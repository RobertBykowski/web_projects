<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

konf::get()->setTekstyTab("konfig_admin_texty","2");

class konfigadmin extends modul {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="konfigadmin class";
	
	
	//domyślne wartosci
	private $_dane=array(
		'nazwa_www'=>"",
		'tytul_przedrostek'=>"",
		'description'=>"",
		'keywords'=>"",
		'kodstat'=>"",		
		'kontakt_email'=>"",
		'kontakt_nadawca'=>"",
		'kontakt_smtp_host'=>"",
		'kontakt_smtp_user'=>"",
		'kontakt_smtp_haslo'=>"",				
    'lang_default'=>"",			
	);
		
	//wartosci na wszystkie jezyki
	private $_danen=array(
		'kodstat'=>"",			
		'kontakt_email',
		'kontakt_nadawca',
		'kontakt_smtp_host',
		'kontakt_smtp_user',
		'kontakt_smtp_haslo',				
		'lang_default'
	);	
	
	
	public function edytuj(){

	  $podstrona=konf::get()->getZmienna('podstrona','podstrona');
		
		$zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'konfig')." WHERE (lang='".konf::get()->getLang()."' OR lang=0) ORDER BY lang");
		
		while($dane2=konf::get()->_bazasql->fetchAssoc($zap)){
			$this->_dane[$dane2['idtf']]=$dane2['wartosc'];
		}
		
		konf::get()->_bazasql->freeResult($zap);

		echo tab_nagl(konf::get()->langTexty("konfig_form_edycja"),1);

	  echo "<tr><td class=\"lewa tlo3\">";   	
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"konfig","konfig");
		echo $form->spr(array(1=>"akcja"));
		echo $form->getFormp();
		echo $form->przenies(array("akcja"=>"konfigadmin_edytuj2"));
		
	 	echo "<div>";
		echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");	
		echo "</div>";			

		echo interfejs::label("nazwa_www",konf::get()->langTexty("konfig_form_tytul"),"grube");		
		echo interfejs::pomocEl(konf::get()->langTexty("konfig_form_htytul"));
		echo "<br />";
		echo $form->input("text","nazwa_www","nazwa_www",$this->_dane['nazwa_www'],"f_bdlugi",200);
		echo "<br /><br />";
		
		echo interfejs::label("tytul_przedrostek",konf::get()->langTexty("konfig_form_tytulp"),"grube");				
		echo interfejs::pomocEl(konf::get()->langTexty("konfig_form_htytulp"));
		echo "<br />";
		echo $form->input("text","tytul_przedrostek","tytul_przedrostek",$this->_dane['tytul_przedrostek'],"f_bdlugi",200);	
		echo "<br /><br />";
			
		echo "<br />";
		
		echo interfejs::label("description",konf::get()->langTexty("konfig_form_description"),"grube");				
		echo interfejs::pomocEl(konf::get()->langTexty("konfig_form_hdescription"));
		echo "<br />";
		echo $form->textarea("description","description",$this->_dane['description'],"f_bdlugi",5);	
		echo "<br />";
		echo $form->skrocTxt("description",250);

		
		echo "<br />";
		echo interfejs::label("keywords",konf::get()->langTexty("konfig_form_keywords"),"grube");	
		echo interfejs::pomocEl(konf::get()->langTexty("konfig_form_hkeywords"));
		echo "<br />";
		echo $form->textarea("keywords","keywords",$this->_dane['keywords'],"f_bdlugi",5);	
		echo "<br />";
		echo $form->skrocTxt("keywords",450);			
		
		echo "<br />";
		echo interfejs::label("kodstat",konf::get()->langTexty("konfig_form_kodstat"),"grube");			
		echo interfejs::pomocEl(konf::get()->langTexty("konfig_form_hkodstat"));
		echo "<br />";
		echo $form->textarea("kodstat","kodstat",$this->_dane['kodstat'],"f_bdlugi",7);	
		echo "<br />";					

	  echo "<br />";
		echo interfejs::label("kontakt_email",konf::get()->langTexty("konfig_form_kontakte"),"grube");	
		echo interfejs::pomocEl(konf::get()->langTexty("konfig_form_hkonakte"));
		echo "<br />";
		echo $form->input("text","kontakt_email","kontakt_email",$this->_dane['kontakt_email'],"f_dlugi",150);	
		echo "<br /><br />";
			
		echo interfejs::label("kontakt_nadawca",konf::get()->langTexty("konfig_form_kontakta"),"grube");				
		echo interfejs::pomocEl(konf::get()->langTexty("konfig_form_hkonakta"));
		echo "<br />";
		echo $form->input("text","kontakt_nadawca","kontakt_nadawca",$this->_dane['kontakt_nadawca'],"f_dlugi",150);	
		echo "<br /><br />";
		
	  echo "<span class=\"grube\">".konf::get()->langTexty("konfig_form_smtp")."</span>";	
		echo interfejs::pomocEl(konf::get()->langTexty("konfig_form_hsmtp"));
		echo "<br />";
		
		echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\">";
		
		echo "<tr class=\"lewa\">";		
		echo "<td>".interfejs::label("kontakt_smtp_host",konf::get()->langTexty("konfig_form_smtphost"))."</td>";				
		echo "<td>".interfejs::label("kontakt_smtp_user",konf::get()->langTexty("konfig_form_smtplogin"))."</td>";
		echo "<td>".interfejs::label("kontakt_smtp_haslo",konf::get()->langTexty("konfig_form_smtphaslo"))."</td>";		
		echo "</tr>";		
				
		echo "<tr class=\"lewa\">";		
		echo "<td>";
		echo $form->input("text","kontakt_smtp_host","kontakt_smtp_host",$this->_dane['kontakt_smtp_host'],"f_dlugi",250);			
		echo "</td>";
		echo "<td>";
		echo $form->input("text","kontakt_smtp_user","kontakt_smtp_user",$this->_dane['kontakt_smtp_user'],"f_dlugi",250);			
		echo "</td>";	
		echo "<td>";
		echo $form->input("text","kontakt_smtp_haslo","kontakt_smtp_haslo",$this->_dane['kontakt_smtp_haslo'],"f_dlugi",250);			
		echo "</td>";
		echo "</tr>";				
		echo "</table>";
		
		echo "<br />";		

		$tab_lang=konf::get()->getKonfigTab('tab_lang');
		if($tab_lang&&is_array($tab_lang)&&count($tab_lang)>1){
			echo $form->select("lang_default","lang_default",$tab_lang,$this->_dane['lang_default'],"f_krotki");			
			echo interfejs::label("lang_default",konf::get()->langTexty("konfig_form_lang"),"grube",true);				
			echo interfejs::pomocEl(konf::get()->langTexty("konfig_form_hlang"));	
			echo "<br /><br />";
		}

	 	echo "<div>";
		echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");	
		echo "</div>";	
		echo $form->getFormk();
	 	
		echo "</td></tr>";
		
		echo "<tr class=\"srodek\"><td class=\"tlo4\">".interfejs::linkEl("cog",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_panel")),konf::get()->langTexty("konfig_form_panel"))."</td></tr>";	
		
		echo tab_stop();

	}


	//sprawdza czy rekord istnieje
	private function istnieje($idtf,$lang){

		$ok=false;
		
		$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'konfig')." WHERE idtf='".$idtf."' AND lang='".$lang."'";
		
		$ile=konf::get()->_bazasql->policz("*",$query);
		if($ile>0){
			$ok=true;
		}
		return $ok;	
		
	}


	//przygotowanie danych
	public function edytuj2(){
	
		reset($this->_dane);
		while(list($key,$val)=each($this->_dane)){
			$this->_dane[$key]=tekstForm::doSql(konf::get()->getZmienna($key),false);
		}

		$this->_dane['description']=substr(tekstForm::bezlinia($this->_dane['description']),0,250);
		$this->_dane['keywords']=substr(tekstForm::bezlinia($this->_dane['keywords']),0,450);
		
		reset($this->_dane);
		while(list($key,$val)=each($this->_dane)){
			if(in_array($key,$this->_danen)){
				$this->zmienparam($key,$val,0);		
			} else {
				$this->zmienparam($key,$val,konf::get()->getLang());					
			}
		}		

		konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");
		user::get()->zapiszLog(konf::get()->langTexty("konfig_zap_zmiana_log"),user::get()->login());
		
	}


	//zmienia okreslony parametr
	private function zmienparam($idtf,$wartosc,$lang=0){

		if($this->istnieje($idtf,$lang)){
			konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'konfig')." SET wartosc='".$wartosc."' WHERE idtf='".$idtf."' AND lang='".$lang."'");
		} else {
			konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'konfig')." VALUES('".$idtf."','".$wartosc."', '".$lang."')");	
		}
		
	}		
	
	
	/**
   * class constructor php5	
   */	
	public function __construct() {	

  }	

		
}

?>