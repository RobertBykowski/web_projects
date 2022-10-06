<?php
//nagłówek www, funkcje definiowane niezależnie dla każdej strony www 

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

konf::get()->setTekstyTab("naglowek_texty");

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
<script type="text/javascript" src="<?php echo konf::get()->getKonfigTab("sciezka"); ?>js/local.js" ></script>
<script type="text/javascript" src="<?php echo konf::get()->getKonfigTab("sciezka"); ?>js/menu/dropdownmenu1.js"></script>
<?php
	konf::get()->setKod("kodonload","menumenu();");
	konf::get()->setKod("kodfooter","<script type=\"text/javascript\">setTimeout(\"menu_ods()\",200);</script>");		
	konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/jquery-min.js","js");
?>
<script type="text/javascript" src="<?php echo konf::get()->getKonfigTab("sciezka"); ?>js/swfobject.js"></script>
<link href="<?php echo konf::get()->getKonfigTab("sciezka"); ?>css/portal.css" type="text/css" rel="stylesheet" />
[[-plikiheader-]][[-kodheader-]]
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<?php
if(konf::get()->getKonfigTab('art_konf',"rss")){
	rss_head();
}
?>
</head>
<body class="srodek" [[-kodonload-]]>

<?php
if(konf::get()->getAkcja()=="art_powitalna"){
	adv_toplayer();
}
?>

<div id="err_box" style="display:none;">
    <div id="err_validate"></div>
    <div id="err_hide" onclick="$('#err_box').hide('medium')"><?php echo konf::get()->langTexty("err_zamknij"); ?></div>
</div>

<div class="srodek t5"><div class="srodek szerokosc" style="height:31px">
<?php
	g_menu();
?>
</div></div>

<div class="t6" style="font-size:1px; height:4px"></div>

<div class="srodek szerokosc nowa_l">

<div class="szerokosc" style="height:191px"><a href="<?php echo konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array()); ?>"><img src="img/top.jpg" alt="" /></a></div>

<div class="t2" style="overflow:auto; height:40px;">

	<div style="width:500px; float:left"><?php
		glowne_menu();
	?></div>
	
	<div style="width:450px; float:left; text-align:right; padding-top:12px; text-align:right"><?php
	if(user::get()->zalogowany()){
		echo " Jesteś zalogowany jako: <a class=\"grube\" style=\"color:#ffffcf\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane"))."\">".tekstForm::utf8Substr(user::get()->nazwa(),0,60)."</a>";
	}	
	?></div>
	
</div>


<div id="kolumny_k">

	<?php
	if(konf::get()->getSzablon()!="forum"&&konf::get()->getSzablon()!="profil"){

		echo "<div id=\"lewa_k\">";

		if(user::get()->zalogowany()){
		
			if(konf::get()->getSzablon()=="grupy"){
			
				if(konf::get()->isMod('grupy')){			
					require_once(konf::get()->getKonfigTab('mod_kat')."grupy/class.grupy.php");	
					$grupy=new grupy();		
					
					if($grupy->_id){
						$grupy->grupaMenu();
					}
					
					$grupy->menu();			
				}			
			
			} else {
			
				if(konf::get()->isMod('poczta')){			
					require_once(konf::get()->getKonfigTab('mod_kat')."poczta/class.poczta.php");	
					$poczta= new poczta();		
					$poczta->menu();			
				}
			
			}
			
		}
				
		banery_rys(1,1);
		
		echo "</div>";

		if(konf::get()->getSzablon()=="poczta"||konf::get()->getSzablon()=="grupy"){
			echo "<div id=\"glowna_k\"><div id=\"glowna_k2\">";	
		} else {	
			echo "<div id=\"srodek_k\"><div id=\"srodek_k2\">";
		}
	}	
	
	?>[[-kodkomunikaty-]]<?php

}


