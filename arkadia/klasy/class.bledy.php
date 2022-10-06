<?php

/**
 * Bledy class v1.2 (2009-05-21)
 * dla CMS i innych klas - obsluga bledow systemowym oraz wlasnych.
 * All rights reserved
 * @package Bledy class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2009 JW Web Development
 */

/**
 *
 * Example:
 *

  include ("class.bledy.php");

  $blad=new Bledy();
  $blad->Folder("./logs/");
	$blad->setZapisuj(array(1=>"E_ERROR",2=>"E_WARNING"));
	$blad->setWyswietl(array(1=>"E_ERROR",2=>"E_WARNING",1=>"E_INNE"));	
	$blad->setEmail("jwaldek@gmail.com");
	$blad->setEmailTytul("blad na www.przyklad.pl");	
	$blad->setWysylaj(array(1=>"E_ERROR",2=>"E_WARNING",3=>"E_SQL"));	
	$blad->dodajBlad("E_INNE","TESTOWY","testujemy bledy");	
	set_error_handler(array($blad,"dodajSystemowe"));	
	
 *
 */
	
	
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		

	
class Bledy {

	/**
	 * Public privateiables
	 */


	/**
	 * Private privateiables
	 */		
		
	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="Bledy class";
	
	/**
	 * katalog na logi
	 */
	private $_folder="";

	/**
	 * typy bledow zapisywanych do katalogu logow
	 */
	private $_zapisuj=array();

	/**
	 * typy bledow wyswietlanych na ekranie
	 */
	private $_wyswietl=array();

	/**
	 * email na jaki wysylac bledy
	 */
	private $_email="";
	
	/**
	 * tytul emaila z bledami
	 */
	private $_emailTytul="";	

	/**
	 * typy bledow wysylanych na email
	 */
	private $_wysylaj=array();
		
	
	/**
	 * tablica bledow
	 */
	private $_bledyTablica=array();			


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
   * ustawia nazwe folderu na logi
   * @param string $folder
   */		
	public function setFolder($folder){
		if(!is_string($folder)){
			$this->dodajBlad("setFolder: invalid  folder value",$this->getNazwaKlasy(),E_USER_ERROR);
		} else {
			$this->_folder=$folder;
		}
	}
	
	
  /**
   * zwraca nazwe folderu na logi
   * @return string		
   */		
	public function getFolder(){
		return $this->_folder;
	}	
	
	
  /**
   * ustawia typy do zapisu
   * @param array $zapisuj
   */		
	public function setZapisuj($zapisuj){
		if(!is_array($zapisuj)){
			$this->dodajBlad("setZapisuj: invalid zapisuj value",$this->getNazwaKlasy(),E_USER_ERROR);		
		} else {
			$this->_zapisuj=$zapisuj;
		}
	}
	
	
  /**
   * zwraca typy do zapisu
   * @return array				
   */		
	public function getZapisuj(){
		return $this->_zapisuj;
	}		
	
	
  /**
   * ustawia typy do wyswietl
   * @param array $wyswietl
   */		
	public function setWyswietl($wyswietl){
		if(!is_array($wyswietl)){
			$this->dodajBlad("setWyswietl: invalid wyswietl value",$this->getNazwaKlasy(),E_USER_ERROR);		
		} else {
			$this->_wyswietl=$wyswietl;
		}
	}
	
	
  /**
   * zwraca typy do wyswietl
   * @return array				
   */		
	public function getWyswietl(){
		return $this->_wyswietl;
	}		
	
	
  /**
   * ustawia typy do wysylaj
   * @param array $wysylaj
   */		
	public function setWysylaj($wysylaj){
		if(!is_array($wysylaj)){
			trigger_error("setWysylaj: invalid wysylaj value",E_USER_ERROR);	
		} else {
			$this->_wysylaj=$wysylaj;
		}
	}
	
	
  /**
   * zwraca typy do wysylaj
   * @return array				
   */		
	public function getWysylaj(){
		return $this->_wysylaj;
	}	
	
	
  /**
   * ustawia email
   * @param string $email
   */		
	public function setEmail($email){
		if(!is_string($email)||strpos($email,"@")===false){
			trigger_error("setEmail: invalid email value",E_USER_ERROR);		
		} else {
			$this->_email=$email;
		}
	}
	
	
  /**
   * zwraca email
   * @return string				
   */		
	public function getEmail(){
		return $this->_email;
	}				
	
	
  /**
   * ustawia emailTytul
   * @param string $emailTytul
   */		
	public function setEmailTytul($emailTytul){
		if(empty($emailTytul)||!is_string($emailTytul)){
			trigger_error("setEmailTytul: invalid emailTytul value",E_USER_ERROR);		
		} else {
			$this->_emailTytul=$emailTytul;
		}
	}
	
	
  /**
   * zwraca emailTytul
   * @return string				
   */		
	public function getEmailTytul(){
		return $this->_emailTytul;
	}		
	
	
  /**
   * zwraca liste bledow okreslonych typow
   * @param array $typy		
   */		
	public function getBledyTablica($typy=""){
		if(empty($typy)||!is_array($typy)){
			return $this->_bledyTablica;
		} else {
			reset($this->_bledyTablica);
			$wybrane=array();
			while(list($key,$val)=each($this->_bledyTablica)){
				if(in_array($val['errno'],$typy)){
					$wybrane[$key]=$val;
				}
			}
			return $wybrane;
		}
	}			
	

