<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

include_once(konf::get()->getKonfigTab('mod_kat')."ankieta/konfig_inc.php");

class ankieta extends modul {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="ankieta class";

	
  /**
   * show ankieta
   * @param int dlugosc
   * @param int/array dzial
   * @param array wykluczone		
   * @return string			
   */			
	public function pokaz($dlugosc,$dzial="",$wykluczone=""){

		$ankiety_gl=konf::get()->getZmienna("","","","ankiety_gl");		

		$dlugosc=$dlugosc+0;
		$html="";
		
		$ok=true;
		
		$query="SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'ankieta')." WHERE lang='".konf::get()->getLang()."'";

		if(!empty($dzial)){
			if(is_array($dzial)){
				$query.=" AND id_typ IN (".tekstForm::tabQuery($dzial,false).") ";		
			} else {
				$query.=" AND id_typ='".tekstForm::tabQuery($dzial,false)."' ";			
			}
		}
		
		if(!empty($wykluczone)&is_array($wykluczone)){	
			$query.=" AND id NOT IN (".tekstForm::tabQuery($wykluczone,false).")";			
		}
		
		$query.=" AND data_start<=NOW() AND (data_stop>=NOW() OR data_stop='0000-00-00 00:00:00')";
		$query.=" AND status=1 ORDER BY RAND() LIMIT 0,1";
		
		$dane=konf::get()->_bazasql->pobierzRekord($query);	
		
		if(!empty($dane)){		
		
			$ip=konf::get()->getIp();
			
			//czy tylko dla zalogowanych	
			if($dane['logowane']&&user::get()->zalogowany()&&konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'ankieta_glosy')." WHERE id_matka='".$dane['id']."' AND id_u='".user::get()->id()."'")>0){
				$ok=false;
			//sprawdzamy cookie
			} else if(!empty($ankiety_gl)){
				$tab=explode("|",$ankiety_gl);
				if(!empty($tab)&&in_array($dane['id'],$tab)){
					$ok=false;
				}	
			//sprawdzamy ip
			} else if(!empty($ip)&&($ip==$dane['last_ip'])&&konf::get()->getKonfigTab("ankieta_konf",'czas_ip')&&$dane['last_glos']>=tekstForm::dniData(konf::get()->getKonfigTab("ankieta_konf",'czas_ip'),"d",$znak="-")){
				$ok=false;
			}

