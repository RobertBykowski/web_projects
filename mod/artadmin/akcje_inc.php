<?php
//akcje 

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}


$akcje_tab["artadmin_staty"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),						//dostep do akcji
	"akcja_brakdostepu"=>"",	//akcja w przypadku braku dostepu		
	"nowy_obiekt"=>false,			//czy tworzyc nowy obiekt jesli juz istnieje
	"akcja_naglowek"=>true,		//czy rysowac naglowek
	"akcja_stopka"=>true,			//czy rysowac stopke
	"szablon"=>"admin",						//szablon
	"akcja_koniec"=>true,			//koniec ciagu akcji
	"akcja_nastepna"=>""			//jaka akcja nastepna (jesli puste to domyslna akcja)
);


$akcje_tab["artadmin_galeriaobrot"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"artadmin_galeriakonfigedytuj"	
);

$akcje_tab["artadmin_galeriakonfigedytuj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"artadmin_galeriakonfigedytuj"	
);

$akcje_tab["artadmin_galeriakonfigedytuj"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);


$akcje_tab["artadmin_galeriawklej"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"artadmin_galeria"	
);

$akcje_tab["artadmin_galeriawytnij"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"artadmin_galeria"	
);

$akcje_tab["artadmin_galeriadeaktyw"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"artadmin_galeria"	
);

$akcje_tab["artadmin_galeriaaktyw"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"artadmin_galeria"	
);

$akcje_tab["artadmin_galeriapoz"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"artadmin_galeria"	
);

$akcje_tab["artadmin_galeriausun"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"artadmin_galeria"	
);

$akcje_tab["artadmin_galeriaedytuj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""	
);

$akcje_tab["artadmin_galeriaedytuj"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["artadmin_galeriadodaj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""	
);

$akcje_tab["artadmin_galeriadodaj"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);


$akcje_tab["artadmin_galeria"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);


$akcje_tab["artadmin_zobacz"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);
	
	
$akcje_tab["artadmin_dodaj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""	
);

$akcje_tab["artadmin_dodaj"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["artadmin_edytuj"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["artadmin_edytuj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""		
);

$akcje_tab["artadmin_usun"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"artadmin_arch"
);

$akcje_tab["artadmin_aktyw"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"artadmin_arch"
);

$akcje_tab["artadmin_deaktyw"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"artadmin_arch"
);

$akcje_tab["artadmin_arch"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["artadmin_typy"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["artadmin_konfigedytuj"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["artadmin_konfigedytuj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"artadmin_konfigedytuj"		
);

$akcje_tab["artadmin_akapitydodaj"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["artadmin_akapitydodaj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"artadmin_zobacz"		
);

$akcje_tab["artadmin_akapityedytuj"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["artadmin_akapityedytuj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"artadmin_akapityedytuj"		
);

$akcje_tab["artadmin_akapitykonfigedytuj"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["artadmin_akapitykonfigedytuj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"artadmin_akapitykonfigedytuj"		
);

$akcje_tab["artadmin_akapityusun"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"artadmin_zobacz"
);

$akcje_tab["artadmin_akapitypoz"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"artadmin_zobacz"
);

$akcje_tab["artadmin_wytnij"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"artadmin_arch"
);

$akcje_tab["artadmin_wklej"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"artadmin_arch"
);


$akcje_tab["artadmin_poz"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"artadmin_arch"
);

$akcje_tab["artadmin_usunblokady"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"artadmin_arch"
);

$akcje_tab["artadmin_arch"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["artadmin_dzialy"]=array(
	"dostep"=>konf::get()->getKonfigTab("art_konf","admin_art"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

?>