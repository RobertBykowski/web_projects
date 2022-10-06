<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

include_once(konf::get()->getKonfigTab('mod_kat')."ankieta/konfig_inc.php");

class rotator extends modul {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="rotator class";
	
	
  /**
   * zlicza klikniecia
   */	
	public function klik(){

		$id_rotator=tekstForm::doSql(konf::get()->getZmienna("id_rotator","id_rotator"));	
		
		if(!empty($id_rotator)){

			$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'rotator')." WHERE id='".$id_rotator."' AND status=1 AND (data_start='0000-00-00 00:00:00' OR data_start<=NOW()) AND (data_stop='0000-00-00 00:00:00' OR data_stop>=NOW())");
			
			if(!empty($dane)){
				konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'rotator')." SET klik=klik+1 WHERE id='".$id_rotator."'");
				header("Location: ".$dane['img_link']);
			}
			
		}
		
	}	

	
	/**
   * class constructor php5	
   */	
	public function __construct() {	

  }	
		
	
}	

?>