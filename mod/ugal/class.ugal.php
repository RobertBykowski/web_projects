<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}


class ugal extends moduladmin {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="ugal class";

	/**
	 * bierzacy 
	 */				
  private $id_u="";			
	
	/**
   * galeria arch
   */		
	public function arch(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$sortuj=tekstForm::doSql(konf::get()->getZmienna('sortuj','sortuj'));		
		$dane_u=$this->getU();
		
		if(!empty($dane_u)){
		
			$colspan=konf::get()->getKonfigTab("u_konf",'galeria_kolumna');
			$wiersz=konf::get()->getKonfigTab("u_konf",'galeria_wiersz');
			$na_str=$colspan*$wiersz;
		
	    //pzygotowanie zapytania pobrania danych
	    $tab_sort=array(
				1=>"id", 2=>"id DESC",			
				5=>"tytul", 6=>"tytul DESC", 
				9=>"licznik", 10=>"licznik DESC",
				11=>"punkty_srednia", 12=>"punkty_srednia DESC",									
				13=>"punkty_ilosc", 14=>"punkty_ilosc DESC",						
			);
			
	    if(empty($sortuj)||empty($tab_sort[$sortuj])){ 
				$sortuj=1; 
			}

	    $query=" FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy_galeria')." WHERE 1 ".$this->sqlAdd(); 

	    //sciezki do linkow
	    $link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ugal_arch","id_u"=>$this->id_u));
	    $link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ugal_zobacz","id_u"=>$this->id_u));
	    $link3=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ugal_edytuj","podstrona"=>$podstrona,"sortuj"=>$sortuj));						
	    $link4=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ugal_usun","podstrona"=>$podstrona,"sortuj"=>$sortuj));							
			
			$naw = new nawig("SELECT COUNT(id) AS ilosc".$query,$podstrona,$na_str);		
			$naw->naw($link."&amp;sortuj=".$sortuj);
			$podstrona=$naw->getPodstrona();	
			
			if($this->id_u==user::get()->id()){		
				$u=new u();		
				$u->menuEdycja(user::get()->id());
			}			
	    
	    //naglowek
	    echo tab_nagl("Galeria zdjęć użytkownika ".user::get()->nazwa($dane_u)." (".$naw->getIle()."):",$colspan);

	    echo "<tr><td colspan=\"".$colspan."\" class=\"tlo4 lewa\">";	
			
			if($this->id_u==user::get()->id()){		
			
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\"><tr>";
				
				echo "<td style=\"padding-right:40px;\">";
				$form=new formularz("post",konf::get()->getKonfigTab("plik"),"archuf","archuf");
				echo $form->spr(array(1=>"akcja"),"","ok=spr_galeriau();");
				echo $form->getFormp();
				echo $form->przenies(array(
					"akcja"=>"ugal_dodaj",
					"sortuj"=>$sortuj,
					"id_u"=>$this->id_u,			
					"podstrona"=>$podstrona
				));
				
				echo $form->input("submit","","","dodaj nowe","formularz2 f_sredni");						
				
		    echo $form->getFormk();
				echo "</td>";
				
				echo "<td>";
				
			}
		
			/*
			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"archf","archf");
			echo $form->getFormp();
			echo $form->przenies(array(
				"akcja"=>konf::get()->getAkcja(),
				"id_u"=>$this->id_u,
			));
			
	    $sortuj_tab[1]="sortuj według data dodania";
			if(konf::get()->getKonfigTab("u_konf",'galeria_punkty')){
		    $sortuj_tab[12]="sortuj według ocen";					
			}
			
			echo $form->select("sortuj","sortuj",$sortuj_tab,$sortuj,"f_dlugi",""," onchange='this.submit();'");			
			
	    echo $form->getFormk();	
			*/		
			
			if($this->id_u==user::get()->id()){		
			
				echo "</td></tr></table>";
				
			}			
			
			echo "</td></tr>";					
			

	    //pobieranie danych  
	    $query="SELECT * ".$query." ORDER BY ".$tab_sort[$sortuj];
	    $query.=" LIMIT ".$naw->getStart().",".$naw->getIle();					
	    $zap=konf::get()->_bazasql->zap($query);
	    $ile=konf::get()->_bazasql->numRows($zap);  
	    $i=0;	
			
			if($ile>0){
			
				$przenies['sortuj']=$sortuj;
				$przenies['podstrona']=$podstrona;

				if($naw->getNaw()){
					echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
				}				
		    
		    while($dane3=konf::get()->_bazasql->fetchAssoc($zap)){
				
					if($i==0){
			      echo "<tr class=\"srodek\" valign=\"top\">";
					}
	 
		      echo "<td class=\"tlo3 srodek\" style=\"width:25%\">";

					if($this->id_u==user::get()->id()){					
						echo "<div class=\"srodek\"><table border=\"0\" style=\"margin-top:5px\" class=\"srodek\"><tr>";    				
				    echo interfejs::edytuj($link3."&amp;id_nr=".$dane3['id']);				
						echo interfejs::usun($link4."&amp;id_tab[1]=".$dane3['id']); 
						echo "</tr></table></div>";   								
					}			
					
					echo "<div>";					
					echo $this->fotka($dane3,2,true,$przenies);
					echo "</div>";
										
					echo "<a href=\"".$this->fotkaLink($dane3,$przenies)."\">".$dane3['tytul']."</a>";
					
					echo "<div class=\"male\">";
					echo "<div>Data dodania:</div>";
					echo "<div class=\"grube\">".substr($dane3['autor_kiedy'],0,16)."</div>";
					echo "</div>";
					
					echo "</td>";

					$i++;
					
					if($i==$colspan){
			      echo "</tr>";
						$i=0;
					}
					
		    }
				
				if($i>0){
					while($i<$colspan){
						echo "<td style=\"width:25%\">&nbsp;</td>";
						$i++;
					}
					echo "</tr>";
				}
				
		    konf::get()->_bazasql->freeResult($zap);									
				
				if($naw->getNaw()){
					echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
				}	
		
	    } else {
				echo interfejs::brak($colspan);			 
	    }
			
			echo "<tr class=\"srodek\"><td class=\"tlo4\" colspan=\"".$colspan."\">".interfejs::linkEl("user",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane","id_u"=>$this->id_u)),"Profil użytkownika")."</td></tr>";			
	    
	    echo tab_stop();

	  } else {
			interfejs::nieprawidlowe();
	  }
		  
	}

	
	/**
   * remove
   */		
	public function usun(){
	
		require_once(konf::get()->getKonfigTab("klasy")."class.galeriaadmin.php");		
		$galeria=new galeriaadmin(konf::get()->getKonfigTab("sql_tab",'uzytkownicy_galeria'),konf::get()->getKonfigTab("u_konf",'galeria_kat'));	
		$galeria->setSqlAdd(" AND id_matka='".user::get()->id()."'");	
		$galeria->usun("galeria profilu - usuwanie zdjęcia");
		
	}

	
	public function fotkaLink($dane,$przenies=""){
	
		if(empty($przenies)){
			$przenies=array();
		}
		$przenies['akcja']="ugal_zobacz";
		$przenies['id_u']=$dane['id_matka'];		
		$przenies['id_nr']=$dane['id'];				
		
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),$przenies);		
		