  /**
   * obiektowy zamiennik systemowego error handling function
   * E_WARNING, E_NOTICE, E_USER_ERROR,
   * E_USER_WARNING and E_USER_NOTICE		
	 *
   * @param string errno
   * The first parameter, errno, contains the level of the error raised, as an integer. 
	 *	
   * @param string errstr
   * The second parameter, errstr, contains the error message, as a string. 
	 *	
   * @param string errfile
   * The third parameter is optional, errfile, which contains the filename that the error was raised in, as a string. 
	 *	
   * @param string errline
   * The fourth parameter is optional, errline, which contains the line number the error was raised at, as an integer. 
	 *	
   * @param array errcontext
   * The fifth parameter is optional, errcontext, which is an array that points to the active symbol table at the point the error occurred. In other words, errcontext will contain an array of every privateiable that existed in the scope the error was triggered in. User error handler must not modify error context. 		
   */		
	public function dodajSystemowe($errno, $errmsg, $filename="", $linenum="", $privates=""){
	
		$errors=array(
			1	=>"E_ERROR",
			2	=>"E_WARNING",
			4	=>"E_PARSE",
			8	=>"E_NOTICE",
			16=>"E_CORE_ERROR",
			32=>"E_CORE_WARNING",
			64=>"E_COMPILE_ERROR",
			128=>"E_COMPILE_WARNING",
			256=>"E_USER_ERROR",
			512=>"E_USER_WARNING",
			1024=>"E_USER_NOTICE",
			2047=>"E_ALL", 	 
			2048=>"E_STRICT",
			4096=>"E_RECOVERABLE_ERROR",		
		);
		
		if(!empty($errors[$errno])){		
			$this->dodajBlad($errors[$errno], $errmsg, $filename, $linenum, $privates);	
		}
		
  }
	
		
  /**
   * obsluga bledow
	 *
   * @param string errno
   * @param string errstr
   * @param string errwhere
   * @param string errline
   * @param array privates		
   */		
	public function dodajBlad($errno, $errmsg, $filename="", $linenum="", $privates=""){	
	
		if(empty($errno)){
			trigger_error("dodajBlad: invalid errno value ".$this->getNazwaKlasy(),E_USER_ERROR);			
		} if(empty($errmsg)){
			trigger_error("dodajBlad: invalid errmsg value ".$this->getNazwaKlasy(),E_USER_ERROR);			
		} else {
				
			// timestamp
   		$kiedy = date("Y-m-d H:i:s");

			//akcje na bledach					
			$this->_bledyTablica[]=array("kiedy"=>$kiedy, "errno"=>$errno, "errmsg"=>$errmsg, "filename"=>$filename, "linenum"=>$linenum);	
			$this->zapiszBlad($kiedy, $errno, $errmsg, $filename, $linenum, $privates);
			$this->wyswietlBlad($kiedy, $errno, $errmsg, $filename, $linenum, $privates);			
			$this->mailBlad($kiedy, $errno, $errmsg, $filename, $linenum, $privates);					
			
		}		
	}
		
		
  /**
   * zapisywanie
	 *
   * @param string kiedy			
   * @param string errno
   * @param string errstr
   * @param string errwhere
   * @param string errline
   * @param array privates		
   */	
	public function zapiszBlad($kiedy, $errno, $errmsg, $filename="", $linenum="", $privates=""){	
	
		if(!empty($this->_folder)&&in_array($errno,$this->getZapisuj())){

     	if ($file=@fopen($this->getFolder().date("Y-m-d").".log","a")){
		 		$err = "<errorentry>\n";
	  		$err .= "\t<datetime>".$kiedy."</datetime>\n";		
	 			$err .= "\t<errornum>".$errno."</errornum>\n";
		 		$err .= "\t<errormsg>".$errmsg."</errormsg>\n";
	 			$err .= "\t<scriptname>".$filename."</scriptname>\n";
		 		$err .= "\t<scriptlinenum>".$linenum."</scriptlinenum>\n";
	 			$err .= "</errorentry>\n\n";			
        @flock($file,LOCK_EX);
        @fwrite($file,$err);
        @flock($file,LOCK_UN);
        @fclose($file);
     	} else {		
				$this->wyswietlBlad($kiedy,3,"zapiszBlad: logfile fopen error");
     	}
		}
	}
	
	
  /**
   * wyswietlanie
	 *
   * @param string kiedy			
   * @param string errno
   * @param string errstr
   * @param string errwhere
   * @param string errline
   * @param array privates		
   */		
	public function wyswietlBlad($kiedy, $errno, $errmsg, $filename="", $linenum="", $privates=""){	
	
		if(in_array($errno,$this->_wyswietl)){
		
	 		$err=$this->zwrotBlad($kiedy,$errno,$errmsg,$filename,$linenum,$privates);
			echo $err;
			
		}
		
	}	
	
