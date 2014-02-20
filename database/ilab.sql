-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 20, 2014 at 12:53 PM
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
  `navOverride` text NOT NULL,
  `navOrder` int(11) NOT NULL,
  PRIMARY KEY (`page_id`),
  KEY `author` (`author`),
  KEY `section` (`section`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`page_id`, `section`, `section_homepage`, `author`, `title`, `content`, `restricted`, `time_last_updated`, `module`, `navOverride`, `navOrder`) VALUES
(1, 2, 1, 'andrew', 'What we do', '&lt;p&gt;Here we are!&lt;/p&gt;', 0, '0000-00-00 00:00:00', '', '', 0),
(2, 3, 1, 'andrew', 'Research', 'Research Test', 0, '0000-00-00 00:00:00', '', '', 0),
(3, 4, 1, 'andrew', 'Publications', 'Publications Test', 0, '0000-00-00 00:00:00', '', '', 0),
(4, 5, 1, 'andrew', 'Intranet Home', 'Intranet Test', 1, '0000-00-00 00:00:00', '', '', 0),
(5, 2, 0, 'andrew', 'Who we are', '&lt;p&gt;The Staff Page!&lt;/p&gt;', 0, '2014-02-02 16:26:59', '', '', 0),
(6, 2, 0, 'andrew', 'Current Collaborations', 'Collaborations Content', 0, '2014-02-02 16:27:44', '', '', 0),
(7, 6, 1, 'andrew', 'News Home', 'News Home Content', 0, '2014-02-02 20:57:11', '', '', 0),
(8, 2, 0, 'andrew', 'Blah', '&lt;p&gt;Blah Blah Blah&lt;/p&gt;', 0, '2014-02-07 19:41:16', '', '', 0),
(9, 3, 0, 'andrew', 'Current Research Projects', '', 0, '2014-02-16 20:57:45', '', '?mode=project', 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`profileId`, `username`, `real_name`, `email`, `website`, `bio`, `pure_id`, `linkedin`, `twitter`, `scholar`, `photo`, `role`) VALUES
(1, 'andrew', 'Andrew Fleming', 'ajf9@hw.ac.uk', 'ajfleming.co.uk', '&lt;p&gt;I am a 4th Year Computer Science Student studying at Heriot-Watt. I am currently redesigning the iLab&#039;s website as part of my Honours Project.&lt;/p&gt;', 'blah', 'testing', 'afleming1992', 'testing', 'andrew.jpg', 'Web Developer'),
(2, 'guest', 'iLab Guest', 'ajf9@hw.ac.uk', '', '', '', '', '', '', '', ''),
(3, 'test', 'iLab Test', 'ajf9@hw.ac.uk', '', '', '', '', '', '', '', ''),
(5, 'charlie', 'iLab Test', 'ajf9@hw.ac.uk', 'www.hw.ac.uk', '&lt;p&gt;BLAH BLAH BLAH&lt;/p&gt;', 'Blah', 'balh', 'afleming1992', 'blah', 'charlie.jpg', 'Charlie Tester'),
(6, 'delta', 'Delta Ilab', 'delta@hw.ac.uk', '', '', '', '', '', '', '', ''),
(7, 'echo', 'Echo Sierra', 'echo@hw.ac.uk', '', '', '', '', '', '', '', ''),
(8, 'victor', 'Victor Sierra', 'victor@hw.ac.uk', '', '', '', '', '', '', '', '');

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
  `logo` text NOT NULL,
  PRIMARY KEY (`projectId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`projectId`, `name`, `description`, `website`, `startDate`, `endDate`, `logo`) VALUES
(1, 'Emote', '&lt;p&gt;This FP7 Project, EMOTE project will design, develop and evaluate a new generation of artificial embodied tutors that have perceptive capabilities to engage in empathic interactions with learners in a shared physical space.&lt;/p&gt;', 'www.emote-project.eu', '2014-02-01', '2014-02-28', 'emote_logo_white.png');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `project_collaborator`
--

INSERT INTO `project_collaborator` (`collaboratorId`, `username`, `projectId`, `admin`, `hidden`) VALUES
(1, 'andrew', 1, 1, 0),
(2, 'charlie', 1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `project_sponsor`
--

CREATE TABLE IF NOT EXISTS `project_sponsor` (
  `projectSponsorId` int(11) NOT NULL AUTO_INCREMENT,
  `projectId` int(11) NOT NULL,
  `sponsorId` int(11) NOT NULL,
  `type` varchar(8) NOT NULL,
  PRIMARY KEY (`projectSponsorId`),
  KEY `projectId` (`projectId`),
  KEY `sponsorId` (`sponsorId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `project_sponsor`
--

INSERT INTO `project_sponsor` (`projectSponsorId`, `projectId`, `sponsorId`, `type`) VALUES
(1, 1, 1, 'partner'),
(2, 1, 2, 'partner');

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
  PRIMARY KEY (`sponsorId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `sponsor`
--

INSERT INTO `sponsor` (`sponsorId`, `name`, `logo`, `website`) VALUES
(1, 'University of Birmingham', 'university-birmingham.jpg', 'http://www.birmingham.ac.uk/'),
(2, 'Heriot-Watt University', 'heriot-watt-University.png', 'www.hw.ac.uk');

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
('andrew', 'e2192149acd787bdd6355db545f1a418', 2, 0, 'EMCfYiX9H1UPEW5YcvAPbH06VYq0ikrh'),
('charlie', 'e2192149acd787bdd6355db545f1a418', 2, 0, 'EMCfYiX9H1UPEW5YcvAPbH06VYq0ikrh'),
('delta', 'e2192149acd787bdd6355db545f1a418', 2, 0, 'EMCfYiX9H1UPEW5YcvAPbH06VYq0ikrh'),
('echo', 'e2192149acd787bdd6355db545f1a418', 2, 0, 'EMCfYiX9H1UPEW5YcvAPbH06VYq0ikrh'),
('guest', 'e2192149acd787bdd6355db545f1a418', 2, 0, 'EMCfYiX9H1UPEW5YcvAPbH06VYq0ikrh'),
('test', 'e2192149acd787bdd6355db545f1a418', 2, 0, 'EMCfYiX9H1UPEW5YcvAPbH06VYq0ikrh'),
('victor', 'e2192149acd787bdd6355db545f1a418', 2, 0, 'EMCfYiX9H1UPEW5YcvAPbH06VYq0ikrh');

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
-- Constraints for table `project_collaborator`
--
ALTER TABLE `project_collaborator`
  ADD CONSTRAINT `project_collaborator_ibfk_1` FOREIGN KEY (`username`) REFERENCES `user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_collaborator_ibfk_2` FOREIGN KEY (`projectId`) REFERENCES `project` (`projectId`) ON DELETE CASCADE ON UPDATE CASCADE;

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
