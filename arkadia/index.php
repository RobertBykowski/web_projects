<?php

/**
 * glowny plik index
 */

header("Content-Type: text/html; charset=utf-8");

//ustawienia cashowania w przegladarkach
header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: post-check=0, pre-check=0",false);

#header("Cache-Control", "Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0");
#header("Pragma", "no-cache");
#header("Expires", 0); 

define("SPR_INCLUDE","tak");

//konfiguracja
include_once("inc/konfig.php");

//inicjalizacja
include_once($konfig['inc']."_init_inc.php");

//generator akcji
require_once(konf::get()->getKonfigTab('klasy')."class.generator.php");

$generator=new generator2();
$generator->obStart();
$generator->akcje();
$generator->obStop();


?>