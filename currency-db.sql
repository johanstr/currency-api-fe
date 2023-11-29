-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Gegenereerd op: 29 nov 2023 om 12:50
-- Serverversie: 8.0.31
-- PHP-versie: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `currency-db`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `clients`
--

DROP TABLE IF EXISTS `clients`;
CREATE TABLE IF NOT EXISTS `clients` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Gegevens worden geëxporteerd voor tabel `clients`
--

INSERT INTO `clients` (`id`, `username`) VALUES
(1, 'Truus von Miepenstein'),
(2, 'Koos Klaproos'),
(3, 'Gerrit Graaier');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `currencies`
--

DROP TABLE IF EXISTS `currencies`;
CREATE TABLE IF NOT EXISTS `currencies` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `abbr` varchar(3) NOT NULL,
  `value` decimal(10,6) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `flag` varchar(255) DEFAULT NULL,
  `unicode_symbol` varchar(8) DEFAULT '&#xa4;' COMMENT 'Unicode code for the symbol in HEX-format',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1 COMMENT='Value for 1 EUR';

--
-- Gegevens worden geëxporteerd voor tabel `currencies`
--

INSERT INTO `currencies` (`id`, `abbr`, `value`, `name`, `country`, `flag`, `unicode_symbol`, `updated_at`) VALUES
(1, 'USD', '1.094900', 'US Dollar', 'VERENIGDE STATEN VAN AMERIKA (DE)', 'http://currency-api.ao-alfa.org/img/flags/usd.png', '&#x24;', '2023-11-29 11:34:10'),
(2, 'JPY', '162.740000', 'Yen', 'JAPAN', 'http://currency-api.ao-alfa.org/img/flags/jpy.png', '&#xa5;', '2023-11-29 11:34:10'),
(3, 'BGN', '1.955800', 'Bulgaarse Lev', 'BULGARIJE', 'http://currency-api.ao-alfa.org/img/flags/bgn.png', '&#xa4;', '2023-11-29 11:34:10'),
(4, 'CZK', '24.365000', 'Tjechische Kroon', 'TJECHISCHE REPUBLIEK (DE)', 'http://currency-api.ao-alfa.org/img/flags/czk.png', '&#xa4;', '2023-11-29 11:34:10'),
(5, 'DKK', '7.456000', 'Deense Kroon', 'DENEMARKEN', 'http://currency-api.ao-alfa.org/img/flags/dkk.png', '&#xa4;', '2023-11-29 11:34:10'),
(6, 'GBP', '0.868200', 'Pound Sterling', 'VERENIGD KONINKRIJK VAN GROOT BRITANNIE EN NOORD IERLAND (DE)', 'http://currency-api.ao-alfa.org/img/flags/gbp.png', '&#xa3;', '2023-11-29 11:34:10'),
(7, 'HUF', '379.850000', 'Forint', 'HONGARIJE', 'http://currency-api.ao-alfa.org/img/flags/huf.png', '&#xa4;', '2023-11-29 11:34:10'),
(8, 'PLN', '4.347300', 'Zloty', 'POLEN', 'http://currency-api.ao-alfa.org/img/flags/pln.png', '&#xa4;', '2023-11-29 11:34:10'),
(9, 'RON', '4.972600', 'Roemeense Leu', 'ROEMENIE', 'http://currency-api.ao-alfa.org/img/flags/ron.png', '&#xa4;', '2023-11-29 11:34:10'),
(10, 'SEK', '11.433000', 'Zweedse Kroon', 'ZWEDEN', 'http://currency-api.ao-alfa.org/img/flags/sek.png', '&#xa4;', '2023-11-29 11:34:10'),
(11, 'CHF', '0.964500', 'Zwitserse Franc', 'ZWITSERLAND', 'http://currency-api.ao-alfa.org/img/flags/chf.png', '&#xa4;', '2023-11-29 11:34:10'),
(12, 'ISK', '150.900000', 'IJslandse Kroon', 'IJSLAND', 'http://currency-api.ao-alfa.org/img/flags/isk.png', '&#xa4;', '2023-11-29 11:34:10'),
(13, 'NOK', '11.716500', 'Noorse Kroon', 'NORWEGEN', 'http://currency-api.ao-alfa.org/img/flags/nok.png', '&#xa4;', '2023-11-29 11:34:10'),
(14, 'HRK', '7.536500', 'Kuna', 'CROATIE', 'http://currency-api.ao-alfa.org/img/flags/hrk.png', '&#xa4;', '2023-11-29 11:34:10'),
(15, 'RUB', '117.201000', 'Russische Roebel', 'RUSSISCHE FEDERATIE (DE)', 'http://currency-api.ao-alfa.org/img/flags/rub.png', '&#x20bd;', '2023-11-29 11:34:10'),
(16, 'TRY', '31.679300', 'Turkse Lira', 'TURKIJE', 'http://currency-api.ao-alfa.org/img/flags/try.png', '&#x20a4;', '2023-11-29 11:34:10'),
(17, 'AUD', '1.656700', 'Australische Dollar', 'AUSTRALIE', 'http://currency-api.ao-alfa.org/img/flags/aud.png', '&#xa4;', '2023-11-29 11:34:10'),
(18, 'BRL', '5.359300', 'Braziliaanse Real', 'BRAZILIE', 'http://currency-api.ao-alfa.org/img/flags/brl.png', '&#xa4;', '2023-11-29 11:34:10'),
(19, 'CAD', '1.488700', 'Canadese Dollar', 'CANADA', 'http://currency-api.ao-alfa.org/img/flags/cad.png', '&#xa4;', '2023-11-29 11:34:10'),
(20, 'CNY', '7.832300', 'Yuan Renminbi', 'CHINA', 'http://currency-api.ao-alfa.org/img/flags/cny.png', '&#xa4;', '2023-11-29 11:34:10'),
(21, 'HKD', '8.536800', 'Hong Kong Dollar', 'HONG KONG', 'http://currency-api.ao-alfa.org/img/flags/hkd.png', '&#xa4;', '2023-11-29 11:34:10'),
(22, 'ILS', '4.054600', 'Nieuwe Israelische shekel', 'ISRAEL', 'http://currency-api.ao-alfa.org/img/flags/ils.png', '&#xa4;', '2023-11-29 11:34:10'),
(23, 'INR', '91.255000', 'Indiase Roepie', 'INDIA', 'http://currency-api.ao-alfa.org/img/flags/inr.png', '&#x20a8;', '2023-11-29 11:34:10'),
(24, 'KRW', '1419.890000', 'Won', 'KOREA (DE REPUBLIEK VAN)', 'http://currency-api.ao-alfa.org/img/flags/krw.png', '&#x20a9;', '2023-11-29 11:34:10'),
(25, 'MXN', '18.809500', 'Mexicaanse Peso', 'MEXICO', 'http://currency-api.ao-alfa.org/img/flags/mxn.png', '&#x20b1;', '2023-11-29 11:34:10'),
(26, 'MYR', '5.114800', 'Maleisische Ringgit', 'MALEISIE', 'http://currency-api.ao-alfa.org/img/flags/myr.png', '&#xa4;', '2023-11-29 11:34:10'),
(27, 'NZD', '1.798000', 'Nieuw Zeeland Dollar', 'NIEUW ZEELAND', 'http://currency-api.ao-alfa.org/img/flags/nzd.png', '&#xa4;', '2023-11-29 11:34:10'),
(28, 'PHP', '60.696000', 'Filippijnse Peso', 'FIlIPPIJNEN (DE)', 'http://currency-api.ao-alfa.org/img/flags/php.png', '&#x20b1;', '2023-11-29 11:34:10'),
(29, 'SGD', '1.463000', 'Singapore Dollar', 'SINGAPORE', 'http://currency-api.ao-alfa.org/img/flags/sgd.png', '&#xa4;', '2023-11-29 11:34:10'),
(30, 'THB', '38.234000', 'Baht', 'THAILAND', 'http://currency-api.ao-alfa.org/img/flags/thb.png', '&#xe3f;', '2023-11-29 11:34:10'),
(31, 'ZAR', '20.483300', 'Rand', 'ZUID AFRICA', 'http://currency-api.ao-alfa.org/img/flags/zar.png', '&#xa4;', '2023-11-29 11:34:10'),
(32, 'IDR', '9999.999999', 'Roepia', 'INDONESIE', 'http://currency-api.ao-alfa.org/img/flags/idr.png', '&#xa4;', '2023-11-29 11:34:10');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `wallets`
--

