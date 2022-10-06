<?php

//==================================

//skrypt konfiguracji serwisu www

//autor JWJ (jwaldek@poczta.onet.pl)

//==================================



if(!defined("SPR_INCLUDE")){

  header("Location: ../index.php");

}





//rozpoznawanie wersji php

$konfig['wersja_php']=(substr(phpversion(),0,1))+0;

if($konfig['wersja_php']!=5){

	$konfig['wersja_php']=4;

} else if ($konfig['wersja_php']>4){



	//strefa czasowa dla php 5

	if(function_exists("date_default_timezone_set")){

		date_default_timezone_set("Europe/Warsaw");

	} else {

		putenv("TZ=Europe/Warsaw");

	}



}



session_set_cookie_params (332600,"/");

ini_set("session.cookie_httponly",1);

ini_set("session.gc_maxlifetime",333600);

ini_set("session.cookie_lifetime",333600);

ini_set("session.cookie_httponly", 1);

//ini_set("url_rewriter.tags","");

//ini_set('session.use_trans_sid', 'Off');

session_cache_limiter("must-revalidate");

ini_set("session.gc_divisor", "1");

ini_set("session.gc_probability", "1");

//polityka cookies

header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"');

//ustawienia zmiennych

ini_set("register_globals", "off");

ini_set("magic_quotes_gpc", "off");

ini_set("magic_quotes_runtime", "off");

//set_magic_quotes_runtime(0);



//czysta tablica konfiguracyjna

if(isset($konfig)){

	unset($konfig);

}



//czy windows

$konfig['windows']=getenv("windir");



//czy pokazywac bledy

$konfig['bledywys']=$konfig['windows'];



//konfiguracja dla windows (local server)

if(!empty($konfig['windows'])){



	//bledy

	error_reporting(E_ALL|E_STRICT);



	$konfig['sciezka']="http://127.0.0.1/arkadia/";

	$konfig['serwer']=getenv("DOCUMENT_ROOT")."/arkadia/";



	$konfig['mysql_user']="root";

	$konfig['mysql_haslo']="sfg";

	$konfig['mysql_serwer']="localhost";

	$konfig['mysql_baza']="arkadia";

	$konfig['mysql_charset']="utf8";

	$konfig['mysql_port']="";



  //katalog edytora

  $konfig['edytor']="/arkadia/edytor/";



  //katalog na uploadowane pliki

  $konfig['upload']="/arkadia/upload/";



//konfiguracja online (linux)

} else {



	//bledy

	error_reporting(E_ALL);

	//error_reporting(0);



	$konfig['sciezka']="http://".$_SERVER['HTTP_HOST']."/";

//	$konfig['sciezka']="http://cms.studiostron.eu/";

  $konfig['serwer']=getenv("DOCUMENT_ROOT");

	if(substr($konfig['serwer'], -1, 1)!="/"){

		$konfig['serwer'].="/";

	}

	//$konfig['serwer']="";



	$konfig['mysql_user']="35239944_1";

	$konfig['mysql_haslo']="tomaszek75";

	$konfig['mysql_serwer']="localhost";

	$konfig['mysql_baza']="35239944_1";

	$konfig['mysql_charset']="utf8";

	$konfig['mysql_port']="";



  //katalog edytora

  $konfig['edytor']="/edytor/";



  //katalog na uploadowane pliki

  $konfig['upload']="/upload/";



}



//kodowanie znakow

$konfig['charset']="utf-8";

if(function_exists("mb_internal_encoding")){

	mb_internal_encoding($konfig['charset']);

}





//prefiks tabel SQL

$_mysql_przed="arkadia_";



//tabele mysql

$konfig["sql_tab"]['art']=$_mysql_przed."art";									 //tabela artykulow

$konfig["sql_tab"]['artd']=$_mysql_przed."artd";									 //tabela artykulow

$konfig["sql_tab"]['art_akapity']=$_mysql_przed."art_akapity";			//tablea akapitow

$konfig["sql_tab"]['art_akapityd']=$_mysql_przed."art_akapityd";			//tablea akapitow

$konfig["sql_tab"]['art_koment']=$_mysql_przed."art_koment";		//tabela komentarzy

