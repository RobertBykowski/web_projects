<?php

if(!defined("SPR_INCLUDE")){
  header("Location: ../index.php");
}

if(user::get()->zalogowany()){
	konf::get()->setTekstyTab("sklep_texty",2);
} else {
	konf::get()->setTekstyTab("sklep_texty");
}

//konfiguracja skryptu sklepu

//komentarze do sklepykułów
$konfig_sklep['kom']=true;

//katalog na grafike akapitów
$konfig_sklep['sklep_kat']="pics/sklep_kat/";

//czy jest dodawanie jpg poprzez formularz
$konfig_sklep['img']=true;

//typ skalowania dla miniaturki kategorii
$konfig_sklep['img_skala']=3;

//miniaturka skalowana nqa wymiar
$konfig_sklep['img_m_size']=120;		

//domyslny rozmiar skalowania img
$konfig_sklep['img_size']=400;

//minimalny wymiar grafiki
$konfig_sklep['img_min_size']=2;

//katalog na grafike akapitów
$konfig_sklep['producenci_kat']="pics/sklep_producenci/";

//czy jest dodawanie jpg poprzez formularz
$konfig_sklep['producent_img']=true;

//typ skalowania dla miniaturki kategorii
$konfig_sklep['producent_img_skala']=3;

//miniaturka skalowana nqa wymiar
$konfig_sklep['producent_img_m_size']=120;		

//domyslny rozmiar skalowania img
$konfig_sklep['producent_img_size']=400;

//minimalny wymiar grafiki
$konfig_sklep['producent_img_min_size']=2;

//katalog na grafike producentow
$konfig_sklep['producenci_kat']="pics/sklep_producenci/";

//katalog na grafike produktow
$konfig_sklep['produkty_kat']="pics/sklep_produkty/";

//czy jest dodawanie jpg poprzez formularz
$konfig_sklep['produkt_img']=true;

//typ skalowania dla miniaturki kategorii
$konfig_sklep['produkt_img_skala']=3;

//typ skalowania dla miniaturki wiekszej
$konfig_sklep['produkt_img2_skala']=3;

//miniaturka skalowana nqa wymiar
$konfig_sklep['produkt_img_m_size']=106;		

//miniaturka skalowana nqa wymiar
$konfig_sklep['produkt_img_m2_size']=250;		

//domyslny rozmiar skalowania img
$konfig_sklep['produkt_img_size']=500;

//minimalny wymiar grafiki
$konfig_sklep['produkt_img_min_size']=2;

//w administracji ile podstron na stronie
$konfig_sklep['sklep_na_str']=25;

//ile produktow na stronie
$konfig_sklep['stronicowanie']=50;

//obrazek zajawki
$konfig_sklep['imgz']=true;

//czy wietlac liste podkategorii 0 - nie - lista produktow z podkategorii, 1 - lista podkategorii
$konfig_sklep['podkat_lista']=1;

//ile poziomow w drzewie administracyjnym 0 - bez ograniczen
$konfig_sklep['drzewo_poziomy']=4;

//wyswietla sciezke
$konfig_sklep['sciezka']=true;

//tytul www zalezny od tytulu kategorii
$konfig_sklep['tytuly_indywidualne']=true;

//zliczac wyswietlenia
$konfig_sklep['zliczac_wys']=true;

//czy jest import danych produktow z csv
$konfig_sklep['import_csv']=true;

