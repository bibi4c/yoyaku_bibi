-- phpMyAdmin SQL Dump
-- version 4.1.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 21, 2014 at 01:04 AM
-- Server version: 5.1.69
-- PHP Version: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `omi_yoyaku`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_appointments`
--

CREATE TABLE IF NOT EXISTS `tb_appointments` (
  `appointment_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `schedule_id` int(11) DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `flag` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`appointment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=232 ;

--
-- Dumping data for table `tb_appointments`
--

INSERT INTO `tb_appointments` (`appointment_id`, `user_id`, `schedule_id`, `last_update`, `start_time`, `end_time`, `flag`) VALUES
(136, 2, 11, '2013-07-31 19:41:05', '00:00:00', '00:00:00', 1),
(138, 2, 4, '2013-07-31 19:41:05', '00:00:00', '00:00:00', 1),
(139, 4, 11, '2013-07-31 19:52:14', '00:00:00', '00:00:00', 1),
(140, 4, 10, '2013-07-31 19:52:14', '00:00:00', '00:00:00', 1),
(141, 4, 4, '2013-07-31 19:52:14', '00:00:00', '00:00:00', 1),
(142, 6, 11, '2013-07-31 20:18:17', '00:00:00', '00:00:00', 1),
(143, 6, 18, '2013-07-31 20:18:17', '00:00:00', '00:00:00', 1),
(144, 6, 2, '2013-07-31 20:18:32', '00:00:00', '00:00:00', 1),
(145, 8, 11, '2013-07-31 20:20:37', '00:00:00', '00:00:00', 1),
(146, 8, 17, '2013-07-31 20:20:37', '00:00:00', '00:00:00', 1),
(147, 8, 3, '2013-07-31 20:20:37', '00:00:00', '00:00:00', 1),
(149, 2, 12, '2013-07-31 20:49:53', '00:00:00', '00:00:00', 1),
(158, 12, 18, '2013-08-01 12:33:27', '00:00:00', '00:00:00', 1),
(159, 12, 4, '2013-08-01 12:33:27', '00:00:00', '00:00:00', 1),
(161, 12, 11, '2013-08-01 12:33:54', '00:00:00', '00:00:00', 1),
(163, 13, 20, '2013-08-01 16:53:09', '00:00:00', '00:00:00', 1),
(165, 19, 24, '2013-08-06 13:04:37', '00:00:00', '00:00:00', 1),
(167, 20, 24, '2013-08-06 13:05:04', '00:00:00', '00:00:00', 1),
(169, 21, 24, '2013-08-06 13:05:26', '00:00:00', '00:00:00', 1),
(171, 22, 24, '2013-08-06 13:05:44', '00:00:00', '00:00:00', 1),
(173, 23, 24, '2013-08-06 13:06:06', '00:00:00', '00:00:00', 1),
(175, 24, 24, '2013-08-06 13:06:21', '00:00:00', '00:00:00', 1),
(177, 25, 24, '2013-08-06 13:06:37', '00:00:00', '00:00:00', 1),
(179, 48, 24, '2013-08-06 13:07:01', '00:00:00', '00:00:00', 1),
(181, 26, 24, '2013-08-06 13:07:18', '00:00:00', '00:00:00', 1),
(183, 27, 24, '2013-08-06 13:07:34', '00:00:00', '00:00:00', 1),
(185, 28, 24, '2013-08-06 13:07:50', '00:00:00', '00:00:00', 1),
(187, 29, 24, '2013-08-06 13:08:04', '00:00:00', '00:00:00', 1),
(189, 30, 24, '2013-08-06 13:08:19', '00:00:00', '00:00:00', 1),
(191, 31, 24, '2013-08-06 13:08:35', '00:00:00', '00:00:00', 1),
(193, 32, 24, '2013-08-06 13:08:51', '00:00:00', '00:00:00', 1),
(195, 33, 24, '2013-08-06 13:09:10', '00:00:00', '00:00:00', 1),
(197, 34, 24, '2013-08-06 13:09:28', '00:00:00', '00:00:00', 1),
(199, 35, 24, '2013-08-06 13:09:47', '00:00:00', '00:00:00', 1),
(201, 36, 24, '2013-08-06 13:10:05', '00:00:00', '00:00:00', 1),
(203, 37, 24, '2013-08-06 13:10:19', '00:00:00', '00:00:00', 1),
(205, 38, 24, '2013-08-06 13:10:35', '00:00:00', '00:00:00', 1),
(207, 39, 24, '2013-08-06 13:10:49', '00:00:00', '00:00:00', 1),
(209, 40, 24, '2013-08-06 13:11:10', '00:00:00', '00:00:00', 1),
(211, 41, 24, '2013-08-06 13:11:25', '00:00:00', '00:00:00', 1),
(213, 42, 24, '2013-08-06 13:11:40', '00:00:00', '00:00:00', 1),
(215, 43, 24, '2013-08-06 13:11:55', '00:00:00', '00:00:00', 1),
(217, 44, 24, '2013-08-06 13:12:10', '00:00:00', '00:00:00', 1),
(219, 45, 24, '2013-08-06 13:12:24', '00:00:00', '00:00:00', 1),
(221, 46, 24, '2013-08-06 13:12:39', '00:00:00', '00:00:00', 1),
(226, 3, 11, '2013-08-14 03:30:14', '00:00:00', '00:00:00', 1),
(227, 3, 9, '2013-08-14 03:30:14', '00:00:00', '00:00:00', 1),
(228, 53, 5, '2013-08-14 19:58:51', '00:00:00', '00:00:00', 1),
(230, 53, 4, '2013-08-14 19:58:51', '00:00:00', '00:00:00', 1),
(231, 53, 17, '2013-08-14 20:12:01', '00:00:00', '00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_courses`
--

