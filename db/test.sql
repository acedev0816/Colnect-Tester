/*
SQLyog Trial v13.1.8 (64 bit)
MySQL - 10.4.28-MariaDB : Database - test
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `domain` */

DROP TABLE IF EXISTS `domain`;

CREATE TABLE `domain` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `domain` */

insert  into `domain`(`id`,`name`) values 
(1,'google.com'),
(2,'stackoverflow.com'),
(3,'php.net'),
(4,'w3schools.com'),
(5,'devpratical.com'),
(6,'github.com'),
(7,'gitlab.com'),
(8,'codepen.io'),
(9,'web.skype.com'),
(10,'drive.google.com'),
(11,'upwork.com');

/*Table structure for table `element` */

DROP TABLE IF EXISTS `element`;

CREATE TABLE `element` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `element` */

insert  into `element`(`id`,`name`) values 
(1,'img'),
(2,'div'),
(3,'p'),
(4,'a'),
(5,'b'),
(6,'i'),
(7,'strong'),
(8,'pre'),
(9,'label'),
(10,'form'),
(11,'script'),
(12,'head'),
(13,'html'),
(14,'body');

/*Table structure for table `requests` */

DROP TABLE IF EXISTS `requests`;

CREATE TABLE `requests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url_id` mediumint(8) unsigned NOT NULL,
  `element_id` mediumint(8) unsigned NOT NULL,
  `time` datetime NOT NULL,
  `duration` mediumint(8) unsigned NOT NULL,
  `count` mediumint(9) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `requests` */

insert  into `requests`(`id`,`url_id`,`element_id`,`time`,`duration`,`count`) values 
(1,1,1,'2023-09-08 06:02:23',34,3),
(2,1,1,'2023-09-08 13:11:50',2,2),
(3,14,14,'2023-09-08 12:22:39',2315,1),
(4,15,14,'2023-09-08 12:27:12',3679,1),
(5,16,1,'2023-09-08 12:46:48',1286,3),
(6,16,1,'2023-09-08 12:48:09',1329,3),
(7,16,1,'2023-09-07 12:48:12',1118,3),
(8,15,14,'2023-09-08 12:27:12',3679,1),
(9,15,14,'2023-09-08 12:27:12',3679,1),
(55,19,1,'2023-09-08 14:52:33',6654,3),
(56,19,2,'2023-09-08 14:52:44',4998,12),
(57,20,2,'2023-09-08 15:09:53',1399,438),
(58,20,2,'2023-09-08 15:09:53',1399,438),
(59,20,2,'2023-09-08 15:09:53',1399,438),
(60,20,2,'2023-09-08 15:09:53',1399,438),
(61,20,2,'2023-09-08 15:09:53',1399,438),
(62,20,2,'2023-09-08 15:09:53',1399,438),
(63,20,2,'2023-09-08 15:09:53',1399,438),
(64,20,2,'2023-09-08 15:09:53',1399,438),
(65,20,2,'2023-09-08 15:09:53',1399,438),
(66,21,2,'2023-09-08 15:10:58',1863,470),
(67,21,2,'2023-09-08 15:10:58',1863,470),
(68,21,2,'2023-09-08 15:10:58',1863,470);

/*Table structure for table `url` */

DROP TABLE IF EXISTS `url`;

CREATE TABLE `url` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `path` varchar(200) DEFAULT NULL,
  `domain_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

/*Data for the table `url` */

insert  into `url`(`id`,`path`,`domain_id`) values 
(1,'a/a',1),
(2,'search?q=a',1),
(3,'search?q=bsd',1),
(4,'search?q=dss',1),
(5,'search?q=asdfsdf',1),
(6,'questions/8071149/post-remaining-empty?rq=3',2),
(7,'',2),
(8,'company/work-here',2),
(9,'company/careers',2),
(10,'',3),
(11,'',4),
(12,'',5),
(13,'',6),
(14,'',13),
(15,'',14),
(16,'/manual/en/domnodelist.count.php',15),
(17,'',16),
(18,'manual/en/domnodelist.count.php',16),
(19,'net/manual/en/domnodelist.count.php',3),
(20,'questions/43773410/when-using-now-in-mysql-can-i-be-certain-that-the-correct-utc-value-will-be-st',2),
(21,'questions/17363545/file-get-contents-is-not-working-for-some-url',2);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
