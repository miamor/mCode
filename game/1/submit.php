<?
	include 'quest.php';

	$answer = isset($_POST['answer']) ? $_POST['answer'] : '';
	$q = isset($_POST['q']) ? $_POST['q'] : '';
	$quest = $questAr[$q];
	$ans = $quest['answer'];

	if ($answer == $ans) $correct = 1;
	else $correct = 0;
	
	echo $correct;