function stopka(){

	if(konf::get()->getSzablon()!="forum"&&konf::get()->getSzablon()!="profil"){
	
		echo "</div></div>"; 	
		
		if(konf::get()->getSzablon()!="poczta"&&konf::get()->getSzablon()!="grupy"){		
		
			echo "<div id=\"prawa_k\">";
	
			echo "<div class=\"tlo2\">Moje konto</div>";
			
			echo "<div class=\"tlo3l\">";	
			if(user::get()->administrator()){
				echo interfejs::linkEl2("cog",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_panel")),konf::get()->langTexty("nagl_paneladmin"),"menu_item grube");
			}
						
			if(!user::get()->zalogowany()){	
				echo interfejs::linkEl2("key",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_zaloguj")),"Zaloguj się");	
				if(!konf::get()->getKonfigTab("u_konf","tylko_admin")){
					echo interfejs::linkEl2("user_add",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dodaj")),"Zarejestruj się");					
				}
			} else {
				echo interfejs::linkEl2("user_edit",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_edytuj")),"Edycja profilu");		
				echo interfejs::linkEl2("key",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_wyloguj")),"Wyloguj się");	
			}	
			echo "</div>";

			ankieta_wys();
			
			subskrypcja();

			banery_rys(2,1);					

			echo "</div>";
			
		}
		
	}
	?>	
	
	
</div>


<div class="szerokosc srodek nowa_l">

	<div class="nowa_l" style="font-size:1px; height:10px"></div>				
	<div class="t3 nowa_l" style="font-size:1px; height:1px"></div>		
				
	<div class="tlo3 srodek" style="height:28px; border-bottom:1px solid #cccccc;">			
	<?php	
		d_menu();
	?>
	</div>				
	
	<div class="t3 nowa_l" style="font-size:1px; height:1px"></div>		
	
 </div>
		
<div class="t2 nowa_l" style="font-size:1px; height:3px"></div>

</div>
	
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
			$pasekreklama->setTekst("");
			$pasekreklama->wyswietl();
		}

	?>
	[[-kodfooter-]]	
	[[-kodstat-]]
	</body></html>
  <?php
}


function ankieta_wys(){

	if(konf::get()->isMod('ankieta')){
	
		$ankieta=new ankieta();
		
		$ankieta_html=$ankieta->pokaz(150,array(1=>1));
		if($ankieta_html){
			echo "<div class=\"nowa_l\" style=\"padding-top:4px\">";
	    echo "<div class=\"tlo2\">".konf::get()->langTexty("nagl_ankieta")."</div>";
	    echo "<div class=\"tlo3 tlo3l lewa\" style=\"padding:5px\">";
	    echo $ankieta_html;
	    echo "</div>";
			echo "</div>";
	  }				
		
	}
	
}


function banery_rys($typy,$ile){

	if(konf::get()->isMod('rotator')){
		$banery=new banery($typy,$ile);
		$banery->generuj();		
		$banery1=$banery->getBanery();				
		if(!empty($banery1)){
			while(list($key,$val)=each($banery1)){
				echo "<div style=\"margin-top:3px\" class=\"banery\">".$val."</div>";
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

	$art=new art();
	
	$dane_tab=konf::get()->_bazasql->pobierzRekordy("SELECT id, id_matka, tytul, tytul_menu, link, link_okno, idtf_link FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id_d=1 AND poziom<2 AND typ!=3 AND menu_nie=0 AND lang='".konf::get()->getLang()."' ".$art->sqlAdd()." ORDER BY id_matka, nr_poz,id DESC","id");
	
	while(list($key,$dane)=each($dane_tab)){
		$tab[$dane['id_matka']][]=$dane;
	}
	
	if(!empty($tab)&&!empty($tab[0])&&is_array($tab[0])){
	
		echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" id=\"menu1\" class=\"ddm1\">";
		echo "<tr class=\"srodek\">";		
		
		reset($tab[0]);
		while(list($key,$val)=each($tab[0])){
			if(!empty($val)){
				echo g_menu_el($tab,$val);		
			}
		}	
	
		echo "</tr></table>";			
		
	}

}


function g_menu_el($tab,$val){

	$art=new art();

	$html="";
	
	if(!empty($val['tytul_menu'])){
		$val['tytul']=$val['tytul_menu'];
	}

	$html.="\n<td><a class=\"item1\" ".$art->artLink($val).">".$val['tytul']."</a>\n";
	
	if(!empty($tab[$val['id']])&&is_array($tab[$val['id']])){
	
		reset($tab[$val['id']]);			
	  $html.="\n<div class=\"section\">";
		
  	while(list($key2,$val2)=each($tab[$val['id']])){
			if($val2['tytul_menu']!=""){
				$val2['tytul']=$val2['tytul_menu'];
			}
			$html.="<a class=\"item2\" ".$art->artLink($val2)."><span>".$val2['tytul']."</span></a>\n";
		}
		
  	$html.="</div>\n";
		
	}		
			
	$html.="</td>";

	return $html;

}


function l_menu(){

	$art=new art();	
	
	//lewe menu
	$dane_tab=konf::get()->_bazasql->pobierzRekordy("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id_d=2 AND typ!=3 AND poziom<2 AND menu_nie=0 AND lang='".konf::get()->getLang()."' ".$art->sqlAdd()." ORDER BY id_matka, nr_poz,id DESC","id");
	while(list($key,$dane)=each($dane_tab)){
		$tab[$dane['id_matka']][]=$dane;
	}		

	if(!empty($tab)&&!empty($tab[0])&&is_array($tab[0])){
		reset($tab[0]);
		echo "<div id=\"l_menu\">";
		while(list($key,$val)=each($tab[0])){
			echo l_menu_el($art,$tab,$val);		
		}	
		echo "</div>";
	}
	
}


function l_menu_el(&$art,$tab,$val){

	$html="";
	
	if(!empty($val['tytul_menu'])){
		$val['tytul']=$val['tytul_menu'];
	}

	$html.="\n<a class=\"l_item1\" ".$art->artLink($val).">".$val['tytul']."</a>\n";
	
	if(!empty($tab[$val['id']])&&is_array($tab[$val['id']])){
		reset($tab[$val['id']]);			
  	while(list($key2,$val2)=each($tab[$val['id']])){
			if(!empty($val2['tytul'])){
				if(!empty($val2['tytul_menu'])){
					$val2['tytul']=$val2['tytul_menu'];
				}
				$html.="<a class=\"l_item2\" ".$art->artLink($val2).">".$val2['tytul']."</a>\n";
			}
		}
	}				

	return $html;

}


function d_menu(){

	$art=new art();			
	
	?>
	<table border="0" cellspacing="0" cellpadding="3" style="margin-top:2px" class="srodek">
		<tr valign="middle" class="srodek">
		<?php
			$zap=konf::get()->_bazasql->zap("SELECT id, id_matka, tytul, tytul_menu, link, link_okno FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id_d=4 AND typ!=3 AND id_matka=0 AND lang='".konf::get()->getLang()."' ".$art->sqlAdd()." ORDER BY nr_poz,id DESC");
			$i=0;
				while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
				if($i>0){
					echo "<td style=\"width:15px\"><img src=\"img/md.gif\" width=\"1\" height=\"9\" alt=\"\" /></td>";
				}
				if(!empty($dane['tytul_menu'])){
					$dane['tytul']=$dane['tytul_menu'];
				}
				echo "<td><a ".$art->artLink($dane).">".$dane['tytul']."</a></td>";				
				$i++;
			}			
		?>
		</tr>
	</table>
	<?php
}


function glowne_menu(){

	echo "<ul id=\"glowne_menu\">";
	
	echo "<li><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array())."\">Home</a></li>";
	echo "<li><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane"))."\">Moje konto</a></li>";
	if(konf::get()->isMod('grupy')){
		echo "<li><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_user"))."\">Grupy</a></li>";	
	}
	if(konf::get()->isMod('poczta')){
		echo "<li><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"poczta_odb"))."\">Poczta</a></li>";	
	}	
	if(konf::get()->isMod('znajomi')){
		echo "<li><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_arch"))."\">Znajomi</a></li>";	
	}	
	echo "</ul>";

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
				echo "<div class=\"prawa\" style=\"margin-top:5px;\"><a ".$art->artLink($dane2)."><img src=\"img/wiecej.gif\" width=\"42\" height=\"9\" alt=\"wiecej\" onmouseover=\"changeSrc(this,'img/wiecej2.gif')\"  onmouseout=\"changeSrc(this,'img/wiecej.gif')\" /></a></div>";
				echo "</div>";
			}		
					
			echo "</div>";
		}
		konf::get()->_bazasql->freeResult($zap);
		
	}
	//k lewe newsy	
	
}

