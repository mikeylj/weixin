<?php
date_default_timezone_set('Asia/Shanghai');

define('APPLICATION_PATH', dirname(__FILE__).'/../'); /* 指向public的上一级 */
define('APP_PATH', dirname(__FILE__).'/../');

if(!extension_loaded("yaf")){
    include(APPLICATION_PATH.'/globals/framework/loader.php');
}
$application = new Yaf_Application(APPLICATION_PATH. "/conf/application.ini");

$application->bootstrap()->run();

