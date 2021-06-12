<?php
$production = file_exists("production");

if (!$production) {
    ini_set('display_errors', 1);
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    ini_set('set_time_zone', 'Asia/Kalkata');
}
// change the following paths if necessary
$yii = dirname(__FILE__) . '/yii/framework/yii.php';
$config = dirname(__FILE__) . '/protected/config/main.php';

if (!$production) {
    // remove the following lines when in production mode
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    // specify how many levels of call stack should be shown in each log message
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
}
require_once($yii);
Yii::createWebApplication($config)->run();
