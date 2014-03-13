-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2014 at 01:00 PM
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
-- Table structure for table `cookie`
--

CREATE TABLE IF NOT EXISTS `cookie` (
  `cookieId` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `keycode` varchar(40) NOT NULL,
  PRIMARY KEY (`cookieId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `cookie`
--

INSERT INTO `cookie` (`cookieId`, `username`, `keycode`) VALUES
(1, 'andrew', '91de58bcfa5f709129813ad6b7d97f316ac0eedf'),
(2, 'andrew', '3c7c4772b23dec0d1d6185531f2116d28c1a07f9'),
(3, 'andrew', '949ccfc41422198d8f097f2d869193d1ccd23edf'),
(4, 'andrew', 'c09dfc2aeedd5e63bbdfed6f64116f71730feddc'),
(5, 'andrew', 'b661856f537e1a122ea3bca6c7b896ae8b1cffbb'),
(6, 'andrew', '675b9a88367f2a84576ccd675725f1aff29029ae'),
(7, 'andrew', 'ab9c9d336315fa4d65f8d6801388870b8c85de1f'),
(8, 'andrew', 'bbfa5106b9e19a68ec1d5f0293a6fd329c1ffca8'),
(9, 'andrew', 'f05401ba692e21791f68ed7fee92e44ceb312c0e'),
(10, 'andrew', 'e2ff3f5acae8d826df4e1518f7c42abf10854f1e'),
(11, 'andrew', '9977821a74c24fce679dc4242a076226'),
(12, 'andrew', 'a480c86e58bc408d429c7960cb965d76'),
(13, 'andrew', '603984d829db7480afb54b06dcbdb909'),
(14, 'andrew', '7ab4718b07ae6d1feb22d881dea2069e'),
(15, 'andrew', '9cad97a47c59fce947a167f5a4d4c760'),
(16, 'andrew', '111bc8b0ccff88c29b6797fe2125a3a1'),
(17, 'andrew', '7ea5ed244cd529e634d341d9672dd9bc'),
(18, 'andrew', '6dcb275b59d4dc545314328a58aa3b12'),
(19, 'andrew', 'c4b8a4f091a212e1a243aedc146f0ab4'),
(20, 'andrew', '94d1de982469da33057d18390ef70a74'),
(21, 'andrew', '4b9c5367616a6d59888c4ce491930212'),
(22, 'andrew', '6d5a3a1c406b121a71937d80842bd8d7'),
(23, 'andrew', 'ca4228a5370813692d29db334f8ac37c'),
(24, 'andrew', 'e5be6dc1c90114490e8f4c5fff1c1b72'),
(25, 'andrew', 'a62928cd2cc0eb713fdf075f5b04dc9c'),
(26, 'andrew', '3fa1e0023beeb8d6c05b0c4f2e1573fa');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `page`
--

INSERT INTO `page` (`page_id`, `section`, `section_homepage`, `author`, `title`, `content`, `restricted`, `time_last_updated`, `module`, `navOverride`, `navOrder`) VALUES
(1, 2, 1, 'andrew', 'What we do', '&lt;p&gt;Here we are!&lt;/p&gt;', 0, '0000-00-00 00:00:00', '', '', 0),
(2, 3, 1, 'andrew', 'Research', 'Research Test', 0, '0000-00-00 00:00:00', '', '', 0),
(3, 4, 1, 'andrew', 'Publications', 'Publications Test', 0, '0000-00-00 00:00:00', '', '?mode=publication', 0),
(4, 5, 1, 'andrew', 'Intranet Home', 'Intranet Test', 1, '0000-00-00 00:00:00', '', '', 0),
(5, 2, 0, 'andrew', 'Who we are', '&lt;p&gt;The Staff Page!&lt;/p&gt;', 0, '2014-02-02 16:26:59', '', '', 0),
(6, 2, 0, 'andrew', 'Current Collaborations', 'Collaborations Content', 0, '2014-02-02 16:27:44', '', '', 0),
(7, 6, 1, 'andrew', 'iLab News', '&lt;p&gt;News Home Content&lt;/p&gt;', 0, '2014-02-02 20:57:11', '', '', 0),
(9, 3, 0, 'andrew', 'Current Research Projects', '', 0, '2014-02-16 20:57:45', '', '?mode=project', 0),
(10, 2, 0, 'andrew', 'Job Openings', '', 0, '2014-03-09 15:48:59', '', '', 0),
(12, 2, 0, 'andrew', 'Contact Us', '', 0, '2014-03-09 16:46:38', '', '', 0),
(13, 6, 0, 'andrew', 'Press Coverage', '', 0, '2014-03-09 18:57:13', '', '', 0),
(14, 6, 0, 'andrew', 'Outreach', '', 0, '2014-03-09 18:57:41', '', '', 0),
(15, 5, 0, 'andrew', 'How to', '', 0, '2014-03-09 18:58:46', '', '', 0),
(16, 5, 0, 'andrew', 'Useful Software', '', 0, '2014-03-09 18:59:07', '', '', 0);

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
(1, 'andrew', 'Andrew Fleming', 'ajf9@hw.ac.uk', 'ajfleming.co.uk', '&lt;p&gt;I am a 4th Year Computer Science Student studying at Heriot-Watt. I am currently redesigning the iLab&#039;s website as part of my Honours Project.&lt;/p&gt;', 'blah', 'http://www.linkedin.com/profile/view?id=201059312', 'afleming1992', '', 'andrew.jpg', 'Web Developer'),
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
(1, 'Emote', '&lt;p&gt;This FP7 Project, EMOTE project will design, develop and evaluate a new generation of artificial embodied tutors that have perceptive capabilities to engage in empathic interactions with learners in a shared physical space.&lt;/p&gt;', 'www.emote-project.eu', '2014-02-01', '2014-06-01', 'emote_logo_white.png');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `project_collaborator`
--

INSERT INTO `project_collaborator` (`collaboratorId`, `username`, `projectId`, `admin`, `hidden`) VALUES
(1, 'andrew', 1, 1, 0),
(2, 'charlie', 1, 0, 0),
(4, 'delta', 1, 0, 0);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `project_sponsor`
--

INSERT INTO `project_sponsor` (`projectSponsorId`, `projectId`, `sponsorId`, `type`) VALUES
(1, 1, 1, 'partner'),
(12, 1, 13, 'sponsor');

-- --------------------------------------------------------

--
-- Table structure for table `publication`
--

CREATE TABLE IF NOT EXISTS `publication` (
  `publicationId` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `year` year(4) NOT NULL,
  `time_uploaded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `abstract` text NOT NULL,
  `publishedIn` text NOT NULL,
  `publisher` text NOT NULL,
  `file` text NOT NULL,
  PRIMARY KEY (`publicationId`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `publication`
--

INSERT INTO `publication` (`publicationId`, `name`, `year`, `time_uploaded`, `abstract`, `publishedIn`, `publisher`, `file`) VALUES
(9, 'Andrew&#039;s Journal', 1992, '2014-03-06 23:17:57', 'Testing', 'Andrew&#039;s Life', 'Andrew Fleming', ''),
(10, 'Managing data in Help4Mood', 2013, '2014-03-08 15:41:27', 'Testing', 'Testing1', 'Testing1', 'uploads/publications/RiccartonSportsCentre_v1.pdf'),
(11, 'Towards empathic virtual and robotic tutors', 2013, '2014-03-08 15:51:26', '', 'Artificial Intelligence in Education', 'Springer Verlag', ''),
(12, 'Towards empathic virtual and robotic tutors', 2013, '2014-03-08 15:53:10', '', 'Artificial Intelligence in Education', 'Springer Verlag', '');

-- --------------------------------------------------------

--
-- Table structure for table `publication_author`
--

CREATE TABLE IF NOT EXISTS `publication_author` (
  `authorId` int(11) NOT NULL AUTO_INCREMENT,
  `publicationId` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `nameOfAuthor` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`authorId`),
  KEY `userId` (`username`),
  KEY `publicationId` (`publicationId`),
  KEY `publicationId_2` (`publicationId`),
  KEY `userId_2` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `publication_author`
--

INSERT INTO `publication_author` (`authorId`, `publicationId`, `username`, `nameOfAuthor`) VALUES
(1, 9, 'andrew', NULL),
(2, 12, 'andrew', NULL),
(11, 9, NULL, 'Helen Hastie'),
(12, 9, 'charlie', NULL),
(13, 9, NULL, 'Bruce Fleming');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `publication_download`
--

INSERT INTO `publication_download` (`downloadId`, `publicationId`, `date`, `ip`) VALUES
(2, 10, '2014-03-10', '::1'),
(3, 10, '2014-03-10', '::1'),
(4, 10, '2014-03-10', '::1'),
(5, 10, '2014-03-10', '::1'),
(6, 10, '2012-03-10', '::1'),
(7, 10, '2014-03-10', '::1'),
(8, 10, '2014-03-10', '::1'),
(9, 10, '2014-03-11', '::1'),
(10, 10, '2014-03-11', '::1'),
(11, 10, '2014-03-11', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `publication_project`
--

CREATE TABLE IF NOT EXISTS `publication_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `publicationId` int(11) NOT NULL,
  `projectId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `publication_project`
--

INSERT INTO `publication_project` (`id`, `publicationId`, `projectId`) VALUES
(7, 9, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `sponsor`
--

INSERT INTO `sponsor` (`sponsorId`, `name`, `logo`, `website`) VALUES
(1, 'University of Birmingham', 'university-birmingham.jpg', 'http://www.birmingham.ac.uk/'),
(2, 'Heriot-Watt University', 'heriot-watt-University.png', 'www.hw.ac.uk'),
(7, 'Andrew Fleming', '', 'ajfleming.co.uk'),
(8, 'Andrew Fleming', '', 'ajfleming.co.uk'),
(9, 'Andrew Fleming', '', 'ajfleming.co.uk'),
(10, 'Andrew Fleming', '', 'ajfleming.co.uk'),
(11, 'Andrew Fleming', '', 'ajfleming.co.uk'),
(12, 'University of Gothenburg', '', ''),
(13, 'University of Gothenburg', 'university-gothenburg.jpg', '');

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
