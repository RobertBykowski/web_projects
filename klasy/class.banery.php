<?php

/**
 * Banery class v1.1 (2009-05-21)
 * dla CMS i innych klas - wyswietlanie banerow.
 * All rights reserved
 * @package Banery class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2009 JW Web Development
 */

/**
 *
 * Example:
 *

  require_once("class.banery.php");
	$banery=new banery(array(5=>5),5);
	$banery1=$banery->pobierz();
	
 *
 */
	
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		

	
class banery {

	/**
	 * Public variables
	 */

	/**
	 * Private variables
	 */
		
	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="banery class";
	
	/**
	 * ile
	 */				
  private $_ile=0;
	
	/**
	 * typy
	 */				
  private $_typy=array();	
	
	/**
	 * id
	 */				
  private $_id=array();		
	
	/**
	 * wykluczone id
	 */				
  private $_wykluczone=array();		
	
	/**
	 * rodzaje
	 */				
  private $_rodzaje=array();		
	
	/**
	 * banery
	 */				
  private $_banery=array();			
	
	/**
	 * banery dane
	 */				
  private $_daneBanery=array();				
	
  /**
   * zwraca nazwe klasy
   * @return string				
   */		
	public function getNazwaKlasy(){
	
		return $this->_nazwaKlasy;
		
	}		
	
	
  /**
   * Set typy
   * @param array $typy
   */
  public function setTypy($typy) {

		if(!empty($typy)){
			if(is_array($typy)){
		    $this->_typy=$typy;
			} else {
				$this->_typy[]=$typy;
			}
		}
		
  }		
	
	
  /**
   * Set id
   * @param array $id
   */
  public function setId($id) {

		if(!empty($id)&&is_array($id)){
	    $this->_id=array_merge($this->_id,$id);
		}
		
  }			
					
					
  /**
   * Set wykluczone
   * @param array $wykluczone
   */
  public function setWykluczone($wykluczone) {

		if(!empty($wykluczone)&&is_array($wykluczone)){
	    $this->_wykluczone=array_merge($this->_wykluczone,$wykluczone);
		}
		
  }		
	
  /**
   * Set rodzaje
   * @param array $rodzaje
   */
  public function setRodzaje($rodzaje) {

		if(!empty($rodzaje)&&is_array($rodzaje)){
	    $this->_rodzaje=array_merge($this->_rodzaje,$rodzaje);
		}
		
  }			
						
  /**
   * Get Banery
   * @return array
   */
  public function getBanery() {

		return $this->_banery;
		
  }			
	
