-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 21, 2020 at 02:51 PM
-- Server version: 5.7.19
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `glhf`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

DROP TABLE IF EXISTS `accounts`;
CREATE TABLE IF NOT EXISTS `accounts` (
  `id` varchar(10) NOT NULL,
  `first_name` varchar(16) NOT NULL,
  `last_name` varchar(16) NOT NULL,
  `password` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `account_type` varchar(16) NOT NULL,
  `experience` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `first_name`, `last_name`, `password`, `dob`, `account_type`, `experience`) VALUES
('brno', 'Brittany', 'Nolan', 'uABt53ym8f', '1978-02-04', 'user', 0),
('daco', 'Daniella', 'Costa', 'cv6cxPyAbG', '1984-04-11', 'reviewer', 5),
('saha', 'Sara', 'Hatfield', 'xxubZmDhYN', '1975-11-09', 'developer', 2),
('hahi', 'Harmony', 'Hicks', 'HSQQtt92Qx', '1964-10-25', 'user', 0),
('pali', 'Paxton', 'Li', '4hPSufEtQw', '1984-12-27', 'reviewer', 4),
('emda', 'Emilee', 'Davila', 'bn8Nr3CjXT', '1965-09-05', 'user', 0),
('mato', 'Maribel', 'Todd', 'txnyXK8bsD', '1999-02-23', 'user', 0),
('elmy', 'Elisha', 'Myers', 'YdU8BXzqwZ', '1969-06-10', 'user', 0),
('jabl', 'Jayleen', 'Black', 'Kkf4W3DNGa', '1984-11-25', 'reviewer', 4),
('alri', 'Alexus', 'Rivas', 'vfKq9q4fqG', '1973-02-23', 'user', 0),
('jagi', 'Jadyn', 'Gilmore', 'JMT7x2aPMG', '1958-01-14', 'user', 0),
('jame', 'Jaydin', 'Mercer', 'wvLPZudNun', '1994-09-23', 'triager', 0),
('drro', 'Drake', 'Rodgers', 'fGe3aWBfKM', '1976-07-25', 'developer', 5),
('amro', 'Amir', 'Rosario', 'xMnpHZCmkm', '1967-10-02', 'user', 0),
('brva', 'Bria', 'Vargas', '8Md8r2R7MR', '1959-09-04', 'user', 0),
('jaew', 'Janet', 'Ewing', 'QYwKydr3xQ', '1970-01-05', 'developer', 4),
('leyo', 'Leonardo', 'Young', 'yGZqJNsM55', '1964-04-09', 'user', 0),
('auba', 'Audrina', 'Barton', 'eLpeA2Rn4B', '1966-03-07', 'user', 0),
('amva', 'Amari', 'Vargas', 'Dty34XCyqd', '1969-01-26', 'user', 0),
('jamu', 'Jaylin', 'Mullen', '4JqqYjW78j', '1958-05-16', 'user', 0),
('mimc', 'Miya', 'Mckee', 'd3MXeZHZuF', '1968-05-10', 'user', 0),
('baor', 'Baron', 'Ortega', '2y5DYhMUma', '1955-04-03', 'user', 0),
('maay', 'Malaki', 'Ayers', 'tZtyyh7ESA', '1984-05-01', 'user', 0),
('jepo', 'Jefferson', 'Potter', '46cLHXuRRh', '1997-03-26', 'triager', 0),
('taad', 'Taliyah', 'Adams', 'mb8xgURNQh', '1979-08-05', 'reviewer', 2),
('enva', 'Enrique', 'Valencia', 'r6DpE6H73s', '1971-10-01', 'user', 0),
('tiro', 'Tiffany', 'Rojas', 'xmVAagkwkM', '1963-08-23', 'user', 0),
('basm', 'Bailey', 'Small', 'RahhZvDVMx', '1980-09-27', 'reviewer', 4),
('kaca', 'Kamora', 'Calhoun', 'fAEWqSGK7M', '1990-02-22', 'triager', 0),
('kawe', 'Kathryn', 'Wells', 'rqxjDfgwCE', '1983-07-19', 'reviewer', 3),
('mafl', 'Mark', 'Flynn', 'ZXaGGArh2m', '1975-10-31', 'developer', 5),
('anst', 'Anna', 'Strong', 'jGU9MkHztb', '1971-10-09', 'user', 0),
('desc', 'Deborah', 'Schroeder', '6nvLbVfusp', '1980-09-29', 'reviewer', 1),
('duan', 'Dulce', 'Andersen', 'hmNWhsANxa', '1964-03-29', 'user', 0),
('moad', 'Mohammad', 'Adams', 'T8AHwhJ6pv', '1963-05-01', 'user', 0),
('jaho', 'Jaron', 'Hooper', 'ZSvNLM5prS', '1971-05-14', 'developer', 8),
('horo', 'Holden', 'Romero', 'JGLVYy2duw', '1982-01-14', 'user', 0),
('trba', 'Tristian', 'Barton', 'PHezTAAXFs', '1965-02-09', 'developer', 1),
('maco', 'Maryjane', 'Cochran', 'nT6nfa78Pw', '1968-05-24', 'user', 0),
('gasu', 'Gaven', 'Sullivan', '36krGSr6na', '1995-07-01', 'user', 0),
('jahe', 'Jazlene', 'Hester', 'h4U6dCaF2h', '1992-07-25', 'user', 0),
('lide', 'Lilian', 'Delacruz', 'Tw69VsfqHs', '1989-04-24', 'triager', 0),
('anwa', 'Annabel', 'Wagner', 'JwuwuzLFgJ', '1961-06-28', 'user', 0),
('yupo', 'Yusuf', 'Powers', 'RyV7uqtWxb', '1963-06-12', 'user', 0),
('jogi', 'Joaquin', 'Gilbert', 'EbgXPZfSjC', '1968-02-25', 'developer', 7),
('ryde', 'Ryann', 'Decker', '65f2y3e6Cm', '1965-06-16', 'user', 0),
('peno', 'Peyton', 'Noble', 'EbUxE8Dgdq', '1962-10-05', 'user', 0),
('anmc', 'Antonio', 'Mcconnell', 'PQWaVGKZyj', '1995-08-28', 'user', 0),
('jiri', 'Jimena', 'Richmond', 'nCNnMdVGgx', '1974-08-20', 'developer', 5),
('reso', 'Reilly', 'Sosa', 'uU9dDSKDsb', '1986-07-15', 'reviewer', 1),
('admin', 'test', 'account', 'admin', '2020-10-01', 'administrator', 99);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `ticket_id` smallint(5) NOT NULL,
  `account_id` varchar(10) NOT NULL,
  `created_date` date NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`ticket_id`,`account_id`,`created_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`ticket_id`, `account_id`, `created_date`, `comment`) VALUES
(2, 'jaew', '2020-10-06', 'The first purchase record is still stored in the database. So there is no loss of information.'),
(2, 'hahi', '2020-10-08', 'The record is actually in the DOM, but is not displayed. Hope that helps you resolve the issue.'),
(5, 'jepo', '2020-10-11', 'Duplicate of ticket #00002. Closed.');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` smallint(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(80) NOT NULL,
  `description` text NOT NULL,
  `created_by` varchar(10) NOT NULL,
  `created_date` date NOT NULL,
  `tags` varchar(127) NOT NULL,
  `status` varchar(16) NOT NULL,
  `assigned_to` varchar(10) NOT NULL,
  `reviewed_by` varchar(10) NOT NULL,
  `duplicate_of` smallint(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `title`, `description`, `created_by`, `created_date`, `tags`, `status`, `assigned_to`, `reviewed_by`, `duplicate_of`) VALUES
(1, 'Cannot update shipping address', 'Users cannot update their shipping address from their profile page. No errors were returned on submit.', 'emda', '2020-10-08', 'shipping address', 'unassigned', '', '', NULL),
(2, 'Purchase history missing first item', 'The user\'s purchase history shows all purchases except the first purchase. If there is only 1 purchase, that purchase is shown.\r\n\r\nItem exists in the table; query or display issue.', 'reso', '2020-10-05', 'purchase history', 'assigned', 'jaew', '', NULL),
(3, 'Cannot see first purchase', 'I can\'t view my first purchase. The rest still appear.', 'duan', '2020-08-05', 'purchase, purchase history', 'closed', '', '', 2),
(4, 'Wrong date of birth', 'Viewing my own profile shows the wrong date of birth.', 'gasu', '2020-09-30', 'dob, date of birth, birthday', 'resolved', 'trba', 'desc', NULL),
(5, 'Setting quantity to 0 does not remove item from basket', 'Setting the purchase amount of an item to 0 does not remove the item. It still shows up in the final receipt with purchase amount of 0.', 'mimc', '2020-10-11', 'purchase, basket', 'pending', 'saha', '', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
