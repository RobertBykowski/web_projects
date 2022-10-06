<?php

/**
 * Nawig class v1.1 (2006-09-29)
 * dla CMS i innych klas - obsluga nawiglacji podstron.
 * All rights reserved
 * @package Nawig class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2006 Waldemar Jonik
 */

/**
 *
 * Example:
 *

  include ("class.nawig.php");

	$nawig = new nawig($query,$podstrona,$nastr);
  $naw->naw();
  echo $naw->getNaw();	
	
 *
 */
	
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		

class nawig {

	/**
	 * Public variables
	 */


	/**
	 * Private variables
	 */		

	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="nawig class";
	
	
	/**
	 * sql query
	 */				
	private $_query="";
	
	
	/**
	 * podstrona nr
	 */				
	private $_podstrona=1;	
	
	
	/**
	 * ilosc na stronie
	 */				
	private $_nastr="";	
	
	
	/**
	 * ilosc stron
	 */				
	private $_stron=0;		
	
	
	/**
	 * ilosc wynikow
	 */				
	private $_wynikow=0;			
	
	
	/**
	 * link dolaczany
	 */				
	private $_pd="";		
	
	
	/**
	 * nawigacja
	 */				
	private $_nawig="";		
		
	
	/**
	 * start od
	 */				
	private $_start=0;			
	
	
	/**
	 * ile 
	 */				
	private $_ile=0;					
	
	
	/**
	 * max ile podstron widocznych w nawigacji
	 */				
	private $_max=6;		
	
	/**
	 * nazwa zmiennej numerujacej
	 */				
	private $_nazwa="podstrona";
	
	/**
	 * wygenerowana nawigacja
	 */				
	private $_naw="";	
	
	
	/**
	 * kotwica
	 */				
	private $_kotwica="";	
	
	
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
   * set podstrona
   * @param int $podstrona
   */		
	public function setPodstrona($podstrona){
		$podstrona=$podstrona+0;
		if(empty($podstrona)||$podstrona<0){
			$this->_podstrona=1;
		} else {
			$this->_podstrona=$podstrona;
		}
	}	
	

  /**
   * Get podstrona
   * @return int
   */
  public function getPodstrona() {
	
  	return $this->_podstrona;
		
  }	
	
	
  /**
   * set nastr
   * @param int $nastr
   */		
	public function setNastr($nastr){
	
		$nastr=$nastr+0;
		if($nastr<0){
			trigger_error("setNastr: invalid nastr value ".$this->getNazwaKlasy(),E_USER_ERROR);
		} else {
			$this->_nastr=$nastr;
		}
		
	}	
	

  /**
   * Get nastr
   * @return int
   */
  public function getNastr() {
	
  	return $this->_nastr;
		
  }		
	
	
  /**
   * set stron
   * @param int $stron
   */		
	public function setStron($stron){
	
		$stron=ceil($stron+0);

		if(empty($stron)||$stron<0){
			$this->_stron=1;
		} else {
			$this->_stron=$stron;
		}
		
	}	
	

  /**
   * Get stron
   * @return int
   */
  public function getStron() {
	
  	return $this->_stron;
		
  }		
	
	
  /**
   * set ile
   * @param int $ile
   */		
	public function setIle($ile){
	
		$ile=$ile+0;
		if($ile<0){
			trigger_error("setIle: invalid ile value ".$this->getNazwaKlasy(),E_USER_ERROR);
		} else {
			$this->_ile=$ile;
		}
		
	}	
	

  /**
   * Get ile
   * @return int
   */
  public function getIle() {
	
  	return $this->_ile;
		
  }		
	
	
  /**
   * set start
   * @param int $start
   */		
	public function setStart($start){
	
		$start=$start+0;
		if($start<0){
			trigger_error("setStart: invalid start value ".$this->getNazwaKlasy(),E_USER_ERROR);
		} else {
			$this->_start=$start;
		}
		
	}	
	

  /**
   * Get start
   * @return int
   */
  public function getStart() {
	
  	return $this->_start;
		
  }			
	
		
  /**
   * set wynikow
   * @param int $wynikow
   */		
	public function setWynikow($wynikow){
	
		$wynikow=$wynikow+0;
		if($wynikow<0){
			trigger_error("setWynikow: invalid wynikow value ".$this->getNazwaKlasy(),E_USER_ERROR);
		} else {
			$this->_wynikow=$wynikow;
		}
		
	}	
	

