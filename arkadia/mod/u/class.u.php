<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

if(user::get()->zalogowany()){
	konf::get()->setTekstyTab("u_login_texty",2);
} else {
	konf::get()->setTekstyTab("u_login_texty");
}

include(konf::get()->getKonfigTab('mod_kat')."u/konfig_inc.php");

class u extends modul {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="u class";
	

	
	public function akcjeEl($link,$opis,$ikona="table"){
		global $konf; 
		
		$html="<tr>".interfejs::innyEl($ikona,"<a class=\"blok\" href=\"".$link."\">".$opis."</a>","tlo3")."</tr>";
		
		return $html;

	}


	public function panel(){

		$this->infodane();
		
		if(user::get()->administrator()){

			echo tab_nagl(konf::get()->langTexty("nagla_a_dostepne"),1);
			
			if(user::get()->adminGlowny()&&konf::get()->isMod('konfig')){
				echo $this->akcjeEl(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"konfigadmin_edytuj")),konf::get()->langTexty("nagla_a_konfig"),"wrench");
			}	

			if(user::get()->adminU()){
				echo $this->akcjeEl(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_arch")),konf::get()->langTexty("nagla_a_kontami"),"group");
			}

			if(user::get()->adminU()&&konf::get()->getKonfigTab("u_konf",'banowanie')){
				echo $this->akcjeEl(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_banytypy")),konf::get()->langTexty("nagla_a_ip"),"group_key");
			}

			if(user::get()->adminLogi()){
				echo $this->akcjeEl(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_logiarch")),konf::get()->langTexty("nagla_a_log"),"table");
			}

			if(konf::get()->isMod('grupy')&&user::get()->upr(3)){
				echo $this->akcjeEl(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupyadmin_typy")),"Administracja grupami","group");
			}			
			
			if(konf::get()->isMod('galerieadmin')&&user::get()->upr(4)){
				echo $this->akcjeEl(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"galerieadmin_typy")),"Administracja galeriami","picture");
			}						
			
			if(konf::get()->isMod('art')&&user::get()->upr(11)){
				echo $this->akcjeEl(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_dzialy")),konf::get()->langTexty("nagla_a_cms"),"folder_explore");
			}
			
			if(konf::get()->isMod('news')&&user::get()->upr(14)){
				echo $this->akcjeEl(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"newsadmin_dzialy")),konf::get()->langTexty("nagla_a_news"),"folder_explore");
			}	
		  
			if(konf::get()->isMod('ankieta')&&user::get()->upr(15)){
				echo $this->akcjeEl(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ankietaadmin_typy")),konf::get()->langTexty("nagla_a_ankietami"),"text_list_bullets");
			}
		  
			if(konf::get()->isMod('guestbook')&&user::get()->upr(13)){
				echo $this->akcjeEl(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"guestbook_zobacz")),konf::get()->langTexty("nagla_a_guestbook"),"user_comment");
			}

