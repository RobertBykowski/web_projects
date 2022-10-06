<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

konf::get()->setTekstyTab("u_texty");

//konfiguracja skryptu

//system aktywny - false blokuje system uzytkowników
$konfig_u['aktywne']=true;

//zapisuj logi
$konfig_u['log']=true;

//dla systemu użytkowników adresy www z ktorych mozna sie zalogowac (nie dotyczy localhost)
//jesli nie zdefiniowane to można logować się z każdego adresu 
$konfig_u['dozw_www']=array();
//$konfig_u['dozw_www'][]="budlex.com.pl";
//$konfig_u['dozw_www'][]="budlex.pl";

//czy jest mozliwosc zalogowania na stale - COOKIE (na ile dni)
$konfig_u['staly_log']=100;

//na jaki czas zapisywac SID w cookie (minut) 
//pozwala zamknac przegladarke i po chwili nadal zalogowany wrocic na www
$konfig_u['cookie']=360;

//autowylogowywanie, jesli >0 to po tylu minutach bezczynnosci automatycznie wyloguje uzytkownika 
$konfig_u['autowylog']=360;

//po ilu dniach autousuwanie kont
$konfig_u['autousuw']=0;

//po tylu minutach generuje nowy sid dla tego samego konta (0 - zawse nowy sid)
//mozliwosc na raz logowania sie kilku osob na jedno konto
$konfig_u['nowysid']=360;

//czy przedawnione konta usuwac (domyslnie zmieniac status)
$konfig_u['autousuw_delete']=false;

//logowanie za pomoca emaila
$konfig_u['email_login']=false;

//stale ip dla danego zalogowania
$konfig_u['staly_ip']=true;

//autousuwanie logów po ilu dniach 
$konfig_u['autousuw_log']=30;

//aby nie obciazac systemu rzadsze wykonywanie autosuwania
//losowo raz na X zalogowań uzytkownika 
//(puste lub =1 oznacza ze przy kazdym logowaniu)
$konfig_u['autousuw_rand']=10;

//czy tylko admin zaklada konta
$konfig_u['tylko_admin']=false;

//czy nowe konta domyslnie sa aktywne
//jesli nieaktywne to uzytkownik dostaje emaila z linkiem do potwierdzenia 
$konfig_u['new_aktywne']=true;

//ile max złych logowań w ciagu godziny
//w logach idtf "b_log" identyfikuje zle logowania 
$konfig_u['max_bad_log']=15;

//ile max nowych kont z jednego ip/host w ciagu godziny (
//nie dotyczny kont zakladanych przez admina)
$konfig_u['max_new']=15;

//czy uzytkownicy zbierają punkty
$konfig_u['punkty']=true;

//czy uzytkownicy moga glosowac na siebie
$konfig_u['glosy']=true;

//czy pobierac rozszerzone dane uzytkownika (false - pobiera tylko login haslo i email)
$konfig_u['rozs']=true;

//mozliwosc odzyskania konta przy zapomnianym hasle
//jesli true to wysyla emaila z kodem do odzyskania konta
$konfig_u['odzysk']=true;

//czy powiadamiac uzytkownika o niektorych akcjach
$konfig_u['powiadamianie']=true;

//aktywne banowanie IP
$konfig_u['banowanie']=true;

//wpisuj jako autora
$konfig_u['autor']=1;

//ile max uprawnien (dlugość pola w MySQL)
$konfig_u['ile_upr']=80;

//czy wysiwetlac palen informacyjny po zalogowaniu
$konfig_u['wys_panel']=true;

//domyslny status nowego uzytkownika, gdy sam zaklada konto
//lub gdy potwierdza zalozenie konta
$konfig_u['status_domyslny']=1;

//minimalna długosc hasla
$konfig_u['haslo_dl']=7;

//czy kodowac haslo w md5
$konfig_u['haslo_md5']=true;

//minimalna długosc loginu
$konfig_u['login_dl']=4;

//czy img
$konfig_u['img']=true;

//domyslny rozmiar skalowania img
$konfig_u['img1_size']=500;
$konfig_u['img1_skalatyp']=3; 

//max rozmiar
$konfig_u['img2_size']=120;
$konfig_u['img2_skalatyp']=3; 

//max rozmiar
$konfig_u['img3_size']=45;
$konfig_u['img3_skalatyp']=6; 