function szuk_form(){

	?><script type="text/javascript">
	
	function spr_artszuk(){
	
		if(document.szukaj.art_szuk.value.length<3){ 		
			form_set_error("art_szuk",'<?php echo htmlspecialchars(konf::get()->langTexty("nagl_szuk_fzakrotka")); ?>');			
		}	
		
	}
	
	</script><?php
	$form=new formularz("post",konf::get()->getKonfigTab("plik"),"szukaj","szukaj");	
	echo $form->spr(array(),""," spr_artszuk(); ");
	echo $form->getFormp();
	echo $form->przenies(array("akcja"=>"art_szukaj"));	
	echo $form->input("text","art_szuk","art_szuk",konf::get()->getZmienna("art_szuk","art_szuk"));	
	echo $form->input("submit","","",konf::get()->langTexty("nagl_szukaj"),"formularz2 f_krotki");	
	?>
	<a name="www_top">&nbsp;</a>	
	<?php				
	echo $form->getFormk();
		
}

function rss_head(){

	$zap=konf::get()->_bazasql->zap("SELECT id, tytul FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE rss=1 AND (data_start<=NOW() OR data_start='0000-00-00 00:00:00')  AND (data_stop>=NOW() OR data_stop='0000-00-00 00:00:00') AND status=1 ORDER BY id_matka, nr_poz, id");
	while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
		echo "<link rel=\"alternate\" title=\"".htmlspecialchars($dane['tytul'])."\" href=\"".konf::get()->getKonfigTab("sciezka")."rss.php?id_art=".$dane['id']."\" type=\"application/rss+xml\" />";
	}
	konf::get()->_bazasql->freeResult($zap);
		
}


