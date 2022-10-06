<?php


/**
 * SQL lista class v1.0
 * dla CMS i innych klas - wyswietla liste zapytan sql
 * @package sqllista class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2007 Waldemar Jonik
 */

/**
 *
 * Example:
 *

  require_once("class.sqllista.php");	
	

 *
 */
	
if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

if(user::get()->zalogowany()){
	konf::get()->setTekstyTab("sql_testy_texty",2);
} else {
	konf::get()->setTekstyTab("sql_testy_texty");
}


class sqllista {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="sqllista class";

		
	/**
   * show queries	
   */		
	public function wyswietl(){

		$query_array=konf::get()->_bazasql->getZapytaniaTab();

		echo "<div class=\"srodek szerokosc nowa_l\" style=\"padding-top:10px; padding-bottom:10px\">";
		echo tab_nagl(konf::get()->langTexty("sql_testy"));	
		
		echo "<tr><td class=\"male grube tlo4 lewa\">".konf::get()->langTexty("sql_testy_zap")."</td></tr>";
		
		while(list($key,$val)=each($query_array)){
			if(!empty($val['zap'])){
				echo "<tr><td class=\"male tlo3 lewa\">".$val['zap']."<br />".($val['stop']-$val['start'])."</td></tr>";
			}
		}

		echo "<tr><td class=\"male grube tlo4 lewa\">".konf::get()->langTexty("sql_testy_ilezap")." ".count($query_array)."</td></tr>";
		echo "<tr><td class=\"male grube tlo4 lewa\">".konf::get()->langTexty("sql_testy_czas")." ".(round(tekstForm::microtimeOblicz(),7)-round(konf::get()->getKonfigTab('dane_start'),7))."</td></tr>";
		echo tab_stop();
		
		echo "</div>";

	}
	
	
	/**
   * class constructor php5	
   */	
	public function __construct() {	

  }		
	
}

?>