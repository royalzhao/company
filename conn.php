<?php
$conn =mysql_connect("localhost","root","root") or die("数据库链接错误");
mysql_select_db("message",$conn);
mysql_query("set names 'utf8'");
?>