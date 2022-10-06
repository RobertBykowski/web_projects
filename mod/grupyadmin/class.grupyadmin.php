<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

include_once(konf::get()->getKonfigTab('mod_kat')."grupy/konfig_inc.php");

class grupyadmin extends moduladmin {

	/**
	 * Privates variables
	 */

		
	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="grupyadmin class";	
	
	
	/**
	 * get search values
	 */		
	protected $_szuk=array(
		"szuk_nazwa"=>"",		
		"typ"=>"",			
	);	
		
		
  /**
   * date format
   */	
	private function dataForm($data,$br=false){
	
		$data=tekstForm::niepuste(substr($data,0,16));
		
		if($br){
			$data=str_replace(" ","<br />",$data);
		}
		
		return $data;
	
	}

	
	public function typy(){
	
		$typy_tab=konf::get()->getKonfigTab("grupy_konf",'typy_tab');		
		$colspan=2;				
		$ilosci_tab=konf::get()->_bazasql->pobierzRekordy("SELECT typ, COUNT(id) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'grupy')." WHERE status=1 GROUP BY typ","typ");
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupyadmin_arch"));
		
		echo tab_nagl("Kategorie grup",$colspan);

		echo "<tr>";		
		echo "<td class=\"tlo4 lewa grube\">nazwa</td>";
		echo "<td class=\"tlo4 prawa grube\" style=\"width:50px\">ilość</td>";
		echo "</tr>";		
		
		while(list($key,$val)=each($typy_tab)){		
		
			echo "<tr>";
			echo interfejs::innyEl("group","<a href=\"".$link."&amp;typ=".$key."\">".$val."</a>","tlo3");
			echo "<td class=\"tlo3 prawa\">";
			if(!empty($ilosci_tab[$key])){
				echo $ilosci_tab[$key]['ile'];
			} else {
				echo "0";
			}
			echo "</td></tr>";		
			
		}	

		echo tab_stop();
		
		$this->wyszukiwarka();		
	
	}
	
	
	private function wyszukiwarka(){
	
		$typy_tab=konf::get()->getKonfigTab("grupy_konf",'typy_tab');			
		
		echo tab_nagl("Wyszukaj grupę");
		echo "<tr><td class=\"lewa tlo3\">";
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"u_arch2","u_arch2");
		echo $form->getFormp();
		echo $form->przenies(array("akcja"=>"grupyadmin_arch"));		
		echo $form->input("text","szuk_nazwa","szuk_nazwa",$this->_szuk['szuk_nazwa'],"f_dlugi",50);	
		echo "&nbsp;";
		echo $form->select("typ","typ",$typy_tab,$this->_szuk['typ'],"f_dlugi","--wybierz kategorię--");
		echo "&nbsp;";
		echo $form->input("submit","","",konf::get()->langTexty("szukaj"),"formularz2 f_sredni");	
		echo $form->getFormk();		
		
		echo "</td></tr>";
		echo tab_stop();
			
	}
	
