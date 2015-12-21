CREATE DATABASE Rest;
USE Rest;
CREATE TABLE IF NOT EXISTS `mail_gearman` (
  `id` bigint(20) NOT NULL auto_increment,
  `to` varchar(255) NOT NULL,
  `from` varchar(255) NOT NULL,
  `attachment` varchar(255) NOT NULL,
  `message` TEXT,
  `priority` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
);