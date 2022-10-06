<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}


$akcje_tab["subsadmin_arch"]=array(
	"dostep"=>konf::get()->getKonfigTab("subs_konf","admin_subs"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);


$akcje_tab["subsadmin_typy"]=array(
	"dostep"=>konf::get()->getKonfigTab("subs_konf","admin_subs"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);


$akcje_tab["subsadmin_zapisz"]=array(
	"dostep"=>konf::get()->getKonfigTab("subs_konf","admin_subs"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"subsadmin_arch"	
);

$akcje_tab["subsadmin_usun"]=array(
	"dostep"=>konf::get()->getKonfigTab("subs_konf","admin_subs"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"subsadmin_arch"	
);

$akcje_tab["subsadmin_przenies"]=array(
	"dostep"=>konf::get()->getKonfigTab("subs_konf","admin_subs"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"subsadmin_arch"	
);

$akcje_tab["subsadmin_aktyw"]=array(
	"dostep"=>konf::get()->getKonfigTab("subs_konf","admin_subs"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"subsadmin_arch"	
);


$akcje_tab["subsadmin_deaktyw"]=array(
	"dostep"=>konf::get()->getKonfigTab("subs_konf","admin_subs"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"subsadmin_arch"	
);


$akcje_tab["subsadmin_wiadomosc"]=array(
	"dostep"=>konf::get()->getKonfigTab("subs_konf","admin_subs"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);

  
$akcje_tab["subsadmin_wiadomosc2"]=array(
	"dostep"=>konf::get()->getKonfigTab("subs_konf","admin_subs"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"subs",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);


$akcje_tab["subsadmin_archw"]=array(
	"dostep"=>konf::get()->getKonfigTab("subs_konf","admin_subs"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);


$akcje_tab["subsadmin_usunw"]=array(
	"dostep"=>konf::get()->getKonfigTab("subs_konf","admin_subs"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"subsadmin_archw"	
);


$akcje_tab["subsadmin_zobacz"]=array(
	"dostep"=>konf::get()->getKonfigTab("subs_konf","admin_subs"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);

	

	
?>