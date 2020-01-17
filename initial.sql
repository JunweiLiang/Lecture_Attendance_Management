-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 01 月 13 日 19:44
-- 服务器版本: 5.6.12
-- PHP 版本: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- 表的结构 `C_choiceAnswer`
--

CREATE TABLE IF NOT EXISTS `C_choiceAnswer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qId` int(11) NOT NULL,
  `text` varchar(1024) NOT NULL,
  `isCorrect` int(1) NOT NULL DEFAULT '0',
  `createTime` datetime NOT NULL,
  `createBy` int(11) NOT NULL,
  `isDeleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- 表的结构 `C_choiceQuestion`
--

CREATE TABLE IF NOT EXISTS `C_choiceQuestion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `formId` int(11) NOT NULL,
  `text` varchar(2048) NOT NULL,
  `isSingleChoice` int(1) NOT NULL DEFAULT '0',
  `createTime` datetime NOT NULL,
  `createBy` int(11) NOT NULL,
  `isDeleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- 表的结构 `C_finalForm`
--

CREATE TABLE IF NOT EXISTS `C_finalForm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `formId` int(11) NOT NULL,
  `data` text NOT NULL,
  `createTime` datetime NOT NULL,
  `changeTime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;


-- --------------------------------------------------------

--
-- 表的结构 `C_form`
--

CREATE TABLE IF NOT EXISTS `C_form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(512) DEFAULT NULL,
  `shoutkey` varchar(128) DEFAULT NULL,
  `expiredTime` datetime DEFAULT NULL,
  `isActive` int(1) NOT NULL DEFAULT '0',
  `isReady` int(1) NOT NULL DEFAULT '0',
  `createTime` datetime NOT NULL,
  `createBy` int(11) NOT NULL,
  `picPath` varchar(1024) DEFAULT NULL,
  `isDeleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `shoutkey` (`shoutkey`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

INSERT INTO `C_form` (`id`, `name`, `shoutkey`, `expiredTime`, `isActive`, `isReady`, `createTime`, `createBy`, `picPath`, `isDeleted`) VALUES
(1, 'Lecture for today', 'peaches', '2017-01-13 12:17:00', 1, 1, '2017-01-10 23:41:31', 5082, NULL, 0);


-- --------------------------------------------------------

--
-- 表的结构 `C_submitData`
--

CREATE TABLE IF NOT EXISTS `C_submitData` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `formId` int(11) NOT NULL,
  `andrewId` varchar(128) NOT NULL,
  `name` varchar(1024) NOT NULL,
  `submitTime` datetime NOT NULL,
  `picData` varchar(2048) NOT NULL,
  `answers` varchar(2048) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- 表的结构 `T_catalog`
--

CREATE TABLE IF NOT EXISTS `T_catalog` (
  `catalogId` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `creatorId` int(8) NOT NULL,
  `createTime` datetime NOT NULL,
  `catalogTitle` varchar(255) NOT NULL,
  `catalogRank` int(8) NOT NULL COMMENT '同级中的顺序',
  `childNum` int(8) unsigned NOT NULL COMMENT '子栏目数',
  `hasText` int(1) unsigned NOT NULL COMMENT '该栏目下是否有文章',
  `isPublic` int(1) unsigned NOT NULL COMMENT '该栏目是外部栏目还是内部栏目',
  `catalogIntro` varchar(512) NOT NULL DEFAULT '',
  `hasWork` int(1) NOT NULL DEFAULT '0' COMMENT '是否赛区 catalog,',
  `zoneSchoolType` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`catalogId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

-- --------------------------------------------------------

--
-- 表的结构 `T_catalogStructure`
--

