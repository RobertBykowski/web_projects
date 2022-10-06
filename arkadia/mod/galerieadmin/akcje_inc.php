<?php
//akcje ksiega gosci

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}


$akcje_tab["galerieadmin_usun"]=array(
	"dostep"=>konf::get()->getKonfigTab("galerie_konf","admin"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"galerieadmin_arch"
);


$akcje_tab["galerieadmin_arch"]=array(
	"dostep"=>konf::get()->getKonfigTab("galerie_konf","admin"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["galerieadmin_typy"]=array(
	"dostep"=>konf::get()->getKonfigTab("galerie_konf","admin"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);
	
?>