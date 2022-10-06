<?php

/**
 * sqlZapis class v1.0
 * dla CMS i innych klas - standardowo tworzy  zapytanie sql do zapisu, edycji danych dla modulow).
 * All rights reserved
 * @package sqlZapis class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2007 Waldemar Jonik
 */

/**
 *
 * Example:
 *

  require_once("class.sqlZapis.php");
	$sql=new sqlZapis($dane);
	$sql->dodaj("UPDATE tabela SET ");
	$sql->dodajDaneE();	
	$sql->dodaj("WHERE id=1");
	$zapytanie=$sql->getSql();
	
 *
 */
	
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		
		
class sqlZapis {

	/**
	 * Public variables
	 */

	/**
	 * Private variables
	 */
		
	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="sqlZapis class";
	
	/**
	 * tabela sql
	 */				
  private $_tabela="";		
	
	/**
	 * dotychczasowe dane
	 */					
	private $_dane=array();				
	
	/**
	 * dane nie do czyszczenia
	 */					
	private $_daneNieczysc=array();				
	
	/**
	 * dane nie do escapowania
	 */					
	private $_nieescape=array();				
		
	/**
	 * testy danych
	 */					
	private $_testy=array();					
	
	/**
	 * typ - typ pliku
	 */					
	private $_sql="";
	
	/**
	 * kontrola
	 */					
	private $_ok=false;
	
	/**
	 * kontrola testowania
	 */					
	private $_testowano=false;	
	
	/**
	 * kontrola testowania
	 */					
	private $_oktest=true;		
	
	/**
	 * dopisz dane autora
	 */					
	private $_autor=false;		
	
	/**
	 * id matka
	 */					
	private $_matka=0;		
	
	/**
	 * query add
	 */					
	private $_queryAdd="";		

	/**
	 * pole matka
	 */					
	private $_poleMatka="";			
	
	/**
	 * pole poz
	 */					
	private $_polePoz="nr_poz";			
	
	/**
	 * pole id
	 */					
	private $_poleId="id";		
	
	/**
	 * wartosc id
	 */					
	private $_id="";			
	
	/**
	 * nr porzadkowy
	 */			
	private $_poz=0;		
	
	/**
	 * element nad ktorym ma byc wpis
	 */			
	private $_nad=0;			
		
  /**
   * zwraca nazwe klasy
   * @return string				
   */		
	public function getNazwaKlasy(){
	
		return $this->_nazwaKlasy;
		
	}		
	
	
  /**
   * Set dane
   * @param array $dane
   */
  public function setDane($dane) {
	
		if(!empty($dane)&&is_array($dane)){
	    $this->_dane=array_merge($this->_dane,$dane);
		}		

  }		
	
	
  /**
   * unSet dane
   * @param string $key
   */
  public function unsetDane($dane) {
	
		if(!empty($key)&&isset($this->_dane[$key])){
			unset($this->_dane[$key]);
		}

  }			
	
	
  /**
   * Set tabela
   * @param string $tabela
   */
  public function setTabela($tabela) {
	
  	if(!empty($tabela)){
      $this->_tabela=$tabela;
		} else {
			trigger_error("setTabela: invalid table value ".$this->getNazwaKlasy(),E_USER_ERROR);
			$this->_oktest=false;
		}		
		
  }			

	
  /**
   * Set testy
   * @param array $testy
   */
  public function setTesty($testy) {

		if(!empty($testy)&&is_array($testy)){
	    $this->_testy=array_merge($this->_testy,$testy);
		}		

  }		
	
	
  /**
   * Set nie escape
   * @param array $testy
   */
  public function setNieEscape($nieescape) {

		if(!empty($nieescape)&&is_array($nieescape)){
	    $this->_nieescape=array_merge($this->_nieescape,$nieescape);
		}		

  }		
		
	
	
