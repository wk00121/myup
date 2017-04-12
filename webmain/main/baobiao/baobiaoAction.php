<?php
class baobiaoClassAction extends Action
{


	public function baobiaoafter($table, $rows)
	{
		$log 	= m('log');
		foreach($rows as $k=>$rs){
			$zt = $log->isread('baobiao', $rs['id'], $this->adminid);
			$status = 1;
			if($zt>0)$status=0;
			$rows[$k]['status']		= $status;
			$dt 	= $rs['dt'];
			if($rs['type']!=0 && !isempt($rs['enddt'])){
				$dt.='<br><font color="#aaaaaa">'.$rs['enddt'].'</font>';
			}
			$rows[$k]['dt']		= $dt;
		}
		return array('rows'=>$rows);
	}
}