DROP TABLE IF EXISTS `wallets`;
CREATE TABLE IF NOT EXISTS `wallets` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `client_id` bigint NOT NULL,
  `balance` decimal(20,6) NOT NULL DEFAULT '0.000000',
  PRIMARY KEY (`id`),
  KEY `client_id` (`client_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3;

--
-- Gegevens worden geëxporteerd voor tabel `wallets`
--

INSERT INTO `wallets` (`id`, `client_id`, `balance`) VALUES
(1, 1, '2000.000000'),
(2, 2, '1000.000000'),
(3, 3, '5000.000000');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `wallet_items`
--

DROP TABLE IF EXISTS `wallet_items`;
CREATE TABLE IF NOT EXISTS `wallet_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `wallet_id` bigint UNSIGNED NOT NULL,
  `currency_id` bigint UNSIGNED NOT NULL,
  `bought_on` date DEFAULT NULL,
  `bought_value` decimal(10,6) DEFAULT NULL,
  `amount` decimal(20,6) DEFAULT NULL,
  `sold_on` date DEFAULT NULL,
  `sold_for_value` decimal(10,6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wallet_id` (`wallet_id`),
  KEY `currency_id` (`currency_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3;

--
-- Gegevens worden geëxporteerd voor tabel `wallet_items`
--

INSERT INTO `wallet_items` (`id`, `wallet_id`, `currency_id`, `bought_on`, `bought_value`, `amount`, `sold_on`, `sold_for_value`) VALUES
(1, 1, 1, '2022-04-05', '1.110000', '1110.000000', NULL, NULL),
(2, 1, 1, '2022-04-12', '1.096900', '1000.000000', NULL, NULL),
(3, 1, 2, '2022-04-12', '134.760000', '150000.000000', '2022-04-13', '134.760000'),
(4, 2, 6, '2022-04-12', '0.834900', '5000.000000', NULL, NULL),
(5, 3, 3, '2022-04-12', '1.955800', '7.000000', '2022-04-12', '1.995800'),
(6, 3, 7, '2022-04-12', '369.930000', '500.000000', NULL, NULL),
(7, 3, 1, '2022-04-12', '1.196900', '1000.000000', '2022-04-13', '1.096900'),
(8, 2, 2, '2022-04-12', '133.760000', '150000.000000', NULL, NULL),
(9, 2, 1, '2022-04-12', '1.096900', '1000.000000', NULL, NULL),
(10, 3, 20, '2022-04-13', '6.978300', '5000.000000', '2022-04-13', '6.978300'),
(11, 3, 32, '2022-04-13', '9999.999999', '1000000.000000', '2022-04-13', '9999.999999'),
(12, 1, 1, '2022-04-14', '1.096900', '1000.000000', NULL, NULL),
(13, 2, 1, '2022-04-15', '1.096900', '10000.000000', NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
