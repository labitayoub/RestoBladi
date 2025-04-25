-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 25, 2025 at 11:48 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restobladi`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `manager_id` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`),
  KEY `categories_manager_id_foreign` (`manager_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`, `slug`, `created_at`, `updated_at`, `manager_id`) VALUES
(1, 'Le petit-déjeuner', 'le-petit-dejeuner', '2025-04-16 14:46:02', '2025-04-16 14:47:17', 2),
(2, 'Le déjeuner', 'le-dejeuner', '2025-04-16 14:46:49', '2025-04-16 14:46:49', 2),
(4, 'Le diner', 'le-diner', '2025-04-16 14:48:13', '2025-04-16 14:48:13', 2),
(5, 'Dessert', 'dessert', '2025-04-16 14:48:35', '2025-04-16 14:48:35', 2);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `managers`
--

DROP TABLE IF EXISTS `managers`;
CREATE TABLE IF NOT EXISTS `managers` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint NOT NULL,
  `restaurant_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `managers_restaurant_id_unique` (`restaurant_id`),
  KEY `managers_user_id_foreign` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `managers`
--

INSERT INTO `managers` (`id`, `status`, `user_id`, `restaurant_id`, `created_at`, `updated_at`) VALUES
(1, 'rejected', 2, 1, '2025-04-16 14:39:38', '2025-04-24 19:57:16'),
(2, 'approved', 3, 2, '2025-04-16 14:42:06', '2025-04-16 14:44:59');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `manager_id` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menus_category_id_foreign` (`category_id`),
  KEY `menus_manager_id_foreign` (`manager_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `title`, `slug`, `description`, `price`, `image`, `category_id`, `created_at`, `updated_at`, `manager_id`) VALUES
(1, 'Jus d\'orange', 'jus-dorange', 'Jus d\'orange pressé', 79.00, '1744818795_Jus d\'orange.jpg', 1, '2025-04-16 14:53:15', '2025-04-16 14:53:15', 2),
(2, 'Lait chaud', 'lait-chaud', 'Lait chaud', 27.00, '1744818913_Lait chaud.jpg', 1, '2025-04-16 14:55:13', '2025-04-16 15:00:39', 2),
(3, 'Lait froid', 'lait-froid', 'Lait froid', 23.00, '1744819002_Lait froid.jpg', 1, '2025-04-16 14:56:42', '2025-04-16 15:00:48', 2),
(4, 'Thé vert', 'the-vert', 'Thé vert', 27.00, '1744819108_Thé vert.jpg', 1, '2025-04-16 14:58:28', '2025-04-16 14:58:28', 2),
(5, 'Expresso', 'expresso', 'Café Expresso', 24.00, '1744819175_Espresso.jpg', 1, '2025-04-16 14:59:35', '2025-04-16 15:00:58', 2),
(6, 'Café au Lait', 'cafe-au-lait', 'Café au Lait', 26.00, '1744819211_Café au lait.jpg', 1, '2025-04-16 15:00:11', '2025-04-16 15:01:06', 2),
(7, 'Cappuccino', 'cappuccino', 'Café Cappuccino', 29.00, '1744819343_Cappuccino.jpg', 1, '2025-04-16 15:02:23', '2025-04-16 15:02:23', 2),
(8, 'Croissant', 'croissant', 'Croissant au beurre', 37.00, '1744819515_Croissant au beurre.jpg', 1, '2025-04-16 15:05:15', '2025-04-16 15:05:15', 2),
(9, 'Pain au chocolat', 'pain-au-chocolat', 'Pain au chocolat', 29.00, '1744819598_Pain au chocolat.jpg', 1, '2025-04-16 15:06:38', '2025-04-16 15:06:38', 2),
(11, 'Œufs', 'oeufs', 'Œufs (brouillés, au plat)', 63.00, '1744820207_oeufs.jpg', 1, '2025-04-16 15:16:47', '2025-04-22 01:44:36', 2),
(12, 'Fromage', 'fromage', 'Fromage blanc avec granola', 36.00, '1744820342_Fromage blanc avec granola.jpg', 1, '2025-04-16 15:19:02', '2025-04-16 15:19:02', 2),
(13, 'Salade verte', 'salade-verte', 'Salade verte, tomate & maïs', 69.00, '1744820493_Salade verte.jpg', 2, '2025-04-16 15:21:33', '2025-04-16 15:21:33', 2),
(14, 'Salade niçoise', 'salade-nicoise', 'Salade niçoise', 72.00, '1744820604_Salade niçoise.jpg', 2, '2025-04-16 15:23:24', '2025-04-16 15:23:24', 2),
(15, 'Poulet rôti', 'poulet-roti', 'Poulet rôti accompagné de riz aux légumes', 143.00, '1744820895_Poulet rôtii.jpg', 2, '2025-04-16 15:28:15', '2025-04-16 15:28:15', 2),
(16, 'Tajine', 'tajine', 'Tajine de bœuf aux pruneaux', 193.00, '1744821042_Tajine.jpg', 2, '2025-04-16 15:30:42', '2025-04-16 15:30:42', 2),
(17, 'Filet de poisson grillé', 'filet-de-poisson-grille', 'Filet de poisson grillé', 158.00, '1744821241_Filet de poisson grillé.jpg', 2, '2025-04-16 15:34:01', '2025-04-16 15:34:01', 2),
(18, 'Couscous', 'couscous', 'Couscous aux 7 légumes', 138.00, '1744821317_Couscous aux 7 légumes.jpg', 2, '2025-04-16 15:35:17', '2025-04-16 15:35:17', 2),
(19, 'Spaghetti', 'spaghetti', 'Spaghetti bolognaise', 73.00, '1744821470_Spaghetti bolognaise.jpg', 2, '2025-04-16 15:37:50', '2025-04-16 15:37:50', 2),
(20, 'Fruits de saison', 'fruits-de-saison', 'Fruits de saison', 87.00, '1744821574_Fruits de saison.jpg', 5, '2025-04-16 15:39:34', '2025-04-16 15:49:07', 2),
(21, 'Yaourt nature', 'yaourt-nature', 'Yaourt nature', 43.00, '1744822495_Yaourt nature.jpg', 5, '2025-04-16 15:54:55', '2025-04-16 15:54:55', 2),
(22, 'Mousse au chocolat', 'mousse-au-chocolat', 'Mousse au chocolat noir de la maison', 67.00, '1744822594_Mousse au chocolat.jpg', 5, '2025-04-16 15:56:34', '2025-04-16 15:56:34', 2),
(23, 'Soupe de légumes', 'soupe-de-legumes', 'Soupe de légumes', 59.00, '1744823307_Soupe de légumes.jpg', 4, '2025-04-16 16:08:27', '2025-04-16 16:08:27', 2),
(24, 'Gratin de courgettes', 'gratin-de-courgettes', 'Gratin de courgettes au fromage léger', 73.00, '1744823428_Gratin de courgettes.jpg', 4, '2025-04-16 16:10:28', '2025-04-16 16:10:28', 2),
(25, 'Escalope de poulet', 'escalope-de-poulet', 'Escalope de poulet grillée', 136.00, '1744823547_Escalope de poulet grillée.jpg', 4, '2025-04-16 16:12:27', '2025-04-16 16:12:56', 2),
(26, 'Eau plate ou gazeuse', 'eau-plate-ou-gazeuse', 'Eau plate ou gazeuse', 37.00, '1744823701_Eau plate ou gazeuse.jpg', 4, '2025-04-16 16:15:01', '2025-04-16 16:15:01', 2),
(27, 'Riz basmati nature', 'riz-basmati-nature', 'Riz basmati nature', 75.00, '1744823782_Riz basmati nature.jpg', 4, '2025-04-16 16:16:22', '2025-04-16 16:16:22', 2),
(28, 'Légumes sautés', 'legumes-sautes', 'Légumes sautés au wok', 55.00, '1744823866_Légumes sautés au wok.jpg', 4, '2025-04-16 16:17:46', '2025-04-16 16:17:46', 2);

-- --------------------------------------------------------

--
-- Table structure for table `menu_sale`
--

DROP TABLE IF EXISTS `menu_sale`;
CREATE TABLE IF NOT EXISTS `menu_sale` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `menu_id` bigint UNSIGNED NOT NULL,
  `sale_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_sale_menu_id_foreign` (`menu_id`),
  KEY `menu_sale_sale_id_foreign` (`sale_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menu_sale`
--

INSERT INTO `menu_sale` (`id`, `menu_id`, `sale_id`, `created_at`, `updated_at`) VALUES
(1, 5, 1, NULL, NULL),
(2, 13, 1, NULL, NULL),
(3, 23, 1, NULL, NULL),
(4, 1, 2, NULL, NULL),
(5, 24, 3, NULL, NULL),
(6, 27, 3, NULL, NULL),
(7, 1, 4, NULL, NULL),
(8, 13, 4, NULL, NULL),
(9, 20, 4, NULL, NULL),
(10, 2, 5, NULL, NULL),
(11, 2, 6, NULL, NULL),
(12, 3, 6, NULL, NULL),
(13, 5, 7, NULL, NULL),
(14, 1, 8, NULL, NULL),
(15, 9, 8, NULL, NULL),
(16, 7, 9, NULL, NULL),
(17, 23, 10, NULL, NULL),
(18, 3, 10, NULL, NULL),
(19, 1, 11, NULL, NULL),
(20, 2, 11, NULL, NULL),
(21, 4, 12, NULL, NULL),
(22, 26, 12, NULL, NULL),
(23, 1, 13, NULL, NULL),
(24, 2, 13, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_01_01_000000_create_roles_table', 1),
(6, '2025_03_04_174845_create_restaurants_table', 1),
(7, '2025_03_23_010026_create_categories_table', 1),
(8, '2025_03_23_023436_create_menus_table', 1),
(9, '2025_03_23_025057_create_sales_table', 1),
(10, '2025_03_23_053844_create_tables_table', 1),
(11, '2025_03_23_054945_create_waiters_table', 1),
(12, '2025_03_24_0009238_create_menu_sale_table', 1),
(13, '2025_03_24_000927_add_user_id_to_waiters_table', 1),
(14, '2025_03_24_101951_create_sale_table_table', 1),
(15, '2025_03_26_180728_create_managers_table', 1),
(16, '2025_04_09_002006_add_manager_id_to_waiters_table', 1),
(17, '2025_04_14_152539_add_manager_id_to_categories_table', 1),
(18, '2025_04_14_152850_add_manager_id_to_menus_table', 1),
(19, '2025_04_14_152936_add_manager_id_to_tables_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

DROP TABLE IF EXISTS `restaurants`;
CREATE TABLE IF NOT EXISTS `restaurants` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `restaurants_slug_unique` (`slug`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`id`, `name`, `slug`, `address`, `phone_number`, `created_at`, `updated_at`) VALUES
(1, 'resto chawarma', 'resto-chawarma', 'rue atlass hay el houda N32', '0660846099', '2025-04-16 14:39:38', '2025-04-16 14:39:38'),
(2, 'resto nassro', 'resto-nassro', 'N93 hay el taqadom ,Yousoufia', '0622734781', '2025-04-16 14:42:06', '2025-04-16 14:42:06'),
(3, 'aaaaaaaaaaa', 'aaaaaaaaaaa', 'zzzzzzzzzzzzzzzzz', '1111111111111', '2025-04-24 19:50:23', '2025-04-24 19:50:23');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2025-04-16 14:32:07', '2025-04-16 14:32:07'),
(2, 'manager', '2025-04-16 14:32:07', '2025-04-16 14:32:07'),
(3, 'waiter', '2025-04-16 14:32:07', '2025-04-16 14:32:07');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
CREATE TABLE IF NOT EXISTS `sales` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `total_ht` decimal(8,2) NOT NULL DEFAULT '0.00',
  `tva` decimal(8,2) NOT NULL DEFAULT '0.00',
  `total_ttc` decimal(8,2) NOT NULL DEFAULT '0.00',
  `payment_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cash',
  `waiter_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sales_waiter_id_foreign` (`waiter_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `total_ht`, `tva`, `total_ttc`, `payment_type`, `waiter_id`, `created_at`, `updated_at`) VALUES
(1, 152.00, 30.40, 182.40, 'cash', 1, '2025-04-16 16:26:46', '2025-04-16 16:26:46'),
(2, 79.00, 15.80, 94.80, 'cash', 2, '2025-04-16 18:23:24', '2025-04-16 18:23:24'),
(3, 148.00, 29.60, 177.60, 'card', 2, '2025-04-16 18:36:57', '2025-04-16 18:36:57'),
(4, 235.00, 47.00, 282.00, 'cash', 2, '2025-04-18 08:42:02', '2025-04-18 08:42:02'),
(5, 27.00, 5.40, 32.40, 'card', 2, '2025-04-19 16:48:30', '2025-04-19 16:48:30'),
(6, 50.00, 10.00, 60.00, 'cash', 2, '2025-04-19 22:32:47', '2025-04-19 22:32:47'),
(7, 24.00, 4.80, 28.80, 'cash', 2, '2025-04-19 22:45:48', '2025-04-19 22:45:48'),
(8, 108.00, 21.60, 129.60, 'card', 2, '2025-04-19 23:20:47', '2025-04-19 23:20:47'),
(9, 29.00, 5.80, 34.80, 'card', 2, '2025-04-19 23:21:20', '2025-04-19 23:21:20'),
(10, 82.00, 16.40, 98.40, 'card', 2, '2025-04-19 23:50:07', '2025-04-19 23:51:00'),
(11, 106.00, 21.20, 127.20, 'cash', 2, '2025-04-21 11:59:35', '2025-04-21 11:59:35'),
(12, 64.00, 12.80, 76.80, 'cash', 2, '2025-04-21 23:21:04', '2025-04-22 01:36:10'),
(13, 106.00, 21.20, 127.20, 'card', 2, '2025-04-22 12:20:20', '2025-04-22 12:20:20');

-- --------------------------------------------------------

--
-- Table structure for table `sale_table`
--

DROP TABLE IF EXISTS `sale_table`;
CREATE TABLE IF NOT EXISTS `sale_table` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `sale_id` bigint UNSIGNED NOT NULL,
  `table_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sale_table_sale_id_foreign` (`sale_id`),
  KEY `sale_table_table_id_foreign` (`table_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sale_table`
--

INSERT INTO `sale_table` (`id`, `sale_id`, `table_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 2, NULL, NULL),
(3, 3, 2, NULL, NULL),
(4, 4, 2, NULL, NULL),
(5, 5, 2, NULL, NULL),
(6, 6, 2, NULL, NULL),
(7, 7, 1, NULL, NULL),
(8, 7, 2, NULL, NULL),
(9, 8, 2, NULL, NULL),
(10, 9, 1, NULL, NULL),
(11, 10, 1, NULL, NULL),
(12, 11, 2, NULL, NULL),
(13, 12, 1, NULL, NULL),
(14, 13, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

DROP TABLE IF EXISTS `tables`;
CREATE TABLE IF NOT EXISTS `tables` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `manager_id` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tables_manager_id_foreign` (`manager_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `name`, `slug`, `status`, `created_at`, `updated_at`, `manager_id`) VALUES
(1, 'Table1', 'table1', 1, '2025-04-16 16:24:45', '2025-04-16 16:24:45', 2),
(2, 'Table2', 'table2', 1, '2025-04-16 16:24:55', '2025-04-16 16:24:55', 2),
(3, 'Table3', 'table3', 0, '2025-04-16 16:25:06', '2025-04-16 16:25:06', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_id_foreign` (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ayoub', 'admin@restobladi.com', NULL, '$2y$10$C08rQTkWowF1Bwo8PVkCaOCcpf/zuOElYHA99dBMOEzHImbdi//yy', 1, NULL, '2025-04-16 14:32:08', '2025-04-16 14:32:08'),
(2, 'Hassan', 'hassan@gmail.com', NULL, '$2y$10$KxGsKxiJYqflK5VziKWp9.tOdZwaiaGsANwpSaz89bCes1HzLejIi', 2, NULL, '2025-04-16 14:39:38', '2025-04-16 14:39:38'),
(3, 'Hamza', 'hamza@gmail.com', NULL, '$2y$10$IB1Urrn3nkCYqyHTKiKR7.O13OI6K9P8ve5VEupheMXkUtxQ3to5q', 2, NULL, '2025-04-16 14:42:06', '2025-04-16 14:42:06'),
(4, 'Aarbi', 'Aarbi@gmail.com', NULL, '$2y$10$9fZTMqUW6mTc8/ID0lPMGuIOvVnpkx5uUWkgO11EqDtg1jisUQd8m', 3, NULL, '2025-04-16 16:20:38', '2025-04-23 07:27:00'),
(5, 'Moukhtari', 'moukhtari@gmail.com', NULL, '$2y$10$H6SVuqm8LS0ERvEfj9H8M.se73TCqxvD6O/2RTrUh.PcV86MWO8rK', 3, NULL, '2025-04-16 16:22:48', '2025-04-16 16:22:48');

-- --------------------------------------------------------

--
-- Table structure for table `waiters`
--

DROP TABLE IF EXISTS `waiters`;
CREATE TABLE IF NOT EXISTS `waiters` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `phone_number` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `manager_id` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `waiters_user_id_foreign` (`user_id`),
  KEY `waiters_manager_id_foreign` (`manager_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `waiters`
--

INSERT INTO `waiters` (`id`, `phone_number`, `status`, `created_at`, `updated_at`, `user_id`, `manager_id`) VALUES
(1, '0673784756', 0, '2025-04-16 16:20:38', '2025-04-23 07:27:00', 4, 2),
(2, '0746453645', 1, '2025-04-16 16:22:48', '2025-04-16 16:27:59', 5, 2);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
