//zmiana obrazka (po najechaniu myszka)
function changeSrc(el,img){
	if(el!=null){
		el.src=img;
	}
}

//zmiana tla
function changeTlo(el,tlo){
	if(el!=null){
		el.className=tlo;
	}
}

//pytaniie czy usunac element
function czy_usun(linkp,komunikat){
	if(confirm(komunikat)){
		location.href=linkp;
	}
}

//zaznaczanie wszystkich checkbox 1- zaznacz, 2 - odznacz, 3- zmien 
function zaznacz_checkboxy(formularz,tablica,statusel) {
	var elts=(typeof(formularz.elements[tablica+'[]'])!= 'undefined') ? formularz.elements[tablica+'[]'] : '';
	var elts_cnt = (typeof(elts.length) != 'undefined') ? elts.length : 0;
	if (elts_cnt){
		for (var i = 0; i < elts_cnt; i++){ 
			if(statusel==1||(statusel==3&&!elts[i].checked)){
			 	elts[i].checked=true;
			} else {
			 	elts[i].checked=false;			
			}
		}
  } else { 
	
		if(statusel==1||(statusel==3&&!elts.checked)){
		 	elts.checked=true;
		} else {
		 	elts.checked=false;			
		}	
		
	}
}

//dodawanie tagow do pola text
function dodajtag(FormName,FieldName,tag,prompttext) {
	if (tag=='b'){ tag_prompt='bold'; }
	if (tag=='i'){ tag_prompt='italic'; }
	inserttext = prompt(prompttext+'\n<'+tag+'>xxx</'+tag+'>','');
	if ((inserttext != null) && (inserttext != '')) {
		document.forms[FormName].elements[FieldName].value += '<'+tag+'>'+inserttext+'</'+tag+'>';
	}
	document.forms[FormName].elements[FieldName].focus();
}

//dodawanie emotikonow do pola text
function emotikony_obrazek(pole,znaczek) {
  emotikony_pole=document.getElementById(pole);
  emotikony_pole.value=emotikony_pole.value+znaczek;
  emotikony_pole.focus();
}

//popup obrazka bez zbednych marginesow
function popup_image(okno,imageURL,imageTitle,w,h,margines){

	if(margines==''){
		$margines=0;
	}

	w=w+(2*margines);
	h=h+(2*margines);
	
	PositionY=(screen.height-h)/2; 
	if (PositionY<0){
		PositionY=0;
	}
	
	PositionX=(screen.width-w)/2; 
	if (PositionY<0){
		PositionY=0;
	}	
	
	
  var imgWin = window.open('',okno,'scrollbars=no,resizable=1,width='+w+',height='+h+',left='+PositionX+',top='+PositionY);
	//popup blockers should not cause errors
  if( !imgWin ) { 
		return true; 
	}

	imgWin.moveTo(PositionX,PositionY);
	imgWin.resizeTo(w,h);	
  imgWin.document.write('<html><head><title>'+imageTitle+'<\/title><\/head><body style="margin:0px; padding:0px; text-align:center"><div style="padding:'+margines+'px">'+'<img src="'+imageURL+'" alt=\"\" style=\"cursor:pointer\" onclick=\"window.close();\" />'+'<\/div><\/body><\/html>');
	
	imgWin.document.close();	
	
  if( imgWin.focus ) { 
		imgWin.focus(); 
	}

}

//zwykly popup centrowany
function popup_open(okno,adres,w,h,margines) {

	if(margines==''||!margines||margines=='undefined'||isNaN(margines)){
		margines=0;
	}

	w=w+margines;
	h=h+margines;

	top_okno=(screen.height-h)/2; 
	if (top_okno<0){
		top_okno=0;
	}
	left_okno=(screen.width-w)/2; 
	
	if (left_okno<0){
		left_okno=0;
	}

	imgWin=window.open(adres,okno,'top='+top_okno+',left='+left_okno+',width='+w+',height='+h+',toolbar=no,menubar=no,location=no,directories=no,alwaysRaised=no,status=no,scrollbars=no,resizable=yes,fullscreen=0');
	
	imgWin.moveTo(left_okno,top_okno);
	imgWin.resizeTo(w,h);	
			
	//popup blockers should not cause errors
  if( !imgWin ) { 
		return true; 
	}		
	
  if( imgWin.focus ) { 
		imgWin.focus(); 
	}

} 


