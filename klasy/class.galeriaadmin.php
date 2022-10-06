<?php

/**
 * galeriaadmin class v1.0
 * dla CMS i innych klas - elementy zarzadzania galeria zdjec.
 * All rights reserved
 * @package galeriaadmin class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2007 Waldemar Jonik
 */
		
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		
		
konf::get()->setTekstyTab("galeriaadmin_texty","2");
		
class galeriaadmin {

	/**
	 * Public variables
	 */

	/**
	 * Private variables
	 */
		
	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="galeriaadmin class";
	
	
	/**
	 * czy pozycja zdjecia
	 */				
  private $_poz=true;	
	
	
	/**
	 * punkty i licznik
	 */				
  private $_pt=true;			
	
	
	/**
	 * status
	 */				
  private $_status=true;		
	
	
	/**
	 * status
	 */				
  private $_statusDomyslny=1;					
	
	
	/**
	 * tabela sql
	 */				
  private $_tabela="";		
	
	
	/**
	 * dodatek sql
	 */				
  private $_sqlAdd="";			
		
  /**
   * zwraca nazwe klasy
   * @return string				
   */		
	public function getNazwaKlasy(){
	
		return $this->_nazwaKlasy;
		
	}		
	
	
  /**
   * Set tabela
   * @param string $tablea
   */
  public function setTabela($tabela) {
	
  	if(!empty($tabela)){
      $this->_tabela=$tabela;
		} else {
			trigger_error("setTabela: invalid table value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
		
  }			


	
  /**
   * Set poz
   * @param bool $poz
   */
  public function setPoz($poz) {
	
  	if(!empty($poz)){
      $this->_poz=true;
		} else {
      $this->_poz=false;
		}		
		
  }	
	
	
  /**
   * Set status
   * @param bool $pt
   */
  public function setPt($pt) {
	
  	if(!empty($pt)){
      $this->_pt=true;
		} else {
      $this->_pt=false;
		}		
		
  }			
				
	
  /**
   * Set status
   * @param bool $pt
   */
  public function setStatus($status) {
	
  	if(!empty($status)){
      $this->_status=true;
		} else {
      $this->_status=false;
		}		
		
  }	
	
  /**
   * Set status domyslny
   * @param bool $status
   */
  public function setStatusDomyslny($status) {
	
  	if(!empty($status)){
      $this->_statusDomyslny=1;
		} else {
      $this->_statusDomyslny=0;
		}		
		
  }					
		
		
  /**
   * Set sql add
   * @param string sql
   */
  public function setSqlAdd($sql) {
	
  	$this->_sqlAdd=$sql;
		
  }			
	
  /**
   * Set katalog
   * @param string $katalog
   */
  public function setKatalog($katalog) {
	
  	if(!empty($katalog)){
      $this->_katalog=$katalog;
		} else {
			trigger_error("setKatalog: invalid katalog value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
		
  }			
	

	/**
   * akapity poz
   */		
	public function poz(){

	  $typ=konf::get()->getZmienna('typ','typ');
	  $id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));	

		if(!empty($typ)&&!empty($id_nr)){			
		
		  $dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".$this->_tabela." WHERE id='".$id_nr."'");
		      	
		  if(!empty($dane)){
			
			  require_once(konf::get()->getKonfigTab("klasy")."class.zmienpoz.php");

				$poz=new zmienPoz($dane['id'],$typ,$this->_tabela);		
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
   * @param string $log	
   */		
	public function zmienparam($param,$wartosc,$log=""){

		$id_tab=konf::get()->getZmienna('id_tab','id_tab');
		$wartosc=tekstForm::doSql($wartosc);
		$query=tekstForm::tabQuery($id_tab);
		
		if(!empty($query)){
			konf::get()->_bazasql->zap("UPDATE ".$this->_tabela." SET ".$param."='".$wartosc."' WHERE id IN (".$query.")");
			user::get()->zapiszLog($log,user::get()->login());
			konf::get()->setKomunikat(konf::get()->langTexty("awykonana"),""); 
		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),""); 
		}

	}
	
	/**
   * zdjecia remove
   * @param string $log			
   */		
	public function usun($log=""){

		$id_tab=konf::get()->getZmienna('id_tab','id_tab');
		$query="";

		if(!empty($id_tab)&&is_array($id_tab)){
	  
		  $query=tekstForm::tabQuery($id_tab);
		  
		  if(!empty($query)){
	
				$zap=konf::get()->_bazasql->zap("SELECT * FROM ".$this->_tabela." WHERE id IN (".$query.")".$this->_sqlAdd);
				
				while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
					if(!empty($dane['img1_nazwa'])&&file_exists(konf::get()->getKonfigTab("serwer").$this->_katalog.$dane['img1_nazwa'])){
		  			unlink(konf::get()->getKonfigTab("serwer").$this->_katalog.$dane['img1_nazwa']); 
		  		}
					if(!empty($dane['img2_nazwa'])&&file_exists(konf::get()->getKonfigTab("serwer").$this->_katalog.$dane['img2_nazwa'])){
		  			unlink(konf::get()->getKonfigTab("serwer").$this->_katalog.$dane['img2_nazwa']); 
		  		}				
		  	}		
				
		  	konf::get()->_bazasql->freeResult($zap);	
				konf::get()->_bazasql->zap("DELETE FROM ".$this->_tabela." WHERE id IN (".$query.")".$this->_sqlAdd);	
				
				user::get()->zapiszLog($log);									
				
			} else {
				konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),""); 
			}
		
			konf::get()->setKomunikat(konf::get()->langTexty("usuwanie"),""); 					
			
		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),""); 
		}
		
	}
	
	

	/**
   * cut
   * @param string $nazwa			
   * @param string $log							
   */		
	public function wytnij($nazwa,$log=""){

	  //pobieramy dane
	  $id_tab=konf::get()->getZmienna('id_tab','id_tab');
	  
	  //czyscimy pamiec  
		konf::get()->zapiszSession($nazwa,"");	
		
		//jesli dane to zapisujemy
	  if(!empty($id_tab)&&is_array($id_tab)){
			konf::get()->zapiszSession($nazwa,$id_tab);	
	    konf::get()->setKomunikat($log,"");
	  } else { 
			konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),"error"); 
		} 
		
	}
	
	

	/**
   * paste
   * @param array $dane2	
   * @param string $nazwa		
   * @param string $log							
   */		
	public function wklej($dane2,$nazwa,$log=""){

		//dane do przeniesienia
	  $tab=tekstForm::doSql(konf::get()->getZmienna('','',$nazwa));
		
		//sprawdzamy czy sa dane
		if(!empty($tab)&&is_array($tab)&&!empty($dane2)){

	  	//gdy istnieje strona i jest w tej samej wersji jezykowej lub gdy istnieje dzial
			if(!empty($dane2)){

        //ustalamy nr porzadkowy - na koncu	    
        $dane=konf::get()->_bazasql->pobierzRekord("SELECT MAX(nr_poz) AS nr_poz FROM ".$this->_tabela." WHERE id_matka='".$dane2['id']."'");
        
        //zawsze o 1 wiekszy od najwiekszego
        if(!empty($dane)){
          $nr=$dane['nr_poz']+1;
        } else {
          $nr=1;
        }
        
        $j=0;

		    //iteracja po tablicy danych
        while(list($key,$val)=each($tab)){
          konf::get()->_bazasql->zap("UPDATE ".$this->_tabela." SET nr_poz=".$nr.", id_matka='".$dane2['id']."' WHERE id='".$val."'");
          $nr++;
          $j++;
        }
	        
	      //jesli wykonano to podstrony zmieniaja poziom
	      if($j>0){
				
	      	konf::get()->setKomunikat(konf::get()->langTexty("awykonana"),"");	
	      
	      }	else { 
					konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
				}
			}	else { 
				konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
			}
		} else { 
			konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),"error"); 
		}
		
		konf::get()->zapiszSession($nazwa,"");
	  
	}
	
	
	/**
   * gallery save
   */		
	public function obrot($dane2,$obrobka=true,$rozmiary="",$log=""){

		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));
		$typ=konf::get()->getZmienna('typ','typ');				
		$ok=false;
		
		//dane podstawowe z formularza
		$daneNieczysc=array();
		$dane=array();
		$testy=array();

		if($typ=="l"||$typ=="r"||$typ=="d"){
		
			//generator zapytania insert/update
			require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
			$sqldane=new sqlZapis($this->_tabela,$dane,$daneNieczysc);
			$sqldane->daneOdczyt();	
			$sqldane->setAutor(true);	
			$sqldane->setTesty($testy);	

			if(!empty($id_nr)){
		    //pobranie aktualne dane   
			  $dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".$this->_tabela." WHERE id='".$id_nr."'");
			  
			  if(empty($dane)){
			  	$id_nr="";
			  } 
				
			}

			if(!empty($dane)&&!empty($dane['img1_nazwa'])){   
			
				//dodaj dane do zapytania
			 	$sqldane->setDane(array(
			 		"id_matka"=>$dane['id_matka']
				));				
																
				$sqldane->dodajDaneE();	
					
				require_once(konf::get()->getKonfigTab('klasy')."class.zapiszgrafike.php");
					
				$grafika=new zapiszGrafike($id_nr,$this->_katalog,"pic","img",$dane);
				$grafika->setWszystkie(true);
				
				if($typ=="l"){
					$obrot=90;
				} else if ($typ=="d"){
					$obrot=180;
				} else {
					$obrot=270;
				}

				//dla dalszej obrobki zdjecie moze miec wieksze wymiary
				if($dane['obrobka']&&$obrobka){
					$grafika->setDaneImg(1,array(
						"hmax"=>$rozmiary['galeria_o_size'],
						"wmax"=>$rozmiary['galeria_o_size'],						
						"hmin"=>$rozmiary['galeria_min_size'],
						"wmin"=>$rozmiary['galeria_min_size'],
						"typy"=>array(2=>2),
						"skala"=>3,
						"obrot"=>$obrot,											
					));					
				} else {
					$grafika->setDaneImg(1,array(
						"hmax"=>$rozmiary['galeria_img_size'],
						"wmax"=>$rozmiary['galeria_img_size'],
						"hmin"=>$rozmiary['galeria_min_size'],
						"wmin"=>$rozmiary['galeria_min_size'],
						"typy"=>array(2=>2),
						"skala"=>3,
						"obrot"=>$obrot									
					));
				}
					
				//w przypadku zdjecia do obrobki, gdy zmian na zwykle zdjecie i zdjecie istnieje to mozemy przeskalowac z automatu zdjecie juz wczesniej zapisane
				$grafika->setPlikzrodlowy(konf::get()->getKonfigTab("serwer").$this->_katalog.$dane['img1_nazwa']);		
						
				$grafika->setDaneImg(2,array(
					"hmax"=>$rozmiary['galeria_m_h'],
					"wmax"=>$rozmiary['galeria_m_w'],
					"hmin"=>$rozmiary['galeria_min_size'],
					"wmin"=>$rozmiary['galeria_min_size'],
					"typy"=>array(2=>2),
					"skala"=>$rozmiary['galeria_skala']					
				));			

				$grafika->wykonaj();
					
				if(!empty($grafika->_typ)){
				
					if($grafika->getSql()){			
						$sqldane->dodaj(", ".$grafika->getSql());				
					}

					$sqldane->dodaj(" WHERE id='".$id_nr."'");	
									
					if($sqldane->getSql()){
						konf::get()->_bazasql->zap($sqldane->getSql());		 				
			  	  user::get()->zapiszLog($log." ".$dane['id'],user::get()->login());
					}
				} else {
					konf::get()->_bazasql->zap("DELETE FROM ".$this->_tabela." WHERE id='".$id_nr."'");				
					$id_nr="";					
				}

		    if(!empty($id_nr)){
		    	konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");
					$ok=true;
		    } else { 
					konf::get()->setKomunikat(konf::get()->langTexty("niezapisane"),"error"); 
				} 
				
			} else { 
				konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
			}
		
		} else { 
			konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
		}		
		
		return $ok;
		
	}		

	
	/**
   * gallery save
   */		
	public function konfigedytuj2($dane2,$obrobka=true,$rozmiary="",$log=""){

		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr'));
		$ok=false;
		
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
		$sqldane=new sqlZapis($this->_tabela,$dane,$daneNieczysc);
		$sqldane->daneOdczyt();	
		$sqldane->setAutor(true);	
		$sqldane->setTesty($testy);	

		if(!empty($id_nr)){
	    //pobranie aktualne dane   
		  $dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".$this->_tabela." WHERE id='".$id_nr."'");
		  
		  if(empty($dane)){
		  	$id_nr="";
		  } 
			
		}
		

		if(!empty($dane2)&&!empty($dane)&&!empty($dane['img1_nazwa'])){   
			
			$sqldane->dodajDaneE();	
				
			require_once(konf::get()->getKonfigTab('klasy')."class.zapiszgrafike.php");
				
			$grafika=new zapiszGrafike($id_nr,$this->_katalog,"pic","img",$dane);
			$grafika->setWszystkie(true);

			//dla dalszej obrobki zdjecie moze miec wieksze wymiary
			if($sqldane->getDane('obrobka')&&$obrobka){
				$grafika->setDaneImg(1,array(
					"hmax"=>$rozmiary['galeria_o_size'],
					"wmax"=>$rozmiary['galeria_o_size'],
					"hmin"=>$rozmiary['galeria_min_size'],
					"wmin"=>$rozmiary['galeria_min_size'],
					"typy"=>array(2=>2),
					"skala"=>3,
					"x1"=>$x1,
					"x2"=>$x2,
					"y1"=>$y1,
					"y2"=>$y2														
				));					
			} else {
				$grafika->setDaneImg(1,array(
					"hmax"=>$rozmiary['galeria_img_size'],
					"wmax"=>$rozmiary['galeria_img_size'],
					"hmin"=>$rozmiary['galeria_min_size'],
					"wmin"=>$rozmiary['galeria_min_size'],
					"typy"=>array(2=>2),
					"skala"=>3,
					"x1"=>$x1,
					"x2"=>$x2,
					"y1"=>$y1,
					"y2"=>$y2												
				));
			}
				
			//w przypadku zdjecia do obrobki, gdy zmian na zwykle zdjecie i zdjecie istnieje to mozemy przeskalowac z automatu zdjecie juzwczesniej zapisane
			$grafika->setPlikzrodlowy(konf::get()->getKonfigTab("serwer").$this->_katalog.$dane['img1_nazwa']);		
					
			$grafika->setDaneImg(2,array(
				"hmax"=>$rozmiary['galeria_m_h'],
				"wmax"=>$rozmiary['galeria_m_w'],
				"hmin"=>$rozmiary['galeria_min_size'],
				"wmin"=>$rozmiary['galeria_min_size'],
				"typy"=>array(2=>2),
				"skala"=>$rozmiary['galeria_skala']				
			));			

			$grafika->wykonaj();
				
			if(!empty($grafika->_typ)){
			
				if($grafika->getSql()){			
					$sqldane->dodaj(", ".$grafika->getSql());				
				}

				$sqldane->dodaj(" WHERE id='".$id_nr."'");	
								
				if($sqldane->getSql()){
					konf::get()->_bazasql->zap($sqldane->getSql());		 				
		  	  user::get()->zapiszLog($log." ".$dane['id'],user::get()->login());
				}
				
			} else {
				konf::get()->_bazasql->zap("DELETE FROM ".$this->_tabela." WHERE id='".$id_nr."'");				
				$id_nr="";					
			}

	    if(!empty($id_nr)){
	    	konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");
	  		$ok=true;
	    } else { 
				konf::get()->setKomunikat(konf::get()->langTexty("niezapisane"),"error"); 
			} 
			
		} else { 
			konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
		}
		
		return $ok;
		
	}	
	
	
	/**
   * gallery save
   */		
	public function zapisz($dane2,$obrobka=true,$rozmiary="",$log="",$log2=""){

		$id_nad=tekstForm::doSql(konf::get()->getZmienna('id_nad'));	
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr'));
		$ok=false;
		
		//dane podstawowe z formularza
		$dane=array(
			"opis"=>"",
			"tytul"=>"",				
			"obrobka"	=>"",					
		);	
		
		$daneNieczysc[]=array();
		$testy[]=array("zmienna"=>"obrobka","test"=>"truefalse");
		
		if($this->_pt){
		
			$dane['licznik']="";
			$dane['punkty_ilosc']="";
			$dane['punkty_srednia']="";			
			$dane['punkty_suma']="";			
			
			$testy[]=array("zmienna"=>"licznik","test"=>"liczba",
				"param"=>array(
					"domyslny"=>0,
					"min"=>0					
				)
			);				
			
			$testy[]=array("zmienna"=>"punkty_ilosc","test"=>"liczba",
				"param"=>array(
					"domyslny"=>0,
					"min"=>0					
				)
			);	
			
			$testy[]=array("zmienna"=>"punkty_srednia","test"=>"liczba",
				"param"=>array(
					"po_przecinku"=>2,			
					"domyslny"=>0,
					"min"=>0					
				)
			);							
			
			$testy[]=array("zmienna"=>"punkty_suma","test"=>"liczba",
				"param"=>array(
					"domyslny"=>0,
					"min"=>0					
				)
			);		
			
		}	
		
		
		if($this->_status){				
		
			$dane['status']="";
			$testy[]=array("zmienna"=>"status","test"=>"truefalse");		
		
		}
			

		//generator zapytania insert/update
		require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
		$sqldane=new sqlZapis($this->_tabela,$dane,$daneNieczysc);
		$sqldane->daneOdczyt();	
		$sqldane->setAutor(true);	
		$sqldane->setTesty($testy);	

		if(!empty($id_nr)){
	    //pobranie aktualne dane   
		  $dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".$this->_tabela." WHERE id='".$id_nr."'".$this->_sqlAdd);
		  
		  if(empty($dane)){
		  	$id_nr="";
		  } 
			
		}

		if(!empty($dane2)){
						
			//dodanie 
			if(empty($id_nr)){
			
				if($this->_poz){
					//numer porzadkowy					
					$sqldane->setMatka($dane2['id']);	
					$sqldane->setNad($id_nad);					
					$sqldane->setPoleMatka("id_matka");				
					$sqldane->setPoleId("id");
					$sqldane->setPolePoz("nr_poz");				
					$sqldane->dodajPoz();			
				}
				
				if(!$this->_status&&$this->_statusDomyslny){				
				
				 	$sqldane->setDane(array(				
						"status"=>$this->_statusDomyslny
					));						
					
				}					
				
				//dodaj dane zo zapytania
			 	$sqldane->setDane(array(
			 		"id_matka"=>$dane2['id']
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
					
					if($this->_poz){											
						$sqldane->ustawPoz();
					}

					require_once(konf::get()->getKonfigTab('klasy')."class.zapiszgrafike.php");
					
					$grafika=new zapiszGrafike($id_nr,$this->_katalog,"pic","img");
					$grafika->setWszystkie(true);
					$grafika->setImgUsun(false);
					
					//dla dalszej obrobki zdjecie moze miec wieksze wymiary					
					if($sqldane->getDane('obrobka')&&$obrobka){
						$grafika->setDaneImg(1,array(
							"hmax"=>$rozmiary['galeria_o_size'],
							"wmax"=>$rozmiary['galeria_o_size'],
							"hmin"=>$rozmiary['galeria_min_size'],
							"wmin"=>$rozmiary['galeria_min_size'],
							"typy"=>array(2=>2),
							"skala"=>3					
						));					
					} else {
						$grafika->setDaneImg(1,array(
							"hmax"=>$rozmiary['galeria_img_size'],
							"wmax"=>$rozmiary['galeria_img_size'],
							"hmin"=>$rozmiary['galeria_min_size'],
							"wmin"=>$rozmiary['galeria_min_size'],
							"typy"=>array(2=>2),
							"skala"=>3					
						));
					}
					
					$grafika->setDaneImg(2,array(
						"hmax"=>$rozmiary['galeria_m_h'],
						"wmax"=>$rozmiary['galeria_m_w'],
						"hmin"=>$rozmiary['galeria_min_size'],
						"wmin"=>$rozmiary['galeria_min_size'],
						"typy"=>array(2=>2),
						"skala"=>$rozmiary['galeria_skala']					
					));		

					$grafika->wykonaj();
					
					if($grafika->getSql()&&$grafika->_typ){					
						konf::get()->_bazasql->zap("UPDATE ".$this->_tabela." SET ".$grafika->getSql()." WHERE id='".$id_nr."'");	
					}	else {
						konf::get()->_bazasql->zap("DELETE FROM ".$this->_tabela." WHERE id='".$id_nr."'");				
						$id_nr="";				
					}
		
	  	  	user::get()->zapiszLog($log,user::get()->login());
					
	    	}	
	    //edycja
	    } else {    
			
				$sqldane->dodajDaneE();	
				
				require_once(konf::get()->getKonfigTab('klasy')."class.zapiszgrafike.php");
				
				$grafika=new zapiszGrafike($id_nr,$this->_katalog,"pic","img",$dane2);
				$grafika->setWszystkie(true);

				if($sqldane->getDane('obrobka')&&$obrobka){
					$grafika->setDaneImg(1,array(
						"hmax"=>$rozmiary['galeria_o_size'],
						"wmax"=>$rozmiary['galeria_o_size'],
						"hmin"=>$rozmiary['galeria_min_size'],
						"wmin"=>$rozmiary['galeria_min_size'],
						"typy"=>array(2=>2),
						"skala"=>3					
					));					
				} else {
					$grafika->setDaneImg(1,array(
						"hmax"=>$rozmiary['galeria_img_size'],
						"wmax"=>$rozmiary['galeria_img_size'],
						"hmin"=>$rozmiary['galeria_min_size'],
						"wmin"=>$rozmiary['galeria_min_size'],
						"typy"=>array(2=>2),
						"skala"=>3					
					));
				}				
				
				//w przypadku zdjecia do obrobki, gdy zmian na zwykle zdjecie i zdjecie istnieje to mozemy przeskalowac z automatu zdjecie juz wczesniej zapisane
				if($obrobka&&!empty($dane['obrobka'])&&!$sqldane->getDane('obrobka')&&!empty($dane['img1_nazwa'])){
					$grafika->setPlikzrodlowy(konf::get()->getKonfigTab("serwer").$this->_katalog.$dane['img1_nazwa']);		
				}
					
				$grafika->setDaneImg(2,array(
					"hmax"=>$rozmiary['galeria_m_h'],
					"wmax"=>$rozmiary['galeria_m_w'],
					"hmin"=>$rozmiary['galeria_min_size'],
					"wmin"=>$rozmiary['galeria_min_size'],
					"typy"=>array(2=>2),
					"skala"=>$rozmiary['galeria_skala']				
				));		

				$grafika->wykonaj();
				
				if((!$grafika->_typ&&!$grafika->_imgUsun)||!empty($grafika->_typ)){
				
					if($grafika->getSql()){			
						$sqldane->dodaj(", ".$grafika->getSql());				
					}

					$sqldane->dodaj(" WHERE id='".$id_nr."'");	
									
					if($sqldane->getSql()){
						konf::get()->_bazasql->zap($sqldane->getSql());		 				
			  	  user::get()->zapiszLog($log2,user::get()->login());
					}
					
				} else {
					konf::get()->_bazasql->zap("DELETE FROM ".$this->_tabela." WHERE id='".$id_nr."'".$this->_sqlAdd);				
					$id_nr="";					
				}

	  	}        
	  	
	    if(!empty($id_nr)){
	    	konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");
				$ok=true;
	    } else { 
				konf::get()->setKomunikat(konf::get()->langTexty("niezapisane"),"error"); 
			} 
			
		} else { 
			konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
		}

		konf::get()->setZmienna("_post","id_nr",$id_nr);	
		
		return $ok;
		
	}	

		
	public function konfigedytuj($dane,$dane2,$przenies="",$obrobka=true,$linkobrot=""){
	
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');		
	 	$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));			

		if(!empty($dane2)&&!empty($dane)){	
		
			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"gal","gal");			
			
			$przenies['id_nr']=$id_nr;
			$przenies['podstrona']=$podstrona;			
			$przenies['akcja']=konf::get()->getAkcja()."2";			
						
			echo $form->getFormp();
			echo $form->przenies($przenies);							
	
			konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/prototype.js","js");	
			konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/scriptaculous/scriptaculous.js?load=effects,builder,dragdrop","js");				
			konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/cropper/cropper.js","js");				

			if(function_exists("imagerotate")){
			
				$linkobrot.="&amp;id_nr=".$id_nr;
				
				echo "<table border=\"0\" style=\"margin-top:5px\" class=\"srodek\">";
				
				echo "<tr>";    
		    echo interfejs::przyciskEl("arrow_turn_left",$linkobrot."&amp;typ=l",konf::get()->langTexty("art_admin_galf_obr90")); 	
				echo "<td class=\"lewa\">".konf::get()->langTexty("art_admin_galf_obr90w")."</td>";			
				echo "</tr>";
				
				echo "<tr>";  								
		    echo interfejs::przyciskEl("arrow_turn_right",$linkobrot."&amp;typ=r",konf::get()->langTexty("art_admin_galf_obr90n")); 	
				echo "<td class=\"lewa\">".konf::get()->langTexty("art_admin_galf_obr90nw")."</td>";								
				echo "</tr>";
				
				echo "<tr>";    
		    echo interfejs::przyciskEl("arrow_undo",$linkobrot."&amp;typ=d",konf::get()->langTexty("art_admin_galf_obr180")); 	
				echo "<td class=\"lewa\">".konf::get()->langTexty("art_admin_galf_obr180w")."</td>";					
				echo "</tr>";
				
				echo "</table>";  				
					
				
			}	
			
			echo "<div class=\"srodek grube\" style=\"padding:7px\">";
			echo konf::get()->langTexty("art_admin_galf_zaznacz");
			echo interfejs::pomocEl(konf::get()->langTexty("art_admin_galf_zaznaczh"));		
			echo "</div>";

			if(!empty($dane['img1_nazwa'])&&file_exists(konf::get()->getKonfigTab("serwer").$this->_katalog.$dane['img1_nazwa'])){
  			echo "<div class=\"srodek\" style=\"width:".$dane['img1_w']."px\"><img id=\"obrazekcrop\" src=\"".konf::get()->getKonfigTab("sciezka").$this->_katalog.$dane['img1_nazwa']."\" width=\"".$dane['img1_w']."\" height=\"".$dane['img1_h']."\" alt=\"\" /></div>"; 
  		}						

			echo "<div class=\"srodek\" style=\"width:70%; padding-top:10px\">";
			echo tab_nagl(konf::get()->langTexty("art_admin_galf_oparametry"),6);
			?>
			
			<tr>
			
				<td class="tlo3"><?php echo interfejs::label("x1",konf::get()->langTexty("art_admin_galf_opolozenie")." x1:"); ?></td>
				<td class="tlo3">
				<?php
				echo $form->input("text","x1","x1",0,"f_krotki",6," onfocus=\"this.blur();\"");		
				?>
				</td>
				
				<td class="tlo3"><?php echo interfejs::label("x2",konf::get()->langTexty("art_admin_galf_opolozenie")." x2:"); ?></td>
				<td class="tlo3">
				<?php
				echo $form->input("text","x2","x2",0,"f_krotki",6," onfocus=\"this.blur();\"");		
				?>
				</td>				
				<td class="tlo3"><?php echo interfejs::label("dl",konf::get()->langTexty("art_admin_galf_oszerokosc")); ?></td>
				<td class="tlo3">
				<?php
				echo $form->input("text","dl","dl",0,"f_krotki",6," onfocus=\"this.blur();\"");		
				?>
				</td>			
				
			</tr>
		
			<tr>
			
				<td class="tlo3"><?php echo interfejs::label("y1",konf::get()->langTexty("art_admin_galf_opolozenie")." y1:"); ?></td>
				<td class="tlo3">
				<?php
				echo $form->input("text","y1","y1",0,"f_krotki",6," onfocus=\"this.blur();\"");		
				?>
				</td>
				
				<td class="tlo3"><?php echo interfejs::label("y2",konf::get()->langTexty("art_admin_galf_opolozenie")." y2:"); ?></td>
				<td class="tlo3">
				<?php
				echo $form->input("text","y2","y2",0,"f_krotki",6," onfocus=\"this.blur();\"");		
				?>
				</td>			
				
				<td class="tlo3"><?php echo interfejs::label("dh",konf::get()->langTexty("art_admin_galf_owysokosc")); ?></td>				
				<td class="tlo3">
				<?php
				echo $form->input("text","dh","dh",0,"f_krotki",6," onfocus=\"this.blur();\"");		
				?>
				</td>			
				
			</tr>		
			
			<tr><td colspan="6" class="tlo4">
			<?php
			echo $form->input("button","","",konf::get()->langTexty("art_admin_galf_oresetuj"),"formularz2 f_sredni",''," onclick=\"resetuj();\"");						
			?>
			</td></tr>
		
			<?php
			
			echo tab_stop();
			echo "</div>";

	    if($obrobka&&!empty($dane['obrobka'])){
		    echo "<div>";
				echo $form->checkbox("obrobka","obrobka",1,$dane['obrobka']);	
				echo interfejs::label("obrobka",konf::get()->langTexty("artadmin_galf_obrobka"),"nobr",true);				
				echo interfejs::pomocEl(konf::get()->langTexty("admin_galf_obrobkah"));							
				echo "</div><br />";
	    }												
			
			echo "<div class=\"srodek\">";
			echo $form->input("submit","","",konf::get()->langTexty("art_admin_galf_okadruj"),"formularz2 f_dlugi");		
			echo "</div>";

			echo "<br /><br />";
			echo "<div class=\"male\">".konf::get()->langTexty("art_admin_galf_owielokrotne")."</div>";
			echo "<div class=\"male\">".konf::get()->langTexty("art_admin_galf_owszystkie")."</div>";			
			
			echo $form->getFormk();
			
	  } else {
			echo interfejs::nieprawidlowe();	
	  }
	
	}
	
	/**
   * form
   */		
	public function formularz($dane="",$przenies="",$opis=true,$licznik=true,$punkty=true,$obrobka=true){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
	 	$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));
		$id_nad=tekstForm::doSql(konf::get()->getZmienna('id_nad','id_nad'));

		//domyslne wartosci
		
		if(empty($dane)){
		
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
			
			$id_nr="";
			
		}

		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"art","art");	

		$form->setMultipart(true);	
			
		if(empty($id_nr)){
			echo $form->spr(array(1=>"akcja",2=>"pic"));			
		} else {
			echo $form->spr(array(1=>"akcja"));
		}
		
		$przenies['id_nr']=$id_nr;
		$przenies['akcja']=konf::get()->getAkcja()."2";
		$przenies['id_nad']=$id_nad;
		$przenies['podstrona']=$podstrona;
										
		echo $form->getFormp();
		echo $form->przenies($przenies);			
		
		if(!empty($dane['img'])&&!empty($dane['img1_nazwa'])){
			echo interfejs::imgPodglad($dane,"img",$this->_katalog,1);	
	 	}

		echo "<div class=\"grube\">".konf::get()->langTexty("art_admin_aform_gjpg")."*</div>";							
		echo $form->input("file","pic","pic","","f_bdlugi");				
		echo "<br /><br />";				
								
 	  echo "<span class=\"grube\">".konf::get()->langTexty("artadmin_galf_tytul")."</span>";
		echo "<br />";
		echo $form->input("text","tytul","tytul",$dane['tytul'],"f_bdlugi",250);		
	  echo "<br /><br />";				
			
    if($opis){

		  echo "<div class=\"grube\">".konf::get()->langTexty("artadmin_galf_opis")."</div>";				
			echo $form->textarea("opis","opis",$dane['opis'],"f_bdlugi",12);
	    echo "<br /><br />";	
				
		}
			
			
		if($this->_pt){
			
	    if($licznik){
				echo $form->input("text","licznik","licznik",$dane['licznik'],"f_krotki",10);				
				echo " ".konf::get()->langTexty("artadmin_galf_licznik")."<br />";
	    }			
						
	    if($punkty){
			
	      echo "<br />";
				echo $form->input("text","punkty","punkty",$dane['punkty'],"f_krotki",10);				
				echo " ".konf::get()->langTexty("artadmin_galf_suma")."<br />";
				
	      echo "<br />";
				echo $form->input("text","ilosc_glosow","ilosc_glosow",$dane['ilosc_glosow'],"f_krotki",10);				
				echo " ".konf::get()->langTexty("artadmin_galf_ilosc")."<br />";			
					
	    }		
			
		}	
		
    if($obrobka){
	    echo "<br /><span class=\"nobr\">";
			echo $form->checkbox("obrobka","obrobka",1,$dane['obrobka']);	
	   	echo " <label for=\"obrobka\">".konf::get()->langTexty("artadmin_galf_obrobka")."</label>";
			echo interfejs::pomocEl(konf::get()->langTexty("admin_galf_obrobkah"));							
			echo "</span><br />";
    }												
		
		if($this->_status){
	    echo "<br /><span class=\"nobr\">";
			echo $form->checkbox("status","status",1,$dane['status']);	
	   	echo " <label for=\"status\">".konf::get()->langTexty("widoczny")."</label></span><br />";
	  }
		
  	echo "<br />";
		echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");		
		echo "<br />";
		echo "<div class=\"male\">".konf::get()->langTexty("musza")."</div>";
		
		echo $form->getFormk();
	
	}
		
	/**
   * class konstructor php5	
   * @param string $tabela		 	
   */	
	public function __construct($tabela,$katalog) {	

		$this->setTabela($tabela);	
		$this->setKatalog($katalog);	
				
  }	
	
}