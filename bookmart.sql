-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2021 at 05:45 PM
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
(13, 'JK Rowling', 'active'),
(14, 'Agatha Christie', 'active'),
(15, 'Jane Austen', 'active'),
(16, 'Paul kalanithi', 'active'),
(17, 'Arthur Conan Doyle', 'active'),
(18, 'Paulo Coelho', 'active'),
(19, 'Hector Garcia', 'active'),
(20, 'Micheal Jackson', 'active'),
(21, 'Dr APJ Abdul Kalam', 'active'),
(22, 'John Carreyrou', 'active'),
(23, 'Racheal Lippincott', 'active'),
(24, 'Dan Brown', 'active'),
(25, 'Jeff Kinney', 'active'),
(26, 'Vaikom Muhammad basheer', 'active'),
(27, 'Chetan Bhagat', 'active'),
(28, 'Walter Isaacson', 'active'),
(29, 'Raja ravi varma', 'active'),
(30, 'Robin Sharma', 'active');

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
(16, 'customer@gmail.com', '1234567812345678', '123', 'alvin', '03/2025', 'active'),
(17, 'customer@gmail.com', '1234567891234567', '123', 'alan', '03/2026', 'active'),
(18, 'customer2@gmail.com', '1234567891234567', '587', 'alvin lal', '03/2040', 'active'),
(19, 'customer3@gmail.com', '1234567891234567', '458', 'alex', '05/2030', 'active'),
(20, 'customer@gmail.com', '1234567812345674', '582', 'alvinto', '03/2026', 'deleted'),
(21, 'customer2@gmail.com', '1234567891234562', '456', 'alvin', '03/2025', 'active'),
(22, 'customer4@gmail.com', '1234567891222213', '345', 'afdf', '03/2030', 'active'),
(23, 'customer4@gmail.com', '1234567833333333', '123', 'gfd', '03/2040', 'active'),
(24, 'customer77@gmail.com', '1234567899999999', '123', 'hfr', '03/2024', 'active');

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
(59, 12, 32, 2, '568.00', '2021-10-13'),
(60, 12, 14, 1, '327.00', '2021-10-13'),
(61, 12, 26, 2, '560.00', '2021-10-13'),
(62, 12, 15, 2, '396.00', '2021-10-13'),
(63, 12, 22, 2, '494.00', '2021-10-13'),
(64, 13, 27, 2, '592.00', '2021-10-13'),
(65, 13, 17, 1, '383.00', '2021-10-13'),
(66, 13, 19, 2, '392.00', '2021-10-13'),
(67, 13, 28, 1, '135.00', '2021-10-13'),
(72, 15, 27, 2, '592.00', '2021-10-13'),
(73, 15, 17, 1, '383.00', '2021-10-13'),
(74, 15, 22, 2, '494.00', '2021-10-13'),
(75, 15, 26, 3, '840.00', '2021-10-13'),
(76, 15, 30, 2, '774.00', '2021-10-13'),
(77, 17, 19, 1, '196.00', '2021-10-13'),
(78, 17, 26, 1, '280.00', '2021-10-13'),
(79, 17, 31, 1, '414.00', '2021-10-13'),
(80, 17, 25, 1, '586.00', '2021-10-13'),
(83, 14, 28, 1, '135.00', '2021-10-13'),
(84, 14, 15, 1, '198.00', '2021-10-13'),
(85, 18, 17, 1, '383.00', '2021-10-13'),
(86, 19, 17, 5, '1915.00', '2021-10-13'),
(87, 20, 28, 2, '270.00', '2021-10-13'),
(88, 16, 28, 5, '675.00', '2021-10-13'),
(89, 20, 27, 2, '592.00', '2021-11-23'),
(90, 21, 28, 1, '135.00', '2021-11-24'),
(91, 21, 30, 1, '387.00', '2021-11-24'),
(93, 22, 26, 1, '280.00', '2021-11-25'),
(94, 22, 24, 1, '308.00', '2021-11-25'),
(95, 22, 29, 1, '163.00', '2021-11-25'),
(96, 23, 24, 1, '308.00', '2021-11-25'),
(97, 24, 19, 1, '196.00', '2021-11-26'),
(98, 16, 19, 1, '196.00', '2021-11-26'),
(99, 26, 27, 1, '296.00', '2021-11-26'),
(100, 27, 19, 1, '196.00', '2021-11-26'),
(101, 27, 31, 1, '414.00', '2021-11-26'),
(102, 28, 15, 1, '198.00', '2021-11-26'),
(103, 29, 22, 1, '247.00', '2021-11-26'),
(104, 31, 15, 2, '396.00', '2021-11-27'),
(105, 32, 19, 1, '196.00', '2021-11-27'),
(106, 33, 25, 1, '586.00', '2021-11-27'),
(107, 30, 25, 1, '586.00', '2021-11-27'),
(108, 25, 25, 1, '586.00', '2021-11-27'),
(109, 36, 24, 1, '308.00', '2021-11-29'),
(110, 37, 29, 2, '326.00', '2021-11-29'),
(111, 37, 15, 2, '396.00', '2021-11-29'),
(112, 37, 14, 1, '327.00', '2021-11-29'),
(113, 37, 31, 1, '414.00', '2021-11-29'),
(114, 39, 25, 2, '1172.00', '2021-11-29'),
(116, 38, 18, 12, '2388.00', '2021-11-30'),
(120, 35, 34, 2, '302.00', '2021-11-30'),
(121, 35, 19, 1, '196.00', '2021-11-30'),
(122, 35, 20, 1, '318.00', '2021-11-30'),
(125, 42, 16, 4, '396.00', '2021-11-30'),
(130, 41, 28, 4, '540.00', '2021-12-01'),
(132, 43, 16, 4, '396.00', '2021-12-01'),
(133, 44, 16, 10, '990.00', '2021-12-01'),
(134, 44, 28, 5, '675.00', '2021-12-01'),
(135, 44, 14, 5, '1635.00', '2021-12-01'),
(138, 45, 16, 5, '495.00', '2021-12-01'),
(139, 45, 28, 8, '1080.00', '2021-12-01'),
(140, 45, 19, 8, '1568.00', '2021-12-01'),
(141, 45, 15, 12, '2376.00', '2021-12-01'),
(142, 45, 14, 4, '1308.00', '2021-12-01'),
(143, 46, 16, 1, '99.00', '2021-12-01'),
(145, 47, 16, 4, '396.00', '2021-12-01'),
(148, 48, 32, 3, '852.00', '2021-12-01'),
(149, 49, 19, 2, '392.00', '2021-12-01'),
(150, 41, 23, 2, '560.00', '2021-12-02'),
(151, 41, 25, 3, '1758.00', '2021-12-02');

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
(12, 'customer@gmail.com', 'payed', '2345.00'),
(13, 'customer@gmail.com', 'payed', '1502.00'),
(14, 'customer@gmail.com', 'payed', '333.00'),
(15, 'customer2@gmail.com', 'payed', '3083.00'),
(16, 'customer2@gmail.com', 'payed', '871.00'),
(17, 'customer3@gmail.com', 'created', '1476.00'),
(18, 'customer@gmail.com', 'payed', '383.00'),
(19, 'customer@gmail.com', 'payed', '1915.00'),
(20, 'customer@gmail.com', 'payed', '862.00'),
(21, 'customer@gmail.com', 'payed', '522.00'),
(22, 'customer@gmail.com', 'payed', '751.00'),
(23, 'customer@gmail.com', 'payed', '308.00'),
(24, 'customer@gmail.com', 'payed', '196.00'),
(25, 'customer@gmail.com', 'payed', '586.00'),
(26, 'customer2@gmail.com', 'payed', '296.00'),
(27, 'customer2@gmail.com', 'payed', '610.00'),
(28, 'customer2@gmail.com', 'payed', '198.00'),
(29, 'customer2@gmail.com', 'payed', '247.00'),
(30, 'customer2@gmail.com', 'payed', '586.00'),
(31, 'customer4@gmail.com', 'payed', '396.00'),
(32, 'customer4@gmail.com', 'payed', '196.00'),
(33, 'customer4@gmail.com', 'payed', '586.00'),
(34, 'customer4@gmail.com', 'created', '0.00'),
(35, 'customer2@gmail.com', 'payed', '816.00'),
(36, 'customer@gmail.com', 'payed', '308.00'),
(37, 'customer@gmail.com', 'payed', '1463.00'),
(38, 'customer@gmail.com', 'payed', '2388.00'),
(39, 'customer77@gmail.com', 'payed', '1172.00'),
(40, 'customer77@gmail.com', 'created', '0.00'),
(41, 'customer@gmail.com', 'created', '2858.00'),
(42, 'customer2@gmail.com', 'payed', '396.00'),
(43, 'customer2@gmail.com', 'payed', '396.00'),
(44, 'customer2@gmail.com', 'payed', '3300.00'),
(45, 'customer2@gmail.com', 'payed', '6827.00'),
(46, 'customer2@gmail.com', 'payed', '99.00'),
(47, 'customer2@gmail.com', 'payed', '396.00'),
(48, 'customer2@gmail.com', 'payed', '852.00'),
(49, 'customer2@gmail.com', 'payed', '392.00'),
(50, 'customer2@gmail.com', 'created', '0.00'),
(51, 'customer99@gmail.com', 'created', '0.00'),
(52, 'customerdate@gmail.com', 'created', '0.00');

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
(1, 'art & musics', 'active'),
(2, 'Biographies', 'active'),
(3, 'Comics', 'active'),
(4, 'Education', 'active'),
(5, 'Novels', 'active'),
(6, 'History', 'active'),
(7, 'Self-help', 'active'),
(8, 'Technology', 'active'),
(9, 'Hobbies & crafts', 'active'),
(10, 'Home & garden', 'active'),
(13, 'Japanese', 'active'),
(14, 'Short stories', 'active'),
(15, 'Scientific', 'active'),
(16, 'Based on true events', 'active'),
(17, 'Greek', 'active'),
(18, 'drama', 'inactive');

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
(16, 'customer@gmail.com', '9207248664', 'alvin', 'lal', 'kutekudiyil', 'puthecruze', 'ernakulam', '682319'),
(17, 'customer2@gmail.com', '9207248664', 'alan', 'lal', 'housename', 'city', 'district', '682310'),
(18, 'customer3@gmail.com', '9207248664', 'alex', 'lal', 'house', 'city', 'dis', '865623'),
(19, 'customer4@gmail.com', '9207248664', 'testers', 'tester', 'teserthouse', 'testercity', 'testerdistrict', '682310'),
(20, 'customer77@gmail.com', '9207248664', 'adfs', 'lkjl', 'ghkh', 'khnjlkh', 'olkhjlj', '856523'),
(21, 'customer99@gmail.com', '9207248664', 'harry', 'potter', 'hogwarts', 'city', 'district', '666666');

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
  `I_price` decimal(10,2) NOT NULL,
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
(14, 13, 10, 28, 'c50531daad76881d85db.jpg', '9780439136358', 'Harry potter and the prisoner of azkaban', 'Harry Potter and the Prisoner of Azkaban is a fantasy novel written by British author J. K. Rowling and is the third in the Harry Potter series. The book follows Harry Potter, a young wizard, in his third year at Hogwarts School of Witchcraft and Wizardry.', '327.00', 19, 480, 'English', 'active', '2021-09-16'),
(15, 14, 11, 57, 'e368dae49d2cd1a48910.jpg', '9780008123208', 'And then there were none', '\"And Then There Were None\" is a dramatic adaptation of the best-selling crime novel by Agatha Christie. The story follows 10 strangers who receive an unusual invitation to a solitary mansion based remotely off Britain\'s Devon Coast. Among the guests is an unstable doctor, an anxious businessman, an irresponsible playboy, and a governess with a secret. Cut off from the outside world, the group arrives at its destination, only to find that darkness awaits them. As people start to mysteriously die, the members of the group realize there is a killer among them.', '198.00', 27, 256, 'English', 'active', '2021-09-16'),
(16, 15, 12, 26, 'e344a9b1b28c4a7b39db.jpg', '9788172344504', 'Pride and Prejudice', 'When Elizabeth Bennet meets Fitzwilliam Darcy for the first time at a ball, she writes him off as an arrogant and obnoxious man. He not only acts like an insufferable snob, but she also overhears him rejecting the very idea of asking her for a dance!', '99.00', 0, 328, 'English', 'active', '2021-09-17'),
(17, 16, 13, 77, '42d433538907971bded5.jpg', '9781847923677', 'When breath becomes air', 'When Breath Becomes Air is a non-fiction autobiographical book written by American neurosurgeon Paul Kalanithi. It is a memoir about his life and illness, battling stage IV metastatic lung cancer. It was posthumously published by Random House on January 12, 2016.', '383.00', 5, 256, 'English', 'active', '2021-09-18'),
(18, 17, 14, 59, 'dc845c6da02fe9c69bef.jpg', '9780140439083', 'Sherlock holmes : A study in scarlet', 'A Study in Scarlet is an 1887 detective novel written by Arthur Conan Doyle. The story marks the first appearance of Sherlock Holmes and Dr. Watson, who would become the most famous detective duo in popular fiction.', '199.00', 0, 176, 'English', 'active', '2021-09-20'),
(19, 18, 11, 28, '8338422f2eb3d5f61d5b.jpg', '9784550069960', 'The Alchemist', 'Paulo Coelho\'s enchanting novel has inspired a devoted following around the world. This story, dazzling in its powerful simplicity and inspiring wisdom, is about an Andalusian shepherd boy named Santiago who travels from his homeland in Spain to the Egyptian desert in search of a treasure buried in the Pyramids.', '196.00', 12, 172, 'English', 'active', '2021-09-15'),
(20, 19, 13, 70, 'a50b8ea28ac4c3926a40.jpg', '9781786330895', 'Ikigai : The japanese secret to a long and happy l', 'Los Angeles Times bestseller • More than 1.5 million copies sold“If hygge is the art of doing nothing, ikigai is the art of doing something—and doing it with supreme focus and joy.”', '318.00', 7, 208, 'English', 'active', '2021-09-16'),
(21, 20, 15, 15, 'b7609e08477d85a449d0.jpg', '9780099547952', 'Moonwalk', 'Moonwalk is a 1988 autobiography written by American recording artist Michael Jackson. It chronicles his humble beginnings in the Midwest, his early days with the Jackson 5, and his unprecedented solo success. Giving unrivalled insight into the King of Pop\'s life, it details his songwriting process for hits like Beat It, Rock With You, Billie Jean, and We Are the World;', '550.00', 15, 320, 'English', 'active', '2021-09-16'),
(22, 21, 16, 13, '9d26715315f5dda3f022.jpg', '9788173711466', 'Wings of fire', 'Every common man who by his sheer grit and hard work achieves success should share his story with the rest for they may find inspiration and strength to go on, in his story. The \'Wings of Fire\' is one such autobiography by visionary scientist Dr. APJ Abdul Kalam, who from very humble beginnings rose to be the President of India. The book is full of insights, personal moments and life experiences of Dr. Kalam. It gives us an understanding on his journey of success.', '247.00', 27, 180, 'English', 'active', '2021-09-16'),
(23, 22, 17, 75, 'd7a755adc31c160ed0fd.jpg', '9781524731656', 'Bad Blood: Secrets and Lies in a Silicon Valley St', 'Bad Blood: Secrets and Lies in a Silicon Valley Startup is a nonfiction book by journalist John Carreyrou, released May 21, 2018. It covers the rise and fall of Theranos, the multibillion-dollar biotech startup headed by Elizabeth Holmes.', '280.00', 20, 354, 'English', 'active', '2021-09-16'),
(24, 23, 18, 26, '9c614d31f20c37da7af8.jpg', '9781471185090', 'Five Feet Apart', 'In this moving story two teens fall in love with just one minor complication—they can’t get within five feet of each other without risking their lives.', '308.00', 66, 288, 'English', 'active', '2021-09-16'),
(25, 13, 10, 28, '1702384042ebedf0861e.jpg', '9781408894743', 'Harry Potter And The Deathly Hallows', 'Harry Potter is preparing to leave the Dursleys and Privet Drive for the last time. But the future that awaits him is full of danger, not only for him, but for anyone close to him - and Harry has already lost so much. Only by destroying Voldemort\'s remaining Horcruxes can Harry free himself and overcome the Dark Lord\'s forces of evil.', '586.00', 32, 640, 'English', 'active', '2021-09-16'),
(26, 24, 15, 28, 'c31b3ee01467e55a5a88.jpg', '9780552161275', 'The Davinci Code', 'A man is murdered in the world’s most famous museum.\r\nAround his body is a ring of codes, drawn in blood. He died to protect a secret which Robert Langdon must uncover. It will be a race against time to decipher this final message. Can he get there before the killers do?', '280.00', 5, 592, 'English', 'active', '2021-09-16'),
(27, 25, 19, 76, '4a95a8e8ee1e69e85588.jpg', '9780141324913', 'Diary of a Wimpy kid : Rodirick Rules', 'Diary of a Wimpy Kid: Rodrick Rules is a sequel to the colossal hit \'Diary of a Wimpy Kid’. The story rotates around an 8th grader Gregory Heffley who is facing some problems which usually is not faced by a mid-school child. The new academic year has just started at school. Greg, in his journal, initiates by focusing on how disastrous his summer vacations went. Greg is a kid, who is considered as a recluse by his peers due to the “cheese touch”', '296.00', 8, 224, 'English', 'active', '2021-09-16'),
(28, 26, 20, 27, '9926412743d1cb3204db.jpg', '9788171302093', 'Paathumayude Aadu', 'Pathummayude Aadu is a humorous novel by Vaikom Muhammad Basheer. The characters of the novel are members of his family and the action takes place at his home in Thalayolaparambu. The goat in the story belongs to his sister Pathumma. Basheer begins the novel with an alternative title for the book, Pennungalude Buddhi.', '135.00', 19, 124, 'English', 'active', '2021-09-16'),
(29, 27, 21, 78, 'cd3e37b1274bdae1552d.webp', '9788129135490', 'Five Point Someone', 'Five Point Someone: What not to do at IIT is a 2004 novel written by Indian author Chetan Bhagat. The book sold more than a million copies worldwide. The films 3 Idiots and Nanban are based on the book.', '163.00', 39, 267, 'English', 'active', '2021-09-16'),
(30, 28, 22, 72, '72c75ec2ec482b917efd.jpg', '9780349140438', 'Steve jobs', 'Steve Jobs is the authorized self-titled biography of American business magnate and Apple Inc. founder Steve Jobs. The book was written at the request of Jobs by Walter Isaacson, a former executive at CNN and TIME who has written best-selling biographies of Benjamin Franklin and Albert Einstein.', '387.00', 4, 592, 'English', 'active', '2021-09-23'),
(31, 13, 10, 28, '005c3e22487715ffb410.jpg', '9781408855706', 'Harry Potter and the Half Blood Prince', 'When Dumbledore arrives at Privet Drive one summer night to collect Harry Potter, his wand hand is blackened and shrivelled, but he does not reveal why. Secrets and suspicion are spreading through the wizarding world, and Hogwarts itself is not safe. Harry is convinced that Malfoy bears the Dark Mark: there is a Death Eater amongst them.', '414.00', 10, 560, 'English', 'active', '2021-10-05'),
(32, 13, 10, 28, '20e1c0a792a002bb025e.jpg', '1408855666', 'Harry Potter and the Chamber of Secrets', 'Harry Potter\'s summer has included the worst birthday ever, doomy warnings from a house-elf called Dobby, and rescue from the Dursleys by his friend Ron Weasley in a magical flying car! Back at Hogwarts School of Witchcraft and Wizardry for his second year, Harry hears strange whispers echo through empty corridors - and then the attacks start. Students are found as though turned to stone . Dobby\'s sinister predictions seem to be coming true.', '284.00', 3, 384, 'English', 'active', '2021-10-05'),
(34, 30, 11, 80, '2e48274004df1ace8376.jpg', '9788179921623', 'The Monk Who Sold His Ferrari', 'A renowned inspirational fiction, The Monk Who Sold His Ferrari is a revealing story that offers the readers a simple yet profound way to live life. The plot of this story revolves around Julian Mantle, a lawyer who has made his fortune and name in the profession. A sudden heart-attack creates havoc in the successful lawyer’s life.', '151.00', 9, 198, 'English', 'active', '2021-10-11'),
(35, 13, 10, 28, '942a0fe68f6606889e0b.jpg', '9781408855690', 'Harry Potter and the Order of the Phoenix', 'Dark times have come to Hogwarts. After the Dementors\' attack on his cousin Dudley, Harry Potter knows that Voldemort will stop at nothing to find him. There are many who deny the Dark Lord\'s return, but Harry is not alone: a secret order gathers at Grimmauld Place to fight against the Dark forces. Harry must allow Professor Snape to teach him how to protect himself from Voldemort\'s savage assaults on his mind. But they are growing stronger by the day and Harry is running out of time.', '200.00', 0, 400, 'English', 'active', '2021-10-13'),
(36, 13, 11, 28, '0fef5fdac8034c07e089.jpg', '1234567899', 'harry potter and the cursed child', 'item descriptionsafdsdfasdfjasdf dfjalskdfjalsfd dlasjdflasjfasdfsfsdf', '120.00', 0, 200, 'English', 'active', '2021-10-13'),
(37, 14, 10, 59, '0abf4130d31c9adafe51.jpg', '9780007527526', 'The Murder of Roger Ackroyd', 'Agatha Christie\'s most daring crime mystery - an early and particularly brilliant outing of Hercule Poirot, The Murder of Roger Ackroyd, with its legendary twist, changed the detective fiction genre for ever.', '150.00', 0, 336, 'English', 'active', '2021-12-03');

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
('admin@bookmart.com', 'admin', 'active', '$2y$10$jYTJ8OMTs2kFwpfXjyy7RuNMTSV7Ghl9T64HN8JhlWBjtUmMN9EKS', '2021-12-04'),
('ahdsfgs@hsdff.com', 'staff', 'active', '$2y$10$oowLUimW4r5yj4TaQqc65er8rX2jy2cnvlavas.a4SrtMLk/VtA6C', '2021-10-07'),
('ahjgsdlkgd@gsdkhg.com', 'staff', 'active', '$2y$10$/CZOTsWB5svI44U1.S9o/u3RnLzCDvBZgEA70QI3xbfOeArENdH7m', '2021-09-22'),
('ahnfdgsjf@adg.com', 'staff', 'active', '$2y$10$RKAWfelFBq9fNiT3l.Usde69WYdlfoGCxN41hXBvDQYo6gMBu/FM6', '2021-11-05'),
('asdhhreh@dah.com', 'staff', 'active', '$2y$10$zf0.kIUIesPKDrS0Ik3e3.r.7doOCYkjCygXCUalLBz.zeKDhEeHy', '2021-11-18'),
('asfdas@asdf.com', 'staff', 'active', '$2y$10$Q4L2iSJTnw3HbwOrZ9/MZ.ekGyufynmj.QgNbj6YhJNPTu3M4.klC', '2021-11-19'),
('customer2@gmail.com', 'customer', 'active', '$2y$10$ftE03tecnAiPHve9Ok7j0O1DUKnPNEE4ShsCvNL6LdeYACDEUm7Qy', '2021-12-01'),
('customer3@gmail.com', 'customer', 'active', '$2y$10$1UmNaxyXyqojTl3ZDPGs8.eKxy6du5xDFD2Os1tSrelEILzXFrNJ6', '2021-11-29'),
('customer4@gmail.com', 'customer', 'active', '$2y$10$QqDfpMRWwGLnBzbHqLJ37.8ZpQ5wfQ.lXms0N39t0X68PJ/a9PgU2', '2021-11-29'),
('customer77@gmail.com', 'customer', 'active', '$2y$10$GpSz4IWBhU64I/q2HoBrcueYnsgAheI4YZ/qDP18TxU6coFpaX8ny', '2021-11-25'),
('customer99@gmail.com', 'customer', 'active', '$2y$10$yHFGtuDg4yRFxQwLf6P1nu7u1JkP.yTXU9SKVMWYf0kxnjykrrW36', '2021-11-20'),
('customer@gmail.com', 'customer', 'active', '$2y$10$ZS0jUOafmPbXlKdh9dJIB.U08KWKxpVpQScly5JnKkkL2NG37CtA2', '2021-11-18'),
('customerdate@gmail.com', 'customer', 'active', '$2y$10$v9DHZpNUQQsS1ODt/quBKOsGZg6yG33GHpy5RruHRM0qvJztTIwma', '2021-12-04'),
('sf@gmail.com', 'staff', 'active', '$2y$10$ML1TtePcdNbrXMKeoWR/sePS2kfFvTEP/SmtUi7bznsA.S5w7SXUS', '2021-10-08'),
('skhhgard@g.com', 'staff', 'active', '$2y$10$uNNGpuuVBrWVtlMVSNoTD.EPPKLLVwsvodWDkh9x.0hWb449UU9Vy', '2021-10-28'),
('staff3@bookmart.com', 'staff', 'active', '$2y$10$11ZH8BEbra.mOoIsdd2NNOkwT/.90IPGZgkJMT8Nqph7z9/IWrH7K', '2021-11-10'),
('staff@gmail.com', 'staff', 'active', '$2y$10$rb4y1UKctGw.2rgO9TUBFenag8jwIQn011jH3dyQcUciLchTnWkli', '2021-12-04'),
('testsf@gmail.com', 'staff', 'active', '$2y$10$jTLHfBfTO/pHHWvtkjnodONNcUWIMS4.gFCrt6GubijwcpFzhSn/S', '2021-11-11');

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
(2, 12, '2021-10-13', 'delivered'),
(3, 13, '2021-10-13', 'ordered'),
(4, 15, '2021-10-13', 'ordered'),
(5, 14, '2021-10-13', 'delivered'),
(6, 18, '2021-10-13', 'ordered'),
(7, 19, '2021-10-13', 'ordered'),
(8, 20, '2021-11-23', 'ordered'),
(9, 21, '2021-11-25', 'delivered'),
(10, 22, '2021-11-25', 'ordered'),
(11, 23, '2021-11-25', 'shipped'),
(12, 24, '2021-11-26', 'shipped'),
(13, 16, '2021-11-26', 'ordered'),
(14, 26, '2021-11-26', 'ordered'),
(15, 27, '2021-11-26', 'shipped'),
(16, 28, '2021-11-26', 'delivered'),
(17, 29, '2021-11-26', 'delivered'),
(18, 31, '2021-11-27', 'delivered'),
(19, 32, '2021-11-27', 'delivered'),
(20, 33, '2021-11-27', 'delivered'),
(21, 30, '2021-11-27', 'delivered'),
(22, 25, '2021-11-27', 'delivered'),
(23, 36, '2021-11-29', 'delivered'),
(24, 37, '2021-11-29', 'ordered'),
(25, 39, '2021-11-29', 'ordered'),
(26, 38, '2021-11-30', 'ordered'),
(27, 35, '2021-11-30', 'ordered'),
(28, 42, '2021-11-30', 'ordered'),
(29, 43, '2021-12-01', 'ordered'),
(30, 44, '2021-12-01', 'ordered'),
(31, 45, '2021-12-01', 'ordered'),
(32, 46, '2021-12-01', 'ordered'),
(33, 47, '2021-12-01', 'ordered'),
(34, 48, '2021-12-01', 'ordered'),
(35, 49, '2021-12-01', 'ordered');

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
(35, 18, 35, 'payed', '2021-12-01');

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
(10, '5656565656', 'bloomsbury@gmail.com', 'Bloomsbury Publishing', 'kochi', 'ernakulam', '682310', 'active'),
(11, '9207248664', 'harper@gmail.com', 'HarperCollins Publishers', 'tripunithura', 'ernakulam', '682345', 'active'),
(12, '8956237845', 'whitehall@gmail.com', 'Whitehall', 'trivandrum', 'trivandrum', '585456', 'active'),
(13, '8527419635', 'randomhouse@gmail.com', 'Random House', 'muvatupuzha', 'ernakulam', '898989', 'active'),
(14, '8495623176', 'wardlockpublishers@gmail.comom', 'Ward Lock', 'puthencruze', 'pathanamthitta', '856234', 'active'),
(15, '5658545254', 'doubldaypublications@yahoo.com', 'Doubleday', 'nevada', 'california', '565854', 'active'),
(16, '5654545658', 'press@universities.com', 'Universities Press', 'kadipur', 'Gurgaon', '475869', 'active'),
(17, '4754545244', 'alfred@hotmail.com', 'Alfred A Knopf', 'New York', 'New York', '682310', 'active'),
(18, '4595351225', 'simonndschustersupport@gmail.com', 'Simon & Schuster', 'texas', 'california', '784585', 'active'),
(19, '4556788923', 'amuletsupport@gmail.com', 'Amulet Books', 'Birningham', 'wolverhampton', '457812', 'active'),
(20, '9207248664', 'dcbooks@gmail.com', 'DC books', 'kochi', 'ernakulam', '682310', 'active'),
(21, '9207244664', 'rupapublications@gmail.com', 'Rupa publications', 'gurugram', 'delhi', '455656', 'active'),
(22, '9656656554', 'abacuspublishers@hotmail.com', 'Abacus', 'machester', 'manchester  central', '682310', 'active'),
(23, '9207248664', 'ahgadfgj@adgk.com', 'khxzkgZ', 'lkjagl', 'jlsgdlkj', '682310', 'active');

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
(53, 24, 14, '150.00', 10, '1500.00'),
(54, 24, 25, '160.00', 5, '800.00'),
(55, 24, 31, '200.00', 7, '1400.00'),
(56, 24, 32, '250.00', 3, '750.00'),
(57, 25, 29, '400.00', 5, '2000.00'),
(58, 25, 24, '250.00', 4, '1000.00'),
(59, 25, 28, '300.00', 8, '2400.00'),
(60, 25, 26, '200.00', 5, '1000.00'),
(61, 26, 30, '250.00', 7, '1750.00'),
(62, 26, 22, '500.00', 20, '10000.00'),
(63, 26, 15, '499.00', 8, '3992.00'),
(64, 27, 17, '125.00', 5, '625.00'),
(65, 27, 27, '200.00', 8, '1600.00'),
(66, 27, 19, '250.00', 5, '1250.00'),
(67, 28, 22, '120.00', 10, '1200.00'),
(68, 28, 24, '100.00', 20, '2000.00'),
(70, 29, 29, '100.00', 12, '1200.00'),
(71, 29, 22, '120.00', 2, '240.00'),
(72, 30, 15, '340.00', 10, '3400.00'),
(73, 30, 25, '230.00', 22, '5060.00'),
(74, 31, 34, '120.00', 14, '1680.00'),
(75, 31, 16, '130.00', 10, '1300.00'),
(76, 32, 18, '150.00', 12, '1800.00'),
(77, 32, 21, '200.00', 15, '3000.00'),
(78, 32, 23, '150.00', 20, '3000.00'),
(79, 33, 32, '130.00', 2, '260.00'),
(80, 34, 28, '130.00', 15, '1950.00'),
(81, 34, 14, '240.00', 17, '4080.00'),
(82, 34, 19, '300.00', 12, '3600.00'),
(83, 34, 15, '150.00', 15, '2250.00');

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
(24, 3, 'admin@bookmart.com', '4450.00', '2021-10-13', 'active'),
(25, 2, 'admin@bookmart.com', '6400.00', '2021-10-14', 'active'),
(26, 4, 'admin@bookmart.com', '15742.00', '2021-10-14', 'active'),
(27, 9, 'admin@bookmart.com', '3475.00', '2021-10-16', 'active'),
(28, 4, 'admin@bookmart.com', '3200.00', '2021-10-13', 'active'),
(29, 2, 'admin@bookmart.com', '1440.00', '2021-10-13', 'active'),
(30, 3, 'admin@bookmart.com', '8460.00', '2021-11-27', 'active'),
(31, 1, 'admin@bookmart.com', '2980.00', '2021-11-30', 'active'),
(32, 8, 'admin@bookmart.com', '7800.00', '2021-11-30', 'active'),
(33, 19, 'admin@bookmart.com', '260.00', '2021-12-01', 'active'),
(34, 2, 'admin@bookmart.com', '11880.00', '2021-12-01', 'active');

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
(1, 15, 'customer2@gmail.com', 'nice book', '2021-11-27', 'active'),
(2, 15, 'customer4@gmail.com', 'nice book', '2021-11-27', 'active'),
(3, 19, 'customer4@gmail.com', 'paulo coelho is the best ! :D', '2021-11-27', 'active'),
(5, 25, 'customer2@gmail.com', 'harry potter is the best', '2021-11-27', 'active'),
(18, 25, 'customer@gmail.com', 'Nice 🙂', '2021-11-27', 'active'),
(19, 24, 'customer@gmail.com', 'nice book', '2021-11-29', 'active');

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
('admin@bookmart.com', 'u55emcdrbunurn8cbsa2c7j8om');

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
(75, 'staff@gmail.com', '9207248664', 'alvinl', 'hello', 'housename', 'city', 'districtwe', '682310'),
(81, 'staff3@bookmart.com', '9207248664', 'test', 'staff', 'testhouse', 'testcity', 'testdistrict', '622310'),
(82, 'asfdas@asdf.com', '9207248664', 'asfd', 'asdf', 'safda', 'asdf', 'asdgadhafsd', '682310'),
(83, 'asdhhreh@dah.com', '9207248664', 'asdha', 'sdfhdgf', 'asdfhgd', 'ashadsg', 'asdffhg', '682310'),
(84, 'ahnfdgsjf@adg.com', '9207248664', 'ahadfg', 'adgjlkj', 'shlojl', 'sdlkk', 'hljdgilj', '682310'),
(85, 'skhhgard@g.com', '9207248664', 'ahadjjnga', 'sdhfagh', 'dasfhadh', 'sagfhjf', 'adjrtmvb', '682340'),
(86, 'ahdsfgs@hsdff.com', '7894561232', 'adradfg', 'kgadgb', 'jskanfgjlk', 'dfhkfh', 'adgln', '682311'),
(87, 'ahjgsdlkgd@gsdkhg.com', '9207248664', 'thklnsdfg', 'kdghknk', 'ahgkhkfg', 'aglfghl', 'afdglljl', '682310'),
(88, 'sf@gmail.com', '9207248664', 'alvin', 'lal', 'hous', 'city', 'district', '682310'),
(90, 'testsf@gmail.com', '9999999999', 'testsf', 'asf', 'asfda', 'sadfasd', 'sadf', '999999');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_subcategory`
--

CREATE TABLE `tbl_subcategory` (
  `SubCat_Id` int(11) NOT NULL,
  `SubCat_name` varchar(20) DEFAULT NULL,
  `Cat_id` int(11) NOT NULL,
  `SubCat_status` enum('active','inactive') DEFAULT 'inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_subcategory`
