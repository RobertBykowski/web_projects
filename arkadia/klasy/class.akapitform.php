<?php

/**
 * AkapitForm class v1.0
 * dla CMS i innych klas - formatowanie akapitu.
 * All rights reserved
 * @package AkapitForm class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2006 Waldemar Jonik
 */

/**
 *
 * Example:
 *

  require_once("class.akapitform.php");
	$akapit=new akapitForm($tresc,$typ);
	echo $akapit->_zwrot();
	
 *
 */
	
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		

	
class akapitForm {

	/**
	 * Public variables
	 */

	/**
	 * Private variables
	 */
		
	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="AkapitForm class";
	
	
	/**
	 * typ akapitu: 0 = html, 1=txt
	 */					
	private $_typ=0;
	
	/**
	 * tresc akapitu
	 */					
	private $_tresc="";
	
	/**
	 * tytul akapitu
	 */					
	private $_tytul="";	
	
	/**
	 * img nazwa pliku
	 */					
	private $_imgNazwa="";			
	
	/**
	 * img nazwa pliku duzego
	 */					
	private $_imgNazwaB="";				
		
	/**
	 * img align
	 */					
	private $_imgAlign=0;			
		
	/**
	 * img w
	 */					
	private $_imgW=0;			
	
	/**
	 * img h
	 */					
	private $_imgH=0;		
		
	/**
	 * img w
	 */					
	private $_imgWB=0;			
	
	/**
	 * img h
	 */					
	private $_imgHB=0;			
	
	/**
	 * img link
	 */					
	private $_imgLink="";			
	
	/**
	 * img link okno
	 */					
	private $_imgLinkOkno="";			
	
	/**
	 * img opis
	 */					
	private $_imgOpis="";			
	
	/**
	 * img class
	 */					
	private $_imgClass="";			
			
	/**
	 * akapit class
	 */					
	private $_akapitClass="nowa_l";		
		
	/**
	 * autolink
	 */					
	private $_autolink=false;			
	
	/**
	 * literki
	 */					
	private $_literki=true;			
	
	/**
	 * lightbox
	 */					
	public $_lightbox=true;				
	
	/**
	 * autolink
	 */					
	private $_phpbb=false;				
	
	/**
	 * linia znakow
	 */					
	private $_liniaZnakow=0;			
	
	/**
	 * html
	 */					
	private $_html="";			
	
	
	/**
	 * dane
	 */					
	private $_dane=array();				
		
	
  /**
   * zwraca nazwe klasy
   * @return string				
   */		
	public function getNazwaKlasy(){
	
		return $this->_nazwaKlasy;
		
	}		
	

