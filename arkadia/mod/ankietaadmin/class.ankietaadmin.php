<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

class ankietaadmin extends moduladmin {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="ankietaadmin class";

	/**
   * data stat
   */		
	public function staty(){

		echo tab_nagl(konf::get()->langTexty("ankieta_stat"),2);
		
		echo "<tr><td colspan=\"2\" class=\"tlo4 grube\">".konf::get()->langTexty("ankieta_stat_ogolne")."</td></tr>";	
		
		echo "<tr class=\"prawa grube\"><td class=\"tlo4\">".konf::get()->langTexty("ankieta_stat_nazwa")."</td>";
		echo "<td class=\"tlo4\" style=\"width:70px\">".konf::get()->langTexty("ankieta_stat_ilosc")."</td></tr>";		
		
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">".konf::get()->langTexty("ankieta_stat_iosca")."</td>";		
		echo "<td class=\"tlo4 prawa\">".konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab","ankieta")." WHERE lang='".konf::get()->getLang()."'")."</td>";	
		echo "</tr>";		
		
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">".konf::get()->langTexty("ankieta_stat_iloscp")."</td>";		
		echo "<td class=\"tlo4 prawa\">".konf::get()->_bazasql->policz("aa.id"," FROM ".konf::get()->getKonfigTab("sql_tab","ankieta_list")." aa, ".konf::get()->getKonfigTab("sql_tab","ankieta")." a WHERE a.id=aa.id_matka AND a.lang='".konf::get()->getLang()."'")."</td>";				
		echo "</tr>";	
		
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">".konf::get()->langTexty("ankieta_stat_iloscgz")."</td>";		
		echo "<td class=\"tlo4 prawa\">".konf::get()->_bazasql->policz("aa.id"," FROM ".konf::get()->getKonfigTab("sql_tab","ankieta_glosy")." aa, ".konf::get()->getKonfigTab("sql_tab","ankieta")." a WHERE a.id=aa.id_matka AND a.logowane=1 AND a.lang='".konf::get()->getLang()."'")."</td>";				
		echo "</tr>";		
			
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">".konf::get()->langTexty("ankieta_stat_sumaodp")."</td>";		
		$dane=konf::get()->_bazasql->pobierzRekord("SELECT SUM(aa.glosy) AS ile FROM ".konf::get()->getKonfigTab("sql_tab","ankieta_list")." aa, ".konf::get()->getKonfigTab("sql_tab","ankieta")." a WHERE a.id=aa.id_matka AND a.lang='".konf::get()->getLang()."'");
		echo "<td class=\"tlo4 prawa\">".$dane['ile']."</td>";				
		echo "</tr>";	
			
		$tab=konf::get()->getKonfigTab("ankieta_konf","tab");
		if(!empty($tab)&&is_array($tab)){

			reset($tab);
		  $link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ankietaadmin_arch"));
			
		  echo "<tr><td colspan=\"2\" class=\"tlo4 grube\">".konf::get()->langTexty("ankieta_stat_kategoriea")."</td></tr>";
		  echo "<tr class=\"prawa grube\"><td class=\"tlo4\">".konf::get()->langTexty("ankieta_stat_nazwa")."</td>";
			echo "<td class=\"tlo4\">".konf::get()->langTexty("ankieta_stat_ilosc")."</td></tr>";		
		  while(list($key,$val)=each($tab)){
				echo "<tr class=\"prawa\">";
				echo "<td class=\"tlo3\"><a href=\"".$link."&amp;id_typ=".$key."\">".$val."</a></td>";		
				echo "<td class=\"tlo4 prawa\">".konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab","ankieta")." WHERE id_typ='".$key."' AND lang='".konf::get()->getLang()."'")."</td>";
				echo "</tr>";
			}
		
		}
		
		echo "<tr><td colspan=\"2\" class=\"tlo4 grube\">".konf::get()->langTexty("ankieta_stat_najgl")."</td></tr>";	
		echo "<tr class=\"prawa grube\"><td class=\"tlo4\">".konf::get()->langTexty("ankieta_stat_nazwa")."</td>";
		echo "<td class=\"tlo4\">".konf::get()->langTexty("ankieta_stat_ilosc")."</td></tr>";		
		
		$zap=konf::get()->_bazasql->zap("SELECT SUM(aa.glosy) AS ile, a.* FROM ".konf::get()->getKonfigTab("sql_tab","ankieta_list")." aa, ".konf::get()->getKonfigTab("sql_tab","ankieta")." a WHERE a.id=aa.id_matka AND a.lang='".konf::get()->getLang()."' GROUP BY a.id ORDER BY ile DESC LIMIT 0,10");
		
	  $link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ankietaadmin_edytuj"));
		while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
			if($dane['ile']>0){
				echo "<tr class=\"prawa\">";
				echo "<td class=\"tlo3\"><a href=\"".$link."&amp;id_nr=".$dane['id']."\">".$dane['tytul']."</a></td>";
				echo "<td class=\"tlo4 prawa\">".$dane['ile']."</td>";			
				echo "</tr>";	
			}
		}	
		$dane=konf::get()->_bazasql->freeResult($zap);
		
