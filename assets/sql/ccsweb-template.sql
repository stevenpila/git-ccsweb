-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 13, 2014 at 02:39 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `moodle`
--

-- --------------------------------------------------------

--
-- Table structure for table `ccs_announcements`
--

CREATE TABLE IF NOT EXISTS `ccs_announcements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `topic` varchar(300) NOT NULL,
  `detail` longtext NOT NULL,
  `file_attachments` longtext,
  `pinned` int(11) NOT NULL DEFAULT '0',
  `date_posted` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `topic` (`topic`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ccs_captcha`
--

CREATE TABLE IF NOT EXISTS `ccs_captcha` (
  `id` bigint(13) unsigned NOT NULL AUTO_INCREMENT,
  `time` int(10) unsigned NOT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `word` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `word` (`word`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ccs_captcha`
--



-- --------------------------------------------------------

--
-- Table structure for table `ccs_forum_comments`
--

CREATE TABLE IF NOT EXISTS `ccs_forum_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` longtext NOT NULL,
  `suggested` int(11) NOT NULL DEFAULT '0',
  `date_posted` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ccs_forum_threads`
--

CREATE TABLE IF NOT EXISTS `ccs_forum_threads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic` varchar(300) NOT NULL DEFAULT '',
  `detail` longtext NOT NULL,
  `file_attachments` longtext,
  `perma_link` varchar(300) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pinned` int(11) NOT NULL DEFAULT '0',
  `date_posted` datetime NOT NULL,
  `view` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `perma_link` (`perma_link`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ccs_methods`
--

CREATE TABLE IF NOT EXISTS `ccs_methods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `function` text NOT NULL,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `ccs_methods`
--

INSERT INTO `ccs_methods` (`id`, `function`, `name`) VALUES
(1, 'create_announcement', 'Create Announcement'),
(2, 'edit_announcement', 'Edit Announcement'),
(3, 'delete_announcement', 'Delete Announcement'),
(4, 'pin_announcement', 'Pin Announcement'),
(5, 'unpin_announcement', 'Unpin Announcement'),
(6, 'create_forum', 'Create Thread'),
(7, 'edit_forum', 'Edit Thread'),
(8, 'delete_forum', 'Delete Thread'),
(9, 'pin_forum', 'Pin Thread'),
(10, 'unpin_forum', 'Unpin Thread'),
(11, 'suggest_comment', 'Suggest Comment'),
(12, 'unsuggest_comment', 'Unsuggest Comment'),
(13, 'create_comment', 'Create Comment'),
(14, 'edit_comment', 'Edit Comment'),
(15, 'delete_comment', 'Delete Comment'),
(16, 'create_poll', 'Create Poll'),
(17, 'delete_poll', 'Delete Poll'),
(18, 'vote_poll_option', 'Vote Poll Option'),
(19, 'open_close_poll', 'Close/Open Poll'),
(20, 'index', 'View'),
(22, 'set_privileges', 'Set Privileges'),
(23, 'show_user_request_information', 'Show Request Information'),
(24, 'approve_decline_recall_request', 'Approve/Deny/Recall User Request'),
(25, 'delete_privileges', 'Delete Privileges'),
(26, 'upload', 'Upload Album Pictures'),
(27, 'create_album', 'Create Album'),
(28, 'delete_album', 'Delete Album'),
(29, 'rename_album', 'Rename Album'),
(30, 'delete_picture', 'Delete Album Pictures'),
(31, 'set_album_cover', 'Set Album Cover'),
(32, 'add_to_slides', 'Add Pictures to Slides');

-- --------------------------------------------------------

--
-- Table structure for table `ccs_modules`
--

CREATE TABLE IF NOT EXISTS `ccs_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `ccs_modules`
--

INSERT INTO `ccs_modules` (`id`, `name`) VALUES
(1, 'Announcement'),
(2, 'Forum'),
(3, 'Poll'),
(4, 'User Type Request'),
(5, 'Privileges'),
(6, 'Profile'),
(7, 'Gallery'),
(8, 'Album');

-- --------------------------------------------------------

--
-- Table structure for table `ccs_module_details`
--

CREATE TABLE IF NOT EXISTS `ccs_module_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `method_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `ccs_module_details`
--

INSERT INTO `ccs_module_details` (`id`, `module_id`, `method_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 20),
(8, 2, 6),
(9, 2, 7),
(10, 2, 8),
(11, 2, 9),
(12, 2, 10),
(13, 2, 11),
(14, 2, 12),
(15, 2, 13),
(16, 2, 14),
(17, 2, 15),
(18, 2, 20),
(19, 3, 16),
(20, 3, 17),
(21, 3, 18),
(22, 3, 19),
(23, 3, 20),
(24, 4, 23),
(25, 4, 24),
(27, 4, 20),
(28, 5, 22),
(29, 5, 25),
(30, 5, 20),
(31, 7, 27),
(32, 7, 28),
(33, 7, 29),
(34, 7, 30),
(35, 7, 31),
(36, 7, 32),
(37, 7, 20),
(38, 8, 26),
(39, 8, 20);

-- --------------------------------------------------------

--
-- Table structure for table `ccs_nonmoodle_user`
--

CREATE TABLE IF NOT EXISTS `ccs_nonmoodle_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) NOT NULL,
  `validemail` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(100) DEFAULT NULL,
  `confirmationcode` varchar(50) DEFAULT NULL,
  `secretquestion` int(11) NOT NULL,
  `secretanswer` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `birthdate` date DEFAULT NULL,
  `profilepicture` varchar(200) NOT NULL DEFAULT 'assets/img/default_profile_picture.jpg',
  `usertype` int(11) NOT NULL DEFAULT '7',
  `datecreated` datetime NOT NULL,
  `lastlogin` datetime NOT NULL,
  `lastlogout` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `ccs_nonmoodle_user`
--

INSERT INTO `ccs_nonmoodle_user` (`id`, `firstname`, `middlename`, `lastname`, `validemail`, `email`, `confirmationcode`, `secretquestion`, `secretanswer`, `username`, `password`, `birthdate`, `profilepicture`, `usertype`, `datecreated`, `lastlogin`, `lastlogout`) VALUES
(1, 'Steven', NULL, 'Pila', 0, 'stevenpilafour169@gmail.com', NULL, 1, 'ashley', 'stevenpila', '$2y$10$DQe3uZJGltCc7hEISvJfse8h7WJJm.PJcreUcHWVxcO7UD3HRSntS', NULL, 'assets/img/default_profile_picture.jpg', 1, '2014-03-13 08:55:33', '2014-03-13 08:55:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ccs_polls`
--

CREATE TABLE IF NOT EXISTS `ccs_polls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `topic` varchar(300) NOT NULL,
  `date_posted` datetime NOT NULL,
  `expiration` datetime DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Open',
  PRIMARY KEY (`id`),
  UNIQUE KEY `topic` (`topic`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ccs_poll_options`
--

CREATE TABLE IF NOT EXISTS `ccs_poll_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poll_id` int(11) NOT NULL,
  `option` varchar(300) NOT NULL,
  `votes` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ccs_poll_voters`
--

CREATE TABLE IF NOT EXISTS `ccs_poll_voters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `poll_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ccs_request_user_types`
--

CREATE TABLE IF NOT EXISTS `ccs_request_user_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `usertypeid` int(11) NOT NULL,
  `daterequested` datetime NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'Pending',
  `affirmedusertypeid` int(11) DEFAULT NULL,
  `dateaffirmed` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ccs_secret_question`
--

CREATE TABLE IF NOT EXISTS `ccs_secret_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `ccs_secret_question`
--

INSERT INTO `ccs_secret_question` (`id`, `name`) VALUES
(1, 'What is your pet''s name?'),
(2, 'What is your favorite subject?'),
(3, 'What is your father''s name?'),
(4, 'Where did you met your first love?');

-- --------------------------------------------------------

--
-- Table structure for table `ccs_services`
--

CREATE TABLE IF NOT EXISTS `ccs_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `url` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `ccs_services`
--

INSERT INTO `ccs_services` (`id`, `name`, `url`) VALUES
(1, 'Resume maker', NULL),
(2, 'Graduate Tracer', NULL),
(3, 'Student Portfolio', NULL),
(4, 'Job Finder', NULL),
(5, 'Job Matcher', NULL),
(6, 'IT Company Profiler', NULL),
(7, 'Learning Object CMS', NULL),
(8, 'Learning Object Organizer', NULL),
(9, 'Learning Object Account Management', NULL),
(10, 'SP Indexer', NULL),
(11, 'SP Documentation Manager', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ccs_service_details`
--

CREATE TABLE IF NOT EXISTS `ccs_service_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `service_id` varchar(100) NOT NULL,
  `affirmed_service_id` varchar(100) DEFAULT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ccs_sessions`
--

CREATE TABLE IF NOT EXISTS `ccs_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ccs_user_company_profile`
--

CREATE TABLE IF NOT EXISTS `ccs_user_company_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `companyname` varchar(100) DEFAULT NULL,
  `companyaddress` varchar(300) DEFAULT NULL,
  `companyemail` varchar(100) DEFAULT NULL,
  `companywebsite` varchar(100) DEFAULT NULL,
  `companycontactnumber` varchar(100) DEFAULT NULL,
  `companyposition` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `ccs_user_types`
--

CREATE TABLE IF NOT EXISTS `ccs_user_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `ccs_user_types`
--

INSERT INTO `ccs_user_types` (`id`, `name`) VALUES
(1, 'Super Administrator'),
(2, 'Administrator'),
(3, 'Employee'),
(4, 'Faculty'),
(5, 'Alumni'),
(6, 'Student'),
(7, 'Guest');

-- --------------------------------------------------------

--
-- Table structure for table `ccs_user_type_details`
--

CREATE TABLE IF NOT EXISTS `ccs_user_type_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type_id` int(11) NOT NULL,
  `module_detail_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
