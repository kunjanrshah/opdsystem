<?php
require(dirname(__FILE__) . '/constants.php');
$HOST_NAME = 'localhost';
return array(
 'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
 'name'=>'My Console Application',
 'components'=>array(
    'db' => array(
        'connectionString' => 'mysql:host=' . $HOST_NAME . ';dbname=' . $DB_NAME,
        'emulatePrepare' => true,
        'enableProfiling' => true,
        'username' => $DB_USERNAME,
        'password' => $DB_PASSWORD,
        'charset' => 'utf8',
    ),
 )
);