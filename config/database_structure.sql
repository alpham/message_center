-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 20, 2013 at 10:41 PM
-- Server version: 5.5.30
-- PHP Version: 5.4.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `message_center`
--

-- --------------------------------------------------------

--
-- Table structure for table `errors`
--

CREATE TABLE IF NOT EXISTS `errors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `string` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `errors`
--

INSERT INTO `errors` (`id`, `string`) VALUES
(1, 'page not found!'),
(2, 'View not found!'),
(3, 'user is not registered!'),
(4, 'method not found!'),
(5, 'error in query!');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `body` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sender` int(11) NOT NULL,
  `receiver` int(11) NOT NULL,
  `receivers_list` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `sender_place` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'sentbox',
  PRIMARY KEY (`id`),
  KEY `FK_SENDER_USER` (`sender`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `receivers_list`
--

CREATE TABLE IF NOT EXISTS `receivers_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `USERS__RECEIVERS_LIST_FK` (`sender_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `receivers_users`
--

CREATE TABLE IF NOT EXISTS `receivers_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `list_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message_place` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `USERS__RECEIVERS_USERS_FK` (`user_id`),
  KEY `RECEIVERS_LIST__RECEIVERS_USERS_FK` (`list_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(50) NOT NULL,
  `state` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'online',
  `avatar` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'public/avatar/avatar.png',
  PRIMARY KEY (`id`,`username`),
  UNIQUE KEY `username` (`username`),
  KEY `username_2` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `state`, `avatar`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'online', 'public/avatar/avatar.png'),
(2, 'ahmed', 'e10adc3949ba59abbe56e057f20f883e', 'online', 'public/avatar/avatar.png'),
(6, 'ahmed1', 'ahmed', 'online', 'public/avatar/avatar.png');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `receivers_list`
--
ALTER TABLE `receivers_list`
  ADD CONSTRAINT `USERS__RECEIVERS_LIST_FK` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `receivers_users`
--
ALTER TABLE `receivers_users`
  ADD CONSTRAINT `RECEIVERS_LIST__RECEIVERS_USERS_FK` FOREIGN KEY (`list_id`) REFERENCES `receivers_list` (`id`),
  ADD CONSTRAINT `USERS__RECEIVERS_USERS_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);


--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `FK_SENDER_USER` FOREIGN KEY (`sender`) REFERENCES `users` (`id`);


ALTER TABLE `messages`
  ADD CONSTRAINT `RECEIVERS_LIST__MESSAGES_FK` FOREIGN KEY (`receiver`) REFERENCES `receivers_list`(`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
