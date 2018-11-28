<?php

// 1, 加载项目初始化文件
include '../init.php';

// 2, 判断用户是否登录
/*session_start();
if(!isset($_SESSION['userInfo'])) {
	// 说明用户没有登录
	jump('./login.php','请您先登录！');
}*/
is_login();


// 3, 加载数据库连接文件
include DIR_CORE . 'MySQLDB.php';

// 4, 接收数据
$num = $_GET['num'];//楼层数
$pub_id = $_GET['pub_id'];//楼主的id
$rep_id = $_GET['rep_id'];//被引用的帖子的id

// 5, 提取楼主的信息
$sql = "select * from publish where pub_id=$pub_id";
$row = fetchRow($sql);

// 6, 提取被引用的帖子的信息
$sql = "select * from reply where rep_id=$rep_id";
$rep_row = fetchRow($sql);// 被引用的帖子的数组信息

// 7, 加载视图文件
include DIR_VIEW . 'quote.html';
