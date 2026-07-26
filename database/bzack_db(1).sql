-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Jul 25, 2026 at 01:07 PM
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
-- Database: `bzack_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 2, '2026-07-16 02:48:57', '2026-07-16 02:48:57'),
(2, 1, '2026-07-21 14:02:27', '2026-07-21 14:02:27');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(19, 1, 7, 2, 82.00, '2026-07-24 13:41:51', '2026-07-24 15:16:00'),
(20, 1, 1, 3, 1299.00, '2026-07-24 13:41:55', '2026-07-24 14:46:49'),
(21, 1, 3, 1, 3499.00, '2026-07-24 14:36:28', '2026-07-24 14:36:28'),
(22, 1, 8, 3, 82.00, '2026-07-24 14:46:26', '2026-07-24 14:46:40');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'T-Shirts', 't-shirts', 'Casual and stylish t-shirts', 'categories/2zltV50Nvhb2CVSM3FWZZOCk21PgBAbvXu71pXhO.jpg', 1, '2026-07-12 09:10:25', '2026-07-13 03:52:06'),
(2, 'Hoodies', 'hoodies', 'Premium quality hoodies', 'categories/NrNDTjmaYIKrwaq222GoabMGZgbmPtnrB5hhMogu.jpg', 1, '2026-07-12 09:10:25', '2026-07-13 03:52:22'),
(3, 'Jeans', 'jeans', 'Trendy denim jeans', 'categories/lyhmnhpeqWCgkak8RSeUlZU9mpNzUwFmYK8AUV49.jpg', 1, '2026-07-12 09:10:25', '2026-07-13 03:52:38'),
(4, 'Jackets', 'jackets', 'Stylish jackets for all seasons', 'categories/C1stpJRQ4wX11NVG0K3RQLnKQz7rQ3hWBYve3CAG.jpg', 1, '2026-07-12 09:10:26', '2026-07-13 03:51:26'),
(5, 'Shorts', 'shorts', 'Comfortable casual shorts', 'categories/Wwble8h4afCbQtjeNz7lVkS0x1y1z3yF8lsY4GWM.jpg', 1, '2026-07-12 09:10:26', '2026-07-13 03:51:38'),
(6, 'Accessories', 'accessories', 'Caps, belts and more', 'categories/OJ0Sc66uAZUZKllI6iviM3Qo3c5EzAnuCGzhjrJe.jpg', 1, '2026-07-12 09:10:26', '2026-07-13 03:51:50');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 'knldnd', 'Q@gmail.com', 'njfnewjef', 'ytyt', 1, '2026-07-12 09:45:25', '2026-07-12 09:46:29');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` enum('percentage','fixed') NOT NULL DEFAULT 'percentage',
  `value` decimal(10,2) NOT NULL,
  `minimum_order` decimal(10,2) NOT NULL DEFAULT 0.00,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `expires_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `value`, `minimum_order`, `usage_limit`, `used_count`, `is_active`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'BZACK10', 'percentage', 10.00, 1000.00, 100, 0, 1, '2025-12-31', '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(2, 'BZACK20', 'percentage', 20.00, 2000.00, 50, 0, 1, '2025-12-31', '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(3, 'FLAT200', 'fixed', 200.00, 1500.00, 200, 0, 1, '2025-12-31', '2026-07-12 09:10:26', '2026-07-12 09:10:26');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `footer_galleries`
--

CREATE TABLE `footer_galleries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `footer_galleries`
--

