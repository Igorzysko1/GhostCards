-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 18, 2025 at 12:12 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ghostschool`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `fiszki`
--

CREATE TABLE `fiszki` (
  `fiszka_id` int(11) NOT NULL,
  `zestaw_id` int(11) NOT NULL,
  `pytanie` text NOT NULL,
  `odpowiedz` varchar(255) NOT NULL,
  `ostatnio_wyswietlone` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fiszki`
--

INSERT INTO `fiszki` (`fiszka_id`, `zestaw_id`, `pytanie`, `odpowiedz`, `ostatnio_wyswietlone`) VALUES
(1, 2, 'W którym roku odbył się chrzest Polski?', '966', '0000-00-00 00:00:00'),
(2, 2, 'Kto był pierwszym królem Polski?', 'Bolesław Chrobry', '0000-00-00 00:00:00'),
(3, 2, 'Bitwa pod Cedynią miała miejsce w...?', '972', '0000-00-00 00:00:00'),
(4, 3, 'Jaki jest symbol chemiczny żelaza?', 'Fe', '0000-00-00 00:00:00'),
(5, 3, 'Jaki pierwiastek ma symbol „Na”?', 'Sód', '0000-00-00 00:00:00'),
(6, 3, 'Co oznacza symbol „K”?', 'Potas', '0000-00-00 00:00:00'),
(7, 4, 'Kto napisał „Latarnika”?', 'Henryk Sienkiewicz', '0000-00-00 00:00:00'),
(8, 4, 'Jakie zwierzęta opiekują się Romusiem i Remusiem?', 'Wilki', '0000-00-00 00:00:00'),
(9, 4, 'Co symbolizuje „Balladyna” Juliusza Słowackiego?', 'Żądzę władzy i winę', '0000-00-00 00:00:00'),
(10, 5, 'Stolica Francji?', 'Paryż', '0000-00-00 00:00:00'),
(11, 5, 'Stolica Niemiec?', 'Berlin', '0000-00-00 00:00:00'),
(12, 5, 'Stolica Czech?', 'Praga', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `podpowiedzi`
--

CREATE TABLE `podpowiedzi` (
  `podpowiedz_id` int(11) NOT NULL,
  `fiszka_id` int(11) NOT NULL,
  `tresc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `podpowiedzi`
--

INSERT INTO `podpowiedzi` (`podpowiedz_id`, `fiszka_id`, `tresc`) VALUES
(1, 1, 'Wydarzenie za panowania Mieszka I'),
(2, 1, 'Początek chrystianizacji kraju'),
(3, 2, 'Koronacja w 1025 roku'),
(4, 2, 'Syn Mieszka I'),
(5, 2, 'Znany z zjazdu gnieźnieńskiego'),
(6, 3, 'Mieszko I pokonał margrabiego Hodona'),
(7, 3, 'Krótko po chrzcie Polski'),
(8, 4, 'Symbol pochodzi od łacińskiej nazwy'),
(9, 5, 'Reaguje gwałtownie z wodą'),
(10, 5, 'Występuje w soli kuchennej'),
(11, 6, 'Pierwiastek grupy metali alkalicznych'),
(12, 4, 'Skrót od łacińskiej nazwy'),
(13, 7, 'Autor Trylogii'),
(14, 7, 'Laureat Nagrody Nobla'),
(15, 8, 'Zwierzęta mięsożerne'),
(16, 8, 'Występują w legendzie o założeniu Rzymu'),
(17, 9, 'Główna bohaterka popełnia zbrodnie'),
(18, 9, 'Motyw walki o władzę'),
(19, 10, 'Nad Sekwaną'),
(20, 10, 'Miasto z wieżą Eiffla'),
(21, 11, 'Miasto podzielone murem'),
(22, 11, 'Stolica z Bramą Brandenburską'),
(23, 12, 'Most Karola'),
(24, 12, 'Znajduje się nad Wełtawą');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `uzytkownik_id` int(11) NOT NULL,
  `nazwa` varchar(255) NOT NULL,
  `haslo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zestawy`
--

CREATE TABLE `zestawy` (
  `zestaw_id` int(11) NOT NULL,
  `uzytkownik_id` int(11) NOT NULL,
  `nazwa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zestawy`
--

INSERT INTO `zestawy` (`zestaw_id`, `uzytkownik_id`, `nazwa`) VALUES
(2, 0, 'Polska Piastów'),
(3, 0, 'Pierwiastki i symbole'),
(4, 0, 'Lektury podstawowe'),
(5, 0, 'Stolice Europy');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `fiszki`
--
ALTER TABLE `fiszki`
  ADD PRIMARY KEY (`fiszka_id`);

--
-- Indeksy dla tabeli `podpowiedzi`
--
ALTER TABLE `podpowiedzi`
  ADD PRIMARY KEY (`podpowiedz_id`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`uzytkownik_id`);

--
-- Indeksy dla tabeli `zestawy`
--
ALTER TABLE `zestawy`
  ADD PRIMARY KEY (`zestaw_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fiszki`
--
ALTER TABLE `fiszki`
  MODIFY `fiszka_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `podpowiedzi`
--
ALTER TABLE `podpowiedzi`
  MODIFY `podpowiedz_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `uzytkownik_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zestawy`
--
ALTER TABLE `zestawy`
  MODIFY `zestaw_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
