/* This notice must be untouched at all times.

wz_tooltip.js    v. 3.38

The latest version is available at
http://www.walterzorn.com
or http://www.devira.com
or http://www.walterzorn.de

Copyright (c) 2002-2005 Walter Zorn. All rights reserved.
Created 1. 12. 2002 by Walter Zorn (Web: http://www.walterzorn.com )
Last modified: 9. 12. 2005

LICENSE: LGPL

This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License (LGPL) as published by the Free Software Foundation; either
version 2.1 of the License, or (at your option) any later version.

This library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.

For more details on the GNU Lesser General Public License,
see http://www.gnu.org/copyleft/lesser.html
*/

////////////////  GLOBAL TOOPTIP CONFIGURATION  /////////////////////
var ttAbove       = false;        // tooltip above mousepointer? Alternative: true
var ttClass				="tooltip";
var ttDelay       = 100;          // time span until tooltip shows up [milliseconds]
var ttLeft        = false;       // tooltip on the left of the mouse? Alternative: true
var ttOffsetX     = 7;           // horizontal offset of left-top corner from mousepointer
var ttOffsetY     = 7;           // vertical offset                   "
var ttOpacity     = 100;          // opacity of tooltip in percent (must be integer between 0 and 100)
var ttStatic      = true;        // tooltip NOT move with the mouse? Alternative: true
var ttSticky      = true;        // do NOT hide tooltip on mouseout? Alternative: true
var ttTemp        = 15000;        // time span after which the tooltip disappears; 0 (zero) means "infinite timespan"

//////////////  TAGS WITH TOOLTIP FUNCTIONALITY  ////////////////////
// List may be extended or shortened:
var tt_tags = new Array("a","area","b","big","caption","center","code","dd","div","dl","dt","em","h1","h2","h3","h4","h5","h6","i","img","input","li","map","ol","p","pre","s", "select", "small","span","strike","strong","sub","sup","table","td","th","tr","tt","u","var","ul","layer");
/////////////////////////////////////////////////////////////////////

var tt_obj = null,         // current tooltip
tt_ifrm = null,            // iframe to cover windowed controls in IE
tt_objW = 0, tt_objH = 0,  // width and height of tt_obj
tt_objX = 0, tt_objY = 0,
tt_offX = 0, tt_offY = 0,
xlim = 0, ylim = 0,        // right and bottom borders of visible client area
tt_sup = false,            // true if T_ABOVE cmd
tt_sticky = false,         // tt_obj sticky?
tt_wait = false,
tt_act = false,            // tooltip visibility flag
tt_sub = false,            // true while tooltip below mousepointer
tt_u = "undefined",
tt_mf = null,              // stores previous mousemove evthandler
tt_tag = null;             // stores hovered dom node, href and previous statusbar txt

var tt_db = (document.compatMode && document.compatMode != "BackCompat")? document.documentElement : document.body? document.body : null,
tt_n = navigator.userAgent.toLowerCase(),
tt_nv = navigator.appVersion;
// Browser flags
var tt_op = !!(window.opera && document.getElementById),
tt_op6 = tt_op && !document.defaultView,
tt_op7 = tt_op && !tt_op6,
tt_ie = tt_n.indexOf("msie") != -1 && document.all && tt_db && !tt_op,
tt_ie6 = tt_ie && parseFloat(tt_nv.substring(tt_nv.indexOf("MSIE")+5)) >= 5.5,
tt_n4 = (document.layers && typeof document.classes != tt_u),
tt_n6 = (!tt_op && document.defaultView && typeof document.defaultView.getComputedStyle != tt_u),
tt_w3c = !tt_ie && !tt_n6 && !tt_op && document.getElementById;

function tt_Int(t_x){
	var t_y;
	return isNaN(t_y = parseInt(t_x))? 0 : t_y;
}

function wzReplace(t_x, t_y){
	var t_ret = "",
	t_str = this,
	t_xI;
	while((t_xI = t_str.indexOf(t_x)) != -1)
	{
		t_ret += t_str.substring(0, t_xI) + t_y;
		t_str = t_str.substring(t_xI + t_x.length);
	}
	return t_ret+t_str;
}

String.prototype.wzReplace = wzReplace;