--

INSERT INTO `tbl_subcategory` (`SubCat_Id`, `SubCat_name`, `Cat_id`, `SubCat_status`) VALUES
(1, 'art history', 1, 'active'),
(2, 'Calligraphy', 1, 'active'),
(3, 'Drawing', 1, 'active'),
(4, 'Fashion', 1, 'active'),
(5, 'Films', 1, 'active'),
(11, 'Ethnic & Cultural', 2, 'active'),
(12, 'Historical', 2, 'active'),
(13, 'Leaders & Notable pe', 2, 'active'),
(14, 'Scientists', 2, 'active'),
(15, 'Artists', 2, 'active'),
(16, 'DC Comics', 3, 'active'),
(17, 'Marvel Comics', 3, 'active'),
(18, 'Fantasy', 3, 'active'),
(19, 'Manga', 3, 'active'),
(20, 'Sci-fi', 3, 'active'),
(21, 'Question Banks', 4, 'active'),
(22, 'Encyclopedia', 4, 'active'),
(23, 'Study Guides', 4, 'active'),
(24, 'Law Practise', 4, 'active'),
(25, 'Textbooks', 4, 'active'),
(26, 'Romance', 5, 'active'),
(27, 'Humour', 5, 'active'),
(28, 'Fictional', 5, 'active'),
(29, 'Mystery', 5, 'active'),
(30, 'Thrillers', 5, 'active'),
(31, 'African', 6, 'active'),
(32, 'Ancient', 6, 'active'),
(33, 'Asian', 6, 'active'),
(34, 'World War', 6, 'active'),
(35, 'Indian', 6, 'active'),
(36, 'Meditation', 7, 'active'),
(37, 'Yoga', 7, 'active'),
(38, 'Mental Well Being', 7, 'active'),
(39, 'Habits', 7, 'active'),
(40, 'Anger Management', 7, 'active'),
(41, 'Electronics', 8, 'active'),
(42, 'Programming', 8, 'active'),
(43, 'Databases', 8, 'active'),
(44, 'Tech Industry', 8, 'active'),
(45, 'Software Development', 8, 'active'),
(46, 'Antiques & Crafts', 9, 'active'),
(47, 'Clay', 9, 'active'),
(48, 'Collecting', 9, 'active'),
(49, 'Fashion', 9, 'active'),
(50, 'Jewellery', 9, 'active'),
(51, 'Architecture', 10, 'active'),
(52, 'Flowers', 10, 'active'),
(53, 'Fruits', 10, 'active'),
(54, 'Home decorating', 10, 'active'),
(55, 'Interior designing', 10, 'active'),
(56, 'Artificial intellige', 8, 'active'),
(57, 'Whodunnits', 5, 'active'),
(58, 'Machine learning', 8, 'active'),
(59, 'Detective novels', 5, 'active'),
(65, 'Paintings', 1, 'active'),
(66, 'Gadgets', 8, 'active'),
(67, 'Circuits', 8, 'active'),
(68, 'Politics', 4, 'active'),
(70, 'Self help', 13, 'active'),
(71, 'Fictional', 14, 'active'),
(72, 'Autobiography', 2, 'active'),
(73, 'Autobiography', 1, 'active'),
(74, 'Autobiography', 15, 'active'),
(75, 'True Crimes', 16, 'active'),
(76, 'childrens book', 14, 'active'),
(77, 'Doctors', 2, 'active'),
(78, 'Campus story', 5, 'active'),
(79, 'stoic literature', 17, 'active'),
(80, 'Inspirational', 5, 'active'),
(81, 'Musical', 18, 'active');

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
(1, 'admin@bookmart.com', '9207248664', 'joe@gmail.com', 'john do', 'asdf', 'asdfajl', '682311', 'active'),
(2, 'admin@bookmart.com', '5854565252', 'janes@gmail.com', 'janes', 'ernakulam', 'kochi', '565656', 'active'),
(3, 'admin@bookmart.com', '5656565656', 'jacobine@gmail.com', 'jake peralta', 'newyork', 'brooklyn', '565656', 'active'),
(4, 'admin@bookmart.com', '5656565656', 'areyoudoing@gmail.com', 'hello', 'world', 'howr', '565655', 'active'),
(5, 'admin@bookmart.com', '5656565656', 'helloworld@gmail.com', 'cap holt', 'michigan', 'america', '565656', 'active'),
(6, 'admin@bookmart.com', '6556565656', 'sadfasdfasdf@dsfsdasdfas.co.uk', 'asdfasdfa', 'asfdasdfasdfasd', 'fasdfasdfasdfasdfasdfasdf', '565656', 'active'),
(7, 'admin@bookmart.com', '9495467201', 'asfdasdflaksdfalsdfjaslkdfjaslkfj@sdfasfdsa.comp', 'asdfasjklaslkfdjalksdf', 'asdfjasdfjkjdfslajadsj', 'asdflasdlfjasdlflsdfjladjlasfj', '565653', 'active'),
(8, 'admin@bookmart.com', '5654852556', 'hello@2wf.com', 'jello', 'new york', 'london bridge', '525252', 'active'),
(9, 'admin@bookmart.com', '9207248664', 'asdf@asdf.com', 'test', 'test', 'trest', '787878', 'active'),
(11, 'admin@bookmart.com', '9207248664', 'asf@sadf.com', 'vendorere', 'vendorcity', 'vendordistrict', '682310', 'active'),
(12, 'admin@bookmart.com', '9207248664', 'asdf@sdff.com', 'asdfa', 'afd', 'asfdq', '682310', 'active'),
(13, 'admin@bookmart.com', '9207248664', 'asdghq@sfs.com', 'asfdasd', 'sdfgw', 'qsdf', '682310', 'active'),
(14, 'admin@bookmart.com', '9207248664', 'ahaeg@sdfhgc.com', 'asdgae', 'sdfhhre', 'adhqerhjq', '682310', 'active'),
(15, 'admin@bookmart.com', '9207248664', 'ahdfjqjrha@adgah.vom', 'aherjqr', 'hjaej qay', 'aherhae', '682310', 'active'),
(16, 'admin@bookmart.com', '9207248664', 'ahdrhqe@dfh.vom', 'aerjarga', 'qaer h wsdsg', 'ahdf adg', '682310', 'active'),
(18, 'admin@bookmart.com', '9207248664', 'Hdndheh@hfifien.com', 'Bdndn', 'Jnsndn', 'Bfndjfj', '682310', 'active'),
(19, 'admin@bookmart.com', '9207248664', 'Jdudn@jfif.com', 'Hsksi', 'Isidn', 'Nsidnd', '682310', 'active'),
(20, 'admin@bookmart.com', '9207248664', 'Ndkxodnd@gmail.com', 'Hdjd', 'Bdjxkcl', 'Bxndkdk', '682310', 'active'),
(21, 'admin@bookmart.com', '9207248664', 'Hdkdk@jdid.com', 'Vxjx', 'Cbcbjdk', 'Fhhhkv', '682310', 'active'),
(22, 'admin@bookmart.com', '9207248664', 'Hdkdk@jdid.com', 'Vxjx', 'Cbcbjdk', 'Fhhhkv', '682310', 'active'),
(23, 'staff@gmail.com', '9207248664', 'testvendor@gmail.com', 'test', 'testcity', 'testdistrict', '682310', 'active'),
(24, 'admin@bookmart.com', '9207248664', 'asgq@sdgf.vom', 'test', 'test', 'aertg', '682310', 'active');

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
  MODIFY `Author_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tbl_card`
