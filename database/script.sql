-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Czas wygenerowania: 27 Kwi 2014, 20:02
-- Wersja serwera: 5.5.32
-- Wersja PHP: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `integra_manager`
--
CREATE DATABASE IF NOT EXISTS `integra_manager` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `integra_manager`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `im_events`
--

CREATE TABLE IF NOT EXISTS `im_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `index_1` int(11) NOT NULL,
  `index_2` int(11) NOT NULL,
  `index_3` int(11) NOT NULL,
  `call_index_1` int(11) NOT NULL,
  `call_index_2` int(11) NOT NULL,
  `call_index_3` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Zrzut danych tabeli `im_events`
--

INSERT INTO `im_events` (`id`, `index_1`, `index_2`, `index_3`, `call_index_1`, `call_index_2`, `call_index_3`, `time`, `description`) VALUES
(1, 1, 2, 3, 3, 2, 1, '2014-04-25 07:28:19', 'Brak kabla siec.'),
(2, 1, 2, 3, 3, 2, 1, '2014-04-25 07:28:19', 'Naruszenie strefy 2'),
(3, 1, 2, 3, 3, 2, 1, '2014-04-25 07:28:19', 'Naruszenie strefy 1');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `im_system_status_values`
--

CREATE TABLE IF NOT EXISTS `im_system_status_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` int(11) NOT NULL,
  `description` varchar(80) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Zrzut danych tabeli `im_system_status_values`
--

INSERT INTO `im_system_status_values` (`id`, `value`, `description`) VALUES
(1, 0, 'Rozbrojony'),
(2, 1, 'Uzbrojony');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `im_system_statuses`
--

CREATE TABLE IF NOT EXISTS `im_system_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `statusValue_idx` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `im_system_statuses`
--

INSERT INTO `im_system_statuses` (`id`, `name`, `status`) VALUES
(1, 'Status systemu', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `im_users`
--

CREATE TABLE IF NOT EXISTS `im_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `name` varchar(80) NOT NULL,
  `email` varchar(80) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `last_login_time` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `im_users`
--

INSERT INTO `im_users` (`id`, `login`, `password`, `name`, `email`, `code`, `last_login_time`) VALUES
(1, 'bstokrocki', 'test1234', 'Bartek Stokrocki', 'bartek.stokrocki@gmail.com', '1234', NULL);

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `im_system_statuses`
--
ALTER TABLE `im_system_statuses`
  ADD CONSTRAINT `statusValue` FOREIGN KEY (`status`) REFERENCES `im_system_status_values` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
