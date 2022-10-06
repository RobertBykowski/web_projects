<?php
//akcje 

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

$akcje_tab["grupygal_usun"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"grupy",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"grupygal_arch"	
);

$akcje_tab["grupygal_edytuj2"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"grupy",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""	
);

$akcje_tab["grupygal_edytuj"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"grupy",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["grupygal_dodaj2"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"grupy",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""	
);

$akcje_tab["grupygal_dodaj"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"grupy",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["grupygal_arch"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"grupy",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);

$akcje_tab["grupygal_zobacz"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"grupy",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);
	
?>