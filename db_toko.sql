-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 17, 2026 at 03:35 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_toko`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `kategori_id` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`kategori_id`, `nama_kategori`, `created_at`) VALUES
(1, 'Kue Kering', '2026-04-28 06:06:55'),
(2, 'Kue Basah', '2026-04-28 06:06:55'),
(3, 'Cookies', '2026-04-28 06:06:55'),
(4, 'Cake & Brownies', '2026-04-28 06:06:55'),
(5, 'Snack Manis', '2026-04-28 06:06:55');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orders_id` int(11) NOT NULL,
  `invoice` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `pajak` int(11) NOT NULL,
  `metode_pembayaran` varchar(50) NOT NULL,
  `status` enum('pending','dibayar','selesai','batal') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orders_id`, `invoice`, `user_id`, `total`, `pajak`, `metode_pembayaran`, `status`, `created_at`) VALUES
(2, 'INV-7261', 1, 317000, 31700, 'Cash', 'selesai', '2026-05-15 13:46:52'),
(3, 'INV-6885', 2, 240000, 24000, 'Transfer', 'pending', '2026-05-15 14:52:49'),
(4, 'INV-9815', 3, 490000, 49000, 'QRIS', 'pending', '2026-05-16 07:43:14'),
(5, 'INV-9698', 3, 314000, 31400, 'QRIS', 'pending', '2026-05-16 07:44:06');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_items_id` int(11) NOT NULL,
  `orders_id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_items_id`, `orders_id`, `produk_id`, `qty`, `harga`, `subtotal`) VALUES
(1, 2, 1, 1, 85000, 85000),
(2, 2, 3, 2, 80000, 160000),
(3, 2, 9, 1, 72000, 72000),
(4, 3, 2, 1, 90000, 90000),
(5, 3, 3, 1, 80000, 80000),
(6, 3, 5, 1, 70000, 70000),
(7, 4, 1, 2, 85000, 170000),
(8, 4, 2, 1, 90000, 90000),
(9, 4, 3, 2, 80000, 160000),
(10, 4, 5, 1, 70000, 70000),
(11, 5, 7, 1, 95000, 95000),
(12, 5, 8, 1, 75000, 75000),
(13, 5, 9, 2, 72000, 144000);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `pembayaran_id` int(11) NOT NULL,
  `orders_id` int(11) NOT NULL,
  `metode` varchar(50) NOT NULL,
  `bayar` int(11) NOT NULL,
  `kembalian` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `produk_id` int(11) NOT NULL,
  `nama_produk` varchar(150) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`produk_id`, `nama_produk`, `kategori_id`, `harga`, `stok`, `deskripsi`, `gambar`, `created_at`) VALUES
(1, 'Nastar Klasik', 1, 85000, 47, 'Kue nastar lembut dengan isian selai nanas premium', 'nastar.jpeg', '2026-05-16 07:43:14'),
(2, 'Kastengel Keju', 1, 60000, 38, 'Kue kastengel gurih dengan keju edam dan cheddar', 'kastangel.jpeg', '2026-05-16 12:24:15'),
(3, 'Putri Salju', 1, 80000, 40, 'Kue lembut dengan taburan gula halus seperti salju', 'putri_salju.jpeg', '2026-05-16 07:43:14'),
(5, 'Chocolate Butter Cookies', 2, 70000, 53, 'Cookies butter lembut dengan rasa coklat yang rich dan aroma khas mentega', 'chocolate_butter.jpeg', '2026-05-16 07:43:14'),
(7, 'Brownies Panggang', 2, 95000, 29, 'Brownies lembut dengan rasa coklat pekat', 'brownis.jpeg', '2026-05-16 07:44:06'),
(8, 'Palm Cheese Cookies', 2, 75000, 49, 'Cookies lembut dengan perpaduan rasa manis gula palm dan gurih keju', 'palm_cheese.jpeg', '2026-05-16 07:44:06'),
(9, 'Strawberry Thumb', 2, 72000, 52, 'Cookies dengan isian selai stroberi di tengah, rasa manis dan sedikit asam segar', 'strawberry_thumb.jpeg', '2026-05-16 07:44:06');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(225) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','kasir','pelanggan','') NOT NULL,
  `status` enum('aktif','nonaktif','','') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `nama`, `username`, `password`, `email`, `role`, `status`, `created_at`) VALUES
(1, 'nana', 'nana', '6ebba2abeb5cb63a539ec3d67a72bbba', 'nana@gmail.com', 'admin', 'aktif', '2026-04-20 06:53:45'),
(2, 'niny', 'niny', 'dba39aa21365a8972380d578a6522ab3', 'niny@gmail.com', 'pelanggan', 'aktif', '2026-04-28 02:23:38'),
(3, 'agan', 'agan', 'abd9b46e55b1080d4c6c5d8e28851aab', 'agan@gmail.com', 'kasir', 'aktif', '2026-04-28 02:24:34'),
(7, 'ayuna', 'ayuna', '41ac64af15eb8fb9ac9b33334b25a9a0', 'ayuna@gmail.com', 'admin', 'aktif', '2026-05-16 10:16:54');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orders_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_items_id`),
  ADD KEY `orders_id` (`orders_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`pembayaran_id`),
  ADD KEY `orders_id` (`orders_id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`produk_id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orders_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_items_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `pembayaran_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `produk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`orders_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`produk_id`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`orders_id`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`kategori_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
