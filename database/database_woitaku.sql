-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 05, 2024 at 10:52 AM
-- Server version: 8.0.30
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `woitakudb`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `handle_expired_transaction_detailcompetition` ()   BEGIN
    -- Update transactions to 'expired' status where expiration_time is past
    UPDATE transaction
    SET transaction_status = 'check'
    WHERE transaction_status = 'pending' AND expiration_time < NOW();

    -- Revert ticket_qty for expired transactions
    UPDATE detail_competition AS dc
    INNER JOIN transaction AS t ON dc.id = t.id_competition
    SET dc.participant_qty = dc.participant_qty + t.qty
    WHERE t.transaction_status = 'expired';

    -- Clean up expired transactions if needed
DELETE FROM transaction WHERE transaction_status = 'expired';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `handle_expired_transaction_detailevent` ()   BEGIN
    -- Update transactions to 'expired' status where expiration_time is past
    UPDATE transaction
    SET transaction_status = 'check'
    WHERE transaction_status = 'pending' AND expiration_time < NOW();

    -- Revert ticket_qty for expired transactions
    UPDATE detail_event AS de
    INNER JOIN transaction AS t ON de.id = t.id_event
    SET de.ticket_qty = de.ticket_qty + t.qty
    WHERE t.transaction_status = 'expired';

    -- Clean up expired transactions if needed
DELETE FROM transaction WHERE transaction_status = 'expired';
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_availability_status_boothrental` ()   BEGIN
    -- Update transactions to 'expired' status where expiration_time is past
    UPDATE transaction
    SET transaction_status = 'expired'
    WHERE transaction_status = 'check' AND expiration_time < NOW();

    -- Revert availability_status for expired transactions
    UPDATE booth_rental AS br
    INNER JOIN transaction AS t ON br.id = t.id_booth_rental
    SET br.availability_status = 'available'
    WHERE t.transaction_status = 'expired';

    -- Clean up expired transactions if needed
    DELETE FROM transaction WHERE transaction_status = 'expired';
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `booth_rental`
--

CREATE TABLE `booth_rental` (
  `id` bigint UNSIGNED NOT NULL,
  `id_event` bigint UNSIGNED NOT NULL,
  `booth_code` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `booth_size` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `provided_facilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rental_price` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `availability_status` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_category` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `booth_rental`
--

INSERT INTO `booth_rental` (`id`, `id_event`, `booth_code`, `booth_size`, `provided_facilities`, `rental_price`, `availability_status`, `id_category`, `created_at`, `updated_at`) VALUES
(24, 54, 'AA-0001', '3x3 meter', '\"<ol style=\\\"border:0px solid rgb(217,217,227);list-style:none;margin:1.25em 0px;padding:0px;\\\"><li style=\\\"border:0px solid rgb(217,217,227);margin-bottom:0px;margin-top:0px;padding-left:0.375em;min-height:28px;\\\"><p style=\\\"border:0px solid rgb(217,217,227);margin-right:0px;margin-bottom:0px;margin-left:0px;\\\">1. Mendapatkan 3 tiket masuk tambahan untuk pegawai booth<\\/p><p style=\\\"border:0px solid rgb(217,217,227);margin-right:0px;margin-bottom:0px;margin-left:0px;\\\">2. Mendapatkan pasokan listrik yang diperlukan<\\/p><p style=\\\"border:0px solid rgb(217,217,227);margin-right:0px;margin-bottom:0px;margin-left:0px;\\\">3. Mendapatkan tempat yang strategis sesuai dengan yang diinginkan<\\/p><p style=\\\"border:0px solid rgb(217,217,227);margin-right:0px;margin-bottom:0px;margin-left:0px;\\\">4. Mendapatkan wifi dengan kecepatan 10mbps<\\/p><p style=\\\"border:0px solid rgb(217,217,227);margin-right:0px;margin-bottom:0px;margin-left:0px;\\\">5. Mendapatkan tenda dengan ukuran booth yang sesuai<\\/p><p style=\\\"border:0px solid rgb(217,217,227);margin-right:0px;margin-bottom:0px;margin-left:0px;\\\">6. Mendapatkan papan nama untuk booth<\\/p><\\/li><\\/ol>\"', '500000', 'booked', 3, '2024-01-16 10:19:25', '2024-01-16 12:54:33'),
(25, 54, 'AA-0002', '3x5 meter', '\"<ol style=\\\"margin: 1.25em 0px; border: 0px solid rgb(217, 217, 227); list-style: none; padding: 0px;\\\"><li style=\\\"border: 0px solid rgb(217, 217, 227); margin-bottom: 0px; margin-top: 0px; padding-left: 0.375em; min-height: 28px;\\\"><p style=\\\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: 0px solid rgb(217, 217, 227);\\\">1. Mendapatkan 3 tiket masuk tambahan untuk pegawai booth<\\/p><p style=\\\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: 0px solid rgb(217, 217, 227);\\\">2. Mendapatkan pasokan listrik yang diperlukan<\\/p><p style=\\\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: 0px solid rgb(217, 217, 227);\\\">3. Mendapatkan tempat yang strategis sesuai dengan yang diinginkan<\\/p><p style=\\\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: 0px solid rgb(217, 217, 227);\\\">4. Mendapatkan wifi dengan kecepatan 10mbps<\\/p><p style=\\\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: 0px solid rgb(217, 217, 227);\\\">5. Mendapatkan tenda dengan ukuran booth yang sesuai<\\/p><p style=\\\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: 0px solid rgb(217, 217, 227);\\\">6. Mendapatkan papan nama untuk booth<\\/p><\\/li><\\/ol><p>\\r\\n                                        <\\/p>\"', '1000000', 'available', 3, '2024-01-16 10:23:02', '2024-01-16 10:26:38'),
(26, 56, 'AA-0001', '3x4 meter', '\"<ol style=\\\"margin: 1.25em 0px; border: 0px solid rgb(217, 217, 227); list-style: none; padding: 0px;\\\"><li style=\\\"border: 0px solid rgb(217, 217, 227); margin-bottom: 0px; margin-top: 0px; padding-left: 0.375em; min-height: 28px;\\\"><p style=\\\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: 0px solid rgb(217, 217, 227);\\\">1. Mendapatkan 3 tiket masuk tambahan untuk pegawai booth<\\/p><p style=\\\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: 0px solid rgb(217, 217, 227);\\\">2. Mendapatkan pasokan listrik yang diperlukan<\\/p><p style=\\\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: 0px solid rgb(217, 217, 227);\\\">3. Mendapatkan tempat yang strategis sesuai dengan yang diinginkan<\\/p><p style=\\\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: 0px solid rgb(217, 217, 227);\\\">4. Mendapatkan wifi dengan kecepatan 10mbps<\\/p><p style=\\\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: 0px solid rgb(217, 217, 227);\\\">5. Mendapatkan tenda dengan ukuran booth yang sesuai<\\/p><p style=\\\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: 0px solid rgb(217, 217, 227);\\\">6. Mendapatkan papan nama untuk booth<\\/p><\\/li><\\/ol><p>\\r\\n                                        <\\/p>\"', '500000', 'booked', 3, '2024-01-16 10:50:40', '2024-01-16 10:51:04'),
(27, 59, 'AA-001', '3x3 meter', '\"<ol style=\\\"margin: 1.25em 0px; border: 0px solid rgb(217, 217, 227); list-style: none; padding: 0px;\\\"><li style=\\\"border: 0px solid rgb(217, 217, 227); margin-bottom: 0px; margin-top: 0px; padding-left: 0.375em; min-height: 28px;\\\"><p style=\\\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: 0px solid rgb(217, 217, 227);\\\">1. Mendapatkan 3 tiket masuk tambahan untuk pegawai booth<\\/p><p style=\\\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: 0px solid rgb(217, 217, 227);\\\">2. Mendapatkan pasokan listrik yang diperlukan<\\/p><p style=\\\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: 0px solid rgb(217, 217, 227);\\\">3. Mendapatkan tempat yang strategis sesuai dengan yang diinginkan<\\/p><p style=\\\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: 0px solid rgb(217, 217, 227);\\\">4. Mendapatkan wifi dengan kecepatan 10mbps<\\/p><p style=\\\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: 0px solid rgb(217, 217, 227);\\\">5. Mendapatkan tenda dengan ukuran booth yang sesuai<\\/p><p style=\\\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: 0px solid rgb(217, 217, 227);\\\">6. Mendapatkan papan nama untuk booth<\\/p><\\/li><\\/ol><p>\\r\\n                                        <\\/p>\"', '300000', 'available', 3, '2024-01-16 10:58:29', '2024-01-16 10:58:29'),
(28, 59, 'DD-001', '5x5 meter', '\"<ol style=\\\"margin: 1.25em 0px; border: 0px solid rgb(217, 217, 227); list-style: none; padding: 0px;\\\"><li style=\\\"border: 0px solid rgb(217, 217, 227); margin-bottom: 0px; margin-top: 0px; padding-left: 0.375em; min-height: 28px;\\\"><p style=\\\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: 0px solid rgb(217, 217, 227);\\\">1. Mendapatkan 3 tiket masuk tambahan untuk pegawai booth<\\/p><p style=\\\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: 0px solid rgb(217, 217, 227);\\\">2. Mendapatkan pasokan listrik yang diperlukan<\\/p><p style=\\\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: 0px solid rgb(217, 217, 227);\\\">3. Mendapatkan tempat yang strategis sesuai dengan yang diinginkan<\\/p><p style=\\\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: 0px solid rgb(217, 217, 227);\\\">4. Mendapatkan wifi dengan kecepatan 10mbps<\\/p><p style=\\\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: 0px solid rgb(217, 217, 227);\\\">5. Mendapatkan tenda dengan ukuran booth yang sesuai<\\/p><p style=\\\"margin-right: 0px; margin-bottom: 0px; margin-left: 0px; border: 0px solid rgb(217, 217, 227);\\\">6. Mendapatkan papan nama untuk booth<\\/p><\\/li><\\/ol><p>\\r\\n                                        <\\/p>\"', '1200000', 'available', 3, '2024-01-16 10:58:45', '2024-01-16 10:58:45');

