<?php

/**
 * BazaSql class v1.0 (2009-05-21)
 * dla CMS i innych klas - obs3uga zapytan.
 * All rights reserved
 * @package bazaSql class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2009 JW Web Development
 */

/**
 *
 * Example:
 *

  include ("class.bazasql.php");

  $bazasql=new bazaSql("localhost","admin","1234","admin");		
	$bazasql->setCharset("latin2");			
	$bazasql->polacz();		
	$zap=$bazasql->zap($zapytanie);
	while($dane=$bazasql->fetchAssoc($zap)){
		print_r($dane);
	}
	$bazasql->rozlacz();				
	
 *
 */
	
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		
	
class bazaSql extends mysqli {

	/**
	 * Public variables
	 */

		
	/**
	 * Private variables
	 */		
		
	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="BazaSql class";
	
  /**
   * serwer
   */
  private $_serwer="localhost";

  /**
   * MySQL username; default empty
   */
  private $_user="";

  /**
   * haslo
   */
  private $_haslo="";

  /**
   * baza danych
   */
  private $_db="";
	
  /**
   * port
   */
  private $_port="";	
	
  /**
   * charset
   */
  private $_charset="";	

  /**
   * wkaznik polaczenia
   */
  private $_conn=false;

  /**
   * wskazniki rezultatow SQL
   */
  private $_wynik=array();

  /**
   * zapytanie SQL
   */
  private $_zapytanie="";
	
  /**
   * zapytania SQL - tablica
   */
  private $_zapytania_tab=array();	

  /**
   * numer w tablicy zapytan
   */
  private $_wynikNr=0;	
	
	
	public $errorno="";
	
	
	public $error="";	

	/**
	 * Public methods
	 */
		
		
  /**
   * zwraca nazwe klasy
   * @return string				
   */		
	public function getNazwaKlasy(){
		return $this->_nazwaKlasy;
	}	
					
			
  /**
   * ustawia nazwe serwera
   * @param string $serwer
   */		
	public function setSerwer($serwer){
		if(empty($serwer)||!is_string($serwer)){
			trigger_error("setSerwer: invalid  serwer value ".$this->getNazwaKlasy(),E_USER_ERROR);
		} else {
			$this->_serwer=$serwer;
		}
	}
	