		echo tab_stop();
		
	}


	/**
   * data types
   */	
	public function typy(){

		$colspan=2;

		echo tab_nagl(konf::get()->langTexty("ankieta_arch_typy"),$colspan);
		echo "<tr>";		
		echo "<td class=\"tlo4 lewa grube\">".konf::get()->langTexty("ankieta_arch_typy_nazwa")."</td>";
		echo "<td class=\"tlo4 prawa grube\" style=\"width:50px\">".konf::get()->langTexty("ankieta_arch_typy_ilosc")."</td>";
		echo "</tr>";	
		
		$tab=konf::get()->getKonfigTab("ankieta_konf","tab");
		
		if(!empty($tab)&&is_array($tab)){
		
			$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ankietaadmin_arch"));
			while(list($key,$val)=each($tab)){
				echo "<tr>";
				echo interfejs::innyEl("text_list_bullets","<a href=\"".$link."&amp;id_typ=".$key."\">".$val."</a>","tlo3");
				echo "<td class=\"tlo3 prawa\">";
				echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'ankieta')." WHERE id_typ='".tekstForm::doSql($key)."' AND lang='".konf::get()->getLang()."'");
				echo "</td></tr>";
			}
			
			echo "<tr class=\"srodek\"><td colspan=\"".$colspan."\" class=\"tlo4 srodek\">".interfejs::linkEl("text_list_bullets",$link,konf::get()->langTexty("ankieta_arch_typy_wszystkie"))."</td></tr>";

		} else {
			echo interfejs::brak($colspan);
		}
		echo tab_stop();
	}


  /**
   * data arch
   */	
	public function arch(){

		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));		
		$sortuj=tekstForm::doSql(konf::get()->getZmienna('sortuj','sortuj'));
		$id_typ=tekstForm::doSql(konf::get()->getZmienna('id_typ','id_typ'));	
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');		
		$colspan=5;
		$na_str=50;
		
		$tab_sort=array(	
			1=>"data_start",
			2=>"data_start DESC",
			3=>"id", 
			4=>"id DESC", 		
			5=>"tytul", 
			6=>"tytul DESC", 
			7=>"status", 
			8=>"status DESC"
		);
		
		if(empty($tab_sort[$sortuj])){ 
			$sortuj=5;
		}
		
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ankietaadmin_arch","id_typ"=>$id_typ));
		$link3=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ankietaadmin_arch","sortuj"=>$sortuj,"id_typ"=>$id_typ));		
		$link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ankietaadmin_edytuj"));
		
		$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'ankieta')." WHERE lang='".konf::get()->getLang()."' ";
		if(!empty($id_typ)){
			$query.=" AND id_typ='".$id_typ."'";
		}
		
		$naw = new nawig("SELECT COUNT(id) AS ilosc ".$query,$podstrona,$na_str);		
		$naw->naw($link3);
		$podstrona=$naw->getPodstrona();	
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"arch","arch");
		echo $form->spr(array(1=>"akcja"),"","ok=spr_akcjau(document.arch.akcja,'ankietaadmin_usun','".konf::get()->langTexty("czyusun")."');");
		echo $form->getFormp();
		echo $form->przenies(array("sortuj"=>$sortuj,"podstrona"=>$podstrona,"id_typ"=>$id_typ));
		
	  echo tab_nagl(konf::get()->langTexty("ankieta_arch")." (".$naw->getWynikow()."):",$colspan);
		
		$tab=konf::get()->getKonfigTab("ankieta_konf","tab");
	  if(!empty($id_typ)&&!empty($tab[$id_typ])){
	    echo "<tr><td colspan=\"".$colspan."\" class=\"tlo4\">".konf::get()->langTexty("ankieta_arch_kategoria")." <span class=\"grube\">".$tab[$id_typ]."</span></td></tr>";
	  }
		
	   //akcje  			
		$akcje_tab['ankietaadmin_dodaj']=konf::get()->langTexty("adodaj");
		if($naw->getWynikow()>0){		
			$akcje_tab['ankietaadmin_aktyw']=konf::get()->langTexty("aaktyw");
			$akcje_tab['ankietaadmin_deaktyw']=konf::get()->langTexty("adeaktyw");
			$akcje_tab['ankietaadmin_usun']=konf::get()->langTexty("ausun");
		}
		$akcje_tab['ankietaadmin_staty']=konf::get()->langTexty("ankieta_arch_a_stat");
		
	  echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 lewa\">";
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

		echo interfejs::sortEl($link."&amp;sortuj=",3,4,konf::get()->langTexty("ankieta_arch_id"),$sortuj,50);
		echo interfejs::sortEl($link."&amp;sortuj=",5,6,konf::get()->langTexty("ankieta_arch_tytul"),$sortuj);
		echo interfejs::sortEl($link."&amp;sortuj=",1,2,konf::get()->langTexty("ankieta_arch_daty"),$sortuj,100);
		echo interfejs::sortEl($link."&amp;sortuj=",7,8,konf::get()->langTexty("ankieta_arch_status"),$sortuj,100);
		echo interfejs::sortEl("","","","&nbsp;","",90);

		echo "</tr>";

		if($naw->getWynikow()>0){
		
			$zap=konf::get()->_bazasql->zap("SELECT * ".$query." ORDER BY ".$tab_sort[$sortuj].",id LIMIT ".$naw->getStart().",".$naw->getIle());
			
			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
				echo "<tr class=\"srodek\">";
				echo "<td class=\"tlo4 srodek\">";
				echo $form->checkbox("id_tab[]","id_".$dane['id'],$dane['id'],"");	
				echo "<div";
				if($id_nr==$dane['id']){
					echo " class=\"grube\"";
				}
				echo ">".$dane['id']."</div>";			
				echo "</td>";
				
				echo "<td class=\"tlo3 lewa\"><a href=\"".$link2."&amp;id_nr=".$dane['id']."\">".$dane['tytul']."</a>";
				if(empty($id_typ)&&!empty($tab[$dane['id_typ']])){ 
					echo "<div class=\"male\">".$tab[$dane['id_typ']]."</div>"; 
				}	
				echo "</td>";
				
				echo "<td class=\"srodek tlo3 male\">";
				if(tekstForm::niepuste($dane['data_start'])){ 
					echo konf::get()->langTexty("ankieta_arch_od")." <span class=\"male grube\">".substr($dane['data_start'],0,10)."</span><br />"; 
				}
				if(tekstForm::niepuste($dane['data_stop'])){ 
					echo konf::get()->langTexty("ankieta_arch_do")." <span class=\"male grube\">".substr($dane['data_stop'],0,10)."</span><br />"; 
				}
				echo "</td>";
				
				echo "<td class=\"tlo3\">";
	      if($dane['status']==1){ 
					echo konf::get()->langTexty("aktywne"); 
				} else { 
					echo konf::get()->langTexty("nieaktywne"); 
				}
				echo "</td>";
				echo "<td class=\"srodek tlo3\">";
				echo "<table border=\"0\" class=\"srodek\"><tr valign=\"top\">"; 
				echo interfejs::edytuj($link2."&amp;id_nr=".$dane['id']); 						   
				echo interfejs::infoEl($dane);
				echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ankietaadmin_usun","id_typ"=>$id_typ,"id_tab[]"=>$dane['id']))); 			
				echo "</tr></table>"; 				
				echo "</td>";
				echo "</tr>";
				
			}		
			konf::get()->_bazasql->freeResult($zap);		

			if($naw->getNaw()){
				echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
			}

		} else { 
			echo interfejs::brak($colspan);
		}

	  echo "<tr class=\"srodek\"><td colspan=\"".$colspan."\" class=\"tlo4 srodek\">".interfejs::linkEl("text_list_bullets",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ankietaadmin_typy")),konf::get()->langTexty("ankieta_arch_typyankiet"))."</td></tr>";
		
	  echo tab_stop();
		echo $form->getFormk();
	}

	
  /**
   * form record
   */	
	public function rekord($form,$max,$i,$dane){

		$html="<tr class=\"srodek\"><td>";
		
		$html.=$form->input("hidden","ankieta_dane[".$i."]","",$i);			
		if(!empty($dane)){
			$html.=$form->input("hidden","ankieta_dane_id[".$i."]","",$dane['id']);				
		}
		$html.="<select name=\"ankieta_dane_nr_poz[".$i."]\">";
		if(empty($dane)){
			$limit=$i;
		} else {
			$limit=$dane['nr_poz'];
		}
		for($j=1;$j<=$max;$j++){
			$html.="<option value=\"".$j."\" ";
			if($j==$limit){
				$html.=" selected=\"selected\"";
			}
			$html.=">".$j."</option>";
		}
		$html.="</select>";
		$html.="</td>";

		if(!isset($dane['tresc'])){ 
			$dane['tresc']=""; 
		}
		$html.="<td>";
		$html.=$form->input("text","ankieta_dane_tresc[".$i."]","",$dane['tresc'],"f_bdlugi",200);		
		$html.="</td>";
		
		if(empty($dane['glosy'])){ 
			$dane['glosy']=0; 
		}
		$html.="<td>";
		$html.=$form->input("text","ankieta_dane_glosy[".$i."]","",$dane['glosy'],"f_krotki",11,"style=\"text-align:right\"");
		$html.="</td>";
		$html.="</tr>";	
		
		return $html;
		
	}


  /**
   * form
   */		
	protected function formularz(){
	
		$id_typ=tekstForm::doSql(konf::get()->getZmienna('id_typ','id_typ'));			
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));		
		$sortuj=tekstForm::doSql(konf::get()->getZmienna('sortuj','sortuj'));
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
				
		//domyślne wartosci
		$dane=array(
			'tytul'=>"",
			'tresc'=>"",
			'typ'=>1,
			'id_typ'=>$id_typ,
			'status'=>1,
			'logowane'=>0,
			'data_start'=>date("Y-m-d H:i"),
	    'data_stop'=>""
		);
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"ankieta","ankieta");	
		$dane=$form->odczyt($dane);	
		
		if(!empty($id_nr)){
			
			$dane2=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'ankieta')." WHERE id='".$id_nr."' AND lang='".konf::get()->getLang()."'");
			if(!empty($dane2)){
				$dane=$dane2;
			} else {
				$id_nr="";
			}
		}

		if(konf::get()->getAkcja()=="ankietaadmin_dodaj"||!empty($id_nr)){
		
			if(!empty($id_nr)){
		  	echo tab_nagl(konf::get()->langTexty("ankieta_form_edycja"),1);
		  } else {
		  	echo tab_nagl(konf::get()->langTexty("ankieta_form_tworzenie"),1);
		  }
	  	
	  	echo "<tr><td class=\"lewa tlo3\">"; 
			
			echo $form->spr(array(1=>"tytul",2=>"tresc",3=>"id_typ"),"","");
			echo $form->getFormp();
			echo $form->przenies(array(
				"akcja"=>konf::get()->getAkcja()."2",
				"id_nr"=>$id_nr,
				"podstrona"=>$podstrona,
				"sortuj"=>$sortuj
			));
	
			echo "<table border=\"0\"><tr>";    
			if(!empty($id_nr)){		
				echo interfejs::edytuj(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ankietaadmin_edytuj","id_nr"=>$dane['id']))); 				
				echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ankietaadmin_usun","id_typ"=>$dane['id_typ'],"id_tab[]"=>$id_nr))); 
				echo interfejs::infoEl($dane);				
			}
			echo interfejs::przyciskEl("arrow_join",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ankietaadmin_arch","podstrona"=>$podstrona,"sortuj"=>$sortuj,"id_typ"=>$id_typ)),konf::get()->langTexty("ankieta_form_arch"));					
			echo "</tr></table><br />";   
			
			
	    echo "<div>";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");
			echo "</div>";					

			echo "<br /><div>";
			echo interfejs::label("typ_1",konf::get()->langTexty("ankieta_form_typ"),"grube");						
			echo "</div><br />";
			
			echo $form->radioTab(array(
				1=>konf::get()->langTexty("ankieta_form_jedna")." ".interfejs::pomocEl(konf::get()->langTexty("ankieta_admin_form_hjedna")),
				2=>konf::get()->langTexty("ankieta_form_kilka")." ".interfejs::pomocEl(konf::get()->langTexty("ankieta_admin_form_hkilka"))
			),
			$dane['typ'],"typ");	
			echo "<br />";
			
			echo "<div>";
			echo interfejs::label("id_typ",konf::get()->langTexty("ankieta_form_miejsce"),"grube");					
			echo interfejs::pomocEl(konf::get()->langTexty("ankieta_admin_form_hmiejsce"));	
			echo "</div>";	
			
			$tab=konf::get()->getKonfigTab("ankieta_konf","tab");			
			echo $form->select("id_typ","id_typ",$tab,$dane['id_typ'],"f_dlugi");					
			echo "<br /><br />";
			
			echo $form->kalendarz("data_start","trigger_b",$dane['data_start'],true);		
			echo interfejs::label("data_start",konf::get()->langTexty("ankieta_form_wysod"),"grube",true);								
			echo "<br />";
			
			echo $form->kalendarz("data_stop","trigger_c",$dane['data_stop'],true,true);		
			echo interfejs::label("data_stop",konf::get()->langTexty("ankieta_form_wysdo"),"grube",true);								
			echo "<br /><br />";
			
			echo interfejs::label("tytul",konf::get()->langTexty("ankieta_form_tytul"),"grube");				
			echo interfejs::pomocEl(konf::get()->langTexty("ankieta_admin_form_htytul"));		
			echo "<br />";
			echo $form->input("text","tytul","tytul",$dane['tytul'],"f_bdlugi",200);					
			echo "<br /><br />";
			
			echo "<div>";
			echo interfejs::label("tresc",konf::get()->langTexty("ankieta_form_tresc"),"grube");						
			echo "</div>";
			echo $form->textarea("tresc","tresc",$dane['tresc'],"f_bdlugi",10);	
			echo "<br />";

			$i=0;
			
			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\">";
			echo "<tr class=\"srodek grube\"><td style=\"width:50px\">".konf::get()->langTexty("ankieta_form_nr")."</td>";
			echo "<td>".konf::get()->langTexty("ankieta_form_odp")."</td>";
			echo "<td style=\"width:50px\">".konf::get()->langTexty("ankieta_form_punkty")."</td></tr>";
			
			if(!empty($id_nr)){
				$zap3=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'ankieta_list')." WHERE id_matka='".$id_nr."' ORDER BY nr_poz");
				while($dane3=konf::get()->_bazasql->fetchAssoc($zap3)){				
					$i++;
					echo $this->rekord($form,konf::get()->getKonfigTab("ankieta_konf","ile_odp"),$i,$dane3);
				}
				konf::get()->_bazasql->freeResult($zap3);
			}
			
			if($i<konf::get()->getKonfigTab("ankieta_konf","ile_odp")){
				for($j=$i;$j<konf::get()->getKonfigTab("ankieta_konf","ile_odp");$j++){
					$i++;
					echo $this->rekord($form,konf::get()->getKonfigTab("ankieta_konf","ile_odp"),$i,"");
				}
			}
			
			echo "</table>";
			
			echo "<br /><div>";
			echo $form->checkbox("logowane","logowane",1,$dane['logowane']);	
			echo interfejs::label("logowane",konf::get()->langTexty("ankieta_form_tylko"),"nobr",true);							
			echo interfejs::pomocEl(konf::get()->langTexty("ankieta_admin_form_htylko"));				
			echo "</div><br />";
			
			echo "<div>";
			echo $form->checkbox("status","status",1,$dane['status']);		
			echo interfejs::label("status",konf::get()->langTexty("widoczny"),"nobr",true);						
			echo "</div><br />";
			
	    echo "<div>";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");
			echo "</div>";
			
			echo "<br /><span class=\"male\">".konf::get()->langTexty("musza")."</span>";
			
			echo $form->getFormk();
	  	
			echo "</td></tr>";
			
			echo "<tr class=\"srodek\"><td class=\"tlo4\">".interfejs::linkEl("text_list_bullets",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ankietaadmin_arch","podstrona"=>$podstrona,"sortuj"=>$sortuj,"id_typ"=>$id_typ)),konf::get()->langTexty("ankieta_form_arch"))."</td></tr>";	
			
			echo tab_stop();
			
		} else { 
			echo interfejs::nieprawidlowe();	
		}
		
	}
	
	
  /**
   * check data exists
	 * @return bool	
   */		
	public function istnieje($mysql,$tytul,$tresc,$id_typ,$id){

		$ok=true;

		$query=" FROM ".$mysql." WHERE tytul='".$tytul."' AND tresc='".$tresc."' AND id_typ='".$id_typ."' AND lang='".konf::get()->getLang()."'";
		if(!empty($id)){
			$query.=" AND id!='".$id."'";
		}
		
		if(konf::get()->_bazasql->policz("id",$query)>0){
			$ok=false;
		}
		
		return $ok;	
		
	}


  /**
   * save data
   */					
	protected function zapisz(){

		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr'));
		$ankieta_dane=konf::get()->getZmienna('ankieta_dane');
		$ankieta_dane_id=konf::get()->getZmienna('ankieta_dane_id');	
		$ankieta_dane_nr_poz=konf::get()->getZmienna('ankieta_dane_nr_poz');
		$ankieta_dane_tresc=konf::get()->getZmienna('ankieta_dane_tresc');
		$ankieta_dane_glosy=konf::get()->getZmienna('ankieta_dane_glosy');

		//dane podstawowe z formularza
		$dane=array(
			"data_start"=>"",
			"data_stop"=>"",		
			"tytul"=>"",			
			"tresc"=>"",				
			"status"=>"",			
			"logowane"=>"",			
			"id_typ"=>"",			
			"typ"=>""
		);
		
		$tab=konf::get()->getKonfigTab("ankieta_konf","tab");		
		$testy[]=array("zmienna"=>"id_typ","test"=>"wtablicyi",
			"param"=>array(
				"wartosci"=>$tab,
				"domyslny"=>""
			)
		);	
		
		$testy[]=array("zmienna"=>"typ","test"=>"wtablicy",
			"param"=>array(
				"wartosci"=>array(1,2),
				"domyslny"=>1
			)
		);			
		
		$testy[]=array("zmienna"=>"status","test"=>"truefalse");	
		
		$testy[]=array("zmienna"=>"tytul","test"=>"wartosc","wymagany"=>true,
			"param"=>array(
				"komunikat"=>konf::get()->langTexty("ankieta_zap_brak"),
				'idtf'=>"tytul"			
			)	
		);		
		
		$testy[]=array("zmienna"=>"tresc","test"=>"wartosc","wymagany"=>true,
			"param"=>array(
				"komunikat"=>konf::get()->langTexty("ankieta_zap_brak"),
				'idtf'=>"tresc"			
			)	
		);		
		
		$testy[]=array("zmienna"=>"typ","test"=>"wartosc","wymagany"=>true,
			"param"=>array(
				"komunikat"=>konf::get()->langTexty("ankieta_zap_brak"),
				'idtf'=>"typ"			
			)	
		);		
		
		//generator zapytania insert/update
		require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
		$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'ankieta'),$dane);
		$sqldane->daneOdczyt();	
		$sqldane->setAutor(true);	
		$sqldane->setTesty($testy);		
		$sqldane->testuj();	
		
		if($sqldane->ok()){

			if($this->istnieje(konf::get()->getKonfigTab("sql_tab",'ankieta'),$sqldane->getDane('tytul'),$sqldane->getDane('tresc'),$sqldane->getDane('id_typ'),$id_nr)){

				if(!empty($id_nr)){
				
					//budowanie zapytania
					$sqldane->dodajDaneE();							
					$sqldane->dodaj(" WHERE id='".$id_nr."'");	
					
					//wykonujemy
					if($sqldane->getSql()){
						konf::get()->_bazasql->zap($sqldane->getSql());
					}						
					user::get()->zapiszLog(konf::get()->langTexty("ankieta_zap_edycja_log"),user::get()->login());
					
				} else {
				
				 	$sqldane->setDane(array(
						"lang"=>konf::get()->getLang()
					));					

					//budowanie zapytania
					$sqldane->dodajDaneD();							
					
					//wykonujemy
					if($sqldane->getSql()){
						konf::get()->_bazasql->zap($sqldane->getSql());
					}			

					$id_nr=konf::get()->_bazasql->insert_id;
					konf::get()->setZmienna("_post","id_nr",$id_nr);				
					user::get()->zapiszLog(konf::get()->langTexty("ankieta_zap_dodanie_log"),user::get()->login());	
									
				}
				
				if(!empty($id_nr)){
 
				 	konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");
				 
					reset($ankieta_dane);
					while (list($key,$val)=each($ankieta_dane)){
					
						if(empty($ankieta_dane_glosy[$key])){ 
							$ankieta_dane_glosy[$key]=0; 
						}
						
						if(!empty($ankieta_dane_nr_poz[$key])){ 
							$ankieta_dane_nr_poz[$key]=tekstForm::doSql($ankieta_dane_nr_poz[$key]); 
						} else { 
							$ankieta_dane_nr_poz[$key]=0; 
						}
						
						if($ankieta_dane_tresc[$key]!=""){ 
							$ankieta_dane_tresc[$key]=tekstForm::doSql($ankieta_dane_tresc[$key]); 
						} else { 
							$ankieta_dane_tresc[$key]=""; 
						}
						
						if(!empty($ankieta_dane_id[$key])){ 
							$ankieta_dane_id[$key]=tekstForm::doSql($ankieta_dane_id[$key]); 
						} else { 
							$ankieta_dane_id[$key]=""; 
						}
											
						if(empty($ankieta_dane_id[$key])){
							if(!empty($ankieta_dane_nr_poz[$key])&&!empty($ankieta_dane_tresc[$key])){
								konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'ankieta_list')." VALUES(NULL,'".$id_nr."','".$ankieta_dane_nr_poz[$key]."','".$ankieta_dane_glosy[$key]."','".$ankieta_dane_tresc[$key]."')");
							}
						} else {
							if(!empty($ankieta_dane_nr_poz[$key])&&$ankieta_dane_tresc[$key]!=""){
								konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'ankieta_list')." SET nr_poz='".$ankieta_dane_nr_poz[$key]."', glosy='".$ankieta_dane_glosy[$key]."', tresc='".$ankieta_dane_tresc[$key]."' WHERE id='".$ankieta_dane_id[$key]."'");
							} else {
								konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'ankieta_list')." WHERE id='".$ankieta_dane_id[$key]."'");
							}
						}
					}			
				} else { 
					konf::get()->setKomunikat(konf::get()->langTexty("niezapisane"),"error"); 
				}

			} else { 
				konf::get()->setKomunikat(konf::get()->langTexty("istnieje"),"error"); 
			}
		} else { 
			konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
		}

		if(konf::get()->getAkcja()=="ankietaadmin_dodaj2"){
			if(!empty($id_nr)){
				konf::get()->setAkcja("ankietaadmin_arch");				
			} else {
				konf::get()->setAkcja("ankietaadmin_dodaj");				
			}
		} else if(konf::get()->getAkcja()=="ankietaadmin_edytuj2"){	
			konf::get()->setAkcja("ankietaadmin_edytuj");					
		} 
						
	}
	
	
  /**
   * set active
   */			
	public function aktyw(){
	
		$this->zmienparam("status",1,konf::get()->getKonfigTab("sql_tab",'ankieta'),konf::get()->langTexty("ankieta_zap_zmiana_log"));	

	}
	
	
  /**
   * set deactive
   */		
	public function deaktyw(){
		$this->zmienparam("status",0,konf::get()->getKonfigTab("sql_tab",'ankieta'),konf::get()->langTexty("ankieta_zap_zmiana_log"));	
	}	

	
  /**
   * remove data
   */	
	public function usun(){

		$id_tab=konf::get()->getZmienna('id_tab','id_tab');
			
		if(!empty($id_tab)&&is_array($id_tab)){
		
			$query=tekstForm::tabQuery($id_tab);
			
			if(!empty($query)){
				konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'ankieta')." WHERE id IN (".$query.")");
		  	konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'ankieta_list')." WHERE id_matka IN (".$query.")");		
			  konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'ankieta_glosy')." WHERE id_matka IN (".$query.")");					
				user::get()->zapiszLog(konf::get()->langTexty("ankieta_zap_usuwanie_log"),user::get()->login());
			}
			konf::get()->setKomunikat(konf::get()->langTexty("usuwanie"),""); 
			
		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),"error"); 		
		}
		
	}	
	
	
	/**
   * class constructor php5	
   */	
	public function __construct() {	
	
		$this->_admin=konf::get()->getKonfigTab("ankieta_konf",'admin_ankieta');

  }	

}

?>