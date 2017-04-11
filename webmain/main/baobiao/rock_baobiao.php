<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params}
	var atype=params.atype;
	var modenum = 'baobiao';
	var a = $('#view_{rand}').bootstable({
		tablename:modenum,params:{'atype':atype},fanye:true,modenum:modenum,
		modedir:'{mode}:{dir}',storeafteraction:'baobiaoafter',
		columns:[{
			text:'',dataIndex:'caozuo'
		},{
			text:'项目分类',dataIndex:'item'
		},{
			text:'岗位名称',dataIndex:'position'
		},{
			text:'项目名称',dataIndex:'itemn'
		},{
			text:'清算金额',dataIndex:'liquida'
		},{
			text:'清算笔数',dataIndex:'liquidc'
		},{
			text:'银联收入',dataIndex:'upincome'
		},{
			text:'交易量环比变化',dataIndex:'ring',align:'left'
		},{
			text:'交易量同比变化',dataIndex:'year',align:'left'
		},{
			text:'优先级',dataIndex:'priority',align:'left',sortable:true,renderer:function(v){
				return v.replace(' ','<br>');
			}
		},{
			text:'现状',dataIndex:'status',align:'left'
		},{
			text:'下阶段进展及存在问题',dataIndex:'nextstage',align:'left'
		},{
			text:'责任人',dataIndex:'respond'
		},{
			text:'配合人',dataIndex:'helper'
		},{
			text:'备注',dataIndex:'remark'
		},{
			text:'新增时间',dataIndex:'adddt',sortable:true,renderer:function(v){
				return v.replace(' ','<br>');
			}
		},{
			text:'操作时间',dataIndex:'optdt',sortable:true,renderer:function(v){
				return v.replace(' ','<br>');
			}
		}],
		itemclick:function(){
			btn(false);
		},
		beforeload:function(){
			btn(true);
		}
	});
	
	function btn(bo){
		get('xiang_{rand}').disabled = bo;
	}
	
	var c = {
		del:function(){
			a.del();
		},
		reload:function(){
			a.reload();
		},
		view:function(){
			var d=a.changedata;
			openxiangs('工作报表',modenum,d.id);
		},
		search:function(){
			a.setparams({
				key:get('key_{rand}').value,
				dt:get('dt2_{rand}').value,
				type:get('type_{rand}').value
			},true);
		},
		daochu:function(){
			a.exceldown(nowtabs.name);
		},
		clickwin:function(o1,lx){
			var id=0;
			if(lx==1)id=a.changeid;
			openinput('工作报表', modenum,id);
		},
		clickdt:function(o1, lx){
			$(o1).rockdatepicker({initshow:true,view:'date',inputid:'dt'+lx+'_{rand}'});
		}
	};
	js.initbtn(c);
	if(atype!='my')$('#tsdsse{rand}').hide();
});
</script>
<div>
	<table width="100%">
	<tr>
	<td id="tsdsse{rand}" style="padding-right:10px">
		<button class="btn btn-primary" click="clickwin,0" type="button"><i class="icon-plus"></i> 新增</button>
	</td>
	<td>
		<input class="form-control" style="width:180px" id="key_{rand}"  placeholder="内容/人员/部门">
	</td>
	<td  style="padding-left:10px">
		<div style="width:140px"  class="input-group">
			<input placeholder="日期" readonly class="form-control" id="dt2_{rand}" >
			<span class="input-group-btn">
				<button class="btn btn-default" click="clickdt,2" type="button"><i class="icon-calendar"></i></button>
			</span>
		</div>	
	</td>
	<td style="padding-left:10px">
		<select class="form-control" id="type_{rand}" style="width:100px"><option value="">所有类型</option><option value="0">工作报表</option><option value="1">周报</option><option value="2">月报</option><option value="3">年报</option></select>
	</td>
	<td style="padding-left:10px">
		<button class="btn btn-default" click="search" type="button">搜索</button> 
	</td>
	<td style="padding-left:10px">
		
	</td>
	<td width="80%"></td>
	<td align="right" nowrap>
		<button class="btn btn-default" id="xiang_{rand}" click="view" disabled type="button">详情</button> &nbsp; 
		<button class="btn btn-default" click="daochu,1" type="button">导出</button> 
	</td>
	</tr>
	</table>
	
</div>
<div class="blank10"></div>
<div id="view_{rand}"></div>
<div class="tishi">提示：灰色标识已读了</div>
