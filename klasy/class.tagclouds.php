<?php

/**
 * tagcloud class v1.0
 * dla CMS i innych klas - chmura tagow
 * All rights reserved
 * @package tagclouds class
 * @author Waldemar Jonik jwaldek@gmail.com
 * @copyright 2009 Waldemar Jonik
 */

/**
 *
 * Example:
 *
  require_once("class.tagclouds.php");
	$tags=new tagclouds(konf::get()->getKonfigTab("sql_tab",'news_tags'),30,$dane['id']);	
	echo $tags_string=$tags->getTagclouds();	
		
 * SQL tables example:
	

--
-- $table (tags list)
--

CREATE TABLE IF NOT EXISTS `rocket_news_tags` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tag` varchar(200) NOT NULL,
  `ile` int(8) unsigned NOT NULL default '0',
  `dlugosc` smallint(4) unsigned NOT NULL default '0',
  `typ` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `typ` (`typ`)
) TYPE=MyISAM ;

-- --------------------------------------------------------

--
-- $table2 (tags - elements list)
--

CREATE TABLE IF NOT EXISTS `rocket_news_tags_news` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `id_matka` int(11) unsigned NOT NULL default '0',
  `id_tag` int(11) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `id_matka` (`id_matka`),
  KEY `id_tag` (`id_tag`),	
) TYPE=MyISAM ;
	
	
 */
	
class tagclouds{

	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="tagclouds class";

  /**
   * Array with words and word count
   * @var array
   */
  protected $_tags = array ();

  /**
   * Minimum occurrences of a word to be displayed
   * @var integer
   */
  protected $_minIle = 0;
	
  /**
   * Maximum words displayed/saved
   * @var integer
   */
  protected $_ile = 30;	
	
  /**
   * Minimum length of word to be displayed/saved
   * @var integer
   */
  protected $_minWordLen = 3;

  /**
   * Maximum length of a word to be displayed/saved
   * @var integer
   */
  protected $_maxWordLen = 30;

  /**
   * Minimum font size of a tag to be displayed
   * @var integer
   */
  protected $_minFontSize = 10;

  /**
   * Maximum font size of a tag to be displayed
   * @var integer
   */
  protected $_maxFontSize = 50;

  /**
   * Sort method (alphabetical, count, random)
   * @var string
   */
  protected $_sort = 'alphabetical';
	
  /**
   * Filter numeric words (onSave)
   * @var boolean
   */
  protected $_filterNumeric = TRUE;

  /**
   * Words to not be saved
   * @var array
   */
  protected $_excludeWords = array ();

  /**
   * Tagclouds title
   * @var string
   */
  protected $_tytul = '';

  /**
   * Full HTML output
   * @var string
   */
  protected $_output = '';
		
  /**
   * sql tags table
   * @var string
   */
  protected $_tabela = '';	
	
  /**
   * sql tags-items table
   * @var string
   */
  protected $_tabela2 = '';		
				
  /**
   * tag link with "[-tag-]" string as replacement for tag
   * @var string
   */
  protected $_link = '';		
		
  /**
   * Maximum number of style class to use
   * @var integer
   */
  protected $_classnumber = 5;	
	
  /**
   * class name  (used for change colour etc. with tags count)
   * @var string
   */
  protected $_classname = "";			
	
  /**
   * min occurs of word for display
   * @var int
   */	
	protected $_minOccurs = 1;
	
  /**
   * max occurs of word for display
   * @var int
   */	
	protected $_maxOccurs = 0;	
		
  /**
   * Tags element separator
   * @var string
   */
  protected $_separator = ',';	
	
	

  /**
   * zwraca nazwe klasy
   * @return string				
   */		
	public function getNazwaKlasy(){
		return $this->_nazwaKlasy;
	}	
	
	
  /**
   * set tabela
   * @param string $tabela
   */		
	public function setTabela($tabela){

		if(empty($tabela)){
			trigger_error("setTabela: invalid tabela value ".$this->getNazwaKlasy(),E_USER_ERROR);
		} else {
			$this->_tabela=$tabela;
		}
		
	}		
	
  /**
   * set tabela 2
   * @param string $tabela2
   */		
	public function setTabela2($tabela2){
	
		if(empty($tabela2)){
			trigger_error("setTabela2: invalid tabela value ".$this->getNazwaKlasy(),E_USER_ERROR);
		} else {
			$this->_tabela2=$tabela2;
		}
		
	}			
	