function tt_N4Tags(tagtyp, t_d, t_y){
	t_d = t_d || document;
	t_y = t_y || new Array();
	var t_x = (tagtyp=="a")? t_d.links : t_d.layers;
	for(var z = t_x.length; z--;) t_y[t_y.length] = t_x[z];
	for(z = t_d.layers.length; z--;) t_y = tt_N4Tags(tagtyp, t_d.layers[z].document, t_y);
	return t_y;
}

function tt_Htm(tt, t_id, txt){
	var t_class   = (typeof tt.T_CLASS != tt_u)? tt.T_CLASS : ttClass,	
	t_opa     = (typeof tt.T_OPACITY != tt_u)? tt.T_OPACITY : ttOpacity,
	t_tit     = (typeof tt.T_TITLE != tt_u)? tt.T_TITLE : "";

	var t_optx = (tt_n4? '' : tt_n6? ('-moz-opacity:'+(t_opa/100.0)) : tt_ie? ('filter:Alpha(opacity='+t_opa+')') : ('opacity:'+(t_opa/100.0))) + ';';
	
	var t_y = '<div id="'+t_id+'" style="position:absolute;z-index:1010;left:0px;top:0px;visibility:'+(tt_n4? 'hide' : 'hidden')+';'+t_optx+'">';
	t_y += '<table class="'+t_class+'" border="0" cellpadding="0" cellspacing="0">';		
	if(t_tit){
		t_y += '<tr><td class="tooltip_title">'+t_tit+'</td></tr>';
	}
	t_y += '<tr><td class="tooltip_content">'+txt+'</td></tr></table>';
	
	return(t_y+'</div>' +
		(tt_ie6 ? '<iframe id="TTiEiFrM" src="javascript:false" scrolling="no" frameborder="0" style="filter:Alpha(opacity=0);position:absolute;top:0px;left:0px;display:none;"></iframe>' : ''));
}

function tt_EvX(t_e){
	var t_y = tt_Int(t_e.pageX || t_e.clientX || 0) +
		tt_Int(tt_ie? tt_db.scrollLeft : 0) +
		tt_offX;
	if(t_y > xlim) t_y = xlim;
	var t_scr = tt_Int(window.pageXOffset || (tt_db? tt_db.scrollLeft : 0) || 0);
	if(t_y < t_scr) t_y = t_scr;
	return t_y;
}

function tt_EvY(t_e){
	var t_y = tt_Int(t_e.pageY || t_e.clientY || 0) +
		tt_Int(tt_ie? tt_db.scrollTop : 0);
	if(tt_sup) t_y -= (tt_objH + tt_offY - 15);
	else if(t_y > ylim || !tt_sub && t_y > ylim-24)
	{
		t_y -= (tt_objH + 5);
		tt_sub = false;
	}
	else
	{
		t_y += tt_offY;
		tt_sub = true;
	}
	return t_y;
}

function tt_ReleasMov(){
	if(document.onmousemove == tt_Move)
	{
		if(!tt_mf && document.releaseEvents) document.releaseEvents(Event.MOUSEMOVE);
		document.onmousemove = tt_mf;
	}
}

function tt_ShowIfrm(t_x){
	if(!tt_obj || !tt_ifrm) return;
	if(t_x)
	{
		tt_ifrm.style.width = tt_objW+'px';
		tt_ifrm.style.height = tt_objH+'px';
		tt_ifrm.style.display = "block";
	}
	else tt_ifrm.style.display = "none";
}

function tt_GetDiv(t_id){
	return(
		tt_n4? (document.layers[t_id] || null)
		: tt_ie? (document.all[t_id] || null)
		: (document.getElementById(t_id) || null)
	);
}

function tt_GetDivW(){
	return tt_Int(
		tt_n4? tt_obj.clip.width
		: (tt_obj.style.pixelWidth || tt_obj.offsetWidth)
	);
}

function tt_GetDivH(){
	return tt_Int(
		tt_n4? tt_obj.clip.height
		: (tt_obj.style.pixelHeight || tt_obj.offsetHeight)
	);
}

