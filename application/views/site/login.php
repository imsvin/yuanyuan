<?php echo  $this->load->view("layouts/main.php");?>
<div id="left_content" >
<div class="c_form">
	<div class="formtable">
	<div class="caption">
		<h2>请登录</h2>
		<p>如果您在本站已拥有帐号，请使用已有的帐号信息直接进行登录即可，不需重复注册。</p>
	</div>


	<div class="login_menu">
		<div class="iteminbox">
			<div class="label">用户名</div> <div><input type="text" id="passport_username" onblur="checkUserName();" class="text"><span class="err_msg" id="passport_username_msg"></span></div>
		</div>

		<div class="iteminbox">
			<div class="label">密码</div> <div><input type="password" id="passport_password" onblur="checkPassWord();" class="text"><span class="err_msg" id="passport_password_msg"></span></div>
		</div>

		<div class="iteminbox">
			<div class="label"><img src="/images/ajax-loader.gif" id="loading_pic"></div><div><input id="passport_rememberMe" value="1" type="checkbox"><label for="passport_rememberMe">下次自动登录</label><input class="btn-submit" type="button" id="passport_login_submit_btn" value="登录" onclick="user_index_login()"></div>
		</div>
	</div>

	</div>
</div>
<div class="c_form">
<table cellpadding="0" cellspacing="0" class="formtable">
	<caption>
	<h2>还没有注册吗？</h2>
	<p>请先注册一个属于自己的帐号吧。最快只要十秒钟</p>
	</caption>
<tr>
<td>
	<a href="/site/register/" class="image_link" style="display: block; margin: 0 110px 2em; width: 200px; line-height: 30px; font-size: 14px; text-align: center; text-decoration: none;">
			<img src="/images/home_create_button.png" class="trans_png" alt="建立帳號" width="195" height="39">
	</a>
	</td>
	</tr>
	</table>
	</div>
</div>
<div id="right_content">

</div>

<?php echo  $this->load->view("layouts/footer");?>

