-- phpMyAdmin SQL Dump
-- version 2.9.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jul 02, 2009 at 05:56 PM
-- Server version: 5.0.27
-- PHP Version: 5.2.1
-- 
-- Database: `colourzwebalbums`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `albumfriends`
-- 

CREATE TABLE `albumfriends` (
  `id` int(11) NOT NULL auto_increment,
  `albumid` int(11) NOT NULL,
  `userid` int(11) default NULL,
  `friendid` int(11) default NULL,
  `status` smallint(6) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `albums`
-- 

CREATE TABLE `albums` (
  `albumid` int(11) NOT NULL auto_increment,
  `albumname` varchar(150) NOT NULL,
  `albumlocation` varchar(150) default NULL,
  `albumdescription` text,
  `albumdate` datetime default NULL,
  `albumcoverphoto` varchar(240) default 'album_default.jpg',
  `albumtypeid` int(11) default '1',
  `authcode` varchar(240) default NULL,
  `status` tinyint(4) default '0',
  `createddate` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`albumid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `albumtype`
-- 

CREATE TABLE `albumtype` (
  `albumtypeid` int(11) NOT NULL auto_increment,
  `type` varchar(240) NOT NULL,
  `previllages` text,
  `status` tinyint(4) default '0',
  PRIMARY KEY  (`albumtypeid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `comments`
-- 

CREATE TABLE `comments` (
  `commentid` int(11) NOT NULL auto_increment,
  `photoid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `comment` text NOT NULL,
  `rating` int(11) default '0',
  `status` tinyint(4) default '0',
  `commenteddate` timestamp NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`commentid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `friendlist`
-- 

CREATE TABLE `friendlist` (
  `friendlistid` int(11) NOT NULL auto_increment,
  `listname` varchar(240) NOT NULL,
  `description` text,
  `createddate` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`friendlistid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `friends`
-- 

CREATE TABLE `friends` (
  `fid` int(11) NOT NULL auto_increment,
  `email` varchar(244) NOT NULL,
  `name` varchar(150) default NULL,
  `uid` int(11) default NULL,
  `status` smallint(6) default '0',
  PRIMARY KEY  (`fid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `pages`
-- 

CREATE TABLE `pages` (
  `pageid` int(11) NOT NULL auto_increment,
  `title` varchar(240) NOT NULL,
  `content` longtext NOT NULL,
  `status` smallint(6) default '0',
  `createdon` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`pageid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `photos`
-- 

CREATE TABLE `photos` (
  `photoid` int(11) NOT NULL auto_increment,
  `albumid` int(11) NOT NULL,
  `filename` varchar(240) NOT NULL,
  `caption` text,
  `status` tinyint(4) default '0',
  `uploadeddate` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `order` varchar(100) default NULL,
  PRIMARY KEY  (`photoid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `users`
-- 

CREATE TABLE `users` (
  `uid` int(11) NOT NULL auto_increment,
  `email` varchar(244) NOT NULL,
  `password` varchar(150) NOT NULL,
  `authcode` varchar(150) default NULL,
  `status` tinyint(4) default '0',
  `name` varchar(150) default NULL,
  `dob` datetime default NULL,
  `location` varchar(150) default NULL,
  `country` int(11) default NULL,
  `photo` varchar(244) default 'defaultphoto.gif',
  `listid` int(11) default NULL,
  `usercreatedon` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`uid`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- phpMyAdmin SQL Dump
-- version 2.9.2
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Jul 02, 2009 at 05:57 PM
-- Server version: 5.0.27
-- PHP Version: 5.2.1
-- 
-- Database: `angelegna`
-- 

-- 
-- Dumping data for table `albumtype`
-- 

INSERT INTO `albumtype` (`albumtypeid`, `type`, `previllages`, `status`) VALUES 
(1, 'Public', 'The photos in the album will be shown public without any anthentication.', 0),
(2, 'Unlisted', 'The photos in the album can be seen by clicking the invite. The invite can be shared by users if needed.', 0),
(3, 'Sign-in Required', 'Photos in the album can be viewed only by logging into the site and the invite cannot be shared', 0);

-- 
-- Dumping data for table `pages`
-- 

INSERT INTO `pages` (`pageid`, `title`, `content`, `status`, `createdon`) VALUES 
(1, 'About Me', 'this is test content', 0, '2009-07-02 17:31:45'),
(2, 'Interests', 'This is test content', 0, '2009-07-02 17:31:45');

-- 
-- Dumping data for table `users`
-- 

INSERT INTO `users` (`uid`, `email`, `password`, `authcode`, `status`, `name`, `dob`, `location`, `country`, `photo`, `listid`, `usercreatedon`) VALUES 
(1, 'daniepaul@gmail.com', '123', NULL, 1, 'Daniel Paul', '1986-01-10 10:01:49', 'Chennai', 0, 'defaultphoto.gif', NULL, '2009-06-26 10:02:14'),
(2, 'angel.dharshini@gmail.com', 'angel', NULL, 4, 'Angel Dharshini', '1986-05-19 17:11:41', 'Ohio', 0, 'defaultphoto.gif', NULL, '2009-07-02 17:12:34'),
(3, 'md@thecolourz.com', '123', NULL, 0, 'Paul', NULL, NULL, NULL, 'defaultphoto.gif', NULL, '2009-07-02 19:13:58');

