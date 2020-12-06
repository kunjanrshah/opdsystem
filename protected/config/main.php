<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'constants.php');
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => $PRODUCT_NAME,
    'timeZone' => 'Asia/Kolkata', // Add timeZone as per your time(Add this for live server issue)
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.vendors.*',
        'application.helpers.*',
        'ext.yii-mail.YiiMailMessage'
    ),
    'defaultController' => 'home',
    'modules' => array(
        // uncomment the following to enable the Gii tool		    
        'admin' => array(
            'defaultController' => 'login',
        ),
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'mano',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
    ),
    // application components
    'components' => array( 
        'messages' => array(
            'language' => 'en'
        ),
        'user' => array(
            'class' => 'CWebUser',
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        'image' => array(
            'class' => 'application.extensions.image.CImageComponent',
            'driver' => 'GD', // GD or ImageMagick            
            'params' => array('directory' => '/opt/local/bin'), // ImageMagick setup path
        ),
        // uncomment the following to use a MySQL database		
        'db' => include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'database.php'),
        'mail' => array(
            'class' => 'ext.yii-mail.YiiMail',
            'transportType' => 'smtp', //php
            'transportOptions' => array(
                'host' => 'smtp.ukservers.net',
                'username' => 'donotreply@omsaipharma.co.uk',
                'password' => 'pharma55$',
                'port' => '465',
                'encryption' => 'tls',
            ),
            'logging' => true,
            'dryRun' => false
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'admin/error/index',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'appendParams' => false,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<module>/<controller:\w+>/<id:\d+>' => '<module>/<controller>/view',
                '<module>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
                '<module>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            ),
        ),
        'widgetFactory' => include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'widgetFactory.php'),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'params.php')
);