//jakie funkcje dla produktow
$konfig_sklep['prod_nowosc']=true;
$konfig_sklep['prod_promocja']=true;
$konfig_sklep['prod_wyprzedaz']=true;
$konfig_sklep['prod_polecamy']=true;
$konfig_sklep['prod_cenapromo']=true;
$konfig_sklep['prod_wyr']=true;  
$konfig_sklep['prod_priorytet']=100;  //ile poziomow priorytetu
$konfig_sklep['prod_tytuly_indywidualne']=true;
$konfig_sklep['prod_zliczac_sprzedane']=true;
$konfig_sklep['prod_zliczac_wys']=true;
$konfig_sklep['prod_symbol']=true;
$konfig_sklep['prod_waga']=true;
$konfig_sklep['prod_dostepnosc']=true;
$konfig_sklep['prod_dostepnosc_sztuk']=true;
$konfig_sklep['prod_odejmuj_sztuki']=true;
$konfig_sklep['prod_glosy']=false;
$konfig_sklep['prod_koment']=false;
$konfig_sklep['prod_opcje']=false;
$konfig_sklep['prod_parametry']=false;
$konfig_sklep['prod_bestsellery']=true;
$konfig_sklep['prod_kupowali']=true;

$konfig_sklep['dostepnosc_tab']=array(
	1=>"dostępny",
	2=>"mała ilość",
	3=>"brak na stanie",
);

//galerie zdjeciowe produktow
$konfig_sklep['prod_galeria']=true;

//katalog na galerie
$konfig_sklep['galeria_kat']="pics/sklep_produkty_gal/";		

//typ galerii
//1 - miniaturka + popup
//2 - miniaturka + projektor popup
//3 - miniaturka + projektor w treści
//5 -miniaturka + powiększenie Lightbox
$konfig_sklep['galeria_typ']=1;		


//galerie zdjeciowe - typ skalowania
//1 - miniaturki o tej samej wysokośći
//2 - miniaturki o tej samej szerokości
//3 - miniaturki skalowane proporcjonalnie na wysokość i szerokość
//6 - miniaturki skalowane i przycinane do jednego rozmiaru
$konfig_sklep['galeria_skalowanie']=1;

//skalowanie
$konfig_sklep['galeria_img_size']=550;

//skalowanie
$konfig_sklep['galeria_min_size']=1;

//skalowanie miniaturki
$konfig_sklep['galeria_m_size']=100;

//opis zdjecia w adminie
$konfig_sklep['galeria_opis']=true;

//tytul zdjecia na liscie
$konfig_sklep['galeria_wys_tytul']=true;

//projektor - szerokosc
$konfig_sklep['galeria_projektor_w']=750;

//projektor - wysokosc
$konfig_sklep['galeria_projektor_h']=750;

//zdjec na podstronie, w administracji
$konfig_sklep['galeria_na_str']=25;

//rozmiar do obrobki
$konfig_sklep['galeria_o_size']=1200;

//czy mozliwosc obrobki
$konfig_sklep['galeria_obrobka']=true;

//ile wierszy na podstronie (0 bez limitu)
$konfig_sklep['galeria_wiersz']=0;

//ile kolumn/zdjec w wierszu na podstronie (zwykle 1-10 zaleznie od szerokosci www)
$konfig_sklep['galeria_kolumna']=5;

//kategorie sklepykułow
$konfig_sklep['d_tab'][1]="Oferta księgarni"; //dzial 1
//$konfig_sklep['d_tab'][2]=konf::get()->langTexty("sklep_d2"); //Dzial 2

$konfig_sklep['platnosci_tab']=array(
	1=>"przy odbiorze",
	2=>"przelew na konto (tradycyjny)",
//	3=>"przelewy24.pl - płatność online",	
//	4=>"platnosci.pl",	
	5=>"dotpay.pl",
);

$konfig_sklep['platnosc_domyslny']=3;

$konfig_sklep['platnosci_statusy_tab']=array(
	0=>"brak",
	1=>"nowa",
	2=>"wykonana",
	3=>"odmowa",		
	4=>"anulowana",		
	5=>"reklamacja",	
	6=>"błąd płatności",					
	7=>"rozpoczęta",		
);


$konfig_sklep['zamowienia_statusy']=array(
	1=>"nowe",
	2=>"opłacone",
	3=>"błąd płatności",	
	4=>"zrealizowane",
	5=>"odrzucone",		
	6=>"reklamacja",	
	7=>"zwrot",	
	8=>"usunięte"
);

