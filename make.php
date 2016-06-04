<?
include_once('config/config.php');

$gid = 1;

$_rGame = MAIN_PATH.'/game/'.$gid;

$file = $_rGame.'/data.php';

include_once($file);

$jsAr = $varsAr = $preloadAr = $createAr = $updateAr = $renderAr = array();

$evtSheets = '';

$game = $data['game'];
$objects = $data['objects'];
$groups = $data['groups'];
$evts = $data['events'];

$js = " 	var game = new Phaser.Game({$game['width']}, {$game['height']}, Phaser.AUTO, 'phaser-example', { preload: preload, create: create, update: update, render: render }); \n";

foreach ($objects as $__obCat => $__obs) {
	foreach ($__obs as $__obID => $__obSettings) {
		if ($__obCat == 'variables' && isset($__obSettings)) $varsAr[] = " 	var {$__obID} = {$__obSettings}; \n";
		else $varsAr[] = " 	var {$__obID}; \n";
		if ($__obCat == 'cursor') 
			$createAr[] = " 	cursors = game.input.keyboard.createCursorKeys(); \n";
		else if ($__obCat == 'sprites') {
			if (isset($__obSettings['spritesheet_name'])) {
				$preloadAr[] = " 	game.load.spritesheet('{$__obSettings['spritesheet_name']}', '{$__obSettings['asset']}', '{$__obSettings['width']}', '{$__obSettings['height']}'); \n";
				if (isset($__obSettings['animations'])) {
					foreach ($__obSettings['animations'] as $aID => $aSettings) {
						$createAr[] = " 	{$__obID}.animations.add('{$aID}', {$aSettings['frames']}, {$aSettings['fps']}, {$aSettings['loop']}); \n";
					}
				}
			} else $preloadAr[] = " 	game.load.image('{$__obID}'); \n";
		} else if ($__obCat == 'tilesmap') {
			$preloadAr[] = " 	game.load.tilemap('{$__obID}', '{$__obSettings['asset']}', null, Phaser.Tilemap.TILED_JSON); \n";
			$createAr[] = " 	{$__obID} = game.add.tilemap('{$__obID}'); \n";
		} else if ($__obCat == 'text') {
			$createAr[] = " 	{$__obID} = game.add.text({$__obSettings['pos']['x']}, {$__obSettings['pos']['y']}, '{$__obSettings['text']}', { fontSize: '{$__obSettings['fontsize']}px', fill: '{$__obSettings['color']}' }); \n";
		} else if ($__obCat == 'layers') {
			$createAr[] = " 	{$__obID} = {$__obSettings['pid']}.createLayer('{$__obSettings['name']}'); \n";
		}
	}
/*	if ($__obCat == 'cursor') 
		$createAr[] = " 	cursors = game.input.keyboard.createCursorKeys(); \n";
	else if ($__obCat == 'sprites') {
		foreach ($__obs as $__obID => $__obSettings) {
			if (isset($__obSettings['spritesheet_name'])) {
				$preloadAr[] = " 	game.load.spritesheet('{$__obSettings['spritesheet_name']}', '{$__obSettings['asset']}', '{$__obSettings['width']}', '{$__obSettings['height']}'); \n";
			} else $preloadAr[] = " 	game.load.image('{$__obID}'); \n";
		}
	} else if ($__obCat == 'tilesmap') {
		foreach ($__obs as $__obID => $__obSettings) {
			$preloadAr[] = " 	game.load.tilemap('{$__obID}', '{$__obSettings['asset']}', null, Phaser.Tilemap.TILED_JSON); \n";
		}
	} */
}
foreach ($groups as $__grID => $__grSettings) {
	$createAr[] = " 	{$__grID} = game.add.group(); \n";
	foreach ($__grSettings as $property => $value) {
		if ($property == 'enableBody') $createAr[] = " 	{$__grID}.enableBody = {$value}; \n";
	}
}

foreach ($evts as $__evCat => $__evs) {
	if ($__evCat == 'system') { // get events of system
		foreach ($__evs as $__evID => $__evSettings) {
			if ($__evID == 'setPhysics') {
				$createAr[] = " 	game.physics.startSystem(Phaser.Physics.{$__evSettings}); \n";
			}
		}
	} else if ($__evCat == 'objects') { // get events of object
		foreach ($__evs as $__ObCat => $__evOb) {
			foreach ($__evOb as $__obID => $__evSettings) {
				if ($__ObCat == 'sprites') {
//					echo $__obID.'~';
//					print_r($__evSettings);
					if (isset($__evSettings['enablePhysics'])) $createAr[] = " 	game.physics.enable({$__obID}); \n";
				}
			}
		}
	}
}

$vars = implode("\n", $varsAr);
$preload = implode("\n", $preloadAr);
$create = implode("\n", $createAr);
$update = implode("\n", $updateAr);
$render = implode("\n", $renderAr);

$all = array_merge($varsAr, $preloadAr, $createAr, $updateAr, $renderAr);

$js .= " 	
{$vars}

function preload () {
{$preload}
}

function create () {
{$create}
}

function update () {
{$update}
}

function render () {
{$render}
}

";

//print_r($data);

echo $js;

//echo json_encode($all);
