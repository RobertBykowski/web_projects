<?php
//nagłówek www, funkcje definiowane niezależnie dla każdej strony www 

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

konf::get()->setTekstyTab("nagloweksklep_texty");

//funkcja wyswietlajaca początek HTML
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
<?php
	konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/jquery-min.js","js");	
?>
<script type="text/javascript" src="<?php echo konf::get()->getKonfigTab("sciezka"); ?>js/local.js" ></script>
<script type="text/javascript" src="<?php echo konf::get()->getKonfigTab("sciezka"); ?>js/swfobject.js"></script>
<link href="<?php echo konf::get()->getKonfigTab("sciezka"); ?>css/sklep.css" type="text/css" rel="stylesheet" />
[[-plikiheader-]][[-kodheader-]]
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<?php
	rss_head();
?>
</head>
<body class="srodek" [[-kodonload-]]>
<?php
if(konf::get()->getAkcja()=="art_powitalna"||konf::get()->getAkcja()=="sklep_powitalna"){
	adv_toplayer();
}
?>

<div id="err_box" style="display:none;">
    <div id="err_validate"></div>
    <div id="err_hide" onclick="$('#err_box').hide('medium')"><?php echo konf::get()->langTexty("err_zamknij"); ?></div>
</div>

<div class="srodek szerokosc">

	<div id="top">
	
		<div id="top2_1"><a href="<?php echo konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array()); ?>"><img src="img/sklep/logo.gif" alt="" width="218" height="91" /></a></div>
		<div id="top2_2"><img src="img/sklep/top.jpg" alt="" width="567" height="131" /></div>
		<div id="top2_3">
		
			<div id="top2_3_1"><div>
				<a href="<?php echo konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"kontakt_polec")); ?>">Poleć serwis</a>
				&nbsp;&nbsp;|&nbsp;&nbsp;
				<a href="<?php echo konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"art_mapa")); ?>">Mapa strony</a>
				
				<a name="www_top"> </a>
			</div></div>
			
			<div id="top2_3_2"><?php
			echo logowanieform();
			?></div>
		
		</div>
	</div>


<?php
	g_menu();
?>

<div id="panel_tr"><table class="srodek szerokosc nowa_l" border="0" cellspacing="0" cellpadding="0">
	<tr valign="top">
	<td id="lewa_k"><div id="lewa_k2"><?php
	
		na_skroty();
	
		$sklep=new sklep();		
		$sklep->katmenu();
				
		banery_rys(1,2);

	?></div></td>	
	<td id="srodek_k">
		
	[[-kodkomunikaty-]]<?php
	
}


function stopka(){

  ?>
	</td>
	
	<td id="prawa_k"><div id="prawa_k2"><?php
	
	twoj_koszyk();		
	$sklep=new sklep();		
	$sklep->wyszukiwarka();					
	kontakt_panel();
	banery_rys(2,2);			

	?></div></td>

	</tr></table>

	<?php	
	d_menu();
	?>
	
	<div id="stopka">
		<div id="stopka1">Copyright <?php echo date("Y"); ?> FLEWER</div>
		<div id="stopka2"><a href="http://jw-webdev.info" target="_blank">Reklama Toruń</a> </div>
	</div>

</div></div>
	
	<?php

		if(konf::get()->isMod('sqllista')){
			require_once(konf::get()->getKonfigTab('klasy')."class.sqllista.php");	
			$sqllista=new sqllista();		
			$sqllista->wyswietl();
	  }
		
		if(konf::get()->isMod('akcjelista')){
			require_once(konf::get()->getKonfigTab('klasy')."class.akcjelista.php");	
			$akcjelista=new akcjelista();		
			$akcjelista->wyswietl();
	  }		

		if(konf::get()->isMod('pasekreklama')){
			require_once(konf::get()->getKonfigTab('klasy')."class.pasekreklama.php");	
			$pasekreklama=new pasekreklama();		
			$pasekreklama->setTekst("test test test test test test test test test test testtest test test test test test test test test test testtest test test test test test test test test test testtest test test test test test test test test test test");
			$pasekreklama->wyswietl();
		}

	?>
	[[-kodfooter-]]
	</body></html>
  <?php
}



function na_skroty(){

	echo "<div class=\"na_skroty\">NA SKRÓTY</div>";	
	echo "<a class=\"na_skroty\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklep_nowosci"))."\">Nowości w ofercie</a>";
	echo "<a class=\"na_skroty\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklep_promocje"))."\">Promocje</a>";
	echo "<a class=\"na_skroty\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklep_poleca"))."\">FLEWER poleca</a>";
	echo "<a class=\"na_skroty\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklep_wyprzedaz"))."\">Wyprzedaż</a>";	
	
	if(user::get()->administrator()){
		echo "<a class=\"na_skroty\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_panel"))."\">Panel administracyjny</a>";
	}	
	
	echo "<div class=\"od\"></div>";
}