CREATE TABLE IF NOT EXISTS `tb_courses` (
  `course_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department_id` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  PRIMARY KEY (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `tb_courses`
--

INSERT INTO `tb_courses` (`course_id`, `course_name`, `department_id`, `last_update`) VALUES
(1, '医師 ①', ',1,2,', '2013-07-25 00:00:00'),
(2, '医師 ②', ',1,2', '2013-07-25 00:00:00'),
(3, '医師 ③', ',1,', '2013-07-25 00:00:00'),
(4, '医師 ③＋レジメン編', ',2,', '2013-07-25 00:00:00'),
(5, '外来看護師リーダ ①', ',3,', '2013-07-25 00:00:00'),
(6, '外来看護師リーダ ②', ',3,', '2013-07-25 00:00:00'),
(7, '外来看護師リーダ ③', ',3,', '2013-07-25 00:00:00'),
(8, '病棟看護師リーダ ①', ',4,', '2013-07-25 00:00:00'),
(9, '病棟看護師リーダ ②', ',4,', '2013-07-25 00:00:00'),
(10, '病棟看護師リーダ ③', ',4,', '2013-07-25 00:00:00'),
(11, '病棟看護師リーダ ④', ',4,', '2013-07-25 00:00:00'),
(12, '病棟看護師リーダ ⑤', ',4,', '2013-07-25 00:00:00'),
(13, '病棟看護師リーダ ⑥', ',4,', '2013-07-25 00:00:00'),
(14, '部門リーダ', ',5,', '2013-07-25 00:00:00'),
(15, '医師リーダ', ',6,', '2013-07-25 00:00:00'),
(16, '外来看護師', ',7,', '2013-07-25 00:00:00'),
(17, '病棟看護師 ①', ',8,', '2013-07-25 00:00:00'),
(18, '病棟看護師 ②', ',8,', '2013-07-25 00:00:00'),
(19, '病棟看護師 ③', ',8,', '2013-07-25 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_departmentnames`
--

CREATE TABLE IF NOT EXISTS `tb_departmentnames` (
  `departmentname_id` int(4) NOT NULL AUTO_INCREMENT,
  `departmentname` varchar(110) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`departmentname_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=55 ;

--
-- Dumping data for table `tb_departmentnames`
--

INSERT INTO `tb_departmentnames` (`departmentname_id`, `departmentname`) VALUES
(1, '診療科'),
(2, '血液・膠原病内科'),
(3, '腎臓・高血圧・内分泌内科'),
(4, '糖尿病・代謝内科'),
(5, '循環器内科'),
(6, '呼吸器内科'),
(7, '消化器・肝臓内科'),
(8, '小児科'),
(9, '精神神経科'),
(10, '皮膚科'),
(11, '乳腺内分泌外科'),
(12, '心臓外科'),
(13, '消化器外科'),
(14, '呼吸器外科'),
(15, '小児外科'),
(16, '脳神経外科'),
(17, '整形外科'),
(18, '産婦人科'),
(19, '泌尿器科'),
(20, '形成外科'),
(21, '耳鼻咽喉科'),
(22, '眼科'),
(23, '放射線科'),
(24, '麻酔科'),
(25, '歯科口腔外科'),
(26, '心療内科'),
(27, '神経内科'),
(28, '総合科（内科）'),
(29, '総合科（外科）'),
(30, '血管外科'),
(31, '病理診断科'),
(32, '臨床検査医学科'),
(33, '東洋医学科'),
(34, '救命救急センター'),
(35, '睡眠センター'),
(36, '看護部'),
(37, '薬剤部'),
(38, '臨床検査部'),
(39, '輸血室'),
(40, '放射線部'),
(41, '理学療法室'),
(42, '栄養科'),
(43, '臨床工学技士室'),
(44, '透析室'),
(45, '歯科技工室'),
(46, '視能訓練室'),
(47, '医療福祉相談室'),
(48, '感染予防対策室'),
(49, '臨床研究推進センター'),
(50, '庶務課'),
(51, '会計課'),
(52, '資材課'),
(53, '医事課'),
(54, '病歴課');

-- --------------------------------------------------------

--
-- Table structure for table `tb_departments`
--

CREATE TABLE IF NOT EXISTS `tb_departments` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tb_departments`
--

INSERT INTO `tb_departments` (`department_id`, `name`, `note`) VALUES
(1, '医師', NULL),
(2, '医師＋レジメン編', NULL),
(3, '外来看護師リーダ', NULL),
(4, '病棟看護師リーダ', NULL),
(5, '部門リーダ', NULL),
(6, '医師リーダ', NULL),
(7, '外来看護師', NULL),
(8, '病棟看護師', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_schedules`
--

CREATE TABLE IF NOT EXISTS `tb_schedules` (
  `schedule_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_id` int(11) DEFAULT NULL,
  `timetable_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `num_members_ordered` tinyint(3) NOT NULL DEFAULT '0',
  `max_members` tinyint(3) DEFAULT '30',
  `last_update` datetime DEFAULT NULL,
  PRIMARY KEY (`schedule_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=26 ;

--
-- Dumping data for table `tb_schedules`
--

INSERT INTO `tb_schedules` (`schedule_id`, `course_id`, `timetable_id`, `date`, `num_members_ordered`, `max_members`, `last_update`) VALUES
(1, 2, 1, '2013-07-27', 0, 30, '2013-07-27 00:00:00'),
(2, 3, 2, '2013-07-27', 1, 30, '2013-07-27 00:00:00'),
(3, 3, 3, '2013-07-29', 1, 30, '2013-07-27 00:00:00'),
(4, 3, 5, '2013-07-29', 4, 30, '2013-07-27 00:00:00'),
(5, 1, 2, '2013-07-29', 1, 30, '2013-08-15 19:41:32'),
(7, 5, 4, '2013-07-27', 0, 30, '2013-07-27 00:00:00'),
(8, 3, 2, '2013-07-26', 0, 30, '2013-07-27 00:00:00'),
(9, 4, 3, '2013-07-31', 1, 30, '2013-07-27 00:00:00'),
(10, 2, 4, '2013-07-31', 1, 30, '2013-07-27 00:00:00'),
(11, 1, 2, '2013-07-30', 6, 30, '2013-08-15 19:45:14'),
(12, 2, 3, '2013-08-01', 1, 30, '2013-07-27 00:00:00'),
(15, 2, 4, '2013-07-30', 0, 30, '2013-07-27 00:00:00'),
(17, 2, 4, '2013-08-01', 2, 30, '2013-07-27 00:00:00'),
(18, 2, 4, '2013-08-02', 2, 30, '2013-07-27 00:00:00'),
(19, 2, 4, '2013-08-05', 0, 30, '2013-07-27 00:00:00'),
(20, 2, 4, '2013-08-06', 1, 30, '2013-07-27 00:00:00'),
(21, 2, 4, '2013-08-07', 0, 30, '2013-07-27 00:00:00'),
(22, 2, 4, '2013-08-08', 0, 30, '2013-07-27 00:00:00'),
(24, 2, 6, '2013-08-06', 29, 30, '2013-08-06 13:02:23'),
(25, 8, 6, '2013-08-21', 0, 30, '2013-08-10 18:16:10');

-- --------------------------------------------------------

--
-- Table structure for table `tb_timetables`
--

CREATE TABLE IF NOT EXISTS `tb_timetables` (
  `timetable_id` int(11) NOT NULL AUTO_INCREMENT,
  `start_time` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `end_time` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  PRIMARY KEY (`timetable_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tb_timetables`
--

INSERT INTO `tb_timetables` (`timetable_id`, `start_time`, `end_time`, `last_update`) VALUES
(1, '13:30', '15:30', NULL),
(2, '16:00', '18:00', '2013-07-25 00:00:00'),
(3, '18:30', '20:30', '2013-07-25 00:00:00'),
(4, '09:00', '12:00', '2013-08-02 09:56:39'),
(5, '16:00', '17:45', NULL),
(6, '18:15', '20:00', '2013-07-25 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE IF NOT EXISTS `tb_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `part_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phs` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mail_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=54 ;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`user_id`, `name`, `department_id`, `part_name`, `phs`, `mail_address`, `password`, `last_update`) VALUES
(1, 'admin', 0, 'admin', '01696455911', 'testadmin@ominext.com', '52797bdf83a28e25fd0ce9e36fd05401cba1386d', '2013-07-23 07:20:36'),
(2, 'やまぎし　みずき', 1, '医師112', '090226033', 'testuser@ominext.com', '52797bdf83a28e25fd0ce9e36fd05401cba1386d', '2013-07-27 05:56:30'),
(3, 'いしだ　みほ', 2, '医師222', '12123232', 'binh4chedsp.i@gmail.com', '52797bdf83a28e25fd0ce9e36fd05401cba1386d', '2013-07-26 12:22:41'),
(4, 'わかすぎ　ゆうご', 1, 'ominext医師', '01696455911', 'binhnd@gmail.com', 'd428bd503f25a6e2474dcdca36dbb54165bc7ab1', '2013-07-26 12:25:17'),
(5, 'いわたけ　はるか', 2, 'bibiday医師', '01696455911', 'binh4ched.spi@gmail.com', '55d8adf9b9b0133a76d5e5398d32443717fd613b', '2013-07-27 06:12:03'),
(6, 'ながみ　ゆうか', 1, '123医師', '01696455911', 'binh.4chedspi@gmail.com', 'd428bd503f25a6e2474dcdca36dbb54165bc7ab1', '2013-07-31 05:59:26'),
(7, 'たに　みつき', 2, 'bibi_pro', '01696455911', 'b.inh4chedspi@gmail.com', 'd428bd503f25a6e2474dcdca36dbb54165bc7ab1', '2013-07-31 03:23:25'),
(8, 'ほしな　げんき', 1, 'bibi_pro', '01696455911', 'bi.nh4chedspi@gmail.com', 'd428bd503f25a6e2474dcdca36dbb54165bc7ab1', '2013-07-31 03:26:04'),
(11, 'Dang Quang Duy', 1, 'HWS', '0303030303', 'dang.quang.duy@headwaters.co.jp', '51e171b27e2a1d2f4566e823172de6aa93e4cb3b', '2013-08-22 10:26:56'),
(12, '源流太郎', 1, 'IT戦略', '12345', 'kokuzawa@headwaters.co.jp', '31302642a5107762d2710556ccf1305406a9102f', '2013-08-20 19:19:47'),
(13, '安達俊也', 1, '医療情報課', '7100', 'adachi.toshiya@nihon-u.ac.jp', '69567dbc1741a7aa3289328f35c041fd78234e29', '2013-08-01 16:51:30'),
(14, 'Dang Quang Duy 2', 2, 'HWS', '0303030304', 'da.ng.quang.duy@headwaters.co.jp', 'd428bd503f25a6e2474dcdca36dbb54165bc7ab1', '2013-08-02 16:54:09'),
(15, 'test', 1, 'test', '123', 'test@ominext.com', 'd428bd503f25a6e2474dcdca36dbb54165bc7ab1', '2013-08-05 15:37:38'),
(16, 'hoai', 3, 'bm', '0982543928', 'hoaibm89@gmail.com', 'd428bd503f25a6e2474dcdca36dbb54165bc7ab1', '2013-08-05 16:06:38'),
(17, 'Maruko', 5, 'Chan', '0123', 'hoaid07cn1@gmail.com', 'd5605511c2d6b23967704118a356e3b7bd0ae9f6', '2013-08-05 16:01:37'),
(18, 'ズイ', 2, 'アジア', '3333', 'quangduy83@gmail.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 10:55:42'),
(19, 'test', 1, 'test', '123', 'test1@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 11:52:39'),
(20, 'test', 1, 'test', '123', 'test2@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 11:53:22'),
(21, 'test', 1, 'test', '123', 'test3@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 11:53:55'),
(22, 'test', 1, 'test', '123', 'test4@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 11:54:26'),
(23, 'test', 1, 'test', '123', 'test5@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 11:55:07'),
(24, 'test', 1, 'test', '123', 'test6@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 11:55:48'),
(25, 'test', 1, 'test', '123', 'test7@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 11:56:18'),
(26, 'test', 1, 'test', '123', 'test9@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 11:56:58'),
(27, 'test', 1, 'test', '123', 'test10@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 11:57:37'),
(28, 'test', 1, 'test', '123', 'test11@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 11:58:03'),
(29, 'test', 1, 'test', '123', 'test12@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 11:58:33'),
(30, 'test', 1, 'test', '123', 'test13@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 11:59:03'),
(31, 'test', 1, 'test', '123', 'test14@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 11:59:35'),
(32, 'test', 1, 'test', '123', 'test15@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 12:00:03'),
(33, 'test', 1, 'test', '123', 'test16@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 12:00:27'),
(34, 'test', 1, 'test', '123', 'test17@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 12:00:51'),
(35, 'test', 1, 'test', '123', 'test18@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 12:01:14'),
(36, 'test', 1, 'test', '123', 'test19@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 12:02:25'),
(37, 'test', 1, 'test', '123', 'test20@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 12:02:53'),
(38, 'test', 1, 'test', '123', 'test21@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 12:03:26'),
(39, 'test', 1, 'test', '123', 'test22@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 12:03:51'),
(40, 'test', 1, 'test', '123', 'test23@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 12:04:24'),
(41, 'test', 1, 'test', '123', 'test24@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 12:04:48'),
(42, 'test', 1, 'test', '123', 'test25@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 12:05:13'),
(43, 'test', 1, 'test', '123', 'test26@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 12:05:53'),
(44, 'test', 1, 'test', '123', 'test27@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 12:06:22'),
(45, 'test', 1, 'test', '123', 'test28@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 12:06:50'),
(46, 'test', 1, 'test', '123', 'test29@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 12:07:19'),
(47, 'test', 1, 'test', '123', 'test30@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 12:07:50'),
(48, 'test', 1, 'test', '123', 'test8@yahoo.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-08-06 12:30:43'),
(49, 'type3', 7, 'type3', '090', 'type3@test.com', 'd3a7cf69de5327b719435baa77b9db01409e3d35', '2013-08-13 21:26:32'),
(50, 'test4', 3, 'test4', '04', 'test4@test.com', '6f129f34fe78a60d62b71770a2e88dec1c982f1a', '2013-08-13 21:29:02'),
(51, 'test3', 3, '診療科', '0303030303', 'test3@test.com', 'd3a7cf69de5327b719435baa77b9db01409e3d35', '2013-08-14 17:14:45'),
(52, 'Duy', 3, '診療科', '0303030303', 'test8@test.com', '4922a906e078c99ebc12ffe36fa1c1953863cfac', '2013-08-14 18:09:07'),
(53, 'bibiday', 1, '循環器内科', '013232332', 'b.i.nh4c.hed.spi@gmail.com', 'd428bd503f25a6e2474dcdca36dbb54165bc7ab1', '2013-08-14 19:58:26');

-- --------------------------------------------------------

--
-- Table structure for table `tb_weeks`
--

CREATE TABLE IF NOT EXISTS `tb_weeks` (
  `week_id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `week_of_year` tinyint(3) NOT NULL,
  `year` int(11) NOT NULL,
  `str_department_ids` varchar(255) NOT NULL,
  PRIMARY KEY (`week_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `tb_weeks`
--

INSERT INTO `tb_weeks` (`week_id`, `week_of_year`, `year`, `str_department_ids`) VALUES
(1, 30, 2013, ',1,2,'),
(2, 31, 2013, ',1,2,'),
(3, 32, 2013, ',1,2,'),
(4, 34, 2013, ',4,');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