$konfig["sql_tab"]['art_galeria']=$_mysql_przed."art_galeria";		//tabela komentarzy

$konfig["sql_tab"]['ankieta']=$_mysql_przed."ankieta";					 //tytuly ankiet

$konfig["sql_tab"]['ankieta_list']=$_mysql_przed."ankieta_list"; //pytania ankiet

$konfig["sql_tab"]['ankieta_glosy']=$_mysql_przed."ankieta_glosy"; //glosy ankiet

$konfig["sql_tab"]['uzytkownicy']=$_mysql_przed."uzytkownicy";			//tabel uzytkownikow

$konfig["sql_tab"]['uzytkownicy_galeria']=$_mysql_przed."uzytkownicy_galeria";			//tabela galerii  uzytkownikow

$konfig["sql_tab"]['uzytkownicy_koment']=$_mysql_przed."uzytkownicy_koment";		//tabela komentarzy

$konfig["sql_tab"]['uzytkownicy_galeria_koment']=$_mysql_przed."uzytkownicy_galeria_koment";		//tabela komentarzy

$konfig["sql_tab"]['logi']=$_mysql_przed."logi";										//table zapisywanych logow

$konfig["sql_tab"]['bany']=$_mysql_przed."bany";										//tabela filtra IP

$konfig["sql_tab"]['subskrypcja']=$_mysql_przed."subskrypcja";               //emaile do subskrypcji

$konfig["sql_tab"]['subskrypcja_w']=$_mysql_przed."subskrypcja_wiadomosci";  //wygenerowane wiadomosci

$konfig["sql_tab"]['subskrypcja_pliki']=$_mysql_przed."subskrypcja_pliki";   //pliki zalacznikow

$konfig["sql_tab"]['forum_d']=$_mysql_przed."forum_d";

$konfig["sql_tab"]['forum_t']=$_mysql_przed."forum_t";

$konfig["sql_tab"]['forum_p']=$_mysql_przed."forum_p";

$konfig["sql_tab"]['guestbook']=$_mysql_przed."guestbook";

$konfig["sql_tab"]['rotator']=$_mysql_przed."rotator";

$konfig["sql_tab"]['konfig']=$_mysql_przed."konfig";

$konfig["sql_tab"]['poczta']=$_mysql_przed."poczta";

$konfig["sql_tab"]['znajomi']=$_mysql_przed."znajomi";

$konfig["sql_tab"]['zablokowani']=$_mysql_przed."zablokowani";

$konfig["sql_tab"]['sklep_kat']=$_mysql_przed."sklep_kat";

$konfig["sql_tab"]['sklep_produkty']=$_mysql_przed."sklep_produkty";

$konfig["sql_tab"]['sklep_produkty_koment']=$_mysql_przed."sklep_produkty_koment";

$konfig["sql_tab"]['sklep_producenci']=$_mysql_przed."sklep_producenci";

$konfig["sql_tab"]['sklep_zamowienia']=$_mysql_przed."sklep_zamowienia";

$konfig["sql_tab"]['sklep_zamowienia_produkty']=$_mysql_przed."sklep_zamowienia_produkty";

$konfig["sql_tab"]['grupy']=$_mysql_przed."grupy";

$konfig["sql_tab"]['grupy_galeria']=$_mysql_przed."grupy_galeria";

$konfig["sql_tab"]['grupy_galeria_koment']=$_mysql_przed."grupy_galeria_koment";

$konfig["sql_tab"]['grupy_uzytkownicy']=$_mysql_przed."grupy_uzytkownicy";



//moduly

$konfig['mod']['pasekreklama']=false;

$konfig['mod']['sqllista']=!empty($konfig['windows']);

$konfig['mod']['akcjelista']=!empty($konfig['windows']);

$konfig['mod']['art']=true;

$konfig['mod']['artadmin']=true;

$konfig['mod']['artdziennik']=false;

$konfig['mod']['ankieta']=false;

$konfig['mod']['ankietaadmin']=false;

$konfig['mod']['forum']=false;

$konfig['mod']['subs']=false;

$konfig['mod']['subsadmin']=false;

$konfig['mod']['guestbook']=false;

$konfig['mod']['u']=true;

$konfig['mod']['ugal']=true;

$konfig['mod']['uadmin']=true;

