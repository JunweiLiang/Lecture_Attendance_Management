<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/protected/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

//设置时区
date_default_timezone_set("America/New_York");


define("COLOR1_LIGHTER1","rgb(0,128,192)");
define("COLOR1_LIGHTER2","rgb(105,196,211)");
define("COLOR1_LIGHTER2_MORE","rgb(105,196,231)");
define("COLORDARKER","rgb(225,225,225)");
define("COLORDARK","rgb(235,235,235)");
define("COLORDARKERER","rgb(215,215,215)");
define("COLOR1_LIGHTER3","rgb(219, 255, 237)");
define("COLOR1_LIGHTER3_DARK","rgb(178, 255, 200)");


//设置ID混淆
defined("IDADDUP") or define("IDADDUP",12345);

// for logggin
define("USER_CHANGENICKNAME",26);
define("USER_CHANGEPW",29);

session_name("lecture");

require_once($yii);
session_start();

Yii::createWebApplication($config)->run();
?>
