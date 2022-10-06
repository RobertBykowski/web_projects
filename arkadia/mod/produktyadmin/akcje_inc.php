<?php
//akcje 

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

$akcje_tab["produktyadmin_importcsv2"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"produktyadmin_arch"	
);

$akcje_tab["produktyadmin_importcsv"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"sklepadmin",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["produktyadmin_dodaj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""	
);

$akcje_tab["produktyadmin_dodaj"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"sklepadmin",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["produktyadmin_edytuj"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"sklepadmin",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["produktyadmin_edytuj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""		
);


$akcje_tab["produktyadmin_dostepnosc"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"produktyadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"produktyadmin_arch"
);

$akcje_tab["produktyadmin_usun"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"produktyadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"produktyadmin_arch"
);

$akcje_tab["produktyadmin_aktyw"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"produktyadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"produktyadmin_arch"
);

$akcje_tab["produktyadmin_deaktyw"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"produktyadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"produktyadmin_arch"
);

$akcje_tab["produktyadmin_nowosc"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"produktyadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"produktyadmin_arch"
);

$akcje_tab["produktyadmin_denowosc"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"produktyadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"produktyadmin_arch"
);

$akcje_tab["produktyadmin_wyr"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"produktyadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"produktyadmin_arch"
);

$akcje_tab["produktyadmin_dewyr"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"produktyadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"produktyadmin_arch"
);

$akcje_tab["produktyadmin_promocja"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"produktyadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"produktyadmin_arch"
);

$akcje_tab["produktyadmin_depromocja"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"produktyadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"produktyadmin_arch"
);

$akcje_tab["produktyadmin_polecamy"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"produktyadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"produktyadmin_arch"
);

$akcje_tab["produktyadmin_depolecamy"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"produktyadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"produktyadmin_arch"
);

$akcje_tab["produktyadmin_wyprzedaz"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"produktyadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"produktyadmin_arch"
);

$akcje_tab["produktyadmin_dewyprzedaz"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"produktyadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"produktyadmin_arch"
);

$akcje_tab["produktyadmin_konfigedytuj"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"sklepadmin",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["produktyadmin_konfigedytuj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"produktyadmin_konfigedytuj"		
);


$akcje_tab["produktyadmin_wytnij"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"produktyadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"produktyadmin_arch"
);

$akcje_tab["produktyadmin_wklej"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"produktyadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"produktyadmin_arch"
);


$akcje_tab["produktyadmin_arch"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["produktyadmin_galeriaobrot"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"produktyadmin_galeriakonfigedytuj"	
);

$akcje_tab["produktyadmin_galeriakonfigedytuj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"produktyadmin_galeriakonfigedytuj"	
);

$akcje_tab["produktyadmin_galeriakonfigedytuj"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"admin2",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);


$akcje_tab["produktyadmin_galeriadeaktyw"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"produktyadmin_galeria"	
);

$akcje_tab["produktyadmin_galeriaaktyw"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"produktyadmin_galeria"	
);

$akcje_tab["produktyadmin_galeriapoz"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"produktyadmin_galeria"	
);

$akcje_tab["produktyadmin_galeriausun"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"produktyadmin_galeria"	
);

$akcje_tab["produktyadmin_galeriaedytuj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""	
);

$akcje_tab["produktyadmin_galeriaedytuj"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"sklepadmin",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["produktyadmin_galeriadodaj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""	
);

$akcje_tab["produktyadmin_galeriadodaj"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"sklepadmin",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);


$akcje_tab["produktyadmin_galeria"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"sklepadmin",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);

?>