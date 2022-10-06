<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

if(user::get()->zalogowany()){
	konf::get()->setTekstyTab("art_texty",2);
} else {
	konf::get()->setTekstyTab("art_texty");
}

//konfiguracja skryptu artykułów

//komentarze do artykułów
$konfig_art['kom']=true;

//kolejne akapity
$konfig_art['akapity']=true;

//blokada akapitu na czas edycji? (podane w minutach)
$konfig_art['blokada']=15;

//czy jest dodawanie jpg do akapitu poprzez formularz
$konfig_art['imga']=true;

//katalog na grafike akapitów
$konfig_art['akapity_kat']="pics/art_akapity/";

//domyslny rozmiar skalowania img dla akapitu
$konfig_art['imga_size']=600;

//domyslny rozmiar skalowania img miniaturki dla akapitu
$konfig_art['imga_m_size']=200;

//minimalny wymiar grafiki
$konfig_art['imga_min_size']=1;

//typ skalowania dla miniaturki akapitu
$konfig_art['imga_skala']=3;

//czy jest dodawanie do zajawski jpg poprzez formularz
$konfig_art['img']=true;

//katalog na grafike zajawek
$konfig_art['art_kat']="pics/art/";

//domyslny rozmiar skalowania img
$konfig_art['img_size']=200;

//miniaturka skalowana na wymiar
$konfig_art['img_m_size']=120;

//typ skalowania dla miniaturki artykulu
$konfig_art['img_skala']=3;

//minimalny wymiar grafiki
$konfig_art['img_min_size']=1;

//domylsne wyrownanie grafiki
$konfig_art['img_align_def']=2;

//domyslne wyrownywanie txt i grafiki
// 1-do lewej, 2-do prawej, 3-centrowanie, 4-justowanie
$konfig_art['txt_align_def']=4;
$konfig_art['img_align_def']=2;

//dostepne wyrównywanie tekstu i grafiki przy dodawaniu i edycji
$konfig_art['img_align']=array(1=>2,2=>1,3=>3);

//czy notować licznik odsłon
$konfig_art['licznik']=true;

//czy kanaly rss
$konfig_art['rss']=true;

//czy funkcje admina w podgladzie produkcyjnym
$konfig_art['adminpodglad']=true;

//co wyswietlac

$konfig_art['wys_data_zal']=true;				//data założenia
$konfig_art['wys_licznik']=true;				//licznik odsłon
$konfig_art['wys_autor']=true;					//autor wpisu
$konfig_art['wys_autor_tresc']=false;		//autor treści
$konfig_art['wys_data_mod']=true;				//data ostatniej modyfikacji
$konfig_art['wys_druk']=true;						//przycisk drukowania i zapisu do pliku
$konfig_art['wys_wyslij']=true;					//przycisk wyslij znajomemu/polec artykul
$konfig_art['wys_dziennik_zmian']=false;	//link do dziennika zmian artykułu

$konfig_art['wytworzyl']=false;
$konfig_art['dziennik_zmian']=false;

//wyswietlaj link powrotu do strony nadrzednej
$konfig_art['powrot']=true;

//szczegoly o autorach
$konfig_art['arch_szczegoly']=true;

//data informnacji
$konfig_art['data_wys']=false;

//data informnacji - dlugosc
$konfig_art['data_wys_dl']=10;

//podtytul
$konfig_art['podtytul']=true;

//ilu odbiorcow przy polec znajomemu
$konfig_art['wyslij_odb']=3;


//czy jest mozliwosc nie usuwania wszystkich tagów html
//daje mozliwosc ominiecia zabezpieczenia powyzej, zmienia sposob wyswietlania (bez lam_stringa)
$konfig_art['select_zostaw_tagi']=true;

//w treści automatycznie zamienia pelny adresy www i email na linki
$konfig_art['autolink']=true;

//pobieraj identyfikatory
$konfig_art['idtf']=true;

//czy dodawac do linku  tytul strony
$konfig_art['link_tytul']=true;

//w administracji ile podstron na stronie
$konfig_art['art_na_str']=25;

//czy dac wybor stronicowania w konfiguracji artykulu
$konfig_art['stronicowanie']=50;

//zajawka artykulu
$konfig_art['zajawka']=true;

//css tresc
$konfig_art['tresc_class']="tlo3";

//css tytul
$konfig_art['tytul_class']="tlo4";


//link więcej pod zajawke
$konfig_art['podstron_wiecej']=konf::get()->langTexty("art_wiecej")."&nbsp;&raquo;";

//dodawanie zajawek do artykulow
$konfig_art['zajawka_edytor']=true;

//dlugosc paska
$konfig_art['stat_dl']=400;

//ile statow na stronie (jesli 0 to bez podzialu na podstrony)
$konfig_art['stat_na_str']=0;

//ile max pierwszych wynikow, jesli nie ma podzialu na podstrony
$konfig_art['stat_max']=10;

