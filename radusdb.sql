-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.7.26-0ubuntu0.18.04.1 - (Ubuntu)
-- Server OS:                    Linux
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Dumping database structure for radusdb
CREATE DATABASE IF NOT EXISTS `radusdb` /*!40100 DEFAULT CHARACTER SET utf32 COLLATE utf32_unicode_ci */;
USE `radusdb`;

-- Dumping structure for table radusdb.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(4) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `firstName` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  `lastName` varchar(50) COLLATE utf32_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf32_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf32_unicode_ci DEFAULT NULL,
  `educatearea` varchar(50) COLLATE utf32_unicode_ci DEFAULT NULL,
  `educationqul` varchar(50) COLLATE utf32_unicode_ci DEFAULT NULL,
  `workArea` varchar(50) COLLATE utf32_unicode_ci DEFAULT NULL,
  `wrokExperience` varchar(50) COLLATE utf32_unicode_ci DEFAULT NULL,
  `decision` varchar(50) COLLATE utf32_unicode_ci DEFAULT NULL,
  `createDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `modifiedDate` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

-- Dumping data for table radusdb.user: ~2 rows (approximately)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `firstName`, `lastName`, `email`, `phone`, `educatearea`, `educationqul`, `workArea`, `wrokExperience`, `decision`, `createDate`, `modifiedDate`) VALUES
	(0023, 'svsdvdsvsdvdsvsdv', 'vsdvsdvdssvds', 'panduka.2014255@iit.ac.lk', '0757984977', 'Others', 'Others', 'Database administration', '3 Yrs', 'Sort Listed', '2019-10-26 22:30:38', '2019-10-26 22:50:07'),
	(0024, 'cascas', 'csacas', 'panduka29@gmail.com', '0757984977', 'Information Technology', 'Post Graduate', 'QA Automation', '2 Yrs', 'Sort Listed', '2019-10-26 22:51:56', '2019-10-26 22:51:56');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
