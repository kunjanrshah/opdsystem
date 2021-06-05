<?php
require(dirname(__FILE__) . '/constants.php');
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Console Application',
    'components' => array(
        'db' => include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'database.php'),
    )
);
