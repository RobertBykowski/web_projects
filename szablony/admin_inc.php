<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

konf::get()->setTekstyTab("naglowek_admin_texty","2");

//poczatek kodu html
function glowa(){

echo "<?xml version=\"1.0\" encoding=\"".konf::get()->getKonfigTab("charset")."\"?>";
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl"> 
<head>
<meta http-equiv="Content-type" content="text/html; charset=<?php echo konf::get()->getKonfigTab("charset"); ?>" />
<meta http-equiv="Content-Language" content="pl" />
<meta http-equiv="Reply-to" content="<?php echo konf::get()->getKonfigTab('autor_email'); ?>" />
<meta name="Author" content="<?php echo konf::get()->getKonfigTab('autor'); ?>" />
<meta name="robots"	content="noindex,nofollow" />
<script type="text/javascript" src="<?php echo konf::get()->getKonfigTab("sciezka"); ?>js/local.js"></script>
<script type="text/javascript" src="<?php echo konf::get()->getKonfigTab("sciezka"); ?>js/menu/dropdownmenu1.js"></script>
<?php
	konf::get()->setKod("kodonload","menumenu();");
	konf::get()->setKod("kodfooter","<script type=\"text/javascript\">setTimeout(\"menu_ods()\",200); tt_Init();</script>");	
	konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/jquery-min.js","js");	
?>
<script type="text/javascript" src="<?php echo konf::get()->getKonfigTab("sciezka"); ?>js/tooltip.js"></script>	
<script type="text/javascript" src="<?php echo konf::get()->getKonfigTab("sciezka"); ?>js/swfobject.js"></script>
<link href="<?php echo konf::get()->getKonfigTab("sciezka"); ?>grafika/admin.css" type="text/css" rel="stylesheet" />
<link href="<?php echo konf::get()->getKonfigTab("sciezka"); ?>grafika/s<?php echo konf::get()->getStyl(); ?>/panel.css" type="text/css" rel="stylesheet" />
[[-plikiheader-]][[-kodheader-]]
<title>[[-tytul-]]</title>
<?php
	if(konf::get()->getKonfigTab('cms_branding')){
?>
<link rel="icon" href="<?php echo konf::get()->getKonfigTab("sciezka"); ?>grafika/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo konf::get()->getKonfigTab("sciezka"); ?>grafika/favicon.ico" type="image/x-icon" />
<?php
}
?>
</head>
<body class="srodek" [[-kodonload-]]>
<div id="err_box" style="display:none;">
    <div id="err_validate"></div>
    <div id="err_hide" onclick="$('#err_box').hide('medium')"><?php echo konf::get()->langTexty("err_zamknij"); ?></div>
</div>
<div class="srodek szerokosc" style="height:63px; text-align:right">

	<div class="lewal lewa" style="width:365px; height:60px"><?php	
	if(konf::get()->getKonfigTab('cms_branding')){
		echo "<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_panel"))."\"><img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/logo.gif\" width=\"300\" height=\"60\" style=\"margin-bottom:5px;\" alt=\"\" /></a>";
	}	
	?></div>
	
	<div class="lewal prawa" style="width:590px">
  <?php	
	panel_dostep();
	echo "<table border=\"0\" class=\"prawa\" cellspacing=\"0\" cellpadding=\"3\" style=\"margin-top:2px\"><tr valign=\"middle\">";	
	
	if(user::get()->zalogowany()){
		echo "<td class=\"male\">".konf::get()->langTexty("nagla_zalogowany")."</td><td class=\"grube\" style=\"padding-right:25px;\"><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane"))."\">".tekstForm::utf8Substr(user::get()->nazwa(),0,40)."</a></td>";
	}
	
	$tab_styl=konf::get()->getKonfigTab('tab_styl');	
  if($tab_styl&&is_array($tab_styl)&&count($tab_styl)>1){
  	while(list($key,$val)=each($tab_styl)){	
			echo "<td class=\"srodek\"><a class=\"styl_link\" style=\"background-color:#".$val."\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_styl","styl_id"=>$key))."\"></a></td>";
		}
	}
	
	echo "<td style=\"width:20px\">&nbsp;</td>";
	
	$tab_lang=konf::get()->getKonfigTab('tab_lang');	
  if($tab_lang&&is_array($tab_lang)&&count($tab_lang)>1){
  	while(list($key,$val)=each($tab_lang)){
  		if(konf::get()->getLang()==$key){
  			echo "<td><a class=\"lang2\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_panel","lang"=>$key),false)."\"><img class=\"lang\" src=\"".konf::get()->getKonfigTab("sciezka")."grafika/l_".$val.".gif\" width=\"22\" height=\"13\" alt=\"".$val."\" /></a></td>";
  		} else {  	
	  	  echo "<td><a class=\"lang\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_panel","lang"=>$key),false)."\"><img class=\"lang\" src=\"".konf::get()->getKonfigTab("sciezka")."grafika/l_".$val.".gif\" width=\"22\" height=\"13\" alt=\"".$val."\" /></a></td>";
	  	}
  	}
  }  
	echo "</tr></table>";	           	
  ?>      
	</div>
