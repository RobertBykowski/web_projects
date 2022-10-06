<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

konf::get()->setTekstyTab("subs_texty");

//w administracji ile rekordow na stronie
$konfig_subs['subs_na_str']=25;

//w administracji ile wiadomosci na stronie
$konfig_subs['w_na_str']=25;

//domyslne zaznaczone wszystkie kategorie subskrypcji
$konfig_subs['kat_zaznaczone']=true;

//czy do wyboru jest opcja dodaj/usun email
$konfig_subs['zapisz_wypisz']=true;

//edytor
$konfig_subs['edytor']=true;

//wiadomosc w formie html
$konfig_subs['html']=true;

//upload zalacznikow (max ilosc)
$konfig_subs['zalacznik']=5;

//zmiana adresow plikow
$konfig_subs['fraza_old']="/upload/";

//zamiana na 
$konfig_subs['fraza_new']=konf::get()->getKonfigTab("sciezka")."upload/";

//domyslny poczatek i koniec emaila
$konfig_subs['szablon']="<html><head><meta http-equiv=\"Content-type\" content=\"text/html; charset=utf-8\"></head><body bgcolor=\"white\"><TRESC></body></html>";

//domyslny temat
$konfig_subs['temat']=konf::get()->langTexty("subs_temat");

//domyslny tekst subskrypcji
$konfig_subs['tekst']=konf::get()->langTexty("subs_domyslny");

//czy uzywac kroku z potwierdzaniem emaila
$konfig_subs['potwierdzony']=true;

//czy email domyslnie aktywny
//nie dotyczny emaili wymagajacych potwierdzenia
$konfig_subs['email_aktywny']=true;

//autousuwanie niepotwierdzonych emaili
$konfig_subs['autousuw']=30;

$konfig_subs['grafiki']=array();
//$konfig_subs['grafiki'][1]=array("plik"=>"tlo.gif","cid"=>"tlogif","typ"=>,"image/gif");
//$konfig_subs['grafiki'][2]=array("plik"=>"top.jpg","cid"=>"topjpg","typ"=>,"image/jpeg");

///dane przy wysylanym emailu
$konfig_subs['nadawca_email']=konf::get()->getKonfigTab("kontakt_email");
$konfig_subs['nadawca']=konf::get()->getKonfigTab("kontakt_email");
$konfig_subs['odbiorca']=konf::get()->getKonfigTab("kontakt_email");
$konfig_subs['odbiorca_email']=konf::get()->getKonfigTab("kontakt_email");

//wyslylanie paczek emaili 0-bez paczkowania
$konfig_subs['paczki']=1;

//ile emaili w paczce
$konfig_subs['paczki_ile']=50;

$konfig_subs['kat']="pics/subs/";

//wyslylanie paczek emaili - czas na paczke (sekund)
$konfig_subs['paczki_czas']=5;

//grupy emaili
$konfig_subs['typy_tab'][1]=konf::get()->langTexty("subs_typy1");

//dosteop do admina
$konfig_subs['admin_subs']=user::get()->upr(16);

konf::get()->setKonfigTab(array("subs_konf"=>$konfig_subs));

?>