<?php

/**
 * Formularz class v1.1 (2009-05-21)
 * dla CMS i innych klas - tworzenie formularzy
 * @package rss class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2009 JW Web Development
 */

/**
 *
 * Example:
 *

  require_once("class.konfig.php");	
  require_once("class.formularz.php");

 *
 */
	
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		


class formularz {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="formularz class";
	

	/**
	 * akcja formularza
	 */				
  private $_action="";			
	
	
	/**
	 * typ formularza (post/get)
	 */				
  private $_methd="post";		
	
	
	/**
	 * nazwa formularza
	 */				
  private $_nazwa="";		
	
	
	/**
	 * id formularza
	 */				
  private $_id="";		
	
	
	/**
	 * typu multipart
	 */				
  private $_multipart=false;
	
	
	/**
	 * form target
	 */				
  private $_target="";	
	
	
	/**
	 * kontrola czy byl kalendarz
	 */				
  private $_bylkalendarz=false;	
	
	
	/**
	 * kontrola czy byl fck
	 */				
  private $_bylfck=false;		
	
	
	/**
	 * kontrola czy byl slider
	 */				
  private $_bylslider=false;		
		
	
	/**
	 * hindden przenies
	 */				
  private $_przenies=array();
		
	
	/**
	 * kod onsubmit
	 */				
  private $_onsubmit=array();
	
	
  /**
   * zwraca nazwe klasy
   * @return string				
   */		
	public function getNazwaKlasy(){
	
		return $this->_nazwaKlasy;
		
	}		
	
	
  /**
   * Set nazwa
   * @param string $nazwa
   */
  public function setNazwa($nazwa) {
		
  	if($nazwa!=''&&is_string($nazwa)){
      $this->_nazwa=$nazwa;
		} else {
			trigger_error("setNazwa: invalid nazwa value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
		
  }	
	
  /**
   * Set target
   * @param string $target
   */
  public function setTarget($target) {
		
  	if($target!=''&&is_string($target)){
      $this->_target=$target;
		} else {
			trigger_error("setTarget: invalid target value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
		
  }		
	
	
  /**
   * Set action
   * @param string $action
   */
  public function setAction($action) {
	
  	if(is_string($action)){
      $this->_action=$action;
		} else {
			trigger_error("setAction: invalid action value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
		
  }	
	
	
  /**
   * Set method
   * @param string $method
   */
  public function setMethod($method) {
	
		if(is_string($method)){
	  	if($method=="get"){
  	    $this->_method=$method;
			} else {
  	    $this->_method="post";			
			}
		}	else {
			trigger_error("setMethod: invalid method value ".$this->getNazwaKlasy(),E_USER_ERROR);		
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
   * Set id
   * @param string $id
   */
  public function setId($id) {
	
  	if(is_string($id)||is_int($id)){
      $this->_id=$id;
		} else {
			trigger_error("setId: invalid id value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
		
  }	
	
	
  /**
   * Get id
   * @return string
   */
  public function getId() {
	
  	return $this->_id;
		
  }	
								

  /**
   * Set multipart
   * @param bool $multipart
   */
  public function setMultipart($multipart) {
	
  	if(!empty($multipart)){
      $this->_multipart=true;
		} else {
      $this->_multipart=false;
		}		
		
  }			
	
	
  /**
   * Set spr
   * @param bool $spr
   */
  public function setOnsubmit($kod) {
	
  	if(!empty($kod)){
      $this->_onsubmit[]=$kod;
		}
		
  }									

	
  /**
   * zabezpieczenie formularzy
   * @param array $pola 
   * @param string $przed 
   * @param string $po 
   * @param array $komunikaty
   * @return string		
   */	
	public function spr($pola="",$przed="",$po="",$komunikaty=array()){
		
		$this->setOnsubmit("return spr_form_".$this->getNazwa()."()");

	  $html="<script type=\"text/javascript\">\n";
	  $html.="wcisnieto".$this->getNazwa()."=0;\n";
	  $html.="function spr_form_".$this->getNazwa()."() {\n";		
		$html.="form_error_defalut='".htmlspecialchars(konf::get()->langTexty("funkcje_spr_brak"))."';\n";		
	  $html.="form_start_errors();\n";	
			
	  $html.=" ok=true;\n";		
		if(!empty($przed)){ 
			$html.=$przed; 
		}				
		$html.=" if (wcisnieto".$this->getNazwa()."==1){ ok=false; } else { \n";
		
		if(!empty($pola)&&is_array($pola)){
			while(list($key,$val)=each($pola)){			
			  $html.="  form_error_spr(document.".$this->getNazwa().",'".$val."','";
				if(!empty($komunikaty[$key])){							
					$html.=htmlspecialchars($komunikaty[$key]);
				}
				$html.="');\n";
			}
		}
		
		if(!empty($po)){ 
			$html.=$po; 
		}		
		$html.="    if(ok && error_komunikat('".htmlspecialchars(konf::get()->langTexty("funkcje_spr_wystapil"))."')){\n";		
	  $html.=" 	    wcisnieto".$this->getNazwa()."=1; setTimeout('wcisnieto".$this->getNazwa()."=0',25000); \n";			
		$html.="    } else {\n";				
		$html.="     ok=false;\n";
		$html.="    }\n";
		$html.="  }\n";
		
	  $html.="  return ok;\n";
	  $html.="}\n";
	  $html.="</script>\n\n";		

		return $html;
		
	}


  /**
   * javascript do zaznaczania i odznaczania wszystkich checkboxow  z tablicy w danym formularzu
   * @param array $tablica 
   * @param bool $odw
   * @return string		
   */		
	public function zaod($tablica,$odw=true){
	
		$html="";

		if(!empty($tablica)){
			$html.="<table class=\"srodek\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr>";
			$html.="<td>";
			$html.=interfejs::linkEl("add","javascript:zaznacz_checkboxy(document.".$this->getNazwa().",'".$tablica."',1);",konf::get()->langTexty("zaznacz"));
			$html.="</td><td class=\"grube\">&nbsp;/&nbsp;</td><td>";
			$html.=interfejs::linkEl("delete","javascript:zaznacz_checkboxy(document.".$this->getNazwa().",'".$tablica."',2);",konf::get()->langTexty("odznacz"));
			$html.="</td>";
			if($odw){
				$html.="<td class=\"grube\">&nbsp;/&nbsp;</td><td>";
				$html.=interfejs::linkEl("arrow_refresh","javascript:zaznacz_checkboxy(document.".$this->getNazwa().",'".$tablica."',3);",konf::get()->langTexty("odwrotniez"));
				$html.="</td>";
			}
			$html.="</tr></table>";
		} else {
			trigger_error("zaod: invalid tablica value ".$this->getNazwaKlasy(),E_USER_ERROR);		
		}
			
		return $html;
		
	}


  /**
   * javascript do ograniczania dlugości tekstu w textarea
   * @param string $pole 
   * @param int $max
   * @param string $dodatek 		
   * @return string		
   */			
	public function skrocTxt($pole,$max,$dodatek=""){
	
		$formularz=$this->getNazwa();
		$html="";
		
		if(empty($dodatek)){
			$dodatek=$pole;
		}
	
		if(!empty($max)&&is_int($max)){
			$html.="<div class=\"male\">".konf::get()->langTexty("funkcje_skroc_pozostalo")." <input name=\"counter".$dodatek."\" id=\"counter".$dodatek."\" onfocus=\"document.".$formularz.".counter".$dodatek.".blur(); document.".$formularz.".".$pole.".focus();\" size=\"5\" value=\"".$max."\" class=\"f_krotki\" />";
			$html.="&nbsp; ".konf::get()->langTexty("funkcje_skroc_napisales")." <input name=\"napisano".$dodatek."\" id=\"napisano".$dodatek."\" size=\"5\" onfocus=\"document.".$formularz.".napisano".$dodatek.".blur(); document.".$formularz.".".$pole.".focus()\" value=\"0\" class=\"f_krotki\" /></div>";			
			$html.="<script type=\"text/javascript\">\n";
			$html.="function skroc_textarea".$dodatek."() {\n";
			$html.="	var max = ".$max.";\n";
		  $html.="	if (document.".$formularz.".".$pole.".value.length<=max) {\n";
		  $html.="		document.".$formularz.".napisano".$dodatek.".value=document.".$formularz.".".$pole.".value.length;\n";
		  $html.="		document.".$formularz.".counter".$dodatek.".value=max-document.".$formularz.".napisano".$dodatek.".value;\n";
		  $html.="	} else {\n";
		  $html.="		document.".$formularz.".".$pole.".value=document.".$formularz.".".$pole.".value.substring(0,max);\n";
		  $html.="	}\n";
		  $html.="	setTimeout('skroc_textarea".$dodatek."()', 50);\n";
			$html.="}\n";
			$html.="skroc_textarea".$dodatek."();\n";
			$html.="</script>\n\n";
		}
		
		return $html;
		
	}
	
  /**
   * rysuje zestawy checkbox
   * @param array $tab
   * @param string $wartosc
   * @param string $nazwa
   * @param string $class		
   * @param string $znak
   * @param bool $label
   * @param bool $div		
   * @return string		
   */				
	public function checkboxTab($tab,$wartosc,$nazwa,$class="",$znak="|",$label=true,$div=true){
	
		$html="";
		
		if($znak!=""&&!is_array($wartosc)&&!empty($wartosc)){
			$wartosc=explode($znak,$wartosc);
		}
		
		if(!is_array($wartosc)){
			if(!empty($wartosc)){
				$wartosc=array($wartosc=>$wartosc);
			} else {
				$wartosc=array();			
			}
		}		
		
		if(!is_array($tab)){
			$tab=array();
		}
	
	  while(list($key,$val)=each($tab)){
		
			if($div){
		    $html.="<div";
				if($class){
					$html.=" class=\"".$class."\"";
				}
				$html.=">";
			}
			
			$html.="<input type=\"checkbox\" name=\"".$nazwa."[]\" class=\"przycisk\" value=\"".$key."\" id=\"".$nazwa."_".$key."\" ";
	    if(in_array($key,$wartosc)){ 
				$html.="checked=\"checked\" "; 
			}
	    $html.=" /> ";
			
			if($label){
				$html.="<label for=\"".$nazwa."_".$key."\">";
			}
			
			$html.=$val;
			
			if($label){
				$html.="</label>";
			}
			
			if($div){
				$html.="</div>";
			}
			
	  }
		
	  return $html;
		
	}     		
	
	
  /**
   * rysuje zestawy radio
   * @param array $tab
   * @param string $wartosc
   * @param string $nazwa
   * @param string $class	
   * @param bool $label
   * @param bool $div					
   * @return string		
   */				
	public function radioTab($tab,$wartosc,$nazwa,$class="",$label=true,$div=true){
	
		$html="";
	
		if(!is_array($tab)){
			$tab=array();
		}
	
	  while(list($key,$val)=each($tab)){
		
			if($div){
		    $html.="<div";
				if($class){
					$html.=" class=\"".$class."\"";
				}
				$html.=">";
			}
			
			$html.="<input type=\"radio\" name=\"".$nazwa."\" class=\"przycisk\" value=\"".$key."\" id=\"".$nazwa."_".$key."\" ";
	    if($wartosc==$key){ 
				$html.="checked=\"checked\" "; 
			}
	    $html.=" /> ";
			
			if($label){
				$html.="<label for=\"".$nazwa."_".$key."\">";
			}
			
			$html.=$val;
			
			if($label){
				$html.="</label>";
			}
			
			if($div){
				$html.="</div>";
			}
			
	  }
		
	  return $html;
		
	}  
	
	
  /**
   * wyswietla pole radio
   * @param string $nazwa 
   * @param string $id
   * @param string $wartosc
   * @param string $wartosc2		
   * @param string $class	
   * @param string $dopisek		
   * @return string		
   */			
	public function radio($nazwa,$id,$wartosc,$wartosc2="",$klasa="",$dopisek=""){
		
		$html="";
		
		if($nazwa){
		
			$html.="<input type=\"radio\" name=\"".$nazwa."\"";
			if($id!=""){
				$html.=" id=\"".$id."\"";
			}
			$html.=" class=\"przycisk";
			if($klasa!=""){
				$html.=" ".$klasa;
			}		
			$html.="\" value=\"".$wartosc."\" ";
	    if($wartosc2==$wartosc){ 
				$html.=" checked=\"checked\""; 
			}
			if($dopisek){
				$html.=" ".$dopisek;
			}
	    $html.=" />";
		
		} else {
			trigger_error("radio: empty nazwa ".$this->getNazwaKlasy(),E_USER_ERROR);		
		}		
		
		return $html;
			
	}	
	
	
  /**
   * wyswietla pole select z liczb
   * @param string $nazwa 
   * @param string $id
   * @param int $start
   * @param int $stop		
   * @param string $wartosc
   * @param string $class	
   * @param string $pusty			
   * @param string $dodatek		
   * @return string		
   */			
	public function selectWylicz($nazwa,$id,$start,$stop,$wartosc="",$class="",$pusty="",$dodatek=""){	
	
		$html="";
		
		if($nazwa){
		
			$tab=array();
			
			if($start>$stop){
				for($i=$start;$i>=$stop;$i--){
					$tab[$i]=$i;
				}
			} else {
				for($i=$start;$i<=$stop;$i++){
					$tab[$i]=$i;
				}			
			}
			
			$html.=$this->select($nazwa,$id,$tab,$wartosc,$class,$pusty,$dodatek);
		
		} else {
			trigger_error("selectWylicz: empty values ".$this->getNazwaKlasy(),E_USER_ERROR);		
		}
		
		return $html;		
		
	}
	

  /**
   * wyswietla pole select z tablicy
   * @param string $nazwa 
   * @param string $id
   * @param array $tablica
   * @param string $wartosc
   * @param string $class	
   * @param string $pusty			
   * @param string $dodatek		
   * @param string $indeks		
   * @return string		
   */			
	public function select($nazwa,$id,$tablica,$wartosc="",$class="",$pusty="",$dodatek="",$indeks=""){
	
		$html="";
		
		if($nazwa){
		
			$html.="<select name=\"".$nazwa."\"";
			if($id!=""){
				$html.=" id=\"".$id."\"";
			}
			if($class!=""){
				$html.=" class=\"".$class."\"";
			}
			if($dodatek){
				$html.=" ".$dodatek;
			}				
			$html.=">";
			if($pusty!=""){ 
				$html.="<option value=\"\">".$pusty."</option>"; 
			}
			if(!empty($tablica)&&is_array($tablica)){
				reset($tablica);		
				while(list($key,$val)=each($tablica)){
					$html.="<option value=\"".$key."\"";
					if($key==$wartosc&&$wartosc!=''){ 
						$html.=" selected=\"selected\""; 
					}
					$html.=">";
					if(is_array($val)&&!empty($indeks)&&isset($val[$indeks])){
						$html.=$val[$indeks];
					} else {
						$html.=$val;
					}
					$html.="</option>";
				}
			}
			$html.="</select>";	
						
		} else {
			trigger_error("select: empty values ".$this->getNazwaKlasy(),E_USER_ERROR);		
		}
		
		return $html;		
		
	}

	
  /**
   * wyswietla pole selec z tablicy (tablica - optgroup i 2-wymiarowa tablica wartosci)
   * @param string $nazwa 
   * @param string $id
   * @param array $tablica
   * @param array $tablica2		
   * @param string $wartosc
   * @param string $class	
   * @param string $pusty			
   * @param bool $usun_puste	- usun puste optgroup gdy nie maja podelementow		
   * @param bool $powtorz_puste - np jesli nie ma podkategorii a kategoria ma byc aktywna do wyboru	w zaman podkategorii
   * @return string		
   */		
	public function select2($nazwa,$id,$tablica,$tablica2,$wartosc="",$class="",$pusty="",$dodatek="",$usun_puste=true,$powtorz_puste=false){
	
		$html="";
		
		if($nazwa){
		
			$html.="<select name=\"".$nazwa."\"";
			if($id!=""){
				$html.=" id=\"".$id."\"";
			}
			if($class!=""){
				$html.=" class=\"".$class."\"";
			}
			if($dodatek){
				$html.=" ".$dodatek;
			}		
			$html.=">";
			if($pusty!=""){ 
				$html.="<option value=\"\">".$pusty."</option>"; 
			}
			if(!empty($tablica)&&is_array($tablica)){
				reset($tablica);	
				while(list($key,$val)=each($tablica)){
					if(!empty($tablica2[$key])&&is_array($tablica2[$key])){				
						if(count($tablica)>1){
							$html.="<optgroup label=\"".htmlspecialchars($val)."\">";
						}
						reset($tablica2[$key]);
						while(list($key2,$val2)=each($tablica2[$key])){	
							$html.="<option value=\"".$key2."\"";
							if($key2==$wartosc&&$wartosc!=''){ 
								$html.=" selected=\"selected\""; 
							}
							$html.=">".$val2."</option>";
						}
						if(count($tablica)>1){				
							$html.="</optgroup>";
						}
					} else {
						if(!$usun_puste&&(count($tablica)>1||$powtorz_puste)){			
							$html.="<optgroup label=\"".htmlspecialchars($val)."\">";
							if($powtorz_puste){
								$html.="<option value=\"".$key."\"";
								if($key==$wartosc&&$wartosc!=''){ 
									$html.=" selected=\"selected\""; 
								}
								$html.=">".$val."</option>";							
							}
							$html.="</optgroup>";					
						}
					}
				}
			}		
		  $html.="</select>";
		
		} else {
			trigger_error("select2: empty values ".$this->getNazwaKlasy(),E_USER_ERROR);		
		}
		
		return $html;				
		
	}
	
	
  /**
   * wyswietla pole select akcji z tablicy
   * @param array $tablica
   * @param bool $submit
   * @return string		
   */			
	public function selectAkcja($tablica,$submit=true){	
		
		$html="";
		$html.=$this->select("akcja","",$tablica,"","f_dlugi",konf::get()->langTexty("akcjawyb"));		
		$html.="&nbsp;";
		if($submit){
			$html.=$this->input("submit","","",konf::get()->langTexty("akcjawykonaj"),"formularz2 f_krotki");		
		}
	
		return $html;
	}	
	
	
  /**
   * wyswietla antyspam	
   * @return string		
   */			
	public function bootproof(){	
	
		require_once(konf::get()->getKonfigTab('klasy').'class.botproof.php');		
		
		$proof2=new botProof(konf::get()->getKonfigTab('g_kodprefix'));		
		
		if(konf::get()->getKonfigTab('g_znakow')){
			$znakow=konf::get()->getKonfigTab('g_znakow');
		} else {
			$znakow=5;
		}
		
		$proof2->setIleZnakow($znakow);				
				
		$proof2->setLitery(true);
		$proof2->setCyfry(true);	
		$proof2->setDuze(false);		
		$proof2->generujKod();		
		
		$html="";
		
		$html.=$this->input("hidden",konf::get()->getKonfigTab('g_kodhash'),"",$proof2->getGKodHash(),"formularz2 f_sredni");			
		$html.="<div class=\"lewa\"><img src=\"".konf::get()->getKonfigTab('sciezka')."botproof.php?".konf::get()->getKonfigTab('g_kodencrypt')."=".rawurlencode($proof2->getGKodEncrypt())."\" alt=\"\" class=\"botproof\" /></div>";
		$html.="<div class=\"lewa\">";
		$html.=$this->input("text",konf::get()->getKonfigTab('g_kod'),"","","f_krotki",$znakow);	
		$html.=" ".konf::get()->langTexty("bootproof_kod")."*";		
		$html.="</div>";
	
		return $html;
	}		
	
	
  /**
   * wyswietla input
   * @param string $typ		
   * @param string $nazwa 
   * @param string $id
   * @param string $wartosc
   * @param string $class		
   * @param int $max
   * @param string $dodatek				
   * @return string		
   */			
	public function input($typ,$nazwa="",$id="",$wartosc="",$class="",$max="",$dodatek=""){
	
		$html="";
		
		if($typ){
		
			$max=$max+0;						
							
			$html.="<input type=\"".$typ."\" ";
			if($nazwa){
				$html.=" name=\"".$nazwa."\"";			
			}
			if($id){
				$html.=" id=\"".$id."\"";
			}
			if($class){
				$html.=" class=\"".$class."\"";
			}			
			$html.=" value=\"".tekstForm::doForm($wartosc)."\"";		
			if($max){
				$html.=" maxlength=\"".$max."\"";
			}			
			if($dodatek){
				$html.=" ".$dodatek;	
			}
			$html.=" />";		
			
		} else {
			trigger_error("input: empty typ value ".$this->getNazwaKlasy(),E_USER_ERROR);		
		}					

		return $html;		
		
	}		
	

  /**
   * wyswietla textarea
   * @param string $nazwa 
   * @param string $id
   * @param string $wartosc
   * @param string $class		
   * @param int $rows			
   * @param int $cols
   * @param string $dodatek						
   * @return string		
   */			
	public function textarea($nazwa="",$id="",$wartosc="",$class="",$rows="",$cols="",$dodatek=""){
	
		$html="";
		
		if(empty($cols)){
			$cols=10;
		}
		
		if($nazwa){
		
			$cols=$cols+0;						
			$rows=$rows+0;	
										
			$html.="<textarea name=\"".$nazwa."\"";			
			if($id){
				$html.=" id=\"".$id."\"";
			}
			if($class){
				$html.=" class=\"".$class."\"";
			}				
			if($cols){
				$html.=" cols=\"".$cols."\"";
			}	
			if($rows){
				$html.=" rows=\"".$rows."\"";
			}						
			if($dodatek){
				$html.=" ".$dodatek;
			}						
			$html.=" >";		
			$html.=tekstForm::doForm($wartosc);	
			$html.="</textarea>";			
			
		} else {
			trigger_error("textarea: empty typ value ".$this->getNazwaKlasy(),E_USER_ERROR);		
		}					

		return $html;		
		
	}		
		
	
  /**
   * wyswietla pole selec z tablicy (tablica - optgroup i 2-wymiarowa tablica wartosci)
   * @param string $nazwa 
   * @param string $wartosc
   * @param int $wysokosc	
   * @param string $typ			
   */		
	public function fck($nazwa,$wartosc="",$wysokosc=350,$typ=""){
	
		if($nazwa){
		
			if(!$this->_bylfck){
	      include_once(konf::get()->getKonfigTab("serwer")."edytor/fckeditor.php");			
				$this->_bylfck=true;				
			}	

	    $oFCKeditor=new FCKeditor($nazwa);
	    $oFCKeditor->BasePath=konf::get()->getKonfigTab('edytor');
	    $oFCKeditor->Value=$wartosc;
	    $oFCKeditor->Height=$wysokosc;
			if($typ){
				$oFCKeditor->ToolbarSet=$typ ;			
			}
	    $oFCKeditor->Create();	
			
		} else {
			trigger_error("fck: empty nazwa value ".$this->getNazwaKlasy(),E_USER_ERROR);		
		}
		
	}
	
		
	
  /**
   * wyswietla pole color picker
   * @param string $nazwa 
   * @param string $id
   * @param array $tablica
   * @param array $tablica2		
   * @param string $wartosc
   * @param string $class	
   * @param string $pusty			
   * @return string		
   */			
	public function colorPicker($nazwa,$wartosc="",$reset=true,$hidden=false){
	
		$html="";
		
		if($nazwa){
		
			$html.="<div style=\"width:128px;\">";
			$html.="<div class=\"srodek nobr\">";
			
	    $html.="<input ";
			if($hidden){
				$html.=" type=\"hidden\"";
			} else {
				$html.=" type=\"text\"";
			}
			$html.=" id=\"".$nazwa."\" name=\"".$nazwa."\" value=\"";
			if($wartosc!="xxxxxx"){
				$html.="#".$wartosc; 
			}
			$html.="\" class=\"f_krotki\" maxlength=\"7\" /> ";
			
			if($reset){
				$html.="<input type=\"button\" value=\"".konf::get()->langTexty("form_reset")."\" class=\"formularz2 f_bkrotki\" onclick=\"picker_reset('".$nazwa."','".$wartosc."');\" />";
			}
			$html.="</div>";

			if($wartosc=="xxxxxx"){
				$wartosc="ffffff"; 
			}	
			konf::get()->setPlikiHeader(konf::get()->getKonfigTab("sciezka")."js/colorpicker.js","js");
								
			$html.="<div class=\"srodek\">";
			$html.="<script type=\"text/javascript\">\n";
		  $html.="picker_write('".$nazwa."_t','".$nazwa."','".$nazwa."_o');\n";
			$html.="</script>";
			$html.="<div id=\"".$nazwa."_t\" class=\"lewal\" style=\"text-align:center; height:20px; width:88px; background-color:#".tekstForm::doForm($wartosc)."\">#".tekstForm::doForm($wartosc)."</div>";
			$html.="<div id=\"".$nazwa."_o\" class=\"lewal\" style=\"width:40px;height:20px;\"></div>";
			$html.="</div>";
			$html.="</div>";
		
		} else {
			trigger_error("colorPicker: empty values ".$this->getNazwaKlasy(),E_USER_ERROR);		
		}
		
		return $html;				

		
	}
	
	
  /**
   * Set tab
   * @param array $przenies
   */
  public function setPrzenies($przenies) {
  	if(!empty($przenies)){
			if(is_array($przenies)){
	      $this->_przenies=array_merge($this->_przenies,$przenies);

			} else {
				trigger_error("setKonfigTab: invalid przenies value ".$this->getNazwaKlasy(),E_USER_ERROR);
			}
		}		
		
  }		
		
	
  /**
   * przenosi zmienne hidden
   * @param array $zmienne
   * @param bool $lang		
   * @param bool $id	
   * @param bool $puste		
   * @return string		
   */			
	public function przenies($zmienne="",$lang=true,$id=false,$puste=false){
		
		if($zmienne){
			$this->setPrzenies($zmienne);
		}

		$html="";
		
		if($lang&&konf::get()->getKonfigTab('przenies_lang')){
			$lang=konf::get()->getLang();
			if($lang!=konf::get()->getKonfigTab('lang_default')){
				$html.="<input type=\"hidden\" name=\"".konf::get()->getKonfigTab('lang_name')."\"";
				if($id){
					$html.=" id=\"".konf::get()->getKonfigTab('lang_name')."\"";
				}
				$html.=" value=\"".$lang."\" />";
			}
		}
		 
		if(!empty($this->_przenies)&&is_array($this->_przenies)){
			reset($zmienne);
			while(list($key,$val)=each($this->_przenies)){
				if($val!=''||$puste){
					$html.="<input type=\"hidden\" name=\"".$key."\"";
					if($id){
						$html.=" id=\"".$key."\"";
					}
					$html.=" value=\"".tekstForm::doForm($val)."\" />";
				}
			}
		}	
		
		return $html;
		
	}	
	
	
  /**
   * Get form tag
   * @return string
   */	
	public function getFormp(){
	
		$html="";
		
		if($this->_nazwa){
	
			$html="<form name=\"".$this->_nazwa."\" method=\"".$this->_method."\" action=\"".$this->_action."\"";
			if(!empty($this->_id)){
				$html.=" id=\"".$this->_id."\"";
			}
			if($this->_multipart){
				$html.=" enctype=\"multipart/form-data\"";
			}		
			if($this->_target){
				$html.=" target=\"".$this->_target."\"";
			}				
			if(!empty($this->_onsubmit)&&count($this->_onsubmit)>0){
				reset($this->_onsubmit);
				$html.=" onsubmit=\"";
				while(list($key,$val)=each($this->_onsubmit)){
					$html.=$val."; ";
				}
				$html.="\"";
			}		
			$html.=">";
		
		} else {
			trigger_error("getFormp: empty values ".$this->getNazwaKlasy(),E_USER_ERROR);		
		}
		
		return $html;		
		
	}	
	
	
  /**
   * wyswietla pole radio
   * @param string $nazwa 
   * @param string $id
   * @param string $wartosc
   * @param string $wartosc2		
   * @param string $class	
   * @param string $dopisek		
   * @return string		
   */			
	public function checkbox($nazwa,$id,$wartosc,$wartosc2="",$klasa="",$dodatek=""){
		
		$html="";
		
		if($nazwa){
		
			$html.="<input type=\"checkbox\" name=\"".$nazwa."\"";
			if($id!=""){
				$html.=" id=\"".$id."\"";
			}
			$html.=" class=\"przycisk";
			if($klasa!=""){
				$html.=" ".$klasa;
			}		
			$html.="\" value=\"".$wartosc."\" ";
	    if($wartosc2==$wartosc){ 
				$html.=" checked=\"checked\""; 
			}
			if($dodatek){
				$html.=" ".$dodatek;
			}
	    $html.=" />";
		
		} else {
			trigger_error("checkbox: empty values ".$this->getNazwaKlasy(),E_USER_ERROR);		
		}		
		
		return $html;
			
	}
	
  /**
   * odczytuje dane z wczesniej wyslanego formularza
   * @param array $dane
   * @return array	
   */			
	public function odczyt($dane){
		
		if(!empty($dane)&&is_array($dane)){
		
			while(list($key,$val)=each($dane)){
				
				if(konf::get()->getZmienna($key)){
					$dane[$key]=konf::get()->getZmienna($key);
				}
			
			}
		
		}		
		
		return $dane;
			
	}	
	

  /**
   * Get end form tag
   * @return string
   */	
	public function getFormk(){
	
		$html="";
		
		if($this->_nazwa){	
	
			$html.="</form>";
			
		}
		
		return $html;
		
	}		
	
	
	/**
   * zmienia styl danego elementu	
   * @param string,array $idtf
   * @param string klasa
   */		
	public function invalid($idtf,$klasa="bladform"){
	
		$blad=false;
		
		if(!is_array($idtf)){
			if(konf::get()->getInvalid($idtf)){			
				$blad=true;
			}
		} else {
			reset($idtf);
			while(list($key,$val)=each($idtf)){
				if(konf::get()->getInvalid($val)){			
					$blad=true;
				}				
			}
		}

		if($blad){
			return $klasa;
		} else {
			return"";
		}
	
	}	
	
	
  /**
   * wyswietla pole color picker
   * @param string $nazwa 
   * @param string $trigger
   * @param string $wartosc
   * @param bool $czas		
   * @param bool $reset	
   * @param bool $readonly			
   * @return string		
   */			
	public function kalendarz($nazwa,$trigger,$wartosc="",$czas=false,$reset=false,$readonly=true){
	
		$html="";
		
		if($nazwa&&$trigger){
		
			$wartosc=tekstForm::niepuste($wartosc);
		
			if($czas){
				$wartosc=substr($wartosc,0,16);
			} else {
				$wartosc=substr($wartosc,0,10);			
			}
		
			if(!$this->_bylkalendarz){
				konf::get()->setPlikiHeader(konf::get()->getKonfigTab('kalendarz_kat')."calendar-blue2.css","css");
				konf::get()->setPlikiHeader(konf::get()->getKonfigTab('kalendarz_kat')."calendar_stripped.js","js");
				konf::get()->setPlikiHeader(konf::get()->getKonfigTab('kalendarz_kat')."lang/calendar-".konf::get()->getKonfigTab('kalendarz_lang').".js","js");
				konf::get()->setPlikiHeader(konf::get()->getKonfigTab('kalendarz_kat')."calendar-setup.js","js");
				$this->_bylkalendarz=true;				
			}
			
			if(!tekstForm::niepuste($wartosc)){
				$wartosc="";
			}
	    $html="";
	    $html.="<input type=\"text\" name=\"".$nazwa."\" id=\"".$nazwa."\" class=\"";
			if($czas){
				$html.="f_sredni";
			} else {
				$html.="f_krotki";		
			}
			$html.="\" value=\"".tekstForm::doForm($wartosc)."\" maxlength=\"";
			if($czas){
				$html.="16";
			} else {
				$html.="10";		
			}		
			$html.="\"";
			if($readonly){
				$html.=" readonly=\"readonly\"";
			}			
			$html.=" />";
			$html.="<img src=\"".konf::get()->getKonfigTab('kalendarz_kat')."img.gif\" width=\"20\" height=\"14\" style=\"vertical-align:middle; cursor:pointer; margin:2px\" id=\"".$trigger."\" alt=\"".konf::get()->langTexty("form_wybierzd")."\" title=\"".konf::get()->langTexty("form_wybierzd")."\" />";
	    
			if($reset){
		    $html.="<a href=\"javascript:void(null)\" onclick=\"document.getElementById('".$nazwa."').value=''; return true;\"><img src=\"".konf::get()->getKonfigTab('kalendarz_kat')."img_nie.gif\" width=\"20\" height=\"14\" style=\"vertical-align:middle; cursor:pointer; margin:2px\" alt=\"".konf::get()->langTexty("form_usund")."\" title=\"".konf::get()->langTexty("form_usund")."\" /></a>";
			}

	    $html.="<script type=\"text/javascript\">\n";
	    $html.="Calendar.setup({\n";
	    $html.="inputField:\"".$nazwa."\",\n";		
	    $html.="ifFormat:\"";
			if($czas){
				$html.="%Y-%m-%d %H:%M";
			} else {
				$html.="%Y-%m-%d";		
			}				
			$html.="\",\n";
	    $html.="button:\"".$trigger."\",\n";
			if($czas){
		    $html.="showsTime:true,\n";
			}
			$html.="align :\"Br\"\n"; 
	    $html.="});\n";
	    $html.="</script>\n";
		
		} else {
			trigger_error("kalendarz: empty values ".$this->getNazwaKlasy(),E_USER_ERROR);		
		}
		
		return $html;		
			
	}
	
	
  /**
   * wyswietla slider
   * @param string $nazwa 
   * @param int $min
   * @param int $max			
   * @param int $krok		
   * @param int $dlugosc_paska				
   * @param string $wartosc
   * @param bool $readonly			
   * @return string		
   */			
	public function slider($nazwa,$min,$max,$krok=1,$dlugosc_paska=100,$wartosc="",$readonly=true){
	
		$min=$min+0;
		$max=$max+0;
		$krok=$krok+0;		
		
		$html="";
		
		if($nazwa){
		
			if(!$this->_bylslider){
				konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/slider/slider.js","js");
				$this->_bylslider=true;				
			}
			
			if(empty($wartosc)){
				$wartosc="0";
			}

			if(empty($dlugosc_paska)){
				$dlugosc_paska=round($max/$krok);
			}

	    $html="";			
	    $html.="<div><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr valign=\"middle\"><td><input type=\"text\" name=\"".$nazwa."\" id=\"".$nazwa."\" class=\"f_krotki2";
			$html.="\" value=\"".tekstForm::doForm($wartosc)."\" ";
			if($readonly){
				$html.=" readonly=\"readonly\"";
			}			
			$html.=" /></td><td style=\"padding-left:5px; padding-top:1px;\">";
			
			$html.="<script type=\"text/javascript\">\n";	
			$html.=" var a_".$nazwa."_p = {\n";
			$html.="		's_imgControl': '".konf::get()->getKonfigTab('sciezka')."js/slider/sldr2h_bg.gif',\n";
			$html.="		's_imgSlider': '".konf::get()->getKonfigTab('sciezka')."js/slider/sldr2h_sl.gif',\n";			
			$html.="		'n_controlWidth': ".($dlugosc_paska+19).",\n";		
			$html.="		'n_pathLength' : ".$dlugosc_paska.",\n";				
			$html.="		's_form' : '".$this->_nazwa."',\n";
			$html.="		's_name': '".$nazwa."',\n";
			$html.="		'n_minValue' : ".$min.",\n";
			$html.="		'n_maxValue' : ".$max.",\n";
			$html.="		'n_value' : ".$wartosc.",\n";
			$html.="		'n_step' : ".$krok."\n";
			$html.="	}\n";
			$html.="new slider(a_slider_w,a_".$nazwa."_p);\n";
			$html.="</script>";
			$html.="</td></tr></table></div>";

		} else {
			trigger_error("slider: empty values ".$this->getNazwaKlasy(),E_USER_ERROR);		
		}
		
		return $html;		
			
	}	
	

	/**
   * class constructor php5	
   * @param string $method					
   * @param string $action			
   * @param string $nazwa nazwa formularza
   * @param string $id			
   */	
	public function __construct($method,$action,$nazwa,$id="") {	
	
		$this->setMethod($method);
		$this->setAction($action);
		$this->setNazwa($nazwa);		
		$this->setId($id);		
				
  }	

}

?>