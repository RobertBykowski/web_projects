<?php
//akcje 

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}


$akcje_tab["sklepadmin_staty"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),						//dostep do akcji
	"akcja_brakdostepu"=>"",	//akcja w przypadku braku dostepu		
	"nowy_obiekt"=>false,			//czy tworzyc nowy obiekt jesli juz istnieje
	"akcja_naglowek"=>true,		//czy rysowac naglowek
	"akcja_stopka"=>true,			//czy rysowac stopke
	"szablon"=>"sklepadmin",						//szablon
	"akcja_koniec"=>true,			//koniec ciagu akcji
	"akcja_nastepna"=>""			//jaka akcja nastepna (jesli puste to domyslna akcja)
);


$akcje_tab["sklepadmin_statkatwys"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,	
	"akcja_naglowek"=>true,	
	"akcja_stopka"=>true,
	"szablon"=>"sklepadmin",
	"akcja_koniec"=>true,	
	"akcja_nastepna"=>""
);

$akcje_tab["sklepadmin_statprodwys"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,	
	"akcja_naglowek"=>true,	
	"akcja_stopka"=>true,
	"szablon"=>"sklepadmin",
	"akcja_koniec"=>true,	
	"akcja_nastepna"=>""
);
	
$akcje_tab["sklepadmin_dodaj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""	
);

$akcje_tab["sklepadmin_dodaj"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"sklepadmin",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["sklepadmin_edytuj"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"sklepadmin",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["sklepadmin_edytuj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""		
);

$akcje_tab["sklepadmin_usun"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"sklepadmin_arch"
);

$akcje_tab["sklepadmin_aktyw"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"sklepadmin_arch"
);

$akcje_tab["sklepadmin_deaktyw"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"sklepadmin_arch"
);

$akcje_tab["sklepadmin_konfigedytuj"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"sklepadmin",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["sklepadmin_konfigedytuj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"sklepadmin_konfigedytuj"		
);


$akcje_tab["sklepadmin_wytnij"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"sklepadmin_arch"
);

$akcje_tab["sklepadmin_wklej"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"sklepadmin_arch"
);


$akcje_tab["sklepadmin_poz"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"sklepadmin_arch"
);

$akcje_tab["sklepadmin_arch"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"sklepadmin",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["sklepadmin_dzialy"]=array(
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