<?php

/**
 * ZmienPoz class v1.0
 * dla CMS i innych klas - zmiana kolejnosci elekentow.
 * All rights reserved
 * @package ZmienPoz class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2007 Waldemar Jonik
 */

/**
 *
 * Example:
 *

  require_once("class.zmienpoz.php");
	$poz=new zmienPoz(5,"up","akapity");
	$poz->wykonaj();
	
 *
 */
	
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		

	
class zmienPoz {

	/**
	 * Public variables
	 */

	/**
	 * Private variables
	 */
		
	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="ZmienPoz class";

	
	/**
	 * typ akcji (up, upp, down, ddown)
	 */					
	private $_typ="";
	
	/**
	 * id
	 */					
	private $_id=0;			
		
	/**
	 * poz
	 */					
	private $_poz=1;			
	
	/**
	 * poz 2
	 */					
	private $_poz2=1;				
	
	/**
	 * id matka
	 */					
	private $_matka=0;		
	
	/**
	 * query add
	 */					
	private $_queryAdd="";		
	
	/**
	 * tabela
	 */					
	private $_tabela="";
			
	/**
	 * pole matka
	 */					
	private $_poleMatka="";			
	
	/**
	 * pole poz
	 */					
	private $_polePoz="nr_poz";			
	
	/**
	 * pole id
	 */					
	private $_poleId="id";			
	
	/**
	 * czy wykonano
	 */					
	private $_ok=false;		
	
	/**
	 * typy tab
	 */					
	private $_typTab=array("up","upp","down","ddown");
			
	
  /**
   * zwraca nazwe klasy
   * @return string				
   */		
	public function getNazwaKlasy(){
	
		return $this->_nazwaKlasy;
		
	}		


