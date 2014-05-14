<?php

require __DIR__ . '/vendor/autoload.php';

$results = array(
    'twig'   => array(),
    'smarty' => array()
);

$data = json_decode(file_get_contents(__DIR__ . '/data.json'), true);

$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates/twig');
$twig = new Twig_Environment($loader, array(
    'cache'       => __DIR__ . '/cache/twig',
    'autoescape'  => false,
    'auto_reload' => false,
));

$result = $twig->render('echo.twig', $data);
$result = $twig->render('foreach.twig', $data);

$start = microtime(true);
for ($i = 0; $i < 100; $i++) {
    $result = $twig->render('echo.twig', $data);
}
$end = microtime(true) - $start;
$results['twig']['echo'] = $end;

$start = microtime(true);
for ($i = 0; $i < 100; $i++) {
    $result = $twig->render('foreach.twig', $data);
}
$end = microtime(true) - $start;
$results['twig']['foreach'] = $end;

$smarty = new Smarty();
$smarty->compile_check = false;
$smarty->setTemplateDir(__DIR__ . '/templates/smarty');
$smarty->setCacheDir(__DIR__ . '/cache/smarty');
$smarty->setCompileDir(__DIR__ . '/cache/smarty');

$start = microtime(true);
for ($i = 0; $i < 100; $i++) {
    $smarty->assign($data);
    $result = $smarty->fetch('echo.tpl');
}
$end = microtime(true) - $start;
$results['smarty']['echo'] = $end;

$start = microtime(true);
for ($i = 0; $i < 100; $i++) {
    $smarty->assign($data);
    $result = $smarty->fetch('foreach.tpl');
}
$end = microtime(true) - $start;
$results['smarty']['foreach'] = $end;

foreach ($results as $engine => $r) {
    foreach ($r as $name => $time) {
        echo "[$engine]: $name - " . ($time / 100) . "\n";
    }
}
