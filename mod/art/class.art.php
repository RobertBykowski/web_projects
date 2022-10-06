<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

include_once(konf::get()->getKonfigTab('mod_kat')."art/konfig_inc.php");

class art extends modul  {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */
  protected $_nazwaKlasy="art class";

	/**
	 * id art
	 */
  private $_artId="";

	/**
	 * uprawniony
	 */
  private $_uprawiony="";

  /**
   * admin
   */
	public function uprawniony(){

		return $this->_uprawniony;

	}

  /**
   * akapit write
   * @param array $dane
   * @param array $dane2
   * @param array $galeria
   * @param array $przenies
   */
	public function akapit($dane,$dane2,$galeria="",$przenies=array()){

		if(!empty($dane2['tytul'])){
			$dane2['tresc']="<h2>".$dane2['tytul']."</h2>".$dane2['tresc'];
		}

		$akapit=new akapitForm($dane2['tresc'],$dane['typ']);

		if($dane2['img2_nazwa']){
			$akapit->setImgNazwa(konf::get()->getKonfigTab("art_konf",'akapity_kat').$dane2['img2_nazwa']);
			$akapit->setImgW($dane2['img2_w']);
			$akapit->setImgH($dane2['img2_h']);
			$akapit->setImgLink($dane2['img_link']);
			$akapit->setImgLinkOkno($dane2['img_link_okno']);
			$akapit->setImgOpis($dane2['img_opis']);
			$akapit->setImgAlign($dane2['img_align']);
			$akapit->setImgClass("obrazek");
		}

		if($dane2['img1_nazwa']){
			$akapit->setImgNazwaB(konf::get()->getKonfigTab("art_konf",'akapity_kat').$dane2['img1_nazwa']);
			$akapit->setImgWB($dane2['img1_w']);
			$akapit->setImgHB($dane2['img1_h']);
		}

		$akapit->setDane($dane2);
		$akapit->setAkapitClass("nowa_l");
		$akapit->setAutolink(konf::get()->getKonfigTab("art_konf",'autolink'));

		echo $akapit->zwrot();

		if(!empty($galeria)){

			$galeria_typy=konf::get()->getKonfigTab("art_konf",'galeria_typy');
			if(empty($dane2['galeria_typ'])||empty($galeria_typy[$dane2['galeria_typ']])){
				$dane2['galeria_typ']=konf::get()->getKonfigTab("art_konf",'galeria_typ_domyslny');
			}

			$galeria=new galeria(konf::get()->getKonfigTab("art_konf",'galeria_kat'),$dane2['galeria_typ'],$galeria);

			if($dane2['galeria_typ']==2){
				$przenies['akcja2']="art_projektor";
			}

			$galeria->setPrzenies($przenies);

			if(empty($dane2['galeria_kolumna'])||$dane2['galeria_kolumna']>10){
				$dane2['galeria_kolumna']=konf::get()->getKonfigTab("art_konf",'galeria_kolumna');
			}

			$galeria->setKolumna($dane2['galeria_kolumna']);
			$galeria->setWiersz($dane2['galeria_wiersz']);
			$galeria->setImageKlasa("galeria1");
			$galeria->setPodstronaNazwa("galeria_podstrona".$dane2['id']);
			$galeria->setTytul($dane2['tytul']);
			$galeria->setKotwica("artgal".$dane2['id']);
			$galeria->setZalezne($dane2['galeria_zalezne']);
			$galeria->setProjektor(konf::get()->getKonfigTab("art_konf",'galeria_projektor_w'),konf::get()->getKonfigTab("art_konf",'galeria_projektor_h'));

			if(konf::get()->getKonfigTab("art_konf",'galeria_wys_tytul')){
				$galeria->setTytulyZdjec('tytul');
				$galeria->setOpisyZdjec('opis');
			}

			$galeria->wyswietl();

		}

	}

  /**
   * sql addition
   * @return string
   */
	public function sqlAdd(){

		$sql="";
		if(!$this->admin()){
			$sql.=" AND status=1";
	    $sql.=" AND (data_start<=NOW() OR data_start='0000-00-00 00:00:00')";
	    $sql.=" AND (data_stop>=NOW() OR data_stop='0000-00-00 00:00:00')";
		}

		return $sql;

	}

  /**
   * tworzy link do artykulu
   * @param array $dane
   * @param zmienne $array
   * @param int $podstrona
   * @param bool $href
   * @return string
   */
	public function artLink($dane,$zmienne=array(),$podstrona="",$href=true){

		$link="";

		if(!empty($dane['link'])){
			$link.=$dane['link'];
		} else if(konf::get()->getKonfigTab('mod_rewrite')){

			$link.=konf::get()->getKonfigTab("sciezka");
			if(!empty($dane['idtf_link'])){
				$link.=$dane['idtf_link'].",";
			} else if(konf::get()->getKonfigTab("art_konf",'link_tytul')){
				if(tekstForm::podstawowy($dane['tytul'])){
					$link.=tekstForm::podstawowy($dane['tytul'],"",true).",";
				}
			}
			$link.=$dane['id'].",";
			if(!empty($podstrona)&&$podstrona>1){
				$link.="s".$podstrona.",";
			}
			$link.="l".konf::get()->getLang().".html";

		} else {
			$link.=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik")."?id_art=".$dane['id'],$zmienne);
		}

		if($href){
			$link="href=\"".$link."\"";
			if(!empty($dane['link_okno'])){
				$link.=" target=\"".$dane['link_okno']."\"";
			}
		}

		return $link;

	}


  /**
   * pobiera art
   * @param int $id_art
   * @param bool $lang
   * @param bool $dostep
   * @param bool $rss
   * @param bool $glowny
   * @return array
   */
	public function pobierz($id_art,$lang=true,$dostep=false,$rss=false,$glowny=false){

		$dane="";

		if(!empty($id_art)||$glowny){
	    $sql="SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE ";
			if($id_art){
				$sql.=" id='".$id_art."' ";
			} else {
				$sql.=" glowny=1 ";
			}
	    if($lang||$glowny){
	      $sql.=" AND lang='".konf::get()->getLang()."'";
	    }

			$sql.=$this->sqlAdd();

			if(!$this->admin()&&!$dostep){
				$sql.=" AND dostep!=3";
			}
			if($rss){
				$sql.=" AND rss=1 ";
			}
			$dane=konf::get()->_bazasql->pobierzRekord($sql);
		}

		return $dane;

	}


  /**
   * pobiera arts
   * @param int $id_art
   * @param bool $dostep
   * @param int $limit
   * @param int $id_d
   * @return array
   */
	public function pobierzLista($id_art,$dostep=false,$limit="",$id_d=""){

		$dane=array();
		$id_art=$id_art+0;

		if(!empty($id_art)||$id_d){
	    $sql="SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE ";
			$sql.=" id_matka='".$id_art."' ";
			if(!empty($id_d)){
			$sql.=" AND id_d='".$id_d."' ";
			}
	    $sql.=" AND lang='".konf::get()->getLang()."'";
			$sql.=$this->sqlAdd();

			if(!$this->admin()&&!$dostep){
				$sql.=" AND dostep!=3";
			}

			$sql.=" ORDER BY nr_poz, id";

			$limit=$limit+0;
			if($limit){
				$sql.=" LIMIT 0,".$limit;
			}
			$dane=konf::get()->_bazasql->pobierzRekordy($sql,"id");

		}

		return $dane;

	}

  /**
   * pobiera art idtf
   * @param string $art_idtf
   * @param bool $lang
   * @param bool $dostep
   * @param bool rss
   * @return array
   */
	public function pobierzIdtf($art_idtf,$lang=true,$dostep=false,$rss=false){

		$dane="";

		if(!empty($art_idtf)){

	    $sql="SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE idtf='".tekstForm::doSql($art_idtf)."' ";
	    if($lang){
	      $sql.=" AND lang='".konf::get()->getLang()."'";
	    }
			$sql.=$this->sqlAdd();

			if(!$this->admin()&&!$dostep){
				$sql.=" AND dostep!=3";
			}

			if($rss){
				$sql.=" AND rss=1 ";
			}

			$dane=konf::get()->_bazasql->pobierzRekord($sql);
		}

		return $dane;

	}


  /**
   * okresla dostep do artykulu
   * @param int $typ
   * @return bool
   */
	public function dostep($typ=0){

		$dostep=true;

		if(!$this->admin()){

			switch($typ){

				case '1':
					if(!user::get()->zalogowany()){
						$dostep=false;
					}
				break;

				case '2':
					if(!$this->uprawniony()){
						$dostep=false;
					}
				break;

			}

		}

		return $dostep;

	}


  /**
   * wysyla znajomemu
   */
	public function wyslij2(){

		$ok=true;

		if(!empty($this->_artId)&&konf::get()->getKonfigTab("art_konf",'wys_wyslij')){

			$this->_artId=tekstForm::doSql($this->_artId);

			$podpis=strip_tags(konf::get()->getZmienna("podpis"));
			$email=tekstForm::male(strip_tags(konf::get()->getZmienna("email")));
			$tresc=substr(strip_tags(konf::get()->getZmienna("tresc")),0,150);

			//sprawdzamy artykul
		  $dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id='".$this->_artId."' AND dostep!=3 AND link='' ".$this->sqlAdd());
			if(empty($dane)){
				$ok=false;
			}

			//jesli ok
			if($ok){

				if(konf::get()->getKonfigTab("art_konf",'wyslij_odb')){
					for($i=1;$i<=konf::get()->getKonfigTab("art_konf",'wyslij_odb');$i++){
						$odb_tab[]=strip_tags(konf::get()->getZmienna("email_odb_".$i));
					}
				}

				if(!empty($odb_tab)&&!empty($podpis)&&!empty($email)&&preg_match("/".tekstForm::getEmailForma()."/",$email)){

					$tresc_email=konf::get()->langTexty("art_polec_t_polecam")."\n";
					$tresc_email.=$dane['tytul']." \n";
					$tresc_email.=konf::get()->getKonfigTab("sciezka").konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_art"=>$this->_artId));

					$tresc_email.=" \n\n";

					if(!empty($tresc)){
						$tresc_email.=$tresc."\n\n";
					}

					$tresc_email.=konf::get()->langTexty("art_polec_t_osoba")." ".$podpis." (".$email.")\n";

					reset($odb_tab);

					require_once(konf::get()->getKonfigTab('klasy')."class.wyslijemail.php");

					$ok=false;

					while(list($key,$val)=each($odb_tab)){

						if(!empty($val)&&preg_match("/".tekstForm::getEmailForma()."/",$val)){

							$ok=true;

							$wyslij=new wyslijemail(konf::get()->langTexty("art_polec_t"),$tresc_email,$val);
							$wyslij->setNadawca(konf::get()->getKonfigTab('kontakt_email'),konf::get()->getKonfigTab('kontakt_nadawca'));
							$wyslij->wykonaj();

						}

					}

					if($ok){
						konf::get()->setKomunikat(konf::get()->langTexty("art_polec_t_wys")."<br /> <a href=\"javascript:window.close();\">".konf::get()->langTexty("art_polec_t_zamknij")."</a>");
					}

				} else {
					$ok=false;
				}

			}

			if(!$ok){
				konf::get()->setKomunikat(konf::get()->langTexty("art_polec_blad"),"error");
			}

		}

	}


  /**
   * form wyslij znajomemu
   */
	public function wyslij3(){

	}


