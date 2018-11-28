<?php

// 1, 加载项目初始化文件
include '../init.php';

// 2, 加载数据库连接文件
include DIR_CORE . 'MySQLDB.php';

// 3, 接收数据
$pub_id = $rep_pub_id = $_POST['pub_id'];
$rep_content = escapeString($_POST['rep_content']);

// 4, 验证数据
if(empty($rep_content)) {
	// 非法,跳转
	jump("./reply.php?pub_id=$pub_id", '回复的内容不能为空！');
}

// 5, 数据入库
// $rep_user = '匿名';
// 提取当前用户的信息
session_start();
$rep_user = $_SESSION['userInfo']['user_name'];

$rep_time = time();
$sql = "insert into reply values(null, $rep_pub_id, '$rep_user', '$rep_content', $rep_time, default, default)";
// 执行
$result = my_query($sql);// 得到资源结果集

// 6, 判断执行结果
if($result) {
	// 入库成功,跳转
	jump("./show.php?pub_id=$pub_id&action=reply");
}else {
	// 入库失败
	jump("./reply.php?pub_id=$pub_id",'发生未知错误，回帖失败！');
}

