<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

if(user::get()->zalogowany()){
	konf::get()->setTekstyTab("poczta_texty",2);
} else {
	konf::get()->setTekstyTab("poczta_texty");
}

$konfig_poczta['na_str']=20; //waidomosci na podstronie
$konfig_poczta['limit']=500; //limit wiadomosci  wyslanych
$konfig_poczta['wlimit']=4000; //limit dlugosci wiadomosci
$konfig_poczta['kosz']=true; //czy uzywac kosza przy usuwaniu
$konfig_poczta['systemowe']=true; //czy osobno lista wiadomosci systemowych
$konfig_poczta['powiadomienie']=true; //powiadomienie o nowej poczcie
$konfig_poczta['lista_zdjecie']=true; //czy miniaturki zdjec na liscie
$konfig_poczta['menu_nowe']=true; //czy w menu info o nowej poczcie
$konfig_poczta['tresc_skrot']=45; //na liscie waidomosci ile znakow skrotu emaila (0= bez skrotu)
$konfig_poczta['adresatajax']=true; //czy wybierac adresata za pomoca ajax czy tez wszyscy od razu jako lista select?

//statusy wiadomosci
$konfig_poczta['statusy_tab']=array(
	1=>konf::get()->langTexty("poczta_status1"), //nowa
	2=>konf::get()->langTexty("poczta_status2"), //przeczytana
	3=>konf::get()->langTexty("poczta_status3"), //odpowiedziana
	4=>konf::get()->langTexty("poczta_status4")  //usunieta
);

//typy wiadomosci_systemowych
$konfig_poczta['systemowe_tab']=array(
	1=>"zaproszenie do znajomości", 
	2=>"zaproszenie do grupy",
);

konf::get()->setKonfigTab(array("poczta_konf"=>$konfig_poczta));

?>