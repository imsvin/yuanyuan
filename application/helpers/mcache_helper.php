<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!class_exists('Mcache')) {
	class Mcache {
		static function connect(){
			$server = array(
				array('host' => '10.182.52.58', 'port'	=> '11211')
			);
			
			if(ENVIRONMENT == 'development') {
				$server = array(
					array('host' => '192.168.2.10', 'port'	=> '11211'),
				);
				$conn = new Memcache;
			} else {
				$conn = new Memcached;
			}

			for($i=0;$i<count($server);$i++) {
				$conn->addServer($server[$i]['host'],$server[$i]['port']);
			}
	    	return $conn;
	  	}
	    
		static function close($conn) {
			return true;
			//$conn->close();
		}
	  
		static function &read($key) {
			$key = md5('QQ_' . $key);
		
			$ret = null;
	  		if ($conn = self::connect($key)) {
	       		$ret = $conn->get($key);
	       		self::close($conn);
	     	}
	    	return $ret;
	   }
	   
	   	static function write($key, $val, $expire = 0, $flag = 0) {
	   		$key = md5('QQ_' . $key);
	   		
	   		$ret = null;
	   		if ($conn = self::connect($key)) {
		   		$ret = ENVIRONMENT == 'development' ? $conn->set($key, $val, $flag, $expire) : $conn->set($key, $val, $expire);
		   		self::close($conn);
	     	}
	     	return $ret;
	   	}
	   
	   	static function delete( $key, $expire = 0) {
	   		$key = md5('QQ_' . $key);
	   		
	   		$ret = null;
	   		if ($conn = self::connect($key)) {
	   			$ret = $conn->delete($key, $expire);
	   			self::close($conn);
	     	}
	     	return $ret;
	   	}
	}
}