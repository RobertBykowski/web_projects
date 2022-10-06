<?php

/**
 * zapiszGrafike class v1.0
 * dla CMS i innych klas - zapisuje z formularza grafike do katalogu i tworzy kod sql z danymi.
 * All rights reserved
 * @package zapiszGrafike class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2007 Waldemar Jonik
 */

/**
 *
 * Example:
 *

  require_once("class.zapiszgrafike.php");
	$grafika=new zapiszGrafike(11,"/pics/art/","pic","img",$dane);
	$grafika->wykonaj();
	
	$sql=$grafika->getSql()
	
 *
 */
	
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		


class zapiszGrafike {

	/**
	 * Public variables
	 */

	/**
	 * Private variables
	 */
		
	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="zapiszGrafike class";

	
	/**
	 * id
	 */					
	private $_id="";		
	
	/**
	 * katalog docelowy
	 */					
	private $_katalog="";
	
	/**
	 * nazwa zmiennej z tablicy _FILES
	 */					
	private $_zmienna="";			
		
	/**
	 * nazwa pola sql
	 */					
	private $_nazwa="";			
	
	/**
	 * czy wszystkie wersje grafiki musza zapisac sie
	 */					
	private $_wszystkie=true;				
	
	/**
	 * czy imgUsun
	 */					
	public $_imgUsun=false;	
	
	/**
	 * kod sql
	 */					
	private $_sql="";		
	
	/**
	 * dotychczasowe dane
	 */					
	private $_dane=array();				
	
	/**
	 * dane grafik
	 */					
	private $_daneImg=array();		
	
	/**
	 * nazwa oryginal - oryginalna nazwa pliku
	 */					
	public $_nazwaOryginal="";				
	
	/**
	 * typ - typ pliku
	 */					
	public $_typ=0;
	
	/**
	 * plik zrodlowy, w zastepstwie zmiennej z formularza
	 */					
	private $_plikzrodlowy="";	
	
	/**
	 * pusta grafika
	 */				
	private $_puste=array(
	 	'nazwa_pliku'=>"",
	 	'w'=>0,
	 	'h'=>0
	);		
	

