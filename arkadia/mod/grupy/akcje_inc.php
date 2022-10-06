<?php
//akcje ksiega gosci

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}


$akcje_tab["grupy_kat"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"grupy",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);


$akcje_tab["grupy_user"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"grupy",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

	
$akcje_tab["grupy_ludzie"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"grupy",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);	

$akcje_tab["grupy_oczekujacy"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"grupy",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);	

$akcje_tab["grupy_zobacz"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"grupy",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["grupy_dolacz"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"grupy",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"grupy_zobacz"	
);


$akcje_tab["grupy_rezygnuj"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"grupy",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);


$akcje_tab["grupy_rezygnuj2"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"grupy",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"grupy_moje"
);


$akcje_tab["grupy_dodaj"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"grupy",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["grupy_edytuj"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"grupy",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["grupy_dodaj2"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"grupy",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""	
);

$akcje_tab["grupy_edytuj2"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"grupy",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""	
);


$akcje_tab["grupy_usun"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"grupy",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["grupy_usun2"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"grupy",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"grupy_moje"	
);


$akcje_tab["grupy_akceptuju"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"grupy",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"grupy_oczekujacy"	
);

$akcje_tab["grupy_usunu"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"grupy",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"grupy_ludzie"	
);


$akcje_tab["grupy_usunz"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"grupy",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"grupy_oczekujacy"	
);

?>