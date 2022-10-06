<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}


class artadmin extends moduladmin {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="artadmin class";

	/**
	 * bierzacy dzial
	 */				
  private $id_d="";			

	/**
   * get art
   * @param int $id_art
   * @param bool $lang		
   * @return array
   */			
	public function pobierz($id_art,$lang=true){

		$dane="";
		
		if(!empty($id_art)){
	    $sql="SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE ";
			$sql.=" id='".$id_art."'";
	    if($lang){
	      $sql.=" AND lang='".konf::get()->getLang()."'";
	    }
			$dane=konf::get()->_bazasql->pobierzRekord($sql);
		}
		
		return $dane;
		
	}

	/**
   * get arts
   * @param int $id_art
   * @param int $limit
   * @return array
   */		
	public function pobierzLista($id_art,$limit=""){

		$dane=array();
		
		if(!empty($id_art)||$glowny){
	    $sql="SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE ";
			$sql.=" id_matka='".$id_art."' ";
	    $sql.=" AND lang='".konf::get()->getLang()."'";
			$sql.=" ORDER BY nr_poz, id";
			
			$limit=$limit+0;
			if($limit){
				$sql.=" LIMIT 0,".$limit;
			}		
			
			$dane=konf::get()->_bazasql->pobierzRekordy($sql,"id");

		}
		
		return $dane;
		
	}

	/**
   * get art by idtf
   * @param string $id_arttf
   * @param bool $lang		
   * @return array
   */	
	public function pobierzIdtf($art_idtf,$lang=true){

		$dane="";
		
		if(!empty($art_idtf)){
	    $sql="SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE idtf='".tekstForm::doSql($art_idtf)."' ";
	    if($lang){
	      $sql.=" AND lang='".konf::get()->getLang()."'";
	    }
			$dane=konf::get()->_bazasql->pobierzRekord($sql);
		}
		
		return $dane;
		
	}	
	
	
	/**
   * get art link
   * @param array $dane
   * @param array $zmienne		
   * @return string
   */	
	public function artLink($dane,$zmienne=array(),$href=true){

		$link="";
		
		if(!empty($dane['link'])){
		
			$link.=$dane['link'];
			
		} else if(konf::get()->getKonfigTab('mod_rewrite')){
		
			if(!empty($dane['idtf_link'])){	
				$link=konf::get()->getKonfigTab("sciezka").$dane['idtf_link'].",".$dane['id'].",l".konf::get()->getLang().".html";
			} else {
				$link=konf::get()->getKonfigTab("sciezka").$dane['id'].",l".konf::get()->getLang().".html";
			}							
			$link.=konf::get()->zmienneLink($link,$zmienne,false);
			
		} else {
			$link.=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik")."?id_art=".$dane['id'],$zmienne);		
		}
		
		if($href){
			$link="href=\"".$link."\"";
			if(!empty($dane['link_okno'])){
				$link.=" target=\"".$dane['link_okno']."\"";
			}
		}
		
		return $link;
		
	}	
		

