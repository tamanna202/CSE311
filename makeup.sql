-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 23, 2022 at 08:01 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `makeup`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `aid` int(6) NOT NULL,
  `email` varchar(30) NOT NULL,
  `pass` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`aid`, `email`, `pass`) VALUES
(1, 'admin123@gmail.com', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartid` int(6) NOT NULL,
  `custid` int(6) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `cartitem`
--

CREATE TABLE `cartitem` (
  `cartid` int(6) DEFAULT NULL,
  `iid` int(6) DEFAULT NULL,
  `quantity` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `catid` int(6) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`catid`, `name`) VALUES
(1, 'face'),
(2, 'lips'),
(3, 'eyes'),
(4, 'nails'),
(5, 'skincare'),
(6, 'hair');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `custid` int(6) NOT NULL,
  `email` varchar(30) NOT NULL,
  `pass` varchar(30) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `address` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `iid` int(6) NOT NULL,
  `catid` int(6) DEFAULT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `price` int(10) NOT NULL,
  `quantity` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`iid`, `catid`, `name`, `description`, `price`, `quantity`) VALUES
(10, 1, 'Guerniss Mineral Powder Blush', 'Blusher is a must for perfect skin make-up, and when used correctly, it adds a vibrant and natural look to the face. Terracotta blushers have become very popular in recent years. Guerniss Terracotta blush is obviously a smooth, long-wearing coverage to define the cheeks.', 1250, 194),
(11, 1, 'E.l.f. Cosmetics Powder Blush Palette', 'Quality makeup is hard to find, so you will be glad that you’ve discovered the e.l.f. Blush Palette. It contours your cheeks for a rosy glow. It comes with silky smooth brushes to create an ideal look. The compact offers a mixture of complementary matte and shimmer finishes, so you can create your own special look. The blush features shades that sculpture just the right areas. The highlighting hues create a professional style.', 350, 300),
(12, 1, 'Alix Avien TERRACOTTA BLUSH', 'Eliminates color imperfections particularly on the face and décolleté area for prominent cheekbones, shadow and defined expression. Does not weigh the face down, easily blends in with your complexion and does not smear. A significant helper you wish to have in your make-up bag.', 1275, 1500),
(13, 1, 'Wet n Wild Color Icon Blush', 'A silky smooth pressed powder that delivers radiant color to flatten any skin tone.Strike the perfect balance between a blendable transparent shine and a radiant touch of maximum color.\r\nLightweight and durable. Cruelty free, gluten free, fragrance free.', 380, 1200),
(14, 5, 'Revolution Ultra Blush Palette Sugar and Spice', 'Our Revolution Ultra Blush Palette Sugar and Spice is perfect for the professional application desired by all of us. Perfect for highlighting and contouring too. Professional and highly pigmented, yet easy to blend, these contain 8 shades consisting of shimmer and matte blushers, merged baked blusher, and merged baked highlighter powder. The ULTIMATE blush palette offering you 8 shades in 1 to suit any occasion! 8 exclusive and unique shades in each palette can be either used individually or combined to create the shade that you.', 750, 1990);

-- --------------------------------------------------------

--
-- Table structure for table `orderr`
--

CREATE TABLE `orderr` (
  `oid` int(6) NOT NULL,
  `cartid` int(6) DEFAULT NULL,
  `orderby` int(6) DEFAULT NULL,
  `delivered` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartid`),
  ADD KEY `custid` (`custid`);

--
-- Indexes for table `cartitem`
--
ALTER TABLE `cartitem`
  ADD KEY `cartid` (`cartid`),
  ADD KEY `iid` (`iid`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`catid`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`custid`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`iid`),
  ADD KEY `catid` (`catid`);

--
-- Indexes for table `orderr`
--
ALTER TABLE `orderr`
  ADD PRIMARY KEY (`oid`),
  ADD KEY `cartid` (`cartid`),
  ADD KEY `orderby` (`orderby`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `aid` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cartid` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `catid` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `custid` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `iid` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `orderr`
--
ALTER TABLE `orderr`
  MODIFY `oid` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`custid`) REFERENCES `customer` (`custid`);

--
-- Constraints for table `cartitem`
--
ALTER TABLE `cartitem`
  ADD CONSTRAINT `cartitem_ibfk_1` FOREIGN KEY (`cartid`) REFERENCES `cart` (`cartid`),
  ADD CONSTRAINT `cartitem_ibfk_2` FOREIGN KEY (`iid`) REFERENCES `item` (`iid`);

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `item_ibfk_1` FOREIGN KEY (`catid`) REFERENCES `category` (`catid`);

--
-- Constraints for table `orderr`
--
ALTER TABLE `orderr`
  ADD CONSTRAINT `orderr_ibfk_1` FOREIGN KEY (`cartid`) REFERENCES `cart` (`cartid`),
  ADD CONSTRAINT `orderr_ibfk_2` FOREIGN KEY (`orderby`) REFERENCES `customer` (`custid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
