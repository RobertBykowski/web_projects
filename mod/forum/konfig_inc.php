<?php
//konfiguracja ksiegi gosci 

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

konf::get()->setTekstyTab("forum_texty");


$konfig_forum['admin_forum']=user::get()->upr(19);

//ile tematow na podstronie
$konfig_forum['t_na_str']=20;

//ile postów na podstronie 0 - bez limitu
$konfig_forum['p_na_str']=30;

//ile tematow na starcie (gdy nie wybrany dzial) 0-brak, tylko lista dzialow
$konfig_forum['t_start_na_str']=20;

//dostep do formularza wpisu tematu
$konfig_forum['nowy_t_dostep']=user::get()->zalogowany();

//czy wyświetlac dzialy
$konfig_forum['wys_d']=true;

//dostep do statystyk
$konfig_forum['wys_stat']=true;

//akcja logowania
$konfig_forum['akcja_log']="u_zaloguj";

//czy obrazki jpg w tresci postow
$konfig_forum['img']=user::get()->zalogowany();

//dostep do dodawania obrazkow
$konfig_forum['img_dostep']=user::get()->zalogowany();

//umieszczenie img w tekscie poprzez symbol
$konfig_forum['img_symbol']="[img]";

//katalog na jpg
$konfig_forum['img_kat']="pics/forum/";

//skalowanie jpg na wymiar
$konfig_forum['img_max']=450;

////minimalny rozmiar grafiki
$konfig_forum['img_min']=20;

//max rozmiar w kb
$konfig_forum['img_kb_max']=120*1024;

//miesieczny limit obrazkow od jednej osoby 0-bez limitu
$konfig_forum['img_limit']=10;

//czy wyswietlac ip
$konfig_forum['wys_ip']=true;

//dostęp do danych uzytkownika
$konfig_forum['user_dane']=$konfig_forum['admin_forum'];

//czy liczyc wejscia do tematu
$konfig_forum['licznik']=true;

//ile aktualnych tematow na starcie
$konfig_forum['t_start']=10;

//tlo na naglowek
$konfig_forum['tytul_class']="tlo2";

//tlo na naglowek
$konfig_forum['naglowek_class']="tlo4";

//tlo na tresc
$konfig_forum['tresc_class']="tlo3";

//tagi html, które nie zostaną usunięte  
$konfig_forum['zostaw_tagi']="<b><i><br>";

//autolink http i @
$konfig_forum['autolink']=true;

//ile znakow w linii
$konfig_forum['linia_znakow']=45;

//pomoc html
$konfig_forum['html_hlp']=true;

//graficzne emotikony
$konfig_forum['emotikony']=true;

//wchodzimy na najnowszy post
$konfig_forum['najnowszy']=true;

//cenzurowanie
$konfig_forum['cenzura']=true;

//domyslny dzial
$konfig_forum['default_d']="";

//legenda
$konfig_forum['wys_legenda']=true;

//wyszukiwarka
$konfig_forum['wys_szukaj']=true;

//czy dostepne typy forum
$konfig_forum['typy']=true;

//ile znakow w wyszukiwanym poscie
$konfig_forum['szukaj_dl']=200;

//bb code
$konfig_forum['bbcode']=true;

//domyslny typ
$konfig_forum['forum_domyslny_typ']=2;

//typy tematów
$konfig_forum['typy_tab'][1]=array("opis"=>konf::get()->langTexty("forum_typy1"),"ikonka"=>"<img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/folder1.gif\" width=\"17\" height=\"15\" border=\"0\" alt=\"\" align=\"absmiddle\" />");
$konfig_forum['typy_tab'][2]=array("opis"=>konf::get()->langTexty("forum_typy2"),"ikonka"=>"<img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/folder2.gif\" width=\"17\" height=\"15\" border=\"0\" alt=\"\" align=\"absmiddle\" />");
$konfig_forum['typy_tab'][3]=array("opis"=>konf::get()->langTexty("forum_typy3"),"ikonka"=>"<img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/folder3.gif\" width=\"17\" height=\"15\" border=\"0\" alt=\"\" align=\"absmiddle\" />");
if(!empty($konfig_forum['admin_forum'])){
	$konfig_forum['typy_tab'][4]=array("opis"=>konf::get()->langTexty("forum_typy4"),"ikonka"=>"<img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/folder4.gif\" width=\"17\" height=\"15\" border=\"0\" alt=\"\" align=\"absmiddle\" />");
	$konfig_forum['typy_tab'][5]=array("opis"=>konf::get()->langTexty("forum_typy5"),"ikonka"=>"<img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/folder5.gif\" width=\"17\" height=\"15\" border=\"0\" alt=\"\" align=\"absmiddle\" />");
}

konf::get()->setKonfigTab(array("forum_konf"=>$konfig_forum));

?>