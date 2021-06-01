<?php

// this contains the application parameters that can be maintained via GUI
return array(
    'title' => 'OPD Systems',
    'adminEmail' => 'alpeshspce20@gmail.com',
    'orderEmail' => 'noreply@radheclinic.com',
    'contactEmail' => 'info@radheclinic.com',
    'telephone' => '08456800561',
    'fax' => '02081816361',
    'copyrightInfo' => 'Copyright Ltd.',
    'companyAddress'=>"Radhe Clinic,\nSanjay Shah,\nMD",
    "ADMIN_BT_URL" => $ADMIN_BT_URL,
    "defaultPageSize" => 25,
    "dateFormatJS" => "dd/mm/yy",
    "timeFormatJS"=>'h:i A',
    "dateFormatPHP" => "d/m/Y",
    "dateTimeFormatPHP" => "d/m/Y h:i:s",
    "timeFormatPHP" => "g:i A",
    'allowedImages'=>array('jpg,gif,png'),
    "paths"=>include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'paths.php')
);
