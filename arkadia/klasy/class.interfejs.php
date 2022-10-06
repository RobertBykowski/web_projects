<?php

/**
 * Interfejs class v1.0
 * dla CMS i innych klas - ikonki, itp do interfejsu administracyjnego.
 * All rights reserved
 * @package Interfejs class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2007 Waldemar Jonik
 */

/**
 *
 * Example:
 *

  require_once("class.interfejs.php");


 *
 */
	
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		

	
class interfejs {

	/**
	 * Public variables
	 */

	/**
	 * Private variables
	 */
		
		
	/**
   * przycisk
   * @param string $ikona
   * @param string $opis	
   * @param string $dodatek		
	 * @return string					
   */		
	public static function ikona($ikona,$opis="",$dodatek=""){
		
	  $html="<img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/ikony/".$ikona.".gif\" width=\"16\" height=\"16\" alt=\"".htmlspecialchars($opis)."\" ".$dodatek." />";

		return $html;
	
	}		
	
	

	/**
   * przycisk
   * @param string $txt
	 * @return string				
   */					
	public static function pomocEl($txt){

		$html="<span onmouseover=\"this.T_TITLE='".konf::get()->langTexty("funkcje_admin_pomoc")."'; return escape('".str_replace("'","\'",$txt)."')\">".interfejs::ikona("help","","style=\"margin-left:5px\"")."</span>";

		return $html;
		
	}
	

	/**
   * przycisk
   * @param string $ikona
   * @param string $link		
   * @param string $opis	
   * @param string $class		
	 * @return string					
   */		
	public static function linkEl($ikona,$link="",$opis="",$class="srodek"){
		
	  $html="<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"";
		if($class){
			$html.=" class=\"".$class."\"";
		}
		$html.="><tr><td style=\"width:20px\"><a href=\"".$link."\">".interfejs::ikona($ikona,$opis,"style=\"margin-right:2px\"")."</a></td>";
		$html.="<td class=\"nobr\"><a href=\"".$link."\">".$opis."</a></td></tr></table>";	
		
		return $html;
	}
	
	
	
	/**
   * przycisk
   * @param string $ikona
   * @param string $link		
   * @param string $opis	
   * @param string $class		
	 * @return string					
   */		
	public static function linkEl2($ikona="",$link="",$opis="",$class="menu_item"){
	
	  $html="<div class=\"".$class."\"><a href=\"".$link."\">";
		if($ikona){
			$html.=interfejs::ikona($ikona,$opis);
			$html.=" ";
		}
		$html.=$opis."</a></div>";

		return $html;
		
	}
		

	
	/**
   * przycisk
   * @param string $ikona
   * @param string $link		
   * @param string $klasa		
   * @param string $opis		
	 * @return string				
   */		
	public static function innyEl($ikona,$link,$klasa,$opis=""){
		
		$html="<td class=\"".$klasa."\">";			
	  $html.="<div class=\"nowa_l\"><div style=\"width:23px\" class=\"lewa lewal\">".interfejs::ikona($ikona,$opis," class=\"lewa\" style=\"margin-left:2px\"")."</div>";
		$html.="<div class=\"lewa\" style=\"padding-top:2px\">".$link."</div></div>";	
		$html.="</td>";	
		
		return $html;
	}


	/**
   * przycisk
   * @param string $link				
   * @param string $klasa
   * @param int $nr
	 * @return string				
   */		
	public static function folderEl($link,$klasa,$nr=1){
		
		$html="<td class=\"".$klasa."\">";			
	  $html.="<div class=\"nowa_l\"><div style=\"width:23px\" class=\"lewa lewal\"><img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/folder".$nr.".gif\" width=\"17\" height=\"15\" alt=\"\" class=\"lewa\" style=\"margin-right:2px\" /></div>";		
		$html.="<div class=\"lewa\">".$link."</div></div>";	
		$html.="</td>";	
		
		return $html;
	}


