<?php

/**
 * userdane class v1.0 (2007-01-17)
 * dla CMS i innych klas - obsluga zalogowania/wylogowania.
 * All rights reserved
 * @package user class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2006 Waldemar Jonik
 */

/**
 *
 * Example:
 *

  include("class.user.php");

	$u = new userdane();
	$u->getById(1);	
	
 *
 */
	
	
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}	

include_once(konf::get()->getKonfigTab('mod_kat')."u/konfig_inc.php");
	
class userdane {

	/**
	 * Public variables
	 */

	/**
	 * protected variables
	 */		

	/**
	 * nazwa klasy
	 */				
  public $_nazwaKlasy="userdane class";

	/**
	 * dane zalogowanego
	 */				
	protected $_dane="";
	
	/**
	 * user id
	 */				
	protected $_id="";
	
	/**
	 * tablica uprawnien
	 */				
	protected $_uprTab=array();		
	
	
	/**
	 * tablica id listy kontaktowej
	 */				
	protected $_znajomiTab=array();			
	
		
	/**
	 * znajomi czy pobrano
	 */				
	protected $_znajomiPobrano=false;				
	

	/**
	 * sql add - dodatek do zapytan do listy uzytkownikow generowany na podstawie uprawnien
	 */				
	protected $_sqlAdd="";			
	

	/**
	 * singleton
	 */			
  private static $Instance = null;	
	
	
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
   * znajomi
	 * @param bool $pobierz
   */		
	public function znajomi($pobierz=false){
	 
	 	//pobierz jesli nie pobrano lub wymuszono pobranie	
	 	if($this->_id&&(!$this->_znajomiPobrano||$pobierz)){
		
			$this->_znajomiTab=konf::get()->_bazasql->pobierzRekordy("SELECT u.id, u.login, u.imie, u.nazwisko, u.miejscowosc FROM ".konf::get()->getKonfigTab("sql_tab",'znajomi')." z LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u ON z.id_gosc=u.id WHERE z.id_u='".$this->_id."'".$this->getSqlAdd("u"),"id");
			$this->_znajomiPobrano=true;
			
		}
		
		return $this->_znajomiTab;

	}	
	
  /**
   * znajomi
	 * @param bool $pobierz
   */		
	public function setZnajomiPobrano($ok){
	 
		$this->_znajomiPobrano=$ok;

	}		
	
	
  /**
   * znajomi
	 * @param int $id_u	
   * @return bool					
   */		
	public function jestZnajomi($id_u){
	 
	 	$ok=false;
			
	 	if($id_u){
		
			$znajomi_tab=$this->znajomi();
			if(isset($znajomi_tab[$id_u])){
				$ok=true;
			}
			
		}
		
		return $ok;

	}		

	
  /**
   * zapisuje dane usera
   * @param array $dane
   */		
	public function setDane($dane){		
	
		if(is_array($dane)&&!empty($dane['id'])){
			$this->_dane=$dane;
			$this->setUprTab();
			
			if(!empty($dane['id'])){
				$this->_id=($dane['id']+0);			
			} else {
				$this->_id="";
			}	
		} else {
			$this->_dane=array();
		}
		
	}
	
	
  /**
   * robi update danych				
   */			
	public function update(){

		$this->getById($this->id());
			
	}	

  /**
   * zwraca dane
	 * @param int $param	
   * @return array string							
   */	
	public function getDane($param=""){
		
		$zwrot="";
		
		if(empty($param)){
			$zwrot=$this->_dane;
		} else if(isset($this->_dane[$param])){
			$zwrot=$this->_dane[$param];
		}
		
		return $zwrot;
		
	}
	
	
  /**
   * pobiera dane				
   */			
	public function getById($id,$bierzacy=false){

		$dane=array();
		
		$id=$id+0;
		
		if($id){
			if($bierzacy&&($id==user::get()->id()||empty($id))){
				$dane=user::get()->getDane();			
			} else {				
				$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE id='".$id."' ".$this->getSqlAdd());
			}
			
		}
		
		if(!$bierzacy){
			$this->setDane($dane);
		} 
		
		return $dane;
			
	}

  /**
   * zwraca id zalogowanego
   * @return int						
   */	
	public function id(){

		return $this->_id;
		
	}
	
	
  /**
   * zwraca email zalogowanego
   * @return int						
   */	
	public function email(){

		return $this->getDane("email");
		
	}
	

  /**
   * zwraca login zalogowanego
   * @return string						
   */	
	public function login(){

		return $this->getDane("login");
		
	}
	
	
  /**
   * zwraca login logowania
   * @return string						
   */	
	public function loginLog(){
	
		if (konf::get()->getKonfigTab("u_konf",'email_login')) {	
			return $this->getDane("email");		
		} else {
			return $this->getDane("login");
		}
		
	}	
	

  /**
   * zwraca imie zalogowanego
   * @return int						
   */	
	public function imie(){

		return $this->getDane("imie");
		
	}
	
  /**
   * autor
   * @return string						
   */	
	public function autor(){
	
		$autor="";
		if(konf::get()->getKonfigTab('u_konf','autor')==1||(!$this->imie()&&!$this->nazwisko())){ 
			$autor=$this->login(); 
		} else { 
			$autor=$this->imie()." ".$this->nazwisko(); 
		}
		
		return $autor;
		
	}
	
	
  /**
   * nazwa
   * @return string						
   */	
	public function nazwa($dane="",$ile=""){
	
		$nazwa="";
		
		if(empty($dane)){
			$dane=$this->_dane;
		}
		
		if(!empty($dane['imie'])||!empty($dane['nazwisko'])){
			$nazwa=$dane['imie']." ".$dane['nazwisko'];
		} else if(!empty($dane['login'])) {
			$nazwa=$dane['login'];
		}
		
		return $nazwa;
		
	}	