$konfig['mod']['koment']=false;

$konfig['mod']['komentadmin']=false;

$konfig['mod']['rotator']=false;

$konfig['mod']['rotatoradmin']=false;

$konfig['mod']['kontakt']=false;

$konfig['mod']['konfigadmin']=true;

$konfig['mod']['poczta']=false;

$konfig['mod']['znajomi']=false;

$konfig['mod']['sklep']=false;

$konfig['mod']['sklepadmin']=false;

$konfig['mod']['producenciadmin']=false;

$konfig['mod']['produktyadmin']=false;

$konfig['mod']['zamowieniaadmin']=false;

$konfig['mod']['zamowienia']=false;

$konfig['mod']['koszyk']=false;

$konfig['mod']['grupy']=false;

$konfig['mod']['grupyadmin']=false;

$konfig['mod']['grupygal']=false;

$konfig['mod']['galerieadmin']=false;



//data rozpoczecia prac nad www

$konfig['data_start']="2010-01-10";



//typ strony - cms , sklep, portal

$konfig['strona_typ']="cms";



//czy wyswietlac branding - login i link w stopce cms

$konfig['cms_branding']=true;



//katalogi na includowane php

$konfig['inc']=$konfig['serwer']."inc/";



//katalog - klasy

$konfig['klasy']=$konfig['serwer']."klasy/";



//tlumaczenia jezykowe

$konfig['lang']=$konfig['serwer']."lang/";



//katalog na banery z rotatora

$konfig['rotator_kat']="pics/rotator/";



//katalog z kalendarzem

$konfig['kalendarz_kat']=$konfig['sciezka']."js/kalendarz/";

$konfig['kalendarz_lang']="pl-utf8";



//informacyjne o serwisie www

$konfig['admin_email']="kontakt@jw-webdev.info";

$konfig['kontakt_email']="kontakt@jw-webdev.info";

$konfig['kontakt_nadawca']="kontakt@jw-webdev.info";

$konfig['nazwa_www']="CMS - System administracji trescia serwisu www";

$konfig['adres_www']=$konfig['sciezka'];



$konfig['autor']="JW Web Development";

$konfig['autor_email']="kontakt@jw-webdev.info";



$konfig['tytul']=$konfig['nazwa_www'];

$konfig['tytul_przedrostek']="";

$konfig['tytul_przedrostek_koniec']=false;  //dla title czy dawac przedrostek na koncu

$konfig['description']="";

$konfig['keywords']="";

$konfig['kodfooter']="";

$konfig['kodheader']="";

$konfig['kodonload']="";

$konfig['kodstat']="";



$konfig['chat']=0;



//ustawienia wysylania emaili metoda smtp

$konfig['kontakt_smtp_host']="";

$konfig['kontakt_smtp_user']="";

$konfig['kontakt_smtp_haslo']="";

$konfig['kontakt_smtp_secure']=""; //ssl

$konfig['kontakt_smtp_port']="";



//szabon graficzny do emaili

$konfig['kontakt_szablon']="";

$konfig['kontakt_html']=true;

$konfig['kontakt_grafiki']=array();



//przyklady

//$konfig['kontakt_grafiki'][1]=array("plik"=>"tlo.gif","cid"=>"tlogif","typ"=>,"image/gif");

//$konfig['kontakt_grafiki'][2]=array("plik"=>"top.jpg","cid"=>"topjpg","typ"=>,"image/jpeg");

// uzywac np w formie <img src=\"cid:topjpg\" />



//graniczne domyslne  rozmiary uploadowanych grafik

$konfig['fotka_max']=550; 	//max rozmiar, powyzej skalowane lub odrzucane

$konfig['fotka_min']=10;		//min rozmiar, ponizej odrzucane (z wyjatkiem SWF)

$konfig['size_max']=1536000; //150kb, nie dotyczy skalowanych JPG, PNG

$konfig['fotka_mini']=120;	//rozmiar miniaturki w newsach



//prawidlowe rozszerzenia plikow graficznych: gif,jpg,png,swf,bmp: 1,2,3,4,13,6

//po jakimi beda zapisywane po uploadzie

$konfig['roz'][1]="gif";

$konfig['roz'][2]="jpg";

$konfig['roz'][3]="png";