	/**
   * przycisk
   * @param string $ikona
   * @param string $link		
   * @param string $opis	
	 * @return string					
   */		
	public static function przyciskEl($ikona,$link="",$opis="",$target=""){
	
		if($opis=="&nbsp;"){
			$opis="";
		}
		
		$iko=interfejs::ikona($ikona,$opis," style=\"margin-top:5px\"");

		$html="";
		
		if(!empty($link)){			
	  	$html.="<a title=\"".htmlspecialchars($opis)."\" class=\"przycisk\" href=\"".$link."\"";
			if($target){
				$html.=" target=\"".htmlspecialchars($target)."\"";
			}
			$html.=">".$iko."</a>";    
		} else {
	   	$html.="<div class=\"nieprzycisk\">".$iko."</div>";    			
		}
		
		$html="<td>".$html."</td>";
		
		return $html;
	}
	
	
	/**
   * przycisk
   * @param string $link
   * @param int $i
   * @param int $ile
   * @param int $podstrona		
	 * @return string					
   */			
	public static function pozycja($link,$i,$ile,$podstrona,$stron){
		
		if(empty($podstrona)){
			$podstrona=1;
		}
		
		$html="";
    if(($i==1&&$podstrona==1)){
			$html.=interfejs::przyciskEl("arrow_turn_right","",konf::get()->langTexty("arch_np"));	
			$html.=interfejs::przyciskEl("arrow_up","",konf::get()->langTexty("arch_pw"));					  
    } else {  
			$html.=interfejs::przyciskEl("arrow_turn_right",$link."&amp;typ=upp&amp;podstrona=1",konf::get()->langTexty("arch_np"));    
			$html.=interfejs::przyciskEl("arrow_up",$link."&amp;typ=up&amp;podstrona=".$podstrona,konf::get()->langTexty("arch_pw"));  
    }    
    if(($i==$ile&&($podstrona==$stron))||$ile==1){
			$html.=interfejs::przyciskEl("arrow_down","",konf::get()->langTexty("arch_pn"));	
			$html.=interfejs::przyciskEl("arrow_turn_dleft","",konf::get()->langTexty("arch_nk"));					
    } else {
			$html.=interfejs::przyciskEl("arrow_down",$link."&amp;typ=down&amp;podstrona=".$podstrona,konf::get()->langTexty("arch_pn"));    
			$html.=interfejs::przyciskEl("arrow_turn_dleft",$link."&amp;typ=ddown&amp;podstrona=".$stron,konf::get()->langTexty("arch_nk"));  
    }	
		
		return $html;
		
	}
	
	/**
   * usuwanie
   * @param string $link
	 * @return string					
   */			
	public static function usun($link){
	
		$html=interfejs::przyciskEl("cross","javascript:czy_usun('".$link."','".konf::get()->langTexty("czyu")."');",konf::get()->langTexty("usun"));
		
		return $html;
	}	
	
	
	/**
   * edycja
   * @param string $link
	 * @return string					
   */			
	public static function edytuj($link){
	
		$html=interfejs::przyciskEl("pencil",$link,konf::get()->langTexty("edytuj"));  
		  
		return $html;
		
	}		
	
