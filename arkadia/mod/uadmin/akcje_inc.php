<?php
//akcje 

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}


$akcje_tab["uadmin_system"]=array(
	"dostep"=>user::get()->adminGlowny(),	//dostep do akcji
	"akcja_brakdostepu"=>"",				//akcja w przypadku braku dostepu		
	"nowy_obiekt"=>false,						//czy tworzyc nowy obiekt jesli juz istnieje
	"akcja_naglowek"=>true,					//czy rysowac naglowek
	"akcja_stopka"=>true,						//czy rysowac stopke
	"szablon"=>"admin2",							//szablon
	"akcja_koniec"=>true,						//koniec ciagu akcji
	"akcja_nastepna"=>""						//jaka akcja nastepna (jesli puste to domyslna akcja)
);


$akcje_tab["uadmin_phpinfo"]=array(
	"dostep"=>user::get()->adminGlowny(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,	
	"akcja_stopka"=>false,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,	
	"akcja_nastepna"=>""
);


$akcje_tab["uadmin_zmienopis"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,	
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,	
	"akcja_nastepna"=>""
);


$akcje_tab["uadmin_zmienopis2"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,	
	"akcja_stopka"=>false,
	"szablon"=>"admin2",	
	"akcja_koniec"=>false,	
	"akcja_nastepna"=>"uadmin_arch"
);


$akcje_tab["uadmin_zmienupr"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,	
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,	
	"akcja_nastepna"=>""
);


$akcje_tab["uadmin_zmienupr2"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,	
	"akcja_stopka"=>false,
	"szablon"=>"admin2",	
	"akcja_koniec"=>false,	
	"akcja_nastepna"=>"uadmin_zmienupr"
);


$akcje_tab["uadmin_wiadomosc"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,	
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,	
	"akcja_nastepna"=>""
);


$akcje_tab["uadmin_wiadomosc2"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,	
	"akcja_stopka"=>false,
	"szablon"=>"admin2",	
	"akcja_koniec"=>false,	
	"akcja_nastepna"=>"uadmin_arch"
);


$akcje_tab["uadmin_arch"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,	
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,	
	"akcja_nastepna"=>""
);


$akcje_tab["uadmin_zmienstatus"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,	
	"akcja_stopka"=>false,
	"szablon"=>"admin2",	
	"akcja_koniec"=>false,	
	"akcja_nastepna"=>"uadmin_arch"
);


$akcje_tab["uadmin_wyzerujpunkty"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,	
	"akcja_stopka"=>false,
	"szablon"=>"admin2",	
	"akcja_koniec"=>false,	
	"akcja_nastepna"=>"uadmin_arch"
);


$akcje_tab["uadmin_usunu"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,	
	"akcja_stopka"=>false,
	"szablon"=>"admin2",	
	"akcja_koniec"=>false,	
	"akcja_nastepna"=>"uadmin_arch"
);


$akcje_tab["uadmin_logiarch"]=array(
	"dostep"=>user::get()->adminLogi(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,	
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,	
	"akcja_nastepna"=>""
);


$akcje_tab["uadmin_usunlogi"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,	
	"akcja_stopka"=>false,
	"szablon"=>"admin2",	
	"akcja_koniec"=>false,	
	"akcja_nastepna"=>"uadmin_logiarch"
);


$akcje_tab["uadmin_banyarch"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,	
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,	
	"akcja_nastepna"=>""
);


$akcje_tab["uadmin_dodajbany"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,	
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,	
	"akcja_nastepna"=>""
);

$akcje_tab["uadmin_dodajbany2"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,	
	"akcja_stopka"=>false,
	"szablon"=>"admin2",	
	"akcja_koniec"=>false,	
	"akcja_nastepna"=>"uadmin_banyarch"
);


$akcje_tab["uadmin_edytujbany"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,	
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,	
	"akcja_nastepna"=>""
);


$akcje_tab["uadmin_edytujbany2"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,	
	"akcja_stopka"=>false,
	"szablon"=>"admin2",	
	"akcja_koniec"=>false,	
	"akcja_nastepna"=>"uadmin_edytujbany"
);


$akcje_tab["uadmin_aktywbany"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,	
	"akcja_stopka"=>false,
	"szablon"=>"admin2",	
	"akcja_koniec"=>false,	
	"akcja_nastepna"=>"uadmin_banyarch"
);


$akcje_tab["uadmin_deaktywbany"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,	
	"akcja_stopka"=>false,
	"szablon"=>"admin2",	
	"akcja_koniec"=>false,	
	"akcja_nastepna"=>"uadmin_banyarch"
);


$akcje_tab["uadmin_usunbany"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,	
	"akcja_stopka"=>false,
	"szablon"=>"admin2",	
	"akcja_koniec"=>false,	
	"akcja_nastepna"=>"uadmin_banyarch"
);


$akcje_tab["uadmin_staty"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,	
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,	
	"akcja_nastepna"=>""
);


$akcje_tab["uadmin_statlog"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,	
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,	
	"akcja_nastepna"=>""
);

$akcje_tab["uadmin_statpt"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,	
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,	
	"akcja_nastepna"=>""
);

$akcje_tab["uadmin_statilez"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,	
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,	
	"akcja_nastepna"=>""
);

$akcje_tab["uadmin_statsumaz"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,	
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,	
	"akcja_nastepna"=>""
);

$akcje_tab["uadmin_statznajomi"]=array(
	"dostep"=>user::get()->adminU(),	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,	
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,	
	"akcja_nastepna"=>""
);


?>