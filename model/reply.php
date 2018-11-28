<?php

// 1, 加载初始化文件
include '../init.php';

// 6, 判断用户是否登录
/*session_start();
if(!isset($_SESSION['userInfo'])) {
	// 说明用户没有登录
	jump('./login.php','请您先登录！');
}
*/
is_login();
// 2, 加载数据库连接文件
include DIR_CORE . 'MySQLDB.php';

// 3, 接收楼主的帖子的id号
$pub_id = $_GET['pub_id'];

// 4, 提取楼主的帖子的信息
$sql = "select * from publish where pub_id=$pub_id";
$row = fetchRow($sql);

// 5, 加载视图文件
include DIR_VIEW . 'reply.html';

