<?php 
class indexClassAction extends Action{
	
	private function homeicons()
	{
		$myext	= $this->getsession('adminallmenuid');
		$where	= '';
		if($myext != '-1'){	
			$where	= ' and `id` in('.str_replace(array('[',']'), array('',''), $myext).')';
		}
		$mrows = m('menu')->getrows("`ishs`=1 and `status`=1 $where ", "`id`,`num`,`name`,`url`,`color`,`icons`",'`sort`');
		return $mrows;
	}
	
	public function gettotalAjax()
	{
		$loadci	= (int)$this->get('loadci','0');
		$optdta	= $this->get('optdt');
		$optdt 	= $this->now;
		$uid 	= $this->adminid;
		$arr['optdt']	= $optdt;
		$todo			= m('todo')->rows("uid='$uid' and `status`=0 and `tododt`<='$optdt'");
		$arr['todo']	= $todo;
		if($loadci==0){
			$arr['showkey'] = $this->jm->base64encode($this->jm->getkeyshow());
			$arr['menuarr'] = $this->homeicons();
			$arr['token']	= $this->admintoken;
			$tssval 		= $this->option->getval('systaskrun');		
			//没服务端时用户id=1就读取计划任务列表
			if($this->adminid==1 && !contain($tssval, $this->rock->date)){
				$arr['tasklist'] 	= m('task')->getrunlist();
				$arr['tasklista'] 	= $tssval;
			}
		}
		$s = $s1 = '';
		if($loadci==0){
			if($todo>0){
				$s = '您还有<font color=red>('.$todo.')</font>条未读提醒信息;<a onclick="return opentixiangs()" href="javascript:">[查看]</a>';
				$s1= '您还有('.$todo.')条未读提醒信息;';
			}
		}else{
			if($todo>0){
				$rows = m('todo')->getrows("uid='$uid' and `status`=0 and `optdt`>'$optdta' and `tododt`<='$optdt' order by `id` limit 3");
				foreach($rows as $k=>$rs){
					$s .= ''.($k+1).'、['.$rs['title'].']'.$rs['mess'].'。<br>';
					$s1.= ''.($k+1).'、['.$rs['title'].']'.$rs['mess'].'。'."\n";
				}
			}
		}
		$msgar[0] = $s;
		$msgar[1] = $s1;
		$arr['msgar']	= $msgar;
		$arr['total']	= m('totals')->gettotals($uid);
		$arr['gongarr'] 	= $this->getgonglist();
		$arr['applyarr'] 	= m('flowbill')->homelistshow();
		$arr['meetarr'] 	= m('meet')->getmeethome($this->date, $uid);
		$this->returnjson($arr);
	}
	
	public function getqrcoresAjax()
	{
		if(!function_exists('ImageCreate')){
			echo ''.URL.'?d=we';
		}else{
			echo 'ok';
		}
	}
	
	public function getqrcodeAjax()
	{
		header("Content-type:image/png");
		$url = ''.URL.'?m=login&d=we&token='.$this->admintoken.'&user='.$this->jm->base64encode($this->adminuser).'';
		$img = c('qrcode')->show($url);
		echo $img;
	}
	
	private function getgonglist()
	{
		$rows = m('flow')->initflow('gong')->getflowrows($this->adminid,'wexx');
		return $rows;
	}
}