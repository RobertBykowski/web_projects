<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

include_once(konf::get()->getKonfigTab('mod_kat')."poczta/konfig_inc.php");

class znajomi extends modul {

	/**
	 * Privates variables
	 */
		
	/**
	 * nazwa klasy
	 */				
  protected $_szuk=array(
		'szuk_nazwa'=>"",	
		'szuk_miejscowosc'=>"",			
		'szuk_plec'=>"",					
		'szuk_wiekod'=>"",					
		'szuk_wiekdo'=>"",					
		'szuk_tylkofotka'=>0			
	);			

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="poczta class";	
	
	
	/**
	 * search form
	 */		
	private function wyszukiwarka(){
	
		$this->szukZmienne(1);			
		
		echo tab_nagl("Wyszukaj nowych znajomych");		
		echo "<tr><td class=\"tlo3 lewa\">";
		
		?><script type="text/javascript">
		
		function spr_szuku(){
		
			if(document.u_szukaj.szuk_nazwa.value==''&&document.u_szukaj.szuk_miejscowosc.value==''){ 		
				form_set_error("szuk_nazwa",'Wybierz miasto lub wprowadż imię lub nazwisko poszukiwanej osoby!');			
			}				
		
		}
		
		</script><?php
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"u_szukaj","u_szukaj");		
		echo $form->spr(array(1=>"akcja"),"","spr_szuku();")
		;		
		echo $form->getFormp();
		echo $form->przenies(array("akcja"=>"znajomi_lista"));
		
		echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\">";
		echo "<tr valign=\"middle\">";
		
		echo "<td class=\"prawa\">";
		echo interfejs::label("szuk_nazwa",konf::get()->langTexty("znajomi_szuk_nazwisko"));
		echo"</td>";
		
		echo "<td>";
		echo $form->input("text","szuk_nazwa","szuk_nazwa",$this->_szuk['szuk_nazwa'],"f_dlugi",40);			
		echo "</td>";
		
		echo "<td class=\"prawa\">";
		echo interfejs::label("szuk_miejscowosc",konf::get()->langTexty("znajomi_szuk_miasto"));		
		echo "</td>";
		
		echo "<td>";
		echo $form->input("text","szuk_miejscowosc","szuk_miejscowosc",$this->_szuk['szuk_miejscowosc'],"f_dlugi",40);			
		echo "</td>";

		echo "</tr>";
		
		echo "<tr valign=\"middle\">";
				
		echo "<td class=\"prawa\">";
		echo interfejs::label("szuk_wiekod",konf::get()->langTexty("znajomi_szuk_wiekod"));	
		echo"</td>";				
		
		echo "<td>";
		echo $form->selectWylicz('szuk_wiekod','szuk_wiekod',6,120,$this->_szuk['szuk_wiekod'],"f_bkrotki","--");
		echo interfejs::label("szuk_wiekdo",konf::get()->langTexty("znajomi_szuk_wiekdo"),"",true);				
		echo " ";	
		echo $form->selectWylicz('szuk_wiekdo','szuk_wiekdo',120,6,$this->_szuk['szuk_wiekdo'],"f_bkrotki","--");					
		echo "</td>";		
		
		echo "<td class=\"prawa\">";
		echo interfejs::label("szuk_plec","Płeć:");	
		echo "</td>";		

		echo "<td>";
		$plec_tab=konf::get()->getKonfigTab("u_konf","plec_tab");		
		echo $form->select('szuk_plec','szuk_plec',$plec_tab,$this->_szuk['szuk_plec'],"f_sredni","--");		
		echo "&nbsp;";
		echo $form->input("submit","","","szukaj","formularz2 f_krotki");			
		echo "</td>";				
		
		echo "</tr>";		
		
		echo "<tr>";
		
		echo "<td></td>";

		echo "<td colspan=\"3\">";
		echo $form->checkbox("szuk_tylkofotka","szuk_tylkofotka",1,$this->_szuk['szuk_tylkofotka']);	
		echo interfejs::label("szuk_tylkofotka",konf::get()->langTexty("znajomi_szuk_tylkofotka"),"",true);					
		echo "</td>";
		echo "</tr>";
		
		echo "</table>";
		
		echo "<br /><div class=\"male\">pole osoby lub miasta musi być wypełnione</div>";

		echo $form->getFormk();		
		
