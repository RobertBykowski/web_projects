<?php
//konfiguracja ksiegi gosci 

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

konf::get()->setTekstyTab("koment_texty");

//max domyślna dlugosc komentarza (0-bez limitu)
$konfig_koment['limit_znakow']=4000;

//jeśli podział na podstrony to ile zmiennych na podstronie
$konfig_koment['na_str']=3;

//lamanie znakow
$konfig_koment['linia_znakow']=50;

//automatyczne linkowanie
$konfig_koment['autolink']=true;

//na jaki czas (ile dni) zapisywać dane w cookie
$konfig_koment['cookie']=60;

//styl pola txt
$konfig_koment['form_class']="f_bdlugi2";

//emotikony
$konfig_koment['emotikony']=true;

//sortowanie
$konfig_koment['order']="autor_kiedy, id";

//domyslny status komentarza
$konfig_koment['status']=1;

//czy antyspam dla niezalogowanych
$konfig_koment['botproof']=true;

//czy antyspam dla niezalogowanych
$konfig_koment['wys_ip']=false;

//sprawdz czy taki koment juz byl
$konfig_koment['spr_bylo']=false;

//dostep do formularza
$konfig_koment['form_dostep']=user::get()->zalogowany();

//admin
$konfig_koment['admin']=user::get()->upr(12);

//mozna moderowac w swoich wpisach
$konfig_koment['moderator']=true;

//dla moderatora dodatek sql przy usuwaniu
$konfig_koment['sqladd']="";

//tablica pozwalajaca zmienic dane komentarzy dla danego typu komentarzy
$konfig_koment['typy_tab'][1]=array(
	'mysql'=>konf::get()->getKonfigTab("sql_tab",'art_koment'),
	'nazwa'=>"Komentarze do artykułów",	
	'moderator'=>false,
	'sqladd'=>"",
	'form_dostep'=>user::get()->zalogowany(),
	'order'=>'autor_kiedy, id'
);

if(konf::get()->getKonfigTab("u_konf",'koment')){

	$konfig_koment['typy_tab'][2]=array(
		'mysql'=>konf::get()->getKonfigTab("sql_tab",'uzytkownicy_koment'),
		'nazwa'=>"Komentarze do profili użytkowników",	
		'moderator'=>true,
	  'sqladd'=>" AND id_matka='".user::get()->id()."'",			
		'form_dostep'=>user::get()->zalogowany(),
		'order'=>'autor_kiedy, id'
	);
	
}

if(konf::get()->getKonfigTab("u_konf",'galeria_koment')&&konf::get()->isMod('ugal')){

	$konfig_koment['typy_tab'][3]=array(
		'mysql'=>konf::get()->getKonfigTab("sql_tab",'uzytkownicy_galeria_koment'),
		'nazwa'=>"Komentarze do galerii użytkowników",	
		'moderator'=>true,					
		'form_dostep'=>user::get()->zalogowany(),
		'order'=>'autor_kiedy, id'
	);
	
}

if(konf::get()->isMod('grupygal')){

	$konfig_koment['typy_tab'][4]=array(
		'mysql'=>konf::get()->getKonfigTab("sql_tab",'grupy_galeria_koment'),
		'nazwa'=>"Komentarze do galerii grup",	
		'form_dostep'=>user::get()->zalogowany(),
		'order'=>'autor_kiedy, id'
	);
	
}


if(konf::get()->isMod('sklep')){

	$konfig_koment['typy_tab'][5]=array(
		'mysql'=>konf::get()->getKonfigTab("sql_tab",'sklep_produkty_koment'),
		'nazwa'=>"Komentarze do produktów sklepowych",	
		'form_dostep'=>user::get()->zalogowany(),
		'order'=>'autor_kiedy, id'
	);
	
}

konf::get()->setKonfigTab(array("koment_konf"=>$konfig_koment));

?>