<?php

// 1, 加载项目初始化文件
include 'init.php';


// 3, 判断用户是否设置了7天免登录
// 如果设置了，应该主动为用户建立会话数据区
session_start();
if(isset($_COOKIE['user_id'])) {
	// 此时，我们应该根据user_id主动为用户建立会话数据区
	include DIR_CORE . 'MySQLDB.php';
	$user_id = $_COOKIE['user_id'];
	$sql = "select * from user where user_id=$user_id";
	$result = my_query($sql);
	$row = mysql_fetch_assoc($result);//得到了用户的信息
	$_SESSION['userInfo'] = $row;
}

// 2, 加载视图文件
include DIR_VIEW . 'index.html';