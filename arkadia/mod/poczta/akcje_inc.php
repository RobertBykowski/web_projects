<?php
//akcje

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

$akcje_tab["poczta_systemowe"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,	
	"szablon"=>"poczta",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"poczta_systemowe2"
);

$akcje_tab["poczta_systemowe2"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,	
	"szablon"=>"poczta",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["poczta_kosz"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,	
	"szablon"=>"",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"poczta_kosz2"
);

$akcje_tab["poczta_kosz2"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,	
	"szablon"=>"poczta",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);

$akcje_tab["poczta_wys"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,	
	"szablon"=>"",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>"poczta_wys2"
);

$akcje_tab["poczta_wys2"]=array(
	"dostep"=>user::get()->zalogowany(),	
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,	
	"szablon"=>"poczta",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);
	
$akcje_tab["poczta_odb"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"poczta_odb2"	
);


$akcje_tab["poczta_odb2"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"poczta",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);


$akcje_tab["poczta_wiadomosca"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"poczta",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);
	
$akcje_tab["poczta_wiadomosc"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"poczta",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>""	
);

$akcje_tab["poczta_wiadomosc2"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"poczta_wys"	
);

$akcje_tab["poczta_wiadomosca2"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"poczta",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"poczta_wys"	
);

$akcje_tab["poczta_usun"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"poczta",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""	
);


$akcje_tab["poczta_usunc"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"poczta",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"poczta_kosz"	
);

$akcje_tab["poczta_odpowiedziane"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"poczta",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"poczta_odb"	
);

$akcje_tab["poczta_przeczytane"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"poczta_odb"	
);

$akcje_tab["poczta_nieprzeczytane"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"poczta",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"poczta_odb"	
);

$akcje_tab["poczta_przywroc"]=array(
	"dostep"=>user::get()->zalogowany(),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"poczta",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>"poczta_kosz"	
);

$akcje_tab["poczta_kontakty"]=array(
	"dostep"=>user::get()->zalogowany()&&konf::get()->plikWarunek("ajax.php"),
	"akcja_brakdostepu"=>"u_zaloguj",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"poczta",					
	"akcja_koniec"=>true,		
	"akcja_nastepna"=>"",
);

?>