		  if(konf::get()->isMod('subs')&&user::get()->upr(16)){
				echo $this->akcjeEl(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"subsadmin_typy")),konf::get()->langTexty("nagla_a_sub"),"email");
			}
			
		  if(konf::get()->isMod('rotator')&&user::get()->upr(17)){
				echo $this->akcjeEl(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"rotatoradmin_typy")),konf::get()->langTexty("nagla_a_rot"),"film");
			}
			
		  if(konf::get()->isMod('sklep')&&user::get()->upr(20)){
				echo $this->akcjeEl(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_dzialy")),konf::get()->langTexty("nagla_a_sklep")."Administracja  kategoriami sklepu","basket");
				echo $this->akcjeEl(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_arch")),konf::get()->langTexty("nagla_a_produkty")."Administracja produktami","basket");				
				echo $this->akcjeEl(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"producenciadmin_arch")),konf::get()->langTexty("nagla_a_producenci")."Administracja producentami","basket");										
			}	
					
		  if(konf::get()->isMod('sklep')&&user::get()->upr(21)){		
				echo $this->akcjeEl(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"zamowieniaadmin_arch")),konf::get()->langTexty("nagla_a_zamowienia")."Administracja zamówieniami","basket");										
			}		
						
			echo tab_stop();
		}
		
	}
	
	
	public function styl(){
	
		$styl_id=konf::get()->getZmienna("styl_id","styl_id");
		
		if(!empty($styl_id)){
			konf::get()->setStyl($styl_id);
		}

	}
	
	
	public function zaloguj(){

		echo "<div class=\"srodek\"><div class=\"srodek\" style=\"margin-top:25px; margin-bottom:20px; width:200px\">";
	  echo tab_nagl(konf::get()->langTexty("nagl_logowanie"),1);
	  echo "<tr><td class=\"tlo3\">";
	  echo $this->logowanieform();
	  echo "</td></tr>";
	  if(user::get()->zalogowany()&&user::get()->administrator()){
	    echo "<tr><td class=\"tlo3 srodek\"><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_panel"))."\"><span class=\"grube\">".konf::get()->langTexty("paneladmin")."</span></a></td></tr>";
	  }
	  echo tab_stop();
		echo "</div></div>";

	}
	
	
	public function zalogujadmin(){
	
		$this->zaloguj();
		
	}
	
	
	public function zaloguj2(){
	
		if(user::get()->zalogowany()){
			if(user::get()->administrator()){
				konf::get()->setAkcja("u_panel");			
			} else {
				konf::get()->setAkcja("");
			}
		} else {
			konf::get()->setAkcja("u_zaloguj");		
		}
		
	}	
		
	
	public function zalogujadmin2(){
	
		if(user::get()->zalogowany()){
			konf::get()->setAkcja("u_panel");
		} else {
			konf::get()->setAkcja("u_zalogujadmin");		
		}
		
	}	
	
	//prosty formularz logowania/wylogowywania
	public function logowanieform($redir=""){

		if(empty($redir)){
			$redir=konf::get()->getZmienna("redir","redir");	
		} else {
			$redir=base64_encode($redir);
		}
		
		$redir=str_replace("&amp;","&",$redir);	
		
		$html="<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"seta\"><tr><td class=\"lewa\">";
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"logowanie","logowanie");
		
		if(!user::get()->zalogowany()){
			$html.=$form->spr(array(1=>"u_login",2=>"u_haslo"));	
		}
		$html.=$form->getFormp();	
		
		if(user::get()->zalogowany()){
			$html.="<div class=\"grube srodek\">".user::get()->login()."<br />";
			if(konf::get()->getSzablon()=="admin"){
				$html.=$form->przenies(array("akcja"=>"u_wylogujadmin"));			
			} else {
				$html.=$form->przenies(array("akcja"=>"u_wyloguj"));
			}
			$html.=$form->input("submit","","",konf::get()->langTexty("nagl_log_wyloguj"),"formularz2 f_krotki");				
			$html.="</div>";
		} else {
		
			//$html.=$form->bootproof();
			
			if(konf::get()->getSzablon()=="admin"){
				$html.=$form->przenies(array("akcja"=>"u_zalogujadmin2","redir"=>$redir));				
			} else {
				$html.=$form->przenies(array("akcja"=>"u_zaloguj2","redir"=>$redir));	
			}
			
			$html.=$form->input("text","u_login","u_login","","f_sredni",50);		
			$html.=interfejs::label("u_login",konf::get()->langTexty("nagl_log_login"),"",true);									
			$html.="<br />";		
			
			$html.=$form->input("password","u_haslo","u_haslo","","f_sredni",50," autocomplete=\"off\"");	
			$html.=interfejs::label("u_haslo",konf::get()->langTexty("nagl_log_haslo"),"",true);					
			$html.="<br />";
			
			if(konf::get()->getKonfigTab("u_konf",'staly_log')){
				$html.="<div class=\"nobr\">";
				$html.=$form->checkbox("u_log_stale","u_log_stale",1,"");			
				$html.=interfejs::label("u_log_stale",konf::get()->langTexty("nagl_log_stale"),"",true);				
				$html.="</div>";
			}
			
			$html.=$form->input("submit","","",konf::get()->langTexty("nagl_log_zaloguj"),"formularz2 f_krotki");			
			if(!konf::get()->getKonfigTab("u_konf",'tylko_admin')){ 
				$html.="<div class=\"prawa\"><a class=\"male\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dodaj"))."\">".konf::get()->langTexty("nagl_log_zaloz")."&gt;</a></div>"; 
			}
			if(konf::get()->getKonfigTab("u_konf",'odzysk')){ 
				$html.="<div class=\"prawa\"><a class=\"male\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_od"))."\">".konf::get()->langTexty("nagl_log_zapomnialem")."&gt;</a></div>"; 
			}
			
		}
		$html.=$form->getFormk();	
		$html.="</td></tr></table>";

		return $html;

	}
		

	//aktywowanie konta (3)
	public function pt(){

		echo tab_nagl(konf::get()->langTexty("login_aktyw_form"),1);
		echo "<tr><td class=\"tlo3 lewa\">";
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"aktyw","aktyw");
		
		echo $form->spr(array(1=>"id_u",2=>"sprcheck"));
		echo $form->getFormp();
		echo $form->przenies(array("akcja"=>"u_potwierdz"));
		
		echo konf::get()->langTexty("login_aktyw_aktywuj")."<br /><br />";
		echo $form->input("text","id_u","id_u","","f_sredni",12);		
		echo interfejs::label("id_u",konf::get()->langTexty("login_aktyw_id"),"",true);					
		echo "<br />";
		
		echo $form->input("text","sprcheck","sprcheck","","f_dlugi",60);	
		echo interfejs::label("sprcheck",konf::get()->langTexty("login_aktyw_check"),"",true);						
		echo "<br />";
		echo $form->input("submit","","",konf::get()->langTexty("login_aktyw_wys"),"formularz2 f_krotki");		
		echo $form->getFormk();
		
		echo "</td></tr>";
		echo tab_stop();

	}


	public function pt2(){

		$id_u=tekstForm::doSql(konf::get()->getZmienna("id_u","id_u"));
		$sprcheck=tekstForm::doSql(konf::get()->getZmienna("sprcheck","sprcheck"));	
		
		$ok=false;
		
		$dane=konf::get()->_bazasql->pobierzRekord("SELECT status,id FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE id='".$id_u."' AND sprcheck='".$sprcheck."'");

		if(!empty($dane)){
			
			if($dane['status']==2){
				konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." SET status='".konf::get()->getKonfigTab("u_konf",'status_domyslny')."' WHERE id='".$id_u."' AND sprcheck='".$sprcheck."'");
				konf::get()->setKomunikat(konf::get()->langTexty("login_dziekujemy"),"");
				user::get()->zapiszLog(konf::get()->langTexty("login_potwierdzenie_log"),"",$id_u,"");
			} else {
				konf::get()->setKomunikat(konf::get()->langTexty("login_uaktywnione"),"error");
			}
			
			konf::get()->setAkcja("u_zaloguj");
			
		} else {
		
			konf::get()->setKomunikat(konf::get()->langTexty("login_uaktyw_nie")." ".konf::get()->langTexty("login_uaktyw_nief"),"error");	
			konf::get()->setAkcja("u_pt");		
				
		}

	}


	//odzyskiwanie konta (1)
	public function od(){

		if(konf::get()->getKonfigTab("u_konf",'odzysk')){
		
			echo tab_nagl(konf::get()->langTexty("login_odzysk"),1);
			echo "<tr><td class=\"tlo3 lewa\">";

			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"odzysk","odzysk");
		
			echo $form->spr(array(1=>"login"));
			echo $form->getFormp();
			echo $form->przenies(array("akcja"=>"u_od2"));

			echo konf::get()->langTexty("login_odzysk_form")."<br /><br />";
			
			echo $form->input("text","login","login","","f_dlugi",60);		
			echo interfejs::label("login",konf::get()->langTexty("login_odzysk_podaj"),"",true);								
			echo "<br />";
			echo $form->input("submit","","",konf::get()->langTexty("login_odzysk_wys"),"formularz2 f_krotki");			
	 		echo $form->getFormk();
			
			echo "</td></tr>".tab_stop();
			
		}

	}


	//odzyskiwanie konta(2)
	public function od2(){

		$login=tekstForm::doSql(konf::get()->getZmienna('login'));	
		
		if(konf::get()->getKonfigTab("u_konf",'odzysk')&&!empty($login)){	
		
			if (konf::get()->getKonfigTab("u_konf",'email_login')) {
				$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE email='".$login."' LIMIT 0,1");
			} else {
				$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE login='".$login."' LIMIT 0,1");		
			}
		  
			//jesli znaleziono login
		  if(!empty($dane)){ 
			
				if($dane['status']==1&&(!konf::get()->getKonfigTab("u_konf",'autousuw')||$dane['typ']==1||$dane['last_log']>tekstForm::dniData(konf::get()->getKonfigTab("u_konf",'autousuw')))){
				
					$tresc=konf::get()->langTexty("login_odzysk_temail1")." ".konf::get()->getKonfigTab('nazwa_www')." ( ".konf::get()->getKonfigTab('adres_www')." )\n\n";
					$tresc.=konf::get()->langTexty("login_odzysk_temail2")." ".$dane['login']." ) ".konf::get()->langTexty("login_odzysk_temail3")."\n";
					$tresc.=konf::get()->getKonfigTab('adres_www').konf::get()->getKonfigTab("plik")."?akcja=u_od3&id_u=".$dane['id']."&sprcheck=".md5($dane['email'].$dane['haslo'])."\n\n";
					
					if(!empty($dane['email'])){
					
						require_once(konf::get()->getKonfigTab('klasy')."class.wyslijemail.php");
															
						$wyslij=new wyslijemail(konf::get()->langTexty("login_odzysk_temail"),$tresc,$dane['email']);
						$wyslij->setNadawca(konf::get()->getKonfigTab('kontakt_email'),konf::get()->getKonfigTab('kontakt_nadawca'));	
						$wyslij->wykonaj();						
						konf::get()->setKomunikat(konf::get()->langTexty("login_odzysk_temail4"),"");
						
					} else{
						konf::get()->setKomunikat(konf::get()->langTexty("login_odzysk_temail5"),"error");
					} 
					
				} else {
					konf::get()->setKomunikat(konf::get()->langTexty("login_odzysk_temail6"),"error"); 
				}
				
			} else {  	
				konf::get()->setKomunikat(konf::get()->langTexty("login_odzysk_temail7"),"error"); 
			}
			
		  user::get()->zapiszLog(konf::get()->langTexty("login_odzysk_temail_kom"),$login);
		
		}
			
	}


	//odzyskiwanie konta (3)
	public function od3(){

		$id_u=tekstForm::doSql(konf::get()->getZmienna('id_u','id_u'));	
		$sprcheck=tekstForm::doSql(konf::get()->getZmienna('sprcheck','sprcheck'));		
		
		if(konf::get()->getKonfigTab("u_konf",'odzysk')&&!empty($id_u)&&!empty($sprcheck)){
		
			$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE id='".$id_u."' LIMIT 0,1");
			
		  if(!empty($dane)){ //jesli znaleziono login

				if(konf::get()->_bazasql->policz("id", " FROM ".konf::get()->getKonfigTab("sql_tab",'logi')." WHERE login='".$dane['login']."' AND idtf='b_odzysk' AND kiedy>'".tekstForm::dniData(60,"i","-")."'")<konf::get()->getKonfigTab("u_konf",'max_bad_log')){
				
					if(md5($dane['email'].$dane['haslo'])==$sprcheck){
					
						if($dane['status']==1&&(!konf::get()->getKonfigTab("u_konf",'autousuw')||$dane['typ']==1||$dane['last_log']>tekstForm::dniData(konf::get()->getKonfigTab("u_konf",'autousuw')))){
						
							echo tab_nagl(konf::get()->langTexty("login_odzysk_temail8"),1);
							echo "<tr><td class=\"tlo3 lewa\">";

							?><script type="text/javascript">						
							function spr_odu(){							
								ok=true;								
								if(document.odzysk_3.haslo.value!=document.odzysk_3.haslo_2.value) {									 	
									form_set_error("haslo",'<?php echo htmlspecialchars(konf::get()->langTexty("login_odzysk_temail9")); ?>');																						
								}									
								return ok;								
							}								
							</script><?php														
							
							$form=new formularz("post",konf::get()->getKonfigTab("plik"),"odzysk_3","odzysk_3");
							echo $form->spr(array(1=>"haslo",2=>"haslo_2"),""," spr_odu(); ");
							echo $form->getFormp();
							echo $form->przenies(array("akcja"=>"u_od4","id_u"=>$id_u,"sprcheck"=>$sprcheck));
							
							echo konf::get()->langTexty("login_odzysk_temail10")."<br /><br />";
							echo konf::get()->langTexty("login_odzysk_tlogin")." <span class=\"grube\">".$dane['login']."</span><br />";
							
							echo $form->input("password","haslo","haslo","","f_dlugi",32);		
							echo interfejs::label("haslo",konf::get()->langTexty("login_odzysk_temail11"),"",true);																			
							echo "<br />";
							
							echo $form->input("password","haslo_2","haslo_2","","f_dlugi",32);		
							echo interfejs::label("haslo_2",konf::get()->langTexty("login_odzysk_temail12"),"",true);								
							echo "<br />";
							
							echo $form->input("submit","","",konf::get()->langTexty("login_odzysk_temail_wys"),"formularz2 f_krotki");	
							echo $form->getFormk();
							
							echo "</td></tr>".tab_stop();
							
						} else { 
							konf::get()->setKomunikat(konf::get()->langTexty("login_odzysk_temail13"),"error"); 
						}
						
					} else { 
						user::get()->zapiszLog(konf::get()->langTexty("login_odzysk_b_kom"),'',"b_odzysk"); 
					}
					
				} else { 
					konf::get()->setKomunikat(konf::get()->langTexty("login_odzysk_temail14"),"error"); 
				}
				
			} else { 
				konf::get()->setKomunikat(konf::get()->langTexty("login_odzysk_temail15"),"error"); 
			}

		}

	}

	//zapisuje zmiane przy odzyskiwaniu konta
	public function od4(){
	
		$id_u=tekstForm::doSql(konf::get()->getZmienna('id_u'));	
		$sprcheck=tekstForm::doSql(konf::get()->getZmienna('sprcheck'));		
		$haslo=tekstForm::doSql(konf::get()->getZmienna('haslo'));	
		$haslo_2=tekstForm::doSql(konf::get()->getZmienna('haslo_2'));	
				
		if(konf::get()->getKonfigTab("u_konf",'odzysk')&&!empty($id_u)&&!empty($sprcheck)&&!empty($haslo)){


			if($haslo==$haslo_2&&user::get()->frazaCheck($haslo,konf::get()->getKonfigTab("u_konf",'haslo_dl'))){

				$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE id='".$id_u."' LIMIT 0,1");

		  	if(!empty($dane)){ //jesli znaleziono login
				
					userdane::get()->setDane($dane);		
					$login=userdane::get()->loginLog();

					if(konf::get()->_bazasql->policz("id", " FROM ".konf::get()->getKonfigTab("sql_tab",'logi')." WHERE login='".$login."' AND idtf='b_odzysk' AND kiedy>'".tekstForm::dniData(60,"i","-")."'")<konf::get()->getKonfigTab("u_konf",'max_bad_log')){
					
						if(md5($dane['email'].$dane['haslo'])==$sprcheck){
						
					    user::get()->zapiszLog(konf::get()->langTexty("login_odzysk_temail_kom"),$dane['login']);					
						
							if($dane['status']==1&&(!konf::get()->getKonfigTab("u_konf",'autousuw')||$dane['typ']==1||$dane['last_log']>tekstForm::dniData(konf::get()->getKonfigTab("u_konf",'autousuw')))){
						
								konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." SET haslo='".user::get()->hasloForma($haslo)."' WHERE id='".$id_u."'");	
								konf::get()->setKomunikat(konf::get()->langTexty("login_odzysk_z_kom"),"");
								
							} else { 
								konf::get()->setKomunikat(konf::get()->langTexty("login_odzysk_temail13"),"error");
							}
							
						} else { 
							user::get()->zapiszLog(konf::get()->langTexty("login_odzysk_b_kom"),$login,'b_odzysk'); 
						}
						
		  		} else { 
						konf::get()->setKomunikat(konf::get()->langTexty("login_odzysk_temail14"),"error"); 
					}
					
				} else { 
					konf::get()->setKomunikat(konf::get()->langTexty("login_odzysk_temail15"),"error"); 
				}

			} else { 
				konf::get()->setKomunikat(konf::get()->langTexty("login_odzysk_temail16"),"error"); 
			}
			
		}
		
	}
	

	//formularz edycja/dodawanie kont
	private function formularz(){

		$id_u=tekstForm::doSql(konf::get()->getZmienna('id_u','id_u'));		
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');	
		$szuk_typ=konf::get()->getZmienna('szuk_typ','szuk_typ');			
		$u_sort=konf::get()->getZmienna('u_sort','u_sort');	
		$woj_tab=konf::get()->getKonfigTab("woj_tab");	
		$lang2_tab=konf::get()->getKonfigTab("tab_lang2");		
		$statusy_tab=konf::get()->getKonfigTab("u_konf",'statusy_tab');	
		$plec_tab=konf::get()->getKonfigTab("u_konf",'plec_tab');	
		$typy_tab=konf::get()->getKonfigTab("u_konf",'typy_tab');	
		
		//czy ograniczac formularz o dane edytowane osobno
		//powoduje to ze haslo, email edytuje sie w osobnych formularzach		
		$zmianarozbita=false;		
		if(user::get()->zalogowany()&&!user::get()->adminU()&&konf::get()->getKonfigTab("u_konf",'zmianarozbita')){
			$zmianarozbita=true;
		}	
		
		//czy mozna zmianiac login
		$zmianalogin=true;
		if(user::get()->zalogowany()&&!konf::get()->langTexty("zmianalogin")&&!user::get()->adminU()){		
			$zmianalogin=false;
		}
				
		$dane['login']="";
		$dane['haslo']="";			
		$dane['email']="";								
		$dane['imie']=""; 
		$dane['nazwisko']=""; 	
		$dane['ur_rok']=""; 
		$dane['ur_mc']=""; 			
		$dane['ur_dzien']=""; 			
		$dane['plec']=""; 
		$dane['woj']=""; 
		$dane['telefon']="";
		$dane['skype']="";
		$dane['miejscowosc']=""; 			
		$dane['ulica']="";
		$dane['nr_domu']="";
		$dane['nr_mieszkania']="";
		$dane['kod_pocztowy']="";		
		$dane['firma']="";	
		$dane['firma_nazwa']="";					
		$dane['firma_miejscowosc']=""; 			
		$dane['firma_ulica']="";
		$dane['firma_nr_domu']="";
		$dane['firma_nr_mieszkania']="";
		$dane['firma_kod_pocztowy']="";		
		$dane['nip']="";								
		$dane['gg']=""; 
		$dane['www']=""; 
		$dane['opis']=""; 
		$dane['omnie']=""; 
		$dane['zainteresowania']=""; 				
		$dane['praca']=""; 		
		$dane['status']=1; 		
		
		if(!empty($szuk_typ)){
			$dane['typ']=$szuk_typ;		
		} else {
			$dane['typ']=konf::get()->getKonfigTab("u_konf",'typy_domyslny');
		}
		$dane['lang2']="";
		$dane['punkty']=0;
		$dane['glosy_suma']=0;			
		$dane['glosy_ile']=0;					
		$dane['niewygasa']="";
		$dane['zgoda_regulamin']=0;
		$dane['zgoda_osobowe']=0;			

		if(user::get()->adminU()){
			$dane['typ']=konf::get()->getKonfigTab("u_konf",'typy_admindomyslny');
		}
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"u_dodaj","u_dodaj");	
		$dane=$form->odczyt($dane);
			
		if(user::get()->zalogowany()&&(!user::get()->adminU()||(empty($id_u)&&konf::get()->getAkcja()!="u_dodaj"))){
			$id_u=user::get()->id();
		} else if(!user::get()->zalogowany()) {
			$id_u="";
		}
		
		//sprawdzamy dostepnosc formularza
		if(user::get()->filtr(2)&&(user::get()->adminU()||(konf::get()->getAkcja()=="u_dodaj"&&!konf::get()->getKonfigTab("u_konf",'tylko_admin')&&!user::get()->zalogowany())||(user::get()->zalogowany()&&konf::get()->getAkcja()=="u_edytuj"&&$id_u==user::get()->id()))){
		
			if(konf::get()->getAkcja()!="u_dodaj"){

				//pobieramy dotychczasowe dane				
				if($id_u==user::get()->id()){
					$dane2=user::get()->getDane();
				} else {
					$dane2=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE id='".$id_u."'".user::get()->getSqlAdd());
				}
				
				if(!empty($dane2)){
				
					$dane=$dane2;
					
				} else {

					$id_u="";
					
				}

			}
			
			$this->menuEdycja($id_u);
			
			if(konf::get()->getAkcja()=="u_dodaj"){			
				echo tab_nagl(konf::get()->langTexty("login_u_zakladanie"));							
			} else {	
				echo tab_nagl(konf::get()->langTexty("login_u_edycja"));
			}														
			
			echo "<tr><td class=\"tlo3 lewa\">";
			
			if(konf::get()->getKonfigTab("u_konf",'firma')){		
			
				$js="<script type=\"text/javascript\">\n";
				$js.="function checkFirma(){\n";
				$js.="firma=document.getElementById('firma');";
				$js.="if(firma.checked){\n";
				$js.="document.getElementById('firma_opis').style.display='';\n";				
				$js.="} else {\n";
				$js.="document.getElementById('firma_opis').style.display='none';\n";							
				$js.="}\n";				
				$js.="}\n";
				$js.="</script>\n";
				
				konf::get()->setKod("kodheader",$js);	
			
			}	
			
			$this->menu($dane);
			
			echo "<div class=\"nowa_l\">";
			
			?><script type="text/javascript">
		
			function spr_formu(){		
			
			<?php			
			if($zmianalogin){
			?>						
			document.u_dodaj.login.value=document.u_dodaj.login.value.trim();			
			<?php
			}
			
			if(!$zmianarozbita){
			?>			
			document.u_dodaj.haslo.value=document.u_dodaj.haslo.value.trim();
			document.u_dodaj.email.value=document.u_dodaj.email.value.trim();						
			<?php					
			}	
			
			if($zmianalogin){			
				echo "if(document.u_dodaj.login.value.length<".konf::get()->getKonfigTab("u_konf",'login_dl')."){ \n";	
				echo "	form_set_error('login','".htmlspecialchars(konf::get()->langTexty("login_u_loginza"))."');\n";
				echo "}\n";			
			}
									
			if(!$zmianarozbita){
			
				echo "if(document.u_dodaj.haslo.value.length<".konf::get()->getKonfigTab("u_konf",'haslo_dl')."&&document.u_dodaj.haslo.value.length>0){ \n";	
				echo "	form_set_error('haslo','".htmlspecialchars(konf::get()->langTexty("login_u_hasloza"))."');\n";
				echo "}\n";		
				
				echo "if(document.u_dodaj.haslo.value!=document.u_dodaj.haslo_2.value) { \n";	
				echo "	form_set_error('haslo','".htmlspecialchars(konf::get()->langTexty("login_u_hasla"))."');\n";
				echo "}\n";					

				echo "if(!spr_email(document.u_dodaj.email.value)) { \n";	
				echo "	form_set_error('email','".htmlspecialchars(konf::get()->langTexty("login_u_bemail"))."');\n";
				echo "}\n";		
				
			}

			if(konf::get()->getAkcja()=="u_dodaj"&&!user::get()->adminU()){			
			
				if(konf::get()->getKonfigTab("u_konf",'zgoda_regulamin'))	{
				
					echo "if(!document.u_dodaj.zgoda_regulamin.checked){ \n";	
					echo "	form_set_error('zgoda_regulamin','".htmlspecialchars(konf::get()->langTexty("login_u_regulamina"))."');\n";
					echo "}\n";				
			
				}
				
				if(konf::get()->getKonfigTab("u_konf",'zgoda_osobowe'))	{
				
					echo "if(!document.u_dodaj.zgoda_osobowe.checked){ \n";	
					echo "	form_set_error('zgoda_osobowe','".htmlspecialchars(konf::get()->langTexty("login_u_osobowea"))."');\n";
					echo "}\n";								
			
				}
				
			}
			

			?>
			}
			</script><?php			
			
			$form->setMultipart(true);	
			
			$spr=array();
			
			if($zmianalogin){
				$spr[1]="login";
			}
			
			if(!$zmianarozbita){	
						
				if(konf::get()->getAkcja()=="u_dodaj"){
					
					$spr[2]="haslo";				
					$spr[3]="haslo_2";						
					$spr[4]="email";				

				} else {
				
					$spr[2]="email";	
					
				}			
				
			}
									
			if(konf::get()->getKonfigTab("strona_typ")=="sklep"){	
				$spr[]="imie";
				$spr[]="nazwisko";				
				$spr[]="miejscowosc";						
				$spr[]="kod_pocztowy";						
				$spr[]="ulica";						
				$spr[]="nr_domu";						
			}			
			
			echo $form->spr($spr,""," spr_formu(); ");			
			echo $form->getFormp();
			echo $form->przenies(array("u_sort"=>$u_sort,"podstrona"=>$podstrona,"akcja"=>konf::get()->getAkcja()."2","id_u"=>$id_u,"szuk_typ"=>$szuk_typ));
			
			if(user::get()->adminU()){			
				echo "<div>";
				echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");					
				echo "</div><br />";				
			}				
				
			if($zmianalogin){		
				echo $form->input("text","login","login",$dane['login'],"f_dlugi",32);	
				echo interfejs::label("login",konf::get()->langTexty("login_u_login"),"",true);				
				echo "<br />";	
				echo "<div class=\"male\">".konf::get()->langTexty("login_u_loginmusi")." ";
				echo konf::get()->getKonfigTab("u_konf",'login_dl')." ".konf::get()->langTexty("login_u_loginmusi2")."</div><br />";													
			} else {
				echo $form->input("text","login","login",$dane['login'],"f_dlugi",32);	
				echo interfejs::label("login",konf::get()->langTexty("login_u_login"),"",true);				
				echo "Twój login: <span class=\"grube\">".$dane['login']."</span><br />";					
			}
						
			if(!$zmianarozbita){	
							
				echo $form->input("password","haslo","haslo","","f_dlugi",32," autocomplete=\"off\"");
				echo interfejs::label("haslo",konf::get()->langTexty("login_u_haslo"),"",true);								
				echo "<br />";
				
				echo $form->input("password","haslo_2","haslo_2","","f_dlugi",32," autocomplete=\"off\"");	
				echo interfejs::label("haslo_2",konf::get()->langTexty("login_u_haslo2"),"",true);						
				echo "<div class=\"male\">".konf::get()->langTexty("login_u_haslomusi")." ";
				echo konf::get()->getKonfigTab("u_konf",'haslo_dl')." ".konf::get()->langTexty("login_u_haslomusi2")."</div>";
				
				if(konf::get()->getAkcja()=="u_edytuj"){ 
					echo "<div class=\"grube\">".konf::get()->langTexty("login_u_uwaga")."</div>"; 
				}

				echo "<br />";		
				echo $form->input("text","email","email",$dane['email'],"f_dlugi",60);
				echo interfejs::label("email",konf::get()->langTexty("login_u_email"),"",true);
				echo "<br />";
				
				if(!konf::get()->getKonfigTab("u_konf",'new_aktywne')){ 
					echo "<div class=\"male\">".konf::get()->langTexty("login_u_wymagany")."</div><br />"; 
				}

				echo "<br />";
			
			}
			
			echo "<h2>".konf::get()->langTexty("login_u_dosobowe")."</h2>";

			echo $form->input("text","imie","imie",$dane['imie'],"f_dlugi",40);
			echo interfejs::label("imie",konf::get()->langTexty("login_u_imie"),"",true);	
			if(konf::get()->getKonfigTab("strona_typ")=="sklep"){					
				echo "*";
			}
			echo "<br />";
			
			echo $form->input("text","nazwisko","nazwisko",$dane['nazwisko'],"f_dlugi",60);
			echo interfejs::label("nazwisko",konf::get()->langTexty("login_u_nazwisko"),"",true);				
			if(konf::get()->getKonfigTab("strona_typ")=="sklep"){				
				echo "*";
			}				
			echo "<br /><br />";			

			if(konf::get()->getKonfigTab("u_konf",'rozs')){
						
				if(konf::get()->getKonfigTab("strona_typ")!="sklep"){	
													
					echo interfejs::label("ur",konf::get()->langTexty("login_u_dataur"),"",true);
					
					echo "<div id=\"ur\">";	
							
					echo $form->selectWylicz("ur_rok","ur_rok",1900,date("Y"),$dane['ur_rok'],"f_krotki","--");
					echo " - ";
					echo $form->selectWylicz("ur_mc","ur_mc",1,12,$dane['ur_mc'],"f_krotki","--");
					echo " - ";
					echo $form->selectWylicz("ur_dzien","ur_dzien",1,31,$dane['ur_dzien'],"f_krotki","--");

					echo "<br /><br />";
					echo $form->select("plec","plec",$plec_tab,$dane['plec'],"f_sredni","--");
					
					echo interfejs::label("plec",konf::get()->langTexty("login_u_plec"),"",true);
					echo "</div><br />";					
					
				}				
									
				echo "<h2>".konf::get()->langTexty("login_u_dadresowe")."</h2>";				
				
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
				
				echo "<tr class=\"lewa\">";
				echo "<td>";
				echo interfejs::label("miejscowosc",konf::get()->langTexty("login_u_miejscowosc"));	
				if(konf::get()->getKonfigTab("strona_typ")=="sklep"){				
					echo "*";
				}				
				echo "</td>";
				echo "<td>";
				echo interfejs::label("kod_pocztowy",konf::get()->langTexty("login_u_kodpocztowy"));
				if(konf::get()->getKonfigTab("strona_typ")=="sklep"){					
					echo "*";
				}				
				echo "</td>";								
				echo "</tr>";
				
				echo "<tr class=\"lewa\">";
				echo "<td>";
				echo $form->input("text","miejscowosc","miejscowosc",$dane['miejscowosc'],"f_dlugi",100);					
				echo " &nbsp;</td>";
				echo "<td>";
				echo $form->input("text","kod_pocztowy","kod_pocztowy",$dane['kod_pocztowy'],"f_krotki",10);					
				echo " &nbsp;</td>";						
				echo "</tr>";				
			
				echo "</table><br />";	

				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
				
				echo "<tr class=\"lewa\">";
				echo "<td>";
				echo interfejs::label("ulica",konf::get()->langTexty("login_u_ulica"));				
				if(konf::get()->getKonfigTab("strona_typ")=="sklep"){					
					echo "*";
				}				
				echo "</td>";
				echo "<td>";
				echo interfejs::label("nr_domu",konf::get()->langTexty("login_u_nrdomu"));						
				if(konf::get()->getKonfigTab("strona_typ")=="sklep"){				
					echo "*";
				}				
				echo "</td>";				
				echo "<td>";				
				echo interfejs::label("nr_mieszkania",konf::get()->langTexty("login_u_nrmieszkania"));
				echo "</td>";						
				echo "</tr>";
				
				echo "<tr class=\"lewa\">";
				echo "<td>";
				echo $form->input("text","ulica","ulica",$dane['ulica'],"f_dlugi",150);						
				echo " &nbsp; </td>";
				echo "<td>";
				echo $form->input("text","nr_domu","nr_domu",$dane['nr_domu'],"f_krotki",10);						
				echo " &nbsp; </td>";			
				echo "<td>";
				echo $form->input("text","nr_mieszkania","nr_mieszkania",$dane['nr_mieszkania'],"f_krotki",10);						
				echo "</td>";					
				echo "</tr>";				
			
				echo "</table><br />";		
								
				echo $form->select("woj","woj",$woj_tab,$dane['woj'],"f_dlugi","--");				
				echo interfejs::label("woj",konf::get()->langTexty("login_u_woj"),"",true);	
				echo "<br /><br />";			
								
				echo "<h2>".konf::get()->langTexty("login_u_dkontaktowe")."</h2>";				
				
				echo $form->input("text","telefon","telefon",$dane['telefon'],"f_dlugi",50);		
				echo interfejs::label("telefon",konf::get()->langTexty("login_u_telefon"),"",true);										
				echo "<br />";							

				echo $form->input("text","gg","gg",$dane['gg'],"f_dlugi",15);		
				echo interfejs::label("gg",konf::get()->langTexty("login_u_gg"),"",true);					
				echo "<br />";			
				
				echo $form->input("text","skype","skype",$dane['skype'],"f_dlugi",150);			
				echo interfejs::label("skype",konf::get()->langTexty("login_u_skype"),"",true);									
				echo "<br /><br />";							

				if(konf::get()->getKonfigTab("u_konf",'firma')){		
						
					echo $form->checkbox("firma","firma",1,$dane['firma'],""," onclick=\"checkFirma()\"");		
					echo interfejs::label("firma",konf::get()->langTexty("login_u_firma")." firma lub instytucja","",true);					
					echo "<br /><br />";						
				
					echo "<div id=\"firma_opis\" ";
					if(empty($dane['firma'])){
						echo " style=\"display:none;\"";
					}
					echo ">";				
				
					echo "<h2>Dane firmy / instytucji (dane na fakturę):</h2>";		
									
					echo interfejs::label("firma_nazwa",konf::get()->langTexty("login_u_nazwa"));
					echo "<br />";						
					echo $form->input("text","firma_nazwa","firma_nazwa",$dane['firma_nazwa'],"f_bdlugi",200);
					echo "<br /><br />";			
					
					echo "NIP:<br />";						
					echo $form->input("text","nip","nip",$dane['nip'],"f_dlugi",20);
					echo "<br /><br />";							
					
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
					
					echo "<tr class=\"lewa\">";
					echo "<td>";
					echo interfejs::label("firma_miejscowosc",konf::get()->langTexty("login_u_miejscowosc"));										
					echo "</td>";
					
					echo "<td>";
					echo interfejs::label("firma_kod_pocztowy",konf::get()->langTexty("login_u_kodpocztowy"));
					echo "</td>";								
					echo "</tr>";
					
					echo "<tr class=\"lewa\">";
					echo "<td>";
					echo $form->input("text","firma_miejscowosc","firma_miejscowosc",$dane['firma_miejscowosc'],"f_dlugi",100);					
					echo " &nbsp;</td>";
					
					echo "<td>";
					echo $form->input("text","firma_kod_pocztowy","firma_kod_pocztowy",$dane['firma_kod_pocztowy'],"f_krotki",10);					
					echo " &nbsp;</td>";						
					echo "</tr>";				
				
					echo "</table><br />";	

					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
					
					echo "<tr class=\"lewa\">";
					
					echo "<td>";
					echo interfejs::label("firma_ulica",konf::get()->langTexty("login_u_ulica"));										
					echo "</td>";
		
					echo "<td>";
					echo interfejs::label("firma_nr_domu",konf::get()->langTexty("login_u_nrdomu"));					
					echo "</td>";		
							
					echo "<td>";
					echo interfejs::label("firma_nr_mieszkania",konf::get()->langTexty("login_u_nrmieszkania"));
					echo "</td>";				
							
					echo "</tr>";
					
					echo "<tr class=\"lewa\">";
					echo "<td>";
					echo $form->input("text","firma_ulica","firma_ulica",$dane['firma_ulica'],"f_dlugi",150);						
					echo " &nbsp; </td>";
					echo "<td>";
					echo $form->input("text","firma_nr_domu","firma_nr_domu",$dane['firma_nr_domu'],"f_krotki",10);						
					echo " &nbsp; </td>";			
					echo "<td>";
					echo $form->input("text","firma_nr_mieszkania","firma_nr_mieszkania",$dane['firma_nr_mieszkania'],"f_krotki",10);						
					echo "</td>";					
					echo "</tr>";				
				
					echo "</table><br />";			
					
					echo "</div>";
					
				}		
										
				echo interfejs::label("www",konf::get()->langTexty("login_u_www"));
				echo "<br />";
				echo $form->input("text","www","www",$dane['www'],"f_bdlugi",100);
				echo "<br /><br />";

				
			}

			if(konf::get()->getKonfigTab("u_konf",'img')){
							
				echo "<h2>".konf::get()->langTexty("login_u_dzdjecie")."</h2>";
										
			  if(!empty($dane['img'])){

					echo interfejs::imgPodglad($dane,"img",konf::get()->getKonfigTab("u_konf",'kat'),1);	
					
					echo "<div class=\"nobr\">";
					echo $form->checkbox("img_usun","img_usun",1,"");		
					echo interfejs::label("img_usun",konf::get()->langTexty("usung"),"",true);					
					echo "</div><br />"; 
					
			  }

				echo interfejs::label("pic",konf::get()->langTexty("login_u_form_grafika"));	
				echo "<br />";
				echo $form->input("file","pic","pic","","f_bdlugi");																						
				echo "<br /><br />";
			
			}
			
			
			if((user::get()->adminU()||konf::get()->getAkcja()=="u_edytuj")&&count($lang2_tab)>1){
			
				echo "<h2>".konf::get()->langTexty("login_u_ustawienia")."</h2>";		
							
				echo $form->select("lang2","lang2",$lang2_tab,$dane['lang2'],"f_krotki","--");				
				echo interfejs::label("lang2",konf::get()->langTexty("login_u_lang2"),"",true);									
				echo "<br /><br />";		
				
			}
						

			if(user::get()->adminU()){			
			
				if(konf::get()->getKonfigTab("u_konf",'opisowe')){	
				
					echo "<h2>Więcej o mnie</h2>";							
				
					echo interfejs::label("omnie","kilka słów o mnie:");										
					echo "<br />";		
					echo $form->textarea("omnie","omnie",$dane['omnie'],"f_bdlugi",8);					
					echo "<br /><br />";
					
					echo interfejs::label("zainteresowania","moje zainteresowania:");										
					echo "<br />";		
					echo $form->textarea("zainteresowania","zainteresowania",$dane['zainteresowania'],"f_bdlugi",5);					
					echo "<br /><br />";			
						
					echo interfejs::label("praca","praca:");										
					echo "<br />";		
					echo $form->textarea("praca","praca",$dane['praca'],"f_bdlugi",5);					
					echo "<br /><br />";		
					
				}	

				echo "<h2>".konf::get()->langTexty("login_u_administracyjne")."</h2>";					
				
				if(konf::get()->getAkcja()=="u_edytuj"){
				
					echo "<span class=\"male\">".konf::get()->langTexty("login_u_data_zal");
					echo " <span class=\"grube\">".$dane['autor_kiedy']."</span><br />";
					echo konf::get()->langTexty("login_u_zalogowany")." <span class=\"grube\">".$dane['last_log'];
					echo "</span>, ".konf::get()->langTexty("login_u_logowan")." <span class=\"grube\">".$dane['ile_log']."</span><br />";
					if(!empty($dane['last_bad_log'])&&$dane['last_bad_log']!="0000-00-00 00:00:00"){
						echo konf::get()->langTexty("login_u_niepoprawne")." <span class=\"grube\">".$dane['last_bad_log']."</span><br />";
					}

					echo konf::get()->langTexty("login_u_ostip")." <span class=\"grube\">".$dane['ip_log']."</span>, ".konf::get()->langTexty("login_u_osthost");
					echo " <span class=\"grube\">".$dane['host_log']."</span></span><br /><br />";
				}							
			
				if(konf::get()->getKonfigTab("u_konf",'punkty')){
					echo $form->input("text","punkty","punkty",$dane['punkty'],"f_krotki",8);				
					echo interfejs::label("punkty",konf::get()->langTexty("login_u_punkty"),"",true);					
					echo "<br />";
				}		
				
				if(konf::get()->getKonfigTab("u_konf",'glosy')){
				
					echo $form->input("text","glosy_suma","glosy_suma",$dane['glosy_suma'],"f_krotki",8);	
					echo interfejs::label("glosy_suma",konf::get()->langTexty("login_u_glosys"),"",true);														
					echo "<br />";
					
					echo $form->input("text","glosy_ile","glosy_ile",$dane['glosy_ile'],"f_krotki",6);	
					echo interfejs::label("glosy_ile",konf::get()->langTexty("login_u_glosyi"),"",true);													
					echo "<br />";	
									
				}						
				
				echo "<br />";
				
				echo interfejs::label("opis",konf::get()->langTexty("login_u_opis"));										
				echo "<br />";		
				echo $form->textarea("opis","opis",$dane['opis'],"f_bdlugi",5);					
				echo "<br />";

				if($id_u!=user::get()->id()){
				
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
					
					$typy_dostepni=konf::get()->getKonfigTab("u_konf",'typydostepni_tab');			
					$typy_tab2=array();

					if(!empty($typy_dostepni[$typ])){
						while(list($key,$val)=each($typy_dostepni[$typ])){
							if(!empty($typy_tab[$val])){
								$typy_tab2[$val]=$typy_tab[$val];
							}
						}
						
					}		

					echo $form->select("status","status",$statusy_tab2,$dane['status'],"f_dlugi",konf::get()->langTexty("wybierz"));			
					echo interfejs::label("status",konf::get()->langTexty("login_u_status"),"",true);								
					echo "<br />";
					
					echo $form->select("typ","typ",$typy_tab2,$dane['typ'],"f_dlugi",konf::get()->langTexty("wybierz"));
					echo interfejs::label("typ",konf::get()->langTexty("login_u_ty"),"",true);
					echo "<br />";					
	  	
	 				if(konf::get()->getKonfigTab("u_konf",'autousuw')){ 
						echo $form->checkbox("niewygasa","niewygasa",1,$dane['niewygasa']);	
						echo interfejs::label("niewygasa",konf::get()->langTexty("login_u_niewygasa"),"",true);							
						echo "<br />";
					}

				}					

			}
			
			if(konf::get()->getAkcja()=="u_dodaj"&&!user::get()->adminU()){		
			
 				if(konf::get()->getKonfigTab("u_konf",'zgoda_regulamin')){ 
					echo $form->checkbox("zgoda_regulamin","zgoda_regulamin",1,$dane['zgoda_regulamin']);		
					echo interfejs::label("zgoda_regulamin",konf::get()->langTexty("login_u_regulamin1")." ".konf::get()->langTexty("login_u_regulamin2"),"",true);											
					echo "<br />";
				}			
				
 				if(konf::get()->getKonfigTab("u_konf",'zgoda_osobowe')){ 
					echo $form->checkbox("zgoda_osobowe","zgoda_osobowe",1,$dane['zgoda_osobowe']);		
					echo interfejs::label("zgoda_osobowe",konf::get()->langTexty("login_u_osobowe"),"",true);
					echo "<br />";
				}							
					
			}			
			
			if(!user::get()->zalogowany()&&konf::get()->getKonfigTab("u_konf",'botproof')){
				echo $form->bootproof();
			}
			
			echo "<br />";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");					
			echo "<br /><br />";
			
			echo "<div class=\"male\">".konf::get()->langTexty("login_u_pozycje")."</div>";
			echo $form->getFormk();
			
			echo "</div>";
			
			echo "</td></tr>";
			
			echo tab_stop();

			if(user::get()->administrator()){
				echo tab_nagl("");
				echo "<tr class=\"srodek\"><td class=\"tlo4\">";
				if(user::get()->adminU()){ 
					echo interfejs::linkEl("group",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_arch")),konf::get()->langTexty("login_u_listau"));
				} else { 
					echo interfejs::linkEl("cog",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_panel")),konf::get()->langTexty("login_u_powrotp"));
				}
				echo "</td></tr>";
				echo tab_stop();			
			}
			
		}

	}
	
	
	public function edytuj(){
	
		$this->formularz();
		
	}
	
	
	public function dodaj(){
		
		$this->formularz();
		
	}

	//dodanie konta
	private function zapisz(){

		$id_u=tekstForm::doSql(konf::get()->getZmienna('id_u'));	
		
		//domyslnie edytujemy swoje konto
		if(user::get()->zalogowany()&&(!user::get()->adminU()||(empty($id_u)&&konf::get()->getAkcja()!="u_dodaj2"))){
			$id_u=user::get()->id();
		} else if(!user::get()->zalogowany()) {
			$id_u="";
		}
		
		//czy mozna tutaj zieniac email i haslo
		$zmianarozbita=false;		
		if(user::get()->zalogowany()&&!user::get()->adminU()&&konf::get()->getKonfigTab("u_konf",'zmianarozbita')){
			$zmianarozbita=true;
		}		
		
		//czy mozna zmieniac login
		$zmianalogin=true;
		if(user::get()->zalogowany()&&!konf::get()->langTexty("zmianalogin")&&!user::get()->adminU()){		
			$zmianalogin=false;
		}							
				
		$woj_tab=konf::get()->getKonfigTab("woj_tab");	
		$lang2_tab=konf::get()->getKonfigTab("tab_lang2");	
		$statusy_tab=konf::get()->getKonfigTab("u_konf",'statusy_tab');		
		$typy_tab=konf::get()->getKonfigTab("u_konf",'typy_tab');					
		$plec_tab=konf::get()->getKonfigTab("u_konf",'plec_tab');			
		$typydostepni_tab=konf::get()->getKonfigTab("u_konf",'typydostepni_tab');				
		$typystatusydostepni_tab=konf::get()->getKonfigTab("u_konf",'typystatusydostepni_tab');				
		$img_usun=konf::get()->getZmienna("img_usun");		
		$haslo=tekstForm::doSql(konf::get()->getZmienna("haslo"));
		$haslo_2=tekstForm::doSql(konf::get()->getZmienna("haslo_2"));
		$status=tekstForm::doSql(konf::get()->getZmienna("status"));		
				
		$dane=array();	
		
		if($zmianalogin){				
			$dane["login"]="";		
		}
		
		if(!$zmianarozbita){	
			$dane['email']="";			
		}
		
		$dane['imie']="";
		$dane['nazwisko']="";

		$testy[]=array("zmienna"=>"login","test"=>"oczysc2");		
		
		if($zmianalogin){	
		
			$testy[]=array("zmienna"=>"login","test"=>"wartosc","wymagany"=>true,
				"param"=>array(
					"mindl"=>konf::get()->getKonfigTab("u_konf",'login_dl'),
					"komunikat"=>konf::get()->langTexty("login_u_brakdanychl1"),
					'idtf'=>"login"
				)	
			);		

			$testy[]=array("zmienna"=>"login","test"=>"wartosc","wymagany"=>true,
				"param"=>array(
					"reg"=>"^[a-zA-Z0-9_\-]+$",
					"komunikat"=>konf::get()->langTexty("login_u_brakdanychl2"),
					'idtf'=>"login"
				)	
			);	
			
		}
		
		if(!$zmianarozbita){								
			
			$testy[]=array("zmienna"=>"email","test"=>"wartosc","wymagany"=>true,
				"param"=>array(
					"komunikat"=>konf::get()->langTexty("login_u_brakdanychl3"),
					"reg"=>tekstForm::getEmailForma(),
					'idtf'=>"email"
				)	
			);
			
		}	
		
		$testy[]=array("zmienna"=>"lang2","test"=>"wtablicyi",
			"param"=>array(
				"wartosci"=>$lang2_tab,
				"domyslny"=>konf::get()->getKonfigTab("lang2_default")
			)
		);		

		
		if(konf::get()->getAkcja()=="u_dodaj2"&&!user::get()->adminU()){			

			//regulamin
			if(konf::get()->getKonfigTab("u_konf",'zgoda_regulamin'))	{
			
				$dane['zgoda_regulamin']="";		
				
				$testy[]=array("zmienna"=>"zgoda_regulamin","test"=>"truefalse",
					"param"=>array(
						"wartosc"=>1
					)
				);							
				
				$testy[]=array("zmienna"=>"zgoda_regulamin","test"=>"wartosc","wymagany"=>true,
					"param"=>array(
						"komunikat"=>konf::get()->langTexty("login_u_brakregulamin"),
						'idtf'=>"zgoda_regulamin"
					)	
				);								
			}
			
			//dane osobowe
			if(konf::get()->getKonfigTab("u_konf",'zgoda_osobowe'))	{
			
				$dane['zgoda_osobowe']="";		
				
				$testy[]=array("zmienna"=>"zgoda_osobowe","test"=>"truefalse",
					"param"=>array(
						"wartosc"=>1
					)
				);							
				
				$testy[]=array("zmienna"=>"zgoda_osobowe","test"=>"wartosc","wymagany"=>true,
					"param"=>array(
						"komunikat"=>konf::get()->langTexty("login_u_brakosobowe"),
						'idtf'=>"zgoda_osobowe"
					)	
				);								
			}
			
		}
		
		if(konf::get()->getKonfigTab("u_konf",'opisowe')&&user::get()->adminU()){			
		
			$dane['omnie']=""; 
			$dane['zainteresowania']=""; 				
			$dane['praca']=""; 			
			
		}
		
		if(konf::get()->getKonfigTab("u_konf",'firma')){	
		
			$dane=array_merge(array(
				'firma_nazwa'=>"",				
				'firma_miejscowosc'=>"", 			
				'firma_ulica'=>"",
				'firma_nr_domu'=>"",
				'firma_nr_mieszkania'=>"",
				'firma_kod_pocztowy'=>"",		
				'nip'=>"",														
				'firma'=>"",
			),$dane);			
			
			$testy[]=array("zmienna"=>"firma","test"=>"truefalse",
				"param"=>array(
					"wartosc"=>1
				)
			);							
			
		}	
		
		if(konf::get()->getKonfigTab("u_konf",'rozs')){	
		
			$dane=array_merge(array(
				'ur_rok'=>"", 
				'ur_mc'=>"", 				
				'ur_dzien'=>"", 				
				'plec'=>"", 
				'miejscowosc'=>"", 
				'ulica'=>"",
				'nr_domu'=>"",
				'nr_mieszkania'=>"",
				'kod_pocztowy'=>"",			
				'nip'=>"",														
				'telefon'=>"",
				'skype'=>"",				
				'woj'=>"", 
				'gg'=>"", 
				'www'=>"", 
			),$dane);		
			
			$testy[]=array("zmienna"=>"woj","test"=>"wtablicyi",
				"param"=>array(
					"wartosci"=>$woj_tab,
					"domyslny"=>0
				)
			);	
						
			$testy[]=array("zmienna"=>"gg","test"=>"wartosc",
				"param"=>array(
					"domyslny"=>"",
					"reg"=>"[0-9]{1,18}"				
				)
			);					
						
			$testy[]=array("zmienna"=>"plec","test"=>"wtablicyi",
				"param"=>array(
					"wartosci"=>$plec_tab,
					"domyslny"=>0
				)
			);			
			
			$testy[]=array("zmienna"=>"ur_rok","test"=>"liczba",
				"param"=>array(
					"min"=>1900,
					"max"=>date("Y"),
					"domyslny"=>0
				)
			);					

			
			$testy[]=array("zmienna"=>"ur_mc","test"=>"liczba",
				"param"=>array(
					"min"=>1,
					"max"=>12,
					"domyslny"=>0
				)
			);		
						
			$testy[]=array("zmienna"=>"ur_dzien","test"=>"liczba",
				"param"=>array(
					"min"=>1,
					"max"=>31,
					"domyslny"=>0
				)
			);			
			
		if(konf::get()->getKonfigTab("strona_typ")=="sklep"){			
						
				$testy[]=array("zmienna"=>"imie","test"=>"wartosc","wymagany"=>true,
					"param"=>array(
						'idtf'=>"imie"
					)	
				);		
				
				$testy[]=array("zmienna"=>"nazwisko","test"=>"wartosc","wymagany"=>true,
					"param"=>array(
						'idtf'=>"nazwisko"
					)	
				);						
				
				$testy[]=array("zmienna"=>"miejscowosc","test"=>"wartosc","wymagany"=>true,
					"param"=>array(
						'idtf'=>"miejsocwosc"
					)	
				);		
							
				$testy[]=array("zmienna"=>"kod_pocztowy","test"=>"wartosc","wymagany"=>true,
					"param"=>array(
						'idtf'=>"kod_pocztowy"
					)	
				);		
							
				$testy[]=array("zmienna"=>"ulica","test"=>"wartosc","wymagany"=>true,
					"param"=>array(
						'idtf'=>"ulica"
					)	
				);		
						
				$testy[]=array("zmienna"=>"nr_domu","test"=>"wartosc","wymagany"=>true,
					"param"=>array(
						'idtf'=>"nr_domu"
					)	
				);		
								
			}			
											
							
		}

		
		//dane podawane przez admina
	 	if(user::get()->adminU()){
					
			$dane['opis']="";
			$dane['niewygasa']=0;
			$dane['punkty']=0;
			$dane['glosy_suma']=0;
			$dane['glosy_ile']=0;
						
			$testy[]=array("zmienna"=>"punkty","test"=>"liczba",
				"param"=>array(
					"min"=>0,
					"domyslny"=>0
				)
			);					
						
			$testy[]=array("zmienna"=>"glosy_suma","test"=>"liczba",
				"param"=>array(
					"min"=>0,
					"domyslny"=>0
				)
			);		
						
						
			$testy[]=array("zmienna"=>"glosy_ile","test"=>"liczba",
				"param"=>array(
					"min"=>0,
					"domyslny"=>0
				)
			);		
														
			$testy[]=array("zmienna"=>"niewygasa","test"=>"truefalse",
				"param"=>array(
					"wartosc"=>1
				)
			);				

			//admin nie moze zmienic statusu i typu swojego konta												
			if($id_u!=user::get()->id()){
			
				$dane['typ']="";
				$dane['status']="";
								
				$typ=user::get()->getDane("typ");																	
				$statusy_tab2=array();
					
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
		
				$testy[]=array("zmienna"=>"typ","test"=>"wtablicyi",
					"param"=>array(
						"wartosci"=>$typy_tab2,
						"domyslny"=>konf::get()->getKonfigTab("u_konf","typy_admindomyslny")
					)
				);					
									
				$testy[]=array("zmienna"=>"status","test"=>"wtablicyi",
					"param"=>array(
						"wartosci"=>$statusy_tab2,
						"domyslny"=>1
					)
				);			
								
			}		
																
		}

		//filtr ip
		$ok=false;				
		if(user::get()->filtr(2)&&(user::get()->adminU()||(konf::get()->getAkcja()=="u_dodaj2"&&!konf::get()->getKonfigTab("u_konf",'tylko_admin')&&!user::get()->zalogowany())||(user::get()->zalogowany()&&konf::get()->getAkcja()=="u_edytuj2"&&$id_u==user::get()->id()))){
			$ok=true;
		} else {			
			konf::get()->setKomunikat(konf::get()->langTexty("login_u_brakdostepu"),"error");
		}
		
		//sprawdznie kodu z obrazka
		if($ok&&!user::get()->zalogowany()&&konf::get()->getKonfigTab("u_konf",'botproof')){
			$ok=konf::get()->botProofCheck(true);	
		}		
		
		
		if(!$zmianarozbita){									

			//gdy niezalogowany lub gdy podane haslo do zmiany
			if($ok&&(empty($id_u)||(!empty($haslo)&&!empty($haslo_2)))){

				//haslo 2x identyczne (nie jest wymagane dla niezalogowanego)							
				$ok=false;
				if($haslo==$haslo_2){
					$ok=true;			
				} else {
					konf::get()->setInvalid('haslo');						
					konf::get()->setKomunikat(konf::get()->langTexty("login_u_brakdanychl4"),"error"); 
				}
				
				//sprawdzenie dlugosci hasla
				if($ok){
				
					$ok=false;
					if(user::get()->frazaCheck($haslo,konf::get()->getKonfigTab("u_konf",'haslo_dl'),false)){
						$ok=true;			
					} else {
						konf::get()->setInvalid('haslo');					
						konf::get()->setKomunikat(konf::get()->langTexty("login_u_brakdanychl5"),"error"); 
					}
					
				}
				
			}

		}
		
		//generator zapytania insert/update
		require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
		$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'uzytkownicy'),$dane);
		$sqldane->daneOdczyt();	
		$sqldane->setAutor(true);	
		$sqldane->setTesty($testy);			
		
		//testuj zapytanie
		if($ok){
			$sqldane->testuj();	
			if(!$sqldane->ok()){	
				$ok=false;			
			}
		}

		//sprawdzamy limit twrozonych kont
		if($ok){
			$ok=false;
			//max
			if(!empty($id_u)||!konf::get()->getKonfigTab("u_konf",'max_new')||(konf::get()->_bazasql->policz("id", " FROM ".konf::get()->getKonfigTab("sql_tab",'logi')." WHERE ip='".konf::get()->getIp()."' AND host='".konf::get()->getHost()."' AND idtf='u_new' AND kiedy>'".tekstForm::dniData(60,"i","-")."'")<konf::get()->getKonfigTab("u_konf",'max_new'))){
				$ok=true;			
			} else {
				konf::get()->setKomunikat(konf::get()->langTexty("login_u_limit"),"error");
			}
		}	
		
		//sprawdzamy czy konto juz istnieje
		if($ok){
			$ok=false;
			if((!konf::get()->getKonfigTab("u_konf",'email_login')&&konf::get()->_bazasql->policz("id", " FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE login='".$sqldane->getDane("login")."' AND id!='".$id_u."'")==0)||(konf::get()->getKonfigTab("u_konf",'email_login')&&konf::get()->_bazasql->policz("id", " FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE email='".$sqldane->getDane("email")."' AND id!='".$id_u."'")==0)){
				$ok=true;
			} else {
				konf::get()->setKomunikat(konf::get()->langTexty("login_u_nieistnieje"),"error"); 
				konf::get()->setInvalid("login");
			}
		}		
			
		//jesli wszystko ok to wykonujemy zapis danych			
		if($ok){
		
			//kodujemy haslo md5
			if(!empty($haslo)){
				$haslo=user::get()->hasloForma($haslo);
			}		
			
			//gdy ktos nie jest adminem usytalamy status konta
			if(!user::get()->adminU()){
			
				if(!user::get()->zalogowany()){				
				
					if(konf::get()->getKonfigTab("u_konf",'new_aktywne')){ 
						$status=konf::get()->getKonfigTab("u_konf",'status_domyslny'); 
					} else {
						$status=2;			
					}		

					if(konf::get()->getKonfigTab("u_konf",'typy_domyslny')){ 
						$typ=konf::get()->getKonfigTab("u_konf",'typy_domyslny'); 
					} else if(!empty($typy_tab[3])){
						$typ=3;			
					}	else {
						$typ=0;
					}

					//dodaj dane zo zapytania
				 	$sqldane->setDane(array(
				 		"status"=>$status,
				 		"typ"=>$typ,						
					));			
					
				}								
				
			} else {
			
				$glosy_suma=user::get()->getDane("glosy_suma");		
				$glosy_ile=user::get()->getDane("glosy_ile");	
				$glosy_srednia=0;
				
				if(!empty($glosy_ile)&&!empty($glosy_suma)){
				
					$glosy_srednia=round($glosy_suma/$glosy_ile,2);
				
				}
				
				//dodaj dane zo zapytania
			 	$sqldane->setDane(array(
					"glosy_srednia"=>$glosy_srednia
				));							
										
			}
		
			//nowe konto
			if(empty($id_u)){			
					
				//dodaj dane do zapytania
			 	$sqldane->setDane(array(
					"haslo"=>$haslo,
			 		"sprcheck"=>user::get()->genSid("sprcheck"),
					"data_haslo"=>date("Y-m-d H:i:s")
				));							

				//budowanie zapytania
				$sqldane->dodajDaneD();	
				
				//zapisanie danych
				if($sqldane->getSql()){
					konf::get()->_bazasql->zap($sqldane->getSql());
	 				$id_u=konf::get()->_bazasql->insert_id;
				}

	   		if(user::get()->adminU()){ 
					user::get()->zapiszLog(konf::get()->langTexty("login_u_dodaniea_log")." ".$sqldane->getDane("login"),user::get()->login()); 
				} else { 
					user::get()->zapiszLog(konf::get()->langTexty("login_u_dodanie_log"),$sqldane->getDane("login"),$id_u,"u_new"); 
				}		
					
				//prawidlowo zapisane		
				if(!empty($id_u)){
				
					konf::get()->setZmienna("_post","szuk_typ",$sqldane->getDane("typ"));					
					konf::get()->setZmienna("_post","id_u",$id_u);							
			
					konf::get()->setKomunikat(konf::get()->langTexty("login_u_praw1_log")." ".$sqldane->getDane("login")." ".konf::get()->langTexty("login_u_praw2_log"),"");
					
					if(konf::get()->getKonfigTab("u_konf",'new_aktywne')){ 
			      konf::get()->setKomunikat(konf::get()->langTexty("login_u_mozesz"),""); 
			    } else {							
						$this->zapiszEmail($sqldane->getDane(),$id_u);	
						konf::get()->setKomunikat(konf::get()->langTexty("login_u_email_aby"),"");
					}

					//zapisanie zdjecia
					if(konf::get()->getKonfigTab("u_konf",'img')){	
										
						$grafika=$this->grafikaZapis($dane,$id_u);		
						
						//zapisz dane zdjecia
						if($grafika->getSql()){					
							konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." SET ".$grafika->getSql()." WHERE id='".$id_u."'");	
						}								
															
					}
													
				}		
				
			//edycja									
			} else {
					
				///pobierz aktualne dane								
				if($id_u==user::get()->id()){
					$dane=user::get()->getDane();
				} else {
					$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE id='".$id_u."'".user::get()->getSqlAdd());
				}						

				if(!empty($dane)){		
				
					if(!$zmianarozbita){					
					
						//zmiana hasla tylko gdy podano nowe haslo
						if(!empty($haslo)){
						 	$sqldane->setDane(array("haslo"=>$haslo));		
						 	$sqldane->setDane(array("data_haslo"=>date('Y-m-d H:i:s')));							
						}		
						
					}			

					//tworz zapytanie
					$sqldane->dodajDaneE();		
				
					//pobieerz grafike
					if(konf::get()->getKonfigTab("u_konf",'img')){	
					
						$grafika=$this->grafikaZapis($dane,$id_u);
									
						if($grafika->getSql()){
							$sqldane->dodaj(", ".$grafika->getSql());				
						}	
	
					}
																	
					$sqldane->dodaj(" WHERE id='".$id_u."'".user::get()->getSqlAdd());
								
					//wykonaj zapytanie
					if($sqldane->getSql()){
					
						konf::get()->_bazasql->zap($sqldane->getSql());

			   		if(user::get()->adminU()){ 
							user::get()->zapiszLog(konf::get()->langTexty("login_u_emailea_log"),user::get()->login()); 
						} else { 
							user::get()->zapiszLog(konf::get()->langTexty("login_u_emailew_log"),user::get()->login()); 
						}
						
						if($id_u!=user::get()->id()){
							konf::get()->setKomunikat(konf::get()->langTexty("login_u_edytuj_konto").$id_u." ".konf::get()->langTexty("login_u_edytuj_konto2"),"");
						} else {
							konf::get()->setKomunikat(konf::get()->langTexty("login_u_edytuj_zmiana"),"");
						}			
						
						//odswiez dane konta
						if($id_u==user::get()->id()){
							user::get()->update();
						}
						
					}
					//getsql
					
				}
				//dane
			}
			//edycja
		}
		//ok
		
		//brak  danych konta, ponownie formularz
		if(empty($id_u)){ 
		
			konf::get()->setAkcja("u_dodaj"); 		
			if(user::get()->adminU()){ 
				konf::get()->setSzablon("admin");	
			}		
		
		} else {

			//zmiana domyslnje wersji jezykowej
			if($sqldane->getDane("lang2")){
				konf::get()->setLang2($sqldane->getDane("lang2"));	
			}
			
			//powrot na liste userow
			if(user::get()->adminU()){ 				
				konf::get()->setSzablon("admin2");
				if(konf::get()->getAkcja()!="u_edytuj2"){						
					konf::get()->setAkcja("uadmin_arch"); 
				} else {
					konf::get()->setAkcja("u_edytuj"); 				
				}
			//lub przejscie do logowania
			} else {		
				konf::get()->setAkcja("u_zaloguj");
			}	
			
			
		}
		
	}


  /**
   * save img
   * @param array $dane
   * @param int $id_nr
   * @return obj							
   */		
	private function grafikaZapis($dane,$id_u){

		$img_usun=tekstForm::doSql(konf::get()->getZmienna('img_usun'));	
			
		require_once(konf::get()->getKonfigTab('klasy')."class.zapiszgrafike.php");
		
		$grafika=new zapiszGrafike($id_u,konf::get()->getKonfigTab("u_konf",'kat'),"pic","img",$dane);
		$grafika->setWszystkie(true);
		$grafika->setImgUsun($img_usun);
		
		$grafika->setDaneImg(1,array(
			"hmax"=>konf::get()->getKonfigTab("u_konf",'img1_size'),
			"wmax"=>konf::get()->getKonfigTab("u_konf",'img1_size'),
			"hmin"=>konf::get()->getKonfigTab("u_konf",'img_min_size'),
			"wmin"=>konf::get()->getKonfigTab("u_konf",'img_min_size'),
			"typy"=>array(2=>2),
			"skala"=>konf::get()->getKonfigTab("u_konf",'img1_skalatyp')				
		));
		
		$grafika->setDaneImg(2,array(
			"hmax"=>konf::get()->getKonfigTab("u_konf",'img2_size'),
			"wmax"=>konf::get()->getKonfigTab("u_konf",'img2_size'),
			"hmin"=>konf::get()->getKonfigTab("u_konf",'img_min_size'),
			"wmin"=>konf::get()->getKonfigTab("u_konf",'img_min_size'),
			"typy"=>array(2=>2),
			"skala"=>konf::get()->getKonfigTab('u_konf','img2_skalatyp')					
		));			

		$grafika->setDaneImg(3,array(
			"hmax"=>konf::get()->getKonfigTab("u_konf",'img3_size'),
			"wmax"=>konf::get()->getKonfigTab("u_konf",'img3_size'),
			"hmin"=>konf::get()->getKonfigTab("u_konf",'img_min_size'),
			"wmin"=>konf::get()->getKonfigTab("u_konf",'img_min_size'),
			"typy"=>array(2=>2),
			"skala"=>konf::get()->getKonfigTab('u_konf','img3_skalatyp')					
		));			

		$grafika->wykonaj();
					
		
		return $grafika;		
	
	}	
	
		
	private function zapiszEmail($dane,$id_u){

		$tresc=konf::get()->langTexty("login_u_email1")." ".konf::get()->getKonfigTab('nazwa_www')." ( ".konf::get()->getKonfigTab('adres_www')." )\n\n";
		$tresc.=konf::get()->langTexty("login_u_email2")." ".$dane["login"]." ) ".konf::get()->langTexty("login_u_email3")."\n";
		$tresc.="<a href=\"".konf::get()->getKonfigTab('adres_www').konf::get()->getKonfigTab("plik")."?akcja=u_pt2&id_u=".$id_u."&sprcheck=".$dane["sprcheck"]."\">".konf::get()->getKonfigTab('adres_www').konf::get()->getKonfigTab("plik")."?akcja=u_pt2&id_u=".$id_u."&sprcheck=".$dane["sprcheck"]."</a>\n\n";
		//$tresc.=konf::get()->langTexty("login_u_email5")." ".$id_u."\n";
		//$tresc.=konf::get()->langTexty("login_u_email6")." ".$dane["sprcheck"]."\n";			
		
		require_once(konf::get()->getKonfigTab('klasy')."class.wyslijemail.php");
											
		$wyslij=new wyslijemail(konf::get()->langTexty("login_u_email0"),$tresc,$dane["email"]);
		$wyslij->setNadawca(konf::get()->getKonfigTab('kontakt_email'),konf::get()->getKonfigTab('kontakt_nadawca'));	
		$wyslij->wykonaj();		
		
	}
	
	public function edytuj2(){
	
		$this->zapisz();
		
	}
	
	
	public function dodaj2(){		
		
		$this->zapisz();
		
	}	
	
	
	public function phpinfowys(){

		phpinfo();
		
	}


	//panel z info o zalogowanym uzytkowniku
	public function systemowe(){

		echo tab_nagl(konf::get()->langTexty("u_login_sys"));
		
		echo "<tr><td class=\"tlo3\"><span class=\"male\">";	
		echo "<span class=\"grube\">".konf::get()->langTexty("u_login_sys_dane")."</span><br />";
		$zap=konf::get()->_bazasql->zap("SELECT VERSION() AS version");
	  $mysql_v=konf::get()->_bazasql->fetchAssoc($zap);
	  konf::get()->_bazasql->freeResult($zap);
		echo konf::get()->langTexty("u_login_sys_server")." <span class=\"grube\">".getenv("SERVER_SOFTWARE")." ";
		echo "(<a href=\"".konf::get()->getKonfigTab("plik")."?akcja=u_phpinfowys\" target=\"_blank\">".konf::get()->langTexty("u_login_sys_phpinfo")."</a>)</span><br />";
		if(!empty($mysql_v[0])){
			echo konf::get()->langTexty("u_login_sys_mysql")." <span class=\"grube\">".$mysql_v[0]."</span><br />";
		}
		echo konf::get()->langTexty("u_login_sys_serwer")." <span class=\"grube\">".konf::get()->getKonfigTab("serwer")."</span><br />";
		echo konf::get()->langTexty("u_login_sys_sciezka")." <span class=\"grube\">".konf::get()->getKonfigTab("sciezka")."</span><br />";
		echo konf::get()->langTexty("u_login_sys_sid")." <span class=\"grube\">".user::get()->getSid()."</span><br />";
	  
	  $tmp=getenv("TMP");
		if(empty($tmp)&&!empty($_ENV['TMP'])){
	 	  $tmp=$_ENV['TMP'];
	  }
	  $tmpdir=getenv("TMPDIR");
		if(empty($tmpdir)&&!empty($_ENV['TMPDIR'])){
	 	  $tmpdir=$_ENV['TMPDIR'];
	  }

		echo konf::get()->langTexty("u_login_sys_tmpdir")." <span class=\"grube\">".$tmpdir."</span> ";
	  if(!empty($tmpdir)) {
			if(!is_writable($tmpdir)){ 
				echo konf::get()->langTexty("u_login_sys_niezapisywalne"); 
			}
	  }
		echo "<br />".konf::get()->langTexty("u_login_sys_tmp")." <span class=\"grube\">".$tmp."</span> ";
	 	if(!empty($tmp)){
	    if(!is_writable($tmp)){
				echo konf::get()->langTexty("u_login_sys_niezapisywalne"); 
			}
		}
		echo "<br /><br />";

		echo "<span class=\"grube\">".konf::get()->langTexty("u_login_sys_konfigu")."</span><br />";
		echo konf::get()->langTexty("u_login_sys_autowyl")." <span class=\"grube\">";
		if(!konf::get()->getKonfigTab("u_konf",'autowylog')){ 
			echo konf::get()->langTexty("u_login_sys_nie"); 
		} else{ 
			echo konf::get()->getKonfigTab("u_konf",'autowylog')." ".konf::get()->langTexty("u_login_sys_minut"); 
		}
		echo "</span><br />";

		echo konf::get()->langTexty("u_login_sys_autousuw")." <span class=\"grube\">";
		if(!konf::get()->getKonfigTab("u_konf",'autousuw')){ 
			echo konf::get()->langTexty("u_login_sys_nie"); 
		} else{ 
			echo konf::get()->getKonfigTab("u_konf",'autousuw')." ".konf::get()->langTexty("u_login_sys_dni"); 
		}
		
		if(konf::get()->getKonfigTab("u_konf",'autousuw_delete')){ 
			echo " ".konf::get()->langTexty("u_login_sys_usuwane"); 
		} else { 
			echo " ".konf::get()->langTexty("u_login_sys_blokowane"); 
		}
		echo "</span><br />";

		echo konf::get()->langTexty("u_login_sys_logowanie")." <span class=\"grube\">";
		if(!konf::get()->getKonfigTab("u_konf",'staly_log')){ 
			echo konf::get()->langTexty("u_login_sys_nie"); 
		} else { 
			echo konf::get()->getKonfigTab("u_konf",'staly_log')." ".konf::get()->langTexty("u_login_sys_logdni"); 
		}
		echo "</span><br />";

		echo konf::get()->langTexty("u_login_sys_tylko")." <span class=\"grube\">";
		if(!konf::get()->getKonfigTab("u_konf",'tylko_admin')){ 
			echo konf::get()->langTexty("u_login_sys_nie"); 
		} else{ 
			echo konf::get()->langTexty("u_login_sys_tak"); 
		}
		echo "</span><br />";

		echo konf::get()->langTexty("u_login_sys_pelne")." <span class=\"grube\">";
		if(!konf::get()->getKonfigTab("u_konf",'rozs')){ 
			echo konf::get()->langTexty("u_login_sys_nie"); 
		} else {
			echo konf::get()->langTexty("u_login_sys_tak"); 
		}
		echo "</span><br />";

		echo konf::get()->langTexty("u_login_sys_maxu")." <span class=\"grube\">".konf::get()->getKonfigTab("u_konf",'ile_upr')."</span><br />";

		echo konf::get()->langTexty("u_login_sys_autolog")." <span class=\"grube\">";
		if(!konf::get()->getKonfigTab("u_konf",'autousuw_log')){ 
			echo konf::get()->langTexty("u_login_sys_nie"); 
		} else { 
			echo " ".konf::get()->langTexty("u_login_sys_po")." ".konf::get()->getKonfigTab("u_konf",'autousuw_log')." ".konf::get()->langTexty("u_login_sys_dnilog"); 
		}
		echo "</span><br />";

		echo konf::get()->langTexty("u_login_sys_nowesa")." <span class=\"grube\">";
		if(!konf::get()->getKonfigTab("u_konf",'new_aktywne')){ 
			echo konf::get()->langTexty("u_login_sys_nie")." "; 
		}		
		echo konf::get()->langTexty("u_login_sys_aktywne")."</span><br />";

		echo konf::get()->langTexty("u_login_sys_sidwc")." <span class=\"grube\">";
		if(!konf::get()->getKonfigTab("u_konf",'cookie')){ 
			echo konf::get()->langTexty("u_login_sys_nie"); 
		} else { 
			echo " na ".konf::get()->getKonfigTab("u_konf",'cookie')." ".konf::get()->langTexty("u_login_sys_sidwcminut"); 
		}
		echo "</span><br />";

		echo konf::get()->langTexty("u_login_sys_maxzly")." <span class=\"grube\">".konf::get()->getKonfigTab("u_konf",'max_bad_log')."</span><br />";

		echo konf::get()->langTexty("u_login_sys_maxkont")." <span class=\"grube\">".konf::get()->getKonfigTab("u_konf",'max_new')."</span><br />";

		echo konf::get()->langTexty("u_login_sys_punkty")." ";
		if(konf::get()->getKonfigTab("u_konf",'punkty')){ 
			echo "<span class=\"grube\">".konf::get()->langTexty("u_login_sys_tak")."</span><br />"; 
		} else { 
			echo "<span class=\"grube\">".konf::get()->langTexty("u_login_sys_nie")."</span><br />"; 
		}

		echo konf::get()->langTexty("u_login_sys_filtr")." ";
		if(konf::get()->getKonfigTab("u_konf",'banowanie')){ 
			echo "<span class=\"grube\">".konf::get()->langTexty("u_login_sys_tak")."</span>"; 
		} else { 
			echo "<span class=\"grube\">".konf::get()->langTexty("u_login_sys_nie")."</span>"; 
		}

		echo "</span></td></tr>";
		
		echo tab_stop();
		
		echo tab_nagl("");	
		echo "<tr class=\"srodek\">";
		echo "<td class=\"tlo4\">".interfejs::linkEl("user",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane","id_u"=>user::get()->id())),konf::get()->langTexty("u_login_sys_danekonta"))."</td>";
		echo "<td class=\"tlo4\">".interfejs::linkEl("user_edit",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_edytuj","id_u"=>user::get()->id())),konf::get()->langTexty("u_login_sys_edytujkonto"))."</td>";
		if(user::get()->adminGlowny()){	
			echo "<td class=\"tlo4\">".interfejs::linkEl("table_gear",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_systemowe")),konf::get()->langTexty("u_login_sys_danesys"))."</td>";	
		}
		echo "</tr>";
		echo tab_stop();
		
	}


	//panel z info o zalogowanym uzytkowniku
	public function infodane(){	

		$u_wiersz=user::get()->getDane();
		
		if(konf::get()->getKonfigTab("u_konf",'wys_panel')){
		
			echo tab_nagl(konf::get()->langTexty("u_login_info"));	
		
			echo "<tr><td class=\"tlo3\">";
			
			echo "<span class=\"male\">";
			echo konf::get()->langTexty("u_login_info_u")." <span class=\"grube\">".$u_wiersz['login']."</span>";
			if(konf::get()->getKonfigTab("u_konf",'rozs')&&(!empty($u_wiersz['imie'])||!empty($u_wiersz['nazwisko']))){
				echo " (".$u_wiersz['imie']." ".$u_wiersz['nazwisko'].")";
			}
			
			echo "<br />".konf::get()->langTexty("u_login_info_email")." <a href=\"mailto:".$u_wiersz['email']."\">".$u_wiersz['email']."</a><br />";
			echo konf::get()->langTexty("u_login_info_datazal")." <span class=\"grube\">";
			if(tekstForm::niepuste($u_wiersz['autor_kiedy'])){ 
				echo $u_wiersz['autor_kiedy']; 
			}
			echo "</span><br />";
			
			echo konf::get()->langTexty("u_login_info_zal")." <span class=\"grube\">".$u_wiersz['last_log']."</span>, ";
			echo konf::get()->langTexty("u_login_info_log")." <span class=\"grube\">".$u_wiersz['ile_log']."</span><br />";
			if(tekstForm::niepuste($u_wiersz['last_bad_log'])){
				echo konf::get()->langTexty("u_login_info_ostnie")." <span class=\"grube\">".$u_wiersz['last_bad_log']."</span><br />";
			}
			
			echo konf::get()->langTexty("u_login_info_ip")." <span class=\"grube\">".konf::get()->getIp()."</span>, ";
			echo konf::get()->langTexty("u_login_info_host")." <span class=\"grube\">".konf::get()->getHost()."</span><br />";
			echo konf::get()->langTexty("u_login_info_status")." ";
			echo "<span class=\"grube\">".konf::get()->langTexty("u_login_info_konto")." ";
			if($u_wiersz['niewygasa']==1){ 
				echo konf::get()->langTexty("u_login_info_nie"); 
			}
			echo " ".konf::get()->langTexty("u_login_info_wygasa");
			if($u_wiersz['niewygasa']!=1&&konf::get()->getKonfigTab("u_konf",'autousuw')){ 
				echo " ".konf::get()->langTexty("u_login_info_po")." ".konf::get()->getKonfigTab("u_konf",'autousuw')." ".konf::get()->langTexty("u_login_info_dniach"); 
			}

			echo ", ".konf::get()->langTexty("u_login_info_kontojest")." ";
			echo konf::get()->langTexty("u_statusy_tab".$u_wiersz['status']);
			echo "</span><br />";
			
			if(konf::get()->getKonfigTab("u_konf",'autowylog')&&!konf::get()->getKonfigTab("u_konf",'staly_log')){
				echo konf::get()->langTexty("u_login_info_zostaniesz")." <span class=\"grube\">".konf::get()->getKonfigTab("u_konf",'autowylog')."</span>";
				echo " ".konf::get()->langTexty("u_login_info_minutbez")."<br />";
			}
			
			echo konf::get()->langTexty("u_login_info_przegladarka")." <span class=\"grube\">";
		  $user_agent=getenv("HTTP_USER_AGENT");
	  	if(empty($user_agent)&&!empty($_ENV['HTTP_USER_AGENT'])){
			  $user_agent=$_ENV['HTTP_USER_AGENT'];
	  	}
			
		  echo $user_agent."</span>";
			echo "</span>";

			echo "</td></tr>";
				
			echo tab_stop();		
			
		}
		
		echo tab_nagl("");	
		echo "<tr class=\"srodek\">";
		echo "<td class=\"tlo4\">".interfejs::linkEl("user",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane","id_u"=>user::get()->id())),konf::get()->langTexty("u_login_info_danekonta"))."</td>";
		echo "<td class=\"tlo4\">".interfejs::linkEl("user_edit",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_edytuj","id_u"=>user::get()->id())),konf::get()->langTexty("u_login_info_edytujkonto"))."</td>";
		if(user::get()->adminGlowny()){	
			echo "<td class=\"tlo4\">".interfejs::linkEl("table_gear",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_systemowe")),konf::get()->langTexty("u_login_info_danesys"))."</td>";	
		}
		echo "</tr>";
		echo tab_stop();
		
	}
	
	
	public function ostatnioZnajomi($dane){

		$ile=4;
			
		if(konf::get()->isMod("znajomi")){	
					
			echo "<div class=\"nowa_l\" style=\"padding-top:4px;\">";
			
			echo tab_nagl("Ostatnio dodani znajomi:",$ile);			
			echo "<tr class=\"srodek\" valign=\"top\">";
			
			$zap=konf::get()->_bazasql->zap("SELECT u.*, z.data_dodania FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u, ".konf::get()->getKonfigTab("sql_tab",'znajomi')." z WHERE u.id=z.id_gosc AND z.id_u='".$dane['id']."' ".user::get()->getSqlAdd("u")." ORDER BY z.data_dodania DESC, z.id DESC LIMIT 0,".$ile);
			
			$i=0;
			
			if(konf::get()->_bazasql->numRows($zap)){
			
				while($dane2=konf::get()->_bazasql->fetchAssoc($zap)){		
				
					echo "<td class=\"tlo3\" style=\"width:25%\">";
					u_wizytowka($dane2,true,($dane['id']==user::get()->id()));
					echo "</td>";		
					
					$i++;	
				
				}
				
				if($i<$ile){
					
					while($i<$ile){
						echo "<td class=\"tlo3\" style=\"width:25%\">&nbsp;</td>";
						$i++;
					}
				
				}
				
				echo "</tr>";
				
				echo "<tr><td class=\"tlo4 srodek\" colspan=\"".$ile."\">";
				echo interfejs::linkEl("group",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_arch","id_u"=>$dane['id'])),"zobacz wszystkich znajomych");
				echo "</td></tr>";
				
			} else {
						
				echo "<tr><td class=\"brak\" colspan=\"".$ile."\">Użytkownik nie posiada znajomych!</td></tr>";				
			
			}	
			
			echo tab_stop();
			
			echo "</div>";
			
		}
	
	}
	
	
	public function ostatnioZdjecia($dane){

		$ile=4;		
		$i=0;			
		
		if(konf::get()->isMod("ugal")){	
		
			$zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy_galeria')." WHERE id_matka='".$dane['id']."' AND status=1 ORDER BY autor_kiedy DESC, id DESC LIMIT 0,".$ile);		
			
			if(konf::get()->_bazasql->numRows($zap)){		
				
				echo "<div class=\"nowa_l\" style=\"padding-top:4px;\">";
				
				echo tab_nagl("Najnowsze fotki w galerii:",$ile);				
				echo "<tr class=\"srodek\" valign=\"top\">";
				
				require_once(konf::get()->getKonfigTab('mod_kat')."ugal/class.ugal.php");														
				$ugal=new ugal();										
							
				while($dane2=konf::get()->_bazasql->fetchAssoc($zap)){		
				
					echo "<td class=\"tlo3\" style=\"width:25%\">";
										
					echo "<div>";					
					echo $ugal->fotka($dane2,2,true);
					echo "</div>";
										
					echo "<a href=\"".$ugal->fotkaLink($dane2)."\">".$dane2['tytul']."</a>";
					
					echo "<div class=\"male\">";
					echo "<div>Data dodania:</div>";
					echo "<div class=\"grube\">".substr($dane2['autor_kiedy'],0,16)."</div>";
					echo "</div>";
									
					echo "</td>";		
					
					$i++;	
				
				}
				
				if($i<$ile){
					
					while($i<$ile){
						echo "<td class=\"tlo3\" style=\"width:25%\">&nbsp;</td>";
						$i++;
					}
				
				}
				
				echo "</tr>";
				
				echo "<tr><td class=\"tlo4 srodek\" colspan=\"".$ile."\">";
				echo interfejs::linkEl("picture",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ugal_arch","id_u"=>$dane['id'])),"zobacz wszystkie zdjęcia");
				echo "</td></tr>";
				
				echo tab_stop();				
				echo "</div>";
				
			}
		
		}
	
	}	
	
	
	public function grupyNowe($dane){
	
		$ile=5;		
		$colspan=2;
		$i=0;			
		
		if(konf::get()->isMod("grupy")){	
		
			require_once(konf::get()->getKonfigTab('mod_kat')."grupy/class.grupy.php");														
			$grupy=new grupy();																		
		
			$zap=konf::get()->_bazasql->zap("SELECT p.* FROM ".konf::get()->getKonfigTab("sql_tab",'grupy')." p LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." u ON p.id=u.id_grupa WHERE u.id_u='".$dane['id']."'".$grupy->sqlAdd("p")." ORDER BY p.data_aktywnosci DESC, p.id DESC LIMIT 0,".$ile);		
			
			if(konf::get()->_bazasql->numRows($zap)){		
				
				echo "<div class=\"nowa_l\" style=\"padding-top:4px;\">";
				
				echo tab_nagl("Grup użytkownika:",$colspan);

				while($dane2=konf::get()->_bazasql->fetchAssoc($zap)){		
				
			  	echo "<tr class=\"srodek\">";
					echo "<td class=\"tlo4\" style=\"width:74px;\">";
					echo $grupy->grupyLogo($dane2,2,true);
					echo "</td>";

					echo "<td class=\"tlo3 lewa\">";
					echo $grupy->grupyRekord($dane2);		
								
					echo "<div class=\"male\">";
					echo $grupy->dataForm($dane2['data_aktywnosci']);
					echo "</div>";
	
					echo "</td>";
					
					echo "</tr>";
				
				}
								
				echo "<tr><td class=\"tlo4 srodek\" colspan=\"".$colspan."\">";
				echo interfejs::linkEl("group",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_user","id_u"=>$dane['id'])),"zobacz wszystkie");
				echo "</td></tr>";
				
				echo "</table></div>";
				
			}
		
		}	
	
	}
	
	
	
	private function wizytowka($dane){
	
		$woj_tab=konf::get()->getKonfigTab("woj_tab");		
		$plec_tab=konf::get()->getKonfigTab("u_konf",'plec_tab');				
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');	
		$u_sort=konf::get()->getZmienna('u_sort','u_sort');			
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_arch"));			
		$id_u=$dane['id'];	
		
		echo "<div id=\"lewa_k\">";
		
		echo "<div class=\"tlo2 lewa\">Użytkownik:</div>";
		
		echo "<div class=\"tlo3 tlo3l srodek\">";
		
		echo user::get()->obrazek($dane,"",2,"",true);		
		
		echo "<div style=\"padding-bottom:3px;\"><a class=\"grube\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane",'id_u'=>$dane['id']))."\">";
		echo tekstForm::wrapWbr(user::get()->nazwa($dane),30);
		echo "</a> (".$dane['ile_znajomi'].")</div>";
		
		if(!empty($dane['miejscowosc'])){
			echo "<div style=\"padding-bottom:3px;\">".$dane['miejscowosc']."</div>";
		}		
		
		echo "</div>";
		
		echo "<div class=\"tlo3l\">";
		
		if(user::get()->id()!=$dane['id']){
		
			if(!user::get()->jestZnajomi($dane['id'])){
					echo interfejs::linkEl2("group_add",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_zapros",'id_u'=>$dane['id'])),"Zaproś do znajomych");			
			}
			echo interfejs::linkEl2("email_edit",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"poczta_wiadomosc","id_u"=>$dane['id'])),"Napisz wiadomość");
			
			if(user::get()->adminU()){			
				echo interfejs::linkEl2("user_edit",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_edytuj","id_u"=>$dane['id'])),"Edytuj profil");			
			}
			
			if(konf::get()->getKonfigTab("u_konf","czarna")){
				echo interfejs::linkEl2("delete",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_czarnadodaj","id_u"=>$dane['id'])),"Dodaj na czarną listę");						
			}
			
		} else {
			echo interfejs::linkEl2("user_edit",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_edytuj")),"Edytuj profil");				
		}
		
		echo interfejs::linkEl2("group",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_arch","id_u"=>$dane['id'])),"Znajomi (".$dane['ile_znajomi'].")");
		
		echo interfejs::linkEl2("picture",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ugal_arch","id_u"=>$dane['id'])),"Galeria zdjęć");									
		

		echo "</div>";
		
		
		if(user::get()->adminU()||user::get()->id()==$id_u){
		
			echo "<div style=\"padding-top:4px;\">";
		
			echo "<div class=\"tlo2\">".konf::get()->langTexty("u_login_u_dane_dstan")."</div>";		
			
			echo "<div class=\"tlo3 tlo3l\">";
			
			echo "<div class=\"male\">".konf::get()->langTexty("u_login_dane_datazal")."</div>";
			echo "<div class=\"grube\">";
			if(tekstForm::niepuste($dane['autor_kiedy'])){ 
				echo $dane['autor_kiedy']; 
			}
			echo "</div>";
			
			echo "<div class=\"male\">".konf::get()->langTexty("u_login_dane_ostlog")."</div>";
			echo "<div class=\"grube\">";
			if(tekstForm::niepuste($dane['last_log'])){
				echo $dane['last_log'];
			}
			echo "</div>";
			
			echo "<div><span class=\"male\">".konf::get()->langTexty("u_login_dane_ilelog")."</span>";
			echo " <span class=\"grube\">".$dane['ile_log']."</span></div>";
			
			if(tekstForm::niepuste($dane['last_bad_log'])){
				echo "<div class=\"male\">".konf::get()->langTexty("u_login_dane_ostnie")."</div>";
				echo "<div class=\"grube\">".$dane['last_bad_log']."</div>";
			}

			echo "<div>";
			
			if(konf::get()->getKonfigTab("u_konf",'autousuw')){
				
				echo konf::get()->langTexty("u_login_dane_konto");
				echo " ";
				if($dane['niewygasa']==1){ 
					echo konf::get()->langTexty("u_login_dane_nie"); 
				}
				echo " ".konf::get()->langTexty("u_login_dane_wygasa");
				if($dane['niewygasa']!=1){ 
					echo " ".konf::get()->langTexty("u_login_dane_po")." ".konf::get()->getKonfigTab("u_konf",'autousuw')." ".konf::get()->langTexty("u_login_dane_dniach"); 
				}
				echo ",<br /> ";
				
			}

			echo konf::get()->langTexty("u_login_dane_kontojest")." ";			
			echo "<span class=\"grube\">";
			echo konf::get()->langTexty("u_statusy_tab".$dane['status']);
			echo "</span>";
			
			echo "</div>";
			
			if(konf::get()->getKonfigTab("u_konf",'punkty')){
				echo "<div><span class=\"male\">".konf::get()->langTexty("u_login_dane_punkty")."</span>";
				echo " <span class=\"grube\">".$dane['punkty']."</span></div>";
			}				
			
			if(user::get()->adminU()){
			
				if(konf::get()->getKonfigTab("u_konf",'glosy')){
					echo "<div><span class=\"male\">".konf::get()->langTexty("u_login_dane_glosyile")."</span>";
					echo " <span class=\"grube\">".$dane['glosy_ile']."</span></div>";
					echo "<div><span class=\"male\">".konf::get()->langTexty("u_login_dane_glosysuma")."</span>";
					echo " <span class=\"grube\">".$dane['glosy_suma']."</span></div>";						
					echo "<div><span class=\"male\">".konf::get()->langTexty("u_login_dane_glosysrednia")."</span>";
					echo " <span class=\"grube\">".$dane['glosy_srednia']."</span></div>";
				}		
													
			}		
			
			echo "</div></div>";

		}	
		
		$this->grupyNowe($dane);
		
		echo "</div>";
		
		echo "<div id=\"glowna_k\"><div id=\"glowna_k2\">";
		
		echo "<h1>".konf::get()->langTexty("u_login_dane")."</h1>";

		echo "<div class=\"tlo3 tlo3l\">";
					
		echo "<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\" class=\"dane_tabelka\">";
		
		echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_login")."</td>";
		echo "<td class=\"dane_wartosc\">".$dane['login']."</td></tr>";
		
		echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_email")."</td>";
		echo "<td class=\"dane_wartosc\"><a href=\"mailto:".$dane['email']."\">".$dane['email']."</a></td></tr>";

		if(konf::get()->getKonfigTab("u_konf",'rozs')){
		
			echo "<tr><td colspan=\"2\" class=\"dane_tytul\">".konf::get()->langTexty("u_login_u_dane_dosobowe")."</td></tr>";
		
			echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_imie")."</td>";
			echo "<td class=\"dane_wartosc\">".$dane['imie']."</td></tr>";
			
			echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_nazwisko")."</td>";
			echo "<td class=\"dane_wartosc\">".$dane['nazwisko']."</td></tr>";

			if(konf::get()->getKonfigTab("strona_typ")=="sklep"){			
								
				echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_dataur")."</td>";								
				echo "<td class=\"dane_wartosc\">";
				if(!empty($dane['ur_rok'])){
					echo$dane['ur_rok'];
					echo " - ";
					if($dane['ur_mc']<10){
						echo "0";
					}
					echo $dane['ur_mc'];		
					echo " - ";		
					if($dane['ur_dzien']<10){
						echo "0";
					}											
					echo $dane['ur_dzien'];							
				}
				echo "</td></tr>";
				
			}
			
			if(user::get()->adminU()||user::get()->id()==$id_u){				
			
				if(konf::get()->getKonfigTab("strona_typ")=="sklep"){					
					echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_plec")."</td>";
					echo "<td class=\"dane_wartosc\">";
					if(!empty($dane['plec'])&&!empty($plec_tab[$dane['plec']])){
						echo $plec_tab[$dane['plec']];
					}
					echo "</td></tr>";
				}
				
				echo "<tr><td colspan=\"2\" class=\"dane_tytul\">".konf::get()->langTexty("u_login_u_dane_dadresowe")."</td></tr>";				
				
				echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_miejscowosc")."</td>";
				echo "<td class=\"dane_wartosc\">".$dane['miejscowosc']." ".$dane['kod_pocztowy']."</td></tr>";
				
				echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_ulica")."</td>";
				echo "<td class=\"dane_wartosc\">".$dane['ulica']." ".$dane['nr_domu'];
				if(!empty($dane['nr_mieszkania'])){
					echo "/".$dane['nr_mieszkania'];
				}
				echo "</td></tr>";				
				
				echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_woj")."</td>";
				echo "<td class=\"dane_wartosc\">";
				if(!empty($woj_tab[$dane['woj']])){
					echo $woj_tab[$dane['woj']];
				}
				echo "</td></tr>";
				
			}
			
			if(!empty($dane['firma'])&&konf::get()->getKonfigTab("u_konf",'firma')){
			
				echo "<tr><td colspan=\"2\" class=\"dane_tytul\">".konf::get()->langTexty("u_login_u_dane_dfirmowe")."Dane firmowe</td></tr>";	
															
				echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_nazwa")."</td>";
				echo "<td class=\"dane_wartosc\">".$dane['firma_nazwa']."</td></tr>";								
				
				echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_nip")."NIP:</td>";
				echo "<td class=\"dane_wartosc\">".$dane['nip']."</td></tr>";								
				
									
				echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_miejscowosc")."</td>";
				echo "<td class=\"dane_wartosc\">".$dane['firma_miejscowosc']." ".$dane['firma_kod_pocztowy']."</td></tr>";
				
				echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_ulica")."</td>";
				echo "<td class=\"dane_wartosc\">".$dane['firma_ulica']." ".$dane['firma_nr_domu'];
				if(!empty($dane['firma_nr_mieszkania'])){
					echo "/".$dane['firma_nr_mieszkania'];
				}
				echo "</td></tr>";				
				
			}

			echo "<tr><td colspan=\"2\" class=\"dane_tytul\">".konf::get()->langTexty("u_login_u_dane_dkontaktowe")."</td></tr>";		
			
			echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_telefon")."</td>";
			echo "<td class=\"dane_wartosc\">";
			echo $dane['telefon'];
			echo "</td></tr>";				
			
			echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_skype")."</td>";
			echo "<td class=\"dane_wartosc\">";
			if(!empty($dane['skype'])){ 
				echo tekstForm::skype($dane['skype']); 
			}
			echo " ".$dane['skype'];
			echo "</td></tr>";												
			
			echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_gg")."</td>";
			echo "<td class=\"dane_wartosc\">";
			if(!empty($dane['gg'])){ 
				echo tekstForm::gg($dane['gg']); 
			}
			echo " ".$dane['gg']."</td></tr>";
			
			if(!empty($dane['www'])){
				echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_www")."</td>";
				echo "<td class=\"dane_wartosc\"><a href=\"".tekstForm::linkPopraw($dane['www'])."\" target=\"_blank\">".$dane['www']."</a></td></tr>";
			}
		}
		
		if(konf::get()->getKonfigTab("u_konf",'opisowe')){
		
			echo "<tr><td colspan=\"2\" class=\"dane_tytul\">Więcej o mnie</td></tr>";				
			
			if(!empty($dane['omnie'])){			
				echo "<tr><td class=\"dane_opis\">kilka słów o mnie:</td>";
				echo "<td class=\"dane_wartosc\">";
				echo tekstForm::doWys($dane['omnie']);
				echo "</td></tr>";						
			}
			
			if(!empty($dane['zainteresowania'])){			
				echo "<tr><td class=\"dane_opis\">zainteresowania:</td>";
				echo "<td class=\"dane_wartosc\">";
				echo tekstForm::doWys($dane['zainteresowania']);
				echo "</td></tr>";						
			}		
			
			if(!empty($dane['praca'])){			
				echo "<tr><td class=\"dane_opis\">praca:</td>";
				echo "<td class=\"dane_wartosc\">";
				echo tekstForm::doWys($dane['praca']);
				echo "</td></tr>";						
			}				
			
		}
		
		if(user::get()->adminU()){

			if(!empty($dane['opis'])){
				echo "<tr valign=\"top\"><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_opis")."</td>";
				echo "<td class=\"dane_wartosc\">".tekstForm::doWys($dane['opis'])."</td></tr>";
			}												
			
		}
		
		echo "</table>";	
		
		echo "</div>";		
		
		$this->ostatnioZnajomi($dane);		
		
		$this->ostatnioZdjecia($dane);
				
    if(konf::get()->isMod("koment")&&konf::get()->getKonfigTab("u_konf",'koment')){
			$konf=konf::get();
			require_once(konf::get()->getKonfigTab('mod_kat')."koment/class.koment.php");
			$koment=new koment(2);
			$koment->setPrzenies(array("id_u"=>$dane['id']));
			$koment->setId($dane['id']);						
			$koment->wyswietl();
			$koment->formularz();						
    }		

		echo "</div></div>";		
	
	}
	
	
	private function wizytowkaProste($dane){

		$woj_tab=konf::get()->getKonfigTab("woj_tab");		
		$plec_tab=konf::get()->getKonfigTab("u_konf",'plec_tab');				
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');	
		$u_sort=konf::get()->getZmienna('u_sort','u_sort');			
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_arch"));			
		$id_u=$dane['id'];
	
		echo tab_nagl(konf::get()->langTexty("u_login_dane"));	

		echo "<tr><td class=\"tlo3\">";
		
		$this->menu($dane);
		
		echo "<div class=\"nowa_l\">";
					
		echo "<table border=\"0\" cellspacing=\"1\" cellpadding=\"4\" class=\"dane_tabelka\">";
		
		echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_login")."</td>";
		echo "<td class=\"dane_wartosc\">".$dane['login']."</td></tr>";
		
		echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_email")."</td>";
		echo "<td class=\"dane_wartosc\"><a href=\"mailto:".$dane['email']."\">".$dane['email']."</a></td></tr>";
		
		echo "<tr><td colspan=\"2\" class=\"dane_tytul\">".konf::get()->langTexty("u_login_u_dane_dosobowe")."</td></tr>";
	
		echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_imie")."</td>";
		echo "<td class=\"dane_wartosc\">".$dane['imie']."</td></tr>";
		
		echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_nazwisko")."</td>";
		echo "<td class=\"dane_wartosc\">".$dane['nazwisko']."</td></tr>";		

		if(konf::get()->getKonfigTab("u_konf",'rozs')){

			if(konf::get()->getKonfigTab("strona_typ")=="sklep"){			
								
				echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_dataur")."</td>";								
				echo "<td class=\"dane_wartosc\">";
				if(!empty($dane['ur_rok'])){
					echo$dane['ur_rok'];
					echo " - ";
					if($dane['ur_mc']<10){
						echo "0";
					}
					echo $dane['ur_mc'];		
					echo " - ";		
					if($dane['ur_dzien']<10){
						echo "0";
					}											
					echo $dane['ur_dzien'];							
				}
				echo "</td></tr>";
				
			}
			
			if(user::get()->adminU()||user::get()->id()==$id_u){				
			
				if(konf::get()->getKonfigTab("strona_typ")=="sklep"){					
					echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_plec")."</td>";
					echo "<td class=\"dane_wartosc\">";
					if(!empty($dane['plec'])&&!empty($plec_tab[$dane['plec']])){
						echo $plec_tab[$dane['plec']];
					}
					echo "</td></tr>";
				}
				
				echo "<tr><td colspan=\"2\" class=\"dane_tytul\">".konf::get()->langTexty("u_login_u_dane_dadresowe")."</td></tr>";				
				
				echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_miejscowosc")."</td>";
				echo "<td class=\"dane_wartosc\">".$dane['miejscowosc']." ".$dane['kod_pocztowy']."</td></tr>";
				
				echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_ulica")."</td>";
				echo "<td class=\"dane_wartosc\">".$dane['ulica']." ".$dane['nr_domu'];
				if(!empty($dane['nr_mieszkania'])){
					echo "/".$dane['nr_mieszkania'];
				}
				echo "</td></tr>";				
				
				echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_woj")."</td>";
				echo "<td class=\"dane_wartosc\">";
				if(!empty($woj_tab[$dane['woj']])){
					echo $woj_tab[$dane['woj']];
				}
				echo "</td></tr>";
				
			}
			
			if(!empty($dane['firma'])&&konf::get()->getKonfigTab("u_konf",'firma')){
			
				echo "<tr><td colspan=\"2\" class=\"dane_tytul\">".konf::get()->langTexty("u_login_u_dane_dfirmowe")."Dane firmowe</td></tr>";	
															
				echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_nazwa")."</td>";
				echo "<td class=\"dane_wartosc\">".$dane['firma_nazwa']."</td></tr>";								
				
				echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_nip")."NIP:</td>";
				echo "<td class=\"dane_wartosc\">".$dane['nip']."</td></tr>";								
				
									
				echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_miejscowosc")."</td>";
				echo "<td class=\"dane_wartosc\">".$dane['firma_miejscowosc']." ".$dane['firma_kod_pocztowy']."</td></tr>";
				
				echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_ulica")."</td>";
				echo "<td class=\"dane_wartosc\">".$dane['firma_ulica']." ".$dane['firma_nr_domu'];
				if(!empty($dane['firma_nr_mieszkania'])){
					echo "/".$dane['firma_nr_mieszkania'];
				}
				echo "</td></tr>";				
				
			}

			echo "<tr><td colspan=\"2\" class=\"dane_tytul\">".konf::get()->langTexty("u_login_u_dane_dkontaktowe")."</td></tr>";		
			
			echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_telefon")."</td>";
			echo "<td class=\"dane_wartosc\">";
			echo $dane['telefon'];
			echo "</td></tr>";				
			
			echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_skype")."</td>";
			echo "<td class=\"dane_wartosc\">";
			if(!empty($dane['skype'])){ 
				echo tekstForm::skype($dane['skype']); 
			}
			echo " ".$dane['skype'];
			echo "</td></tr>";												
			
			echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_gg")."</td>";
			echo "<td class=\"dane_wartosc\">";
			if(!empty($dane['gg'])){ 
				echo tekstForm::gg($dane['gg']); 
			}
			echo " ".$dane['gg']."</td></tr>";
			
			if(!empty($dane['www'])){
				echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_www")."</td>";
				echo "<td class=\"dane_wartosc\"><a href=\"".tekstForm::linkPopraw($dane['www'])."\" target=\"_blank\">".$dane['www']."</a></td></tr>";
			}
		}
		
		
		if(user::get()->adminU()||user::get()->id()==$id_u){
			
			echo "<tr><td colspan=\"2\" class=\"dane_tytul\">".konf::get()->langTexty("u_login_u_dane_dstan")."</td></tr>";				

			echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_datazal")."</td>";
			echo "<td class=\"dane_wartosc\">";
			if(tekstForm::niepuste($dane['autor_kiedy'])){ 
				echo $dane['autor_kiedy']; 
			}
			echo "</td></tr>";
			
			echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_ostlog")."</td>";
			echo "<td class=\"dane_wartosc\">";
			if(tekstForm::niepuste($dane['last_log'])){
				echo $dane['last_log'];
			}
			echo "</td></tr>";
			
			echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_ilelog")."</td>";
			echo "<td class=\"dane_wartosc\">".$dane['ile_log']."</td></tr>";
			
			if(tekstForm::niepuste($dane['last_bad_log'])){
				echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_ostnie")."</td>";
				echo "<td class=\"dane_wartosc\">".$dane['last_bad_log']."</td></tr>";
			}

			echo "<tr valign=\"top\"><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_status")."</td>";
			echo "<td class=\"dane_wartosc\">";
			
			if(konf::get()->getKonfigTab("u_konf",'autousuw')){
				
				echo konf::get()->langTexty("u_login_dane_konto");
				echo " ";
				if($dane['niewygasa']==1){ 
					echo konf::get()->langTexty("u_login_dane_nie"); 
				}
				echo " ".konf::get()->langTexty("u_login_dane_wygasa");
				if($dane['niewygasa']!=1){ 
					echo " ".konf::get()->langTexty("u_login_dane_po")." ".konf::get()->getKonfigTab("u_konf",'autousuw')." ".konf::get()->langTexty("u_login_dane_dniach"); 
				}
				echo ",<br /> ";
				
			}

			echo konf::get()->langTexty("u_login_dane_kontojest")." ";
			echo konf::get()->langTexty("u_statusy_tab".$dane['status']);
			
			echo "</td></tr>";
			
			if(konf::get()->getKonfigTab("u_konf",'punkty')){
				echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_punkty")."</td>";
				echo "<td class=\"dane_wartosc\">".$dane['punkty']."</td></tr>";
			}				
			
			if(user::get()->adminU()){
			
				if(konf::get()->getKonfigTab("u_konf",'glosy')){
					echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_glosyile")."</td>";
					echo "<td class=\"dane_wartosc\">".$dane['glosy_ile']."</td></tr>";
					echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_glosysuma")."</td>";
					echo "<td class=\"dane_wartosc\">".$dane['glosy_suma']."</td></tr>";						
					echo "<tr><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_glosysrednia")."</td>";
					echo "<td class=\"dane_wartosc\">".$dane['glosy_srednia']."</td></tr>";								
				}		
				
				if(!empty($dane['opis'])){
					echo "<tr valign=\"top\"><td class=\"dane_opis\">".konf::get()->langTexty("u_login_dane_opis")."</td>";
					echo "<td class=\"dane_wartosc\">".tekstForm::doWys($dane['opis'])."</td></tr>";
				}												
			
			}				
			
		}
		
		echo "</table>";			
		
		if(konf::get()->getKonfigTab("u_konf",'img')&&!empty($dane['img'])&&!empty($dane['img1_nazwa'])){
					
      if(file_exists(konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("u_konf",'kat').$dane['img1_nazwa'])){
   			echo "<div class=\"srodek\"><img src=\"".konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("u_konf",'kat').$dane['img1_nazwa']."\" width=\"".$dane['img1_w']."\" height=\"".$dane['img1_h']."\" class=\"obrazek\" alt=\"\" /></div>";
  	  }

		}
		
		echo "</div>";
						
		echo "</td></tr>";
		echo tab_stop();

			
		echo tab_nagl("");		
		echo "<tr class=\"srodek\">";
		if(user::get()->adminU()){
			echo "<td class=\"tlo4\">".interfejs::linkEl("user_edit",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_edytuj","id_u"=>$id_u)),konf::get()->langTexty("u_login_dane_edytujkonto"))."</td>";	
		} else {
			echo "<td class=\"tlo4\">".interfejs::linkEl("user_edit",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_edytuj","id_u"=>user::get()->id())),konf::get()->langTexty("u_login_dane_edytujkonto"))."</td>";
		}
		if(user::get()->adminU()){	
			echo "<td class=\"tlo4\">".interfejs::linkEl("group",$link,konf::get()->langTexty("u_login_dane_listau"))."</td>";	
		}
		echo "</tr>";	
		echo tab_stop();	
	
	
	}


	//wswietla dane uzytkownika
	public function dane(){

		$id_u=tekstForm::doSql(konf::get()->getZmienna('id_u','id_u'));	

		if(empty($id_u)){
			$id_u=user::get()->id();
		}	

		if(!user::get()->adminU()&&!konf::get()->getKonfigTab("u_konf",'konta_dostepne')){ 
			$id_u=user::get()->id(); 
		}

		$dane=user::get()->getById($id_u,true);
		
		if(!empty($dane)&&!user::get()->jestCzarna($id_u)){	
		
			if(konf::get()->getKonfigTab("u_konf","profilprosty")){
				$this->wizytowkaProste($dane);
			} else {
				$this->wizytowka($dane);			
			}
			
		} else {
			echo interfejs::nieprawidlowe();		
		}
	
	}	
	
	
  /**
   * user menu
   * @param array $dane
   */		
	private function menu($dane){
	
		$szuk_typ=tekstForm::doSql(konf::get()->getZmienna('szuk_typ','szuk_typ'));		
	
		if(user::get()->zalogowany()&&$this->_admin){
			echo "<div><table class=\"lewa\" border=\"0\" style=\"margin-bottom:10px;\"><tr>";
			
			if(!empty($dane['id'])){
				echo interfejs::edytuj(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_edytuj","id_u"=>$dane['id'],"szuk_typ"=>$szuk_typ))); 				
				echo interfejs::podglad(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane","id_u"=>$dane['id']))); 					
				if($dane['id']!=user::get()->id()){	
					echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_usunu","id_tab[1]"=>$dane['id'],"szuk_typ"=>$szuk_typ))); 
		 			echo interfejs::przyciskEl("key",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_zmienupr","id_u"=>$dane['id'])),konf::get()->langTexty("u_login_upr"));
					if(user::get()->adminLogi()){						
			 			echo interfejs::przyciskEl("table",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_logiarch","id_u"=>$dane['id'])),konf::get()->langTexty("u_login_logi"));
					}
				}	
			}
			echo interfejs::przyciskEl("arrow_join",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_arch","szuk_typ"=>$szuk_typ)),konf::get()->langTexty("poziomdogory"));		
								
			echo "</tr></table></div>";
		}
	
	}	
	
	
	public function menuEdycja($id_u){	
	
		if(user::get()->zalogowany()&&!konf::get()->getKonfigTab("u_konf",'profilprosty')&&$id_u==user::get()->id()){
		
			$akcja=konf::get()->getAkcja();
				
			echo tab_nagl();
			echo "<tr>";
			
			echo "<td class=\"tlo";
			if($akcja=="u_edytuj"){
				echo "3";
			} else {
				echo "4";
			}
			echo "\">";
			echo interfejs::linkEl("user_edit",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_edytuj")),"Edycja profilu");
			echo"</td>";	
			
			if(konf::get()->getKonfigTab("u_konf",'galeria')){				
			
				echo "<td class=\"tlo";
				if($akcja=="ugal_arch"||$akcja=="ugal_dodaj"||$akcja=="ugal_edytuj"){
					echo "3";
				} else {
					echo "4";
				}
				echo "\">";
				echo interfejs::linkEl("picture",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ugal_arch")),"Moja galeria");
				echo"</td>";		
				
			}			
			
			if(konf::get()->getKonfigTab("u_konf",'preferencje')){				
				echo "<td class=\"tlo";
				if($akcja=="u_preferencje"){
					echo "3";
				} else {
					echo "4";
				}
				echo "\">";
				echo interfejs::linkEl("cog",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_preferencje")),"Preferencje");
				echo"</td>";	
			}			
			
			
			if(konf::get()->getKonfigTab("u_konf",'opisowe')){					
				echo "<td class=\"tlo";
				if($akcja=="u_opisowe"){
					echo "3";
				} else {
					echo "4";
				}
				echo "\">";
				echo interfejs::linkEl("user_comment",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_opisowe")),"O mnie");
				echo"</td>";		
			}					
			
			if(konf::get()->getKonfigTab("u_konf",'zmianarozbita')||konf::get()->getKonfigTab("u_konf",'usuwanie')){				
				echo "<td class=\"tlo";
				if($akcja=="u_usun"||$akcja=="u_haslo"||$akcja=="u_email"||$akcja=="u_zaawansowane"){
					echo "3";
				} else {
					echo "4";
				}
				echo "\">";
				echo interfejs::linkEl("cog",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_zaawansowane")),"Zaawansowane");
				echo"</td>";	
			}							
			
			echo "</tr>";
			echo tab_stop();
			
		}
	
	}
	

	//formularz edycja/dodawanie kont
	public function haslo(){	
		
		$dane=user::get()->getDane();	
		$this->menuEdycja(user::get()->id());								
		
		echo tab_nagl("Formularz zmiany hasła:");		
	
		echo "<tr><td class=\"tlo3 lewa\">";

		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"u_h","u_h");	
		$dane=$form->odczyt($dane);
		
		?><script type="text/javascript">	
		function spr_formh(){			
			document.u_h.haslo.value=document.u_h.haslo.value.trim();			
			if(document.u_h.haslo.value.length<<?php echo konf::get()->getKonfigTab("u_konf",'haslo_dl'); ?>&&document.u_h.haslo.value.length>0){ 
				form_set_error('haslo','<?php echo htmlspecialchars(konf::get()->langTexty("login_u_loginza")); ?>');			
			}	else if(document.u_h.haslo.value!=document.u_h.haslo_2.value) { 			
				form_set_error('haslo','<?php echo htmlspecialchars(konf::get()->langTexty("login_u_hasla")); ?>');			
			}		
		}
		</script><?php		
					
		echo $form->spr(array(1=>"haslo",2=>"haslostare"),""," spr_formh(); ");		

		echo $form->getFormp();
		echo $form->przenies(array("akcja"=>konf::get()->getAkcja()."2"));

	 	echo $form->input("password","haslostare","haslostare","","formularz f_dlugi",32," autocomplete=\"off\"");			
		echo interfejs::label("haslostare","podaj aktualne hasło*","",true);						
		echo "<br /><br />";

		echo $form->input("password","haslo","haslo","","f_dlugi",32," autocomplete=\"off\"");
		echo interfejs::label("haslo",konf::get()->langTexty("login_u_haslo"),"",true);								
		echo "<br />";
		
		echo $form->input("password","haslo_2","haslo_2","","f_dlugi",32," autocomplete=\"off\"");	
		echo interfejs::label("haslo_2",konf::get()->langTexty("login_u_haslo2"),"",true);						
		echo "<div class=\"male\">".konf::get()->langTexty("login_u_haslomusi")." ";
		echo konf::get()->getKonfigTab("u_konf",'haslo_dl')." ".konf::get()->langTexty("login_u_haslomusi2")."</div>";
				
		echo "<br />";
		echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");		
		
		echo $form->getFormk();

		echo "</td></tr>";
		
		echo "<tr class=\"srodek\">";
		echo "<td class=\"tlo4\">".interfejs::linkEl("user_edit",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_edytuj","id_u"=>user::get()->id())),konf::get()->langTexty("u_login_dane_edytujkonto"))."</td>";
		echo "</tr>";			
		
		echo tab_stop();

	}		
	
	
	//dodanie konta
	public function haslo2(){

		$haslostare=konf::get()->getZmienna("haslostare");		
		$haslo=tekstForm::doSql(konf::get()->getZmienna("haslo"));
		$haslo_2=tekstForm::doSql(konf::get()->getZmienna("haslo_2"));

		$dane=array();
		$testy=array();
		
		$ok=false;

		//haslo 2x identyczne
		if((!empty($haslo)&&!empty($haslo_2)&&$haslo==$haslo_2)){
			$ok=true;			
		} else {
			konf::get()->setInvalid('haslo');						
			konf::get()->setKomunikat(konf::get()->langTexty("login_u_brakdanychl4"),"error"); 
		}

		if($ok){
			$ok=false;
			//haslo poprawna forma
			if(user::get()->frazaCheck($haslo,konf::get()->getKonfigTab("u_konf",'haslo_dl'),false)){
				$ok=true;			
			} else {
				konf::get()->setInvalid('haslo');					
				konf::get()->setKomunikat(konf::get()->langTexty("login_u_brakdanychl5"),"error"); 
			}
		}
		
		if($ok){
			if(empty($haslostare)||user::get()->hasloForma($haslostare)!=user::get()->getDane('haslo')){
				konf::get()->setInvalid('haslostare');					
				konf::get()->setKomunikat("Nieprawidłowe dotychczasowe hasło!","error"); 			
				$ok=false;
			}		
		}
		
		if($ok){
			
			//generator zapytania insert/update
			require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
			$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'uzytkownicy'),$dane);
			$sqldane->daneOdczyt();	
			$sqldane->setAutor(true);	
			$sqldane->setTesty($testy);			
				
			$haslo=user::get()->hasloForma($haslo);

			//dodaj dane zo zapytania
		 	$sqldane->setDane(array(
				"haslo"=>$haslo,
				"data_haslo"=>date("Y-m-d H:i:s")
			));							
				
			$sqldane->dodajDaneE();		
													
			$sqldane->dodaj(" WHERE id='".user::get()->id()."'".user::get()->getSqlAdd());
								
			//wykonaj zapytanie
			if($sqldane->getSql()){
					
				konf::get()->_bazasql->zap($sqldane->getSql());
				konf::get()->setKomunikat("Nowe hasło zostało poprawnie zapisane","");
				user::get()->update();
				konf::get()->setAkcja("u_dane");				
				
			} else {
			
				konf::get()->setKomunikat("Hasło nie zostało","error");				
				konf::get()->setAkcja("u_haslo");		
								
			}

		} else {
			konf::get()->setAkcja("u_haslo");			
		}

	}		

	
	//formularz edycja/dodawanie kont
	public function email(){

		$dane=user::get()->getDane();
		
		$this->menuEdycja(user::get()->id());			
					
		echo tab_nagl("Formularz zmiany adresu email:");		
	
		echo "<tr><td class=\"tlo3 lewa\">";

		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"u_m","u_m");	
		$dane=$form->odczyt($dane);
		
		?><script type="text/javascript">	
		function spr_formm(){			
			document.u_m.email.value=document.u_m.email.value.trim();			
			if(!spr_email(document.u_m.email.value)) { 
				form_set_error('email','<?php echo htmlspecialchars(konf::get()->langTexty("login_u_bemail")); ?>');			
			}	
		}
		</script><?php		
					
		echo $form->spr(array(1=>"email",2=>"haslostare"),""," spr_formm(); ");		

		echo $form->getFormp();
		echo $form->przenies(array("akcja"=>konf::get()->getAkcja()."2"));

	 	echo $form->input("password","haslostare","haslostare","","formularz f_dlugi",32," autocomplete=\"off\"");	
		echo interfejs::label("haslostare","podaj aktualne hasło*","",true);						
		echo "<br />";
		echo $form->input("text","email","email",$dane['email'],"formularz f_dlugi",60," autocomplete=\"off\"");
		echo interfejs::label("email","podaj nowy adres email*","",true);				

		echo "<br />";
		echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");		
		
		echo $form->getFormk();

		echo "</td></tr>";
	
		echo "<tr class=\"srodek\">";
		echo "<td class=\"tlo4\">".interfejs::linkEl("user_edit",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_edytuj","id_u"=>user::get()->id())),konf::get()->langTexty("u_login_dane_edytujkonto"))."</td>";
		echo "</tr>";			
		
		echo tab_stop();

	}		
	
	
	//dodanie konta
	public function email2(){

		$haslostare=konf::get()->getZmienna("haslostare");		
		$email=konf::get()->getZmienna("email");		
		$testy=array();
		$dane=array();
		$ok=true;

		if(empty($email)||!preg_match("/".tekstForm::getEmailForma()."/",$email)){
			konf::get()->setInvalid('email');					
			konf::get()->setKomunikat("login_u_brakdanychl3","error"); 			
			$ok=false;
		}		

		if($ok){
			if(empty($haslostare)||user::get()->hasloForma($haslostare)!=user::get()->getDane('haslo')){
				konf::get()->setInvalid('haslostare');					
				konf::get()->setKomunikat("Nieprawidłowe hasło!","error"); 			
				$ok=false;
			}		
		}
		
		if($ok){
			
			//generator zapytania insert/update
			require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
			$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'uzytkownicy'),$dane);
			$sqldane->setAutor(true);		
			
			if(konf::get()->getKonfigTab("u_konf",'zmianapotwemail')){
			
				$sprcheck=user::get()->genSid("sprcheck");				
							
				$tresc="Dokonaleś zmiany adresu email na stronie ".konf::get()->getKonfigTab('nazwa_www')." ( ".konf::get()->getKonfigTab('adres_www')." )\n\n";
				$tresc.="Twój nowy email to ".$email."\n";
				$tresc.="Aby potwierdzić jego autentyczność klikni w podany link:\n";				
				$tresc.="<a href=\"".konf::get()->getKonfigTab('adres_www').konf::get()->getKonfigTab("plik")."?akcja=u_email3&id_u=".user::get()->id()."&sprcheck=".$sprcheck."\">".konf::get()->getKonfigTab('adres_www').konf::get()->getKonfigTab("plik")."?akcja=u_email3&id_u=".user::get()->id()."&sprcheck=".$sprcheck."</a>\n\n";

				require_once(konf::get()->getKonfigTab('klasy')."class.wyslijemail.php");													
				$wyslij=new wyslijemail(konf::get()->langTexty("login_u_email0"),$tresc,user::get()->email());
				$wyslij->setNadawca(konf::get()->getKonfigTab('kontakt_email'),konf::get()->getKonfigTab('kontakt_nadawca'));	
				$wyslij->wykonaj();		
				
				$sqldane->setDane(array("email2"=>$email));	
				$sqldane->setDane(array("sprcheck"=>$sprcheck));					

			} else {
			
				$sqldane->setDane(array("email"=>$email));		
				
			}
							
			$sqldane->dodajDaneE();															
			$sqldane->dodaj(" WHERE id='".user::get()->id()."'".user::get()->getSqlAdd());
								
			//wykonaj zapytanie
			if($sqldane->getSql()){
					
				konf::get()->_bazasql->zap($sqldane->getSql());
				konf::get()->setKomunikat("Email został zapisany","");
				user::get()->update();
				konf::get()->setAkcja("u_dane");				
				
			} else {
				konf::get()->setKomunikat("Email nie został zapisany","error");				
				konf::get()->setAkcja("u_email");						
			}

		} else {
			konf::get()->setAkcja("u_email");			
		}

	}		
		

	public function email3(){

		$id_u=tekstForm::doSql(konf::get()->getZmienna("id_u","id_u"));
		$sprcheck=tekstForm::doSql(konf::get()->getZmienna("sprcheck","sprcheck"));			
		
		if(user::get()->zalogowany()){
			$id_u=user::get()->id();
		}

		if(konf::get()->getKonfigTab("u_konf",'zmianapotwemail')){		
			
			$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE id='".$id_u."' AND sprcheck='".$sprcheck."'");

			if(!empty($dane)){
			
				if(!empty($dane['email2'])){
				
					konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." SET email='".$dane['email2']."', email2='' WHERE id='".$dane['id']."'");
					konf::get()->setKomunikat("Poprawna weryfikacja danych. Twój nowy email to ".$dane['email2'],"");	
					user::get()->zapiszLog("zmiana adresu email","",$id_u,"");
					
					if(!user::get()->zalogowany()){
						konf::get()->setAkcja("u_zaloguj");
					} else {
						user::get()->update();
						konf::get()->setAkcja("u_dane");
					}
					
				} else {
					konf::get()->setKomunikat("Brak podanego nowego adresu email","error");
					konf::get()->setAkcja("u_dane");
				}
				
			} else {		
				konf::get()->setKomunikat("Niepoprawne dane weryfikacji adresu email","error");	
				konf::get()->setAkcja("u_dane");
			}
			
		}

	}		
	
	
  /**
   * blocked account action
   */		
	public function zablokowany(){
	
		echo tab_nagl("Brak dostępu");
		echo "<tr><td class=\"tlo3 srodek grube\" style=\"padding:20px;\">";
		echo "Niestety twój dostęp do konta użytkownika został zablokowany!";
		echo "</td></tr>";
		echo tab_stop();
	
	
	}		
	
	//formularz edycja/dodawanie kont
	public function usun(){
	
		if(konf::get()->getKonfigTab("u_konf",'usuwanie')){			
	
			$this->menuEdycja(user::get()->id());				
			
			echo tab_nagl("Usuwanie konta z portalu");

			echo "<tr><td class=\"tlo3\">";

			echo "<div class=\"grube\">Czy na pewno chceszusunąć swoje konto?</div>";
			
			echo "<div>Usunięcie konta spowoduje trwałe i nieodwracalne wykasowanie danych związanych z twoim profilem użytkownika.</div>";	
			echo "<br />";		
			
			?><script type="text/javascript">			
			function usunupotw(ok){			
				if(ok){
					document.uu.akcja.value='u_usun2';
				} else {
					document.uu.akcja.value='u_dane';
				}		
				
				if(spr_form_uu()){
					document.uu.submit();			
				}
				
			}			
			</script><?php			

			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"uu","uu");	
								
			echo $form->spr(array(1=>"haslostare"));		

			echo $form->getFormp();
			echo $form->przenies(array("akcja"=>konf::get()->getAkcja()."2"));

		 	echo $form->input("password","haslostare","haslostare","","formularz f_dlugi",32," autocomplete=\"off\"");						
			echo interfejs::label("haslostare","podaj aktualne hasło*","",true);					
			echo 	"<br /><br />";
			echo $form->input("button","","","Tak, usuwam","formularz2 f_sredni",""," onclick=\"usunupotw(true);\"");
			echo "&nbsp;&nbsp;";
			echo $form->input("button","","","Nie, rezygnuję","formularz2 f_sredni",""," onclick=\"usunupotw(false);\"");

			echo $form->getFormk();					

			echo "</td></tr>";
			
		 	echo "<tr><td class=\"tlo4\">";	
			echo interfejs::linkEl("user",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane")),"Moje konto");
			echo "</td></tr>";
			
			echo tab_stop();
			
		}

	}		
	
	
	//dodanie konta
	public function usun2(){

		$haslostare=konf::get()->getZmienna("haslostare");		

		if(konf::get()->getKonfigTab("u_konf",'usuwanie')){				
		
			if(empty($haslostare)||user::get()->hasloForma($haslostare)!=user::get()->getDane('haslo')){
			
				konf::get()->setInvalid('haslostare');					
				konf::get()->setKomunikat("Nieprawidłowe dotychczasowe hasło!","error"); 			
				konf::get()->setAkcja("u_usun");	
				
			} else {

				$dane=user::get()->getDane();				
				
			  if(konf::get()->isMod('znajomi')){						
					konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'znajomi')." WHERE id_u='".$dane['id']."'");
					konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'zablokowani')." WHERE id_u'".$dane['id']."'");	
				}
				
			  if(konf::get()->isMod('grupy')){	
						
				  $zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." WHERE id_u='".$dane['id']."' AND status=1");
					konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." WHERE id_u='".$dane['id']."'");
				  while($dane2=konf::get()->_bazasql->fetchAssoc($zap)){
					  konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'grupy')." g SET g.osoby=(SELECT COUNT(u.id) FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." u WHERE u.id_grupa=g.id AND u.status=1) WHERE g.id=".$dane2['id_grupa']);
					}
					
				}		
								
			  if(konf::get()->isMod('ugal')){	
						
				  $zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy_galeria')." WHERE id_matka='".$dane['id']."'");
				  while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
						$this->usunImg($dane,konf::get()->getKonfigTab("u_konf",'galeria_kat'),2,"img");						
					}
					konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy_galeria')." WHERE id_matka='".$dane['id']."'");
					
				}						
				
			  if(konf::get()->isMod('poczta')){						
					konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'poczta')." WHERE ((id_odb='".$dane['id']."' AND typ=1) OR (id_wys='".$dane['id']."' AND typ=2))");
				}		
				
				$this->usunImg($dane,konf::get()->getKonfigTab("u_konf",'kat'),3,"img");									
				konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE id='".$dane['id']."'");												
				user::get()->wyloguj();
				konf::get()->setKomunikat("Konto zostało usunięte");				
					
			}

		} else {
			konf::get()->setAkcja("u_dane");			
		}

	}		
	
	
	
	//formularz edycja/dodawanie kont
	public function preferencje(){
	
		if(konf::get()->getKonfigTab("u_konf",'preferencje')){		
		
			$dane=user::get()->getDane();	
	
			$this->menuEdycja(user::get()->id());				
			
			echo tab_nagl("Preferencje konta");

			echo "<tr><td class=\"tlo3\">";			

			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"up","up");	
								
			echo $form->getFormp();
			echo $form->przenies(array("akcja"=>konf::get()->getAkcja()."2"));
			
			echo "<table border=\"0\">";
			
			if(konf::get()->getKonfigTab("u_konf",'powiadamianie')){				
			
				echo "<tr valign=\"middle\">";			
				echo "<td>Czy przesyłać powiadomienia o nowych wiadomościach:</td>";			
				echo "<td>";			
				echo $form->select("wys_niepowiadomienia","wys_niepowiadomienia",array(0=>"TAK",1=>"NIE"),$dane['wys_niepowiadomienia'],"f_krotki");			
				echo "</td>";			
				echo "</tr>";
				
			}
						
			echo "<tr valign=\"middle\">";			
			echo "<td>Czy profil ma być widoczny w wyszukiwarce użytkowników:</td>";			
			echo "<td>";			
			echo $form->select("wys_niewyszukiwarka","wys_niewyszukiwarka",array(0=>"TAK",1=>"NIE"),$dane['wys_niewyszukiwarka'],"f_krotki");			
			echo "</td>";			
			echo "</tr>";		
									
			echo "<tr valign=\"middle\">";			
			echo "<td>Dane kontaktowe widzą:</td>";			
			echo "<td>";			
			echo $form->select("wys_kontaktowe","wys_kontaktowe",array(0=>"wszyscy",1=>"tylko znajomi",2=>"nikt"),$dane['wys_kontaktowe'],"f_sredni");			
			echo "</td>";			
			echo "</tr>";			
			
			echo "<tr valign=\"middle\">";			
			echo "<td>Dane opisowe o mnie widzą:</td>";			
			echo "<td>";			
			echo $form->select("wys_opisowe","wys_opisowe",array(0=>"wszyscy",1=>"tylko znajomi",2=>"nikt"),$dane['wys_opisowe'],"f_sredni");			
			echo "</td>";			
			echo "</tr>";						
				
			if(konf::get()->getKonfigTab("u_konf",'galeria')){								
			
				echo "<tr valign=\"middle\">";			
				echo "<td>Galerie zdjęciowe widzą:</td>";			
				echo "<td>";			
				echo $form->select("wys_galerie","wys_galerie",array(0=>"wszyscy",1=>"tylko znajomi",2=>"nikt"),$dane['wys_galerie'],"f_sredni");			
				echo "</td>";			
				echo "</tr>";		
				
			}
			
			if(konf::get()->getKonfigTab("u_konf",'koment')){				
			
				echo "<tr valign=\"middle\">";			
				echo "<td>Komentarze i opinie widzą:</td>";			
				echo "<td>";			
				echo $form->select("wys_koment","wys_koment",array(0=>"wszyscy",1=>"tylko znajomi",2=>"nikt"),$dane['wys_koment'],"f_sredni");			
				echo "</td>";			
				echo "</tr>";		
				
			}								
			
			echo "</table>";
				
			echo "<br />";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");		
			
			echo $form->getFormk();					

			echo "</td></tr>";
			
		 	echo "<tr><td class=\"tlo4\">";	
			echo interfejs::linkEl("user",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane")),"Moje konto");
			echo "</td></tr>";
			
			echo tab_stop();
			
		}

	}		
	
		
		
	//dodanie konta
	public function preferencje2(){
	
		if(konf::get()->getKonfigTab("u_konf",'preferencje')){		
		
			$dane=array(
				"wys_niepowiadomienia"=>0,
				"wys_niewyszukiwarka"=>0,		
				"wys_kontaktowe"=>0,					
				"wys_opisowe"=>0,				
				"wys_galerie"=>0,	
				"wys_koment"=>0,
			);
			
			$testy[]=array("zmienna"=>"wys_niepowiadomienia","test"=>"truefalse",
				"param"=>array(
					"wartosc"=>1
				)
			);		
			
			$testy[]=array("zmienna"=>"wys_niewyszukiwarka","test"=>"truefalse",
				"param"=>array(
					"wartosc"=>1
				)
			);	
			
			$testy[]=array("zmienna"=>"wys_kontaktowe","test"=>"liczba",
				"param"=>array(
					"min"=>0,
					"max"=>2,
					"domyslny"=>0
				)
			);	
			
			$testy[]=array("zmienna"=>"wys_opisowe","test"=>"liczba",
				"param"=>array(
					"min"=>0,
					"max"=>2,
					"domyslny"=>0
				)
			);		
			
			$testy[]=array("zmienna"=>"wys_galerie","test"=>"liczba",
				"param"=>array(
					"min"=>0,
					"max"=>2,
					"domyslny"=>0
				)
			);	
			
			$testy[]=array("zmienna"=>"wys_koment","test"=>"liczba",
				"param"=>array(
					"min"=>0,
					"max"=>2,
					"domyslny"=>0
				)
			);												
			
			//generator zapytania insert/update
			require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
			$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'uzytkownicy'),$dane);
			$sqldane->daneOdczyt();	
			$sqldane->setAutor(true);	
			$sqldane->setTesty($testy);			
					
			$sqldane->dodajDaneE();		
														
			$sqldane->dodaj(" WHERE id='".user::get()->id()."'".user::get()->getSqlAdd());
									
			//wykonaj zapytanie
			if($sqldane->getSql()){
					
				konf::get()->_bazasql->zap($sqldane->getSql());
				konf::get()->setKomunikat("Dane zostały poprawnie zapisane","");
				user::get()->update();

			} 
			
		}

	}		
	
						
	public function zaawansowane(){
	
		$this->menuEdycja(user::get()->id());	
	
		echo tab_nagl("Konto - opcje zaawansowane");
		echo "<tr><td class=\"tlo3 lewa\">";
		
		echo "<div class=\"grube\">Wybierz jedną z zaawansowanych opcji edycji Twojego konta</div><br />";
		
		echo "<ul>";	
		
		if(konf::get()->getKonfigTab("u_konf",'preferencje')){		
			echo "<li><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_preferencje"))."\">Preferencje dostępności</a></li>";		
		}					
		
		if(konf::get()->getKonfigTab("u_konf",'czarna')){		
			echo "<li><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_czarna"))."\">Czarna lista</a></li>";		
		}			
		
		if(konf::get()->getKonfigTab("u_konf",'zmianarozbita')){			
			echo "<li><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_haslo"))."\">Zmiana hasła</a></li>";
			echo "<li><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_email"))."\">Zmiana adresu email</a></li>";		
		}
		if(konf::get()->getKonfigTab("u_konf",'usuwanie')){		
			echo "<li><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_usun"))."\">Usuwanie konta</a></li>";		
		}	
		echo "</ul>";
		
		echo "</td></tr>";
		echo tab_stop();
	
	}
	
	
	//formularz edycja/dodawanie kont
	public function opisowe(){
	
		if(konf::get()->getKonfigTab("u_konf",'opisowe')){		
		
			$dane=user::get()->getDane();	
	
			$this->menuEdycja(user::get()->id());				
			
			echo "<div class=\"tlo2\">Więcej o mnie:</div>";
			echo "<div class=\"tlo3 tlo3l\">";			

			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"up","up");	
								
			echo $form->getFormp();
			echo $form->przenies(array("akcja"=>konf::get()->getAkcja()."2"));
			
			echo interfejs::label("omnie","kilka słów o mnie:");										
			echo "<br />";		
			echo $form->textarea("omnie","omnie",$dane['omnie'],"f_bdlugi",8);					
			echo "<br /><br />";
			
			echo interfejs::label("zainteresowania","moje zainteresowania:");										
			echo "<br />";		
			echo $form->textarea("zainteresowania","zainteresowania",$dane['zainteresowania'],"f_bdlugi",5);					
			echo "<br /><br />";			
				
			echo interfejs::label("praca","praca:");										
			echo "<br />";		
			echo $form->textarea("praca","praca",$dane['praca'],"f_bdlugi",5);					
			echo "<br /><br />";
			
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");		
			
			echo $form->getFormk();					

			echo "</div>";
			
		 	echo "<div class=\"tlo4 tlo3l\">";	
			echo interfejs::linkEl("user",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane")),"Moje konto");
			echo "</div>";
			
		}

	}		
	
		
		
	//dodanie konta
	public function opisowe2(){
	
		if(konf::get()->getKonfigTab("u_konf",'opisowe')){		
		
			$dane=array(
				"omnie"=>"",
				"zainteresowania"=>"",
				"praca"=>"",				
			);	
			
			$testy=array();										
			
			//generator zapytania insert/update
			require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
			$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'uzytkownicy'),$dane);
			$sqldane->daneOdczyt();	
			$sqldane->setAutor(true);	
			$sqldane->setTesty($testy);			
					
			$sqldane->dodajDaneE();		
														
			$sqldane->dodaj(" WHERE id='".user::get()->id()."'".user::get()->getSqlAdd());
									
			//wykonaj zapytanie
			if($sqldane->getSql()){
					
				konf::get()->_bazasql->zap($sqldane->getSql());
				konf::get()->setKomunikat("Dane zostały poprawnie zapisane","");
				user::get()->update();

			} 
			
		}

	}	
	
		
	public function powitalna(){
	
		if(user::get()->zalogowany()){
		
			$this->powitalnazalogowany();
		
		} else {

			$this->powitalnaniezalogowany();		
		
		}	
	
	}	
	
	private function powitalnaniezalogowany(){
	
		$this->ostatnioKonta();
		
		$this->ostatnioZdjeciaAll();
		
		$this->ostatnioGrupy();				

	}
	
	
	private function powitalnazalogowany(){

		$this->ostatnioKonta();	
		
		$this->ostatnioZdjeciaAll();			
		
		$this->ostatnioGrupy();	
				
	}
	
	
	private function ostatnioKonta(){
	
		$ile=4;
								
		echo "<div class=\"nowa_l\" style=\"padding-bottom:4px;\">";
		
		echo tab_nagl("Ostatnio założone konta:",$ile);
		
		echo "<tr class=\"srodek\" valign=\"top\">";
		
		$zap=konf::get()->_bazasql->zap("SELECT u.* FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u WHERE 1 ".user::get()->getSqlAdd("u")." AND u.img!=0 ORDER BY u.autor_kiedy DESC, u.id DESC LIMIT 0,".$ile);
		
		$i=0;
		
		if(konf::get()->_bazasql->numRows($zap)){
		
			while($dane2=konf::get()->_bazasql->fetchAssoc($zap)){		
			
				echo "<td class=\"tlo3\" style=\"width:25%\">";
				u_wizytowka($dane2,true,($dane2['id']==user::get()->id()));
				echo "</td>";		
				
				$i++;	
			
			}
			
			if($i<$ile){
				
				while($i<$ile){
					echo "<td class=\"tlo3\" style=\"width:25%\">&nbsp;</td>";
					$i++;
				}
				
			}
			
			echo "</tr>";
			
			echo "<tr><td class=\"tlo4 srodek\" colspan=\"".$ile."\">";
			echo interfejs::linkEl("group",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_szukaj")),"wyszukaj swoich znajomych");
			echo "</td></tr>";
			
		}
			
		echo tab_stop();
		echo "</div>";
	
	}
	
	
	
	public function ostatnioZdjeciaAll(){

		$ile=4;		
		$i=0;			
		
		if(konf::get()->isMod("ugal")){	
		
			$zap=konf::get()->_bazasql->zap("SELECT z.*, u.imie, u.nazwisko, u.login FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy_galeria')." z, ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u WHERE z.autor_id=u.id AND z.status=1 ".user::get()->getSqlAdd("u")." ORDER BY z.autor_kiedy DESC, z.id DESC LIMIT 0,".$ile);		
			
			if(konf::get()->_bazasql->numRows($zap)){		
				
				echo "<div class=\"nowa_l\" style=\"padding-top:4px;\">";
				
				echo tab_nagl("Najnowsze zdjęcia użytkowników:",$ile);				
				echo "<tr class=\"srodek\" valign=\"top\">";
				
				require_once(konf::get()->getKonfigTab('mod_kat')."ugal/class.ugal.php");														
				$ugal=new ugal();										
							
				while($dane2=konf::get()->_bazasql->fetchAssoc($zap)){		
				
					echo "<td class=\"tlo3\" style=\"width:25%\">";
										
					echo "<div>";					
					echo $ugal->fotka($dane2,2,true);
					echo "</div>";
										
					echo "<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane","id_u"=>$dane2['autor_id']))."\">".user::get()->nazwa($dane2)."</a>";
					
					echo "<div class=\"male\">";
					echo "<div>Data dodania:</div>";
					echo "<div class=\"grube\">".substr($dane2['autor_kiedy'],0,16)."</div>";
					echo "</div>";
				
					
					echo "</td>";		
					
					$i++;	
				
				}
				
				if($i<$ile){
					
					while($i<$ile){
						echo "<td class=\"tlo3\" style=\"width:25%\">&nbsp;</td>";
						$i++;
					}
				
				}
				
				echo "</tr>";				
				echo tab_stop();				

				echo "</div>";
				
			}
		
		}
	
	}	
	
	private function ostatnioGrupy(){
	
		$ile=4;		
		$i=0;			
		
		if(konf::get()->isMod("grupy")){		
	
			$zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'grupy')." WHERE status=1 ORDER BY autor_kiedy DESC LIMIT 0,".$ile);

			require_once(konf::get()->getKonfigTab('mod_kat')."grupy/class.grupy.php");														
			$grupy=new grupy();		
			
			echo tab_nagl("Najnowsze grupy:",3);							
				
			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
			
				echo "<tr class=\"srodek\" valign=\"top\">";			
				
				echo "<td class=\"tlo4\" style=\"width:70px;\">";
				echo $grupy->grupyLogo($dane,2,true);
				echo "</td>";

				echo "<td class=\"tlo3 lewa\">";
				echo $grupy->grupyRekord($dane);
				echo "</td>";
				
				echo "<td class=\"tlo3 lewa\" style=\"width:120px;\">";	
				echo $grupy->dataForm($dane['autor_kiedy']);
				echo "<div><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane","id_u"=>$dane['autor_id']))."\">".$dane['autor_name']."</a></div>";				
				echo "</td>";				
					
				echo "</tr>";
					
			}
			konf::get()->_bazasql->freeResult($zap);		
			
			echo "<tr><td class=\"tlo4 srodek\" colspan=\"3\">";
			echo interfejs::linkEl("group",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_kat")),"zobacz wszystkie");
			echo "</td></tr>";			
			
			echo tab_stop();
			
		}
			
	
	}
	
		
  /**
   * empty action
   */		
	public function pusta(){
	
	
	}	
	
	/**
   * class constructor php5	
   */	
	public function __construct() {	
	
		$this->_admin=user::get()->adminU();

  }	
	
	
}


?>