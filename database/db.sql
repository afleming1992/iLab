-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2014 at 06:43 PM
-- Server version: 5.5.34
-- PHP Version: 5.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ilab`
--

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `newsId` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(30) NOT NULL,
  `title` varchar(50) NOT NULL,
  `summary` text NOT NULL,
  `content` text NOT NULL,
  `createdAt` int(11) NOT NULL,
  PRIMARY KEY (`newsId`),
  KEY `author` (`author`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `section` int(11) NOT NULL,
  `section_homepage` tinyint(1) NOT NULL,
  `author` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `restricted` int(11) NOT NULL,
  `time_last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `module` text NOT NULL,
  PRIMARY KEY (`page_id`),
  KEY `author` (`author`),
  KEY `section` (`section`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`page_id`, `section`, `section_homepage`, `author`, `title`, `content`, `restricted`, `time_last_updated`, `module`) VALUES
(1, 2, 1, 'andrew', 'What we do', 'Testing 123', 0, '0000-00-00 00:00:00', ''),
(2, 3, 1, 'andrew', 'Research', 'Research Test', 0, '0000-00-00 00:00:00', ''),
(3, 4, 1, 'andrew', 'Publications', 'Publications Test', 0, '0000-00-00 00:00:00', ''),
(4, 5, 1, 'andrew', 'Intranet Home', 'Intranet Test', 1, '0000-00-00 00:00:00', ''),
(5, 2, 0, 'andrew', 'Who we are', 'Who we are Content', 0, '2014-02-02 16:26:59', ''),
(6, 2, 0, 'andrew', 'Current Collaborations', 'Collaborations Content', 0, '2014-02-02 16:27:44', ''),
(7, 6, 1, 'andrew', 'News Home', 'News Home Content', 0, '2014-02-02 20:57:11', '');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE IF NOT EXISTS `profile` (
  `profileId` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `real_name` varchar(70) NOT NULL,
  `email` varchar(50) NOT NULL,
  `website` text NOT NULL,
  `bio` text NOT NULL,
  `pure_id` varchar(50) NOT NULL,
  `linkedin` text NOT NULL,
  `twitter` text NOT NULL,
  `scholar` text NOT NULL,
  `photo` text NOT NULL,
  `role` varchar(100) NOT NULL,
  PRIMARY KEY (`profileId`),
  KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`profileId`, `username`, `real_name`, `email`, `website`, `bio`, `pure_id`, `linkedin`, `twitter`, `scholar`, `photo`, `role`) VALUES
(1, 'andrew', 'Andrew Fleming', 'ajf9@hw.ac.uk', 'ajfleming.co.uk', 'Student studying Computer Science at Heriot-Watt University', '', 'http://www.linkedin.com/profile/view?id=201059312', '@afleming', '', '', 'Web Developer');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE IF NOT EXISTS `project` (
  `projectId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `website` text NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  PRIMARY KEY (`projectId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_collaborator`
--

CREATE TABLE IF NOT EXISTS `project_collaborator` (
  `collaboratorId` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `projectId` int(11) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  PRIMARY KEY (`collaboratorId`),
  KEY `username` (`username`),
  KEY `projectId` (`projectId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_sponsor`
--

CREATE TABLE IF NOT EXISTS `project_sponsor` (
  `projectSponsorId` int(11) NOT NULL AUTO_INCREMENT,
  `projectId` int(11) NOT NULL,
  `sponsorId` int(11) NOT NULL,
  PRIMARY KEY (`projectSponsorId`),
  KEY `projectId` (`projectId`),
  KEY `sponsorId` (`sponsorId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `publication`
--

CREATE TABLE IF NOT EXISTS `publication` (
  `publicationId` int(11) NOT NULL AUTO_INCREMENT,
  `name` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `time_uploaded` int(11) NOT NULL,
  `abstract` text NOT NULL,
  `file` text NOT NULL,
  PRIMARY KEY (`publicationId`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `publication_author`
--

CREATE TABLE IF NOT EXISTS `publication_author` (
  `authorId` int(11) NOT NULL AUTO_INCREMENT,
  `publicationId` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nameOfAuthor` varchar(30) NOT NULL,
  PRIMARY KEY (`authorId`),
  KEY `userId` (`username`),
  KEY `publicationId` (`publicationId`),
  KEY `publicationId_2` (`publicationId`),
  KEY `userId_2` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `publication_download`
--

CREATE TABLE IF NOT EXISTS `publication_download` (
  `downloadId` int(11) NOT NULL AUTO_INCREMENT,
  `publicationId` int(11) NOT NULL,
  `date` date NOT NULL,
  `ip` varchar(20) NOT NULL,
  PRIMARY KEY (`downloadId`),
  KEY `publicationId` (`publicationId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE IF NOT EXISTS `section` (
  `section_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `restricted` tinyint(1) NOT NULL,
  `navOrder` int(11) NOT NULL,
  PRIMARY KEY (`section_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `section`
--

INSERT INTO `section` (`section_id`, `name`, `restricted`, `navOrder`) VALUES
(2, 'About Us', 0, 1),
(3, 'Research', 0, 3),
(4, 'Publications', 0, 4),
(5, 'Intranet', 1, 5),
(6, 'News', 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sponsor`
--

CREATE TABLE IF NOT EXISTS `sponsor` (
  `sponsorId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `website` text NOT NULL,
  `type` varchar(8) NOT NULL,
  PRIMARY KEY (`sponsorId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `access_level` int(11) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `salt` varchar(32) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `access_level`, `hidden`, `salt`) VALUES
('andrew', '4e242d97ce82d10917cd59017a6c9123', 2, 0, 'PgPJTjzPmf1GyPSeT3YYRRgBnewCB5wV');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`author`) REFERENCES `user` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `page`
--
ALTER TABLE `page`
  ADD CONSTRAINT `page_ibfk_1` FOREIGN KEY (`author`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `page_ibfk_2` FOREIGN KEY (`section`) REFERENCES `section` (`section_id`);

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_collaborator`
--
ALTER TABLE `project_collaborator`
  ADD CONSTRAINT `project_collaborator_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_collaborator_ibfk_2` FOREIGN KEY (`projectId`) REFERENCES `profile` (`profileId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `project_sponsor`
--
ALTER TABLE `project_sponsor`
  ADD CONSTRAINT `project_sponsor_ibfk_1` FOREIGN KEY (`projectId`) REFERENCES `project` (`projectId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_sponsor_ibfk_2` FOREIGN KEY (`sponsorId`) REFERENCES `sponsor` (`sponsorId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `publication_author`
--
ALTER TABLE `publication_author`
  ADD CONSTRAINT `publication_author_ibfk_1` FOREIGN KEY (`publicationId`) REFERENCES `publication` (`publicationId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `publication_author_ibfk_2` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `publication_download`
--
ALTER TABLE `publication_download`
  ADD CONSTRAINT `publication_download_ibfk_1` FOREIGN KEY (`publicationId`) REFERENCES `publication` (`publicationId`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
