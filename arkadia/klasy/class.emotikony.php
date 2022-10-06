<?php

/**
 * emotikony class v1.2   (2009-05-21)
 * dla CMS i innych klas - obsluga wyswietlania emotikonow.
 * All rights reserved
 * @package emotikony class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2009 JW Web Development
 */

/**
 *
 * Example:
 *

  include ("class.emotikony.php");

  $emotikony=new emotikony($sciezka,$katalog,$emotikon,$rozszerzenie);
	echo $swf->pobierz();
	
	
 *
 */
	
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		

class emotikony {

	/**
	 * Public variables
	 */


	/**
	 * Private variables
	 */		

	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="emotikony class";
	
	/**
	 * sciezka do katalogu
	 */				
	private $_sciezka="";
	
	/**
	 * katalog
	 */				
	private $_katalog="grafika/emotikony/";	
	
	
	/**
	 * rozszerzenie plikow
	 */				
	private $_rozs="gif";		
	
	
	/**
	 * graficzki
	 */				
	private $_emotikon=array(
		1 => "%)",
		2 => ":D",
		3 => "8)",
		4 => ":)",
		5 => ":P",
		6 => ";)",
		7 => ":J",
		8 => ":ok",
		9 => ":(",
		10 => ":[]",
		11 => ":o",
		12 => ":bad",
		13 => "(!)",
		14 => "(?)",
		15 => "hihi!",
		16 => ":wow",
		17 => ":mniam",
		18 => ":jezyk",
		19 => ":\$\$",
		20 => ":evil",
		21 => ":love",
		22 => ":bzik",
		23 => ":happy"
	);
	
	
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
   * sciezka do katalogu
   * @param string $sciezka
   */		
	public function setSciezka($sciezka){
		$this->_sciezka=$sciezka;
	}
	
	
  /**
   * katalog
   * @param string $katalog
   */		
	public function setKatalog($katalog){
		if(!empty($katalog)){
			$this->_katalog=$katalog;
		}
	}
	
	
  /**
   * rozszerzenie
   * @param string $rozs
   */		
	public function setRozs($rozs){
		if(!empty($rozs)){
			$this->_rozs=$rozs;
		}
	}	
	
	
	
  /**
   * tablica graficzek
   * @param array $emotikon
   * @param bool $usun
   */		
	public function setEmotikon($emotikon,$usun=true){
		if(!empty($emotikon)&&is_array($emotikon)){
			if($usun){
				$this->_emotikon=$emotikon;
			} else {
				$this->_emotikon=array_push($emotikon);
			}
		}
	}		
	
			
  /**
   * rysuje emotikony w txt
   * @param string $tekst
   * @return string
   */		
	public function rysuj($tekst){
		reset($this->_emotikon);	
		while(list($key,$val)=each($this->_emotikon)){
	    $tekst=str_replace(" ".$val," <img src=\"".$this->_sciezka.$this->_katalog.$key.".".$this->_rozs."\" style=\"vertical-align: text-top\" border=\"0\"  alt=\"".htmlspecialchars($val)."\" /> ",$tekst);
		}
	  return $tekst;
	}
	
	
  /**
   * wyświetla liste emotikonów wklejanych do formularza w zdefiniowane pole
   * @param string $form
   * @param string $pole		
   * @return string
   */		
	public function wyswietl($form,$pole){

		$html="";
		
		if(!empty($form)&&!empty($pole)){
			$html.="<div class=\"emotikony\">";
		  while (list($key,$val)=each($this->_emotikon)) {
		 		$html.="<a href=\"javascript:void(null);\" onclick=\"emotikony_obrazek('".$pole."',' ".$val." ');\" onmouseover=\"window.status='".$val."'; return true;\" onmouseout=\"window.status='';\"><img src=\"".$this->_sciezka.$this->_katalog.$key.".".$this->_rozs."\" style=\"margin-right:1px; margin-left:1px;\" border=\"0\" alt=\"".htmlspecialchars($val)."\" /></a> ";
	  	}
			$html.="</div>";
		} else {
			trigger_error("wyswietl: invalid or empty form, pole walues ".$this->getNazwaKlasy(),E_USER_ERROR);		
		}
		
		return $html;
		
	}			
	
  /**
   * konstruktor
   * @param string $sciezka
   * @param string $katalog	
   * @param array $emotikon		
   * @param string $rozs
   */	
	public function __construct($sciezka="",$katalog="",$emotikon="",$rozs="") {	
		$this->setSciezka($sciezka);
		$this->setKatalog($sciezka);
		$this->setEmotikon($sciezka,true);
		$this->setRozs($sciezka);				
  }	

	
}

?>