<?php

// 1, 加载项目初始化文件
include '../init.php';

// 3, 判断用户是否登录
/*session_start();
if(!isset($_SESSION['userInfo'])) {
	// 说明用户没有登录
	jump('./login.php','请您先登录！');
}
*/
is_login();

// 2, 加载视图文件
include DIR_VIEW . 'publish.html';