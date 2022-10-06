<?php

/**
 * SQL lista class v1.1 (2009-05-21)
 * dla CMS i innych klas - pokazuje liste akcji dla webmastera - programisty
 * @package sqllista class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2009 JW Web Development
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
	konf::get()->setTekstyTab("akcje_testy_texty",2);
} else {
	konf::get()->setTekstyTab("akcje_testy_texty");
}


class akcjelista {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="akcjelista class";

		
	/**
   * show queries	
   */		
	public function wyswietl(){

		$colspan=4;
		$akcje_array=konf::get()->getAkcjeTab();

		echo "<div class=\"srodek szerokosc nowa_l\" style=\"padding-top:10px; padding-bottom:10px\">";
		echo tab_nagl(konf::get()->langTexty("akcje_testy"),$colspan);	
		
		echo "<tr class=\"grube lewa\">";
		echo "<td class=\"tlo4\">".konf::get()->langTexty("akcje_testy_modul")."</td>";
		echo "<td class=\"tlo4\">".konf::get()->langTexty("akcje_testy_akcja")."</td>";		
		echo "<td class=\"tlo4\">".konf::get()->langTexty("akcje_testy_czas")."</td>";			
		echo "<td class=\"tlo4\">".konf::get()->langTexty("akcje_testy_komunikat")."</td>";			
		echo "</tr>";
		
		while(list($key,$val)=each($akcje_array)){
			echo "<tr class=\"lewa\">";
			echo "<td class=\"tlo3\">".$val['modul']."</td>";
			echo "<td class=\"tlo3\">".$val['akcja']."</td>";				
			echo "<td class=\"tlo3\">".($val['stop']-$val['start'])."</td>";							
			echo "<td class=\"tlo3\">".konf::get()->langTexty($val['komunikat'])."</td>";					
			echo "</tr>";
		}

		echo "<tr><td class=\"male grube tlo4 lewa\" colspan=\"".$colspan."\">".konf::get()->langTexty("akcje_testy_ilezap")." ".count($akcje_array)."</td></tr>";
		echo "<tr><td class=\"male grube tlo4 lewa\" colspan=\"".$colspan."\">".konf::get()->langTexty("akcje_testy_czasc")." ".(round(tekstForm::microtimeOblicz(),7)-round(konf::get()->getKonfigTab('dane_start'),7))."</td></tr>";
		
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