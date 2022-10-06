<?php
//akcje ksiega gosci

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

$akcje_tab["ankietaadmin_staty"]=array(
	"dostep"=>konf::get()->getKonfigTab("ankieta_konf","admin_ankieta"),						//dostep do akcji
	"akcja_brakdostepu"=>"",	//akcja w przypadku braku dostepu		
	"nowy_obiekt"=>false,			//czy tworzyc nowy obiekt jesli juz istnieje
	"akcja_naglowek"=>true,		//czy rysowac naglowek
	"akcja_stopka"=>true,			//czy rysowac stopke
	"szablon"=>"admin2",						//szablon
	"akcja_koniec"=>true,			//koniec ciagu akcji
	"akcja_nastepna"=>""			//jaka akcja nastepna (jesli puste to domyslna akcja)
);
	
$akcje_tab["ankietaadmin_dodaj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("ankieta_konf","admin_ankieta"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""	
);

$akcje_tab["ankietaadmin_dodaj"]=array(
	"dostep"=>konf::get()->getKonfigTab("ankieta_konf","admin_ankieta"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["ankietaadmin_edytuj"]=array(
	"dostep"=>konf::get()->getKonfigTab("ankieta_konf","admin_ankieta"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["ankietaadmin_edytuj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("ankieta_konf","admin_ankieta"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"ankietaadmin_edytuj"		
);

$akcje_tab["ankietaadmin_usun"]=array(
	"dostep"=>konf::get()->getKonfigTab("ankieta_konf","admin_ankieta"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"ankietaadmin_arch"
);

$akcje_tab["ankietaadmin_aktyw"]=array(
	"dostep"=>konf::get()->getKonfigTab("ankieta_konf","admin_ankieta"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"ankietaadmin_arch"
);

$akcje_tab["ankietaadmin_deaktyw"]=array(
	"dostep"=>konf::get()->getKonfigTab("ankieta_konf","admin_ankieta"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"ankietaadmin_arch"
);

$akcje_tab["ankietaadmin_arch"]=array(
	"dostep"=>konf::get()->getKonfigTab("ankieta_konf","admin_ankieta"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["ankietaadmin_typy"]=array(
	"dostep"=>konf::get()->getKonfigTab("ankieta_konf","admin_ankieta"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);
	
?>