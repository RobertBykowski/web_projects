<?php
//akcje ksiega gosci

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

$akcje_tab["guestbook_zobacz"]=array(
	"dostep"=>true,						//dostep do akcji
	"akcja_brakdostepu"=>"",	//akcja w przypadku braku dostepu		
	"nowy_obiekt"=>false,			//czy tworzyc nowy obiekt jesli juz istnieje
	"akcja_naglowek"=>true,		//czy rysowac naglowek
	"akcja_stopka"=>true,			//czy rysowac stopke
	"szablon"=>"",						//szablon
	"akcja_koniec"=>true,			//koniec ciagu akcji
	"akcja_nastepna"=>""			//jaka akcja nastepna (jesli puste to domyslna akcja)
);
	
$akcje_tab["guestbook_dodaj2"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""	
);

$akcje_tab["guestbook_dodaj"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["guestbook_usun"]=array(
	"dostep"=>konf::get()->getKonfigTab("guestbook_konf","admin_guestbook"),
	"akcja_brakdostepu"=>"guestbook_zobacz",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"guestbook_zobacz"
);

$akcje_tab["guestbook_edytuj"]=array(
	"dostep"=>konf::get()->getKonfigTab("guestbook_konf","admin_guestbook"),
	"akcja_brakdostepu"=>"guestbook_zobacz",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["guestbook_edytuj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("guestbook_konf","admin_guestbook"),
	"akcja_brakdostepu"=>"guestbook_zobacz",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"guestbook_zobacz"		
);



?>