  /**
   * Get wynikow
   * @return int
   */
  public function getWynikow() {
	
  	return $this->_wynikow;
		
  }			
	

  /**
   * set max
   * @param int $max
   */		
	public function setMax($max){
	
		$max=$max+0;
		if(!empty($max)&&$max>0){
			$this->_max=$max;
		}
		
	}	
	

  /**
   * Get max
   * @return int
   */
  public function getMax() {
	
  	return $this->_max;
		
  }				
	
	
  /**
   * set nazwa
   * @param string $nazwa
   */		
	public function setNazwa($nazwa){
	
		if(!empty($nazwa)&&is_string($nazwa)){
			$this->_nazwa=$nazwa;
		}
		
	}	
	
	
  /**
   * set kotwica
   * @param string $kotwica
   */		
	public function setKotwica($kotwica){
	
		if(!empty($kotwica)&&is_string($kotwica)){
			$this->_kotwica="#".$kotwica;
		} else {
			$this->_kotwica="";		
		}
		
	}		
	

  /**
   * Get nazwa
   * @return string
   */
  public function getNazwa() {
	
  	return $this->_nazwa;
		
  }		
	
	
  /**
   * set pd
   * @param string $pd
   */		
	public function setPd($pd){
	
		$pd=konf::get()->zmienneLink($pd,"",true);
		
		if(strpos($pd,"?".$this->getNazwa()."=")===false&&strpos($pd,"&amp;".$this->getNazwa()."=")===false){
			if(ereg("\?*=",$pd)){ 
				$pd.="&amp;".$this->getNazwa()."="; 
			} else { 
				$pd.="?".$this->getNazwa()."="; 
			}
		}
		
		$this->_pd=$pd;			
		
	}	
	

  /**
   * Get pd
   * @param int $nr
   * @return int
   */
  public function getPd($nr) {

  	return $this->_pd.$nr.$this->_kotwica;
		
  }				
	
	
  /**
   * set nawig
   * @param string $nawig
   */		
	public function setNawig($nawig){
		if(!empty($nawig)&&is_string($nawig)){
			$this->_nawig=$nawig;
		}
	}	
	

