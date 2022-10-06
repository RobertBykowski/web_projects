<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

class komentadmin extends moduladmin {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="komentadmin class";


	/**
   * data types
   */	
	public function typy(){

		$colspan=2;
		$tab=konf::get()->getKonfigTab("koment_konf","typy_tab");
		
		echo tab_nagl("Typy komentarzy",$colspan);
		echo "<tr>";		
		echo "<td class=\"tlo4 lewa grube\">nazwa typu komentarzy</td>";
		echo "<td class=\"tlo4 prawa grube\" style=\"width:50px\">ilość</td>";
		echo "</tr>";	

		if(!empty($tab)&&is_array($tab)){
		
			$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"komentadmin_arch"));
			while(list($key,$val)=each($tab)){
				echo "<tr>";
				echo interfejs::innyEl("text_list_bullets","<a href=\"".$link."&amp;id_typ=".$key."\">".$val['nazwa']."</a>","tlo3");
				echo "<td class=\"tlo3 prawa\">";
				echo konf::get()->_bazasql->policz("id"," FROM ".$val['mysql']." WHERE 1");
				echo "</td></tr>";
			}

		} else {
		
			echo interfejs::brak($colspan);
			
		}
		
		echo tab_stop();
	}


  /**
   * data arch
   */	
	public function arch(){

		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));		
		$sortuj=tekstForm::doSql(konf::get()->getZmienna('sortuj','sortuj'));
		$id_typ=tekstForm::doSql(konf::get()->getZmienna('id_typ','id_typ'));	
		$tab=konf::get()->getKonfigTab("koment_konf","typy_tab");		
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');		
		$colspan=5;
		$na_str=25;
		
		if(empty($tab[$id_typ])){
			$id_typ="";
		}
		
		$tab_sort=array(	
			1=>"autor_kiedy, id",
			2=>"autor_kiedy DESC, id DESC",
			3=>"id", 
			4=>"id DESC", 		
			5=>"autor_name", 
			6=>"autor_name DESC", 
			7=>"status", 
			8=>"status DESC",
		);

		if(empty($tab_sort[$sortuj])){ 
			$sortuj=5;
		}
		
		if(!empty($id_typ)){
			
			$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"komentadmin_arch","id_typ"=>$id_typ));
			$link3=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"komentadmin_arch","sortuj"=>$sortuj,"id_typ"=>$id_typ));		
			$link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"komentadmin_edytuj","id_typ"=>$id_typ));
			
			$query=" FROM ".$tab[$id_typ]['mysql']." WHERE 1 ";
			
			$naw = new nawig("SELECT COUNT(id) AS ilosc ".$query,$podstrona,$na_str);		
			$naw->naw($link3);
			$podstrona=$naw->getPodstrona();	
			
			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"arch","arch");
			echo $form->spr(array(1=>"akcja"),"","ok=spr_akcjau(document.arch.akcja,'komentadmin_usun','".konf::get()->langTexty("czyusun")."');");
			echo $form->getFormp();
			echo $form->przenies(array("sortuj"=>$sortuj,"podstrona"=>$podstrona,"id_typ"=>$id_typ));
			
		  echo tab_nagl("Komentarze ".$tab[$id_typ]['nazwa']." (".$naw->getWynikow()."):",$colspan);

		   //akcje 
			$akcje_tab=array(); 			
			if($naw->getWynikow()>0){		
				$akcje_tab['komentadmin_aktyw']=konf::get()->langTexty("aaktyw");
				$akcje_tab['komentadmin_deaktyw']=konf::get()->langTexty("adeaktyw");
				$akcje_tab['komentadmin_usun']=konf::get()->langTexty("ausun");
			}

		  echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 lewa\">";
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
			echo interfejs::sortEl($link."&amp;sortuj=",3,4,"id",$sortuj,50);
			echo interfejs::sortEl($link."&amp;sortuj=",1,2,"data",$sortuj,100);			
			echo interfejs::sortEl($link."&amp;sortuj=",5,6,"autor, treść",$sortuj);
			echo interfejs::sortEl($link."&amp;sortuj=",7,8,"status",$sortuj,70);
			echo interfejs::sortEl("","","","&nbsp;","",99);
			echo "</tr>";

			if($naw->getWynikow()>0){
			
				$zap=konf::get()->_bazasql->zap("SELECT * ".$query." ORDER BY ".$tab_sort[$sortuj].",id LIMIT ".$naw->getStart().",".$naw->getIle());
				
				while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
					echo "<tr class=\"srodek\">";
					echo "<td class=\"tlo4 srodek\">";
					echo $form->checkbox("id_tab[]","id_".$dane['id'],$dane['id'],"");	
					echo "<div";
					if($id_nr==$dane['id']){
						echo " class=\"grube\"";
					}
					echo ">".$dane['id']."</div>";			
					echo "</td>";
										
					echo "<td class=\"srodek tlo3 male\">";
					echo str_replace(" ","<br />",$dane['autor_kiedy']);
					echo "</td>";				
					
					echo "<td class=\"lewa tlo3\">";
					echo "<a class=\"grube\" href=\"".$link2."&amp;id_nr=".$dane['id']."\">";
					echo $dane['autor_name'];
					echo "</a>";
					
					if(!empty($dane['ip'])){
						echo "<span class=\"male\"> (ip: ".$dane['ip'].")</span>";
					}
					
					echo "<div style=\"padding-top:7px;\">";
					echo tekstForm::doWys($dane['tresc']);
					echo "</div>";
					echo "</td>";								

					echo "<td class=\"tlo3\">";
		      if($dane['status']==1){ 
						echo konf::get()->langTexty("aktywne"); 
					} else { 
						echo konf::get()->langTexty("nieaktywne"); 
					}
					echo "</td>";
					
					echo "<td class=\"srodek tlo3\" valign=\"top\">";
					echo "<table border=\"0\" class=\"srodek\"><tr valign=\"top\">"; 
					echo interfejs::edytuj($link2."&amp;id_nr=".$dane['id']); 						   
					echo interfejs::infoEl($dane);
					echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"komentadmin_usun","id_typ"=>$id_typ,"id_tab[]"=>$dane['id']))); 
					echo "</tr></table>"; 				
					echo "</td>";
					echo "</tr>";
					
				}		
				konf::get()->_bazasql->freeResult($zap);		

				if($naw->getNaw()){
					echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
				}

			} else { 
				echo interfejs::brak($colspan);
			}

		  echo "<tr class=\"srodek\"><td colspan=\"".$colspan."\" class=\"tlo4 srodek\">".interfejs::linkEl("text_list_bullets",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"komentadmin_typy")),"Typy komentarzy")."</td></tr>";
			
		  echo tab_stop();
			echo $form->getFormk();
			
		} else {
		
			echo interfejs::nieprawidlowe();			
			
		}		
		
	}


  /**
   * form
   */		
	protected function formularz(){
	
		$id_typ=tekstForm::doSql(konf::get()->getZmienna('id_typ','id_typ'));			
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));		
		$sortuj=tekstForm::doSql(konf::get()->getZmienna('sortuj','sortuj'));
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$tab=konf::get()->getKonfigTab("koment_konf","typy_tab");		
		if(empty($tab[$id_typ])){
			$id_typ="";
		}
	
		//domyślne wartosci
		$dane=array(
			'tresc'=>"",
			'status'=>"",
		);
		
		if(!empty($id_typ)&&!empty($id_nr)){
		
			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"koment","koment");	
			$dane=$form->odczyt($dane);			
			
			$dane2=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".$tab[$id_typ]['mysql']." WHERE id='".$id_nr."'");
			if(!empty($dane2)){
				$dane=$dane2;
			} else {
				$id_nr="";
			}
				
		}

		if(!empty($id_typ)&&!empty($id_nr)){
		
		  echo tab_nagl("Formularz edycji komentarza",1);
	  	
	  	echo "<tr><td class=\"lewa tlo3\">"; 
			
			echo $form->spr(array(2=>"tresc"),"","");
			echo $form->getFormp();
			echo $form->przenies(array(
				"akcja"=>konf::get()->getAkcja()."2",
				"id_nr"=>$id_nr,
				"id_typ"=>$id_typ,				
				"podstrona"=>$podstrona,
				"sortuj"=>$sortuj
			));
	
			echo "<table border=\"0\"><tr>";    
			echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"komentadmin_usun","id_typ"=>$id_typ,"id_tab[]"=>$id_nr))); 
			echo interfejs::infoEl($dane);				
			echo interfejs::przyciskEl("arrow_join",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"komentadmin_arch","podstrona"=>$podstrona,"sortuj"=>$sortuj,"id_typ"=>$id_typ)),"powrót do listy komentarzy");
			echo "</tr></table><br />";   
			
	    echo "<div>";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");
			echo "</div><br />";		
			
			echo "<div>";
			echo "typ: <span class=\"grube\">".$tab[$id_typ]['nazwa']."</span>";
			echo "</div>";			
			
			echo "<div>";
			echo "autor komentarza: <span class=\"grube\">".$dane['autor_name']."</span>";
			echo "</div>";
			
			echo "<div>";
			echo "data komentarza: <span class=\"grube\">".$dane['autor_kiedy']."</span>";
			echo "</div>";			
			
			if(!empty($dane['ip'])){
				echo "<div>";
				echo "ip: <span class=\"grube\">".$dane['ip']."</span>";
				echo "</div>";		
			}				
				
			echo "<br />";
			echo "<div>";
			echo interfejs::label("tresc","treść komentarza*:","grube");
			echo "</div>";
			echo $form->textarea("tresc","tresc",$dane['tresc'],"f_bdlugi",10);	
			echo "<br />";

			$i=0;
			
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
			
			echo "<tr class=\"srodek\"><td class=\"tlo4\">".interfejs::linkEl("text_list_bullets",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"komentadmin_arch","podstrona"=>$podstrona,"sortuj"=>$sortuj,"id_typ"=>$id_typ)),konf::get()->langTexty("koment_form_arch"))."</td></tr>";	
			
			echo tab_stop();
			
		} else { 
			echo interfejs::nieprawidlowe();	
		}
		
	}
	

  /**
   * save data
   */					
	protected function zapisz(){

		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr'));
		$id_typ=tekstForm::doSql(konf::get()->getZmienna('id_typ'));		
		$tab=konf::get()->getKonfigTab("koment_konf","typy_tab");		
		if(empty($tab[$id_typ])){
			$id_typ="";
		}

		//dane podstawowe z formularza
		$dane=array(	
			"tresc"=>"",				
			"status"=>"",			
		);

		$testy[]=array("zmienna"=>"status","test"=>"truefalse");	
		
		$testy[]=array("zmienna"=>"tresc","test"=>"wartosc","wymagany"=>true,
			"param"=>array(
				"komunikat"=>"brak treści komentarza",
				'idtf'=>"tresc"			
			)	
		);		
			
		if(!empty($id_typ)&&!empty($id_nr)){

			$dane2=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".$tab[$id_typ]['mysql']." WHERE id='".$id_nr."'");
			if(empty($dane2)){
				$id_nr="";
			}
				
		}

		if(!empty($id_nr)){		
		
			//generator zapytania insert/update
			require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
			$sqldane=new sqlZapis($tab[$id_typ]['mysql'],$dane);
			$sqldane->daneOdczyt();	
			$sqldane->setAutor(true);	
			$sqldane->setTesty($testy);		
			$sqldane->testuj();	
			
			if($sqldane->ok()){

				//budowanie zapytania
				$sqldane->dodajDaneE();							
				$sqldane->dodaj(" WHERE id='".$id_nr."'");	
				
				//wykonujemy
				if($sqldane->getSql()){
					konf::get()->_bazasql->zap($sqldane->getSql());
				}		
								
				user::get()->zapiszLog("komentarze edycja ".$id_nr,user::get()->login());
				konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");
	
			} else { 
				konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
			}	

		} else { 
			konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
		}

		konf::get()->setAkcja("komentadmin_edytuj");
						
	}
	
	
  /**
   * set active
   */			
	public function aktyw(){
	
		$id_typ=tekstForm::doSql(konf::get()->getZmienna('id_typ','id_typ'));		
		$tab=konf::get()->getKonfigTab("koment_konf","typy_tab");		
		
		if(empty($tab[$id_typ])){
			$id_typ="";
		}	
	
		if(!empty($id_typ)){
			$this->zmienparam("status",1,$tab[$id_typ]['mysql'],"komentarze zmiana statusu");	
		}

	}
	
	
  /**
   * set deactive
   */		
	public function deaktyw(){
	
		$id_typ=tekstForm::doSql(konf::get()->getZmienna('id_typ','id_typ'));		
		$tab=konf::get()->getKonfigTab("koment_konf","typy_tab");	
			
		if(empty($tab[$id_typ])){
			$id_typ="";
		}	
	
		if(!empty($id_typ)){
			$this->zmienparam("status",0,$tab[$id_typ]['mysql'],"komentarze zmiana statusu");	
		}
		
	}	

	
  /**
   * remove data
   */	
	public function usun(){

		$id_tab=konf::get()->getZmienna('id_tab','id_tab');
		$id_typ=tekstForm::doSql(konf::get()->getZmienna('id_typ','id_typ'));		
		$tab=konf::get()->getKonfigTab("koment_konf","typy_tab");		
		
		if(empty($tab[$id_typ])){
			$id_typ="";
		}	
	
		if(!empty($id_typ)&&!empty($id_tab)&&is_array($id_tab)){
		
			$query=tekstForm::tabQuery($id_tab);
			
			if(!empty($query)){
				konf::get()->_bazasql->zap("DELETE FROM ".$tab[$id_typ]['mysql']." WHERE id IN (".$query.")");			
				user::get()->zapiszLog("komentarze usuwanie",user::get()->login());
			}
			konf::get()->setKomunikat(konf::get()->langTexty("usuwanie"),""); 
			
		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),"error"); 		
		}
		
	}	
	
	
	/**
   * class constructor php5	
   */	
	public function __construct() {	
	
		$this->_admin=konf::get()->getKonfigTab("koment_konf",'admin');

  }	

}

?>