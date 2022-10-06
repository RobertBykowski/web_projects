<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}


class grupygal extends moduladmin {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="grupygal class";

	/**
	 * bierzacy 
	 */				
  private $_id_grupa="";			
	
	/**
	 * dane grupy
	 */				
  public $_dane="";			
		
	
	/**
   * galeria arch
   */		
	public function arch(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$sortuj=tekstForm::doSql(konf::get()->getZmienna('sortuj','sortuj'));		
		
		if(!empty($this->_dane)){
		
			$colspan=konf::get()->getKonfigTab("grupy_konf",'galeria_kolumna');
			$wiersz=konf::get()->getKonfigTab("grupy_konf",'galeria_wiersz');
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

	    $query=" FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_galeria')." WHERE 1 ".$this->sqlAdd(); 

	    //sciezki do linkow
	    $link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupygal_arch","id_grupa"=>$this->_id_grupa));
	    $link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupygal_zobacz","id_grupa"=>$this->_id_grupa));
	    $link3=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupygal_edytuj","podstrona"=>$podstrona,"sortuj"=>$sortuj,"id_grupa"=>$this->_id_grupa));						
	    $link4=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupygal_usun","podstrona"=>$podstrona,"sortuj"=>$sortuj,"id_grupa"=>$this->_id_grupa));							
			
			$naw = new nawig("SELECT COUNT(id) AS ilosc".$query,$podstrona,$na_str);		
			$naw->naw($link."&amp;sortuj=".$sortuj);
			$podstrona=$naw->getPodstrona();	
			
			if($this->_id_grupa==user::get()->id()){		
				$u=new u();		
				$u->menuEdycja(user::get()->id());
			}			
			
			$spradmin=$this->sprAdmin($this->_id_grupa);
	    
	    //naglowek
	    echo tab_nagl("Galeria zdjęć grupy ".$this->_dane['nazwa']." (".$naw->getIle()."):",$colspan);

	    echo "<tr><td colspan=\"".$colspan."\" class=\"tlo4 lewa\">";	
			
			if($spradmin){		
			
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\"><tr>";
				
				echo "<td style=\"padding-right:40px;\">";
				$form=new formularz("post",konf::get()->getKonfigTab("plik"),"archuf","archuf");
				echo $form->spr(array(1=>"akcja"),"","ok=spr_galeriau();");
				echo $form->getFormp();
				echo $form->przenies(array(
					"akcja"=>"grupygal_dodaj",
					"sortuj"=>$sortuj,
					"id_grupa"=>$this->_id_grupa,			
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
				"id_grupa"=>$this->_id_grupa,
			));
			
	    $sortuj_tab[1]="sortuj według data dodania";
			if(konf::get()->getKonfigTab("grupy_konf",'galeria_punkty')){
		    $sortuj_tab[12]="sortuj według ocen";					
			}
			
			echo $form->select("sortuj","sortuj",$sortuj_tab,$sortuj,"f_dlugi",""," onchange='this.submit();'");			
			
	    echo $form->getFormk();		
			*/	
			
			if($spradmin){		
			
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

					if($spradmin&&($this->admin()||user::get()->id()==$this->_dane['autor_id']||$dane3['autor_id']==user::get()->id())){					
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
			
			echo "<tr class=\"srodek\"><td class=\"tlo4\" colspan=\"".$colspan."\">".interfejs::linkEl("group",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_zobacz","id_grupa"=>$this->_id_grupa)),"Dane grupy")."</td></tr>";
	    
	    echo tab_stop();

	  } else {
			interfejs::nieprawidlowe();
	  }
		  
	}

	
	/**
   * remove
   */		
	public function usun(){
		
		if(!empty($this->_dane)&&$this->sprAdmin($this->_id_grupa)){
		
			$sql=$this->sqlAdd();
			
			if(!$this->admin()&&!user::get()->id()==$this->_dane['autor_id']){			
				$sql.=" AND autor_id='".user::get()->id()."'";
			}	
		
			require_once(konf::get()->getKonfigTab("klasy")."class.galeriaadmin.php");		
			$galeria=new galeriaadmin(konf::get()->getKonfigTab("sql_tab",'grupy_galeria'),konf::get()->getKonfigTab("grupy_konf",'galeria_kat'));		
			$galeria->usun("galeria grupy - usuwanie zdjęcia");
			
		}
		
	}

	
	public function fotkaLink($dane,$przenies=""){
	
		if(empty($przenies)){
			$przenies=array();
		}
		$przenies['akcja']="grupygal_zobacz";
		$przenies['id_grupa']=$dane['id_matka'];		
		$przenies['id_nr']=$dane['id'];				
		
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),$przenies);		
		
		return $link;
	
	}
	
	
	public function fotka($dane,$nr=2,$link=true,$przenies=""){
	
		$html="";
		if($link){
			$html.="<a href=\"".$this->fotkaLink($dane,$przenies)."\">";
		}
	 	$html.="<img src=\"".konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("grupy_konf",'galeria_kat').$dane['img'.$nr.'_nazwa']."\" class=\"obrazek\" width=\"".$dane['img'.$nr.'_w']."\" height=\"".$dane['img'.$nr.'_h']."\" alt=\"".htmlspecialchars($dane['tytul'])."\" />";
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
		$dane=array();
		$ok=true;
		
		if(!empty($this->_dane)&&$this->sprAdmin($this->_id_grupa)){			
			
			if(!empty($id_nr)){
			
				$sql="SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_galeria')." WHERE id='".$id_nr."' AND id_matka='".$this->_id_grupa."'";
				if(!$this->admin()&&$this->_dane['autor_id']!=user::get()->id()){
					$sql.=" AND autor_id='".user::get()->id()."'";
				}
				
				$danea=konf::get()->_bazasql->pobierzRekord($sql);
				
				if(!empty($danea)){
					$dane=$danea;
				} else {
					$id_nr="";
				}
			}		
			
		} else {
		
			$ok=false;
			
		}			

		if($ok&&(!empty($id_nr)||konf::get()->getAkcja()=="grupygal_dodaj")){
			
			if(konf::get()->getAkcja()=="grupygal_dodaj"){
	  		echo tab_nagl("Galeria grupy ".$this->_dane['nazwa']." - dodawanie zdjęcia",1);
		  } else {
	  	  echo tab_nagl("Galeria grupy ".$this->_dane['nazwa']." - edycja zdjęcia",1);
		  }
			
		  echo "<tr><td valign=\"top\" class=\"tlo3\">";

			if(!empty($id_nr)){
				$this->galeriaMenu($dane);
			}
			
			echo "<br />";   
			
			$przenies=array();	
			$przenies['sortuj']=$sortuj;
			$przenies['podstrona']=$podstrona;		
			$przenies['id_grupa']=$this->_id_grupa;					
			require_once(konf::get()->getKonfigTab("klasy")."class.galeriaadmin.php");		
			$galeria=new galeriaadmin(konf::get()->getKonfigTab("sql_tab",'grupy_galeria'),konf::get()->getKonfigTab("grupy_konf",'galeria_kat'));							
			$galeria->setPoz(false);
			$galeria->setStatus(false);	
			$galeria->setStatusDomyslny(1);								
			$galeria->formularz($dane,$przenies,konf::get()->getKonfigTab("grupy_konf",'galeria_opis'),false,false,false);
			
			echo "</td></tr>";
			
			echo "<tr class=\"srodek\"><td class=\"tlo4\">".interfejs::linkEl("folder_explore",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupygal_arch","id_grupa"=>$this->_id_grupa)),"Powrót do galerii")."</td></tr>";
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
		$dane=array();

		if(!empty($this->_dane)&&$this->sprAdmin($this->_id_grupa)){			
			
			if(!empty($id_nr)){
			
				$sql="SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_galeria')." WHERE id='".$id_nr."' AND id_matka='".$this->_id_grupa."'";
				if(!$this->admin()){
					if($this->_dane['autor_id']!=user::get()->id()){
						$sql.=" AND autor_id='".user::get()->id()."'";
					}
				}
				
				$danea=konf::get()->_bazasql->pobierzRekord($sql);
				if(!empty($danea)){
					$dane=$danea;
				} else {
					$id_nr="";
				}
				
			}						
			
			$ok=false;
			
			//sprawdzamy czy sa dane
			if(!empty($id_nr)||konf::get()->getAkcja()=="grupygal_dodaj2"){
			
				require_once(konf::get()->getKonfigTab("klasy")."class.galeriaadmin.php");		
				$galeria=new galeriaadmin(konf::get()->getKonfigTab("sql_tab",'grupy_galeria'),konf::get()->getKonfigTab("grupy_konf",'galeria_kat'));	
				$galeria->setPoz(false);
				$galeria->setStatus(false);			
				$galeria->setStatusDomyslny(1);	
				$galeria->setSqlAdd($this->sqlAdd());				
				$rozmiary=$this->galeriaKonfig();
				
				$ok=$galeria->zapisz($this->_dane,false,$rozmiary,"galeria grupy - zapis zdjęcia","Galeria grupy - zapis zdjęcia");

			}	else {
				konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 		
			}
			
		}

		if(empty($ok)){
			konf::get()->setAkcja("grupygal_arch");				
		} else {
			if(konf::get()->getAkcja()=="grupygal_dodaj2"){
				konf::get()->setAkcja("grupygal_arch");					
			} else {
				konf::get()->setAkcja("grupygal_edytuj");					
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
	

	private function sqlAdd(){
	
		$sql=" AND id_matka='".$this->_id_grupa."'";
		if(!$this->admin()&&($this->_dane['autor_id']!=user::get()->id())){
			$sql.=" AND status=1";
		}
	
		return $sql;
	
	}
		

	private function sprAdmin($id_grupa){
	
		$ok=true;
		
		if(!$this->admin()&&!konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." WHERE id_u='".user::get()->id()."' AND id_grupa='".$id_grupa."' AND status=1")>0){
			$ok=false;		
		}
		
		return $ok;
	
	}

	
	private function galeriaKonfig(){
	
		$rozmiary=array();
		$rozmiary['galeria_min_size']=konf::get()->getKonfigTab("grupy_konf",'galeria_min_size');			
		$rozmiary['galeria_m_w']=konf::get()->getKonfigTab("grupy_konf",'galeria_m_size');	
		$rozmiary['galeria_m_h']=konf::get()->getKonfigTab("grupy_konf",'galeria_m_size');				
		$rozmiary['galeria_img_size']=konf::get()->getKonfigTab("grupy_konf",'galeria_img_size');
		$rozmiary['galeria_skala']=konf::get()->getKonfigTab("grupy_konf",'galeria_skalowanie');						
		
		return $rozmiary;		
	
	}		
	
	
  /**
   * galeria menu
   * @param array $dane
   */		
	public function galeriaMenu($dane){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$sortuj=konf::get()->getZmienna('sortuj','sortuj');		
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_grupa"=>$dane['id_matka'],"podstrona"=>$podstrona,"sortuj"=>$sortuj));

		echo "<table border=\"0\" style=\"margin-top:5px\"><tr>";    
    echo interfejs::edytuj($link."&amp;akcja=grupygal_edytuj&amp;id_nr=".$dane['id']);  
	  echo interfejs::przyciskEl("picture",$link."&amp;akcja=grupygal_zobacz&amp;id_nr=".$dane['id'],"zobacz zdjęcie"); 			
		echo interfejs::usun($link."&amp;akcja=grupygal_usun&amp;id_tab[1]=".$dane['id']);		
	  echo interfejs::przyciskEl("arrow_join",$link."&amp;akcja=grupygal_arch",konf::get()->langTexty("powrot")); 		
		echo "</tr></table>";  		
	
	}	
	
	
	/**
   * art akapity form
   */		
	public function zobacz(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$sortuj=konf::get()->getZmienna('sortuj','sortuj');		
	 	$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));
								
		if(!empty($this->_dane)&&!empty($id_nr)){
			$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_galeria')." WHERE id='".$id_nr."'".$this->sqlAdd());		
		}			

		if(!empty($dane)&&!empty($this->_dane)){

	    echo tab_nagl("Galeria zdjęć grupy ".$this->_dane['nazwa']);
			
		  echo "<tr><td valign=\"top\" class=\"tlo4 grube\">";

			require_once(konf::get()->getKonfigTab("klasy")."class.cofnijdalej.php");		
			$cofnijdalej=new cofnijdalej("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_galeria')." WHERE 1 ".$this->sqlAdd()." ORDE BY id DESC",$dane,"id","id");	
		  $cofnijdalej->setPrzenies(array("akcja"=>konf::get()->getAkcja(),"sortuj"=>$sortuj,"id_grupa"=>$this->_id_grupa));	
			$cofnijdalej->setZmienna("id_nr");
			$cofnijdalej->setPowrot("<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupygal_arch","id_grupa"=>$this->_id_grupa))."\">powrót</a>");
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
			
			echo "<tr class=\"srodek\"><td class=\"tlo4\">".interfejs::linkEl("folder_explore",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupygal_arch","id_grupa"=>$this->_id_grupa)),"Powrót do galerii")."</td></tr>";
	  	echo tab_stop();
			
	    if(konf::get()->isMod("koment")&&konf::get()->getKonfigTab("grupy_konf",'galeria_koment')){
				$konf=konf::get();
				require_once(konf::get()->getKonfigTab('mod_kat')."koment/class.koment.php");
				$koment=new koment(4);
				$koment->setPrzenies(array("id_nr"=>$dane['id'],"id_grupa"=>$this->_id_grupa));
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
		
		if(konf::get()->getKonfigTab("grupy_konf",'galeria_limit')&&konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_galeria')." WHERE autor_id='".$this->_id_grupa."'")>=konf::get()->getKonfigTab("grupy_konf",'galeria_limit')){
			$ok=false;
			konf::get()->setKomunikat("Przekroczony limit zdjęć w galerii. Aby dodać nowe zdjęcia należy usunąć część dotychczasowych zdjęć","error"); 				
		}
		
		return $ok;
	
	}
	
	
  /**
   * set grupa
   */
	public function setGrupa($id_grupa){
	
		$id_grupa=$id_grupa+0;
			
		if(!empty($id_grupa)){	
			
			if($this->admin()){		
				$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'grupy')." WHERE id='".$id_grupa."'");	
			} else {
				$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'grupy')." WHERE id='".$id_grupa."' AND ((autor_id='".user::get()->id()."' AND status!=0) OR status=1)");
			}
			
			if(!empty($dane)){
				$this->_id_grupa=$id_grupa;				
				$this->_dane=$dane;
			} else {
				$this->_id_grupa="";							
				$this->_dane=array();
			}
			
		} else {
			$this->_id_grupa="";							
			$this->_dane=array();		
		}
		
	}		
	
	
	/**
   * class constructor php5	
   */	
	public function __construct() {	
		
		$this->_admin=konf::get()->getKonfigTab("grupy_konf",'admin');		
		$id_grupa=tekstForm::doSql(konf::get()->getZmienna('id_grupa','id_grupa'));		
		
		if(!empty($id_grupa)){			
			$this->setGrupa($id_grupa);
		}	
		
  }	

		
}

?>