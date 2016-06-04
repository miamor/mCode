<?
$gid = 1;

$_rGame = MAIN_PATH.'/game/'.$gid;

$file = $_rGame.'/data.php';

$js = '';

$objects = $data['objects'];

foreach ($objects as $__k => $__ob) {
	if ($__k == 'groups') {
		foreach ($objects[$__k] as $obK=> $ob) {
			$js .= "{$obK} = game.add.group(); \n";
			foreach ($ob as $property => $value) {
				if ($property == 'enableBody') $js .= "{$obK}.enableBody = {$value} \n";
			}
		}
	} else if ()
}


echo $js.'~~~~';
