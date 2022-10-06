<?php

konf::get()->setTekstyTab("galerie_admin_texty","2");


//admin
$konfig_galerie['admin']=user::get()->upr(4);


//typy galerii

$konfig_galerie['typy_tab']=array();

if(konf::get()->isMod('ugal')){
	$konfig_galerie['typy_tab'][1]=array(
		'mysql'=>konf::get()->getKonfigTab("sql_tab",'uzytkownicy_galeria'),
		'katalog'=>"pics/ugal/",			
		'mysql_koment'=>"",	
		'nazwa'=>"Galerie użytkowników",	
	);
}


if(konf::get()->isMod('grupygal')){
	$konfig_galerie['typy_tab'][2]=array(
		'mysql'=>konf::get()->getKonfigTab("sql_tab",'grupy_galeria'),
		'katalog'=>"pics/grupygal/",			
		'mysql_koment'=>"",			
		'nazwa'=>"Galerie grup",	
	);
}

konf::get()->setKonfigTab(array("galerie_konf"=>$konfig_galerie));

?>