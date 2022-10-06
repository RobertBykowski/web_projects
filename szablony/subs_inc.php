<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}


//poczatek kodu html
function glowa(){

  echo "<?xml version=\"1.0\" encoding=\"".konf::get()->getKonfigTab("charset")."\"?>"; 
  echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"DTD/xhtml1-transitional.dtd\">";
  echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"pl\" lang=\"pl\">";
	echo "<head><title>".konf::get()->getKonfigTab('nazwa_www')."</title>";
	echo "<meta http-equiv=\"Content-type\" content=\"text/html; charset=".konf::get()->getKonfigTab("charset")."\" />";
	echo "<meta http-equiv=\"Content-Language\" content=\"pl\" />";
	?>
	<link href="<?php echo konf::get()->getKonfigTab("sciezka"); ?>grafika/admin.css" type="text/css" rel="stylesheet" />
	<link href="<?php echo konf::get()->getKonfigTab("sciezka"); ?>grafika/s<?php echo konf::get()->getStyl(); ?>/panel.css" type="text/css" rel="stylesheet" />
	<?php
	echo "[[-plikiheader-]]";	
	echo "</head>";
	echo "<body onload=\"subs_nastepna()\">";
	
	echo "<table border=\"0\" cellspacing=\"5\" cellpadding=\"0\" class=\"szerokosc srodek\"><tr><td valign=\"top\" class=\"lewa\">";		
	
	?>[[-kodkomunikaty-]]<?php	
		
}


function stopka(){

	echo "</td></tr></table></body></html>";	
	
}


function rysuj_komunikaty($komunikaty=array()){

	$html="";
	
	reset($komunikaty);
	while(list($key,$val)=each($komunikaty)){
		switch($val['typ']){
			case 'error':
				$html.="<div class=\"error\">".$val['txt']."</div>";
			break;

			default:
				$html.="<div>".$val['txt']."</div>";
		}
	}
	
	return $html;
	
}


function tab_nagl($tytul="",$colspan="",$align="",$help=""){

	$html="<table class=\"tlo1 seta\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"margin-bottom:3px\">";
  $html.="<tr><td><table class=\"seta\" cellspacing=\"1\" cellpadding=\"3\" border=\"0\">\n\n";
	if(!empty($tytul)){ 
		$html.="<tr><td class=\"tlo2 lewa grube\"";
		if(!empty($colspan)&&$colspan!="1"){
			$html.=" colspan=\"".$colspan."\"";
		}
		$html.=">".$tytul."</td></tr>";
	}
	
	return $html;
	
}


function tab_stop(){

	$html="\n\n</table>";
	$html.="</td></tr>";
	$html.="</table>";
	
	return $html;
	
}

?>