<?php
class flow_workClassModel extends flowModel
{

	public function initModel()
	{
		$this->statearr		 = c('array')->strtoarray('待执行|blue,已完成|green,执行中|#ff6600,终止|#888888,验证未通过|#9D4FF7');
	}
	
	//自定义审核人读取
	protected function flowcheckname($num){
		$sid = '';
		$sna = '';
		if($num=='run'){
			$sid = $this->rs['distid'];
			$sna = $this->rs['dist'];
		}
		return array($sid, $sna);
	}
	
	//转办时要更新对应的执行人员
	protected function flowcheckbefore(){
		$up = array();
		if($this->checkiszhuanyi==1){
			$up['dist'] 	= $this->rs['zb_name'];
			$up['distid'] 	= $this->rs['zb_nameid'];
			$up['status'] 	= 3; //待执行状态
		}
		if($up)$up['update'] = $up;
		return $up;
	}
	
	public function flowrsreplace($rs, $slx=0){
		
		$zts 		= $rs['status'];
		$str 		= $this->getstatus($rs,'','',1);
		if($slx==1){
			$projectid 	= (int)$rs['projectid'];
			$rs['projectid'] = '';
			if($projectid>0){
				$prs 		= $this->db->getone('[Q]project', $projectid);
				if($prs){
					$rs['projectid']=''.$prs['title'].'('.$prs['progress'].'%)';
				}
			}
		}
		if(!isempt($rs['enddt']) && $zts!=1){
			if(strtotime($rs['enddt'])<time())$str.='<font color=red>(已超期)</font>';
		}
		$rs['state']= $str;
		if($rs['score']==0)$rs['score']='';
		if($rs['mark']==0)$rs['mark']='';
		return $rs;
	}
	
	protected function flowchangedata(){
		$this->rs['stateid'] = $this->rs['state'];
	}
	
	
	protected function flowdatalog($arr)
	{
		$isaddlog	= 0;
		$uid 		= $this->adminid;
		$ispingfen	= 0;
		$distid 	= ','.$this->rs['distid'].',';
		$zt 		= $this->rs['stateid'];
		if($this->contain($distid, ','.$this->adminid.',') && ($zt==0||$zt==2)){
			$isaddlog = 1;
		}
		
		$arr['isaddlog'] = $isaddlog; //是否可以添加日志记录
		$arr['state'] 	 = $this->rs['stateid'];
		
		//判断是否可以督导评分
		$where  = $this->ddwhere($uid);
		if($this->rows("`id`='$this->id' and `status`=1 and `mark`=0 $where")==1){
			$ispingfen		= 1;
		}
		$arr['ispingfen'] 	= $ispingfen; //是否可以评分
		$arr['score'] 		= $this->rs['score'];
		return $arr;
	}
	
	protected function flowsubmit($na, $sm)
	{
		//$this->push($this->rs['distid'], '', '[{type}]{title}');//提交给对应人提醒
		$this->push($this->rs['ddid'], '', '{optname}提交任务[{type}.{title}]分配给:{dist}，需要你督导','任务督导');//提醒给督导人员
		
		$zt  = 0;
		if(!isempt($this->rs['distid']))$zt = 3;//待执行的状态值
		$this->updatestatus($zt);
		
	}
	
	protected function flowaddlog($a)
	{
		//提交报告时发送给创建人和督导人员
		if($a['name']=='进度报告'){
			$state 	= $a['status'];
			$arr['state'] = $state;
			$cont = ''.$this->adminname.'添加[{type}.{title}]的任务进度,说明:'.$a['explain'].'';
			if($state=='1')$cont='[{type}.{title}]任务'.$this->adminname.'已完成';
			$toid 	= $this->rs['optid'];
			$ddid	= $this->rs['ddid'];
			if(!isempt($ddid))$toid.=','.$ddid.'';
			$this->push($toid, '任务', $cont);
			$this->update($arr, $this->id);
		}
		if($a['name']=='指派给'){
			$cname 	 = $this->rock->post('changename');
			$cnameid = $this->rock->post('changenameid');
			$state = '0';
			$arr['state'] 	= $state;
			$arr['distid'] 	= $cnameid;
			$arr['dist'] 	= $cname;
			$this->update($arr, $this->id);
			$this->push($cnameid, '任务', ''.$this->adminname.'指派任务[{type}.{title}]给你');
		}
		if($a['name'] == '任务评分'){
			$fenshu	 = (int)$this->rock->post('fenshu','0');
			$this->push($this->rs['distid'], '任务', ''.$this->adminname.'评分[{type}.{title}],分数('.$fenshu.')','任务评分');
			$this->update(array(
				'mark' => $fenshu
			), $this->id);
		}
	}
	
