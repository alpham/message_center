-- phpMyAdmin SQL Dump
-- version 3.5.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 30, 2013 at 02:24 AM
-- Server version: 5.5.30
-- PHP Version: 5.4.14

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

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
(7, 'info', 'No message specified to apply action : '),
(8, 'error', 'something is missing'),
(9, 'success', 'process successfully done :) '),
(10, 'error', 'login error : system confused!'),
(11, 'error', 'login error : username or password is incorrect.');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=251 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `subject`, `body`, `time`, `sender`, `receiver`, `receivers_list`, `sender_place`) VALUES
(231, 'kjhasdkjh jkh a', 'oiasd kljahwfjkl ajkh', '2013-04-27 18:11:40', 1, 236, 'ahmed,ahmed1', 'sentbox'),
(232, 'hi admin ..', 'hi admin :) my name is Ahmed and i''d like to be friends', '2013-04-28 05:00:29', 2, 237, 'admin', 'sentbox'),
(233, 'hi ahmed ', 'i''ve received your message .. of course dear we can be friends :D', '2013-04-28 05:02:36', 1, 238, 'ahmed', 'sentbox'),
(234, '??? ? ?????? ????? :P', '??? ???? ?????? ? ???? ??? ???? ????? ? ?? ????  :P \r\n??? ???? ?????? ? ??? ?? :P', '2013-04-28 05:05:10', 2, 239, 'ahmed1', 'trash'),
(235, 'Ø¥Ø²ÙŠÙƒ ÙŠØ§Ø¯ ', 'Ø¹Ø§Ù…Ù„ Ø¥ÙŠÙ‡ ØŸØŸ\r\nÙ…Ø¨ØªØ³Ø£Ù„Ø´ Ù„ÙŠÙ‡ ØŸ\r\n', '2013-04-28 21:57:23', 1, 241, 'ahmed', 'sentbox'),
(236, 'Ø£Ù†Ø§ ØµØ§Ø­Ø¨ Ø§Ù„Ø£Ø¯Ù…Ù† Ùˆ Ø£Ù†Øª Ù„Ø£ :P ', 'Ø£Ù†Ø§ ÙƒÙ„Ù…Øª Ø§Ù„Ø£Ø¯Ù…Ù† Ùˆ Ø¨Ù‚ÙŠØª Ø£Ù†Ø§ Ùˆ Ù‡Ùˆ Ø£ØµØ­Ø§Ø¨ :P Ùˆ ÙƒÙ„Ù…Ù†ÙŠ Ùˆ Ø¨ÙŠØ³Ø£Ù„ Ø¹Ù„ÙŠØ§ :p ÙˆÙˆ Ø£Ù†Øª Ù„Ø£ :p', '2013-04-28 22:02:59', 2, 242, 'ahmed1', 'sentbox'),
(237, 'Ùˆ Ø¥ÙŠÙ‡ ÙŠØ¹Ù†ÙŠ :(', 'Ø£ØµÙ„Ø§Ù‹ Ø¹Ø§Ø¯ÙŠ .. Ùˆ Ø¥ÙŠÙ‡ ÙŠØ¹Ù†ÙŠ :''(', '2013-04-28 22:03:57', 6, 243, 'ahmed', 'sentbox'),
(238, 'Ù‡Ù‡Ù‡Ù‡Ù‡Ù‡Ù‡Ù‡Ù‡Ù‡Ù‡Ù‡Ù‡Ù‡Ù‡Ù‡Ù‡Ù‡Ù‡Ù‡Ù‡Ù‡Ù‡Ù‡Ù‡ .. Ø®Ù„Ø§Øµ Ù…ØªØ¹ÙŠØ·Ø´ :D', 'Ø®Ù„Ø§Øµ Ù‡Ø£ÙƒÙ„Ù…Ù‡ Ùˆ Ø£Ø®Ù„ÙŠÙ‡ ÙŠØ¨Ù‚Ù‰ ØµØ§Ø­Ø¨Ùƒ Ø£Ù†Øª ÙƒÙ…Ø§Ù† :D', '2013-04-28 22:07:15', 2, 244, 'ahmed1', 'sentbox'),
(239, 'hi admin .. how are you ??', 'I''d like you to meet my friend @ahmed1@ he is such a good friend :)', '2013-04-28 22:18:17', 2, 245, 'admin', 'sentbox'),
(240, 'It''s such a pleasure :)', 'Oh dear .. of course your friend is my friend as well :)', '2013-04-28 22:19:52', 1, 246, 'ahmed', 'sentbox'),
(241, 'hi ahmed1 :D', '@ahmed@ and I talked about you .. he said that you''re such a good friend .. I hope you accept my friendship :)', '2013-04-28 22:23:34', 1, 247, 'ahmed1', 'sentbox'),
(242, 'hi admin', '', '2013-04-28 22:24:32', 6, 248, 'admin ', 'sentbox'),
(243, 'sorry about the empty message :)', 'hi admin ... \r\nof course I''m proud of your friendship :)', '2013-04-28 22:26:11', 6, 249, 'admin', 'sentbox'),
(244, 'Ø­Ù„Ø§ÙˆØªÙƒ :)', 'Ø­Ø¨ÙŠØ¨ Ù‚Ù„Ø¨ÙŠ ÙŠØ§ Ø£Ø¨Ùˆ Ø­Ù…ÙŠØ¯ .. Ùˆ Ø±Ø¨Ù†Ø§ Ø£Ù†Øª Ø¨Ø±Ù†Ø³ \r\nØ§Ù„Ø£Ø¯Ù…Ù† ÙƒÙ„Ù…Ù†ÙŠ Ùˆ Ø¨Ù‚ÙŠÙ†Ø§ Ø£ØµØ­Ø§Ø¨ :D', '2013-04-28 22:26:59', 6, 250, 'ahmed', 'sentbox'),
(245, 'Ø£ÙŠ Ø®Ø¯Ù…Ø© :D ', 'Ø¨Ø³ Ø¹Ù„Ø´Ø§Ù† Ù…ØªØ¹ÙŠØ·Ø´ :P', '2013-04-28 22:27:35', 2, 251, 'ahmed1', 'sentbox'),
(246, 'hi there ', 'just try compose new submit button', '2013-04-28 23:15:16', 6, 252, 'admin', 'sentbox'),
(247, 'lkhjsdkfhj', ':D :D :D :D :D :D :D :D :D ', '2013-04-29 05:06:25', 6, 253, 'admin', 'sentbox'),
(248, 'try my emotions', ':D :P :O :p :o :) :( :''(', '2013-04-29 05:22:11', 6, 254, 'admin', 'sentbox'),
(249, 'Ø´ÙˆÙØª Ø§Ù„Ù€ emotions Ø¨ØªØ§Ø¹ØªÙŠ ØŸØŸ :P', ':P :) :( 3:) O:) :O :''( ', '2013-04-29 05:40:46', 1, 255, 'ahmed', 'sentbox'),
(250, 'hi mohmed ', 'Ø¥Ø²ÙŠÙƒ ÙŠØ§ Ø­Ù…Ø§Ø¯Ø© :)', '2013-04-30 01:49:25', 14, 256, 'mohamed', 'sentbox');

