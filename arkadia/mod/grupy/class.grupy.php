<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

include_once(konf::get()->getKonfigTab('mod_kat')."grupy/konfig_inc.php");

class grupy extends modul {

	/**
	 * Privates variables
	 */

		
	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="grupy class";	
	
	/**
	 * id grupy
	 */				
  public $_id="";		
	
	/**
	 * dane grupy
	 */				
  public $_dane="";			
	
	
	/**
	 * get search values
	 */		
	protected $_szuk=array(
		"szuk_nazwa"=>"",		
		"typ"=>"",			
	);	
		
		
  /**
   * date format
   * @param string $data
   * @param bool $br
	 * @return string					
   */	
	public function dataForm($data,$br=false){
	
		$data=tekstForm::niepuste(substr($data,0,16));
		
		if($br){
			$data=str_replace(" ","<br />",$data);
		}
		
		return $data;
	
	}
	
	
  /**
   * add sql to admin group
   * @param string $tab
	 * @return string			
   */		
	public function sqlAdd($tab=""){
	
		if($tab){
			$tab=$tab.".";
		}
		
		$sql="";
		if(!$this->admin()){
			$sql.=" AND ((".$tab."autor_id='".user::get()->id()."' AND ".$tab."status!=0) OR ".$tab."status=1)";
		}
		
		return $sql;
			
	}	
	
	
  /**
   * set grupa
   */
	public function setGrupa($id_grupa){
	
		$id_grupa=$id_grupa+0;
			
		if(!empty($id_grupa)){	
			
			if($this->admin()){		
				$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'grupy')." WHERE id='".$id_grupa."'");	
			} else {
				$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'grupy')." WHERE id='".$id_grupa."' AND ((autor_id='".user::get()->id()."' AND status!=0) OR status=1)");
			}
			
			if(!empty($dane)){
				$this->_id=$id_grupa;				
				$this->_dane=$dane;
			} else {
				$this->_id="";							
				$this->_dane=array();
			}
			
		} else {
			$this->_id="";							
			$this->_dane=array();		
		}
		
	}	
				
	
  /**
   * update members counter
   * @param int $id_grupa		
   */		
	private function updateOsoby($id_grupa=""){
	
		if(empty($id_grupa)){
			$id_grupa=$this->_id;
		}
	
		if(!empty($id_grupa)){
			konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'grupy')." g SET g.osoby=(SELECT COUNT(u.id) FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." u WHERE u.id_grupa=g.id AND u.status=1) WHERE g.id=".$id_grupa);
		}
	
	}
	
	
  /**
   * add sql to admin group
   * @param int $id_grupa
	 * @return bool			
   */		
	private function jestWgrupie($id_u="",$id_grupa=""){
	
		if(empty($id_grupa)){
			$id_grupa=$this->_id;
		}	
		
		if(empty($id_u)){
			$id_u=user::get()->id();
		}			
		
		$ok=false;
		
		if(!empty($id_grupa)){
		
			if(konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." WHERE id_u='".$id_u."' AND id_grupa='".$id_grupa."' AND status=1")>0){
			
				$ok=true;			
				
			}
			
		}
		
		return $ok;
	
	}	
	
	
  /**
   * if invitation exists send by me
   * @param int $id_grupa		
	 * @return bool	
   */		
	private function istniejeZgloszenie($id_grupa=""){
	
		if(empty($id_grupa)){
			$id_grupa=$this->_id;
		}	
	
		$ok=false;		

		if(konf::get()->_bazasql->policz('id'," FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." WHERE id_u='".user::get()->id()."' AND id_grupa='".$id_grupa."' AND status=0")>0){
			$ok=true;
		}
		
		return $ok;
		
	}		
			
			
  /**
   * test privileges to admin group - if no admin -reset data
   */			
	private function grupaSpr(){
	
		if(!empty($this->_id)){
			if(empty($this->_dane)||!($this->admin()||$this->_dane['autor_id']==user::get()->id())){
				$this->setGrupa("");			
			}
		}			
	
	}	
	
	
  /**
   * date format
   * @param int $id_grupa
	 * @return bool				
   */		
	private function dostep($id_grupa){
	
		$ok=true;
		
		if($this->admin()||!$this->_dane['zamknieta']||$this->jestWgrupie("",$id_grupa)){
			$ok=true;
		} else {
			$ok=false;
		}
	
		return $ok;
	
	}		
		
		
  /**
   * show groups main menu
   */
	public function menu(){	
	
		echo tab_nagl("Grupy");
		echo "<tr><td class=\"tlo3 lewa\" style=\"padding:0px\">";			
		echo interfejs::linkEl2("group",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_kat")),"Wszystkie grupy");	
		echo interfejs::linkEl2("group_go",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_user")),"Moje grupy");	
		echo interfejs::linkEl2("add",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_dodaj")),"Załóż grupę");	
		echo "</td></tr>";		
		echo tab_stop();

	}
	
	
  /**
   * group menu
   * @param array $dane
   */		
	public function grupaMenu($dane=""){
		
		$akcja=konf::get()->getAkcja();
	
		if(empty($dane)){
			$dane=$this->_dane;
		}		
		
		echo tab_nagl("Menu grupy");
		echo "<tr><td class=\"tlo3 lewa\" style=\"padding:0px\">";	
		
		$i="";
		
		if($akcja=="grupy_zobacz"){
			$i="2";
		} else {
			$i="";
		}		
		echo interfejs::linkEl2("group",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_zobacz","id_grupa"=>$dane['id'])),"Opis grupy","menu_item".$i);
		
		if($akcja=="grupy_ludzie"){
			$i="2";
		} else {
			$i="";
		}		
		echo interfejs::linkEl2("group",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_ludzie","id_grupa"=>$dane['id'])),"Członkowie grupy","menu_item".$i);
		
		if(konf::get()->getKonfigTab("grupy_konf",'galeria')){
			if(!(strpos($akcja,"grupygal_")===false)){
				$i="2";
			} else {
				$i="";
			}		
			echo interfejs::linkEl2("picture",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupygal_arch","id_grupa"=>$dane['id'])),"Galeria zdjęć","menu_item".$i);
		}			
			
		if($this->jestWgrupie("",$dane['id'])){
		
			if($akcja=="grupy_rezygnuj"){
				$i="2";
			} else {
				$i="";
			}
			echo interfejs::linkEl2("delete",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_rezygnuj","id_grupa"=>$dane['id'])),"Rezygnuj z grupy","menu_item".$i);
		
		} else {
		
			if($akcja=="grupy_dolacz"){
				$i="2";
			} else {
				$i="";
			}
			echo interfejs::linkEl2("accept",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_dolacz","id_grupa"=>$dane['id'])),"Dołącz do grupy","menu_item".$i);
		
		}		
			
		if($dane['autor_id']==user::get()->id()){
		
			if($akcja=="grupy_edytuj"){
				$i="2";
			} else {
				$i="";
			}			
			echo interfejs::linkEl2("group_edit",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_edytuj","id_grupa"=>$dane['id'])),"Edytuj","menu_item".$i);
			
		}
		
		if($dane['autor_id']==user::get()->id()&&konf::get()->getKonfigTab("grupy_konf",'usuwanie')){		

			if($akcja=="grupy_usun"){
				$i="2";
			} else {
				$i="";
			}
			echo interfejs::linkEl2("cross",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_usun","id_grupa"=>$dane['id'])),"Usuń grupę","menu_item".$i);		
		
		}
						
		echo "</td></tr>";		
		echo tab_stop();		
	
	}	
	
  /**
   * show group types
   */		
	private function typy(){
	
		$typy_tab=konf::get()->getKonfigTab("grupy_konf",'typy_tab');		
		$colspan=3;		
		$ilosci_tab=konf::get()->_bazasql->pobierzRekordy("SELECT typ, COUNT(id) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'grupy')." WHERE 1 ".$this->sqlAdd()." GROUP BY typ","typ");
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_kat"));				
		
		echo tab_nagl("Kategorie grup");
		echo "<tr><td class=\"tlo3 lewa\">";
		
		echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"5\" class=\"seta\">";
		
		$i=0;
		while(list($key,$val)=each($typy_tab)){
		
			if($i==0){
				echo "<tr valign=\"top\">";
			}
			echo "<td><a class=\"grube\" href=\"".$link."&amp;typ=".$key."\">".$val."</a>";
			
		 	echo " (";
			if(!empty($ilosci_tab[$key])){
				echo $ilosci_tab[$key]['ile'];
			} else {
				echo "0";
			}
			echo ")";
			echo "</td>";
			
			$i++;
			if($i==$colspan){
				echo "</tr>";
				$i=0;
			}
		
		}
		
		if($i>0){
			while($i<$colspan){
				echo "<td>&nbsp;</td>";
				$i++;
			}
			echo "</tr>";
		}
		
		echo "</table>";						
				
		echo "</td></tr>";
		echo tab_stop();
			
	
	}
	
	
  /**
   * gropus search form
   */		
	private function wyszukiwarka(){
	
		$typy_tab=konf::get()->getKonfigTab("grupy_konf",'typy_tab');			
		
		echo tab_nagl("Wyszukaj grupę");
		echo "<tr><td class=\"lewa tlo3\">";
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"u_arch2","u_arch2");
		echo $form->getFormp();
		echo $form->przenies(array("akcja"=>konf::get()->getAkcja()));		
		echo $form->input("text","szuk_nazwa","szuk_nazwa",$this->_szuk['szuk_nazwa'],"f_dlugi",50);	
		echo "&nbsp;";
		echo $form->select("typ","typ",$typy_tab,$this->_szuk['typ'],"f_dlugi","--wybierz kategorię--");
		echo "&nbsp;";
		echo $form->input("submit","","",konf::get()->langTexty("szukaj"),"formularz2 f_sredni");	
		echo $form->getFormk();		
		
		echo "</td></tr>";
		echo tab_stop();
			
	}
	
	
  /**
   * show new groups and last active groups
   * @param int $ile
   */		
	private function nowedobre($ile=5){
	
		echo tab_nagl();
		echo "<tr valign=\"top\" class=\"lewa\">";		
		echo "<td style=\"width:50%\" class=\"tlo4 grube\">Ostatnio aktywne grupy:</td>";
		echo "<td style=\"width:50%\" class=\"tlo4 grube\">Najnowsze grupy:</td>";		
		echo "</tr>";
		
		echo "<tr class=\"lewa\" valign=\"top\">";
		
		echo "<td class=\"tlo3\">";
		
		$zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'grupy')." WHERE status=1 ORDER BY data_aktywnosci DESC LIMIT 0,".$ile);

		while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
			echo "<div class=\"lewa nowa_l\" style=\"padding-bottom:5px;\">";
			$this->grupyRekord($dane,2,false);
			echo "</div>";
		}
		konf::get()->_bazasql->freeResult($zap);
		
		echo "</td>";
		
		echo "<td class=\"tlo3\">";
		
		$zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'grupy')." WHERE status=1 ORDER BY autor_kiedy DESC LIMIT 0,".$ile);

		while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
			echo "<div class=\"lewa nowa_l\" style=\"padding-bottom:5px;\">";
			$this->grupyRekord($dane);
			echo "</div>";
		}
		konf::get()->_bazasql->freeResult($zap);		
		
		echo "</td>";		
		
		
		echo "</tr>";
		echo tab_stop();
		
	}
	
	
  /**
   * show group data
   * @param array $dane	
   */		
	public function grupyRekord($dane){	
	
		if(!empty($dane)){

			echo "<div class=\"grube\"><a href=\"".$this->grupLink($dane)."\">".$dane['nazwa']."</a></div>";
			echo $dane['opis_krotki'];
		
		}
	
	}
	
	
  /**
   * return html with group logo
   * @param array $dane
   * @param int $numer
   * @param bool $link
	 * @return string
   */		
	public function grupyLogo($dane,$numer=2,$link=true){
	
		$html="";
		
    if(!empty($dane['img'.$numer.'_nazwa'])&&file_exists(konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("grupy_konf",'kat').$dane['img'.$numer.'_nazwa'])){
			if($link){
				$html.="<a href=\"".$this->grupLink($dane)."\">";
			}
			$html.="<img src=\"".konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("grupy_konf",'kat').$dane['img'.$numer.'_nazwa']."\" alt=\"".htmlspecialchars($dane['nazwa'])."\" />";
			if($link){
				$html.="</a>";			
			}
 		}
		
		return $html;
					
	}
	
	
  /**
   * return link to group data
   * @param array $dane
	 * @return string
   */			
	public function grupLink($dane){
	
		$html=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_zobacz","id_grupa"=>$dane['id']));
		
		return $html;
		
	}
	
	
  /**
   * show groups
   */		
	public function kat(){
	
		$link=$this->szukZmienne(1);
		
		if(empty($this->_szuk['szuk_nazwa'])&&empty($this->_szuk['typ'])){
		
			$this->typy();						
		
		}
		
		$this->wyszukiwarka();
						
		if(empty($this->_szuk['szuk_nazwa'])&&empty($this->_szuk['typ'])){
		
			$this->nowedobre();			
		
		} else {
		
			$this->arch();
		
		}
		
	}
	
	
  /**
   * show my groups
   */		
	public function user(){

		$id_u=tekstForm::doSql(konf::get()->getZmienna("id_u","id_u"));		
		$podstrona=konf::get()->getZmienna("podstrona","podstrona");	
		$sortuj=tekstForm::doSql(konf::get()->getZmienna("sortuj","sortuj"));				
		$na_str=konf::get()->getKonfigTab("grupy_konf",'na_strm');
		$typy_tab=konf::get()->getKonfigTab("grupy_konf",'typy_tab');
		$colspan=4;	
		
		if(empty($id_u)){
			$id_u=user::get()->id();
		}						
		
		$dane_u=user::get()->getById($id_u,true);
		
		if(!empty($dane_u)&&!user::get()->jestCzarna($id_u)){			
				
			$tab_sort=array(
				1=>"p.id", 2=>"p.id DESC", 
				3=>"p.nazwa", 4=>"p.nazwa DESC", 
				5=>"p.autor_kiedy, p.id", 6=>"p.autor_kiedy DESC, p.id DESC", 
				7=>"p.osoby", 8=>"p.osoby DESC", 			
				9=>"p.data_aktywnosci", 10=>"p.data_aktywnosci DESC", 			
				11=>"p.wypowiedzi", 12=>"p.wypowiedzi DESC",	
				13=>"u.data_dodania", 14=>"u.data_dodania DESC", 							
			);	
			
			if(empty($tab_sort[$sortuj])){ 		
				$sortuj=6; 
			}	

			$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>konf::get()->getAkcja(),"id_u"=>$id_u));			
			$link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane"));													
			$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'grupy')." p LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." u ON p.id=u.id_grupa WHERE u.id_u='".$id_u."'".$this->sqlAdd("p");

			$naw = new nawig("SELECT COUNT(p.id) AS ilosc ".$query,$podstrona,$na_str);		
			$naw->naw($link);
			$podstrona=$naw->getPodstrona();	

			if($id_u=-user::get()->id()){
				echo tab_nagl("Moje grupy (".$naw->getWynikow()."):",$colspan);	
			} else {
				echo tab_nagl("Grupy użytkownika ".user::get()->nazwa($dane_u)." (".$naw->getWynikow()."):",$colspan);			
			}

			if($naw->getNaw()){
				echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
			}	
			
			echo "<tr class=\"srodek\">";		
			echo interfejs::sortEl($link."&amp;sortuj=","","","",$sortuj,80);			
			echo interfejs::sortEl($link."&amp;sortuj=",3,4,"nazwa i opis grupy",$sortuj);				
			echo interfejs::sortEl($link."&amp;sortuj=",7,8,"członków",$sortuj,80);
			echo interfejs::sortEl($link."&amp;sortuj=",9,10,"aktywność",$sortuj,100);		
			echo "</tr>";		
			
			if($naw->getWynikow()>0){		
			
				$funkcja="";			
				$i=0;
				
				$zap=konf::get()->_bazasql->zap("SELECT p.*, u.ostatnia_wizyta, u.funkcja ".$query." ORDER BY u.funkcja DESC, ".$tab_sort[$sortuj]." LIMIT ".$naw->getStart().",".$naw->getIle());

				while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
				
					if($i==0||$funkcja!=$dane['funkcja']){
					
						$funkcja=$dane['funkcja'];
						
				  	echo "<tr>";
						echo "<td class=\"tlo4 lewa grube\" colspan=\"".$colspan."\">";
						if($funkcja==2){
							echo "Właściciel:";
						} else if($funkcja==1){
							echo "Moderator:";					
						} else {
							echo "Członek:";					
						}
						echo "</td></tr>";				

					}
			  	
			  	echo "<tr class=\"srodek\">";
					echo "<td class=\"tlo4\">";
					echo $this->grupyLogo($dane,2,true);
					echo "</td>";

					echo "<td class=\"tlo3 lewa\">";
					echo $this->grupyRekord($dane);
					echo "</td>";

					echo "<td class=\"tlo3 prawa\">";
					echo $dane['osoby'];
					echo "</td>";				
					
					echo "<td class=\"tlo3 srodek\">";	
					
					if($dane['data_aktywnosci']>$dane['ostatnia_wizyta']){
						echo "<div class=\"grube\">";
					}
					echo $this->dataForm($dane['data_aktywnosci']);
					if($dane['data_aktywnosci']>$dane['ostatnia_wizyta']){
						echo "</div>";
					}				
					echo "<div>(".$dane['wypowiedzi'].")</div>";									
					echo "</td>";
					
					echo "</tr>";
					
					$i++;
					
				}	
				konf::get()->_bazasql->freeResult($zap);		
				
				if($naw->getNaw()){
					echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
				}	
				
			} else {
			
				echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 srodek grube\" style=\"padding:10px;\">".konf::get()->langTexty("brakdanych")."</td></tr>";
				
			}
			
			echo tab_stop();	
			
		}
		
	}
	
	
  /**
   * show  groups list
   */
	private function arch(){
	
		$podstrona=konf::get()->getZmienna("podstrona","podstrona");	
		$sortuj=tekstForm::doSql(konf::get()->getZmienna("sortuj","sortuj"));				
		$na_str=konf::get()->getKonfigTab("grupy_konf",'na_str');
		$typy_tab=konf::get()->getKonfigTab("grupy_konf",'typy_tab');
		$colspan=4;	
			
		$tab_sort=array(
			1=>"p.id", 2=>"p.id DESC", 
			3=>"p.nazwa", 4=>"p.nazwa DESC", 
			5=>"p.autor_kiedy, p.id", 6=>"p.autor_kiedy DESC, p.id DESC", 
			7=>"p.osoby", 8=>"p.osoby DESC", 					
		);	
			
		$link=$this->szukZmienne(1);	
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>konf::get()->getAkcja())).$link;			
		$link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane"));													
		
		if(!empty($this->_szuk['typ'])){
			$tytul="Grupy kategoria";	
			if(!empty($typy_tab[$this->_szuk['typ']])){
				$tytul.=" ".$typy_tab[$this->_szuk['typ']];
			}			
		} else {
			$tytul="Lista grup";
		}		

		if(empty($tab_sort[$sortuj])){ 		
			$sortuj=6; 
		}			
		
		$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'grupy')." p WHERE 1".$this->sqlAdd();		
		
		if(!empty($this->_szuk['typ'])){
			$query.=" AND p.typ='".tekstform::doSql($this->_szuk['typ'])."'";
		}
		
		if(!empty($this->_szuk['szuk_nazwa'])){
			$query.=" AND p.nazwa LIKE '%".tekstform::doLike($this->_szuk['szuk_nazwa'])."%'";
		}		

		$naw = new nawig("SELECT COUNT(p.id) AS ilosc ".$query,$podstrona,$na_str);		
		$naw->naw($link);
		$podstrona=$naw->getPodstrona();	

		echo tab_nagl($tytul." (".$naw->getWynikow()."):",$colspan);	

		if($naw->getNaw()){
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
		}	
		
		echo "<tr class=\"srodek\">";		
		echo interfejs::sortEl($link."&amp;sortuj=","","","",$sortuj,80);			
		echo interfejs::sortEl($link."&amp;sortuj=",3,4,"nazwa i opis grupy",$sortuj);	
		echo interfejs::sortEl($link."&amp;sortuj=",5,6,"utworzono",$sortuj,110);					
		echo interfejs::sortEl($link."&amp;sortuj=",7,8,"członków",$sortuj,80);	
		echo "</tr>";		
		
		if($naw->getWynikow()>0){		
			
			$zap=konf::get()->_bazasql->zap("SELECT p.* ".$query." ORDER BY ".$tab_sort[$sortuj]." LIMIT ".$naw->getStart().",".$naw->getIle());

			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
		  	
		  	echo "<tr class=\"srodek\">";
				echo "<td class=\"tlo4\">";
				echo $this->grupyLogo($dane,2,true);
				echo "</td>";

				echo "<td class=\"tlo3 lewa\">";
				echo $this->grupyRekord($dane);
				echo "</td>";
				
				echo "<td class=\"tlo3 srodek\">";	
				echo $this->dataForm($dane['autor_kiedy']);
				echo "<div><a href=\"".$link2."&amp;id_u=".$dane['autor_id']."\">".$dane['autor_name']."</a></div>";				
				echo "</td>";
				
				echo "<td class=\"tlo3 prawa\">";
				echo $dane['osoby'];
				echo "</td>";				

				echo "</tr>";
				
			}	
			konf::get()->_bazasql->freeResult($zap);		
			
			if($naw->getNaw()){
				echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
			}	
			
		} else {
			echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 srodek grube\" style=\"padding:10px;\">".konf::get()->langTexty("brakdanych")."</td></tr>";
		}
		
		echo tab_stop();

	}
	
	
  /**
   * show one group
   */		
	public function zobacz(){
		
		$typy_tab=konf::get()->getKonfigTab("grupy_konf",'typy_tab');		

		if(!empty($this->_dane)){

			echo tab_nagl("Grupa: ".$this->_dane['nazwa']);			
			echo "<tr><td class=\"tlo3 lewa\">";
						
			$logo=$this->grupyLogo($this->_dane,$numer=1);
			
			if(!empty($logo)){
				echo "<div class=\"srodek\" style=\"padding:5px;\">".$logo."</div>";
			}
						
			echo "<div class=\"nowa_l\"><table border=\"0\" cellspacing=\"1\" cellpadding=\"4\" class=\"dane_tabelka\">";
			
			echo "<tr>";			
			echo "<td class=\"dane_opis\">Kategoria:</td>";			
			echo "<td class=\"dane_wartosc\">";
			if(!empty($typy_tab[$this->_dane['typ']])){
				echo $typy_tab[$this->_dane['typ']];
			}
			echo "</td>";
			echo "</tr>";		
			
			echo "<tr valign=\"top\">";			
			echo "<td class=\"dane_opis\">Opis:</td>";			
			echo "<td class=\"dane_wartosc\">";			
			echo tekstForm::doWys($this->_dane['opis']);			
			echo "</td>";
			echo "</tr>";								
			
			echo "<tr>";			
			echo "<td class=\"dane_opis\">Założyciel:</td>";			
			echo "<td class=\"dane_wartosc\"><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane","id_u"=>$this->_dane['autor_id']))."\">".$this->_dane['autor_name']."</a></td>";
			echo "</tr>";
			
			echo "<tr>";			
			echo "<td class=\"dane_opis\">Ilość członków grupy:</td>";			
			echo "<td class=\"dane_wartosc\">".$this->_dane['osoby']."</td>";
			echo "</tr>";
						
			echo "<tr>";			
			echo "<td class=\"dane_opis\">Ilość wypowiedzi:</td>";			
			echo "<td class=\"dane_wartosc\">".$this->_dane['wypowiedzi']."</td>";
			echo "</tr>";						
			
			if(konf::get()->getKonfigTab("grupy_konf",'zamkniete')){
			
				echo "<tr>";			
				echo "<td class=\"dane_opis\">Typ:</td>";			
				echo "<td class=\"dane_wartosc\">";
				if($this->_dane['zamknieta']){
					echo "Grupa zamknięta dla odwiedzających";
				} else {
					echo "Grupa otwarta dla odwiedzających";				
				}
				echo "</td>";
				echo "</tr>";				
				
			}		
			
			if(konf::get()->getKonfigTab("grupy_konf",'zatwierdzanie')){
			
				echo "<tr>";			
				echo "<td class=\"dane_opis\">Dołączanie:</td>";			
				echo "<td class=\"dane_wartosc\">";
				if($this->_dane['zatwierdzanie']){
					echo "Wymaga akceptacji moderatora";
				} else {
					echo "Nie wymaga akceptacji moderatora";			
				}
				echo "</td>";
				echo "</tr>";				
				
			}					

			echo "<tr>";			
			echo "<td class=\"dane_opis\">Data założenia:</td>";			
			echo "<td class=\"dane_wartosc\">".$this->dataForm($this->_dane['autor_kiedy'],false)."</td>";
			echo "</tr>";					
						
			echo "</table></div>";
			
			echo "</td></tr>";	
			echo tab_stop();	
			
			$this->najCzlonkowie();
			
			$this->najZdjecia();			
		
		} else {
			echo interfejs::nieprawidlowe();			
		}		

	
	}
	
	
	private function najCzlonkowie(){
	
		$ile=4;
						
		echo "<div class=\"nowa_l\" style=\"padding-top:4px;\">";		
		echo tab_nagl("Ostatnio dodani członkowie:",$ile);		
		echo "<tr class=\"srodek\" valign=\"top\">";

		$zap=konf::get()->_bazasql->zap("SELECT u.*, z.data_dodania FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u, ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." z WHERE u.id=z.id_u AND z.id_grupa='".$this->_id."' AND z.status=1 ".user::get()->getSqlAdd("u")." ORDER BY z.data_dodania DESC, z.id DESC LIMIT 0,".$ile);
		
		$i=0;
		
		if(konf::get()->_bazasql->numRows($zap)){
		
			while($dane2=konf::get()->_bazasql->fetchAssoc($zap)){		
			
				echo "<td class=\"tlo3\" style=\"width:25%\">";
				u_wizytowka($dane2,true);
				echo "</td>";		
				
				$i++;	
			
			}
			
			if($i<$ile){
				
				while($i<$ile){
					echo "<td class=\"tlo3\" style=\"width:25%\">&nbsp;</td>";
					$i++;
				}
			
			}
			
			echo "</tr>";
			
			echo "<tr><td class=\"tlo4 srodek\" colspan=\"".$ile."\">";
			echo interfejs::linkEl("group",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_ludzie","id_grupa"=>$this->_id)),"zobacz wszystkich");
			echo "</td></tr>";
			
		} else {
				
			echo "<tr><td class=\"brak\" colspan=\"".$ile."\">Grupa nie posiada członków</td></tr>";
					
		}	
		
		echo tab_stop();					
		echo "</div>";
	
	}
	
	
	public function najZdjecia(){

		$ile=4;		
		$i=0;			
		
		if(konf::get()->isMod("grupygal")){	
		
			$zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_galeria')." WHERE id_matka='".$this->_id."' AND status=1 ORDER BY autor_kiedy DESC, id DESC LIMIT 0,".$ile);		
			
			if(konf::get()->_bazasql->numRows($zap)){		
				
				echo "<div class=\"nowa_l\" style=\"padding-top:4px;\">";				
				echo tab_nagl("Najnowsze fotki w galerii:",$ile);				
				echo "<tr class=\"srodek\" valign=\"top\">";
				
				require_once(konf::get()->getKonfigTab('mod_kat')."grupygal/class.grupygal.php");														
				$grupygal=new grupygal();										
							
				while($dane2=konf::get()->_bazasql->fetchAssoc($zap)){		
				
					echo "<td class=\"tlo3\" style=\"width:25%\">";
										
					echo "<div>";					
					echo $grupygal->fotka($dane2,2,true);
					echo "</div>";
										
					echo "<a href=\"".$grupygal->fotkaLink($dane2)."\">".$dane2['tytul']."</a>";
					
					echo "<div class=\"male\">";
					echo "<div>Data dodania:</div>";
					echo "<div class=\"grube\">".substr($dane2['autor_kiedy'],0,16)."</div>";
					echo "</div>";
				
					
					echo "</td>";		
					
					$i++;	
				
				}
				
				echo "</tr>";
				
				if($i<$ile){
					
					while($i<$ile){
						echo "<td class=\"tlo3\" style=\"width:25%\">&nbsp;</td>";
						$i++;
					}
				
				}
				
				echo "<tr><td class=\"tlo4 srodek\" colspan=\"".$ile."\">";
				echo interfejs::linkEl("picture",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupygal_arch","id_u"=>$this->_id)),"zobacz wszystkie zdjęcia");
				echo "</td></tr>";				

				echo tab_stop();								
				echo "</div>";
				
			}
		
		}
	
	}		
		
  /**
   * add groups
   */		
	public function dodaj(){
	
		$this->formularz();
	
	}
	
	
  /**
   * edit group
   */		
	public function edytuj(){
	
		$this->formularz();
	
	}	

	
  /**
   * group form
   */	
	private function formularz(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');		
		$sortuj=konf::get()->getZmienna('sortuj','sortuj');			
		$typy_tab=konf::get()->getKonfigTab("grupy_konf",'typy_tab');			
		$statusy_tab=konf::get()->getKonfigTab("grupy_konf",'statusy_tab');						
		$link=$this->szukZmienne(1);			
		
		//domyślne wartosci
		$dane=array(
			'nazwa'=>"",
			'typ'=>$this->_szuk['typ'],
			'opis_krotki'=>"",			
			'opis'=>"",			
			'status'=>1,
			'zamknieta'=>0,		
			'zatwierdzanie'=>0,
		);		

		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"grupyf","grupyf");	
		$dane=$form->odczyt($dane);	

		$this->grupaSpr();	
				
		if(!empty($this->_dane)){
			$dane=$this->_dane;		
		}		

		//jesli wszystko ok to wyswietl formularz
		if(konf::get()->getAkcja()=="grupy_dodaj"||!empty($this->_id)){
			
			echo $form->spr(array(1=>"nazwa",2=>"typ",3=>"opis_krotki"),"","");
			$form->setMultipart(true);
			
			if(!empty($this->_id)){
						
	  		echo tab_nagl("Edycja danych grupy",1);
				
			} else {
	  		echo tab_nagl("Tworzenie nowej grupy",1);		
			}
	  
	  	echo "<tr><td valign=\"top\" class=\"tlo3\">";
			
			echo $form->getFormp();
			echo $form->przenies(array("a"=>"a","akcja"=>konf::get()->getAkcja()."2","id_grupa"=>$this->_id));	
			
			echo "<div>";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");						
			echo "</div><br />";					

			echo interfejs::label("typ","typ grupy*","grube");			
			echo "<br />";					
			echo $form->select("typ","typ",$typy_tab,$dane['typ'],"f_bdlugi",konf::get()->langTexty("wybierz"));
			echo "<br /><br />";
			
			echo interfejs::label("nazwa","nazwa*:","grube blok");				
			echo $form->input("text","nazwa","nazwa",$dane['nazwa'],"f_bdlugi",200);
			echo "<br /><br />";

			echo interfejs::label("opis_krotki","opis skrócony*:","grube");		
			echo "<br />";			
			echo $form->input("text","opis_krotki","opis_krotki",$dane['opis_krotki'],"f_bdlugi",250);	
			
			echo "<div class=\"male\">Krótki opis wyświetlany jest na listach grup, zanim użytkownik trafi na stronę główną grupy. ";
			echo "<br />Może składać się maksymalnie z 250 znaków.</div>";	
			echo "<br />";		
			
			echo interfejs::label("opis","opis:","grube");		
			echo "<br />";					
			echo $form->textarea("opis","opis",$dane['opis'],"f_bdlugi",10);					
			echo "<br /><br />";		
			
			if(konf::get()->getKonfigTab("grupy_konf",'img')){							

	  		if(!empty($dane['img'])){
				
					echo interfejs::imgPodglad($dane,"img",konf::get()->getKonfigTab("grupy_konf",'kat'));	
	  			echo "<div>";
					echo $form->checkbox("img_usun","img_usun",1,"");				
					echo interfejs::label("img_usun",konf::get()->langTexty("usung"),"",true);
					echo "</div>"; 
					
	  		}
				
				echo interfejs::label("pic","logo grupy:","grube");																					
				echo "<div>";
				echo $form->input("file","pic","pic","","f_bdlugi");
				echo "</div><br />";		
				
			}
				
			if(konf::get()->getKonfigTab("grupy_konf",'zamkniete')){
				echo interfejs::label("zamknieta","dostęp do grupy mają:","grube");			
				echo "<br class=\"nowa_l\" />";					
				echo $form->select("zamknieta","zamknieta",array(0=>"wszyscy",1=>"tylko członkowie"),$dane['zamknieta'],"f_sredni");		
				echo "<br /><br />";				
			}
			
			if(konf::get()->getKonfigTab("grupy_konf",'zatwierdzanie')){
				echo interfejs::label("zatwierdzanie","członkowstwo w grupie:","grube");			
				echo "<br class=\"nowa_l\" />";					
				echo $form->select("zatwierdzanie","zatwierdzanie",array(0=>"jest otwarte",1=>"potwierdza moderator"),$dane['zatwierdzanie'],"f_sredni");	
				echo "<br /><br />";											
			}			

			if($this->admin()){
				echo interfejs::label("status","status:","grube");			
				echo "<br class=\"nowa_l\" />";					
				echo $form->select("status","status",$statusy_tab,$dane['status'],"f_sredni");
				echo "<br /><br />";						
			} 
			
			echo "<div>";
			echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");						
			echo "</div><br />";
			
			echo "<div class=\"male\">".konf::get()->langTexty("musza")."</div>";
			
			echo $form->getFormk();
			
			echo "</td></tr>";
		
		  echo "<tr class=\"srodek\"><td class=\"tlo4\">".interfejs::linkEl("group",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_user")),"moje grupy")."</td></tr>";
	  	echo tab_stop();
			
		} else { 
			echo interfejs::nieprawidlowe();	
		}		

		
	}
	
	
  /**
   * save new group
   */		
	public function dodaj2(){	
	
		$this->zapisz();	
		
	}	
	
	
  /**
   * save edit group
   */		
	public function edytuj2(){	
	
		$this->zapisz();	
		
	}		
		
		
  /**
   * if group exists
   * @param string $nazwa
   * @param int $typ
   * @param int $id_grupa
	 * @return bool	
   */		
	private function istnieje($nazwa,$typ,$id_grupa=""){
	
		$ok=true;
		
		$sql="nazwa='".$nazwa."' AND typ='".$typ."'";
		if($id_grupa){
			$sql.=" AND id!='".$id_grupa."'";
		}
				
		if(konf::get()->_bazasql->policz('id'," FROM ".konf::get()->getKonfigTab("sql_tab",'grupy')." WHERE ".$sql)>0){
			$ok=false;
		}
		
		return $ok;
		
	}	
	
	
  /**
   * save group data
   */	
	private function zapisz(){
									
		$typy_tab=konf::get()->getKonfigTab("grupy_konf",'typy_tab');			
		$statusy_tab=konf::get()->getKonfigTab("grupy_konf",'statusy_tab');							
		
		//domyślne wartosci
		$dane=array(
			'nazwa'=>"",
			'typ'=>$this->_szuk['typ'],
			'opis_krotki'=>"",			
			'opis'=>"",			
			'zamknieta'=>0,		
			'zatwierdzanie'=>0,
		);	
		
		if($this->admin()){
		
			$dane['status']=1;
			
			$testy[]=array("zmienna"=>"status","test"=>"wtablicyi","wymagany"=>true,
				"param"=>array(
					"wartosci"=>$statusy_tab,
					"domyslny"=>""
				)
			);					
			
		}
				
		$testy[]=array("zmienna"=>"nazwa","test"=>"wartosc","wymagany"=>true,
			"param"=>array(
				"komunikat"=>"Nieprawidłowa nazwa grupy",
				'idtf'=>"nazwa"			
			)	
		);	
		
		$testy[]=array("zmienna"=>"opis_krotki","test"=>"wartosc","wymagany"=>true,
			"param"=>array(
				"komunikat"=>"Nieprawidłowy opis grupy",
				'idtf'=>"opis_krotki"			
			)	
		);	
				
				
		$testy[]=array("zmienna"=>"typ","test"=>"wtablicyi","wymagany"=>true,
			"param"=>array(
				"wartosci"=>$typy_tab,
				"domyslny"=>"",
				"komunikat"=>"Nieprawidłowy typ grupy",
				'idtf'=>"typ"							
			)
		);	
		
		
		if(konf::get()->getKonfigTab("grupy_konf",'zamkniete')){		
			$testy[]=array("zmienna"=>"zamknieta","test"=>"truefalse",
				"param"=>array(
					"wartosc"=>1
				)
			);	
		}	
		
		if(konf::get()->getKonfigTab("grupy_konf",'zatwierdzanie')){		
			$testy[]=array("zmienna"=>"zatwierdzanie","test"=>"truefalse",
				"param"=>array(
					"wartosc"=>1
				)
			);	
		}		
		

		//generator zapytania insert/update
		require_once(konf::get()->getKonfigTab('klasy')."class.sqlzapis.php");
		$sqldane=new sqlZapis(konf::get()->getKonfigTab("sql_tab",'grupy'),$dane);
		$sqldane->daneOdczyt();	
		$sqldane->setAutor(true);	
		$sqldane->setTesty($testy);			

		$sqldane->testuj();	
		
		if($sqldane->ok()){
		
			$this->grupaSpr();		
				
			if(!empty($this->_dane)){
				$dane=$this->_dane;		
			}		

			if($this->istnieje($sqldane->getDane("nazwa"),$sqldane->getDane("typ"),$this->_id)){							
				
				//dodawanie
				if(empty($this->_id)){
				
					if(!$this->admin()){
						if(konf::get()->getKonfigTab("grupy_konf",'adminmoderacja')){				
							$sqldane->setDane(array("status"=>2));
						} else {
							$sqldane->setDane(array("status"=>1));						
						}
						
					}
					
					$sqldane->setDane(array("data_aktywnosci"=>date('Y-m-d H:i:s')));	
				
					//budowanie zapytania
					$sqldane->dodajDaneD();							
					
					//wykonujemy
					if($sqldane->getSql()){
						konf::get()->_bazasql->zap($sqldane->getSql());			
						$id_grupa=konf::get()->_bazasql->insert_id;
					}
					
					//grafika
					if(!empty($id_grupa)){
					 
						$this->setGrupa($id_grupa);
						konf::get()->setZmienna("_post","id_grupa",$id_grupa);						
						$this->dolacz(true);
					
						if(konf::get()->getKonfigTab("grupy_konf",'img')){						
							$grafika=$this->grafikaZapis($dane,$id_grupa);									
							if($grafika->getSql()){
								konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'grupy')." SET ".$grafika->getSql()." WHERE id='".$id_grupa."'");
					 		}
						}
						
					}
					
				//edycja
				} else {

					$sqldane->dodajDaneE();								
					
					if(konf::get()->getKonfigTab("grupy_konf",'img')){						
						$grafika=$this->grafikaZapis($dane,$this->_id);										
						if($grafika->getSql()){
							$sqldane->dodaj(", ".$grafika->getSql());				
						}		
					}
									
					$sqldane->dodaj(" WHERE id='".$this->_id."'".$this->sqlAdd());
					
					if($sqldane->getSql()){
						konf::get()->_bazasql->zap($sqldane->getSql());	
						$this->setGrupa($this->_id);
					}
				
				}

		    //jesli ok
		    if(!empty($this->_id)){   
		    	konf::get()->setKomunikat(konf::get()->langTexty("zapisane"),"");
		    } else { 
					konf::get()->setKomunikat(konf::get()->langTexty("niezapisane"),"error");
				}		
			
			} else { 
				konf::get()->setKomunikat(konf::get()->langTexty("istnieje"),"error"); 
			}
				 		
		} else { 
			konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
		}
		
		if(konf::get()->getAkcja()=="grupy_dodaj2"){
		  if(!empty($this->_id)){
				konf::get()->setAkcja("grupy_kat");				
			} else {
				konf::get()->setAkcja("grupy_dodaj");				
			}
		} else if(konf::get()->getAkcja()=="grupy_edytuj2"){	
			konf::get()->setAkcja("grupy_edytuj");					
		} 
		
	}	
	
	
  /**
   * show leave group form
   */		
	public function rezygnuj(){

		if(!empty($this->_dane)){

			echo tab_nagl("Wypisz się z grupy: ".$this->_dane['nazwa']);

			echo "<tr><td class=\"tlo3\">";

			if($this->jestWgrupie()){	

				echo "<div class=\"grube srodek\">Potwierdź czy na pewno chcesz wypisać się z członkowstwa w grupie?</div>";

				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\" class=\"srodek\"><tr valign=\"middle\">";

				echo "<td>";

				$form=new formularz("post",konf::get()->getKonfigTab("plik"),"grupyw","grupyw");	
				echo $form->getFormp();
				echo $form->przenies(array("akcja"=>"grupy_rezygnuj2","id_grupa"=>$this->_id));
				echo $form->input("submit","","","Tak, rezygnuję","formularz2 f_sredni");
				echo $form->getFormk();

				echo "</td>";

				echo "<td>";

				$form=new formularz("post",konf::get()->getKonfigTab("plik"),"grupyw","grupyw");	
				echo $form->getFormp();
				echo $form->przenies(array("akcja"=>"grupy_zobacz","id_grupa"=>$this->_id));
				echo $form->input("submit","","","Nie","formularz2 f_sredni");
				echo $form->getFormk();

				echo "</td>";

				echo "</tr></table>";

			} else {

				echo "<div class=\"grube srodek\">Nie jesteś zapisany do tej grupy</div>";

			}

			echo "</td></tr>";
			
			echo tab_stop();

		} else {

			echo interfejs::nieprawidlowe();

		}

	}
	
	
  /**
   * leave group
   */		
	public function rezygnuj2(){

		if(!empty($this->_dane)){

			if($this->jestWgrupie()){	
			
				konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." WHERE id_grupa='".$this->_id."' AND id_u='".user::get()->id()."'");
				$this->updateOsoby($this->_id);				
				konf::get()->setKomunikat("Zostałes wypisany z grupy");

			} else {
			
				konf::get()->setKomunikat("Nie jesteś członkiem grupy, ktorą chcesz opuścić","error"); 

			}


		} else {

			konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),"error"); 		

		}


	}
		
	
  /**
   * save img
   * @param array $dane
   * @param int $id_nr
   * @return obj							
   */		
	private function grafikaZapis($dane,$id_nr){

		$img_usun=tekstForm::doSql(konf::get()->getZmienna('img_usun'));		
		require_once(konf::get()->getKonfigTab('klasy')."class.zapiszgrafike.php");
		
		$grafika=new zapiszGrafike($id_nr,konf::get()->getKonfigTab("grupy_konf",'kat'),"pic","img",$dane);
		$grafika->setWszystkie(true);
		$grafika->setImgUsun($img_usun);
		
		$grafika->setDaneImg(1,array(
			"hmax"=>konf::get()->getKonfigTab("grupy_konf",'img1_size'),
			"wmax"=>konf::get()->getKonfigTab("grupy_konf",'img1_size'),
			"hmin"=>konf::get()->getKonfigTab("grupy_konf",'img_min_size'),
			"wmin"=>konf::get()->getKonfigTab("grupy_konf",'img_min_size'),
			"typy"=>array(2=>2),
			"skala"=>konf::get()->getKonfigTab("grupy_konf",'img1_skalatyp')			
		));
		
		$grafika->setDaneImg(2,array(
			"hmax"=>konf::get()->getKonfigTab("grupy_konf",'img2_size'),
			"wmax"=>konf::get()->getKonfigTab("grupy_konf",'img2_size'),
			"hmin"=>konf::get()->getKonfigTab("grupy_konf",'img_min_size'),
			"wmin"=>konf::get()->getKonfigTab("grupy_konf",'img_min_size'),
			"typy"=>array(2=>2),
			"skala"=>konf::get()->getKonfigTab("grupy_konf",'img2_skalatyp')				
		));	
		
		$grafika->setDaneImg(3,array(
			"hmax"=>konf::get()->getKonfigTab("grupy_konf",'img3_size'),
			"wmax"=>konf::get()->getKonfigTab("grupy_konf",'img3_size'),
			"hmin"=>konf::get()->getKonfigTab("grupy_konf",'img_min_size'),
			"wmin"=>konf::get()->getKonfigTab("grupy_konf",'img_min_size'),
			"typy"=>array(2=>2),
			"skala"=>konf::get()->getKonfigTab("grupy_konf",'img3_skalatyp')				
		));		

		$grafika->wykonaj();	
		
		return $grafika;		
	
	}	

	
  /**
   * sign up to group
   * @param boot $auto
   */		
	public function dolacz($auto=false){
			
		if(!empty($this->_dane)){
		
			if($auto){
				$funkcja=2;
				$status=1;
			} else {
				$funkcja=0;
				if(konf::get()->getKonfigTab("grupy_konf",'zatwierdzanie')&&$this->_dane['zatwierdzanie']==1){				
					$status=0;
				} else {
					$status=1;
				}
				
			}
				
			if($auto||!$this->jestWgrupie()){		
											
				if($status==1){
				
					konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." (id_u,id_grupa,data_dodania,ostatnia_wizyta,funkcja,status) VALUES ('".user::get()->id()."','".$this->_id."',NOW(),NOW(),".$funkcja.",".$status.")");
					if(!$auto){							
						konf::get()->setKomunikat("Dołączyłeś do grupy: ".$this->_dane['nazwa'],""); 
					}
					
				} else {
				
					if(!empty($this->_dane['autor_id'])){
						$dane_u=konf::get()->_bazasql->pobierzRekord("SELECT u.* FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u WHERE u.id='".$this->_dane['autor_id']."'".user::get()->getSqlAdd("u"));
					}
										
					//sprawdz czy juz ta wiadomosc nie byla wyslana
					if(!$this->istniejeZgloszenie()){	
					
						konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." (id_u,id_grupa,data_dodania,ostatnia_wizyta,funkcja,status) VALUES ('".user::get()->id()."','".$this->_id."',NOW(),NOW(),".$funkcja.",".$status.")");														
					
						//zapisz w poczcie										
						if(konf::get()->isMod('poczta')){
						
							$tytul="Do Twojej grupy chce dołączyć nowa osoba.";
							
							$tresc="";
							$tresc.="Witaj ".user::get()->nazwa($dane_u)."\n\n";
							$tresc.="<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane","id_u"=>user::get()->id()))."\">".user::get()->nazwa()."</a> chce dołączyć do twojej grupy ".$this->_dane['nazwa']." .\n\n";	
							$tresc.="Zobacz <a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_oczekujacy","id_grupa"=>$this->_id))."\">listę osób oczekujących na akceptację</a> \n";
											
							require_once(konf::get()->getKonfigTab('mod_kat')."poczta/class.poczta.php");														
							$poczta=new poczta();													
							$id_w2=$poczta->zdefiniowana($dane_u,$tytul,$tresc,2);		
							
						}
													
						if(!empty($id_w2)){		
																		
							konf::get()->setKomunikat("Twoje zgłoszenie do grupy ".$this->_dane['nazwa']." zostało przekazane do jej moderatora",""); 	
																					
						}
						
		 			} else {
											
						konf::get()->setKomunikat("Twoje zgłoszenie do grupy było już przesłane","error"); 		
									
					}			
					
				}
					
				$this->updateOsoby($this->_id);
			
			} else {
			
				konf::get()->setKomunikat("Już jesteś członkiem tej grupy","error"); 		
					
			}
		
		} else {
		
			if(!$auto){
			
				konf::get()->setKomunikat(konf::get()->langTexty("nieprawidlowe"),"error"); 
				
			}
			
		}
	
	}	
	
	
  /**
   * remove group form
   */		
	public function usun(){

		$usuwanie=konf::get()->getKonfigTab("grupy_konf",'usuwanie');
		
		if($this->admin()){
			$usuwanie=2;
		}

		$this->grupaSpr();				
	
		if(!empty($this->_dane)&&$usuwanie){

			echo tab_nagl("Usuń grupę: ".$this->_dane['nazwa']);

			echo "<tr><td class=\"tlo3\">";

			echo "<div class=\"grube srodek\">Potwierdź usunięcie grupy</div>";

			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\" class=\"srodek\"><tr valign=\"middle\">";

			echo "<td>";

			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"grupyw","grupyw");	
			echo $form->getFormp();
			echo $form->przenies(array("akcja"=>"grupy_usun2","id_grupa"=>$this->_id));
			echo $form->input("submit","","","Tak, usuwam","formularz2 f_sredni");
			echo $form->getFormk();

			echo "</td>";

			echo "<td>";

			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"grupyw","grupyw");	
			echo $form->getFormp();
			echo $form->przenies(array("akcja"=>"grupy_zobacz","id_grupa"=>$this->_id));
			echo $form->input("submit","","","Nie","formularz2 f_sredni");
			echo $form->getFormk();

			echo "</td>";

			echo "</tr></table>";

			echo "</td></tr>";
			
			echo tab_stop();

		} else {

			echo interfejs::nieprawidlowe();

		}
		
	}
		
	
  /**
   * remove
   */
	public function usun2(){
			
		$usuwanie=konf::get()->getKonfigTab("grupy_konf",'usuwanie');
		
		if($this->admin()){
			$usuwanie=2;
		}		
		
		$this->grupaSpr();		

		if(!empty($this->_dane)&&$usuwanie){		
				
			if($usuwanie==2){
						
				$this->usunImg($this->_dane,konf::get()->getKonfigTab("grupy_konf",'kat'),3,"img");	
				
			  if(konf::get()->isMod('grupygal')){	
						
				  $zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_galeria')." WHERE id_matka='".$this->_id."'");
				  while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
						$this->usunImg($dane,konf::get()->getKonfigTab("grupy_konf",'galeria_kat'),2,"img");						
					}
					konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_galeria')." WHERE id_matka='".$this->_id."'");
					
					if(konf::get()->getKonfigTab("grupy_konf",'galeria_koment')){
						konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_galeria_koment')." WHERE id_matka='".$dane['id']."'");					
					}
					
				}					
										
				konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'grupy')." WHERE id='".$this->_id."'");
				konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." WHERE id_grupa='".$this->_id."'");
				konf::get()->setKomunikat(konf::get()->langTexty("usuwanie"),""); 
				$this->setGrupa("");
				
			} else {
			
				konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'grupy')." SET do_usuniecia=1 WHERE id='".$this->_id."'");
				konf::get()->setKomunikat("Grupa została zgłoszona do usunięcia. Całkowite usunięcie grupy wymaga akceptacji ze strony administratora",""); 			
			
			}
			
		} else {
		
			konf::get()->setKomunikat(konf::get()->langTexty("usuwaniebrak"),"error"); 
					
		}
		
	}		
	
	
	
  /**
   * members list
   */
	public function ludzie(){
			
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');						
		$sortuj=tekstForm::doSql(konf::get()->getZmienna('sortuj','sortuj'));			
		$funkcje_tab=konf::get()->getKonfigTab("grupy_konf",'funkcje_tab');

		if(!empty($this->_dane)){	

			if(konf::get()->getKonfigTab("grupy_konf",'wys_grafika')){
				$colspan=konf::get()->getKonfigTab("grupy_konf",'wys_kolumn');
			} else {
				if($this->_dane['autor_id']==user::get()->id()){		
					$colspan=5;
				} else {
					$colspan=4;
				}
			}

			$tab_sort=array(	
				1=>"u.id",
				2=>"u.id DESC",
				3=>"u.nazwisko,u.imie,u.login", 
				4=>"u.nazwisko DESC, u.imie DESC, u.login DESC", 		
				5=>"u.miejscowosc", 
				6=>"u.miejscowosc DESC", 
				7=>"z.ostatnia_wizyta", 
				8=>"z.ostatnia_wizyta DESC",
				9=>"z.data_dodania", 
				10=>"z.data_dodania DESC", 		
				11=>"z.funkcja,u.nazwisko,u.imie,u.login", 
				12=>"z.funkcja DESC,u.nazwisko DESC, u.imie DESC, u.login DESC", 							
			);	
			
			if(empty($tab_sort[$sortuj])){
				$sortuj=3;
			}
						
			$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>konf::get()->getAkcja(),"id_grupa"=>$this->_id));				
		
			$sql=" FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u, ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." z WHERE u.id=z.id_u AND z.id_grupa='".$this->_id."' AND z.status=1 ".user::get()->getSqlAdd("u");
			$naw = new nawig("SELECT COUNT(u.id) AS ilosc ".$sql,$podstrona,konf::get()->getKonfigTab("grupy_konf",'na_str'));
			$naw->naw($link."&amp;sortuj=".$sortuj);
			$podstrona=$naw->getPodstrona();			
	
			echo tab_nagl("Członkowie grupy ".$this->_dane['nazwa']." (".$naw->getWynikow()."):",$colspan);			

			if($naw->getNaw()){
				echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
			}		

			if(!konf::get()->getKonfigTab("grupy_konf",'wys_grafika')){
			
				echo "<tr class=\"srodek\">";
				echo interfejs::sortEl($link."&amp;sortuj=",3,4,"nazwisko,imię",$sortuj);
				echo interfejs::sortEl($link."&amp;sortuj=",11,12,"funkcja",$sortuj,100);				
				echo interfejs::sortEl($link."&amp;sortuj=",7,8,"aktywność",$sortuj,90);
				echo interfejs::sortEl($link."&amp;sortuj=",9,10,"dodano",$sortuj,90);	
				if($this->_dane['autor_id']==user::get()->id()){						
					echo interfejs::sortEl("","","","&nbsp;","",33);
				}
				echo "</tr>";
			
			}			

			if($naw->getWynikow()>0){				
			
				$zap=konf::get()->_bazasql->zap("SELECT u.*, z.data_dodania, z.ostatnia_wizyta, z.funkcja ".$sql." ORDER BY ".$tab_sort[$sortuj]." LIMIT ".$naw->getStart().",".$naw->getIle());
				
				if(!konf::get()->getKonfigTab("grupy_konf",'wys_grafika')){			
				
					while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
					
						echo "<tr valign=\"middle\" class=\"lewa\">";

						echo "<td class=\"tlo3\">";	
						
						echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr valign=\"middle\">";
						
						$fotka=user::get()->obrazek($dane,"",3,"",true);	
													
						if($fotka){					
							echo "<td style=\"padding-right:5px;\">";
			   			echo $fotka;
							echo "</td>";
			  	  }											

						echo "<td>";														
						echo "<a class=\"grube\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane",'id_u'=>$dane['id']))."\">";
						echo user::get()->nazwa($dane);
						echo "</a>";				
						
						echo "</td></tr></table>";
									
						echo "</td>";
						
						echo "<td class=\"tlo3 srodek\">";						
						if(!empty($funkcje_tab[$dane['funkcja']])){
							echo $funkcje_tab[$dane['funkcja']];
						}
						echo "</td>";	
						
						echo "<td class=\"tlo3 srodek male\">";												
						$dane['ostatnia_wizyta']=substr($dane['ostatnia_wizyta'],0,16);
						echo str_replace(" ","<br />",$dane['ostatnia_wizyta']);				
						echo "</td>";									
																								
						echo "<td class=\"tlo3 srodek male\">";												
						$dane['data_dodania']=substr($dane['data_dodania'],0,16);
						echo str_replace(" ","<br />",$dane['data_dodania']);				
						echo "</td>";				

						if($this->_dane['autor_id']==user::get()->id()){						
							echo "<td class=\"tlo3 srodek\">";							
							echo "<table border=\"0\"><tr valign=\"top\" class=\"srodek\">"; 					
							if($this->_dane['autor_id']==user::get()->id()){							
								echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_usunu","id_u"=>$dane['id'],"id_grupa"=>$this->_id)),"usuń z listy członków grupy");
							}
							echo "</tr></table>";							
							echo "</td>";							
						}
											
						echo "</tr>";
		
					}								
				
				} else {				
					
					$i=0;							
					
					while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
					
						if($i==0){
							echo "<tr valign=\"top\" class=\"srodek\">";
						}
						
						$i++;
						
						echo "<td class=\"tlo3\" style=\"width:25%\">";
						u_wizytowka($dane,true,($this->_dane['autor_id']==user::get()->id()));						
						echo "<div>";
						echo "<table class=\"srodek\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr>"; 	
						if($this->_dane['autor_id']==user::get()->id()||$this->admin()){										
							echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_usunu",'id_grupa'=>$id_grupa,"id_u"=>$dane['id']))); 
						}
						echo "</tr></table>";						
						echo "</div>";							
					
						echo "</td>";
						
						if($i==$colspan){
							$i=0;
							echo "</tr>";
						}
									
					}
									
					if($i>0){
						while($i<$colspan){
							$i++;
							echo "<td class=\"tlo3\" style=\"width:25%\">&nbsp;</td>";
						}
						echo "</tr>";
					}	
					
				}		
									
				konf::get()->_bazasql->freeResult($zap);
				
				if($naw->getNaw()){
					echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
				}				
							
			} else { 
	 			echo interfejs::brak($colspan);
			}
			
			if($this->_dane['autor_id']==user::get()->id()){		
		  	echo "<tr class=\"srodek\"><td class=\"tlo4\" colspan=\"".$colspan."\">".interfejs::linkEl("group",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_oczekujacy","id_grupa"=>$this->_id)),"zobacz listę zgłoszeń do grupy")."</td></tr>";
			}
			
			echo tab_stop();				
			
		} else{
			echo interfejs::nieprawidlowe();		
		}

		
	}			
	

  /**
   * new members list
   */
	public function oczekujacy(){
			
		$podstrona=konf::get()->getZmienna('podstrona','podstrona');						
		$sortuj=tekstForm::doSql(konf::get()->getZmienna('sortuj','sortuj'));			
		
		$this->grupaSpr();	

		if(!empty($this->_dane)){	
		
			if(konf::get()->getKonfigTab("grupy_konf",'wys_grafika')){
				$colspan=konf::get()->getKonfigTab("grupy_konf",'wys_kolumn');
			} else {
				$colspan=3;
			}

			$tab_sort=array(	
				1=>"u.id",
				2=>"u.id DESC",
				3=>"u.nazwisko,u.imie,u.login", 
				4=>"u.nazwisko DESC, u.imie DESC, u.login DESC", 		
				5=>"u.miejscowosc", 
				6=>"u.miejscowosc DESC", 
				9=>"z.data_dodania", 
				10=>"z.data_dodania DESC", 							
			);	
			
			if(empty($tab_sort[$sortuj])){
				$sortuj=3;
			}
						
			$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>konf::get()->getAkcja(),"id_grupa"=>$this->_id));				
		
			$sql=" FROM ".konf::get()->getKonfigTab("sql_tab",'uzytkownicy')." u, ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." z WHERE u.id=z.id_u AND z.id_grupa='".$this->_id."' AND z. status=0 ".user::get()->getSqlAdd("u");
			$naw = new nawig("SELECT COUNT(u.id) AS ilosc ".$sql,$podstrona,konf::get()->getKonfigTab("grupy_konf",'na_str'));
			$naw->naw($link."&amp;sortuj=".$sortuj);
			$podstrona=$naw->getPodstrona();			
	
			echo tab_nagl("Oosby oczekujące na akceptację członkowską grupy ".$this->_dane['nazwa']." (".$naw->getWynikow()."):",$colspan);			

			if($naw->getNaw()){
				echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
			}		

			if(!konf::get()->getKonfigTab("grupy_konf",'wys_grafika')){
			
				echo "<tr class=\"srodek\">";
				echo interfejs::sortEl($link."&amp;sortuj=",3,4,"nazwisko,imię",$sortuj);		
				echo interfejs::sortEl($link."&amp;sortuj=",9,10,"data dodania",$sortuj,120);						
				echo interfejs::sortEl("","","","&nbsp;","",66);
				echo "</tr>";
			
			}			

			if($naw->getWynikow()>0){				
			
				$zap=konf::get()->_bazasql->zap("SELECT u.*, z.data_dodania, z.id AS id_z ".$sql." ORDER BY ".$tab_sort[$sortuj]." LIMIT ".$naw->getStart().",".$naw->getIle());
				
				if(!konf::get()->getKonfigTab("grupy_konf",'wys_grafika')){			
				
					while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
					
						echo "<tr valign=\"middle\" class=\"lewa\">";

						echo "<td class=\"tlo3\">";	
						
						echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr valign=\"middle\">";
						
						$fotka=user::get()->obrazek($dane,"",3,"",true);	
													
						if($fotka){					
							echo "<td style=\"padding-right:5px;\">";
			   			echo $fotka;
							echo "</td>";
			  	  }											

						echo "<td>";														
						echo "<a class=\"grube\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_dane",'id_u'=>$dane['id']))."\">";
						echo user::get()->nazwa($dane);
						echo "</a>";				
						
						echo "</td></tr></table>";
									
						echo "</td>";

									
						echo "<td class=\"tlo3 srodek male\">";												
						$dane['data_dodania']=substr($dane['data_dodania'],0,16);
						echo str_replace(" ","<br />",$dane['data_dodania']);				
						echo "</td>";				
					
						echo "<td class=\"tlo3 srodek\">";							
						echo "<table border=\"0\"><tr valign=\"top\" class=\"srodek\">"; 		
						echo interfejs::przyciskEl("accept",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_akceptuju","id_u"=>$dane['id'],"id_grupa"=>$this->_id,"id_z"=>$dane['id_z'])),"akceptuj zgłoszenie");
						echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_usunz","id_u"=>$dane['id'],"id_grupa"=>$this->_id)),"usuń zgłoszenie");
						echo "</tr></table>";							
						echo "</td>";							

											
						echo "</tr>";
		
					}								
				
				} else {				
					
					$i=0;							
					
					while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
					
						if($i==0){
							echo "<tr valign=\"top\" class=\"srodek\">";
						}
						
						$i++;
						
						echo "<td class=\"tlo3\" style=\"width:25%\">";
						u_wizytowka($dane,true,($this->_dane['autor_id']==user::get()->id()));						
						echo "<div>";
						echo "<table border=\"0\"><tr valign=\"top\" class=\"srodek\">"; 		
						echo interfejs::przyciskEl("accept",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_akceptuju","id_u"=>$dane['id'],"id_grupa"=>$this->_id,"id_z"=>$dane['id_z'])),"akceptuj zgłoszenie");
						echo interfejs::usun(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_usunz","id_u"=>$dane['id'],"id_grupa"=>$this->_id)),"usuń zgłoszenie");
						echo "</tr></table>";					
						echo "</div>";							
					
						echo "</td>";
						
						if($i==$colspan){
							$i=0;
							echo "</tr>";
						}
									
					}
									
					if($i>0){
						while($i<$colspan){
							$i++;
							echo "<td class=\"tlo3\" style=\"width:25%\">&nbsp;</td>";
						}
						echo "</tr>";
					}	
					
				}		
									
				konf::get()->_bazasql->freeResult($zap);
				
				if($naw->getNaw()){
					echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
				}				
							
			} else { 
	 			echo interfejs::brak($colspan);
			}
					
		  echo "<tr class=\"srodek\"><td class=\"tlo4\" colspan=\"".$colspan."\">".interfejs::linkEl("group",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"grupy_ludzie","id_grupa"=>$this->_id)),"zobacz listę członków grupy")."</td></tr>";
			
			echo tab_stop();				
			
		} else {
			echo interfejs::nieprawidlowe();		
		}
		
	}	
		
		
	
  /**
   * lremove from group  - only admin or owner of group
   */		
	public function usunu(){
	
		$id_u=tekstForm::doSql(konf::get()->getZmienna('id_u','id_u'));			
		$this->grupaSpr();	

		if(!empty($this->_dane)&&!empty($id_u)){

			if($this->jestWgrupie($id_u)){	
			
				konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." WHERE id_grupa='".$this->_id."' AND id_u='".$id_u."' AND status=1");
				$this->updateOsoby($this->_id);				
				konf::get()->setKomunikat("Użytkownik został usunięty z grupy");

			} else {			
				konf::get()->setKomunikat("Użytkownik nie jest członkiem grupy","error"); 
			}

		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),"error"); 		
		}

	}		
	
	
  /**
   * remove invitation - only admin or owner of group
   */		
	public function usunz(){	

		$id_u=tekstForm::doSql(konf::get()->getZmienna('id_u','id_u'));		
		$this->grupaSpr();			
		
		if(!empty($this->_dane)&&!empty($id_u)){

			konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." WHERE id_grupa='".$this->_id."' AND id_u='".$id_u."' AND status=0");			
			konf::get()->setKomunikat("Zgłoszenie do grupy zostało usunięte");

		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),"error"); 		
		}

	}		
	
	
  /**
   * accept invitation - only admin or owner of group
   */		
	public function akceptuju(){
	
		$id_u=tekstForm::doSql(konf::get()->getZmienna('id_u','id_u'));			
		$id_z=tekstForm::doSql(konf::get()->getZmienna('id_z','id_z'));				
		$this->grupaSpr();	

		if(!empty($this->_dane)&&!empty($id_u)&&!empty($id_z)){

			if(!$this->jestWgrupie($id_u)){	
			
				konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." SET status=1 WHERE id_grupa='".$this->_id."' AND id_u='".$id_u."'AND id='".$id_z."' AND status=0");
				konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'grupy_uzytkownicy')." WHERE id_grupa='".$this->_id."' AND id_u='".$id_u."' AND status=0");	
				$this->updateOsoby($this->_id);				
				konf::get()->setKomunikat("Użytkownik został przyjęty do grupy");

			} else {			
				konf::get()->setKomunikat("Użytkownik jest już członkiem grupy","error"); 
			}

		} else {
			konf::get()->setKomunikat(konf::get()->langTexty("brakdanych"),"error"); 		
		}

	}			


	/**
   * class constructor
   */	
	public function __construct() {	
	
		$this->_admin=konf::get()->getKonfigTab("grupy_konf",'admin');		
		$id_grupa=tekstForm::doSql(konf::get()->getZmienna('id_grupa','id_grupa'));		
		
		if(!empty($id_grupa)){			
			$this->setGrupa($id_grupa);
		}	

  }	

	
}	

?>