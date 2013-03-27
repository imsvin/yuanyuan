<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_lib {
	private $auth_key = 'eqqXje6m*JKu*eyOJ1%&$S3iMZ)eqN5u';
	private $strict = false; //严格模式判断是否登录，会检查浏览器user_agent,IP地址变化等

	public function init_login() {
		if (session_id() == '' && !session_start()) die("Session Start Fail!");
		if (empty($_COOKIE['PP_USER']) || empty($_COOKIE['PP_AUTH'])) {
			$this->unset_login_session();
			return false;
		}

		if (!empty($_SESSION['PP_AUTH']) && ($_COOKIE['PP_AUTH'] === $_SESSION['PP_AUTH']) && ($_COOKIE['PP_AUTH'] == $this->_info_auth($_COOKIE['PP_USER']))) {
			return true;
		} else {
			if($_COOKIE['PP_AUTH'] != $this->_info_auth($_COOKIE['PP_USER'])) {
				$this->unset_login_session();
				return false;
			}

			$user_info_tmp = gzuncompress(base64_decode($_COOKIE['PP_USER']));
			parse_str($user_info_tmp,$user_info);
			if(!is_array($user_info)) {
				$this->unset_login_session();
				return false;
			}

			foreach($user_info as $key => $value) {
				$_SESSION[$key] = rawurldecode($value);
			}
			$_SESSION['PP_AUTH'] = $_COOKIE['PP_AUTH'];
			return true;
		}
	}

	public function set_login_cookie($uid, $login_expried_time = 0) {
		$CI = &get_instance();
		$CI->load->model('user_model');
		$result = $CI->user_model->get_by_uid($uid);
		if(empty($result)) return false;	//取用户信息失败
		unset($result['password']);

		$userinfo = array(
			'PP_UID'			=>	$result['uid'],
			'PP_NICKNAME'		=>	$result['username'],
			'PP_SYSTIME'		=>	microtime(true), //这个值会确保用户信息未变化的情况下，每次生成的PP_AUTH值都是不一样的
		);

		$package = '';
		foreach($userinfo as $key => $value) {
			$package .= '&' . $key . '=' . urlencode($value);
		}

		$package = base64_encode(gzcompress($package, 9));
		$info_auth = $this->_info_auth($package);
		$cookie_domain = $this->get_cookid_domain();

		setcookie('PP_AUTH', $info_auth, $login_expried_time, '/', $cookie_domain);
		setcookie('PP_USER', $package, $login_expried_time, '/', $cookie_domain);
		return true;
	}

	public function unset_login_session() {
		$session_key = array(
			'PP_AUTH',
			'PP_UID',
			'PP_NICKNAME',
			'PP_APPUSER',
			'PP_SYSTIME'
		);
		foreach($session_key as $skey) {
			unset($_SESSION[$skey]);
		}
		return true;
	}

	public function logout() {
		$cookie_domain = $this->get_cookid_domain();

		$expried = time() - 86400;
		setcookie('PP_AUTH', '', $expried, '/', $cookie_domain);
		setcookie('PP_USER', '', $expried, '/', $cookie_domain);
		return true;
	}

	public function get_cookid_domain() {
		if(strpos($_SERVER['HTTP_HOST'], '.') == strrpos($_SERVER['HTTP_HOST'], '.')) {
			return '.' . $_SERVER['HTTP_HOST'];
		} else {
			return substr($_SERVER['HTTP_HOST'], strpos($_SERVER['HTTP_HOST'], '.'));
		}
	}

	private function _info_auth($userinfo_package) {
		if($this->strict) {
			$CI = &get_instance();
			return sha1(md5($userinfo_package . $this->auth_key . $CI->input->server('HTTP_USER_AGENT') . $CI->input->ip_address()));
		} else {
			return sha1(md5($userinfo_package . $this->auth_key));
		}
	}


}