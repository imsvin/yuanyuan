<?php

class passport extends CI_Controller
{

	// 独立登录提交
	public function login_sub() {

		$callback = $this->input->get('callback');
		if ($this->uid) {
			echo jsonp_return($callback, RESPONSE_OK);
			return;
		}
		$account = $this->input->post('username');
		$password = $this->input->post('password');

		// 校验
		if (!$account || !$password ) {
			echo jsonp_return($callback, RESPONSE_PARAMS_ERROR, '你的输入不正确');
			return;
		}


		$this->load->model('user_model');
		$this->load->library('login_lib');

		$select_par = array('username' => $account);

		$query = $this->db->get_where("user", $select_par);
		if($query->num_rows() == 0) {
			echo jsonp_return($callback, 2, '此用户不存在');
			return;
		}

		$userinfo = $query->row_array();
		if ($userinfo['password'] != md5($password)) {
			echo jsonp_return($callback, 3, '密码错误');
			return;
		}

		// 成功了
		$ip = $this->input->ip_address();
		$time = time();

		$uid = $userinfo['uid'];

		$old_userinfo = $this->user_model->get_by_uid($uid);
		$update = array(
				'lastLoginIp' 		=>	$ip,
				'lastLoginTime' 	=>	date('Y-m-d H:i:s', $time),
		);

		$this->user_model->update($uid, $update);

		$this->login_lib->set_login_cookie($uid);
		echo jsonp_return($callback, RESPONSE_OK);
	}


	public function reg_sub() {
		$callback = $_GET['callback'];

		// 校验
		$form=new RegForm;
		$form->attributes=$_POST;
		if(!$form->validate())
		{
			$e_username = $form->getError('username');
			$e_password = $form->getError('password');
			$data = array(
				'e_username' => 	$form->getError('username'),
				'e_password' =>		$form->getError('password'),
				'e_email' =>		$form->getError('email'),
				'e_listname' =>		$form->getError('listname'),
			);
			echo jsonp_return($callback, RESPONSE_PARAMS_ERROR,$data);
			return ;
		}
		echo jsonp_return($callback, RESPONSE_PARAMS_ERROR,array('e_username' => '现在不给注册～'));
		return ;
		//事物
		$transaction = Yii::app()->db->beginTransaction();
		// 注册
		$user = new user();
		$user->attributes = $form->attributes;
		$user->regIp = Yii::app()->request->userHostAddress;
		$user->regTime = date('Y-m-d H:i:s');
		$user->save();
		if(!empty($user->errors)){
			$e_username = $form->getError('username');
			$e_password = $form->getError('password');
			$data = array(
				'e_username' => 	$user->getError('username'),
				'e_password' =>		$user->getError('password'),
				'e_email' =>		$user->getError('email'),
				'e_listname' =>		$user->getError('listname'),
			);
			echo jsonp_return($callback, RESPONSE_PARAMS_ERROR,$data);
			return ;
		}

		// 新建一个planlist
		$listname = $_POST['listname'] ? $_POST['listname'] : '我的清单';
		$plan = new Plan_Model;
		$plan->attributes = array('uid'=>$user->attributes['userid'],'content'=>$_POST['listname'], 'planlist_id' => 0);
		$plan->save();
		//print_r($plan->errors);
		// 提交事务
		$transaction->commit();

		// 登录
		$form=new LoginForm;
		$form->attributes=$_POST;
		$form->validate();

		echo jsonp_return($callback, RESPONSE_OK);
		return ;

	}

	public function check_index_username() {

	}


}
