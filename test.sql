-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 22. Jan, 2020 12:03 PM
-- Tjener-versjon: 10.4.10-MariaDB
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `emner`
--

DROP TABLE IF EXISTS `emner`;
CREATE TABLE IF NOT EXISTS `emner` (
  `emneKode` int(4) NOT NULL,
  `navn` varchar(100) NOT NULL,
  `foreleserNavn` text NOT NULL,
  `foreleserID` varchar(10) NOT NULL,
  `PIN` int(4) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`emneKode`),
  UNIQUE KEY `Unique` (`PIN`)
) ENGINE=MyISAM AUTO_INCREMENT=1238 DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `emner`
--

INSERT INTO `emner` (`emneKode`, `navn`, `foreleserNavn`, `foreleserID`, `PIN`) VALUES
(5432, 'Datasikkerhet', 'Henrik', 'hen5555', 1111),
(2345, 'Algoritmer', 'Høiberg', 'kø9876', 1234),
(4444, 'Datasikkerhet2', 'Frida Unneberg', 'abc1234', 1236),
(6666, 'Rammeverk', 'Frida Unneberg', 'abc1234', 1237);

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `forelesere`
--

DROP TABLE IF EXISTS `forelesere`;
CREATE TABLE IF NOT EXISTS `forelesere` (
  `ansattID` varchar(100) NOT NULL,
  `navn` text NOT NULL,
  `epost` varchar(100) NOT NULL,
  `bilde` varchar(50) NOT NULL,
  `passord` varchar(10) NOT NULL,
  PRIMARY KEY (`ansattID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `forelesere`
--

INSERT INTO `forelesere` (`ansattID`, `navn`, `epost`, `bilde`, `passord`) VALUES
('abc1234', 'Hei', 'hei@hotmail.com', '123Link', '654321');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `meldinger`
--

DROP TABLE IF EXISTS `meldinger`;
CREATE TABLE IF NOT EXISTS `meldinger` (
  `meldingKode` varchar(10) NOT NULL,
  `melding` text NOT NULL,
  `emneKode` varchar(10) NOT NULL,
  `studentID` varchar(10) NOT NULL,
  `svar` text NOT NULL,
  PRIMARY KEY (`meldingKode`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `meldinger`
--

INSERT INTO `meldinger` (`meldingKode`, `melding`, `emneKode`, `studentID`, `svar`) VALUES
('meld2', 'heiheihei', '1234', 'fri2912', ''),
('meld1', 'heiheihei', '5432', 'fri2912', ''),
('meld3', 'HalloHalloHallo', '1234', 'fri2912', '');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `passord`
--

DROP TABLE IF EXISTS `passord`;
CREATE TABLE IF NOT EXISTS `passord` (
  `studentID` varchar(10) NOT NULL,
  `passord` varchar(10) NOT NULL,
  PRIMARY KEY (`studentID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `passord`
--

INSERT INTO `passord` (`studentID`, `passord`) VALUES
('fri2912', '123456');

-- --------------------------------------------------------

--
-- Tabellstruktur for tabell `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `studentID` varchar(7) NOT NULL,
  `navn` varchar(200) NOT NULL,
  `epost` varchar(200) NOT NULL,
  `studieretning` text NOT NULL,
  `kull` int(4) NOT NULL,
  `passord` varchar(7) NOT NULL,
  PRIMARY KEY (`studentID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dataark for tabell `students`
--

INSERT INTO `students` (`studentID`, `navn`, `epost`, `studieretning`, `kull`, `passord`) VALUES
('fri2912', 'Frida Unneberg', 'friunn@hotmail.com', 'Informatikk', 2018, '123456'),
('avl1995', 'Alex', 'alex@epost', 'Informatikk', 2018, 'alex123');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