	/**
   * podglad
   * @param string $link
	 * @return string					
   */			
	public static function podglad($link){
	
		$html=interfejs::przyciskEl("eye",$link,konf::get()->langTexty("podglad"));  
		  
		return $html;
		
	}			
	
	
	/**
   * wstaw
   * @param string $link
	 * @return string					
   */			
	public static function wstaw($link,$odsun=true){

		$html="<div class=\"male lewa\" style=\"height:16px;\">".interfejs::linkEl('folder_add',$link,konf::get()->langTexty("wstaw"),"lewa")."</div>";

		return $html;
		
	}			
	
	
	/**
   * img imgPodglad
   * @param array $dane;
   * @param string $pole;		
   * @param string $katalog;				
	 * @return string					
   */			
	public static function imgPodglad($dane,$pole,$katalog,$ile=2){	
		
		$html="";
		
		$max=850;
		
		if(!empty($dane)&&is_array($dane)&&!empty($pole)&&!empty($katalog)){
		
			for($i=1;$i<=$ile;$i++){
	    	if(!empty($dane[$pole.$i.'_nazwa'])&&file_exists(konf::get()->getKonfigTab("serwer").$katalog.$dane[$pole.$i.'_nazwa'])){
					
					if(empty($html)){
		  			$html.="<div class=\"male\">".konf::get()->langTexty("img_dotychczasowa")."</div>";
					}
					if($dane[$pole.$i.'_w']>$max){
						$html.="<div style=\"width:".$max."px; overflow-x:scroll;\">";
					}
					if($dane[$pole]!=4&&$dane[$pole]!=13){
						$html.="<img src=\"".konf::get()->getKonfigTab("sciezka").$katalog.$dane[$pole.$i.'_nazwa']."\" width=\"".$dane[$pole.$i.'_w']."\" height=\"".$dane[$pole.$i.'_h']."\" class=\"obrazek\" alt=\"\" />";				
					} else {
						$swf= new swf(konf::get()->getKonfigTab("sciezka").$katalog.$dane[$pole.$i.'_nazwa'],$dane[$pole.$i.'_w'],$dane[$pole.$i.'_h']);
						$swf->setId('testswf_'.$pole.$i);
						$swf->setParametry(array(
							'wmode'=>'opaque'
						));			
						$swf->setWersja(8);
						$html.=$swf->pobierz();												
					}
					if($dane[$pole.$i.'_w']>$max){
						$html.="</div>";
					}				
		  		$html.="<div class=\"male\" style=\"padding-bottom:5px\">".konf::get()->langTexty("img_wys").$dane[$pole.$i.'_h']." ".konf::get()->langTexty("img_px").", ".konf::get()->langTexty("img_szer").$dane[$pole.$i.'_w']." ".konf::get()->langTexty("img_px")."</div>";
	 	  	}
				
			}
			
		}
				
		return $html;
				
	}		
	
	
	/**
   * przycisk
   * @param array $dane
	 * @return string					
   */			
	public static function infoEl($dane){	
	
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane"));	
		
		$html="<td onmouseover=\"this.T_TITLE='".konf::get()->langTexty('info')."'; return escape('";
		
	 	//zalozono
	  $html.="<div class=\'male\'>".konf::get()->langTexty("autor_utworzono")." <span class=\'grube\'>".substr($dane['autor_kiedy'],0,16)."</span>";
	  if(!empty($dane['autor_name'])){
			if(!empty($dane['autor_name'])){
				$html.="<div>";
		  	$html.=" ".konf::get()->langTexty("autor_przez")." ";
		  	if(!empty($dane['autor_id'])&&user::get()->adminU()){
		  		$html.="<a class=\'male\' href=\'".$link."&amp;id_u=".$dane['autor_id']."\' target=\'_blank\'>";
		  	}
			  $html.="<span class=\'grube\'>".$dane['autor_name']."</span>";
		  	if(!empty($dane['autor_id'])&&user::get()->adminU()){
		  		$html.="</a>";
		  	}
				$html.="</div>";
			}
	  }
	  //wyedytowano
	  if($dane['edytor_kiedy']!="0000-00-00 00:00:00"){
		  $html.="<div>".konf::get()->langTexty("autor_wyedytowano")." <span class=\'grube\'>".substr($dane['edytor_kiedy'],0,16)."</span></div>";
	    if(!empty($dane['edytor_name'])){
				$html.="<div>";
	   		$html.=" ".konf::get()->langTexty("autor_przez")." ";
	   		if(!empty($dane['edytor_id'])&&user::get()->adminU()){
		  		$html.="<a class=\'male\\' href=\'".$link."&amp;id_u=".$dane['edytor_id']."\' target=\'_blank\'>";
	  		}
	  		$html.="<span class=\'grube\'>".$dane['edytor_name']."&nbsp;</span>";
	   		if(!empty($dane['edytor_id'])&&user::get()->adminU()){
	   			$html.="</a>";
	   		}
				$html.="</div>";
			}
		}
		
	  //od kiedy do kiedy
	  if(!empty($dane['data_start'])&&$dane['data_start']!="0000-00-00 00:00:00"){
			$html.="<div>";		
			$html.=konf::get()->langTexty("autor_aktywneod");	
			$html.=" <span class=\'grube\'>".substr($dane['data_start'],0,16)."</span>";
			$html.="</div>";					
		}
	  if(!empty($dane['data_stop'])&&$dane['data_stop']!="0000-00-00 00:00:00"){
			$html.="<div>";
		  $html.=konf::get()->langTexty("autor_aktywnedo");
			$html.=" <span class=\'grube\'>".substr($dane['data_stop'],0,16)."</span>";
			$html.="</div>";			
		}
		
		$html.="</div>";  
				
		$html.="')\">";		
	  $html.="<a class=\"przycisk\" href=\"javascript:void(null)\">";    
		$html.=interfejs::ikona("information","","style=\"margin-top:5px\"");
		$html.="</a>";
		$html.="</td>"; 	

		return $html;
		
	}
									
