-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 22, 2022 at 05:20 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cinemaster`
--


CREATE DATABASE if not exists cinemaster;


-- --------------------------------------------------------

--
-- Svuoto il database dalle tabelle esistenti
--
DROP TABLE if exists user_table;
DROP TABLE if exists films;
DROP TABLE if exists tickets;

--
-- Table structure for table `films`
--

CREATE TABLE films (
    `id` int(11) NOT NULL,
    `title` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
    `publish_date` DATE,
    `regista` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
    `duration` int,
    `price` float,
    `category` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
    `description` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
    `img` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Table structure for table `user_table`
--

CREATE TABLE user_table (
    `id` int(11) NOT NULL,
    `first_name` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
    `surname` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
    `password` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
    `email` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
    `date_of_birth` DATE,
    `role` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
    `is_logged` boolean
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Table structure for table `tickets`
--

CREATE TABLE tickets (
    `id` int(11) NOT NULL,
    `filmId` INT,
    `userId` INT,
    `numeroPersone` INT,
    `prezzoTotale` FLOAT,
    `dataOra` TIMESTAMP,
    `numeroRidotti` INT,
    `pagato` boolean,
    `posti` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--
-- Dumping data for table `films`
--

INSERT INTO `films` (`id`,`title`,`publish_date`,`regista`,`duration`,`price`,`category`,`description`,`img`) VALUES
(1, 'Die Hart the Movie', '2023-03-03', 'Eric Appel', 92, 15, 'Azione', 'Kevin Hart, è impegnato in una missione dove sfida la morte per diventare una star di azione. E con un piccolo aiuto da parte di John Travolta, Nathalie Emmanuel e Josh Hartnett, potrebbe farcela.', 'die_hart.jpg'),
(2, 'Unlocked', '2023-03-09', 'Kim Tae-joon', 100, 18, 'Drammatico', 'La vita di una donna viene stravolta dopo che un uomo pericoloso entra in possesso del suo cellulare smarrito e lo usa per seguire ogni sua mossa.', 'unlocked.jpg'),
(3, 'Dog Gone', '2023-05-01', 'Stephen Herek', 88, 15, 'Per famiglie', 'Quando il suo amato cane scompare, un giovane si imbarca in una incredibile ricerca con i suoi genitori per trovarlo e dargli un farmaco salvavita.', 'dog_gone.jpg'),
(4, 'True Spirit', '2023-08-10', 'Danny Ruhlmann', 96, 15, 'Azione', 'Una tenace adolescente australiana insegue i suoi sogni, e affronta le sue paure, mentre si accinge a diventare la più giovane persona a navigare in solitaria intorno al mondo.', 'true_spirit.jpg');


--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`id`,`first_name`,`surname`,`password`,`email`,`date_of_birth`,`role`,`is_logged`) VALUES
(1, 'Alice', 'Corvetto', 'alccrvtt', 'alice.corvetto@cmail.it', '1999-03-03 00:00:00', 'utente','0'),
(2,'Marco', 'Donati', 'mrcdnt', 'marco.donati@cmail.it', '2001-05-05 00:00:00', 'utente','0'),
(3,'Giovanni', 'Roselli', 'gvnnrsll', 'giovanni_roselli@cmail.it', '2000-04-04 00:00:00', 'utente','0'),
(4,'Luca', 'Grazioli', 'cinemaster_77456', 'admin_luca@cinemaster.com', '1970-01-01 00:00:00', 'admin','0'),
(5,'Sara', 'Flori', 'cinemaster_33245', 'admin_sara@cinemaster.it', '1970-01-01 00:00:00', 'admin','0');



--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`,`filmId`,`userId`,`numeroPersone`,`prezzoTotale`,`dataOra`,`numeroRidotti`,`pagato`,`posti`) VALUES
(20, 1, 1, 2, 30.0, '2023-04-04 15:00:00-02', 0,'A1,A2','0'),
(21, 1,1, 1, 30.0, '2023-08-04 19:00:00-02', 0,'G5','1');


--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`id`);


--
-- Indexes for table `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `films`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `prodotti_ibfk_1` (`filmId`),
  ADD KEY `prodotti_ibfk_2` (`userId`);


--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;



--
-- AUTO_INCREMENT for table `films`
--
ALTER TABLE `films`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;



--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


--
-- Constraints for table `tickets`
--

-- ALTER TABLE `tickets`
-- ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`filmId`) REFERENCES `films` (`id`),
-- ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `user_table` (`id`);



COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



