<?php

/**
 * 数据库连接文件
 */

/**
 * 数据库连接函数
 */
function my_connect($arr) {
	$host = isset($arr['host']) ? $arr['host'] : 'localhost';
	$port = isset($arr['port']) ? $arr['port'] : '3306';
	$user = isset($arr['user']) ? $arr['user'] : 'root';
	$pass = isset($arr['pass']) ? $arr['pass'] : '';
	$link = @ mysql_connect("$host:$port", $user, $pass);
	if(!$link) {
		echo "数据库连接失败！<br />";
		echo "错误编号：", mysql_errno(), "<br />";
		echo "错误信息：", mysql_error(), '<br />';
		die;
	}
}

/**
 * 封装错误调试函数
 * @param string $sql 一条sql语句
 * @return mixed(true|resource) sql语句的执行结果
 */ 
function my_query($sql) {
	// 先执行sql语句
	$result = mysql_query($sql);
	// 再判断执行的结果
	if(!$result) {
		// sql语句执行失败
		// 给出相关的提示信息
		echo "SQL语句执行失败！<br />";
		echo "错误编号：", mysql_errno(), "<br />";
		echo "错误信息：", mysql_error(), '<br />';
		die;	
	}
	// 返回执行结果
	return $result;
}
/**
 * 封装fetchAll函数,得到多行多列的数据
 * @param string $sql 一条sql语句
 * @return array 二维数组
 */
function fetchAll($sql) {
	$result = my_query($sql);
	$rows = array();
	while($row = mysql_fetch_assoc($result)) {
		$rows[] = $row;
	}
	// 释放结果集资源
	mysql_free_result($result);
	return $rows;
}

/**
 * 封装fetchRow函数,得到一行多列的数据(一条记录)
 * @param string $sql 一条sql语句
 * @return array 一维数组
 */
function fetchRow($sql) {
	$result = my_query($sql);
	$row = mysql_fetch_assoc($result);
	// 释放结果集资源
	mysql_free_result($result);
	return $row;
}

/**
 * 封装fetchColumn函数,得到一行一列的数据(一个数值)
 * @param string $sql 一条sql语句
 * @return string $str
 */
function fetchColumn($sql) {
	$result = my_query($sql);
	$row = mysql_fetch_row($result);
	// 释放结果集资源
	mysql_free_result($result);
	return isset($row[0]) ? $row[0] : NULL;
}

/**
 * 选择默认的字符集
 */
function my_charset($arr) {
	$charset = isset($arr['charset']) ? $arr['charset'] : 'utf8';
	$sql = "set names $charset";
	my_query($sql);
}
 /**
 * 选择默认的数据库
 */
function my_dbname($arr) {
	$dbname = isset($arr['dbname']) ? $arr['dbname'] : '';
	$sql = "use $dbname";
	my_query($sql);
}

// 加载配置文件
$config = include DIR_CONFIG . 'config.php';
$arr = $config['db'];

// 数据库连接三步曲
// 连接数据库
my_connect($arr);
// 选择默认字符集
my_charset($arr);
// 选择默认的数据库
my_dbname($arr);