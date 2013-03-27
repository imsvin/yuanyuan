<?php if ( ! defined('BASEPATH')) exit('No direct script access	allowed');

class Plan_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}

	public function get_all_plan($planlist_id, $limit = 9999, $offset = 0) {
		$query = $this->db->get_where('plan',array('planlist_id' => $planlist_id), $limit,$offset);
		if(is_object($query)) {
			if($query->num_rows() >	0) {
				$ret = $query->result_array();
				return $ret;
			} else {
				return array();
			}
		} else {
			return array();
		}
	}

	public function get_by_id($plan_id) {
		$query = $this->db->get_where('plan',array('plan_id' => $plan_id));
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



	function get_default_list($uid) {
		$query = $this->db->get_where('plan',array('uid' => $uid ,'isdelete' => 0, 'planlist_id' => 0));
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

	public function update($plan_id, $update) {
		if(array_key_exists('plan_id', $update)) unset($update['plan_id']);

		$query = $this->db->update('plan', $update, array('plan_id' => $plan_id));
		if($query) {
			if($this->db->affected_rows() > 0) {
				return true;
			} else {
				return null;
			}
		} else {
			return false;
		}
	}


	public function add_plan($planlist_id, $insert) {
		$insert['planlist_id'] = $planlist_id;
		$query = $this->db->insert('plan', $insert);
		if($query) {
			if($this->db->affected_rows() > 0) {
				return $this->db->insert_id();
			} else {
				return null;
			}
		} else {
			return false;
		}
	}



}