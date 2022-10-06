<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

if(user::get()->zalogowany()){
	konf::get()->setTekstyTab("grupy_texty",2);
} else {
	konf::get()->setTekstyTab("grupy_texty");
}

$konfig_grupy['na_str']=20; //ile grup na podstronie
$konfig_grupy['na_strm']=50; //ile grup na podstronie moje grupy
$konfig_grupy['limit']=100; //limit zalozonych grup przez jedna osobe
$konfig_grupy['zamkniete']=true; //czy mozliwosc tworzenia grup zamknietych
$konfig_grupy['zatwierdzanie']=true; //czy mozliwosc zatwierdzania nowych czlonkow grupy
$konfig_grupy['adminmoderacja']=true; //czy admin musi atwierdzic utworzenie grupy
$konfig_grupy['usuwanie']=1; //0 - brak mozliwosci usuwania 1-zgloszenie do usuniecia 2- mozliwosc usuniecia samodzielnego
$konfig_grupy['admin']=user::get()->upr(3);  //admin
$konfig_grupy['wys_kolumn']=4; //ile kolumn znajomych
$konfig_grupy['wys_grafika']=false; //czy czarna lista
$konfig_grupy['kat']="pics/grupy/"; //katalog na img
$konfig_grupy['img']=true; //czy img

//domyslny rozmiar skalowania img
$konfig_grupy['img1_size']=450;
$konfig_grupy['img1_skalatyp']=3; 

//max rozmiar
$konfig_grupy['img2_size']=70;
$konfig_grupy['img2_skalatyp']=3; 

//max rozmiar
$konfig_grupy['img3_size']=35;
$konfig_grupy['img3_skalatyp']=6; 

//minimalny wymiar grafiki
$konfig_grupy['img_min_size']=1;

//jaka wersja profilu
$konfig_grupy['galeria']=true;

//katalog na galerie
$konfig_grupy['galeria_kat']="pics/grupygal/";		

//typ skakowania miniaturki
$konfig_grupy['galeria_skalowanie']=3;

//skalowanie
$konfig_grupy['galeria_img_size']=500;

//skalowanie
$konfig_grupy['galeria_min_size']=1;

//skalowanie miniaturki
$konfig_grupy['galeria_m_size']=120;

//oceny zdjec
$konfig_grupy['galeria_punkty']=false;

//licznik wyswietlen zdjec
$konfig_grupy['galeria_licznik']=false;

//opis zdjecia w adminie
$konfig_grupy['galeria_opis']=false;

//komentarze
$konfig_grupy['galeria_koment']=true;

//ile wierszy na podstronie (0 bez limitu)
$konfig_grupy['galeria_wiersz']=5;

//ile kolumn/zdjec w wierszu na podstronie (zwykle 1-10 zaleznie od szerokosci www)
$konfig_grupy['galeria_kolumna']=4;

//limit zdjecdodanych do galerii
$konfig_grupy['galeria_limit']=1000;

//statusy wiadomosci
$konfig_grupy['typy_tab']=array(
	1=>"Giełda i inwestycje",
	2=>"Kobiety, zdrowie, uroda",
	3=>"Komputery/internet",
	4=>"Literatura, kino, sztuka",
	5=>"Media i dziennikarstwo",
	6=>"Miasta/regiony",
	7=>"Motoryzacja",
	8=>"Muzyka i taniec",
	9=>"Organizacje i stowarzyszenia",
	10=>"Podróże",
	11=>"Pozostałe",
	12=>"Przedsiębiorcy/biznesmeni",
	13=>"Reklama, marketing, wizerunek",
	14=>"Sport i rekreacja",
	15=>"Uczelnie, studia, studenci, absolwenci",
	16=>"Zainteresowania",
);

//statusy wiadomosci
$konfig_grupy['statusy_tab']=array(
	0=>"nieaktywna",
	1=>"aktywna",
);

//statusy wiadomosci
$konfig_grupy['funkcje_tab']=array(
	0=>"zwykły członek",
	1=>"moderator",
	2=>"właściciel",	
);

if($konfig_grupy['adminmoderacja']){
	$konfig_grupy['statusy_tab'][2]="do potwierdzenia";
}

konf::get()->setKonfigTab(array("grupy_konf"=>$konfig_grupy));

?>