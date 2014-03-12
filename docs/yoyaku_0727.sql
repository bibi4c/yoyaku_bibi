-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 27, 2013 at 06:11 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `om_yoyaku`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tb_courses`
--

CREATE TABLE IF NOT EXISTS `tb_courses` (
  `course_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  PRIMARY KEY (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=20 ;

--
-- Dumping data for table `tb_courses`
--

INSERT INTO `tb_courses` (`course_id`, `course_name`, `department_id`, `last_update`) VALUES
(1, '医師①', 1, '2013-07-25 00:00:00'),
(2, '医師②', 1, '2013-07-25 00:00:00'),
(3, '医師③', 1, '2013-07-25 00:00:00'),
(4, '医師③＋レジメン編', 2, '2013-07-25 00:00:00'),
(5, '外来看護師リーダ①', 3, '2013-07-25 00:00:00'),
(6, '外来看護師リーダ②', 3, '2013-07-25 00:00:00'),
(7, '外来看護師リーダ③', 3, '2013-07-25 00:00:00'),
(8, '病棟看護師リーダ①', 4, '2013-07-25 00:00:00'),
(9, '病棟看護師リーダ②', 4, '2013-07-25 00:00:00'),
(10, '病棟看護師リーダ③', 4, '2013-07-25 00:00:00'),
(11, '病棟看護師リーダ④', 4, '2013-07-25 00:00:00'),
(12, '病棟看護師リーダ⑤', 4, '2013-07-25 00:00:00'),
(13, '病棟看護師リーダ⑥', 4, '2013-07-25 00:00:00'),
(14, '部門リーダ', 5, '2013-07-25 00:00:00'),
(15, '医師リーダ', 6, '2013-07-25 00:00:00'),
(16, '外来看護師', 7, '2013-07-25 00:00:00'),
(17, '病棟看護師①', 8, '2013-07-25 00:00:00'),
(18, '病棟看護師②', 8, '2013-07-25 00:00:00'),
(19, '病棟看護師③', 8, '2013-07-25 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=15 ;

--
-- Dumping data for table `tb_schedules`
--

INSERT INTO `tb_schedules` (`schedule_id`, `course_id`, `timetable_id`, `date`, `num_members_ordered`, `max_members`, `last_update`) VALUES
(1, 2, 1, '2013-07-27', 0, 30, '2013-07-27 00:00:00'),
(2, 3, 2, '2013-07-27', 0, 30, '2013-07-27 00:00:00'),
(3, 3, 3, '2013-07-29', 0, 30, '2013-07-27 00:00:00'),
(4, 3, 5, '2013-07-29', 0, 30, '2013-07-27 00:00:00'),
(5, 1, 1, '2013-07-29', 0, 30, '2013-07-27 00:00:00'),
(6, 7, 2, '2013-07-30', 0, 30, '2013-07-27 00:00:00'),
(7, 5, 4, '2013-07-27', 0, 30, '2013-07-27 00:00:00'),
(8, 3, 2, '2013-07-26', 0, 30, '2013-07-27 00:00:00'),
(9, 4, 3, '2013-07-31', 0, 30, '2013-07-27 00:00:00'),
(10, 2, 4, '2013-07-31', 0, 30, '2013-07-27 00:00:00'),
(11, 1, 2, '2013-07-30', 0, 30, '2013-07-27 00:00:00'),
(12, 2, 3, '2013-08-01', 0, 30, '2013-07-27 00:00:00'),
(13, 1, 2, '2013-08-02', 0, 30, '2013-07-27 00:00:00'),
(14, 1, 4, '2013-07-31', 0, 30, '2013-07-27 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tb_timetables`
--

CREATE TABLE IF NOT EXISTS `tb_timetables` (
  `timetable_id` int(11) NOT NULL AUTO_INCREMENT,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `last_update` datetime DEFAULT NULL,
  PRIMARY KEY (`timetable_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tb_timetables`
--

INSERT INTO `tb_timetables` (`timetable_id`, `start_time`, `end_time`, `last_update`) VALUES
(1, '13:30:00', '15:30:00', NULL),
(2, '16:00:00', '18:00:00', '2013-07-25 00:00:00'),
(3, '18:30:00', '20:30:00', '2013-07-25 00:00:00'),
(4, '08:00:00', '12:00:00', '2013-07-25 00:00:00'),
(5, '16:00:00', '17:45:00', NULL),
(6, '18:15:00', '20:00:00', '2013-07-25 00:00:00');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`user_id`, `name`, `department_id`, `part_name`, `phs`, `mail_address`, `password`, `last_update`) VALUES
(1, 'admin', 0, 'admin', '01696455911', 'binh4chedspi@gmail.com', '7d573f04710df3176f24937e7dd751ca6e1352e7', '2013-07-23 07:20:36'),
(2, 'bibi4c', 1, '医師', '0902260591', 'binhnd@ominext.com', 'e02fc6f53f67aa1a9e546ec12207ab7ac18f2f03', '2013-07-27 05:56:30'),
(3, 'bibi', 2, 'bibi', '1212', 'binh4chedspi@gmaidl.com', 'd4a2931df72fba9c5860d668d52290e90d4077bc', '2013-07-26 12:22:41'),
(4, 'babi', 3, 'ominext', '01696455911', 'binh@gmail.com', 'd428bd503f25a6e2474dcdca36dbb54165bc7ab1', '2013-07-26 12:25:17'),
(5, 'bibi', 2, 'bibiday', '01696455911', 'binh4ched.spi@gmail.com', '55d8adf9b9b0133a76d5e5398d32443717fd613b', '2013-07-27 06:12:03');

-- --------------------------------------------------------

--
-- Table structure for table `tb_weeks`
--

CREATE TABLE IF NOT EXISTS `tb_weeks` (
  `week_id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `week_of_year` tinyint(3) NOT NULL,
  `year` int(11) NOT NULL,
  PRIMARY KEY (`week_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tb_weeks`
--

INSERT INTO `tb_weeks` (`week_id`, `week_of_year`, `year`) VALUES
(1, 30, 2013),
(2, 31, 2013);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