function banery_rys($typy,$ile){

	if(konf::get()->isMod('rotator')){
		$banery=new banery($typy,$ile);
		$banery->generuj();		
		$banery1=$banery->getBanery();				
		if(!empty($banery1)){
			while(list($key,$val)=each($banery1)){
				echo "<div class=\"banery\">".$val."</div>";
			}
		}
	}	
	
}


function adv_toplayer(){

	$limit=5; //ile max wysweitlen	
	$czas=60000; //po ilu mikrosekundach zamknac  automatycznie
	$czas_cookie=2592000; //na jaki cas cookie 0 - bez cookie
	$top=180; //ile px od gory
	$typ=3; //typ reklam z rotatora
	
	if(konf::get()->isMod('rotator')){
	
		$banery=new banery($typ,1);
		$banery->generuj();		
		$banery1=$banery->getBanery();		

		if(!empty($banery1)){		
		
			while(list($key,$val)=each($banery1)){
			
				$top_bylo=konf::get()->getZmienna("","","","top_layer");		
			
				if(empty($top_bylo[$key])){
					$top_bylo[$key]=1;
				} else {
					$top_bylo[$key]++;				
				}
				
				if(!empty($czas_cookie)&&$top_bylo[$key]<=$limit){
				
 					if(!empty($czas_cookie)){
						konf::get()->zapiszCookie("top_layer[".$key."]",$top_bylo[$key],$czas_cookie);
					}
				
					echo "<div id=\"adv_layer\" style=\"position:absolute; top:".$top."px; z-index:200;\" class=\"srodek seta\">";	
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"srodek\"><tr><td>";			
					echo "<div class=\"prawa\"><img src=\"grafika/close.gif\" onclick=\"adv_close();\" style=\"cursor: pointer;\" alt=\"\" /></div>";
					echo "<div class=\"srodek\">".$val."</div>";					
					echo "</td></tr></table>";
					echo "<script type=\"text/javascript\">\n";
	    		echo "setTimeout('adv_close()',".$czas.");\n";
					echo "</script>";
					echo "</div>";
					
				}
			
			}
		}
	}	
	
}

function lang_menu(){

	$tab_lang=konf::get()->getKonfigTab('tab_lang');
  if($tab_lang&&is_array($tab_lang)){
  	while(list($key,$val)=each($tab_lang)){
  		echo "<td><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("lang"=>$key),false)."\"><img src=\"grafika/l_".$val.".gif\" alt=\"".$val."\" width=\"22\" height=\"13\" style=\"border:1px solid #000000\" /></a></td>";				  	
  	}
  } 
	  	
}

	
function g_menu(){

	$id_art=konf::get()->getZmienna("id_art","id_art");
	
	

	$dane_tab=konf::get()->_bazasql->pobierzRekordy("SELECT id, id_matka, tytul, tytul_menu, link, link_okno, idtf_link, idtf FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id_d=5 AND status=1 AND poziom=0 AND menu_nie=0 AND lang='".konf::get()->getLang()."' AND (data_start='0000-00-00 00:00:00' OR data_start<=NOW()) AND (data_stop='0000-00-00 00:00:00' OR data_stop>=NOW()) ORDER BY id_matka, nr_poz,id DESC","id");
	
	while(list($key,$dane)=each($dane_tab)){
		$tab[$dane['id_matka']][]=$dane;
	}
	
	echo "<div id=\"menukontener\">";
	
	if(!empty($tab)&&!empty($tab[0])&&is_array($tab[0])){
		

		$art=new art();		
		
		echo "<ul>";
		
		reset($tab[0]);
		while(list($key,$val)=each($tab[0])){
			if(!empty($val)){
	
				if(!empty($val['tytul_menu'])){
					$val['tytul']=$val['tytul_menu'];
				}	
				
				echo "<li><a ";
				if(($id_art==$val['id'])||(konf::get()->getAkcja()=="sklep_powitalna"&&$val['idtf']=="glowna")||(konf::get()->getAkcja()=="kontakt_formularz"&&$val['idtf']=="kontakt")){
					echo "class=\"menu2\" ";
				}
				echo $art->artLink($val).">".$val['tytul']."</a></li>";
	
			}
		}	
		
		echo "</ul>";
		
	}
	
	echo "</div>";

}



