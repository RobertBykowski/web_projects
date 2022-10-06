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
<title>[[-tytul-]]</title>
<meta name="keywords"	content="[[-keywords-]]" />
<meta name="description" content="[[-description-]]" />
<meta http-equiv="Content-type" content="text/html; charset=<?php echo konf::get()->getKonfigTab("charset"); ?>" />
<meta http-equiv="Content-Language" content="<?php echo konf::get()->getLangR(); ?>" />
<meta http-equiv="Reply-to" content="<?php echo konf::get()->getKonfigTab('autor_email'); ?>" />
<meta name="Author" content="<?php echo konf::get()->getKonfigTab('autor'); ?>" />
<meta name="robots"	content="index,follow" />
<script type="text/javascript" src="<?php echo konf::get()->getKonfigTab("sciezka"); ?>js/local.js" ></script>
<script type="text/javascript" src="<?php echo konf::get()->getKonfigTab("sciezka"); ?>js/menu/dropdownmenu1.js"></script>
<?php
	//konf::get()->setKod("kodonload","menumenu();");
	//konf::get()->setKod("kodfooter","<script type=\"text/javascript\">setTimeout(\"menu_ods()\",200);</script>");
	//konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/jquery-min.js","js");
?>
<script type="text/javascript" src="<?php echo konf::get()->getKonfigTab("sciezka"); ?>js/swfobject.js"></script>
<link href="<?php echo konf::get()->getKonfigTab("sciezka"); ?>css/styl.css" type="text/css" rel="stylesheet" />
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


<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
   js.src = "//connect.facebook.net/pl_PL/all.js#xfbml=1&appId=535373376554451";	
 
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>



<?php
if(konf::get()->getAkcja()=="art_powitalna"){
	adv_toplayer();
}
?>
<div id="err_box" style="display:none;">
    <div id="err_validate"></div>
    <div id="err_hide" onclick="$('#err_box').hide('medium')"><?php echo konf::get()->langTexty("err_zamknij"); ?></div>
</div>

<table cellpadding="0" cellspacing="0" class="szerokosc srodek"><tr><td style="padding: 0px; text-align: left;">

<div style="height: 194px;">
  <div  style="width:291px; float: left;">
    <div id="logo_div">
      <div style="padding-top: 55px; padding-left: 55px;">
            <a href="<?php echo konf::get()->getKonfigTab("sciezka"); ?>" id="logo"></a>
      </div>
    </div>
  </div>

  <div  id="baner">
  </div>
</div>

<div id="menu_div">
  <?php
    g_menu();
  ?>
</div>

<table cellpadding="0" cellspacing="0" id="main_table" class="seta"><tr><td class="seta" style="padding: 0px; vertical-align: top;">
[[-kodkomunikaty-]]<?php


}


function stopka(){

?>
  </td></tr></table>

  <div id="footer">

    <div style="width: 460px;float: left; padding-top: 10px; color: #ffffff; text-align: center; ">
      <span>Copyright &copy; e-byk design 2008 </span>
    </div>

    <div style="width: 560px; float: right;">
      <?php
        g_menu2();
      ?>
    </div>
  </div>

  </td></tr></table>
	

		
<div style="width: 460px;float: left" class="fb-like-box" data-href="https://www.facebook.com/pages/Restauracja-Arkadia-Radziej%C3%B3w/1426932717543267?hc_location=stream" data-colorscheme="light" data-show-faces="true" data-header="true" data-stream="true" data-show-border="true"></div>
	

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

	?>
	[[-kodfooter-]]
	[[-kodstat-]]
	</body>

	
	</html>
  <?php
}


