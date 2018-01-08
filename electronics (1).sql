-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 04, 2017 at 04:04 PM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `electronics`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `ID` int(11) NOT NULL,
  `Nome` varchar(25) NOT NULL,
  `Cognome` varchar(25) NOT NULL,
  `Email` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`ID`, `Nome`, `Cognome`, `Email`) VALUES
(1, 'Admin', 'Administrator', 'admin@electronics.com');

-- --------------------------------------------------------

--
-- Table structure for table `annunci`
--

CREATE TABLE `annunci` (
  `ID` int(11) NOT NULL,
  `Titolo` varchar(25) NOT NULL,
  `Descrizione` varchar(150) NOT NULL,
  `Prezzo` float(10,2) NOT NULL,
  `DataInserimento` date NOT NULL,
  `Status` enum('Online','Offline') NOT NULL DEFAULT 'Online',
  `Views` int(11) NOT NULL DEFAULT '0',
  `FKutente` int(11) NOT NULL,
  `FKsottocategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `annunci`
--

INSERT INTO `annunci` (`ID`, `Titolo`, `Descrizione`, `Prezzo`, `DataInserimento`, `Status`, `Views`, `FKutente`, `FKsottocategoria`) VALUES
(4, 'Telefono Android', 'Vendo telefono Android in perfette condizioni', 52.00, '2017-05-01', 'Online', 0, 1, 1),
(5, 'iPhone iOS 8.0', 'Vendo iPhone in perfette condizioni.\r\n', 78.00, '2017-05-03', 'Online', 0, 1, 2),
(7, 'iPhone 8', 'fsadfad', 123.00, '2017-05-06', 'Online', 0, 1, 2),
(8, 'fantastico telefono', 'mai stato cosÃ¬ bello', 67.00, '2017-05-07', 'Online', 0, 1, 1),
(13, 'Offerta offertissima', 'Descrivimi come vuoi tu', 66.00, '2017-05-07', 'Online', 0, 1, 5),
(14, 'Computer Assemblato', 'Ottimo computer assemblato in casa', 760.00, '2017-06-08', 'Online', 0, 1, 3),
(16, 'Titolo', 'Descrizione', 80.00, '1257-12-12', 'Online', 0, 1, 3),
(17, 'iPad Air', 'ottimo iPad air', 500.00, '2017-06-08', 'Online', 0, 1, 6),
(18, 'iPad Pro', 'iPad Pro ottime condizioni', 900.00, '2017-06-08', 'Online', 0, 1, 6),
(19, 'MacBook Pro', 'MacBook pro usatissimo', 300.00, '2017-06-08', 'Online', 0, 1, 4),
(20, 'Computer PreAssemblato', 'Computer montato dai cinesi', 500.00, '2017-06-08', 'Online', 0, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `citta`
--

CREATE TABLE `citta` (
  `ID` smallint(6) NOT NULL,
  `Nome` varchar(30) NOT NULL,
  `FKregion` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `citta`
--

INSERT INTO `citta` (`ID`, `Nome`, `FKregion`) VALUES
(1, 'Milano', 1),
(2, 'Roma', 2);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `FKutente` int(11) NOT NULL,
  `FKannuncio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`FKutente`, `FKannuncio`) VALUES
(1, 4),
(1, 7),
(1, 13),
(6, 4),
(6, 5);

-- --------------------------------------------------------

--
-- Table structure for table `macrocategory`
--

