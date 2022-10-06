<?php

/**
 * SWF class v1.1 (2006-09-29)
 * dla CMS i innych klas - obsluga wyswietlania SWF.
 * All rights reserved
 * @package SWF class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2006 Waldemar Jonik
 */

/**
 *
 * Example:
 *

  include ("class.swf.php");

  $swf=new swf("przyklad.swf",450,50);
  $swf->setParametry(array("wmode"=>"transparent"));
	echo $swf->pobierz();
	
	
 *
 */
	
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		

class swf {

	/**
	 * Public variables
	 */


	/**
	 * Private variables
	 */		

	/**
	 * nazwa klasy
	 */				
  var $_nazwaKlasy="swf class";
	
	/**
	 * nazwa pliku
	 */				
	var $_nazwa="";
	
	/**
	 * dlugosc
	 */			
	var $_w=0;
	
	/**
	 * szerokosc
	 */				
	var $_h=0;	
	
	/**
	 * wersja flash
	 */				
	var $_wersja=6;
		
	/**
	 * swf js in html header
	 */				
	var $_htmlheader=true;	
	
	/**
	 * alt for swf
	 */				
	var $_alt="";		

	/**
	 * id
	 */				
	var $_id="";	


	/**
	 * parametry
	 */				
	var $_parametry=array(
	  "allowScriptAccess"=>"sameDomain",
	  "wmode"=>"opaque",
	  "quality"=>"high",
	  "bgcolor"=>"#ffffff"
	);	
	
	
	/**
	 * zmienne
	 */				
	var $_zmienne=array();	
	
	
	/**
	 * czy wersja xhtml
	 */				
	var $_xhtml=false;	
	
	/**
	 * czy wersja js
	 */		
	var $_js=true;
	
	
	/**
	 * Public methods
	 */
			

  /**
   * zwraca nazwe klasy
   * @return string				
   */		
	function getNazwaKlasy(){
		return $this->_nazwaKlasy;
	}	
	
  /**
   * wersja swf
   * @param int $wersja
   */		
	function setWersja($wersja){
		$wersja=$wersja+0;
		if(empty($wersja)||!is_integer($wersja)||$wersja<0){
			$this->trigger_error("setWersja: invalid  wersja value ".$this->getNazwaKlasy(),E_USER_ERROR);
		} else {
			$this->_wersja=$wersja;
		}
	}
	
  /**
   * czy wersja xhtml kodu
   * @param bool $xhtml
   */		
	function setXhtml($xhtml){
		if($xhtml){
			$this->_xhtml=true;
		} else {
			$this->_xhtml=false;
		}
	}	
	
	
  /**
   * czy wersja xhtml kodu
   * @param bool $xhtml
   */		
	function setJs($js){
		if($js){
			$this->_js=true;
		} else {
			$this->_js=false;
		}
	}	
	
	
  /**
   * czy js w header
   * @param bool $htmlheader
   */		
	function setHtmlheader($htmlheader){
		if($htmlheader){
			$this->_htmlheader=true;
		} else {
			$this->_htmlheader=false;
		}
	}		
		
	
  /**
   * id
   * @param string $id
   */		
	function setId($id){
		$id=strip_tags($id);
		$this->_id=$id;
	}	
	
	
  /**
   * czy wersja xhtml kodu
   * @param string $alt
   */		
	function setAlt($alt){
		$this->_alt=$alt;
	}		
	

