<?php if(!defined('HOST'))die('not access');?>
<script >
$(document).ready(function(){
	var c={
		yulan:function(){
			var cont = mobjs.val(),s='',a,a1,i,j,oi=0;
			s+='<table class="basetable" border="1">';
			s+='<tr><td></td><td>*帐号</td><td>*姓名</td><td>性别</td><td>职位</td><td>部门</td><td>手机号</td><td>邮箱</td><td>电话</td><td>上级主管</td></tr>';
			a = cont.split('\n');
			for(i=0;i<a.length;i++){
				if(a[i]){
					oi++;
					a1 = a[i].replace(/[ ]/g,'').split('	');
					s+='<tr>';
					s+='<td>'+oi+'</td>';
					for(j=0;j<a1.length;j++)s+='<td>'+a1[j]+'</td>';
					s+='</tr>';
				}
			}
			s+='</table>';
			$('#showview_{rand}').html(s);
		},
		downss:function(){
			js.open('upload/base/userimport.xls');
		},
		insrtss:function(){
			var val = mobjs.val();
			mobjs.val(val+'	');
			mobjs.focus();
		},
		saveadd:function(){
			var val = mobjs.val();
			var vis = 'msgview_{rand}';
			if(isempt(val)){
				js.setmsg('没有输入任何东西','', vis);
				return;
			}
			js.setmsg('处理中...','', vis);
			js.ajax(js.getajaxurl('saveadminpl','{mode}','{dir}'),{importcont:val},function(ds){
				if(ds.success){
					js.msg('success', ds.msg);
					closenowtabs();
					try{adminusermanage.reload();}catch(e){}
				}else{
					js.setmsg(ds.msg,'', vis);
				}
			},'post,json');
		}
	}
	var mobjs = $('#maincont_{rand}');
	mobjs.keyup(function(){
		c.yulan();
	});
	
	
	onpasteuserman = function(event){
		c.yulan();
	}
	js.initbtn(c);
});
</script>

<div align="left">
<div>请根据Excel格式添加数据，用户名和姓名不能重复，并复制到下面文本框中，<a click="downss" href="javascript:;">下载导入Excel表格格式</a><br>也可以手动输入，多行代表多记录，整行字段用	分开，<a click="insrtss" href="javascript:;">插入间隔符</a></div>
<div><textarea style="height:250px;" onpaste="onpasteuserman(event)" id="maincont_{rand}" class="form-control"></textarea></div>
<div id="showview_{rand}"></div>
<div style="padding:10px 0px"><a click="yulan" href="javascript:;">[预览]</a>&nbsp; &nbsp; <button class="btn btn-success"click="saveadd" type="button">提交添加</button>&nbsp; <span id="msgview_{rand}"></span></div>
<div class="tishi">请严格按照规定格式添加，否则数据将错乱哦，更多字段请二次开发哦</div>
</div>