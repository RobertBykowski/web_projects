<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

//dla pozycjonowaia, pozvycie sie adresow z widocznym index.php
if ($_SERVER['REQUEST_URI']=='/index.php' && $_SERVER['QUERY_STRING']==''&&empty($_POST)) {
	header("HTTP/1.1 301 Moved Permanently"); 
	header("location: ".$konfig['sciezka']);
	header("Connection: close");
	exit;
}

//zabezpieczenie przed podmiana cookie session (zabezpiecza invalid characters error)
if(!empty($_COOKIE[session_name()])&&!preg_match("/^[0-9a-zA-Z]{1,256}$/",$_COOKIE[session_name()])){

	//losuje 30 liczb
	$id=$_COOKIE[session_name()];
	for ($i=1; $i<=30; $i++){ 
		$id.=round(rand(0,9));
	}
	$id=md5($id.date("Y-m-d"));	
	$_COOKIE[session_name()]=$id;
	session_id($id);
	
}

//poczatek sesji
if(!isset($_SESSION)){
	session_start();
}

//inicjujemy obsluge bledow
require_once($konfig['klasy']."class.bledy.php");
$blad=new Bledy();
$blad->setFolder($konfig['serwer']."logs/");
$blad->setEmail($konfig['admin_email']);
$blad->setEmailTytul("blad na ".$konfig['nazwa_www']);	

$blad->setZapisuj(array(
	1=>"E_WARNING", 
	2=>"E_NOTICE", 
	3=>"E_USER_ERROR",
  4=>"E_USER_WARNING",
	5=>"E_USER_NOTICE",	
));

//8=>"E_STRICT"		

if(!empty($konfig['bledywys'])){
	$blad->setWyswietl(array(
		1=>"E_WARNING", 
  	2=>"E_NOTICE", 
		3=>"E_USER_ERROR",
	  4=>"E_USER_WARNING",
		5=>"E_USER_NOTICE",
		7=>"E_STRICT",
		8=>"E_RECOVERABLE_ERROR",		
	));	
} else {
	$blad->setWyswietl(array(
		3=>"E_USER_ERROR",
	  4=>"E_USER_WARNING",
		5=>"E_USER_NOTICE",
	));	
}

set_error_handler(array($blad,"dodajSystemowe"));
//trigger_error("dodajBlad: test",E_USER_ERROR);

//obsluga funkcji tekstowych
require_once($konfig['klasy']."class.tekstform.php");

//obsluga konfiguracji www
require_once($konfig['klasy']."class.konf.php");
konf::get($konfig);

//szkielet modulu
require_once($konfig['klasy']."class.moduladmin.php");

//zmiana jezyka
$lang=konf::get()->getZmienna('lang','lang');
if(!empty($lang)){
	konf::get()->setLang($lang);
}

//inicjujemy baze danych
if(konf::get()->getKonfigTab('mysql_baza')){

	require_once(konf::get()->getKonfigTab('klasy')."class.bazasql.php");
	$bazasql=new bazaSql(konf::get()->getKonfigTab('mysql_serwer'),konf::get()->getKonfigTab('mysql_user'),konf::get()->getKonfigTab('mysql_haslo'),konf::get()->getKonfigTab('mysql_baza'));		
	$bazasql->setCharset(konf::get()->getKonfigTab('mysql_charset'));
	$bazasql->setPort(konf::get()->getKonfigTab('mysql_port'));		
	$bazasql->polacz();		
	konf::get()->setBazasql($bazasql);

	//odczyt konfiguracji www z bazdy danych
	if(konf::get()->isMod("konfigadmin")){
		konf::get()->odczyt();
	}
	
}

//domyslny szablon
konf::get()->setSzablon("");

//domyslnie zaladowane podstawowe komunikaty
konf::get()->setTekstyTab("texty");

//formularze
require_once(konf::get()->getKonfigTab('klasy')."class.formularz.php");

//swf
require_once(konf::get()->getKonfigTab('klasy')."class.swf.php");

//uniwersalna nawigacja
require_once(konf::get()->getKonfigTab('klasy')."class.nawig.php");

//interfejs - ikonki itp
require_once(konf::get()->getKonfigTab('klasy')."class.interfejs.php");

//system uzytkownikow
if(konf::get()->isMod("u")){

	require_once(konf::get()->getKonfigTab('klasy')."class.user.php");	
	//inicjalizacja
	user::get();
	
}

if(konf::get()->isMod('rotator')){
	require_once(konf::get()->getKonfigTab('klasy')."class.banery.php");
}

//jelsi istnieje id artykul to domyslnie odczytuje akcje art_zobacz
if(!konf::get()->getAkcja()&&(konf::get()->getZmienna('id_art','id_art')||konf::get()->getZmienna('art_idtf','art_idtf'))){

	konf::get()->setAkcja("art_zobacz");	
	
}

//domyslnie zmienia nazwe akcji kontakt na => kontakt_formularz 
//zrobione dla czytelnosci linku
if(konf::get()->getAkcja()=="kontakt"){
	konf::get()->setAkcja("kontakt_formularz");
}


?>