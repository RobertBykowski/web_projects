<?php
//akcje ksiega gosci

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}


$akcje_tab["artdziennik_arch"]=array(
	"dostep"=>true,	
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,	
	"akcja_naglowek"=>true,	
	"akcja_stopka"=>true,	
	"szablon"=>"",	
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);


$akcje_tab["artdziennik_zobacz"]=array(
	"dostep"=>true,	
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,	
	"akcja_stopka"=>true,	
	"szablon"=>"",
	"akcja_koniec"=>true,	
	"akcja_nastepna"=>""	
);


?>