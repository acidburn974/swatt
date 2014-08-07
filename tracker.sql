<<<<<<< HEAD
CREATE TABLE `articles` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`slug` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`created_at` datetime NULL DEFAULT NULL,
`updated_at` datetime NULL DEFAULT NULL,
`user_id` int(11) NOT NULL,
PRIMARY KEY (`id`) ,
INDEX `fk_articles_users1_idx` (`user_id`)
)
AUTO_INCREMENT=1;

CREATE TABLE `categories` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`slug` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`num_torrent` int(11) NULL,
PRIMARY KEY (`id`) 
)
AUTO_INCREMENT=1;

CREATE TABLE `comments` (
`id` int(10) NOT NULL AUTO_INCREMENT,
`content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`torrent_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
`article_id` int(11) NULL DEFAULT NULL,
`user_id` int(11) NULL DEFAULT NULL,
`created_at` datetime NULL,
`updated_at` datetime NULL,
PRIMARY KEY (`id`) ,
INDEX `fk_comments_torrents_1` (`torrent_id`),
INDEX `fk_comments_users_1` (`user_id`),
INDEX `fk_comments_articles_1` (`article_id`)
)
AUTO_INCREMENT=1;

CREATE TABLE `files` (
`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`size` bigint(20) UNSIGNED NOT NULL,
`torrent_id` bigint(20) UNSIGNED NOT NULL,
PRIMARY KEY (`id`) ,
INDEX `fk_files_torrents1_idx` (`torrent_id`)
)
AUTO_INCREMENT=1;

CREATE TABLE `forums` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`position` int(11) NULL DEFAULT NULL,
`num_topic` int(11) NULL DEFAULT NULL,
`num_post` int(11) NULL DEFAULT NULL,
`last_topic_id` int(11) NULL DEFAULT NULL,
`last_topic_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`last_topic_slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`last_topic_user_id` int(11) NULL DEFAULT NULL,
`last_topic_user_username` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`name` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`slug` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`description` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
`parent_id` int(11) NULL DEFAULT NULL,
`created_at` datetime NULL DEFAULT NULL,
`updated_at` datetime NULL DEFAULT NULL,
PRIMARY KEY (`id`) 
)
AUTO_INCREMENT=1;

CREATE TABLE `groups` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`slug` varchar(90) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`is_admin` tinyint(4) NOT NULL,
`is_modo` tinyint(4) NOT NULL,
PRIMARY KEY (`id`) 
)
AUTO_INCREMENT=1;

CREATE TABLE `peers` (
`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`peer_id` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`ip` varchar(64) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`port` smallint(5) UNSIGNED NOT NULL,
`uploaded` bigint(20) UNSIGNED NOT NULL,
`downloaded` bigint(20) UNSIGNED NOT NULL,
`left` bigint(20) UNSIGNED NOT NULL,
`seeder` tinyint(4) NOT NULL,
`created_at` datetime NULL DEFAULT NULL,
`updated_at` datetime NULL DEFAULT NULL,
`torrent_id` bigint(20) UNSIGNED NOT NULL,
`user_id` int(11) NOT NULL,
PRIMARY KEY (`id`) ,
INDEX `fk_peers_torrents1_idx` (`torrent_id`),
INDEX `fk_peers_users1_idx` (`user_id`)
)
AUTO_INCREMENT=1;

CREATE TABLE `permissions` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`show_forum` tinyint(4) NOT NULL,
`read_topic` tinyint(4) NOT NULL,
`reply_topic` tinyint(4) NOT NULL,
`start_topic` tinyint(4) NOT NULL,
`upload` tinyint(4) NOT NULL,
`download` tinyint(4) NOT NULL,
`forum_id` int(11) NOT NULL,
`group_id` int(11) NOT NULL,
PRIMARY KEY (`id`) ,
INDEX `fk_permissions_forums1_idx` (`forum_id`),
INDEX `fk_permissions_groups1_idx` (`group_id`)
)
AUTO_INCREMENT=1;

CREATE TABLE `posts` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`created_at` datetime NULL DEFAULT NULL,
`updated_at` datetime NULL DEFAULT NULL,
`user_id` int(11) NOT NULL,
`topic_id` int(11) NOT NULL,
PRIMARY KEY (`id`) ,
INDEX `fk_forum_posts_users1_idx` (`user_id`),
INDEX `fk_posts_topics1_idx` (`topic_id`)
)
AUTO_INCREMENT=1;

