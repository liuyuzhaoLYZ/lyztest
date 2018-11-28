<?php

include '../init.php';
include DIR_CORE . 'MySQLDB.php';

// 1, 接收数据
$rep_content = escapeString($_POST['rep_content']);// 回复的内容
$rep_pub_id = $pub_id = $_GET['pub_id']; // 楼主的id
$rep_quote_id = $rep_id = $_GET['rep_id']; // 被引用的回帖的id
$rep_num = $num = $_GET['num']; // 被引用的回帖的楼层号

// 2, 判断数据的合法性
if(empty($rep_content)) {
	// 非法,跳转
	jump("./quote.php?num=$num&pub_id=$pub_id&rep_id=$rep_id", '内容不能为空！');
}

// 3,数据入库
// 3.1 提取回复者的名字
session_start();
$rep_user = $_SESSION['userInfo']['user_name'];
// 3.2 引用回复的时间
$rep_time = time();
// 3.3 执行
$sql = "insert into reply values(null, $rep_pub_id, '$rep_user', '$rep_content', $rep_time, $rep_num, $rep_quote_id)";
$result = my_query($sql);
// 4, 判断执行的结果
if($result) {
	// 入库成功
	jump("show.php?pub_id=$pub_id&action=reply");
}else {
	// 入库失败
	jump("./quote.php?num=$num&pub_id=$pub_id&rep_id=$rep_id", '发生未知错误,回帖失败！');
}





