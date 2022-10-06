<?php
//akcje 

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}


$akcje_tab["u_zaloguj"]=array(
	"dostep"=>true,		
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,	
	"akcja_naglowek"=>true,	
	"akcja_stopka"=>true,	
	"szablon"=>"",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);


$akcje_tab["u_zalogujadmin"]=array(
	"dostep"=>true,		
	"akcja_brakdostepu"=>"",
	"nowy_obiekt"=>false,	
	"akcja_naglowek"=>true,	
	"akcja_stopka"=>true,	
	"szablon"=>"admin",
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);


$akcje_tab["u_wylogujadmin"]=array(
	"dostep"=>true,								//dostep do akcji
	"akcja_brakdostepu"=>"",			//akcja w przypadku braku dostepu		
	"nowy_obiekt"=>false,					//czy tworzyc nowy obiekt jesli juz istnieje
	"akcja_naglowek"=>false,			//czy rysowac naglowek
	"akcja_stopka"=>false,				//czy rysowac stopke
	"szablon"=>"",								//szablon
	"akcja_koniec"=>false,				//koniec ciagu akcji
	"akcja_nastepna"=>"u_zalogujadmin"	//jaka akcja nastepna (jesli puste to domyslna akcja)
);

$akcje_tab["u_wyloguj"]=array(
	"dostep"=>true,								//dostep do akcji
	"akcja_brakdostepu"=>"",			//akcja w przypadku braku dostepu		
	"nowy_obiekt"=>false,					//czy tworzyc nowy obiekt jesli juz istnieje
	"akcja_naglowek"=>false,			//czy rysowac naglowek
	"akcja_stopka"=>false,				//czy rysowac stopke
	"szablon"=>"",								//szablon
	"akcja_koniec"=>false,				//koniec ciagu akcji
	"akcja_nastepna"=>"u_zaloguj"	//jaka akcja nastepna (jesli puste to domyslna akcja)
);


$akcje_tab["u_zaloguj2"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""	
);


$akcje_tab["u_zalogujadmin2"]=array(
	"dostep"=>true,
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"admin",					
	"akcja_koniec"=>false,		
	"akcja_nastepna"=>""	
);


$akcje_tab["u_pt"]=array(
	"dostep"=>!user::get()->zalogowany(),		
	"akcja_brakdostepu"=>"u_dane",
	"nowy_obiekt"=>false,			
	"akcja_naglowek"=>true,
	"akcja_stopka"=>true,
	"szablon"=>"",
	"akcja_koniec"=>true,	
	"akcja_nastepna"=>""	
);


$akcje_tab["u_pt2"]=array(
	"dostep"=>!user::get()->zalogowany(),		
	"akcja_brakdostepu"=>"u_dane",
	"nowy_obiekt"=>false,	
	"akcja_naglowek"=>false,	
	"akcja_stopka"=>false,	
	"szablon"=>"",
	"akcja_koniec"=>false,
	"akcja_nastepna"=>""
);


$akcje_tab["u_od"]=array(
	"dostep"=>true,			
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,	
	"akcja_naglowek"=>true,	
	"akcja_stopka"=>true,
	"szablon"=>"",
	"akcja_koniec"=>true,	
	"akcja_nastepna"=>""
);

$akcje_tab["u_od2"]=array(
	"dostep"=>true,					
	"akcja_brakdostepu"=>"",		
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>false,			
	"akcja_stopka"=>false,				
	"szablon"=>"",								
	"akcja_koniec"=>false,				
	"akcja_nastepna"=>"u_zaloguj"	
);

$akcje_tab["u_od3"]=array(
	"dostep"=>true,					
	"akcja_brakdostepu"=>"",		
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>true,			
	"akcja_stopka"=>true,				
	"szablon"=>"",								
	"akcja_koniec"=>true,				
	"akcja_nastepna"=>""	
);


$akcje_tab["u_od4"]=array(
	"dostep"=>true,					
	"akcja_brakdostepu"=>"",		
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>false,			
	"akcja_stopka"=>false,				
	"szablon"=>"",								
	"akcja_koniec"=>false,				
	"akcja_nastepna"=>"u_zaloguj"	
);


