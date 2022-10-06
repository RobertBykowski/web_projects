<?php
//podstawowe funkcje do księgi gości

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}


class forum extends modul {

	/**
	 * Privates variables
	 */

	/**
	 * nazwa klasy
	 */				
  protected $_nazwaKlasy="forum class";

	
	/**
	 * bierzacy dzial
	 */				
  private $d_nr="";		
		
	
	/**
	 * bierzacy temat
	 */				
  private $t_nr="";			

	/**	
   * forum view
   */		
	public function zobacz(){

	  if(empty($this->t_nr)){
			$this->start();
	  } else {
	    $this->wyswietlp();
	  } 
		
	}

	
  /**
   * czy mozna dodawac jpg
   * @return bool				
   */	
	public function czyJpg(){

		$ok=true;
		
		if(!$this->admin()&&konf::get()->getKonfigTab("forum_konf",'img_limit')){
			if(konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'forum_p')." WHERE img!='0' AND id_autor='".user::get()->id()."' AND data>'".tekstForm::dniData(30,"d","-")."'")>=konf::get()->getKonfigTab("forum_konf",'img_limit')){
				$ok=false;
			}
		}
		
		return $ok;
		
	}

	
  /**
   * user dane
   * @param bool $wys
   * @param int $id
   * @param string $login
   * @param string $pliczek		
   * @return string
   */	
	public function userDane($wys,$id,$login,$pliczek){

		$html="";
		
		if($wys&&!empty($id)&&!empty($login)){
			$html.="<a href=\"".konf::get()->zmienneLink($pliczek,array("akcja"=>"u_dane","id_u"=>$id))."\">".$login."</a>";
		} else { 
			$html.=$login; 
		}
		
		return $html;
		
	}

  /**
   * cite format
   * @param string $fraza
   * @return string
   */	
	public function cytat($fraza){

		$fraza=addslashes($fraza);
	  $fraza=strip_tags($fraza);
	  $fraza=str_replace(array("\n","\r",konf::get()->getKonfigTab("forum_konf",'img_symbol')),array("\\n","",""),$fraza);
		$fraza=htmlspecialchars($fraza);
		
	  return $fraza;
		
	}

	
  /**
   * post format
   * @param array $dane
   * @return string
   */	
	public function tresc($dane){

		$dane['tresc']=strip_tags($dane['tresc'],konf::get()->getKonfigTab("forum_konf",'zostaw_tagi'));
		
		if(konf::get()->getKonfigTab("forum_konf",'bbcode')){
			$dane['tresc']=tekstForm::bbForm($dane['tresc'],true,true,konf::get()->getKonfigTab("forum_konf",'linia_znakow'));
			$dane['tresc']=tekstForm::doWys($dane['tresc']);
		} else {
		  $dane['tresc']=tekstForm::zlamStringa($dane['tresc'],konf::get()->getKonfigTab("forum_konf",'linia_znakow'),true,konf::get()->getKonfigTab("forum_konf",'autolink'));
		}
		
		if(konf::get()->getKonfigTab("forum_konf",'emotikony')){
			$emotikony=new emotikony();
	    $dane['tresc']=$emotikony->rysuj($dane['tresc']);
		}
		
		$img_zam="";
		
		if($dane['img']&&konf::get()->getKonfigTab("forum_konf",'img_symbol')&&konf::get()->getKonfigTab("forum_konf",'img_kat')){
			if(file_exists(konf::get()->getKonfigTab("forum_konf",'img_kat').$dane['img1_nazwa'])){ 
				$img_zam="<div class=\"srodek\" style=\"padding:3px;\"><img src=\"".konf::get()->getKonfigTab("forum_konf",'img_kat').$dane['img1_nazwa']."\" width=\"".$dane['img1_w']."\" height=\"".$dane['img1_h']."\"alt=\"\" /></div>";
			}
		}
		if(konf::get()->getKonfigTab("forum_konf",'img_symbol')){
			$dane['tresc']=str_replace(konf::get()->getKonfigTab("forum_konf",'img_symbol'),$img_zam,$dane['tresc']);
		}
		
		return $dane['tresc'];
		
	}


  /**
   * post search format
   * @param string $tresc
   * @param string $fraza	
   * @param string $kat		
   * @return string
   */		
	public function trescSzukaj($tresc,$fraza,$kat){

		$max_pol=ceil(konf::get()->getKonfigTab("forum_konf",'szukaj_dl')/2);
		
		$tresc=strip_tags($tresc);
		$tresc=str_replace(array(konf::get()->getKonfigTab("forum_konf",'img_symbol')),array(""),$tresc);
		
		$dl=strlen($tresc);
			
		if($dl>konf::get()->getKonfigTab("forum_konf",'szukaj_dl')){
			$start=0;
			$stop=konf::get()->getKonfigTab("forum_konf",'szukaj_dl');
			if($kat=="tresc"){
				$pos=strpos($tresc,$fraza);
				if($pos>$max_pol){
					$start=$pos-$max_pol;
				}
				$pos=$pos+strlen($fraza);
				if(($pos+$max_pol)<($dl-1)){
					$stop=$pos+$max_pol;
				}	else { $stop=$dl-1-$pos; }		
			}
			$tresc=substr($tresc,$start,$stop-$start);
			if($start>0){ $tresc="...".$tresc; }
			if($stop<$dl){ $tresc.="..."; }
		}

		if($kat=="tresc"){
			$tresc=str_replace($fraza," <b>".$fraza."</b> ",$tresc);
		}

	  $tresc=tekstForm::zlamStringa($tresc,konf::get()->getKonfigTab("forum_konf",'linia_znakow'),true,false);

		return $tresc;
		
	}


  /**
   * count posts
   * @param int $t_nr
   * @return int
   */		
	public function policzT($t_nr){

		$query="";
		if(!$this->admin()){ 
			$query=" AND status IN(1,2,3)"; 
		}
		$ile=konf::get()->_bazasql->policz("id","FROM ".konf::get()->getKonfigTab("sql_tab",'forum_p')." WHERE id_t='".$t_nr."'".$query);

		if($ile>0){ 
			$ile--; 
		} else { 
			$ile=0; 
		}
		
		return $ile;
		
	}


  /**
   * return theme status
   * @param int $t_nr
   * @return int
   */		
	public function statusT($t_nr){

		$status=0;
		
		if(!empty($t_nr)){
			$dane=konf::get()->_bazasql->pobierzRekord("SELECT status FROM ".konf::get()->getKonfigTab("sql_tab",'forum_t')." WHERE id='".$t_nr."'");
			if(!empty($dane['status'])){
				$status=$dane['status'];
			}			
		}
		
		return $status;
		
	}


  /**
   * return category status
   * @param int $d_nr
   * @return int
   */	
	public function statusD($d_nr){

		$status=0;	
		
		if(!empty($d_nr)){
			$dane=konf::get()->_bazasql->pobierzRekord("SELECT status FROM ".konf::get()->getKonfigTab("sql_tab",'forum_d')." WHERE id='".$d_nr."'");
			if(!empty($dane['status'])){
				$status=$dane['status'];
			}						
		}
		
		return $status;
		
	}


  /**
   * return category status
   * @param string $naw
   * @return string
   */	
	public function menu($naw) {

		$html="<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"width:100%\"><tr class=\"srodek\">";
		
		if(konf::get()->getKonfigTab("forum_konf",'wys_d')){
		  $html.="<td style=\"width:100px;\">[<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"forum_zobacz"))."\"><span class=\"grube\">".konf::get()->langTexty("forum_kategorie")."</span></a>]</td>";
		}
		
		if(!empty($this->d_nr)){
			$html.="<td style=\"width:100px;\">[<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"forum_zobacz","d_nr"=>$this->d_nr))."\"><span class=\"grube\">".konf::get()->langTexty("forum_tematy")."</span></a>]</td>";
		}
		
		if(konf::get()->getKonfigTab("forum_konf",'nowy_t_dostep')){
			$html.="<td style=\"width:120px;\">[<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"forum_dodajt","d_nr"=>$this->d_nr))."\"><span class=\"grube nobr\">".konf::get()->langTexty("forum_nowyt")."</span></a>]</td>";
		}
		if(konf::get()->getKonfigTab("forum_konf",'wys_stat')){
			$html.="<td style=\"width:80px;\">[<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"forum_staty","d_nr"=>$this->d_nr))."\"><span class=\"grube nobr\">".konf::get()->langTexty("forum_stat")."</span></a>]</td>";
		}
		
		if(konf::get()->getKonfigTab("forum_konf",'akcja_log')&&!user::get()->zalogowany()) { 
			$html.="<td style=\"width:120px;\">[<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>konf::get()->getKonfigTab("forum_konf",'akcja_log'),"redir"=>base64_encode("index.php?akcja=forum_zobacz")))."\"><span class=\"grube nobr\">".konf::get()->langTexty("forum_zaloguj")."</span></a>]</td>";
		} else if($this->admin()){ 
			$html.="<td style=\"width:150px;\">[<a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"forum_dodajd"))."\"><span class=\"grube nobr\">".konf::get()->langTexty("forum_katadmin")."</span></a>]</td>";
		}

		if($naw=="g"){ 
			$html.="<td class=\"prawa\"><a href=\"#d\"><span class=\"nobr\">".konf::get()->langTexty("forum_dol")."&gt;&gt;</span></a><a name=\"g\">&nbsp;</a></td>";
		} else if($naw=="d"){
			$html.="<td class=\"prawa\"><a href=\"#g\"><span class=\"nobr\">".konf::get()->langTexty("forum_gora")."&gt;&gt;</span></a><a name=\"d\">&nbsp;</a></td>"; 
		}
		
		$html.="</tr></table>";
		
		return $html;
	}


  /**
   * naglowek
   * @param string $tytul
   * @param int $colspan
   */		
	public function naglowek($tytul,$colspan=""){

		echo tab_nagl(konf::get()->langTexty("forum_tyt"),$colspan);
		
		echo "<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'naglowek_class')."\" ";	
		if(!empty($colspan)){
			echo " colspan=\"".$colspan."\"";
		}
		echo ">";
		echo $this->menu("g");
		echo "</td></tr>";
			
		if(!empty($tytul)){
			echo "<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'tytul_class')."\" ";
			if(!empty($colspan)){
				echo " colspan=\"".$colspan."\"";
			}
			echo ">".$tytul."</td></tr>";
		}
		
	}


  /**
   * stopka
   * @param int $colspan
   */			
	public function stopka($colspan=""){

		echo "<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'naglowek_class')."\" ";	
		if(!empty($colspan)){
			echo " colspan=\"".$colspan."\"";
		}
		echo ">";
		echo $this->menu("d");
		echo "</td></tr>";
		echo tab_stop();
		
	}

	
  /**
   * return subpage number
   * @param int $postow
   * @param int $na_str
   * @return int	
   */			
	public function oblPodstrona($postow,$na_str){

		$stron=1;
		
		if(!empty($na_str)&&$postow>$na_str){
			$stron=ceil($postow/$na_str);
		}
		
		return $stron;
		
	}


  /**
   * forum stats
   */		
	public function staty(){

		$query=""; 
		if(!$this->admin()){ 
			$query=" AND status IN(1,2,3)"; 
		} 
		
		if(konf::get()->getKonfigTab("forum_konf",'wys_stat')){
			
			$this->naglowek(konf::get()->langTexty("forum_stat_tyt"),2);
			echo "<tr><td class=\"tlo4 grube\" colspan=\"2\">".konf::get()->langTexty("forum_stat_ogol")."</td></tr>";
			echo "<tr><td class=\"tlo3\">".konf::get()->langTexty("forum_stat_iled")."</td><td class=\"tlo3 prawa\" style=\"width:80px\">".konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'forum_d')." WHERE 1".$query)."</td></tr>";
			echo "<tr><td class=\"tlo3\">".konf::get()->langTexty("forum_stat_ilet")."</td><td class=\"tlo3 prawa\">".konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'forum_t')." WHERE 1".$query)."</td></tr>";
			echo "<tr><td class=\"tlo3\">".konf::get()->langTexty("forum_stat_ilep")."</td><td class=\"tlo3 prawa\">".konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'forum_p')." WHERE 1".$query)."</td></tr>";
			if(konf::get()->getKonfigTab("forum_konf",'img')){
				echo "<tr><td class=\"tlo3\">".konf::get()->langTexty("forum_stat_ilejpg")."</td><td class=\"tlo3 prawa\">".konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'forum_p')." WHERE 1 AND img!='0'".$query)."</td></tr>";	
			}
			if(konf::get()->getKonfigTab("forum_konf",'licznik')){
				$dane=konf::get()->_bazasql->pobierzRekord("SELECT SUM(licznik) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'forum_t')." WHERE 1".$query);
				echo "<tr><td class=\"tlo3\">".konf::get()->langTexty("forum_stat_wys")."</td><td class=\"tlo3 prawa\">".$dane['ile']."</td></tr>";	
			}
			echo "<tr><td class=\"tlo3\">".konf::get()->langTexty("forum_stat_iledyskutantow")."</td><td class=\"tlo3 prawa\">".konf::get()->_bazasql->policz("DISTINCT autor"," FROM ".konf::get()->getKonfigTab("sql_tab",'forum_p')." WHERE 1".$query)."</td></tr>";

			echo "<tr><td class=\"tlo4 grube\" colspan=\"2\">".konf::get()->langTexty("forum_stat_najczesciej")."</td></tr>"; 
			$zap=konf::get()->_bazasql->zap("SELECT id_autor, autor, COUNT(id) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'forum_p')." WHERE 1".$query." GROUP BY autor ORDER BY ile DESC LIMIT 0,10");
			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
				echo "<tr><td class=\"tlo3\">".$this->userDane(konf::get()->getKonfigTab("forum_konf",'user_dane'),$dane['id_autor'],$dane['autor'],konf::get()->getKonfigTab("plik"))."</td><td class=\"tlo3 prawa\">".$dane['ile']."</td></tr>";	
			}
			konf::get()->_bazasql->freeResult($zap);
			
			echo "<tr><td class=\"tlo4 grube\" colspan=\"2\">".konf::get()->langTexty("forum_stat_najwiekszet")."</td></tr>"; 
			$zap=konf::get()->_bazasql->zap("SELECT id_t, COUNT(id) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'forum_p')." WHERE 1".$query." GROUP BY id_t ORDER BY ile DESC LIMIT 0,10");
			$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"forum_zobacz"));
			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
				$zap2=konf::get()->_bazasql->zap("SELECT temat FROM ".konf::get()->getKonfigTab("sql_tab",'forum_t')." WHERE 1 AND id='".$dane['id_t']."'".$query);
				if(konf::get()->_bazasql->numRows($zap2)>0){
					$dane2=konf::get()->_bazasql->fetchAssoc($zap2);
					echo "<tr><td class=\"tlo3\">";
					echo "<a href=\"".$link."&amp;t_nr=".$dane['id_t'];
		      if(konf::get()->getKonfigTab("forum_konf",'najnowszy')){
		        $t_podstrona=$this->oblPodstrona($dane['ile'],konf::get()->getKonfigTab("forum_konf",'p_na_str'));
		        if(!empty($t_podstrona)&&$t_podstrona>1){
		          echo "&amp;podstrona=".$t_podstrona;
		        }
		        echo "#d"; 
		      }
		      echo "\">".tekstForm::zlamStringa($dane2['temat'],40,true,false)."</a>"; 				
		 			echo "</td><td class=\"tlo3 prawa\">".$dane['ile']."</td></tr>";	
		 		}
				konf::get()->_bazasql->freeResult($zap2);
			}
			konf::get()->_bazasql->freeResult($zap);
			
			if($this->admin()){
				echo "<tr><td class=\"tlo4 grube\" colspan=\"2\">".konf::get()->langTexty("forum_stat_host")."</td></tr>"; 
				$zap=konf::get()->_bazasql->zap("SELECT host, COUNT(id) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'forum_p')." WHERE 1".$query." GROUP BY host ORDER BY ile DESC LIMIT 0,10");
				while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
					echo "<tr><td class=\"tlo3\">".$dane['host']."</td><td class=\"tlo3 prawa\">".$dane['ile']."</td></tr>";	
				}
				konf::get()->_bazasql->freeResult($zap);	
				
				echo "<tr><td class=\"tlo4 grube\" colspan=\"2\">".konf::get()->langTexty("forum_stat_ip")."</td></tr>"; 
				$zap=konf::get()->_bazasql->zap("SELECT ip, COUNT(id) AS ile FROM ".konf::get()->getKonfigTab("sql_tab",'forum_p')." WHERE 1".$query." GROUP BY ip ORDER BY ile DESC LIMIT 0,10");
				while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
					echo "<tr><td class=\"tlo3\">".$dane['ip']."</td><td class=\"tlo3 prawa\">".$dane['ile']."</td></tr>";
				}
				konf::get()->_bazasql->freeResult($zap);	
			}
			
			$this->stopka(2);
			$this->wyszukiwarka();
		}
		 			
	}


  /**
   * search engine
   */	
	public function wyszukiwarka(){

	  $szukaj_fraza=konf::get()->getZmienna('szukaj_fraza','szukaj_fraza');
	  $szukaj_czas=konf::get()->getZmienna('szukaj_czas','szukaj_czas');
	  $szukaj_kat=konf::get()->getZmienna('szukaj_kat','szukaj_kat');

		if(konf::get()->getKonfigTab("forum_konf",'wys_szukaj')||konf::get()->getKonfigTab("forum_konf",'wys_legenda')){
		
		 	echo tab_nagl("",""); 
			if(konf::get()->getKonfigTab("forum_konf",'wys_szukaj')){
				echo "<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'naglowek_class')." male grube\">".konf::get()->langTexty("forum_wyszuk")."</td></tr>";
				echo "<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'tresc_class')."\">";

				?><script type="text/javascript">
				
				function spr_formszuk(){
				
					if(document.forum_szukaj.szukaj_fraza.value.length<3){ 
						form_set_error("szukaj_fraza",'<?php echo htmlspecialchars(konf::get()->langTexty("forum_wyszuk_zakrotka")); ?>');						
					}
					
				}
				
				</script><?php				
				
				$form4=new formularz("post",konf::get()->getKonfigTab("plik"),"forum_szukaj","forum_szukaj");
				echo $form4->spr(array(1=>"szukaj_fraza"),"","spr_formszuk();");
				echo $form4->getFormp();
				echo $form4->przenies(array("akcja"=>"forum_szukaj"));

		    echo "<div class=\"male\"><div class=\"grube\">&nbsp; ".konf::get()->langTexty("forum_wyszuk_fraza")." ";
				echo $form4->input("text","szukaj_fraza","szukaj_fraza",$szukaj_fraza,"f_sredni",50);
				echo "&nbsp;&nbsp;&nbsp;&nbsp;";
	  	  echo konf::get()->langTexty("forum_wyszuk_wsrod")." &nbsp;&nbsp;";
				
				echo $form4->select("szukaj_czas","szukaj_czas",
					array(
				    0=>konf::get()->langTexty("forum_wyszuk_wszystkich"),
			  	  7=>konf::get()->langTexty("forum_wyszuk_zost")." 7 ".konf::get()->langTexty("forum_wyszuk_zostdni"),
			  	  30=>konf::get()->langTexty("forum_wyszuk_zost")." 30 ".konf::get()->langTexty("forum_wyszuk_zostdni"),
			  	  90=>konf::get()->langTexty("forum_wyszuk_zost")." 90 ".konf::get()->langTexty("forum_wyszuk_zostdni"),
			  	  365=>konf::get()->langTexty("forum_wyszuk_zost")." 365 ".konf::get()->langTexty("forum_wyszuk_zostdni")
					),
				$szukaj_czas,"f_sredni");
		
				echo "&nbsp;&nbsp;&nbsp;";
				echo $form4->input("submit","","",konf::get()->langTexty("forum_wyszuk_szukaj"),"formularz2 f_krotki");					
				echo "</div>";
				
				echo "<div>";
		    echo "&nbsp;<span class=\"grube\">".konf::get()->langTexty("forum_wyszuk_wpolu")."</span>&nbsp;&nbsp;";

				$szuk_kat_tab=array(
					"imie"=>konf::get()->langTexty("forum_wyszuk_autor")."&nbsp;&nbsp;",
					"temat"=>konf::get()->langTexty("forum_wyszuk_tytul")."&nbsp;&nbsp;",				
					"tresc"=>konf::get()->langTexty("forum_wyszuk_tresc")."&nbsp;&nbsp;"				
				);	
				
		    if($this->admin()){	
					$szuk_kat_tab['host']=konf::get()->langTexty("forum_wyszuk_host")."&nbsp;&nbsp;";
					$szuk_kat_tab['ip']=konf::get()->langTexty("forum_wyszuk_ip")."&nbsp;&nbsp;";						
				}		
							
				echo $form4->radioTab($szuk_kat_tab,$szukaj_kat,"szukaj_kat","liniowy");
				
	   	 	echo "</div></div>";
				echo $form4->getFormk();
				echo "</td></tr>";
			}

			if(konf::get()->getKonfigTab("forum_konf",'wys_legenda')){
				echo "<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'tresc_class')." male\">";
				echo "<span class=\"grube\">".konf::get()->langTexty("forum_wyszuk_uwaga")."</span> ".konf::get()->langTexty("forum_wyszuk_redakcja")."<br />";
				echo konf::get()->langTexty("forum_wyszuk_zastrzegamy")."<br /><br />";
			
				$typy_tab=konf::get()->getKonfigTab("forum_konf",'typy_tab');
				if(!empty($typy_tab)&&is_array($typy_tab)){
					echo konf::get()->langTexty("forum_wyszuk_legenda")."<br />";
					while(list($key,$val)=each($typy_tab)){
						echo $val['ikonka']." ".$val['opis']."<br />";
					}
				}
				echo "</td></tr>";
			}	
			echo tab_stop();
		}
	}

	
  /**
   * search
   */		
	public function szukaj(){

	  $szukaj_fraza=konf::get()->getZmienna('szukaj_fraza','szukaj_fraza');
	  $szukaj_czas=konf::get()->getZmienna('szukaj_czas','szukaj_czas');
	  $szukaj_kat=konf::get()->getZmienna('szukaj_kat','szukaj_kat');
	  $podstrona=konf::get()->getZmienna('podstrona','podstrona');
		  
	  $na_str=20;
	  
	  if(empty($szukaj_kat)){ 
			$szukaj_kat="tresc"; 
		}
		
		if(konf::get()->getKonfigTab("forum_konf",'wys_szukaj')){
		  $this->naglowek(konf::get()->langTexty("forum_wyszuk_wyszukiwanie"),1);
		  
		  if(strlen($szukaj_fraza)>2){
		     
			  $link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"forum_zobacz"));
				$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"forum_szukaj","szukaj_fraza"=>$szukaj_fraza,"szukaj_kat"=>$szukaj_kat,"szukaj_czas"=>$szukaj_czas));
				
	  		$szukaj_fraza=tekstForm::doLike($szuk_fraza);	
			  
				$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'forum_p')." p LEFT JOIN ".konf::get()->getKonfigTab("sql_tab",'forum_t')." t ON p.id_t=t.id WHERE 1 ";
				if(!$this->admin()){
					$query.=" AND p.status IN(1,2,3) AND t.status IN(1,2,3)";
				}
			
				switch($szukaj_kat){
				
					case 'imie':
						$query.=" AND p.autor='".$szukaj_fraza."'";
					break;
			
					case 'ip':
						$query.=" AND p.ip='".$szukaj_fraza."'";
					break;
				
					case 'host':
						$query.=" AND p.host='".$szukaj_fraza."'";
					break;
				
					case 'temat':
						$query.=" AND t.temat LIKE '%".$szukaj_fraza."%'";
					break;		
				
					default:
						$query.=" AND p.tresc LIKE '%".$szukaj_fraza."%'";
				}
				
				if(!empty($szukaj_czas)&&($szukaj_czas=="7"||$szukaj_czas=="30"||$szukaj_czas=="90"||$szukaj_czas=="365")){ 
					$query.=" AND p.data>='".tekstForm::dniData($szukaj_czas,"d","-")."' ";
				}

				$naw = new nawig("SELECT COUNT(p.id) AS ilosc ".$query,$podstrona,$na_str);		
				$naw->naw($link);
				$podstrona=$naw->getPodstrona();				

				echo "<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'naglowek_class')." lewa\">".konf::get()->langTexty("forum_wyszuk_wfraza")." <span class=\"grube\">".$szukaj_fraza."</span></td></tr>";
				
				if($naw->getIle()>0){

					if($naw->getNaw()){
						echo "<tr><td colspan=\"".$colspan."\" class=\"".konf::get()->getKonfigTab("forum_konf",'tresc_class')."\">".$naw->getNaw()."</td></tr>";
					}					

				  $query="SELECT p.*, t.temat ".$query." ORDER BY p.data DESC, p.id DESC";
		  		if(konf::get()->getKonfigTab("forum_konf",'p_na_str')){
		    		$query.=" LIMIT ".$naw->getStart().",".$naw->getIle();
				  }     
		  		$zap=konf::get()->_bazasql->zap($query);
		  		$query="";
					
					require_once(konf::get()->getKonfigTab('klasy')."class.emotikony.php");						
		  		
			  	while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
			  	  echo "<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'tresc_class')."\">";
			  	  if(konf::get()->getKonfigTab("forum_konf",'p_na_str')){
				  	  $ile_w=konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'forum_p')." WHERE id_t='".$dane['id_t']."' AND (data<'".$dane['data']."' OR (data='".$dane['data']."' AND id<='".$dane['id']."'))".$query);
				  	  $p_podstrona=$this->oblPodstrona($ile_w,konf::get()->getKonfigTab("forum_konf",'p_na_str'));
			  	  }
		  	  	echo "<div class=\"grube\">";
		  	  	echo "<a href=\"".$link."&amp;t_nr=".$dane['id_t']."&amp;p_szuk=".$dane['id'];
						if(!empty($p_podstrona)&&$p_podstrona>1){
							echo "&amp;podstrona=".$p_podstrona;
						}
						echo "#p"; 
						echo "\">".tekstForm::zlamStringa($dane['temat'],40,true,false)."</a>";
		  	  	echo "</div>";
		  	  	
			  	  echo $this->userDane(konf::get()->getKonfigTab("forum_konf",'user_dane'),$dane['id_autor'],$dane['autor'],konf::get()->getKonfigTab("plik"));
		  	  	echo ", <span class=\"male\">".$dane['data'];
			    	if($this->admin()){
				      echo ", host: ".$dane['host'];
			  	    if($dane['host']!=$dane['id']){ 
								echo ", ip: ".$dane['ip']; 
							}
				    }
			  	  echo "</span><br />";
		  	  	echo "<i>".$this->tresc_szukaj($dane['tresc'],$szukaj_fraza,$szukaj_kat)."</i>";
			  	  echo "</td></tr>";
			  	}
				  konf::get()->_bazasql->freeResult($zap);
		      
					if($naw->getNaw()){
						echo "<tr><td colspan=\"".$colspan."\" class=\"".konf::get()->getKonfigTab("forum_konf",'tresc_class')."\">".$naw->getNaw()."</td></tr>";
					}				
					
			  } else {
			  	echo "<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'tresc_class')." srodek grube\" style=\"padding:10px\">".konf::get()->langTexty("forum_wyszuk_szukana")."</td></tr>";
			  }
			} else {
				echo "<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'tresc_class')." srodek grube\" style=\"padding:10px\">".konf::get()->langTexty("forum_wyszuk_nieprawidlowa")."</td></tr>";
			}
		  $this->stopka(1);

		  $this->wyszukiwarka();
			
		}
		
	}

	
  /**
   * start page
   */	
	public function start(){

	  $podstrona=konf::get()->getZmienna('podstrona','podstrona');
		$typy_tab=konf::get()->getKonfigTab("forum_konf",'typy_tab');
		
		$colspan=4;
		
		if(konf::get()->getKonfigTab("forum_konf",'licznik')){ 
			$colspan=5; 
		}
		
		$link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"forum_zobacz"));
		$link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"forum_edytujt","d_nr"=>$this->d_nr));	
		
		if(!$this->admin()){
			$query_dodaj=" AND status IN(1,2,3) ";
		} else {
			$query_dodaj="";
		}
		
	  if ($this->admin()){		

			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"forum_t","forum_t");
			echo $form->spr(array(1=>"akcja"),"","ok=spr_akcjau(document.forum_t.akcja,'forum_usunt','".konf::get()->langTexty("czyusun")."');");
			echo $form->getFormp();
			echo $form->przenies(array("podstrona"=>$podstrona,"d_nr"=>$this->d_nr));
		
		}	
			
		//gdy wybrano dzial lub gdy wyswietlac najnowsze dyskusje
		if(!empty($this->d_nr)||konf::get()->getKonfigTab("forum_konf",'t_start_na_str')){
	          
			$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'forum_t')." WHERE 1 ".$query_dodaj;
			
			$nawigacja="";
			
			//sprawdzamy dzial
			if(!empty($this->d_nr)){
				$dane=konf::get()->_bazasql->pobierzRekord("SELECT nazwa,status FROM ".konf::get()->getKonfigTab("sql_tab",'forum_d')." WHERE id='".$this->d_nr."'".$query_dodaj);
				
				if(!empty($dane)){
					
					$link.="&amp;d_nr=".$this->d_nr;									
	 				$this->naglowek($dane['nazwa'],$colspan);
	  			$query.=" AND id_d=".$this->d_nr." ";

					$naw = new nawig("SELECT COUNT(id) AS ilosc ".$query,$podstrona,konf::get()->getKonfigTab("forum_konf",'t_na_str'));		
					$naw->naw($link);
					$podstrona=$naw->getPodstrona();	

					if($naw->getNaw()){
						echo $nawigacja="<tr><td colspan=\"".$colspan."\" class=\"".konf::get()->getKonfigTab("forum_konf",'tresc_class')."\">".$naw->getNaw()."</td></tr>";
					}					

				} else { 
					$this->d_nr=""; 
				}

				//gdy nieprawidlowy dzial to nie wyswietlamy tematow
				if(empty($this->d_nr)){ 
					$query=""; 
				}
				
			} else {
				$this->naglowek(konf::get()->langTexty("forum_najnowsze"),$colspan);
			}
			
			if(!empty($query)){
			
				$query="SELECT * ".$query." ORDER BY ";
				if(!empty($this->d_nr)){ 
					$query.=" przyklejony DESC, "; 
				} 
				
				$query.="data DESC, id DESC LIMIT ";
				if(empty($this->d_nr)){
					$query.="0,".konf::get()->getKonfigTab("forum_konf",'t_start_na_str');
				} else {
					$query.=$naw->getStart().",".$naw->getIle();
				}
				echo "<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'naglowek_class')."\">";
				echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"seta\"><tr>";
				echo "<td class=\"".konf::get()->getKonfigTab("forum_konf",'naglowek_class')."srodek\" style=\"width:25px;\">&nbsp;</td>";
				echo "<td class=\"".konf::get()->getKonfigTab("forum_konf",'naglowek_class')."male grube seta\">".konf::get()->langTexty("forum_tytul")."</td></tr></table></td>";
				echo "<td class=\"srodek ".konf::get()->getKonfigTab("forum_konf",'naglowek_class')." male grube\">".konf::get()->langTexty("forum_autor")."</td>";
				echo "<td class=\"prawa ".konf::get()->getKonfigTab("forum_konf",'naglowek_class')." male grube\" style=\"width:40px;\">".konf::get()->langTexty("forum_odp")."</td>";
				if(konf::get()->getKonfigTab("forum_konf",'licznik')){
					echo "<td class=\"prawa ".konf::get()->getKonfigTab("forum_konf",'naglowek_class')." male grube\" style=\"width:40px;\">".konf::get()->langTexty("forum_wejsc")."</td>";
				}
				echo "<td class=\"prawa ".konf::get()->getKonfigTab("forum_konf",'naglowek_class')." male grube nobr\" style=\"width:80px;\">".konf::get()->langTexty("forum_ostatni")."</td></tr>";
				
				$zap=konf::get()->_bazasql->zap($query);
				
				if(konf::get()->_bazasql->numRows($zap)>0){
					while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
						$postow=$this->policzT($dane['id']);
						echo "<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'tresc_class')."\">";
						echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"seta\"><tr><td class=\"srodek\" style=\"width:25px;\">";
						if(is_array($typy_tab)&&!empty($typy_tab[$dane['status']])){ 
							echo $typy_tab[$dane['status']]['ikonka']; 
						}
						if ($this->admin()){
							echo $form->checkbox("id_tab[]","id_".$dane['id'],$dane['id']);						
						}					
						echo "</td><td>";
						echo "<a href=\"".$link."&amp;t_nr=".$dane['id'];
						if(konf::get()->getKonfigTab("forum_konf",'najnowszy')){
							$t_podstrona=$this->oblPodstrona($postow,konf::get()->getKonfigTab("forum_konf",'p_na_str'));
							if(!empty($t_podstrona)&&$t_podstrona>1){
								echo "&amp;podstrona=".$t_podstrona;
							}
							echo "#d"; 
						}
						echo "\">".tekstForm::zlamStringa($dane['temat'],30,true,false)."</a>";
						if ($this->admin()){
							echo "<a href=\"".$link2."&amp;id_nr=".$dane['id']."\"><img src=\"grafika/pencil.gif\" alt=\"".konf::get()->langTexty("forum_aedytujt")."\" align=\"absmiddle\" width=\"16\" height=\"16\" style=\"margin-left:10px\" /></a>";
						}					
						echo "</td>";					
						echo "</tr></table></td>";
						echo "<td class=\"srodek ".konf::get()->getKonfigTab("forum_konf",'tresc_class')."\">";					
						$dane['autor']=tekstForm::zlamStringa($dane['autor'],20,true,false);			
						echo $this->userDane(konf::get()->getKonfigTab("forum_konf",'user_dane'),$dane['id_autor'],$dane['autor'],konf::get()->getKonfigTab("plik"));
						echo "</td>";
						echo "<td class=\"prawa ".konf::get()->getKonfigTab("forum_konf",'tresc_class')."\">".$postow."</td>";
						if(konf::get()->getKonfigTab("forum_konf",'licznik')){
							echo "<td class=\"prawa ".konf::get()->getKonfigTab("forum_konf",'tresc_class')."\">".$dane['licznik']."</td>";
						}
						echo "<td class=\"prawa ".konf::get()->getKonfigTab("forum_konf",'tresc_class')." male nobr\">".str_replace(" ","<br />",$dane['data'])."</td></tr>";
					}
					echo $nawigacja;
					
				} else {
					echo "<tr><td colspan=\"".$colspan."\" class=\"srodek ".konf::get()->getKonfigTab("forum_konf",'tresc_class')." grube\" style=\"padding:10px\">".konf::get()->langTexty("forum_brakt")."</td></tr>";
				}
				konf::get()->_bazasql->freeResult($zap);			
			}		
		} else {	
			$this->naglowek("",$colspan);
		}
		
		
		if ($this->admin()){
			echo "<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'tresc_class')."\" ";	
			if(!empty($colspan)){ 
				echo " colspan=\"".$colspan."\""; 
			}
			echo ">";

	    //akcje  
			$akcje_tab['forum_usunt']=konf::get()->langTexty("forum_ausunt");
			$akcje_tab['forum_typt']=konf::get()->langTexty("forum_azmienstatust");
			if(!empty($this->d_nr)){
				$akcje_tab['forum_wytnijt']=konf::get()->langTexty("forum_awytnij");		
				if(!empty($_SESSION['forum_wytnijt_tab'])){
					$akcje_tab['forum_wklejt']=konf::get()->langTexty("forum_awklej");						
				}
			}
				
			
			if($typy_tab){	
				echo "<select name=\"f_status\" id=\"f_status\" class=\"f_dlugi\">";
				echo "<option value=\"\">--".konf::get()->langTexty("forum_p_statusna")."--</option>";
				while(list($key,$val)=each($typy_tab)){
					echo "<option value=\"".$key."\">".$val['opis']."</option>";
				}
				echo "</select> ";
			}			
				
			echo $form->selectAkcja($akcje_tab);

			echo "</td></tr>";
		}
	  
		if(konf::get()->getKonfigTab("forum_konf",'wys_d')&&empty($this->d_nr)){
			echo "<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'naglowek_class')."\" ";	
			if(!empty($colspan)){ echo " colspan=\"".$colspan."\""; }
			echo ">";
			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" class=\"seta\">";
		 	echo "<tr class=\"lewa\">";
			echo "<td style=\"width:25px\">&nbsp;</td>";
			echo "<td class=\"male grube nobr\">".konf::get()->langTexty("forum_katt")."&nbsp;</td>";
			echo "<td class=\"prawa male grube nobr\">".konf::get()->langTexty("forum_ilosct")."</td>";
			echo "</tr>";
			echo "</table>";
			echo "</td></tr>";
		
			$zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'forum_d')." WHERE 1 ".$query_dodaj." ORDER BY nr,id"); 
			$sum_tematy=0;	
			
			if(konf::get()->_bazasql->numRows($zap)>0){
			
				while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
					echo "<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'tresc_class')."\" ";	
					if(!empty($colspan)){ echo " colspan=\"".$colspan."\""; }
					echo ">";
					echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"3\" class=\"seta\">";
			 		echo "<tr><td class=\"srodek\" style=\"width:25px\" valign=\"top\">";
	        if(is_array($typy_tab)&&!empty($typy_tab[$dane['status']])){ 
	          echo $typy_tab[$dane['status']]['ikonka'];
	        }
	        echo "</td><td class=\"seta\"><a class=\"grube\" href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"forum_zobacz","d_nr"=>$dane['id']))."\">".$dane['nazwa']."</a>";
					echo "<div class=\"male\">".$dane['opis']."</div></td>";
					echo "<td class=\"prawa male grube\">";
					echo $ile=konf::get()->_bazasql->policz("id","FROM ".konf::get()->getKonfigTab("sql_tab",'forum_t')." WHERE id_d='".$dane['id']."'".$query_dodaj);
					$sum_tematy+=$ile;
					echo "</td></tr></table></td></tr>";
				}
				
				echo "<tr><td class=\"prawa male ".konf::get()->getKonfigTab("forum_konf",'tresc_class')."\" ";	
				if(!empty($colspan)){ 
					echo " colspan=\"".$colspan."\""; 
				}
				echo ">".konf::get()->langTexty("forum_razemt")." <span class=\"grube\">".$sum_tematy."</span></td></tr>";
			} else {
				echo "<tr><td class=\" srodek ".konf::get()->getKonfigTab("forum_konf",'tresc_class')." grube\" ";	
				if(!empty($colspan)){ 
					echo " colspan=\"".$colspan."\""; 
				}
				echo ">".konf::get()->langTexty("forum_brakd")."</td></tr>";
			}
			konf::get()->_bazasql->freeResult($zap);
			
		} 
		
		$this->stopka($colspan);
			
		if ($this->admin()){
			echo $form->getFormk();
		}
			
		$this->wyszukiwarka();
	}


  /**
   * show theme
   */	
	public function wyswietlp(){

	  $podstrona=konf::get()->getZmienna('podstrona','podstrona');
	  $p_szuk=konf::get()->getZmienna('p_szuk','p_szuk');
	  $link=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"forum_zobacz"));
		$typy_tab=konf::get()->getKonfigTab("forum_konf",'typy_tab');
		
		$link2=konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("t_nr"=>$this->t_nr,"akcja"=>"forum_edytujp"));
		
		$query_dodaj="";
		
		if(!$this->admin()){
			$query_dodaj=" AND status IN(1,2,3) ";
		} else {
		
			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"forum_p","forum_p");
			echo $form->spr(array(1=>"akcja"),"","ok=spr_akcjau(document.forum_p.akcja,'forum_usunp','".konf::get()->langTexty("czyusun")."');");
			echo $form->getFormp();
			echo $form->przenies(array("podstrona"=>$podstrona,"t_nr"=>$this->t_nr));
			
		}
		
		
		$query=" FROM ".konf::get()->getKonfigTab("sql_tab",'forum_p')." WHERE 1 ".$query_dodaj;	
	 
		$dane=konf::get()->_bazasql->pobierzRekord("SELECT id_d,temat,status FROM ".konf::get()->getKonfigTab("sql_tab",'forum_t')." WHERE id='".$this->t_nr."'".$query_dodaj);
		if(!empty($dane)){

	    $this->d_nr=$dane['id_d'];

			$link.="&amp;t_nr=".$this->t_nr;

     $nagl="<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr valign=\"middle\">";
     if(is_array($typy_tab)&&!empty($typy_tab[$dane['status']])){ 
       $nagl.="<td class=\"srodek\" style=\"width:25px\">".$typy_tab[$dane['status']]['ikonka']."</td>";
     }
     $nagl.="<td>".$dane['temat']."</td></tr></table>";
		 $this->naglowek($nagl);
		 $query.=" AND id_t='".$this->t_nr."' ";

		} else { 
			$this->t_nr=""; 
		}


		//gdy nieprawidlowy temat to nie wyswietlamy postow
		if(!empty($this->t_nr)){  	
		
	    if(konf::get()->getKonfigTab("forum_konf",'p_na_str')){
			
				$naw = new nawig("SELECT COUNT(id) AS ilosc ".$query,$podstrona,konf::get()->getKonfigTab("forum_konf",'p_na_str'));		
				$naw->naw($link);
				$podstrona=$naw->getPodstrona();	

				if($naw->getNaw()){
					$naw['tresc']="<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'tresc_class')."\">".$naw->getNaw()."</td></tr>";
				}
				
	    }

	  	//sprawdzamy czy temat istnieje i czy ma status ktory pozwala odpowiedzieć
			if(!$this->admin()&&(($dane['status']==2&&!user::get()->zalogowany())||$dane['status']>2)){
				$odp=false;
			} else { 
				$odp=true; 
			}
	      
			$query="SELECT * ".$query." ORDER BY data, id";
	    if(konf::get()->getKonfigTab("forum_konf",'p_na_str')){
	      $query.=" LIMIT ".$naw->getStart().",".$naw->getIle();
			}			
	    $zap=konf::get()->_bazasql->zap($query);
			
			require_once(konf::get()->getKonfigTab('klasy')."class.emotikony.php");			
			
			$i=0;	
			
	    while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
			
				$i++;
				
	      echo "<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'naglowek_class')."\">";
	      echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr valign=\"top\">";
	      if(is_array(konf::get()->getKonfigTab("forum_konf",'typy_tab'))&&!empty($typy_tab[$dane['status']])){ 
	        echo "<td class=\"srodek\" style=\"width:25px\">".$typy_tab[$dane['status']]['ikonka']."</td>";
	      }
	      echo "<td>";
				
	      if(!empty($p_szuk)&&$p_szuk==$dane['id']){ 
					echo "<a name=\"p\"></a>"; 
				}
				
	      if($this->admin()){
					echo $form->checkbox("id_tab[]","id_".$dane['id'],$dane['id'],"");	
				}
				
	      echo "<span class=\"grube\">";
	      echo $this->userDane(konf::get()->getKonfigTab("forum_konf",'user_dane'),$dane['id_autor'],$dane['autor'],konf::get()->getKonfigTab("plik"));
	      echo "</span>, <span class=\"male\">".$dane['data'];
	      if($this->admin()){
	        echo ", host: ".$dane['host'];
	        if($dane['host']!=$dane['id']){ 
						echo ", ip: ".$dane['ip']; 
					}
	      }
	      echo "</span>";
				if ($this->admin()){
					echo "<a href=\"".$link2."&amp;id_nr=".$dane['id']."\"><img src=\"grafika/pencil.gif\" alt=\"".konf::get()->langTexty("forum_p_adytuj")."\" align=\"absmiddle\" width=\"16\" height=\"16\" style=\"margin-left:10px\" /></a>";
				}
				echo "</td></tr></table>";
	      echo "</td></tr>";
	      echo "<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'tresc_class')."\">";
	      echo $this->tresc($dane);
	      if($odp){
	        echo "<div class=\"prawa\"><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("t_nr"=>$this->t_nr,"akcja"=>"forum_dodajp","id_odp"=>$dane['id'],'podstrona'=>$podstrona))."\">napisz odpowiedź <img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/pisz.gif\" width=\"20\" height=\"19\" border=\"0\" style=\"vertical-align:-4px;\" alt=\"\" /></a></div>";
	      }
	      echo "</td></tr>";
	    }
			
			if(empty($i)&&$odp){
	     	echo "<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'tresc_class')."\">";
	      echo "<div class=\"prawa\"><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("t_nr"=>$this->t_nr,"akcja"=>"forum_dodajp","id_odp"=>$dane['id'],'podstrona'=>$podstrona))."\">napisz odpowiedź <img src=\"".konf::get()->getKonfigTab("sciezka")."grafika/pisz.gif\" width=\"20\" height=\"19\" border=\"0\" style=\"vertical-align:-4px;\" alt=\"\" /></a></div>";
	      echo "</td></tr>";		
			}	
			
			if(konf::get()->getKonfigTab("forum_konf",'licznik')){ 
				konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'forum_t')." SET licznik=licznik+1 WHERE id='".$this->t_nr."'"); 
			}
			
			konf::get()->_bazasql->freeResult($zap);
	        
	    if ($this->admin()){
				echo "<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'tresc_class')."\" ";	
				if(!empty($colspan)){ echo " colspan=\"".$colspan."\""; }
				echo "><table border=\"0\" cellspacing=\"0\" cellpadding=\"2\">";
				echo "<tr><td class=\"prawa\"><span class=\"grube\">".konf::get()->langTexty("forum_p_zaznaczone")."</span></td><td>";
				
		    //akcje  
				$akcje_tab['forum_usunp']=konf::get()->langTexty("forum_p_ausun");
				if($typy_tab){			
					$akcje_tab['forum_typp']=konf::get()->langTexty("forum_p_azmiens");
				}
				if(!empty($this->d_nr)){
					$akcje_tab['forum_wytnijp']=konf::get()->langTexty("forum_awytnij");		
					if(!empty($_SESSION['forum_wytnijp_tab'])){
						$akcje_tab['forum_wklejp']=konf::get()->langTexty("forum_awklej");						
					}
				}			
				echo $form->selectAkcja($akcje_tab);
				
				echo "</td></tr>";
				if($typy_tab){
					echo "<tr><td class=\"prawa\">".konf::get()->langTexty("forum_p_statusna")."</td><td>";
					echo "<select name=\"f_status\" id=\"f_status\" class=\"f_dlugi\">";
					echo "<option value=\"\">&nbsp;</option>";
					while(list($key,$val)=each($typy_tab)){
						echo "<option value=\"".$key."\">".$val['opis']."</option>";
					}
					echo "</select></td></tr>";
				}
				echo "</table></td></tr>";
			}
			
	    if(konf::get()->getKonfigTab("forum_konf",'p_na_str')){
				if($naw->getNaw()){
					$naw['tresc']="<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'tresc_class')."\">".$naw->getNaw()."</td></tr>";
				}			
	    }
			
	    $this->stopka(1);
	  } 
		
	  if ($this->admin()){
			echo $form->getFormk();
	 	}	
	  
	  $this->wyszukiwarka();
		
	}


  /**
   * category form
   */	
	private function formularzd(){

		$typy_tab=konf::get()->getKonfigTab("forum_konf",'typy_tab');
		
		$dane=array(
			'nr'=>"1",
			'nazwa'=>'',
			'opis'=>'',
			'status'=>konf::get()->getKonfigTab("forum_konf",'forum_domyslny_typ')
		);

		if(konf::get()->getAkcja()=="forum_edytujd"){
			//pobiera aktualne dane
			$zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'forum_d')." WHERE id='".$this->d_nr."'");
			$dane=konf::get()->_bazasql->fetchAssoc($zap);
			konf::get()->_bazasql->freeResult($zap);
			echo $this->naglowek(konf::get()->langTexty("forum_d_edycja"),1);
		} else {
			echo $this->naglowek(konf::get()->langTexty("forum_d_dodawanie"),1);	
		}

		echo "<tr valign=\"top\"><td class=\"".konf::get()->getKonfigTab("forum_konf",'tresc_class')."\">";
		
		$form=new formularz("post",konf::get()->getKonfigTab("plik"),"form_d","form_d");
		echo $form->spr(array(1=>"f_nazwa_d",2=>"f_nr_d"));
		echo $form->getFormp();
		echo $form->przenies(array("akcja"=>konf::get()->getAkcja()."2","d_nr"=>$this->d_nr));

		if($typy_tab&&is_array($typy_tab)){
			echo konf::get()->langTexty("forum_d_kategoria")."<br />";
			while(list($key,$val)=each($typy_tab)){
				echo "<input type=\"radio\" name=\"f_status_d\" value=\"".$key."\"  class=\"przycisk\" ";
				if($dane['status']==$key){ 
					echo "checked"; 
				}
				echo " /> ".$val['ikonka']." ".$val['opis']."<br />";
			}
			echo "<br />";
		}

		echo "<select id=\"f_nr_d\" name=\"f_nr_d\" class=\"f_sredni\">";
		for($i=1;$i<=100;$i++){
			echo "<option value=\"".$i."\" ";
			if($dane['nr']==$i){ 
				echo "selected"; 
			}
			echo ">".$i."</option>";
		}
		
		echo "</select>";
		echo interfejs::label("f_nr_d",konf::get()->langTexty("forum_d_nrpoz"),"",true);				
		echo "<br />";
		
		echo interfejs::label("f_nazwa_d",konf::get()->langTexty("forum_d_nazwa"));						
		echo "<br />";
		echo $form->input("text","f_nazwa_d","f_nazwa_d",$dane['nazwa'],"f_bdlugi",150);			
		echo "<br />";
		
		echo interfejs::label("f_opis_d",konf::get()->langTexty("forum_d_opis"),"",true);						
		echo "<br />";
		echo $form->textarea("f_opis_d","f_opis_d",$dane['opis'],"f_bdlugi",4);		
		echo "<br />";
		
		echo $form->input("submit","","",konf::get()->langTexty("zapisz"),"formularz2 f_krotki");	
		
		echo "<br /><div class=\"male\">".konf::get()->langTexty("forum_d_pozycje")."</div><br />";
		echo $form->getFormk();
		echo "</td></tr>";
		
		if(konf::get()->getAkcja()=="forum_edytujd"){
			echo "<tr valign=\"top\"><td class=\"".konf::get()->getKonfigTab("forum_konf",'tresc_class')."\"><br />";
			if(konf::get()->_bazasql->policz("id","FROM ".konf::get()->getKonfigTab("sql_tab",'forum_t')." WHERE id_d='".$this->d_nr."'")==0){
				$form2=new formularz("post",konf::get()->getKonfigTab("plik"),"form_d2","form_d2");
				$form2->setOnsubmit("return confirm('".konf::get()->langTexty("forum_d_czy")."');");
				echo $form2->getFormp();
				echo $form2->przenies(array("akcja"=>"forum_usund","d_nr"=>$this->d_nr));				
				echo "<div class=\"prawa\">";
				echo $form2->input("submit","","",konf::get()->langTexty("forum_d_usund"),"formularz2 f_sredni");	
				echo "</div>";
				echo $form2->getFormk();			
			} else { 
				echo konf::get()->langTexty("forum_d_wybrany")."<br />"; 
			}
			echo "</td></tr>";		
		}	
		
		if(!empty($this->d_nr)){
			echo "<tr><td class=\"srodek ".konf::get()->getKonfigTab("forum_konf",'naglowek_class')."\"><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"forum_dodajd"))."\">".konf::get()->langTexty("forum_d_dodaj")."</a></td></tr>";
		}
			
		echo "<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'naglowek_class')."\">".konf::get()->langTexty("forum_d_istniejace")."</td></tr>";
		echo "<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'tresc_class')."\">";
		
		$form2=new formularz("post",konf::get()->getKonfigTab("plik"),"form_d3","form_d3");
		echo $form2->getFormp();
		echo $form2->przenies(array("akcja"=>"forum_edytujd"));
		$zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'forum_d')." ORDER BY nr,id");
		if(konf::get()->_bazasql->numRows($zap)>0){
			while($dane=konf::get()->_bazasql->fetchAssoc($zap)){		
				echo "<div style=\"padding-bottom:7px;\">";
				echo $form2->radio("d_nr","",$dane['id'],"","","onclick=\"this.form.submit();\"");
				if(is_array($typy_tab)&&!empty($typy_tab[$dane['status']])){ 
					echo $typy_tab[$dane['status']]['ikonka']; 
				}
				echo " ".$dane['nr']." <a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("d_nr"=>$dane['id'],"akcja"=>"forum_zobacz"))."\">".$dane['nazwa']."</a> (tematów: ".konf::get()->_bazasql->policz("id","FROM ".konf::get()->getKonfigTab("sql_tab",'forum_t')." WHERE id_d='".$dane['id']."'").")";
				if(!empty($dane['opis'])){ 
					echo "<div class=\"male\">".tekstForm::doWys($dane['opis'],false)."</div>"; 
				}
				echo "</div>";
			}
		} else {
			echo "<br /><div class=\"srodek\">".konf::get()->langTexty("forum_d_brak")."</div>";
		}
		konf::get()->_bazasql->freeResult($zap);

		echo $form2->getFormk();
		
		echo "<br/>";
		echo "</td></tr>";
		
	  echo $this->stopka();
		
		$this->wyszukiwarka();
		
	}

	
  /**
   * add category
   */	
	public function dodajd(){	
	
		$this->formularzd();
		
	}
	
	
  /**
   * edit category
   */	
	public function edytujd(){	
	
		$this->formularzd();
		
	}	
	
	
  /**
   * save category
   */	
	private function zapiszd(){

		$typy_tab=konf::get()->getKonfigTab("forum_konf",'typy_tab');
	  $f_status_d=konf::get()->getZmienna('f_status_d');
	  $f_nr_d=konf::get()->getZmienna('f_nr_d');
	  $f_nazwa_d=tekstForm::doSql(konf::get()->getZmienna('f_nazwa_d'));	
	  $f_opis_d=tekstForm::doSql(konf::get()->getZmienna('f_opis_d'));

	  if(empty($f_status_d)||empty($typy_tab[$f_status_d])||!$typy_tab){ 
			$f_status_d=konf::get()->getKonfigTab("forum_konf",'forum_domyslny_typ'); 
		}
		if(empty($f_nr_d)||!is_numeric($f_nr_d)||$f_nr_d<1||$f_nr_d>100){ 
			$f_nr_d=1; 
		}

		if(!empty($f_nazwa_d)){
			if(konf::get()->_bazasql->policz("id","FROM ".konf::get()->getKonfigTab("sql_tab",'forum_d')." WHERE nazwa='".$f_nazwa_d."' AND id!='".$this->d_nr."'")==0){
		
				if(konf::get()->getAkcja()=="forum_dodajd2"||empty($this->d_nr)){
		  		konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'forum_d')." VALUES(NULL, '".$f_nr_d."','".$f_nazwa_d."', '".$f_opis_d."','".$f_status_d."')");
					user::get()->zapiszLog(konf::get()->langTexty("forum_d_dodawanie_log")." ".$f_nazwa_d,user::get()->login());
				} else {
	  			konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'forum_d')." SET nr='".$f_nr_d."', nazwa='".$f_nazwa_d."', opis='".$f_opis_d."', status='".$f_status_d."' WHERE id='".$this->d_nr."'");
		  		user::get()->zapiszLog(konf::get()->langTexty("forum_d_edycja_log")." ".$f_nazwa_d,user::get()->login());			
				}
				
	  		konf::get()->setKomunikat(konf::get()->langTexty("forum_d_zostaly"),"");
			} else { 
				konf::get()->setKomunikat(konf::get()->langTexty("forum_d_istnieje"),"error"); 
			}
		} else { 
			konf::get()->setKomunikat(konf::get()->langTexty("forum_d_braknazwy"),"error"); 
		}
	}	

	
  /**
   * add category
   */	
	public function dodajd2(){	
	
		$this->zapiszd();
		
	}
	
	
  /**
   * edit category
   */	
	public function edytujd2(){	
	
		$this->zapiszd();
		
	}		
	
  /**
   * delete category
   */	
	public function usund(){

		if(!empty($this->d_nr)){
			if(konf::get()->_bazasql->policz("id","FROM ".konf::get()->getKonfigTab("sql_tab",'forum_t')." WHERE id_d='".$this->d_nr."'")==0){
				konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'forum_d')." WHERE id='".$this->d_nr."'");
	  		konf::get()->setKomunikat(konf::get()->langTexty("forum_d_usuniety"),"");
			  user::get()->zapiszLog(konf::get()->langTexty("forum_d_usuniety_log")." ".$this->d_nr,user::get()->login());
			} else { 
				konf::get()->setKomunikat(konf::get()->langTexty("forum_d_niepusty"),"error"); 
			}
		}
		
		$this->d_nr="";
		
	}


  /**
   * theme/post form
   */		
	private function formularz(){
		$p_nr=tekstForm::doSql(konf::get()->getZmienna('p_nr','p_nr'));
		$id_nr=tekstForm::doSql(konf::get()->getZmienna('id_nr','id_nr'));
		$typy_tab=konf::get()->getKonfigTab("forum_konf",'typy_tab');
	  $podstrona=konf::get()->getZmienna('podstrona','podstrona');	
	  $id_odp=konf::get()->getZmienna('id_odp','id_odp');	
	  $forum_login=konf::get()->getZmienna('','','forum_login');
	  $forum_email=konf::get()->getZmienna('','','forum_email');	
		
		$dane=array(
			'id_d'=>$this->d_nr,
			'autor'=>$forum_login,
			'email'=>$forum_email,
			'temat'=>'',
			'tresc'=>'',
			'przyklejony'=>'0',
			'status'=>konf::get()->getKonfigTab("forum_konf",'forum_domyslny_typ'),
			'img'=>'',
			'img_w'=>'',
			'img_h'=>''
		);
		
		$ok=true;
		
		require_once(konf::get()->getKonfigTab('klasy')."class.emotikony.php");			

		if (konf::get()->getAkcja()=="forum_edytujt"){
		
			$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'forum_t')." WHERE id='".$id_nr."'");
			echo $this->naglowek(konf::get()->langTexty("forum_pform_edycjat"),1);
			
		} else if (konf::get()->getAkcja()=="forum_dodajt") {
		
			$status_d=$this->statusD($this->d_nr);
			
			if(!$this->admin()&&(($status_d==2&&!user::get()->zalogowany())||$status_d>2)){
				$ok=false;
			} else { 
				$dane['status']=$status_d; 
			}
			
			echo $this->naglowek(konf::get()->langTexty("forum_pform_dodawaniet"),1);	
			
		} else if (konf::get()->getAkcja()=="forum_edytujp"){
		
			$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'forum_p')." WHERE id='".$id_nr."'");
			echo $this->naglowek(konf::get()->langTexty("forum_pform_edycjap"),1);
			
		} else {
		
			konf::get()->setAkcja("forum_dodajp");
			
			//jesli to nowy post to pobieramy dane tematu
			$zap=konf::get()->_bazasql->zap("SELECT id_d,temat,status FROM ".konf::get()->getKonfigTab("sql_tab",'forum_t')." WHERE id='".$this->t_nr."'");
			if(konf::get()->_bazasql->numRows($zap)>0){
			
				$dane3=konf::get()->_bazasql->fetchAssoc($zap);
	      $this->d_nr=$dane3['id_d'];
				//sprawdzamy czy temat istnieje i czy ma status ktory pozwala odpowiedzieć
				if(!$this->admin()&&(($dane3['status']==2&&!user::get()->zalogowany())||$dane3['status']>2)){
					$ok=false;
				}
				
			} else { 
				$ok=false; 
			}
			
			konf::get()->_bazasql->freeResult($zap);
			echo $this->naglowek(konf::get()->langTexty("forum_pform_dodawaniep"),1);	
			
		}

		echo "<tr valign=\"top\"><td class=\"".konf::get()->getKonfigTab("forum_konf",'tresc_class')."\"><br />";

		if($ok){
		
			if(konf::get()->getAkcja()=="forum_dodajp"&&!empty($id_odp)){
			
				//pobieramy dane postu na ktory odpowiadamy 
				echo "<script type=\"text/javascript\">\n";
				//pobiera aktualne dane
				$zap=konf::get()->_bazasql->zap("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'forum_p')." WHERE id='".$id_odp."'");
				if(konf::get()->_bazasql->numRows($zap)>0){
					$dane2=konf::get()->_bazasql->fetchAssoc($zap);
			  	echo "cytat='\\n<i>".$this->cytat(konf::get()->langTexty("forum_pform_wodp")." ".$dane2['autor'].", ".substr($dane2['data'],0,16)."\n\n".strip_tags($dane2['tresc'])."")."</i>\\n\\n';\n";
				} else { 
					$id_odp=""; 
				}	
				konf::get()->_bazasql->freeResult($zap);	
				echo "</script>\n\n";	
				
			}
			
			if(!user::get()->zalogowany()){
				$forum_spr[]="f_kto";
				$forum_spr[]="f_email";
			}
			if(konf::get()->getAkcja()=="forum_dodajt"||konf::get()->getAkcja()=="forum_edytujt"){
				$forum_spr[]="f_temat";
				$forum_spr[]="d_nr";
				if(konf::get()->getAkcja()=="forum_dodajt"){
					$forum_spr[]="f_tresc";
				}
			} else {
				$forum_spr[]="f_tresc";
			}
			if($typy_tab&&$this->admin()){
				$forum_spr[]="f_status";
			}
			
			?><script type="text/javascript">			
			function spr_formdodajp(){			
				if (document.forum_form.pic.value!='' && !document.forum_form.usun_fotke.checked){ document.forum_form.usun_fotke.click(); }				
			}			
			</script><?php			
			
			$form=new formularz("post",konf::get()->getKonfigTab("plik"),"forum_form","forum_form");
			$form->setMultipart(true);		

			if($this->admin()&&konf::get()->getAkcja()=="forum_edytujp"&&!empty($dane['img'])&&file_exists(konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("forum_konf",'img_kat').$dane['img1_nazwa'])){
				echo $form->spr($forum_spr," spr_formdodajp(); ");		
			} else {
				echo $form->spr($forum_spr);		
			}

			echo $form->getFormp();
			echo $form->przenies(array("a"=>"a","id_nr"=>$id_nr,"akcja"=>konf::get()->getAkcja()."2","podstrona"=>$podstrona));			

			if(konf::get()->getAkcja()=="forum_edytujp"){
				echo $form->input("hidden","p_nr","p_nr",$id_nr,"","");
			} else if(konf::get()->getAkcja()=="forum_dodajp"){
				echo $form->input("hidden","t_nr","t_nr",$this->t_nr,"","");		
			} else if(konf::get()->getAkcja()=="forum_edytujt"){
				echo $form->input("hidden","t_nr","t_nr",$id_nr,"","");		
			}
				
			echo "<table border=\"0\" cellspacing=\"0\" cellpadding=\"2\">";
			
			echo "<tr><td class=\"prawa\">";			
			echo interfejs::label("f_kto",konf::get()->langTexty("forum_pform_kto"),"grube");					
			echo"</td><td>";
			
			if(!user::get()->zalogowany()){
				echo $form->input("text","f_kto","f_kto",$dane['autor'],"f_dlugi",30);		
			} else { 
				echo "<div id=\"f_kto\">";
				echo user::get()->login(); 
				echo "</div>";
			}
			echo "</td></tr>";
			echo "<tr><td class=\"prawa\">";
			echo interfejs::label("f_email",konf::get()->langTexty("forum_pform_email"),"grube");									
			echo "</td><td>";
			
			if(!user::get()->zalogowany()){
				echo $form->input("text","f_email","f_email",$dane['email'],"f_dlugi",60);				
			} else { 
				echo "<div id=\"f_email\">";			
				echo user::get()->email(); 
				echo "</div>";
			}
			echo "</td></tr>";
		
			if(konf::get()->getAkcja()!="forum_edytujp"){
			
				echo "<tr><td class=\"prawa grube\">";						
				echo interfejs::label("f_temat",konf::get()->langTexty("forum_pform_t"),"grube");									
				echo "</td><td>";
				
				if(konf::get()->getAkcja()=="forum_dodajt"||konf::get()->getAkcja()=="forum_edytujt"){
					echo $form->input("text","f_temat","f_temat",$dane['temat'],"f_bdlugi",250);					
				} else if(konf::get()->getAkcja()=="forum_dodajp"){
					echo "<div id=\"f_temat\"><a href=\"".konf::get()->zmienneLink(konf::get()->getKonfigTab("plik"),array("akcja"=>"forum_zobacz","t_nr"=>$id_nr,"podstrona"=>$podstrona))."\">".$dane3['temat']."</a></div>";
				}
				echo "</td></tr>";
				
				if($this->admin()&&(konf::get()->getAkcja()=="forum_dodajt"||konf::get()->getAkcja()=="forum_edytujt")){
					echo "<tr><td></td><td>";
					echo $form->checkbox("f_przyklejony","f_przyklejony",1,$dane['przyklejony']);		
					echo interfejs::label("f_przyklejony",konf::get()->langTexty("forum_pform_przyklejony"),"",true);						
					echo "</td></tr>";
				}
				
			} else {
			
	   		echo "<tr><td class=\"prawa\">";				
				echo interfejs::label("t_nr",konf::get()->langTexty("forum_pform_t"),"grube");						
				echo "</td><td>";
				
	  		echo "<select name=\"t_nr\" id=\"t_nr\" class=\"f_bdlugi\"/><option value=\"\">&nbsp;</option>";
	   		$zap=konf::get()->_bazasql->zap("SELECT id,temat FROM ".konf::get()->getKonfigTab("sql_tab",'forum_t')." ORDER BY przyklejony DESC, data DESC LIMIT 0,100");
				while($dane3=konf::get()->_bazasql->fetchAssoc($zap)){
					echo " <option value=\"".$dane3['id']."\" ";
					if($dane3['id']==$dane['id_t']){ 
						echo "selected=\"selected\""; 
					}
	   			echo "> ".$dane3['temat']."</option>";
	   		}
	   		konf::get()->_bazasql->freeResult($zap);
	   		echo "</select>";
		
	   		echo "</td></tr>";
				
			}
		
			if(konf::get()->getAkcja()=="forum_dodajt"||konf::get()->getAkcja()=="forum_edytujt"){
		
	   		echo "<tr><td class=\"prawa\">";
				echo interfejs::label("d_nr",konf::get()->langTexty("forum_pform_kat"),"grube");									
				echo "</td><td>";
				
	  		echo "<select name=\"d_nr\" id=\"d_nr\" class=\"f_bdlugi\">";
	   		if($this->admin()){ 
					$zap=konf::get()->_bazasql->zap("SELECT id,nazwa FROM ".konf::get()->getKonfigTab("sql_tab",'forum_d')." ORDER BY nr,id"); 
				} else{ 
					$zap=konf::get()->_bazasql->zap("SELECT id,nazwa FROM ".konf::get()->getKonfigTab("sql_tab",'forum_d')." WHERE STATUS IN(1,2) ORDER BY nr,id"); 
				}	
				while($dane3=konf::get()->_bazasql->fetchAssoc($zap)){
					echo " <option value=\"".$dane3['id']."\" ";
					if($dane3['id']==$dane['id_d']){ 
						echo "selected=\"selected\""; 
					}
	   			echo "> ".$dane3['nazwa']."</option>";
	   		}
	   		konf::get()->_bazasql->freeResult($zap);
	   		echo "</select>";
	   		echo "</td></tr>";
			
	   	}
	   	if($typy_tab&&$this->admin()){
			
	   		echo "<tr><td class=\"prawa\">";
				echo interfejs::label("f_status",konf::get()->langTexty("forum_pform_status"),"grube");							
				echo "</td><td>";
				
	   		echo "<select name=\"f_status\" id=\"f_status\" class=\"f_bdlugi\">";
	   		while(list($key,$val)=each($typy_tab)){
	   			echo " <option value=\"".$key."\" ";
					if($key==$dane['status']){ 
						echo "selected=\"selected\""; 
					}
	   			echo "> ".$val['opis']."</option>";
	   		}
	   		echo "</select>";
	   		echo "</td></tr>";
				
	   	}
	   
		 	if(konf::get()->getAkcja()!="forum_edytujt"){
			
		   	echo "<tr><td class=\"prawa\" valign=\"top\">";
				echo interfejs::label("f_tresc",konf::get()->langTexty("forum_pform_tresc"),"grube");					
				echo "</td><td>";
				
				echo $form->textarea("f_tresc","f_tresc",$dane['tresc'],"f_bdlugi",15);				
	   		echo "</td></tr>";
	   
	   		if(konf::get()->getKonfigTab("forum_konf",'emotikony')){
	   			echo "<tr><td></td><td>";
					$emotikony=new emotikony();							
					echo $emotikony->wyswietl("forum_form","f_tresc");		
	   			echo "</td></tr>";
	   		}
	   
	   		if(konf::get()->getKonfigTab("forum_konf",'html_hlp')){
	   			echo "<tr><td></td><td>";
	   			echo "&nbsp;&nbsp;&nbsp;<a href=\"javascript:dodajtag('forum_form','f_tresc','b','".konf::get()->langTexty("forum_pform_wgruby")."');\">".konf::get()->langTexty("forum_pform_pogrubiony")."</a>&nbsp;&nbsp;&nbsp;&nbsp;";
					echo "<a href=\"javascript:dodajtag('forum_form','f_tresc','i','".konf::get()->langTexty("forum_pform_wpochyly")."');\">".konf::get()->langTexty("forum_pform_pochyly")."</a><br /><br />";   
	   			echo "</td></tr>";
	   		}
				
				if(konf::get()->getKonfigTab("forum_konf",'img')){
				
	   			if($this->admin()&&konf::get()->getAkcja()=="forum_edytujp"&&!empty($dane['img'])){
	   				echo "<tr><td></td><td>";
						echo interfejs::imgPodglad($dane,"img",konf::get()->getKonfigTab("forum_konf",'img_kat'));	
						echo $form->checkbox("usun_fotke","usun_fotke","tak","");		
						echo interfejs::label("usun_fotke",konf::get()->langTexty("forum_pform_usunjpg"),"",true);																					
						echo "</td></tr>";
	   			}
					
	   			if($this->czyJpg()){
	   				echo "<tr><td valign=\"top\" class=\"prawa\">".konf::get()->langTexty("forum_pform_jpg")." </td>";
						echo "<td>";
						echo $form->input("file","pic","pic","","f_bdlugi");
						echo "<div class=\"male\">";
	   				echo konf::get()->langTexty("forum_pform_minimalny")." ".konf::get()->getKonfigTab("forum_konf",'img_min')." ".konf::get()->langTexty("forum_pform_pszer")." ".konf::get()->getKonfigTab("forum_konf",'img_min')." ".konf::get()->langTexty("forum_pform_pwys")."<br />".konf::get()->langTexty("forum_pform_obrazek")." ".konf::get()->getKonfigTab("forum_konf",'img_max')." ".konf::get()->langTexty("forum_pform_przeskalowany");
	   				if(!$this->admin()&&konf::get()->getKonfigTab("forum_konf",'img_limit')){
	   					echo "<br />(max.".konf::get()->getKonfigTab("forum_konf",'img_limit')." ".konf::get()->langTexty("forum_pform_obrazkow");
	   				}
	   				echo "</div></td></tr>";
						
	   				echo "<tr><td valign=\"middle\" class=\"prawa\">".konf::get()->langTexty("forum_pform_umiescjpg")." </td>";
						echo "<td><a href=\"javascript:document.forum_form.f_tresc.value=document.forum_form.f_tresc.value+'\\n[img]\\n '; document.forum_form.f_tresc.focus();\"><img src=\"grafika/fotki.gif\" width=\"16\" height=\"16\" vspace=\"3\" hspace=\"3\" border=\"0\" alt=\"\" /></a>";
						echo "<div class=\"male\">".konf::get()->langTexty("forum_pform_jesli")."</div></td></tr>";
						
	   			} else {
	   				echo "<tr><td></td><td class=\"error\">";
						echo konf::get()->langTexty("forum_pform_przekroczyles")." ".konf::get()->getKonfigTab("forum_konf",'img_limit')." ".konf::get()->langTexty("forum_pform_przekroczyles2");
						echo "</td></tr>";
		   		}
	 	  	}
	  	} 
			
			echo "<tr><td></td><td>";
			
			echo "<br />";
			echo $form->input("submit","","",konf::get()->langTexty("forum_pform_zapisz"),"formularz2 f_krotki");						
			if(konf::get()->getAkcja()!="forum_dodajt"&&konf::get()->getAkcja()!="forum_edytujt"&&!empty($this->d_nr)){
				echo $form->input("hidden","d_nr","",$this->d_nr,"","");			
			}
			
			if(konf::get()->getAkcja()=="forum_dodajp"&&!empty($id_odp)){
		   	echo "&nbsp;&nbsp;&nbsp;";
				echo $form->input("button","","",konf::get()->langTexty("forum_pform_cytuj"),"formularz2 f_krotki",""," onclick=\"document.forum_form.f_tresc.value=document.forum_form.f_tresc.value+cytat; cytat=''; this.form.f_tresc.focus();\"");
			}
			
	   	echo "</td></tr>";
	   
	   	echo "<tr><td></td><td class=\"male\"><div class=\"male\"> ".konf::get()->langTexty("forum_pform_pozycje")."<br />";
	   	echo konf::get()->langTexty("forum_pform_prawidlowe")."</td></tr>"; 
	  	echo "</table>";
			echo $form->getFormk();
			
			echo "<br/>";
			echo "</td></tr>";
	   
		 	if(konf::get()->getAkcja()=="forum_dodajp"&&!empty($id_odp)){
	   		echo "<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'naglowek_class')."\">".konf::get()->langTexty("forum_pform_wodp");
				echo " <span class=\"grube\">".$dane2['autor']."</span>, ".substr($dane2['data'],0,16)."</td></tr>";
	   		echo "<tr><td class=\"".konf::get()->getKonfigTab("forum_konf",'tresc_class')."\"><br />";
	    	echo $this->tresc($dane2);
	    	echo "<br /><br /></td></tr>";
			}
		} else { 
			echo "</td></tr>"; 
		}
		
	  echo $this->stopka();
		
		$this->wyszukiwarka();
		
	}


  /**
   * new theme
   */	
	public function dodajt(){	
			
		$this->formularz();
		
	}
	
	
  /**
   * edit theme
   */	
	public function edytujt(){	
			
		$this->formularz();
		
	}	
	
	
  /**
   * new post
   */	
	public function dodajp(){	
			
		$this->formularz();
		
	}
	
	
  /**
   * edit post
   */	
	public function edytujp(){	
			
		$this->formularz();
		
	}	
		
	
  /**
   * add theme
   */	
	public function dodajt2(){

		$typy_tab=konf::get()->getKonfigTab("forum_konf",'typy_tab');
	  $f_temat=tekstForm::doSql(konf::get()->getZmienna('f_temat'));
	  $f_przyklejony=konf::get()->getZmienna('f_przyklejony');
	  $f_status=konf::get()->getZmienna('f_status');	
	  $f_kto=tekstForm::doSql(konf::get()->getZmienna('f_kto'));
	  $f_email=tekstForm::doSql(konf::get()->getZmienna('f_email'));
	  $f_tresc=tekstForm::doSql(konf::get()->getZmienna('f_tresc'));		
						
		$this->t_nr=""; 
		
		if(konf::get()->getKonfigTab("forum_konf",'nowy_t_dostep')){
		
			if(user::get()->zalogowany()){
				$f_kto=user::get()->login();
				$f_email=user::get()->email();
			} else {
				if(!preg_match("/".konf::get()->getKonfigTab('email_forma')."/",$f_email)){
					$f_email="";
				}
			}

			if(!$this->admin()||$f_przyklejony!="1"){
				$f_przyklejony=0; 
			}
			
			//sprawdzamy status tematu. tylkoadmin moze wstawic dowolny status
			if($this->admin()&&$typy_tab){
				if(empty($typy_tab[$f_status])){
					$f_status=konf::get()->getKonfigTab("forum_konf",'forum_domyslny_typ');
				}
			} else if($typy_tab){
				$status_d=$this->statusD($this->d_nr);
				if(($status_d==2&&!user::get()->zalogowany())||$status_d>2){
					$f_status="";
				} else { 
					$f_status=$status_d; 
				}
			} else {
				$f_status=konf::get()->getKonfigTab("forum_konf",'forum_domyslny_typ');
			}

			if(!empty($f_temat)&&!empty($f_status)&&!empty($f_kto)&&!empty($f_email)&&!empty($this->d_nr)&&!empty($f_tresc)){
			
		    if(konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'forum_t')." WHERE temat='".$f_temat."' AND id_d='".$this->d_nr."'")==0){
		    	$f_data=date("Y-m-d H:i:s");
		  		konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'forum_t')." VALUES(NULL,'".$this->d_nr."',".user::get()->id().",'".$f_kto."','".$f_email."','".$f_temat."','".$f_data."','".$f_data."','0','".$f_przyklejony."','".$f_status."')");
			  	$this->t_nr=konf::get()->_bazasql->insert_id;
					
				  if(!empty($this->t_nr)){
					  konf::get()->setKomunikat(konf::get()->langTexty("forum_dodajt_zapisany"),"");
						konf::get()->setZmienna("_post","t_nr",$this->t_nr);						
		  			$this->dodajp2($f_data,false); 
			  	} else { 
						konf::get()->setKomunikat(konf::get()->langTexty("forum_dodajt_blad"),"error"); 
					}
		    } else { 
					konf::get()->setKomunikat(konf::get()->langTexty("forum_dodajt_istnieje"),"error"); 
				}
			} else { 
				konf::get()->setKomunikat(konf::get()->langTexty("forum_dodajt_niepelne"),"error");  
			}
		}

	}


  /**
   * edit theme
   */	
	public function edytujt2(){

		$typy_tab=konf::get()->getKonfigTab("forum_konf",'typy_tab');
	  $f_temat=tekstForm::doSql(konf::get()->getZmienna('f_temat'));
	  $f_przyklejony=konf::get()->getZmienna('f_przyklejony');
	  $f_status=konf::get()->getZmienna('f_status');	
	  $f_kto=tekstForm::doSql(konf::get()->getZmienna('f_kto'));
	  $f_email=tekstForm::doSql(konf::get()->getZmienna('f_email'));

	  $post="";

		if($f_przyklejony!="1"){ 
			$f_przyklejony=0; 
		}
		
		//sprawdzamy status tematu. tylkoadmin moze wstawic dowolny status
		if($this->admin()&&$typy_tab){
			if(empty($typy_tab[$f_status])){
				$f_status=konf::get()->getKonfigTab("forum_konf",'forum_domyslny_typ');
			}
		} else {
			$f_status=konf::get()->getKonfigTab("forum_konf",'forum_domyslny_typ');
		}
		$status_d=$this->statusD($this->d_nr);
		
		if(empty($status_d)){ 
			$this->d_nr=""; 
		}
		
		if(!empty($f_temat)&&!empty($f_status)&&!empty($this->d_nr)){
		
	    if(konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'forum_t')." WHERE temat='".$f_temat."' AND id_d='".$this->d_nr."' AND id!='".$this->t_nr."'")==0){
	  		konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'forum_t')." SET id_d='".$this->d_nr."', temat='".$f_temat."', przyklejony='".$f_przyklejony."', status='".$f_status."' WHERE id='".$this->t_nr."'");
		  	konf::get()->setKomunikat(konf::get()->langTexty("forum_dodajt_zapisany"),"");
	    } else { 
				konf::get()->setKomunikat(konf::get()->langTexty("forum_dodajt_istnieje"),"error"); 
			}
	  } else { 
			konf::get()->setKomunikat(konf::get()->langTexty("forum_dodajt_niepelne"),"error"); 
		}  
		
	}


  /**
   * save post
   * @param string $data
   * @param bool $spr
   */	
	public function dodajp2($data="",$spr=true){

		$typy_tab=konf::get()->getKonfigTab("forum_konf",'typy_tab');	
	  $f_status=tekstForm::doSql(konf::get()->getZmienna('f_status'));	
	  $f_tresc=konf::get()->getZmienna('f_tresc');	
	  $f_status=konf::get()->getZmienna('f_status');	
	  $f_kto=tekstForm::doSql(konf::get()->getZmienna('f_kto'));
	  $f_email=tekstForm::doSql(konf::get()->getZmienna('f_email'));
		
		if(empty($data)){
			$data=date("Y-m-d H:i:s");
		}
		
		$p_nr=""; 	
		
		if(user::get()->zalogowany()){
		
			$f_kto=user::get()->login();
			$f_email=user::get()->email();
			
		} else {
			if(!preg_match("/".konf::get()->getKonfigTab('email_forma')."/",$f_email)){
				$f_email="";
			}
			
		}
		
		if(!empty($this->t_nr)){
			//sprawdzamy status. tylko admin moze wstawic status
			if($this->admin()&&$typy_tab){
				if(empty($typy_tab[$f_status])){
					$f_status=konf::get()->getKonfigTab("forum_konf",'forum_domyslny_typ');
				}
			} else if ($typy_tab){
				$f_status=$this->statusT($this->t_nr);
				if(!$this->admin()&&(($f_status==2&&!user::get()->zalogowany())||$f_status>2)){
					$f_status="";
				}
			} else {
				$f_status=konf::get()->getKonfigTab("forum_konf",'forum_domyslny_typ');
			}

		}
		
		if(!konf::get()->getKonfigTab("forum_konf",'zostaw_tagi')){
			$f_tresc=tekstForm::doSql($f_tresc);
		} else {
			$f_tresc=tekstForm::doSql($f_tresc,false);
			$f_tresc=strip_tags($f_tresc,konf::get()->getKonfigTab("forum_konf",'zostaw_tagi'));
		}		
		
		if(!empty($f_tresc)&&!empty($f_kto)&&!empty($f_email)&&!empty($f_status)&&!empty($this->t_nr)){
	    if(!$spr||(konf::get()->_bazasql->policz("id"," FROM ".konf::get()->getKonfigTab("sql_tab",'forum_p')." WHERE id_t='".$this->t_nr."' AND autor='".$f_kto."' AND email='".$f_email."' AND tresc='".$f_tresc."'")==0)){
	  		konf::get()->_bazasql->zap("INSERT INTO ".konf::get()->getKonfigTab("sql_tab",'forum_p')." VALUES(NULL,'".$this->t_nr."','".user::get()->id()."','".$f_kto."','".$f_email."','".konf::get()->getHost()."','".konf::get()->getIp()."','".$f_tresc."','".$data."','0','','','0','0','".$f_status."')");
		  	$p_nr=konf::get()->_bazasql->insert_id;
			  if(!empty($p_nr)){
				
	  			konf::get()->setKomunikat(konf::get()->langTexty("forum_dodajp_zapisany"),""); 
					
		  		if(konf::get()->getKonfigTab("forum_konf",'img_dostep')&&$this->czyJpg()&&!empty($_FILES['pic'])&&!empty($_FILES['pic']["tmp_name"])){
					
						require_once(konf::get()->getKonfigTab('klasy')."class.zapiszgrafike.php");
						
						$grafika=new zapiszGrafike($p_nr,konf::get()->getKonfigTab("forum_konf",'img_kat'),"pic","img");
						$grafika->setWszystkie(true);
						$grafika->setImgUsun(false);
						
						$grafika->setDaneImg(1,array(
							"hmax"=>konf::get()->getKonfigTab("forum_konf",'img_max'),
							"wmax"=>konf::get()->getKonfigTab("forum_konf",'img_max'),
							"hmin"=>konf::get()->getKonfigTab("forum_konf",'img_min'),
							"wmin"=>konf::get()->getKonfigTab("forum_konf",'img_min'),
							"typy"=>array(2=>2),
							"skala"=>3					
						));	

						$grafika->wykonaj();
						
						if($grafika->getSql()){	
						
							//jesli obrazek nie jest podlinkowany do tresci to linkujemy go na końcu
							if(substr_count($f_tresc,"[img]")>1) { 
								$f_tresc=str_replace("[img]","",$f_tresc); 
							} 
							
				  		if(strpos($f_tresc,"[img]")===false){ 
								$f_tresc.="\n[img]"; 
							}
										
	  	  			konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'forum_p')." SET tresc='".$f_tresc."', ".$grafika->getSql()." WHERE id='".$p_nr."'");
																							
						}							

			  	}
			  	
			  	if($spr){
				  	if(konf::get()->getKonfigTab("forum_konf",'najnowszy')){
				  		$postow=$this->policzT($this->t_nr)+1;
							$t_podstrona=$this->oblPodstrona($postow,konf::get()->getKonfigTab("forum_konf",'p_na_str'));
							if(!empty($t_podstrona)&&$t_podstrona>1){
								$podstrona=$t_podstrona;
							} 
						}
						konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'forum_t')." SET data='".$data."' WHERE id='".$this->t_nr."'");
					} 
	  		} else { 
					konf::get()->setKomunikat(konf::get()->langTexty("forum_dodajp_blad"),"error"); 
				}
	    } else { 
				konf::get()->setKomunikat(konf::get()->langTexty("forum_dodajp_istnieje"),"error"); 
			} 
		} else { 
			konf::get()->setKomunikat(konf::get()->langTexty("forum_dodajp_niepelne"),"error");  
		}
		
	  if(!empty($p_nr)){
	   	konf::get()->setAkcja("forum_zobacz");
	  } else {
	    konf::get()->setAkcja("forum_dodajp");	   
		}
		
	}



  /**
   * edit post
   */	
	public function edytujp2(){

		$p_nr=tekstForm::doSql(konf::get()->getZmienna('p_nr','p_nr'));		
		$typy_tab=konf::get()->getKonfigTab("forum_konf",'typy_tab');	
	  $f_status=tekstForm::doSql(konf::get()->getZmienna('f_status'));	
	  $f_tresc=konf::get()->getZmienna('f_tresc');	
	  $f_status=konf::get()->getZmienna('f_status');	
	  $f_kto=tekstForm::doSql(konf::get()->getZmienna('f_kto'));
	  $f_email=tekstForm::doSql(konf::get()->getZmienna('f_email'));
	  $usun_fotke=tekstForm::doSql(konf::get()->getZmienna('usun_fotke'));
		
		//sprawdzamy status. tylko admin moze wstawic status
		if($this->admin()&&$typy_tab){
			if(empty($typy_tab[$f_status])){
				$f_status=konf::get()->getKonfigTab("forum_konf",'forum_domyslny_typ');
			}
		}
		
		if(!konf::get()->getKonfigTab("forum_konf",'zostaw_tagi')){
			$f_tresc=tekstForm::doSql($f_tresc);
		} else {
			$f_tresc=tekstForm::doSql($f_tresc,false);
			$f_tresc=strip_tags($f_tresc,konf::get()->getKonfigTab("forum_konf",'zostaw_tagi'));
		}
		
		if(!empty($f_tresc)&&!empty($this->t_nr)&&!empty($p_nr)){
			
			$dane=konf::get()->_bazasql->pobierzRekord("SELECT * FROM ".konf::get()->getKonfigTab("sql_tab",'forum_p')." WHERE id='".$p_nr."'");

			if(!empty($dane)){
			
	    	$query="UPDATE ".konf::get()->getKonfigTab("sql_tab",'forum_p')." SET id_t='".$this->t_nr."'";								
							
		  	if(konf::get()->getKonfigTab("forum_konf",'img_dostep')&&$this->czyJpg()){
					
					require_once(konf::get()->getKonfigTab('klasy')."class.zapiszgrafike.php");
				
					$grafika=new zapiszGrafike($p_nr,konf::get()->getKonfigTab("forum_konf",'img_kat'),"pic","img",$dane);
					$grafika->setWszystkie(true);
					$grafika->setImgUsun($usun_fotke);
				
					$grafika->setDaneImg(1,array(
						"hmax"=>konf::get()->getKonfigTab("forum_konf",'img_max'),
						"wmax"=>konf::get()->getKonfigTab("forum_konf",'img_max'),
						"hmin"=>konf::get()->getKonfigTab("forum_konf",'img_min'),
						"wmin"=>konf::get()->getKonfigTab("forum_konf",'img_min'),						
						"typy"=>array(2=>2),
						"skala"=>3					
					));	
		
					$grafika->wykonaj();
				
					if($grafika->getSql()){	
									
						$query.=", ".$grafika->getSql();

		        //jesli obrazek nie jest podlinkowany do tresci to linkujemy go na końcu
	  	      if(substr_count($f_tresc,"[img]")>1) { 
							$f_tresc=str_replace("[img]","",$f_tresc); 
						} 
	  	      if(strpos($f_tresc,"[img]")===false){ 
							$f_tresc.="\n[img]"; 
						}
					}
				}	
				
				$query.=", tresc='".$f_tresc."'";
				
				if($this->admin()){
					$query.=", status='".$f_status."'";
				}
				
				$query.=" WHERE id='".$p_nr."'";

				konf::get()->_bazasql->zap($query);			
				
			}
			
			konf::get()->setKomunikat(konf::get()->langTexty("forum_dodajp_zapisany"),""); 
		} else { 
			konf::get()->setKomunikat(konf::get()->langTexty("forum_dodajp_niepelne"),"error");  
		}

	}

	
  /**
   * remove theme
   */	
	public function usunt(){

	  $id_tab=konf::get()->getZmienna('id_tab','id_tab');	
		
		if(!empty($id_tab)&&is_array($id_tab)){

		  $query=tekstForm::tabQuery($id_tab);
			
			if(!empty($query)){
				//sprawdzamy grafiki i usuwamy je
				$zap=konf::get()->_bazasql->zap("SELECT img1_nazwa FROM ".konf::get()->getKonfigTab("sql_tab",'forum_p')." WHERE id_t IN (".$query.") AND img1_nazwa!=''");
				while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
					if(file_exists(konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("forum_konf",'img_kat').$dane['img1_nazwa'])){
		 				unlink(konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("forum_konf",'img_kat').$dane['img1_nazwa']); 
			 		}
		 		}
			 	konf::get()->_bazasql->freeResult($zap);	
				
				konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'forum_p')." WHERE id_t IN (".$query.")");
				konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'forum_t')." WHERE id IN (".$query.")"); 
			}
			
			konf::get()->setKomunikat(konf::get()->langTexty("forum_usunt"),""); 
			
		}
		
	}

  /**
   * set typ theme
   */	
	public function typt(){

	  $id_tab=konf::get()->getZmienna('id_tab','id_tab');	
	  $f_status=konf::get()->getZmienna('f_status');	
				
		if(!empty($id_tab)&&is_array($id_tab)){			
		
			$query=tekstForm::tabQuery($id_tab);
			
			if(!empty($query)){
				konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'forum_t')." SET status='".tekstForm::doSql($f_status,true)."' WHERE id IN (".$query.")");
				user::get()->zapiszLog(konf::get()->langTexty("forum_statust_log"),user::get()->login());	
				konf::get()->setKomunikat(konf::get()->langTexty("forum_statust"),""); 
			}	
		}
		
	}


	/**
   * delete posts
   */	
	public function usunp(){
		global $konf;
		
		$id_tab=konf::get()->getZmienna('id_tab','id_tab');	
	  $query=tekstForm::tabQuery($id_tab);

		//sprawdzamy grafiki i usuwamy je
		$zap=konf::get()->_bazasql->zap("SELECT img1_nazwa FROM ".konf::get()->getKonfigTab("sql_tab",'forum_p')." WHERE id IN (".$query.") AND img1_nazwa!=''");
		while($dane=konf::get()->_bazasql->fetchAssoc($zap)){
			if(file_exists(konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("forum_konf",'img_kat').$dane['img1_nazwa'])){
	 			unlink(konf::get()->getKonfigTab("serwer").konf::get()->getKonfigTab("forum_konf",'img_kat').$dane['img1_nazwa']); 
	 		}
	 	}
	 	konf::get()->_bazasql->freeResult($zap);	
		
		if(!empty($query)){
			konf::get()->_bazasql->zap("DELETE FROM ".konf::get()->getKonfigTab("sql_tab",'forum_p')." WHERE id_t='".$this->t_nr."' AND id IN (".$query.")");
			user::get()->zapiszLog(konf::get()->langTexty("forum_usunp_log"),user::get()->login());	
			konf::get()->setKomunikat(konf::get()->langTexty("forum_usunp"),""); 
		}
	}
	

	/**
   * typ post
   */		
	public function typp(){

	  $id_tab=konf::get()->getZmienna('id_tab','id_tab');	
	  $f_status=tekstForm::doSql(konf::get()->getZmienna('f_status'));	

		if(!empty($id_tab)&&is_array($id_tab)){			
		
			$query=tekstForm::tabQuery($id_tab);
		
			if(!empty($query)){
				konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'forum_p')." SET status='".$f_status."' WHERE id IN (".$query.") AND id_t='".$this->t_nr."'");
				user::get()->zapiszLog(konf::get()->langTexty("forym_typp_log"),user::get()->login());	
				konf::get()->setKomunikat(konf::get()->langTexty("forum_typp"),""); 
			}
			
		}
			
	}


	/**
   * cut themes
   */		
	public function wytnijt(){

	  //pobieramy dane
	  $id_tab=konf::get()->getZmienna('id_tab','id_tab');
	  
	  //czyscimy pamiec  
		konf::get()->zapiszSession("forum_wytnijt_tab","");	
		
		//jesli dane to zapisujemy
	  if(!empty($id_tab)&&is_array($id_tab)){
			konf::get()->zapiszSession("forum_wytnijt_tab",$id_tab);		   
	    konf::get()->setKomunikat(konf::get()->langTexty("forum_wyt"),"");
	  } else { 
	    konf::get()->setKomunikat(konf::get()->langTexty("forum_wyt_brak"),"error");
		} 
		
	}


	/**
   * cut posts
   */		
	public function wytnijp(){

	  //pobieramy dane
	  $id_tab=konf::get()->getZmienna('id_tab','id_tab');
	  
	  //czyscimy pamiec  
		konf::get()->zapiszSession("forum_wytnijp_tab","");		
		
		//jesli dane to zapisujemy
	  if(!empty($id_tab)&&is_array($id_tab)){
			konf::get()->zapiszSession("forum_wytnijp_tab",$id_tab);		 
	    konf::get()->setKomunikat(konf::get()->langTexty("forum_wyt"),"");
	  } else { 
	    konf::get()->setKomunikat(konf::get()->langTexty("forum_wyt_brak"),"error");
		} 
		
	}



	/**
   * paste themes
   */		
	public function wklejt(){

		//dane do przeniesienia
	  $id_tab=tekstForm::doSql(konf::get()->getZmienna('','','forum_wytnijt_tab'));
		
		//sprawdzamy czy sa dane
		if(!empty($id_tab)&&is_array($id_tab)){
		
			if(!empty($this->d_nr)&&$this->statusD($this->d_nr)){
				
				$query=tekstForm::tabQuery($id_tab);
			
				if(!empty($query)){
					konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'forum_t')." SET id_d='".tekstForm::doSql($this->d_nr)."' WHERE id IN (".$query.")");
					user::get()->zapiszLog(konf::get()->langTexty("forum_dzialt_log"),user::get()->login());	
					konf::get()->setKomunikat(konf::get()->langTexty("forum_dzialt"),"");
				}	
			} else { 
				konf::get()->setKomunikat(konf::get()->langTexty("forum_dzialt_blad"),"error"); 
			}
			
		}

		konf::get()->zapiszSession("forum_wytnijt_tab","");		
	  
	}



	/**
   * paste posts
   */		
	public function wklejp(){

		//dane do przeniesienia
	  $id_tab=tekstForm::doSql(konf::get()->getZmienna('','','forum_wytnijp_tab'));

		//sprawdzamy czy sa dane
		if(!empty($id_tab)&&is_array($id_tab)){

			if(!empty($this->t_nr)&&$this->statusT($this->t_nr)){
				
				$query=tekstForm::tabQuery($id_tab);
			
				if(!empty($query)){
					konf::get()->_bazasql->zap("UPDATE ".konf::get()->getKonfigTab("sql_tab",'forum_p')." SET id_t='".$this->t_nr."' WHERE id IN (".$query.")");
					user::get()->zapiszLog(konf::get()->langTexty("forum_przeniesp_log"),user::get()->login());	
					konf::get()->setKomunikat(konf::get()->langTexty("forum_przeniesp"),"");
				}	
				
			} else { 
				konf::get()->setKomunikat(konf::get()->langTexty("forum_przeniesp_blad"),"error"); 
			}
			
		}
		
		konf::get()->zapiszSession("forum_wytnijp_tab","");	
	  
	}	
	
	/**
   * class constructor php5	
   */	
	public function __construct() {	
	
		$this->_admin=konf::get()->getKonfigTab("forum_konf",'admin_forum');
		
		$this->d_nr=konf::get()->getZmienna('d_nr','d_nr');
		if(empty($this->d_nr)){
			if(konf::get()->getKonfigTab("forum_konf",'default_d')){
				$this->d_nr=konf::get()->getKonfigTab("forum_konf",'default_d');
			} else {
				$this->d_nr="";
			}
		}

		$this->t_nr=tekstForm::doSql(konf::get()->getZmienna('t_nr','t_nr'));				
		$this->d_nr=tekstForm::doSql($this->d_nr); 			

  }	
	

}



?>