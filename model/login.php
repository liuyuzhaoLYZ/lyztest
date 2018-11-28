<?php

// 1, 加载项目初始化文件
include '../init.php';

session_start();
// 3, 判断是否设置了user_id这个cookie变量
if(isset($_COOKIE['user_id']) && isset($_SESSION['userInfo'])) {
	// 说明用户设置了7天免登录并没有过期
	// 应该直接跳转到发帖页面
	jump('./publish.php');
}


// 2, 加载视图文件
include DIR_VIEW . 'login.html';