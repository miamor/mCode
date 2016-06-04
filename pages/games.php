<?
// include object files
include_once 'objects/problem.php';
include_once 'objects/submission.php';

// prepare product object
$problem = new Problem();

// get ID of the product to be edited
//$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
$id = isset($n) ? $n : '';


if (isset($id) && $id && $id != 'new') {
	$sid = ($config->get('sid') != null) ? $config->get('sid') : null;

	// set ID property of product
	$problem->id = $id;

	// read the details of product
	$problemView = $problem->readOne();
	//extract($problemView);

	// Reset $id to ID property of product
	$id = $problem->id;

	$mySubmit = new Submission();
}

if ($do) include 'system/problems/'.$do.'.php';
else {
	if (!isset($id) || !$id) include 'views/problems/list.php';
	else if ($id == 'new') include 'views/problems/new.php';
	else include 'views/problems/view.php';
}
