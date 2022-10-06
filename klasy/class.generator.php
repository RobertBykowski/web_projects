<?php

/**
 * Konfig class v1.0
 * dla CMS i innych klas - tworzenie formularzy
 * @package konfig class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2006 Waldemar Jonik
 */

	
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		


class generator2 {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="Generator class";
	
	
	/**
	 * zakonczono akcje
	 */				
  private $_akcjaKoniec=false;			
	
	
	/**
	 * wyswietlono naglowek szablonu
	 */				
  private $_akcjaNaglowek=false;	
			
	
	/**
	 * wyswietlono stopke szablonu
	 */				
  private $_akcjaStopka=false;		
	
	
	/**
	 * wyswietlono stopke szablonu
	 */				
  private $_akcjaDostep=true;			
	

	/**
	 * lista akcji
	 */				
  private $_akcjeTab=array();			
	
	/**
	 * akcje konfig tab
	 */				
  private $_akcjeKonfigTab=array();				
	
	
	/**
	 * akcje obiekty tab
	 */				
  private $_akcjeObiektyTab=array();			
	
	
	/**
	 * moduly tab
	 */				
  private $_modulyTab=array();				
	
	
	/**
	 * domyslne parametry akcji
	 */		
	private $_akcjaDomyslna=array( 	
		"dostep"=>true,						//dostep do akcji
		"akcja_brakdostepu"=>"",	//akcja w przypadku braku dostepu		
		"nowy_obiekt"=>false,			//czy tworzyc nowy obiekt jesli juz istnieje
		"akcja_naglowek"=>false,	//czy rysowac naglowek
		"akcja_stopka"=>false,		//czy rysowac stopke
		"szablon"=>"",						//szablon
		"akcja_koniec"=>true,			//koniec ciagu akcji
		"akcja_nastepna"=>"",			//jaka akcja nastepna (jesli puste to domyslna akcja)	
	);
	
