<?php
	require dirname(__FILE__).'/includes/common.php';
	session_start();
	if(@$_GET['action'] == 'review'){
		if(@$_COOKIE['username'] != null){
			
			$_clean = array();
			$_clean['face'] = $_COOKIE['face'];	
			$_clean['reviewer'] = $_COOKIE['username'];
			$_clean['by_reviewer'] = $_POST['user'];
			$_clean['by_reviewer_messageid'] = $_POST['id'];
			$_clean['re_content'] = $_POST['re_content'];
		
			$sql="insert into review(id,face,reviewer,by_reviewer,by_reviewer_messageid,re_content,re_datetime)"."values('','{$_clean['face']}','{$_clean['reviewer']}','{$_clean['by_reviewer']}','{$_clean['by_reviewer_messageid']}','{$_clean['re_content']}',now())";
			mysql_query($sql);
			echo "<script>alert('回复留言成功');location.href='list.php';</script>";
			session_destroy();
		}else{
			echo "<script>alert('请先登录');location.href='list.php';</script>";
		}
		
		
	}
								
								
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
 	<meta charset="UTF-8">
 	<link rel="stylesheet" href="css/bootstrap.min.css" />
 	<link rel="stylesheet" href="css/base.css" />
 	<link href="css/css.css" rel="stylesheet" type="text/css">
	
 	<script type="text/javascript" src="js/jquery-3.0.0.min.js" ></script>
 	<script type="text/javascript" src="js/bootstrap.min.js" ></script>
	<script type="text/javascript" src="js/code.js" ></script>
	<script src="https://cdn.bootcss.com/pace/1.0.2/pace.min.js"></script>
	<link href="https://cdn.bootcss.com/pace/1.0.2/themes/green/pace-theme-loading-bar.min.css" rel="stylesheet">
	
	<title>留言板</title>
	<?php include ("add.php")?>
	<?php include ("conn.php")?>
</head>

<style>
	body{
		background: url(img/background.jpg);
		background-attachment: fixed;
		background-size:cover ;
	}
