<?php
header('content-type: text/plain; charset=utf-8');
$data = json_decode(file_get_contents('data.json'), true);

require('twig/Autoloader.php');
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader, array(
	'cache' => 'templates_c',
	'autoescape' => false, 
	'auto_reload' => false,
));

$start = microtime(true);
$template = $twig->loadTemplate('b100.tpl');
$template->render($data);
echo microtime(true)-$start;