//czy wyswietlac strony z licznikiem=0
$konfig_art['stat_zero']=false;

//czy wietlac liste podstron 0-nie, 1-na gorze, 2-na dole
$konfig_art['submenu_polozenie']=1;

//czy wyswietlac liste podstron  1-zwykla lista, 2-lista w postaci tabeli, 3- lista wpostaci miniaturek obrazkow
$konfig_art['submenu_wyglad']=1;

//zdefiniowany wyglad submenu
$konfig_art['submenu_typy']=array(
	1=>"lista wypunktowana",
	2=>"tabela przycisków",
	3=>"tabela obrazków",
	4=>"tytuł + zajawka + obrazek",
);

//ile poziomow w drzewie administracyjnym 0 - bez ograniczen
$konfig_art['drzewo_poziomy']=4;

//wyszukiwarka - wynikow na podstronie
$konfig_art['szuk_na_str']=25;

//wyszukiwarka - znakow wycietych z tekstu
$konfig_art['szuk_max']=200;

//wyswietla sciezke
$konfig_art['sciezka']=true;

//wyswietla sciezke
$konfig_art['wys_wiecej']="&nbsp;".konf::get()->langTexty("art_wiecej")."&nbsp;&raquo;";

//tytul www zalezny od tytulu artykulu
$konfig_art['tytuly_indywidualne']=true;

//limit poziomu(>=)  0 - bez limitu
$konfig_art['mapa_poziom_limit']=0;

//wykluczone typy elementow z mapy strony
$konfig_art['mapa_d_wyklucz']=array(10);

//wykluczone typy elementow z mapy strony
$konfig_art['mapa_typy_wyklucz']=array(3);

//czy pobierać link do źródła wiadomości
$konfig_art['pobierz_zrodlo']=true;

//kolejnosc na liscie newsow
$konfig_art['news_order']=" data_wys DESC, id DESC ";

//galerie zdjeciowe
$konfig_art['galeria']=true;

//katalog na galerie
$konfig_art['galeria_kat']="pics/art_galerie/";

//galerie zdjeciowe
$konfig_art['galeria_typy']=array(
	1=>konf::get()->langTexty("gal_typ1"),  //miniaturka + popup
	2=>konf::get()->langTexty("gal_typ2"),	//miniaturka + projektor popup
	3=>konf::get()->langTexty("gal_typ3"),	//miniaturka + projektor w treści
//	4=>konf::get()->langTexty("gal_typ4"),	//miniaturka + powiększenie dynamiczne
	5=>konf::get()->langTexty("gal_typ5")		//miniaturka + powiększenie Lightbox
);

//galerie zdjeciowe - typ skaowania
$konfig_art['galeria_skala']=array(
	1=>konf::get()->langTexty("gal_skala1"),  //miniaturki o tej samej wysokośći
	2=>konf::get()->langTexty("gal_skala2"),	//miniaturki o tej samej szerokości
	3=>konf::get()->langTexty("gal_skala3"),	//miniaturki skalowane proporcjonalnie na wysokość i szerokość
	6=>konf::get()->langTexty("gal_skala6"),	//miniaturki skalowane i przycinane do jednego rozmiaru
);

//domyslny typ
$konfig_art['galeria_typ_domyslny']=5;

//typ skakowania miniaturki
$konfig_art['galeria_skalowanie']=3;

//skalowanie
$konfig_art['galeria_img_size']=550;

//skalowanie
$konfig_art['galeria_min_size']=1;

//skalowanie miniaturki
$konfig_art['galeria_m_size']=80;

//oceny zdjec
$konfig_art['galeria_punkty']=false;

//licznik wyswietlen zdjec
$konfig_art['galeria_licznik']=false;

//opis zdjecia w adminie
$konfig_art['galeria_opis']=true;

//tytul zdjecia na liscie
$konfig_art['galeria_wys_tytul']=true;

//projektor - szerokosc
$konfig_art['galeria_projektor_w']=750;

//projektor - wysokosc
$konfig_art['galeria_projektor_h']=750;

//zdjec na podstronie, w administracji
$konfig_art['galeria_na_str']=25;

//komentarze
$konfig_art['galeria_koment']=false;

//rozmiar do obrobki
$konfig_art['galeria_o_size']=1200;

//czy mozliwosc obrobki
$konfig_art['galeria_obrobka']=true;

//ile wierszy na podstronie (0 bez limitu)
$konfig_art['galeria_wiersz']=0;

//ile kolumn/zdjec w wierszu na podstronie (zwykle 1-10 zaleznie od szerokosci www)
$konfig_art['galeria_kolumna']=4;

//typy zawartosci
$konfig_art['typ_tab'][0]=konf::get()->langTexty("art_typ0"); //Strona z edytorem HTML
$konfig_art['typ_tab'][2]=konf::get()->langTexty("art_typ2"); //Newsy, informacje
$konfig_art['typ_tab'][3]=konf::get()->langTexty("art_typ3"); //Newsy, informacje