//minimalny wymiar grafiki
$konfig_u['img_min_size']=1;

//katalog na zdjecia
$konfig_u['kat']="pics/u/"; 

//dodatek do zmiennej u_sid
$konfig_u['sid_dodatek']="_admin4"; 

//dodatek do hasla kodowanego w md5
//uwaga nie zmieniac na dzialajacym systemie
$konfig_u['haslo_dodatek']="_admin"; 

//nr uprawnienia dla admina uzytkownikow
$konfig_u['upr_u']=1;

//nr uprawninia dla sdmina logow
$konfig_u['upr_log']=2;

//wyszukiwarka uzytkownikow
$konfig_u['wyszukiwarka']=true; 

//czy sprawdzac czarna liste
$konfig_u['czarna']=true;

//czy kodowac haslo w md5
$konfig_u['botproof']=true;

//czy wymagac zgody na wypelnienie regulaminu
$konfig_u['zgoda_regulamin']=true;

//czy wymagac zgody na przetwarzanie danych osobowych
$konfig_u['zgoda_osobowe']=true;

//czy pobierac dane o firmie
$konfig_u['firma']=true;

//czy mozna zmieniac login
$konfig_u['zmianalogin']=true;

//czy rozbijac edycje hasla, emiala na rozbite formulrze
$konfig_u['zmianarozbita']=true;

//czy potwierdzac zmiane emaila
$konfig_u['zmianapotwemail']=true;

//czy uzytkownik moze usunac swoje konto
$konfig_u['usuwanie']=true;

//czy udostepniac preferencje konta
$konfig_u['preferencje']=true;

//jaka wersja profilu
$konfig_u['profilprosty']=false;

//formularz opisowy dla konta
$konfig_u['opisowe']=true;

//jaka wersja profilu
$konfig_u['koment']=true;

//brak zdjecia
$konfig_u['img_brak0']="grafika/p.gif";
$konfig_u['img_brak1']="grafika/p1.gif";
$konfig_u['img_brak2']="grafika/p2.gif";

$konfig_u['statusy_tab']=array(
	1=>konf::get()->langTexty("u_statusy_tab1"),	//aktywne
	2=>konf::get()->langTexty("u_statusy_tab2"),	//oczekujace
	3=>konf::get()->langTexty("u_statusy_tab3"),	//nowe
	4=>konf::get()->langTexty("u_statusy_tab4"),	//przeterminowane
	5=>konf::get()->langTexty("u_statusy_tab5"),	//zablokowane
	6=>konf::get()->langTexty("u_statusy_tab6"),	//w moderacji
	7=>konf::get()->langTexty("u_statusy_tab7")		//usuniete
);


$konfig_u['statusy_kolory']=array(
	1=>"#ffffff",
	2=>"#f8fbc3",
	3=>"#c9f9d3",
	4=>"#c9eff9",
	5=>"#f9d2c9",
	6=>"#fdd7fc",
	7=>"#d2d1d1"
);

//typy kont
$konfig_u['typy_tab']=array(
	1=>konf::get()->langTexty("u_typy1"),    //admin
	2=>konf::get()->langTexty("u_typy2"),	   //superadmin
	3=>konf::get()->langTexty("u_typy3")     //zwykly user
);


//tablice dostepnosci nawzajem typow kont
$konfig_u['typydostepni_tab']=array(
	1=>array(1,3),
	2=>array(1,2,3),	
	3=>array(1,3)
);


//tablice dostepnosci nawzajem statusow kont
$konfig_u['typystatusydostepni_tab']=array(
	1=>array(1,5,6,7),
	2=>array(1,2,3,4,5,6,7),	
	3=>array(1)
);

//ktore typy uzytkownikow maja dostep do panelu admina
$konfig_u['typy_paneladmin']=array(1,2);

//domyslny typy konta dla nowo tworzonego przez zwyklego usera
$konfig_u['typy_domyslny']=3;

//domyslny typ w panelu admina
$konfig_u['typy_admindomyslny']=1;

//jak pobierac dane dla niezalogowanych (dla jakiego typu konta jest rownowazne)
$konfig_u['typy_niezalogowani']=3;

//czy mozna podgladac dane kont innych uzytkownikow (bez uprawien admina)
$konfig_u['konta_dostepne']=true;

