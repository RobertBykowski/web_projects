<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

class produktyadmin extends moduladmin {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="produktyadmin class";	

	/**
	 * get search values
	 */		
	protected $_szuk=array(
		"id_kat"=>"",		
		"id_d"=>"",		
		"szuk_producent"=>"",			
		"szuk_nazwa"=>"",	
		"szuk_symbol"=>"",			
		"szuk_priorytet"=>"",			
		"szuk_nowosc"=>"",		
		"szuk_wyr"=>"",
		"szuk_promocja"=>"",					
		"szuk_polecamy"=>"",			
		"szuk_wyprzedaz"=>"",			
		"szuk_cenaod"=>"",			
		"szuk_cenado"=>"",				
	);
	
	
	public function sciezka(){

		$id_kat=tekstForm::doSql(konf::get()->getZmienna('id_kat','id_kat'));	
		$id_d=tekstForm::doSql(konf::get()->getZmienna('id_d','id_d'));	
		
		$link="";
		
		$akcja2="sklepadmin_arch";
		$akcja3="produktyadmin_arch";

		if(!empty($id_kat)){
			$id=$id_kat;
			while($id!=0){
 				$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." WHERE id='".$id."'");		

				if(!empty($dane)){
					if(!empty($dane['typ'])&&$dane['typ']==1){
						$link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>$akcja3,"id_d"=>$id_d));
					} else {
						$link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>$akcja2,"id_d"=>$id_d));
					}				
					$id_d=$dane['id_d'];
					$link=" &gt; <a href=\"".$link2."&amp;sklep_d=".$id_d."&amp;id_kat=".$id."\">".$dane['tytul']."</a>".$link;
					$id=$dane['id_matka'];
				} else {
					break;
				}
				
			}
		}

		$d_tab=konf::get()->getKonfigTab("sklep_konf",'d_tab');
		
		if(!empty($id_d)&&!empty($d_tab[$id_d])){	
			$this->_szuk['id_d']=$id_d;
			$link="<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_arch","id_d"=>$id_d))."\">".$d_tab[$id_d]."</a>".$link;
		}

		if(!empty($link)){
		
			echo tab_nagl("",1);
			echo "<tr style=\"height:24px\">";
			
			echo "<td valign=\"middle\" class=\"tlo3 lewa\">";		
			echo "<table border=\"0\" cellspacing=\"0\" class=\"lewa nowa_l\"><tr valign=\"middle\">";
			echo "<td valign=\"top\">";
			echo "<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_dzialy"))."\"><img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/ikony/house.gif\" width=\"16\" height=\"16\" alt=\"\" class=\"lewa\" style=\"margin-right:2px\" /></a>";
			echo "</td><td> &gt; ";	
			echo $link;
			echo "</td></tr></table>";
			echo "</td></tr>";
			echo tab_stop();		
		}		
		
	}		

	/**
   * sklep arch
   */		
	public function arch(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$id_nr=konf::get()->getZmienna('id_nr','id_nr');
		$sortuj=tekstForm::doSql(konf::get()->getZmienna('sortuj','sortuj'));

		$na_str=50;
		$colspan=5;
		if(konf::get()->getKonfigTab("sklep_konf",'prod_symbol')){
			$colspan++;
		}
		if(konf::get()->getKonfigTab("sklep_konf",'prod_zliczac_sprzedane')){
			$colspan++;
		}		
		if(konf::get()->getKonfigTab("sklep_konf",'prod_zliczac_wys')){
			$colspan++;
		}		
		
		if(konf::get()->getKonfigTab("sklep_konf",'prod_waga')){
			$colspan++;
		}		
		
		if(konf::get()->getKonfigTab("sklep_konf",'prod_dostepnosc_sztuk')){
			$colspan++;
		}							
		
	  $tab_sort=array(
			1=>"p.id", 2=>"p.id DESC", 
			3=>"p.symbol", 4=>"p.symbol DESC", 			
			5=>"p.nazwa", 6=>"p.nazwa DESC", 
			11=>"p.cena, p.nazwa", 12=>"p.cena DESC, p.nazwa", 		
			19=>"p.waga, p.nazwa", 20=>"p.waga DESC, p.nazwa", 				
			13=>"p.status, p.nazwa", 14=>"p.status DESC, p.nazwa", 			
			15=>"p.licznik_sprzedane, p.nazwa", 16=>"p.licznik_sprzedane DESC, p.nazwa", 					
			17=>"p.licznik, p.nazwa", 18=>"p.licznik DESC, p.nazwa", 					
		);
		
    if(empty($sortuj)||empty($tab_sort[$sortuj])){ 
			$sortuj=5; 
		}

		$link=$this->szukZmienne(1);			

    $query=" FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." p LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'sklep_producenci')." pr ON p.id_producent=pr.id LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." k ON p.id_kat=k.id WHERE p.lang='".konf::get()->getLang()."' ";

	  if(!empty($this->_szuk['id_kat'])){
	    $query.=" AND p.id_kat='".tekstForm::doSql($this->_szuk['id_kat'])."'";
	  }
	  if(!empty($this->_szuk['szuk_producent'])){
	    $query.=" AND p.id_producent='".tekstForm::doSql($this->_szuk['szuk_producent'])."'";
	  }
	  if(!empty($this->_szuk['szuk_nazwa'])){
	    $query.=" AND p.nazwa LIKE '%".tekstForm::Like($this->_szuk['szuk_nazwa'])."%'";
	  }		
	  if(!empty($this->_szuk['szuk_symbol'])){
	    $query.=" AND p.symbol LIKE '%".tekstForm::doLike($this->_szuk['szuk_symbol'])."%'";
	  }		
	  if(!empty($this->_szuk['szuk_wyr'])){
	    $query.=" AND p.wyr=1";
	  }		
	  if(!empty($this->_szuk['szuk_promocja'])){
	    $query.=" AND p.promocja=1";
	  }		
	  if(!empty($this->_szuk['szuk_polecamy'])){
	    $query.=" AND p.polecamy=1";
	  }		
	  if(!empty($this->_szuk['szuk_wyprzedaz'])){
	    $query.=" AND p.wyprzedaz=1";
	  }			
	  if(!empty($this->_szuk['szuk_nowosc'])){
	    $query.=" AND p.nowosc=1";
	  }			
	  if(!empty($this->_szuk['szuk_priorytet'])){
	    $query.=" AND p.priorytet>0";
	  }														
	  if(!empty($this->_szuk['szuk_cenaod'])){
	    $query.=" AND p.cena>='".tekstForm::doLiczba($this->_szuk['szuk_cenaod'])."'";
	  }		
	  if(!empty($this->_szuk['szuk_cenado'])){
	    $query.=" AND p.cena<='".tekstForm::doLiczba($this->_szuk['szuk_cenado'])."'";
	  }		
						
    $link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_edytuj","sortuj"=>$sortuj,"podstrona"=>$podstrona)).$link;
    $link3=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_usun","sortuj"=>$sortuj,"podstrona"=>$podstrona)).$link;		
    $link5=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_konfigedytuj","sortuj"=>$sortuj,"podstrona"=>$podstrona)).$link;	
	  $link4=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_konfigedytuj","sortuj"=>$sortuj,"podstrona"=>$podstrona)).$link;		
	  $link6=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklep_produkt"));		
								
    $link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_arch")).$link;		
		
		$naw = new nawig("SELECT COUNT(p.id) AS ilosc".$query,$podstrona,$na_str);		
		$naw->naw($link."&amp;sortuj=".$sortuj);
		$podstrona=$naw->getPodstrona();		
		
		$this->sciezka();	
	    		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"arch","arch");
		echo $form->spr(array(1=>"akcja"),"","ok=spr_akcjau(document.arch.akcja,'produktyadmin_usun','".konf::get()->langTexty("czyusun")."');");
		echo $form->getFormp();
		
		$przenies=$this->_szuk;
		$przenies['sortuj']=$sortuj;
		$przenies['podstrona']=$podstrona;
				
		echo $form->przenies($przenies);
			
	  echo tab_nagl(konf::get()->langTexty("produkty_admin")."Lista produktów (".$naw->getWynikow()."):",$colspan);
		
		if(!empty($this->_szuk['id_kat'])){
			$dane_kat=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." WHERE id='".$this->_szuk['id_kat']."'");		
			if(!empty($dane_kat)){
		    echo "<tr><td class=\"tlo3 lewa\" colspan=\"".$colspan."\">".konf::get()->langTexty("produkty_wybkat")."Wybrana kategoria: <span class=\"grube\">".$dane_kat['tytul']."</span></td></tr>";			
			}
			
		}		
	  						
    echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 lewa\">";
		
    //akcje  
		$akcje_tab['produktyadmin_dodaj']=konf::get()->langTexty("adodaj");	
		
		if($naw->getWynikow()>0){			
			
			$akcje_tab['produktyadmin_aktyw']=konf::get()->langTexty("aaktyw");
			$akcje_tab['produktyadmin_deaktyw']=konf::get()->langTexty("adeaktyw");
			
			if(konf::get()->getKonfigTab("sklep_konf",'prod_dostepnosc_sztuk')){				
				$akcje_tab['produktyadmin_dostepnosc']="zmień dostępność";					
			}

			if(konf::get()->getKonfigTab("sklep_konf",'prod_nowosc')){	
				$akcje_tab['produktyadmin_nowosc']=konf::get()->langTexty("produkty_admin_arch_anowosc")."zaznaczone ustaw nowość";
				$akcje_tab['produktyadmin_denowosc']=konf::get()->langTexty("produkty_admin_arch_anienowosc")."zaznaczone usuń nowość";			
			}		
			if(konf::get()->getKonfigTab("sklep_konf",'prod_wyr')){	
				$akcje_tab['produktyadmin_wyr']=konf::get()->langTexty("produkty_admin_arch_awyr")."zaznaczone ustaw wyróznione";
				$akcje_tab['produktyadmin_dewyr']=konf::get()->langTexty("produkty_admin_arch_aniewyr")."zaznaczone usuń wyróznione";		
			}				
			if(konf::get()->getKonfigTab("sklep_konf",'prod_promocja')){	
				$akcje_tab['produktyadmin_promocja']=konf::get()->langTexty("produkty_admin_arch_apromocja")."zaznaczone ustaw promocja";
				$akcje_tab['produktyadmin_depromocja']=konf::get()->langTexty("produkty_admin_arch_anieprmocja")."zaznaczone usuń promocja";		
			}					
			if(konf::get()->getKonfigTab("sklep_konf",'prod_polecamy')){	
				$akcje_tab['produktyadmin_polecamy']=konf::get()->langTexty("produkty_admin_arch_apolecamy")."zaznaczone ustaw polecamy";
				$akcje_tab['produktyadmin_depolecamy']=konf::get()->langTexty("produkty_admin_arch_aniepolecamy")."zaznaczone usuń polecamy";		
			}		
			if(konf::get()->getKonfigTab("sklep_konf",'prod_wyprzedaz')){	
				$akcje_tab['produktyadmin_wyprzedaz']=konf::get()->langTexty("produkty_admin_arch_awyprzedaz")."zaznaczone ustaw wyprzedaz";
				$akcje_tab['produktyadmin_dewyprzedaz']=konf::get()->langTexty("produkty_admin_arch_aniewyprzedaz")."zaznaczone usuń wyprzedaz";		
			}						
			if(konf::get()->getKonfigTab("sklep_konf",'import_csv')){		
				$akcje_tab['produktyadmin_importcsv']=konf::get()->langTexty("produkty_admin_arch_awimport")."import produktów z CSV";		
			}		
			
			$akcje_tab['produktyadmin_usun']=konf::get()->langTexty("ausun");		
		}		
						
		echo $form->selectAkcja($akcje_tab);
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
		echo interfejs::sortEl($link."&amp;sortuj=",1,2,konf::get()->langTexty("produkty_admin_arch_nr")."id",$sortuj,50);
		
		if(konf::get()->getKonfigTab("sklep_konf",'prod_symbol')){		
			echo interfejs::sortEl($link."&amp;sortuj=",3,4,konf::get()->langTexty("produkty_admin_arch_symbol")."symbol",$sortuj,100);		
		}
		echo interfejs::sortEl($link."&amp;sortuj=","","",konf::get()->langTexty("produkty_admin_arch_zdjecie")."zdjęcie",$sortuj);			
		echo interfejs::sortEl($link."&amp;sortuj=",5,6,konf::get()->langTexty("produkty_admin_arch_nazwa")."nazwa",$sortuj);			
		echo interfejs::sortEl($link."&amp;sortuj=",11,12,konf::get()->langTexty("produkty_admin_arch_cena")."cena",$sortuj,80);
		if(konf::get()->getKonfigTab("sklep_konf",'prod_waga')){		
			echo interfejs::sortEl($link."&amp;sortuj=",19,20,konf::get()->langTexty("produkty_admin_arch_waga")."waga",$sortuj,50);	
		}					
		echo interfejs::sortEl($link."&amp;sortuj=",13,14,konf::get()->langTexty("produkty_admin_arch_status")."status",$sortuj,100);	
		
		if(konf::get()->getKonfigTab("sklep_konf",'prod_dostepnosc_sztuk')){		
			echo interfejs::sortEl($link."&amp;sortuj=","","",konf::get()->langTexty("produkty_admin_arch_spr")."dost.",$sortuj,50);			
		}	
		
		if(konf::get()->getKonfigTab("sklep_konf",'prod_zliczac_sprzedane')){		
			echo interfejs::sortEl($link."&amp;sortuj=",15,16,konf::get()->langTexty("produkty_admin_arch_spr")."kup.",$sortuj,50);	
		}
		if(konf::get()->getKonfigTab("sklep_konf",'prod_zliczac_wys')){		
			echo interfejs::sortEl($link."&amp;sortuj=",17,18,konf::get()->langTexty("produkty_admin_arch_ogl")."ogl.",$sortuj,50);	
		}
    echo "</tr>";			

	  //pobieranie danych  
	  $query="SELECT p.*, k.tytul AS kategoria, pr.nazwa AS producent ".$query." ORDER BY ".$tab_sort[$sortuj]."";
	  $query.=" LIMIT ".$naw->getStart().",".$naw->getIle();
			
	  $i=0;	    		
	  $dane_tab=konf::get()->_bazasql->pobierzRekordy($query,"id");

		if(!empty($dane_tab)){
				
			while(list($key,$dane)=each($dane_tab)){
				
		  	$i++;
					
	      echo "<tr class=\"srodek\">";
				
				echo "<td class=\"tlo4 srodek\">";
				echo $form->checkbox("id_tab[]","id_".$dane['id'],$dane['id'],"");	
				echo "<div ";
				if($id_nr==$dane['id']){
					echo " class=\"grube\"";
				}
				echo ">".$dane['id']."</div>";
	      echo "</td>";
				
				if(konf::get()->getKonfigTab("sklep_konf",'prod_symbol')){					
	  	    echo "<td class=\"tlo3 srodek\">";
		  	  echo $dane['symbol'];				
					echo "</td>";				
				}
								
	  	  echo "<td class=\"tlo3 srodek\">";
				if(!empty($dane['img'])&&!empty($dane['img3_w'])&&!empty($dane['img3_h'])&&!empty($dane['img3_nazwa'])){
				
					$pliczek=konf::get()->getKonfigTab("sklep_konf",'produkty_kat').$dane['img3_nazwa'];			
					
				  if(file_exists(konf::get()->getKonfigTab("serwer").$pliczek)){		
					
						echo "<a href=\"".$link2."&amp;id_nr=".$dane['id']."\"><img src=\"".konf::get()->getKonfigTab("sciezka").$pliczek."\" width=\"".$dane['img3_w']."\" height=\"".$dane['img3_h']."\" alt=\"".htmlspecialchars($dane['nazwa'])."\" title=\"".htmlspecialchars($dane['nazwa'])."\" class=\"prod_img\" /></a>";								
						
					} else {
						echo "&nbsp;";					
					}
					
				}	else {
					echo "&nbsp;";
				}
				echo "</td>";				
			
		        
	      echo "<td class=\"tlo3 lewa\">";
		    echo "<a class=\"grube\" href=\"".$link2."&amp;id_nr=".$dane['id']."\">".$dane['nazwa']."</a>";
				
				if(!empty($dane['kategoria'])||!empty($dane['producent'])){			
					echo "<div class=\"male\">";										
					if(!empty($dane['kategoria'])){
						echo konf::get()->langTexty("produkty_admin_arch_kategoria")."Kat.: ";		
						echo $dane['kategoria'];
						echo " ";
					}
					if(!empty($dane['producent'])){
						echo konf::get()->langTexty("produkty_admin_arch_producent")."Prod.: ";		
						echo $dane['producent'];
					}
					
					echo "</div>";
							
				}
								
				echo "<div><table border=\"0\" style=\"margin-top:5px\"><tr>";    					
		    echo interfejs::edytuj($link2."&amp;id_nr=".$dane['id']."&amp;akcja=produktyadmin_edytuj&amp;id_nr=".$dane['id']);					
			  echo interfejs::przyciskEl("folder_wrench",$link4."&amp;id_nr=".$dane['id'],konf::get()->langTexty("produkty_admin_arch_edytujk")."edytuj konfigurację");
			  echo interfejs::podglad($link6."&amp;id_produkt=".$dane['id']); 				
				echo interfejs::usun($link3."&amp;id_tab[1]=".$dane['id']); 										
				echo interfejs::infoEl($dane);			
				echo "</tr></table></div>";   					
				echo "</td>";

	      echo "<td class=\"tlo3 prawa\">";
		    echo "<div class=\"grube\">".$dane['cena']."</div>";				
				if(tekstForm::niepuste($dane['cena_skreslona'])){
					echo "<div class=\"male\" style=\"color:#ff0000; text-decoration:line-through\">".$dane['cena_skreslona']."</div>";
				}
				if(konf::get()->getKonfigTab("sklep_konf",'prod_cenapromo')&&tekstForm::niepuste($dane['cena_promo'])){				
					echo "<div class=\"male\">(".$dane['cena_promo'].")</div>";				
				}
				echo "</td>";			
				
				if(konf::get()->getKonfigTab("sklep_konf",'prod_waga')){					
	  	    echo "<td class=\"tlo3 prawa\">";
		  	  echo $dane['waga'];				
					echo "</td>";										
				}							
												
	      //status  
	      echo "<td class=\"tlo3\">";
	      if($dane['status']==1){ 
					echo konf::get()->langTexty("aktywne"); 
				} else { 
					echo konf::get()->langTexty("nieaktywne"); 
				}

	      echo "</td>";		
				
				if(konf::get()->getKonfigTab("sklep_konf",'prod_dostepnosc_sztuk')){		
		      echo "<td class=\"tlo3\">";								
					echo $form->input("text","dostepnosc_".$dane['id'],"dostepnosc_".$dane['id'],$dane['dostepnosc_sztuk'],"formularz f_krotki2 prawa",7);	
					echo $form->input("hidden","id_tab2[]","id_tab2_".$dane['id'],$dane['id'],"");						
		      echo "</td>";		
				}										
																	
				if(konf::get()->getKonfigTab("sklep_konf",'prod_zliczac_sprzedane')){					
	  	    echo "<td class=\"tlo3 srodek\">";
		  	  echo $dane['licznik_sprzedane'];				
					echo "</td>";										
				}
				
				if(konf::get()->getKonfigTab("sklep_konf",'prod_zliczac_wys')){					
	  	    echo "<td class=\"tlo3 srodek\">";
		  	  echo $dane['licznik'];				
					echo "</td>";		
				}
						    					
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
		echo $form2->przenies(array("akcja"=>"produktyadmin_arch","sortuj"=>$sortuj));		
	
		$producenci_tab=$this->pobierzProducenci();
		$kategorie_tab=$this->pobierzKategorie();		
		$d_tab=konf::get()->getKonfigTab("sklep_konf",'d_tab');		
		
		echo $form2->select("szuk_producent","szuk_producent",$producenci_tab,$this->_szuk['szuk_producent'],"f_dlugi",konf::get()->langTexty("produkty_admin_producenci")."--wybierz producenta--");
		echo " ";
		echo $form2->select2("id_kat","id_kat",$d_tab,$kategorie_tab,$this->_szuk['id_kat'],"f_bdlugi",konf::get()->langTexty("produkty_admin_kategorie")."--wybierz kategorię--");
		echo " ";
		echo $form2->input("submit","","",konf::get()->langTexty("szukaj"),"formularz2 f_sredni");		
				
		echo "<div>";					
		echo interfejs::label("szuk_nazwa",konf::get()->langTexty("produkty_admin_szuknazwa")."nazwa: ");						
		echo $form2->input("text","szuk_nazwa","szuk_nazwa",$this->_szuk['szuk_nazwa'],"f_sredni",150);		
		echo " ";			
		echo interfejs::label("szuk_symbol",konf::get()->langTexty("produkty_admin_szuksymbol")."symbol: ");								
		echo $form2->input("text","szuk_symbol","szuk_symbol",$this->_szuk['szuk_symbol'],"f_sredni",150);				
		echo " ";				
		echo interfejs::label("szuk_cenaod",konf::get()->langTexty("produkty_admin_szukcenaod")."cena od: ");					
		echo $form2->input("text","szuk_cenaod","szuk_cenaod",$this->_szuk['szuk_cenaod'],"f_krotki",20);				
		echo " ";	
		echo interfejs::label("szuk_cenado",konf::get()->langTexty("produkty_admin_szukcenado")." do: ");				
		echo $form2->input("text","szuk_cenado","szuk_cenado",$this->_szuk['szuk_cenado'],"f_krotki",20);							
		echo "</div>";
			
		echo "<div style=\"padding-top:5px;\"><div class=\"grube\" style=\"padding-bottom:5px;\">".konf::get()->langTexty("produkty_admin_oznaczone")."Tylko produkty oznaczone jako:</div>";
		if(konf::get()->getKonfigTab("sklep_konf",'prod_nowosc')){	
			echo "<span class=\"nobr\">";
			echo $form->checkbox("szuk_nowosc","szuk_nowosc",1,$this->_szuk['szuk_nowosc']);
			echo interfejs::label("szuk_nowosc",konf::get()->langTexty("produkty_admin_szuknowosc")."nowość","",true);								
	    echo "</span> ";
		}		
		if(konf::get()->getKonfigTab("sklep_konf",'prod_wyr')){	
			echo "<span class=\"nobr\">";
			echo $form->checkbox("szuk_wyr","szuk_wyr",1,$this->_szuk['szuk_wyr']);
			echo interfejs::label("szuk_wyr",konf::get()->langTexty("produkty_admin_szukwyr")."wyróżnione","",true);								
	    echo "</span> ";
		}				
		if(konf::get()->getKonfigTab("sklep_konf",'prod_promocja')){	
			echo "<span class=\"nobr\">";
			echo $form->checkbox("szuk_promocja","szuk_promocja",1,$this->_szuk['szuk_promocja']);
			echo interfejs::label("szuk_promocja",konf::get()->langTexty("produkty_admin_szukpromocja")."promocja","",true);							
	    echo "</span> ";
		}					
		if(konf::get()->getKonfigTab("sklep_konf",'prod_polecamy')){	
			echo "<span class=\"nobr\">";
			echo $form->checkbox("szuk_polecamy","szuk_polecamy",1,$this->_szuk['szuk_polecamy']);
			echo interfejs::label("szuk_polecamy",konf::get()->langTexty("produkty_admin_szukpolecamy")."polecamy","",true);					
	    echo "</span> ";
		}		
		if(konf::get()->getKonfigTab("sklep_konf",'prod_wyprzedaz')){	
			echo "<span class=\"nobr\">";
			echo $form->checkbox("szuk_wyprzedaz","szuk_wyprzedaz",1,$this->_szuk['szuk_wyprzedaz']);
			echo interfejs::label("szuk_wyprzedaz",konf::get()->langTexty("produkty_admin_szukwyprzedaz")."wyprzedaż","",true);							
	    echo "</span> ";
		}					
		if(konf::get()->getKonfigTab("sklep_konf",'prod_priorytet')){	
			echo "<span class=\"nobr\">";
			echo $form->checkbox("szuk_priorytet","szuk_priorytet",1,$this->_szuk['szuk_priorytet']);
			echo interfejs::label("szuk_priorytet",konf::get()->langTexty("produkty_admin_szukpriorytet")."priorytet","",true);								
	    echo "</span> ";
		}									
		echo "</div>";
		
		echo $form2->getFormk();
		
		echo "</td></tr>";	
		echo tab_stop();		
 
	}
	
  /**
   * get producenci
	 * @return array
   */			
	private function pobierzProducenci(){
	
		$dane_tab=array();
		
		$producenci_dane=konf::get()->_bazasql->pobierzRekordy("SELECT nazwa,id FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_producenci')." WHERE lang='".konf::get()->getLang()."' ORDER BY nazwa, id ","id");

		while(list($key,$dane)=each($producenci_dane)){
			$dane_tab[$key]=$dane['nazwa'];
		}
		
		return $dane_tab;
	
	}
	
	
  /**
   * get categories
	 * @return array
   */			
	private function pobierzKategorie(){
	
		$dane_tab=array();
		$kategorie_dane=array();
				
		$zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." ORDER BY id_d, poziom, id_matka, nr_poz, id ");
		
    while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
      $kategorie_dane[$dane['id_matka']][$dane['id']]=$dane;
    }
    konf::get()->_bazasql->freeResult($zap);
										
		if(!empty($kategorie_dane[0])){
		
			$dane_tab=$this->pobierzPodkategorieK($kategorie_dane,0,1,$dane_tab);
			
		}

		return $dane_tab;
		
	}
	
	
	private function pobierzPodkategorieK($tab,$key,$poziom,$dane_tab){
	
		//jesli jest poziom
		if(!empty($tab[$key])&&is_array($tab[$key])){

	    reset($tab[$key]);		
			//to przelatujemy poziom
	    while(list($key2,$dane)=each($tab[$key])){

				$dane_tab[$dane['id_d']][$key2]=str_repeat("-",$dane['poziom'])." &raquo; ".$dane['tytul'];			
				$dane_tab=$this->pobierzPodkategorieK($tab,$key2,$poziom+1,$dane_tab);

			}		
		}	
		
		return $dane_tab;
	
	}	

  /**
   * check data exists
   * @param string $nazwa
   * @param int $id_kat
   * @param int $id_producent				
   * @param float $cena		
   * @param int $id
	 * @return bool	
   */		
	protected function istnieje($nazwa,$id_kat,$id_producent,$cena,$id=""){

		$ok=true;

		$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." WHERE nazwa='".$nazwa."' AND id_kat='".$id_kat."' AND id_producent='".$id_producent."' AND cena='".$cena."' AND lang='".konf::get()->getLang()."'";
		if(!empty($id)){
			$query.=" AND id!='".$id."'";
		}
		
		if(konf::get()->_bazasql->policz("id",$query)>0){
			$ok=false;
		}
		
		return $ok;	
		
	}


  /**
   * save img
   * @param array $dane
   * @param int $id_nr
   * @return obj							
   */		
	private function grafikaZapis($dane,$id_nr){

		$img_usun=tekstForm::doSql(konf::get()->getZmienna('img_usun'));		
		require_once(konf::get()->getKonfigTab('klasy')."class.zapiszgrafike.php");
		
		$grafika=new zapiszGrafike($id_nr,konf::get()->getKonfigTab("sklep_konf",'produkty_kat'),"pic","img",$dane);
		$grafika->setWszystkie(true);
		$grafika->setImgUsun($img_usun);
		
		$grafika->setDaneImg(1,array(
			"hmax"=>konf::get()->getKonfigTab("sklep_konf",'produkt_img_size'),
			"wmax"=>konf::get()->getKonfigTab("sklep_konf",'produkt_img_size'),
			"hmin"=>konf::get()->getKonfigTab("sklep_konf",'produkt_img_min_size'),
			"wmin"=>konf::get()->getKonfigTab("sklep_konf",'produkt_img_min_size'),
			"typy"=>array(2=>2),
			"skala"=>3					
		));
		
		$grafika->setDaneImg(2,array(
			"hmax"=>konf::get()->getKonfigTab("sklep_konf",'produkt_img_m2_size'),
			"wmax"=>konf::get()->getKonfigTab("sklep_konf",'produkt_img_m2_size'),
			"hmin"=>konf::get()->getKonfigTab("sklep_konf",'produkt_img_min_size'),
			"wmin"=>konf::get()->getKonfigTab("sklep_konf",'produkt_img_min_size'),
			"typy"=>array(2=>2),
			"skala"=>konf::get()->getKonfigTab("sklep_konf",'produkt_img2_skala')					
		));				
		
		$grafika->setDaneImg(3,array(
			"hmax"=>konf::get()->getKonfigTab("sklep_konf",'produkt_img_m_size'),
			"wmax"=>konf::get()->getKonfigTab("sklep_konf",'produkt_img_m_size'),
			"hmin"=>konf::get()->getKonfigTab("sklep_konf",'produkt_img_min_size'),
			"wmin"=>konf::get()->getKonfigTab("sklep_konf",'produkt_img_min_size'),
			"typy"=>array(2=>2),
			"skala"=>konf::get()->getKonfigTab("sklep_konf",'produkt_img_skala')					
		));			

		$grafika->wykonaj();	
		
		return $grafika;		
	
	}	

	/**
   * sklep save
   */		
	protected function zapisz(){

		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr',"id_nr"));		
		$img_usun=tekstForm::doSql(konf::get()->getZmienna('img_usun'));			
		$dost_tab=konf::get()->getKonfigTab("sklep_konf",'dostepnosc_tab');						
		
		$dane=array(
			"id_kat"=>$this->_szuk['id_kat'],
			"id_producent"=>$this->_szuk['szuk_producent'],			
			"nazwa"=>"",
			"symbol"=>"",
			"data_start"=>"",
			"data_stop"=>"",			
			"nazwa_menu"=>"",
			"zajawka"=>"",
			"status"=>1,
			"opis"=>"",
			"link"=>"",					
			"cena"=>"",						
			"cena_skreslona"=>"",		
			"cena_promo"=>"",										
			"waga"=>"",		
			"dostepnosc"=>"",			
			"dostepnosc_sztuk"=>"",										
		);
		
		//testowanie danych z formularza
		
		$testy[]=array("zmienna"=>"status","test"=>"truefalse",
			"param"=>array(
				"wartosc"=>1
			)
		);

		$testy[]=array("zmienna"=>"nazwa","test"=>"wartosc","wymagany"=>true,
			"param"=>array(
				"komunikat"=>konf::get()->langTexty("produkty_admin_arch_nieprawidlowe")."Nieprawidłowa nazwa producenta",
				'idtf'=>"nazwa"			
			)	
		);	
		
		$testy[]=array("zmienna"=>"id_kat","test"=>"wartosc","wymagany"=>true,
			"param"=>array(
				"komunikat"=>konf::get()->langTexty("produkty_admin_arch_nieprawidlowek")."Nieprawidłowa kategoria",
				'idtf'=>"id_kat"			
			)	
		);		
			
		$testy[]=array("zmienna"=>"cena","test"=>"wartosc","wymagany"=>true,
			"param"=>array(
				"komunikat"=>konf::get()->langTexty("produkty_admin_arch_nieprawidlowacena")."Nieprawidłowa cena",
				'idtf'=>"cena"			
			)	
		);		
				
		$testy[]=array("zmienna"=>"cena","test"=>"liczba",
			"param"=>array(
				"po_przecinku"=>2,
				"domyslny"=>0,
				"min"=>0,			
			)
		);	
				
		$testy[]=array("zmienna"=>"cena_promo","test"=>"liczba",
			"param"=>array(
				"po_przecinku"=>2,
				"domyslny"=>0,
				"min"=>0,			
			)
		);	
				
				
		$testy[]=array("zmienna"=>"cena_skreslona","test"=>"liczba",
			"param"=>array(
				"po_przecinku"=>2,
				"domyslny"=>0,
				"min"=>0,			
			)
		);	
				
				
		$testy[]=array("zmienna"=>"dostepnosc_sztuk","test"=>"liczba",
			"param"=>array(
				"domyslny"=>0,
				"min"=>0,			
			)
		);	
																
		$testy[]=array("zmienna"=>"dostepnosc","test"=>"wtablicyi",
			"param"=>array(
				"wartosci"=>$dost_tab,
				"domyslny"=>0
			)
		);	
					
		$daneNieczysc[]="opis";		
		$daneNieczysc[]="zajawka";	
		
		//generator zapytania insert/update
		require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
		$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'sklep_produkty'),$dane,$daneNieczysc);
		$sqldane->daneOdczyt();	
		$sqldane->setAutor(true);	
		$sqldane->setTesty($testy);
		
		$sqldane->testuj();	
		
		if($sqldane->ok()){
		
			if(!empty($id_nr)){
			
				$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." WHERE id='".$id_nr."'");

				if(empty($dane)){
					$id_nr="";
				}	
					
			}	else {
				$id_nr="";				
			}				
		
			if($this->istnieje($sqldane->getDane('nazwa'),$sqldane->getDane('id_kat'),$sqldane->getDane('id_producent'),$sqldane->getDane('cena'),$id_nr)){
					
				// dodawanie 
				if(empty($id_nr)){
				
					//dodaj dane zo zapytania
				 	$sqldane->setDane(array(
						"lang"=>konf::get()->getLang(),
					));		
					
					//budowanie zapytania
					$sqldane->dodajDaneD();							
					
					//wykonujemy
					if($sqldane->getSql()){
						konf::get()->_bazasql->zap($sqldane->getSql());
						//wykonaj zapytanie
						$id_nr=konf::get()->_bazasql->insert_id;
						$sqldane->setId($id_nr);					
					}
								
					if(!empty($id_nr)){
					
						//wstawianie grafiki
				 		if(konf::get()->getKonfigTab("sklep_konf",'img')){

							$grafika=$this->grafikaZapis($dane,$id_nr);	
							if($grafika->getSql()){
								konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." SET ".$grafika->getSql()." WHERE id='".$id_nr."'");				
							}
																								  
						}						

						user::get()->zapiszLog(konf::get()->langTexty("produkty_admin_arch_sdodaj_log")."dodanie produktu ".$sqldane->getDane("nazwa"),user::get()->login());
						
					} else {
						konf::get()->setAkcja("produktyadmin_dodaj");	

					}
					
				} else {
				
					//budowanie zapytania
					$sqldane->dodajDaneE();			
					
					//wstawianie grafiki
			 		if(konf::get()->getKonfigTab("sklep_konf",'imgz')){

						$grafika=$this->grafikaZapis($dane,$id_nr);										
						if($grafika->getSql()){
							$sqldane->dodaj(", ".$grafika->getSql());				
						}
																							  
					}	
														
					$sqldane->dodaj(" WHERE id='".$id_nr."'");	
					
					//wykonaj zapytanie
					if($sqldane->getSql()){
						konf::get()->_bazasql->zap($sqldane->getSql());
					}				
					
			    user::get()->zapiszLog(konf::get()->langTexty("produkty_admin_arch_sedycja_log")."edycja produktu ".$sqldane->getDane("nazwa"),user::get()->login());

				}
				
				konf::get()->setZmienna("_post","id_nr",$id_nr);					

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
		
		
		if(konf::get()->getAkcja()=="produktyadmin_dodaj2"){
			if(!empty($id_nr)){
				konf::get()->setAkcja("produktyadmin_arch");				
			} else {
				konf::get()->setAkcja("produktyadmin_dodaj");				
			}
		} else if(konf::get()->getAkcja()=="produktyadmin_edytuj2"){	
			konf::get()->setAkcja("produktyadmin_edytuj");					
		} 
				

	}	

	private function produktMenu($id_nr,$dane,$link=""){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$sortuj=konf::get()->getZmienna('sortuj','sortuj');

		echo "<table border=\"0\"><tr>"; 
				
		if(!empty($id_nr)){
			echo interfejs::edytuj(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_edytuj","id_nr"=>$id_nr)).$link); 			
			echo interfejs::przyciskEl("folder_wrench",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_konfigedytuj","id_nr"=>$id_nr)).$link,konf::get()->langTexty("produkty_admin_arch_edytujk")."edytuj konfigurację");
			echo interfejs::podglad(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklep_produkt","id_produkt"=>$id_nr))); 			
			echo interfejs::infoEl($dane);		  
			echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_usun","id_tab[]"=>$dane['id'])).$link);
		}
		echo interfejs::przyciskEl("arrow_join",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_arch")).$link,konf::get()->langTexty("produkty_admin_powrot")."powrót do listy");

		echo "</tr></table>"; 	
	
	}
	
	/**
   * sklep form
   */		
	protected function formularz(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$sortuj=konf::get()->getZmienna('sortuj','sortuj');				
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));	
		$link=$this->szukZmienne(1)."&amp;podstrona=".$podstrona."&amp;sortuj=".$sortuj;								

		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"sklep","sklep");		
		
		//domyslne wartosci
		$dane=array(
			"id_kat"=>$this->_szuk['id_kat'],
			"id_producent"=>$this->_szuk['szuk_producent'],			
			"nazwa"=>"",
			"symbol"=>"",
			"data_start"=>"",
			"data_stop"=>"",			
			"nazwa_menu"=>"",
			"zajawka"=>"",
			"opis"=>"",
			"link"=>"",			
			"status"=>1,				
			"cena"=>"",						
			"cena_skreslona"=>"",		
			"cena_promo"=>"",										
			"waga"=>"",		
			"dostepnosc"=>"",			
			"dostepnosc_sztuk"=>"",										
		);
		
		$dane=$form->odczyt($dane);
		
		//dla edycji pobierz aktualne dane
		if(!empty($id_nr)){
			$dane2=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." WHERE id='".$id_nr."'");
			if(!empty($dane2)){
				$dane=$dane2;	
			} else {
				$id_nr="";
			}
		}

    //jesli wszystko ok to wyswietl formularz
    if(empty($id_nr)){
      echo tab_nagl(konf::get()->langTexty("produkty_admin_form_t")."Dodawanie produktu",1);  
    } else {
      echo tab_nagl(konf::get()->langTexty("produkty_admin_form_e")."Edycja produktu",1); 
    }

    echo "<tr><td valign=\"top\" class=\"tlo3\">";

		$this->produktMenu($id_nr,$dane,$link);
					
		echo "<br />";		
		
		echo $form->spr(array(1=>"nazwa",2=>"id_kat",3=>"cena"));
		$form->setMultipart(true);
		echo $form->getFormp();
		
		$przenies=$this->_szuk;
		$przenies['sortuj']=$sortuj;
		$przenies['podstrona']=$podstrona;
		$przenies['id_nr']=$id_nr;
		$przenies['akcja']=konf::get()->getAkcja()."2";
								
		echo $form->przenies($przenies);
		
    echo "<div>";
		echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");			
		echo "</div><br />";		
		
    //od kiedy wyswietlać
		echo $form->kalendarz("data_start","trigger_b",$dane['data_start'],true);
		echo interfejs::label("data_start",konf::get()->langTexty("produkty_admin_form_datastart")." data startu wyświetlania","grube",true);					
		echo "<br />";
        
    //do kiedy wyswietlać
		echo $form->kalendarz("data_stop","trigger_c",$dane['data_stop'],true,true);
		echo interfejs::label("data_stop",konf::get()->langTexty("produkty_admin_form_dataw")." data ważności, wyświetlaj do dnia","grube",true);							
		echo "<br /><br />";
			
		$kategorie_tab=$this->pobierzKategorie();		
		$d_tab=konf::get()->getKonfigTab("sklep_konf",'d_tab');		
		echo interfejs::label("id_kat",konf::get()->langTexty("produkty_admin_form_idkat")."kategoria*:","grube");		
    echo "<br />";		
		echo $form->select2("id_kat","id_kat",$d_tab,$kategorie_tab,$dane['id_kat'],"f_bdlugi",konf::get()->langTexty("produkty_admin_kategorie")."--wybierz kategorię--");
		echo "<br /><br />";
								
		$producenci_tab=$this->pobierzProducenci();		
		echo interfejs::label("id_producent",konf::get()->langTexty("produkty_admin_form_idproducent")."producent:","grube");					
    echo "<br />";				
		echo $form->select("id_producent","id_producent",$producenci_tab,$dane['id_producent'],"f_bdlugi",konf::get()->langTexty("produkty_admin_producenci")."--wybierz producenta--");
		echo "<br /><br />";
		
		if(konf::get()->getKonfigTab("sklep_konf",'prod_symbol')){	
			echo interfejs::label("symbol",konf::get()->langTexty("produkty_admin_form_symbol")."symbol produktu:","grube");								
	    echo "<br />";
			echo $form->input("text","symbol","symbol",$dane['symbol'],"f_dlugi",100);	
		 	echo "<br /><br />";				
		}				

		echo interfejs::label("nazwa",konf::get()->langTexty("produkty_admin_form_nazwa")."nazwa produktu*:","grube");				
    echo "<br />";
		echo $form->input("text","nazwa","nazwa",$dane['nazwa'],"f_bdlugi",250);	
	 	echo "<br /><br />";
		
		echo interfejs::label("nazwa_menu",konf::get()->langTexty("produkty_admin_form_nazwam")."nazwa zastępcza do listy produktów:","grube");						
    echo "<br />";
		echo $form->input("text","nazwa_menu","nazwa_menu",$dane['nazwa_menu'],"f_bdlugi",250);	
	 	echo "<br /><br />";		
		
		
		echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";	
		
		echo "<tr class=\"lewa\">";
		
		echo "<td>";		
		echo interfejs::label("cena",konf::get()->langTexty("produkty_admin_form_cena")."cena produktu*:","grube");				
	 	echo "</td>";					
		
		echo "<td style=\"padding-left:10px;\">";
		echo interfejs::label("cena_skreslona",konf::get()->langTexty("produkty_admin_form_cena_skreslona")."cena skreślona:","grube");		
	 	echo "</td>";		

		if(konf::get()->getKonfigTab("sklep_konf",'prod_cenapromo')){		
			echo "<td style=\"padding-left:10px;\">";
			echo interfejs::label("cena_promo",konf::get()->langTexty("produkty_admin_form_cena_promo")."cena promocyjna dla wybranych klientów:","grube");	
		 	echo "</td>";	
		}

		echo "</tr>";
		
		echo "<tr class=\"lewa\">";
		
		echo "<td>";		
		$dane['cena']=tekstForm::niepuste($dane['cena']);		
		echo $form->input("text","cena","cena",$dane['cena'],"f_sredni prawa",12);	
	 	echo "</td>";			
		
		echo "<td style=\"padding-left:10px;\">";
		$dane['cena_skreslona']=tekstForm::niepuste($dane['cena_skreslona']);		
		echo $form->input("text","cena_skreslona","cena_skreslona",$dane['cena_skreslona'],"f_sredni prawa",12);	
	 	echo "</td>";		

		if(konf::get()->getKonfigTab("sklep_konf",'prod_cenapromo')){		
			echo "<td style=\"padding-left:10px;\">";
			$dane['cena_promo']=tekstForm::niepuste($dane['cena_promo']);
			echo $form->input("text","cena_promo","cena_promo",$dane['cena_promo'],"f_sredni prawa",12);	
		 	echo "</td>";	
		}

		echo "</tr>";		
		
		echo "</table><br />";

		if(konf::get()->getKonfigTab("sklep_konf",'prod_waga')){	
			$dane['waga']=tekstForm::niepuste($dane['waga']);	
			echo interfejs::label("waga",konf::get()->langTexty("produkty_admin_form_waga")."waga jednostkowa produktu:","grube");						
	    echo "<br />";
			echo $form->input("text","waga","waga",$dane['waga'],"f_sredni prawa",12);	
		 	echo "<br /><br />";				
		}		

		if(konf::get()->getKonfigTab("sklep_konf",'prod_dostepnosc')||konf::get()->getKonfigTab("sklep_konf",'prod_dostepnosc_sztuk')){	
				
			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";				
			echo "<tr class=\"lewa\">";
				
			if(konf::get()->getKonfigTab("sklep_konf",'prod_dostepnosc')){			
				
				echo "<td style=\"padding-right:10px;\">";	
				echo interfejs::label("dostepnosc",konf::get()->langTexty("produkty_admin_form_dostepnosc")."dostępność produktu:","grube");																
		    echo "<br />";
				echo "</td>";						
				
			}
			
			if(konf::get()->getKonfigTab("sklep_konf",'prod_dostepnosc_sztuk')){			
				
				echo "<td style=\"padding-right:10px;\">";		
				echo interfejs::label("dostepnosc_sztuk",konf::get()->langTexty("produkty_admin_form_dostepnosc_sztuk")." dostępnych sztuk produktu:","grube");											
		    echo "<br />";
			 	echo "</td>";					
				
			}		
			
			echo "</tr>";		
			
			echo "<tr>";			
			if(konf::get()->getKonfigTab("sklep_konf",'prod_dostepnosc')){			
				
				echo "<td style=\"padding-right:10px;\">";									
				$dost_tab=konf::get()->getKonfigTab("sklep_konf",'dostepnosc_tab');		
				echo $form->select("dostepnosc","dostepnosc",$dost_tab,$dane['dostepnosc'],"f_dlugi",konf::get()->langTexty("wybierz"));
				echo "</td>";						
				
			}
			
			if(konf::get()->getKonfigTab("sklep_konf",'prod_dostepnosc_sztuk')){			
				
				echo "<td style=\"padding-right:10px;\">";				
				$dane['dostepnosc_sztuk']=tekstForm::niepuste($dane['dostepnosc_sztuk']);	
				echo $form->input("text","dostepnosc_sztuk","dostepnosc_sztuk",$dane['dostepnosc_sztuk'],"f_sredni prawa",10);	
			 	echo "</td>";					
				
			}		
			
			echo "</tr>";								
			echo "</table><br />";	
		
		}			
						
		echo interfejs::label("link",konf::get()->langTexty("produkty_admin_form_link")."strona WWW produktu:","grube");
    echo "<br />";
		echo $form->input("text","link","link",$dane['link'],"f_bdlugi",250);	
	 	echo "<br /><br />";				
		
		echo interfejs::label("zajawka",konf::get()->langTexty("produkty_admin_form_zajawka")."opis skrócony produktu:","grube");				
    echo "<br />";		
		$form->fck("zajawka",$dane['zajawka'],150,"Simple");	
	 	echo "<br /><br />";							

		echo interfejs::label("opis",konf::get()->langTexty("produkty_admin_form_opis")."opis produktu:","grube");					
    echo "<br />";		
		$form->fck("opis",$dane['opis'],450);			
						
		//sekcja dotyczaca uploadu grafiki
		if(konf::get()->getKonfigTab("sklep_konf",'produkt_img')){
		
      //zajawka
 	    echo "<br /><br />";
			echo interfejs::label("pic",konf::get()->langTexty("produkty_admin_form_obrazek")."zdjęcie produktu:","grube blok");				
			echo "<br />";	
					
  		if(!empty($dane['img'])){
			
				echo interfejs::imgPodglad($dane,"img",konf::get()->getKonfigTab("sklep_konf",'produkty_kat'),3);	

  			echo "<div class=\"nobr\">";
				echo $form->checkbox("img_usun","img_usun",1,"");	
				echo interfejs::label("img_usun",konf::get()->langTexty("usung"),"",true);
				echo "</div>"; 
				
  		}
			
  	  echo konf::get()->langTexty("produkty_admin_form_grafika")."wybierz zdjęcie:";
			echo interfejs::pomocEl(konf::get()->langTexty("produkty_admin_form_himg")."Plik JPG spełniający wymagania co do rozmiarów. Uwaga, pliki JPG w palecie kolorów CMYK są odrzucane. Strony WWW obsługują wyłącznie paletę RGB");
			echo "<div>";
			echo $form->input("file","pic","pic","","f_bdlugi");
			echo "</div><br />";

		}			

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
      
		echo "<tr class=\"srodek\"><td class=\"tlo4\">".interfejs::linkEl("basket",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_arch","sortuj"=>$sortuj,"podstrona"=>$podstrona)).$link,konf::get()->langTexty("produkty_admin_form_listas")."Powrót na listę produktów")."</td></tr>";
		
    echo tab_stop();

	}
	
	/**
   * sklep remove
   */		
	public function usun(){
	
		$this->usunRekordy(konf::get()->getKonfigTab("sql_tab",'sklep_produkty'),konf::get()->getKonfigTab("sklep_konf",'produkty_kat'),3,"img",konf::get()->langTexty("produkty_admin_a_usuwanie_log")."produkty - usuwanie");
	 
	}

	
  /**
   * set active
   */			
	public function aktyw(){
	
		$this->zmienparam("status",1,konf::get()->getKonfigTab("sql_tab",'sklep_produkty'),konf::get()->langTexty("produkty_admin_a_param_log")."produkty - zmiana statusu");
		
	}
	
	
  /**
   * set deactive
   */		
	public function deaktyw(){
	
		$this->zmienparam("status",0,konf::get()->getKonfigTab("sql_tab",'sklep_produkty'),konf::get()->langTexty("produkty_admin_a_param_log")."produkty - zmiana statusu");
		
	}	
	
  /**
   * set 
   */			
	public function nowosc(){

		if(konf::get()->getKonfigTab("sklep_konf",'prod_nowosc')){		
			$this->zmienparam("nowosc",1,konf::get()->getKonfigTab("sql_tab",'sklep_produkty'),konf::get()->langTexty("produkty_admin_a_param_log")."produkty - zmiana statusu");
		}
		
	}
		
  /**
   * set 
   */			
	public function denowosc(){

		if(konf::get()->getKonfigTab("sklep_konf",'prod_nowosc')){		
			$this->zmienparam("nowosc",0,konf::get()->getKonfigTab("sql_tab",'sklep_produkty'),konf::get()->langTexty("produkty_admin_a_param_log")."produkty - zmiana statusu");
		}
		
	}	
	
  /**
   * set 
   */			
	public function wyr(){

		if(konf::get()->getKonfigTab("sklep_konf",'prod_wyr')){		
			$this->zmienparam("wyr",1,konf::get()->getKonfigTab("sql_tab",'sklep_produkty'),konf::get()->langTexty("produkty_admin_a_param_log")."produkty - zmiana statusu");
		}
		
	}
		
  /**
   * set 
   */			
	public function dewyr(){

		if(konf::get()->getKonfigTab("sklep_konf",'prod_wyr')){		
			$this->zmienparam("wyr",0,konf::get()->getKonfigTab("sql_tab",'sklep_produkty'),konf::get()->langTexty("produkty_admin_a_param_log")."produkty - zmiana statusu");
		}
		
	}	
		
  /**
   * set 
   */			
	public function promocja(){

		if(konf::get()->getKonfigTab("sklep_konf",'prod_promocja')){		
			$this->zmienparam("promocja",1,konf::get()->getKonfigTab("sql_tab",'sklep_produkty'),konf::get()->langTexty("produkty_admin_a_param_log")."produkty - zmiana statusu");
		}
		
	}
		
  /**
   * set 
   */			
	public function depromocja(){

		if(konf::get()->getKonfigTab("sklep_konf",'prod_promocja')){		
			$this->zmienparam("promocja",0,konf::get()->getKonfigTab("sql_tab",'sklep_produkty'),konf::get()->langTexty("produkty_admin_a_param_log")."produkty - zmiana statusu");
		}
		
	}			
	
  /**
   * set 
   */			
	public function polecamy(){

		if(konf::get()->getKonfigTab("sklep_konf",'prod_polecamy')){		
			$this->zmienparam("polecamy",1,konf::get()->getKonfigTab("sql_tab",'sklep_produkty'),konf::get()->langTexty("produkty_admin_a_param_log")."produkty - zmiana statusu");
		}
		
	}
		
  /**
   * set 
   */			
	public function depolecamy(){

		if(konf::get()->getKonfigTab("sklep_konf",'prod_polecamy')){		
			$this->zmienparam("polecamy",0,konf::get()->getKonfigTab("sql_tab",'sklep_produkty'),konf::get()->langTexty("produkty_admin_a_param_log")."produkty - zmiana statusu");
		}
		
	}		
	
  /**
   * set 
   */			
	public function wyprzedaz(){

		if(konf::get()->getKonfigTab("sklep_konf",'prod_wyprzedaz')){		
			$this->zmienparam("wyprzedaz",1,konf::get()->getKonfigTab("sql_tab",'sklep_produkty'),konf::get()->langTexty("produkty_admin_a_param_log")."produkty - zmiana statusu");
		}
		
	}
		
  /**
   * set 
   */			
	public function dewyprzedaz(){

		if(konf::get()->getKonfigTab("sklep_konf",'prod_wyprzedaz')){		
			$this->zmienparam("wyprzedaz",0,konf::get()->getKonfigTab("sql_tab",'sklep_produkty'),konf::get()->langTexty("produkty_admin_a_param_log")."produkty - zmiana statusu");
		}
		
	}		


	/**
   * konfig form
   */		
	public function konfigedytuj(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$sortuj=konf::get()->getZmienna('sortuj','sortuj');				
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));	
		$link=$this->szukZmienne(1)."&amp;podstrona=".$podstrona."&amp;sortuj=".$sortuj;		
		
		//domyslne wartosci
		$dane=array(
			"idtf_link"=>"",
			"description"=>"",
			"keywords"=>"",
			"title"=>"",
			"nowosc"=>"",			
			"promocja"=>"",			
			"wyprzedaz"=>"",			
			"polecamy"=>"",		
			"niebestsellery"=>"",					
			"wyr"	=>"",
		);

		//dla edycji pobierz aktualne dane
		$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." WHERE id='".$id_nr."'");
		
		if(!empty($dane)){

			$this->sciezka();
			
	    //jesli wszystko ok to wyswietl formularz  
	    echo tab_nagl(konf::get()->langTexty("produkty_admin_konfig_form")."Konfiguracja produktu",1); 

	    echo "<tr><td valign=\"top\" class=\"tlo3\">";
			
	    echo "<div class=\"grube\">".$dane['nazwa']."</div>";		
			
			$this->produktMenu($id_nr,$dane,$link);
					
			echo "<br />";

			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"sklep","sklep");
			$form->setMultipart(false);			
			echo $form->getFormp();
			
			$przenies=$this->_szuk;
			$przenies['sortuj']=$sortuj;
			$przenies['podstrona']=$podstrona;
			$przenies['id_nr']=$id_nr;
			$przenies['akcja']=konf::get()->getAkcja()."2";		
			
			echo $form->przenies($przenies);
			
	    echo "<div>";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");
			echo "</div><br />";						
			
			if(konf::get()->getKonfigTab("sklep_konf",'prod_nowosc')){	
				echo $form->checkbox("nowosc","nowosc",1,$dane['nowosc']);
				echo interfejs::label("nowosc",konf::get()->langTexty("produkty_admin_konfnowosc")."oznacz jako nowość","nobr",true);							
				echo "<br /><br />";
			}		
			if(konf::get()->getKonfigTab("sklep_konf",'prod_wyr')){	
				echo $form->checkbox("wyr","wyr",1,$dane['wyr']);
				echo interfejs::label("wyr",konf::get()->langTexty("produkty_admin_konfwyr")."oznacz jako wyróżnione","nobr",true);							
				echo "<br /><br />";						
			}				
			if(konf::get()->getKonfigTab("sklep_konf",'prod_promocja')){	
				echo $form->checkbox("promocja","promocja",1,$dane['promocja']);
				echo interfejs::label("promocja",konf::get()->langTexty("produkty_admin_konfpromocja")."oznacz jako promocja","nobr",true);	
				echo "<br /><br />";				
			}					
			if(konf::get()->getKonfigTab("sklep_konf",'prod_polecamy')){	
				echo "<span class=\"nobr\">";
				echo $form->checkbox("polecamy","polecamy",1,$dane['polecamy']);
				echo interfejs::label("polecamy",konf::get()->langTexty("produkty_admin_konfpolecamy")."oznacz jako polecamy","nobr",true);						
				echo "<br /><br />";				
			}		
			if(konf::get()->getKonfigTab("sklep_konf",'prod_wyprzedaz')){	
				echo $form->checkbox("wyprzedaz","wyprzedaz",1,$dane['wyprzedaz']);
				echo interfejs::label("wyprzedaz",konf::get()->langTexty("produkty_admin_konfwyprzedaz")."oznacz jako wyprzedaż","nobr",true);		
				echo "<br /><br />";				
			}			
			
			if(konf::get()->getKonfigTab("sklep_konf",'prod_bestsellery')){	
				echo $form->checkbox("niebestsellery","niebestsellery",1,$dane['niebestsellery']);
				echo interfejs::label("niebestsellery",konf::get()->langTexty("produkty_admin_konfwyprzedaz")."nie pokazuj w bestsellerach","nobr",true);		
				echo "<br /><br />";				
			}								
			
			if(konf::get()->getKonfigTab("sklep_konf",'prod_priorytet')){	
				echo "<span class=\"nobr\">";
				echo "<select name=\"priorytet\" id=\"priorytet\" class=\"f_sredni\">";
				echo "<option value=\"\">".konf::get()->langTexty("produkty_admin_konf_brak")."--brak--</option>";
				$priorytet_max=konf::get()->getKonfigTab("sklep_konf",'prod_priorytet');
				for($i=1;$i<=$priorytet_max;$i++){
					echo "<option value=\"".$i."\"";
					if($dane['priorytet']==$i){
						echo " selected=\"selected\"";
					}
					echo ">".$i;
					if($i==1){
						echo konf::get()->langTexty("produktyadmin_konf_najwyzszy")."najwyższy";
					}			
					if($i==$priorytet_max){
						echo konf::get()->langTexty("produktyadmin_konf_najnizszy")."najniższy";
					}
					echo "</option>";
				}
				echo "</select> ";
				echo interfejs::label("priorytet",konf::get()->langTexty("produkty_admin_konfpriorytet")."priorytet w wynikach wyszukiwania","nobr",true);						
				echo interfejs::pomocEl(konf::get()->langTexty("produkty_admin_konfprioryteth")."Wartość priorytetu wpływa na kolejność produktów. Im wyższy priorytet tym produkt wyżej na liście bez względu n ille parametry sortowania");		
		    echo "</span>";
				echo "<br /><br />";				
			}					
					
		  echo "<div>";
			echo interfejs::label("idtf_link",konf::get()->langTexty("produkty_admin_form_idtflink")."identyfikator elementu w postaci przyjaznej dla wyszukiwarek","grube");	
			echo interfejs::pomocEl(konf::get()->langTexty("produktyadmin_konf_form_hidtflink")."Pozwala tworzyć do kategorii link w formie przyjaznej dla wyszukiwarek, zawierający słowa kluczowe lub znaczące frazy. Uwaga - identyfikator nie moze zawierać znaków specjalnych, narodowych a znak spacji należy zastąpić podkreśleniem lub myślnikiem");
			echo "</div>";
			echo $form->input("text","idtf_link","idtf_link",$dane['idtf_link'],"f_bdlugi",100);
			echo "<br /><br />";
						
			echo "<div>";
			echo interfejs::label("description",konf::get()->langTexty("produktyadmin_konf_form_description")."opis podstrony (description) dla wyszukiwarek","grube");			
			echo interfejs::pomocEl(konf::get()->langTexty("produktyadmin_konf_form_hdescription")."Krótki (2-3 zdania) opis podstrony strony dla wyszukiwarek. Jeśli pusty to zastosowany będzie domyślny opis z konfiguracji.");
			echo "</div>";
			echo $form->textarea("description","description",$dane['description'],"f_bdlugi",5);	
			echo "<br />";
			echo $form->skrocTxt("description",250);
			echo "<br />";
			
			echo "<div>";
	
			echo interfejs::label("keywords",konf::get()->langTexty("produktyadmin_konf_form_keywords")."słowa kluczowe (keywords) dla wyszukiwarek","grube");			
			echo interfejs::pomocEl(konf::get()->langTexty("produktyadmin_konf_form_hkeywords")."Grupa wybranych słów - haseł, fraz oddzielonych przecinkami charakteryzujących serwis www. Nie więcej niz 20-30 haseł. Jeśli puste to zastosowany będzie domyślny zestaw słów z konfiguracji.");
			echo "</div>";
			echo $form->textarea("keywords","keywords",$dane['keywords'],"f_bdlugi",5);	
			echo "<br />";
			echo $form->skrocTxt("keywords",250);
			echo "<br />";
			
		  echo "<div>";
			echo interfejs::label("title",konf::get()->langTexty("produktyadmin_konf_form_title")."title dla wyszukiwarek","grube");			
			echo "</div>";
			echo $form->input("text","title","title",$dane['title'],"f_bdlugi",200);
			echo "<br /><br />";			
										
	    echo "<div>";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");
			echo "</div>";
	    
			echo $form->getFormk();
			
			echo "</td></tr>";
	      
			echo "<tr class=\"srodek\"><td class=\"tlo4\">".interfejs::linkEl("basket",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_arch","sortuj"=>$sortuj,"podstrona"=>$podstrona)).$link,konf::get()->langTexty("produkty_admin_form_listas")."Powrót na listę produktów")."</td></tr>";

	    echo tab_stop();
			
	  } else {
			echo interfejs::nieprawidlowe();
	  }
		
	}	
	
	

	/**
   * sklep konfig edit
   */		
	public function konfigedytuj2(){

		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr'));	

		//dane podstawowe z formularza
		$dane=array(
			"idtf_link"=>"",
			"description"=>"",
			"keywords"=>"",
			"title"=>"",
			"nowosc"=>"",			
			"promocja"=>"",			
			"wyprzedaz"=>"",			
			"polecamy"=>"",		
			"niebestsellery"=>"",					
			"wyr"	=>"",
		);
		$daneNieczysc=array();

		$testy[]=array("zmienna"=>"description","test"=>"usunwiersz");	
		$testy[]=array("zmienna"=>"keywords","test"=>"usunwiersz");			
		$testy[]=array("zmienna"=>"idtf_link","test"=>"oczysc",
			"param"=>array(
				"znak"=>"-"
			)	
		);	
		
		$testy[]=array("zmienna"=>"priorytet","test"=>"liczba",
			"param"=>array(
				"domyslny"=>0,
				"min"=>0,
				"max"=>konf::get()->getKonfigTab("sklep_konf",'prod_priorytet'),						
			)
		);	
		
		$testy[]=array("zmienna"=>"nowosc","test"=>"truefalse",
			"param"=>array(
				"wartosc"=>1
			)
		);	
						
		$testy[]=array("zmienna"=>"promocja","test"=>"truefalse",
			"param"=>array(
				"wartosc"=>1
			)
		);		
		
		$testy[]=array("zmienna"=>"wyprzedaz","test"=>"truefalse",
			"param"=>array(
				"wartosc"=>1
			)
		);		
					
		$testy[]=array("zmienna"=>"polecamy","test"=>"truefalse",
			"param"=>array(
				"wartosc"=>1
			)
		);
		
		$testy[]=array("zmienna"=>"wyr","test"=>"truefalse",
			"param"=>array(
				"wartosc"=>1
			)
		);	
		
		$testy[]=array("zmienna"=>"niebestsellery","test"=>"truefalse",
			"param"=>array(
				"wartosc"=>1
			)
		);				
							
		//sprawdzamy strone nadrzedna zeby ustalic poziom w strukturze	
		if(!empty($id_nr)){
			$daneodczyt=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." WHERE id='".$id_nr."'");		
		}
		
		//pobieramy aktualne dane 
		if(!empty($daneodczyt)){
		
			//generator zapytania insert/update
			require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
			$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'sklep_produkty'),$dane,$daneNieczysc);
			$sqldane->daneOdczyt();	
			$sqldane->setAutor(true);	
			$sqldane->setTesty($testy);			
			$sqldane->dodajDaneE();						

			$sqldane->dodaj(" WHERE id='".$id_nr."'");	
			
			//wykonaj zapytanie
			if($sqldane->getSql()){
			
				konf::get()->_bazasql->zap($sqldane->getSql());
			  user::get()->zapiszLog(konf::get()->langTexty("produktyadmin_sedycja_log")."edycja produktu ".$daneodczyt['nazwa'],user::get()->login());
				konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");

			} else { 
				konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
			}
			
		} else { 
			konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
		}

	}		
	
  /**
   * galeria menu
   * @param array $dane
   */		
	public function galeriaMenu($dane){

		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_akapit"=>$dane['id_matka'],"id_d"=>$this->id_d));

		echo "<table border=\"0\" style=\"margin-top:5px\"><tr>";    
    echo interfejs::edytuj($link."&amp;akcja=produktyadmin_galeriaedytuj&amp;id_nr=".$dane['id']);  
    echo interfejs::przyciskEl("folder_wrench",$link."&amp;akcja=produktyadmin_galeriakonfigedytuj&amp;id_nr=".$dane['id'],konf::get()->langTexty("sklep_galeria_edytujk")); 
	  echo interfejs::przyciskEl("picture",$link."&amp;akcja=produktyadmin_galeria&amp;id_akapit=".$dane['id_matka'],konf::get()->langTexty("sklep_akapity_galeria")); 		
		echo interfejs::infoEl($dane);		
		echo interfejs::usun($link."&amp;akcja=produktyadmin_galeriausun&amp;id_tab[1]=".$dane['id']);
		echo "</tr></table>";  		
	
	}	

	
	/**
   * akapity poz
   */		
	public function galeriapoz(){

	  $typ=konf::get()->getZmienna('typ','typ');
	  $id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));	

		if(!empty($typ)&&!empty($id_nr)){			
		
		  $dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab","sklep_galeria")." WHERE id='".$id_nr."'");
		      	
		  if(!empty($dane)){
			
			  require_once(konf::get()->getKonfigTab("klasy")."class.zmienpoz.php");

				$poz=new zmienPoz($dane['id'],$typ,konf::get()->getKonfigTab("sql_tab","sklep_galeria"));		
				$poz->setMatka($dane['id_matka']);	
				$poz->setPoleMatka("id_matka");				
				$poz->setPoleId("id");
				$poz->setPolePoz("nr_poz");			
				$poz->setPoz($dane['nr_poz']);						
				$poz->wykonaj();				
					
			} else {
				konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),""); 
			}

		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),""); 
		}
		
	}	
	
	
  /**
   * change parameter
   * @param string $param
   * @param string $wartosc
   */		
	private function galeriazmienparam($param,$wartosc){

		$id_tab=konf::get()->getZmienna('id_tab','id_tab');

		$wartosc=tekstForm::doSql($wartosc);
		$query=tekstForm::tabQuery($id_tab);
		
		if(!empty($query)){
			konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'sklep_galeria')." SET ".$param."='".$wartosc."' WHERE id IN ($query)");
			user::get()->zapiszLog(konf::get()->langTexty("sklep_admin_gal_param_log"),user::get()->login());
			konf::get()->setKomunikat(konf::get()->langTexty("awykonana"),""); 
		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),""); 
		}

	}
	
	
  /**
   * set active
   */			
	public function galeriaaktyw(){
		$this->galeriazmienparam("status",1);
	}
	
	
  /**
   * set deactive
   */		
	public function galeriadeaktyw(){
		$this->galeriazmienparam("status",0);
	}	
	
	
	/**
   * sklep akapity remove
   */		
	public function galeriausun(){

		$id_tab=konf::get()->getZmienna('id_tab','id_tab');

		$query="";
		
		if(!empty($id_tab)&&is_array($id_tab)){
	  
		  $query=tekstForm::tabQuery($id_tab);
		  
		  if(!empty($query)){
	
				$zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_galeria')." WHERE id IN (".$query.")");
				
				while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
					if(!empty($dane['img1_nazwa'])&&file_exists(konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("sklep_konf",'galeria_kat').$dane['img1_nazwa'])){
		  			unlink(konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("sklep_konf",'galeria_kat').$dane['img1_nazwa']); 
		  		}
					if(!empty($dane['img2_nazwa'])&&file_exists(konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("sklep_konf",'galeria_kat').$dane['img2_nazwa'])){
		  			unlink(konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("sklep_konf",'galeria_kat').$dane['img2_nazwa']); 
		  		}				
		  	}		
				
		  	konf::get()->_bazasql->freeResult($zap);	
				konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_galeria')." WHERE id IN (".$query.")");	
				
				user::get()->zapiszLog(konf::get()->langTexty("sklep_admin_galeria_usun_log"));									
				
			} else {
				konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),""); 
			}
		
			konf::get()->setKomunikat(konf::get()->langTexty("usuwanie"),""); 					
			
		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),""); 
		}
		
	}
	
	
	/**
   * galeria arch
   */		
	public function galeria(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');

		//sortowanie
		$sortuj=tekstForm::doSql(konf::get()->getZmienna('sortuj','sortuj'));

		//element nadrzedny
		$id_akapit=tekstForm::doSql(konf::get()->getZmienna('id_akapit','id_akapit'));
		
		if(!empty($id_akapit)){
			$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_akapity')." WHERE id='".$id_akapit."'");
			if(!empty($dane)){
				$id_kat=$dane['id_matka'];
			}
		}		
		
		//dzial od elementu nadrzednego
		if(!empty($id_kat)){
			$dane2=$this->pobierz($id_kat,true);
		}

		
		if(!empty($dane)&&!empty($dane2)){
		
			$this->id_d=$dane2['id_d'];
			konf::get()->setZmienna('_post','id_kat',$dane2['id']);		
			
			$colspan=5;
			
	    if(konf::get()->getKonfigTab("sklep_konf",'galeria_licznik')){
	      $colspan++;
	    }
			
	    if(konf::get()->getKonfigTab("sklep_konf",'galeria_punkty')){
	      $colspan+=2;
	    }			
	    
	    //pzygotowanie zapytania pobrania danych
	    $tab_sort=array(
				1=>"nr_poz", 2=>"nr_poz DESC", 
				5=>"tytul", 6=>"tytul DESC", 
				7=>"status", 8=>"status DESC", 
				9=>"licznik", 10=>"licznik DESC",
				11=>"punkty", 12=>"punkty DESC",									
				13=>"ilosc_glosow", 14=>"ilosc_glosow DESC",						
			);
			
	    if(empty($sortuj)||empty($tab_sort[$sortuj])){ 
				$sortuj=1; 
			}

	    $query=" FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_galeria')." WHERE id_matka='".$id_akapit."' "; 

			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"arch","arch");
						
			echo $form->spr(array(1=>"akcja"),"","ok=spr_akcjau(document.arch.akcja,'produktyadmin_galeriausun','".konf::get()->langTexty("czyusun")."');");
			echo $form->getFormp();
			echo $form->przenies(array(
				"sortuj"=>$sortuj,
				"id_akapit"=>$id_akapit,
				"id_d"=>$this->id_d,
				"podstrona"=>$podstrona
			));

	    //sciezki do linkow
	    $link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_galeria","id_akapit"=>$id_akapit, "id_d"=>$this->id_d));
	    $link4=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_d"=>$this->id_d, "id_kat"=>$dane2['id']));
	    $link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_d"=>$this->id_d, "id_akapit"=>$id_akapit,"sortuj"=>$sortuj,"podstrona"=>$podstrona));
	    $link3=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklep_zobacz"));
						
	    //nawigator;
			$this->sciezka();    
			
			$naw = new nawig("SELECT COUNT(id) AS ilosc".$query,$podstrona,konf::get()->getKonfigTab("sklep_konf",'galeria_na_str'));		
			$naw->naw($link."&amp;sortuj=".$sortuj);
			$podstrona=$naw->getPodstrona();			
	    
	    //naglowek
	    echo tab_nagl(konf::get()->langTexty("produktyadmin_galeria")." (".$naw->getIle()."):",$colspan);
			
	    echo "<tr><td class=\"tlo4 lewa\" colspan=\"".$colspan."\"><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"seta\"><tr valign=\"middle\">";
	    echo "<td>";
	    echo "<img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/folder1.gif\" width=\"17\" height=\"15\" alt=\"\" class=\"lewa\" style=\"margin-right:2px\" />";
	    echo "<span class=\"grube\">".$dane2['tytul']."</span>";
	    echo "</td>";
			
			echo "<td class=\"prawa\"><table border=\"0\" class=\"prawa\"><tr>";    

		  echo interfejs::edytuj($link4."&amp;akcja=produktyadmin_edytuj&amp;id_nr=".$dane2['id']);
		  echo interfejs::przyciskEl("folder_wrench",$link4."&amp;akcja=produktyadmin_konfigedytuj&amp;id_nr=".$dane2['id'],konf::get()->langTexty("sklep_admin_arch_edytujk")); 
	     if($dane2['typ']!=2){		
				echo interfejs::przyciskEl("page_edit",$link4."&amp;akcja=produktyadmin_&amp;id_nr=".$dane2['id'],konf::get()->langTexty("sklep_admin_edycjatresci"));	
			}							
	    echo interfejs::podglad($link3."&amp;id_kat=".$dane2['id']);
			echo interfejs::infoEl($dane2);
			 
	    //nawigacja o poziom wyzej

	   	if(!empty($dane2['id_matka'])){
				echo interfejs::przyciskEl("arrow_join",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_arch"))."&amp;id_kat=".$dane2['id_matka']."&amp;id_d=".$dane2['id_d'],konf::get()->langTexty("poziomdogory"));
	   	} else {
				echo interfejs::przyciskEl("arrow_join",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_arch"))."&amp;id_d=".$this->id_d,konf::get()->langTexty("poziomdogory"));
			}
			
		  echo "</tr></table></td>";			
			
	    echo "</tr></table></td></tr>";
			
	    echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 lewa\">";
			
	    //akcje  
			$akcje_tab['produktyadmin_galeriadodaj']=konf::get()->langTexty("adodaj");
			$akcje_tab['produktyadmin_galeriaaktyw']=konf::get()->langTexty("aaktyw");
			$akcje_tab['produktyadmin_galeriadeaktyw']=konf::get()->langTexty("adeaktyw");
			$akcje_tab['produktyadmin_galeriausun']=konf::get()->langTexty("ausun");

			echo $form->selectAkcja($akcje_tab);
			echo "</td></tr>";
	    			
	    //zaznaczanie checkboxow
	    if(!empty($ile)){
				echo "<tr><td colspan=\"".$colspan."\" class=\"tlo4 srodek nobr\">";		
				echo $form->zaod("id_tab");		
				echo "</td></tr>";		
	    }			
			
			if($naw->getNaw()){
				echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
			}	
	      
	    //sortowanie  po kolumnach
	    echo "<tr class=\"srodek\">";

			echo interfejs::sortEl($link."&amp;sortuj=",1,2,konf::get()->langTexty("produktyadmin_gal_nr"),$sortuj,70);			
			echo interfejs::sortEl($link."&amp;sortuj=",5,6,konf::get()->langTexty("produktyadmin_gal_zdjecie"),$sortuj);
			echo interfejs::sortEl(""."","","","&nbsp;","",200);			
			echo interfejs::sortEl("","","",konf::get()->langTexty("produktyadmin_gal_param"),"",120);					
			echo interfejs::sortEl($link."&amp;sortuj=",7,8,konf::get()->langTexty("produktyadmin_gal_status"),$sortuj,70);			
	    if(konf::get()->getKonfigTab("sklep_konf",'galeria_licznik')){
				echo interfejs::sortEl($link."&amp;sortuj=",9,10,konf::get()->langTexty("produktyadmin_gal_wys"),$sortuj,70);		
	    }
	    if(konf::get()->getKonfigTab("sklep_konf",'galeria_punkty')){
				echo interfejs::sortEl($link."&amp;sortuj=",11,12,konf::get()->langTexty("produktyadmin_gal_glosow"),$sortuj,70);		
				echo interfejs::sortEl($link."&amp;sortuj=",13,14,konf::get()->langTexty("produktyadmin_gal_ocen"),$sortuj,70);					
	    }			

	    echo "</tr>";

	    //pobieranie danych  
	    $query="SELECT * ".$query." ORDER BY ".$tab_sort[$sortuj].",id";
	    $query.=" LIMIT ".$naw->getStart().",".$naw->getIle();
					
	    $zap=konf::get()->_bazasql->zap($query);
	    $ile=konf::get()->_bazasql->numRows($zap);  
	    $i=0;
	    
	    while($dane3=konf::get()->_bazasql->fetchAssoc($zap)){
			
	      $i++;
	      echo "<tr><td class=\"tlo3 lewa\" colspan=\"".$colspan."\">";
				echo interfejs::wstaw($link2."&amp;akcja=produktyadmin_galeriadodaj&amp;id_nad=".$dane3['id']);			
				echo "</td></tr>";
				
	      echo "<tr class=\"srodek\">";
				
				echo "<td class=\"tlo4 srodek\">";
				echo $form->checkbox("id_tab[]","id_".$dane3['id'],$dane3['id'],"");	
	      echo "<div class=\"male\">".$dane3['nr_poz']."(".$dane3['id'].")</div>";					
	      echo "</td>";		
 
	      echo "<td class=\"tlo3 srodek\">";
				
				if(!empty($dane3['tytul'])){
			    echo "<div style=\"padding-bottom:5px;\"><a class=\"admin_link\" href=\"".$link2."&amp;akcja=produktyadmin_galeriaedytuj&amp;id_nr=".$dane3['id']."\">".$dane3['tytul']."</a></div>";
				}
				
				echo "<div>";
				echo "<a class=\"admin_link\" href=\"".$link2."&amp;akcja=produktyadmin_galeriaedytuj&amp;id_nr=".$dane3['id']."\">";
				if(!empty($dane3['img2_nazwa'])&&file_exists(konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("sklep_konf",'galeria_kat').$dane3['img2_nazwa'])){
	  			echo "<img src=\"".konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("sklep_konf",'galeria_kat').$dane3['img2_nazwa']."\" class=\"obrazek\" width=\"".$dane3['img2_w']."\" height=\"".$dane3['img2_h']."\" alt=\"\" />"; 
	  		}						
				echo "</a>";
				echo "</div>";
				
				echo "</td>";
				
	      echo "<td class=\"tlo3 srodek\">";
				
				echo "<div class=\"srodek\"><table border=\"0\" style=\"margin-top:5px\" class=\"srodek\"><tr>";    				
		    echo interfejs::edytuj($link2."&amp;akcja=produktyadmin_galeriaedytuj&amp;id_nr=".$dane3['id']);				
		    echo interfejs::przyciskEl("folder_wrench",$link2."&amp;akcja=produktyadmin_galeriakonfigedytuj&amp;id_nr=".$dane3['id'],konf::get()->langTexty("produktyadmin_gal_eplik")); 	
				echo interfejs::infoEl($dane);			
				echo interfejs::usun($link2."&amp;akcja=produktyadmin_galeriausun&amp;id_tab[1]=".$dane3['id']); 
				echo "</tr></table></div>";   
				
				echo "<div class=\"srodek\"><table border=\"0\" style=\"margin-top:5px\" class=\"srodek\"><tr>";    
				echo interfejs::pozycja($link2."&amp;akcja=produktyadmin_galeriapoz&amp;id_nr=".$dane3['id'],$i,$ile,$podstrona,$naw->getStron());
				echo "</tr></table></div>";   				
				
	      echo "</td>";
				
				echo "<td class=\"tlo3 srodek\">";				
	      echo "<div>".konf::get()->langTexty("produktyadmin_gal_szerokosc").": <span class=\"grube\">".$dane3['img1_w']."</span>".konf::get()->langTexty("produktyadmin_gal_px")."</div>";					
	      echo "<div>".konf::get()->langTexty("produktyadmin_gal_wysokosc").": <span class=\"grube\">".$dane3['img1_h']."</span>".konf::get()->langTexty("produktyadmin_gal_px")."</div>";					
	      echo "</td>";						
	      
	      //status  
	      echo "<td class=\"tlo3\">";
	      if($dane3['status']==1){ 
					echo konf::get()->langTexty("aktywne"); 
				} else { 
					echo konf::get()->langTexty("nieaktywne"); 
				}
			
		    if(konf::get()->getKonfigTab("sklep_konf",'galeria_obrobka')&&!empty($dane3['obrobka'])){
		      echo "<div class=\"grube\">".konf::get()->langTexty("produktyadmin_gal_obrobka")."</div>";
		    }							
	      echo "</td>";
	      
	      //licznik ogladalnosci
	      if(konf::get()->getKonfigTab("sklep_konf",'galeria_licznik')){
	        echo "<td class=\"tlo3\">".$dane3['licznik']."</td>";
	      }
				
	      //licznik ogladalnosci
	      if(konf::get()->getKonfigTab("sklep_konf",'galeria_punkty')){
	        echo "<td class=\"tlo3\">".$dane3['punkty']."</td>";
	        echo "<td class=\"tlo3\">";					
					echo $dane3['ilosc_glosow'];
					if(!empty($dane['ilosc_glosow'])){
						echo "<div>(".round(($dane3['punkty']/$dane3['ilosc_glosow']),2).")</div>";
					}
					echo "</td>";					
	      }				
				
	      echo "</tr>";
				
	    }
			
			if($podstrona==$naw->getStron()){
	      echo "<tr><td class=\"tlo3 lewa\" colspan=\"".$colspan."\">";
				echo interfejs::wstaw($link2."&amp;akcja=produktyadmin_galeriadodaj");
				echo "</td></tr>";		
			}
			
	    konf::get()->_bazasql->freeResult($zap);
			
	    if($i==0){
				echo interfejs::brak($colspan);			 
	    }
	    
			if($naw->getNaw()){
				echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
			}	

			echo "<tr class=\"srodek\"><td colspan=\"".$colspan."\" class=\"tlo4\">";
			echo interfejs::linkEl("folder_explore",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_zobacz","id_kat"=>$dane2['id'],"id_d"=>$this->id_d)),konf::get()->langTexty("produktyadmin_gal_powrot"));
			echo "</td></tr>";
			
	    echo tab_stop();
	    echo $form->getFormk();
			
	  } else {
			interfejs::nieprawidlowe();
	  }
		  
	}
	
	
	/**
   * gallery save
   */		
	public function galeriaobrot(){

		$id_akapit=tekstForm::doSql(konf::get()->getZmienna('id_akapit','id_akapit'));
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));
		$typ=konf::get()->getZmienna('typ','typ');		
		
		//dane podstawowe z formularza
		$daneNieczysc=array();
		$dane=array();
		$testy=array();

		if($typ=="l"||$typ=="r"||$typ=="d"){
		
			//generator zapytania insert/update
			require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
			$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'sklep_galeria'),$dane,$daneNieczysc);
			$sqldane->daneOdczyt();	
			$sqldane->setAutor(true);	
			$sqldane->setTesty($testy);	

			if(!empty($id_nr)){
		    //pobranie aktualne dane   
			  $dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_galeria')." WHERE id='".$id_nr."'");
			  
			  if(empty($dane)){
			  	$id_nr="";
			  } else {
			  	$id_akapit=$dane['id_matka'];
			  }
			}
			
			if(!empty($id_akapit)){
				$dane2=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_akapity')." WHERE id='".$id_akapit."'");
				if(!empty($dane2)){
					$id_kat=$dane2['id_matka'];
				}
			}		

			if(!empty($dane2)&&!empty($dane)&&!empty($dane['img1_nazwa'])){   
			
				//dodaj dane zo zapytania
			 	$sqldane->setDane(array(
			 		"id_matka"=>$dane['id_matka']
				));				
							
									
				$sqldane->dodajDaneE();	
					
				require_once(konf::get()->getKonfigTab('klasy')."class.zapiszgrafike.php");
					
				$grafika=new zapiszGrafike($id_nr,konf::get()->getKonfigTab("sklep_konf",'galeria_kat'),"pic","img",$dane);
				$grafika->setWszystkie(true);
				
				if($typ=="l"){
					$obrot=90;
				} else if ($typ=="d"){
					$obrot=180;
				} else {
					$obrot=270;
				}

				//dla dalszej obrobki zdjecie moze miec wieksze wymiary
				if($dane['obrobka']&&konf::get()->getKonfigTab("sklep_konf",'galeria_obrobka')){
					$grafika->setDaneImg(1,array(
						"hmax"=>konf::get()->getKonfigTab("sklep_konf",'galeria_o_size'),
						"wmax"=>konf::get()->getKonfigTab("sklep_konf",'galeria_o_size'),
						"hmin"=>konf::get()->getKonfigTab("sklep_konf",'galeria_min_size'),
						"wmin"=>konf::get()->getKonfigTab("sklep_konf",'galeria_min_size'),
						"typy"=>array(2=>2),
						"skala"=>3,
						"obrot"=>$obrot,											
					));					
				} else {
					$grafika->setDaneImg(1,array(
						"hmax"=>konf::get()->getKonfigTab("sklep_konf",'galeria_img_size'),
						"wmax"=>konf::get()->getKonfigTab("sklep_konf",'galeria_img_size'),
						"hmin"=>konf::get()->getKonfigTab("sklep_konf",'galeria_min_size'),
						"wmin"=>konf::get()->getKonfigTab("sklep_konf",'galeria_min_size'),
						"typy"=>array(2=>2),
						"skala"=>3,
						"obrot"=>$obrot									
					));
				}
					
				//w przypadku zdjecia do obrobki, gdy zmian na zwykle zdjecie i zdjecie istnieje to mozemy przeskalowac z automatu zdjecie juzwczesniej zapisane
				$grafika->setPlikzrodlowy(konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("sklep_konf",'galeria_kat').$dane['img1_nazwa']);		
						
				$grafika->setDaneImg(2,array(
					"hmax"=>konf::get()->getKonfigTab("sklep_konf",'galeria_m_size'),
					"wmax"=>konf::get()->getKonfigTab("sklep_konf",'galeria_m_size'),
					"hmin"=>konf::get()->getKonfigTab("sklep_konf",'galeria_min_size'),
					"wmin"=>konf::get()->getKonfigTab("sklep_konf",'galeria_min_size'),
					"typy"=>array(2=>2),
					"skala"=>konf::get()->getKonfigTab("sklep_konf",'galeria_skalowanie')					
				));			

				$grafika->wykonaj();
					
				if(!empty($grafika->_typ)){
				
					if($grafika->getSql()){			
						$sqldane->dodaj(", ".$grafika->getSql());				
					}

					$sqldane->dodaj(" WHERE id='".$id_nr."'");	
									
					if($sqldane->getSql()){
						konf::get()->_bazasql->zap($sqldane->getSql());		 				
			  	  user::get()->zapiszLog(konf::get()->langTexty("sklep_admin_gal_kobrot")." ".$dane['id'],user::get()->login());
					}
				} else {
					konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_galeria')." WHERE id='".$id_nr."'");				
					$id_nr="";					
				}

		    if(!empty($id_nr)){
		    	konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");
		  		konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." SET edytor_id='".user::get()->id()."', edytor_name='".user::get()->autor()."', edytor_kiedy=NOW() WHERE id='".$id_kat."'");
		    } else { 
					konf::get()->setKomunikat(konf::get()->langTexty("niezapisane"),"error"); 
				} 
				
			} else { 
				konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
			}
		
		} else { 
			konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
		}		
		
	}		

	
	/**
   * gallery save
   */		
	public function galeriakonfigedytuj2(){

		$id_nad=tekstForm::doSql(konf::get()->getZmienna('id_nad'));	
		$id_akapit=tekstForm::doSql(konf::get()->getZmienna('id_akapit'));
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr'));
		
	 	$x1=tekstForm::doSql(konf::get()->getZmienna('x1'));
	 	$x2=tekstForm::doSql(konf::get()->getZmienna('x2'));
	 	$y1=tekstForm::doSql(konf::get()->getZmienna('y1'));
	 	$y2=tekstForm::doSql(konf::get()->getZmienna('y2'));				
	 	$dl=tekstForm::doSql(konf::get()->getZmienna('dl'));
	 	$dh=tekstForm::doSql(konf::get()->getZmienna('dh'));				

		//dane podstawowe z formularza
		$dane=array(		
			"obrobka"	=>""
		);	
		
		
		$daneNieczysc=array();
		
		$testy[]=array("zmienna"=>"obrobka","test"=>"truefalse");		

		//generator zapytania insert/update
		require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
		$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'sklep_galeria'),$dane,$daneNieczysc);
		$sqldane->daneOdczyt();	
		$sqldane->setAutor(true);	
		$sqldane->setTesty($testy);	

		if(!empty($id_nr)){
	    //pobranie aktualne dane   
		  $dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_galeria')." WHERE id='".$id_nr."'");
		  
		  if(empty($dane)){
		  	$id_nr="";
		  } else {
		  	$id_akapit=$dane['id_matka'];
		  }
		}
		
		if(!empty($id_akapit)){
			$dane2=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_akapity')." WHERE id='".$id_akapit."'");
			if(!empty($dane2)){
				$id_kat=$dane2['id_matka'];
			}
		}		

		if(!empty($dane2)&&!empty($dane)&&!empty($dane['img1_nazwa'])){   
			
			$sqldane->dodajDaneE();	
				
			require_once(konf::get()->getKonfigTab('klasy')."class.zapiszgrafike.php");
				
			$grafika=new zapiszGrafike($id_nr,konf::get()->getKonfigTab("sklep_konf",'galeria_kat'),"pic","img",$dane);
			$grafika->setWszystkie(true);

			//dla dalszej obrobki zdjecie moze miec wieksze wymiary
			if($sqldane->getDane('obrobka')&&konf::get()->getKonfigTab("sklep_konf",'galeria_obrobka')){
				$grafika->setDaneImg(1,array(
					"hmax"=>konf::get()->getKonfigTab("sklep_konf",'galeria_o_size'),
					"wmax"=>konf::get()->getKonfigTab("sklep_konf",'galeria_o_size'),
					"hmin"=>konf::get()->getKonfigTab("sklep_konf",'galeria_min_size'),
					"wmin"=>konf::get()->getKonfigTab("sklep_konf",'galeria_min_size'),
					"typy"=>array(2=>2),
					"skala"=>3,
					"x1"=>$x1,
					"x2"=>$x2,
					"y1"=>$y1,
					"y2"=>$y2														
				));					
			} else {
				$grafika->setDaneImg(1,array(
					"hmax"=>konf::get()->getKonfigTab("sklep_konf",'galeria_img_size'),
					"wmax"=>konf::get()->getKonfigTab("sklep_konf",'galeria_img_size'),
					"hmin"=>konf::get()->getKonfigTab("sklep_konf",'galeria_min_size'),
					"wmin"=>konf::get()->getKonfigTab("sklep_konf",'galeria_min_size'),
					"typy"=>array(2=>2),
					"skala"=>3,
					"x1"=>$x1,
					"x2"=>$x2,
					"y1"=>$y1,
					"y2"=>$y2												
				));
			}
				
			//w przypadku zdjecia do obrobki, gdy zmian na zwykle zdjecie i zdjecie istnieje to mozemy przeskalowac z automatu zdjecie juzwczesniej zapisane
			$grafika->setPlikzrodlowy(konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("sklep_konf",'galeria_kat').$dane['img1_nazwa']);		
					
			$grafika->setDaneImg(2,array(
				"hmax"=>konf::get()->getKonfigTab("sklep_konf",'galeria_m_size'),
				"wmax"=>konf::get()->getKonfigTab("sklep_konf",'galeria_m_size'),
				"hmin"=>konf::get()->getKonfigTab("sklep_konf",'galeria_min_size'),
				"wmin"=>konf::get()->getKonfigTab("sklep_konf",'galeria_min_size'),
				"typy"=>array(2=>2),
				"skala"=>konf::get()->getKonfigTab("sklep_konf",'galeria_skalowanie')					
			));			

			$grafika->wykonaj();
				
			if(!empty($grafika->_typ)){
				if($grafika->getSql()){			
					$sqldane->dodaj(", ".$grafika->getSql());				
				}

				$sqldane->dodaj(" WHERE id='".$id_nr."'");	
								
				if($sqldane->getSql()){
					konf::get()->_bazasql->zap($sqldane->getSql());		 				
		  	  user::get()->zapiszLog(konf::get()->langTexty("sklep_admin_gal_kedycja")." ".$dane['id'],user::get()->login());
				}
			} else {
				konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_galeria')." WHERE id='".$id_nr."'");				
				$id_nr="";					
			}

	    if(!empty($id_nr)){
	    	konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");
	  		konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." SET edytor_id='".user::get()->id()."', edytor_name='".user::get()->autor()."', edytor_kiedy=NOW() WHERE id='".$id_kat."'");
	    } else { 
				konf::get()->setKomunikat(konf::get()->langTexty("niezapisane"),"error"); 
			} 
			
		} else { 
			konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
		}
		
	}	
		
	
	public function galeriakonfigedytuj(){
	
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$id_akapit=tekstForm::doSql(konf::get()->getZmienna('id_akapit','id_akapit'));	
	 	$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));	

		if(!empty($id_nr)){
			$danea=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_galeria')." WHERE id='".$id_nr."'");
			if(!empty($danea)){
				$id_akapit=$danea['id_matka'];
				$dane=$danea;
			} else {
				$id_nr="";
			}
		}				
		
		if(!empty($id_akapit)){
			$dane2=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_akapity')." WHERE id='".$id_akapit."'");
			if(!empty($dane2)){
				$id_kat=$dane2['id_matka'];
			}
		}		
		
		//dzial od elementu nadrzednego
		if(!empty($id_kat)){
			$dane3=$this->pobierz($id_kat,true);
		}

		if(!empty($dane2)&&!empty($dane3)){	
			
			konf::get()->setZmienna('_post','id_kat',$dane3['id']);		
			$this->id_d=$dane3['id_d'];

			$this->sciezka();
			 
	  	echo tab_nagl(konf::get()->langTexty("produktyadmin_galf_pkonfig"),1);

		 	echo "<tr><td class=\"tlo4 lewa\">";
			echo "<div class=\"grube\">".$dane3['tytul']."</div>";			
			$this->sklepMenu($dane3);						
			echo "</td></tr>";
			
		  echo "<tr><td valign=\"top\" class=\"tlo3\">";

			if(!empty($id_nr)){
				$this->galeriaMenu($dane);
			}
			
			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"sklep","sklep");				
			
			echo $form->getFormp();
			echo $form->przenies(array(
				"a"=>"",
				"id_nr"=>$id_nr,
				"akcja"=>konf::get()->getAkcja()."2",
				"podstrona"=>$podstrona,
				"id_d"=>$this->id_d,				
				"id_akapit"=>$id_akapit
			));							
			
			konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/prototype.js","js");	
			konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/scriptaculous/scriptaculous.js?load=builder,dragdrop","js");				
			konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/cropper/cropper.js","js");				
			
			/*
			//ratio params
      ratioDim: {
				x: 220,
				y: 165				
			},
			//min size params
      minWidth:<?php echo konf::get()->getKonfigTab("sklep_konf",'galeria_m_size'); ?>,
      minHeight:<?php echo konf::get()->getKonfigTab("sklep_konf",'galeria_m_size'); ?>,			
			displayOnInit: true,
			*/
			
			?>			
			
			<script type="text/javascript" charset="utf-8">
			
				obrazekcrop='obrazekcrop';
				
				// setup the callback function
				function onEndCrop( coords, dimensions ) {
					$( 'x1' ).value = coords.x1;
					$( 'y1' ).value = coords.y1;
					$( 'x2' ).value = coords.x2;
					$( 'y2' ).value = coords.y2;
					$( 'dl' ).value = dimensions.width;
					$( 'dh' ).value = dimensions.height;
				}
				
				// basic example
				Event.observe(window, 'load', function() { 
						curCrop=new Cropper.Img(obrazekcrop,{ 
							onEndCrop: onEndCrop 
						}) 
					}
				); 		
				
				function resetuj(){
					if( curCrop == null ){ 
						curCrop = new Cropper.Img(obrazekcrop, { onEndCrop: onEndCrop } );
					} else {
						this.curCrop.reset();
					}
				}
				
			</script>			
	
			<?php
			
			if(function_exists("imagerotate")){
			
				$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_galeriaobrot","id_akapit"=>$id_akapit,"id_d"=>$this->id_d,"id_nr"=>$id_nr));
				
				echo "<table border=\"0\" style=\"margin-top:5px\" class=\"srodek\">";
				
				echo "<tr>";    
		    echo interfejs::przyciskEl("arrow_turn_left",$link."&amp;typ=l",konf::get()->langTexty("sklep_admin_galf_obr90")); 	
				echo "<td class=\"lewa\">".konf::get()->langTexty("sklep_admin_galf_obr90w")."</td>";			
				echo "</tr>";
				
				echo "<tr>";  								
		    echo interfejs::przyciskEl("arrow_turn_right",$link."&amp;typ=r",konf::get()->langTexty("sklep_admin_galf_obr90n")); 	
				echo "<td class=\"lewa\">".konf::get()->langTexty("sklep_admin_galf_obr90nw")."</td>";								
				echo "</tr>";
				
				echo "<tr>";    
		    echo interfejs::przyciskEl("arrow_undo",$link."&amp;typ=d",konf::get()->langTexty("sklep_admin_galf_obr180")); 	
				echo "<td class=\"lewa\">".konf::get()->langTexty("sklep_admin_galf_obr180w")."</td>";					
				echo "</tr>";
				
				echo "</table>";  				
					
				
			}	
			
			echo "<div class=\"srodek grube\" style=\"padding:7px\">".konf::get()->langTexty("sklep_admin_galf_zaznacz");
			echo interfejs::pomocEl(konf::get()->langTexty("sklep_admin_galf_zaznaczh"));		
			echo "</div>";

			if(!empty($dane['img1_nazwa'])&&file_exists(konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("sklep_konf",'galeria_kat').$dane['img1_nazwa'])){
  			echo "<div class=\"srodek\" style=\"width:".$dane['img1_w']."px\"><img id=\"obrazekcrop\" src=\"".konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("sklep_konf",'galeria_kat').$dane['img1_nazwa']."\" width=\"".$dane['img1_w']."\" height=\"".$dane['img1_h']."\" alt=\"\" /></div>"; 
  		}						

			echo "<div class=\"srodek\" style=\"width:70%; padding-top:10px\">";
			echo tab_nagl(konf::get()->langTexty("sklep_admin_galf_oparametry"),6);
			?>
			
			<tr>
			
				<td class="tlo3"><?php echo konf::get()->langTexty("sklep_admin_galf_opolozenie"); ?> x1:</td>
				<td class="tlo3">
				<?php
				echo $form->input("text","x1","x1",0,"f_krotki",6," onfocus=\"this.blur();\"");		
				?>
				</td>
				
				<td class="tlo3"><?php echo konf::get()->langTexty("sklep_admin_galf_opolozenie"); ?> x2:</td>
				<td class="tlo3">
				<?php
				echo $form->input("text","x2","x2",0,"f_krotki",6," onfocus=\"this.blur();\"");		
				?>
				</td>
				
				<td class="tlo3"><?php echo konf::get()->langTexty("sklep_admin_galf_oszerokosc"); ?></td>
				<td class="tlo3">
				<?php
				echo $form->input("text","dl","dl",0,"f_krotki",6," onfocus=\"this.blur();\"");		
				?>
				</td>			
				
			</tr>
		
			<tr>
			
				<td class="tlo3"><?php echo konf::get()->langTexty("sklep_admin_galf_opolozenie"); ?> y1:</td>
				<td class="tlo3">
				<?php
				echo $form->input("text","y1","y1",0,"f_krotki",6," onfocus=\"this.blur();\"");		
				?>
				</td>
				
				<td class="tlo3"><?php echo konf::get()->langTexty("sklep_admin_galf_opolozenie"); ?> y2:</td>
				<td class="tlo3">
				<?php
				echo $form->input("text","y2","y2",0,"f_krotki",6," onfocus=\"this.blur();\"");		
				?>
				</td>			
				
				<td class="tlo3"><?php echo konf::get()->langTexty("sklep_admin_galf_owysokosc"); ?></td>
				<td class="tlo3">
				<?php
				echo $form->input("text","dh","dh",0,"f_krotki",6," onfocus=\"this.blur();\"");		
				?>
				</td>			
				
			</tr>		
			
			<tr><td colspan="6" class="tlo4">
			<?php
			echo $form->input("button","","",konf::get()->langTexty("sklep_admin_galf_oresetuj"),"formularz2 f_sredni",''," onclick=\"resetuj();\"");						
			?>
			</td></tr>
		
			<?php
			
			echo tab_stop();
			echo "</div>";

	    if(konf::get()->getKonfigTab("sklep_konf",'galeria_obrobka')&&$dane['obrobka']){
		    echo "<br /><span class=\"nobr\">";
				echo $form->checkbox("obrobka","obrobka",1,$dane['obrobka']);	
		   	echo " <label for=\"obrobka\">".konf::get()->langTexty("produktyadmin_galf_obrobka")."</label>";
				echo interfejs::pomocEl(konf::get()->langTexty("admin_galf_obrobkah"));							
				echo "</span><br />";
	    }												
			
			echo "<div class=\"srodek\">";
			echo $form->input("submit","","",konf::get()->langTexty("sklep_admin_galf_okadruj"),"formularz2 f_dlugi");		
			echo "</div>";

			echo "<br /><br />";
			echo "<div class=\"male\">".konf::get()->langTexty("sklep_admin_galf_owielokrotne")."</div>";
			echo "<div class=\"male\">".konf::get()->langTexty("sklep_admin_galf_owszystkie")."</div>"
			;			
			echo $form->getFormk();
			
			echo "</td></tr>";
			
			echo "<tr class=\"srodek\"><td class=\"tlo4\">".interfejs::linkEl("folder_explore",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_galeria","id_akapit"=>$id_akapit,"id_d"=>$this->id_d)),konf::get()->langTexty("produktyadmin_galf_powrot"))."</td></tr>";
	  	echo tab_stop();

			
	  } else {
			echo interfejs::nieprawidlowe();	
	  }
	
	}
	
	/**
   * sklep akapity form
   */		
	private function galeriaForm(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$id_akapit=tekstForm::doSql(konf::get()->getZmienna('id_akapit','id_akapit'));	
	 	$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));
		$id_nad=tekstForm::doSql(konf::get()->getZmienna('id_nad','id_nad'));

		//domyslne wartosci
		$dane=array(
			"opis"=>"",
			"tytul"=>"",
			"autor"=>"",
			"punkty"=>0,
			"licznik"=>0,
			"ilosc_glosow"=>0,
			"obrobka"=>0,			
			"status"=>1
		);	

		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"sklep","sklep");	
		
		if(!empty($id_nr)){
			$danea=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_galeria')." WHERE id='".$id_nr."'");
			if(!empty($danea)){
				$id_akapit=$danea['id_matka'];
				$dane=$danea;
			} else {
				$id_nr="";
			}
		}				
		
		if(!empty($id_akapit)){
			$dane2=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_akapity')." WHERE id='".$id_akapit."'");
			if(!empty($dane2)){
				$id_kat=$dane2['id_matka'];
			}
		}		
		
		//dzial od elementu nadrzednego
		if(!empty($id_kat)){
			$dane3=$this->pobierz($id_kat,true);
		}

		if(!empty($dane2)&&!empty($dane3)){
		
			konf::get()->setZmienna('_post','id_kat',$dane3['id']);		
			$this->id_d=$dane3['id_d'];

			$this->sciezka();
			 
			if(konf::get()->getAkcja()=="produktyadmin_galeriadodaj"){
	  		echo tab_nagl(konf::get()->langTexty("produktyadmin_galf_dodawanie"),1);
		  } else {
	  	  echo tab_nagl(konf::get()->langTexty("produktyadmin_galf_edycja"),1);
		  }

		 	echo "<tr><td class=\"tlo4 lewa\">";
			echo "<div class=\"grube\">".$dane3['tytul']."</div>";			
			$this->sklepMenu($dane3);						
			echo "</td></tr>";
			
		  echo "<tr><td valign=\"top\" class=\"tlo3\">";

			if(!empty($id_nr)){
				$this->galeriaMenu($dane);
			}
			
			echo "<br />";   

			$form->setMultipsklep(true);	
				
			if(empty($id_nr)){
				echo $form->spr(array(1=>"akcja",2=>"pic"));			
			} else {
				echo $form->spr(array(1=>"akcja"));
			}
			
			echo $form->getFormp();
			echo $form->przenies(array(
				"a"=>"",
				"id_nr"=>$id_nr,
				"akcja"=>konf::get()->getAkcja()."2",
				"podstrona"=>$podstrona,
				"id_d"=>$this->id_d,				
				"id_akapit"=>$id_akapit,
				"id_nad"=>$id_nad
			));
			
			
			if(!empty($dane['img'])&&!empty($dane['img1_nazwa'])){

				echo interfejs::imgPodglad($dane,"img",konf::get()->getKonfigTab("sklep_konf",'galeria_kat'));	

 	 		}

			echo "<div class=\"grube\">".konf::get()->langTexty("sklep_admin_aform_gjpg")."*</div>";							
			echo $form->input("file","pic","pic","","f_bdlugi");				
			echo "<br /><br />";				
			
	    if(konf::get()->getKonfigTab("sklep_konf",'galeria_opis')){
							
		    echo "<span class=\"grube\">".konf::get()->langTexty("produktyadmin_galf_tytul")."</span>";
				echo "<br />";
				echo $form->input("text","tytul","tytul",$dane['tytul'],"f_bdlugi",250);		
				echo "<br /><br />";		

			  echo "<div class=\"grube\">".konf::get()->langTexty("produktyadmin_galf_opis")."</div>";				
				echo $form->textarea("opis","opis",$dane['opis'],"f_bdlugi",12);
		    echo "<br /><br />";	
					
			}
						
	    if(konf::get()->getKonfigTab("sklep_konf",'galeria_licznik')){
				echo $form->input("text","licznik","licznik",$dane['licznik'],"f_krotki",10);				
				echo " ".konf::get()->langTexty("produktyadmin_galf_licznik")."<br />";
	    }			
			
			
	    if(konf::get()->getKonfigTab("sklep_konf",'galeria_punkty')){
	      echo "<br />";
				echo $form->input("text","punkty","punkty",$dane['punkty'],"f_krotki",10);				
				echo " ".konf::get()->langTexty("produktyadmin_galf_suma")."<br />";
				
	      echo "<br />";
				echo $form->input("text","ilosc_glosow","ilosc_glosow",$dane['ilosc_glosow'],"f_krotki",10);				
				echo " ".konf::get()->langTexty("produktyadmin_galf_ilosc")."<br />";			
					
	    }			
			
	    if(konf::get()->getKonfigTab("sklep_konf",'galeria_obrobka')){
		    echo "<br /><span class=\"nobr\">";
				echo $form->checkbox("obrobka","obrobka",1,$dane['obrobka']);	
		   	echo " <label for=\"obrobka\">".konf::get()->langTexty("produktyadmin_galf_obrobka")."</label>";
				echo interfejs::pomocEl(konf::get()->langTexty("admin_galf_obrobkah"));							
				echo "</span><br />";
	    }												
			
	    echo "<br /><span class=\"nobr\">";
			echo $form->checkbox("status","status",1,$dane['status']);	
	   	echo " <label for=\"status\">".konf::get()->langTexty("widoczny")."</label></span><br />";
	   	
	  	echo "<br />";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");		
			echo "<br />";
			echo "<div class=\"male\">".konf::get()->langTexty("musza")."</div>";
			
			echo $form->getFormk();
			
			echo "</td></tr>";
			
			echo "<tr class=\"srodek\"><td class=\"tlo4\">".interfejs::linkEl("folder_explore",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_galeria","id_akapit"=>$id_akapit,"id_d"=>$this->id_d)),konf::get()->langTexty("produktyadmin_galf_powrot"))."</td></tr>";
	  	echo tab_stop();
			
	  } else {
			echo interfejs::nieprawidlowe();	
	  }
		
	}
	
	/**
   * sklep add
   */		
	public function galeriadodaj(){	
		$this->galeriaForm();
	}
	
	
	/**
   * sklep edit
   */		
	public function galeriaedytuj(){	
		$this->galeriaForm();
	}		
	
	
	
	/**
   * gallery save
   */		
	private function galeriaZapisz(){

		$id_nad=tekstForm::doSql(konf::get()->getZmienna('id_nad'));	
		$id_akapit=tekstForm::doSql(konf::get()->getZmienna('id_akapit'));
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr'));

		//dane podstawowe z formularza
		$dane=array(
			"opis"=>"",
			"tytul"=>"",
			"licznik"=>"",					
			"punkty"=>"",		
			"obrobka"	=>"",
			"ilosc_glosow"=>"",						
			"status"=>""
		);	
		
		$daneNieczysc[]=array();
		
		$testy[]=array("zmienna"=>"status","test"=>"truefalse");
		$testy[]=array("zmienna"=>"obrobka","test"=>"truefalse");
				
		$testy[]=array("zmienna"=>"licznik","test"=>"liczba",
			"param"=>array(
				"domyslny"=>0,
				"min"=>0					
			)
		);				
		
		$testy[]=array("zmienna"=>"punkty","test"=>"liczba",
			"param"=>array(
				"domyslny"=>0,
				"min"=>0					
			)
		);					
		
		$testy[]=array("zmienna"=>"ilosc_glosow","test"=>"liczba",
			"param"=>array(
				"domyslny"=>0,
				"min"=>0					
			)
		);					

		//generator zapytania insert/update
		require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
		$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'sklep_galeria'),$dane,$daneNieczysc);
		$sqldane->daneOdczyt();	
		$sqldane->setAutor(true);	
		$sqldane->setTesty($testy);	

		if(!empty($id_nr)){
	    //pobranie aktualne dane   
		  $dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_galeria')." WHERE id='".$id_nr."'");
		  
		  if(empty($dane)){
		  	$id_nr="";
		  } else {
		  	$id_akapit=$dane['id_matka'];
		  }
		}
		
		if(!empty($id_akapit)){
			$dane2=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_akapity')." WHERE id='".$id_akapit."'");
			if(!empty($dane2)){
				$id_kat=$dane2['id_matka'];
			}
		}		
		
		//dzial od elementu nadrzednego
		if(!empty($id_kat)){
			$dane3=$this->pobierz($id_kat,true);
		}

		if(!empty($dane2)&&!empty($dane3)){
		
			//skalowanie miniaturek zdjec
			
			$skala=konf::get()->getKonfigTab("sklep_konf",'galeria_skalowanie');
			if(!empty($dane2['galeria_skala'])){
				$skala=$dane2['galeria_skala'];
			}
			
			$img_m_w=konf::get()->getKonfigTab("sklep_konf",'galeria_m_size');
			if(!empty($dane2['galeria_m_w'])){
				$img_m_w=$dane2['galeria_m_w'];
			}				
		
			$img_m_h=konf::get()->getKonfigTab("sklep_konf",'galeria_m_size');
			if(!empty($dane2['galeria_m_h'])){
				$img_m_h=$dane2['galeria_m_h'];
			}				
		
			//dodanie 
			if(empty($id_nr)){
			
				//numer porzadkowy					
				$sqldane->setMatka($id_akapit);	
				$sqldane->setNad($id_nad);					
				$sqldane->setPoleMatka("id_matka");				
				$sqldane->setPoleId("id");
				$sqldane->setPolePoz("nr_poz");				
				$sqldane->dodajPoz();			
				
				//dodaj dane zo zapytania
			 	$sqldane->setDane(array(
			 		"id_matka"=>$id_akapit
				));		
				

				//budowanie zapytania
				$sqldane->dodajDaneD();											

				if($sqldane->getSql()){
					konf::get()->_bazasql->zap($sqldane->getSql());
				}
						
				//wykonaj zapytanie
				$id_nr=konf::get()->_bazasql->insert_id;			
					
				if(!empty($id_nr)){
			
					//jesli dodany pomiedzy to przesun kolejne elementy						
					$sqldane->setId($id_nr);							
					$sqldane->ustawPoz();

					require_once(konf::get()->getKonfigTab('klasy')."class.zapiszgrafike.php");
					
					$grafika=new zapiszGrafike($id_nr,konf::get()->getKonfigTab("sklep_konf",'galeria_kat'),"pic","img");
					$grafika->setWszystkie(true);
					$grafika->setImgUsun(false);
					
					//dla dalszej obrobki zdjecie moze miec wieksze wymiary					
					if($sqldane->getDane('obrobka')&&konf::get()->getKonfigTab("sklep_konf",'galeria_obrobka')){
						$grafika->setDaneImg(1,array(
							"hmax"=>konf::get()->getKonfigTab("sklep_konf",'galeria_o_size'),
							"wmax"=>konf::get()->getKonfigTab("sklep_konf",'galeria_o_size'),
							"hmin"=>konf::get()->getKonfigTab("sklep_konf",'galeria_min_size'),
							"wmin"=>konf::get()->getKonfigTab("sklep_konf",'galeria_min_size'),
							"typy"=>array(2=>2),
							"skala"=>3					
						));					
					} else {
						$grafika->setDaneImg(1,array(
							"hmax"=>konf::get()->getKonfigTab("sklep_konf",'galeria_img_size'),
							"wmax"=>konf::get()->getKonfigTab("sklep_konf",'galeria_img_size'),
							"hmin"=>konf::get()->getKonfigTab("sklep_konf",'galeria_min_size'),
							"wmin"=>konf::get()->getKonfigTab("sklep_konf",'galeria_min_size'),
							"typy"=>array(2=>2),
							"skala"=>3					
						));
					}
					
					$grafika->setDaneImg(2,array(
						"hmax"=>$img_m_h,
						"wmax"=>$img_m_w,
						"hmin"=>konf::get()->getKonfigTab("sklep_konf",'galeria_min_size'),
						"wmin"=>konf::get()->getKonfigTab("sklep_konf",'galeria_min_size'),
						"typy"=>array(2=>2),
						"skala"=>$skala					
					));		

					$grafika->wykonaj();
					
					if($grafika->getSql()){					
						konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'sklep_galeria')." SET ".$grafika->getSql()." WHERE id='".$id_nr."'");	
					}	else {
						konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_galeria')." WHERE id='".$id_nr."'");				
						$id_nr="";				
					}
		
	  	  	user::get()->zapiszLog(konf::get()->langTexty("sklep_admin_gal_dodaniek")." ".$dane3['tytul'],user::get()->login());
					
	    	}	
	    //edycja
	    } else {    
			
				$sqldane->dodajDaneE();	
				
				require_once(konf::get()->getKonfigTab('klasy')."class.zapiszgrafike.php");
				
				$grafika=new zapiszGrafike($id_nr,konf::get()->getKonfigTab("sklep_konf",'galeria_kat'),"pic","img",$dane2);
				$grafika->setWszystkie(true);

				//dla dalszej obrobki zdjecie moze miec wieksze wymiary
				if($sqldane->getDane('obrobka')&&konf::get()->getKonfigTab("sklep_konf",'galeria_obrobka')){
					$grafika->setDaneImg(1,array(
						"hmax"=>konf::get()->getKonfigTab("sklep_konf",'galeria_o_size'),
						"wmax"=>konf::get()->getKonfigTab("sklep_konf",'galeria_o_size'),
						"hmin"=>konf::get()->getKonfigTab("sklep_konf",'galeria_min_size'),
						"wmin"=>konf::get()->getKonfigTab("sklep_konf",'galeria_min_size'),
						"typy"=>array(2=>2),
						"skala"=>3					
					));					
				} else {
					$grafika->setDaneImg(1,array(
						"hmax"=>konf::get()->getKonfigTab("sklep_konf",'galeria_img_size'),
						"wmax"=>konf::get()->getKonfigTab("sklep_konf",'galeria_img_size'),
						"hmin"=>konf::get()->getKonfigTab("sklep_konf",'galeria_min_size'),
						"wmin"=>konf::get()->getKonfigTab("sklep_konf",'galeria_min_size'),
						"typy"=>array(2=>2),
						"skala"=>3					
					));
				}
				
				//w przypadku zdjecia do obrobki, gdy zmian na zwykle zdjecie i zdjecie istnieje to mozemy przeskalowac z automatu zdjecie juz wczesniej zapisane
				if(konf::get()->getKonfigTab("sklep_konf",'galeria_obrobka')&&!empty($dane['obrobka'])&&!$sqldane->getDane('obrobka')&&!empty($dane['img1_nazwa'])){
					$grafika->setPlikzrodlowy(konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("sklep_konf",'galeria_kat').$dane['img1_nazwa']);		
				}
					
				$grafika->setDaneImg(2,array(
					"hmax"=>$img_m_h,
					"wmax"=>$img_m_w,
					"hmin"=>konf::get()->getKonfigTab("sklep_konf",'galeria_min_size'),
					"wmin"=>konf::get()->getKonfigTab("sklep_konf",'galeria_min_size'),
					"typy"=>array(2=>2),
					"skala"=>$skala					
				));		

				$grafika->wykonaj();
				
				if((!$grafika->_typ&&!$grafika->_imgUsun)||!empty($grafika->_typ)){
				
					if($grafika->getSql()){			
						$sqldane->dodaj(", ".$grafika->getSql());				
					}

					$sqldane->dodaj(" WHERE id='".$id_nr."'");	
									
					if($sqldane->getSql()){
						konf::get()->_bazasql->zap($sqldane->getSql());		 				
			  	  user::get()->zapiszLog(konf::get()->langTexty("sklep_admin_gal_edycjak")." ".$dane3['tytul'],user::get()->login());
					}
				} else {
					konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_galeria')." WHERE id='".$id_nr."'");				
					$id_nr="";					
				}

	  	}        
	  	
	    if(!empty($id_nr)){
	    	konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");
	  		konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." SET edytor_id='".user::get()->id()."', edytor_name='".user::get()->autor()."', edytor_kiedy=NOW() WHERE id='".$id_kat."'");
	    } else { 
				konf::get()->setKomunikat(konf::get()->langTexty("niezapisane"),"error"); 
			} 
		} else { 
			konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
		}

		if(empty($id_nr)){
			konf::get()->setAkcja("produktyadmin_galeria");				
		} else {
			if(konf::get()->getAkcja()=="produktyadmin_galeriadodaj2"){
				konf::get()->setAkcja("produktyadmin_galeria");					
			} else {
				konf::get()->setAkcja("produktyadmin_galeriaedytuj");					
			}
		}
		
		konf::get()->setZmienna("_post","id_nr",$id_nr);	
		
	}	


	/**
   * sklep add
   */		
	public function galeriadodaj2(){	
		$this->galeriaZapisz();
	}
	
	
	/**
   * sklep edit
   */		
	public function galeriaedytuj2(){	
		$this->galeriaZapisz();
	}	
		
		
	public function produkty(){
	
	
	}
	
	
	/**
	 * import csv
	 */
	public function importcsv(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$sortuj=konf::get()->getZmienna('sortuj','sortuj');			
		$link=$this->szukZmienne(1)."&amp;podstrona=".$podstrona."&amp;sortuj=".$sortuj;			
		
		if(konf::get()->getKonfigTab("sklep_konf",'import_csv')){											
			
			echo tab_nagl(konf::get()->langTexty("produktyadmin_csv"));		
			echo "<tr class=\"tlolisty\">";
					
			echo "<td class=\"tlo3 lewa\">";		
		
			echo "<div style=\"padding-bottom:10px;\">".konf::get()->langTexty("produktyadmin_csvdane")."Wybierz prawidłowy plik CVS z danymi do importu bazy danych produktów:</div>";
			
			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"csv","csv");				
			$form->setMultipart(true);			
			echo $form->spr(array(1=>"plik"));		
			echo $form->getFormp();		
			
			$przenies=$this->_szuk;
			$przenies['sortuj']=$sortuj;
			$przenies['podstrona']=$podstrona;
			$przenies['akcja']=konf::get()->getAkcja()."2";
			
			echo $form->przenies($przenies);	
			
			echo "<div>";
			echo interfejs::label("plik",konf::get()->langTexty("produkty_wybierzplik")."wybierz plik z dysku: ");					
			echo "</div>";
			
			echo $form->input("file","plik","","","f_dlugi");	
			echo " ";			
			echo $form->input("submit","","",konf::get()->langTexty("produktyadmin_csvpobierz")."Pobierz plik","formularz2 f_sredni");				
			echo $form->getFormk();		

			echo "</td>";

			echo "</tr>";
			
			echo "<tr class=\"srodek\"><td class=\"tlo4\">".interfejs::linkEl("basket",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_arch","sortuj"=>$sortuj,"podstrona"=>$podstrona)).$link,konf::get()->langTexty("produkty_admin_form_listas")."Powrót na listę produktów")."</td></tr>";
					
			echo tab_stop();
			
		}
		
	}	
	
	
	/**
	 * import csv
	 */
	public function importcsv2(){
	
		$rekordy['odczytane']=0;
		$rekordy['dodane']=0;		
		$rekordy['edytowane']=0;		
		$rekordy['bledne']=0;		

		if(konf::get()->getKonfigTab("sklep_konf",'import_csv')){		

			$ok=true;
			$plik="";
			$nowi=array();
			$zmienna="plik";
			$dzielnik="|";
			
			//sprawdzamy czy jest plik
			if(!empty($_FILES)&&!empty($_FILES[$zmienna])){
				$plik=$_FILES[$zmienna];			
			} else {
				$ok=false;
			}
			
			//sprawdzamy cz sa bledy
			if($ok&&!empty($plik["error"])){			
				$ok=false;
			}
			
			//sprawdzamy czy istnieje plik tmp
			if($ok&&(empty($plik["tmp_name"])||empty($plik["name"])||!is_file($plik["tmp_name"]))){
				$ok=false;
			}							
			
			if($ok){
			
				$pliczek=file($plik["tmp_name"]);	
				$kategorie=array();				
				$kategorie_tab=konf::get()->_bazasql->pobierzRekordy("SELECT tytul,id,poziom,id_d,nr_poz FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." WHERE lang='".konf::get()->getLang()."' ORDER BY id_d, poziom, nr_poz, id ","id");
				$producenci_tab=konf::get()->_bazasql->pobierzRekordy("SELECT id,nazwa FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_producenci')." WHERE lang='".konf::get()->getLang()."' ORDER BY nazwa, id ","id");															
				$d_tab=konf::get()->getKonfigTab("sklep_konf",'d_tab');														
				
				while(list($key,$dane)=each($pliczek)){			
				
					$rekordy['odczytane']++;
				
					if(!empty($dane))	{

						//$dane=str_replace("\"","",$dane);			
						$tab = explode($dzielnik, $dane);
						$nowy=false;
						
						while(list($key2,$val2)=each($tab)){
							$tab[$key2]=trim($val2);
						}			
							
						//1=nazwa, 2=dzial, 3=kategoria
						if(!empty($tab[1])&&!empty($tab[2])){
 
							$id_d=1;
							
							//pobranie kategorii
							
							$id_kat="";							
							$id_podkat="";		
							$id_podkat2="";									
							$max_nr=0;
							$max_nr_tab=array();
							$id_producent=0;
														
							reset($kategorie_tab);							
							while(list($key3,$val3)=each($kategorie_tab)){
			
								if($tab[2]==$val3['tytul']){
									$id_kat=$key3;
								}			

								if($tab[3]==$val3['tytul']&&$val3['poziom']==1&&!empty($id_kat)){
									$id_podkat=$key3;
								}		

								if($tab[4]==$val3['tytul']&&$val3['poziom']==2&&!empty($id_podkat)){
									$id_podkat2=$key3;
								}		
																								
								if(!empty($id_kat)&&!empty($id_podkat)&&(empty($tab[4])||!empty($id_podkat2))){
									break;
								}
								
								if($max_nr<$val3['nr_poz']){
									$max_nr=$val3['nr_poz'];
								}
																					
							}		
							
							reset($producenci_tab);							
							while(list($key3,$val3)=each($producenci_tab)){
							
								if($tab[5]==$val3['nazwa']){
									$id_producent=$key3;
									break;
								}
											
							}									
							
							if(!empty($id_d)){
							
								//gdy brak kategorii
								if(empty($id_kat)){
								
									$id_podkat="";
									$max_nr++;								
								
									konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." (id_d,poziom,nr_poz,tytul,autor_id,autor_name,autor_kiedy,status,lang) VALUES ('".$id_d."',0,".$max_nr.",'".tekstForm::doSql($tab[2])."','".user::get()->id()."','".user::get()->nazwa()."',NOW(),1,'".konf::get()->getLang()."')");																												
									$id_kat=konf::get()->_bazasql->insert_id;		
									$kategorie_tab[$id_kat]=konf::get()->_bazasql->pobierzRekord("SELECT tytul,id,poziom,id_d,nr_poz FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." WHERE id='".$id_kat."'");
									$max_nr=1;
									$nowy=true;
								
								}
								
								//gdy jest kategoria ale brak podkategorii
								if(!empty($id_kat)&&(!empty($tab[3])&&empty($id_podkat))){
								
									$max_nr++;
																	
									konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." (id_d,id_matka,id_pierwszy,poziom,nr_poz,tytul,autor_id,autor_name,autor_kiedy,status,lang,typ) VALUES ('".$id_d."','".$id_kat."','".$id_kat."',1,".$max_nr.",'".tekstForm::doSql($tab[3])."','".user::get()->id()."','".user::get()->nazwa()."',NOW(),1,'".konf::get()->getLang()."',1)");	
									$id_podkat=konf::get()->_bazasql->insert_id;	
									$kategorie_tab[$id_podkat]=konf::get()->_bazasql->pobierzRekord("SELECT tytul,id,poziom,id_d,nr_poz FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." WHERE id='".$id_podkat."'");									
									$nowy=true;									
								
								}
								
								//gdy jest kategoria ale brak podkategorii
								if(!empty($id_podkat)&&(!empty($tab[4])&&empty($id_podkat2))){
								
									$max_nr++;
																	
									konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." (id_d,id_matka,id_pierwszy,poziom,nr_poz,tytul,autor_id,autor_name,autor_kiedy,status,lang,typ) VALUES ('".$id_d."','".$id_podkat."','".$id_kat."',2,".$max_nr.",'".tekstForm::doSql($tab[4])."','".user::get()->id()."','".user::get()->nazwa()."',NOW(),1,'".konf::get()->getLang()."',1)");	
									$id_podkat2=konf::get()->_bazasql->insert_id;	
									$kategorie_tab[$id_podkat2]=konf::get()->_bazasql->pobierzRekord("SELECT tytul,id,poziom,id_d,nr_poz FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." WHERE id='".$id_podkat2."'");									
									$nowy=true;									
								
								}								
								
								if(!empty($id_kat)){
																
									$kat_br=$id_kat;
									if(!empty($id_podkat2)){
										$kat_br=$id_podkat2;
									} else if(!empty($id_podkat)){
										$kat_br=$id_podkat;
									}								
							
									//gdy brak producenta
									if(empty($id_producent)){					
										konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'sklep_producenci')." (nazwa,autor_id,autor_name,autor_kiedy,status,lang) VALUES ('".tekstForm::doSql($tab[5])."','".user::get()->id()."','".user::get()->nazwa()."',NOW(),1,'".konf::get()->getLang()."')");	
										$id_producent=konf::get()->_bazasql->insert_id;	
										$producenci_tab[$id_producent]=konf::get()->_bazasql->pobierzRekord("SELECT id,nazwa FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_producenci')." WHERE id='".$id_producent."'");	
										$nowy=true;																		
									}																
						
									if(!$nowy&&konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." WHERE nazwa='".tekstForm::doSql($tab[1])."' AND id_kat='".$kat_br."' AND id_producent='".$id_producent."' AND symbol='".tekstForm::doSql($tab[0])."' AND lang='".konf::get()->getLang()."'")>0){
									
										konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." SET  cena='".tekstForm::doLiczba($tab[6])."' WHERE nazwa='".tekstForm::doSql($tab[1])."' AND id_kat='".$id_kat."' AND id_producent='".$id_producent."' AND symbol='".tekstForm::doSql($tab[0])."' AND lang='".konf::get()->getLang()."'");
										$rekordy['edytowane']++;
										
									} else {
		
										konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." (id_kat,id_producent,symbol,nazwa,cena,autor_id,autor_name,autor_kiedy,status,lang) VALUES ('".$kat_br."','".$id_producent."','".tekstForm::doSql($tab[0])."','".tekstForm::doSql($tab[1])."','".tekstForm::doLiczba($tab[6])."','".user::get()->id()."','".user::get()->nazwa()."',NOW(),1,'".konf::get()->getLang()."')");
										$id_nr=konf::get()->_bazasql->insert_id;	
										$rekordy['dodane']++;		
																
									}
									
								} else {
								
									$rekordy['bledne']++;		
									
								}

							} else {
							
								$rekordy['bledne']++;		
								
							}
							
							
						} else {
						
							$rekordy['bledne']++;		
							
						}
						
					} else {
					
						$rekordy['bledne']++;							
						
					}
														
				} 								
			
				konf::get()->setKomunikat(konf::get()->langTexty("produktyadmin_csvrekordyod")."Rekordów odczytanych: ".$rekordy['odczytane']);
				konf::get()->setKomunikat(konf::get()->langTexty("produktyadmin_csvrekordydo")."Rekordów dodanych: ".$rekordy['dodane']);						
				konf::get()->setKomunikat(konf::get()->langTexty("produktyadmin_csvrekordyed")."Rekordów edytowanych: ".$rekordy['edytowane']);
				konf::get()->setKomunikat(konf::get()->langTexty("produktyadmin_csvrekordybl")."Rekordów błędnych: ".$rekordy['bledne']);				
													
			} else {		
				konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 							
			}

		} else {		
			konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 				
		}
			
	}		
			
		
	/**
   * sklep remove
   */		
	public function dostepnosc(){

		$id_tab=konf::get()->getZmienna('id_tab2','id_tab2');	

	  if(!empty($id_tab)&&is_array($id_tab)){
		
			while(list($key,$val)=each($id_tab)){
	  
				$val=$val+0;
				
				if(!empty($val)){
					$dostepnosc=tekstForm::doLiczba(konf::get()->getZmienna("dostepnosc_".$val));				
					konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." SET dostepnosc_sztuk='".$dostepnosc."' WHERE id='".$val."'");
				}
				
			}
			
			konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");		
			user::get()->zapiszLog("produkty - zmiana dostępności",user::get()->login());					
			
		}

	}			
	
	/**
   * class constructor php5	
   */	
	public function __construct() {	
		
		$this->_admin=konf::get()->getKonfigTab("sklep_konf",'admin_sklep');
		
  }	

		
}

?>