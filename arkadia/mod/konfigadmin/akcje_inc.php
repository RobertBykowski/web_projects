<?php
//akcje 

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

	
$akcje_tab["konfigadmin_edytuj"]=array(
	"dostep"=>user::get()->adminGlowny(),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["konfigadmin_edytuj2"]=array(
	"dostep"=>user::get()->adminGlowny(),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"konfigadmin_edytuj"		
);


?>