//jaka wersja profilu
$konfig_u['galeria']=true;

//katalog na galerie
$konfig_u['galeria_kat']="pics/ugal/";		

//typ skakowania miniaturki
$konfig_u['galeria_skalowanie']=3;

//skalowanie
$konfig_u['galeria_img_size']=500;

//skalowanie
$konfig_u['galeria_min_size']=1;

//skalowanie miniaturki
$konfig_u['galeria_m_size']=120;

//oceny zdjec
$konfig_u['galeria_punkty']=false;

//licznik wyswietlen zdjec
$konfig_u['galeria_licznik']=false;

//opis zdjecia w adminie
$konfig_u['galeria_opis']=false;

//komentarze
$konfig_u['galeria_koment']=false;

//ile wierszy na podstronie (0 bez limitu)
$konfig_u['galeria_wiersz']=5;

//ile kolumn/zdjec w wierszu na podstronie (zwykle 1-10 zaleznie od szerokosci www)
$konfig_u['galeria_kolumna']=4;

//limit zdjec w galerii
$konfig_u['galeria_limit']=5;

$konfig_u['plec_tab']=array(
	1=>konf::get()->langTexty("u_plec1"),
	2=>konf::get()->langTexty("u_plec2")
);

$konfig_u['bany_typy'][1]=konf::get()->langTexty("u_b1");
$konfig_u['bany_typy'][2]=konf::get()->langTexty("u_b2");
$konfig_u['bany_typy'][3]=konf::get()->langTexty("u_b3");
$konfig_u['bany_typy'][4]=konf::get()->langTexty("u_b4");

/////////////////////////////////

//0-10 uprawnienia zarezerwowane dla systemu 
$konfig_u['uprawnienia'][0]=array("symbol"=>"glowny_admin", "opis"=>konf::get()->langTexty("u_u0"));
$konfig_u['uprawnienia'][1]=array("symbol"=>"uzytkownicy", "opis"=>konf::get()->langTexty("u_u1"));

if(!empty($konfig_u['u_banowanie'])){
	$konfig_u['uprawnienia'][2]=array("symbol"=>"logi", "opis"=>konf::get()->langTexty("u_u2"));
}

if(konf::get()->isMod('grupy')){
	$konfig_u['uprawnienia'][3]=array("symbol"=>"grupy", "opis"=>konf::get()->langTexty("u_u3"));
}

if(konf::get()->isMod('galerieadmin')){
	$konfig_u['uprawnienia'][4]=array("symbol"=>"galerie", "opis"=>konf::get()->langTexty("u_u4"));
}

//uprawnienia zdefiniowane dla konkretnego www

if(konf::get()->isMod('art')){
	$konfig_u['uprawnienia'][11]=array("symbol"=>"art", "opis"=>konf::get()->langTexty("u_u11"));
}
if(konf::get()->isMod('koment')){
	$konfig_u['uprawnienia'][12]=array("symbol"=>"komentarze", "opis"=>konf::get()->langTexty("u_u12"));
}
if(konf::get()->isMod('guestbook')){
	$konfig_u['uprawnienia'][13]=array("symbol"=>"guestbook", "opis"=>konf::get()->langTexty("u_u13"));
}
if(konf::get()->isMod('ankieta')){
	$konfig_u['uprawnienia'][15]=array("symbol"=>"ankieta", "opis"=>konf::get()->langTexty("u_u15"));
}
if(konf::get()->isMod('subs')){
	$konfig_u['uprawnienia'][16]=array("symbol"=>"subs", "opis"=>konf::get()->langTexty("u_u16"));
}
if(konf::get()->isMod('rotator')){
	$konfig_u['uprawnienia'][17]=array("symbol"=>"rotator", "opis"=>konf::get()->langTexty("u_u17"));
}
if(konf::get()->isMod('art')){
	$konfig_u['uprawnienia'][18]=array("symbol"=>"art_dostep", "opis"=>konf::get()->langTexty("u_u18"));
}
if(konf::get()->isMod('forum')){
	$konfig_u['uprawnienia'][19]=array("symbol"=>"forum", "opis"=>konf::get()->langTexty("u_u19"));
}
if(konf::get()->isMod('sklep')){
	$konfig_u['uprawnienia'][20]=array("symbol"=>"sklep", "opis"=>konf::get()->langTexty("u_u20"));
	$konfig_u['uprawnienia'][21]=array("symbol"=>"zamowienia", "opis"=>konf::get()->langTexty("u_u21"));	
}


