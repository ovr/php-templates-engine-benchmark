<?php
header('content-type: text/plain; charset=utf-8');
$data = json_decode(file_get_contents('data.json'), true);

require('smarty/Smarty.class.php');
$smarty = new Smarty();
$smarty->compile_check = false;

$start = microtime(true);
$smarty->assign($data);
$smarty->fetch('demo.tpl');
echo(microtime(true)-$start);
