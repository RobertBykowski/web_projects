<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

class modul {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="modul class";
	
	
	/**
	 * seach values
	 */				
  protected $_szuk=array();			
	
	/**
	 * get search values
	 */		
	protected $_szukPobrano=false;	
	
	
	/**
	 * admin
	 */				
  protected $_admin="";		

	
  /**
   * zwraca nazwe klasy
   * @return string				
   */		
	public function getNazwaKlasy(){
	
		return $this->_nazwaKlasy;
		
	}		
	
	
  /**
   * admin 
   * @return bool				
   */	
	public function admin(){
	
		return $this->_admin;
		
	}			
	
	
  /**
   * get search parameters
   * @param int $typ (1 = GET, 2 = POST)
   * @param bool $amp	
   * @param bool $pierwszy
   * @return string, array
   */			
	protected function szukZmienne($typ=1,$amp=true,$pierwszy=true){

		reset($this->_szuk);	
		
		//pobierz wartosci z post lub get
		if(!$this->_szukPobrano){
			while(list($key,$val)=each($this->_szuk)){
				$this->_szuk[$key]=konf::get()->getZmienna($key,$key);	
			}
			$this->_szukPobrano=true;
			reset($this->_szuk);				
		}

		//pobierz dane dla linku		
		if($typ==1){
			
			$link_add="";
			if($amp){	
				$amp="&amp;";
			} else {
				$amp="&";
			}
			
			$i=0;

			while(list($key,$val)=each($this->_szuk)){
				if($val!=''){
					if($pierwszy||$i>0){
						$link_add.=$amp;
					}
					$link_add.=$key."=".tekstForm::doLink($val);		
					$i++;			
				}							
			}
						
			return $link_add;
		
		//pobierz dane dla formularza	
		} else if($typ==2)	{	

			return $this->_szuk;
			
		} else {
		
			return "";
			
		}
	
	}	
	
	/**
   * class constructor php5	
   */	
	public function __construct() {	

  }	
	
}	

?>