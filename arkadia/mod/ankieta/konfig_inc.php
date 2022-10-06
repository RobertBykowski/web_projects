<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

konf::get()->setTekstyTab("ankieta_texty",2);

$konfig_ankieta['ile_odp']=10; //max ile mozliwych odpowiedzi
$konfig_ankieta['notuj_ip']=true; //czy notowac ostatnie IP
$konfig_ankieta['czas_ip']=10; //na jaki czas (dni) zablokowane ostatnie IP
$konfig_ankieta['czas_cookie']=10; //na jaki czas cookie (dni)
$konfig_ankieta['dl_pasek']=250; //max dlugosc paska w archiwum ankiet
$konfig_ankieta['autor']=1; //autor
$konfig_ankieta['tab'][1]=konf::get()->langTexty("ankieta_1");
$konfig_ankieta['admin_ankieta']=user::get()->upr(15);

konf::get()->setKonfigTab(array("ankieta_konf"=>$konfig_ankieta));

?>