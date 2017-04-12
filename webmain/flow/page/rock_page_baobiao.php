<?php
/**
*	模块：baobiao.报表，
*	说明：自定义区域内可写您想要的代码，模块列表页面，生成分为2块
*	来源：http://xh829.com/
*/
defined('HOST') or die ('not access');
?>
<script>
$(document).ready(function(){
	{params}
	var modenum = 'baobiao',modename='报表',modeid='56',atype = params.atype;
	if(!atype)atype='';
	//常用操作c方法
	var c = {
		//刷新
		reload:function(){
			a.reload();
		},
		//新增编辑窗口
		clickwin:function(o1,lx){
			var id=0;
			if(lx==1)id=a.changeid;
			openinput(modename,modenum,id);
		},
		//打开详情
		view:function(){
			var d=a.changedata;
			openxiangs(modename,modenum,d.id);
		},
		searchbtn:function(){
			this.search({});
		},
		//搜索
		search:function(cans){
			var s=get('key_{rand}').value;
			var canss = js.apply({key:s}, cans);
			a.setparams(canss,true);
		},
		//高级搜索
		searchhigh:function(){
			new highsearchclass({
				modenum:modenum,
				oncallback:function(d){
					c.searchhighb(d);
				}
			});
		},
		searchhighb:function(d){
			d.key='';
			get('key_{rand}').value='';
			a.setparams(d,true);
		},
		//导出
		daochu:function(){
			a.exceldown();
		},
		//对应控制器返回rul
		getacturl:function(act){
			return js.getajaxurl(act,'mode_baobiao|input','flow');
		},
		//查看切换
		changatype:function(o1,lx){
			$("button[id^='changatype{rand}']").removeClass('active');
			$('#changatype{rand}_'+lx+'').addClass('active');
			a.setparams({atype:lx},true);
			nowtabssettext($(o1).html());
		},
		init:function(){
			$('#changatype{rand}_'+atype+'').addClass('active');
			this.initpage();
		},
		initpage:function(){
			
		}
	};	
	
	//表格参数设定
	var bootparams = {
		fanye:true,modenum:modenum,modename:modename,
		url:c.getacturl('publicstore'),storeafteraction:'storeaftershow',
		params:{atype:atype},
		columns:[{text:"报表类型",dataIndex:"type"},{text:"操作人",dataIndex:"optname"},{text:"评分分数",dataIndex:"mark"},{text:"项目名称",dataIndex:"itemn"},{text:"岗位名称",dataIndex:"position"},{text:"项目分类",dataIndex:"item"},{text:"清算金额",dataIndex:"liquida"},{text:"清算笔数",dataIndex:"liquidc"},{text:"银联收入",dataIndex:"upincome"},{text:"环比",dataIndex:"ring"},{text:"同比",dataIndex:"year"},{text:"优先级",dataIndex:"priority"},{text:"现状",dataIndex:"ustatus",align:"left"},{text:"下阶段进展及存在问题",dataIndex:"nextstage",align:"left"},{text:"责任人",dataIndex:"respond"},{text:"配合人",dataIndex:"helper"},{text:"备注",dataIndex:"remark"},{text:"日期",dataIndex:"dt"},{text:"截止日期",dataIndex:"enddt"},{
			text:'',dataIndex:'caozuo'
		}],
		itemdblclick:function(){
			c.view();
		},
		itemclick:function(){
			get('xiang_{rand}').disabled=false;
		},
		beforeload:function(){
			get('xiang_{rand}').disabled=true;
		}
	};
	
//[自定义区域start]



//[自定义区域end]

	js.initbtn(c);//初始化绑定按钮方法
	var a = $('#viewbaobiao_{rand}').bootstable(bootparams);//加载表格
	c.init();
});
</script>
<!--SCRIPTend-->
<!--HTMLstart-->
<div>
	<table width="100%">
	<tr>
		<td style="padding-right:10px;"><button class="btn btn-primary" click="clickwin,0" type="button"><i class="icon-plus"></i> 新增</button></td>
		<td>
			<input class="form-control" style="width:160px" id="key_{rand}" placeholder="搜索关键词">
		</td>
		<td style="padding-left:10px">
			<button class="btn btn-default" click="searchbtn" type="button">搜索</button> 
		</td>
		<td style="padding-left:10px">
			<button class="btn btn-default" click="searchhigh" type="button">高级搜索</button> 
		</td>
		<td  width="90%" style="padding-left:10px"></td>
	
		<td align="right" nowrap>
			<button class="btn btn-default" id="xiang_{rand}" click="view" disabled type="button">详情</button> &nbsp; 
			<button class="btn btn-default" click="daochu,1" type="button">导出</button> 
		</td>
	</tr>
	</table>
</div>
<div class="blank10"></div>
<div id="viewbaobiao_{rand}"></div>
<!--HTMLend-->