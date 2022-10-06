<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

konf::get()->setTekstyTab("znajomi_texty",2);

$konfig_znajomi['na_str']=20; //osob na podstronie
$konfig_znajomi['szuk_na_str']=20; //wyszukiwanie na str
$konfig_znajomi['na_str']=20; //znajomi na str
$konfig_znajomi['wys_kolumn']=4; //ile kolumn znajomych
$konfig_znajomi['szuk_sort']="autor_kiedy DESC, id DESC"; //czy czarna lista
$konfig_znajomi['wys_grafika']=false; //czy czarna lista
$konfig_znajomi['zaprosdo']=true; //czy czarna lista

konf::get()->setKonfigTab(array("znajomi_konf"=>$konfig_znajomi));

?>