// Compat with DragDrop Lib: Ensure that z-index of tooltip is lifted beyond toplevel dragdrop element
function tt_SetDivZ(){
	var t_i = tt_obj.style || tt_obj;
	if(t_i)
	{
		if(window.dd && dd.z)
			t_i.zIndex = Math.max(dd.z+1, t_i.zIndex);
		if(tt_ifrm) tt_ifrm.style.zIndex = t_i.zIndex-1;
	}
}

function tt_SetDivPos(t_x, t_y){
	var t_i = tt_obj.style || tt_obj;
	var t_px = (tt_op6 || tt_n4)? '' : 'px';
	t_i.left = (tt_objX = t_x) + t_px;
	t_i.top = (tt_objY = t_y) + t_px;
	if(tt_ifrm)
	{
		tt_ifrm.style.left = t_i.left;
		tt_ifrm.style.top = t_i.top;
	}
}

function tt_ShowDiv(t_x){
	tt_ShowIfrm(t_x);
	if(tt_n4) tt_obj.visibility = t_x? 'show' : 'hide';
	else tt_obj.style.visibility = t_x? 'visible' : 'hidden';
	tt_act = t_x;
}

function tt_OpDeHref(t_e){
	var t_tag;
	if(t_e)
	{
		t_tag = t_e.target;
		while(t_tag)
		{
			if(t_tag.hasAttribute("href"))
			{
				tt_tag = t_tag
				tt_tag.t_href = tt_tag.getAttribute("href");
				tt_tag.removeAttribute("href");
				tt_tag.style.cursor = "hand";
				tt_tag.onmousedown = tt_OpReHref;
				tt_tag.stats = window.status;
				window.status = tt_tag.t_href;
				break;
			}
			t_tag = t_tag.parentElement;
		}
	}
}

function tt_OpReHref(){
	if(tt_tag)
	{
		tt_tag.setAttribute("href", tt_tag.t_href);
		window.status = tt_tag.stats;
		tt_tag = null;
	}
}

function tt_Show(t_e, t_id, t_sup, t_delay, t_fix, t_left, t_offx, t_offy, t_static, t_sticky, t_temp){
	if(tt_obj) tt_Hide();
	tt_mf = document.onmousemove || null;
	if(window.dd && (window.DRAG && tt_mf == DRAG || window.RESIZE && tt_mf == RESIZE)) return;

	tt_obj = tt_GetDiv(t_id);
	if(tt_obj)
	{
		t_e = t_e || window.event;
		tt_sub = !(tt_sup = t_sup);
		tt_sticky = t_sticky;
		tt_objW = tt_GetDivW();
		tt_objH = tt_GetDivH();
		tt_offX = t_left? -(tt_objW+t_offx) : t_offx;
		tt_offY = t_offy;
		if(tt_op7) tt_OpDeHref(t_e);

		xlim = tt_Int((tt_db && tt_db.clientWidth)? tt_db.clientWidth : window.innerWidth) +
			tt_Int(window.pageXOffset || (tt_db? tt_db.scrollLeft : 0) || 0) -
			tt_objW -
			(tt_n4? 21 : 0);
		ylim = tt_Int(window.innerHeight || tt_db.clientHeight) +
			tt_Int(window.pageYOffset || (tt_db? tt_db.scrollTop : 0) || 0) -
			tt_objH - tt_offY;

		tt_SetDivZ();
		if(t_fix) tt_SetDivPos(tt_Int((t_fix = t_fix.split(','))[0]), tt_Int(t_fix[1]));
		else tt_SetDivPos(tt_EvX(t_e), tt_EvY(t_e));

		var t_txt = 'tt_ShowDiv(\'true\');';
		if(t_sticky) t_txt += '{'+
				'tt_ReleasMov();'+
				'window.tt_upFunc = document.onmouseup || null;'+
				'if(document.captureEvents) document.captureEvents(Event.MOUSEUP);'+
				'document.onmouseup = new Function("window.setTimeout(\'tt_Hide();\', 10);");'+
			'}';
		else if(t_static) t_txt += 'tt_ReleasMov();';
		if(t_temp > 0) t_txt += 'window.tt_rtm = window.setTimeout(\'tt_sticky = false; tt_Hide();\','+t_temp+');';
		window.tt_rdl = window.setTimeout(t_txt, t_delay);

		if(!t_fix)
		{
			if(document.captureEvents) document.captureEvents(Event.MOUSEMOVE);
			document.onmousemove = tt_Move;
		}
	}
}

