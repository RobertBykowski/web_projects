<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

include_once(konf::get()->getKonfigTab('szablony_kat')."admin_inc.php");

function sklep_drzewo_poziomy($link,$tab,$key,$poziom){

	$id_nr=konf::get()->getZmienna('id_kat','id_kat');

	//jesli jest poziom
	if(!empty($tab[$key])&&is_array($tab[$key])){
    reset($tab[$key]);		
		//to przelatujemy poziom
    while(list($key2,$val2)=each($tab[$key])){
			for($i=0;$i<=$poziom;$i++){ 
				echo " ";
			}
			echo "<div class=\"folder\">&lt;a";
			if($id_nr==$key2){
				echo " class=\"grube\"";
			}			
			echo " href=\"".$link."&amp;id_kat=".$key2."&amp;akcja=sklepadmin_arch";
			echo "\"&gt;".strip_tags($val2['tytul'])."&lt;/a&gt;\n";
			sklep_drzewo_poziomy($link,$tab,$key2,$poziom+1);
			echo "</div>\n";
		}		
	}
	
}

function sklep_drzewo(){

	$id_d=konf::get()->getZmienna('id_d','id_d');
	$d_tab=konf::get()->getKonfigTab("sklep_konf",'d_tab');
	
	konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/menu/dynamictree.js","js");
	include_once(konf::get()->getKonfigTab('mod_kat')."sklep/konfig_inc.php");	

	echo tab_nagl(konf::get()->langTexty("naglsklep_struktura")."Struktura asortymentu");

	if(!empty($d_tab)&&is_array($d_tab)){	
	
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"sklepadmin_arch"));	
		echo "<tr><td class=\"tlo4\">";
		
	  while(list($key,$val)=each($d_tab)){	
  		echo "<div class=\"nowa_l\" style=\"padding:2px\"><div style=\"width:23px\" class=\"lewa lewal\"><img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/folder1.gif\" width=\"17\" height=\"15\" alt=\"\" class=\"lewa\" style=\"margin-right:2px\" /></div>";		
			echo "<div class=\"lewa\"><a href=\"".$link."&amp;id_d=".$key."\">".$val."</a></div></div>";			
		}
	  echo "</td></tr>";
		
  }
	
	if(!empty($id_d)&&!empty($d_tab[$id_d])){
	
		echo "<tr><td class=\"tlo3 bialy\">";	
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_d"=>$id_d));
		?>
		<div id="tree_kontener">
	    <div class="DynamicTree">
        <div class="top"><?php echo "<a class=\"grube\" href=\"".$link."&amp;akcja=sklepadmin_arch\">".$d_tab[$id_d]."</a>"; ?></div>
        <div class="wrap" id="tree2">
				<?php
				
					//pobieramy okreslone dane
    			$query="SELECT id, id_matka, tytul, typ FROM ".konf::get()->getKonfigTab("sql_tab",'sklep_kat')." WHERE lang='".konf::get()->getLang()."' ";
			    $query.=" AND id_d='".$id_d."' ";
					if(konf::get()->getKonfigTab("sklep_konf",'drzewo_poziomy')){
						$query.=" AND poziom<='".konf::get()->getKonfigTab("sklep_konf",'drzewo_poziomy')."'";
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
						sklep_drzewo_poziomy($link,$poziomy,0,1); 
					}
    
				?>
        </div>
	    </div>
		</div>
	  <script type="text/javascript">
	  	var tree2 = new DynamicTree("tree2");
	  	tree2.init();
	  </script>
		<?php	
		echo "</td></tr>";
	}
	echo tab_stop();
	
}

?>