$akcje_tab["u_dodaj"]=array(
	"dostep"=>true,					
	"akcja_brakdostepu"=>"",		
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>true,			
	"akcja_stopka"=>true,				
	"szablon"=>"",								
	"akcja_koniec"=>true,				
	"akcja_nastepna"=>""	
);

if(user::get()->adminU()){
	$akcje_tab["u_dodaj"]["szablon"]="admin";
}

$akcje_tab["u_dodaj2"]=array(
	"dostep"=>true,					
	"akcja_brakdostepu"=>"",		
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>false,			
	"akcja_stopka"=>false,				
	"szablon"=>"",								
	"akcja_koniec"=>false,				
	"akcja_nastepna"=>""	
);


$akcje_tab["u_edytuj"]=array(
	"dostep"=>user::get()->zalogowany(),					
	"akcja_brakdostepu"=>"u_zaloguj",		
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>true,			
	"akcja_stopka"=>true,				
	"szablon"=>"",								
	"akcja_koniec"=>true,				
	"akcja_nastepna"=>""	
);


if(user::get()->adminU()){
	$akcje_tab["u_edytuj"]["szablon"]="admin";
}

$akcje_tab["u_edytuj2"]=array(
	"dostep"=>user::get()->zalogowany(),					
	"akcja_brakdostepu"=>"u_zaloguj",		
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>false,			
	"akcja_stopka"=>false,				
	"szablon"=>"",								
	"akcja_koniec"=>false,				
	"akcja_nastepna"=>""	
);


$akcje_tab["u_dane"]=array(
	"dostep"=>user::get()->zalogowany(),					
	"akcja_brakdostepu"=>"u_zaloguj",		
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>true,			
	"akcja_stopka"=>true,				
	"szablon"=>"profil",								
	"akcja_koniec"=>true,				
	"akcja_nastepna"=>""	
);

if(user::get()->adminU()&&konf::get()->getKonfigTab("strona_typ")!="portal"){
	$akcje_tab["u_dane"]["szablon"]="admin";
	$akcje_tab["u_dane"]["akcja_brakdostepu"]="u_zalogujadmin";	
}

$akcje_tab["u_styl"]=array(
	"dostep"=>true,					
	"akcja_brakdostepu"=>"u_panel",		
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>false,			
	"akcja_stopka"=>false,				
	"szablon"=>"admin",								
	"akcja_koniec"=>false,				
	"akcja_nastepna"=>"u_panel"	
);


$akcje_tab["u_panel"]=array(
	"dostep"=>user::get()->administrator(),					
	"akcja_brakdostepu"=>"u_zalogujadmin",	
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>true,			
	"akcja_stopka"=>true,				
	"szablon"=>"admin",								
	"akcja_koniec"=>true,				
	"akcja_nastepna"=>""	
);

$akcje_tab["u_systemowe"]=array(
	"dostep"=>user::get()->adminGlowny(),					
	"akcja_brakdostepu"=>"u_panel",	
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>true,			
	"akcja_stopka"=>true,				
	"szablon"=>"admin",								
	"akcja_koniec"=>true,				
	"akcja_nastepna"=>""	
);


$akcje_tab["u_phpinfowys"]=array(
	"dostep"=>user::get()->adminGlowny(),					
	"akcja_brakdostepu"=>"u_panel",	
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>true,			
	"akcja_stopka"=>true,				
	"szablon"=>"phpinfo",								
	"akcja_koniec"=>true,				
	"akcja_nastepna"=>""	
);

if(user::get()->zalogowany()){
	$akcje_tab["u_panel"]["akcja_brakdostepu"]="u_edytuj";
}

$akcje_tab["u_pusta"]=array(
	"dostep"=>true,					
	"akcja_brakdostepu"=>"",	
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>false,
	"akcja_stopka"=>false,
	"szablon"=>"",						
	"akcja_koniec"=>true,
	"akcja_nastepna"=>""
);


$akcje_tab["u_haslo"]=array(
	"dostep"=>user::get()->zalogowany(),					
	"akcja_brakdostepu"=>"u_zaloguj",		
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>true,			
	"akcja_stopka"=>true,				
	"szablon"=>"",								
	"akcja_koniec"=>true,				
	"akcja_nastepna"=>""	
);

