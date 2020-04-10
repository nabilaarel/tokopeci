-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2020 at 06:15 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laplanta`
--

-- --------------------------------------------------------

--
-- Table structure for table `berita`
--

CREATE TABLE `berita` (
  `id_berita` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `jenis_berita` varchar(20) NOT NULL,
  `judul_berita` varchar(255) NOT NULL,
  `slug_berita` varchar(255) NOT NULL,
  `keywords` text DEFAULT NULL,
  `status_berita` varchar(20) NOT NULL,
  `keterangan` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `tanggal_post` datetime NOT NULL,
  `tanggal_update` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gambar`
--

CREATE TABLE `gambar` (
  `id_gambar` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `judul_gambar` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `tanggal_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gambar`
--

INSERT INTO `gambar` (`id_gambar`, `id_produk`, `judul_gambar`, `gambar`, `tanggal_update`) VALUES
(1, 3, 'lili', 'tanaman-hias-Keladi-Red-Star1.jpg', '2020-03-11 16:01:39'),
(2, 3, 'red', 'tanaman-hias-Lili-Paris1.jpg', '2020-03-11 16:06:07'),
(3, 12, 'mawar', 'Tanaman-hias-bunga-mawar-bonica-roses1.jpg', '2020-03-13 11:46:27'),
(4, 12, 'lili', '20200312_230728_00002.png', '2020-03-13 12:25:45');

-- --------------------------------------------------------

--
-- Table structure for table `header_transaksi`
--

CREATE TABLE `header_transaksi` (
  `id_header_transaksi` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `kode_transaksi` varchar(255) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `jumlah_transaksi` int(11) NOT NULL,
  `status_bayar` varchar(20) NOT NULL,
  `jumlah_bayar` int(11) DEFAULT NULL,
  `rekening_pembayaran` varchar(255) DEFAULT NULL,
  `rekening_pelanggan` varchar(255) DEFAULT NULL,
  `bukti_bayar` varchar(255) DEFAULT NULL,
  `tanggal_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `slug_kategori` varchar(255) NOT NULL,
  `nama_kategori` varchar(255) NOT NULL,
  `urutan` int(11) DEFAULT NULL,
  `tanggal_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `slug_kategori`, `nama_kategori`, `urutan`, `tanggal_update`) VALUES
(1, 'tanaman-hias-jenis-daun', 'Tanaman Hias Jenis Daun', 1, '2020-03-11 03:02:54'),
(2, 'tanaman-hias-jenis-bunga', 'Tanaman Hias Jenis Bunga', 2, '2020-03-10 16:39:20');

-- --------------------------------------------------------

--
-- Table structure for table `konfigurasi`
--

CREATE TABLE `konfigurasi` (
  `id_konfigurasi` int(11) NOT NULL,
  `namaweb` varchar(255) NOT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `keywords` text DEFAULT NULL,
  `metatext` text DEFAULT NULL,
  `telepon` varchar(50) DEFAULT NULL,
  `alamat` varchar(300) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `rekening_pembayaran` varchar(255) DEFAULT NULL,
  `tanggal_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `konfigurasi`
--

INSERT INTO `konfigurasi` (`id_konfigurasi`, `namaweb`, `tagline`, `email`, `website`, `keywords`, `metatext`, `telepon`, `alamat`, `facebook`, `instagram`, `deskripsi`, `logo`, `icon`, `rekening_pembayaran`, `tanggal_update`) VALUES
(1, 'Inzalo', 'Percantik Sekitarmu', 'inzalo@gmail.com', 'www.inzalocom', 'jual', 'ok', '0895338434246', 'Bojonegoro', 'https://facebook.com/inzalo', 'https://instagram.com/inzalo', 'Inzalo merupakan toko tanaman hias online yang ada di Bojonegoro', '20200312_230728_0000.png', '20200312_230728_00001.png', '76590', '2020-03-13 06:37:19');

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `status_pelanggan` varchar(20) NOT NULL,
  `nama_pelanggan` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `telepon` varchar(50) DEFAULT NULL,
  `alamat` varchar(300) DEFAULT NULL,
  `tanggal_daftar` datetime NOT NULL,
  `tanggal_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `kode_produk` varchar(20) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `slug_produk` varchar(255) NOT NULL,
  `keterangan` text NOT NULL,
  `keywords` text DEFAULT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `berat` float DEFAULT NULL,
  `ukuran` varchar(255) DEFAULT NULL,
  `status_produk` varchar(20) NOT NULL,
  `tanggal_post` datetime NOT NULL,
  `tanggal_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `id_user`, `id_kategori`, `kode_produk`, `nama_produk`, `slug_produk`, `keterangan`, `keywords`, `harga`, `stok`, `gambar`, `berat`, `ukuran`, `status_produk`, `tanggal_post`, `tanggal_update`) VALUES
(3, 2, 2, 'DN01', 'Lili Paris', 'lili-paris-dn01', '<p>Tanaman hias daun yang satu ini dapat ditanam di pot duduk maupun pot gantung. Selain itu, tanaman ini sangat mudah beradaptasi di berbagai tempat, sehingga dapat diletakkan baik di dalam maupun luar ruangan.</p>\r\n\r\n<p>&nbsp;</p>\r\n', 'Lili Paris', 10000, 20, 'tanaman-hias-Lili-Paris.jpg', 150, 'Bibit', 'Publish', '2020-03-11 06:00:44', '2020-03-12 04:58:59'),
(6, 2, 2, 'BG01', 'Bonica Roses', 'bonica-roses-bg01', '<p>Mawar bonica adalah mawar semak berwarna merah muda tetapi lebih gelap, mempunyai diameter bunga rata-rata 3, 8 cm dengan jumlah kelopak bunga 26-40 lembar, sedikit wangi, toleransi pada keteduhan, mekar berulang kali di penghujung musim semi atau awal musim panas.</p>\r\n', 'Bibit Bonica Rose', 40000, 17, 'Tanaman-hias-bunga-mawar-bonica-roses.jpg', 40, 'Bibit', 'Publish', '2020-03-12 05:50:47', '2020-03-12 04:50:47'),
(7, 2, 2, 'BG02', 'Bougenville', 'bougenville-bg02', '<p>Bunga Bougenville atau bougenville, termasuk juga bunga yang cukup popular serta gampang perawatannya. Di musim panas meskipun, bunga ini bisa bertahan, bahkan juga kerapkali berbunga indah ditengah cuaca terik. Uniknya, ketika berbunga, tanaman ini malah merontokkan daun-daunnya hingga semua batang bakal penuh dengan kuntum bunga</p>\r\n', 'Bougenville', 42000, 14, 'Tanaman-hias-bunga-bougenville.jpg', 250, 'Bibit', 'Publish', '2020-03-12 05:58:41', '2020-03-12 04:58:41'),
(8, 2, 1, 'DN02', 'Keladi Red Star', 'keladi-red-star-dn02', '<p>Salah satu varietas dari tumbuhan genus&nbsp;<em>Caladium&nbsp;</em>adalah keladi&nbsp;<em>red star.&nbsp;</em>daun yang dimiliki tumbuhan ini berbentuk bintang dengan warna merah yang cerah. Untuk mendapatkan warna merah yang sehat, sebaiknya tanaman ini diletakkan di tempat dengan sinar matahari yang cukup. Selain itu, tangkai daunnya juga berwarna merah belang yang menambah kecantikan tanaman hias daun satu ini.</p>\r\n', 'Keladi', 98000, 9, 'tanaman-hias-Keladi-Red-Star8.jpg', 370, 'Bibit', 'Publish', '2020-03-12 06:01:05', '2020-03-12 05:01:05'),
(9, 2, 2, 'BG03', 'Matahari', 'matahari-bg03', '<p>Bunga matahari kerap dipakai sebagai bunga tangan maupun tanaman hias di pekarangan rumah yang disebut satu diantara bunga favorit beberapa orang. Hal itu lantaran bunga matahari mempunyai bentuk serta warna bunga yang indah serta mempunyai khasiat yang banyak.</p>\r\n', 'Bunga Matahari', 17000, 39, 'Tanaman-hias-bunga-matahari.jpg', 50, 'Bibit', 'Publish', '2020-03-12 06:03:35', '2020-03-12 05:03:35'),
(10, 2, 1, 'DN03', 'Puring', 'puring-dn03', '<p>Warna daun yang dimiliki tanaman hias daun ini sangatlah eksotis dengan perpaduan dari tiga warna, yaitu kuning, merah, dan hijau. Tanaman ini berbentuk perdu dengan bentuk daun bervariasi, seperti memanjang, oval, dan bergelombang. Diantara beberapa jenis tanaman puring yang cantik adalah puring anting raja, puring arjuna, dan puring asmara jingga.</p>\r\n\r\n<p>&nbsp;</p>\r\n', 'Puring', 23000, 24, 'Tanaman-Puring-Worten-1.jpg', 150, 'Bibit', 'Publish', '2020-03-12 06:06:08', '2020-03-12 05:06:08'),
(11, 2, 2, 'BG04', 'Adenium', 'adenium-bg04', '<p>Bunga adenium atau yang populer di Indonesia dengan bunga kamboja jepang nyatanya banyak tumbuh subur juga di Indonesia, namun pada intinya bunga ini bukanlah juga datang dari daerah Jepang tetapi datang dari benua afrika serta asia barat. Akar adenium memilki batang yang jadi membesar seperti umbi, batang ini bermanfaat untuk menaruh air sebagai cadangan pada ketika kekeringan melanda.</p>\r\n', 'Adenium', 16000, 17, 'Tanaman-hias-bunga-adenium.jpg', 150, 'Bibit', 'Publish', '2020-03-12 06:09:02', '2020-03-12 05:09:02'),
(12, 2, 1, 'DN04', 'Lemon Lime Draceana', 'lemon-lime-draceana-dn04', '<p>Sekilas tanaman hias daun ini nampak seperti pandan. Bentuk daunnya yang menyerupai pedang disertai kombinasi warna hijau, kuning terang, dan putih menjadikannya terlihat sangat manis.&nbsp;<em>Lemon Lime Draceanan&nbsp;</em>memiliki daun yang rimbun seperti semak dan menjuntai tegak lurus dengan batangnya.</p>\r\n', 'Lemon Lime Draceana', 42000, 11, 'tanaman-hias-Lemon-Lime-Draceana.jpg', 250, 'Bibit', 'Publish', '2020-03-12 06:14:28', '2020-03-12 05:14:28');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `kode_transaksi` varchar(255) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `tanggal_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `akses_level` varchar(20) NOT NULL,
  `tanggal_update` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `nama`, `email`, `username`, `password`, `akses_level`, `tanggal_update`) VALUES
(2, 'Hilda', 'hilda@gmail.com', 'hildasalsha', '6e09b0ffb4b4aad160813f6cdbcff04030ce7346', 'Admin', '2020-03-05 06:02:05'),
(4, 'hildasalsha', 'hilda1@gmail.com', 'hildasal', '6e09b0ffb4b4aad160813f6cdbcff04030ce7346', 'Admin', '2020-03-11 10:13:01'),
(5, 'hildasalshabila', 'hildasalshabila@gmail.com', 'hildasalshabila', '221ba2956f9f8aa9d4441ae114e664c266a96e18', 'User', '2020-03-13 11:40:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id_berita`);

--
-- Indexes for table `gambar`
--
ALTER TABLE `gambar`
  ADD PRIMARY KEY (`id_gambar`);

--
-- Indexes for table `header_transaksi`
--
ALTER TABLE `header_transaksi`
  ADD PRIMARY KEY (`id_header_transaksi`),
  ADD UNIQUE KEY `kode_transaksi` (`kode_transaksi`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `konfigurasi`
--
ALTER TABLE `konfigurasi`
  ADD PRIMARY KEY (`id_konfigurasi`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD UNIQUE KEY `kode_produk` (`kode_produk`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `berita`
--
ALTER TABLE `berita`
  MODIFY `id_berita` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gambar`
--
ALTER TABLE `gambar`
  MODIFY `id_gambar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `header_transaksi`
--
ALTER TABLE `header_transaksi`
  MODIFY `id_header_transaksi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `konfigurasi`
--
ALTER TABLE `konfigurasi`
  MODIFY `id_konfigurasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
