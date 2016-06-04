<?

$gid = $_POST['gid'];

$_rGame = MAIN_PATH.'/game/'.$gid;
$file = MAIN_PATH.'/game/'.$gid.'/js/game.js';
$code = file_get_contents($file);
$code = explode('function newQuest (id, coin) {', $code)[0];

$_Ar = $subjectsAr = $spritesAr = $animationsAr = array();

$rfile = fopen($file, "r");
while (!feof($rfile)) {
	$line = fgets($rfile);
//	$linee = str_replace(' ', '', $line); 
	$linee = preg_replace('/ |;/', '', $line);
	$matchSubject = preg_match('/^var(.*)/', $linee, $subject);
	$matchSprites = preg_match('/^game.load.(.*)\(\'(.*)\',\'(.*)\'(.*)/', $linee, $sprite);
	$matchAnimations = preg_match('/(.*)animations.add(.*)/', $linee, $animations);

	if ($matchSubject) {
		$sAr = explode('=', $subject[1]);
		$sName = $sAr[0];
		$sVal = (isset($sAr[1])) ? $sAr[1] : '';
		$subjectsAr[] = array('subject' => $sName, 'value' => $sVal);
	} else if ($matchSprites) {
		$sp4 = (isset($sprite[4])) ? substr($sprite[4], 1, -1) : '';
		$spritesAr[] = array('type' => $sprite[1], 'id' => $sprite[2], 'asset' => $sprite[3], 'others' => $sp4);
	} else if ($matchAnimations) {
		$aniName = explode('.', $animations[0])[0];
		preg_match('/\[(.*)\]/', $animations[0], $aniFrame);
		$animationsAr[] = array('sprite' => $aniName, 'frames' => $aniFrame[1]);
	}

}
fclose($rfile);

$_Ar = 
	array(
		'code' => $code,
		'subjects' => $subjectsAr,
		'sprites' => $spritesAr,
		'animations' => $animationsAr,
	);

//print_r($_Ar);

//echo json_encode($_Ar);

include_once $_rGame.'/data.php';

$data['code'] = $code;

echo json_encode($data);

//echo $code;
