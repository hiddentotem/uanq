-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2020 at 03:37 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uanq`
--

-- --------------------------------------------------------

--
-- Table structure for table `bulan`
--

CREATE TABLE `bulan` (
  `idBulan` int(11) NOT NULL,
  `namaBulan` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bulan`
--

INSERT INTO `bulan` (`idBulan`, `namaBulan`) VALUES
(1, 'Jan'),
(2, 'Feb'),
(3, 'Mar'),
(4, 'Apr'),
(5, 'May'),
(6, 'Jun'),
(7, 'Jul'),
(8, 'Aug'),
(9, 'Sep'),
(10, 'Oct'),
(11, 'Nov'),
(12, 'Dec');

-- --------------------------------------------------------

--
-- Table structure for table `cabang`
--

CREATE TABLE `cabang` (
  `idCabang` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `namaCabang` varchar(50) NOT NULL,
  `alamatCabang` text NOT NULL,
  `telpCabang` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cabang`
--

INSERT INTO `cabang` (`idCabang`, `email`, `namaCabang`, `alamatCabang`, `telpCabang`) VALUES
(1, 'ranggadpermadi@gmail.com', 'Pusat', 'Tangerang', '081383012382');

-- --------------------------------------------------------

--
-- Table structure for table `earnings`
--

CREATE TABLE `earnings` (
  `idEarning` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `transaksi` varchar(40) NOT NULL,
  `income` int(11) NOT NULL,
  `outcome` int(11) NOT NULL,
  `dateCreated` date NOT NULL,
  `dateModified` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `earnings`
--

INSERT INTO `earnings` (`idEarning`, `email`, `transaksi`, `income`, `outcome`, `dateCreated`, `dateModified`) VALUES
(1, 'ranggadpermadi@gmail.com', 'Modal Awal', 607000, 0, '2020-01-19', '2020-01-19'),
(2, 'ranggadpermadi@gmail.com', 'Fotocopy', 0, 2000, '2020-01-19', '2020-01-19'),
(5, 'bonuslupis@gmail.com', 'Jual Sepeda Balap', 60000000, 0, '2020-01-20', '2020-01-20'),
(6, 'ranggadpermadi@gmail.com', 'Beli Indomie 4', 0, 7500, '2020-01-20', '2020-01-20'),
(7, 'ranggadpermadi@gmail.com', 'Fotocopy', 0, 1000, '2020-01-20', '2020-01-20'),
(8, 'ranggadpermadi@gmail.com', 'Beli Saos', 0, 6200, '2020-01-20', '2020-01-20'),
(9, 'ranggadpermadi@gmail.com', 'Subisidi nasi padang', 0, 2000, '2020-01-20', '2020-01-20'),
(10, 'ranggadpermadi@gmail.com', 'Nemu receh', 1000, 300, '2020-01-20', '2020-01-20'),
(11, 'ranggadpermadi@gmail.com', 'Bensin', 0, 50000, '2020-01-21', '2020-01-21'),
(12, 'ranggadpermadi@gmail.com', 'Isi angin', 0, 6000, '2020-01-21', '2020-01-21'),
(13, 'ranggadpermadi@gmail.com', 'Sarapan', 0, 15000, '2020-01-21', '2020-01-21'),
(14, 'ranggadpermadi@gmail.com', 'Beli sarapan', 0, 15000, '2020-01-22', '2020-01-22'),
(15, 'ranggadpermadi@gmail.com', 'Cuci steam', 0, 20000, '2020-01-22', '2020-01-22'),
(16, 'ranggadpermadi@gmail.com', 'Beli telor', 0, 12000, '2020-01-22', '2020-01-22'),
(17, 'ranggadpermadi@gmail.com', 'Beli mie 4', 0, 10000, '2020-01-23', '2020-01-23'),
(18, 'ranggadpermadi@gmail.com', 'Subsidi', 0, 4000, '2020-01-23', '2020-01-23'),
(19, 'ranggadpermadi@gmail.com', 'Isi angin', 0, 6000, '2020-01-23', '2020-01-23'),
(20, 'ranggadpermadi@gmail.com', 'Bensin', 0, 50000, '2020-01-24', '2020-01-24'),
(21, 'ranggadpermadi@gmail.com', 'Beli nasi kuning', 0, 10000, '2020-01-24', '2020-01-24'),
(22, 'ranggadpermadi@gmail.com', 'Beli lauk siang', 0, 5000, '2020-01-24', '2020-01-24'),
(24, 'ranggadpermadi@gmail.com', 'Beli ayam geprek', 0, 12000, '2020-01-25', '2020-01-25'),
(25, 'ranggadpermadi@gmail.com', 'Beli ayam sayur', 0, 10000, '2020-01-25', '2020-01-25'),
(26, 'ranggadpermadi@gmail.com', 'Beli mie 4', 0, 10000, '2020-01-25', '2020-01-25'),
(27, 'ranggadpermadi@gmail.com', 'Beli telor', 0, 13000, '2020-01-25', '2020-01-25'),
(28, 'ranggadpermadi@gmail.com', 'Isi angin', 0, 7000, '2020-01-27', '2020-01-27'),
(29, 'ranggadpermadi@gmail.com', 'Beli obat', 0, 20000, '2020-01-27', '2020-01-27'),
(30, 'ranggadpermadi@gmail.com', 'Subsidi Rokok', 0, 100000, '2020-01-28', '2020-01-28'),
(31, 'ranggadpermadi@gmail.com', 'Modal', 600000, 0, '2020-01-28', '2020-01-28'),
(32, 'ranggadpermadi@gmail.com', 'Beli beras', 0, 110000, '2020-01-28', '2020-01-28'),
(33, 'ranggadpermadi@gmail.com', 'Ganti oli', 0, 100000, '2020-01-28', '2020-01-28'),
(34, 'ranggadpermadi@gmail.com', 'Beli nasi kuning', 0, 10000, '2020-01-28', '2020-01-28'),
(35, 'ranggadpermadi@gmail.com', 'Cuci steam', 0, 20000, '2020-01-29', '2020-01-29'),
(36, 'ranggadpermadi@gmail.com', 'Beli nasi padang', 0, 13000, '2020-01-29', '2020-01-29'),
(37, 'ranggadpermadi@gmail.com', 'Subsidi makan enjo', 0, 6000, '2020-01-29', '2020-01-29'),
(38, 'ranggadpermadi@gmail.com', 'Sarapan', 0, 18000, '2020-01-30', '2020-01-30'),
(39, 'ranggadpermadi@gmail.com', 'Bensin', 0, 50000, '2020-01-30', '2020-01-30'),
(40, 'ranggadpermadi@gmail.com', 'Beli baut', 0, 4000, '2020-01-30', '2020-01-30'),
(41, 'ranggadpermadi@gmail.com', 'Beli mie 4', 0, 11000, '2020-01-30', '2020-01-30'),
(42, 'ranggadpermadi@gmail.com', 'Nemu receh', 1000, 0, '2020-01-30', '2020-01-30'),
(43, 'ranggadpermadi@gmail.com', 'Modal', 150000, 0, '2020-02-01', '2020-02-01'),
(44, 'ranggadpermadi@gmail.com', 'Bensin', 0, 20000, '2020-02-01', '2020-02-01'),
(45, 'ranggadpermadi@gmail.com', 'Beli pecel ayam', 0, 16000, '2020-02-01', '2020-02-01'),
(46, 'ranggadpermadi@gmail.com', 'Beli nasi kuning', 0, 10000, '2020-02-01', '2020-02-01'),
(47, 'ranggadpermadi@gmail.com', 'Outcome', 0, 5000, '2020-02-01', '2020-02-01'),
(48, 'ranggadpermadi@gmail.com', 'Gojek statsiun', 0, 40000, '2020-02-01', '2020-02-01'),
(49, 'ranggadpermadi@gmail.com', 'Kereta Bekasi', 0, 16000, '2020-02-01', '2020-02-01'),
(50, 'ranggadpermadi@gmail.com', 'Beli ultramilk', 0, 9000, '2020-02-01', '2020-02-01'),
(51, 'ranggadpermadi@gmail.com', 'Naik angkot babelan', 0, 7000, '2020-02-01', '2020-02-01'),
(52, 'ranggadpermadi@gmail.com', 'Naik ojek babelan', 0, 10000, '2020-02-01', '2020-02-01'),
(53, 'ranggadpermadi@gmail.com', 'Outcome', 0, 5000, '2020-02-01', '2020-02-01'),
(54, 'ranggadpermadi@gmail.com', 'Beli lauk siang', 0, 9000, '2020-02-03', '2020-02-03'),
(55, 'ranggadpermadi@gmail.com', 'Beli sambel', 0, 14000, '2020-02-03', '2020-02-03'),
(56, 'ranggadpermadi@gmail.com', 'Beli getuk', 0, 5000, '2020-02-03', '2020-02-03'),
(57, 'ranggadpermadi@gmail.com', 'Beli lauk siang', 0, 10000, '2020-02-04', '2020-02-04'),
(58, 'ranggadpermadi@gmail.com', 'Beli roti', 0, 4000, '2020-02-04', '2020-02-04'),
(59, 'ranggadpermadi@gmail.com', 'Parkir', 0, 2000, '2020-02-04', '2020-02-04'),
(60, 'ranggadpermadi@gmail.com', 'Bensin', 0, 20000, '2020-02-04', '2020-02-04'),
(61, 'ranggadpermadi@gmail.com', 'Subsidi', 0, 100000, '2020-02-04', '2020-02-04'),
(62, 'ranggadpermadi@gmail.com', 'Nol', 0, 0, '2020-02-05', '2020-02-05'),
(63, 'ranggadpermadi@gmail.com', 'Beli gorengan', 0, 6000, '2020-02-08', '2020-02-08'),
(64, 'ranggadpermadi@gmail.com', 'Bensin', 0, 20000, '2020-02-08', '2020-02-08'),
(65, 'ranggadpermadi@gmail.com', 'Beli nasi kuning', 0, 8000, '2020-02-08', '2020-02-08'),
(66, 'ranggadpermadi@gmail.com', 'Beli gorengan', 0, 5000, '2020-02-08', '2020-02-08'),
(67, 'ranggadpermadi@gmail.com', 'Subsidi Rokok', 0, 50000, '2020-02-08', '2020-02-08'),
(68, 'ranggadpermadi@gmail.com', 'Parkir', 0, 2000, '2020-02-08', '2020-02-08'),
(69, 'ranggadpermadi@gmail.com', 'Beli nasi padang', 0, 26000, '2020-02-08', '2020-02-08'),
(70, 'ranggadpermadi@gmail.com', 'Beli pulsa', 0, 53000, '2020-02-08', '2020-02-08'),
(71, 'ranggadpermadi@gmail.com', 'Beli telor 1kg', 0, 23000, '2020-02-08', '2020-02-08'),
(72, 'ranggadpermadi@gmail.com', 'Beli Indomie 4', 0, 10200, '2020-02-08', '2020-02-08'),
(73, 'ranggadpermadi@gmail.com', 'Kembalian ilang', 0, 800, '2020-02-08', '2020-02-08'),
(74, 'ranggadpermadi@gmail.com', 'Beli nasi padang', 0, 13000, '2020-02-10', '2020-02-10'),
(75, 'ranggadpermadi@gmail.com', 'Subsidi', 0, 10000, '2020-02-10', '2020-02-10'),
(76, 'ranggadpermadi@gmail.com', 'Beli batagor', 0, 6000, '2020-02-10', '2020-02-10'),
(77, 'ranggadpermadi@gmail.com', 'Beli lauk siang', 0, 10000, '2020-02-10', '2020-02-10'),
(78, 'ranggadpermadi@gmail.com', 'Bensin', 0, 20000, '2020-02-10', '2020-02-10'),
(79, 'ranggadpermadi@gmail.com', 'Beli lauk siang', 0, 7000, '2020-02-11', '2020-02-11'),
(80, 'ranggadpermadi@gmail.com', 'Bensin', 0, 20000, '2020-02-12', '2020-02-12'),
(81, 'ranggadpermadi@gmail.com', 'Beli ayam geprek', 0, 12000, '2020-02-12', '2020-02-12'),
(82, 'ranggadpermadi@gmail.com', 'Modal Mama', 250000, 0, '2020-02-12', '2020-02-12'),
(83, 'ranggadpermadi@gmail.com', 'Beli nasi kuning', 0, 8000, '2020-02-13', '2020-02-13'),
(84, 'ranggadpermadi@gmail.com', 'Beli mie 2', 0, 6000, '2020-02-13', '2020-02-13'),
(85, 'ranggadpermadi@gmail.com', 'Beli gorengan', 0, 4000, '2020-02-15', '2020-02-15'),
(86, 'ranggadpermadi@gmail.com', 'Bensin', 0, 20000, '2020-02-15', '2020-02-15'),
(87, 'ranggadpermadi@gmail.com', 'Beli makan njo', 0, 63000, '2020-02-15', '2020-02-15'),
(88, 'ranggadpermadi@gmail.com', 'Beli nasi padang', 0, 13000, '2020-02-15', '2020-02-15'),
(89, 'ranggadpermadi@gmail.com', 'Subsidi papa', 0, 100000, '2020-02-15', '2020-02-15'),
(90, 'ranggadpermadi@gmail.com', 'Beli indomie', 0, 4000, '2020-02-15', '2020-02-15'),
(91, 'ranggadpermadi@gmail.com', 'Beli telur 1kg + kecap', 0, 28000, '2020-02-15', '2020-02-15'),
(92, 'ranggadpermadi@gmail.com', 'Beli mie 4', 0, 10000, '2020-02-15', '2020-02-15'),
(93, 'ranggadpermadi@gmail.com', 'Beli getuk', 0, 7000, '2020-02-17', '2020-02-17'),
(94, 'ranggadpermadi@gmail.com', 'Beli roti', 0, 14000, '2020-02-17', '2020-02-17'),
(95, 'ranggadpermadi@gmail.com', 'Subsidi', 0, 30000, '2020-02-17', '2020-02-17'),
(96, 'ranggadpermadi@gmail.com', 'Parkir', 0, 3000, '2020-02-17', '2020-02-17'),
(97, 'ranggadpermadi@gmail.com', 'Modal Mama', 300000, 0, '2020-02-17', '2020-02-17'),
(98, 'ranggadpermadi@gmail.com', 'Beli tahu crispy', 0, 5000, '2020-02-19', '2020-02-19'),
(99, 'ranggadpermadi@gmail.com', 'Parkir', 0, 3000, '2020-02-19', '2020-02-19'),
(100, 'ranggadpermadi@gmail.com', 'Parkir', 0, 3000, '2020-02-19', '2020-02-19'),
(101, 'ranggadpermadi@gmail.com', 'Beli sarapan', 0, 10000, '2020-02-19', '2020-02-19'),
(102, 'ranggadpermadi@gmail.com', 'Beli ayam geprek', 0, 12000, '2020-02-19', '2020-02-19'),
(103, 'ranggadpermadi@gmail.com', 'Modal Bude', 250000, 0, '2020-02-19', '2020-02-19'),
(104, 'ranggadpermadi@gmail.com', 'Bensin', 0, 20000, '2020-02-20', '2020-02-20'),
(105, 'ranggadpermadi@gmail.com', 'Parkir kereta', 0, 2000, '2020-02-20', '2020-02-20'),
(106, 'ranggadpermadi@gmail.com', 'Parkir', 0, 3000, '2020-02-20', '2020-02-20'),
(107, 'ranggadpermadi@gmail.com', 'Beli lauk siang', 0, 7000, '2020-02-20', '2020-02-20'),
(108, 'ranggadpermadi@gmail.com', 'Beli ayam geprek', 0, 12000, '2020-02-20', '2020-02-20'),
(109, 'ranggadpermadi@gmail.com', 'Beli telor 1kg', 0, 32000, '2020-02-20', '2020-02-20'),
(110, 'ranggadpermadi@gmail.com', 'Beli sampo', 0, 3000, '2020-02-20', '2020-02-20'),
(111, 'ranggadpermadi@gmail.com', 'Subsidi papa', 0, 100000, '2020-02-20', '2020-02-20'),
(112, 'ranggadpermadi@gmail.com', 'Dan lain lain', 0, 197000, '2020-02-22', '2020-02-22'),
(113, 'ranggadpermadi@gmail.com', 'Modal Mama', 200000, 0, '2020-02-23', '2020-02-23'),
(114, 'ranggadpermadi@gmail.com', 'Beli ayam geprek', 0, 24000, '2020-02-23', '2020-02-23'),
(115, 'ranggadpermadi@gmail.com', 'Beli gula', 0, 5000, '2020-02-23', '2020-02-23');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `idOrder` int(11) NOT NULL,
  `idProduk` int(11) NOT NULL,
  `idCabang` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `namaBarang` varchar(50) NOT NULL,
  `stokBarang` int(11) NOT NULL,
  `terjualBarang` int(11) NOT NULL,
  `hargaJual` int(11) NOT NULL,
  `hargaBeli` int(11) NOT NULL,
  `qtyOrder` int(11) NOT NULL,
  `totalHarga` int(11) NOT NULL,
  `profitOrder` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `dateCreated` date NOT NULL,
  `dateModified` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`idOrder`, `idProduk`, `idCabang`, `email`, `namaBarang`, `stokBarang`, `terjualBarang`, `hargaJual`, `hargaBeli`, `qtyOrder`, `totalHarga`, `profitOrder`, `status`, `dateCreated`, `dateModified`) VALUES
(1, 13, 1, 'ranggadpermadi@gmail.com', 'Indomie Kuah Soto Padang', 37, 3, 3000, 1500, 3, 9000, 4500, 1, '2020-02-02', '2020-02-02'),
(2, 12, 1, 'ranggadpermadi@gmail.com', 'Indomie Goreng Super Pedas', 37, 3, 3000, 1500, 3, 9000, 4500, 1, '2020-02-02', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `idProduk` int(11) NOT NULL,
  `idCabang` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `namaProduk` varchar(50) NOT NULL,
  `stokProduk` int(11) NOT NULL,
  `terjualProduk` int(11) NOT NULL,
  `hargaBeli` int(11) NOT NULL,
  `hargaJual` int(11) NOT NULL,
  `profitProduk` int(11) NOT NULL,
  `dateCreated` date NOT NULL,
  `dateModified` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`idProduk`, `idCabang`, `email`, `namaProduk`, `stokProduk`, `terjualProduk`, `hargaBeli`, `hargaJual`, `profitProduk`, `dateCreated`, `dateModified`) VALUES
(1, 1, 'ranggadpermadi@gmail.com', 'Indomie Kuah Soto', 40, 0, 1500, 3000, 1500, '2020-01-24', '2020-01-24'),
(2, 1, 'ranggadpermadi@gmail.com', 'Indomie Goreng Classic', 40, 0, 1500, 3000, 1500, '2020-01-24', '2020-01-24'),
(3, 1, 'ranggadpermadi@gmail.com', 'Rokok Gudang Garam Filter (1 bngks)', 20, 0, 16000, 20000, 4000, '2020-01-25', '2020-01-25'),
(4, 1, 'ranggadpermadi@gmail.com', 'Telur 1kg', 10, 0, 15000, 24000, 9000, '2020-01-25', '2020-01-25'),
(5, 1, 'ranggadpermadi@gmail.com', 'Aqua Botol 600ml', 20, 0, 1500, 3000, 1500, '2020-01-25', '2020-01-25'),
(6, 1, 'ranggadpermadi@gmail.com', 'Beng beng', 30, 0, 800, 2000, 1200, '2020-01-25', '2020-01-25'),
(7, 1, 'ranggadpermadi@gmail.com', 'Indomie Kuah Kari Ayam', 40, 0, 1500, 3000, 1500, '2020-01-25', '2020-01-25'),
(8, 1, 'ranggadpermadi@gmail.com', 'Indomie Kuah Empal Gentong', 40, 0, 1500, 3000, 1500, '2020-01-25', '2020-01-25'),
(9, 1, 'ranggadpermadi@gmail.com', 'Indomie Goreng Rendang', 40, 0, 1500, 3000, 1500, '2020-01-25', '2020-01-25'),
(10, 1, 'ranggadpermadi@gmail.com', 'Indomie Kuah Mi Celor', 40, 0, 1500, 3000, 1500, '2020-01-25', '2020-01-25'),
(11, 1, 'ranggadpermadi@gmail.com', 'Indomie Kuah Cakalang', 40, 0, 1500, 3000, 1500, '2020-01-25', '2020-01-25'),
(12, 1, 'ranggadpermadi@gmail.com', 'Indomie Goreng Super Pedas', 37, 3, 1500, 3000, 1500, '2020-01-25', '2020-01-25'),
(13, 1, 'ranggadpermadi@gmail.com', 'Indomie Kuah Soto Padang', 37, 3, 1500, 3000, 1500, '2020-01-25', '2020-01-25');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `namaUser` varchar(128) NOT NULL,
  `emailUser` varchar(128) NOT NULL,
  `imageUser` varchar(128) NOT NULL,
  `passwordUser` varchar(255) NOT NULL,
  `idRole` int(11) NOT NULL,
  `isActive` int(1) NOT NULL,
  `dateCreated` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`idUser`, `namaUser`, `emailUser`, `imageUser`, `passwordUser`, `idRole`, `isActive`, `dateCreated`) VALUES
(1, 'Rangga Dimas Permadi', 'ranggadpermadi@gmail.com', 'bmw.png', '$2y$10$f6/ZzO1zZGLiWlg3v7YKSOFpoNgpRb4aEvUY/mpn7X5e7H7DLPUIi', 1, 1, 1577105734),
(2, 'Boris', 'bonuslupis@gmail.com', 'default.jpg', '$2y$10$OmixDpHYYs.nvFg6iEruiO0qETyejnSFaIQ/g.vSxKsV36Bsgk0lq', 2, 1, 1579512012),
(3, 'Testing', 'badcodebutgoodjoke@gmail.com', 'default.jpg', '$2y$10$DUiWejhAedfZYu1QMuOt4uSwyfQ1Hx9U2x4fxjE/AkgqKDfFP4aTO', 2, 0, 1583503854);

-- --------------------------------------------------------

--
-- Table structure for table `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `idAccess` int(11) NOT NULL,
  `idRole` int(11) NOT NULL,
  `idMenu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_access_menu`
--

INSERT INTO `user_access_menu` (`idAccess`, `idRole`, `idMenu`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(4, 1, 3),
(5, 1, 4),
(6, 2, 4);

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE `user_menu` (
  `idMenu` int(11) NOT NULL,
  `namaMenu` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_menu`
--

INSERT INTO `user_menu` (`idMenu`, `namaMenu`) VALUES
(1, 'Admin'),
(2, 'User'),
(3, 'Menu'),
(4, 'Inventory');

-- --------------------------------------------------------

--
-- Table structure for table `user_role`
--

CREATE TABLE `user_role` (
  `idRole` int(11) NOT NULL,
  `role` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_role`
--

INSERT INTO `user_role` (`idRole`, `role`) VALUES
(1, 'Administrator'),
(2, 'Member');

-- --------------------------------------------------------

--
-- Table structure for table `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `idSubMenu` int(11) NOT NULL,
  `idMenu` int(11) NOT NULL,
  `judulSubMenu` varchar(128) NOT NULL,
  `urlSubMenu` varchar(128) NOT NULL,
  `iconSubMenu` varchar(128) NOT NULL,
  `isActiveMenu` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`idSubMenu`, `idMenu`, `judulSubMenu`, `urlSubMenu`, `iconSubMenu`, `isActiveMenu`) VALUES
(1, 1, 'Dashboard', 'admin', 'fas fa-fw fa-tachometer-alt', 1),
(2, 2, 'Profile', 'user', 'fas fa-fw fa-user', 1),
(3, 2, 'Edit Profile', 'user/edit', 'fas fa-fw fa-user-edit', 1),
(4, 3, 'Menu Management', 'menu', 'fas fa-fw fa-folder', 1),
(5, 3, 'Submenu Management', 'menu/submenu', 'fas fa-fw fa-folder-open', 1),
(8, 1, 'Role', 'admin/role', 'fas fa-fw fa-user-tie', 1),
(9, 2, 'Change Password', 'user/changepassword', 'fas fa-fw fa-key', 1),
(10, 2, 'Earnings', 'user/earning', 'fas fa-fw fa-coins', 1),
(11, 4, 'Inventory', 'inventory', 'fas fa-fw fa-warehouse', 1),
(12, 4, 'Orders', 'inventory/orders', 'fas fa-fw fa-boxes', 1),
(13, 4, 'Deals', 'inventory/deals', 'far fa-fw fa-money-bill-alt', 1),
(14, 4, 'Cabang', 'inventory/cabang', 'fas fa-fw fa-store', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_token`
--

CREATE TABLE `user_token` (
  `idToken` int(11) NOT NULL,
  `email` varchar(128) NOT NULL,
  `token` varchar(128) NOT NULL,
  `date_created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_token`
--

INSERT INTO `user_token` (`idToken`, `email`, `token`, `date_created`) VALUES
(1, 'badcodebutgoodjoke@gmail.com', 'l87kI3tRqemiUNVviI9viiJlmcvXCKZhl+225SSfu0k=', 1583503854);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bulan`
--
ALTER TABLE `bulan`
  ADD PRIMARY KEY (`idBulan`);

--
-- Indexes for table `cabang`
--
ALTER TABLE `cabang`
  ADD PRIMARY KEY (`idCabang`);

--
-- Indexes for table `earnings`
--
ALTER TABLE `earnings`
  ADD PRIMARY KEY (`idEarning`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`idOrder`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`idProduk`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`);

--
-- Indexes for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`idAccess`);

--
-- Indexes for table `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`idMenu`);

--
-- Indexes for table `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`idRole`);

--
-- Indexes for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`idSubMenu`);

--
-- Indexes for table `user_token`
--
ALTER TABLE `user_token`
  ADD PRIMARY KEY (`idToken`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bulan`
--
ALTER TABLE `bulan`
  MODIFY `idBulan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `cabang`
--
ALTER TABLE `cabang`
  MODIFY `idCabang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `earnings`
--
ALTER TABLE `earnings`
  MODIFY `idEarning` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `idOrder` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `idProduk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `idAccess` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `idMenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_role`
--
ALTER TABLE `user_role`
  MODIFY `idRole` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `idSubMenu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_token`
--
ALTER TABLE `user_token`
  MODIFY `idToken` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