  /**
   * ustawia port serwera
   * @param string $port
   */		
	public function setPort($port){
		$this->_port=$port;
	}
	
	
  /**
   * zwraca liste zapytan
   * @return array		
   */		
	public function getZapytaniaTab(){
		return $this->_zapytania_tab;
	}		
	
		
  /**
   * ustawia nazwe usera
   * @param string $user
   */		
	public function setUser($user){
		if(!is_string($user)){
			trigger_error("setUser: invalid  user value ".$this->getNazwaKlasy(),E_USER_ERROR);
		} else {
			$this->_user=$user;
		}
	}
	
	
  /**
   * ustawia haslo
   * @param string $haslo
   */		
	public function setHaslo($haslo){
		if(!is_string($haslo)){
			trigger_error("setHaslo: invalid  haslo value ".$this->getNazwaKlasy(),E_USER_ERROR);
		} else {
			$this->_haslo=$haslo;
		}
	}
	
	
  /**
   * ustawia charset
   * @param string $charset
   */		
	public function setCharset($charset){
		if(!is_string($charset)){
			trigger_error("setCharset: invalid  charset value ".$this->getNazwaKlasy(),E_USER_ERROR);
		} else {
			$this->_charset=$charset;
			if($this->getConn(false)){			
				if(method_exists($this,"set_charset")){
					$this->set_charset($this->_charset);			
				}
				$this->zap("SET CHARACTER SET '".$this->_charset."'");
				$this->zap("SET NAMES '".$this->_charset."'");
			}
		}
	}

	
  /**
   * ustawia nazwe db
   * @param string $db
   */		
	public function setDb($db){
	
		$ok=false;
		
		if(empty($db)||!is_string($db)){
			trigger_error("setDb: invalid  db value ".$this->getNazwaKlasy(),E_USER_ERROR);
		} else {
			$this->_db=$db;
			if($this->getConn(false)){	
				$this->connectDb();					
			}
		}
		
		return $ok;
		
	}
	
	
  /**
   * laczy DB
   * @param string $db
   * @return bool					
   */		
	public function connectDb(){	
		
		$ok=false;
		
		if($this->getConn()){
		
			if(!$this->_db){
				trigger_error("connectDb: invalid db value ".$this->getNazwaKlasy(),E_USER_ERROR);				
			} else if(!$this->select_db($this->_db)){
				trigger_error("connectDb: can't select db ",$this->getNazwaKlasy(),E_USER_ERROR);						
			} else {
				$ok=true;
				if ($this->_charset){
					if(method_exists($this,"set_charset")){
						$this->set_charset($this->_charset);			
					}
					$this->zap("SET CHARACTER SET '".$this->_charset."'");
					$this->zap("SET NAMES '".$this->_charset."'");
				}
			}	 
		}
			
		return $ok;
	
	}
	
	
  /**
   * zwraca polaczenie
   * @return resource/bool			
   */		
	public function getConn($blad=true){

		if(!$this->_conn&&$blad){
			trigger_error("getConn: no connection ".$this->getNazwaKlasy(),E_USER_ERROR);		
		}	
		
		return $this->_conn;

	}				

	
  /**
   * ustawia polaczenie, automatycznei laczy sie z baza danych
   * @param bool $nowy
   * @return bool				
   */		
	public function polacz($nowy=false){
		
		if($this->_serwer==""){
			trigger_error("polacz: no serwer value ".$this->getNazwaKlasy(),E_USER_ERROR);	
		} else {
		
			if($this->_port){
				$this->connect($this->_serwer,$this->_user,$this->_haslo,'',$this->_port);
			} else {
				$this->connect($this->_serwer,$this->_user,$this->_haslo);			
			}

		  if (!mysqli_connect_errno()){ 	
						
				$this->_conn=true;
				
				if($this->_db){
					$this->connectDb();
				}
				
			}	else {
				trigger_error($this->getZapytanie().", ## ".mysqli_connect_error()." ## ".mysqli_connect_errno(),E_USER_ERROR);					
			}
				
		}
		
		return $this->_conn;
		
	}
	
	
  /**
   * ustawia zapytanie
   * @param string $zapytanie
   * @return bool				
   */		
	public function setZapytanie($zapytanie){
	
		$ok=false;
		
		if(!is_string($zapytanie)){
			trigger_error("setZapytanie: invalid  sql query value ".$this->getNazwaKlasy(),E_USER_ERROR);
		} else {
			$this->_zapytanie=$zapytanie;
			$ok=true;
		}
		
		return $ok;
		
	}	
	
  /**
   * wykonuje zapytanie sql
   * @param string $zapytanie
   * @return int	
   */			
	public function zap($zapytanie){
	
		$nr="";
					
		if($this->getConn()){		
			
			if($this->setZapytanie($zapytanie)) {
			
				$_start=$this->microtimeOblicz();
				$this->_wynikNr++;
				$nr=$this->_wynikNr;
				
				$this->_wynik[$nr]=$this->query($this->getZapytanie());	
				$this->getZapytanie();
				if(!$this->getWynik($nr)){
					$this->wyswietlBlad();
	  		} 			

				$this->_zapytania_tab[]=array('zap'=>$this->getZapytanie(),'start'=>$_start,'stop'=>$this->microtimeOblicz());		
			}
		}		
		return $nr;
		
	}
	
	
  /**
   * zwraca zasob wybranego nr zapytania
   * @param int $zap		
   * @return resource/bool/int				
   */		
	public function getWynik($zap){
		
		if(isset($this->_wynik[$zap])){	
			return $this->_wynik[$zap];
		} else {
			trigger_error("getWynik: invalid or empty query result ".$this->getNazwaKlasy(),E_USER_ERROR);		
			return false;
		}
		
	}				
	
  /**
   * zwraca ostatnie zapytanie
   * @return string				
   */		
	public function getZapytanie(){
	
		return $this->_zapytanie;
		
	}				
	

  /**
   * wyswietla bledy SQL
   */		
	public function wyswietlBlad(){
		if($this->error||$this->errorno){
			trigger_error($this->getZapytanie().", ## ".$this->error." ## ".$this->errorno,E_USER_ERROR);
		}					
	}	
		
	
  /**
   * czysci rezultat	
   * @param int $zap		
   */			
	public function freeResult($zap){
	
		if($this->getWynik($zap)){		
	 		$this->_wynik[$zap]->free();
			unset($this->_wynik[$zap]);
		}
		
	}	
	
	
  /**
   * ilosc rekordow z zapytania		
   * @return int		
   */		
	public function numRows($zap){	
	
		$ile=0;

		if($this->getWynik($zap)){
			$ile=$this->_wynik[$zap]->num_rows;
		}

		return $ile;
		
	}	
	