var tt_area = false;

function tt_Move(t_ev){
	if(!tt_obj) return;
	if(tt_n6 || tt_w3c)
	{
		if(tt_wait) return;
		tt_wait = true;
		setTimeout('tt_wait = false;', 5);
	}
	var t_e = t_ev || window.event;
	tt_SetDivPos(tt_EvX(t_e), tt_EvY(t_e));
	if(tt_op6)
	{
		if(tt_area && t_e.target.tagName != 'AREA') tt_Hide();
		else if(t_e.target.tagName == 'AREA') tt_area = true;
	}
}

function tt_Hide(){
	if(window.tt_obj)
	{
		if(window.tt_rdl) window.clearTimeout(tt_rdl);
		if(!tt_sticky || !tt_act)
		{
			if(window.tt_rtm) window.clearTimeout(tt_rtm);
			tt_ShowDiv(false);
			tt_SetDivPos(-tt_objW, -tt_objH);
			tt_obj = null;
			if(typeof window.tt_upFunc != tt_u) document.onmouseup = window.tt_upFunc;
		}
		tt_sticky = false;
		if(tt_op6 && tt_area) tt_area = false;
		tt_ReleasMov();
		if(tt_op7) tt_OpReHref();
	}
}

function tt_Init(){
	if(!(tt_op || tt_n4 || tt_n6 || tt_ie || tt_w3c)) return;

	var htm = tt_n4? '<div style="position:absolute;"></div>' : '',
	tags,
	t_tj,
	over,
	esc = 'return escape(';
	var i = tt_tags.length; while(i--)
	{
		tags = tt_ie? (document.all.tags(tt_tags[i]) || 1)
			: document.getElementsByTagName? (document.getElementsByTagName(tt_tags[i]) || 1)
			: (!tt_n4 && tt_tags[i]=="a")? document.links
			: 1;
		if(tt_n4 && (tt_tags[i] == "a" || tt_tags[i] == "layer")) tags = tt_N4Tags(tt_tags[i]);
		var j = tags.length; while(j--)
		{
			if(typeof (t_tj = tags[j]).onmouseover == "function" && t_tj.onmouseover.toString().indexOf(esc) != -1 && !tt_n6 || tt_n6 && (over = t_tj.getAttribute("onmouseover")) && over.indexOf(esc) != -1)
			{
				if(over) t_tj.onmouseover = new Function(over);
				var txt = unescape(t_tj.onmouseover());
				htm += tt_Htm(
					t_tj,
					"tOoLtIp"+i+""+j,
					txt.wzReplace("& ","&")
				);

				t_tj.onmouseover = new Function('e',
					'tt_Show(e,'+
					'"tOoLtIp' +i+''+j+ '",'+
					((typeof t_tj.T_ABOVE != tt_u)? t_tj.T_ABOVE : ttAbove)+','+
					((typeof t_tj.T_DELAY != tt_u)? t_tj.T_DELAY : ttDelay)+','+
					((typeof t_tj.T_FIX != tt_u)? '"'+t_tj.T_FIX+'"' : '""')+','+
					((typeof t_tj.T_LEFT != tt_u)? t_tj.T_LEFT : ttLeft)+','+
					((typeof t_tj.T_OFFSETX != tt_u)? t_tj.T_OFFSETX : ttOffsetX)+','+
					((typeof t_tj.T_OFFSETY != tt_u)? t_tj.T_OFFSETY : ttOffsetY)+','+
					((typeof t_tj.T_STATIC != tt_u)? t_tj.T_STATIC : ttStatic)+','+
					((typeof t_tj.T_STICKY != tt_u)? t_tj.T_STICKY : ttSticky)+','+
					((typeof t_tj.T_TEMP != tt_u)? t_tj.T_TEMP : ttTemp)+
					');'
				);
				t_tj.onmouseout = tt_Hide;
				if(t_tj.alt) t_tj.alt = "";
				if(t_tj.title) t_tj.title = "";
			}
		}
	}
	document.write(htm);
	if(document.getElementById) tt_ifrm = document.getElementById("TTiEiFrM");
}