CREATE TABLE `topics` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`slug` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`state` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`num_post` int(11) NULL DEFAULT NULL,
`first_post_user_id` int(11) NULL DEFAULT NULL,
`last_post_user_id` int(11) NULL DEFAULT NULL,
`first_post_user_username` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`last_post_user_username` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`views` int(11) NULL DEFAULT NULL,
`pinned` tinyint(4) NULL DEFAULT NULL,
`created_at` datetime NULL DEFAULT NULL,
`updated_at` datetime NULL DEFAULT NULL,
`forum_id` int(11) NOT NULL,
PRIMARY KEY (`id`) ,
INDEX `fk_topics_forums1_idx` (`forum_id`)
)
AUTO_INCREMENT=1;

CREATE TABLE `torrents` (
`id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
`name` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`slug` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`description` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`info_hash` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`file_name` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`num_file` int(11) NOT NULL,
`size` float NOT NULL,
`nfo` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
`leechers` int(11) NOT NULL,
`seeders` int(11) NOT NULL,
`times_completed` int(11) NOT NULL,
`created_at` datetime NOT NULL,
`updated_at` datetime NOT NULL,
`category_id` int(11) NOT NULL,
`announce` varchar(255) NOT NULL,
`user_id` int(11) NOT NULL,
PRIMARY KEY (`id`) ,
INDEX `fk_table1_categories1_idx` (`category_id`),
INDEX `fk_torrents_users1_idx` (`user_id`)
)
AUTO_INCREMENT=1;

CREATE TABLE `users` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`username` varchar(80) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`email` varchar(90) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`password` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`passkey` varchar(40) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
`uploaded` bigint(20) NOT NULL,
`downloaded` bigint(20) NOT NULL,
`image` varchar(255) NULL,
`about` varchar(255) NULL,
`remember_token` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
`created_at` datetime NULL DEFAULT NULL,
`updated_at` datetime NULL DEFAULT NULL,
`group_id` int(11) NOT NULL,
PRIMARY KEY (`id`) ,
INDEX `fk_users_groups_idx` (`group_id`)
)
AUTO_INCREMENT=1;

CREATE TABLE `uploads` (
`id` int(10) NOT NULL AUTO_INCREMENT,
`link` varchar(255) NULL,
`host` varchar(255) NULL,
`created_at` varchar(255) NULL,
`updated_at` datetime NULL,
`user_id` int NOT NULL,
PRIMARY KEY (`id`) 
);


ALTER TABLE `articles` ADD CONSTRAINT `fk_articles_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
ALTER TABLE `comments` ADD CONSTRAINT `fk_comments_articles_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`);
ALTER TABLE `comments` ADD CONSTRAINT `fk_comments_torrents_1` FOREIGN KEY (`torrent_id`) REFERENCES `torrents` (`id`);
ALTER TABLE `comments` ADD CONSTRAINT `fk_comments_users_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
ALTER TABLE `files` ADD CONSTRAINT `fk_files_torrents1` FOREIGN KEY (`torrent_id`) REFERENCES `torrents` (`id`);
ALTER TABLE `peers` ADD CONSTRAINT `fk_peers_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
ALTER TABLE `peers` ADD CONSTRAINT `fk_peers_torrents1` FOREIGN KEY (`torrent_id`) REFERENCES `torrents` (`id`);
ALTER TABLE `permissions` ADD CONSTRAINT `fk_permissions_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);
ALTER TABLE `permissions` ADD CONSTRAINT `fk_permissions_forums1` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`id`);
ALTER TABLE `posts` ADD CONSTRAINT `fk_posts_topics1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`);
ALTER TABLE `posts` ADD CONSTRAINT `fk_forum_posts_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
ALTER TABLE `topics` ADD CONSTRAINT `fk_topics_forums1` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`id`);
ALTER TABLE `torrents` ADD CONSTRAINT `fk_torrents_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
ALTER TABLE `torrents` ADD CONSTRAINT `fk_table1_categories1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
ALTER TABLE `users` ADD CONSTRAINT `fk_users_groups` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);
ALTER TABLE `uploads` ADD CONSTRAINT `fk_uploads_users_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

=======
/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : tracker

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2014-08-06 09:40:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for articles
-- ----------------------------
DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `brief` tinytext NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_articles_users1_idx` (`user_id`),
  CONSTRAINT `fk_articles_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of articles
-- ----------------------------
INSERT INTO `articles` VALUES ('1', 'Ralamoin un tracker next-gen', 'ralamoin-un-tracker-next-gen', 'Qu\'est-ce que ralamoin ? \r\nRalamoin est un tracker torrent de nouvelle generation qui est basé sur le framework PHP Laravel dont le but est de proposer des torrents gratuit et de crée une communauté autour du partage.\r\n', '<h2>Qu\'est-ce que ralamoin ?&nbsp;</h2>\r\n\r\n<p>Ralamoin est un tracker torrent de nouvelle generation qui est basé développé en PHP et basé sur un framework.</p>\r\n\r\n<p>Ralamoin propose des torrents en telechargement gratuit.</p>\r\n\r\n<h2>Pourquoi ralamoin ?</h2>\r\n\r\n<p>Ralamoin est d\'abord l\'ocasion d\'améliorer le script qui est basé sur Laravel et est un première dans le genre.</p>\r\n\r\n<p>Pour celà un forum est a disposition et permet à chacun de dire ce qu\'il pense à propos du tracker.</p>\r\n\r\n<h3>Que comporte ce script ?</h3>\r\n\r\n<p>Le script comporte un tracker torrent (bien entendu), un système de gestion d\'article, un forum de discussion et une partie d\'administration.</p>\r\n\r\n<p>A l\'heure ou nous écrivons ces lignes le script n\'est encore qu\'en version alpha et toutes les fonctionnalitées ne sont pas disponible.</p>\r\n', '2014-07-31 19:57:43', '2014-07-31 19:58:10', '1');

-- ----------------------------
-- Table structure for categories
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `slug` varchar(45) NOT NULL,
  `num_torrent` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES ('1', 'Operating System', 'operating-system', '1');

-- ----------------------------
-- Table structure for comments
-- ----------------------------
DROP TABLE IF EXISTS `comments`;
CREATE TABLE `comments` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `torrent_id` bigint(20) unsigned DEFAULT NULL,
  `article_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_comments_torrents_1` (`torrent_id`),
  KEY `fk_comments_users_1` (`user_id`),
  KEY `fk_comments_articles_1` (`article_id`),
  CONSTRAINT `fk_comments_articles_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id`),
  CONSTRAINT `fk_comments_torrents_1` FOREIGN KEY (`torrent_id`) REFERENCES `torrents` (`id`),
  CONSTRAINT `fk_comments_users_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of comments
