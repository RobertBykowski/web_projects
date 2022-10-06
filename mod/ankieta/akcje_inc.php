<?php
//akcje ksiega gosci

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

$akcje_tab["ankieta_lista"]=array(
	"dostep"=>false,						//dostep do akcji
	"akcja_brakdostepu"=>"",	//akcja w przypadku braku dostepu		
	"nowy_obiekt"=>false,			//czy tworzyc nowy obiekt jesli juz istnieje
	"akcja_naglowek"=>true,		//czy rysowac naglowek
	"akcja_stopka"=>true,			//czy rysowac stopke
	"szablon"=>"",						//szablon
	"akcja_koniec"=>true,			//koniec ciagu akcji
	"akcja_nastepna"=>""			//jaka akcja nastepna (jesli puste to domyslna akcja)
);
	
$akcje_tab["ankieta_glos"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"ankieta_lista"	
);

?>