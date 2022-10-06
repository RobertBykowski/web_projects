-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 07 Lis 2019, 16:52
-- Wersja serwera: 5.7.26-29-log
-- Wersja PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `29111834_1`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_ankieta`
--

CREATE TABLE `antyki_ankieta` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_typ` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL,
  `edytor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL,
  `typ` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `data_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tytul` varchar(200) NOT NULL DEFAULT '',
  `tresc` text NOT NULL,
  `last_ip` varchar(15) NOT NULL DEFAULT '',
  `last_glos` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `logowane` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `lang` tinyint(2) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_ankieta_glosy`
--

CREATE TABLE `antyki_ankieta_glosy` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_u` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_ankieta_list`
--

CREATE TABLE `antyki_ankieta_list` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `nr_poz` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `glosy` int(6) UNSIGNED NOT NULL DEFAULT '0',
  `tresc` varchar(200) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_art`
--

CREATE TABLE `antyki_art` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_d` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_pierwszy` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `poziom` int(5) NOT NULL,
  `nr_poz` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `idtf` varchar(100) NOT NULL DEFAULT '',
  `tytul` varchar(200) NOT NULL DEFAULT '',
  `tytul_menu` varchar(200) NOT NULL,
  `podtytul` text NOT NULL,
  `data_wys` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `zajawka` text NOT NULL,
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(200) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img_align` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `link` varchar(250) NOT NULL DEFAULT '',
  `link_okno` varchar(50) NOT NULL,
  `autor_id` int(11) UNSIGNED NOT NULL,
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(11) NOT NULL,
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `licznik` mediumint(7) UNSIGNED NOT NULL DEFAULT '0',
  `typ` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `komentarze` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `lang` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `na_str` int(3) UNSIGNED NOT NULL DEFAULT '0',
  `dostep` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `rss` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `glowny` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `menu_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `menu_wyr` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `submenu` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `submenu_polozenie` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `submenu_wyglad` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `do_gory` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `mapa_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `tytul_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `stopka_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `idtf_link` varchar(100) NOT NULL,
  `art_description` varchar(250) NOT NULL,
  `art_keywords` varchar(250) NOT NULL,
  `art_title` varchar(200) NOT NULL,
  `wytworzyl` varchar(150) NOT NULL,
  `wytworzyl_data` date NOT NULL DEFAULT '0000-00-00',
  `zrodlo_link` varchar(200) NOT NULL,
  `stat_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `antyki_art`
--

INSERT INTO `antyki_art` (`id`, `id_d`, `id_matka`, `id_pierwszy`, `poziom`, `nr_poz`, `idtf`, `tytul`, `tytul_menu`, `podtytul`, `data_wys`, `zajawka`, `img`, `img_nazwa_oryginal`, `img1_nazwa`, `img1_w`, `img1_h`, `img2_nazwa`, `img2_w`, `img2_h`, `img_align`, `link`, `link_okno`, `autor_id`, `autor_name`, `autor_kiedy`, `edytor_id`, `edytor_name`, `edytor_kiedy`, `data_start`, `data_stop`, `licznik`, `typ`, `komentarze`, `status`, `lang`, `na_str`, `dostep`, `rss`, `glowny`, `menu_nie`, `menu_wyr`, `submenu`, `submenu_polozenie`, `submenu_wyglad`, `do_gory`, `mapa_nie`, `tytul_nie`, `stopka_nie`, `idtf_link`, `art_description`, `art_keywords`, `art_title`, `wytworzyl`, `wytworzyl_data`, `zrodlo_link`, `stat_nie`) VALUES
(244, 1, 0, 0, 0, 1, 'katalog', 'Antyki Katalog', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2009-08-25 20:28:55', 0, '', '0000-00-00 00:00:00', '2009-08-25 20:28:00', '0000-00-00 00:00:00', 1086, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(245, 1, 0, 0, 0, 2, 'glowna', 'Strona główna', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2009-08-25 20:29:17', 1, 'admin', '2009-09-17 22:54:00', '2009-08-25 20:28:00', '0000-00-00 00:00:00', 5087, 0, 0, 1, 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, '', '', '', '', '', '0000-00-00', '', 0),
(246, 1, 0, 0, 0, 3, 'oferta', 'Oferta', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2009-08-25 20:29:31', 1, 'admin', '2009-09-04 16:53:35', '2009-08-25 20:29:00', '0000-00-00 00:00:00', 1599, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 1, '', '', '', '', '', '0000-00-00', '', 0),
(247, 1, 0, 0, 0, 4, 'kontakt', 'Kontakt', '', '', '0000-00-00 00:00:00', '<p><span style=\"color: rgb(128, 0, 0);\"><strong><span style=\"font-family: Tahoma;\"><span style=\"font-size: 13px;\">Manufaktura K.W. Bartoszewicz<br />\r\n87-100 Toruń&nbsp; ul. Reja 22<br />\r\nnasze telefony&nbsp;&nbsp; 056-471-15-09&nbsp;&nbsp;&nbsp; 505-092-097&nbsp;&nbsp; 509-799-003</span></span></strong></span></p>\r\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>\r\n<p>&nbsp;</p>', 0, '', '', 0, 0, '', 0, 0, 0, 'index.php?akcja=kontakt', '', 1, 'admin', '2009-08-25 20:29:47', 1, 'admin', '2009-09-28 09:10:18', '2009-08-25 20:29:00', '0000-00-00 00:00:00', 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(248, 2, 0, 0, 0, 5, '', 'Porcelana', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2009-08-25 21:36:31', 0, '', '0000-00-00 00:00:00', '2009-08-25 21:36:00', '0000-00-00 00:00:00', 1349, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(249, 2, 0, 0, 0, 6, '', 'Meble', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2009-08-25 21:36:36', 1, 'admin', '2009-08-29 18:54:45', '2009-08-25 21:36:00', '0000-00-00 00:00:00', 3357, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(250, 2, 0, 0, 0, 7, '', 'Malarstwo', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2009-08-25 21:36:51', 0, '', '0000-00-00 00:00:00', '2009-08-25 21:36:00', '0000-00-00 00:00:00', 1287, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(251, 2, 0, 0, 0, 8, '', 'Srebro, patery', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2009-08-25 21:37:01', 0, '', '0000-00-00 00:00:00', '2009-08-25 21:36:00', '0000-00-00 00:00:00', 1268, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(252, 2, 0, 0, 0, 9, '', 'Zegary, rzemiosło', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2009-08-25 21:37:13', 1, 'admin', '2009-10-02 22:51:06', '2009-08-25 21:37:00', '0000-00-00 00:00:00', 1851, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(255, 2, 249, 249, 1, 3, '', 'Szafy, witryny, biblioteki', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2009-08-29 18:36:37', 1, 'admin', '2009-09-18 12:34:58', '2009-08-29 18:36:00', '0000-00-00 00:00:00', 1738, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 4, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(266, 2, 249, 249, 1, 2, '', 'Komody,Sekretery', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2009-08-31 12:22:59', 0, '', '0000-00-00 00:00:00', '2009-08-31 12:22:00', '0000-00-00 00:00:00', 1538, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(256, 2, 249, 249, 1, 1, '', 'Stoły, stoliki, biurka', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2009-08-29 18:36:51', 1, 'admin', '2010-01-17 08:45:04', '2009-08-29 18:36:00', '0000-00-00 00:00:00', 1455, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 4, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(257, 2, 249, 249, 1, 6, '', 'Kanapy, sofy, fotele, krzesła', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2009-08-29 18:37:14', 1, 'admin', '2009-08-29 18:49:54', '2009-08-29 18:36:00', '0000-00-00 00:00:00', 1445, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 4, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(258, 2, 249, 249, 1, 7, '', 'Toaletki, lustra, pozostałe', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2009-08-29 18:37:34', 1, 'admin', '2009-08-29 18:50:04', '2009-08-29 18:37:00', '0000-00-00 00:00:00', 1040, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 4, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(305, 2, 257, 249, 2, 1, '', 'Kątny fotelik gabinetowy', '', '', '0000-00-00 00:00:00', '<p><span style=\"font-family: Verdana;\">Fotel wykonany&nbsp; jest z litego dębu , siedzisko wybite zostało nową skórą licową w kolorze koniakowym ,obitą rzędami złotych ćwieków.</span></p>\r\n<p><strong><span style=\"color: rgb(255, 0, 0);\"><span style=\"font-family: Verdana;\">Cena . 850 zł </span></span></strong></p>', 2, '505_001.jpg', '305_img1_4e04f9d768d45bb327abb2fdc32d7d97.jpg', 190, 254, '305_img2_4072a261d955c71a66973ca810c7c046.jpg', 110, 148, 0, '', '', 1, 'admin', '2009-09-07 11:20:06', 1, 'admin', '2009-09-07 11:39:33', '2009-09-07 11:19:00', '0000-00-00 00:00:00', 342, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(306, 2, 257, 249, 2, 2, '', 'Krzesło 2', '', '', '0000-00-00 00:00:00', '<p><span style=\"font-family: Verdana;\">Fotel wykonany&nbsp; jest z litego dębu , siedzisko wybite zostało nową skórą licową w kolorze koniakowym ,obitą rzędami złotych ćwieków.</span></p>', 2, '505_004.jpg', '306_img1_832b58054cca3c2a08638c14e4c76d56.jpg', 190, 254, '306_img2_38b77a7ce3c0e4b1dd9de6740f6b57ab.jpg', 110, 148, 0, '', '', 1, 'admin', '2009-09-07 11:32:33', 1, 'admin', '2009-09-07 11:36:32', '2009-09-07 11:32:00', '0000-00-00 00:00:00', 311, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(307, 2, 255, 249, 2, 1, '', 'biblioteka dębowa lata 1915-1925', '', '', '0000-00-00 00:00:00', '<p>biblioteka dębowa trzydrzwiowa pochodząca z lat dwudziestych minionego wieku</p>\r\n<p>&nbsp;</p>\r\n<p><strong><span style=\"font-family: Verdana;\"><span style=\"color: rgb(128, 0, 0);\">cena 7500</span></span></strong></p>', 2, 'bibl5_(5).jpg', '307_img1_2cd019cb27043ae5169e4610e1214c33.jpg', 254, 168, '307_img2_5fe217d7fac7a32b23903d0113686da2.jpg', 148, 97, 0, '', '', 1, 'admin', '2009-09-07 11:42:54', 1, 'admin', '2009-09-18 12:33:14', '2009-09-07 11:42:00', '0000-00-00 00:00:00', 615, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(308, 2, 256, 249, 2, 1, '', 'stół dębowy rozkładany dwudziestolecie międzywojenne', '', '', '0000-00-00 00:00:00', '', 2, 'giozte_sz_333.jpg', '308_img1_915cef0ed9c48fafaa7bb7d778f0a697.jpg', 254, 190, '308_img2_75c10df4e877ae4f17ec9d3ea60595b1.jpg', 148, 110, 0, '', '', 1, 'admin', '2009-09-17 22:35:43', 1, 'admin', '2009-09-17 22:50:08', '2009-09-17 22:34:00', '0000-00-00 00:00:00', 908, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', 'stół dębowy rozkładany stary antyki antyczny dwudziestolecie', '', '', '0000-00-00', '', 0),
(309, 2, 255, 249, 2, 2, '', 'biblioteka lata 1915-25', '', '', '0000-00-00 00:00:00', '<br />\r\n<p><bdo dir=\"ltr\"><span style=\"font-family: Tahoma;\"><strong><span style=\"color: rgb(128, 0, 0);\">cena 6000 zł</span></strong></span></bdo><span style=\"font-family: Tahoma;\"><strong><span style=\"color: rgb(128, 0, 0);\"><br />\r\n</span></strong></span></p>', 2, 'wtorek_019.jpg', '309_img1_b44668c3b40264a7dbbb745efd73c581.jpg', 254, 190, '309_img2_ce8a3a02e454cb9311b0d632f5531af9.jpg', 148, 110, 0, '', '', 1, 'admin', '2009-09-18 12:36:13', 1, 'admin', '2010-01-17 09:25:11', '2009-09-18 12:35:00', '0000-00-00 00:00:00', 572, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', 'biblioteka antyki gabinet  meble antyczne dwudziestolecie', 'biblioteka antyki szafa gabinet toruń', '', '0000-00-00', '', 0),
(310, 1, 247, 247, 1, 1, '', 'nasze telefony    056-471-15-09    505-092-097   509799003', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2009-09-28 09:06:29', 1, 'admin', '2009-09-28 09:07:17', '2009-09-28 09:05:00', '0000-00-00 00:00:00', 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(311, 2, 249, 249, 1, 8, '', 'gabinety', '', '', '0000-00-00 00:00:00', '', 2, 'gabinet_z_krzyZEem_005.jpg', '311_img1_7cbf23fcbf665dbb452a374a9cd40e8b.jpg', 254, 190, '311_img2_4a2eb505c0ded29a08a603a19f2f2a73.jpg', 148, 110, 0, '', '', 1, 'admin', '2009-10-02 22:36:32', 1, 'admin', '2009-10-02 22:43:47', '2009-10-02 22:36:00', '0000-00-00 00:00:00', 834, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(313, 2, 255, 249, 2, 3, '', 'ogromna szafa dębowa 1870-1890', '', '', '0000-00-00 00:00:00', '', 2, '12.30_003.jpg', '313_img1_26ea2b1a7acaf18baa5d7cad9bd0c899.jpg', 254, 190, '313_img2_51aa9d1e53dc9e159d1517bc6b602ed4.jpg', 148, 110, 0, '', '', 1, 'admin', '2010-01-16 21:13:03', 1, 'admin', '2010-01-17 09:04:32', '2010-01-16 21:11:00', '0000-00-00 00:00:00', 382, 0, 0, 1, 1, 0, 0, 0, 0, 0, 1, 0, 1, 1, 0, 0, 0, 0, '', '', 'szafa garderobiana  ubraniowa stara antyczna dębowa', '', '', '0000-00-00', '', 0),
(314, 2, 255, 249, 2, 4, '', 'biblioteka dębowa lata 1920-1930', '', '', '0000-00-00 00:00:00', '', 2, 'b1_002.jpg', '314_img1_3fb4c48a8ca73d93a4dd3ffee78eaf59.jpg', 190, 254, '314_img2_5011353d311431098eb98974753caaff.jpg', 110, 148, 0, '', '', 1, 'admin', '2010-01-16 21:34:06', 1, 'admin', '2010-01-16 22:00:42', '2010-01-16 21:33:00', '0000-00-00 00:00:00', 379, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', 'biblioteka stara antyczna dwudziestolecie gabinetowa', '', '', '0000-00-00', '', 0),
(315, 2, 256, 249, 2, 2, '', 'STÓŁ MAHONIOWY LUDWIKOWSKI OWALNY', '', '', '0000-00-00 00:00:00', '', 2, 'zegary_161.jpg', '315_img1_ec03f11ced2d6ef40a6242bea7f44a1d.jpg', 254, 190, '315_img2_4c7304f0dc7804109253efec4003c7a4.jpg', 148, 110, 0, '', '', 1, 'admin', '2010-01-17 08:44:05', 1, 'admin', '2010-01-17 09:00:38', '2010-01-17 08:40:00', '0000-00-00 00:00:00', 309, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', 'stół owalny orzechowy mahoniowy ludwik filip antyczny filipowski ludwikowski', 'stół owalny orzechowy mahoniowy ludwik', '', '0000-00-00', '', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_artd`
--

CREATE TABLE `antyki_artd` (
  `id` int(10) UNSIGNED NOT NULL,
  `akcja` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `akcja_data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `akcja_autor` varchar(150) NOT NULL,
  `akcja_autor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_art` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_d` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_pierwszy` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `poziom` int(5) NOT NULL,
  `nr_poz` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `idtf` varchar(100) NOT NULL DEFAULT '',
  `tytul` varchar(200) NOT NULL DEFAULT '',
  `tytul_menu` varchar(200) NOT NULL,
  `podtytul` text NOT NULL,
  `data_wys` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `zajawka` text NOT NULL,
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(200) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img_align` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `link` varchar(250) NOT NULL DEFAULT '',
  `link_okno` varchar(50) NOT NULL,
  `autor_id` int(11) UNSIGNED NOT NULL,
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(11) NOT NULL,
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `licznik` mediumint(7) UNSIGNED NOT NULL DEFAULT '0',
  `typ` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `komentarze` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `lang` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `na_str` int(3) UNSIGNED NOT NULL DEFAULT '0',
  `dostep` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `rss` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `glowny` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `menu_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `menu_wyr` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `submenu` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `submenu_polozenie` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `submenu_wyglad` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `do_gory` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `mapa_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `tytul_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `stopka_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `idtf_link` varchar(100) NOT NULL,
  `art_description` varchar(250) NOT NULL,
  `art_keywords` varchar(250) NOT NULL,
  `art_title` varchar(200) NOT NULL,
  `wytworzyl` varchar(150) NOT NULL,
  `wytworzyl_data` date NOT NULL DEFAULT '0000-00-00',
  `zrodlo_link` varchar(200) NOT NULL,
  `stat_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_art_akapity`
--

CREATE TABLE `antyki_art_akapity` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `nr_poz` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `tytul` varchar(250) NOT NULL,
  `tresc` longtext NOT NULL,
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(250) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img_align` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `img_opis` varchar(200) NOT NULL DEFAULT '',
  `img_link` varchar(250) NOT NULL DEFAULT '',
  `img_link_okno` varchar(50) NOT NULL DEFAULT '',
  `autor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL,
  `edytor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL,
  `typ` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `ramka` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `ramka_kolor` varchar(6) NOT NULL,
  `tlo_kolor` varchar(6) NOT NULL,
  `dlugosc` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `padding` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_wiersz` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_kolumna` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_typ` smallint(2) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_zalezne` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_m_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_m_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_skala` smallint(2) UNSIGNED NOT NULL DEFAULT '0',
  `blokada` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `data_blokada` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `antyki_art_akapity`
--

INSERT INTO `antyki_art_akapity` (`id`, `id_matka`, `nr_poz`, `tytul`, `tresc`, `img`, `img_nazwa_oryginal`, `img1_nazwa`, `img1_w`, `img1_h`, `img2_nazwa`, `img2_w`, `img2_h`, `img_align`, `img_opis`, `img_link`, `img_link_okno`, `autor_id`, `autor_name`, `autor_kiedy`, `edytor_id`, `edytor_name`, `edytor_kiedy`, `typ`, `ramka`, `ramka_kolor`, `tlo_kolor`, `dlugosc`, `padding`, `galeria_wiersz`, `galeria_kolumna`, `galeria_typ`, `galeria_zalezne`, `galeria_m_w`, `galeria_m_h`, `galeria_skala`, `blokada`, `data_blokada`, `status`) VALUES
(176, 305, 1, '', '<p><span style=\"font-family: Verdana;\">Fotel wykonany&nbsp; jest z litego dębu , siedzisko wybite zostało nową skórą licową w kolorze koniakowym ,obitą rzędami złotych ćwieków.</span></p>\r\n<p>&nbsp;</p>\r\n<p><span style=\"font-family: Verdana;\">wysokość siedziska 46cm<br />\r\nszerokość 48 cm<br />\r\ngłębokość 48cm <br />\r\nwysokość z oparciem 79 cm</span></p>', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2009-09-07 11:23:16', 1, 'admin', '2009-09-07 11:27:43', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(164, 245, 1, '', '<p><span style=\"font-size: 13px;\"><strong><span style=\"color: rgb(153, 51, 0);\">WITAMY SERDECZNIE NA NASZEJ STRONIE INTERNETOWEJ I ZACHĘCAMY DO OBEJRZENIA NASZEJ OFERTY</span></strong></span></p>\r\n<p><span style=\"font-size: 13px;\"><strong><span style=\"color: rgb(153, 51, 0);\"><span style=\"font-family: Tahoma;\">Skupem,renowacją i sprzedażą mebli zajmujemy się już od blisko 15 lat ,czynimy to ciągle z taką samą pasją i zaangażowaniem .Nasza galeria i pracownia mieszczą się w Toruniu,meble odrestaurowane przez nas a także i te jeszcze przed renowacją będziemy systematycznie umieszczać na naszej stronie i serdecznie zapraszamy Państwa do zapoznania się z naszą ofertą.</span></span></strong></span></p>\r\n<p><span style=\"font-size: 13px;\"><strong><span style=\"color: rgb(153, 51, 0);\"><span style=\"font-family: Verdana;\">Specjalizujemy się w obróbce, konserwacji i renowacji antyków starych mebli, ale również innych staroci (malarstwo, rzeźba figuralna, ceramika, wyroby zdobnicze, rękodzieła artystyczne).</span></span></strong></span></p>\r\n<p><span style=\"font-size: 13px;\"><strong><span style=\"color: rgb(153, 51, 0);\"><span style=\"font-family: Verdana;\">Proces renowacji mebli opiera się na tradycyjnych metodach stosowanych dawniej, co pozwala zatrzymać piękno antycznego mebla. Więcej informacji z zakresu renowacji i konserwacji mebli udzielimy Państwu po kontakcie z nami .</span></span></strong></span><span style=\"font-family: Verdana;\"><br />\r\n</span></p>', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2009-08-31 11:18:13', 1, 'admin', '2009-09-17 22:54:00', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(177, 306, 1, '', '<p>Fotel wykonany&nbsp; jest z litego dębu , siedzisko wybite zostało nową skórą licową w kolorze koniakowym ,obitą rzędami złotych ćwieków.</p>\r\n<p>&nbsp;</p>\r\n<p>wymiary</p>', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2009-09-07 11:35:52', 0, '', '0000-00-00 00:00:00', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(178, 307, 1, '', '<p><span style=\"font-family: Verdana;\">szfa pochodzi z lat dwudziestych minionego wieku </span></p>\r\n<p><span style=\"font-family: Verdana;\">stan po renowacji </span></p>', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2009-09-07 11:47:36', 0, '', '0000-00-00 00:00:00', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(175, 247, 1, '', '<p>Komoda w stylu rokokowym wykonana w Europie północnej w latach 40-tych XX wieku. Komoda z typowym dla stylu wybrzuszeniem frontu. Trzyszufladowa , dekorowana intarsją mahoniową&nbsp;w &quot;jodełkę&quot;, oraz jasną żyłką. Konstrukcja mebla sosnowa , szuflady w całości wykonane z mahoniu. Okucia cyzelowane z patynowanego mosiądzu.Na blacie granit w odcieniu zieleni o falistej lini z uskokiem. Wysokość 79 cm , szerokość 101 cm , głębokość 54 cm. Stan zachowania doskonały.</p>', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2009-09-01 21:54:22', 0, '', '0000-00-00 00:00:00', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(180, 308, 1, '', '', 2, 'giozte_sz_338.jpg', '180_img1_955d66cee427c9c4df719fe25a210f3a.jpg', 600, 449, '180_img2_bb53c4e15ec49909dde4ab5359d178a3.jpg', 148, 110, 2, '', '', '', 1, 'admin', '2009-09-17 22:43:37', 0, '', '0000-00-00 00:00:00', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(181, 308, 2, '', '', 2, 'giozte_sz_336.jpg', '181_img1_adcb664cf0a8a3728b6424e8886d9602.jpg', 449, 600, '181_img2_8b830610a6ec8ee145678d4235d8ae5e.jpg', 110, 148, 2, '', '', '', 1, 'admin', '2009-09-17 22:43:58', 0, '', '0000-00-00 00:00:00', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(182, 308, 3, '', '', 2, 'giozte_sz_344.jpg', '182_img1_d6a644ffb0a71fd351a19cddefafc327.jpg', 600, 449, '182_img2_8dbb7fc07c24cbd6e17d7137f554fe36.jpg', 148, 110, 2, '', '', '', 1, 'admin', '2009-09-17 22:44:25', 0, '', '0000-00-00 00:00:00', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(183, 308, 4, '', '<p>Przed Państwem stół dębowy ,rozkładany ,z lat 1920-25 </p>\r\n<p>po renowacji, kolor ciepły orzech, lity dąb</p>\r\n<p><span style=\"color: rgb(128, 0, 0);\"><strong>cena 3200 zl</strong></span></p>', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2009-09-17 22:50:08', 0, '', '0000-00-00 00:00:00', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(185, 311, 1, 'gabinet lata dwudzieste', '<p><span style=\"color: rgb(153, 51, 0);\"><span style=\"font-size: 13px;\"><span style=\"font-family: Tahoma;\">komplet mebli gabinetowych ,biblioteka i biurko ,stan po renowacji <br />\r\n</span></span></span></p>\r\n<p><span style=\"color: rgb(153, 51, 0);\"><strong><span style=\"font-family: Tahoma;\">cena 7000</span></strong></span></p>', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2009-10-02 22:38:53', 0, '', '0000-00-00 00:00:00', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(186, 252, 1, 'zegar stojący Gustaw Becker', '<p><span style=\"color: rgb(128, 0, 0);\"><span style=\"font-family: Tahoma;\">Zegar stojący ,pochodzący z lat dwudziestych ,w dębowej skrzyni ,na chodzie ,stan&nbsp; po renowacji</span></span></p>\r\n<p><strong><span style=\"color: rgb(128, 0, 0);\"><span style=\"font-family: Tahoma;\">cena 2800</span></span></strong></p>', 2, 'giozte_sz_282.jpg', '186_img1_dc2f2251597db8322cea9da184361757.jpg', 449, 600, '186_img2_4bda34d47f51f37315486fc95556f8f9.jpg', 110, 148, 2, '', '', '', 1, 'admin', '2009-10-02 22:48:44', 0, '', '0000-00-00 00:00:00', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(188, 313, 1, '', '<p>&nbsp;</p>\r\n<p><span style=\"color: rgb(128, 0, 0);\"><ins> </ins></span><ins>\r\n<p><span style=\"color: rgb(128, 0, 0);\">&nbsp;</span></p>\r\n<span style=\"color: rgb(128, 0, 0);\"><span style=\"font-family: Times New Roman;\"><tt>Przedstawiamy Państwu mebel niezwykły ,ogromną,</tt></span></span><span style=\"color: rgb(128, 0, 0);\">  <span style=\"font-family: Times New Roman;\"><tt>pięknie zdobioną szafę garderobianą <br />\r\n</tt></span>   </span>\r\n<p><span style=\"font-family: Times New Roman;\"><tt>stan po renowacji <br />\r\n</tt></span></p>\r\n<p>&nbsp;&nbsp;<span style=\"font-family: Times New Roman;\"><tt>wymiary<br />\r\n</tt></span></p>\r\n<p><span style=\"color: rgb(128, 0, 0);\"><span style=\"font-size: 14px;\"><font style=\"font-family: Times New Roman,Times,serif; font-style: italic;\">wysokość 258 cm</font><br />\r\n<font style=\"font-family: Times New Roman,Times,serif; font-style: italic;\">szerokość 265 cm</font><br />\r\n<font style=\"font-family: Times New Roman,Times,serif; font-style: italic;\">głębokość&nbsp; 102 cm</font></span></span></p>\r\n<p><span style=\"font-family: Times New Roman;\"><span style=\"color: rgb(128, 0, 0);\">&nbsp;</span></span></p>\r\n</ins></p>\r\n<p><span style=\"color: rgb(128, 0, 0);\"><strong>cena 28000</strong></span></p>', 2, '301_036.jpg', '188_img1_621cf7167fe283d2a4371d921d04fc3d.jpg', 600, 450, '188_img2_0b197ca27aac24270160f8972df90d11.jpg', 148, 111, 2, '', '', '', 1, 'admin', '2010-01-16 21:18:14', 1, 'admin', '2010-01-17 09:04:32', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(189, 314, 1, '', '<p><span style=\"font-family: Times New Roman;\">Zapraszamy do obejrzenia zdjęć biblioteki dębowej ,trzydrzwiowej o płycinach ,lekko gietych ,wyłożonych fornirem orzecha kaukaskiego<br />\r\n</span></p>\r\n<p><span style=\"font-family: Times New Roman;\">środkowe drzwi przeszklone szlifowaną ,oryginalną szybą.</span></p>\r\n<p><span style=\"font-family: Times New Roman;\">stan po renowacji</span></p>\r\n<p><span style=\"font-size: 14px;\"><span style=\"color: rgb(128, 0, 0);\"><strong>cena 3000</strong></span></span></p>', 2, 'b1_002.jpg', '189_img1_64e7e9ed2a52fa0562d9381d69185c3b.jpg', 449, 600, '189_img2_54ecd42364812e64baddb69b28dd93f1.jpg', 110, 148, 2, '', '', '', 1, 'admin', '2010-01-16 21:35:47', 1, 'admin', '2010-01-16 21:53:01', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(191, 315, 1, '', '<p><span style=\"font-family: Times New Roman;\"><span style=\"color: rgb(128, 0, 0);\">oryginany stó ł z&nbsp; okresu 1860-1880 &nbsp; blat owalny ,wyłożony fornirem mahoniowym,na jednej mahonioewj nodze<br />\r\n</span></span></p>\r\n<p><span style=\"font-family: Times New Roman;\"><span style=\"color: rgb(128, 0, 0);\">stan bdb<br />\r\n</span></span></p>\r\n<p><strong><span style=\"font-size: 14px;\"><span style=\"font-family: Times New Roman;\"><span style=\"color: rgb(128, 0, 0);\">cena 3500</span></span></span></strong></p>', 2, 'zegary_161.jpg', '191_img1_6fb4c215790d474781557137a0223d62.jpg', 600, 449, '191_img2_3c45d7753e9472403da3091756da6b40.jpg', 148, 110, 2, '', '', '', 1, 'admin', '2010-01-17 08:44:31', 1, 'admin', '2010-01-17 08:49:29', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(197, 309, 1, '', '<p><span style=\"font-family: Times New Roman;\">biblioteka dębowa ,stan po renowacji ,piękna forma ,oryginalne gięte szyby ,okleinowana fornirem dębowym i orzechowym<br />\r\n</span></p>\r\n<p><span style=\"font-family: Times New Roman;\">utrzymana w kolorze ciemnych ,ciepłych brązów.Polecam!</span></p>\r\n<p><span style=\"font-family: Times New Roman;\">wymiary szer/wys/głębokość</span><bdo dir=\"ltr\"><br />\r\n</bdo></p>\r\n<h3><bdo dir=\"ltr\"><span style=\"font-family: Times New Roman;\">249cm/210 cm/60 cm</span></bdo></h3>', 2, 'wtorek_019.jpg', '197_img1_b938d57a40a9dde71b0bee0700f590a2.jpg', 600, 450, '197_img2_4b37381c9a764df5efb4b30e6be423fc.jpg', 148, 111, 2, '', '', '', 1, 'admin', '2010-01-17 09:20:18', 0, '', '0000-00-00 00:00:00', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_art_akapityd`
--

CREATE TABLE `antyki_art_akapityd` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_artd` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_akapit` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `nr_poz` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `tytul` varchar(250) NOT NULL,
  `tresc` longtext NOT NULL,
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(250) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img_align` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `img_opis` varchar(200) NOT NULL DEFAULT '',
  `img_link` varchar(250) NOT NULL DEFAULT '',
  `img_link_okno` varchar(50) NOT NULL DEFAULT '',
  `autor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL,
  `edytor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL,
  `typ` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `ramka` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `ramka_kolor` varchar(6) NOT NULL,
  `tlo_kolor` varchar(6) NOT NULL,
  `dlugosc` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `padding` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_wiersz` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_kolumna` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_typ` smallint(2) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_zalezne` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_m_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_m_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_skala` smallint(2) UNSIGNED NOT NULL DEFAULT '0',
  `blokada` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `data_blokada` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_art_dziennik`
--

CREATE TABLE `antyki_art_dziennik` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_u` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_art` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor` varchar(100) NOT NULL DEFAULT '',
  `opis` varchar(255) NOT NULL DEFAULT '',
  `data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_art_galeria`
--

CREATE TABLE `antyki_art_galeria` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `nr_poz` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `tytul` varchar(250) NOT NULL,
  `opis` text NOT NULL,
  `autor_zdjecia` varchar(250) NOT NULL,
  `licznik` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `punkty` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `ilosc_glosow` int(8) UNSIGNED NOT NULL DEFAULT '0',
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(250) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL,
  `edytor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `obrobka` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `img3_nazwa` varchar(200) NOT NULL,
  `img3_h` smallint(4) NOT NULL,
  `img3_w` smallint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `antyki_art_galeria`
--

INSERT INTO `antyki_art_galeria` (`id`, `id_matka`, `nr_poz`, `tytul`, `opis`, `autor_zdjecia`, `licznik`, `punkty`, `ilosc_glosow`, `img`, `img_nazwa_oryginal`, `img1_nazwa`, `img1_w`, `img1_h`, `img2_nazwa`, `img2_w`, `img2_h`, `autor_id`, `autor_name`, `autor_kiedy`, `edytor_id`, `edytor_name`, `edytor_kiedy`, `status`, `obrobka`, `img3_nazwa`, `img3_h`, `img3_w`) VALUES
(208, 178, 3, '', '', '', 0, 0, 0, 2, 'bibl5.jpg', '208_img1_a40f20c567342aac654b67ce9e02504b.jpg', 365, 550, '208_img2_9fdfa1fed34528dd6b24572bb40918c1.jpg', 66, 100, 1, 'admin', '2009-09-07 11:50:04', 0, '', '0000-00-00 00:00:00', 1, 0, '208_img3_9fdfa1fed34528dd6b24572bb40918c1.jpg', 382, 254),
(203, 176, 1, '', '', '', 0, 0, 0, 2, '505_003.jpg', '203_img1_446408bc6914e674f574cef998de6423.jpg', 550, 412, '203_img2_3ffbf80d07489f8cbbd9b765137c70b3.jpg', 133, 100, 1, 'admin', '2009-09-07 11:26:29', 0, '', '0000-00-00 00:00:00', 1, 0, '203_img3_3ffbf80d07489f8cbbd9b765137c70b3.jpg', 190, 254),
(204, 176, 2, '', '', '', 0, 0, 0, 2, '505_006.jpg', '204_img1_5ca3d44db61eee724524b5516cc744f2.jpg', 550, 412, '204_img2_9841c72fcd46e90df632ccab3a5c8db4.jpg', 133, 100, 1, 'admin', '2009-09-07 11:26:55', 0, '', '0000-00-00 00:00:00', 1, 0, '204_img3_39f491c47c620485ae90b749058a671a.jpg', 190, 254),
(205, 177, 1, '', '', '', 0, 0, 0, 2, '505_006.jpg', '205_img1_452ed9106ac94f74299a2a9af9e2fbc6.jpg', 550, 412, '205_img2_0cd671ef82a4d1ce0a2a34e8326c561f.jpg', 133, 100, 1, 'admin', '2009-09-07 11:36:31', 0, '', '0000-00-00 00:00:00', 1, 0, '205_img3_0cd671ef82a4d1ce0a2a34e8326c561f.jpg', 190, 254),
(206, 178, 1, '', '', '', 0, 0, 0, 2, 'bibl5_(3).jpg', '206_img1_4f5b64584551017265603ab5d8cd1d10.jpg', 365, 550, '206_img2_b378aab49f8d983cf54139806b348064.jpg', 66, 100, 1, 'admin', '2009-09-07 11:48:52', 0, '', '0000-00-00 00:00:00', 1, 0, '206_img3_b378aab49f8d983cf54139806b348064.jpg', 382, 254),
(207, 178, 2, '', '', '', 0, 0, 0, 2, 'bibl5_(1).jpg', '207_img1_81f44de9a6c6390dd40b606cf8feebbb.jpg', 550, 365, '207_img2_26becf4a374e614b8cb6482b4188c5ef.jpg', 150, 100, 1, 'admin', '2009-09-07 11:49:17', 0, '', '0000-00-00 00:00:00', 1, 0, '207_img3_26becf4a374e614b8cb6482b4188c5ef.jpg', 168, 254),
(211, 185, 1, '', '', '', 0, 0, 0, 2, 'gabinet_z_krzyZEem_039.jpg', '211_img1_211732f8b6421044bbf0c58ba23173e1.jpg', 550, 412, '211_img2_effb9f12c07a0546f5136aa3836a3984.jpg', 133, 100, 1, 'admin', '2009-10-02 22:40:40', 0, '', '0000-00-00 00:00:00', 1, 0, '211_img3_effb9f12c07a0546f5136aa3836a3984.jpg', 190, 254),
(212, 185, 2, '', '', '', 0, 0, 0, 2, 'gabinet_z_krzyZEem_065.jpg', '212_img1_04752a2b62cde89da7b16ed836ecf607.jpg', 412, 550, '212_img2_f126cc8e7084ee2eaf9e3bdf874249af.jpg', 74, 100, 1, 'admin', '2009-10-02 22:43:06', 0, '', '0000-00-00 00:00:00', 1, 0, '212_img3_5c191be95d6af14254bfe0825ba08e5b.jpg', 339, 254),
(213, 185, 3, '', '', '', 0, 0, 0, 2, 'gabinet_z_krzyZEem_020.jpg', '213_img1_39beb8a0e5b60580aa6a19260b18edae.jpg', 550, 412, '213_img2_87d0f7bd59611c99c2f675b55abcd176.jpg', 133, 100, 1, 'admin', '2009-10-02 22:43:24', 0, '', '0000-00-00 00:00:00', 1, 0, '213_img3_eb74414932776a7cbd8d39577a7b1558.jpg', 190, 254),
(214, 185, 4, '', '', '', 0, 0, 0, 2, 'gabinet_z_krzyZEem_028.jpg', '214_img1_0af6070322cbba5606b3442870877b4a.jpg', 412, 550, '214_img2_dd097d710f2e50a709054b861dcf89f3.jpg', 74, 100, 1, 'admin', '2009-10-02 22:43:46', 0, '', '0000-00-00 00:00:00', 1, 0, '214_img3_dd097d710f2e50a709054b861dcf89f3.jpg', 339, 254),
(215, 186, 1, '', '', '', 0, 0, 0, 2, 'giozte_sz_291.jpg', '215_img1_3d3b27a2e686d17e794004ce5d905062.jpg', 412, 550, '215_img2_6a978493ef9e67259d4e4d7dce7439b0.jpg', 74, 100, 1, 'admin', '2009-10-02 22:49:22', 0, '', '0000-00-00 00:00:00', 1, 0, '215_img3_6a978493ef9e67259d4e4d7dce7439b0.jpg', 339, 254),
(216, 186, 2, '', '', '', 0, 0, 0, 2, 'giozte_sz_288.jpg', '216_img1_feaa5ec56034de7f4c7729860a78beb4.jpg', 550, 412, '216_img2_c146ed98d03912173494229f53f6a74e.jpg', 133, 100, 1, 'admin', '2009-10-02 22:51:04', 0, '', '0000-00-00 00:00:00', 1, 0, '216_img3_8b028f5a34d9286584ac6bc2f8a45a71.jpg', 190, 254),
(250, 197, 3, '', 'delikatny,niemal koronkowy dekor umieszczony  w centralnej części środkowych,lekko cofniętych drzwi biblioteki prezentuje się wspaniale', '', 0, 0, 0, 2, 'wtorek_077.jpg', '250_img1_8ca4eff48fb0316fde4213cd44f27b83.jpg', 550, 412, '250_img2_f8caec6277d4cc6efcdc3a577a5663ba.jpg', 133, 100, 1, 'admin', '2010-01-17 09:25:11', 0, '', '0000-00-00 00:00:00', 1, 0, '250_img3_f8caec6277d4cc6efcdc3a577a5663ba.jpg', 190, 254),
(249, 197, 6, '', '', '', 0, 0, 0, 2, 'wtorek_083.jpg', '249_img1_688bc27bef2e4efb0383e0c83c51cdb0.jpg', 412, 550, '249_img2_eb1b4cefef319d9d20bed53f0fccb403.jpg', 74, 100, 1, 'admin', '2010-01-17 09:22:52', 0, '', '0000-00-00 00:00:00', 1, 0, '249_img3_eb1b4cefef319d9d20bed53f0fccb403.jpg', 339, 254),
(248, 197, 5, '', '', '', 0, 0, 0, 2, 'wtorek_069.jpg', '248_img1_85beaf3ffe0bb8d298baa5ffde193d19.jpg', 550, 412, '248_img2_5afcd1801934989c9a880b9d6ae93d19.jpg', 133, 100, 1, 'admin', '2010-01-17 09:22:36', 0, '', '0000-00-00 00:00:00', 1, 0, '248_img3_070d7cdc3752c287b256690c4fb6d18a.jpg', 190, 254),
(247, 197, 4, '', '', '', 0, 0, 0, 2, 'wtorek_033.jpg', '247_img1_65ffd99b6fc4cbe9bdf09ae4830edc66.jpg', 412, 550, '247_img2_6045a97b168241f0e7f7bdd1f8e882df.jpg', 74, 100, 1, 'admin', '2010-01-17 09:22:17', 0, '', '0000-00-00 00:00:00', 1, 0, '247_img3_78fefd6070def1c86e174b34a59be37e.jpg', 339, 254),
(246, 197, 2, '', '', '', 0, 0, 0, 2, 'wtorek_020.jpg', '246_img1_57c3a9c697d99bd1cadfed450367f036.jpg', 550, 412, '246_img2_b3f33191a33443af3da9621882909e4a.jpg', 133, 100, 1, 'admin', '2010-01-17 09:21:32', 0, '', '0000-00-00 00:00:00', 1, 0, '246_img3_b3f33191a33443af3da9621882909e4a.jpg', 190, 254),
(245, 197, 1, '', '', '', 0, 0, 0, 2, 'wtorek_019.jpg', '245_img1_5a92701fbd795d026a616dda8f2b2f2f.jpg', 550, 412, '245_img2_9995d62a86ff940092e7e0c9ad11c4cb.jpg', 133, 100, 1, 'admin', '2010-01-17 09:21:19', 0, '', '0000-00-00 00:00:00', 1, 0, '245_img3_bba365c2f48af7ee516ee05ea4f02cb1.jpg', 190, 254),
(224, 188, 1, '', '', '', 0, 0, 0, 2, '12.30_003.jpg', '224_img1_0b2c76d2a5f4151f6db13c916f120c12.jpg', 550, 412, '224_img2_00f18a8711bc190e20b259d2ea69dfac.jpg', 133, 100, 1, 'admin', '2010-01-16 21:19:04', 0, '', '0000-00-00 00:00:00', 1, 0, '224_img3_00f18a8711bc190e20b259d2ea69dfac.jpg', 190, 254),
(225, 188, 2, '', '', '', 0, 0, 0, 2, '12.30_007.jpg', '225_img1_f6292a6bdbb9fbfa1bc091d3cbc18fdb.jpg', 412, 550, '225_img2_c7cb5ff286baf5d0c59e30883827c710.jpg', 74, 100, 1, 'admin', '2010-01-16 21:19:27', 0, '', '0000-00-00 00:00:00', 1, 0, '225_img3_5ad824673b09c648a90c035bae36d38f.jpg', 339, 254),
(226, 188, 3, '', '', '', 0, 0, 0, 2, '12.30_022.jpg', '226_img1_d32f5fece9f4169212ccee9a50416031.jpg', 412, 550, '226_img2_6952a47148badfd7df44852e8513ebeb.jpg', 74, 100, 1, 'admin', '2010-01-16 21:20:31', 0, '', '0000-00-00 00:00:00', 1, 0, '226_img3_88db86bf95da076c9d8c710a22700636.jpg', 339, 254),
(227, 188, 5, '', '', '', 0, 0, 0, 2, '12.30_013.jpg', '227_img1_b8f93354604ee6cd93dff23100d1ccdf.jpg', 412, 550, '227_img2_87926b53e6d8d1e2b4144401e8e73e7f.jpg', 74, 100, 1, 'admin', '2010-01-16 21:21:13', 0, '', '0000-00-00 00:00:00', 1, 0, '227_img3_14462d01a5beb57770c241f1a69e1f76.jpg', 339, 254),
(228, 188, 6, '', '', '', 0, 0, 0, 2, '301_058.jpg', '228_img1_3c06bf500b1a86373e9c9bd093c6702d.jpg', 412, 550, '228_img2_4609bcc537faf5d7b6dc1dac7b08a39c.jpg', 74, 100, 1, 'admin', '2010-01-16 21:21:58', 0, '', '0000-00-00 00:00:00', 1, 0, '228_img3_4609bcc537faf5d7b6dc1dac7b08a39c.jpg', 339, 254),
(229, 188, 7, '', '', '', 0, 0, 0, 2, '301_018.jpg', '229_img1_509b716ec1b044fec99beee09063ee55.jpg', 412, 550, '229_img2_bba6159d725a590d4f82fe1e7e3ca3f8.jpg', 74, 100, 1, 'admin', '2010-01-16 21:22:41', 0, '', '0000-00-00 00:00:00', 1, 0, '229_img3_f62d7019a8536689121491154361e52e.jpg', 339, 254),
(230, 188, 4, '', '', '', 0, 0, 0, 2, '301_109.jpg', '230_img1_4fbc6f4d29de47d2c1a1edf631e322eb.jpg', 550, 412, '230_img2_aa762dd337703797b82a53ceeb9b87ca.jpg', 133, 100, 1, 'admin', '2010-01-16 21:32:36', 0, '', '0000-00-00 00:00:00', 1, 0, '230_img3_aa762dd337703797b82a53ceeb9b87ca.jpg', 190, 254),
(231, 189, 1, '', '', '', 0, 0, 0, 2, 'b1_002.jpg', '231_img1_361c0596a21807377ef6c589a8df9307.jpg', 412, 550, '231_img2_0e30bb280633bd2aa0ef2fe3e3793094.jpg', 74, 100, 1, 'admin', '2010-01-16 21:39:53', 0, '', '0000-00-00 00:00:00', 1, 0, '231_img3_fd300387b11fecc40d46d74f1db3ee19.jpg', 339, 254),
(232, 189, 2, '', '', '', 0, 0, 0, 2, 'b1_005.jpg', '232_img1_018cecc47632a7a7fcb990461b0289d1.jpg', 550, 412, '232_img2_bec1d85efe55ae73dd6a7af2dd744002.jpg', 133, 100, 1, 'admin', '2010-01-16 21:40:11', 0, '', '0000-00-00 00:00:00', 1, 0, '232_img3_18d36479fda8a2a5861ef2ac2f9a17cd.jpg', 190, 254),
(233, 189, 3, '', '', '', 0, 0, 0, 2, 'b1_031.jpg', '233_img1_2b2d182aef7dd13eae35004e2e8d625a.jpg', 550, 412, '233_img2_e64a806492c74bfe0d5d284f5fbce692.jpg', 133, 100, 1, 'admin', '2010-01-16 21:40:37', 0, '', '0000-00-00 00:00:00', 1, 0, '233_img3_e64a806492c74bfe0d5d284f5fbce692.jpg', 190, 254),
(234, 189, 4, '', '', '', 0, 0, 0, 2, 'b1_019.jpg', '234_img1_2c8a0ddb58b87750024aed47c62675a9.jpg', 412, 550, '234_img2_a7b62c2ae59abd0cb5f4668f74fdb4bf.jpg', 74, 100, 1, 'admin', '2010-01-16 21:44:20', 0, '', '0000-00-00 00:00:00', 1, 0, '234_img3_a7b62c2ae59abd0cb5f4668f74fdb4bf.jpg', 339, 254),
(235, 191, 1, '', '', '', 0, 0, 0, 2, 'zegary_159.jpg', '235_img1_00b4aeaa1df51789fe9d0a0b18a1bf08.jpg', 550, 412, '235_img2_b3ec3b53f31b4b7801d8ccca86dc3fd5.jpg', 133, 100, 1, 'admin', '2010-01-17 08:50:08', 0, '', '0000-00-00 00:00:00', 1, 0, '235_img3_b3ec3b53f31b4b7801d8ccca86dc3fd5.jpg', 190, 254),
(236, 191, 2, '', '', '', 0, 0, 0, 2, 'zegary_167.jpg', '236_img1_783f960cef32be0216764ca7ed2c8131.jpg', 412, 550, '236_img2_f99f7af92f105b9899d13b8517767aa3.jpg', 74, 100, 1, 'admin', '2010-01-17 08:51:01', 0, '', '0000-00-00 00:00:00', 1, 0, '236_img3_f99f7af92f105b9899d13b8517767aa3.jpg', 339, 254),
(237, 191, 3, '', '', '', 0, 0, 0, 2, 'zegary_171.jpg', '237_img1_520e64f5ba43ac2fbc26ece7a4fed0ec.jpg', 412, 550, '237_img2_f25657fc6885da9f3da5c691c493623d.jpg', 74, 100, 1, 'admin', '2010-01-17 08:51:27', 0, '', '0000-00-00 00:00:00', 1, 0, '237_img3_f25657fc6885da9f3da5c691c493623d.jpg', 339, 254),
(238, 191, 4, '', '', '', 0, 0, 0, 2, 'BLAT.jpg', '238_img1_8b30b0fb62cc1ae3cf4eacf06f6f9b80.jpg', 550, 412, '238_img2_8d2ae33cf2ca38d2484ceab4e4bc02f8.jpg', 133, 100, 1, 'admin', '2010-01-17 08:56:46', 0, '', '0000-00-00 00:00:00', 1, 0, '238_img3_8d2ae33cf2ca38d2484ceab4e4bc02f8.jpg', 190, 254);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_art_komentarze`
--

CREATE TABLE `antyki_art_komentarze` (
  `id` int(12) UNSIGNED NOT NULL,
  `id_matka` int(12) UNSIGNED NOT NULL DEFAULT '0',
  `id_u` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor` varchar(20) NOT NULL,
  `data` datetime NOT NULL,
  `tresc` text NOT NULL,
  `ip` varchar(15) NOT NULL,
  `host` varchar(60) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_bany`
--

CREATE TABLE `antyki_bany` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_typ` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `opis` varchar(255) NOT NULL DEFAULT '',
  `ip` varchar(30) NOT NULL DEFAULT '',
  `data_start` datetime NOT NULL,
  `data_stop` datetime NOT NULL,
  `rodzaj` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_forum_d`
--

CREATE TABLE `antyki_forum_d` (
  `id` smallint(4) UNSIGNED NOT NULL,
  `nr` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `nazwa` varchar(250) NOT NULL DEFAULT '',
  `opis` text NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_forum_p`
--

CREATE TABLE `antyki_forum_p` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_t` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `id_autor` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor` varchar(25) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '',
  `host` varchar(60) NOT NULL DEFAULT '',
  `ip` varchar(60) NOT NULL DEFAULT '',
  `tresc` text NOT NULL,
  `data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `img` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(250) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_forum_t`
--

CREATE TABLE `antyki_forum_t` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_d` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `id_autor` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '',
  `temat` varchar(250) NOT NULL DEFAULT '',
  `data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_zal` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `licznik` int(12) UNSIGNED NOT NULL DEFAULT '0',
  `przyklejony` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_guestbook`
--

CREATE TABLE `antyki_guestbook` (
  `id` int(12) UNSIGNED NOT NULL,
  `autor` varchar(20) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '',
  `gg` varchar(15) NOT NULL DEFAULT '',
  `www` varchar(100) NOT NULL DEFAULT '',
  `data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tresc` text NOT NULL,
  `ip` varchar(15) NOT NULL DEFAULT '',
  `host` varchar(60) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_konfig`
--

CREATE TABLE `antyki_konfig` (
  `idtf` varchar(100) NOT NULL,
  `wartosc` text NOT NULL,
  `lang` smallint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `antyki_konfig`
--

INSERT INTO `antyki_konfig` (`idtf`, `wartosc`, `lang`) VALUES
('konfig_tytul', 'JW WEB DEVELOPMENT', 1),
('konfig_tytul_przedrostek', 'JW WEBDEV', 1),
('konfig_description', 'opis tt', 1),
('konfig_keywords', 'cms', 1),
('konfig_kontakt_email', '', 0),
('konfig_chat', '1', 0),
('konfig_kontakt_nadawca', '', 0),
('konfig_lang_default', '1', 0),
('konfig_tytul', '', 2),
('konfig_tytul_przedrostek', '', 2),
('konfig_description', '', 2),
('konfig_keywords', '', 2),
('konfig_tytul', '', 3),
('konfig_tytul_przedrostek', '', 3),
('konfig_description', '', 3),
('konfig_keywords', '', 3),
('tytul', 'CMS - System użtkowników i administracji treścią serwisu WWW', 1),
('tytul_przedrostek', 'Antyki', 1),
('description', '', 1),
('keywords', '', 1),
('kontakt_email', 'antyki_torun@op.pl', 0),
('kontakt_nadawca', '', 0),
('chat', '1', 0),
('lang_default', '', 0),
('nazwa_www', 'Antyki Toruń', 1),
('kontakt_smtp_host', '', 0),
('kontakt_smtp_user', '', 0),
('kontakt_smtp_haslo', '', 0),
('kodstat', '', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_logi`
--

CREATE TABLE `antyki_logi` (
  `id` int(12) UNSIGNED NOT NULL,
  `id_u` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `login` varchar(30) NOT NULL DEFAULT '',
  `opis` varchar(255) NOT NULL DEFAULT '',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `host` varchar(60) NOT NULL DEFAULT '',
  `kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `idtf` varchar(20) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `antyki_logi`
--

INSERT INTO `antyki_logi` (`id`, `id_u`, `login`, `opis`, `ip`, `host`, `kiedy`, `idtf`) VALUES
(4495, 1, 'admin', 'Wylogowanie', '86.111.98.108', 'host-86-111-98-108.tvk.torun.pl', '2011-04-12 20:53:41', 'wylog'),
(4494, 1, 'admin', 'poprawne zalogowanie', '86.111.98.108', 'host-86-111-98-108.tvk.torun.pl', '2011-04-12 20:53:32', 'log'),
(4490, 1, 'admin', 'poprawne zalogowanie', '86.111.98.108', 'host-86-111-98-108.tvk.torun.pl', '2011-04-12 20:51:22', 'log'),
(4491, 1, 'admin', 'edycja konta - admin', '86.111.98.108', 'host-86-111-98-108.tvk.torun.pl', '2011-04-12 20:51:59', ''),
(4492, 1, 'admin', 'Wylogowanie', '86.111.98.108', 'host-86-111-98-108.tvk.torun.pl', '2011-04-12 20:52:03', 'wylog'),
(4493, 0, '', 'Wylogowanie', '86.111.98.108', 'host-86-111-98-108.tvk.torun.pl', '2011-04-12 20:52:12', 'wylog'),
(4496, 1, 'admin', 'poprawne zalogowanie', '86.111.98.108', 'host-86-111-98-108.tvk.torun.pl', '2011-04-13 18:21:00', 'log'),
(4497, 1, 'admin', 'konfiguracja - zmiana danych', '86.111.98.108', 'host-86-111-98-108.tvk.torun.pl', '2011-04-13 18:21:35', ''),
(4498, 1, 'admin', 'Wylogowanie', '86.111.98.108', 'host-86-111-98-108.tvk.torun.pl', '2011-04-13 18:22:18', 'wylog'),
(4499, 1, 'admin', 'poprawne zalogowanie', '86.111.98.108', 'host-86-111-98-108.tvk.torun.pl', '2011-04-13 19:55:08', 'log'),
(4500, 1, 'admin', 'Wylogowanie', '86.111.98.108', 'host-86-111-98-108.tvk.torun.pl', '2011-04-13 20:04:35', 'wylog');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_poczta`
--

CREATE TABLE `antyki_poczta` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_autor` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `autor` varchar(150) NOT NULL,
  `id_odb` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `odb` varchar(150) NOT NULL,
  `tytul` varchar(200) NOT NULL DEFAULT '',
  `tresc` text NOT NULL,
  `data_wys` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_odczyt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_odp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_usuniecia` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `id_wys` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_odp` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `systemowa` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `wykonana` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `typ` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_rotator`
--

CREATE TABLE `antyki_rotator` (
  `id` int(12) UNSIGNED NOT NULL,
  `id_typ` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link` text NOT NULL,
  `tytul` varchar(250) NOT NULL,
  `opis` text NOT NULL,
  `priorytet` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `udzial` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `licznik` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `licznik_limit` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `czy_licznik` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `klik` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `klik_limit` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `czy_klik` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `data_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa` varchar(200) NOT NULL,
  `img_nazwa_oryginal` varchar(200) NOT NULL,
  `img_w` smallint(4) NOT NULL DEFAULT '0',
  `img_h` smallint(4) NOT NULL DEFAULT '0',
  `swf_wersja` smallint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_tlo` varchar(6) NOT NULL DEFAULT '',
  `img_link` varchar(250) NOT NULL DEFAULT '',
  `link_okno` varchar(50) NOT NULL DEFAULT '',
  `lang` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_sklep_kat`
--

CREATE TABLE `antyki_sklep_kat` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_d` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_pierwszy` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `poziom` int(5) NOT NULL,
  `nr_poz` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `tytul` varchar(200) NOT NULL DEFAULT '',
  `tytul_menu` varchar(200) NOT NULL,
  `podtytul` text NOT NULL,
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(200) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(11) UNSIGNED NOT NULL,
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(11) NOT NULL,
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `licznik` mediumint(7) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `lang` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `menu_wyr` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `idtf_link` varchar(100) NOT NULL,
  `description` varchar(250) NOT NULL,
  `keywords` varchar(250) NOT NULL,
  `title` varchar(200) NOT NULL,
  `typ` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_sklep_producenci`
--

CREATE TABLE `antyki_sklep_producenci` (
  `id` int(10) UNSIGNED NOT NULL,
  `nazwa` varchar(250) NOT NULL DEFAULT '',
  `opis` text NOT NULL,
  `link` varchar(250) NOT NULL,
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(200) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(11) UNSIGNED NOT NULL,
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(11) NOT NULL,
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `lang` smallint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_sklep_produkty`
--

CREATE TABLE `antyki_sklep_produkty` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_kat` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_producent` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `symbol` varchar(100) NOT NULL,
  `nazwa` varchar(250) NOT NULL,
  `nazwa_menu` varchar(250) NOT NULL,
  `zajawka` text NOT NULL,
  `opis` text NOT NULL,
  `link` varchar(250) NOT NULL,
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(200) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img3_w` smallint(4) NOT NULL DEFAULT '0',
  `img3_h` smallint(4) NOT NULL DEFAULT '0',
  `img3_nazwa` varchar(200) NOT NULL,
  `autor_id` int(11) UNSIGNED NOT NULL,
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(11) NOT NULL,
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `licznik` mediumint(7) UNSIGNED NOT NULL DEFAULT '0',
  `licznik_sprzedane` mediumint(7) NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `lang` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `idtf_link` varchar(100) NOT NULL,
  `description` varchar(250) NOT NULL,
  `keywords` varchar(250) NOT NULL,
  `title` varchar(200) NOT NULL,
  `priorytet` smallint(2) NOT NULL DEFAULT '0',
  `wyr` tinyint(1) NOT NULL DEFAULT '0',
  `wyr_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wyr_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nowosc` tinyint(4) NOT NULL DEFAULT '0',
  `nowosc_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nowosc_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `promocja` tinyint(4) NOT NULL DEFAULT '0',
  `promocja_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `promocja_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wyprzedaz` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `wyprzedaz_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wyprzedaz_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `polecamy` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `polecamy_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `polecamy_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cena` float(10,2) NOT NULL DEFAULT '0.00',
  `vat` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `cena_skreslona` float(10,2) NOT NULL DEFAULT '0.00',
  `cena_promo` float(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `glosy` int(8) NOT NULL,
  `glosy_suma` int(11) NOT NULL,
  `glosy_srednia` float(8,2) NOT NULL,
  `waga` float(8,2) NOT NULL DEFAULT '0.00',
  `dostepnosc` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `dostepnosc_sztuk` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_sklep_zamowienia`
--

CREATE TABLE `antyki_sklep_zamowienia` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_u` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `klient_nazwa` varchar(200) NOT NULL,
  `zam_data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `zam_kwota` float(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `zam_waga` float(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `przesylka_kwota` float(6,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `przesylka_typ` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `status_data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `platnosc_typ` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `platnosc_status` smallint(4) UNSIGNED NOT NULL,
  `platnosc_kod` varchar(200) NOT NULL,
  `platnosc_error` varchar(20) NOT NULL,
  `platnosc_kwota` float(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `platnosc_data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `uwagi_klient` text NOT NULL,
  `uwagi_tylko_admin` text NOT NULL,
  `uwagi_admin_klient` text NOT NULL,
  `autor_id` int(11) UNSIGNED NOT NULL,
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(11) NOT NULL,
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `faktura` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `email` varchar(60) NOT NULL,
  `telefon` varchar(50) NOT NULL,
  `imie` varchar(100) NOT NULL,
  `nazwisko` varchar(100) NOT NULL,
  `miejscowosc` varchar(100) NOT NULL,
  `kod_pocztowy` varchar(10) NOT NULL,
  `ulica` varchar(150) NOT NULL,
  `nr_domu` varchar(10) NOT NULL,
  `nr_mieszkania` varchar(10) NOT NULL,
  `firma_nazwa` varchar(200) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `wysylka_miejscowosc` varchar(100) NOT NULL,
  `wysylka_kod_pocztowy` varchar(10) NOT NULL,
  `wysylka_ulica` varchar(150) NOT NULL,
  `wysylka_nr_domu` varchar(10) NOT NULL,
  `wysylka_nr_mieszkania` varchar(10) NOT NULL,
  `faktura_nr` varchar(100) NOT NULL,
  `faktura_data` date NOT NULL DEFAULT '0000-00-00',
  `przesylka_nr` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_sklep_zamowienia_produkty`
--

CREATE TABLE `antyki_sklep_zamowienia_produkty` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_zam` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_produkt` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_wersja` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `nazwa` varchar(250) NOT NULL,
  `cena` float(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `vat` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `ilosc` int(7) UNSIGNED NOT NULL DEFAULT '0',
  `id_kolor` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_rozmiar` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_subskrypcja`
--

CREATE TABLE `antyki_subskrypcja` (
  `id` int(10) UNSIGNED NOT NULL,
  `idtf` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `email` varchar(150) NOT NULL,
  `data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(15) NOT NULL,
  `zalogowanie` varchar(32) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_subskrypcja_pliki`
--

CREATE TABLE `antyki_subskrypcja_pliki` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_matka` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `nazwa` varchar(200) NOT NULL,
  `nazwa_oryginal` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_subskrypcja_wiadomosci`
--

CREATE TABLE `antyki_subskrypcja_wiadomosci` (
  `id` int(10) UNSIGNED NOT NULL,
  `data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tytul` varchar(200) NOT NULL DEFAULT '',
  `tresc` text NOT NULL,
  `licznik` mediumint(7) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_uzytkownicy`
--

CREATE TABLE `antyki_uzytkownicy` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(30) NOT NULL DEFAULT '',
  `haslo` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '',
  `imie` varchar(100) NOT NULL,
  `nazwisko` varchar(100) NOT NULL,
  `nazwa` varchar(200) NOT NULL,
  `ur_rok` mediumint(4) UNSIGNED NOT NULL DEFAULT '0',
  `ur_mc` smallint(2) UNSIGNED NOT NULL DEFAULT '0',
  `ur_dzien` smallint(2) UNSIGNED NOT NULL DEFAULT '0',
  `plec` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `miejscowosc` varchar(100) NOT NULL DEFAULT '',
  `kod_pocztowy` varchar(10) NOT NULL,
  `ulica` varchar(150) NOT NULL,
  `nr_domu` varchar(10) NOT NULL,
  `nr_mieszkania` varchar(10) NOT NULL,
  `woj` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `firma` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `firma_nazwa` varchar(200) NOT NULL,
  `firma_miejscowosc` varchar(100) NOT NULL,
  `firma_kod_pocztowy` varchar(10) NOT NULL,
  `firma_ulica` varchar(150) NOT NULL,
  `firma_nr_domu` varchar(10) NOT NULL,
  `firma_nr_mieszkania` varchar(10) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `gg` varchar(15) NOT NULL DEFAULT '',
  `skype` varchar(150) NOT NULL,
  `telefon` varchar(50) NOT NULL,
  `www` varchar(100) NOT NULL DEFAULT '',
  `zalogowanie` varchar(32) NOT NULL DEFAULT '',
  `ip_log` varchar(15) NOT NULL DEFAULT '',
  `host_log` varchar(60) NOT NULL DEFAULT '',
  `last_log` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_bad_log` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_operation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_operation_name` varchar(100) NOT NULL,
  `data_haslo` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ile_log` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `uprawnienia` varchar(80) NOT NULL DEFAULT '0000000000000000000000000000000000000000',
  `opis` text NOT NULL,
  `punkty` mediumint(7) NOT NULL DEFAULT '0',
  `glosy_suma` int(8) UNSIGNED NOT NULL DEFAULT '0',
  `glosy_ile` int(6) UNSIGNED NOT NULL DEFAULT '0',
  `glosy_srednia` float(5,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `niewygasa` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT '1',
  `lang2` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `img` smallint(2) UNSIGNED NOT NULL,
  `img_nazwa_oryginal` varchar(200) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img3_nazwa` varchar(200) NOT NULL,
  `img3_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img3_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `typ` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `ile_zdjecia` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `ile_znajomi` int(7) UNSIGNED NOT NULL DEFAULT '0',
  `wys_niepowiadomienia` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `wys_niewyszukiwarka` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `zgoda_osobowe` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `zgoda_regulamin` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `suma_zakupy` float(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `ilosc_zakupy` int(5) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `antyki_uzytkownicy`
--

INSERT INTO `antyki_uzytkownicy` (`id`, `login`, `haslo`, `email`, `imie`, `nazwisko`, `nazwa`, `ur_rok`, `ur_mc`, `ur_dzien`, `plec`, `miejscowosc`, `kod_pocztowy`, `ulica`, `nr_domu`, `nr_mieszkania`, `woj`, `firma`, `firma_nazwa`, `firma_miejscowosc`, `firma_kod_pocztowy`, `firma_ulica`, `firma_nr_domu`, `firma_nr_mieszkania`, `nip`, `gg`, `skype`, `telefon`, `www`, `zalogowanie`, `ip_log`, `host_log`, `last_log`, `last_bad_log`, `last_operation`, `last_operation_name`, `data_haslo`, `ile_log`, `uprawnienia`, `opis`, `punkty`, `glosy_suma`, `glosy_ile`, `glosy_srednia`, `niewygasa`, `status`, `lang2`, `img`, `img_nazwa_oryginal`, `img1_nazwa`, `img1_w`, `img1_h`, `img2_nazwa`, `img2_w`, `img2_h`, `img3_nazwa`, `img3_w`, `img3_h`, `typ`, `ile_zdjecia`, `ile_znajomi`, `wys_niepowiadomienia`, `wys_niewyszukiwarka`, `autor_id`, `autor_name`, `autor_kiedy`, `edytor_id`, `edytor_name`, `edytor_kiedy`, `zgoda_osobowe`, `zgoda_regulamin`, `suma_zakupy`, `ilosc_zakupy`) VALUES
(1, 'admin', '33d55641ce40996d6603df2e020e26aa', 'antyki_torun@op.pl', 'waldemar', 'jonik', 'JW Web Development', 1979, 1, 9, 1, 'Stary Torun', '87-134', 'Toruńska', '3', '1', 2, 0, '', '', '', '', '', '', '', '6776675', 'waldemarjonik', '694600343', 'http://jw-webdev.info', '', '86.111.98.108', 'host-86-111-98-108.tvk.torun.pl', '2011-04-13 19:55:08', '2010-03-01 15:57:20', '2011-04-13 20:04:35', 'u_wylogujadmin', '0000-00-00 00:00:00', 446, '10000000000100000000', 'konto głównego admina', 0, 0, 0, 0.00, 0, 1, 1, 2, 'fot19.jpg', '1_img1_98d4eeef816622184d397ab24649ca48.jpg', 550, 413, '1_img2_17c2dceb294ce0de4eca9dec8660f3c8.jpg', 120, 90, '1_img3_ebe61652343d98378dd8c0445796cdc1.jpg', 90, 90, 1, 0, 1, 0, 0, 0, '', '2008-01-18 11:55:26', 1, 'admin', '2011-04-12 20:51:59', 0, 0, 0.00, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_zablokowani`
--

CREATE TABLE `antyki_zablokowani` (
  `id` int(11) UNSIGNED NOT NULL,
  `nr_poz` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_u` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_gosc` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `data_dodania` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `antyki_znajomi`
--

CREATE TABLE `antyki_znajomi` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_u` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_gosc` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `data_dodania` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_ankieta`
--

CREATE TABLE `arkadia_ankieta` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_typ` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL,
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL,
  `typ` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `data_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tytul` varchar(200) NOT NULL DEFAULT '',
  `tresc` text NOT NULL,
  `last_ip` varchar(15) NOT NULL DEFAULT '',
  `last_glos` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `logowane` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `lang` tinyint(2) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_ankieta_glosy`
--

CREATE TABLE `arkadia_ankieta_glosy` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_u` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_ankieta_list`
--

CREATE TABLE `arkadia_ankieta_list` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `nr_poz` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `glosy` int(6) UNSIGNED NOT NULL DEFAULT '0',
  `tresc` varchar(200) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_art`
--

CREATE TABLE `arkadia_art` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_d` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_pierwszy` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `poziom` int(5) NOT NULL,
  `nr_poz` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `idtf` varchar(100) NOT NULL DEFAULT '',
  `tytul` varchar(200) NOT NULL DEFAULT '',
  `tytul_menu` varchar(200) NOT NULL,
  `podtytul` text NOT NULL,
  `data_wys` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `zajawka` text NOT NULL,
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(200) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img_align` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `link` varchar(250) NOT NULL DEFAULT '',
  `link_okno` varchar(50) NOT NULL,
  `autor_id` int(10) UNSIGNED NOT NULL,
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(10) NOT NULL,
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `licznik` mediumint(7) UNSIGNED NOT NULL DEFAULT '0',
  `typ` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `komentarze` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `lang` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `na_str` int(3) UNSIGNED NOT NULL DEFAULT '0',
  `dostep` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `rss` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `glowny` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `menu_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `menu_wyr` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `submenu` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `submenu_polozenie` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `submenu_wyglad` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `do_gory` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `mapa_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `tytul_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `stopka_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `idtf_link` varchar(100) NOT NULL,
  `art_description` varchar(250) NOT NULL,
  `art_keywords` varchar(250) NOT NULL,
  `art_title` varchar(200) NOT NULL,
  `wytworzyl` varchar(150) NOT NULL,
  `wytworzyl_data` date NOT NULL DEFAULT '0000-00-00',
  `zrodlo_link` varchar(200) NOT NULL,
  `stat_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `arkadia_art`
--

INSERT INTO `arkadia_art` (`id`, `id_d`, `id_matka`, `id_pierwszy`, `poziom`, `nr_poz`, `idtf`, `tytul`, `tytul_menu`, `podtytul`, `data_wys`, `zajawka`, `img`, `img_nazwa_oryginal`, `img1_nazwa`, `img1_w`, `img1_h`, `img2_nazwa`, `img2_w`, `img2_h`, `img_align`, `link`, `link_okno`, `autor_id`, `autor_name`, `autor_kiedy`, `edytor_id`, `edytor_name`, `edytor_kiedy`, `data_start`, `data_stop`, `licznik`, `typ`, `komentarze`, `status`, `lang`, `na_str`, `dostep`, `rss`, `glowny`, `menu_nie`, `menu_wyr`, `submenu`, `submenu_polozenie`, `submenu_wyglad`, `do_gory`, `mapa_nie`, `tytul_nie`, `stopka_nie`, `idtf_link`, `art_description`, `art_keywords`, `art_title`, `wytworzyl`, `wytworzyl_data`, `zrodlo_link`, `stat_nie`) VALUES
(1, 1, 0, 0, 0, 1, '', 'restauracja', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, 'index.php?akcja=art_restauracja', '', 1, 'admin', '2010-03-06 08:13:37', 1, 'admin', '2010-03-06 10:03:27', '2010-03-06 08:13:00', '0000-00-00 00:00:00', 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(2, 1, 0, 0, 0, 2, '', 'menu', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, 'index.php?akcja=art_menu', '', 1, 'admin', '2010-03-06 08:13:44', 1, 'admin', '2010-03-06 16:08:41', '2010-03-06 08:13:00', '0000-00-00 00:00:00', 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(3, 1, 0, 0, 0, 3, 'galeria', 'galeria', '', '', '0000-00-00 00:00:00', '', 2, 'Sala_palacowa_1.jpg', '3_img1_60e2eb73374718028a4f65728fcffd92.jpg', 153, 200, '3_img2_cd021726c7c440b96982408d1e1483a9.jpg', 91, 120, 0, 'index.php?akcja=art_galeria', '', 1, 'admin', '2010-03-06 08:13:49', 1, 'admin', '2010-03-07 21:26:49', '2010-03-06 08:13:00', '0000-00-00 00:00:00', 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(5, 1, 0, 0, 0, 6, '', 'pokoje gościnne', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, 'index.php?akcja=art_pokoje', '', 1, 'admin', '2010-03-06 08:14:11', 1, 'admin', '2010-03-10 13:54:00', '2010-03-06 08:14:00', '0000-00-00 00:00:00', 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(6, 1, 0, 0, 0, 7, '', 'kontakt', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, 'index.php?akcja=art_kontakt', '', 1, 'admin', '2010-03-06 08:14:18', 1, 'admin', '2010-03-06 16:30:13', '2010-03-06 08:14:00', '0000-00-00 00:00:00', 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(7, 1, 1, 1, 1, 1, 'r_left', 'lewa kolumna', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-06 10:02:33', 1, 'admin', '2010-03-07 12:15:38', '2010-03-06 10:02:00', '0000-00-00 00:00:00', 1, 0, 0, 1, 1, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(8, 1, 1, 1, 1, 2, 'r_right', 'prawa kolumna', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-06 10:02:47', 1, 'admin', '2010-03-09 13:19:19', '2010-03-06 10:02:00', '0000-00-00 00:00:00', 0, 0, 0, 1, 1, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(9, 1, 7, 1, 2, 1, '', 'Witamy serdecznie gości', '', '', '0000-00-00 00:00:00', '<p style=\"text-align: justify;\"><span style=\"font-family: Verdana;\">Restauracja &bdquo;Arkadia &rdquo;położona jest w cichej i urokliwej części miasta Radziejów, w woj. kujawsko-pomorskim. Nasze menu stanowi tradycyjną kuchnie staropolską, regionalną oraz kuchnie z różnych stron świata. Poza walorami smakowymi restauracja zaskoczy Państwa iście królewską estetyką podawanych dań i miłą obsługą.</span></p>\r\n<p style=\"text-align: justify;\"><span style=\"font-family: Verdana;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br />\r\n</span></p>', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-06 10:10:40', 1, 'admin', '2010-03-19 15:13:58', '2010-03-06 10:10:00', '0000-00-00 00:00:00', 11079, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(10, 1, 7, 1, 2, 2, '', 'Aktualności', '', '', '0000-00-00 00:00:00', '<p><br />\r\n<span style=\"font-size: 13px;\"><span style=\"font-family: Arial;\">Serdecznie zapraszamy na bal Andrzejkowy dnia 30 listopada, bilet w kwocie 290 złotych od pary- gra zespół Socho-band. <br />\r\n</span></span></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p><span style=\"font-size: 13px\"><span style=\"font-family: Arial\">Przygotowujemy zestawy posiłków&nbsp; dla osób odchudzających się.</span></span><span style=\"font-size: 13px\"><span style=\"font-family: Arial\"><br />\r\n</span></span></p>\r\n<p><span style=\"font-size: 13px\"><span style=\"font-family: Arial\">Serdecznie zapraszamy</span></span></p>\r\n<p><span style=\"font-size: 13px\"><span style=\"font-family: Arial\"><font face=\"\"><br />\r\n</font></span></span></p>\r\n<p><span style=\"font-size: 14px\"><br />\r\n</span></p>\r\n<p>&nbsp;</p>', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-06 10:11:28', 1, 'admin', '2019-10-10 10:12:03', '2010-03-06 10:11:00', '0000-00-00 00:00:00', 14660, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(11, 1, 8, 1, 2, 1, '', 'pokoje', '', '', '0000-00-00 00:00:00', '<p><img alt=\"\" width=\"234\" height=\"106\" src=\"/upload/image/pokoj__do_ramki.jpg\" /></p>', 0, '', '', 0, 0, '', 0, 0, 0, 'http://www.restauracja-arkadia.pl/index.php?akcja=art_pokoje', '', 1, 'admin', '2010-03-06 10:50:32', 1, 'admin', '2012-03-19 15:44:47', '2010-03-06 10:50:00', '0000-00-00 00:00:00', 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(12, 1, 8, 1, 2, 2, '', 'Sale', '', '', '0000-00-00 00:00:00', '<p><img height=\"105\" width=\"238\" src=\"/upload/image/animacja.gif\" alt=\"\" /></p>', 0, '', '', 0, 0, '', 0, 0, 0, 'http://www.restauracja-arkadia.pl/index.php?akcja=art_galeria&id_art=15', '', 1, 'admin', '2010-03-06 10:50:39', 1, 'admin', '2015-06-29 17:14:38', '2010-03-06 10:50:00', '0000-00-00 00:00:00', 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(14, 1, 8, 1, 2, 3, '', 'na zewnątrz', '', '', '0000-00-00 00:00:00', '<p><img alt=\"\" width=\"234\" height=\"106\" src=\"/upload/image/restauracja__do_ramki.jpg\" /></p>', 0, '', '', 0, 0, '', 0, 0, 0, 'http://www.restauracja-arkadia.pl/index.php?akcja=art_galeria&id_art=19', '', 1, 'admin', '2010-03-06 10:50:54', 1, 'admin', '2012-03-19 15:46:26', '2010-03-06 10:50:00', '0000-00-00 00:00:00', 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(15, 1, 3, 3, 1, 1, '', 'Sala pałacowa', '', '', '0000-00-00 00:00:00', '<div class=\"grube\">&nbsp;</div>\r\n<p><span style=\"font-size: 10px;\"><span style=\"font-family: Verdana;\">Mieści ok. 150  osób, scenę dla występującego zespołu. Sala posiada profesjonalne  nagłośnienie i oświetlenie oraz klimatyzację.</span></span></p>', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-06 13:12:07', 1, 'admin', '2017-03-01 19:06:34', '2010-03-06 13:11:00', '0000-00-00 00:00:00', 156, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(16, 1, 3, 3, 1, 3, '', 'Sala kameralna', '', '', '0000-00-00 00:00:00', '<p><strong><br />\r\n</strong><span style=\"font-size: 10px;\"><span style=\"font-family: Verdana;\">Mieści ok. 35  osób, zaprojektowana na potrzeby firm organizujących szkolenia i  prezentacje biznesowe.</span></span></p>\r\n<p>&nbsp;</p>', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-06 13:12:17', 1, 'admin', '2015-06-29 16:00:28', '2010-03-06 13:12:00', '0000-00-00 00:00:00', 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(17, 1, 3, 3, 1, 2, '', 'Sala lustrzana', '', '', '0000-00-00 00:00:00', '<div class=\"grube\"><strong><span style=\"font-family: Verdana;\"><br />\r\n</span></strong></div>\r\n<div style=\"padding-right: 40px; padding-top: 10px;\"><span style=\"font-size: 10px;\"><span style=\"font-family: Verdana;\">Mieści ok. 100  osób, sala posiada profesjonalne nagłośnienie i oświetlenie oraz  klimatyzację. Dodatkowo do dyspozycji gości oddajemy stylowy barek.</span></span></div>', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-06 13:12:44', 1, 'admin', '2017-03-01 19:18:42', '2010-03-06 13:12:00', '0000-00-00 00:00:00', 3, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(18, 1, 3, 3, 1, 4, '', 'Pokoje', '', '', '0000-00-00 00:00:00', '<div class=\"grube\"><strong><span style=\"font-family: Verdana;\"><br />\r\n</span></strong></div>\r\n<div style=\"padding-right: 40px; padding-top: 10px;\"><span style=\"font-size: 10px;\"><span style=\"font-family: Verdana;\">Oferujemy naszym  gościom usługi hotelarskie.Dysponuje pokojami, wszystkie pokoje hotelowe  posiadają własną toaletę i łazienkę oraz są w pełni wyposażone w TV.</span></span></div>', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-06 13:12:49', 1, 'admin', '2010-03-13 16:37:55', '2010-03-06 13:12:00', '0000-00-00 00:00:00', 4, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(19, 1, 3, 3, 1, 5, '', 'Na zewnątrz', '', '', '0000-00-00 00:00:00', '<div class=\"grube\"><strong><span style=\"font-family: Verdana;\"><br />\r\n</span></strong></div>\r\n<div style=\"padding-right: 40px; padding-top: 10px;\"><span style=\"font-size: 10px;\"><span style=\"font-family: Verdana;\">Restauracja  &bdquo;Arkadia &rdquo;położona jest w cichej i urokliwej części miasta Radziejów, w  woj. kujawsko-pomorskim.</span></span></div>', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-06 13:12:57', 1, 'admin', '2015-11-17 07:31:55', '2010-03-06 13:12:00', '0000-00-00 00:00:00', 88, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(20, 1, 2, 2, 1, 1, 'm_left', 'lewa kolumna', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-06 16:09:19', 1, 'admin', '2010-03-06 16:14:21', '2010-03-06 16:09:00', '0000-00-00 00:00:00', 0, 0, 0, 1, 1, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(21, 1, 2, 2, 1, 2, 'm_right', 'prawa kolumna', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-06 16:09:31', 1, 'admin', '2010-03-06 16:29:30', '2010-03-06 16:09:00', '0000-00-00 00:00:00', 0, 0, 0, 1, 1, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(22, 1, 20, 2, 2, 1, '', 'Menu przyjęcia ogólne', '', '', '0000-00-00 00:00:00', '<p><span style=\"font-family: Verdana;\"><b>Obiad</b></span></p>\r\n<ul style=\"margin-top: 5px;\">\r\n    <li><span style=\"font-family: Verdana;\">Rosół z makaronem</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Karkówka ze śliwką w sosie własnym lub rolada ze schabu w sosie  pieczarkowym, kluski śląskie</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Filet faszerowany sosem chrzanowym podany na ananasie</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Golonka po bawarsku, kapusta kwaszona gotowana</span></li>\r\n</ul>', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-06 16:12:04', 1, 'admin', '2016-03-06 12:39:26', '2010-03-06 16:11:00', '0000-00-00 00:00:00', 11805, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(23, 1, 20, 2, 2, 2, '', 'Menu  weselne 1', '', '', '0000-00-00 00:00:00', '<p><span style=\"font-family: Verdana;\"><strong>Pierwszy obiad (5 porcji mięsa na 1 osobę)<br />\r\n</strong></span></p>\r\n<ul style=\"margin-top: 5px;\">\r\n    <li><span style=\"font-family: Verdana;\">Rosół z makaronem i zieloną pietruszką</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Rolada z karkówki w sosie własnym , kluski śląskie</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Filet faszerowany sosem chrzanowym podanym na ananasie <br />\r\n    </span></li>\r\n</ul>', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-06 16:12:14', 1, 'admin', '2016-03-06 12:30:23', '2010-03-06 16:12:00', '0000-00-00 00:00:00', 13889, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(24, 1, 21, 2, 2, 1, '', 'Dania główne', 'Dania główne przedstawiamy klika przykładów', '', '0000-00-00 00:00:00', '<p><img height=\"107\" width=\"183\" src=\"/upload/image/menu_przyjecia/menu_przyjecia_do_ramki.jpg\" alt=\"\" /></p>', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-06 16:17:47', 1, 'admin', '2010-03-18 15:33:30', '2010-03-06 16:17:00', '0000-00-00 00:00:00', 15814, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(25, 1, 21, 2, 2, 2, '', 'Przystawki i surówki', '', '', '0000-00-00 00:00:00', '<p><img height=\"107\" width=\"183\" src=\"/upload/image/menu_przystawki_do_ramki.jpg\" alt=\"\" /></p>', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-06 16:17:52', 1, 'admin', '2010-03-18 15:14:16', '2010-03-06 16:17:00', '0000-00-00 00:00:00', 10899, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(26, 1, 21, 2, 2, 3, '', 'Desery i owoce', '', '', '0000-00-00 00:00:00', '<p><img height=\"107\" width=\"183\" src=\"/upload/image/menu_desery_do_ramki.jpg\" alt=\"\" /></p>', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-06 16:17:56', 1, 'admin', '2017-03-01 19:49:40', '2010-03-06 16:17:00', '0000-00-00 00:00:00', 7865, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(27, 1, 6, 6, 1, 1, 'kontakt_left', 'lewa kolumna', '', '', '0000-00-00 00:00:00', '<p style=\"text-align: center;\"><span style=\"font-size: 16px;\"><strong>Restauracja &rdquo;Arkadia&rdquo;<br />\r\nul. Toruńska 36<br />\r\n88-200 Radziejów</strong></span></p>\r\n<p style=\"text-align: center;\">&nbsp;</p>\r\n<p style=\"text-align: center;\"><span style=\"font-size: 13px;\">Telefon: 0-54 285 21 23<br />\r\nWłaściciel:&nbsp;&nbsp;&nbsp; Irena Ucińska od godz. 8:00 do 21:00<br />\r\n&nbsp; Telefon: +48 605 850 596<br />\r\n</span></p>\r\n<p style=\"text-align: center;\"><span style=\"font-size: 13px;\">&nbsp;&nbsp;&nbsp;&nbsp; E-mail:&nbsp;<a href=\"mailto:arkadia36@onet.eu\"><span style=\"color: rgb(0, 0, 255);\"><u>arkadia36@onet.eu</u></span></a></span><br />\r\n<br />\r\n<span style=\"font-size: 14px;\"><u>Godziny otwarcia :</u></span></p>\r\n<p style=\"text-align: center;\"><br />\r\nSala Kameralna -&nbsp; Pon-Niedz od&nbsp; godziny 12:00 do 21:00<br />\r\nSala Lustrzana -&nbsp;&nbsp; na życzenia klienta <br />\r\nSala Pałacowa -&nbsp;&nbsp; na życzenie klienta</p>', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-06 16:33:07', 1, 'admin', '2010-03-18 15:00:46', '2010-03-06 16:33:00', '0000-00-00 00:00:00', 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(28, 1, 6, 6, 1, 2, 'kontakt_right', 'prawa kolumna', '', '', '0000-00-00 00:00:00', '<p><iframe scrolling=\"no\" height=\"360\" frameborder=\"0\" width=\"450\" src=\"http://mapy.google.pl/maps?f=q&amp;source=s_q&amp;hl=pl&amp;geocode=&amp;q=Arkadia&amp;sll=52.626017,18.526951&amp;sspn=0.002296,0.006968&amp;ie=UTF8&amp;split=1&amp;rq=1&amp;ev=zo&amp;radius=0.15&amp;hq=Arkadia&amp;hnear=&amp;ll=52.626492,18.526028&amp;spn=0.002344,0.004828&amp;z=17&amp;output=embed\" marginwidth=\"0\" marginheight=\"0\"></iframe><br />\r\n<small><a style=\"color: rgb(0, 0, 255); text-align: left;\" href=\"http://mapy.google.pl/maps?f=q&amp;source=embed&amp;hl=pl&amp;geocode=&amp;q=Arkadia&amp;sll=52.626017,18.526951&amp;sspn=0.002296,0.006968&amp;ie=UTF8&amp;split=1&amp;rq=1&amp;ev=zo&amp;radius=0.15&amp;hq=Arkadia&amp;hnear=&amp;ll=52.626492,18.526028&amp;spn=0.002344,0.004828&amp;z=17\">Wyświetl większą mapę</a></small></p>', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-06 16:33:20', 1, 'admin', '2010-03-16 07:30:04', '2010-03-06 16:33:00', '0000-00-00 00:00:00', 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(30, 1, 20, 2, 2, 3, '', 'Menu weselne 2', '', '', '0000-00-00 00:00:00', '<p><span style=\"font-family: Verdana;\"><b>Zupy</b></span></p>\r\n<ul style=\"margin-top: 5px;\">\r\n    <li><span style=\"font-family: Verdana;\">Krem z borowików     </span>\r\n    <ul style=\"padding-top: 5px;\">\r\n        <li><span style=\"font-family: Verdana;\">kalafiora</span></li>\r\n        <li><span style=\"font-family: Verdana;\">brokuł</span></li>\r\n    </ul>\r\n    </li>\r\n    <li><span style=\"font-family: Verdana;\">Krem cytrynowy</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Zupa gulaszowa</span></li>\r\n</ul>', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-07 12:32:56', 1, 'admin', '2010-09-06 17:02:03', '2010-03-07 12:32:00', '0000-00-00 00:00:00', 8839, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(42, 1, 0, 0, 0, 5, 'oferta_oferta', 'oferta', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, 'index.php?akcja=art_oferta', '', 1, 'admin', '2010-03-07 21:34:52', 1, 'admin', '2010-03-10 13:52:24', '2010-03-07 21:34:00', '0000-00-00 00:00:00', 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 1, 0, '', '', '', '', '', '0000-00-00', '', 0),
(48, 1, 42, 42, 1, 1, 'o_left', 'lewa kolumna', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-08 18:07:34', 1, 'admin', '2010-03-13 08:54:22', '2010-03-08 18:07:00', '0000-00-00 00:00:00', 0, 0, 0, 1, 1, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(53, 1, 5, 5, 1, 1, 'p_left', 'lewa kolumna', '', '', '0000-00-00 00:00:00', '<p>asdasdfasdasdasdasdasdas</p>', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-09 21:55:41', 1, 'admin', '2010-03-10 13:54:29', '2010-03-09 21:55:00', '0000-00-00 00:00:00', 0, 0, 0, 1, 1, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, 1, 1, 0, '', '', '', '', '', '0000-00-00', '', 0),
(54, 1, 42, 42, 1, 2, 'o_right', 'prawa kolumna', '', '', '0000-00-00 00:00:00', '<p><img height=\"221\" width=\"332\" src=\"/upload/image/sale/sala_palacowa_1.jpg\" alt=\"\" /></p>\r\n<p><img height=\"221\" width=\"333\" vspace=\"20\" src=\"/upload/image/sale/sala_lustrzana_2.jpg\" alt=\"\" />&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-10 13:52:12', 1, 'admin', '2010-03-13 17:27:47', '2010-03-10 13:52:00', '0000-00-00 00:00:00', 0, 0, 0, 1, 1, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(55, 1, 5, 5, 1, 2, 'p_right', 'prawa kolumna', '', '', '0000-00-00 00:00:00', '<p>&nbsp;</p>\r\n<p><img hspace=\"5\" height=\"233\" align=\"left\" width=\"155\" src=\"/upload/image/zdjecia_pokoje/pok_nr2_1osobowy.jpg\" alt=\"\" /><img hspace=\"5\" height=\"234\" align=\"left\" width=\"155\" src=\"/upload/image/zdjecia_pokoje/pok_nr1_2osobowy.jpg\" alt=\"\" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img hspace=\"5\" height=\"234\" align=\"left\" width=\"155\" src=\"/upload/image/zdjecia_pokoje/pok_nr1_lazienka.jpg\" alt=\"\" /></p>\r\n<p>&nbsp;</p>\r\n<p><br />\r\n&nbsp;&nbsp;&nbsp;</p>\r\n<p><br />\r\n&nbsp;&nbsp;</p>', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-10 13:53:43', 1, 'admin', '2010-03-13 17:29:41', '2010-03-10 13:53:00', '0000-00-00 00:00:00', 0, 0, 0, 1, 1, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, 1, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(56, 1, 48, 42, 2, 1, '', 'Oferta Restauracji \"Arkadia\"', '', '', '0000-00-00 00:00:00', '<p>&nbsp;</p>\r\n<div class=\"lewa_tresc\">\r\n<div class=\"lewa_tresc\">\r\n<div class=\"tekst\"><span style=\"font-family: Verdana;\">Zapraszamy do Restauracji &bdquo; Arkadia&rdquo; gdzie spędzą Państwo wyjątkowe  chwile w gronie swoich najbliższych, przyjaciół, znajomych oraz  współpracowników.  </span></div>\r\n<ul>\r\n    <li><span style=\"font-family: Verdana;\">Śniadania, obiady, kolacje podawane są w &bdquo;Sali Kameralnej&rdquo;  codziennie.</span></li>\r\n    <li><strong><span style=\"font-family: Verdana;\">Imprezy okolicznościowe:</span></strong><span style=\"font-family: Verdana;\"> chrzciny, komunie, wesela, uroczystości  rodzinne, bankiety, konferencje, szkolenia, prezentacje i wiele innych  imprez są organizowane w trzech klimatyzownych salach, w   zależności od  ilości osób lub upodobań klienta <br />\r\n    <br />\r\n    <b>Do dyspozycji klientów oddajemy: </b> <br />\r\n    <br />\r\n    <b>&bdquo;Salę Pałacową&rdquo;</b>    mieści ona ok. 150 osób, scenę dla występującego zespołu. Sala posiada  profesjonalne  nagłośnienie i oświetlenie oraz  klimatyzację . 	 </span><span style=\"font-family: Verdana;\"><br />\r\n    <b>&bdquo;Salę Lustrzaną&rdquo;</b>    	mieści ona ok. 100 osób, sala posiada profesjonalne  nagłośnienie i  oświetlenie oraz  klimatyzację. Dodatkowo do dyspozycji gości oddajemy  stylowy barek.</span><span style=\"font-family: Verdana;\"><br />\r\n    <b>&bdquo;Salę Kameralną&rdquo;</b> 	 mieści ona ok. 35 osób, zaprojektowania na potrzeby firm  organizujących szkolenia i prezentacje biznesowe.</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Catering :  świadczymy usługi z dowozem na wskazane adres z pełną  obsługa gastronomiczną </span></li>\r\n</ul>\r\n<div class=\"tekst\" style=\"font-style: italic; padding-bottom: 20px;\"><span style=\"font-family: Verdana;\"> Dołożymy wszelkich starań, aby wizyta w naszej restauracji dzięki miłej  obsłudze i dobrej kuchni na długo pozostała w Państwa pamięci.  </span></div>\r\n<h1><span style=\"font-family: Verdana;\">Serdecznie Zapraszamy</span></h1>\r\n</div>\r\n</div>', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-10 13:55:51', 1, 'admin', '2010-03-13 17:05:49', '2010-03-10 13:55:00', '0000-00-00 00:00:00', 5403, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(58, 1, 53, 5, 2, 1, '', 'Pokoje gościnne', '', '', '0000-00-00 00:00:00', '<p><span style=\"font-size: 10px;\"><span style=\"font-family: Verdana;\">Poza prowadzeniem restauracji oferujemy Naszym gościom usługi noclegowe.</span></span></p>\r\n<p><span style=\"font-size: 10px;\"><span style=\"font-family: Verdana;\">Dysponujemy 15 pokojami 4,2 i 1 osobowymi.</span></span></p>\r\n<p><span style=\"font-size: 10px;\"><span style=\"font-family: Verdana;\">Każdy pokój wyposażony jest w:</span></span></p>\r\n<ul>\r\n    <li><span style=\"font-size: 10px;\"><span style=\"font-family: Verdana;\">łazienkę</span></span></li>\r\n    <li><span style=\"font-size: 10px;\"><span style=\"font-family: Verdana;\">toaletę <br />\r\n    </span></span></li>\r\n    <li><span style=\"font-size: 10px;\"><span style=\"font-family: Verdana;\">TV</span></span></li>\r\n    <li><span style=\"font-size: 10px;\"><span style=\"font-family: Verdana;\">internet.</span></span></li>\r\n</ul>\r\n<p><span style=\"font-size: 10px;\"><span style=\"font-family: Verdana;\">Pokoje noclegowe znajdują się w budynku restauracji, co umożliwia gościom przebywającym w restauracji do późnych godzin nocnych do korzystania z noclegu. Goście przyjezdni mają udostępniony nocleg 24 godziny na dobę z możliwością spożycia posiłku i parkowania samochodu przy restauracji hotelu.</span></span></p>\r\n<p>&nbsp;</p>\r\n<p><span style=\"font-size: 10px;\"><span style=\"font-family: Verdana;\">Więcej zdjęć można zobaczyć w zakładce Galeria - Pokoje. Zapraszamy</span></span></p>', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-10 14:08:54', 1, 'admin', '2010-03-20 10:45:39', '2010-03-10 14:08:00', '0000-00-00 00:00:00', 11051, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(61, 1, 20, 2, 2, 4, '', 'Menu dań', '', '', '0000-00-00 00:00:00', '<table cellspacing=\"1\" cellpadding=\"1\" border=\"0\" style=\"width: 238px;\">\r\n    <tbody>\r\n        <tr>\r\n            <td width=\"85\">1. Sernik -</td>\r\n            <td width=\"143\">Szt. 1 - 75,00 zł</td>\r\n        </tr>\r\n        <tr>\r\n            <td width=\"85\">2. Pijawiec -</td>\r\n            <td width=\"143\">Szt. 1 - 65,00 zł</td>\r\n        </tr>\r\n        <tr>\r\n            <td width=\"85\">3. Pychotka -</td>\r\n            <td width=\"143\">Szt. 1  - 65,00 zł</td>\r\n        </tr>\r\n        <tr>\r\n            <td width=\"85\">4.  Delicje -</td>\r\n            <td width=\"143\">Szt. 1  - 65,00 zł</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<p>&nbsp;</p>', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-12 16:00:22', 1, 'admin', '2010-03-19 16:45:57', '2010-03-12 16:00:00', '0000-00-00 00:00:00', 19395, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(62, 1, 20, 2, 2, 5, '', 'Menu na Andrzejki', '', '', '0000-00-00 00:00:00', '<p><span style=\"font-family: Verdana;\"><b>Pierwsze podanie</b></span></p>\r\n<ul style=\"margin-top: 5px;\">\r\n    <li><span style=\"font-family: Verdana;\">Flaki</span></li>\r\n    <li><span style=\"font-family: Verdana;\">cielęcina w sosie borowikowym, kluski śląskie</span></li>\r\n    <li><span style=\"font-family: Verdana;\">rolada ze schabu faszerowana</span></li>\r\n    <li><span style=\"font-family: Verdana;\">sznycel drobiowy</span></li>\r\n</ul>', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-12 16:02:13', 1, 'admin', '2010-03-12 16:32:49', '2010-03-12 16:01:00', '0000-00-00 00:00:00', 8157, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(63, 1, 20, 2, 2, 6, '', 'Menu na Bal Sylwestrowy', '', '', '0000-00-00 00:00:00', '<p><span style=\"font-family: Verdana;\"><b>Pierwsze podanie</b></span></p>\r\n<ul style=\"margin-top: 5px;\">\r\n    <li><span style=\"font-family: Verdana;\">Rosół a\'la Arkadia</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Schab pieczony w sosie własnym, kluski śląskie</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Filet z sandacza soute w sosie koperkowym</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Cielęcina duszona w sosie borowikowym</span></li>\r\n</ul>', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-12 16:03:48', 1, 'admin', '2010-03-12 16:33:38', '2010-03-12 16:03:00', '0000-00-00 00:00:00', 8994, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(64, 1, 20, 2, 2, 7, '', 'Menu pogrzegowe', '', '', '0000-00-00 00:00:00', '<p><span style=\"font-family: Verdana;\"><b>Zestaw 1</b></span></p>\r\n<ul style=\"margin-top: 5px;\">\r\n    <li><span style=\"font-family: Verdana;\">Rosół z makaronem z zieloną pietruszką</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Schab panierowany</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Ziemniaki puree z koperkiem</span></li>\r\n</ul>', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-12 16:05:13', 1, 'admin', '2016-03-06 12:40:57', '2010-03-12 16:04:00', '0000-00-00 00:00:00', 6991, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_artd`
--

CREATE TABLE `arkadia_artd` (
  `id` int(10) UNSIGNED NOT NULL,
  `akcja` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `akcja_data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `akcja_autor` varchar(150) NOT NULL,
  `akcja_autor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_art` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_d` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_pierwszy` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `poziom` int(5) NOT NULL,
  `nr_poz` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `idtf` varchar(100) NOT NULL DEFAULT '',
  `tytul` varchar(200) NOT NULL DEFAULT '',
  `tytul_menu` varchar(200) NOT NULL,
  `podtytul` text NOT NULL,
  `data_wys` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `zajawka` text NOT NULL,
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(200) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img_align` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `link` varchar(250) NOT NULL DEFAULT '',
  `link_okno` varchar(50) NOT NULL,
  `autor_id` int(10) UNSIGNED NOT NULL,
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(10) NOT NULL,
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `licznik` mediumint(7) UNSIGNED NOT NULL DEFAULT '0',
  `typ` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `komentarze` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `lang` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `na_str` int(3) UNSIGNED NOT NULL DEFAULT '0',
  `dostep` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `rss` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `glowny` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `menu_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `menu_wyr` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `submenu` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `submenu_polozenie` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `submenu_wyglad` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `do_gory` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `mapa_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `tytul_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `stopka_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `idtf_link` varchar(100) NOT NULL,
  `art_description` varchar(250) NOT NULL,
  `art_keywords` varchar(250) NOT NULL,
  `art_title` varchar(200) NOT NULL,
  `wytworzyl` varchar(150) NOT NULL,
  `wytworzyl_data` date NOT NULL DEFAULT '0000-00-00',
  `zrodlo_link` varchar(200) NOT NULL,
  `stat_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_art_akapity`
--

CREATE TABLE `arkadia_art_akapity` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `nr_poz` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `tytul` varchar(250) NOT NULL,
  `tresc` longtext NOT NULL,
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(250) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img_align` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `img_opis` varchar(200) NOT NULL DEFAULT '',
  `img_link` varchar(250) NOT NULL DEFAULT '',
  `img_link_okno` varchar(50) NOT NULL DEFAULT '',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL,
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL,
  `typ` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `ramka` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `ramka_kolor` varchar(6) NOT NULL,
  `tlo_kolor` varchar(6) NOT NULL,
  `dlugosc` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `padding` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_wiersz` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_kolumna` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_typ` smallint(2) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_zalezne` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_m_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_m_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_skala` smallint(2) UNSIGNED NOT NULL DEFAULT '0',
  `blokada` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `data_blokada` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `arkadia_art_akapity`
--

INSERT INTO `arkadia_art_akapity` (`id`, `id_matka`, `nr_poz`, `tytul`, `tresc`, `img`, `img_nazwa_oryginal`, `img1_nazwa`, `img1_w`, `img1_h`, `img2_nazwa`, `img2_w`, `img2_h`, `img_align`, `img_opis`, `img_link`, `img_link_okno`, `autor_id`, `autor_name`, `autor_kiedy`, `edytor_id`, `edytor_name`, `edytor_kiedy`, `typ`, `ramka`, `ramka_kolor`, `tlo_kolor`, `dlugosc`, `padding`, `galeria_wiersz`, `galeria_kolumna`, `galeria_typ`, `galeria_zalezne`, `galeria_m_w`, `galeria_m_h`, `galeria_skala`, `blokada`, `data_blokada`, `status`) VALUES
(3, 7, 1, 'Nowości', '', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-07 12:15:38', 0, '', '0000-00-00 00:00:00', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(4, 30, 1, 'Propozycja dań uzupełniających', '<p><b>Zupy</b></p>\r\n<ul>\r\n    <li>Krem z borowików\r\n    <ul style=\"padding-top: 5px;\">\r\n        <li>kalafiora</li>\r\n        <li>brokuł</li>\r\n    </ul>\r\n    </li>\r\n    <li>Krem cytrynowy</li>\r\n    <li>Zupa gulaszowa</li>\r\n    <li>Boeuf strogonow</li>\r\n    <li>Pilaw</li>\r\n</ul>\r\n<p><b>Dania gorące</b></p>\r\n<ul>\r\n    <li>Cielęcina w sosie borowikowym</li>\r\n    <li>Filet z sandacza w sosie ogórkowym lub z szyjek rakowych</li>\r\n    <li>Indyk pieczony</li>\r\n    <li>Klopsiki mielone faszerowane pieczarkami</li>\r\n    <li>Kaczka faszerowana pieczona po staropolsku</li>\r\n    <li>Krokiety faszerowane kapustą i grzybami</li>\r\n    <li>Omlet staropolski</li>\r\n    <li>Polędwica wieprzowa w żurawinach</li>\r\n    <li>Polędwica wołowa smażona, podana z cebulą i jabłkiem</li>\r\n    <li>Roladki drobiowe faszerowane łososiem</li>\r\n    <li>Schab pieczony z porami</li>\r\n    <li>Schab faszerowany smażony w cieście naleśnikowym</li>\r\n    <li>Udziec z dzika w sosie żurawinowym</li>\r\n    <li>Udko kacze pieczone</li>\r\n    <li>Udziec wieprzowy</li>\r\n    <li>Kurczak po śródziemnomorsku</li>\r\n    <li>Udka na ostro</li>\r\n</ul>\r\n<p><b>Dania zimne </b></p>\r\n<ul>\r\n    <li>Jaja przepiórcze z kawiorem</li>\r\n    <li>Karp po szlachecku</li>\r\n    <li>Pstrąg faszerowany w galarecie</li>\r\n    <li>Roladki z łososia wędzone z ananasem</li>\r\n    <li>Ryba po chińsku</li>\r\n    <li>Sałatka z szyjek rakowych</li>\r\n    <li>Sandacz smażony w pestkach dyni z kapustą włoską</li>\r\n    <li>Szczupak w galarecie</li>\r\n    <li>Śledź po tatarsku</li>\r\n    <li>Tatar z łososia</li>\r\n    <li>Węgorz wędzony podany z łososiem</li>\r\n    <li>Roladki z łososia faszerowane szparagami w galarecie</li>\r\n    <li>Jesiotr wędzony</li>\r\n    <li>Polędwica wieprzowa faszerowana szpinakiem w galarecie</li>\r\n    <li>Śledź po tatarsku</li>\r\n</ul>\r\n<p>&nbsp;</p>\r\n<h1 style=\"text-align: center;\">Jadłospis może być modyfikowany na  życzenie Klienta<br />\r\n<br />\r\nSerdecznie zapraszamy</h1>', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-07 12:34:35', 1, 'admin', '2010-09-06 17:02:03', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(5, 23, 1, '', '<h1 style=\"text-align: center;\"><span style=\"font-family: Verdana;\">Propozycja jadłospisu na przyjęcie  weselne</span></h1>\r\n<p><span style=\"font-family: Verdana;\"> <b>Pierwszy Obiad (5 porcji mięsa na 1 osobę)</b> </span></p>\r\n<ul>\r\n    <li><span style=\"font-family: Verdana;\">Rosół z makaronem i zieloną pietruszką</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Rolada z karkówki w sosie własnym , kluski śląskie</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Filet faszerowany sosem chrzanowym podanym na ananasie i po śródziemnomorsku, bukiet warzyw gotowanych <br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Filet z indyka zapiekany z serem mozzarella <br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Schab panierowany, kotlet mielony, pieczarki<br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Policzki wieprzowe duszone w piwie miodowym, kapusta modra gotowana</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Polędwica wieprzowa&nbsp; w cieście francuskim w sosie kurkowym</span></li>\r\n    <li><span style=\"font-family: Verdana;\">mieszki ze schabu, faszerowane sosem serowym\\ </span></li>\r\n    <li><span style=\"font-family: Verdana;\">yuki ułańskie w sosie podgrzybkowym podane z pyzą gotowaną na parze </span><span style=\"font-family: Verdana;\"><br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Ziemniaki</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Surówki : z białej kapusty , z marchwi ,z  czerwonej kapusty,</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Sałatka wiosenna , fantazyjna, jarzyna gotowana <br />\r\n    </span></li>\r\n</ul>\r\n<p><span style=\"font-family: Verdana;\"> <b>Zakąski</b> </span></p>\r\n<ul>\r\n    <li><span style=\"font-family: Verdana;\">Ryba w galarecie, roladki łososiowe w galarecie, rolada z łososia wędzonego w sosie bzyliowym <br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Tatar wołowy</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Schab, indyk, polędwica w galarecie <br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Ryba wędzona</span></li>\r\n    <p>&nbsp;</p>\r\n    <p><span style=\"font-family: Verdana;\"><b><i>&nbsp;udziec wieprzowy pieczony, sos chrzanowy, ogórki kwaszone,&nbsp; pierogi z kapustą i grzybami <br />\r\n    </i></b></span></p>\r\n</ul>\r\n<p><span style=\"font-family: Verdana;\"> <b>Drugi Obiad ( 3 porcje mięsa na jedną osobę)</b> </span></p>\r\n<ul>\r\n    <li><span style=\"font-family: Verdana;\">Barszcz czerwony</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Kotlet devolay , frytki</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Polędwica po parmeńsku podana z groszkiem zielonym <br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Kaczka faszerowana, pieczona po staropolsku <br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Rolada ze schabu z orzechami laskowymi w sosie borowikowym <br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Golonka po bawarsku, kapusta kwaszona gotowana</span></li>\r\n</ul>\r\n<p><span style=\"font-family: Verdana;\"> <b>Duży Obiad (2,5 porcji mięsa na osobę)&nbsp;</b> </span></p>\r\n<ul>\r\n    <li><span style=\"font-family: Verdana;\">Flaki z pieczywem</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Filet z indyka panierowany w migdałach lub pieczeń wieprzowa w sosie własnym <br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Pierś drobiowa pieczona w boczku, fasolka szparagowa oprószana <br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Karkówka zapiekana z pieczarkami i serem żółtym lub w jarzynach <br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Gulasz wołowy podany w chlebie <br />\r\n    </span></li>\r\n</ul>\r\n<p><span style=\"font-family: Verdana;\"> <b>Nad ranem </b> </span></p>\r\n<ul>\r\n    <li><span style=\"font-family: Verdana;\">Żurek z kiełbasą</span></li>\r\n</ul>\r\n<p><span style=\"font-family: Verdana;\"> <b>Ciasta</b> </span></p>\r\n<ul>\r\n    <li><span style=\"font-family: Verdana;\">Sernik</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Stefanek</span></li>\r\n    <li>Piernikowe </li>\r\n    <li><span style=\"font-family: Verdana;\">Pychotka</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Delicje</span><span style=\"font-family: Verdana;\"><br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Słonecznikowiec</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Snickers</span></li>\r\n    <li>Ciasto Jagodowe </li>\r\n    <li>Filadelfia </li>\r\n    <li>Pani Walewska </li>\r\n    <li><span style=\"font-family: Verdana;\">Pijawiec</span><span style=\"font-family: Verdana;\"><br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Ciastka orkiszowe</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Desery wenecja z owocami</span></li>\r\n</ul>\r\n<p><span style=\"font-family: Verdana;\"> <b>Tort</b>, <b>Lody</b> <br />\r\n</span></p>\r\n<p><span style=\"font-family: Verdana;\"><b>Napoje gorące, kawa i herbata, podawane w czasie uroczystości na życzenie klienta </b></span></p>\r\n<div class=\"tekst\" style=\"text-align: center;\"><span style=\"font-family: Verdana;\">Istnieje możliwość  zabezpieczenia owoców i słodyczy.</span></div>\r\n<p><span style=\"font-family: Verdana;\"> <br />\r\n<br />\r\n</span></p>\r\n<h1 style=\"text-align: center;\"><span style=\"font-family: Verdana;\">Jadłospis może być modyfikowany na  życzenie Klienta<br />\r\n<br />\r\nSerdecznie zapraszamy</span></h1>', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-07 12:39:39', 1, 'admin', '2016-03-06 12:30:23', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(6, 22, 1, '', '<p><span style=\"font-family: Verdana;\"><b>Obiad</b></span></p>\r\n<ul>\r\n    <li><span style=\"font-family: Verdana;\">Rosół z makaronem</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Karkówka w sosie własnym lub rolada ze schabu w sosie  pieczarkowym, kluski śląskie</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Filet faszerowany sosem chrzanowym podany na ananasie lub filet z indyka zapiekany z mozzarellą lub filet faszerowany szpinakiem podany z bukietem warzyw <br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Kaczka pieczona po staropolsku lub udka kacze podane z ziemniakami pieczonymi <br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Schab panierowany lub zapiekany z pieczarkami<br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Mieszki ze schabu faszerowane sosem sorowym<br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Policzki wieprzowe duszone w piwie miodowym, kapusta modra gotowana <br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Polędwica wieprzowa w cieście francuskim w sosie kurkowym lub polędwica po parmeńsku zapiekana z serem <br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Żeberka pieczone bez kości lub sznycel drobiowy, filet panierowany w  płatkach migdałowych</span></li>\r\n    <li><span style=\"font-family: Verdana;\">surówki z kapusty, z marchwi, z czerwonej kapusty, fantazyjna,  ziemniaki</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Kawa , herbata z cytryną</span></li>\r\n</ul>\r\n<p><span style=\"font-family: Verdana;\"> <b>Zakąski</b> </span></p>\r\n<ul>\r\n    <li><span style=\"font-family: Verdana;\">Ryba w galarecie lub roladki łososiowe w galarecie <br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Tatar wołowy</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Ryba wędzona</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Szynka w galarecie lub polędwica faszerowana szpinakiem w galarecie<br />\r\n    </span></li>\r\n</ul>\r\n<p><span style=\"font-family: Verdana;\"> <b>Podwieczorek</b> </span></p>\r\n<ul>\r\n    <li><span style=\"font-family: Verdana;\">Czerwony barszcz do picia</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Kotlet davolay , frytki</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Szaszłyki, ryż na sypko<br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Yuki ułańskie w sosie podgrzybkowym lub pieczeń wieprzowa w sosie borowikowym <br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Karkówka pieczona w jarzynach lub zapiekana z pieczarkami i serem <br />\r\n    </span></li>\r\n</ul>\r\n<p><span style=\"font-family: Verdana;\"> <b>Ciasta</b> </span></p>\r\n<ul>\r\n    <li><span style=\"font-family: Verdana;\">Tort</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Sernik</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Snickers</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Pijawiec</span></li>\r\n    <li>Filadelfia </li>\r\n    <li>Piernikowe </li>\r\n    <li>Ciasto Jagodowe </li>\r\n    <li><span style=\"font-family: Verdana;\">Pychotka</span></li>\r\n    <li><span style=\"font-family: Verdana;\">3 bit</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Delicja</span><span style=\"font-family: Verdana;\"><br />\r\n    </span></li>\r\n</ul>\r\n<p>Tel. kontaktowy: 605 850 596</p>\r\n<p><span style=\"font-family: Verdana;\"> <br />\r\n</span></p>\r\n<h1 style=\"text-align: center;\"><span style=\"font-family: Verdana;\">Jadłospis może być modyfikowany na  życzenie Klienta<br />\r\n<br />\r\nSerdecznie zapraszamy</span></h1>', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-07 12:41:15', 1, 'admin', '2016-03-06 12:39:26', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(7, 27, 1, '', '', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-07 12:59:09', 1, 'admin', '2010-03-07 12:59:40', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(26, 48, 1, '', '', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-08 18:18:12', 1, 'admin', '2010-03-09 21:52:02', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(29, 62, 1, '', '<p><span style=\"font-family: Verdana;\"><b>Pierwsze podanie</b></span></p>\r\n<ul>\r\n    <li><span style=\"font-family: Verdana;\">Flaki</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Cielęcina w sosie borowikowym, kluski śląskie</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Rolada ze schabu faszerowana</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Sznycel drobiowy</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Schab panierowany, słoneczny</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Karkówka po meksykańsku</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Surówki: z białej kapusty, marchwi, czerwonej kapusty, fantazyjna</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Ziemniaki</span></li>\r\n</ul>\r\n<p><span style=\"font-family: Verdana;\"> <b>Zakąski</b> </span></p>\r\n<ul>\r\n    <li><span style=\"font-family: Verdana;\">Tatar wołowy</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Roladki z pstrąga</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Polędwica w sosie chrzanowym</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Śledź po tatarsku</span></li>\r\n</ul>\r\n<p><span style=\"font-family: Verdana;\"> <b>Drugie podanie</b> </span></p>\r\n<ul>\r\n    <li><span style=\"font-family: Verdana;\">czerwony barszcz do picia</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Kotlet davolay , frytki</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Szaszłyki z ryżem</span></li>\r\n    <li><span style=\"font-family: Verdana;\">pieczeń wieprzowa w sosie własnym, kluski półfrancuskie</span></li>\r\n</ul>\r\n<p><span style=\"font-family: Verdana;\"> <b>Ciasto</b> <b>Owoce, napoje zimne, kawa, herbata</b>  <br />\r\n</span></p>\r\n<h1 style=\"text-align: center;\"><span style=\"font-family: Verdana;\">Życzymy Smacznego</span></h1>', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-12 16:03:03', 1, 'admin', '2010-03-12 16:32:49', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(30, 63, 1, '', '<p><span style=\"font-family: Verdana;\"><b>Pierwsze podanie</b></span></p>\r\n<ul>\r\n    <li><span style=\"font-family: Verdana;\">Rosół a\'la Arkadia</span></li>\r\n    <li><span style=\"font-family: Verdana;\">schab pieczony w sosie własnym, kluski śląskie</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Filet z sandacza soute w sosie koperkowym</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Cielęcina duszona w sosie borowikowym</span></li>\r\n    <li><span style=\"font-family: Verdana;\">sznycel drobiowy</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Wołowina duszona w volewantach</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Zestaw surówek, ziemniaki</span></li>\r\n</ul>\r\n<p><span style=\"font-family: Verdana;\"> <b>Zakąski</b> </span></p>\r\n<ul>\r\n    <li><span style=\"font-family: Verdana;\">Ryba wędzona</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Łosoś wędzony, kawior, jaja przepiórcze</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Pstrąg faszerowany szparagami</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Tatar wołowy</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Udziec pieczony w sosie żurawinowym</span></li>\r\n</ul>\r\n<p><span style=\"font-family: Verdana;\"> <b>Drugie podanie</b> </span></p>\r\n<ul>\r\n    <li><span style=\"font-family: Verdana;\">Golonka  po bawarsku,, kapusta kwaszona gotowana</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Polędwica wieprzowa po staropolsku</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Kotlet devolay, frytki</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Czerwony barszcz</span></li>\r\n</ul>\r\n<p><span style=\"font-family: Verdana;\"> <b>Trzecie podanie</b> </span></p>\r\n<ul>\r\n    <li><span style=\"font-family: Verdana;\">Flaki wołowe z pieczywem</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Karkówka w jarzynach, sos czosnkowy</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Filet w migdałach</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Sztuka mięsa duszona z morelą</span></li>\r\n</ul>\r\n<p><span style=\"font-family: Verdana;\"> <b>Ciasto, owoce, soki, herbata, kawa, szampan </b>  <br />\r\n</span></p>\r\n<h1 style=\"text-align: center;\"><span style=\"font-family: Verdana;\">Życzymy Smacznego</span></h1>', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-12 16:04:42', 1, 'admin', '2010-03-12 16:33:38', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(31, 64, 1, '', '<p><span style=\"font-family: Verdana;\"><b>Zestaw 1</b></span></p>\r\n<ul style=\"padding-left: 100px;\">\r\n    <li><span style=\"font-family: Verdana;\">Rosół z makaronem z zieloną pietruszką</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Schab panierowany lub kotlet devolay <br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Ziemniaki puree z koperkiem</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Surówka z marchwi , kapusta gotowana,</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Ciasto , kawa , herbata z cytryną</span></li>\r\n</ul>\r\n<p><span style=\"font-family: Verdana;\"> <b>Zestaw 2</b> </span></p>\r\n<ul style=\"padding-left: 100px;\">\r\n    <li><span style=\"font-family: Verdana;\">Rosół z makaronem z zieloną pietruszką</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Schab panierowany z pieczarkami</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Pieczeń rzymska , karkówka pieczona, kluski śląskie<br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Sznycel drobiowy zapiekany z serem, kotlet devolay</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Ziemniaki puree z koperkiem</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Surówka z marchwi i z białej kapusty</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Jarzyna gotowana</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Ciasto , kawa , herbata z cytryn</span></li>\r\n</ul>\r\n<p><span style=\"font-family: Verdana;\"> <b>Zestaw 3</b> </span></p>\r\n<ul style=\"padding-left: 100px;\">\r\n    <li><span style=\"font-family: Verdana;\">Rosół z makaronem z zieloną pietruszką</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Schab panierowany z pieczarkami</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Udka pieczone , kotlet mielony lub pieczeń rzymska</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Żeberka pieczone</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Karkówka faszerowana w sosie pieczarkowym, kluski śląskie <br />\r\n    </span></li>\r\n    <li><span style=\"font-family: Verdana;\">Kotlet devolay z masłem i serem</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Ziemniaki puree z koperkiem</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Surówka z marchwi i z białej kapusty</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Jarzyna gotowana</span></li>\r\n    <li><span style=\"font-family: Verdana;\">Ciasto , kawa , herbata z cytryną</span></li>\r\n</ul>\r\n<p><span style=\"font-family: Verdana;\"> <br />\r\n</span></p>\r\n<h1><span style=\"font-family: Verdana;\">Serdecznie zapraszamy</span></h1>', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-12 16:05:59', 1, 'admin', '2016-03-06 12:40:57', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(33, 16, 1, 'Galeria zdjęć - sala kameralna', '', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-12 20:26:24', 1, 'admin', '2010-03-13 15:27:13', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(34, 17, 1, 'sl', '', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-12 20:28:38', 0, '', '0000-00-00 00:00:00', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(35, 18, 1, 'pokoje galeria', '', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-12 20:35:43', 0, '', '0000-00-00 00:00:00', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(61, 19, 5, '', '', 2, 'zdjecie_nr5.JPG', '61_img1_3453063d3f565c7142a488f847c7a362.jpg', 600, 402, '61_img2_1f56254a54e1337f84e121edb8f7fa7c.jpg', 200, 134, 2, '', '', '', 1, 'admin', '2015-11-17 07:18:58', 0, '', '0000-00-00 00:00:00', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(39, 24, 2, 'Filet z indyka panierowany w płatkach migdałowych', '', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-13 10:07:40', 1, 'admin', '2010-03-18 15:06:44', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(42, 24, 3, 'Karkówka pieczona w sosie własnym, kluski śląskie', '', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-13 10:16:08', 1, 'admin', '2010-03-18 15:03:42', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(43, 9, 1, '', '<p><span style=\"font-size: 12px;\"><span style=\"font-family: Verdana;\">30-letnie doświadczenie Szefowej restauracji w branży gastronomicznej oraz doskonale wykwalifikowana kadra współpracowników sprawia, że nasza restauracja jest w stanie sprostać Państwa oczekiwaniom a może nawet zaskoczyć.Specjalizujemy się w organizowaniu imprez okolicznościowych, spotkań biznesowych i obsłudze cateringowej.</span></span></p>\r\n<p style=\"text-align: justify;\"><span style=\"font-size: 12px;\"><span style=\"font-family: Verdana;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Do dyspozycji oddajemy Państwu 3 klimatyzowane sale a w sezonie letnim zapraszamy do naszego ogródka, gdzie w otoczeniu zieleni będą mogli Państwo odetchnąć świeżym powietrzem. </span></span><span style=\"font-family: Verdana;\"><br />\r\n</span></p>', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-13 13:32:20', 1, 'admin', '2010-03-13 15:25:50', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(46, 26, 1, 'Ciasta', '', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-13 18:43:47', 0, '', '0000-00-00 00:00:00', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(47, 25, 1, 'Pstrąg faszerowany w galarecie', '', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-13 19:57:05', 1, 'admin', '2010-03-18 15:08:38', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(48, 25, 3, 'Szynka faszerowana w galarecie', '', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-14 08:28:41', 1, 'admin', '2010-03-18 15:14:16', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(49, 25, 4, 'Surówki', '', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-14 20:06:32', 0, '', '0000-00-00 00:00:00', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(50, 24, 4, 'Roladki ze schabu faszerowane, panierowane w ziarnach sezamu', '', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-14 20:08:37', 1, 'admin', '2010-03-18 15:04:21', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(51, 24, 5, 'Kotlet devolay, frytki', '', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-14 20:10:40', 1, 'admin', '2010-03-18 15:33:30', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(52, 58, 1, '', '<p>\r\n<meta http-equiv=\"CONTENT-TYPE\" content=\"text/html; charset=utf-8\">\r\n<title></title>\r\n<meta name=\"GENERATOR\" content=\"OpenOffice.org 2.4  (Win32)\"><style type=\"text/css\">\r\n	<!--\r\n		@page { size: 21cm 29.7cm; margin: 2cm }\r\n		P { margin-bottom: 0.21cm }\r\n	-->\r\n	</style> </meta>\r\n</meta>\r\n</p>\r\n<p style=\"margin-bottom: 0cm;\"><span style=\"font-family: Verdana;\">Oferujemy naszym gościom usługi hotelarskie.Dysponuje pokojami, które wyposażone są w toaletę, łazienkę, internet i TV.</span></p>\r\n<p style=\"margin-bottom: 0cm;\">&nbsp;</p>', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-18 14:34:52', 1, 'admin', '2010-03-19 15:22:13', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(53, 25, 2, 'Roladki z łososia faszerowane szparagami', '', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-18 15:09:53', 0, '', '0000-00-00 00:00:00', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(54, 24, 1, 'Przedstawiamy klika przykładów', '', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-18 15:32:00', 0, '', '0000-00-00 00:00:00', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1);
INSERT INTO `arkadia_art_akapity` (`id`, `id_matka`, `nr_poz`, `tytul`, `tresc`, `img`, `img_nazwa_oryginal`, `img1_nazwa`, `img1_w`, `img1_h`, `img2_nazwa`, `img2_w`, `img2_h`, `img_align`, `img_opis`, `img_link`, `img_link_okno`, `autor_id`, `autor_name`, `autor_kiedy`, `edytor_id`, `edytor_name`, `edytor_kiedy`, `typ`, `ramka`, `ramka_kolor`, `tlo_kolor`, `dlugosc`, `padding`, `galeria_wiersz`, `galeria_kolumna`, `galeria_typ`, `galeria_zalezne`, `galeria_m_w`, `galeria_m_h`, `galeria_skala`, `blokada`, `data_blokada`, `status`) VALUES
(55, 61, 1, '', '<p>\r\n<meta content=\"text/html; charset=utf-8\" http-equiv=\"Content-Type\">\r\n<meta content=\"Word.Document\" name=\"ProgId\">\r\n<meta content=\"Microsoft Word 11\" name=\"Generator\">\r\n<meta content=\"Microsoft Word 11\" name=\"Originator\">\r\n<link href=\"file:///C:\\DOCUME~1\\Waran\\USTAWI~1\\Temp\\msohtml1\\01\\clip_filelist.xml\" rel=\"File-List\" /><o:smarttagtype name=\"metricconverter\" namespaceuri=\"urn:schemas-microsoft-com:office:smarttags\"></o:smarttagtype><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\"><!--[if gte mso 9]><xml>\r\n<w:WordDocument>\r\n<w:View>Normal</w:View>\r\n<w:Zoom>0</w:Zoom>\r\n<w:HyphenationZone>21</w:HyphenationZone>\r\n<w:PunctuationKerning />\r\n<w:ValidateAgainstSchemas />\r\n<w:SaveIfXMLInvalid>false</w:SaveIfXMLInvalid>\r\n<w:IgnoreMixedContent>false</w:IgnoreMixedContent>\r\n<w:AlwaysShowPlaceholderText>false</w:AlwaysShowPlaceholderText>\r\n<w:Compatibility>\r\n<w:BreakWrappedTables />\r\n<w:SnapToGridInCell />\r\n<w:WrapTextWithPunct />\r\n<w:UseAsianBreakRules />\r\n<w:DontGrowAutofit />\r\n</w:Compatibility>\r\n<w:BrowserLevel>MicrosoftInternetExplorer4</w:BrowserLevel>\r\n</w:WordDocument>\r\n</xml><![endif]--><!--[if gte mso 9]><xml>\r\n<w:LatentStyles DefLockedState=\"false\" LatentStyleCount=\"156\">\r\n</w:LatentStyles>\r\n</xml><![endif]--><!--[if !mso]><object\r\nclassid=\"clsid:38481807-CA0E-42D2-BF39-B33AF135CC4D\" id=ieooui></object>\r\n<style>\r\nst1\\:*{behavior:url(#ieooui) }\r\n</style>\r\n<![endif]--></span></span><style type=\"text/css\"></style><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\"><!--[if gte mso 10]>\r\n<style>\r\n/* Style Definitions */\r\ntable.MsoNormalTable\r\n{mso-style-name:Standardowy;\r\nmso-tstyle-rowband-size:0;\r\nmso-tstyle-colband-size:0;\r\nmso-style-noshow:yes;\r\nmso-style-parent:\"\";\r\nmso-padding-alt:0cm 5.4pt 0cm 5.4pt;\r\nmso-para-margin:0cm;\r\nmso-para-margin-bottom:.0001pt;\r\nmso-pagination:widow-orphan;\r\nfont-size:10.0pt;\r\nfont-family:\"Times New Roman\";\r\nmso-ansi-language:#0400;\r\nmso-fareast-language:#0400;\r\nmso-bidi-language:#0400;}\r\n</style>\r\n<![endif]-->  </span></span>     </meta>\r\n</meta>\r\n</meta>\r\n</meta>\r\n</p>\r\n<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" width=\"721\" style=\"width: 432.8pt; margin-left: 2.7pt; border-collapse: collapse;\" class=\"MsoNormalTable\">\r\n    <tbody>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">1. Sernik - </span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt. 1 - 75,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">2. Pijawiec -</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt. 1 - 65,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">3. Pychotka- </span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt.1&nbsp; -   65,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">4.   &nbsp;Delicje - </span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt.1&nbsp; -   65,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">5. Makowiec drożdżowy - </span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt. 1 - 10,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">6. Wenus lub Biała Dama- </span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt. 1 - 65,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">7. Stefanek- </span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt. 1 - 65,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">8. Snikers - </span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt. 1 - 65,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">9. Devolay - </span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt. 1 -&nbsp;&nbsp;   5,10 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">10. Filet faszerowany -</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt. 1 -&nbsp;&nbsp;   5,30 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">11. Rolada ze schabu w sosie pieczarkowym -&nbsp; </span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt. 1 -&nbsp;&nbsp;   6,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">12. Karkówka pieczona - </span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt. 1 -&nbsp;&nbsp;   5,30 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">13. Karkówka w jarzynach -</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt. 1 - &nbsp;&nbsp;5,50 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">14. Golonka po bawarsku -</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt. 1 -&nbsp;&nbsp;   7,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">15. Schab zapiekany z pieczarkami -</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt. 1 -&nbsp;&nbsp;   6,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">16. Sznycel drobiowy -</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt. 1 -&nbsp;&nbsp;   4,50 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">17. Schab faszerowany, panierowany w sezamie -</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt. 1 -&nbsp;&nbsp;   5,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">18. Faworki z indyka - </span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt. 1 - &nbsp;&nbsp;4,50 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">19.Zrazy wieprzowe - </span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt. 1 -&nbsp;&nbsp;   4,50 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">20. Karkówka po meksykańsku -</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt. 1 -&nbsp;&nbsp;   5,50 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">21. Szaszłyki -</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt. 1 -&nbsp;&nbsp;   5,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">22. Roladki z pstrąga w galarecie -</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt. 1 -&nbsp;&nbsp;   5,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">23. Pstrąg faszerowany w galarecie -</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt. 1 -&nbsp;   15,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">24. Pstrąg w galarecie - </span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt. 1 -&nbsp;   12,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">25. Karp w galarecie - </span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt. 1 -&nbsp;   50,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">26. Sandacz w galarecie </span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><st1:metricconverter w:st=\"on\" productid=\"2 kg\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">2 kg</span></span></st1:metricconverter><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\"> - </span></span><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">Szt. 1 -&nbsp;   65,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">27. Pierogi z kapustą i grzybami -</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">1 porcja - 6,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">28. Śledź po kaszubsku -</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">1 porcja - 3,50 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">29. Karp po żydowsku -</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">1 porcja - 5,50 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">30. Ryba po japońsku -</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">1 porcja - 4,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">31. Sałatka z szynki -</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">1 porcja - 2,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">32. Sałatka jarzynowa -</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">1 porcja - 1,59 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">33. Kaczka faszerowana - </span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">1 szt.&nbsp;&nbsp; -   75,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">34. Cielęcina w sosie borowikowym -</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">1 porcja&nbsp;   -7,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">35. Sandacz w sosie ogórkowym -</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">1 porcja&nbsp;   -7,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">36. Dorsz w sosie ogórkowym -</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">1 porcja&nbsp;   -5,50 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">37. Krokiet z kapustą i grzybami -</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">1 szt.&nbsp;&nbsp;&nbsp;&nbsp;   - 2,50 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">38. Czerwony barszcz z suszonymi grzybami -</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><st1:metricconverter w:st=\"on\" productid=\"1 litr\"></st1:metricconverter><span style=\"font-family: Verdana;\"><st1:metricconverter w:st=\"on\" productid=\"1 litr\"><span style=\"font-size: 11px;\">1    litr</span></st1:metricconverter><span style=\"font-size: 11px;\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   - 6,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">39. Paszteciki z kapustą i grzybami -</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><st1:metricconverter w:st=\"on\" productid=\"1 kg\"></st1:metricconverter><span style=\"font-family: Verdana;\"><st1:metricconverter w:st=\"on\" productid=\"1 kg\"><span style=\"font-size: 11px;\">1 kg</span></st1:metricconverter><span style=\"font-size: 11px;\">.&nbsp;&nbsp;&nbsp; - 25,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n        <tr style=\"height: 13.2pt;\">\r\n            <td nowrap=\"\" width=\"275\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">40. Makowiec na kruchym spodzie -</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n            <td nowrap=\"\" width=\"425\" valign=\"bottom\" style=\"padding: 0cm 3.5pt; height: 13.2pt;\">\r\n            <p class=\"MsoNormal\"><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">1 szt.&nbsp;&nbsp;&nbsp; -   65,00 zł</span></span><span style=\"font-size: 10pt; font-family: Verdana;\"><o:p></o:p></span></p>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n<p class=\"MsoNormal\"><o:p><span style=\"font-family: Verdana;\"><span style=\"font-size: 11px;\">&nbsp;</span></span></o:p></p>', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-19 08:48:01', 1, 'admin', '2010-03-19 12:55:14', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(58, 10, 1, '', '', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2013-10-28 20:09:28', 1, 'admin', '2013-10-28 20:15:23', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(60, 12, 1, '', '', 2, '1.JPG', '60_img1_c902710d1b9f77d6d3d123d6698d016d.jpg', 600, 400, '60_img2_1d2e830ed496357f20719a0b636fdf34.jpg', 200, 133, 2, '', '', '', 1, 'admin', '2015-06-29 17:14:36', 0, '', '0000-00-00 00:00:00', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(62, 19, 4, '', '', 2, 'zdjecie_numer_2.JPG', '62_img1_5de9add5ebd1ca0dd49b6e386d4371ad.jpg', 600, 402, '62_img2_b3af9056906861e0484800488343fb08.jpg', 200, 134, 2, '', '', '', 1, 'admin', '2015-11-17 07:19:52', 0, '', '0000-00-00 00:00:00', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(63, 19, 3, '', '', 2, 'zdjecie_nr1.JPG', '63_img1_947dd35f2e56af18823ef9eec0cea746.jpg', 600, 402, '63_img2_07ccf76db73caf1e8a575e742bf73626.jpg', 200, 134, 2, '', '', '', 1, 'admin', '2015-11-17 07:21:45', 0, '', '0000-00-00 00:00:00', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(64, 19, 2, '', '', 2, 'zdjecie_nr4.JPG', '64_img1_9a1c6d0177e98268b039ac49abb5bd06.jpg', 600, 402, '64_img2_acdd321176528843c5de49083ce0eddf.jpg', 200, 134, 2, '', '', '', 1, 'admin', '2015-11-17 07:22:30', 0, '', '0000-00-00 00:00:00', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(65, 19, 6, '', '', 2, 'zdjecie_numer3.JPG', '65_img1_49e4a73dab78d287d63d28e103e0befb.jpg', 600, 402, '65_img2_553b237556fbb15d8fdfe551a0610719.jpg', 200, 134, 2, '', '', '', 1, 'admin', '2015-11-17 07:23:09', 0, '', '0000-00-00 00:00:00', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(69, 15, 2, 'al', '', 2, 'palacowa1.jpg', '69_img1_ecb47f0871dde35622cafb2c0a767c24.jpg', 600, 337, '69_img2_85a88657c7a51ed04063eec1dcd6513e.jpg', 200, 112, 2, '', '', '', 1, 'admin', '2017-03-01 19:01:48', 1, 'admin', '2017-03-01 19:02:28', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_art_akapityd`
--

CREATE TABLE `arkadia_art_akapityd` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_artd` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_akapit` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `nr_poz` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `tytul` varchar(250) NOT NULL,
  `tresc` longtext NOT NULL,
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(250) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img_align` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `img_opis` varchar(200) NOT NULL DEFAULT '',
  `img_link` varchar(250) NOT NULL DEFAULT '',
  `img_link_okno` varchar(50) NOT NULL DEFAULT '',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL,
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL,
  `typ` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `ramka` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `ramka_kolor` varchar(6) NOT NULL,
  `tlo_kolor` varchar(6) NOT NULL,
  `dlugosc` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `padding` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_wiersz` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_kolumna` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_typ` smallint(2) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_zalezne` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_m_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_m_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_skala` smallint(2) UNSIGNED NOT NULL DEFAULT '0',
  `blokada` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `data_blokada` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_art_dziennik`
--

CREATE TABLE `arkadia_art_dziennik` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_u` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_art` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor` varchar(150) NOT NULL,
  `opis` varchar(255) NOT NULL DEFAULT '',
  `data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_art_galeria`
--

CREATE TABLE `arkadia_art_galeria` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `nr_poz` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `tytul` varchar(250) NOT NULL,
  `opis` text NOT NULL,
  `autor_zdjecia` varchar(250) NOT NULL,
  `licznik` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `punkty_ilosc` int(8) UNSIGNED NOT NULL DEFAULT '0',
  `punkty_suma` int(8) UNSIGNED NOT NULL DEFAULT '0',
  `punkty_srednia` float(5,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(250) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL,
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `obrobka` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `arkadia_art_galeria`
--

INSERT INTO `arkadia_art_galeria` (`id`, `id_matka`, `nr_poz`, `tytul`, `opis`, `autor_zdjecia`, `licznik`, `punkty_ilosc`, `punkty_suma`, `punkty_srednia`, `img`, `img_nazwa_oryginal`, `img1_nazwa`, `img1_w`, `img1_h`, `img2_nazwa`, `img2_w`, `img2_h`, `autor_id`, `autor_name`, `autor_kiedy`, `edytor_id`, `edytor_name`, `edytor_kiedy`, `status`, `obrobka`) VALUES
(36, 35, 5, '', '', '', 0, 0, 0, 0.00, 2, 'pok_n1.jpg', '36_img1_9a3989e3b6446069b40149f42af736d1.jpg', 550, 365, '36_img2_adab39d7367e5ab104d5855e668b120f.jpg', 80, 53, 1, 'admin', '2010-03-13 16:35:52', 0, '', '0000-00-00 00:00:00', 1, 0),
(113, 34, 4, '', '', '', 0, 0, 0, 0.00, 2, 'lustrzana3.jpg', '113_img1_2060e7f0b332704845c8760ca5c635cd.jpg', 550, 309, '113_img2_d095028ea40c356690efc04b00d2b64f.jpg', 80, 44, 1, 'admin', '2017-03-01 19:15:15', 0, '', '0000-00-00 00:00:00', 1, 0),
(114, 34, 7, '', '', '', 0, 0, 0, 0.00, 2, 'lustrzana4.jpg', '114_img1_2486b072d36d652004e6664e1cb8642e.jpg', 550, 309, '114_img2_81c0a6bebc6555b48eb03fbfae9a93fe.jpg', 80, 44, 1, 'admin', '2017-03-01 19:16:23', 0, '', '0000-00-00 00:00:00', 1, 0),
(110, 69, 7, '', '', '', 0, 0, 0, 0.00, 2, '10.jpg', '110_img1_e73faaa4c68cb98fe970473ff888fd52.jpg', 550, 366, '110_img2_ba862c04c90f2fce41d6553f7fd59d0e.jpg', 80, 53, 1, 'admin', '2017-03-01 19:06:34', 0, '', '0000-00-00 00:00:00', 1, 0),
(91, 33, 1, '', '', '', 0, 0, 0, 0.00, 2, '2.JPG', '91_img1_2e69b3b8951315d8e5225373be3ad8b0.jpg', 550, 366, '91_img2_0e12f4e68bd5df643133470a1c564305.jpg', 80, 53, 1, 'admin', '2015-06-29 15:58:19', 0, '', '0000-00-00 00:00:00', 1, 0),
(89, 33, 2, '', '', '', 0, 0, 0, 0.00, 2, '1.JPG', '89_img1_b66fdc3e7922857ff9f895174e46995b.jpg', 550, 366, '89_img2_4cbebb823ae6f2f72b2673dd48cbbce5.jpg', 80, 53, 1, 'admin', '2015-06-29 15:53:27', 0, '', '0000-00-00 00:00:00', 1, 0),
(97, 34, 11, '', '', '', 0, 0, 0, 0.00, 2, 'zdjecia_5.JPG', '97_img1_ccb47d6e8a70abe48d0f64a9a45af03b.jpg', 550, 367, '97_img2_0f49a59b922206f0873149425aed7b9a.jpg', 80, 53, 1, 'admin', '2015-08-30 09:33:21', 0, '', '0000-00-00 00:00:00', 1, 0),
(101, 64, 4, '', '', '', 0, 0, 0, 0.00, 2, 'zdjecie_nr1.JPG', '101_img1_42b56d55dcb72ef62284accf37dda682.jpg', 550, 369, '101_img2_e976d848df35a35c0b2e50daa7c979b9.jpg', 80, 53, 1, 'admin', '2015-11-17 07:30:43', 0, '', '0000-00-00 00:00:00', 1, 0),
(16, 35, 1, '', '', '', 0, 0, 0, 0.00, 2, 'p2.jpg', '16_img1_0ed299a1442fda6af475adaa90b1c679.jpg', 450, 299, '16_img2_d77a8407eeae414568424b0f3a27be0e.jpg', 80, 53, 1, 'admin', '2010-03-12 20:43:18', 1, 'admin', '2010-03-12 20:55:35', 1, 0),
(17, 35, 3, '', '', '', 0, 0, 0, 0.00, 2, 'p1.jpg', '17_img1_2d5b1e2d9223541b55782668f7b6607c.jpg', 450, 299, '17_img2_573c1de2e63ebbc89af1a958b937acad.jpg', 80, 53, 1, 'admin', '2010-03-12 20:43:46', 1, 'admin', '2010-03-12 20:58:51', 1, 0),
(18, 35, 4, '', '', '', 0, 0, 0, 0.00, 2, 'p3.jpg', '18_img1_8eaf8e62e00987d4ec50d542be89d0f6.jpg', 450, 299, '18_img2_0baea70160ff0f19706e5ed09128d5e1.jpg', 80, 53, 1, 'admin', '2010-03-12 20:44:11', 1, 'admin', '2010-03-12 21:00:11', 1, 0),
(100, 64, 2, '', '', '', 0, 0, 0, 0.00, 2, 'zdjecie_numer_2.JPG', '100_img1_b06a3589104036151067fc166fc07208.jpg', 550, 369, '100_img2_d531f0f238f5138703a43152a5502465.jpg', 80, 53, 1, 'admin', '2015-11-17 07:29:29', 0, '', '0000-00-00 00:00:00', 1, 0),
(99, 64, 3, '', '', '', 0, 0, 0, 0.00, 2, 'zdjecie_nr5.JPG', '99_img1_d488939255e888cd4bab7a03c5510bcb.jpg', 550, 369, '99_img2_0ff784a8601813262559315140e840a7.jpg', 80, 53, 1, 'admin', '2015-11-17 07:28:48', 0, '', '0000-00-00 00:00:00', 1, 0),
(24, 39, 1, '', '', '', 0, 0, 0, 0.00, 2, 'schab_brzoskwinie.jpg', '24_img1_72db5c39f13eaa6ea7c692026cbf66c1.jpg', 550, 365, '24_img2_b83d179afbbb9bf84a4e3c81f60bb9d7.jpg', 80, 53, 1, 'admin', '2010-03-13 10:13:21', 0, '', '0000-00-00 00:00:00', 1, 0),
(25, 39, 2, '', '', '', 0, 0, 0, 0.00, 2, 'schab_brzoskwinie_01.jpg', '25_img1_24aef59b2238e7f5d27c9e74d8b21d3a.jpg', 550, 365, '25_img2_7c11830aff50843d2ff8ebdf09d8c7a1.jpg', 80, 53, 1, 'admin', '2010-03-13 10:13:58', 1, 'admin', '2010-03-14 08:56:37', 1, 0),
(26, 42, 1, '', '', '', 0, 0, 0, 0.00, 2, 'kluski_slaskie_01.jpg', '26_img1_c527f0bb2018e6d49826c209f539f88b.jpg', 550, 365, '26_img2_4afd6780138507763bef5bf52dae02aa.jpg', 80, 53, 1, 'admin', '2010-03-13 10:16:45', 1, 'admin', '2010-03-14 08:25:47', 1, 0),
(28, 39, 3, '', '', '', 0, 0, 0, 0.00, 2, 'DSC_0016ab.jpg', '28_img1_cc3a0a567c6f767afe67b691be026b94.jpg', 550, 366, '28_img2_f598045bfc6dffd912ed6c11fa52b88a.jpg', 80, 53, 1, 'admin', '2010-03-13 11:03:28', 0, '', '0000-00-00 00:00:00', 1, 0),
(95, 34, 10, '', '', '', 0, 0, 0, 0.00, 2, 'zdjecia_3.JPG', '95_img1_88ae917393ac421d8175d39379c79ada.jpg', 550, 367, '95_img2_d7b840d713476694c3bf955d99f70253.jpg', 80, 53, 1, 'admin', '2015-08-30 09:28:35', 0, '', '0000-00-00 00:00:00', 1, 0),
(111, 34, 1, '', '', '', 0, 0, 0, 0.00, 2, 'lustrzana1.jpg', '111_img1_b007e4b2f5f496054526683dbadcb6b1.jpg', 550, 309, '111_img2_f4d11110e040115a3ae70d70245e375c.jpg', 80, 44, 1, 'admin', '2017-03-01 19:07:30', 0, '', '0000-00-00 00:00:00', 1, 0),
(39, 35, 8, '', '', '', 0, 0, 0, 0.00, 2, 'pok_n4.jpg', '39_img1_0c1fc5d443099ca9a23943f47063bfef.jpg', 549, 365, '39_img2_45ecb4f250e21be131803d968a04a0cd.jpg', 80, 53, 1, 'admin', '2010-03-13 16:37:30', 0, '', '0000-00-00 00:00:00', 1, 0),
(40, 35, 9, '', '', '', 0, 0, 0, 0.00, 2, 'pok_n5.jpg', '40_img1_1d67871e238ae1024ac0d00336317ae2.jpg', 549, 365, '40_img2_177fe5679cc70c79b3d7dbdefc7e3fe6.jpg', 80, 53, 1, 'admin', '2010-03-13 16:37:55', 0, '', '0000-00-00 00:00:00', 1, 0),
(42, 46, 1, '', '', '', 0, 0, 0, 0.00, 2, 'dester_1.jpg', '42_img1_b94b5f505ba454c1941c861ea82989df.jpg', 550, 366, '42_img2_3855c4178e42b89ed5c1db6ecbeae74b.jpg', 80, 53, 1, 'admin', '2010-03-13 18:44:14', 0, '', '0000-00-00 00:00:00', 1, 0),
(43, 46, 3, '', '', '', 0, 0, 0, 0.00, 2, 'dester_2.jpg', '43_img1_d310dfefb8546fc8d3e96e3bdd169c04.jpg', 550, 366, '43_img2_9d0efcf677423f37d96ed4103b7655dd.jpg', 80, 53, 1, 'admin', '2010-03-13 18:44:36', 0, '', '0000-00-00 00:00:00', 1, 0),
(44, 46, 4, '', '', '', 0, 0, 0, 0.00, 2, 'dester_3.jpg', '44_img1_0bbcca18051f8ddaeaf4351af0f5cda1.jpg', 550, 365, '44_img2_3e764e1c17fb4c4153d62f7f123a941e.jpg', 80, 53, 1, 'admin', '2010-03-13 19:03:45', 0, '', '0000-00-00 00:00:00', 1, 0),
(45, 46, 6, '', '', '', 0, 0, 0, 0.00, 2, 'dester_4.jpg', '45_img1_6b76725c218323362dc2a813f1537f0c.jpg', 255, 365, '45_img2_c489e21acc2029a9ca340c52f0a20ffb.jpg', 55, 80, 1, 'admin', '2010-03-13 19:04:02', 0, '', '0000-00-00 00:00:00', 1, 0),
(46, 46, 7, '', '', '', 0, 0, 0, 0.00, 2, 'dester_5.jpg', '46_img1_b9a81f90719deb324f29556972f9d9ab.jpg', 255, 365, '46_img2_f6508108e79b9a922360137be789eb9a.jpg', 55, 80, 1, 'admin', '2010-03-13 19:04:20', 0, '', '0000-00-00 00:00:00', 1, 0),
(47, 46, 2, '', '', '', 0, 0, 0, 0.00, 2, 'dester_6.jpg', '47_img1_3e0cf43dfa007b06fcf78a8689db967f.jpg', 550, 365, '47_img2_b3830a28e45a5fc4046b31c8e10cfb85.jpg', 80, 53, 1, 'admin', '2010-03-13 19:21:31', 0, '', '0000-00-00 00:00:00', 1, 0),
(48, 46, 5, '', '', '', 0, 0, 0, 0.00, 2, 'dester_7.jpg', '48_img1_d3948b57995bff8ea9b9b4e29fa1cebd.jpg', 550, 365, '48_img2_da070ebb0470b001e23e513e2d9f6f46.jpg', 80, 53, 1, 'admin', '2010-03-13 19:37:23', 0, '', '0000-00-00 00:00:00', 1, 0),
(49, 47, 1, '', '', '', 0, 0, 0, 0.00, 2, 'ryba_galareta_01.jpg', '49_img1_8a8eace7ee39c56a4b0dbbb7a15f63c9.jpg', 550, 365, '49_img2_76fd48eebcba11d0ae556f77ca0cf733.jpg', 80, 53, 1, 'admin', '2010-03-13 19:57:26', 0, '', '0000-00-00 00:00:00', 1, 0),
(50, 47, 2, '', '', '', 0, 0, 0, 0.00, 2, 'ryba_galareta_02.jpg', '50_img1_df29c6ccf5a711bbe2f3685d1801ea2d.jpg', 550, 366, '50_img2_3dd6a70d8bd1ce2ee52e56fa118a2116.jpg', 80, 53, 1, 'admin', '2010-03-13 20:19:51', 0, '', '0000-00-00 00:00:00', 1, 0),
(69, 53, 2, '', '', '', 0, 0, 0, 0.00, 2, 'ryba_galareta_04.jpg', '69_img1_4c5aa2d83363726fcccaa605dbdbc0ce.jpg', 550, 366, '69_img2_a900505dd9eaa49641a6a3d75d95c033.jpg', 80, 53, 1, 'admin', '2010-03-18 15:11:15', 0, '', '0000-00-00 00:00:00', 1, 0),
(68, 53, 1, '', '', '', 0, 0, 0, 0.00, 2, 'ryba_galareta_03.jpg', '68_img1_ad84b8a70e93b46554865d54fd9513cb.jpg', 550, 366, '68_img2_ca9989e352f3c6c7b8e0c193163df007.jpg', 80, 53, 1, 'admin', '2010-03-18 15:11:05', 0, '', '0000-00-00 00:00:00', 1, 0),
(53, 42, 2, '', '', '', 0, 0, 0, 0.00, 2, 'kluski_slaskie_05.jpg', '53_img1_e5ab58af3a75a5f6a48d6ce5142a30e2.jpg', 550, 365, '53_img2_e2c919b774b0a05891cb78152f63e0a1.jpg', 80, 53, 1, 'admin', '2010-03-14 08:26:08', 0, '', '0000-00-00 00:00:00', 1, 0),
(54, 42, 3, '', '', '', 0, 0, 0, 0.00, 2, 'kluski_slaskie_02.jpg', '54_img1_9e739c2f2fd7caa71766d904a05ee435.jpg', 550, 366, '54_img2_61874d407a0bb8d5f5f861aa37d828ff.jpg', 80, 53, 1, 'admin', '2010-03-14 08:26:29', 0, '', '0000-00-00 00:00:00', 1, 0),
(55, 42, 4, '', '', '', 0, 0, 0, 0.00, 2, 'kluski_slaskie_03.jpg', '55_img1_43b94fe13b95a213a52777b1ca22cb4a.jpg', 550, 366, '55_img2_5d5cd33ba49478d6b3859fa52941dea0.jpg', 80, 53, 1, 'admin', '2010-03-14 08:26:47', 0, '', '0000-00-00 00:00:00', 1, 0),
(56, 42, 5, '', '', '', 0, 0, 0, 0.00, 2, 'kluski_slaskie_04.jpg', '56_img1_1ad8129642ca9f46f8efda35e79b3427.jpg', 550, 365, '56_img2_1dc851b29f37bd2ed50ecd891a6f122a.jpg', 80, 53, 1, 'admin', '2010-03-14 08:27:08', 0, '', '0000-00-00 00:00:00', 1, 0),
(57, 48, 1, '', '', '', 0, 0, 0, 0.00, 2, 'szynka_galareta_01.jpg', '57_img1_b1c0049ca4cefaa231180af958a9fb9e.jpg', 550, 366, '57_img2_3cde5d14bdc5948d87071481468f5c76.jpg', 80, 53, 1, 'admin', '2010-03-14 08:29:02', 0, '', '0000-00-00 00:00:00', 1, 0),
(58, 48, 2, '', '', '', 0, 0, 0, 0.00, 2, 'szynka_galareta_02.jpg', '58_img1_19d2c91d11eb614452d477bff8fb96ba.jpg', 550, 365, '58_img2_9658cb5cba43869382c5f6dc39c90574.jpg', 80, 53, 1, 'admin', '2010-03-14 08:29:19', 0, '', '0000-00-00 00:00:00', 1, 0),
(59, 49, 1, '', '', '', 0, 0, 0, 0.00, 2, 'surowki.jpg', '59_img1_3e1f1ed43113434cf5266d3536000809.jpg', 550, 365, '59_img2_ab9f032df77ff59098743a504b99b473.jpg', 80, 53, 1, 'admin', '2010-03-14 20:07:03', 0, '', '0000-00-00 00:00:00', 1, 0),
(60, 49, 2, '', '', '', 0, 0, 0, 0.00, 2, 'surowki_2.jpg', '60_img1_ab7649d5dd36266065b55dde15cf15e8.jpg', 550, 365, '60_img2_c7a4a1f2b8363af98b8c611b7f6e2d0d.jpg', 80, 53, 1, 'admin', '2010-03-14 20:07:25', 0, '', '0000-00-00 00:00:00', 1, 0),
(61, 49, 3, '', '', '', 0, 0, 0, 0.00, 2, 'surowki_3.jpg', '61_img1_06535bf3f3e831306873b47d975238f2.jpg', 550, 365, '61_img2_5807700050a1a93dd540d56776e43139.jpg', 80, 53, 1, 'admin', '2010-03-14 20:07:47', 0, '', '0000-00-00 00:00:00', 1, 0),
(62, 49, 4, '', '', '', 0, 0, 0, 0.00, 2, 'surowki_4.jpg', '62_img1_3d4c52905d64eba61fded8de121ae314.jpg', 550, 365, '62_img2_a98908b3a3bc61e1e9f4480373780406.jpg', 80, 53, 1, 'admin', '2010-03-14 20:08:02', 0, '', '0000-00-00 00:00:00', 1, 0),
(63, 50, 1, '', '', '', 0, 0, 0, 0.00, 2, 'roladki_sezam.jpg', '63_img1_5a16333c23fbe0ceecff56ee6f6f8f2a.jpg', 550, 365, '63_img2_119e39fe4fab147fba932ec8cbb57968.jpg', 80, 53, 1, 'admin', '2010-03-14 20:09:07', 0, '', '0000-00-00 00:00:00', 1, 0),
(64, 50, 2, '', '', '', 0, 0, 0, 0.00, 2, 'roladki_sezam_2.jpg', '64_img1_9ca2b433e2028b5a2a8c909aa84c2a31.jpg', 550, 365, '64_img2_9d369bc776d1b9e22dd1f809f534b000.jpg', 80, 53, 1, 'admin', '2010-03-14 20:09:25', 0, '', '0000-00-00 00:00:00', 1, 0),
(65, 51, 1, '', '', '', 0, 0, 0, 0.00, 2, 'dewolay.jpg', '65_img1_6ebc495a13cc76d15c930a7e2452416c.jpg', 550, 365, '65_img2_db5348986eb17a5d2aa3f926fd5cc1c7.jpg', 80, 53, 1, 'admin', '2010-03-14 20:11:57', 1, 'admin', '2010-03-14 20:14:24', 1, 0),
(66, 51, 2, '', '', '', 0, 0, 0, 0.00, 2, 'dewolay_frytki.jpg', '66_img1_430adeb3ef67737673ce45f2300d309f.jpg', 550, 365, '66_img2_6e11a467b3b9cf98d78ee5fece4c516d.jpg', 80, 53, 1, 'admin', '2010-03-14 20:12:18', 1, 'admin', '2010-03-14 20:15:02', 1, 0),
(109, 69, 6, '', '', '', 0, 0, 0, 0.00, 2, '9.jpg', '109_img1_8df4b9ed276747003b22b59e46cd2ff5.jpg', 550, 377, '109_img2_2ac14a83b2495ed5efe6aad93e1baa7e.jpg', 80, 54, 1, 'admin', '2017-03-01 19:06:26', 0, '', '0000-00-00 00:00:00', 1, 0),
(108, 69, 5, '', '', '', 0, 0, 0, 0.00, 2, '8.jpg', '108_img1_7e886f1bfd0af2c1840148e7722bd0a4.jpg', 550, 366, '108_img2_650e2d9a8b5bde92ab42558998d7333f.jpg', 80, 53, 1, 'admin', '2017-03-01 19:06:12', 0, '', '0000-00-00 00:00:00', 1, 0),
(107, 69, 4, '', '', '', 0, 0, 0, 0.00, 2, '3.jpg', '107_img1_6197c160130ef8afcbc0ca28d68937f1.jpg', 550, 397, '107_img2_821798cf277377a1915983b9616b2dfa.jpg', 80, 57, 1, 'admin', '2017-03-01 19:05:59', 0, '', '0000-00-00 00:00:00', 1, 0),
(106, 69, 3, '', '', '', 0, 0, 0, 0.00, 2, '1.jpg', '106_img1_314b0f4d0de1cd0f89c895bd8ab61f6f.jpg', 550, 366, '106_img2_76b3f36ae9a897caa2d8afb99b0adf29.jpg', 80, 53, 1, 'admin', '2017-03-01 19:05:18', 0, '', '0000-00-00 00:00:00', 1, 0),
(105, 69, 2, '', '', '', 0, 0, 0, 0.00, 2, 'palacowa2.JPG', '105_img1_f578797ae45cf9f68d50a5d7af5edb17.jpg', 550, 369, '105_img2_abb74bb9e4887f44962c2fe4be3275e4.jpg', 80, 53, 1, 'admin', '2017-03-01 19:04:40', 0, '', '0000-00-00 00:00:00', 1, 0),
(104, 69, 1, '', '', '', 0, 0, 0, 0.00, 2, 'palacowa1.jpg', '104_img1_5a3f65cb98259b59624e88ea2f6abed7.jpg', 550, 309, '104_img2_a89bc297a4c9ccd57d31c2a1cf17d019.jpg', 80, 44, 1, 'admin', '2017-03-01 19:03:12', 0, '', '0000-00-00 00:00:00', 1, 0),
(98, 34, 12, '', '', '', 0, 0, 0, 0.00, 2, 'zdjecia_6.JPG', '98_img1_03a6a708e81cbb10018b0149c03223dc.jpg', 550, 367, '98_img2_654e31e4c92d8d101ad19135c15ccc91.jpg', 80, 53, 1, 'admin', '2015-08-30 09:34:35', 0, '', '0000-00-00 00:00:00', 1, 0),
(102, 64, 5, '', '', '', 0, 0, 0, 0.00, 2, 'zdjecie_nr4.JPG', '102_img1_4ec7a2598e786fad60613f81b6640b51.jpg', 550, 369, '102_img2_f24a2409e6c2112e06bd6b4edb94f3b5.jpg', 80, 53, 1, 'admin', '2015-11-17 07:31:20', 0, '', '0000-00-00 00:00:00', 1, 0),
(93, 34, 6, '', '', '', 0, 0, 0, 0.00, 2, 'zdjecia_1.jpg', '93_img1_2f8714fd008363d522f7948f6103711f.jpg', 550, 367, '93_img2_896149e8ecd71cec77edf36c8851dc6a.jpg', 80, 53, 1, 'admin', '2015-08-30 09:08:42', 0, '', '0000-00-00 00:00:00', 1, 0),
(92, 33, 3, '', '', '', 0, 0, 0, 0.00, 2, '3.JPG', '92_img1_db5cd806ecce84352bb872fb6b3e72d8.jpg', 366, 550, '92_img2_57f0779a9846bd0031101f11ec678c92.jpg', 53, 80, 1, 'admin', '2015-06-29 16:00:26', 0, '', '0000-00-00 00:00:00', 1, 0),
(103, 64, 1, '', '', '', 0, 0, 0, 0.00, 2, 'zdjecie_numer3.JPG', '103_img1_aeb3ea427a927d4f19305ba0dad96b6f.jpg', 550, 369, '103_img2_5a441336627b2b08ccaffe89e75d52ca.jpg', 80, 53, 1, 'admin', '2015-11-17 07:31:54', 0, '', '0000-00-00 00:00:00', 1, 0),
(115, 34, 8, '', '', '', 0, 0, 0, 0.00, 2, 'lustrzana5.JPG', '115_img1_7ee7136195c9d8aa8ad881ee07dcd72e.jpg', 550, 369, '115_img2_b44f779c4dc9042983083399e75a5143.jpg', 80, 53, 1, 'admin', '2017-03-01 19:16:49', 0, '', '0000-00-00 00:00:00', 1, 0),
(116, 34, 9, '', '', '', 0, 0, 0, 0.00, 2, 'lustrzana6.JPG', '116_img1_92b73ebd07b6353e62940e75fde85709.jpg', 550, 369, '116_img2_741404b10e9e5360a280639eae633cfc.jpg', 80, 53, 1, 'admin', '2017-03-01 19:17:48', 0, '', '0000-00-00 00:00:00', 1, 0),
(118, 46, 8, '', '', '', 0, 0, 0, 0.00, 2, '20160806_225247.jpg', '118_img1_f7aeedaea6734ae141e44c1da09d5b33.jpg', 309, 550, '118_img2_dac300c212eb0326925fdad9d7e13711.jpg', 44, 80, 1, 'admin', '2017-03-01 19:49:39', 0, '', '0000-00-00 00:00:00', 1, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_art_koment`
--

CREATE TABLE `arkadia_art_koment` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_matka` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `tresc` text NOT NULL,
  `ip` varchar(39) NOT NULL,
  `host` varchar(60) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_bany`
--

CREATE TABLE `arkadia_bany` (
  `id` int(7) UNSIGNED NOT NULL,
  `id_typ` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `opis` varchar(255) NOT NULL DEFAULT '',
  `ip` varchar(30) NOT NULL DEFAULT '',
  `data_start` datetime NOT NULL,
  `data_stop` datetime NOT NULL,
  `rodzaj` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_forum_c`
--

CREATE TABLE `arkadia_forum_c` (
  `id` int(7) UNSIGNED NOT NULL,
  `nr_poz` int(7) UNSIGNED NOT NULL DEFAULT '0',
  `nazwa` varchar(250) NOT NULL DEFAULT '',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `specjalny` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_forum_d`
--

CREATE TABLE `arkadia_forum_d` (
  `id` smallint(4) UNSIGNED NOT NULL,
  `nr` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `nazwa` varchar(250) NOT NULL DEFAULT '',
  `opis` text NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_forum_f`
--

CREATE TABLE `arkadia_forum_f` (
  `id` int(7) UNSIGNED NOT NULL,
  `id_kat` int(7) UNSIGNED NOT NULL DEFAULT '0',
  `nr_poz` int(7) UNSIGNED NOT NULL DEFAULT '0',
  `nazwa` varchar(250) NOT NULL DEFAULT '',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `opis` text NOT NULL,
  `link` varchar(200) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `ile_tematy` int(11) NOT NULL,
  `ile_posty` int(11) NOT NULL,
  `last_poster_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `last_poster` varchar(250) NOT NULL,
  `last_post_id` int(11) NOT NULL,
  `last_post_date` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_forum_p`
--

CREATE TABLE `arkadia_forum_p` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_t` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `id_autor` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor` varchar(25) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '',
  `host` varchar(60) NOT NULL DEFAULT '',
  `ip` varchar(60) NOT NULL DEFAULT '',
  `tresc` text NOT NULL,
  `data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `img` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(250) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_forum_pp`
--

CREATE TABLE `arkadia_forum_pp` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_t` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `autor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `autor_email` varchar(80) NOT NULL,
  `autor_ip` varchar(39) NOT NULL,
  `edytor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tresc` text NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_forum_t`
--

CREATE TABLE `arkadia_forum_t` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_d` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `id_autor` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '',
  `temat` varchar(250) NOT NULL DEFAULT '',
  `data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_zal` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `licznik` int(12) UNSIGNED NOT NULL DEFAULT '0',
  `przyklejony` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_forum_tt`
--

CREATE TABLE `arkadia_forum_tt` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_f` int(7) UNSIGNED NOT NULL DEFAULT '0',
  `tytul` varchar(250) NOT NULL DEFAULT '',
  `przyklejony` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `first_post_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `last_post_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `last_post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `przekierowany` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `licznik_posty` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `licznik_wys` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_grupy`
--

CREATE TABLE `arkadia_grupy` (
  `id` int(10) UNSIGNED NOT NULL,
  `autor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL,
  `edytor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL,
  `typ` int(5) UNSIGNED NOT NULL DEFAULT '0',
  `nazwa` varchar(250) NOT NULL,
  `opis_krotki` text NOT NULL,
  `opis` text NOT NULL,
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(250) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img3_nazwa` varchar(200) NOT NULL,
  `img3_w` smallint(4) NOT NULL DEFAULT '0',
  `img3_h` smallint(4) NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `zamknieta` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `zatwierdzanie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `osoby` int(7) UNSIGNED NOT NULL DEFAULT '0',
  `wypowiedzi` int(7) UNSIGNED NOT NULL DEFAULT '0',
  `data_aktywnosci` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `do_usuniecia` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_grupy_galeria`
--

CREATE TABLE `arkadia_grupy_galeria` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `nr_poz` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `tytul` varchar(250) NOT NULL,
  `opis` text NOT NULL,
  `autor_zdjecia` varchar(250) NOT NULL,
  `licznik` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `punkty_ilosc` int(8) UNSIGNED NOT NULL DEFAULT '0',
  `punkty_suma` int(8) UNSIGNED NOT NULL DEFAULT '0',
  `punkty_srednia` float(5,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(250) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL,
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `obrobka` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_grupy_galeria_koment`
--

CREATE TABLE `arkadia_grupy_galeria_koment` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_matka` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `tresc` text NOT NULL,
  `ip` varchar(39) NOT NULL,
  `host` varchar(60) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_grupy_uzytkownicy`
--

CREATE TABLE `arkadia_grupy_uzytkownicy` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_u` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_grupa` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `data_dodania` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ostatnia_wizyta` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `funkcja` smallint(2) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_guestbook`
--

CREATE TABLE `arkadia_guestbook` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(60) NOT NULL DEFAULT '',
  `gg` varchar(15) NOT NULL DEFAULT '',
  `www` varchar(100) NOT NULL DEFAULT '',
  `tresc` text NOT NULL,
  `ip` varchar(15) NOT NULL DEFAULT '',
  `host` varchar(60) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_konfig`
--

CREATE TABLE `arkadia_konfig` (
  `idtf` varchar(100) NOT NULL,
  `wartosc` text NOT NULL,
  `lang` smallint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `arkadia_konfig`
--

INSERT INTO `arkadia_konfig` (`idtf`, `wartosc`, `lang`) VALUES
('konfig_tytul', 'JW WEB DEVELOPMENT', 1),
('konfig_tytul_przedrostek', 'JW WEBDEV', 1),
('konfig_description', 'opis tt', 1),
('konfig_keywords', 'cms', 1),
('konfig_kontakt_email', '', 0),
('konfig_chat', '1', 0),
('konfig_kontakt_nadawca', '', 0),
('konfig_lang_default', '1', 0),
('konfig_tytul', '', 2),
('konfig_tytul_przedrostek', '', 2),
('konfig_description', '', 2),
('konfig_keywords', '', 2),
('konfig_tytul', '', 3),
('konfig_tytul_przedrostek', '', 3),
('konfig_description', '', 3),
('konfig_keywords', '', 3),
('tytul', 'CMS - System użtkowników i administracji treścią serwisu WWW', 1),
('tytul_przedrostek', 'Arkadia', 1),
('description', '', 1),
('keywords', '', 1),
('kontakt_email', '', 0),
('kontakt_nadawca', '', 0),
('chat', '1', 0),
('lang_default', '1', 0),
('nazwa_www', 'Arkadia', 1),
('kontakt_smtp_host', '', 0),
('kontakt_smtp_user', '', 0),
('kontakt_smtp_haslo', '', 0),
('kodstat', '', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_logi`
--

CREATE TABLE `arkadia_logi` (
  `id` int(12) UNSIGNED NOT NULL,
  `id_u` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `login` varchar(30) NOT NULL DEFAULT '',
  `opis` varchar(255) NOT NULL DEFAULT '',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `host` varchar(60) NOT NULL DEFAULT '',
  `kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `idtf` varchar(20) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `arkadia_logi`
--

INSERT INTO `arkadia_logi` (`id`, `id_u`, `login`, `opis`, `ip`, `host`, `kiedy`, `idtf`) VALUES
(1359, 1, 'admin', 'struktura - edycja: Aktualności', '', '', '2019-10-10 10:12:03', ''),
(1358, 1, 'admin', 'poprawne zalogowanie', '', '', '2019-10-10 10:05:09', 'log'),
(1357, 0, 'arkadia', 'błąd logowania - konto nie istnieje', '', '', '2019-10-10 10:05:02', 'b_log');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_poczta`
--

CREATE TABLE `arkadia_poczta` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_autor` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `autor` varchar(150) NOT NULL,
  `id_odb` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `odb` varchar(150) NOT NULL,
  `tytul` varchar(200) NOT NULL DEFAULT '',
  `tresc` text NOT NULL,
  `data_wys` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_odczyt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_odp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_usuniecia` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `id_wys` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_odp` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `systemowa` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `wykonana` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `typ` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `zdefiniowana` smallint(4) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_rotator`
--

CREATE TABLE `arkadia_rotator` (
  `id` int(12) UNSIGNED NOT NULL,
  `id_typ` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link` text NOT NULL,
  `tytul` varchar(250) NOT NULL,
  `opis` text NOT NULL,
  `priorytet` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `udzial` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `licznik` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `licznik_limit` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `czy_licznik` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `klik` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `klik_limit` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `czy_klik` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `data_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa` varchar(200) NOT NULL,
  `img_nazwa_oryginal` varchar(200) NOT NULL,
  `img_w` smallint(4) NOT NULL DEFAULT '0',
  `img_h` smallint(4) NOT NULL DEFAULT '0',
  `swf_wersja` smallint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_tlo` varchar(6) NOT NULL DEFAULT '',
  `img_link` varchar(250) NOT NULL DEFAULT '',
  `link_okno` varchar(50) NOT NULL DEFAULT '',
  `lang` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_sklep_kat`
--

CREATE TABLE `arkadia_sklep_kat` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_d` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_pierwszy` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `poziom` int(5) NOT NULL,
  `nr_poz` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `tytul` varchar(200) NOT NULL DEFAULT '',
  `tytul_menu` varchar(200) NOT NULL,
  `podtytul` text NOT NULL,
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(200) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(11) UNSIGNED NOT NULL,
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(11) NOT NULL,
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `licznik` mediumint(7) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `lang` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `menu_wyr` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `idtf_link` varchar(100) NOT NULL,
  `description` varchar(250) NOT NULL,
  `keywords` varchar(250) NOT NULL,
  `title` varchar(200) NOT NULL,
  `typ` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_sklep_producenci`
--

CREATE TABLE `arkadia_sklep_producenci` (
  `id` int(10) UNSIGNED NOT NULL,
  `nazwa` varchar(250) NOT NULL DEFAULT '',
  `opis` text NOT NULL,
  `link` varchar(250) NOT NULL,
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(200) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(11) UNSIGNED NOT NULL,
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(11) NOT NULL,
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `lang` smallint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_sklep_produkty`
--

CREATE TABLE `arkadia_sklep_produkty` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_kat` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_producent` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `symbol` varchar(100) NOT NULL,
  `nazwa` varchar(250) NOT NULL,
  `nazwa_menu` varchar(250) NOT NULL,
  `zajawka` text NOT NULL,
  `opis` text NOT NULL,
  `link` varchar(250) NOT NULL,
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(200) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img3_w` smallint(4) NOT NULL DEFAULT '0',
  `img3_h` smallint(4) NOT NULL DEFAULT '0',
  `img3_nazwa` varchar(200) NOT NULL,
  `autor_id` int(11) UNSIGNED NOT NULL,
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(11) NOT NULL,
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `licznik` mediumint(7) UNSIGNED NOT NULL DEFAULT '0',
  `licznik_sprzedane` mediumint(7) NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `lang` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `idtf_link` varchar(100) NOT NULL,
  `description` varchar(250) NOT NULL,
  `keywords` varchar(250) NOT NULL,
  `title` varchar(200) NOT NULL,
  `priorytet` smallint(2) NOT NULL DEFAULT '0',
  `wyr` tinyint(1) NOT NULL DEFAULT '0',
  `wyr_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wyr_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nowosc` tinyint(4) NOT NULL DEFAULT '0',
  `nowosc_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nowosc_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `promocja` tinyint(4) NOT NULL DEFAULT '0',
  `promocja_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `promocja_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wyprzedaz` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `wyprzedaz_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wyprzedaz_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `polecamy` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `polecamy_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `polecamy_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cena` float(10,2) NOT NULL DEFAULT '0.00',
  `vat` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `cena_skreslona` float(10,2) NOT NULL DEFAULT '0.00',
  `cena_promo` float(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `glosy` int(8) NOT NULL,
  `glosy_suma` int(11) NOT NULL,
  `glosy_srednia` float(8,2) NOT NULL,
  `waga` float(8,2) NOT NULL DEFAULT '0.00',
  `dostepnosc` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `dostepnosc_sztuk` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_sklep_zamowienia`
--

CREATE TABLE `arkadia_sklep_zamowienia` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_u` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `klient_nazwa` varchar(200) NOT NULL,
  `zam_data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `zam_kwota` float(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `zam_waga` float(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `przesylka_kwota` float(6,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `przesylka_typ` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `status_data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `platnosc_typ` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `platnosc_status` smallint(4) UNSIGNED NOT NULL,
  `platnosc_kod` varchar(200) NOT NULL,
  `platnosc_error` varchar(20) NOT NULL,
  `platnosc_kwota` float(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `platnosc_data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `uwagi_klient` text NOT NULL,
  `uwagi_tylko_admin` text NOT NULL,
  `uwagi_admin_klient` text NOT NULL,
  `autor_id` int(11) UNSIGNED NOT NULL,
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(11) NOT NULL,
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `faktura` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `email` varchar(60) NOT NULL,
  `telefon` varchar(50) NOT NULL,
  `imie` varchar(100) NOT NULL,
  `nazwisko` varchar(100) NOT NULL,
  `miejscowosc` varchar(100) NOT NULL,
  `kod_pocztowy` varchar(10) NOT NULL,
  `ulica` varchar(150) NOT NULL,
  `nr_domu` varchar(10) NOT NULL,
  `nr_mieszkania` varchar(10) NOT NULL,
  `firma_nazwa` varchar(200) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `wysylka_miejscowosc` varchar(100) NOT NULL,
  `wysylka_kod_pocztowy` varchar(10) NOT NULL,
  `wysylka_ulica` varchar(150) NOT NULL,
  `wysylka_nr_domu` varchar(10) NOT NULL,
  `wysylka_nr_mieszkania` varchar(10) NOT NULL,
  `faktura_nr` varchar(100) NOT NULL,
  `faktura_data` date NOT NULL DEFAULT '0000-00-00',
  `przesylka_nr` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_sklep_zamowienia_produkty`
--

CREATE TABLE `arkadia_sklep_zamowienia_produkty` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_zam` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_produkt` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_wersja` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `nazwa` varchar(250) NOT NULL,
  `cena` float(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `vat` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `ilosc` int(7) UNSIGNED NOT NULL DEFAULT '0',
  `id_kolor` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_rozmiar` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_subskrypcja`
--

CREATE TABLE `arkadia_subskrypcja` (
  `id` int(10) UNSIGNED NOT NULL,
  `idtf` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_u` int(10) NOT NULL DEFAULT '0',
  `email` varchar(150) NOT NULL,
  `data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(15) NOT NULL,
  `sprcheck` varchar(32) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_subskrypcja_pliki`
--

CREATE TABLE `arkadia_subskrypcja_pliki` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_matka` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `nazwa` varchar(200) NOT NULL,
  `nazwa_oryginal` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_subskrypcja_wiadomosci`
--

CREATE TABLE `arkadia_subskrypcja_wiadomosci` (
  `id` int(10) UNSIGNED NOT NULL,
  `data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tytul` varchar(200) NOT NULL DEFAULT '',
  `tresc` text NOT NULL,
  `licznik` mediumint(7) NOT NULL DEFAULT '0',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_uzytkownicy`
--

CREATE TABLE `arkadia_uzytkownicy` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(30) NOT NULL DEFAULT '',
  `haslo` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(80) NOT NULL,
  `email2` varchar(80) NOT NULL,
  `imie` varchar(40) NOT NULL,
  `nazwisko` varchar(60) NOT NULL,
  `nazwa` varchar(200) NOT NULL,
  `ur_rok` mediumint(4) UNSIGNED NOT NULL DEFAULT '0',
  `ur_mc` smallint(2) UNSIGNED NOT NULL DEFAULT '0',
  `ur_dzien` smallint(2) UNSIGNED NOT NULL DEFAULT '0',
  `plec` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `miejscowosc` varchar(100) NOT NULL DEFAULT '',
  `kod_pocztowy` varchar(10) NOT NULL,
  `ulica` varchar(150) NOT NULL,
  `nr_domu` varchar(10) NOT NULL,
  `nr_mieszkania` varchar(10) NOT NULL,
  `woj` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `firma` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `firma_nazwa` varchar(200) NOT NULL,
  `firma_miejscowosc` varchar(100) NOT NULL,
  `firma_kod_pocztowy` varchar(10) NOT NULL,
  `firma_ulica` varchar(150) NOT NULL,
  `firma_nr_domu` varchar(10) NOT NULL,
  `firma_nr_mieszkania` varchar(10) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `gg` varchar(15) NOT NULL DEFAULT '',
  `skype` varchar(150) NOT NULL,
  `telefon` varchar(50) NOT NULL,
  `www` varchar(100) NOT NULL DEFAULT '',
  `omnie` text NOT NULL,
  `zainteresowania` text NOT NULL,
  `praca` text NOT NULL,
  `sprcheck` varchar(32) NOT NULL,
  `zalogowanie` varchar(32) NOT NULL DEFAULT '',
  `ip_log` varchar(15) NOT NULL DEFAULT '',
  `host_log` varchar(60) NOT NULL DEFAULT '',
  `last_log` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_bad_log` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_operation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_operation_name` varchar(100) NOT NULL,
  `data_haslo` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ile_log` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `uprawnienia` varchar(80) NOT NULL DEFAULT '0000000000000000000000000000000000000000',
  `opis` text NOT NULL,
  `punkty` mediumint(7) NOT NULL DEFAULT '0',
  `glosy_suma` int(8) UNSIGNED NOT NULL DEFAULT '0',
  `glosy_ile` int(6) UNSIGNED NOT NULL DEFAULT '0',
  `glosy_srednia` float(5,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `niewygasa` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT '1',
  `lang2` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `img` smallint(2) UNSIGNED NOT NULL,
  `img_nazwa_oryginal` varchar(200) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img3_nazwa` varchar(200) NOT NULL,
  `img3_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img3_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `typ` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `ile_znajomi` int(7) UNSIGNED NOT NULL DEFAULT '0',
  `wys_niepowiadomienia` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `wys_niewyszukiwarka` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `wys_kontaktowe` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `wys_opisowe` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `wys_galerie` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `wys_koment` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `zgoda_osobowe` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `zgoda_regulamin` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `suma_zakupy` float(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `ilosc_zakupy` int(5) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `arkadia_uzytkownicy`
--

INSERT INTO `arkadia_uzytkownicy` (`id`, `login`, `haslo`, `email`, `email2`, `imie`, `nazwisko`, `nazwa`, `ur_rok`, `ur_mc`, `ur_dzien`, `plec`, `miejscowosc`, `kod_pocztowy`, `ulica`, `nr_domu`, `nr_mieszkania`, `woj`, `firma`, `firma_nazwa`, `firma_miejscowosc`, `firma_kod_pocztowy`, `firma_ulica`, `firma_nr_domu`, `firma_nr_mieszkania`, `nip`, `gg`, `skype`, `telefon`, `www`, `omnie`, `zainteresowania`, `praca`, `sprcheck`, `zalogowanie`, `ip_log`, `host_log`, `last_log`, `last_bad_log`, `last_operation`, `last_operation_name`, `data_haslo`, `ile_log`, `uprawnienia`, `opis`, `punkty`, `glosy_suma`, `glosy_ile`, `glosy_srednia`, `niewygasa`, `status`, `lang2`, `img`, `img_nazwa_oryginal`, `img1_nazwa`, `img1_w`, `img1_h`, `img2_nazwa`, `img2_w`, `img2_h`, `img3_nazwa`, `img3_w`, `img3_h`, `typ`, `ile_znajomi`, `wys_niepowiadomienia`, `wys_niewyszukiwarka`, `wys_kontaktowe`, `wys_opisowe`, `wys_galerie`, `wys_koment`, `autor_id`, `autor_name`, `autor_kiedy`, `edytor_id`, `edytor_name`, `edytor_kiedy`, `zgoda_osobowe`, `zgoda_regulamin`, `suma_zakupy`, `ilosc_zakupy`) VALUES
(1, 'admin', '7d554e1c8e905a48c6b9106509f6eb0b', 'btomas@wp.pl', '', '', '', '', 0, 0, 0, 0, 'Toruń', '87-100', 'Grudziądzka', '44', '55', 2, 0, '', '', '', '', '', '', '', '5108169', 'waldemarjonik', '694600343', 'http://salonstron.pl', 'oto ja\r\n\r\n:)', ':)\r\n\r\n:)', ':)\r\n\r\n:)', 'b49a5b96937b73d049c61cb53218086c', 'a391c482f6fa8367f8012d12fef0cd80', '', '', '2019-10-10 10:05:09', '2019-03-05 09:50:57', '2019-10-10 10:12:11', '', '2011-01-18 08:40:03', 284, '10000000000000000000000000000000000000000000000000000000000000000000000000000000', '', 0, 0, 0, 0.00, 0, 1, 0, 2, 'fot21.jpg', '1_img1_aee6b5e249e9512448564aa30fb41037.jpg', 500, 375, '1_img2_811b6cf7f519e61f973c4d18336d3497.jpg', 120, 90, '1_img3_811b6cf7f519e61f973c4d18336d3497.jpg', 45, 45, 1, 0, 0, 0, 0, 0, 0, 0, 13, 'demo', '2009-09-04 14:53:40', 1, 'admin', '2011-01-18 08:40:03', 0, 0, 0.00, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_uzytkownicy_galeria`
--

CREATE TABLE `arkadia_uzytkownicy_galeria` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `nr_poz` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `tytul` varchar(250) NOT NULL,
  `opis` text NOT NULL,
  `autor_zdjecia` varchar(250) NOT NULL,
  `licznik` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `punkty_ilosc` int(8) UNSIGNED NOT NULL DEFAULT '0',
  `punkty_suma` int(8) UNSIGNED NOT NULL DEFAULT '0',
  `punkty_srednia` float(5,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(250) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL,
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `obrobka` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_uzytkownicy_galeria_koment`
--

CREATE TABLE `arkadia_uzytkownicy_galeria_koment` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_matka` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `tresc` text NOT NULL,
  `ip` varchar(39) NOT NULL,
  `host` varchar(60) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_uzytkownicy_koment`
--

CREATE TABLE `arkadia_uzytkownicy_koment` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_matka` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `tresc` text NOT NULL,
  `ip` varchar(39) NOT NULL,
  `host` varchar(60) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_zablokowani`
--

CREATE TABLE `arkadia_zablokowani` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_u` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_gosc` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `data_dodania` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `opis` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `arkadia_znajomi`
--

CREATE TABLE `arkadia_znajomi` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_u` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_gosc` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `data_dodania` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_ankieta`
--

CREATE TABLE `luminar_ankieta` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_typ` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL,
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL,
  `typ` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `data_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tytul` varchar(200) NOT NULL DEFAULT '',
  `tresc` text NOT NULL,
  `last_ip` varchar(15) NOT NULL DEFAULT '',
  `last_glos` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `logowane` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `lang` tinyint(2) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_ankieta_glosy`
--

CREATE TABLE `luminar_ankieta_glosy` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_u` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_ankieta_list`
--

CREATE TABLE `luminar_ankieta_list` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `nr_poz` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `glosy` int(6) UNSIGNED NOT NULL DEFAULT '0',
  `tresc` varchar(200) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_art`
--

CREATE TABLE `luminar_art` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_d` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_pierwszy` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `poziom` int(5) NOT NULL,
  `nr_poz` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `idtf` varchar(100) NOT NULL DEFAULT '',
  `tytul` varchar(200) NOT NULL DEFAULT '',
  `tytul_menu` varchar(200) NOT NULL,
  `podtytul` text NOT NULL,
  `data_wys` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `zajawka` text NOT NULL,
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(200) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img_align` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `link` varchar(250) NOT NULL DEFAULT '',
  `link_okno` varchar(50) NOT NULL,
  `autor_id` int(10) UNSIGNED NOT NULL,
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(10) NOT NULL,
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `licznik` mediumint(7) UNSIGNED NOT NULL DEFAULT '0',
  `typ` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `komentarze` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `lang` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `na_str` int(3) UNSIGNED NOT NULL DEFAULT '0',
  `dostep` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `rss` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `glowny` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `menu_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `menu_wyr` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `submenu` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `submenu_polozenie` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `submenu_wyglad` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `do_gory` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `mapa_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `tytul_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `stopka_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `idtf_link` varchar(100) NOT NULL,
  `art_description` varchar(250) NOT NULL,
  `art_keywords` varchar(250) NOT NULL,
  `art_title` varchar(200) NOT NULL,
  `wytworzyl` varchar(150) NOT NULL,
  `wytworzyl_data` date NOT NULL DEFAULT '0000-00-00',
  `zrodlo_link` varchar(200) NOT NULL,
  `stat_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `luminar_art`
--

INSERT INTO `luminar_art` (`id`, `id_d`, `id_matka`, `id_pierwszy`, `poziom`, `nr_poz`, `idtf`, `tytul`, `tytul_menu`, `podtytul`, `data_wys`, `zajawka`, `img`, `img_nazwa_oryginal`, `img1_nazwa`, `img1_w`, `img1_h`, `img2_nazwa`, `img2_w`, `img2_h`, `img_align`, `link`, `link_okno`, `autor_id`, `autor_name`, `autor_kiedy`, `edytor_id`, `edytor_name`, `edytor_kiedy`, `data_start`, `data_stop`, `licznik`, `typ`, `komentarze`, `status`, `lang`, `na_str`, `dostep`, `rss`, `glowny`, `menu_nie`, `menu_wyr`, `submenu`, `submenu_polozenie`, `submenu_wyglad`, `do_gory`, `mapa_nie`, `tytul_nie`, `stopka_nie`, `idtf_link`, `art_description`, `art_keywords`, `art_title`, `wytworzyl`, `wytworzyl_data`, `zrodlo_link`, `stat_nie`) VALUES
(1, 1, 0, 0, 0, 1, '', 'Z nami udekorujesz każdą okazję...', 'Home', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, 'index.php', '', 1, 'admin', '2010-03-08 21:02:52', 1, 'admin', '2010-03-14 17:42:40', '2010-03-08 21:02:00', '0000-00-00 00:00:00', 488, 0, 0, 1, 1, 0, 0, 0, 1, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(2, 1, 0, 0, 0, 2, '', 'O Firmie', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-08 21:03:00', 1, 'admin', '2010-03-17 14:38:32', '2010-03-08 21:02:00', '0000-00-00 00:00:00', 167, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(3, 1, 0, 0, 0, 3, '', 'Nowości', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, 'index.php?akcja=sklep_nowosci', '', 1, 'admin', '2010-03-08 21:03:06', 1, 'admin', '2010-03-10 12:19:33', '2010-03-08 21:03:00', '0000-00-00 00:00:00', 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(4, 1, 0, 0, 0, 4, '', 'Promocje', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-08 21:03:15', 0, '', '0000-00-00 00:00:00', '2010-03-08 21:03:00', '0000-00-00 00:00:00', 156, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(5, 1, 0, 0, 0, 5, '', 'Wyprzedaże', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-08 21:03:24', 1, 'admin', '2010-03-09 20:19:15', '2010-03-08 21:03:00', '0000-00-00 00:00:00', 143, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(6, 1, 0, 0, 0, 6, 'kontakt', 'Kontakt', '', '', '0000-00-00 00:00:00', '<p style=\"margin-bottom: 5px;\"><strong>Luminar</strong><br />\r\n<br />\r\n87-100 Toruń<br />\r\nul. Wały gen. Sikorskiego 29<br />\r\nvis-a-vis Dworzec PKS</p>\r\n<p style=\"margin-bottom: 5px;\">tel/fax: 056 622 40 91<br />\r\ntel.kom.: 0501 516 875<br />\r\ne-mail: <a href=\"http://luminar@wp.pl\">luminar@wp.pl</a></p>\r\n<p style=\"margin-bottom: 5px;\">godziny otwarcia: Pon.- Piąt.: 8:00 - 16:00<br />\r\nSob.: 8:00 - 14:00</p>\r\n<p><iframe scrolling=\"no\" height=\"295\" frameborder=\"0\" width=\"295\" marginheight=\"0\" marginwidth=\"0\" src=\"http://maps.google.pl/maps?f=q&amp;source=s_q&amp;hl=pl&amp;geocode=&amp;q=87-100+Toru%C5%84+ul.+Wa%C5%82y+gen.+Sikorskiego+29&amp;sll=52.025459,19.204102&amp;sspn=9.726818,28.54248&amp;ie=UTF8&amp;hq=&amp;hnear=Wa%C5%82y+Genera%C5%82a+W%C5%82adys%C5%82awa+Sikorskiego+29,+Toru%C5%84,+Kujawsko-Pomorskie&amp;ll=53.022218,18.613844&amp;spn=0.015488,0.025749&amp;z=14&amp;output=embed\"></iframe><br />\r\n<small><a href=\"http://maps.google.pl/maps?f=q&amp;source=embed&amp;hl=pl&amp;geocode=&amp;q=87-100+Toru%C5%84+ul.+Wa%C5%82y+gen.+Sikorskiego+29&amp;sll=52.025459,19.204102&amp;sspn=9.726818,28.54248&amp;ie=UTF8&amp;hq=&amp;hnear=Wa%C5%82y+Genera%C5%82a+W%C5%82adys%C5%82awa+Sikorskiego+29,+Toru%C5%84,+Kujawsko-Pomorskie&amp;ll=53.022218,18.613844&amp;spn=0.015488,0.025749&amp;z=14\" style=\"color: rgb(0, 0, 255); text-align: left;\">Wyświetl większą mapę</a></small></p>', 0, '', '', 0, 0, '', 0, 0, 0, 'index.php?akcja=kontakt', '', 1, 'admin', '2010-03-08 21:03:50', 1, 'admin', '2010-03-15 17:35:17', '2010-03-08 21:03:00', '0000-00-00 00:00:00', 1, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 1, 0, '', '', '', '', '', '0000-00-00', '', 0),
(7, 10, 0, 0, 0, 7, 'wesela', 'Z nami udekorujesz każdą okazję...', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-10 16:37:30', 1, 'admin', '2010-03-14 18:29:15', '2010-03-10 16:36:00', '0000-00-00 00:00:00', 116, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0),
(8, 10, 0, 0, 0, 8, 'salony', 'Salony firmowe', '', '', '0000-00-00 00:00:00', '', 0, '', '', 0, 0, '', 0, 0, 0, '', '', 1, 'admin', '2010-03-10 22:39:40', 1, 'admin', '2010-03-17 23:26:57', '2010-03-10 22:39:00', '0000-00-00 00:00:00', 109, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, '', '', '', '', '', '0000-00-00', '', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_artd`
--

CREATE TABLE `luminar_artd` (
  `id` int(10) UNSIGNED NOT NULL,
  `akcja` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `akcja_data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `akcja_autor` varchar(150) NOT NULL,
  `akcja_autor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_art` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_d` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_pierwszy` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `poziom` int(5) NOT NULL,
  `nr_poz` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `idtf` varchar(100) NOT NULL DEFAULT '',
  `tytul` varchar(200) NOT NULL DEFAULT '',
  `tytul_menu` varchar(200) NOT NULL,
  `podtytul` text NOT NULL,
  `data_wys` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `zajawka` text NOT NULL,
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(200) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img_align` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `link` varchar(250) NOT NULL DEFAULT '',
  `link_okno` varchar(50) NOT NULL,
  `autor_id` int(10) UNSIGNED NOT NULL,
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(10) NOT NULL,
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `licznik` mediumint(7) UNSIGNED NOT NULL DEFAULT '0',
  `typ` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `komentarze` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `lang` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `na_str` int(3) UNSIGNED NOT NULL DEFAULT '0',
  `dostep` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `rss` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `glowny` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `menu_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `menu_wyr` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `submenu` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `submenu_polozenie` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `submenu_wyglad` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `do_gory` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `mapa_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `tytul_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `stopka_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `idtf_link` varchar(100) NOT NULL,
  `art_description` varchar(250) NOT NULL,
  `art_keywords` varchar(250) NOT NULL,
  `art_title` varchar(200) NOT NULL,
  `wytworzyl` varchar(150) NOT NULL,
  `wytworzyl_data` date NOT NULL DEFAULT '0000-00-00',
  `zrodlo_link` varchar(200) NOT NULL,
  `stat_nie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_art_akapity`
--

CREATE TABLE `luminar_art_akapity` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `nr_poz` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `tytul` varchar(250) NOT NULL,
  `tresc` longtext NOT NULL,
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(250) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img_align` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `img_opis` varchar(200) NOT NULL DEFAULT '',
  `img_link` varchar(250) NOT NULL DEFAULT '',
  `img_link_okno` varchar(50) NOT NULL DEFAULT '',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL,
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL,
  `typ` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `ramka` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `ramka_kolor` varchar(6) NOT NULL,
  `tlo_kolor` varchar(6) NOT NULL,
  `dlugosc` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `padding` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_wiersz` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_kolumna` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_typ` smallint(2) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_zalezne` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_m_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_m_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_skala` smallint(2) UNSIGNED NOT NULL DEFAULT '0',
  `blokada` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `data_blokada` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `luminar_art_akapity`
--

INSERT INTO `luminar_art_akapity` (`id`, `id_matka`, `nr_poz`, `tytul`, `tresc`, `img`, `img_nazwa_oryginal`, `img1_nazwa`, `img1_w`, `img1_h`, `img2_nazwa`, `img2_w`, `img2_h`, `img_align`, `img_opis`, `img_link`, `img_link_okno`, `autor_id`, `autor_name`, `autor_kiedy`, `edytor_id`, `edytor_name`, `edytor_kiedy`, `typ`, `ramka`, `ramka_kolor`, `tlo_kolor`, `dlugosc`, `padding`, `galeria_wiersz`, `galeria_kolumna`, `galeria_typ`, `galeria_zalezne`, `galeria_m_w`, `galeria_m_h`, `galeria_skala`, `blokada`, `data_blokada`, `status`) VALUES
(1, 1, 1, '', '<p>Dekoracja to bardzo istotny element wpływający na jakość imprezy. Nie zdawaj się na przypadek.<br />\r\n&nbsp;&nbsp; Pomożemy Ci w skomponowaniu dekoracji tak, aby odpowiadała Twoim oczekiwaniom, a jednocześnie pozwoliła w każdym pomieszczeniu stworzyć niezapomnianą atmosferę.<br />\r\n&nbsp;&nbsp; Planujesz ślub, wesele, przyjęcie? Nasza firma zaprasza bardzo serdecznie. <br />\r\n<br />\r\n&nbsp;&nbsp;&nbsp; W naszej ofercie znajdą Państwo dekoracje wszelkiego rodzaju. Balony, girlandy, stroiki, serwetki, świece, zaproszenia, stroiki na samochód i do domu - to tylko niektóre z oferowanych przez nas produktów.</p>', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-09 00:23:51', 1, 'admin', '2010-03-14 17:42:40', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(2, 2, 1, '', '<p><img src=\"file:///C:/DOCUME%7E1/Waran/USTAWI%7E1/Temp/moz-screenshot-3.png\" alt=\"\" /></p>\r\n<p>&nbsp;&nbsp; <span style=\"font-family: Verdana;\"><span style=\"font-size: 18px;\">W naszej ofercie znajdą Państwo dekoracje wszelkiego rodzaju. Balony, girlandy, stroiki, serwetki, świece, zaproszenia, stroiki na samochód i do domu - to tylko niektóre z oferowanych przez nas produktów.<br />\r\n&nbsp;&nbsp;</span></span></p>\r\n<p><span style=\"font-family: Verdana;\"><span style=\"font-size: 18px;\">&nbsp; Nasza firma na toruńskim rynku istnieje już od 1992 roku toteż dekoracje różnego rodzaju imprez i ważnych uroczystości to nasza specjalność. Uzyskają Państwo u nas fachową poradę jak i wiele ciekawych pomysłów, tak by te najważniejsze chwile Waszego życia spędzone były w jak najlepszej i najpiękniejszej atmosferze.</span></span></p>', 2, 'married-with-bagage.jpg', '2_img1_1e2872f2b80b7c8771a91f4cac1de1b9.jpg', 380, 380, '2_img2_5d6e78fbefcb82980e12813743ec9944.jpg', 200, 200, 1, 'Ozdoby weselne Luminar', '', '', 1, 'admin', '2010-03-10 07:45:15', 1, 'admin', '2010-03-17 14:38:32', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(3, 7, 1, '', '<p>Nasza firma na toruńskim rynku istnieje już od 1992 roku toteż dekoracje różnego rodzaju imprez i ważnych uroczystości to nasza specjalność. Uzyskają Państwo u nas fachową poradę jak i wiele ciekawych pomysłów, tak by te najważniejsze chwile Waszego życia spędzone były w jak najlepszej i najpiękniejszej atmosferze.<br />\r\n<br />\r\n&nbsp;</p>\r\n<div style=\"padding-bottom: 60px;\">\r\n<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" class=\"seta srodek\">\r\n    <tbody>\r\n        <tr valign=\"top\">\r\n            <td><a href=\"index.php?akcja=sklep_zobacz&amp;id_kat=14\"><img alt=\"dekoracje kościołów\" src=\"img/dekoracjekosc.jpg\" /></a></td>\r\n            <td><a href=\"index.php?akcja=sklep_zobacz&amp;id_kat=15\"><img alt=\"dekoracje sal\" src=\"img/dekoracjesal.jpg\" /></a></td>\r\n            <td><a href=\"index.php?akcja=sklep_zobacz&amp;id_kat=16\"><img alt=\"dekoracje samochodów\" src=\"img/dekoracjesam.jpg\" /></a></td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-10 16:41:34', 1, 'admin', '2010-03-11 18:04:49', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(5, 8, 1, '', '<p><span style=\"color: rgb(0, 0, 0);\"><b>Toruń<br />\r\nul. Wały gen. Sikorskiego 29<br />\r\n</b>vis-a-vis Dworzec PKS&nbsp;</span></p>\r\n<p><b>tel/fax: 056 622 40 91</b>    <b> tel.kom.: 0501 516 875</b><br />\r\n<b> e-mail: <a href=\"mailto:luminar@wp.pl\"><u>luminar@wp.pl</u></a> </b></p>\r\n<p><span style=\"font-size: 9px;\"><b>godziny otwarcia: </b></span> <span style=\"font-size: 9px;\"><b>Pon.- Piąt.: 8:00 - 16:00 &nbsp;&nbsp;&nbsp;</b></span> <span style=\"font-size: 9px;\"><b>Sob.: 8:00 - 14:00</b></span></p>\r\n<p><span style=\"color: rgb(0, 0, 0);\"><strong><br />\r\n</strong></span></p>\r\n<p>&nbsp;</p>\r\n<p>&nbsp;</p>', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-12 15:02:47', 1, 'admin', '2010-03-17 23:26:57', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1),
(7, 6, 1, 'Liminar', '<p><span style=\"font-size: 16px;\"><strong>Liminar </strong></span></p>\r\n<p><b>87-100 Toruń<br />\r\nul. Wały gen. Sikorskiego 29<br />\r\n</b>vis-a-vis Dworzec PKS<b><br />\r\n<br />\r\ntel/fax: 056 622 40 91<br />\r\ntel.kom.: 0501 516 875<br />\r\ne-mail: <a href=\"mailto:luminar@wp.pl\"><u>luminar@wp.pl</u></a> </b></p>\r\n<p><b> godziny otwarcia: </b></p>\r\n<p><b>Pon.- Piąt.: 8:00 - 16:00 &nbsp;&nbsp; </b></p>\r\n<p><b>Sob.: 8:00 - 14:00</b></p>', 0, '', '', 0, 0, '', 0, 0, 2, '', '', '', 1, 'admin', '2010-03-14 12:40:42', 1, 'admin', '2010-03-14 12:44:37', 0, 0, '', '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_art_akapityd`
--

CREATE TABLE `luminar_art_akapityd` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_artd` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_akapit` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `nr_poz` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `tytul` varchar(250) NOT NULL,
  `tresc` longtext NOT NULL,
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(250) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img_align` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `img_opis` varchar(200) NOT NULL DEFAULT '',
  `img_link` varchar(250) NOT NULL DEFAULT '',
  `img_link_okno` varchar(50) NOT NULL DEFAULT '',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL,
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL,
  `typ` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `ramka` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `ramka_kolor` varchar(6) NOT NULL,
  `tlo_kolor` varchar(6) NOT NULL,
  `dlugosc` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `padding` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_wiersz` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_kolumna` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_typ` smallint(2) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_zalezne` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_m_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_m_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `galeria_skala` smallint(2) UNSIGNED NOT NULL DEFAULT '0',
  `blokada` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `data_blokada` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_art_dziennik`
--

CREATE TABLE `luminar_art_dziennik` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_u` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_art` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor` varchar(150) NOT NULL,
  `opis` varchar(255) NOT NULL DEFAULT '',
  `data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_art_galeria`
--

CREATE TABLE `luminar_art_galeria` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `nr_poz` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `tytul` varchar(250) NOT NULL,
  `opis` text NOT NULL,
  `autor_zdjecia` varchar(250) NOT NULL,
  `licznik` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `punkty_ilosc` int(8) UNSIGNED NOT NULL DEFAULT '0',
  `punkty_suma` int(8) UNSIGNED NOT NULL DEFAULT '0',
  `punkty_srednia` float(5,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(250) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL,
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `obrobka` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_art_koment`
--

CREATE TABLE `luminar_art_koment` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_matka` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `tresc` text NOT NULL,
  `ip` varchar(39) NOT NULL,
  `host` varchar(60) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_bany`
--

CREATE TABLE `luminar_bany` (
  `id` int(7) UNSIGNED NOT NULL,
  `id_typ` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `opis` varchar(255) NOT NULL DEFAULT '',
  `ip` varchar(30) NOT NULL DEFAULT '',
  `data_start` datetime NOT NULL,
  `data_stop` datetime NOT NULL,
  `rodzaj` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_forum_c`
--

CREATE TABLE `luminar_forum_c` (
  `id` int(7) UNSIGNED NOT NULL,
  `nr_poz` int(7) UNSIGNED NOT NULL DEFAULT '0',
  `nazwa` varchar(250) NOT NULL DEFAULT '',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `specjalny` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_forum_d`
--

CREATE TABLE `luminar_forum_d` (
  `id` smallint(4) UNSIGNED NOT NULL,
  `nr` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `nazwa` varchar(250) NOT NULL DEFAULT '',
  `opis` text NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_forum_f`
--

CREATE TABLE `luminar_forum_f` (
  `id` int(7) UNSIGNED NOT NULL,
  `id_kat` int(7) UNSIGNED NOT NULL DEFAULT '0',
  `nr_poz` int(7) UNSIGNED NOT NULL DEFAULT '0',
  `nazwa` varchar(250) NOT NULL DEFAULT '',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `opis` text NOT NULL,
  `link` varchar(200) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `ile_tematy` int(11) NOT NULL,
  `ile_posty` int(11) NOT NULL,
  `last_poster_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `last_poster` varchar(250) NOT NULL,
  `last_post_id` int(11) NOT NULL,
  `last_post_date` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_forum_p`
--

CREATE TABLE `luminar_forum_p` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_t` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `id_autor` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor` varchar(25) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '',
  `host` varchar(60) NOT NULL DEFAULT '',
  `ip` varchar(60) NOT NULL DEFAULT '',
  `tresc` text NOT NULL,
  `data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `img` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(250) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_forum_pp`
--

CREATE TABLE `luminar_forum_pp` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_t` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `autor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `autor_email` varchar(80) NOT NULL,
  `autor_ip` varchar(39) NOT NULL,
  `edytor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tresc` text NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_forum_t`
--

CREATE TABLE `luminar_forum_t` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_d` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `id_autor` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(60) NOT NULL DEFAULT '',
  `temat` varchar(250) NOT NULL DEFAULT '',
  `data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_zal` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `licznik` int(12) UNSIGNED NOT NULL DEFAULT '0',
  `przyklejony` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_forum_tt`
--

CREATE TABLE `luminar_forum_tt` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_f` int(7) UNSIGNED NOT NULL DEFAULT '0',
  `tytul` varchar(250) NOT NULL DEFAULT '',
  `przyklejony` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `first_post_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `last_post_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `last_post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `przekierowany` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `licznik_posty` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `licznik_wys` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_grupy`
--

CREATE TABLE `luminar_grupy` (
  `id` int(10) UNSIGNED NOT NULL,
  `autor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL,
  `edytor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL,
  `typ` int(5) UNSIGNED NOT NULL DEFAULT '0',
  `nazwa` varchar(250) NOT NULL,
  `opis_krotki` text NOT NULL,
  `opis` text NOT NULL,
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(250) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img3_nazwa` varchar(200) NOT NULL,
  `img3_w` smallint(4) NOT NULL DEFAULT '0',
  `img3_h` smallint(4) NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `zamknieta` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `zatwierdzanie` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `osoby` int(7) UNSIGNED NOT NULL DEFAULT '0',
  `wypowiedzi` int(7) UNSIGNED NOT NULL DEFAULT '0',
  `data_aktywnosci` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `do_usuniecia` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_grupy_galeria`
--

CREATE TABLE `luminar_grupy_galeria` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `nr_poz` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `tytul` varchar(250) NOT NULL,
  `opis` text NOT NULL,
  `autor_zdjecia` varchar(250) NOT NULL,
  `licznik` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `punkty_ilosc` int(8) UNSIGNED NOT NULL DEFAULT '0',
  `punkty_suma` int(8) UNSIGNED NOT NULL DEFAULT '0',
  `punkty_srednia` float(5,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(250) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL,
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `obrobka` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_grupy_galeria_koment`
--

CREATE TABLE `luminar_grupy_galeria_koment` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_matka` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `tresc` text NOT NULL,
  `ip` varchar(39) NOT NULL,
  `host` varchar(60) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_grupy_uzytkownicy`
--

CREATE TABLE `luminar_grupy_uzytkownicy` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_u` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_grupa` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `data_dodania` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ostatnia_wizyta` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `funkcja` smallint(2) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_guestbook`
--

CREATE TABLE `luminar_guestbook` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(60) NOT NULL DEFAULT '',
  `gg` varchar(15) NOT NULL DEFAULT '',
  `www` varchar(100) NOT NULL DEFAULT '',
  `tresc` text NOT NULL,
  `ip` varchar(15) NOT NULL DEFAULT '',
  `host` varchar(60) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_konfig`
--

CREATE TABLE `luminar_konfig` (
  `idtf` varchar(100) NOT NULL,
  `wartosc` text NOT NULL,
  `lang` smallint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `luminar_konfig`
--

INSERT INTO `luminar_konfig` (`idtf`, `wartosc`, `lang`) VALUES
('nazwa_www', 'Luminar artykuły dekoracyjne', 1),
('tytul_przedrostek', 'Luminar', 1),
('description', '', 1),
('keywords', '', 1),
('kodstat', '', 1),
('kontakt_email', '', 0),
('kontakt_nadawca', '', 0),
('kontakt_smtp_host', '', 0),
('kontakt_smtp_user', '', 0),
('kontakt_smtp_haslo', '', 0),
('lang_default', '', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_logi`
--

CREATE TABLE `luminar_logi` (
  `id` int(12) UNSIGNED NOT NULL,
  `id_u` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `login` varchar(30) NOT NULL DEFAULT '',
  `opis` varchar(255) NOT NULL DEFAULT '',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `host` varchar(60) NOT NULL DEFAULT '',
  `kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `idtf` varchar(20) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `luminar_logi`
--

INSERT INTO `luminar_logi` (`id`, `id_u`, `login`, `opis`, `ip`, `host`, `kiedy`, `idtf`) VALUES
(1, 1, 'admin', 'poprawne zalogowanie', '127.0.0.1', 'localhost', '2010-03-08 20:57:44', 'log'),
(2, 1, 'admin', 'struktura - dodawanie: Balony', '127.0.0.1', 'localhost', '2010-03-08 21:00:46', ''),
(3, 1, 'admin', 'struktura - dodawanie: Wesela śluby', '127.0.0.1', 'localhost', '2010-03-08 21:00:59', ''),
(4, 1, 'admin', 'struktura - dodawanie: Chrzest', '127.0.0.1', 'localhost', '2010-03-08 21:01:08', ''),
(5, 1, 'admin', 'struktura - dodawanie: Narodziny, roczek', '127.0.0.1', 'localhost', '2010-03-08 21:01:22', ''),
(6, 1, 'admin', 'struktura - dodawanie: Komunia', '127.0.0.1', 'localhost', '2010-03-08 21:01:30', ''),
(7, 1, 'admin', 'struktura - dodawanie: Urodziny, imieniny', '127.0.0.1', 'localhost', '2010-03-08 21:01:48', ''),
(8, 1, 'admin', 'struktura - dodawanie: Boże narodzenie', '127.0.0.1', 'localhost', '2010-03-08 21:01:59', ''),
(9, 1, 'admin', 'struktura - dodawanie: Sylwester', '127.0.0.1', 'localhost', '2010-03-08 21:02:09', ''),
(10, 1, 'admin', 'struktura - dodawanie: Studniówka', '127.0.0.1', 'localhost', '2010-03-08 21:02:18', ''),
(11, 1, 'admin', 'struktura - dodawanie: Walentynki', '127.0.0.1', 'localhost', '2010-03-08 21:02:26', ''),
(12, 1, 'admin', 'struktura - dodawanie: Sprzęt dekoratorski', '127.0.0.1', 'localhost', '2010-03-08 21:02:41', ''),
(13, 1, 'admin', 'struktura - dodawanie: Home', '127.0.0.1', 'localhost', '2010-03-08 21:02:52', ''),
(14, 1, 'admin', 'struktura - dodawanie: O Firmie', '127.0.0.1', 'localhost', '2010-03-08 21:03:00', ''),
(15, 1, 'admin', 'struktura - dodawanie: Nowości', '127.0.0.1', 'localhost', '2010-03-08 21:03:06', ''),
(16, 1, 'admin', 'struktura - dodawanie: Promocje', '127.0.0.1', 'localhost', '2010-03-08 21:03:15', ''),
(17, 1, 'admin', 'struktura - dodawanie: Wypredaże', '127.0.0.1', 'localhost', '2010-03-08 21:03:24', ''),
(18, 1, 'admin', 'struktura - dodawanie: Kontakt', '127.0.0.1', 'localhost', '2010-03-08 21:03:50', ''),
(19, 1, 'admin', 'struktura - edycja: Z nami udekorujesz każdą okazję...', '127.0.0.1', 'localhost', '2010-03-08 21:53:18', ''),
(20, 1, 'admin', 'struktura - edycja: Z nami udekorujesz każdą okazję...', '127.0.0.1', 'localhost', '2010-03-08 23:55:30', ''),
(21, 1, 'admin', 'struktura - edycja: Z nami udekorujesz każdą okazję...', '127.0.0.1', 'localhost', '2010-03-08 23:55:47', ''),
(22, 1, 'admin', 'artykuł - dodawanie akapitu: Z nami udekorujesz każdą okazję...', '127.0.0.1', 'localhost', '2010-03-09 00:23:51', ''),
(23, 1, 'admin', 'Wylogowanie', '127.0.0.1', 'localhost', '2010-03-09 00:24:00', 'wylog'),
(24, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-09 11:40:32', 'log'),
(25, 1, 'admin', 'poprawne zalogowanie', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 19:42:17', 'log'),
(26, 1, 'admin', 'struktura - edycja: Balony', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 19:45:20', ''),
(27, 1, 'admin', 'struktura - edycja: Balony', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 19:45:28', ''),
(28, 1, 'admin', 'dodanie produktu Balon biały', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 19:46:59', ''),
(29, 1, 'admin', 'edycja produktu Balon biały', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 19:48:09', ''),
(30, 1, 'admin', 'produkty - usuwanie', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 19:48:51', ''),
(31, 1, 'admin', 'dodanie produktu Ozdoby weselne - serca', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 19:52:32', ''),
(32, 1, 'admin', 'edycja produktu Ozdoby weselne - serca', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 19:53:01', ''),
(33, 1, 'admin', 'edycja produktu Ozdoby weselne - serca', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 19:53:10', ''),
(34, 1, 'admin', 'dodanie produktu Ozdoby weselne - kwiaty', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 19:54:20', ''),
(35, 1, 'admin', 'poprawne zalogowanie', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 19:57:37', 'log'),
(36, 1, 'admin', 'dodanie produktu Ozdoby weselne - balony', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 19:58:50', ''),
(37, 1, 'admin', 'edycja produktu Ozdoby weselne - balony', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 19:59:06', ''),
(38, 1, 'admin', 'dodanie produktu Ozdoby weselne - balony', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 20:00:30', ''),
(39, 1, 'admin', 'poprawne zalogowanie', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 20:04:16', 'log'),
(40, 1, 'admin', 'struktura - edycja: Kontakt', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 20:05:32', ''),
(41, 1, 'admin', 'poprawne zalogowanie', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 20:08:12', 'log'),
(42, 1, 'admin', 'edycja produktu Ozdoby weselne - balony', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 20:08:39', ''),
(43, 1, 'admin', 'edycja produktu Ozdoby weselne - serca', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 20:09:27', ''),
(44, 1, 'admin', 'poprawne zalogowanie', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 20:12:18', 'log'),
(45, 1, 'admin', 'dodanie produktu Ozdoba weselna - balony sufit', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 20:15:51', ''),
(46, 1, 'admin', 'dodanie produktu Ozdoba weselna - balony dla Pary', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 20:17:03', ''),
(47, 1, 'admin', 'dodanie produktu Koszyk ozodobny', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 20:17:48', ''),
(48, 1, 'admin', 'edycja produktu Koszyk ozodobny', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 20:18:06', ''),
(49, 1, 'admin', 'edycja produktu Ozdoby weselne - kwiaty', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 20:18:38', ''),
(50, 1, 'admin', 'struktura - edycja: Wyprzedaże', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 20:19:15', ''),
(51, 1, 'admin', 'struktura - dodawanie: Ozdoby wielkanocne', '77.112.148.35', 'apn-77-112-148-35.dynamic.gprs.plus.pl', '2010-03-09 20:20:20', ''),
(52, 1, 'admin', 'poprawne zalogowanie', '77.114.215.148', 'apn-77-114-215-148.dynamic.gprs.plus.pl', '2010-03-09 20:51:22', 'log'),
(53, 1, 'admin', 'struktura - dodawanie: Ozodby jakieś', '77.114.215.148', 'apn-77-114-215-148.dynamic.gprs.plus.pl', '2010-03-09 20:52:17', ''),
(54, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-10 07:43:16', 'log'),
(55, 1, 'admin', 'struktura - edycja: O Firmie', '83.17.15.234', 'waran.pl', '2010-03-10 07:43:37', ''),
(56, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-10 07:44:39', 'log'),
(57, 1, 'admin', 'artykuł - dodawanie akapitu: O Firmie', '83.17.15.234', 'waran.pl', '2010-03-10 07:45:15', ''),
(58, 1, 'admin', 'struktura - edycja: O Firmie', '83.17.15.234', 'waran.pl', '2010-03-10 07:45:26', ''),
(59, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-10 07:46:34', 'log'),
(60, 1, 'admin', 'artykuł - edycja akapitu: Z nami udekorujesz każdą okazję...', '83.17.15.234', 'waran.pl', '2010-03-10 07:47:11', ''),
(61, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-10 07:49:00', 'log'),
(62, 1, 'admin', 'struktura - edycja: Kontakt', '83.17.15.234', 'waran.pl', '2010-03-10 07:50:14', ''),
(63, 1, 'admin', 'struktura - edycja: Kontakt', '83.17.15.234', 'waran.pl', '2010-03-10 07:50:47', ''),
(64, 1, 'admin', 'edycja produktu Koszyk ozodobny', '83.17.15.234', 'waran.pl', '2010-03-10 07:52:20', ''),
(65, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-10 08:33:48', 'log'),
(66, 1, 'admin', 'artykuł - edycja akapitu: O Firmie', '83.17.15.234', 'waran.pl', '2010-03-10 08:35:35', ''),
(67, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-10 08:43:24', 'log'),
(68, 1, 'admin', 'edycja produktu Ozdoba weselna - balony dla Pary', '83.17.15.234', 'waran.pl', '2010-03-10 08:44:08', ''),
(69, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-10 09:06:36', 'log'),
(70, 1, 'admin', 'Wylogowanie', '83.17.15.234', 'waran.pl', '2010-03-10 09:08:15', 'wylog'),
(71, 1, 'admin', 'poprawne zalogowanie', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 12:19:14', 'log'),
(72, 1, 'admin', 'struktura - edycja: Nowości', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 12:19:33', ''),
(73, 1, 'admin', 'konfiguracja - zmiana danych', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 12:22:39', ''),
(74, 1, 'admin', 'poprawne zalogowanie', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 15:03:53', 'log'),
(75, 1, 'admin', 'struktura - edycja: Wesela śluby', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 15:04:46', ''),
(76, 1, 'admin', 'struktura - edycja: Wesela śluby', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 15:10:23', ''),
(77, 1, 'admin', 'struktura - dodawanie: Dekoracje kościołów', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 15:13:53', ''),
(78, 1, 'admin', 'struktura - dodawanie: Dekoracje sal', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 15:14:08', ''),
(79, 1, 'admin', 'struktura - dodawanie: Dekoracje samochodów', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 15:14:23', ''),
(80, 1, 'admin', 'struktura - edycja: Dekoracje kościołów', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 15:28:21', ''),
(81, 1, 'admin', 'struktura - edycja: Dekoracje sal', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 15:28:38', ''),
(82, 1, 'admin', 'struktura - edycja: Dekoracje samochodów', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 15:28:53', ''),
(83, 1, 'admin', 'struktura - edycja: Dekoracje kościołów', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 16:21:03', ''),
(84, 1, 'admin', 'struktura - edycja: Dekoracje sal', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 16:21:13', ''),
(85, 1, 'admin', 'struktura - edycja: Dekoracje samochodów', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 16:21:22', ''),
(86, 1, 'admin', 'struktura - edycja: Wesela śluby', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 16:35:42', ''),
(87, 1, 'admin', 'struktura - dodawanie: Z nami udekorujesz każdą okazję...', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 16:37:30', ''),
(88, 1, 'admin', 'artykuł - dodawanie akapitu: Z nami udekorujesz każdą okazję...', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 16:41:34', ''),
(89, 1, 'admin', 'artykuł - dodawanie akapitu: Z nami udekorujesz każdą okazję...', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 16:42:26', ''),
(90, 1, 'admin', 'artykuł: usuwanie akapitów', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 16:42:34', ''),
(91, 1, 'admin', 'struktura - edycja: Wesela śluby', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 16:43:21', ''),
(92, 1, 'admin', 'struktura - edycja: Wesela śluby', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 16:52:08', ''),
(93, 1, 'admin', 'artykuł - edycja akapitu: Z nami udekorujesz każdą okazję...', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 16:53:38', ''),
(94, 1, 'admin', 'artykuł - edycja akapitu: Z nami udekorujesz każdą okazję...', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 16:53:46', ''),
(95, 1, 'admin', 'Wylogowanie', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 16:54:18', 'wylog'),
(96, 1, 'admin', 'poprawne zalogowanie', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 17:09:31', 'log'),
(97, 1, 'admin', 'artykuł - edycja akapitu: Z nami udekorujesz każdą okazję...', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 17:09:51', ''),
(98, 1, 'admin', 'artykuł - edycja akapitu: Z nami udekorujesz każdą okazję...', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 17:10:33', ''),
(99, 1, 'admin', 'artykuł - edycja akapitu: Z nami udekorujesz każdą okazję...', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 17:10:48', ''),
(100, 1, 'admin', 'artykuł - edycja akapitu: Z nami udekorujesz każdą okazję...', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 17:10:58', ''),
(101, 1, 'admin', 'Wylogowanie', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 17:11:09', 'wylog'),
(102, 1, 'admin', 'poprawne zalogowanie', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 17:14:12', 'log'),
(103, 1, 'admin', 'poprawne zalogowanie', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 22:11:51', 'log'),
(104, 1, 'admin', 'struktura - edycja: Z nami udekorujesz każdą okazję...', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 22:12:33', ''),
(105, 1, 'admin', 'struktura - edycja: Wesela śluby', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 22:13:15', ''),
(106, 1, 'admin', 'struktura - edycja: Z nami udekorujesz każdą okazję...', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 22:17:28', ''),
(107, 1, 'admin', 'artykuł - edycja akapitu: Z nami udekorujesz każdą okazję...', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 22:18:18', ''),
(108, 1, 'admin', 'Wylogowanie', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 22:18:22', 'wylog'),
(109, 0, '', 'Wylogowanie', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 22:30:53', 'wylog'),
(110, 1, 'admin', 'poprawne zalogowanie', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 22:30:58', 'log'),
(111, 1, 'admin', 'struktura - dodawanie: test1', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 22:31:13', ''),
(112, 1, 'admin', 'struktura - dodawanie: test 2', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 22:31:20', ''),
(113, 1, 'admin', 'sklepykuły - usuwanie', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 22:34:08', ''),
(114, 1, 'admin', 'sklepykuły - usuwanie', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 22:34:10', ''),
(115, 1, 'admin', 'poprawne zalogowanie', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 22:39:26', 'log'),
(116, 1, 'admin', 'struktura - dodawanie: Salony firmowe', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 22:39:40', ''),
(117, 1, 'admin', 'Wylogowanie', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-10 22:47:46', 'wylog'),
(118, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-11 10:46:21', 'log'),
(119, 1, 'admin', 'struktura - edycja: Kontakt', '83.17.15.234', 'waran.pl', '2010-03-11 10:48:54', ''),
(120, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-11 10:51:36', 'log'),
(121, 1, 'admin', 'struktura - edycja: Salony firmowe', '83.17.15.234', 'waran.pl', '2010-03-11 10:54:39', ''),
(122, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-11 10:55:30', 'log'),
(123, 1, 'admin', 'struktura - dodawanie: Luminar Toruń', '83.17.15.234', 'waran.pl', '2010-03-11 10:56:38', ''),
(124, 1, 'admin', 'struktura - edycja: Luminar Toruń', '83.17.15.234', 'waran.pl', '2010-03-11 10:56:55', ''),
(125, 1, 'admin', 'struktura - edycja: Salony firmowe', '83.17.15.234', 'waran.pl', '2010-03-11 10:57:09', ''),
(126, 1, 'admin', 'Wylogowanie', '83.17.15.234', 'waran.pl', '2010-03-11 10:57:13', 'wylog'),
(127, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-11 10:58:04', 'log'),
(128, 1, 'admin', 'struktura - edycja: Luminar Toruń', '83.17.15.234', 'waran.pl', '2010-03-11 10:59:44', ''),
(129, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-11 15:08:02', 'log'),
(130, 1, 'admin', 'rotator - usuwanie', '83.17.15.234', 'waran.pl', '2010-03-11 15:11:32', ''),
(131, 1, 'admin', 'poprawne zalogowanie', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-11 18:02:45', 'log'),
(132, 1, 'admin', 'artykuł - edycja akapitu: Z nami udekorujesz każdą okazję...', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-11 18:04:05', ''),
(133, 1, 'admin', 'Wylogowanie', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-11 18:04:11', 'wylog'),
(134, 1, 'admin', 'poprawne zalogowanie', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-11 18:04:31', 'log'),
(135, 1, 'admin', 'artykuł - edycja akapitu: Z nami udekorujesz każdą okazję...', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-11 18:04:49', ''),
(136, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-12 14:56:42', 'log'),
(137, 1, 'admin', 'edycja produktu Ozdoby weselne - kwiaty', '83.17.15.234', 'waran.pl', '2010-03-12 14:57:23', ''),
(138, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-12 14:59:52', 'log'),
(139, 1, 'admin', 'artykuł - edycja akapitu: O Firmie', '83.17.15.234', 'waran.pl', '2010-03-12 15:01:49', ''),
(140, 1, 'admin', 'struktura - edycja: Luminar Toruń', '83.17.15.234', 'waran.pl', '2010-03-12 15:02:27', ''),
(141, 1, 'admin', 'artykuły - usuwanie', '83.17.15.234', 'waran.pl', '2010-03-12 15:02:37', ''),
(142, 1, 'admin', 'artykuł - dodawanie akapitu: Salony firmowe', '83.17.15.234', 'waran.pl', '2010-03-12 15:02:47', ''),
(143, 1, 'admin', 'Wylogowanie', '83.17.15.234', 'waran.pl', '2010-03-12 15:02:54', 'wylog'),
(144, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-12 15:03:30', 'log'),
(145, 1, 'admin', 'artykuł - edycja akapitu: Salony firmowe', '83.17.15.234', 'waran.pl', '2010-03-12 15:08:52', ''),
(146, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-12 15:09:47', 'log'),
(147, 1, 'admin', 'artykuł - edycja akapitu: Salony firmowe', '83.17.15.234', 'waran.pl', '2010-03-12 15:10:16', ''),
(148, 1, 'admin', 'edycja konta - admin', '83.17.15.234', 'waran.pl', '2010-03-12 15:11:40', ''),
(149, 1, 'admin', 'poprawne zalogowanie', '77.115.78.224', 'apn-77-115-78-224.dynamic.gprs.plus.pl', '2010-03-12 21:42:41', 'log'),
(150, 1, 'admin', 'błąd logowania - nieprawidłowe hasło', '95.41.81.116', 'apn-95-41-81-116.dynamic.gprs.plus.pl', '2010-03-13 13:42:14', 'b_log'),
(151, 1, 'admin', 'poprawne zalogowanie', '95.41.81.116', 'apn-95-41-81-116.dynamic.gprs.plus.pl', '2010-03-13 13:42:21', 'log'),
(152, 1, 'admin', 'struktura - dodawanie: Balony lateksowe', '95.41.81.116', 'apn-95-41-81-116.dynamic.gprs.plus.pl', '2010-03-13 13:54:08', ''),
(153, 1, 'admin', 'poprawne zalogowanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 09:29:39', 'log'),
(154, 1, 'admin', 'poprawne zalogowanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 09:33:10', 'log'),
(155, 1, 'admin', 'dodanie konta - admin: luminar', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 10:12:16', ''),
(156, 1, 'admin', 'użytkownicy zmiana uprawnień: luminar', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 10:29:35', ''),
(157, 1, 'admin', 'Wylogowanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 10:30:53', 'wylog'),
(158, 30, 'Luminar', 'poprawne zalogowanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 10:31:06', 'log'),
(159, 30, 'luminar', 'edycja konta - własne', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 10:31:13', ''),
(160, 30, 'luminar', 'Wylogowanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 10:31:15', 'wylog'),
(161, 30, 'Luminar', 'poprawne zalogowanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 10:31:25', 'log'),
(162, 30, 'luminar', 'Wylogowanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 10:31:37', 'wylog'),
(163, 30, 'Luminar', 'poprawne zalogowanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 10:31:44', 'log'),
(164, 30, 'luminar', 'Wylogowanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 10:32:35', 'wylog'),
(165, 1, 'admin', 'poprawne zalogowanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 10:32:45', 'log'),
(166, 1, 'admin', 'konfiguracja - zmiana danych', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 10:47:33', ''),
(167, 1, 'admin', 'struktura - dodawanie: Super promocje', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 11:06:55', ''),
(168, 1, 'admin', 'artykuły - usuwanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 11:07:19', ''),
(169, 1, 'admin', 'struktura - dodawanie: Wyprzedaż sezonowa', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 11:27:48', ''),
(170, 1, 'admin', 'struktura - edycja: Wyprzedaż sezonowa', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 11:39:45', ''),
(171, 1, 'admin', 'struktura - edycja: Wyprzedaż sezonowa', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 11:40:53', ''),
(172, 1, 'admin', 'struktura - edycja: Wyprzedaż sezonowa', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 11:41:22', ''),
(173, 1, 'admin', 'artykuł - dodawanie akapitu: Wyprzedaż sezonowa', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 11:41:52', ''),
(174, 1, 'admin', 'poprawne zalogowanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 11:46:27', 'log'),
(175, 1, 'admin', 'artykuł - edycja akapitu: O Firmie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 12:18:24', ''),
(176, 1, 'admin', 'poprawne zalogowanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 12:21:26', 'log'),
(177, 1, 'admin', 'artykuł - edycja akapitu: O Firmie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 12:22:04', ''),
(178, 1, 'admin', 'artykuł - edycja akapitu: O Firmie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 12:22:12', ''),
(179, 1, 'admin', 'artykuł - edycja akapitu: O Firmie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 12:31:43', ''),
(180, 1, 'admin', 'artykuł - dodawanie akapitu: Kontakt', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 12:40:42', ''),
(181, 1, 'admin', 'artykuł - edycja akapitu: Kontakt', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 12:41:06', ''),
(182, 1, 'admin', 'struktura - edycja: Kontakt', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 12:41:19', ''),
(183, 1, 'admin', 'poprawne zalogowanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 12:43:04', 'log'),
(184, 1, 'admin', 'artykuł - edycja akapitu: Kontakt', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 12:44:37', ''),
(185, 1, 'admin', 'artykuły - usuwanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 12:47:41', ''),
(186, 1, 'admin', 'rotator - usuwanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 13:05:22', ''),
(187, 1, 'admin', 'struktura - dodawanie: Dekoracja aut - studniówka', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 13:54:03', ''),
(188, 1, 'admin', 'sklepykuły - usuwanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 13:56:35', ''),
(189, 1, 'admin', 'sklepykuły - usuwanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 13:57:09', ''),
(190, 1, 'admin', 'struktura - dodawanie: Ozdoby wielkanocne', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 14:28:38', ''),
(191, 1, 'admin', 'struktura - dodawanie: Ozdoby wielkanocne na słół', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 14:30:45', ''),
(192, 1, 'admin', 'dodanie produktu Koszyk świąteczny', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 14:32:50', ''),
(193, 1, 'admin', 'struktura - dodawanie: Ozdoby wielkanocne podwieszane', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 14:33:57', ''),
(194, 1, 'admin', 'dodanie produktu Koszyk świąteczny  podwieszany', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 14:34:48', ''),
(195, 1, 'admin', 'struktura - edycja: Ozdoby wielkanocne', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 14:36:13', ''),
(196, 1, 'admin', 'edycja produktu Koszyk świąteczny', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 14:50:18', ''),
(197, 1, 'admin', 'sklepykuły - usuwanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 14:52:38', ''),
(198, 1, 'admin', 'struktura - dodawanie: Ozdoby wielkanocne na słół', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 15:24:27', ''),
(199, 1, 'admin', 'struktura - edycja: Ozdoby wielkanocne na słół', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 15:29:43', ''),
(200, 1, 'admin', 'sklepykuły - usuwanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 15:30:00', ''),
(201, 1, 'admin', 'struktura - dodawanie: Ozdoby wielkanocne na słół', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 15:30:13', ''),
(202, 1, 'admin', 'dodanie produktu Koszyk świąteczny', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 15:45:09', ''),
(203, 1, 'admin', 'edycja produktu Koszyk świąteczny', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 15:46:58', ''),
(204, 1, 'admin', 'edycja produktu Koszyk świąteczny', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 15:51:18', ''),
(205, 1, 'admin', 'edycja produktu Koszyk świąteczny', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 15:57:32', ''),
(206, 1, 'admin', 'produkty - usuwanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 15:57:40', ''),
(207, 1, 'admin', 'dodanie produktu Koszyk świąteczny', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 15:57:59', ''),
(208, 1, 'admin', 'edycja produktu Koszyk świąteczny', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 15:58:27', ''),
(209, 1, 'admin', 'edycja produktu Koszyk świąteczny', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 16:18:01', ''),
(210, 1, 'admin', 'poprawne zalogowanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 16:47:21', 'log'),
(211, 1, 'admin', 'artykuł - edycja akapitu: Salony firmowe', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 17:03:03', ''),
(212, 1, 'admin', 'artykuł - edycja akapitu: Salony firmowe', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 17:19:10', ''),
(213, 1, 'admin', 'artykuł - edycja akapitu: Z nami udekorujesz każdą okazję...', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 17:32:50', ''),
(214, 1, 'admin', 'błąd logowania - nieprawidłowe hasło', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 17:33:57', 'b_log'),
(215, 1, 'admin', 'poprawne zalogowanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 17:34:14', 'log'),
(216, 1, 'admin', 'struktura - edycja: Home', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 17:37:25', ''),
(217, 1, 'admin', 'struktura - edycja: Z nami udekorujesz każdą okazję...', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 17:38:43', ''),
(218, 1, 'admin', 'artykuł - edycja akapitu: Z nami udekorujesz każdą okazję...', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 17:40:43', ''),
(219, 1, 'admin', 'artykuł - edycja akapitu: Z nami udekorujesz każdą okazję...', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 17:42:40', ''),
(220, 1, 'admin', 'poprawne zalogowanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 17:45:00', 'log'),
(221, 1, 'admin', 'poprawne zalogowanie', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 18:16:57', 'log'),
(222, 1, 'admin', 'struktura - edycja: Z nami udekorujesz każdą okazję...+++', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 18:29:00', ''),
(223, 1, 'admin', 'struktura - edycja: Z nami udekorujesz każdą okazję...', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 18:29:15', ''),
(224, 0, '', 'Wylogowanie', '95.41.245.44', 'apn-95-41-245-44.dynamic.gprs.plus.pl', '2010-03-14 19:25:45', 'wylog'),
(225, 1, 'admin', 'poprawne zalogowanie', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-15 17:20:38', 'log'),
(226, 1, 'admin', 'struktura - edycja: Kontakt', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-15 17:30:32', ''),
(227, 1, 'admin', 'struktura - edycja: Kontakt', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-15 17:33:15', ''),
(228, 1, 'admin', 'struktura - edycja: Kontakt', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-15 17:34:31', ''),
(229, 1, 'admin', 'struktura - edycja: Kontakt', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-15 17:34:49', ''),
(230, 1, 'admin', 'struktura - edycja: Kontakt', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-15 17:35:17', ''),
(231, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-16 07:35:17', 'log'),
(232, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-16 07:39:54', 'log'),
(233, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-16 07:43:31', 'log'),
(234, 1, 'admin', 'struktura - dodawanie: Ozdoby wielkanocne podwieszane', '83.17.15.234', 'waran.pl', '2010-03-16 07:43:53', ''),
(235, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-16 07:48:08', 'log'),
(236, 1, 'admin', 'struktura - dodawanie: Chrzest dekoracja stołu', '83.17.15.234', 'waran.pl', '2010-03-16 07:49:17', ''),
(237, 1, 'admin', 'struktura - dodawanie: Dekoracja mieszkania lub domu', '83.17.15.234', 'waran.pl', '2010-03-16 07:50:12', ''),
(238, 1, 'admin', 'struktura - dodawanie: Dekoracje na stół', '83.17.15.234', 'waran.pl', '2010-03-16 07:50:31', ''),
(239, 1, 'admin', 'struktura - dodawanie: Dekoracja mieszkania lub domu', '83.17.15.234', 'waran.pl', '2010-03-16 07:50:41', ''),
(240, 1, 'admin', 'struktura - dodawanie: Dekoracje na stół', '83.17.15.234', 'waran.pl', '2010-03-16 07:50:49', ''),
(241, 1, 'admin', 'struktura - dodawanie: Dekoracja mieszkania lub domu', '83.17.15.234', 'waran.pl', '2010-03-16 07:50:55', ''),
(242, 1, 'admin', 'struktura - dodawanie: Dekoracja niespodzianka', '83.17.15.234', 'waran.pl', '2010-03-16 07:51:22', ''),
(243, 1, 'admin', 'struktura - dodawanie: Akcesoria dekoratorskie', '83.17.15.234', 'waran.pl', '2010-03-16 07:52:21', ''),
(244, 1, 'admin', 'dodanie produktu Obciążnik do balonów, Dwa serca czerwone, 1 szt.', '83.17.15.234', 'waran.pl', '2010-03-16 07:55:05', ''),
(245, 1, 'admin', 'edycja produktu Obciążnik do balonów, Dwa serca czerwone, 1 szt.', '83.17.15.234', 'waran.pl', '2010-03-16 07:58:37', ''),
(246, 1, 'admin', 'edycja produktu Obciążnik do balonów, Dwa serca czerwone, 1 szt.', '83.17.15.234', 'waran.pl', '2010-03-16 07:59:01', ''),
(247, 1, 'admin', 'edycja produktu Obciążnik do balonów, Dwa serca czerwone, 1 szt.', '83.17.15.234', 'waran.pl', '2010-03-16 07:59:21', ''),
(248, 1, 'admin', 'edycja produktu Obciążnik do balonów, Dwa serca czerwone, 1 szt.', '83.17.15.234', 'waran.pl', '2010-03-16 07:59:24', ''),
(249, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-16 14:41:38', 'log'),
(250, 1, 'admin', 'edycja produktu Koszyk ozodobny', '83.17.15.234', 'waran.pl', '2010-03-16 14:48:21', ''),
(251, 1, 'admin', 'edycja produktu Ozdoby weselne - balony', '83.17.15.234', 'waran.pl', '2010-03-16 14:49:38', ''),
(252, 1, 'admin', 'dodanie produktu Baloniki dmuchane i podwieszane', '83.17.15.234', 'waran.pl', '2010-03-16 14:52:35', ''),
(253, 1, 'admin', 'poprawne zalogowanie', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-16 16:29:05', 'log'),
(254, 1, 'admin', 'rotator - usuwanie', '86.111.100.90', 'host-86-111-100-90.tvk.torun.pl', '2010-03-16 16:43:58', ''),
(255, 1, 'admin', 'poprawne zalogowanie', '77.115.240.119', 'apn-77-115-240-119.dynamic.gprs.plus.pl', '2010-03-16 23:49:45', 'log'),
(256, 1, 'admin', 'artykuł - edycja akapitu: O Firmie', '77.115.240.119', 'apn-77-115-240-119.dynamic.gprs.plus.pl', '2010-03-17 00:05:14', ''),
(257, 1, 'admin', 'artykuł - edycja akapitu: O Firmie', '77.115.240.119', 'apn-77-115-240-119.dynamic.gprs.plus.pl', '2010-03-17 00:06:19', ''),
(258, 1, 'admin', 'artykuł - edycja akapitu: O Firmie', '77.115.240.119', 'apn-77-115-240-119.dynamic.gprs.plus.pl', '2010-03-17 00:07:17', ''),
(259, 1, 'admin', 'Wylogowanie', '77.115.240.119', 'apn-77-115-240-119.dynamic.gprs.plus.pl', '2010-03-17 00:07:52', 'wylog'),
(260, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-17 12:51:46', 'log'),
(261, 1, 'admin', 'poprawne zalogowanie', '77.113.111.93', 'apn-77-113-111-93.dynamic.gprs.plus.pl', '2010-03-17 14:17:05', 'log'),
(262, 1, 'admin', 'dodanie konta - admin: robert', '77.113.111.93', 'apn-77-113-111-93.dynamic.gprs.plus.pl', '2010-03-17 14:19:34', ''),
(263, 1, 'admin', 'użytkownicy - usuwanie konta (id:31)', '77.113.111.93', 'apn-77-113-111-93.dynamic.gprs.plus.pl', '2010-03-17 14:20:05', ''),
(264, 1, 'admin', 'struktura - dodawanie: ozdoby', '77.113.111.93', 'apn-77-113-111-93.dynamic.gprs.plus.pl', '2010-03-17 14:30:54', ''),
(265, 1, 'admin', 'poprawne zalogowanie', '77.113.111.93', 'apn-77-113-111-93.dynamic.gprs.plus.pl', '2010-03-17 14:32:06', 'log'),
(266, 1, 'admin', 'dodanie produktu szyky 123', '77.113.111.93', 'apn-77-113-111-93.dynamic.gprs.plus.pl', '2010-03-17 14:35:32', ''),
(267, 1, 'admin', 'produkty - usuwanie', '77.113.111.93', 'apn-77-113-111-93.dynamic.gprs.plus.pl', '2010-03-17 14:36:52', ''),
(268, 1, 'admin', 'artykuł - edycja akapitu: O Firmie', '77.113.111.93', 'apn-77-113-111-93.dynamic.gprs.plus.pl', '2010-03-17 14:38:32', ''),
(269, 1, 'admin', 'rotator - usuwanie', '77.113.111.93', 'apn-77-113-111-93.dynamic.gprs.plus.pl', '2010-03-17 14:40:46', ''),
(270, 1, 'admin', 'rotator - usuwanie', '77.113.111.93', 'apn-77-113-111-93.dynamic.gprs.plus.pl', '2010-03-17 14:41:47', ''),
(271, 1, 'admin', 'poprawne zalogowanie', '77.113.111.93', 'apn-77-113-111-93.dynamic.gprs.plus.pl', '2010-03-17 15:00:32', 'log'),
(272, 1, 'admin', 'edycja produktu Koszyk świąteczny', '77.113.111.93', 'apn-77-113-111-93.dynamic.gprs.plus.pl', '2010-03-17 15:01:35', ''),
(273, 1, 'admin', 'poprawne zalogowanie', '77.112.73.193', 'apn-77-112-73-193.dynamic.gprs.plus.pl', '2010-03-17 23:16:08', 'log'),
(274, 1, 'admin', 'Wylogowanie', '77.112.73.193', 'apn-77-112-73-193.dynamic.gprs.plus.pl', '2010-03-17 23:18:55', 'wylog'),
(275, 1, 'admin', 'poprawne zalogowanie', '77.112.73.193', 'apn-77-112-73-193.dynamic.gprs.plus.pl', '2010-03-17 23:21:06', 'log'),
(276, 1, 'admin', 'artykuł - edycja akapitu: Salony firmowe', '77.112.73.193', 'apn-77-112-73-193.dynamic.gprs.plus.pl', '2010-03-17 23:26:57', ''),
(277, 1, 'admin', 'Wylogowanie', '77.112.73.193', 'apn-77-112-73-193.dynamic.gprs.plus.pl', '2010-03-17 23:30:00', 'wylog'),
(278, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-18 07:45:10', 'log'),
(279, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-18 10:52:07', 'log'),
(280, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-18 13:36:18', 'log'),
(281, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-18 16:05:05', 'log'),
(282, 1, 'admin', 'edycja produktu Ozdoba jaja', '83.17.15.234', 'waran.pl', '2010-03-18 16:07:33', ''),
(283, 1, 'admin', 'edycja produktu Ozdoba jaja', '83.17.15.234', 'waran.pl', '2010-03-18 16:10:07', ''),
(284, 1, 'admin', 'poprawne zalogowanie', '83.17.15.234', 'waran.pl', '2010-03-18 16:12:15', 'log'),
(285, 1, 'admin', 'poprawne zalogowanie', '77.115.72.180', 'apn-77-115-72-180.dynamic.gprs.plus.pl', '2010-03-19 23:04:27', 'log'),
(286, 1, 'admin', 'Wylogowanie', '77.115.72.180', 'apn-77-115-72-180.dynamic.gprs.plus.pl', '2010-03-19 23:13:36', 'wylog');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_poczta`
--

CREATE TABLE `luminar_poczta` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_autor` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `autor` varchar(150) NOT NULL,
  `id_odb` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `odb` varchar(150) NOT NULL,
  `tytul` varchar(200) NOT NULL DEFAULT '',
  `tresc` text NOT NULL,
  `data_wys` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_odczyt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_odp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_usuniecia` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `id_wys` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_odp` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `systemowa` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `wykonana` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `typ` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `zdefiniowana` smallint(4) UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_rotator`
--

CREATE TABLE `luminar_rotator` (
  `id` int(12) UNSIGNED NOT NULL,
  `id_typ` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `link` text NOT NULL,
  `tytul` varchar(250) NOT NULL,
  `opis` text NOT NULL,
  `priorytet` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `udzial` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `licznik` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `licznik_limit` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `czy_licznik` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `klik` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `klik_limit` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `czy_klik` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `data_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa` varchar(200) NOT NULL,
  `img_nazwa_oryginal` varchar(200) NOT NULL,
  `img_w` smallint(4) NOT NULL DEFAULT '0',
  `img_h` smallint(4) NOT NULL DEFAULT '0',
  `swf_wersja` smallint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_tlo` varchar(6) NOT NULL DEFAULT '',
  `img_link` varchar(250) NOT NULL DEFAULT '',
  `link_okno` varchar(50) NOT NULL DEFAULT '',
  `lang` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `luminar_rotator`
--

INSERT INTO `luminar_rotator` (`id`, `id_typ`, `autor_id`, `autor_name`, `autor_kiedy`, `edytor_id`, `edytor_name`, `edytor_kiedy`, `link`, `tytul`, `opis`, `priorytet`, `udzial`, `licznik`, `licznik_limit`, `czy_licznik`, `klik`, `klik_limit`, `czy_klik`, `data_start`, `data_stop`, `img`, `img_nazwa`, `img_nazwa_oryginal`, `img_w`, `img_h`, `swf_wersja`, `img_tlo`, `img_link`, `link_okno`, `lang`, `status`) VALUES
(1, 1, 1, 'admin', '2010-03-08 23:16:31', 1, 'admin', '2010-03-14 13:09:41', '', 'Zdjecie w oknie \"Salony firmowe\"', '', 0, 1, 0, 0, 0, 0, 0, 0, '2010-03-08 23:16:00', '2011-03-31 13:00:00', 2, '1_352c841809ad4817524d1a3bc170301f.jpg', 'baner_otwarcie.jpg', 188, 125, 0, 'ffffff', 'index.php?akcja=art_zobacz&amp;art_idtf=salony', '', 0, 1),
(6, 3, 1, 'admin', '2010-03-18 16:12:54', 1, 'admin', '2010-03-19 23:11:52', '', 'TOP BANER', '', 0, 1, 0, 0, 0, 0, 0, 0, '2010-03-18 16:12:00', '0000-00-00 00:00:00', 2, '6_01cf80be063401116d9cbdba4f8b2483.jpg', 'gallery8425mamcie.jpg', 225, 178, 0, 'ffffff', '', '', 0, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_sklep_kat`
--

CREATE TABLE `luminar_sklep_kat` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_d` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_pierwszy` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `poziom` int(5) NOT NULL,
  `nr_poz` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `tytul` varchar(200) NOT NULL DEFAULT '',
  `tytul_menu` varchar(200) NOT NULL,
  `podtytul` text NOT NULL,
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(200) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(11) UNSIGNED NOT NULL,
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(11) NOT NULL,
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `licznik` mediumint(7) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `lang` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `menu_wyr` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `idtf_link` varchar(100) NOT NULL,
  `description` varchar(250) NOT NULL,
  `keywords` varchar(250) NOT NULL,
  `title` varchar(200) NOT NULL,
  `typ` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `link` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `luminar_sklep_kat`
--

INSERT INTO `luminar_sklep_kat` (`id`, `id_d`, `id_matka`, `id_pierwszy`, `poziom`, `nr_poz`, `tytul`, `tytul_menu`, `podtytul`, `img`, `img_nazwa_oryginal`, `img1_nazwa`, `img1_w`, `img1_h`, `img2_nazwa`, `img2_w`, `img2_h`, `autor_id`, `autor_name`, `autor_kiedy`, `edytor_id`, `edytor_name`, `edytor_kiedy`, `data_start`, `data_stop`, `licznik`, `status`, `lang`, `menu_wyr`, `idtf_link`, `description`, `keywords`, `title`, `typ`, `link`) VALUES
(1, 1, 0, 0, 0, 1, 'Balony', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-08 21:00:46', 1, 'admin', '2010-03-09 19:45:28', '2010-03-08 21:00:00', '0000-00-00 00:00:00', 196, 1, 1, 0, 'balony-biale', '', '', '', 1, ''),
(2, 1, 0, 0, 0, 2, 'Wesela śluby', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-08 21:00:59', 1, 'admin', '2010-03-10 22:13:15', '2010-03-08 21:00:00', '0000-00-00 00:00:00', 27, 1, 1, 0, '', '', '', '', 0, 'index.php?akcja=sklep_wesela&amp;id_kat=2'),
(3, 1, 0, 0, 0, 3, 'Chrzest', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-08 21:01:08', 0, '', '0000-00-00 00:00:00', '2010-03-08 21:01:00', '0000-00-00 00:00:00', 230, 1, 1, 0, '', '', '', '', 1, ''),
(4, 1, 0, 0, 0, 4, 'Narodziny, roczek', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-08 21:01:22', 0, '', '0000-00-00 00:00:00', '2010-03-08 21:01:00', '0000-00-00 00:00:00', 169, 1, 1, 0, '', '', '', '', 1, ''),
(5, 1, 0, 0, 0, 5, 'Komunia', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-08 21:01:30', 0, '', '0000-00-00 00:00:00', '2010-03-08 21:01:00', '0000-00-00 00:00:00', 145, 1, 1, 0, '', '', '', '', 1, ''),
(6, 1, 0, 0, 0, 6, 'Urodziny, imieniny', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-08 21:01:48', 0, '', '0000-00-00 00:00:00', '2010-03-08 21:01:00', '0000-00-00 00:00:00', 128, 1, 1, 0, '', '', '', '', 1, ''),
(7, 1, 0, 0, 0, 7, 'Boże narodzenie', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-08 21:01:59', 0, '', '0000-00-00 00:00:00', '2010-03-08 21:01:00', '0000-00-00 00:00:00', 113, 1, 1, 0, '', '', '', '', 1, ''),
(8, 1, 0, 0, 0, 8, 'Sylwester', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-08 21:02:09', 0, '', '0000-00-00 00:00:00', '2010-03-08 21:02:00', '0000-00-00 00:00:00', 139, 1, 1, 0, '', '', '', '', 1, ''),
(9, 1, 0, 0, 0, 9, 'Studniówka', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-08 21:02:18', 0, '', '0000-00-00 00:00:00', '2010-03-08 21:02:00', '0000-00-00 00:00:00', 115, 1, 1, 0, '', '', '', '', 1, ''),
(10, 1, 0, 0, 0, 10, 'Walentynki', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-08 21:02:26', 0, '', '0000-00-00 00:00:00', '2010-03-08 21:02:00', '0000-00-00 00:00:00', 110, 1, 1, 0, '', '', '', '', 1, ''),
(11, 1, 0, 0, 0, 11, 'Sprzęt dekoratorski', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-08 21:02:41', 0, '', '0000-00-00 00:00:00', '2010-03-08 21:02:00', '0000-00-00 00:00:00', 178, 1, 1, 0, '', '', '', '', 1, ''),
(21, 1, 0, 0, 0, 12, 'Ozdoby wielkanocne', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-14 14:28:38', 1, 'admin', '2010-03-14 14:36:13', '2010-03-14 14:14:00', '0000-00-00 00:00:00', 174, 1, 1, 0, '', '', '', '', 0, ''),
(14, 1, 2, 2, 1, 1, 'Dekoracje kościołów', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-10 15:13:53', 1, 'admin', '2010-03-10 16:21:03', '2010-03-10 15:13:00', '0000-00-00 00:00:00', 107, 1, 1, 0, '', '', '', '', 1, ''),
(15, 1, 2, 2, 1, 2, 'Dekoracje sal', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-10 15:14:08', 1, 'admin', '2010-03-10 16:21:13', '2010-03-10 15:14:00', '0000-00-00 00:00:00', 115, 1, 1, 0, '', '', '', '', 1, ''),
(16, 1, 2, 2, 1, 3, 'Dekoracje samochodów', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-10 15:14:23', 1, 'admin', '2010-03-10 16:21:22', '2010-03-10 15:14:00', '0000-00-00 00:00:00', 84, 1, 1, 0, '', '', '', '', 1, ''),
(19, 1, 1, 1, 1, 1, 'Balony lateksowe', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-13 13:54:08', 0, '', '0000-00-00 00:00:00', '2010-03-13 13:53:00', '0000-00-00 00:00:00', 64, 1, 1, 0, '', '', '', '', 1, ''),
(20, 1, 9, 9, 1, 1, 'Dekoracja aut - studniówka', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-14 13:54:03', 0, '', '0000-00-00 00:00:00', '2010-03-14 13:53:00', '0000-00-00 00:00:00', 49, 1, 1, 0, '', '', '', '', 1, ''),
(25, 1, 21, 21, 1, 1, 'Ozdoby wielkanocne na słół', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-14 15:30:13', 0, '', '0000-00-00 00:00:00', '2010-03-14 15:30:00', '0000-00-00 00:00:00', 102, 1, 1, 0, '', '', '', '', 1, ''),
(26, 1, 21, 21, 1, 2, 'Ozdoby wielkanocne podwieszane', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-16 07:43:53', 0, '', '0000-00-00 00:00:00', '2010-03-16 07:43:00', '0000-00-00 00:00:00', 84, 1, 1, 0, '', '', '', '', 1, ''),
(27, 1, 3, 3, 1, 1, 'Chrzest dekoracja stołu', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-16 07:49:17', 0, '', '0000-00-00 00:00:00', '2010-03-16 07:48:00', '0000-00-00 00:00:00', 228, 1, 1, 0, '', '', '', '', 1, ''),
(28, 1, 4, 4, 1, 1, 'Dekoracja mieszkania lub domu', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-16 07:50:12', 0, '', '0000-00-00 00:00:00', '2010-03-16 07:49:00', '0000-00-00 00:00:00', 75, 1, 1, 0, '', '', '', '', 1, ''),
(29, 1, 5, 5, 1, 1, 'Dekoracje na stół', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-16 07:50:31', 0, '', '0000-00-00 00:00:00', '2010-03-16 07:50:00', '0000-00-00 00:00:00', 61, 1, 1, 0, '', '', '', '', 1, ''),
(30, 1, 6, 6, 1, 1, 'Dekoracja mieszkania lub domu', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-16 07:50:41', 0, '', '0000-00-00 00:00:00', '2010-03-16 07:50:00', '0000-00-00 00:00:00', 47, 1, 1, 0, '', '', '', '', 1, ''),
(31, 1, 7, 7, 1, 1, 'Dekoracje na stół', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-16 07:50:49', 0, '', '0000-00-00 00:00:00', '2010-03-16 07:50:00', '0000-00-00 00:00:00', 51, 1, 1, 0, '', '', '', '', 1, ''),
(32, 1, 8, 8, 1, 1, 'Dekoracja mieszkania lub domu', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-16 07:50:55', 0, '', '0000-00-00 00:00:00', '2010-03-16 07:50:00', '0000-00-00 00:00:00', 90, 1, 1, 0, '', '', '', '', 1, ''),
(33, 1, 10, 10, 1, 1, 'Dekoracja niespodzianka', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-16 07:51:22', 0, '', '0000-00-00 00:00:00', '2010-03-16 07:50:00', '0000-00-00 00:00:00', 38, 1, 1, 0, '', '', '', '', 1, ''),
(34, 1, 11, 11, 1, 1, 'Akcesoria dekoratorskie', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-16 07:52:21', 0, '', '0000-00-00 00:00:00', '2010-03-16 07:52:00', '0000-00-00 00:00:00', 82, 1, 1, 0, '', '', '', '', 1, ''),
(35, 1, 21, 21, 1, 3, 'ozdoby', '', '', 0, '', '', 0, 0, '', 0, 0, 1, 'admin', '2010-03-17 14:30:53', 0, '', '0000-00-00 00:00:00', '2010-03-17 14:30:00', '0000-00-00 00:00:00', 80, 1, 1, 0, '', '', '', '', 1, '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_sklep_producenci`
--

CREATE TABLE `luminar_sklep_producenci` (
  `id` int(10) UNSIGNED NOT NULL,
  `nazwa` varchar(250) NOT NULL DEFAULT '',
  `opis` text NOT NULL,
  `link` varchar(250) NOT NULL,
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(200) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(11) UNSIGNED NOT NULL,
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(11) NOT NULL,
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `lang` smallint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_sklep_produkty`
--

CREATE TABLE `luminar_sklep_produkty` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_kat` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `id_producent` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `symbol` varchar(100) NOT NULL,
  `nazwa` varchar(250) NOT NULL,
  `nazwa_menu` varchar(250) NOT NULL,
  `zajawka` text NOT NULL,
  `opis` text NOT NULL,
  `link` varchar(250) NOT NULL,
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(200) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img3_w` smallint(4) NOT NULL DEFAULT '0',
  `img3_h` smallint(4) NOT NULL DEFAULT '0',
  `img3_nazwa` varchar(200) NOT NULL,
  `autor_id` int(11) UNSIGNED NOT NULL,
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(11) NOT NULL,
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `data_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `licznik` mediumint(7) UNSIGNED NOT NULL DEFAULT '0',
  `licznik_sprzedane` mediumint(7) NOT NULL DEFAULT '0',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `lang` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `idtf_link` varchar(100) NOT NULL,
  `description` varchar(250) NOT NULL,
  `keywords` varchar(250) NOT NULL,
  `title` varchar(200) NOT NULL,
  `priorytet` smallint(2) NOT NULL DEFAULT '0',
  `wyr` tinyint(1) NOT NULL DEFAULT '0',
  `wyr_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wyr_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nowosc` tinyint(4) NOT NULL DEFAULT '0',
  `nowosc_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `nowosc_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `promocja` tinyint(4) NOT NULL DEFAULT '0',
  `promocja_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `promocja_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wyprzedaz` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `wyprzedaz_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `wyprzedaz_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `polecamy` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `polecamy_start` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `polecamy_stop` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cena` float(10,2) NOT NULL DEFAULT '0.00',
  `vat` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `cena_skreslona` float(10,2) NOT NULL DEFAULT '0.00',
  `cena_promo` float(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `glosy` int(8) NOT NULL,
  `glosy_suma` int(11) NOT NULL,
  `glosy_srednia` float(8,2) NOT NULL,
  `waga` float(8,2) NOT NULL DEFAULT '0.00',
  `dostepnosc` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `dostepnosc_sztuk` int(10) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `luminar_sklep_produkty`
--

INSERT INTO `luminar_sklep_produkty` (`id`, `id_kat`, `id_producent`, `symbol`, `nazwa`, `nazwa_menu`, `zajawka`, `opis`, `link`, `img`, `img_nazwa_oryginal`, `img1_nazwa`, `img1_w`, `img1_h`, `img2_nazwa`, `img2_w`, `img2_h`, `img3_w`, `img3_h`, `img3_nazwa`, `autor_id`, `autor_name`, `autor_kiedy`, `edytor_id`, `edytor_name`, `edytor_kiedy`, `data_start`, `data_stop`, `licznik`, `licznik_sprzedane`, `status`, `lang`, `idtf_link`, `description`, `keywords`, `title`, `priorytet`, `wyr`, `wyr_start`, `wyr_stop`, `nowosc`, `nowosc_start`, `nowosc_stop`, `promocja`, `promocja_start`, `promocja_stop`, `wyprzedaz`, `wyprzedaz_start`, `wyprzedaz_stop`, `polecamy`, `polecamy_start`, `polecamy_stop`, `cena`, `vat`, `cena_skreslona`, `cena_promo`, `glosy`, `glosy_suma`, `glosy_srednia`, `waga`, `dostepnosc`, `dostepnosc_sztuk`) VALUES
(2, 15, 0, 'Ozdoby_wesela', 'Ozdoby weselne - serca', '', '<p>W związku z nadchodzącym sezonem ślubno-komunijnym prezentujemy Państwu artykuły, które szczególnie możemy polecić na tego typu okazje. Wszyskie z polecanych produktów można nabyć w tonacji biało-kremowej. Świetnie nadają się do dekoracji sali, kościoła czy samochodu.</p>', '<p>W związku z nadchodzącym sezonem ślubno-komunijnym prezentujemy Państwu artykuły, które szczególnie możemy polecić na tego typu okazje. Wszyskie z polecanych produktów można nabyć w tonacji biało-kremowej. Świetnie nadają się do dekoracji sali, kościoła czy samochodu.</p>', '', 2, 'gal_31.jpg', '2_img1_8349cd3881446e6cecf0f0eeb8dbb814.jpg', 500, 375, '2_img2_553a4f15807e4712d25aa198e93bde8a.jpg', 250, 187, 115, 86, '2_img3_04a5eae8566aeb468fe37296e79001b8.jpg', 1, 'admin', '2010-03-09 19:52:32', 1, 'admin', '2010-03-09 20:09:27', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 4, 0, 1, 1, '', '', '', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 54.00, 0, 0.00, 0.00, 0, 0, 0.00, 0.00, 0, 0),
(3, 14, 0, '', 'Ozdoby weselne - kwiaty', '', '<p>W związku z nadchodzącym sezonem ślubno-komunijnym prezentujemy Państwu artykuły, które szczególnie możemy polecić na tego typu okazje. Wszyskie z polecanych produktów można nabyć w tonacji biało-kremowej. Świetnie nadają się do dekoracji sali, kościoła czy samochodu.</p>', '<p>W związku z nadchodzącym sezonem ślubno-komunijnym prezentujemy Państwu artykuły, które szczególnie możemy polecić na tego typu okazje. Wszyskie z polecanych produktów można nabyć w tonacji biało-kremowej. Świetnie nadają się do dekoracji sali, kościoła czy samochodu.</p>', '', 2, 'gal_30.jpg', '3_img1_1e7f4f221deb0d77d4d391f676bb7580.jpg', 500, 375, '3_img2_d64506fa3a483ed79468b476cf13518b.jpg', 250, 187, 115, 86, '3_img3_d64506fa3a483ed79468b476cf13518b.jpg', 1, 'admin', '2010-03-09 19:54:20', 1, 'admin', '2010-03-12 14:57:23', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 2, 0, 1, 1, '', '', '', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 45.00, 0, 0.00, 0.00, 0, 0, 0.00, 0.00, 0, 0),
(4, 1, 0, '', 'Ozdoby weselne - balony', '', '<p>W związku z nadchodzącym sezonem ślubno-komunijnym prezentujemy Państwu artykuły, które szczególnie możemy polecić na tego typu okazje. Wszyskie z polecanych produktów można nabyć w tonacji biało-kremowej. Świetnie nadają się do dekoracji sali, kościoła czy samochodu.</p>', '<p>W związku z nadchodzącym sezonem ślubno-komunijnym prezentujemy Państwu artykuły, które szczególnie możemy polecić na tego typu okazje. Wszyskie z polecanych produktów można nabyć w tonacji biało-kremowej. Świetnie nadają się do dekoracji sali, kościoła czy samochodu.</p>', '', 2, 'gal_16s.jpg', '4_img1_aca1f3279b23046a8b0e143975ce3230.jpg', 100, 75, '4_img2_fbbb8d664337a8ffab140ba3ae29a502.jpg', 100, 75, 100, 75, '4_img3_fbbb8d664337a8ffab140ba3ae29a502.jpg', 1, 'admin', '2010-03-09 19:58:50', 1, 'admin', '2010-03-16 14:49:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 8, 0, 1, 1, '', '', '', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 120.00, 0, 0.00, 500.00, 0, 0, 0.00, 0.00, 0, 0),
(5, 15, 0, '', 'Ozdoby weselne - balony', '', '<p>W związku z nadchodzącym sezonem ślubno-komunijnym prezentujemy Państwu artykuły, które szczególnie możemy polecić na tego typu okazje. Wszyskie z polecanych produktów można nabyć w tonacji biało-kremowej. Świetnie nadają się do dekoracji sali, kościoła czy samochodu.</p>', '<p>W związku z nadchodzącym sezonem ślubno-komunijnym prezentujemy Państwu artykuły, które szczególnie możemy polecić na tego typu okazje. Wszyskie z polecanych produktów można nabyć w tonacji biało-kremowej. Świetnie nadają się do dekoracji sali, kościoła czy samochodu.</p>', '', 2, 'gal_16s.jpg', '5_img1_983f07674143628dc3f39ff3171e25aa.jpg', 100, 75, '5_img2_1a9b230fd82bfd10a63a42eb8e2910d0.jpg', 100, 75, 100, 75, '5_img3_1a9b230fd82bfd10a63a42eb8e2910d0.jpg', 1, 'admin', '2010-03-09 20:00:30', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1, 1, '', '', '', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 78.00, 0, 0.00, 0.00, 0, 0, 0.00, 0.00, 0, 0),
(6, 15, 0, '', 'Ozdoba weselna - balony sufit', '', '<p>W związku z nadchodzącym sezonem ślubno-komunijnym prezentujemy Państwu artykuły, które szczególnie możemy polecić na tego typu okazje. Wszyskie z polecanych produktów można nabyć w tonacji biało-kremowej. Świetnie nadają się do dekoracji sali, kościoła czy samochodu.</p>', '<p>W związku z nadchodzącym sezonem ślubno-komunijnym prezentujemy Państwu artykuły, które szczególnie możemy polecić na tego typu okazje. Wszyskie z polecanych produktów można nabyć w tonacji biało-kremowej. Świetnie nadają się do dekoracji sali, kościoła czy samochodu.</p>', '', 2, 'sufit_wesela.jpg', '6_img1_a3b8b1d7017c6abd1e121bbff40f677f.jpg', 100, 75, '6_img2_89024a645cf5e4afa157bcd41aab0fd8.jpg', 100, 75, 100, 75, '6_img3_89024a645cf5e4afa157bcd41aab0fd8.jpg', 1, 'admin', '2010-03-09 20:15:51', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1, 1, '', '', '', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 200.00, 0, 0.00, 150.00, 0, 0, 0.00, 0.00, 0, 0),
(7, 15, 0, 'Nr kat. b - 124578', 'Ozdoba weselna - balony dla Pary', '', '<p>W związku z nadchodzącym sezonem ślubno-komunijnym prezentujemy Państwu artykuły, które szczególnie możemy polecić na tego typu okazje. Wszyskie z polecanych produktów można nabyć w tonacji biało-kremowej. Świetnie nadają się do dekoracji sali, kościoła czy samochodu.</p>', '<p>W związku z nadchodzącym sezonem ślubno-komunijnym prezentujemy Państwu artykuły, które szczególnie możemy polecić na tego typu okazje. Wszyskie z polecanych produktów można nabyć w tonacji biało-kremowej. Świetnie nadają się do dekoracji sali, kościoła czy samochodu.</p>', '', 2, 'stol_wesela.jpg', '7_img1_f24e8b21fa63b627e86ab71d357e6324.jpg', 100, 75, '7_img2_64a59c73de721b8579cf8664e0dd738a.jpg', 100, 75, 100, 75, '7_img3_64a59c73de721b8579cf8664e0dd738a.jpg', 1, 'admin', '2010-03-09 20:17:03', 1, 'admin', '2010-03-10 08:44:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 9, 0, 1, 1, '', '', '', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 350.00, 0, 0.00, 0.00, 0, 0, 0.00, 0.00, 0, 0),
(8, 3, 0, '', 'Koszyk ozodobny', '', '<p>W związku z nadchodzącym sezonem ślubno-komunijnym prezentujemy Państwu artykuły, które szczególnie możemy polecić na tego typu okazje. Wszyskie z polecanych produktów można nabyć w tonacji biało-kremowej. Świetnie nadają się do dekoracji sali, kościoła czy samochodu.</p>', '<p>W związku z nadchodzącym sezonem ślubno-komunijnym prezentujemy Państwu artykuły, które szczególnie możemy polecić na tego typu okazje. Wszyskie z polecanych produktów można nabyć w tonacji biało-kremowej. Świetnie nadają się do dekoracji sali, kościoła czy samochodu.</p>', '', 2, 'kosz_wesela.jpg', '8_img1_42ae4c037319e4781597d84f8cc49108.jpg', 100, 75, '8_img2_ed24d4da3ba4785ad9a450449fdf98f4.jpg', 100, 75, 100, 75, '8_img3_ed24d4da3ba4785ad9a450449fdf98f4.jpg', 1, 'admin', '2010-03-09 20:17:48', 1, 'admin', '2010-03-16 14:48:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 6, 0, 1, 1, '', '', '', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 180.00, 0, 0.00, 150.00, 0, 0, 0.00, 0.00, 0, 0),
(9, 22, 0, '', 'Koszyk świąteczny', '', '<p>Kosz wiklinowy z dozdobami świątecznymi. </p>', '', '', 2, 'kosz_wesela.jpg', '9_img1_07f5110e8e1736d341038d1a130cec95.jpg', 100, 75, '9_img2_a16ef852e7859bc7a73d4d79bc9fe998.jpg', 100, 75, 100, 75, '9_img3_a16ef852e7859bc7a73d4d79bc9fe998.jpg', 1, 'admin', '2010-03-14 14:32:50', 1, 'admin', '2010-03-14 14:50:18', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, 1, 1, '', '', '', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 450.00, 0, 500.00, 410.00, 0, 0, 0.00, 0.00, 0, 0),
(10, 23, 0, '', 'Koszyk świąteczny  podwieszany', '', '<p>Kosz podwieszany</p>', '', '', 2, 'kosz_wesela.jpg', '10_img1_e3a782a39f133005fb8c7a269d994a76.jpg', 100, 75, '10_img2_f741363c26f5104c73214b1eaf7d1ca1.jpg', 100, 75, 100, 75, '10_img3_f741363c26f5104c73214b1eaf7d1ca1.jpg', 1, 'admin', '2010-03-14 14:34:48', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1, 1, '', '', '', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 120.00, 0, 150.00, 110.00, 0, 0, 0.00, 0.00, 0, 0),
(12, 25, 0, 'Nr -1345-98-OW', 'Ozdoba jaja', '', '', '', '', 2, 'jajka-wielkanocne-2.jpg', '12_img1_405a43a532f82bea7355ac0125acab14.jpg', 500, 375, '12_img2_d1163c61ee1c1709602aaac524faa4ec.jpg', 250, 187, 115, 86, '12_img3_ef553b55427b53e56d378662e7596817.jpg', 1, 'admin', '2010-03-14 15:57:59', 1, 'admin', '2010-03-18 16:10:07', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1, 1, '', '', '', '', 0, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 500.00, 0, 0.00, 450.00, 0, 0, 0.00, 0.00, 0, 0),
(13, 34, 0, '11711', 'Obciążnik do balonów, Dwa serca czerwone, 1 szt.', '', '', '<p>Obciążnik do balonów, Dwa serca czerwone, 1 szt.</p>', '', 2, 'min11711_01.jpg', '13_img1_fce0c8be2fde40b62d64f4d3713c82f1.jpg', 230, 145, '13_img2_5b9b78721e8c058d47e635c2bcabb393.jpg', 230, 145, 115, 72, '13_img3_6b0c0b436fda94a168074fbef052ea52.jpg', 1, 'admin', '2010-03-16 07:55:04', 1, 'admin', '2010-03-16 07:59:24', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3, 0, 1, 1, '', '', '', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 5.33, 0, 0.00, 0.00, 0, 0, 0.00, 0.00, 0, 0),
(14, 32, 0, '', 'Baloniki dmuchane i podwieszane', '', '<p>Balon lateksowy wszystkie kolory</p>', '<p><img height=\"75\" width=\"100\" src=\"/upload/image/gal_28sx.jpg\" alt=\"\" /></p>', '', 0, '', '', 0, 0, '', 0, 0, 0, 0, '', 1, 'admin', '2010-03-16 14:52:35', 0, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 1, 1, '', '', '', '', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 154.00, 0, 0.00, 79.00, 0, 0, 0.00, 0.00, 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_sklep_zamowienia`
--

CREATE TABLE `luminar_sklep_zamowienia` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_u` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `klient_nazwa` varchar(200) NOT NULL,
  `zam_data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `zam_kwota` float(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `zam_waga` float(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `przesylka_kwota` float(6,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `przesylka_typ` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `status_data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `platnosc_typ` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `platnosc_status` smallint(4) UNSIGNED NOT NULL,
  `platnosc_kod` varchar(200) NOT NULL,
  `platnosc_error` varchar(20) NOT NULL,
  `platnosc_kwota` float(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `platnosc_data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `uwagi_klient` text NOT NULL,
  `uwagi_tylko_admin` text NOT NULL,
  `uwagi_admin_klient` text NOT NULL,
  `autor_id` int(11) UNSIGNED NOT NULL,
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(11) NOT NULL,
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `faktura` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `email` varchar(60) NOT NULL,
  `telefon` varchar(50) NOT NULL,
  `imie` varchar(100) NOT NULL,
  `nazwisko` varchar(100) NOT NULL,
  `miejscowosc` varchar(100) NOT NULL,
  `kod_pocztowy` varchar(10) NOT NULL,
  `ulica` varchar(150) NOT NULL,
  `nr_domu` varchar(10) NOT NULL,
  `nr_mieszkania` varchar(10) NOT NULL,
  `firma_nazwa` varchar(200) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `wysylka_miejscowosc` varchar(100) NOT NULL,
  `wysylka_kod_pocztowy` varchar(10) NOT NULL,
  `wysylka_ulica` varchar(150) NOT NULL,
  `wysylka_nr_domu` varchar(10) NOT NULL,
  `wysylka_nr_mieszkania` varchar(10) NOT NULL,
  `faktura_nr` varchar(100) NOT NULL,
  `faktura_data` date NOT NULL DEFAULT '0000-00-00',
  `przesylka_nr` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_sklep_zamowienia_produkty`
--

CREATE TABLE `luminar_sklep_zamowienia_produkty` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_zam` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_produkt` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_wersja` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `nazwa` varchar(250) NOT NULL,
  `cena` float(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `vat` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `ilosc` int(7) UNSIGNED NOT NULL DEFAULT '0',
  `id_kolor` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_rozmiar` int(11) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_subskrypcja`
--

CREATE TABLE `luminar_subskrypcja` (
  `id` int(10) UNSIGNED NOT NULL,
  `idtf` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_u` int(10) NOT NULL DEFAULT '0',
  `email` varchar(150) NOT NULL,
  `data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ip` varchar(15) NOT NULL,
  `sprcheck` varchar(32) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_subskrypcja_pliki`
--

CREATE TABLE `luminar_subskrypcja_pliki` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_matka` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `nazwa` varchar(200) NOT NULL,
  `nazwa_oryginal` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_subskrypcja_wiadomosci`
--

CREATE TABLE `luminar_subskrypcja_wiadomosci` (
  `id` int(10) UNSIGNED NOT NULL,
  `data` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `tytul` varchar(200) NOT NULL DEFAULT '',
  `tresc` text NOT NULL,
  `licznik` mediumint(7) NOT NULL DEFAULT '0',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_uzytkownicy`
--

CREATE TABLE `luminar_uzytkownicy` (
  `id` int(10) UNSIGNED NOT NULL,
  `login` varchar(30) NOT NULL DEFAULT '',
  `haslo` varchar(32) NOT NULL DEFAULT '',
  `email` varchar(80) NOT NULL,
  `email2` varchar(80) NOT NULL,
  `imie` varchar(40) NOT NULL,
  `nazwisko` varchar(60) NOT NULL,
  `nazwa` varchar(200) NOT NULL,
  `ur_rok` mediumint(4) UNSIGNED NOT NULL DEFAULT '0',
  `ur_mc` smallint(2) UNSIGNED NOT NULL DEFAULT '0',
  `ur_dzien` smallint(2) UNSIGNED NOT NULL DEFAULT '0',
  `plec` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `miejscowosc` varchar(100) NOT NULL DEFAULT '',
  `kod_pocztowy` varchar(10) NOT NULL,
  `ulica` varchar(150) NOT NULL,
  `nr_domu` varchar(10) NOT NULL,
  `nr_mieszkania` varchar(10) NOT NULL,
  `woj` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `firma` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `firma_nazwa` varchar(200) NOT NULL,
  `firma_miejscowosc` varchar(100) NOT NULL,
  `firma_kod_pocztowy` varchar(10) NOT NULL,
  `firma_ulica` varchar(150) NOT NULL,
  `firma_nr_domu` varchar(10) NOT NULL,
  `firma_nr_mieszkania` varchar(10) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `gg` varchar(15) NOT NULL DEFAULT '',
  `skype` varchar(150) NOT NULL,
  `telefon` varchar(50) NOT NULL,
  `www` varchar(100) NOT NULL DEFAULT '',
  `omnie` text NOT NULL,
  `zainteresowania` text NOT NULL,
  `praca` text NOT NULL,
  `sprcheck` varchar(32) NOT NULL,
  `zalogowanie` varchar(32) NOT NULL DEFAULT '',
  `ip_log` varchar(15) NOT NULL DEFAULT '',
  `host_log` varchar(60) NOT NULL DEFAULT '',
  `last_log` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_bad_log` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_operation` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_operation_name` varchar(100) NOT NULL,
  `data_haslo` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ile_log` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `uprawnienia` varchar(80) NOT NULL DEFAULT '0000000000000000000000000000000000000000',
  `opis` text NOT NULL,
  `punkty` mediumint(7) NOT NULL DEFAULT '0',
  `glosy_suma` int(8) UNSIGNED NOT NULL DEFAULT '0',
  `glosy_ile` int(6) UNSIGNED NOT NULL DEFAULT '0',
  `glosy_srednia` float(5,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `niewygasa` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `status` tinyint(2) UNSIGNED NOT NULL DEFAULT '1',
  `lang2` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `img` smallint(2) UNSIGNED NOT NULL,
  `img_nazwa_oryginal` varchar(200) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img3_nazwa` varchar(200) NOT NULL,
  `img3_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img3_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `typ` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `ile_znajomi` int(7) UNSIGNED NOT NULL DEFAULT '0',
  `wys_niepowiadomienia` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `wys_niewyszukiwarka` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `wys_kontaktowe` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `wys_opisowe` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `wys_galerie` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `wys_koment` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `zgoda_osobowe` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `zgoda_regulamin` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `suma_zakupy` float(10,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `ilosc_zakupy` int(5) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `luminar_uzytkownicy`
--

INSERT INTO `luminar_uzytkownicy` (`id`, `login`, `haslo`, `email`, `email2`, `imie`, `nazwisko`, `nazwa`, `ur_rok`, `ur_mc`, `ur_dzien`, `plec`, `miejscowosc`, `kod_pocztowy`, `ulica`, `nr_domu`, `nr_mieszkania`, `woj`, `firma`, `firma_nazwa`, `firma_miejscowosc`, `firma_kod_pocztowy`, `firma_ulica`, `firma_nr_domu`, `firma_nr_mieszkania`, `nip`, `gg`, `skype`, `telefon`, `www`, `omnie`, `zainteresowania`, `praca`, `sprcheck`, `zalogowanie`, `ip_log`, `host_log`, `last_log`, `last_bad_log`, `last_operation`, `last_operation_name`, `data_haslo`, `ile_log`, `uprawnienia`, `opis`, `punkty`, `glosy_suma`, `glosy_ile`, `glosy_srednia`, `niewygasa`, `status`, `lang2`, `img`, `img_nazwa_oryginal`, `img1_nazwa`, `img1_w`, `img1_h`, `img2_nazwa`, `img2_w`, `img2_h`, `img3_nazwa`, `img3_w`, `img3_h`, `typ`, `ile_znajomi`, `wys_niepowiadomienia`, `wys_niewyszukiwarka`, `wys_kontaktowe`, `wys_opisowe`, `wys_galerie`, `wys_koment`, `autor_id`, `autor_name`, `autor_kiedy`, `edytor_id`, `edytor_name`, `edytor_kiedy`, `zgoda_osobowe`, `zgoda_regulamin`, `suma_zakupy`, `ilosc_zakupy`) VALUES
(1, 'admin', '33d55641ce40996d6603df2e020e26aa', 'e-byk@e-byk.pl', '', 'Tomasz', 'Bykowski', '', 0, 0, 0, 0, 'Toruń', '87-100', 'Grudziądzka', '44', '55', 2, 0, '', '', '', '', '', '', '', '5108169', 'waldemarjonik', '694600343', 'http://salonstron.pl', 'oto ja\r\n\r\n:)', ':)\r\n\r\n:)', ':)\r\n\r\n:)', 'b49a5b96937b73d049c61cb53218086c', '', '77.115.72.180', 'apn-77-115-72-180.dynamic.gprs.plus.pl', '2010-03-19 23:04:27', '2010-03-14 17:33:57', '2010-03-19 23:13:36', 'u_wylogujadmin', '2009-09-04 14:53:40', 131, '10000000000000000000000000000000000000000000000000000000000000000000000000000000', '', 0, 0, 0, 0.00, 0, 1, 0, 2, 'fot21.jpg', '1_img1_aee6b5e249e9512448564aa30fb41037.jpg', 500, 375, '1_img2_811b6cf7f519e61f973c4d18336d3497.jpg', 120, 90, '1_img3_811b6cf7f519e61f973c4d18336d3497.jpg', 45, 45, 1, 0, 0, 0, 0, 0, 0, 0, 13, 'demo', '2009-09-04 14:53:40', 1, 'admin', '2010-03-12 15:11:40', 0, 0, 0.00, 0),
(30, 'luminar', '8a38bd069e3b910910a42330674788e7', 'luninar@luminar.pl', '', 'Jan', 'Nowak', '', 0, 0, 0, 0, '', '', '', '', '', 0, 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '15d121ccbf4de8fb452264f4c73a9ed1', '', '77.115.136.98', 'apn-77-115-136-98.dynamic.gprs.plus.pl', '2010-03-14 10:31:44', '0000-00-00 00:00:00', '2010-03-14 10:32:35', 'u_wylogujadmin', '2010-03-14 10:12:16', 3, '00000000000000000000110000000000000000000000000000000000000000000000000000000000', 'Pracownik działu zamównień.', 0, 0, 0, 0.00, 0, 1, 0, 0, '', '', 0, 0, '', 0, 0, '', 0, 0, 3, 0, 0, 0, 0, 0, 0, 0, 1, 'admin', '2010-03-14 10:12:16', 30, 'luminar', '2010-03-14 10:31:13', 0, 0, 0.00, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_uzytkownicy_galeria`
--

CREATE TABLE `luminar_uzytkownicy_galeria` (
  `id` int(10) UNSIGNED NOT NULL,
  `id_matka` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `nr_poz` smallint(3) UNSIGNED NOT NULL DEFAULT '0',
  `tytul` varchar(250) NOT NULL,
  `opis` text NOT NULL,
  `autor_zdjecia` varchar(250) NOT NULL,
  `licznik` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `punkty_ilosc` int(8) UNSIGNED NOT NULL DEFAULT '0',
  `punkty_suma` int(8) UNSIGNED NOT NULL DEFAULT '0',
  `punkty_srednia` float(5,2) UNSIGNED NOT NULL DEFAULT '0.00',
  `img` tinyint(2) UNSIGNED NOT NULL DEFAULT '0',
  `img_nazwa_oryginal` varchar(250) NOT NULL,
  `img1_nazwa` varchar(200) NOT NULL,
  `img1_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img1_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_nazwa` varchar(200) NOT NULL,
  `img2_w` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `img2_h` smallint(4) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL,
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `obrobka` tinyint(1) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_uzytkownicy_galeria_koment`
--

CREATE TABLE `luminar_uzytkownicy_galeria_koment` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_matka` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `tresc` text NOT NULL,
  `ip` varchar(39) NOT NULL,
  `host` varchar(60) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_uzytkownicy_koment`
--

CREATE TABLE `luminar_uzytkownicy_koment` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_matka` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `tresc` text NOT NULL,
  `ip` varchar(39) NOT NULL,
  `host` varchar(60) NOT NULL,
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `autor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `autor_name` varchar(150) NOT NULL,
  `autor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `edytor_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `edytor_name` varchar(150) NOT NULL,
  `edytor_kiedy` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_zablokowani`
--

CREATE TABLE `luminar_zablokowani` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_u` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_gosc` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `data_dodania` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `opis` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `luminar_znajomi`
--

CREATE TABLE `luminar_znajomi` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_u` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_gosc` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `data_dodania` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `antyki_ankieta`
--
ALTER TABLE `antyki_ankieta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `data_start` (`data_start`),
  ADD KEY `data_stop` (`data_stop`),
  ADD KEY `lang` (`lang`),
  ADD KEY `id_typ` (`id_typ`);

--
-- Indeksy dla tabeli `antyki_ankieta_glosy`
--
ALTER TABLE `antyki_ankieta_glosy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_matka` (`id_matka`);

--
-- Indeksy dla tabeli `antyki_ankieta_list`
--
ALTER TABLE `antyki_ankieta_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_matka` (`id_matka`),
  ADD KEY `nr_poz` (`nr_poz`);

--
-- Indeksy dla tabeli `antyki_art`
--
ALTER TABLE `antyki_art`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idtf` (`idtf`),
  ADD KEY `status` (`status`),
  ADD KEY `nr_poz` (`nr_poz`),
  ADD KEY `id_autor` (`autor_id`),
  ADD KEY `data_start` (`data_start`),
  ADD KEY `data_stop` (`data_stop`),
  ADD KEY `poziom` (`poziom`),
  ADD KEY `glowny` (`glowny`),
  ADD KEY `dostep` (`dostep`),
  ADD KEY `rss` (`rss`),
  ADD KEY `menu_nie` (`menu_nie`),
  ADD KEY `mapa_nie` (`mapa_nie`),
  ADD KEY `id_d` (`id_d`),
  ADD KEY `id_pierwszy` (`id_pierwszy`);

--
-- Indeksy dla tabeli `antyki_artd`
--
ALTER TABLE `antyki_artd`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idtf` (`idtf`),
  ADD KEY `status` (`status`),
  ADD KEY `nr_poz` (`nr_poz`),
  ADD KEY `id_autor` (`autor_id`),
  ADD KEY `data_start` (`data_start`),
  ADD KEY `data_stop` (`data_stop`),
  ADD KEY `poziom` (`poziom`),
  ADD KEY `glowny` (`glowny`),
  ADD KEY `dostep` (`dostep`),
  ADD KEY `rss` (`rss`),
  ADD KEY `menu_nie` (`menu_nie`),
  ADD KEY `mapa_nie` (`mapa_nie`),
  ADD KEY `id_d` (`id_d`),
  ADD KEY `id_art` (`id_art`);

--
-- Indeksy dla tabeli `antyki_art_akapity`
--
ALTER TABLE `antyki_art_akapity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `id_matka` (`id_matka`),
  ADD KEY `nr_poz` (`nr_poz`);

--
-- Indeksy dla tabeli `antyki_art_akapityd`
--
ALTER TABLE `antyki_art_akapityd`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `id_matka` (`id_matka`),
  ADD KEY `nr_poz` (`nr_poz`),
  ADD KEY `id_artd` (`id_artd`);

--
-- Indeksy dla tabeli `antyki_art_dziennik`
--
ALTER TABLE `antyki_art_dziennik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_u` (`id_u`),
  ADD KEY `id_art` (`id_art`),
  ADD KEY `kiedy` (`data`);

--
-- Indeksy dla tabeli `antyki_art_galeria`
--
ALTER TABLE `antyki_art_galeria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `id_matka` (`id_matka`),
  ADD KEY `nr_poz` (`nr_poz`);

--
-- Indeksy dla tabeli `antyki_art_komentarze`
--
ALTER TABLE `antyki_art_komentarze`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_matka` (`id_matka`),
  ADD KEY `id_u` (`id_u`),
  ADD KEY `data` (`data`);

--
-- Indeksy dla tabeli `antyki_bany`
--
ALTER TABLE `antyki_bany`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip` (`ip`),
  ADD KEY `id_typ` (`id_typ`);

--
-- Indeksy dla tabeli `antyki_forum_d`
--
ALTER TABLE `antyki_forum_d`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nr` (`nr`),
  ADD KEY `status` (`status`);

--
-- Indeksy dla tabeli `antyki_forum_p`
--
ALTER TABLE `antyki_forum_p`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_t` (`id_t`),
  ADD KEY `data` (`data`),
  ADD KEY `status` (`status`);

--
-- Indeksy dla tabeli `antyki_forum_t`
--
ALTER TABLE `antyki_forum_t`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_d` (`id_d`),
  ADD KEY `data` (`data`),
  ADD KEY `przyklejony` (`przyklejony`),
  ADD KEY `status` (`status`);

--
-- Indeksy dla tabeli `antyki_guestbook`
--
ALTER TABLE `antyki_guestbook`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data` (`data`);

--
-- Indeksy dla tabeli `antyki_konfig`
--
ALTER TABLE `antyki_konfig`
  ADD PRIMARY KEY (`idtf`,`lang`);

--
-- Indeksy dla tabeli `antyki_logi`
--
ALTER TABLE `antyki_logi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kiedy` (`kiedy`),
  ADD KEY `id_u` (`id_u`),
  ADD KEY `idtf` (`idtf`),
  ADD KEY `login` (`login`);

--
-- Indeksy dla tabeli `antyki_poczta`
--
ALTER TABLE `antyki_poczta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_autor` (`id_autor`),
  ADD KEY `id_odb` (`id_odb`),
  ADD KEY `data_wys` (`data_wys`),
  ADD KEY `status` (`status`),
  ADD KEY `wykonana` (`wykonana`);

--
-- Indeksy dla tabeli `antyki_rotator`
--
ALTER TABLE `antyki_rotator`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_typ` (`id_typ`),
  ADD KEY `status` (`status`),
  ADD KEY `lang` (`lang`),
  ADD KEY `data_start` (`data_start`),
  ADD KEY `data_stop` (`data_stop`),
  ADD KEY `udzial` (`udzial`);

--
-- Indeksy dla tabeli `antyki_sklep_kat`
--
ALTER TABLE `antyki_sklep_kat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `nr_poz` (`nr_poz`),
  ADD KEY `id_autor` (`autor_id`),
  ADD KEY `data_start` (`data_start`),
  ADD KEY `data_stop` (`data_stop`),
  ADD KEY `poziom` (`poziom`),
  ADD KEY `id_d` (`id_d`),
  ADD KEY `id_pierwszy` (`id_pierwszy`),
  ADD KEY `typ` (`typ`);

--
-- Indeksy dla tabeli `antyki_sklep_producenci`
--
ALTER TABLE `antyki_sklep_producenci`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `id_autor` (`autor_id`);

--
-- Indeksy dla tabeli `antyki_sklep_produkty`
--
ALTER TABLE `antyki_sklep_produkty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `id_autor` (`autor_id`),
  ADD KEY `data_start` (`data_start`),
  ADD KEY `data_stop` (`data_stop`),
  ADD KEY `id_producent` (`id_producent`),
  ADD KEY `nowosc` (`nowosc`),
  ADD KEY `nowosc_start` (`nowosc_start`),
  ADD KEY `nowosc_stop` (`nowosc_stop`),
  ADD KEY `promocja` (`promocja`),
  ADD KEY `promocja_start` (`promocja_start`),
  ADD KEY `promocja_stop` (`promocja_stop`),
  ADD KEY `wyprzedarz_stop` (`wyprzedaz_stop`),
  ADD KEY `wyprzedaz_start` (`wyprzedaz_start`),
  ADD KEY `polecamy` (`polecamy`),
  ADD KEY `polecamy_start` (`polecamy_start`),
  ADD KEY `cena` (`cena`),
  ADD KEY `glosy_srednia` (`glosy_srednia`),
  ADD KEY `nazwa` (`nazwa`),
  ADD KEY `symbol` (`symbol`);

--
-- Indeksy dla tabeli `antyki_sklep_zamowienia`
--
ALTER TABLE `antyki_sklep_zamowienia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `id_autor` (`autor_id`),
  ADD KEY `id_u` (`id_u`),
  ADD KEY `kwota_zam` (`zam_kwota`),
  ADD KEY `zam_data` (`zam_data`);

--
-- Indeksy dla tabeli `antyki_sklep_zamowienia_produkty`
--
ALTER TABLE `antyki_sklep_zamowienia_produkty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_zam` (`id_zam`),
  ADD KEY `id_produkt` (`id_produkt`),
  ADD KEY `id_wersja` (`id_wersja`),
  ADD KEY `id_kolor` (`id_kolor`),
  ADD KEY `id_rozmiar` (`id_rozmiar`);

--
-- Indeksy dla tabeli `antyki_subskrypcja`
--
ALTER TABLE `antyki_subskrypcja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `idtf` (`idtf`),
  ADD KEY `zalogowanie` (`zalogowanie`);

--
-- Indeksy dla tabeli `antyki_subskrypcja_pliki`
--
ALTER TABLE `antyki_subskrypcja_pliki`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_matka` (`id_matka`);

--
-- Indeksy dla tabeli `antyki_subskrypcja_wiadomosci`
--
ALTER TABLE `antyki_subskrypcja_wiadomosci`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data` (`data`),
  ADD KEY `tytul` (`tytul`);

--
-- Indeksy dla tabeli `antyki_uzytkownicy`
--
ALTER TABLE `antyki_uzytkownicy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login` (`login`),
  ADD KEY `status` (`status`),
  ADD KEY `zalogowanie` (`zalogowanie`),
  ADD KEY `last_log` (`last_log`),
  ADD KEY `email` (`email`),
  ADD KEY `typ` (`typ`),
  ADD KEY `niewygasa` (`niewygasa`);

--
-- Indeksy dla tabeli `antyki_zablokowani`
--
ALTER TABLE `antyki_zablokowani`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_u` (`id_u`),
  ADD KEY `data_dodania` (`data_dodania`);

--
-- Indeksy dla tabeli `antyki_znajomi`
--
ALTER TABLE `antyki_znajomi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_u` (`id_u`),
  ADD KEY `data_dodania` (`data_dodania`);

--
-- Indeksy dla tabeli `arkadia_ankieta`
--
ALTER TABLE `arkadia_ankieta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `data_start` (`data_start`),
  ADD KEY `data_stop` (`data_stop`),
  ADD KEY `lang` (`lang`),
  ADD KEY `id_typ` (`id_typ`);

--
-- Indeksy dla tabeli `arkadia_ankieta_glosy`
--
ALTER TABLE `arkadia_ankieta_glosy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_matka` (`id_matka`);

--
-- Indeksy dla tabeli `arkadia_ankieta_list`
--
ALTER TABLE `arkadia_ankieta_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_matka` (`id_matka`),
  ADD KEY `nr_poz` (`nr_poz`);

--
-- Indeksy dla tabeli `arkadia_art`
--
ALTER TABLE `arkadia_art`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idtf` (`idtf`),
  ADD KEY `status` (`status`),
  ADD KEY `nr_poz` (`nr_poz`),
  ADD KEY `id_autor` (`autor_id`),
  ADD KEY `data_start` (`data_start`),
  ADD KEY `data_stop` (`data_stop`),
  ADD KEY `poziom` (`poziom`),
  ADD KEY `glowny` (`glowny`),
  ADD KEY `dostep` (`dostep`),
  ADD KEY `rss` (`rss`),
  ADD KEY `menu_nie` (`menu_nie`),
  ADD KEY `mapa_nie` (`mapa_nie`),
  ADD KEY `id_d` (`id_d`),
  ADD KEY `id_pierwszy` (`id_pierwszy`);

--
-- Indeksy dla tabeli `arkadia_artd`
--
ALTER TABLE `arkadia_artd`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idtf` (`idtf`),
  ADD KEY `status` (`status`),
  ADD KEY `nr_poz` (`nr_poz`),
  ADD KEY `id_autor` (`autor_id`),
  ADD KEY `data_start` (`data_start`),
  ADD KEY `data_stop` (`data_stop`),
  ADD KEY `poziom` (`poziom`),
  ADD KEY `glowny` (`glowny`),
  ADD KEY `dostep` (`dostep`),
  ADD KEY `rss` (`rss`),
  ADD KEY `menu_nie` (`menu_nie`),
  ADD KEY `mapa_nie` (`mapa_nie`),
  ADD KEY `id_d` (`id_d`),
  ADD KEY `id_art` (`id_art`);

--
-- Indeksy dla tabeli `arkadia_art_akapity`
--
ALTER TABLE `arkadia_art_akapity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `id_matka` (`id_matka`),
  ADD KEY `nr_poz` (`nr_poz`);

--
-- Indeksy dla tabeli `arkadia_art_akapityd`
--
ALTER TABLE `arkadia_art_akapityd`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `id_matka` (`id_matka`),
  ADD KEY `nr_poz` (`nr_poz`),
  ADD KEY `id_artd` (`id_artd`);

--
-- Indeksy dla tabeli `arkadia_art_dziennik`
--
ALTER TABLE `arkadia_art_dziennik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_u` (`id_u`),
  ADD KEY `id_art` (`id_art`),
  ADD KEY `kiedy` (`data`);

--
-- Indeksy dla tabeli `arkadia_art_galeria`
--
ALTER TABLE `arkadia_art_galeria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `id_matka` (`id_matka`),
  ADD KEY `nr_poz` (`nr_poz`);

--
-- Indeksy dla tabeli `arkadia_art_koment`
--
ALTER TABLE `arkadia_art_koment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_matka` (`id_matka`);

--
-- Indeksy dla tabeli `arkadia_bany`
--
ALTER TABLE `arkadia_bany`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip` (`ip`),
  ADD KEY `id_typ` (`id_typ`);

--
-- Indeksy dla tabeli `arkadia_forum_c`
--
ALTER TABLE `arkadia_forum_c`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nr_poz` (`nr_poz`),
  ADD KEY `status` (`status`),
  ADD KEY `specjalny` (`specjalny`);

--
-- Indeksy dla tabeli `arkadia_forum_d`
--
ALTER TABLE `arkadia_forum_d`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nr` (`nr`),
  ADD KEY `status` (`status`);

--
-- Indeksy dla tabeli `arkadia_forum_f`
--
ALTER TABLE `arkadia_forum_f`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nr_poz` (`nr_poz`),
  ADD KEY `status` (`status`),
  ADD KEY `id_kat` (`id_kat`);

--
-- Indeksy dla tabeli `arkadia_forum_p`
--
ALTER TABLE `arkadia_forum_p`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_t` (`id_t`),
  ADD KEY `data` (`data`),
  ADD KEY `status` (`status`);

--
-- Indeksy dla tabeli `arkadia_forum_pp`
--
ALTER TABLE `arkadia_forum_pp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_t` (`id_t`),
  ADD KEY `status` (`status`),
  ADD KEY `autor_kiedy` (`autor_kiedy`);

--
-- Indeksy dla tabeli `arkadia_forum_t`
--
ALTER TABLE `arkadia_forum_t`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_d` (`id_d`),
  ADD KEY `data` (`data`),
  ADD KEY `przyklejony` (`przyklejony`),
  ADD KEY `status` (`status`);

--
-- Indeksy dla tabeli `arkadia_forum_tt`
--
ALTER TABLE `arkadia_forum_tt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_f` (`id_f`),
  ADD KEY `przyklejony` (`przyklejony`),
  ADD KEY `status` (`status`),
  ADD KEY `autor_kiedy` (`autor_kiedy`),
  ADD KEY `first_post_id` (`first_post_id`),
  ADD KEY `last_post_id` (`last_post_id`),
  ADD KEY `last_post_date` (`last_post_date`);

--
-- Indeksy dla tabeli `arkadia_grupy`
--
ALTER TABLE `arkadia_grupy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`);

--
-- Indeksy dla tabeli `arkadia_grupy_galeria`
--
ALTER TABLE `arkadia_grupy_galeria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `id_matka` (`id_matka`),
  ADD KEY `nr_poz` (`nr_poz`);

--
-- Indeksy dla tabeli `arkadia_grupy_galeria_koment`
--
ALTER TABLE `arkadia_grupy_galeria_koment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_matka` (`id_matka`);

--
-- Indeksy dla tabeli `arkadia_grupy_uzytkownicy`
--
ALTER TABLE `arkadia_grupy_uzytkownicy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_u` (`id_u`),
  ADD KEY `data_dodania` (`data_dodania`),
  ADD KEY `status` (`status`),
  ADD KEY `ostatnia_wizyta` (`ostatnia_wizyta`);

--
-- Indeksy dla tabeli `arkadia_guestbook`
--
ALTER TABLE `arkadia_guestbook`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `arkadia_konfig`
--
ALTER TABLE `arkadia_konfig`
  ADD PRIMARY KEY (`idtf`,`lang`);

--
-- Indeksy dla tabeli `arkadia_logi`
--
ALTER TABLE `arkadia_logi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kiedy` (`kiedy`),
  ADD KEY `id_u` (`id_u`),
  ADD KEY `idtf` (`idtf`),
  ADD KEY `login` (`login`);

--
-- Indeksy dla tabeli `arkadia_poczta`
--
ALTER TABLE `arkadia_poczta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_autor` (`id_autor`),
  ADD KEY `id_odb` (`id_odb`),
  ADD KEY `data_wys` (`data_wys`),
  ADD KEY `status` (`status`),
  ADD KEY `wykonana` (`wykonana`),
  ADD KEY `zdefiniowana` (`zdefiniowana`);

--
-- Indeksy dla tabeli `arkadia_rotator`
--
ALTER TABLE `arkadia_rotator`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_typ` (`id_typ`),
  ADD KEY `status` (`status`),
  ADD KEY `lang` (`lang`),
  ADD KEY `data_start` (`data_start`),
  ADD KEY `data_stop` (`data_stop`),
  ADD KEY `udzial` (`udzial`);

--
-- Indeksy dla tabeli `arkadia_sklep_kat`
--
ALTER TABLE `arkadia_sklep_kat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `nr_poz` (`nr_poz`),
  ADD KEY `id_autor` (`autor_id`),
  ADD KEY `data_start` (`data_start`),
  ADD KEY `data_stop` (`data_stop`),
  ADD KEY `poziom` (`poziom`),
  ADD KEY `id_d` (`id_d`),
  ADD KEY `id_pierwszy` (`id_pierwszy`),
  ADD KEY `typ` (`typ`);

--
-- Indeksy dla tabeli `arkadia_sklep_producenci`
--
ALTER TABLE `arkadia_sklep_producenci`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `id_autor` (`autor_id`);

--
-- Indeksy dla tabeli `arkadia_sklep_produkty`
--
ALTER TABLE `arkadia_sklep_produkty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `id_autor` (`autor_id`),
  ADD KEY `data_start` (`data_start`),
  ADD KEY `data_stop` (`data_stop`),
  ADD KEY `id_producent` (`id_producent`),
  ADD KEY `nowosc` (`nowosc`),
  ADD KEY `nowosc_start` (`nowosc_start`),
  ADD KEY `nowosc_stop` (`nowosc_stop`),
  ADD KEY `promocja` (`promocja`),
  ADD KEY `promocja_start` (`promocja_start`),
  ADD KEY `promocja_stop` (`promocja_stop`),
  ADD KEY `wyprzedarz_stop` (`wyprzedaz_stop`),
  ADD KEY `wyprzedaz_start` (`wyprzedaz_start`),
  ADD KEY `polecamy` (`polecamy`),
  ADD KEY `polecamy_start` (`polecamy_start`),
  ADD KEY `cena` (`cena`),
  ADD KEY `glosy_srednia` (`glosy_srednia`),
  ADD KEY `nazwa` (`nazwa`),
  ADD KEY `symbol` (`symbol`);

--
-- Indeksy dla tabeli `arkadia_sklep_zamowienia`
--
ALTER TABLE `arkadia_sklep_zamowienia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `id_autor` (`autor_id`),
  ADD KEY `id_u` (`id_u`),
  ADD KEY `kwota_zam` (`zam_kwota`),
  ADD KEY `zam_data` (`zam_data`);

--
-- Indeksy dla tabeli `arkadia_sklep_zamowienia_produkty`
--
ALTER TABLE `arkadia_sklep_zamowienia_produkty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_zam` (`id_zam`),
  ADD KEY `id_produkt` (`id_produkt`),
  ADD KEY `id_wersja` (`id_wersja`),
  ADD KEY `id_kolor` (`id_kolor`),
  ADD KEY `id_rozmiar` (`id_rozmiar`);

--
-- Indeksy dla tabeli `arkadia_subskrypcja`
--
ALTER TABLE `arkadia_subskrypcja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `idtf` (`idtf`),
  ADD KEY `zalogowanie` (`sprcheck`);

--
-- Indeksy dla tabeli `arkadia_subskrypcja_pliki`
--
ALTER TABLE `arkadia_subskrypcja_pliki`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_matka` (`id_matka`);

--
-- Indeksy dla tabeli `arkadia_subskrypcja_wiadomosci`
--
ALTER TABLE `arkadia_subskrypcja_wiadomosci`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data` (`data`),
  ADD KEY `tytul` (`tytul`);

--
-- Indeksy dla tabeli `arkadia_uzytkownicy`
--
ALTER TABLE `arkadia_uzytkownicy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login` (`login`),
  ADD KEY `status` (`status`),
  ADD KEY `zalogowanie` (`zalogowanie`),
  ADD KEY `last_log` (`last_log`),
  ADD KEY `email` (`email`),
  ADD KEY `typ` (`typ`),
  ADD KEY `niewygasa` (`niewygasa`);

--
-- Indeksy dla tabeli `arkadia_uzytkownicy_galeria`
--
ALTER TABLE `arkadia_uzytkownicy_galeria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `id_matka` (`id_matka`),
  ADD KEY `nr_poz` (`nr_poz`);

--
-- Indeksy dla tabeli `arkadia_uzytkownicy_galeria_koment`
--
ALTER TABLE `arkadia_uzytkownicy_galeria_koment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_matka` (`id_matka`);

--
-- Indeksy dla tabeli `arkadia_uzytkownicy_koment`
--
ALTER TABLE `arkadia_uzytkownicy_koment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_matka` (`id_matka`);

--
-- Indeksy dla tabeli `arkadia_zablokowani`
--
ALTER TABLE `arkadia_zablokowani`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_u` (`id_u`),
  ADD KEY `data_dodania` (`data_dodania`);

--
-- Indeksy dla tabeli `arkadia_znajomi`
--
ALTER TABLE `arkadia_znajomi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_u` (`id_u`),
  ADD KEY `data_dodania` (`data_dodania`);

--
-- Indeksy dla tabeli `luminar_ankieta`
--
ALTER TABLE `luminar_ankieta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `data_start` (`data_start`),
  ADD KEY `data_stop` (`data_stop`),
  ADD KEY `lang` (`lang`),
  ADD KEY `id_typ` (`id_typ`);

--
-- Indeksy dla tabeli `luminar_ankieta_glosy`
--
ALTER TABLE `luminar_ankieta_glosy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_matka` (`id_matka`);

--
-- Indeksy dla tabeli `luminar_ankieta_list`
--
ALTER TABLE `luminar_ankieta_list`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_matka` (`id_matka`),
  ADD KEY `nr_poz` (`nr_poz`);

--
-- Indeksy dla tabeli `luminar_art`
--
ALTER TABLE `luminar_art`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idtf` (`idtf`),
  ADD KEY `status` (`status`),
  ADD KEY `nr_poz` (`nr_poz`),
  ADD KEY `id_autor` (`autor_id`),
  ADD KEY `data_start` (`data_start`),
  ADD KEY `data_stop` (`data_stop`),
  ADD KEY `poziom` (`poziom`),
  ADD KEY `glowny` (`glowny`),
  ADD KEY `dostep` (`dostep`),
  ADD KEY `rss` (`rss`),
  ADD KEY `menu_nie` (`menu_nie`),
  ADD KEY `mapa_nie` (`mapa_nie`),
  ADD KEY `id_d` (`id_d`),
  ADD KEY `id_pierwszy` (`id_pierwszy`);

--
-- Indeksy dla tabeli `luminar_artd`
--
ALTER TABLE `luminar_artd`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idtf` (`idtf`),
  ADD KEY `status` (`status`),
  ADD KEY `nr_poz` (`nr_poz`),
  ADD KEY `id_autor` (`autor_id`),
  ADD KEY `data_start` (`data_start`),
  ADD KEY `data_stop` (`data_stop`),
  ADD KEY `poziom` (`poziom`),
  ADD KEY `glowny` (`glowny`),
  ADD KEY `dostep` (`dostep`),
  ADD KEY `rss` (`rss`),
  ADD KEY `menu_nie` (`menu_nie`),
  ADD KEY `mapa_nie` (`mapa_nie`),
  ADD KEY `id_d` (`id_d`),
  ADD KEY `id_art` (`id_art`);

--
-- Indeksy dla tabeli `luminar_art_akapity`
--
ALTER TABLE `luminar_art_akapity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `id_matka` (`id_matka`),
  ADD KEY `nr_poz` (`nr_poz`);

--
-- Indeksy dla tabeli `luminar_art_akapityd`
--
ALTER TABLE `luminar_art_akapityd`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `id_matka` (`id_matka`),
  ADD KEY `nr_poz` (`nr_poz`),
  ADD KEY `id_artd` (`id_artd`);

--
-- Indeksy dla tabeli `luminar_art_dziennik`
--
ALTER TABLE `luminar_art_dziennik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_u` (`id_u`),
  ADD KEY `id_art` (`id_art`),
  ADD KEY `kiedy` (`data`);

--
-- Indeksy dla tabeli `luminar_art_galeria`
--
ALTER TABLE `luminar_art_galeria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `id_matka` (`id_matka`),
  ADD KEY `nr_poz` (`nr_poz`);

--
-- Indeksy dla tabeli `luminar_art_koment`
--
ALTER TABLE `luminar_art_koment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_matka` (`id_matka`);

--
-- Indeksy dla tabeli `luminar_bany`
--
ALTER TABLE `luminar_bany`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip` (`ip`),
  ADD KEY `id_typ` (`id_typ`);

--
-- Indeksy dla tabeli `luminar_forum_c`
--
ALTER TABLE `luminar_forum_c`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nr_poz` (`nr_poz`),
  ADD KEY `status` (`status`),
  ADD KEY `specjalny` (`specjalny`);

--
-- Indeksy dla tabeli `luminar_forum_d`
--
ALTER TABLE `luminar_forum_d`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nr` (`nr`),
  ADD KEY `status` (`status`);

--
-- Indeksy dla tabeli `luminar_forum_f`
--
ALTER TABLE `luminar_forum_f`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nr_poz` (`nr_poz`),
  ADD KEY `status` (`status`),
  ADD KEY `id_kat` (`id_kat`);

--
-- Indeksy dla tabeli `luminar_forum_p`
--
ALTER TABLE `luminar_forum_p`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `id_t` (`id_t`),
  ADD KEY `data` (`data`),
  ADD KEY `status` (`status`);

--
-- Indeksy dla tabeli `luminar_forum_pp`
--
ALTER TABLE `luminar_forum_pp`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_t` (`id_t`),
  ADD KEY `status` (`status`),
  ADD KEY `autor_kiedy` (`autor_kiedy`);

--
-- Indeksy dla tabeli `luminar_forum_t`
--
ALTER TABLE `luminar_forum_t`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_d` (`id_d`),
  ADD KEY `data` (`data`),
  ADD KEY `przyklejony` (`przyklejony`),
  ADD KEY `status` (`status`);

--
-- Indeksy dla tabeli `luminar_forum_tt`
--
ALTER TABLE `luminar_forum_tt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_f` (`id_f`),
  ADD KEY `przyklejony` (`przyklejony`),
  ADD KEY `status` (`status`),
  ADD KEY `autor_kiedy` (`autor_kiedy`),
  ADD KEY `first_post_id` (`first_post_id`),
  ADD KEY `last_post_id` (`last_post_id`),
  ADD KEY `last_post_date` (`last_post_date`);

--
-- Indeksy dla tabeli `luminar_grupy`
--
ALTER TABLE `luminar_grupy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`);

--
-- Indeksy dla tabeli `luminar_grupy_galeria`
--
ALTER TABLE `luminar_grupy_galeria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `id_matka` (`id_matka`),
  ADD KEY `nr_poz` (`nr_poz`);

--
-- Indeksy dla tabeli `luminar_grupy_galeria_koment`
--
ALTER TABLE `luminar_grupy_galeria_koment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_matka` (`id_matka`);

--
-- Indeksy dla tabeli `luminar_grupy_uzytkownicy`
--
ALTER TABLE `luminar_grupy_uzytkownicy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_u` (`id_u`),
  ADD KEY `data_dodania` (`data_dodania`),
  ADD KEY `status` (`status`),
  ADD KEY `ostatnia_wizyta` (`ostatnia_wizyta`);

--
-- Indeksy dla tabeli `luminar_guestbook`
--
ALTER TABLE `luminar_guestbook`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `luminar_konfig`
--
ALTER TABLE `luminar_konfig`
  ADD PRIMARY KEY (`idtf`,`lang`);

--
-- Indeksy dla tabeli `luminar_logi`
--
ALTER TABLE `luminar_logi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kiedy` (`kiedy`),
  ADD KEY `id_u` (`id_u`),
  ADD KEY `idtf` (`idtf`),
  ADD KEY `login` (`login`);

--
-- Indeksy dla tabeli `luminar_poczta`
--
ALTER TABLE `luminar_poczta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_autor` (`id_autor`),
  ADD KEY `id_odb` (`id_odb`),
  ADD KEY `data_wys` (`data_wys`),
  ADD KEY `status` (`status`),
  ADD KEY `wykonana` (`wykonana`),
  ADD KEY `zdefiniowana` (`zdefiniowana`);

--
-- Indeksy dla tabeli `luminar_rotator`
--
ALTER TABLE `luminar_rotator`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_typ` (`id_typ`),
  ADD KEY `status` (`status`),
  ADD KEY `lang` (`lang`),
  ADD KEY `data_start` (`data_start`),
  ADD KEY `data_stop` (`data_stop`),
  ADD KEY `udzial` (`udzial`);

--
-- Indeksy dla tabeli `luminar_sklep_kat`
--
ALTER TABLE `luminar_sklep_kat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `nr_poz` (`nr_poz`),
  ADD KEY `id_autor` (`autor_id`),
  ADD KEY `data_start` (`data_start`),
  ADD KEY `data_stop` (`data_stop`),
  ADD KEY `poziom` (`poziom`),
  ADD KEY `id_d` (`id_d`),
  ADD KEY `id_pierwszy` (`id_pierwszy`),
  ADD KEY `typ` (`typ`);

--
-- Indeksy dla tabeli `luminar_sklep_producenci`
--
ALTER TABLE `luminar_sklep_producenci`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `id_autor` (`autor_id`);

--
-- Indeksy dla tabeli `luminar_sklep_produkty`
--
ALTER TABLE `luminar_sklep_produkty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `id_autor` (`autor_id`),
  ADD KEY `data_start` (`data_start`),
  ADD KEY `data_stop` (`data_stop`),
  ADD KEY `id_producent` (`id_producent`),
  ADD KEY `nowosc` (`nowosc`),
  ADD KEY `nowosc_start` (`nowosc_start`),
  ADD KEY `nowosc_stop` (`nowosc_stop`),
  ADD KEY `promocja` (`promocja`),
  ADD KEY `promocja_start` (`promocja_start`),
  ADD KEY `promocja_stop` (`promocja_stop`),
  ADD KEY `wyprzedarz_stop` (`wyprzedaz_stop`),
  ADD KEY `wyprzedaz_start` (`wyprzedaz_start`),
  ADD KEY `polecamy` (`polecamy`),
  ADD KEY `polecamy_start` (`polecamy_start`),
  ADD KEY `cena` (`cena`),
  ADD KEY `glosy_srednia` (`glosy_srednia`),
  ADD KEY `nazwa` (`nazwa`),
  ADD KEY `symbol` (`symbol`);

--
-- Indeksy dla tabeli `luminar_sklep_zamowienia`
--
ALTER TABLE `luminar_sklep_zamowienia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `id_autor` (`autor_id`),
  ADD KEY `id_u` (`id_u`),
  ADD KEY `kwota_zam` (`zam_kwota`),
  ADD KEY `zam_data` (`zam_data`);

--
-- Indeksy dla tabeli `luminar_sklep_zamowienia_produkty`
--
ALTER TABLE `luminar_sklep_zamowienia_produkty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_zam` (`id_zam`),
  ADD KEY `id_produkt` (`id_produkt`),
  ADD KEY `id_wersja` (`id_wersja`),
  ADD KEY `id_kolor` (`id_kolor`),
  ADD KEY `id_rozmiar` (`id_rozmiar`);

--
-- Indeksy dla tabeli `luminar_subskrypcja`
--
ALTER TABLE `luminar_subskrypcja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `idtf` (`idtf`),
  ADD KEY `zalogowanie` (`sprcheck`);

--
-- Indeksy dla tabeli `luminar_subskrypcja_pliki`
--
ALTER TABLE `luminar_subskrypcja_pliki`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_matka` (`id_matka`);

--
-- Indeksy dla tabeli `luminar_subskrypcja_wiadomosci`
--
ALTER TABLE `luminar_subskrypcja_wiadomosci`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data` (`data`),
  ADD KEY `tytul` (`tytul`);

--
-- Indeksy dla tabeli `luminar_uzytkownicy`
--
ALTER TABLE `luminar_uzytkownicy`
  ADD PRIMARY KEY (`id`),
  ADD KEY `login` (`login`),
  ADD KEY `status` (`status`),
  ADD KEY `zalogowanie` (`zalogowanie`),
  ADD KEY `last_log` (`last_log`),
  ADD KEY `email` (`email`),
  ADD KEY `typ` (`typ`),
  ADD KEY `niewygasa` (`niewygasa`);

--
-- Indeksy dla tabeli `luminar_uzytkownicy_galeria`
--
ALTER TABLE `luminar_uzytkownicy_galeria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `status` (`status`),
  ADD KEY `id_matka` (`id_matka`),
  ADD KEY `nr_poz` (`nr_poz`);

--
-- Indeksy dla tabeli `luminar_uzytkownicy_galeria_koment`
--
ALTER TABLE `luminar_uzytkownicy_galeria_koment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_matka` (`id_matka`);

--
-- Indeksy dla tabeli `luminar_uzytkownicy_koment`
--
ALTER TABLE `luminar_uzytkownicy_koment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_matka` (`id_matka`);

--
-- Indeksy dla tabeli `luminar_zablokowani`
--
ALTER TABLE `luminar_zablokowani`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_u` (`id_u`),
  ADD KEY `data_dodania` (`data_dodania`);

--
-- Indeksy dla tabeli `luminar_znajomi`
--
ALTER TABLE `luminar_znajomi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_u` (`id_u`),
  ADD KEY `data_dodania` (`data_dodania`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `antyki_ankieta`
--
ALTER TABLE `antyki_ankieta`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT dla tabeli `antyki_ankieta_glosy`
--
ALTER TABLE `antyki_ankieta_glosy`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `antyki_ankieta_list`
--
ALTER TABLE `antyki_ankieta_list`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT dla tabeli `antyki_art`
--
ALTER TABLE `antyki_art`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=316;

--
-- AUTO_INCREMENT dla tabeli `antyki_artd`
--
ALTER TABLE `antyki_artd`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `antyki_art_akapity`
--
ALTER TABLE `antyki_art_akapity`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT dla tabeli `antyki_art_akapityd`
--
ALTER TABLE `antyki_art_akapityd`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `antyki_art_dziennik`
--
ALTER TABLE `antyki_art_dziennik`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `antyki_art_galeria`
--
ALTER TABLE `antyki_art_galeria`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=251;

--
-- AUTO_INCREMENT dla tabeli `antyki_art_komentarze`
--
ALTER TABLE `antyki_art_komentarze`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `antyki_bany`
--
ALTER TABLE `antyki_bany`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `antyki_forum_d`
--
ALTER TABLE `antyki_forum_d`
  MODIFY `id` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `antyki_forum_p`
--
ALTER TABLE `antyki_forum_p`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT dla tabeli `antyki_forum_t`
--
ALTER TABLE `antyki_forum_t`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT dla tabeli `antyki_guestbook`
--
ALTER TABLE `antyki_guestbook`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `antyki_logi`
--
ALTER TABLE `antyki_logi`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4501;

--
-- AUTO_INCREMENT dla tabeli `antyki_poczta`
--
ALTER TABLE `antyki_poczta`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT dla tabeli `antyki_rotator`
--
ALTER TABLE `antyki_rotator`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT dla tabeli `antyki_sklep_kat`
--
ALTER TABLE `antyki_sklep_kat`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

--
-- AUTO_INCREMENT dla tabeli `antyki_sklep_producenci`
--
ALTER TABLE `antyki_sklep_producenci`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `antyki_sklep_produkty`
--
ALTER TABLE `antyki_sklep_produkty`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=885;

--
-- AUTO_INCREMENT dla tabeli `antyki_sklep_zamowienia`
--
ALTER TABLE `antyki_sklep_zamowienia`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `antyki_sklep_zamowienia_produkty`
--
ALTER TABLE `antyki_sklep_zamowienia_produkty`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `antyki_subskrypcja`
--
ALTER TABLE `antyki_subskrypcja`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `antyki_subskrypcja_pliki`
--
ALTER TABLE `antyki_subskrypcja_pliki`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `antyki_subskrypcja_wiadomosci`
--
ALTER TABLE `antyki_subskrypcja_wiadomosci`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT dla tabeli `antyki_uzytkownicy`
--
ALTER TABLE `antyki_uzytkownicy`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT dla tabeli `antyki_zablokowani`
--
ALTER TABLE `antyki_zablokowani`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `antyki_znajomi`
--
ALTER TABLE `antyki_znajomi`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `arkadia_ankieta`
--
ALTER TABLE `arkadia_ankieta`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_ankieta_glosy`
--
ALTER TABLE `arkadia_ankieta_glosy`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_ankieta_list`
--
ALTER TABLE `arkadia_ankieta_list`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_art`
--
ALTER TABLE `arkadia_art`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT dla tabeli `arkadia_artd`
--
ALTER TABLE `arkadia_artd`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_art_akapity`
--
ALTER TABLE `arkadia_art_akapity`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT dla tabeli `arkadia_art_akapityd`
--
ALTER TABLE `arkadia_art_akapityd`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_art_dziennik`
--
ALTER TABLE `arkadia_art_dziennik`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_art_galeria`
--
ALTER TABLE `arkadia_art_galeria`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT dla tabeli `arkadia_art_koment`
--
ALTER TABLE `arkadia_art_koment`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_bany`
--
ALTER TABLE `arkadia_bany`
  MODIFY `id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_forum_c`
--
ALTER TABLE `arkadia_forum_c`
  MODIFY `id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_forum_d`
--
ALTER TABLE `arkadia_forum_d`
  MODIFY `id` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_forum_f`
--
ALTER TABLE `arkadia_forum_f`
  MODIFY `id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_forum_p`
--
ALTER TABLE `arkadia_forum_p`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_forum_pp`
--
ALTER TABLE `arkadia_forum_pp`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_forum_t`
--
ALTER TABLE `arkadia_forum_t`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_forum_tt`
--
ALTER TABLE `arkadia_forum_tt`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_grupy`
--
ALTER TABLE `arkadia_grupy`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_grupy_galeria`
--
ALTER TABLE `arkadia_grupy_galeria`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_grupy_galeria_koment`
--
ALTER TABLE `arkadia_grupy_galeria_koment`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_grupy_uzytkownicy`
--
ALTER TABLE `arkadia_grupy_uzytkownicy`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_guestbook`
--
ALTER TABLE `arkadia_guestbook`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_logi`
--
ALTER TABLE `arkadia_logi`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1360;

--
-- AUTO_INCREMENT dla tabeli `arkadia_poczta`
--
ALTER TABLE `arkadia_poczta`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_rotator`
--
ALTER TABLE `arkadia_rotator`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_sklep_kat`
--
ALTER TABLE `arkadia_sklep_kat`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_sklep_producenci`
--
ALTER TABLE `arkadia_sklep_producenci`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_sklep_produkty`
--
ALTER TABLE `arkadia_sklep_produkty`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_sklep_zamowienia`
--
ALTER TABLE `arkadia_sklep_zamowienia`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_sklep_zamowienia_produkty`
--
ALTER TABLE `arkadia_sklep_zamowienia_produkty`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_subskrypcja`
--
ALTER TABLE `arkadia_subskrypcja`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_subskrypcja_pliki`
--
ALTER TABLE `arkadia_subskrypcja_pliki`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_subskrypcja_wiadomosci`
--
ALTER TABLE `arkadia_subskrypcja_wiadomosci`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_uzytkownicy`
--
ALTER TABLE `arkadia_uzytkownicy`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `arkadia_uzytkownicy_galeria`
--
ALTER TABLE `arkadia_uzytkownicy_galeria`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_uzytkownicy_galeria_koment`
--
ALTER TABLE `arkadia_uzytkownicy_galeria_koment`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_uzytkownicy_koment`
--
ALTER TABLE `arkadia_uzytkownicy_koment`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_zablokowani`
--
ALTER TABLE `arkadia_zablokowani`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `arkadia_znajomi`
--
ALTER TABLE `arkadia_znajomi`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_ankieta`
--
ALTER TABLE `luminar_ankieta`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_ankieta_glosy`
--
ALTER TABLE `luminar_ankieta_glosy`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_ankieta_list`
--
ALTER TABLE `luminar_ankieta_list`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_art`
--
ALTER TABLE `luminar_art`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT dla tabeli `luminar_artd`
--
ALTER TABLE `luminar_artd`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_art_akapity`
--
ALTER TABLE `luminar_art_akapity`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT dla tabeli `luminar_art_akapityd`
--
ALTER TABLE `luminar_art_akapityd`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_art_dziennik`
--
ALTER TABLE `luminar_art_dziennik`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_art_galeria`
--
ALTER TABLE `luminar_art_galeria`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_art_koment`
--
ALTER TABLE `luminar_art_koment`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_bany`
--
ALTER TABLE `luminar_bany`
  MODIFY `id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_forum_c`
--
ALTER TABLE `luminar_forum_c`
  MODIFY `id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_forum_d`
--
ALTER TABLE `luminar_forum_d`
  MODIFY `id` smallint(4) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_forum_f`
--
ALTER TABLE `luminar_forum_f`
  MODIFY `id` int(7) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_forum_p`
--
ALTER TABLE `luminar_forum_p`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_forum_pp`
--
ALTER TABLE `luminar_forum_pp`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_forum_t`
--
ALTER TABLE `luminar_forum_t`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_forum_tt`
--
ALTER TABLE `luminar_forum_tt`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_grupy`
--
ALTER TABLE `luminar_grupy`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_grupy_galeria`
--
ALTER TABLE `luminar_grupy_galeria`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_grupy_galeria_koment`
--
ALTER TABLE `luminar_grupy_galeria_koment`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_grupy_uzytkownicy`
--
ALTER TABLE `luminar_grupy_uzytkownicy`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_guestbook`
--
ALTER TABLE `luminar_guestbook`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_logi`
--
ALTER TABLE `luminar_logi`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=287;

--
-- AUTO_INCREMENT dla tabeli `luminar_poczta`
--
ALTER TABLE `luminar_poczta`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_rotator`
--
ALTER TABLE `luminar_rotator`
  MODIFY `id` int(12) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `luminar_sklep_kat`
--
ALTER TABLE `luminar_sklep_kat`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT dla tabeli `luminar_sklep_producenci`
--
ALTER TABLE `luminar_sklep_producenci`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_sklep_produkty`
--
ALTER TABLE `luminar_sklep_produkty`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT dla tabeli `luminar_sklep_zamowienia`
--
ALTER TABLE `luminar_sklep_zamowienia`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_sklep_zamowienia_produkty`
--
ALTER TABLE `luminar_sklep_zamowienia_produkty`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_subskrypcja`
--
ALTER TABLE `luminar_subskrypcja`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_subskrypcja_pliki`
--
ALTER TABLE `luminar_subskrypcja_pliki`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_subskrypcja_wiadomosci`
--
ALTER TABLE `luminar_subskrypcja_wiadomosci`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_uzytkownicy`
--
ALTER TABLE `luminar_uzytkownicy`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT dla tabeli `luminar_uzytkownicy_galeria`
--
ALTER TABLE `luminar_uzytkownicy_galeria`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_uzytkownicy_galeria_koment`
--
ALTER TABLE `luminar_uzytkownicy_galeria_koment`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_uzytkownicy_koment`
--
ALTER TABLE `luminar_uzytkownicy_koment`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_zablokowani`
--
ALTER TABLE `luminar_zablokowani`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `luminar_znajomi`
--
ALTER TABLE `luminar_znajomi`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
