<?php

include '../init.php';
/**
 * 注销登录
 */
// 删除cookie数据
setCookie('user_id', '', time()-1, '/');
// 删除session数据
session_start();
$_SESSION = array();
session_destroy();
// 跳转
jump('../index.php', '注销成功！2秒后跳转到首页！');
