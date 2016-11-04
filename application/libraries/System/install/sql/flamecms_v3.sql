/*
Navicat MySQL Data Transfer

Source Server         : splashframe
Source Server Version : 100027
Source Host           : splashframe.tk:3306
Source Database       : flamecms_v3

Target Server Type    : MYSQL
Target Server Version : 100027
File Encoding         : 65001

Date: 2016-11-04 11:06:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for v3_settings
-- ----------------------------
DROP TABLE IF EXISTS `v3_settings`;
CREATE TABLE `v3_settings` (
  `setting_id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `setting_ind` varchar(255) NOT NULL,
  `setting_value` varchar(255) NOT NULL,
  `setting_type` varchar(1) NOT NULL,
  PRIMARY KEY (`setting_id`,`setting_ind`),
  UNIQUE KEY `setting_ind` (`setting_ind`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of v3_settings
-- ----------------------------
INSERT INTO `v3_settings` VALUES ('00000000001', 'cms_sitename', 'FlameCMS Test site', 's');
INSERT INTO `v3_settings` VALUES ('00000000002', 'cms_https', 'true', 'b');
INSERT INTO `v3_settings` VALUES ('00000000003', 'cms_theme', 'default', 's');
INSERT INTO `v3_settings` VALUES ('00000000004', 'cms_lang', 'en', 's');
INSERT INTO `v3_settings` VALUES ('00000000005', 'cms_multilang', 'true', 'b');
INSERT INTO `v3_settings` VALUES ('00000000006', 'cms_languages', '{\'0\':\"pt\",\'1\':\"en\",\'2\':\"es\"}', 'j');
INSERT INTO `v3_settings` VALUES ('00000000007', 'cms_force_https', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000008', 'cms_login_force_https', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000009', '', '', '');
INSERT INTO `v3_settings` VALUES ('00000000010', 'cms_baseurl', 'v3.flamecms.tk', 's');
INSERT INTO `v3_settings` VALUES ('00000000011', 'cms_alpha_security', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000012', 'cms_version', '0.0.3-alpha', 'v');
INSERT INTO `v3_settings` VALUES ('00000000013', 'cms_version_type', 'pre_alpha', 's');
INSERT INTO `v3_settings` VALUES ('00000000014', 'cms_update_server', 'https://api.github.com/repos/FlameNET/FlameCms-3/releases', 's');

-- ----------------------------
-- Table structure for v3_system_perms
-- ----------------------------
DROP TABLE IF EXISTS `v3_system_perms`;
CREATE TABLE `v3_system_perms` (
  `perm_system_id` varchar(255) NOT NULL,
  `perm_id` int(11) NOT NULL,
  `perm_description` varchar(255) NOT NULL,
  PRIMARY KEY (`perm_system_id`,`perm_id`),
  UNIQUE KEY `perm_system_id` (`perm_system_id`,`perm_id`) USING BTREE,
  KEY `perm_id` (`perm_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of v3_system_perms
-- ----------------------------

-- ----------------------------
-- Table structure for v3_system_roles
-- ----------------------------
DROP TABLE IF EXISTS `v3_system_roles`;
CREATE TABLE `v3_system_roles` (
  `role_id` int(11) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `role_name` text NOT NULL,
  `role_perms_id` int(11) unsigned zerofill NOT NULL,
  `role_gm` tinyint(1) DEFAULT NULL,
  `role_visible_name` text,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of v3_system_roles
-- ----------------------------
INSERT INTO `v3_system_roles` VALUES ('00000000000', 'Banned', '00000000000', '0', '[BANNED]');
INSERT INTO `v3_system_roles` VALUES ('00000000001', 'Player', '00000000000', '0', '[player]');
INSERT INTO `v3_system_roles` VALUES ('00000000002', 'Moderator', '00000000000', '0', '[MOD]');
INSERT INTO `v3_system_roles` VALUES ('00000000003', 'Game Master', '00000000000', '1', '[GM]');
INSERT INTO `v3_system_roles` VALUES ('00000000004', 'Forum Moderator', '00000000000', '0', '[FORUM MOD]');
INSERT INTO `v3_system_roles` VALUES ('00000000005', 'Forum Game Master', '00000000000', '0', '[FORUM GM]');
INSERT INTO `v3_system_roles` VALUES ('00000000006', 'Hidden Game Master', '00000000000', '1', '[player]');
INSERT INTO `v3_system_roles` VALUES ('00000000007', 'Administrator', '00000000000', '2', '[ADMIN]');
INSERT INTO `v3_system_roles` VALUES ('00000000008', 'Forum Administrator', '00000000000', '1', '[FORUM ADMIN]');
INSERT INTO `v3_system_roles` VALUES ('00000000009', 'Hidden Administrator', '00000000000', '2', '[player]');
INSERT INTO `v3_system_roles` VALUES ('00000000010', 'Hidden Owner', '00000000000', '3', '[player]');
INSERT INTO `v3_system_roles` VALUES ('00000000011', 'Owner', '00000000000', '3', '[OWNER]');
INSERT INTO `v3_system_roles` VALUES ('00000000012', 'Hidden ROOT', '00000000000', '3', '[Player]');
SET FOREIGN_KEY_CHECKS=1;