  /**
   * zwrot bledu
	 *
   * @param string kiedy			
   * @param string errno
   * @param string errstr
   * @param string errwhere
   * @param string errline
   * @param array privates	
   * @return string					
   */		
	public function zwrotBlad($kiedy, $errno, $errmsg, $filename="", $linenum="", $privates=""){	

	 	$err = "<div class=\"blad\">";
	 	$err .= "<i>date: ".$kiedy."</i><br />";
		$err .= "error: <b>".$errno."</b><br />";
	 	$err .= "description: <div>".$errmsg."</div>\n";
		if($filename!=""){
	 		$err .= "<div>place: ".$filename."</div>\n";
		}
		if($linenum!=""){				
	 		$err .= "<i>line: ".$linenum."</i><br />";
		}
		$err .= "</div>";			

		return $err;

	}		
	
	
  /**
   * email
	 *
   * @param string kiedy			
   * @param string errno
   * @param string errstr
   * @param string errwhere
   * @param string errline
   * @param array errcontext	
   * @return bool				
   */		
	public function mailBlad($kiedy, $errno, $errmsg, $filename="", $linenum="", $privates=""){	
	
		$ok=false;
		
		if(!empty($this->_email)&&in_array($errno,$this->getWysylaj())){

	 		$err=$this->zwrotBlad($kiedy,$errno,$errmsg,$filename,$linenum,$privates);
					
			if(!@mail($this->getEmail(), $this->getEmailTytul(), $err)){			
				$this->wyswietlBlad($kiedy,3,"BLEDY","mailBlad: email error");							
			} else {
				$ok=true;
			}			
		}
		
		return $ok;
		
	}	
		
	
	/**
   * class constructor php5
   */
	public function __construct(){	
				
  }	

	
}

?>