  /**
   * rekord	
	 $ @param int $zap
   * @return array/bool	
   */		
	public function fetchAssoc($zap){	
	
		$dane=false;
	
		if($this->getWynik($zap)){
			$dane=$this->_wynik[$zap]->fetch_assoc();
		}

		return $dane;
		
	}		
	
	
  /**
   * generuje unikalny identyfikator dla danej tabeli sql, dla danego pola
   * @param string $tabela	
   * @param string $pole		
   * @return string
   */	
	public function genSid($tabela,$pole="zalogowanie"){
	
		$ok=false;
		$sid="";
	
		if(empty($tabela)||!is_string($tabela)){
			trigger_error("genSid: invalid tabela value ".$this->getNazwaKlasy());
		} else if(empty($pole)||!is_string($pole)){
			trigger_error("genSid: invalid pole value ".$this->getNazwaKlasy());
		} else {		
		
			srand((double)microtime()*10000000); 

			while(!$ok){
				$sid=""; 
				//losuje 30 liczb
				for ($i=1; $i<=20; $i++){ 
					$sid.=round(rand(0,9));
				}
				$sid=md5($sid);
				if($this->policz("*"," FROM ".$tabela." WHERE ".$pole."='".$sid."'")==0){
					$ok=true; 
				}
			}
		}
		
		return $this->escapeString($sid);
		
	}	
	
	
  /**
   * zwraca ilosc danego elementu dla danego zapytania sql
   * @param string $pole
   * @param string $warunek		
   * @return int				
   */	
	public function policz($pole, $warunek){
		
		if(empty($pole)||!is_string($pole)){
			trigger_error("zap: invalid pole value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}	else if(empty($warunek)||!is_string($warunek)){
			trigger_error("zap: invalid warunek value ".$this->getNazwaKlasy(),E_USER_ERROR);
		} else {							
  		$dane=$this->pobierzRekord("SELECT COUNT(".$pole.") AS ile ".$warunek);			
		}	
		
		if(empty($dane['ile'])){
			$dane['ile']=0;
		}
		
		return $dane['ile'];
		
	}
	
	
  /**
   * zwraca dokladnie jeden rekord dla danego zapytania			
   * @param string $zapytanie	
   * @return array		
   */		
	public function pobierzRekord($zapytanie){
	
  	$dane=array();

		$zap=$this->zap($zapytanie);	
 		if($this->numRows($zap)>0){		
  	  $dane=$this->fetchAssoc($zap);
	  }
		$this->freeResult($zap);

  	return $dane;	
		
	}
	
	
  /**
   * zwraca tablice rekordow		
   * @param string $zapytanie	
   * @return array		
   */		
	public function pobierzRekordy($zapytanie,$key=""){
	
  	$dane=array();

		$zap=$this->zap($zapytanie);
 		while($dane2=$this->fetchAssoc($zap)){
			if(!empty($key)&&isset($dane2[$key])){
	  	  $dane[$dane2[$key]]=$dane2;
			} else {
	  	  $dane[]=$dane2;			
			}
	  }
		$this->freeResult($zap);

  	return $dane;	
		
	}		
	
	
  /**
   * oblicza microtime
   * @return int		
   */			
	public function microtimeOblicz(){
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);	
	}
	

  /**
   * formatowanie do bazy danych
   * @param string/array $fraza		
   * @param bool $usunTagi		
   * @return string/array				
   */	
	public function escapeString($fraza="",$usunTagi=false){
	
		if($fraza!=''){				
			if(is_string($fraza)){
				$fraza=trim($fraza);
				if($usunTagi){ 
					$fraza=strip_tags($fraza); 
				}
				
				$fraza=$this->real_escape_string($fraza);

			} else if (is_array($fraza)){
			
				reset($fraza);
				while(list($key,$val)=each($fraza)){
					$fraza[$key]=$this->escapeString($val,$usunTagi);
				}
				
			} else {	
				unset($fraza);
				$fraza="";
			}
		}
		return $fraza;
		
	}
		

	/**
   * class constructor php5	
   */
	public function __construct($serwer,$user,$haslo,$db) {		
	
		if($serwer!=''){
			$this->setSerwer($serwer);
		}

		if($user!=''){
			$this->setUser($user);
		}	

		if($haslo!=''){
			$this->setHaslo($haslo);
		}		
		
		if($db!=''){
			$this->setDb($db);
		}				
		
  }	

}

?>