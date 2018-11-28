<?php

// 1, 加载项目初始化文件
include '../init.php';

// 2, 加载数据库连接文件
include DIR_CORE . 'MySQLDB.php';

// 以下的代码跟分页有关
// 3, 查询总记录数
$sql = "select count(*)  from publish";
$rowCount = fetchColumn($sql);

// 4, 载入配置文件
$config = include DIR_CONFIG . 'config.php';
$rowsPerPage = $config['page']['rowsPerPage'];
$maxnum = $config['page']['maxnum'];
$url = './list_father.php?';

// 5, 载入分页文件
include DIR_CORE . 'page.php';

// 6, 调用函数,得到页码字符串
$strPage = page($rowCount, $maxnum, $rowsPerPage, $url);


// 分页到此结束

$pageNum = isset($_GET['pageNum']) ? $_GET['pageNum'] : 1;
// 3, 提取publish表的数据
$offset = ($pageNum - 1) * $rowsPerPage;
$sql = "select * from publish left join user on pub_owner = user_name order by pub_time desc limit $offset, $rowsPerPage";
$result = my_query($sql); // 得到资源结果集, 

// 4,加载视图文件
include DIR_VIEW . 'list_father.html';