switch(konf::get()->getKonfigTab('strona_typ')){

	case 'cms':
		$konfig_u['staly_log']=0;
		$konfig_u['cookie']=60;
		$konfig_u['autowylog']=60;
		$konfig_u['autousuw']=0;
		$konfig_u['nowysid']=60;
		$konfig_u['tylko_admin']=true;
		$konfig_u['punkty']=false;
		$konfig_u['glosy']=false;	
		$konfig_u['banowanie']=false;		
		$konfig_u['rozs']=false;
		$konfig_u['odzysk']=false;
		$konfig_u['img']=false;
		$konfig_u['typy_domyslny']=1;	
		$konfig_u['konta_dostepne']=false;		
		$konfig_u['zmianalogin']=true;
		$konfig_u['zmianarozbita']=false;
		$konfig_u['zmianapotwemail']=false;		
		$konfig_u['zmianalogin']=false;
		$konfig_u['zmianarozbita']=false;
		$konfig_u['zmianapotwemail']=false;
		$konfig_u['usuwanie']=false;
		$konfig_u['preferencje']=false;
		$konfig_u['profilprosty']=true;
		$konfig_u['koment']=false;		
		$konfig_u['galeria']=false;	
		$konfig_u['opisowe']=false;
		$konfig_u['koment']=false;		
	break;
	
	case 'sklep':	
		$konfig_u['staly_log']=0;
		$konfig_u['cookie']=60;
		$konfig_u['autowylog']=60;
		$konfig_u['autousuw']=0;
		$konfig_u['nowysid']=60;
		$konfig_u['punkty']=true;
		$konfig_u['banowanie']=false;		
		$konfig_u['rozs']=true;
		$konfig_u['odzysk']=true;
		$konfig_u['img']=false;
		$konfig_u['typy_domyslny']=3;	
		$konfig_u['status_domyslny']=1;			
		$konfig_u['konta_dostepne']=false;		
		$konfig_u['glosy']=false;		
		$konfig_u['zmianalogin']=true;
		$konfig_u['zmianarozbita']=false;
		$konfig_u['zmianapotwemail']=false;		
		$konfig_u['zmianalogin']=false;
		$konfig_u['zmianarozbita']=false;
		$konfig_u['zmianapotwemail']=false;
		$konfig_u['usuwanie']=false;
		$konfig_u['preferencje']=false;
		$konfig_u['profilprosty']=true;
		$konfig_u['koment']=false;
		$konfig_u['galeria']=false;		
		$konfig_u['opisowe']=false;
		$konfig_u['koment']=false;	
		$konfig_u['new_aktywne']=false;					
	break;

	case 'portal':
		$konfig_u['staly_log']=0;
		$konfig_u['cookie']=60;
		$konfig_u['autowylog']=60;
		$konfig_u['autousuw']=0;
		$konfig_u['nowysid']=60;
		$konfig_u['punkty']=false;
		$konfig_u['banowanie']=false;		
		$konfig_u['rozs']=true;
		$konfig_u['odzysk']=true;
		$konfig_u['img']=true;
		$konfig_u['typy_domyslny']=3;	
		$konfig_u['status_domyslny']=1;			
		$konfig_u['konta_dostepne']=true;		
		$konfig_u['glosy']=false;		
		$konfig_u['zmianalogin']=true;
		$konfig_u['zmianarozbita']=true;
		$konfig_u['zmianapotwemail']=true;		
		$konfig_u['zmianalogin']=true;
		$konfig_u['zmianarozbita']=true;
		$konfig_u['zmianapotwemail']=true;
		$konfig_u['usuwanie']=true;
		$konfig_u['preferencje']=true;
		$konfig_u['profilprosty']=false;
		$konfig_u['koment']=true;
		$konfig_u['galeria']=true;	
		$konfig_u['opisowe']=true;
		$konfig_u['koment']=true;			
		$konfig_u['galeria_koment']=true;		
		$konfig_u['new_aktywne']=false;						
	break;
}

konf::get()->setKonfigTab(array("u_konf"=>$konfig_u));


?>