<? $config->addJS('dist', 'main.js');
$config->addJS('plugins', 'sceditor/minified/jquery.sceditor.bbcode.min.js'); ?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>mGame</title>

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
    <link rel="stylesheet" href="<? echo MAIN_URL ?>/assets/dist/css/style.min.css">
    <link rel="stylesheet" href="<? echo MAIN_URL ?>/assets/dist/css/custom.css">

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

    <!-- container -->
    <div class="container main-container">
		<div class="page-header">
			<div class="header-links right">
				<a href="<? echo $config->pLink ?>">Create</a> | 
				<a href="<? echo $config->aLink ?>">Games list</a> | 
				<a href="<? echo $config->aLink ?>">About</a>
			</div>
			<h1><a href="<? echo MAIN_URL ?>">mGame</a></h1>
		</div>
		<div class="page-main">
