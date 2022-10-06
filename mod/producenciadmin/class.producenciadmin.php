<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

class producenciadmin extends moduladmin {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="producenciadmin class";


	/**
   * sklep arch
   */		
	public function arch(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$szuk_nazwa=konf::get()->getZmienna('szuk_nazwa','szuk_nazwa');
		$sortuj=tekstForm::doSql(konf::get()->getZmienna('sortuj','sortuj'));
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));
		
		$colspan=5;
		$na_str=25;
		
	  $tab_sort=array(
			1=>"id", 2=>"id DESC", 
			5=>"nazwa", 6=>"nazwa DESC", 
			7=>"status", 8=>"status DESC", 
		);
		
    if(empty($sortuj)||empty($tab_sort[$sortuj])){ 
			$sortuj=5; 
		}

		$link="";
		
    $query=" FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_producenci')." WHERE lang='".konf::get()->getLang()."' ";

	  if(!empty($szuk_nazwa)){
	    $link.="&amp;szuk_nazwa=".tekstForm::doLink($szuk_nazwa);
	    $query.=" AND LCASE(nazwa) LIKE '%".tekstForm::doLike($szuk_nazwa)."%' ";
	  }

    $link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"producenciadmin_edytuj","sortuj"=>$sortuj,"podstrona"=>$podstrona)).$link;
    $link3=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"producenciadmin_usun","sortuj"=>$sortuj,"podstrona"=>$podstrona)).$link;		
    $link4=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_arch"));			
    $link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"producenciadmin_arch")).$link;		
		
		$naw = new nawig("SELECT COUNT(id) AS ilosc".$query,$podstrona,$na_str);		
		$naw->naw($link."&amp;sortuj=".$sortuj);
		$podstrona=$naw->getPodstrona();	

		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"arch","arch");		
		echo $form->spr(array(1=>"akcja"),"","ok=spr_akcjau(document.arch.akcja,'producenciadmin_usun','".konf::get()->langTexty("czyusun")."');");
		echo $form->getFormp();
		echo $form->przenies(array("sortuj"=>$sortuj,"szuk_nazwa"=>$szuk_nazwa,"podstrona"=>$podstrona));
			
	  echo tab_nagl(konf::get()->langTexty("producenci_admin")."Lista wydawnictw (".$naw->getWynikow()."):",$colspan);
		
    echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 lewa\">";
		
    //akcje  
		$akcje_tab['producenciadmin_dodaj']=konf::get()->langTexty("adodaj");
		if($naw->getWynikow()>0){			
			$akcje_tab['producenciadmin_aktyw']=konf::get()->langTexty("aaktyw");
			$akcje_tab['producenciadmin_deaktyw']=konf::get()->langTexty("adeaktyw");
			$akcje_tab['producenciadmin_usun']=konf::get()->langTexty("ausun");						
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
		echo interfejs::sortEl($link."&amp;sortuj=",1,2,konf::get()->langTexty("producenci_admin_arch_nr")."id",$sortuj,50);
		echo interfejs::sortEl($link."&amp;sortuj=",5,6,konf::get()->langTexty("producenci_admin_arch_nazwa")."nazwa",$sortuj);
		echo interfejs::sortEl($link."&amp;sortuj=",7,8,konf::get()->langTexty("producenci_admin_arch_status")."status",$sortuj,70);		
		echo interfejs::sortEl("","","",konf::get()->langTexty("producenci_admin_arch_pod")."produkty","",40);		
		echo interfejs::sortEl("","","","","",120);	
    echo "</tr>";

	  //pobieranie danych  
	  $query="SELECT * ".$query." ORDER BY ".$tab_sort[$sortuj]."";
	  $query.=" LIMIT ".$naw->getStart().",".$naw->getIle();
			
	  $i=0;	    
		$dane_ile=array();
		$dane_tab=array();
			
	  $dane_tab=konf::get()->_bazasql->pobierzRekordy($query,"id");

		if(!empty($dane_tab)){
				
			$query2="";
					
			while(list($key,$dane)=each($dane_tab)){
				if(!empty($query2)){
					$query2.=",";
				}
				$query2.=$key;

			}			
				
		  $dane_ile1=konf::get()->_bazasql->pobierzRekordy("SELECT id_producent,COUNT(id) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." WHERE id_producent IN(".$query2.") GROUP BY id_producent","id_producent");

			reset($dane_tab);
				
			while(list($key,$dane)=each($dane_tab)){
				
		  	$i++;
					
	      echo "<tr class=\"srodek\"><td class=\"tlo4 srodek\">";
				echo $form->checkbox("id_tab[]","id_".$dane['id'],$dane['id'],"");	
				echo "<div";
				if($id_nr==$dane['id']){
					echo " class=\"grube\"";
				}
				echo ">".$dane['id']."</div>";
	      echo "</td>";
		        
	      echo "<td class=\"tlo3 lewa\">";
		    echo "<a class=\"grube\" href=\"".$link2."&amp;id_nr=".$dane['id']."\">".$dane['nazwa']."</a>";
				echo "</td>";
				
	      //status  
	      echo "<td class=\"tlo3\">";
	      if($dane['status']==1){ 
					echo konf::get()->langTexty("aktywne"); 
				} else { 
					echo konf::get()->langTexty("nieaktywne"); 
				}
	      echo "</td>";		
				
	      echo "<td class=\"tlo3 srodek\">";
	      if(!empty($dane_ile[$dane['id']]['ile'])){
		    	echo $dane_ile[$dane['id']]['ile'];					
		    } else {
					echo "0";
				}
	      echo "</td>";						

	      echo "<td class=\"tlo3 srodek\">";				
				echo "<table border=\"0\"><tr>";    					
		    echo interfejs::edytuj($link2."&amp;id_nr=".$dane['id']."&amp;akcja=producenciadmin_edytuj&amp;id_nr=".$dane['id']);	
				echo interfejs::przyciskEl("basket",$link4."&amp;szuk_producent=".$dane['id'],konf::get()->langTexty("producenci_admin_produkty")."Produkty");							
				echo interfejs::usun($link3."&amp;id_tab[1]=".$dane['id']); 						
				echo interfejs::infoEl($dane);			
				echo "</tr></table>";   				
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
		echo $form2->przenies(array("akcja"=>"producenciadmin_arch","sortuj"=>$sortuj));	
		
		echo interfejs::label("szuk_nazwa",konf::get()->langTexty("producenci_admin_szuknazwa")."nazwa producenta: ");						
		echo $form2->input("text","szuk_nazwa","szuk_nazwa",$szuk_nazwa,"f_dlugi",150);		
		echo " ";
		echo $form2->input("submit","","",konf::get()->langTexty("szukaj"),"formularz2 f_sredni");		
		echo $form2->getFormk();
		
		echo "</td></tr>";	
		echo tab_stop();		
 
	}

  /**
   * check data exists
   * @param string $nazwa
   * @param int $id
	 * @return bool	
   */		
	protected function istnieje($nazwa,$id=""){

		$ok=true;

		$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_producenci')." WHERE nazwa='".$nazwa."' AND lang='".konf::get()->getLang()."'";
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
		
		$grafika=new zapiszGrafike($id_nr,konf::get()->getKonfigTab("sklep_konf",'producenci_kat'),"pic","img",$dane);
		$grafika->setWszystkie(true);
		$grafika->setImgUsun($img_usun);
		
		$grafika->setDaneImg(1,array(
			"hmax"=>konf::get()->getKonfigTab("sklep_konf",'producent_img_size'),
			"wmax"=>konf::get()->getKonfigTab("sklep_konf",'producent_img_size'),
			"hmin"=>konf::get()->getKonfigTab("sklep_konf",'producent_img_min_size'),
			"wmin"=>konf::get()->getKonfigTab("sklep_konf",'producent_img_min_size'),
			"typy"=>array(2=>2),
			"skala"=>3					
		));
		
		$grafika->setDaneImg(2,array(
			"hmax"=>konf::get()->getKonfigTab("sklep_konf",'producent_img_m_size'),
			"wmax"=>konf::get()->getKonfigTab("sklep_konf",'producent_img_m_size'),
			"hmin"=>konf::get()->getKonfigTab("sklep_konf",'producent_img_min_size'),
			"wmin"=>konf::get()->getKonfigTab("sklep_konf",'producent_img_min_size'),
			"typy"=>array(2=>2),
			"skala"=>konf::get()->getKonfigTab("sklep_konf",'producent_img_skala')					
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
					
		$dane=array(
			"nazwa"=>"",
			"opis"=>"",
			"link"=>"",			
			"status"=>1,		
		);
		
		//testowanie danych z formularza
		
		$testy[]=array("zmienna"=>"status","test"=>"truefalse",
			"param"=>array(
				"wartosc"=>1
			)
		);

		$testy[]=array("zmienna"=>"nazwa","test"=>"wartosc","wymagany"=>true,
			"param"=>array(
				"komunikat"=>konf::get()->langTexty("producenci_admin_arch_nieprawidlowe")."Nieprawidłowa nazwa producenta",
				'idtf'=>"nazwa"			
			)	
		);	
		
		$daneNieczysc[]="opis";		

		//generator zapytania insert/update
		require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
		$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'sklep_producenci'),$dane,$daneNieczysc);
		$sqldane->daneOdczyt();	
		$sqldane->setAutor(true);	
		$sqldane->setTesty($testy);
		
		$sqldane->testuj();	
		
		if($sqldane->ok()){
									
			if(!empty($id_nr)){
			
				$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_producenci')." WHERE id='".$id_nr."'");

				if(empty($dane)){
					$id_nr="";
				}	
					
			}	else {
				$id_nr="";				
			}				
		
			if($this->istnieje($sqldane->getDane('nazwa'),$id_nr)){
					
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
								konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'sklep_producenci')." SET ".$grafika->getSql()." WHERE id='".$id_nr."'");				
							}
																								  
						}						

						user::get()->zapiszLog(konf::get()->langTexty("producenci_admin_arch_sdodaj_log")."dodanie producenta ".$sqldane->getDane("nazwa"),user::get()->login());
						
					} else {
						konf::get()->setAkcja("producenciadmin_dodaj");	
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
					
			    user::get()->zapiszLog(konf::get()->langTexty("producenci_admin_arch_sedycja_log")."edycja producenta ".$sqldane->getDane("nazwa"),user::get()->login());

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
		
		
		if(konf::get()->getAkcja()=="producenciadmin_dodaj2"){
			if(!empty($id_nr)){
				konf::get()->setAkcja("producenciadmin_arch");				
			} else {
				konf::get()->setAkcja("producenciadmin_dodaj");				
			}
		} else if(konf::get()->getAkcja()=="producenciadmin_edytuj2"){	
			konf::get()->setAkcja("producenciadmin_edytuj");					
		} 
				

	}	

	
	/**
   * sklep form
   */		
	protected function formularz(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$sortuj=konf::get()->getZmienna('sortuj','sortuj');		
		$szuk_nazwa=konf::get()->getZmienna('szuk_nazwa','szuk_nazwa');			
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));	

		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"sklep","sklep");		
		
		//domyslne wartosci
		$dane=array(
			"nazwa"=>"",
			"opis"=>"",
			"link"=>"",			
			"status"=>1,		
		);
		
		$dane=$form->odczyt($dane);

		//dla edycji pobierz aktualne dane
		if(!empty($id_nr)){
			$dane2=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_producenci')." WHERE id='".$id_nr."'");
			if(!empty($dane2)){
				$dane=$dane2;	
			} else {
				$id_nr="";
			}
		}

    //jesli wszystko ok to wyswietl formularz
    if(empty($id_nr)){
      echo tab_nagl(konf::get()->langTexty("producenci_admin_form_t")."Dodawanie wydawnictwa",1);  
    } else {
      echo tab_nagl(konf::get()->langTexty("producenci_admin_form_e")."Edycja wydawnicta",1); 
    }

    echo "<tr><td valign=\"top\" class=\"tlo3\">";
	
		echo "<table border=\"0\" style=\"margin-top:5px\"><tr>"; 
		
		if(!empty($id_nr)){
			echo interfejs::edytuj(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"producenciadmin_edytuj","id_nr"=>$dane['id'],"id_nr"=>$dane['id'],"sortuj"=>$sortuj,"podstrona"=>$podstrona,"szuk_nazwa"=>$szuk_nazwa))); 			
			echo interfejs::przyciskEl("basket",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"producenciadmin_produkty","szuk_producent"=>$dane['id'])),konf::get()->langTexty("producenci_admin_produkty")."produkty");
			echo interfejs::infoEl($dane);		  
			echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"producenciadmin_usun","id_tab[]"=>$dane['id'])));
		}
		echo interfejs::przyciskEl("arrow_join",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"producenciadmin_arch","sortuj"=>$sortuj,"podstrona"=>$podstrona,"szuk_nazwa"=>$szuk_nazwa)),konf::get()->langTexty("producenci_admin_powrot")."powrót do listy");

		echo "</tr></table>"; 										
		echo "<br />";		
		
		echo $form->spr(array(1=>"nazwa"));
		$form->setMultipart(true);
		echo $form->getFormp();
		echo $form->przenies(array(
			"id_nr"=>$id_nr,
			"akcja"=>konf::get()->getAkcja()."2",
			"podstrona"=>$podstrona,
			"sortuj"=>$sortuj,
			"szuk_nazwa"=>$szuk_nazwa
		));

    echo "<div>";
		echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");			
		echo "</div><br />";		
				
		echo interfejs::label("nazwa",konf::get()->langTexty("producenci_admin_form_nazwa")."nazwa producenta*:","grube");					
    echo "<br />";
		echo $form->input("text","nazwa","nazwa",$dane['nazwa'],"f_bdlugi",200);	
	 	echo "<br /><br />";
		
		echo interfejs::label("link",konf::get()->langTexty("producenci_admin_form_link")."strona WWW producenta:","grube");					
    echo "<br />";
		echo $form->input("text","link","link",$dane['link'],"f_bdlugi",250);	
	 	echo "<br /><br />";		

		echo interfejs::label("opis",konf::get()->langTexty("producenci_admin_form_opis")."opis:","grube");						
    echo "<br />";		
		$form->fck("opis",$dane['opis']);			
				
		//sekcja dotyczaca uploadu grafiki
		if(konf::get()->getKonfigTab("sklep_konf",'producent_img')){
		
      //zajawka
 	    echo "<br /><br />";
			echo interfejs::label("img",konf::get()->langTexty("producenci_admin_form_obrazek")."logo producenta:","grube blok");			
			echo "<br />";	
					
  		if(!empty($dane['img'])){
			
				echo interfejs::imgPodglad($dane,"img",konf::get()->getKonfigTab("sklep_konf",'producenci_kat'));	

  			echo "<div class=\"nobr\">";
				echo $form->checkbox("img_usun","img_usun",1,"");			
				echo interfejs::label("img_usun",konf::get()->langTexty("usung"),"",true);										
				echo "</div>"; 
				
  		}
			
  	  echo konf::get()->langTexty("producenci_admin_form_grafika")."grafika:";
			echo interfejs::pomocEl(konf::get()->langTexty("producenci_admin_form_himg")."Plik JPG spełniający wymagania co do rozmiarów. Uwaga, pliki JPG w palecie kolorów CMYK są odrzucane. Strony WWW obsługują wyłącznie paletę RGB");																							
			echo "<div>";
			echo $form->input("file","pic","pic","","f_bdlugi");
			echo "</div><br />";

		}							

    echo "<br />";
		echo $form->checkbox("status","status",1,$dane['status']);
		echo interfejs::label("status",konf::get()->langTexty("widoczny"),"nobr",true);							
    echo "<br /><br />";
		
    echo "<div>";
		echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");			
		echo "</div>";
		
    echo "<br /><span class=\"male\">".konf::get()->langTexty("musza")."</span>";
		
		echo $form->getFormk();
		echo "</td></tr>";
      
		echo "<tr class=\"srodek\"><td class=\"tlo4\">".interfejs::linkEl("folder_explore",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"producenciadmin_arch","sortuj"=>$sortuj,"podstrona"=>$podstrona,"szuk_nazwa"=>$szuk_nazwa)),konf::get()->langTexty("producenci_admin_form_listas")."Powrót na listę producentów")."</td></tr>";
		
    echo tab_stop();

	}
	
	/**
   * sklep remove
   */		
	public function usun(){
	
		$this->usunRekordy(konf::get()->getKonfigTab("sql_tab",'sklep_producenci'),konf::get()->getKonfigTab("sklep_konf",'producenci_kat'),2,"img",konf::get()->langTexty("producenci_admin_a_usuwanie_log")."producenci - usuwanie");
	 
	}

	
  /**
   * set active
   */			
	public function aktyw(){
	
		$this->zmienparam("status",1,konf::get()->getKonfigTab("sql_tab",'sklep_producenci'),konf::get()->langTexty("producenci_admin_a_param_log")."producenci - zmiana statusu");
		
	}
	
	
  /**
   * set deactive
   */		
	public function deaktyw(){
	
		$this->zmienparam("status",0,konf::get()->getKonfigTab("sql_tab",'sklep_producenci'),konf::get()->langTexty("producenci_admin_a_param_log")."producenci - zmiana statusu");
		
	}	

	
	/**
   * class constructor php5	
   */	
	public function __construct() {	
		
		$this->_admin=konf::get()->getKonfigTab("sklep_konf",'admin_sklep');
		$this->id_d=konf::get()->getZmienna("id_d",'id_d');
		
  }	

		
}

?>