  /**
   * zwraca nazwisko zalogowanego
   * @return int						
   */	
	public function nazwisko(){

		return $this->getDane("nazwisko");
		
	}
	

  /**
   * sprawdza czy to zwykly user czy administratorz
   * @return bool						
   */		
	public function administrator(){

		if($this->getDane("typ")==1||$this->getDane("typ")==2){
			return true;
		} else {
			return false;
		}
		
	}	

  /**
   * sprawdza czy to zwykly user czy specjalny
   * @return bool						
   */	
	public function specjalny(){

		if($this->getDane("typ")==2){
			return true;
		} else {
			return false;
		}

	}
	
	
  /**
   * sprawdza czy konto w pełni aktywne
   * @return bool						
   */	
	public function aktywne(){

		if($this->getDane("status")==1){
			return true;
		} else {
			return false;
		}

	}
			
	
  /**
   * sprawdza czy ten typ ma dostep do panelu admina
   * @return bool					
   */		
	public function adminDostep(){

		$dostepne_tab=konf::get()->getKonfigTab("u_konf",'typy_paneladmin');
		
		if(in_array($this->getDane("typ"),$dostepne_tab)){
			return true;
		} else {
			return false;
		}
		
	}	
	

  /**
   * stawia uprawnienia usera		
   * @return array			
   */		
	public function getUprTab(){
		
		return $this->_uprTab;
		
	}
	

  /**
   * ustawia uprawnien usera			
   */			
	public function setUprTab(){
	
		$uprawnienia_tab=konf::get()->getKonfigTab("u_konf",'uprawnienia');
		$ile_upr=konf::get()->getKonfigTab("u_konf",'ile_upr');
		
		for($i=0;$i<=$ile_upr;$i++){
			if(!empty($this->_dane['uprawnienia'])&&(substr($this->_dane['uprawnienia'],0,1)==1)||(!empty($uprawnienia_tab[$i])&&!empty($this->_dane['uprawnienia'])&&substr($this->_dane['uprawnienia'],$i,1)==1)){ 
				$ok=1; 
			} else {
				$ok=0;
			}
			$this->_uprTab[$i]=$ok;
		}
		
	}

	
  /**
   * sprawdza uprawnienie nr
   * @param int $nr
   * @return bool						
   */		
	public function upr($nr){

		$ok=false;
		if(!empty($this->_uprTab[$nr])){ 
			$ok=true; 
		}
		return $ok;
		
	}		
	
	
  /**
   * sprawdza uprawnienie glowne
   * @return bool						
   */			
	public function adminGlowny(){
	
		return $this->upr(0);
		
	}
	
	
  /**
   * sprawdza uprawnienie uzytkownikow
   * @return bool						
   */			
	public function adminU(){

		return $this->upr(konf::get()->getKonfigTab("u_konf",'upr_u'));
		
	}


  /**
   * sprawdza uprawnienie logow
   * @return bool						
   */			
	public function adminLogi(){

		return $this->upr(konf::get()->getKonfigTab("u_konf",'upr_log'));
		
	}	
	
	

  /**
   * ustawia dodatek do zapytan sql dla uzytkownikow
   * @return string						
   */			
	public function setSqlAdd($tab=""){
	
		$this->_sqlAdd=user::get()->getSqlAdd($tab);

	}
	
	
  /**
   * zwraca dodatek do sql
   * @return bool						
   */			
	public function getSqlAdd($tab=""){

		$this->setSqlAdd($tab);		
		return $this->_sqlAdd;
		
	}	

  public static function get($id="") {
	
  	return is_null( self::$Instance ) ? self::$Instance = new userdane($id) : self::$Instance;
		
  }	
	
	public static function obrazek($dane,$id_u="",$numer=3,$autor="",$link=true,$klasa="obrazek",$dodatek=""){
	
		$html="";
		
		if(empty($id_u)&&!empty($dane['id'])){
			$id_u=$dane['id'];
		}
		
		if(empty($autor)){
			$autor=user::get()->nazwa($dane);
		}
		
		if(!empty($dane['img'.$numer.'_nazwa'])){
		
      if(file_exists(konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("u_konf",'kat').$dane['img'.$numer.'_nazwa'])){				
				if($link)	{
					$html.="<a class=\"grube\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane",'id_u'=>$id_u))."\" title=\"".htmlspecialchars($autor)."\">";
				} 
				$html.="<img src=\"".konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("u_konf",'kat').$dane['img'.$numer.'_nazwa']."\" width=\"".$dane['img'.$numer.'_w']."\" height=\"".$dane['img'.$numer.'_h']."\" class=\"".$klasa."\" alt=\"".htmlspecialchars($autor)."\" ".$dodatek." />";
				if($link){
					$html.="</a>";
				}
  	  }					
		
		}		
		
		return $html;
						
	}
	

	

  /**
   * konstruktor	
   * @param int $id
   */	
	private function __construct($id="") {
	
		$this->setSqlAdd();
		
		if($id){
			$this->getById($id);
		}
		
	}		

	
}

?>