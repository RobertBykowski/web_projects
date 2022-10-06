<?php
//akcje ksiega gosci

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}


$akcje_tab["grupyadmin_typy"]=array(
	"dostep"=>konf::get()->getKonfigTab("grupy_konf","admin"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["grupyadmin_arch"]=array(
	"dostep"=>konf::get()->getKonfigTab("grupy_konf","admin"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["grupyadmin_dodaj"]=array(
	"dostep"=>konf::get()->getKonfigTab("grupy_konf","admin"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["grupyadmin_edytuj"]=array(
	"dostep"=>konf::get()->getKonfigTab("grupy_konf","admin"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["grupyadmin_dodaj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("grupy_konf","admin"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""	
);

$akcje_tab["grupyadmin_edytuj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("grupy_konf","admin"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""	
);

$akcje_tab["grupyadmin_usun"]=array(
	"dostep"=>konf::get()->getKonfigTab("grupy_konf","admin"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"grupyadmin_arch"	
);

$akcje_tab["grupyadmin_status"]=array(
	"dostep"=>konf::get()->getKonfigTab("grupy_konf","admin"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"grupyadmin_arch"	
);

$akcje_tab["grupyadmin_dousuniecia"]=array(
	"dostep"=>konf::get()->getKonfigTab("grupy_konf","admin"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"grupyadmin_arch"	
);

$akcje_tab["grupyadmin_dousuniecianie"]=array(
	"dostep"=>konf::get()->getKonfigTab("grupy_konf","admin"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"grupyadmin_arch"	
);

?>