<?php
$__pattern = '/mgame';

define('MAIN_PATH', './');
define('HOST_URL', '//localhost'.$__pattern);
define('MAIN_URL', 'http:'.HOST_URL);
define('ASSETS', MAIN_URL.'/assets');
define('GG_API_KEY', 'AIzaSyA5xbqBF1tGx96z6-QLhGGmvqIQ5LUrt4s');
define('GG_CX_ID', '014962602028620469778:yf4br-mf6mk');
$__page = str_replace($__pattern.'/', '', $_SERVER['REQUEST_URI']);

class Config {

	// specify your own database credentials
	private $host = "localhost";
	private $db_name = "mcode";
	private $username = "root";
	private $password = "";
	protected $conn;
	protected $uLink;
	public $u;
	public $request;
	public $JS;

	public function __construct () {
		$this->pLink = MAIN_URL.'/p';
		$this->uLink = MAIN_URL.'/u';
		$this->aLink = MAIN_URL.'/about';
		$this->codeDir = MAIN_PATH.'data/code';
		$this->u = 1;
		$this->JS = '';
		return $this->getConnection();
	}

	// get the database connection
	public function getConnection() {

		$this->conn = null;

		try {
			$this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
			$this->conn->exec("set names utf8");
		} catch (PDOException $exception) {
			echo "Connection error: " . $exception->getMessage();
		}

		return $this->conn;
	}

	// used for the 'created' field when creating a product
	function getTimestamp(){
		date_default_timezone_set('Asia/Manila');
		$this->timestamp = date('Y-m-d H:i:s');
	}

	public function getUserInfo ($u = '', $fields = '') {
		if (!$u) $u = $this->u;
		$defaultFields = 'avatar,username,first_name,last_name,online,rank';
		if (!$fields) $fields = $defaultFields;
		else $fields .= ','.$defaultFields;
		$query = "SELECT
					{$fields}
				FROM
					members
				WHERE
					id = ?
				LIMIT
					0,1";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $u);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$row['name'] = $row['first_name'].' '.$row['last_name'];
		$row['link'] = $this->uLink.'/'.$row['username'];
		return $row;
	}
	
	function get ($char) {
		$request = $this->request;
		if ($request && check($request, $char) > 0) {
			$c = explode($char.'=', $request)[1];
			$c = explode('&', $c)[0];
			$request = str_replace("{$char}={$c}&", "", $request);
			return $c;
		}
		return null;
	}

	function getFilesNum ($_udir, $_fLang) {
		$_files = $this->getFiles($_udir, $_fLang);
		$_fNum = count($_files);
		return $_fNum;
	}
	function getFiles ($_udir, $_fLang, $checkSubmit = false) {
		if (is_dir($_udir)) {
			$_files = scandir($_udir);
			foreach ($_files as $_k => $_fileo) {
				$_fileO = $_udir.'/'.$_fileo;
				$_fOext = end(explode('.', $_fileO));
				if (!is_file($_fileO) || $_fOext != $_fLang) unset($_files[$_k]);
				else {
					$fullFilePath = MAIN_PATH.str_replace('./', '/', $_fileO);
					$_fOmode = $_fOext;
					if ($_fOext) $_fOmode = 'c_cpp';
					if ($checkSubmit == false)
						$_files[$_k] = 
							array(
								'dir' => $_udir.'/'.$_fileo, 
								'u' => preg_match('/(?<=u)(.*)(?=\/)/', $_udir), 
								'filename' => explode('.', $_fileo)[0], 
								'ext' => $_fOext, 
								'mode' => $_fOmode
							);
					else {
						$query = "SELECT id FROM submissions WHERE file = ? LIMIT 0,1";
						$stmt = $this->conn->prepare($query);
						$stmt->bindParam(1, $fullFilePath);
						$stmt->execute();
						$num = $stmt->rowCount();
						$_files[$_k] = 
							array(
								'dir' => $_udir.'/'.$_fileo, 
								'u' => preg_match('/(?<=u)(.*)(?=\/)/', $_udir), 
								'filename' => explode('.', $_fileo)[0], 
								'submit' => $num, 
								'ext' => $_fOext, 
								'mode' => $_fOmode
							);
					}
				}
			}
			return array_values($_files);
		} 
		return null;
	}
	
	function addJS ($type, $link) {
		if ($type == 'dist') $type = 'dist/js';
		$this->JS .= ASSETS.'/'.$type.'/'.$link.'|';
	}
	
	function echoJS () {
		$exJS = explode('|', $this->JS);
		foreach ($exJS as $exjs)
			echo '<script src="'.$exjs.'"></script>';
	}

}

function checkInternet ($sCheckHost = 'www.google.com')  {
    $connected = @fsockopen($sCheckHost, 80); 
    return (bool) $connected;
}

	function ggsearch ($query, $cx) {
		$key = GG_API_KEY;
		$cx = urlencode($cx);
		$query = urlencode($query);
		$url = "https://www.googleapis.com/customsearch/v1?cx={$cx}&key={$key}&q={$query}";
//		echo $url;
		$google_search = file_get_contents($url);
		return ($google_search);
	}

	function check ($haystack, $needle) {
	//	return strlen(strstr($string, $word)); // Find $word in $string
		return substr_count($haystack, $needle); // Find $word in $string
	}

	function checkURL ($word) {
		return check($_SERVER['REQUEST_URI'], $word);
	}

	function strip_comments ($str) {
		$str = preg_replace('!/\*.*?\*/!s', '', $str);
		$str = preg_replace('/\n\s*\n/', "\n", $str);
		$str = preg_replace('![ \t]*//.*[ \t]*[\r\n]!', '', $str);
		return $str;
	}

function str_insert_after ($str, $search, $insert) {
    $index = strpos($str, $search);
    if ($index === false) {
        return $str;
    }
    return substr_replace($str, $search.$insert, $index, strlen($search));
}

function str_insert_before ($str, $search, $insert) {
    $index = strpos($str, $search);
    if ($index === false) {
        return $str;
    }
    return substr_replace($str, $insert.$search, $index, strlen($search));
}

?>
