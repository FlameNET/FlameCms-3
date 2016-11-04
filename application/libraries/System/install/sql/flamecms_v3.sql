/*
Navicat MySQL Data Transfer

Source Server         : splashframe
Source Server Version : 100027
Source Host           : splashframe.tk:3306
Source Database       : flamecms_v3

Target Server Type    : MYSQL
Target Server Version : 100027
File Encoding         : 65001

Date: 2016-11-04 22:34:16
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for v3_log_login
-- ----------------------------
DROP TABLE IF EXISTS `v3_log_login`;
CREATE TABLE `v3_log_login` (
  `username` longtext NOT NULL,
  `id` int(99) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `ip` longtext NOT NULL,
  `useragent` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of v3_log_login
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

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
INSERT INTO `v3_settings` VALUES ('00000000015', 'cms_enable_alpha_features', 'true', 'b');
INSERT INTO `v3_settings` VALUES ('00000000016', 'cms_enable_beta_features', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000017', 'cms_enable_charlie_features', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000018', 'cms_enable_release_features', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000019', 'cms_quick_notifications', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000020', 'cms_ajax_security', 'true', 'b');
INSERT INTO `v3_settings` VALUES ('00000000021', 'cms_plugins', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000022', 'cms_themes', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000023', 'cms_uploads', 'true', 'b');
INSERT INTO `v3_settings` VALUES ('00000000024', 'cms_hide_flame_credits', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000025', 'cms_custom_copyright', '{\'value\':false,\'msg\':\'\'}', 'j');
INSERT INTO `v3_settings` VALUES ('00000000026', 'cms_advanced_paypal', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000027', 'cms_advanced_enablement_key', '{\'value\':false,\'key\':\'\'}', 'j');
INSERT INTO `v3_settings` VALUES ('00000000028', 'cms_maintenance_mode', '{\'value\':false,\'msg\':\'\'}', 'j');
INSERT INTO `v3_settings` VALUES ('00000000029', 'cms_enable_wysiwyg', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000030', 'cms_utc', 'UTC+0', 's');
INSERT INTO `v3_settings` VALUES ('00000000031', 'cms_root_change_password', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000032', 'cms_enable_menu_managment', 'true', 'b');
INSERT INTO `v3_settings` VALUES ('00000000033', 'cms_enable_ceo', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000034', 'cms_enable_updates', 'true', 'b');
INSERT INTO `v3_settings` VALUES ('00000000035', 'cms_support_verification_mode', 'checksum', 's');
INSERT INTO `v3_settings` VALUES ('00000000036', 'cms_paid_support', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000037', 'cms_geoip_tracking', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000038', 'cms_log_user_login', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000039', 'cms_ban_ip_for', '15m', 's');
INSERT INTO `v3_settings` VALUES ('00000000040', 'cms_facebook_login', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000041', 'cms_splashframe_login', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000042', 'cms_google_login', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000043', 'cms_enable_app_support', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000044', 'cms_log_user_actions', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000045', 'cms_log_update_checks', 'true', 'b');
INSERT INTO `v3_settings` VALUES ('00000000046', 'cms_favion', '', 's');
INSERT INTO `v3_settings` VALUES ('00000000047', 'cms_xls_export_enable', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000048', 'cms_rss_enable', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000049', 'cms_pps_type', '3', 's');
INSERT INTO `v3_settings` VALUES ('00000000050', 'cms_subdomain_per_language', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000053', 'cms_enable_localstorage_key', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000054', 'cms_user_session_tracking', 'false', 'b');
INSERT INTO `v3_settings` VALUES ('00000000055', 'cms_platform_tracking', 'true', 'b');
INSERT INTO `v3_settings` VALUES ('00000000056', 'cms_install_id', '1', 'i');

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
  `role_gm` tinyint(1) NOT NULL,
  `role_visible_name` text NOT NULL,
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

-- ----------------------------
-- Table structure for v3_user_data
-- ----------------------------
DROP TABLE IF EXISTS `v3_user_data`;
CREATE TABLE `v3_user_data` (
  `UUID` varchar(99) NOT NULL,
  `fname` text NOT NULL,
  `lname` text NOT NULL,
  `email` text NOT NULL,
  `permission_level` int(11) unsigned NOT NULL,
  `permission_clearance` text NOT NULL,
  `about_text` text NOT NULL,
  `job` text NOT NULL,
  `contact_info` text NOT NULL,
  PRIMARY KEY (`UUID`),
  UNIQUE KEY `UUID` (`UUID`) USING BTREE,
  KEY `permission_level` (`permission_level`),
  CONSTRAINT `v3_user_data_ibfk_1` FOREIGN KEY (`UUID`) REFERENCES `v3_user_data` (`UUID`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `v3_user_data_ibfk_2` FOREIGN KEY (`permission_level`) REFERENCES `v3_system_roles` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of v3_user_data
-- ----------------------------

-- ----------------------------
-- Table structure for v3_user_login
-- ----------------------------
DROP TABLE IF EXISTS `v3_user_login`;
CREATE TABLE `v3_user_login` (
  `UUID` varchar(99) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `recovery_key` text NOT NULL,
  `activation` text NOT NULL,
  `enforcement` text NOT NULL,
  `ek01` varchar(255) NOT NULL,
  `ek02` varchar(255) NOT NULL,
  `ek03` varchar(255) NOT NULL,
  `ek04` varchar(255) NOT NULL,
  `ek05` varchar(255) NOT NULL,
  `ek06` varchar(255) NOT NULL,
  `ek07` varchar(255) NOT NULL,
  `ek08` varchar(255) NOT NULL,
  `ek09` varchar(255) NOT NULL,
  `ek10` varchar(255) NOT NULL,
  PRIMARY KEY (`UUID`),
  UNIQUE KEY `UUID` (`UUID`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of v3_user_login
-- ----------------------------

-- ----------------------------
-- Table structure for v3_user_messages
-- ----------------------------
DROP TABLE IF EXISTS `v3_user_messages`;
CREATE TABLE `v3_user_messages` (
  `UUID_sender` varchar(99) NOT NULL,
  `UUID_receiver` varchar(99) NOT NULL,
  `message_id` int(99) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `message_content` longtext NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`UUID_sender`,`UUID_receiver`,`message_id`),
  UNIQUE KEY `UUID_sender` (`UUID_sender`,`UUID_receiver`,`message_id`) USING BTREE,
  UNIQUE KEY `message_id` (`message_id`) USING BTREE,
  KEY `UUID_receiver` (`UUID_receiver`),
  CONSTRAINT `v3_user_messages_ibfk_1` FOREIGN KEY (`UUID_sender`) REFERENCES `v3_user_login` (`UUID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `v3_user_messages_ibfk_2` FOREIGN KEY (`UUID_receiver`) REFERENCES `v3_user_login` (`UUID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of v3_user_messages
-- ----------------------------
SET FOREIGN_KEY_CHECKS=1;
