<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

class sklepadmin extends moduladmin {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="sklepadmin class";

	
	/**
	 * bierzacy dzial
	 */				
  private $id_d="";			

	/**
   * get sklep
   * @param int $id_kat
   * @param bool $lang		
   * @return array
   */			
	public function pobierz($id_kat,$lang=true){

		$dane="";
		
		if(!empty($id_kat)){
	    $sql="SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." WHERE id='".$id_kat."'";
	    if($lang){
	      $sql.=" AND lang='".konf::get()->getLang()."'";
	    }
			$dane=konf::get()->_bazasql->pobierzRekord($sql);
		}
		
		return $dane;
		
	}


	/**
   * sklep stat
   */			
	public function staty(){
	
		$query=" AND lang=".konf::get()->getLang();
		
		$this->statpanel();

		echo tab_nagl("Statystyka sklepu",2);

		echo "<tr class=\"prawa grube\"><td class=\"tlo4\" style=\"width:80%\">Nazwa:</td>";
		echo "<td class=\"tlo4\" style=\"width:20%\">Ilość:</td></tr>";
		
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">Ilość produktów</td>";		
		echo "<td class=\"tlo4 prawa\">";
		echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." WHERE 1".$query);
		echo "</td>";
		echo "</tr>";				
		
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">Ilość kategorii</td>";		
		echo "<td class=\"tlo4 prawa\">";
		echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." WHERE 1".$query);
		echo "</td>";
		echo "</tr>";				
				
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">Ilość producentów</td>";		
		echo "<td class=\"tlo4 prawa\">";
		echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_producenci')." WHERE 1".$query);
		echo "</td>";
		echo "</tr>";		
		
		if(konf::get()->getKonfigTab("sklep_konf",'zliczac_wys')){

			echo "<tr class=\"prawa\">";
			echo "<td class=\"tlo3\">Suma wyświetleń kategorii</td>";		
			echo "<td class=\"tlo4 prawa\">";
			$dane=konf::get()->_bazasql->pobierzRekord("SELECT SUM(licznik) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." WHERE 1 ".$query);
			echo $dane['ile'];
			echo "</td>";
			echo "</tr>";			
			
		}
			
		if(konf::get()->getKonfigTab("sklep_konf",'prod_zliczac_wys')){			
			
			echo "<tr class=\"prawa\">";
			echo "<td class=\"tlo3\">Suma wyświetleń produktów</td>";		
			echo "<td class=\"tlo4 prawa\">";
			$dane=konf::get()->_bazasql->pobierzRekord("SELECT SUM(licznik) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." WHERE 1 ".$query);
			echo $dane['ile'];
			echo "</td>";
			echo "</tr>";					
			
		}			
		
		if(konf::get()->getKonfigTab("sklep_konf",'prod_nowosc')){

			echo "<tr class=\"prawa\">";
			echo "<td class=\"tlo3\">Ilośc produktów oznaczonych jako nowość</td>";		
			echo "<td class=\"tlo4 prawa\">";
			echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." WHERE nowosc=1 ".$query);
			echo "</td>";
			echo "</tr>";					
			
		}	
			
		if(konf::get()->getKonfigTab("sklep_konf",'prod_promocja')){

			echo "<tr class=\"prawa\">";
			echo "<td class=\"tlo3\">Ilośc produktów oznaczonych jako promocja</td>";		
			echo "<td class=\"tlo4 prawa\">";
			echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." WHERE promocja=1 ".$query);
			echo "</td>";
			echo "</tr>";					
			
		}	
								
		if(konf::get()->getKonfigTab("sklep_konf",'prod_wyprzedaz')){

			echo "<tr class=\"prawa\">";
			echo "<td class=\"tlo3\">Ilośc produktów oznaczonych jako wyprzedaż</td>";		
			echo "<td class=\"tlo4 prawa\">";
			echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." WHERE wyprzedaz=1 ".$query);
			echo "</td>";
			echo "</tr>";					
			
		}	
					
		if(konf::get()->getKonfigTab("sklep_konf",'prod_polecamy')){

			echo "<tr class=\"prawa\">";
			echo "<td class=\"tlo3\">Ilośc produktów oznaczonych jako polecamy</td>";		
			echo "<td class=\"tlo4 prawa\">";
			echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." WHERE polecamy=1 ".$query);
			echo "</td>";
			echo "</tr>";					
			
		}	
		
		if(konf::get()->getKonfigTab("sklep_konf",'prod_wyr')){

			echo "<tr class=\"prawa\">";
			echo "<td class=\"tlo3\">Ilośc produktów oznaczonych jako wyróżnione</td>";		
			echo "<td class=\"tlo4 prawa\">";
			echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." WHERE wyr=1 ".$query);
			echo "</td>";
			echo "</tr>";					
			
		}			
				
		if(konf::get()->getKonfigTab("sklep_konf",'prod_glosy')){			
			
			echo "<tr class=\"prawa\">";
			echo "<td class=\"tlo3\">Suma głosów oddanych na produkty</td>";		
			echo "<td class=\"tlo4 prawa\">";
			$dane=konf::get()->_bazasql->pobierzRekord("SELECT SUM(glosy) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." WHERE 1 ".$query);
			echo $dane['ile'];
			echo "</td>";
			echo "</tr>";					
			
		}																
		
		echo tab_stop();
		
	}
	
	
	private function statSklep($tabela,$tytul,$query,$order,$count,$pole){
	
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');	
		$na_str=50;			
		
		$link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>konf::get()->getAkcja()));		
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane"));
		
		$query=" FROM ".$tabela." WHERE lang=".konf::get()->getLang()." ".$query;
				
		$naw = new nawig("SELECT COUNT(id) AS ilosc ".$query,$podstrona,$na_str);
		$naw->naw($link2);
		$podstrona=$naw->getPodstrona();		
		
		$this->statpanel();			
				
		echo tab_nagl($tytul,2);		
		
		if($naw->getNaw()){
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
		}			

		echo "<tr class=\"prawa grube\"><td class=\"tlo4\" style=\"width:80%\">Nazwa:</td>";
		echo "<td class=\"tlo4\" style=\"width:20%\">Ilość:</td></tr>";

		if($naw->getWynikow()>0){
		
			$zap=konf::get()->_bazasql->zap("SELECT  ".$pole." AS nazwa, ".$count." AS ilosc ".$query." ORDER BY ".$order);	

			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){		

				echo "<tr class=\"prawa\">";
				echo "<td class=\"tlo3\">".$dane['nazwa']."</td>";		
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
	
	
	
	public function statkatwys(){
		
		$this->statSklep(konf::get()->getKonfigTab("sql_tab",'sklep_kat'),"Statystyka - najczęściej wyświetlane kategorie","AND licznik>0"," licznik DESC, id DESC",'licznik',"tytul");
			
	}	
	
	
	public function statprodwys(){
		
		$this->statSklep(konf::get()->getKonfigTab("sql_tab",'sklep_produkty'),"Statystyka - najczęściej wyświetlane produkty","AND licznik>0"," licznik DESC, id DESC",'licznik',"nazwa");
			
	}		
	
	
	private function statpanel(){
	
		$table_akcje['sklepadmin_staty']="ogólna";
		$table_akcje['sklepadmin_statkatwys']="wyświetlenia kategorii";
		$table_akcje['sklepadmin_statprodwys']="wyświetlenia produktów";		
									
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
   * sklep poz
   */		
	public function poz(){

	  $typ=konf::get()->getZmienna('typ','typ');
	  $id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));

		if(!empty($typ)&&!empty($id_nr)){			
			
		  $query_d=" AND lang='".konf::get()->getLang()."'";

		  $dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab","sklep_kat")." WHERE id='".$id_nr."' ".$query_d);
		    	
		  if(!empty($dane)){
			
			  $query_d.=" AND id_d='".$dane['id_d']."'";				
			
			  require_once(konf::get()->getKonfigTab("klasy")."class.zmienpoz.php");

				$poz=new zmienPoz($dane['id'],$typ,konf::get()->getKonfigTab("sql_tab","sklep_kat"));
				$poz->setQueryAdd($query_d);				
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
   * paste
   */		
	public function wklej(){

		//element nadrzedny
		$id_kat=tekstForm::doSql(konf::get()->getZmienna('id_kat','id_kat'));
		require_once(konf::get()->getKonfigTab("klasy")."class.wytnijwklej.php");
		
		$poz=new wytnijwklej(konf::get()->getKonfigTab("sql_tab","sklep_kat"),"sklep_wytnij_tab",$this->id_d,true);
		$poz->setPole("poleMatka","id_matka");
		$poz->setPole("polePoz","nr_poz");
		$poz->setPole("polePoziom","poziom");		
		$poz->setPole("poleId","id");
		$poz->setPole("polePierwszy","id_pierwszy");						
		$poz->setPole("poleDzial","id_d");	
		$poz->setDzialy(konf::get()->getKonfigTab("sklep_konf",'d_tab'));	
		$poz->wklej($id_kat);
	  
	}


	/**
   * cut
   */		
	public function wytnij(){
	
	  $id_tab=konf::get()->getZmienna('id_tab','id_tab');		
		require_once(konf::get()->getKonfigTab("klasy")."class.wytnijwklej.php");
		$poz=new wytnijwklej(konf::get()->getKonfigTab("sql_tab","sklep_kat"),"sklep_wytnij_tab",$this->id_d,true);
		$poz->wytnij($id_tab);
		
	}


	/**
   * dzialy arch
   */		
	public function dzialy(){

		$colspan=2;			
		
		$d_tab=konf::get()->getKonfigTab("sklep_konf",'d_tab');
		
		if(!empty($d_tab)&&is_array($d_tab)){
		
			$query="";		
			
			$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_arch"));

			echo tab_nagl(konf::get()->langTexty("sklep_admin_d").count($d_tab)."):",$colspan);
			echo "<tr><td class=\"lewa grube tlo4\">".konf::get()->langTexty("sklep_admin_d_nazwa")."</td><td class=\"prawa grube tlo4\" style=\"width:40px\">".konf::get()->langTexty("sklep_admin_d_ilosc")."</td></tr>";
			
		  while(list($key,$val)=each($d_tab)){
				echo "<tr>";
				echo interfejs::folderEl("<a class=\"blok\" href=\"".$link."&amp;id_d=".$key."\">".$val."</a>","tlo3",1);		
				echo "<td class=\"tlo4 prawa\">".konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." WHERE id_d='".$key."' AND lang='".konf::get()->getLang()."'")."</td>";
				echo "</tr>";			
			}

		  echo tab_stop();
			
	  } else {
	  	echo "<div class=\"brak\">".konf::get()->langTexty("sklep_admin_d_brak")."</div>";
	  }
		
	}


	/**
   * sklep arch
   */		
	public function arch(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');

		//sortowanie
		$sortuj=tekstForm::doSql(konf::get()->getZmienna('sortuj','sortuj'));

		//element nadrzedny
		$id_kat=tekstForm::doSql(konf::get()->getZmienna('id_kat','id_kat'));
		
		//dzial od elementu nadrzednego
		$dane_kat=array();
		if(!empty($id_kat)){
			$dane_kat=$this->pobierz($id_kat,true);
		}

		if(empty($dane_kat)){
			$id_kat="";
		} else {
			//dzial od elementu nadrzednego
			$this->id_d=$dane_kat['id_d'];			
		}
		
		konf::get()->setZmienna("_post","id_d",$this->id_d);					
		
		if(!empty($this->id_d)){
		
			$d_tab=konf::get()->getKonfigTab("sklep_konf",'d_tab');
		
			$colspan=4;
			
	    if(konf::get()->getKonfigTab("sklep_konf",'zliczac_wys')){
	      $colspan++;
	    }
	    
	    //przygotowanie zapytania pobrania danych
	    $tab_sort=array(1=>"nr_poz", 2=>"nr_poz DESC", 5=>"tytul", 6=>"tytul DESC", 7=>"status", 8=>"status DESC", 9=>"licznik", 10=>"licznik DESC");
	    if(empty($sortuj)||empty($tab_sort[$sortuj])){ 
				$sortuj=1; 
			}

	    $query=" FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." WHERE lang='".konf::get()->getLang()."' ";
	    $query.=" AND id_matka='".$id_kat."' "; 
	    $query.=" AND id_d='".$this->id_d."' ";

			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"arch","arch");
			echo $form->spr(array(1=>"akcja"),"","ok=spr_akcjau(document.arch.akcja,'sklepadmin_usun','".konf::get()->langTexty("czyusun")."');");
			echo $form->getFormp();
			echo $form->przenies(array("sortuj"=>$sortuj,"id_kat"=>$id_kat,"id_d"=>$this->id_d,"podstrona"=>$podstrona));

	    //sciezki do linkow
	    $link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_arch","id_kat"=>$id_kat, "id_d"=>$this->id_d));
	    $link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_arch","sortuj"=>$sortuj, "id_d"=>$this->id_d));
	    $link3=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklep_zobacz"));
	    $link4=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_d"=>$this->id_d, "id_kat"=>$id_kat,"sortuj"=>$sortuj));
	    $link6=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_arch","id_d"=>$this->id_d));
	    $link7=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_d"=>$this->id_d,"sortuj"=>$sortuj));		
		
	    //nawigator;
			$this->sciezka();    
			
			$naw = new nawig("SELECT COUNT(id) AS ilosc".$query,$podstrona,konf::get()->getKonfigTab("sklep_konf",'sklep_na_str'));		
			$naw->naw($link."&amp;sortuj=".$sortuj);
			$podstrona=$naw->getPodstrona();			
	    
	    //naglowek
	    echo tab_nagl(konf::get()->langTexty("sklep_admin_arch").$naw->getIle()."):",$colspan);
			
			$this->naglowekKat($dane_kat,$colspan,false,$id_kat="");

	    echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 lewa\">";
			
	    //akcje  
			$akcje_tab['sklepadmin_dodaj']=konf::get()->langTexty("adodaj");
			
			if($naw->getWynikow()>0){				
				$akcje_tab['sklepadmin_wytnij']=konf::get()->langTexty("awytnij");
			}
	    if(konf::get()->getZmienna('','','sklep_wytnij_tab')){
				$akcje_tab['sklepadmin_wklej']=konf::get()->langTexty("awklej");		
	    }   
			if($naw->getWynikow()>0){				
				$akcje_tab['sklepadmin_aktyw']=konf::get()->langTexty("aaktyw");
				$akcje_tab['sklepadmin_deaktyw']=konf::get()->langTexty("adeaktyw");
				$akcje_tab['sklepadmin_usun']=konf::get()->langTexty("ausun");			
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

			echo interfejs::sortEl($link."&amp;sortuj=",1,2,konf::get()->langTexty("sklep_admin_arch_nr"),$sortuj,70);
			echo interfejs::sortEl($link."&amp;sortuj=",5,6,konf::get()->langTexty("sklep_admin_arch_tyt"),$sortuj);
			echo interfejs::sortEl($link."&amp;sortuj=",7,8,konf::get()->langTexty("sklep_admin_arch_status"),$sortuj,70);		
	    if(konf::get()->getKonfigTab("sklep_konf",'zliczac_wys')){
				echo interfejs::sortEl($link."&amp;sortuj=",9,10,konf::get()->langTexty("sklep_admin_arch_licznik"),$sortuj,50);		
	    }
			echo interfejs::sortEl("","","",konf::get()->langTexty("sklep_admin_arch_pod"),"",40);		

	    echo "</tr>";

	    //pobieranie danych  
	    $query="SELECT * ".$query." ORDER BY ".$tab_sort[$sortuj].",id";
	    $query.=" LIMIT ".$naw->getStart().",".$naw->getIle();
			
	    $i=0;	    
			$dane_ile0=array();
			$dane_ile1=array();			
			$dane_tab=array();
			
	    $dane_tab=konf::get()->_bazasql->pobierzRekordy($query,"id");
			$ile=count($dane_tab);

			if(!empty($dane_tab)){
				
				$query2="";
				$query3="";				
				
				while(list($key,$dane)=each($dane_tab)){
					if(!empty($query2)){
						$query2.=",";
					}
					$query2.=$key;

				}			
				
		    $dane_ile0=konf::get()->_bazasql->pobierzRekordy("SELECT id_matka,COUNT(id) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." WHERE id_matka IN(".$query2.") GROUP BY id_matka","id_matka");
		    $dane_ile1=konf::get()->_bazasql->pobierzRekordy("SELECT id_kat,COUNT(id) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." WHERE id_kat IN(".$query2.") GROUP BY id_kat","id_kat");

				reset($dane_tab);
				
				while(list($key,$dane)=each($dane_tab)){
				
		      $i++;
		      echo "<tr><td class=\"tlo3 lewa\" colspan=\"".$colspan."\">";
					echo interfejs::wstaw($link4."&amp;akcja=sklepadmin_dodaj&amp;id_nad=".$dane['id']."&amp;podstrona=".$podstrona);			
					echo "</td></tr>";
					
		      echo "<tr class=\"srodek\"><td class=\"tlo4 srodek\">";

					echo $form->checkbox("id_tab[]","id_".$dane['id'],$dane['id'],"");	
					
		      echo "<div class=\"male\">".$dane['nr_poz']."(".$dane['id'].")</div>";					

		      echo "</td>";
		        
		      echo "<td class=\"tlo3 lewa\">";
			    echo "<a href=\"".$link2."&amp;id_kat=".$dane['id']."\">".$dane['tytul']."</a>";

					echo "<div><table border=\"0\" style=\"margin-top:5px\"><tr>";    
					
			    echo interfejs::edytuj($link7."&amp;id_kat=".$dane['id']."&amp;akcja=sklepadmin_edytuj&amp;id_nr=".$dane['id']);
			    echo interfejs::przyciskEl("folder_wrench",$link7."&amp;id_kat=".$dane['id']."&amp;akcja=sklepadmin_konfigedytuj&amp;id_nr=".$dane['id'],konf::get()->langTexty("sklep_admin_arch_edytujk")); 
		      if($dane['typ']==1){		
						echo interfejs::przyciskEl("basket",$link6."&amp;id_kat=".$dane['id'],konf::get()->langTexty("sklep_admin_edycjatresci"));						
					}			
			    echo interfejs::podglad($link3."&amp;id_kat=".$dane['id']); 
					echo interfejs::pozycja($link4."&amp;akcja=sklepadmin_poz&amp;id_nr=".$dane['id'],$i,$ile,$podstrona,$naw->getStron());
					echo interfejs::infoEl($dane);			

					echo "</tr></table></div>";   
					
		      echo "</td>";
		      
		      //status  
		      echo "<td class=\"tlo3\">";
		      if($dane['status']==1){ 
						echo konf::get()->langTexty("aktywne"); 
					} else { 
						echo konf::get()->langTexty("nieaktywne"); 
					}
		      echo "</td>";
		      
		      //licznik ogladalnosci
		      if(konf::get()->getKonfigTab("sklep_konf",'zliczac_wys')){
		        echo "<td class=\"tlo3\">".$dane['licznik']."</td>";
		      }
					
		      echo "<td class=\"tlo3 srodek\">";
					
					$ile_podstron=0;
					
		      if($dane['typ']==1&&!empty($dane_ile1[$dane['id']]['ile'])){
			    	$ile_podstron=$dane_ile1[$dane['id']]['ile'];					
			    } else if(!empty($dane_ile0[$dane['id']]['ile'])){
			    	$ile_podstron=$dane_ile0[$dane['id']]['ile'];
			    }
		      if(!empty($ile_podstron)){
		      	echo $ile_podstron;      
		      } else {
						echo "<table class=\"srodek\" border=\"0\"><tr>"; 			
						echo interfejs::usun($link4."&amp;podstrona=".$podstrona."&amp;sortuj=".$sortuj."&amp;akcja=sklepadmin_usun&amp;id_tab[1]=".$dane['id']); 
						echo "</tr></table>";
			    }
		      echo "</td>";
					
		      echo "</tr>";
					
		    }
				
			}
				
			if($podstrona==$naw->getStron()){
	      echo "<tr><td class=\"tlo3 lewa\" colspan=\"".$colspan."\">";
				echo interfejs::wstaw($link4."&amp;akcja=sklepadmin_dodaj&amp;podstrona=".$podstrona);
				echo "</td></tr>";		
			}

	    if($i==0){
				echo interfejs::brak($colspan);			 
	    }
	    
			if($naw->getNaw()){
				echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
			}	
			
			echo "<tr class=\"srodek\"><td colspan=\"".$colspan."\" class=\"tlo4\">";
			if(!empty($dane_kat)){
				echo interfejs::linkEl("folder_explore",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_arch","id_kat"=>$dane_kat['id_matka'],"id_d"=>$this->id_d)),konf::get()->langTexty("poziomdogory"));			
			} else {
				echo interfejs::linkEl("folder_explore",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_dzialy")),konf::get()->langTexty("sklep_admin_arch_kategorie"));
			}
			echo "</td></tr>";

	    echo tab_stop();
	    echo $form->getFormk();
			
	  } else {
	  	echo "<div class=\"brak\">".konf::get()->langTexty("sklep_admin_arch_nied")."</div>";
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
		);
		
		$daneNieczysc=array();

		$testy[]=array("zmienna"=>"description","test"=>"usunwiersz");	
		$testy[]=array("zmienna"=>"keywords","test"=>"usunwiersz");			
		$testy[]=array("zmienna"=>"idtf_link","test"=>"oczysc",
			"param"=>array(
				"znak"=>"-"
			)	
		);	
					
		//sprawdzamy strone nadrzedna zeby ustalic poziom w strukturze	
		if(!empty($id_nr)){
			$daneodczyt=$this->pobierz($id_nr);		
		}
		
		//pobieramy aktualne dane 
		if(!empty($dane)){
		
			//generator zapytania insert/update
			require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
			$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'sklep_kat'),$dane,$daneNieczysc);
			$sqldane->daneOdczyt();	
			$sqldane->setAutor(true);	
			$sqldane->setTesty($testy);			
			$sqldane->dodajDaneE();						
						
			$this->id_d=$daneodczyt['id_d'];
			konf::get()->setZmienna("_post","id_d",$this->id_d);			
			
			$sqldane->dodaj(" WHERE id='".$id_nr."'");	
			
			//wykonaj zapytanie
			if($sqldane->getSql()){
			
				konf::get()->_bazasql->zap($sqldane->getSql());
			  user::get()->zapiszLog(konf::get()->langTexty("sklep_admin_arch_sedycja_log")." ".$daneodczyt['tytul'],user::get()->login());
				konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");

			} else { 
				konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
			}
			
		} else { 
			konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
		}

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
		
		$grafika=new zapiszGrafike($id_nr,konf::get()->getKonfigTab("sklep_konf",'sklep_kat'),"pic","img",$dane);
		$grafika->setWszystkie(true);
		$grafika->setImgUsun($img_usun);
		
		$grafika->setDaneImg(1,array(
			"hmax"=>konf::get()->getKonfigTab("sklep_konf",'img_size'),
			"wmax"=>konf::get()->getKonfigTab("sklep_konf",'img_size'),
			"hmin"=>konf::get()->getKonfigTab("sklep_konf",'img_min_size'),
			"wmin"=>konf::get()->getKonfigTab("sklep_konf",'img_min_size'),
			"typy"=>array(2=>2),
			"skala"=>3					
		));
		
		$grafika->setDaneImg(2,array(
			"hmax"=>konf::get()->getKonfigTab("sklep_konf",'img_m_size'),
			"wmax"=>konf::get()->getKonfigTab("sklep_konf",'img_m_size'),
			"hmin"=>konf::get()->getKonfigTab("sklep_konf",'img_min_size'),
			"wmin"=>konf::get()->getKonfigTab("sklep_konf",'img_min_size'),
			"typy"=>array(2=>2),
			"skala"=>konf::get()->getKonfigTab("sklep_konf",'img_skala')					
		));			

		$grafika->wykonaj();	
		
		return $grafika;		
	
	}
	
	
  /**
   * check data exists
   * @param string $nazwa
   * @param int $id_matka		
   * @param int $id
	 * @return bool	
   */		
	public function istnieje($nazwa,$id_matka,$id_d="",$id=""){

		$ok=true;

		$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." WHERE tytul='".$nazwa."' AND id_matka='".$id_matka."' AND id_d='".$id_d."' AND lang='".konf::get()->getLang()."'";
		if(!empty($id)){
			$query.=" AND id!='".$id."'";
		}
		
		if(konf::get()->_bazasql->policz("id",$query)>0){
			$ok=false;
		}
		
		return $ok;	
		
	}
	

	/**
   * sklep save
   */		
	protected function zapisz(){

		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr',"id_nr"));		
		$id_kat=tekstForm::doSql(konf::get()->getZmienna('id_kat'));
		$id_nad=tekstForm::doSql(konf::get()->getZmienna('id_nad'));
					
		$dane=array(
			"tytul"=>"",
			"tytul_menu"=>"",
			"podtytul"=>"",
			"id_d"=>$this->id_d,
			"data_start"=>date("Y-m-d H:i:s"),
			"data_stop"=>"",
			"licznik"=>"0",
			"typ"=>1,
			"menu_wyr"=>0,
			"status"=>1,		
		);
		
		//testowanie danych z formularza
		
		$testy[]=array("zmienna"=>"status","test"=>"truefalse",
			"param"=>array(
				"wartosc"=>1
			)
		);
		
		$testy[]=array("zmienna"=>"typ","test"=>"truefalse",
			"param"=>array(
				"wartosc"=>1
			)
		);		
		
		$testy[]=array("zmienna"=>"menu_wyr","test"=>"truefalse",
			"param"=>array(
				"wartosc"=>0
			)
		);		
				
		$d_tab=konf::get()->getKonfigTab("sklep_konf",'d_tab');		
		$testy[]=array("zmienna"=>"id_d","test"=>"wtablicyi",
			"param"=>array(
				"wartosci"=>$d_tab,
				"domyslny"=>""
			)
		);	
		
		$testy[]=array("zmienna"=>"id_d","test"=>"wartosc","wymagany"=>true,
			"param"=>array(
				"komunikat"=>konf::get()->langTexty("sklep_admin_arch_nieprawidlowe"),
				'idtf'=>"id_d"
			)	
		);	
		
		$testy[]=array("zmienna"=>"tytul","test"=>"wartosc","wymagany"=>true,
			"param"=>array(
				"komunikat"=>konf::get()->langTexty("sklep_admin_arch_nieprawidlowe"),
				'idtf'=>"tytul"			
			)	
		);	

		//generator zapytania insert/update
		require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
		$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'sklep_kat'),$dane);
		$sqldane->daneOdczyt();	
		$sqldane->setAutor(true);	
		$sqldane->setTesty($testy);
		
		$sqldane->testuj();	
		
		if($sqldane->ok()){
		
			if($this->istnieje($sqldane->getDane('tytul'),$id_kat,$this->id_d,$id_nr)){
			
				// dodawanie 
				if(empty($id_nr)){
				
					//sprawdzamy strone nadrzedna zeby ustalic poziom w strukturze	
					$poziom=0;	
					$id_pierwszy=0;					
					
					if(!empty($id_kat)){
						$dane2=$this->pobierz($id_kat);		
						if(!empty($dane2)){
							$poziom=$dane2['poziom']+1;
							$this->id_d=$dane2['id_d'];
							if($dane2['poziom']==0){
								$id_pierwszy=$dane2['id'];
							} else {
								$id_pierwszy=$dane2['id_pierwszy'];						
							}
						} else {
							$id_kat=0;
						}		
					}	else {
						$id_kat=0;
					}

					//dodaj dane zo zapytania
				 	$sqldane->setDane(array(
						"lang"=>konf::get()->getLang(),
				 		"id_matka"=>$id_kat,
				 		"id_pierwszy"=>$id_pierwszy,					
				 		"poziom"=>$poziom,
						"id_d"=>$this->id_d
					));		
					
					//numer porzadkowy			
					$sqldane->setQueryAdd(" AND lang='".konf::get()->getLang()."'");				
					$sqldane->setMatka($id_kat);			
					$sqldane->setNad($id_nad);	
					$sqldane->setPoleMatka("id_matka");				
					$sqldane->setPoleId("id");
					$sqldane->setPolePoz("nr_poz");				
					$sqldane->dodajPoz();			
					
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
								konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." SET ".$grafika->getSql()." WHERE id='".$id_nr."'");				
							}
																								  
						}						

						//jesli dodany pomiedzy to przesun kolejne elementy						
						$sqldane->ustawPoz();					
						
						user::get()->zapiszLog(konf::get()->langTexty("sklep_admin_arch_sdodaj_log")." ".$sqldane->getDane("tytul"),user::get()->login());
						
					} else {
						konf::get()->setAkcja("sklepadmin_dodaj");	
					}
					
					konf::get()->setZmienna("_post","id_kat",$id_kat);				
					
				} else {
				
					$dane=$this->pobierz($id_nr);

					if(!empty($dane)){
					
						$this->id_d=$dane['id_d'];

						//jezeli byl newsem a ma byc czyms innym
						if($dane['typ']==1&&$dane['typ']!=$sqldane->getDane("typ")){
						
							//nie moze zawierac newsow
							if(konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_produkty')." WHERE id_matka='".$id_nr."'")>0){
								$sqldane->setDane(array("typ"=>2));	
								konf::get()->setKomunikat(konf::get()->langTexty("sklep_admin_arch_elgrupn"),"error"); 
							}
							
						} else if($dane['typ']!=2&&$sqldane->getDane("typ")==2){
						
							//nie moze zawierac podstron
							if(konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." WHERE id_matka='".$id_nr."'")>0){
								$sqldane->setDane(array("typ"=>1));							
								konf::get()->setKomunikat(konf::get()->langTexty("sklep_admin_arch_elgrupa"),"error"); 
							}			
							
						}		

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
						
				    user::get()->zapiszLog(konf::get()->langTexty("sklep_admin_arch_sedycja_log")." ".$sqldane->getDane("tytul"),user::get()->login());
						
					} else {
						$id_nr="";
					}
					
					konf::get()->setZmienna("_post","id_kat",$id_nr);				
					
				}

				if(!empty($id_nr)){			
					konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");
				} else { 
					konf::get()->setKomunikat(konf::get()->langTexty("niezapisane"),"error"); 
				} 
				
			} else { 
				konf::get()->setKomunikat(konf::get()->langTexty("istnieje"),"error"); 
			}			
			
			if($sqldane->getDane("typ")==1){
				//konf::get()->setZmienna("_post","id_kat",$id_nr);				
			}
			
		} else {
		
			if(!empty($id_nr)){
				konf::get()->setAkcja("sklepadmin_edytuj");	
			} else {
				konf::get()->setAkcja("sklepadmin_dodaj");	
			}		

		}
		
		if(konf::get()->getAkcja()=="sklepadmin_edytuj2"){			
			konf::get()->setAkcja("sklepadmin_edytuj");					
		} else if(empty($id_nr)){
			konf::get()->setAkcja("sklepadmin_dodaj");			
		} else {
			konf::get()->setAkcja("sklepadmin_arch");	
		}		
		
		konf::get()->setZmienna("_post","id_d",$this->id_d);		

	}	

	
	public function sciezka(){

		$id_kat=tekstForm::doSql(konf::get()->getZmienna('id_kat','id_kat'));	

		$link="";
		
		$akcja2="sklepadmin_arch";
		$akcja3="produktyadmin_arch";

		if(!empty($id_kat)){
			$id=$id_kat;
			while($id!=0){
				$dane=$this->pobierz($id,true);
				if(!empty($dane)){
					if(!empty($dane['typ'])&&$dane['typ']==1){
						$link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>$akcja3,"id_d"=>$this->id_d));
					} else {
						$link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>$akcja2,"id_d"=>$this->id_d));
					}				
					$this->id_d=$dane['id_d'];
					$link=" &gt; <a href=\"".$link2."&amp;sklep_d=".$this->id_d."&amp;id_kat=".$id."\">".$dane['tytul']."</a>".$link;
					$id=$dane['id_matka'];
				} else {
					break;
				}
			}
		}

		$d_tab=konf::get()->getKonfigTab("sklep_konf",'d_tab');
		
		if(!empty($this->id_d)&&!empty($d_tab[$this->id_d])){	
			$link="<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_arch","id_d"=>$this->id_d))."\">".$d_tab[$this->id_d]."</a>".$link;
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
   * sklep konfig form
   */		
	public function konfigedytuj(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));	

		//domyslne wartosci
		$dane=array(
			"idtf_link"=>"",
			"description"=>"",
			"keywords"=>"",
			"title"=>"",
		);

		//dla edycji pobierz aktualne dane
		$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." WHERE id='".$id_nr."'");
		
		if(!empty($id_nr)&&!empty($dane)){
		
			$this->id_d=$dane['id_d'];
		
			$this->sciezka();
			
	    //jesli wszystko ok to wyswietl formularz  
	    echo tab_nagl(konf::get()->langTexty("sklep_admin_konfig_form"),1); 
			
			$this->naglowekKat($dane,1,true);					

	    echo "<tr><td valign=\"top\" class=\"tlo3\">";

		
			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"sklep","sklep");
			$form->setMultipart(false);			
			echo $form->getFormp();
			echo $form->przenies(array(
				"id_nr"=>$id_nr,
				"id_kat"=>$dane['id_matka'],
				"id_d"=>$this->id_d,				
				"akcja"=>konf::get()->getAkcja()."2",
				"podstrona"=>$podstrona
			));
			
	    echo "<div>";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");
			echo "</div><br />";						
					
		  echo "<div>";
			echo interfejs::label("idtf_link",konf::get()->langTexty("sklep_admin_form_idtflink"),"grube");				
			echo interfejs::pomocEl(konf::get()->langTexty("sklep_admin_form_hidtflink"));
			echo "</div>";
			echo $form->input("text","idtf_link","idtf_link",$dane['idtf_link'],"f_bdlugi",100);
			echo "<br /><br />";
						
			echo "<div>";
			echo interfejs::label("description",konf::get()->langTexty("sklep_admin_form_description"),"grube");
			echo interfejs::pomocEl(konf::get()->langTexty("sklep_admin_form_hdescription"));
			echo "</div>";
			echo $form->textarea("description","description",$dane['description'],"f_bdlugi",5);	
			echo "<br />";
			echo $form->skrocTxt("description",250);
			echo "<br />";
			
			echo "<div>";
			echo interfejs::label("keywords",konf::get()->langTexty("sklep_admin_form_keywords"),"grube");						
			echo interfejs::pomocEl(konf::get()->langTexty("sklep_admin_form_hkeywords"));
			echo "</div>";
			echo $form->textarea("keywords","keywords",$dane['keywords'],"f_bdlugi",5);	
			echo "<br />";
			echo $form->skrocTxt("keywords",250);
			echo "<br />";
			
		  echo "<div>";
			echo interfejs::label("title",konf::get()->langTexty("sklep_admin_form_title"),"grube");
			echo "</div>";
			echo $form->input("text","title","title",$dane['title'],"f_bdlugi",200);
			echo "<br /><br />";			
										
	    echo "<div>";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");
			echo "</div>";
	    
			echo $form->getFormk();
			
			echo "</td></tr>";
	      
			echo "<tr class=\"srodek\"><td class=\"tlo4\">";
			echo interfejs::linkEl("folder_explore",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_arch","id_kat"=>$dane['id_matka'],"id_d"=>$this->id_d)),konf::get()->langTexty("sklep_admin_form_listas"));
			echo "</td></tr>";
			
	    echo tab_stop();
			
	  } else {
			echo interfejs::nieprawidlowe();
	  }
		
	}

	
	private function naglowekKat($dane,$colspan,$edycja=true,$id_kat=""){

		$d_tab=konf::get()->getKonfigTab("sklep_konf",'d_tab');	
	
    echo "<tr><td class=\"tlo4 lewa\" colspan=\"".$colspan."\"><table border=\"0\" cellspacing=\"0\" cellpadding=\"2\" class=\"seta\"><tr valign=\"middle\">";
		
		if(!empty($dane['id'])){

	    echo "<td class=\"seta\">";
									
	    if($edycja){
				echo "<a class=\"grube\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_edytuj","id_nr"=>$dane['id'],"id_d"=>$this->id_d,"id_kat"=>$dane['id']))."\">";			
				echo "<img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/ikony/pencil.gif\" alt=\"\" class=\"lewa\" style=\"margin-right:2px\" />";
				echo $dane['tytul'];					
				echo "</a>";							
			} else {			
				echo "<div class=\"grube\">";	
				echo $dane['tytul'];									
				echo "</div>";											
			}		
							
	    echo "</td>";

			
			echo interfejs::edytuj(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_edytuj","id_nr"=>$dane['id'],"id_d"=>$this->id_d,"id_kat"=>$dane['id']))); 		
		  echo interfejs::przyciskEl("folder_wrench",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_konfigedytuj","id_nr"=>$dane['id'],"id_d"=>$this->id_d,"id_kat"=>$dane['id'])),konf::get()->langTexty("sklep_admin_arch_edytujk")); 			
			if($dane['typ']==1){
				echo interfejs::przyciskEl("basket",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_arch","id_d"=>$this->id_d,"id_kat"=>$dane['id'])),konf::get()->langTexty("sklep_admin_produkty")."produkty");
			}
			echo interfejs::podglad(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklep_zobacz","id_kat"=>$dane['id'],"id_d"=>$this->id_d)));
			echo interfejs::infoEl($dane);		  
			echo interfejs::przyciskEl("arrow_join",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_arch","id_d"=>$this->id_d,"id_kat"=>$dane['id_matka'])),konf::get()->langTexty("poziomdogory"));		

		} else {
				
			if(!$edycja){
			
				echo "<td class=\"lewa seta\">";

	  	  if(!empty($d_tab[$this->id_d])){
				
		      echo "<div class=\"grube\">";
					echo "<img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/ikony/folder.gif\" alt=\"\" class=\"lewa\" style=\"margin-right:2px\" />";				
					echo $d_tab[$this->id_d];
					echo "</div>";	

		    }	
				echo "</td>";					
			
			}		
			
			
	   	if(!empty($dane)&&!empty($dane['id_matka'])){
				echo interfejs::przyciskEl("arrow_join",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_arch","id_kat"=>$dane['id_matka'],"id_d"=>$dane['id_d'])),konf::get()->langTexty("poziomdogory"));
	   	} else if(!empty($dane)){
				echo interfejs::przyciskEl("arrow_join",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_arch","id_d"=>$dane['id_d'])),konf::get()->langTexty("poziomdogory"));
			} else {
				echo interfejs::przyciskEl("arrow_join",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_dzialy")),konf::get()->langTexty("poziomdogory"));
			}			

		}
		
    echo "</tr></table></td></tr>";				
	
	}	
	

	/**
   * sklep form
   */		
	protected function formularz(){

		$sortuj=konf::get()->getZmienna('sortuj','sortuj');	
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));	

		//kat nadrzedny
		$id_kat=tekstForm::doSql(konf::get()->getZmienna('id_kat','id_kat'));
		
	  //kat rownorzedny, w kolejnosci nastepny
		$id_nad=tekstForm::doSql(konf::get()->getZmienna('id_nad','id_nad'));		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"sklep","sklep");		
		
		//domyslne wartosci
		$dane=array(
			"tytul"=>"",
			"tytul_menu"=>"",
			"podtytul"=>"",
			"id_d"=>$this->id_d,
			"data_start"=>date("Y-m-d H:i"),
			"data_stop"=>"",
			"licznik"=>"0",
			"typ"=>1,
			"menu_wyr"=>0,
			"status"=>1,		
		);
		
		$dane=$form->odczyt($dane);

		//dla edycji pobierz aktualne dane
		if(!empty($id_nr)){
			$dane2=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." WHERE id='".$id_nr."'");
			if(!empty($dane2)){
				$dane=$dane2;	
				$this->id_d=$dane['id_d'];
			} else {
				$id_nr="";
			}
		}

		if($id_nr!=''||$this->id_d!=''){
		
			$this->sciezka();
			
	    //jesli wszystko ok to wyswietl formularz
	    if(empty($id_nr)){
	      echo tab_nagl(konf::get()->langTexty("sklep_admin_form_t"),1);  
	    } else {
	      echo tab_nagl(konf::get()->langTexty("sklep_admin_form_e"),1); 
	    }
			
			if(!empty($id_nr)){
				$this->naglowekKat($dane,1,false,$id_nr);					
			} else {
				$this->naglowekKat($dane,1,false,$id_kat);					
			}			

	    echo "<tr><td valign=\"top\" class=\"tlo3\">";
	
			
			echo $form->spr(array(1=>"tytul"));
			$form->setMultipart(true);
			echo $form->getFormp();
			echo $form->przenies(array("id_nr"=>$id_nr,"id_kat"=>$id_kat,"id_nad"=>$id_nad,"akcja"=>konf::get()->getAkcja()."2","podstrona"=>$podstrona,"sortuj"=>$sortuj));

	    echo "<div>";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");
			echo "</div><br />";			
			
	    //od kiedy wyswietlać
			echo $form->kalendarz("data_start","trigger_b",$dane['data_start'],true);
			echo interfejs::label("data_start",konf::get()->langTexty("sklep_admin_form_datastart"),"grube",true);			
			echo "<br />";
	        
	    //do kiedy wyswietlać
			echo $form->kalendarz("data_stop","trigger_c",$dane['data_stop'],true,true);
			echo interfejs::label("data_stop",konf::get()->langTexty("sklep_admin_form_dataw"),"grube",true);							
			echo "<br /><br />";
			
			echo interfejs::label("tytul",konf::get()->langTexty("sklep_admin_form_tytul"),"grube");
	    echo "<br />";
			echo $form->input("text","tytul","tytul",$dane['tytul'],"f_bdlugi",200);	
		 	echo "<br /><br />";
			
			echo interfejs::label("tytul_menu",konf::get()->langTexty("sklep_admin_form_tytulz"),"grube");
			echo interfejs::pomocEl(konf::get()->langTexty("sklep_admin_form_htytulz"));		
			echo "<br />";
			echo $form->input("text","tytul_menu","tytul_menu",$dane['tytul_menu'],"f_bdlugi",200);		
			echo "<br /><br />";
			
			echo interfejs::label("podtytul",konf::get()->langTexty("sklep_admin_form_podtytul"),"grube");
			echo "<br />";
			echo $form->textarea("podtytul","podtytul",$dane['podtytul'],"f_bdlugi",5);	
			echo "<br />";				
			
			//sekcja dotyczaca uploadu grafiki
			if(konf::get()->getKonfigTab("sklep_konf",'img')){
			
	      //zajawka
	 	    echo "<br />";
				echo interfejs::label("pic",konf::get()->langTexty("sklep_admin_form_obrazek")."obrazek kategorii:","grube blok");							
				echo "<br />";	
						
	  		if(!empty($dane['img'])){
				
					echo interfejs::imgPodglad($dane,"img",konf::get()->getKonfigTab("sklep_konf",'sklep_kat'));	

	  			echo "<div>";
					echo $form->checkbox("img_usun","img_usun",1,"");			
					echo interfejs::label("img_usun",konf::get()->langTexty("usung"),"nobr",true);												
					echo "</div>"; 
					
	  		}
				
	  	  echo konf::get()->langTexty("sklep_admin_form_grafika");
				echo interfejs::pomocEl(konf::get()->langTexty("sklep_admin_form_himg"));																							
				echo "<div>";
				echo $form->input("file","pic","pic","","f_bdlugi");
				echo "</div><br />";

			}							

	    //dzial
			$d_tab=konf::get()->getKonfigTab("sklep_konf",'d_tab');			
			
	    if(empty($id_nr)&&!empty($d_tab)&&is_array($d_tab)){	
	      echo "<br />";
				echo interfejs::label("img_usun",konf::get()->langTexty("sklep_admin_form_dzial"),"grube blok");										
				echo "<br />";				
				echo $form->select("id_d","id_d",$d_tab,$dane['id_d'],"f_bdlugi");
	      echo "<br /><br />";
	    } else {
				echo $form->input("hidden","id_d","id_d",$dane['id_d']);			
			}
			
	    if(konf::get()->getKonfigTab("sklep_konf",'zliczac_wys')){
				echo $form->input("text","licznik","licznik",$dane['licznik'],"f_krotki",10);			
				echo interfejs::label("licznik",konf::get()->langTexty("sklep_admin_form_licznik"),"nobr",true);
				echo interfejs::pomocEl(konf::get()->langTexty("sklep_admin_form_hlicznik"));
				echo "<br />";
	    }		
			
	    echo "<div>";
			echo $form->checkbox("typ","typ",1,$dane['typ']);
			echo interfejs::label("typ",konf::get()->langTexty("sklep_admin_form_typ")."kategoria zawierająca produkty","nobr",true);	
			echo interfejs::pomocEl(konf::get()->langTexty("sklep_admin_form_htyp")."Niezaznaczenie tej opcji oznacza, że kategoria służy tylko do podziału na podkategorie w menu a sama nie zawiera przypisanych bezpośrednio produktów");			
			echo "</div><br />";						

	    echo "<div>";
			echo $form->checkbox("menu_wyr","menu_wyr",1,$dane['menu_wyr']);
			echo interfejs::label("menu_wyr",konf::get()->langTexty("sklep_admin_form_wyr")."wyróżnij w menu","nobr",true);							
	    echo "</div><br />";
			
	    echo "<div><br />";
			echo $form->checkbox("status","status",1,$dane['status']);
			echo interfejs::label("status",konf::get()->langTexty("widoczny"),"nobr",true);								
	    echo "</div><br />";
			
	    echo "<div>";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");			
			echo "</div>";
			
	    echo "<br /><span class=\"male\">".konf::get()->langTexty("musza")."</span>";
			
			echo $form->getFormk();
			echo "</td></tr>";
	      
			echo "<tr class=\"srodek\"><td class=\"tlo4\">".interfejs::linkEl("folder_explore",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_arch","id_kat"=>$id_nr,"id_d"=>$this->id_d)),konf::get()->langTexty("sklep_admin_form_listas"))."</td></tr>";
			
	    echo tab_stop();
			
	  } else {
			echo interfejs::nieprawidlowe();
	  }
	}
	

	/**
   * sklep remove
   */		
	public function usun(){
	
		$this->usunRekordy(konf::get()->getKonfigTab("sql_tab",'sklep_kat'),konf::get()->getKonfigTab("sklep_konf",'sklep_kat'),2,"img",konf::get()->langTexty("sklep_admin_a_usuwanie_log"),"id_matka");
	 
	}

  /**
   * set active
   */			
	public function aktyw(){
	
		$this->zmienparam("status",1,konf::get()->getKonfigTab("sql_tab",'sklep_kat'),konf::get()->langTexty("sklep_admin_a_param_log"));
		
	}
	
	
  /**
   * set deactive
   */		
	public function deaktyw(){
	
		$this->zmienparam("status",0,konf::get()->getKonfigTab("sql_tab",'sklep_kat'),konf::get()->langTexty("sklep_admin_a_param_log"));
		
	}	

	
  /**
   * sklep menu
   * @param array $dane
   */		
	public function sklepMenu($dane){
	
		if(!empty($dane)){
		
			echo "<table border=\"0\" style=\"margin-top:5px\"><tr>"; 
			
			echo interfejs::edytuj(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_edytuj","id_nr"=>$dane['id'],"id_d"=>$this->id_d,"id_kat"=>$dane['id']))); 		
		  echo interfejs::przyciskEl("folder_wrench",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_konfigedytuj","id_nr"=>$dane['id'],"id_d"=>$this->id_d,"id_kat"=>$dane['id'])),konf::get()->langTexty("sklep_admin_arch_edytujk")); 			
			if($dane['typ']==1){
				echo interfejs::przyciskEl("basket",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_arch","id_d"=>$this->id_d,"id_kat"=>$dane['id'])),konf::get()->langTexty("sklep_admin_produkty")."produkty");
			}
			echo interfejs::podglad(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklep_zobacz","id_kat"=>$dane['id'],"id_d"=>$this->id_d)));
			echo interfejs::infoEl($dane);		  
			echo interfejs::przyciskEl("arrow_join",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_arch","id_d"=>$this->id_d,"id_kat"=>$dane['id_matka'])),konf::get()->langTexty("poziomdogory"));		
					
			echo "</tr></table>";   
			
		}
		
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