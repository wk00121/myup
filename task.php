<?php 
/**
*	计划任务地址，指向目录webmain/task下
*	主页：http://xh829.com/
*	软件：信呼
*	作者：雨中磐石(rainrock)
*/
define('ENTRANCE', 'task');
include_once('config/config.php');
$d			= $rock->get('d','task');
$m			= $rock->get('m','mode');
include_once('include/View.php');