//prosty formularz logowania/wylogowywania
function logowanieform($redir=""){

	if(empty($redir)){
		$redir=konf::get()->getZmienna("redir","redir");	
	} else {
		$redir=base64_encode($redir);
	}
	
	$redir=str_replace("&amp;","&",$redir);	
	
	$html="<div>";
	
	$form=new formularz("post",konf::get()->getKonfigTab("plik"),"logowanie2","logowanie2");
	
	if(!user::get()->zalogowany()){
		$html.=$form->spr(array(1=>"u_login",2=>"u_haslo"));	
	}
	$html.=$form->getFormp();	
	
	if(user::get()->zalogowany()){
	
		$html.="<div class=\"srodek\" style=\"padding-bottom:10px;\">";
		$html.="<div style=\"padding-bottom:10px;\">zalogowany: <span class=\"grube\">".user::get()->login()."</span></div>";
		
		if(konf::get()->getSzablon()=="admin"){
			$html.=$form->przenies(array("akcja"=>"u_wylogujadmin"));			
		} else {
			$html.=$form->przenies(array("akcja"=>"u_wyloguj"));
		}
		$html.=$form->input("submit","","u_wyloguj",konf::get()->langTexty("nagl_log_wyloguj"),"formularz2 f_krotki");			
	
		$html.="</div>";
		
		if(konf::get()->getKonfigTab("u_konf",'odzysk')){ 
			$html.="<div class=\"lewa\"><a class=\"male\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_edytuj"))."\">moje konto</a></div>"; 
			$html.="<div class=\"lewa\"><a class=\"male\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"zamowienia_arch"))."\">historia zamówień</a></div>"; 
		}					
		
	} else {

		if(konf::get()->getSzablon()=="admin"){
			$html.=$form->przenies(array("akcja"=>"u_zalogujadmin2","redir"=>$redir));				
		} else {
			$html.=$form->przenies(array("akcja"=>"u_zaloguj2","redir"=>$redir));	
		}
		
		$html.=$form->input("text","u_login","u_login2","","f_sredni",50);			
		$html.=" &nbsp;".konf::get()->langTexty("nagl_log_login")."<br />";		
		$html.=$form->input("password","u_haslo","u_haslo2","","f_sredni",50," autocomplete=\"off\"");			
		$html.=" &nbsp;".konf::get()->langTexty("nagl_log_haslo")."<br />";

		$html.=$form->input("submit","","",konf::get()->langTexty("nagl_log_zaloguj"),"formularz2 f_krotki");		
		$html.="<div class=\"lewa\" style=\"padding-top:4px;\">";	
		if(!konf::get()->getKonfigTab("u_konf",'tylko_admin')){ 
			$html.="<a class=\"male\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dodaj"))."\">".konf::get()->langTexty("nagl_log_zaloz")."</a>"; 
		}
		if(konf::get()->getKonfigTab("u_konf",'odzysk')){ 
			$html.=" | <a class=\"male\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_od"))."\">".konf::get()->langTexty("nagl_log_zapomnialem")."</a>"; 
		}
		$html.="</div>";
		
	}
	$html.=$form->getFormk();	
	$html.="</div>";

	return $html;

}


function twoj_koszyk(){

	$produkty=konf::get()->getZmienna("","","produkty");
	$kwota=konf::get()->getZmienna("","","kwota")+0;

	echo "<div id=\"twojkoszyk\"><div id=\"twojkoszyk2\">";
	
	if(empty($produkty)||!is_array($produkty)){
		echo "<div class=\"srodek\" style=\"padding-top:20px;\">Brak produktów w koszyku</div>";
	} else {

		$ile=0;
		while(list($key,$val)=each($produkty)){		
			while(list($key2,$val2)=each($val)){					
				$ile+=$val2;
			}
		}
		echo "<div class=\"srodek\">Ilość produktów w koszyku: <strong>".$ile."</strong></div>";	
		echo "<div class=\"srodek\">Wartość produktów: <strong>".sprintf('%.2f',$kwota)."</strong> zł</div>";	
		
		echo "<div class=\"srodek\" style=\"padding-top:7px;\">";
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"koszyk","koszyk");		
		echo $form->getFormp();	
		echo $form->przenies(array("akcja"=>"koszyk_zobacz"));		
		echo $form->input("submit","","","Mój koszyk","formularz2 f_krotki");						
		echo $form->getFormk();				
		echo "</div>";
		
	}

	echo "</div></div>";
	echo "<div class=\"od\"></div>";	

}


