<?php

/**
 * rss dla art i news
 */
	
header("Content-Type: text/xml; charset=utf-8");

//ustawienia cashowania w przegladarkach
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: post-check=0, pre-check=0",false);

define("SPR_INCLUDE","tak");

include_once("inc/konfig.php");
include_once($konfig['inc']."_init_inc.php");

//generator akcji
require_once(konf::get()->getKonfigTab('klasy')."class.generator.php");

konf::get()->setAkcja("art_rss");

$generator=new generator();
$generator->obStart();
$generator->akcje();
$generator->obStop();

?>