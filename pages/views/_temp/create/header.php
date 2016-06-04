<? $config->addJS('dist', 'main.js');
$config->addJS('plugins', 'sceditor/minified/jquery.sceditor.bbcode.min.js'); ?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo $page_title; ?></title>

	<!-- some custom CSS -->
	<style>
	.left-margin{
		margin:0 .5em 0 0;
	}

	.right-button-margin{
		margin: 0 0 1em 0;
		overflow: hidden;
	}
	</style>

    <!-- Bootstrap -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<? echo MAIN_URL ?>/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<? echo MAIN_URL ?>/assets/dist/css/font-awesome.min.css">
    <link rel="stylesheet" href="<? echo MAIN_URL ?>/assets/dist/css/manage.css">

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<? echo MAIN_URL ?>/assets/plugins/jquery/jquery-1.11.0.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <!-- Latest compiled and minified JavaScript -->
    <script src="<? echo MAIN_URL ?>/assets/bootstrap/js/bootstrap.min.js"></script>
	<script>var MAIN_URL = '<? echo MAIN_URL ?>' </script>
</head>
<body>

<div class="acp-menu">
	<a href="<? echo $game->rootLink ?>/admincp/index"><span class="fa fa-dashboard"></span> Dashboard</a>
	<a href="<? echo $game->rootLink ?>/admincp/general"><span class="glyphicon glyphicon-th-list"></span> General</a>
	<a href="<? echo $game->rootLink ?>/admincp/appearance"><span class="fa fa-cog"></span> Apperance</a>
	<a href="<? echo $game->rootLink ?>/admincp/boxes"><span class="fa fa-gift"></span> Boxes</a>
	<a href="<? echo $game->rootLink ?>/admincp/widget"><span class="fa fa-cubes"></span> Widgets</a>
	<a href="<? echo $game->rootLink ?>/admincp/feedback"><span class="fa fa-send"></span> Feedbacks</a>
	<a href="<? echo $game->rootLink ?>/admincp/lang"><span class="fa fa-language"></span> Lang</a>
	<a href="<? echo $game->rootLink ?>/admincp/users"><span class="fa fa-language"></span> Users &amp; groups</a>
	<a href="<? echo $game->rootLink ?>/admincp/credits"><span class="fa fa-bar-chart-o"></span> Medals &amp; credits</a>
	<a href="<? echo $game->rootLink ?>/admincp/statistics"><span class="fa fa-bar-chart-o"></span> Social &amp; Statistics</a>
	<a href="<? echo $game->rootLink ?>/admincp/upgrade"><span class="fa fa-cloud-upload"></span> Upgrade</a>
	<div class="right">
		<span class="gensmall">Log in as:</span> <a href="<? echo $uLink ?>"><? //echo $member['name'] ?></a>
	</div>
</div>

<div class="manage-wrapper <? if (!$a || $a == 'index') echo 'col-lg-9' ?> no-margin"><div class="manage-content">
