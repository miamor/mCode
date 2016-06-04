<?php
class Game extends Config {

	// database connection and table name
//	private $conn;
	private $table_name = "games";

	// object properties
	public $id;
	public $title;
	public $code;
	public $content;
	public $cid;
	public $uid;
	public $input;
	public $output;
	public $score;
	public $time_limit;
	public $memory_limit;
	public $tests;
	public $views;
	public $submissions;
	public $mySubmitCount;
	public $author;
	public $sid;
	public $topSubmissions;

	public function __construct() {
		$this->rootLink = '';
		$this->page = (isset($this->pageAr[2])) ? $this->pageAr[2] : '';
		parent::__construct();
	}

	// create product
	function create() {

		// to get time-stamp for 'created' field
		parent::getTimestamp();

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

	function readAll($page, $from_record_num, $records_per_page) {

		$query = "SELECT
					*
				FROM
					" . $this->table_name . "
				ORDER BY
					modified DESC, created DESC
				LIMIT
					{$from_record_num}, {$records_per_page}";

		$stmt = $this->conn->prepare( $query );
		$stmt->execute();

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$row['author'] = $this->getUserInfo($row['uid']);
			$row['scoreTxtCorlor'] = '';
			if ($row['score'] >= 80) $row['scoreTxtCorlor'] = 'success';
			else if ($row['score'] >= 50) $row['scoreTxtCorlor'] = 'warning';
			$this->problemsList[] = $row;
		}

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

	function readOne() {
		$query = "SELECT
					*
				FROM
					" . $this->table_name . "
				WHERE
					id = ? OR code = ?
				LIMIT
					0,1";

		$stmt = $this->conn->prepare( $query );
		$stmt->bindParam(1, $this->id);
		$stmt->bindParam(2, $this->id);
//		$stmt->bindParam(2, $this->code);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		$this->id = $row['id'];
		$this->title = $row['title'];
		$this->code = $row['code'];
		$this->content = $row['content'];
		$this->cid = $row['cid'];
		$this->input = $row['input'];
		$this->output = $row['output'];
		$this->score = $row['score'];
		$this->time_limit = $row['time_limit'];
		$this->memory_limit = $row['memory_limit'];
		$this->tests = $row['tests'];
		$this->views = $row['views'];
		$this->submissions = $row['submissions'];
		$this->uid = $row['uid'];
		
		$this->author = $row['author'] = $this->getUserInfo($this->uid);
		$this->mySubmitCount = $row['mySubmitCount'] = $this->checkMySubmissions();

		$this->topSubmissions();

		$queryr = "SELECT * FROM " . $this->table_name . "_ratings WHERE iid = ?";

		$stmtr = $this->conn->prepare( $queryr );
		$stmtr->bindParam(1, $this->id);
		$stmtr->execute();

		$stars = $totalRates = 0;
		while ($ro = $stmtr->fetch(PDO::FETCH_ASSOC)) {
			$stars += $ro['rate'];
			$totalRates++;
		}
		$rates = $stars/$totalRates;
		$this->ratings = number_format((float)$rates, 1, '.', '');

		return $row;
	}
	
	function update() {

		$query = "UPDATE
					" . $this->table_name . "
				SET
					name = :name,
					price = :price,
					description = :description,
					category_id  = :category_id
				WHERE
					id = :id";

		$stmt = $this->conn->prepare($query);

		// posted values
		$this->name=htmlspecialchars(strip_tags($this->name));
		$this->price=htmlspecialchars(strip_tags($this->price));
		$this->description=htmlspecialchars(strip_tags($this->description));
		$this->category_id=htmlspecialchars(strip_tags($this->category_id));
		$this->id=htmlspecialchars(strip_tags($this->id));

		// bind parameters
		$stmt->bindParam(':name', $this->name);
		$stmt->bindParam(':price', $this->price);
		$stmt->bindParam(':description', $this->description);
		$stmt->bindParam(':category_id', $this->category_id);
		$stmt->bindParam(':id', $this->id);

		// execute the query
		if($stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

	// delete the product
	function delete() {

		$query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
		
		$stmt = $this->conn->prepare($query);
		$stmt->bindParam(1, $this->id);

		if($result = $stmt->execute()){
			return true;
		}else{
			return false;
		}
	}

}
?>