-- --------------------------------------------------------

--
-- Table structure for table `receivers_list`
--

CREATE TABLE IF NOT EXISTS `receivers_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `USERS__RECEIVERS_LIST_FK` (`sender_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=257 ;

--
-- Dumping data for table `receivers_list`
--

INSERT INTO `receivers_list` (`id`, `sender_id`) VALUES
(236, 1),
(238, 1),
(241, 1),
(246, 1),
(247, 1),
(255, 1),
(237, 2),
(239, 2),
(242, 2),
(244, 2),
(245, 2),
(251, 2),
(240, 6),
(243, 6),
(248, 6),
(249, 6),
(250, 6),
(252, 6),
(253, 6),
(254, 6),
(256, 14);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=436 ;

--
-- Dumping data for table `receivers_users`
--

INSERT INTO `receivers_users` (`id`, `list_id`, `user_id`, `message_place`) VALUES
(414, 236, 2, 'inbox'),
(415, 236, 6, 'inbox'),
(416, 237, 1, 'inbox'),
(417, 238, 2, 'inbox'),
(418, 239, 6, 'inbox'),
(419, 240, 2, 'inbox'),
(420, 241, 2, 'inbox'),
(421, 242, 6, 'inbox'),
(422, 243, 2, 'inbox'),
(423, 244, 6, 'inbox'),
(424, 245, 1, 'inbox'),
(425, 246, 2, 'inbox'),
(426, 247, 6, 'inbox'),
(427, 248, 1, 'inbox'),
(428, 249, 1, 'inbox'),
(429, 250, 2, 'inbox'),
(430, 251, 6, 'inbox'),
(431, 252, 1, 'inbox'),
(432, 253, 1, 'inbox'),
(433, 254, 1, 'inbox'),
(434, 255, 2, 'inbox'),
(435, 256, 13, 'inbox');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `messages_per_page` int(11) NOT NULL DEFAULT '10',
  `theme` varchar(10) NOT NULL DEFAULT 'default',
  PRIMARY KEY (`id`),
  KEY `USERS_ID__SETTINGS` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `user_id`, `messages_per_page`, `theme`) VALUES
(1, 1, 10, 'default'),
(2, 2, 10, 'dark'),
(3, 6, 10, 'default'),
(9, 13, 10, 'default'),
(10, 14, 10, 'default');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `state`, `avatar`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'online', 'public/avatar/avatar.png'),
(2, 'ahmed', 'e10adc3949ba59abbe56e057f20f883e', 'online', 'public/avatar/avatar.png'),
(6, 'ahmed1', '9193ce3b31332b03f7d8af056c692b84', 'online', 'public/avatar/avatar.png'),
(7, 'moh', '94e510ecc1b1d7a405c0e7aa18db792b', 'online', 'public/avatar/avatar.png'),
(13, 'mohamed', 'eb0495cbcf9fb912f52f47839a4b046f', 'online', 'public/avatar/avatar.png'),
(14, 'mohamed1', '309cd3800aacbd003ac36199fa537295', 'online', 'public/avatar/avatar.png');

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