  /**
   * set separator
   * @param string $separator
   */		
	public function setSeparator($separator=","){
	
		if($separator!=''){
			$this->_separator=$separator;
		} else {
			trigger_error("setSeparator: invalid separator value ".$this->getNazwaKlasy(),E_USER_ERROR);		
		}
		
	}			
	
	
  /**
   * set link use [-tag-] string in link for tag replacement
   * @param string $link
   */		
	public function setLink($link){
	
		if(empty($link)){
			$this->_link="";
		} else {
			$this->_link=$link;
		}
		
	}		
	
	
  /**
   * set tytul
   * @param string $tytul
   */		
	public function setTytul($tytul){
	
		if(empty($tytul)){
			$this->_tytul="";
		} else {
			$this->_tytul=$tytul;
		}
		
	}			
		
				
  /**
   * Define limit of tags   
   * @param  int $ile
   */
  public function setIle ($ile){
	
	 	$ile=$ile+0;	
    $this->_ile = $ile;
					
  }		
		
  /**
   * Define typ  
   * @param  int $typ
   */
  public function setTyp ($typ){
	
	 	$typ=$typ+0;	
    $this->_typ = $typ;
					
  }		
				
  /**
   * Define min count of tags for  display    
   * @param  int $min
   */
  public function setMinIle ($min){
	
 		$min=$min+0;		
    $this->_minIle = $min;
					
  }		
	
  /**
   * Define max class number   
   * @param  int $ile
   */
  public function setClassNumber ($ile){
	
 		$ile=$ile+0;		
    $this->_classnumber = $ile;
					
  }		
	
  /**
   * set class name
   * @param string $name
   */		
	public function setClassName($name){
	
		if(empty($name)){
			$this->_classname="";
		} else {
			$this->_classname=$name;
		}
		
	}					
		
	/**
	 * Change minimum length of a word to be displayed/saved
	 * @param  integer
	 */
	public function setMinWordLength ($val){

		//Validate and save value
	  $this->_minWordLen = is_numeric ($val) ? intval ($val) : $this->_minWordLen;

	}
	
	/**
	 * Change maximum length of a word to be displayed/saved
	 * @param  integer
	 */
	public function setMaxWordLength ($val){

	  //Validate and save value
	  $this->_maxWordLen = is_numeric ($val) ? intval ($val) : $this->_maxWordLen;

	}

  /**
   * Change minimum font size of a tag to be displayed
   * @param  integer
   */
  public function setMinFontSize ($val){
	
    $this->_minFontSize = is_numeric ($val) ? intval ($val) : $this->_minFontSize;
		
  }

  /**
   * Change maximum font size of a tag to be displayed
   * @param  integer
   */
  public function setMaxFontSize ($val){
     $this->_maxFontSize = is_numeric ($val) ? intval ($val) : $this->_maxFontSize;
  }	
	
	
  /**
   * display sort method
   * @param  string $sort
   */
  public function setSort ($sort){
	
    //Correct value
    $sort = strtolower (trim ($sort));

    //Define supported methods for sorting
    $allowedSortMethods = array (
       'alphabetical' ,
       'count' ,
       'random',				
    );

    //Validate and save value
    $this->_sort = in_array ($sort, $allowedSortMethods) ? $sort : 'alphabetical';
		
  }	

  /**
   * Filter numeric words
   * @param  boolean
   */
  public function setFilterNumeric($filter = TRUE){
	
    $this->_filterNumeric = (boolean) $filter;
		
  }
	
		
  /**
   * Add more words to not be saved
   * @param  mixed (Array or string)
   * @return boolean TRUE on success, FALSE on error
   */
  public function exclude ($exclude){
	
    if (!empty ($exclude)){
	
      if (is_array ($exclude)){
		
        $this->_excludeWords = array_merge ($this->_excludeWords, $exclude);
				
      } else if (is_string ($exclude)){
			
        //Clean string
        $exclude = $this->strip_specialchars ($exclude);

        //Convert string to array
        $exclude = explode (' ', $exclude);

        //Merge with existing exclusion words array
        if (is_array ($exclude) && ! empty ($exclude)){
           $this->_excludeWords = array_merge ($this->_excludeWords, $exclude);
        }
				
      }
			
    } else {
		
			$this->_excludeWords=array();
		
	 	}	

  }		