CREATE TABLE IF NOT EXISTS `T_catalogStructure` (
  `parentId` int(8) NOT NULL,
  `childId` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='栏目结构的表';

-- --------------------------------------------------------

--
-- 表的结构 `T_clientProfile`
--

CREATE TABLE IF NOT EXISTS `T_clientProfile` (
  `clientId` int(11) NOT NULL COMMENT '=userid',
  `email` varchar(256) DEFAULT '',
  `name` varchar(256) NOT NULL,
  PRIMARY KEY (`clientId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员账户信息表';

--
-- 转存表中的数据 `T_clientProfile`
--

INSERT INTO `T_clientProfile` (`clientId`, `email`, `name`) VALUES
(5082, '', 'ta_name');

-- --------------------------------------------------------

--
-- 表的结构 `T_log`
--

CREATE TABLE IF NOT EXISTS `T_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` int(2) NOT NULL,
  `userId` int(11) NOT NULL,
  `param` text,
  `time` datetime NOT NULL,
  `actionId` int(11) NOT NULL COMMENT '根据type,对应到该表的主键',
  `projectId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=602 ;

-- --------------------------------------------------------

--
-- 表的结构 `T_managerProfile`
--

CREATE TABLE IF NOT EXISTS `T_managerProfile` (
  `managerId` int(11) NOT NULL COMMENT '=userid',
  `email` varchar(256) DEFAULT '',
  `name` varchar(256) NOT NULL,
  PRIMARY KEY (`managerId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员账户信息表';

--
-- 转存表中的数据 `T_managerProfile`
--

INSERT INTO `T_managerProfile` (`managerId`, `email`, `name`) VALUES
(1, 'junweil@cs.cmu.edu', 'ta_name');

-- --------------------------------------------------------

--
-- 表的结构 `T_notice`
--

CREATE TABLE IF NOT EXISTS `T_notice` (
  `noticeId` int(11) NOT NULL AUTO_INCREMENT,
  `content` text NOT NULL,
  `noticeIntro` varchar(512) NOT NULL DEFAULT '' COMMENT '此字段只显示在编辑端，用于解释此notice的用处，在编辑的地方，可以新建通知，要手动添加该通知到对应的页面',
  PRIMARY KEY (`noticeId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='存储通知信息的表，在需要的页面中调用对应的id的通知noticeId,或者noticeWidget中的name映射' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- 表的结构 `T_user`
--

CREATE TABLE IF NOT EXISTS `T_user` (
  `userId` int(8) NOT NULL AUTO_INCREMENT,
  `userName` varchar(64) NOT NULL,
  `userPw` varchar(64) NOT NULL,
  `userRegTime` datetime NOT NULL,
  `isUM` int(1) unsigned NOT NULL DEFAULT '0' COMMENT 'UM---user manager',
  `nickName` varchar(256) NOT NULL DEFAULT '',
  `intro` varchar(512) NOT NULL DEFAULT '',
  `isSuper` int(1) NOT NULL DEFAULT '0' COMMENT '超级管理员－－栏目无关',
  `userLevel` int(4) NOT NULL DEFAULT '0' COMMENT '客户级别,2普通用户，3高级用户',
  PRIMARY KEY (`userId`),
  UNIQUE KEY `userName` (`userName`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户基本信息的表（以后加入密保字段）' AUTO_INCREMENT=5103 ;

--
-- 转存表中的数据 `T_user`
--

INSERT INTO `T_user` (`userId`, `userName`, `userPw`, `userRegTime`, `isUM`, `nickName`, `intro`, `isSuper`, `userLevel`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '2017-01-10 10:19:49', 1, 'adminliang', 'adminliang', 1, 0),
(5082, 'ta', 'e10adc3949ba59abbe56e057f20f883e', '2017-01-10 10:19:49', 0, 'TA Liang', '', 0, 3);

-- --------------------------------------------------------

--
-- 表的结构 `T_userStructure`
--

CREATE TABLE IF NOT EXISTS `T_userStructure` (
  `parentUserId` int(11) NOT NULL,
  `childUserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='管理员的树形辐射结构，“我能管理我创建的以及他们创建的所有管理员”';

--
-- 转存表中的数据 `T_userStructure`
--

INSERT INTO `T_userStructure` (`parentUserId`, `childUserId`) VALUES
(1, 5082);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