	/**
   * art stat
   */			
	public function staty(){

		echo tab_nagl(konf::get()->langTexty("art_admin_stat"),2);
		
		echo "<tr><td colspan=\"2\" class=\"tlo4 grube\">".konf::get()->langTexty("art_admin_stat_ogolne")."</td></tr>";	
		
		echo "<tr class=\"prawa grube\"><td class=\"tlo4\">".konf::get()->langTexty("art_admin_stat_nazwa")."</td><td class=\"tlo4\" style=\"width:70px\">".konf::get()->langTexty("art_admin_stat_ilosc")."</td></tr>";
				
		$d_tab=konf::get()->getKonfigTab("art_konf",'d_tab');
		
		if(!empty($d_tab)&&is_array($d_tab)){

		  $link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_arch"));

		  echo "<tr><td colspan=\"2\" class=\"tlo4 grube\">".konf::get()->langTexty("art_admin_stat_kat")."</td></tr>";
		  echo "<tr class=\"prawa grube\"><td class=\"tlo4\">".konf::get()->langTexty("art_admin_stat_nazwa")."</td><td class=\"tlo4\">".konf::get()->langTexty("art_admin_stat_ilosc")."</td></tr>";
		  while(list($key,$val)=each($d_tab)){
				echo "<tr class=\"prawa\">";
				echo "<td class=\"tlo3\"><a href=\"".$link."&amp;id_d=".$key."\">".$val."</a></td>";		
				echo "<td class=\"tlo4 prawa\">".konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id_d='".$key."' AND lang='".konf::get()->getLang()."'")."</td>";
				echo "</tr>";
			}
		
		}
		
		$typ_tab=konf::get()->getKonfigTab("art_konf",'typ_tab');
		
		if(!empty($typ_tab)&&is_array($typ_tab)){

			reset(konf::get()->getKonfigTab("art_konf",'typ_tab'));

		  echo "<tr><td colspan=\"2\" class=\"tlo4 grube\">".konf::get()->langTexty("art_admin_stat_typy")."</td></tr>";
		  echo "<tr class=\"prawa grube\"><td class=\"tlo4\">".konf::get()->langTexty("art_admin_stat_nazwa")."</td><td class=\"tlo4\">".konf::get()->langTexty("art_admin_stat_ilosc")."</td></tr>";		
			
		  while(list($key,$val)=each($typ_tab)){
				echo "<tr class=\"prawa\">";
				echo "<td class=\"tlo3\">".$val."</td>";		
				echo "<td class=\"tlo4 prawa\">".konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE typ='".$key."' AND lang='".konf::get()->getLang()."'")."</td>";	
				echo "</tr>";
			}	
		}	
		
		echo "<tr class=\"prawa\">";
		echo "<td class=\"tlo3\">".konf::get()->langTexty("art_admin_stat_ilea")."</td>";		
		echo "<td class=\"tlo4 prawa\">".konf::get()->_bazasql->policz("aa.id"," FROM ".konf::get()->getKonfigTab("sql_tab",'art_akapity')." aa, ".konf::get()->getKonfigTab("sql_tab",'art')." a WHERE a.id=aa.id_matka AND a.lang='".konf::get()->getLang()."'")."</td>";
		echo "</tr>";				

		if(konf::get()->getKonfigTab("art_konf",'kom')&&konf::get()->getKonfigTab("sql_tab",'art_koment')){
			echo "<tr class=\"prawa\">";
			echo "<td class=\"tlo3\">".konf::get()->langTexty("art_admin_stat_ilek")."</td>";		
			echo "<td class=\"tlo4 prawa\">".konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'art_koment'))."</td>";				
			echo "</tr>";			
		}					
		
		if(konf::get()->getKonfigTab("art_konf",'licznik')){
			echo "<tr><td colspan=\"2\" class=\"tlo4 grube\">".konf::get()->langTexty("art_admin_stat_naj")."</td></tr>";		
			echo "<tr class=\"prawa grube\"><td class=\"tlo4\">".konf::get()->langTexty("art_admin_stat_tyt")."</td><td class=\"tlo4\">".konf::get()->langTexty("art_admin_stat_wizyt")."</td></tr>";
			
			$zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE lang='".konf::get()->getLang()."' AND licznik>0 ORDER BY licznik DESC LIMIT 0,10");		
			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
				echo "<tr class=\"prawa\">";
				echo "<td class=\"tlo3\"><a ".$this->artLink($dane).">".$dane['tytul']."</a></td>";		
				echo "<td class=\"tlo4 prawa\">".$dane['licznik']."</td>";			
				echo "</tr>";
			}
			konf::get()->_bazasql->freeResult($zap);
			
		}
		
		echo tab_stop();
		
	}


	/**
   * akapity poz
   */		
	public function akapitypoz(){

	  $typ=konf::get()->getZmienna('typ','typ');
	  $id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));	

		if(!empty($typ)&&!empty($id_nr)){			
		
		  $dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab","art_akapity")." WHERE id='".$id_nr."'");
		      	
		  if(!empty($dane)){
			
			  require_once(konf::get()->getKonfigTab("klasy")."class.zmienpoz.php");

				$poz=new zmienPoz($dane['id'],$typ,konf::get()->getKonfigTab("sql_tab","art_akapity"));		
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
   * art poz
   */		
	public function poz(){

	  $typ=konf::get()->getZmienna('typ','typ');
	  $id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));

		if(!empty($typ)&&!empty($id_nr)){			
			
		  $query_d=" AND lang='".konf::get()->getLang()."'";

		  $dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab","art")." WHERE id='".$id_nr."' ".$query_d);
		    	
		  if(!empty($dane)){
			
			  $query_d.=" AND id_d='".$dane['id_d']."'";				
			
			  require_once(konf::get()->getKonfigTab("klasy")."class.zmienpoz.php");

				$poz=new zmienPoz($dane['id'],$typ,konf::get()->getKonfigTab("sql_tab","art"));
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
	
		$ok=true;

		//element nadrzedny
		$id_art=tekstForm::doSql(konf::get()->getZmienna('id_art','id_art'));
		
		if(!empty($id_art)){
			$dane2=$this->pobierz($id_art);		
			//nie mozna doklejac podstron do newsa					
			if(empty($dane2)||$dane2['typ']==3){
				$ok=false;
			}
		}
		
		if($ok){
		
			//element nadrzedny
			require_once(konf::get()->getKonfigTab("klasy")."class.wytnijwklej.php");
			
			$poz=new wytnijwklej(konf::get()->getKonfigTab("sql_tab","art"),"art_wytnij_tab",$this->id_d,true);
			
			//dla listy newsow mozna dokleic tylko newsy
			if($dane2['typ']==2){
				$poz->setQueryAdd(" AND typ=3");
			//dla artykulow tylko artykuly
			} else if($dane2['typ']==1||$dane2['typ']==0){
				$poz->setQueryAdd(" AND typ IN (0,1,2)");			
			}
			$poz->setPole("poleMatka","id_matka");
			$poz->setPole("polePoz","nr_poz");
			$poz->setPole("polePoziom","poziom");		
			$poz->setPole("poleId","id");
			$poz->setPole("polePierwszy","id_pierwszy");						
			$poz->setPole("poleDzial","id_d");	
			$poz->setDzialy(konf::get()->getKonfigTab("art_konf",'d_tab'));	
			$poz->wklej($id_art);
			
		}
	  
	}


	/**
   * cut
   */		
	public function wytnij(){
	
	  $id_tab=konf::get()->getZmienna('id_tab','id_tab');		
		require_once(konf::get()->getKonfigTab("klasy")."class.wytnijwklej.php");
		$poz=new wytnijwklej(konf::get()->getKonfigTab("sql_tab","art"),"art_wytnij_tab",$this->id_d,true);
		$poz->wytnij($id_tab);	
		
	}


	/**
   * dzialy arch
   */		
	public function dzialy(){

		$colspan=2;					
		$d_tab=konf::get()->getKonfigTab("art_konf",'d_tab');
		
		if(!empty($d_tab)&&is_array($d_tab)){
		
			$query="";		
			
			$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_arch"));

			echo tab_nagl(konf::get()->langTexty("art_admin_d").count($d_tab)."):",$colspan);
			echo "<tr><td class=\"lewa grube tlo4\">".konf::get()->langTexty("art_admin_d_nazwa")."</td><td class=\"prawa grube tlo4\" style=\"width:40px\">".konf::get()->langTexty("art_admin_d_ilosc")."</td></tr>";
			
		  while(list($key,$val)=each($d_tab)){
				echo "<tr>";
				echo interfejs::folderEl("<a class=\"blok\" href=\"".$link."&amp;id_d=".$key."\">".$val."</a>","tlo3",1);		
				echo "<td class=\"tlo4 prawa\">".konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id_d='".$key."' AND lang='".konf::get()->getLang()."'")."</td>";
				echo "</tr>";			
			}
			
		  echo tab_stop();
			
	  } else {
	  	echo "<div class=\"brak\">".konf::get()->langTexty("art_admin_d_brak")."</div>";
	  }
		
	}


	/**
   * art arch
   */		
	public function arch(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$sortuj=tekstForm::doSql(konf::get()->getZmienna('sortuj','sortuj'));
		$id_art=tekstForm::doSql(konf::get()->getZmienna('id_art','id_art'));
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));
		
		//typ informacji
		$typ=0;
		
		$dane_art=array();
		
		if(!empty($id_art)){
			$dane_art=$this->pobierz($id_art,true);
		}

		if(empty($dane_art)){
			$id_art=0;
		} else {
			//dzial od elementu nadrzednego
			$this->id_d=$dane_art['id_d'];		
			$typ=$dane_art['typ'];
		}
		
		konf::get()->setZmienna("_post","id_d",$this->id_d);					
		
		if(!empty($this->id_d)){
		
			$d_tab=konf::get()->getKonfigTab("art_konf",'d_tab');
		
			$colspan=4;
			
			if($typ==2){
				$colspan++;
			}
			
	    if(konf::get()->getKonfigTab("art_konf",'licznik')){
	      $colspan++;
	    }
	    
	    //pzygotowanie zapytania pobrania danych
	    $tab_sort=array(5=>"tytul", 6=>"tytul DESC", 7=>"status", 8=>"status DESC", 9=>"licznik", 10=>"licznik DESC");
			
			//dla news sortowanie po dacie
			if($typ!=2){
				$tab_sort[1]="nr_poz";
				$tab_sort[2]="nr_poz DESC";
			} else {
				$tab_sort[11]="data_wys, id";
				$tab_sort[12]="data_wys DESC, id DESC";				
			}
			
	    if(empty($sortuj)||empty($tab_sort[$sortuj])){ 
				if($typ==2){
					$sortuj=12;
				} else {
					$sortuj=1; 
				}
			}

	    $query=" FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE 1 ";			
	    $query.=" AND id_matka='".$id_art."' "; 
	    $query.=" AND id_d='".$this->id_d."' ";
			$query.=" AND lang='".konf::get()->getLang()."'";				

			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"arch","arch");
			echo $form->spr(array(1=>"akcja"),"","ok=spr_akcjau(document.arch.akcja,'artadmin_usun','".konf::get()->langTexty("czyusun")."');");
			echo $form->getFormp();
			echo $form->przenies(array("sortuj"=>$sortuj,"id_art"=>$id_art,"id_d"=>$this->id_d,"podstrona"=>$podstrona));

	    //sciezki do linkow
	    $link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_arch","id_art"=>$id_art, "id_d"=>$this->id_d));
	    $link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_arch","sortuj"=>$sortuj, "id_d"=>$this->id_d));
	    $link3=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"art_zobacz"));
	    $link4=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_d"=>$this->id_d, "id_art"=>$id_art,"sortuj"=>$sortuj));
	    $link7=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_d"=>$this->id_d,"sortuj"=>$sortuj));		
		
	    //nawigator;
			$this->sciezka();    
			
			$naw = new nawig("SELECT COUNT(id) AS ilosc".$query,$podstrona,konf::get()->getKonfigTab("art_konf",'art_na_str'));		
			$naw->naw($link."&amp;sortuj=".$sortuj);
			$podstrona=$naw->getPodstrona();			
	    
	    //naglowek
	    echo tab_nagl(konf::get()->langTexty("art_admin_arch").$naw->getIle()."):",$colspan);
			
			$this->naglowekArt($dane_art,$colspan,false,$id_art="");

	    echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 lewa\">";

	    //pobieranie danych  
	    $query="SELECT * ".$query." ORDER BY ".$tab_sort[$sortuj].",id";
	    $query.=" LIMIT ".$naw->getStart().",".$naw->getIle();
			
	    $i=0;	    
			$dane_ile=array();
			$dane_tab=array();
			
	    $dane_tab=konf::get()->_bazasql->pobierzRekordy($query,"id");
			$ile=count($dane_tab);

	    //akcje  
			
			if($typ!=3){			
				$akcje_tab['artadmin_dodaj']=konf::get()->langTexty("adodaj");				
			}			
			if(!empty($ile)){
				$akcje_tab['artadmin_wytnij']=konf::get()->langTexty("awytnij");
			}
			if($typ!=3){					
		    if(konf::get()->getZmienna('','','art_wytnij_tab')){
					$akcje_tab['artadmin_wklej']=konf::get()->langTexty("awklej");		
		    }   
			}
			if(!empty($ile)){			
				$akcje_tab['artadmin_aktyw']=konf::get()->langTexty("aaktyw");
				$akcje_tab['artadmin_deaktyw']=konf::get()->langTexty("adeaktyw");
				$akcje_tab['artadmin_usun']=konf::get()->langTexty("ausun");
			}
			
	    if(konf::get()->getKonfigTab("art_konf",'blokada')){
				$akcje_tab['artadmin_usunblokady']=konf::get()->langTexty("art_admin_arch_awyczysc");		
		  }					
			
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

			if($typ==2){
				echo interfejs::sortEl($link."&amp;sortuj=","","",konf::get()->langTexty("art_admin_arch_nr"),$sortuj,70);			
				echo interfejs::sortEl($link."&amp;sortuj=",11,12,konf::get()->langTexty("art_admin_arch_data"),$sortuj,80);	
	  	} else {
	 			echo interfejs::sortEl($link."&amp;sortuj=",1,2,konf::get()->langTexty("art_admin_arch_nr"),$sortuj,70);				
			}
			echo interfejs::sortEl($link."&amp;sortuj=",5,6,konf::get()->langTexty("art_admin_arch_tyt"),$sortuj);
			echo interfejs::sortEl($link."&amp;sortuj=",7,8,konf::get()->langTexty("art_admin_arch_status"),$sortuj,70);		
	    if(konf::get()->getKonfigTab("art_konf",'licznik')){
				echo interfejs::sortEl($link."&amp;sortuj=",9,10,konf::get()->langTexty("art_admin_arch_licznik"),$sortuj,50);		
	    }
			echo interfejs::sortEl("","","",konf::get()->langTexty("art_admin_arch_pod"),"",40);		

	    echo "</tr>";

			if($typ==2){
	      echo "<tr><td class=\"tlo3 lewa\" colspan=\"".$colspan."\">";
				echo interfejs::wstaw($link4."&amp;akcja=artadmin_dodaj&amp;podstrona=".$podstrona);
				echo "</td></tr>";		
			}			

			if(!empty($dane_tab)){
				
				$query2="";
				while(list($key,$dane)=each($dane_tab)){
					if(!empty($query2)){
						$query2.=",";
					}
					$query2.=$key;
				}			
				
		    $dane_ile=konf::get()->_bazasql->pobierzRekordy("SELECT id_matka,COUNT(id) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id_matka IN(".$query2.") GROUP BY id_matka","id_matka");

				reset($dane_tab);
				
				while(list($key,$dane)=each($dane_tab)){
				
		      $i++;
										
					//pomin newsy bo tam nie mozna wstawiac po numerze porzadkowym
					if($typ!=2&&$typ!=3){
			      echo "<tr><td class=\"tlo3 lewa\" colspan=\"".$colspan."\">";
						echo interfejs::wstaw($link4."&amp;akcja=artadmin_dodaj&amp;id_nad=".$dane['id']."&amp;podstrona=".$podstrona);			
						echo "</td></tr>";
					}
					
		      echo "<tr class=\"srodek\"><td class=\"tlo4 srodek\">";
					
					if($dane['glowny']==1){			
				    echo "<img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/ikony/award_star_gold_1.gif\" style=\"margin-top:4px; margin-bottom:5px\" width=\"16\" height=\"16\" alt=\"".konf::get()->langTexty("art_admin_arch_sglowna")."\" title=\"".konf::get()->langTexty("art_admin_arch_sglowna")."\" /><br class=\"nowa_l\" />"; 
					}
					
					echo $form->checkbox("id_tab[]","id_".$dane['id'],$dane['id'],"");	
					
					echo "<div class=\"male\">";
					switch($dane['typ']){
					
						case '3':
							echo konf::get()->langTexty("art_admin_arch_t2");
						break;					
					
						case '2':
							echo konf::get()->langTexty("art_admin_arch_t2");
						break;
						
						case '1':
							echo konf::get()->langTexty("art_admin_arch_t1");
						break;
						
						default:
							echo konf::get()->langTexty("art_admin_arch_t0");
						
					}
					
					echo "<div ";
					if($id_nr==$dane['id']){
						echo " class=\"grube\"";
					}
					echo ">";
					if($typ==2){
			      echo $dane['id'];					
					} else {
			      echo $dane['nr_poz']."(".$dane['id'].")";							
					}
					echo "</div></div>";	
					
							
		      echo "</td>";					
					
					if($typ==2){
					
				  	echo "<td class=\"tlo3 srodek\">".$dane['data_wys']."</td>";					
					
					}					
		        
		      echo "<td class=\"tlo3 lewa\">";
					
					if($dane['typ']==3){
				    echo "<a class=\"admin_link\" href=\"".$link7."&amp;akcja=artadmin_zobacz&amp;id_nr=".$dane['id']."&amp;id_art=".$dane['id']."\">".$dane['tytul']."</a>";					
					} else {					
				    echo "<a class=\"admin_link\" href=\"".$link2."&amp;id_art=".$dane['id']."\">".$dane['tytul']."</a>";
					}

					echo "<div><table border=\"0\" style=\"margin-top:5px\"><tr>";    
					
			    echo interfejs::edytuj($link7."&amp;id_art=".$dane['id']."&amp;akcja=artadmin_edytuj&amp;id_nr=".$dane['id']);
			    echo interfejs::przyciskEl("folder_wrench",$link7."&amp;id_art=".$dane['id']."&amp;akcja=artadmin_konfigedytuj&amp;id_nr=".$dane['id'],konf::get()->langTexty("art_admin_arch_edytujk")); 
		      if($dane['typ']!=2){		
						echo interfejs::przyciskEl("page_edit",$link7."&amp;akcja=artadmin_zobacz&amp;id_nr=".$dane['id']."&amp;id_art=".$dane['id'],konf::get()->langTexty("art_admin_edycjatresci"));						
					}			
			    echo interfejs::podglad($link3."&amp;id_art=".$dane['id']); 
					if($typ!=2){
						echo interfejs::pozycja($link4."&amp;akcja=artadmin_poz&amp;id_nr=".$dane['id'],$i,$ile,$podstrona,$naw->getStron());
					}
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
		      if(konf::get()->getKonfigTab("art_konf",'licznik')){
		        echo "<td class=\"tlo3\">".$dane['licznik']."</td>";
		      }
					
		      echo "<td class=\"tlo3 srodek\">";
					
					$ile_podstron=0;					
		      if(!empty($dane_ile[$dane['id']]['ile'])){
			    	$ile_podstron=$dane_ile[$dane['id']]['ile'];
			    }
					
		      if(!empty($ile_podstron)){
		      	echo $ile_podstron;      
		      } else {
						echo "<table class=\"srodek\" border=\"0\"><tr>"; 			
						echo interfejs::usun($link4."&amp;podstrona=".$podstrona."&amp;sortuj=".$sortuj."&amp;akcja=artadmin_usun&amp;id_tab[1]=".$dane['id']); 
						echo "</tr></table>";
			    }
		      echo "</td>";
					
		      echo "</tr>";
					
		    }
				
			}
				
			if($podstrona==$naw->getStron()&&$typ!=2&&$typ!=3){
	      echo "<tr><td class=\"tlo3 lewa\" colspan=\"".$colspan."\">";
				echo interfejs::wstaw($link4."&amp;akcja=artadmin_dodaj&amp;podstrona=".$podstrona);
				echo "</td></tr>";		
			}

	    if($i==0){
				echo interfejs::brak($colspan);			 
	    }

			if($naw->getNaw()){
				echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
			}	
			
			echo "<tr class=\"srodek\"><td colspan=\"".$colspan."\" class=\"tlo4\">";
			if(!empty($dane_art)){
				echo interfejs::linkEl("folder_explore",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_arch","id_art"=>$dane_art['id_matka'],"id_d"=>$this->id_d)),konf::get()->langTexty("poziomdogory"));			
			} else {
				echo interfejs::linkEl("folder_explore",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_dzialy")),konf::get()->langTexty("art_admin_arch_kategorie"));
			}
			echo "</td></tr>";

	    echo tab_stop();
	    echo $form->getFormk();
			
	  } else {
	  	echo "<div class=\"brak\">".konf::get()->langTexty("art_admin_arch_nied")."</div>";
	  }
		  
	}


	/**
   * art konfig edit
   */		
	public function konfigedytuj2(){

		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr'));	
		$img_usun=tekstForm::doSql(konf::get()->getZmienna('img_usun'));	
			
		//dane podstawowe z formularza
		$daneodczyt=array(
			"komentarze"=>"",
			"na_str"=>"",		
			"rss"=>"",			
			"menu_nie"=>"",			
			"menu_wyr"=>"",			
			"do_gory"=>"",			
			"mapa_nie"=>"",			
			"stopka_nie"=>"",			
			"submenu"=>"",			
			"tytul_nie"=>"",
			"glowny"=>"",
			"idtf_link"=>"",			
			"art_description"=>"",
			"art_keywords"=>"",
			"art_title"=>"",			
			"zajawka"=>"",	
			"stat_nie"=>"",
			"submenu_polozenie"=>"",
			"submenu_wyglad"=>"",					
		);	
		
		$daneNieczysc[]="zajawka";
		
		$testy[]=array("zmienna"=>"komentarze","test"=>"truefalse");
		$testy[]=array("zmienna"=>"rss","test"=>"truefalse");
		$testy[]=array("zmienna"=>"menu_nie","test"=>"truefalse");	
		$testy[]=array("zmienna"=>"menu_wyr","test"=>"truefalse");	
		$testy[]=array("zmienna"=>"do_gory","test"=>"truefalse");	
		$testy[]=array("zmienna"=>"mapa_nie","test"=>"truefalse");	
		$testy[]=array("zmienna"=>"stopka_nie","test"=>"truefalse");	
		$testy[]=array("zmienna"=>"tytul_nie","test"=>"truefalse");			
		$testy[]=array("zmienna"=>"glowny","test"=>"truefalse");					
		$testy[]=array("zmienna"=>"art_description","test"=>"usunwiersz");	
		$testy[]=array("zmienna"=>"art_keywords","test"=>"usunwiersz");			
		$testy[]=array("zmienna"=>"stat_nie","test"=>"truefalse");		
			
		$testy[]=array("zmienna"=>"idtf_link","test"=>"oczysc",
			"param"=>array(
				"znak"=>"-"
			)	
		);	
				
		$img_align_tab=konf::get()->getKonfigTab("art_konf",'img_align');	
		$testy[]=array("zmienna"=>"img_align","test"=>"wtablicyi",
			"param"=>array(
				"wartosci"=>$img_align_tab,
				"domyslny"=>konf::get()->getKonfigTab("art_konf",'img_align_def')
			)	
		);		
		
		$submenu_typy=konf::get()->getKonfigTab("art_konf",'submenu_typy');	
		$testy[]=array("zmienna"=>"submenu_wyglad","test"=>"wtablicyi",
			"param"=>array(
				"wartosci"=>$submenu_typy,
				"domyslny"=>konf::get()->getKonfigTab("art_konf",'submenu_wyglad')
			)	
		);					
					
		//sprawdzamy strone nadrzedna zeby ustalic poziom w strukturze	
		if(!empty($id_nr)){
			$dane=$this->pobierz($id_nr);		
		}
		
		//pobieramy aktualne dane 
		if(!empty($dane)){
		
			//generator zapytania insert/update
			require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
			$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'art'),$daneodczyt,$daneNieczysc);
			$sqldane->daneOdczyt();	
			$sqldane->setAutor(true);	
			$sqldane->setTesty($testy);			
			$sqldane->dodajDaneE();						
						
			$this->id_d=$dane['id_d'];
			konf::get()->setZmienna("_post","id_d",$this->id_d);			

			//wstawianie grafiki
	 		if(konf::get()->getKonfigTab("art_konf",'img')){

				require_once(konf::get()->getKonfigTab('klasy')."class.zapiszgrafike.php");
				
				$grafika=new zapiszGrafike($id_nr,konf::get()->getKonfigTab("art_konf",'art_kat'),"pic","img",$dane);
				$grafika->setWszystkie(true);
				$grafika->setImgUsun($img_usun);
				
				$grafika->setDaneImg(1,array(
					"hmax"=>konf::get()->getKonfigTab("art_konf",'img_size'),
					"wmax"=>konf::get()->getKonfigTab("art_konf",'img_size'),
					"hmin"=>konf::get()->getKonfigTab("art_konf",'img_min_size'),
					"wmin"=>konf::get()->getKonfigTab("art_konf",'img_min_size'),
					"typy"=>array(2=>2),
					"skala"=>3					
				));
				
				$grafika->setDaneImg(2,array(
					"hmax"=>konf::get()->getKonfigTab("art_konf",'img_m_size'),
					"wmax"=>konf::get()->getKonfigTab("art_konf",'img_m_size'),
					"hmin"=>konf::get()->getKonfigTab("art_konf",'img_min_size'),
					"wmin"=>konf::get()->getKonfigTab("art_konf",'img_min_size'),
					"typy"=>array(2=>2),
					"skala"=>konf::get()->getKonfigTab("art_konf",'img_skala')					
				));			

				$grafika->wykonaj();
							
				if($grafika->getSql()){
					$sqldane->dodaj(", ".$grafika->getSql());				
				}
																					  
			}		
			
			$sqldane->dodaj(" WHERE id='".$id_nr."'");	
			
			//wykonaj zapytanie
			if($sqldane->getSql()){
				konf::get()->_bazasql->zap($sqldane->getSql());
			  user::get()->zapiszLog(konf::get()->langTexty("art_admin_arch_sedycja_log")." ".$dane['tytul'],user::get()->login());
				konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");
				
				if($dane['glowny']==0&&$sqldane->getDane('glowny')==1){
					konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'art')." SET glowny=0 WHERE id !='".$dane['id']."' AND lang='".konf::get()->getLang()."'");
				}
				
			} else { 
				konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
			}
			
		} else { 
			konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
		}

	}	


	/**
   * art save
   */		
	protected function zapisz(){

		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr',"id_nr"));		
		$id_art=tekstForm::doSql(konf::get()->getZmienna('id_art'));
		$id_nad=tekstForm::doSql(konf::get()->getZmienna('id_nad'));
		
		//dane podstawowe z formularza
		$dane=array(
			"data_start"=>"",
			"data_stop"=>"",		
			"data_wys"=>"",				
			"tytul"=>"",			
			"tytul_menu"=>"",		
			"podtytul"=>"",
			"link"=>"",			
			"link_okno"=>"",			
			"licznik"=>"",			
			"status"=>"",			
			"idtf"=>"",			
			"typ"=>"",		
			"wytworzyl"=>"",
			"wytworzyl_data"=>"",					
			"dostep"=>"",
			"zrodlo_link"=>"",			
		);
		
		//testowanie danych z formularza
		
		$testy[]=array("zmienna"=>"status","test"=>"truefalse",
			"param"=>array(
				"wartosc"=>1
			)
		);
		
		$d_tab=konf::get()->getKonfigTab("art_konf",'d_tab');		
		$testy[]=array("zmienna"=>"id_d","test"=>"wtablicyi",
			"param"=>array(
				"wartosci"=>$d_tab,
				"domyslny"=>""
			)
		);	
		
		$testy[]=array("zmienna"=>"id_d","test"=>"wartosc","wymagany"=>true,
			"param"=>array(
				"komunikat"=>konf::get()->langTexty("art_admin_arch_nieprawidlowe"),
				'idtf'=>"id_d"
			)	
		);	
		
		$testy[]=array("zmienna"=>"tytul","test"=>"wartosc","wymagany"=>true,
			"param"=>array(
				"komunikat"=>konf::get()->langTexty("art_admin_arch_nieprawidlowe"),
				'idtf'=>"tytul"			
			)	
		);	
			
		$dostep_tab=konf::get()->getKonfigTab("art_konf",'dostep_tab');	
				
		$testy[]=array("zmienna"=>"dostep","test"=>"wtablicyi",
			"param"=>array(
				"wartosci"=>$dostep_tab,
				"domyslny"=>""
			)
		);	

		$testy[]=array("zmienna"=>"idtf","test"=>"oczysc2");	
					
		//generator zapytania insert/update
		require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
		$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'art'),$dane);
		$sqldane->daneOdczyt();	
		$sqldane->setAutor(true);	
		$sqldane->setTesty($testy);

		//sprawdzamy czy strony o tym identyfikatorze jeszcze nie ma, jesli jest to czyscimy identyfkator
		if($sqldane->getDane("idtf")){
			if(konf::get()->_bazasql->policz("id","FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE idtf='".$sqldane->getDane("idtf")."' AND id!='".$id_nr."' AND lang='".konf::get()->getLang()."'")>0){
	  		$sqldane->setDane(array("idtf"=>""));			
				konf::get()->setKomunikat(konf::get()->langTexty("art_admin_arch_pidtf"),"error"); 
			}
		}	
		
		$sqldane->testuj();	
		
		if($sqldane->ok()){
		
			// dodawanie 
			if(empty($id_nr)){
			
				//sprawdzamy strone nadrzedna zeby ustalic poziom w strukturze	
				$poziom=0;	
				$id_pierwszy=0;					
				
				if(!empty($id_art)){
					$dane2=$this->pobierz($id_art);							
					if(!empty($dane2)&&$dane2['typ']!=3){
						$poziom=$dane2['poziom']+1;
						$this->id_d=$dane2['id_d'];
						if($dane2['poziom']==0){
							$id_pierwszy=$dane2['id'];
						} else {
							$id_pierwszy=$dane2['id_pierwszy'];						
						}
					} else {
						$id_art=0;
					}		
				}	else {
					$id_art=0;
				}

				//dodaj dane zo zapytania
			 	$sqldane->setDane(array(
					"lang"=>konf::get()->getLang(),
			 		"id_matka"=>$id_art,
			 		"id_pierwszy"=>$id_pierwszy,					
			 		"poziom"=>$poziom,
					"id_d"=>$this->id_d
				));		
				
				if(!empty($dane2)&&$dane2['typ']==2){
				 	$sqldane->setDane(array(
						"typ"=>3,
					));						
				} else if(!empty($dane2)&&$dane2['typ']!=2&&$sqldane->getDane("typ")==3){
				 	$sqldane->setDane(array(
						"typ"=>1,
					));							
				}
				
				//numer porzadkowy			
				$sqldane->setQueryAdd(" AND lang='".konf::get()->getLang()."'");				
				$sqldane->setMatka($id_art);			
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

					//jesli dodany pomiedzy to przesun kolejne elementy						
					$sqldane->ustawPoz();					
					
					user::get()->zapiszLog(konf::get()->langTexty("art_admin_arch_sdodaj_log")." ".$sqldane->getDane("tytul"),user::get()->login());
					$this->dziennikDodaj($id_nr,1);		
					
				} else {
					konf::get()->setAkcja("artadmin_dodaj");	
				}
				
				konf::get()->setZmienna("_post","id_art",$id_art);				
				
			} else {
			
				$dane=$this->pobierz($id_nr);				

				if(!empty($dane)){
				
					$this->id_d=$dane['id_d'];

					$dane3=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id='".$dane['id_matka']."'");
					if(!empty($dane3)){

						if($sqldane->getDane("typ")!=3&&$dane3['typ']==2){
							$sqldane->setDane(array("typ"=>3));										
						}	else if(!empty($dane2)&&$dane2['typ']!=2&&$sqldane->getDane("typ")==3){
				 			$sqldane->setDane(array("typ"=>1));							
						}
												
						$id_nad=$dane3['id'];						
					}	

					//budowanie zapytania
					$sqldane->dodajDaneE();						
					$sqldane->dodaj(" WHERE id='".$id_nr."'");	

					//wykonaj zapytanie
					if($sqldane->getSql()){
						konf::get()->_bazasql->zap($sqldane->getSql());
					}		
			
					$this->dziennikDodaj($id_nr,2);							
					
			    user::get()->zapiszLog(konf::get()->langTexty("art_admin_arch_sedycja_log")." ".$sqldane->getDane("tytul"),user::get()->login());
					
				} else {
					$id_nr="";
				}
				
				konf::get()->setZmienna("_post","id_art",$id_nr);				
				
			}

			if(!empty($id_nr)){						
				konf::get()->setZmienna("_post","id_nr",$id_nr);				
				konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");
			} else { 
				konf::get()->setKomunikat(konf::get()->langTexty("niezapisane"),"error"); 
			} 
			
			if(konf::get()->getAkcja()=="artadmin_edytuj2"){
			
				konf::get()->setAkcja("artadmin_edytuj");	
				
			} else {

				konf::get()->setAkcja("artadmin_arch");	

			}
				
		} else {
		
			if(!empty($id_nr)){
				konf::get()->setAkcja("artadmin_edytuj");	
			} else {
				konf::get()->setAkcja("artadmin_dodaj");	
			}		

		}
		
		konf::get()->setZmienna("_post","id_d",$this->id_d);		

	}	
	
	/**
   * art add
   */		
	public function dodaj2(){	
		$this->zapisz();
	}
	
	
	/**
   * art edit
   */		
	public function edytuj2(){	
		$this->zapisz();
	}	

	
  /**
   * save img
   * @param array $dane
   * @param int $id_nr
   * @return obj							
   */		
	private function grafikaZapisA($dane,$id_nr){

		$img_usun=tekstForm::doSql(konf::get()->getZmienna('img_usun'));		
		require_once(konf::get()->getKonfigTab('klasy')."class.zapiszgrafike.php");
		
		$grafika=new zapiszGrafike($id_nr,konf::get()->getKonfigTab("art_konf",'akapity_kat'),"pic","img",$dane);
		$grafika->setWszystkie(true);
		$grafika->setImgUsun($img_usun);
		
		$grafika->setDaneImg(1,array(
			"hmax"=>konf::get()->getKonfigTab("art_konf",'imga_size'),
			"wmax"=>konf::get()->getKonfigTab("art_konf",'imga_size'),
			"hmin"=>konf::get()->getKonfigTab("art_konf",'imga_min_size'),
			"wmin"=>konf::get()->getKonfigTab("art_konf",'imga_min_size'),
			"typy"=>array(2=>2),
			"skala"=>3					
		));	
		
		$grafika->setDaneImg(2,array(
			"hmax"=>konf::get()->getKonfigTab("art_konf",'imga_m_size'),
			"wmax"=>konf::get()->getKonfigTab("art_konf",'imga_m_size'),
			"hmin"=>konf::get()->getKonfigTab("art_konf",'imga_min_size'),
			"wmin"=>konf::get()->getKonfigTab("art_konf",'imga_min_size'),
			"typy"=>array(2=>2),
			"skala"=>konf::get()->getKonfigTab("art_konf",'imga_skala')
		));								

		$grafika->wykonaj();	
		
		return $grafika;		
	
	}		

	/**
   * art akapity save
   */		
	private function akapityZapisz(){

		$id_nad=tekstForm::doSql(konf::get()->getZmienna('id_nad'));	
		$id_art=tekstForm::doSql(konf::get()->getZmienna('id_art'));
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr'));

		//dane podstawowe z formularza
		$dane=array(
			"tresc"=>"",
			"tytul"=>"",
			"img_align"=>"",					
			"img_opis"=>"",			
			"img_link"=>"",			
			"img_link_okno"=>"",					
			"status"=>""
		);	
		
		
		$daneNieczysc[]="tresc";

		$img_align_tab=konf::get()->getKonfigTab("art_konf",'img_align');	
		$testy[]=array("zmienna"=>"img_align","test"=>"wtablicyi",
			"param"=>array(
				"wartosci"=>$img_align_tab,
				"domyslny"=>konf::get()->getKonfigTab("art_konf",'img_align_def')
			)	
		);	
		
		$testy[]=array("zmienna"=>"status","test"=>"truefalse");

		//generator zapytania insert/update
		require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
		$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'art_akapity'),$dane,$daneNieczysc);
		$sqldane->daneOdczyt();	
		$sqldane->setAutor(true);	
		$sqldane->setTesty($testy);	

		if(!empty($id_nr)){
	    //pobranie aktualne dane   
		  $dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art_akapity')." WHERE id='".$id_nr."'");
		  
		  if(empty($dane)){
		  	$id_nr="";
		  } else {
		  	$id_art=$dane['id_matka'];
		  }
		}
		
		if(!empty($id_art)){
	 
			$dane2=$this->pobierz($id_art);
			
			if(!empty($dane2)&&($dane2['typ']==0||$dane2['typ']==1||$dane2['typ']==3)){
				
				//dodanie 
				if(empty($id_nr)){
				
					//numer porzadkowy					
					$sqldane->setMatka($id_art);	
					$sqldane->setNad($id_nad);					
					$sqldane->setPoleMatka("id_matka");				
					$sqldane->setPoleId("id");
					$sqldane->setPolePoz("nr_poz");				
					$sqldane->dodajPoz();			
					
					//dodaj dane zo zapytania
				 	$sqldane->setDane(array(
				 		"id_matka"=>$id_art,
				 		"typ"=>$dane2['typ']
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
					
			    	if(konf::get()->getKonfigTab("art_konf",'imga')){					
							
							$grafika=$this->grafikaZapisA($dane,$id_nr);										
							
							if($grafika->getSql()){					
								konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'art_akapity')." SET ".$grafika->getSql()." WHERE id='".$id_nr."'");	
							}				

		  	   	}

						$this->dziennikDodaj($id_art,4,$dane2);					
		  	  	user::get()->zapiszLog(konf::get()->langTexty("art_admin_aka_dodaj_log")." ".$dane2['tytul'],user::get()->login());
						
		    	}	
		    //edycja
		    } else {    
				
					$sqldane->dodajDaneE();	
					
		      //dodanie grafiki	    
			    if(konf::get()->getKonfigTab("art_konf",'imga')){	
					
						$grafika=$this->grafikaZapisA($dane,$id_nr);		
						
						if($grafika->getSql()){			
							$sqldane->dodaj(", ".$grafika->getSql());				
						}

					}
				  
					$sqldane->dodaj(" WHERE id='".$id_nr."'");	
									
					if($sqldane->getSql()){
						konf::get()->_bazasql->zap($sqldane->getSql());
						$this->dziennikDodaj($id_art,5,$dane2);				 				
			  	  user::get()->zapiszLog(konf::get()->langTexty("art_admin_aka_edytuj_log")." ".$dane2['tytul'],user::get()->login());
					}

		  	}        
		  	
		    if(!empty($id_nr)){
		    	konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");
					$this->updateEdytor($id_art);					
		    } else { 
					konf::get()->setKomunikat(konf::get()->langTexty("niezapisane"),"error"); 
				} 
			} else { 
				konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
			}
		}
		
		konf::get()->setZmienna("_post","id_nr",$id_nr);	
		konf::get()->setZmienna("_post","id_art",$id_art);				

	}	


	/**
   * art add
   */		
	public function akapitydodaj2(){	
		$this->akapityZapisz();
	}
	
	
	/**
   * art edit
   */		
	public function akapityedytuj2(){	
		$this->akapityZapisz();
	}	
	
	
	public function sciezka(){

		$id_art=tekstForm::doSql(konf::get()->getZmienna('id_art','id_art'));	
		$link="";

		if(!empty($id_art)){
			$id=$id_art;
			while($id!=0){
				$dane=$this->pobierz($id,true);
				if(!empty($dane)){
					$this->id_d=$dane['id_d'];
					$link=" &gt; <a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_arch","id_d"=>$this->id_d,"id_art"=>$id))."\">".$dane['tytul']."</a>".$link;
					$id=$dane['id_matka'];
				} else {
					break;
				}
			}
		}

		$d_tab=konf::get()->getKonfigTab("art_konf",'d_tab');
		
		if(!empty($this->id_d)&&!empty($d_tab[$this->id_d])){	
			$link="<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_arch","id_d"=>$this->id_d))."\">".$d_tab[$this->id_d]."</a>".$link;
		}

		if(!empty($link)){
		
			echo tab_nagl("",1);
			echo "<tr style=\"height:24px\"><td valign=\"middle\" class=\"tlo3 lewa\"><table border=\"0\" cellspacing=\"0\" class=\"lewa nowa_l\"><tr valign=\"middle\">";
			echo "<td valign=\"top\">";
			echo "<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_dzialy"))."\"><img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/ikony/house.gif\" width=\"16\" height=\"16\" alt=\"\" class=\"lewa\" style=\"margin-right:2px\" /></a>";
			echo "</td><td> &gt; ".$link."</td>";			
			echo "</tr></table></td></tr>";
			echo tab_stop();		
			
		}		
		
	}	
	

	/**
   * art konfig form
   */		
	public function konfigedytuj(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));	

		//domyslne wartosci
		$dane=array(
			"zajawka"=>"",	
			"komentarze"=>0,
			"na_str"=>0,
			"rss"=>0,
			"menu_nie"=>0,
			"menu_wyr"=>0,		
			"do_gory"=>0,		
			"mapa_nie"=>0,
			"tytul_nie"=>0,
			"stat_nie"=>0,
			"stopka_nie"=>0,
			"glowny"=>0,			
			"idtf_link"=>"",
			"art_description"=>"",
			"art_keywords"=>"",
			"art_title"=>"",
			"submenu_polozenie"=>"",
			"submenu_wyglad"=>"",			
			"img_align"=>konf::get()->getKonfigTab("art_konf",'img_align_def')			
		);

		//dla edycji pobierz aktualne dane
		$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id='".$id_nr."'");
		
		if(!empty($id_nr)&&!empty($dane)){
		
			$this->id_d=$dane['id_d'];
		
			$this->sciezka();
			
	    //jesli wszystko ok to wyswietl formularz  
	    echo tab_nagl(konf::get()->langTexty("art_admin_konfig_form"),1); 
			
			$this->naglowekArt($dane,1,true);					

	    echo "<tr><td valign=\"top\" class=\"tlo3\">";

			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"art","art");
			$form->setMultipart(true);			
			echo $form->getFormp();
			echo $form->przenies(array(
				"id_nr"=>$id_nr,
				"id_art"=>$id_nr,				
				"id_d"=>$this->id_d,				
				"akcja"=>konf::get()->getAkcja()."2",
				"podstrona"=>$podstrona
			));
			
	    echo "<div>";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");
			echo "</div>";			
			
	    //zajawka artykułu
	    if(konf::get()->getKonfigTab("art_konf",'zajawka')){
	      echo "<div class=\"grube\">";
				echo interfejs::label("zajawka",konf::get()->langTexty("art_admin_form_zajawka"));
				echo interfejs::pomocEl(konf::get()->langTexty("art_admin_form_hzajawka"));
				echo "</div>";
	      if(konf::get()->getKonfigTab("art_konf",'zajawka_edytor')){
					$form->fck("zajawka",$dane['zajawka']);
	      } else {
					echo $form->textarea("zajawka","zajawka",$dane['zajawka'],"f_bdlugi");
	      }
	      echo "<br />";			
	    }
			
			//sekcja dotyczaca uploadu grafiki
			if(konf::get()->getKonfigTab("art_konf",'img')){
			
	      //zajawka
	 	    echo "<br /><div class=\"grube\">".konf::get()->langTexty("art_admin_form_zajawkai")."</div><br />";	
						
	  		if(!empty($dane['img'])){
				
					echo interfejs::imgPodglad($dane,"img",konf::get()->getKonfigTab("art_konf",'art_kat'));	
	  			echo "<div>";
					echo $form->checkbox("img_usun","img_usun",1,"");				
					echo interfejs::label("img_usun",konf::get()->langTexty("usung"),"",true);
					echo "</div>"; 
					
	  		}
				
	  	  echo konf::get()->langTexty("art_admin_form_grafika");
				echo interfejs::pomocEl(konf::get()->langTexty("art_admin_form_himg"));																							
				echo "<div>";
				echo $form->input("file","pic","pic","","f_bdlugi");
				echo "</div><br />";
				
			  //pozycja grafiki	
				$img_align_tab=konf::get()->getKonfigTab("art_konf",'img_align');
				if(!empty($img_align_tab)&&is_array($img_align_tab)){
					while(list($key,$val)=each($img_align_tab)){
						$img_align_tab[$key]=konf::get()->langTexty("align".$key);
					}
					echo "<div>".interfejs::label("img_align",konf::get()->langTexty("art_admin_form_gwt"))."</div>";					
					echo $form->select("img_align","img_align",$img_align_tab,$dane['img_align'],"f_dlugi");
				}				

			}			
			
	    if(konf::get()->getKonfigTab("art_konf",'submenu_polozenie')){	
				
				$submenu_typy=konf::get()->getKonfigTab("art_konf",'submenu_typy');			
					
				echo "<br /><br /><div><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
				
				echo "<tr valign=\"top\" style=\"line-height:16px;\">";
				
				echo "<td style=\"padding-right:10px\">";
				echo interfejs::label("submenu",konf::get()->langTexty("art_admin_form_submenu"),"grube");
				echo interfejs::pomocEl(konf::get()->langTexty("art_admin_form_submenuh")."Opcje submenu nie dotyczą listy aktualności");				
		 	  echo "</td>";		
				
				echo "<td style=\"padding-right:10px\">";
				echo interfejs::label("submenu_polozenie",konf::get()->langTexty("art_admin_form_submenup")."położenie submenu","grube");						
		 	  echo "</td>";		

				if(!empty($submenu_typy)){
				
					echo "<td style=\"padding-right:10px\">";
					echo interfejs::label("submenu_wyglad",konf::get()->langTexty("art_admin_form_submenuw")."wygląd submenu","grube");					
			 	  echo "</td>";						
				
				}
				
				echo "</tr>";

				echo "<tr valign=\"top\">";
				
				echo "<td style=\"padding-right:10px\">";
				echo $form->select("submenu","submenu",array(0=>konf::get()->langTexty("art_submenu0"),1=>konf::get()->langTexty("art_submenu1"),2=>konf::get()->langTexty("art_submenu2")),$dane['submenu'],"f_dlugi");
		 	  echo "</td>";		
				
				echo "<td style=\"padding-right:10px\">";
				echo $form->select("submenu_polozenie","submenu_polozenie",array(1=>konf::get()->langTexty("art_submenup1")."nad treścią artykułu",2=>konf::get()->langTexty("art_submenup2")."pod treścią artykułu"),$dane['submenu_polozenie'],"f_dlugi");
		 	  echo "</td>";		

				if(!empty($submenu_typy)){				
					echo "<td style=\"padding-right:10px\">";
					echo $form->select("submenu_wyglad","submenu_wyglad",$submenu_typy,$dane['submenu_wyglad'],"f_dlugi");
			 	  echo "</td>";										
				}
				
				echo "</tr>";				
				
				echo "</table></div><br />";
								
			}			
	    
	    //typ stronicowania
	    if(konf::get()->getKonfigTab("art_konf",'stronicowanie')){
	      echo "<div>";
				echo interfejs::label("na_str",konf::get()->langTexty("art_admin_form_ilosc"));		
				echo interfejs::pomocEl(konf::get()->langTexty("art_admin_form_hilosc"));
				echo "</div>";
				echo "<div class=\"male\">".konf::get()->langTexty("art_admin_form_iloscbez")."</div>";
				echo $form->selectWylicz("na_str","na_str",0,konf::get()->getKonfigTab("art_konf",'stronicowanie'),$dane['na_str'],"f_krotki","");
	      echo "<br />";
				
	    }
			
			echo "<br />";
			echo $form->checkbox("glowny","glowny",1,$dane['glowny']);				
			echo interfejs::label("glowny",konf::get()->langTexty("art_admin_form_glowny"),"block",true);				
			echo interfejs::pomocEl(konf::get()->langTexty("art_admin_form_hglowny"));		
			echo "<br />";						
						
	    if(konf::get()->getKonfigTab("art_konf",'kom')){
				echo "<br />";
				echo $form->checkbox("komentarze","komentarze",1,$dane['komentarze']);		
				echo interfejs::label("komentarze",konf::get()->langTexty("art_admin_form_koment"),"nobr",true);		
				echo "<br />";			
	    }

	    if(konf::get()->getKonfigTab("art_konf",'rss')){						
				echo "<br />";			
				echo $form->checkbox("rss","rss",1,$dane['rss']);	
				echo interfejs::label("rss",konf::get()->langTexty("art_admin_form_rss"),"nobr",true);					
				echo interfejs::pomocEl(konf::get()->langTexty("art_admin_form_hrss"));		
				echo "<br />";
			}
					
			echo "<br />";					
			echo $form->checkbox("menu_nie","menu_nie",1,$dane['menu_nie']);	
			echo interfejs::label("menu_nie",konf::get()->langTexty("art_admin_form_menunie"),"nobr",true);									
			echo interfejs::pomocEl(konf::get()->langTexty("art_admin_form_hmenunie"));				
			echo "<br />";
					
			echo "<br />";					
			echo $form->checkbox("menu_wyr","menu_wyr",1,$dane['menu_wyr']);
			echo interfejs::label("menu_wyr",konf::get()->langTexty("art_admin_form_menuwyr"),"nobr",true);		
			echo interfejs::pomocEl(konf::get()->langTexty("art_admin_form_hmenuwyr"));					
			echo "<br />";
					
					
			echo "<br />";
			echo $form->checkbox("do_gory","do_gory",1,$dane['do_gory']);		
			echo interfejs::label("do_gory",konf::get()->langTexty("art_admin_form_dogory"),"nobr",true);		
			echo interfejs::pomocEl(konf::get()->langTexty("art_admin_form_hdogory"));				
			echo "<br />";
					
	    echo "<br />";
			echo $form->checkbox("mapa_nie","mapa_nie",1,$dane['mapa_nie']);	
			echo interfejs::label("mapa_nie",konf::get()->langTexty("art_admin_form_mapanie"),"nobr",true);		
			echo interfejs::pomocEl(konf::get()->langTexty("art_admin_form_hmapanie"));				
			echo "<br />";
					
	    echo "<br />";
			echo $form->checkbox("tytul_nie","tytul_nie",1,$dane['tytul_nie']);			
			echo interfejs::label("tytul_nie",konf::get()->langTexty("art_admin_form_tytulnie"),"nobr",true);		
			echo interfejs::pomocEl(konf::get()->langTexty("art_admin_form_htytulnie"));		
			echo "<br />";
					
	    echo "<br />";
			echo $form->checkbox("stopka_nie","stopka_nie",1,$dane['stopka_nie']);
			echo interfejs::label("stopka_nie",konf::get()->langTexty("art_admin_form_stopkanie"),"nobr",true);		
			echo interfejs::pomocEl(konf::get()->langTexty("art_admin_form_hstopkanie"));
			echo "<br />";
			
	    echo "<br />";
			echo $form->checkbox("stat_nie","stat_nie",1,$dane['stat_nie']);		
			echo interfejs::label("stat_nie",konf::get()->langTexty("art_admin_form_statnie"),"nobr",true);		
			echo interfejs::pomocEl(konf::get()->langTexty("art_admin_form_hstatnie"));	
			echo "<br /><br />";			
					
					
		  echo "<div>";
			echo interfejs::label("idtf_link",konf::get()->langTexty("art_admin_form_idtflink"),"grube");		
			echo interfejs::pomocEl(konf::get()->langTexty("art_admin_form_hidtflink"));
			echo "</div>";
			echo $form->input("text","idtf_link","idtf_link",$dane['idtf_link'],"f_bdlugi",100);
			echo "<br /><br />";
						
			echo "<div>";
			echo interfejs::label("art_description",konf::get()->langTexty("art_admin_form_description"),"grube");					
			echo interfejs::pomocEl(konf::get()->langTexty("art_admin_form_hdescription"));
			echo "</div>";
			echo $form->textarea("art_description","art_description",$dane['art_description'],"f_bdlugi",5);	
			echo "<br />";
			echo $form->skrocTxt("art_description",250);
			echo "<br />";
			
			echo "<div>";
			echo interfejs::label("art_keywords",konf::get()->langTexty("art_admin_form_keywords"),"grube");					
			echo interfejs::pomocEl(konf::get()->langTexty("art_admin_form_hkeywords"));
			echo "</div>";
			echo $form->textarea("art_keywords","art_keywords",$dane['art_keywords'],"f_bdlugi",5);	
			echo "<br />";
			echo $form->skrocTxt("art_keywords",250);
			echo "<br />";
			
		  echo "<div>";
			echo interfejs::label("art_title",konf::get()->langTexty("art_admin_form_title"),"grube");					
			echo "</div>";
			echo $form->input("text","art_title","art_title",$dane['art_title'],"f_bdlugi",200);
			echo "<br />";			
										
	    echo "<div>";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");
			echo "</div>";
	    
			echo $form->getFormk();
			
			echo "</td></tr>";
	      
			echo "<tr class=\"srodek\"><td class=\"tlo4 srodek\">";			
			echo interfejs::linkEl("folder_explore",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_arch","id_art"=>$dane['id_matka'],"id_d"=>$this->id_d)),konf::get()->langTexty("art_admin_form_listas"));			
			echo "</td></tr>";
			
	    echo tab_stop();
			
	  } else {
			echo interfejs::nieprawidlowe();
	  }
		
	}


	/**
   * art form
   */		
	private function artForm(){
	
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		
		//artykul
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));	

		//artykul nadrzedny
		$id_art=tekstForm::doSql(konf::get()->getZmienna('id_art','id_art'));
		
	  //artykul rownorzedny, w kolejnosci nastepny
		$id_nad=tekstForm::doSql(konf::get()->getZmienna('id_nad','id_nad'));
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"art","art");		
		
		//domyslne wartosci
		$dane=array(
			"idtf"=>"",
			"id_matka"=>$id_art,
			"tytul"=>"",
			"tytul_menu"=>"",
			"podtytul"=>"",
			"link"=>"",
			"link_okno"=>"",
			"id_d"=>$this->id_d,
			"data_wys"=>date("Y-m-d H:i"),			
			"data_start"=>date("Y-m-d H:i"),
			"data_stop"=>"",
			"licznik"=>0,
			"typ"=>0,
			"status"=>1,
			"wytworzyl"=>"",
			"wytworzyl_data"=>"",			
			"dostep"=>0,
			"zrodlo_link"=>"",
		);
		
		$dane=$form->odczyt($dane);

		//dla edycji pobierz aktualne dane
		if(!empty($id_nr)){
			$dane2=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id='".$id_nr."'");
			if(!empty($dane2)){
				$dane=$dane2;	
				$id_art=$dane2['id_matka'];
				$this->id_d=$dane['id_d'];
			} else {
				$id_nr="";
			}
		}

		if($id_nr!=''||$this->id_d!=''){
		
			if(!empty($id_art)){
				$dane3=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id='".$id_art."'");							
				if(empty($dane3)){
					$id_art="";
				}							
			}
		
			$this->sciezka();
			
	    //jesli wszystko ok to wyswietl formularz
	    if(empty($id_nr)){
	      echo tab_nagl(konf::get()->langTexty("art_admin_form_t"),1);  
	    } else {
	      echo tab_nagl(konf::get()->langTexty("art_admin_form_e"),1); 
	    }
			
			if(!empty($id_nr)){
				$this->naglowekArt($dane,1,false,$id_nr);					
			} else {
				$this->naglowekArt($dane,1,false,$id_art);					
			}
			
	    echo "<tr><td valign=\"top\" class=\"tlo3\">";
			
			echo $form->spr(array(1=>"tytul"));
			echo $form->getFormp();
			echo $form->przenies(array("id_nr"=>$id_nr,"id_art"=>$id_art,"id_nad"=>$id_nad,"akcja"=>konf::get()->getAkcja()."2","podstrona"=>$podstrona));

	    echo "<div>";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");
			echo "</div>";
						
	    //identyfikator
	    if(konf::get()->getKonfigTab("art_konf",'idtf')){
				echo $form->input("text","idtf","idtf",$dane['idtf'],"f_dlugi",100);
				echo interfejs::label("idtf",konf::get()->langTexty("art_admin_form_idtf"),"grube",true);
				echo interfejs::pomocEl(konf::get()->langTexty("art_admin_form_hidtf"));
				echo "<br />";
	      echo "<span class=\"male\">".konf::get()->langTexty("art_admin_form_unikalny")."</span>";
				echo "<br /><br />";
	    }			
			
	    if(konf::get()->getKonfigTab("art_konf",'data_wys')||(!empty($dane3)&&$dane3['typ']==2)||(!empty($dane['typ'])&&$dane['typ']==3)){
		    //data informacji
				echo $form->kalendarz("data_wys","trigger_a",$dane['data_wys'],true);
				echo interfejs::label("data_wys",konf::get()->langTexty("art_admin_form_datawys"),"grube",true);				
				echo "<br />";			
			}

	    //od kiedy wyswietlać
			echo $form->kalendarz("data_start","trigger_b",$dane['data_start'],true);
			echo interfejs::label("data_start",konf::get()->langTexty("art_admin_form_datastart"),"grube",true);			
			echo "<br />";
	        
	    //do kiedy wyswietlać
			echo $form->kalendarz("data_stop","trigger_c",$dane['data_stop'],true,true);
			echo interfejs::label("data_stop",konf::get()->langTexty("art_admin_form_dataw"),"grube",true);								
			echo "<br /><br />";
			
			echo interfejs::label("tytul",konf::get()->langTexty("art_admin_form_tytul"),"grube ".$form->invalid('tytul'));								
	    echo "<br />";
			echo $form->input("text","tytul","tytul",$dane['tytul'],"f_bdlugi",200);	
		 	echo "<br /><br />";
			
			echo interfejs::label("tytul_menu",konf::get()->langTexty("art_admin_form_tytulz"),"grube ".$form->invalid('tytulz'));			
			echo interfejs::pomocEl(konf::get()->langTexty("art_admin_form_htytulz"));		
			echo "<br />";
			echo $form->input("text","tytul_menu","tytul_menu",$dane['tytul_menu'],"f_bdlugi",200);		
			echo "<br /><br />";
			
	    if(konf::get()->getKonfigTab("art_konf",'podtytul')){
				echo interfejs::label("podtytul",konf::get()->langTexty("art_admin_form_podtytul"),"grube ".$form->invalid('podtytul'));						
				echo "<br />";
				echo $form->textarea("podtytul","podtytul",$dane['podtytul'],"f_bdlugi",4);	
				echo "<br /><br />";			
			}			
			
			echo interfejs::label("link",konf::get()->langTexty("art_admin_form_linkz"),"grube ".$form->invalid('link'));			
			echo interfejs::pomocEl(konf::get()->langTexty("art_admin_form_hlink"));
			echo "<br />";
			echo $form->input("text","link","link",$dane['link'],"f_bdlugi",250);			
			echo "<br />";
			
			echo $form->input("text","link_okno","link_okno",$dane['link_okno'],"f_dlugi",50);	
			echo interfejs::label("link_okno",konf::get()->langTexty("art_admin_form_oknol"),$form->invalid('tytulz'),true);											
	    echo "<br />";
	    echo "<span class=\"male\"><span class=\"grube\" onclick=\"document.getElementById('link_okno').value='_blank'\">_blank</span> ".konf::get()->langTexty("art_admin_form_noweo")." <span class=\"grube\" onclick=\"document.getElementById('link_okno').value='_self'\">_self</span> ".konf::get()->langTexty("art_admin_form_tosamoo")."</span>";
	    echo "<br /><br />";

	    //dzial
			$d_tab=konf::get()->getKonfigTab("art_konf",'d_tab');			
	    if(empty($id_nr)&&!empty($d_tab)&&is_array($d_tab)){	
	      echo "<br />";
				echo interfejs::label("id_d",konf::get()->langTexty("art_admin_form_dzial"),"grube ".$form->invalid('id_d'));										
				echo "<br />";				
				echo $form->select("id_d","id_d",$d_tab,$dane['id_d'],"f_bdlugi");
	      echo "<br /><br />";
	    } else {
				echo $form->input("hidden","id_d","id_d",$dane['id_d']);			
			}
	    
	    //typ zawartosci
			$typ_tab=konf::get()->getKonfigTab("art_konf",'typ_tab');		
	    if(!empty($typ_tab)&&is_array($typ_tab)&&!(!empty($dane3)&&$dane3['typ']==2)){
			
				if($dane['typ']!=3&&isset($typ_tab[3])){
					unset($typ_tab[3]);
				}
				
				echo interfejs::label("typ",konf::get()->langTexty("art_admin_form_typz"),"grube ".$form->invalid('typ'));		
				echo interfejs::pomocEl(konf::get()->langTexty("art_admin_form_htypz"));			
				echo "<br />";			
				echo $form->select("typ","typ",$typ_tab,$dane['typ'],"f_dlugi");
	 	    echo "<br />";
	    }
			
	    //dostep do zawartosci
			$dostep_tab=konf::get()->getKonfigTab("art_konf",'dostep_tab');
			
	    if(!empty($dostep_tab)&&is_array($dostep_tab)){
	      echo "<br />";
				echo interfejs::label("dostep",konf::get()->langTexty("art_admin_form_dostep"),"grube ".$form->invalid('dostep'));	
				echo interfejs::pomocEl(konf::get()->langTexty("art_admin_form_hdostep"));			
				echo "<br />";
				echo $form->select("dostep","dostep",$dostep_tab,$dane['dostep'],"f_dlugi");			
	 	    echo "<br />";
	    }		
			
	    if(konf::get()->getKonfigTab("art_konf",'licznik')){
	      echo "<br />";
				echo $form->input("text","licznik","licznik",$dane['licznik'],"f_krotki",10);								
				echo interfejs::label("licznik",konf::get()->langTexty("art_admin_form_licznik"),$form->invalid('licznik'),true);					
				echo interfejs::pomocEl(konf::get()->langTexty("art_admin_form_hlicznik"));
				echo "<br />";
	    }		
			

			//informacje na temat newsa		
			if(konf::get()->getKonfigTab("art_konf",'pobierz_zrodlo')){
				echo "<br />";
				echo interfejs::label("zrodlo_link",konf::get()->langTexty("art_admin_form_zrodlo"),"grube ".$form->invalid('zrodlo'));	
				echo interfejs::pomocEl(konf::get()->langTexty("art_admin_form_hzrodlo"));										
				echo "<br />";
				echo $form->input("text","zrodlo_link","zrodlo_link",$dane['zrodlo_link'],"f_bdlugi",200);				
				echo "<br />";
			}						
			
	    if(konf::get()->getKonfigTab("art_konf",'wytworzyl')){
	      echo "<br />";
				echo interfejs::label("wytworzyl",konf::get()->langTexty("art_admin_form_wytworzyl"),"grube ".$form->invalid('wytworzyl'));									
				echo "<br />";
				echo $form->input("text","wytworzyl","wytworzyl",$dane['wytworzyl'],"f_dlugi",150);		
				echo "<br /><br />";
				echo $form->input("text","wytworzyl_data","wytworzyl_data",tekstForm::niepuste($dane['wytworzyl_data']),"f_krotki",10);				
				echo interfejs::label("wytworzyl_data",konf::get()->langTexty("art_admin_form_wytworzylkiedy"),"",true);	
				echo "<br />";				
	    }		
		
	    echo "<br /><div class=\"nobr\">";
			echo $form->checkbox("status","status",1,$dane['status']);			
			echo interfejs::label("status",konf::get()->langTexty("widoczny"),"",true);								
	    echo "</div>";
			
	    echo "<br />";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");			
			echo "<br />";
	    echo "<br /><span class=\"male\">".konf::get()->langTexty("musza")."</span>";
			
			echo $form->getFormk();
			echo "</td></tr>";  
			
			echo "<tr class=\"srodek\"><td class=\"tlo4\">".interfejs::linkEl("folder_explore",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_arch","id_art"=>$id_nr,"id_d"=>$this->id_d)),konf::get()->langTexty("art_admin_form_listas"))."</td></tr>";
			
	    echo tab_stop();
			
	  } else {
			echo interfejs::nieprawidlowe();
	  }
	}
	

	/**
   * art add
   */		
	public function dodaj(){	
		$this->artForm();
	}
	
	
	/**
   * art edit
   */		
	public function edytuj(){	
		$this->artForm();
	}	
		

	/**
   * art akapity form
   */		
	private function akapityForm(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$id_art=tekstForm::doSql(konf::get()->getZmienna('id_art','id_art'));	
	 	$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));
		$id_nad=tekstForm::doSql(konf::get()->getZmienna('id_nad','id_nad'));

		//domyslne wartosci
		$dane=array(
			"tresc"=>"",
			"tytul"=>"",
			"img_opis"=>"",
			"img_link"=>"",
			"img_link_okno"=>"",
			"status"=>"1",
			'tresc_align'=>konf::get()->getKonfigTab("art_konf",'txt_align_def'),
			'img_align'=>konf::get()->getKonfigTab("art_konf",'img_align_def')	
		);	

		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"art","art");	
		
		$dane=$form->odczyt($dane);
		
		//sprawdzamy art nadrzedny
		if(!empty($id_art)){
			$dane2=$this->pobierz($id_art);	
		}

		if(!empty($dane2)){
		
			$this->id_d=$dane2['id_d'];

			//dla edycji pobierz aktualne dane
			if(!empty($id_nr)){
				$danea=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art_akapity')." WHERE id='".$id_nr."'");
				if(!empty($danea)){
					$dane=$danea;
				} else {
					$id_nr="";
				}
			} 

			$this->sciezka();
			 
			if(konf::get()->getAkcja()=="artadmin_akapitydodaj"){
	  		echo tab_nagl(konf::get()->langTexty("art_admin_aform_t"),1);
		  } else {
	  	  echo tab_nagl(konf::get()->langTexty("art_admin_aform_e"),1);
		  }
						
			$this->naglowekArt($dane2,1,true,$id_art);
			
		  echo "<tr><td valign=\"top\" class=\"tlo3\">";

			if(!empty($id_nr)){
				$this->akapityMenu($dane);
			}
			
			echo "<br />"; 
  

			$form->setMultipart(true);		
			echo $form->spr(array(1=>"akcja"));
			echo $form->getFormp();
			echo $form->przenies(array(
				"a"=>"",
				"id_nr"=>$id_nr,
				"akcja"=>konf::get()->getAkcja()."2",
				"podstrona"=>$podstrona,
				"id_d"=>$this->id_d,				
				"id_art"=>$id_art,
				"id_nad"=>$id_nad
			));
			
			
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");		
			echo "<br /><br />";						
			
			echo interfejs::label("tytul",konf::get()->langTexty("art_admin_aform_tytul"),"grube");			
			echo "<br />";
			echo $form->input("text","tytul","tytul",$dane['tytul'],"f_bdlugi",250);		
			echo "<br /><br />";		

		  echo "<div>";
			echo interfejs::label("tresc",konf::get()->langTexty("art_admin_aform_tresc"),"grube");								
			echo "</div>";				

			$form->fck("tresc",$dane['tresc'],500);

			//sekcja dotyczaca uploadu grafiki
			if(konf::get()->getKonfigTab("art_konf",'imga')){
			
				echo "<br /><br />";
				
				if(!empty($dane['img'])&&!empty($dane['img1_nazwa'])){

					echo interfejs::imgPodglad($dane,"img",konf::get()->getKonfigTab("art_konf",'akapity_kat'));	
	  			echo "<div>";
					echo $form->checkbox("img_usun","img_usun",1,"");		
					echo interfejs::label("img_usun",konf::get()->langTexty("usung"),"nobr",true);														
					echo "</div>"; 
					
  	 		}

  		  echo "<div>";
				echo interfejs::label("pic",konf::get()->langTexty("art_admin_aform_gjpg"),"grube");						
 				echo "</div>";										
				echo $form->input("file","pic","pic","","f_bdlugi");				
				echo "<br /><br />";				
								
				echo interfejs::label("img_opis",konf::get()->langTexty("art_admin_aform_opisg"),"grube");										
	  		echo "<br />";
				echo $form->input("text","img_opis","img_opis",$dane['img_opis'],"f_bdlugi",200);		
				echo "<br /><br />";		
				
				echo interfejs::label("img_link",konf::get()->langTexty("art_admin_aform_linkg"),"grube");												
  			echo "<br />";				
				echo $form->input("text","img_link","img_link",$dane['img_link'],"f_bdlugi",250);
				echo "<br />";	
								
				echo $form->input("text","img_link_okno","img_link_okno",$dane['img_link_okno'],"f_dlugi",50);					
				echo interfejs::label("img_link_okno",konf::get()->langTexty("art_admin_aform_oknog"),"",true);														
	  		echo "<br />";				
  			echo "<span class=\"male\"><span class=\"grube\" onclick=\"document.art.img_link_okno.value='_blank'\">_blank</span> ".konf::get()->langTexty("art_admin_aform_noweo")." <span class=\"grube\" onclick=\"document.art.img_link_okno.value='_self'\">_self</span> ".konf::get()->langTexty("art_admin_aform_tosamo")."</span>";
	  		echo "<br /><br />";
			
				$img_align_tab=konf::get()->getKonfigTab("art_konf",'img_align');
				if(isset($img_align_tab)&&is_array($img_align_tab)){
					while(list($key,$val)=each($img_align_tab)){
						$img_align_tab[$key]=konf::get()->langTexty("align".$key);
					}
					echo $form->select("img_align","img_align",$img_align_tab,$dane['img_align'],"f_dlugi");
					echo interfejs::label("img_align",konf::get()->langTexty("art_admin_aform_polozenieg"),"",true);											
    			echo "<br />";
				}		
				
			}
			
	    echo "<br /><br />";
			echo $form->checkbox("status","status",1,$dane['status']);	
			echo interfejs::label("status",konf::get()->langTexty("widoczny"),"nobr",true);									
	   	echo "<br />";
	   	
	  	echo "<br />";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");		
			echo "<br />";
			
			echo "<div class=\"male\">".konf::get()->langTexty("musza")."</div>";
			
			echo $form->getFormk();
			
			echo "</td></tr>";			
			
			echo "<tr class=\"srodek\"><td class=\"tlo4\">".interfejs::linkEl("folder_explore",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_arch","id_art"=>$dane2['id_matka'],"id_d"=>$dane2['id_d'])),konf::get()->langTexty("art_admin_aform_listael"))."</td></tr>";
			
	  	echo tab_stop();
			
	  } else {
			echo interfejs::nieprawidlowe();	
	  }
		
	}
	
	/**
   * art add
   */		
	public function akapitydodaj(){	
		$this->akapityForm();
	}
	
	
	/**
   * art edit
   */		
	public function akapityedytuj(){	
		$this->akapityForm();
	}	
	
	
	/**
   * art konfig form
   */		
	public function akapitykonfigedytuj(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));	

		//dla edycji pobierz aktualne dane
		if(!empty($id_nr)){
			$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art_akapity')." WHERE id='".$id_nr."'");
		}
		
		if(!empty($dane['id_matka'])){
			$dane2=$this->pobierz($dane['id_matka']);	
		}

		if(!empty($dane2)){
		
			$this->id_d=$dane2['id_d'];
		
			$this->sciezka();
			
	    //jesli wszystko ok to wyswietl formularz  
	    echo tab_nagl(konf::get()->langTexty("art_admin_akapity_edytujk"),1); 			
			
			$this->naglowekArt($dane2,1,true,$dane['id_matka']);			

		  echo "<tr><td valign=\"top\" class=\"tlo3\">";

			if(!empty($id_nr)){
				$this->akapityMenu($dane);
			}
			
			echo "<br />";  			

			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"art","art");
			$form->setMultipart(true);			
			echo $form->getFormp();
			echo $form->przenies(array(
				"id_nr"=>$id_nr,
				"id_art"=>$dane['id_matka'],
				"id_d"=>$this->id_d,
				"akcja"=>konf::get()->getAkcja()."2",
				"podstrona"=>$podstrona
			));
			
	    echo "<div>";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");
			echo "</div>";			
			
			echo "<table border=\"0\"><tr valign=\"top\">";
			
			echo "<td>";
			
	    echo "<div>";			
			echo interfejs::label("ramka",konf::get()->langTexty("art_admin_akapity_kramka"),"grube");								
			echo interfejs::pomocEl(konf::get()->langTexty("art_admin_akapity_kramkah"));	
			echo "</div>";					
			echo $form->slider('ramka',0,100,1,100,$dane['ramka']);		
			echo "<br />";
			
	    echo "<div class=\"grube\">";
			echo interfejs::label("dlugosc",konf::get()->langTexty("art_admin_akapity_ksser"),"grube");								
			echo interfejs::pomocEl(konf::get()->langTexty("art_admin_akapity_kszerh"));			
			echo "</div>";					
			echo $form->slider('dlugosc',0,100,1,100,$dane['dlugosc']);			
			echo "<br />";
						
	    echo "<div>";
			echo interfejs::label("padding",konf::get()->langTexty("art_admin_akapity_kmargines"),"grube");								
			echo interfejs::pomocEl(konf::get()->langTexty("art_admin_akapity_kmarginesh"));			
			echo "</div>";					
			echo $form->slider('padding',0,100,1,100,$dane['padding']);						
			echo "<br />";
			
			echo "</td>";			
			
			echo "<td style=\"padding-left:25px;\">";
						
	    echo "<div>";
			echo interfejs::label("ramka_kolor",konf::get()->langTexty("art_admin_akapity_kramkak"),"grube");						
			echo interfejs::pomocEl(konf::get()->langTexty("art_admin_akapity_kramkakh"));	
			echo "</div>";	
						
			echo $form->colorPicker("ramka_kolor",$dane['ramka_kolor']);			
			
			echo "</td>";		
			
			echo "<td style=\"padding-left:25px;\">";
						
	    echo "<div>";
			echo interfejs::label("tlo_kolor",konf::get()->langTexty("art_admin_akapity_ktlo"),"grube");								
			echo interfejs::pomocEl(konf::get()->langTexty("art_admin_akapity_ktloh"));	
			echo "</div>";	
						
			echo $form->colorPicker("tlo_kolor",$dane['tlo_kolor']);			
			
			echo "</td>";					
				
			echo "</tr></table>";
						
	    if(konf::get()->getKonfigTab("art_konf",'galeria')){		
			
			
				echo "<br /><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";			
				
				echo "<tr valign=\"top\">";
				
		    echo "<td style=\"padding-right:25px;\">";
				echo interfejs::label("galeria_kolumna",konf::get()->langTexty("art_admin_akapity_kgalw"),"grube");					
				echo interfejs::pomocEl(konf::get()->langTexty("art_admin_akapity_kgalwh"));
				echo "</td>";					
															
		    echo "<td>";
				echo interfejs::label("galeria_wiersz",konf::get()->langTexty("art_admin_akapity_kgalh"),"grube");		
				echo interfejs::pomocEl(konf::get()->langTexty("art_admin_akapity_kgalhh"));
				echo "</td>";						
				
				echo "</tr>";		
				
				
				echo "<tr valign=\"top\">";
				
		    echo "<td style=\"padding-right:25px;\">";
				echo $form->slider('galeria_kolumna',0,10,1,100,$dane['galeria_kolumna']);
				echo "</td>";					
															
		    echo "<td>";
				echo $form->slider('galeria_wiersz',0,100,1,100,$dane['galeria_wiersz']);		
				echo "</td>";						
				
				echo "</tr>";						
						
				echo "</table><br />";

				$galeria_typy=konf::get()->getKonfigTab("art_konf",'galeria_typy');
				
		    if(!empty($galeria_typy)){	
					
					if(empty($dane['galeria_typ'])){
						$dane['galeria_typ']=konf::get()->getKonfigTab("art_konf",'galeria_typ_domyslny');
					}
					
			    echo "<div>";
					echo interfejs::label("galeria_typ",konf::get()->langTexty("art_admin_akapity_kgalt"),"grube");												
					echo interfejs::pomocEl(konf::get()->langTexty("art_admin_akapity_kgalth"));
					echo "</div>";	
					
					echo $form->select("galeria_typ","galeria_typ",$galeria_typy,$dane['galeria_typ'],"f_bdlugi");
			 	  echo "<br /><br />";		
				}		
				
				
				$galeria_skala=konf::get()->getKonfigTab("art_konf",'galeria_skala');
				
		    if(!empty($galeria_skala)){	
					
					if(empty($dane['galeria_skala'])){
						$dane['galeria_skala']=0;
					}
					
			    echo "<div>";
					echo interfejs::label("galeria_skala",konf::get()->langTexty("art_admin_akapity_sgalt"),"grube");							
					echo "</div>";
					
					echo $form->select("galeria_skala","galeria_skala",$galeria_skala,$dane['galeria_skala'],"f_bdlugi",konf::get()->langTexty("wybierz"));
			 	  echo "<br /><br />";		
					
					
			    echo "<div>";							
					echo interfejs::label("galeria_m_w",konf::get()->langTexty("art_admin_akapity_galw"),"grube");														
					echo interfejs::pomocEl(konf::get()->langTexty("art_admin_akapity_wgalh"));									
					echo "</div>";					
					echo $form->slider('galeria_m_w',0,500,1,500,$dane['galeria_m_w']);						
					echo "<br />";					
					
			    echo "<div>";
					echo interfejs::label("galeria_m_h",konf::get()->langTexty("art_admin_akapity_galh"),"grube");													
					echo interfejs::pomocEl(konf::get()->langTexty("art_admin_akapity_wgalh"));											
					echo "</div>";					
					echo $form->slider('galeria_m_h',0,500,1,500,$dane['galeria_m_h']);						
					echo "<br />";							
					
				}						

		    echo "<div>";
				echo $form->checkbox("galeria_zalezne","galeria_zalezne",1,$dane['galeria_zalezne']);
				echo interfejs::label("galeria_zalezne",konf::get()->langTexty("art_admin_akapity_zalezne"),"nobr",true);						
				echo interfejs::pomocEl(konf::get()->langTexty("art_admin_akapity_zalezneh"));				
				echo "</div><br />";																	
					
			}
										
	    echo "<div>";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");
			echo "</div>";
	    
			echo $form->getFormk();
			
			echo "</td></tr>";
	      
			echo "<tr class=\"srodek\"><td class=\"tlo4\">";
			echo interfejs::linkEl("folder_explore",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_zobacz","id_art"=>$dane['id_matka'],"id_d"=>$this->id_d)),konf::get()->langTexty("art_admin_akapity_kpowrot"));
			echo "</td></tr>";
			
	    echo tab_stop();
			
	  } else {
			echo interfejs::nieprawidlowe();
	  }
		
	}	
			
			
	/**
   * art konfig edit
   */		
	public function akapitykonfigedytuj2(){

		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr'));	

		//dane podstawowe z formularza
		//domyslne wartosci
		$daneodczyt=array(
			"ramka"=>0,	
			"ramka_kolor"=>"",
			"tlo_kolor"=>"",
			"dlugosc"=>0,
			"padding"=>0,
			"galeria_wiersz"=>0,		
			"galeria_kolumna"=>0,		
			"galeria_typ"=>0,
			"galeria_skala"=>0,
			"galeria_m_w"=>0,			
			"galeria_m_h"=>0,			
			"galeria_zalezne"=>0,							
		);
		
		$daneNieczysc=array();
		
		$galeria_typy=konf::get()->getKonfigTab("art_konf",'galeria_typy');			
		
		if(!empty($galeria_typy))	{
		
			$testy[]=array("zmienna"=>"galeria_typ","test"=>"wtablicyi",
				"param"=>array(
					"wartosci"=>$galeria_typy,
					"domyslny"=>konf::get()->getKonfigTab("art_konf",'galeria_typ_domyslny')
				)
			);	
			
		}
		
		$galeria_skala=konf::get()->getKonfigTab("art_konf",'galeria_skala');		
		
		if(!empty($galeria_skala))	{		
					
			$testy[]=array("zmienna"=>"galeria_skala","test"=>"wtablicyi",
				"param"=>array(
					"wartosci"=>$galeria_skala,
					"domyslny"=>0
				)
			);	
				
		}
		
		$testy[]=array("zmienna"=>"galeria_m_w","test"=>"liczba",
			"param"=>array(
				"domyslny"=>0,
				"min"=>0,
				"max"=>500,						
			)
		);	
		
		$testy[]=array("zmienna"=>"galeria_m_h","test"=>"liczba",
			"param"=>array(
				"domyslny"=>0,
				"min"=>0,
				"max"=>500,						
			)
		);		
		
		$testy[]=array("zmienna"=>"galeria_zalezne","test"=>"liczba",
			"param"=>array(
				"domyslny"=>0,
				"min"=>0,
				"max"=>2,						
			)
		);							
		
		$testy[]=array("zmienna"=>"ramka","test"=>"liczba",
			"param"=>array(
				"domyslny"=>0,
				"min"=>0,
				"max"=>100,						
			)
		);				
		
		$testy[]=array("zmienna"=>"dlugosc","test"=>"liczba",
			"param"=>array(
				"domyslny"=>0,
				"min"=>0,
				"max"=>100,						
			)
		);					
		
		$testy[]=array("zmienna"=>"padding","test"=>"liczba",
			"param"=>array(
				"domyslny"=>0,
				"min"=>0,
				"max"=>100,						
			)
		);		
		
		$testy[]=array("zmienna"=>"galeria_wiersz","test"=>"liczba",
			"param"=>array(
				"domyslny"=>0,
				"min"=>0,
				"max"=>100,						
			)
		);				
		
		$testy[]=array("zmienna"=>"galeria_kolumna","test"=>"liczba",
			"param"=>array(
				"domyslny"=>0,
				"min"=>0,
				"max"=>10,						
			)
		);			
		
		$testy[]=array("zmienna"=>"ramka_kolor","test"=>"oczysc");								
		$testy[]=array("zmienna"=>"tlo_kolor","test"=>"oczysc");			
		
		//dla edycji pobierz aktualne dane
		if(!empty($id_nr)){
			$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art_akapity')." WHERE id='".$id_nr."'");
		}
		
		if(!empty($dane['id_matka'])){
			$dane2=$this->pobierz($dane['id_matka']);	
		}

		if(!empty($dane2)){
		
			//generator zapytania insert/update
			require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
			$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'art_akapity'),$daneodczyt,$daneNieczysc);
			$sqldane->daneOdczyt();	
			$sqldane->setAutor(true);	
			$sqldane->setTesty($testy);			
			$sqldane->dodajDaneE();						
			$sqldane->dodaj(" WHERE id='".$id_nr."'");	
			
			//wykonaj zapytanie
			if($sqldane->getSql()){
			
				konf::get()->_bazasql->zap($sqldane->getSql());			
			  user::get()->zapiszLog(konf::get()->langTexty("art_admin_akapity_klog")." ".$dane2['tytul'],user::get()->login());
				konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");
				
			} else { 
				konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
			}
			
		} else { 
			konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
		}

	}	
			

	/**
   * art akapity remove
   */		
	public function akapityusun(){

		$id_tab=konf::get()->getZmienna('id_tab','id_tab');
		$id_art=konf::get()->getZmienna('id_art','id_art');			
		$query="";
				
		if(!empty($id_tab)){			
			$query=tekstForm::tabQuery($id_tab);				
		}		
		
		if(!empty($query)){
				
			//pobieramy akapity
			$zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art_akapity')." WHERE id IN (".$query.")");
			
			//usuwamy grafiki akapitow
			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
				$this->usunImg($dane,konf::get()->getKonfigTab("art_konf",'akapity_kat'),2,"img");		
			}	
		  konf::get()->_bazasql->freeResult($zap);

			//usuwamy galerie akapitow		
			if(konf::get()->getKonfigTab("sql_tab",'art_galeria')){
			
				$zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art_galeria')." WHERE id_matka IN (".$query.")");
				while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
					$this->usunImg($dane,konf::get()->getKonfigTab("art_konf",'galeria_kat'),2,"img");				
		  	}		
		  	konf::get()->_bazasql->freeResult($zap);	
				konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'art_galeria')." WHERE id_matka IN (".$query.")");	
				
			}				
			
			//usuwamy akapity
			konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'art_akapity')." WHERE id IN (".$query.")");
			user::get()->zapiszLog(konf::get()->langTexty("art_admin_aka_usun_log"));	
			
			$this->updateEdytor($id_art);			
			$this->dziennikDodaj($id_art,6);
			
			konf::get()->setKomunikat(konf::get()->langTexty("usuwanie"),"");
			
		}	else {
			konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),"error"); 
		}
		
	}


	/**
   * art dziennik
   */		
	public function dziennikDodaj($id_art,$akcja,$dane=""){

		if(konf::get()->getKonfigTab("art_konf",'dziennik_zmian')){
		
			if(empty($dane)){
				$dane=$this->pobierz($id_art);
			}
			
			if(!empty($dane)){
			
				$query="INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'artd')." VALUES(";
				$query.="NULL";
				$query.=",'".tekstForm::doSql($akcja)."'";		
				$query.=",NOW()";				
				$query.=",'".tekstForm::doSql(user::get()->autor())."'";
				$query.=",'".user::get()->id()."'";
				while(list($key,$val)=each($dane)){
					$query.=",'".tekstForm::doSql($val,false)."'";
				}
				$query.=")";
				konf::get()->_bazasql->zap($query);
				
				$id_nr=konf::get()->_bazasql->insert_id;
				
				if(!empty($id_nr)){
					$zap2=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art_akapity')." WHERE id_matka='".$id_art."'");
					while($dane2=konf::get()->_bazasql->fetchAssoc($zap2)){		
						$query="INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'art_akapityd')." VALUES(";
						$query.="NULL";
						$query.=",'".$id_nr."'";				
						while(list($key,$val)=each($dane2)){
							$query.=",'".tekstForm::doSql($val,false)."'";
						}
						$query.=")";
						konf::get()->_bazasql->zap($query);								
					}
				}
						
			}
			
		}
		
	}


	/**
   * art remove
   */		
	public function usun(){

		$id_tab=konf::get()->getZmienna('id_tab','id_tab');
		$query="";
		$query_galerie="";
		
		if(!empty($id_tab)){
		
			while(list($key,$val)=each($id_tab)){
			
				$val=tekstForm::doSql($val);
				
				if(!empty($val)){
					
					//sprawdzamy czy pusty
					$dane2=$this->pobierz($val);
					
					if(!empty($dane2)){

						//sprawdzamy czy nie ma podelementow
			    	$ile=konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id_matka=".$dane2['id']);

						if($ile==0){			
												
							$this->dziennikDodaj($val,3,$dane2);													
							$this->usunImg($dane2,konf::get()->getKonfigTab("art_konf",'art_kat'),2,"img");		
														
							if(!empty($query)){ 
								$query.=","; 
							}
							$query.="'".$val."'";
							
						} //k ile
					} //k dane2
				} //k empty
			} //k while
		} //k !empty
				
		//jeśli znaleziono artykuły to ich usunięcie		
		if(!empty($query)){
		
			//usuwanie akapitow	
			$zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art_akapity')." WHERE id_matka IN (".$query.")");
			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
				$this->usunImg($dane,konf::get()->getKonfigTab("art_konf",'akapity_kat'),2,"img");		
				if(!empty($query_galerie)){ 
					$query_galerie.=","; 
				}
				$query_galerie.="'".$dane['id']."'";								
			}
			konf::get()->_bazasql->freeResult($zap);		
		
			//usuwanie galerii
			if(!empty($query_galerie)&&konf::get()->getKonfigTab("sql_tab",'art_galeria')){
				$zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art_galeria')." WHERE id_matka IN (".$query_galerie.")");
				while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
					$this->usunImg($dane,konf::get()->getKonfigTab("art_konf",'galeria_kat'),2,"img");								
		  	}		
							
				konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'art_galeria')." WHERE id_matka IN (".$query_galerie.")");												
			}
			
			konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id IN (".$query.")");
			konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'art_akapity')." WHERE id_matka IN (".$query.")");
			//usuwanie komentarzy
			if(konf::get()->getKonfigTab("sql_tab",'art_koment')){
				konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'art_koment')." WHERE id_matka IN (".$query.")");
			}
			konf::get()->setKomunikat(konf::get()->langTexty("usuwanie"),"");
		}	else {
			konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),"error"); 
		}
		user::get()->zapiszLog(konf::get()->langTexty("art_admin_a_usuwanie_log"),user::get()->login());	
	 
	}

	
  /**
   * set active
   */			
	public function aktyw(){
	
		$this->zmienparam("status",1,konf::get()->getKonfigTab("sql_tab",'art'),konf::get()->langTexty("art_admin_a_param_log"));
		
	}
	
	
  /**
   * set deactive
   */		
	public function deaktyw(){
	
		$this->zmienparam("status",0,konf::get()->getKonfigTab("sql_tab",'art'),konf::get()->langTexty("art_admin_a_param_log"));
		
	}	
	

  /**
   * usuwa blokady edycji
   */		
	public function usunblokady(){

	  require_once(konf::get()->getKonfigTab("klasy")."class.blokada.php");	
		
		$blokada=new blokada(konf::get()->getKonfigTab("sql_tab",'art_akapity'),"blokada","data_blokada","","");
		$blokada->stop();	

		konf::get()->setKomunikat(konf::get()->langTexty("art_admin_a_blok"),"");
		user::get()->zapiszLog(konf::get()->langTexty("art_admin_a_blok_log"),user::get()->login());	
		
	}
	
	
	private function naglowekArt($dane,$colspan,$edycja=true,$id_art=""){

		$d_tab=konf::get()->getKonfigTab("art_konf",'d_tab');	
	
    echo "<tr><td class=\"tlo4 lewa\" colspan=\"".$colspan."\"><table border=\"0\" cellspacing=\"0\" cellpadding=\"2\" class=\"seta\"><tr valign=\"middle\">";
		
		if(!empty($dane['id'])){

	    echo "<td class=\"seta\">";
					
			if(konf::get()->getKonfigTab("art_konf",'data_wys')&&tekstForm::niepuste($dane['data_wys'])){
		    echo "<div class=\"datownik\">".substr($dane['data_wys'],0,konf::get()->getKonfigTab("art_konf",'data_wys_dl'))."</div>";	
			}		
														
	    if($edycja){
				echo "<a class=\"grube\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_edytuj","id_nr"=>$dane['id'],"id_d"=>$this->id_d,"id_art"=>$dane['id']))."\">";			
				echo "<img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/ikony/pencil.gif\" alt=\"\" class=\"lewa\" style=\"margin-right:2px\" />";
				echo $dane['tytul'];					
				echo "</a>";							
			} else {			
				echo "<a class=\"grube\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_zobacz","id_nr"=>$dane['id'],"id_d"=>$this->id_d,"id_art"=>$dane['id']))."\">";				
				echo "<img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/ikony/page_edit.gif\" alt=\"\" class=\"lewa\" style=\"margin-right:2px\" />";						
				echo $dane['tytul'];									
				echo "</a>";											
			}
			
	    if(!empty(konf::get()->d_tab[$this->id_d])){
	      echo "<div class=\"male\" style=\"padding-left:20px\">".$d_tab[$this->id_d]."</div>";
	    }					
							
	    echo "</td>";

			echo interfejs::edytuj(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_edytuj","id_nr"=>$dane['id'],"id_d"=>$this->id_d,"id_art"=>$dane['id']))); 		
		  echo interfejs::przyciskEl("folder_wrench",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_konfigedytuj","id_nr"=>$dane['id'],"id_d"=>$this->id_d,"id_art"=>$dane['id'])),konf::get()->langTexty("art_admin_arch_edytujk")); 				
			echo interfejs::przyciskEl("page_edit",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_zobacz","id_d"=>$this->id_d,"id_art"=>$dane['id'])),konf::get()->langTexty("art_admin_edycjatresci"));										
			echo interfejs::podglad(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"art_zobacz","id_art"=>$dane['id'],"id_d"=>$this->id_d)));
			echo interfejs::infoEl($dane);		  
			echo interfejs::przyciskEl("arrow_join",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_arch","id_d"=>$this->id_d,"id_art"=>$dane['id_matka'])),konf::get()->langTexty("poziomdogory"));		
			
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
				echo interfejs::przyciskEl("arrow_join",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_arch","id_art"=>$dane['id_matka'],"id_d"=>$dane['id_d'])),konf::get()->langTexty("poziomdogory"));
	   	} else if(!empty($dane)){
				echo interfejs::przyciskEl("arrow_join",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_arch","id_d"=>$dane['id_d']))."&amp;id_d=".$this->id_d,konf::get()->langTexty("poziomdogory"));
			} else {
				echo interfejs::przyciskEl("arrow_join",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_dzialy")),konf::get()->langTexty("poziomdogory"));			
			}			

		}
		
    echo "</tr></table></td></tr>";			
	
	
	}
	
	
  /**
   * art
   */		
	public function zobacz(){

	  $id_art=tekstForm::doSql(konf::get()->getZmienna('id_art','id_art'));	
	  $podstrona=konf::get()->getZmienna('podstrona','podstrona');	
		
	  $colspan=1;

	  //lub za pomoca id
		if(!empty($id_art)){	
			$dane=$this->pobierz($id_art);
	  }	
	  
	  //jesli istnieje element
		if(!empty($dane)){
		
			$this->id_d=$dane['id_d'];
			
			$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'art_akapity')." WHERE id_matka='".$dane['id']."'";
			
			$naw = new nawig("SELECT COUNT(id) AS ilosc".$query,$podstrona,$dane['na_str']);		
			$naw->naw(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>konf::get()->getAkcja(),"id_art"=>$id_art,"id_d"=>$this->id_d)));	
			$podstrona=$naw->getPodstrona();	
										
			$query="SELECT * ".$query." ORDER BY nr_poz,id ";					
			if(!empty($dane['na_str'])){
				$query.="LIMIT ".$naw->getStart().",".$naw->getIle();
			}
			  	
			$zap2=konf::get()->_bazasql->zap($query);

			//licznik petli
			$i=0;
			
			$ile=konf::get()->_bazasql->numRows($zap2);
			
			require_once(konf::get()->getKonfigTab('klasy')."class.akapitform.php");				
		  require_once(konf::get()->getKonfigTab("klasy")."class.blokada.php");	
					
			$blokada=new blokada(konf::get()->getKonfigTab("sql_tab",'art_akapity'),"blokada","data_blokada",konf::get()->getKonfigTab("art_konf",'blokada'));	
					
			$this->sciezka();

			echo tab_nagl(konf::get()->langTexty("art_admin_edycjatresci"));			
			
			$this->naglowekArt($dane,$colspan,true);		
	
			if($naw->getNaw()){
				echo "<tr><td class=\"tlo3\">".$naw->getNaw()."</td></tr>";
			}	
			
			echo "<tr><td class=\"tlo3\">";			
			
			$link4=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_art"=>$dane['id'],"id_d"=>$this->id_d));
			  					
			//przelatujemy akapity
			$dane_akapitow=array();
			$pobierz_galerie="";
			
			//pobierz akapity
			while($dane2=konf::get()->_bazasql->fetchAssoc($zap2)){
				$dane_akapitow[$dane2['id']]=$dane2;
				if(!empty($pobierz_galerie)){ 
					$pobierz_galerie.=","; 
				}
				$pobierz_galerie.="'".$dane2['id']."'";				
			}
	 		konf::get()->_bazasql->freeResult($zap2);	
			
			//pobierz galerie
			if(!empty($pobierz_galerie)&&konf::get()->getKonfigTab("sql_tab",'art_galeria')){
			
				require_once(konf::get()->getKonfigTab('klasy')."class.galeria.php");				
			
				$zap2=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art_galeria')." WHERE id_matka IN (".$pobierz_galerie.") AND status=1 AND obrobka=0 ORDER BY id_matka,nr_poz,id");
				while($dane2=konf::get()->_bazasql->fetchAssoc($zap2)){
					$galerie[$dane2['id_matka']][$dane2['id']]=$dane2;		
				}
		 		konf::get()->_bazasql->freeResult($zap2);				
				
			}
							
			$art=new art();			
						
			if(konf::get()->getKonfigTab("art_konf",'podtytul')&&!empty($dane['podtytul'])){
		    echo "<div class=\"podtytul\">".$dane['podtytul']."</div>";	
			}												

			reset($dane_akapitow);
			while(list($key,$dane2)=each($dane_akapitow)){
					
				$i++;

				echo "<div class=\"ramka nowa_l\">";						
				echo "<div class=\"male\">";
				echo interfejs::wstaw($link4."&amp;akcja=artadmin_akapitydodaj&amp;id_nad=".$dane2['id']);
				echo "</div>";
				echo "<div class=\"male\">".konf::get()->langTexty("art_akapit_admin")."</div>"; 		        
  	    echo "<div class=\"grube male\">";
    	  if($dane2['status']==1){ 
      		echo konf::get()->langTexty("art_akapit_widoczny"); 
	      } else { 
          echo konf::get()->langTexty("art_akapit_niewidoczny"); 
        }
        echo "</div>";
       	//sprawdzamy czy ktos aktualnie edytuje ten artykul
      	if(!$blokada->dostepny($dane2['blokada'], $dane2['data_blokada'])){
        	echo "<div class=\"error nowa_l male\">".konf::get()->langTexty("art_aktualnie")." ".$dane2['blokada']."</div>";
	      } else {
					echo "<table border=\"0\" style=\"margin-top:5px\"><tr>";    
			    echo interfejs::edytuj($link4."&amp;akcja=artadmin_akapityedytuj&amp;id_nr=".$dane2['id']);  
			    echo interfejs::przyciskEl("folder_wrench",$link4."&amp;akcja=artadmin_akapitykonfigedytuj&amp;id_nr=".$dane2['id'],konf::get()->langTexty("art_akapity_edytujk")); 
					if(konf::get()->getKonfigTab("art_konf",'galeria')){
				    echo interfejs::przyciskEl("picture",$link4."&amp;akcja=artadmin_galeria&amp;id_akapit=".$dane2['id'],konf::get()->langTexty("art_akapity_galeria")); 		
					}					
					echo interfejs::pozycja($link4."&amp;akcja=artadmin_akapitypoz&amp;id_nr=".$dane2['id'],$i,$ile,$podstrona,$naw->getStron());	
					echo interfejs::infoEl($dane2);					
					echo interfejs::usun($link4."&amp;podstrona=".$podstrona."&amp;akcja=artadmin_akapityusun&amp;id_tab[1]=".$dane2['id']);
					echo "</tr></table>";  					
        }				
        echo "</div>";
				
				if(konf::get()->getKonfigTab("sql_tab",'art_galeria')&&!empty($galerie[$dane2['id']])){				
					echo $art->akapit($dane,$dane2,$galerie[$dane2['id']]);				
				} else {
					echo $art->akapit($dane,$dane2);				
				}
     
		 	}
					
	    echo "<div class=\"ramka nowa_l\">";
			echo interfejs::wstaw($link4."&amp;akcja=artadmin_akapitydodaj");
	    echo "</div>";	
			
			echo "</td></tr>";
			
			if($naw->getNaw()){
				echo "<tr><td class=\"tlo3\">".$naw->getNaw()."</td></tr>";
			}	
			
			echo "<tr class=\"srodek\"><td class=\"tlo4\">".interfejs::linkEl("folder_explore",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_arch","id_art"=>$id_art,"id_d"=>$this->id_d)),konf::get()->langTexty("art_admin_form_listas"))."</td></tr>";

			echo tab_stop();
			
		} else {
			interfejs::nieprawidlowe();
		}

	}
	

  /**
   * akapity menu
   * @param array $dane
   */		
	public function akapityMenu($dane){

		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_art"=>$dane['id_matka'],"id_d"=>$this->id_d));

		echo "<table border=\"0\" style=\"margin-top:5px\"><tr>";    
    echo interfejs::edytuj($link."&amp;akcja=artadmin_akapityedytuj&amp;id_nr=".$dane['id']);  
    echo interfejs::przyciskEl("folder_wrench",$link."&amp;akcja=artadmin_akapitykonfigedytuj&amp;id_nr=".$dane['id'],konf::get()->langTexty("art_akapity_edytujk")); 
		if(konf::get()->getKonfigTab("art_konf",'galeria')){
	    echo interfejs::przyciskEl("picture",$link."&amp;akcja=artadmin_galeria&amp;id_akapit=".$dane['id'],konf::get()->langTexty("art_akapity_galeria")); 		
		}
		echo interfejs::infoEl($dane);		
		echo interfejs::usun($link."&amp;akcja=artadmin_akapityusun&amp;id_tab[1]=".$dane['id']);
		
		echo interfejs::przyciskEl("arrow_join",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_zobacz","id_d"=>$this->id_d,"id_art"=>$dane['id_matka'])),konf::get()->langTexty("poziomdogory"));		
	
		echo "</tr></table>";  		
	
	}
	
  /**
   * galeria menu
   * @param array $dane
   */		
	public function galeriaMenu($dane){

		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_akapit"=>$dane['id_matka'],"id_d"=>$this->id_d));

		echo "<table border=\"0\" style=\"margin-top:5px\"><tr>";    
    echo interfejs::edytuj($link."&amp;akcja=artadmin_galeriaedytuj&amp;id_nr=".$dane['id']);  
    echo interfejs::przyciskEl("folder_wrench",$link."&amp;akcja=artadmin_galeriakonfigedytuj&amp;id_nr=".$dane['id'],konf::get()->langTexty("art_galeria_edytujk")); 
	  echo interfejs::przyciskEl("picture",$link."&amp;akcja=artadmin_galeria&amp;id_akapit=".$dane['id_matka'],konf::get()->langTexty("art_akapity_galeria")); 		
		echo interfejs::infoEl($dane);		
		echo interfejs::usun($link."&amp;akcja=artadmin_galeriausun&amp;id_tab[1]=".$dane['id']);		
	  echo interfejs::przyciskEl("arrow_join",$link."&amp;akcja=artadmin_galeria&amp;id_akapit=".$dane['id_matka'],konf::get()->langTexty("powrot")); 		

		echo "</tr></table>";  		
	
	}	

	
	/**
   * galeria arch
   */		
	public function galeria(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$sortuj=tekstForm::doSql(konf::get()->getZmienna('sortuj','sortuj'));
		$id_akapit=tekstForm::doSql(konf::get()->getZmienna('id_akapit','id_akapit'));
		
		$id_art="";		
		if(!empty($id_akapit)){
			$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art_akapity')." WHERE id='".$id_akapit."'");
			if(!empty($dane)){
				$id_art=$dane['id_matka'];
			}
		}		
		
		//dzial od elementu nadrzednego

		if(!empty($id_art)){
			$dane2=$this->pobierz($id_art,true);
		}

		
		if(!empty($dane)&&!empty($dane2)){
		
			$this->id_d=$dane2['id_d'];
			konf::get()->setZmienna('_post','id_art',$dane2['id']);		
			
			$colspan=5;
			
	    if(konf::get()->getKonfigTab("art_konf",'galeria_licznik')){
	      $colspan++;
	    }
			
	    if(konf::get()->getKonfigTab("art_konf",'galeria_punkty')){
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

	    $query=" FROM ".konf::get()->getKonfigTab("sql_tab",'art_galeria')." WHERE id_matka='".$id_akapit."' "; 
			
		?><script type="text/javascript">
	
			function spr_galeriau(){
			
				ok=true;
			
				if(document.arch.akcja.value=="artadmin_galeriausun"){ 				
					if(!confirm("<?php echo konf::get()->langTexty("czyusun"); ?>")){ 
						ok=false; 
					}
				}
				
				return ok;
				
			}
			
		</script><?php			

			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"arch","arch");
			echo $form->spr(array(1=>"akcja"),"","ok=spr_galeriau();");
			echo $form->getFormp();
			echo $form->przenies(array(
				"sortuj"=>$sortuj,
				"id_akapit"=>$id_akapit,
				"id_d"=>$this->id_d,
				"id_art"=>$id_art,				
				"podstrona"=>$podstrona
			));

	    //sciezki do linkow
	    $link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_galeria","id_akapit"=>$id_akapit,"id_d"=>$this->id_d,"id_art"=>$id_art));
	    $link4=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_d"=>$this->id_d, "id_art"=>$id_art));
	    $link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_d"=>$this->id_d, "id_akapit"=>$id_akapit,"sortuj"=>$sortuj,"podstrona"=>$podstrona,"id_art"=>$id_art));
	    $link3=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"art_zobacz"));
						
	    //nawigator;
			$this->sciezka();    
			
			$naw = new nawig("SELECT COUNT(id) AS ilosc".$query,$podstrona,konf::get()->getKonfigTab("art_konf",'galeria_na_str'));		
			$naw->naw($link."&amp;sortuj=".$sortuj);
			$podstrona=$naw->getPodstrona();				
	    
	    //naglowek
	    echo tab_nagl(konf::get()->langTexty("artadmin_galeria")." (".$naw->getIle()."):",$colspan);
			
			$this->naglowekArt($dane2,$colspan,true,$id_art);			
			

	    echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 lewa\">";
			
	    //akcje  
			$akcje_tab['artadmin_galeriadodaj']=konf::get()->langTexty("adodaj");
			$akcje_tab['artadmin_galeriawytnij']=konf::get()->langTexty("awytnij");
	    if(konf::get()->getZmienna('','','galeriaa_wytnij_tab')){
				$akcje_tab['artadmin_galeriawklej']=konf::get()->langTexty("awklej");		
	    }   
			$akcje_tab['artadmin_galeriaaktyw']=konf::get()->langTexty("aaktyw");
			$akcje_tab['artadmin_galeriadeaktyw']=konf::get()->langTexty("adeaktyw");
			$akcje_tab['artadmin_galeriausun']=konf::get()->langTexty("ausun");

			echo $form->selectAkcja($akcje_tab);
			echo "</td></tr>";					
			

	    //pobieranie danych  
	    $query="SELECT * ".$query." ORDER BY ".$tab_sort[$sortuj].",id";
	    $query.=" LIMIT ".$naw->getStart().",".$naw->getIle();
					
	    $zap=konf::get()->_bazasql->zap($query);
	    $ile=konf::get()->_bazasql->numRows($zap);  
	    $i=0;			
			
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

			echo interfejs::sortEl($link."&amp;sortuj=",1,2,konf::get()->langTexty("artadmin_gal_nr"),$sortuj,70);			
			echo interfejs::sortEl($link."&amp;sortuj=",5,6,konf::get()->langTexty("artadmin_gal_zdjecie"),$sortuj);
			echo interfejs::sortEl(""."","","","&nbsp;","",200);			
			echo interfejs::sortEl("","","",konf::get()->langTexty("artadmin_gal_param"),"",120);					
			echo interfejs::sortEl($link."&amp;sortuj=",7,8,konf::get()->langTexty("artadmin_gal_status"),$sortuj,70);			
	    if(konf::get()->getKonfigTab("art_konf",'galeria_licznik')){
				echo interfejs::sortEl($link."&amp;sortuj=",9,10,konf::get()->langTexty("artadmin_gal_wys"),$sortuj,70);		
	    }
	    if(konf::get()->getKonfigTab("art_konf",'galeria_punkty')){
				echo interfejs::sortEl($link."&amp;sortuj=",11,12,konf::get()->langTexty("artadmin_gal_glosow"),$sortuj,70);		
				echo interfejs::sortEl($link."&amp;sortuj=",13,14,konf::get()->langTexty("artadmin_gal_ocen"),$sortuj,70);					
	    }			

	    echo "</tr>";
	    
	    while($dane3=konf::get()->_bazasql->fetchAssoc($zap)){
			
	      $i++;
	      echo "<tr><td class=\"tlo3 lewa\" colspan=\"".$colspan."\">";
				echo interfejs::wstaw($link2."&amp;akcja=artadmin_galeriadodaj&amp;id_nad=".$dane3['id']);			
				echo "</td></tr>";
				
	      echo "<tr class=\"srodek\">";
				
				echo "<td class=\"tlo4 srodek\">";
				echo $form->checkbox("id_tab[]","id_".$dane3['id'],$dane3['id'],"");	
	      echo "<div class=\"male\">".$dane3['nr_poz']."(".$dane3['id'].")</div>";					
	      echo "</td>";		
 
	      echo "<td class=\"tlo3 srodek\">";
				
				if(!empty($dane3['tytul'])){
			    echo "<div style=\"padding-bottom:5px;\"><a class=\"admin_link\" href=\"".$link2."&amp;akcja=artadmin_galeriaedytuj&amp;id_nr=".$dane3['id']."\">".$dane3['tytul']."</a></div>";
				}
				
				echo "<div>";
				echo "<a class=\"admin_link\" href=\"".$link2."&amp;akcja=artadmin_galeriaedytuj&amp;id_nr=".$dane3['id']."\">";
				if(!empty($dane3['img2_nazwa'])&&file_exists(konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("art_konf",'galeria_kat').$dane3['img2_nazwa'])){
	  			echo "<img src=\"".konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("art_konf",'galeria_kat').$dane3['img2_nazwa']."\" class=\"obrazek\" width=\"".$dane3['img2_w']."\" height=\"".$dane3['img2_h']."\" alt=\"\" />"; 
	  		}						
				echo "</a>";
				echo "</div>";
				
				echo "</td>";
				
	      echo "<td class=\"tlo3 srodek\">";
				
				echo "<div class=\"srodek\"><table border=\"0\" style=\"margin-top:5px\" class=\"srodek\"><tr>";    				
		    echo interfejs::edytuj($link2."&amp;akcja=artadmin_galeriaedytuj&amp;id_nr=".$dane3['id']);				
		    echo interfejs::przyciskEl("folder_wrench",$link2."&amp;akcja=artadmin_galeriakonfigedytuj&amp;id_nr=".$dane3['id'],konf::get()->langTexty("artadmin_gal_eplik")); 	
				echo interfejs::infoEl($dane);			
				echo interfejs::usun($link2."&amp;akcja=artadmin_galeriausun&amp;id_tab[1]=".$dane3['id']); 
				echo "</tr></table></div>";   
				
				echo "<div class=\"srodek\"><table border=\"0\" style=\"margin-top:5px\" class=\"srodek\"><tr>";    
				echo interfejs::pozycja($link2."&amp;akcja=artadmin_galeriapoz&amp;id_nr=".$dane3['id'],$i,$ile,$podstrona,$naw->getStron());
				echo "</tr></table></div>";   				
				
	      echo "</td>";
				
				echo "<td class=\"tlo3 srodek\">";				
	      echo "<div>".konf::get()->langTexty("artadmin_gal_szerokosc").": <span class=\"grube\">".$dane3['img1_w']."</span>".konf::get()->langTexty("artadmin_gal_px")."</div>";					
	      echo "<div>".konf::get()->langTexty("artadmin_gal_wysokosc").": <span class=\"grube\">".$dane3['img1_h']."</span>".konf::get()->langTexty("artadmin_gal_px")."</div>";					
	      echo "</td>";						
	      
	      //status  
	      echo "<td class=\"tlo3\">";
	      if($dane3['status']==1){ 
					echo konf::get()->langTexty("aktywne"); 
				} else { 
					echo konf::get()->langTexty("nieaktywne"); 
				}
			
		    if(konf::get()->getKonfigTab("art_konf",'galeria_obrobka')&&!empty($dane3['obrobka'])){
		      echo "<div class=\"grube\">".konf::get()->langTexty("artadmin_gal_obrobka")."</div>";
		    }							
	      echo "</td>";
	      
	      //licznik ogladalnosci
	      if(konf::get()->getKonfigTab("art_konf",'galeria_licznik')){
	        echo "<td class=\"tlo3\">".$dane3['licznik']."</td>";
	      }
				
	      //licznik ogladalnosci
	      if(konf::get()->getKonfigTab("art_konf",'galeria_punkty')){
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
				echo interfejs::wstaw($link2."&amp;akcja=artadmin_galeriadodaj");
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
			echo interfejs::linkEl("folder_explore",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_zobacz","id_art"=>$dane2['id'],"id_d"=>$this->id_d)),konf::get()->langTexty("artadmin_gal_powrot"));
			echo "</td></tr>";
			
	    echo tab_stop();
	    echo $form->getFormk();
			
	  } else {
			interfejs::nieprawidlowe();
	  }
		  
	}
	
		
	/**
   * akapity poz
   */		
	public function galeriapoz(){
	
		require_once(konf::get()->getKonfigTab("klasy")."class.galeriaadmin.php");		
		$galeria=new galeriaadmin(konf::get()->getKonfigTab("sql_tab",'art_galeria'),konf::get()->getKonfigTab("art_konf",'galeria_kat'));		
		$galeria->poz();		
		
	}	
	
	
  /**
   * change parameter
   * @param string $param
   * @param string $wartosc
   */		
	private function galeriazmienparam($param,$wartosc){
	
		require_once(konf::get()->getKonfigTab("klasy")."class.galeriaadmin.php");		
		$galeria=new galeriaadmin(konf::get()->getKonfigTab("sql_tab",'art_galeria'),konf::get()->getKonfigTab("art_konf",'galeria_kat'));		
		$galeria->zmienparam($param,$wartosc,konf::get()->langTexty("art_admin_gal_param_log"));	

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
   * art akapity remove
   */		
	public function galeriausun(){
	
		require_once(konf::get()->getKonfigTab("klasy")."class.galeriaadmin.php");		
		$galeria=new galeriaadmin(konf::get()->getKonfigTab("sql_tab",'art_galeria'),konf::get()->getKonfigTab("art_konf",'galeria_kat'));		
		$galeria->usun(konf::get()->langTexty("art_admin_galeria_usun_log"));
		
	}
		

	/**
   * cut
   */		
	public function galeriawytnij(){
			
		require_once(konf::get()->getKonfigTab("klasy")."class.galeriaadmin.php");		
		$galeria=new galeriaadmin(konf::get()->getKonfigTab("sql_tab",'art_galeria'),konf::get()->getKonfigTab("art_konf",'galeria_kat'));		
		$galeria->wytnij("galeriaa_wytnij_tab",konf::get()->langTexty("art_admin_wklej_wyt"));

	}
	
	
	/**
   * paste
   */		
	public function galeriawklej(){

		//element nadrzedny
		$id_akapit=tekstForm::doSql(konf::get()->getZmienna('id_akapit','id_akapit'));

		//sprawdzamy czy sa dane
		if(!empty($id_akapit)){
		
		  //pobieramy nowe dane
	  	$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art_akapity')." WHERE id='".$id_akapit."'");				
	  	
	  	//gdy istnieje strona i jest w tej samej wersji jezykowej lub gdy istnieje dzial
			if(!empty($dane)){	

				require_once(konf::get()->getKonfigTab("klasy")."class.galeriaadmin.php");		
				$galeria=new galeriaadmin(konf::get()->getKonfigTab("sql_tab",'art_galeria'),konf::get()->getKonfigTab("art_konf",'galeria_kat'));		
				$galeria->wklej($dane,"galeriaa_wytnij_tab");
			
			}
			
		}
				  
	}
	
	
	private function pobierzAkapitByZdjecie($id_akapit,$id_nr){
	
		$dane2=array();
	
		if(!empty($id_nr)){
	    //pobranie aktualne dane   
		  $dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art_galeria')." WHERE id='".$id_nr."'");
		  
		  if(empty($dane)){
		  	$id_nr="";
		  } else {
		  	$id_akapit=$dane['id_matka'];
		  }
		}
				
		if(!empty($id_akapit)){
			$dane2=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art_akapity')." WHERE id='".$id_akapit."'");
		}	
		
		return $dane2;	
	
	}
	
	
	private function galeriaKonfig($dane2){
	
		$rozmiary=array();
		$rozmiary['galeria_o_size']=konf::get()->getKonfigTab("art_konf",'galeria_o_size');
		$rozmiary['galeria_min_size']=konf::get()->getKonfigTab("art_konf",'galeria_min_size');			
		$rozmiary['galeria_m_w']=konf::get()->getKonfigTab("art_konf",'galeria_m_size');	
		$rozmiary['galeria_m_h']=konf::get()->getKonfigTab("art_konf",'galeria_m_size');				
		$rozmiary['galeria_img_size']=konf::get()->getKonfigTab("art_konf",'galeria_img_size');
		$rozmiary['galeria_skala']=konf::get()->getKonfigTab("art_konf",'galeria_skalowanie');						
		if(!empty($dane2['galeria_skala'])){
			$rozmiary['galeria_skala']=$dane2['galeria_skala'];						
		}			
		if(!empty($dane2['galeria_m_w'])){
			$rozmiary['galeria_m_w']=$dane2['galeria_m_w'];					
		}							
		if(!empty($dane2['galeria_m_h'])){
			$rozmiary['galeria_m_h']=$dane2['galeria_m_h'];					
		}		
		
		return $rozmiary;		
	
	}
	
	
	/**
   * gallery save
   */		
	public function galeriaobrot(){
	
		$id_akapit=tekstForm::doSql(konf::get()->getZmienna('id_akapit','id_akapit'));
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));		
		$dane2=$this->pobierzAkapitByZdjecie($id_akapit,$id_nr);
	
		//sprawdzamy czy sa dane
		if(!empty($dane2)){
		
			require_once(konf::get()->getKonfigTab("klasy")."class.galeriaadmin.php");		
			$galeria=new galeriaadmin(konf::get()->getKonfigTab("sql_tab",'art_galeria'),konf::get()->getKonfigTab("art_konf",'galeria_kat'));					
			$rozmiary=$this->galeriaKonfig($dane2);
			$ok=$galeria->obrot($dane2,konf::get()->getKonfigTab("art_konf",'galeria_obrobka'),$rozmiary,konf::get()->langTexty("art_admin_gal_kobrot"));

		  if(!empty($ok)){
				$this->updateEdytor($dane2['id_matka']);
		  }	

		}	
		
	}		

	
	/**
   * gallery save
   */		
	public function galeriakonfigedytuj2(){
		
		$id_akapit=tekstForm::doSql(konf::get()->getZmienna('id_akapit','id_akapit'));
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));
		
		$dane2=$this->pobierzAkapitByZdjecie($id_akapit,$id_nr);
	
		//sprawdzamy czy sa dane
		if(!empty($dane2)){
		
			require_once(konf::get()->getKonfigTab("klasy")."class.galeriaadmin.php");		
			$galeria=new galeriaadmin(konf::get()->getKonfigTab("sql_tab",'art_galeria'),konf::get()->getKonfigTab("art_konf",'galeria_kat'));					
			$rozmiary=$this->galeriaKonfig($dane2);
			$ok=$galeria->konfigedytuj2($dane2,konf::get()->getKonfigTab("art_konf",'galeria_obrobka'),$rozmiary,konf::get()->langTexty("art_admin_gal_kedycja"));
			
		  if(!empty($ok)){
				$this->updateEdytor($dane2['id_matka']);			
		  }	

		}	
		
	}	
		
	
	public function galeriakonfigedytuj(){
	
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$id_akapit=tekstForm::doSql(konf::get()->getZmienna('id_akapit','id_akapit'));	
	 	$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));	
	
		if(!empty($id_nr)){
			$danea=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art_galeria')." WHERE id='".$id_nr."'");
			if(!empty($danea)){
				$dane=$danea;
			} else {
				$id_nr="";
			}
		}				
	
		$dane2=$this->pobierzAkapitByZdjecie($id_akapit,$id_nr);		
	
		$id_art="";
		if(!empty($dane2)){
			$id_art=$dane2['id_matka'];
		}
		
		//dzial od elementu nadrzednego
		if(!empty($id_art)){
			$dane3=$this->pobierz($id_art,true);
		}

		if(!empty($dane2)&&!empty($dane3)){	
			
			konf::get()->setZmienna('_post','id_art',$dane3['id']);		
			$this->id_d=$dane3['id_d'];

			$this->sciezka();
			 
	  	echo tab_nagl(konf::get()->langTexty("artadmin_galf_pkonfig"),1);

			$this->naglowekArt($dane3,1,true,$id_art);
			
		  echo "<tr><td valign=\"top\" class=\"tlo3\">";

			if(!empty($id_nr)){
				$this->galeriaMenu($dane);
			}
			
			$przenies["id_d"]=$this->id_d;
			$przenies["id_akapit"]=$id_akapit;	
			$przenies["id_art"]=$id_art;								
			$linkobrot=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_galeriaobrot","id_akapit"=>$id_akapit,"id_d"=>$this->id_d,"id_nr"=>$id_nr));									
			require_once(konf::get()->getKonfigTab("klasy")."class.galeriaadmin.php");		
			$galeria=new galeriaadmin(konf::get()->getKonfigTab("sql_tab",'art_galeria'),konf::get()->getKonfigTab("art_konf",'galeria_kat'));						
			$galeria->konfigedytuj($dane,$dane2,$przenies,konf::get()->getKonfigTab("art_konf",'galeria_obrobka'),$linkobrot);
			
			echo "</td></tr>";
			
			echo "<tr class=\"srodek\"><td class=\"tlo4\">".interfejs::linkEl("folder_explore",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_galeria","id_akapit"=>$id_akapit,"id_d"=>$this->id_d)),konf::get()->langTexty("artadmin_galf_powrot"))."</td></tr>";
	  	echo tab_stop();

			
	  } else {
			echo interfejs::nieprawidlowe();	
	  }
	
	}
	
	/**
   * art akapity form
   */		
	private function galeriaForm(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$id_akapit=tekstForm::doSql(konf::get()->getZmienna('id_akapit','id_akapit'));	
	 	$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));
		$id_nad=tekstForm::doSql(konf::get()->getZmienna('id_nad','id_nad'));
		
		$dane2=$this->pobierzAkapitByZdjecie($id_akapit,$id_nr);				

		$id_art="";
		if(!empty($dane2)){
			$id_art=$dane2['id_matka'];
		}

		//dzial od elementu nadrzednego
		if(!empty($id_art)){
			$dane3=$this->pobierz($id_art,true);
		}
		
		$dane=array();
		
		if(!empty($id_nr)){
			$danea=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art_galeria')." WHERE id='".$id_nr."'");
			if(!empty($danea)){
				$dane=$danea;
			} else {
				$id_nr="";
			}
		}				

		if(!empty($dane2)&&!empty($dane3)){
		
			konf::get()->setZmienna('_post','id_art',$dane3['id']);		
			$this->id_d=$dane3['id_d'];

			$this->sciezka();
			 
			if(konf::get()->getAkcja()=="artadmin_galeriadodaj"){
	  		echo tab_nagl(konf::get()->langTexty("artadmin_galf_dodawanie"),1);
		  } else {
	  	  echo tab_nagl(konf::get()->langTexty("artadmin_galf_edycja"),1);
		  }
			
			$this->naglowekArt($dane3,1,true,$id_art);			

		  echo "<tr><td valign=\"top\" class=\"tlo3\">";

			if(!empty($id_nr)){
				$this->galeriaMenu($dane);
			}
			
			echo "<br />";   
			
			$przenies["id_d"]=$this->id_d;
			$przenies["id_art"]=$id_art;			
			$przenies["id_akapit"]=$id_akapit;				
			require_once(konf::get()->getKonfigTab("klasy")."class.galeriaadmin.php");		
			$galeria=new galeriaadmin(konf::get()->getKonfigTab("sql_tab",'art_galeria'),konf::get()->getKonfigTab("art_konf",'galeria_kat'));							
			$galeria->formularz($dane,$przenies,konf::get()->getKonfigTab("art_konf",'galeria_opis'),konf::get()->getKonfigTab("art_konf",'galeria_licznik'),konf::get()->getKonfigTab("art_konf",'galeria_punkty'),konf::get()->getKonfigTab("art_konf",'galeria_obrobka'));
			
			echo "</td></tr>";
			
			echo "<tr class=\"srodek\"><td class=\"tlo4\">".interfejs::linkEl("folder_explore",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_galeria","id_akapit"=>$id_akapit,"id_d"=>$this->id_d)),konf::get()->langTexty("artadmin_galf_powrot"))."</td></tr>";
	  	echo tab_stop();
			
	  } else {
			echo interfejs::nieprawidlowe();	
	  }
		
	}
	
	/**
   * art add
   */		
	public function galeriadodaj(){	
		$this->galeriaForm();
	}
	
	
	/**
   * art edit
   */		
	public function galeriaedytuj(){	
		$this->galeriaForm();
	}		
	
	
	
	/**
   * gallery save
   */		
	private function galeriaZapisz(){
	
		$id_akapit=tekstForm::doSql(konf::get()->getZmienna('id_akapit','id_akapit'));
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));		
		$dane2=$this->pobierzAkapitByZdjecie($id_akapit,$id_nr);
		
		if(!empty($dane2)){
			$id_art=$dane2['id_matka'];
		}		
		
		//dzial od elementu nadrzednego
		if(!empty($id_art)){
			$dane3=$this->pobierz($id_art,true);
		}
		
		//sprawdzamy czy sa dane
		if(!empty($dane2)&&!empty($dane3)){
		
			require_once(konf::get()->getKonfigTab("klasy")."class.galeriaadmin.php");		
			$galeria=new galeriaadmin(konf::get()->getKonfigTab("sql_tab",'art_galeria'),konf::get()->getKonfigTab("art_konf",'galeria_kat'));					
			$rozmiary=$this->galeriaKonfig($dane2);
			
			$ok=$galeria->zapisz($dane2,konf::get()->getKonfigTab("art_konf",'galeria_obrobka'),$rozmiary,konf::get()->langTexty("art_admin_gal_dodaniek"),konf::get()->langTexty("art_admin_gal_edycjak"));
			
		  if(!empty($ok)){
				$this->updateEdytor($dane2['id_matka']);			
		  }	

		}	else {		
			konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 					
		}

		if(empty($ok)){
			konf::get()->setAkcja("artadmin_galeria");				
		} else {
			if(konf::get()->getAkcja()=="artadmin_galeriadodaj2"){
				konf::get()->setAkcja("artadmin_galeria");					
			} else {
				konf::get()->setAkcja("artadmin_galeriaedytuj");					
			}
		}
		
	}	


	/**
   * art add
   */		
	public function galeriadodaj2(){	
		$this->galeriaZapisz();
	}
		
	/**
   * art edit
   */		
	public function galeriaedytuj2(){	
		$this->galeriaZapisz();
	}	
		
		
	/**
   * update the art's editor time and name
   */				
	private function updateEdytor($id_art){
	
		konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'art')." SET edytor_id='".user::get()->id()."', edytor_name='".user::get()->autor()."', edytor_kiedy=NOW() WHERE id='".$id_art."'");
	
	}		
	
	/**
   * class constructor php5	
   */	
	public function __construct() {	
		
		$this->_admin=konf::get()->getKonfigTab("art_konf",'admin_art');
		$this->id_d=konf::get()->getZmienna("id_d",'id_d');
		
  }	

		
}

?>