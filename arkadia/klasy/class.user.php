<?php

/**
 * user class v1.0 (2007-01-17)
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

	$u = new user();
	
 *
 */
	
	
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}	

require_once(konf::get()->getKonfigTab('klasy')."class.userdane.php");


class user extends userdane {

	/**
	 * Public variables
	 */

	/**
	 * Private variables
	 */		

	/**
	 * nazwa klasy
	 */				
  public $_nazwaKlasy="user class";
	
	
	/**
	 * sid zalogowanego
	 */				
	private $_sid="";	
	
	/**
	 * redir - czyli przekierowanie po zalogowaniu
	 */				
	private $_redir="";	
	
	/**
	 * admin upload (dla fck)
	 */				
	private $_adminUpload=false;			
	
	/**
	 * Public methods
	 */
			
	/**
	 * singleton
	 */			
  private static $Instance = null;				

  /**
   * zwraca nazwe klasy
   * @return string				
   */		
	public function getNazwaKlasy(){
		return $this->_nazwaKlasy;
	}	

	
  /**
   * zapisuje admin upload
   * @param bool $admin
   */		
	public function setAdminUpload($admin){
		$this->_adminUpload=$admin;
	}	
		

	/**
   * odczyt admin upload
   * @return bool
   */		
	public function adminUpload(){
		return $this->_adminUpload;
	}	
	

  /**
   * zapisuje redir
   * @param string	$redir
   */		
	public function setRedir($redir){
	
		$this->_redir=base64_decode($redir);
	}	
		

	/**
   * odczyt redir
   * @return string
   */		
	public function getRedir(){
		return $this->_redir;
	}	
	

  /**
   * wylogowanie	
   */		
	public function wyloguj(){
	
		if(!$this->specjalny()){
			$this->zapiszLog(konf::get()->langTexty("u_log_wylogowany")." ",$this->login(),$this->id(),"wylog");
		}	

		konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." SET zalogowanie='' WHERE zalogowanie='".tekstForm::doSql($this->getSid())."'");