</style>
<body>

	<div class="main">
		<!--
        	作者：1461451270@qq.com
        	时间：2017-04-01
        	描述：调用头部
        -->
		<?php include ("head.php")?>
		
		<!--
        	作者：1461451270@qq.com
        	时间：2017-04-01
        	描述：正文开始
        -->
		<div class="container">
			<div class="row">
				<!--
                	作者：1461451270@qq.com
                	时间：2017-04-01
                	描述：正文左侧
                -->
				<div class="col-xs-7">
					<div class="message_write">
						<div class="row">
							<div class="face col-sm-2">
								<img src="<?php 
								if(@$_COOKIE['username'] != null){
									echo $_COOKIE['face'];
								}else{
									echo 'img/face.jpg';
								}
								?>" />
							</div>
							<div class="content col-sm-10">
								<form action="add.php?action=message" role="form" class="form-horizontal" method="post" name="myform" onsubmit="return CheckPost();">
									
									<div class="form-group">
										<label class="col-sm-2 control-label">标题</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="title"  required="required" /><br/><br>
										</div>
									</div>
									<div class="suggest">你还可以输入<span>200</span>个字</div>
									<div class="form-group">
										<div class="col-sm-12">
											<textarea name="content" class="form-control"  required="required"></textarea><br>
										</div>
									</div>
									<input type="submit"  name="submit" class="btn btn-default" value="发布留言" />
									
								</form>
							</div>
						</div>
					</div>
					
						<?php
						     $sql="select * from message order by id desc";
						     $query=mysql_query($sql);
						     while($row=mysql_fetch_array($query)){ 
							
							 ?>
					<div class="message_show">
						<div class="row">
							<div class="face col-sm-2">
								<img src="<?php echo $row['face'];?>" />
								<p class="user"><?php echo $row['user'];?> </p>
							</div>
							
							<div class="content col-sm-10">
								<div class="panel panel-default">
									<div class="panel-heading">
								    	<!--
			                            	作者：1461451270@qq.com
			                            	时间：2017-04-01
			                            	描述：留言框的三角形
			                            -->
										<div class="san"></div>
								        	<span class="title">标题： <?php echo $row['title'];?> </span>
								        	<span class="time">时间:<?php echo $row['lastdate'];?></span>
								    </div>
								    <div class="panel-body">
								        <?php echo $row['content'];?>
								        	
										<?php if(@$_COOKIE['username'] != null){ ?>
											<span class="reviwer"><a data-toggle="collapse" data-target="#<?php echo $row['id']?>" >回复</a></span>
										<?php }?>
								        <?php
								        	$level = @_fetch_array("select level from user where username='{$_COOKIE['username']}'");
											
											if($level['level']==1){
										?>
								        	<span class="del"><a href="javascript:if(confirm('确认删除吗?'))window.location='del.php?id=<?php echo $row['id'];?>'">删除</a></span>
								        <?php
								        	}	
								        ?>
								    </div>
								</div>
								<!--
			                    	作者：1461451270@qq.com
			                    	时间：2017-04-03
			                    	描述：回复面板
			                    -->
					        	<div id="<?php echo $row['id']?>" class="collapse out">
					        		<div class="panel panel-default">
					        			<form action="list.php?action=review" method="post">
										    <div class="panel-heading">
										        <span class="reviwer_name"><b><?php echo $_COOKIE['username']?></b>回复给<b><?php echo @$row['user']?></b> </span>
						        				<span class="time">时间:<?php echo  date("Y-m-d");?></span>
												<input type="text" name="id" value="<?php echo $row['id']?>" style="display:none" />
												<input type="text" name="user" value="<?php echo $row['user']?>"  style="display:none" />
										    </div>
										    <div class="panel-body">
										        <textarea name="re_content" class="form-control"  required="required"></textarea>
										    </div>
										    <input type="submit" class="btn btn-default" value="回复留言"/>
									    </form>
									</div>
					        	</div>
								
					        	<!--
                                	作者：1461451270@qq.com
                                	时间：2017-04-03
                                	描述：回复评论
                                -->
								<?php
							     $sql1="select * from review where by_reviewer_messageid='{$row['id']}' order by id desc";
							     $query1=mysql_query($sql1);
							     while($html=mysql_fetch_array($query1)){ ?>
							    <div class="review">
									<div class="media panel panel-default">
										<a class="pull-left" href="#">
									        <img class="media-object" src="<?php echo $html['face']?>"
									             alt="<?php echo $html['reviewer']?>" style="width: 60px;">
									    </a>
									    <div class="media-body">
									        <h4 class="media-heading">
									        	<span class="head"><b><?php echo $html['reviewer']?></b>回复给<b><?php echo $html['by_reviewer']?></b> </span>
				        						<span class="time">时间:<?php echo $html['re_datetime'];?></span>
									        </h4>
									       	<span><?echo $html['re_content']?></span>
									       	<?php
									        	$level = @_fetch_array("select level from user where username='{$_COOKIE['username']}'");
												
												if($level['level']==1){
											?>
									        	<span class="del"><a href="javascript:if(confirm('确认删除吗?'))window.location='del_review.php?id=<?php echo $html['id'];?>'">删除</a></span>
									        <?php
									        	}	
									        ?>
									    </div>
									</div>
								</div>
								
								<?php
								}	
								?>
							</div>
						</div>
					</div>
					
					<?php } ?>
				</div>
				<!--
                	作者：1461451270@qq.com
                	时间：2017-04-01
                	描述：正文右侧
                -->
				<div class="col-xs-5">
					<div class="ad_face">
						<img src="img/zhao.jpg" />
						<p>管理员</p>
					</div>
					
					<div class="notice">
						<img src="img/subject.png" />
					</div>
					<div class="clear"></div>
					<?php
					     $sql="select * from ad_message order by id desc";
					     $query=mysql_query($sql);
					     while($row=mysql_fetch_array($query)){  ?>
						<!--
	                    	作者：1461451270@qq.com
	                    	时间：2017-04-01
	                    	描述：对话框循环
	                    -->
	                    
						<div class="message">
							<div class="top_san"></div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<span class="title">标题： <?php echo $row['ad_title'];?> </span>
							    	<span class="time">时间:<?php echo $row['ad_lastdate'];?></span>
								</div>
							    <div class="panel-body">
							       <?php echo $row['ad_content'];?>
							       	<?php
							        	$level = @_fetch_array("select level from user where username='{$_COOKIE['username']}'");
										
										if($level['level']==1){
									?>
							        	<span class="del"><a href="javascript:if(confirm('确认删除吗?'))window.location='del_admessage.php?id=<?php echo $row['id'];?>'">删除</a></span>
							        <?php
							        	}	
							        ?>
							    </div>
							</div> 
						</div>  
						<?php
				        	}	
				        ?>
							    <!--
	                                	作者：1461451270@qq.com
	                                	时间：2017-04-02
	                                	描述：管理员发表公告
	                                -->
					    <?php
				        	$level = @_fetch_array("select level from user where username='{$_COOKIE['username']}'");
							
							if($level['level']==1){
						?>
				        	<div class="ad_message_write">
								<div class="row">
									<div class="content col-sm-10">
										<form action="add.php?action=ad_message" role="form" class="form-horizontal" method="post" name="myform" onsubmit="return CheckPost();">
											<div class="form-group">
												<label class="col-sm-2 control-label">标题</label>
												<div class="col-sm-10">
													<input type="text" class="form-control" name="ad_title"  required="required" /><br/><br>
												</div>
											</div>
											<div class="suggest">你还可以输入<span>200</span>个字</div>
											<div class="form-group">
												<div class="col-sm-12">
													<textarea name="ad_content" class="form-control"  required="required"></textarea><br>
												</div>
											</div>
											<input type="submit"  name="submit" class="btn btn-default" value="发布公告" />
											
										</form>
									</div>
								</div>
							</div>
				        <?php
				        	}	
				        ?>
							
				</div>
			</div>
		</div>
		
	
		<?php include ("footer.php")?>
	</div>
	
</body>

</html>