//dostep do zawartosci
$konfig_art['dostep_tab'][0]=konf::get()->langTexty("art_dostep0"); //Ogolny
$konfig_art['dostep_tab'][1]=konf::get()->langTexty("art_dostep1"); //Dla zalogowanych
$konfig_art['dostep_tab'][2]=konf::get()->langTexty("art_dostep2"); //Uprawnienie
$konfig_art['dostep_tab'][3]=konf::get()->langTexty("art_dostep3"); //Specjalny


//akcje do dziennika
$konfig_art['dziennik_tab'][1]=konf::get()->langTexty("art_dziennik1"); //Dodanie artykułu
$konfig_art['dziennik_tab'][2]=konf::get()->langTexty("art_dziennik2"); //Edycja artykułu
$konfig_art['dziennik_tab'][3]=konf::get()->langTexty("art_dziennik3"); //Usunięcie artykułu
$konfig_art['dziennik_tab'][4]=konf::get()->langTexty("art_dziennik4"); //Dodanie akapitu artykułu
$konfig_art['dziennik_tab'][5]=konf::get()->langTexty("art_dziennik5"); //Edycja akapitu artykułu
$konfig_art['dziennik_tab'][6]=konf::get()->langTexty("art_dziennik6"); //Usunięcie akapitu artykułu



switch(konf::get()->getKonfigTab('strona_typ')){

	case 'cms':
		$konfig_art['rss']=false;
		$konfig_art['kom']=false;
		$konfig_art['licznik']=false;
		$konfig_art['wys_data_zal']=false;
		$konfig_art['wys_licznik']=false;
		$konfig_art['wys_autor']=false;
		$konfig_art['wys_autor_tresc']=false;
		$konfig_art['wys_data_mod']=false;
		$konfig_art['wys_druk']=false;
		$konfig_art['wys_wyslij']=false;
		$konfig_art['wys_dziennik_zmian']=false;
		$konfig_art['wytworzyl']=false;
		$konfig_art['dziennik_zmian']=false;
		$konfig_art['arch_szczegoly']=false;
		$konfig_art['podtytul']=false;
		$konfig_art['pobierz_zrodlo']=false;
		$konfig_art['imga']=true;

		$konfig_art['d_tab'][1]=konf::get()->langTexty("art_d1"); //Gorne menu
		//$konfig_art['d_tab'][2]=konf::get()->langTexty("art_d2"); //Lewe menu
		//$konfig_art['d_tab'][4]=konf::get()->langTexty("art_d4"); //dolne menu

	break;

	case 'sklep':
		$konfig_art['rss']=false;
		$konfig_art['kom']=false;
		$konfig_art['licznik']=false;
		$konfig_art['wys_data_zal']=false;
		$konfig_art['wys_licznik']=false;
		$konfig_art['wys_autor']=false;
		$konfig_art['wys_autor_tresc']=false;
		$konfig_art['wys_data_mod']=false;
		$konfig_art['wys_druk']=true;
		$konfig_art['wys_wyslij']=false;
		$konfig_art['wys_dziennik_zmian']=false;
		$konfig_art['wytworzyl']=false;
		$konfig_art['dziennik_zmian']=false;
		$konfig_art['arch_szczegoly']=false;
		$konfig_art['imga']=true;

		$konfig_art['d_tab'][5]="Górne menu - sklep".konf::get()->langTexty("art_d5"); //Gorne menu
		$konfig_art['d_tab'][4]=konf::get()->langTexty("art_d4"); //Stopka

	break;

	case 'portal':
		$konfig_art['rss']=false;
		$konfig_art['kom']=false;
		$konfig_art['licznik']=false;
		$konfig_art['wys_data_zal']=false;
		$konfig_art['wys_licznik']=false;
		$konfig_art['wys_autor']=false;
		$konfig_art['wys_autor_tresc']=false;
		$konfig_art['wys_data_mod']=false;
		$konfig_art['wys_druk']=true;
		$konfig_art['wys_wyslij']=false;
		$konfig_art['wys_dziennik_zmian']=false;
		$konfig_art['wytworzyl']=false;
		$konfig_art['dziennik_zmian']=false;
		$konfig_art['arch_szczegoly']=false;
		$konfig_art['imga']=true;

		$konfig_art['d_tab'][1]=konf::get()->langTexty("art_d1"); //Gorne menu
		$konfig_art['d_tab'][4]=konf::get()->langTexty("art_d4"); //dolne menu

	break;

}

//$konfig_art['d_tab'][10]=konf::get()->langTexty("art_d10"); //Element specjalny

//zmienną określająca dostęp do administracji
$konfig_art['admin_art']=user::get()->upr(11);

$konfig_art['uprawniony_art']=user::get()->upr(18);

konf::get()->setKonfigTab(array("art_konf"=>$konfig_art));

?>