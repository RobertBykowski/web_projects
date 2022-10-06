<?php

/**
 * Konfig class v1.0
 * dla CMS i innych klas - tworzenie formularzy
 * @package konfig class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2006 Waldemar Jonik
 */

/**
 *
 * Example:
 *

  require_once("class.konfig.php");	
	$konf=new konfig($konfig);
 *
 */
	
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}		


class konf {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="konf class";
	
	
	/**
	 * tablica zmiennych konfiguracyjnych
	 */				
  private $_konfigTab=array();	
	
	
	/**
	 * tablica komunikatow
	 */				
  private $_komunikatTab=array();	
	
	
	/**
	 * tablica komunikatow bledow formularzy
	 */				
  private $_invalidTab=array();	
	
	
	/**
	 * tlumaczenia jezykowe
	 */				
  private $_tekstyTab=array();		
	
	
	/**
	 * lista wykonanych akcji
	 */				
  private $_akcjeTab=array();			
	
	
	/**
	 * pliki header - js , css
	 */				
  private $_plikiHeaderTab=array();				
	

	/**
	 * aktualna wersja jezykowa
	 */				
  private $_lang=1;
	
	
	/**
	 * aktualna wersja jezykowa administracji
	 */				
  private $_lang2=1;
	
	
	/**
	 * aktualny styl panelu admina
	 */				
  private $_styl=1;	
			
	
	/**
	 * aktualna akcja
	 */				
 	private $_akcja="";		
	
	
	/**
	 * aktualny szablon
	 */				
  private $_szablon="";			
	
	
	/**
	 * kod header
	 */				
  private $_header="";				
	
	
	/**
	 * kopia danych z post, get itp
	 */			
	private $_gpcs=array();
	
	
	/**
	 * polaczenie sql
	 */				
  public $_bazasql="";				
	
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
   * Set konfig tab
   * @param array $konfig
   */
  public function setKonfigTab($konfig) {
  	if(!empty($konfig)){
			if(is_array($konfig)){
	      $this->_konfigTab=array_merge($this->_konfigTab,$konfig);
			} else {
				trigger_error("setKonfigTab: invalid konfig value ".$this->getNazwaKlasy(),E_USER_ERROR);
			}
		}		
		
  }		

	
  /**
   * get konfig 
   * @param string $indeks
   * @return string array		
   */
  public function getKonfigTab($indeks="",$indeks2="") {
  	if(empty($indeks)){
			return $this->_konfigTab;
		} else if(is_string($indeks)&&isset($this->_konfigTab[$indeks])){
			if(empty($indeks2)){
		    return $this->_konfigTab[$indeks];
			} else if(is_string($indeks2)&&isset($this->_konfigTab[$indeks][$indeks2])){
				return $this->_konfigTab[$indeks][$indeks2];
			} else {
				trigger_error("getKonfigTab: invalid indeks2 '".$indeks2."' value ".$this->getNazwaKlasy(),E_USER_ERROR);
			}		
		} else {
			trigger_error("getKonfigTab: invalid indeks '".$indeks."' '".$indeks2."'  value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		
		
  }
	
	
  /**
   * Set szablon
   * @param string $szablon
   */
	public function setSzablon($szablon){
		
		$this->_szablon=$szablon;
		
	}	
	
	
  /**
   * Get szablon
   * @return string
   */
	public function getSzablon(){
		
		return $this->_szablon;
		
	}				
	
	
  /**
   * Set akcja
   * @param string $akcja
   */
	public function setAkcja($akcja){
		$this->_akcja=$akcja;		
	}	
	
	
  /**
   * Set akcje tab
   * @param string $modul
   * @param string $akcja	
   * @param string $start	
   * @param string $stop
   * @param string $komunikat
   */
	public function setAkcjeTab($modul,$akcja,$start,$stop,$komunikat=""){
		$this->_akcjeTab[]=array("modul"=>$modul,"akcja"=>$akcja,"modul"=>$modul,"start"=>$start,"stop"=>$stop,"komunikat"=>$komunikat);
		
	}	
		

  /**
   * Get akcja
   * @return string
   */
	public function getAkcja(){
		
		return $this->_akcja;
		
	}	
	
  /**
   * unSet pliki header tab
   * @param string $plik
   * @param string $typ
   */
	public function unSetPlikiHeader($plik,$typ=""){
		
		while(list($key,$val)=each($this->_plikiHeaderTab)){	
			if($val['plik']==$plik&&(empty($typ)||$typ=$val['typ'])){
				unset($this->_plikiHeaderTab[$key]);
			}
		}
	}	
		
  /**
   * Set pliki header tab
   * @param string $plik
   * @param string $typ
   * @param string $title		
   */
	public function setPlikiHeader($plik,$typ="",$title=""){
		
		if(!empty($plik)&&!empty($typ)&&!in_array(array("plik"=>$plik,"typ"=>$typ),$this->_plikiHeaderTab)){
			if(!in_array(array("plik"=>$plik,"typ"=>$typ,"title"=>$title),$this->_plikiHeaderTab)){
				$this->_plikiHeaderTab[]=array("plik"=>$plik,"typ"=>$typ,"title"=>$title);
			}
		} else if(!empty($plik)){
			$this->_plikiHeaderTab[]=array("plik"=>$plik,"typ"=>"kod");		
		}

	}	
	
	
  /**
   * Get pliki header tab
   * @param string $typ		
   * @return array
   */
	public function getPlikiHeader($typ=""){
		
		$zwrot=array();
		
		if(empty($typ)){
			$zwrot=$this->_plikiHeaderTab;
		} else {
			while(list($key,$val)=each($this->_plikiHeaderTab)){
				if($val['typ']==$typ){
					$zwrot[]=$val;
				}
			}
		}
		
		return $zwrot;
		
	}		
	
	
  /**
   * Set pliki header tab
   * @param string $typ
   * @param bool $all
   * @return string		
   */
	public function getHeader($typ="",$all=true){
		
		$html="";
		if($all){
			$html.=$this->_header;
		}
		
		while(list($key,$val)=each($this->_plikiHeaderTab)){
			if(empty($typ)||$val['typ']==$typ){
				
				if($val['typ']=="js"){
					$html.="<script type=\"text/javascript\" src=\"".$val['plik']."\"></script>\n";				
				} else if ($val['typ']=="css"){
					$html.="<link rel=\"stylesheet\" type=\"text/css\" media=\"all\" href=\"".$val['plik']."\" />\n";				
				} else if ($val['typ']=="rss"){
					$html.="<link rel=\"alternate\" title=\"".htmlspecialchars($val['title'])."\" href=\"".$val['plik']."\" type=\"application/rss+xml\" />\n";
				} else {
					$html.=$val['plik'];
				}
				
			}
		}		
		
		return $html;

	}		
	
	
  /**
   * Set header
   * @param string $header
   * @param bool $wyczysc	
   */
	public function setHeader($header,$wyczysc=false){
	
		if($wyczysc){
			$this->_header="";
		}
		
		if(!empty($header)){
			$this->_header.=$header;
		}

	}	
		
	
  /**
   * Set komunikat tab
   * @param string $txt
   * @param string $typ
   */
	public function setKomunikat($txt,$typ=""){
		
		if(!empty($txt)){
			$this->_komunikatTab[]=array("txt"=>$txt,"typ"=>$typ);
		}

	}
	
	
  /**
   * Set komunikat tab identyfikator
   * @param string $txt
   * @param string $typ
   */
	public function setKomunikatI($tab,$typ=""){
		
		if(!empty($tab)&&is_array($tab)){
			while(list($key,$val)=each($tab)){
				$this->_komunikatTab[]=array("txt"=>$this->langTexty($val),"typ"=>$typ);
			}
		}

	}	
	
	
  /**
   * get komunikat 
   * @return array		
   */
  public function getKomunikatTab() {
	
		return $this->_komunikatTab;

  }	
	
	
  /**
   * Set invalid tab
   * @param string $typ
   * @param string $txt
   */
	public function setInvalid($typ){
		
		if(!empty($typ)){
			$this->_invalidTab[$typ]=$typ;
		}

	}
	
	
  /**
   * Get invalid tab
   * @param string $typ
   * @return string
   */
	public function getInvalid($typ=""){
		
		if(!empty($typ)){
			if(isset($this->_invalidTab[$typ])){
				return $this->_invalidTab[$typ];
			} else {
				return "";
			}
		} else {
			return $this->_invalidTab;
		}

	}	
	
		
  /**
   * Set bazasql
   * @param object $bazasql
   */
	public function setBazasql($bazasql){
		
		if(!empty($bazasql)&&is_object($bazasql)){
			$this->_bazasql=$bazasql;
		}

	}
	
	
  /**
   * get aktualny styl admin
   * @return int	
   */
	public function getStyl(){
		
		if($this->getZmienna("","","","u_styl")){
			$this->setStyl($this->getZmienna("","","","u_styl"));
		} else if(!empty($this->_konfigTab['styl_default'])){
			$this->setStyl($this->_konfigTab['styl_default']);
		}
		
		return $this->_styl;

		
	}	
	
  /**
   * Set styl
   * @param int $styl
   */
	public function setStyl($styl=""){
		if(!empty($styl)&&!empty($this->_konfigTab['tab_styl'][$styl])){
			$this->_styl=$styl; 
		} else if ((empty($styl)||empty($this->_konfigTab['tab_styl'][$styl]))&&!empty($this->_konfigTab['styl_default'])){
			$this->_styl=$this->_konfigTab['styl_default'];
		} else {
			$this->_styl=1;
		}
		$this->zapiszCookie('u_styl',$this->_styl,3600*24*365,"/");
	}	
	
	
  /**
   * Set page title for seo
   * @param string $title
   * @param bool $zamiana		
   */
	public function setTitle($title,$zamiana=false){
	
		
		if($this->getKonfigTab('tytul_przedrostek')&&!$zamiana){
		
			if($this->getKonfigTab('tytul_przedrostek_koniec')){
				$title=$title." - ".$this->getKonfigTab('tytul_przedrostek');			
			} else {
				$title=$this->getKonfigTab('tytul_przedrostek')." - ".$title;
			}
			
		}
		
		$this->setKonfigTab(array('tytul'=>$title));				
		
	}	
	
	
  /**
   * Set html/js code
   * @param string $kod
   * @param string $tresc		
   * @param bool $poczatek		
   * @param bool $zamiana				
   */
	public function setKod($kod,$tresc,$poczatek=false,$zamiana=false){
		
		if(!$zamiana){
		
			$tresc_byl=$this->getKonfigTab($kod);		
			
			if($poczatek){
				$tresc=$tresc.$tresc_byl;			
			} else {
				$tresc=$tresc_byl.$tresc;	
			}
			
		}
		
		$this->setKonfigTab(array($kod=>$tresc));				
		
	}		
	
		
  /**
   * check installed mod
   * @param int styl
	 * @return bool	
   */	
	public function isMod($mod){
	
		$ok=false;
		
		if(!empty($mod)&&!empty($this->_konfigTab['mod'][$mod])){
			$ok=true;
		}
		
		return $ok;
	
	}
	
	
  /**
   * get aktualny lang 
   * @return int	
   */
	public function getAkcjeTab(){

		return $this->_akcjeTab;
		
	}	
	
	
  /**
   * get aktualny lang 
   * @return int	
   */
	public function getLang(){

		return $this->_lang;
		
	}
	
	
  /**
   * get aktualny lang admin
   * @return int	
   */
	public function getLang2(){
		
		return $this->_lang2;
		
	}	
	
	
  /**
   * get aktualny lang rozs 
   * @return string	
   */
	public function getLangR(){
	
		if($this->_konfigTab['tab_lang'][$this->getLang()]){
			return $this->_konfigTab['tab_lang'][$this->getLang()];
		} else {
			return "";
		}
	
	}	

	
  /**
   * Set lang
   * @param int lang
   */
	public function setLang($lang=""){
		if(!empty($lang)&&!empty($this->_konfigTab['tab_lang'][$lang])){
			$_SESSION['language']=$lang;
			$this->_lang=$lang; 
		} else if (empty($this->_konfigTab['tab_lang'][$lang])&&!empty($this->_konfigTab['lang_default'])){
			$_SESSION['language']=$this->_konfigTab['lang_default'];
			$this->_lang=$this->_konfigTab['lang_default'];
		}
	}
	
  /**
   * Set lang2
   * @param int lang
   */
	public function setLang2($lang=""){
		if(!empty($lang)&&!empty($this->_konfigTab['tab_lang2'][$lang])){
			$this->_lang2=$lang; 
		} else if (empty($this->_konfigTab['tab_lang2'][$lang])&&!empty($this->_konfigTab['lang2_default'])){
			$this->_lang2=$this->_konfigTab['lang2_default'];
		} else {
			$this->_lang2=$this->_lang;
		}
	}	


  /**
   * get language txt
   * @param string $co
   * @param int $lang
	 * @return string
   */	
	public function langTexty($co,$lang=""){
	
		if(!empty($co)){
		
			//jezyk wymuszony
			if (!empty($lang)&&!empty($this->_tekstyTab[$lang][$co])){
		    return $this->_tekstyTab[$lang][$co];		
			//jezyk administracyjny	
		  } else if (!empty($this->_tekstyTab[$this->getLang2()][$co])){
		    return $this->_tekstyTab[$this->getLang2()][$co];				
			//jezyk tresci
		  } else if (!empty($this->_tekstyTab[$this->getLang()][$co])){
		    return $this->_tekstyTab[$this->getLang()][$co];				
			//domyslny jezyk administracyjny
		  } else if ($this->_konfigTab['lang2_default']!=$this->getLang2()&&!empty($this->_tekstyTab[$this->_konfigTab['lang2_default']][$co])){
		    return $this->_tekstyTab[$this->_konfigTab['lang2_default']][$co];	
			} else {
				//szuka pierwsego dostepnego elementu			
				$lang_tab=$this->_konfigTab['tab_lang'];
				while(list($key,$val)=each($lang_tab)){
					if ($key!=$this->getLang2()&&$key!=$this->getLang()&&!empty($this->_tekstyTab[$key][$co])){
		    		return $this->_tekstyTab[$key][$co];	
					}
				}
				
		    return " ";				
			
			}

		} else {
		  return " ";
		} 	
			
	}
	
	
  /**
   * get language pack
   * @param string $plik
   * @param int $lang
   */	
	public function setTekstyTab($plik,$typ=1,$lang=""){
	
		if($typ==1){
			if(empty($lang)||empty($this->_konfigTab['tab_lang'][$lang])){	
				$lang=$this->getLang();
			}
		} else if ($typ==2){
			if(empty($lang)||empty($this->_konfigTab['tab_lang2'][$lang])){	
				$lang=$this->getLang2();
			}		
		}
	 
	 	$plik=$this->getKonfigTab("lang").$plik."_".$lang."_inc.php";	
		
	  if(!empty($plik)&&is_file($plik)){
		
			include($plik);
			if(!empty($texty_tab)&&is_array($texty_tab)){
				if(empty($this->_tekstyTab[$lang])){
					$this->_tekstyTab[$lang]=$texty_tab;
				} else {
					$this->_tekstyTab[$lang]=array_merge($this->_tekstyTab[$lang],$texty_tab);
				}
			}
	  }    
		
	}	


  /**
   * get link 
   * @param string $plik
   * @param array $zmienne
   * @param bool $lang_link
   * @param bool $amp		
	 * @return string
   */	
	public function zmienneLink($plik,$zmienne="",$lang_link=true,$amp=true){
		
		if($amp){
			$znak_amp="&amp;";
		} else {
			$znak_amp="&";
		}
		
		if(strpos($plik,"?")===false){
			$znak="?";
		} else {
			$znak=$znak_amp;
		}
		
		$txt=$plik;
		
		if($lang_link&&!empty($this->_konfigTab['przenies_lang'])){
			$lang=$this->_lang;
			if($lang!=$this->_konfigTab['lang_default']){
				$txt.=$znak.$this->_konfigTab['lang_name']."=".$lang;
				$znak=$znak_amp;
			}
		}
		 
		if(!empty($zmienne)&&is_array($zmienne)){
			reset($zmienne);
			while(list($key,$val)=each($zmienne)){
				if($val!=''||$val===0){
					$txt.=$znak.$key."=".rawurlencode($val);
					if($znak=="?"){ 
						$znak=$znak_amp; 
					}
				}
			}
		}	
		
		return $txt;
		
	}


  /**
   * get value from GPS
   * @param string $post
   * @param string $get
   * @param string $session
	 * @return string
   */	
	public function getZmienna($post="",$get="",$session="",$cookie=""){

		$val="";

		if(!empty($session)&&isset($this->_gpcs['_session'][$session])){
			$val=$this->_gpcs['_session'][$session];
		} else if(!empty($cookie)&&isset($this->_gpcs['_cookie'][$cookie])){
			$val=$this->_gpcs['_cookie'][$cookie];			
		} else if(!empty($post)&&isset($this->_gpcs['_post'][$post])){
			$val=$this->_gpcs['_post'][$post];
		} else if(!empty($get)&&isset($this->_gpcs['_get'][$get])){
			$val=$this->_gpcs['_get'][$get];
		}
		
		$val=tekstForm::gpcSpr($val);
		
		return $val;
		
	} 
	
	
  /**
   * set value to GPS copy
   * @param string $typ
   * @param string $nazwa
   * @param string $wartosc
   */	
	public function setZmienna($typ,$nazwa,$wartosc=""){

		if(!empty($typ)&&isset($this->_gpcs[$typ])){
			if(!empty($nazwa)){
				$wartosc=tekstForm::gpcSprR($wartosc);
				$this->_gpcs[$typ][$nazwa]=$wartosc;
				
			} else {
				trigger_error("setZmienna: invalid nazwa value ".$this->getNazwaKlasy(),E_USER_ERROR);
			}				
		
		} else {
			trigger_error("setZmienna: invalid typ value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}		

	} 	
	
	
  /**
   * set cookie value
   * @param string $nazwa
   * @param string, array $wartosc
   * @param int $czas
   * @param string $sciezka	
   */		
	public function zapiszCookie($nazwa,$wartosc="",$czas=0,$sciezka="/"){
		if(!empty($nazwa)){		
			$this->setZmienna("_cookie",$nazwa,$wartosc);
			@setcookie($nazwa,$wartosc,time()+$czas,$sciezka);				
			$_COOKIE[$nazwa]=$wartosc;
		} else {
			trigger_error("zapiszCookie: invalid nazwa value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}						
	}
	
	
  /**
   * set session value
   * @param string $nazwa
   * @param string, array $wartosc
   */		
	public function zapiszSession($nazwa,$wartosc=""){
		if(!empty($nazwa)){		
			$this->setZmienna("_session",$nazwa,$wartosc);
			$_SESSION[$nazwa]=$wartosc;
		} else {
			trigger_error("zapiszSession: invalid nazwa value ".$this->getNazwaKlasy(),E_USER_ERROR);
		}						
	}	
	
	
  /**
   * zwraca nazwe bierzacego pliku
	 * @return string
   */	
	public function plik() {

		$plik="";
		
		if(!empty($_SERVER)){
		  if (!empty($_SERVER['SCRIPT_FILENAME'])) {
		    $plik=$_SERVER['SCRIPT_FILENAME'];
	  	} else if (!empty($_SERVER['PHP_SELF'])) {
		    $plik=$_SERVER['PHP_SELF'];
	  	}
		}
		
		if($plik==""){
			$plik="index.php";
		}

	  return basename($plik);
		
	}	

	
	//pobiera IP
	public function getIp(){

		if (getenv("HTTP_CLIENT_IP")){ 
			$ip=getenv("HTTP_CLIENT_IP"); 
		} else { $ip=getenv("REMOTE_ADDR"); }
	  if(!(strpos($ip,",")===false)){ 
			$ips=split(",",$ip);
			$ip=$ips[0];
		}	
		
		return $ip;
		
	}

	//pobiera HOST na podstawie IP
	public function getHost(){

		$host="";
		$ip=$this->getIp();
		if(!empty($ip)){
		  $host=@gethostbyaddr($ip);
		}
		
		return $host;
		
	}	
	
	//pobiera dane konfiguracyjne z sql	
	public function odczyt(){

		$konfig=array();
		
		if($this->_bazasql){
		
			$zap=$this->_bazasql->zap("SELECT * FROM ".$this->getKonfigTab("sql_tab",'konfig')." WHERE (lang='".$this->getLang()."' OR lang=0) AND wartosc!='' ORDER BY lang");
			while($dane=$this->_bazasql->fetchAssoc($zap)){
				if(!empty($dane['wartosc'])){
					$this->_konfigTab[$dane['idtf']]=$dane['wartosc'];
				}
			}
			$this->_konfigTab['tytul']=$this->_konfigTab['nazwa_www'];			
			$this->_bazasql->freeResult($zap);	
			
		}
		
	}	
	
	
	
  /**
   * sprawdza kod
   * @param boot spr
   * @return bool
   */			
	public function botProofCheck($spr=true){
	
		$ok=true;
	
		if($spr){

			if ($this->getZmienna($this->getKonfigTab('g_kodhash'))&&$this->getZmienna($this->getKonfigTab('g_kod'))){

				require_once($this->getKonfigTab('klasy').'class.botproof.php');				
				
			  $proof=new botProof($this->getKonfigTab('g_kodprefix'));
			  $proof->setGKodHash($this->getZmienna($this->getKonfigTab('g_kodhash')));

			  if (!$proof->sprKod($this->getZmienna($this->getKonfigTab('g_kod')))){
			  	$ok=false;
			  }
			} else {
				$ok=false;
			}
		}
		
		if(!$ok){
			$this->setKomunikat($this->langTexty("bootproof_kodbledny"),"error");		
		}
		
		return $ok;

	}
	
	
  /**
   * sprawdza czy bierzacy plik php jest plikiem o danej nazwie (mozna uzyc do zabezpieczania akcji modulow ze moga byc wykonane tylko w okreslonyjm pliku)
   * @param string nazwa
   * @return bool
   */			
	public function plikWarunek($nazwa){
	
		$ok=true;
	
		if($nazwa){

			if (tekstForm::male($nazwa)!=tekstForm::male($this->plik())){
				$ok=false;
			}
						
		}

		return $ok;

	}	
	
	
  public static function get($konfig="") {
	
  	return is_null( self::$Instance ) ? self::$Instance = new konf($konfig) : self::$Instance;
		
  }		
	
	/**
   * class constructor php5	
   * @param array $konfig
   */	
	private function __construct($konfig) {	
	
		if(!isset($_SESSION)){
			$_SESSION=array();
		}
	
		$this->_gpcs=array(
			'_post'=>$_POST,
			'_get'=>$_GET,
			'_session'=>$_SESSION,	
			'_cookie'=>$_COOKIE
		);	
		$this->setKonfigTab($konfig);
		$this->setLang();
		$this->setLang2();			
		$this->setKonfigTab(array(
			"plik"=>$this->plik(),
			"dane_start"=>tekstForm::microtimeOblicz()
		));
		
		//akcja
		$this->setAkcja($this->getZmienna('akcja','akcja'));	

			
  }	

}

?>