  /**
   * Clean string of whitespace and special characters
   * @param  string
   * @return string
   */
  protected function stripSpecialchars ($string = ''){
	
     //Handle whitespace
     $string = str_replace ("&nbsp;", " ", $string); //Windows
     $string = str_replace ("\r\n", " ", $string); //Windows
     $string = str_replace ("\r", " ", $string); //Mac
     $string = str_replace ("\n", " ", $string); //*NIX
     $string = str_replace ("\t", " ", $string); //TAB
     $string = str_replace ("\0", "", $string); //NULL BYTE
     $string = str_replace ("\x0B", "", $string); //Vertical TAB

     //Remove anything except word, digit characters and spaces, at the end remove multiple spaces
     $pattern = array ('#[\'"/\._\-()!?@\#$%^&*+:;=`<>\\\]#i','#[\s]+#');
		
     $string = preg_replace ($pattern, ' ', $string);

     return trim ($string);
		
  }

  /**
   * Convert special characters to HTML entities
   * @param  string String to be escaped
   * @return string Escaped string
   */
  protected function escape ($string = ''){
     //Escape
     $char_set = defined ('CHARSET') ? CHARSET : 'UTF-8';
     return htmlspecialchars ($string, ENT_QUOTES, $char_set);
		
  }	

  /**
   * Clean tag string of unneeded characters
   * (This will also escape the string)
   * @param  string
   * @return string
   */
  protected function cleanTagstring ($string = ''){
	
    //Remove HTML and PHP tags
    $string = strip_tags ($string);

    //Strip whitespace
    $string = $this->stripSpecialchars ($string);

    //Convert special characters to HTML entities
    $string = $this->escape ($string);

    //Make lowercase and trim
    $string = tekstForm::male (trim ($string));

    return $string;
			
  }		

	/**
	 * Build tags output and return it
	 *
	 * @return string
	 */
	public function getTagclouds () {

		if(!empty($this->_tabela)){

			$sql="SELECT * FROM ".$this->_tabela." WHERE 1";
			if(!empty($this->_typ)){
				$sql.=" AND typ=".$this->_typ;
			}			
			if(!empty($this->_minIle)){
				$sql.=" AND ile>=".$this->_minIle;
			} else {
				$sql.=" AND ile>0";			
			}
			if(!empty($this->_minWordLen)){
				$sql.=" AND dlugosc>=".$this->_minWordLen;
			}			
			if(!empty($this->_maxWordLen)){
				$sql.=" AND dlugosc<=".$this->_maxWordLen;
			}		
			
			$sql.=" ORDER BY ";		

			switch($this->_sort){
			
				case 'count':
					$sql.="ile DESC";
				break;
				
				case 'random':
					$sql.="RAND()";
				break;	
				
				default:
					$sql.="tag, ile DESC";			
					
			}

			if(!empty($this->_ile)){
				$sql.=" LIMIT 0,".$this->_ile;
			}		
			
			$dane_tab=konf::get()->_bazasql->pobierzRekordy($sql,"id");
			
			if(!empty($dane_tab)){
			
				if($this->_sort=="random"&&$this->_ile){
					shuffle($dane_tab);
				}
			
				while(list($key,$dane)=each($dane_tab)){
					
					if($dane['ile']<$this->_minOccurs||$this->_minOccurs==0){
						$this->_minOccurs=$dane['ile'];
					}
					if($dane['ile']>$this->_maxOccurs){
						$this->_maxOccurs=$dane['ile'];
					}			
						
					$this->_tags[]=array("tag"=>$dane['tag'],"count"=>$dane['ile']);
				}
			
			}
		
		  //Build the output
		  $this->buildOutput();

		  //Make output
		  return $this->_output;

		} else {

			trigger_error("getTagClouds: invalid tabela value ".$this->getNazwaKlasy(),E_USER_ERROR);		

		}

	}
	

