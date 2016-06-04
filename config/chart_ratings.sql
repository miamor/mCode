-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 01, 2016 at 12:38 PM
-- Server version: 5.6.14
-- PHP Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `astro`
--

-- --------------------------------------------------------

--
-- Table structure for table `chart_ratings`
--

CREATE TABLE IF NOT EXISTS `chart_ratings` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `uid` int(255) NOT NULL,
  `uip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `iid` int(255) NOT NULL,
  `rate` int(1) NOT NULL,
  `title` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `likes` longtext COLLATE utf8_unicode_ci NOT NULL,
  `dislikes` longtext COLLATE utf8_unicode_ci NOT NULL,
  `show` int(1) NOT NULL DEFAULT '1',
  `time` char(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `chart_ratings`
--

INSERT INTO `chart_ratings` (`id`, `uid`, `uip`, `iid`, `rate`, `title`, `content`, `likes`, `dislikes`, `show`, `time`) VALUES
(1, 1, '', 1, 4, 'Good', 'hehe', '', '', 1, '1434427613');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
