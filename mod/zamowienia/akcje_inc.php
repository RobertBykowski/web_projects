<?php
//akcje 

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

$akcje_tab["zamowienia_zobacz"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["zamowienia_drukuj"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"drukuj",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["zamowienia_arch"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

?>