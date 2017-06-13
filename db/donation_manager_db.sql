# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.5.5-10.1.9-MariaDB-log)
# Database: donation_manager
# Generation Time: 2017-05-24 08:09:53 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table campaigns
# ------------------------------------------------------------

DROP TABLE IF EXISTS `campaigns`;

CREATE TABLE `campaigns` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `CampaignName` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `OrgId` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_campaigns` (`OrgId`),
  CONSTRAINT `fk_campaigns` FOREIGN KEY (`OrgId`) REFERENCES `org` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `campaigns` WRITE;
/*!40000 ALTER TABLE `campaigns` DISABLE KEYS */;

INSERT INTO `campaigns` (`id`, `CampaignName`, `Description`, `StartDate`, `OrgId`)
VALUES
	(1,'Fundraiser Gala','Our annual gala fundraiser','2014-11-01',1),
	(2,'Capital Campaign Marathon','Marathon raising money for our capital campaign','2014-10-01',1),
	(3,'Miscellaneous Donations','Direct donations unaffiliated with a specific campaign.','2014-11-19',1),
	(4,'Bake Sale','Gourmet Bake Sale (to end all bake sales)!','2013-12-04',1),
	(5,'test','test','2017-03-03',NULL);

/*!40000 ALTER TABLE `campaigns` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table donations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `donations`;

CREATE TABLE `donations` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `CampaignId` int(11) unsigned NOT NULL,
  `Amount` decimal(64,0) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Notes` varchar(255) DEFAULT NULL,
  `DonorId` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_donations` (`CampaignId`),
  KEY `idx_donations_0` (`DonorId`),
  CONSTRAINT `fk_donations` FOREIGN KEY (`CampaignId`) REFERENCES `campaigns` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_donations_0` FOREIGN KEY (`DonorId`) REFERENCES `donors` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `donations` WRITE;
/*!40000 ALTER TABLE `donations` DISABLE KEYS */;

INSERT INTO `donations` (`id`, `CampaignId`, `Amount`, `Date`, `Notes`, `DonorId`)
VALUES
	(1,4,5000,'2014-01-01','Lyda loved the bake sale! Wants to do more next year.',6),
	(2,2,10000,'2014-02-01','John sponsored 200 runners!',5),
	(3,1,25000,'2014-03-11','Pam is a gold sponsor of the gala',2),
	(4,3,15000,'2014-05-01','A disbursement from his trust',4),
	(5,4,2500,'2014-03-03','He didn\'t even buy any baked good, just donated!',1),
	(6,3,50000,'2014-11-03','A foundation grant',1),
	(7,1,20000,'2014-09-01','Sponsors Table',3),
	(8,1,10000,'2013-09-02','Two plates',5),
	(9,2,10000,'2014-10-09','Sponsored T-shirts',1),
	(10,4,25000,'2015-03-03','Finish Line Donor',3),
	(11,3,20000,'2015-03-11','Foundation Grant',1),
	(12,4,10000,'2015-12-04','Table Sponsor',4),
	(13,4,300000,'2015-12-06','sample',4),
	(14,3,330000,'2016-02-03','',6),
	(15,1,0,'2016-05-09','Bbb',4),
	(16,5,123450,'2016-08-08','',6),
	(17,3,2000,'2016-11-11','Golf fund',6),
	(18,3,1200,'2017-03-01','test',6);

/*!40000 ALTER TABLE `donations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table donors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `donors`;

CREATE TABLE `donors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  `FirstName` varchar(255) DEFAULT NULL,
  `MiddleName` char(1) DEFAULT NULL,
  `LastName` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Phone` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Address_Street_1` varchar(255) DEFAULT NULL,
  `Address_Street_2` varchar(255) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `State` varchar(255) DEFAULT NULL,
  `Zip` varchar(255) DEFAULT NULL,
  `Country` varchar(255) DEFAULT NULL,
  `Occupation` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `donors` WRITE;
/*!40000 ALTER TABLE `donors` DISABLE KEYS */;

INSERT INTO `donors` (`id`, `Name`, `FirstName`, `MiddleName`, `LastName`, `Email`, `Phone`, `Address`, `Address_Street_1`, `Address_Street_2`, `City`, `State`, `Zip`, `Country`, `Occupation`)
VALUES
	(1,'Bill Gates','Bill','','Gates','bill@hotmail.com','443.332.5231','1 Microsoft Way Redmond, WA 98052','1 Microsoft Way','','Redmond','WA','98052','','Software'),
	(2,'Pam Omidyar','Pam','','Omidyar','p.omidyar@gmail.com','877.326.4332','Honolulu, HI ','','','Honolulu','HI','','','Entrepreneur'),
	(3,'Millicent Atkins','Millicent','','Atkins','millicent@atkins.com','443.225.3267','Ipswich, SD ','','','Ipswich','SD','','','Retired'),
	(4,'George Mitchell','George','','Mitchell','g.mitchel@yahoo.com','','Galveston, TX ','','','Galveston','TX','','','CEO'),
	(5,'John Arrillaga','John','','Arrillaga','john.a@gmail.com','774.338.2545','star, CA ','','','star','CA','','','Developer'),
	(6,'Lyda Hill','Lyda','','Hill','lyda@hill.com','554.856.3241','Dallas, TX ','','','Dallas','TX','','','Entrepreneur');

/*!40000 ALTER TABLE `donors` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table org
# ------------------------------------------------------------

DROP TABLE IF EXISTS `org`;

CREATE TABLE `org` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `org` WRITE;
/*!40000 ALTER TABLE `org` DISABLE KEYS */;

INSERT INTO `org` (`id`, `Name`)
VALUES
	(1,'World Envision');

/*!40000 ALTER TABLE `org` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