			$zap2=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'ankieta_list')." WHERE id_matka=".$dane['id']." ORDER BY nr_poz, id");
			
			if(konf::get()->_bazasql->numRows($zap2)>0){
			
				//jesli mozna oddac glos
				if($ok){
					$tab=explode("|",$ankiety_gl);
					if(!empty($tab)&&in_array($dane['id'],$tab)){
						$ok=false;
					}
				}
				
				$html.="<div style=\"padding:5px\" class=\"lewa\">";
				if($ok){
					$form=new formularz("post",konf::get()->getKonfigTab("plik"),"ankietagl","ankietagl");
					$html.=$form->getFormp();
					$html.=$form->przenies(array("akcja"=>"ankieta_glos","id_ankieta"=>$dane['id']));
				}
				$html.="<div style=\"padding-bottom:5px;\"><i>".tekstForm::doWys($dane['tresc'])."</i></div>";
			
				$l_max=0;
				$l_sum=0;
				
				
				while($dane2=konf::get()->_bazasql->fetchAssoc($zap2)){
					$l_sum+=$dane2['glosy'];
					if($dane2['glosy']>$l_max){
						$l_max=$dane2['glosy'];
					}
					$dane3[]=$dane2;
				}
						
				while(list($key,$val)=each($dane3)){
				
					if($val['glosy']>0){
						$dane_dl=round(($val['glosy']/$l_max)*$dlugosc,1);
						$dane_pc=round(($val['glosy']/$l_sum)*100,1);
					} else {
						$dane_dl=0;
						$dane_pc=0;
					}
					
					$html.="<div class=\"nowa_l lewa\" style=\"padding-bottom:4px;\">";
					if($ok){
						if($dane['typ']==1){
							$html.=$form->input("radio","glosy[]","glosy_".$val['id'],$val['id'],"przycisk");
						} else {
							$html.=$form->input("checkbox","glosy[]","glosy_".$val['id'],$val['id'],"przycisk");					
						}
					}
					
					if($ok){
						$html.=" <label for=\"glosy_".$val['id']."\">";
					}
					$html.=$val['tresc'];
					if($ok){					
						$html.="</label>";
					}
					$html.="</div>";
					
					if(!$ok){
						$html.="<div>".str_replace("[WIDTH]",$dane_dl,konf::get()->getKonfigTab('pasek_stat'))."</div>";
						$html.="<div class=\"nowa_l\" style=\"padding-bottom:7px;\"><span class=\"grube\">".$val['glosy']."</span> (".$dane_pc."%)</div>";						
					}
				}
				
				if($ok){
					$html.="<div class=\"srodek\">";
					$html.=$form->input("submit","","",konf::get()->langTexty("ankieta_glosuj"),"formularz2 f_krotki");				
					$html.="</div>";
					$html.=$form->getFormk();
				}
				
				$html.="<div class=\"srodek\" style=\"padding-top:5px\"><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ankieta_lista"))."\">".konf::get()->langTexty("ankieta_wyniki")."</a></div>";
				
				$html.="</div>";
			}
			konf::get()->_bazasql->freeResult($zap2);
		}

		return $html;
		 
	}	


  /**
   * add vote 
   */		
	public function glos(){
		
		$ankiety_gl=konf::get()->getZmienna("","","","ankiety_gl");	
		$id_ankieta=tekstForm::doSql(konf::get()->getZmienna("id_ankieta"));	
		$glosy=konf::get()->getZmienna('glosy');
		
		$ok=false;

		if(!empty($glosy)&&is_array($glosy)){
		
			$dane=konf::get()->_bazasql->pobierzRekord("SELECT typ,last_ip,last_glos,logowane FROM ".konf::get()->getKonfigTab("sql_tab",'ankieta')." WHERE id='".$id_ankieta."' AND status=1 AND data_start<=NOW() AND (data_stop>=NOW() OR data_stop='0000-00-00 00:00:00') AND lang='".konf::get()->getLang()."'");

			if(!empty($dane)){

				$ip=konf::get()->getIp();		
				$glosowano=false; 
			
				//czy tylko dla zalogowanych	
				if($dane['logowane']&&(!user::get()->zalogowany()||konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'ankieta_glosy')." WHERE id_matka='".$id_ankieta."' AND id_u='".user::get()->id()."'")>0)){
					$glosowano=true;
				//sprawdzamy cookie
				} else if (!empty($ankiety_gl)){
					$tab=explode("|",$ankiety_gl);
					if(!empty($tab)&&in_array($id_ankieta,$tab)){
						$glosowano=true;
					}	
				//sprawdzamy ip
				} else if(konf::get()->getKonfigTab("ankieta_konf",'notuj_ip')&&($ip==$dane['last_ip'])&&$dane['last_glos']>=tekstForm::dniData(konf::get()->getKonfigTab("ankieta_konf",'czas_ip'),"d","-")){
					$glosowano=true;
				}

				//jesli nie glosowano 
				if(!$glosowano){
					
					$query="0";
					while(list($key,$val)=each($glosy)){
						if($dane['typ']==2||empty($query)){
							$query.=",".tekstForm::doSql($val);
						}
					}
					//jesli oddano niepuste glosy
					if(!empty($query)){
					
						//dodajemy glosy
						konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'ankieta_list')." SET glosy=glosy+1 WHERE id IN (".$query.") AND id_matka='".$id_ankieta."'");

						//notujemy ip					
						if(konf::get()->getKonfigTab("ankieta_konf",'notuj_ip')){
							konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'ankieta')." SET last_ip='".tekstForm::doSql($ip)."', last_glos=NOW() WHERE id='".$id_ankieta."'");
						}
						
						//notujemy id
						if($dane['logowane']){
							konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'ankieta_glosy')." (id_matka, id_u,last_glos) VALUES ('".$id_ankieta."','".user::get()->id()."',NOW())");
						} else {
						//lub zapis cookie
							$ankiety_gl.=$id_ankieta."|";
							konf::get()->zapiszCookie('ankiety_gl',$ankiety_gl,3600*24*konf::get()->getKonfigTab("ankieta_konf",'czas_cookie'),"/");
						}
						
					}
				}
				$ok=true;
			}
		}

	}

	
  /**
   * show list
   */	
	public function lista(){

		$podstrona=konf::get()->getZmienna("podstrona","podstrona");	
		$id_ankieta=tekstForm::doSql(konf::get()->getZmienna("id_ankieta","id_ankieta"));				
		$na_str=3;

		$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'ankieta')." WHERE lang='".konf::get()->getLang()."' ";
		if(!user::get()->adminU()){
			$query.=" AND status=1";	
		}
		if(!empty($id_ankieta)){
			$query.=" AND id='".$id_ankieta."'";
		}
		
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"ankieta_lista"));
		
		$naw = new nawig("SELECT COUNT(id) AS ilosc ".$query,$podstrona,$na_str);		
		$naw->naw($link);
		$podstrona=$naw->getPodstrona();	

		if(user::get()->adminU()){	
			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"ankieta_list","ankieta_list");
			echo $form->getFormp();
			echo $form->przenies(array("akcja"=>"ankietaadmin_edytuj"));		
		}
		
		echo "<h1>";
		if(empty($id_ankieta)){
		  echo konf::get()->langTexty("ankieta_arch").$naw->getWynikow()."):";	
		} else {
			echo konf::get()->langTexty("ankieta_wynik");
		}
		echo "</h1>";

		if($naw->getNaw()){
			echo "<div class=\"tlo3 prawa\">".$naw->getNaw()."</div>";
		}	

		$zap=konf::get()->_bazasql->zap("SELECT * ".$query." ORDER BY data_start DESC, data_stop DESC, id DESC LIMIT ".$naw->getStart().",".$naw->getIle());
		
		while($dane=konf::get()->_bazasql->fetchAssoc($zap)){

			$zap2=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'ankieta_list')." WHERE id_matka=".$dane['id']." ORDER BY nr_poz, id");
			$l_max=0;
			$l_sum=0;
				
	  	while($dane2=konf::get()->_bazasql->fetchAssoc($zap2)){
	  		$l_sum+=$dane2['glosy'];
	  		if($dane2['glosy']>$l_max){
	  			$l_max=$dane2['glosy'];
	  		}
	  		$dane3[]=$dane2;
	  	}
	  	
	  	echo "<div class=\"lewa tlo3\" style=\"padding-bottom:15px\">";
			
			echo "<div style=\"padding-bottom:5px\">";
			if(user::get()->adminU()){
				echo $form->input("radio","id_nr","",$dane['id'],"przycisk","","onclick=\"this.form.submit()\"");	
			}
			echo "<span class=\"grube\">".$dane['tytul']."</span> (".$l_sum.")</div>";
			
			echo "<div class=\"lewa\" style=\"padding-bottom:5px\"><i>".tekstForm::doWys($dane['tresc'])."</i></div>";
									
			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
			
	  	while(list($key,$val)=each($dane3)){
			
	  		if($val['glosy']>0){
	  			$dane_dl=round(($val['glosy']/$l_max)*konf::get()->getKonfigTab("ankieta_konf",'dl_pasek'),1);
	  			$dane_pc=round(($val['glosy']/$l_sum)*100,1);
	  		} else {
	  			$dane_dl=0;
	  			$dane_pc=0;
	  		}
				echo "<tr><td class=\"lewa tlo3\" colspan=\"2\">".$val['tresc']."</td></tr>";
				echo "<tr valign=\"top\"><td class=\"lewa tlo3\" style=\"width:".(konf::get()->getKonfigTab("ankieta_konf",'dl_pasek')+20)."px; padding-right:3px; padding-top:3px;\">";
				echo str_replace("[WIDTH]",$dane_dl,konf::get()->getKonfigTab('pasek_stat'));
				echo "</td>";
				echo "<td class=\"lewa tlo3\">";
				echo "<span class=\"grube\">".$val['glosy']."</span> (".$dane_pc."%)";
				echo "</td></tr>";
			}
			konf::get()->_bazasql->freeResult($zap2);
			echo "</table>";
			
			echo "</div>";
			
		}	
		konf::get()->_bazasql->freeResult($zap);
		
		if($naw->getNaw()){
			echo "<div class=\"tlo3 prawa\">".$naw->getNaw()."</div>";
		}	
		
		if(!empty($id_ankieta)){
			echo "<div class=\"srodek tlo3\"><a href=\"".$link."\">".konf::get()->langTexty("ankieta_lista")."</a></div>";
		}

		if(user::get()->adminU()){
			echo $form->getFormk();
		}
	}
	
	
	/**
   * class constructor php5	
   */	
	public function __construct() {	
	
		$this->_admin=konf::get()->getKonfigTab("ankieta_konf",'admin_ankieta');

  }	

	
}	

?>