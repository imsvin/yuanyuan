<?php $this->pageTitle=Yii::app()->name . ' - Register'; ?>
<div id="left_content" >


<div  class="formtable">
	<div class="caption">
	<h2>注册本站帐号</h2>
	<p>请完整填写以下信息进行注册。</p>
	</div>

	<div class="login_menu">
		<div class="iteminbox">
			<div class="label">名  字</div> <div><input type="text" id="passport_username" onblur="checkUserName();" class="text"><span class="err_msg" id="passport_username_msg"></span></div>
		</div>

		<div class="iteminbox">
			<div class="label">密  码</div> <div><input type="password" id="passport_password" onblur="checkPassWord();" class="text"><span class="err_msg" id="passport_password_msg"></span></div>
		</div>

		<div class="iteminbox">
			<div class="label">邮 箱</div> <div><input type="text" id="passport_email" class="text" onblur="checkEmail();" /><span class="err_msg" id="passport_email_msg"></span></div>
		</div>

		<div class="iteminbox">
			<div class="label">清单名称</div><div><input type="text" id="passport_listname"  class="text" value="我要完成的100件事" /><span class="err_msg" id="passport_listname_msg"></span></div>
		</div>
		<div class="iteminbox">
			<div class="label"><img src="/images/ajax-loader.gif" id="loading_pic"></div><div><input type="button" id="passport_reg_submit_btn" onclick="user_index_reg()" value="注册新用户" class="btn-submit"></div>
		</div>

	</div>
</div>


	<div class="c_form">
	<table class="formtable">
	<caption>
	<h2>已有帐号？</h2>

	</caption>
	<tbody><tr>
	<td>
	<a href="do.php?ac=6dfcf947f9bb8cce6bd56fc2cad8293d" style="display: block; margin: 0 110px 2em; width: 100px; border: 1px solid #486B26; background: #76A14F; line-height: 30px; font-size: 14px; text-align: center; text-decoration: none;"><strong style="display: block; border-top: 1px solid #9EBC84; color: #FFF; padding: 0 0.5em;">立即登录</strong></a>
	</td>
	</tr>
	</tbody></table>
	</div>


</div>
<div id="right_content">





</div>

<script>
function checkUserName(){
	var _account = $("#passport_username").val();
	if (_account == "") {
		$('#passport_username_msg').html('帐号是必填的');
		return false;
	}
	$('#passport_username_msg').html('<img src="http://img1.zhubo123.com/images/correct.gif" />');
	return false;


	$.getJSON('/passport/check_index_account?callback=?',{account : _account},function(json){
		if(json.result == 1) {
			$('#passport_username_msg').html('<img src="http://img1.zhubo123.com/images/correct.gif" style="margin-top: 8px;" />');
		} else{
			$('#userNote').html(json.msg);
		}
	}, 'json');
}

function checkPassWord(){
	var _pw = $('#passport_password').val();
	if (_pw == "") {
		$("#passport_password_msg").html('密码是必填的');
		return false;
	}
	if(_pw.length<6 || _pw.length>12){
		$("#passport_password_msg").html('密码长度不正确，必须是6-12个字符');
		return false;
	}
	$('#passport_password_msg').html('<img src="http://img1.zhubo123.com/images/correct.gif"/>');

}

function checkEmail() {
	var _email = $('#passport_email').val();
	if (_email == "") {
		$("#passport_email_msg").html('邮箱是必填的');
		return false;
	}

	$('#passport_email_msg').html('<img src="http://img1.zhubo123.com/images/correct.gif"/>');
}


</script>