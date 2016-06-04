<? $rows = $rows2 = array();
if ($game->page == 'appearance')
	$rows = array(
		'theme'		=> 'Theme',
		'stylesheet'		=> 'Colors &amp; CSS stylesheets',
//		'pics' 		=> 'Colors &amp; Pics management',
		'templates' 		=> 'Templates',
		'javascript' 		=> 'Javascript'
	);
else if ($game->page == 'general')
	$rows = array(
		'info' 			=> 'Update info',
		'avacover'		=> 'Avatar and cover',
		'permissions'	=> 'Permissions'
	);
else if ($game->page == 'users') {
	$rows = array(
		'users' 		=> 'Users managements',
		'special' 		=> 'Special users',
		'ban' 			=> 'Ban control',
	);
	$rowDevide = 'Groups';
	$rows2 = array(
		'groups' 		=> 'Groups managements',
	);
} else if ($game->page == 'boxes') $rows = $boxesArs;
else if ($game->page == 'widget')
	$rows = array(
		'widget'		=> 'Widget management'
	);
else if ($game->page == 'feedback')
	$rows = array(
		'messages' 	=> 'Messages',
		'reports' 		=> 'Reports'
	);
else if ($game->page == 'statistics' || $game->page == 'social') {
	$rows = array(
		'advanced' 	=> 'Statistics',
		'statistics'		=> 'Statistics',
	);
	$rowDevide = 'Social';
	$rows2 = array(
		'facebook' 		=> 'Facebook',
		'google'		=> 'Google'
	);
} else if ($game->page == 'credits') {
	$rows = array(
		'credits'		=> 'Credits system',
		'credits_donation' 		=> 'Credits donation'
	);
	$rowDevide = 'Medals';
	$rows2 = array(
		'medals'		=> 'Medals',
		'awards' 		=> 'Awards'
	);
} else if ($game->page == 'lang') {
	$rows = $boxesArs;
	$rows['general'] = 'General';
} ?>
<div class="manage-one-big-section" id="<? echo $game->page ?>">
	<div class="abox-content">
	<? foreach ($rows as $roK => $roN) { ?>
		<div class="abox-one-row one-section <? if ($b == $roK) echo 'active' ?>">
			<b><? if ($game->page == 'boxes' || $game->page == 'lang') echo 'Boxes';
			else if ($game->page == 'statistics') {
				if ($roK == 'statistics') echo 'Pushme';
				else if ($roK == 'advanced') echo 'Advanced';
			} ?></b>
			<a href="<? echo $game->rootLink ?>/admincp/<? if ($game->page == 'lang') { if ($roK == 'general') echo $game->page.'&l='.$roK; else echo $game->page.'/box&l='.$roK; } else echo $game->page.'/'.$roK ?>"> <? echo ucfirst($roN) ?></a>
		</div>
	<? } ?>
	</div>
<? if ($rows2) { ?>
	<div class="abox-content txt-with-line ahead"><span class="txt static" style="background:#f9f9f9"><? echo $rowDevide ?></span></div>
	<div class="abox-content">
	<? foreach ($rows2 as $roK => $roN) { ?>
		<div class="abox-one-row one-section <? if ($b == $roK) echo 'active' ?>">
			<a href="<? echo $game->rootLink ?>/admincp/<? echo $game->page.'/'.$roK ?>"> <? echo ucfirst($roN) ?></a>
		</div>
	<? } ?>
	</div>
<? } ?>
</div>