--
ALTER TABLE `tbl_card`
  MODIFY `Card_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tbl_cart_child`
--
ALTER TABLE `tbl_cart_child`
  MODIFY `Cart_child_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `tbl_cart_master`
--
ALTER TABLE `tbl_cart_master`
  MODIFY `Cart_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `Cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  MODIFY `Cust_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tbl_item`
--
ALTER TABLE `tbl_item`
  MODIFY `Item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `Order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbl_payment`
--
ALTER TABLE `tbl_payment`
  MODIFY `Payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbl_publisher`
--
ALTER TABLE `tbl_publisher`
  MODIFY `Publisher_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `tbl_purchase_child`
--
ALTER TABLE `tbl_purchase_child`
  MODIFY `Purchase_child_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `tbl_purchase_master`
--
ALTER TABLE `tbl_purchase_master`
  MODIFY `Purchase_master_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tbl_review`
--
ALTER TABLE `tbl_review`
  MODIFY `Review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_staff`
--
ALTER TABLE `tbl_staff`
  MODIFY `Staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `tbl_subcategory`
--
ALTER TABLE `tbl_subcategory`
  MODIFY `SubCat_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `tbl_vendor`
--
ALTER TABLE `tbl_vendor`
  MODIFY `V_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
  ADD CONSTRAINT `tbl_SubCategory_ibfk_1` FOREIGN KEY (`Cat_id`) REFERENCES `tbl_category` (`Cat_id`);

--
-- Constraints for table `tbl_vendor`
--
ALTER TABLE `tbl_vendor`
  ADD CONSTRAINT `tbl_Vendor_ibfk_1` FOREIGN KEY (`V_added_by`) REFERENCES `tbl_login` (`Username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
