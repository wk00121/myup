<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	{params};
	var id = params.id;
	if(!id)id = 0;var setid=params.setid,statusstr='';
	var h = $.bootsform({
		window:false,rand:'{rand}',tablename:'flow_course',
		url:publicsave('{mode}','{dir}'),
		params:{otherfields:'optdt={now}'},
		submitfields:'setid,name,num,checktype,checktypeid,checktypename,checkfields,sort,whereid,explain,status,courseact,checkshu,recename,receid,pid,iszf',
		requiredfields:'name',
		success:function(){
			closenowtabs();
			try{guanflowcourselist.reload();}catch(e){}
		},
		load:function(a){
			js.setselectdata(h.form.whereid,a.wherelist,'id');
			statusstr=a.statusstr;
		},
		loadafter:function(a){
			c.changetype(0);
			if(a.data){
				
			}
		},
		submitcheck:function(d){
			if(d.checktype=='user'&&d.checktypeid=='')return '请选择人员';
			if(d.checktype=='rank'&&d.checktypename=='')return '请输入职位';
			return '';
		}
	});
	h.forminit();
	h.load(js.getajaxurl('loaddatacourse','{mode}','{dir}',{id:id,setid:setid}));
	var c = {
		getdist:function(o1, lx){
			var cans = {
				nameobj:h.form.checktypename,
				idobj:h.form.checktypeid,
				value:h.form.checktypeid.value,
				type:'usercheck',
				title:'选择人员'
			};
			js.getuser(cans);
		},
		clears:function(){
			h.form.checktypename.value='';
			h.form.checktypeid.value='';
		},
		changetype:function(lx){
			var v=h.form.checktype.value;
			$('#checktext_{rand}').html('');
			$('#checkname_{rand}').hide();
			if(lx==1){
				h.form.checktypename.value='';
				h.form.checktypeid.value='';
			}
			if(v=='rank'){
				$('#checktext_{rand}').html('请输入职位：');
				$('#checkname_{rand}').show();
			}
			if(v=='user'){
				$('#checktext_{rand}').html('请选择人员：');
				$('#checkname_{rand}').show();
			}
		},
		reloadhweil:function(){
			h.form.whereid.length = 1;
			h.load(js.getajaxurl('loaddatacourse','{mode}','{dir}',{id:id,setid:setid}));
		},
		getdists:function(o1, lx){
			var cans = {
				nameobj:h.form.recename,
				idobj:h.form.receid,
				type:'deptusercheck',
				title:'选择适用对象'
			};
			js.getuser(cans);
		},
		allqt:function(){
			h.form.recename.value='全体人员';
			h.form.receid.value='all';
		},
		removes:function(){
			h.form.recename.value='';
			h.form.receid.value='';
		},
		setstatus:function(){
			var val = h.form.courseact.value;
			var sha = [],vala;
			if(val)sha = val.split(',');
			var str = '<table width="100%"><tr><td align="center"  height="30" nowrap>动作值</td><td>动作名</td><td>动作颜色</td><td>处理后状态</td></tr>';
			if(statusstr=='')statusstr='待处理,已完成,不通过';
			var ztarr = statusstr.replace(/\?/g,'').split(',');
			for(var i=0;i<=6;i++){
				var na='',col='',naa,sel='',ove='';
				if(sha[i]){
					naa = sha[i].split('|');
					na  = naa[0];
					if(naa[1])col=naa[1];
					if(naa[2])ove=naa[2];
				}
				str+='<tr><td width="20%" align="center">'+(i+1)+'</td><td width="25%"><input maxlength="10" value="'+na+'" id="abc_xtname'+i+'" style="color:'+col+'" class="form-control"></td><td width="25%"><input class="form-control" maxlength="7" style="color:'+col+'" value="'+col+'"  id="abc_xtcol'+i+'"></td><td width="30%">';
				str+='<select class="form-control" id="abc_xscol'+i+'" value="'+col+'">';
				str+='<option value=""></option>';
				for(var j=0;j<ztarr.length;j++){
					sel=(ove!='' && ove==j)?'selected':'';
					str+='<option '+sel+' value="'+j+'">'+ztarr[j]+'</option>';
				}
				str+='</select></td></tr>';
			}
			str+='</table>';
			
			js.tanbody('sttts','['+h.form.name.value+']的状态设置',400,300,{
				html:'<div style="height:300px;overflow:auto;padding:5px">'+str+'</div>',
				btn:[{text:'确定'}]
			});
			$('#sttts_btn0').click(function(){
				c.setstatusok();
			});
		},
		setstatusok:function(){
			var str = '';
			for(var i=0;i<=6;i++){
				var na=get('abc_xtname'+i+'').value,col=get('abc_xtcol'+i+'').value,zts=get('abc_xscol'+i+'').value;
				if(!na)break;
				str+=','+na+'';
				if(col){
					str+='|'+col+'';
					if(zts)str+='|'+zts+'';
				}else{
					if(zts)str+='||'+zts+'';
				}
			}
			if(str!='')str=str.substr(1);
			h.form.courseact.value=str;
			js.tanclose('sttts');
		}
	};
	js.initbtn(c);
	
	if(id==0){
		h.form.setid.value=setid;
		h.form.pid.value=params.pid;	
	}
	
	$(h.form.checktype).change(function(){
		c.changetype(1);
	});
	backsheowe{rand}=function(s1,s2){
		h.setValue('where',s1);
		h.setValue('explain',s2);
	}
});