   /**
    * Build array with tags from string
    * @param  string
    * @return boolean TRUE on success, FALSE on error (=empty tags string)
    */
   public function buildTagsArray ($string = ''){
		
      if (empty ($string)){
			
        return FALSE;
				
      } else {
			
				$string=$this->cleanTagstring($string);
						
        //Explode string to array and count words
        $array_content = explode ($this->_separator, $string);				
				$byly=array();

        //Process each word at a time
        while(list($key,$tag)=each($array_content)){
				
				 	$tag=trim($tag);
			
          //Check if word is numeric
          if (TRUE === $this->_filterNumeric && is_numeric ($tag)){
            continue;
          }

          //Check word length
          if (tekstForm::utf8Strlen($tag) < $this->_minWordLen || ($this->_maxWordLen&&tekstForm::utf8Strlen($tag) > $this->_maxWordLen)){						
            continue;							
          }

          //Check if in exclude words
          if (in_array ($tag, $this->_excludeWords)){						
            continue;
          }

          //Word is OK, no exists, add to new array					
					if(!in_array($tag,$byly)){
	          $this->_tags[] =array('tag'=>$tag,'count'=>1);
						$byly[]=$tag;
					} else {
						//here we can build counter++;
					}
					
        }

      }

      return TRUE;
			
   }
		
		
   /**
    * save tags
    * @param  int $id_matka
    * @return boolean TRUE on success, FALSE on error
    */
				
