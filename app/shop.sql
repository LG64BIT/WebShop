-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 29, 2022 at 01:32 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent_id`) VALUES
(1, 'uncategorized', 0),
(2, 'AMD', 4),
(3, 'Nvidia', 4),
(4, 'GPU', 0),
(5, 'CPU', 0),
(6, 'AMD Ryzen', 5),
(7, 'Intel Core', 5);

-- --------------------------------------------------------

--
-- Table structure for table `guests`
--

CREATE TABLE `guests` (
  `id` int(11) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `guests`
--

INSERT INTO `guests` (`id`, `firstName`, `lastName`, `email`, `address`, `phone`) VALUES
(2, 'Tomica', 'Tomić', 'traktorTom@gmail.com', 'Trpimirova 12, Semeljci', '099-123-1234'),
(4, 'Luka', 'Lukic', 'luka.lukic@hotmail.com', 'Kralja Trpimira 95, Vuka', '095-599-8158');

-- --------------------------------------------------------

--
-- Table structure for table `guest_orders`
--

CREATE TABLE `guest_orders` (
  `id` int(11) NOT NULL,
  `guest_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `guest_orders`
--

INSERT INTO `guest_orders` (`id`, `guest_id`, `product_id`, `status`, `quantity`, `date`) VALUES
(1, 2, 4, 'completed', 1, '2022-06-23 15:15:20'),
(3, 4, 1, 'payed', 1, '2022-06-23 15:08:08');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `quantity`, `image`) VALUES
(1, 'Gtx 1080 ti', '680.00', 'SPECIFICATIONS\r\n\r\nBase Clock: 1480 MHZ\r\nBoost Clock: 1582 MHz\r\nMemory Clock: 11016 MHz Effective\r\nCUDA Cores: 3584\r\nBus Type: PCIe 3.0\r\nMemory Detail: 11264MB GDDR5X\r\nMemory Bit Width: 352 Bit\r\nMemory Speed: 0.18ns\r\nMemory Bandwidth: 484.4 GB/s', 2, 'img1.jpg'),
(2, 'GTX 3090 ti founders edition', '2500.00', 'Chipset Manufacturer	NVIDIA\r\nGPU Series	NVIDIA GeForce RTX 30 Series\r\nGPU 	GeForce RTX 3090 Ti\r\nCore Clock 	1905 MHz\r\nCUDA Cores 	10752\r\nMemory\r\nEffective Memory Clock 	21000 MHz\r\nMemory Size	24GB\r\nMemory Interface 	384-Bit\r\nMemory Type	GDDR6X\r\n3D API\r\nDirectX 	DirectX 12 Ultimate\r\nOpenGL 	OpenGL 4.6\r\nPorts\r\nMulti-Monitor Support	4\r\nHDMI 	1 x HDMI 2.1\r\nDisplayPort 	3 x DisplayPort 1.4a\r\nDetails\r\nMax Resolution	7680 x 4320\r\nVirtual Reality Ready	Yes\r\nCooler	WINDFORCE 3X\r\nRecommended PSU Wattage	850W\r\nPower Connector	1 x 16-Pin\r\nForm Factor & Dimensions\r\nForm Factor 	ATX\r\nMax GPU Length	331 mm\r\nCard Dimensions (L x H)	13.03\" x 5.91\"\r\nSlot Width	3.5 slot\r\nPackaging\r\nPackage Contents	Accessory\r\n12-pin power cable\r\nVGA holder', 1, 'img2.jpg'),
(3, 'GTX 1050 Ti 4GB GDDR5', '205.00', 'New NVIDIA pascal architecture delivers improved performance and power efficiency\r\nClassic and modern games at 1080P at 60 FPS\r\nFast, smooth, power-efficient gaming experiences. Support up to 8K display at 60Hz\r\nSupport for the latest DirectX 12 Features\r\nDelivers all the latest GeForce gaming Features. Card size-H=40 L=229 W=118 mm. Recommended PSU: 300W\r\nForm Factor: ATX', 4, 'img3.jpg'),
(4, 'AMD Radeon r9 270x', '89.99', 'Memory Size:	\r\n2 GB	\r\nConnectors:	\r\nDisplayPort, DVI-D, DVI-I, HDMI\r\nCompatible Slot:	\r\nPCI, PCI Express 3.0 x16	\r\nAPIs:	\r\nShader Model 5.1, DirectX 11.2, OpenCL 1.2, OpenGL 4.3\r\nChipset/GPU Model:	\r\nAMD Radeon R9 270	\r\nMemory Type:	\r\nGDDR5\r\nChipset Manufacturer:	\r\nAMD	\r\nMPN:	\r\n7121800900G, 106DK\r\nPower Cable Requirement:	\r\n2x 6-Pin', 4, 'img4.jpg'),
(5, 'Gtx Titan Z', '993.00', '12GB 768-Bit GDDR5\r\nCore Clock 705 MHz\r\nBoost Clock 876 MHz\r\n1 x DVI-I 1 x DVI-D 1 x HDMI 1 x DisplayPort\r\n5760 CUDA Cores\r\nPCI Express 3.0', 1, '2575-front.jpg'),
(13, 'Ryzen Threadripper 2950x', '899.99', '16 Cores and 32 Processing Threads, Updated with 2nd Gen Ryzen Technology Advancements\r\nIncredible 4.4 GHz Max Boost Frequency, with a huge 40MB Cache\r\nUnlocked, with automatic overclocking via the new Precision Boost Overdrive (PBO) feature\r\nQuad-Channel DDR4 and 64 PCIe lanes, the most bandwidth and I/O you can get on Desktop Processor\r\n180W TDP, CPU Cooler Not Included', 4, '20180924160424_cad27d99.jpeg'),
(14, 'Thermal Paste', '5.49', 'BRAND  	AeroCool\r\nMFG CODE  	ACTG-NA21210.01\r\nTYPE  Thermal compound  \r\nQUANTITY  1 g  \r\nTHERMAL CONDUCTIVITY  	5.15 W/mK  \r\nDENSITY  3.5 g/cm3  \r\nVISCOSITY  12500  \r\nWORKING TEMP  -30° ~ 280°  \r\nCOLOR Grey\r\nOTHERS  non-electric conductive material', 9, 'R.jpg'),
(16, 'Intel Core i9 12900k', '589.98', 'The processor features Socket LGA-1700 socket for installation on the PCB\r\n30 MB of L3 cache memory provides excellent hit rate in short access time enabling improved system performance\r\n10 nm enables improved performance per watt and micro architecture makes it power-efficient\r\nIntel 7 Architecture enables improved performance per watt and micro architecture makes it power-efficient', 5, 'intelI9.jpg'),
(17, 'Intel Core i7 10700k', '311.99', '8 Cores / 16 Threads\r\nSocket type LGA 1200\r\nUp to 5.1 GHz unlocked\r\nCompatible with Intel 400 series chipset based motherboards.Bus Speed: 8 GT/s\r\nIntel Turbo Boost Max Technology 3.0 support\r\nIntel Optane Memory support\r\nGraphics Base Frequency: 350 MHz', 10, '71P3chRzgNL._AC_SX522_.jpg'),
(18, 'Ryzen 9 5900x', '549.99', 'The world\'s best gaming desktop processor, with 12 cores and 24 processing threads\r\nCan deliver elite 100-plus FPS performance in the world\'s most popular games\r\nCooler not included, high-performance cooler recommended. Max Temperature- 90°C\r\n4.8 GHz Max Boost, unlocked for overclocking, 70 MB of cache, DDR-3200 support\r\nFor the advanced Socket AM4 platform, can support PCIe 4.0 on X570 and B550 motherboards', 3, 'AMD-Ryzen-9-5900X-Processor.jpg'),
(19, 'CRJ 4-Pin Molex Male to Female Extension', '8.99', 'PC Molex Extension Cable Is Compatible With All ATX Power Supplies\r\nQuality Construction Features High Density Black Sleeved Cable And Crimped Connectors\r\nCable Length (Including Connectors): 24.6\"\r\n\r\nBrand Name	CRJ Electronics\r\nColor	Black\r\nCompatible Devices	Personal Computer\r\nConnector Gender	Female-to-Male\r\nConnector Type	4-pin Male Molex\r\nSize	24\"', 25, '81ABhsW1y3L._SX522_.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

CREATE TABLE `product_category` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`id`, `product_id`, `category_id`) VALUES
(48, 1, 3),
(49, 1, 4),
(62, 2, 3),
(63, 2, 4),
(52, 3, 3),
(53, 3, 4),
(56, 4, 2),
(57, 4, 4),
(58, 5, 3),
(59, 5, 4),
(60, 13, 5),
(61, 13, 6),
(47, 14, 1),
(64, 16, 5),
(65, 16, 7),
(70, 17, 5),
(71, 17, 7),
(68, 18, 5),
(69, 18, 6),
(72, 19, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `password`, `isAdmin`, `firstName`, `lastName`, `email`, `address`, `phone`) VALUES
(8, '$2y$10$wtVdzEjaGHpSmrsI8eaGGeqyVAMOYAjGtzk4a5viwP6aHvqcu9Qwa', 0, 'Dubravka', 'Ivanušić', 'd.ivanusic@gmail.com', 'Kneza Domagoja 12, Trogir', '091/512-1233'),
(11, '$2y$10$cXMuikckPLQlhOl1r9WnvOXSYowLBhizpWlU3t8I1qlU5prxzb7Be', 1, 'Root', 'Rootić', 'root@gmail.com', 'Rootopoly 12', '123/123-1234');

-- --------------------------------------------------------

--
-- Table structure for table `user_orders`
--

CREATE TABLE `user_orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_orders`
--

INSERT INTO `user_orders` (`id`, `user_id`, `product_id`, `status`, `quantity`, `date`) VALUES
(3, 11, 1, 'payed', 1, '2022-06-23 15:01:49'),
(10, 11, 1, 'payed', 2, '2022-06-23 15:01:49'),
(14, 11, 1, 'payed', 2, '2022-06-23 15:01:49'),
(18, 8, 1, 'shipped', 1, '2022-06-24 13:54:45'),
(19, 8, 14, 'completed', 1, '2022-06-24 13:56:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guests`
--
ALTER TABLE `guests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guest_orders`
--
ALTER TABLE `guest_orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id` (`product_id`,`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_orders`
--
ALTER TABLE `user_orders`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `guests`
--
ALTER TABLE `guests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `guest_orders`
--
ALTER TABLE `guest_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_orders`
--
ALTER TABLE `user_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
