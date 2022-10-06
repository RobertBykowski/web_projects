<?php
//akcje ksiega gosci

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

$akcje_tab["art_wyslij3"]=array(
	"dostep"=>true,						//dostep do akcji
	"akcja_brakdostepu"=>"",	//akcja w przypadku braku dostepu
	"nowy_obiekt"=>false,			//czy tworzyc nowy obiekt jesli juz istnieje
	"akcja_naglowek"=>true,		//czy rysowac naglowek
	"akcja_stopka"=>true,			//czy rysowac stopke
	"szablon"=>"plik",						//szablon
	"akcja_koniec"=>true,			//koniec ciagu akcji
	"akcja_nastepna"=>""			//jaka akcja nastepna (jesli puste to domyslna akcja)
);

$akcje_tab["art_wyslij"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"plik",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["art_wyslij2"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"plik",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"art_wyslij3"
);

$akcje_tab["art_szukaj"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["art_drukuj"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"drukuj",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["art_plik"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"plik",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["art_statystyka"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["art_projektor"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"projektor",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["art_mapa"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["art_zobacz"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);


$akcje_tab["art_powitalna"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["art_rss"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["art_restauracja"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["art_oferta"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["art_pokoje"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);



$akcje_tab["art_galeria"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["art_menu"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["art_kontakt"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);




?>