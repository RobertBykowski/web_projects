<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}



class galerieadmin extends moduladmin {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="galerieadmin class";


	/**
   * data types
   */	
	public function typy(){

		$colspan=2;
		$tab=konf::get()->getKonfigTab("galerie_konf","typy_tab");
		
		echo tab_nagl("Typy galerii zdjęciowych",$colspan);
		echo "<tr>";		
		echo "<td class=\"tlo4 lewa grube\">nazwa typu zdjęć</td>";
		echo "<td class=\"tlo4 prawa grube\" style=\"width:50px\">ilość</td>";
		echo "</tr>";	

		if(!empty($tab)&&is_array($tab)){
		
			$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"galerieadmin_arch"));
			while(list($key,$val)=each($tab)){
				echo "<tr>";
				echo interfejs::innyEl("picture","<a href=\"".$link."&amp;id_typ=".$key."\">".$val['nazwa']."</a>","tlo3");
				echo "<td class=\"tlo3 prawa\">";
				echo konf::get()->_bazasql->policz("id"," FROM ".$val['mysql']." WHERE 1");
				echo "</td></tr>";
			}

		} else {
		
			echo interfejs::brak($colspan);
			
		}
		
		echo tab_stop();
	}


  /**
   * data arch
   */	
	public function arch(){

		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));		
		$sortuj=tekstForm::doSql(konf::get()->getZmienna('sortuj','sortuj'));
		$id_typ=tekstForm::doSql(konf::get()->getZmienna('id_typ','id_typ'));	
		$tab=konf::get()->getKonfigTab("galerie_konf","typy_tab");		
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');		
		$colspan=6;
		$na_str=25;
		
		if(empty($tab[$id_typ])){
			$id_typ="";
		}
		
		$tab_sort=array(	
			1=>"autor_kiedy, id",
			2=>"autor_kiedy DESC, id DESC",
			
			9=>"edytor_kiedy, id",
			10=>"edytor_kiedy DESC, id DESC",			
			
			3=>"id", 
			4=>"id DESC", 		
			5=>"autor_name", 
			6=>"autor_name DESC", 
		);

		if(empty($tab_sort[$sortuj])){ 
			$sortuj=5;
		}
		
		if(!empty($id_typ)){
			
			$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"galerieadmin_arch","id_typ"=>$id_typ));
			$link3=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"galerieadmin_arch","sortuj"=>$sortuj,"id_typ"=>$id_typ));		
			$link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane"));					
			
			$query=" FROM ".$tab[$id_typ]['mysql']." WHERE 1 ";
			
			$naw = new nawig("SELECT COUNT(id) AS ilosc ".$query,$podstrona,$na_str);		
			$naw->naw($link3);
			$podstrona=$naw->getPodstrona();	
			
			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"arch","arch");
			echo $form->spr(array(1=>"akcja"),"","ok=spr_akcjau(document.arch.akcja,'galerieadmin_usun','".konf::get()->langTexty("czyusun")."');");
			echo $form->getFormp();
			echo $form->przenies(array("sortuj"=>$sortuj,"podstrona"=>$podstrona,"id_typ"=>$id_typ));
			
			konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/jquery-min.js","js");
			konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/slimbox/slimbox2.js","js");					
			konf::get()->setPlikiHeader(konf::get()->getKonfigTab('sciezka')."js/slimbox/slimbox2.css","css");						
		
		  echo tab_nagl("Galerie ".$tab[$id_typ]['nazwa']." (".$naw->getWynikow()."):",$colspan);

		   //akcje 
			$akcje_tab=array(); 			
			if($naw->getWynikow()>0){		
				$akcje_tab['galerieadmin_usun']=konf::get()->langTexty("ausun");
			}

		  echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 lewa\">";
			echo $form->selectAkcja($akcje_tab);
			echo "</td></tr>";	
			
			if($naw->getWynikow()>0){			
				echo "<tr><td colspan=\"".$colspan."\" class=\"tlo4 srodek nobr\">";		
				echo $form->zaod("id_tab");	
				echo "</td></tr>";		
			}

			if($naw->getNaw()){
				echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
			}			

			echo "<tr class=\"srodek\">";
			echo interfejs::sortEl($link."&amp;sortuj=",3,4,"id",$sortuj,50);
			echo interfejs::sortEl($link."&amp;sortuj=","","","zdjęcie",$sortuj,200);					
			echo interfejs::sortEl($link."&amp;sortuj=",5,6,"autor",$sortuj);			
			echo interfejs::sortEl($link."&amp;sortuj=",1,2,"data dodania",$sortuj,100);	
			echo interfejs::sortEl($link."&amp;sortuj=",9,10,"data edycji",$sortuj,100);				
			echo interfejs::sortEl("","","","&nbsp;","",66);
			echo "</tr>";

			if($naw->getWynikow()>0){
			
				$zap=konf::get()->_bazasql->zap("SELECT * ".$query." ORDER BY ".$tab_sort[$sortuj]." LIMIT ".$naw->getStart().",".$naw->getIle());
				
				while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
				
					echo "<tr class=\"srodek\">";
					
					echo "<td class=\"tlo4 srodek\">";
					echo $form->checkbox("id_tab[]","id_".$dane['id'],$dane['id'],"");	
					echo "<div";
					if($id_nr==$dane['id']){
						echo " class=\"grube\"";
					}
					echo ">".$dane['id']."</div>";			
					echo "</td>";
					
					echo "<td class=\"srodek tlo3\">";	
					if(!empty($dane['img2_nazwa'])){
					 	echo "<a href=\"".konf::get()->getKonfigTab("sciezka").$tab[$id_typ]['katalog'].$dane['img1_nazwa']."\" rel=\"lightbox\" title=\"".htmlspecialchars($dane['tytul'])."\"><img src=\"".konf::get()->getKonfigTab("sciezka").$tab[$id_typ]['katalog'].$dane['img2_nazwa']."\" class=\"obrazek\" width=\"".$dane['img2_w']."\" height=\"".$dane['img2_h']."\" alt=\"".htmlspecialchars($dane['tytul'])."\" /></a>";
					}							
					echo "<div class=\"male\">".$dane['tytul']."</div>";					
					echo "</td>";

					echo "<td class=\"lewa tlo3\">";	
					if(user::get()->adminU()){
						echo "<a class=\"grube\" href=\"".$link2."&amp;id_u=".$dane['autor_id']."\">";
					}
					echo $dane['autor_name'];
					if(user::get()->adminU()){					
						echo "</a>";
					}
					echo "</td>";							
										
					echo "<td class=\"srodek tlo3\">";
					echo str_replace(" ","<br />",$dane['autor_kiedy']);
					echo "</td>";			
					
					echo "<td class=\"srodek tlo3\">";
					if(tekstForm::niepuste($dane['edytor_kiedy'])){
						echo str_replace(" ","<br />",$dane['edytor_kiedy']);
					}
					echo "</td>";												

					echo "<td class=\"srodek tlo3\" valign=\"top\">";
					echo "<table border=\"0\" class=\"srodek\"><tr valign=\"top\">"; 						   
					echo interfejs::infoEl($dane);
					echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"galerieadmin_usun","id_typ"=>$id_typ,"id_tab[]"=>$dane['id']))); 
					echo "</tr></table>"; 				
					echo "</td>";
					echo "</tr>";
					
				}		
				konf::get()->_bazasql->freeResult($zap);		

				if($naw->getNaw()){
					echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
				}

			} else { 
				echo interfejs::brak($colspan);
			}

		  echo "<tr class=\"srodek\"><td colspan=\"".$colspan."\" class=\"tlo4 srodek\">".interfejs::linkEl("text_list_bullets",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"galerieadmin_typy")),"Typy galerii zdjęciowych")."</td></tr>";
			
		  echo tab_stop();
			echo $form->getFormk();
			
		} else {
		
			echo interfejs::nieprawidlowe();			
			
		}		
		
	}

	
  /**
   * remove data
   */	
	public function usun(){

		$id_tab=konf::get()->getZmienna('id_tab','id_tab');
		$id_typ=tekstForm::doSql(konf::get()->getZmienna('id_typ','id_typ'));		
		$tab=konf::get()->getKonfigTab("galerie_konf","typy_tab");		
		
		if(empty($tab[$id_typ])){
			$id_typ="";
		}	
	
		if(!empty($id_typ)&&!empty($id_tab)&&is_array($id_tab)){
		
			$query=tekstForm::tabQuery($id_tab);
			
			if(!empty($query)){
			
			  $zap=konf::get()->_bazasql->zap("SELECT * FROM ".$tab[$id_typ]['mysql']." WHERE id_matka IN (".$query.")");
			  while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
					$this->usunImg($dane,$tab[$id_typ]['katalog'],2,"img");						
				}
				konf::get()->_bazasql->zap("DELETE FROM ".$tab[$id_typ]['mysql']." WHERE id IN (".$query.")");	
				
				if($tab[$id_typ]['mysql_koment']){
					konf::get()->_bazasql->zap("DELETE FROM ".$tab[$id_typ]['mysql_koment']." WHERE id_matka IN (".$query.")");				
				}
						
				user::get()->zapiszLog("galerie usuwanie",user::get()->login());
			}
			konf::get()->setKomunikat(konf::get()->langTexty("usuwanie"),""); 
			
		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),"error"); 		
		}
		
	}	
	
	
	/**
   * class constructor php5	
   */	
	public function __construct() {	
	
		$this->_admin=konf::get()->getKonfigTab("galerie_konf",'admin');

  }	

}

?>