  /**
   * Set daneNieczysc
   * @param array $daneNieczysc		
   */
  public function setDaneNieczysc($daneNieczysc) {

		if (!empty($daneNieczysc)&&is_array($daneNieczysc)){
	    $this->_daneNieczysc=$daneNieczysc;
		}		

  }		

			
  /**
   * Get dane
   * @param string $key
   * @return string array
   */		
  public function getDane($key="") {

		if(!empty($key)){
			if(isset($this->_dane[$key])){
		    return $this->_dane[$key];
			} else {
				return "";
			}
		}	else {
	    return $this->_dane;		
		}

  }		
	
	
  /**
   * Get oktest
   * @return bool
   */		
  public function ok() {

	  return $this->_oktest;		

  }			
	
	
  /**
   * Set autor
   * @param bool $autor
   */
  public function setAutor($autor) {

		if(!empty($autor)){
	    $this->_autor=true;
		} else {
	    $this->_autor=false;
		}		

  }			
	
	
  /**
   * Set matka
   * @param int $matka
   */
  public function setMatka($matka) {
	
		$matka=tekstForm::doSql($matka);	
		$matka=$matka+0;	

		if(is_int($matka)&&$matka>=0){
    	$this->_matka=$matka;
		} else {
			trigger_error("setMatka: invalid matka value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
			
  }			
	
	
  /**
   * Set poleMatka
   * @param string $poleMatka
   */
  public function setPoleMatka($poleMatka) {

		if(!empty($poleMatka)){
	    $this->_poleMatka=$poleMatka;
		} else {
			trigger_error("setPoleMatka: invalid poleMatka value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
			
  }		
	
			

  /**
   * Set poleId
   * @param string $poleId
   */
  public function setPoleId($poleId) {

		if(!empty($poleId)){
	    $this->_poleId=$poleId;
		} else {
			trigger_error("setPoleId: invalid poleId value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}				

  }		
			
			
  /**
   * Set id
   * @param int $id
   */
  public function setId($id) {
		
		$id=$id+0;	

		if($id>0){
    	$this->_id=$id;
		} else {
			trigger_error("setId: invalid id value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
			
  }			
						
		
  /**
   * Set polePoz
   * @param string $polePoz
   */
  public function setPolePoz($polePoz) {

		if(!empty($polePoz)){
    	$this->_polePoz=$polePoz;
		} else {
			trigger_error("setPolePoz: invalid polePoz value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
			
  }	
	
	
  /**
   * Set nad
   * @param int $nad
   */
  public function setNad($nad) {
	
		$nad=$nad+0;	

		if(is_int($nad)&&$nad>=0){
    	$this->_nad=$nad;
		} else {
			trigger_error("setNad: invalid nad value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
			
  }			
		
	
	
  /**
   * Set queryAdd
   * @param string $queryAdd
   */
  public function setQueryAdd($queryAdd) {

    $this->_queryAdd=$queryAdd;

  }			
	

  /**
   * add sql
   * @param string $sql
   */
  public function dodaj($sql) {

		if($sql!=''){
	    $this->_sql.=$sql;
		}		

  }		
	
	
  /**
   * add sql edit
   */	
	public function dodajDaneE(){

		$this->testuj();
		
		if($this->_oktest){
		
			$this->_sql.="UPDATE ".$this->_tabela." SET ";

			if(!empty($this->_dane)&&is_array($this->_dane)){		
			
				$i=0;										
				reset($this->_dane);
				
				//przelatujemy dane
				while(list($key,$val)=each($this->_dane)){			
									
					if($i>0){
						$this->_sql.=",";
					}
					$this->_sql.=$key."='".$val."'";
					$i++;		
				
				}
			}
			
			if($this->_autor){
				if(!empty($i)){
					$this->_sql.=",";
				}
				$this->_sql.="edytor_id='".user::get()->id()."',edytor_name='".tekstForm::doSql(user::get()->autor())."',edytor_kiedy=NOW()";
			}							
		
		}

		
	}	
	
	
  /**
   * add sql news part 1
   */	
	public function dodajDaneD(){
	
		if(!empty($this->_dane)&&is_array($this->_dane)){
		
			$this->testuj();
			
			if($this->_oktest){
			
				$this->_sql.="INSERT INTO ".$this->_tabela." (";

				reset($this->_dane);
				
				$i=0;
				
				//przelatujemy dane
				while(list($key,$val)=each($this->_dane)){			
									
					if($i>0){
						$this->_sql.=",";
					}
					$this->_sql.=$key;
					
					$i++;
				
				}
			

				if($this->_autor){
					if(!empty($i)){
						$this->_sql.=",";
					}
					$this->_sql.="autor_id,autor_name,autor_kiedy";
				}
			
				$this->_sql.=") VALUES(";		
			
				reset($this->_dane);
				
				$i=0;
				
				//przelatujemy dane
				while(list($key,$val)=each($this->_dane)){			
									
					if($i>0){
						$this->_sql.=",";
					}
					
					if(!in_array($key,$this->_nieescape)){
						$this->_sql.="'";
					}
					$this->_sql.=$val;
					if(!in_array($key,$this->_nieescape)){
						$this->_sql.="'";
					}
					
					$i++;
				
				}
				
				if($this->_autor){
					if(!empty($i)){
						$this->_sql.=",";
					}
					$this->_sql.="'".user::get()->id()."','".tekstForm::doSql(user::get()->autor())."',NOW()";
				}	
				
				$this->_sql.=")";					
				
			}				
			
		}
		
	}
	
	
  /**
   * data testing
   */		
	public function testuj(){
	
		//testy tylko raz
		if(!$this->_testowano){

			//czy sa testy
			if(!empty($this->_testy)&&is_array($this->_testy)){
			
				reset($this->_testy);
				
				//przelatujemy testy
				while(list($key,$val)=each($this->_testy)){
				
					//czy prawidlowo zdefiniowany test
					if(!empty($val['zmienna'])&&isset($this->_dane[$val['zmienna']])&&!empty($val['test'])){
					
						//wykonujemy testy
						switch($val['test']){
							
							//wymus - zeby byla wartosc (dlugosc >0)
							case 'wartosc':
								if(
									empty($this->_dane[$val['zmienna']])
									||(!empty($val['param']['mindl'])&&strlen($this->_dane[$val['zmienna']])<$val['param']['mindl'])||
									(!empty($val['param']['maxdl'])&&strlen($this->_dane[$val['zmienna']])>$val['param']['maxdl'])||
									(!empty($val['param']['reg'])&&!preg_match("/".$val['param']['reg']."/",$this->_dane[$val['zmienna']]))
								){
								
									$this->setBlad($val);		
									
									if(isset($val['param']['domyslny'])){
										$this->_dane[$val['zmienna']]=$val['param']['domyslny'];
									}																						
									
								}
							break;	

							//wymus - wartosc z tablicy
							case 'wtablicy':
								if(!empty($val['param']['wartosci'])&&is_array($val['param']['wartosci'])&&!in_array($this->_dane[$val['zmienna']],$val['param']['wartosci'])){
								
									$this->setBlad($val);			
																
									if(isset($val['param']['domyslny'])){
										$this->_dane[$val['zmienna']]=$val['param']['domyslny'];
									}
																	
								}
							break;
							
							//wymus - wartosc z tablicy indeksow
							case 'wtablicyi':
								if(!empty($val['param']['wartosci'])&&is_array($val['param']['wartosci'])&&!isset($val['param']['wartosci'][$this->_dane[$val['zmienna']]])){

									$this->setBlad($val);	
									
									if(isset($val['param']['domyslny'])){
										$this->_dane[$val['zmienna']]=$val['param']['domyslny'];
									}
																	
								}
							break;
														
							//formatowanie - wartosc bool
							case 'truefalse':
								//puste
								if(empty($this->_dane[$val['zmienna']])){
									$this->_dane[$val['zmienna']]=0;
								//inne niz wymagana wartosc
								} else if(!empty($val['param']['wartosc'])&&$val['param']['wartosc']!=$this->_dane[$val['zmienna']]){
									$this->_dane[$val['zmienna']]=0;								
								//true
								} else {
									$this->_dane[$val['zmienna']]=1;
								}
							break;								
							
							//formatowanie - wymus liczbe
							case 'liczba':
							
								if(empty($val['param']['po_przecinku'])){
									$val['param']['po_przecinku']=0;
								}
								
								$this->_dane[$val['zmienna']]=tekstForm::doLiczba($this->_dane[$val['zmienna']],$val['param']['po_przecinku']);

								if(!empty($val['param']['max'])&&$this->_dane[$val['zmienna']]>$val['param']['max']){	
									$this->setBlad($val);
									if(isset($val['param']['domyslny'])){
										$this->_dane[$val['zmienna']]=$val['param']['domyslny'];
									}									
								}	else if(!empty($val['param']['min'])&&$this->_dane[$val['zmienna']]<$val['param']['min']){
									$this->setBlad($val);		
									if(isset($val['param']['domyslny'])){
										$this->_dane[$val['zmienna']]=$val['param']['domyslny'];
									}															
								}
								
							break;									
							
							//formatowanie - wymus liczbe
							case 'data':							
								if(!tekstForm::sprDate($this->_dane[$val['zmienna']])){	
									$this->setBlad($val);
									if(isset($val['param']['domyslny'])){
										$this->_dane[$val['zmienna']]=$val['param']['domyslny'];
									}									
								}								
							break;																		
							
							//formatowanie - max dlugosc
							case 'skroc':
								if(!empty($val['param']['max'])&&strlen($this->_dane[$val['zmienna']])>$val['param']['max']){
									$this->_dane[$val['zmienna']]=substr($this->_dane[$val['zmienna']],0,$val['param']['max']);																				
								}
							break;															
							
							//formatowanie - oczysc ze znakow specjalnych							
							case 'oczysc':														
								if(isset($val['param']['znak'])){
								  $this->_dane[$val['zmienna']]=tekstForm::podstawowy($this->_dane[$val['zmienna']],$val['param']['znak'],false);	
								} else {
								  $this->_dane[$val['zmienna']]=tekstForm::podstawowy($this->_dane[$val['zmienna']],"",false);	
								}							
							break;
							
							//formatowanie - oczysc ze znakow specjalnych zostawiajac _ oraz -							
							case 'oczysc2':														
								if(isset($val['param']['znak'])){
								  $this->_dane[$val['zmienna']]=tekstForm::podstawowy($this->_dane[$val['zmienna']],$val['param']['znak'],true);	
								} else {
								  $this->_dane[$val['zmienna']]=tekstForm::podstawowy($this->_dane[$val['zmienna']],"",true);	
								}							
							break;							
							
							//formatowanie - usun znaki nowego wiersza									
							case 'usunwiersz':																							
								$this->_dane[$val['zmienna']]=tekstForm::bezlinia($this->_dane[$val['zmienna']]);
							break;
					
																			
						}			
								
					}
				
				}
								
			}
			
			$this->_testowano=true;
			
		}
	
	}
	
	
  /**
   * odczyt danych
   */		
	public function daneOdczyt(){
		
		//odczyt danych z formularza
		reset($this->_dane);		
		while(list($key,$val)=each($this->_dane))	{
			$this->_dane[$key]=konf::get()->getZmienna($key);
			if(!in_array($key,$this->_daneNieczysc)){
				$this->_dane[$key]=tekstForm::doSql($this->_dane[$key]);
			} else {
				$this->_dane[$key]=tekstForm::doSql($this->_dane[$key],false);			
			}
		}		
	}	
	
	
  /**
   * Get dane
   * @param array $val
   */		
  public function setBlad($val) {

		//jesli nie jest to test wymagany to poprawne dane
		if(!empty($val['wymagany'])){
			$this->_oktest=false;
		}	
		if(!empty($val['param']['komunikat'])){
			konf::get()->setKomunikat($val['param']['komunikat'],"error");
		}			
		if(!empty($val['param']['idtf'])){
			konf::get()->setInvalid($val['param']['idtf']);
		}		
		
  }		
	
	
  /**
   * dodaj nr porzadkowy
   */		
	public function dodajPoz(){
	
		if(!empty($this->_polePoz)&&!empty($this->_poleId)){
		
			if($this->_poleMatka){
				$this->_queryAdd.=" AND ".$this->_poleMatka."='".$this->_matka."' ";
			}				
	
			//jesli element nad ktorym umiescic nowy to sprawdzamy go		
			if(!empty($this->_nad)){
				$dane=konf::get()->_bazasql->pobierzRekord("SELECT ".$this->_polePoz." FROM ".$this->_tabela." WHERE ".$this->_poleId."='".$this->_nad."' ".$this->_queryAdd);
				if(!empty($dane)&&!empty($dane[$this->_polePoz])){
					$this->_poz=$dane[$this->_polePoz];
				}
			}
			//lub dodaj jako ostatni na liscie
			if(empty($this->_poz)){
				$dane=konf::get()->_bazasql->pobierzRekord("SELECT MAX(".$this->_polePoz.") AS ".$this->_polePoz." FROM ".$this->_tabela." WHERE 1 ".$this->_queryAdd);
				if(!empty($dane)&&!empty($dane[$this->_polePoz])){
					$this->_poz=$dane[$this->_polePoz];
				}
				$this->_poz++;
			}		
			
  		$this->setDane(array($this->_polePoz=>$this->_poz));			
			
		}
	
	}
	

  /**
   * dodaj nr porzadkowy
   */		
	public function ustawPoz(){

		if(!empty($this->_polePoz)&&!empty($this->_poleId)&&!empty($this->_id)&&!empty($this->_nad)){					
			konf::get()->_bazasql->zap("UPDATE ".$this->_tabela." SET ".$this->_polePoz."=".$this->_polePoz."+1 WHERE 1 ".$this->_queryAdd." AND ".$this->_polePoz.">='".$this->_poz."' AND ".$this->_poleId."!='".$this->_id."'");
		}	
		
	}
	
	
  /**
   * pobierz kod SQL
   * @return string
   */
  public function getSql() {	

		return $this->_sql;
	
	}		
	
	
  /**
   * zwraca  wynik testowania
   * @return bool
   */
  public function okTest() {	

		return $this->_oktest;
	
	}			
			
			
  /**
   * remowe sql query
   */	
	public function resetSql(){			
	
		$this->_sql="";
	
	}
	
	/**
   * class konstructor php5	
   * @param string $tabela		 
   * @param array $dane
   * @param array $daneNieczysc				
   */	
	public function __construct($tabela,$dane="",$daneNieczysc="") {	

		$this->setDane($dane);		
		$this->setTabela($tabela);
		$this->setDaneNieczysc($daneNieczysc);			
		
  }	

}

?>