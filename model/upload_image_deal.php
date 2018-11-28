<?php

// 1, 加载项目初始化文件
include '../init.php';

// 2, 加载数据库连接文件
include DIR_CORE . 'MySQLDB.php';

// 3, 加载上传函数的文件
include DIR_CORE . 'upload.php';

// 4, 确定上传的参数
$file = $_FILES['image'];
$allow = array('image/jpg', 'image/jpeg', 'image/png', 'image/gif');
$path = DIR_UPLOADS . 'images';

// 5, 调用上传函数
$result = upload($file, $allow, $error, $path);

// 6, 判断是否入库成功
if($result) {
	// 上传成功
	// 提取当前登录者的名字
	session_start();
	$user_name = $_SESSION['userInfo']['user_name'];
	// 先提取旧头像名
	$old_sql = "select user_image from user where user_name='$user_name'";
	$old_name = fetchColumn($old_sql); // 旧头像名
	// 入库,更新
	$sql = "update user set user_image='$result' where user_name='$user_name'";
	$res = my_query($sql);
	if($res) {
		// 入库成功
		// 删除旧头像
		unlink($path . '/' . $old_name);
		// 跳转
		jump('./list_father.php','头像上传成功！');
	}else {
		// 入库失败
		jump('./upload_image.php','发生未知错误，上传失败！');
	}
}else {
	// 上传失败
	jump('./upload_image.php','发生未知错误，上传失败！');
}
