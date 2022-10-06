<?php
//akcje 

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

$akcje_tab["ugal_usun"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"portal",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"ugal_arch"	
);

$akcje_tab["ugal_edytuj2"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"portal",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""	
);

$akcje_tab["ugal_edytuj"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"portal",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["ugal_dodaj2"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"portal",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""	
);

$akcje_tab["ugal_dodaj"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"portal",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["ugal_arch"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"portal",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);

$akcje_tab["ugal_zobacz"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"portal",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);
	
?>