  /**
   * form wyslij znajomemu
   */
	public function wyslij(){


		if(!empty($this->_artId)&&konf::get()->getKonfigTab("art_konf",'wys_wyslij')){

			$ok=true;

			//sprawdzamy artykul
		  $dane=$this->pobierz($this->_artId);
			if(empty($dane)){
				$ok=false;
			}

			//jesli ok
			if($ok){

				echo tab_nagl(konf::get()->langTexty("art_polec_tyt"));

				echo "<tr><td class=\"lewa tlo3\">";

				?><script type="text/javascript">

				function spr_artwys(){

				<?php
				if(konf::get()->getKonfigTab("art_konf",'wyslij_odb')){
					echo " if(";
					for($i=1;$i<=konf::get()->getKonfigTab("art_konf",'wyslij_odb');$i++){
						if($i>1){
							echo "&&";
						}
						echo "document.polec.email_odb_".$i.".value == ''";
					}
					echo "){";
					echo " form_set_error('email_odb_1','".htmlspecialchars(konf::get()->langTexty("art_polec_brakadr"))."');\n";
					echo "}\n";
				}
				?>
				}
				</script><?php

				$form=new formularz("post",konf::get()->getKonfigTab("plik"),"polec","polec");
				echo $form->spr(array(1=>"podpis",2=>"email"),"","spr_artwys();");
				echo $form->getFormp();
				echo $form->przenies(array("akcja"=>"art_wyslij2","id_art"=>$this->_artId));

				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"4\">";

				echo "<tr>";
				echo "<td class=\"lewa\" colspan=\"2\">".konf::get()->langTexty("art_polec_polecam")."<br />";
				echo "<div class=\"grube\">".$dane['tytul']."</div>";
				echo konf::get()->getKonfigTab("sciezka").konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_art"=>$this->_artId));
				echo "<br /><br /></td></tr>";

				echo "<tr>";
				echo "<td class=\"prawa\">".konf::get()->langTexty("art_polec_podpis")."</td>";
				echo "<td class=\"lewa\">";
				echo $form->input("text","podpis","podpis",user::get()->login(),"f_dlugi",40);
				echo "</td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td class=\"prawa\">".konf::get()->langTexty("art_polec_email")."</td>";
				echo "<td class=\"lewa\">";
				echo $form->input("text","email","email",user::get()->email(),"f_dlugi",60);
				echo "</td>";
				echo "</tr>";

				if(konf::get()->getKonfigTab("art_konf",'wyslij_odb')){
					for($i=1;$i<=konf::get()->getKonfigTab("art_konf",'wyslij_odb');$i++){
						echo "<tr>";
						echo "<td class=\"prawa\">".konf::get()->langTexty("art_polec_emailodb")." ".$i.":</td>";
						echo "<td class=\"lewa\">";
						echo $form->input("text","email_odb_".$i,"email_odb_".$i,"","f_dlugi",60);
						echo "</td>";
						echo "</tr>";
					}
				}

				echo "<tr><td></td><td>";
				echo "<br />".konf::get()->langTexty("art_polec_komentarz")."<br />";
				echo $form->textarea("tresc","tresc","","f_dlugi",5);
				echo "</td>";
				echo "</tr>";

				echo "<tr><td colspan=\"2\">";
				echo $form->skrocTxt("tresc",150);
				echo "</td>";
				echo "</tr>";

				echo "<tr>";
				echo "<td></td>";
				echo "<td class=\"lewa\">";
				echo $form->input("submit","","",konf::get()->langTexty("art_polec_wyslij"),"formularz2 f_krotki");
				echo "</td>";
				echo "</tr>";

				echo "</table>";

				echo $form->getFormk();

				echo "</td></tr>";
				echo tab_stop();

			}
		}
	}


  /**
   * sciezka do art
   */
	public function sciezka(){

		$link="";

		if(konf::get()->getAkcja()!="art_zobacz") {
			konf::get()->setAkcja("");
		}

		if(!empty($this->_artId)){
			$id=$this->_artId;
			while($id!=0){
				$dane=$this->pobierz($id,true,true);
				if(!empty($dane)){
          if(empty($dane['menu_nie']) && empty($dane['mapa_nie']))
          {
					$link=" &raquo; <a ".$this->artLink($dane).">".$dane['tytul']."</a>".$link;
					}
					$id=$dane['id_matka'];
				} else {
					break;
				}
			}
		}

		if(!empty($link)){
			echo "<div class=\"nowa_l lewa\" style=\"padding-bottom:5px; padding-left: 15px; text-transform: uppercase; padding-top:4px\">";
			echo "<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array())."\">&raquo;&nbsp;STRONA GŁÓWNA</a>";
			echo $link;
			echo "</div>";
		}
	}



  /**
   * lista art
   * @param array $dane
   */
	public function podstron($dane){

		if($dane['typ']==2){

			$this->listanews($dane);

		} else if($dane['submenu']!=2){

			if($dane['submenu']==1){
				$dane2=$this->pobierzLista($dane['id_matka']);
			} else {
				$dane2=$this->pobierzLista($dane['id']);
			}

		  if(!empty($dane2)){

				switch($dane['submenu_wyglad']){

					//table buttons
					case 2:

						$wiersz=4;
						$i=0;

						echo "<table class=\"submenu\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
					  while(list($key,$val)=each($dane2)){
							if($i==0){

								echo "<tr>";

							}
				  	  echo "<td><a class=\"grube\" ".$this->artLink($val).">".$val['tytul']."</a></td>";
							$i++;

							if($i==$wiersz){
								echo "</tr>";
								$i=0;
							}

					  }

						if($i>0){
							while($i<$wiersz){
								echo "<td>&nbsp;</td>";
								$i++;
							}
							echo "</tr>";
						}
						echo "</table>";

					break;

					//table of images
					case 3:

						$wiersz=3;
						$i=0;

						echo "<table class=\"submenu3\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
					  while(list($key,$val)=each($dane2)){
							if($i==0){

								echo "<tr valign=\"top\">";

							}
				  	  echo "<td>";

							if(!empty($val['img2_nazwa'])){
								echo "<div><a class=\"grube\" ".$this->artLink($val)."><img src=\"".konf::get()->getKonfigTab('sciezka').konf::get()->getKonfigTab("art_konf",'art_kat').$val['img2_nazwa']."\" alt=\"".htmlspecialchars($val['tytul'])."\" /></a></div>";
							}
							echo "<a class=\"grube\" ".$this->artLink($val).">";
							echo $val['tytul'];
							echo "</a>";

							echo "</td>";
							$i++;

							if($i==$wiersz){
								echo "</tr>";
								$i=0;
							}

					  }

						if($i>0){
							while($i<$wiersz){
								echo "<td>&nbsp;</td>";
								$i++;
							}
							echo "</tr>";
						}
						echo "</table>";

					break;


					//table of title + images + descrption
					case 4:

						echo "<table class=\"submenu4\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";

					  while(list($key,$val)=each($dane2)){

							echo "<tr valign=\"top\">";

							if(!empty($val['img2_nazwa'])){
								echo "<td class=\"td1\"><a class=\"grube\" ".$this->artLink($val)."><img src=\"".konf::get()->getKonfigTab('sciezka').konf::get()->getKonfigTab("art_konf",'art_kat').$val['img2_nazwa']."\" alt=\"".htmlspecialchars($val['tytul'])."\" /></a></td>";
							}

							echo "<td ";
							if(empty($val['img2_nazwa'])){
								echo " colspan=\"2\"";
							}
							echo ">";

							echo "<div><a class=\"grube\" ".$this->artLink($val).">";
							echo $val['tytul'];
							echo "</a></div>";

							if(!empty($val['zajawka'])){
								echo $val['zajawka'];
							}

							echo "</td>";

							echo "</tr>";

					  }

						echo "</table>";

					break;

					//default list
					default:

				  	echo "<ul class=\"submenu\">";
					  while(list($key,$val)=each($dane2)){
				  	  echo "<li>";

							echo "<div><a ".$this->artLink($val).">".$val['tytul']."</a></div>";
							if(!empty($val['zajawka'])){
								echo $val['zajawka'];
							}

							echo "</li>";
					  }
					  echo "</ul>";

				}


			}
		}

	}



  /**
   * view news list
   * @param array $dane
   */
	public function listanews($dane){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');

	  //czy jest struktura
	 	if(!empty($dane)){

	    //pobierz newsy
	  	$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id_matka='".$dane['id']."'".$this->sqlAdd();

			$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>konf::get()->getAkcja(),"id_art"=>$dane['id']));

	  	if(!empty($dane['na_str'])){
				$naw = new nawig("SELECT COUNT(id) AS ilosc ".$query,$podstrona,$dane['na_str']);
				$naw->naw($link);
				$podstrona=$naw->getPodstrona();
	  	}

	  	$query.=" ORDER BY ".konf::get()->getKonfigTab("art_konf",'news_order');

	  	if(!empty($dane['na_str'])){
	    	$query.=" LIMIT ".$naw->getStart().",".$naw->getIle();
	 		}

	    if($this->admin()&&konf::get()->getKonfigTab("art_konf",'adminpodglad')){

				$form=new formularz("post",konf::get()->getKonfigTab("plik"),"news".$dane['id'],"news".$dane['id']);
				echo $form->getFormp();
				echo $form->przenies(array("akcja"=>"artadmin_edytuj","id_d"=>$dane['id_d'],));
				echo $form->input("hidden","id_art","id_art","");

				?><script type="text/javascript">
				function wyb_artn(id){
					document.news<?php echo $dane['id']; ?>.id_art.value=id;
					document.news<?php echo $dane['id']; ?>.submit();
				}
				</script><?php

			}

	  	$zap=konf::get()->_bazasql->zap("SELECT * ".$query);

			//czy newsy
			if(konf::get()->_bazasql->numRows($zap)>0){

	    	if(!empty($dane['na_str'])){
					if($naw->getNaw()){
						echo "<div class=\"nowa_l\" style=\"padding:5px\">".$naw->getNaw()."</div>";
					}
	    	}

				require_once(konf::get()->getKonfigTab('klasy')."class.akapitform.php");

				//przelatujemy newsy
				while($dane2=konf::get()->_bazasql->fetchAssoc($zap)){

					//tytul
	      	echo "<div style=\"padding:3px\" class=\"nowa_l tlo4 grube\">";

			    if($this->admin()&&konf::get()->getKonfigTab("art_konf",'adminpodglad')){
						echo $form->radio("id_nr","",$dane2['id'],"",""," onclick=\"wyb_artn(".$dane2['id'].");\"");
	      	}

	      	if(konf::get()->getKonfigTab("art_konf",'data_wys')&&tekstForm::niepuste($dane2['data_wys'])){
	          echo "<span class=\"datownik\">";
		        echo substr($dane2['data_wys'],0,konf::get()->getKonfigTab("art_konf",'data_wys_dl'));
	      	  echo " </span>";
		      }

					echo "<a ".$this->artLink($dane2).">";
	      	echo $dane2['tytul'];
	        echo "</a>";
	      	echo "</div>";

					//zajawka
			  	echo "<div style=\"padding:3px; padding-bottom:5px\" class=\"nowa_l tlo3\">";

			 		$akapit=new akapitForm($dane2['zajawka'],0);

					if($dane2['img2_nazwa']){
						$akapit->setImgNazwa(konf::get()->getKonfigTab("art_konf",'art_kat').$dane2['img2_nazwa']);
						$akapit->setImgW($dane2['img2_w']);
						$akapit->setImgH($dane2['img2_h']);
						$akapit->setImgLink($this->artLink($dane2,"","",false));
						$akapit->setImgOpis($dane2['tytul']);
						$akapit->setImgAlign($dane2['img_align']);
						$akapit->setImgClass("obrazek");
					}

					$akapit->setAkapitClass("nowa_l");

					echo $akapit->zwrot();

		    	echo "<div class=\"prawa\"><a class=\"grube\" ".$this->artLink($dane2).">".konf::get()->getKonfigTab("art_konf",'wys_wiecej')."</a></div>";

		  		//stopka newsa z zawartoscia zależnie od konfiguracji
		  		echo "<div class=\"male nowa_l\">";
		      if($dane['komentarze']){
		        $ile_kom=konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'art_koment')." WHERE id_matka='".$dane2['id']."'");
		        echo "<a href=\"".$this->artLink($dane2,"","",false)."#koment\" class=\"male\">".konf::get()->langTexty("art_komentarze");
		        if(!empty($ile_kom)){
		          echo " [".$ile_kom."]";
		        }
		        echo "</a><br />";
		      }