</div>

<div class="tlo5_admin nowa_l" style="height:2px; font-size:1px"></div>

<div class="tlo6_admin nowa_l srodek" style="height:26px; ">
	<div class="srodek szerokosc"><?php
			admin_menu_admin();
	?></div>
</div> 	

<div class="tlo8_admin nowa_l" style="height:3px; font-size:1px"></div>
<div class="tlo5_admin nowa_l" style="height:1px; font-size:1px"></div>

<div class="nowa_l tlo7_admin"><table border="0" cellspacing="0" class="srodek szerokosc" style="margin-top:3px" cellpadding="0">
	<tr class="lewa" valign="top">
		<?php
		if(konf::get()->getSzablon()!="admin2"){
			echo "<td style=\"width:170px\">";
		
			if(user::get()->upr(11)&&konf::get()->getSzablon()=="admin"){
				art_drzewo();
			}
			
			if(user::get()->upr(20)&&konf::get()->getSzablon()=="sklepadmin"){
				sklep_drzewo();
			}			

			echo "</td>";
		}
		?>
		<td style="padding-left:3px" class="lewa">
    
		[[-kodkomunikaty-]]<?php

}



function stopka(){

  ?>

	</td></tr></table></div>

	<div class="tlo5_admin nowa_l" style="height:3px; font-size:1px"></div>		
	<div class="tlo8_admin nowa_l" style="height:2px; font-size:1px"></div>		
	<div class="tlo5_admin nowa_l" style="height:1px; font-size:1px"></div>		
	
	<div class="szerokosc srodek">

		<?php		
		if(konf::get()->getKonfigTab('cms_branding')){				
			echo "<div class=\"nowa_l prawa\" style=\"padding:7px;\"><a class=\"copy\" href=\"http://jw-webdev.info\" target=\"_blank\">&copy; JW Web Development</a></div>";
		}
	
		echo "<div class=\"nowa_l\">";

		if(konf::get()->isMod('sqllista')){
			require_once(konf::get()->getKonfigTab('klasy')."class.sqllista.php");	
			$sqllista= new sqllista();		
			$sqllista->wyswietl();
	  }
		
		if(konf::get()->isMod('akcjelista')){
			require_once(konf::get()->getKonfigTab('klasy')."class.akcjelista.php");	
			$akcjelista= new akcjelista();		
			$akcjelista->wyswietl();
	  }			
		?>
		</div>
	</div>	

	[[-kodfooter-]]	
	[[-kodstat-]]	
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


function art_drzewo_poziomy($link,$tab,$key,$poziom){

	$id_nr=konf::get()->getZmienna('id_art','id_art');
	
	//jesli jest poziom
	if(!empty($tab[$key])&&is_array($tab[$key])){
    reset($tab[$key]);		
		//to przelatujemy poziom
    while(list($key2,$val2)=each($tab[$key])){
			for($i=0;$i<=$poziom;$i++){ 
				echo " ";
			}
			echo "<div class=\"folder\">&lt;a ";
			if($id_nr==$key2){
				echo " class=\"grube\"";
			}
			echo "href=\"".$link."&amp;id_art=".$key2."&amp;akcja=artadmin_arch";
			echo "\"&gt;".strip_tags($val2['tytul'])."&lt;/a&gt;\n";
			art_drzewo_poziomy($link,$tab,$key2,$poziom+1);
			echo "</div>\n";
		}		
	}
	
}


function art_drzewo(){

	include_once(konf::get()->getKonfigTab('mod_kat')."art/konfig_inc.php");	
	$id_d=konf::get()->getZmienna('id_d','id_d');
	
	echo tab_nagl(konf::get()->langTexty("nagla_struktura"));
	
	$d_tab=konf::get()->getKonfigTab("art_konf",'d_tab');
	
	if(!empty($d_tab)&&is_array($d_tab)){	
	
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_arch"));	
		echo "<tr><td class=\"tlo4\">";
		
	  while(list($key,$val)=each($d_tab)){	
  		echo "<div class=\"nowa_l\" style=\"padding:2px\"><div style=\"width:23px\" class=\"lewa lewal\"><img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/folder1.gif\" width=\"17\" height=\"15\" alt=\"\" class=\"lewa\" style=\"margin-right:2px\" /></div>";		
			echo "<div class=\"lewa\"><a href=\"".$link."&amp;id_d=".$key."\">".$val."</a></div></div>";			
		}
	  echo "</td></tr>";

		if(!empty($id_d)&&!empty($d_tab[$id_d])){
		
			konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/menu/dynamictree.js","js");
							
			echo "<tr><td class=\"tlo3 bialy\">";	
			$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_d"=>$id_d));
			?>
			<div id="tree_kontener"><div class="DynamicTree">
				
        <div class="top"><?php echo "<a class=\"grube\" href=\"".$link."&amp;akcja=artadmin_arch\">".$d_tab[$id_d]."</a>"; ?></div>
				
        <div class="wrap" id="tree"><?php						
				//pobieramy okreslone dane
   			$query="SELECT id, id_matka, tytul, typ FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE lang='".konf::get()->getLang()."' ";
		    $query.=" AND id_d='".$id_d."' AND typ!=3 ";
				if(konf::get()->getKonfigTab("art_konf",'drzewo_poziomy')){
					$query.=" AND poziom<='".konf::get()->getKonfigTab("art_konf",'drzewo_poziomy')."'";
				}
				//tworzymy tablice drzewa
	      $zap=konf::get()->_bazasql->zap($query." ORDER BY nr_poz,id");       
	      while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
	        $poziomy[$dane['id_matka']][$dane['id']]=$dane;
	      }
	      konf::get()->_bazasql->freeResult($zap);
				
				//jesli jest talibca to wyswietlamy ja
				if(!empty($poziomy)&&is_array($poziomy)){
					reset($poziomy);							
					//zaczynamy od poziomu 1 (zerowy element nadrzedny)
					art_drzewo_poziomy($link,$poziomy,0,1); 
				}
   
				?></div>
					
		  </div></div>
			
		  <script type="text/javascript">
		  	var tree = new DynamicTree("tree");
		  	tree.init();
		  </script>
			<?php	
			echo "</td></tr>";
		}
		
	}
	echo tab_stop();
	
}