$konfig_sklep['dostarczenie_tab']=array(
	1=>"odbiór osobisty",
//	2=>"poczta",
	3=>"kurier",			
);

$konfig_sklep['dostarczenie_domyslny']=3;

$konfig_sklep['platnosci_bledy_tab']=array();

$konfig_sklep['platnosci_bledy_tab'][3]=array(
	'err01'=>'Nie uzyskano od sklepu potwierdzenia odebrania odpowiedzi autoryzacyjnej',
	'err02'=>'Nie uzyskano odpowiedzi autoryzacyjnej',
	'err03'=>'To zapytanie było już przetwarzane',			
	'err04'=>'Zapytanie autoryzacyjne niekompletne lub niepoprawne',	
	'err05'=>'Nie udało się odczytać konfiguracji sklepu internetowego',			
	'err06'=>'Nieudany zapis zapytania autoryzacyjnego',		
	'err07'=>'Inna osoba dokonuje płatności',	
	'err08'=>'Błąd wewnęzny w systemie.',
	'err09'=>'Przekroczono dozwolonąą liczbę poprawek danych.',		
	'err10'=>'Nieprawidłowa kwota transakcji!',				
	'err49'=>'Zbyt wysoki wynik oceny ryzyka transakcji przeprowadzonej przez PolCard.',				
	'err51'=>'Nieprawidłowe wywołanie strony',				
	'err52'=>'Błędna informacja zwrotna o sesji!',				
	'err53'=>'Bład transakcji !',				
	'err54'=>'Niezgodność kwoty transakcji !',
	'err55'=>'Nieprawidłowy kod odpowiedzi !',				
	'err56'=>'Nieprawidłowa karta',				
	'err57'=>'Niezgodność flagi TEST !',				
	'err58'=>'Nieprawidłowy numer sekwencji !',				
	'err101'=>'Błąd wywołania skryptu.',				
	'err102'=>'Minął czas na dokonanie transakcji',				
	'err103'=>'Nieprawidłowa kwota przelewu',				
	'err104'=>'Transakcja oczekuje na potwierdzenie.',				
	'err105'=>'Transakcja dokonana po dopuszczalnym czasie',				
	'err106'=>'Błąd weryfikacji wyniku transakcji',				
	'err161'=>'Żądanie transakcji przerwane przez użytkownika',				
	'err162'=>'Żądanie transakcji przerwane przez użytkownika',				
);

$konfig_sklep['platnosci_bledy_tab'][5]=array(
	'err01'=>'Błąd techniczny.',
	'err02'=>'Nie uzyskano odpowiedzi autoryzacyjnej od banku - wydawca karty.',
	'err03'=>'Transakcja była już przetwarzana i uzyskała zgodę',				
	'err04'=>'Nie wprowadzono wszystkich wymaganych danych lub są one niepoprawne.',				
	'err05'=>'Nie udało się odczytać konfiguracji sklepu internetowego.',				
	'err06'=>'Błąd techniczny.',				
	'err07'=>'Kod obecnie nie używany.',				
	'err08'=>'Błąd techniczny.',				
	'err09'=>'Przekroczono dozwoloną liczbę poprawek danych.',				
	'err10'=>'Przekroczono maksymalną kwotę dla transakcji internetowej (lub kwota jest zbyt niska)',				
	'err11'=>'Kod obecnie nie używany.',				
);