$konfig['roz'][4]="swf";

$konfig['roz'][6]="bmp";

$konfig['roz'][13]="swf";



//obsluga jezykow

$konfig['przenies_lang']=true;

$konfig['lang_default']=1;

$konfig['lang_name']="lang";



//nie zmieniac indeksow

$konfig['tab_lang']=array(

1=>"pl",

2=>"en",

3=>"de",

//4=>"fr",

//5=>"it",

//6=>"ru",

);





//obsluga jezykow - panel admina

$konfig['lang2_default']=1;



//nie zmieniac indeksow

$konfig['tab_lang2']=array(

	1=>"pl",

//	2=>"en",

//	3=>"de",

);



//panel admina styl

$konfig['styl_default']=1;



//nie zmieniac indeksow 1-niebieski 2-siwy 3-czarny 4-zielony 5-czerowny 6-brazowy

$konfig['tab_styl']=array(

	1=>"1e53ec",

	2=>"dcdfe7",

	3=>"414244",

	4=>"0eaf30",

	5=>"e10b10",

	6=>"937559",

);



//mozliwosc tworzenia przyjaznych linkow

$konfig['mod_rewrite']=true;



//pasek uzywany w statystykach. [WIDTH] jest w nim zamieniane na dlugosc jaka ma miec w statystyce

//$konfig['pasek_stat']="<img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/pasek.jpg\" height=\"7\" width=[WIDTH] alt=\"\" style=\"vertical-align:middle\" style=\"margin-right:3pt\" />";

$konfig['pasek_stat']="<div style=\"padding:3px; padding-left:0px;\"><div style=\"height:3px; width:[WIDTH]px; background-color:#d5550f; border:1px solid #000000; font-size:1px\"></div></div>";



//parametry nawigacji

$konfig['nawig_podstron']=6;					//ile stron na raz (*2+1)



//antyspam

$konfig['g_kodhash']="g_kodhash";					//zmienna zawierajaca hash

$konfig['g_kod']="g_kod";									//zmienna wpisany kod

$konfig['g_kodencrypt']="g_kodencrypt"; 	//zmienna zakodowany kod

$konfig['g_kodprefix']="ih7t8tuihg67r7"; 	//zmienna prefix

$konfig['g_znakow']=5; 										//ile znakow



//wojewodztwa

$konfig['woj_tab']=array(

	1=>"dolnośląskie",

	2=>"kujawsko-pomorskie",

	3=>"lubelskie",

	4=>"lubuskie",

	5=>"łódzkie",

	6=>"małopolskie",

	7=>"mazowieckie",

	8=>"opolskie",

	9=>"podkarpackie",

	10=>"podlaskie",

	11=>"pomorskie",

	12=>"śląskie",

	13=>"świętokrzyskie",

	14=>"warmińsko-mazurskie",

	15=>"wielkopolskie",

	16=>"zachodniopomorskie"

);



//mc

$konfig['mc_tab']=array(

	1=>"styczeń",

	2=>"luty",

	3=>"marzec",

	4=>"kwiecień",

	5=>"maj",

	6=>"czerwiec",

	7=>"lipiec",

	8=>"sierpień",

	9=>"wrzesień",

	10=>"październik",

	11=>"listopad",

	12=>"grudzień",

);







//katalog na moduly

$konfig['mod_kat']=$konfig['serwer']."mod/";



//katalog na szablony

$konfig['szablony_kat']=$konfig['serwer']."szablony/";



//domyslna akcja, szablon, wgrywane moduly

switch($konfig['strona_typ']){



	case 'portal':

		$konfig['akcja_domyslna']="u_powitalna";

		$konfig['szablon_domyslny']="portal";

		$konfig['mod_domyslne']=array("art","ankieta","rotator","u");

	break;



	case 'sklep':

		$konfig['akcja_domyslna']="sklep_powitalna";

		$konfig['szablon_domyslny']="sklep";

		$konfig['mod_domyslne']=array("art","ankieta","rotator","sklep");

	break;



	default:

		$konfig['akcja_domyslna']="art_powitalna";

		$konfig['szablon_domyslny']="domyslny";

		$konfig['mod_domyslne']=array("art","ankieta","rotator");

}





?>
