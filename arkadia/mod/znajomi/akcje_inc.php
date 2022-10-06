<?php
//akcje

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

$akcje_tab["znajomi_usun"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,	
	"szablon"=>"poczta",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"znajomi_arch"
);

$akcje_tab["znajomi_akceptuje"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,	
	"szablon"=>"poczta",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"znajomi_arch"
);

$akcje_tab["znajomi_zapros"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,	
	"szablon"=>"poczta",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"u_dane"
);

$akcje_tab["znajomi_szukaj"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,	
	"szablon"=>"poczta",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);
	
$akcje_tab["znajomi_lista"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"poczta",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);
	
$akcje_tab["znajomi_arch"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"poczta",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);

$akcje_tab["znajomi_czarna"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"poczta",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);

$akcje_tab["znajomi_czarnausun"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,	
	"szablon"=>"poczta",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"znajomi_czarna"
);


$akcje_tab["znajomi_czarnadodaj"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"poczta",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);

$akcje_tab["znajomi_czarnadodaj2"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,	
	"szablon"=>"poczta",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"znajomi_czarna"
);

$akcje_tab["znajomi_zaproszenia"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"poczta",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);

$akcje_tab["znajomi_zaproszenieusun"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,	
	"szablon"=>"poczta",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"znajomi_zaproszenia"
);


$akcje_tab["znajomi_zaproszenieodrzuc"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,	
	"szablon"=>"poczta",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"znajomi_zaproszenia"
);


$akcje_tab["znajomi_zaprosdo"]=array(
	"dostep"=>user::get()->zalogowany()&&konf::get()->getKonfigTab("znajomi_konf",'zaprosdo'),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"poczta",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);

$akcje_tab["znajomi_zaprosdo2"]=array(
	"dostep"=>user::get()->zalogowany()&&konf::get()->getKonfigTab("znajomi_konf",'zaprosdo'),	
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,	
	"szablon"=>"poczta",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>""
);

?>