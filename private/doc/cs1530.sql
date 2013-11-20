-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: drew.db
-- Generation Time: Nov 20, 2013 at 09:09 PM
-- Server version: 5.3.12-MariaDB
-- PHP Version: 5.3.27-nfsn1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cs1530`
--

-- --------------------------------------------------------

--
-- Table structure for table `e_events`
--

CREATE TABLE IF NOT EXISTS `e_events` (
  `e_id` int(6) NOT NULL AUTO_INCREMENT,
  `e_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Name',
  `e_date` datetime NOT NULL COMMENT 'Date / Time',
  `e_descrip` varchar(1000) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Description',
  `e_private` int(1) NOT NULL COMMENT 'Privacy type flag',
  `p_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `l_id` int(11) NOT NULL,
  PRIMARY KEY (`e_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Table structure for table `e_follow`
--

CREATE TABLE IF NOT EXISTS `e_follow` (
  `f_id` int(6) NOT NULL AUTO_INCREMENT COMMENT 'Follow ID',
  `u_head_id` int(6) NOT NULL COMMENT 'Follower (head)',
  `u_tail_id` int(6) NOT NULL COMMENT 'Following (tail)',
  PRIMARY KEY (`f_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Follow Table' AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `e_inv`
--

CREATE TABLE IF NOT EXISTS `e_inv` (
  `i_id` int(6) NOT NULL,
  `e_id` int(6) NOT NULL COMMENT 'Event ID',
  `u_inv_id` int(6) NOT NULL COMMENT 'User (inviter) ID',
  `u_gu_id` int(6) NOT NULL COMMENT 'User (guest) ID',
  `i_cmt` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Invite table';

-- --------------------------------------------------------

--
-- Table structure for table `e_location`
--

CREATE TABLE IF NOT EXISTS `e_location` (
  `l_id` int(11) NOT NULL AUTO_INCREMENT,
  `l_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `l_address` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `l_lat` float(10,6) DEFAULT NULL,
  `l_lng` float(10,6) DEFAULT NULL,
  PRIMARY KEY (`l_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=73 ;

-- --------------------------------------------------------

--
-- Table structure for table `e_pictures`
--

CREATE TABLE IF NOT EXISTS `e_pictures` (
  `p_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL COMMENT 'Uploading user',
  `p_path` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `p_type` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`p_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `e_rsvp`
--

CREATE TABLE IF NOT EXISTS `e_rsvp` (
  `r_id` int(6) NOT NULL AUTO_INCREMENT COMMENT 'RSVP ID',
  `e_id` int(6) NOT NULL COMMENT 'Event ID',
  `u_id` int(6) NOT NULL COMMENT 'User ID',
  `rsvp` int(1) NOT NULL COMMENT 'RSVP type',
  PRIMARY KEY (`r_id`),
  KEY `e_id` (`e_id`,`u_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='RSVP table' AUTO_INCREMENT=67 ;

-- --------------------------------------------------------

--
-- Table structure for table `e_users`
--

CREATE TABLE IF NOT EXISTS `e_users` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'User id',
  `u_status` int(2) NOT NULL DEFAULT '0',
  `u_admin` int(1) NOT NULL,
  `u_activecode` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `u_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL COMMENT 'User name',
  `u_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Email',
  `u_pass` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Pass (sha1)',
  `p_id` int(11) NOT NULL,
  `l_id` int(11) NOT NULL,
  PRIMARY KEY (`u_id`),
  UNIQUE KEY `u_name` (`u_name`,`u_email`),
  UNIQUE KEY `u_name_2` (`u_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='User table' AUTO_INCREMENT=143 ;

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `type` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `details` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
