<?php
$PRODUCT_NAME = "OPD System";
$production = file_exists(dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . "production");

if ($production):
    $WEB_URL = 'http://' . $_SERVER['HTTP_HOST'] . '/opdsystem/';
    $DOCUMENT_PATH = $_SERVER['DOCUMENT_ROOT'] . '/opdsystem/';
    $DB_USERNAME = "superbi1_opd";
    $DB_PASSWORD = "!61tFE#9WmAG";
    $DB_NAME = "superbi1_opdsystem";
else:
    $WEB_URL = 'http://' . $_SERVER['HTTP_HOST'] . '/opdsystem/';
    $DOCUMENT_PATH = $_SERVER['DOCUMENT_ROOT'] . '/opdsystem/';
    $DB_USERNAME = "root";
    $DB_PASSWORD = "";
    $DB_NAME = "superzcr_opdsystem";
endif;
$UPLOADS_PATH = $DOCUMENT_PATH . "uploads/";
$UPLOADS_URL = $WEB_URL . "uploads/";
$ADMIN_BT_URL = $WEB_URL . "admin_bt/";