//weryfikacja email
function spr_email(email){
	var forma_email=/^(?:(?:\w\-*)+\.?)*\w+@(?:(?:\w\-*)+\.)+\w{1,4}$/;
	return forma_email.test(email);
}

//funkcja trim
String.prototype.trim=function(){
	return this.replace(/^\s*|\s*$/g,"");
}

//czyszczenie defaultowej wartosci pola formularza
function field_clear(field,val,czysc){

	wartosc=document.getElementById(field);

	if(czysc){
		if(wartosc.value==val){
			wartosc.value='';
		}		
	} else {
		if(wartosc.value==''){
			wartosc.value=val;
		}				
	}
}

//zamykanie reklamy top layer
function adv_close() { 
	adv=document.getElementById('adv_layer');
  adv.style.display='none';
}

//dodawanie do ulubionych w przegladarkach
function dodaj_favorite(tytul,adres) {

 //FireFox
 if (window.sidebar) {
	
 	window.sidebar.addPanel(tytul, adres, "");

 //IE
 } else if (window.external) {
	
 	window.external.AddFavorite(adres, tytul);

 //Opera
 } else if (window.opera && window.print) {
	
 	var a = document.createElement('a'); a.setAttribute('href', adres); a.setAttribute('title', tytul); a.setAttribute('rel','sidebar'); a.click();
	
 }

}


function wlacz_wylacz(id){

	if(id){
	
		element=document.getElementById(id);
		
		if(element){
			if(element.style.display=='none'){
				element.style.display='';
			} else {
				element.style.display="none";
			}
		}
	}
	
}


//error variables
var form_ok=true;
var form_error_nr=0; 
var form_error_defalut="";
var form_errors_tab=new Array();
var form_fields_tab=new Array();

//show error label - html
function form_error_wyr(field,blad){

	wyr=document.getElementById(field+"_label");
	
	if(wyr!=null){

		if(blad){
			wyr.style.color="#ff0000";
		} else {
			wyr.style.color="";		
		}
			
	}
	
}

//start error variables
function form_start_errors(){

	form_ok=true;
	form_error_nr=0; 
	form_errors_tab=new Array();
	form_fields_tab=new Array();

}

//set form error
function form_set_error(field,comment){

	if(field){
	
		form_ok=false;
		form_error_nr++;
		form_fields_tab[form_error_nr]=field;
		if(comment){
			form_errors_tab[form_error_nr]=comment;		
		} else {
			form_errors_tab[form_error_nr]=form_error_defalut;			
		}

		form_error_wyr(field,true);
		
		if(form_error_nr==1){
			if(document.getElementById(field)!=null){
				document.getElementById(field).focus();
			}
		}

	}

}

//check the field
function form_error_spr(form_name,field,comment,wyr){

	if (form_name[field]!=null) {
		form_name[field].value.trim();			
		if (form_name[field].value==''||(wyr&&!form_name[field].value.test(wyr))) {	
			form_set_error(field,comment);
		} else {
			form_error_wyr(field,false);				
		}		
	}
						
}


//show the error message
function error_komunikat(main_text){	

	if(form_error_nr){
	
		text="";

		for(i=1;i<=form_error_nr;i++)	{
			if(form_errors_tab[i]){
				if(!text){
					text=text+form_errors_tab[i]+"\n\r";
				}
			}
			
		}
		
		if(text){
		
			text=main_text+"\n\r"+text;			
			err_validatek=document.getElementById('err_validate');				
			if(err_validatek!=null){			
				text=text.replace('\n\r','<br />');		
   			err_validatek.innerHTML = "<div style=\"color:#ff0000;\">"+text+"</div>";
				$('#err_box').show('slow');
			} else {
				alert(text);
			}
		}
						
	}
	
	return form_ok;
	
}

//check the delete action and show message
function spr_akcjau(pole,akcja,komunikat){

	ok=true;

	if(pole.value==akcja){ 				
		if(!confirm(komunikat)){ 
			ok=false; 
		}
	}
	
	return ok;
	
}