<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

//zamknij polaczenie sql
if(konf::get()->getKonfigTab('mysql_baza')){
	$bazasql->close();	
}
	
?>