<?php

/**
 * Encrypt MD5 64 class v1.0 (2006-08-03)
 * for Content Managment System
 * All rights reserved
 * @package Encrypt MD5 64 class
 */

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		


class encryptMd5 {

	/**
	 * Public variables
	 */


	/**
	 * Private variables
	 */		

  var $charx;
	
  var $char;

  /**
   * decrypt
   * @param string $data
   * @param string $key		
	 * @return string	
   */			
  function decrypt($data,$key) {
	
    $key=md5($key);
    $x=0;
    for ($i=0;$i<strlen($data);$i++) {
    	if ($x==strlen($key)){
				$x=0;
			}
      $this->char.=substr($key,$x,1);
      $x++;
    }
    for ($i=0;$i<strlen($data);$i++)	{
    	if (ord(substr($data,$i,1))<ord(substr($this->char,$i,1))) {
        $this->charx.=chr((ord(substr($data,$i,1))+256)-ord(substr($this->char,$i,1)));
      } else {
        $this->charx.=chr(ord(substr($data,$i,1))-ord(substr($this->char,$i,1)));
      }
    }
		
    return base64_decode($this->charx);
		
  }

  /**
   * encrypt
   * @param string $data
   * @param string $key		
	 * @return string	
   */				
  function encrypt($data,$key) {
		
		$key=md5($key);
    $data=base64_encode($data);
    $x=0;
    for ($i=0;$i<strlen($data);$i++) {
      if ($x==strlen($key)){
				$x=0;
			}
      $this->char.=substr($key,$x,1);
      $x++;
    }
    for ($i=0;$i<strlen($data);$i++) {
    	$this->charx.=chr(ord(substr($data,$i,1))+(ord(substr($this->char,$i,1)))%256);
    }
		
    return ($this->charx);
		
 	}

}

?>