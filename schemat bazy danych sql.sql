-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 20 Sie 2024, 19:11
-- Wersja serwera: 10.3.39-MariaDB-0ubuntu0.20.04.2
-- Wersja PHP: 7.4.3-4ubuntu2.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `2025_pawel123`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `flashcards`
--

CREATE TABLE `flashcards` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `term` varchar(255) DEFAULT NULL,
  `definition` text NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `level_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `flashcards`
--

INSERT INTO `flashcards` (`id`, `title`, `term`, `definition`, `user_id`, `level_id`) VALUES
(38, 'Zwierzęta', 'Pies', 'Dog', 11, 1),
(39, 'Zwierzęta', 'Kot', 'Cat', 11, 1),
(40, 'Zwierzęta', 'Nosorożec', 'Rhino', 11, 4),
(41, 'Zwierzęta', 'Koń', 'Horse', 11, 1),
(42, 'Zwierzęta', 'Krowa', 'Cow', 11, 1),
(43, 'Zwierzęta', 'Zółw', 'Tortoise', 11, 5),
(44, 'Zwierzęta', 'Wilk', 'Wolf', 11, 1),
(45, 'Zwierzęta', 'Lew', 'Lion', 11, 1),
(46, 'Zwierzęta', 'Lis', 'Fox', 11, 1),
(47, 'Zwierzęta', 'Owca', 'Sheep', 11, 1),
(48, 'Zwierzęta', 'Niedzwiedź', 'Bear', 11, 1),
(49, 'Meble', 'Krzesło', 'Chair', 11, 1),
(50, 'Zwierzęta ', 'Kot', 'Cat', 11, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `levels`
--

CREATE TABLE `levels` (
  `id` int(11) NOT NULL,
  `name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `levels`
--

INSERT INTO `levels` (`id`, `name`) VALUES
(1, 'A1'),
(2, 'A2'),
(3, 'B1'),
(4, 'B2'),
(5, 'C1'),
(6, 'C2');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reported_flashcards`
--

CREATE TABLE `reported_flashcards` (
  `id` int(11) NOT NULL,
  `flashcard_id` int(11) NOT NULL,
  `reported_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `reported_flashcards`
--

INSERT INTO `reported_flashcards` (`id`, `flashcard_id`, `reported_at`) VALUES
(13, 39, '2024-08-20 16:44:56');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `user_type` varchar(5) NOT NULL DEFAULT 'user',
  `city` varchar(100) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `street_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `email`, `password`, `user_type`, `city`, `street`, `street_number`) VALUES
(11, 'User', 'User', 'user1@example.com', '24c9e15e52afc47c225b757e7bee1f9d', 'user', '', '', ''),
(12, 'Użytkownik', 'Użytkowik', 'user2@example.com', '7e58d63b60197ceb55a1c487989a3720', 'user', NULL, NULL, NULL),
(13, 'Admin', 'Admin', 'admin@example.com', '21232f297a57a5a743894a0e4a801fc3', 'admin', NULL, NULL, NULL),
(332, 'tymek', 'tymek', 'test@test.com', '098f6bcd4621d373cade4e832627b4f6', 'user', NULL, NULL, NULL),
(334, 'pawel', 'pawel', 'pawel@example.com', '207023ccb44feb4d7dadca005ce29a64', 'user', NULL, NULL, NULL),
(335, 'Paweł', 'Wozignój', 'UL0273240@edu.uni.lodz.pl', '1a7fcdd5a9fd433523268883cfded9d0', 'user', NULL, NULL, NULL);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `flashcards`
--
ALTER TABLE `flashcards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_flashcards_levels` (`level_id`);

--
-- Indeksy dla tabeli `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `reported_flashcards`
--
ALTER TABLE `reported_flashcards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `flashcard_id` (`flashcard_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `flashcards`
--
ALTER TABLE `flashcards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT dla tabeli `levels`
--
ALTER TABLE `levels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT dla tabeli `reported_flashcards`
--
ALTER TABLE `reported_flashcards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=336;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `flashcards`
--
ALTER TABLE `flashcards`
  ADD CONSTRAINT `fk_flashcards_levels` FOREIGN KEY (`level_id`) REFERENCES `levels` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `flashcards_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ograniczenia dla tabeli `reported_flashcards`
--
ALTER TABLE `reported_flashcards`
  ADD CONSTRAINT `reported_flashcards_ibfk_1` FOREIGN KEY (`flashcard_id`) REFERENCES `flashcards` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
