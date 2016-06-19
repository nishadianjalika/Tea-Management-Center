-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 22, 2015 at 07:16 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `t_center`
--
CREATE DATABASE IF NOT EXISTS `t_center` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `t_center`;

-- --------------------------------------------------------

--
-- Table structure for table `advanced`
--

CREATE TABLE IF NOT EXISTS `advanced` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cus_id` int(11) NOT NULL,
  `year_month` varchar(10) NOT NULL,
  `advance` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `advanced`
--

INSERT INTO `advanced` (`id`, `cus_id`, `year_month`, `advance`) VALUES
(1, 2, '201508', 1500),
(2, 3, '201509', 3000),
(3, 2, '201509', 1000),
(4, 1, '201508', 50000),
(5, 3, '201508', 3000);

-- --------------------------------------------------------

--
-- Table structure for table `fertilizer_req`
--

CREATE TABLE IF NOT EXISTS `fertilizer_req` (
  `req_id` int(11) NOT NULL AUTO_INCREMENT,
  `id` varchar(10) NOT NULL,
  `fer_type` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `quantity` varchar(11) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`req_id`,`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `fertilizer_req`
--

INSERT INTO `fertilizer_req` (`req_id`, `id`, `fer_type`, `name`, `quantity`, `date`) VALUES
(36, '', 'For small plants', '', '', '0000-00-00'),
(37, '1', '', '', '125', '0000-00-00'),
(38, '1', '', '', '125', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `month_sup_data`
--

CREATE TABLE IF NOT EXISTS `month_sup_data` (
  `year_month` varchar(10) NOT NULL,
  `id` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `bill_id` int(11) NOT NULL AUTO_INCREMENT,
  `cus_id` int(11) NOT NULL,
  `year_month` varchar(11) NOT NULL,
  `total_weight` int(11) NOT NULL,
  `rate` float NOT NULL,
  `value` float NOT NULL COMMENT 'value of this month suplied',
  `advanced` float NOT NULL COMMENT 'advanced payment',
  `loan` float NOT NULL COMMENT 'last month loan',
  `payble` float NOT NULL COMMENT 'rest for this month',
  PRIMARY KEY (`bill_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_data`
--

CREATE TABLE IF NOT EXISTS `t_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cus_id` int(11) NOT NULL,
  `year_month` varchar(10) NOT NULL,
  `date` int(11) NOT NULL,
  `weight` int(10) NOT NULL,
  PRIMARY KEY (`id`,`cus_id`),
  KEY `t_data_ibfk_1` (`cus_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `t_data`
--

INSERT INTO `t_data` (`id`, `cus_id`, `year_month`, `date`, `weight`) VALUES
(4, 2, '201509', 12, 126),
(5, 2, '201509', 14, 100),
(8, 3, '201508', 1, 122),
(9, 3, '201509', 2, 200),
(10, 2, '201508', 1, 100),
(11, 2, '201508', 2, 100),
(12, 2, '201508', 7, 120),
(13, 2, '201509', 11, 150),
(14, 2, '201509', 20, 200),
(15, 3, '201508', 1, 130),
(16, 3, '201508', 2, 170),
(17, 3, '201508', 23, 120),
(18, 3, '201509', 4, 100);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `f_name` varchar(50) NOT NULL,
  `l_name` varchar(50) NOT NULL,
  `nic` varchar(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `privilege` varchar(10) NOT NULL,
  `contact_no` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL,
  `loan` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `f_name`, `l_name`, `nic`, `username`, `password`, `privilege`, `contact_no`, `email`, `loan`) VALUES
(1, 'chamika', 'vishmal', '923464316v', 'chamika', 'e10adc3949ba59abbe56e057f20f883e', 'Administra', '0770373513', 'chamikaudugama@gmail.com', 27860),
(2, 'adad', 'dwd', '550934412v', 'aaa', 'e10adc3949ba59abbe56e057f20f883e', 'Customer', '0770373513', 'chamikavishmal@yahoo.com', 11500),
(3, 'adad', 'dwd', '550934412v', 'aaa', 'e10adc3949ba59abbe56e057f20f883e', 'Customer', '0770373513', 'chamikavishmal2@yahoo.com', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `month_sup_data`
--
ALTER TABLE `month_sup_data`
  ADD CONSTRAINT `month_sup_data_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `t_data`
--
ALTER TABLE `t_data`
  ADD CONSTRAINT `t_data_ibfk_1` FOREIGN KEY (`cus_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
