<?php if ( ! defined('BASEPATH')) exit('No direct script access	allowed');

class User_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	function get_by_uid($uid) {
		$query = $this->db->get_where('user',array('uid' => $uid));
		if(is_object($query)) {
			if($query->num_rows() >	0) {
				$ret = $query->row_array();
				return $ret;
			} else {
				return array();
			}
		} else {
			return array();
		}
	}

	public function	update($uid, $update) {
		if(array_key_exists('uid', $update)) unset($update['uid']);

		$query = $this->db->update('user', $update,	array('uid'	=> $uid));
		if($query) {
			if($this->db->affected_rows() >	0) {
				return true;
			} else {
				return null;
			}
		} else {
			return false;
		}
	}

}