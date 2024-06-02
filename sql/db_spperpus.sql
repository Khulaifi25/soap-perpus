-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 03 Bulan Mei 2024 pada 14.16
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_spperpus`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `author_name` varchar(500) NOT NULL,
  `publish` varchar(500) NOT NULL,
  `isbn` varchar(50) NOT NULL,
  `category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `books`
--

INSERT INTO `books` (`id`, `title`, `author_name`, `publish`, `isbn`, `category`) VALUES
(1, 'C++ By Example', 'John', '500', 'PR-123-A1', 'Programming'),
(2, 'Java Book', 'Jane davis', '450', 'PR-456-A2', 'Programming'),
(3, 'Database Management Systems', 'Mark', '$75', 'DB-123-ASD', 'Database'),
(4, 'Harry Potter and the Order of the Phoenix', 'J.K. Rowling', '650', 'FC-123-456', 'Novel'),
(5, 'Data Structures', 'author 5', '450', 'FC-456-678', 'Programming'),
(6, 'Learning Web Development ', 'Michael', '300', 'ABC-123-456', 'Web Development'),
(7, 'Professional PHP & MYSQL', 'Programmer Blog', '$340', 'PR-123-456', 'Web Development'),
(8, 'Java Server Pages', 'technical authoer', ' $45.90', 'ABC-567-345', 'Programming'),
(9, 'Marketing', 'author3', '$423.87', '456-GHI-987', 'Business'),
(10, 'Economics', 'autor9', '$45', '234-DSG-456', 'Business'),
(11, 'Your Name.', 'Makoto Shinkai', 'Penerbit Haru', '978-623-7351-20-7', 'Novel'),
(12, 'dawd', 'wdad', '778', 'PR-123-A2', 'Novel'),
(13, 'Weathering with You', 'Makoto Shinkai', '99000', '978-324-7523-20-5', 'Novel'),
(14, 'Weathering with You', 'Makoto Shinkai', '99000', '978-324-7523-20-5', 'Novel'),
(15, 'Parasite', 'Yuji', '80000', 'HKWD1213', 'Novel'),
(16, 'Kamus Bhs Jepang', 'Hanae', 'YenPress', 'JP-HDW-266', 'Language');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
