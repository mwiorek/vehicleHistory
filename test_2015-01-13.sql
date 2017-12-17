# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.6.21)
# Database: test
# Generation Time: 2015-01-13 14:19:56 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table driver_in_vehicles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `driver_in_vehicles`;

CREATE TABLE `driver_in_vehicles` (
  `entry_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `users_id` int(11) unsigned NOT NULL,
  `registration_number` varchar(10) NOT NULL DEFAULT '',
  `date_assigned` datetime NOT NULL,
  `date_checked_out` datetime DEFAULT NULL,
  `date_returned` datetime DEFAULT NULL,
  `mileage_start` int(11) DEFAULT NULL,
  `mileage_end` int(11) DEFAULT NULL,
  PRIMARY KEY (`entry_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `driver_in_vehicles` WRITE;
/*!40000 ALTER TABLE `driver_in_vehicles` DISABLE KEYS */;

INSERT INTO `driver_in_vehicles` (`entry_id`, `users_id`, `registration_number`, `date_assigned`, `date_checked_out`, `date_returned`, `mileage_start`, `mileage_end`)
VALUES
	(2,24,'XBS122','2015-01-12 08:00:00','2015-01-12 09:30:00','2015-01-12 09:00:00',233,455),
	(9,21,'FER244','2015-01-12 19:43:14','2015-01-12 20:30:11','2015-01-12 21:34:22',1232,1600),
	(10,21,'EER122','2015-01-12 21:39:47','2015-01-12 21:40:19','2015-01-12 21:45:18',2300,2330),
	(11,21,'EER122','2015-01-12 21:45:33','2015-01-12 21:45:37','2015-01-12 21:45:44',2330,2333),
	(13,21,'DFS332','2015-01-13 12:09:13','2015-01-13 12:09:24',NULL,3003,NULL),
	(14,22,'XBS122','2015-01-13 12:20:17',NULL,NULL,25800,NULL);

/*!40000 ALTER TABLE `driver_in_vehicles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table errors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `errors`;

CREATE TABLE `errors` (
  `error_code` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `error_name` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`error_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `errors` WRITE;
/*!40000 ALTER TABLE `errors` DISABLE KEYS */;

INSERT INTO `errors` (`error_code`, `error_name`)
VALUES
	(101,'ERROR_NAME_INTERNAL_PASSWORD_HASH_ERROR'),
	(201,'ERROR_NAME_LOGIN_EMAIL_NOT_FOUND'),
	(202,'ERROR_NAME_PASSWORD_INCORRECT'),
	(203,'ERROR_NAME_NOT_VALID_NAME'),
	(204,'ERROR_NAME_REGISTER_USER_EMAIL_ALREADY_EXISTS'),
	(205,'ERROR_NAME_ACCOUNT_SETTINGS_EMAIL_ALREADY_EXISTS'),
	(206,'ERROR_NAME_NOT_VALID_EMAIL_ADDRESS'),
	(207,'ERROR_NAME_NO_EMAIL_ADDRESS'),
	(208,'ERROR_NAME_NO_PASSWORD_PROVIDED'),
	(209,'ERROR_NAME_NO_PASSWORD_CONFIRMATION_PROVIDED'),
	(210,'ERROR_NAME_PASSWORDS_DO_NOT_MATCH'),
	(211,'ERROR_NAME_NO_OLD_PASSWORD_PROVIDED'),
	(212,'ERROR_NAME_NO_NEW_PASSWORD_PROVIDED'),
	(213,'ERROR_NAME_UPLOADED_IMAGE_TOO_LARGE'),
	(214,'ERROR_NAME_FILE_UPLOAD_ERROR'),
	(215,'ERROR_NAME_IMAGE_FORMAT_NOT_SUPPORTED'),
	(216,'ERROR_NAME_UNABLE_TO_DELETE_ACCOUNT'),
	(217,'ERROR_NAME_NO_REG'),
	(218,'ERROR_NAME_NO_MAKE'),
	(219,'ERROR_NAME_NO_MODEL'),
	(220,'ERROR_NAME_NO_VALID_YEAR'),
	(221,'ERROR_NAME_NO_VALID_MILEAGE'),
	(222,'ERROR_NAME_REGNR_ALREADY_EXISTS'),
	(223,'ERROR_NAME_VEHICLE_OBJ_DOES_NOT_MATCH_HEADER_INFO'),
	(224,'ERROR_NAME_CANNOT_LOWER_MILEAGE'),
	(225,'ERROR_NAME_VEHICLE_STATUS_WAS_NOT_CHANGED'),
	(226,'ERROR_NAME_ROLE_DOESNT_EXISTS'),
	(227,'ERROR_NAME_THIS_IS_THE_ONLY_ADMIN'),
	(228,'ERROR_NAME_ILLEGAL_ARGUMENT'),
	(229,'ERROR_NAME_NO_USER_PROVIDED'),
	(230,'ERROR_NAME_VEHICLE_WASNT_FOUND'),
	(231,'ERROR_NAME_USER_ISNT_DRIVER'),
	(232,'ERROR_NAME_VEHICLE_IS_BUSY'),
	(301,'ERROR_NAME_CSRF_TOKEN_ERROR'),
	(302,'ERROR_NAME_PERMISSION_DENIED');

/*!40000 ALTER TABLE `errors` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `roles_name` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`roles_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;

INSERT INTO `roles` (`roles_name`)
VALUES
	('ADM'),
	('ADMIN'),
	('DRIVER');

/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `users_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `users_name` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
  `users_email_address` varchar(64) CHARACTER SET latin1 DEFAULT NULL,
  `users_password` varchar(255) CHARACTER SET latin1 DEFAULT '',
  `users_profile_image` varchar(32) CHARACTER SET latin1 DEFAULT NULL,
  `last_login` datetime DEFAULT '0000-00-00 00:00:00',
  `last_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `date_created` datetime DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`users_id`, `users_name`, `users_email_address`, `users_password`, `users_profile_image`, `last_login`, `last_modified`, `date_created`)
VALUES
	(19,'Martin Wiorek','martinwiorek@hotmail.com','$2y$10$9kmuahGS8ae4k6tb1/dkFu.9Vexq0STkbAAJsamBy8VLSo.SzFYNS','media/profile_images/19.jpg','2015-01-13 11:05:31','2015-01-11 22:04:52','2015-01-10 16:40:20'),
	(20,'Martin Wiorek01','martin20@hotmail.com','$2y$10$V.PsovXWU8JOdiaGa3oesOdEDvEc99cgBCkubspoMsqaieAdBZVRa','media/profile_images/default.jpg','1970-01-01 01:00:00','2015-01-11 16:20:33','2015-01-11 10:00:11'),
	(21,'MÃ¥rten','martin@mwiorek.se','$2y$10$uLAePPbMjbMQ/5yfqflnfuzpiUMpbJM65xrfolrp3qHS6PkauHQau','media/profile_images/21.jpg','2015-01-13 11:58:55','2015-01-13 14:02:11','2015-01-11 10:00:25'),
	(22,'Klas klasson','clas.k@klas.se','$2y$10$WvnJuLU7gszy06EFk8tWzeRd0/sLpHTR/IUrHGjnMHry1/XmsqjuC','media/profile_images/default.jpg','1970-01-01 01:00:00','2015-01-11 15:25:23','2015-01-11 15:25:23'),
	(23,'MÃ¥rten','info@mwiorek.se','$2y$10$fIgNRULA4Cvxptf0tQ0rQuVMksSnPB4lAKFttQDzjYQeDds1J9ZVu','media/profile_images/default.jpg','2015-01-12 07:45:35','2015-01-12 13:37:30','2015-01-12 07:45:23'),
	(24,'5.5.19','martinwiorek@hotmail.com12','$2y$10$6quCzKRCmsJJ9XH1ytJPfeNoU9aJ5kxC4xgwzxaeB1dAjQGXOxko2','media/profile_images/default.jpg','1970-01-01 01:00:00','2015-01-12 07:46:17','2015-01-12 07:46:17');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users_roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users_roles`;

CREATE TABLE `users_roles` (
  `users_id` int(11) unsigned NOT NULL,
  `role` varchar(32) NOT NULL DEFAULT '',
  PRIMARY KEY (`users_id`,`role`),
  KEY `role` (`role`),
  CONSTRAINT `users_roles_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`users_id`) ON UPDATE CASCADE,
  CONSTRAINT `users_roles_ibfk_2` FOREIGN KEY (`role`) REFERENCES `roles` (`roles_name`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users_roles` WRITE;
/*!40000 ALTER TABLE `users_roles` DISABLE KEYS */;

INSERT INTO `users_roles` (`users_id`, `role`)
VALUES
	(19,'ADM'),
	(23,'ADM'),
	(21,'ADMIN'),
	(24,'ADMIN'),
	(21,'DRIVER'),
	(22,'DRIVER'),
	(24,'DRIVER');

/*!40000 ALTER TABLE `users_roles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table vehicles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `vehicles`;

CREATE TABLE `vehicles` (
  `registration_number` varchar(10) NOT NULL DEFAULT '',
  `make` varchar(32) NOT NULL,
  `model` varchar(32) NOT NULL DEFAULT '',
  `year` int(4) NOT NULL,
  `registration_date` date NOT NULL DEFAULT '0000-00-00',
  `vehicle_mileage` int(11) NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`registration_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `vehicles` WRITE;
/*!40000 ALTER TABLE `vehicles` DISABLE KEYS */;

INSERT INTO `vehicles` (`registration_number`, `make`, `model`, `year`, `registration_date`, `vehicle_mileage`, `active`)
VALUES
	('DFS332','Jeep','Wrangler',2014,'2015-01-12',3003,1),
	('EER122','JEEP','Wrangler Unlimited',2012,'2015-01-12',2333,1),
	('FER244','Jeep','Cherokee',1991,'2015-01-12',1500,1),
	('WRQ234','JEEP','Wrangler',2005,'2015-01-09',234,0),
	('XBS122','JEEP','Grand Cherokee',2014,'2015-01-09',25800,1);

/*!40000 ALTER TABLE `vehicles` ENABLE KEYS */;
UNLOCK TABLES;



--
-- Dumping routines (PROCEDURE) for database 'test'
--
DELIMITER ;;

# Dump of PROCEDURE test_multi_sets
# ------------------------------------------------------------

/*!50003 DROP PROCEDURE IF EXISTS `test_multi_sets` */;;
/*!50003 SET SESSION SQL_MODE=""*/;;
/*!50003 CREATE*/ /*!50020 DEFINER=`root`@`localhost`*/ /*!50003 PROCEDURE `test_multi_sets`()
    DETERMINISTIC
begin
        select user() as first_col;
        select user() as first_col, now() as second_col;
        select user() as first_col, now() as second_col, now() as third_col;
        end */;;

/*!50003 SET SESSION SQL_MODE=@OLD_SQL_MODE */;;
DELIMITER ;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
