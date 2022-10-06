<?php
//akcje 

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

$akcje_tab["zamowieniaadmin_faktura"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"zamowieniaadmin_zobacz"		
);

$akcje_tab["zamowieniaadmin_uwagi"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"zamowieniaadmin_zobacz"		
);

$akcje_tab["zamowieniaadmin_platnosc"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"zamowieniaadmin_zobacz"		
);

$akcje_tab["zamowieniaadmin_usun"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"zamowieniaadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"zamowieniaadmin_arch"
);

$akcje_tab["zamowieniaadmin_status"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"zamowieniaadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"zamowieniaadmin_arch"
);

$akcje_tab["zamowieniaadmin_arch"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["zamowieniaadmin_zobacz"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);


$akcje_tab["zamowieniaadmin_drukuj"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"drukuj",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);


$akcje_tab["zamowieniaadmin_staty"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["zamowieniaadmin_statprod"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["zamowieniaadmin_statkwoty"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

/*
$akcje_tab["zamowieniaadmin_eksportcsv2"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"zamowieniaadmin_arch"	
);

$akcje_tab["zamowieniaadmin_eksprotcsv"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["zamowieniaadmin_dodaj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin2",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""	
);

$akcje_tab["zamowieniaadmin_dodaj"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

*/

?>