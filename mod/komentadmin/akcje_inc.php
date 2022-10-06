<?php
//akcje ksiega gosci

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}


$akcje_tab["komentadmin_edytuj"]=array(
	"dostep"=>konf::get()->getKonfigTab("koment_konf","admin"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["komentadmin_edytuj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("koment_konf","admin"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"komentadmin_edytuj"		
);

$akcje_tab["komentadmin_usun"]=array(
	"dostep"=>konf::get()->getKonfigTab("koment_konf","admin"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"komentadmin_arch"
);

$akcje_tab["komentadmin_aktyw"]=array(
	"dostep"=>konf::get()->getKonfigTab("koment_konf","admin"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"komentadmin_arch"
);

$akcje_tab["komentadmin_deaktyw"]=array(
	"dostep"=>konf::get()->getKonfigTab("koment_konf","admin"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"komentadmin_arch"
);

$akcje_tab["komentadmin_arch"]=array(
	"dostep"=>konf::get()->getKonfigTab("koment_konf","admin"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["komentadmin_typy"]=array(
	"dostep"=>konf::get()->getKonfigTab("koment_konf","admin"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);
	
?>