-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 06, 2014 at 07:26 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `new`
--

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

DROP TABLE IF EXISTS `conversations`;
CREATE TABLE IF NOT EXISTS `conversations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `days_to_expiry` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `conversations`
--

INSERT INTO `conversations` (`id`, `title`, `days_to_expiry`, `thread_id`, `created_at`, `updated_at`) VALUES
(1, 'an example conversation', 2, 1, '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(2, 'Aids In Uganda', 10, 1, '2014-04-05 22:55:17', '2014-04-05 22:55:17');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_03_21_084504_create_users_table', 1),
('2014_03_21_124202_create_posts_table', 1),
('2014_03_21_132157_create_conversations_table', 1),
('2014_03_30_074422_create_specialities_table', 1),
('2014_04_02_205700_create_settings_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name_of_attachment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link_to_video` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `conversation_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `content`, `name_of_attachment`, `link_to_video`, `conversation_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'an example post', '', '', 1, '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(2, 1, '<p><span style="font-weight: bold; font-style: italic;">seriously </span>aids is killing all our youth.we gots to do something</p>', 'TGEZJr_bootstrap.zip', 'https://www.youtube.com/watch?v=kxwC5ic-s6M&list=PL83E8B245976AFF22', 2, '2014-04-05 22:55:17', '2014-04-05 22:55:17'),
(3, 5, '<p>waa stop siking.jst hating</p>', '', '', 2, '2014-04-05 23:25:08', '2014-04-05 23:25:08'),
(4, 6, '<p>he isnt siking...he is just stating a fact</p>', '', '', 2, '2014-04-05 23:27:14', '2014-04-05 23:27:14');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_name_unique` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'appearance', 'Light', '2014-04-05 22:31:01', '2014-04-05 22:31:01'),
(2, 'forum_title', '', '2014-04-05 22:31:01', '2014-04-06 05:24:15'),
(3, 'payment_duration', '1', '2014-04-05 22:31:01', '2014-04-05 22:31:01'),
(4, 'approval', 'No', '2014-04-05 22:31:01', '2014-04-05 23:24:22'),
(5, 'suspension_duration', '3', '2014-04-05 22:31:01', '2014-04-05 22:31:01'),
(6, 'registration', 'Yes', '2014-04-05 22:31:01', '2014-04-05 22:31:01'),
(7, 'send_email', 'No', '2014-04-05 22:31:01', '2014-04-05 23:24:22');

-- --------------------------------------------------------

--
-- Table structure for table `specialities`
--

DROP TABLE IF EXISTS `specialities`;
CREATE TABLE IF NOT EXISTS `specialities` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `speciality` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=47 ;

--
-- Dumping data for table `specialities`
--

INSERT INTO `specialities` (`id`, `speciality`, `created_at`, `updated_at`) VALUES
(1, 'Andrologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(2, 'Anesthesiologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(3, 'Allergist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(4, 'Audiologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(5, 'Cardiologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(6, 'Dentist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(7, 'Dermatologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(8, 'Endocrinologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(9, 'Epidemiologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(10, 'Family Practician', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(11, 'Gastroenterologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(12, 'Gynecologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(13, 'Hematologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(14, 'Hepatologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(15, 'Immunologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(16, 'Infectious Disease Specialist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(17, 'Internal Medicine Specialist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(18, 'Internist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(19, 'Medical Geneticist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(20, 'Microbiologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(21, 'Neonatologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(22, 'Nephrologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(23, 'Neurologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(24, 'Neurosurgeon', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(25, 'Nurse', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(26, 'Obstetrician', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(27, 'Oncologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(28, 'Ophthalmologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(29, 'Orthopedic Surgeon', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(30, 'ENT specialist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(31, 'Perinatologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(32, 'Paleopathologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(33, 'Parasitologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(34, 'Pathologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(35, 'Pediatrician', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(36, 'Physiologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(37, 'Physiatrist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(38, 'Plastic Surgeon', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(39, 'Podiatrist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(40, 'Psychiatrist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(41, 'Pulmonologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(42, 'Radiologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(43, 'Rheumatologsist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(44, 'Surgeon', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(45, 'Urologist', '2014-04-05 22:30:57', '2014-04-05 22:30:57'),
(46, 'Emergency Doctor', '2014-04-05 22:30:57', '2014-04-05 22:30:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Location` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `about_me` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `speciality` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `current_hospital` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name_of_pic` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `account_type`, `Location`, `about_me`, `full_name`, `speciality`, `current_hospital`, `gender`, `name_of_pic`, `status`, `created_at`, `updated_at`) VALUES
(1, 'nsubugak@yahoo.com', 'nsubugak', '$2y$10$KAgXRCCXbuB7uWb885vKSOvcDmxMdwVNidQkw3KsNi37hF0isMaEK', 'Administrator', 'kampala', 'Imagine me', 'Nsubuga Kasozi', 'Cardiologist', 'Case', 'Male', '675PLN_Capture.JPG', 'active', '2014-04-05 22:30:56', '2014-04-05 22:59:10'),
(2, 'Peter@KadicBlahBlahBlah.com', 'peter', '$2y$10$PnhQf6Uj4i3tRjN1OjxlI.bSzt9BJYsb9VzPr9lDd1DdzPaZmrbGi', 'Administrator', 'kampala', 'Imagine me', '', '', '', '', 'guest.png', 'active', '2014-04-05 22:30:56', '2014-04-05 22:30:56'),
(3, 'Dr.Emma@KadicBlahBlah.com', 'emma', '$2y$10$x0SfOIyTUbt8UfeKnXJoaOxXIik53JDbm8TLpwV9J/q2oSwuwSnOm', 'Administrator', 'kampala', 'Imagine me', '', '', '', '', 'guest.png', 'active', '2014-04-05 22:30:56', '2014-04-05 22:30:56'),
(4, 'user@KadicBlahBlah.com', 'user', '$2y$10$Y0jQT/PdLM1kRnjvIw8l6.vFQ5Rl3JfQOa9S2GOF2LD46ZGYxbzNO', 'member', 'kampala', 'Imagine me', '', '', '', '', 'guest.png', 'active', '2014-04-05 22:30:56', '2014-04-05 22:30:56'),
(5, 'josh@home.com', 'josh', '$2y$10$GHMQ3WQcnPUDiWzZyIYqAudOzzopxJC3wxWOn4bzd7LxX59jhSaNu', 'member', 'Bukoto', '', 'njovu joshua', 'Dentist', 'Kadic', 'Male', 'dTqssq_42575.jpg', 'active', '2014-04-05 23:23:30', '2014-04-09 23:38:23'),
(6, 'kasoma@home.com', 'kasoma', '$2y$10$S3xaRCatST29Y0ldg/zT7eOMTcXhQqetb4Ev2cPLrmvI503IsGvxK', 'member', 'Wandegeya', '', 'kasoma Fredrick', 'Andrologist', 'Case', 'Male', 'guest.png', 'active', '2014-04-05 23:26:28', '2014-04-05 23:27:14');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
