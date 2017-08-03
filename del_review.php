<?php
header("Content-type: text/html; charset=utf-8");
include 'conn.php';
$id = $_GET['id'];
$query="delete from review where id=".$id;
mysql_query($query);
echo "<script>alert('删除成功');location.href='list.php';</script>";
?>