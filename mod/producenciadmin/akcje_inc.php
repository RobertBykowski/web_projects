<?php
//akcje 

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}
	
$akcje_tab["producenciadmin_dodaj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""	
);

$akcje_tab["producenciadmin_dodaj"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"sklepadmin",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["producenciadmin_edytuj"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"sklepadmin",	
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["producenciadmin_edytuj2"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""		
);

$akcje_tab["producenciadmin_usun"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"producenciadmin_arch"
);

$akcje_tab["producenciadmin_aktyw"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"producenciadmin_arch"
);

$akcje_tab["producenciadmin_deaktyw"]=array(
	"dostep"=>konf::get()->getKonfigTab("sklep_konf","admin_sklep"),
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"sklepadmin",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"producenciadmin_arch"
);

$akcje_tab["producenciadmin_arch"]=array(
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