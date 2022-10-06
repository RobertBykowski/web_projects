<?php

/**
 * rysuje obrazek captcha
 */

define("SPR_INCLUDE",true);

header("Content-Type: text/html; charset=utf-8");

include_once("inc/konfig.php");	
require_once($konfig['klasy'].'class.bledy.php');	

//inicjujemy obsluge bledow
$blad=new Bledy();

$blad->setWyswietl(array(
	1=>"E_WARNING", 
	2=>"E_NOTICE", 
	3=>"E_USER_ERROR",
  4=>"E_USER_WARNING",
	5=>"E_USER_NOTICE"			
));

set_error_handler(array($blad,"dodajSystemowe"));	

require_once($konfig['klasy'].'class.botproof.php');

if(!empty($_GET[$konfig['g_kodencrypt']])){
	$proof=new botProof($konfig['g_kodprefix']);
	$proof->setMargines(10);
	$proof->setLinie(20);	
	$proof->setImgTlo($konfig['serwer']."grafika/botproof/szumy.jpg");
	$proof->setZnakKolor(array(array(23,134,230),array(23,324,30),array(230,14,20),array(0,0,0)));
	$proof->setTlo(array(255,233,233));
	//$proof->setCzcionka(5);	
	$proof->setPlikTTF($konfig['serwer']."grafika/botproof/verdana.ttf");
	$proof->setRozmiar(24);
	//$proof->setDuze(false);		
	$proof->setGKod($_GET[$konfig['g_kodencrypt']],true);	
	//echo $proof->getGKod();
	$proof->obrazek();
}
	
	
?>