$konfig_sklep['platnosci_bledy_tab'][4]=array(
	"100" => "brak parametru pos id",
	"101" => "brak parametru session id",
	"102" => "brak parametru ts",
	"103" => "brak parametru sig",
	"104" => "brak parametru desc",
	"105" => "brak parametru client ip",
	"106" => "brak parametru first name",
	"107" => "brak parametru last name",
	"108" => "brak parametru street",
	"109" => "brak parametru city",
	"110" => "brak parametru post code",
	"111" => "brak parametru amount",
	"112" => "błędny numer konta bankowego",
	"200" => "inny chwilowy błąd",
	"201" => "inny chwilowy błąd bazy danych",
	"202" => "POS o podanym identyfikatorze jest zablokowany",
	"203" => "niedozwolona wartość pay_type dla danego pos_id",
	"204" => "podana metoda płatności (wartość pay_type) jest chwilowo zablokowana dla danego pos_id, np. przerwa konserwacyjna bramki płatniczej",
	"205" => "kwota transakcji mniejsza od wartości minimalnej",
	"206" => "kwota transakcji większa od wartości maksymalnej",
	"207" => "przekroczona wartość wszystkich transakcji dla jednego klienta w ostatnim przedziale czasowym",
	"208" => "POS działa w wariancie ExpressPayment lecz nie nastapiła aktywacja tego wariantu współpracy (czekamy na zgode działu obsługi klienta)",
	"209" => "błędny numer pos_id lub pos_auth_key",
	"500" => "transakcja nie istnieje",
	"501" => "brak autoryzacji dla danej transakcji",
	"502" => "transakcja rozpoczęta; wcześniej",
	"503" => "autoryzacja do transakcji była juz przeprowadzana",
	"504" => "transakcja anulowana wczesniej",
	"505" => "transakcja przekazana do odbioru wcześniej",
	"506" => "transakcja już odebrana",
	"507" => "błąd podczas zwrotu środków do klienta",
	"599" => "będny stan transakcji, np. nie można uznać transakcji kilka razy lub inny, prosimy o kontakt",
	"999" => "inny błąd krytyczny - prosimy o kontakt"
);

//przy jakiej wartosci przesylki koszt  preslania ==0
$konfig_sklep['przesylka_zero']=250;

//domyslny koszt przesylki
$konfig_sklep['przesylka_koszt']=10;

$konfig_sklep['przesylka_limity_tab'][3]=array(
	'1'=>10,
	'2'=>20,
	'5'=>25,				
	'10'=>30,				
	'20'=>35,				
	'50'=>40,				
	'70'=>45,				
	'100'=>50,						
);


$konfig_sklep['platnosci_parametry_tab'][3]=array(
	'p24_id_sprzedawcy'=>"5699",
	'p24_return_url_ok'=>konf::get()->getKonfigTab('sciezka')."koszyk_p24ok,a,l1.html",
	'p24_return_url_error'=>konf::get()->getKonfigTab('sciezka')."koszyk_p24error,a,l1.html",			
	'p24_adres'=>"https://secure.przelewy24.pl/index.php",									
);

$konfig_sklep['platnosci_parametry_tab'][5]=array(
	'id'=>"5699",
	'link'=>"https://ssl.dotpay.pl/",
	'type'=>3,
	'pin'=>"bd8f7g8347t8erg1",
	'description'=>"",		
	'URL'=>konf::get()->getKonfigTab('sciezka')."koszyk_dotpayf,a,l1.html"
);


$konfig_sklep['platnosci_parametry_tab'][4]=array(
	'pos_id'=>"5699",
	'pos_auth_key'=>"",
	'key'=>"",
	'key2'=>"",	
	'check_payment'=>"https://www.platnosci.pl/paygw/UTF/Payment/get",	
	'pay_payment'=>"https://www.platnosci.pl/paygw/UTF/NewPayment",		
	'pay_type'=>"t",	
);


//jaka akcja po dodaniu do koszyka 1- pokaz kosz 2-powrot do zakupow
$konfig_sklep['kosz_akcja']=1;

//zmienną określająca dostęp do administracji
$konfig_sklep['admin_sklep']=user::get()->upr(20);

konf::get()->setKonfigTab(array("sklep_konf"=>$konfig_sklep));

?>