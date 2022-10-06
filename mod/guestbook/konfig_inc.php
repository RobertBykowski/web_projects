<?php
//konfiguracja ksiegi gosci 

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

konf::get()->setTekstyTab("guestbook_texty");

//zmienną określająca dostęp do administracji komentarzami
$konfig_guestbook['admin_guestbook']=user::get()->upr(13);

//max domyślna dlugosc komentarza (0-bez limitu)
$konfig_guestbook['max_dlugosc']=0;

//jeśli podział na podstrony to ile rekordów na podstronie
//0 bez podizalu na podstrony
$konfig_guestbook['k_na_str']=10;

//emotikony w komentarzach
$konfig_guestbook['emotikony']=true;

//dostępny formularz
$konfig_guestbook['form_dostep']=true;

//kierunek sortowania
$konfig_guestbook['order']='autor_kiedy DESC, id DESC';

//domyślny status wpisu
$konfig_guestbook['default_status']=1;

//w formularzu pobierz email
$konfig_guestbook['email']=true;

//w formularzu pobierz www
$konfig_guestbook['www']=true;

//w formularzu pobierz gg
$konfig_guestbook['gg']=true;

//w formularzu pobierz gg
$konfig_guestbook['botproof']=true;

//wymagany email do wpisu
$konfig_guestbook['wymagany_email']=true;

//jakie tagi html mogą pozostać
$konfig_guestbook['zostaw_tagi']="<b><i>";

//przyciski pomocy do wstawiania znakow html <i> oraz <b>
$konfig_guestbook['html_hlp']=true;

//po ilu znakach lłamać linie (0 bez łamania)
$konfig_guestbook['linia_znakow']=50;

//automatycznie tworzy linki do www i email
$konfig_guestbook['autolink']=true;

$konfig_guestbook['wyswietl_email']=true;
$konfig_guestbook['wyswietl_ip']=true;
$konfig_guestbook['wyswietl_data']=true;
$konfig_guestbook['wyswietl_numeracja']=true;

//położenie formularza wpisu 1-nagorze, 2 na dole, 3-po kliknieciu na link 
$konfig_guestbook['form_pos']=3;

//na ile dni zapisywać dane w cookie
$konfig_guestbook['cookie']=60;

konf::get()->setKonfigTab(array("guestbook_konf"=>$konfig_guestbook));

?>