-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2022 at 06:56 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookmart`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `Username` varchar(255) NOT NULL,
  `Name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`Username`, `Name`) VALUES
('admin@bookmart.com', 'alvin lal');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_author`
--

CREATE TABLE `tbl_author` (
  `Author_id` int(11) NOT NULL,
  `A_name` varchar(30) DEFAULT NULL,
  `A_status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_author`
--

INSERT INTO `tbl_author` (`Author_id`, `A_name`, `A_status`) VALUES
(32, 'Dr APJ Abdul Kalam', 'active'),
(33, 'Agatha Christie', 'active'),
(34, 'Sir Conan Arthur Doyle', 'active'),
(35, 'Paul Kalanithi', 'active'),
(36, 'Vaikam Muhammad Basheer', 'active'),
(37, 'JK Rowling', 'active'),
(38, 'John Carreyrou', 'active'),
(39, 'James Clear', 'active'),
(40, 'Robert T Kiyosaki', 'active'),
(41, 'Benjamin Graham', 'active'),
(42, 'Pauolo Coelho', 'active'),
(43, 'Jane Austen', 'active'),
(44, 'Rachael Lippincott', 'active'),
(45, 'Jeff Kinney', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_card`
--

CREATE TABLE `tbl_card` (
  `Card_id` int(11) NOT NULL,
  `Username` varchar(255) DEFAULT NULL,
  `Card_no` decimal(16,0) DEFAULT NULL,
  `Card_cvv` varchar(3) DEFAULT NULL,
  `Card_name` varchar(60) DEFAULT NULL,
  `Expiry_date` varchar(7) DEFAULT NULL,
  `Card_status` enum('active','deleted') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_card`
--

INSERT INTO `tbl_card` (`Card_id`, `Username`, `Card_no`, `Card_cvv`, `Card_name`, `Expiry_date`, `Card_status`) VALUES
(30, 'customer@gmail.com', '1234567891234568', '345', 'Alvin lal', '02/2024', 'active'),
(31, 'customer@gmail.com', '1234567891112345', '123', 'Alvin lal', '12/2024', 'deleted'),
(32, 'customer2@gmail.com', '1234567891234567', '345', 'Joy James', '02/2025', 'active'),
(33, 'customer7@gmail.com', '9876543211982345', '145', 'Chris harris', '10/2023', 'active'),
(34, 'customer@gmail.com', '8352645372836452', '342', 'Alvin Lal', '02/2025', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart_child`
--

CREATE TABLE `tbl_cart_child` (
  `Cart_child_id` int(11) NOT NULL,
  `Cart_master_id` int(11) NOT NULL,
  `Item_id` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Total_price` decimal(8,2) NOT NULL,
  `Added_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_cart_child`
--

INSERT INTO `tbl_cart_child` (`Cart_child_id`, `Cart_master_id`, `Item_id`, `Quantity`, `Total_price`, `Added_date`) VALUES
(210, 94, 59, 3, '630.00', '2022-03-22'),
(216, 96, 59, 2, '420.00', '2022-03-22'),
(217, 98, 56, 4, '1080.00', '2022-03-22'),
(219, 95, 56, 1, '270.00', '2022-03-22'),
(220, 98, 54, 4, '880.00', '2022-03-22'),
(221, 99, 54, 1, '220.00', '2022-03-22'),
(222, 99, 53, 1, '300.00', '2022-03-22'),
(223, 97, 53, 2, '600.00', '2022-03-22'),
(224, 97, 51, 2, '552.00', '2022-03-22'),
(225, 100, 51, 2, '552.00', '2022-03-22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cart_master`
--

CREATE TABLE `tbl_cart_master` (
  `Cart_master_id` int(11) NOT NULL,
  `Username` varchar(255) DEFAULT NULL,
  `Cart_status` enum('created','ordered','payed') DEFAULT 'created',
  `Total_amt` decimal(8,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_cart_master`
--

INSERT INTO `tbl_cart_master` (`Cart_master_id`, `Username`, `Cart_status`, `Total_amt`) VALUES
(90, 'customer3@gmail.com', 'created', '0.00'),
(91, 'customer4@gmail.com', 'created', '0.00'),
(92, 'customer5@gmail.com', 'created', '0.00'),
(93, 'customer6@gmail.com', 'created', '0.00'),
(94, 'customer@gmail.com', 'payed', '630.00'),
(95, 'customer@gmail.com', 'payed', '270.00'),
(96, 'customer2@gmail.com', 'payed', '420.00'),
(97, 'customer2@gmail.com', 'payed', '1152.00'),
(98, 'customer7@gmail.com', 'created', '1960.00'),
(99, 'customer@gmail.com', 'payed', '520.00'),
(100, 'customer@gmail.com', 'payed', '552.00'),
(101, 'customer2@gmail.com', 'created', '0.00'),
(102, 'customer@gmail.com', 'created', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `Cat_id` int(11) NOT NULL,
  `Cat_name` varchar(20) DEFAULT NULL,
  `Cat_status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_category`
--

INSERT INTO `tbl_category` (`Cat_id`, `Cat_name`, `Cat_status`) VALUES
(1, 'Art & Music', 'active'),
(2, 'Biographies', 'active'),
(3, 'Comics', 'active'),
(4, 'Education', 'active'),
(5, 'Novels', 'active'),
(6, 'History', 'active'),
(7, 'Self-help', 'active'),
(8, 'Technology', 'active'),
(9, 'Hobbies & crafts', 'active'),
(10, 'Home & garden', 'active'),
(11, 'Finance', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `Cust_id` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `C_phno` decimal(10,0) NOT NULL,
  `C_fname` varchar(25) NOT NULL,
  `C_lname` varchar(25) NOT NULL,
  `C_housename` varchar(20) NOT NULL,
  `C_city` varchar(20) NOT NULL,
  `C_district` varchar(20) NOT NULL,
  `C_pin` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_customer`
--

INSERT INTO `tbl_customer` (`Cust_id`, `Username`, `C_phno`, `C_fname`, `C_lname`, `C_housename`, `C_city`, `C_district`, `C_pin`) VALUES
(28, 'customer3@gmail.com', '7892736455', 'John', 'Joe', 'john villa', 'Thodupuzha', 'Idukki', '685581'),
(29, 'customer4@gmail.com', '5322123232', 'Jake', 'Joy', 'jake villa', 'Brooklyn', 'NewYork', '782343'),
(30, 'customer5@gmail.com', '9323323222', 'Allen', 'Waltz', 'allen villa', 'Kochi', 'Ernakulam', '782322'),
(31, 'customer@gmail.com', '9207248664', 'Alvin', 'lal', 'alvin villa', 'Puthencruze', 'Ernakulam', '682310'),
(32, 'customer2@gmail.com', '8732938721', 'Joy', 'James', 'joy villa', 'Varkala', 'Trivandrum', '688004'),
(33, 'customer7@gmail.com', '9274828282', 'Chris', 'harris', 'harris villa', 'Kochi', 'Ernakulam', '622345');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_item`
--

CREATE TABLE `tbl_item` (
  `Item_id` int(11) NOT NULL,
  `Author_id` int(11) NOT NULL,
  `Publisher_id` int(11) NOT NULL,
  `SubCat_id` int(11) NOT NULL,
  `I_cover_image` varchar(100) NOT NULL,
  `I_isbn` decimal(13,0) NOT NULL,
  `I_title` varchar(50) NOT NULL,
  `I_description` text NOT NULL,
  `I_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `I_stock` int(11) NOT NULL DEFAULT 0,
  `I_no_of_pages` int(11) NOT NULL,
  `I_language` varchar(20) NOT NULL,
  `I_status` enum('active','inactive') DEFAULT 'active',
  `I_date_added` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_item`
--

INSERT INTO `tbl_item` (`Item_id`, `Author_id`, `Publisher_id`, `SubCat_id`, `I_cover_image`, `I_isbn`, `I_title`, `I_description`, `I_price`, `I_stock`, `I_no_of_pages`, `I_language`, `I_status`, `I_date_added`) VALUES
(50, 32, 24, 8, 'a5ddd3a2bab77853c9e2.jpg', '9788173711421', 'Wings of fire', 'Wings of Fire: An Autobiography of APJ Abdul Kalam, former President of India. It was written by Dr. Abdul Kalam and Arun Tiwari. Dr. Kalam examines his early life, effort, hardship, fortitude, luck and chance that eventually led him to lead Indian space research, nuclear and missile programs.', '242.00', 10, 200, 'English', 'active', '2022-03-22'),
(51, 34, 26, 24, '59977705b3a082175205.jpg', '8175994312', 'Sherlock holmes : A study in Scarlet', 'A Study in Scarlet is an 1887 detective novel written by Arthur Conan Doyle. The story marks the first appearance of Sherlock Holmes and Dr. Watson, who would become the most famous detective duo in literature.', '276.00', 6, 151, 'English', 'active', '2022-03-22'),
(52, 42, 26, 23, '404617e4448e15875197.jpg', '9788172234980', 'The Alchemist', 'Paulo Coelho\'s enchanting novel has inspired a devoted following around the world. This story, dazzling in its powerful simplicity and inspiring wisdom, is about an Andalusian shepherd boy named Santiago who travels from his homeland in Spain to the Egyptian desert in search of a treasure buried in the Pyramids', '253.00', 10, 172, 'English', 'active', '2022-03-22'),
(53, 33, 30, 24, 'd1cdce5b86cc5713269c.jpg', '9780008123208', 'And then there were none', 'Ten strangers are invited to Soldier Island, an isolated rock near the Devon coast. Cut off from the mainland, with their generous hosts Mr and Mrs U.N. Owen mysteriously absent, they are each accused of a terrible crime. When one of the party dies suddenly they realise they may be harbouring a murderer among their number.', '300.00', 17, 200, 'English', 'active', '2022-03-22'),
(54, 36, 25, 22, '7bf80d355748fd352943.jpg', '8171302092', 'Paathumayude Aadu', 'Pathummayude Aadu is one of the most popular works by Vaikom Muhammad Basheer. It has a long foreword by the novelist himself and a longer afterword by P K Balakrishnan. This special edition also has illustrations by Sherif and photographs of the real characters including Pathumma and goats.', '220.00', 4, 124, 'Malayalam', 'active', '2022-03-22'),
(55, 38, 29, 56, '338fd2c9010128095591.jpg', '1509868089', 'Bad Blood: Secrets and Lies in a Silicon Valley St', 'The full inside story of the breathtaking rise and shocking collapse of Theranos, the multibillion-dollar biotech startup founded by Elizabeth Holmes, by the prize-winning journalist who first broke the story and pursued it to the end, despite pressure from its charismatic CEO and threats by her lawyers.', '330.00', 10, 352, 'English', 'active', '2022-03-22'),
(56, 43, 28, 21, '9f78f4cc230a6657e95f.jpg', '8172344503', 'Pride And Prejudice', 'The story is set in England in the late 18th century. Charles Bingley, a wealthy and charismatic single man, moves to the Netherfield estate, and when he does, the residents there are very thrilled', '270.00', 4, 328, 'English', 'active', '2022-03-22'),
(57, 44, 27, 21, '2887c09b9aca79244a19.jpg', '1471185095', 'Five feet apart', 'Stella Grant likes to be in control—even though her totally out of control lungs have sent her in and out of the hospital most of her life. At this point, what Stella needs to control most is keeping herself away from anyone or anything that might pass along an infection and jeopardize the possibility of a lung transplant.', '224.00', 13, 288, 'English', 'active', '2022-03-22'),
(58, 35, 27, 9, '1e2dbde4f3e6cbee3b8c.jpg', '9781847923677', 'When Breathe Becomes Air', 'When Breath Becomes Air is a non-fiction autobiographical book written by American neurosurgeon Paul Kalanithi. It is a memoir about his life and illness, battling stage IV metastatic lung cancer. It was posthumously published by Random House on January 12, 2016.', '315.00', 5, 256, 'English', 'active', '2022-03-22'),
(59, 45, 27, 57, 'fb19a4ecc8aa55d4082e.jpg', '9780141324913', 'Diary of a wimpy kid : Rodrick Rules', 'Diary of a Wimpy Kid: Rodrick Rules is a sequel to the colossal hit \'Diary of a Wimpy Kid\'. The story rotates around an 8th grader Gregory Heffley who is facing some problems which usually is not faced by a mid-school child. The new academic year has just started at school. Greg, in his journal, initiates by focusing on how disastrous his summer vacations went. Greg is a kid, who is considered as a recluse by his peers due to the cheese touch. Although, he tries to forget the past things as a new and fresh academic year is about to start, things do not go down well with him as his own brother Rodrick Heffley knows one of Greg\'s dirty secret.', '210.00', 3, 224, 'English', 'active', '2022-03-22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login`
--

CREATE TABLE `tbl_login` (
  `Username` varchar(255) NOT NULL,
  `User_type` enum('admin','staff','customer') DEFAULT NULL,
  `User_status` enum('active','inactive') DEFAULT 'active',
  `Password` varchar(255) NOT NULL,
  `added_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_login`
--

INSERT INTO `tbl_login` (`Username`, `User_type`, `User_status`, `Password`, `added_date`) VALUES
('admin@bookmart.com', 'admin', 'active', '$2y$10$E/zLrPOjYuRn0UDIYcrtceNt6LnziAOOtK/VSqi4hbR2cmhoJe6Ze', '2021-12-04'),
('customer2@gmail.com', 'customer', 'active', '$2y$10$CDfhjIDPrIoQ4wD3ZsyDyOFspWpdcGIBdrVsnj.12U.rbd1t3dLom', '2022-03-22'),
('customer3@gmail.com', 'customer', 'active', '$2y$10$gOO/7USpj6XV5qtdxXPlSee2eXsrMbFcLuhwZnOYLZX6.2KdzYacy', '2022-03-22'),
('customer4@gmail.com', 'customer', 'active', '$2y$10$YRspal8SXeJx9nMEuCshZuxZWg7iq0k4KBULlQnpPwAaYZszfWylG', '2022-03-22'),
('customer5@gmail.com', 'customer', 'active', '$2y$10$Gp0FarZy8OqHBQ3HqJxVmOMAPf7vNvag5w9Do.a9RlgiXZwFrG4Z.', '2022-03-22'),
('customer6@gmail.com', 'customer', 'active', '$2y$10$34qG8l6Jsdj2AyToBcQxtOAVtohUxFjLJaBPq/EiRhRd19N.WeUR.', '2022-03-22'),
('customer7@gmail.com', 'customer', 'active', '$2y$10$TkRzrVbjdbR6spIrPgyrBuwpa7HULplmq8dQl8MFzTeoG7VKXQVMK', '2022-03-22'),
('customer@gmail.com', 'customer', 'active', '$2y$10$3uwKXZL5dleHMDuuDqhqNeZPkwZqFz8o8yFlDeTgdbtd/DolJJfPG', '2022-03-22'),
('staff2@gmail.com', 'staff', 'active', '$2y$10$PpFe4.TGeiYWYBqosXIJv.VocktmAPyJKZ3Dn0u9sU4dben5TPIXe', '2022-03-23'),
('staff3@gmail.com', 'staff', 'active', '$2y$10$VjFyYJX2..yrwhkJDDEu3uSz3I4G7RaspS87Sr7z1wfUcgF7B9hFG', '2022-03-23'),
('staff4@gmail.com', 'staff', 'active', '$2y$10$kJgSwTy7ZEDBLCwkCpa45OpjVYc1MM.cUrbrw3AbmRRdmCMtZ6gaO', '2022-03-26'),
('staff5@gmail.com', 'staff', 'active', '$2y$10$6nvzwxI6c1XjfFuzgesSbO7l2k8unRW4xdZC14iNbVHqSGxMDrZNm', '2022-03-28'),
('staff6@gmail.com', 'staff', 'active', '$2y$10$yiPSrjiY4KsfT/bDVGWDy.Kw3tbIoJbhP.aXVl1OyXJNXe1h5/XWy', '2022-04-01'),
('staff@gmail.com', 'staff', 'active', '$2y$10$O.wzojvc/A6TnsIdawbRE.28.0R9MoLS9TluONGW1exghoqKrZ.F2', '2022-03-22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `Order_id` int(11) NOT NULL,
  `Cart_master_id` int(11) NOT NULL,
  `O_date` date DEFAULT NULL,
  `O_status` enum('ordered','shipped','delivered') NOT NULL DEFAULT 'ordered'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`Order_id`, `Cart_master_id`, `O_date`, `O_status`) VALUES
(65, 94, '2022-03-22', 'ordered'),
(66, 96, '2022-03-22', 'delivered'),
(67, 95, '2022-03-22', 'ordered'),
(68, 99, '2022-03-22', 'ordered'),
(69, 97, '2022-03-22', 'delivered'),
(70, 100, '2022-03-22', 'delivered');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_payment`
--

CREATE TABLE `tbl_payment` (
  `Payment_id` int(11) NOT NULL,
  `Card_id` int(11) NOT NULL,
  `Order_id` int(11) NOT NULL,
  `Payment_status` enum('initiated','payed') DEFAULT 'initiated',
  `Payment_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_payment`
--

INSERT INTO `tbl_payment` (`Payment_id`, `Card_id`, `Order_id`, `Payment_status`, `Payment_date`) VALUES
(2, 16, 2, 'payed', '2021-10-13'),
(3, 17, 3, 'payed', '2021-10-13'),
(4, 18, 4, 'payed', '2021-10-13'),
(5, 17, 5, 'payed', '2021-10-13'),
(6, 16, 6, 'payed', '2021-10-13'),
(7, 20, 7, 'payed', '2021-10-13'),
(8, 16, 8, 'payed', '2021-11-23'),
(9, 17, 9, 'payed', '2021-11-25'),
(10, 17, 10, 'payed', '2021-11-25'),
(11, 17, 11, 'payed', '2021-11-25'),
(12, 16, 12, 'payed', '2021-11-26'),
(13, 21, 13, 'payed', '2021-11-26'),
(14, 18, 14, 'payed', '2021-11-26'),
(15, 21, 15, 'payed', '2021-11-26'),
(16, 18, 16, 'payed', '2021-11-26'),
(17, 18, 17, 'payed', '2021-11-26'),
(18, 22, 18, 'payed', '2021-11-27'),
(19, 23, 19, 'payed', '2021-11-27'),
(20, 23, 20, 'payed', '2021-11-27'),
(21, 21, 21, 'payed', '2021-11-27'),
(22, 17, 22, 'payed', '2021-11-27'),
(23, 16, 23, 'payed', '2021-11-29'),
(24, 17, 24, 'payed', '2021-11-29'),
(25, 24, 25, 'payed', '2021-11-29'),
(26, 16, 26, 'payed', '2021-11-30'),
(27, 21, 27, 'payed', '2021-11-30'),
(28, 18, 28, 'payed', '2021-11-30'),
(29, 21, 29, 'payed', '2021-12-01'),
(30, 18, 30, 'payed', '2021-12-01'),
(31, 18, 31, 'payed', '2021-12-01'),
(32, 18, 32, 'payed', '2021-12-01'),
(33, 18, 33, 'payed', '2021-12-01'),
(34, 18, 34, 'payed', '2021-12-01'),
(35, 18, 35, 'payed', '2021-12-01'),
(36, 25, 36, 'payed', '2021-12-05'),
(37, 26, 37, 'payed', '2021-12-06'),
(38, 16, 38, 'payed', '2021-12-06'),
(39, 26, 39, 'payed', '2021-12-06'),
(40, 25, 40, 'payed', '2021-12-06'),
(41, 16, 41, 'payed', '2021-12-06'),
(42, 18, 42, 'payed', '2021-12-07'),
(43, 17, 43, 'payed', '2021-12-07'),
(44, 27, 44, 'payed', '2021-12-07'),
(45, 25, 45, 'payed', '2021-12-07'),
(46, 25, 46, 'payed', '2021-12-07'),
(47, 16, 47, 'payed', '2021-12-07'),
(48, 25, 48, 'payed', '2021-12-07'),
(49, 16, 49, 'payed', '2021-12-07'),
(50, 16, 50, 'payed', '2021-12-07'),
(51, 16, 51, 'payed', '2021-12-07'),
(52, 16, 52, 'payed', '2021-12-07'),
(53, 16, 53, 'payed', '2021-12-07'),
(54, 16, 54, 'payed', '2021-12-07'),
(55, 16, 55, 'payed', '2021-12-07'),
(56, 16, 56, 'payed', '2021-12-07'),
(57, 16, 57, 'payed', '2021-12-08'),
(58, 16, 58, 'payed', '2021-12-08'),
(59, 16, 59, 'payed', '2022-01-03'),
(60, 25, 60, 'payed', '2022-01-03'),
(61, 16, 61, 'payed', '2022-01-11'),
(62, 16, 62, 'payed', '2022-01-11'),
(63, 16, 63, 'payed', '2022-01-11'),
(64, 16, 64, 'payed', '2022-01-11'),
(65, 30, 65, 'payed', '2022-03-22'),
(66, 32, 66, 'payed', '2022-03-22'),
(67, 30, 67, 'payed', '2022-03-22'),
(68, 30, 68, 'payed', '2022-03-22'),
(69, 32, 69, 'payed', '2022-03-22'),
(70, 30, 70, 'payed', '2022-03-22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_publisher`
--

CREATE TABLE `tbl_publisher` (
  `Publisher_id` int(11) NOT NULL,
  `P_phno` decimal(10,0) NOT NULL,
  `P_email` varchar(50) NOT NULL,
  `P_name` varchar(60) NOT NULL,
  `P_city` varchar(30) NOT NULL,
  `P_district` varchar(30) NOT NULL,
  `P_pin` varchar(6) NOT NULL,
  `P_status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_publisher`
--

INSERT INTO `tbl_publisher` (`Publisher_id`, `P_phno`, `P_email`, `P_name`, `P_city`, `P_district`, `P_pin`, `P_status`) VALUES
(24, '7733223322', 'universities@gmail.com', 'Universities Press', 'Kochi', 'Ernakulam', '682310', 'active'),
(25, '7823787121', 'dcsupport1@gmail.com', 'DC Books', 'Kottayam', 'Kottayam', '686002', 'active'),
(26, '6343323213', 'happercollinsindia@gmail.com', 'HarperCollins Publishers India', 'Gurugram', 'Gurgaon', '100525', 'active'),
(27, '8343454744', 'penguinsupport@gmail.com', 'Penguin Random House', 'Shahjahanabad', 'Central Delhi', '110002', 'active'),
(28, '6777377338', 'prakashbooks@gmail.com', 'Prakash Books', 'Daryaganj', 'Central Delhi', '101234', 'active'),
(29, '7878787223', 'picadorpvtltd@gmail.com', 'Picador Books', 'Frazer City', 'Bengaluru', '456732', 'active'),
(30, '7823121218', 'bloomsbury@gmail.com', 'Bloomsbury Publishers', 'New Delhi', 'East Delhi', '123123', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_child`
--

CREATE TABLE `tbl_purchase_child` (
  `Purchase_child_id` int(11) NOT NULL,
  `Purchase_master_id` int(11) NOT NULL,
  `Item_id` int(11) NOT NULL,
  `Purchase_price` decimal(8,2) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Total_price` decimal(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_purchase_child`
--

INSERT INTO `tbl_purchase_child` (`Purchase_child_id`, `Purchase_master_id`, `Item_id`, `Purchase_price`, `Quantity`, `Total_price`) VALUES
(112, 58, 50, '220.00', 10, '2200.00'),
(113, 58, 51, '230.00', 10, '2300.00'),
(114, 59, 52, '230.00', 10, '2300.00'),
(115, 59, 53, '250.00', 20, '5000.00'),
(116, 59, 54, '200.00', 5, '1000.00'),
(117, 60, 55, '300.00', 10, '3000.00'),
(118, 60, 56, '250.00', 5, '1250.00'),
(119, 61, 57, '200.00', 13, '2600.00'),
(120, 61, 58, '300.00', 5, '1500.00'),
(121, 62, 59, '200.00', 8, '1600.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_purchase_master`
--

CREATE TABLE `tbl_purchase_master` (
  `Purchase_master_id` int(11) NOT NULL,
  `Vendor_id` int(11) NOT NULL,
  `Purchased_by` varchar(255) NOT NULL,
  `Total_amt` decimal(8,2) NOT NULL,
  `Purchase_date` date NOT NULL,
  `Status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_purchase_master`
--

INSERT INTO `tbl_purchase_master` (`Purchase_master_id`, `Vendor_id`, `Purchased_by`, `Total_amt`, `Purchase_date`, `Status`) VALUES
(58, 30, 'admin@bookmart.com', '4500.00', '2022-03-22', 'active'),
(59, 29, 'admin@bookmart.com', '8300.00', '2022-03-22', 'active'),
(60, 31, 'admin@bookmart.com', '4250.00', '2022-03-22', 'active'),
(61, 32, 'admin@bookmart.com', '4100.00', '2022-03-21', 'active'),
(62, 33, 'admin@bookmart.com', '1600.00', '2022-03-22', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_review`
--

CREATE TABLE `tbl_review` (
  `Review_id` int(11) NOT NULL,
  `Item_id` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `R_content` text NOT NULL,
  `R_date` date NOT NULL,
  `R_status` enum('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_review`
--

INSERT INTO `tbl_review` (`Review_id`, `Item_id`, `Username`, `R_content`, `R_date`, `R_status`) VALUES
(24, 59, 'customer2@gmail.com', 'Nice book for kids to read', '2022-03-22', 'active'),
(25, 51, 'customer2@gmail.com', 'Nice book', '2022-03-22', 'active'),
(27, 51, 'customer@gmail.com', 'As good as the tv show.', '2022-03-22', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_session`
--

CREATE TABLE `tbl_session` (
  `Username` varchar(255) NOT NULL,
  `Session_id` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_session`
--

INSERT INTO `tbl_session` (`Username`, `Session_id`) VALUES
('admin@bookmart.com', 'hq5clr5ku00oj8qer20mo3onej'),
('admin@bookmart.com', 'svu5pit7m9uv1ov720bj4clsoa'),
('admin@bookmart.com', '2hdrmprfevtrlksdck3jni8qpj'),
('customer4@gmail.com', '5217r2aq28ka2dk37q5no458ug'),
('admin@bookmart.com', 's4lgr56cl74khp6slodi7scnev'),
('admin@bookmart.com', '6quumvsf5hj6ukn77um45l4n5u'),
('admin@bookmart.com', 'hcf3c09pcls7v8js25h1b6d572'),
('customer33@gmail.com', '5h4s23hvf7v2denddplpuffvpq'),
('admin@bookmart.com', 'qujtv92d3ne6o648fbgi25ekba'),
('admin@bookmart.com', 's25t2lf9e424eqp47uvh6v8607'),
('admin@bookmart.com', 'he836ie3nbh00vaulpr9qucln8'),
('admin@bookmart.com', '49b7hekgnh94sih4fkdl393p97'),
('staff123@gmail.com', '194lg2gfjsq00ji8ju0507sb62'),
('admin@bookmart.com', '247poin2hu9s8ab9lnr1iu6c0l'),
('customer@gmail.com', 'hqnopicov14btri7vd3aqb39g8'),
('admin@bookmart.com', 's697ju59cpkv108ooelol1ci85');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staff`
--

CREATE TABLE `tbl_staff` (
  `Staff_id` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `S_phno` decimal(10,0) NOT NULL,
  `S_fname` varchar(30) NOT NULL,
  `S_lname` varchar(30) NOT NULL,
  `S_housename` varchar(30) NOT NULL,
  `S_city` varchar(30) NOT NULL,
  `S_district` varchar(30) NOT NULL,
  `S_pin` decimal(6,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_staff`
--

INSERT INTO `tbl_staff` (`Staff_id`, `Username`, `S_phno`, `S_fname`, `S_lname`, `S_housename`, `S_city`, `S_district`, `S_pin`) VALUES
(94, 'staff@gmail.com', '9207248664', 'Alvin', 'Lal', 'alvin villa', 'Puthencruze', 'Ernakulam', '682310'),
(95, 'staff2@gmail.com', '9656435678', 'Mathew', 'Wilson', 'mathew Villa', 'Kochi', 'Ernakulam', '682311'),
(96, 'staff3@gmail.com', '7846356746', 'Chris', 'George', 'chris villa', 'Trivandrum', 'Trivandrum', '682312'),
(97, 'staff4@gmail.com', '4356253432', 'Micheal', 'Scott', 'scott villa', 'Scranton', 'Pensylvania', '234534'),
(98, 'staff5@gmail.com', '4342244434', 'Jim', 'Jane', 'jim villa', 'NewYork City', 'NewYork', '324555'),
(99, 'staff6@gmail.com', '3537622232', 'Toby', 'Kane', 'kane villa', 'Arkansas', 'Kansas', '234242');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subcategory`
--

CREATE TABLE `tbl_subcategory` (
  `SubCat_Id` int(11) NOT NULL,
  `SubCat_name` varchar(30) DEFAULT NULL,
  `Cat_id` int(11) NOT NULL,
  `SubCat_status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_subcategory`
--

INSERT INTO `tbl_subcategory` (`SubCat_Id`, `SubCat_name`, `Cat_id`, `SubCat_status`) VALUES
(1, 'Art History', 1, 'active'),
(2, 'Calligraphy', 1, 'active'),
(3, 'Drawing', 1, 'active'),
(4, 'Fashion', 1, 'active'),
(5, 'Films', 1, 'active'),
(6, 'Ethnic & Cultural', 2, 'active'),
(7, 'Historical', 2, 'active'),
(8, 'Leaders & Notable people', 2, 'active'),
(9, 'Scientists', 2, 'active'),
(10, 'Artists', 2, 'active'),
(11, 'DC Comics', 3, 'active'),
(12, 'Marvel Comics', 3, 'active'),
(13, 'Fantasy', 3, 'active'),
(14, 'Manga', 3, 'active'),
(15, 'Sci-fi', 3, 'active'),
(16, 'Question Banks', 4, 'active'),
(17, 'Encyclopedia', 4, 'active'),
(18, 'Study Guides', 4, 'active'),
(19, 'Law Practise', 4, 'active'),
(20, 'Textbooks', 4, 'active'),
(21, 'Romance', 5, 'active'),
(22, 'Humour', 5, 'active'),
(23, 'Fictional', 5, 'active'),
(24, 'Mystery', 5, 'active'),
(25, 'Thrillers', 5, 'active'),
(26, 'African', 6, 'active'),
(27, 'Ancient', 6, 'active'),
(28, 'Asian', 6, 'active'),
(29, 'World War', 6, 'active'),
(30, 'Indian', 6, 'active'),
(31, 'Meditation', 7, 'active'),
(32, 'Yoga', 7, 'active'),
(33, 'Mental Well Being', 7, 'active'),
(34, 'Habits', 7, 'active'),
(35, 'Anger Management', 7, 'active'),
(36, 'Electronics', 8, 'active'),
(37, 'Programming', 8, 'active'),
(38, 'Databases', 8, 'active'),
(39, 'Tech Industry', 8, 'active'),
(40, 'Software Development', 8, 'active'),
(41, 'Antiques & Crafts', 9, 'active'),
(42, 'Clay', 9, 'active'),
(43, 'Collecting', 9, 'active'),
(44, 'Fashion', 9, 'active'),
(45, 'Jewellery', 9, 'active'),
(46, 'Architecture', 10, 'active'),
(47, 'Flowers', 10, 'active'),
(48, 'Fruits', 10, 'active'),
(49, 'Home decorating', 10, 'active'),
(50, 'Interior designing', 10, 'active'),
(51, 'Stock Market', 11, 'active'),
(52, 'Mutual Funds', 11, 'active'),
(53, 'Trading', 11, 'active'),
(54, 'Investment banking', 11, 'active'),
(55, 'Asset Management', 11, 'active'),
(56, 'Scammers', 2, 'active'),
(57, 'Kids Comics', 3, 'active');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vendor`
--

CREATE TABLE `tbl_vendor` (
  `V_id` int(11) NOT NULL,
  `V_added_by` varchar(50) NOT NULL,
  `V_phno` decimal(10,0) NOT NULL,
  `V_email` varchar(50) NOT NULL,
  `V_name` varchar(60) NOT NULL,
  `V_city` varchar(30) NOT NULL,
  `V_district` varchar(30) NOT NULL,
  `V_pin` varchar(6) NOT NULL,
  `V_status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_vendor`
--

INSERT INTO `tbl_vendor` (`V_id`, `V_added_by`, `V_phno`, `V_email`, `V_name`, `V_city`, `V_district`, `V_pin`, `V_status`) VALUES
(29, 'admin@bookmart.com', '8236108291', 'kumilyagencies@gmail.com', 'Kumily agencies', 'Kumily', 'Idukki', '688812', 'active'),
(30, 'admin@bookmart.com', '7823612311', 'timesretailers@gmail.com', 'Times retailers', 'Kochi', 'Ernakulam', '682310', 'active'),
(31, 'admin@bookmart.com', '9235672419', 'newkeralabussiness@gmail.com', 'New Kerala pvt ltd', 'Cherthala', 'Alappuzha', '688527', 'active'),
(32, 'admin@bookmart.com', '9605473327', 'familyvendors@gmail.com', 'Family Vendors', 'Kochi', 'Ernakulam', '682310', 'active'),
(33, 'staff@gmail.com', '7838338333', 'happy@wholesales.com', 'Happy Wholesales', 'Trivandrum', 'Trivandrum', '688000', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD KEY `Username` (`Username`);

--
-- Indexes for table `tbl_author`
--
ALTER TABLE `tbl_author`
  ADD PRIMARY KEY (`Author_id`);

--
-- Indexes for table `tbl_card`
--
ALTER TABLE `tbl_card`
  ADD PRIMARY KEY (`Card_id`),
  ADD KEY `Username` (`Username`);

--
-- Indexes for table `tbl_cart_child`
--
ALTER TABLE `tbl_cart_child`
  ADD PRIMARY KEY (`Cart_child_id`),
  ADD KEY `Cart_master_id` (`Cart_master_id`),
  ADD KEY `Item_id` (`Item_id`);

--
-- Indexes for table `tbl_cart_master`
--
ALTER TABLE `tbl_cart_master`
  ADD PRIMARY KEY (`Cart_master_id`),
  ADD KEY `Username` (`Username`);

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`Cat_id`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`Cust_id`),
  ADD KEY `Username` (`Username`);

--
-- Indexes for table `tbl_item`
--
ALTER TABLE `tbl_item`
  ADD PRIMARY KEY (`Item_id`),
  ADD UNIQUE KEY `I_cover_image` (`I_cover_image`),
  ADD UNIQUE KEY `I_isbn` (`I_isbn`),
  ADD KEY `Author_id` (`Author_id`),
  ADD KEY `Publisher_id` (`Publisher_id`),
  ADD KEY `SubCat_id` (`SubCat_id`);

--
-- Indexes for table `tbl_login`
--
ALTER TABLE `tbl_login`
  ADD PRIMARY KEY (`Username`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`Order_id`),
  ADD KEY `Cart_master_id` (`Cart_master_id`);

--
-- Indexes for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  ADD PRIMARY KEY (`Payment_id`),
  ADD KEY `Card_id` (`Card_id`),
  ADD KEY `Order_id` (`Order_id`);

--
-- Indexes for table `tbl_publisher`
--
ALTER TABLE `tbl_publisher`
  ADD PRIMARY KEY (`Publisher_id`);

--
-- Indexes for table `tbl_purchase_child`
--
ALTER TABLE `tbl_purchase_child`
  ADD PRIMARY KEY (`Purchase_child_id`),
  ADD KEY `Purchase_master_id` (`Purchase_master_id`),
  ADD KEY `Item_id` (`Item_id`);

--
-- Indexes for table `tbl_purchase_master`
--
ALTER TABLE `tbl_purchase_master`
  ADD PRIMARY KEY (`Purchase_master_id`),
  ADD KEY `Vendor_id` (`Vendor_id`),
  ADD KEY `Purchased_by` (`Purchased_by`);

--
-- Indexes for table `tbl_review`
--
ALTER TABLE `tbl_review`
  ADD PRIMARY KEY (`Review_id`),
  ADD KEY `Item_id` (`Item_id`),
  ADD KEY `Username` (`Username`);

--
-- Indexes for table `tbl_session`
--
ALTER TABLE `tbl_session`
  ADD KEY `Username` (`Username`);

--
-- Indexes for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD PRIMARY KEY (`Staff_id`),
  ADD KEY `Username` (`Username`);

--
-- Indexes for table `tbl_subcategory`
--
ALTER TABLE `tbl_subcategory`
  ADD PRIMARY KEY (`SubCat_Id`),
  ADD KEY `Cat_id` (`Cat_id`);

--
-- Indexes for table `tbl_vendor`
--
ALTER TABLE `tbl_vendor`
  ADD PRIMARY KEY (`V_id`),
  ADD KEY `V_added_by` (`V_added_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_author`
--
ALTER TABLE `tbl_author`
  MODIFY `Author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `tbl_card`
--
ALTER TABLE `tbl_card`
  MODIFY `Card_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tbl_cart_child`
--
ALTER TABLE `tbl_cart_child`
  MODIFY `Cart_child_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=226;

--
-- AUTO_INCREMENT for table `tbl_cart_master`
--
ALTER TABLE `tbl_cart_master`
  MODIFY `Cart_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `Cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `Cust_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tbl_item`
--
ALTER TABLE `tbl_item`
  MODIFY `Item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `Order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  MODIFY `Payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `tbl_publisher`
--
ALTER TABLE `tbl_publisher`
  MODIFY `Publisher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tbl_purchase_child`
--
ALTER TABLE `tbl_purchase_child`
  MODIFY `Purchase_child_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `tbl_purchase_master`
--
ALTER TABLE `tbl_purchase_master`
  MODIFY `Purchase_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `tbl_review`
--
ALTER TABLE `tbl_review`
  MODIFY `Review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  MODIFY `Staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `tbl_subcategory`
--
ALTER TABLE `tbl_subcategory`
  MODIFY `SubCat_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tbl_vendor`
--
ALTER TABLE `tbl_vendor`
  MODIFY `V_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD CONSTRAINT `tbl_admin_ibfk_1` FOREIGN KEY (`Username`) REFERENCES `tbl_login` (`Username`);

--
-- Constraints for table `tbl_card`
--
ALTER TABLE `tbl_card`
  ADD CONSTRAINT `tbl_card_ibfk_1` FOREIGN KEY (`Username`) REFERENCES `tbl_login` (`Username`);

--
-- Constraints for table `tbl_cart_child`
--
ALTER TABLE `tbl_cart_child`
  ADD CONSTRAINT `tbl_Cart_child_ibfk_1` FOREIGN KEY (`Cart_master_id`) REFERENCES `tbl_cart_master` (`Cart_master_id`),
  ADD CONSTRAINT `tbl_Cart_child_ibfk_2` FOREIGN KEY (`Item_id`) REFERENCES `tbl_item` (`Item_id`);

--
-- Constraints for table `tbl_cart_master`
--
ALTER TABLE `tbl_cart_master`
  ADD CONSTRAINT `tbl_Cart_master_ibfk_1` FOREIGN KEY (`Username`) REFERENCES `tbl_login` (`Username`);

--
-- Constraints for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD CONSTRAINT `tbl_Customer_ibfk_1` FOREIGN KEY (`Username`) REFERENCES `tbl_login` (`Username`);

--
-- Constraints for table `tbl_item`
--
ALTER TABLE `tbl_item`
  ADD CONSTRAINT `tbl_Item_ibfk_1` FOREIGN KEY (`Author_id`) REFERENCES `tbl_author` (`Author_id`),
  ADD CONSTRAINT `tbl_Item_ibfk_2` FOREIGN KEY (`Publisher_id`) REFERENCES `tbl_publisher` (`Publisher_id`),
  ADD CONSTRAINT `tbl_Item_ibfk_3` FOREIGN KEY (`SubCat_id`) REFERENCES `tbl_subcategory` (`SubCat_Id`);

--
-- Constraints for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD CONSTRAINT `tbl_order_ibfk_1` FOREIGN KEY (`Cart_master_id`) REFERENCES `tbl_cart_master` (`Cart_master_id`);

--
-- Constraints for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  ADD CONSTRAINT `tbl_payment_ibfk_1` FOREIGN KEY (`Card_id`) REFERENCES `tbl_card` (`Card_id`),
  ADD CONSTRAINT `tbl_payment_ibfk_2` FOREIGN KEY (`Order_id`) REFERENCES `tbl_order` (`Order_id`);

--
-- Constraints for table `tbl_purchase_child`
--
ALTER TABLE `tbl_purchase_child`
  ADD CONSTRAINT `tbl_Purchase_child_ibfk_1` FOREIGN KEY (`Purchase_master_id`) REFERENCES `tbl_purchase_master` (`Purchase_master_id`),
  ADD CONSTRAINT `tbl_Purchase_child_ibfk_2` FOREIGN KEY (`Item_id`) REFERENCES `tbl_item` (`Item_id`);

--
-- Constraints for table `tbl_purchase_master`
--
ALTER TABLE `tbl_purchase_master`
  ADD CONSTRAINT `tbl_Purchase_master_ibfk_1` FOREIGN KEY (`Vendor_id`) REFERENCES `tbl_vendor` (`V_id`),
  ADD CONSTRAINT `tbl_Purchase_master_ibfk_2` FOREIGN KEY (`Purchased_by`) REFERENCES `tbl_login` (`Username`);

--
-- Constraints for table `tbl_review`
--
ALTER TABLE `tbl_review`
  ADD CONSTRAINT `tbl_review_ibfk_1` FOREIGN KEY (`Item_id`) REFERENCES `tbl_item` (`Item_id`),
  ADD CONSTRAINT `tbl_review_ibfk_2` FOREIGN KEY (`Username`) REFERENCES `tbl_login` (`Username`);

--
-- Constraints for table `tbl_session`
--
ALTER TABLE `tbl_session`
  ADD CONSTRAINT `tbl_Session_ibfk_1` FOREIGN KEY (`Username`) REFERENCES `tbl_login` (`Username`);

--
-- Constraints for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  ADD CONSTRAINT `tbl_Staff_ibfk_1` FOREIGN KEY (`Username`) REFERENCES `tbl_login` (`Username`);

--
-- Constraints for table `tbl_subcategory`
--
ALTER TABLE `tbl_subcategory`
  ADD CONSTRAINT `tbl_subcategory_ibfk_1` FOREIGN KEY (`Cat_id`) REFERENCES `tbl_category` (`Cat_id`);

--
-- Constraints for table `tbl_vendor`
--
ALTER TABLE `tbl_vendor`
  ADD CONSTRAINT `tbl_Vendor_ibfk_1` FOREIGN KEY (`V_added_by`) REFERENCES `tbl_login` (`Username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
