<?php
//akcje

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

$akcje_tab["koment_dodaj"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""	
);


$akcje_tab["koment_usun"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>""
);

?>