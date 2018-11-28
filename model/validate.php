<?php

// 1, 加载项目初始化文件
include '../init.php';

// 2, 加载数据库连接文件
include DIR_CORE . 'MySQLDB.php';

// 3, 接收表单数据
$user_name = trim($_POST['user_name']);
$user_password = trim($_POST['user_password']);

// 4, 验证用户的合法性
// 4.1 判断用户名和密码是否为空
if(empty($user_name) || empty($user_password)) {
	// 非法，跳转
	jump('./login.php', '用户名和密码不能为空！');
}
// 4.2 判断用户名是否存在
$sql = "select * from user where user_name='$user_name'";
$result = my_query($sql); // 资源结果集
if(mysql_affected_rows() == 0) {
	// 说明用户名不存在
	jump('./login.php', '用户名不存在！');
}
// 4.3 判断密码是否正确
// 4.3.1 先提取数据库中正确的密码
$row = mysql_fetch_assoc($result); // 得到一个数组
$true_password = $row['user_password'];//正确的密码
// 4.3.2 判断用户提交的密码和正确的密码是否相等
if(md5($user_password) === $true_password) {
	// 验证成功
	// 判断用户是否勾选了"7天免登录"
	if(isset($_POST['remember'])) {
		// 说明用户勾选了
		setCookie('user_id', $row['user_id'], time()+604800, '/');
	}
	// 为用户建立会话数据区,保存该用户的信息
	session_start();
	$_SESSION['userInfo'] = $row;
	
	// 跳转
	jump('./publish.php', '登录成功，2秒后跳转到发帖页面！');
}else {
	// 验证失败
	jump('./login.php', '您输入的密码不正确！');
}
