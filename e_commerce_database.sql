-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2019 at 03:47 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `e_commerce_database`
--
CREATE DATABASE IF NOT EXISTS `e_commerce_database` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `e_commerce_database`;

-- --------------------------------------------------------

--
-- Table structure for table `coupon`
--

CREATE TABLE IF NOT EXISTS `coupon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(255) NOT NULL,
  `amount` double NOT NULL,
  `usages` int(11) NOT NULL,
  `expiry` date NOT NULL,
  `created` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `cost` double NOT NULL DEFAULT '0',
  `description` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=102 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `cost`, `description`, `thumbnail`, `quantity`, `tags`, `type`) VALUES
(1, 'Test', 0, 'Some test product', 'null', 0, 'test1,test2,test3,test4', 'test'),
(2, 'eu,', 5.93, 'lectus justo eu arcu. Morbi sit amet massa.', 'ac', 3, 'one,two,three,four,five,six,seven,eight,nine,ten', 'vulputate,'),
(3, 'auctor.', 57.3, 'elit erat vitae risus. Duis a mi fringilla mi lacinia mattis. Integer eu lacus.', 'elit.', 8, 'one,two,three,four,five,six,seven,eight,nine,ten', 'tincidunt'),
(4, 'lectus', 22.77, 'mi', 'cursus', 4, 'one,two,three,four,five,six,seven,eight,nine,ten', 'vitae'),
(5, 'Aliquam', 48.09, 'at, velit. Cras lorem lorem, luctus ut, pellentesque eget, dictum placerat, augue.', 'tincidunt', 1, 'one,two,three,four,five,six,seven,eight,nine,ten', 'mollis'),
(6, 'sed', 24.02, 'Nullam lobortis', 'Duis', 8, 'one,two,three,four,five,six,seven,eight,nine,ten', 'semper'),
(7, 'faucibus', 17.86, 'Curabitur egestas nunc sed libero. Proin sed turpis nec mauris blandit', 'accumsan', 6, 'one,two,three,four,five,six,seven,eight,nine,ten', 'Sed'),
(8, 'parturient', 41.3, 'Morbi metus. Vivamus euismod urna. Nullam lobortis quam a felis ullamcorper viverra. Maecenas iaculis aliquet diam. Sed diam lorem, auctor quis,', 'parturient', 10, 'one,two,three,four,five,six,seven,eight,nine,ten', 'Pellentesque'),
(9, 'orci.', 4.35, 'Sed dictum. Proin eget odio. Aliquam vulputate', 'nec', 5, 'one,two,three,four,five,six,seven,eight,nine,ten', 'pede'),
(10, 'est.', 28.83, 'tellus. Nunc lectus pede, ultrices a, auctor non, feugiat', 'Mauris', 7, 'one,two,three,four,five,six,seven,eight,nine,ten', 'amet'),
(11, 'massa', 72.94, 'tellus.', 'fermentum', 1, 'one,two,three,four,five,six,seven,eight,nine,ten', 'diam.'),
(12, 'molestie', 94.96, 'aliquet vel, vulputate eu, odio.', 'justo', 1, 'one,two,three,four,five,six,seven,eight,nine,ten', 'arcu'),
(13, 'nec', 90.05, 'nostra, per inceptos hymenaeos. Mauris ut quam vel sapien imperdiet ornare. In faucibus. Morbi vehicula. Pellentesque', 'sapien', 10, 'one,two,three,four,five,six,seven,eight,nine,ten', 'sagittis'),
(14, 'vel', 86.17, 'nisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin vel nisl. Quisque', 'velit.', 2, 'one,two,three,four,five,six,seven,eight,nine,ten', 'egestas'),
(15, 'arcu.', 5.53, 'vulputate mauris sagittis placerat. Cras dictum ultricies ligula. Nullam enim. Sed nulla ante, iaculis nec, eleifend', 'amet,', 6, 'one,two,three,four,five,six,seven,eight,nine,ten', 'orci'),
(16, 'eu', 9.95, 'Donec tempor, est ac mattis semper, dui lectus rutrum urna, nec luctus felis purus ac tellus. Suspendisse', 'orci.', 8, 'one,two,three,four,five,six,seven,eight,nine,ten', 'congue,'),
(17, 'dis', 97.26, 'dis parturient montes, nascetur ridiculus mus. Proin vel nisl. Quisque fringilla euismod enim. Etiam', 'pretium', 1, 'one,two,three,four,five,six,seven,eight,nine,ten', 'diam'),
(18, 'tristique', 27.53, 'fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus, at fringilla purus mauris a nunc.', 'ligula', 4, 'one,two,three,four,five,six,seven,eight,nine,ten', 'ligula.'),
(19, 'felis.', 37.22, 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce aliquet magna a neque. Nullam ut', 'quam,', 7, 'one,two,three,four,five,six,seven,eight,nine,ten', 'Sed'),
(20, 'Aenean', 59.29, 'laoreet, libero et tristique pellentesque, tellus sem mollis dui, in', 'dis', 9, 'one,two,three,four,five,six,seven,eight,nine,ten', 'tellus.'),
(21, 'quis,', 29.98, 'non nisi. Aenean eget metus. In nec orci. Donec', 'massa.', 8, 'one,two,three,four,five,six,seven,eight,nine,ten', 'Donec'),
(22, 'Phasellus', 56.61, 'elit sed consequat auctor, nunc nulla vulputate dui, nec tempus mauris erat', 'ornare.', 1, 'one,two,three,four,five,six,seven,eight,nine,ten', 'Proin'),
(23, 'dolor.', 9.2, 'lacus. Aliquam rutrum lorem ac', 'amet,', 5, 'one,two,three,four,five,six,seven,eight,nine,ten', 'fringilla'),
(24, 'litora', 40.74, 'lacinia at, iaculis quis, pede. Praesent eu dui. Cum sociis natoque penatibus et magnis dis parturient montes,', 'dolor.', 10, 'one,two,three,four,five,six,seven,eight,nine,ten', 'mus.'),
(25, 'Proin', 42.47, 'rhoncus. Donec est. Nunc ullamcorper, velit', 'orci,', 2, 'one,two,three,four,five,six,seven,eight,nine,ten', 'non'),
(26, 'Suspendisse', 82.58, 'molestie sodales.', 'fermentum', 6, 'one,two,three,four,five,six,seven,eight,nine,ten', 'non,'),
(27, 'at', 10.49, 'commodo tincidunt nibh. Phasellus nulla. Integer vulputate, risus a ultricies adipiscing, enim', 'at', 2, 'one,two,three,four,five,six,seven,eight,nine,ten', 'Duis'),
(28, 'eu', 30.95, 'pede blandit congue. In scelerisque scelerisque dui. Suspendisse ac', 'commodo', 8, 'one,two,three,four,five,six,seven,eight,nine,ten', 'magna.'),
(29, 'egestas', 90.71, 'morbi tristique senectus et netus et malesuada fames ac', 'a', 2, 'one,two,three,four,five,six,seven,eight,nine,ten', 'facilisis'),
(30, 'aptent', 68.67, 'fringilla, porttitor vulputate, posuere vulputate, lacus. Cras', 'orci,', 1, 'one,two,three,four,five,six,seven,eight,nine,ten', 'cubilia'),
(31, 'luctus.', 43.01, 'magna a tortor. Nunc commodo auctor velit. Aliquam nisl. Nulla eu neque pellentesque massa lobortis ultrices.', 'Donec', 8, 'one,two,three,four,five,six,seven,eight,nine,ten', 'dignissim'),
(32, 'Donec', 77.15, 'porttitor vulputate, posuere vulputate, lacus. Cras interdum. Nunc sollicitudin commodo ipsum. Suspendisse non leo. Vivamus', 'nisl.', 1, 'one,two,three,four,five,six,seven,eight,nine,ten', 'Nam'),
(33, 'ullamcorper', 25.62, 'non, hendrerit id, ante. Nunc mauris', 'dictum', 9, 'one,two,three,four,five,six,seven,eight,nine,ten', 'neque'),
(34, 'bibendum', 33.39, 'imperdiet, erat nonummy ultricies ornare, elit elit fermentum risus,', 'adipiscing', 3, 'one,two,three,four,five,six,seven,eight,nine,ten', 'dui'),
(35, 'ut', 52.57, 'euismod et, commodo at, libero. Morbi accumsan laoreet ipsum. Curabitur consequat, lectus sit amet luctus vulputate,', 'risus', 8, 'one,two,three,four,five,six,seven,eight,nine,ten', 'ligula'),
(36, 'mauris.', 90.96, 'ante blandit viverra. Donec tempus, lorem fringilla ornare placerat, orci lacus vestibulum lorem, sit amet ultricies sem', 'Donec', 8, 'one,two,three,four,five,six,seven,eight,nine,ten', 'ornare.'),
(37, 'ante,', 57.6, 'enim. Mauris quis turpis vitae purus gravida sagittis. Duis gravida. Praesent eu nulla at sem molestie', 'quam,', 7, 'one,two,three,four,five,six,seven,eight,nine,ten', 'enim,'),
(38, 'tincidunt,', 73.53, 'pellentesque massa lobortis ultrices. Vivamus rhoncus. Donec est. Nunc ullamcorper, velit in aliquet lobortis, nisi nibh lacinia orci, consectetuer euismod est arcu', 'commodo', 9, 'one,two,three,four,five,six,seven,eight,nine,ten', 'ipsum'),
(39, 'urna.', 55.66, 'tincidunt dui augue eu tellus. Phasellus elit pede, malesuada vel, venenatis vel, faucibus id, libero. Donec consectetuer', 'lacinia', 6, 'one,two,three,four,five,six,seven,eight,nine,ten', 'vitae'),
(40, 'ac', 75.61, 'Cras dolor dolor, tempus non, lacinia at, iaculis quis, pede. Praesent', 'ornare,', 8, 'one,two,three,four,five,six,seven,eight,nine,ten', 'in,'),
(41, 'vestibulum.', 23.03, 'auctor. Mauris vel turpis. Aliquam adipiscing', 'lacinia', 4, 'one,two,three,four,five,six,seven,eight,nine,ten', 'nec'),
(42, 'non,', 1.82, 'tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at, egestas a, scelerisque', 'Etiam', 8, 'one,two,three,four,five,six,seven,eight,nine,ten', 'malesuada.'),
(43, 'et', 21.04, 'nisi. Mauris', 'nonummy', 9, 'one,two,three,four,five,six,seven,eight,nine,ten', 'eu'),
(44, 'Proin', 43.94, 'Nulla eu neque pellentesque massa lobortis ultrices. Vivamus rhoncus.', 'massa.', 5, 'one,two,three,four,five,six,seven,eight,nine,ten', 'et'),
(45, 'mauris', 43.31, 'senectus et netus et malesuada fames ac', 'placerat.', 8, 'one,two,three,four,five,six,seven,eight,nine,ten', 'Duis'),
(46, 'ut', 39.12, 'in, tempus eu, ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque. Sed eget lacus. Mauris non dui nec urna suscipit', 'orci', 9, 'one,two,three,four,five,six,seven,eight,nine,ten', 'lorem'),
(47, 'nunc', 34.74, 'rutrum urna, nec luctus felis purus ac tellus. Suspendisse sed dolor. Fusce mi', 'nulla.', 6, 'one,two,three,four,five,six,seven,eight,nine,ten', 'eros.'),
(48, 'fringilla', 38.28, 'consectetuer adipiscing elit. Curabitur sed tortor. Integer', 'Quisque', 2, 'one,two,three,four,five,six,seven,eight,nine,ten', 'purus,'),
(49, 'Curabitur', 14.24, 'ridiculus mus. Proin vel arcu eu odio tristique pharetra. Quisque ac libero nec ligula consectetuer', 'euismod', 5, 'one,two,three,four,five,six,seven,eight,nine,ten', 'et'),
(50, 'nulla', 12.1, 'adipiscing elit.', 'enim', 9, 'one,two,three,four,five,six,seven,eight,nine,ten', 'iaculis'),
(51, 'Nulla', 72.79, 'dui. Fusce aliquam, enim nec tempus scelerisque, lorem ipsum sodales purus, in molestie tortor nibh', 'arcu', 8, 'one,two,three,four,five,six,seven,eight,nine,ten', 'purus.'),
(52, 'metus', 85.44, 'ac metus vitae velit egestas lacinia. Sed congue, elit sed consequat auctor, nunc nulla vulputate dui, nec tempus mauris erat', 'nisi.', 5, 'one,two,three,four,five,six,seven,eight,nine,ten', 'magna.'),
(53, 'Fusce', 59.73, 'quam dignissim pharetra. Nam ac nulla. In tincidunt congue turpis. In condimentum. Donec at arcu.', 'habitant', 6, 'one,two,three,four,five,six,seven,eight,nine,ten', 'Maecenas'),
(54, 'Cum', 79.34, 'lacus. Quisque purus sapien,', 'ligula.', 5, 'one,two,three,four,five,six,seven,eight,nine,ten', 'semper'),
(55, 'Curae;', 96.56, 'nec mauris blandit mattis. Cras eget nisi dictum augue malesuada', 'Maecenas', 6, 'one,two,three,four,five,six,seven,eight,nine,ten', 'non'),
(56, 'ut,', 36.44, 'Fusce feugiat. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aliquam auctor, velit eget laoreet posuere, enim', 'diam', 8, 'one,two,three,four,five,six,seven,eight,nine,ten', 'nunc'),
(57, 'et', 50.68, 'sit amet diam eu dolor egestas rhoncus. Proin nisl sem, consequat nec, mollis vitae, posuere at, velit. Cras lorem lorem, luctus ut, pellentesque', 'Aliquam', 3, 'one,two,three,four,five,six,seven,eight,nine,ten', 'risus.'),
(58, 'magna.', 6.08, 'mollis lectus pede et risus. Quisque libero lacus, varius et, euismod et, commodo at, libero. Morbi accumsan', 'montes,', 4, 'one,two,three,four,five,six,seven,eight,nine,ten', 'Mauris'),
(59, 'a,', 21.58, 'Nunc sollicitudin commodo ipsum. Suspendisse non leo. Vivamus nibh dolor, nonummy ac, feugiat non, lobortis', 'In', 7, 'one,two,three,four,five,six,seven,eight,nine,ten', 'arcu.'),
(60, 'egestas.', 65.17, 'ligula consectetuer rhoncus. Nullam velit dui, semper et,', 'Duis', 9, 'one,two,three,four,five,six,seven,eight,nine,ten', 'mollis.'),
(61, 'metus.', 3.26, 'Integer sem elit, pharetra ut, pharetra sed, hendrerit a, arcu. Sed et libero. Proin mi. Aliquam', 'libero', 5, 'one,two,three,four,five,six,seven,eight,nine,ten', 'vel'),
(62, 'purus.', 74.15, 'non leo. Vivamus nibh dolor, nonummy ac, feugiat non, lobortis quis, pede. Suspendisse', 'pharetra.', 9, 'one,two,three,four,five,six,seven,eight,nine,ten', 'Fusce'),
(63, 'nunc', 16.3, 'lorem, luctus ut, pellentesque eget, dictum placerat, augue.', 'ridiculus', 9, 'one,two,three,four,five,six,seven,eight,nine,ten', 'Cras'),
(64, 'ultrices.', 3.97, 'Sed et libero. Proin mi. Aliquam gravida mauris ut mi. Duis risus', 'Phasellus', 4, 'one,two,three,four,five,six,seven,eight,nine,ten', 'urna'),
(65, 'lorem', 0.59, 'tempor augue ac ipsum. Phasellus vitae mauris sit amet lorem semper auctor. Mauris vel turpis. Aliquam adipiscing lobortis risus. In mi pede,', 'mi', 3, 'one,two,three,four,five,six,seven,eight,nine,ten', 'non'),
(66, 'massa', 79.33, 'dignissim. Maecenas ornare egestas ligula. Nullam feugiat placerat velit. Quisque varius. Nam porttitor scelerisque neque. Nullam nisl. Maecenas malesuada fringilla', 'tellus.', 2, 'one,two,three,four,five,six,seven,eight,nine,ten', 'blandit'),
(67, 'vel', 15.94, 'eu, ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque. Sed eget lacus. Mauris non dui nec urna suscipit nonummy.', 'vulputate', 10, 'one,two,three,four,five,six,seven,eight,nine,ten', 'Aenean'),
(68, 'nibh', 2.83, 'dui, semper et, lacinia vitae, sodales at, velit. Pellentesque ultricies dignissim lacus. Aliquam rutrum lorem ac risus. Morbi', 'id', 6, 'one,two,three,four,five,six,seven,eight,nine,ten', 'varius.'),
(69, 'nec', 97.91, 'risus. Morbi metus. Vivamus euismod urna. Nullam lobortis quam a felis ullamcorper viverra. Maecenas iaculis aliquet diam. Sed diam lorem, auctor quis,', 'urna,', 2, 'one,two,three,four,five,six,seven,eight,nine,ten', 'pellentesque'),
(70, 'nulla', 47.6, 'ac, fermentum vel, mauris. Integer sem elit, pharetra ut, pharetra sed, hendrerit a, arcu. Sed et libero. Proin mi. Aliquam', 'ultrices.', 2, 'one,two,three,four,five,six,seven,eight,nine,ten', 'Nulla'),
(71, 'rutrum', 7.04, 'faucibus lectus, a sollicitudin', 'ut', 1, 'one,two,three,four,five,six,seven,eight,nine,ten', 'posuere'),
(72, 'massa.', 99.02, 'Nunc ullamcorper, velit in aliquet lobortis, nisi nibh lacinia', 'eget,', 9, 'one,two,three,four,five,six,seven,eight,nine,ten', 'nec'),
(73, 'augue', 91.53, 'Cras eget nisi dictum augue malesuada malesuada. Integer id magna et ipsum cursus vestibulum. Mauris magna. Duis dignissim tempor', 'scelerisque,', 4, 'one,two,three,four,five,six,seven,eight,nine,ten', 'mauris.'),
(74, 'tincidunt', 31.32, 'Vivamus nisi.', 'varius', 10, 'one,two,three,four,five,six,seven,eight,nine,ten', 'ac'),
(75, 'ultrices', 88.33, 'Cras dolor dolor, tempus non, lacinia at, iaculis quis, pede. Praesent eu dui. Cum sociis natoque penatibus et magnis', 'dui', 9, 'one,two,three,four,five,six,seven,eight,nine,ten', 'risus.'),
(76, 'tellus', 65.38, 'eleifend non, dapibus rutrum, justo. Praesent luctus. Curabitur egestas nunc sed libero. Proin sed turpis nec mauris blandit mattis.', 'pede,', 5, 'one,two,three,four,five,six,seven,eight,nine,ten', 'sit'),
(77, 'sem', 5.32, 'ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec tincidunt. Donec vitae erat vel', 'magna', 1, 'one,two,three,four,five,six,seven,eight,nine,ten', 'imperdiet'),
(78, 'nec', 39.38, 'Aenean gravida nunc sed pede. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', 'sem,', 9, 'one,two,three,four,five,six,seven,eight,nine,ten', 'laoreet,'),
(79, 'est', 26.63, 'libero. Donec consectetuer mauris id sapien. Cras dolor dolor, tempus non, lacinia at,', 'sapien.', 8, 'one,two,three,four,five,six,seven,eight,nine,ten', 'massa.'),
(80, 'velit', 93.34, 'enim non', 'enim.', 4, 'one,two,three,four,five,six,seven,eight,nine,ten', 'non'),
(81, 'montes,', 79.99, 'nec luctus felis purus ac tellus. Suspendisse sed dolor. Fusce mi lorem, vehicula et, rutrum eu, ultrices sit amet, risus. Donec nibh enim,', 'vitae', 6, 'one,two,three,four,five,six,seven,eight,nine,ten', 'lectus,'),
(82, 'Fusce', 91.77, 'In lorem. Donec elementum, lorem ut aliquam iaculis, lacus pede sagittis augue, eu tempor erat', 'Cras', 1, 'one,two,three,four,five,six,seven,eight,nine,ten', 'nulla'),
(83, 'orci,', 20.74, 'velit in aliquet lobortis, nisi nibh lacinia orci, consectetuer euismod est arcu', 'laoreet', 8, 'one,two,three,four,five,six,seven,eight,nine,ten', 'Proin'),
(84, 'arcu.', 66.32, 'risus quis diam luctus lobortis.', 'lorem', 5, 'one,two,three,four,five,six,seven,eight,nine,ten', 'a,'),
(85, 'consequat', 89.58, 'nulla at sem molestie sodales. Mauris', 'odio.', 6, 'one,two,three,four,five,six,seven,eight,nine,ten', 'libero.'),
(86, 'mi,', 30.21, 'urna. Nullam lobortis quam a felis ullamcorper viverra. Maecenas iaculis aliquet diam. Sed', 'lorem', 5, 'one,two,three,four,five,six,seven,eight,nine,ten', 'diam'),
(87, 'at', 87.04, 'Fusce dolor quam, elementum at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et pede.', 'dictum', 1, 'one,two,three,four,five,six,seven,eight,nine,ten', 'quis'),
(88, 'aliquet', 98.6, 'convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat', 'purus', 1, 'one,two,three,four,five,six,seven,eight,nine,ten', 'dui,'),
(89, 'et', 15.03, 'euismod enim. Etiam gravida molestie arcu. Sed eu nibh', 'dapibus', 4, 'one,two,three,four,five,six,seven,eight,nine,ten', 'dolor,'),
(90, 'mauris', 36.57, 'tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id nunc interdum feugiat. Sed', 'arcu.', 9, 'one,two,three,four,five,six,seven,eight,nine,ten', 'Mauris'),
(91, 'molestie', 37, 'libero et tristique pellentesque, tellus sem mollis dui, in sodales elit erat vitae risus. Duis a mi fringilla', 'cursus', 7, 'one,two,three,four,five,six,seven,eight,nine,ten', 'dui'),
(92, 'leo.', 44.05, 'quis massa. Mauris vestibulum, neque', 'tristique', 9, 'one,two,three,four,five,six,seven,eight,nine,ten', 'Integer'),
(93, 'nonummy', 58.24, 'magna. Cras convallis convallis dolor.', 'a,', 9, 'one,two,three,four,five,six,seven,eight,nine,ten', 'elementum'),
(94, 'in,', 61.5, 'a sollicitudin orci sem eget massa. Suspendisse eleifend. Cras', 'felis', 7, 'one,two,three,four,five,six,seven,eight,nine,ten', 'Cum'),
(95, 'leo.', 30.13, 'Duis elementum, dui quis accumsan convallis, ante lectus convallis est, vitae sodales nisi magna sed dui. Fusce aliquam, enim nec tempus', 'enim,', 1, 'one,two,three,four,five,six,seven,eight,nine,ten', 'dignissim'),
(96, 'sit', 54.18, 'ipsum. Donec sollicitudin adipiscing ligula. Aenean gravida nunc sed pede. Cum sociis natoque', 'Nunc', 5, 'one,two,three,four,five,six,seven,eight,nine,ten', 'scelerisque'),
(97, 'ligula.', 13.37, 'Quisque libero lacus, varius et, euismod et, commodo at, libero. Morbi accumsan laoreet', 'cursus.', 3, 'one,two,three,four,five,six,seven,eight,nine,ten', 'convallis'),
(98, 'aliquet', 42.46, 'ullamcorper, nisl arcu iaculis enim, sit amet ornare lectus justo eu arcu. Morbi sit amet massa. Quisque porttitor eros nec', 'ipsum.', 1, 'one,two,three,four,five,six,seven,eight,nine,ten', 'sit'),
(99, 'id,', 22.79, 'dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur', 'ullamcorper,', 10, 'one,two,three,four,five,six,seven,eight,nine,ten', 'Suspendisse'),
(100, 'accumsan', 36.9, 'erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id nunc', 'mi', 9, 'one,two,three,four,five,six,seven,eight,nine,ten', 'et'),
(101, 'sem.', 20.54, 'diam dictum sapien. Aenean massa. Integer', 'eu', 3, 'one,two,three,four,five,six,seven,eight,nine,ten', 'sem.');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer` int(11) NOT NULL,
  `products` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `coupon` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer` (`customer`),
  KEY `coupon` (`coupon`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `other_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `postcode` varchar(13) DEFAULT NULL,
  `telephone` varchar(13) DEFAULT NULL,
  `dob` date NOT NULL,
  `dateOfRegistry` date NOT NULL,
  `privileges` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `first_name`, `last_name`, `other_name`, `email`, `username`, `password`, `address`, `postcode`, `telephone`, `dob`, `dateOfRegistry`, `privileges`) VALUES
