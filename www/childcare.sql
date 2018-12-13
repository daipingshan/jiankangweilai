/*
Navicat MySQL Data Transfer

Source Server         : 47.96.78.2
Source Server Version : 50173
Source Host           : 47.96.78.2:3306
Source Database       : childcare

Target Server Type    : MYSQL
Target Server Version : 50173
File Encoding         : 65001

Date: 2018-07-04 13:58:56
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `admin`
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL DEFAULT '' COMMENT '账号名称',
  `password` char(32) NOT NULL DEFAULT '' COMMENT '登录密码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'admin', '3f47c8a76a2af609c466ed3b6214aa31');

-- ----------------------------
-- Table structure for `advert`
-- ----------------------------
DROP TABLE IF EXISTS `advert`;
CREATE TABLE `advert` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pic` varchar(255) NOT NULL DEFAULT '' COMMENT '广告图片地址',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '广告标题',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '广告类型 1->普通广告 2->url链接广告',
  `content` text COMMENT '广告内容',
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '广告添加时间',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1->启用 2->禁用',
  `sort` tinyint(1) unsigned NOT NULL DEFAULT '255' COMMENT '广告排序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of advert
-- ----------------------------
INSERT INTO `advert` VALUES ('2', 'http://pic.taodianke.com/2018/0702/5b39eaaf16159.jpg', '测试url链接广告', '2', 'http://www.baidu.com', '2018-07-02 17:04:56', '1', '255');

-- ----------------------------
-- Table structure for `baby_grow`
-- ----------------------------
DROP TABLE IF EXISTS `baby_grow`;
CREATE TABLE `baby_grow` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `baby_id` int(11) NOT NULL DEFAULT '0' COMMENT '宝宝id',
  `height` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '宝宝身高',
  `weight` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT '宝宝体重',
  `vaccine` varchar(255) NOT NULL DEFAULT '' COMMENT '已打过的疫苗',
  `nutrition_num` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '已吃过的营养包数',
  `add_time` date NOT NULL COMMENT '记录日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of baby_grow
-- ----------------------------

-- ----------------------------
-- Table structure for `caregiver_baby`
-- ----------------------------
DROP TABLE IF EXISTS `caregiver_baby`;
CREATE TABLE `caregiver_baby` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `trainer_id` int(11) NOT NULL DEFAULT '0' COMMENT '健康管理员id',
  `caregiver_name` varchar(255) NOT NULL DEFAULT '' COMMENT '养育人姓名',
  `caregiver_mobile` char(11) NOT NULL DEFAULT '' COMMENT '养育人手机',
  `caregiver_birthday` date NOT NULL DEFAULT '0000-00-00' COMMENT '养育人出生日期',
  `address` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  `relation` varchar(255) NOT NULL,
  `baby_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0->未出生 1->已出生',
  `baby_avatar` varchar(255) DEFAULT NULL,
  `baby_name` varchar(255) DEFAULT NULL,
  `baby_sex` tinyint(1) DEFAULT '0' COMMENT '0->孕中未知 1->男 2->女',
  `baby_birthday` date DEFAULT '0000-00-00' COMMENT '出生日期，未出生代表预产期',
  `baby_birthday_day` tinyint(1) DEFAULT '0' COMMENT '出生日期-日',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of caregiver_baby
-- ----------------------------
INSERT INTO `caregiver_baby` VALUES ('1', '1', '代山', '17509140688', '1991-03-13', '陕西省商洛市丹凤县凤凰小区', '爸爸', '1', 'http://pic.taodianke.com/2018/0703/5b3adfdb15042.jpg', '代梓俊', '1', '2018-08-18', '18');

-- ----------------------------
-- Table structure for `config`
-- ----------------------------
DROP TABLE IF EXISTS `config`;
CREATE TABLE `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of config
-- ----------------------------
INSERT INTO `config` VALUES ('1', 'a:2:{s:10:\"IMG_PREFIX\";s:25:\"http://pic.taodianke.com/\";s:3:\"OSS\";a:3:{s:6:\"key_id\";s:16:\"LTAI8ixfEzOHRVVm\";s:10:\"key_secret\";s:30:\"Z4Y6zwqp0cgmCAi4kIJENW7pqCS5ci\";s:6:\"bucket\";s:9:\"taodianke\";}}');

-- ----------------------------
-- Table structure for `course`
-- ----------------------------
DROP TABLE IF EXISTS `course`;
CREATE TABLE `course` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `course` varchar(255) NOT NULL DEFAULT '' COMMENT '课程名称',
  `suit_month` tinyint(1) NOT NULL DEFAULT '0' COMMENT '适合多大月份的宝宝',
  `require` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1->必修 2->选修',
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '课程添加日期',
  `update_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '课程更新日期',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of course
-- ----------------------------
INSERT INTO `course` VALUES ('1', '怀孕8个月，必修课程', '-1', '2', '2018-07-03 11:23:51', '2018-07-03 15:08:29');

-- ----------------------------
-- Table structure for `exam`
-- ----------------------------
DROP TABLE IF EXISTS `exam`;
CREATE TABLE `exam` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `caregiver_baby_id` int(11) NOT NULL DEFAULT '0' COMMENT '考试对象（养育人id）',
  `test_paper_id` int(11) NOT NULL DEFAULT '0' COMMENT '考试试卷id',
  `total_question_num` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '总题数',
  `total_score` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '总分数',
  `score` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '得分',
  `error_question` varchar(255) NOT NULL,
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '纪录时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of exam
-- ----------------------------

-- ----------------------------
-- Table structure for `feedback`
-- ----------------------------
DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `feedback_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '反馈类型',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '反馈详情',
  `pics` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `reply` varchar(255) DEFAULT '' COMMENT '回复',
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  `reply_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '回复时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of feedback
-- ----------------------------
INSERT INTO `feedback` VALUES ('1', '1', '5个月大的小孩半夜一直哭，哈哈哈哈哈哈哈哈哈哈', '[\"http:\\/\\/pic.taodianke.com\\/2018\\/0703\\/5b3b1c1544804.jpg\",\"http:\\/\\/pic.taodianke.com\\/2018\\/0703\\/5b3b20e857117.jpg\",\"http:\\/\\/pic.taodianke.com\\/2018\\/0703\\/5b3b20e948cef.jpg\"]', '你可以试试这个方法？？', '2018-07-04 11:00:00', '2018-07-04 11:28:13');

-- ----------------------------
-- Table structure for `knowledge`
-- ----------------------------
DROP TABLE IF EXISTS `knowledge`;
CREATE TABLE `knowledge` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL DEFAULT '0' COMMENT '课程id',
  `title` varchar(255) NOT NULL DEFAULT '' COMMENT '知识点标题',
  `desc` text COMMENT '知识点简介',
  `video` varchar(255) DEFAULT '' COMMENT '知识点视频',
  `pics` varchar(255) DEFAULT '' COMMENT '知识点图片',
  `add_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  `update_time` datetime DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of knowledge
-- ----------------------------
INSERT INTO `knowledge` VALUES ('1', '1', '怀孕8个月，必修课程', '怀孕8个月，必修课程', '', '[\"http:\\/\\/pic.taodianke.com\\/2018\\/0703\\/5b3b1c1544804.jpg\",\"http:\\/\\/pic.taodianke.com\\/2018\\/0703\\/5b3b20e857117.jpg\",\"http:\\/\\/pic.taodianke.com\\/2018\\/0703\\/5b3b20e948cef.jpg\"]', '2018-07-03 14:48:40', '2018-07-03 15:08:29');

-- ----------------------------
-- Table structure for `test_paper`
-- ----------------------------
DROP TABLE IF EXISTS `test_paper`;
CREATE TABLE `test_paper` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL DEFAULT '0' COMMENT '课程id',
  `test_paper_name` varchar(255) NOT NULL DEFAULT '' COMMENT '试卷名称',
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of test_paper
-- ----------------------------
INSERT INTO `test_paper` VALUES ('1', '1', '怀孕8个月，必修课程之一', '2018-07-03 15:53:16', '2018-07-04 10:33:48');

-- ----------------------------
-- Table structure for `test_question`
-- ----------------------------
DROP TABLE IF EXISTS `test_question`;
CREATE TABLE `test_question` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `test_paper_id` int(11) NOT NULL DEFAULT '0' COMMENT '试卷id',
  `course_id` int(11) NOT NULL DEFAULT '0' COMMENT '课程id',
  `knowledge_id` int(11) NOT NULL DEFAULT '0' COMMENT '知识点id',
  `sn` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '试题序号',
  `score` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '分值',
  `select_type` enum('single','mutiple') NOT NULL DEFAULT 'single' COMMENT 'single->单选 mutiple->多选',
  `question` varchar(255) NOT NULL,
  `answer_option` text NOT NULL COMMENT '答题选项',
  `answer` varchar(255) NOT NULL DEFAULT '' COMMENT '答案',
  `explain` varchar(255) NOT NULL DEFAULT '' COMMENT '解释说明',
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  `update_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of test_question
-- ----------------------------
INSERT INTO `test_question` VALUES ('1', '1', '1', '1', '0', '5', 'single', '1+1等于几', '[{\"type\":\"pic\",\"value\":\"A\",\"content\":\"http:\\/\\/pic.taodianke.com\\/2018\\/0704\\/5b3c32002c7f8.jpg\"},{\"type\":\"text\",\"value\":\"B\",\"content\":\"2\"},{\"type\":\"pic\",\"value\":\"C\",\"content\":\"http:\\/\\/pic.taodianke.com\\/2018\\/0704\\/5b3c320873569.jpg\"},{\"type\":\"text\",\"value\":\"D\",\"content\":\"4\"}]', 'B', '1+1=2是正确答案', '2018-07-04 10:04:51', '2018-07-04 10:33:48');

-- ----------------------------
-- Table structure for `train`
-- ----------------------------
DROP TABLE IF EXISTS `train`;
CREATE TABLE `train` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `trainer_id` int(11) NOT NULL DEFAULT '0' COMMENT '健康管理员',
  `caregiver_baby_id` int(11) NOT NULL DEFAULT '0' COMMENT '养育人',
  `training_people_name` varchar(255) NOT NULL DEFAULT '' COMMENT '实际被培训人',
  `baby_relation` varchar(255) NOT NULL DEFAULT '' COMMENT '被培训人和宝宝的关系',
  `training_feedback` text NOT NULL,
  `test_score` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '课后测试得分',
  `pic` varchar(255) NOT NULL DEFAULT '' COMMENT '离户照片地址',
  `start_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '入户开始培训时间',
  `finished_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '结束培训时间',
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '保存记录时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of train
-- ----------------------------

-- ----------------------------
-- Table structure for `trainer`
-- ----------------------------
DROP TABLE IF EXISTS `trainer`;
CREATE TABLE `trainer` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号码',
  `passwrod` char(32) NOT NULL DEFAULT '' COMMENT '密码',
  `real_name` varchar(255) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `age` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '年龄',
  `sex` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0->保密 1->男 2->女',
  `avatar` varchar(255) NOT NULL,
  `token` char(32) NOT NULL DEFAULT '' COMMENT '用户登陆token',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '1->启用 2->禁用',
  `add_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile` (`mobile`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of trainer
-- ----------------------------
INSERT INTO `trainer` VALUES ('1', '17509140688', '', '代平山', '28', '1', 'http://pic.taodianke.com/2018/0702/5b39f7a3a1da1.jpg', 'aace757989573a6ab8307cda2d2a371f', '1', '2018-07-02 18:00:08');
