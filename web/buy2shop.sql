-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 08, 2024 at 09:02 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `buy2shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `anuncios`
--

CREATE TABLE `anuncios` (
  `id` int(11) UNSIGNED NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `nome` varchar(255) NOT NULL,
  `telemovel` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anuncios`
--

INSERT INTO `anuncios` (`id`, `categoria`, `titulo`, `descricao`, `nome`, `telemovel`, `email`, `cidade`, `valor`, `user_id`, `created_at`) VALUES
(79, 'Telemoveis', 'aa', 'aa', 'aa', '911111111', 'aa', 'aa', 1500.00, 2, '2023-05-16 14:17:46'),
(80, 'Telemoveis', 'bb', 'bb', 'bb', '922222222', 'bb', 'bb', 2000.00, 2, '2023-05-16 14:18:19'),
(81, 'Livros, Desportos & Hobbies', 'Livro', 'Livro', 'aa', '911111111', 'aa', 'aa', 10.00, 2, '2023-05-19 19:23:26'),
(82, 'Carros', 'Carro', 'Carro', 'aa', '911111111', 'aa', 'aa', 10000.00, 2, '2023-05-19 19:30:17'),
(83, 'Electronicos e acessorios', 'Eletronico e acessório', 'electronico e acessório', 'aa', '911111111', 'aa', 'aa', 30.00, 2, '2023-05-19 19:34:55'),
(84, 'Moda', 'Moda', 'Moda', 'aa', '911111111', 'aa', 'aa', 50.00, 2, '2023-05-19 19:38:16'),
(85, 'Trabalhos', 'Trabalho', 'Trabalho', 'aa', '911111111', 'aa', 'aa', 1.00, 2, '2023-05-19 19:43:57'),
(86, 'Criancas', 'Crianças', 'Crianças', 'aa', '911111111', 'aa', 'aa', 100.00, 2, '2023-05-19 19:48:22'),
(87, 'Animais', 'Animais', 'Animais', 'aa', '911111111', 'aa', 'aa', 200.00, 2, '2023-05-19 19:52:49'),
(88, 'Casas', 'Casa', 'Casa', 'aa', '911111111', 'aa', 'aa', 100000.00, 2, '2023-05-19 19:54:49'),
(89, 'Servicos', 'Serviço', 'Serviço', 'aa', '911111111', 'aa', 'aa', 1.00, 2, '2023-05-19 19:59:46');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `itemId` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `itemId`, `userid`) VALUES
(9, 80, 3),
(10, 79, 2);

-- --------------------------------------------------------

--
-- Table structure for table `fotos`
--

CREATE TABLE `fotos` (
  `id` int(11) UNSIGNED NOT NULL,
  `anuncio_id` int(11) UNSIGNED NOT NULL,
  `photo_capa` varchar(255) NOT NULL,
  `photo_1` varchar(255) NOT NULL,
  `photo_2` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fotos`
--

INSERT INTO `fotos` (`id`, `anuncio_id`, `photo_capa`, `photo_1`, `photo_2`) VALUES
(31, 79, 'uploads/resized_iphone-14-pro-colors.png', 'uploads/resized_Unknown.jpeg', 'uploads/resized_frente.jpeg'),
(32, 80, 'uploads/resized_iphone_frente.png', 'uploads/resized_frente.jpeg', 'uploads/resized_Unknown.jpeg'),
(33, 81, 'uploads/resized_iphone_frente.png', 'uploads/resized_frente.jpeg', 'uploads/resized_Unknown.jpeg'),
(34, 82, 'uploads/resized_iphone-14-pro-colors.png', 'uploads/resized_frente.jpeg', 'uploads/resized_Unknown.jpeg'),
(35, 83, 'uploads/resized_iphone-14-pro-colors.png', 'uploads/resized_frente.jpeg', 'uploads/resized_Unknown.jpeg'),
(36, 84, 'uploads/resized_Unknown.jpeg', 'uploads/resized_frente.jpeg', 'uploads/resized_iphone_frente.png'),
(37, 85, 'uploads/resized_iphone-14-pro-colors.png', 'uploads/resized_frente.jpeg', 'uploads/resized_Unknown.jpeg'),
(38, 86, 'uploads/resized_iphone_frente.png', 'uploads/resized_frente.jpeg', 'uploads/resized_Unknown.jpeg'),
(39, 87, 'uploads/resized_Unknown.jpeg', 'uploads/resized_frente.jpeg', 'uploads/resized_iphone-14-pro-colors.png'),
(40, 88, 'uploads/resized_Unknown.jpeg', 'uploads/resized_frente.jpeg', 'uploads/resized_iphone_frente.png'),
(41, 89, 'uploads/resized_iphone-14-pro-colors.png', 'uploads/resized_frente.jpeg', 'uploads/resized_iphone_frente.png');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `name`, `email`, `message`, `created_at`) VALUES
(1, 'bb', 'bb', 'bb', '2023-05-13 22:22:00'),
(2, 'cc', 'cc', 'cc', '2023-05-13 22:23:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `saldo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `pass`, `saldo`) VALUES
(2, 'aa', 'aa', NULL),
(3, 'dd', '', NULL),
(6, 'hh', 'hh', NULL),
(7, 'kk', 'kk', 110);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anuncios`
--
ALTER TABLE `anuncios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_anuncios_users` (`user_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fotos`
--
ALTER TABLE `fotos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anuncio_id` (`anuncio_id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anuncios`
--
ALTER TABLE `anuncios`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `fotos`
--
ALTER TABLE `fotos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anuncios`
--
ALTER TABLE `anuncios`
  ADD CONSTRAINT `fk_anuncios_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `fotos`
--
ALTER TABLE `fotos`
  ADD CONSTRAINT `fotos_ibfk_1` FOREIGN KEY (`anuncio_id`) REFERENCES `anuncios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
