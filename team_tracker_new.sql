-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 24, 2013 at 02:15 PM
-- Server version: 5.5.24
-- PHP Version: 5.3.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `team_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `tt_authority`
--

CREATE TABLE IF NOT EXISTS `tt_authority` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `event` bigint(20) NOT NULL,
  `authority` tinyint(4) DEFAULT NULL COMMENT '1 read only, 2 read and write',
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `event` (`event`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tt_country`
--

CREATE TABLE IF NOT EXISTS `tt_country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `abbr` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tt_country`
--

INSERT INTO `tt_country` (`id`, `name`, `abbr`) VALUES
(1, 'United States', 'US');

-- --------------------------------------------------------

--
-- Table structure for table `tt_events`
--

CREATE TABLE IF NOT EXISTS `tt_events` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `pic` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `owner` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `owner` (`owner`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tt_events`
--

INSERT INTO `tt_events` (`id`, `name`, `pic`, `date`, `time`, `owner`, `type`) VALUES
(1, 'Aaaa', 'thumbnail.jpg', '2013-07-23', '21:46:21', 1, 1),
(2, 'bbbbbbb', 'thumbnail.jpg', '2013-07-24', '21:46:21', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tt_events_type`
--

CREATE TABLE IF NOT EXISTS `tt_events_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `has_pic` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tt_events_type`
--

INSERT INTO `tt_events_type` (`id`, `name`, `has_pic`) VALUES
(1, 'goal', 1),
(2, 'activity', 0),
(3, 'vpdate', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tt_event_group_map`
--

CREATE TABLE IF NOT EXISTS `tt_event_group_map` (
  `event` bigint(20) NOT NULL,
  `group` int(11) NOT NULL,
  KEY `group` (`group`),
  KEY `event` (`event`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tt_event_group_map`
--

INSERT INTO `tt_event_group_map` (`event`, `group`) VALUES
(1, 1),
(2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tt_event_user_map`
--

CREATE TABLE IF NOT EXISTS `tt_event_user_map` (
  `event` bigint(20) NOT NULL,
  `user` int(11) NOT NULL,
  KEY `event` (`event`),
  KEY `user` (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tt_groups`
--

CREATE TABLE IF NOT EXISTS `tt_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `default` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tt_groups`
--

INSERT INTO `tt_groups` (`id`, `name`, `description`, `default`) VALUES
(1, 'Haider Default Group', '', 1),
(2, 'Jonathan Bannett Default Group', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tt_mebership_map`
--

CREATE TABLE IF NOT EXISTS `tt_mebership_map` (
  `user` int(11) DEFAULT NULL,
  `group` int(11) DEFAULT NULL,
  `authority` int(11) DEFAULT NULL COMMENT '1 admin, 2 member',
  KEY `user` (`user`),
  KEY `group` (`group`),
  KEY `authority` (`authority`),
  KEY `user_2` (`user`),
  KEY `authority_2` (`authority`),
  KEY `authority_3` (`authority`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tt_mebership_map`
--

INSERT INTO `tt_mebership_map` (`user`, `group`, `authority`) VALUES
(1, 1, 1),
(2, 2, 1),
(1, 2, 2),
(2, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tt_state`
--

CREATE TABLE IF NOT EXISTS `tt_state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `abbr` varchar(2) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `country` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `country` (`country`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Dumping data for table `tt_state`
--

INSERT INTO `tt_state` (`id`, `abbr`, `name`, `country`) VALUES
(1, 'AL', 'Alabama', 1),
(2, 'AK', 'Alaska', 1),
(4, 'AZ', 'Arizona', 1),
(5, 'AR', 'Arkansas', 1),
(6, 'CA', 'California', 1),
(8, 'CO', 'Colorado', 1),
(9, 'CT', 'Connecticut', 1),
(10, 'DE', 'Delaware', 1),
(11, 'DC', 'Washington DC', 1),
(12, 'FL', 'Florida', 1),
(13, 'GA', 'Georgia', 1),
(14, 'GU', 'Guam', 1),
(15, 'HI', 'Hawaii', 1),
(16, 'ID', 'Idaho', 1),
(17, 'IL', 'Illinois', 1),
(18, 'IN', 'Indiana', 1),
(19, 'IA', 'Iowa', 1),
(20, 'KS', 'Kansas', 1),
(21, 'KY', 'Kentucky', 1),
(22, 'LA', 'Louisiana', 1),
(23, 'ME', 'Maine', 1),
(24, 'MD', 'Maryland', 1),
(25, 'MA', 'Massachusetts', 1),
(26, 'MI', 'Michigan', 1),
(27, 'MN', 'Minnesota', 1),
(28, 'MS', 'Mississippi', 1),
(29, 'MO', 'Missouri', 1),
(30, 'MT', 'Montana', 1),
(31, 'NE', 'Nebraska', 1),
(32, 'NV', 'Nevada', 1),
(33, 'NH', 'New Hampshire', 1),
(34, 'NJ', 'New Jersey', 1),
(35, 'NM', 'New Mexico', 1),
(36, 'NY', 'New York', 1),
(37, 'NC', 'North Carolina', 1),
(38, 'ND', 'North Dakota', 1),
(39, 'OH', 'Ohio', 1),
(40, 'OK', 'Oklahoma', 1),
(41, 'OR', 'Oregon', 1),
(42, 'PA', 'Pennsylvania', 1),
(43, 'PR', 'Puerto Rico', 1),
(44, 'RI', 'Rhode Island', 1),
(45, 'SC', 'South Carolina', 1),
(46, 'SD', 'South Dakota', 1),
(47, 'TN', 'Tennessee', 1),
(48, 'TX', 'Texas', 1),
(49, 'UT', 'Utah', 1),
(50, 'VT', 'Vermont', 1),
(51, 'VA', 'Virginia', 1),
(53, 'WA', 'Washington', 1),
(54, 'WV', 'West Virginia', 1),
(55, 'WI', 'Wisconsin', 1),
(56, 'WY', 'Wyoming', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tt_users`
--

CREATE TABLE IF NOT EXISTS `tt_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` int(11) DEFAULT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0 for deactive, 1 for active',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `state` (`state`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tt_users`
--

INSERT INTO `tt_users` (`id`, `name`, `avatar`, `email`, `password`, `city`, `state`, `status`) VALUES
(1, 'Haider Ali', 'avatar97.gif', 'haiderequal@yahoo.com', 'ae2b1fca515949e5d54fb22b8ed95575', 'Abc', 8, '1'),
(2, 'Jonathan Bannett', 'avatar96.gif', 'j@gmail.com', 'ae2b1fca515949e5d54fb22b8ed95575', 'Test', 1, '1');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tt_authority`
--
ALTER TABLE `tt_authority`
  ADD CONSTRAINT `tt_authority_ibfk_1` FOREIGN KEY (`user`) REFERENCES `tt_users` (`id`),
  ADD CONSTRAINT `tt_authority_ibfk_2` FOREIGN KEY (`event`) REFERENCES `tt_events` (`id`);

--
-- Constraints for table `tt_events`
--
ALTER TABLE `tt_events`
  ADD CONSTRAINT `tt_events_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `tt_users` (`id`),
  ADD CONSTRAINT `tt_events_ibfk_2` FOREIGN KEY (`type`) REFERENCES `tt_events_type` (`id`);

--
-- Constraints for table `tt_event_group_map`
--
ALTER TABLE `tt_event_group_map`
  ADD CONSTRAINT `tt_event_group_map_ibfk_1` FOREIGN KEY (`event`) REFERENCES `tt_events` (`id`),
  ADD CONSTRAINT `tt_event_group_map_ibfk_2` FOREIGN KEY (`group`) REFERENCES `tt_groups` (`id`);

--
-- Constraints for table `tt_event_user_map`
--
ALTER TABLE `tt_event_user_map`
  ADD CONSTRAINT `tt_event_user_map_ibfk_1` FOREIGN KEY (`event`) REFERENCES `tt_events` (`id`),
  ADD CONSTRAINT `tt_event_user_map_ibfk_2` FOREIGN KEY (`user`) REFERENCES `tt_users` (`id`);

--
-- Constraints for table `tt_mebership_map`
--
ALTER TABLE `tt_mebership_map`
  ADD CONSTRAINT `tt_mebership_map_ibfk_1` FOREIGN KEY (`group`) REFERENCES `tt_groups` (`id`),
  ADD CONSTRAINT `tt_mebership_map_ibfk_2` FOREIGN KEY (`user`) REFERENCES `tt_users` (`id`);

--
-- Constraints for table `tt_state`
--
ALTER TABLE `tt_state`
  ADD CONSTRAINT `tt_state_ibfk_1` FOREIGN KEY (`country`) REFERENCES `tt_country` (`id`);

--
-- Constraints for table `tt_users`
--
ALTER TABLE `tt_users`
  ADD CONSTRAINT `tt_users_ibfk_1` FOREIGN KEY (`state`) REFERENCES `tt_state` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