  /**
   * Set typ
   * @param string $typ
   */
  public function setTyp($typ) {

		if(!empty($typ)&&in_array($typ,$this->_typTab)){
	    $this->_typ=$typ;
		} else {
			trigger_error("setTyp: invalid typ value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
  }		
										
			
  /**
   * Set id
   * @param int $id
   */
  public function setId($id) {
	
		$id=$id+0;	

		if(is_int($id)&&$id>0){
			$id=tekstForm::doSql($id);
    	$this->_id=$id;
		} else {
			trigger_error("setId: invalid id value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
			
  }			
	
  /**
   * Set poz
   * @param int $poz
   */
  public function setPoz($poz) {
	
		$poz=tekstForm::doSql($poz);
		$poz=$poz+0;	

		if(is_int($poz)&&$poz>0){
    	$this->_poz=$poz;
		} else {
			trigger_error("setPoz: invalid poz value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
			
  }			
	
	
  /**
   * Set matka
   * @param int $matka
   */
  public function setMatka($matka) {
	
		$matka=tekstForm::doSql($matka);	
		$matka=$matka+0;	

		if(is_int($matka)&&$matka>=0){
    	$this->_matka=$matka;
		} else {
			trigger_error("setMatka: invalid matka value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
			
  }					
	
  /**
   * Set queryAdd
   * @param string $queryAdd
   */
  public function setQueryAdd($queryAdd) {

    $this->_queryAdd=$queryAdd;

  }		
	
  /**
   * Set tabela
   * @param string $tabela
   */
  public function setTabela($tabela) {

		if(!empty($tabela)){
	    $this->_tabela=$tabela;
		} else {
			trigger_error("setTabela: invalid tabela value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
						

  }		
	
	
  /**
   * Set poleMatka
   * @param string $poleMatka
   */
  public function setPoleMatka($poleMatka) {

		if(!empty($poleMatka)){
	    $this->_poleMatka=$poleMatka;
		} else {
			trigger_error("setPoleMatka: invalid poleMatka value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
			
  }		
			

  /**
   * Set poleId
   * @param string $poleId
   */
  public function setPoleId($poleId) {

		if(!empty($poleId)){
	    $this->_poleId=$poleId;
		} else {
			trigger_error("setPoleId: invalid poleId value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}				

  }		
					
		
  /**
   * Set polePoz
   * @param string $polePoz
   */
  public function setPolePoz($polePoz) {

		if(!empty($polePoz)){
    	$this->_polePoz=$polePoz;
		} else {
			trigger_error("setPolePoz: invalid polePoz value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
			
  }		

	
  /**
   * wykonaj akcje
   */
  public function wykonaj() {
	
		if($this->_id&&$this->_typ&&$this->_tabela){
		
			if($this->_poleMatka){
				$this->_queryAdd.=" AND ".$this->_poleMatka."='".$this->_matka."' ";
			}		
		
		  $query=" FROM ".$this->_tabela." WHERE 1 ";
			$query.=$this->_queryAdd;

		  switch($this->_typ){

		    //na sama gore
		    case 'upp':
		      $dane=konf::get()->_bazasql->pobierzRekord("SELECT MIN(".$this->_polePoz.") AS nr_poz ".$query);
		      if(!empty($dane)&&!empty($dane['nr_poz'])){
					
		        //gdy nowy nr_poz=1 to inne przesuwamy
		        if($dane['nr_poz']==1){
		          $this->_poz2=1;
							konf::get()->_bazasql->zap("UPDATE ".$this->_tabela." SET ".$this->_polePoz."=".$this->_polePoz."+1 WHERE ".$this->_poleId."!='".$this->_id."'".$this->_queryAdd);
		        //gdy nowy nr_poz >1 to nie musimy innych przesuwac
		        } else {
		          $this->_poz2=$dane['nr_poz']-1;
		        }
						
		      }
		    break;

		    //poziom wyzej
		    case 'up':
		      //jesli mozemy przesunac o poziom wyzej
		      if($this->_poz>1){
		        $dane=konf::get()->_bazasql->pobierzRekord("SELECT ".$this->_polePoz." AS nr_poz ".$query." AND ".$this->_polePoz."<'".$this->_poz."' ORDER BY nr_poz DESC LIMIT 0,1");
		        if(!empty($dane)){
		          $this->_poz2=$dane['nr_poz'];
		          konf::get()->_bazasql->zap("UPDATE ".$this->_tabela." SET ".$this->_polePoz."='".$this->_poz."' WHERE ".$this->_polePoz."='".$dane['nr_poz']."' ".$this->_queryAdd);
		        }
		      }
		    break;

		    //na sam dol
		    case 'ddown':
		      $dane=konf::get()->_bazasql->pobierzRekord("SELECT MAX(".$this->_polePoz.") AS nr_poz ".$query);
		      //zawsze o 1 wiekszy od najwiekszego
		      if(!empty($dane)){
		        $this->_poz2=$dane['nr_poz']+1;
		      }
		    break;

		    //poziom nizej
		    case 'down':
		      $dane=konf::get()->_bazasql->pobierzRekord("SELECT ".$this->_polePoz." AS nr_poz ".$query." AND nr_poz>'".$this->_poz."' ORDER BY nr_poz LIMIT 0,1");
		      //jesli jest jakis ponizej to zamiana miejsc
		      if(!empty($dane)){
		        konf::get()->_bazasql->zap("UPDATE ".$this->_tabela." SET ".$this->_polePoz."='".$this->_poz."' WHERE ".$this->_polePoz."='".$dane['nr_poz']."' ".$this->_queryAdd);
		        $this->_poz2=$dane['nr_poz'];   
		      }
		    break;

		  }
		  
			//jesli nastapila zmiana poziomu
			if($this->_poz2!=$this->_poz){
			  konf::get()->_bazasql->zap("UPDATE ".$this->_tabela." SET ".$this->_polePoz."=".$this->_poz2." WHERE ".$this->_poleId."='".$this->_id."' ".$this->_queryAdd);
			  konf::get()->setKomunikat(konf::get()->langTexty("a_wykonana"),"");
				$this->_ok=true;
				
			}		
		
		} else {
			trigger_error("wykonaj: invalid data".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
		
	}
					
						
	/**
   * class constructor php5	
   * @param int $id
   * @param int $typ				
   * @param string $tabela
   */	
	public function __construct($id,$typ,$tabela) {	

		$this->setId($id);
		$this->setTyp($typ);
		$this->setTabela($tabela);
		
  }	

}


?>