function tab_nagl($tytul="",$colspan="",$id="",$class=""){

	$html="<table class=\"tabelka ".$class."\" cellspacing=\"0\" cellpadding=\"7\" border=\"1\"";
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

	if(konf::get()->isMod('subs')){
		
		echo "<div class=\"srodek\" style=\"margin-top:4px;\">";
		
		echo "<div class=\"tlo2\">".konf::get()->langTexty("nagl_subs")."</div>";
	  echo "<div class=\"tlo3 tlo3l lewa\">";
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"subs","subs");
		echo $form->spr(array(1=>"subs_email"));
		echo $form->getFormp();	
		echo $form->przenies(array("id_subs"=>1));
	  echo "<div class=\"male\">".konf::get()->langTexty("nagl_subs_podajemail")."</div>";
		echo $form->input("text","subs_email","subs_email","","f_sredni",50);			
	  echo "<br />";
		echo $form->select("akcja","akcja",array(
			"subs_zapisz"=>konf::get()->langTexty("nagl_subs_zapisz"),
			"subs_wypisz"=>konf::get()->langTexty("nagl_subs_wypisz")
		),"","f_sredni");
	  echo "&nbsp;";
		
		echo $form->input("submit","","",konf::get()->langTexty("nagl_subs_wyslij"),"formularz2 f_krotki");				
		echo $form->getFormk();	
	  echo "</div>";	
				
		echo "</div>";
		
	}

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


function u_wizytowka($dane,$dodaj=true,$usun=true,$czarna=true){

	echo "<div class=\"srodek\">";
		
	if(!empty($dane['id'])){
		
		if(konf::get()->getKonfigTab("u_konf",'img')){												
			echo "<div>";							
			echo user::get()->obrazek($dane,"",2,"",true);			
			echo "</div>";					
		}
			
		echo "<div style=\"padding-bottom:3px;\"><a class=\"grube\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane",'id_u'=>$dane['id']))."\">";
		echo tekstForm::wrapWbr(user::get()->nazwa($dane),30);
		echo "</a> (".$dane['ile_znajomi'].")</div>";
		
		if(!empty($dane['miejscowosc'])){
			echo "<div style=\"padding-bottom:3px;\">".$dane['miejscowosc']."</div>";
		}		
		
		echo "<div style=\"line-height:25px; height:25px;\">";
  	echo "<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"poczta_wiadomosc",'id_u'=>$dane['id']))."\"><img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/ikony/email_edit.gif\" alt=\"".konf::get()->langTexty("u_mnapiszw")."\" title=\"".konf::get()->langTexty("u_mnapiszw")."\" /></a>";	
		echo "&nbsp;&nbsp;";	
		
		if($dodaj&&!user::get()->jestZnajomi($dane['id'])){
		  echo "<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_zapros",'id_u'=>$dane['id']))."\"><img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/ikony/group_add.gif\" alt=\"".konf::get()->langTexty("u_mzaprosz")."\" title=\"".konf::get()->langTexty("u_mzaprosz")."\" /></a>";
			echo "&nbsp;&nbsp;";				
		} 
		
  	echo "<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_arch",'id_u'=>$dane['id']))."\"><img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/ikony/group.gif\" alt=\"".konf::get()->langTexty("u_mlistaz")."\" title=\"".konf::get()->langTexty("u_mlistaz")."\" /></a>";
	
		if($czarna&&$dane['id']!=user::get()->id()){
			echo "&nbsp;&nbsp;";		
		  echo "<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"znajomi_czarnadodaj",'id_u'=>$dane['id']))."\"><img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/ikony/delete.gif\" alt=\"dodaj na czarnąlistę\" title=\"dodaj na czarną liste\" /></a>";
		
		}					
		
		echo "</div>";
		
	} else {
		echo "<div class=\"grube\">".konf::get()->langTexty("u_musuniety")."Użytkownik usunięty lub niedostępny</div>";
	}
	
	echo "</div>";	

}

?>