INSERT INTO `footer_galleries` (`id`, `image`, `status`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'storage/footer-gallery/DdscLWWnJLk5A5cZaq5fk2tHPWi5MiaAou0xNwKD.jpg', 1, 0, '2026-07-16 07:29:49', '2026-07-16 07:59:45'),
(2, 'storage/footer-gallery/6cc1QD3eVaT1HuQtgDdXPTPQmrn8FUKTiUql90hG.jpg', 1, 2, '2026-07-16 08:01:10', '2026-07-16 08:09:38');

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `low_stock_alert` int(11) NOT NULL DEFAULT 5,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `product_id`, `size`, `color`, `quantity`, `low_stock_alert`, `created_at`, `updated_at`) VALUES
(1, 1, 'S', 'Black', 5, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(2, 1, 'S', 'White', 25, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(3, 1, 'S', 'Navy', 42, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(4, 1, 'M', 'Black', 32, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(5, 1, 'M', 'White', 37, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(6, 1, 'M', 'Navy', 25, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(7, 1, 'L', 'Black', 40, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(8, 1, 'L', 'White', 21, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(9, 1, 'L', 'Navy', 30, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(10, 1, 'XL', 'Black', 31, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(11, 1, 'XL', 'White', 5, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(12, 1, 'XL', 'Navy', 34, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(13, 1, 'XXL', 'Black', 30, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(14, 1, 'XXL', 'White', 44, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(15, 1, 'XXL', 'Navy', 39, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(16, 2, 'S', 'Black', 28, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(17, 2, 'S', 'White', 37, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(18, 2, 'M', 'Black', 28, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(19, 2, 'M', 'White', 41, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(20, 2, 'L', 'Black', 23, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(21, 2, 'L', 'White', 10, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(22, 2, 'XL', 'Black', 46, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(23, 2, 'XL', 'White', 11, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(24, 3, 'S', 'Black', 13, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(25, 3, 'S', 'Grey', 29, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(26, 3, 'S', 'Olive', 46, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(27, 3, 'M', 'Black', 13, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(28, 3, 'M', 'Grey', 5, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(29, 3, 'M', 'Olive', 17, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(30, 3, 'L', 'Black', 30, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(31, 3, 'L', 'Grey', 43, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(32, 3, 'L', 'Olive', 11, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(33, 3, 'XL', 'Black', 22, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(34, 3, 'XL', 'Grey', 32, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(35, 3, 'XL', 'Olive', 33, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(36, 3, 'XXL', 'Black', 38, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(37, 3, 'XXL', 'Grey', 30, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(38, 3, 'XXL', 'Olive', 35, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(39, 4, '28', 'Blue', 11, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(40, 4, '28', 'Black', 31, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(41, 4, '28', 'Grey', 8, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(42, 4, '30', 'Blue', 7, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(43, 4, '30', 'Black', 46, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(44, 4, '30', 'Grey', 29, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(45, 4, '32', 'Blue', 35, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(46, 4, '32', 'Black', 27, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(47, 4, '32', 'Grey', 12, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(48, 4, '34', 'Blue', 10, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(49, 4, '34', 'Black', 36, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(50, 4, '34', 'Grey', 32, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(51, 4, '36', 'Blue', 5, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(52, 4, '36', 'Black', 29, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(53, 4, '36', 'Grey', 12, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(54, 5, 'S', 'Black', 11, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(55, 5, 'S', 'Olive', 30, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(56, 5, 'S', 'Brown', 33, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(57, 5, 'M', 'Black', 9, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(58, 5, 'M', 'Olive', 23, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(59, 5, 'M', 'Brown', 11, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(60, 5, 'L', 'Black', 48, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(61, 5, 'L', 'Olive', 10, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(62, 5, 'L', 'Brown', 14, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(63, 5, 'XL', 'Black', 20, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(64, 5, 'XL', 'Olive', 39, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(65, 5, 'XL', 'Brown', 42, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(66, 6, 'S', 'Khaki', 32, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(67, 6, 'S', 'Black', 10, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(68, 6, 'S', 'Olive', 22, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(69, 6, 'M', 'Khaki', 32, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(70, 6, 'M', 'Black', 12, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(71, 6, 'M', 'Olive', 29, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(72, 6, 'L', 'Khaki', 49, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(73, 6, 'L', 'Black', 25, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(74, 6, 'L', 'Olive', 29, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(75, 6, 'XL', 'Khaki', 28, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(76, 6, 'XL', 'Black', 22, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(77, 6, 'XL', 'Olive', 36, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(78, 6, 'XXL', 'Khaki', 40, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(79, 6, 'XXL', 'Black', 8, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(80, 6, 'XXL', 'Olive', 33, 5, '2026-07-12 09:10:26', '2026-07-12 09:10:26'),
(81, 7, 'Numquam ratione vita', 'Possimus nulla fuga', 0, 5, '2026-07-13 03:49:35', '2026-07-13 03:49:35'),
(82, 8, 'Aut doloribus in eni', 'Anim ut corrupti qu', 0, 5, '2026-07-13 03:51:03', '2026-07-13 03:51:03');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_28_071126_create_personal_access_tokens_table', 1),
(5, '2026_06_28_071236_create_categories_table', 1),
(6, '2026_06_28_071326_create_products_table', 1),
(7, '2026_06_28_071339_create_orders_table', 1),
(8, '2026_06_28_071349_create_order_items_table', 1),
(9, '2026_06_28_071401_create_payments_table', 1),
(10, '2026_06_28_071421_create_inventory_table', 1),
(11, '2026_06_28_071431_create_reviews_table', 1),
(12, '2026_06_28_071719_create_coupons_table', 1),
(13, '2026_07_11_072721_create_password_reset_tokens_table', 1),
(14, '2026_07_12_120909_create_contact_messages_table', 1),
(19, '2026_07_15_155232_create_carts_table', 2),
(20, '2026_07_15_155234_create_cart_items_table', 2),
(21, '2026_07_16_090415_create_newsletter_subscribers_table', 3),
(22, '2026_07_16_112837_create_footer_galleries_table', 4),
(23, '2026_07_21_101804_create_wishlists_table', 5),
(24, '2026_07_21_135714_add_transaction_id_to_orders_table', 6),
(25, '2026_07_21_184343_alter_payments_table_add_bank_and_verification_fields', 7),
(26, '2026_07_22_135335_add_proof_image_to_payments_table', 8),
(27, '2026_07_22_192512_add_proof_image_to_payments_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscribers`
--

CREATE TABLE `newsletter_subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `newsletter_subscribers`
--

INSERT INTO `newsletter_subscribers` (`id`, `email`, `created_at`, `updated_at`) VALUES
(1, 'muhammad922222222abx@gmail.com', '2026-07-16 05:43:46', '2026-07-16 05:43:46');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'pending',
  `subtotal` decimal(10,2) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'cod',
  `payment_status` enum('pending','paid','failed','refunded') DEFAULT 'pending',
  `transaction_id` varchar(255) DEFAULT NULL,
  `coupon_code` varchar(255) DEFAULT NULL,
  `shipping_address` text NOT NULL,
  `shipping_city` varchar(255) NOT NULL,
  `shipping_phone` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL,
  `whatsapp_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_number`, `status`, `subtotal`, `discount`, `shipping`, `total`, `payment_method`, `payment_status`, `transaction_id`, `coupon_code`, `shipping_address`, `shipping_city`, `shipping_phone`, `notes`, `whatsapp_number`, `created_at`, `updated_at`) VALUES
(1, 2, 'BZK-KSJTKTLC', 'shipped', 24121.00, 0.00, 0.00, 24121.00, 'cod', 'pending', NULL, NULL, 'jnkakjdjsak, jkwehhudw, hjefwfhe, jkndjkd', 'jkhdffhd', '889924983249832498', 'jbfdsjhds', NULL, '2026-07-22 08:32:58', '2026-07-22 08:37:14'),
(2, 2, 'BZK-QBD1YPAK', 'pending', 288.00, 0.00, 0.00, 288.00, 'jazzcash', 'pending', NULL, NULL, 'hqdhdewhk, 7547547, ygreyge, tyty', 'hueduhwe', '438484848', 'dwcdcww', NULL, '2026-07-22 13:49:11', '2026-07-23 09:19:46'),
(3, 1, 'BZK-VYHK2X3Y', 'pending', 999.00, 0.00, 0.00, 999.00, 'bank', 'pending', NULL, NULL, 'Obcaecati sequi reru, Blanditiis vero cons, Quod exercitation pr, Est autem sunt minim', 'Sunt exercitation v', '+1 (808) 564-1121', 'Quia est doloribus', NULL, '2026-07-22 13:50:56', '2026-07-22 13:50:56'),
(4, 2, 'BZK-0KDXJXBT', 'pending', 2894.00, 0.00, 0.00, 2894.00, 'jazzcash', 'pending', NULL, NULL, 'hudwqhdwqiuhudwqi, j222, Punjab, Pakistan', 'jwqwjswqw', '12299i2', 'good', NULL, '2026-07-22 14:08:52', '2026-07-22 14:08:52'),
(5, 2, 'BZK-BHUCNJDL', 'processing', 480.00, 0.00, 0.00, 480.00, 'jazzcash', 'failed', NULL, NULL, 'dwdfff, fewfdwfw, fefg, efwefw', 'dfdfdf', '123', 'ffwwffe', NULL, '2026-07-22 14:34:05', '2026-07-23 09:20:17'),
(6, 2, 'BZK-YASFMDYU', 'pending', 12275.00, 0.00, 0.00, 12275.00, 'jazzcash', 'pending', NULL, NULL, 'jnkncsncsdsjn, 555, punjab, pk', 'jcdscdsjk', '329i290392', 'bjdwbjwdeuheu', NULL, '2026-07-23 08:20:59', '2026-07-23 08:20:59'),
(7, 2, 'BZK-CSYGOV8R', 'pending', 96.00, 0.00, 0.00, 96.00, 'jazzcash', 'pending', NULL, NULL, '343434, 3323, Punjab, pk', '12132124', '32432423', 'jsqjwq', NULL, '2026-07-23 08:38:26', '2026-07-23 08:38:26'),
(8, 2, 'BZK-BSBSYKH1', 'pending', 96.00, 0.00, 0.00, 96.00, 'jazzcash', 'pending', NULL, NULL, 'CANTT, 51200675q, tguwqdhg, jeje', 'Multan', '43445348737843987', NULL, NULL, '2026-07-23 08:54:45', '2026-07-23 08:54:45'),
(9, 2, 'BZK-SNQSPHH5', 'cancelled', 1287.00, 0.00, 0.00, 1287.00, 'bank', 'pending', NULL, NULL, 'ewdoijdwji, sdj, jwdq, qndskmqs', 'dn', '3235', NULL, NULL, '2026-07-23 09:07:56', '2026-07-24 17:56:52');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `size` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `size`, `color`, `quantity`, `price`, `total`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 'Totam assumenda iust', NULL, NULL, 8, 84.00, 672.00, '2026-07-22 08:32:58', '2026-07-22 08:32:58'),
(2, 1, 3, 'Bzack Premium Hoodie', NULL, NULL, 2, 2999.00, 5998.00, '2026-07-22 08:32:58', '2026-07-22 08:32:58'),
(3, 1, 5, 'Bzack Bomber Jacket', NULL, NULL, 1, 4999.00, 4999.00, '2026-07-22 08:32:58', '2026-07-22 08:32:58'),
(4, 1, 1, 'Bzack Classic Tee', NULL, NULL, 2, 999.00, 1998.00, '2026-07-22 08:32:58', '2026-07-22 08:32:58'),
(5, 1, 8, 'In occaecat laboris', NULL, NULL, 7, 54.00, 378.00, '2026-07-22 08:32:58', '2026-07-22 08:32:58'),
(6, 1, 7, 'Quo elit odit tempo', NULL, NULL, 5, 96.00, 480.00, '2026-07-22 08:32:58', '2026-07-22 08:32:58'),
(7, 1, 4, 'Bzack Slim Fit Jeans', NULL, NULL, 2, 2999.00, 5998.00, '2026-07-22 08:32:58', '2026-07-22 08:32:58'),
(8, 1, 6, 'Bzack Cargo Shorts', NULL, NULL, 2, 1799.00, 3598.00, '2026-07-22 08:32:58', '2026-07-22 08:32:58'),
(9, 2, 7, 'Quo elit odit tempo', NULL, NULL, 3, 96.00, 288.00, '2026-07-22 13:49:11', '2026-07-22 13:49:11'),
(10, 3, 1, 'Bzack Classic Tee', NULL, NULL, 1, 999.00, 999.00, '2026-07-22 13:50:56', '2026-07-22 13:50:56'),
(11, 4, 7, 'Quo elit odit tempo', NULL, NULL, 1, 96.00, 96.00, '2026-07-22 14:08:52', '2026-07-22 14:08:52'),
(12, 4, 1, 'Bzack Classic Tee', NULL, NULL, 1, 999.00, 999.00, '2026-07-22 14:08:52', '2026-07-22 14:08:52'),
(13, 4, 6, 'Bzack Cargo Shorts', NULL, NULL, 1, 1799.00, 1799.00, '2026-07-22 14:08:52', '2026-07-22 14:08:52'),
(14, 5, 7, 'Quo elit odit tempo', NULL, NULL, 5, 96.00, 480.00, '2026-07-22 14:34:05', '2026-07-22 14:34:05'),
(15, 6, 1, 'Bzack Classic Tee', NULL, NULL, 1, 999.00, 999.00, '2026-07-23 08:20:59', '2026-07-23 08:20:59'),
(16, 6, 6, 'Bzack Cargo Shorts', NULL, NULL, 1, 1799.00, 1799.00, '2026-07-23 08:20:59', '2026-07-23 08:20:59'),
(17, 6, 7, 'Quo elit odit tempo', NULL, NULL, 5, 96.00, 480.00, '2026-07-23 08:20:59', '2026-07-23 08:20:59'),
(18, 6, 4, 'Bzack Slim Fit Jeans', NULL, NULL, 3, 2999.00, 8997.00, '2026-07-23 08:20:59', '2026-07-23 08:20:59'),
(19, 7, 7, 'Quo elit odit tempo', NULL, NULL, 1, 96.00, 96.00, '2026-07-23 08:38:26', '2026-07-23 08:38:26'),
(20, 8, 7, 'Quo elit odit tempo', NULL, NULL, 1, 96.00, 96.00, '2026-07-23 08:54:45', '2026-07-23 08:54:45'),
(21, 9, 7, 'Quo elit odit tempo', NULL, NULL, 3, 96.00, 288.00, '2026-07-23 09:07:56', '2026-07-23 09:07:56'),
(22, 9, 1, 'Bzack Classic Tee', NULL, NULL, 1, 999.00, 999.00, '2026-07-23 09:07:56', '2026-07-23 09:07:56');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `transaction_id` varchar(255) DEFAULT NULL,
  `sender_number` varchar(255) DEFAULT NULL,
  `bank_reference` varchar(255) DEFAULT NULL,
  `proof_image` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `method` enum('cod','online','card','jazzcash','easypaisa','bank') DEFAULT 'cod',
  `status` enum('pending','paid','failed','refunded') DEFAULT 'pending',
  `verified_by` bigint(20) UNSIGNED DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `user_id`, `transaction_id`, `sender_number`, `bank_reference`, `proof_image`, `amount`, `method`, `status`, `verified_by`, `verified_at`, `notes`, `created_at`, `updated_at`) VALUES
(1, 1, 2, NULL, NULL, NULL, NULL, 24121.00, 'cod', 'pending', NULL, NULL, NULL, '2026-07-22 08:32:58', '2026-07-22 08:32:58'),
(2, 2, 2, '123444', '21822148', NULL, NULL, 288.00, 'jazzcash', 'pending', 1, '2026-07-23 09:19:46', NULL, '2026-07-22 13:49:12', '2026-07-23 09:19:46'),
(3, 3, 1, '1333', NULL, '1333', NULL, 999.00, 'bank', 'pending', NULL, NULL, NULL, '2026-07-22 13:50:56', '2026-07-22 13:50:56'),
(4, 4, 2, '1747447332482438', '75735375375', NULL, NULL, 2894.00, 'jazzcash', 'pending', NULL, NULL, NULL, '2026-07-22 14:08:52', '2026-07-22 14:08:52'),
(5, 5, 2, '222', '223443545', NULL, NULL, 480.00, 'jazzcash', 'failed', 1, '2026-07-23 09:20:14', NULL, '2026-07-22 14:34:05', '2026-07-23 09:20:14'),
(6, 6, 2, '132e324', '312424224', NULL, NULL, 12275.00, 'jazzcash', 'pending', NULL, NULL, NULL, '2026-07-23 08:20:59', '2026-07-23 08:20:59'),
(7, 7, 2, '1235445', '122443232535', NULL, 'payment-proofs/EhWoHYVXVz198hqDJBYuJKBdKKkIRcnYJN9bNhBl.jpg', 96.00, 'jazzcash', 'pending', NULL, NULL, NULL, '2026-07-23 08:38:26', '2026-07-23 08:38:28'),
(8, 8, 2, '3244234939324', '93249423439', NULL, 'payment-proofs/jnqspN7YGea8CMClZQI4EyZZs7ePQSPc3vqh2FBz.jpg', 96.00, 'jazzcash', 'pending', NULL, NULL, NULL, '2026-07-23 08:54:45', '2026-07-23 08:54:46'),
(9, 9, 2, 'jjdsd', NULL, 'jjdsd', 'payment-proofs/k6Bf7UBtDaVLRWjvQJfupkeLsn1wYvnZpTQNOV2x.jpg', 1287.00, 'bank', 'pending', 1, '2026-07-24 17:56:52', NULL, '2026-07-23 09:07:56', '2026-07-24 17:56:52');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 1, 'bzack_token', '3d7bd5055676c8f392ecdf440995a4dac1b6f6b2cb7938ddaa9d84a3c0c5e279', '[\"*\"]', '2026-07-13 03:54:50', NULL, '2026-07-12 09:11:12', '2026-07-13 03:54:50'),
(2, 'App\\Models\\User', 1, 'bzack_token', '15c8e8b4d3b982328a56e06c5a354a04c4544ace4206c60bd1c9b24cac227432', '[\"*\"]', '2026-07-23 09:10:02', NULL, '2026-07-13 03:45:56', '2026-07-23 09:10:02'),
(3, 'App\\Models\\User', 2, 'bzack_token', 'caebc3a31cb598c53c25cc687bbbdcd942d52e60e08832a85f2d3c8ccfe09f14', '[\"*\"]', NULL, NULL, '2026-07-16 02:36:37', '2026-07-16 02:36:37'),
(4, 'App\\Models\\User', 2, 'bzack_token', 'f72e47ac21a6884ad93c35f2c480ae0dc9e0bb54c15f871f573f2524ee1b0047', '[\"*\"]', NULL, NULL, '2026-07-16 02:36:48', '2026-07-16 02:36:48'),
(5, 'App\\Models\\User', 2, 'bzack_token', 'a971c69392252ac55aac971fa2aaa60fbf87cf65071d49340d8861229602d5de', '[\"*\"]', '2026-07-24 13:27:49', NULL, '2026-07-16 02:48:53', '2026-07-24 13:27:49'),
(6, 'App\\Models\\User', 1, 'bzack_token', '270a0866611e58da7831ad0c2e1410980df6e4bd1f16b7620bcf91b608a7600a', '[\"*\"]', '2026-07-24 18:12:06', NULL, '2026-07-16 06:14:11', '2026-07-24 18:12:06'),
(7, 'App\\Models\\User', 1, 'bzack_token', 'b265836ce6cf7a75c7582b808fee8dcb60a8e0b6efbca2a8d8bc6ff6b1cc4fa7', '[\"*\"]', '2026-07-23 08:57:34', NULL, '2026-07-21 14:02:18', '2026-07-23 08:57:34'),
(8, 'App\\Models\\User', 1, 'test', 'e94c17b5e860826ba72fc6ec377227a6d00606e155dd195d8fe569e9848a9f27', '[\"*\"]', NULL, NULL, '2026-07-22 08:10:35', '2026-07-22 08:10:35'),
(9, 'App\\Models\\User', 1, 'bzack_token', 'a01d8dab24f2f721c1ef749a362395186520140582b8556eb14d4eec0acbd123', '[\"*\"]', '2026-07-23 10:05:48', NULL, '2026-07-23 09:10:20', '2026-07-23 10:05:48'),
(10, 'App\\Models\\User', 2, 'bzack_token', 'a23cdf4f08cf425f1ad825707c7d1d1edd6d2d13c453b706c869939d0f50ef10', '[\"*\"]', NULL, NULL, '2026-07-24 13:28:03', '2026-07-24 13:28:03'),
(11, 'App\\Models\\User', 2, 'bzack_token', '07621437bad436e8435aff61212b974af1ec28155b192ddac256904d19ba448e', '[\"*\"]', '2026-07-24 13:30:07', NULL, '2026-07-24 13:28:20', '2026-07-24 13:30:07'),
(12, 'App\\Models\\User', 2, 'bzack_token', '91d7a665b1f8dc3aef5e8640fa7bf173a16c98811119c115bd9a546dd8668208', '[\"*\"]', NULL, NULL, '2026-07-24 13:31:50', '2026-07-24 13:31:50'),
(13, 'App\\Models\\User', 2, 'bzack_token', '22ecfe30ed4d87471a68646ace71caa44232f072ead7cb96e39c3fd5214cf35f', '[\"*\"]', NULL, NULL, '2026-07-24 13:32:22', '2026-07-24 13:32:22'),
(15, 'App\\Models\\User', 2, 'bzack_token', 'bcccdace7ce3ff9948614ccbb1e52995897ee05a9b2c435bb223391388eda373', '[\"*\"]', '2026-07-24 15:50:07', NULL, '2026-07-24 14:20:56', '2026-07-24 15:50:07');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `sizes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`sizes`)),
  `colors` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`colors`)),
  `images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`images`)),
  `sku` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_new` tinyint(1) NOT NULL DEFAULT 0,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `short_description`, `price`, `sale_price`, `sizes`, `colors`, `images`, `sku`, `is_active`, `is_featured`, `is_new`, `meta_title`, `meta_description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Bzack Classic Tee', 'bzack-classic-tee-RBkEm', 'Made from 100% premium cotton for ultimate comfort', 'Premium cotton classic t-shirt', 1299.00, 999.00, '[\"S\",\"M\",\"L\",\"XL\",\"XXL\"]', '[\"Black\",\"White\",\"Navy\"]', '[\"products\\/38Zv9PqW4RLnTqrxSDmfcichwZgTWUF8V1wW7snq.jpg\",\"products\\/ArQEEHLeHA1HeQY1CZHoJWL58yo8hNUjcM20yRCG.jpg\"]', 'BZK-TEE-001', 1, 1, 1, 'Bzack Classic Tee | Bzack', NULL, '2026-07-12 09:10:26', '2026-07-13 03:52:59'),
(2, 3, 'Totam assumenda iust', 'bzack-graphic-tee-dMh0E', 'Alias aut non nihil', 'Proident odio non o', 60.00, 84.00, '[\"Consectetur invento\"]', '[\"Ratione minima reici\"]', '[\"products\\/PturMpzj4dpUDbIbGiSKvQL5sp43xz1MOAR9gQjZ.jpg\"]', 'Consequatur repudian', 1, 1, 1, 'Bzack Graphic Tee | Bzack', NULL, '2026-07-12 09:10:26', '2026-07-13 03:53:09'),
(3, 2, 'Bzack Premium Hoodie', 'bzack-premium-hoodie-O4sEi', 'Ultra soft heavyweight fleece for maximum warmth', 'Heavyweight fleece hoodie', 3499.00, 2999.00, '[\"S\",\"M\",\"L\",\"XL\",\"XXL\"]', '[\"Black\",\"Grey\",\"Olive\"]', '[\"products\\/mEKfd7krSeqk8a0bqpIVQEwlIf0zq4UrmA18VFQk.jpg\"]', 'BZK-HOD-001', 1, 1, 0, 'Bzack Premium Hoodie | Bzack', NULL, '2026-07-12 09:10:26', '2026-07-13 03:53:25'),
(4, 3, 'Bzack Slim Fit Jeans', 'bzack-slim-fit-jeans-1hZSU', 'Modern slim fit cut in premium stretch denim', 'Premium slim fit denim jeans', 2999.00, NULL, '[\"28\",\"30\",\"32\",\"34\",\"36\"]', '[\"Blue\",\"Black\",\"Grey\"]', '[\"products\\/djv0UNN08mD3CE8lOtYm0v8XsmSSPPH7aXAZyBXJ.jpg\"]', 'BZK-JNS-001', 1, 1, 1, 'Bzack Slim Fit Jeans | Bzack', NULL, '2026-07-12 09:10:26', '2026-07-13 03:54:40'),
(5, 4, 'Bzack Bomber Jacket', 'bzack-bomber-jacket-AlYgi', 'Premium quality bomber jacket for all seasons', 'Classic bomber jacket', 5999.00, 4999.00, '[\"S\",\"M\",\"L\",\"XL\"]', '[\"Black\",\"Olive\",\"Brown\"]', '[\"products\\/3Yd5797MUylfPeI8Dx7atUR5HEp8M6kLieHv1PP5.jpg\"]', 'BZK-JKT-001', 1, 1, 1, 'Bzack Bomber Jacket | Bzack', NULL, '2026-07-12 09:10:26', '2026-07-13 03:54:05'),
(6, 5, 'Bzack Cargo Shorts', 'bzack-cargo-shorts-c6sK4', 'Multi-pocket cargo shorts for everyday wear', 'Comfortable cargo shorts', 1799.00, NULL, '[\"S\",\"M\",\"L\",\"XL\",\"XXL\"]', '[\"Khaki\",\"Black\",\"Olive\"]', '[\"products\\/4K7LiUhABjYITd03snVnGp0avf7vA4cRI43WzKKB.jpg\"]', 'BZK-SHT-001', 1, 1, 1, 'Bzack Cargo Shorts | Bzack', NULL, '2026-07-12 09:10:26', '2026-07-13 03:54:49'),
(7, 3, 'Quo elit odit tempo', 'quo-elit-odit-tempo-NC9TA', 'Quis esse consectet', 'Commodi sunt qui nul', 82.00, 96.00, '[\"Numquam ratione vita\"]', '[\"Possimus nulla fuga\"]', '[\"products\\/n66eOlQBijnS4u1g0CuKLtzfx2p7bfs7LsEV76wV.jpg\"]', 'Cum minim aut quam a', 1, 1, 1, NULL, NULL, '2026-07-13 03:49:35', '2026-07-13 03:49:35'),
(8, 5, 'In occaecat laboris', 'in-occaecat-laboris-UglFH', 'Omnis ut cumque nobi', 'Error recusandae Se', 82.00, 54.00, '[\"Aut doloribus in eni\"]', '[\"Anim ut corrupti qu\"]', '[\"products\\/jKUa3i8hVXQrpdooHQ2TFZqR0y0HTSHHwVbleyT8.jpg\"]', 'Voluptas illo volupt', 1, 1, 1, NULL, NULL, '2026-07-13 03:51:03', '2026-07-13 03:51:03');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `title` varchar(255) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('customer','admin') NOT NULL DEFAULT 'customer',
  `avatar` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT 'Pakistan',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role`, `avatar`, `address`, `city`, `country`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Bzack Admin', 'admin@bzack.com', '03001234567', '$2y$12$U.N1l5NMYUzAxFAjzS6bPuqCfZPj0OYQTIQBdVOQgXTaeVwRTnU5K', 'admin', NULL, NULL, NULL, 'Pakistan', NULL, NULL, '2026-07-12 09:10:25', '2026-07-12 09:10:25'),
(2, 'Syed Muhammad Abdullah Shahid', 'muhammad92222@gmail.com', '03134356288', '$2y$12$jWaDefKn4B5Rn0W1V35.HuZj00.IosVuiu10vHnYcqQdjyaI0LydW', 'customer', NULL, NULL, NULL, 'Pakistan', NULL, NULL, '2026-07-16 02:36:37', '2026-07-16 02:36:37');

-- --------------------------------------------------------

--
-- Table structure for table `wishlists`
--

CREATE TABLE `wishlists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wishlists`
--

INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(4, 2, 8, '2026-07-24 15:09:20', '2026-07-24 15:09:20'),
(5, 2, 7, '2026-07-24 15:09:34', '2026-07-24 15:09:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `carts_user_id_unique` (`user_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cart_items_cart_id_product_id_unique` (`cart_id`,`product_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `footer_galleries`
--
ALTER TABLE `footer_galleries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_product_id_foreign` (`product_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `newsletter_subscribers_email_unique` (`email`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_order_id_foreign` (`order_id`),
  ADD KEY `payments_user_id_foreign` (`user_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `wishlists_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `wishlists_product_id_foreign` (`product_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `footer_galleries`
--
ALTER TABLE `footer_galleries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `newsletter_subscribers`
--
ALTER TABLE `newsletter_subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `wishlists`
--
ALTER TABLE `wishlists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `wishlists`
--
ALTER TABLE `wishlists`
  ADD CONSTRAINT `wishlists_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `wishlists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
