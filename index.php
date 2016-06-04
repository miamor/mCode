<?
header('Content-Type: text/html; charset=utf-8');
// config file
include_once 'config/config.php';
$config = new Config();

// include object files
include_once 'objects/page.php';

if (check($__page, '?') > 0) $__page = $__page.'&';
else $__page = $__page;

$__pageAr = array_filter(explode('/', explode('?', rtrim($__page))[0]));
//$__pageAr = array_filter(explode('/', explode('&', rtrim($__page))[0]));
//print_r($__pageAr);

if ($__pageAr) {
	$page = $__pageAr[0];
	$n = (array_key_exists(1, $__pageAr) && $__pageAr[1] != null) ? $__pageAr[1] : '';
	$requestAr = explode('?', $__page);
//	print_r($requestAr);
//	echo $requestAr[1].'~~~';
	$config->request = isset($requestAr[1]) ? $requestAr[1] : null;
	$config->pageAr = $__pageAr;
} else $__page = 'error';

//$do = isset($_GET['do']) ? $_GET['do'] : null;

$v = ($config->get('v') != null) ? $config->get('v') : '';
$type = ($config->get('type') != null) ? $config->get('type') : '';
$do = ($config->get('do') != null) ? $config->get('do') : '';

if (!isset($page) || !$page) $page = 'p';

if ($page == 'p') $page = 'create';

$allowAr = array('about', 'source', 'error', 'logout');
if (!$page) $page = 'index';

if ($page && !$do) echo '<div class="page-class" id="p-'.$page.'">';

if (!$config->u && !in_array($page, $allowAr)) $page = 'login';
if (!file_exists('pages/'.$page.'.php')) $page = 'error';
if ($page) include 'pages/'.$page.'.php';

 ?>