  /**
   * Get nawig
   * @return int
   */
  public function getNawig() {
	
  	return $this->_nawig;
		
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
   * set query
   * @param string $query
   */		
	public function setQuery($query){
	
		$this->_query=$query;
		
	}	
	

  /**
   * Get query
   * @return string
   */
  public function getQuery() {
	
  	return $this->_query;
		
  }			
	
	
  /**
   * set parametry
   * @param int $wynikow
   */		
	public function setParametry($wynikow){
	
		if(!empty($this->_nastr)){

			if(empty($this->_podstrona)||empty($this->_nastr)||$wynikow<$this->_nastr){
				$this->_podstrona=1;
			}
			
			$this->setWynikow($wynikow);
			$stron=ceil($wynikow/$this->_nastr);
			if(empty($stron)){
				$stron=1;
			}
			
			if($this->_podstrona>$stron){
				$this->_podstrona=$stron;
			}
						
			$start=($this->_podstrona-1)*$this->_nastr;
			
			if($this->_podstrona<$stron){ 
				$ile=$this->_nastr; 
			} else { 
				$ile=$wynikow-($stron-1)*$this->_nastr; 
			}

			$this->setStron($stron);
			$this->setWynikow($wynikow);
			$this->setIle($ile);
			$this->setStart($start);
			
		}
		
	}					
						
		
  /**
   * oblicza parametry do nawigacji porcjowania wyników podstron SQL
   */	
	public function nawp(){

		if($this->getNastr()&&$this->getQuery()){
		
			//pobranie danych do nawigacji podstron			
			$dane=konf::get()->_bazasql->pobierzRekord($this->getQuery());
			
			if(!empty($dane)){
			
				//ile wynikow
				$this->setWynikow($dane['ilosc']);
				
				//ile wszystkich stron				
				$this->setStron($dane['ilosc']/$this->getNastr());				

				//strona >=1				
				if(!$this->getPodstrona()||$this->getPodstrona()<1||$this->getPodstrona()>$this->getStron()){ 
					$this->setPodstrona(1);
				}

				//na podstawie podstrony okresla ktore pozycje pobrac z bazy danych
				$this->setStart($this->getNastr()*($this->getPodstrona()-1));

				//obliczamy ile pobrac danych
				if($this->getPodstrona()<$this->getStron()){ 
					$this->setIle($this->getNastr());
				} else { 
					$this->setIle($this->getWynikow()-($this->getStron()-1)*$this->getNastr()); 
				}
				
			} else {
 				trigger_error("nawp: empty dane ".$this->getNazwaKlasy(),E_USER_ERROR);		
			}

		}
		
	}


  /**
   * nawigacja - rysowanie
   * @param string $pd
   * @param string $nazwa		
   */		
	public function naw($pd="",$nazwa=""){

		$txt="";

  	if ($this->getStron()>1) {
		
			if(!empty($nazwa)){
				$this->setNazwa($nazwa);
			}
			$this->setPd($pd);
			
			$txt.="<table border=\"0\" class=\"nawig\" cellspacing=\"0\" cellpadding=\"0\"><tr>";
			
			//dodatek - zmienna pomocnicza pomagajaca okreslic graniczne wyswietlane podstrony
			if(($this->getStron()-$this->getPodstrona())<=$this->getMax()){ 
				$dodatek=$this->getMax()-$this->getStron()+$this->getPodstrona(); 
			} else{ 
				$dodatek=0; 
			}

			//od ktorej strony zaczynamy
			if(($this->getPodstrona()-$dodatek)<=$this->getMax()){ 
				$start_naw=1; 
			} else{ 
				$start_naw=$this->getPodstrona()-$this->getMax()-$dodatek; 
			}
			
			//jesli nie zaczynamy od pierwszej strony to daj link do min. strony -1
			if($this->getPodstrona()>1){
				$i=$this->getPodstrona()-1;
				$txt.="<td><a href=\"".$this->getPd($i)."\">&laquo;</a></td>";				
			} else {
				$txt.="<td><span>&nbsp;</span></td>";
			}

			//okreslamy ostatni wyświetlany numer podstrony
			$dodatek=0;
			if($this->getPodstrona()<=$this->getMax()){ 
				$dodatek=$this->getMax()-$this->getPodstrona()+1; 
			}
			
			if(($this->getPodstrona()+$this->getMax()+$dodatek)<=$this->getStron()){ 
				$end_naw=$this->getPodstrona()+$this->getMax()+$dodatek; 
			} else{ 
				$end_naw=$this->getStron(); 
			}
			
			for($i=$start_naw;$i<=$end_naw;$i++){
				$txt.="<td><a ";
				if($i==$this->getPodstrona()){ 
					$txt.=" class=\"nawig_wyb\""; 
				}				
				$txt .=" href=\"".$this->getPd($i)."\">".$i."</a></td>";
			}
			
			if($end_naw<$this->getStron()){
				//dodatkowo numer ostatniej podstrony
				$txt.="<td>...</td>";
				$txt.="<td><a href=\"".$this->getPd($this->getStron())."\">";
	  	  $txt.=$this->getStron();
	    	$txt.="</a></td>";
			}
						
			//jeśli ostatni numer jest mniejszy od ilości stron to link do max. strony +1
			if($this->getStron()>$this->getPodstrona()){
				$i=$this->getPodstrona()+1;
				$txt.="<td><a href=\"".$this->getPd($i)."\">&raquo;</a></td>";
			} else {
				$txt.="<td><span>&nbsp;</span></td>";
			}
			
			$txt.="</tr></table>";
			
		}
		
		$this->setNaw($txt);
		
	}
	
  /**
   * konstruktor	
   * @param object $konfig 
   * @param string $query				
   * @param int $podstrona		
   * @param int $nastr	
   */	
	public function __construct($query,$podstrona,$nastr) {
	
		$this->setQuery($query);
		$this->setPodstrona($podstrona);
		$this->setNaStr($nastr);		
		$this->setMax(konf::get()->getKonfigTab('nawig_podstron'));				
		$this->nawp();  
		
	}		

	
}

?>