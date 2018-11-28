<?php

// 1, 加载项目初始化文件
include '../init.php';

// 2, 连接数据库
include DIR_CORE . 'MySQLDB.php';

// 3, 接收数据
$user_name = trim($_POST['user_name']);
$user_password1 = trim($_POST['user_password1']);
$user_password2 = trim($_POST['user_password2']);
$vcode = trim($_POST['vcode']);

// 4, 判断数据合法性
// 判断用户输入的验证码和系统随机产生的验证码是否相同
session_start();
if(strtolower($vcode) != strtolower($_SESSION['captcha'])) {
	// 验证码非法，跳转
	jump('./register.php', '验证码不正确！');
}
// 4.1 判断用户名和密码是否为空
if(empty($user_name) || empty($user_password1) || empty($user_password2)) {
	// 非法,跳转
	jump('./register.php', '用户名和密码不能为空！请您重新注册！');
}
// 4.2 判断用户名的长度
if(strlen($user_name) < 6 || strlen($user_name) > 16) {
	// 非法,跳转
	jump('./register.php', '用户名在6到10位之间！请您重新注册！');
}
// 4.3 判断两次数据的密码是否一致
if($user_password1 !== $user_password2) {
	// 非法,跳转
	jump('./register.php', '两次密码输入的不一致！请您重新注册！');
}

// 4.4 判断密码的长度
if(strlen($user_password1) < 6 || strlen($user_password1) > 16) {
	// 非法,跳转
	jump('./register.php', '密码在6到10位之间！请您重新注册！');
}
// 4.5 判断用户名是否已经存在
$sql = "select * from user where user_name='$user_name'";
mysql_query($sql);
if(mysql_affected_rows() > 0) {
	// 说明用户名已经存在
	// 非法,跳转
	jump('./register.php', '您输入的用户名已经存在！请您重新注册！');
}

// 5, 数据入库
$user_password = md5($user_password1);
$sql = "insert into user values(null, '$user_name', '$user_password', default)";
// 执行
$result = mysql_query($sql);
if($result) {
	// 成功注册,跳转
	jump('./login.php', '注册成功,2秒后跳转到登录页面！');
}else {
	// 入库失败
	jump('./register.php', '发生未知错误,注册失败！');
}








/*// 4, 判断数据合法性
// 4.1 判断用户名和密码是否为空
if(empty($user_name) || empty($user_password1) || empty($user_password2)) {
	// 非法,跳转
	header("refresh:2;url=./register.php"); // 刷新跳转,以后学
	die('用户名和密码不能为空！请您重新注册！');
}
// 4.2 判断用户名的长度
if(strlen($user_name) < 6 || strlen($user_name) > 16) {
	// 非法,跳转
	header("refresh:2;url=./register.php"); 
	die('用户名在6到10位之间！请您重新注册！');	
}
// 4.3 判断两次数据的密码是否一致
if($user_password1 !== $user_password2) {
	// 非法,跳转
	header("refresh:2;url=./register.php"); 
	die('两次密码输入的不一致！请您重新注册！');
}

// 4.4 判断密码的长度
if(strlen($user_password1) < 6 || strlen($user_password1) > 16) {
	// 非法,跳转
	header("refresh:2;url=./register.php"); 
	die('密码在6到10位之间！请您重新注册！');	
}
// 4.5 判断用户名是否已经存在
$sql = "select * from user where user_name='$user_name'";
mysql_query($sql);
if(mysql_affected_rows() > 0) {
	// 说明用户名已经存在
	// 非法,跳转
	header("refresh:2;url=./register.php"); 
	die('您输入的用户名已经存在！请您重新注册！');
}

// 5, 数据入库
$user_password = md5($user_password1);
$sql = "insert into user values(null, '$user_name', '$user_password')";
// 执行
$result = mysql_query($sql);
if($result) {
	// 成功注册,跳转
	header("refresh:2;url=./login.php"); 
	die('注册成功,2秒后跳转到登录页面！');
}else {
	// 入库失败
	header("refresh:2;url=./login.php"); 
	die('发生未知错误,注册失败！');	
}*/