</script>

<div align="center">
<div  style="padding:10px;width:700px">
	
	
	<form name="form_{rand}">
	
		<input name="id" value="0" type="hidden" />
		<input name="setid" value="0" type="hidden" />
		<input name="pid" value="0" type="hidden" />
		
		<table cellspacing="0" border="0" width="100%" align="center" cellpadding="0">
		<tr>
			<td  align="right"  width="15%"><font color=red>*</font> 步骤名称：</td>
			<td class="tdinput"  width="35%"><input name="name" class="form-control"></td>
			<td  align="right"   width="15%">编号：</td>
			<td class="tdinput" width="35%"><input name="num" class="form-control"></td>
		</tr>
		
		<tr>
			<td  align="right" nowrap >步骤适用对象：</td>
		
			<td class="tdinput" colspan="3">
				<div style="width:100%" class="input-group">
					<input readonly class="form-control" placeholder="不选就适用全体人员" name="recename" >
					<input type="hidden" name="receid" >
					<span class="input-group-btn">
						<button class="btn btn-default" click="removes" type="button"><i class="icon-remove"></i></button>
						<button class="btn btn-default" click="getdists,1" type="button"><i class="icon-search"></i></button>
					</span>
				</div>
			</td>
		</tr>
		
		<tr>
			<td  align="right" nowrap ><a href="http://xh829.com/view_checklx.html" target="_blank">?审核人员类型</a>：</td>
			<td class="tdinput"><select class="form-control" name="checktype"><option value="">-类型-</option><option value="super">直属上级</option><option value="rank">职位</option><option value="user">指定人员</option><option value="dept">部门负责人</option><option value="auto">自定义(写代码上)</option><option value="apply">申请人</option><option value="opt">操作人</option><option value="change">由上步指定</option></select></td>
			
			<td align="right" id="checktext_{rand}" nowrap></td>
			<td class="tdinput" id="checkname_{rand}" style="display:none">
				<div class="input-group" style="width:100%">
					<input class="form-control"  name="checktypename" >
					<input type="hidden" name="checktypeid" >
					<span class="input-group-btn">
						<button class="btn btn-default" click="clears" type="button">×</button>
						<button class="btn btn-default" click="getdist,1" type="button"><i class="icon-search"></i></button>
					</span>
				</div>
				
			</td>
		</tr>
		
		
		<tr>
			<td  align="right" >审核条件：</td>
			<td class="tdinput"><select class="form-control" name="whereid"><option value="0">无条件</option></select></td>
			<td colspan="2"><a click="reloadhweil" href="javascript:;">[刷新]</a></td>
		</tr>
		<tr>
			<td  align="right" ></td>
			<td colspan="3" style="padding-bottom:10px"><font color=#888888>在【流程模块条件】上添加，满足此条件才需要此步骤</font></td>
		</tr>

		
		<tr>
			<td  align="right" >审核动作：</td>
			<td class="tdinput" colspan="3"><input name="courseact" class="form-control"><div style="padding-top:0px" class="tishi"><a href="javascript:;" click="setstatus">[设置]</a>默认是：通过,不通过。多个,分开</div></td>
		</tr>
		
		<tr>
			<td  align="right" >审核处理表单：</td>
			<td class="tdinput" colspan="3"><input name="checkfields" class="form-control"><div style="padding-top:0px" class="tishi">需要处理表单元素必须在【表单元素管理】上，输入字段名，多个用, 分开</div></td>
		</tr>
		<tr>
			<td  align="right" >说明：</td>
			<td class="tdinput" colspan="3"><textarea  name="explain" style="height:60px" class="form-control"></textarea></td>
		</tr>
		
		
		<tr>
			<td align="right">排序号：</td>
			<td class="tdinput"><input name="sort" value="0" maxlength="3" type="number"  onfocus="js.focusval=this.value" onblur="js.number(this)" class="form-control"></td>
			
			<td  align="right" nowrap >审核人数：</td>
			<td class="tdinput"><select class="form-control" name="checkshu"><option value="0">需全部审核</option><option value="1" selected>至少一人</option><option value="2">至少2人</option></select></td>
			
			
		</tr>
		
		<tr>
			<td  align="right" ></td>
			<td class="tdinput" colspan="3">
				<label><input name="status" value="1" checked type="checkbox"> 启用</label>&nbsp; &nbsp; 
				<label><input name="iszf" value="1" type="checkbox">是否可转给他人办理</label>
			</td>
		</tr>
		
		
		<tr>
			<td  align="right"></td>
			<td style="padding:15px 0px" colspan="3" align="left"><button disabled class="btn btn-success" id="save_{rand}" type="button"><i class="icon-save"></i>&nbsp;保存</button>&nbsp; <span id="msgview_{rand}"></span>&nbsp;<a href="http://xh829.com/view_course.html" target="_blank">[看帮助]</a>
		</td>
		</tr>
		
		</table>
		</form>
</div>
</div>