
//szybkosc przewijania tekstu
var speed=3; 

//zatrzymywac po najechaniu myszka
var onMouseOverPause=1;

//tekst
var tekst='';

//dlugosc tekstu (przyblizona w pikselach?)
var imageWidth=tekst.length*8;

//wysokosc paska
var imageHeight=25;

var dps=document;
var pstn;
var cPs=speed;
var pPs=(onMouseOverPause==0)?cPs:0;
var divekName1='pasekScroll1';
var divekName2='pasekScroll2';
var psbel='psbl';
var psbel2='psbl2';
var myWidth = 0, myHeight = 0;
var dokument='';	
var aWh=0;


function psdgs(id) { 
	return dps.getElementById(id).style; 
} 

function psdg(id)  { 
	return dps.getElementById(id); 
}  

function ClientSize() {
	if( typeof( window.innerWidth ) == 'number' ) {
	//Non-IE
		dokument=window;
		myWidth = dokument.innerWidth;
		myHeight = dokument.innerHeight;
	} else if( dps.documentElement && ( dps.documentElement.clientWidth || dps.documentElement.clientHeight ) ) {
		dokument=dps.documentElement;
		//IE 6+ in 'standards compliant mode'
		myWidth = dokument.clientWidth;
		myHeight = dokument.clientHeight;
	} else if( dps.body && ( dps.body.clientWidth || dps.body.clientHeight ) ) {
		//IE 4 compatible
		dokument=dps.body;
		myWidth = dokument.clientWidth;
		myHeight = dokument.clientHeight;
	}
}

//pozycjonowanie paska na dole www
function psbepo() {
  ClientSize();
  psdgs(psbel).left = 0;
  if (dps.all) psdgs(psbel).top = (dokument.scrollTop + myHeight - imageHeight)+'px';
  else psdgs(psbel).top = (myHeight - imageHeight)+'px';
  if (dps.all) psdgs(psbel).left = (dokument.scrollLeft)+'px';
  psdgs(psbel).width = myWidth+'px';
  psdgs(psbel2).width = myWidth+'px';
} 

function moveIt() {
  divekPos1=parseInt(divek1.style.left);
  divek1.style.left=divekPos1-cPs+'px';
  divekPos2=parseInt(divek2.style.left);
  divek2.style.left=divekPos2-cPs+'px';
  if (Math.abs(divekPos1)>=aWh) divek1.style.left=divekPos2+aWh-speed+'px';
  if (Math.abs(divekPos2)>=aWh) divek2.style.left=divekPos1+aWh-speed+'px';
}	


function pasek_rysuj(){

	if (dps.all||dps.getElementById) {

		ClientSize();
  				
		//polozenie paska przy zmianie rozmiaru okna lub przy scrollowaniu
		if (window.attachEvent) { 
			window.attachEvent("onscroll", psbepo); 
			window.attachEvent("onresize", psbepo); 
			pstn = "absolute"; 
		} else { 
			window.addEventListener("resize",psbepo, 1); 		
			pstn = "fixed"; 
		} 

		//rysowanie paska
		dps.write('<div class="pasek_linia" id="'+psbel+'" style="overflow:hidden; margin:0px; padding:0px; border:0px; position:'+pstn+'; top:-'+(imageHeight*2)+'; left:0px; width:'+(myWidth-0)+'px;height:'+imageHeight+'px; z-index:9900;" onmouseover="cPs=pPs" onmouseout="cPs=speed">');
		dps.write('<div class="pasek_tlo" id="'+psbel2+'" style="position:absolute; left:0px; top:1px; overflow:visible; height:'+(imageHeight-1)+'px; width:'+(myWidth-0)+'px; ">');
		dps.write('<div class="nobr" id="'+divekName1+'" style="overflow:hidden; position:absolute; left:0px; top:5px; text-align:left;"><'+'/div>');
		dps.write('<div class="nobr" id="'+divekName2+'" style="overflow:hidden; position:absolute; left:0px; top:5px; text-align:left;"><'+'/div>');
		dps.write('<'+'/div><'+'/div>');

		//umieszczenie tekstu na pasku
		divek1=dps.getElementById?psdg(divekName1):dps.all[divekName1];
	  divek2=dps.getElementById?psdg(divekName2):dps.all[divekName2];
	  divek1.innerHTML=tekst;
	  divek2.innerHTML=divek1.innerHTML;
		
		//przewijanie tekstu w poziomie
		aWh=(Math.floor(screen.width/imageWidth)+1)*imageWidth;	
		
	  divek2.style.left=aWh-speed+'px'; 
	  
	  scrolling=setInterval("moveIt()",20);
		
		//pozycjonowanie paska	
		setTimeout("psbepo()",500);
		
	}
	
}
