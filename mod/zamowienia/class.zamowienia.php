<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

require_once(konf::get()->getKonfigTab('mod_kat')."sklep/class.sklep.php");			

class zamowienia extends sklep  {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="zamówienia class";
	
	
	private function zamAdd($tab="z"){
	
		$sql=" AND ".$tab.".id_u=".user::get()->id()." ";
		
		return $sql;
	
	}	

	private function getZamProdukty($id_nr){
	
		$id_nr+=0;
		
		$dane_tab=array();
	
		if(!empty($id_nr)){
	    $sql="SELECT p.* FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia_produkty')." p  WHERE p.id_zam='".$id_nr."' ";
			$sql.=" ORDER BY p.id";			
			$dane_tab=konf::get()->_bazasql->pobierzRekordy($sql,"id");			
		}
		
		return $dane_tab;
	
	}
	
	
	public function zobacz(){
	
		$statusy_tab=konf::get()->getKonfigTab("sklep_konf",'zamowienia_statusy');
		$platnosci_tab=konf::get()->getKonfigTab("sklep_konf",'platnosci_tab');		
		$platnosci_statusy_tab=konf::get()->getKonfigTab("sklep_konf",'platnosci_statusy_tab');				
		$platnosci_bledy_tab=konf::get()->getKonfigTab("sklep_konf",'platnosci_bledy_tab');		
		$id_nr=tekstForm::doSql(konf::get()->getZmienna("id_nr","id_nr"))+0;						
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$sortuj=konf::get()->getZmienna('sortuj','sortuj');			
		$colspan=5;

		if(!empty($id_nr)){
		
 			 $dane_zam=konf::get()->_bazasql->pobierzRekord("SELECT z.* FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia')." z WHERE id='".$id_nr."' ".$this->zamAdd());		
				
		}
		
		echo tab_nagl("Dane zamówienia",2);
		
		if(!empty($dane_zam)){
		
			echo "<tr>";
			echo "<td class=\"tlo4 lewa\" style=\"width:200px;\">Numer zamówienia:</td>";
			echo "<td class=\"tlo3 lewa\">".$dane_zam['id']."</td>";			
			echo "</tr>";
			
			echo "<tr>";
			echo "<td class=\"tlo4 lewa\">Data zamówienia:</td>";
			echo "<td class=\"tlo3 lewa\">".substr($dane_zam['zam_data'],0,16)."</td>";			
			echo "</tr>";
					
			echo "<tr>";
			echo "<td class=\"tlo4 lewa\">Wartość całkowita:</td>";
			echo "<td class=\"tlo3 lewa\">".$dane_zam['zam_kwota']." zł</td>";			
			echo "</tr>";		
			
			echo "<tr>";
			echo "<td class=\"tlo4 lewa\">W tym koszt przesyłki:</td>";
			echo "<td class=\"tlo3 lewa\">".$dane_zam['przesylka_kwota']." zł</td>";			
			echo "</tr>";				
			
			echo "<tr>";
			echo "<td class=\"tlo4 lewa\">Status zamówienia:</td>";
			echo "<td class=\"tlo3 lewa\">";
			
			if(!empty($statusy_tab[$dane_zam['status']])){
			
				echo $statusy_tab[$dane_zam['status']];

				if($dane_zam['status']==3&&!empty($platnosci_bledy_tab[$dane_zam['platnosc_typ']])&&!empty($platnosci_bledy_tab[$dane_zam['platnosc_typ']][$dane_zam['platnosc_error']])){
				
					echo "<div class=\"male\">".$platnosci_bledy_tab[$dane_zam['platnosc_typ']][$dane_zam['platnosc_error']]."</div>";
				
				}
			
			}	else {
			
				echo "&nbsp;";
				
			}	
			echo "</td>";			
			echo "</tr>";		
			
			echo "<tr>";
			echo "<td class=\"tlo4 lewa\">Sposób płatności:</td>";
			echo "<td class=\"tlo3 lewa\">";			
			if(!empty($platnosci_tab[$dane_zam['platnosc_typ']])){
			
				echo $platnosci_tab[$dane_zam['platnosc_typ']];

			}	else {
				echo "&nbsp;";
			}	
			echo "</td>";			
			echo "</tr>";										
		
		} else {
		
			echo interfejs::brak($colspan);		
				 		
		}		
				
		if(konf::get()->getSzablon()!="drukuj"){
		
			echo "<tr><td class=\"tlo4 srodek\" colspan=\"".$colspan."\">";	
			echo interfejs::linkEl("basket",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"zamowienia_arch","sortuj"=>$sortuj,"podstrona"=>$podstrona)),"Powrót na listę zamówień");
			echo "</td></tr>";
		
		}
								
