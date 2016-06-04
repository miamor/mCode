<?
	// set page headers
//	$page_title = "Read Products";
//	$page_title = $game->title;
	include_once "pages/views/_temp/header.php";
//	include_once "pages/views/_temp/create/header.php";

	include_once 'pages/views/_temp/create/view.php';

	$config->addJS('plugins', 'ace/src/ace.js');
//	$config->addJS('plugins', 'ace/src/ext-language_tools.js');
	$config->addJS('dist', 'beautify.js');
	$config->addJS('dist', 'create/view.js');

	include 'pages/views/_temp/footer.php';
