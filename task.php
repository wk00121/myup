<?php 
/**
*	计划任务地址，指向目录webmain/task下
*	主页：http://xh829.com/
*	软件：信呼
*	作者：雨中磐石(rainrock)
*/
define('ENTRANCE', 'task');
include_once('config/config.php');
$m 			= 'mode';
if(isset($argv[1])){
	$_mar	= explode(',', $argv[1]);
	$m 		= $_mar[0];
	if(isset($_mar[1]))$a = $_mar[1];
}
$d			= $rock->get('d','task');
$m			= $rock->get('m',$m);
include_once('include/View.php');