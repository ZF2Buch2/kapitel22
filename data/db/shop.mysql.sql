SET FOREIGN_KEY_CHECKS=0;
SET AUTOCOMMIT=0;
START TRANSACTION;

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `cdate` datetime DEFAULT NULL,
  `status` varchar(8) DEFAULT NULL,
  `positions` text DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `user_id` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orders_user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

SET FOREIGN_KEY_CHECKS=1;
COMMIT;