(1, 'Carter', 'Howe', 'Allegra', 'mus.Donec@egetodio.co.uk', 'Alan', 'vitae', 'P.O. Box 739, 716 Natoque St.', 'E4Z 2R4', '0800 658139', '1984-06-25', '2018-11-29', 0),
(2, 'Nash', 'Rivera', 'Reed', 'et.netus@Phasellusliberomauris.co.uk', 'Vladimir', 'nunc.', '249-2807 Convallis St.', '8869', '076 5640 4186', '1978-06-25', '2018-07-15', 0),
(3, 'Price', 'Thomas', 'Wynne', 'blandit.mattis.Cras@molestie.co.uk', 'Rafael', 'ornare.', '4951 Ut, Street', '4289', '0800 931 3851', '1977-04-09', '2019-10-30', 0),
(4, 'Raven', 'Hatfield', 'Cameran', 'habitant@rutrumloremac.com', 'Nathaniel', 'mollis', '8438 Dolor Street', '5042', '0500 088521', '1982-11-12', '2018-12-21', 0),
(5, 'Odysseus', 'Kirkland', 'Dominic', 'pretium.neque.Morbi@in.org', 'Michael', 'eget', 'P.O. Box 500, 1226 Risus. St.', '04-994', '07624 616164', '1988-07-24', '2018-09-22', 0),
(6, 'Nina', 'Garrett', 'Janna', 'malesuada@mauris.org', 'Slade', 'lorem,', '883 Magna. Rd.', '12829', '0333 828 7253', '1972-10-31', '2019-04-12', 0),
(7, 'Susan', 'Gomez', 'Larissa', 'quis.massa@elitNulla.com', 'Colorado', 'Nullam', 'P.O. Box 565, 6344 Phasellus Road', '207186', '0804 337 6509', '1992-11-25', '2018-08-03', 0),
(8, 'Mohammad', 'Zimmerman', 'Cameran', 'vitae@eueuismodac.net', 'Myles', 'Suspendisse', 'Ap #954-4494 Fringilla Avenue', '33043', '076 0975 3394', '1974-07-16', '2018-03-27', 0),
(9, 'Oscar', 'Baxter', 'Amelia', 'penatibus.et@consectetuer.org', 'Ira', 'tincidunt', '7240 Hendrerit Street', '07629', '(01964) 29883', '1983-03-05', '2019-08-15', 0),
(10, 'Caldwell', 'Ramsey', 'Ariana', 'lobortis@nisi.edu', 'Kane', 'hendrerit', 'Ap #818-7807 Vitae Rd.', '255019', '07509 015958', '1987-05-21', '2019-08-08', 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `coupon_fk` FOREIGN KEY (`coupon`) REFERENCES `coupon` (`id`),
  ADD CONSTRAINT `customer_fk` FOREIGN KEY (`customer`) REFERENCES `user` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
