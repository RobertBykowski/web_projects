<?php
//==================================
//skrypt rysowania grafik skalowanych
//wersja 1.0
//autor JWJ (jwaldek@poczta.onet.pl)
//==================================

header("Content-type: image/jpeg");
define("SPR_INCLUDE","tak");

include_once("inc/konfig.php");
include_once("inc/_init_inc.php");
require_once($konfig['klasy']."class.plikzapisz.php");

if(!empty($_GET['rys'])){

	$rys=base64_decode($_GET['rys']);
	
  $plik=new plikZapisz("[nazwa]");
	$plik->kopiujPlik($rys);
	$plik->setImgSkala(3);	
	$plik->setImgSize(array("hmax"=>120,"wmax"=>120));
	$plik->setImgTypy(array(2=>2));
	$plik->setJakosc(85);	
	$zwrot=$plik->zapiszImg(false);	

}

?>