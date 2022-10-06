<?php
//-----------------------------------------------------------------------------
// SWF HEADER - version 1.0
// Small utility class to determine basic data from a SWF file header
// Does not need any php-flash extension, based on raw binary data reading
// modified by Waldemar Jonik jwaldek@gmail.com
//-----------------------------------------------------------------------------
//	SWFHEADER CLASS - PHP SWF header parser
//	Copyright (C) 2004  Carlos Falo Herv&#3146;//
//	This library is free software; you can redistribute it and/or
//	modify it under the terms of the GNU Lesser General Public
//	License as published by the Free Software Foundation; either
//	version 2.1 of the License, or (at your option) any later version.
//
//	This library is distributed in the hope that it will be useful,
//	but WITHOUT ANY WARRANTY; without even the implied warranty of
//	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
//	Lesser General Public License for more details.
//
//	You should have received a copy of the GNU Lesser General Public
//	License along with this library; if not, write to the Free Software
//	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
//-----------------------------------------------------------------------------


if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}	

class swfHeader {

	/**
	 * nazwa klasy
	 */				
  private $_nazwaKlasy="swfheader class";

	public $fname="";					// SWF file analyzed
	public $magic="";					// Magic in a SWF file (FWS or CWS)
	public $compressed=false;	// Flag to indicate a compressed file (CWS)
	public $version=0;					// Flash version
	public $size=0;						// Uncompressed file size (in bytes)
	public $width=0;						// Flash movie native width
	public $height=0;					// Flash movie native height
	public $valid=false;				// Valid SWF file
	public $fps=array();				// Flash movie native frame-rate
	public $frames=0;					// Flash movie total frames


  /**
   * zwraca nazwe klasy
   * @return string				
   */		
	public function getNazwaKlasy(){
		return $this->_nazwaKlasy;
	}	
				
			
  /**
   * odczytuje plik
   * @param string $filename		
   */	
		
	public function loadswf($filename) {
	
		$this->fname = $filename ;
		$fp = @fopen($filename,"rb");
		
		if($fp){

			// Read MAGIC FIELD
			$this->magic = fread($fp,3) ;
			if ($this->magic!="FWS" && $this->magic!="CWS") {
				$this->valid =  0 ;
			} else {
			
				// Compression
				if (substr($this->magic,0,1)=="C"){
					$this->compressed = true ;
				} else {
					$this->compressed = false ;
				}
				
				// Version
				$this->version = ord(fread($fp,1)) ;
				
				// Size
				$lg = 0 ;
				
				// 4 LSB-MSB
				for ($i=0;$i<4;$i++) {
					$t = ord(fread($fp,1)) ;
					$lg += ($t<<(8*$i)) ;
				}				
				$this->size = $lg ;
				
				// RECT... we will "simulate" a stream from now on... read remaining file
				$buffer = fread($fp,$this->size) ;
				if ($this->compressed) {
					// First decompress GZ stream
					$buffer = gzuncompress($buffer,$this->size) ;
				}
				
				$b 			= ord(substr($buffer,0,1)) ;
				$buffer = substr($buffer,1) ;
				$cbyte 	= $b ;
				$bits 	= $b>>3 ;
				$cval 	= "" ;
				
				// Current byte
				$cbyte &= 7 ;
				$cbyte<<= 5 ;
				
				// Current bit (first byte starts off already shifted)
				$cbit 	= 2 ;
				
				// Must get all 4 values in the RECT
				for ($vals=0;$vals<4;$vals++) {
					$bitcount = 0 ;
					while ($bitcount<$bits) {
						if ($cbyte&128) {
							$cval .= "1" ;
						} else {
							$cval.="0" ;
						}
						
						$cbyte<<=1 ;
						$cbyte &= 255 ;
						$cbit-- ;
						$bitcount++ ;
						
						// We will be needing a new byte if we run out of bits
						if ($cbit<0) {
							$cbyte	= ord(substr($buffer,0,1)) ;
							$buffer = substr($buffer,1) ;
							$cbit = 7 ;
						}
					}
					
					// O.k. full value stored... calculate
					$c 		= 1 ;
					$val 	= 0 ;
					
					// Reverse string to allow for SUM(2^n*$atom)
					$tval = strrev($cval) ;
					for ($n=0;$n<strlen($tval);$n++) {
						$atom = substr($tval,$n,1) ;
						if ($atom=="1"){
							$val+=$c ;
						}
						// 2^n
						$c*=2 ;
					}
					
					// TWIPS to PIXELS
					$val/=20 ;
					
					switch ($vals) {
					
						case 0:
							// tmp value
							$this->width = $val ;
						break ;
						
						case 1:
							$this->width = $val - $this->width ;
						break ;
						
						case 2:
							// tmp value
							$this->height = $val ;
						break ;
						
						case 3:
							$this->height = $val - $this->height;
						break ;
						
					}
					
					$cval = "";
				}
				
				// Frame rate
				$this->fps = Array();
				for ($i=0;$i<2;$i++){
					$t 			= ord(substr($buffer,0,1));
					$buffer = substr($buffer,1);
					$this->fps[] = $t;
				}
				
				// Frames
				$this->frames = 0 ;
				for ($i=0;$i<2;$i++) {
					$t 			= ord(substr($buffer,0,1));
					$buffer = substr($buffer,1);
					$this->frames += ($t<<(8*$i));
				}
				
				fclose($fp) ;
				$this->valid =  1 ;
				
	  		}
		} else {
			$this->valid = 0 ;
		}
		
		return $this->valid ;
		
	}
	
	/**
   * class constructor php5	
   * @param string $filename	
   */	
	public function __construct($filename) {	
		$this->loadswf($filename);	
  }	

	
}

?>