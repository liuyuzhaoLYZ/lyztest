<?php

// 1, 加载项目初始化文件
include '../init.php';

// 2, 加载数据库连接文件
include DIR_CORE . 'MySQLDB.php';

// 3, 接收表单数据
$pub_title = escapeString($_POST['pub_title']);
$pub_content = escapeString($_POST['pub_content']);

// 4, 判断数据的合法性
if(empty($pub_content) || empty($pub_title)) {
	// 非法,跳转
	jump('./publish.php', '标题和内容都不能为空！');
}

// 5, 数据入库
// $pub_owner = '游客'; // 此时应该是登录者的名字
// 提取当前用户的信息
session_start();
$pub_owner = $_SESSION['userInfo']['user_name'];

$pub_time = time();
$sql = "insert into publish values(null, '$pub_title', '$pub_content', '$pub_owner',$pub_time,default)";
// echo $sql; die;
$result = my_query($sql);

// 6, 判断执行结果
if($result) {
	// 发帖成功
	jump('./list_father.php');
}else {
	// 发帖失败
	jump('./publish.php', '发生未知错误，发帖失败！');
}


