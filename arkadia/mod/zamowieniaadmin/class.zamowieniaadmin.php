<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

class zamowieniaadmin extends moduladmin {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="zamowieniaadmin class";	

	/**
	 * get search values
	 */		
	protected $_szuk=array(
		"szuk_id"=>"",		
		"szuk_u"=>"",		
		"szuk_nazwa"=>"",			
		"szuk_nazwisko"=>"",							
		"szuk_status"=>"",	
		"szuk_platnosc"=>"",			
		"szuk_miasto"=>"",			
		"szuk_nip"=>"",		
		"szuk_produkt"=>"",	
		"szuk_dataod"=>"",			
		"szuk_datado"=>"",				
		"szuk_faktura"=>"",			
	);


	/**
   * sklep arch
   */		
	public function arch(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$id_nr=konf::get()->getZmienna('id_nr','id_nr');
		$sortuj=tekstForm::doSql(konf::get()->getZmienna('sortuj','sortuj'));
		$statusy_tab=konf::get()->getKonfigTab("sklep_konf",'zamowienia_statusy');
		$platnosci_tab=konf::get()->getKonfigTab("sklep_konf",'platnosci_tab');		
		$platnosci_statusy_tab=konf::get()->getKonfigTab("sklep_konf",'platnosci_statusy_tab');				

		$na_str=50;
		$colspan=8;
		if(konf::get()->getKonfigTab("sklep_konf",'prod_waga')){
			$colspan++;
		}
		
	  $tab_sort=array(
			1=>"p.id", 2=>"p.id DESC", 		
			5=>"p.klient_nazwa", 6=>"p.klient_nazwa DESC", 
			7=>"p.zam_data", 8=>"p.zam_data DESC", 			
			11=>"p.zam_kwota, p.klient_nazwa", 12=>"p.zam_kwota DESC, p.klient_nazwa", 		
			13=>"p.status, p.klient_nazwa", 14=>"p.status DESC, p.klient_nazwa", 			
			15=>"p.platnosc_status, p.klient_nazwa", 16=>"p.platnosc_status DESC, p.klient_nazwa", 										
			17=>"p.zam_waga, p.klient_nazwa", 18=>"p.zam_waga DESC, p.klient_nazwa", 					
			19=>"p.miejscowosc, p.klient_nazwa", 20=>"p.miejscowosc DESC, p.klient_nazwa", 						
			21=>"p.faktura_nr, p.klient_nazwa", 22=>"p.faktura_nr DESC, p.klient_nazwa", 				
		);	
		
    if(empty($sortuj)||empty($tab_sort[$sortuj])){ 
			$sortuj=5; 
		}

		$link=$this->szukZmienne(1);	

    $query=" FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia')." p  LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u ON p.id_u=u.id WHERE 1 ";

	  if(!empty($this->_szuk['szuk_id'])){
	    $query.=" AND p.id='".tekstForm::doSql($this->_szuk['szuk_id'])."'";
	  }
	  if(!empty($this->_szuk['szuk_u'])){
	    $query.=" AND p.id_u='".tekstForm::doSql($this->_szuk['szuk_u'])."'";
	  }
	  if(isset($this->_szuk['szuk_status'])&&$this->_szuk['szuk_status']!=''){
	    $query.=" AND p.status='".tekstForm::doSql($this->_szuk['szuk_status'])."'";
	  }
	  if(!empty($this->_szuk['szuk_platnosc'])){
	    $query.=" AND p.platnosc_status='".tekstForm::doSql($this->_szuk['szuk_platnosc'])."'";
	  }				
	  if(!empty($this->_szuk['szuk_miasto'])){
	    $query.=" AND (u.miejscowosc LIKE '%".tekstForm::doLike($this->_szuk['szuk_miasto'])."%' OR p.miejscowosc LIKE '%".tekstForm::doLike($this->_szuk['szuk_miasto'])."%')";
	  }				
	  if(!empty($this->_szuk['szuk_nip'])){
	    $query.=" AND u.nip='".tekstForm::doSql($this->_szuk['szuk_nip'])."'";
	  }		
	  if(!empty($this->_szuk['szuk_faktura'])){
	    $query.=" AND p.faktura_nr='".tekstForm::doSql($this->_szuk['szuk_faktura'])."'";
	  }						
	  if(!empty($this->_szuk['szuk_nazwa'])){
	    $query.=" AND (p.klient LIKE '%".tekstForm::doLike($this->_szuk['szuk_nazwa'])."%' OR u.firma_nazwa LIKE '%".tekstForm::doLike($this->_szuk['szuk_nazwa'])."%')";
	  }		
	  if(!empty($this->_szuk['szuk_nazwisko'])){
	    $query.=" AND (p.klient LIKE '%".tekstForm::doLike($this->_szuk['szuk_nazwisko'])."%' OR u.nazwisko LIKE '%".tekstForm::doLike($this->_szuk['szuk_nazwisko'])."%')";
	  }		
		
	  if(!empty($this->_szuk['szuk_produkt'])){
	    $query.=" AND (COUNT(pr.id) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'sklepzamowienia_produkty')." pr WHERE pr.id_zam=p.id AND pr.id_produkt='".$this->_szuk['szuk_produkt']."')>0";
	  }			
			