  /**
   * Get Dane Banery
   * @return array
   */
  public function getDaneBanery() {

		return $this->_daneBanery;
		
  }			
						
																			
  /**
   * Set ile
   * @param int $ile
   */
  public function setIle($ile) {
	
		$ile=$ile+0;	

		if(is_int($ile)&&$ile>=0){
    	$this->_ile=$ile;
		} else {
			trigger_error("setIle: invalid ile value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
			
  }		
	
  /**
   * generate banners
   */	
	public function generuj(){

		$wys=array();
		
		$query="SELECT r.*, (RAND()*r.udzial) AS udzial FROM ".konf::get()->getKonfigTab("sql_tab",'rotator')." r WHERE r.status=1 ";
		
		if(!empty($this->_id)){
			$query2=tekstForm::tabQuery($this->_id);
			if(!empty($query2)){
				$query.=" AND r.id IN(".$query2.")";
			}
		}				
		
		if(!empty($this->_typy)){
			$query2=tekstForm::tabQuery($this->_typy);
			if(!empty($query2)){
				$query.=" AND r.id_typ IN(".$query2.")";
			}
		}
		
		$query.=" AND (r.data_start='0000-00-00 00:00:00' OR r.data_start<=NOW() ) AND (r.data_stop='0000-00-00 00:00:00' OR r.data_stop>=NOW()) AND (r.img!=0 OR r.link!='') AND (r.czy_licznik=0 OR (r.czy_licznik=1 AND (r.licznik_limit=0 OR r.licznik_limit>r.licznik))) AND (r.czy_klik=0 OR (r.czy_klik=1 AND (r.klik_limit=0 OR r.klik_limit>r.klik))) AND (r.lang=0 OR r.lang='".konf::get()->getLang()."') ";
		
		if(!empty($this->_rodzaje)){
			$query2=tekstForm::tabQuery($this->_rodzaje);
			if(!empty($query2)){
				$query.=" AND r.img IN(".$query2.")";
			}
		}	
		
		if(!empty($this->_wykluczone)){
			$query2=tekstForm::tabQuery($this->_wykluczone);
			if(!empty($query2)){
				$query.=" AND r.id NOT IN(".$query2.")";
			}
		}						
		
		$query.=" ORDER BY r.priorytet DESC, r.udzial DESC, RAND()";
		
		if($this->_ile){
			$query.=" LIMIT 0,".$this->_ile;
		}
		
		$zap=konf::get()->_bazasql->zap($query);
				
		while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
		
			$this->_daneBanery[$dane['id']]=$dane;
		
			$pliczek=konf::get()->getKonfigTab("rotator_kat").$dane['img_nazwa'];
			$link_klik=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"rotator_klik"));
			
			//do powiekszenia licznika
			if($dane['czy_licznik']){
				$wys[$dane['id']]=$dane['id'];
			}
			
			//baner za pomoca linku
			if(!empty($dane['link'])){
			
				$this->_banery[$dane['id']]=$dane['link'];
			
			//zwykle
			} else {
				
			  //baner swf
				if($dane['img']==4||$dane['img']==13){
				
				  $swf=new swf(konf::get()->getKonfigTab("sciezka").$pliczek,$dane['img_w'],$dane['img_h']);
					
					if($dane['img_tlo']=="xxxxxx"){
					  $swf->setParametry(array("wmode"=>"transparent"));						
					} else if(!empty($dane['img_tlo'])){
					  $swf->setParametry(array("bgcolor"=>"#".$dane['img_tlo']));
					}
					$swf->setId("baner".$dane['id']);				
					$this->_banery[$dane['id']]=$swf->pobierz();				
					
				//inne banery typu jpg, gif, bmp
				} else {			
					
					$img="";
					
					//link
					if(!empty($dane['img_link'])){
						$img.="<a href=\"";
						if($dane['czy_klik']==1){
							$img.=$link_klik."&amp;id_rotator=".$dane['id'];
						} else {
							$img.=$dane['img_link'];	
						}
						$img.="\" ";
						if(!empty($dane['link_okno'])){
							$img.=" target=\"".htmlspecialchars($dane['link_okno'])."\"";
						}
						$img.=">";
					}
					//k link
					
					$img.="<img src=\"".konf::get()->getKonfigTab("sciezka").$pliczek."\" width=\"".$dane['img_w']."\" height=\"".$dane['img_h']."\" alt=\"\" />";
					
					if(!empty($dane['img_link'])){
						$img.="</a>";
					}					

	 				if(!empty($img)){
	   				$this->_banery[$dane['id']]=$img;
				  }
					
				}
				
				//k inne
			}
			//k zwykle

		}
		konf::get()->_bazasql->freeResult($zap);
				
		//licznik wyswietlen
		if(!empty($wys)&&is_array($wys)){
			$query=tekstForm::tabQuery($wys);
			if(!empty($query)){
				konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab","rotator")." SET licznik=licznik+1 WHERE id IN(".$query.")");
			}
		}				

	}
	
				
	/**
   * class constructor php5	
   * @param array $typy
   * @param int $ile			
   */	
	public function __construct($typy,$ile=0) {	
	
		$this->setTypy($typy);
		$this->setIle($ile);
		
  }	
	
}

?>