	private function grupyRekord($dane){	
	
		if(!empty($dane)){
		
			$this->grupyLogo($dane,2,true);
			echo "<div class=\"grube\"><a href=\"".$this->grupLink($dane)."\">".$dane['nazwa']."</a></div>";
			echo $dane['opis_krotki'];
		
		}
	
	}
	
	
	private function grupyLogo($dane,$numer=2,$link=true){
	
		$html="";
		
    if(!empty($dane['img'.$numer.'_nazwa'])&&file_exists(konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("grupy_konf",'kat').$dane['img'.$numer.'_nazwa'])){
			if($link){
				$html.="<a href=\"".$this->grupLink($dane)."\">";
			}
			$html.="<img src=\"".konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("grupy_konf",'kat').$dane['img'.$numer.'_nazwa']."\" alt=\"".htmlspecialchars($dane['nazwa'])."\" />";
			if($link){
				$html.="</a>";			
			}
 		}
		
		return $html;
					
	}
	
	
	private function grupLink($dane){
	
		$html=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupyadmin_edytuj","id_grupa"=>$dane['id']));
		
		return $html;
		
	}
	
	
	public function moje(){
	
		$podstrona=konf::get()->getZmienna("podstrona","podstrona");	
		$sortuj=tekstForm::doSql(konf::get()->getZmienna("sortuj","sortuj"));				
		$na_str=konf::get()->getKonfigTab("grupy_konf",'na_strm');
		$typy_tab=konf::get()->getKonfigTab("grupy_konf",'typy_tab');
		$colspan=4;	
			
		$tab_sort=array(
			1=>"p.id", 2=>"p.id DESC", 
			3=>"p.nazwa", 4=>"p.nazwa DESC", 
			5=>"p.autor_kiedy, p.id", 6=>"p.autor_kiedy DESC, p.id DESC", 
			7=>"p.osoby", 8=>"p.osoby DESC", 			
			9=>"p.data_aktywnosci", 10=>"p.data_aktywnosci DESC", 			
			11=>"p.wypowiedzi", 12=>"p.wypowiedzi DESC",	
			13=>"u.data_dodania", 14=>"u.data_dodania DESC", 							
		);	
		
		if(empty($tab_sort[$sortuj])){ 		
			$sortuj=6; 
		}	

		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>konf::get()->getAkcja()));			
		$link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane"));													
		
		$tytul="Moje grupy";

		$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'grupy')." p LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." u ON p.id=u.id_grupa WHERE u.id_u='".user::get()->id()."'";

		$naw = new nawig("SELECT COUNT(p.id) AS ilosc ".$query,$podstrona,$na_str);		
		$naw->naw($link);
		$podstrona=$naw->getPodstrona();	

		echo tab_nagl($tytul." (".$naw->getWynikow()."):",$colspan);	

		if($naw->getNaw()){
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
		}	
		
		echo "<tr class=\"srodek\">";		
		echo interfejs::sortEl($link."&amp;sortuj=","","","",$sortuj,80);			
		echo interfejs::sortEl($link."&amp;sortuj=",3,4,"nazwa i opis grupy",$sortuj);				
		echo interfejs::sortEl($link."&amp;sortuj=",7,8,"członków",$sortuj,80);
		echo interfejs::sortEl($link."&amp;sortuj=",9,10,"aktywność",$sortuj,100);		
		echo "</tr>";		
		
		if($naw->getWynikow()>0){		
		
			$funkcja="";			
			$i=0;
			
			$zap=konf::get()->_bazasql->zap("SELECT p.*, u.ostatnia_wizyta, u.funkcja ".$query." ORDER BY u.funkcja DESC, ".$tab_sort[$sortuj]." LIMIT ".$naw->getStart().",".$naw->getIle());

			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
			
				if($i==0||$funkcja!=$dane['funkcja']){
				
					$funkcja=$dane['funkcja'];
					
			  	echo "<tr>";
					echo "<td class=\"tlo4 lewa grube\" colspan=\"".$colspan."\">";
					if($funkcja==2){
						echo "Grupy których jesteś właścicielem:";
					} else if($funkcja==1){
						echo "Grupy których jesteś moderatorem:";					
					} else {
						echo "Grupy których jesteś członkiem:";					
					}
					echo "</td></tr>";				

				}
		  	
		  	echo "<tr class=\"srodek\">";
				echo "<td class=\"tlo4\">";
				echo $this->grupyLogo($dane,2,true);
				echo "</td>";

				echo "<td class=\"tlo3 lewa\">";
				echo $this->grupyRekord($dane);
				echo "</td>";

				echo "<td class=\"tlo3 prawa\">";
				echo $dane['osoby'];
				echo "</td>";				
				
				echo "<td class=\"tlo3 srodek\">";	
				
				if($dane['data_aktywnosci']>$dane['ostatnia_wizyta']){
					echo "<div class=\"grube\">";
				}
				echo $this->dataForm($dane['data_aktywnosci']);
				if($dane['data_aktywnosci']>$dane['ostatnia_wizyta']){
					echo "</div>";
				}				
				echo "<div>(".$dane['wypowiedzi'].")</div>";									
				echo "</td>";
				
				echo "</tr>";
				
				$i++;
				
			}	
			konf::get()->_bazasql->freeResult($zap);		
			
			if($naw->getNaw()){
				echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
			}	
			
		} else {
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 srodek grube\" style=\"padding:10px;\">".konf::get()->langTexty("brakdanych")."</td></tr>";
		}
		
		echo tab_stop();	

		
	}

	
  /**
   * show  data
   */
	public function arch(){
	
		$podstrona=konf::get()->getZmienna("podstrona","podstrona");	
		$sortuj=tekstForm::doSql(konf::get()->getZmienna("sortuj","sortuj"));		
		$id_nr=konf::get()->getZmienna("id_nr","id_nr");					
		$typy_tab=konf::get()->getKonfigTab("grupy_konf",'typy_tab');
		$statusy_tab=konf::get()->getKonfigTab("grupy_konf",'statusy_tab');		
		
		$na_str=35;		
		$colspan=7;	
		if(konf::get()->getKonfigTab("grupy_konf",'usuwanie')==1){	
			$colspan++;
		}		
			
		$tab_sort=array(
			1=>"p.id", 2=>"p.id DESC", 
			3=>"p.nazwa", 4=>"p.nazwa DESC", 
			5=>"p.autor_kiedy, p.id", 6=>"p.autor_kiedy DESC, p.id DESC", 
			7=>"p.osoby", 8=>"p.osoby DESC", 					
			9=>"p.do_usuniecia", 10=>"p.do_usuniecia DESC", 					
			11=>"p.data_aktywnosci", 12=>"p.data_aktywnosci DESC", 					
			13=>"p.status", 14=>"p.status DESC", 				
		);	
			
		$link=$this->szukZmienne(1);			
		$link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane"));				
    $link3=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupyadmin_edytuj","sortuj"=>$sortuj,"podstrona"=>$podstrona)).$link;		
    $link4=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupyadmin_usun","sortuj"=>$sortuj,"podstrona"=>$podstrona)).$link;			
	  $link5=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_zobacz"));		
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>konf::get()->getAkcja())).$link;									
														
		if(!empty($this->_szuk['typ'])){
			$tytul="Grupy kategoria";	
			if(!empty($typy_tab[$this->_szuk['typ']])){
				$tytul.=" ".$typy_tab[$this->_szuk['typ']];
			}			
		} else {
			$tytul="Lista grup";
		}		

		if(empty($tab_sort[$sortuj])){ 		
			$sortuj=6; 
		}			
		
		$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'grupy')." p WHERE 1";		
		
		if(!empty($this->_szuk['typ'])){
			$query.=" AND p.typ='".tekstform::doSql($this->_szuk['typ'])."'";
		}
		
		if(!empty($this->_szuk['szuk_nazwa'])){
			$query.=" AND p.nazwa LIKE '%".tekstform::doLike($this->_szuk['szuk_nazwa'])."%'";
		}		

		$naw = new nawig("SELECT COUNT(p.id) AS ilosc ".$query,$podstrona,$na_str);		
		$naw->naw($link);
		$podstrona=$naw->getPodstrona();	
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"arch","arch");
		echo $form->spr(array(1=>"akcja"),"","ok=spr_akcjau(document.arch.akcja,'grupyadmin_usun','".konf::get()->langTexty("czyusun")."');");
		echo $form->getFormp();
		
		$przenies=$this->_szuk;
		$przenies['sortuj']=$sortuj;
		$przenies['podstrona']=$podstrona;				
		echo $form->przenies($przenies);

		echo tab_nagl($tytul." (".$naw->getWynikow()."):",$colspan);	

    echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 lewa\">";
		
    //akcje  
		$akcje_tab['grupyadmin_dodaj']=konf::get()->langTexty("adodaj");	
		
		if($naw->getWynikow()>0){			
			$akcje_tab['grupyadmin_status']="zmień status";			
			if(konf::get()->getKonfigTab("grupy_konf",'usuwanie')==1){	
				$akcje_tab['grupyadmin_dousuniecia']="ustaw do usunięcia";
				$akcje_tab['grupyadmin_dousuniecianie']="odznacz do usunięcia";				
			}					
			$akcje_tab['grupyadmin_usun']=konf::get()->langTexty("ausun");
		}		
	
		echo $form->selectAkcja($akcje_tab,false);
		echo "&nbsp;";
		echo $form->select("status","status",$statusy_tab,"","f_dlugi","--wybierz status--");	
		echo "&nbsp;";			
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
		
		echo "<tr class=\"srodek\">";		
		echo interfejs::sortEl($link."&amp;sortuj=",1,2,"id",$sortuj,60);			
		echo interfejs::sortEl($link."&amp;sortuj=","","","logo",$sortuj,80);			
		echo interfejs::sortEl($link."&amp;sortuj=",3,4,"nazwa i opis grupy",$sortuj);	
		echo interfejs::sortEl($link."&amp;sortuj=",5,6,"utworzono",$sortuj,110);					
		echo interfejs::sortEl($link."&amp;sortuj=",7,8,"członków",$sortuj,80);	
		echo interfejs::sortEl($link."&amp;sortuj=",11,12,"aktywność",$sortuj,100);	
		if(konf::get()->getKonfigTab("grupy_konf",'usuwanie')==1){						
			echo interfejs::sortEl($link."&amp;sortuj=",9,10,"do usnięcia",$sortuj,80);		
		}
		echo interfejs::sortEl($link."&amp;sortuj=",13,14,"status",$sortuj,100);				
		echo "</tr>";		
		
		if($naw->getWynikow()>0){		
			
			$zap=konf::get()->_bazasql->zap("SELECT p.* ".$query." ORDER BY ".$tab_sort[$sortuj]." LIMIT ".$naw->getStart().",".$naw->getIle());

			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
		  	
		  	echo "<tr class=\"srodek\">";
								
				echo "<td class=\"tlo4 srodek\">";
				echo $form->checkbox("id_tab[]","id_".$dane['id'],$dane['id'],"");	
				echo "<div ";
				if($id_nr==$dane['id']){
					echo " class=\"grube\"";
				}
				echo ">".$dane['id']."</div>";
	      echo "</td>";				
				
				echo "<td class=\"tlo3 srodek\">";
				echo $this->grupyLogo($dane,2,true);
				echo "</td>";

				echo "<td class=\"tlo3 lewa\">";
				echo $this->grupyRekord($dane);
				
				echo "<div><table border=\"0\" style=\"margin-top:5px\"><tr>";    					
		    echo interfejs::edytuj($link3."&amp;id_nr=".$dane['id']);					
			  echo interfejs::podglad($link5."&amp;id_grupa=".$dane['id']); 				
				echo interfejs::usun($link4."&amp;id_tab[1]=".$dane['id']); 										
				echo interfejs::infoEl($dane);			
				echo "</tr></table></div>";  				
				
				echo "</td>";
				
				echo "<td class=\"tlo3 srodek\">";	
				echo $this->dataForm($dane['autor_kiedy']);
				echo "<div><a href=\"".$link2."&amp;id_u=".$dane['autor_id']."\">".$dane['autor_name']."</a></div>";				
				echo "</td>";
				
				echo "<td class=\"tlo3 prawa\">";
				echo $dane['osoby'];
				echo "</td>";			
				
				echo "<td class=\"tlo3 srodek\">";
				if(tekstForm::niepuste($dane['data_aktywnosci'])){
					echo $this->dataForm($dane['data_aktywnosci']);
				}
				echo "</td>";								
				
				if(konf::get()->getKonfigTab("grupy_konf",'usuwanie')==1){					
					echo "<td class=\"tlo3 srodek\">";
					if(!empty($dane['do_usuniecia'])){
						echo "TAK";	
					} else {
						echo "NIE";
					}
					echo "</td>";		
				}	
				
				echo "<td class=\"tlo3 srodek\">";
				if(!empty($statusy_tab[$dane['status']])){
					echo $statusy_tab[$dane['status']];
				}
				echo "</td>";											

				echo "</tr>";
				
			}	
			konf::get()->_bazasql->freeResult($zap);		
			
			if($naw->getNaw()){
				echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
			}	
			
		} else {
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 srodek grube\" style=\"padding:10px;\">".konf::get()->langTexty("brakdanych")."</td></tr>";
		}
		
	  echo "<tr class=\"srodek\"><td colspan=\"".$colspan."\" class=\"tlo4 srodek\">".interfejs::linkEl("group",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupyadmin_typy")),"Kategorie grup")."</td></tr>";		
		
		echo tab_stop();
    echo $form->getFormk();		
		
		$this->wyszukiwarka();

	}


  /**
   * new group
   */	
	protected function formularz(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');		
		$sortuj=konf::get()->getZmienna('sortuj','sortuj');			
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));							
		$typy_tab=konf::get()->getKonfigTab("grupy_konf",'typy_tab');			
		$statusy_tab=konf::get()->getKonfigTab("grupy_konf",'statusy_tab');						
		$link=$this->szukZmienne(1)."&amp;podstrona=".$podstrona."&amp;sortuj=".$sortuj;									
		
		//domyślne wartosci
		$dane=array(
			'nazwa'=>"",
			'typ'=>$this->_szuk['typ'],
			'opis_krotki'=>"",			
			'opis'=>"",			
			'status'=>1,
			'zamknieta'=>0,		
			'zatwierdzanie'=>0,
		);		

		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"grupyf","grupyf");	
		$dane=$form->odczyt($dane);	

		if(!empty($id_nr)){
			$dane2=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'grupy')." WHERE id='".$id_nr."'");
			if(empty($dane2)){
				$id_nr="";
			} else {
				$dane=$dane2;
			}
		}

		//jesli wszystko ok to wyswietl formularz
		if(konf::get()->getAkcja()=="grupyadmin_dodaj"||!empty($id_nr)){
			
			echo $form->spr(array(1=>"nazwa",2=>"typ",3=>"opis_krotki"),"","");
			$form->setMultipart(true);
			
			if(!empty($id_nr)){
	  		echo tab_nagl("Edycja grupy",1);					
			} else {
	  		echo tab_nagl("Dodawanie grupy",1);			
			}
	  
	  	echo "<tr><td valign=\"top\" class=\"tlo3\">";
			
			$this->grupaMenu($id_nr,$dane,$link);
						
			echo "<br />";					
			
			echo $form->getFormp();
			echo $form->przenies(array("a"=>"a","akcja"=>konf::get()->getAkcja()."2","id_nr"=>$id_nr));	
			
			echo "<div>";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");						
			echo "</div><br />";					

			echo interfejs::label("typ","typ grupy*","grube");			
			echo "<br />";					
			echo $form->select("typ","typ",$typy_tab,$dane['typ'],"f_bdlugi",konf::get()->langTexty("wybierz"));
			echo "<br /><br />";
			
			echo interfejs::label("nazwa","nazwa*:","grube blok");				
			echo $form->input("text","nazwa","nazwa",$dane['nazwa'],"f_bdlugi",200);
			echo "<br /><br />";

			echo interfejs::label("opis_krotki","opis skrócony*:","grube");		
			echo "<br />";			
			echo $form->input("text","opis_krotki","opis_krotki",$dane['opis_krotki'],"f_bdlugi",250);	
			
			echo "<div class=\"male\">Krótki opis wyświetlany jest na listach grup, zanim użytkownik trafi na stronę główną grupy. ";
			echo "<br />Może składać się maksymalnie z 250 znaków.</div>";	
			echo "<br />";		
			
			echo interfejs::label("opis","opis:","grube");		
			echo "<br />";					
			echo $form->textarea("opis","opis",$dane['opis'],"f_bdlugi",10);					
			echo "<br /><br />";		
			
			if(konf::get()->getKonfigTab("grupy_konf",'img')){							

	  		if(!empty($dane['img'])){
				
					echo interfejs::imgPodglad($dane,"img",konf::get()->getKonfigTab("grupy_konf",'kat'));	
	  			echo "<div>";
					echo $form->checkbox("img_usun","img_usun",1,"");				
					echo interfejs::label("img_usun",konf::get()->langTexty("usung"),"",true);
					echo "</div>"; 
					
	  		}
				
				echo interfejs::label("pic","logo grupy:","grube");																					
				echo "<div>";
				echo $form->input("file","pic","pic","","f_bdlugi");
				echo "</div><br />";		
				
			}
				
			if(konf::get()->getKonfigTab("grupy_konf",'zamkniete')){
				echo interfejs::label("zamknieta","dostęp do grupy mają:","grube");			
				echo "<br class=\"nowa_l\" />";					
				echo $form->select("zamknieta","zamknieta",array(0=>"wszyscy",1=>"tylko członkowie"),$dane['zamknieta'],"f_sredni");		
				echo "<br /><br />";				
			}
			
			if(konf::get()->getKonfigTab("grupy_konf",'zatwierdzanie')){
				echo interfejs::label("zatwierdzanie","członkowstwo w grupie:","grube");			
				echo "<br class=\"nowa_l\" />";					
				echo $form->select("zatwierdzanie","zatwierdzanie",array(0=>"jest otwarte",1=>"potwierdza moderator"),$dane['zatwierdzanie'],"f_sredni");	
				echo "<br /><br />";											
			}			

			echo interfejs::label("status","status:","grube");			
			echo "<br class=\"nowa_l\" />";					
			echo $form->select("status","status",$statusy_tab,$dane['status'],"f_sredni");
			echo "<br /><br />";						

			echo "<div>";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");						
			echo "</div><br />";
			
			echo "<div class=\"male\">".konf::get()->langTexty("musza")."</div>";
			
			echo $form->getFormk();
			
			echo "</td></tr>";
			
			echo "<tr class=\"srodek\"><td class=\"tlo4\">".interfejs::linkEl("group",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_arch","sortuj"=>$sortuj,"podstrona"=>$podstrona)).$link,konf::get()->langTexty("produkty_admin_form_listas")."Powrót na listę grup")."</td></tr>";
		
	  	echo tab_stop();
			
		} else { 
			echo interfejs::nieprawidlowe();	
		}		
		
	
	}

	
	private function grupaMenu($id_nr,$dane,$link=""){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$sortuj=konf::get()->getZmienna('sortuj','sortuj');

		echo "<table border=\"0\"><tr>"; 
				
		if(!empty($id_nr)){
			echo interfejs::edytuj(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupyadmin_edytuj","id_nr"=>$id_nr)).$link); 			
			echo interfejs::podglad(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_zobacz","id_grupa"=>$id_nr))); 			
			echo interfejs::infoEl($dane);		  
			echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupyadmin_usun","id_tab[]"=>$dane['id'])).$link);
		}
		echo interfejs::przyciskEl("arrow_join",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupyadmin_arch")).$link,"powrót do listy");

		echo "</tr></table>"; 	
	
	}	
	
		
  /**
   * if message exists
   * @param string $tytul
   * @param string $tresc
   * @param int $id_u	
	 * @return bool	
   */		
	private function istnieje($nazwa,$typ,$id_grupa=""){
	
		$ok=true;
		
		$sql="nazwa='".$nazwa."' AND typ='".$typ."'";
		if($id_grupa){
			$sql.=" AND id!='".$id_grupa."'";
		}
				
		if(konf::get()->_bazasql->policz('id'," FROM ".konf::get()->getKonfigTab("sql_tab",'grupy')." WHERE ".$sql)>0){
			$ok=false;
		}
		
		return $ok;
		
	}	
	
	
	//data save
	protected function zapisz(){
		
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));									
		$typy_tab=konf::get()->getKonfigTab("grupy_konf",'typy_tab');			
		$statusy_tab=konf::get()->getKonfigTab("grupy_konf",'statusy_tab');							
		
		//domyślne wartosci
		$dane=array(
			'nazwa'=>"",
			'typ'=>$this->_szuk['typ'],
			'opis_krotki'=>"",			
			'opis'=>"",			
			'status'=>1,
			'zamknieta'=>0,		
			'zatwierdzanie'=>0,
		);	
		
		$dane['status']=1;
		
		$testy[]=array("zmienna"=>"status","test"=>"wtablicyi","wymagany"=>true,
			"param"=>array(
				"wartosci"=>$statusy_tab,
				"domyslny"=>""
			)
		);					
			
		$testy[]=array("zmienna"=>"nazwa","test"=>"wartosc","wymagany"=>true,
			"param"=>array(
				"komunikat"=>"Nieprawidłowa nazwa grupy",
				'idtf'=>"nazwa"			
			)	
		);	
		
		$testy[]=array("zmienna"=>"opis_krotki","test"=>"wartosc","wymagany"=>true,
			"param"=>array(
				"komunikat"=>"Nieprawidłowy opis grupy",
				'idtf'=>"opis_krotki"			
			)	
		);	
				
				
		$testy[]=array("zmienna"=>"typ","test"=>"wtablicyi","wymagany"=>true,
			"param"=>array(
				"wartosci"=>$typy_tab,
				"domyslny"=>"",
				"komunikat"=>"Nieprawidłowy typ grupy",
				'idtf'=>"typ"							
			)
		);	
		
		
		if(konf::get()->getKonfigTab("grupy_konf",'zamkniete')){		
			$testy[]=array("zmienna"=>"zamknieta","test"=>"truefalse",
				"param"=>array(
					"wartosc"=>1
				)
			);	
		}	
		
		if(konf::get()->getKonfigTab("grupy_konf",'zatwierdzanie')){		
			$testy[]=array("zmienna"=>"zatwierdzanie","test"=>"truefalse",
				"param"=>array(
					"wartosc"=>1
				)
			);	
		}		
		

		//generator zapytania insert/update
		require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
		$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'grupy'),$dane);
		$sqldane->daneOdczyt();	
		$sqldane->setAutor(true);	
		$sqldane->setTesty($testy);			

		$sqldane->testuj();	
		
		if($sqldane->ok()){
		
			if(!empty($id_nr)){
			
				$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'grupy')." WHERE id='".$id_nr."'");

				if(empty($dane)){
					$id_nr="";
				}	
					
			}	else {
				$id_nr="";				
			}					

			if($this->istnieje($sqldane->getDane("nazwa"),$sqldane->getDane("typ"),$id_nr)){							
				
				//dodawanie
				if(empty($id_nr)){
				
					$sqldane->setDane(array("data_aktywnosci"=>date('Y-m-d H:i:s')));					

					//budowanie zapytania
					$sqldane->dodajDaneD();							
					
					//wykonujemy
					if($sqldane->getSql()){
						konf::get()->_bazasql->zap($sqldane->getSql());					
						$id_nr=konf::get()->_bazasql->insert_id;
					}
					
					//grafika
					if(!empty($id_nr)){
					 
						konf::get()->setZmienna("_post","id_nr",$id_nr);	
						konf::get()->setZmienna("_post","id_grupa",$id_nr);							
						
						require_once(konf::get()->getKonfigTab('mod_kat')."grupy/class.grupy.php");														
						$grupy=new grupy();													
						$grupy->dolacz(true);
					
						if(konf::get()->getKonfigTab("grupy_konf",'img')){						
							$grafika=$this->grafikaZapis($dane,$id_nr);									
							if($grafika->getSql()){
								konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'grupy')." SET ".$grafika->getSql()." WHERE id='".$id_nr."'");				
					 		}
						}
						
					}
					
				//edycja
				} else {
				
					$sqldane->dodajDaneE();								
					
					if(konf::get()->getKonfigTab("grupy_konf",'img')){						
						$grafika=$this->grafikaZapis($dane,$id_nr);										
						if($grafika->getSql()){
							$sqldane->dodaj(", ".$grafika->getSql());				
						}		
					}
									
					$sqldane->dodaj(" WHERE id='".$id_nr."'");
					
					if($sqldane->getSql()){
						konf::get()->_bazasql->zap($sqldane->getSql());	
					}
				
				}

		    //jesli ok
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
		
		if(konf::get()->getAkcja()=="grupyadmin_dodaj2"){
			if(!empty($id_nr)){
				konf::get()->setAkcja("grupyadmin_arch");				
			} else {
				konf::get()->setAkcja("grupyadmin_dodaj");				
			}
		} else if(konf::get()->getAkcja()=="grupyadmin_edytuj2"){	
			konf::get()->setAkcja("grupyadmin_edytuj");					
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
		
		$grafika=new zapiszGrafike($id_nr,konf::get()->getKonfigTab("grupy_konf",'kat'),"pic","img",$dane);
		$grafika->setWszystkie(true);
		$grafika->setImgUsun($img_usun);
		
		$grafika->setDaneImg(1,array(
			"hmax"=>konf::get()->getKonfigTab("grupy_konf",'img1_size'),
			"wmax"=>konf::get()->getKonfigTab("grupy_konf",'img1_size'),
			"hmin"=>konf::get()->getKonfigTab("grupy_konf",'img_min_size'),
			"wmin"=>konf::get()->getKonfigTab("grupy_konf",'img_min_size'),
			"typy"=>array(2=>2),
			"skala"=>konf::get()->getKonfigTab("grupy_konf",'img1_skalatyp')			
		));
		
		$grafika->setDaneImg(2,array(
			"hmax"=>konf::get()->getKonfigTab("grupy_konf",'img2_size'),
			"wmax"=>konf::get()->getKonfigTab("grupy_konf",'img2_size'),
			"hmin"=>konf::get()->getKonfigTab("grupy_konf",'img_min_size'),
			"wmin"=>konf::get()->getKonfigTab("grupy_konf",'img_min_size'),
			"typy"=>array(2=>2),
			"skala"=>konf::get()->getKonfigTab("grupy_konf",'img2_skalatyp')				
		));	
		
		$grafika->setDaneImg(3,array(
			"hmax"=>konf::get()->getKonfigTab("grupy_konf",'img3_size'),
			"wmax"=>konf::get()->getKonfigTab("grupy_konf",'img3_size'),
			"hmin"=>konf::get()->getKonfigTab("grupy_konf",'img_min_size'),
			"wmin"=>konf::get()->getKonfigTab("grupy_konf",'img_min_size'),
			"typy"=>array(2=>2),
			"skala"=>konf::get()->getKonfigTab("grupy_konf",'img3_skalatyp')				
		));		

		$grafika->wykonaj();	
		
		return $grafika;		
	
	}	
	
  /**
   * set status
   */			
	public function status(){
	
		$status=tekstForm::doSql(konf::get()->getZmienna('status','status'));				
		$this->zmienparam("status",$status,konf::get()->getKonfigTab("sql_tab",'grupy'),"grupy - zmiana statusu");
		
	}
	
	
	
  /**
   * set active
   */			
	public function dousuniecia(){
			
		$this->zmienparam("do_usuniecia",1,konf::get()->getKonfigTab("sql_tab",'grupy'),"grupy - do usunięcia");
		
	}
			
		
  /**
   * set active
   */			
	public function dousuniecianie(){
			
		$this->zmienparam("do_usuniecia",0,konf::get()->getKonfigTab("sql_tab",'grupy'),"grupy - do usunięcia");
		
	}		
	
  /**
   * delete
   */
	public function usun(){

		$id_tab=konf::get()->getZmienna('id_tab','id_tab');	
		$id_tab2=array();
		
		if(!empty($id_tab)&&is_array($id_tab)){		
		
		  $query=tekstForm::tabQuery($id_tab);
			
		}		
		
		if(!empty($query)){		
		
		  $query=tekstForm::tabQuery($id_tab);					
		  $zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'grupy')." WHERE id IN (".$query.")");
			
		  while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
			
				$id_tab2[]=$dane['id'];				
				$this->usunImg($dane,konf::get()->getKonfigTab("grupy_konf",'kat'),3,"img");
				
			}	
			
			konf::get()->_bazasql->freeResult($zap);	
				
			$query="";					
			if(!empty($id_tab2)){
			  $query=tekstForm::tabQuery($id_tab2);			
			}
						
			if(!empty($query)){
			
			  if(konf::get()->isMod('grupygal')){	
						
				  $zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_galeria')." WHERE id_matka IN (".$query.")");
				  while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
						$this->usunImg($dane,konf::get()->getKonfigTab("grupy_konf",'galeria_kat'),2,"img");						
					}
					konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_galeria')." WHERE id_matka IN (".$query.")");
					
					if(konf::get()->getKonfigTab("grupy_konf",'galeria_koment')){
						konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_galeria_koment')." WHERE id_matka='".$dane['id']."'");					
					}					
					
				}					
										
				konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'grupy')." WHERE id IN (".$query.")");
				konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." WHERE id_grupa IN (".$query.")");
			}
	
			konf::get()->setKomunikat(konf::get()->langTexty("usuwanie"),""); 
			
		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("usuwaniebrak"),"error"); 		
		}
		
	}	
	

	/**
   * class constructor php5	
   */	
	public function __construct() {	
	
		$this->_admin=konf::get()->getKonfigTab("grupy_konf",'admin');	

  }	

	
}	

?>