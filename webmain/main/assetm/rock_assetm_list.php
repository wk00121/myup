<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params};
	var num = params.num,pid,optlx=0;
	var typeid=0,sspid=0;
	var at = $('#optionview_{rand}').bootstree({
		url:js.getajaxurl('gettreedata','option','system',{'num':'assetstype'}),
		columns:[{
			text:'资产分类',dataIndex:'name',align:'left',xtype:'treecolumn',width:'79%'
		},{
			text:'ID',dataIndex:'id',width:'20%'
		}],
		load:function(d){
			if(sspid==0){
				typeid = d.pid;
				sspid = d.pid;
				c.loadfile('0','所有资产');
			}
		},
		itemdblclick:function(d){
			typeid = d.id;
			c.loadfile(d.id,d.name);
		},
		itemclick:function(d){
			c.ismoveok(d);
		}
	});;
	var modenum='assetm';
	var a = $('#view_{rand}').bootstable({
		tablename:modenum,celleditor:true,autoLoad:false,modenum:modenum,fanye:true,
		columns:[{
			text:'',dataIndex:'caozuo'
		},{
			text:'资产名称',dataIndex:'title',editor:false,align:'left'
		},{
			text:'编号',dataIndex:'num'
		},{
			text:'操作时间',dataIndex:'optdt'
		},{
			text:'状态',dataIndex:'state'
		},{
			text:'品牌',dataIndex:'brand'
		},{
			text:'仓库',dataIndex:'ckid'
		},{
			text:'使用人',dataIndex:'usename'
		}],
		itemclick:function(){
			
		},
		beforeload:function(){
			
		}
	});

	var c = {
		reload:function(){
			at.reload();
		},
		loadfile:function(spd,nsd){
			$('#megss{rand}').html(nsd);
			a.setparams({'typeid':spd}, true);
		},
		genmu:function(){
			typeid = sspid;
			at.changedata={};
			this.loadfile('0','所有资产');
		},
		clicktypeeidt:function(){
			var d = at.changedata;
			if(d.id)c.clicktypewin(false, 1, d);
		},
		clicktypewin:function(o1, lx, da){
			var h = $.bootsform({
				title:'资产分类',height:250,width:300,
				tablename:'option',labelWidth:50,
				isedit:lx,submitfields:'name,sort,pid',cancelbtn:false,
				items:[{
					labelText:'名称',name:'name',required:true
				},{
					labelText:'上级id',name:'pid',value:0,type:'hidden'
				},{
					labelText:'排序号',name:'sort',type:'number',value:0
				}],
				success:function(){
					if(optlx==0)at.reload();
					if(optlx==1)a.reload();
				}
			});
			if(lx==1)h.setValues(da);
			if(lx==0)h.setValue('pid', typeid);
			optlx = 0;
			return h;
		},
		typedel:function(o1){
			at.del({
				url:js.getajaxurl('deloption','option','system'),params:{'stable':'assetm'}
			});
		},
		del:function(){
			a.del();
		},
		daochu:function(){
			a.exceldown(nowtabs.name);
		},
		adds:function(){
			openinput('固定资产',modenum);
		},
		search:function(){
			var s=get('key_{rand}').value;
			a.setparams({key:s},true);
		},
		movedata:false,
		move:function(){
			var d = at.changedata;
			if(!d){js.msg('msg','没有选中行');return;}
			this.movedata = d;
			js.msg('success','请在5秒内选择其他分类确认移动');
			clearTimeout(this.cmoeefese);
			this.cmoeefese=setTimeout(function(){c.movedata=false;},5000);
		},
		ismoveok:function(d){
			var md = this.movedata;
			if(md && md.id!=d.id){
				js.confirm('确定要将['+md.name+']移动到['+d.name+']下吗？',function(jg){
					if(jg=='yes'){
						c.movetoss(md.id,d.id,0);
					}
				});
			}
		},
		moveto:function(){
			var d = at.changedata;if(!d)return;
			js.confirm('确定要将['+d.name+']移动到顶级吗？',function(jg){
				if(jg=='yes'){
					c.movetoss(d.id,sspid,1);
				}
			});
		},
		movetoss:function(id,toid,lx){
			js.ajax(js.getajaxurl('movetype','option','system'),{'id':id,'toid':toid,'lx':lx},function(s){
				if(s!='ok'){
					js.msg('msg', s);
				}else{
					at.reload();
				}
			},'get',false, '移动中...,移动成功');
			c.movedata=false;
		}
	};
	js.initbtn(c);
	$('#optionview_{rand}').css('height',''+(viewheight-70)+'px');
});
</script>


<table width="100%">
<tr valign="top">
<td width="220">
	<div style="border:1px #cccccc solid">
	  <div id="optionview_{rand}" style="height:400px;overflow:auto;"></div>
	  <div  class="panel-footer">
		<a href="javascript:" title="新增"  click="clicktypewin,0" onclick="return false"><i class="icon-plus"></i></a>&nbsp; &nbsp; 
		<a href="javascript:" title="编辑" click="clicktypeeidt" onclick="return false"><i class="icon-edit"></i></a>&nbsp; &nbsp; 
		<a href="javascript:" title="删除" click="typedel" onclick="return false"><i class="icon-trash"></i></a>&nbsp; &nbsp; 
		<a href="javascript:" title="刷新" click="reload" onclick="return false"><i class="icon-refresh"></i></a>&nbsp; &nbsp; 
		<a href="javascript:" title="移动" click="move" onclick="return false"><i class="icon-move"></i></a>&nbsp; &nbsp; 
		<a href="javascript:" title="移动到顶级" click="moveto" onclick="return false"><i class="icon-arrow-up"></i></a>
	  </div>
	</div>  
</td>
<td width="10"></td>
<td>	
	<div>
	<table width="100%"><tr>
		<td align="left" nowrap>
			<button class="btn btn-primary" click="adds"  type="button"><i class="icon-plus"></i> 新增</button>&nbsp; 
			<button class="btn btn-default" click="genmu"  type="button">所有资产</button>&nbsp; 
			
		</td>
		
		<td style="padding-left:10px">
		<input class="form-control" style="width:200px" id="key_{rand}"   placeholder="资产名称/编号/使用人">
		</td>
		<td style="padding-left:10px">
			<button class="btn btn-default" click="search" type="button">搜索</button> 
		</td>
		<td width="90%">
			&nbsp;&nbsp;<span id="megss{rand}"></span>
		</td>
		<td align="right">
			<button class="btn btn-default"  click="daochu" type="button">导出</button>
		</td>
	</tr></table>
	</div>
	<div class="blank10"></div>
	<div id="view_{rand}"></div>
</td>
</tr>
</table>
