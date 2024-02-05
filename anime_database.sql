-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 04, 2024 at 05:38 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `anime_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `photo_profile` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `nama_lengkap`, `photo_profile`) VALUES
(3, 'admin01', '$2y$10$e6Qoginq72IULDAUg.28ee.oHhE9qNct42363LxfcYOqlwuK0awDK', 'Andika', '659ca6facbd34.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `animes`
--

CREATE TABLE `animes` (
  `anime_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `kategori` text NOT NULL,
  `description` text,
  `rating` float NOT NULL,
  `release_date` date DEFAULT NULL,
  `status` varchar(50) NOT NULL,
  `jadwal_hari` varchar(50) NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `genre_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `animes`
--

INSERT INTO `animes` (`anime_id`, `title`, `kategori`, `description`, `rating`, `release_date`, `status`, `jadwal_hari`, `cover_image`, `genre_id`) VALUES
(22, 'Kuroko No Basuke', 'Series', 'Hokage 7 said:&quot;saya akan kembali ke kota saya..... Solo, Sebagai rakyat biasa&quot;  :)', 9.1, '2024-01-03', 'End', 'Jumat', '659920bfb764c.jpg', 12),
(23, 'One Punch Man', 'Series', 'akjvakvhahvavhjasujsujasuj', 8.8, '2024-01-01', 'onGoing', 'kamis', '659927e17a9ca.jpg', 2),
(24, 'One Punch Man S2', 'Series', 'Hokage 7 said:&quot;saya akan kembali ke kota saya..... Solo, Sebagai rakyat biasa&quot;  :)', 8.1, '2024-01-01', 'onGoing', 'Minggu', '659a337c82267.jpg', 2),
(25, 'Attack On Titan Final Movie 2', 'Movie', 'tentang rumblingnya bangsa eldia yang dipimpin eren karena tidak lulus di sekolah jurusan kesenian', 9.8, '2023-11-30', 'End', 'Jumat', '659ad09e6da8e.jpg', 2),
(26, 'Captain Tsubasa', 'Series', 'permainan indah dari captain tsubasa', 8.8, '2024-01-09', 'onGoing', 'Minggu', '659c31c67e9eb.webp', 12),
(27, 'Konosuba', 'Series', 'tentang rumblingnya bangsa eldia yang dipimpin eren karena tidak lulus di sekolah jurusan kesenian', 7.8, '2024-01-09', 'onGoing', 'Rabu', '659c9a7b3f3ac.jpg', 5),
(28, 'The Monster', 'Movie', 'Hokage 7 said:&quot;saya akan kembali ke kota saya..... Solo, Sebagai rakyat biasa&quot;  :)', 8.9, '2024-01-02', 'End', 'Selasa', '659ca4cea56c7.jpg', 13);

-- --------------------------------------------------------

--
-- Table structure for table `episodes`
--

CREATE TABLE `episodes` (
  `episode_id` int NOT NULL,
  `anime_id` int DEFAULT NULL,
  `episode_number` int DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `video_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `episodes`
--

INSERT INTO `episodes` (`episode_id`, `anime_id`, `episode_number`, `title`, `video_path`) VALUES
(23, 23, 10, 'botak biadab penyelamat bumi', '659a4e71df9df.mp4'),
(26, 24, 1, '2', '659a4fc139c85.mp4'),
(28, 24, 1, '2', '659a515114f8a.mp4'),
(32, 25, 1, 'rumbling', '659ad1c65598e.mkv'),
(34, 23, 2, '4', '659adcce6b52d.mp4'),
(35, 23, 2, 'kejanggalan', '659b96333022e.mp4'),
(36, 26, 1, 'pengenalan', '659c31f647c55.mkv'),
(37, 26, 2, 'pertemuan dengan wakabayashi', '659c3232ea03e.mkv'),
(38, 26, 3, 'kekalahan wakabayashi', '659c37568b18c.mkv'),
(39, 27, 1, 'Masuk ke dunia lain', '659c9a9f61492.mp4'),
(40, 28, 1, 'Horor dari solo', '659ca50add72a.mp4'),
(42, 22, 1, 'xxx', '65b64950e9f82.mp4'),
(43, 22, 2, 'xxy', '65b6498b23ada.mp4'),
(44, 22, 3, 'xxz', '65b649fb68580.mp4');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `genre_id` int NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`genre_id`, `name`) VALUES
(2, 'Action'),
(3, 'Romance'),
(4, 'Mistery'),
(5, 'Comedy'),
(6, 'Slice of Life'),
(12, 'Sport'),
(13, 'Horor'),
(15, 'Hentai');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `animes`
--
ALTER TABLE `animes`
  ADD PRIMARY KEY (`anime_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- Indexes for table `episodes`
--
ALTER TABLE `episodes`
  ADD PRIMARY KEY (`episode_id`),
  ADD KEY `anime_id` (`anime_id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`genre_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `animes`
--
ALTER TABLE `animes`
  MODIFY `anime_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `episodes`
--
ALTER TABLE `episodes`
  MODIFY `episode_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `genre_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `animes`
--
ALTER TABLE `animes`
  ADD CONSTRAINT `animes_ibfk_1` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`genre_id`);

--
-- Constraints for table `episodes`
--
ALTER TABLE `episodes`
  ADD CONSTRAINT `episodes_ibfk_1` FOREIGN KEY (`anime_id`) REFERENCES `animes` (`anime_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
