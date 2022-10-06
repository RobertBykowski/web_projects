<?php

/**
 * UTF class v1.0
 * dla CMS i innych klas - formatowanie tekstow na UTF.
 * All rights reserved
 * na podstawie klasy Romans(2000) romans@lv.net	
 *	
 * @package utf class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2006 Waldemar Jonik
 */

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}	

class utf{

	/**
	 * Public variables
	 */

	/**
	 * Private variables
	 */	
		
			
	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="utf class";
	
	
	/**
	 * loaded charset mappings. You can obtain them at ftp://ftp.unicode.org/Public/MAPPINGS/
	 */				
  private $map; 
	
	
	/**
	 * Public methods
	 */
			
	
  /**
   * zwraca nazwe klasy
   * @return string				
   */		
	public function getNazwaKlasy(){
		return $this->_nazwaKlasy;
	}		


	/**
   * Translate string ($str) to UTF-8 from given charset ($xcp)
   * if charset is not present, ISO-8859-1 will be used.	 
	 *
   * @param  string $str			
   * @param  string $alias		
   */				
	public function cp2utf($str,$alias=''){

  	$xstr="";
  	if($alias==''){
   		for($x=0;$x<strlen($str);$x++){
    		$xstr.=$this->code2utf(ord(substr($str,$x,1)));
   		}
   		return $xstr;
  	}
  	for($x=0;$x<strlen($str);$x++){
   		$xstr.=$this->code2utf($this->map[$alias][ord(substr($str,$x,1))]);
  	}
		
  	return $xstr;
 	}

	
	/**
   *  Translate numeric code of UTF-8 character code to corresponding character sequence. Refer to www.unicode.org for info.
	 *
   * @param  int $num	
   */		
	public function code2utf($num){

		if($num<128) return chr($num); // ASCII
  	if($num<1024) return chr(($num>>6)+192).chr(($num&63)+128);
  	if($num<32768) return chr(($num>>12)+240).chr((($num>>6)&63)+128).chr(($num&63)+128);
  	if($num<2097152) return chr($num>>18+240).chr((($num>>12)&63)+128).chr(($num>>6)&63+128).chr($num&63+128);
  	return '';
 }

	
	/**
   * class constructor php5	Load table with mapping into array for latter use. Pass alias to cp2utf function..	
	 *
   * @param  string $filename			
   * @param  string $alias		
   */			
	public function __construct($filename,$alias){
		$f=fopen($filename,'r') or die();
	  while(!feof($f)){
	  	if($s=chop(fgets($f,1023))){
	    	@list($x,$a,$b)=split('0x',$s);
	    	$a=hexdec(substr($a,0,2));
	    	$b=hexdec(substr($b,0,4));
	    	if($a&&$b){	
					$this->map[$alias][$a]=$b;
				}
	   	}
	  }
	}	

}

?>