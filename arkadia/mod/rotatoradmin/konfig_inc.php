<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

include_once(konf::get()->getKonfigTab('mod_kat')."rotator/konfig_inc.php");

konf::get()->setTekstyTab("rotator_admin_texty","2");

?>