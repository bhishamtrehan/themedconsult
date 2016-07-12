-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 03, 2016 at 10:31 AM
-- Server version: 5.5.46-0ubuntu0.14.04.2
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `themedconsult`
--

-- --------------------------------------------------------

--
-- Table structure for table `mc_login_attempts`
--

CREATE TABLE IF NOT EXISTS `mc_login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
  `login` varchar(50) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- Dumping data for table `mc_login_attempts`
--

INSERT INTO `mc_login_attempts` (`id`, `ip_address`, `login`, `time`) VALUES
(1, '::1', 'paritosh@visions.net.in', '2016-03-02 05:03:34');

-- --------------------------------------------------------

--
-- Table structure for table `mc_perm_data`
--

CREATE TABLE IF NOT EXISTS `mc_perm_data` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `permKey` varchar(30) NOT NULL,
  `permName` varchar(30) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mc_perm_data`
--

INSERT INTO `mc_perm_data` (`ID`, `permKey`, `permName`) VALUES
(1, 'master_access', 'master admin'),
(2, 'clinic_access', 'clinic admin'),
(3, 'practitioner_access', 'practitioner access'),
(4, 'patient_access', 'patient access');

-- --------------------------------------------------------

--
-- Table structure for table `mc_role`
--

CREATE TABLE IF NOT EXISTS `mc_role` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT,
  `roleName` varchar(30) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mc_role`
--

INSERT INTO `mc_role` (`ID`, `roleName`) VALUES
(1, 'Master Admin'),
(2, 'Clinic Admin'),
(3, 'Practitioner'),
(4, 'Patient');

-- --------------------------------------------------------

--
-- Table structure for table `mc_role_perms`
--

CREATE TABLE IF NOT EXISTS `mc_role_perms` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` tinyint(20) NOT NULL,
  `permID` tinyint(20) NOT NULL,
  `value` tinyint(1) NOT NULL DEFAULT '0',
  `addDate` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `roleID_2` (`role_id`,`permID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mc_role_perms`
--

INSERT INTO `mc_role_perms` (`ID`, `role_id`, `permID`, `value`, `addDate`) VALUES
(3, 1, 1, 1, '2016-03-02 05:15:20'),
(4, 2, 2, 1, '2016-03-02 15:18:00');

-- --------------------------------------------------------

--
-- Table structure for table `mc_sessions`
--

CREATE TABLE IF NOT EXISTS `mc_sessions` (
  `session_id` varchar(40) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `ip_address` varchar(16) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `mc_sessions`
--

INSERT INTO `mc_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('022390279be2a99c489c625fef0f55ac', '::1', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/47.0.2526.106 Chrome/47.0.2526.106 ', 1456981287, 'a:5:{s:9:"user_data";s:0:"";s:7:"user_id";s:1:"1";s:8:"username";s:9:"test_user";s:6:"status";s:1:"1";s:9:"user_role";s:1:"1";}'),
('55cd888784d717be26872dc379e8d35d', '::1', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/47.0.2526.106 Chrome/47.0.2526.106 ', 1456980263, 'a:5:{s:9:"user_data";s:0:"";s:7:"user_id";s:1:"1";s:8:"username";s:9:"test_user";s:6:"status";s:1:"1";s:9:"user_role";s:1:"1";}'),
('af2ef37addc54477e85ea9146b9de2f0', '::1', 'Mozilla/5.0 (X11; Linux i686) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/47.0.2526.106 Chrome/47.0.2526.106 ', 1456925153, 'a:5:{s:9:"user_data";s:0:"";s:7:"user_id";s:1:"1";s:8:"username";s:9:"test_user";s:6:"status";s:1:"1";s:9:"user_role";s:1:"1";}');

-- --------------------------------------------------------

--
-- Table structure for table `mc_speciality`
--

CREATE TABLE IF NOT EXISTS `mc_speciality` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `speciality` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `mc_speciality`
--

INSERT INTO `mc_speciality` (`ID`, `speciality`, `date`) VALUES
(1, 'Addiction Medicine', '2016-03-02 10:54:23'),
(2, 'Anaesthesia', '2016-03-02 10:54:23'),
(3, 'Dermatology', '2016-03-02 10:54:41'),
(4, 'Emergency medicine', '2016-03-02 10:54:41'),
(5, 'Intensive Care Medicine Adult Intensive Care Med', '2016-03-02 12:58:42');

-- --------------------------------------------------------

--
-- Table structure for table `mc_users`
--

CREATE TABLE IF NOT EXISTS `mc_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `new_password_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mc_users`
--

INSERT INTO `mc_users` (`id`, `username`, `password`, `email`, `activated`, `banned`, `ban_reason`, `new_password_key`, `new_password_requested`, `new_email`, `new_email_key`, `last_ip`, `last_login`, `created`, `modified`) VALUES
(1, 'test_user', '$2a$08$VTsbDId3RFXEzWZ/gFQAmedutLAr7ugPz11MYnSrU1sxJpolWVn2W', 'paritosh@visions.net.in', 1, 0, NULL, NULL, NULL, NULL, 'b96dbab73ad6702a297d422011b282a7', '::1', '2016-03-03 10:15:51', '2016-03-01 15:56:01', '2016-03-03 04:45:51'),
(2, 'clinic_admin', '$2a$08$ASJCnQWRTW5BRO46fNjkyuJXsFNg9sSjAOKxstJhgYlhY1GrVS6VS', 'clinic@gmail.com', 1, 0, NULL, NULL, NULL, NULL, '520f44072103fdd5112513162d238927', '::1', '2016-03-02 14:07:47', '2016-03-02 13:15:55', '2016-03-02 08:37:47');

-- --------------------------------------------------------

--
-- Table structure for table `mc_user_autologin`
--

CREATE TABLE IF NOT EXISTS `mc_user_autologin` (
  `key_id` char(32) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `mc_user_perms`
--

CREATE TABLE IF NOT EXISTS `mc_user_perms` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` tinyint(20) NOT NULL,
  `permID` tinyint(20) NOT NULL,
  `value` tinyint(1) NOT NULL DEFAULT '0',
  `addDate` datetime NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `userID` (`user_id`,`permID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mc_user_profiles`
--

CREATE TABLE IF NOT EXISTS `mc_user_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `mc_user_roles`
--

CREATE TABLE IF NOT EXISTS `mc_user_roles` (
  `user_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`user_role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mc_user_roles`
--

INSERT INTO `mc_user_roles` (`user_role_id`, `user_id`, `role_id`) VALUES
(1, 1, 1),
(2, 2, 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