function admin_menu_el($tytul,$link,$tablica=""){

	$html="";
	
	if(!empty($tytul)&&!empty($link)){
		$html.="\n<td><a class=\"item1\" href=\"".$link."\">".$tytul."</a>\n";
		if(!empty($tablica)&&is_array($tablica)){
			reset($tablica);			
		  $html.="\n<div class=\"section\">";
	  	while(list($key,$val)=each($tablica)){
				if(!empty($val['link'])&&!empty($val['tytul'])){
					$html.="<a class=\"item2\" href=\"".$val['link']."\"><span>".$val['tytul']."</span></a>\n";
				}
			}
	  	$html.="</div>\n";
		}				
		$html.="</td>";
	}
	
	return $html;

}
	
	
function admin_menu_admin(){

	echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"float:left\" id=\"menu1\" class=\"ddm1\">";
	echo "<tr class=\"srodek\">";
	
	if(user::get()->zalogowany()){		
	
		if(isset($podmenu)){
			unset($podmenu);
		}
		
		$podmenu=array(
			1=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane","u_id"=>user::get()->id())),"tytul"=>konf::get()->langTexty("nagla_menu_m_zobacz")),
			2=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_edytuj","u_id"=>user::get()->id())),"tytul"=>konf::get()->langTexty("nagla_menu_m_edytuj"))	
		);
		
		if(konf::get()->getKonfigTab("u_konf",'zmianarozbita')){
			$podmenu[]=array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_haslo")),"tytul"=>"Zmień hasło");
			$podmenu[]=array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_email")),"tytul"=>"Zmień email");				
		}
		
		if(user::get()->adminLogi()){	
			$podmenu[]=array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_logiarch","u_id"=>user::get()->id())),"tytul"=>konf::get()->langTexty("nagla_menu_m_listal"));
		}	
		if(user::get()->adminGlowny()){	
			$podmenu[]=array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_systemowe")),"tytul"=>konf::get()->langTexty("nagla_menu_m_danes"));
		}	
		
		echo admin_menu_el(konf::get()->langTexty("nagla_menu_m"),konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane","u_id"=>user::get()->id())),$podmenu);
	}

	if(user::get()->adminU()){
		if(isset($podmenu)){
			unset($podmenu);
		}	
		$podmenu=array(
			1=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_arch")),"tytul"=>konf::get()->langTexty("nagla_menu_u_arch")),			
			2=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dodaj")),"tytul"=>konf::get()->langTexty("nagla_menu_u_dodaj")),
			3=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_staty")),"tytul"=>konf::get()->langTexty("nagla_menu_u_stat")),
		);		
		if(user::get()->adminLogi()){
			$podmenu[]=array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_logiarch")),"tytul"=>konf::get()->langTexty("nagla_menu_u_log"));
		}
		if(konf::get()->getKonfigTab("u_konf",'banowanie')){
			$podmenu[]=array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_banyarch")),"tytul"=>konf::get()->langTexty("nagla_menu_u_filtr"));
		}		
		echo admin_menu_el(konf::get()->langTexty("nagla_menu_u"),konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"uadmin_arch")),$podmenu);	
	}
	
	if(konf::get()->isMod('grupy')&&user::get()->upr(3)){
		if(isset($podmenu)){
			unset($podmenu);
		}	
		$podmenu=array(
			1=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupyadmin_typy")),"tytul"=>"Typy grup"),
			2=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupyadmin_dodaj")),"tytul"=>"Dodaj grupę"),
		);				
		echo admin_menu_el("GRUPY",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupyadmin_typy")),$podmenu);	
		
	}
	
	if(konf::get()->isMod('galerieadmin')&&user::get()->upr(4)){
		if(isset($podmenu)){
			unset($podmenu);
		}	
		$podmenu=array();			
			
		echo admin_menu_el("GALERIE",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"galerieadmin_typy")),$podmenu);	
		
	}	
  	
	if(konf::get()->isMod('art')&&user::get()->upr(11)){
		if(isset($podmenu)){
			unset($podmenu);
		}	
		$podmenu=array(
			1=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_dzialy")),"tytul"=>konf::get()->langTexty("nagla_menu_cms_struk")),		
			3=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_staty")),"tytul"=>konf::get()->langTexty("nagla_menu_cms_stat"))	
		);			
		if(user::get()->adminGlowny()&&konf::get()->isMod('konfigadmin')){
			$podmenu[]=array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"konfigadmin_edytuj")),"tytul"=>konf::get()->langTexty("nagla_menu_m_konfig"));			
		}			
		echo admin_menu_el(konf::get()->langTexty("nagla_menu_cms"),konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artadmin_dzialy")),$podmenu);	
		
	}
  
	if(konf::get()->isMod('ankieta')&&user::get()->upr(15)){
		if(isset($podmenu)){
			unset($podmenu);
		}
		$podmenu=array(
			1=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ankietaadmin_typy")),"tytul"=>konf::get()->langTexty("nagla_menu_a_typy")),		
			2=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ankietaadmin_arch")),"tytul"=>konf::get()->langTexty("nagla_menu_a_arch")),
			3=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ankietaadmin_dodaj")),"tytul"=>konf::get()->langTexty("nagla_menu_a_dodaj")),
			4=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ankietaadmin_staty")),"tytul"=>konf::get()->langTexty("nagla_menu_a_stat"))
		);		
		echo admin_menu_el(konf::get()->langTexty("nagla_menu_a"),konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ankietaadmin_arch")),$podmenu);					
	}

  if(konf::get()->isMod('subs')&&user::get()->upr(16)){
		if(isset($podmenu)){
			unset($podmenu);
		}
		$podmenu=array(
			1=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"subsadmin_typy")),"tytul"=>konf::get()->langTexty("nagla_menu_sub_kat")),
			2=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"subsadmin_arch")),"tytul"=>konf::get()->langTexty("nagla_menu_sub_arch")),	
			3=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"subsadmin_archw")),"tytul"=>konf::get()->langTexty("nagla_menu_sub_archw")),
			4=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"subsadmin_wiadomosc")),"tytul"=>konf::get()->langTexty("nagla_menu_sub_w")),				
		);			
	
		echo admin_menu_el(konf::get()->langTexty("nagla_menu_sub"),konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"subsadmin_typy")),$podmenu);		
		
	}
	
  if(konf::get()->isMod('rotator')&&user::get()->upr(17)){
		$podmenu=array(
			1=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"rotatoradmin_typy")),"tytul"=>konf::get()->langTexty("nagla_menu_rot_typy")),
			2=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"rotatoradmin_arch")),"tytul"=>konf::get()->langTexty("nagla_menu_rot_arch")),
			3=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"rotatoradmin_dodaj")),"tytul"=>konf::get()->langTexty("nagla_menu_rot_dodaj")),
			4=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"rotatoradmin_staty")),"tytul"=>konf::get()->langTexty("nagla_menu_rot_stat")),						
		);		
		echo admin_menu_el(konf::get()->langTexty("nagla_menu_rot"),konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"rotatoradmin_typy")),$podmenu);		
	}
	
  if(konf::get()->isMod('sklepadmin')&&user::get()->upr(20)){
	
		$podmenu=array(
			1=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_dzialy")),"tytul"=>konf::get()->langTexty("nagla_menu_sklep_kat")."Kategorie produktów"),
			2=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"produktyadmin_arch")),"tytul"=>konf::get()->langTexty("nagla_menu_sklep_produkty")."Produkty"),
			3=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"producenciadmin_arch")),"tytul"=>konf::get()->langTexty("nagla_menu_producenci")."Producenci"),
			4=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_staty")),"tytul"=>konf::get()->langTexty("nagla_menu_sklep_stat")."Statystyka"),
		);		
			
	  if(konf::get()->isMod('zamowieniaadmin')&&user::get()->upr(21)){
			$podmenu[5]=array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"zamowieniaadmin_arch")),"tytul"=>konf::get()->langTexty("nagla_menu_zamowienia_arch")."Lista zamówień");
			$podmenu[6]=array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"zamowieniaadmin_staty")),"tytul"=>konf::get()->langTexty("nagla_menu_zamowienia_stat")."Statystyka zamówień");
		}				
		
		echo admin_menu_el(konf::get()->langTexty("nagla_menu_sklep")."SKLEP",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_dzialy")),$podmenu);		
	}	
	
	if(konf::get()->isMod('komentadmin')&&user::get()->upr(12)){
		if(isset($podmenu)){
			unset($podmenu);
		}	
		$podmenu=array(
			1=>array("link"=>konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"komentadmin_typy")),"tytul"=>"Typy komentarzy"),
		);				
		echo admin_menu_el("KOMENTARZE",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"komentadmin_typy")),$podmenu);	
		
	}	
	
	echo "</tr></table>";

}