function d_menu(){

	$art=new art();			
	
	$zap=konf::get()->_bazasql->zap("SELECT id, id_matka, tytul, tytul_menu, link, link_okno FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id_d=5 AND status=1 AND id_matka=0 AND lang='".konf::get()->getLang()."' AND (data_start='0000-00-00 00:00:00' OR data_start<=NOW()) AND (data_stop='0000-00-00 00:00:00' OR data_stop>=NOW()) ORDER BY nr_poz,id DESC");
	$i=0;
	
	echo "<div id=\"d_menu\">";
	
	while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
		if($i>0){
			echo "&nbsp;&nbsp; : &nbsp;&nbsp;";
		}
		if(!empty($dane['tytul_menu'])){
			$dane['tytul']=$dane['tytul_menu'];
		}
		echo "<a ".$art->artLink($dane).">".$dane['tytul']."</a> ";				
		$i++;
	}		
	
	echo "</div>";
		

}


function news_menu(){

	//lewe newsy
	
	$art=new art();
	$dane=$art->pobierzIdtf('news',true,true);
	
	if(!empty($dane)){
	
		$zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id_matka='".$dane['id']."' AND typ=3 ".$art->sqlAdd()." ORDER BY data_wys DESC, id DESC LIMIT 0,".$dane['na_str']);
		
		if(konf::get()->_bazasql->numRows($zap)>0){
			echo "<div>";
			
			while($dane2=konf::get()->_bazasql->fetchAssoc($zap)){
				echo "<div class=\"tlo4 lewa nowa_l\" style=\"padding:7px; border-bottom:1px solid #ffffff\">";
				echo "<div class=\"news_tyt\">".$dane2['tytul']."</div>";
				echo $dane2['zajawka'];
				echo "<div class=\"prawa\" style=\"padding-top:5px;\"><a ".$art->artLink($dane2).">".konf::get()->langTexty("wiecej")." &raquo;</a></div>";
				echo "</div>";
			}		
					
			echo "</div>";
		}
		konf::get()->_bazasql->freeResult($zap);
		
	}
	//k lewe newsy	
	
}


function rss_head(){

	$zap=konf::get()->_bazasql->zap("SELECT id, tytul FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE rss=1 AND (data_start<=NOW() OR data_start='0000-00-00 00:00:00')  AND (data_stop>=NOW() OR data_stop='0000-00-00 00:00:00') AND status=1 ORDER BY id_matka, nr_poz, id");
	while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
		echo "<link rel=\"alternate\" title=\"".htmlspecialchars($dane['tytul'])."\" href=\"".konf::get()->getKonfigTab("sciezka")."rss.php?id_art=".$dane['id']."\" type=\"application/rss+xml\" />";
	}
	konf::get()->_bazasql->freeResult($zap);
		
}


function tab_nagl($tytul="",$colspan="",$id="",$class=""){

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


function subskrypcja(){

	echo "<div class=\"srodek\"><div class=\"srodek\" style=\"padding-top:25px; padding-bottom:20px; width:200px\">";
	
  echo tab_nagl(konf::get()->langTexty("nagl_subs"),1);
  echo "<tr><td class=\"tlo3 lewa\">";
	
	$form=new formularz("post",konf::get()->getKonfigTab("plik"),"subs","subs");	
	echo $form->spr(array(1=>"subs_email"));
	echo $form->getFormp();	
	echo $form->przenies(array("id_subs"=>1));
  echo "<div class=\"male\">".konf::get()->langTexty("nagl_subs_podajemail")."</div>";
	echo $form->input("text","subs_email","subs_email","","f_dlugi",50);			
  echo "<br />";
	echo $form->select("akcja","akcja",array(
		"subs_zapisz"=>konf::get()->langTexty("nagl_subs_zapisz"),
		"subs_wypisz"=>konf::get()->langTexty("nagl_subs_wypisz")
	),"","f_sredni");
  echo "&nbsp;";
	
	echo $form->input("submit","","",konf::get()->langTexty("nagl_subs_wyslij"),"formularz2 f_krotki");				
	echo $form->getFormk();	
  echo "</td></tr>";
  echo tab_stop();		
			
	echo "</div></div>";

}


function kontakt_panel(){

	echo "<div class=\"od\"></div>";	
	echo "<div id=\"kontakt_panel\"><div id=\"kontakt_panel2\">";
	
	$art=new art();
	$dane=$art->pobierzIdtf('kontakt_panel',true,true);
	if(!empty($dane)){
		echo "<div id=\"kontakt_panel_tyt\">".$dane['tytul']."</div>";
		echo $dane['zajawka'];
	} else {
		echo "&nbsp;";
	}				

	
	echo "</div></div>";

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

?>