$akcje_tab["u_haslo2"]=array(
	"dostep"=>user::get()->zalogowany(),					
	"akcja_brakdostepu"=>"",		
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>false,			
	"akcja_stopka"=>false,				
	"szablon"=>"",								
	"akcja_koniec"=>false,				
	"akcja_nastepna"=>""	
);

$akcje_tab["u_email"]=array(
	"dostep"=>user::get()->zalogowany(),					
	"akcja_brakdostepu"=>"u_zaloguj",		
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>true,			
	"akcja_stopka"=>true,				
	"szablon"=>"",								
	"akcja_koniec"=>true,				
	"akcja_nastepna"=>""	
);


$akcje_tab["u_email2"]=array(
	"dostep"=>user::get()->zalogowany(),					
	"akcja_brakdostepu"=>"",		
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>false,			
	"akcja_stopka"=>false,				
	"szablon"=>"",								
	"akcja_koniec"=>false,				
	"akcja_nastepna"=>""	
);

$akcje_tab["u_email3"]=array(
	"dostep"=>user::get()->zalogowany(),					
	"akcja_brakdostepu"=>"",		
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>false,			
	"akcja_stopka"=>false,				
	"szablon"=>"",								
	"akcja_koniec"=>false,				
	"akcja_nastepna"=>""	
);


$akcje_tab["u_zablokowany"]=array(
	"dostep"=>user::get()->zalogowany(),					
	"akcja_brakdostepu"=>"u_zaloguj",		
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>true,			
	"akcja_stopka"=>true,				
	"szablon"=>"",								
	"akcja_koniec"=>true,				
	"akcja_nastepna"=>""	
);


$akcje_tab["u_usun"]=array(
	"dostep"=>user::get()->zalogowany(),					
	"akcja_brakdostepu"=>"u_zaloguj",		
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>true,			
	"akcja_stopka"=>true,				
	"szablon"=>"",								
	"akcja_koniec"=>true,				
	"akcja_nastepna"=>""	
);

$akcje_tab["u_usun2"]=array(
	"dostep"=>user::get()->zalogowany(),					
	"akcja_brakdostepu"=>"",		
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>false,			
	"akcja_stopka"=>false,				
	"szablon"=>"",								
	"akcja_koniec"=>false,				
	"akcja_nastepna"=>""	
);

$akcje_tab["u_zaawansowane"]=array(
	"dostep"=>user::get()->zalogowany(),					
	"akcja_brakdostepu"=>"u_zaloguj",		
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>true,			
	"akcja_stopka"=>true,				
	"szablon"=>"portal",								
	"akcja_koniec"=>true,				
	"akcja_nastepna"=>""	
);


$akcje_tab["u_preferencje"]=array(
	"dostep"=>user::get()->zalogowany(),					
	"akcja_brakdostepu"=>"u_zaloguj",		
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>true,			
	"akcja_stopka"=>true,				
	"szablon"=>"",								
	"akcja_koniec"=>true,				
	"akcja_nastepna"=>""	
);

$akcje_tab["u_preferencje2"]=array(
	"dostep"=>user::get()->zalogowany(),					
	"akcja_brakdostepu"=>"",		
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>false,			
	"akcja_stopka"=>false,				
	"szablon"=>"",								
	"akcja_koniec"=>false,				
	"akcja_nastepna"=>"u_preferencje"	
);


$akcje_tab["u_opisowe"]=array(
	"dostep"=>user::get()->zalogowany(),					
	"akcja_brakdostepu"=>"u_zaloguj",		
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>true,			
	"akcja_stopka"=>true,				
	"szablon"=>"",								
	"akcja_koniec"=>true,				
	"akcja_nastepna"=>""	
);

$akcje_tab["u_opisowe2"]=array(
	"dostep"=>user::get()->zalogowany(),					
	"akcja_brakdostepu"=>"",		
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>false,			
	"akcja_stopka"=>false,				
	"szablon"=>"",								
	"akcja_koniec"=>false,				
	"akcja_nastepna"=>"u_opisowe"	
);

$akcje_tab["u_powitalna"]=array(
	"dostep"=>true,					
	"akcja_brakdostepu"=>"",		
	"nowy_obiekt"=>false,				
	"akcja_naglowek"=>true,			
	"akcja_stopka"=>true,				
	"szablon"=>"",								
	"akcja_koniec"=>true,				
	"akcja_nastepna"=>""	
);

?>