		$this->setDane(array());
		$this->setSid("");
		konf::get()->setKomunikat(konf::get()->langTexty("u_wylogowany"),"");

	}
	

  /**
   * zwraca status filtra ip danego typu
	 * @param int $id_typ	
   * @return bool				
   */	
	public function filtr($id_typ=""){

		$ok=true;
		
		$id_typ=tekstForm::doSql($id_typ);

		if(konf::get()->getKonfigTab("u_konf",'banowanie')&&!empty($id_typ)){
		
			$query=" AND id_typ='".$id_typ."' AND status=1 AND (data_start='0000-00-00 00:00:00' OR data_start<=NOW() ) AND (data_stop='0000-00-00 00:00:00' OR data_stop>=NOW()) AND '".tekstForm::doSql(konf::get()->getIp())."' REGEXP ".konf::get()->getKonfigTab("sql_tab",'bany').".ip";
			
			//typ 1 - blokowanie
			if(konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'bany')." WHERE rodzaj=1 ".$query)>0){
				$ok=false;
			}
			if(!$ok){
				//typ 2 - przepuszczanie - wyższy priorytet (nadpisuje blokowanie)
				if(konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'bany')." WHERE rodzaj=2 ".$query)>0){
					$ok=true;
				}
			}
		}
		
		return $ok;
		
	}
	
	
  /**
   * zapisuje dane usera
   * @param array $dane
   */		
	public function setDane($dane){		
	
		if(is_array($dane)){
			$this->_dane=$dane;
			if(!empty($dane['lang2'])){
				konf::get()->setLang2($dane['lang2']);					
			} else {
				konf::get()->setLang2("");					
			}
			$this->setUprTab();
			$this->setSqlAdd();
			if(!empty($dane['id'])){
				$this->_id=($dane['id']+0);			
			} else {
				$this->_id="";
			}
			
		} else {
			trigger_error("setDane: invalid dane value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}
		
	}
		
		
			
  /**
   * Set sid
   * @param string $sid
   * @param bool $zalogowanie	
   */
  public function setSid($sid,$zalogowanie=false) {	
	
		$u_log_stale=konf::get()->getZmienna('u_log_stale');				
    $this->_sid=$sid;
		
		konf::get()->zapiszSession('u_sid'.konf::get()->getKonfigTab("u_konf",'sid_dodatek'),$sid);
		
		if(konf::get()->getKonfigTab("u_konf",'staly_log')){
			if(empty($sid)){
 				konf::get()->zapiszCookie('u_sid_staly'.konf::get()->getKonfigTab("u_konf",'sid_dodatek'),$sid,-3600,"/");
			} else {
 				konf::get()->zapiszCookie('u_sid_staly'.konf::get()->getKonfigTab("u_konf",'sid_dodatek'),$sid,(3600*24*konf::get()->getKonfigTab("u_konf",'staly_log')),"/");			
			}	
		}
		
		if(konf::get()->getKonfigTab("u_konf",'cookie')){
			if(empty($sid)){
	    	konf::get()->zapiszCookie("u_sid".konf::get()->getKonfigTab("u_konf",'sid_dodatek'),$sid,-3600,"/");
			} else {
	    	konf::get()->zapiszCookie("u_sid".konf::get()->getKonfigTab("u_konf",'sid_dodatek'),$sid,60*konf::get()->getKonfigTab("u_konf",'cookie'),"/");			
			}		
		}
				
  }	
	
	
  /**
   * Get sid
   * @param bool $odczyt
   * @return string
   */
  public function getSid($odczyt=false) {
		
		if($odczyt){
		
			$u_sid=konf::get()->getZmienna("","",'u_sid'.konf::get()->getKonfigTab("u_konf",'sid_dodatek'));
		
			if(empty($u_sid)&&konf::get()->getKonfigTab("u_konf",'cookie')){
				$u_sid=konf::get()->getZmienna("","","",'u_sid'.konf::get()->getKonfigTab("u_konf",'sid_dodatek'));	
			}			
		
			//sprawdzmy czy istnieje stale logowanie i czy jest taka mozliwosc a uzytkownik nie na SID
			if(konf::get()->getKonfigTab("u_konf",'staly_log')&&empty($u_sid)){
				$u_sid=konf::get()->getZmienna("","","",'u_sid_staly'.konf::get()->getKonfigTab("u_konf",'sid_dodatek'));	
			}	
			
			$this->_sid=$u_sid;
			
		}
	
  	return $this->_sid;
		
  }		

	
  /**
   * zwraca true jesli zalogowany
   * @return bool						
   */	
	public function zalogowany(){
		
		if($this->getSid()){ 
			return true; 
		} else{ 
			return false; 
		}
		
	}	
	

  /**
   * sprawdza poprawnosc login haslo
   * @param string $fraza
   * @param int $dlugosc
   * @param bool $check
   * @return bool						
   */		
	public function frazaCheck($fraza,$dlugosc,$check=true){
		$ok=false;

		if(tekstForm::utf8Strlen($fraza)>=$dlugosc){
			if(!$check||preg_match("/^(\w)+$/",$fraza)){
				$ok=true;
			}
		}

		return $ok;
		
	}


  /**
   * zapisuje dane log
   * @param string $tresc
   * @param string $kto
   * @param int $id_kto
   * @param string $idtf
   */		
	public function zapiszLog($tresc,$kto="",$id_kto="",$idtf=""){
	
		if(konf::get()->getKonfigTab("u_konf",'log')&&!$this->specjalny()){

			if(empty($id_kto)){ 
				$id_kto=$this->id(); 
			}
			
			if(empty($kto)){ 
				$kto=$this->loginLog(); 
			}			
			
			if(!empty($tresc)){
				konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'logi')." (id_u,login,opis,ip,host,kiedy,idtf) VALUES('".$id_kto."','".tekstForm::doSql($kto)."','".tekstForm::doSql($tresc)."','".tekstForm::doSql(konf::get()->getIp())."','".tekstForm::doSql(konf::get()->getHost())."',NOW(),'".tekstForm::doSql($idtf)."')");
			}
			
		}
			
	}
	
	
  /**
   * przedluzenie zalogowania				
   */			
	public function statusLog(){
	
		$ok=false;

		if(konf::get()->getKonfigTab("u_konf",'aktywne')){
		
			$u_sid=$this->getSid(true);
			
			if(!empty($u_sid)){
			
				$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE zalogowanie='".tekstForm::doSql($this->getSid(false),false)."' AND status IN(1,3,6) ");

				if (!empty($dane)) {
				
					//sprawdzamy czas zalogowania
					if(konf::get()->getKonfigTab("u_konf",'staly_log')||!konf::get()->getKonfigTab("u_konf",'autowylog')||(strtotime($dane["last_operation"])+(60*konf::get()->getKonfigTab("u_konf",'autowylog'))>time())){			
					
						//jesli ip ma byc stale dla danego SID to sprawdzamy to
						if(!konf::get()->getKonfigTab("u_konf",'staly_ip')||$dane['ip_log']==konf::get()->getIp()){
						
		  				konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." SET last_operation=NOW(), last_operation_name='".tekstForm::doSql(konf::get()->getAkcja())."' WHERE id='".$dane['id']."'");
							
							$this->setSid($u_sid);
							$this->setDane($dane);
						
							$ok=true;
							
						}
		
					} else {
						konf::get()->setKomunikat(konf::get()->langTexty("u_przekroczyles"),"error");
					}
					
				} else {
					konf::get()->setKomunikat(konf::get()->langTexty("u_niepoprawnie"),"error");
				}
					
				if(!$ok){ 
					$this->wyloguj();
				}						
				
			}

		}

	}	
	
	
  /**
   * zalogowanie		
   */		
	public function zaloguj(){

		$redir=konf::get()->getZmienna('redir');		
		$u_login=konf::get()->getZmienna('u_login');	
		$u_haslo=konf::get()->getZmienna('u_haslo');			
		$u_sid=""; 		
		$ok=true;

		//system aktywny
		if(konf::get()->getKonfigTab("u_konf",'aktywne')){ //czy system aktywny
		
			if(!empty($redir)){
				$this->setRedir($redir);
			}
		
			//podane dane do logowania
			if(!empty($u_login)&&!empty($u_haslo)){
			
				srand((float) microtime() * 10000000);
								
				//czy autousuwanie kont
				if(konf::get()->getKonfigTab("u_konf",'autousuw')){ 
					if(rand(1,konf::get()->getKonfigTab("u_konf",'autousuw_rand'))==konf::get()->getKonfigTab("u_konf",'autousuw_rand')){
						$data_gr=tekstForm::dniData(konf::get()->getKonfigTab("u_konf",'autousuw'),"d","-");
						if(konf::get()->getKonfigTab("u_konf",'autousuw_delete')){ //czy usuwac czy zmieniac status
							konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE niewygasa=0 AND last_log<'".$data_gr."' AND data_zal<'".$data_gr."'");
						} else {
							konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." SET status=7 WHERE niewygasa=0 AND last_log<'".$data_gr."' AND data_zal<'".$data_gr."'");
						}
					}
				}
				
				//czy autousuwanie logow
				if(konf::get()->getKonfigTab("u_konf",'autousuw_log')){ 
					if(rand(1,konf::get()->getKonfigTab("u_konf",'autousuw_rand'))!=konf::get()->getKonfigTab("u_konf",'autousuw_rand')){			
						konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'logi')." WHERE kiedy<'".tekstForm::dniData(konf::get()->getKonfigTab("u_konf",'autousuw_log'),"d","-")."'");
					}
				}
				
				//jesli zdefiniowano tablice refererow to tylko z nich logowania		
				$dozw_www=konf::get()->getKonfigTab("u_konf",'dozw_www');				
				if(!empty($dozw_www)&&is_array($dozw_www)){
				
					//if(!empty($_SERVER['HTTP_REFERER'])){
					//	$referer=$_SERVER['HTTP_REFERER'];
					//}
					
			  	$referer=getenv("HTTP_HOST");
			    if(empty($referer)&&!empty($_ENV['HTTP_HOST'])){
				    $referer=$_ENV['HTTP_HOST'];
			    }			
					
				  if(!empty($referer)&&$referer!="localhost"&&$referer!="127.0.0.1") {				
			  		$referer=str_replace(strrchr($referer, ":"),"",$referer);
						$ok=false;
				    while(list($key,$val)=each($dozw_www)){
			  	    if (eregi($val."$", $referer)){ 
								$ok=true; 
							}
						}
					}
					
				}
				
				//filtr regul dopuszczania/banowania IP
				if($ok&&!$this->filtr(3)){
					$ok=false;
				}
				
				//ilosc zlych logowan w ciagu godziny
				if ($ok&&konf::get()->getKonfigTab("u_konf",'max_bad_log')) {
					$ile=konf::get()->_bazasql->policz("id", " FROM ".konf::get()->getKonfigTab("sql_tab",'logi')." WHERE login='".tekstForm::doSql($u_login)."' AND idtf='".tekstForm::doSql("b_log")."' AND kiedy>'".tekstForm::dniData(60,"i","-")."'");
					if($ile>konf::get()->getKonfigTab("u_konf",'max_bad_log')){
						$ok=false;
		  			konf::get()->setKomunikat(konf::get()->langTexty("u_czasowo"),"error");
					}
				}

		  	if ($ok) {
		  		
					//logowanie za pomoca emaila
					if (konf::get()->getKonfigTab("u_konf",'email_login')) {
			  	  $wiersz=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE email='".tekstForm::doSql($u_login)."' limit 0,1");				
					} else {
					//logowanie za pomoca loginu
			  	  $wiersz=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE login='".tekstForm::doSql($u_login)."' limit 0,1");
					}

					//jesli znaleziono login
		  		if(!empty($wiersz)){ 
					
						$teraz=date("Y-m-d H:i:s");
						
						//zgadzaja sie hasla
		  			if($this->hasloForma($u_haslo)==$wiersz['haslo']){ 		
							
							//status pozwalajacy na zalogowanie	
		  				if($wiersz['status']==1||$wiersz['status']==6||$wiersz['status']==3){ 
							
		  				  //jesli ktos byl zalogowany to ostatni sid
		  				  if(konf::get()->getKonfigTab("u_konf",'nowysid')&&!empty($wiersz['zalogowanie'])&&$wiersz['last_operation']!="0000-00-00 00:00:00"&&(strtotime($wiersz["last_operation"])+(60*konf::get()->getKonfigTab("u_konf",'nowysid'))>time())){
		  				    $u_sid=$wiersz['zalogowanie'];	
																
		  				  //inaczej generujemy unowy nikalny identyfikator 
		  				  } else {						
		    					$u_sid=$this->genSid();  					
								}					
								
								//po wygenerowaniu SID przedluzenie zalogowania
		  					if(!empty($u_sid)){ 
								
		  						konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." SET zalogowanie='".$u_sid."', ip_log='".konf::get()->getIp()."', host_log='".konf::get()->getHost()."', last_log='".$teraz."', last_operation='".$teraz."', ile_log=ile_log+1 WHERE id=".$wiersz['id']);
		  						konf::get()->setKomunikat(konf::get()->langTexty("u_poprawne"),"");
									
									session_regenerate_id();
									$this->setSid($u_sid,true);		
									$this->setDane($wiersz);
									
			   					$this->zapiszLog(konf::get()->langTexty("u_brak_poprawne_log"),$u_login,$wiersz['id'],"log");			
									
									if($this->getRedir()){
									  header("Location: ".$this->getRedir());
									}
									
		  					} else { 
		  						konf::get()->setKomunikat(konf::get()->langTexty("u_niepowiodlo"),"error");
		  						$this->zapiszLog(konf::get()->langTexty("u_niepowodzenie_log"),$u_login,$wiersz['id']);
		  					}
												
							} else if ($wiersz['status']==0){ 
														
								konf::get()->setKomunikat(konf::get()->langTexty("u_brak_zablokowaneh"),"error");
								 								
							} else if ($wiersz['status']==2){ 					
									
								konf::get()->setKomunikat(konf::get()->langTexty("u_brak_nieaktywowane"),"error"); 		
														
							}
							
			  		} else { //próba logowania niepoprawnych hasłem
						
		  				konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." SET last_bad_log=NOW() WHERE id=".$wiersz['id']);
							konf::get()->setKomunikat(konf::get()->langTexty("u_zlehaslo"),"error");
			   			$this->zapiszLog(konf::get()->langTexty("u_zlehaslo_log"),$u_login,$wiersz['id'],"b_log");
							
		  			}
						
			  	} else { 
					
						konf::get()->setKomunikat(konf::get()->langTexty("u_nieistnieje"),"error"); 
						$this->zapiszLog(konf::get()->langTexty("u_nieistnieje_log"),$u_login,"","b_log");
						
					}			
					
				} else { 
				
					konf::get()->setKomunikat(konf::get()->langTexty("u_blad"),"error"); 
					$this->zapiszLog(konf::get()->langTexty("u_blad_log"),$u_login,"","b_log");			
					
				} 
				
			} else {
				konf::get()->setKomunikat(konf::get()->langTexty("u_brak_danych"),"error"); 
			}
			
		}
		
	}
	
	
  /**
   * generuje SID
   * @param string	$kolumna		
   * @return string
   */	
	public function genSid($kolumna="zalogowanie"){

		$ok=false;
		
		$sid="";
		
		while(!$ok){
			
			//losuje 30 liczb
			for ($i=1; $i<=30; $i++){ 
				$sid.=round(rand(0,9));
			}
			
			//teraz aby wynik byl mniej czytelny dodatkowo md5
			$sid=md5(konf::get()->getKonfigTab("u_konf",'sid_dodatek').$sid.date("Y-m-d"));
			$sid=tekstForm::doSql($sid);			
			
			if(konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." WHERE ".$kolumna."='".$sid."'")==0){
				$ok=true; 
			} else {
				$sid="";
			}
			
		}
		
		return $sid;
		
	}	
	
	
  /**
   * zapisuje haslo w odpowiedniej formie
   * @param string		 $haslo
   * @return string
   */		
	public function hasloForma($haslo){
	
	
		$haslo=$haslo.konf::get()->getKonfigTab("u_konf",'haslo_dodatek');
		
		if(konf::get()->getKonfigTab("u_konf",'haslo_md5')){
			$haslo=md5($haslo);
		}
		return $haslo;
		
	}
	
  /**
   * ustawia dodatek do zapytan sql dla uzytkownikow
   * @return string						
   */			
	public function setSqlAdd($tab=""){
	
		if(!empty($tab)){
			$tab.=".";
		}

		$query="";

		if($this->zalogowany()){
			$typ=$this->getDane("typ");
		} else {
			$typ=konf::get()->getKonfigTab("u_konf",'typy_niezalogowani');		
		}

		$typy_dostepni=konf::get()->getKonfigTab("u_konf",'typydostepni_tab');		
		
		if(!empty($typ)&&!empty($typy_dostepni[$typ])){

			$query_add=tekstForm::tabQuery($typy_dostepni[$typ]);
			
			if(!empty($query_add)){		
				$query.=" AND ".$tab."typ IN (".$query_add.")";			
			}
				
		}

		$typy_statusdostepni=konf::get()->getKonfigTab("u_konf",'typystatusydostepni_tab');			
		
		if(!empty($typ)&&!empty($typy_statusdostepni[$typ])){
		
			$query_add=tekstForm::tabQuery($typy_statusdostepni[$typ]);
			
			if(!empty($query_add)){
				$query.=" AND ".$tab."status IN (".$query_add.")";			
			}
				
		}		
		
		
		if($this->zalogowany()&&!empty($query)){
		
			$query=" AND (".$tab."id='".$this->id()."' OR (".$tab."id!='".$this->id()."' ".$query.")) ";
		
		} 
			
		$this->_sqlAdd=$query;

	}	
	
	
  /**
   * if blocked exists
   * @param int $id_u	
	 * @return bool	
   */		
	public static function jestCzarna($id_u,$komunikat=true){
	
		$ok=false;
		$id_u=$id_u+0;
				
		if(konf::get()->getKonfigTab("u_konf",'czarna')&&!user::get()->adminU()&&!empty($id_u)&&$id_u!=user::get()->id()){
		
			if(konf::get()->_bazasql->policz('id'," FROM ".konf::get()->getKonfigTab("sql_tab",'zablokowani')." WHERE id_gosc='".user::get()->id()."' AND id_u='".$id_u."'")>0){
				if($komunikat){
					konf::get()->setKomunikat("Brak dostępu do konta","error"); 			
				}
				header("index.php?akcja=u_zablokowany");
				$ok=true;
			}
			
		}
			
		return $ok;
		
	}			
	
	
  public static function get($id="") {
	
  	return is_null( self::$Instance ) ? self::$Instance = new user() : self::$Instance;
		
  }			

	
  /**
   * konstruktor	
   * @param object $konfig
   */	
	private function __construct() {
	
		$this->setSqlAdd();
		
		//////////////////////
		//procedura logowania
		//////////////////////
		
		//zalogowanie poprzez przypisanie identyfikatora
		if(konf::get()->getAkcja()=="u_zaloguj2"||konf::get()->getAkcja()=="u_zalogujadmin2"){	
			$this->zaloguj();	
		} else {
		//lub sprawdzenie statusu czy zalogowany
			$this->statusLog();
		}

		//jesli jest zalogowany (ma SID) to pobieramy inne wersje tekstow
		if($this->zalogowany()){
			konf::get()->setLang2($this->getDane('lang2'));	
			if(konf::get()->getZmienna("u_lang2")){
				konf::get()->setLang2(konf::get()->getZmienna("u_lang2"));	
			}		
			konf::get()->setTekstyTab("texty",2);
			konf::get()->setTekstyTab("u_texty",2);		
		} else {
			konf::get()->setTekstyTab("u_texty");		
		}

		//procedura wylogowania
		if(konf::get()->getAkcja()=='u_wyloguj'||konf::get()->getAkcja()=='u_wylogujadmin'){
			$this->wyloguj();
		}
		
		//filtr dostepu do www
		if(!$this->zalogowany()&&!$this->filtr(1)){
			header("Location: http://www.google.com");
		}

		//uprawnienie do uploadu za pomoca edytora
		if($this->upr(11)||$this->upr(14)||$this->upr(16)){
			$this->setAdminUpload(true);
		} else {
			$this->setAdminUpload(false);	
		}		
		
	}		

	
}

?>