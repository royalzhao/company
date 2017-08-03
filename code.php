<?php
	session_start();
	$_nmsg = '';
	
		//随机码的个数
		$_rand_number = 4;
		
		//创建随机码
		for($i=0;$i<$_rand_number;$i++){
			$_nmsg .= dechex(mt_rand(0, 15));
		}
		
		//持久保存在session
	
		$_SESSION['code'] = $_nmsg;
		
		
		//创建一张图像
		$width = 75;
		$height = 25;
		
		$image = imagecreatetruecolor($width, $height);
		
		//白色
		$white = imagecolorallocate($image, 255, 255, 255);
		
		//填充
		imagefill($image, 0, 0, $white);
		
		$_flag = FALSE;
		
		if($_flag){
			//创建一个黑色的边框
			$black = imagecolorallocate($image, 0, 0, 0);
			imagerectangle($image, 0, 0,$width-1, $height-1, $black);
		}
		
		
		
		//随机画出六个线条
		for($i=0;$i<6;$i++){
			$_rand_color = imagecolorallocate($image, mt_rand(0, 255), mt_rand(0, 255), mt_rand(0, 255));
			imageline($image, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, $width), mt_rand(0, $height), $_rand_color);
		}
		
		//随机雪花
		for($i=0;$i<100;$i++){
			$_rand_color = imagecolorallocate($image, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
			imagestring($image, 1, mt_rand(1, $width), mt_rand(1, $height), '*', $_rand_color);
		}
		
		//输出验证码
		for($i=0;$i<strlen($_SESSION['code']);$i++){
			$_rand_color = imagecolorallocate($image, mt_rand(0, 100), mt_rand(0, 150), mt_rand(0, 200	));
			imagestring($image, 5, $i*$width/$_rand_number+mt_rand(1,10), mt_rand(1,$height/2), $_SESSION['code'][$i], $_rand_color);
		}
	
		
		//输出图像
		header('Content-Type:image/png');
		imagepng($image);
		
		//销毁
		imagedestroy($image);
	
?>