function tab_nagl($tytul="",$colspan="",$align="",$help=""){

	$html="<table class=\"tabelka\" cellspacing=\"0\" cellpadding=\"3\" border=\"1\">";
	if(!empty($tytul)){ 
		$html.="<tr><td class=\"tlo2 lewa grube nobr\"";
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


function panel_dostep(){

	echo "<table class=\"seta tlo4\" cellspacing=\"0\" cellpadding=\"4\" border=\"0\"><tr>";
	
	if(user::get()->zalogowany()){	
		echo "<td style=\"width:40%\" class=\"srodek\">";
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"form_pan","form_pan");
		echo $form->getFormp();
		echo $form->przenies(array("akcja"=>"u_wylogujadmin"));		
		echo $form->input("submit","","",konf::get()->langTexty("nagla_pan_wylog"),"formularz2 f_sredni");			
		echo $form->getFormk();
		echo "</td>";
	}
	
	echo "<td class=\"grube srodek\" style=\"padding-right:25px;\">";
	echo interfejs::linkEl("eye",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array()),konf::get()->langTexty("nagla_podglad"),"srodek");
	echo "</td>";	
	
	if(user::get()->zalogowany()){		
		echo "<td class=\"grube srodek\" style=\"padding-right:15px;\">";
		echo interfejs::linkEl("cog",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_panel")),konf::get()->langTexty("nagla_pan"));	
		echo "</td>";
	}
	
	echo "</tr></table>";

}

?>