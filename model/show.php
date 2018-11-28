<?php

// 1, 加载项目初始化文件
include '../init.php';

// 2, 加载数据库连接文件
include DIR_CORE . 'MySQLDB.php';

// 3, 接收pub_id
$pub_id = $_GET['pub_id']; // 楼主的帖子的id号

// 6, 每通过列表页点一次,楼主的publish表的pub_hits加1
if(!$_GET['action']) {
	$sql = "update publish set pub_hits = pub_hits + 1 where pub_id = $pub_id";
	my_query($sql);
}

// 4, 提取楼主的帖子的信息
$sql = "select * from publish left join user on pub_owner = user_name where pub_id=$pub_id";
$row = fetchRow($sql); // 楼主的帖子的信息

// 5, 查询总记录数
$sql = "select count(*) from reply where rep_pub_id=$pub_id";
$rowCount = fetchColumn($sql); // 得到总记录数

// 6, 载入配置文件
$config = include DIR_CONFIG . 'config.php';
$rowsPerPage = $config['page']['rowsPerPage'];
$maxnum = $config['page']['maxnum'];
// 7, 拼凑$url
$url = "./show.php?pub_id=$pub_id&action=reply&";

// 8, 载入分页文件
include DIR_CORE . 'page.php';

// 9, 调用函数,得到页码字符串
$strPage = page($rowCount, $maxnum, $rowsPerPage, $url);

// 10, 提取回帖的资源结果集
$pageNum = isset($_GET['pageNum']) ? $_GET['pageNum'] : 1;
$offset = ($pageNum - 1) * $rowsPerPage;
$rep_sql = "select * from reply left join user on rep_user = user_name where rep_pub_id = $pub_id order by rep_time limit $offset, $rowsPerPage";
$rep_result = my_query($rep_sql);

// 11,提取当前帖子的回复数量
$num_sql = "select count(*) from reply where rep_pub_id = $pub_id";
$rep_num = fetchColumn($num_sql);

// 12,加载视图文件
include DIR_VIEW . 'show.html';
