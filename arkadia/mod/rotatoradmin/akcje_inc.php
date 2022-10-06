<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}


$akcje_tab["rotatoradmin_staty"]=array(
	"dostep"=>konf::get()->getKonfigTab("rotator_konf","admin_rotator"),						//dostep do akcji
	"akcja_brakdostepu"=>"",	//akcja w przypadku braku dostepu		
	"nowy_obiekt"=>false,			//czy tworzyc nowy obiekt jesli juz istnieje
	"akcja_naglowek"=>true,		//czy rysowac naglowek
	"akcja_stopka"=>true,			//czy rysowac stopke
	"szablon"=>"admin2",						//szablon
	"akcja_koniec"=>true,			//koniec ciagu akcji
	"akcja_nastepna"=>""			//jaka akcja nastepna (jesli puste to domyslna akcja)
);
	
	
$akcje_tab["rotatoradmin_dodaj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("rotator_konf","admin_rotator"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""	
);

$akcje_tab["rotatoradmin_dodaj"]=array(
	"dostep"=>konf::get()->getKonfigTab("rotator_konf","admin_rotator"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["rotatoradmin_edytuj"]=array(
	"dostep"=>konf::get()->getKonfigTab("rotator_konf","admin_rotator"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["rotatoradmin_edytuj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("rotator_konf","admin_rotator"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""		
);

$akcje_tab["rotatoradmin_usun"]=array(
	"dostep"=>konf::get()->getKonfigTab("rotator_konf","admin_rotator"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"rotatoradmin_arch"
);

$akcje_tab["rotatoradmin_aktywuj"]=array(
	"dostep"=>konf::get()->getKonfigTab("rotator_konf","admin_rotator"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"rotatoradmin_arch"
);

$akcje_tab["rotatoradmin_deaktywuj"]=array(
	"dostep"=>konf::get()->getKonfigTab("rotator_konf","admin_rotator"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"rotatoradmin_arch"
);

$akcje_tab["rotatoradmin_arch"]=array(
	"dostep"=>konf::get()->getKonfigTab("rotator_konf","admin_rotator"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["rotatoradmin_typy"]=array(
	"dostep"=>konf::get()->getKonfigTab("rotator_konf","admin_rotator"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);
		
		
?>