		echo "</td></tr>";
		echo tab_stop();
				
	}
	
	
	/**
	 * search
	 */		
	public function szukaj(){
	
		$this->wyszukiwarka();
		
	}
	
	
	/**
	 * search list
	 */		
	public function lista(){	
	
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');						
		$sortuj=tekstForm::doSql(konf::get()->getZmienna('sortuj','sortuj'));
		$plec_tab=konf::get()->getKonfigTab("u_konf","plec_tab");	
		
		$ok=false;
				
		$tab_sort=array(	
			1=>"id",
			2=>"id DESC",
			3=>"nazwisko,imie,login", 
			4=>"nazwisko DESC, imie DESC, login DESC", 		
			5=>"miesjcowosc", 
			6=>"miejscowosc DESC", 
			7=>"plec", 
			8=>"plec DESC",
			9=>"ur_rok, ur_mc, ur_dzien", 
			10=>"ur_rok DESC, ur_mc DESC, ur_dzien DESC",
		);
		
		if(empty($tab_sort[$sortuj])){ 
			$sortuj=2;
		}	
		
		$link=$this->szukZmienne(1);					
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_lista")).$link;	
		
		if(konf::get()->getKonfigTab("znajomi_konf",'wys_grafika')){
			$colspan=konf::get()->getKonfigTab("znajomi_konf",'wys_kolumn');
		} else {
			$colspan=5;
		}
		
		$sql=" FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u WHERE 1 ";
		$sql.=" AND u.wys_niewyszukiwarka=0 ";
		
		if($this->_szuk['szuk_plec']){
			$sql.=" AND u.plec='".tekstForm::doSql($this->_szuk['szuk_plec'])."'";			
		}
		if($this->_szuk['szuk_tylkofotka']){
			$sql.=" AND u.img!=0";
		}		
		
		if($this->_szuk['szuk_miejscowosc']){
			$ok=true;
			$sql.=" AND LCASE(u.miejscowosc)='".tekstForm::doSql(tekstForm::male($this->_szuk['szuk_miejscowosc']))."'";
		}		
		
		if($this->_szuk['szuk_nazwa']){
		
			$this->_szuk['szuk_nazwa']=str_replace(","," ",tekstForm::male($this->_szuk['szuk_nazwa']));
			$szukaj_nazwa=explode(" ",$this->_szuk['szuk_nazwa']);
			if(!empty($szukaj_nazwa)&&is_array($szukaj_nazwa)){
				$i=0;
				$sql2="";
				reset($szukaj_nazwa);
				while(list($key,$val)=each($szukaj_nazwa)){
					$val=tekstForm::doLike(trim($val));
					if(tekstForm::utf8Strlen($val)>2){
						if($i>0){
							$sql2.=" OR ";
						}
						$sql2.="(LCASE(u.imie)='".$val."' OR LCASE(u.nazwisko)='".$val."' OR LCASE(u.login) LIKE '%".$val."%')";
						$i++;
					}
				}
				
				if($sql2){
					$sql.=" AND (".$sql2.")";
					$ok=true;					
				} 				
				
			}
			
		}

		$this->_szuk['szuk_wiekod']=tekstForm::doSql($this->_szuk['szuk_wiekod']+0);
		
    if(!empty($this->_szuk['szuk_wiekod'])){
      $sql.=" AND (ur_rok<'".(date("Y")-$this->_szuk['szuk_wiekod'])."' OR (ur_rok='".(date("Y")-$this->_szuk['szuk_wiekod'])."' AND (ur_mc<".date("n")." OR (ur_mc=".date("n")." AND ur_dzien<".date("j").")))) ";
    }
		
		$this->_szuk['szuk_wiekdo']=tekstForm::doSql($this->_szuk['szuk_wiekdo']+0);
					
    if(!empty($this->_szuk['szuk_wiekdo'])){
      $sql.=" AND (ur_rok>'".(date("Y")-$this->_szuk['szuk_wiekdo']+1)."' OR (ur_rok='".(date("Y")-$this->_szuk['szuk_wiekdo']+1)."' AND (ur_mc>".date("n")." OR (ur_mc=".date("n")." AND ur_dzien>=".date("j").")))) ";
    }
	
		$sql.=" AND u.id!='".user::get()->id()."'".user::get()->getSqlAdd("u");		
			
		$this->wyszukiwarka();		

		if($ok){

			$naw = new nawig("SELECT COUNT(u.id) AS ilosc ".$sql,$podstrona,konf::get()->getKonfigTab("znajomi_konf",'szuk_na_str'));
			$naw->naw($link."&amp;sortuj=".$sortuj);
			$podstrona=$naw->getPodstrona();			
			
			echo tab_nagl(konf::get()->langTexty("znajomi_l")." (".$naw->getWynikow()."):",$colspan);
			
			
			if(!konf::get()->getKonfigTab("znajomi_konf",'wys_grafika')){
			
				echo "<tr class=\"srodek\">";
				
				echo interfejs::sortEl($link."&amp;sortuj=",3,4,"nazwisko,imię",$sortuj);
				echo interfejs::sortEl($link."&amp;sortuj=",5,6,"miasto",$sortuj,150);
				echo interfejs::sortEl($link."&amp;sortuj=",7,8,"płeć",$sortuj,80);
				echo interfejs::sortEl($link."&amp;sortuj=",9,10,"wiek",$sortuj,70);
				echo interfejs::sortEl("","","","&nbsp;","",90);

				echo "</tr>";
			
			}		
			
			if($naw->getNaw()){
				echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
			}					
			
			if($naw->getWynikow()>0){
			
				if($naw->getNaw()){
					echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
				}			
				
				$zap=konf::get()->_bazasql->zap("SELECT u.* ".$sql." ORDER BY ".konf::get()->getKonfigTab("znajomi_konf",'szuk_sort')." LIMIT ".$naw->getStart().",".$naw->getIle());	

				if(!konf::get()->getKonfigTab("znajomi_konf",'wys_grafika')){			
				
					while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
					
						echo "<tr valign=\"middle\" class=\"lewa\">";

						echo "<td class=\"tlo3\">";		
												
						echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr valign=\"middle\">";

						$fotka=user::get()->obrazek($dane,"",3,"",true);	
													
						if($fotka){					
							echo "<td style=\"padding-right:5px;\">";
			   			echo $fotka;
							echo "</td>";
			  	  }					

						echo "<td>";														
						echo "<a class=\"grube\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane",'id_u'=>$dane['id']))."\">";
						echo tekstForm::wrapWbr(user::get()->nazwa($dane),30);
						echo "</a>";				
						
						echo "</td></tr></table>";
						
						echo "</td>";	
						
						echo "<td class=\"tlo3 srodek\">";
						echo $dane['miejscowosc'];
						echo "</td>";
						
						echo "<td class=\"tlo3 srodek\">";
						if(!empty($plec_tab[$dane['plec']])){
							echo $plec_tab[$dane['plec']];
						} else {
							echo "&nbsp;";
						}
						echo "</td>";						
						
						echo "<td class=\"tlo3\">";
						echo tekstForm::wiek($dane['ur_rok']."-".$dane['ur_mc']."-".$dane['ur_dzien']);
						echo "</td>";
						
						echo "<td class=\"tlo3 srodek\">";
						
						echo "<table border=\"0\" class=\"srodek\"><tr valign=\"top\">"; 					
						echo interfejs::przyciskEl("email_edit",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"poczta_wiadomosc","id_u"=>$dane['id'])),"wyślij wiadomość");										
						if($dane['id']!=user::get()->id()){						
							if(!user::get()->jestZnajomi($dane['id'])){					
								echo interfejs::przyciskEl("group_add",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_zapros","id_u"=>$dane['id'])),"zaproś do znajomych");					
							}	else {
								echo interfejs::przyciskEl("group_delete",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_usun","id_u"=>$dane['id'])),"usuń ze znajomych");
							}
						}
						echo "</tr></table>"; 							
						
						echo "</td>";
											
						echo "</tr>";
		
					}			
				
				} else {
					
					$i=0;
					
					while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
					
						if($i==0){
							echo "<tr valign=\"top\" class=\"srodek\">";
						}
						
						$i++;
						
						echo "<td class=\"tlo3\" style=\"width:25%\">";
						u_wizytowka($dane);
						echo "</td>";
						
						if($i==$colspan){
							$i=0;
							echo "</tr>";
						}
									
					}
								
					if($i>0){
						while($i<$colspan){
							$i++;
							echo "<td class=\"tlo3\" style=\"width:25%\">&nbsp;</td>";
						}
						echo "</tr>";
					}	
					
				}
								
				konf::get()->_bazasql->freeResult($zap);							
				
				if($naw->getNaw()){
					echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
				}				
							
			} else { 
	 			echo interfejs::brak($colspan);
			}
			
			echo tab_stop();
			
		} else {
			
			echo tab_nagl(konf::get()->langTexty("znajomi_l"));
			echo "<tr><td class=\"tlo3 srodek grube\" style=\"padding:10px;\">";
			
			echo "Musisz wybrać więcej parametrów wyszukiwania! <br />Wybierz miasto lub wprowadż imię lub nazwisko poszukiwanej osoby!";
			
			echo "</td></tr>";
			echo tab_stop();
			
		}
		
	}

	
  /**
   * if invitation exists send by me
   * @param int $id_u	
	 * @return bool	
   */		
	private function istniejeZaproszenie($id_u){
	
		$ok=false;		
		$id_u=$id_u+0;
		
		if(konf::get()->_bazasql->policz('id'," FROM ".konf::get()->getKonfigTab("sql_tab",'poczta')." WHERE id_autor='".user::get()->id()."' AND id_odb='".$id_u."' AND typ=2 AND zdefiniowana=1 AND wykonana=0")>0){
			$ok=true;
		}
		
		return $ok;
		
	}		
	
	
  /**
   * if invitation exists send to me
   * @param int $id_u	
	 * @return bool	
   */		
	private function istniejeZaproszony($id_u){
	
		$ok=false;
		$id_u=$id_u+0;		
		
		if(konf::get()->_bazasql->policz('id'," FROM ".konf::get()->getKonfigTab("sql_tab",'poczta')." WHERE id_odb='".user::get()->id()."' AND id_autor='".$id_u."' AND typ=1 AND zdefiniowana=1 AND wykonana=0")>0){
			$ok=true;
		}
		
		return $ok;
		
	}			
	
	
  /**
   * send invitation
   */		
	public function zapros(){
	
		$id_u=tekstForm::doSql(konf::get()->getZmienna('id_u','id_u')+0);	
		$ok=true;		
				
		//sprawdz czy nadawca nie jest na czarnej liscie adresata
		if($ok&&$this->istniejeZaproszony($id_u)){
			$ok=false;	
			$this->akceptuje(true);			
		}		
			
		if($ok){
		
			//pobierz dane adresata
			if(!empty($id_u)){
				$dane_u=konf::get()->_bazasql->pobierzRekord("SELECT u.* FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u WHERE u.id='".$id_u."'".user::get()->getSqlAdd("u"));
			}
					
			if(empty($dane_u)){
				$ok=false;
				konf::get()->setKomunikat(konf::get()->langTexty("znajomi_zapros_nieistnieje"),"error"); 								
			}
			
		}

		if($ok&&!user::get()->jestCzarna($id_u,false)){				
						
			//sprawdz czy juz ta wiadomosc nie byla wyslana
			if(!$this->istniejeZaproszenie($id_u)){	
			
				//sprawdzamy czy nie ma tej osoby w znajomych				
				if(!user::get()->jestZnajomi($id_u)){
						
					//zapisz w poczcie										
					if(konf::get()->isMod('poczta')){
					
						$tytul=konf::get()->langTexty("znajomi_zapros_tytul");
						
						$tresc="Witaj ".user::get()->nazwa($dane_u)."\n\n";			
						$tresc.=konf::get()->langTexty("znajomi_zapros_t1")." ";
						$tresc.="<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane","id_u"=>user::get()->id()),true,false)."\">".tekstForm::doSql(user::get()->nazwa())."</a>";
						$tresc.="\n\n";
						$tresc.="<b><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_akceptuje","id_u"=>user::get()->id()),true,false)."\">".konf::get()->langTexty("znajomi_zapros_akceptuje")."</a></b>\n";						
						$tresc.="Jeśli nie jesteś zainteresowany znajomością ";
						$tresc.="<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_zaproszenieodrzuc","id_u"=>user::get()->id()),true,false)."\">odrzuć zaproszenie</a>";
						
						require_once(konf::get()->getKonfigTab('mod_kat')."poczta/class.poczta.php");														
						$poczta=new poczta();													
						$id_w2=$poczta->zdefiniowana($dane_u,$tytul,$tresc,1);		
						
					}				
					
					
					if(!empty($id_w2)){	

						konf::get()->setKomunikat(konf::get()->langTexty("znajomi_zapros_wyslane")); 	
									
					}
					
	 			} else {
					konf::get()->setKomunikat(konf::get()->langTexty("znajomi_zapros_jestjuz"),"error"); 					
				}						
				
 			} else {
				konf::get()->setKomunikat(konf::get()->langTexty("znajomi_zapros_bylowys"),"error"); 					
			}						
										
		}

	}

	
  /**
   * accept invitation
   * @param bool $bylo	
   */		
	public function akceptuje($bylo=false){
	
		$id_u=tekstForm::doSql(konf::get()->getZmienna('id_u','id_u')+0);	
		$ok=true;				
		
		//pobierz dane adresata
		if(!empty($id_u)){
			$dane_u=konf::get()->_bazasql->pobierzRekord("SELECT u.* FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u WHERE u.id='".$id_u."'".user::get()->getSqlAdd("u"));
		}
				
		if(empty($dane_u)){
			$id_u="";
			$ok=false;
			konf::get()->setKomunikat(konf::get()->langTexty("znajomi_akcept_nieistnieje"),"error"); 								
		}


		if($ok&&!user::get()->jestCzarna($id_u)){
		
			//sprawdz czy istnieje zaproszenie
			if($this->istniejeZaproszony($id_u)){	
			
				$ok=false;		
				
				//zmien status wiadomosci
		    konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'poczta')." SET wykonana=1, data_odp=NOW() WHERE id_odb='".user::get()->id()."' AND id_autor='".$id_u."' AND typ=1 AND zdefiniowana=1 AND wykonana=0");										
			
				//sprawdzamy czy nie ma tej osoby w znajomych				
				if(!user::get()->jestZnajomi($id_u)){							
				
					$ok=true;
				
					//dodaje znajomego
		      konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'znajomi')." (id_u,id_gosc,data_dodania) VALUES('".user::get()->id()."','".$id_u."',NOW())");
					$id_w=konf::get()->_bazasql->insert_id;

					 //jesli dodano							
					if(!empty($id_w)){
					
						//podwyzszamy ilosc znajomych
						$this->updateZnajomi();
						
						//pobieramy aktualizavje listy znajomych
						user::get()->setZnajomiPobrano(false);
						user::get()->update();							
						
					}
					
				}

				//sprawdzamy drugas strone czy nie ma tej osoby w znajomych
				if(konf::get()->_bazasql->policz('id'," FROM ".konf::get()->getKonfigTab("sql_tab",'znajomi')." WHERE id_gosc='".user::get()->id()."' AND id_u='".$id_u."'")==0){
				
					$ok=true;
					
					//dodajemy znajomego
		      konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'znajomi')." (id_u,id_gosc,data_dodania) VALUES('".$id_u."','".user::get()->id()."',NOW())");	
					$id_w2=konf::get()->_bazasql->insert_id;		
					
					//podwyzszamy ilosc znajomych
					if(!empty($id_w2)){
						$this->updateZnajomi($id_u);
					}
					
				}
		
				if($ok){
					konf::get()->setKomunikat(konf::get()->langTexty("znajomi_akcept_przyjete")); 										
				} else {
					konf::get()->setKomunikat("Podana osoba już była wpisana na listę znajomych"); 						
				}								

 			} else {
				konf::get()->setKomunikat("Podane zaproszenie już zostało zrealizowane","error"); 					
			}						
										
		}
		
		konf::get()->setZmienna("_post",'id_u',"");			
					
	}	

	
  /**
   * remove friend
   */		
	public function usun(){
	
		$id_u=tekstForm::doSql(konf::get()->getZmienna('id_u','id_u')+0);	
		$id_tab=tekstForm::doSql(konf::get()->getZmienna('id_tab','id_tab'));	
		
		if(!empty($id_u)){
		  $query="'".$id_u."'";			
		} else if(!empty($id_tab)){	  
		  $query=tekstForm::tabQuery($id_tab);				
		}		
			 		
		if(!empty($query)){
		  konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'znajomi')." WHERE id_u='".user::get()->id()."' AND id_gosc IN (".$query.")");
			$ile=konf::get()->_bazasql->affected_rows;			
		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("znajomi_usuwaniebrak"),"error"); 			
		}
	
		//jesli wykonano							
		if(!empty($ile)){		
		
			//usun druga strone znajomych 
		  $zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'znajomi')." WHERE id_gosc='".user::get()->id()."' AND id_u IN (".$query.")");
			konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'znajomi')." WHERE id_gosc='".user::get()->id()."' AND id_u IN (".$query.")");			
			
			//przelicz nowe ilosci znajomych
			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
				$this->updateZnajomi($dane['id_u']);
			}			
			konf::get()->_bazasql->freeResult($zap);

			//przeliczamy ilosc znajomych
			$this->updateZnajomi();			
			user::get()->setZnajomiPobrano(false);
			user::get()->update();						
			konf::get()->setKomunikat(konf::get()->langTexty("usuwanie")); 						
				
		}							

		konf::get()->setZmienna("_post",'id_u',"");	
			
	}	
		
		
  /**
   * friends list
   */			
	public function arch(){	
	
		$id_u=tekstForm::doSql(konf::get()->getZmienna('id_u','id_u')+0);			
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');						
		$sortuj=tekstForm::doSql(konf::get()->getZmienna('sortuj','sortuj'));
		$plec_tab=konf::get()->getKonfigTab("u_konf","plec_tab");		
		
		$link=$this->szukZmienne(1);
				
		if(empty($id_u)){
			$id_u=user::get()->id();
		}								

		if(konf::get()->getKonfigTab("znajomi_konf",'wys_grafika')){
			$colspan=konf::get()->getKonfigTab("znajomi_konf",'wys_kolumn');
		} else {
			if($id_u==user::get()->id()){		
				$colspan=5;
			} else {
				$colspan=4;
			}
		}		
		
		$tab_sort=array(	
			1=>"u.id",
			2=>"u.id DESC",
			3=>"u.nazwisko,u.imie,u.login", 
			4=>"u.nazwisko DESC, u.imie DESC, u.login DESC", 		
			5=>"u.miejscowosc", 
			6=>"u.miejscowosc DESC", 
			7=>"u.plec", 
			8=>"u.plec DESC",
			9=>"z.data_dodania", 
			10=>"z.data_dodania DESC", 			
		);	
		
		if(empty($tab_sort[$sortuj])){
			$sortuj=3;
		}
		
		if($id_u==user::get()->id()){
			$dane_u=user::get()->getDane();
		} else {
			$dane_u=konf::get()->_bazasql->pobierzRekord("SELECT u.id, u.login, u.imie, u.nazwisko, u.miejscowosc, u.email FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u WHERE u.id='".$id_u."'".user::get()->getSqlAdd("u"));		
		}

		if(!empty($dane_u)&&!user::get()->jestCzarna($id_u)){

			$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_arch","id_u"=>$id_u)).$link;				
		
			$sql=" FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u, ".konf::get()->getKonfigTab("sql_tab",'znajomi')." z WHERE u.id=z.id_gosc AND z.id_u='".$id_u."' ".user::get()->getSqlAdd("u");
			
			if($this->_szuk['szuk_plec']){
				$sql.=" AND u.plec='".tekstForm::doSql($this->_szuk['szuk_plec'])."'";			
			}

			if($this->_szuk['szuk_miejscowosc']){
				$ok=true;
				$sql.=" AND LCASE(u.miejscowosc)='".tekstForm::doSql(tekstForm::male($this->_szuk['szuk_miejscowosc']))."'";
			}		
			
			if($this->_szuk['szuk_nazwa']){
			
				$this->_szuk['szuk_nazwa']=str_replace(","," ",tekstForm::male($this->_szuk['szuk_nazwa']));
				$szukaj_nazwa=explode(" ",$this->_szuk['szuk_nazwa']);
				if(!empty($szukaj_nazwa)&&is_array($szukaj_nazwa)){
					$i=0;
					$sql2="";
					reset($szukaj_nazwa);
					while(list($key,$val)=each($szukaj_nazwa)){
						$val=tekstForm::doSql(trim($val));
						if(tekstForm::utf8Strlen($val)>2){
							if($i>0){
								$sql2.=" OR ";
							}
							$sql2.="(LCASE(u.imie)='".$val."' OR LCASE(u.nazwisko)='".$val."' OR LCASE(u.login) LIKE '%".$val."%')";
							$i++;
						}
					}
					
					if($sql2){
						$sql.=" AND (".$sql2.")";
						$ok=true;					
					} 				
					
				}
				
			}			

			$naw = new nawig("SELECT COUNT(u.id) AS ilosc ".$sql,$podstrona,konf::get()->getKonfigTab("znajomi_konf",'na_str'));
			$naw->naw($link."&amp;sortuj=".$sortuj);
			$podstrona=$naw->getPodstrona();			
			
			if($id_u==user::get()->id()){
				$form=new formularz("post",konf::get()->getKonfigTab("plik"),"arch","arch");			
				echo $form->spr(array(1=>"akcja"),"","ok=spr_akcjau(document.arch.akcja,'znajomi_usun','".konf::get()->langTexty("czyusun")."');");			
				echo $form->getFormp();		
				$przenies=$this->_szuk;
				$przenies['podstrona']=$podstrona;
				$przenies['sortuj']=$sortuj;								
				echo $form->przenies($przenies);		
			}
						
			echo tab_nagl(konf::get()->langTexty("znajomi_arch_lista")." (".$naw->getWynikow()."):",$colspan);
			
			$this->nagloweku($dane_u,$colspan);

			if($id_u==user::get()->id()){						
				
				echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 lewa\">";	
				$akcje_tab['znajomi_szukaj']="wyszukaj nowych znajomych";					
							
				if($naw->getWynikow()>0){		
					if(konf::get()->getKonfigTab("znajomi_konf",'zaprosdo')){
						$akcje_tab['znajomi_zaprosdo']="zaproś do portalu";				
					}
					$akcje_tab['poczta_wiadomosc']="napisz do zaznaczonych";													
					$akcje_tab['poczta_wiadomosca']="napisz do wszystkich";						
					$akcje_tab['znajomi_usun']="usuń zaznaczone";		
				}			
				
				echo $form->selectAkcja($akcje_tab);	
				echo "</td></tr>";	
				
			}				

			if($naw->getWynikow()>0){
			
				if($id_u==user::get()->id()){				
					echo "<tr><td colspan=\"".$colspan."\" class=\"tlo4 srodek nobr\">";		
					echo $form->zaod("id_tab");		
					echo "</td></tr>";			
				}				
				
				if($naw->getNaw()){
					echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
				}		
				
			}
						
			if(!konf::get()->getKonfigTab("znajomi_konf",'wys_grafika')){
			
				echo "<tr class=\"srodek\">";
				if($id_u==user::get()->id()){				
					echo interfejs::sortEl($link."&amp;sortuj=",9,10,"data",$sortuj,80);				
				}
				echo interfejs::sortEl($link."&amp;sortuj=",3,4,"nazwisko,imię",$sortuj);
				echo interfejs::sortEl($link."&amp;sortuj=",5,6,"miasto",$sortuj,150);
				echo interfejs::sortEl($link."&amp;sortuj=",7,8,"płeć",$sortuj,80);	
				echo interfejs::sortEl("","","","&nbsp;","",66);
				echo "</tr>";
			
			}			

			if($naw->getWynikow()>0){				
			
				$zap=konf::get()->_bazasql->zap("SELECT u.*, z.data_dodania ".$sql." ORDER BY ".$tab_sort[$sortuj]." LIMIT ".$naw->getStart().",".$naw->getIle());					
				
				if(!konf::get()->getKonfigTab("znajomi_konf",'wys_grafika')){			
				
					while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
					
						echo "<tr valign=\"middle\" class=\"lewa\">";
						
						if($id_u==user::get()->id()){		
												
							echo "<td class=\"tlo4 srodek male\">";			
							echo "<div>";									
							echo $form->checkbox("id_tab[]","id_".$dane['id'],$dane['id'],"");
							echo "</div>";
							$dane['data_dodania']=substr($dane['data_dodania'],0,16);
							echo str_replace(" ","<br />",$dane['data_dodania']);				
							echo "</td>";				
									
						}
						
						echo "<td class=\"tlo3\">";	
						
						echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr valign=\"middle\">";
						
						$fotka=user::get()->obrazek($dane,"",3,"",true);	
													
						if($fotka){					
							echo "<td style=\"padding-right:5px;\">";
			   			echo $fotka;
							echo "</td>";
			  	  }											

						echo "<td>";														
						echo "<a class=\"grube\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane",'id_u'=>$dane['id']))."\">";
						echo tekstForm::wrapWbr(user::get()->nazwa($dane),30);
						echo "</a>";				
						
						echo "</td></tr></table>";
									
						echo "</td>";
						
						echo "<td class=\"tlo3 srodek\">";
						echo $dane['miejscowosc'];
						echo "</td>";
						
						echo "<td class=\"tlo3 srodek\">";
						if(!empty($plec_tab[$dane['plec']])){
							echo $plec_tab[$dane['plec']];
						} else {
							echo "&nbsp;";
						}
						echo "</td>";			
						
						echo "<td class=\"tlo3 srodek\">";
						
						echo "<table border=\"0\"><tr valign=\"top\" class=\"srodek\">"; 					
						echo interfejs::przyciskEl("email_edit",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"poczta_wiadomosc","id_u"=>$dane['id'])),"wyślij wiadomość");	
						if($id_u==user::get()->id()){							
							echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_usun","id_u"=>$dane['id'])),"usuń ze znajomych");
						} else {						
							if(!user::get()->jestZnajomi($dane['id'])&&$dane['id']!=user::get()->id()){					
								echo interfejs::przyciskEl("group_add",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_zapros","id_u"=>$dane['id'])),"zaproś do znajomych");	
							}												
						}
						echo "</tr></table>"; 							
						
						echo "</td>";
											
						echo "</tr>";
		
					}								
				
				} else {				
					
					$i=0;							
					
					while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
					
						if($i==0){
							echo "<tr valign=\"top\" class=\"srodek\">";
						}
						
						$i++;
						
						echo "<td class=\"tlo3\" style=\"width:25%\">";
						u_wizytowka($dane,true,($id_u==user::get()->id()));
						
						if($id_u==user::get()->id()){								
							echo "<div>";
							echo "<table class=\"srodek\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr>"; 						
							echo "<td class=\"srodek\">";
							echo $form->checkbox("id_tab[]","id_".$dane['id'],$dane['id'],"");
							echo "</td>";													
							echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_usun",'id_u'=>$dane['id']))); 
							echo "</tr></table>";						
							echo "</div>";		
						}					
					
						echo "</td>";
						
						if($i==$colspan){
							$i=0;
							echo "</tr>";
						}
									
					}
									
					if($i>0){
						while($i<$colspan){
							$i++;
							echo "<td class=\"tlo3\" style=\"width:25%\">&nbsp;</td>";
						}
						echo "</tr>";
					}	
					
				}		
									
				konf::get()->_bazasql->freeResult($zap);
				
				if($naw->getNaw()){
					echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
				}				
							
			} else { 
	 			echo interfejs::brak($colspan);
			}
			
			if($id_u==user::get()->id()){					
				echo "<tr><td class=\"tlo4 srodek\" colspan=\"".$colspan."\">".interfejs::linkEl("group_add",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_szukaj")),"Wyszukaj nowych znajomych")."</td></tr>";
			}
			
			echo tab_stop();	
			
			if($id_u==user::get()->id()){				
				echo $form->getFormk();					
			}
			
			$this->szukZmienne(1);			
			
			echo tab_nagl("Szujak wśród swoich kontaktów");		
			echo "<tr><td class=\"tlo3 lewa\">";
			
			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"u_szukaj","u_szukaj");		
			
			echo $form->getFormp();
			echo $form->przenies(array("akcja"=>"znajomi_arch"));
			
			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\">";
			echo "<tr valign=\"middle\">";
			
			echo "<td class=\"prawa\">";
			echo interfejs::label("szuk_nazwa",konf::get()->langTexty("znajomi_szuk_nazwisko"));
			echo"</td>";
			
			echo "<td>";
			echo $form->input("text","szuk_nazwa","szuk_nazwa",$this->_szuk['szuk_nazwa'],"f_dlugi",40);			
			echo "</td>";
			
			echo "<td class=\"prawa\">";
			echo interfejs::label("szuk_miejscowosc",konf::get()->langTexty("znajomi_szuk_miasto"));		
			echo "</td>";
			
			echo "<td>";
			echo $form->input("text","szuk_miejscowosc","szuk_miejscowosc",$this->_szuk['szuk_miejscowosc'],"f_sredni",40);			
			echo "</td>";

			echo "<td class=\"prawa\">";
			echo interfejs::label("szuk_plec","Płeć:");	
			echo "</td>";		

			echo "<td>";
			$plec_tab=konf::get()->getKonfigTab("u_konf","plec_tab");		
			echo $form->select('szuk_plec','szuk_plec',$plec_tab,$this->_szuk['szuk_plec'],"f_sredni","--");		
			echo "&nbsp;";
			echo $form->input("submit","","","szukaj","formularz2 f_krotki");			
			echo "</td>";				
			
			echo "</tr>";	
			
			if(konf::get()->getKonfigTab("znajomi_konf",'wys_grafika')){			
				
				echo "<tr valign=\"middle\">";
				
				echo "<td class=\"prawa\">Sortuj według:</td>";
				
				echo "<td>";	
				echo $form->select('sortuj','sortuj',array(9=>"data dodania",10=>"data dodania malejąco",3=>"nazwisko, imię",4=>"nazwisko,imię malejąco"),$sortuj,"f_dlugi");
				echo "</td>";
				
				echo "<td colspan=\"4\"></td>";
				
				echo "</tr>";		
				
			}		
			
			echo "</table>";
			

			echo $form->getFormk();		
			
			echo "</td></tr>";
			echo tab_stop();

			
		} else {
			echo "<div class=\"tlo3 srodek grube\" style=\"padding:10px;\">".konf::get()->langTexty("znajomi_arch_nieprawidlowu")."</div>";		
		}
		
		
	}	
	
	
  /**
   * black list
   */		
	public function czarna(){	
						
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');						
		$sortuj=tekstForm::doSql(konf::get()->getZmienna('sortuj','sortuj'));
		$plec_tab=konf::get()->getKonfigTab("u_konf","plec_tab");	
		
		if(konf::get()->getKonfigTab("znajomi_konf",'wys_grafika')){
			$colspan=konf::get()->getKonfigTab("znajomi_konf",'wys_kolumn');
		} else {
			$colspan=4;
		}			
		
		$tab_sort=array(	
			1=>"id",
			2=>"id DESC",
			3=>"nazwisko,imie,login", 
			4=>"nazwisko DESC, imie DESC, login DESC", 		
			5=>"miesjcowosc", 
			6=>"miejscowosc DESC", 
			7=>"plec", 
			8=>"plec DESC",
		);	
		
		if(empty($tab_sort[$sortuj])){
			$sortuj=3;
		}					
									
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>konf::get()->getAkcja()));				
	
		$sql=" FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u, ".konf::get()->getKonfigTab("sql_tab",'zablokowani')." z WHERE u.id=z.id_gosc AND z.id_u='".user::get()->id()."' ".user::get()->getSqlAdd("u");

		$naw = new nawig("SELECT COUNT(u.id) AS ilosc ".$sql,$podstrona,konf::get()->getKonfigTab("znajomi_konf",'na_str'));
		$naw->naw($link."&amp;sortuj=".$sortuj);
		$podstrona=$naw->getPodstrona();		
		
		$u=new u();		
		$u->menuEdycja(user::get()->id());
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"arch","arch");			
		echo $form->spr(array(1=>"akcja"),"","ok=spr_akcjau(document.arch.akcja,'znajomi_czarnausun','".konf::get()->langTexty("czyusun")."');");			
		echo $form->getFormp();		
		echo $form->przenies(array("sortuj"=>$sortuj,"podstrona"=>$podstrona));					

		echo tab_nagl(konf::get()->langTexty("znajomi_czarna")." (".$naw->getWynikow()."):",$colspan);
		
		$this->nagloweku("",$colspan);	
		
		echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 lewa\">";	
		$akcje_tab['znajomi_szukaj']="wyszukaj nowych znajomych";					
					
		if($naw->getWynikow()>0){						
			$akcje_tab['znajomi_czarnausun']="usuń zaznaczone";		
		}			
		
		echo $form->selectAkcja($akcje_tab);	
		echo "</td></tr>";	
	
		if($naw->getWynikow()>0){
				
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo4 srodek nobr\">";		
			echo $form->zaod("id_tab");		
			echo "</td></tr>";			

			if($naw->getNaw()){
				echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
			}		
			
		}
					
		if(!konf::get()->getKonfigTab("znajomi_konf",'wys_grafika')){
		
			echo "<tr class=\"srodek\">";		
			echo interfejs::sortEl("","","","&nbsp;",$sortuj,40);				
			echo interfejs::sortEl($link."&amp;sortuj=",3,4,"nazwisko,imię",$sortuj);
			echo interfejs::sortEl($link."&amp;sortuj=","","","przyczyna blokady",$sortuj);
			echo interfejs::sortEl("","","","&nbsp;","",33);
			echo "</tr>";
		
		}			
				
		if($naw->getWynikow()>0){

			$zap=konf::get()->_bazasql->zap("SELECT u.*, z.data_dodania, z.opis AS opis_blokady ".$sql." ORDER BY z.data_dodania DESC, z.id DESC LIMIT ".$naw->getStart().",".$naw->getIle());	
			
			if(!konf::get()->getKonfigTab("znajomi_konf",'wys_grafika')){			
			
				while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
				
					echo "<tr valign=\"middle\" class=\"lewa\">";
	
					echo "<td class=\"tlo4 srodek\">";
					echo $form->checkbox("id_tab[]","id_".$dane['id'],$dane['id'],"");
					echo "</td>";				

					echo "<td class=\"tlo3\">";		
											
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr valign=\"middle\">";

					$fotka=user::get()->obrazek($dane,"",3,"",true);	
												
					if($fotka){					
						echo "<td style=\"padding-right:5px;\">";
		   			echo $fotka;
						echo "</td>";
		  	  }					

					echo "<td>";														
					echo "<a class=\"grube\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane",'id_u'=>$dane['id']))."\">";
					echo tekstForm::wrapWbr(user::get()->nazwa($dane));
					echo "</a>";				
					
					echo "</td></tr></table>";

					echo "</td>";
					
					echo "<td class=\"tlo3 lewa\">";
					
					echo "<div class=\"male\">";
					echo "<div class=\"grube\">Przyczyna blokady:</div>";
					echo tekstForm::doWys($dane['opis_blokady']);
					echo "</div>";

					echo "</td>";	
					
					echo "<td class=\"tlo3 srodek\">";
					
					echo "<table border=\"0\"><tr valign=\"top\">"; 										
					echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_czarnausun","id_u"=>$dane['id'])),"usuń z czarne listy");
					echo "</tr></table>"; 							
					
					echo "</td>";
										
					echo "</tr>";
	
				}								
			
			} else {	
							
				$i=0;
				
				while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
				
					if($i==0){
						echo "<tr valign=\"top\" class=\"srodek\">";
					}
					
					$i++;
					
					echo "<td class=\"tlo3\" style=\"width:25%\">";
					u_wizytowka($dane,false,false,true);
				
					echo "<div>";
					echo "<table class=\"srodek\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr>"; 		
					echo "<td class=\"srodek\">";
					echo $form->checkbox("id_tab[]","id_".$dane['id'],$dane['id'],"");
					echo "</td>";								
					echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_czarnausun",'id_u'=>$dane['id']))); 
					echo "</tr></table>";						
					echo "</div>";							
						
					if(!empty($dane['opis_blokady'])){
						echo "<div class=\"male\">";
						echo "<div class=\"grube\">Przyczyna blokady:</div>";
						echo tekstForm::doWys($dane['opis_blokady']);
						echo "</div>";
					}					
					
					echo "</td>";
					
					if($i==$colspan){
						$i=0;
						echo "</tr>";
					}
								
				}
					
				if($i>0){
					while($i<$colspan){
						$i++;
						echo "<td class=\"tlo3\" style=\"width:25%\">&nbsp;</td>";
					}
					echo "</tr>";
				}		
				
			}	
			
			konf::get()->_bazasql->freeResult($zap);			
													
			if($naw->getNaw()){
				echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
			}				
						
		} else { 
 			echo interfejs::brak($colspan);
		}
		
		echo "<tr><td class=\"tlo4 srodek\" colspan=\"".$colspan."\">".interfejs::linkEl("group",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_arch")),konf::get()->langTexty("znajomi_czarna_znajomi"))."</td></tr>";

		echo tab_stop();
		echo $form->getFormk();
		
	}	
		
	
  /**
   * remove from black list
   */			
	public function czarnausun(){

		$id_u=tekstForm::doSql(konf::get()->getZmienna('id_u','id_u')+0);	
		$id_tab=tekstForm::doSql(konf::get()->getZmienna('id_tab','id_tab')+0);	
		
		if(!empty($id_u)){

			konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'zablokowani')." WHERE id_u='".user::get()->id()."' AND id_gosc='".$id_u."'");
			$ile=konf::get()->_bazasql->affected_rows;				
			
		} else if(!empty($id_tab)){
	  
		  $query=tekstForm::tabQuery($id_tab);			
			if(!empty($query)){
				konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'zablokowani')." WHERE id_u='".user::get()->id()."' AND id_gosc IN (".$query.")");			
				$ile=konf::get()->_bazasql->affected_rows;						
			}
					
		}		
	
		//jesli wykonano							
		if(!empty($ile)){				
			konf::get()->setKomunikat(konf::get()->langTexty("usuwanie")); 						
 		} else {		
			konf::get()->setKomunikat(konf::get()->langTexty("znajomi_cczarna_usunbrak"),"error"); 								
		}											
			
		konf::get()->setZmienna("_post",'id_u',"");	
			
	}	
	
	public function czarnadodaj(){
	
		$id_u=tekstForm::doSql(konf::get()->getZmienna('id_u','id_u')+0);		
		$ok=true;				
		
		//pobierz dane adresata
		if(!empty($id_u)){
			$dane_u=konf::get()->_bazasql->pobierzRekord("SELECT u.id, u.login, u.imie, u.nazwisko, u.miejscowosc, u.email FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u WHERE u.id='".$id_u."'".user::get()->getSqlAdd("u"));
		}
				
		if(empty($dane_u)){
			$id_u="";
			$ok=false;						
		}

		if($ok){

			echo tab_nagl("Zablokowanie użytkownika:");

			echo "<tr><td class=\"tlo3\">";

			echo "<div class=\"grube srodek\">Czy na pewno chcesz zablokować użytkownika ".user::get()->nazwa($dane_u)." ?</div>";
			
			?><script type="text/javascript">			
			function czarnapotw(ok){			
				if(ok){
					document.czarnaw.akcja.value='znajomi_czarnadodaj2';
				} else {
					document.czarnaw.akcja.value='u_dane';
				}				
				document.czarnaw.submit();			
			}			
			</script><?php
			
			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"czarnaw","czarnaw");	
			echo $form->getFormp();
			echo $form->przenies(array("akcja"=>"znajomi_czarnadodaj2","id_u"=>$id_u));		
						
			echo interfejs::label("opis","Przyczyna zablokowania użytkownika");		
			echo "<br />";		
			echo $form->textarea("opis","opis","","f_bdlugi",5);					
			echo "<br />";						
					
			echo $form->input("button","","","Tak, chcę","formularz2 f_sredni",""," onclick=\"czarnapotw(true);\"");
			echo "&nbsp;&nbsp;";
			echo $form->input("button","","","Nie, rezygnuję","formularz2 f_sredni",""," onclick=\"czarnapotw(false);\"");
			echo "</td>";

			echo $form->getFormk();			
			
			echo "</td></tr>";
			
			echo tab_stop();	
			
		} else {
		
			echo interfejs::nieprawidlowe();		
		
		}
		
	}
	
	
  /**
   * add to black list
   */		
	public function czarnadodaj2(){
	
		$id_u=tekstForm::doSql(konf::get()->getZmienna('id_u','id_u')+0);	
		$opis=tekstForm::doSql(konf::get()->getZmienna('opis','opis'),false);			
		$ok=true;				
		
		if($id_u==user::get()->id()){
			$ok=false;
		}
		
		//pobierz dane adresata
		if($ok&&!empty($id_u)){
			$dane_u=konf::get()->_bazasql->pobierzRekord("SELECT u.id, u.login, u.imie, u.nazwisko, u.miejscowosc, u.email FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u WHERE u.id='".$id_u."'".user::get()->getSqlAdd("u"));
		}
				
		if(empty($dane_u)){
			$id_u="";
			$ok=false;
			konf::get()->setKomunikat(konf::get()->langTexty("znajomi_czarnadodaj_nieistnieje"),"error"); 								
		}

		if($ok){
		
			if(konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'zablokowani')." WHERE id_u='".user::get()->id()."' AND id_gosc='".$id_u."'")==0){
			
				//dodaje d oczarne listy
		    konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'zablokowani')." (id_u,id_gosc,data_dodania,opis) VALUES('".user::get()->id()."','".$id_u."',NOW(),'".$opis."')");			
				$id_w=konf::get()->_bazasql->insert_id;		
						
				//jesli dodano							
				if(!empty($id_w)){		
				
			    konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'znajomi')." WHERE (id_u='".user::get()->id()."' AND id_gosc='".$id_u."') OR (id_gosc='".user::get()->id()."' AND id_u='".$id_u."')");
	  		  konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'poczta')." WHERE ((id_odb='".user::get()->id()."' AND id_autor='".$id_u."') OR (id_autor='".user::get()->id()."' AND id_odb='".$id_u."')) AND typ=1 AND zdefiniowana=1 AND wykonana=0");	
		
					$this->updateZnajomi();				
					$this->updateZnajomi($id_u);
					user::get()->setZnajomiPobrano(false);
					user::get()->update();									

					konf::get()->setKomunikat(konf::get()->langTexty("znajomi_czarnadodaj_zapisany")); 	
									
				}
				
			} else {
				konf::get()->setKomunikat("Podany użytkownik jest już na czarnej liście","error"); 				
			}
												
		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 				
		}
			
		konf::get()->setZmienna("_post",'id_u',"");	
			
	}		
	
	
  /**
   * zaproszenia
   */		
	public function zaproszenia(){	
			
		$sortuj=tekstForm::doSql(konf::get()->getZmienna('sortuj','sortuj'));			
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');		
		$typ=konf::get()->getZmienna('typ','typ');	
			
		if(empty($typ)||($typ!=1&&$typ!=2)){
			$typ=1;
		}
			
		if(konf::get()->getKonfigTab("znajomi_konf",'wys_grafika')){
			$colspan=konf::get()->getKonfigTab("znajomi_konf",'wys_kolumn');
		} else {
			$colspan=5;
		}							
									
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>konf::get()->getAkcja(),"typ"=>$typ));				
				
		if($typ==1){	
			$sql=" FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'poczta')." z ON u.id=z.id_autor WHERE z.id_odb='".user::get()->id()."' AND z.typ=1 AND z.zdefiniowana=1 AND z.wykonana=0 ".user::get()->getSqlAdd("u");		
		} else {				
			$sql=" FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'poczta')." z ON u.id=z.id_odb WHERE z.id_autor='".user::get()->id()."' AND z.zdefiniowana=1 AND z.typ=1 AND z.wykonana=0 ".user::get()->getSqlAdd("u");
		} 
		
		$naw = new nawig("SELECT COUNT(u.id) AS ilosc ".$sql,$podstrona,konf::get()->getKonfigTab("znajomi_konf",'na_str'));
		$naw->naw($link);
		$podstrona1=$naw->getPodstrona();	
		
		echo tab_nagl("",2);
		echo "<tr class=\"srodek\">";
		
		echo "<td class=\"";
		if($typ==2){
			echo "tlo4";
		} else {
			echo "tlo3";
		}
		echo "\">";			
		echo interfejs::linkEl("email",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_zaproszenia","typ"=>1)),"Zaproszenia odebrane");	
		echo "</td>";
				
		echo "<td class=\"";
		if($typ==1){
			echo "tlo4";
		} else {
			echo "tlo3";
		}
		echo "\">";			
		echo interfejs::linkEl("email",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_zaproszenia","typ"=>2)),"Zaproszenia wysłane");	
		echo "</td>";		

		echo "</tr>";
		echo tab_stop();			
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"arch","arch");			
		echo $form->spr(array(1=>"akcja"),"","ok=spr_akcjau(document.arch.akcja,'zaproszenia_usun','".konf::get()->langTexty("czyusun")."');");			
		echo $form->getFormp();		
		echo $form->przenies(array("sortuj"=>$sortuj,"podstrona"=>$podstrona));		
		
		if($typ==2){			
			echo tab_nagl(konf::get()->langTexty("znajomi_zaproszeniaod")." (".$naw->getWynikow()."):",$colspan);							
		} else {
			echo tab_nagl(konf::get()->langTexty("znajomi_zaproszeniado")." (".$naw->getWynikow()."):",$colspan);									
		}
		
		$this->nagloweku("",$colspan);			
		
		
		if($naw->getWynikow()>0){
				
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo4 srodek nobr\">";		
			echo $form->zaod("id_tab");		
			echo "</td></tr>";				
			
			if($naw->getNaw()){
				echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
			}		
			
		}
					
		if(!konf::get()->getKonfigTab("znajomi_konf",'wys_grafika')){
		
			echo "<tr class=\"srodek\">";		
			echo interfejs::sortEl($link."&amp;sortuj=",9,10,"data",$sortuj,80);				
			echo interfejs::sortEl($link."&amp;sortuj=",3,4,"nazwisko,imię",$sortuj);
			echo interfejs::sortEl($link."&amp;sortuj=",5,6,"miasto",$sortuj,150);
			echo interfejs::sortEl($link."&amp;sortuj=",7,8,"płeć",$sortuj,80);	
			echo interfejs::sortEl("","","","&nbsp;","",66);
			echo "</tr>";
		
		}			
		
		if($naw->getWynikow()>0){			
			
			$zap=konf::get()->_bazasql->zap("SELECT u.*, z.data_wys ".$sql." ORDER BY z.data_wys DESC, z.id DESC LIMIT ".$naw->getStart().",".$naw->getIle());	
			
			if(!konf::get()->getKonfigTab("znajomi_konf",'wys_grafika')){		
			
				while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
				
					echo "<tr valign=\"middle\" class=\"lewa\">";

					echo "<td class=\"tlo4 srodek male\">";		
					echo "<div class=\"srodek\">";										
					echo $form->checkbox("id_tab[]","id_".$dane['id'],$dane['id'],"");
					echo "</div>";
					$dane['data_wys']=substr($dane['data_wys'],0,16);
					echo str_replace(" ","<br />",$dane['data_wys']);				
					echo "</td>";				

					echo "<td class=\"tlo3\">";	
					
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr valign=\"middle\">";
					
					$fotka=user::get()->obrazek($dane,"",3,"",true);	
												
					if($fotka){					
						echo "<td style=\"padding-right:5px;\">";
		   			echo $fotka;
						echo "</td>";
		  	  }											

					echo "<td>";														
					echo "<a class=\"grube\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane",'id_u'=>$dane['id']))."\">";
					echo tekstForm::wrapWbr(user::get()->nazwa($dane));
					echo "</a>";				
					
					echo "</td></tr></table>";
								
					echo "</td>";
					
					echo "<td class=\"tlo3 srodek\">";
					echo $dane['miejscowosc'];
					echo "</td>";
					
					echo "<td class=\"tlo3 srodek\">";
					if(!empty($plec_tab[$dane['plec']])){
						echo $plec_tab[$dane['plec']];
					} else {
						echo "&nbsp;";
					}
					echo "</td>";			
					
					echo "<td class=\"tlo3 srodek\">";
						
					echo "<table class=\"srodek\" border=\"0\" cellspacing=\"0\" cellpadding=\"2\"><tr>"; 										
					if($typ==2){						
						echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_zaproszenieusun",'id_tab[]'=>$dane['id'],"typ"=>$typ,"sortuj"=>$sortuj))); 
					} else {							
						echo interfejs::przyciskEl("accept",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_akceptuje",'id_u'=>$dane['id'],"typ"=>$typ,"sortuj"=>$sortuj)),konf::get()->langTexty("znajomi_zaproszenia_akcept"));
						echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_zaproszenieodrzuc",'id_u'=>$dane['id'],"typ"=>$typ,"sortuj"=>$sortuj))); 										
					}		
					echo "</tr></table>"; 							
					
					echo "</td>";
										
					echo "</tr>";
	
				}						
			
			
			} else {

				$i=0;
				
				while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
				
					if($i==0){
						echo "<tr valign=\"top\" class=\"srodek\">";
					}
					
					$i++;
					
					echo "<td class=\"tlo3\" style=\"width:25%\">";
					
					u_wizytowka($dane,false,false);
				
					echo "<div>";
					echo "<table class=\"srodek\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr>"; 	
					echo "<td class=\"srodek\">";
					echo $form->checkbox("id_tab[]","id_".$dane['id'],$dane['id'],"");
					echo "</td>";							
					
					if($typ==2){							
						echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_zaproszenieusun",'id_tab[]'=>$dane['id'],"typ"=>$typ,"sortuj"=>$sortuj))); 
					} else {							
						echo interfejs::przycisk("accept",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_akceptuje",'id_u'=>$dane['id'],"typ"=>$typ,"sortuj"=>$sortuj)),konf::get()->langTexty("znajomi_zaproszenia_akcept"));
						echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_zaproszenieodrzuc",'id_u'=>$dane['id'],"typ"=>$typ,"sortuj"=>$sortuj))); 				
					}				
					
					echo "</tr></table>";						
					echo "</div>";
						
					echo "</td>";
					
					if($i==$colspan){
						$i=0;
						echo "</tr>";
					}
								
				}
						
				if($i>0){
					while($i<$colspan){
						$i++;
						echo "<td class=\"tlo3\" style=\"width:25%\">&nbsp;</td>";
					}
					echo "</tr>";
				}			
			
			}
			
			konf::get()->_bazasql->freeResult($zap);
			
			if($naw->getNaw()){
				echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
			}				
						
		} else { 
 			echo interfejs::brak($colspan);
		}	
		
		echo tab_stop();
		
		echo $form->getFormk();			
		
	}		
		
  /**
   * remove my invitation
   */			
	public function zaproszenieusun(){
	
		$id_tab=tekstForm::doSql(konf::get()->getZmienna('id_tab','id_tab'));	

		if(!empty($id_tab)){
			$query=tekstForm::tabQuery($id_tab);	
		}
				
		if(!empty($query)){				
			konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'poczta')." SET wykonana=1 WHERE id_autor='".user::get()->id()."' AND id_odb IN (".$query.") AND typ=1 AND zdefiniowana=1");
			$ile=konf::get()->_bazasql->affected_rows;																	
		}
		
		//jesli wykonano							
		if(!empty($ile)){					
			konf::get()->setKomunikat(konf::get()->langTexty("znajomi_zaproszenia_usuniete"));
 		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("znajomi_zaproszenia_usunbrak"),"error");
		}						

	}	
				
	
  /**
   * remove  invitation to me
   */			
	public function zaproszenieodrzuc(){

		$id_u=tekstForm::doSql(konf::get()->getZmienna('id_u','id_u'));				
		
		if(!empty($id_u)){

			konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'poczta')." SET wykonana=1 WHERE id_odb='".user::get()->id()."' AND id_autor='".$id_u."' AND typ=1 AND zdefiniowana=1 AND wykonana=0");
			$ile=konf::get()->_bazasql->affected_rows;		
										
		}
		
		//jesli wykonano							
		if(!empty($ile)){			
		
			$dane_u=konf::get()->_bazasql->pobierzRekord("SELECT u.* FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u WHERE u.id='".$id_u."'".user::get()->getSqlAdd("u"));
						
			//zapisz w poczcie										
			if(konf::get()->isMod('poczta')&&!empty($dane_u)){
			
				$tytul="Odrzucone zaproszenie do znajomości";
				
				$tresc="Witaj ".user::get()->nazwa($dane_u)."\n\n";			
				$tresc.="Twoje zaproszenie do znajomości użytownika ".user::get()->nazwa()." zostało odrzucone.";
				require_once(konf::get()->getKonfigTab('mod_kat')."poczta/class.poczta.php");														
				$poczta=new poczta();													
				$id_w2=$poczta->zdefiniowana($dane_u,$tytul,$tresc,3);		
				
			}		
									
			konf::get()->setKomunikat(konf::get()->langTexty("znajomi_zaproszenia_odrzucone"));
 		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("znajomi_zaproszenia_odrzucbrakt"),"error"); 					
		}			
		
		konf::get()->setZmienna("_post",'id_u',"");			
			
	}	
	
	
	private function nagloweku($dane_u="",$colspan=1){
	
		if(empty($dane_u)){
			$dane_u=user::get()->getDane();
		}
		
		echo "<tr><td class=\"tlo4 lewa\" colspan=\"".$colspan."\">";
		echo konf::get()->langTexty("znajomi_arch_u")." ";
		echo "<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane","id_u"=>$dane_u['id']))."\" class=\"grube\">".user::get()->nazwa($dane_u)."</a>";
		if(!empty($dane_u['miejscowosc'])){
			echo " (".$dane_u['miejscowosc'].")";
		}
		echo "</td></tr>";		
	
	}
	
	
  /**
   * new message
   */	
	public function zaprosdo(){
	
		$email=konf::get()->getZmienna('email','email');			

		echo tab_nagl("Zaproś znajomego");
		
		echo "<tr><td class=\"tlo3\">";
			
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"wiadomosc","wiadomosc");
		echo $form->spr(array(1=>"email"),"","");
		echo $form->getFormp();			
		echo $form->przenies(array("akcja"=>"znajomi_zaprosdo2"));	
		
	  echo "<br /><div class=\"grube\">Wyślij znajomemu e-maila z zaproszeniem do portalu</div><br />";		
		
		echo interfejs::label("email","Podaj adres email adresata zaproszenia*:","");		
		echo "<br />";		
		
		echo $form->input("text","email","email",$email,"f_dlugi",200);		
	  echo "&nbsp;";		
		echo $form->input("submit","","","wyślij","formularz2 f_krotki");		
		echo "<br />";
		
	  echo "<div class=\"male\">".konf::get()->langTexty("musza")."</div><br />";			
		
		echo $form->getFormk();					
					
		echo "</td></tr>";
		
		echo "<tr><td class=\"tlo4 srodek\">".interfejs::linkEl("group",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_arch")),"Powrót do listy znajomych")."</td></tr>";
		
		echo tab_stop();
		
	
	}	
	
	public function zaprosdo2(){
	
		$email=tekstForm::male(tekstForm::doSql(konf::get()->getZmienna('email','email')));		

		
		if(!empty($email)&&preg_match("/".tekstForm::getEmailForma()."/",$email)){
		
			$dane=konf::get()->_bazasql->pobierzRekord("SELECT u.* FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u WHERE email='".$email."' ".user::get()->getSqlAdd("u")." LIMIT 0,1");	
			
			if(!empty($dane)){
			
				konf::get()->setZmienna("_post",'id_u',$dane['id']);					
				konf::get()->setAkcja("u_dane");
				konf::get()->setKomunikat("Osoba o tym adresie email jest już zapisana do portalu","error");
			
			} else {
			
				$tytul=user::get()->nazwa()." zaprasza Cię do portalu ".konf::get()->getKonfigTab('nazwa_www');
			
				$tresc=" Witaj!\n";
				$tresc.="Zostałeś zaproszony przez ".user::get()->nazwa()."\n";				
				$tresc.="do uczestnictwa w społeczności portalu o adresie: ".konf::get()->getKonfigTab('adres_www')."\n";				
				$tresc.="Szczegółowe informacje o portalu znajdziesz na stronie: ".konf::get()->getKonfigTab('adres_www')."\n";
				$tresc.="Zapraszamy!\n";
				
				require_once(konf::get()->getKonfigTab('klasy')."class.wyslijemail.php");														
				$wyslij=new wyslijemail($tytul,$tresc,$email);
				$wyslij->setNadawca(konf::get()->getKonfigTab('kontakt_email'),konf::get()->getKonfigTab('kontakt_nadawca'));	
				$wyslij->wykonaj();		
				
				konf::get()->setAkcja("znajomi_arch");				
				konf::get()->setKomunikat("Zaproszenie zostało poprawnie wysłane na adres: ".$email);				
				
			}

		
		} else {
		
			konf::get()->setAkcja("znajomi_zaprosdo");			
			konf::get()->setKomunikat(konf::get()->langTexty("Podany email jest nieprawidłowy"),"error"); 
					
		}
	
	
	}
	
	private function updateZnajomi($id_u=""){
		
		$id_u=$id_u+0;
			
		if(empty($id_u)){
			$id_u=user::get()->id();
		}
		
		konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." SET ile_znajomi=(SELECT COUNT(id) FROM ".konf::get()->getKonfigTab("sql_tab",'znajomi')." WHERE id_u='".$id_u."') WHERE id='".$id_u."'");	
	
	
	}
	
		
	/**
   * class constructor php5	
   */	
	public function __construct() {	

  }	

	
}	

?>