CREATE TABLE `macrocategory` (
  `ID` int(11) NOT NULL,
  `Nome` varchar(10) NOT NULL,
  `Descrizione` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `macrocategory`
--

INSERT INTO `macrocategory` (`ID`, `Nome`, `Descrizione`) VALUES
(1, 'Telefoni', 'Telefoni cellulari Android e iOS'),
(2, 'Computer', 'Computer PC Preassemblati & Macintosh'),
(3, 'Tablet', 'Tablet Android & iOS');

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE `pictures` (
  `ID` int(11) NOT NULL,
  `FKannunci` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `region`
--

CREATE TABLE `region` (
  `ID` tinyint(4) NOT NULL,
  `Nome` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `region`
--

INSERT INTO `region` (`ID`, `Nome`) VALUES
(1, 'Lombardia '),
(2, 'Lazio');

-- --------------------------------------------------------

--
-- Table structure for table `sottocategory`
--

CREATE TABLE `sottocategory` (
  `ID` int(11) NOT NULL,
  `Nome` varchar(20) NOT NULL,
  `FKcategory` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sottocategory`
--

INSERT INTO `sottocategory` (`ID`, `Nome`, `FKcategory`) VALUES
(1, 'Android', 1),
(2, 'iOS', 1),
(3, 'PC assemblati', 2),
(4, 'Apple Macintosh', 2),
(5, 'Tablet Android', 3),
(6, 'iPad', 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `Nome` varchar(25) NOT NULL,
  `Cognome` varchar(25) NOT NULL,
  `Sesso` enum('M','F') NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `FKCity` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Nome`, `Cognome`, `Sesso`, `Email`, `Password`, `FKCity`) VALUES
(1, 'Gigi', 'Pigi', 'F', 'gigipigi@gmail.com', '25f9e794323b453885f5181f1b624d0b', 1),
(6, 'Gigiolino', 'Pigiolino', 'M', 'gigiolinopigiolino@gmail.com', '25f9e794323b453885f5181f1b624d0b', 2),
(7, 'Tester', 'Tester123', 'F', 'tester@test.it', 'ab56b4d92b40713acc5af89985d4b786', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `annunci`
--
ALTER TABLE `annunci`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FKutente` (`FKutente`),
  ADD KEY `FKsottocategoria` (`FKsottocategoria`);
ALTER TABLE `annunci` ADD FULLTEXT KEY `Titolo` (`Titolo`,`Descrizione`);

--
-- Indexes for table `citta`
--
ALTER TABLE `citta`
  ADD PRIMARY KEY (`ID`,`FKregion`),
  ADD KEY `FKregion` (`FKregion`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`FKutente`,`FKannuncio`),
  ADD KEY `FKannuncio` (`FKannuncio`);

--
-- Indexes for table `macrocategory`
--
ALTER TABLE `macrocategory`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FKannunci` (`FKannunci`);

--
-- Indexes for table `region`
--
ALTER TABLE `region`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `sottocategory`
--
ALTER TABLE `sottocategory`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FKcategory` (`FKcategory`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FKCity` (`FKCity`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `annunci`
--
ALTER TABLE `annunci`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT for table `citta`
--
ALTER TABLE `citta`
  MODIFY `ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `macrocategory`
--
ALTER TABLE `macrocategory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `region`
--
ALTER TABLE `region`
  MODIFY `ID` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `sottocategory`
--
ALTER TABLE `sottocategory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `annunci`
--
ALTER TABLE `annunci`
  ADD CONSTRAINT `annunci_ibfk_1` FOREIGN KEY (`FKutente`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `annunci_ibfk_2` FOREIGN KEY (`FKsottocategoria`) REFERENCES `sottocategory` (`ID`);

--
-- Constraints for table `citta`
--
ALTER TABLE `citta`
  ADD CONSTRAINT `citta_ibfk_1` FOREIGN KEY (`FKregion`) REFERENCES `region` (`ID`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`FKutente`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`FKannuncio`) REFERENCES `annunci` (`ID`);

--
-- Constraints for table `pictures`
--
ALTER TABLE `pictures`
  ADD CONSTRAINT `pictures_ibfk_1` FOREIGN KEY (`FKannunci`) REFERENCES `annunci` (`ID`);

--
-- Constraints for table `sottocategory`
--
ALTER TABLE `sottocategory`
  ADD CONSTRAINT `sottocategory_ibfk_1` FOREIGN KEY (`FKcategory`) REFERENCES `macrocategory` (`ID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