	 public function saveTags($id_matka){
		
	 	$ok=false;	

    if (empty ($this->_tabela)||empty($this->_tabela2)){
	
			trigger_error("getTagString: invalid tabela value ".$this->getNazwaKlasy(),E_USER_ERROR);	
		
    } else if(empty($id_matka)){

			trigger_error("getTagString: invalid id_matka value ".$this->getNazwaKlasy(),E_USER_ERROR);	
					
		} else {
	
			$dane_tab=konf::get()->_bazasql->pobierzRekordy("SELECT p.* FROM ".$this->_tabela." p,".$this->_tabela2." t WHERE t.id_matka='".tekstForm::doSql($id_matka)."' AND t.id_tag=p.id AND p.typ='".$this->_typ."' ORDER BY p.tag","id");
			
			$byly=array();
			
			while(list($key,$dane)=each($this->_tags)){
			
				//sprawdzamy czy juz go nie zapisywalismy
				if(!in_array($dane['tag'],$byly)){
				
					$byly[]=$dane['tag'];
					$id_tag=0;					

					reset($dane_tab);
			
					while(list($key2,$dane2)=each($dane_tab)){
					
						if($dane2['tag']==$dane['tag']){
							$id_tag=$key2;
							break;
						}
					
					}
					
					//nowy tag dla tego elementu
					if(empty($id_tag)){
					
						$tag_dane=konf::get()->_bazasql->pobierzRekord("SELECT p.* FROM ".$this->_tabela." p WHERE p.typ='".tekstForm::doSql($this->_typ)."' AND p.tag='".tekstForm::doSql($dane['tag'])."' ORDER BY p.tag");

						//juz istnial dla innych
						if(!empty($tag_dane)&&empty($dane_tab[$tag_dane['id']])){
						
							konf::get()->_bazasql->zap("UPDATE ".$this->_tabela." p SET ile=ile+1 WHERE p.typ='".$this->_typ."' AND p.id='".$tag_dane['id']."'");												
							$id_tag=$tag_dane['id'];
							
						//jeszce go nie byo na ilnnych elementow
						} else {
												
							konf::get()->_bazasql->zap("INSERT INTO ".$this->_tabela." (tag,ile,dlugosc,typ) VALUES ('".tekstForm::doSql($dane['tag'])."',1,".tekstForm::utf8Strlen($dane['tag']).",'".tekstForm::doSql($this->_typ)."')");
							$id_tag=konf::get()->_bazasql->insert_id;
						
						}
						
						if(!empty($id_tag)){
							konf::get()->_bazasql->zap("INSERT INTO ".$this->_tabela2." (id_matka,id_tag) VALUES ('".tekstForm::doSql($id_matka)."',".$id_tag.")");
						}						
					
					//tag byl wiec pomijamy go															
					} else {
				
						unset($dane_tab[$id_tag]);
						
					}
					
				}
			
			}
			
			//jesli zostala tablica to znaczy ze usunieto jakies tagi
			if(!empty($dane_tab)){
				reset($dane_tab);
				$sql="";
				
				///robimy liste do usuniecie
				while(list($key,$dane2)=each($dane_tab)){
				
					if(!empty($sql)){
						$sql.=",";
					}
					$sql.=$dane2['id'];
				
				}
				
				if(!empty($sql)){
					//usuwamy przypisania tagow
					konf::get()->_bazasql->zap("DELETE FROM ".$this->_tabela2." WHERE id_matka='".tekstForm::doSql($id_matka)."' AND id_tag IN(".$sql.")");
					//odejmujemy liczniki
					konf::get()->_bazasql->zap("UPDATE ".$this->_tabela." SET ile=ile-1 WHERE id IN(".$sql.") AND typ='".tekstForm::doSql($this->_typ)."' AND ile>0");					
				}
				
			}
			
			$ok=true;

    }	
		
		return $ok;	
		
	 }		
		
		
	/**
	 * Build string from tags - get it from table
	 * @param int id_matka	
	 * @return string
	 */
	public function getTagsString ($id_matka){
	
		$txt="";

    if (empty ($this->_tabela)||empty($this->_tabela2)){
	
			trigger_error("getTagString: invalid tabela value ".$this->getNazwaKlasy(),E_USER_ERROR);	
		
    } else if(empty($id_matka)){

			trigger_error("getTagString: invalid id_matka value ".$this->getNazwaKlasy(),E_USER_ERROR);	
					
		} else {

			$dane_tab=konf::get()->_bazasql->pobierzRekordy("SELECT p.tag FROM ".$this->_tabela." p,".$this->_tabela2." t WHERE t.id_matka='".tekstForm::doSql($id_matka)."' AND p.typ='".$this->_typ."' AND t.id_tag=p.id ORDER BY p.tag","id");
			
			$txt="";
			
			while(list($key,$dane)=each($dane_tab)){
				if(!empty($txt)){
					$txt.=$this->_separator;
				}
				$txt.=$dane['tag'];
			}
			

    }

    return $txt;
			
	}		

	
  /**
   * Build HTML output
   * @return boolean TRUE on success ($output populated), FALSE on error (no tags/words available)
   */
	protected function buildOutput(){

		if(empty($this->_tags)||!is_array ($this->_tags)){
			
      //No tags/word, return empty output
      $this->_output = '';
      return FALSE;
							
    } else {
		
      //Add a title if available
      if (! empty ($this->_tytul)){
        $this->_output .= "<div>".$this->_tytul."</div>";
      }

			reset($this->_tags);
			
      while(list($key,$val)=each($this->_tags)){

				//Calculate font-size for current tag
				if($this->_maxOccurs!=$this->_minOccurs&&$val['count']>$this->_minOccurs){
					$weight = (log ($val['count']) - log ($this->_minOccurs)) / (log ($this->_maxOccurs) - log ($this->_minOccurs));
				} else {
					$weight=0;
				}
				
				$fontSize = round($this->_minFontSize + round (($this->_maxFontSize - $this->_minFontSize) * $weight));
				
				//Calculate style class (usually for CSS colors)
				if($this->_classname&&$this->_classnumber)	{
				  $styleClass = ceil (((($val['count'] - $this->_minCountValue) * 100) / ($this->_maxOccurs - $this->_minCountValue)) / (100 / $this->_classnumber));
				} else {
					$styleClass=$this->_classname;
				}

				if($this->_link){
				  $this->_output .= '<a href="' .str_replace("[-tag-]",$val['tag'],$this->_link).'" title="'.$val['tag'].'" ';
				} else {
				  $this->_output .= '<span ';						
				}

				if($styleClass){
				  $this->_output .= 'class='.$styleClass.'" ';						
				}

				$this->_output .= 'style="font-size:'.$fontSize.'px;">'.$val['tag'];
					
				if($this->_link){
				  $this->_output .= '</a> ';
				} else {
				  $this->_output .= '</span> ';						
				}		

			}

			//Trim output (last char is a space)
			$this->_output = trim ($this->_output);

    }
		
		$this->_output;

		return TRUE;
			
  }
		
		
  /**
   * konstruktor	
   * @param string $tabela				
   * @param int $ile	
   * @param int $typ
   */	
	public function __construct($tabela="",$ile=0,$typ="") {
				
		if(!empty($tabela)){
			$this->setTabela($tabela);
		}
		$this->setIle($ile);
		$this->setTyp($typ);		
		
	}		
		

		
}
