<?php
if(!defined('HOST'))die('not access');
//[管理员]在2017-04-07 03:55:02通过[系统→系统工具→系统设置]，保存修改了配置文件
return array(
	'url'	=> 'http://localhost/up/',	//系统URL
	'localurl'	=> '',	//本地系统URL，用于服务器上浏览地址
	'title'	=> '银联办公系统',	//系统默认标题
	'apptitle'	=> '银联OA',	//APP上或PC客户端上的标题
	'db_host'	=> 'localhost',	//数据库地址
	'db_user'	=> 'root',	//数据库用户名
	'db_pass'	=> '',	//数据库密码
	'db_base'	=> 'up',	//数据库名称
	'perfix'	=> 'up_',	//数据库表名前缀
	'qom'	=> 'xinhu_',	//session、cookie前缀
	'highpass'	=> '',	//超级管理员密码，可用于登录任何帐号
	'db_drive'	=> 'mysqli',	//操作数据库驱动有mysql,mysqli,pdo三种
	'randkey'	=> 'leuyntfqmpavrxzdigjowbhskc',	//系统随机字符串密钥
	'asynkey'	=> 'da2cca25475e8f72d1f6d93776680559',	//这是异步任务key
	'openkey'	=> '6d2a0ce06c614a79cbdd0e1c945992df',	//对外接口openkey
	'updir'	=> 'upload',
	'sqllog'	=> false,	//是否记录sql日志保存upload/sqllog下
	'asynsend'	=> false,	//是否异步发送提醒消息，为true需开启服务端
	'install'	=> true,	//已安装，不要去掉啊
	'xinhukey'	=> '',	//信呼官网key，用于在线升级使用

);