		echo tab_stop();
	
				
		if(!empty($dane_zam)){		
		
			$colspan=4;

			echo tab_nagl("Zamówione produkty",$colspan);
			
			echo "<tr class=\"grube srodek\">";
			echo "<td class=\"tlo4\">Produkty:</td>";
			echo "<td class=\"tlo4\" style=\"width:50px\">Ilość:</td>";		
			echo "<td class=\"tlo4\" style=\"width:80px\">Cena:</td>";			
			echo "<td class=\"tlo4\" style=\"width:80px\">Wartość:</td>";				
			echo "</tr>";
			
			$dane_tab=$this->getZamProdukty($id_nr);		

			if(!empty($dane_tab)){	
			
				while(list($key,$dane)=each($dane_tab)){
			
					$link=$this->prodLink($dane);				
					
					echo "<tr class=\"srodek\">";
					echo "<td class=\"tlo3 lewa\">";						
					echo "<div class=\"grube\"><a ".$link.">".$dane['nazwa']."</a></div>";						
					echo "</td>";
					
					echo "<td class=\"tlo3\">";
					echo $dane['ilosc'];
					echo "</td>";	
						
					echo "<td class=\"tlo3 prawa\">".sprintf('%.2f',$dane['cena'])." zł</td>";		
						
					echo "<td class=\"tlo3 prawa\">".sprintf('%.2f',($dane['cena']*$dane['ilosc']))." zł</td>";	
		
					echo "</tr>";			
				
				}	

			} else {
			
				echo interfejs::brak($colspan);	
				
			}
				
			
			echo tab_stop();
			
			if(!empty($dane_zam['uwagi_klient'])||!empty($dane_zam['uwagi_admin_klient'])){

				echo tab_nagl("Uwagi do zamówienia");		
					
				if(!empty($dane_zam['uwagi_klient'])){
				
					echo "<tr><td class=\"tlo4 lewa grube\">Uwagi od klienta:</td></tr>";
					echo "<tr><td class=\"tlo3 lewa\">".tekstForm::doWys($dane_zam['uwagi_klient'])."</td></tr>";
					
				}
				
				if(!empty($dane_zam['uwagi_admin_klient'])){
				
					echo "<tr><td class=\"tlo4 lewa grube\">Uwagi od administratora do klienta:</td></tr>";
					echo "<tr><td class=\"tlo3 lewa\">".tekstForm::doWys($dane_zam['uwagi_admin_klient'])."</td></tr>";
					
				}				
				
				echo tab_stop();
			
			}

			
		}
		
		
	
	}
	
	
	/**
   * sklep arch
   */		
	public function arch($typ=""){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$id_nr=konf::get()->getZmienna('id_nr','id_nr');
		$sortuj=tekstForm::doSql(konf::get()->getZmienna('sortuj','sortuj'));
		$statusy_tab=konf::get()->getKonfigTab("sklep_konf",'zamowienia_statusy');
		$platnosci_tab=konf::get()->getKonfigTab("sklep_konf",'platnosci_tab');		
		$platnosci_statusy_tab=konf::get()->getKonfigTab("sklep_konf",'platnosci_statusy_tab');				
		$platnosci_bledy_tab=konf::get()->getKonfigTab("sklep_konf",'platnosci_bledy_tab');		
		
		$na_str=20;
		$colspan=5;
		
	  $tab_sort=array(
			1=>"z.id", 2=>"z.id DESC", 		
			7=>"z.zam_data", 8=>"z.zam_data DESC", 			
			11=>"z.zam_kwota, z.klient_nazwa", 12=>"z.zam_kwota DESC, z.klient_nazwa", 		
			13=>"z.status, z.klient_nazwa", 14=>"z.status DESC, z.klient_nazwa", 											
		);		
		
    if(empty($sortuj)||empty($tab_sort[$sortuj])){ 
			$sortuj=8; 
		}

    $query=" FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_zamowienia')." z WHERE 1 ".$this->zamAdd();
		
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"zamowienia_arch"));	
	  $link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"zamowienia_zobacz","podstrona"=>$podstrona,"sortuj"=>$sortuj));		
	  $link3=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"zamowienia_drukuj"));		

		$naw = new nawig("SELECT COUNT(z.id) AS ilosc".$query,$podstrona,$na_str);		
		$naw->naw($link."&amp;sortuj=".$sortuj);
		$podstrona=$naw->getPodstrona();		

	  echo tab_nagl("Historia zamówień (".$naw->getWynikow()."):",$colspan);	
	  			
		if($naw->getNaw()){
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
		}	

    //sortowanie  po kolumnach
    echo "<tr class=\"srodek\">";
		echo interfejs::sortEl($link."&amp;sortuj=",1,2,konf::get()->langTexty("zamowienia_admin_arch_nr")."Id",$sortuj,50);
		echo interfejs::sortEl($link."&amp;sortuj=",7,8,konf::get()->langTexty("zamowienia_admin_arch_data")."Data",$sortuj,80);				
		echo interfejs::sortEl($link."&amp;sortuj=",11,12,konf::get()->langTexty("zamowienia_admin_arch_cena")."Wartość",$sortuj,80);					
		echo interfejs::sortEl($link."&amp;sortuj=",13,14,konf::get()->langTexty("zamowienia_admin_arch_status")."Status",$sortuj);	
		echo "<td class=\"tlo4 srodek\" style=\"width:66px;\">&nbsp;</td>";
    echo "</tr>";			

	  //pobieranie danych  
	  $query="SELECT z.* ".$query." ORDER BY ".$tab_sort[$sortuj]."";
	  $query.=" LIMIT ".$naw->getStart().",".$naw->getIle();
			
	  $i=0;	    		
	  $dane_tab=konf::get()->_bazasql->pobierzRekordy($query,"id");
		$ile=count($dane_tab);
		
		if(!empty($dane_tab)){
				
			while(list($key,$dane)=each($dane_tab)){
				
		  	$i++;
					
	      echo "<tr class=\"srodek\">";
				
	      echo "<td class=\"tlo3 srodek\">";
		    echo "<a class=\"grube\" href=\"".$link2."&amp;id_nr=".$dane['id']."\">".$dane['id']."</a>";
				echo "</td>";
				
	      echo "<td class=\"tlo3 srodek nobr\">";
				echo "<a href=\"".$link2."&amp;id_nr=".$dane['id']."\">".substr($dane['zam_data'],0,16)."</a>";
	      echo "</td>";			
				
	      echo "<td class=\"tlo3 prawa\">";
		    echo "<div>".$dane['zam_kwota']." zł</div>";				
				echo "</td>";		
				
	      //status  
	      echo "<td class=\"tlo3 srodek\">";
				if(!empty($statusy_tab[$dane['status']])){
				
					echo $statusy_tab[$dane['status']];

					if($dane['status']==3&&!empty($platnosci_bledy_tab[$dane['platnosc_typ']])&&!empty($platnosci_bledy_tab[$dane['platnosc_typ']][$dane['platnosc_error']])){
					
						echo "<div class=\"male\">".$platnosci_bledy_tab[$dane['platnosc_typ']][$dane['platnosc_error']]."</div>";
					
					}
				
				}
	      echo "</td>";		
																	
	      echo "<td class=\"tlo3 srodek\">";												
				echo "<div><table border=\"0\" class=\"srodek\"><tr>";  
			  echo interfejs::podglad($link2."&amp;id_nr=".$dane['id']); 					  								
			  echo interfejs::przyciskEl("drukuj",$link3."&amp;id_nr=".$dane['id'],konf::get()->langTexty("zamowienia_drukuj")."drukuj","_blank");
				echo "</tr></table></div>";   					
				echo "</td>";						
						    					
		    echo "</tr>";

			}
			
			if($naw->getNaw()){
				echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
			}	
								
		} else {
		
			echo interfejs::brak($colspan);			 
						
	  }
			    
		echo tab_stop();		
 
	}	
	
	
	public function drukuj(){
	
		$this->zobacz();
	
	}
		
		
	/**
   * class constructor php5	
   */	
	public function __construct() {	

				
  }	
		
	
}

?>