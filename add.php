<?php
header("Content-type: text/html; charset=utf-8");
include("conn.php");

if(@$_GET['action'] == 'message'){
	if(@$_COOKIE['username'] != null){
		$sql="insert into message(id,user,title,content,face,lastdate)"."values('','{$_COOKIE['username']}','$_POST[title]','$_POST[content]','{$_COOKIE['face']}',now())";
    mysql_query($sql);
    echo "<script>alert('留言成功');location.href='list.php';</script>";
	}else{
		echo "<script>alert('请先登录');location.href='list.php';</script>";
	}
  
}
if(@$_GET['action'] == 'ad_message'){

  $sql="insert into ad_message(id,ad_title,ad_content,ad_lastdate)"."values('','$_POST[ad_title]','$_POST[ad_content]',now())";
    mysql_query($sql);
    echo "<script>alert('公告发布成功');location.href='list.php';</script>";
}
?>