  /**
   * zwraca nazwe klasy
   * @return string				
   */		
	public function getNazwaKlasy(){
	
		return $this->_nazwaKlasy;
		
	}		

	
  /**
   * Set akcje tab
   * @param string $akcja
   */
	public function setAkcjeTab($akcja){
		
		if(!empty($akcja)){
			$this->_akcjeTab[]=$akcja;
		}

	}
	
	
  /**
   * Set akcje konfig tab
   * @param array $akcje
   */
  public function setAkcjeKonfigTab($akcje) {
  	if(!empty($akcje)){
			if(is_array($akcje)){
	      $this->_akcjeKonfigTab=array_merge($this->_akcjeKonfigTab,$akcje);
			} else {
				trigger_error("setAkcjeKonfigTab: invalid konfig value ".$this->getNazwaKlasy(),E_USER_ERROR);
			}
		}		
		
  }			
	
	
  /**
   * Set akcje obiekty tab
   * @param string $nazwa
   * @param obj $obiekt
   */
	public function setAkcjeObiektyTab($nazwa,&$obiekt){
	
		if(!empty($nazwa)&&!empty($obiekt)&&is_object($obiekt)){
			$this->_akcjeObiektyTab[$nazwa]=$obiekt;
		} else {
			trigger_error("setAkcjeObiektyTab: invalid obiekt value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}

	}		
	
	
  /**
   * wczytuje domyslne moduly
   */	
	private function domyslne(){

		$domyslne=konf::get()->getKonfigTab("mod_domyslne");
	
		if(!empty($domyslne)&&is_array($domyslne)){
		
			while(list($key,$modul)=each($domyslne)){
	
				//prawidlowo odczytano obiekt i metode, modul istnieje
				if(konf::get()->isMod($modul)){

					//ten modul jeszcze nie byl wczytany
					if(!in_array($modul,$this->_modulyTab)){
					
						//konfiguracja
				 		$plik=konf::get()->getKonfigTab("mod_kat").$modul."/konfig_inc.php";	

				  	if(!empty($plik)&&is_file($plik)){	
							include_once($plik);		
						}	

						//plik akcji
				 		$plik=konf::get()->getKonfigTab("mod_kat").$modul."/akcje_inc.php";	
					
				  	if(!empty($plik)&&is_file($plik)){	
						
							include_once($plik);		
							
							if(isset($akcje_tab)){
								$this->setAkcjeKonfigTab($akcje_tab);
							}
							
						}							
						
						//include pliku klasy
				 		$plik=konf::get()->getKonfigTab("mod_kat").$modul."/class.".$modul.".php";	
					
				  	if(!empty($plik)&&is_file($plik)){	
						
							require_once($plik);	
							
						}			
						
						$this->_modulyTab[]=$modul;
						
					}

				}	
				
			}
			
		}
	
	}
			

		
  /**
   * do actions
   */
	public function akcje(){
			
		$akcja=konf::get()->getAkcja();		
		$modul="";
		$metoda="";
		$komunikat="";
		
		$start=tekstForm::microtimeOblicz();
		
		//konfiguracja bierzacej akcji
		$akcja_dane=$this->_akcjaDomyslna;

		$this->setAkcjeTab($akcja);

		//rozbijamy akcje aby wyciagnac modul i metode
		if(!empty($akcja)){
		
			$akcja_rozbij=array();
			preg_match ("/^([A-Za-z0-9]+)_([A-Za-z0-9]+)$/",$akcja,$akcja_rozbij);
			
			//modul
			if(isset($akcja_rozbij[1])){
				$modul=$akcja_rozbij[1];
			} else {
				$modul="";
			}
			
			//metoda
			if(isset($akcja_rozbij[2])){			
				$metoda=$akcja_rozbij[2];			
			} else {
				$metoda="";
			}

		} else {
			$komunikat="akcjelista_brakakcji";
		}

		//prawidlowo odczytano obiekt i metode, modul istnieje
		if(!empty($modul)&&!empty($metoda)&&konf::get()->isMod($modul)){
		
			//ten modul jeszcze nie byl wczytany
			if(!in_array($modul,$this->_modulyTab)){
			
				//konfiguracja
		 		$plik=konf::get()->getKonfigTab("mod_kat").$modul."/konfig_inc.php";	

		  	if(!empty($plik)&&is_file($plik)){	
					include_once($plik);		
				}	

				//plik akcji
		 		$plik=konf::get()->getKonfigTab("mod_kat").$modul."/akcje_inc.php";	
			
		  	if(!empty($plik)&&is_file($plik)){	
				
					include_once($plik);		
					
					if(isset($akcje_tab)){
						$this->setAkcjeKonfigTab($akcje_tab);
					}
					
				}							
				
				$this->_modulyTab[]=$modul;

			}
			
			//odczytanie konfiguracji bierzacej akcji
			if(isset($this->_akcjeKonfigTab[$akcja])){

				$akcja_dane=array_merge($akcja_dane,$this->_akcjeKonfigTab[$akcja]);
			
				//czy dostepna akcja
				if(!empty($akcja_dane['dostep'])){	
								
					//include pliku klasy
			 		$plik=konf::get()->getKonfigTab("mod_kat").$modul."/class.".$modul.".php";	
				
			  	if(!empty($plik)&&is_file($plik)){	
					
						require_once($plik);	
						
					}	else {
						$komunikat="akcjelista_brakplikuklasy";	
					}						
				
					//szablon
					if($akcja_dane['szablon']){
						konf::get()->setSzablon($akcja_dane['szablon']);
					} else if(konf::get()->getKonfigTab('szablon_domyslny')){
						konf::get()->setSzablon(konf::get()->getKonfigTab('szablon_domyslny'));								
					}

					//wyswietl naglowek
					if(!$this->_akcjaNaglowek&&$akcja_dane['akcja_naglowek']){
					
						$this->_akcjaNaglowek=true;

						$plik=konf::get()->getKonfigTab("szablony_kat").konf::get()->getSzablon()."_inc.php";	
						
				  	if(!empty($plik)&&is_file($plik)){	
						
							include_once($plik);	
							
							if(function_exists('glowa')){
								glowa();
							}
							
						}
						
					}

					//sprawdzamy czy klasa istnieje
					if(class_exists($modul)){

						//czy nowy obiekt
						if($akcja_dane['nowy_obiekt']||empty($this->_akcjeObiektyTab[$modul])){
							$obiekt=new $modul();
							$this->setAkcjeObiektyTab($modul,$obiekt);
						}

						//czy istnieje obiekt
						if(!empty($this->_akcjeObiektyTab[$modul])&&is_object($this->_akcjeObiektyTab[$modul])){

							//sprawdzamy czy metoda istnieje i czy jest dostepna
							if(method_exists($this->_akcjeObiektyTab[$modul],$metoda)&&in_array($metoda,get_class_methods($this->_akcjeObiektyTab[$modul]))) {

								$this->_akcjeObiektyTab[$modul]->$metoda();
								
							} else {
								konf::get()->setAkcja("");			
								$komunikat="akcjelista_niedostepnametoda";										
							}
							
						} else {
							konf::get()->setAkcja("");			
							$komunikat="akcjelista_brakobiektu";									
						}

					} else {
						konf::get()->setAkcja("");		
						$komunikat="akcjelista_brakklasy";								
					}
							
					//czy nastepna akcja
					if(!empty($akcja_dane['akcja_nastepna'])){
						konf::get()->setAkcja($akcja_dane['akcja_nastepna']);			
					}
					
					//czy to koncowa akcja
					if(!empty($akcja_dane['akcja_koniec'])){
						$this->_akcjaKoniec=true;
					}		
					
					konf::get()->setAkcjeTab($modul,$metoda,$start,tekstForm::microtimeOblicz(),$komunikat);						
					$komunikat="";
					
					//rysuje stopke dokumentu
					if(!$this->_akcjaStopka&&$akcja_dane['akcja_stopka']){
					
						$this->_akcjaStopka=true;

						if(function_exists('stopka')){
							stopka();
						}
						
					}						

				} else {
				
					$komunikat="akcjelista_brakdostepu";					
				
					//akcja braku dostepu
					if(!empty($akcja_dane['akcja_brakdostepu'])){						
						konf::get()->setAkcja($akcja_dane['akcja_brakdostepu']);						
					} else {
						konf::get()->setAkcja("");
					}
					
				}
				
			} else {
				konf::get()->setAkcja("");			
				$komunikat="akcjelista_brakkonfiguracji";				
			}

		} else {
		
			konf::get()->setAkcja("");
			
			if(!empty($akcja)){
			
				if(empty($modul)){
					$komunikat="akcjelista_brakmodulu";
				} else if(empty($metoda)){
					$komunikat="akcjelista_brakmetody";				
				} else {
					$komunikat="akcjelista_modulniedostepny";							
				}
			
			}

		}
				
		if($komunikat){
			//notuje informacje
			konf::get()->setAkcjeTab($modul,$metoda,$start,tekstForm::microtimeOblicz(),$komunikat);
		}
				
		//przy braku akcji
		if(!$this->_akcjaKoniec&&(!konf::get()->getAkcja()||$akcja==konf::get()->getAkcja())){
			//dla administracji
			if(konf::get()->getSzablon()=="admin"||konf::get()->getSzablon()=="admin2"){
				//jesli jest logowanie
				if(konf::get()->isMod("u")){
					//panel admina
					if(user::get()->adminDostep()){
						konf::get()->setAkcja("u_panel");			
					//panel logowania
					} else {
						konf::get()->setAkcja("u_zalogujadmin");	
					}
				//akcja domyslna
				} else if(!$this->_akcjaKoniec&&konf::get()->getKonfigTab("akcja_domyslna")){				
					konf::get()->setAkcja(konf::get()->getKonfigTab("akcja_domyslna"));
				}
			//akcja domyslna	
		 	} else if(!$this->_akcjaKoniec&&konf::get()->getKonfigTab("akcja_domyslna")){				
				konf::get()->setAkcja(konf::get()->getKonfigTab("akcja_domyslna"));
			}
			
		}

		//jesli kolejna akcja to wykonujemy rekurencyjnie
		if(!$this->_akcjaKoniec&&konf::get()->getAkcja()&&$akcja!=konf::get()->getAkcja()&&!in_array(konf::get()->getAkcja(),$this->_akcjeTab)){
			$this->akcje();
		}
		
	}

	
  /**
   * buforowanie zawartosci
   */			
	public function obStart(){
	
		//buforowanie treści - poczatek
		ob_start(); 
		ob_implicit_flush(0);	
	
	}
	
	
  /**
   * buforowanie zawartosci
   */			
	public function obStop(){
	
		//buforowanie tresci - koniec i wyswietlenie tresci
		$contents = ob_get_contents();
		ob_end_clean();
		
		$zamiana1[]="[[-plikiheader-]]";
		$zamiana2[]=konf::get()->getHeader();		
		
		$zamiana1[]="[[-tytul-]]";
		$zamiana2[]=htmlspecialchars(konf::get()->getKonfigTab('tytul'));			

		$zamiana1[]="[[-keywords-]]";
		$zamiana2[]=htmlspecialchars(konf::get()->getKonfigTab('keywords'));		
		
		$zamiana1[]="[[-description-]]";
		$zamiana2[]=htmlspecialchars(konf::get()->getKonfigTab('description'));			
		
		$zamiana1[]="[[-kodheader-]]";
		$zamiana2[]=konf::get()->getKonfigTab('kodheader');					
		
		$zamiana1[]="[[-kodfooter-]]";
		$zamiana2[]=konf::get()->getKonfigTab('kodfooter');			
		
		$zamiana1[]="[[-kodstat-]]";
		$zamiana2[]=konf::get()->getKonfigTab('kodstat');				
				
		$zamiana1[]="[[-kodonload-]]";
		if(konf::get()->getKonfigTab('kodonload')){
			$zamiana2[]="onload=\"".konf::get()->getKonfigTab('kodonload')."\"";					
		} else {
			$zamiana2[]="";					
		}
		
		$zamiana1[]="[[-kodkomunikaty-]]";			
		if(konf::get()->getKomunikatTab()){ //wyswietlanie komunikatow i bledow
			$zamiana2[]="<div id=\"komunikaty\">".rysuj_komunikaty(konf::get()->getKomunikatTab())."</div>";
		} else {
			$zamiana2[]="";					
		}		
		
		//zamiana w szablonie
		$contents=str_replace($zamiana1,$zamiana2,$contents);
		
		echo $contents;
	
	}	
	

	/**
   * class constructor php5	
   * @param array $konfig
   */	
	public function __construct() {	
	
		$this->domyslne();

  }	


}

?>