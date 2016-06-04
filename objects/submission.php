<?php
class Submission extends Problem {

	// database connection and table name
//	private $conn;
	private $table_name = "submissions";
	public $id;
	public $uid;
	public $iid;
	public $sid;
	public $file;
	public $compile_stt;
	public $_dir;
	public $_udir;
	public $codeContent;

	public function __construct() {
		parent::__construct();
	}

	public function newFile ($u = '') {
		if (!$u) $u = $this->u;
		$this->_dir = $_dir = $this->codeDir.'/p'.$this->iid;
		$this->_udir = $_udir = $this->_dir.'/u'.$u;
		$_fLang = $this->_fLang;
		$_fdir = $this->_udir.'/'.$this->_fLang;
		$_fNum = $this->_fNum;
		
		if (!is_dir($_fdir)) mkdir($_fdir, 0777);
		exec('chmod -R 777 '.$_fdir);

		$_fNum = $this->getFilesNum($_fdir, $_fLang);

		$_fdir = $_udir.'/'.$_fLang;
		$_file = $_fdir.'/'.$_fNum.'.'.$_fLang;
		$_fileFormat = $_dir.'/u'.$u.'.'.$_fNum.'.'.$_fLang;

		$handle = fopen($_file, 'w') or die('Cannot open file:  '.$_file); 
		fwrite($handle, '');

		return $_fNum;
	}

	function readAllMy ($from_record_num, $records_per_page) {
		$query = "SELECT
					*
				FROM
					" . $this->table_name . "
				WHERE 
					iid = ? AND uid = ?
				ORDER BY
					modified DESC, created DESC
				LIMIT
					{$from_record_num}, {$records_per_page}";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->iid);
		$stmt->bindParam(2, $this->u);
		$stmt->execute();
		
		return $stmt;
	}
	
	function readAll ($u, $from_record_num, $records_per_page) {
		$this->uid = $u;
		$query = "SELECT
					*
				FROM
					" . $this->table_name . "
				WHERE 
					iid = ? AND uid = ?
				ORDER BY
					modified DESC, created DESC
				LIMIT
					{$from_record_num}, {$records_per_page}";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->iid);
		$stmt->bindParam(2, $this->uid);
		$stmt->execute();

		return $stmt;
	}
	
	// used for paging products
	public function countAll(){

		$query = "SELECT id FROM " . $this->table_name . "";

		$stmt = $this->conn->prepare( $query );
		$stmt->execute();

		$num = $stmt->rowCount();

		return $num;
	}

	public function readOne() {
		$query = "SELECT
					*
				FROM
					" . $this->table_name . "
				WHERE
					id = ?
				LIMIT
					0,1";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->id);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$row['author'] = $this->getUserInfo($row['uid']);
		$this->id = $row['id'];
		$this->file = $row['file'];
		$tdir = explode('/u', $this->file)[0].'/tests';
		$row['tests'] = count(array_diff(scandir($tdir), array('..', '.')));
		$row['compile_details'] = explode('|', $row['compile_details']);
		if ($row['similar']) {
			$similar = explode('|', $row['similar']);
			if (count($similar) > 0) {
				foreach ($similar as $sk => $simi) {
					if ($simi) {
						$simiAr = explode('::', $simi);
						$siu = preg_match('/u(.*)./', $simiAr[0]);
						$similar[$sk] = 
							array(
								'u' 	=> $siu,
								'file' => $simiAr[0],
								'per' => $simiAr[1]
							);
					}
				}
				$row['similar'] = $similar;
			}
		}
		
		$this->getCodeContent();
//		$this->codeContent = preg_replace('/\n/', '  ', $this->codeContent);
		$row['codeContent'] = preg_replace("/<br[^>]*>\s*\r*\n*/is", "\n", htmlentities($this->codeContent));

		$this->data = $row;
	}

	public function listFiles ($u = '') {
		if (!$u) $u = $this->u;
		$this->_dir = $_dir = $this->codeDir.'/p'.$this->iid;
		$this->_udir = $_udir = $this->_dir.'/u'.$u;
	//	$supported = array('cpp', 'c', 'java', '27.py', '32.py');
		$supported = array('cpp', 'c', 'java', 'py');
		$myCodeFile = array();
		foreach ($supported as $ext) {
			$ext = end(explode('.', $ext));
			$dirf = $_udir.'/'.$ext;
			if (is_dir($dirf)) {
				$filesAr = $this->getFiles($dirf, $ext, true);
				if (count($filesAr) > 0) $myCodeFile = array_merge($myCodeFile, $filesAr);
			}
		}
		return array_reverse($myCodeFile);
	}
	
	public function checkSubmit ($file) {
		if (!$file) $file = $this->_file;
		$fullFilePath = MAIN_PATH.str_replace('./', '/', $file);
		$query = "SELECT id FROM submissions WHERE file = ? LIMIT 0,1";
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $fullFilePath);
		$stmt->execute();
		$num = $stmt->rowCount();
		return $num;
	}

	function create () {
		// to get time-stamp for 'created' field
		$this->getTimestamp();

		//write query
		$query = "INSERT INTO
					" . $this->table_name . "
				SET
					title = ?, code = ?, content = ?, cid = ?, uid = ?, 
					input = ?, output = ?, score = ?, time_limit = ?, memory_limit = ?, tests = ?, 
					created = ?";

		$stmt = $this->conn->prepare($query);

		// posted values
		$this->title=htmlspecialchars(strip_tags($this->title));
		$this->code=htmlspecialchars(strip_tags($this->code));
		$this->content=htmlspecialchars(strip_tags($this->content));
		$this->cid=htmlspecialchars(strip_tags($this->cid));
		$this->input=htmlspecialchars(strip_tags($this->input));
		$this->output=htmlspecialchars(strip_tags($this->output));
		$this->score=htmlspecialchars(strip_tags($this->score));
		$this->time_limit=htmlspecialchars(strip_tags($this->time_limit));
		$this->memory_limit=htmlspecialchars(strip_tags($this->memory_limit));
		$this->tests=htmlspecialchars(strip_tags($this->tests));
		$this->timestamp=htmlspecialchars(strip_tags($this->timestamp));

		// bind values
		$stmt->bindParam(1, $this->title);
		$stmt->bindParam(2, $this->code);
		$stmt->bindParam(3, $this->content);
		$stmt->bindParam(4, $this->cid);
		$stmt->bindParam(5, $this->input);
		$stmt->bindParam(6, $this->output);
		$stmt->bindParam(7, $this->score);
		$stmt->bindParam(8, $this->time_limit);
		$stmt->bindParam(9, $this->memory_limit);
		$stmt->bindParam(10, $this->tests);
		$stmt->bindParam(11, $this->timestamp);

		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	function getCodeContent ($file = '') {
		$this->ext = $this->mode = end(explode('.', $this->file));
		if ($this->ext == 'cpp') $this->mode = 'c_cpp';
		if (is_file($this->file)) $this->codeContent = file_get_contents($this->file);
		return $this->codeContent;
	}

}
?>
