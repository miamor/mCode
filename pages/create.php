<?
// include object files
include_once 'objects/game.php';

// prepare product object
$game = new Game();

// get ID of the product to be edited
//$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
$id = isset($n) ? $n : '';


if ($do) include 'system/create/'.$do.'.php';
else include 'views/create/view.php';