  /**
   * dodaje zmienne
   * @param array $zmienne
   */		
	function setZmienne($zmienne){
		if(empty($zmienne)||!is_array($zmienne)){	
			trigger_error("setZmienne: invalid array zmienne ".$this->getNazwaKlasy(),E_USER_ERROR);		
		} else {
			reset($zmienne);
			while(list($key,$val)=each($zmienne)){			
				$this->_zmienne[strip_tags($key)]=strip_tags($val);
			}
		}
	}		
	
	
  /**
   * dodaje parametry
   * @param array $parametry
   */		
	function setParametry($parametry){
		if(empty($parametry)||!is_array($parametry)){
			trigger_error("setParametry: invalid array parametry ".$this->getNazwaKlasy(),E_USER_ERROR);		
		} else {
			reset($parametry);
			while(list($key,$val)=each($parametry)){			
				$this->_parametry[strip_tags($key)]=strip_tags($val);
			}
		}
	}			
			
			
  /**
   * wyswietla kod do swf
   * @return string						
   */	
	function pobierz(){

		$html="";
		$html2="";
		
		if(!empty($this->_nazwa)&&!empty($this->_w)&&!empty($this->_h)){
		
			if(!empty($this->_parametry['wmode'])&&$this->_parametry['wmode']=="transparent"){
				$this->_parametry['bgcolor']="";
			}		
		
			if($this->_js){
			
				if($this->_id){
			 		$html.="<div id=\"".$this->_id."\">".$this->_alt."</div>\n";
										
					$html2.="<script type=\"text/javascript\">\n";
					
					//zmienne
					$html2.="var flashvars = {};\n";										
					if(!empty($this->_zmienne)&&is_array($this->_zmienne)){					
						reset($this->_zmienne);			
						while(list($key,$val)=each($this->_zmienne)){		
							$html2.="flashvars.".htmlspecialchars($key)." = \"".$val."\";\n";											
						}
					}		

					//parametry
					$html2.="var params = {};\n";								
					reset($this->_parametry);
					while(list($key,$val)=each($this->_parametry)){
						$html2.="params.".htmlspecialchars($key)." = \"".htmlspecialchars($val)."\";\n";							
					}						
					
					$html2.="swfobject.embedSWF('".$this->_nazwa."','".$this->_id."','".$this->_w."','".$this->_h."','".$this->_wersja."', false, flashvars, params);\n";
					$html2.="</script>\n";
					
					if($this->_htmlheader){
						konf::get()->setKod("kodheader",$html2);	
					} else {
						$html.=$html2;
					}
				} else {
					trigger_error("wyswietl: empty id ".$this->getNazwaKlasy(),E_USER_ERROR);
				}
				
			} else {
			
				$html.="<object width=\"".$this->_w."\" height=\"".$this->_h."\"";
				
				//dla zwyklego
				if(!$this->_xhtml){
					$html.=" classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=".$this->_wersja.",0,0,0\"";
				} else {
				//dla xhtml
					$html.=" type=\"application/x-shockwave-flash\" data=\"".$this->_nazwa."\"";
				}
				
				//id	
				if(!empty($this->_id)){
					$html.=" id=\"".$this->_id."\"";
				}
				$html.=">";
				
				//parametry
				reset($this->_parametry);
				while(list($key,$val)=each($this->_parametry)){
					if(!empty($val)){
						$html.="<param name=\"".htmlspecialchars($key)."\" value=\"".htmlspecialchars($val)."\" />";
					}
				}
				
				//zmienne
				if(!empty($this->_zmienne)&&is_array($this->_zmienne)){
				
					reset($this->_zmienne);				
					$vars="";
					while(list($key,$val)=each($this->_zmienne)){
						if(!empty($val)){
							$vars.="&amp;".htmlspecialchars($key)."=".htmlspecialchars($val);
						}
					}		
					$html.="<param name=\"FlashVars\" value=\"".$vars."\" />";	
				}
				$html.="<param name=\"movie\" value=\"".$this->_nazwa."\" />";					
				if(!$this->_xhtml){					
					$html.="<embed src=\"".$this->_nazwa."\" width=\"".$this->_w."\" height=\"".$this->_h."\"";
					if(!empty($this->_id)){
						$html.=" name=\"".$this->_id."\"";
					}		
					//parametry
					reset($this->_parametry);
					while(list($key,$val)=each($this->_parametry)){
						if(!empty($val)){
							$html.=" ".strtolower(htmlspecialchars($key))."=\"".htmlspecialchars($val)."\"";
						}
					}		
					//zmienne - wygenerowane wczesniej	
					if(!empty($vars)){
						$html.=" flashvars=\"".$vars."\">";
					}
					$html.=" type=\"application/x-shockwave-flash\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" />";
				}			
				$html.="</object>";
				
			}
			
		} else {
			trigger_error("wyswietl: invalid file to display ".$this->getNazwaKlasy(),E_USER_ERROR);
		}
		
		return $html;
	}
	
	
	/**
   * class constructor php5	
   * @param string $nazwa
   * @param int $w		
   * @param int $h	
   * @param string $alt
   * @param bool $htmlheader
   */	
	function __construct($nazwa,$w,$h,$alt="",$htmlheader=true) {	
		if(empty($nazwa)){
			trigger_error("_contruct: invali nazwa ".$this->getNazwaKlasy(),E_USER_ERROR);
		} else {
			$this->_nazwa=$nazwa;
			$w=$w+0;
			$h=$h+0;
			if(empty($w)||!is_integer($w)||$w<0){
				trigger_error("_contruct: invali width value ".$this->getNazwaKlasy(),E_USER_ERROR);				
			} else {
				$this->_w=$w;
			}
			 if(empty($h)||!is_integer($h)||$h<0){				 
				trigger_error("_contruct: invali height value ".$this->getNazwaKlasy(),E_USER_ERROR);				
			} else {
				$this->_h=$h;
			}
			$this->setAlt($alt);
			$this->setHtmlheader($htmlheader);
		}
  }	

}

?>