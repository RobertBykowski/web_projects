<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

class uadmin extends moduladmin {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="uadmin class";

	
	protected $_szuk=array(
		"szuk_status"=>"",
		"szuk_fraza"=>"",
		"szuk_typ"=>"",		
		"szuk_email"=>"",		
		"szuk_id"=>"",	
		"szuk_datazalod"=>"",			
		"szuk_datazaldo"=>"",								
		"szuk_datalogod"=>"",			
		"szuk_datalogdo"=>"",			
	);
	
	
  /**
   * staty
   */	
	public function staty(){
	
		$this->statpanel();

		echo tab_nagl(konf::get()->langTexty("u_admin_stat"),2);
		
		$query=" WHERE 1".user::get()->getSqlAdd();
		
		echo "<tr><td colspan=\"2\" class=\"tlo4 grube\">".konf::get()->langTexty("u_admin_stat_ogol")."</td></tr>";	
		
		echo "<tr class=\"prawa grube\"><td class=\"tlo4\" style=\"width:80%\">".konf::get()->langTexty("u_admin_stat_nazwa")."</td>";
		echo "<td class=\"tlo4\" style=\"width:20%\">".konf::get()->langTexty("u_admin_stat_ilosc")."</td></tr>";
		
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">".konf::get()->langTexty("u_admin_stat_iloscu")."</td>";		
		echo "<td class=\"tlo4 prawa\">";
		echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy').$query);
		echo "</td>";
		echo "</tr>";		
		
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">".konf::get()->langTexty("u_admin_stat_iloscuupr")."</td>";
		echo "<td class=\"tlo4 prawa\">";
		echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy').$query." AND uprawnienia LIKE '%1%'");
		echo "</td>";
		echo "</tr>";		
		
		if(konf::get()->getKonfigTab("u_konf",'rozs')){
		
			echo "<tr class=\"prawa\">";
			echo "<td class=\"tlo3\">".konf::get()->langTexty("u_admin_stat_m")."</td>";		
			echo "<td class=\"tlo4 prawa\">";
			echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy').$query." AND plec=1");
			echo "</td>";
			echo "</tr>";		
			
			echo "<tr class=\"prawa\">";
			echo "<td class=\"tlo3\">".konf::get()->langTexty("u_admin_stat_k")."</td>";		
			echo "<td class=\"tlo4 prawa\">";
			echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy').$query." AND plec=2");
			echo "</td>";
			echo "</tr>";
			
			echo "<tr class=\"prawa\">";
			echo "<td class=\"tlo3\">".konf::get()->langTexty("u_admin_stat_wlogowan")."</td>";
			$dane=konf::get()->_bazasql->pobierzRekord("SELECT SUM(ile_log) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy').$query);
			echo "<td class=\"tlo4 prawa\">".$dane['ile']."</td>";
			echo "</tr>";		

			
			if(konf::get()->getKonfigTab("u_konf",'punkty')){
				echo "<tr class=\"prawa\">";
				echo "<td class=\"tlo3\">".konf::get()->langTexty("u_admin_stat_sp")."</td>";
				$dane=konf::get()->_bazasql->pobierzRekord("SELECT SUM(punkty) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy').$query);
				echo "<td class=\"tlo4 prawa\">".$dane['ile']."</td>";
				echo "</tr>";		
			}
			
			if(user::get()->adminLogi()){
			
				echo "<tr class=\"prawa\">";
				echo "<td class=\"tlo3\">";
				echo "<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_logiarch"))."\">".konf::get()->langTexty("u_admin_stat_ilelog")."</a>";
				echo "</td>";
				echo "<td class=\"tlo4 prawa\">";
				echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'logi'));
				echo "</td>";
				echo "</tr>";				
			}
			
		}
		
		echo "<tr><td colspan=\"2\" class=\"tlo4 grube\">".konf::get()->langTexty("u_admin_stat_statusy")."</td></tr>";	
		
		echo "<tr class=\"prawa grube\"><td class=\"tlo4\">".konf::get()->langTexty("u_admin_stat_nazwa")."</td>";
		echo "<td class=\"tlo4\">".konf::get()->langTexty("u_admin_stat_ilosc")."</td></tr>";
		
		$zap=konf::get()->_bazasql->zap("SELECT COUNT(id) AS ile, status FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy').$query." GROUP BY status ORDER BY status");
		
		$statusy_tab=konf::get()->getKonfigTab("u_konf",'statusy_tab');
		while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
			if(!empty($statusy_tab[$dane['status']])){
				echo "<tr class=\"prawa\">";
				echo "<td class=\"tlo3\">".konf::get()->langTexty("u_statusy_tab".$dane['status'])."</td>";		
				echo "<td class=\"tlo4 prawa\">".$dane['ile']."</td>";				
				echo "</tr>";	
			}
		}	
		
		konf::get()->_bazasql->freeResult($zap);		

		echo "<tr><td colspan=\"2\" class=\"tlo4 grube\">".konf::get()->langTexty("u_admin_stat_zalozone")."</td></tr>";	
		
		echo "<tr class=\"prawa grube\"><td class=\"tlo4\">".konf::get()->langTexty("u_admin_stat_nazwa")."</td>";
		echo "<td class=\"tlo4\">".konf::get()->langTexty("u_admin_stat_ilosc")."</td></tr>";		
		
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">".konf::get()->langTexty("u_admin_stat_dzis")."</td>";		
		echo "<td class=\"tlo4 prawa\">";
		echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy').$query." AND autor_kiedy>'".date("Y-m-d")." 00:00:01'");
		echo "</td>";				
		echo "</tr>";			
			
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">".konf::get()->langTexty("u_admin_stat_wczoraj")."</td>";		
		echo "<td class=\"tlo4 prawa\">";
		echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy').$query." AND autor_kiedy<'".date("Y-m-d")." 00:00:01' AND autor_kiedy>'".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")))." 00:00:01'");
		echo "</td>";	
		echo "</tr>";			
		
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">".konf::get()->langTexty("u_admin_stat_w7")."</td>";		
		echo "<td class=\"tlo4 prawa\">";
		echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy').$query." AND autor_kiedy>'".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-7,date("Y")))." 00:00:01'");
		echo "</td>";
		echo "</tr>";	
		
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">".konf::get()->langTexty("u_admin_stat_w30")."</td>";		
		echo "<td class=\"tlo4 prawa\">";
		echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy').$query." AND autor_kiedy>'".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y")))." 00:00:01'");
		echo "</td>";
		echo "</tr>";					
		
		
		echo "<tr><td colspan=\"2\" class=\"tlo4 grube\">".konf::get()->langTexty("u_admin_stat_logowania")."</td></tr>";	
		
		echo "<tr class=\"prawa grube\"><td class=\"tlo4\">".konf::get()->langTexty("u_admin_stat_nazwa")."</td>";
		echo "<td class=\"tlo4\">".konf::get()->langTexty("u_admin_stat_ilosc")."</td></tr>";
		
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">".konf::get()->langTexty("u_admin_stat_dzis")."</td>";		
		echo "<td class=\"tlo4 prawa\">";
		echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'logi')." WHERE idtf='log' AND kiedy>'".date("Y-m-d")." 00:00:01'");
		echo "</td>";				
		echo "</tr>";			
			
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">".konf::get()->langTexty("u_admin_stat_wczoraj")."</td>";		
		echo "<td class=\"tlo4 prawa\">";
		echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'logi')." WHERE idtf='log' AND kiedy<'".date("Y-m-d")." 00:00:01' AND kiedy>'".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")))." 00:00:01'");
		echo "</td>";	
		echo "</tr>";		
		
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">".konf::get()->langTexty("u_admin_stat_w7")."</td>";		
		echo "<td class=\"tlo4 prawa\">";
		echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'logi')." WHERE idtf='log' AND kiedy>'".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-7,date("Y")))." 00:00:01'");
		echo "</td>";	
		echo "</tr>";	
		
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">".konf::get()->langTexty("u_admin_stat_w3")."</td>";		
		echo "<td class=\"tlo4 prawa\">";
		echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'logi')." WHERE idtf='log' AND kiedy>'".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-30,date("Y")))." 00:00:01'");
		echo "</td>";	
		echo "</tr>";			

		echo "<tr><td colspan=\"2\" class=\"tlo4 grube\">".konf::get()->langTexty("u_admin_stat_bledne")."</td></tr>";	
		
		echo "<tr class=\"prawa grube\"><td class=\"tlo4\">".konf::get()->langTexty("u_admin_stat_nazwa")."</td>";
		echo "<td class=\"tlo4\">".konf::get()->langTexty("u_admin_stat_ilosc")."</td></tr>";		
		
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">".konf::get()->langTexty("u_admin_stat_dzis")."</td>";		
		echo "<td class=\"tlo4 prawa\">";
		echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'logi')." WHERE idtf='b_log' AND kiedy>'".date("Y-m-d")." 00:00:01'");
		echo "</td>";	
		echo "</tr>";			
			
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">".konf::get()->langTexty("u_admin_stat_wczoraj")."</td>";		
		echo "<td class=\"tlo4 prawa\">";
		echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'logi')." WHERE idtf='b_log' AND kiedy<'".date("Y-m-d")." 00:00:01' AND kiedy>'".date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")))." 00:00:01'");
		echo "</td>";	
		echo "</tr>";			
		
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">".konf::get()->langTexty("u_admin_stat_w7")."</td>";		
		echo "<td class=\"tlo4 prawa\">";
		echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'logi')." WHERE idtf='b_log' AND kiedy>'".tekstForm::dniData(7,"d","-")."'");
		echo"</td>";	
		echo "</tr>";	
		
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">".konf::get()->langTexty("u_admin_stat_w30")."</td>";		
		echo "<td class=\"tlo4 prawa\">";
		echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'logi')." WHERE idtf='b_log' AND kiedy>'".tekstForm::dniData(30,"d","-")."'");
		echo "</td>";
		echo "</tr>";		

		echo tab_stop();
		
	}
	
	
	private function statU($tytul,$query,$order,$count){
	
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');	
		$na_str=50;			
		
		$link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>konf::get()->getAkcja()));		
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane"));
		
		$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE 1 ".user::get()->getSqlAdd()." ".$query;
				
		$naw = new nawig("SELECT COUNT(id) AS ilosc ".$query,$podstrona,$na_str);
		$naw->naw($link2);
		$podstrona=$naw->getPodstrona();		
		
		$this->statpanel();			
				
		echo tab_nagl($tytul,2);		
		
		if($naw->getNaw()){
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
		}			

		echo "<tr class=\"prawa grube\"><td class=\"tlo4\" style=\"width:80%\">".konf::get()->langTexty("u_admin_stat_nazwa")."</td>";
		echo "<td class=\"tlo4\" style=\"width:20%\">".konf::get()->langTexty("u_admin_stat_ilosc")."</td></tr>";

		if($naw->getWynikow()>0){
		
			$zap=konf::get()->_bazasql->zap("SELECT id, login, imie, nazwisko, miejscowosc, ".$count." AS ilosc ".$query." ORDER BY ".$order);	

			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){		

				echo "<tr class=\"prawa\">";
				echo "<td class=\"tlo3\"><a href=\"".$link."&amp;id_u=".$dane['id']."\">".$dane['login']."</a>";
				if(konf::get()->getKonfigTab("u_konf",'rozs')){ 
					echo " ".$dane['imie']." ".$dane['nazwisko'];
					if(!empty($dane['miejscowosc'])){
						echo " (".$dane['miejscowosc'].")";
					}
				}
				echo "</td>";		
				echo "<td class=\"tlo4 prawa\">".$dane['ilosc']."</td>";				
				echo "</tr>";	
				
			}
			
			if($naw->getNaw()){
				echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
			}		
			

			konf::get()->_bazasql->freeResult($zap);						
			
		}	else {
		
			echo interfejs::brak(2);
			
		}

		echo tab_stop();		
	
	}	
	
	
	private function statpanel(){
	
		$table_akcje['uadmin_staty']="ogólna";
		$table_akcje['uadmin_statlog']="logowania";
		
		if(konf::get()->getKonfigTab("u_konf",'punkty')){		
			$table_akcje['uadmin_statpt']="punkty";
		}
		
		if(konf::get()->getKonfigTab("strona_typ")=="sklep"){		
			$table_akcje['uadmin_statilez']="ilość zakupów";		
			$table_akcje['uadmin_statsumaz']="suma zakupów";	
		}
		
		if(konf::get()->isMod("znajomi")){		
			$table_akcje['uadmin_statznajomi']="ilość znajomych";	
		}
									
		echo tab_nagl("");
		echo "<tr class=\"srodek\">";
		
		while(list($key,$val)=each($table_akcje)){
			
			echo "<td class=\"";
			if(konf::get()->getAkcja()==$key){
				echo "tlo4";
			} else {
				echo "tlo3";
			}
			echo "\">";
			echo interfejs::linkEl("table",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>$key)),$val);
			echo "</td>";
	
			
		}
		
		echo "</tr>";
		echo tab_stop();			
		
	}

	
	
	public function statlog(){
	
	
		$this->statU("Statystyka - najczęściej zalogowani użytkownicy","AND ile_log>0"," ile_log DESC, id DESC",'ile_log');
		
	
	}
	
	public function statpt(){
	
		if(konf::get()->getKonfigTab("u_konf",'punkty')){			
			$this->statU("Statystyka - największa ilość punktów","AND punkty>0"," punkty DESC, id DESC",'punkty');
		}
			
	}	
		
		
	public function statilez(){
	
		if(konf::get()->getKonfigTab("strona_typ")=="sklep"){			
			$this->statU("Statystyka - największa ilość zakupów","AND ilosc_zakupy>0"," ilosc_zakupy DESC, id DESC",'ilosc_zakupy');
		}
			
	}	
	
	
	public function statsumaz(){
	
		if(konf::get()->getKonfigTab("strona_typ")=="sklep"){					
			$this->statU("Statystyka - największa suma zakupów","AND suma_zakupy>0"," suma_zakupy DESC, id DESC",'suma_zakupy');
		}
			
	}		
			
			
	public function statznajomi(){
	
		if(konf::get()->isMod("znajomi")){				
			$this->statU("Statystyka - największa ilość znajomych","AND ile_znajomi>0"," ile_znajomi DESC, id DESC",'ile_znajomi');
		}
			
	}					

  /**
   * users list
   */
	public function arch(){
	
		$id_u=konf::get()->getZmienna('id_u','id_u');	
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');	
		$u_sort=konf::get()->getZmienna('u_sort','u_sort');			
		$uprawnienia_tab=konf::get()->getKonfigTab("u_konf",'uprawnienia');	
		$statusy_tab=konf::get()->getKonfigTab("u_konf",'statusy_tab');	
		$typy_tab=konf::get()->getKonfigTab("u_konf",'typy_tab');			
		$statusy_kolory_tab=konf::get()->getKonfigTab("u_konf",'statusy_kolory');		
		$typ=user::get()->getDane("typ");		
		$typy_statusdostepni=konf::get()->getKonfigTab("u_konf",'typystatusydostepni_tab');			
		$statusy_tab2=array();
		$na_str=25;
		
		if(!empty($typy_statusdostepni[$typ])){
		
			while(list($key,$val)=each($typy_statusdostepni[$typ])){
				if(!empty($statusy_tab[$val])){
					$statusy_tab2[$val]=$statusy_tab[$val];
				}
			}
			
		}			
		
		$typy_dostepni=konf::get()->getKonfigTab("u_konf",'typydostepni_tab');			
		$typy_tab2=array();
		
		if(!empty($typy_dostepni[$typ])){
		
			while(list($key,$val)=each($typy_dostepni[$typ])){
				if(!empty($typy_tab[$val])){
					$typy_tab2[$val]=$typy_tab[$val];
				}
			}
			
		}					
			
		$tab_sort=array(
			1=>"id", 2=>"id DESC", 
			3=>"login", 4=>"login DESC", 
			17=>"email", 18=>"email DESC", 			
			5=>"autor_kiedy", 6=>"autor_kiedy DESC", 
			7=>"last_log", 8=>"last_log DESC", 
			9=>"status", 10=>"status DESC", 
			11=>"uprawnienia", 12=>"uprawnienia DESC", 
			19=>"administrator", 20=>"administrator DESC", 			
			13=>"ile_log", 14=>"ile_log DESC", 
			15=>"punkty", 16=>"punkty DESC"
		);
		
		if(empty($tab_sort[$u_sort])){ 
			$u_sort=3; 
		}
		
		if(konf::get()->getKonfigTab("u_konf",'punkty')){ 
			$colspan=9; 
		} else { 
			$colspan=8; 
		}

		$link=$this->szukZmienne(1);
		
		$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE 1 ".user::get()->getSqlAdd();
		
		if(!empty($this->_szuk['szuk_id'])){ 
			$query.=" AND id ='".tekstForm::doSql($this->_szuk['szuk_id'])."'";
		}	
		
		if(!empty($this->_szuk['szuk_typ'])){ 
			$query.=" AND typ='".$this->_szuk['szuk_typ']."'";
		}		
		
		if(!empty($this->_szuk['szuk_status'])){ 
			$query.=" AND status='".tekstForm::doSql($this->_szuk['szuk_status'])."'";
		}
		
		if(!empty($this->_szuk['szuk_datazalod'])){ 
			$query.=" AND autor_kiedy>='".tekstForm::doSql($this->_szuk['szuk_datazalod'])."'";
		}	
		
		if(!empty($this->_szuk['szuk_datazaldo'])){ 
			$query.=" AND autor_kiedy<='".tekstForm::doSql($this->_szuk['szuk_datazaldo'])."'";
		}		
		
		if(!empty($this->_szuk['szuk_datalogod'])){ 
			$query.=" AND last_log>='".tekstForm::doSql($this->_szuk['szuk_datalogod'])."'";
		}	
		
		if(!empty($this->_szuk['szuk_datalogdo'])){ 
			$query.=" AND last_log<='".tekstForm::doSql($this->_szuk['szuk_datalogdo'])."'";
		}					
		
		if(!empty($this->_szuk['szuk_fraza'])){ 
			$query.=" AND login LIKE '%".tekstForm::doLike($this->_szuk['szuk_fraza'])."%'";
		}
		
		if(!empty($this->_szuk['szuk_email'])){ 
			$query.=" AND email LIKE '%".tekstForm::doLike($this->_szuk['szuk_email'])."%'"; 
		}		
	  
		$link2=$link;
		
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_arch")).$link2;		
		$link3=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_zmienupr"));		
		$link4=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_usunu")).$link2;			
		$link5=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_zmienupr")).$link2;			
		$link6=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_logiarch")).$link2;	
		$link7=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_edytuj")).$link2;	
		$link8=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane")).$link2;
		$link9=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"zamowieniaadmin_arch"));
		
		$naw = new nawig("SELECT COUNT(id) AS ilosc ".$query,$podstrona,$na_str);
		$naw->naw($link."&amp;u_sort=".$u_sort);
		$podstrona=$naw->getPodstrona();			

		if($podstrona>1){
			$link2.="&amp;podstrona=".$podstrona;  
		}
		$link2.="&amp;u_sort=".$u_sort; 
		
		$form = new formularz("post",konf::get()->getKonfigTab("plik"),"uarch","uarch");
		
		echo $form->spr(array(1=>"akcja"),"","ok=spr_akcjau(document.uarch.akcja,'uadmin_usunu','".konf::get()->langTexty("czyusun")."');");
		echo $form->getFormp();
		$form->setPrzenies($this->_szuk);
		echo $form->przenies(array(
			"u_sort"=>$u_sort,
			"podstrona"=>$podstrona
		));
		
		if(!empty($typy_tab2)){
			echo tab_nagl("",count($typy_tab2));
			echo "<tr class=\"srodek\">";
			while(list($key,$val)=each($typy_tab2)){
				echo "<td class=\"";
				if($this->_szuk['szuk_typ']==$key){
					echo "tlo3";
				} else {
					echo "tlo4";
				}
				echo "\">";
				echo interfejs::linkEl("group",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>konf::get()->getAkcja(),"szuk_typ"=>$key)),$val);				
				echo "</td>";
			}			
			echo "</tr>";
			echo tab_stop();
		
		}

		if(!empty($typy_tab2[$this->_szuk['szuk_typ']])){
			echo tab_nagl(konf::get()->langTexty("u_admin_arch_lista")." - ".$typy_tab2[$this->_szuk['szuk_typ']]." (".$naw->getWynikow().") :",$colspan);		
		} else {		
			echo tab_nagl(konf::get()->langTexty("u_admin_arch_lista")." (".$naw->getWynikow().") :",$colspan);
		}
		
		echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 lewa\">";
		
	   //akcje  
		$akcje_tab['u_dodaj']=konf::get()->langTexty("adodaj");
		
		if($naw->getWynikow()>0){		
			
			$akcje_tab['uadmin_wiadomosc']=konf::get()->langTexty("u_admin_arch_awyslij");	
			$akcje_tab['uadmin_zmienopis']=konf::get()->langTexty("u_admin_arch_azmineopis");	
			$akcje_tab['uadmin_zmienstatus']=konf::get()->langTexty("u_admin_arch_astatus");	
			$akcje_tab['uadmin_usunu']=konf::get()->langTexty("ausun");
			if(konf::get()->getKonfigTab("u_konf",'punkty')){ 
				$akcje_tab['uadmin_wyzerujpunkty']=konf::get()->langTexty("u_admin_arch_awyzeruj");		
		  }				
			
		}
		
		if(user::get()->adminLogi()){
			$akcje_tab['uadmin_logiarch']=konf::get()->langTexty("u_admin_arch_azobaczl");		
		}		
		if(konf::get()->getKonfigTab("u_konf",'banowanie')){
			$akcje_tab['uadmin_banyarch']=konf::get()->langTexty("u_admin_arch_afiltr");		
		}	
		$akcje_tab['uadmin_staty']=konf::get()->langTexty("u_admin_arch_astat");	
		
		echo $form->selectAkcja($akcje_tab,false);			
		
		echo $form->select("status","status",$statusy_tab2,"","f_dlugi",konf::get()->langTexty("u_admin_arch_statusw"));					
		echo "  ";	
		echo $form->input("submit","","",konf::get()->langTexty("akcjawykonaj"),"formularz2 f_sredni");
		
		echo "</td></tr>";		
		
		if($naw->getWynikow()>0){			
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo4 srodek nobr\">";
			echo $form->zaod("id_tab");
			echo "</td></tr>";	
		}			

		if($naw->getNaw()){
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
		}	
		
		$query="SELECT * ".$query." ORDER BY ".$tab_sort[$u_sort]." LIMIT ".$naw->getStart().",".$naw->getIle();

		echo "<tr class=\"srodek\">";
		
		echo interfejs::sortEl($link."&amp;u_sort=",1,2,konf::get()->langTexty("u_admin_arch_id"),$u_sort,50);
		echo interfejs::sortEl($link."&amp;u_sort=",3,4,konf::get()->langTexty("u_admin_arch_u"),$u_sort);
		echo interfejs::sortEl($link."&amp;u_sort=",17,18,konf::get()->langTexty("u_admin_arch_email"),$u_sort,150);				
		echo interfejs::sortEl($link."&amp;u_sort=",5,6,konf::get()->langTexty("u_admin_arch_datazal"),$u_sort,80);
		echo interfejs::sortEl($link."&amp;u_sort=",7,8,konf::get()->langTexty("u_admin_arch_ostlog"),$u_sort,80);
		echo interfejs::sortEl($link."&amp;u_sort=",9,10,konf::get()->langTexty("u_admin_arch_status"),$u_sort,100);
		echo interfejs::sortEl($link."&amp;u_sort=",11,12,konf::get()->langTexty("u_admin_arch_upr"),$u_sort,40);
		echo interfejs::sortEl($link."&amp;u_sort=",13,14,konf::get()->langTexty("u_admin_arch_log"),$u_sort,40);						
					
		if(konf::get()->getKonfigTab("u_konf",'punkty')){ 
			echo interfejs::sortEl($link."&amp;u_sort=",15,16,konf::get()->langTexty("u_admin_arch_pt"),$u_sort,40);
		}
		echo "</tr>";

		if($naw->getWynikow()>0){
		
			$zap=konf::get()->_bazasql->zap($query);	

			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
			
				echo "<tr><td class=\"tlo4 srodek\">";
				if($dane['id']!=user::get()->id()){
					echo $form->checkbox("id_tab[]","id_".$dane['id'],$dane['id'],"");	
				}
				echo "<div";
				if($dane['id']==$id_u){
					echo " class=\"grube\"";
				}				
				echo "><a href=\"".$link7."&amp;id_u=".$dane['id']."\">".$dane['id']."</a></div></td>";
				
				echo "<td class=\"tlo3\">";
				echo "<a href=\"".$link8."&amp;id_u=".$dane['id']."\">".$dane['login']."</a>";
				if(konf::get()->getKonfigTab("u_konf",'rozs')){
					if(!empty($dane['gg'])){ 
						echo "&nbsp;".tekstForm::gg($dane['gg']); 
					}
					if(!empty($dane['imie'])||!empty($dane['nazwisko'])){ 
						echo " (".$dane['imie']." ".$dane['nazwisko'].")"; 
					}
				}

				echo "<div><table class=\"lewa\" border=\"0\" style=\"margin-top:3px\"><tr>";
				echo interfejs::edytuj($link7."&amp;id_u=".$dane['id']); 				
				echo interfejs::podglad($link8."&amp;id_u=".$dane['id']); 					
				if($dane['id']!=user::get()->id()){	
					echo interfejs::usun($link4."&amp;id_tab[1]=".$dane['id']); 
		 			echo interfejs::przyciskEl("key",$link5."&amp;id_u=".$dane['id'],konf::get()->langTexty("u_admin_arch_upr"));					
					if(user::get()->adminLogi()){		
		 				echo interfejs::przyciskEl("table",$link6."&amp;id_u=".$dane['id'],konf::get()->langTexty("u_admin_arch_logi"));						
					}
				}	
				if(konf::get()->getKonfigTab("strona_typ")=="sklep"){				
		 			echo interfejs::przyciskEl("basket",$link9."&amp;szuk_u=".$dane['id'],"zamówienia");					
				}
				echo interfejs::infoEl($dane);						
				echo "</tr></table></div>";
				echo"</td>";
				
				echo "<td class=\"tlo3 srodek \"><a href=\"mailto:".$dane['email']."\">".$dane['email']."</a></td>";				
				
				echo "<td class=\"tlo3 srodek male\">".str_replace(" ","<br />",$dane['autor_kiedy'])."</td>";
				
				echo "<td class=\"tlo3 srodek male\">";
				if($dane['last_log']!="0000-00-00 00:00:00"){ 
					echo str_replace(" ","<br />",$dane['last_log']); 
				}
				echo "</td><td class=\"tlo3 srodek male\"";
				if(!empty($statusy_kolory_tab[$dane['status']])){
					echo " style=\"background-color:".$statusy_kolory_tab[$dane['status']]."\"";
				}
				echo ">";
				if(!empty($statusy_tab[$dane['status']])){
					echo konf::get()->langTexty("u_statusy_tab".$dane['status']);
				} else {
					echo "&nbsp;";
				}
				echo "</td>";
				
				echo "<td class=\"tlo3 srodek\">";
				if($dane['id']!=user::get()->id()){
					echo"<a class=\"grube\" href=\"".$link5."&amp;id_u=".$dane['id']."\" ";
					if(!(strpos($dane['uprawnienia'],"1")===false)){ 
						echo " onmouseover=\"this.T_TITLE='".konf::get()->langTexty('info')."'; return escape('";
						for($i=0;$i<konf::get()->getKonfigTab("u_konf",'ile_upr');$i++){
							if(substr($dane['uprawnienia'],$i,1)==1&&!empty($uprawnienia_tab[$i]['opis'])){ 
								echo tekstForm::doTooltip(konf::get()->langTexty("u_u".$i)."<br />"); 
							}						 
						}		
						echo "')\"";
					}		
					echo ">";
				}
				if(!(strpos($dane['uprawnienia'],"1")===false)){ 
					echo konf::get()->langTexty("u_admin_arch_tak"); 
				} else { 
					echo konf::get()->langTexty("u_admin_arch_nie"); 
				}
				if($dane['id']!=user::get()->id()){
					echo "</a>";
				}
				echo "</td>";
				
				echo "<td class=\"tlo3 prawa\">";
				if(user::get()->adminLogi()){				
					echo "<a href=\"".$link6."&amp;id_u=".$dane['id']."\">";
				}
				echo $dane['ile_log'];
				if(user::get()->adminLogi()){				
					echo "</a>";
				}
				echo "</td>";
				
				if(konf::get()->getKonfigTab("u_konf",'punkty')){ 
					echo "<td class=\"tlo3 prawa\">";
					echo $dane['punkty'];
					echo "</td>"; 
				}
				
				echo "</tr>";
				
			}
			
			konf::get()->_bazasql->freeResult($zap);					
			
		} else { 
 			echo interfejs::brak($colspan);
		}
		
		if($naw->getNaw()){
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
		}	

		echo tab_stop();
		echo $form->getFormk();

		echo tab_nagl(konf::get()->langTexty("wyszukiwarka"),1);
		echo "<tr><td class=\"tlo3\">";
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"uarch2","uarch2");
		echo $form->getFormp();
		echo $form->przenies(array("u_sort"=>$u_sort,"akcja"=>"uadmin_arch"));
				
		echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\" class=\"prawa\">";
		echo "<tr class=\"nobr\">";
		
		echo "<td class=\"prawa\">&nbsp;&nbsp;&nbsp;";
		echo interfejs::label("szuk_datazalod",konf::get()->langTexty("u_admin_arch_sdatazlaod"));				
		echo " </td>";
		echo "<td class=\"lewa\">";
		echo $form->kalendarz("szuk_datazalod","trigger_a",$this->_szuk['szuk_datazalod'],true,true);	
		echo "</td>";	
		
		echo "<td class=\"prawa\">&nbsp;&nbsp;&nbsp;";
		echo interfejs::label("szuk_datazaldo",konf::get()->langTexty("u_admin_arch_sdo"));					
		echo " </td>";		
		echo "<td class=\"lewa\">";
		echo $form->kalendarz("szuk_datazaldo","trigger_b",$this->_szuk['szuk_datazaldo'],true,true);	
		echo "</td>";	
		
		echo "<td class=\"prawa\">&nbsp;&nbsp;&nbsp;";
		echo interfejs::label("szuk_datalogod",konf::get()->langTexty("u_admin_arch_sdatalogd"));	
		echo " </td>";
		echo "<td class=\"lewa\">";	
		echo $form->kalendarz("szuk_datalogod","trigger_c",$this->_szuk['szuk_datalogod'],true,true);		
		echo "</td>";	
		
		echo "<td class=\"prawa\">&nbsp;&nbsp;&nbsp;";
		echo interfejs::label("szuk_datalogdo",konf::get()->langTexty("u_admin_arch_sdo"));	
		echo " </td>";
		echo "<td class=\"lewa\">";
		echo $form->kalendarz("szuk_datalogdo","trigger_d",$this->_szuk['szuk_datalogdo'],true,true);		
		echo "</td>";			
		
		echo "</tr>";
		echo "</table>";
		
		echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\" class=\"prawa\">";		
		echo "<tr>";
		
		echo "<td class=\"prawa\">";
		echo interfejs::label("szuk_fraza",konf::get()->langTexty("u_admin_arch_sflogin"));		
		echo " </td>";
		echo "<td class=\"lewa\">";
		echo $form->input("text","szuk_fraza","szuk_fraza",$this->_szuk['szuk_fraza'],"f_sredni",50);	
		echo "</td>";	
		
		echo "<td class=\"prawa\">";
		echo interfejs::label("szuk_email",konf::get()->langTexty("u_admin_arch_semail"));				
		echo " </td>";
		echo "<td class=\"lewa\">";
		echo $form->input("text","szuk_email","szuk_email",$this->_szuk['szuk_email'],"f_sredni",50);	
		echo "</td>";				
		
		echo "<td class=\"prawa\">";
		echo interfejs::label("szuk_id",konf::get()->langTexty("u_admin_arch_sid"));			
		echo " </td>";
		echo "<td class=\"lewa\">";
		echo $form->input("text","szuk_id","szuk_id",$this->_szuk['szuk_id'],"f_krotki",50);
		echo "</td>";			
					
		
		echo "<td class=\"prawa\">";
		echo interfejs::label("szuk_status",konf::get()->langTexty("u_admin_arch_sstatus"));		
		echo" </td>";
		echo "<td class=\"lewa\">";					
		echo $form->select("szuk_status","szuk_status",$statusy_tab2,$this->_szuk['szuk_status'],"f_sredni",konf::get()->langTexty("u_admin_arch_statusw"));					
		echo "</td>";	
				
		echo "<td class=\"prawa\">";
		echo interfejs::label("szuk_typ",konf::get()->langTexty("u_admin_arch_styp")."typ: ");			
		echo "</td>";
		echo "<td class=\"lewa\">";					
		echo $form->select("szuk_typ","szuk_typ",$typy_tab2,$this->_szuk['szuk_typ'],"f_dlugi",konf::get()->langTexty("u_admin_arch_typw")."--wybierz typ--");
		echo "</td>";			

		echo "</tr>";		
		echo "</table>";
		
		echo "<div class=\"prawa\">";
		echo $form->input("submit","","",konf::get()->langTexty("szukaj"),"formularz2 f_sredni");		
		echo "</div>";
		
		echo $form->getFormk();
		
		echo "</td></tr>";
		echo tab_stop();

	}


  /**
   * delete users
   */
	public function usunu(){

		$id_tab=konf::get()->getZmienna('id_tab','id_tab');	
		$id_tab2=array();
		
		if(!empty($id_tab)&&is_array($id_tab)){		
		
		  $query=tekstForm::tabQuery($id_tab);
			
		}		
		
		if(!empty($query)){		

		  $zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE id IN (".$query.") AND id!='".user::get()->id()."'".user::get()->getSqlAdd());
							
			require_once(konf::get()->getKonfigTab('klasy')."class.wyslijemail.php");		
							
		  while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
			
				$id_tab2[]=$dane['id'];
			
				if(konf::get()->getKonfigTab("u_konf",'powiadamianie')){
													
					$wyslij=new wyslijemail(konf::get()->getKonfigTab('nazwa_www')." ".konf::get()->langTexty("u_admin_usun_e1"),konf::get()->langTexty("u_admin_param_e2")." ".$dane['login']." ".konf::get()->langTexty("u_admin_usun_e3")." ".konf::get()->getKonfigTab('nazwa_www')." (".konf::get()->getKonfigTab('adres_www').")",$dane['email']);
					$wyslij->setNadawca(konf::get()->getKonfigTab('admin_email'),konf::get()->getKonfigTab('nazwa_www')." (".konf::get()->getKonfigTab('adres_www').")");	
					$wyslij->wykonaj();			
									
				}	
				
				$this->usunImg($dane,konf::get()->getKonfigTab("u_konf",'kat'),3,"img");							
						
				user::get()->zapiszLog(konf::get()->langTexty("u_admin_usun_log").$dane['id'].")",user::get()->login());
			}	
			konf::get()->_bazasql->freeResult($zap);	
						
			$query="";;			
			if(!empty($id_tab2)){
			  $query=tekstForm::tabQuery($id_tab2);			
			}
			
			if(!empty($query)){
				
			  if(konf::get()->isMod('znajomi')){						
					konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'znajomi')." WHERE id_u IN (".$query.")");
					konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'zablokowani')." WHERE id_u IN (".$query.")");	
				}
				
			  if(konf::get()->isMod('grupy')){	
						
				  $zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." WHERE id_u IN (".$query.") AND status=1");
					konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." WHERE id_u IN (".$query.")");
				  while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
					  konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'grupy')." g SET g.osoby=(SELECT COUNT(u.id) FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." u WHERE u.id_grupa=g.id AND u.status=1) WHERE g.id=".$dane['id_grupa']);
					}
					
				}		
				
			  if(konf::get()->isMod('ugal')){	
						
				  $zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy_galeria')." WHERE id_matka IN (".$query.")");
				  while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
						$this->usunImg($dane,konf::get()->getKonfigTab("u_konf",'galeria_kat'),2,"img");						
					}
					konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy_galeria')." WHERE id_matka IN (".$query.")");
					
				}					
				
			  if(konf::get()->isMod('poczta')){						
					konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'poczta')." WHERE ((id_odb IN (".$query.") AND typ=1) OR (id_wys IN (".$query.") AND typ=2))");
				}						
				
				konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE id IN (".$query.") AND id!='".user::get()->id()."'".user::get()->getSqlAdd());
					
			}
					
			konf::get()->setKomunikat(konf::get()->langTexty("usuwanie"),""); 
			
		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("usuwaniebrak"),"error"); 		
		}
		
	}

	
  /**
   * change parameter
   * @param string $param
	 * @param string $wartosc	
   */
	protected function zmienparam($param, $wartosc,$tabela="",$log="",$sql="",$komunikat=true){

		$id_tab=konf::get()->getZmienna('id_tab','id_tab');	
		
		if(!empty($id_tab)&&is_array($id_tab)){		

			$wartosc=tekstForm::doSql($wartosc);
			
			require_once(konf::get()->getKonfigTab('klasy')."class.wyslijemail.php");		

			while(list($key,$val)=each($id_tab)){
				if(!empty($val)&&$val!=user::get()->id()){
				
					konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." SET ".$param."='".$wartosc."' WHERE id='".$val."' AND id!='".user::get()->id()."'".user::get()->getSqlAdd());
					user::get()->zapiszLog(konf::get()->langTexty("u_admin_zmien_log").$param."=".$wartosc." (".$val.")",user::get()->login());
					
					if(konf::get()->getKonfigTab("u_konf",'powiadamianie')&&$param!="opis"){
					
						$zap=konf::get()->_bazasql->zap("SELECT login,email,niewygasa,status FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE id='".$val."'");
						$dane=konf::get()->_bazasql->fetchAssoc($zap);
						$tresc=konf::get()->langTexty("u_admin_param_e1")." ".$dane['login']." ".konf::get()->langTexty("u_admin_param_e2")." ".konf::get()->getKonfigTab('nazwa_www')." (".konf::get()->getKonfigTab('adres_www').")\n\n";
						$tresc.=konf::get()->langTexty("u_admin_param_e3")."\n";
						
						switch($dane['status']){
							case '1':
								$tresc.=konf::get()->langTexty("u_admin_param_es1");
							break;

							case '2':
								$tresc.=konf::get()->langTexty("u_admin_param_es2");
							break;

							default:
								$tresc.=konf::get()->langTexty("u_admin_param_es0");
						}
						
						if($dane['niewygasa']==1){ 
							$tresc.="\n ".konf::get()->langTexty("u_admin_param_en"); 
						} else if(konf::get()->getKonfigTab("u_konf",'autousuw')) { 
							$tresc.="/n ".konf::get()->langTexty("u_admin_param_ew")." ".konf::get()->getKonfigTab("u_konf",'autousuw').konf::get()->langTexty("u_admin_param_ed"); 
						}

						$wyslij=new wyslijemail(konf::get()->getKonfigTab('nazwa_www').konf::get()->langTexty("u_admin_param_e"),$tresc,$dane['email']);
						$wyslij->setNadawca(konf::get()->getKonfigTab('admin_email'),konf::get()->getKonfigTab('nazwa_www'));	
						$wyslij->wykonaj();			
													
						konf::get()->_bazasql->freeResult($zap);
					}		
				}		
			}	
			
			konf::get()->setKomunikat(konf::get()->langTexty("awykonana"),""); 
			
		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),"error"); 		
		}
		
	}

	
  /**
   * change opis
   */	
	public function zmienopis2(){
	
		$opis=konf::get()->getZmienna('opis');
	
		$this->zmienparam("opis",$opis);
		
	}
	
	
  /**
   * zerofill points
   */	
	public function wyzerujpunkty(){

		$this->zmienparam("punkty",0);	
		
	}
	

	
  /**
   * change status
   */
	public function zmienstatus(){

		$status=tekstForm::doSql(konf::get()->getZmienna('status','status'));		
		$id_tab=konf::get()->getZmienna('id_tab','id_tab');	
		
		$statusy_tab=konf::get()->getKonfigTab("u_konf",'statusy_tab');	
		$typ=user::get()->getDane("typ");		
		$typy_statusdostepni=konf::get()->getKonfigTab("u_konf",'typystatusydostepni_tab');			
		$statusy_tab2=array();
		
		if(!empty($typy_statusdostepni[$typ])){
		
			while(list($key,$val)=each($typy_statusdostepni[$typ])){
				if(!empty($statusy_tab[$val])){
					$statusy_tab2[$val]=$statusy_tab[$val];
				}
			}
			
		}			
		
		if((user::get()->specjalny()&&empty($statusy_tab[$status]))||(!user::get()->specjalny()&&empty($statusy_tab2[$status]))){
			$status="";
		}	
		
		if(!empty($id_tab)&&is_array($id_tab)&&!empty($status)){		
		
			$query=tekstForm::tabQuery($id_tab);
			
			if(!empty($query)){
			
				if(konf::get()->getKonfigTab("u_konf",'powiadamianie')&&$param!="opis"){		
				
					require_once(konf::get()->getKonfigTab('klasy')."class.wyslijemail.php");			
				
					$zap=konf::get()->_bazasql->zap("SELECT login,email FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE id IN (".$query.") AND id!='".user::get()->id()."'".user::get()->getSqlAdd());
				
					while($dane=konf::get()->_bazasql->fetchAssoc($zap)){

						$dane=konf::get()->_bazasql->fetchAssoc($zap);
						$tresc=konf::get()->langTexty("u_admin_param_e1")." ".$dane['login']." ".konf::get()->langTexty("u_admin_param_e2")." ".konf::get()->getKonfigTab('nazwa_www')." (".konf::get()->getKonfigTab('adres_www').")\n\n";
						$tresc.=konf::get()->langTexty("u_admin_param_e3")."\n";
						$tresc.=konf::get()->langTexty("u_statusy_tab".$status);		
						
						$wyslij=new wyslijemail(konf::get()->getKonfigTab('nazwa_www').konf::get()->langTexty("u_admin_param_e"),$tresc,$dane['email']);
						$wyslij->setNadawca(konf::get()->getKonfigTab('admin_email'),konf::get()->getKonfigTab('nazwa_www'));	
						$wyslij->wykonaj();			

					}		
					
					konf::get()->_bazasql->freeResult($zap);					
				}
				
				konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." SET status='".$status."' WHERE id IN (".$query.") AND id!='".user::get()->id()."'".user::get()->getSqlAdd());
				user::get()->zapiszLog(konf::get()->langTexty("u_admin_zmstatus"),user::get()->login());					
				
				konf::get()->setKomunikat(konf::get()->langTexty("u_admin_param"),""); 
				
			}
			
		}
		
	}

	
  /**
   * param form
   */
	public function formtext(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');	
		$u_sort=konf::get()->getZmienna('u_sort','u_sort');						
		$id_tab=konf::get()->getZmienna('id_tab','id_tab');	
		$tytul=konf::get()->getZmienna('tytul','tytul');	
		
		if(!empty($id_tab)&&is_array($id_tab)){			

			$dane['opis']="";

			$ile=count($id_tab);

		  if($ile==1){		
				if(konf::get()->getAkcja()=="uadmin_zmienopis"){
					echo tab_nagl(konf::get()->langTexty("u_admin_txt")." (".count($id_tab)."):",1);
				} else {
					$dane['opis']="";
					echo tab_nagl(konf::get()->langTexty("u_admin_txtw")." (".count($id_tab)."):",1);
				}
			} else {
				if(konf::get()->getAkcja()=="uadmin_zmienopis"){
					echo tab_nagl(konf::get()->langTexty("u_admin_txtk")." (".count($id_tab)."):",1);
				} else {
					echo tab_nagl(konf::get()->langTexty("u_admin_txtwk")." (".count($id_tab)."):",1);
				}
			}

			echo "<tr><td class=\"tlo3 lewa\">";
			
			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"u_form_text","u_form_text");
		
			if(konf::get()->getAkcja()!="uadmin_zmienopis"){			
				echo $form->spr(array(1=>"opis",2=>"tytul"));				
			}	
			
			echo $form->getFormp();		
			$form->setPrzenies($this->_szuk);
			echo $form->przenies(array(
				"u_sort"=>$u_sort,
				"podstrona"=>$podstrona,
				"akcja"=>konf::get()->getAkcja()."2"
			));	
			
			if(konf::get()->getAkcja()!="uadmin_zmienopis"){
				echo konf::get()->langTexty("u_admin_txt_tytul")."<br />";
				echo $form->input("text","tytul","tytul",$tytul,"f_bdlugi",200);	
				echo "<br />";
			}
			
		  echo konf::get()->langTexty("u_admin_txt_tresc")."<br />";
			
			echo $form->textarea("opis","opis",$dane['opis'],"f_bdlugi",15);			
			echo "<br />";
			
			while(list($key,$val)=each($id_tab)){
				if(!empty($val)){
					echo $form->input("hidden","id_tab[]","id_tab_".$val,$val);	
				}
			}
			
			echo $form->input("submit","","",konf::get()->langTexty("u_admin_txt_wyslij"),"formularz2 f_sredni");	
			echo $form->getFormk();	
			
			echo "</td></tr>";
			echo "<tr><td class=\"tlo4 srodek\">";
			echo "<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_arch"))."\">".konf::get()->langTexty("u_admin_powrot")."</a>";
			echo "</td></tr>";
			echo tab_stop();
			
		}

	}
	
	
  /**
   * opis form
   */	
	public function zmienopis(){
	
		$this->formtext();
		
	}	
	
	
  /**
   * message form
   */
	public function wiadomosc(){
	
		$this->formtext();
		
	}

	
  /**
   * message sent
   */
	public function wiadomosc2(){

		$id_tab=konf::get()->getZmienna('id_tab');	
		$opis=konf::get()->getZmienna('opis');	
		$tytul=konf::get()->getZmienna('tytul');	
		
		if(!empty($id_tab)&&is_array($id_tab)&&!empty($opis)&&!empty($tytul)){		
		
			$query=tekstForm::tabQuery($id_tab);
			
			if(!empty($query)){
				$zap=konf::get()->_bazasql->zap("SELECT email FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE id IN (".$query.")".user::get()->getSqlAdd());
				if(konf::get()->_bazasql->numRows($zap)>0){
					while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
						$email[]=$dane['email'];
					}
				}
				konf::get()->_bazasql->freeResult($zap);		
			}
			if(isset($email)&&is_array($email)){
			
				require_once(konf::get()->getKonfigTab('klasy')."class.wyslijemail.php");		
			
				$wyslij=new wyslijemail($tytul,$opis,$email);
				$wyslij->setNadawca(konf::get()->getKonfigTab('admin_email'),konf::get()->getKonfigTab('nazwa_www'));	
				$wyslij->wykonaj();			

				user::get()->zapiszLog(konf::get()->langTexty("u_admin_txt_log").$tytul,user::get()->login());
				konf::get()->setKomunikat(konf::get()->langTexty("u_admin_txt_rozs"),"");
			} 
		}
	}


  /**
   * privileges form
   */
	public function zmienupr(){

		$id_u=tekstForm::doSql(konf::get()->getZmienna('id_u','id_u'));	
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');	
		$u_sort=konf::get()->getZmienna('u_sort','u_sort');	
		
		if(!empty($id_u)){
		
			$uprawnienia_tab=konf::get()->getKonfigTab("u_konf",'uprawnienia');	

			$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE id='".$id_u."' AND id!='".user::get()->id()."'".user::get()->getSqlAdd());

			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"u_upr","u_upr");
			echo $form->getFormp();
			$form->setPrzenies($this->_szuk);
			echo $form->przenies(array(
				"u_sort"=>$u_sort,
				"podstrona"=>$podstrona,
				"akcja"=>"uadmin_zmienupr2",
				"id_u"=>$id_u
			));

			echo tab_nagl(konf::get()->langTexty("u_admin_upr")." ".$dane['login'],1);
			
			echo "<tr><td class=\"tlo3 grube\">";						
			$this->menu($dane);
			echo "</td></tr>";			
			
			echo "<tr><td class=\"tlo3\">";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");		
			echo "</td></tr>";			

			while(list($key,$val)=each($uprawnienia_tab)){
			
				if(!empty($val['opis'])&&user::get()->upr($key)){
					echo "<tr><td class=\"tlo3 grube\">";
					echo $form->checkbox("upr_tab[".$key."]","upr_tab_".$key,1,substr($dane['uprawnienia'],$key,1));					
					echo interfejs::label("upr_tab_".$key,konf::get()->langTexty("u_u".$key),true);					
					echo "</td></tr>";
				}
				
			}
			
			echo "<tr><td class=\"tlo3\">";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");		
			echo "</td></tr>";
			
			if(user::get()->adminU()){
				echo "<tr class=\"srodek\"><td class=\"tlo4\">";
				echo interfejs::linkEl("group",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_arch")),konf::get()->langTexty("u_admin_upr_listu"));
				echo "</td></tr>";
			}	
			echo tab_stop();
			echo $form->getFormk();
			
		}

	}


  /**
   * change privileges
   */
	public function zmienupr2(){

		$id_u=tekstForm::doSql(konf::get()->getZmienna('id_u'));	
		
		if(!empty($id_u)){
			
			$upr_tab=konf::get()->getZmienna('upr_tab');	
			$uprawnienia_tab=konf::get()->getKonfigTab("u_konf",'uprawnienia');	

			$zap=konf::get()->_bazasql->zap("SELECT login,email,uprawnienia FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE id='".$id_u."' AND id!='".user::get()->id()."'".user::get()->getSqlAdd());
			$dane=konf::get()->_bazasql->fetchAssoc($zap);
			konf::get()->_bazasql->freeResult($zap);

			if(!empty($dane)){
			
				$new_upr="";
				$tresc=konf::get()->langTexty("u_admin_upr_e1")." ".$dane['login']."\n";
				$tresc.=konf::get()->langTexty("u_admin_upr_e2")."\n";

				for($i=0;$i<konf::get()->getKonfigTab("u_konf",'ile_upr');$i++){
				
					$next="0";
					if(!empty($uprawnienia_tab[$i]['opis'])&&user::get()->upr($i)){
						if(!empty($upr_tab[$i])&&$upr_tab[$i]==1){
							$next="1";
						} else { 
							$next="0"; 
						}
					} else if (substr($dane['uprawnienia'],$i,1)!="") {
						$next=substr($dane['uprawnienia'],$i,1); 
					}

					$new_upr.=$next;
					if(konf::get()->getKonfigTab("u_konf",'powiadamianie')&&$next=='1'){
						$tresc.=konf::get()->langTexty("u_u".$i)."\n";
					}
				}

				konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." set uprawnienia='".$new_upr."' WHERE id='".$id_u."' AND id!='".user::get()->id()."'".user::get()->getSqlAdd());

				if(konf::get()->getKonfigTab("u_konf",'powiadamianie')){
				
					require_once(konf::get()->getKonfigTab('klasy')."class.wyslijemail.php");
														
					$wyslij=new wyslijemail(konf::get()->langTexty("u_admin_upr_e"),$tresc,$dane['email']);
					$wyslij->setNadawca(konf::get()->getKonfigTab('admin_email'),konf::get()->getKonfigTab('nazwa_www'));	
					$wyslij->wykonaj();			

				}

				user::get()->zapiszLog(konf::get()->langTexty("u_admin_upr_log")." ".$dane['login'],user::get()->login());
				konf::get()->setKomunikat(konf::get()->langTexty("u_admin_upr_zapisane"),""); 
				
			}
			
		}
		
	}


  /**
   * logs list
   */
	public function logiarch(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');	
		$logi_sort=konf::get()->getZmienna('logi_sort','logi_sort');	
		$szuk_fraza=konf::get()->getZmienna('szuk_fraza','szuk_fraza');	
		$szuk_kat=konf::get()->getZmienna('szuk_kat','szuk_kat');	
		$id_u=konf::get()->getZmienna('id_u','id_u');		
		$na_str=45;		

		$tab_sort=array(
			1=>"id", 2=>"id DESC", 
			3=>"id_u", 4=>"id_u DESC", 
			5=>"login", 6=>"login DESC", 
			7=>"opis", 8=>"opis DESC", 
			9=>"ip", 10=>"ip DESC", 
			11=>"kiedy", 12=>"kiedy DESC"
		);
		
		$colspan=6;

		if(empty($tab_sort[$logi_sort])){ 
			$logi_sort=2; 
		}
	 
	 	$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_logiarch"));

		$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'logi')." WHERE 1";

		if(!empty($id_u)){
			$query.=" AND id_u ='".tekstForm::doSql($id_u)."'";
			$link.="&amp;id_u=".$id_u;  
		}

		if(!empty($szuk_fraza)){
	 		$link.="&amp;szuk_fraza=".rawurlencode($szuk_fraza)."&amp;szuk_kat=".rawurlencode($szuk_kat);
			if($szuk_kat==1){
				$query.=" AND login LIKE '%".tekstForm::doLike($szuk_fraza)."%'";
			} else {  
				$query.=" AND opis LIKE '%".tekstForm::doLike($szuk_fraza)."%'";
			}
		}

		$naw = new nawig("SELECT COUNT(id) AS ilosc ".$query,$podstrona,$na_str);		
		$naw->naw($link."&amp;logi_sort=".$logi_sort);
		$podstrona=$naw->getPodstrona();	

		$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE id='".$id_u."' AND id!='".user::get()->id()."'".user::get()->getSqlAdd());
		
		echo tab_nagl(konf::get()->langTexty("u_logi_lista")." (".$naw->getWynikow()."):",$colspan);
				
		if(!empty($dane)){						
			echo "<tr><td class=\"tlo3 grube\" colspan=\"".$colspan."\">";						
			echo "<div class=\"grube\">".$dane['login']."</div>";
			$this->menu($dane);
			echo "</td></tr>";		
		}

		echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3\">";
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"arch","arch");	
		echo $form->spr(array(1=>"akcja"),"","ok=spr_akcjau(document.arch.akcja,'uadmin_usunlogi','".konf::get()->langTexty("czyusun")."');");
		echo $form->getFormp();
		echo $form->przenies(array("logi_sort"=>$logi_sort,"szuk_fraza"=>$szuk_fraza,"szuk_kat"=>$szuk_kat));

	   //akcje  
		$akcje_tab['uadmin_logiarch']=konf::get()->langTexty("u_logi_azobaczw");
		$akcje_tab['uadmin_usunlogi']=konf::get()->langTexty("u_logi_awyczysc");		
		echo $form->selectAkcja($akcje_tab);

		echo $form->getFormk();	
		
		echo "</td></tr>";
						
		if($naw->getNaw()){
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
		}

		echo "<tr class=\"srodek\">";

		echo interfejs::sortEl($link."&amp;logi_sort=",1,2,konf::get()->langTexty("u_logi_id"),$logi_sort,70);
		echo interfejs::sortEl($link."&amp;logi_sort=",3,4,konf::get()->langTexty("u_logi_idu"),$logi_sort,40);
		echo interfejs::sortEl($link."&amp;logi_sort=",5,6,konf::get()->langTexty("u_logi_login"),$logi_sort,160);
		echo interfejs::sortEl($link."&amp;logi_sort=",7,8,konf::get()->langTexty("u_logi_opis"),$logi_sort);
		echo interfejs::sortEl($link."&amp;logi_sort=",9,10,konf::get()->langTexty("u_logi_ip"),$logi_sort,150);
		echo interfejs::sortEl($link."&amp;logi_sort=",11,12,konf::get()->langTexty("u_logi_kiedy"),$logi_sort,140);
		
		echo "</tr>";
		
		if($naw->getWynikow()>0){
		
			$query="SELECT * ".$query." ORDER BY ".$tab_sort[$logi_sort];
			$query.=" LIMIT ".$naw->getStart().",".$naw->getIle();	
			
			$zap=konf::get()->_bazasql->zap($query);
			
			$link_u=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane"))."&amp;id_u=";

			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
			
				echo "<tr>";
				
				echo "<td class=\"tlo4 srodek\">";
				echo $dane['id'];
				echo "</td>";
				
				echo "<td class=\"tlo3 prawa\">";
				if(!empty($dane['id_u'])){
					if(user::get()->adminU()){
						echo "<a href=\"".$link_u.$dane['id_u']."\">";
					} 
					echo $dane['id_u'];
				 	if(user::get()->adminU()){
						echo "</a>";
					} 
				}
				echo "</td>";
				
				echo "<td class=\"tlo3\"><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_logiarch","id_u"=>$dane['id_u']))."\"><span class=\"male\">".$dane['login']."&nbsp;</span></a></td>";
				echo "<td class=\"tlo3 male\">".$dane['opis']."</td>";
				
				echo "<td class=\"tlo3 male srodek\"><span ";
				if(!empty($dane['host'])){ 
					echo " title=\"".htmlspecialchars($dane['host'])."\""; 
				}
				echo ">".$dane['ip']."</span></td>";
				
				echo "<td class=\"tlo3 srodek male\">".$dane['kiedy']."</td>";
				
				echo "</tr>";
				
			}
			
		} else { 
			echo interfejs::brak($colspan);
		}

		if($naw->getNaw()){
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
		}	
		
		if(user::get()->adminU()){
			echo "<tr class=\"srodek\"><td colspan=\"".$colspan."\" class=\"tlo4\">".interfejs::linkEl("group",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_arch")),konf::get()->langTexty("u_logi_listau"))."</td></tr>";	
		}
		
		echo tab_stop();
		
		echo tab_nagl(konf::get()->langTexty("wyszukiwarka"),1);
		echo "<tr><td class=\"tlo3\">";
		
		$form2=new formularz("post",konf::get()->getKonfigTab("plik"),"u_logi_arch2","u_logi_arch2");	
		echo $form2->getFormp();
		echo $form2->przenies(array("logi_sort"=>$logi_sort,"akcja"=>"uadmin_logiarch"));
		
		echo $form->select("szuk_kat","szuk_kat",array(
			1=>konf::get()->langTexty("u_logi_szuk_login"),
			2=>konf::get()->langTexty("u_logi_szuk_opis"),		
		),$szuk_kat,"f_dlugi");	

		echo " ";
		echo $form->input("text","szuk_fraza","szuk_fraza",$szuk_fraza,"f_dlugi",50);			
		echo " ";
		echo $form->input("submit","","",konf::get()->langTexty("szukaj"),"formularz2 f_sredni");	
		echo $form2->getFormk();	
		
		echo "</td></tr>";
		echo tab_stop();
		
	}

	
  /**
   * remove logs
   */	
	public function usunlogi(){

		konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'logi'));
		user::get()->zapiszLog(konf::get()->langTexty("u_logi_log"),user::get()->login());
		konf::get()->setKomunikat(konf::get()->langTexty("usuwanie"),"");
	 
	}



  /**
   * ip to display
   * @param string $ip
   */
	public function banyIpWys($ip){
		$ip=str_replace(array("^","$","\.",".*"),array("","","#","*"),$ip); //# jako zmienna przejsciowa
		$ip=str_replace(array(".","#"),array("?","."),$ip);
		return $ip;
	}

  /**
   * ip to mysql
	 * @param	 string $ip
   */
	public function banyIpZap($ip){
		$ip=str_replace(array(".","*","?"),array("\.",".*","."),$ip);
		$ip="^".$ip."$";
		$ip=tekstForm::doSql($ip,true);
		return $ip;
	}

	
  /**
   * bans list
   */
	public function banyarch(){

		$id_typ=tekstForm::doSql(konf::get()->getZmienna('id_typ','id_typ'));	

		if(!empty($id_typ)){
			$this->banyarch2();
		} else {
			$this->banytypy();		
		}
		
	}


  /**
   * bans types
   */
	public function banytypy(){

		$typy_tab=konf::get()->getKonfigTab("u_konf",'bany_typy');			
		
		$colspan=2;

		echo tab_nagl(konf::get()->langTexty("ubany_arch"),$colspan);
		
		echo "<tr><td class=\"tlo4 lewa grube\">".konf::get()->langTexty("ubany_arch_nazwa")."</td>";
		echo "<td class=\"tlo4 prawa grube\" style=\"width:50px\">".konf::get()->langTexty("ubany_arch_ilosc")."</td></tr>";
		
		if(isset($typy_tab)&&is_array($typy_tab)){
		
			$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_banyarch"));
			
			while(list($key,$val)=each($typy_tab)){
				echo "<tr>";
				echo interfejs::innyEl("group_key","<a href=\"".$link."&amp;id_typ=".$key."\">".konf::get()->langTexty("u_b".$key)."</a>","tlo3");
				echo "<td class=\"tlo3 prawa\">";
				echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'bany')." WHERE id_typ='".tekstForm::doSql($key)."'");
				echo "</td></tr>";
			}
			
		} else {
 			echo interfejs::brak($colspan);		
		}
		
		if(user::get()->adminU()){
			echo "<tr class=\"srodek\"><td colspan=".$colspan." class=\"tlo4\">";
			echo interfejs::linkEl("group",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_arch")),konf::get()->langTexty("ubany_arch_listau"));
			echo "</td></tr>";	
		}	
		
		echo tab_stop();
		
	}


  /**
   * bans list
   */
	public function banyarch2(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');	
		$sort=konf::get()->getZmienna('sort','sort');	
		$id_typ=tekstForm::doSql(konf::get()->getZmienna('id_typ','id_typ'));
		$typy_tab=konf::get()->getKonfigTab("u_konf",'bany_typy');	
		$na_str=25;
		
		if(empty($id_typ)||empty($typy_tab[$id_typ])){
			$id_typ="";
		}

		$tab_sort=array(
			1=>"ip", 2=>"ip DESC", 
			3=>"typ", 4=>"typ DESC", 
			5=>"status", 6=>"status DESC"
		);
		
		$colspan=5;

		if(empty($tab_sort[$sort])){ $sort=1; }
	 
	 	$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_banyarch","id_typ"=>$id_typ));

		$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'bany')." WHERE id_typ='".$id_typ."'";

		$naw = new nawig("SELECT COUNT(id) AS ilosc ".$query,$podstrona,$na_str);		
		$naw->naw($link."&amp;sort=".$sort);
		$podstrona=$naw->getPodstrona();	
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"arch","arch");
		
		echo $form->spr(array(1=>"akcja"),""," ok=spr_akcjau(document.arch.akcja,'uadmin_usunbany','".konf::get()->langTexty("czyusun")."'); ");
		echo $form->getFormp();
		echo $form->przenies(array("podstrona"=>$podstrona,"id_typ"=>$id_typ,"sort"=>$sort));	

		echo tab_nagl(konf::get()->langTexty("ubany_arch_reg").$naw->getWynikow().") :",$colspan);
		
		if(!empty($id_typ)&&!empty($typy_tab[$id_typ])){
		  echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3\">".konf::get()->langTexty("ubany_arch_typf")." <span class=\"grube\">".konf::get()->langTexty("u_b".$id_typ)."</span></td></tr>";
		}
		
		echo "<tr><td colspan=".$colspan." class=\"tlo3\">";

	   //akcje  
		$akcje_tab['uadmin_dodajbany']=konf::get()->langTexty("adodaj");
		
		if($naw->getWynikow()>0) {		
			$akcje_tab['uadmin_usunbany']=konf::get()->langTexty("ausun");
			$akcje_tab['uadmin_aktywbany']=konf::get()->langTexty("aaktyw");
			$akcje_tab['uadmin_deaktywbany']=konf::get()->langTexty("adeaktyw");		
		}
		
		echo $form->selectAkcja($akcje_tab);
		
		echo "<div class=\"male\">".konf::get()->langTexty("ubany_arch_oznacza")."</div>";	
			
		echo "</td></tr>";
		
		if($naw->getWynikow()>0) {		
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo4 srodek nobr\">";		
			echo $form->zaod("id_tab");		
			echo "</td></tr>";			
		}
						
		if($naw->getNaw()){
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
		}		
		
		echo "<tr class=\"srodek\">";		
		echo interfejs::sortEl("","","","",45);
		echo interfejs::sortEl("","","",konf::get()->langTexty("ubany_arch_regula"),"");
		echo interfejs::sortEl($link."&amp;sort=",1,2,konf::get()->langTexty("ubany_arch_ip"),$sort);
		echo interfejs::sortEl($link."&amp;sort=",3,4,konf::get()->langTexty("ubany_arch_typ"),$sort);
		echo interfejs::sortEl($link."&amp;sort=",5,6,konf::get()->langTexty("ubany_arch_status"),$sort,80);
		echo "</tr>";	

		if($naw->getWynikow()>0) {
		
			$zap=konf::get()->_bazasql->zap("SELECT * ".$query." ORDER BY ".$tab_sort[$sort].",id LIMIT ".$naw->getStart().",".$naw->getIle());

			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
			
				echo "<tr class=\"srodek\"><td class=\"tlo4\">";
				echo $form->checkbox("id_tab[]","id_".$dane['id'],$dane['id'],"");	
				echo "<div>".$dane['id']."</div>";			
				echo "</td>";
				
				echo "<td class=\"tlo3 lewa\">";
				echo $dane['opis'];
				
				echo "<table border=\"0\" style=\"margin-top:5px\"><tr valign=\"top\">";  
				echo interfejs::edytuj(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_edytujbany","id_nr"=>$dane['id'],"podstrona"=>$podstrona)));						
				echo interfejs::infoEl($dane);			  							
				echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_usunbany","id_typ"=>$id_typ,"id_tab[]"=>$dane['id'])));			
				echo "</tr></table>"; 
							
				echo "</td>";
				
				echo "<td class=\"tlo3\">";
				echo "<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_edytujbany","id_nr"=>$dane['id'],"podstrona"=>$podstrona))."\">";
				echo $this->banyIpWys($dane['ip']);
				echo "</a>";
				echo "</td>";
				
				echo "<td class=\"tlo3 male\">";
				if($dane['rodzaj']==1){ 
					echo konf::get()->langTexty("ubany_arch_banuj"); 
				} else if ($dane['rodzaj']==2){ 
					echo konf::get()->langTexty("ubany_arch_dopusc"); 
				} else { 
					echo "??"; 
				}
				echo "</td>";
				
				echo "<td class=\"tlo3 srodek male\">";
				if($dane['status']==1){ 
					echo konf::get()->langTexty("aktywne"); 
				} else { 
					echo konf::get()->langTexty("nieaktywne"); 
				}
				echo "</td>";
				
				echo "</tr>";
			}
			
			konf::get()->_bazasql->freeResult($zap);
			
		} else { 
 			echo interfejs::brak($colspan);				
		}
		
		if($naw->getNaw()){
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
		}		
		
		echo "<tr class=\"srodek\"><td colspan=".$colspan." class=\"tlo4\">";
		echo interfejs::linkEl("group_key",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_banyarch")),konf::get()->langTexty("ubany_arch_typyl"));
		echo "</td></tr>";
		
		echo tab_stop();
		echo $form->getFormk();

	}


  /**
   * bans form
   */
	private function banyform(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');	
		$sort=konf::get()->getZmienna('sort','sort');		
		$id_typ=tekstForm::doSql(konf::get()->getZmienna('id_typ','id_typ'));
		$typy_tab=konf::get()->getKonfigTab("u_konf",'bany_typy');	
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));

		$dane=array(
			'id_typ'=>$id_typ,
			'ip'=>"",
			'opis'=>"",
		  'data_start'=>date("Y-m-d H:i"),
		  'data_stop'=>"",		
			'rodzaj'=>"",
			'status'=>1
		);
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"u_bany","u_bany");	
		$dane=$form->odczyt($dane);
		
		if(!empty($id_nr)){
			$danez=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'bany')." WHERE id='".$id_nr."'");
			if(empty($danez)){
				$id_nr="";
			} else {
				$dane=$danez;
			}
		}

		if(konf::get()->getAkcja()=="uadmin_dodajbany"||!empty($id_nr)){
		
			if(konf::get()->getAkcja()=="uadmin_dodajbany"){
	  		echo tab_nagl(konf::get()->langTexty("ubany_form_tworzenie"),1);
			} else {
	  		echo tab_nagl(konf::get()->langTexty("ubany_form_edycja"),1);
			}
	  	echo "<tr><td class=\"tlo3\">";

			echo $form->spr(array(1=>"id_typ",2=>"ip",3=>"opis",4=>"rodzaj"));
			echo $form->getFormp();
			echo $form->przenies(array("akcja"=>konf::get()->getAkcja()."2","id_nr"=>$id_nr,"podstrona"=>$podstrona,"sort"=>$sort));					

			echo "<table border=\"0\"><tr>";  
			if(!empty($id_nr)){		  
				echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_usunbany","id_typ"=>$id_typ,"id_tab[]"=>$id_nr,"sort"=>$sort)));
				echo interfejs::infoEl($dane);		
			}
			echo interfejs::przyciskEl("arrow_join",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_banyarch","podstrona"=>$podstrona,"id_typ"=>$dane['id_typ'],"sort"=>$sort)),konf::get()->langTexty("ubany_form_listar"));				
			echo "</tr></table><br />"; 
			
			echo "<div>";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");				
			echo "</div><br />";			  
			
			echo $form->kalendarz("data_start","trigger_a",$dane['data_start'],true);
			echo interfejs::label("data_start",konf::get()->langTexty("ubany_form_dataod"),"grube",true);
			echo "<br /><br />";			

			echo $form->kalendarz("data_stop","trigger_b",$dane['data_stop'],true);
			echo interfejs::label("data_stop",konf::get()->langTexty("ubany_form_datado"),"grube",true);				
			echo "<br /><br />";
			
			echo $form->select("typ","typ",array(
				1=>konf::get()->langTexty("ubany_form_blokowany"),
				2=>konf::get()->langTexty("ubany_form_dopuszczany")
			),$dane['rodzaj'],"f_dlugi");	
			
			echo interfejs::label("typ",konf::get()->langTexty("ubany_form_rodzaj"),"grube",true);									
			echo "<br /><br />";
			
			echo interfejs::label("id_typ",konf::get()->langTexty("ubany_form_typfiltra"),"grube");							
			echo "<br />";
			
			echo "<select name=\"id_typ\" id=\"id_typ\" class=\"f_bdlugi\">";
			echo "<option value=\"\">".konf::get()->langTexty("ubany_form_wybierz")."</option>";
			while(list($key,$val)=each($typy_tab)){
				echo "<option value=\"".$key."\" ";
				if($dane['id_typ']==$key){
					echo " selected=\"selected\"";
				}
				echo ">".konf::get()->langTexty("u_b".$key)."</option>";
			}
			echo "</select>";
			echo "<br /><br />";		
			
			echo interfejs::label("ip",konf::get()->langTexty("ubany_form_adres"),"grube");				
	  	echo "<br />";				
			echo $form->input("text","ip","ip",$this->banyIpWys($dane['ip']),"f_dlugi",30);				
			echo "<br />";
			echo "<span class=\"male\">".konf::get()->langTexty("ubany_form_znak")." <span class=\"grube\">*</span> ";
			echo konf::get()->langTexty("ubany_form_oznacza1").", ".konf::get()->langTexty("ubany_form_znak")." ";
			echo "<span class=\"grube\">?</span> ".konf::get()->langTexty("ubany_form_oznacza2")."</span><br /><br />";

			echo interfejs::label("opis",konf::get()->langTexty("ubany_form_opis"),"grube blok");		
			echo $form->input("text","opis","opis",$dane['opis'],"f_bdlugi",250);				
			echo "<br /><br />";
			
			echo $form->checkbox("status","status",1,$dane['status']);
			echo interfejs::label("status",konf::get()->langTexty("ubany_form_aktywna"),"nobr",true);				
	   	echo "<br /><br />";
			
			echo "<div>";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");				
			echo "</div><br />";
			
			echo "<div class=\"male\">".konf::get()->langTexty("musza")."</div>";

			echo $form->getFormk();	
					
			echo "</td></tr>";
		  echo "<tr class=\"srodek\"><td class=\"tlo4\">";
			echo interfejs::linkEl("group_key",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_banyarch","podstrona"=>$podstrona,"id_typ"=>$dane['id_typ'])),konf::get()->langTexty("ubany_form_listar"));
			echo "</td></tr>";	
	  	echo tab_stop();
		
		} else { 
			echo interfejs::nieprawidlowe();
		}

	}

	
  /**
   * bans add form
   */
	public function dodajbany(){
		
		$this->banyform();
			
	}	
	
	
  /**
   * bans edit form
   */	
	public function edytujbany(){
		
		$this->banyform();
			
	}	
	

  /**
   * bans save
   */
	private function banyzapisz(){

		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr'));
		
		$dane=array(
			"ip"=>"",
			"opis"=>"",		
			"id_typ"=>"",		
			"rodzaj"=>"",			
			"status"=>"",			
			"data_start"=>"",			
			"data_stop"=>""
		);

		$testy[]=array("zmienna"=>"status","test"=>"truefalse",
			"param"=>array(
				"wartosc"=>1
			)
		);
		
		$testy[]=array("zmienna"=>"rodzaj","test"=>"liczba",
			"param"=>array(
				"min"=>1,
				"max"=>2,
				"domyslny"=>1
			)
		);		
		
		$testy[]=array("zmienna"=>"ip","test"=>"wartosc","wymagany"=>true,
			"param"=>array(
				"komunikat"=>konf::get()->langTexty("nieprawidlowe"),
				'idtf'=>"ip"			
			)	
		);		
		
		$testy[]=array("zmienna"=>"opis","test"=>"wartosc","wymagany"=>true,
			"param"=>array(
				"komunikat"=>konf::get()->langTexty("nieprawidlowe"),
				'idtf'=>"ip"			
			)	
		);		
		
		$testy[]=array("zmienna"=>"id_typ","test"=>"wartosc","wymagany"=>true,
			"param"=>array(
				"komunikat"=>konf::get()->langTexty("nieprawidlowe"),
				'idtf'=>"ip"			
			)	
		);		
		
		//generator zapytania insert/update
		require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
		$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'bany'),$dane);
		$sqldane->daneOdczyt();	
		$sqldane->setAutor(true);	
		$sqldane->setTesty($testy);	
		
		$sqldane->testuj();	
		
		if($sqldane->ok()){
		
			//zamienia na wyraĹźenie regularne
		 	$sqldane->setDane(array(
				"ip"=>$this->banyIpZap($sqldane->getDane("ip"))
			));		

			//sprawdzamy czy strony o tym idcentyfikatorze jeszcze nie ma
			if(konf::get()->_bazasql->policz("id","FROM ".konf::get()->getKonfigTab("sql_tab",'bany')." WHERE ip='".$sqldane->getDane("ip")."' AND id!='".$id_nr."' AND id_typ='".$sqldane->getDane("id_typ")."'")==0){
			
				if(empty($id_nr)){
				
					//budowanie zapytania
					$sqldane->dodajDaneD();							
					
					//wykonujemy
					if($sqldane->getSql()){
						konf::get()->_bazasql->zap($sqldane->getSql());
						//wykonaj zapytanie
						$id_nr=konf::get()->_bazasql->insert_id;
						$sqldane->setId($id_nr);					
					}	

				} else {
				
					//budowanie zapytania
					$sqldane->dodajDaneE();						
					$sqldane->dodaj(" WHERE id='".$id_nr."'");	
					
					//wykonaj zapytanie
					if($sqldane->getSql()){
						konf::get()->_bazasql->zap($sqldane->getSql());
					}		

				}
				
				if(!empty($id_nr)){
				
					konf::get()->setZmienna("_post","id_nr",$id_nr);	
					
					konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");
					user::get()->zapiszLog(konf::get()->langTexty("ubany_zapis_log")." ".$this->banyIpZapis($sqldane->getDane("ip")),user::get()->login());

					//nie pozwala zabanowac IP wlasnego komputera IP 
					$this->autoban($sqldane->getDane("ip"));

				} else { 
					konf::get()->setKomunikat(konf::get()->langTexty("niezapisane"),"error"); 
				} 
				
			} else { 
				konf::get()->setKomunikat(konf::get()->langTexty("istnieje"),"error"); 
			}
			
		} else { 
			konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),"error"); 
		}
		
	}	
	
	
  /**
   * bans add
   */	
	public function dodajbany2(){
		
		$this->banyzapisz();
			
	}	
	
	
  /**
   * bans edit
   */	
	public function edytujbany2(){
		
		$this->banyzapisz();
			
	}

	
  /**
   * bans remove
   */
	public function usunbany(){

		$id_tab=konf::get()->getZmienna('id_tab','id_tab');	
		$id_typ=konf::get()->getZmienna('id_typ','id_typ');	
				
		if(!empty($id_tab)&&is_array($id_tab)){	
		
		$query=tekstForm::tabQuery($id_tab);

			if(!empty($query)){
			
				konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'bany')." WHERE id IN (".$query.")");
				user::get()->zapiszLog(konf::get()->langTexty("ubany_usun_log"),user::get()->login());
				konf::get()->setKomunikat(konf::get()->langTexty("usuwanie"),"");
				
				$this->autoban($id_typ);
				
			} else {
				konf::get()->setKomunikat(konf::get()->langTexty("usuwaniebrak"),"");			
			}
			
		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("usuwaniebrak"),"");			
		}
		
	}


  /**
   * bans change parameter
   * @param string $param
	 * @param string $wartosc	
   */
	private function banyzmienparam($param, $wartosc){

		$id_tab=konf::get()->getZmienna('id_tab');	
		
		if(!empty($id_tab)&&is_array($id_tab)){	
		
			$id_typ=tekstForm::doSql(konf::get()->getZmienna("id_typ","id_typ"));	
			$wartosc=tekstForm::doSql($wartosc);
			$query=tekstForm::tabQuery($id_tab);
				
			if(!empty($query)){
			
				konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'bany')." SET ".$param."='".$wartosc."' WHERE id IN (".$query.")");
				user::get()->zapiszLog(konf::get()->langTexty("ubany_zmiana_log"),user::get()->login());
				konf::get()->setKomunikat(konf::get()->langTexty("awykonana"),""); 

				$this->autoban($id_typ);
				
			} else {
				konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),""); 		
			}
			
		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),""); 		
		}
			
	}
	
	
  /**
   * bans activ
   */	
	public function aktywbany(){
	
		$this->banyzmienparam("status",1);
		
	}	
	
	
  /**
   * bans deactiv
   */	
	public function deaktywbany(){
	
		$this->banyzmienparam("status",0);
		
	}

	
  /**
   * set auto ban
   * @param int $id_typ
   */
	public function autoban($id_typ){

		if(($id_typ==1||$id_typ==3)&&!user::get()->filtr($id_typ)){
			konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'bany')." VALUES(NULL, '".$id_typ."', '".user::get()->id()."', '".u_bany_autor()."',0,'', 'auto', '".u_logi_ip_zap(konf::get()->getIp())."',NOW(),'',NOW(),'',2,1)");
			konf::get()->setKomunikat(konf::get()->langTexty("ubany_autozapis"),"error");
		}	
		
	}	
	
  /**
   * user menu
   * @param array $dane
   */		
	function menu($dane){
	
		if(user::get()->zalogowany()&&$this->_admin&&!empty($dane)){
			echo "<div><table class=\"lewa\" border=\"0\"><tr>";
			echo interfejs::edytuj(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_edytuj","id_u"=>$dane['id']))); 				
			echo interfejs::podglad(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane","id_u"=>$dane['id']))); 					
			if($dane['id']!=user::get()->id()){	
				echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_usunu","id_tab[1]"=>$dane['id']))); 
	 			echo interfejs::przyciskEl("key",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_zmienupr","id_u"=>$dane['id'])),konf::get()->langTexty("u_login_upr"));
				if(user::get()->adminLogi()){						
		 			echo interfejs::przyciskEl("table",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_logiarch","id_u"=>$dane['id'])),konf::get()->langTexty("u_login_logi"));
				}
			}	
			echo interfejs::infoEl($dane);					
			echo interfejs::przyciskEl("arrow_join",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_arch")),konf::get()->langTexty("poziomdogory"));					
			echo "</tr></table></div>";
		}
	
	}	

	/**
   * class constructor php5	
   */	
	public function __construct() {	

		$this->_admin=user::get()->adminU();
		$this->szukZmienne(1);
			
		if(empty($this->_szuk['szuk_typ'])){
			$this->_szuk['szuk_typ']=konf::get()->getKonfigTab("u_konf",'typy_admindomyslny');
		}		

  }	

		
}

?>