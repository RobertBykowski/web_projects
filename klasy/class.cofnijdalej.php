<?php

/**
 * Cofnij dalej class v1.2 (2009-05-21)
 * dla CMS i innych klas - obsluga nawiglacji podstron - poprzednia - następna.
 * All rights reserved
 * @package Nawig class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2009 JW Web Development
 */

/**
 *
 * Example:
 *

  include ("class.cofnijdalej.php");

	$cofnijdalej = new cofnijdalej($sql,$dane,$pole_id,$porownaj);	
  $cofnijdalej->setPrzenies(array("akcja"=>$akcja));	
  $cofnijdalej->naw();
  echo $cofnijdalej->getNaw();	
	
 *
 */
	
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		

class cofnijdalej {

	/**
	 * Public variables
	 */


	/**
	 * Private variables
	 */		

	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="cofnijdalej class";
	
	
	/**
	 * sql tab
	 */				
	private $_sql="";
	
	
	/**
	 * pole id
	 */				
	private $_poleId="id";	
	
	
	/**
	 * porownaj
	 */				
	private $_porownaj="";	
	
	
	/**
	 * zmienna link
	 */				
	private $_zmienna="";			

	
	/**
	 * powrot html
	 */				
	private $_powrot="";				
	
	/**
	 * naw html
	 */				
	private $_naw="";		

	/**
	 * przenies
	 */				
	private $_przenies=array();		
	
	
	/**
	 * current element
	 */				
	private $_dane=array();		
	
	
	/**
	 * all data
	 */				
	public $_daneTab=array();			
	
	
	/**
	 * previous id
	 */				
	public $_poprzednie="";			
	
	
	/**
	 * next id
	 */				
	public $_next="";	
		
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
   * set sql
   * @param string $sql
   */		
	public function setSql($sql){
	
		if(!empty($sql)&&is_string($sql)){
			$this->_sql=$sql;
		} else {
			trigger_error("setSql: invalid sql value ".$this->getNazwaKlasy(),E_USER_ERROR);		
		}
		
	}	
		
	
  /**
   * set poleId
   * @param string $pole_id
   */		
	public function setPoleId($pole_id){
	
		if(!empty($pole_id)&&is_string($pole_id)){
			$this->_poleId=$pole_id;
		} else {
			trigger_error("setPoleId: invalid pole_id value ".$this->getNazwaKlasy(),E_USER_ERROR);		
		}
		
	}	
	
	
  /**
   * set porownaj
   * @param string $porownaj
   */		
	public function setPorownaj($porownaj){
	
		if(!empty($porownaj)&&is_string($porownaj)){
			$this->_porownaj=$porownaj;
		} else {
			trigger_error("setPorownaj: invalid porownaj value ".$this->getNazwaKlasy(),E_USER_ERROR);		
		}
		
	}		
	
	
  /**
   * set zmienna
   * @param string $zmienna
   */		
	public function setZmienna($zmienna){
	
		if(!empty($zmienna)&&is_string($zmienna)){
			$this->_zmienna=$zmienna;
		} else {
			trigger_error("setZmienna: invalid zmienna value ".$this->getNazwaKlasy(),E_USER_ERROR);		
		}
		
	}		
		
		
  /**
   * set powrot
   * @param string $powrot
   */		
	public function setPowrot($powrot){
	
		$this->_powrot=$powrot;
		
	}	
			
			
  /**
   * set przenies
   * @param array $przenies
   */		
	public function setPrzenies($przenies){
	
		if(!empty($przenies)&&is_array($przenies)){
			$this->_przenies=$przenies;
		} else {
			$this->_przenies=array();	
		}
		
	}			
	
	
  /**
   * set dane
   * @param array $dane
   */		
	public function setDane($dane){
	
		if(!empty($dane)&&is_array($dane)){
			$this->_dane=$dane;
		} else {
			trigger_error("setDane: invalid dane value ".$this->getNazwaKlasy(),E_USER_ERROR);		
		}
		
	}		
	
	
  /**
   * set naw
   * @param string $naw
   */		
	public function setNaw($naw){
	
		$this->_naw=$naw;
		
	}	
	

  /**
   * Get naw
   * @return string
   */
  public function getNaw() {

  	return $this->_naw;
		
  }							
		

  /**
   * set nawigacja - rysowanie
   * @param bool $rys
   */		
	public function naw($rys=true){
		
		$zap2=konf::get()->_bazasql->zap($this->_sql);

		while($dane4=konf::get()->_bazasql->fetchAssoc($zap2)){

			$this->_daneTab[$dane4[$this->_poleId]]=$dane4;		
			
			if($dane4[$this->_poleId]!=$this->_dane[$this->_poleId]&&$dane4[$this->_porownaj]<$this->_dane[$this->_porownaj]){
				$this->_poprzednie=$dane4[$this->_poleId];
			}
			
			if(empty($this->_nastepne)&&$dane4[$this->_poleId]!=$this->_dane[$this->_poleId]&&$dane4[$this->_porownaj]>$this->_dane[$this->_porownaj]){
				$this->_nastepne=$dane4[$this->_poleId];
			}
			
		}
 		konf::get()->_bazasql->freeResult($zap2);		
		
			
		if($rys){
		
			$html="";				
			$html.="<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"seta srodek\"><tr>";
			
			$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),$this->_przenies);

			$html.="<td style=\"width:33%; padding-left:10px;\" class=\"lewa\">";
			if(!empty($this->_poprzednie)){
				$html.="<a href=\"".$link."&amp;".$this->_zmienna."=".$this->_poprzednie."\">&lt;&lt;&nbsp;".konf::get()->langTexty("poprzednie")."</a>";
			} else {
				$html.="&nbsp;";
			}
			$html.="</td>";
			
			$html.="<td style=\"width:33%\">";		
			if($this->_powrot){
				$html.=$this->_powrot;
			} else {
				$html.="&nbsp;";
			}		
			$html.="</td>";
			
			$html.="<td style=\"width:33%; padding-right:10px;\" class=\"prawa\">";			
			if(!empty($this->_nastepne)){
				$html.="<a href=\"".$link."&amp;".$this->_zmienna."=".$this->_nastepne."\">".konf::get()->langTexty("nastepne")."&nbsp;&gt;&gt;</a>";
			} else {
				$html.="&nbsp;";
			}			
			$html.="</td>";	
						
			$html.="</tr></table>";
			
			$this->setNaw($html);
			
		}
		
	}	
	
	
  /**
   * konstruktor	
   * @param string $sql_tab				
   * @param array $dane	
   * @param string $pole_id
   * @param string $porownaj		
   */	
	public function __construct($sql,$dane,$pole_id,$porownaj) {

		$this->setSql($sql);
		$this->setDane($dane);
		$this->setPoleId($pole_id);		
		$this->setporownaj($porownaj);	
		
	}		

	
}

?>