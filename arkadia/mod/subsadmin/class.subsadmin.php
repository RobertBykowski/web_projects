<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}


class subsadmin extends moduladmin {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="subsadmin class";

  /**
   * subs categories 			
   */	
	public function typy(){

		$colspan=2;

		echo tab_nagl(konf::get()->langTexty("subs_arch"),$colspan);
		echo "<tr><td class=\"tlo4 lewa grube\">".konf::get()->langTexty("subs_arch_nazwa")."</td>";
		echo "<td class=\"tlo4 prawa grube\" style=\"width:50px\">".konf::get()->langTexty("subs_arch_ilosc")."</td></tr>";

		$typy_tab=konf::get()->getKonfigTab("subs_konf",'typy_tab');	
				
		if(!empty($typy_tab)&&is_array($typy_tab)){
			$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"subsadmin_arch"));
			
			while(list($key,$val)=each($typy_tab)){
				echo "<tr valign=\"top\">";
				echo interfejs::innyEl("email","<a href=\"".$link."&amp;id_subs=".$key."\">".$val."</a>","tlo3");
				echo "<td class=\"tlo3 prawa\">";
				echo konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'subskrypcja')." WHERE idtf='".tekstForm::doSql($key)."'");
				echo "</td></tr>";
			}
			
			echo "<tr class=\"srodek\"><td colspan=\"".$colspan."\" class=\"tlo4 srodek\">".interfejs::linkEl("email",$link,konf::get()->langTexty("subs_arch_wszystkie"))."</td></tr>";

		} else {
	 		echo interfejs::brak($colspan);
		}
		echo tab_stop();
		
	}


  /**
   * subs emails		
   */	
	public function arch(){

		$id_subs=konf::get()->getZmienna('id_subs','id_subs');		
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');		
		$sortuj=konf::get()->getZmienna('sortuj','sortuj');
		$szuk=konf::get()->getZmienna('szuk','szuk');	
		$szuk_status=tekstForm::doSql(konf::get()->getZmienna('szuk_status','szuk_status'));
		
		$typy_tab=konf::get()->getKonfigTab("subs_konf",'typy_tab');	
		if(empty($typy_tab[$id_subs])){
			$id_subs="";
		}
		
		$colspan=6;
		
		$tab_sort=array(
			1=>"id", 2=>"id DESC",
			3=>"email", 4=>"email DESC", 
			5=>"data", 6=>"data DESC", 
			7=>"idtf", 8=>"idtf DESC", 
			9=>"status", 10=>"status DESC",
			11=>"ip", 12=>"ip DESC",			
		);
		
		if(empty($sortuj)||empty($tab_sort[$sortuj])){ 
			$sortuj=1; 
		}

		$link="";

	  $query=" FROM ".konf::get()->getKonfigTab("sql_tab",'subskrypcja')." WHERE 1 ";
	    
	  if(!empty($id_subs)){
	    $link.="&amp;id_subs=".$id_subs;
	    $query.=" AND idtf='".$id_subs."'";
	  }

	  if(!empty($szuk_status)){
			if($szuk_status==2){
		    $query.=" AND status=0 ";
			} else{
		    $query.=" AND status='".$szuk_status."' ";		
			}
	    $link.="&amp;szuk_status=".$szuk_status;
	  }

	  if(!empty($szuk)){
	    $link.="&amp;szuk=".rawurlencode($szuk);
	    $query.=" AND LCASE(email) LIKE '%".tekstForm::male(tekstForm::doLike($szuk))."%'";
	  }
		

		$link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"subsadmin_usun","podstrona"=>$podstrona,"sortuj"=>$sortuj)).$link;		
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"subsadmin_arch")).$link;		
	   
		$naw = new nawig("SELECT COUNT(id) AS ilosc ".$query,$podstrona,konf::get()->getKonfigTab("subs_konf",'subs_na_str'));		
		$naw->naw($link."&amp;sortuj=".$sortuj);
		$podstrona=$naw->getPodstrona();	
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"arch","arch");
		
		echo $form->spr(array(1=>"akcja"),"","ok=spr_akcjau(document.arch.akcja,'subsadmin_usun','".konf::get()->langTexty("czyusun")."');");
		echo $form->getFormp();
		echo $form->przenies(array("id_subs"=>$id_subs,"sortuj"=>$sortuj,"szuk_status"=>$szuk_status,"szuk"=>$szuk,"podstrona"=>$podstrona));	

	  echo tab_nagl(konf::get()->langTexty("subs_list").$naw->getWynikow()."):",$colspan);
		
	  if(!empty($id_subs)){
	    echo "<tr><td colspan=\"".$colspan."\" class=\"tlo4\">".konf::get()->langTexty("subs_list_kat")." <span class=\"grube\">".$typy_tab[$id_subs]."</span></td></tr>";
	  }

		echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 lewa\">";
		
	   //akcje  
		$akcje_tab['subsadmin_przenies']="przenieś do kategorii";		
		if($naw->getWynikow()>0){			
			$akcje_tab['subsadmin_aktyw']=konf::get()->langTexty("aaktyw");
			$akcje_tab['subsadmin_deaktyw']=konf::get()->langTexty("adeaktyw");
			$akcje_tab['subsadmin_usun']=konf::get()->langTexty("ausun");
		}
		$akcje_tab['subsadmin_wiadomosc']=konf::get()->langTexty("subs_list_arozeslij");
		$akcje_tab['subsadmin_archw']=konf::get()->langTexty("subs_list_aarchw");	
		
		echo $form->selectAkcja($akcje_tab,false);	
		echo " ";
	  echo $form_list=$form->select("id_subs","",$typy_tab,$id_subs,"f_dlugi",konf::get()->langTexty("subs_list_katdowolna"));		
		echo " ";
		echo $form->input("submit","","","wykonaj","formularz2 f_sredni");				

	  echo "</td></tr>";		
		
		if($naw->getWynikow()>0){		
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo4 srodek nobr\">";		
			echo $form->zaod("id_tab");		
			echo "</td></tr>";
		}
							  
		if($naw->getNaw()){
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
		}	

		echo "<tr class=\"srodek\">";

		echo interfejs::sortEl($link."&amp;sortuj=",1,2,konf::get()->langTexty("subs_list_id"),$sortuj,50);
		echo interfejs::sortEl($link."&amp;sortuj=",3,4,konf::get()->langTexty("subs_list_email"),$sortuj);
		echo interfejs::sortEl($link."&amp;sortuj=",11,12,"ip",$sortuj,150);		
		echo interfejs::sortEl($link."&amp;sortuj=",5,6,konf::get()->langTexty("subs_list_data"),$sortuj,100);
		echo interfejs::sortEl($link."&amp;sortuj=",9,10,konf::get()->langTexty("subs_list_status"),$sortuj,80);
		echo interfejs::sortEl("","","","","",33);
		
		echo "</tr>";

		if($naw->getWynikow()>0){

			$zap=konf::get()->_bazasql->zap("SELECT * ".$query." ORDER BY ".$tab_sort[$sortuj].",id LIMIT ".$naw->getStart().",".$naw->getIle());

			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
	    
				echo "<tr class=\"srodek\"><td class=\"tlo4\">";
				echo $form->checkbox("id_tab[]","id_".$dane['id'],$dane['id'],"");				
				echo "<div>".$dane['id']."</div>";
				echo "</td><td class=\"tlo3 lewa\">";
				echo "<a href=\"mailto:".$dane['email']."\">".$dane['email']."</a>";				
				echo "</td>";
				
				echo "<td class=\"tlo3 srodek male\">".$dane['ip']."</td>";				
				echo "<td class=\"tlo3 srodek male\">".$dane['data']."</td>";
				
				echo "<td class=\"tlo3\">";
				if($dane['status']==1){ 
					echo konf::get()->langTexty("aktywne"); 
				} else { 
					echo konf::get()->langTexty("snieaktywne"); 
				}
				echo "</td>";			

				echo "<td class=\"srodek tlo3\">";
				echo "<table class=\"srodek\" border=\"0\"><tr>"; 			
				echo interfejs::usun($link2."&amp;id_tab[1]=".$dane['id']); 
				echo "</tr></table>";			
				echo "</td>";
				
				echo "</tr>";
				
			}
			
			konf::get()->_bazasql->freeResult($zap);		

		} else { 
	 		echo interfejs::brak($colspan);
		}

		if($naw->getNaw()){
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
		}	
		
		echo "<tr class=\"srodek\"><td colspan=\"".$colspan."\" class=\"tlo4\">";
		echo interfejs::linkEl("email",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"subsadmin_typy")),konf::get()->langTexty("subs_list_listkat"));
		echo "</td></tr>";

	  echo tab_stop();
		echo $form->getFormk();
	  
	  echo tab_nagl(konf::get()->langTexty("wyszukiwarka"),1);
		echo "<tr><td class=\"tlo3\">";
		
		$form2=new formularz("post",konf::get()->getKonfigTab("plik"),"arch2","arch2");
		echo $form2->getFormp();
		echo $form2->przenies(array("sortuj"=>$sortuj,"akcja"=>"subsadmin_arch"));
			
		echo $form2->select("szuk_status","szuk_status",array(
			1=>konf::get()->langTexty("subs_list_tylkoaktyw"),
			2=>konf::get()->langTexty("subs_list_tylkodeaktyw")
		),$szuk_status,"f_dlugi",konf::get()->langTexty("subs_list_dowolne"));	
		echo " ";
	  echo $form_list;
		echo " ";
		echo $form2->input("text","szuk","szuk",$szuk,"f_dlugi",50);					
	  echo " ";
		echo $form2->input("submit","","",konf::get()->langTexty("szukaj"),"formularz2 f_sredni");			
		
		echo $form2->getFormk();
		
		echo "</td></tr>";
		echo tab_stop();
	  
	  echo tab_nagl(konf::get()->langTexty("subs_list_dodawanie"),1);
		echo "<tr><td class=\"tlo3\">";
		
		$form3=new formularz("post",konf::get()->getKonfigTab("plik"),"subs_dodaj","subs_dodaj");
		
		echo $form3->spr(array(1=>"subs_email",2=>"id_subs"));
		echo $form3->getFormp();
		echo $form3->przenies(array("akcja"=>"subsadmin_zapisz","sortuj"=>$sortuj));
		
		echo $form3->input("text","subs_email","subs_email","","f_dlugi",150);				
	  echo " ";  
	  echo $form_list; 	
	  echo " ";
		echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_sredni");					
		echo $form3->getFormk();
		
		echo "</td></tr>";
		echo tab_stop();
		
	}
	
	
  /**
   * add email		
   */		
	public function zapisz(){

		$subs_email=tekstForm::doSql(konf::get()->getZmienna('subs_email'));	
		$id_subs=tekstForm::doSql(konf::get()->getZmienna('id_subs'));			
		$typy_tab=konf::get()->getKonfigTab("subs_konf",'typy_tab');	
	  $subs_email=tekstForm::male($subs_email);
					
	  if(!empty($subs_email)&&!empty($id_subs)&&!empty($typy_tab[$id_subs])){
		
	    if(preg_match("/".tekstForm::getEmailForma()."/",$subs_email)){
	    
	      if(konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'subskrypcja')." WHERE email='".$subs_email."' AND idtf='".$id_subs."'")==0){

					$status=1;

	        konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'subskrypcja')." (idtf,email,data,status) VALUES('".$id_subs."','".$subs_email."',NOW(),'".$status."')");
	        $id_nr=konf::get()->_bazasql->insert_id;
					
	        if(!empty($id_nr)){     
					
						konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");
										   		      
					} else {
					
						konf::get()->setKomunikat(konf::get()->langTexty("niezapisane"),"error");	
										
					}
					
				}
				
			}
			
		}
		
	}	



  /**
   * delete emails	
   */		
	public function przenies(){

		$id_tab=konf::get()->getZmienna('id_tab','id_tab');	
		$id_subs=tekstForm::doSql(konf::get()->getZmienna('id_subs'));	
				
		if(!empty($id_tab)&&is_array($id_tab)&&!empty($id_subs)){	
			
			$query=tekstForm::tabQuery($id_tab);
			
			if(!empty($query)){
				konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'subskrypcja')." SET idtf='".tekstForm::doSql($id_subs)."' WHERE id IN (".$query.")");
				konf::get()->setKomunikat(konf::get()->langTexty("awykonana"),"");
			} else {
				konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),"error");			
			}
			
		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),"error");			
		}
	
	}
		
	
  /**
   * delete emails	
   */		
	public function usun(){
	
		$this->usunRekordy(konf::get()->getKonfigTab("sql_tab",'subskrypcja'),"","","",konf::get()->langTexty("subs_usun_log"));
	
	}	

  /**
   * active	
   */			
	public function aktyw(){
		
		$this->zmienparam("status",1,konf::get()->getKonfigTab("sql_tab",'subskrypcja'),konf::get()->langTexty("subs_zmien_log"));	
		
	}
	
	
  /**
   * deactive
   */			
	public function deaktyw(){
	
		$this->zmienparam("status",0,konf::get()->getKonfigTab("sql_tab",'subskrypcja'),konf::get()->langTexty("subs_zmien_log"));	
		
	}	

	
  /**
   * message form
   */		
	public function wiadomosc(){

		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));
		$typy_tab=konf::get()->getKonfigTab("subs_konf",'typy_tab');	

	  $dane['tytul']=konf::get()->getKonfigTab("subs_konf",'temat');
	  $dane['tresc']=konf::get()->getKonfigTab("subs_konf",'tekst');
	  
	  if(!empty($id_nr)){
	    $zap=konf::get()->_bazasql->zap("SELECT tytul, tresc FROM ".konf::get()->getKonfigTab("sql_tab",'subskrypcja_w')." WHERE id='".$id_nr."'");
	    if(konf::get()->_bazasql->numRows($zap)>0){
	      $dane=konf::get()->_bazasql->fetchAssoc($zap);
	    }
	    konf::get()->_bazasql->freeResult($zap);
	  }
	 
	  echo tab_nagl(konf::get()->langTexty("subs_form_tworzenie"),1);

	  echo "<tr><td valign=\"top\" class=\"tlo3\">";
		
		echo "<table border=\"0\"><tr>";  
		echo interfejs::przyciskEl("arrow_join",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"subsadmin_archw")),"");				
		echo "</tr></table>";   		
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"subs_wiadomosc","subs_wiadomosc");
		$form->setMultipart(true);	
		$form->setTarget("_blank");		
		
		?><script type="text/javascript">
	
			function spr_czyw(){
			
				ok=true;
			
				if(!confirm('<?php echo konf::get()->langTexty("subs_form_czy"); ?>')){
					ok=false;
				}
				
				return ok;
				
			}
			
		</script><?php		
		
		echo $form->spr(array(1=>"tytul"),""," ok=spr_czyw(); ");
		echo $form->getFormp();	
		echo $form->przenies(array("a"=>"a","akcja"=>"subsadmin_wiadomosc2"));	
		
	  echo "<div>";
		echo $form->input("submit","","",konf::get()->langTexty("subs_form_rozeslij"),"formularz2 f_krotki");		
		echo "</div><br />";		
		
		echo interfejs::label("tytul",konf::get()->langTexty("subs_form_tytul"),"grube blok");					
		echo $form->input("text","tytul","tytul",$dane['tytul'],"f_bdlugi",200);		
		echo "<br /><br />";
		
		echo interfejs::label("tresc",konf::get()->langTexty("subs_form_tresc"),"grube blok");					
	  echo "<br />";

	  if(konf::get()->getKonfigTab("subs_konf",'edytor')){
			$form->fck("tresc",$dane['tresc']);		
			
	  } else {
			echo $form->textarea("tresc","tresc",$dane['tresc'],"f_bdlugi",20);		
	  }
	  echo "<br />";
		 
	  if(konf::get()->getKonfigTab("subs_konf",'zalacznik')){
	  	for($i=1;$i<=konf::get()->getKonfigTab("subs_konf",'zalacznik');$i++){
			  echo "<div>";
				echo interfejs::label("zalacznik_".$i,konf::get()->langTexty("subs_form_plik").$i."):","grube blok");
				echo "</div>";
				echo $form->input("file","zalacznik_".$i,"zalacznik_".$i,"","f_bdlugi");					
				echo "<br /><br />";
			}
	  }

		echo interfejs::label("idtf_tab",konf::get()->langTexty("subs_form_grupa"),"grube blok");	
		echo "<select id=\"idtf_tab\" name=\"idtf_tab[]\" style=\"width: 350pt; height:70pt;\" size=".count($typy_tab)." multiple=\"multiple\">";
		while(list($key,$val)=each($typy_tab)){
		  echo "<option value=\"".$key."\"";
	    if(konf::get()->getKonfigTab("subs_konf",'kat_zaznaczone')){ 
				echo " selected=\"selected\""; 
			}
	    echo ">".$val."</option>";
	  }
	  
	  echo "</select>";
		echo "<div class=\"male\">".konf::get()->langTexty("subs_form_przytrzymaj")."</div>";
		
	  echo "<br /><div>";
		echo $form->input("submit","","",konf::get()->langTexty("subs_form_rozeslij"),"formularz2 f_krotki");		
		echo "</div><br />";
		
	  echo "<div class=\"male\">".konf::get()->langTexty("musza")."</div>";
		
		echo $form->getFormk();
		
		echo "</td></tr>";

		echo "<tr class=\"srodek\"><td class=\"tlo4\">";
		echo interfejs::linkEl("email",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"subsadmin_arch")),konf::get()->langTexty("subs_form_listaemaili"));
		echo "</td></tr>";
		
	  echo tab_stop();
		
	}



  /**
   * message form
   * @param string $tresc
   * @return string						
   */		
	public function wiadomoscTresc($tresc){

	  $tresc=trim($tresc);
	  
	  if(konf::get()->getKonfigTab("subs_konf",'fraza_old')){
	    $tresc=str_replace(konf::get()->getKonfigTab("subs_konf",'fraza_old'),konf::get()->getKonfigTab("subs_konf",'fraza_new'),$tresc);
	  }
	  
	  if(!konf::get()->getKonfigTab("subs_konf",'edytor')){
	    $tresc=nl2br($tresc);
	  }

	  return $tresc;
	}


  /**
   * message send			
   */	
	public function wiadomosc2(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');		
		$tylko_test=konf::get()->getZmienna('tylko_test','tylko_test');		
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));		
		$idtf_tab=tekstForm::doSql(konf::get()->getZmienna("idtf_tab","idtf_tab"));	
		$typy_tab=konf::get()->getKonfigTab("subs_konf",'typy_tab');	
		
		set_time_limit(0); 	
		
		if(konf::get()->getKonfigTab('windows')){
			$tylko_test=1;
		}

		//nr paczki
		if(empty($podstrona)){
			$podstrona=1;
		}		
		
		//gdy pierwsza paczka to zapis
		if($podstrona==1){
		
			$dane3['licznik']=0;
		
			$tresc=konf::get()->getZmienna("tresc");
			$tresc=str_replace("\r","",$tresc);  
		  $tresc=$this->wiadomoscTresc($tresc);
			  
			$tytul=konf::get()->getZmienna("tytul");		
		  $tytul=strip_tags(trim(tekstForm::usunPl($tytul)));	
			
			//zapisujemy dane
		  konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'subskrypcja_w')." (data,tytul,tresc,autor_id,autor_name,autor_kiedy) VALUES(NOW(),'".tekstForm::doSql($tytul)."','".tekstForm::doSql($tresc,false)."','".user::get()->id()."','".user::get()->nazwa()."',NOW())");
			$id_nr=konf::get()->_bazasql->insert_id;
			
			//zalaczniki
		 	if(konf::get()->getKonfigTab("subs_konf",'zalacznik')&&!empty($id_nr)){
			
				require_once(konf::get()->getKonfigTab('klasy')."class.plikzapisz.php");		
				
		 		for($i=1;$i<=konf::get()->getKonfigTab("subs_konf",'zalacznik');$i++){
		 		
	        if (!empty($_FILES['zalacznik_'.$i])&&!empty($_FILES['zalacznik_'.$i]['tmp_name'])) {

	    			$nazwa_pliku=konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("subs_konf",'kat').$id_nr."_".md5($_FILES['zalacznik_'.$i]['tmp_name']).".dat";

		  			$pliczek=new plikZapisz($nazwa_pliku);
						$pliczek->zmiennaFiles("zalacznik_".$i);	
						$zapisany=$pliczek->zapisz();	
						if($zapisany['ok']){						
							konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'subskrypcja_pliki')." VALUES(NULL,'".$id_nr."','".$zapisany['nazwa_pliku']."','".$zapisany['name']."')");
						}
					} 								      
				}
			}
							
			
		//odczytanie zapisanych danych
		} else if (!empty($id_nr)){
		
			$dane3=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'subskrypcja_w')." WHERE id='".$id_nr."'");
			$tresc=$dane3['tresc'];
			$tytul=$dane3['tytul'];
			
		}	
		
		$przenies=array();
		
	  //sprawdzamy dane
	  if(!empty($tytul)&&!empty($tresc)&&isset($idtf_tab)&&is_array($idtf_tab)&&!empty($id_nr)){
			
			$przenies['akcja']=konf::get()->getAkcja();		
			$przenies['id_nr']=$id_nr;
			$przenies['tylko_test']=$tylko_test;		
	    $query="0";
	    
			//pobieramy grupy 
	    reset($idtf_tab);
	    while(list($key,$val)=each($idtf_tab)){
	      if(!empty($val)&&!empty($typy_tab[$val])){
					$przenies["idtf_tab[".$key."]"]=$val;
	        $query.=",'".$val."'";
	      }
	    }
	    
	    if(!empty($query)){
			
				$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'subskrypcja')." WHERE idtf IN(".$query.") AND status=1 ";
			
				//paczkowanie - wysylanie paczek emaili co xx sekund
				
				$na_str=konf::get()->getKonfigTab("subs_konf",'paczki')*konf::get()->getKonfigTab("subs_konf",'paczki_ile');					
				$naw = new nawig("SELECT COUNT(id) AS ilosc ".$query,$podstrona,$na_str);							
						
				//pobieramy paczke emaili
				if(konf::get()->getKonfigTab("subs_konf",'paczki')){	
					$query.=" ORDER BY id LIMIT ".$naw->getStart().",".$naw->getIle();					
				} else {		
					$naw->setStron(1);
					$naw->setWynikow(konf::get()->_bazasql->policz("id"," ".$query));
				}
			
	      $zap=konf::get()->_bazasql->zap("SELECT email ".$query);
	      $ile=konf::get()->_bazasql->numRows($zap);
	      
				//czy emaile
	      if($ile>0){

	        require_once(konf::get()->getKonfigTab("serwer")."klasy/phpmailer/class.phpmailer.php");
	        				 
	    		$i=0;
		      
					//dane emaila
	        $mail =new PHPMailer();        
	      	$mail->CharSet=konf::get()->getKonfigTab("charset");  		  
	        $mail->IsHTML(konf::get()->getKonfigTab("subs_konf",'html'));
	        $mail->From=konf::get()->getKonfigTab("subs_konf",'nadawca_email');
	        $mail->FromName=konf::get()->getKonfigTab("subs_konf",'nadawca');
	        $mail->AddAddress(konf::get()->getKonfigTab("subs_konf",'odbiorca'),konf::get()->getKonfigTab("subs_konf",'odbiorca_email')); 
	        //$mail->Subject=tekstForm::usunPl($tytul);
	        $mail->Subject=$tytul;					
	        $mail->AltBody=strip_tags($tresc); 
					
					//szablon 
			    if(konf::get()->getKonfigTab("subs_konf",'szablon')){
				  	$tresc=str_replace("<TRESC>", $tresc, konf::get()->getKonfigTab("subs_konf",'szablon'));
					} 
					$mail->Body=$tresc; 
					
					$grafiki_tab=konf::get()->getKonfigTab("subs_konf",'grafiki');
										
					//grafiki w szablonie
					if(konf::get()->getKonfigTab("subs_konf",'html')&&!empty($grafiki_tab)&&is_array($grafiki_tab)){

						while(list($key,$val)=each($grafiki_tab)){
							$mail->AddEmbeddedImage(konf::get()->getKonfigTab("serwer")."grafika/email/".$val['plik'],$val['cid'],$val['plik'],"base64",$val['typ']);
						}
						
					}
					
					//zalaczniki
				 	if(konf::get()->getKonfigTab("subs_konf",'zalacznik')){
						$zap2=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'subskrypcja_pliki')." WHERE id_matka='".$id_nr."'");
						$ile_z=0;
						while($dane2=konf::get()->_bazasql->fetchAssoc($zap2)){
		    			$nazwa_pliku=konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("subs_konf",'kat').$dane2['nazwa'];
							if(is_file($nazwa_pliku)){	
								$ile_z++;
				        $mail->AddAttachment($nazwa_pliku,$dane2["nazwa_oryginal"],"base64","application/octet-stream");
							}				
						}
						konf::get()->_bazasql->freeResult($zap2);
					}
					
					
					//smtp
					if(konf::get()->getKonfigTab('kontakt_smtp_host')&&konf::get()->getKonfigTab('kontakt_smtp_user')&&konf::get()->getKonfigTab('kontakt_smtp_haslo')){
						$mail->Mailer="smtp";
			   		$mail->Host=konf::get()->getKonfigTab('kontakt_smtp_host');
			   		$mail->Username=konf::get()->getKonfigTab('kontakt_smtp_user');
			   		$mail->Password=konf::get()->getKonfigTab('kontakt_smtp_haslo');
						$mail->IsSMTP();						
						$mail->SMTPAuth=true;					
				  }	else {
						$mail->IsMail();	
					}				

					//rozsylanie emaili  
					if(!$tylko_test){
					
				    while($dane=konf::get()->_bazasql->fetchAssoc($zap)){   
		          $mail->AddBCC($dane['email'],"");
		          $i++;
		          
		          if($i==konf::get()->getKonfigTab("subs_konf",'paczki_ile')){
		    		  	$mail->Send();
		    		  	$mail->ClearBCCs();
		    		  	$i=0;
		    		  }
						}
						
						if($i>0){
		    		  $mail->Send();
		    		  $mail->ClearBCCs();
		    		  $i=0;
		    		}
						
					}
					
					if($podstrona==$naw->getStron()){
		        user::get()->zapiszLog(konf::get()->langTexty("subs_mail_rozeslanie"),user::get()->login());
					} else if($podstrona<$naw->getStron()){
						$przenies["podstrona"]=$podstrona+1;	
					}						

					//koniec rozsylanie
					
					//raport
					if($tylko_test){
						echo tab_nagl(konf::get()->langTexty("subs_mail_rapottest"),2);				
					} else {
						echo tab_nagl(konf::get()->langTexty("subs_mail_raport"),2);
					}
					
					echo "<tr class=\"prawa\">";
					echo "<td class=\"tlo3\">".konf::get()->langTexty("subs_mail_paczka")."</td>";
					echo "<td class=\"tlo4 grube\" style=\"width:70px\">".$podstrona."/".$naw->getStron()."</td>";		
					echo "</tr>";
					
					echo "<tr class=\"prawa\">";
					echo "<td class=\"tlo3\">".konf::get()->langTexty("subs_mail_emailip")."</td>";
					echo "<td class=\"tlo4 grube\">".$ile."</td>";		
					echo "</tr>";			
					
					echo "<tr class=\"prawa\">";
					echo "<td class=\"tlo3\">".konf::get()->langTexty("subs_mail_emaili")."</td>";
					echo "<td class=\"tlo4 grube\">".$naw->getWynikow()."</td>";		
					echo "</tr>";							
					
					echo "<tr class=\"prawa\">";
					echo "<td class=\"tlo3\">".konf::get()->langTexty("subs_mail_razemwys")."</td>";
					echo "<td class=\"tlo4 grube\">".($dane3['licznik']+$ile)."</td>";		
					echo "</tr>";			
					
					echo "<tr class=\"prawa\">";
					echo "<td class=\"tlo3\">".konf::get()->langTexty("subs_mail_pozostalo")."</td>";
					echo "<td class=\"tlo4 grube\">".($naw->getWynikow()-($dane3['licznik']+$ile))."</td>";		
					echo "</tr>";					
					
					echo "<tr class=\"prawa\">";
					echo "<td class=\"tlo3\">".konf::get()->langTexty("subs_mail_typ")."</td>";
					echo "<td class=\"tlo4 grube\">";
					if(konf::get()->getKonfigTab("subs_konf",'html')){
						echo konf::get()->langTexty("subs_mail_html");
					} else {
						echo konf::get()->langTexty("subs_mail_txt");
					}
					echo "</td>";		
					echo "</tr>";		
					
					echo "<tr class=\"prawa\">";
					echo "<td class=\"tlo3\">".konf::get()->langTexty("subs_mail_zalacznikow")."</td>";
					echo "<td class=\"tlo4 grube\">".$ile_z."</td>";		
					echo "</tr>";														
					
					if(konf::get()->getKonfigTab("subs_konf",'paczki_czas')){
						echo "<tr class=\"prawa\">";
						echo "<td class=\"tlo3\">".konf::get()->langTexty("subs_mail_limitczasu")."</td>";
						echo "<td class=\"tlo4\">".konf::get()->getKonfigTab("subs_konf",'paczki_czas')."s</td>";
						echo "</tr>";
					}
					
					echo "<tr><td class=\"tlo4 srodek\" colspan=\"2\">";
					echo "<script type=\"text/javascript\">\n"; 
					echo "czas=".konf::get()->getKonfigTab("subs_konf",'paczki_czas').";\n";
					
					if($podstrona<$naw->getStron()){				
					
						echo "function subs_odswiez(){\n";				
						echo "  document.forms.wys_form.submit();\n";
						echo "}\n\n";
						
						echo "function subs_zmien_czas(){\n";				
						echo "  if(czas>0){\n";
						echo "    czas=czas-1;\n";
						echo "  }\n";
						echo "  document.getElementById('czas_aktual').innerHTML=czas+'s';\n";
						echo "}\n\n";					
						
					}
					
					echo "function subs_nastepna(){\n";
					if($podstrona<$naw->getStron()){
						echo "setTimeout('subs_odswiez()',(1000*".konf::get()->getKonfigTab("subs_konf",'paczki_czas')."));\n";
						echo "setInterval('subs_zmien_czas()',1000);\n";
					}			
					echo "}\n";				
					echo "</script>\n";
					
					$form=new formularz("post",konf::get()->getKonfigTab("plik"),"wys_form","wys_form");

					echo $form->getFormp();

					if($podstrona<$naw->getStron()){
						echo $form->przenies($przenies);
						echo "<div id=\"czas_aktual\" class=\"srodek\" style=\"padding:5px\">".konf::get()->getKonfigTab("subs_konf",'paczki_czas')."s</div>";
					} else {
						echo "<input type=\"button\" class=\"formularz2 f_sredni\" value=\"".konf::get()->langTexty("subs_mail_zamknij")."\" onclick=\"window.close()\" />";
					}
					echo $form->getFormk();
					echo "</td></tr>";
					
					echo tab_stop();	
										         					
	        konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'subskrypcja_w')." SET licznik=licznik+".$ile." WHERE id='".$id_nr."'");
					//k raport

	      } else { 
					konf::get()->setKomunikat(konf::get()->langTexty("subs_mail_brake"),"error"); 
				}
				//k czy emaile
	      konf::get()->_bazasql->freeResult($zap);
				
	    } else { 
				konf::get()->setKomunikat(konf::get()->langTexty("subs_mail_brakg"),"error"); 
			}
	  } else { 
			konf::get()->setKomunikat(konf::get()->langTexty("subs_mail_brakt"),"error");
		}
		
	}



  /**
   * messages list	
   */	
	public function archw(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');	
		$szuk_w=konf::get()->getZmienna('szuk_w','szuk_w');
		$sortuj_w=konf::get()->getZmienna('sortuj_w','sortuj_w');	

		$colspan=5;
		
		$tab_sort=array(
			1=>"id", 2=>"id DESC",
			3=>"tytul", 4=>"tytul DESC", 
			5=>"data", 6=>"data DESC", 
			7=>"licznik", 8=>"licznik DESC"
		);
		
		if(empty($sortuj_w)||empty($tab_sort[$sortuj_w])){ 
			$sortuj_w=6; 
		}

		$link="";
		$link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"subsadmin_zobacz"));
		
	  $query=" FROM ".konf::get()->getKonfigTab("sql_tab",'subskrypcja_w')." WHERE 1 ";

	  if(!empty($szuk_w)){
	    $link.="&amp;szuk_w=".rawurlencode($szuk_w);
	    $query.=" AND LCASE(tytul) LIKE '%".tekstForm::male(tekstForm::doLike($szuk_w))."%'";
	  }
			

		$naw = new nawig("SELECT COUNT(id) AS ilosc FROM ".konf::get()->getKonfigTab("sql_tab",'subskrypcja_w'),$podstrona,konf::get()->getKonfigTab("subs_konf",'w_na_str'));
		$naw->naw($link."&amp;sortuj_w=".$sortuj_w);
		$podstrona=$naw->getPodstrona();		
		
		$link3=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"subsadmin_usunw","podstrona"=>$podstrona,"sortuj_w"=>$sortuj_w)).$link;			
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"subsadmin_archw"));		
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"arch_w","arch_w");
		
		echo $form->spr(array(1=>"akcja"),"","ok=spr_akcjau(document.arch_w.akcja,'subsadmin_usunw','".konf::get()->langTexty("czyusun")."');");
		echo $form->getFormp();
		echo $form->przenies(array("sortuj_w"=>$sortuj_w,"szuk_w"=>$szuk_w,"podstrona"=>$podstrona));
			
	  echo tab_nagl(konf::get()->langTexty("subs_mail_archw").$naw->getWynikow()."):",$colspan);
		
		echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 lewa\">";
		
	   //akcje  
		if($naw->getWynikow()>0){			
			$akcje_tab['subsadmin_usunw']=konf::get()->langTexty("ausun");
		}
		$akcje_tab['subsadmin_wiadomosc']=konf::get()->langTexty("adodaj");
		echo $form->selectAkcja($akcje_tab);	

		echo "</td></tr>";		
		
		if($naw->getWynikow()>0){							
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo4 srodek nobr\">";		
			echo $form->zaod("id_tab");		
			echo "</td></tr>";			
	 	}
		
		if($naw->getNaw()){
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
		}	
		
		echo "<tr class=\"srodek\">";
		
		echo interfejs::sortEl($link."&amp;sortuj_w=",1,2,konf::get()->langTexty("subs_mail_archw_id"),$sortuj_w,50);
		echo interfejs::sortEl($link."&amp;sortuj_w=",3,4,konf::get()->langTexty("subs_mail_archw_tytul"),$sortuj_w);
		echo interfejs::sortEl($link."&amp;sortuj_w=",5,6,konf::get()->langTexty("subs_mail_archw_data"),$sortuj_w,90);
		echo interfejs::sortEl($link."&amp;sortuj_w=",7,8,konf::get()->langTexty("subs_mail_archw_rozeslano"),$sortuj_w,90);
		echo interfejs::sortEl("","","","",66);
		
		echo "</tr>";

		if($naw->getWynikow()>0){
		
			$zap=konf::get()->_bazasql->zap("SELECT * ".$query." ORDER BY ".$tab_sort[$sortuj_w].",id LIMIT ".$naw->getStart().",".$naw->getIle());

			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
			
				echo "<tr class=\"srodek\">";			
				echo "<td class=\"tlo4\">";
				echo $form->checkbox("id_tab[]","id_".$dane['id'],$dane['id'],"");				
				echo "<div>".$dane['id']."</div>";
				echo "</td>";
				echo "<td class=\"tlo3 lewa seta\">";
				echo "<a href=\"".$link2."&amp;id_nr=".$dane['id']."\">".$dane['tytul']."</a></td>";      
				echo "<td class=\"tlo3 srodek male\">";
				echo str_replace(" ","<br />",$dane['data']);
				echo "</td>";
				echo "<td class=\"tlo3 srodek male\">";
				echo $dane['licznik'];
				echo "</td>";
				
				echo "<td class=\"srodek tlo3\">";
				echo "<table class=\"srodek\" border=\"0\"><tr>"; 			
				echo interfejs::podglad($link2."&amp;id_nr=".$dane['id']); 			
				echo interfejs::usun($link3."&amp;id_tab[1]=".$dane['id']); 
				echo "</tr></table>";			
				echo "</td>";			
				
				echo "</tr>";
			}
			konf::get()->_bazasql->freeResult($zap);

		} else { 
			echo interjefs::brak($colspan);
		}

		if($naw->getNaw()){
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
		}	
		
		
		echo "<tr class=\"srodek\"><td colspan=\"".$colspan."\" class=\"tlo4\">";
		echo interfejs::linkEl("email",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"subsadmin_arch")),konf::get()->langTexty("subs_mail_archw_listae"));
		echo "</td></tr>";

	  echo tab_stop();
		echo $form->getFormk();
	  
	  echo tab_nagl(konf::get()->langTexty("wyszukiwarka"),1);
		echo "<tr><td class=\"tlo3\">";
		$form2=new formularz("post",konf::get()->getKonfigTab("plik"),"form_subs2","form_subs2");
		echo $form2->getFormp();
		echo $form2->przenies(array("sortuj_w"=>$sortuj_w,"akcja"=>"subsadmin_archw"));		

		echo $form->input("text","szuk_w","szuk_w",$szuk_w,"f_dlugi",50);	
	  echo " ";
		echo $form->input("submit","","",konf::get()->langTexty("subs_mail_archw_szukaj"),"formularz2 f_sredni");		
	  echo "<br />";	
		echo $form2->getFormk();
		
		echo "</td></tr>";
		echo tab_stop();
		
	}


  /**
   * delete message		
   */	
	public function usunw(){	

		$id_tab=konf::get()->getZmienna('id_tab','id_tab');	
		
		if(!empty($id_tab)&&is_array($id_tab)){	
			
			$query=tekstForm::tabQuery($id_tab);
			
			if(!empty($query)){
				konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'subskrypcja_w')." WHERE id IN (".$query.")");
				
				$zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'subskrypcja_pliki')." WHERE id_matka IN(".$query.")");
				while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
					if(!empty($dane['nazwa'])){
			    	$nazwa_pliku=konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("subs_konf",'kat').$dane['nazwa'];
						if(is_file($nazwa_pliku)){				
							unlink($nazwa_pliku);
						}
					}
				}
				konf::get()->_bazasql->freeResult($zap);
				
				$zap=konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'subskrypcja_pliki')." WHERE id_matka IN(".$query.")");		
				user::get()->zapiszLog(konf::get()->langTexty("subs_w_usun_log"),user::get()->login());
				konf::get()->setKomunikat(konf::get()->langTexty("usuwanie"),"");				
			} else {
				konf::get()->setKomunikat(konf::get()->langTexty("usuwaniebrak"),"error");					
			}
			
		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("usuwaniebrak"),"error");					
		}
		
		
	}

	
  /**
   * view message		
   */	
	public function zobacz(){

		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));	
		
		if(!empty($id_nr)){

		  $dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'subskrypcja_w')." WHERE id='".$id_nr."'");
		 
		}
		
		if(!empty($dane)){	
				
		  echo tab_nagl(konf::get()->langTexty("subs_w"),1);
			
			echo "<tr><td class=\"tlo4 lewa grube\">";
			echo $dane['tytul'];
			echo "</td></tr>";
			
		  echo "<tr><td class=\"tlo3\">";
			
			echo "<table border=\"0\"><tr>";  
			echo interfejs::przyciskEl("arrow_join",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"subsadmin_archw")),"");				
			echo "</tr></table>";   	
				
			echo "<div>";
	    echo $dane['tresc'];
			echo "</div>";

	    echo "<div class=\"srodek\">";
			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"subsw","subsw");
			echo $form->getFormp();
			echo $form->przenies(array("id_nr"=>$id_nr,"akcja"=>"subsadmin_wiadomosc"));
			echo $form->input("submit","","",konf::get()->langTexty("subs_w_wyslij"),"formularz2 f_dlugi");
			echo $form->getFormk();
			echo "</div>";
			
		  echo "</td></tr>";
			echo "<tr class=\"srodek\"><td class=\"tlo4\">";
			echo interfejs::linkEl("email",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"subsadmin_arch")),konf::get()->langTexty("subs_w_listae"));
			echo "</td></tr>";
			
		  echo tab_stop();			
			
	  } else {
			echo interfejs::nieprawidlowe();
	  }

		
	}
		
	
	/**
   * class constructor php5	
   */	
	public function __construct() {	
	
		$this->_admin=konf::get()->getKonfigTab("subs_konf",'admin_subs');
		

  }	

	
}	

?>