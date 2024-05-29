-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Creato il: Mag 29, 2024 alle 19:09
-- Versione del server: 8.0.18
-- Versione PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `talkie`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `messages`
--

CREATE TABLE `messages` (
  `ID` bigint(20) NOT NULL,
  `SenderID` bigint(11) NOT NULL,
  `ReciverID` bigint(11) NOT NULL,
  `Content` varchar(300) NOT NULL,
  `Timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `ID` bigint(20) NOT NULL,
  `Email` varchar(128) NOT NULL,
  `Password` varchar(96) NOT NULL,
  `Name` varchar(40) NOT NULL,
  `Surname` varchar(40) NOT NULL,
  `DateOfBirth` date NOT NULL,
  `LastUpdate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `SenderID` (`SenderID`),
  ADD KEY `ReciverID` (`ReciverID`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Email` (`Email`) USING BTREE;

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `messages`
--
ALTER TABLE `messages`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `users-ID_messages-ReciverID` FOREIGN KEY (`ReciverID`) REFERENCES `users` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `users-ID_messages-SenderID` FOREIGN KEY (`SenderID`) REFERENCES `users` (`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;