    $link3=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"zamowieniaadmin_usun","sortuj"=>$sortuj,"podstrona"=>$podstrona)).$link;			
	  $link6=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"zamowieniaadmin_zobacz"));		
	  $link8=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"zamowieniaadmin_drukuj"));				
	  $link7=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane"));											
    $link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"zamowieniaadmin_arch")).$link;		
		
		$naw = new nawig("SELECT COUNT(p.id) AS ilosc".$query,$podstrona,$na_str);		
		$naw->naw($link."&amp;sortuj=".$sortuj);
		$podstrona=$naw->getPodstrona();		

		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"arch","arch");
		echo $form->spr(array(1=>"akcja"),"","ok=spr_akcjau(document.arch.akcja,'zamowieniaadmin_usun','".konf::get()->langTexty("czyusun")."');");
		echo $form->getFormp();
		
		$przenies=$this->_szuk;
		$przenies['sortuj']=$sortuj;
		$przenies['podstrona']=$podstrona;
				
		echo $form->przenies($przenies);
			
	  echo tab_nagl(konf::get()->langTexty("zamowienia_admin")."Lista zamówień (".$naw->getWynikow()."):",$colspan);	

    echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 lewa\">";
				
    //akcje  
		//$akcje_tab['zamowieniaadmin_dodaj']=konf::get()->langTexty("adodaj");	
		$akcje_tab=array();
		if($naw->getWynikow()>0){			
			$akcje_tab['zamowieniaadmin_status']=konf::get()->langTexty("zamowienia_admin_astatus")."zmień status";
			$akcje_tab['zamowieniaadmin_usun']=konf::get()->langTexty("ausun");						
		}
		echo $form->selectAkcja($akcje_tab,false);
		echo " ";
		echo $form->select("status","ststus",$statusy_tab,"","f_dlugi",konf::get()->langTexty("zamowienia_admin_statusas")."--wybierz status--");
		echo " ";
		echo $form->input("submit","","",konf::get()->langTexty("akcjawykonaj"),"formularz2 f_krotki");				
		echo "</td></tr>";					
					
    //zaznaczanie checkboxow
		if($naw->getWynikow()>0){		
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo4 srodek nobr\">";		
			echo $form->zaod("id_tab");		
			echo "</td></tr>";		
    }
    				
		if($naw->getNaw()){
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
		}	
		
    //sortowanie  po kolumnach
    echo "<tr class=\"srodek\">";
		echo interfejs::sortEl($link."&amp;sortuj=",1,2,konf::get()->langTexty("zamowienia_admin_arch_nr")."id",$sortuj,50);
		echo interfejs::sortEl($link."&amp;sortuj=",7,8,konf::get()->langTexty("zamowienia_admin_arch_data")."data",$sortuj,80);				
		echo interfejs::sortEl($link."&amp;sortuj=",21,22,konf::get()->langTexty("zamowienia_admin_arch__faktura")."faktura",$sortuj);		
		echo interfejs::sortEl($link."&amp;sortuj=",5,6,konf::get()->langTexty("zamowienia_admin_arch_nazwa")."nazwa klienta",$sortuj);		
		echo interfejs::sortEl($link."&amp;sortuj=",19,20,konf::get()->langTexty("zamowienia_admin_arch_miasto")."miejscowość",$sortuj);			
		echo interfejs::sortEl($link."&amp;sortuj=",11,12,konf::get()->langTexty("zamowienia_admin_arch_cena")."wartość",$sortuj,80);		
		if(konf::get()->getKonfigTab("sklep_konf",'prod_waga')){
			echo interfejs::sortEl($link."&amp;sortuj=",17,18,konf::get()->langTexty("zamowienia_admin_arch_waga")."waga",$sortuj,80);		
		}										
		echo interfejs::sortEl($link."&amp;sortuj=",13,14,konf::get()->langTexty("zamowienia_admin_arch_status")."status",$sortuj,100);	
		echo interfejs::sortEl($link."&amp;sortuj=",15,16,konf::get()->langTexty("zamowienia_admin_arch_platnosc")."płatność",$sortuj,100);	
    echo "</tr>";			

	  //pobieranie danych  
	  $query="SELECT p.*, u.firma_nazwa AS u_firma_nazwa, u.nip AS u_nip ".$query." ORDER BY ".$tab_sort[$sortuj]."";
	  $query.=" LIMIT ".$naw->getStart().",".$naw->getIle();
			
	  $i=0;	    		
	  $dane_tab=konf::get()->_bazasql->pobierzRekordy($query,"id");

		if(!empty($dane_tab)){
				
			while(list($key,$dane)=each($dane_tab)){
									
				if(empty($dane['firma_nazwa'])&&!empty($dane['u_firma_nazwa'])){									
					echo $dane['firma_nazwa']=$dane['u_firma_nazwa'];				
				}				
									
				if(empty($dane['nip'])&&!empty($dane['u_nip'])){									
					echo $dane['nip']=$dane['u_nip'];				
				}				
								
		  	$i++;
					
	      echo "<tr class=\"srodek\">";
				
				echo "<td class=\"tlo4 srodek\">";
				echo $form->checkbox("id_tab[]","id_".$dane['id'],$dane['id'],"");	
				echo "<div";
				if($id_nr==$dane['id']){
					echo " class=\"grube\"";
				}
				echo ">".$dane['id']."</div>";
	      echo "</td>";
				
	      echo "<td class=\"tlo3 srodek male\">";
				echo substr($dane['zam_data'],0,16);
	      echo "</td>";				
				
	      echo "<td class=\"tlo3 srodek\">";
		    echo $dane['faktura_nr'];
				echo "</td>";										
		        
	      echo "<td class=\"tlo3 lewa\">";
		    echo "<a class=\"grube\" href=\"".$link7."&amp;id_u=".$dane['id_u']."\">";
				if(!empty($dane['id_u'])){
					echo $dane['klient_nazwa'];
				}			
				echo "</a>";								
				if(!empty($dane['firma_nazwa'])){			
					echo "<div class=\"male\">";										
					echo $dane['firma_nazwa'];
					if(!empty($dane['nip'])){							
						echo " (".$dane['nip'].")";
					}
					echo "</div>";							
				} 
												
				echo "<div><table border=\"0\" style=\"margin-top:5px\"><tr>";    					
			  echo interfejs::podglad($link6."&amp;id_nr=".$dane['id']); 		
			  echo interfejs::przyciskEl("drukuj",$link8."&amp;id_nr=".$dane['id'],konf::get()->langTexty("zamowieniaadmin_arch_drukuj")."drukuj","_blank");						
				echo interfejs::infoEl($dane);					
				echo interfejs::usun($link3."&amp;id_tab[1]=".$dane['id']); 												
				echo "</tr></table></div>";   					
				echo "</td>";
				
	      echo "<td class=\"tlo3 srodek\">";
		    echo $dane['miejscowosc'];
				echo "</td>";						

	      echo "<td class=\"tlo3 prawa\">";
		    echo "<div class=\"grube\">".$dane['zam_kwota']."</div>";				
				echo "</td>";			
				
				if(konf::get()->getKonfigTab("sklep_konf",'prod_waga')){				
	  	    echo "<td class=\"tlo3 prawa\">";
		  	  echo "<div class=\"grube\">".$dane['zam_waga']."</div>";				
					echo "</td>";								
				}
												
	      //status  
	      echo "<td class=\"tlo3 srodek\">";
				if(!empty($statusy_tab[$dane['status']])){
				
					echo $statusy_tab[$dane['status']];
					
					if(tekstForm::niepuste($dane['status_data'])){
						echo "<div class=\"male\">".substr($dane['status_data'],0,16)."</div>";
					}
				
				}
	      echo "</td>";		
				
	      echo "<td class=\"tlo3 srodek\">";
				if(!empty($platnosci_statusy_tab[$dane['platnosc_status']])){
				
					echo "<div class=\"grube\">";
					echo $platnosci_statusy_tab[$dane['platnosc_status']];
					echo "</div>";
					
					if(tekstForm::niepuste($dane['platnosc_data'])){
						echo "<div class=\"male\">".substr($dane['platnosc_data'],0,16)."</div>";
					}
				
				}
				
				if(!empty($platnosci_tab[$dane['platnosc_typ']])&&count($platnosci_tab)>1){
				
					echo "<div>";
					echo $platnosci_tab[$dane['platnosc_typ']];
					echo "</div>";
				
				}		
	      echo "</td>";						
						    					
		    echo "</tr>";

			}
			
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
		
		$form2=new formularz("post",konf::get()->getKonfigTab("plik"),"arch2","arch2");
		echo $form2->getFormp();
		echo $form2->przenies(array("akcja"=>"zamowieniaadmin_arch","sortuj"=>$sortuj));		

		$d_tab=konf::get()->getKonfigTab("sklep_konf",'d_tab');		
				
		echo $form2->select("szuk_status","szuk_status",$statusy_tab,$this->_szuk['szuk_status'],"f_dlugi",konf::get()->langTexty("zamowienia_admin_szukstatus")."--wybierz status--");
		echo " ";			
		echo $form2->select("szuk_platnosc","szuk_platnosc",$platnosci_statusy_tab,$this->_szuk['szuk_platnosc'],"f_dlugi",konf::get()->langTexty("zamowienia_admin_szukplatosc")."--status płatności--");
		echo " ";			
		
		echo interfejs::label("szuk_id",konf::get()->langTexty("zamowienia_admin_szukid")."id zamówienia: ");							
		echo $form2->input("text","szuk_id","szuk_id",$this->_szuk['szuk_id'],"f_krotki",11);	
		echo " ";			
				
		echo interfejs::label("szuk_produkt",konf::get()->langTexty("zamowienia_admin_szukprodukt")."id produktu w zamówieniu: ");											
		echo $form2->input("text","szuk_produkt","szuk_produkt",$this->_szuk['szuk_produkt'],"f_krotki",11);									
				
		echo "<div>";		
		echo interfejs::label("szuk_u",konf::get()->langTexty("zamowienia_admin_szuku")."id klienta: ");			
		echo $form2->input("text","szuk_u","szuk_u",$this->_szuk['szuk_u'],"f_krotki",11);		
		echo " ";			
		
		echo interfejs::label("szuk_nazwa",konf::get()->langTexty("zamowienia_admin_szuknazwa")."nazwa klienta: ");							
		echo $form2->input("text","szuk_nazwa","szuk_nazwa",$this->_szuk['szuk_nazwa'],"f_sredni",50);				
		echo " ";		
		echo interfejs::label("szuk_nazwisko",konf::get()->langTexty("zamowienia_admin_szuknazwisko")."nazwisko: ");		
		echo $form2->input("text","szuk_nazwisko","szuk_nazwisko",$this->_szuk['szuk_nazwisko'],"f_sredni",50);				
		echo " ";			
		echo interfejs::label("szuk_miasto",konf::get()->langTexty("zamowienia_admin_szukmiasto")."miasto: ");			
		echo $form2->input("text","szuk_miasto","szuk_miasto",$this->_szuk['szuk_miasto'],"f_sredni",50);				
		echo " ";		
		echo interfejs::label("szuk_nip",konf::get()->langTexty("zamowienia_admin_szuknip")."NIP: ");		
		echo $form2->input("text","szuk_nip","szuk_nip",$this->_szuk['szuk_nip'],"f_sredni",50);				
		echo "</div>";		

		echo "<div>";		
		echo interfejs::label("szuk_dataod",konf::get()->langTexty("zamowienia_admin_szukdataod")."data od: ");				
		echo $form2->kalendarz("szuk_dataod","trigger_a",$this->_szuk['szuk_dataod'],true,true);				
		echo " ";			
		echo interfejs::label("szuk_datado",konf::get()->langTexty("zamowienia_admin_szukdatado")."do: ");				
		echo $form2->kalendarz("szuk_datado","trigger_b",$this->_szuk['szuk_datado'],true,true);				
		echo " ";		
		echo interfejs::label("szuk_faktura",konf::get()->langTexty("zamowienia_admin_szukfaktura")."numer faktury: ");								
		echo $form2->input("text","szuk_faktura","szuk_faktura",$this->_szuk['szuk_faktura'],"f_sredni",50);				
		echo "</div>";	
					
		echo $form2->input("submit","","",konf::get()->langTexty("szukaj"),"formularz2 f_sredni");		
		echo "</div>";

		echo $form2->getFormk();
		
		echo "</td></tr>";	
		echo tab_stop();		
 
	}
	
	
	public function drukuj(){
	
		$this->zobacz();
	
	}

	private function zamowienieMenu($id_nr,$dane,$link=""){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$sortuj=konf::get()->getZmienna('sortuj','sortuj');

		echo "<table border=\"0\"><tr>"; 
				
		if(!empty($id_nr)){
			echo interfejs::podglad(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"zamowieniaadmin_zobacz","id_nr"=>$id_nr))); 			
			echo interfejs::przyciskEl("drukuj",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"zamowieniaadmin_drukuj","id_nr"=>$id_nr)),konf::get()->langTexty("zamowieniaadmin_arch_drukuj")."drukuj","_blank");			
			echo interfejs::infoEl($dane);		  
			echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"zamowieniaadmin_usun","id_tab[]"=>$id_nr)).$link);
		}
		echo interfejs::przyciskEl("arrow_join",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"zamowieniaadmin_arch")).$link,konf::get()->langTexty("zamowienia_admin_powrot")."powrót do listy");

		echo "</tr></table>"; 	
	
	}
		
	
	public function zobacz(){
	
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$sortuj=konf::get()->getZmienna('sortuj','sortuj');				
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));	
		$link=$this->szukZmienne(1)."&amp;podstrona=".$podstrona."&amp;sortuj=".$sortuj;		
		$statusy_tab=konf::get()->getKonfigTab("sklep_konf",'zamowienia_statusy');
		$platnosci_tab=konf::get()->getKonfigTab("sklep_konf",'platnosci_tab');		
		$platnosci_statusy_tab=konf::get()->getKonfigTab("sklep_konf",'platnosci_statusy_tab');				
		$dostarczenie_tab=konf::get()->getKonfigTab("sklep_konf",'dostarczenie_tab');				
		$platnosci_bledy_tab=konf::get()->getKonfigTab("sklep_konf",'platnosci_bledy_tab');					
		$dane_u=array();
		
		//dla edycji pobierz aktualne dane
		if(!empty($id_nr)){
			$dane=konf::get()->_bazasql->pobierzRekord("SELECT p.* FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia')." p WHERE id='".$id_nr."'");

			if(empty($dane)){
				$id_nr="";
			} else if(!empty($dane['id_u'])){		
				$userdane=userdane::get($dane['id_u']);
				$dane_u=userdane::get()->getDane();
			}		
		}
		
		if(!empty($id_nr)){
		
			if(!empty($dane_u)){		
			
				$dane['firma']=$dane_u['firma'];
				$dane['email']=$dane_u['email'];				
				$dane['telefon']=$dane_u['telefon'];					
				$dane['imie']=$dane_u['imie'];		
				$dane['nazwisko']=$dane_u['nazwisko'];						
				$dane['miejscowosc']=$dane_u['miejscowosc'];						
												
			}
		
      echo tab_nagl(konf::get()->langTexty("zamowienia_zobacz_zam")."Zamówienie numer: ".$dane['id'],2);  	
		
			if(konf::get()->getAkcja()!="zamowieniaadmin_drukuj"){
				echo "<tr><td class=\"tlo3\" colspan=\"2\">";	
				$this->zamowienieMenu($id_nr,$dane,$link);			
				echo "</td></tr>";
			}
			
			echo "<tr valign=\"top\">";			
			echo "<td class=\"tlo4 grube\">Informacje ogólne:</td>";
			echo "<td class=\"tlo4 grube\">Status i płatność:</td>";						
			echo "</tr>";					
			
			echo "<tr valign=\"top\">";
			
			echo "<td class=\"tlo3\">";
			
			if(konf::get()->getAkcja()!="zamowieniaadmin_drukuj"){			
				$form=new formularz("post",konf::get()->getKonfigTab("plik"),"sklep2","sklep2");		
				echo $form->getFormp();
				
				$przenies=$this->_szuk;
				$przenies['sortuj']=$sortuj;
				$przenies['podstrona']=$podstrona;
				$przenies['id_nr']=$id_nr;
				$przenies['akcja']="zamowieniaadmin_faktura";			
										
				echo $form->przenies($przenies);		
			}
						
			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\">";
			
			echo "<tr>";
			echo "<td class=\"prawa\" style=\"width:150px;\">data:</td>";
			echo "<td class=\"lewa grube\">".substr($dane['zam_data'],0,16)."</td>";						
			echo "</tr>";			
			
			echo "<tr>";
			echo "<td class=\"prawa\">użytkownik:</td>";
			echo "<td class=\"lewa grube\">";
			if(empty($dane['id_u'])){
			
				echo "niezarejestrowany";
				
			} else {
			
				if(empty($dane_u)){
					echo "usunięty";			
				} 
				
				echo "<div><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane"))."\">".$dane['klient_nazwa']."</a></div>";
				
			}
			
			echo "</td>";						
			echo "</tr>";			
						
			if(!empty($dane['email'])){
				echo "<tr>";
				echo "<td class=\"prawa\">email:</td>";
				if(!empty($dane_u['email'])){
					$dane['email']=$dane_u['email'];
				}
				echo "<td class=\"lewa grube\"><a href=\"mailto:".$dane['email']."\">".$dane['email']."</a></td>";						
				echo "</tr>";								
			}
			
			if(!empty($dane['telefon'])){
				echo "<tr>";
				echo "<td class=\"prawa\">telefon:</td>";
				if(!empty($dane_['telefon'])){
					$dane['telefon']=$dane_u['telefon'];
				}
				echo "<td class=\"lewa grube\">".$dane['telefon']."</td>";						
				echo "</tr>";								
			}			
			
			if(konf::get()->getKonfigTab("sklep_konf",'prod_waga')){				
				echo "<tr>";
				echo "<td class=\"prawa\">waga całkowita:</td>";
				echo "<td class=\"lewa grube\">".$dane['zam_waga']."</td>";						
				echo "</tr>";							
			}
			
						
			if(!empty($dane['platnosc_kod'])){
				echo "<tr>";
				echo "<td class=\"prawa\">kod zarejestrowanej płatności:</td>";		
				echo "<td class=\"lewa grube\">".$dane['platnosc_kod']."</td>";						
				echo "</tr>";						
			}
					
						
			if(!empty($dane['platnosc_error'])&&!empty($platnosci_bledy_tab[$dabe['platnosc_typ']])&&!empty($platnosci_bledy_tab[$dabe['platnosc_typ']][$dane['platnosc_error']])){
				echo "<tr>";
				echo "<td class=\"prawa\">błąd płatności:</td>";		
				echo "<td class=\"lewa grube\">".$platnosci_bledy_tab[$dabe['platnosc_typ']][$dane['platnosc_error']]."</td>";						
				echo "</tr>";						
			}
					
			
			if(!empty($dostarczenie_tab[$dane['przesylka_typ']])){
				echo "<tr>";
				echo "<td class=\"prawa\">dostawa:</td>";
				echo "<td class=\"lewa grube\">".$dostarczenie_tab[$dane['przesylka_typ']]."</td>";						
				echo "</tr>";		
			}			
			
			echo "<tr>";
			echo "<td class=\"prawa\">numer faktury:</td>";
			echo "<td class=\"lewa grube\">";
			if(konf::get()->getAkcja()!="zamowieniaadmin_drukuj"){			
				echo $form->input("text","faktura_nr","faktura_nr",$dane['faktura_nr'],"f_sredni",100);				
			} else {
				echo $dane['faktura_nr'];
			}
			echo "</td>";						
			echo "</tr>";		

			echo "<tr>";
			echo "<td class=\"prawa\">numer przesyłki:</td>";
			echo "<td class=\"lewa grube\">";
			if(konf::get()->getAkcja()!="zamowieniaadmin_drukuj"){			
				echo $form->input("text","przesylka_nr","przesylka_nr",$dane['przesylka_nr'],"f_sredni",100);				
			} else {
				echo $dane['przesylka_nr'];
			}
			echo "</td>";						
			echo "</tr>";					
			
			if(konf::get()->getAkcja()!="zamowieniaadmin_drukuj"){			
				echo "<tr>";
				echo "<td class=\"prawa\"></td>";
				echo "<td class=\"lewa grube\">";
				echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");		
				echo "</td>";						
				echo "</tr>";
			}
			
			echo "</table>";

			if(konf::get()->getAkcja()!="zamowieniaadmin_drukuj"){			
				echo $form->getFormk();		
			}
						
			echo "</td>";

			echo "<td class=\"tlo3\">";
	
			if(konf::get()->getAkcja()!="zamowieniaadmin_drukuj"){	
				$form=new formularz("post",konf::get()->getKonfigTab("plik"),"sklep","sklep");		
				echo $form->getFormp();			
				$przenies=$this->_szuk;
				$przenies['sortuj']=$sortuj;
				$przenies['podstrona']=$podstrona;
				$przenies['id_nr']=$id_nr;
				$przenies['akcja']="zamowieniaadmin_platnosc";									
				echo $form->przenies($przenies);		
			}

			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\">";
			
			echo "<tr>";
			echo "<td class=\"prawa\" style=\"width:150px;\">status zamówienia:</td>";		
			echo "<td class=\"lewa grube\">";
			if(konf::get()->getAkcja()!="zamowieniaadmin_drukuj"){			
				echo $form->select("status","status",$statusy_tab,$dane['status'],"f_dlugi",konf::get()->langTexty("zamowienia_admin_zmstatus")."--wybierz status--");			
			} else {
				if(!empty($statusy_tab[$dane['status']])){
					echo $statusy_tab[$dane['status']];
				} else {
					echo "&nbsp;";
				}
			}
			echo "</td>";						
			echo "</tr>";				
			
			echo "<tr>";
			echo "<td class=\"prawa\">typ płatności:</td>";		
			echo "<td class=\"lewa grube\">";
			if(konf::get()->getAkcja()!="zamowieniaadmin_drukuj"){					
				echo $form->select("platnosc_typ","platnosc_typ",$platnosci_tab,$dane['platnosc_typ'],"f_dlugi",konf::get()->langTexty("zamowienia_admin_zmplatnosc")."--typ płatności--");	
			} else {
				if(!empty($platnosci_tab[$dane['platnosc_typ']])){
					echo $platnosci_tab[$dane['platnosc_typ']];
				} else {
					echo "&nbsp;";
				}
			}	
			echo "</td>";						
			echo "</tr>";		
			
			echo "<tr>";
			echo "<td class=\"prawa\">status płatności:</td>";		
			echo "<td class=\"lewa grube\">";
			if(konf::get()->getAkcja()!="zamowieniaadmin_drukuj"){						
				echo $form->select("platnosc_status","platnosc_status",$platnosci_statusy_tab,$dane['platnosc_status'],"f_dlugi",konf::get()->langTexty("zamowienia_admin_zmstatusplatnosc")."--status płatności--");
			} else {
				if(!empty($platnosci_statusy_tab[$dane['platnosc_status']])){
					echo $platnosci_statusy_tab[$dane['platnosc_status']];
				} else {
					echo "&nbsp;";
				}			
			}
			echo "</td>";						
			echo "</tr>";		
											
			echo "<tr>";
			echo "<td class=\"prawa\">data płatości:</td>";		
			echo "<td class=\"lewa grube\">";
			$dane['platnosc_data']=substr(tekstForm::niepuste($dane['platnosc_data']),0,16);
			
			if(konf::get()->getAkcja()!="zamowieniaadmin_drukuj"){				
				echo $form->kalendarz("platnosc_data","trigger_a",$dane['platnosc_data'],true,true);		
			} else {
				echo $dane['platnosc_data'];
			}
			echo "</td>";						
			echo "</tr>";				
			
			echo "<tr>";
			echo "<td class=\"prawa\">zapłacono:</td>";		
			echo "<td class=\"lewa grube\">";
			if(konf::get()->getAkcja()!="zamowieniaadmin_drukuj"){		
				echo $form->input("text","platnosc_kwota","platnosc_kwota",$dane['platnosc_kwota'],"f_sredni prawa",12);				
			} else {
				echo $dane['platnosc_kwota'];
			}
			echo " zł</td>";						
			echo "</tr>";		
						
			echo "<tr>";
			echo "<td class=\"prawa\">do zapłaty:</td>";		
			echo "<td class=\"lewa grube\">".$dane['zam_kwota']." zł</td>";						
			echo "</tr>";			

			echo "<tr>";
			echo "<td class=\"prawa\">w tym koszt przesyłki:</td>";		
			echo "<td class=\"lewa grube\">".$dane['przesylka_kwota']."</td>";						
			echo "</tr>";			
			
			if(konf::get()->getAkcja()!="zamowieniaadmin_drukuj"){		
				echo "<tr>";
				echo "<td class=\"prawa\"></td>";		
				echo "<td class=\"lewa\">";
				echo $form->checkbox("poinformuj","poinformuj",1,"");
		    echo " <label for=\"poinformuj\">poinformuj klienta e-mailem o zmianie</label>";
									
		    echo "<br />";
				echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");						
				echo "</td>";						
				echo "</tr>";		
			}										
						
			echo "</table>";

			if(konf::get()->getAkcja()!="zamowieniaadmin_drukuj"){					
				echo $form->getFormk();		
			}
		
			echo "</td>";			
			
			echo "</tr>";
			
			echo "<tr valign=\"top\">";			
			
			echo "<td class=\"tlo4 grube\">Dane bilingowe/do faktury:</td>";
			
			echo "<td class=\"tlo4 grube\">Dane do przesyłki:</td>";		
							
			echo "</tr>";			
					
			echo "<tr valign=\"top\">";
			
			echo "<td class=\"tlo3\">";
			
			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\">";
									
			echo "<tr>";
			echo "<td class=\"prawa\" style=\"width:150px;\">firma:</td>";
			echo "<td class=\"lewa grube\">".$dane['firma_nazwa']."</td>";						
			echo "</tr>";								

			echo "<tr>";
			echo "<td class=\"prawa\">NIP:</td>";
			echo "<td class=\"lewa grube\">".$dane['nip']."</td>";						
			echo "</tr>";								
			
			echo "<tr>";
			echo "<td class=\"prawa\">miejscowość:</td>";
			echo "<td class=\"lewa grube\">".$dane['kod_pocztowy']." ".$dane['miejscowosc']."</td>";						
			echo "</tr>";			
			
			echo "<tr>";
			echo "<td class=\"prawa\">ulica:</td>";
			echo "<td class=\"lewa grube\">".$dane['ulica']." ".$dane['nr_domu'];
			if(!empty($dane['nr_mieszkania'])){
				echo "/".$dane['nr_mieszkania'];
			}
			echo "</td>";						
			echo "</tr>";											
			
			echo "</table>";

			
			echo "</td>";		
			
			echo "<td class=\"tlo3 lewa\">";
			
			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\">";

			echo "<tr>";
			echo "<td class=\"prawa\" style=\"width:150px;\">imię:</td>";
			echo "<td class=\"lewa grube\">".$dane['imie']."</td>";						
			echo "</tr>";	
			
			echo "<tr>";
			echo "<td class=\"prawa\">nazwisko:</td>";
			echo "<td class=\"lewa grube\">".$dane['nazwisko']."</td>";						
			echo "</tr>";				
			
			echo "<tr>";
			echo "<td class=\"prawa\">miejscowość:</td>";
			echo "<td class=\"lewa grube\">".$dane['kod_pocztowy']." ".$dane['miejscowosc']."</td>";						
			echo "</tr>";			
			
			echo "<tr>";
			echo "<td class=\"prawa\">ulica:</td>";
			echo "<td class=\"lewa grube\">".$dane['ulica']." ".$dane['nr_domu'];
			if(!empty($dane['nr_mieszkania'])){
				echo "/".$dane['nr_mieszkania'];
			}
			echo "</td>";						
			echo "</tr>";											
			
			echo "</table>";			
			
			echo "</td>";

			echo "</tr>";
							
			if(konf::get()->getAkcja()!="zamowieniaadmin_drukuj"){											
				echo "<tr class=\"srodek\"><td class=\"tlo4\" colspan=\"2\">".interfejs::linkEl("basket",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"zamowieniaadmin_arch","sortuj"=>$sortuj,"podstrona"=>$podstrona)).$link,konf::get()->langTexty("zamowienia_admin_form_listas")."Powrót na listę zamówień")."</td></tr>";
			}
			
			echo tab_stop();
						
			$colspan=4;
			
		  $link6=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklep_produkt"));					

			echo tab_nagl("Zamówione produkty",$colspan);
			
			echo "<tr class=\"grube srodek\">";
			echo "<td class=\"tlo4\">produkty:</td>";
			echo "<td class=\"tlo4\" style=\"width:50px\">ilość:</td>";		
			echo "<td class=\"tlo4\" style=\"width:80px\">cena:</td>";			
			echo "<td class=\"tlo4\" style=\"width:80px\">wartość:</td>";				
			echo "</tr>";
			
			$dane_tab=$this->getZamProdukty($id_nr);		

			if(!empty($dane_tab)){	
			
				while(list($key,$dane2)=each($dane_tab)){

					echo "<tr class=\"srodek\">";
					echo "<td class=\"tlo3 lewa\">";						
					echo "<div class=\"grube\"><a href=\"".$link6."&amp;&amp;id_produkt=".$dane2['id_produkt']."\">".$dane2['nazwa']."</a></div>";						
					echo "</td>";
					
					echo "<td class=\"tlo3\">";
					echo $dane2['ilosc'];
					echo "</td>";	
						
					echo "<td class=\"tlo3 prawa\">".sprintf('%.2f',$dane2['cena'])." zł</td>";		
						
					echo "<td class=\"tlo3 prawa\">".sprintf('%.2f',($dane2['cena']*$dane2['ilosc']))." zł</td>";	
		
					echo "</tr>";			
				
				}	

			} else {
			
				echo interfejs::brak($colspan);	
				
			}

			echo tab_stop();		
			
			if(konf::get()->getAkcja()!="zamowieniaadmin_drukuj"){	
						
				$form=new formularz("post",konf::get()->getKonfigTab("plik"),"sklep3","sklep3");		
				echo $form->getFormp();
				
				$przenies=$this->_szuk;
				$przenies['sortuj']=$sortuj;
				$przenies['podstrona']=$podstrona;
				$przenies['id_nr']=$id_nr;
				$przenies['akcja']="zamowieniaadmin_uwagi";									
				echo $form->przenies($przenies);		
				
			}
			
			echo tab_nagl("Uwagi do zamówienia",2);		
				
			if(!empty($dane_zam['uwagi_klient'])){
			
				echo "<tr><td class=\"tlo4 lewa grube\" colspan=\"2\">Uwagi od klienta:</td></tr>";
				echo "<tr><td class=\"tlo3 lewa\" colspan=\"2\">".tekstForm::doWys($dane_zam['uwagi_klient'])."</td></tr>";
				
			}
			
			echo "<tr><td class=\"tlo4 lewa grube\">Uwagi od administratora widoczne dla klienta:</td>";
			echo "<td class=\"tlo4 lewa grube\">Uwagi tylko dla administratorów:</td></tr>";					
						
			echo "<tr><td class=\"tlo3 lewa\">";
			if(konf::get()->getAkcja()!="zamowieniaadmin_drukuj"){				
				echo $form->textarea("uwagi_admin_klient","uwagi_admin_klient",$dane['uwagi_admin_klient'],"f_bdlugi",10);	
			} else {
				echo tekstForm::doWys($dane['uwagi_admin_klient']);
			}
			echo "</td>";		
			
			echo "<td class=\"tlo3 lewa\">";
			if(konf::get()->getAkcja()!="zamowieniaadmin_drukuj"){					
				echo $form->textarea("uwagi_tylko_admin","uwagi_tylko_admin",$dane['uwagi_tylko_admin'],"f_bdlugi",10);
			} else {
				echo tekstForm::doWys($dane['uwagi_tylko_admin']);		 
			}	
			echo "</td></tr>";
			
			if(konf::get()->getAkcja()!="zamowieniaadmin_drukuj"){				
			
				echo "<tr><td colspan=\"2\" class=\"tlo3 lewa\">";							
				echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");								
				echo "&nbsp;&nbsp;";				
				echo $form->checkbox("poinformuj","poinformuj2",1,"");
		    echo " <label for=\"poinformuj2\">poinformuj klienta e-mailem o zmianie</label>";												
				echo "</td></tr>";
				
			}

			echo tab_stop();

			if(konf::get()->getAkcja()!="zamowieniaadmin_drukuj"){				
				echo $form->getFormk();					
			}
		
		} else {
		
			echo interfejs::brak("",false);
		
		}
			
	
	}
	
	
	/**
   * sklep remove
   */		
	public function usun(){
	
		$ok=$this->usunRekordy(konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia'),"",0,"",konf::get()->langTexty("zamowienia_admin_a_usuwanie_log")."zamówienia - usuwanie");
		
		if($ok){
		
			$id_tab=konf::get()->getZmienna('id_tab','id_tab');

			if(!empty($id_tab)){			
				$query=tekstForm::tabQuery($id_tab);						
			}	
						
			//jeśli jest co usunac		
			if(!empty($query)){
				
				$query="DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia_produkty')." WHERE id_zam IN (".$query.")";
				konf::get()->_bazasql->zap($query);						
				
			}
			
		}
		
		
	}

	
  /**
   * set status
   */			
	public function status(){
	
		$statusy_tab=konf::get()->getKonfigTab("sklep_konf",'zamowienia_statusy');	
		$status=konf::get()->getZmienna('status','status')+0;		
		
		if($status!=''&&!empty($statusy_tab[$status])){
		
			if($status==6){
				$typ="reklamacja";
			} else if($status==7){
				$typ="zwrot";						
			} else if($status==8){
				$typ="usun";						
			} else if($status==2){
				$typ="platnosc";						
			} else if($status==4){
				$typ="potw";						
			}	
			
			if(!empty($typ)){
			
				$id_tab=konf::get()->getZmienna('id_tab','id_tab');
				if(!empty($id_tab)){			
					$query=tekstForm::tabQuery($id_tab);						
				}			
				
				if(!empty($query)){
				
					$dane_zam=konf::get()->_bazasql->pobierzRekordy("SELECT p.* FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia')." p WHERE p.id IN (".$query.")","id");		
										
					while(list($key,$dane)=each($dane_zam)){					
					
						if($dane['status']!=$status){
							$this->poinformuj($dane,$typ);
						}	
						
						
					}					
						
				}
			
			}
		
			$this->zmienparam("status",$status,konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia'),konf::get()->langTexty("zamowienia_admin_a_param_log")."zamówienia - zmiana statusu");
			$this->zmienparam("status_data",date("Y-m-d H:i:s"),konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia'),"","",false);			
		}
		
	}
	

	private function getZamProdukty($id_nr){
	
		$id_nr+=0;		
		$dane_tab=array();
	
		if(!empty($id_nr)){
	    $sql="SELECT p.*, p2.symbol,p2.waga FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia_produkty')." p LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." p2 ON p.id_produkt=p2.id WHERE p.id_zam='".$id_nr."' ";
			$sql.=" ORDER BY p.id";			
			$dane_tab=konf::get()->_bazasql->pobierzRekordy($sql,"id");			
		}
		
		return $dane_tab;
	
	}	
	
	
	/**
   * uwagi save
   */		
	public function faktura(){
	
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr',"id_nr"));		
		$poinformuj=tekstForm::doSql(konf::get()->getZmienna('poinformuj',"poinformuj"));		
		
		$dane=array(
			"faktura_nr"=>"",
			"przesylka_nr"=>"",											
		);

		$daneNieczysc=array();
		$testy=array();
		
		if(!empty($id_nr)){
		
			$dane_zam=konf::get()->_bazasql->pobierzRekord("SELECT p.* FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia')." p WHERE id='".$id_nr."'");
		
		}
		
		if(!empty($dane_zam)){
					
			//generator zapytania insert/update
			require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
			$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia'),$dane,$daneNieczysc);
			$sqldane->daneOdczyt();	
			$sqldane->setAutor(true);	
			$sqldane->setTesty($testy);
			
			$sqldane->testuj();	
			
			if($sqldane->ok()){
			
				//budowanie zapytania
				$sqldane->dodajDaneE();																		
				$sqldane->dodaj(" WHERE id='".$id_nr."'");							
				//wykonaj zapytanie
				if($sqldane->getSql()){
					konf::get()->_bazasql->zap($sqldane->getSql());
				}				
				
				user::get()->zapiszLog(konf::get()->langTexty("zamowienia_admin_arch_sedycjau_log")."edycja zamówienia - faktura ".$id_nr,user::get()->login());		
				konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");
				
				if($poinformuj){
				
					$this->poinformuj($id_nr,"informacja");
				
				}
								
			} else { 			
				konf::get()->setKomunikat(konf::get()->langTexty("niezapisane"),"error"); 				
			} 

		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 		
		}
		
	}			
	
	/**
   * uwagi save
   */		
	public function uwagi(){

		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr',"id_nr"));		
		$poinformuj=tekstForm::doSql(konf::get()->getZmienna('poinformuj',"poinformuj"));		
		
		$dane=array(
			"uwagi_tylko_admin"=>"",
			"uwagi_admin_klient"=>"",											
		);

		$daneNieczysc=array();
		$testy=array();
		
		if(!empty($id_nr)){
		
			$dane_zam=konf::get()->_bazasql->pobierzRekord("SELECT p.* FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia')." p WHERE id='".$id_nr."'");
		
		}
		
		if(!empty($dane_zam)){
					
			//generator zapytania insert/update
			require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
			$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia'),$dane,$daneNieczysc);
			$sqldane->daneOdczyt();	
			$sqldane->setAutor(true);	
			$sqldane->setTesty($testy);
			
			$sqldane->testuj();	
			
			if($sqldane->ok()){
			
				//budowanie zapytania
				$sqldane->dodajDaneE();																		
				$sqldane->dodaj(" WHERE id='".$id_nr."'");							
				//wykonaj zapytanie
				if($sqldane->getSql()){
					konf::get()->_bazasql->zap($sqldane->getSql());
				}				
				
				user::get()->zapiszLog(konf::get()->langTexty("zamowienia_admin_arch_sedycjau_log")."edycja zamówienia - uwagi ".$id_nr,user::get()->login());		
				konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");
				
				if($poinformuj){
				
					$this->poinformuj($id_nr,"informacja");
				
				}
				
				
			} else { 			
				konf::get()->setKomunikat(konf::get()->langTexty("niezapisane"),"error"); 				
			} 

		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 		
		}
		
	}		
	
	
	/**
   * platnosc save
   */		
	public function platnosc(){

		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr',"id_nr"));		
		$poinformuj=tekstForm::doSql(konf::get()->getZmienna('poinformuj',"poinformuj"));		
		$statusy_tab=konf::get()->getKonfigTab("sklep_konf",'zamowienia_statusy');
		$platnosci_tab=konf::get()->getKonfigTab("sklep_konf",'platnosci_tab');		
		$platnosci_statusy_tab=konf::get()->getKonfigTab("sklep_konf",'platnosci_statusy_tab');				
		$dostarczenie_tab=konf::get()->getKonfigTab("sklep_konf",'dostarczenie_tab');				
		
		$dane=array(
			"status"=>"",
			"platnosc_typ"=>"",
			"platnosc_status"=>"",
			"platnosc_kwota"=>"",	
			"platnosc_data"=>"",						
		);

		$daneNieczysc=array();
		$testy=array();
		
		$testy[]=array("zmienna"=>"platnosc_kwota","test"=>"liczba",
			"param"=>array(
				"po_przecinku"=>2,
				"domyslny"=>0,
				"min"=>0,			
			)
		);	
		
		$testy[]=array("zmienna"=>"status","test"=>"wtablicyi",
			"param"=>array(
				"wartosci"=>$statusy_tab,
				"domyslny"=>0
			)
		);					
		
		$testy[]=array("zmienna"=>"platnosc_typ","test"=>"wtablicyi",
			"param"=>array(
				"wartosci"=>$platnosci_tab,
				"domyslny"=>0
			)
		);		
		
		$testy[]=array("zmienna"=>"platnosc_status","test"=>"wtablicyi",
			"param"=>array(
				"wartosci"=>$platnosci_statusy_tab,
				"domyslny"=>0
			)
		);	
						
		if(!empty($id_nr)){
		
			$dane_zam=konf::get()->_bazasql->pobierzRekord("SELECT p.* FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia')." p WHERE id='".$id_nr."'");
		
		}
		
		if(!empty($dane_zam)){
					
			//generator zapytania insert/update
			require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
			$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia'),$dane,$daneNieczysc);
			$sqldane->daneOdczyt();	
			$sqldane->setAutor(true);	
			$sqldane->setTesty($testy);
			
			$sqldane->testuj();	
			
			if($sqldane->ok()){
			
				//budowanie zapytania
				$sqldane->dodajDaneE();																		
				$sqldane->dodaj(" WHERE id='".$id_nr."'");							
				//wykonaj zapytanie
				if($sqldane->getSql()){
					konf::get()->_bazasql->zap($sqldane->getSql());
				}				
				
				user::get()->zapiszLog(konf::get()->langTexty("zamowienia_admin_arch_sedycjau_log")."edycja zamówienia - płatność ".$id_nr,user::get()->login());		
				konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");
				
				if($poinformuj){

					$typ="informacja";
					
					$status=$sqldane->getDane('status');
					
					if($dane_zam['status']!=$status){
						if($status==6){
							$typ="reklamacja";
						} else if($status==7){
							$typ="zwrot";						
						} else if($status==8){
							$typ="usun";						
						} else if($status==2){
							$typ="platnosc";						
						} else if($status==4){
							$typ="potw";						
						}	
					}									

					$this->poinformuj($id_nr,$typ);
				
				}
								
			} else { 			
				konf::get()->setKomunikat(konf::get()->langTexty("niezapisane"),"error"); 				
			} 

		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 		
		}
		
	}			
	
	public function poinformuj($dane,$typ="potwierdz"){
	
		require_once(konf::get()->getKonfigTab('mod_kat')."koszyk/class.koszyk.php");	
		$koszyk=new koszyk();
		$koszyk->poinformuj($dane,$typ);
	
	}
	
	
	/**
   * sklep stat
   */			
	public function staty(){
	
		$statusy_tab=konf::get()->getKonfigTab("sklep_konf",'zamowienia_statusy');
		$platnosci_tab=konf::get()->getKonfigTab("sklep_konf",'platnosci_tab');		
		$platnosci_statusy_tab=konf::get()->getKonfigTab("sklep_konf",'platnosci_statusy_tab');			
			
		$query="";
		
		$this->statpanel();

		echo tab_nagl("Statystyka zamówień",2);

		echo "<tr class=\"prawa grube\"><td class=\"tlo4\" style=\"width:80%\">Nazwa:</td>";
		echo "<td class=\"tlo4\" style=\"width:20%\">Ilość:</td></tr>";
		
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">Ilość zamówień</td>";		
		echo "<td class=\"tlo4 prawa\">";
		echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia')." WHERE 1".$query);
		echo "</td>";
		echo "</tr>";				
		
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">Ilość sztuk zamówionych produktów</td>";		
		echo "<td class=\"tlo4 prawa\">";
		$dane=konf::get()->_bazasql->pobierzRekord("SELECT SUM(ilosc) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia_produkty')." WHERE 1 ".$query);
		echo $dane['ile'];		
		echo "</td>";
		echo "</tr>";			
		
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">Łączna kwota zamówień</td>";		
		echo "<td class=\"tlo4 prawa\">";
		$dane=konf::get()->_bazasql->pobierzRekord("SELECT SUM(zam_kwota) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia')." WHERE 1 ".$query);
		echo $dane['ile'];		
		echo "</td>";
		echo "</tr>";				
		
		echo "<tr><td colspan=\"2\" class=\"tlo4 grube\">Zamówienia według statusów</td></tr>";					
	
		$dane_tab=konf::get()->_bazasql->pobierzRekordy("SELECT status, COUNT(id) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia')." WHERE 1 ".$query." GROUP BY status","status");

		while(list($key,$val)=each($statusy_tab)){
		
			echo "<tr class=\"prawa\">";
			echo "<td class=\"tlo3\">".$val."</td>";		
			echo "<td class=\"tlo4 prawa\">";
			
			if(!empty($dane_tab[$key])){
				echo $dane_tab[$key]['ile'];				
			}	else {
				echo "0";
			}
			echo "</td>";
			echo "</tr>";					
		
		}		
			
		echo "<tr><td colspan=\"2\" class=\"tlo4 grube\">Zamówienia według typu płatności</td></tr>";				
		
			
		$dane_tab=konf::get()->_bazasql->pobierzRekordy("SELECT platnosc_typ, COUNT(id) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia')." WHERE 1 ".$query." GROUP BY platnosc_typ","platnosc_typ");
		
		while(list($key,$val)=each($platnosci_tab)){
		
			echo "<tr class=\"prawa\">";
			echo "<td class=\"tlo3\">".$val."</td>";		
			echo "<td class=\"tlo4 prawa\">";
			
			if(!empty($dane_tab[$key])){
				echo $dane_tab[$key]['ile'];				
			}	else {
				echo "0";
			}
			echo "</td>";
			echo "</tr>";					
		
		}		
		
		echo "<tr><td colspan=\"2\" class=\"tlo4 grube\">Zamówienia według statusu płatności</td></tr>";				
		
		$dane_tab=konf::get()->_bazasql->pobierzRekordy("SELECT platnosc_status, COUNT(id) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia')." WHERE 1 ".$query." GROUP BY platnosc_status","platnosc_status");
		
		while(list($key,$val)=each($platnosci_statusy_tab)){
		
			echo "<tr class=\"prawa\">";
			echo "<td class=\"tlo3\">".$val."</td>";		
			echo "<td class=\"tlo4 prawa\">";
			
			if(!empty($dane_tab[$key])){
				echo $dane_tab[$key]['ile'];				
			}	else {
				echo "0";
			}
			echo "</td>";
			echo "</tr>";					
		
		}						

		echo tab_stop();
		
	}	
	
	/**
   * sklep stat
   */			
	public function statprod(){
	
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');	
		$na_str=50;			
		
		$link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>konf::get()->getAkcja()));		
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklep_zobacz"));
		
		$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." WHERE lang='".konf::get()->getLang()."' AND licznik_sprzedane>0 ";
				
		$naw = new nawig("SELECT COUNT(id) AS ilosc ".$query,$podstrona,$na_str);
		$naw->naw($link2);
		$podstrona=$naw->getPodstrona();		
		
		$this->statpanel();			
				
		echo tab_nagl("Statystyka - najczęściej zamawiane produkty",2);		
		
		if($naw->getNaw()){
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
		}			

		echo "<tr class=\"prawa grube\"><td class=\"tlo4\" style=\"width:80%\">Nazwa:</td>";
		echo "<td class=\"tlo4\" style=\"width:20%\">Ilość:</td></tr>";
		
		if($naw->getWynikow()>0){
		
			$zap=konf::get()->_bazasql->zap("SELECT * ".$query." ORDER BY licznik_sprzedane DESC, nazwa");	

			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){		
		
				echo "<tr class=\"prawa\">";
				echo "<td class=\"tlo3\"><a href=\"".$link."&amp;id_nr=".$dane['id']."\">".$dane['nazwa']."</a></td>";		
				echo "<td class=\"tlo4 prawa\">";				
				echo $dane['licznik_sprzedane'];
				echo "</td>";
				echo "</tr>";			
				
			}		
		
		}	else {
		
			echo interfejs::brak(3);
			
		}
			
		echo tab_stop();
		
	}
	
	
	/**
   * sklep stat
   */			
	public function statkwoty(){
	
		$mc_tab=konf::get()->getKonfigTab("mc_tab");
		$link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>konf::get()->getAkcja()));				
		$query="SELECT SUBSTRING(zam_data,1,7) AS zam_data, SUM(zam_kwota) AS zam_kwota, COUNT(id) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia')." WHERE status=4 AND zam_kwota>0 GROUP BY(zam_data) ORDER BY zam_data";

		$this->statpanel();			
				
		echo tab_nagl("Statystyka - zrealizowane zamówienia miesięcznie",3);		
		
		echo "<tr class=\"prawa grube\">";
		echo "<td class=\"tlo4\" style=\"width:60%\">Nazwa:</td>";
		echo "<td class=\"tlo4\" style=\"width:20%\">Ilość:</td>";
		echo "<td class=\"tlo4\" style=\"width:20%\">Wartość:</td>";
		echo "</tr>";		
		
		$rok="";
		$mc="";
		
		$zap=konf::get()->_bazasql->zap($query);	
		
		if(konf::get()->_bazasql->numRows($zap)>0){

			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){		
			
				if(substr($dane['zam_data'],0,4)!=$rok){
					$rok=substr($dane['zam_data'],0,4);			
				}
				
				if((substr($dane['zam_data'],5,2)+0)!=$mc){
					$mc=substr($dane['zam_data'],5,2)+0;			
				}			
		
				echo "<tr class=\"prawa\">";
				echo "<td class=\"tlo3\">".$mc_tab[$mc]." ".$rok."</td>";		
				echo "<td class=\"tlo3 prawa\">";				
				echo $dane['ile'];
				echo "</td>";
				echo "<td class=\"tlo3 prawa\">";				
				echo $dane['zam_kwota'];
				echo "</td>";			
				echo "</tr>";			
				
			}		
			
		}	else {
		
			echo interfejs::brak(3);
			
		}

		echo tab_stop();
		
	}		
		
	
	private function statpanel(){
	
		$table_akcje['zamowieniaadmin_staty']="zamówienia - ogólnie";
		$table_akcje['zamowieniaadmin_statprod']="najczęsciej zamawiane produkty";
		$table_akcje['zamowieniaadmin_statkwoty']="zamówienia miesięcznie";												
		
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
	
	
	/**
   * class constructor php5	
   */	
	public function __construct() {	
		
		$this->_admin=konf::get()->getKonfigTab("sklep_konf",'admin_sklep');
		
  }	

		
}

?>