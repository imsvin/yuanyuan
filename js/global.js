function user_index_login(){
	$('#passport_password_msg').html('');
	$('#passport_username_msg').html('');
	var username = $('#passport_username').val();
	var password = $('#passport_password').val();
	var rememberMe = $('#passport_rememberMe').val();
	//var validated  = $('#passport_validated').val();
	if(username == '') {
		$('#passport_username_msg').html('请输入用户名');
		$('#passport_username').focus();
		return false;
	}

	if(password == '') {
		$('#passport_password_msg').html('请输入密码');
		$('#passport_password').focus();
		return false;
	}
	$('#loading_pic').show();
	$('#passport_login_submit_btn').attr('disabled','disabled');
	$.ajax({type:'POST',url:'/passport/login_sub?callback=?',cache: false,timeout:3000,dataType:'jsonp',data:{username : username, password : password,rememberMe : rememberMe},
		success:function(json){
			$('#loading_pic').hide();
			$('#passport_login_submit_btn').attr('disabled',false);
			if(json.result == 1) {
				location.href = '/';
				return;
			} else {
				if (json.result == 2) {
					$('#passport_username_msg').html(json.msg);
				} else if (json.result == 3) {
					$('#passport_password_msg').html(json.msg);
				}
				
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown){
			$('#loading_pic').hide();
			$('#passport_login_submit_btn').attr('disabled',false);
		}
	});
}


function user_index_reg(){
	$('#passport_password_msg').html('');
	$('#passport_username_msg').html('');
	$('#passport_email_msg').html('');
	var username = $('#passport_username').val();
	var password = $('#passport_password').val();
	var email = $('#passport_email').val();
	var listname = $('#passport_listname').val();
	$('#passport_username').focus();
	$('#loading_pic').show();
	$('#passport_reg_submit_btn').attr('disabled','disabled');
	$.ajax({type:'POST',url:'/passport/reg_sub?callback=?',cache: false,timeout:3000,dataType:'jsonp',data:{username : username, password : password,email : email,listname : listname},
		success:function(json){
			$('#loading_pic').hide();
			$('#passport_reg_submit_btn').attr('disabled',false);
			if(json.result == 1) {
				location.href = '/';
				return;
			} else {
				if (json.msg.e_username) {
					$('#passport_username_msg').html(json.msg.e_username);
				}
				
				if (json.msg.e_password) {
					$('#passport_password_msg').html(json.msg.e_password);
				}
				
				if (json.msg.e_email) {
					$('#passport_email_msg').html(json.msg.e_email);
				}
				
			}
		},
		error: function(XMLHttpRequest, textStatus, errorThrown){
			$('#loading_pic').hide();
			$('#passport_reg_submit_btn').attr('disabled',false);
		}
	});
}