		return $link;
	
	}
	
	
	public function fotka($dane,$nr=2,$link=true,$przenies=""){
	
		$html="";
		if($link){
			$html.="<a href=\"".$this->fotkaLink($dane,$przenies)."\">";
		}
	 	$html.="<img src=\"".konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("u_konf",'galeria_kat').$dane['img'.$nr.'_nazwa']."\" class=\"obrazek\" width=\"".$dane['img'.$nr.'_w']."\" height=\"".$dane['img'.$nr.'_h']."\" alt=\"".htmlspecialchars($dane['tytul'])."\" />";
		if($link){
			$html.="</a>";	
		}
		
		return $html;
	
	}
	
	/**
   * art akapity form
   */		
	private function galeriaForm(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$sortuj=konf::get()->getZmienna('sortuj','sortuj');		
	 	$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));
		$this->id_u=user::get()->id();					
		$dane=array();
		
		if(!empty($id_nr)){
			$danea=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy_galeria')." WHERE id='".$id_nr."' AND id_matka='".$this->id_u."'");
			if(!empty($danea)){
				$dane=$danea;
			} else {
				$id_nr="";
			}
		}				

		if(!empty($id_nr)||konf::get()->getAkcja()=="ugal_dodaj"){
		
			if($this->id_u==user::get()->id()){		
				$u=new u();		
				$u->menuEdycja(user::get()->id());
			}					

			if(konf::get()->getAkcja()=="ugal_dodaj"){
	  		echo tab_nagl("Moja galeria - dodawanie zdjęcia",1);
		  } else {
	  	  echo tab_nagl("Moja galeria - edycja zdjęcia",1);
		  }
			
		  echo "<tr><td valign=\"top\" class=\"tlo3\">";

			if(!empty($id_nr)){
				$this->galeriaMenu($dane);
			}
			
			echo "<br />";   
			
			$przenies=array();	
			$przenies['sortuj']=$sortuj;
			$przenies['podstrona']=$podstrona;		
			require_once(konf::get()->getKonfigTab("klasy")."class.galeriaadmin.php");		
			$galeria=new galeriaadmin(konf::get()->getKonfigTab("sql_tab",'uzytkownicy_galeria'),konf::get()->getKonfigTab("u_konf",'galeria_kat'));							
			$galeria->setPoz(false);
			$galeria->setStatus(false);	
			$galeria->setStatusDomyslny(1);								
			$galeria->formularz($dane,$przenies,konf::get()->getKonfigTab("u_konf",'galeria_opis'),false,false,false);
			
			echo "</td></tr>";
			
			echo "<tr class=\"srodek\"><td class=\"tlo4\">".interfejs::linkEl("folder_explore",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ugal_arch")),"Powrót do galerii")."</td></tr>";
	  	echo tab_stop();
			
	  } else {
			echo interfejs::nieprawidlowe();	
	  }
		
	}
	
	/**
   * art add
   */		
	public function dodaj(){	
		if($this->oblLimit()){
			$this->galeriaForm();
		}
	}
	
	
	/**
   * art edit
   */		
	public function edytuj(){	
		$this->galeriaForm();
	}		
	
	
	
	/**
   * gallery save
   */		
	private function galeriaZapisz(){
	
	 	$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));
		$this->id_u=user::get()->id();					
		$dane=array();
		
		if(!empty($id_nr)){
			$danea=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy_galeria')." WHERE id='".$id_nr."' AND id_matka='".$this->id_u."'");
			if(!empty($danea)){
				$dane=$danea;
			} else {
				$id_nr="";
			}
		}						
		
		$ok=false;
		
		$dane_u=$this->getU();
		
		//sprawdzamy czy sa dane
		if(!empty($dane_u)&&(!empty($id_nr)||konf::get()->getAkcja()=="ugal_dodaj2")){
		
			require_once(konf::get()->getKonfigTab("klasy")."class.galeriaadmin.php");		
			$galeria=new galeriaadmin(konf::get()->getKonfigTab("sql_tab",'uzytkownicy_galeria'),konf::get()->getKonfigTab("u_konf",'galeria_kat'));	
			$galeria->setPoz(false);
			$galeria->setStatus(false);			
			$galeria->setStatusDomyslny(1);	
			$galeria->setSqlAdd($this->sqlAdd());				
			$rozmiary=$this->galeriaKonfig();
			
			$ok=$galeria->zapisz($dane_u,false,$rozmiary,"galeria profilu - zapis zdjęcia","Galeria profilu - zapis zdjęcia");

		}	else {
			konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 		
		}

		if(empty($ok)){
			konf::get()->setAkcja("ugal_arch");				
		} else {
			if(konf::get()->getAkcja()=="ugal_dodaj2"){
				konf::get()->setAkcja("ugal_arch");					
			} else {
				konf::get()->setAkcja("ugal_edytuj");					
			}
		}
		
	}	


	/**
   * art add
   */		
	public function dodaj2(){	
		if($this->oblLimit()){	
			$this->galeriaZapisz();
		}
	}
		
	/**
   * art edit
   */		
	public function edytuj2(){	
		$this->galeriaZapisz();
	}	
	
	
	private function getU(){
	
		if(user::get()->id()==$this->id_u){
			$dane=user::get()->getDane();
		} else {
			$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE id='".$this->id_u."'".user::get()->getSqlAdd());
		}
		
		return $dane;
	
	}
	
	
	private function sqlAdd(){
	
		$sql=" AND id_matka='".$this->id_u."'";
		if(!$this->admin()&&($this->id_u!=user::get()->id())){
			$sql.=" AND status=1";
		}
	
		return $sql;
	
	}
		

	
	private function galeriaKonfig(){
	
		$rozmiary=array();
		$rozmiary['galeria_min_size']=konf::get()->getKonfigTab("u_konf",'galeria_min_size');			
		$rozmiary['galeria_m_w']=konf::get()->getKonfigTab("u_konf",'galeria_m_size');	
		$rozmiary['galeria_m_h']=konf::get()->getKonfigTab("u_konf",'galeria_m_size');				
		$rozmiary['galeria_img_size']=konf::get()->getKonfigTab("u_konf",'galeria_img_size');
		$rozmiary['galeria_skala']=konf::get()->getKonfigTab("u_konf",'galeria_skalowanie');						
		
		return $rozmiary;		
	
	}		
	
	
  /**
   * galeria menu
   * @param array $dane
   */		
	public function galeriaMenu($dane){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$sortuj=konf::get()->getZmienna('sortuj','sortuj');		
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_u"=>$dane['id_matka'],"podstrona"=>$podstrona,"sortuj"=>$sortuj));

		echo "<table border=\"0\" style=\"margin-top:5px\"><tr>";    
    echo interfejs::edytuj($link."&amp;akcja=ugal_edytuj&amp;id_nr=".$dane['id']);  
	  echo interfejs::przyciskEl("picture",$link."&amp;akcja=ugal_zobacz&amp;id_nr=".$dane['id'],"zobacz zdjęcie"); 			
		echo interfejs::usun($link."&amp;akcja=ugal_usun&amp;id_tab[1]=".$dane['id']);		
	  echo interfejs::przyciskEl("arrow_join",$link."&amp;akcja=ugal_arch",konf::get()->langTexty("powrot")); 		

		echo "</tr></table>";  		
	
	}	
	
	
	/**
   * art akapity form
   */		
	public function zobacz(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$sortuj=konf::get()->getZmienna('sortuj','sortuj');		
	 	$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));
				
		$dane_u=$this->getU();						
		
		if(!empty($dane_u)&&!empty($id_nr)){
			$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy_galeria')." WHERE id='".$id_nr."'".$this->sqlAdd());
		}			

		if(!empty($dane)){

	    echo tab_nagl("Galeria zdjęć ".user::get()->nazwa($dane_u));
			
		  echo "<tr><td valign=\"top\" class=\"tlo4 grube\">";

			require_once(konf::get()->getKonfigTab("klasy")."class.cofnijdalej.php");		
			$cofnijdalej=new cofnijdalej("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy_galeria')." WHERE 1 ".$this->sqlAdd()." ORDER BY id DESC",$dane,"id","id");	
		  $cofnijdalej->setPrzenies(array("akcja"=>konf::get()->getAkcja(),"sortuj"=>$sortuj,"id_u"=>$this->id_u));	
			$cofnijdalej->setPorownaj("id");
			$cofnijdalej->setZmienna("id_nr");
			$cofnijdalej->setPowrot("<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ugal_arch","id_u"=>$this->id_u))."\">powrót</a>");
		  $cofnijdalej->naw();
		  echo $cofnijdalej->getNaw();	
			
			echo "</td></tr>";
			
			echo "<tr><td class=\"tlo3 srodek\">";
			
			if(user::get()->id()==$dane['autor_id']){
				$this->galeriaMenu($dane);
			}			
			
			echo "<div class=\"srodek\">";		
			echo $this->fotka($dane,1,false);
			echo "</div>";	
			
			echo "<div class=\"srodek\">".$dane['tytul']."</div>";
			echo "</td></tr>";
			
			echo "<tr class=\"srodek\"><td class=\"tlo4\">".interfejs::linkEl("folder_explore",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ugal_arch","id_u"=>$this->id_u)),"Powrót do galerii")."</td></tr>";
	  	echo tab_stop();
						
	    if(konf::get()->isMod("koment")&&konf::get()->getKonfigTab("u_konf",'galeria_koment')){
				$konf=konf::get();
				require_once(konf::get()->getKonfigTab('mod_kat')."koment/class.koment.php");
				$koment=new koment(3);
				$koment->setPrzenies(array("id_nr"=>$dane['id'],"id_u"=>$this->id_u));
				$koment->setId($dane['id']);						
				$koment->wyswietl();
				$koment->formularz();						
	    }					
				
	  } else {
			echo interfejs::nieprawidlowe();	
	  }
		
	}	
	
	
	private function oblLimit(){
	
		$ok=true;
		
		if(konf::get()->getKonfigTab("u_konf",'galeria_limit')&&konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy_galeria')." WHERE autor_id='".$this->id_u."'")>=konf::get()->getKonfigTab("u_konf",'galeria_limit')){
			$ok=false;
			konf::get()->setKomunikat("Przekroczony limit zdjęć w galerii. Aby dodać nowe zdjęcia należy usunąć część dotychczasowych zdjęć","error"); 				
		}
		
		return $ok;
	
	}
	
	
	/**
   * class constructor php5	
   */	
	public function __construct() {	
		
		$this->id_u=konf::get()->getZmienna("id_u",'id_u');
		if(empty($this->id_u)){
			$this->id_u=user::get()->id();
		}
		
  }	

		
}

?>