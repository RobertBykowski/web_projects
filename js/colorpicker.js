// http://www.interclasse.com/scripts/colorpicker.php

var picker_total=1657;
var picker_X=picker_Y=picker_j=picker_RG=picker_B=0;
var picker_hexbase=new Array("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F");
var ns6=document.getElementById&&!document.all;
var ie=document.all;
var picker_artabus='';

var picker_aR=new Array(picker_total);
var picker_aG=new Array(picker_total);
var picker_aB=new Array(picker_total);
for (var i=0;i<256;i++){
  picker_aR[i+510]=picker_aR[i+765]=picker_aG[i+1020]=picker_aG[i+5*255]=picker_aB[i]=picker_aB[i+255]=0;
  picker_aR[510-i]=picker_aR[i+1020]=picker_aG[i]=picker_aG[1020-i]=picker_aB[i+510]=picker_aB[1530-i]=i;
  picker_aR[i]=picker_aR[1530-i]=picker_aG[i+255]=picker_aG[i+510]=picker_aB[i+765]=picker_aB[i+1020]=255;
  if(i<255){
    picker_aR[i/2+1530]=127;
		picker_aG[i/2+1530]=127;
		picker_aB[i/2+1530]=127;
  }
}

var i=0;
var picker_jl=new Array();
for(x=0;x<16;x++){
  for(y=0;y<16;y++){
    picker_jl[i++]=picker_hexbase[x]+picker_hexbase[y];
  }
}



function picker_p(picker_pole,picker_value){
  var jla=document.getElementById(picker_pole);
  jla.innerHTML=picker_artabus;
  jla.style.backgroundColor=picker_artabus;
  document.getElementById(picker_value).value=picker_artabus;
}


function picker_t(e,picker_over){
  source=ie?e.srcElement:e.target;
  if(source.tagName=="TABLE"){
		return;
	}
  while(source.tagName!="TD" && source.tagName!="HTML"){
		source=ns6?source.parentNode:source.parentElement;
	}
  document.getElementById(picker_over).style.backgroundColor=picker_artabus=source.bgColor;
}

function picker_write(picker_pole,picker_value,picker_over){
  document.write('<'+'table border="0" cellspacing="0" cellpadding="0" onmouseover="picker_t(event,\''+picker_over+'\')" onclick="picker_p(\''+picker_pole+'\',\''+picker_value+'\')">');
  var picker_H=picker_W=63;

  for (picker_Y=0;picker_Y<=picker_H;picker_Y++){
  	s='<'+'tr height="2">';
    j=Math.round(picker_Y*(510/(picker_H+1))-255);
  	for (picker_X=0;picker_X<=picker_W;picker_X++){
	   	i=Math.round(picker_X*(picker_total/picker_W));
  	 	picker_R=picker_aR[i]-j;
			if(picker_R<0) {
				picker_R=0;
			}
			if(picker_R>255||isNaN(picker_R)){
				picker_R=255;
			}			
	 	  picker_G=picker_aG[i]-j;
			if(picker_G<0){ 
			  picker_G=0;
			}
			if(picker_G>255||isNaN(picker_G)){
				picker_G=255;
			}			
		  picker_B=picker_aB[i]-j;
			if(picker_B<0){
				picker_B=0;
			}
			if(picker_B>255||isNaN(picker_B)){
				picker_B=255;
			}			
		  s=s+'<'+'td width="2" bgcolor="#'+picker_jl[picker_R]+picker_jl[picker_G]+picker_jl[picker_B]+'" style="background-color:#'+picker_jl[picker_R]+picker_jl[picker_G]+picker_jl[picker_B]+'"><'+'/td>'
  	}
	  document.write(s+'<'+'/tr>')
  }
  document.write('<'+'/table>');
}

function picker_reset(pole,wartosc){
	document.getElementById(pole+'_t').innerHTML=''; 
	if(wartosc=="xxxxxx"){
		wartosc='';
	} else {
		wartosc='#'+wartosc;
	}
	document.getElementById(pole+'_t').style.backgroundColor=wartosc; 
	document.getElementById(pole).value=wartosc;
}