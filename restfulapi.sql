/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : restfulapi

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-07-14 20:15:47
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `cart`
-- ----------------------------
DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `amount` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of cart
-- ----------------------------

-- ----------------------------
-- Table structure for `item`
-- ----------------------------
DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of item
-- ----------------------------
INSERT INTO `item` VALUES ('1', 'Buku', '1000');
INSERT INTO `item` VALUES ('2', 'Pulpen', '5000');
INSERT INTO `item` VALUES ('3', 'Pensil', '7000');
INSERT INTO `item` VALUES ('4', 'Spidol', '6000');

-- ----------------------------
-- Table structure for `stocktransaction`
-- ----------------------------
DROP TABLE IF EXISTS `stocktransaction`;
CREATE TABLE `stocktransaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `item_price` int(11) NOT NULL DEFAULT '0',
  `subtotal_price` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `IDX_39A98DD2126F525E` (`item_id`),
  CONSTRAINT `FK_39A98DD2126F525E` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of stocktransaction
-- ----------------------------
INSERT INTO `stocktransaction` VALUES ('3', '1', '10', '1', '0');
INSERT INTO `stocktransaction` VALUES ('23', '1', '1', '0', '0');
INSERT INTO `stocktransaction` VALUES ('31', '1', '2222', '1', '2222');
INSERT INTO `stocktransaction` VALUES ('32', '1', '33', '1', '33');
INSERT INTO `stocktransaction` VALUES ('33', '1', '333', '1', '333');
INSERT INTO `stocktransaction` VALUES ('34', '2', '33', '23', '759');
INSERT INTO `stocktransaction` VALUES ('35', '1', '22', '1', '22');
INSERT INTO `stocktransaction` VALUES ('36', '1', '333', '1', '333');
INSERT INTO `stocktransaction` VALUES ('37', '1', '36', '1', '36');
INSERT INTO `stocktransaction` VALUES ('38', '1', '38', '1', '38');
INSERT INTO `stocktransaction` VALUES ('39', '1', '333', '1', '333');
INSERT INTO `stocktransaction` VALUES ('40', '1', '333', '1', '333');
INSERT INTO `stocktransaction` VALUES ('41', '1', '3332', '1', '3332');

-- ----------------------------
-- Table structure for `transaction`
-- ----------------------------
DROP TABLE IF EXISTS `transaction`;
CREATE TABLE `transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `item_price` int(11) NOT NULL DEFAULT '0',
  `subtotal_price` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `IDX_723705D1126F525E` (`item_id`),
  CONSTRAINT `FK_723705D1126F525E` FOREIGN KEY (`item_id`) REFERENCES `item` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of transaction
-- ----------------------------
INSERT INTO `transaction` VALUES ('1', '1', '22', '2323', '2323');
INSERT INTO `transaction` VALUES ('2', '1', '2323', '1', '2323');
INSERT INTO `transaction` VALUES ('3', '1', '22', '1', '22');
INSERT INTO `transaction` VALUES ('4', '1', '0', '1', '0');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'User_1', 'taufik@aa.aa');
