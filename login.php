<?php
	session_start();
	require dirname(__FILE__).'/includes/common.php';
	
	//登录状态
	_login_state();
	
	//开始处理登录状态
	if(@$_GET['action'] == 'login'){
		//接入验证文件
		include ROOT_PATH.'includes/login_fun.php';
		//为防止恶意注册，跨站攻击
    	_check_code($_POST['code'], $_SESSION['code']);
		//接受数据
//		$_clean = array();
//		$_clean['username'] = $_POST['username'];
//		$_clean['password'] = _check_password($_POST['password'], 6);
//		$_clean['face'] = $_POST['face'];
		
		//到数据库验证
		if(!!$_rows = _fetch_array("select username,face from user where username='{$_POST['username']}' and password='{$_POST['password']}'")){
			//登陆成功后记录登录信息
			_close();
			session_destroy();
			setcookie('username',$_rows['username']);
			setcookie('face',$_rows['face']);
			_location(null, 'list.php');
		}else{
			_close();
			session_destroy();
			_location('用户名或密码不正确', 'list.php');

		}
	}
	
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>登录</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/base.css" />
        <link rel="stylesheet" href="css/css.css" />
        <link rel="stylesheet" href="css/login.css" />
        <script type="text/javascript" src="js/jquery-3.0.0.min.js" ></script>
        <script type="text/javascript" src="js/bootstrap.min.js" ></script>
        <script type="text/javascript" src="js/code.js" ></script>
        <script type="text/javascript" src="js/login.js" ></script>
    </head>
    <body>
    	
    </body>
</html>