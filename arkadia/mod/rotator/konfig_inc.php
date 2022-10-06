<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

if(user::get()->zalogowany()){
	konf::get()->setTekstyTab("rotator_texty",2);
} else {
	konf::get()->setTekstyTab("rotator_texty");
}

//graniczne domyslne  rozmiary uploadowanych grafik
$konfig_rotator['img_max_w']=950; 	//max rozmiar, powyzej skalowane lub odrzucane
$konfig_rotator['img_min_w']=10;		//min rozmiar, ponizej odrzucane (z wyjatkiem SWF)
$konfig_rotator['img_max_h']=950; 	//max rozmiar, powyzej skalowane lub odrzucane
$konfig_rotator['img_min_h']=10;		//min rozmiar, ponizej odrzucane (z wyjatkiem SWF)
$konfig_rotator['size_max']=1536000; //150kb, nie dotyczy skalowanych JPG, PNG
$konfig_rotator['skalowanie']=0; //typ skalowania

//czy notować licznik odsłon
$konfig_rotator['licznik']=true;

//domysle tlo dla swf (bez # na poczatku)
$konfig_rotator['tlo_swf']="ffffff";

//katalog na grafike
$konfig_rotator['kat']=konf::get()->getKonfigTab("rotator_kat");

//ile na stronie w administracji
$konfig_rotator['na_str']=20;

//typy plikow (z konfiguracji numery)
$konfig_rotator['typy']=array(1=>1,2=>2,3=>3,4=>4,6=>6,13=>13);


//banery lewa
$konfig_rotator['kat_tab'][1]=array(
  "nazwa"=>konf::get()->langTexty("rot_typy1"),
  "img_max_w"=>210,
	"img_min_w"=>1,	
  "img_max_h"=>400,
	"img_min_h"=>1,	
	"skalowanie"=>2,
	"size_max"=>1036000
);

//banery prawa
$konfig_rotator['kat_tab'][2]=array(
  "nazwa"=>konf::get()->langTexty("rot_typy2"),
  "img_max_w"=>191,
	"img_min_w"=>5,	
  "img_max_h"=>400,
	"img_min_h"=>1,	
	"skalowanie"=>2,	
	"size_max"=>1036000
);

//top layer
$konfig_rotator['kat_tab'][3]=array(
  "nazwa"=>konf::get()->langTexty("rot_typy3"),
  "img_max_w"=>600,
	"img_min_w"=>1,	
  "img_max_h"=>600,
	"img_min_h"=>1,	
	"skalowanie"=>3,	
	"size_max"=>3036000
);


//strona glowna
$konfig_rotator['kat_tab'][4]=array(
  "nazwa"=>"Sklep - strona główna",
  "img_max_w"=>563,
	"img_min_w"=>1,	
  "img_max_h"=>150,
	"img_min_h"=>1,	
	"skalowanie"=>2,	
	"size_max"=>1036000
);


$konfig_rotator['admin_rotator']=user::get()->upr(17);

konf::get()->setKonfigTab(array("rotator_konf"=>$konfig_rotator));

?>