  /**
   * Set typ
   * @param int $typ
   */
  public function setTyp($typ) {
	
		$typ=$typ+0;

		if(is_int($typ)&&$typ>=0){
    	$this->_typ=$typ;
		} else {
			trigger_error("setTyp: invalid typ value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
			
  }				
	
	
  /**
   * Set dane
   * @param array $dane
   */
  public function setDane($dane) {

		if(is_array($dane)){
			$this->_dane=$dane;
		} else {
			trigger_error("setDane: invalid dane value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
			
  }		
					
		
  /**
   * Set tresc
   * @param string $tresc
   */
  public function setTresc($tresc) {

    $this->_tresc=$tresc;

  }			
	
  /**
   * Set tytul
   * @param string $tytul
   */
  public function setTytul($tytul) {

    $this->_tytul=$tytul;

  }			
		
	
  /**
   * Set imgNazwa
   * @param string $imgNazwa
   */
  public function setImgNazwa($imgNazwa) {

		if(file_exists(konf::get()->getKonfigTab("serwer").$imgNazwa)){
    	$this->_imgNazwa=$imgNazwa;
		} else {
    	$this->_imgNazwa="";		
		}

  }				
			
  /**
   * Set imgLink
   * @param string $imgLink
   */
  public function setImgLink($imgLink) {

    $this->_imgLink=$imgLink;

  }		
	
  /**
   * Set imgLinkOkno
   * @param string $imgLinkOkno
   */
  public function setImgLinkOkno($imgLinkOkno) {

    $this->_imgLinkOkno=$imgLinkOkno;

  }				
						
  /**
   * Set imgOpis
   * @param string $imgOpis
   */
  public function setImgOpis($imgOpis) {

    $this->_imgOpis=$imgOpis;

  }											
			
  /**
   * Set imgAlign
   * @param int $imgAlign
   */
  public function setImgAlign($imgAlign) {
	
		$imgAlign=$imgAlign+0;	

		if(is_int($imgAlign)&&$imgAlign>=0){
    	$this->_imgAlign=$imgAlign;
		} else {
			trigger_error("setImgAlign: invalid imgAlign value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
			
  }			
	
  /**
   * Set imgClass
   * @param string $imgClass
   */
  public function setImgClass($imgClass) {

    $this->_imgClass=$imgClass;

  }		
		
  /**
   * Set imgW
   * @param int $imgW
   */
  public function setImgW($imgW) {
	
		$imgW=$imgW+0;

		if(is_int($imgW)&&$imgW>=0){
    	$this->_imgW=$imgW;
		} else {
			trigger_error("setImgW: invalid imgW value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
			
  }			
	
  /**
   * Set imgH
   * @param int $imgH
   */
  public function setImgH($imgH) {
	
		$imgH=$imgH+0;	

		if(is_int($imgH)&&$imgH>=0){
    	$this->_imgH=$imgH;
		} else {
			trigger_error("setImgH: invalid imgH value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
			
  }		
	
	
  /**
   * Set imgNazwa
   * @param string $imgNazwa
   */
  public function setImgNazwaB($imgNazwa) {

		if(file_exists(konf::get()->getKonfigTab("serwer").$imgNazwa)){
    	$this->_imgNazwaB=$imgNazwa;
		} else {
    	$this->_imgNazwaB="";		
		}

  }		
			
  /**
   * Set imgW
   * @param int $imgW
   */
  public function setImgWB($imgW) {
	
		$imgW=$imgW+0;

		if(is_int($imgW)&&$imgW>=0){
    	$this->_imgWB=$imgW;
		} else {
			trigger_error("setImgW: invalid imgW value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
			
  }			
	
  /**
   * Set imgH
   * @param int $imgH
   */
  public function setImgHB($imgH) {
	
		$imgH=$imgH+0;	

		if(is_int($imgH)&&$imgH>=0){
    	$this->_imgHB=$imgH;
		} else {
			trigger_error("setImgH: invalid imgH value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
			
  }					
	
  /**
   * Set liniaZnakow
   * @param int $liniaZnakow
   */
  public function setLiniaZnakow($liniaZnakow) {

		if(is_int($liniaZnakow)&&$liniaZnakow>=0){
    	$this->_liniaZnakow=$liniaZnakow;
		} else {
			trigger_error("setLiniaZnakow: invalid liniaZnakow value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
			
  }				
		
  /**
   * Set phpbb
   * @param bool $phpbb
   */
  public function setPhpbb($phpbb) {

		if(!empty($phpbb)){
    	$this->_phpbb=true;
		} else {
    	$this->_phpbb=false;		
		}		
			
  }				
	
  /**
   * Set autolink
   * @param boll $autolink
   */
  public function setAutolink($autolink) {

		if(!empty($autolink)){
    	$this->_autolink=true;
		} else {
    	$this->_autolink=false;		
		}		
			
  }			
	
  /**
   * Set literki
   * @param boll $literki
   */
  public function setLiterki($literki) {

		if(!empty($literki)){
    	$this->_literki=true;
		} else {
    	$this->_literki=false;		
		}		
			
  }			
	
  /**
   * Set akapitClass
   * @param string $akapitClass
   */
  public function setAkapitClass($akapitClass) {

    $this->_akapitClass=$akapitClass;

  }		
	
	
  /**
   * zwrot danych
   * @return string
   */
  public function zwrot() {

		$styl="";
		
		if(!empty($this->_dane['tlo_kolor'])&&$this->_dane['tlo_kolor']!="#"){
			$styl.="background-color:#".$this->_dane['tlo_kolor']."; ";
		}
		
		if(!empty($this->_dane['ramka'])&&!empty($this->_dane['ramka_kolor'])&&$this->_dane['ramka_kolor']!="#"){
			$styl.="border:".$this->_dane['ramka']."px solid #".$this->_dane['ramka_kolor']."; ";
		}		
		
		if(!empty($this->_dane['padding'])){
			$styl.="padding:".$this->_dane['padding']."px; ";
		}
		
		if(!empty($this->_dane['dlugosc'])&&$this->_dane['dlugosc']<100){
			$styl.="width:".$this->_dane['dlugosc']."%; margin:auto; ";
		}		
				
		$this->_html.="<div";
	  if($this->_akapitClass){ 			
 			$this->_html.=" class=\"".$this->_akapitClass."\"";
		}
		if(!empty($styl)){
 			$this->_html.=" style=\"".$styl."\"";			
		}
		$this->_html.=">";	
		
		if($this->_tytul){
			$html.="<h2>".$this->_tytul."</h2>";
		}
		
		if($this->_imgNazwa){
		
			if($this->_imgAlign==3){ 
		    $this->_html.="<div class=\"srodek\">"; 
		  }
			
		  if($this->_imgLink){ 
			
			  $this->_html.="<a href=\"".$this->_imgLink."\""; 
				
				if($this->_imgLinkOkno){ 
		      $this->_html.=" target=\"".tekstForm::doForm($this->_imgLinkOkno)."\""; 
		    }
				
		    $this->_html.=">"; 
				
		  } else if($this->_lightbox&&$this->_imgNazwaB){
			
				konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/jquery-min.js","js");
				konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/slimbox/slimbox2.js","js");					
				konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/slimbox/slimbox2.css","css");												
				$this->_html.="<a href=\"".konf::get()->getKonfigTab("sciezka").$this->_imgNazwaB."\" rel=\"lightbox-a".$this->_dane['id']."\" title=\"".tekstForm::doForm($this->_imgOpis)."\">";
				
			}			   
			            
		  $this->_html.="<img src=\"".konf::get()->getKonfigTab("sciezka").$this->_imgNazwa."\"";
			
			if($this->_imgW){
				$this->_html.=" width=\"".$this->_imgW."\"";
			}
			
			if($this->_imgH){
				$this->_html.=" height=\"".$this->_imgH."\"";
			}	
					
		  if($this->_imgClass){ 			
	 			$this->_html.=" class=\"".$this->_imgClass."\"";
			}
			
		  if($this->_imgAlign==2){ 
		  	$this->_html.=" style=\"float:right; margin-left:12px;\""; 
		  } else if ($this->_imgAlign!=3){ 
		    $this->_html.=" style=\"float:left; margin-right:12px;\""; 
		  }
			
		  $this->_html.=" alt=\"".tekstForm::doForm($this->_imgOpis)."\" title=\"".tekstForm::doForm($this->_imgOpis)."\"";
			
		  $this->_html.=" />";
			
		  if($this->_imgLink||($this->_lightbox&&$this->_imgNazwaB)){ 
		    $this->_html.="</a>"; 
		  }
			
		  if($this->_imgAlign==3){ 
		  	$this->_html.="</div>"; 
		  }
			
		}

		//tryb bez edytora, reczne formatowanie
		if($this->_typ==1){

			if(!$this->_phpbb){
				$this->_tresc=tekstForm::zlamStringa($this->_tresc,$this->_liniaZnakow,true,$this->_autolink);     
			} else {
				$this->_tresc=tekstForm::bbForm($this->_tresc);
			}

		}
		
		if($this->_literki){
			$this->_tresc=tekstForm::literki($this->_tresc);						
		}
		
		if(!(strpos($this->_tresc,"rel=\"lightbox\"")===false)){		
			konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/jquery-min.js","js");
			konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/slimbox/slimbox2.js","js");				
			konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/slimbox/slimbox2.css","css");				
		}
			
		$this->_html.=$this->_tresc;
			
		$this->_html.="</div>";    
		
		return $this->_html;
		
	}
					
										
				
	/**
   * class constructor php5	
   * @param string $tresc					
   * @param int $typ				
   */	
	public function __construct($tresc,$typ) {	
	
		$this->setTresc($tresc);
		$this->setTyp($typ);

  }	
	
}

?>