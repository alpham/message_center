-- phpMyAdmin SQL Dump
-- version 3.5.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 26, 2013 at 04:39 AM
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
  `type` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'error',
  `string` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `errors`
--

INSERT INTO `errors` (`id`, `type`, `string`) VALUES
(1, 'error', 'page not found!'),
(2, 'error', 'View not found!'),
(3, 'error', 'user is not registered!'),
(4, 'error', 'method not found!'),
(5, 'error', 'error in query!'),
(6, 'success', 'Message sent successfully '),
(7, 'info', 'No message specified to apply action : ');

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
  KEY `FK_SENDER_USER` (`sender`),
  KEY `RECEIVERS_LIST__MESSAGES_FK` (`receiver`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=26 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `subject`, `body`, `time`, `sender`, `receiver`, `receivers_list`, `sender_place`) VALUES
(20, 'l;kajsdfkljh ', 'lkjdfklaj sdflwefjaklsej fl;ijua', '2013-04-25 16:08:11', 1, 22, 'ahmed,ahmed1', 'trash'),
(21, 'kjajksdfkashdfjklh', ';lkajg;kljasdkl;f as;dfh klajwehf awuerakludhf ljk;lkajg;kljasdkl;f as;dfh klajwehf awuerakludhf ljk;lkajg;kljasdkl;f as;dfh klajwehf awuerakludhf ljk;lkajg;kljasdkl;f as;dfh klajwehf awuerakludhf ljk;lkajg;kljasdkl;f as;dfh klajwehf awuerakludhf ljk;lkajg;kljasdkl;f as;dfh klajwehf awuerakludhf ljk;lkajg;kljasdkl;f as;dfh klajwehf awuerakludhf ljk;lkajg;kljasdkl;f as;dfh klajwehf awuerakludhf ljk;lkajg;kljasdkl;f as;dfh klajwehf awuerakludhf ljk;lkajg;kljasdkl;f as;dfh klajwehf awuerakludhf ljk', '2013-04-25 16:08:11', 2, 23, 'admin , ahmed1', 'sentbox'),
(22, 'kljhasjkldfhh fhasjkldhf alka uawheflkh ', 'lklajoiau dfhajklsdhf laukh', '2013-04-25 16:13:35', 2, 24, 'ahmed1', 'sentbox'),
(23, 'hi there', 'ay kalam hena', '2013-04-25 21:50:58', 1, 25, 'ahmed1', 'sentbox'),
(24, 'replay to ay haga', 'نجرب الكلام بالعربي كده !!', '2013-04-25 21:53:17', 6, 26, 'admin', 'sentbox'),
(25, 'replay to ay haga', 'نجرب الكلام بالعربي كده !!', '2013-04-25 21:53:28', 6, 26, 'admin', 'sentbox');

-- --------------------------------------------------------

--
-- Table structure for table `receivers_list`
--

CREATE TABLE IF NOT EXISTS `receivers_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `USERS__RECEIVERS_LIST_FK` (`sender_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `receivers_list`
--

INSERT INTO `receivers_list` (`id`, `sender_id`) VALUES
(22, 1),
(25, 1),
(23, 2),
(24, 2),
(26, 6);

-- --------------------------------------------------------

--
-- Table structure for table `receivers_users`
--

CREATE TABLE IF NOT EXISTS `receivers_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `list_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message_place` varchar(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'inbox',
  PRIMARY KEY (`id`),
  KEY `USERS__RECEIVERS_USERS_FK` (`user_id`),
  KEY `RECEIVERS_LIST__RECEIVERS_USERS_FK` (`list_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `receivers_users`
--

INSERT INTO `receivers_users` (`id`, `list_id`, `user_id`, `message_place`) VALUES
(1, 22, 2, 'inbox'),
(2, 22, 6, 'inbox'),
(3, 23, 1, 'inbox'),
(4, 23, 6, 'inbox'),
(5, 24, 6, 'inbox'),
(6, 25, 6, 'inbox'),
(7, 26, 1, 'inbox');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `theme` varchar(10) NOT NULL DEFAULT 'default',
  PRIMARY KEY (`id`),
  KEY `USERS_ID__SETTINGS` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `user_id`, `theme`) VALUES
(1, 1, 'default'),
(2, 2, 'default'),
(3, 6, 'default');

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
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `FK_SENDER_USER` FOREIGN KEY (`sender`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `RECEIVERS_LIST__MESSAGES_FK` FOREIGN KEY (`receiver`) REFERENCES `receivers_list` (`id`);

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
-- Constraints for table `settings`
--
ALTER TABLE `settings`
  ADD CONSTRAINT `USERS_ID__SETTINGS` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
