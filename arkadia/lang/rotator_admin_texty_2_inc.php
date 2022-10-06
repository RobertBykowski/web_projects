<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}


$texty_tab['rot_stat']="Statistics";
$texty_tab['rot_stat_ogolne']="General information:";	
$texty_tab['rot_stat_nazwa']="Name:";
$texty_tab['rot_stat_ilosc']="Number:";		
$texty_tab['rot_stat_ilew']="Number of all elements";		
$texty_tab['rot_stat_sumaw']="Number of displays";		
$texty_tab['rot_stat_sumak']="Number of clicks";		
$texty_tab['rot_stat_typy']="Types of files:";	
$texty_tab['rot_stat_link']="Outside links";		
$texty_tab['rot_stat_nw']="Most frequently displayed:";
$texty_tab['rot_stat_nk']="Most frequently clicked-on:";	
$texty_tab['rot_stat_kw']="Clicks for displays:";	
$texty_tab['rot_typy']="Types of banners:";
$texty_tab['rot_typy_nazwa']="Category name:";
$texty_tab['rot_typy_ilosc']="Number";
$texty_tab['rot_typy_typyp']="types of files:";
$texty_tab['rot_typy_sod']="width from:";
$texty_tab['rot_typy_px']="px";
$texty_tab['rot_typy_do']="to:";
$texty_tab['rot_typy_wod']="height from:";
$texty_tab['rot_typy_do']="to:";
$texty_tab['rot_typy_max']="max.:";
$texty_tab['rot_typy_kb']="kb)";			
$texty_tab['rot_typy_wszystkie']="all banners";		
$texty_tab['rot_arch_lista']="List of banners, ads (";
$texty_tab['rot_arch_typ']="Type of banners:";
$texty_tab['rot_arch_id']="id";
$texty_tab['rot_arch_baner']="Banner";
$texty_tab['rot_arch_aktywnosc']="Dates";
$texty_tab['rot_arch_status']="Status";
$texty_tab['rot_arch_jezyk']="Language";
$texty_tab['rot_arch_prio']="Prior.";
$texty_tab['rot_arch_udzial']="Share";
$texty_tab['rot_arch_wys']="Displ.";
$texty_tab['rot_arch_klik']="Clicks:";
$texty_tab['rot_arch_od']="from:";
$texty_tab['rot_arch_do']="to:";
$texty_tab['rot_arch_astat']="statistics";	
$texty_tab['rot_arch_listakat']="list of categories of rotators/information";		
$texty_tab['rot_arch_szuk_status1']="active only";
$texty_tab['rot_arch_szuk_status2']="inactive only";
$texty_tab['rot_arch_szuk_status0']="--banner status--";
$texty_tab['rot_arch_szuk_dostepne']="available only";
$texty_tab['rot_arch_szuk_niedostepne']="unavailable only";
$texty_tab['rot_arch_szuk_dostepnosc']="--display availability--";
$texty_tab['rot_arch_lang']="--language version--";
$texty_tab['rot_form_edycja']="Edit banner:";
$texty_tab['rot_form_uzupelnij']="Fill in data";
$texty_tab['rot_form_dodawanie']="Add banner:";		
$texty_tab['rot_form_dataod']="Day of the start of the display";
$texty_tab['rot_form_datado']="Date due, show till day";
$texty_tab['rot_form_typ']="type of banner/ad*:";
$texty_tab['rot_form_typwyb']="--choose--";
$texty_tab['rot_form_tytul']="title/name*:";
$texty_tab['rot_form_linkg']="link on the banner:";
$texty_tab['rot_form_okno']="window, in which the link opens";		
$texty_tab['rot_form_noweokno']="- new window";
$texty_tab['rot_form_tosamookno']="- the same window";
$texty_tab['rot_form_dotychczasowa']="existing graphic file:";			
$texty_tab['rot_form_grafika']="graphic file:*";
$texty_tab['rot_form_wymiary']="size:";
$texty_tab['rot_form_mozliwosc']="(manual modification only possible for SWF)";		
$texty_tab['rot_form_wys']="height (px)";
$texty_tab['rot_form_szer']="width (px)";
$texty_tab['rot_form_tlo']="background";
$texty_tab['rot_form_tylko swf']="(only for SWF)";			
$texty_tab['rot_form_przezroczysty']="transparent"; 				
$texty_tab['rot_form_link']="code for the link/graphic file:";
$texty_tab['rot_form_opis']="description, information:";
$texty_tab['rot_form_czywys']="she displays be counted";
$texty_tab['rot_form_wysw']="number of displays";
$texty_tab['rot_form_wyslimit']="displays limit (0 = no limit)";
$texty_tab['rot_form_czyklik']="Should clicks be counted";
$texty_tab['rot_form_klik']="number of clicks";
$texty_tab['rot_form_kliklimit']="clicks limit (0 = no limit)";
$texty_tab['rot_form_brak']="--missing--";
$texty_tab['rot_form_najwyzszy']=" - the lowest";
$texty_tab['rot_form_najnizszy']=" - the highest";
$texty_tab['rot_form_priorytet']="priority";
$texty_tab['rot_form_udzial']="share";
$texty_tab['rot_form_dowolna']="--any--";
$texty_tab['rot_form_lang']="language version";		
$texty_tab['rot_form_lista']="list of banners/ads";
$texty_tab['rot_form_reset']="Reset"; 

$texty_tab['rot_form_htyp']="Available types of banners depend on the www configuration created individually for every project";		
$texty_tab['rot_form_hadres']="WWW address which the given banner leads to - redirection to the link when clicked on the banner. Does not refer to SWF banners.";
$texty_tab['rot_form_hgrafika']="Graphic file meeting the type and size requirements defined for the given type of banners";
$texty_tab['rot_form_hwymiary']="System automatically reads the size of banners, it does not calibrate them with the exception of SWF. In case of SWF, the size read can be changed within limits set for the given type of banners.";
$texty_tab['rot_form_htlo']="Choosing transparency causes the background colours to be ignored";
$texty_tab['rot_form_hlink']="Link displaying the outside banner. When given, the banner, the link on the banner and other parameters of the banner are ignored. This type of banners does not allow to count clicks";
$texty_tab['rot_form_hopis']="Only for administrative purposes, e.g. noting down information about the source of the banner or the advertisment contract";
$texty_tab['rot_form_hwys']="Setting the display limit causes the banner to be displayed only as long as the display limit is greater than or equal to the number of displays";		
$texty_tab['rot_form_hklik']="Setting the clicks limit causes the banner to be displayed only as long as the clicks limit is greater than or equal to the number of clicks. Adding up clicks does not include banners opened by a link and SWF banners, for which the function of clicks couting is not available";
$texty_tab['rot_form_hpriorytet']="Option used when displaying more than one banner at the same time. Banners are drawn according to their priority. Banners with the same priority are chosen in random order";
$texty_tab['rot_form_hlangt']="Defines whether banner is to be displayed only for one language version or for all available versions";
$texty_tab['rot_form_hudzial']="Option used when displaying more than one banner at the same time. anners are drawn according to their priority. Banners with the same priority are chosen in random order";

$texty_tab['rot_zmiena_log']="rotator - parameter modification:";
$texty_tab['rot_usuna_log']="rotator - removal";	
$texty_tab['rot_img_brak']="Incorrect type of file - rejected.";				

?>