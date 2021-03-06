<?php
$PRODUCT_NAME = "OPD System";
$production = file_exists(dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . "production");
$development = file_exists(dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . "development");
$qa = file_exists(dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . "qa");

$HTTP_HOST = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';

if ($production) {
    $WEB_URL = 'http://' . $HTTP_HOST . '/opdsystem/';
    $DOCUMENT_PATH = $_SERVER['DOCUMENT_ROOT'] . '/opdsystem/';
    $DB_USERNAME = "superbi1_opd";
    $DB_PASSWORD = "!61tFE#9WmAG";
    $DB_NAME = "superbi1_opdsystem";
    $HOST_NAME = "localhost";
    $SESSION_NAME = "opdystem_prod";
} else if ($qa) {
    $WEB_URL = 'http://' . $HTTP_HOST . '/opd_uat/';
    $DOCUMENT_PATH = $_SERVER['DOCUMENT_ROOT'] . '/opd_uat/';
    $DB_USERNAME = "superbi1_opd_uat";
    $DB_PASSWORD = "opd_uat";
    $DB_NAME = "superbi1_opd_uat";
    $HOST_NAME = "localhost";
    $SESSION_NAME = "opdystem_qa";
} else {
    $WEB_URL = 'http://' . $HTTP_HOST . '/opdsystem/';
    $DOCUMENT_PATH = $_SERVER['DOCUMENT_ROOT'] . '/opdsystem/';
    $DB_USERNAME = "alpesh";
    $DB_PASSWORD = "alpesh@123";
    $DB_NAME = "opdsystem";
    $HOST_NAME = "localhost";
    $SESSION_NAME = "opdystem_dev";
}
$UPLOADS_PATH = $DOCUMENT_PATH . "uploads/";
$UPLOADS_URL = $WEB_URL . "uploads/";
$ADMIN_BT_URL = $WEB_URL . "admin_bt/";
