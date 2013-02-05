<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/config.html
 */
class CI_Model {
	
	//加入以下代码到CI的Controller和Model类的类申明下
	//------------------------------------------------------------------------
	//补善CI在IDE中的代码提示－开始
	//------------------------------------------------------------------------
	/**
	 * @var CI_Loader
	 */
	private $load;
	/**
	 * @var CI_DB_active_record
	 */
	private $db;
	/**
	 * @var CI_Calendar
	 */
	private $calendar;
	/**
	 * @var Email
	 */
	private $email;
	/**
	 * @var CI_Encrypt
	 */
	private $encrypt;
	/**
	 * @var CI_Ftp
	 */
	private $ftp;
	/**
	 * @var CI_Hooks
	 */
	private $hooks;
	/**
	 * @var CI_Image_lib
	 */
	private $image_lib;
	/**
	 * @var CI_Language
	 */
	private $language;
	/**
	 * @var CI_Log
	 */
	private $log;
	/**
	 * @var CI_Output
	 */
	private $output;
	/**
	 * @var CI_Pagination
	 */
	private $pagination;
	/**
	 * @var CI_Parser
	 */
	private $parser;
	/**
	 * @var CI_Session
	 */
	private $session;
	/**
	 * @var CI_Sha1
	 */
	private $sha1;
	/**
	 * @var CI_Table
	 */
	private $table;
	/**
	 * @var CI_Trackback
	 */
	private $trackback;
	/**
	 * @var CI_Unit_test
	 */
	private $unit;
	/**
	 * @var CI_Upload
	 */
	private $upload;
	/**
	 * @var CI_URI
	 */
	private $uri;
	/**
	 * @var CI_User_agent
	 */
	private $agent;
	/**
	 * @var CI_Validation
	 */
	private $validation;
	/**
	 * @var CI_Xmlrpc
	 */
	private $xmlrpc;
	/**
	 * @var CI_Zip
	 */
	private $zip;
	//------------------------------------------------------------------------
	//补善CI在IDE中的代码提示—结束
	//------------------------------------------------------------------------
	/**
	 * Constructor
	 *
	 * @access public
	 */
	function __construct()
	{
		log_message('debug', "Model Class Initialized");
		
		$this->load=$this->__get("load");
		$this->db=$this->__get("db");
		$this->calendar=$this->__get("calendar");
		$this->email=$this->__get("email");
		$this->encrypt=$this->__get("encrypt");
		$this->ftp=$this->__get("ftp");
		$this->hooks=$this->__get("hooks");
		$this->image_lib=$this->__get("image_lib");
		$this->language=$this->__get("language");
		$this->log=$this->__get("log");
		$this->output=$this->__get("output");
		$this->pagination=$this->__get("pagination");
		$this->parser=$this->__get("parser");
		$this->session=$this->__get("session");
		$this->sha1=$this->__get("sha1");
		$this->table=$this->__get("table");
		$this->trackback=$this->__get("trackback");
		$this->unit=$this->__get("unit");
		$this->upload=$this->__get("upload");
		$this->uri=$this->__get("uri");
		$this->agent=$this->__get("agent");
		$this->validation=$this->__get("validation");
		$this->xmlrpc=$this->__get("xmlrpc");
		$this->zip=$this->__get("zip");
	 
	}

	/**
	 * __get
	 *
	 * Allows models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param	string
	 * @access private
	 */
	function __get($key)
	{
		//echo $key;
		$CI =& get_instance();
		return $CI->$key;
	}
}
// END Model Class

/* End of file Model.php */
/* Location: ./system/core/Model.php */