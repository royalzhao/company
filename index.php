<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>我的网页</title>
		<script type="text/javascript" src="js/jquery-3.0.0.min.js" ></script>
		<script type="text/javascript" src="js/bootstrap.min.js" ></script>	
		<script type="text/javascript" src="js/code.js" ></script>
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/base.css" />
		<link rel="stylesheet" href="css/css.css" />
		<script src="https://cdn.bootcss.com/pace/1.0.2/pace.min.js"></script>
		<link href="https://cdn.bootcss.com/pace/1.0.2/themes/green/pace-theme-loading-bar.min.css" rel="stylesheet">
	</head>
	<body>
		
		<div class="main">
			<?php include ("head.php")?>
			<div class="container">
				<div id="myCarousel" class="carousel slide">
				    <!-- 轮播（Carousel）指标 -->
				    <ol class="carousel-indicators">
				        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
				        <li data-target="#myCarousel" data-slide-to="1"></li>
				        <li data-target="#myCarousel" data-slide-to="2"></li>
				    </ol>   
				    <!-- 轮播（Carousel）项目 -->
				    <div class="carousel-inner">
				        <div class="item active">
				            <img src="img/bg3.jpg" alt="First slide">
				        </div>
				        <div class="item">
				            <img src="img/bg4.jpg" alt="Second slide">
				        </div>
				        <div class="item">
				            <img src="img/bg5.jpg" alt="Third slide">
				        </div>
				    </div>
				    <!-- 轮播（Carousel）导航 -->
				    <a class="carousel-control left" href="#myCarousel" 
				        data-slide="prev">&lsaquo;
				    </a>
				    <a class="carousel-control right" href="#myCarousel" 
				        data-slide="next">&rsaquo;
				    </a>
				</div>
			</div>
			<?php include ("footer.php")?>
		</div>
	</body>
</html>
