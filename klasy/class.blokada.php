<?php

/**
 * Blokada class v1.1  (2009-05-21)
 * dla CMS i innych klas - blokada do edycji.
 * All rights reserved
 * @package Blokada class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2009 JW Web Development
 */

/**
 *
 * Example:
 *

  require_once("class.blokada.php");
	$blokada=new blokada($tabela,$pole,$poleData,$ile,$id);
	$blokada->start();

 *
 */
	
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		

	
class blokada {

	/**
	 * Public privateiables
	 */

	/**
	 * Private privateiables
	 */
		
	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="Blokada class";
	
	/**
	 * tabela blokowana
	 */				
  private $_tabela="";	
	
	/**
	 * pole zapisu blokady
	 */				
  private $_pole="blokada";	
	
	/**
	 * pole zapisu daty blokady
	 */				
  private $_poleData="data_blokada";		
	
	/**
	 * pole rekordu
	 */				
  private $_id="";		
	
	/**
	 * ile minut
	 */				
  private $_ile=0;			
			
	
  /**
   * zwraca nazwe klasy
   * @return string				
   */		
	public function getNazwaKlasy(){
	
		return $this->_nazwaKlasy;
		
	}									
					
			
  /**
   * Set tabela
   * @param string $tabela
   */
  public function setTabela($tabela) {
	
  	if(!empty($tabela)&&is_string($tabela)){
      $this->_tabela=$tabela;
		} else {
			trigger_error("setTabela: invalid tabela value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
		
  }									
				

  /**
   * Set pole
   * @param string $pole
   */
  public function setPole($pole) {
	
  	if(!empty($pole)&&is_string($pole)){
      $this->_pole=$pole;
		} else {
			trigger_error("setPole: invalid pole value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
		
  }									
			
			
  /**
   * Set poleData
   * @param string $poleData
   */
  public function setPoleData($poleData) {
	
  	if(!empty($poleData)&&is_string($poleData)){
      $this->_poleData=$poleData;
		} else {
			trigger_error("setPoleData: invalid poleData value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
		
  }			
	
	
  /**
   * Set id
   * @param int $id
   */
  public function setId($id) {
	
		$id=$id+0;
	
  	if(!empty($id)&&$id>0){
      $this->_id=$id;
		}
		
  }			
	
	
  /**
   * Set ile
   * @param int $ile
   */
  public function setIle($ile) {
	
		$ile=$ile+0;
	
  	if(!empty($ile)&&$ile>=0){
      $this->_ile=$ile;
		}
		
  }			
		
		
  /**
   * blokada start
   */
  public function start() {
	
		if($this->_tabela&&$this->_pole&&$this->_poleData&&$this->_id){
			if($this->_ile){
				konf::get()->_bazasql->zap("UPDATE ".$this->_tabela." SET ".$this->_pole."='".user::get()->id()."', ".$this->_poleData."=NOW() WHERE id='".$this->_id."'");
			}
		} else {
			trigger_error("start: invalid or empty data ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
		
  }			
	
	
  /**
   * blokada stop
   * @param string $wartosc	
   */
  public function stop($wartosc="") {
	
		if($this->_tabela&&$this->_pole&&$this->_poleData){
		
			$query="UPDATE ".$this->_tabela." SET ".$this->_pole."='' WHERE 1 ";
			if(!empty($wartosc)) { 
				$query.=" AND ".$this->_pole."='".user::get()->id()."'"; 
			}
			if($this->_id) { 
				$query.="  AND id='".$this->_id."'"; 
			}
			konf::get()->_bazasql->zap($query);		
			
		} else {
			trigger_error("stop: invalid or empty data ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
		
  }			
	
	
  /**
   * blokada sprawdz
   * @param string $wartosc	
   */
  public function dostepny($wartosc,$czas) {								
	
		$ok=true;
		
		if($this->_ile&&!empty($wartosc)&&$wartosc!=user::get()->id()){
			if((strtotime($czas)+(60*$this->_ile))>time()){
				$ok=false;
			}
		}
		
		return $ok;	
	
	}
								
												
	/**
   * class constructor php5	
   * @param string $tabela
   * @param string $pole		
   * @param string $poleData
   * @param int $id
   */	
	public function __construct($tabela,$pole,$poleData,$ile="",$id="") {	

		$this->setTabela($tabela);
		$this->setPole($pole);
		$this->setPoleData($poleData);
		$this->setIle($ile);
		$this->setId($id);		
		
  }	
	
	
}

?>