			 	  if(konf::get()->getKonfigTab("art_konf",'wys_autor')){
						echo interfejs::autor($dane2);
		  		}

		  		if(konf::get()->getKonfigTab("art_konf",'wys_licznik')){
		  			echo konf::get()->langTexty("art_odslon")." ".$dane2['licznik']."<br />";
				  }

			  	echo "</div>";
					//k stopka newsa

					echo "</div>";

		    } //k przelatujemy newsy

	    	if(!empty($dane['na_str'])){
					if($naw->getNaw()){
						echo "<div class=\"nowa_l\" style=\"padding:5px\">".$naw->getNaw()."</div>";
					}
	    	}

			}//k czy newsy

	    if($this->admin()&&konf::get()->getKonfigTab("art_konf",'adminpodglad')){
				echo $form->getFormk();
	   	}

		  konf::get()->_bazasql->freeResult($zap);

		}

	}


  /**
   * art
   */
	public function zobacz($art_idtf=""){

		if(empty($art_idtf)){
		  $art_idtf=tekstForm::doSql(konf::get()->getZmienna('art_idtf','art_idtf'));
		}

	  $podstrona=konf::get()->getZmienna('podstrona','podstrona');
	  $colspan=1;

	  //pobierz za pomoca identyfikatora
	  if(!empty($art_idtf)){
			$dane=$this->pobierzIdtf($art_idtf);
	  }

	  //lub za pomoca id
		if(!empty($this->_artId)&&empty($dane)){
			$dane=$this->pobierz($this->_artId);
	  }

	  //lub domyslny
		if(empty($this->_artId)&&empty($dane)){
			$dane=$this->pobierz("",true,false,false,1);
	  }

	  if(empty($dane)){
	  	$this->_artId="";
	  }  else {
			$this->_artId=$dane['id'];
		}

	  //jesli istnieje element
		if(!empty($this->_artId)){

			if(konf::get()->getKonfigTab("art_konf",'sciezka')&&$dane['id_matka']>=0){
				$this->sciezka();
			}

			$dostep=$this->dostep($dane['dostep']);

			//dostep
			if($dostep){

				if(empty($dane['submenu_polozenie'])){
					$dane['submenu_polozenie']=konf::get()->getKonfigTab("art_konf",'submenu_polozenie');
				}

				if(empty($dane['submenu_wyglad'])){
					$dane['submenu_wyglad']=konf::get()->getKonfigTab("art_konf",'submenu_wyglad');
				}

				//indywidualne meta tagi
				if(!empty($dane['art_description'])){
					konf::get()->setKonfigTab(array('description'=>$dane['art_description']));
				}
				if(!empty($dane['art_keywords'])){
					konf::get()->setKonfigTab(array('keywords'=>$dane['art_keywords']));
				}

				if(!empty($dane['stat_nie'])){
					konf::get()->setKonfigTab(array('kodstat'=>""));
				}

				//indywidualne title dla podstrony
				if(konf::get()->getKonfigTab("art_konf",'tytuly_indywidualne')){

					if(!empty($dane['art_title'])){
						konf::get()->setTitle($dane['art_title'],true);
					} else {
						konf::get()->setTitle($dane['tytul']);
					}

				}

				if($dane['typ']==3){

					$dane3=$this->pobierz($dane['id_matka'],true,true);
					if(!empty($dane3)){
				    echo "<h1>".$dane3['tytul']."</h1>";
					}
		      //naglowek newsa
		      echo "<div style=\"padding:3px\" class=\"tlo4 grube\">";
		      if((konf::get()->getKonfigTab("art_konf",'data_wys')||$dane['typ']==3)&&tekstForm::niepuste($dane['data_wys'])){
		        echo "<span class=\"datownik\">";
		        echo substr($dane['data_wys'],0,konf::get()->getKonfigTab("art_konf",'data_wys_dl'));
		        echo "</span> ";
		      }
					echo $dane['tytul'];
					echo "</div>";

				} else {

					if(konf::get()->getKonfigTab("art_konf",'data_wys')&&tekstForm::niepuste($dane['data_wys'])){
				    echo "<div class=\"datownik\">".substr($dane['data_wys'],0,konf::get()->getKonfigTab("art_konf",'data_wys_dl'))."</div>";
					}

					if(empty($dane['tytul_nie'])){
				    echo "<h1>".$dane['tytul']."</h1>";
					}

				}

				if(konf::get()->getKonfigTab("art_konf",'podtytul')&&!empty($dane['podtytul'])){
			    echo "<div class=\"podtytul\">".$dane['podtytul']."</div>";
				}

			  if($this->admin()&&konf::get()->getAkcja()!="art_drukuj"&&konf::get()->getAkcja()!="art_plik"&&konf::get()->getKonfigTab("art_konf",'adminpodglad')){
					echo "<div class=\"nowa_l ".konf::get()->getKonfigTab("art_konf",'tresc_class')."\" style=\"padding:5px\">";
					$form=new formularz("post",konf::get()->getKonfigTab("plik"),"art","art");
					echo $form->getFormp();
					echo $form->input("radio","id_nr","id_nr",$dane['id'],"przycisk","","onclick=\"this.form.submit();\"");
					echo $form->przenies(array("akcja"=>"artadmin_edytuj","id_d"=>$dane['id_d']));
					echo $form->getFormk();
					echo "</div>";

					konf::get()->setPlikiHeader(konf::get()->getKonfigTab("sciezka")."js/tooltip.js","js");
					konf::get()->setKod("kodfooter","<script type=\"text/javascript\">tt_Init();</script>");

		    }

		    $query=" FROM ".konf::get()->getKonfigTab("sql_tab",'art_akapity')." WHERE id_matka='".$this->_artId."'";
		  	if(!$this->admin()){
					$query.=" AND status=1";
		  	}

				if($dane['na_str']&&$dane['typ']!=2){
					$naw = new nawig("SELECT COUNT(id) AS ilosc".$query,$podstrona,$dane['na_str']);
					$naw->naw(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>konf::get()->getAkcja(),"id_art"=>$this->_artId)));
					$podstrona=$naw->getPodstrona();

					if($naw->getNaw()){
						echo "<div class=\"nowa_l ".konf::get()->getKonfigTab("art_konf",'tresc_class')."\"\" style=\"padding:5px\">".$naw->getNaw()."</div>";
					}
				}

			  $query="SELECT * ".$query." ORDER BY nr_poz,id ";

				if($dane['na_str']&&$dane['typ']!=2){
					$query.="LIMIT ".$naw->getStart().",".$naw->getIle();
				}

			  $zap2=konf::get()->_bazasql->zap($query);

				echo "<div class=\"nowa_l ".konf::get()->getKonfigTab("art_konf",'tresc_class')."\">";

				//lista podstron
		    if($dane['submenu_polozenie']==1&&$dane['typ']!=2){
			    $this->podstron($dane);
		    }

				//licznik petli
				$i=0;
				$ile=konf::get()->_bazasql->numRows($zap2);
				$dane_akapitow=array();
				$pobierz_galerie="";
			  $link4=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_art"=>$dane['id'],"id_d"=>$dane['id_d']));

				require_once(konf::get()->getKonfigTab('klasy')."class.akapitform.php");

				if(konf::get()->getKonfigTab("art_konf",'blokada')&&$this->admin()){
					require_once(konf::get()->getKonfigTab("klasy")."class.blokada.php");
					$blokada=new blokada(konf::get()->getKonfigTab("sql_tab",'art_akapity'),"blokada","data_blokada",konf::get()->getKonfigTab("art_konf",'blokada'));
				}

				//pobierz akapity
				while($dane2=konf::get()->_bazasql->fetchAssoc($zap2)){
					$dane_akapitow[$dane2['id']]=$dane2;
					if(!empty($pobierz_galerie)){
						$pobierz_galerie.=",";
					}
					$pobierz_galerie.="'".$dane2['id']."'";
				}
		 		konf::get()->_bazasql->freeResult($zap2);

				//pobierz galerie
				if(!empty($pobierz_galerie)&&konf::get()->getKonfigTab("sql_tab",'art_galeria')){

					require_once(konf::get()->getKonfigTab('klasy')."class.galeria.php");

					$zap2=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art_galeria')." WHERE id_matka IN (".$pobierz_galerie.") AND status=1 AND obrobka=0 ORDER BY id_matka,nr_poz,id");
					while($dane2=konf::get()->_bazasql->fetchAssoc($zap2)){
						$galerie[$dane2['id_matka']][$dane2['id']]=$dane2;
					}
			 		konf::get()->_bazasql->freeResult($zap2);

				}

				$przenies=array(
					"akcja"=>konf::get()->getAkcja(),
					"id_art"=>$dane['id'],
					"podstrona"=>$podstrona
				);

				reset($dane_akapitow);
				while(list($key,$dane2)=each($dane_akapitow)){

					$i++;

				  //tylko dla admina
		      if($this->admin()&&konf::get()->getAkcja()!="art_drukuj"&&konf::get()->getAkcja()!="art_plik"&&konf::get()->getKonfigTab("art_konf",'adminpodglad')){

						echo "<div class=\"ramka nowa_l\">";
						echo "<div class=\"male\">";
						echo interfejs::wstaw($link4."&amp;akcja=artadmin_akapitydodaj&amp;id_nad=".$dane2['id']);
						echo "</div>";
						echo "<div class=\"male\">".konf::get()->langTexty("art_akapit_admin")."</div>";
		  	    echo "<div class=\"grube male\">";
		    	  if($dane2['status']==1){
		      		echo konf::get()->langTexty("art_akapit_widoczny");
			      } else {
		          echo konf::get()->langTexty("art_akapit_niewidoczny");
		        }
		        echo "</div>";
		       	//sprawdzamy czy ktos aktualnie edytuje ten artykul
		      	if(!$blokada->dostepny($dane2['blokada'], $dane2['data_blokada'])){
		        	echo "<div class=\"error nowa_l male\">".konf::get()->langTexty("art_aktualnie")." ".$dane2['blokada']."</div>";
			      } else {

							echo "<table border=\"0\" style=\"margin-top:5px\"><tr>";
					    echo interfejs::edytuj($link4."&amp;akcja=artadmin_akapityedytuj&amp;id_nr=".$dane2['id']);
					    echo interfejs::przyciskEl("folder_wrench",$link4."&amp;akcja=artadmin_akapitykonfigedytuj&amp;id_nr=".$dane2['id'],konf::get()->langTexty("art_akapity_edytujk"));
							if(konf::get()->getKonfigTab("art_konf",'galeria')){
						    echo interfejs::przyciskEl("picture",$link4."&amp;akcja=artadmin_galeria&amp;id_akapit=".$dane2['id'],konf::get()->langTexty("art_akapity_galeria"));
							}
							if($dane['na_str']&&$dane['typ']!=2){
								echo interfejs::pozycja($link4."&amp;akcja=artadmin_akapitypoz&amp;id_nr=".$dane2['id'],$i,$ile,$podstrona,$naw->getStron());
							} else {
								echo interfejs::pozycja($link4."&amp;akcja=artadmin_akapitypoz&amp;id_nr=".$dane2['id'],$i,$ile,$podstrona,1);
							}
							echo interfejs::infoEl($dane);
							echo interfejs::usun($link4."&amp;podstrona=".$podstrona."&amp;akcja=artadmin_akapityusun&amp;id_tab[1]=".$dane2['id']);
							echo "</tr></table>";
		        }
						echo "<div class=\"nowa_l\"></div>";
		        echo "</div>";

		      }

					if(konf::get()->getKonfigTab("sql_tab",'art_galeria')&&!empty($galerie[$dane2['id']])){
						echo $this->akapit($dane,$dane2,$galerie[$dane2['id']],$przenies);
					} else {
						echo $this->akapit($dane,$dane2);
					}

		    }


	      if($this->admin()&&konf::get()->getAkcja()!="art_drukuj"&&konf::get()->getAkcja()!="art_plik"&&konf::get()->getKonfigTab("art_konf",'adminpodglad')){
	        echo "<div class=\"ramka nowa_l\">";
					echo interfejs::wstaw($link4."&amp;akcja=artadmin_akapitydodaj");
					echo "<div class=\"nowa_l\"></div>";
	        echo "</div>";
	      }


		    if($dane['submenu_polozenie']==2||$dane['typ']==2){
		      $this->podstron($dane);
		    }

				if($dane['na_str']&&$dane['typ']!=2){
					if($naw->getNaw()){
						echo "<div class=\"nowa_l\" style=\"padding:5px\">".$naw->getNaw()."</div>";
					}
				}

			  //stopka artykułu z zawartością zależnie od konfiguracji

				if(empty($dane['stopka_nie'])){

			    echo "<div class=\"nowa_l\">";
			    echo "<div class=\"male\">";

			    if(konf::get()->getKonfigTab("art_konf",'arch_szczegoly')){
						echo interfejs::autor($dane);
			  	}
			  	if(konf::get()->getKonfigTab("art_konf",'wytworzyl')&&$dane['wytworzyl']){
		    	  echo konf::get()->langTexty("art_wytworzyl")."<span class=\"grube\"> ".$dane['wytworzyl_data']." ".$dane['wytworzyl']."</span><br />";
					}
		  	  //licznik
		    	if(konf::get()->getKonfigTab("art_konf",'wys_licznik')){
		    	  echo konf::get()->langTexty("art_ileo")." <span class=\"grube\">".$dane['licznik']."</span><br />";
		    	}

					if(konf::get()->getAkcja()!="art_drukuj"&&konf::get()->getAkcja()!="art_plik"&&konf::get()->getKonfigTab("art_konf",'wys_dziennik_zmian')){
						echo "<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artdziennik_arch","id_art"=>$dane['id']))."\">".konf::get()->langTexty("art_repozytorium")."</a>";
					}

		      if(konf::get()->getKonfigTab("art_konf",'pobierz_zrodlo')&&!empty($dane['zrodlo_link'])){
				  	echo konf::get()->langTexty("art_zrodlo")."<span class=\"grube\"> ".$dane['zrodlo']."</span><br />";
		  		}

			    echo "</div>";


					echo "<div class=\"prawa\">";

			    //druk
			    if(konf::get()->getAkcja()!="art_drukuj"&&konf::get()->getAkcja()!="art_plik"&&$dane['typ']!=2){
						if($dane['do_gory']){
							echo "<div class=\"prawa\" style=\"padding-bottom:10px; padding-right:20px;\"><a href=\"#www_top\" class=\"male\">".konf::get()->langTexty("art_dogory")."</a></div>";
						}

						if(empty($dane['stopka_nie'])){
							if(konf::get()->getKonfigTab("art_konf",'wys_druk')){
					      echo "<a href=\"javascript:void(null);\" onclick=\"javascript:window.open('".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"art_drukuj","id_art"=>$dane['id']))."','druk','top=10,left=10,width=600,height=600,toolbar=yes,menubar=yes,location=no,directories=no,alwaysRaised=no,status=no,scrollbars=yes,resizable=yes,fullscreen=0');\"><img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/drukuj.gif\" border=\"0\" width=\"21\" height=\"18\" alt=\"".konf::get()->langTexty("art_drukuj")."\" title=\"".konf::get()->langTexty("art_drukuj")."\" /></a>&nbsp;&nbsp;";
					      echo "<a href=\"javascript:void(null);\" onclick=\"javascript:window.open('".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"art_plik","id_art"=>$dane['id']))."','druk','top=10,left=10,width=600,height=600,toolbar=yes,menubar=yes,location=no,directories=no,alwaysRaised=no,status=no,scrollbars=yes,resizable=yes,fullscreen=0');\"><img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/plik.gif\" border=\"0\" width=\"18\" height=\"16\" alt=\"".konf::get()->langTexty("art_zapisz")."\" title=\"".konf::get()->langTexty("art_zapisz")."\" /></a>&nbsp;&nbsp;";
							}
							if(konf::get()->getKonfigTab("art_konf",'wys_wyslij')){
					      echo "<a href=\"javascript:void(null);\" onclick=\"javascript:window.open('".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"art_wyslij","id_art"=>$dane['id']))."','druk','top=50,left=200,width=450,height=500,toolbar=yes,menubar=yes,location=no,directories=no,alwaysRaised=no,status=no,scrollbars=yes,resizable=yes,fullscreen=0');\"><img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/wyslij.gif\" border=\"0\" width=\"18\" height=\"16\" alt=\"".konf::get()->langTexty("art_wyslij")."\" title=\"".konf::get()->langTexty("art_wyslij")."\" /></a>";
							}
						}
			    }

					if(empty($dane['stopka_nie'])&&$dane['rss']){
						echo "&nbsp;&nbsp;<a href=\"".konf::get()->zmienneLink("rss.php",array("id_art"=>$dane['id']))."\" target=\"_blank\"><img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/ikony/feed.gif\" width=\"16\" height=\"16\" alt=\"RSS\" /></a>";
					}
			    echo "</div>";

					if(konf::get()->getAkcja()=="art_drukuj"||konf::get()->getAkcja()=="art_plik"){
						echo "<div><hr /><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_art"=>$dane['id']))."\">".konf::get()->zmienneLink(konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("plik"),array("id_art"=>$dane['id']))."</a></div>";
					}

					echo "</div>";

					//k stopka
					echo "</div>";

				}

				if(konf::get()->getAkcja()!="art_drukuj"&&konf::get()->getAkcja()!="art_plik"&&konf::get()->getKonfigTab("art_konf",'powrot')&&!empty($dane['id_matka'])){
					$dane3=$this->pobierz($dane['id_matka']);
					if(!empty($dane3)){
						//echo "<div class=\"tlo4 srodek\" style=\"padding:3px;\"><a ".$this->artLink($dane3).">".konf::get()->langTexty("art_powrot")."</a></div>";
					}
				}

		    //licznik ogladalnosci
		    if(!$this->admin()&&user::get()->filtr(4)) {
		    	konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'art')." SET licznik=licznik+1 WHERE id='".$dane['id']."'");
		    }

		    if(konf::get()->isMod("koment")&&$dane['typ']!=2&&konf::get()->getKonfigTab("art_konf",'kom')&&$dane['komentarze']&&konf::get()->getAkcja()!="art_drukuj"&&konf::get()->getAkcja()!="art_plik"){
					$konf=konf::get();
					require_once(konf::get()->getKonfigTab('mod_kat')."koment/class.koment.php");
					$koment=new koment(1);
					$koment->setPrzenies(array("id_art"=>$dane['id']));
					$koment->setId($dane['id']);
					$koment->wyswietl();
					$koment->formularz();
		    }

				//k art
			} else {
				$redir=base64_encode(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_art"=>$dane['id'])));
			 	header("Location: ".str_replace("&amp;","&",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_zaloguj","redir"=>$redir))));
			}

			//k dostep
	  } else {
			echo "<div class=\"grube srodek\">...</div>";
		}

	}

  public function zobacz2($art_idtf=""){

		if(empty($art_idtf)){
		  $art_idtf=tekstForm::doSql(konf::get()->getZmienna('art_idtf','art_idtf'));
		}

	  $podstrona=konf::get()->getZmienna('podstrona','podstrona');
	  $colspan=1;

	  //pobierz za pomoca identyfikatora
	  if(!empty($art_idtf)){
			$dane=$this->pobierzIdtf($art_idtf);
	  }

	  //lub za pomoca id
		if(!empty($this->_artId)&&empty($dane)){
			$dane=$this->pobierz($this->_artId);
	  }

	  //lub domyslny
		if(empty($this->_artId)&&empty($dane)){
			$dane=$this->pobierz("",true,false,false,1);
	  }

	  if(empty($dane)){
	  	$this->_artId="";
	  }  else {
			$this->_artId=$dane['id'];
		}

	  //jesli istnieje element
		if(!empty($this->_artId)){

			if(konf::get()->getKonfigTab("art_konf",'sciezka')&&$dane['id_matka']>=0){
				$this->sciezka();
			}

			$dostep=$this->dostep($dane['dostep']);

			//dostep
			if($dostep){

				if(empty($dane['submenu_polozenie'])){
					$dane['submenu_polozenie']=konf::get()->getKonfigTab("art_konf",'submenu_polozenie');
				}

				if(empty($dane['submenu_wyglad'])){
					$dane['submenu_wyglad']=konf::get()->getKonfigTab("art_konf",'submenu_wyglad');
				}

				//indywidualne meta tagi
				if(!empty($dane['art_description'])){
					konf::get()->setKonfigTab(array('description'=>$dane['art_description']));
				}
				if(!empty($dane['art_keywords'])){
					konf::get()->setKonfigTab(array('keywords'=>$dane['art_keywords']));
				}

				if(!empty($dane['stat_nie'])){
					konf::get()->setKonfigTab(array('kodstat'=>""));
				}

				//indywidualne title dla podstrony
				if(konf::get()->getKonfigTab("art_konf",'tytuly_indywidualne')){

					if(!empty($dane['art_title'])){
						konf::get()->setTitle($dane['art_title'],true);
					} else {
						konf::get()->setTitle($dane['tytul']);
					}

				}

				if($dane['typ']==3){

					$dane3=$this->pobierz($dane['id_matka'],true,true);
					if(!empty($dane3)){
				    echo "<h1>".$dane3['tytul']."</h1>";
					}
		      //naglowek newsa
		      echo "<div style=\"padding:3px\" class=\"tlo4 grube\">";
		      if((konf::get()->getKonfigTab("art_konf",'data_wys')||$dane['typ']==3)&&tekstForm::niepuste($dane['data_wys'])){
		        echo "<span class=\"datownik\">";
		        echo substr($dane['data_wys'],0,konf::get()->getKonfigTab("art_konf",'data_wys_dl'));
		        echo "</span> ";
		      }
					echo $dane['tytul'];
					echo "</div>";

				} else {

					if(konf::get()->getKonfigTab("art_konf",'data_wys')&&tekstForm::niepuste($dane['data_wys'])){
				    echo "<div class=\"datownik\">".substr($dane['data_wys'],0,konf::get()->getKonfigTab("art_konf",'data_wys_dl'))."</div>";
					}

					if(empty($dane['tytul_nie'])){
				    echo "<h1>".$dane['tytul']."</h1>";
					}

				}

				if(konf::get()->getKonfigTab("art_konf",'podtytul')&&!empty($dane['podtytul'])){
			    echo "<div class=\"podtytul\">".$dane['podtytul']."</div>";
				}

			  if($this->admin()&&konf::get()->getAkcja()!="art_drukuj"&&konf::get()->getAkcja()!="art_plik"&&konf::get()->getKonfigTab("art_konf",'adminpodglad')){
					echo "<div class=\"nowa_l ".konf::get()->getKonfigTab("art_konf",'tresc_class')."\" style=\"padding:5px\">";
					$form=new formularz("post",konf::get()->getKonfigTab("plik"),"art","art");
					echo $form->getFormp();
					echo $form->input("radio","id_nr","id_nr",$dane['id'],"przycisk","","onclick=\"this.form.submit();\"");
					echo $form->przenies(array("akcja"=>"artadmin_edytuj","id_d"=>$dane['id_d']));
					echo $form->getFormk();
					echo "</div>";

					konf::get()->setPlikiHeader(konf::get()->getKonfigTab("sciezka")."js/tooltip.js","js");
					konf::get()->setKod("kodfooter","<script type=\"text/javascript\">tt_Init();</script>");

		    }

		    $query=" FROM ".konf::get()->getKonfigTab("sql_tab",'art_akapity')." WHERE id_matka='".$this->_artId."'";
		  	if(!$this->admin()){
					$query.=" AND status=1";
		  	}

				if($dane['na_str']&&$dane['typ']!=2){
					$naw = new nawig("SELECT COUNT(id) AS ilosc".$query,$podstrona,$dane['na_str']);
					$naw->naw(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>konf::get()->getAkcja(),"id_art"=>$this->_artId)));
					$podstrona=$naw->getPodstrona();

					if($naw->getNaw()){
						echo "<div class=\"nowa_l ".konf::get()->getKonfigTab("art_konf",'tresc_class')."\"\" style=\"padding:5px\">".$naw->getNaw()."</div>";
					}
				}

			  $query="SELECT * ".$query." ORDER BY nr_poz,id ";

				if($dane['na_str']&&$dane['typ']!=2){
					$query.="LIMIT ".$naw->getStart().",".$naw->getIle();
				}

			  $zap2=konf::get()->_bazasql->zap($query);

				echo "<div class=\"nowa_l ".konf::get()->getKonfigTab("art_konf",'tresc_class')."\">";

				//lista podstron
		    if($dane['submenu_polozenie']==1&&$dane['typ']!=2){
			    $this->podstron($dane);
		    }

				//licznik petli
				$i=0;
				$ile=konf::get()->_bazasql->numRows($zap2);
				$dane_akapitow=array();
				$pobierz_galerie="";
			  $link4=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_art"=>$dane['id'],"id_d"=>$dane['id_d']));

				require_once(konf::get()->getKonfigTab('klasy')."class.akapitform.php");

				if(konf::get()->getKonfigTab("art_konf",'blokada')&&$this->admin()){
					require_once(konf::get()->getKonfigTab("klasy")."class.blokada.php");
					$blokada=new blokada(konf::get()->getKonfigTab("sql_tab",'art_akapity'),"blokada","data_blokada",konf::get()->getKonfigTab("art_konf",'blokada'));
				}

				//pobierz akapity
				while($dane2=konf::get()->_bazasql->fetchAssoc($zap2)){
					$dane_akapitow[$dane2['id']]=$dane2;
					if(!empty($pobierz_galerie)){
						$pobierz_galerie.=",";
					}
					$pobierz_galerie.="'".$dane2['id']."'";
				}
		 		konf::get()->_bazasql->freeResult($zap2);

				//pobierz galerie
				if(!empty($pobierz_galerie)&&konf::get()->getKonfigTab("sql_tab",'art_galeria')){

					require_once(konf::get()->getKonfigTab('klasy')."class.galeria.php");

					$zap2=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art_galeria')." WHERE id_matka IN (".$pobierz_galerie.") AND status=1 AND obrobka=0 ORDER BY id_matka,nr_poz,id");
					while($dane2=konf::get()->_bazasql->fetchAssoc($zap2)){
						$galerie[$dane2['id_matka']][$dane2['id']]=$dane2;
					}
			 		konf::get()->_bazasql->freeResult($zap2);

				}

				$przenies=array(
					"akcja"=>konf::get()->getAkcja(),
					"id_art"=>$dane['id'],
					"podstrona"=>$podstrona
				);

				reset($dane_akapitow);
				while(list($key,$dane2)=each($dane_akapitow)){

					$i++;

				  //tylko dla admina
		      if($this->admin()&&konf::get()->getAkcja()!="art_drukuj"&&konf::get()->getAkcja()!="art_plik"&&konf::get()->getKonfigTab("art_konf",'adminpodglad')){

						echo "<div class=\"ramka nowa_l\">";
						echo "<div class=\"male\">";
						echo interfejs::wstaw($link4."&amp;akcja=artadmin_akapitydodaj&amp;id_nad=".$dane2['id']);
						echo "</div>";
						echo "<div class=\"male\">".konf::get()->langTexty("art_akapit_admin")."</div>";
		  	    echo "<div class=\"grube male\">";
		    	  if($dane2['status']==1){
		      		echo konf::get()->langTexty("art_akapit_widoczny");
			      } else {
		          echo konf::get()->langTexty("art_akapit_niewidoczny");
		        }
		        echo "</div>";
		       	//sprawdzamy czy ktos aktualnie edytuje ten artykul
		      	if(!$blokada->dostepny($dane2['blokada'], $dane2['data_blokada'])){
		        	echo "<div class=\"error nowa_l male\">".konf::get()->langTexty("art_aktualnie")." ".$dane2['blokada']."</div>";
			      } else {

							echo "<table border=\"0\" style=\"margin-top:5px\"><tr>";
					    echo interfejs::edytuj($link4."&amp;akcja=artadmin_akapityedytuj&amp;id_nr=".$dane2['id']);
					    echo interfejs::przyciskEl("folder_wrench",$link4."&amp;akcja=artadmin_akapitykonfigedytuj&amp;id_nr=".$dane2['id'],konf::get()->langTexty("art_akapity_edytujk"));
							if(konf::get()->getKonfigTab("art_konf",'galeria')){
						    echo interfejs::przyciskEl("picture",$link4."&amp;akcja=artadmin_galeria&amp;id_akapit=".$dane2['id'],konf::get()->langTexty("art_akapity_galeria"));
							}
							if($dane['na_str']&&$dane['typ']!=2){
								echo interfejs::pozycja($link4."&amp;akcja=artadmin_akapitypoz&amp;id_nr=".$dane2['id'],$i,$ile,$podstrona,$naw->getStron());
							} else {
								echo interfejs::pozycja($link4."&amp;akcja=artadmin_akapitypoz&amp;id_nr=".$dane2['id'],$i,$ile,$podstrona,1);
							}
							echo interfejs::infoEl($dane);
							echo interfejs::usun($link4."&amp;podstrona=".$podstrona."&amp;akcja=artadmin_akapityusun&amp;id_tab[1]=".$dane2['id']);
							echo "</tr></table>";
		        }
						echo "<div class=\"nowa_l\"></div>";
		        echo "</div>";

		      }

					if(konf::get()->getKonfigTab("sql_tab",'art_galeria')&&!empty($galerie[$dane2['id']])){
						echo $this->akapit($dane,$dane2,$galerie[$dane2['id']],$przenies);
					} else {
						echo $this->akapit($dane,$dane2);
					}

		    }


	      if($this->admin()&&konf::get()->getAkcja()!="art_drukuj"&&konf::get()->getAkcja()!="art_plik"&&konf::get()->getKonfigTab("art_konf",'adminpodglad')){
	        echo "<div class=\"ramka nowa_l\">";
					echo interfejs::wstaw($link4."&amp;akcja=artadmin_akapitydodaj");
					echo "<div class=\"nowa_l\"></div>";
	        echo "</div>";
	      }


		    if($dane['submenu_polozenie']==2||$dane['typ']==2){
		      $this->podstron($dane);
		    }

				if($dane['na_str']&&$dane['typ']!=2){
					if($naw->getNaw()){
						echo "<div class=\"nowa_l\" style=\"padding:5px\">".$naw->getNaw()."</div>";
					}
				}

			  //stopka artykułu z zawartością zależnie od konfiguracji

				if(empty($dane['stopka_nie'])){

			    echo "<div class=\"nowa_l\">";
			    echo "<div class=\"male\">";

			    if(konf::get()->getKonfigTab("art_konf",'arch_szczegoly')){
						echo interfejs::autor($dane);
			  	}
			  	if(konf::get()->getKonfigTab("art_konf",'wytworzyl')&&$dane['wytworzyl']){
		    	  echo konf::get()->langTexty("art_wytworzyl")."<span class=\"grube\"> ".$dane['wytworzyl_data']." ".$dane['wytworzyl']."</span><br />";
					}
		  	  //licznik
		    	if(konf::get()->getKonfigTab("art_konf",'wys_licznik')){
		    	  echo konf::get()->langTexty("art_ileo")." <span class=\"grube\">".$dane['licznik']."</span><br />";
		    	}

					if(konf::get()->getAkcja()!="art_drukuj"&&konf::get()->getAkcja()!="art_plik"&&konf::get()->getKonfigTab("art_konf",'wys_dziennik_zmian')){
						echo "<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"artdziennik_arch","id_art"=>$dane['id']))."\">".konf::get()->langTexty("art_repozytorium")."</a>";
					}

		      if(konf::get()->getKonfigTab("art_konf",'pobierz_zrodlo')&&!empty($dane['zrodlo_link'])){
				  	echo konf::get()->langTexty("art_zrodlo")."<span class=\"grube\"> ".$dane['zrodlo']."</span><br />";
		  		}

			    echo "</div>";


					echo "<div class=\"prawa\">";

			    //druk
			    if(konf::get()->getAkcja()!="art_drukuj"&&konf::get()->getAkcja()!="art_plik"&&$dane['typ']!=2){
						if($dane['do_gory']){
							echo "<div class=\"prawa\" style=\"padding-bottom:10px; padding-right:20px;\"><a href=\"#www_top\" class=\"male\">".konf::get()->langTexty("art_dogory")."</a></div>";
						}

						if(empty($dane['stopka_nie'])){
							if(konf::get()->getKonfigTab("art_konf",'wys_druk')){
					      echo "<a href=\"javascript:void(null);\" onclick=\"javascript:window.open('".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"art_drukuj","id_art"=>$dane['id']))."','druk','top=10,left=10,width=600,height=600,toolbar=yes,menubar=yes,location=no,directories=no,alwaysRaised=no,status=no,scrollbars=yes,resizable=yes,fullscreen=0');\"><img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/drukuj.gif\" border=\"0\" width=\"21\" height=\"18\" alt=\"".konf::get()->langTexty("art_drukuj")."\" title=\"".konf::get()->langTexty("art_drukuj")."\" /></a>&nbsp;&nbsp;";
					      echo "<a href=\"javascript:void(null);\" onclick=\"javascript:window.open('".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"art_plik","id_art"=>$dane['id']))."','druk','top=10,left=10,width=600,height=600,toolbar=yes,menubar=yes,location=no,directories=no,alwaysRaised=no,status=no,scrollbars=yes,resizable=yes,fullscreen=0');\"><img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/plik.gif\" border=\"0\" width=\"18\" height=\"16\" alt=\"".konf::get()->langTexty("art_zapisz")."\" title=\"".konf::get()->langTexty("art_zapisz")."\" /></a>&nbsp;&nbsp;";
							}
							if(konf::get()->getKonfigTab("art_konf",'wys_wyslij')){
					      echo "<a href=\"javascript:void(null);\" onclick=\"javascript:window.open('".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"art_wyslij","id_art"=>$dane['id']))."','druk','top=50,left=200,width=450,height=500,toolbar=yes,menubar=yes,location=no,directories=no,alwaysRaised=no,status=no,scrollbars=yes,resizable=yes,fullscreen=0');\"><img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/wyslij.gif\" border=\"0\" width=\"18\" height=\"16\" alt=\"".konf::get()->langTexty("art_wyslij")."\" title=\"".konf::get()->langTexty("art_wyslij")."\" /></a>";
							}
						}
			    }

					if(empty($dane['stopka_nie'])&&$dane['rss']){
						echo "&nbsp;&nbsp;<a href=\"".konf::get()->zmienneLink("rss.php",array("id_art"=>$dane['id']))."\" target=\"_blank\"><img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/ikony/feed.gif\" width=\"16\" height=\"16\" alt=\"RSS\" /></a>";
					}
			    echo "</div>";

					if(konf::get()->getAkcja()=="art_drukuj"||konf::get()->getAkcja()=="art_plik"){
						echo "<div><hr /><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_art"=>$dane['id']))."\">".konf::get()->zmienneLink(konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("plik"),array("id_art"=>$dane['id']))."</a></div>";
					}

					echo "</div>";

					//k stopka
					echo "</div>";

				}

				if(konf::get()->getAkcja()!="art_drukuj"&&konf::get()->getAkcja()!="art_plik"&&konf::get()->getKonfigTab("art_konf",'powrot')&&!empty($dane['id_matka'])){
					$dane3=$this->pobierz($dane['id_matka']);
					if(!empty($dane3)){
						//echo "<div class=\"tlo4 srodek\" style=\"padding:3px;\"><a ".$this->artLink($dane3).">".konf::get()->langTexty("art_powrot")."</a></div>";
					}
				}

		    //licznik ogladalnosci
		    if(!$this->admin()&&user::get()->filtr(4)) {
		    	konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'art')." SET licznik=licznik+1 WHERE id='".$dane['id']."'");
		    }

		    if(konf::get()->isMod("koment")&&$dane['typ']!=2&&konf::get()->getKonfigTab("art_konf",'kom')&&$dane['komentarze']&&konf::get()->getAkcja()!="art_drukuj"&&konf::get()->getAkcja()!="art_plik"){
					$konf=konf::get();
					require_once(konf::get()->getKonfigTab('mod_kat')."koment/class.koment.php");
					$koment=new koment(1);
					$koment->setPrzenies(array("id_art"=>$dane['id']));
					$koment->setId($dane['id']);
					$koment->wyswietl();
					$koment->formularz();
		    }

				//k art
			} else {
				$redir=base64_encode(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_art"=>$dane['id'])));
			 	header("Location: ".str_replace("&amp;","&",konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"u_zaloguj","redir"=>$redir))));
			}

			//k dostep
	  } else {
			echo "<div class=\"grube srodek\">...</div>";
		}

	}


  /**
   * art
   */
	public function projektor(){

	  $id_fotka=tekstForm::doSql(konf::get()->getZmienna('id_fotka','id_fotka'));

		if(!empty($id_fotka)){

			$dane3=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art_galeria')." WHERE id=".$id_fotka." AND status=1 AND obrobka=0");

			if(!empty($dane3)){

				$dane2=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art_akapity')." WHERE id=".$dane3['id_matka']." AND status=1");
				if(!empty($dane2)){
					$this->_artId=$dane2['id_matka'];
				}

			}


		}

	  //lub za pomoca id
		if(!empty($this->_artId)){
			$dane=$this->pobierz($this->_artId);
	  }

	  //jesli istnieje element
		if(!empty($this->_artId)&&!empty($dane2)&&$this->dostep($dane['dostep'])){

			$galerie=array();

			$poprzednie="";
			$nastepne="";

			$zap2=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art_galeria')." WHERE id_matka =".$dane2['id']." AND status=1 AND obrobka=0 ORDER BY nr_poz,id");
			while($dane4=konf::get()->_bazasql->fetchAssoc($zap2)){
				$galerie[$dane4['id']]=$dane4;

				if($dane4['id']!=$id_fotka&&$dane4['nr_poz']<$dane3['nr_poz']){
					$poprzednie=$dane4['id'];
				}

				if(empty($nastepne)&&$dane4['id']!=$id_fotka&&$dane4['nr_poz']>$dane3['nr_poz']){
					$nastepne=$dane4['id'];
				}

			}
	 		konf::get()->_bazasql->freeResult($zap2);

			$dostep=$this->dostep($dane['dostep']);


			//indywidualne meta tagi
			if(!empty($dane['art_description'])){
				konf::get()->setKonfigTab(array('description'=>$dane['art_description']));
			}
			if(!empty($dane['art_keywords'])){
				konf::get()->setKonfigTab(array('keywords'=>$dane['art_keywords']));
			}

			//indywidualne title dla podstrony
			if(konf::get()->getKonfigTab("art_konf",'tytuly_indywidualne')){

				if(konf::get()->getKonfigTab('tytul_przedrostek')){
					$dane['art_tytul']=konf::get()->getKonfigTab('tytul_przedrostek')." - ".$dane['tytul'];
				} else {
					$dane['art_tytul']=$dane['tytul'];
				}

				konf::get()->setKonfigTab(array('tytul'=>$dane['art_tytul']));

			}

			echo "<div class=\"galeria1 srodek\" style=\"padding:5px;\">";
			echo "<h1>".$dane['tytul']."</h1>";

			echo "<div><table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"seta srodek\" style=\"margin-bottom:5px\"><tr>";

			$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"art_projektor","id_art"=>$this->_artId));

			echo "<td style=\"width:33%; padding-left:10px;\" class=\"lewa\">";
			if(!empty($poprzednie)){
				echo "<a href=\"".$link."&amp;id_fotka=".$poprzednie."\">&lt;&lt;&nbsp;".konf::get()->langTexty("art_gal_poprzednie")."</a>";
			} else {
				echo "&nbsp;";
			}
			echo "</td>";
			echo "<td style=\"width:33%\"><a href=\"javascript:window.close()\">".konf::get()->langTexty("art_gal_zamknijokno")."</a></td>";

			echo "<td style=\"width:33%; padding-right:10px;\" class=\"prawa\">";
			if(!empty($nastepne)){
				echo "<a href=\"".$link."&amp;id_fotka=".$nastepne."\">".konf::get()->langTexty("art_gal_nastepne")."&nbsp;&gt;&gt;</a>";
			} else {
				echo "&nbsp;";
			}
			echo "</td>";

			echo "</tr></table></div>";

			echo "<div class=\"nowa_l\">";

			if(!empty($galerie[$id_fotka])){
				echo "<div class=\"srodek\">";
			  echo "<img src=\"".konf::get()->getKonfigTab("sciezka").konf::get()->getKonfigTab("art_konf","galeria_kat").$galerie[$id_fotka]['img1_nazwa']."\" width=\"".$galerie[$id_fotka]['img1_w']."\" height=\"".$galerie[$id_fotka]['img1_h']."\" alt=\"".htmlspecialchars($galerie[$id_fotka]['tytul'])."\" />";

				if(isset($galerie[$id_fotka]['tytul'])){
					echo "<div>".$galerie[$id_fotka]['tytul']."</div>";
				}

				echo "</div>";
			}

			echo "</div>";
			echo "</div>";

			//k dostep

	  } else {
			echo "<div class=\"grube srodek\">...</div>";
		}

	}




  /**
   * art plik
   */
	public function plik(){

		$this->zobacz();

	}

  /**
   * art druk
   */
	public function drukuj(){

		$this->zobacz();

	}


  /**
   * art rss
   */
	public function rss($art_idtf=""){

		if(empty($art_idtf)){
		  $art_idtf=tekstForm::doSql(konf::get()->getZmienna('art_idtf','art_idtf'));
		}

	  //pobierz za pomoca identyfikatora
	  if(!empty($art_idtf)){
			$dane=$this->pobierzIdtf($art_idtf);
	  }

	  //lub za pomoca id
		if(!empty($this->_artId)&&empty($dane)){
			$dane=$this->pobierz($this->_artId,false,true,true);
	  }


		if(!empty($dane)){

			$rss_link=konf::get()->getKonfigTab("sciezka").konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("id_art"=>$this->_artId));

			$dane['tytul']=htmlspecialchars(strip_tags(trim($dane['tytul'])));

			require_once(konf::get()->getKonfigTab('klasy')."class.rss.php");
			$rss=new rss("2.0");
			$rss->setParametry(array(
				"title"=>$dane['tytul'],
				"about"=>konf::get()->getKonfigTab('adres_www'),
				"description"=>konf::get()->getKonfigTab('adres_www')." ".$dane['tytul'],
				"rights"=>"Copyright © ".konf::get()->getKonfigTab('nazwa_www'),
				"date"=>time()
			));

			$rss->setLanguage(konf::get()->getKonfigTab('tab_lang',$dane['lang']));

	  	$query="SELECT id, data_start AS data, tytul, link, zajawka FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id_matka='".$dane['id']."' AND dostep!=3 ".$this->sqlAdd()." ORDER BY nr_poz,id";

			if(!empty($dane['na_str'])){
			 $query.=" LIMIT 0,".$dane['na_str'];
			}

			$zap=konf::get()->_bazasql->zap($query);
			while($dane2=konf::get()->_bazasql->fetchAssoc($zap)){

				if($dane['typ']!=2){
					if(!empty($dane2['link'])){
						if(!ereg("^http://",$dane2['link'])){
							$dane2['link']=konf::get()->getKonfigTab("sciezka").$dane2['link'];
						}
						$link=$dane2['link'];
					} else {
						$link=konf::get()->getKonfigTab("sciezka").konf::get()->zmienneLink("index.php",array("id_art"=>$dane2['id']));
					}
				} else {
					$link=konf::get()->getKonfigTab("sciezka").konf::get()->zmienneLink("index.php",array("id_art"=>$this->_artId));
				}
	  		$rss->dodaj(array(
	    		"about" => $link,
			    "title" => htmlspecialchars(strip_tags(trim($dane2['tytul'])))." (".$dane2['data'].")",
					"link" => $link,
	    		"category" => $dane['tytul'],
			    "subject" => "", // optional DC value
	    		"date" => mktime(substr($dane2['data'],11,2),substr($dane2['data'],14,2),substr($dane2['data'],17,2),substr($dane2['data'],5,2),substr($dane2['data'],8,2),substr($dane2['data'],0,4))
			  ));

			}
			konf::get()->_bazasql->freeResult($zap);

			echo $rss->zwrot();

		}
	}


  /**
   * rysuje mape podelementow
   * @param array $tab
   * @param int $key
   * @param int $glebokosc
   */
	public function mapaPodstrony($tab,$key,$glebokosc){

	  if(!empty($tab[$key])&&is_array($tab[$key])){
	    reset($tab[$key]);

	    echo "<ul>";
	    while(list($key2,$val2)=each($tab[$key])){
	      echo "<li><a ".$this->artLink($val2).">".$val2['tytul']."</a>";
	      $this->mapaPodstrony($tab,$key2,$glebokosc+1);
				echo "</li>";
	    }
	    echo "</ul>";
	  }

	}


  /**
   * rysuje mape
   */
	public function mapa(){

	  echo tab_nagl(konf::get()->langTexty("art_mapa"),1);

		$d_tab=konf::get()->getKonfigTab("art_konf",'d_tab');
		$typ_tab=konf::get()->getKonfigTab("art_konf",'typ_tab');

	  if(!empty($d_tab)&&is_array($d_tab)){

	  	echo "<tr><td class=\"tlo3\" id=\"art_mapa\"><br />";

	    $query1="";
			$query2="";

			$d_wyklucz=konf::get()->getKonfigTab("art_konf",'mapa_d_wyklucz');

	    while(list($key,$val)=each($d_tab)){
				if(!in_array($key,$d_wyklucz)){
		    	if($query1!=""){
	  	  		$query1.=",";
	    		}
	    		$query1.="'".$key."'";
				}
	    }

			$typy_wyklucz=konf::get()->getKonfigTab("art_konf",'mapa_typy_wyklucz');

	    while(list($key,$val)=each($typ_tab)){
				if(!in_array($key,$typy_wyklucz)){
		    	if($query2!=""){
	  	  		$query2.=",";
	    		}
	    		$query2.="'".$key."'";
				}
	    }

	    $query="SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id_d IN (".$query1.") AND typ IN (".$query2.") AND lang='".konf::get()->getLang()."' AND (dostep!=3 OR link!='') AND mapa_nie=0 ".$this->sqlAdd();

	    //puste tablice
	    $poziom0=array();
	    $poziomy=array();

	    //pobranie poziomu 0
	    $zap=konf::get()->_bazasql->zap($query." AND poziom=0  ORDER BY nr_poz,id");

	    while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
	      $poziom0[$dane['id_d']][$dane['id']]=$dane;
	    }
	    konf::get()->_bazasql->freeResult($zap);


	    //jesli byl poziom 0
	    if(!empty($poziom0)){

	      $query.=" AND id_matka!=0 AND poziom>0";
	      if(konf::get()->getKonfigTab("art_konf",'mapa_poziom_limit')){
	        $query.=" AND poziom<='".konf::get()->getKonfigTab("art_konf",'mapa_poziom_limit')."'";
	      }

	      //pobranie wyzszych poziomow
	      $zap=konf::get()->_bazasql->zap($query." ORDER BY nr_poz,id");
	      while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
	        $poziomy[$dane['id_matka']][$dane['id']]=$dane;
	      }

	      konf::get()->_bazasql->freeResult($zap);

	      //wyswietlaj poziomy

	      reset($poziom0);
	      //przelatujemy dzialy
	      while(list($key,$val)=each($poziom0)){
					echo "<ul>";
	        if(!empty($val)&&is_array($val)){
	          reset($val);
	          //przelatujemy poziom 1
	          while(list($key2,$val2)=each($val)){
	            echo "<li><a ".$this->artLink($val2).">".$val2['tytul']."</a>";

	            //podstrony
	            $this->mapaPodstrony($poziomy,$val2['id'],1);

							echo "</li>";
	          }
	        }
		      echo "</ul><br />";
	      }
	    }
	    echo "</td></tr>";

	  }

	  echo tab_stop();

	}


  /**
   * staty
   */
	public function statystyka(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE lang='".konf::get()->getLang()."' ".$this->sqlAdd();

		if(!konf::get()->getKonfigTab("art_konf",'stat_zero')){
			$query.=" AND licznik>0 ";
		}

		echo tab_nagl(konf::get()->langTexty("art_ogladalnosc"),1);

		if(konf::get()->getKonfigTab("art_konf",'stat_na_str')){

			$naw = new nawig("SELECT COUNT(id) AS ilosc ".$query,$podstrona,konf::get()->getKonfigTab("art_konf",'stat_na_str'));
			$naw->naw(konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"art_statystyka")));
			$podstrona=$naw->getPodstrona();

			$query.=" ORDER BY licznik DESC,id LIMIT ".$naw->getStart().",".$naw->getIle();

		} else {
			$query.=" ORDER BY licznik DESC,id";
			if(konf::get()->getKonfigTab("art_konf",'stat_max')){
				$query.=" LIMIT 0,".konf::get()->getKonfigTab("art_konf",'stat_max');
			}
		}

		$zap=konf::get()->_bazasql->zap("SELECT * ".$query);

		if(konf::get()->_bazasql->numRows($zap)>0){

			$max="";

			//pobiera max wartosc dla podstron
			if(konf::get()->getKonfigTab("art_konf",'stat_na_str')!=0&&$podstrona!=1){
				$query="SELECT MAX(licznik) AS licznik FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE licznik>0";
				if(!$this->admin()){
					$query.=" AND status=1";
				}
				$dane2=konf::get()->_bazasql->pobierzRekord($query);
				if(!empty($dane2)){
					$max=$dane2['licznik'];
				}
			}

			if(konf::get()->getKonfigTab("art_konf",'stat_na_str')){
				if($naw->getNaw()){
					echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
				}
			}

			echo "<tr><td class=\"tlo3 lewa\">";

			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){

				if(empty($max)){
					$max=$dane['licznik'];
					$rozmiar=konf::get()->getKonfigTab("art_konf",'stat_dl');
				} else {
					if(!empty($max)){
						$rozmiar=ceil($dane['licznik']/$max*konf::get()->getKonfigTab("art_konf",'stat_dl'));
					} else {
						$rozmiar=0;
					}
				}

				echo "<div style=\"padding-bottom:1px\"><a ".$this->artLink($dane).">".$dane['tytul']."</a></div>";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin-bottom:15px\"><tr><td>";
				if(!empty($rozmiar)){
					echo str_replace("[WIDTH]",$rozmiar,konf::get()->getKonfigTab('pasek_stat'));
				} else {
					echo "&nbsp;";
				}
				echo "</td><td>".$dane['licznik']."</td></tr></table>";
			}

			echo "</td></tr>";

			if(konf::get()->getKonfigTab("art_konf",'stat_na_str')){
				if($naw->getNaw()){
					echo "<tr><td colspan=\"".$colspan."\" class=\"tlo3 prawa\">".$naw->getNaw()."</td></tr>";
				}
			}

		}
		konf::get()->_bazasql->freeResult($zap);

		echo tab_stop();

	}


  /**
   * szukaj w art
   */
	public function szukaj(){

		$podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$art_szuk=tekstForm::doLike(konf::get()->getZmienna('art_szuk','art_szuk'));
		$colspan=1;

		echo "<h1>".konf::get()->langTexty("art_szuk_wyszuk")." ".$art_szuk."</h1>";


		if(empty($art_szuk)){
			echo "<div class=\"tlo3 srodek grube\" style=\"padding:10px\">".konf::get()->langTexty("art_szuk_brakfr")."</div>";
		} else if(strlen($art_szuk)<3){
			echo "<div class=\"tlo3 srodek grube\" style=\"padding:10px\">".konf::get()->langTexty("art_szuk_zakrotka")."</div>";
		} else {

			$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'art')." a LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'art_akapity')." t ON a.id=t.id_matka WHERE ((t.tresc LIKE '%".$art_szuk."%' AND t.status=1) OR a.tytul LIKE '%".$art_szuk."%' OR a.tytul_menu LIKE '%".$art_szuk."%') AND a.lang='".konf::get()->getLang()."' AND (a.data_start='0000-00-00 00:00:00' OR a.data_start<=NOW()) AND (a.data_stop='0000-00-00 00:00:00' OR a.data_stop>=NOW()) AND a.dostep!=3";

			if(!$this->admin()){
			  $query.=" AND a.status=1 ";
			}

			if($this->uprawniony()){
			  $query.=" AND a.dostep IN (0,1,2) ";
			} else if(user::get()->zalogowany()){
			  $query.=" AND a.dostep IN (0,1) ";
			} else {
			  $query.=" AND a.dostep=0 ";
			}

			$link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"art_szukaj","art_szuk"=>$art_szuk));

			$naw = new nawig("SELECT COUNT(a.id) AS ilosc ".$query,$podstrona,konf::get()->getKonfigTab("art_konf",'szuk_na_str'));
			$naw->naw($link2);
			$podstrona=$naw->getPodstrona();

			if($naw->getIle()>0){

				if($naw->getNaw()){
					echo "<div class=\"tlo3\">".$naw->getNaw()."</div>";
				}

				echo "<div class=\"tlo3 lewa\">";

			  $query.=" ORDER BY a.tytul";
				$zap=konf::get()->_bazasql->zap("SELECT a.*, t.tresc ".$query." LIMIT ".$naw->getStart().",".$naw->getIle());

				while($dane=konf::get()->_bazasql->fetchAssoc($zap)){

					echo "<div style=\"padding-bottom:7px\">";
					echo "<a class=\"grube\" ".$this->artLink($dane).">".$dane['tytul']."</a><br />";

					if(!empty($dane['tresc'])){

			      $dane['tresc']=strip_tags($dane['tresc']);

						if(konf::get()->getKonfigTab("art_konf",'szuk_max')>0){
							$tresc['start']=0;
							$tresc['ile']=konf::get()->getKonfigTab("art_konf",'szuk_max');
							$tresc['poz']=tekstForm::utf8Strpos($dane['tresc'],$art_szuk);
							$tresc['dlugosc']=tekstForm::utf8Strlen($dane['tresc']);
							if($tresc['poz']>=konf::get()->getKonfigTab("art_konf",'szuk_max')){
								$tresc['start']=$tresc['poz']-round(konf::get()->getKonfigTab("art_konf",'szuk_max')/2)+1;
							}
							if($tresc['dlugosc']<=($tresc['start']+konf::get()->getKonfigTab("art_konf",'szuk_max'))){
								$tresc['ile']=$tresc['dlugosc']-$tresc['start'];
							}
							$dane['tresc']=tekstForm::utf8Substr($dane['tresc'],$tresc['start'],$tresc['ile']);
							if($tresc['start']>0){
								$dane['tresc']="[...]&nbsp;".$dane['tresc'];
							}
							if($tresc['ile']==konf::get()->getKonfigTab("art_konf",'szuk_max')){
								$dane['tresc']=$dane['tresc']."&nbsp;[...]";
							}
						}

						$dane['tresc']=tekstForm::zlamStringa($dane['tresc'],45,false,false);

						echo $dane['tresc']=str_replace($art_szuk,"<span class=\"grube\">".$art_szuk."</span>",$dane['tresc']);

					}

					echo "<div style=\"padding-top:5px\"><hr /></div></div>";
				}
				konf::get()->_bazasql->freeResult($zap);
				echo "</div>";

				if($naw->getNaw()){
					echo "<div colspan=\"".$colspan."\" class=\"tlo3\">".$naw->getNaw()."</div>";
				}

			} else {
	    	echo "<div class=\"tlo3 srodek grube\" style=\"padding:10px\">".konf::get()->langTexty("art_szuk_nieodnaleziona")."</div>";
			}
	  }

	}

