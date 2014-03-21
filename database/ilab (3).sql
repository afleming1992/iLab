-- phpMyAdmin SQL Dump
-- version 2.11.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 21, 2014 at 09:28 AM
-- Server version: 5.1.58
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `a9214664_ilab`
--

-- --------------------------------------------------------

--
-- Table structure for table `cookie`
--

CREATE TABLE `cookie` (
  `cookieId` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `keycode` varchar(40) NOT NULL,
  PRIMARY KEY (`cookieId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `cookie`
--

INSERT INTO `cookie` VALUES(1, 'andrew', '91de58bcfa5f709129813ad6b7d97f316ac0eedf');
INSERT INTO `cookie` VALUES(2, 'andrew', '3c7c4772b23dec0d1d6185531f2116d28c1a07f9');
INSERT INTO `cookie` VALUES(3, 'andrew', '949ccfc41422198d8f097f2d869193d1ccd23edf');
INSERT INTO `cookie` VALUES(4, 'andrew', 'c09dfc2aeedd5e63bbdfed6f64116f71730feddc');
INSERT INTO `cookie` VALUES(5, 'andrew', 'b661856f537e1a122ea3bca6c7b896ae8b1cffbb');
INSERT INTO `cookie` VALUES(6, 'andrew', '675b9a88367f2a84576ccd675725f1aff29029ae');
INSERT INTO `cookie` VALUES(7, 'andrew', 'ab9c9d336315fa4d65f8d6801388870b8c85de1f');
INSERT INTO `cookie` VALUES(8, 'andrew', 'bbfa5106b9e19a68ec1d5f0293a6fd329c1ffca8');
INSERT INTO `cookie` VALUES(9, 'andrew', 'f05401ba692e21791f68ed7fee92e44ceb312c0e');
INSERT INTO `cookie` VALUES(10, 'andrew', 'e2ff3f5acae8d826df4e1518f7c42abf10854f1e');
INSERT INTO `cookie` VALUES(11, 'andrew', '9977821a74c24fce679dc4242a076226');
INSERT INTO `cookie` VALUES(12, 'andrew', 'a480c86e58bc408d429c7960cb965d76');
INSERT INTO `cookie` VALUES(13, 'andrew', '603984d829db7480afb54b06dcbdb909');
INSERT INTO `cookie` VALUES(14, 'andrew', '7ab4718b07ae6d1feb22d881dea2069e');
INSERT INTO `cookie` VALUES(15, 'andrew', '9cad97a47c59fce947a167f5a4d4c760');
INSERT INTO `cookie` VALUES(16, 'andrew', '111bc8b0ccff88c29b6797fe2125a3a1');
INSERT INTO `cookie` VALUES(17, 'andrew', '7ea5ed244cd529e634d341d9672dd9bc');
INSERT INTO `cookie` VALUES(18, 'andrew', '6dcb275b59d4dc545314328a58aa3b12');
INSERT INTO `cookie` VALUES(19, 'andrew', 'c4b8a4f091a212e1a243aedc146f0ab4');
INSERT INTO `cookie` VALUES(20, 'andrew', '94d1de982469da33057d18390ef70a74');
INSERT INTO `cookie` VALUES(21, 'andrew', '4b9c5367616a6d59888c4ce491930212');
INSERT INTO `cookie` VALUES(22, 'andrew', '6d5a3a1c406b121a71937d80842bd8d7');
INSERT INTO `cookie` VALUES(23, 'andrew', 'ca4228a5370813692d29db334f8ac37c');
INSERT INTO `cookie` VALUES(24, 'andrew', 'e5be6dc1c90114490e8f4c5fff1c1b72');
INSERT INTO `cookie` VALUES(25, 'andrew', 'a62928cd2cc0eb713fdf075f5b04dc9c');
INSERT INTO `cookie` VALUES(26, 'andrew', '3fa1e0023beeb8d6c05b0c4f2e1573fa');
INSERT INTO `cookie` VALUES(27, 'andrew', '5cad1004e6008ca72aebe25e864c8f8e');
INSERT INTO `cookie` VALUES(28, 'helen', 'e577586b0cf5b3453aff101aeca37f17');
INSERT INTO `cookie` VALUES(29, 'Helen', '440663f613a2b7c18c7f2b456419885a');
INSERT INTO `cookie` VALUES(30, 'andrew', '722de13b572b6f7656d1eaabfabeca1e');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `newsId` int(11) NOT NULL AUTO_INCREMENT,
  `author` varchar(30) NOT NULL,
  `title` varchar(50) NOT NULL,
  `summary` text NOT NULL,
  `content` text NOT NULL,
  `createdAt` int(11) NOT NULL,
  `image` text NOT NULL,
  PRIMARY KEY (`newsId`),
  KEY `author` (`author`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` VALUES(1, 'Helen', 'Bit of news', 'Lots of cool news about us', '&lt;p&gt;text text text&amp;nbsp;&lt;/p&gt;', 0, 'hwu_logo.gif');

-- --------------------------------------------------------

--
-- Table structure for table `page`
--

CREATE TABLE `page` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `page`
--

INSERT INTO `page` VALUES(1, 2, 1, 'andrew', 'What we do', '&lt;p&gt;Here we are!&lt;/p&gt;', 0, '0000-00-00 00:00:00', '', '', 0);
INSERT INTO `page` VALUES(3, 4, 1, 'andrew', 'Publications', 'Publications Test', 0, '0000-00-00 00:00:00', '', '?mode=publication', 0);
INSERT INTO `page` VALUES(4, 5, 1, 'andrew', 'Intranet Home', 'Intranet Test', 1, '0000-00-00 00:00:00', '', '', 0);
INSERT INTO `page` VALUES(5, 2, 0, 'andrew', 'Who we are', '&lt;p&gt;The Staff Page!&lt;/p&gt;', 0, '2014-02-02 11:26:59', '', '?mode=profile', -1);
INSERT INTO `page` VALUES(6, 2, 0, 'andrew', 'Current Collaborations', 'Collaborations Content', 0, '2014-02-02 11:27:44', '', '', 0);
INSERT INTO `page` VALUES(7, 6, 1, 'andrew', 'iLab News', '&lt;p&gt;News Home Content&lt;/p&gt;', 0, '2014-02-02 15:57:11', '', '?mode=news', 0);
INSERT INTO `page` VALUES(9, 3, 1, 'andrew', 'Current Research Projects', '', 0, '2014-02-16 15:57:45', '', '?mode=project', 0);
INSERT INTO `page` VALUES(10, 2, 0, 'andrew', 'Job Openings', '', 0, '2014-03-09 11:48:59', '', '', 0);
INSERT INTO `page` VALUES(12, 2, 0, 'andrew', 'Contact Us', '', 0, '2014-03-09 12:46:38', '', '', 0);
INSERT INTO `page` VALUES(13, 6, 0, 'andrew', 'Press Coverage', '', 0, '2014-03-09 14:57:13', '', '', 0);
INSERT INTO `page` VALUES(14, 6, 0, 'andrew', 'Outreach', '', 0, '2014-03-09 14:57:41', '', '', 0);
INSERT INTO `page` VALUES(15, 5, 0, 'andrew', 'How to', '', 0, '2014-03-09 14:58:46', '', '', 0);
INSERT INTO `page` VALUES(16, 5, 0, 'andrew', 'Useful Software', '', 0, '2014-03-09 14:59:07', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` VALUES(1, 'andrew', 'Andrew Fleming', 'ajf9@hw.ac.uk', 'ajfleming.co.uk', '&lt;p&gt;I am a 4th Year Computer Science Student studying at Heriot-Watt. I am currently redesigning the iLab&#039;s website as part of my Honours Project.&lt;/p&gt;', 'blah', 'http://www.linkedin.com/profile/view?id=201059312', 'afleming1992', '', 'andrew.jpg', 'Web Developer');
INSERT INTO `profile` VALUES(2, 'guest', 'iLab Guest', 'ajf9@hw.ac.uk', '', '', '', '', '', '', '', '');
INSERT INTO `profile` VALUES(3, 'test', 'iLab Test', 'ajf9@hw.ac.uk', '', '', '', '', '', '', '', '');
INSERT INTO `profile` VALUES(5, 'charlie', 'iLab Test', 'ajf9@hw.ac.uk', 'www.hw.ac.uk', '&lt;p&gt;BLAH BLAH BLAH&lt;/p&gt;', 'Blah', 'balh', 'afleming1992', 'blah', 'charlie.jpg', 'Charlie Tester');
INSERT INTO `profile` VALUES(6, 'delta', 'Delta Ilab', 'delta@hw.ac.uk', '', '', '', '', '', '', '', '');
INSERT INTO `profile` VALUES(7, 'echo', 'Echo Sierra', 'echo@hw.ac.uk', '', '', '', '', '', '', '', '');
INSERT INTO `profile` VALUES(8, 'victor', 'Victor Sierra', 'victor@hw.ac.uk', '', '', '', '', '', '', '', '');
INSERT INTO `profile` VALUES(9, 'helen', 'Helen Hastie', 'h.hastie@hw.ac.uk', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `projectId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `website` text NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `logo` text NOT NULL,
  PRIMARY KEY (`projectId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `project`
--

INSERT INTO `project` VALUES(1, 'Emote', '&lt;p&gt;This FP7 Project, EMOTE project will design, develop and evaluate a new generation of artificial embodied tutors that have perceptive capabilities to engage in empathic interactions with learners in a shared physical space.&lt;/p&gt;', 'www.emote-project.eu', '2014-02-01', '2014-06-01', 'emote_logo_white.png');
INSERT INTO `project` VALUES(2, 'Parlance', '&lt;p&gt;description&lt;/p&gt;', 'parlance.eu', '2011-10-01', '2014-10-31', '');

-- --------------------------------------------------------

--
-- Table structure for table `project_collaborator`
--

CREATE TABLE `project_collaborator` (
  `collaboratorId` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `projectId` int(11) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  PRIMARY KEY (`collaboratorId`),
  KEY `username` (`username`),
  KEY `projectId` (`projectId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `project_collaborator`
--

INSERT INTO `project_collaborator` VALUES(1, 'andrew', 1, 1, 0);
INSERT INTO `project_collaborator` VALUES(2, 'charlie', 1, 0, 0);
INSERT INTO `project_collaborator` VALUES(4, 'delta', 1, 0, 0);
INSERT INTO `project_collaborator` VALUES(5, 'helen', 2, 1, 0);
INSERT INTO `project_collaborator` VALUES(6, 'echo', 2, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `project_sponsor`
--

CREATE TABLE `project_sponsor` (
  `projectSponsorId` int(11) NOT NULL AUTO_INCREMENT,
  `projectId` int(11) NOT NULL,
  `sponsorId` int(11) NOT NULL,
  `type` varchar(8) NOT NULL,
  PRIMARY KEY (`projectSponsorId`),
  KEY `projectId` (`projectId`),
  KEY `sponsorId` (`sponsorId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `project_sponsor`
--

INSERT INTO `project_sponsor` VALUES(1, 1, 1, 'partner');
INSERT INTO `project_sponsor` VALUES(12, 1, 13, 'sponsor');
INSERT INTO `project_sponsor` VALUES(13, 1, 2, '');

-- --------------------------------------------------------

--
-- Table structure for table `publication`
--

CREATE TABLE `publication` (
  `publicationId` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `year` year(4) NOT NULL,
  `time_uploaded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `abstract` text NOT NULL,
  `publishedIn` text NOT NULL,
  `publisher` text NOT NULL,
  `file` text NOT NULL,
  PRIMARY KEY (`publicationId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `publication`
--

INSERT INTO `publication` VALUES(9, 'Andrew&#039;s Journal', 1992, '2014-03-06 18:17:57', 'Testing', 'Andrew&#039;s Life', 'Andrew Fleming', '');
INSERT INTO `publication` VALUES(10, 'Managing data in Help4Mood', 2013, '2014-03-08 10:41:27', 'Testing', 'Testing1', 'Testing1', 'uploads/publications/RiccartonSportsCentre_v1.pdf');
INSERT INTO `publication` VALUES(11, 'Towards empathic virtual and robotic tutors', 2013, '2014-03-08 10:51:26', '', 'Artificial Intelligence in Education', 'Springer Verlag', '');
INSERT INTO `publication` VALUES(12, 'Towards empathic virtual and robotic tutors', 2013, '2014-03-08 10:53:10', '', 'Artificial Intelligence in Education', 'Springer Verlag', '');
INSERT INTO `publication` VALUES(13, 'Test', 2012, '2014-03-14 17:01:11', 'Blah', 'Test', 'Test', '');
INSERT INTO `publication` VALUES(14, 'Blah2', 1992, '2014-03-14 17:01:33', 'Andrew', 'Blah2', 'Blah2', '');
INSERT INTO `publication` VALUES(15, 'An extremely interesting title', 2014, '2014-03-20 17:58:45', 'text text', 'Proceedings of ACL', 'ACL', 'uploads/publications/sigdialemote2013.pdf');
INSERT INTO `publication` VALUES(16, 'another interesting publication ', 2014, '2014-03-20 18:00:34', 'ajskdlf;alkjasdf', 'Proceedings of ACL', 'ACL', '');

-- --------------------------------------------------------

--
-- Table structure for table `publication_author`
--

CREATE TABLE `publication_author` (
  `authorId` int(11) NOT NULL AUTO_INCREMENT,
  `publicationId` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `nameOfAuthor` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`authorId`),
  KEY `userId` (`username`),
  KEY `publicationId` (`publicationId`),
  KEY `publicationId_2` (`publicationId`),
  KEY `userId_2` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `publication_author`
--

INSERT INTO `publication_author` VALUES(1, 9, 'andrew', NULL);
INSERT INTO `publication_author` VALUES(2, 12, 'andrew', NULL);
INSERT INTO `publication_author` VALUES(11, 9, NULL, 'Helen Hastie');
INSERT INTO `publication_author` VALUES(12, 9, 'charlie', NULL);
INSERT INTO `publication_author` VALUES(13, 9, NULL, 'Bruce Fleming');
INSERT INTO `publication_author` VALUES(14, 13, 'andrew', NULL);
INSERT INTO `publication_author` VALUES(15, 14, 'andrew', NULL);
INSERT INTO `publication_author` VALUES(16, 15, 'Helen', NULL);
INSERT INTO `publication_author` VALUES(17, 15, 'andrew', NULL);
INSERT INTO `publication_author` VALUES(18, 16, 'Helen', NULL);
INSERT INTO `publication_author` VALUES(19, 16, 'guest', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `publication_download`
--

CREATE TABLE `publication_download` (
  `downloadId` int(11) NOT NULL AUTO_INCREMENT,
  `publicationId` int(11) NOT NULL,
  `date` date NOT NULL,
  `ip` varchar(20) NOT NULL,
  PRIMARY KEY (`downloadId`),
  KEY `publicationId` (`publicationId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `publication_download`
--

INSERT INTO `publication_download` VALUES(2, 10, '2014-03-10', '::1');
INSERT INTO `publication_download` VALUES(3, 10, '2014-03-10', '::1');
INSERT INTO `publication_download` VALUES(4, 10, '2014-03-10', '::1');
INSERT INTO `publication_download` VALUES(5, 10, '2014-03-10', '::1');
INSERT INTO `publication_download` VALUES(6, 10, '2012-03-10', '::1');
INSERT INTO `publication_download` VALUES(7, 10, '2014-03-10', '::1');
INSERT INTO `publication_download` VALUES(8, 10, '2014-03-10', '::1');
INSERT INTO `publication_download` VALUES(9, 10, '2014-03-11', '::1');
INSERT INTO `publication_download` VALUES(10, 10, '2014-03-11', '::1');
INSERT INTO `publication_download` VALUES(11, 10, '2014-03-11', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `publication_project`
--

CREATE TABLE `publication_project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `publicationId` int(11) NOT NULL,
  `projectId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `publication_project`
--

INSERT INTO `publication_project` VALUES(7, 9, 1);
INSERT INTO `publication_project` VALUES(8, 11, 1);
INSERT INTO `publication_project` VALUES(9, 13, 1);
INSERT INTO `publication_project` VALUES(10, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `section`
--

CREATE TABLE `section` (
  `section_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `restricted` tinyint(1) NOT NULL,
  `navOrder` int(11) NOT NULL,
  PRIMARY KEY (`section_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `section`
--

INSERT INTO `section` VALUES(2, 'About Us', 0, 1);
INSERT INTO `section` VALUES(3, 'Research', 0, 3);
INSERT INTO `section` VALUES(4, 'Publications', 0, 4);
INSERT INTO `section` VALUES(5, 'Intranet', 1, 5);
INSERT INTO `section` VALUES(6, 'News', 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sponsor`
--

CREATE TABLE `sponsor` (
  `sponsorId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `website` text NOT NULL,
  PRIMARY KEY (`sponsorId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `sponsor`
--

INSERT INTO `sponsor` VALUES(1, 'University of Birmingham', 'university-birmingham.jpg', 'http://www.birmingham.ac.uk/');
INSERT INTO `sponsor` VALUES(2, 'Heriot-Watt University', 'heriot-watt-University.png', 'www.hw.ac.uk');
INSERT INTO `sponsor` VALUES(7, 'Andrew Fleming', '', 'ajfleming.co.uk');
INSERT INTO `sponsor` VALUES(8, 'Andrew Fleming', '', 'ajfleming.co.uk');
INSERT INTO `sponsor` VALUES(9, 'Andrew Fleming', '', 'ajfleming.co.uk');
INSERT INTO `sponsor` VALUES(10, 'Andrew Fleming', '', 'ajfleming.co.uk');
INSERT INTO `sponsor` VALUES(11, 'Andrew Fleming', '', 'ajfleming.co.uk');
INSERT INTO `sponsor` VALUES(12, 'University of Gothenburg', '', '');
INSERT INTO `sponsor` VALUES(13, 'University of Gothenburg', 'university-gothenburg.jpg', '');
INSERT INTO `sponsor` VALUES(14, 'Blah', '', 'www.blah.com');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `access_level` int(11) NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `salt` varchar(32) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` VALUES('andrew', '8f4c044b0da5be4e511791e660080b49', 2, 0, '4jSvqxmbPmbPLTBgcHiQBTvpV3XkFiRp');
INSERT INTO `user` VALUES('charlie', 'ddee879f5a8daa496a5013df2bc4a16f', 2, 0, 'P1CUMgVuB8ZZtCeU4WgoghZA0ItUIpuy');
INSERT INTO `user` VALUES('delta', 'ddee879f5a8daa496a5013df2bc4a16f', 2, 0, 'P1CUMgVuB8ZZtCeU4WgoghZA0ItUIpuy');
INSERT INTO `user` VALUES('echo', 'ddee879f5a8daa496a5013df2bc4a16f', 2, 0, 'P1CUMgVuB8ZZtCeU4WgoghZA0ItUIpuy');
INSERT INTO `user` VALUES('guest', 'ddee879f5a8daa496a5013df2bc4a16f', 2, 0, 'P1CUMgVuB8ZZtCeU4WgoghZA0ItUIpuy');
INSERT INTO `user` VALUES('test', 'ddee879f5a8daa496a5013df2bc4a16f', 2, 0, 'P1CUMgVuB8ZZtCeU4WgoghZA0ItUIpuy');
INSERT INTO `user` VALUES('victor', 'ddee879f5a8daa496a5013df2bc4a16f', 2, 0, 'P1CUMgVuB8ZZtCeU4WgoghZA0ItUIpuy');
INSERT INTO `user` VALUES('helen', 'ddee879f5a8daa496a5013df2bc4a16f', 2, 0, 'P1CUMgVuB8ZZtCeU4WgoghZA0ItUIpuy');
