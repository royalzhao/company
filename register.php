<?PHP
	
    //引入公共文件
    require dirname(__FILE__).'/includes/common.php';
	require dirname(__FILE__).'/includes/login_fun.php';
	session_start();
	
    if(@$_GET['action'] == 'reg'){
    	
    	//为防止恶意注册，跨站攻击
    	_check_code($_POST['code'], $_SESSION['code']);
		
		//登录状态
		_login_state();
	
		//创建一个空数组，用来接受合法数据
		$_clean = array();
		$_clean['username'] = $_POST['username'];
		$_clean['password'] = $_POST['password'];
		
		if(isset($_SESSION['face'])){
			$_clean['face'] = $_SESSION['face'];
		}else{
			$_clean['face'] = 'img/face.jpg';
		}
		
		
		_is_repeat("SELECT username from user where username = '{$_clean['username']}'", 
					'对不起，此用户已被注册!'
			);
		
		//新增用户
		_query(
					"insert into user(
										username,
										password,
										face
										)
								values(
										'{$_clean['username']}',
										'{$_clean['password']}',
										'{$_clean['face']}'
										)"
		);
		if(_affected_rows() == 1){
			
			//关闭数据库
			_close();
			session_destroy();
			//生成xml
			_set_xml('new.xml', $_clean);
			//跳转
			_location('恭喜你注册成功！', 'index.php');
		}else{
			_close();
			session_destroy();
			//跳转
			_location('很遗憾，注册失败！', 'register.php');
		}
		
		
    }
	
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>注册</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/base.css" />
        <link rel="stylesheet" href="css/css.css" />
        <link rel="stylesheet" href="css/reg.css" />
        <script type="text/javascript" src="js/jquery-3.0.0.min.js" ></script>
        <script type="text/javascript" src="js/bootstrap.min.js" ></script>
        <script type="text/javascript" src="js/login.js" ></script>
        <script type="text/javascript" src="js/check.js" ></script>
        <script type='text/javascript' src='js/jquery.form.js'></script>
        <script type="text/javascript" src="js/code.js" ></script>
        <script src="https://cdn.bootcss.com/pace/1.0.2/pace.min.js"></script>
		<link href="https://cdn.bootcss.com/pace/1.0.2/themes/green/pace-theme-loading-bar.min.css" rel="stylesheet">
    </head>
    <body>
        <?PHP
            require ROOT_PATH.'head.php';
        ?>
        	<div class="reg_main">
	        	<figure>
					<form id='myupload' action='upload.php' method='post' enctype='multipart/form-data'>
						<input type="file" id="uploadphoto" name="uploadfile" value="请点击上传图片"  style="display:none;" />
					</form>
					<div class="imglist">
						<img src="img/face.jpg" /> 
					</div>
					<figcaption>
						<a href="javascript:void(0);" onclick="uploadphoto.click()" class="uploadbtn">点击更换头像</a>
					</figcaption>
					
				</figure>
				<p class="res"></p>
        		<form class="form-horizontal" id='myupload'  enctype='multipart/form-data' role="form" method="post" name="reg" action="register.php?action=reg">
					
					<!--<div class="progress">
						<div class="progress-bar progress-bar-striped" ><span class="percent">50%</span></div>
				    </div>-->
				  <div class="form-group">
				    <label for="username" class="col-sm-3 control-label">昵称:</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="re_username" name="username" placeholder="昵称不得小于两位或大于二十位" required="required">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="password" class="col-sm-3 control-label">密码:</label>
				    <div class="col-sm-9">
				      <input type="password" class="form-control" id="re_password" name="password" placeholder="密码不得小于6位" required="required">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="lastname" class="col-sm-3 control-label">确认密码:</label>
				    <div class="col-sm-9">
				      <input type="password" class="form-control" id="notpassword"  name="notpassword" placeholder="" required="required">
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="lastname" class="col-sm-3 control-label">验证码:</label>
				    <div class="col-sm-9">
				      	<input type="text" class="form-control code" name="code">
				      	<img src="code.php" class="yzm">
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-12">
				      <input type="submit" id="send" class="btn btn-default btn-lg btn-block" value="注册">
				    </div>
				  </div>
				</form>
			</div>
			<script>
				$(function(){
					$("form :input").blur(function(){
						var $parent = $(this).parent();
						if( $(this).is('#re_username') ){
							if( this.value=="" || this.value.length	< 2	){
								$('#re_username').addClass("error");
							}else{
								$('#re_username').addClass("success");
							}
					 	}
					 	if( $(this).is('#re_password') ){
							if( this.value=="" || this.value.length	< 6	){
								$('#re_password').addClass("error");
							}else{
								$('#re_password').addClass("success");
							}
					 	}
					 	if( $(this).is('#notpassword') ){
							if( $('#notpassword').val() == $('#re_password').val()){
								$('#notpassword').addClass("success");
							}else{
								
								$('#notpassword').addClass("error");
							}
					 	}
					});
					$("#send").click(function(){
						$("form .required:input").trigger('blur');
						var numError = $('form .onError').length;
						if(numError){
							return false;
						}else{
							return true;
						}
						
					})
					
					var progress = $(".progress"); 
				    var progress_bar = $(".progress-bar");
				    var percent = $('.percent');
				    $("#uploadphoto").change(function(){
				  	 $("#myupload").ajaxSubmit({ 
				  		dataType:  'json', //数据格式为json 
				  		beforeSend: function() { //开始上传 
				  			progress.show();
				  			var percentVal = '0%';
				  			progress_bar.width(percentVal);
				  			percent.html(percentVal);
				  		}, 
				  		uploadProgress: function(event, position, total, percentComplete) { 
				  			var percentVal = percentComplete + '%'; //获得进度 
				  			progress_bar.width(percentVal); //上传进度条宽度变宽 
				  			percent.html(percentVal); //显示上传进度百分比 
				  		}, 
				  		success: function(data) {
							 
							if(data.status == 1){
								var src = data.url;  
				//				var attstr= '<img src="'+src+'">';  
				//				$(".imglist").append(attstr);
								$(".imglist img").attr('src',src);
								
							}else{
								$(".res").html(data.content);
							}
				  			progress.hide();		
				  		}, 
				  		error:function(xhr){ //上传失败 
				  		   alert("上传失败"); 
				  		   progress.hide(); 
				  		} 
				  	}); 
				   });
				})

			</script>
            
        </div>
        <?PHP
            require ROOT_PATH.'footer.php';
        ?>
        
    </body>
</html>

    



