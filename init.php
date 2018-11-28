<?php

/**
 * 项目初始化文件
 */

// 1, 设置响应头(设置文字编码)
header("Content-type:text/html;charset=utf-8");

// 2, 定义目录常量
// 定义根目录常量
define("DIR_ROOT", str_replace('\\', '/', __DIR__) . '/');
// 定义配置文件目录常量
define("DIR_CONFIG", DIR_ROOT . 'config/');
// 定义核心文件目录常量
define("DIR_CORE", DIR_ROOT . 'core/');
// 定义业务逻辑处理目录常量
define("DIR_MODEL", DIR_ROOT . 'model/');
// 定义模板文件目录常量
define("DIR_VIEW", DIR_ROOT . 'view/');
// 定义公开文件目录常量
define("DIR_PUBLIC", '/public'); // 这里的'/'代表根目录
// 定义UPLOADS文件目录常量
define("DIR_UPLOADS", DIR_ROOT . 'uploads/');

// 3, 封装跳转函数
/**
 * 封装跳转函数
 * @param string $url 跳转的url
 * @param string $info 跳转时的提示信息
 * @param int $time 跳转的时候等待的时间
 */
function jump($url, $info=NULL, $time=2) {
	if($info == NULL) {
		// 说明是直接跳转
		header("location:$url");
		die;
	}else {
		// 说明是刷新跳转
		header("refresh:$time;url=$url"); 
		die("$info");	
	}
}

/**
 * 封装数据处理函数
 * @param string $str 用户提交的信息
 * @return string 处理之后的信息
 */
function escapeString($str) {
	return addslashes(strip_tags(trim($str)));
}

/**
 * 判断用户是否登录
 */
function is_login() {
	// 判断用户是否登录
	@session_start(); // 确保开启了session
	if(!isset($_SESSION['userInfo'])) {
		// 说明用户没有登录
		jump('./login.php','请您先登录！');
	}
}


