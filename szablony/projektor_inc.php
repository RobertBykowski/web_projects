<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

function glowa(){

	echo "<?xml version=\"1.0\" encoding=\"".konf::get()->getKonfigTab("charset")."\"?>";
  ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="<?php echo konf::get()->getLangR(); ?>"> 
<head>
<meta http-equiv="Content-type" content="text/html; charset=<?php echo konf::get()->getKonfigTab("charset"); ?>" />
<meta http-equiv="Content-Language" content="<?php echo konf::get()->getLangR(); ?>" />
<meta http-equiv="Reply-to" content="<?php echo konf::get()->getKonfigTab('autor_email'); ?>" />
<meta name="Author" content="<?php echo konf::get()->getKonfigTab('autor'); ?>" />
<meta name="robots"	content="index,follow" />
<meta name="keywords"	content="[[-keywords-]]" />
<meta name="description" content="[[-description-]]" />
<title>[[-tytul-]]</title>
<script type="text/javascript" src="<?php echo konf::get()->getKonfigTab("sciezka"); ?>js/local.js" ></script>
<link href="<?php echo konf::get()->getKonfigTab("sciezka"); ?>css/styl.css" type="text/css" rel="stylesheet" />
[[-plikiheader-]][[-kodheader-]]
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
</head>
<body class="srodek" [[-kodonload-]]>
	
	<?php	
	echo "<table class=\"seta\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"border-collapse: collapse; \">";
	
	?>[[-kodkomunikaty-]]<?php
	
}

function stopka(){

	?>
	</table>
	[[-kodfooter-]]	
	</body></html>
	<?php
	
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
				$html.=$val['txt']."<br />";
		}
	}
	
	return $html;
	
}


function tab_nagl($tytul,$colspan="",$id="",$class=""){

	$html="<table class=\"tabelka ".$class."\" cellspacing=\"0\" cellpadding=\"4\" border=\"1\"";
	if($id){
		$html.=" id=\"".$id."\"";
	}
	$html.=">";
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

	$html="</table>";
	
	return $html;
	
}



?>