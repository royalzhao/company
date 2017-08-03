<?php
	//数据库链接
	define('db_host', 'localhost');
	define('db_user', 'root');
	define('db_pwd', 'root');
	define('db_name', 'message');
	
	/*
	 * _connect()连接mysql数据库
	 */
	
	function _connect(){
		//创建数据库连接
		global $_conn;//global标识全局变量，将此变量在函数外部也能访问
		if(!$_conn = @mysql_connect(db_host,db_user,db_pwd)){
			exit('数据库连接失败');
		}
	}
	
	/*
	 * _select_db()选择数据库
	 */
	function _select_db(){
		if(!mysql_select_db(db_name)){
			exit('找不到指定的数据库');
		}
	}
	
	function _set_names(){
		if(!mysql_query('set names utf8')){
			exit('字符集错误');
		}
	}
	
	
	function _query($_sql){
		if(!$_result = mysql_query($_sql)){
			exit('SQL执行失败');
		}
		return $_result;
	}
	
	
	function _fetch_array($_sql){
		return mysql_fetch_array(_query($_sql),MYSQL_ASSOC);
	}
	
	function _is_repeat($_sql,$_info){
		if(_fetch_array($_sql)){
			_alert_back($_info);
		}
		
	}
	
	function _close(){
		if(!mysql_close()){
			exit('关闭异常！');
		}
	}
	
	/*
	 * _affected_rows()表示影响到的记录数
	 */
	function _affected_rows(){
		return mysql_affected_rows();
	}
	
	
	function _num_rows($_result){
		return mysql_num_rows($_result);
		
	}
	
	
	function _insert_id(){
		return mysql_insert_id();
	}
?>