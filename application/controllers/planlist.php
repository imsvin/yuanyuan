<?php

class Planlist extends MY_Controller {

	function __construct() {
		parent::__construct(true,false);
	}


	public function index($uid = 0, $planlist_id = 0) {
		$uid = (int)$uid;
		$planlist_id = (int)$planlist_id;
		$canupdate = 0;
		if (!$uid) {
			show_404();
			return ;
		}

		$this->load->model('user_model');
		$this->load->model('plan_model');

		$userinfo = $this->user_model->get_by_uid($uid);

		if (!$userinfo) {
			show_404();
			return ;
		}

		// 获取默认list
		if (!$planlist_id) {
			// 获取默认
			$listinfo = $this->plan_model->get_default_list($uid);
		} else {
			$listinfo = $this->plan_model->get_by_id($planlist_id);
		}

		if (!$listinfo) {
			show_404();
			return ;
		}

		$planlist_id = $listinfo['plan_id'];

		if($this->uid == $listinfo['uid']){
			$canupdate = 1;
		}

		$plans = $this->plan_model->get_all_plan($planlist_id);

		$daddy_listinfo = array();
		// 上级
		if ($planlist_id > 0) {
			$daddy_listinfo = $this->plan_model->get_by_id($planlist_id);
		}

		$this->load->view('planlist/index', array(
			'plans'	=>	$plans,
			'listinfo'	=>	$listinfo,
			'canupdate'	=>	$canupdate,
			'userinfo'	=>	$userinfo,
			'daddy_listinfo' => $daddy_listinfo
		));

	}

	public function actionList()
	{
		$this->render('list');

	}


	public function add_plan(){
		if (!$this->uid) {
			echo json_return(RESPONSE_UN_LOGIN, '请先登录。');
			return;
		}

		$content = $this->input->post('content');
		$planlist_id = (int)$this->input->post('planlist');
		$images = $this->input->post('images');

		$this->load->model('plan_model');

		$planlist = $this->plan_model->get_by_id($planlist_id);
		if (!$planlist || $planlist['uid'] != $this->uid){
			echo json_return(RESPONSE_PARAMS_ERROR, '你没有权限。');
			return;
		}


		$update = array('total' => $planlist['total'] + 1);

		if (!$this->plan_model->update($planlist_id, $update)) {
			echo json_return(RESPONSE_PARAMS_ERROR, '网络不稳定请重试。');
			return;
		}


		$new_plan = array('uid' => $this->uid,'content' => $content, 'images' => $images, 'sort' => time());

		$re = $this->plan_model->add_plan($planlist_id, $new_plan);
		if (!$re) {
			echo json_return(RESPONSE_PARAMS_ERROR, '网络不稳定请重试。');
			return;
		}

		$newplan = $this->plan_model->get_by_id($re);

		echo json_return(RESPONSE_OK,$newplan);
		return;
	}

	public function change_sort() {
		if (!$this->uid) {
			echo json_return(RESPONSE_UN_LOGIN, '请先登录。');
			return;
		}

		$planlist_id = (int)$this->input->post('planlist_id');
		$plan_id = (int)$this->input->post('plan_id');
		$order = (int)$this->input->post('order');
		if (!$planlist_id || !$plan_id || !$order ) {
			echo json_return(RESPONSE_PARAMS_ERROR, '参数错误。');
			return;
		}

		$this->load->model('plan_model');
		$sort = $this->plan_model->get_all_plan($planlist_id, 1, $order-1);
		if(!$sort) {
			echo json_return(RESPONSE_PARAMS_ERROR, '参数错误。');
			return;
		}

		$update = array('sort' => (int)$sort['sort'] + 1);
		if(!$this->plan_model->update($plan_id, $update)){
			echo json_return(RESPONSE_PARAMS_ERROR, '系统繁忙，请稍后再试。');
			return;
		}
		echo json_return(RESPONSE_OK);
		return;
	}


	private function update_plan_content($model,$plan_id,$data,$complete=array()) {
		$model->attributes = $data;
		if($model->save()){
			if (!empty($complete)) {
				$planlist = Plan_Model::model()->findByAttributes(array('plan_id' => $model->attributes['planlist_id']));
				switch ($complete[1]) {
					case 'down':
						$planlist->attributes = array($complete[0] => $planlist->attributes[$complete[0]] - 1);
						$planlist->save();
						break;
					case 'up':
						$planlist->attributes = array($complete[0] => $planlist->attributes[$complete[0]] + 1);
						$planlist->save();
						break;
				}
			}


		}
	}


