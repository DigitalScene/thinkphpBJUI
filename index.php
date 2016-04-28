<?php
/**
 * Created by PhpStorm.
 * User: yang
 * Date: 2016/4/20
 * Time: 11:19
 */
//检测PHP环境
//if(version_compare(PHP_VERSION,'5.3.0','>'))
//    die('require PHP<5.3.0!');

//开启调试模式，建议开发阶段开启，部署阶段注释或者设为false
define('APP_DEBUG',TRUE);

define('APP_NAME','Admin');

//定义应用目录
define('APP_PATH','./APP/Admin/');

//定义站点根目录
define("WEB_ROOT",dirname(__FILE__)."/");

//系统缓存路径
define('WEB_CACHE_PATH','/App/');

//系统备份数据库文件存放目录
define("DatabaseBackDir",WEB_ROOT.'App/'.'Databases/');

//引入ThinkPHP3.1.3入口文件
require './ThinkPHP/ThinkPHP.php';