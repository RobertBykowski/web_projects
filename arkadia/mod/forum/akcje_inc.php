<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

$akcje_tab["forum_zobacz"]=array(
	"dostep"=>true,						//dostep do akcji
	"akcja_brakdostepu"=>"",	//akcja w przypadku braku dostepu		
	"nowy_obiekt"=>false,			//czy tworzyc nowy obiekt jesli juz istnieje
	"akcja_naglowek"=>true,		//czy rysowac naglowek
	"akcja_stopka"=>true,			//czy rysowac stopke
	"szablon"=>"forum",						//szablon
	"akcja_koniec"=>true,			//koniec ciagu akcji
	"akcja_nastepna"=>""			//jaka akcja nastepna (jesli puste to domyslna akcja)
);

	
$akcje_tab["forum_szukaj"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"forum",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>"guestbook_zobacz"	
);


$akcje_tab["forum_usunp"]=array(
	"dostep"=>konf::get()->getKonfigTab("forum_konf","admin_forum"),
	"akcja_brakdostepu"=>"forum_zobacz",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"forum",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"forum_zobacz"	
);


$akcje_tab["forum_edytujp"]=array(
	"dostep"=>konf::get()->getKonfigTab("forum_konf","admin_forum"),
	"akcja_brakdostepu"=>"forum_zobacz",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"forum",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);


$akcje_tab["forum_edytujp2"]=array(
	"dostep"=>konf::get()->getKonfigTab("forum_konf","admin_forum"),
	"akcja_brakdostepu"=>"forum_zobacz",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"forum",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"forum_zobacz"	
);
	
$akcje_tab["forum_wytnijp"]=array(
	"dostep"=>konf::get()->getKonfigTab("forum_konf","admin_forum"),
	"akcja_brakdostepu"=>"forum_zobacz",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"forum",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"forum_zobacz"	
);


$akcje_tab["forum_wklejp"]=array(
	"dostep"=>konf::get()->getKonfigTab("forum_konf","admin_forum"),
	"akcja_brakdostepu"=>"forum_zobacz",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"forum",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"forum_zobacz"	
);


$akcje_tab["forum_typp"]=array(
	"dostep"=>konf::get()->getKonfigTab("forum_konf","admin_forum"),
	"akcja_brakdostepu"=>"forum_zobacz",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"forum",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"forum_zobacz"	
);


$akcje_tab["forum_dodajp"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"forum",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);


$akcje_tab["forum_dodajp2"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"forum",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"forum_zobacz"	
);
	

$akcje_tab["forum_staty"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"forum",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);
	

$akcje_tab["forum_dodajd"]=array(
	"dostep"=>konf::get()->getKonfigTab("forum_konf","admin_forum"),
	"akcja_brakdostepu"=>"forum_zobacz",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"forum",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);


$akcje_tab["forum_dodajd2"]=array(
	"dostep"=>konf::get()->getKonfigTab("forum_konf","admin_forum"),
	"akcja_brakdostepu"=>"forum_zobacz",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"forum",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"forum_dodajd"	
);
	
	
$akcje_tab["forum_edytujd"]=array(
	"dostep"=>konf::get()->getKonfigTab("forum_konf","admin_forum"),
	"akcja_brakdostepu"=>"forum_zobacz",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"forum",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);


$akcje_tab["forum_edytujd2"]=array(
	"dostep"=>konf::get()->getKonfigTab("forum_konf","admin_forum"),
	"akcja_brakdostepu"=>"forum_zobacz",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"forum",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"forum_edytujd"	
);
	
	
$akcje_tab["forum_usund"]=array(
	"dostep"=>konf::get()->getKonfigTab("forum_konf","admin_forum"),
	"akcja_brakdostepu"=>"forum_zobacz",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"forum",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"forum_dodajd"	
);
		

$akcje_tab["forum_dodajt"]=array(
	"dostep"=>konf::get()->getKonfigTab("forum_konf","nowy_t_dostep"),
	"akcja_brakdostepu"=>"forum_zobacz",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"forum",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);
		
		
$akcje_tab["forum_dodajt2"]=array(
	"dostep"=>konf::get()->getKonfigTab("forum_konf","nowy_t_dostep"),
	"akcja_brakdostepu"=>"forum_zobacz",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"forum",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"forum_zobacz"	
);
	
	
$akcje_tab["forum_edytujt"]=array(
	"dostep"=>konf::get()->getKonfigTab("forum_konf","admin_forum"),
	"akcja_brakdostepu"=>"forum_zobacz",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"forum",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);


$akcje_tab["forum_edytujt2"]=array(
	"dostep"=>konf::get()->getKonfigTab("forum_konf","admin_forum"),
	"akcja_brakdostepu"=>"forum_zobacz",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"forum",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"forum_edytujt"	
);
	

$akcje_tab["forum_usunt"]=array(
	"dostep"=>konf::get()->getKonfigTab("forum_konf","admin_forum"),
	"akcja_brakdostepu"=>"forum_zobacz",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"forum",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"forum_zobacz"	
);
	
	
$akcje_tab["forum_wytnijt"]=array(
	"dostep"=>konf::get()->getKonfigTab("forum_konf","admin_forum"),
	"akcja_brakdostepu"=>"forum_zobacz",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"forum",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"forum_zobacz"	
);


$akcje_tab["forum_wklejt"]=array(
	"dostep"=>konf::get()->getKonfigTab("forum_konf","admin_forum"),
	"akcja_brakdostepu"=>"forum_zobacz",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"forum",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"forum_zobacz"	
);
	

$akcje_tab["forum_typt"]=array(
	"dostep"=>konf::get()->getKonfigTab("forum_konf","admin_forum"),
	"akcja_brakdostepu"=>"forum_zobacz",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"forum",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"forum_zobacz"	
);		


?>