	public function actionEdit_plan()
	{
		if (!Yii::app()->user->id) {
			echo json_return(RESPONSE_UN_LOGIN, '请先登录。');
			return;
		}

		$action = htmlspecialchars($_POST['action']);
		$plan_id = (int)$_POST['plan_id'];

		$model = Plan_Model::model()->findByPk($plan_id);
		if (!$model || $model['uid'] != Yii::app()->user->id) {
			echo json_return(RESPONSE_PARAMS_ERROR, '你没有权限。');
			return;
		}

		$content = $_POST['content'];
		switch ($action){
			case 'sort':
				$this->update_plan_content($plan_id, array('sort'=>(int)$content));
				break;
			case 'delete':
				if ($model['ischecked'] == 1) {
					$this->update_plan_content($model,$plan_id, array('ischecked'=>'0') ,array('complete' ,'down'));
				}
				$this->update_plan_content($model,$plan_id, array('isdelete'=>'1') ,array('total' ,'down'));
				break;
			case 'private':
				$this->update_plan_content($model,$plan_id, array('isprivate'=>'1'));
				break;
			case 'fail':
				$this->update_plan_content($model,$plan_id, array('ischecked'=>'-1'),array('complete' ,'down'));
				break;
			case 'checked':
				$this->update_plan_content($model,$plan_id, array('ischecked'=>'1'),array('complete' ,'up'));
				break;
			case 'unchecked':
				$this->update_plan_content($model,$plan_id, array('ischecked' => '0') ,array('complete' ,'down'));
				break;
			case 'edit_content':
				$this->update_plan_content($model,$plan_id, array('content' => $content));
				break;
			default:
				break;
		}

		echo json_return(RESPONSE_OK);
		return;
	}

	public function actionEdit_content() {
		if (!Yii::app()->user->id) {
			echo json_return(RESPONSE_UN_LOGIN, '请先登录。');
			return;
		}

		$plan_id = (int)$_POST['plan_id'];

		$plan = Plan_Model::model()->findByPk($plan_id);
		if (!$plan || $plan['uid'] != Yii::app()->user->id) {
			echo json_return(RESPONSE_PARAMS_ERROR, '参数错误。');
			return;
		}

		$content = $_POST['content'];
		if ($plan['content'] == $content) {
			echo json_return(RESPONSE_OK);
			return ;
		}
		$plan->attributes = array('content' => $content);
		if($plan->save()){
			echo json_return(RESPONSE_OK,$plan->attributes);
		} else {
			echo json_return(RESPONSE_SYSTEM_BUSY,'系统繁忙，请稍后再试。');
		}

	}


	public function actionCreate_kid() {
		if (!Yii::app()->user->id) {
			echo json_return(RESPONSE_UN_LOGIN, '请先登录。');
			return;
		}

		$plan_id = (int)$_POST['plan_id'];

		$plan_id = $plan_id ? $plan_id : '';

		if (!$plan_id) {
			echo json_return(RESPONSE_PARAMS_ERROR, '参数错误。');
			return;
		}


		$planlist = Plan_Model::model()->findByAttributes(array('plan_id' => $plan_id));


		if (!$planlist) {
			echo json_return(RESPONSE_PARAMS_ERROR, '参数错误。');
			return;
		}

		if ($planlist['has_child'] == 1) {
			echo json_return(RESPONSE_PARAMS_ERROR, '已经创建了。');
			return;
		}
		$planlist->attributes = array('has_child' => '1');
		if ($planlist->save()) {
			echo json_return(RESPONSE_OK);
			return;
		}

		echo json_return(RESPONSE_UN_LOGIN, '请先登录。');
		return;
	}

	public function actionAjax_delete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			try {

			}catch (Exception $e) {
				echo 'fail';exit;
			}
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionAjax_upload(){
		// list of valid extensions, ex. array("jpeg", "xml", "bmp")
		$allowedExtensions = array();
		// max file size in bytes
		$sizeLimit = 10 * 1024 * 1024;

		$uploader = new CFileUploader($allowedExtensions, $sizeLimit);
		$result = $uploader->handleUpload('uploads/');
		if ($result['success']) {
			$date = array('filename'=>$result['filename'], 'imagename'=>$result['imagename']);
			echo htmlspecialchars(json_encode($date), ENT_NOQUOTES);
			return ;
		}

		echo htmlspecialchars(json_encode(array('success'=>false)), ENT_NOQUOTES);
		exit;

	}
}
