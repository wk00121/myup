<?php
class flow_kqdwClassModel extends flowModel
{
	public function initModel()
	{
		$this->dateobj = c('date');
	}
	
	//打开详情时跳转到地理位置显示
	protected function flowchangedata()
	{
		$url = 'index.php?m=kaoqin&a=location&d=main&id='.$this->id.'';
		$this->rock->location($url);
		exit();
	}
	
	/**
	*	显示条件过滤
	*/
	protected function flowbillwhere($uid, $lx)
	{
		$atype	= $lx;
		$dt1	= $this->rock->post('dt1');
		$dt2	= $this->rock->post('dt2');
		$key	= $this->rock->post('key');
		$s 		= '';
		$s		= ' and b.id='.$this->adminid.'';
		
		//全部下属打卡
		if($lx=='down'){
			$s  = 'and '.m('admin')->getdownwheres('b.id', $uid, 0);
		}
		if($atype=='all')$s ='';
		if(!isempt($dt1))$s.=" and a.`optdt`>='$dt1'";
		if(!isempt($dt2))$s.=" and a.`optdt`<='$dt2 23:59:59'";
		if(!isempt($key))$s.=m('admin')->getkeywhere($key, 'b.');
		$fields = 'a.*,b.name,b.deptname';
		$tabls  = $this->mtable;
		
		$table  = '`[Q]'.$tabls.'` a left join `[Q]admin` b on a.uid=b.id';
		return array(
			'where' => $s,
			'table' => $table, 
			'order' => 'a.`id` desc',
			'fields'=> $fields
		);
	}
	
	//替换
	public function flowrsreplace($rs, $lx=0)
	{
		$week 		= $this->dateobj->cnweek($rs['optdt']);
		$rs['week'] = $week;
		if($week=='六' || $week=='日')$rs['ishui']= 1;
		return $rs;
	}
}