-- --------------------------------------------------------

--
-- Table structure for table `category_transaction`
--

CREATE TABLE `category_transaction` (
  `id` bigint UNSIGNED NOT NULL,
  `category_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category_transaction`
--

INSERT INTO `category_transaction` (`id`, `category_name`, `created_at`, `updated_at`) VALUES
(1, 'Event Ticket', NULL, NULL),
(2, 'Competition Registration', NULL, NULL),
(3, 'Booth Rental', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detail_booth`
--

CREATE TABLE `detail_booth` (
  `id` bigint UNSIGNED NOT NULL,
  `booth_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `thumbnail_booth` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `id_booth_rental` bigint UNSIGNED NOT NULL,
  `id_member` bigint UNSIGNED NOT NULL,
  `booth_description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `booth_image` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_booth`
--

INSERT INTO `detail_booth` (`id`, `booth_name`, `thumbnail_booth`, `id_booth_rental`, `id_member`, `booth_description`, `booth_image`, `created_at`, `updated_at`) VALUES
(20, 'Grandblue Fantasy Co', 'booth_images/1705426020_granblue-fantasy_02.jpg', 26, 43, 'Booth yang menjual berbagai koleksi GBF. Harga mulai dari 15rb aja!', '[\"1705426020_D07vX7nV4AAp7WA.png\",\"1705426020_D07vXlhU8AIl0X2.png\",\"1705426020_EDW1QanUwAABzzz.png\"]', NULL, '2024-01-16 17:27:00');

-- --------------------------------------------------------

--
-- Table structure for table `detail_competition`
--

CREATE TABLE `detail_competition` (
  `id` bigint UNSIGNED NOT NULL,
  `id_event` bigint UNSIGNED NOT NULL,
  `thumbnail_competition` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `competition_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `competition_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `competition_start_date` date NOT NULL,
  `competition_end_date` date NOT NULL,
  `competition_fee` int DEFAULT NULL,
  `participant_qty` int NOT NULL,
  `id_category` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_competition`
--

INSERT INTO `detail_competition` (`id`, `id_event`, `thumbnail_competition`, `competition_name`, `competition_description`, `competition_start_date`, `competition_end_date`, `competition_fee`, `participant_qty`, `id_category`, `created_at`, `updated_at`) VALUES
(44, 54, 'event_organizer/competition/1705401159_cosplay competition.jpg', 'Cosplay Competition', '<p style=\"text-align:justify;\"><b>Teknis Lomba:</b><ol><li style=\"text-align:justify;\">Battle royale solo dan team (max 2 orang)</li><li style=\"text-align:justify;\">Minimal perform di atas panggung 1 menit</li><li style=\"text-align:justify;\">Maksimal perform di atas panggung 6 menit</li><li style=\"text-align:justify;\">Dilarang memakai senajta tajam/pedang asli, bahan yang mudah terbakar</li><li style=\"text-align:justify;\">Apalabila kontenstan menggunakan properta yang mengotori panggung, setelah selesai perform harus segera dibersihkan</li><li style=\"text-align:justify;\">Backman diizinkan</li><li style=\"text-align:justify;\">Keputusan juri mutlak dan tidak dapat diganggu gugat</li></ol></p>\n', '2024-01-20', '2024-01-20', 30000, 99, 2, '2024-01-16 10:32:39', '2024-01-16 10:32:39'),
(45, 56, 'event_organizer/competition/1705401949_Snapinsta.app_413473469_1083924156124935_7435297004242475475_n_1080.jpg', 'MMV/AMV Competition', '<div style=\"text-align:justify;\">Minna-san pasti ga asing dengan AMV/MMV, video musik di mana menggabungkan elemen potongan-potongan klip dari Anime atau Manga ditambah dengan lagu yang keren.<div style=\"text-align:justify;\"><br></div><div style=\"text-align:justify;\">Nah, di SHF 2024 kali ini bakal ada lombanya loh! Yang mengikuti lomba ini nanti berkesempatan untuk ditampilkan MMV/AMVnya selama acara dan ditonton oleh banyak orang!</div><div style=\"text-align:justify;\"><br></div><div style=\"text-align:justify;\">Yuk join dan menangkan hadiahnya! Bagi yang lolos nanti juga akan dapat freepass ke eventnya!</div></div>\n', '2024-01-27', '2024-01-28', 20000, 999, 2, '2024-01-16 10:45:49', '2024-01-16 10:45:49'),
(46, 56, 'event_organizer/competition/1705402163_snapinsta.jpeg', 'J-SONG COMPETITION', '<div style=\"text-align:justify;\">Halo, ini Koharu mainin IGnya Sashimi (&Euml;&micro; &acirc;&#128;&cent;&Igrave;&#128; &aacute;&acute;&#151; - &Euml;&micro; ) &acirc;&#156;&sect; Ayo pada daftar Japanese Song Competitionnya (&acirc;&#136;&copy;&Euml;&#131;o&Euml;&#130;&acirc;&#136;&copy;)&acirc;&#153;&iexcl; semoga sukses ya. Koharu pengen dengerin nyanyiannya temen-temen (&Euml;&para;&aacute;&micro;&#148; &aacute;&micro;&#149; &aacute;&micro;&#148;&Euml;&para;)<div style=\"text-align:justify;\"><br></div><div style=\"text-align:justify;\">Cek websitenya ya untuk pendaftaran dan rules &agrave;&acute;&brvbar;&agrave;&micro;&#141;&agrave;&acute;&brvbar;&agrave;&acute;&iquest; &Euml;&#137;&Iacute;&#136;&Igrave;&#128;&ecirc;&#146;&sup3;&Euml;&#137;&Iacute;&#136;&Igrave;&#129; )&acirc;&#156;&sect;</div></div>\n', '2024-01-27', '2024-01-28', 25000, 100, 2, '2024-01-16 10:49:23', '2024-01-16 10:49:23'),
(47, 59, 'event_organizer/competition/1705403123_Snapinsta.app_416872653_386790547199821_172040110558126162_n_1080.jpg', 'ANICHA! Anisong Challange!', '<div>Siapa nih yang hobinya nyanyi lagu-lagu anisong?<div>kami menantang kalian semua untuk membawakan 1 lagu dari playlist yang sudah kami siapkan!</div><div><br></div><div>Segera daftarkan diri kalian sebelum tanggal 5 Februari 2024</div><div>klik link yang ada di bio kami yaa!</div><div><br></div><div>Syarat pendaftaran dan list lagu ada di formulir ya!</div><div>See ya!!!!</div></div>\n', '2024-03-09', '2024-03-10', 20000, 30, 2, '2024-01-16 11:05:23', '2024-01-16 11:05:23'),
(48, 59, 'event_organizer/competition/1705403178_Snapinsta.app_416599690_385751620637047_25346300212350796_n_1080.jpg', 'IDOLICIOUS COVERDANCE COMPETITION', '<div>Siapa yang udah punya grup nari dan butuh jam terbang?<div>Kita buka pendaftaran nih bagi yang mau tampil di acara ULTICON EXPO 2024 nanti!</div><div><br></div><div>PENDAFTARAN GRATIS!</div><div>Syarat dan ketentuan ada di form pendaftaran ya!</div><div>Klik link yang ada di bio Instagram kami ya!</div><div><br></div><div>Perhatikan syaratnya ya!</div><div>Sampai jumpa~</div></div>\n', '2024-03-09', '2024-03-10', 0, 10, 2, '2024-01-16 11:06:18', '2024-01-16 11:06:18'),
(49, 54, 'event_organizer/competition/1705424836_cosplay competition.jpg', 'J-pop competition', '<p>Menyanyikan lagu jpop</p>\n', '2024-01-20', '2024-01-20', 0, 10, 2, '2024-01-16 17:07:16', '2024-01-16 17:07:16'),
(50, 65, 'event_organizer/competition/1705446008_theme_pdf_single.jpg', 'Darryl Maldonado', '<p>c</p>\n', '2024-01-17', '2024-01-18', 21, 365, 2, '2024-01-16 23:00:09', '2024-01-16 23:00:53');

-- --------------------------------------------------------

--
-- Table structure for table `detail_event`
--

CREATE TABLE `detail_event` (
  `id` bigint UNSIGNED NOT NULL,
  `id_eo` bigint UNSIGNED NOT NULL,
  `event_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `event_description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `city` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ticket_price` int DEFAULT NULL,
  `ticket_qty` int DEFAULT NULL,
  `booth_layout` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `verification` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_category` bigint UNSIGNED NOT NULL,
  `reason_verification` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_event`
--

INSERT INTO `detail_event` (`id`, `id_eo`, `event_name`, `featured_image`, `event_description`, `start_date`, `end_date`, `city`, `address`, `ticket_price`, `ticket_qty`, `booth_layout`, `document`, `verification`, `id_category`, `reason_verification`, `created_at`, `updated_at`) VALUES
(54, 44, 'NEW YEAR CELEBRATION', 'event_organizer/detail_event/1705397942_new-year-celebration.jpg', '<p style=\"text-align:justify;border:0px solid rgb(217,217,227);margin:1.25em 0px;\">Selamat datang di perayaan Tahun Baru yang tak terlupakan, \"New Year Celebration: Jejepangan Extravaganza\"! Bersiaplah untuk merayakan malam pergantian tahun dengan nuansa kebudayaan Jepang yang kaya dan penuh warna. Acara ini dirancang untuk memberikan pengalaman unik yang menggabungkan keindahan tradisional Jepang dengan semangat penuh kegembiraan menyambut tahun yang baru.<p style=\"text-align:justify;border:0px solid rgb(217,217,227);margin-right:0px;margin-bottom:1.25em;margin-left:0px;\"><span style=\"border:0px solid rgb(217,217,227);\"><b>Highlight Acara:</b></span></p><ol style=\"border:0px solid rgb(217,217,227);list-style:none;margin:1.25em 0px;padding:0px;\"><li style=\"border:0px solid rgb(217,217,227);margin-bottom:0px;margin-top:0px;padding-left:0.375em;min-height:28px;\"><ol><li style=\"text-align:justify;border:0px solid rgb(217,217,227);margin-right:0px;margin-bottom:0px;margin-left:0px;\"><span style=\"border:0px solid rgb(217,217,227);\">Sakura Garden Entrance:</span>\r\nTiba di acara dengan melewati pintu masuk yang dihiasi dengan pohon sakura buatan yang mekar, menciptakan atmosfer Jepang yang romantis dan indah.</li><li style=\"text-align:justify;border:0px solid rgb(217,217,227);margin-right:0px;margin-bottom:0px;margin-left:0px;\">Kimono Corner:\r\nJangan lewatkan kesempatan untuk mencoba mengenakan kimono tradisional. Ada sudut khusus yang menyediakan kimono berbagai warna dan desain untuk diabadikan dalam foto Anda.</li><li style=\"text-align:justify;border:0px solid rgb(217,217,227);margin-right:0px;margin-bottom:0px;margin-left:0px;\">Traditional Performances:\r\nNikmati pertunjukan seni tradisional Jepang, termasuk tari Geisha yang elegan, pertunjukan Taiko drum yang menggetarkan, dan pertunjukan kembang api yang memukau.</li><li style=\"text-align:justify;border:0px solid rgb(217,217,227);margin-right:0px;margin-bottom:0px;margin-left:0px;\">Culinary Journey:\r\nMenyelami kelezatan kuliner Jepang dengan stasiun makanan yang menyajikan sushi, ramen, dan berbagai hidangan lezat lainnya. Ada juga bar sake untuk merayakan dengan minuman khas Jepang.</li><li style=\"text-align:justify;border:0px solid rgb(217,217,227);margin-right:0px;margin-bottom:0px;margin-left:0px;\">Anime Corner:\r\nBagi para penggemar anime, ada sudut khusus yang menampilkan maraton anime terpopuler dan area cosplay untuk menunjukkan kostum favorit Anda.</li><li style=\"text-align:justify;border:0px solid rgb(217,217,227);margin-right:0px;margin-bottom:0px;margin-left:0px;\">Countdown to Midnight:\r\nSambut pergantian tahun dengan semangat penuh kegembiraan. Ada penampilan live band yang akan mengiringi Anda memasuki tahun baru dengan suka cita.</li><li style=\"text-align:justify;border:0px solid rgb(217,217,227);margin-right:0px;margin-bottom:0px;margin-left:0px;\">Souvenir Corner:\r\nIngatlah malam spesial ini dengan mengambil souvenir unik dari sudut khusus yang menawarkan barang-barang spesifik Jepang, seperti kerajinan tangan dan pernak-pernik.</li></ol></li></ol><p style=\"text-align:justify;border:0px solid rgb(217,217,227);margin-right:0px;margin-bottom:1.25em;margin-left:0px;\"><span style=\"border:0px solid rgb(217,217,227);\"><b>Dress Code:</b></span>\r\n</p><p style=\"text-align:justify;border:0px solid rgb(217,217,227);margin-right:0px;margin-bottom:1.25em;margin-left:0px;\">Hadir dengan pakaian semi-formal atau kostum tradisional Jepang akan memberikan sentuhan khusus pada pengalaman Anda.</p><p style=\"text-align:justify;border:0px solid rgb(217,217,227);margin-right:0px;margin-bottom:1.25em;margin-left:0px;\"><span style=\"border:0px solid rgb(217,217,227);\"><b>Catatan Penting:</b></span>\r\n</p><p style=\"text-align:justify;border:0px solid rgb(217,217,227);margin-right:0px;margin-bottom:1.25em;margin-left:0px;\">Pastikan untuk melakukan pemesanan tiket sebelumnya, karena tempat terbatas. Semua protokol kesehatan akan diikuti untuk memastikan keamanan semua tamu.</p><p></p></p>\n', '2024-01-20', '2024-01-20', 'Manado', 'MTC Manado', 50000, 1494, 'event_organizer/detail_event/1705426730_denah-horisontal-0000.jpg', 'https://drive.google.com/drive/folders/0BwioWCXXeLVBfi1LcFdydDc2Y3NDTEFHRHh4RERBXzFSRFZhUmhJNVFIWDNDcTRCamNqbUE?resourcekey=0-8JboUjOHmXQ2TWa1DDPWFQ&usp=sharing', 'accepted', 1, 'event kamu sedang dicek terlebih dahulu', '2024-01-16 09:38:10', '2024-01-16 17:38:50'),
(55, 44, 'Gathering Cosplay Medan Road to ICGP', 'event_organizer/detail_event/1705401321_416306082_10224655383880732_7383510535843299240_n.jpg', '<div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin:0.5em 0px 0px;\"><div>Halo Cosmedtizen semuanya!</div><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin:0.5em 0px 0px;\"><div>Tahun ini CosMed kembali akan mengadakan gathering tahunan dimana tahun ini kami akan memfokuskan dan memberitahu kalian semua mengenai apa itu cosplay dan kiat kiat apa saja yang dibutuhkan agar cosplay kalian, terutama jika kalian ingin ikut kompetisi cosplay perform semakin bagus! </div></div><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin:0.5em 0px 0px;\"><div>Nantinya akan ada Workshop dan untuk workshop sendiri kami akan membuat beberapa stand yang terdiri dari :</div><ul><li>Wig Styling, dimana kalian bisa belajar cara styling wig.</li><li>Armor Making, dimana kalian bisa belajar cara buat kostum armor.</li><li>LED Workshop, dimana kalian bisa belajar bagaimana cara memasang LED untuk props/acc/costume kalian.</li><li>Sound Workshop, dimana kalian bisa belajar bagaimana cara membuat sound untuk cosperform.</li><li>Choreography Workshop, dimana kalian bisa belajar gerakan dan koreografi yang bagus untuk perform diatas panggung.</li></ul></div><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin:0.5em 0px 0px;\"><div>Dan tentu saja semuanya akan diajari oleh mentor yang emang berpengalaman dan jago dibidang masing-masing!</div></div><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin:0.5em 0px 0px;\"><div>Selain Workshop yang bisa kalian datangi sesuai dengan minat kalian, di gathering nanti juga akan ada perkenalan, terutama bagi kalian coser coser baru atau yang memiliki tim cosplay, pembahasan mengenai mekanisme penjurian, jenis perlombaan, pembahasan mengenai ICGP, GICOF, dll, serta sesi tanya jawab, serta mini games menarik dengan hadiah yg mantep</div></div><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin:0.5em 0px 0px;\"><div>Jadi tunggu apalagi??</div><div>Marilah menjadi cosplayer yang berilmu!</div></div></div>\n', '2024-01-21', '2024-01-21', 'Medan', 'Manhattan Urban Market, Medan', 0, 0, NULL, 'https://drive.google.com/drive/folders/0BwioWCXXeLVBfi1LcFdydDc2Y3NDTEFHRHh4RERBXzFSRFZhUmhJNVFIWDNDcTRCamNqbUE?resourcekey=0-8JboUjOHmXQ2TWa1DDPWFQ&usp=sharing', 'accepted', 1, 'Event anda diterima tanpa ada kendala', '2024-01-16 10:35:21', '2024-01-16 11:07:24'),
(56, 49, 'SEMILIR HOBBY FEST in the MULTIVERSE', 'event_organizer/detail_event/1705401751_416018608_10224657150284891_2486321684859004417_n.jpg', '<p><div style=\"text-align:justify;\">Hallo minna-san, yang nanya \"Eventnya bakal ada apa aja ni?\"</div><div style=\"text-align:justify;\">Nah ini mimin kasih konten eventnya besok. Ada lomba dubbing yang akan dijuri oleh dubber professional Indonesia, Coscomp dengan juri professional juga, Coswalk 2 DAY! Dan masih banyak lagi kompetisinya.</div><div style=\"text-align:justify;\"><br></div><div style=\"text-align:justify;\">Selain itu, minna-san yang mau membuka booth circle, booth cosplay, booth hobbies, dsb bisa banget nih untuk ikut meramaikan eventnya. Info lebih lanjut terkait booth nanti akan kami update! So stay tune ya~</div><div style=\"text-align:justify;\">Gak kalah seru, ada VTUBER juga nih! Tebak kira-kira siapa hayo?</div></p>\n', '2024-01-27', '2024-01-28', 'Semarang', 'Dusun Semilir, Bawen, Jawa Tengah', 30000, 699, 'event_organizer/detail_event/1705426420_denah-horisontal-0000.jpg', 'https://drive.google.com/drive/folders/0BwioWCXXeLVBfi1LcFdydDc2Y3NDTEFHRHh4RERBXzFSRFZhUmhJNVFIWDNDcTRCamNqbUE?resourcekey=0-8JboUjOHmXQ2TWa1DDPWFQ&usp=sharing', 'accepted', 1, 'Event anda diterima tanpa ada kendala', '2024-01-16 10:42:31', '2024-01-16 17:33:40'),
(57, 49, 'Pinnacle Party Volume 1', 'event_organizer/detail_event/1705402404_416377665_10232783966211304_2488659691378746156_n.jpg', '<p><div>Halo Warga dan wibu Bandung dan sekitarnya.</div><div>Akhir pekan bingung mau ke mana?</div><div>Yuk dateng ke Pinnacle Party!</div><div><br></div><div>Ada apa aja sih?</div><div>- DJ &amp; Music Performance</div><div>- Pinnacle Talks</div><div>- dan masih banyak lagi</div><div><br></div><div>Apa!? Kamu pengen ikutan manggung?</div><div>Atau mau jadi staff, sponsor dan community partner?</div><div>Cuss gabung menjadi bagian dari acara kami~</div></p>\n', '2024-02-17', '2024-02-17', 'Bandung', 'Bandung Creative Hub, Ruang Auditorium', 0, 1000, NULL, 'https://drive.google.com/drive/folders/0BwioWCXXeLVBfi1LcFdydDc2Y3NDTEFHRHh4RERBXzFSRFZhUmhJNVFIWDNDcTRCamNqbUE?resourcekey=0-8JboUjOHmXQ2TWa1DDPWFQ&usp=sharing', 'accepted', 1, 'Event anda diterima tanpa ada kendala', '2024-01-16 10:53:24', '2024-01-16 10:53:30'),
(58, 49, 'HYAKUNEN NO IE MONOGATARI', 'event_organizer/detail_event/1705402513_417795676_10224672681713167_4962307112215282779_n.jpg', '<p><div>\"Selama 100 tahun, aku, rumah ini, menjadi saksi bisu dari riang gembira dan kesedihan. Dinding-dindingku merangkum kisah hidup yang terpahat dengan indah, menjadi penjaga setia sepanjang perjalanan waktu.&acirc;&#128;&#157;</div><div><br></div><div>Hyakunen no Ie Monogatari adalah sebuah drama musikal berbahasa Jepang yang akan membawa Anda menyaksikan perjalanan sebuah keluarga yang melintasi manis-pahitnya kehidupan dan peristiwa-peristiwa penting dalam sejarah Jepang sejak 1924 &acirc;&#128;&#147; 2024.</div><div><br></div><div>Ingin tau kisah selengkapnya?</div><div><br></div><div>Ayo saksikan pementasan kedua SHiN DORAMA PROJECT!!</div></p>\n', '2024-02-17', '2024-02-18', 'Jakarta', 'Teater Salihara, Pasar Minggu, Jakarta Selatan', 200000, 99, NULL, 'https://drive.google.com/drive/folders/0BwioWCXXeLVBfi1LcFdydDc2Y3NDTEFHRHh4RERBXzFSRFZhUmhJNVFIWDNDcTRCamNqbUE?resourcekey=0-8JboUjOHmXQ2TWa1DDPWFQ&usp=sharing', 'accepted', 1, 'Event anda diterima tanpa ada kendala', '2024-01-16 10:55:13', '2024-01-16 10:55:17'),
(59, 51, 'Cocoon Comic Market', 'event_organizer/detail_event/1705402668_416283967_10224656685313267_8712339151429467558_n.jpg', '<div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin:0.5em 0px 0px;\"><div>Cocoon Comic Market is a creative event that celebrates and brings together comic, creative industry, original creation, doujinshi, illustrations, merchandise, anime, and goods from around the world. </div><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin:0.5em 0px 0px;\"><div>Our events are full of energy and enthusiasm, and we offer something for everyone. Whether you&Atilde;&cent;&Acirc;&#128;&Acirc;&#153;re an avid fan of comics or an artist looking to showcase your work, you&Atilde;&cent;&Acirc;&#128;&Acirc;&#153;ll find something that you&Atilde;&cent;&Acirc;&#128;&Acirc;&#153;ll love at Cocoon Comic Market. </div></div><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin:0.5em 0px 0px;\"><div>Join us and explore the amazing world of comics and art!</div></div></div>\n', '2024-02-25', '2024-02-25', 'Jakarta', 'Dian Ballroom, Mall Ciputra, Jakarta', 25000, 497, 'event_organizer/detail_event/1705402668_417740448_10224656685433270_5056383800919501537_n.jpg', 'https://drive.google.com/drive/folders/0BwioWCXXeLVBfi1LcFdydDc2Y3NDTEFHRHh4RERBXzFSRFZhUmhJNVFIWDNDcTRCamNqbUE?resourcekey=0-8JboUjOHmXQ2TWa1DDPWFQ&usp=sharing', 'accepted', 1, 'Event anda diterima tanpa ada kendala', '2024-01-16 10:57:48', '2024-01-16 10:59:50'),
(60, 51, 'HIMAWARI JAPAN FEST 2024', 'event_organizer/detail_event/1705402904_418816389_10224677980285628_9157103718740427037_n.jpg', '<div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin:0.5em 0px 0px;\"><div><div>KONNICHIWA &atilde;&#129;&#147;&atilde;&#130;&#147;&atilde;&#129;&laquo;&atilde;&#129;&iexcl;&atilde;&#129;&macr; </div></div><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin:0.5em 0px 0px;\"><div>HIMAWARI JAPAN FEST 2024 IS COMING IN MARCH!</div></div><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin:0.5em 0px 0px;\"><div>Siapa nih yang udah nungguin Himawari Japan Fest?</div></div><div class=\"x11i5rnm xat24cr x1mh8g0r x1vvkbs xtlvy1s x126k92a\" style=\"margin:0.5em 0px 0px;\"><div>CALLING OUT ALL JAPANESE RELATED BRANDS:</div><div>Japanese FnB, Fashion, Anime Merchandise, Home and Appliances, Tour and Travel, Beauty and Makeup, etc.</div></div></div>\n', '2024-03-07', '2024-03-17', 'Jakarta', 'PIK AVENUE MALL, Jakarta', 50000, 1000, NULL, 'https://drive.google.com/drive/folders/0BwioWCXXeLVBfi1LcFdydDc2Y3NDTEFHRHh4RERBXzFSRFZhUmhJNVFIWDNDcTRCamNqbUE?resourcekey=0-8JboUjOHmXQ2TWa1DDPWFQ&usp=sharing', 'accepted', 1, 'Event anda diterima tanpa ada kendala', '2024-01-16 11:01:44', '2024-01-16 11:01:52'),
(61, 51, 'ULTICON EXPO x ICGP 2024', 'event_organizer/detail_event/1705402987_419915745_10224691784470724_6136710259956088856_n.jpg', '<div>Konten:<div>ICGP 2024</div><div>Idolicious</div><div>Anicha </div><div>Creator Space by StikR Fest</div><div>Weebs Community League </div><div>dll</div></div>\n', '2024-03-09', '2024-03-10', 'Bandung', 'Harris Convention Hall, Festival Citylink Bandung', 15000, 1000, NULL, 'https://drive.google.com/drive/folders/0BwioWCXXeLVBfi1LcFdydDc2Y3NDTEFHRHh4RERBXzFSRFZhUmhJNVFIWDNDcTRCamNqbUE?resourcekey=0-8JboUjOHmXQ2TWa1DDPWFQ&usp=sharing', 'accepted', 1, 'Event anda diterima tanpa ada kendala', '2024-01-16 11:03:07', '2024-01-16 11:03:11'),
(62, 44, 'Road to Bokutachi No Matsuri 4', 'event_organizer/detail_event/1705405836_417703015_10224657263287716_5650304101390637787_n.jpg', '<p><div>HTM:</div><div>Presale 1 Rp 35rb</div><div>OTS : TIDAK ADA tiket OTS</div><div>.</div><div>Konten:</div><div>Cosplay Competition (Senpai)</div><div>Cosplay Competition (Kouhai)</div><div>Cover Sing Competition</div><div>Dll</div></p>\n', '2024-02-25', '2024-02-25', 'Tasikmalaya', 'Trans Studio Mini Tasikmalaya', 35000, 997, NULL, 'https://drive.google.com/drive/folders/0BwioWCXXeLVBfi1LcFdydDc2Y3NDTEFHRHh4RERBXzFSRFZhUmhJNVFIWDNDcTRCamNqbUE?resourcekey=0-8JboUjOHmXQ2TWa1DDPWFQ&usp=sharing', 'accepted', 1, 'Event anda diterima tanpa ada kendala', '2024-01-16 11:50:36', '2024-01-16 11:50:44'),
(63, 44, 'Orchestra Concert Ghibli Chapter 02', 'event_organizer/detail_event/1705406129_412449228_10224600128539383_7126122341540065492_n.jpg', '<p>.</p>\n', '2024-03-09', '2024-03-09', 'Yogyakarta', 'GOR Universitas Negeri Yogya', 120000, 94, NULL, 'https://drive.google.com/drive/folders/0BwioWCXXeLVBfi1LcFdydDc2Y3NDTEFHRHh4RERBXzFSRFZhUmhJNVFIWDNDcTRCamNqbUE?resourcekey=0-8JboUjOHmXQ2TWa1DDPWFQ&usp=sharing', 'accepted', 1, 'Event anda diterima tanpa ada kendala', '2024-01-16 11:55:29', '2024-01-16 11:55:38'),
(64, 44, 'Bunkasai USU', 'event_organizer/detail_event/1705416055_Snapinsta.app_277397008_542591707171612_3822736525517770865_n_1080.jpg', '<p>Bunkasai USU 2024</p>\n', '2024-01-12', '2024-01-14', 'Ambon', 'Universitas Sumatera Utara, Gerbang I', 0, 0, NULL, 'https://drive.google.com/drive/folders/0BwioWCXXeLVBfi1LcFdydDc2Y3NDTEFHRHh4RERBXzFSRFZhUmhJNVFIWDNDcTRCamNqbUE?resourcekey=0-8JboUjOHmXQ2TWa1DDPWFQ&usp=sharing', 'accepted', 1, 'event kamu sedang dicek terlebih dahulu', '2024-01-12 14:40:55', '2024-01-14 14:40:55'),
(65, 44, 'Selma Nieves', 'event_organizer/detail_event/1705436471_534111.png', '<p>Voluptatem, consequa.c</p>\n', '2024-01-17', '2024-01-18', 'Pontianak', 'Dolor nihil tempore', 143, 238, NULL, 'Sunt ut autem labori', 'accepted', 1, 'event kamu sedang dicek terlebih dahulu', '2024-01-16 20:21:11', '2024-01-16 23:00:43'),
(66, 56, 'Adele Molina', 'event_organizer/detail_event/1705453116_finan-akbar-HuC3cii5VA8-unsplash.jpg', '<p>Ad cupiditate doloru.c</p>\n', '2024-01-17', '2024-01-17', 'Bandung', 'Dolorem et sit praes', 86, 816, NULL, 'Odit amet incidunt', 'rejected', 1, 'Tolak', '2024-01-17 00:58:36', '2024-01-17 00:59:41'),
(67, 56, 'Paul Yang', 'event_organizer/detail_event/1705453128_hiroku-yamashiro-5Gahb7KXYeo-unsplash.jpg', '<p>Laboris ratione inci.c</p>\n', '2024-01-17', '2024-01-17', 'Kotamobagu', 'Voluptas neque vel r', 509, 878, NULL, 'Corporis enim duis v', 'revision', 1, '123', '2024-01-17 00:58:48', '2024-01-18 17:31:06'),
(68, 56, 'Adam Baxter', 'event_organizer/detail_event/1705453140_534111.png', '<p>Dolor explicabo. Aut.c</p>\n', '2024-01-17', '2024-01-17', 'Palu', 'Consectetur dolore', 182, 964, NULL, 'Elit velit assumend', 'pending', 1, 'event kamu sedang dicek terlebih dahulu', '2024-01-17 00:59:00', '2024-01-17 00:59:00');

-- --------------------------------------------------------

--
-- Table structure for table `detail_member`
--

CREATE TABLE `detail_member` (
  `id` bigint UNSIGNED NOT NULL,
  `id_member` bigint UNSIGNED NOT NULL,
  `foto_profile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kota` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_whatsapp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_member`
--

INSERT INTO `detail_member` (`id`, `id_member`, `foto_profile`, `address`, `kota`, `nomor_whatsapp`, `created_at`, `updated_at`) VALUES
(8, 43, 'detail_member/1709633540_rose-cat-give-give-rose-to-cat.png', 'Jl. Tuar', 'Medan', '6282167565321', '2024-01-16 02:41:21', '2024-03-05 10:12:20'),
(10, 45, NULL, NULL, NULL, NULL, '2024-01-16 02:44:25', '2024-01-16 02:44:25'),
(11, 46, NULL, NULL, NULL, NULL, '2024-01-16 02:48:17', '2024-01-16 02:48:17'),
(12, 47, NULL, NULL, NULL, NULL, '2024-01-16 03:55:33', '2024-01-16 03:55:33'),
(13, 48, NULL, NULL, NULL, NULL, '2024-01-16 03:55:47', '2024-01-16 03:55:47'),
(15, 50, NULL, NULL, NULL, NULL, '2024-01-16 03:56:20', '2024-01-16 03:56:20'),
(17, 52, NULL, NULL, NULL, NULL, '2024-01-16 03:57:33', '2024-01-16 03:57:33'),
(19, 54, NULL, NULL, NULL, NULL, '2024-01-16 03:58:01', '2024-01-16 03:58:01'),
(20, 55, NULL, NULL, NULL, NULL, '2024-01-16 03:58:21', '2024-01-16 03:58:21'),
(22, 57, NULL, NULL, NULL, NULL, '2024-01-16 03:59:05', '2024-01-16 03:59:05'),
(40, 78, 'detail_member/1709635358_rose-cat-give-give-rose-to-cat.png', 'Jl Sana', 'Ambon', '6282167565321', '2024-03-05 09:54:28', '2024-03-05 10:42:38');

-- --------------------------------------------------------

--
-- Table structure for table `event_organizer`
--

CREATE TABLE `event_organizer` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `foto_profile` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `alamat` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kota` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nomor_whatsapp` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_organizer`
--

INSERT INTO `event_organizer` (`id`, `id_user`, `description`, `foto_profile`, `alamat`, `kota`, `nomor_whatsapp`, `created_at`, `updated_at`) VALUES
(44, 44, 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.', 'event_organizer/profile_photos/1709635760_afda8f9788c42e7ef7d81f5eba5d7e11.jpg', 'Jl. Fokrat Raya', 'Bandung', '628161238612', '2024-01-16 09:15:46', '2024-03-05 10:49:20'),
(45, 49, NULL, NULL, NULL, NULL, NULL, '2024-01-16 09:15:49', NULL),
(46, 51, NULL, NULL, NULL, NULL, NULL, '2024-01-16 09:15:50', NULL),
(47, 53, NULL, NULL, NULL, NULL, NULL, '2024-01-16 09:15:52', NULL),
(48, 56, NULL, NULL, NULL, NULL, NULL, '2024-01-16 09:15:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(7, '2014_10_12_000000_create_users_table', 1),
(8, '2014_10_12_100000_create_password_resets_table', 1),
(9, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(10, '2019_08_19_000000_create_failed_jobs_table', 1),
(11, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(12, '2023_12_05_113427_create_detail_member_table', 1),
(13, '2023_12_05_180710_create_event_organizer_table', 2),
(14, '2023_12_06_052519_create_detail_event_table', 3),
(15, '2023_12_06_104141_create_detail_competition_table', 4),
(16, '2023_12_07_090220_booth_rental_list_table', 5),
(17, '2023_12_07_113520_create_transaction_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('admin@gmail.com', '$2y$10$TuUt2XL9cAJ4hjK8ziX/rOdvSBLSDSPRq8mGRvhrrQbYdCkbGkOmK', '2023-12-07 13:09:54'),
('arifjagad00096@gmail.com', '$2y$10$vZN3R0YeHJhURUayNwcawuqX4QFvW6cqE4CFm29XnRURQ05rqivEO', '2023-12-07 14:26:07');

-- --------------------------------------------------------

--
-- Table structure for table `payment_methods`
--

CREATE TABLE `payment_methods` (
  `id` bigint UNSIGNED NOT NULL,
  `id_eo` bigint UNSIGNED NOT NULL,
  `bank_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `account_number` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `account_holder_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payment_methods`
--

INSERT INTO `payment_methods` (`id`, `id_eo`, `bank_name`, `account_number`, `account_holder_name`, `status`, `created_at`, `updated_at`) VALUES
(16, 44, 'BNI', '18651237', 'ALEXA BISHOP', '1', '2024-01-16 09:46:17', '2024-01-16 21:54:15'),
(17, 49, 'BCA', '71255123', 'IDONA STEPHENSON', '1', '2024-01-16 10:44:10', '2024-01-16 10:44:10'),
(18, 51, 'MANDIRI', '61257812', 'JOLIE DILLON', '1', '2024-01-16 10:56:33', '2024-01-16 10:56:33');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id` bigint UNSIGNED NOT NULL,
  `id_transaction` bigint UNSIGNED NOT NULL,
  `ticket_identifier` varchar(6) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` varchar(8) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id`, `id_transaction`, `ticket_identifier`, `status`, `created_at`, `updated_at`) VALUES
(91, 194, '9E1408', 'unused', '2024-01-16 11:09:52', '2024-01-16 11:09:52'),
(92, 194, '02C7CB', 'unused', '2024-01-16 11:09:52', '2024-01-16 11:09:52'),
(93, 194, '565C36', 'unused', '2024-01-16 11:09:52', '2024-01-16 11:09:52'),
(94, 194, '888228', 'unused', '2024-01-16 11:09:52', '2024-01-16 11:09:52'),
(95, 194, 'CDE1ED', 'unused', '2024-01-16 11:09:52', '2024-01-16 11:09:52'),
(96, 195, '75A240', 'unused', '2024-01-16 12:11:47', '2024-01-16 12:11:47'),
(97, 195, 'E5BAE7', 'unused', '2024-01-16 12:11:47', '2024-01-16 12:11:47'),
(98, 197, '524ACE', 'unused', '2024-01-16 12:30:05', '2024-01-16 12:30:05'),
(99, 197, '53DD37', 'unused', '2024-01-16 12:30:05', '2024-01-16 12:30:05'),
(100, 198, '5335EA', 'unused', '2024-01-16 12:32:09', '2024-01-16 12:32:09'),
(101, 198, '5B1676', 'unused', '2024-01-16 12:32:09', '2024-01-16 12:32:09'),
(102, 198, '5C79E6', 'unused', '2024-01-16 12:32:09', '2024-01-16 12:32:09'),
(103, 199, '96ED44', 'unused', '2024-01-16 12:48:19', '2024-01-16 12:48:19'),
(104, 204, '1A54E4', 'unused', '2024-01-16 12:59:51', '2024-01-16 12:59:51'),
(105, 205, 'JNVXN1', 'unused', '2024-01-16 15:26:49', '2024-01-16 15:26:49'),
(106, 206, '19AE39', 'unused', '2024-01-16 17:23:47', '2024-01-16 17:23:47'),
(107, 210, '8666D0', 'used', '2024-01-16 23:01:24', '2024-01-16 23:01:24'),
(108, 211, '950920', 'unused', '2024-01-16 23:01:51', '2024-01-16 23:01:51'),
(109, 209, 'F0C37A', 'unused', '2024-01-20 03:09:43', '2024-01-20 03:09:43');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` bigint UNSIGNED NOT NULL,
  `id_member` bigint UNSIGNED NOT NULL,
  `id_event` bigint UNSIGNED NOT NULL,
  `id_competition` bigint UNSIGNED DEFAULT NULL,
  `id_booth_rental` bigint UNSIGNED DEFAULT NULL,
  `preferred_date` date DEFAULT NULL,
  `id_category` bigint UNSIGNED NOT NULL,
  `qty` int NOT NULL,
  `transaction_amout` int DEFAULT NULL,
  `proof_of_transaction` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `transaction_status` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_payment_methods` bigint UNSIGNED DEFAULT NULL,
  `expiration_time` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `id_member`, `id_event`, `id_competition`, `id_booth_rental`, `preferred_date`, `id_category`, `qty`, `transaction_amout`, `proof_of_transaction`, `transaction_status`, `id_payment_methods`, `expiration_time`, `created_at`, `updated_at`) VALUES
(194, 43, 54, NULL, NULL, '2024-01-20', 1, 5, 250076, 'member/transaction/1705403377_7a2a54914b7408dbceb49246b0de929f.jpg', 'success', 16, '2024-01-17 11:09:11', '2024-01-16 11:09:11', '2024-01-16 11:09:52'),
(195, 43, 62, NULL, NULL, '2024-02-25', 1, 2, 70005, 'member/transaction/1705407102_7a2a54914b7408dbceb49246b0de929f.jpg', 'success', 16, '2024-01-17 12:11:36', '2024-01-16 12:11:36', '2024-01-16 12:11:47'),
(196, 43, 59, NULL, NULL, '2024-02-25', 1, 2, 50008, 'member/transaction/1705408124_7a2a54914b7408dbceb49246b0de929f.jpg', 'check', 18, '2024-01-17 12:28:36', '2024-01-16 12:28:36', '2024-01-16 12:28:36'),
(197, 43, 63, NULL, NULL, '2024-03-09', 1, 2, 240097, 'member/transaction/1705408201_7a2a54914b7408dbceb49246b0de929f.jpg', 'success', 16, '2024-01-17 12:29:57', '2024-02-02 12:29:57', '2024-02-02 12:30:05'),
(198, 43, 63, NULL, NULL, '2024-03-09', 1, 3, 360020, 'member/transaction/1705408326_7a2a54914b7408dbceb49246b0de929f.jpg', 'success', 16, '2024-01-17 12:32:02', '2024-03-05 12:32:02', '2024-03-05 12:32:02'),
(199, 43, 54, 44, NULL, NULL, 2, 1, 30028, 'member/transaction/1705409190_7a2a54914b7408dbceb49246b0de929f.jpg', 'success', 16, '2024-01-17 12:46:27', '2024-01-16 12:46:27', '2024-01-16 12:48:19'),
(204, 43, 54, NULL, 24, NULL, 3, 1, 500057, 'member/transaction/1705409974_7a2a54914b7408dbceb49246b0de929f.jpg', 'success', 16, '2024-01-17 12:59:28', '2024-01-16 12:59:28', '2024-01-16 12:59:51'),
(205, 43, 55, NULL, NULL, '2024-01-16', 1, 1, 0, NULL, 'success', NULL, NULL, '2024-01-16 15:26:49', '2024-01-16 15:26:49'),
(206, 43, 56, NULL, 26, NULL, 3, 1, 500073, 'member/transaction/1705425818_7a2a54914b7408dbceb49246b0de929f.jpg', 'success', 17, '2024-01-17 17:23:34', '2024-01-16 17:23:34', '2024-01-16 17:23:34'),
(207, 43, 54, NULL, NULL, '2024-01-20', 1, 1, 50029, NULL, 'check', 16, '2024-01-17 17:50:21', '2024-01-16 17:50:21', '2024-01-16 17:50:21'),
(208, 43, 56, 45, NULL, NULL, 2, 1, 20059, NULL, 'check', 17, '2024-01-17 17:56:53', '2024-01-16 17:56:53', '2024-01-16 17:56:53'),
(209, 47, 63, NULL, NULL, '2024-03-09', 1, 1, 120077, 'member/transaction/1705433847_7a2a54914b7408dbceb49246b0de929f.jpg', 'success', 16, '2024-01-17 19:37:23', '2024-01-16 19:37:23', '2024-01-20 03:09:43'),
(210, 43, 65, NULL, NULL, '2024-01-17', 1, 1, 205, 'member/transaction/1705446073_7a2a54914b7408dbceb49246b0de929f.jpg', 'success', 16, '2024-01-17 23:01:02', '2024-01-16 23:01:02', '2024-01-16 23:01:02'),
(211, 43, 65, 50, NULL, NULL, 2, 1, 22, 'member/transaction/1705446103_7a2a54914b7408dbceb49246b0de929f.jpg', 'success', 16, '2024-01-17 23:01:39', '2024-01-16 23:01:39', '2024-01-16 23:01:39'),
(212, 45, 59, NULL, NULL, '2024-02-25', 1, 1, 25086, NULL, 'check', 18, '2024-01-18 16:25:58', '2024-01-17 16:25:58', '2024-01-17 16:25:58'),
(213, 43, 58, NULL, NULL, '2024-02-17', 1, 1, 200055, 'member/transaction/1705720147_7a2a54914b7408dbceb49246b0de929f.jpg', 'check', 17, '2024-01-21 03:08:54', '2024-01-20 03:08:54', '2024-01-20 03:08:54'),
(214, 43, 56, NULL, NULL, '2024-01-27', 1, 1, 30066, 'member/transaction/1705725631_7a2a54914b7408dbceb49246b0de929f.jpg', 'check', 17, '2024-01-21 04:40:26', '2024-01-20 04:40:26', '2024-01-20 04:40:26'),
(215, 43, 62, NULL, NULL, '2024-02-25', 1, 1, 35005, NULL, 'check', 16, '2024-01-21 22:21:23', '2024-01-20 22:21:23', '2024-01-20 22:21:23');

--
-- Triggers `transaction`
--
DELIMITER $$
CREATE TRIGGER `after_insert_transaction` AFTER UPDATE ON `transaction` FOR EACH ROW BEGIN
    IF NEW.id_category = 3 AND (NEW.transaction_status = 'success' AND OLD.transaction_status = 'check') THEN
        INSERT INTO detail_booth (id_booth_rental, id_member, booth_description)
        VALUES (NEW.id_booth_rental, NEW.id_member, null);
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_update_transaction_status` AFTER UPDATE ON `transaction` FOR EACH ROW BEGIN
    DECLARE i INT DEFAULT 0;

    IF NEW.transaction_status = 'success' AND OLD.transaction_status = 'check' THEN
        WHILE i < NEW.qty DO
            INSERT INTO ticket (id_transaction, ticket_identifier, status, created_at, updated_at)
            VALUES (NEW.id, UPPER(SUBSTRING(MD5(RAND()) FROM 1 FOR 6)), 'unused', NOW(), NOW());
            SET i = i + 1;
        END WHILE;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_availability_status_boothrental` AFTER INSERT ON `transaction` FOR EACH ROW BEGIN
    IF NEW.transaction_status = 'pending' AND NEW.id_category = 3 THEN
        UPDATE booth_rental
        SET availability_status = 'booked'
        WHERE id = NEW.id_booth_rental;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_participant_qty_detailcompetition` AFTER INSERT ON `transaction` FOR EACH ROW BEGIN
    IF NEW.transaction_status = 'pending' AND NEW.id_category = 2 THEN
        UPDATE detail_competition
        SET participant_qty = participant_qty - NEW.qty
        WHERE id = NEW.id_competition;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_ticket_qty_detailevent` BEFORE INSERT ON `transaction` FOR EACH ROW BEGIN
    IF NEW.transaction_status = 'pending' AND NEW.id_category = 1 THEN
        UPDATE detail_event
        SET ticket_qty = ticket_qty - NEW.qty
        WHERE id = NEW.id_event;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `usertype` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `usertype`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Wahyu', 'admin@gmail.com', '2023-12-05 04:46:49', '$2y$10$pkCuUIhl03EM.Dqz7wnHZu8W1Bb37KsgAvzKznXIGfEFa0IllzBPO', 'admin', NULL, NULL, NULL, 'rkN5UGppKRRZ5xJ7bbDbIV0hmqahPX3ZebAsUbDvxeh3bpYi79tMw1CgYYD7', '2023-12-05 04:46:49', '2023-12-22 12:48:54'),
(43, 'Logan Anthony', 'arifjagad34@gmail.com', '2024-01-16 09:51:24', '$2y$10$ibPTTQbwngm3tiZwBMTabu0blLuqSFQzPxAMwtTkFwEqvOMVP87Lq', 'member', NULL, NULL, NULL, 'pwoYKnK6vZUGcNV6NhIPbycc0gq9vHWHwqKCmLcT6Cy55YIC2Ka6uqrvxfbD', '2024-01-16 02:41:21', '2024-01-20 21:02:12'),
(44, 'Alexa Bishop', 'qyvajan@mailinator.com', '2024-01-16 02:45:06', '$2y$10$XgoqSD6LRfSrQOi67yPrMeG9EaSqKZWEBQmFP4L/PwseFt61i1Oxy', 'event organizer', NULL, NULL, NULL, NULL, '2024-01-16 02:42:52', '2024-01-16 02:42:52'),
(45, 'Marcia Glover', 'dukikorog@mailinator.com', '2024-01-17 17:13:29', '$2y$10$iVt9Ar5KrdLji27ZF.npgu5JfsncqM/p..MvVsGgNRJiPNZOfl8Da', 'member', NULL, NULL, NULL, NULL, '2024-01-16 02:44:25', '2024-01-16 02:44:25'),
(46, 'Eagan Gordon', 'gajebyf@mailinator.com', NULL, '$2y$10$UqOIaTRzA3w89hpH/IFIpuHWHO8yVFfbJxuIkx7OzvOJF2jtoYV/m', 'member', NULL, NULL, NULL, NULL, '2024-01-16 02:48:17', '2024-01-16 02:48:17'),
(47, 'Kessie Wall', 'dijaqumy@mailinator.com', '2024-01-17 17:02:50', '$2y$10$muURoaO17Ue.F73vvBkR8ubF/TaSt8TQo.2U38yayI33kgMWIFuqa', 'member', NULL, NULL, NULL, NULL, '2024-01-16 03:55:32', '2024-01-16 03:55:32'),
(48, 'Bruno Sykes', 'hame@mailinator.com', NULL, '$2y$10$YyPpaS5H5c0VOio3f3tsU.lMuxHWbwL0xLn30960gjf8THORfmnWm', 'member', NULL, NULL, NULL, NULL, '2024-01-16 03:55:47', '2024-01-16 03:55:47'),
(49, 'Idona Stephenson', 'hasis@mailinator.com', '2024-01-16 10:39:15', '$2y$10$2izp19UzMwnz.aZbZkmohOGiQ5sMd8yoN9LMqQ7HuwI6GX0jV6rtq', 'event organizer', NULL, NULL, NULL, NULL, '2024-01-16 03:56:00', '2024-01-16 03:56:00'),
(50, 'Yuri Knowles', 'riconisa@mailinator.com', NULL, '$2y$10$HUR90DKznglk0ATRPDNAn.DjpiHWQ35LeksnmnC1zDu7HM4Cyng/6', 'member', NULL, NULL, NULL, NULL, '2024-01-16 03:56:20', '2024-01-16 03:56:20'),
(51, 'Jolie Dillon', 'gekav@mailinator.com', '2024-01-16 10:55:57', '$2y$10$fsc8Pg5muPu7neW5FpvhSeDUcqlTmPQbW3pIEgqsJKZFRnlTU8WsG', 'event organizer', NULL, NULL, NULL, NULL, '2024-01-16 03:57:16', '2024-01-16 03:57:16'),
(52, 'Elaine Ramirez', 'nyza@mailinator.com', NULL, '$2y$10$sD5Qc92khS4P1hRn0li7Du50Ia/hvlH9mMl0Wv/JpdwVC/6AED526', 'member', NULL, NULL, NULL, NULL, '2024-01-16 03:57:32', '2024-01-16 03:57:32'),
(53, 'Troy Gaines', 'leka@mailinator.com', NULL, '$2y$10$OFe9eSJOyMLX2fko5yNLAefSBqCCwcToyhfZ/DGECsySDwCqXmZBG', 'event organizer', NULL, NULL, NULL, NULL, '2024-01-16 03:57:46', '2024-01-16 03:57:46'),
(54, 'Kieran Santos', 'necir@mailinator.com', NULL, '$2y$10$d4B4wpU9.V4cuX3nho.G/.HX28pUO2wp5/bx/8SWWJbaOAj5LX3Uu', 'member', NULL, NULL, NULL, NULL, '2024-01-16 03:58:01', '2024-01-16 03:58:01'),
(55, 'Cameron Russo', 'wyryk@mailinator.com', NULL, '$2y$10$uKihAzpV8GU5UKy.hCvgYeOG8jSqOGHrHn0zHy6EfQSXdKfHUwZ6m', 'member', NULL, NULL, NULL, NULL, '2024-01-16 03:58:21', '2024-01-16 03:58:21'),
(56, 'Tanner Gutierrez', 'guhivi@mailinator.com', '2024-01-17 00:58:13', '$2y$10$Sc7oUsc6rJ29wqiGLW8gQ.eKEkeMptEOsd7liNNCQPbeRe0t68Lqm', 'event organizer', NULL, NULL, NULL, NULL, '2024-01-16 03:58:42', '2024-01-16 03:58:42'),
(57, 'Quinlan Gillespie', 'kepylupady@mailinator.com', NULL, '$2y$10$QYaLiTJDc6hkoqeRbW77/urI.uJ8yPTJFAqPy6GmxL9BCofHX/vxa', 'member', NULL, NULL, NULL, NULL, '2024-01-16 03:59:05', '2024-01-16 03:59:05'),
(77, 'Quyn Richard', 'hilahagyx@mailinator.com', NULL, '$2y$10$2RczG1.PVuoeaoJnUB8LvuyY6Xn6pSCz53ZsfIjQ0crCzxnNrOcsK', 'admin', NULL, NULL, NULL, NULL, '2024-01-17 20:00:16', '2024-01-17 20:00:16'),
(78, 'diki@gmail.com', 'diki@gmail.com', NULL, '$2y$10$qib2kRFxmF0ZieSaCWkLTuSYYxLeKYRRzXmnBVbFdEy.5aMmLucsu', 'member', NULL, NULL, NULL, NULL, '2024-03-05 09:54:28', '2024-03-05 09:54:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booth_rental`
--
ALTER TABLE `booth_rental`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booth_rental_id_event_foreign` (`id_event`),
  ADD KEY `booth_rental_id_category_foreign` (`id_category`);

--
-- Indexes for table `category_transaction`
--
ALTER TABLE `category_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_booth`
--
ALTER TABLE `detail_booth`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_booth_id_booth_rental` (`id_booth_rental`),
  ADD KEY `detail_booth_id_member` (`id_member`);

--
-- Indexes for table `detail_competition`
--
ALTER TABLE `detail_competition`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_competition_id_category_foreign` (`id_category`) USING BTREE,
  ADD KEY `detail_competition_id_event_foreign` (`id_event`);

--
-- Indexes for table `detail_event`
--
ALTER TABLE `detail_event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_eo` (`id_eo`) USING BTREE,
  ADD KEY `detail_event_id_category_foreign` (`id_category`) USING BTREE;

--
-- Indexes for table `detail_member`
--
ALTER TABLE `detail_member`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_member_id_member_foreign` (`id_member`);

--
-- Indexes for table `event_organizer`
--
ALTER TABLE `event_organizer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_user` (`id_user`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_methods_id_eo_foreign` (`id_eo`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_ticket` (`ticket_identifier`),
  ADD KEY `ticket_id_transaction` (`id_transaction`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_id_booth` (`id_booth_rental`),
  ADD UNIQUE KEY `transaction_id_competition` (`id_competition`),
  ADD KEY `transaction_id_category_foreign` (`id_category`) USING BTREE,
  ADD KEY `transaction_id_event_foreign` (`id_event`),
  ADD KEY `transaction_id_member_foreign` (`id_member`),
  ADD KEY `transaction_id_payment_methods` (`id_payment_methods`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booth_rental`
--
ALTER TABLE `booth_rental`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `detail_booth`
--
ALTER TABLE `detail_booth`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `detail_competition`
--
ALTER TABLE `detail_competition`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `detail_event`
--
ALTER TABLE `detail_event`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `detail_member`
--
ALTER TABLE `detail_member`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `event_organizer`
--
ALTER TABLE `event_organizer`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=216;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booth_rental`
--
ALTER TABLE `booth_rental`
  ADD CONSTRAINT `booth_rental_id_category_foreign` FOREIGN KEY (`id_category`) REFERENCES `category_transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booth_rental_id_event_foreign` FOREIGN KEY (`id_event`) REFERENCES `detail_event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_booth`
--
ALTER TABLE `detail_booth`
  ADD CONSTRAINT `detail_booth_id_booth_rental` FOREIGN KEY (`id_booth_rental`) REFERENCES `booth_rental` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `detail_booth_id_member_foreign` FOREIGN KEY (`id_member`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `detail_competition`
--
ALTER TABLE `detail_competition`
  ADD CONSTRAINT `detail_competition_id_category_foreign` FOREIGN KEY (`id_category`) REFERENCES `category_transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_competition_id_event_foreign` FOREIGN KEY (`id_event`) REFERENCES `detail_event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_event`
--
ALTER TABLE `detail_event`
  ADD CONSTRAINT `detail_event_id_category_foreign` FOREIGN KEY (`id_category`) REFERENCES `category_transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_event_id_eo_foreign` FOREIGN KEY (`id_eo`) REFERENCES `event_organizer` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `detail_member`
--
ALTER TABLE `detail_member`
  ADD CONSTRAINT `detail_member_id_member_foreign` FOREIGN KEY (`id_member`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_organizer`
--
ALTER TABLE `event_organizer`
  ADD CONSTRAINT `event_organizer_id_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD CONSTRAINT `payment_methods_id_eo_foreign` FOREIGN KEY (`id_eo`) REFERENCES `event_organizer` (`id_user`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_id_transaction` FOREIGN KEY (`id_transaction`) REFERENCES `transaction` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `transaction_id_booth_rental_foreign` FOREIGN KEY (`id_booth_rental`) REFERENCES `booth_rental` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `transaction_id_category_foreign` FOREIGN KEY (`id_category`) REFERENCES `category_transaction` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_id_competition_foreign` FOREIGN KEY (`id_competition`) REFERENCES `detail_competition` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `transaction_id_event_foreign` FOREIGN KEY (`id_event`) REFERENCES `detail_event` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaction_id_member_foreign` FOREIGN KEY (`id_member`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `transaction_id_payment_methods` FOREIGN KEY (`id_payment_methods`) REFERENCES `payment_methods` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `handle_expired_eventsx` ON SCHEDULE EVERY 1 DAY STARTS '2024-01-12 02:05:17' ON COMPLETION NOT PRESERVE ENABLE DO CALL handle_expired_transaction_detailevent()$$

CREATE DEFINER=`root`@`localhost` EVENT `handle_expired_transaction_event` ON SCHEDULE EVERY 1 SECOND STARTS '2024-01-12 03:40:33' ON COMPLETION NOT PRESERVE ENABLE DO CALL handle_expired_transaction_detailevent()$$

CREATE DEFINER=`root`@`localhost` EVENT `handle_expired_transaction_competition` ON SCHEDULE EVERY 1 SECOND STARTS '2024-01-12 03:40:44' ON COMPLETION NOT PRESERVE ENABLE DO CALL handle_expired_transaction_detailcompetition()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
