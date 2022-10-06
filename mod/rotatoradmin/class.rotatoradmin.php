<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

class rotatoradmin extends moduladmin {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="rotatoradmin class";
	
  /**
   * rotator stats
   */
	public function staty(){

		echo tab_nagl(konf::get()->langTexty("rot_stat"),2);
		
		echo "<tr><td colspan=\"2\" class=\"tlo4 grube\">".konf::get()->langTexty("rot_stat_ogolne")."</td></tr>";	
		
		echo "<tr class=\"prawa grube\"><td class=\"tlo4\">".konf::get()->langTexty("rot_stat_nazwa")."</td><td class=\"tlo4\" style=\"width:70px\">".konf::get()->langTexty("rot_stat_ilosc")."</td></tr>";		
		
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">".konf::get()->langTexty("rot_stat_ilew")."</td>";		
		echo "<td class=\"tlo4 prawa\">".konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'rotator'))."</td>";				
		echo "</tr>";		
		
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">".konf::get()->langTexty("rot_stat_sumaw")."</td>";		
		$dane=konf::get()->_bazasql->pobierzRekord("SELECT SUM(licznik) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'rotator'));
		echo "<td class=\"tlo4 prawa\">".$dane['ile']."</td>";				
		echo "</tr>";	
		
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">".konf::get()->langTexty("rot_stat_sumak")."</td>";		
		$dane=konf::get()->_bazasql->pobierzRekord("SELECT SUM(klik) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'rotator'));
		echo "<td class=\"tlo4 prawa\">".$dane['ile']."</td>";				
		echo "</tr>";		

		echo "<tr><td colspan=\"2\" class=\"tlo4 grube\">".konf::get()->langTexty("rot_stat_typy")."</td></tr>";	
		echo "<tr class=\"prawa grube\"><td class=\"tlo4\">".konf::get()->langTexty("rot_stat_nazwa")."</td><td class=\"tlo4\">".konf::get()->langTexty("rot_stat_ilosc")."</td></tr>";		
		
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">".konf::get()->langTexty("rot_stat_link")."</td>";		
		echo "<td class=\"tlo4 prawa\">".konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'rotator')." WHERE link!=''")."</td>";
		echo "</tr>";		
		
		$roz_tab=konf::get()->getKonfigTab("roz");

		$zap=konf::get()->_bazasql->zap("SELECT COUNT(id) AS ile, img FROM ".konf::get()->getKonfigTab("sql_tab",'rotator')." WHERE link='' AND img!=0 GROUP BY img ORDER BY img");	
		
		while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
			if(!empty($konfig_roz[$dane['img']])){
				echo "<tr class=\"prawa\">";
				echo "<td class=\"tlo3\">".$roz_tab[$dane['img']]."</td>";		
				echo "<td class=\"tlo4 prawa\">".$dane['ile']."</td>";			
				echo "</tr>";	
			}
		}	
		konf::get()->_bazasql->freeResult($zap);
		
	  $link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"rotatoradmin_edytuj"));
		
		$zap=konf::get()->_bazasql->zap("SELECT id, tytul, img_nazwa_oryginal, licznik FROM ".konf::get()->getKonfigTab("sql_tab",'rotator')." WHERE licznik>0 ORDER BY licznik DESC LIMIT 0,10");
			
		if(konf::get()->_bazasql->numRows($zap)>0){	
			
			echo "<tr><td colspan=\"2\" class=\"tlo4 grube\">".konf::get()->langTexty("rot_stat_nw")."</td></tr>";
			echo "<tr class=\"prawa grube\"><td class=\"tlo4\">".konf::get()->langTexty("rot_stat_nazwa")."</td><td class=\"tlo4\">".konf::get()->langTexty("rot_stat_ilosc")."</td></tr>";		
				
			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
				echo "<tr class=\"prawa\">";
				echo "<td class=\"tlo3\">";
				echo "<span class=\"male\">".$dane['img_nazwa_oryginal']."</span> ";
				echo "<a href=\"".$link."&amp;id_nr=".$dane['id']."\">".$dane['tytul']."</a>";
				echo "</td>";		
				echo "<td class=\"tlo4 prawa\">".$dane['licznik']."</td>";			
				echo "</tr>";	
			}	
		}
		
		konf::get()->_bazasql->freeResult($zap);	
		
		$zap=konf::get()->_bazasql->zap("SELECT id, tytul, img_nazwa_oryginal, klik FROM ".konf::get()->getKonfigTab("sql_tab",'rotator')." WHERE klik>0 ORDER BY klik DESC LIMIT 0,10");
			
		if(konf::get()->_bazasql->numRows($zap)>0){	

			echo "<tr><td colspan=\"2\" class=\"tlo4 grube\">".konf::get()->langTexty("rot_stat_nk")."</td></tr>";	
			echo "<tr class=\"prawa grube\"><td class=\"tlo4\">".konf::get()->langTexty("rot_stat_nazwa")."</td><td class=\"tlo4\">".konf::get()->langTexty("rot_stat_ilosc")."</td></tr>";		
				
			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
				echo "<tr class=\"prawa\">";
				echo "<td class=\"tlo3\">";
				echo "<span class=\"male\">".$dane['img_nazwa_oryginal']."</span> ";		
				echo "<a href=\"".$link."&amp;id_nr=".$dane['id']."\">".$dane['tytul']."</a>";
				echo "</td>";		
				echo "<td class=\"tlo4 prawa\">".$dane['klik']."</td>";			
				echo "</tr>";	
			}	
		}
		
		konf::get()->_bazasql->freeResult($zap);		
		
		$zap=konf::get()->_bazasql->zap("SELECT id, tytul, img_nazwa_oryginal, (klik/licznik) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'rotator')." WHERE klik>0 AND licznik>0 ORDER BY ile DESC LIMIT 0,10");
		
		if(konf::get()->_bazasql->numRows($zap)>0){
		
			echo "<tr><td colspan=\"2\" class=\"tlo4 grube\">".konf::get()->langTexty("rot_stat_kw")."</td></tr>";	
			echo "<tr class=\"prawa grube\"><td class=\"tlo4\">".konf::get()->langTexty("rot_stat_nazwa")."</td><td class=\"tlo4\">".konf::get()->langTexty("rot_stat_ilosc")."</td></tr>";		
				
			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
			
				echo "<tr class=\"prawa\">";
				echo "<td class=\"tlo3\">";
				echo "<span class=\"male\">".$dane['img_nazwa_oryginal']."</span> ";		
				echo "<a href=\"".$link."&amp;id_nr=".$dane['id']."\">".$dane['tytul']."</a>";
				echo "</td>";		
				echo "<td class=\"tlo4 prawa\">".number_format($dane['ile'],5)."</td>";			
				echo "</tr>";	
			}	
		}
		
		konf::get()->_bazasql->freeResult($zap);			

		echo tab_stop();
		
	}


  /**
   * rotator typy
   */
	public function typy(){
	
		$colspan=2;
		
		$roz_tab=konf::get()->getKonfigTab("roz");
		$kat_tab=konf::get()->getKonfigTab("rotator_konf",'kat_tab');		

		echo tab_nagl(konf::get()->langTexty("rot_typy"),$colspan);
		echo "<tr><td class=\"tlo4 lewa grube\">".konf::get()->langTexty("rot_typy_nazwa")."</td>";
		echo "<td class=\"tlo4 prawa grube\" style=\"width:50px\">".konf::get()->langTexty("rot_typy_ilosc")."</td></tr>";
		
		if(isset($kat_tab)&&is_array($kat_tab)){
		
			$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"rotatoradmin_arch"));
			
			while(list($key,$val)=each($kat_tab)){
			
				echo "<tr valign=\"middle\"><td class=\"tlo3\">";
				
				echo "<div class=\"lewa\">";
				echo interfejs::linkEl("film",$link."&amp;id_typ=".$key,$val['nazwa'],"lewa");
	      echo "</div>";
				echo "<div class=\"male nowa_l\">";
				if(!isset($val['typy'])||empty($val['typy'])||!is_array($val['typy'])){
					$val['typy']=konf::get()->getKonfigTab("rotator_konf",'typy');
				} 
				reset($val['typy']);
				echo konf::get()->langTexty("rot_typy_typyp")." ";
				
				$i=0;
				while(list($key2,$val2)=each($val['typy'])){
					if(!empty($roz_tab[$val2])){
						if($i>0){
							echo ", ";
						}
						echo $roz_tab[$val2];				
					}				
					$i++;
				}
				
				echo "<br />";	
						
				echo konf::get()->langTexty("rot_typy_sod")." <span class=\"grube\">";
				if(isset($val['img_min_w'])&&$val['img_min_w']!=''){
					echo $val['img_min_w'];
				} else {
				  echo konf::get()->getKonfigTab("rotator_konf",'img_min_w');
				}
				echo "</span> ".konf::get()->langTexty("rot_typy_px");
				
				echo " ".konf::get()->langTexty("rot_typy_do")." <span class=\"grube\">";
				if(!empty($val['img_max_w'])){
					echo $val['img_max_w'];
				} else {
				  echo konf::get()->getKonfigTab("rotator_konf",'img_max_w');
				}
				echo "</span> ".konf::get()->langTexty("rot_typy_px").", ";			

				echo konf::get()->langTexty("rot_typy_wod")." <span class=\"grube\">";
				if(isset($val['img_min_h'])&&$val['img_min_h']!=''){
					echo $val['img_min_h'];
				} else {
				  echo konf::get()->getKonfigTab("rotator_konf",'img_min_h');
				}
				echo "</span> ".konf::get()->langTexty("rot_typy_px");
				
				echo " ".konf::get()->langTexty("rot_typy_do")." <span class=\"grube\">";
				if(!empty($val['img_max_h'])){
					echo $val['img_max_h'];
				} else {
				  echo konf::get()->getKonfigTab("rotator_konf",'img_max_h');
				}
				echo "</span> ".konf::get()->langTexty("rot_typy_px")." ";		
				
				echo " (".konf::get()->langTexty("rot_typy_max")." <span class=\"grube\">";
				if(!empty($val['size_max'])){
					echo round($val['size_max']/1024);
				} else {
				  echo round(konf::get()->getKonfigTab("rotator_konf",'size_max')/1024);
				}
				echo "</span> ".konf::get()->langTexty("rot_typy_kb");		
					
				echo "</div>";
				echo "</td>";
				echo "<td class=\"tlo3 prawa\">";
				echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'rotator')." WHERE id_typ='".tekstForm::doSql($key)."'");
				echo "</td></tr>";
				
			}
			echo "<tr class=\"srodek\"><td class=\"tlo4\" colspan=\"".$colspan."\">".interfejs::linkEl("film",$link,konf::get()->langTexty("rot_typy_wszystkie"))."</td></tr>";		
			
		} else {
			echo interfejs::brak($colspan);
		}
		
		echo tab_stop();
		
	}

	
	/**
   * change parameter
   * @param array $dane
   */		
	private function banerRys($dane){
	
		if(!empty($dane['link'])){
		
			echo $dane['link'];
								
		} else if(!empty($dane['img'])&&!empty($dane['img_w'])&&!empty($dane['img_h'])&&!empty($dane['img_nazwa'])){

			$pliczek=konf::get()->getKonfigTab("rotator_konf",'kat').$dane['img_nazwa'];

		  if(file_exists(konf::get()->getKonfigTab("serwer").$pliczek)){			
											
				if($dane['img']==4||$dane['img']==13){	
			
				  $swf=new swf(konf::get()->getKonfigTab("sciezka").$pliczek,$dane['img_w'],$dane['img_h']);
					$swf->setId('rotator_podglad'.$dane['id']);						
					if($dane['img_tlo']=="xxxxxx"){
					  $swf->setParametry(array("wmode"=>"transparent"));						
					} else if(!empty($dane['img_tlo'])){
			  		$swf->setParametry(array("bgcolor"=>"#".$dane['img_tlo']));
					}
					echo $swf->pobierz();

				} else {
					echo "<img src=\"".konf::get()->getKonfigTab("sciezka").$pliczek."\" width=\"".$dane['img_w']."\" height=\"".$dane['img_h']."\" alt=\"\" />";
				}		
			}
		}
	}

	
  /**
   * rotator list
   */
	public function arch(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');	
		$sortuj=tekstForm::doSql(konf::get()->getZmienna("sortuj","sortuj"));
	  $szuk_status=tekstForm::doSql(konf::get()->getZmienna("szuk_status","szuk_status"));
	  $szuk=tekstForm::male(tekstForm::doSql(konf::get()->getZmienna("szuk","szuk")));
	  $szuk_aktual=tekstForm::doSql(konf::get()->getZmienna("szuk_aktual","szuk_aktual")); 
	  $szuk_lang=tekstForm::doSql(konf::get()->getZmienna("szuk_lang","szuk_lang"));
		$id_typ=tekstForm::doSql(konf::get()->getZmienna("id_typ","id_typ"));
		$id_nr=tekstForm::doSql(konf::get()->getZmienna("id_nr","id_nr"));
		
		$roz_tab=konf::get()->getKonfigTab("roz");
		$kat_tab=konf::get()->getKonfigTab("rotator_konf",'kat_tab');		
			
		$colspan=9;

		$tab_sort=array(
			1=>"id", 2=>"id DESC", 
			3=>"tytul", 4=>"tytul DESC", 
			5=>"data_start, data_stop", 6=>"data_start DESC, data_stop DESC", 
			7=>"status", 8=>"status DESC", 
			9=>"lang", 10=>"lang DESC", 
			11=>"priorytet", 12=>"priorytet DESC", 
			13=>"udzial", 14=>"udzial DESC",
			15=>"licznik", 16=>"licznik DESC",
			17=>"klik", 18=>"klik DESC",				
		);

		if(empty($sortuj)||empty($tab_sort[$sortuj])){ 
			$sortuj=3; 
		}

		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"rotatoradmin_arch","id_typ"=>$id_typ));

		$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'rotator')." WHERE 1 ";
		
		if(!empty($id_typ)){
			$query.=" AND id_typ='".$id_typ."'";
		}
	  
	  if($szuk_status==1){
	    $query.=" AND status=1 ";
	    $link.="&amp;szuk_status=1";
	  } else if($szuk_status==2){
	    $query.=" AND status!=1 ";
	    $link.="&amp;szuk_status=2";
	  }

	  if(!empty($szuk)){
	    $link.="&amp;szuk=".rawurlencode($szuk);
	    $query.=" AND (LCASE(tytul) LIKE '%".tekstForm::doLike($szuk,true)."%' ";
	  }
		
	  if(!empty($szuk_lang)){
	    $link.="&amp;szuk_lang=".rawurlencode($szuk_lang);
	    $query.=" AND (lang=0 OR lang='".tekstForm::doSql($szuk_lang)."') ";
	  }	
	   
	  if($szuk_aktual==1){
	    $query.=" AND status=1 AND data_start<=NOW() AND data_stop>=NOW() ";
	    $link.="&amp;szuk_aktual=1";
	  } else if($szuk_aktual==2){
	    $query.=" AND (status!=1 OR data_start>NOW() AND data_stop>NOW()) ";
	    $link.="&amp;szuk_aktual=2";
	  }

		$naw = new nawig("SELECT COUNT(id) AS ilosc ".$query,$podstrona,konf::get()->getKonfigTab("rotator_konf",'na_str'));		
		$naw->naw($link."&amp;sortuj=".$sortuj);
		$podstrona=$naw->getPodstrona();	

		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"arch","arch");
		echo $form->spr(array(1=>"akcja"),"","ok=spr_akcjau(document.arch.akcja,'rotatoradmin_usun','".konf::get()->langTexty("czyusun")."');");
		echo $form->getFormp();
		echo $form->przenies(array(
		  "id_typ"=>$id_typ,
			"sortuj"=>$sortuj,
			"szuk_status"=>$szuk_status,
			"szuk"=>$szuk,
			"szuk_aktual"=>$szuk_aktual,
			"szuk_lang"=>$szuk_lang,		
			"podstrona"=>$podstrona
		));
			
	  echo tab_nagl(konf::get()->langTexty("rot_arch_lista").$naw->getWynikow()."):",$colspan);
	  
		if(!empty($id_typ)&&!empty($kat_tab[$id_typ])){
		  echo "<tr><td colspan=\"".$colspan."\" class=\"tlo4\">".konf::get()->langTexty("rot_arch_typ")." <span class=\"grube\">".$kat_tab[$id_typ]['nazwa']."</span></td></tr>";
		}
		
		echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 lewa\">";
		
	  //akcje  
		$akcje_tab['rotatoradmin_dodaj']=konf::get()->langTexty("adodaj");
		if($naw->getWynikow()>0){		
			$akcje_tab['rotatoradmin_aktywuj']=konf::get()->langTexty("aaktyw");
			$akcje_tab['rotatoradmin_deaktywuj']=konf::get()->langTexty("adeaktyw");
			$akcje_tab['rotatoradmin_usun']=konf::get()->langTexty("ausun");
		}
		$akcje_tab['rotatoradmin_staty']=konf::get()->langTexty("rot_arch_astat");		

		echo $form->selectAkcja($akcje_tab);	
		echo "</td></tr>";	
		
		if($naw->getWynikow()>0){			
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo4 srodek nobr\">";		
			echo $form->zaod("id_tab");	
			echo "</td></tr>";	
		}			

		if($naw->getNaw()){
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
		}	

		echo "<tr class=\"srodek\">";
		
		echo interfejs::sortEl($link."&amp;sortuj=",1,2,konf::get()->langTexty("rot_arch_id"),$sortuj,50);
		echo interfejs::sortEl($link."&amp;sortuj=",3,4,konf::get()->langTexty("rot_arch_baner"),$sortuj);
		echo interfejs::sortEl($link."&amp;sortuj=",15,16,konf::get()->langTexty("rot_arch_wys"),$sortuj,70);
		echo interfejs::sortEl($link."&amp;sortuj=",17,18,konf::get()->langTexty("rot_arch_klik"),$sortuj,70);
		echo interfejs::sortEl($link."&amp;sortuj=",5,6,konf::get()->langTexty("rot_arch_aktywnosc"),$sortuj,80);
		echo interfejs::sortEl($link."&amp;sortuj=",7,8,konf::get()->langTexty("rot_arch_status"),$sortuj,70);
		echo interfejs::sortEl($link."&amp;sortuj=",9,10,konf::get()->langTexty("rot_arch_jezyk"),$sortuj,70);
		echo interfejs::sortEl($link."&amp;sortuj=",11,12,konf::get()->langTexty("rot_arch_prio"),$sortuj,70);
		echo interfejs::sortEl($link."&amp;sortuj=",13,14,konf::get()->langTexty("rot_arch_udzial"),$sortuj,70);

		echo "</tr>";

		if($naw->getWynikow()>0){

			$zap=konf::get()->_bazasql->zap("SELECT * ".$query." ORDER BY ".$tab_sort[$sortuj].",id LIMIT ".$naw->getStart().",".$naw->getIle());

			$link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"rotatoradmin_edytuj"));
			 
			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
			
				echo "<tr class=\"srodek\"><td class=\"tlo4 srodek\">";
			  echo "<input type=\"checkbox\" name=\"id_tab[]\" class=\"przycisk\" value=\"".$dane['id']."\" />";
				echo "<div ";
				if($id_nr==$dane['id']){
					echo " class=\"grube\"";
				}
				echo ">";
				echo $dane['id'];
				echo "</div>";
				echo "</td>";
				
				echo "<td class=\"tlo3 lewa\">";

				echo "<a href=\"".$link2."&amp;id_nr=".$dane['id']."\">";		
				echo strip_tags($dane['tytul']);
				echo "</a>";
				
				echo "<table border=\"0\" style=\"margin-top:5px\"><tr valign=\"top\">";  
				
			  echo interfejs::edytuj($link2."&amp;id_nr=".$dane['id']);				
				echo interfejs::infoEl($dane);			  							
				echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"rotatoradmin_usun","id_typ"=>$id_typ,"id_tab[]"=>$dane['id']))); 		
				echo interfejs::przyciskEl("eye","javascript:wlacz_wylacz('baner_".$dane['id']."')"); 			

				echo "</tr></table>"; 			
				
				echo "</td>";
				
				echo "<td class=\"srodek tlo3\">";
				
				if($dane['czy_licznik']){
				
					echo "<span class=\"grube\">".$dane['licznik']."</span>";
					
					if(!empty($dane['licznik_limit'])){
							echo "<div>(".$dane['licznik_limit'].")</div>";
					}

				} else {
					echo "&nbsp;";
				}
				
				echo "</td>";
				
				
				echo "<td class=\"srodek tlo3\">";
				
				if($dane['czy_klik']){
				
					echo "<span class=\"grube\">".$dane['klik']."</span>";
					
					if(!empty($dane['klik_limit'])){
							echo "<div>(".$dane['klik_limit'].")</div>";
					}

				} else {
					echo "&nbsp;";
				}
				
				echo "</td>";						
					
				echo "<td class=\"tlo3 male nobr\">";
				if($dane['data_start']!="0000-00-00 00:00:00"){
					echo konf::get()->langTexty("rot_arch_od")." <span class=\"grube\">".substr($dane['data_start'],0,10)."</span><br />";
				}
				if($dane['data_stop']!="0000-00-00 00:00:00"){
					echo konf::get()->langTexty("rot_arch_do")." <span class=\"grube\">".substr($dane['data_stop'],0,10)."</span><br />";
				}			
				echo "</td>";
				
				echo "<td class=\"tlo3\">";
				if($dane['status']==1){ 
					echo konf::get()->langTexty("aktywne"); 
				} else { 
					echo konf::get()->langTexty("nieaktywne"); 
				}
				echo "</td>";
				
				echo "<td class=\"tlo3\">";
				$lang_tab=konf::get()->getKonfigTab('tab_lang');
				if(!empty($dane['lang'])&&!empty($lang_tab[$dane['lang']])){ 
					echo $lang_tab[$dane['lang']];
				}
				echo "</td>";
				
				echo "<td class=\"tlo3 prawa\">";
				if(!empty($dane['priorytet'])){ 
					echo $dane['priorytet'];
				}
				echo "</td>";			
				
				echo "<td class=\"tlo3 prawa\">";
				if(!empty($dane['udzial'])){ 
					echo $dane['udzial'];
				}
				echo "</td>";						
				
				echo "</tr>";
				
				echo "<tr style=\"display:none\" id=\"baner_".$dane['id']."\"><td colspan=\"".$colspan."\" class=\"srodek tlo3\">";					
				$this->banerRys($dane);											
				echo "</td></tr>";
								
			}

			konf::get()->_bazasql->freeResult($zap);		
			
		} else { 
			echo interfejs::brak($colspan);
		}

		if($naw->getNaw()){
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
		}	

		
		echo "<tr class=\"srodek\"><td colspan=\"".$colspan."\" class=\"tlo4 srodek\">";
		echo interfejs::linkEl("film",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"rotatoradmin_typy")),konf::get()->langTexty("rot_arch_listakat"));
		echo "</td></tr>";		
		
	  echo tab_stop();
		echo $form->getFormk();
	  
	  echo tab_nagl(konf::get()->langTexty("wyszukiwarka"),1);
		echo "<tr><td class=\"tlo3\">";
		
		$form2=new formularz("post",konf::get()->getKonfigTab("plik"),"arch2","arch2");
		echo $form2->getFormp();
		echo $form2->przenies(array("akcja"=>"rotatoradmin_arch","id_typ"=>$id_typ,"sortuj"=>$sortuj));		
		echo $form2->select("szuk_status","szuk_status",array(1=>konf::get()->langTexty("rot_arch_szuk_status1"),2=>konf::get()->langTexty("rot_arch_szuk_status2")),$szuk_status,"f_dlugi",konf::get()->langTexty("rot_arch_szuk_status0"));
		echo " ";			
		echo $form2->input("text","szuk","szuk",$szuk,"f_dlugi",50);		
		echo " ";
		echo $form2->select("szuk_aktual","szuk_aktual",array(1=>konf::get()->langTexty("rot_arch_szuk_dostepne"),2=>konf::get()->langTexty("rot_arch_szuk_niedostepne")),$szuk_aktual,"f_dlugi",konf::get()->langTexty("rot_arch_szuk_dostepnosc"));
		echo " ";
		echo $form2->select("szuk_lang","szuk_lang",konf::get()->getKonfigTab('tab_lang'),$szuk_lang,"f_dlugi",konf::get()->langTexty("rot_arch_lang"));
		echo " ";	
		echo $form2->input("submit","","",konf::get()->langTexty("szukaj"),"formularz2 f_sredni");		
		echo $form2->getFormk();
		
		echo "</td></tr>";	
		echo tab_stop();
		
	}


	//formularz dodawania/edycji
	protected function formularz(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');		
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));
		$id_typ=tekstForm::doSql(konf::get()->getZmienna("id_typ","id_typ"));

		$roz_tab=konf::get()->getKonfigTab("roz");
		$kat_tab=konf::get()->getKonfigTab("rotator_konf",'kat_tab');				
		
		//domyślne wartosci
		$dane=array(
			'tytul'=>"",
			'id_typ'=>$id_typ,
			'link'=>"",
			'tytul'=>"",
			'opis'=>"",
			'priorytet'=>0,
			'udzial'=>0,		
			'licznik'=>0,
			'licznik_limit'=>0,
			'czy_licznik'=>0,
			'klik'=>0,
			'klik_limit'=>0,
			'czy_klik'=>0,
			'data_start'=>date("Y-m-d H:i"),
			'data_stop'=>"",
			'img'=>"",
			'img_nazwa'=>"",
			'img_nazwa_oryginal'=>"",	
			'img_w'=>"",
			'img_h'=>"",
			'img_tlo'=>"ffffff",
			'swf_wersja'=>6,
			'img_link'=>"",
			'link_okno'=>"",
			'lang'=>"",
			'status'=>1		
		);
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"rotator","rotator");	
		$dane=$form->odczyt($dane);	

		if(!empty($id_nr)){
			$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'rotator')." WHERE id='".$id_nr."'");
			if(empty($dane)){
				$id_nr="";
			}
		}

		//jesli wszystko ok to wyswietl formularz
		if(konf::get()->getAkcja()=="rotatoradmin_dodaj"||!empty($id_nr)){
			
			$form->setMultipart(true);
			
			?><script type="text/javascript">
			
			function spr_rotatorf(){
			
				if(document.rotator.pic.value=='' && document.rotator.link.value==''){ 		
					form_set_error("pic",'<?php echo htmlspecialchars(konf::get()->langTexty("rot_form_uzupelnij")); ?>');			
				}	
				
			}
			
			</script><?php			
			
			if(!empty($id_nr)){
				echo $form->spr(array(1=>"tytul",2=>"id_typ"),"","");			
	  		echo tab_nagl(konf::get()->langTexty("rot_form_edycja"),1);
			} else {
				echo $form->spr(array(1=>"tytul",2=>"id_typ"),""," spr_rotatorf(); ");
	  		echo tab_nagl(konf::get()->langTexty("rot_form_dodawanie"),1);		
			}
	  
	  	echo "<tr><td valign=\"top\" class=\"tlo3\">";
			
			echo $form->getFormp();
			echo $form->przenies(array("a"=>"a","akcja"=>konf::get()->getAkcja()."2","id_nr"=>$id_nr));	
			
			echo "<table border=\"0\" style=\"margin-top:5px\"><tr>";    
			if(!empty($id_nr)){
				echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"rotatoradmin_usun","id_typ"=>$id_typ,"id_tab[]"=>$id_nr)));
				echo interfejs::infoEl($dane);		
			}
			echo interfejs::przyciskEl("arrow_join",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"rotatoradmin_arch","id_typ"=>$id_typ)),konf::get()->langTexty("rot_form_lista"));
			echo "</tr></table><br />";   
			
			echo "<div>";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");						
			echo "</div><br />";					

			echo $form->kalendarz("data_start","trigger_a",$dane['data_start'],true);		
			echo interfejs::label("data_start",konf::get()->langTexty("rot_form_dataod"),"grube",true);				
			echo "<br />";
		
			echo $form->kalendarz("data_stop","trigger_b",$dane['data_stop'],true);		
			echo interfejs::label("data_stop",konf::get()->langTexty("rot_form_datado"),"grube",true);						
			echo "<br /><br />";

			echo interfejs::label("id_typ",konf::get()->langTexty("rot_form_typ"),"grube");	
			echo interfejs::pomocEl(konf::get()->langTexty("rot_form_htyp"));		
			echo "<br />";		
			
			$kat_tab2=array();
			while(list($key,$val)=each($kat_tab)){
				$kat_tab2[$key]=$val['nazwa'];
			}
			echo $form->select("id_typ","id_typ",$kat_tab2,$dane['id_typ'],"f_bdlugi","--");
			echo "<br /><br />";
			
			echo interfejs::label("tytul",konf::get()->langTexty("rot_form_tytul"),"grube blok");				
			echo $form->input("text","tytul","tytul",$dane['tytul'],"f_bdlugi",200);
			echo "<br /><br />";
			
			echo interfejs::label("img_link",konf::get()->langTexty("rot_form_linkg"),"grube");
			echo interfejs::pomocEl(konf::get()->langTexty("rot_form_hadres"));
			echo "<br />";
			echo $form->input("text","img_link","img_link",$dane['img_link'],"f_bdlugi",200);				
			echo "<br /><br />";
			
			echo $form->input("text","link_okno","link_okno",$dane['link_okno'],"f_krotki",50);		
			echo interfejs::label("link_okno",konf::get()->langTexty("rot_form_okno"),"grube",true);						
		  echo "<br />";					
		  echo "<span class=\"male\"><span class=\"grube\" onclick=\"document.getElementById('link_okno').value='_blank'\">_blank</span> ".konf::get()->langTexty("rot_form_noweokno")." ,";
			echo " <span class=\"grube\" onclick=\"document.getElementById('link_okno').value='_self'\">_self</span> ".konf::get()->langTexty("rot_form_tosamookno")."</span>";
			echo "<br /><br />";
							
			if(!empty($dane['img'])&&!empty($dane['img_w'])&&!empty($dane['img_h'])&&!empty($dane['img_nazwa'])){
			
				$pliczek=konf::get()->getKonfigTab("rotator_konf",'kat').$dane['img_nazwa'];
			
			  if(file_exists(konf::get()->getKonfigTab("serwer").$pliczek)){					
				
			    echo "<br /><span class=\"male\">".konf::get()->langTexty("rot_form_dotychczasowa")."</span>";
					echo "<div style=\"padding-top:10px; padding-bottom:10px\">";
					
					if($dane['img_w']>650){
						echo "<div style=\"width:650px; overflow-x:scroll;\">";
					}			

					//baner flash
					if($dane['img']==4||$dane['img']==13){	
					
					  $swf=new swf(konf::get()->getKonfigTab("sciezka").$pliczek,$dane['img_w'],$dane['img_h']);
						$swf->setId('rotator_podglad');						
						if($dane['img_tlo']=="xxxxxx"){
						  $swf->setParametry(array("wmode"=>"transparent"));						
						} else if(!empty($dane['img_tlo'])){
						  $swf->setParametry(array("bgcolor"=>"#".$dane['img_tlo']));
						}
						echo $swf->pobierz();
						
					//inne banery
					} else {
						echo "<img src=\"".konf::get()->getKonfigTab("sciezka").$pliczek."\" width=\"".$dane['img_w']."\" height=\"".$dane['img_h']."\" alt=\"\" />";
					}
					
					if($dane['img_w']>650){
						echo "</div>";
					}							
					echo "</div>";
					
					echo $form->checkbox("img_usun","img_usun",1);		
					echo interfejs::label("img_usun",konf::get()->langTexty("usung"),"",true);											
					
				}
			}
			
		  echo "<br />";
			
			echo interfejs::label("pic",konf::get()->langTexty("rot_form_grafika"),"grube");					
			echo interfejs::pomocEl(konf::get()->langTexty("rot_form_hgrafika"));					
			echo "<br />";
			echo $form->input("file","pic","pic","","f_bdlugi");		
			echo "<br /><br />";
			
		  echo "<span class=\"grube\">".konf::get()->langTexty("rot_form_wymiary")."</span> ".konf::get()->langTexty("rot_form_mozliwosc");
			echo interfejs::pomocEl(konf::get()->langTexty("rot_form_hwymiary"));
			echo "<br />";		
						
			echo "<div style=\"width:200px;\" class=\"lewal\">";
			echo $form->input("text","img_w","img_w",$dane['img_w'],"f_krotki",6);					
			echo interfejs::label("img_w",konf::get()->langTexty("rot_form_szer"),"",true);													
			echo "<br /></div>";
			
			echo "<div style=\"width:200px;\" class=\"lewal\">";		
			echo $form->input("text","img_h","img_h",$dane['img_h'],"f_krotki",6);		
			echo interfejs::label("img_h",konf::get()->langTexty("rot_form_wys"),"",true);									
			echo "<br /></div>";					
			echo "<br class=\"nowa_l\" /><br />";		
			
			echo interfejs::label("img_tlo",konf::get()->langTexty("rot_form_tlo"),"grube",true);							
		  echo " ";
			echo konf::get()->langTexty("rot_form_tylko swf");
			echo interfejs::pomocEl(konf::get()->langTexty("rot_form_htlo"));		
			echo "<br /><br />";	
				
			echo "<div>";
			if($dane['img_tlo']=="xxxxxx"){		
				echo $form->checkbox("przezroczysty","przezroczysty",1,1);		
			} else {
				echo $form->checkbox("przezroczysty","przezroczysty",1,0);			
			}
			echo interfejs::label("przezroczysty",konf::get()->langTexty("rot_form_przezroczysty"),"nobr",true);								
			echo "</div>";
			echo "<br />"; 

			echo $form->colorPicker("img_tlo",$dane['img_tlo']);
			
			echo "<br class=\"nowa_l\" /><br />";			
			
			echo interfejs::label("link",konf::get()->langTexty("rot_form_link"),"grube");
			echo interfejs::pomocEl(konf::get()->langTexty("rot_form_hlink"));		
			echo "<br />";
			echo $form->textarea("link","link",$dane['link'],"f_bdlugi",10);			
			echo "<br /><br />";
							
			echo interfejs::label("opis",konf::get()->langTexty("rot_form_opis"),"grube");										
			echo interfejs::pomocEl(konf::get()->langTexty("rot_form_hopis"));				
			echo "<br />";
			echo $form->textarea("opis","opis",$dane['opis'],"f_bdlugi",10);					
			echo "<br /><br />";
			
			echo "<div style=\"width:290px;\" class=\"lewal\">";
			
			echo $form->checkbox("czy_licznik","czy_licznik",1,$dane['czy_licznik']);	
			echo interfejs::label("czy_licznik",konf::get()->langTexty("rot_form_czywys"),"nobr",true);						
			echo interfejs::pomocEl(konf::get()->langTexty("rot_form_hwys"));		
			echo "<br />";
			
			echo $form->input("text","licznik","licznik",$dane['licznik'],"f_krotki",11);	
			echo interfejs::label("licznik",konf::get()->langTexty("rot_form_wysw"),"",true);											
			echo "<br />";
			echo $form->input("text","licznik_limit","licznik_limit",$dane['licznik_limit'],"f_krotki",11);			
			echo interfejs::label("licznik_limit",konf::get()->langTexty("rot_form_wyslimit"),"",true);			
			echo "<br /><br />";
			echo "</div>";
			
			echo "<div style=\"width:290px;\" class=\"lewal\">";		
			echo $form->checkbox("czy_klik","czy_klik",1,$dane['czy_klik']);	
			echo interfejs::label("czy_klik",konf::get()->langTexty("rot_form_czyklik"),"nobr",true);						 
			echo interfejs::pomocEl(konf::get()->langTexty("rot_form_hklik"));
				
			echo "<br />";
			echo $form->input("text","klik","klik",$dane['klik'],"f_krotki",11);	
			echo interfejs::label("klik",konf::get()->langTexty("rot_form_klik"),"",true);										
			echo "<br />";
			echo $form->input("text","klik_limit","klik_limit",$dane['klik_limit'],"f_krotki",11);		
			echo interfejs::label("klik_limit",konf::get()->langTexty("rot_form_kliklimit"),"",true);	
			echo "<br /><br />";
			echo "</div>";
			
			echo "<div class=\"nowa_l\"></div>";
					
			echo "<select name=\"priorytet\" id=\"priorytet\" class=\"f_sredni\">";
			echo "<option value=\"\">".konf::get()->langTexty("rot_form_brak")."</option>";
			for($i=1;$i<=100;$i++){
				echo "<option value=\"".$i."\"";
				if($dane['priorytet']==$i){
					echo " selected=\"selected\"";
				}
				echo ">".$i;
				if($i==1){
					echo konf::get()->langTexty("rot_form_najwyzszy");
				}			
				if($i==100){
					echo konf::get()->langTexty("rot_form_najnizszy");
				}
				echo "</option>";
			}
			echo "</select>";
			echo interfejs::label("priorytet",konf::get()->langTexty("rot_form_priorytet"),"",true);	
			echo interfejs::pomocEl(konf::get()->langTexty("rot_form_hpriorytet"));		
			echo "<br /><br />";
			
			echo "<select name=\"udzial\" id=\"udzial\" class=\"f_sredni\">";
			echo "<option value=\"\">".konf::get()->langTexty("rot_form_brak")."</option>";
			for($i=1;$i<=99;$i++){
				echo "<option value=\"".$i."\"";
				if($dane['udzial']==$i){
					echo " selected=\"selected\"";
				}
				echo ">".$i;
				if($i==1){
					echo konf::get()->langTexty("rot_form_najwyzszy");
				}			
				if($i==99){
					echo konf::get()->langTexty("rot_form_najnizszy");
				}
				echo "</option>";
			}
			echo "</select>";
			echo interfejs::label("udzial",konf::get()->langTexty("rot_form_udzial"),"",true);		
			echo interfejs::pomocEl(konf::get()->langTexty("rot_form_hudzial"));		
			echo "<br /><br />";		
						
			$tab_lang=konf::get()->getKonfigTab('tab_lang');
			
			if(!empty($tab_lang)&&is_array($tab_lang)&&count($tab_lang)>1){
			
				echo $form->select("lang","lang",$tab_lang,$dane['lang'],"f_sredni",konf::get()->langTexty("rot_form_dowolna"));
				echo interfejs::label("lang",konf::get()->langTexty("rot_form_lang"),"",true);									
				echo interfejs::pomocEl(konf::get()->langTexty("rot_form_hlangt"));						
				echo "<br /><br />";		
				
			}
			
	    echo "<div>";
			echo $form->checkbox("status","status",1,$dane['status']);		
			echo interfejs::label("status",konf::get()->langTexty("widoczny"),"nobr",true);									
	   	echo "</div><br />";
			
			echo "<div>";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");						
			echo "</div><br />";
			
			echo "<div class=\"male\">".konf::get()->langTexty("musza")."</div>";
			
			echo $form->getFormk();
			
			echo "</td></tr>";
		
		  echo "<tr class=\"srodek\"><td class=\"tlo4\">".interfejs::linkEl("film",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"rotatoradmin_arch","id_typ"=>$id_typ)),konf::get()->langTexty("rot_form_lista"))."</td></tr>";
	  	echo tab_stop();
			
		} else { 
			echo interfejs::nieprawidlowe();	
		}
		
	}


	//formularz dodawania/edycji
	protected function zapisz(){

		$id_nr=tekstForm::doSql(konf::get()->getZmienna("id_nr"));
		$img_h=tekstForm::doSql(konf::get()->getZmienna("img_h"));
		$img_w=tekstForm::doSql(konf::get()->getZmienna("img_w"));	
		$przezroczysty=tekstForm::doSql(konf::get()->getZmienna("przezroczysty"));
		$img_usun=tekstForm::doSql(konf::get()->getZmienna("img_usun"));	
					
	 	//dane podstawowe z formularza	
		$dane=array(
			"id_typ"=>"",
			"data_start"=>"",				
			"data_stop"=>"",		
			"tytul"=>"",				
			"link"=>"",				
			"opis"=>"",			
			"priorytet"=>"",			
			"udzial"=>"",			
			"licznik"=>"",				
			"licznik_limit"=>"",
			"czy_licznik"=>"",
			"klik"=>"",				
			"klik_limit"=>"",
			"czy_klik"=>"",				
			"img_tlo"=>"",				
			"img_link"=>"",
			"link_okno"=>"",				
			"lang"=>"",				
			"status"=>"",					
		);
		
		
		$dane_nieczysc=array("link");
		
		$testy[]=array("zmienna"=>"tytul","test"=>"wartosc","wymagany"=>true,
			"param"=>array(
				"komunikat"=>konf::get()->langTexty("art_admin_arch_nieprawidlowe"),
				'idtf'=>"tytul"			
			)	
		);	
		
		
		$kat_tab=konf::get()->getKonfigTab("rotator_konf",'kat_tab');		
		
		$testy[]=array("zmienna"=>"id_typ","test"=>"wtablicyi","wymagany"=>true,
			"param"=>array(
				"wartosci"=>$kat_tab,
				"domyslny"=>""
			)
		);		
		
		$testy[]=array("zmienna"=>"status","test"=>"truefalse",
			"param"=>array(
				"wartosc"=>1
			)
		);		
		
		$testy[]=array("zmienna"=>"czy_klik","test"=>"truefalse",
			"param"=>array(
				"wartosc"=>1
			)
		);		
		
		$testy[]=array("zmienna"=>"czy_licznik","test"=>"truefalse",
			"param"=>array(
				"wartosc"=>1
			)
		);			

		$testy[]=array("zmienna"=>"priorytet","test"=>"liczba",
			"param"=>array(
				"domyslny"=>0,
				"min"=>0,
				"max"=>100,						
			)
		);			
				
		$testy[]=array("zmienna"=>"udzial","test"=>"liczba",
			"param"=>array(
				"domyslny"=>1,
				"min"=>1,
				"max"=>99,						
			)
		);		
				
		$testy[]=array("zmienna"=>"klik","test"=>"liczba",
			"param"=>array(
				"domyslny"=>0,
				"min"=>0					
			)
		);		
					
		$testy[]=array("zmienna"=>"klik_limit","test"=>"liczba",
			"param"=>array(
				"domyslny"=>0,
				"min"=>0					
			)
		);		
			
		$testy[]=array("zmienna"=>"licznik","test"=>"liczba",
			"param"=>array(
				"domyslny"=>0,
				"min"=>0					
			)
		);		
					
		$testy[]=array("zmienna"=>"licznik_limit","test"=>"liczba",
			"param"=>array(
				"domyslny"=>0,
				"min"=>0					
			)
		);		
		
		$testy[]=array("zmienna"=>"img_tlo","test"=>"oczysc");	
		
		//generator zapytania insert/update
		require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
		$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'rotator'),$dane,$dane_nieczysc);
		$sqldane->daneOdczyt();	
		$sqldane->setAutor(true);	
		$sqldane->setTesty($testy);			

		$sqldane->testuj();	
		
		if($sqldane->ok()){
		
			$id_typ=$sqldane->getDane("id_typ");
		
			if(empty($kat_tab[$id_typ]['img_max_w'])){
				$kat_tab[$id_typ]['img_max_w']=konf::get()->getKonfigTab("rotator_konf",'img_max_w');
			}
			
			if(empty($kat_tab[$id_typ]['img_min_w'])){
				$kat_tab[$id_typ]['img_min_w']=konf::get()->getKonfigTab("rotator_konf",'img_min_w');
			}	
			
			if(empty($kat_tab[$id_typ]['img_max_h'])){
				$kat_tab[$id_typ]['img_max_h']=konf::get()->getKonfigTab("rotator_konf",'img_max_h');
			}
			
			if(empty($kat_tab[$id_typ]['img_min_h'])){
				$kat_tab[$id_typ]['img_min_h']=konf::get()->getKonfigTab("rotator_konf",'img_min_h');
			}	
			
			if(empty($kat_tab[$id_typ]['size_max'])){
				$kat_tab[$id_typ]['size_max']=konf::get()->getKonfigTab("rotator_konf",'size_max');
			}		
			
			if(empty($kat_tab[$id_typ]['typy'])){
				$kat_tab[$id_typ]['typy']=konf::get()->getKonfigTab("rotator_konf",'typy');
			}		
			
			if(empty($kat_tab[$id_typ]['skalowanie'])){
				$kat_tab[$id_typ]['skalowanie']=konf::get()->getKonfigTab("rotator_konf",'skalowanie');
			}								
		
			if(!empty($id_nr)){
				$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'rotator')." WHERE id='".$id_nr."'");
				if(empty($dane)){
					$id_nr="";
				}
			}	
					
			//przezroczste tlo specjalnie oznaczone
			if($przezroczysty==1){
				$img_tlo="xxxxxx";
				//dodaj dane zo zapytania
			 	$sqldane->setDane(array(
					"img_tlo"=>"xxxxxx"
				));					
			}				

			
			if($this->istnieje($sqldane->getDane("tytul"),$id_typ,$sqldane->getDane("link"),$id_nr)){
				
				//dodawanie
				if(empty($id_nr)){
				
					//budowanie zapytania
					$sqldane->dodajDaneD();							
					
					//wykonujemy
					if($sqldane->getSql()){
						konf::get()->_bazasql->zap($sqldane->getSql());					
						$id_nr=konf::get()->_bazasql->insert_id;
					}
					
					//grafika
					if(!empty($id_nr)){
					
						$grafika=$this->zapiszImg("pic",$id_typ,$id_nr,$img_w,$img_h);
						
						if(!empty($grafika)&&!empty($grafika['imgtyp'])){
							konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'rotator')." SET img='".$grafika['imgtyp']."', img_nazwa='".$grafika['nazwa_pliku']."', img_nazwa_oryginal='".$grafika['name']."', img_w='".$grafika['w']."', img_h='".$grafika['h']."', swf_wersja='".$grafika['swf']."' WHERE id='".$id_nr."'");
						} else if($sqldane->getDane("link")=='') {
							konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'rotator')." WHERE id='".$id_nr."'");	
							$id_nr="";
						}
						
						konf::get()->setZmienna("_post","id_nr",$id_nr);							
						
					}
					
				//edycja
				} else {
				
					$sqldane->dodajDaneE();								
					
					$query="";
					
					//czy usuwac / zamieniac grafike
					if($img_usun||!empty($_FILES['pic']["tmp_name"])){	

						//usuwanie
			    	if(!empty($dane['img'])&&!empty($konfig_roz[$dane['img']])&&file_exists(konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("rotator_konf",'kat').$dane['img_nazwa'])){						
			    		unlink(konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("rotator_konf",'kat').$dane['img_nazwa']); 
			  		}
						
						$grafika=$this->zapiszImg("pic",$id_typ,$id_nr,$img_w,$img_h);
						
						$query.=", img='".$grafika['imgtyp']."', img_nazwa='".$grafika['nazwa_pliku']."', img_nazwa_oryginal='".$grafika['name']."', img_w='".$grafika['w']."', img_h='".$grafika['h']."', swf_wersja='".$grafika['swf']."' ";		
					
					//dla swf sprawdzamy czy zmiana rozmiarow											
					} else if($dane['img']==4){
					
						//rozmiary flash podane przez uzytkownika						
						if(!empty($img_w)&&$img_w>=$kat_tab[$id_typ]['img_min_w']&&$img_w<=$kat_tab[$id_typ]['img_max_w']){
							$query.=", img_w='".$img_w."'";						
						}

						if(!empty($img_h)&&$img_h>=$kat_tab[$id_typ]['img_min_h']&&$img_h<=$kat_tab[$id_typ]['img_max_h']){
							$query.=", img_h='".$img_h."'";		
						}		
																					
					}
					
					$sqldane->dodaj($query);						
					$sqldane->dodaj(" WHERE id='".$id_nr."'");
					
					if($sqldane->getSql()){
						konf::get()->_bazasql->zap($sqldane->getSql());	
					}
				
				}

		    //jesli ok
		    if(!empty($id_nr)){   
		    	konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");
		    } else { 
					konf::get()->setKomunikat(konf::get()->langTexty("niezapisane"),"error");
				}		
			
			} else { 
				konf::get()->setKomunikat(konf::get()->langTexty("istnieje"),"error"); 
			}
				 		
		} else { 
			konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
		}
		
		if(konf::get()->getAkcja()=="rotatoradmin_dodaj2"){
			if(!empty($id_nr)){
				konf::get()->setAkcja("rotatoradmin_arch");				
			} else {
				konf::get()->setAkcja("rotatoradmin_dodaj");				
			}
		} else if(konf::get()->getAkcja()=="rotatoradmin_edytuj2"){	
			konf::get()->setAkcja("rotatoradmin_edytuj");					
		} 
		
	}

		
	public function zapiszImg($pliczek_nazwa,$id_typ,$id_nr,$szer=0,$wys=0){

		$kat_tab=konf::get()->getKonfigTab("rotator_konf",'kat_tab');			

		$img['imgtyp']=0;
		$img['w']=0;	
		$img['h']=0;
		$img['swf']=0;
		$img['name']=""; //oryginalna
		$img['nazwa_pliku']=""; //zapisana
		
		$ok=true;

		//plik
	  if(!empty($_FILES[$pliczek_nazwa])&&!empty($_FILES[$pliczek_nazwa]["tmp_name"])){
			
			if(empty($kat_tab[$id_typ]['img_max_w'])){
				$kat_tab[$id_typ]['img_max_w']=konf::get()->getKonfigTab("rotator_konf",'img_max_w');
			}
			
			if(empty($kat_tab[$id_typ]['img_min_w'])){
				$kat_tab[$id_typ]['img_min_w']=konf::get()->getKonfigTab("rotator_konf",'img_min_w');
			}	
			
			if(empty($kat_tab[$id_typ]['img_max_h'])){
				$kat_tab[$id_typ]['img_max_h']=konf::get()->getKonfigTab("rotator_konf",'img_max_h');
			}
			
			if(empty($kat_tab[$id_typ]['img_min_h'])){
				$kat_tab[$id_typ]['img_min_h']=konf::get()->getKonfigTab("rotator_konf",'img_min_h');
			}	
			
			if(empty($kat_tab[$id_typ]['size_max'])){
				$kat_tab[$id_typ]['size_max']=konf::get()->getKonfigTab("rotator_konf",'size_max');
			}		
			
			if(empty($kat_tab[$id_typ]['typy'])){
				$kat_tab[$id_typ]['typy']=konf::get()->getKonfigTab("rotator_konf",'typy');
			}		
			
			if(empty($kat_tab[$id_typ]['skalowanie'])){
				$kat_tab[$id_typ]['skalowanie']=konf::get()->getKonfigTab("rotator_konf",'skalowanie');
			}			
			
			require_once(konf::get()->getKonfigTab('klasy')."class.plikzapisz.php");
			
		  $pliczek=new plikZapisz(konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("rotator_konf",'kat').$id_nr."_"."[md5oryginal].[rozs]");
			$pliczek->zmiennaFiles($pliczek_nazwa);	
			$pliczek->setImgSkala($kat_tab[$id_typ]['skalowanie']);			
			$pliczek->setSizeMax($kat_tab[$id_typ]['size_max']);
			$pliczek->setImgSize(array("hmax"=>$kat_tab[$id_typ]['img_max_h'],"wmax"=>$kat_tab[$id_typ]['img_max_w'],"hmin"=>$kat_tab[$id_typ]['img_min_h'],"wmin"=>$kat_tab[$id_typ]['img_min_w']));
			$pliczek->setImgTypy(konf::get()->getKonfigTab("rotator_konf",'typy'));
			$img=$pliczek->zapiszImg();
			
			konf::get()->setKomunikatI($img['komunikat'],"error");

			//dla flash mozliwa zmian rozmiaru		
			if($img['ok']&&$img['imgtyp']==4){
				//rozmiary flash podane przez uzytkownika						
				if(!empty($szer)&&$szer>=$kat_tab[$id_typ]['img_min_w']&&$szer<=$kat_tab[$id_typ]['img_max_w']){
					$img['w']=$szer;						
				}						
				if(!empty($wys)&&$wys>=$kat_tab[$id_typ]['img_min_h']&&$wys<=$kat_tab[$id_typ]['img_max_h']){
					$img['h']=$wys;
				}
				
			}
			
		}
		
		return $img;
		
	}
			


	//sprawdza czy rekord istnieje
	public function istnieje($tytul,$id_typ,$link,$id=""){

		$ok=true;

		$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'rotator')." WHERE tytul='".$tytul."' AND id_typ='".$id_typ."'";
		if(!empty($id)){
			$query.=" AND id!='".$id."'";
		}
		$ile=konf::get()->_bazasql->policz("id",$query);
		if($ile>0){
			$ok=false;
		}
		
		return $ok;	
		
	}

	
	public function aktywuj(){
	
		$this->zmienparam("status",1,konf::get()->getKonfigTab("sql_tab",'rotator'),konf::get()->langTexty("rot_zmiena_log"));		
	
	}
	
	
	public function deaktywuj(){
	
		$this->zmienparam("status",0,konf::get()->getKonfigTab("sql_tab",'rotator'),konf::get()->langTexty("rot_zmiena_log"));		
	
	}	
	

	//usuwanie
	public function usun(){

		$id_tab=konf::get()->getZmienna('id_tab','id_tab');	
		
		if(!empty($id_tab)&&is_array($id_tab)){	
	  
		  $query=tekstForm::tabQuery($id_tab);
		  
		  if(!empty($query)){
			
		    $zap=konf::get()->_bazasql->zap("SELECT id,img,img_nazwa FROM ".konf::get()->getKonfigTab("sql_tab",'rotator')." WHERE id IN (".$query.")");
				
		    while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
					if(!empty($dane['img'])){
						$pliczek=konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("rotator_konf",'kat').$dane['img_nazwa'];
		  	    if(file_exists($pliczek)){
		  				unlink($pliczek); 
		  			}
					}
		    }    
				konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'rotator')." WHERE id IN (".$query.")");
				user::get()->zapiszLog(konf::get()->langTexty("rot_usuna_log"),user::get()->login());	
		    konf::get()->setKomunikat(konf::get()->langTexty("usuwanie"),"");   
			}
		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("usuwaniebrak"),"error"); 		
		}
		
	}

	
	/**
   * class constructor php5	
   */	
	public function __construct() {	
	
		$this->_admin=konf::get()->getKonfigTab("rotator_konf",'admin_rotator');

  }	

		
}

?>