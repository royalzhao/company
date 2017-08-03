
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>

<header>
	<div class="logo">
		<a href="index.php"><img src="img/logo.png" /></a>
	</div>
	<ul>
		<li><a href="index.php">首页</a></li>
		<li><a href="shige.php">诗歌</a></li>
		<li><a href="list.php">留言板</a></li>
	</ul>
	<?php
    	if(isset($_COOKIE['username'])){
    		echo '<div class="login">';
    		echo '<img src="'.$_COOKIE["face"].'" />';
    		echo '<a href="#">'.$_COOKIE['username'].'</a>|';
			
            echo '<a href="logout.php">退出</a>';
            	
			echo '</div>';
    	}else{
    		echo '<div class="login">';
			echo '<img src="img/face.jpg" />';
			echo "\t\t";
    		echo '<a href="#"  data-toggle="modal" data-target="#myModal">登录/注册</a>';
			echo "\n";
			echo '</div>';
    	}
    ?>
	
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
							&times;
					</button>
				</div>
				<div class="modal-body">
					<div class="login_main">
	        		<form class="form-horizontal" role="form" method="post" name="login" action="login.php?action=login">
						<figure>
							<img src="img/face.jpg" alt="头像选择"> 
							<figcaption>
								<a href="javascript:void(0);"class="avatar_uplpad_btn" id="avatar_uplpad_btn">点击更换头像</a> 
							</figcaption>
						</figure>
					  <div class="form-group">
					    <label for="username" class="col-sm-3 control-label">昵称:</label>
					    <div class="col-sm-9">
					      <input type="text" class="form-control" id="username" name="username" placeholder="请输入昵称" required="required">
					    </div>
					  </div>
					  <div class="form-group">
					    <label for="password" class="col-sm-3 control-label">密码:</label>
					    <div class="col-sm-9">
					      <input type="password" class="form-control" id="password" name="password" placeholder="请输入密码" required="required">
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
					      <input type="submit" class="btn btn-default btn-lg btn-block" value="登录">
					    </div>
					  </div>
					  <p><a href="register.php">还没有账号，现在去注册&nbsp;&gt;&gt;</a></p>
					</form>
				</div>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal -->
	</div>	
		
	<script type="text/javascript">
		$(function(){
			$("form :input").blur(function(){
				var $parent = $(this).parent();
				if( $(this).is('#username') ){
					if( this.value=="" || this.value.length	< 2	){
						$('#username').addClass("error");
					}else{
						$('#username').addClass("success");
					}
			 	}
			 	if( $(this).is('#password') ){
					if( this.value=="" || this.value.length	< 6	){
						$('#password').addClass("error");
					}else{
						$('#password').addClass("success");
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
		})
	</script>
</header>