	private function ddwhere($uid)
	{
		$downid = m('admin')->getdown($uid, 1);
		$where  = 'and `ddid`='.$uid.'';
		if($downid!='')$where  = 'and (('.$uid.' in(`ddid`)) or (ifnull(`ddid`,\'0\')=\'0\' and `distid` in('.$downid.')) or (ifnull(`ddid`,\'0\')=\'0\' and `optid`='.$uid.'))';
		return $where;
	}
	
	protected function flowbillwhere($uid, $lx)
	{
		$where 	= 'and '.$this->rock->dbinstr('distid', $uid);
		if($lx=='def' || $lx=='wwc'){
			$where.=' and status not in(1)';
		}
		if($lx=='myall'){
			
		}
		if($lx=='all'){
			$where = '';
		}
		//已完成
		if($lx=='ywc'){
			$where.=' and status=1';
		}
		//未完成
		if($lx=='wcj'){
			$where = 'and optid='.$uid.'';
		}
		
		//下属任务
		if($lx=='down' || $lx=='xxrw'){
			$where  = 'and '.m('admin')->getdownwhere('`distid`', $uid, 1);
		}
		//督导
		if($lx=='dd'){
			$where  = $this->ddwhere($uid);
		}
		
		$key 	= $this->rock->post('key');
		$zt 	= $this->rock->post('zt');
		$projcetid 	= (int)$this->rock->post('projcetid');
		if($projcetid>0)$where.=' and `projectid`='.$projcetid.'';
		
		if($zt!='')$where.=' and `status`='.$zt.'';
		
		if(!isempt($key)){
			$where.=" and (`title` like '%$key%' or `type` like '%$key%' or `dist` like '$key%' or `grade` like '%$key%' or `projectid` in (select `id` from `[Q]project` where `title` like '%$key%'))";
		}
		
		return array(
			'where' => $where,
			'fields'=> 'id,type,grade,dist,startdt,title,enddt,`status`,state,optname,projectid,score,mark,ddname',
			'order' => '`optdt` desc'
		);
	}
	
	/**
	*	提醒快过期的任务
	*	$txsj 提前几天提醒
	*/
	public function tododay($txsj = 1)
	{
		$dtobj= c('date');
		$dt   = $this->rock->date;
		$rows = $this->getrows("`status`=1 and `state` in(0,2) and ifnull(`distid`,'')<>'' and `enddt`>='$dt'");
		$arr  = array();
		foreach($rows as $k=>$rs){
			$jg = $dtobj->datediff('d', $this->rock->date, $rs['enddt']);
			if($jg <= $txsj){
				$dista = explode(',', $rs['distid']);
				foreach($dista as $distid){
					if(!isset($arr[$distid]))$arr[$distid] = array();
					$tis = ''.$jg.'天后截止';
					if($jg == 0)$tis = '需今日完成';
					$arr[$distid][]= '['.$rs['type'].']'.$rs['title'].'('.$tis.');';
				}
			}
		}
		foreach($arr as $uid => $strarr){
			$this->flowweixinarr['url'] = $this->getwxurl();//设置微信提醒的详情链接
			$str = '';
			foreach($strarr as $k=>$str1){
				if($k>0)$str.="\n";
				$str.="".($k+1).".$str1";
			}
			if($str != '')$this->push($uid, '', $str, '任务到期提醒');
		}
	}
}