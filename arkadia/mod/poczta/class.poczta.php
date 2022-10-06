<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

include_once(konf::get()->getKonfigTab('mod_kat')."poczta/konfig_inc.php");

class poczta extends modul {

	/**
	 * Privates variables
	 */

		
	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="poczta class";	
	
	
	/**
	 * get search values
	 */		
	protected $_szuk=array(
		"szuk"=>"",		
		"szuk_typ"=>"",								
		"szuk_status"=>"",			
	);	
		
		
  /**
   * date format
   */	
	private function dataForm($data,$br=false){
	
		$data=substr($data,0,16);
		
		if($br){
			$data=str_replace(" ","<br />",$data);
		}
		
		return $data;
	
	}
	
		
  /**
   * show menu
   */
	public function menu(){	
	
		echo tab_nagl("Poczta");
		echo "<tr><td class=\"tlo3 lewa\" style=\"padding:0px\">";
		
		echo interfejs::linkEl2("email_edit",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"poczta_wiadomosc")),konf::get()->langTexty("poczta_mwiadomosc"));		
		if(konf::get()->getKonfigTab("poczta_konf","menu_nowe")){				
			$ile=konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'poczta')." WHERE typ=1 AND id_odb='".user::get()->id()."' AND systemowa=0 AND status=1");		
		}
		if(empty($ile)){
			echo interfejs::linkEl2("email",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"poczta_odb")),konf::get()->langTexty("poczta_mwodebrane"));
		} else {
			echo interfejs::linkEl2("email",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"poczta_odb")),konf::get()->langTexty("poczta_modebrane")." (".$ile.")","menu_item grube");				
		}
		echo interfejs::linkEl2("email_go",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"poczta_wys")),konf::get()->langTexty("poczta_mwyslane"));	
		
		if(konf::get()->getKonfigTab("poczta_konf","systemowe")){		
			echo interfejs::linkEl2("email",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"poczta_systemowe")),konf::get()->langTexty("poczta_msystemowe")."Wiadomości systemowe");	
		}		
		
		if(konf::get()->getKonfigTab("poczta_konf","kosz")){		
			echo interfejs::linkEl2("bin",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"poczta_kosz")),konf::get()->langTexty("poczta_mkosz")."Kosz");		
		}
				
		echo "</td></tr>";		
		echo tab_stop();
		
		if(konf::get()->isMod('znajomi')){
		
			echo tab_nagl("Znajomi");
			echo "<tr><td class=\"tlo3 lewa\" style=\"padding:0px\">";
			
			echo interfejs::linkEl2("group_add",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_szukaj")),konf::get()->langTexty("poczta_mszukaj"));		
			echo interfejs::linkEl2("group",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_arch")),konf::get()->langTexty("poczta_mlistaz")." (".user::get()->getDane('ile_znajomi').")");
			if(konf::get()->getKonfigTab("u_konf","czarna")){
				echo interfejs::linkEl2("group_delete",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_czarna")),konf::get()->langTexty("poczta_mczarna"));						
			}		
			echo interfejs::linkEl2("email",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_zaproszenia")),konf::get()->langTexty("poczta_mzaproszenia"));				
			
			echo "</td></tr>";				
			echo tab_stop();
				
		}
	
	}
	
	
  /**
   * show  messages	
   */
	private function arch(){
	
		$podstrona=konf::get()->getZmienna("podstrona","podstrona");	
		$sortuj=tekstForm::doSql(konf::get()->getZmienna("sortuj","sortuj"));				
		$na_str=konf::get()->getKonfigTab("poczta_konf",'na_str');
		$statusy_tab=konf::get()->getKonfigTab("poczta_konf",'statusy_tab');		

		$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'poczta')." p ";	
		
		$zdjecia=false;
		
		if(konf::get()->getKonfigTab("poczta_konf","lista_zdjecie")&&konf::get()->getAkcja()!="poczta_usun"){		
			
			$zdjecia=true;			
			
		}

		if(konf::get()->getAkcja()!="poczta_usun"){				
			$query.=" LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u ON ";
			if(konf::get()->getAkcja()!="poczta_wys"){
				$query.=" p.id_autor=u.id ";
			} else {
				$query.=" p.id_odb=u.id ";			
			}

		}
		
		$tab_sort=array(
			1=>"p.id", 2=>"p.id DESC", 
			3=>"p.tytul", 4=>"p.tytul DESC", 
			5=>"p.data_wys, id", 6=>"p.data_wys DESC, p.id DESC", 
			7=>"p.status", 8=>"p.status DESC", 			
		);			
								
		switch(konf::get()->getAkcja()){
		
			case "poczta_wys":
				$query.="WHERE p.id_autor='".user::get()->id()."' AND p.typ=2 AND p.status!=4 ".user::get()->setSqlAdd("u");	
				$tab_sort[9]="p.autor, p.id_autor";
				$tab_sort[10]="p.autor DESC, p.id_autor DESC";		
				$tytul=konf::get()->langTexty("poczta_arch_wyslane");
			break;
			
			case "poczta_kosz":
				$query.="WHERE ((p.id_autor='".user::get()->id()."' AND p.typ=2)||(p.id_odb='".user::get()->id()."' AND p.typ=1)) AND p.status=4";	
				$tab_sort[9]="p.odb, p.id_odb";
				$tab_sort[10]="p.odb DESC, p.id_odb DESC";		
				$tytul="Wiadomości usunięte";										
			break;			
						
			case "poczta_systemowe":
				$query.="WHERE p.id_odb='".user::get()->id()."' AND p.typ=1 AND p.status!=4 AND p.systemowa!=0".user::get()->setSqlAdd("u");	
				$tab_sort[9]="p.odb, p.id_odb";
				$tab_sort[10]="p.odb DESC, p.id_odb DESC";			
				$tytul="Wiadomości systemowe";
			break;						
			
			default:
				$query.="WHERE p.id_odb='".user::get()->id()."' AND p.typ=1 AND p.status!=4 AND p.systemowa=0".user::get()->setSqlAdd("u");					
				$tab_sort[9]="p.odb, p.id_odb";
				$tab_sort[10]="p.odb DESC, p.id_odb DESC";	
				$tytul=konf::get()->langTexty("poczta_arch_odebrane");												
			break;			
		
		}
		
		$link=$this->szukZmienne(1);			
		
		if(konf::get()->getAkcja()!="poczta_kosz"){		
		
		  if(!empty($this->_szuk['szuk_status'])){
		    $query.=" AND p.status='".tekstForm::doSql($this->_szuk['szuk_status'])."'";
		  }			
			
		  if(!empty($this->_szuk['szuk'])){
			
				switch($this->_szuk['szuk_typ']){
				
					case 1:
						if(konf::get()->getAkcja()!="poczta_wys"){
					    $query.=" AND p.odb LIKE '%".tekstForm::doLike($this->_szuk['szuk'])."%'";
						} else {
					    $query.=" AND p.autor LIKE '%".tekstForm::doLike($this->_szuk['szuk'])."%'";						
						}
					break;
					
					case 2:
						$query.=" AND p.tytul LIKE '%".tekstForm::doLike($this->_szuk['szuk'])."%'";
					break;

					case 3:
						$query.=" AND (p.tytul LIKE '%".tekstForm::doLike($this->_szuk['szuk'])."%' OR p.tresc LIKE '%".tekstForm::doLike($this->_szuk['szuk'])."%')";
					break;										
					
				}
				
		  }					
		
		}
		
		if(empty($tab_sort[$sortuj])){ 
			$sortuj=6; 
		}			
		
		$colspan=5;

		$link3=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"poczta_usun","akcja2"=>konf::get()->getAkcja())).$link;		
		$link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane"));				
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>konf::get()->getAkcja())).$link;			
		
		$naw = new nawig("SELECT COUNT(p.id) AS ilosc ".$query,$podstrona,$na_str);		
		$naw->naw($link);
		$podstrona=$naw->getPodstrona();	

		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"arch","arch");
		if(konf::get()->getAkcja()!="poczta_kosz"){				
			echo $form->spr(array(1=>"akcja"),"","ok=spr_akcjau(document.arch.akcja,'poczta_usun','".konf::get()->langTexty("czyusun")."');");
		} else {
			echo $form->spr(array(1=>"akcja"),"","ok=spr_akcjau(document.arch.akcja,'poczta_usunc','".konf::get()->langTexty("czyusun")."');");
		}
		echo $form->getFormp();		
		echo $form->przenies(array("sortuj"=>$sortuj,"podstrona"=>$podstrona,"akcja2"=>konf::get()->getAkcja()));		
		
		echo tab_nagl($tytul." (".$naw->getWynikow()."):",$colspan);	
					
		echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 lewa\">";	
		$akcje_tab['poczta_wiadomosc']="napisz wiadomość";					
					
		if($naw->getWynikow()>0){									
		   //akcje  - zmian statustu tylko dla skrzynki odbiorczej
			if(konf::get()->getAkcja()=="poczta_kosz"){					
				$akcje_tab['poczta_przywroc']="przywróć zaznaczone";				
				$akcje_tab['poczta_usunc']=konf::get()->langTexty("ausun");			
			} else if(konf::get()->getAkcja()=="poczta_wys"){		
				$akcje_tab['poczta_usun']="przenieś do kosza";				
			} else {
				$akcje_tab['poczta_usun']="przenieś do kosza";	
				$akcje_tab['poczta_odpowiedziane']=konf::get()->langTexty("poczta_arch_aodpowiedziane");						
				$akcje_tab['poczta_przeczytane']=konf::get()->langTexty("poczta_arch_aprzeczytane");					
				$akcje_tab['poczta_nieprzeczytane']=konf::get()->langTexty("poczta_arch_anieprzeczytane");					
			}
			
		}
		
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
		
		echo interfejs::sortEl("","","","&nbsp;",$sortuj,40);
		if(konf::get()->getAkcja()=="poczta_wys"){	
			echo interfejs::sortEl($link."&amp;sortuj=",9,10,konf::get()->langTexty("poczta_arch_do"),$sortuj,170);		
		}	else 	if(konf::get()->getAkcja()=="poczta_kosz"){
			echo interfejs::sortEl($link."&amp;sortuj=","","",konf::get()->langTexty("poczta_arch_od"),$sortuj,170);		
		} else {
			echo interfejs::sortEl($link."&amp;sortuj=",9,10,konf::get()->langTexty("poczta_arch_od"),$sortuj,170);			
		}
		echo interfejs::sortEl($link."&amp;sortuj=",3,4,konf::get()->langTexty("poczta_arch_tytul"),$sortuj);	
				
		echo interfejs::sortEl($link."&amp;sortuj=",5,6,konf::get()->langTexty("poczta_arch_data"),$sortuj,110);		
		echo interfejs::sortEl("","","","&nbsp;",$sortuj,33);

		echo "</tr>";		
		
		if($naw->getWynikow()>0){		
	
			if(konf::get()->getAkcja()!="poczta_usun"){	
				$zap=konf::get()->_bazasql->zap("SELECT p.*, u.img3_nazwa, u.img3_w, u.img3_h, u.imie, u.nazwisko, u.login ".$query." ORDER BY ".$tab_sort[$sortuj]." LIMIT ".$naw->getStart().",".$naw->getIle());
			} else {		
				$zap=konf::get()->_bazasql->zap("SELECT p.* ".$query." ORDER BY ".$tab_sort[$sortuj]." LIMIT ".$naw->getStart().",".$naw->getIle());				
			}
			
			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
		  	
		  	echo "<tr class=\"srodek\">";
				echo "<td class=\"tlo4\">";
				echo $form->checkbox("id_tab[]","id_".$dane['id'],$dane['id'],"");
				echo "</td>";

				echo "<td class=\"tlo3\">";
				
				$autor="";
				if($dane['typ']==1){				
					$autor=$dane['autor'];
				} else {
					if(konf::get()->getAkcja()=="poczta_usun"){
						$autor.="ja - ";
					}
					$autor.=$dane['odb'];			
				}		
				
				if(!empty($dane['imie'])||!empty($dane['nazwisko'])||!empty($dane['login'])){
					$autor=user::get()->nazwa($dane);
				}
				
				if($zdjecia){
				
					echo "<div class=\"srodek\">";
					if($dane['typ']==1){				
						echo user::get()->obrazek($dane,$dane['id_autor'],3,$autor,true);			
					} else {
						echo user::get()->obrazek($dane,$dane['id_odb'],3,$autor,true);
					}
					
					echo "</div>";
 			
				
				}
								
				if($dane['typ']==1){				
					echo "<a href=\"".$link2."&amp;id_u=".$dane['id_autor']."\">".tekstForm::wrapWbr($autor,25)."</a>";
				} else {
					echo "<a href=\"".$link2."&amp;id_u=".$dane['id_odb']."\">".tekstForm::wrapWbr($autor,25)."</a>";			
				}
				echo "</td>";
				
				echo "<td class=\"tlo3 lewa\">";	
				echo "<img src=\"grafika/ikony/";
				if($dane['typ']==2){
					echo "email_go";
				} else if($dane['status']!=1&&$dane['status']!=4){
					echo "email_open";
				} else {
					echo "email";
				}
				echo ".gif\" alt=\"\" align=\"left\" style=\"margin-right:5px;\" width=\"16\" height=\"16\" />";						
			
				echo "<a href=\"".$link."&amp;id_nr=".$dane['id']."\"";
				if($dane['status']==1&&$dane['typ']==1){
					echo " class=\"grube\"";			
				}
				echo ">";
				
				$dane['tytul']=tekstForm::zlamStringa($dane['tytul'],30,false,false,false);
				
				echo $dane['tytul'];
				echo "</a>";	
				
				if(konf::get()->getKonfigTab("poczta_konf","tresc_skrot")){
					echo "<div class=\"male\">";
										
					$dane['tresc']=substr(strip_tags($dane['tresc']),0,konf::get()->getKonfigTab("poczta_konf","tresc_skrot"));
					echo $dane['tresc']=tekstForm::zlamStringa($dane['tresc'],30,false,false,false);					
					echo " ...</div>";
				}
				echo "</td>";
				
				echo "<td class=\"tlo3 male\">";
				echo $this->dataForm($dane['data_wys']);
				if(!empty($statusy_tab[$dane['status']])){
					
					if($dane['status']!=1){
						echo "<div>".$statusy_tab[$dane['status']]."</div>";
					}
					//odczytana wiadomosc
					if($dane['status']==2){
						echo "<div>".$this->dataForm($dane['data_odczyt'])."</div>";
					//odpowiedziana wiadomosc
					} else if($dane['status']==3){
						echo "<div>".$this->dataForm($dane['data_odp'])."</div>";				
					//nowa wiadomosc
					} else if($dane['status']==4){
						echo "<div>".$this->dataForm($dane['data_usuniecia'])."</div>";						
					}
				}		
				echo "</td>";				
				
				echo "<td class=\"tlo4\">";
				echo "<table class=\"srodek\" border=\"0\"><tr>"; 			
				echo interfejs::usun($link3."&amp;id_tab[1]=".$dane['id']); 
				echo "</tr></table>";						
				echo "</td>";
				
				echo "</tr>";
				
			}	
			konf::get()->_bazasql->freeResult($zap);		
			
			if($naw->getNaw()){
				echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
			}	
			
		} else {
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 srodek grube\" style=\"padding:10px;\">".konf::get()->langTexty("poczta_arch_brak")."</td></tr>";
		}
		
		echo tab_stop();
		echo $form->getFormk();
		
		if(konf::get()->getAkcja()!="poczta_kosz"){				
		
		  echo tab_nagl(konf::get()->langTexty("wyszukiwarka"),1);
			echo "<tr><td class=\"tlo3\">";
			
			$form2=new formularz("post",konf::get()->getKonfigTab("plik"),"arch2","arch2");
			echo $form2->getFormp();
			echo $form2->przenies(array("akcja"=>konf::get()->getAkcja(),"sortuj"=>$sortuj));	
							
			echo $form2->input("text","szuk","szuk",$this->_szuk['szuk'],"f_dlugi",150);					
			echo " ";
			
			$szuk_typ[2]="tytuł wiadomości";								
			if(konf::get()->getAkcja()=="poczta_wys"){
				$szuk_typ[1]="adresat wiadomości";
			} else {
				$szuk_typ[1]="autor wiadomości";			
			}
			$szuk_typ[3]=" cała wiadomość";		
							
			echo $form2->select("szuk_typ","szuk_typ",$szuk_typ,$this->_szuk['szuk_typ'],"f_dlugi");
			echo " ";
			
			$szuk_status[1]=$statusy_tab[1];
			$szuk_status[2]=$statusy_tab[2];
			$szuk_status[3]=$statusy_tab[3];
							
			echo $form2->select("szuk_status","szuk_status",$szuk_status,$this->_szuk['szuk_status'],"f_dlugi","--status dowolny--");
			echo " ";						
			echo $form2->input("submit","","",konf::get()->langTexty("szukaj"),"formularz2 f_sredni");		
			echo $form2->getFormk();
			
			echo "</td></tr>";	
			echo tab_stop();		
			
		}		

	}
	
	
  /**
   * show concrete message
   * @param int $id_nr
   */
	private function zobacz($id_nr){	
	
		$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'poczta')." p WHERE p.id='".$id_nr."' AND ((p.id_autor='".user::get()->id()."' AND p.typ=2)||(p.id_odb='".user::get()->id()."' AND p.typ=1))");
		
		if(!empty($dane)){
		
			//powoduje zapisanie u nadawcy ze wiadomosc odczytano
			if($dane['typ']==1&&$dane['status']==1&&!empty($dane['id_wys'])){
				konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'poczta')." SET status=2, data_odczyt=NOW() WHERE id='".$dane['id_wys']."' AND id_autor='".$dane['id_autor']."' AND status=1 AND typ=2");
			}		
		
			if($dane['typ']==2){
				echo tab_nagl(konf::get()->langTexty("poczta_z_wyslana"));
				$dane_u=konf::get()->_bazasql->pobierzRekord("SELECT u.* FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u WHERE u.id='".$dane['id_odb']."'".user::get()->getSqlAdd("u"));
			} else {	
				echo tab_nagl(konf::get()->langTexty("poczta_z_odebrana"));		
				$dane_u=konf::get()->_bazasql->pobierzRekord("SELECT u.* FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u WHERE u.id='".$dane['id_autor']."'".user::get()->getSqlAdd("u"));
			}			
		
			echo "<tr><td class=\"tlo3\">";
			
			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"seta\"><tr valign=\"top\">";
			
			echo "<td class=\"srodek\" style=\"width:25%; padding-right:5px;\">";
			if(!empty($dane_u)){
				u_wizytowka($dane_u,true,true);
			} else {
				echo "<div class=\"srodek grube\">".konf::get()->langTexty("poczta_z_niedostepny")."</div>";
			}
			echo "</td>";
	
			echo "<td class=\"lewa\">";
					
			echo "<div style=\"padding-bottom:5px;\"><span class=\"male\">".konf::get()->langTexty("poczta_z_data")." </span>";
			echo "<span class=\"grube\">".$this->dataForm($dane['data_wys'])."</span>";
			echo "</div>";
						
			echo "<div style=\"padding-bottom:5px;\"><span class=\"male\">".konf::get()->langTexty("poczta_z_temat")." </span>";
			echo "<span class=\"grube\">".$dane['tytul']."</span>";
			echo "</div>";
			
			echo "<div style=\"padding-top:5px;\">";
			echo tekstform::doWys($dane['tresc']);
			echo "</div>";
			
			echo "</td>";
			echo "</tr></table>";

			echo "<div class=\"prawa\">";			
			echo "<table border=\"0\" cellspacing=\"0\" cellpaddin=\"0\" class=\"prawa\"><tr>";
			
			if($dane['typ']==1){				
				
				echo "<td class=\"prawa\" style=\"padding-right:40px;\">";
				echo "<script type=\"text/javascript\">\n";				
				echo "function cytuj(){\n";
				$tresc="";
		    $tresc.=str_replace("\n","\n> ",$dane['tresc']);
		    $tresc=strip_tags("> dnia: ".substr($dane['data_wys'],0,10)." godz. ".substr($dane['data_wys'],11,5)." ".$dane['autor']." \n> ".$tresc);
				echo "cytatpole=document.getElementById('tresc');\n";
				echo "cytatwartosc=document.getElementById('cytattr');\n";				
				echo "if(cytatwartosc.value&&cytatpole!=null){\n";
				echo "cytatpole.value=cytatwartosc.value;\n";
				echo "cytatwartosc.value='';\n";		
				echo "}\n";
				echo "}\n";
				echo "</script>\n";
				$form=new formularz("post",konf::get()->getKonfigTab("plik"),"wiadomoscc","wiadomoscc");
				echo $form->getFormp();	
				echo $form->input("hidden","cytattr","cytattr",$tresc);						
				echo $form->input("button","","","cytuj","formularz2 f_sredni",""," onclick=\"cytuj();\"");			
				echo $form->getFormk();					
				echo "</td>";		
				
			}			

			echo "<td class=\"prawa\">";
			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"wiadomoscu","wiadomoscu");
			echo $form->spr(array(1=>"akcja"),"","ok=spr_akcjau(document.wiadomoscu.akcja,'poczta_usun','".konf::get()->langTexty("czyusun")."');");			
			echo $form->getFormp();	
						
			if($dane['typ']==2){
				$form->setPrzenies(array("akcja"=>"poczta_usun","akcja2"=>"poczta_wys"));	
			} else {
				$form->setPrzenies(array("akcja"=>"poczta_usun","akcja2"=>"poczta_odb"));
			}
	
			echo $form->przenies(array("id_tab[]"=>$id_nr));		
			echo $form->input("submit","","",konf::get()->langTexty("poczta_z_usunw"),"formularz2");			
			echo $form->getFormk();					
			echo "</td>";		
						
			echo "</tr></table>";
			echo "</div>";
			
			echo "</td></tr>";
			
			if($dane['typ']==1){			
				echo "<tr><td class=\"tlo4 srodek\">".interfejs::linkEl("email",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"poczta_odb")),konf::get()->langTexty("poczta_z_listaw"))."</td></tr>";
			} else {
				echo "<tr><td class=\"tlo4 srodek\">".interfejs::linkEl("email",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"poczta_wys")),konf::get()->langTexty("poczta_z_listaw"))."</td></tr>";			
			}
			
			echo tab_stop();

			//szybki formularz odpowiedzi
			if($dane['typ']==1){
				$dane['tresc']="";
				$this->formularz($dane_u['id'],$dane_u,$dane,konf::get()->langTexty("poczta_z_odp"));
				
			}		
			
		}			
	
	}
	
	
  /**
   * outgoing messages list first action
   */
	public function wys(){

		//uzywane tylko do przekierowania
		
	}
	
	
  /**
   * outgoing messages
   */
	public function wys2(){
		
		//zmiana nazwy akcji - nazwa akcji jest potem uzywana jako warunek
		if(konf::get()->getAkcja()=="poczta_wys2"){
			konf::get()->setAkcja("poczta_wys");
		}

		$id_nr=konf::get()->getZmienna('id_nr','id_nr');	
	
		//wyswietl wiadomosc lub liste wiadomosci	
		if(empty($id_nr)){
			$this->arch();
		} else {
			$this->zobacz($id_nr);		
		}
		
	}	
	
	
  /**
   * incoming messages first action
   */
	public function odb(){
	
		//zmiana statusu odczytania wiadomosci zanim wyswietli sie menu z lista wiadomosci
		$id_nr=konf::get()->getZmienna('id_nr','id_nr');	
	
		if(!empty($id_nr)){
			konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'poczta')." SET status=2, data_odczyt=NOW() WHERE id='".$id_nr."' AND id_odb='".user::get()->id()."' AND status=1");	
		}
		
	}
	

  /**
   * incoming messages 
   */
	public function odb2(){
		
		//zmiana nazwy akcji - nazwa akcji jest potme uzywana jako warunek		
		if(konf::get()->getAkcja()=="poczta_odb2"){
			konf::get()->setAkcja("poczta_odb");
		}		
	
		$id_nr=konf::get()->getZmienna('id_nr','id_nr');	
	
		//wyswietl wiadomosc lub liste wiadomosci
		if(empty($id_nr)){
			$this->arch();
		} else {
			$this->zobacz($id_nr);		
		}
		
	}	
	
	
  /**
   * outgoing messages list first action
   */
	public function kosz(){

		//uzywane tylko do przekierowania
		
	}
	
	
  /**
   * outgoing messages
   */
	public function kosz2(){
		
		//zmiana nazwy akcji - nazwa akcji jest potem uzywana jako warunek
		if(konf::get()->getAkcja()=="poczta_kosz2"){
			konf::get()->setAkcja("poczta_kosz");
		}

		$id_nr=konf::get()->getZmienna('id_nr','id_nr');	
	
		//wyswietl wiadomosc lub liste wiadomosci	
		if(empty($id_nr)){
			$this->arch();
		} else {
			$this->zobacz($id_nr);		
		}
		
	}	
	
	
  /**
   * outgoing messages list first action
   */
	public function systemowe(){

		//uzywane tylko do przekierowania
		
	}
	
	
  /**
   * outgoing messages
   */
	public function systemowe2(){
		
		//zmiana nazwy akcji - nazwa akcji jest potem uzywana jako warunek
		if(konf::get()->getAkcja()=="poczta_systemowe2"){
			konf::get()->setAkcja("poczta_systemowe");
		}

		$id_nr=konf::get()->getZmienna('id_nr','id_nr');	
	
		//wyswietl wiadomosc lub liste wiadomosci	
		if(empty($id_nr)){
			$this->arch();
		} else {
			$this->zobacz($id_nr);		
		}
		
	}		
		
  /**
   * new message	
   */
	public function wiadomosc(){
	
		$id_u=tekstForm::doSql(konf::get()->getZmienna('id_u','id_u'));	
		
		if(!empty($id_u)){	
			$dane_u=konf::get()->_bazasql->pobierzRekord("SELECT u.* FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u WHERE u.id='".$id_u."'".user::get()->getSqlAdd("u"));
		} else {
			$dane_u=array();
		}

		$this->formularz($id_u,$dane_u,"","Napisz wiadomość");		

	}	
	
	
  /**
   * new message	
   */
	public function wiadomosca(){
	
		$this->formularz("","","","Napisz wiadomość do wszystkich znajomych");		

	}		
	

  /**
   * new message
   * @param int $id_u - message to
   * @param array $dane_u - user data
   * @param array $dane - replay message
   * @param string $nagl - form title
   */	
	private function formularz($id_u="",$dane_u="",$dane="",$nagl=""){
	
		$id_tab=tekstForm::doSql(konf::get()->getZmienna('id_tab','id_tab'));	
		$ile=0;
		if(!empty($id_tab)&&is_array($id_tab)){
			$ile=count($id_tab);
		} else if(konf::get()->getAkcja()=="poczta_wiadomosca"){
			$ile=user::get()->getDane('ile_znajomi');
		}
		
		
		$tresc="";		
		$tytul="";
		
		if(!empty($dane)){
		
			if(tekstForm::utf8Substr($dane['tytul'],0,3)=="Re:"){
				$tytul=$dane['tytul'];
			} else {
				$tytul="Re: ".$dane['tytul'];
			}		
				
			if(!empty($dane['tresc'])){
		    $tresc=str_replace("\r\n","\r\n> ",$dane['tresc']);
		    $tresc="dnia: ".substr($dane['data_wys'],0,10)." godz. ".substr($dane['data_wys'],11,5)." ".$dane['autor']." \r\n> ".$tresc;		
			}
			
		}

		echo tab_nagl($nagl);
		
		if(!empty($id_u)){		
			$ile=1;		
		}
		
		if((empty($dane_u)&&!empty($id_u))||(empty($ile)&&(!empty($id_tab)||konf::get()->getAkcja()=="poczta_wiadomosca"))){
		
			echo "<tr><td class=\"srodek grube error\" style=\"padding:10px\">".konf::get()->langTexty("poczta_f_braka")."</td></tr>";
			
		} else if (!empty($id_u)&&user::get()->jestCzarna($id_u)){
		
			echo "<tr><td class=\"srodek grube error\" style=\"padding:10px\">".konf::get()->langTexty("poczta_f_niezyczy")."</td></tr>";		

		} else {
		
			echo "<tr><td class=\"tlo3\">";
			
			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"wiadomosc","wiadomosc");
			echo $form->spr(array(1=>"id_u",2=>"tytul",3=>"tresc"),"","");
			echo $form->getFormp();	
			if(konf::get()->getAkcja()=="poczta_wiadomosca"){
				$przenies['akcja']="poczta_wiadomosca2";
			} else {
				$przenies['akcja']="poczta_wiadomosc2";			
			}
			if(!empty($dane['id'])){
				$przenies['id_nr']=$dane['id'];			
			}					
			if(!empty($dane_u)){
				$przenies['id_u']=$dane_u['id'];			
			}					
			echo $form->przenies($przenies);	
			
			
			if(!empty($id_tab)||konf::get()->getAkcja()=="poczta_wiadomosca"){
			
			  echo "<br /><div class=\"grube\">Wiadomość do grupy adresatów (".$ile.")</div>";
				if(!empty($id_tab)){
					
					while(list($key,$val)=each($id_tab)){
						echo $form->input("hidden","id_tab[]","id_tab_".$key,$val);
					}
				
				}
				
			
			} else if(empty($id_u)){
			
			  echo "<br /><div>";
				echo interfejs::label("id_u",konf::get()->langTexty("poczta_f_adresat"),"grube");
				echo "</div>";					

				if(konf::get()->getKonfigTab("poczta_konf",'adresatajax')){

					konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/jquery/autocomplete.js","js");				
					konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."css/autocomplete.css","css");						
									
					echo $form->input("text","uzytkownik","uzytkownik","","f_bdlugi",200," onfocus=\"field_clear('uzytkownik',uzytkowniko,true);\" onblur=\"field_clear('uzytkownik',uzytkowniko,false);\"");				
					echo $form->input("hidden","id_u","id_u","");			
					echo "<div class=\"male\">Wpisz imię i nazwisko znajomego ze swoich kontaktów.</div>";
					
					?><script type="text/javascript">			
					$(document).ready(function() {					
						uzytkowniko='';
						$("#uzytkownik").autocomplete("<?php echo konf::get()->getKonfigTab('sciezka'); ?>ajax.php?akcja=poczta_kontakty",{cacheLength:10,matchContains:1, onItemSelect:selectItem, formatItem:formatItem});
					});
					</script><?php		
					
				} else {					
				
					$znajomi_tab=user::get()->znajomi();
					$adresaci_tab=array();
					while(list($key,$val)=each($znajomi_tab)){
						$adresaci_tab[$key]=user::get()->nazwa($val);
						if(!empty($val['miejscowosc'])){
							$adresaci_tab[$key].="(".$val['miejscowosc'].")";
						}
					}
					
					echo $form->select("id_u","id_u",$adresaci_tab,"","f_bdlugi",konf::get()->langTexty("wybierz"));		
					
				}				

			} else {
			
			  echo "<div>".konf::get()->langTexty("poczta_f_adresat")." ";
				echo "<a class=\"grube\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane","id_u"=>$id_u))."\">";
				echo user::get()->nazwa($dane_u);
				echo "</a></div>";
			}
			
			echo "<br /><br />";						
			
		  echo "<div>";
			echo interfejs::label("tytul",konf::get()->langTexty("poczta_f_tytul"),"grube");					
			echo "</div>";
			
			echo $form->input("text","tytul","tytul",$tytul,"f_bdlugi",200);		
			echo "<br /><br />";			
			
		  echo "<div>";
			echo interfejs::label("tresc",konf::get()->langTexty("poczta_f_tresc"),"grube");					
			echo "</div>";

			echo $form->textarea("tresc","tresc",$tresc,"f_bdlugi",20);					
				
		  echo "<br />";
			echo $form->input("submit","","",konf::get()->langTexty("poczta_f_wyslij"),"formularz2 f_krotki");		
			echo "<br />";
			
		  echo "<div class=\"male\">".konf::get()->langTexty("musza")."</div>";			
			echo $form->getFormk();					
					
			echo "</td></tr>";
			
		}		
		
		echo "<tr><td class=\"tlo4 srodek\">".interfejs::linkEl("email",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"poczta_wys")),konf::get()->langTexty("poczta_f_wyslane"))."</td></tr>";
		
		echo tab_stop();
		
	
	}
	
  /**
   * send message
   */		
	public function wiadomosc2(){
	
		$id_u=tekstForm::doSql(konf::get()->getZmienna('id_u','id_u'));	
		$id_tab=tekstForm::doSql(konf::get()->getZmienna('id_tab','id_tab'));		
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));			
		$tytul=tekstForm::doSql(konf::get()->getZmienna('tytul','tytul'));		
		$tresc=tekstForm::doSql(konf::get()->getZmienna('tresc','tresc'));	
		
		$ok=true;		
		
		//pobierz dane adresata
		if(!empty($id_u)){
		
			$dane_u=konf::get()->_bazasql->pobierzRekord("SELECT u.* FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u WHERE u.id='".$id_u."'".user::get()->getSqlAdd("u"));
				
			if(empty($dane_u)){
				$id_u="";
				$ok=false;
				konf::get()->setKomunikat(konf::get()->langTexty("poczta_wys_braka"),"error"); 								
			}	else {
				$dane_tab[$id_u]=$dane_u;
			}	
			
			//sprawdz czy nadawca nie jest na czarnej liscie adresata
			if($ok&&user::get()->jestCzarna($id_u)){
				$ok=false;
				konf::get()->setKomunikat(konf::get()->langTexty("poczta_wys_niezyczy"),"error"); 				
			}
								
			if($ok&&$tytul==''){
				$ok=false;
				konf::get()->setKomunikat(konf::get()->langTexty("poczta_wys_braktyt"),"error"); 				
			}
			
			if($ok&&$tresc==''){
				$ok=false;
				konf::get()->setKomunikat(konf::get()->langTexty("poczta_wys_braktresc"),"error"); 				
			}		
			
		} else if(!empty($id_tab)||konf::get()->getAkcja()=="poczta_wiadomosca2"){
		
			//wybrani adresaci z kontaktow
			if(!empty($id_tab)){
						
		  	$query=tekstForm::tabQuery($id_tab);
				if(!empty($query)){							
					$dane_tab=konf::get()->_bazasql->pobierzRekordy("SELECT u.* FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u, ".konf::get()->getKonfigTab("sql_tab",'znajomi')." z WHERE u.id=z.id_gosc AND z.id_u='".user::get()->getId()."' AND z.id_gosc IN(".$query.") ".user::get()->getSqlAdd("u"),"id");
				}
			
			//wszyscy z listy kontaktow
			} else {
				$dane_tab=konf::get()->_bazasql->pobierzRekordy("SELECT u.* FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u, ".konf::get()->getKonfigTab("sql_tab",'znajomi')." z WHERE u.id=z.id_gosc AND z.id_u='".user::get()->id()."' ".user::get()->getSqlAdd("u"),"id");
			}
			
			if(empty($dane_tab)){
				$ok=false;
				konf::get()->setKomunikat(konf::get()->langTexty("poczta_wys_braka"),"error"); 			
			}
							
		} else {
			$ok=false;
			konf::get()->setKomunikat(konf::get()->langTexty("poczta_wys_braka"),"error"); 				
		}
		
		if($ok){
		
			$ile=count($dane_tab);		
			$data=date("Y-m-d H:i:s");
			$wys=user::get()->nazwa();
			$wys=tekstForm::doSql($wys);			
			$wyslane_ok=0;
			$wyslane_blad=0;
			$komunikat="";

			reset($dane_tab);		
			while(list($key,$dane_u)=each($dane_tab)){
		
				//sprawdz czy juz ta wiadomosc nie byla wyslana
				if(!$this->istnieje($tytul,$tresc,$dane_u['id'])){		
				
					$odb=user::get()->nazwa($dane_u);
					$odb=tekstForm::doSql($odb);

					//zapisz w wyslanych nadawcy
		      konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'poczta')." (id_autor,autor,id_odb,odb,tytul,tresc,data_wys,status,id_odp,typ) VALUES('".user::get()->id()."','".$wys."','".$dane_u['id']."','".$odb."','".$tytul."','".$tresc."','".$data."',1,'".$id_nr."',2)");
					$id_w=konf::get()->_bazasql->insert_id;
					
					if(!empty($id_w)){
					
						//zapisz w odebranych adresata wraz z id wyslanych nadawcy
			      konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'poczta')." (id_autor,autor,id_odb,odb,tytul,tresc,data_wys,status,id_wys,typ) VALUES('".user::get()->id()."','".$wys."','".$dane_u['id']."','".$odb."','".$tytul."','".$tresc."','".$data."',1,'".$id_w."',1)");
						$id_w2=konf::get()->_bazasql->insert_id;				
						
						if(!empty($id_w2)){
						
							$this->powiadomienie($dane_u,$id_w2);

							//zaznacz u nadawcy ze odpowiedziana wiadomosc								
							if(!empty($id_nr)){
								$dane=konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'poczta')." set data_odp='".$data."', id_odp='".$id_nr."', status=3 WHERE id='".$id_nr."' AND id_odb='".user::get()->id()."' AND typ=1");
							}
						
					 		$wyslane_ok++; 	
							$komunikat=konf::get()->langTexty("poczta_wys_wyslana");							
							
						} else {
					 		$wyslane_blad++; 																						
							$komunikat=konf::get()->langTexty("poczta_wys_blad"); 				
						}						
						
					} else {
					 	$wyslane_blad++; 							
						$komunukat=konf::get()->langTexty("poczta_wys_blad"); 				
					}
					
	 			} else {
					$wyslane_blad++; 						
					$komunikat=konf::get()->langTexty("poczta_wys_byla"); 					
				}		
				
			}	
			
			//jesli tylko jeden odbiorca
			if($ile==1){
				if($wyslane_blad){
					konf::get()->setKomunikat($komunikat,"error"); 		
				} else {
					konf::get()->setKomunikat($komunikat); 						
				}
				
			//wysylanie do grupy
			} else {
			
				konf::get()->setKomunikat("Wybranych adresatów: ".$ile,"error");							
				if($wyslane_ok){
					konf::get()->setKomunikat("Wysłanych prawidłowo wiadomości: ".$wyslane_ok); 					
				} 
				if($wyslane_blad){
					konf::get()->setKomunikat("Ilość nieprawidłowych lub zablokowanych adresatów: ".$wyslane_blad,"error"); 						
				}
				
			}
								
		
		}
		
	}
	
	
	public function wiadomosca2(){

		$this->wiadomosc2();	
	
	}
	
	
  /**
   * if message exists
   * @param string $tytul
   * @param string $tresc
   * @param int $id_u	
	 * @return bool	
   */		
	private function istnieje($tytul,$tresc,$id_u){
	
		$ok=false;
		
		if(empty($id_u)){
			$id_u=0;
		}
		
		if(konf::get()->_bazasql->policz('id'," FROM ".konf::get()->getKonfigTab("sql_tab",'poczta')." WHERE typ=2 AND id_autor='".user::get()->id()."' AND id_odb='".$id_u."' AND tytul='".$tytul."' AND tresc='".$tresc."'")>0){
			$ok=true;
		}
		
		return $ok;
		
	}	

	
	public function powiadomienie($dane_u,$id_w2=""){
	
		//wyslij powiadomienie email jesli sa w konfiguracji i chce ich odbiorca
		if(konf::get()->getKonfigTab("poczta_konf",'powiadomienie')&&empty($dane_u['wys_niepowiadomienia'])){
		
			$tresc_w="Witaj ".user::get()->nazwa($dane_u)."\n\n";			
			$tresc_w.=konf::get()->langTexty("poczta_email_t1")."\n";
			$tresc_w.="\n";
			$tresc_w.=konf::get()->langTexty("poczta_email_t2")."\n";			
			$tresc_w.="<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("plik"),array("akcja"=>"poczta_odb"),true,false)."\">".konf::get()->zmienneLink(konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("plik"),array("akcja"=>"poczta_odb"),true,false)."</a>\n";
			$tresc_w.="\n";
			$tresc_w.=konf::get()->langTexty("poczta_email_t3")."\n";

			require_once(konf::get()->getKonfigTab('klasy')."class.wyslijemail.php");														
			$wyslij=new wyslijemail(konf::get()->langTexty("poczta_email_tyt"),$tresc_w,$dane_u["email"]);
			$wyslij->setNadawca(konf::get()->getKonfigTab('kontakt_email'),konf::get()->getKonfigTab('kontakt_nadawca'));	
			$wyslij->wykonaj();	
				
		}	
	
	}
	

  /**
   * delete messages
   * @param string $typ
   */		
	public function usun(){
	
		$this->usunw(false);

		$akcja=konf::get()->getZmienna('akcja2','akcja2');		
		if(!empty($akcja)){
			konf::get()->setAkcja($akcja);
		} else {
			konf::get()->setAkcja("poczta_odb");		
		}

		
	}
	
	
  /**
   * delete messages
   * @param string $typ
   */		
	public function usunc(){
	
		$this->usunw(true);
		
	}	
	
	
  /**
   * delete messages
   * @param string $calkowicie
   */		
	private function usunw($calkowicie=false){
	
		if(!konf::get()->getKonfigTab("poczta_konf","kosz")){
			$calkowicie=true;
		}

		$id_tab=konf::get()->getZmienna('id_tab','id_tab');	
		
		if(!empty($id_tab)&&is_array($id_tab)){	
	  
		  $query=tekstForm::tabQuery($id_tab);
		  
		  if(!empty($query)){

				if($calkowicie){
					konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'poczta')." WHERE id IN (".$query.") AND ((id_autor='".user::get()->id()."' AND typ=2) OR (id_odb='".user::get()->id()."' AND typ=1))");
				} else {
					konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'poczta')." SET status=4, data_usuniecia=NOW() WHERE id IN (".$query.") AND ((id_autor='".user::get()->id()."' AND typ=2) OR (id_odb='".user::get()->id()."' AND typ=1))");					
				}
				
				user::get()->zapiszLog(konf::get()->langTexty("poczta_usuwanie"),user::get()->login());	
		    konf::get()->setKomunikat(konf::get()->langTexty("usuwanie"),"");   
				
			}
		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("usuwaniebrak"),""); 		
		}
		
	}	
	

  /**
   * change status incoming messages
   * @param int $status	
   */				
	private function zmienstatus($status=""){

		$id_tab=konf::get()->getZmienna('id_tab','id_tab');	
		
		if(!empty($id_tab)&&is_array($id_tab)&&!empty($status)){		  
		  $query2=tekstForm::tabQuery($id_tab);			
		}
		  
		if(!empty($query2)){

			$query="UPDATE ".konf::get()->getKonfigTab("sql_tab",'poczta')." SET status='".$status."'";
			
			//wyzreuj daty jesli oznaczamy jako nieprzeczytana
			if($status==1){
				$query.=",data_odczyt='', data_odp=''";
			//wyzeruj date odp dla wiadomosci nieodpowiedzianej
			} else if($status==2) {
				$query.=",data_odczyt=NOW(), data_odp=''";
			} else if($status==3){
				$query.=",data_odp=NOW()";				
			}
			
			//ustawiaj tylko dla wlasnej skrzynki odbiorczej i tylko w przypadku zmiany statusu
			$query.=" WHERE id IN (".$query2.") AND typ=1 AND id_odb='".user::get()->id()."' AND status!='".$status."'";
			
			konf::get()->_bazasql->zap($query);			
			user::get()->zapiszLog(konf::get()->langTexty("poczta_zmianastatusu"),user::get()->login());	
	    konf::get()->setKomunikat(konf::get()->langTexty("awykonana"),"");   			

		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("usuwaniebrak"),"error"); 		
		}
		
	}	
	
	
  /**
   *  set status
   */		
	public function odpowiedziane(){
	
		$this->zmienstatus(3);		
		
	}	
	
	
  /**
   * set status
   */		
	public function przeczytane(){
	
		$this->zmienstatus(2);		
		
	}		
		
		
  /**
   * set status
   */		
	public function nieprzeczytane(){
	
		$this->zmienstatus(1);		
		
	}			

  /**
   *  set status
   */		
	public function przywroc(){
	
		$id_tab=konf::get()->getZmienna('id_tab','id_tab');	
		
		if(!empty($id_tab)&&is_array($id_tab)){		  
		  $query=tekstForm::tabQuery($id_tab);			
		}
			
		if(!empty($query)){	
			
			konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'poczta')." SET status=0, data_odczyt='', data_odp='', data_usuniecia='' WHERE id IN (".$query.") AND status=4 AND ((id_odb='".user::get()->id()."' AND typ=1) OR (id_autor='".user::get()->id()."' AND typ=2))");
			user::get()->zapiszLog(konf::get()->langTexty("poczta_przywracania")."poczta - przywracanie z kosza",user::get()->login());	
	    konf::get()->setKomunikat(konf::get()->langTexty("awykonana"),"");
		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),"error"); 		
		}		
		
	}		
	
	public function kontakty(){
	
		$q=tekstForm::doLike(konf::get()->getZmienna('q','q'));	
		
		if(!empty($q)){

			$zap=konf::get()->_bazasql->zap("SELECT u.id, u.login, u.imie, u.nazwisko, u.miejscowosc FROM ".konf::get()->getKonfigTab("sql_tab",'znajomi')." z LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u ON z.id_gosc=u.id WHERE z.id_u='".user::get()->id()."'".user::get()->getSqlAdd("u")." AND (imie LIKE '%".$q."%' OR nazwisko LIKE '%".$q."%' OR login LIKE '%".$q."%')","id");
		
			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
		
				$nazwa=user::get()->nazwa($dane);
				$nazwa=str_replace('|',"/",tekstForm::utf8Substr($nazwa,0,28));
				echo $nazwa."|".$dane['id']."\n";		
							
			}
			
			konf::get()->_bazasql->freeResult($zap);							
		
		} 
	
	}
	
	public function zdefiniowana($dane_u,$tytul,$tresc,$zdefiniowana=0,$typ=1){
		
		$odb=tekstForm::doSql(user::get()->nazwa($dane_u));
		$wys=tekstForm::doSql(user::get()->nazwa());
		$data=date("Y-m-d H:i:s");		
		$id_w2="";
		
		if(!empty($dane_u)&&!empty($tytul)&&!empty($tresc)){

			//zapisz w odebranych adresata
	    konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'poczta')." (id_autor,autor,id_odb,odb,tytul,tresc,data_wys,status,zdefiniowana,typ) VALUES('".user::get()->id()."','".$wys."','".$dane_u['id']."','".$odb."','".tekstForm::doSql($tytul)."','".tekstForm::doSql($tresc,false)."','".$data."',1,".$zdefiniowana.",".$typ.")");
			
			$id_w2=konf::get()->_bazasql->insert_id;				
			
			//wyslij powiadomienie email jesli sa w konfiguracji i chce ich odbiorca
			if(!empty($id_w2)){	
			
				if(empty($dane_u['wys_niepowiadomienia'])){						
			
					require_once(konf::get()->getKonfigTab('klasy')."class.wyslijemail.php");														
					$wyslij=new wyslijemail($tytul,$tresc,$dane_u["email"]);
					$wyslij->setNadawca(konf::get()->getKonfigTab('kontakt_email'),konf::get()->getKonfigTab('kontakt_nadawca'));	
					$wyslij->wykonaj();		
					
				}							
							
			}	
			
		}
		
		return $id_w2;
	
	
	}
	
	/**
   * class constructor php5	
   */	
	public function __construct() {	

  }	

	
}	

?>