-- ----------------------------
INSERT INTO `comments` VALUES ('1', 'Ceci est un test commentaire sur mon premier article.', null, '1', '1', '2014-08-03 12:09:05', '2014-08-03 12:09:05');

-- ----------------------------
-- Table structure for files
-- ----------------------------
DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `size` bigint(20) unsigned NOT NULL,
  `torrent_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_files_torrents1_idx` (`torrent_id`),
  CONSTRAINT `fk_files_torrents1` FOREIGN KEY (`torrent_id`) REFERENCES `torrents` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of files
-- ----------------------------
INSERT INTO `files` VALUES ('1', 'ubuntu-14.04.1-desktop-amd64.iso', '1028653056', '1');

-- ----------------------------
-- Table structure for forums
-- ----------------------------
DROP TABLE IF EXISTS `forums`;
CREATE TABLE `forums` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `position` int(11) DEFAULT NULL,
  `num_topic` int(11) DEFAULT NULL,
  `num_post` int(11) DEFAULT NULL,
  `last_topic_id` int(11) DEFAULT NULL,
  `last_topic_name` varchar(255) DEFAULT NULL,
  `last_topic_slug` varchar(255) DEFAULT NULL,
  `last_topic_user_id` int(11) DEFAULT NULL,
  `last_topic_user_username` varchar(45) DEFAULT NULL,
  `name` varchar(45) DEFAULT NULL,
  `slug` varchar(45) DEFAULT NULL,
  `description` text,
  `parent_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of forums
-- ----------------------------
INSERT INTO `forums` VALUES ('1', '1', null, null, null, null, null, null, null, 'Administration', 'administration', 'Forum d\'administration', '0', '2014-08-01 13:58:56', '2014-08-01 13:58:56');
INSERT INTO `forums` VALUES ('2', '1', null, null, null, null, null, null, null, 'Forum du staff', 'forum-du-staff', 'Tout ce qui concerne l\'administration du tracker et la modération.', '1', '2014-08-01 13:59:38', '2014-08-01 13:59:38');
INSERT INTO `forums` VALUES ('3', '2', null, null, null, null, null, null, null, 'Le tracker', 'le-tracker', '', '0', '2014-08-01 14:00:37', '2014-08-01 14:02:07');
INSERT INTO `forums` VALUES ('4', '2', null, null, null, null, null, null, null, 'Presentation', 'presentation', 'Présentez-vous ici', '3', '2014-08-01 14:01:22', '2014-08-01 14:02:11');
INSERT INTO `forums` VALUES ('5', '2', null, null, null, null, null, null, null, 'Espace Détente', 'espace-detente', '', '3', '2014-08-01 14:01:53', '2014-08-01 14:02:15');

-- ----------------------------
-- Table structure for groups
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `slug` varchar(90) NOT NULL,
  `is_admin` tinyint(4) NOT NULL,
  `is_modo` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of groups
-- ----------------------------
INSERT INTO `groups` VALUES ('1', 'Validating', 'validating', '0', '0');
INSERT INTO `groups` VALUES ('2', 'Guests', 'guests', '0', '0');
INSERT INTO `groups` VALUES ('3', 'Members', 'members', '0', '0');
INSERT INTO `groups` VALUES ('4', 'Administrators', 'administrators', '1', '1');
INSERT INTO `groups` VALUES ('5', 'Banned', 'banned', '0', '0');
INSERT INTO `groups` VALUES ('6', 'Moderators', 'moderators', '0', '1');

-- ----------------------------
-- Table structure for peers
-- ----------------------------
DROP TABLE IF EXISTS `peers`;
CREATE TABLE `peers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `peer_id` varchar(40) NOT NULL,
  `ip` varchar(64) NOT NULL,
  `port` smallint(5) unsigned NOT NULL,
  `uploaded` bigint(20) unsigned NOT NULL,
  `downloaded` bigint(20) unsigned NOT NULL,
  `left` bigint(20) unsigned NOT NULL,
  `seeder` tinyint(4) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `torrent_id` bigint(20) unsigned NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_peers_torrents1_idx` (`torrent_id`),
  KEY `fk_peers_users1_idx` (`user_id`),
  CONSTRAINT `fk_peers_torrents1` FOREIGN KEY (`torrent_id`) REFERENCES `torrents` (`id`),
  CONSTRAINT `fk_peers_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of peers
-- ----------------------------
INSERT INTO `peers` VALUES ('1', '-TR2820-ueuems5ew7c8', '108.162.229.121', '51522', '0', '0', '0', '1', '2014-07-31 20:11:24', '2014-08-03 13:19:10', '1', '1');

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `show_forum` tinyint(4) NOT NULL,
  `read_topic` tinyint(4) NOT NULL,
  `reply_topic` tinyint(4) NOT NULL,
  `start_topic` tinyint(4) NOT NULL,
  `upload` tinyint(4) NOT NULL,
  `download` tinyint(4) NOT NULL,
  `forum_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_permissions_forums1_idx` (`forum_id`),
  KEY `fk_permissions_groups1_idx` (`group_id`),
  CONSTRAINT `fk_permissions_forums1` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`id`),
  CONSTRAINT `fk_permissions_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', '0', '0', '0', '0', '0', '0', '1', '1');
INSERT INTO `permissions` VALUES ('2', '0', '0', '0', '0', '0', '0', '1', '2');
INSERT INTO `permissions` VALUES ('3', '0', '0', '0', '0', '0', '0', '1', '3');
INSERT INTO `permissions` VALUES ('4', '1', '1', '1', '1', '1', '1', '1', '4');
INSERT INTO `permissions` VALUES ('5', '0', '0', '0', '0', '0', '0', '1', '5');
INSERT INTO `permissions` VALUES ('6', '1', '1', '1', '1', '1', '1', '1', '6');
INSERT INTO `permissions` VALUES ('7', '0', '0', '0', '0', '0', '0', '2', '1');
INSERT INTO `permissions` VALUES ('8', '0', '0', '0', '0', '0', '0', '2', '2');
INSERT INTO `permissions` VALUES ('9', '0', '0', '0', '0', '0', '0', '2', '3');
INSERT INTO `permissions` VALUES ('10', '1', '1', '1', '1', '1', '1', '2', '4');
INSERT INTO `permissions` VALUES ('11', '0', '0', '0', '0', '0', '0', '2', '5');
INSERT INTO `permissions` VALUES ('12', '1', '1', '1', '1', '1', '1', '2', '6');
INSERT INTO `permissions` VALUES ('13', '1', '1', '0', '0', '0', '0', '3', '1');
INSERT INTO `permissions` VALUES ('14', '1', '1', '0', '0', '0', '0', '3', '2');
INSERT INTO `permissions` VALUES ('15', '1', '1', '0', '1', '0', '0', '3', '3');
INSERT INTO `permissions` VALUES ('16', '1', '1', '1', '1', '1', '1', '3', '4');
INSERT INTO `permissions` VALUES ('17', '1', '1', '0', '0', '0', '0', '3', '5');
INSERT INTO `permissions` VALUES ('18', '1', '1', '1', '1', '1', '1', '3', '6');
INSERT INTO `permissions` VALUES ('19', '1', '1', '0', '0', '0', '0', '4', '1');
INSERT INTO `permissions` VALUES ('20', '1', '1', '0', '0', '0', '0', '4', '2');
INSERT INTO `permissions` VALUES ('21', '1', '1', '0', '1', '0', '0', '4', '3');
INSERT INTO `permissions` VALUES ('22', '1', '1', '0', '1', '0', '0', '4', '4');
INSERT INTO `permissions` VALUES ('23', '1', '1', '0', '0', '0', '0', '4', '5');
INSERT INTO `permissions` VALUES ('24', '1', '1', '0', '1', '0', '0', '4', '6');
INSERT INTO `permissions` VALUES ('25', '1', '1', '0', '0', '0', '0', '5', '1');
INSERT INTO `permissions` VALUES ('26', '1', '1', '0', '0', '0', '0', '5', '2');
INSERT INTO `permissions` VALUES ('27', '1', '1', '0', '1', '0', '0', '5', '3');
INSERT INTO `permissions` VALUES ('28', '1', '1', '0', '1', '0', '0', '5', '4');
INSERT INTO `permissions` VALUES ('29', '1', '1', '0', '0', '0', '0', '5', '5');
INSERT INTO `permissions` VALUES ('30', '1', '1', '0', '1', '0', '0', '5', '6');

-- ----------------------------
-- Table structure for posts
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `topic_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_forum_posts_users1_idx` (`user_id`),
  KEY `fk_posts_topics1_idx` (`topic_id`),
  CONSTRAINT `fk_forum_posts_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `fk_posts_topics1` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of posts
-- ----------------------------

-- ----------------------------
-- Table structure for topics
-- ----------------------------
DROP TABLE IF EXISTS `topics`;
CREATE TABLE `topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `slug` varchar(45) NOT NULL,
  `state` varchar(45) DEFAULT NULL,
  `num_post` int(11) DEFAULT NULL,
  `first_post_user_id` int(11) DEFAULT NULL,
  `last_post_user_id` int(11) DEFAULT NULL,
  `first_post_user_username` varchar(45) DEFAULT NULL,
  `last_post_user_username` varchar(45) DEFAULT NULL,
  `views` int(11) DEFAULT NULL,
  `pinned` tinyint(4) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `forum_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_topics_forums1_idx` (`forum_id`),
  CONSTRAINT `fk_topics_forums1` FOREIGN KEY (`forum_id`) REFERENCES `forums` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of topics
-- ----------------------------

-- ----------------------------
-- Table structure for torrents
-- ----------------------------
DROP TABLE IF EXISTS `torrents`;
CREATE TABLE `torrents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `slug` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `info_hash` varchar(40) NOT NULL,
  `file_name` varchar(45) NOT NULL,
  `num_file` int(11) NOT NULL,
  `size` float NOT NULL,
  `nfo` text,
  `leechers` int(11) NOT NULL,
  `seeders` int(11) NOT NULL,
  `times_completed` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `category_id` int(11) NOT NULL,
  `announce` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_table1_categories1_idx` (`category_id`),
  KEY `fk_torrents_users1_idx` (`user_id`),
  CONSTRAINT `fk_table1_categories1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `fk_torrents_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of torrents
-- ----------------------------
INSERT INTO `torrents` VALUES ('1', 'Ubuntu 14.04', 'ubuntu-1404', '[b]Ubuntu[/b]\r\n\r\n[img]http://img.clubic.com/03776856-photo-ubuntu-logo-sq-gb.jpg[/img]\r\n\r\n[url=http://streetprez.fr/][img]http://img.streetprez.fr/fr_FR/vert/infoLogiciel.png[/img][/url]\r\n\r\n[b]Éditeur[/b][i] :Canonical[/i]\r\n[url=http://streetprez.fr/][img]http://img.streetprez.fr/fr_FR/vert/detailLogiciel.png[/img][/url]\r\n\r\n\r\n\r\n[url=http://streetprez.fr/][img]http://img.streetprez.fr/fr_FR/vert/infoUpload.png[/img][/url]\r\n\r\n[b]Langue :[/b][i] Array[/i]\r\n[url=http://streetprez.fr/][img]http://img.streetprez.fr/fr_FR/vert/infoDownload.png[/img][/url]\r\n\r\n[b]Nom de la release :[/b][i] Ubuntu 14.04[/i]\r\n[url=http://streetprez.fr/][img]http://img.streetprez.fr/logo.png[/img][/url]', '91ab956ef541934230ac75e2360014ddc307027e', '53daa18b9d900.torrent', '1', '1028650000', '', '0', '1', '0', '2014-07-31 20:05:31', '2014-08-05 17:59:03', '1', 'http://www.ralamoin.com/announce', '1');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(80) NOT NULL,
  `email` varchar(90) NOT NULL,
  `password` varchar(150) NOT NULL,
  `passkey` varchar(40) NOT NULL,
  `uploaded` bigint(20) NOT NULL,
  `downloaded` bigint(20) NOT NULL,
  `about` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `remember_token` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `group_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_groups_idx` (`group_id`),
  CONSTRAINT `fk_users_groups` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'acidburn974', 'djstone974@hotmail.com', '$2y$10$KX0H6ksQLGAlGyXEw3H9zuMCvxqE2UQvSCnEuZouynyPO4B3UbP9O', 'fc0294170168df5bf51363a85ae98d68', '2147483648', '1073741824', '', null, 'wav7uaR9wqONvMRkUXWvc6RrFdKfTkREo4yuOifPSY6V7blfmP', '2014-07-31 19:02:49', '2014-07-31 20:16:17', '4');
INSERT INTO `users` VALUES ('2', 'Misterwhite', 'misterwhite974@gmail.com', '$2y$10$Tsuc/ms.usPlGMqnF0EWzOYyCcHXDAwsYPdIVoTAindOQwERHRj/u', 'c45afc5136b118c14183c72eed8e1202', '2147483648', '1073741824', '', null, 'UbKBcQiaUCCvbJRnIDm13Jpfr08HQlsWrzxKyfnh4Mrt88uIcZ', '2014-07-31 19:05:17', '2014-07-31 19:11:43', '4');
INSERT INTO `users` VALUES ('3', 'HiCADjwddW', 'wo.lfgan.gi.m.a@gmail.com', '$2y$10$W86lVUeroAm4UUM9qtRHCOw4Gz3XQ9OXF76sx4pSCyx.qN0qgi8Wa', 'e1a0d9763d2785347ee12204d3447785', '2147483648', '1073741824', '', null, null, '2014-08-01 07:21:49', '2014-08-01 07:21:49', '3');
INSERT INTO `users` VALUES ('4', 'pika974', 'fabien.gourama@gmail.com', '$2y$10$LwnPTmpYAuTSOA8kp7xl8uL1LQGCkPJomZN029.LXmEnsfBEHLONa', '002babf37b15e89a6c94fb8480c85cc7', '2147483648', '1073741824', '', null, null, '2014-08-01 14:20:48', '2014-08-01 14:20:48', '3');
>>>>>>> origin/master