  /**
   * zwraca nazwe klasy
   * @return string				
   */		
	public function getNazwaKlasy(){
	
		return $this->_nazwaKlasy;
		
	}		
							
			
  /**
   * Set id
   * @param int $id
   */
  public function setId($id) {
	
		$id=$id+0;	

		if(is_int($id)&&$id>0){
    	$this->_id=$id;
		} else {
			trigger_error("setId: invalid id value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
			
  }			


  /**
   * Set katalog
   * @param string $katalog
   */
  public function setKatalog($katalog) {

		if(!empty($katalog)){
	    $this->_katalog=$katalog;
		} else {
			trigger_error("setKatalog: invalid or empty katalog value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}				

  }		
	
	
  /**
   * Set pliksrodlowy
   * @param string $katalog
   */
  public function setPlikzrodlowy($plik) {

		if(!empty($plik)){
	    $this->_plikzrodlowy=$plik;
		} else {
	    $this->_plikzrodlowy="";
		}				

  }			
					
					
  /**
   * Set zmienna
   * @param string $zmienna
   */
  public function setZmienna($zmienna) {

		if(!empty($zmienna)){
	    $this->_zmienna=$zmienna;
		} else {
			trigger_error("setZmienna: invalid or empty zmienna value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}				

  }		
									
  /**
   * Set nazwa
   * @param string $nazwa
   */
  public function setNazwa($nazwa) {

		if(!empty($nazwa)){
	    $this->_nazwa=$nazwa;
		} else {
			trigger_error("setNazwa: invalid or empty nazwa value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}				

  }		
	
	
  /**
   * Set dane
   * @param array $dane
   */
  public function setDane($dane) {

		if(!empty($dane)&&is_array($dane)){
	    $this->_dane=$dane;
		}		

  }		

  /**
   * Set wszystkie
   * @param bool $wszytkie
   */
  public function setWszystkie($wszystkie) {
	
		if(!empty($wszystkie)){
    	$this->_wszystkie=true;
		} else {
    	$this->_wszystkie=false;
		}		
			
  }			
	
	
  /**
   * Set imgUsun
   * @param bool $imgUsun
   */
  public function setImgUsun($imgUsun) {
	
		if(!empty($imgUsun)){
    	$this->_imgUsun=true;
		} else {
    	$this->_imgUsun=false;
		}		
			
  }					
											
  /**
   * Set daneImg
   * @param int $indeks
   */
  public function setDaneImg($indeks,$dane) {
	
		$indeks=$indeks+0;	

		if(is_int($indeks)&&$indeks>0){
								
			if(empty($dane['hmax'])||$dane['hmax']<0){
				$dane['hmax']=0;
			}
			if(empty($dane['wmax'])||$dane['wmax']<0){
				$dane['wmax']=0;
			}			
			if(empty($dane['hmin'])||$dane['hmin']<0){
				$dane['hmin']=1;
			}
			if(empty($dane['wmin'])||$dane['wmin']<0){
				$dane['wmin']=1;
			}						
			if(empty($dane['sizemax'])||$dane['sizemax']<0){
				$dane['sizemax']=0;
			}
			if(empty($dane['skala'])||$dane['skala']<=0){
				$dane['skala']=3;
			}			
			if(empty($dane['typy'])||!is_array($dane['typy'])){
				$dane['typy']=array(2=>2);
			}			
			
			if(empty($dane['x1'])||$dane['x1']<0){
				$dane['x1']=0;
			}		
			if(empty($dane['y1'])||$dane['y1']<0){
				$dane['y1']=0;
			}					
			if(empty($dane['x2'])||$dane['x2']<0){
				$dane['x2']=0;
			}					
			if(empty($dane['y2'])||$dane['y2']<0){
				$dane['y2']=0;
			}			
			
			if(empty($dane['obrot'])){
				$dane['obrot']=0;
			}									
			
			$this->_daneImg[$indeks]=$dane;
			
		} else {
			trigger_error("setIndeks: invalid indeks value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
			
  }		
				
				
  /**
   * usun Img
   */
  public function usunImg() {
	
		if($this->_imgUsun){
	
			if(!empty($this->_daneImg)&&!empty($this->_katalog)&&!empty($this->_nazwa)){
				
				$daneimg=$this->_daneImg;				
				reset($daneimg);
				
				while(list($key,$val)=each($daneimg)){
				
					//stara grafika
	  		  if(!empty($this->_dane[$this->_nazwa.$key.'_nazwa'])&&file_exists(konf::get()->getKonfigTab("serwer").$this->_katalog.$this->_dane[$this->_nazwa.$key.'_nazwa'])){						
	 					unlink(konf::get()->getKonfigTab("serwer").$this->_katalog.$this->_dane[$this->_nazwa.$key.'_nazwa']); 
					}

					//nowa grafika
	  		  if(!empty($val['nazwa_pliku'])&&file_exists(konf::get()->getKonfigTab("serwer").$this->_katalog.$val['nazwa_pliku'])){						
	 					unlink(konf::get()->getKonfigTab("serwer").$this->_katalog.$val['nazwa_pliku']); 
					}

				}	

			} else {
				trigger_error("usunImg: invalid or empty img data ".$this->getNazwaKlasy(),E_USER_ERROR);
			}		
			
		}
									
	}
	
	
	
  /**
   * ustaw Img
   */
  public function ustawImg() {
	
		if(!empty($this->_daneImg)&&!empty($this->_katalog)&&!empty($this->_nazwa)){
			
			reset($this->_daneImg);
			
			while(list($key,$val)=each($this->_daneImg)){
				
				$this->_daneImg[$key]=array_merge($this->_daneImg[$key],$this->_puste);
				
			}	
										
			$this->_nazwaOryginal="";		
			$this->_typ=0;
				
		} else {
			trigger_error("usunImg: invalid or empty img data ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		

									
	}		
									

  /**
   * wykonaj akcje
   */
  public function wykonaj() {
	
		if(!empty($this->_daneImg)&&!empty($this->_katalog)&&!empty($this->_nazwa)&&!empty($this->_id)){
			
			$this->ustawImg();	
							
			if((!empty($_FILES[$this->_zmienna])&&!empty($_FILES[$this->_zmienna]["tmp_name"]))||$this->_plikzrodlowy){			

				$this->setImgUsun(true);
	
				$i=0;
				
				$pierwszy="";					

				require_once(konf::get()->getKonfigTab('klasy')."class.plikzapisz.php");					

				ksort($this->_daneImg);			
				reset($this->_daneImg);			
							
				while(list($key,$val)=each($this->_daneImg)){	
				
					if(isset($pliczek)){
						unset($pliczek);
						$pliczek=false;
					}

					$pliczek=new plikZapisz(konf::get()->getKonfigTab("serwer").$this->_katalog.$this->_id."_".$this->_nazwa.$key."_[md5oryginal].[rozs]");
					
					//dla pierwszego odczyt z formularza

					if($i==0){
						if(!empty($_FILES[$this->_zmienna])&&!empty($_FILES[$this->_zmienna]['name'])){
							$pliczek->zmiennaFiles($this->_zmienna);					
						} else if($this->_plikzrodlowy){
							$pliczek->kopiujPlik($this->_plikzrodlowy);		
						}						
					} else {
						$pliczek->kopiujPlik(konf::get()->getKonfigTab("serwer").$this->_katalog.$pierwszy);
					}
				
					$pliczek->setSizeMax($val['sizemax']);				
					$pliczek->setImgTypy($val['typy']);
					$pliczek->setImgSkala($val["skala"]);		
					$pliczek->setImgSize(array("hmax"=>$val["hmax"],"wmax"=>$val["wmax"],"hmin"=>$val["hmin"],"wmin"=>$val["wmin"]));								
					$pliczek->setCrop($val['x1'],$val['x2'],$val['y1'],$val['y2']);							
					$pliczek->setObrot($val['obrot']);								
					$img=$pliczek->zapiszImg();	
					
					if($i==0){
						$this->usunImg();
					}

					//jesli  nie zapisal sie
					if(!$img['ok']||empty($img['name'])){	
						//pokaz bledy
						konf::get()->setKomunikatI($img['komunikat'],"error");	

						//jesli trzeba przerwij petle i usun dotychczasowe grafiki
						if($this->_wszystkie||$i==0){					
							$this->usunImg();
							break;
						}					
							
					} else {
						
						//dla pierwszego odczytaj oryginalne dane
						if($i==0){
							$this->_nazwaOryginal=$img['name'];				
							$this->_typ=$img['imgtyp'];
							$pierwszy=$img['nazwa_pliku'];
						}
						
						//zapisz do tablicy
						$this->_daneImg[$key]=array_merge($this->_daneImg[$key],array("nazwa_pliku"=>$img['nazwa_pliku'],"w"=>$img['w'],"h"=>$img['h']));
																
					}
					
					$i++;
				
				}	
				
			} else {
				//usuwanie, jesli tylko trzeba usunac, bez dodawania nowej grafiki
				$this->usunImg();
				
			}
			
			$this->setSql();
					
		} else {
			trigger_error("wykonaj: invalid data".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
		
	}
	
	
  /**
   * generuj kod SQL
   * @return string
   */
  public function setSql() {		
	
		if(!empty($this->_daneImg)&&!empty($this->_katalog)&&!empty($this->_nazwa)){
		
			if($this->_imgUsun){
					
				$this->_sql=" ".$this->_nazwa."='".$this->_typ."', ".$this->_nazwa."_nazwa_oryginal='".$this->_nazwaOryginal."'";			
				
				reset($this->_daneImg);
				
				while(list($key,$val)=each($this->_daneImg)){				

					$this->_sql.=", ".$this->_nazwa.$key."_nazwa='".tekstForm::doSql($val['nazwa_pliku'])."', ".$this->_nazwa.$key."_w='".$val['w']."', ".$this->_nazwa.$key."_h='".$val['h']."'";
					
				}
				
			}

		} else {
			trigger_error("wykonaj: invalid data".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
	
	}
	
	
  /**
   * pobierz kod SQL
   * @return string
   */
  public function getSql() {	

		return $this->_sql;
	
	}			
	
			
	/**
   * class konstructor php5	  
	 * @param int $id
   * @param string $katalog
   * @param string $zmienna
   * @param string $nazwa
   * @param array $dane
   */	
	public function __construct($id,$katalog,$zmienna,$nazwa,$dane="") {	

		$this->setId($id);		
		$this->setKatalog($katalog);
		$this->setZmienna($zmienna);
		$this->setNazwa($nazwa);
		$this->setDane($dane);		
		
  }	

}

?>