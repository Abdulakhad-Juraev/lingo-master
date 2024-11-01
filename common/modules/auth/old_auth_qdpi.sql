-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 19, 2024 at 02:19 PM
-- Server version: 5.7.39
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test-app`
--

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1716893516);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, NULL, NULL, NULL, 1716893516, 1716893516),
('company-info', 3, NULL, NULL, NULL, 1718085846, 1718085846),
('company-info/create ', 2, '', NULL, NULL, 1718085846, 1718085846),
('company-info/delete', 2, '', NULL, NULL, 1718085846, 1718085846),
('company-info/index', 2, '', NULL, NULL, 1718085846, 1718085846),
('company-info/update', 2, '', NULL, NULL, 1718085846, 1718085846),
('company-info/view', 2, '', NULL, NULL, 1718085846, 1718085846),
('course', 3, NULL, NULL, NULL, 1717416396, 1717416396),
('course/create', 2, 'Qo\'shish', NULL, NULL, 1718000036, 1718000036),
('course/delete', 2, 'O\'chirish', NULL, NULL, 1718012061, 1718012061),
('course/index', 2, '', NULL, NULL, 1717416396, 1717416396),
('course/update', 2, 'Tahrirlash', NULL, NULL, 1718000264, 1718000264),
('course/view', 2, 'Ko\'rish', NULL, NULL, 1718000280, 1718000280),
('department', 3, NULL, NULL, NULL, 1717416360, 1717416360),
('department/create', 2, 'Qo\'shish', NULL, NULL, 1718000328, 1718000328),
('department/delete', 2, 'O\'chirish', NULL, NULL, 1718012072, 1718012072),
('department/index', 2, '', NULL, NULL, 1717416360, 1717416360),
('department/update', 2, 'Tahrirlash', NULL, NULL, 1718000344, 1718000344),
('department/view', 2, 'Ko\'rish', NULL, NULL, 1718000368, 1718000368),
('direction', 3, NULL, NULL, NULL, 1717416377, 1717416377),
('direction/create', 2, 'Qo\'shish', NULL, NULL, 1718000401, 1718000401),
('direction/delete', 2, 'O\'chirish', NULL, NULL, 1718012165, 1718012165),
('direction/index', 2, '', NULL, NULL, 1717416377, 1717416377),
('direction/update', 2, 'Tahrirlash', NULL, NULL, 1718000407, 1718000407),
('direction/view', 2, 'Ko\'rish', NULL, NULL, 1718000413, 1718000413),
('district', 3, '', NULL, NULL, 1718084103, 1718084194),
('district/index', 2, '', NULL, NULL, 1718084103, 1718084103),
('faculty', 3, NULL, NULL, NULL, 1717416211, 1717416211),
('faculty/create', 2, 'Qo\'shish', NULL, NULL, 1718000429, 1718000429),
('faculty/delete', 2, 'O\'chirish', NULL, NULL, 1718012185, 1718012185),
('faculty/index', 2, '', NULL, NULL, 1717416211, 1717416211),
('faculty/update', 2, 'Tahrirlash', NULL, NULL, 1718000436, 1718000436),
('faculty/view', 2, 'Ko\'rish', NULL, NULL, 1718000443, 1718000443),
('faq', 3, NULL, NULL, NULL, 1718085800, 1718085800),
('faq/create ', 2, '', NULL, NULL, 1718085800, 1718085800),
('faq/delete', 2, '', NULL, NULL, 1718085800, 1718085800),
('faq/index', 2, '', NULL, NULL, 1718085800, 1718085800),
('faq/update', 2, '', NULL, NULL, 1718085800, 1718085800),
('faq/view', 2, '', NULL, NULL, 1718085800, 1718085800),
('language', 3, NULL, NULL, NULL, 1717416420, 1717416420),
('language/create', 2, 'Qo\'shish', NULL, NULL, 1718001079, 1718001079),
('language/delete', 2, 'O\'chirish', NULL, NULL, 1718012226, 1718012226),
('language/index', 2, '', NULL, NULL, 1717416420, 1717416420),
('language/update', 2, 'Tahrirlash', NULL, NULL, 1718001075, 1718001075),
('language/view', 2, 'Ko\'rish', NULL, NULL, 1718001085, 1718001085),
('permission', 3, NULL, NULL, NULL, 1717416901, 1717416901),
('permission/create', 2, 'Qo\'shish', NULL, NULL, 1718012248, 1718012248),
('permission/delete', 2, 'O\'chirish', NULL, NULL, 1718012263, 1718012263),
('permission/index', 2, '', NULL, NULL, 1717416901, 1717416901),
('permission/update', 2, 'Tahrirlash', NULL, NULL, 1718012253, 1718012253),
('permission/view', 2, 'Ko\'rish', NULL, NULL, 1718012281, 1718012281),
('region', 3, NULL, NULL, NULL, 1718009237, 1718009237),
('region/delete', 2, 'O\'chirish', NULL, NULL, 1718009350, 1718009350),
('region/index', 2, '', NULL, NULL, 1718009237, 1718009237),
('region/update', 2, 'Tahrirlash', NULL, NULL, 1718009326, 1718009326),
('roll', 3, NULL, NULL, NULL, 1718013334, 1718013334),
('roll/index', 2, '', NULL, NULL, 1718013334, 1718013334),
('settings', 3, NULL, NULL, NULL, 1717416941, 1717416941),
('settings/create', 2, 'Qo\'shish', NULL, NULL, 1718000557, 1718000557),
('settings/delete', 2, 'O\'chirish', NULL, NULL, 1718012822, 1718012822),
('settings/index', 2, '', NULL, NULL, 1717416941, 1717416941),
('settings/update', 2, 'Tahrirlash', NULL, NULL, 1718000564, 1718000564),
('settings/view', 2, 'Ko\'rish', NULL, NULL, 1718000573, 1718000573),
('site', 3, '', NULL, NULL, 1718079986, 1718080045),
('site/chart', 2, '', NULL, NULL, 1718080529, 1718080529),
('site/report', 2, '', NULL, NULL, 1718079986, 1718080045),
('student', 3, NULL, NULL, NULL, 1718008778, 1718008778),
('student/create', 2, 'Qo\'shish', NULL, NULL, 1718008786, 1718008786),
('student/delete', 2, 'O\'chirish', NULL, NULL, 1718012889, 1718012889),
('student/import', 2, 'Fayl yuklash', NULL, NULL, 1718008870, 1718008870),
('student/index', 2, '', NULL, NULL, 1718008778, 1718008778),
('student/update', 2, 'Tahrirlash', NULL, NULL, 1718008794, 1718008794),
('student/update-import', 2, 'Yuklangan faylni tahrirlash', NULL, NULL, 1718008899, 1718008899),
('student/user-balance', 2, '', NULL, NULL, 1718019900, 1718019900),
('student/user-device', 2, '', NULL, NULL, 1718019881, 1718019881),
('student/user-test-result', 2, '', NULL, NULL, 1718009072, 1718009072),
('student/view', 2, 'Ko\'rish', NULL, NULL, 1718008808, 1718008808),
('subject', 3, NULL, NULL, NULL, 1717416437, 1717416437),
('subject/create', 2, 'Qo\'shish', NULL, NULL, 1718000701, 1718000701),
('subject/delete', 2, 'O\'chirish', NULL, NULL, 1718012906, 1718012906),
('subject/index', 2, '', NULL, NULL, 1717416437, 1717416437),
('subject/update', 2, 'Tahrirlash', NULL, NULL, 1718000706, 1718000706),
('subject/view', 2, 'Ko\'rish', NULL, NULL, 1718000712, 1718000712),
('teacher', 3, NULL, NULL, NULL, 1718001884, 1718001884),
('teacher/create', 2, 'Qo\'shish', NULL, NULL, 1718001893, 1718001893),
('teacher/delete', 2, 'O\'chirish', NULL, NULL, 1718012922, 1718012922),
('teacher/index', 2, '', NULL, NULL, 1718001884, 1718001884),
('teacher/update', 2, 'Tahrirlash', NULL, NULL, 1718002076, 1718002076),
('teacher/view', 2, 'Ko\'rish', NULL, NULL, 1718002086, 1718002086),
('test', 3, NULL, NULL, NULL, 1717416448, 1717416448),
('test-enroll', 3, NULL, NULL, NULL, 1718784582, 1718784582),
('test-enroll/create', 2, '', NULL, NULL, 1718784661, 1718784661),
('test-enroll/delete', 2, '', NULL, NULL, 1718784671, 1718784671),
('test-enroll/index', 2, '', NULL, NULL, 1718784582, 1718784582),
('test-enroll/view', 2, '', NULL, NULL, 1718784654, 1718784654),
('test-list', 3, NULL, NULL, NULL, 1718085725, 1718085725),
('test-list/create', 2, '', NULL, NULL, 1718085749, 1718085749),
('test-list/delete', 2, '', NULL, NULL, 1718085763, 1718085763),
('test-list/index', 2, '', NULL, NULL, 1718085725, 1718085725),
('test-list/update', 2, '', NULL, NULL, 1718085754, 1718085754),
('test-list/view', 2, '', NULL, NULL, 1718085758, 1718085758),
('test-result', 3, NULL, NULL, NULL, 1718001611, 1718001611),
('test-result/create', 2, 'Qo\'shish', NULL, NULL, 1718001618, 1718001618),
('test-result/delete', 2, 'O\'chirish', NULL, NULL, 1718012961, 1718012961),
('test-result/index', 2, '', NULL, NULL, 1718001611, 1718001611),
('test-result/update', 2, 'Tahrirlash', NULL, NULL, 1718001624, 1718001624),
('test-result/view', 2, 'Ko\'rish', NULL, NULL, 1718001633, 1718001633),
('test/create', 2, 'Qo\'shish', NULL, NULL, 1718000782, 1718000782),
('test/delete', 2, 'O\'chirish', NULL, NULL, 1718012936, 1718012936),
('test/import', 2, 'Fayl yuklash', NULL, NULL, 1718000964, 1718000964),
('test/index', 2, '', NULL, NULL, 1717416448, 1717416448),
('test/update', 2, 'Tahrirlash', NULL, NULL, 1718000786, 1718000786),
('test/view', 2, 'Ko\'rish', NULL, NULL, 1718000794, 1718000794),
('translation-manager', 3, NULL, NULL, NULL, 1717416915, 1717416915),
('translation-manager/create', 2, 'Qo\'shish', NULL, NULL, 1718012982, 1718012982),
('translation-manager/delete', 2, 'O\'chirish', NULL, NULL, 1718012974, 1718012974),
('translation-manager/index', 2, '', NULL, NULL, 1717416915, 1717416915),
('translation-manager/update', 2, 'Tahrirlash', NULL, NULL, 1718012996, 1718012996),
('translation-manager/view', 2, 'Ko\'rish', NULL, NULL, 1718012988, 1718012988),
('user', 1, NULL, NULL, NULL, 1716893516, 1716893516),
('user-payment', 3, NULL, NULL, NULL, 1718368233, 1718368233),
('user-payment/index', 2, '', NULL, NULL, 1718368233, 1718368233);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'company-info/create '),
('admin', 'company-info/delete'),
('admin', 'company-info/index'),
('admin', 'company-info/update'),
('admin', 'company-info/view'),
('admin', 'course/create'),
('admin', 'course/delete'),
('admin', 'course/index'),
('admin', 'course/update'),
('admin', 'course/view'),
('admin', 'department/create'),
('admin', 'department/delete'),
('admin', 'department/index'),
('admin', 'department/update'),
('admin', 'department/view'),
('admin', 'direction/create'),
('admin', 'direction/delete'),
('admin', 'direction/index'),
('admin', 'direction/update'),
('admin', 'direction/view'),
('admin', 'faculty/create'),
('admin', 'faculty/delete'),
('admin', 'faculty/index'),
('admin', 'faculty/update'),
('admin', 'faculty/view'),
('admin', 'faq/create '),
('admin', 'faq/delete'),
('admin', 'faq/index'),
('admin', 'faq/update'),
('admin', 'faq/view'),
('admin', 'language/create'),
('admin', 'language/delete'),
('admin', 'language/index'),
('admin', 'language/update'),
('admin', 'language/view'),
('admin', 'permission/create'),
('admin', 'permission/delete'),
('admin', 'permission/index'),
('admin', 'permission/update'),
('admin', 'permission/view'),
('admin', 'region/delete'),
('admin', 'region/index'),
('admin', 'region/update'),
('admin', 'roll/index'),
('admin', 'settings/create'),
('admin', 'settings/delete'),
('admin', 'settings/index'),
('admin', 'settings/update'),
('admin', 'settings/view'),
('admin', 'site/chart'),
('admin', 'site/report'),
('admin', 'student/create'),
('admin', 'student/delete'),
('admin', 'student/import'),
('admin', 'student/index'),
('admin', 'student/update'),
('admin', 'student/update-import'),
('admin', 'student/user-balance'),
('admin', 'student/user-device'),
('admin', 'student/user-test-result'),
('admin', 'student/view'),
('admin', 'subject/create'),
('admin', 'subject/delete'),
('admin', 'subject/index'),
('admin', 'subject/update'),
('admin', 'subject/view'),
('admin', 'teacher/create'),
('admin', 'teacher/delete'),
('admin', 'teacher/index'),
('admin', 'teacher/update'),
('admin', 'teacher/view'),
('admin', 'test-enroll/create'),
('admin', 'test-enroll/delete'),
('admin', 'test-enroll/index'),
('admin', 'test-enroll/view'),
('admin', 'test-list/create'),
('admin', 'test-list/delete'),
('admin', 'test-list/index'),
('admin', 'test-list/update'),
('admin', 'test-list/view'),
('admin', 'test-result/create'),
('admin', 'test-result/delete'),
('admin', 'test-result/index'),
('admin', 'test-result/update'),
('admin', 'test-result/view'),
('admin', 'test/create'),
('admin', 'test/delete'),
('admin', 'test/import'),
('admin', 'test/index'),
('admin', 'test/update'),
('admin', 'test/view'),
('admin', 'translation-manager/create'),
('admin', 'translation-manager/delete'),
('admin', 'translation-manager/index'),
('admin', 'translation-manager/update'),
('admin', 'translation-manager/view'),
('admin', 'user-payment/index');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `idx-auth_assignment-user_id` (`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
