<?php
header("Content-Type:text/html;charset=utf-8");

//转换硬路径常量
define('ROOT_PATH', substr(dirname(__FILE__), 0,-8));

//拒绝php低版本
if(PHP_VERSION < '5.1.0'){
    exit('PHP版本太低');
}


//引入核心函数库
require  ROOT_PATH.'includes/global_func.php';
require  ROOT_PATH.'includes/mysql_func.php';

//执行耗时

$_start_time = runtime();


	_connect();//连接
	_select_db();//选择数据库
	_set_names();//设置字符集
	

?>
