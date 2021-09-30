-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Sep 2021 pada 05.12
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `login-limits`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('Admin','Member','Staff') NOT NULL,
  `verif_code` text NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `log` text NOT NULL DEFAULT 'belum pernah login'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `level`, `verif_code`, `is_verified`, `log`) VALUES
(4, 'budi', 'bravecoderofficial@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'Admin', '', 0, 'belum pernah login'),
(5, 'haidar', 'haidar123@gmail.com', '09b8dae41c023a7b3419a8152c981a57', 'Admin', '', 1, '2021-09-30 04:58:27'),
(6, 'haikall', 'haikal123@gmail.com', 'e6622d8b1b53d157a432861ad739a9da', 'Staff', '', 0, 'belum pernah login'),
(7, 'otniel', 'otniel123@gmail.com', '0a08510bcf352284d27bd103d537f887', 'Member', '', 0, 'belum pernah login'),
(18, 'aziz', 'pranaja200102@gmail.com', 'fc74e9f2c04ed699b2e504c9cca9406d', 'Member', '7569c82b9deb72db0b19181e1fe903b1', 0, 'belum pernah login'),
(20, 'haidar guhardy', 'haidar5115@gmail.com', '09b8dae41c023a7b3419a8152c981a57', 'Member', 'c0bf68bc9202aa2282d22cac77c28744', 1, '2021-09-30 05:05:08');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