######################################################################################

	public function galeria(){

   $dane = $this->pobierzIdtf("galeria",true,true);
   $pierwszy = true;
   $pokapoka = 0;

   echo "<div class=\"gall_head\"><div style=\"float: left; padding-left: 425px; padding-top: 15px;\">GALERIA</div>";
   echo "<div style=\"float: right; text-align: left; padding-right: 60px; padding-top: 15px; font-size: 10px;\"><a href=\"index.php\">&raquo;&nbsp;STRONA GŁÓWNA</a><a href=\"index.php?akcja=art_galeria\">&nbsp;&raquo;&nbsp;GALERIA</a></div></div>";
   if(!empty($dane))
   {
   echo "<div class=\"left_columng\">";
   $zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id_matka='".$dane['id']."' AND lang='".konf::get()->getLang()."' ".$this->sqlAdd()." ORDER BY nr_poz");
     $i=0;
       while($dane2=konf::get()->_bazasql->fetchAssoc($zap)){
       if($pierwszy){
        $pokapoka = $dane2['id'];
        $pierwszy=false;
       }
       echo "<div class=\"single_gal\">";
        echo "<div class=\"gal_title\">";

                echo $dane2['tytul'];


            echo "</div>";


            echo "<div class=\"gal_tresc\">";

              echo $dane2['zajawka'];

            echo "</div>";

            echo "<div class=\"gal_link\">";
              echo "<a href=\"".konf::get()->getKonfigTab("sciezka")."index.php?akcja=art_galeria&amp;id_art=".$dane2['id']."\">GALERIA</a>";
            echo "</div>";
         echo "</div>";
       }
    echo "</div>";
   }




    echo "<div class=\"right_columng\">";
    $pobierz_galerie = "";
    echo "<table class=\"gallery_tab\"><tr><td style=\"vertical-align: middle; text-align: center;  height: 311px;\">";
    $art_id = konf::get()->getZmienna("id_art",'id_art');
    if(empty($art_id) && !empty($pokapoka)) $art_id = $pokapoka;
    $pic_id = konf::get()->getZmienna("pic_id",'pic_id');
    if(empty($pic_id)) $pic_id = 1;
    $zap2 = konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art_akapity')." WHERE id_matka='".$art_id."' AND status=1 ORDER BY id");
     //pobierz akapity
				while($dane2=konf::get()->_bazasql->fetchAssoc($zap2)){

					$dane_akapitow[$dane2['id']]=$dane2;
					if(!empty($pobierz_galerie)){
						$pobierz_galerie.=",";
					}
					$pobierz_galerie.="'".$dane2['id']."'";
				}
		 		konf::get()->_bazasql->freeResult($zap2);

				//pobierz galerie
				if(!empty($pobierz_galerie)&&konf::get()->getKonfigTab("sql_tab",'art_galeria')){

					require_once(konf::get()->getKonfigTab('klasy')."class.galeria.php");
          $i=0;
					$zap2=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art_galeria')." WHERE id_matka IN (".$pobierz_galerie.") AND status=1 AND obrobka=0 ORDER BY id_matka,nr_poz,id");
					while($dane2=konf::get()->_bazasql->fetchAssoc($zap2)){
            $i++;
						$galerie[$art_id][$i]=$dane2;

					}
			 		konf::get()->_bazasql->freeResult($zap2);
			 	}

        if(!empty($galerie))
        {
        if(!empty($pic_id) && !empty($art_id)){

          echo "<div><img src=\"".konf::get()->getKonfigTab('sciezka').konf::get()->getKonfigTab("art_konf",'galeria_kat').$galerie[$art_id][$pic_id]['img1_nazwa']."\" alt=\"\" /></div>";
        }

        echo "</td></tr><tr><td>";

          echo "<div style=\"padding-left: 50px; padding-right: 50px;\" id=\"bottom_img\">";
			 	while(list($key,$val)=each($galerie[$art_id])){

          echo "<a href=\"".konf::get()->getKonfigTab('sciezka')."index.php?akcja=art_galeria&amp;id_art=".$art_id."&amp;pic_id=".$key."\" ><img src=\"".konf::get()->getKonfigTab('sciezka').konf::get()->getKonfigTab("art_konf",'galeria_kat').$val['img2_nazwa']."\" alt=\"".htmlspecialchars($val['tytul'])."\" /></a>";

			 	}
          echo "</div>";

        }

      echo "</td></tr></table>";

    echo "</div>";
	}

	public function restauracja(){

    echo "<div class=\"left_column\">";

    $dane = $this->pobierzIdtf("r_left",true,true);
    if(!empty($dane))
    {
    $zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id_matka='".$dane['id']."' AND lang='".konf::get()->getLang()."' ".$this->sqlAdd()." ORDER BY nr_poz");
      $i=0;
        while($dane2=konf::get()->_bazasql->fetchAssoc($zap)){
          echo "<div class=\"single_left\">";

            echo "<div class=\"left_title\">";
              echo "<div style=\"padding-left: 50px;\">";
                echo $dane2['tytul'];
              echo "</div>";

            echo "</div>";

            echo "<div style=\" height:10px\"></div>";
            echo "<div class=\"left_tresc\">";
              echo "<div style=\"padding: 15px 30px 15px 30px\">";
              echo $dane2['zajawka'];
              echo "</div>";
            echo "</div>";

            echo "<div class=\"left_link\">";
              echo "<a ".$this->artLink($dane2).">&raquo;&nbsp;więcej</a>";
            echo "</div>";

          echo "</div>";
        }
    }

    konf::get()->_bazasql->freeResult($zap);
		echo "</div>";


    echo "<div class=\"right_column\">";
    echo "<div style=\"height: 40px; line-height: 40px; padding-left: 30px;\">";
      echo "<a href=\"index.php\">&raquo;&nbsp;STRONA GŁÓWNA</a>";
      echo "</div>";
    $dane = $this->pobierzIdtf("r_right",true,true);
    if(!empty($dane))
    {
    $zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id_matka='".$dane['id']."' AND lang='".konf::get()->getLang()."' ".$this->sqlAdd()." ORDER BY nr_poz");
      $i=1;
        while($dane2=konf::get()->_bazasql->fetchAssoc($zap)){
          echo "<div class=\"single_right\">";
           echo "<table cellpadding=\"0\" cellspacing=\"0\"  onclick='javascript:document.location.";

            echo $this->artLink($dane2);

            echo ";' onmouseover=\"this.style.cursor='pointer';\"><tr>";
           echo "<td class=\"right_title\"><div style=\"padding-left: 10px;\">".$dane2['tytul']."<br/><span style=\"font-size: 22px\">0".$i."</span></div></td>";

           echo "<td class=\"right_pic\">";
             echo $dane2['zajawka'];
           echo "</td>";

           echo "<td class=\"right_link\"><div style=\"padding: 13px;\"><a ".$this->artLink($dane2).">&raquo;&nbsp;więcej</a></div></td>";
           echo "</tr></table>";
          echo "</div>";
          $i++;
        }
    }

		echo "</div>";

	}


	public function oferta(){

    echo "<div class=\"left_column\">";

    $dane = $this->pobierzIdtf("o_left",true,true);
    if(!empty($dane))
    {
    $zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id_matka='".$dane['id']."' AND lang='".konf::get()->getLang()."' ".$this->sqlAdd()." ORDER BY nr_poz");
      $i=0;
        while($dane2=konf::get()->_bazasql->fetchAssoc($zap)){
          echo "<div class=\"single_left\">";

            echo "<div class=\"left_title\">";
              echo "<div style=\"padding-left: 50px;\">";
                echo $dane2['tytul'];
              echo "</div>";

            echo "</div>";

            echo "<div style=\" height:10px\"></div>";
            echo "<div class=\"left_tresc\">";
              echo "<div style=\"padding: 15px 30px 15px 30px\">";
              echo $dane2['zajawka'];
              echo "</div>";
            echo "</div>";

            echo "<div class=\"left_link\">";
              echo "<a ".$this->artLink($dane2).">&raquo;&nbsp;więcej</a>";
            echo "</div>";

          echo "</div>";
        }
    }

    konf::get()->_bazasql->freeResult($zap);
		echo "</div>";


    echo "<div class=\"right_column\">";
    echo "<div style=\"height: 40px; line-height: 40px; padding-left: 30px;\">";
       $dane_t = $this->pobierz($dane['id_matka']);
      echo "<a href=\"index.php\">&raquo;&nbsp;STRONA GŁÓWNA</a><a href=\"index.php?akcja=art_oferta\" style=\"text-transform: uppercase\">&nbsp;&raquo;&nbsp;".$dane_t['tytul']."</a>";

    echo "</div>";
    $dane = $this->pobierzIdtf("o_right",true,true);
    if(!empty($dane))
    {
   echo "<div class=\"right_column\">";
    echo "<div style=\"height: 40px; line-height: 40px; padding-left: 30px;\">";

       echo "</div>";

      echo "<div style=\"text-align: center; padding-top: 20px;\">";
        echo $dane['zajawka'];
          echo "</div>";
		echo "</div>";
		}

		echo "</div>";

	}


	public function pokoje(){

    echo "<div class=\"left_column\">";

    $dane = $this->pobierzIdtf("p_left",true,true);
    if(!empty($dane))
    {
    $zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id_matka='".$dane['id']."' AND lang='".konf::get()->getLang()."' ".$this->sqlAdd()." ORDER BY nr_poz");
      $i=0;
        while($dane2=konf::get()->_bazasql->fetchAssoc($zap)){
          echo "<div class=\"single_left\">";

            echo "<div class=\"left_title\">";
              echo "<div style=\"padding-left: 50px;\">";
                echo $dane2['tytul'];
              echo "</div>";

            echo "</div>";

            echo "<div style=\" height:10px\"></div>";
            echo "<div class=\"left_tresc\">";
              echo "<div style=\"padding: 15px 30px 15px 30px\">";
              echo $dane2['zajawka'];
              echo "</div>";
            echo "</div>";

            echo "<div class=\"left_link\">";
              echo "<a ".$this->artLink($dane2).">&raquo;&nbsp;więcej</a>";
            echo "</div>";

          echo "</div>";
        }
    }

    konf::get()->_bazasql->freeResult($zap);
		echo "</div>";


    echo "<div class=\"right_column\">";
    echo "<div style=\"height: 40px; line-height: 40px; padding-left: 30px;\">";
       $dane_t = $this->pobierz($dane['id_matka']);
      echo "<a href=\"index.php\">&raquo;&nbsp;STRONA GŁÓWNA</a><a href=\"index.php?akcja=art_pokoje\" style=\"text-transform: uppercase\">&nbsp;&raquo;&nbsp;".$dane_t['tytul']."</a>";

    echo "</div>";
    $dane = $this->pobierzIdtf("p_right",true,true);
    if(!empty($dane))
    {
   echo "<div class=\"right_column\">";
    echo "<div style=\"height: 40px; line-height: 40px; padding-left: 30px;\">";

       echo "</div>";

      echo "<div style=\"text-align: center; padding-top: 20px;\">";
        echo $dane['zajawka'];
          echo "</div>";
		echo "</div>";
		}

		echo "</div>";

	}





	public function kontakt(){

  $dane = $this->pobierzIdtf("kontakt_left",true,true);
    echo "<div class=\"left_column\">";

        echo "<div class=\"single_left\">";
          echo "<div style=\"height: 40px; line-height: 36px; font-size: 16px; text-align: center\">KONTAKT</div>";
          echo "<div style=\"text-align: center; padding-top: 20px;\">";
        echo $dane['zajawka'];
          echo "</div>";
          echo "</div>";
        echo "</div>";


		echo "</div>";

  $dane = $this->pobierzIdtf("kontakt_right",true,true);
    echo "<div class=\"right_column\">";
    echo "<div style=\"height: 40px; line-height: 40px; padding-left: 30px;\">";
      $dane_t = $this->pobierz($dane['id_matka']);
      echo "<a href=\"index.php\">&raquo;&nbsp;STRONA GŁÓWNA</a><a href=\"index.php?akcja=art_kontakt\" style=\"text-transform: uppercase\">&nbsp;&raquo;&nbsp;".$dane_t['tytul']."</a>";

       echo "</div>";

      echo "<div style=\"text-align: center; padding-top: 20px;\">";
        echo $dane['zajawka'];
          echo "</div>";
		echo "</div>";

	}


	public function menu(){

    echo "<div class=\"left_column\">";

    $dane = $this->pobierzIdtf("m_left",true,true);
    if(!empty($dane))
    {
    $zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id_matka='".$dane['id']."' AND lang='".konf::get()->getLang()."' ".$this->sqlAdd()." ORDER BY nr_poz");
      $i=0;
        while($dane2=konf::get()->_bazasql->fetchAssoc($zap)){
          echo "<div class=\"singlem_left\">";

            echo "<div class=\"leftm_title\">";
              echo "<div style=\"padding-left: 115px;\">";
                echo $dane2['tytul'];
              echo "</div>";

            echo "</div>";


            echo "<div class=\"left_tresc\">";
              echo "<div style=\"padding: 4px 30px 15px 30px\">";
              echo $dane2['zajawka'];
              echo "</div>";
            echo "</div>";

            echo "<div class=\"left_link\" style=\"padding-bottom: 15px;\">";
              echo "<a ".$this->artLink($dane2).">&raquo;&nbsp;więcej</a>";
            echo "</div>";

          echo "</div>";
        }
    }

    konf::get()->_bazasql->freeResult($zap);
		echo "</div>";


    echo "<div class=\"right_column\">";
    echo "<div style=\"height: 40px; line-height: 40px; padding-left: 30px;\">";
       $dane_t = $this->pobierz($dane['id_matka']);
      echo "<a href=\"index.php\">&raquo;&nbsp;STRONA GŁÓWNA</a><a href=\"index.php?akcja=art_menu\" style=\"text-transform: uppercase\">&nbsp;&raquo;&nbsp;".$dane_t['tytul']."</a>";
    echo "</div>";
    echo "<div class=\"menu_head\">MENU</div>";
    $dane = $this->pobierzIdtf("m_right",true,true);
    if(!empty($dane))
    {
    $zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'art')." WHERE id_matka='".$dane['id']."' AND lang='".konf::get()->getLang()."' ".$this->sqlAdd()." ORDER BY nr_poz");
      $i=1;
        while($dane2=konf::get()->_bazasql->fetchAssoc($zap)){
          echo "<div class=\"single_right\">";
           echo "<table cellpadding=\"0\" cellspacing=\"0\"  onclick='javascript:document.location.";

            echo $this->artLink($dane2);

            echo ";' onmouseover=\"this.style.cursor='pointer';\"><tr>";
           echo "<td class=\"right_title\"><div style=\"padding-left: 10px;\">".$dane2['tytul']."<br/><span style=\"font-size: 22px\">0".$i."</span></div></td>";

           echo "<td class=\"right_pic\">";
             echo $dane2['zajawka'];
           echo "</td>";

           echo "<td class=\"right_link\"><div style=\"padding: 13px;\"><a ".$this->artLink($dane2).">&raquo;&nbsp;więcej</a></div></td>";
           echo "</tr></table>";
          echo "</div>";
          $i++;
        }
    }

		echo "</div>";

	}

	public function powitalna(){

		$this->restauracja();

	}

	/**
   * class constructor php5
   */
	public function __construct() {

		$this->_admin=konf::get()->getKonfigTab("art_konf",'admin_art');
		$this->_uprawniony=konf::get()->getKonfigTab("art_konf",'uprawniony_art');
		$this->_artId=konf::get()->getZmienna("id_art",'id_art');

  }


}

?>