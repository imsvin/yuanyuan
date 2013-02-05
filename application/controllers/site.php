<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends MY_Controller {

	function __construct() {
		parent::__construct(true,false);
	}

	public function index()
	{
		$this->load->view('site/index');
	}

	public function login() {
		$this->load->view('site/login');
	}

	public function logout() {
		$this->load->library('login_lib');
		$this->login_lib->logout();
		header("location: /");
	}

	public function douban() {
		//$url = $this->input->post('url');
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://douban.fm/j/mine/playlist?type=n&h=&channel=2&from=radio');        // 请求的URL
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_REFERER, "http://douban.fm/swf/53041/fmplayer.swf?0.6961411843076348");
		// curl_setopt($ch, CURLOPT_POST, true );           // 如果POST则加上
		// curl_setopt($ch, CURLOPT_POSTFIELDS, $vars );     // 如果POST则加上
		curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 86400 ); // DNS缓存超时时间
		$post = curl_exec($ch);
		curl_close($ch);
		var_dump($post);exit;
		$post = json_decode($post,true);
	}

	public function curl_test() {
		$urls = $this->input->post('urls');
		$files = $this->input->post('files');

		$urls = json_decode($urls);
		$files = json_decode($files);

		$this->load->helpers('vdisk_helper');
		$appkey = 2351281750;
		$appsecret = 'ad6de19a2e93c6778103bc9846855a50';
		$username = '362758578@qq.com';
		$password = '1212123abc';

		$vdisk = new vDisk($appkey, $appsecret);
		$vdisk->get_token($username, $password, 'sinat');
		if (!$vdisk->token) {
			echo 'error';
			return;
		}
		$_SESSION['token'] = $vdisk->token;

		$vdisk->keep_token();
		$rets = array();

		if (is_array($files) && $files) {
			foreach ($files as $sid => $file_id) {
				$file_info = $vdisk->get_file_info($file_id);

				$ret = array(
						'err_code' => $file_info['err_code'],
						'file_id' => $file_id,
						'down'		=> $file_info['data']['s3_url'],
						'sid'		=> $sid
				);
				$rets[$sid] = $ret;
			}

		}

		if ($urls) {
			$names =$this->get_by_curl($urls);
			if (!$names) {
				return json_encode(array('err_code' => 1));
			}

			foreach ($names as $dou_url => $content) {
				$url_arr = explode('/', $dou_url);
				$sid = end($url_arr);
				$sid = str_replace('.mp3','', $sid);
				$sid = str_replace('p', '', $sid);
				$name = BASEPATH.'/../uploads/'.$sid.'.mp3';
				try{
					file_put_contents($name, $content);
					$as = $vdisk->upload_file($name, 52055059);


					if ($as['err_code'] != 0) {
						continue;
					}

					$file_id = $as['data']['fid'];
					unlink($name);
					$file_info = $vdisk->get_file_info($file_id);

					$ret = array(
							'err_code' => $file_info['err_code'],
							'file_id' => $file_id,
							'down'		=> $file_info['data']['s3_url'],
							'sid'		=> $sid
					);
					$rets[$sid] = $ret;
				}catch (Exception $e) {
					echo json_encode(array('err_code' => 1));
					return ;
				}
			}
		}


		echo json_encode(array('err_code' => 0, 'data' =>$rets));
		return ;
	}



	/**
	 * 抓取多页面
	 *
	 * @param array $urls
	 * @return array 返回的数组是以url为key的数组
	 */
	private  function get_by_curl(array $urls)
	{
		// 创建一个列队
		$mh = curl_multi_init();

		//监听列队
		$listener_list = array();


		foreach ($urls as $url)
		{

			// 创建一个curl对象
			$current = $this->create_curl($url);

			// 将curl对象加入列队
			curl_multi_add_handle($mh, $current);

			// 记录监听列队
			$listener_list[$url] = $current;
		}
		// 删除多余的变量
		unset($current);

		// 是否执行中
		$running = null;

		// 返回的内容都放在这个变量里
		$result = array();

		// 记录已完成数
		$done_num = 0;

		// 记录待处理数
		$list_num = count($listener_list);
		do
		{
			while ( ($execrun = curl_multi_exec($mh, $running)) == CURLM_CALL_MULTI_PERFORM );
			if ( $execrun!=CURLM_OK ) break;

			while ( true==($done = curl_multi_info_read($mh)) )
			{
				foreach ( $listener_list as $url=>$listener )
				{
					if ( $listener === $done['handle'] )
					{
						// 获取内容
						$result[$url] = curl_multi_getcontent($done['handle']);

						// 此方法可获取返回编码
						// $code = curl_getinfo($done['handle'], CURLINFO_HTTP_CODE);

						// 关闭当前CURL
						curl_close($done['handle']);

						// 获取到数据后移除列队
						curl_multi_remove_handle($mh, $done['handle']);

						break;
					}
				}
			}

			// 如果完成数达到待处理数则退出do循环
			if ($done_num>=$list_num) break;

			// 如果没有执行了，就退出
			if (!$running) break;

		} while (true);


		// 关闭列队
		curl_multi_close($mh);

		return $result;
	}

	/**
	 * 创建一个CURL对象
	 *
	 * 这个方法只是一个简单的例子，实际中可以加入很多不同的参数，可参照 curl_setopt 方法
	 *
	 * @param string $url URL地址
	 * @return curl_init()
	 */
	function create_curl($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);        // 请求的URL
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_REFERER, "http://douban.fm/swf/53041/fmplayer.swf?0.6961411843076348");
		// curl_setopt($ch, CURLOPT_POST, true );           // 如果POST则加上
		// curl_setopt($ch, CURLOPT_POSTFIELDS, $vars );     // 如果POST则加上
		curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 86400 ); // DNS缓存超时时间

		return $ch;
	}


	private function save_con($url) {
		$ch = curl_init();
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_REFERER, "http://douban.fm/swf/53041/fmplayer.swf?0.6961411843076348");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$str = curl_exec($ch);
		curl_close ($ch);
		$name = BASEPATH.'/../uploads/'.md5($url).'.mp3';
		try{
			file_put_contents($name, $str);
			return $name;
		}catch (Exception $e) {
			return false;
		}

	}



}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */