/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50162
Source Host           : localhost:3306
Source Database       : tracker

Target Server Type    : MYSQL
Target Server Version : 50162
File Encoding         : 65001

Date: 2014-11-19 22:36:01
*/

SET FOREIGN_KEY_CHECKS=0;

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of groups
-- ----------------------------
INSERT INTO `groups` VALUES ('1', 'Validating', 'validating', '0', '0');
INSERT INTO `groups` VALUES ('2', 'Guests', 'guests', '0', '0');
INSERT INTO `groups` VALUES ('3', 'Members', 'members', '0', '0');
INSERT INTO `groups` VALUES ('4', 'Administrators', 'administrators', '1', '1');
INSERT INTO `groups` VALUES ('5', 'Banned', 'banned', '0', '0');
INSERT INTO `groups` VALUES ('6', 'Moderators', 'moderators', '0', '1');