function ankieta_wys(){

	if(konf::get()->isMod('ankieta')){

		$ankieta=new ankieta();
		$ankieta_html=$ankieta->pokaz(150,array(1=>1));

		if($ankieta_html){
			echo "<div class=\"nowa_l\" style=\"margin-top:7px\">";
	    echo "<div class=\"tlo2 srodek\" style=\"padding:3px\">".konf::get()->langTexty("nagl_ankieta")."</div>";
	    echo "<div class=\"tlo3 lewa\" style=\"padding:5px\">";
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
  $id_art = konf::get()->getZmienna("id_art","id_art");

	$html="";

	if(!empty($val['tytul_menu'])){
		$val['tytul']=$val['tytul_menu'];
	}

  if($id_art == $val['id'])
	{
	$html.="\n<td><a class=\"item1-active\" ".$art->artLink($val).">".$val['tytul']."</a>\n";
	} else if((konf::get()->getAkcja()=="art_restauracja" || konf::get()->getAkcja()=="art_powitalna") && $val['tytul'] == 'restauracja'){
	$html.="\n<td><a class=\"item1-active\" ".$art->artLink($val).">".$val['tytul']."</a>\n";
	} else if(konf::get()->getAkcja()=="art_menu" && $val['tytul'] == 'menu'){
	$html.="\n<td><a class=\"item1-active\" ".$art->artLink($val).">".$val['tytul']."</a>\n";
	} else if(konf::get()->getAkcja()=="art_galeria" && $val['tytul'] == 'galeria'){
	$html.="\n<td><a class=\"item1-active\" ".$art->artLink($val).">".$val['tytul']."</a>\n";
	} else if(konf::get()->getAkcja()=="art_kontakt" && $val['tytul'] == 'kontakt'){
	$html.="\n<td><a class=\"item1-active\" ".$art->artLink($val).">".$val['tytul']."</a>\n";
	} else if(konf::get()->getAkcja()=="art_oferta" && $val['tytul'] == 'oferta'){
	$html.="\n<td><a class=\"item1-active\" ".$art->artLink($val).">".$val['tytul']."</a>\n";
	} else if(konf::get()->getAkcja()=="art_pokoje" && $val['tytul'] == 'pokoje gościnne'){
	$html.="\n<td><a class=\"item1-active\" ".$art->artLink($val).">".$val['tytul']."</a>\n";
	} else {
	$html.="\n<td><a class=\"item1\" ".$art->artLink($val).">".$val['tytul']."</a>\n";
	}


	/*if(!empty($tab[$val['id']])&&is_array($tab[$val['id']])){

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
  */
	$html.="</td>";

	return $html;

}

function g_menu2(){

	$art=new art();

	$dane_tab=konf::get()->_bazasql->pobierzRekordy("SELECT id, id_matka, tytul, tytul_menu, link, link_okno, idtf_link FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id_d=1 AND poziom<2 AND typ!=3 AND menu_nie=0 AND lang='".konf::get()->getLang()."' ".$art->sqlAdd()." ORDER BY id_matka, nr_poz,id DESC","id");

	while(list($key,$dane)=each($dane_tab)){
		$tab[$dane['id_matka']][]=$dane;
	}

	if(!empty($tab)&&!empty($tab[0])&&is_array($tab[0])){

		echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" id=\"menu2\" class=\"ddm2\">";
		echo "<tr class=\"srodek\">";

		reset($tab[0]);
		while(list($key,$val)=each($tab[0])){
			if(!empty($val)){
				echo g_menu_el2($tab,$val);
			}
		}

		echo "</tr></table>";

	}

}


function g_menu_el2($tab,$val){

	$art=new art();
  $id_art = konf::get()->getZmienna("id_art","id_art");

	$html="";

	if(!empty($val['tytul_menu'])){
		$val['tytul']=$val['tytul_menu'];
	}

 // if($id_art == $val['id'])
	//{
	$html.="\n<td><a class=\"item1\" ".$art->artLink($val).">".$val['tytul']."</a>\n";
//	} else {
//	$html.="\n<td><a class=\"item1\" ".$art->artLink($val).">".$val['tytul']."</a>\n";
	//}


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

	$zap=konf::get()->_bazasql->zap("SELECT id, id_matka, tytul, tytul_menu, link, link_okno FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id_d=4 AND typ!=3 AND id_matka=0 AND lang='".konf::get()->getLang()."' ".$art->sqlAdd()." ORDER BY nr_poz,id DESC");
	$i=0;
	echo "<div class=\"srodek nowa_l\">";
	while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
		if($i>0){
			echo " | ";
		}
		if(!empty($dane['tytul_menu'])){
			$dane['tytul']=$dane['tytul_menu'];
		}
		echo "<a ".$art->artLink($dane).">".$dane['tytul']."</a>";
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

	$html="<table class=\"tabelka ".$class."\" cellspacing=\"0\" cellpadding=\"3\" border=\"1\"";
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

	echo "<div class=\"srodek\"><div class=\"srodek\" style=\"margin-top:25px; margin-bottom:20px; width:200px\">";

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