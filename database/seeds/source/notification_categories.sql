/*
SQLyog Community v11.52 (64 bit)
MySQL - 10.4.11-MariaDB : Database - bizinabox_db
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
-- CREATE DATABASE /*!32312 IF NOT EXISTS*/`bizinabox_db` /*!40100 DEFAULT CHARACTER SET utf8 */;
--
-- USE `bizinabox_db`;

/*Table structure for table `notification_categories` */

DROP TABLE IF EXISTS `notification_categories`;

CREATE TABLE `notification_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `notification_categories` */

insert  into `notification_categories`(`id`,`name`,`slug`,`description`,`created_at`,`updated_at`) values (1,'Website Basic Notifications','website-basic-notifications','Website Basic Notifications','2020-08-26 10:11:30','2020-08-26 10:12:57'),(2,'Domain Associated Notification','domain-associated-notification','Domain Associated Notification','2020-08-26 10:13:35','2020-08-26 10:13:35'),(3,'Appointment Notification','appointment-notification','Appointment Notification','2020-08-26 10:13:54','2020-08-26 10:13:54'),(4,'Blog Module Notification','blog-module-notification','Blog Module Notification','2020-08-26 10:14:06','2020-08-26 10:14:06'),(5,'BlogAds Module Notification','blogads-module-notification','BlogAds Module Notification','2020-08-26 10:14:12','2020-08-26 10:14:12'),(6,'Ticket Notification','ticket-notification','Ticket Notification','2020-08-26 10:14:28','2020-08-26 10:14:28'),(8,'Purchase Notification','purchase-notification','Purchase Notification','2020-08-26 10:18:05','2020-08-26 10:18:05'),(9,'Purchase FollowUp Notifications','purchase-followup-notifications','Purchase FollowUp Notifications','2020-08-31 09:55:41','2020-08-31 09:55:41'),(10,'Email Campaign','email-campaign','Email Campaign','2020-09-04 16:12:21','2020-09-04 16:12:21');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