	/**
   * sort buttons
   * @param string $link		
   * @param string $l	
   * @param string $p		
   * @param string $opis
   * @param string $wartosc		
   * @param int $dlugosc	
   * @param string $dlugoscm	
   * @param string $klasa						
	 * @return string							
   */		
	public static function sortEl($link,$l,$p,$opis="",$wartosc="",$dlugosc="",$dlugoscm="px",$klasa="tlo4 grube"){
		
		if($opis==""){
			$opis="&nbsp;";
		}
		
		$html="<td class=\"nobr ".$klasa."\" ";
		if(!empty($dlugosc)){
			$html.=" style=\"width:".$dlugosc.$dlugoscm."\"";
		}
		$html.=">";

		if(!empty($l)){
			$html.="<a href=\"".$link.$l."\"><img ";
			if($wartosc!=$l){
				$html.="src=\"".konf::get()->getKonfigTab("sciezka")."grafika/s_d.gif\" onmouseover=\"changeSrc(this,'grafika/s_d_over.gif');\" onmouseout=\"changeSrc(this,'grafika/s_d.gif');\"";
			} else {
				$html.="src=\"".konf::get()->getKonfigTab("sciezka")."grafika/s_d_over.gif\"";	
			}
			$html.=" width=\"8\" height=\"10\" border=\"0\" alt=\"".konf::get()->langTexty("sort_asc")."\" title=\"".konf::get()->langTexty("sort_asc")."\" style=\"margin-right:3px\" /></a>";
		}
		$html.="<span class=\"grube\">".$opis."</span>";
		if(!empty($p)){
			$html.="<a href=\"".$link.$p."\"><img ";
			if($wartosc!=$p){
				$html.="src=\"".konf::get()->getKonfigTab("sciezka")."grafika/s_g.gif\" onmouseover=\"changeSrc(this,'grafika/s_g_over.gif');\" onmouseout=\"changeSrc(this,'grafika/s_g.gif');\" ";
			} else {
				$html.="src=\"".konf::get()->getKonfigTab("sciezka")."grafika/s_g_over.gif\"";	
			}
			$html.=" width=\"8\" height=\"10\" border=\"0\" alt=\"".konf::get()->langTexty("sort_desc")."\" title=\"".konf::get()->langTexty("sort_desc")."\" style=\"margin-left:3px\" /></a>";
		}
		$html.="</td>";
			
		return $html;
	}
	
							
	/**
   * autor html
   * @param array $dane		
	 * @return string		
   */			
	public static function autor($dane){

		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane"));
		
	 	//zalozono
	  $html="<div class=\"male\">".konf::get()->langTexty("autor_utworzono")." <span class=\"grube\">".substr($dane['autor_kiedy'],0,16)."</span>";
	  if(!empty($dane['autor_name'])){
			if(!empty($dane['autor_name'])){
		  	$html.=" ".konf::get()->langTexty("autor_przez")." ";
		  	if(!empty($dane['autor_id'])&&user::get()->adminU()){
		  		$html.="<a class=\"male\" href=\"".$link."&amp;id_u=".$dane['autor_id']."\" target=\"_blank\">";
		  	}
			  $html.="<span class=\"grube\">".$dane['autor_name']."</span>";
		  	if(!empty($dane['autor_id'])&&user::get()->adminU()){
		  		$html.="</a>";
		  	}
			}
	  }
	  //wyedytowano
	  if($dane['edytor_kiedy']!="0000-00-00 00:00:00"){
		  $html.="<br />".konf::get()->langTexty("autor_wyedytowano")." <span class=\"grube\">".substr($dane['edytor_kiedy'],0,16)."</span>";
	    if(!empty($dane['edytor_name'])){
	   		$html.=" ".konf::get()->langTexty("autor_przez")." ";
	   		if(!empty($dane['edytor_id'])&&user::get()->adminU()){
		  		$html.="<a class=\"male\" href=\"".$link."&amp;id_u=".$dane['edytor_id']."\" target=\"_blank\">";
	  		}
	  		$html.="<span class=\"grube\">".$dane['edytor_name']."&nbsp;</span>";
	   		if(!empty($dane['edytor_id'])&&user::get()->adminU()){
	   			$html.="</a>";
	   		}
			}
		}
		
	  //od kiedy do kiedy
	  if(!empty($dane['data_start'])&&$dane['data_start']!="0000-00-00 00:00:00"){
			$html.="<br />";
			$html.=konf::get()->langTexty("autor_aktywneod");
			$html.=" <span class=\"grube\">".substr($dane['data_start'],0,16)."</span>";
		}
	  if(!empty($dane['data_stop'])&&$dane['data_stop']!="0000-00-00 00:00:00"){
			$html.="<br />";
		  $html.=konf::get()->langTexty("autor_aktywnedo");
			$html.=" <span class=\"grube\">".substr($dane['data_stop'],0,16)."</span>";
		}
		
		$html.="</div>";  
		
		return $html;
		
	}
	
	
	/**
   * komunikat dane			
   * @param string $komunikat
   * @param int $colspan			
   * @param bool $td		
	 * @return string		
   */			
	public static function komunikatDane($komunikat,$colspan="",$td=false){	
	
		$html="";
		
		if($td){
			$html.="<tr><td";
			if(!empty($colspan)&&$colspan>1){
				$html.=" colspan=\"".$colspan."\"";
			}
		} else {
			$html.="<div";
		}
		$html.=" class=\"brak\">";
		
		$html.=konf::get()->langTexty($komunikat);
		
		if($td){		
			$html.="</td></tr>";
		} else {
			$html.="</div>";
		}
		
		return $html;	

	}	
	
	
	/**
   * nieprawidlowe dane			
   * @param int $colspan			
   * @param bool $td		
	 * @return string		
   */			
	public static function nieprawidlowe($colspan="",$td=false){	
	
		$html=interfejs::komunikatDane("nieprawidlowe",$colspan,$td);
		
		return $html;	

	}
	
	
	/**
   * brak danych
   * @param int $colspan			
   * @param bool $td
	 * @return string		
   */			
	public static function brak($colspan="",$td=true){	
	
		$html=interfejs::komunikatDane("brakdanych",$colspan,$td);
		
		return $html;
		
	}	

	
	/**
   * przycisk
   * @param string $id
   * @param string $opis	
   * @param string $klasy
	 * @return string					
   */		
	public static function label($id,$opis="",$klasy="",$spacja=false){
		
		$html="";
		
		if($id){
		
		  $html.="<label for=\"".$id."\" id=\"".$id."_label\"";
			if($klasy){
				$html.=" class=\"".$klasy."\"";			
			}
			if(konf::get()->getInvalid($id)){
				$html.=" style=\"color:#ff0000\"";
			}			
			$html.=">";
			if($spacja){
				$html.=" ";
			}
			$html.=$opis."</label>";
			
		}

		return $html;
	
	}		
		
								
	/**
   * class constructor php5	
   */	
	public function __construct() {	

		
  }	

	
}

?>