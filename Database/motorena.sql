-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 05, 2025 at 08:05 PM
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
-- Database: `motorena`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorieproduit`
--

CREATE TABLE `categorieproduit` (
  `CategoryID` int(11) NOT NULL,
  `NomCategorie_fr` varchar(255) NOT NULL,
  `NomCategorie` varchar(50) NOT NULL,
  `NomCategorie_ar` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorieproduit`
--

INSERT INTO `categorieproduit` (`CategoryID`, `NomCategorie_fr`, `NomCategorie`, `NomCategorie_ar`) VALUES
(1, 'Motor', 'Motorcycle', 'دراجة نارية'),
(2, 'Accessoire', 'Accessories', 'أدوات الزينة'),
(3, 'Piece', 'Pieces', 'قِطَع');

-- --------------------------------------------------------

--
-- Table structure for table `categorieuser`
--

CREATE TABLE `categorieuser` (
  `CategoryID` int(11) NOT NULL,
  `NomCategorie` varchar(255) NOT NULL,
  `NomCategorie_fr` varchar(30) NOT NULL,
  `NomCategorie_ar` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorieuser`
--

INSERT INTO `categorieuser` (`CategoryID`, `NomCategorie`, `NomCategorie_fr`, `NomCategorie_ar`) VALUES
(1, 'Buyer', 'Acheteur', 'مشتر'),
(2, 'Seller', 'Vendeur', 'تاجر'),
(3, 'Admin', 'Administrateur', 'مسؤل');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `CityID` int(11) NOT NULL,
  `CityName` varchar(100) NOT NULL,
  `CityName_fr` varchar(100) NOT NULL,
  `CityName_ar` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`CityID`, `CityName`, `CityName_fr`, `CityName_ar`) VALUES
(1, 'Casablanca', 'Casablanca', 'الدار البيضاء'),
(2, 'Marrakech', 'Marrakech', 'مراكش'),
(3, 'Fes', 'Fès', 'فاس'),
(4, 'Tangier', 'Tanger', 'طنجة'),
(5, 'Rabat', 'Rabat', 'الرباط'),
(6, 'Agadir', 'Agadir', 'أكادير'),
(7, 'Meknes', 'Meknès', 'مكناس'),
(8, 'Ouarzazate', 'Ouarzazate', 'ورزازات'),
(9, 'Essaouira', 'Essaouira', 'الصويرة'),
(10, 'Chefchaouen', 'Chefchaouen', 'شفشاون');

-- --------------------------------------------------------

--
-- Table structure for table `command`
--

CREATE TABLE `command` (
  `CommandID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `command_statu` int(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `command`
--

INSERT INTO `command` (`CommandID`, `name`, `phone_number`, `address`, `quantity`, `total_price`, `ProductID`, `UserID`, `created_at`, `command_statu`, `is_deleted`) VALUES
(2, 'Aymen Oumaalla', '0629474030', 'ISEBTIENNE DB EL HAMMAME NO 61', 3, 30.00, 9, 4, '2024-06-07 16:41:36', 1, 0),
(3, 'Aymen Oumaalla', '0629474030', 'ISEBTIENNE DB EL HAMMAME NO 61', 3, 30.00, 9, NULL, '2024-06-07 16:43:35', 0, 1),
(4, 'Aymen Oumaalla', '0629474030', 'ISEBTIENNE DB EL HAMMAME NO 61', 3, 150.00, 5, NULL, '2024-06-08 13:21:02', 0, 1),
(5, 'Aymen Oumaalla', '0629474030', 'ISEBTIENNE DB EL HAMMAME NO 61', 4, 60.00, 8, 4, '2024-06-09 13:59:27', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `deleted_products`
--

CREATE TABLE `deleted_products` (
  `DeletedProductID` int(11) NOT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `DeletedByUserID` int(11) DEFAULT NULL,
  `DateDeleted` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deleted_products`
--

INSERT INTO `deleted_products` (`DeletedProductID`, `ProductID`, `DeletedByUserID`, `DateDeleted`) VALUES
(9, 11, NULL, '2024-06-21 14:10:25'),
(11, 11, NULL, '2024-06-21 16:42:31'),
(12, 11, NULL, '2024-06-21 17:03:29'),
(13, 11, NULL, '2024-06-21 17:12:10'),
(14, 12, NULL, '2024-06-21 17:12:15'),
(15, 12, NULL, '2024-06-28 09:14:43');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `FavoriteID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`FavoriteID`, `UserID`, `ProductID`, `created_at`) VALUES
(21, 2, 8, '2024-06-08 14:49:48'),
(24, 4, 5, '2024-06-18 11:08:17'),
(33, 2, 10, '2024-06-19 20:40:20'),
(35, 2, 13, '2024-06-21 16:28:06');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `NotificationID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Type` varchar(50) DEFAULT NULL,
  `EntityID` int(11) DEFAULT NULL,
  `Message` text DEFAULT NULL,
  `admin_response` varchar(255) DEFAULT NULL,
  `DateAdded` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`NotificationID`, `UserID`, `Type`, `EntityID`, `Message`, `admin_response`, `DateAdded`, `is_deleted`) VALUES
(3, 2, 'request', 2, 'Have requested to become a seller.', 'Welcome aboard our new seller', '2024-05-11 11:43:21', 0),
(5, 2, 'report', 3, 'dbnxb,c', 'Fuck Off', '2024-05-11 11:50:56', 1),
(6, 4, 'request', 4, 'Have requested to become a seller.', 'Welcome aboard our new seller', '2024-05-20 11:05:38', 0),
(7, 4, 'report', 19, 'something is off with it\r\n', NULL, '2024-05-29 15:50:04', 0),
(8, 4, 'report', 19, 'hey', 'Welcome aboard our new seller', '2024-05-29 16:09:23', 0),
(17, 10, 'request', 10, 'Have requested to become a seller.', 'Welcome aboard our new seller!', '2024-06-25 18:03:21', 0),
(18, 11, 'request', 11, 'Have requested to become a seller.', 'Welcome aboard our new seller!', '2024-06-25 20:52:23', 0),
(19, 12, 'request', 12, '', NULL, '2024-09-18 08:34:57', 0);

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `partner_id` int(11) NOT NULL,
  `brand_name` varchar(255) DEFAULT NULL,
  `email` varchar(30) NOT NULL,
  `website_link` varchar(50) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  `date_timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`partner_id`, `brand_name`, `email`, `website_link`, `logo`, `is_deleted`, `date_timestamp`) VALUES
(1, 'BMW', 'aymenoml2002@gmail.com', 'https://www.bmw.com', 'partners/brand_03.png', 0, '2024-05-11 10:58:51'),
(4, 'YAMAHA', 'aymenoml2002@gmail.com', 'https://yamaha-motor.com/', 'partners/brand.png', 0, '2024-05-16 21:17:49'),
(5, 'TOYOTA', 'aymenoml2002@gmail.com', 'https://www.toyota.com', 'partners/brand_01.png', 0, '2024-06-08 10:18:10'),
(6, 'HONDA', 'aymenoml2002@gmail.com', 'https://www.honda-mideast.com/fr-ma/', 'partners/brand_04.png', 0, '2024-06-08 10:18:30'),
(7, 'ds;', 'smlq@jdl', 'ml,qsd', 'partners/Screenshot (9).png', 1, '2024-06-19 20:04:49');

-- --------------------------------------------------------

--
-- Table structure for table `productpictures`
--

CREATE TABLE `productpictures` (
  `PictureID` int(11) NOT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_main` bit(1) DEFAULT b'0',
  `is_deleted` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productpictures`
--

INSERT INTO `productpictures` (`PictureID`, `ProductID`, `image_url`, `is_main`, `is_deleted`, `created_at`) VALUES
(8, 1, 'uploads/1.jpg', b'1', 0, '2024-06-21 14:05:22'),
(9, 2, 'uploads/images (5).jpg', b'1', 0, '2024-06-21 14:05:22'),
(10, 3, 'uploads/images (2).jpg', b'1', 0, '2024-06-21 14:05:22'),
(11, 4, 'uploads/images (4).jpg', b'1', 0, '2024-06-21 14:05:22'),
(12, 5, 'uploads/416hSXJX-JL._AC_.jpg', b'1', 0, '2024-06-21 14:05:22'),
(13, 6, 'uploads/les-gants-moto-et-velo_140478-2-700x500.jpg', b'1', 0, '2024-06-21 14:05:22'),
(14, 7, 'uploads/41KJVCi5QIL._SY355_-247x296.webp', b'1', 0, '2024-06-21 14:05:22'),
(15, 8, 'uploads/s-l1200.jpg', b'1', 0, '2024-06-21 14:05:22'),
(16, 9, 'uploads/mqdefault.jpg', b'1', 0, '2024-06-21 14:05:22'),
(17, 10, 'uploads/H0931d1b4afe24be287da59f1f9199745q.png_300x300.avif', b'1', 0, '2024-06-21 14:05:22'),
(18, 11, 'uploads/6474834.jpg', b'1', 0, '2024-06-21 14:05:22'),
(19, 12, 'uploads/images.jpg', b'1', 0, '2024-06-21 14:05:22'),
(20, 13, 'uploads/city_blanc_plongee-e1667871385873.jpg', b'1', 0, '2024-06-21 14:05:22'),
(21, 14, 'uploads/8990979.jpg', b'1', 0, '2024-06-21 14:05:22'),
(28, 11, 'uploads/IMG-6675880c3c43b6.81311787.jpg', b'0', 0, '2024-06-21 14:05:22'),
(29, 11, 'uploads/IMG-6675880c3d3884.80768540.jpg', b'0', 0, '2024-06-21 14:05:22'),
(30, 12, 'uploads/667589f9dcf432.27657744.jpg', b'0', 0, '2024-06-21 14:11:05'),
(31, 12, 'uploads/667589f9de3592.70173058.jpg', b'0', 0, '2024-06-21 14:11:05'),
(32, 12, 'uploads/667589f9f3e386.08066328.jpg', b'0', 0, '2024-06-21 14:11:06'),
(33, 12, 'uploads/667589fa019bb9.85828177.jpg', b'0', 1, '2024-06-21 14:11:06'),
(35, 14, 'uploads/66758cfa8f8680.55898005.jpg', b'0', 0, '2024-06-21 14:23:54'),
(36, 13, 'uploads/66758d163fe8f9.88100387.jpg', b'0', 0, '2024-06-21 14:24:22'),
(39, 11, 'uploads/6677fc031a4291.15717796.jpg', b'0', 1, '2024-06-23 10:42:11'),
(40, 11, 'uploads/6677fd3317e180.13085595.jpg', b'0', 0, '2024-06-23 10:47:15'),
(75, 43, 'uploads/416hSXJX-JL._AC_.jpg', b'1', 0, '2024-07-05 19:35:46'),
(76, 43, 'uploads/41KJVCi5QIL._SY355_-247x296.webp', b'0', 0, '2024-07-05 19:35:46');

-- --------------------------------------------------------

--
-- Table structure for table `product_interest`
--

CREATE TABLE `product_interest` (
  `id` int(11) NOT NULL,
  `BuyerID` int(11) DEFAULT NULL,
  `buyer_name` varchar(100) DEFAULT NULL,
  `buyer_phone` varchar(20) DEFAULT NULL,
  `seller_id` int(30) NOT NULL,
  `ProductID` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produit`
--

CREATE TABLE `produit` (
  `ProductID` int(11) NOT NULL,
  `NomProduit` varchar(255) NOT NULL,
  `quantity` int(30) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Prix` decimal(10,2) DEFAULT NULL,
  `kilometrage` int(11) DEFAULT NULL,
  `annee` date DEFAULT NULL,
  `puissance_fiscale` int(11) DEFAULT NULL,
  `couleur` varchar(50) DEFAULT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `Vehicule_dedouane` date DEFAULT NULL,
  `is_sold` tinyint(1) DEFAULT 0,
  `DateAdded` timestamp NOT NULL DEFAULT current_timestamp(),
  `UserID` int(11) DEFAULT NULL,
  `Statu` tinyint(1) DEFAULT 0,
  `is_deleted` tinyint(1) DEFAULT 0,
  `command_statu` tinyint(1) DEFAULT 0,
  `CityID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produit`
--

INSERT INTO `produit` (`ProductID`, `NomProduit`, `quantity`, `Description`, `Prix`, `kilometrage`, `annee`, `puissance_fiscale`, `couleur`, `CategoryID`, `Vehicule_dedouane`, `is_sold`, `DateAdded`, `UserID`, `Statu`, `is_deleted`, `command_statu`, `CityID`) VALUES
(1, 'Bougie', NULL, 'mre7ba 3endna', 40.00, NULL, NULL, NULL, NULL, 3, NULL, 0, '2024-05-23 13:09:36', 2, 0, 0, 1, NULL),
(2, 'Tier Yamaha ', NULL, 'jdad o el ga3 el mater mre7ba commande kayna tamane fix', 200.00, NULL, NULL, NULL, NULL, 3, NULL, 0, '2024-05-23 13:12:35', 2, 0, 0, 1, NULL),
(3, 'Casque', NULL, 'bga3 lwan o achkal ', 250.00, NULL, NULL, NULL, NULL, 3, NULL, 0, '2024-05-23 13:15:39', 2, 0, 0, 1, NULL),
(4, 'Cache des Motos', NULL, 'bzzzf alwan ', 100.00, NULL, NULL, NULL, NULL, 2, NULL, 0, '2024-05-23 13:33:56', 2, 0, 0, 1, NULL),
(5, 'Phone Holder', NULL, 'ta itjebed el ay tele m3ah cable type C', 50.00, NULL, NULL, NULL, NULL, 2, NULL, 0, '2024-05-23 13:39:34', 2, 0, 0, 1, NULL),
(6, 'Les gants de motos', NULL, 'bga3 alwan atmina fix', 70.00, NULL, NULL, NULL, NULL, 2, NULL, 0, '2024-05-23 13:41:12', 2, 0, 0, 1, NULL),
(7, 'Piece de charge', NULL, 'jdid ', 50.00, NULL, NULL, NULL, NULL, 3, NULL, 0, '2024-05-23 13:43:50', 2, 0, 0, 1, NULL),
(8, 'Yamaha stickers', NULL, 'collection kbira ', 15.00, NULL, NULL, NULL, NULL, 2, NULL, 0, '2024-05-23 13:49:21', 2, 1, 0, 1, NULL),
(9, 'c-90 stickers', NULL, 'cheri 3 o 5oud 3 fabour', 10.00, NULL, NULL, NULL, NULL, 2, NULL, 1, '2024-05-23 13:52:55', 2, 0, 0, 1, NULL),
(10, 'respect for bikers', NULL, 'collection for all bikers', 15.00, NULL, NULL, NULL, NULL, 2, NULL, 0, '2024-05-23 14:11:37', 2, 0, 0, 1, NULL),
(11, 'Yamaha Trois', NULL, 'mre7ba bnas meknas', 5000.00, 0, '0000-00-00', 0, '', 1, '0000-00-00', 0, '2024-05-23 14:16:38', 2, 0, 0, 0, 2),
(12, 'c-90', NULL, 'mre7ba fwhatsapp ', 5000.00, 0, '0000-00-00', 0, '', 1, '0000-00-00', 0, '2024-05-23 14:18:09', 2, 1, 1, 0, NULL),
(13, 'Scooter Electrique', NULL, 'nas dyal casa safe', 6000.00, 0, '0000-00-00', 0, '', 1, '0000-00-00', 0, '2024-05-23 14:19:22', 2, 0, 0, 0, NULL),
(14, 'Neos ', NULL, 'nas merrakch dawdyat', 8000.00, 0, '0000-00-00', 0, '', 1, '0000-00-00', 0, '2024-05-23 14:20:38', 2, 1, 0, 0, NULL),
(43, 'Yamaha Trois', 0, 'j\'ai stock de motos', 5000.00, NULL, NULL, NULL, NULL, 2, NULL, 0, '2024-07-05 19:35:46', 2, 0, 0, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `profile_ratings`
--

CREATE TABLE `profile_ratings` (
  `RatingID` int(11) NOT NULL,
  `RatedUserID` int(11) DEFAULT NULL,
  `RatingUserID` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile_ratings`
--

INSERT INTO `profile_ratings` (`RatingID`, `RatedUserID`, `RatingUserID`, `rating`, `created_at`) VALUES
(1, 2, 1, 3, '2024-05-27 21:15:13'),
(3, 2, 4, 4, '2024-05-28 22:55:58');

-- --------------------------------------------------------

--
-- Table structure for table `social_media_links`
--

CREATE TABLE `social_media_links` (
  `SocialMediaID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `Facebook` varchar(255) DEFAULT NULL,
  `Instagram` varchar(255) DEFAULT NULL,
  `paypal` varchar(255) DEFAULT NULL,
  `Linkedin` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `social_media_links`
--

INSERT INTO `social_media_links` (`SocialMediaID`, `UserID`, `Facebook`, `Instagram`, `paypal`, `Linkedin`, `created_at`) VALUES
(1, 1, 'https://www.facebook.com/profile.php?id=100034950181394', '', 'https://twitter.com/alarcon_44', 'https://www.linkedin.com/in/aymen-oumaalla-676b46268/', '2024-05-11 10:27:19'),
(2, 2, 'https://www.facebook.com/profile.php?id=100034950181394', '', 'https://twitter.com/alarcon_44', 'https://www.linkedin.com/in/aymen-oumaalla-676b46268/', '2024-05-11 11:43:21'),
(4, 4, 'https://www.facebook.com/profile.php?id=100034950181394', '', 'https://twitter.com/alarcon_44', 'https://www.linkedin.com/in/aymen-oumaalla-676b46268/', '2024-05-20 11:05:38'),
(9, 10, 'https://www.facebook.com/profile.php?id=100034950181394', '', 'alarcon442002@gmail.com', 'https://www.linkedin.com/in/aymen-oumaalla-676b46268/', '2024-06-25 18:03:21'),
(10, 11, 'https://www.facebook.com/profile.php?id=100034950181394', '', 'alarcon442002@gmail.com', '', '2024-06-25 20:52:23'),
(11, 12, '', '', '', '', '2024-09-18 08:34:57');

-- --------------------------------------------------------

--
-- Table structure for table `subscription_plans`
--

CREATE TABLE `subscription_plans` (
  `PlanID` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_ar` varchar(30) NOT NULL,
  `name_fr` varchar(30) NOT NULL,
  `max_quantity_per_product` varchar(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `access_to_premium_features` tinyint(1) NOT NULL DEFAULT 0,
  `verification_mark` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscription_plans`
--

INSERT INTO `subscription_plans` (`PlanID`, `name`, `name_ar`, `name_fr`, `max_quantity_per_product`, `price`, `access_to_premium_features`, `verification_mark`) VALUES
(1, 'Free Plan', 'اشتراك مجاني', 'Forfait gratuit', '10', 0.00, 0, 0),
(2, 'Basic Plan', 'الاشتراك الأساسي', 'forfait de base', '20', 9.99, 0, 1),
(3, 'Standard Plan', 'الاشتراك العادي', 'Forfait standard', '50', 19.99, 1, 1),
(4, 'Premium Plan', 'الاشتراك المتميز', 'plan premium', 'unlimited', 29.99, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_subscriptions`
--

CREATE TABLE `user_subscriptions` (
  `SubscriptionID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `PlanID` int(11) NOT NULL,
  `start_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `end_date` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_subscriptions`
--

INSERT INTO `user_subscriptions` (`SubscriptionID`, `UserID`, `PlanID`, `start_date`, `end_date`, `status`) VALUES
(1, 10, 1, '2024-06-25 19:18:16', '2024-07-25', 1),
(2, 11, 2, '2024-06-26 11:48:04', '2024-07-25', 1);

--
-- Triggers `user_subscriptions`
--
DELIMITER $$
CREATE TRIGGER `update_subscription_status` BEFORE UPDATE ON `user_subscriptions` FOR EACH ROW BEGIN
    IF NEW.end_date < NOW() THEN
        SET NEW.status = 0;
    ELSE
        SET NEW.status = 1;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `UserID` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `DateAdded` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`UserID`, `username`, `email`, `password`, `DateAdded`) VALUES
(1, 'aymen', 'ntaola06@gmail.com', '$2y$10$IUrb43AtNHGKFSGLh.GrNeifxmx.BzZQ8BDVvCIPeOk9YVLd3diLu', '2024-05-11 10:23:11'),
(2, 'aymen', 'aymenoml2002@gmail.com', '$2y$10$D00m149Rqn.HFTGx0PAnJueKf/E5eq9mlWFP0mvarHaIh3Mnj5N/e', '2024-05-11 11:43:02'),
(4, 'aymen', 'aymen2002@gmail.com', '$2y$10$7J01tJ.j4BPfePofYwg78OPkMYep0AIqGhfKiWClWWfId362FbTU6', '2024-05-20 11:01:26'),
(10, 'saad', 'aml2002@gmail.com', '$2y$10$Nyu4waK3RYcBQkRTv.zxjuyweuWXTFsLO0z47qfVF2vX.YRHYBmPm', '2024-06-25 18:02:55'),
(11, 'chi smiya', 'noml2002@gmail.com', '$2y$10$aeFgGzlS3ug82RoEiufE.Oe6tW.Dpjwq7mKOx15zGqj5p79UHwWqy', '2024-06-25 20:52:09'),
(12, 'aljds', 'a@gmail.com', '$2y$10$UB4.UabM5FxnB0eIMD4yxOb8fy5DoDwDjDKh8ZdLtdS9CULeZoQxK', '2024-09-18 08:34:31');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurinfo`
--

CREATE TABLE `utilisateurinfo` (
  `id` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `fullname` varchar(30) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `Gender` enum('Male','Female','Other') DEFAULT NULL,
  `Adresse` varchar(255) DEFAULT NULL,
  `CodePostal` varchar(10) DEFAULT NULL,
  `Bio` text DEFAULT NULL,
  `type` int(2) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `subscribed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `utilisateurinfo`
--

INSERT INTO `utilisateurinfo` (`id`, `UserID`, `fullname`, `phone`, `Gender`, `Adresse`, `CodePostal`, `Bio`, `type`, `birthday`, `profile_picture`, `subscribed`) VALUES
(2, 2, 'Aymen Oumaalla', '0629474030', 'Male', 'ISEBTIENNE DB EL HAMMAME NO 61', '40000', 'halla madrid', 2, '2002-12-07', 'users/WhatsApp Image 2023-03-28 à 17.41.01.jpg', 0),
(3, 1, 'Aymen Oumaalla', '0629474030', 'Male', 'ISEBTIENNE DB EL HAMMAME NO 61', '40000', 'halla madrid', 3, '2002-12-07', 'users/XXXX 338.png', 0),
(5, 4, 'Aymen Oumaalla', '0629474030', 'Male', 'ISEBTIENNE DB EL HAMMAME NO 61', '40000', '', 2, '2002-12-07', 'users/XXXX 338.png', 0),
(10, 10, 'Aymen Oumaalla', '0629474030', 'Male', 'ISEBTIENNE DB EL HAMMAME NO 61', '40000', 'ax ka txouf', 2, '2005-12-10', 'users/Screenshot (1).png', 1),
(11, 11, 'Aymen Oumaalla', '0629474030', '', 'ISEBTIENNE DB EL HAMMAME NO 61', '40000', '', 2, '0000-00-00', 'users/Logo-accreditation.jpg', 1),
(12, 12, 'Aymen Oumaalla', '0629474030', 'Male', 'ISEBTIENNE DB EL HAMMAME NO 61', '40000', 'ax ka txouf', 1, '2005-12-01', 'users/Capture d\'écran 2024-07-18 163646.png', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorieproduit`
--
ALTER TABLE `categorieproduit`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `categorieuser`
--
ALTER TABLE `categorieuser`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`CityID`);

--
-- Indexes for table `command`
--
ALTER TABLE `command`
  ADD PRIMARY KEY (`CommandID`),
  ADD KEY `command_ibfk_2` (`UserID`),
  ADD KEY `command_ibfk_1` (`ProductID`);

--
-- Indexes for table `deleted_products`
--
ALTER TABLE `deleted_products`
  ADD PRIMARY KEY (`DeletedProductID`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `DeletedByUserID` (`DeletedByUserID`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`FavoriteID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`NotificationID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`partner_id`);

--
-- Indexes for table `productpictures`
--
ALTER TABLE `productpictures`
  ADD PRIMARY KEY (`PictureID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `product_interest`
--
ALTER TABLE `product_interest`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_interest_ibfk_1` (`BuyerID`),
  ADD KEY `product_interest_ibfk_2` (`ProductID`);

--
-- Indexes for table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `CategoryID` (`CategoryID`),
  ADD KEY `fk_user` (`UserID`),
  ADD KEY `fk_city` (`CityID`);

--
-- Indexes for table `profile_ratings`
--
ALTER TABLE `profile_ratings`
  ADD PRIMARY KEY (`RatingID`),
  ADD KEY `RatedUserID` (`RatedUserID`),
  ADD KEY `RatingUserID` (`RatingUserID`);

--
-- Indexes for table `social_media_links`
--
ALTER TABLE `social_media_links`
  ADD PRIMARY KEY (`SocialMediaID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  ADD PRIMARY KEY (`PlanID`);

--
-- Indexes for table `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  ADD PRIMARY KEY (`SubscriptionID`),
  ADD KEY `user_subscriptions_ibfk_1` (`UserID`),
  ADD KEY `user_subscriptions_ibfk_2` (`PlanID`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `utilisateurinfo`
--
ALTER TABLE `utilisateurinfo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `UserID` (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorieproduit`
--
ALTER TABLE `categorieproduit`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categorieuser`
--
ALTER TABLE `categorieuser`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `CityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `command`
--
ALTER TABLE `command`
  MODIFY `CommandID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `deleted_products`
--
ALTER TABLE `deleted_products`
  MODIFY `DeletedProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `FavoriteID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `NotificationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `partner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `productpictures`
--
ALTER TABLE `productpictures`
  MODIFY `PictureID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `product_interest`
--
ALTER TABLE `product_interest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `produit`
--
ALTER TABLE `produit`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `profile_ratings`
--
ALTER TABLE `profile_ratings`
  MODIFY `RatingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `social_media_links`
--
ALTER TABLE `social_media_links`
  MODIFY `SocialMediaID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `subscription_plans`
--
ALTER TABLE `subscription_plans`
  MODIFY `PlanID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  MODIFY `SubscriptionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `utilisateurinfo`
--
ALTER TABLE `utilisateurinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `command`
--
ALTER TABLE `command`
  ADD CONSTRAINT `command_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `produit` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `command_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `utilisateur` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `deleted_products`
--
ALTER TABLE `deleted_products`
  ADD CONSTRAINT `deleted_products_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `produit` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `deleted_products_ibfk_2` FOREIGN KEY (`DeletedByUserID`) REFERENCES `utilisateur` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `utilisateur` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `produit` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `utilisateur` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `productpictures`
--
ALTER TABLE `productpictures`
  ADD CONSTRAINT `productpictures_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `produit` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_interest`
--
ALTER TABLE `product_interest`
  ADD CONSTRAINT `product_interest_ibfk_1` FOREIGN KEY (`BuyerID`) REFERENCES `utilisateurinfo` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_interest_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `produit` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `fk_city` FOREIGN KEY (`CityID`) REFERENCES `cities` (`CityID`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`UserID`) REFERENCES `utilisateur` (`UserID`),
  ADD CONSTRAINT `produit_ibfk_1` FOREIGN KEY (`CategoryID`) REFERENCES `categorieproduit` (`CategoryID`);

--
-- Constraints for table `profile_ratings`
--
ALTER TABLE `profile_ratings`
  ADD CONSTRAINT `profile_ratings_ibfk_1` FOREIGN KEY (`RatedUserID`) REFERENCES `utilisateur` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `profile_ratings_ibfk_2` FOREIGN KEY (`RatingUserID`) REFERENCES `utilisateur` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `social_media_links`
--
ALTER TABLE `social_media_links`
  ADD CONSTRAINT `social_media_links_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `utilisateur` (`UserID`) ON DELETE CASCADE;

--
-- Constraints for table `user_subscriptions`
--
ALTER TABLE `user_subscriptions`
  ADD CONSTRAINT `user_subscriptions_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `utilisateur` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_subscriptions_ibfk_2` FOREIGN KEY (`PlanID`) REFERENCES `subscription_plans` (`PlanID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `utilisateurinfo`
--
ALTER TABLE `utilisateurinfo`
  ADD CONSTRAINT `UserID` FOREIGN KEY (`UserID`) REFERENCES `utilisateur` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
