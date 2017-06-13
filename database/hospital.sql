-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-06-13 10:42:30
-- 服务器版本： 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `hospital`
--

-- --------------------------------------------------------

--
-- 表的结构 `appointment`
--

CREATE TABLE IF NOT EXISTS `appointment` (
  `DCT_NO` varchar(20) NOT NULL,
  `PTT_NO` varchar(20) NOT NULL,
  `APT_DATE` datetime NOT NULL,
  `APT_STATE` smallint(6) NOT NULL,
  PRIMARY KEY (`DCT_NO`,`PTT_NO`,`APT_DATE`),
  KEY `DCT_NO` (`DCT_NO`),
  KEY `PTT_NO` (`PTT_NO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `appointment`
--

INSERT INTO `appointment` (`DCT_NO`, `PTT_NO`, `APT_DATE`, `APT_STATE`) VALUES
('0', '0', '2017-06-13 09:13:15', 2),
('0', '0', '2017-06-13 09:35:33', 2),
('1', '0', '2017-06-13 10:13:34', 4),
('1', '0', '2017-06-13 10:26:03', 4);

-- --------------------------------------------------------

--
-- 表的结构 `checklist`
--

CREATE TABLE IF NOT EXISTS `checklist` (
  `CL_NO` varchar(20) NOT NULL,
  `CL_NAME` varchar(20) CHARACTER SET gbk NOT NULL,
  `CL_DATE` datetime NOT NULL,
  `CL_STATE` smallint(6) NOT NULL,
  `RESULT` varchar(100) CHARACTER SET gbk DEFAULT NULL,
  `CL_DCT` varchar(20) DEFAULT NULL,
  `DCT_NO` varchar(20) NOT NULL,
  `DEPT_NAME` varchar(20) CHARACTER SET gbk NOT NULL,
  PRIMARY KEY (`CL_NO`),
  KEY `CL_DCT` (`CL_DCT`),
  KEY `DCT_NO` (`DCT_NO`),
  KEY `DEPT_NAME` (`DEPT_NAME`),
  KEY `CL_NAME` (`CL_NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `checklist`
--

INSERT INTO `checklist` (`CL_NO`, `CL_NAME`, `CL_DATE`, `CL_STATE`, `RESULT`, `CL_DCT`, `DCT_NO`, `DEPT_NAME`) VALUES
('2017-06-1309:13:580', '血检', '2017-06-13 09:13:58', 2, '感冒轻微', '2', '0', '血检处'),
('2017-06-1309:20:310', '血检', '2017-06-13 09:20:31', 2, '感冒轻微', '2', '0', '血检处'),
('2017-06-1310:29:310', '血检', '2017-06-13 10:29:31', 2, '感冒轻微', '2', '0', '血检处');

-- --------------------------------------------------------

--
-- 表的结构 `checkprogram`
--

CREATE TABLE IF NOT EXISTS `checkprogram` (
  `CK_NO` varchar(20) NOT NULL,
  `CK_NAME` varchar(20) NOT NULL,
  `CK_PRICE` int(11) NOT NULL,
  PRIMARY KEY (`CK_NO`),
  UNIQUE KEY `CK_NAME` (`CK_NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk;

--
-- 转存表中的数据 `checkprogram`
--

INSERT INTO `checkprogram` (`CK_NO`, `CK_NAME`, `CK_PRICE`) VALUES
('0', '血检', 50);

-- --------------------------------------------------------

--
-- 表的结构 `dept`
--

CREATE TABLE IF NOT EXISTS `dept` (
  `DEPT_NO` varchar(20) NOT NULL,
  `DEPT_NAME` varchar(20) CHARACTER SET gbk NOT NULL,
  PRIMARY KEY (`DEPT_NO`),
  UNIQUE KEY `DEPT_NAME` (`DEPT_NAME`),
  UNIQUE KEY `DEPT_NAME_2` (`DEPT_NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `dept`
--

INSERT INTO `dept` (`DEPT_NO`, `DEPT_NAME`) VALUES
('6', '放射科'),
('0', '内科'),
('3', '收费处'),
('1', '外科'),
('5', '血检处'),
('4', '药房'),
('100', '院长室'),
('2', '住院部');

-- --------------------------------------------------------

--
-- 表的结构 `diagnosis`
--

CREATE TABLE IF NOT EXISTS `diagnosis` (
  `DIAG_NO` varchar(40) NOT NULL,
  `DIAG_DATE` datetime NOT NULL,
  `DIAG_NAME` varchar(100) CHARACTER SET gbk NOT NULL,
  `DIAG_DESC` varchar(100) CHARACTER SET gbk NOT NULL,
  `DL_NO` varchar(20) DEFAULT NULL,
  `CL_NO` varchar(20) DEFAULT NULL,
  `HL_NO` varchar(20) DEFAULT NULL,
  `DCT_NO` varchar(20) NOT NULL,
  `PTT_NO` varchar(20) NOT NULL,
  PRIMARY KEY (`DIAG_NO`),
  KEY `DL_NO` (`DL_NO`),
  KEY `CL_NO` (`CL_NO`),
  KEY `HL_NO` (`HL_NO`),
  KEY `DCT_NO` (`DCT_NO`),
  KEY `PTT_NO` (`PTT_NO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `diagnosis`
--

INSERT INTO `diagnosis` (`DIAG_NO`, `DIAG_DATE`, `DIAG_NAME`, `DIAG_DESC`, `DL_NO`, `CL_NO`, `HL_NO`, `DCT_NO`, `PTT_NO`) VALUES
('2017-06-1309:13:580', '2017-06-13 09:13:58', '感冒', '轻微', '2017-06-1309:13:580', '2017-06-1309:13:580', '2017-06-1309:13:5886', '0', '0'),
('2017-06-1309:20:310', '2017-06-13 09:20:31', '感冒', '', NULL, '2017-06-1309:20:310', NULL, '0', '0'),
('2017-06-1310:29:310', '2017-06-13 10:29:31', '感冒', '轻微', '2017-06-1310:29:310', '2017-06-1310:29:310', '2017-06-1310:29:3186', '0', '0');

-- --------------------------------------------------------

--
-- 表的结构 `doctor`
--

CREATE TABLE IF NOT EXISTS `doctor` (
  `DCT_NO` varchar(20) NOT NULL,
  `DCT_NAME` varchar(20) CHARACTER SET gbk NOT NULL,
  `DCT_PSW` varchar(20) DEFAULT NULL,
  `DCT_SEX` varchar(5) CHARACTER SET gbk NOT NULL,
  `DCT_BIRTH` datetime NOT NULL,
  `DCT_TITLE` varchar(20) CHARACTER SET gbk NOT NULL,
  `DCT_TEL` varchar(20) NOT NULL,
  `DEPT_NAME` varchar(20) CHARACTER SET gbk NOT NULL,
  `DCT_ON` smallint(6) NOT NULL,
  PRIMARY KEY (`DCT_NO`),
  KEY `DEPT_NAME` (`DEPT_NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `doctor`
--

INSERT INTO `doctor` (`DCT_NO`, `DCT_NAME`, `DCT_PSW`, `DCT_SEX`, `DCT_BIRTH`, `DCT_TITLE`, `DCT_TEL`, `DEPT_NAME`, `DCT_ON`) VALUES
('0', '曹操', NULL, '男', '1996-01-01 00:00:00', '专家', '11122233344', '内科', 1),
('1', '刘备', NULL, '男', '1996-06-01 00:00:00', '专家', '12111111111', '外科', 1),
('2', '宋江', NULL, '男', '2017-06-01 00:00:00', '检查医师', '11122223333', '血检处', 1),
('3', '孙权', NULL, '女', '1996-06-02 00:00:00', '护士', '11233333333', '住院部', 1);

-- --------------------------------------------------------

--
-- 表的结构 `drug`
--

CREATE TABLE IF NOT EXISTS `drug` (
  `DRUG_NO` varchar(20) NOT NULL,
  `DRUG_NAME` varchar(20) CHARACTER SET gbk NOT NULL,
  `DRUG_PRO_DATE` datetime NOT NULL,
  `DRUG_EXP_DATE` datetime NOT NULL,
  `DRUG_INPRICE` int(11) NOT NULL,
  `DRUG_PRICE` int(11) NOT NULL,
  `DRUG_STORE` int(11) NOT NULL,
  `DRUG_INTIME` datetime NOT NULL,
  PRIMARY KEY (`DRUG_NO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `drug`
--

INSERT INTO `drug` (`DRUG_NO`, `DRUG_NAME`, `DRUG_PRO_DATE`, `DRUG_EXP_DATE`, `DRUG_INPRICE`, `DRUG_PRICE`, `DRUG_STORE`, `DRUG_INTIME`) VALUES
('0', '新康泰克', '2017-06-01 00:00:00', '2019-12-10 00:00:00', 10, 20, 93, '2017-06-02 00:00:00'),
('1', '板蓝根', '2017-06-01 00:00:00', '2017-06-10 00:00:00', 10, 20, 0, '2017-06-05 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `druglist`
--

CREATE TABLE IF NOT EXISTS `druglist` (
  `DL_NO` varchar(20) NOT NULL,
  `DL_STATE` smallint(6) NOT NULL,
  `DL_DATE` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `STF_NO` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`DL_NO`),
  KEY `STF_NO` (`STF_NO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `druglist`
--

INSERT INTO `druglist` (`DL_NO`, `DL_STATE`, `DL_DATE`, `STF_NO`) VALUES
('2017-06-1309:13:580', 2, '2017-06-13 09:13:58', '4'),
('2017-06-1310:29:310', 2, '2017-06-13 10:29:31', '4');

-- --------------------------------------------------------

--
-- 表的结构 `drugmanage`
--

CREATE TABLE IF NOT EXISTS `drugmanage` (
  `STF_NO` varchar(20) NOT NULL,
  `DRUG_NO` varchar(20) NOT NULL,
  `IS_IN` smallint(6) NOT NULL,
  `TIME` datetime NOT NULL,
  `AMOUNT` int(11) NOT NULL,
  PRIMARY KEY (`STF_NO`,`TIME`),
  KEY `DRUG_NO` (`DRUG_NO`),
  KEY `STF_NO` (`STF_NO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- 表的结构 `hospitallist`
--

CREATE TABLE IF NOT EXISTS `hospitallist` (
  `HL_NO` varchar(20) NOT NULL,
  `HL_DATE` datetime NOT NULL,
  `DCT_NO` varchar(20) DEFAULT NULL,
  `IN_TIME` datetime DEFAULT NULL,
  `OUT_TIME` datetime DEFAULT NULL,
  `HL_STATE` smallint(6) NOT NULL,
  `WD_NO` varchar(20) NOT NULL,
  PRIMARY KEY (`HL_NO`),
  KEY `WD_NO` (`WD_NO`),
  KEY `WD_NO_2` (`WD_NO`),
  KEY `DCT_NO` (`DCT_NO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `hospitallist`
--

INSERT INTO `hospitallist` (`HL_NO`, `HL_DATE`, `DCT_NO`, `IN_TIME`, `OUT_TIME`, `HL_STATE`, `WD_NO`) VALUES
('0', '2017-06-02 00:00:00', '3', '2017-06-12 04:23:39', NULL, 2, '860101'),
('2', '2017-06-01 00:00:00', '3', '2017-06-01 00:00:00', '2017-06-13 00:10:34', 3, '860101'),
('2017-06-1308:39:3086', '2017-06-13 08:39:30', NULL, NULL, NULL, 1, '860101'),
('2017-06-1309:13:5886', '2017-06-13 09:13:58', '3', '2017-06-13 09:17:41', '2017-06-13 09:17:55', 3, '860101'),
('2017-06-1310:29:3186', '2017-06-13 10:29:31', '3', '2017-06-13 10:35:27', '2017-06-13 10:35:47', 3, '860101');

-- --------------------------------------------------------

--
-- 表的结构 `listdrug`
--

CREATE TABLE IF NOT EXISTS `listdrug` (
  `DL_NO` varchar(20) NOT NULL,
  `DRUG_NO` varchar(20) NOT NULL,
  `DRUG_USAGE` varchar(100) CHARACTER SET gbk NOT NULL,
  `DRUG_AMOUNT` int(11) NOT NULL,
  PRIMARY KEY (`DL_NO`,`DRUG_NO`),
  KEY `DRUG_NO` (`DRUG_NO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `listdrug`
--

INSERT INTO `listdrug` (`DL_NO`, `DRUG_NO`, `DRUG_USAGE`, `DRUG_AMOUNT`) VALUES
('2017-06-1309:13:580', '0', '一天2次', 2),
('2017-06-1309:13:580', '1', '一天3次', 1),
('2017-06-1310:29:310', '0', '一天3次', 3),
('2017-06-1310:29:310', '1', '一天2次', 2);

-- --------------------------------------------------------

--
-- 表的结构 `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `PTT_NO` varchar(20) NOT NULL,
  `PTT_NAME` varchar(20) CHARACTER SET gbk NOT NULL,
  `PTT_ADDR` varchar(100) CHARACTER SET gbk NOT NULL,
  `PTT_TEL` varchar(20) NOT NULL,
  `PTT_SEX` varchar(5) CHARACTER SET gbk NOT NULL,
  `PTT_PWD` varchar(20) NOT NULL,
  `PTT_BIRTH` datetime NOT NULL,
  PRIMARY KEY (`PTT_NO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `patient`
--

INSERT INTO `patient` (`PTT_NO`, `PTT_NAME`, `PTT_ADDR`, `PTT_TEL`, `PTT_SEX`, `PTT_PWD`, `PTT_BIRTH`) VALUES
('0', '胡适', '武汉', '12212222222', '男', '1', '2017-06-01 00:00:00'),
('1', '朱德', '南京', '11123456789', '男', '1', '1996-06-10 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `PTT_NO` varchar(20) NOT NULL,
  `STF_NO` varchar(20) NOT NULL,
  `PAY_PRICE` int(11) NOT NULL,
  `PAY_DATE` datetime NOT NULL,
  `PAY_FOR` smallint(6) NOT NULL,
  `LIST_NO` varchar(20) NOT NULL,
  PRIMARY KEY (`PTT_NO`,`PAY_DATE`,`PAY_FOR`),
  KEY `PTT_NO` (`PTT_NO`),
  KEY `STF_NO` (`STF_NO`),
  KEY `LIST_NO` (`LIST_NO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `payment`
--

INSERT INTO `payment` (`PTT_NO`, `STF_NO`, `PAY_PRICE`, `PAY_DATE`, `PAY_FOR`, `LIST_NO`) VALUES
('0', '3', 50, '2017-06-13 09:21:11', 0, '2017-06-1309:20:310'),
('0', '2', 50, '2017-06-13 10:32:22', 0, '2017-06-1310:29:310'),
('0', '2', 100, '2017-06-13 10:32:22', 1, '2017-06-1310:29:310'),
('0', '2', 100, '2017-06-13 10:32:22', 2, '2017-06-1310:29:3186');

-- --------------------------------------------------------

--
-- 表的结构 `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `STF_NO` varchar(20) NOT NULL,
  `STF_ON` smallint(6) NOT NULL,
  `STF_PWD` varchar(20) DEFAULT NULL,
  `STF_NAME` varchar(20) CHARACTER SET gbk NOT NULL,
  `STF_SEX` varchar(5) CHARACTER SET gbk NOT NULL,
  `STF_BIRTH` datetime NOT NULL,
  `STF_TITLE` varchar(20) CHARACTER SET gbk NOT NULL,
  `STF_TEL` varchar(20) NOT NULL,
  `DEPT_NAME` varchar(20) CHARACTER SET gbk NOT NULL,
  PRIMARY KEY (`STF_NO`),
  KEY `DEPT_NAME` (`DEPT_NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `staff`
--

INSERT INTO `staff` (`STF_NO`, `STF_ON`, `STF_PWD`, `STF_NAME`, `STF_SEX`, `STF_BIRTH`, `STF_TITLE`, `STF_TEL`, `DEPT_NAME`) VALUES
('0', 1, 'root', '皇子', '男', '2012-06-19 00:00:00', '海贼王', '15922222222', '院长室'),
('1', 1, NULL, '关羽', '女', '2017-06-01 00:00:00', '检查员', '1', '内科'),
('2', 1, NULL, '赵云', '女', '2017-06-02 00:00:00', '挂号员', '11122223333', '收费处'),
('3', 1, NULL, '张飞', '女', '2017-06-03 00:00:00', '缴费员', '11122223333', '收费处'),
('4', 1, NULL, '吕蒙', '女', '2017-06-08 00:00:00', '药剂师', '22211114444', '药房');

-- --------------------------------------------------------

--
-- 表的结构 `ward`
--

CREATE TABLE IF NOT EXISTS `ward` (
  `WD_NO` varchar(20) NOT NULL,
  `WD_BLD` smallint(6) NOT NULL,
  `WD_FLOOR` smallint(6) NOT NULL,
  `WD_ROOM` smallint(6) NOT NULL,
  `WD_BED` smallint(6) NOT NULL,
  `WD_STATE` smallint(6) NOT NULL,
  PRIMARY KEY (`WD_NO`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `ward`
--

INSERT INTO `ward` (`WD_NO`, `WD_BLD`, `WD_FLOOR`, `WD_ROOM`, `WD_BED`, `WD_STATE`) VALUES
('860101', 8, 6, 1, 1, 0);

--
-- 限制导出的表
--

--
-- 限制表 `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `appointment_ibfk_1` FOREIGN KEY (`DCT_NO`) REFERENCES `doctor` (`DCT_NO`),
  ADD CONSTRAINT `appointment_ibfk_2` FOREIGN KEY (`PTT_NO`) REFERENCES `patient` (`PTT_NO`);

--
-- 限制表 `checklist`
--
ALTER TABLE `checklist`
  ADD CONSTRAINT `checklist_ibfk_1` FOREIGN KEY (`CL_DCT`) REFERENCES `doctor` (`DCT_NO`),
  ADD CONSTRAINT `checklist_ibfk_2` FOREIGN KEY (`DCT_NO`) REFERENCES `doctor` (`DCT_NO`),
  ADD CONSTRAINT `checklist_ibfk_3` FOREIGN KEY (`DEPT_NAME`) REFERENCES `dept` (`DEPT_NAME`),
  ADD CONSTRAINT `checklist_ibfk_4` FOREIGN KEY (`CL_NAME`) REFERENCES `checkprogram` (`CK_NAME`);

--
-- 限制表 `diagnosis`
--
ALTER TABLE `diagnosis`
  ADD CONSTRAINT `diagnosis_ibfk_1` FOREIGN KEY (`DL_NO`) REFERENCES `druglist` (`DL_NO`),
  ADD CONSTRAINT `diagnosis_ibfk_2` FOREIGN KEY (`CL_NO`) REFERENCES `checklist` (`CL_NO`),
  ADD CONSTRAINT `diagnosis_ibfk_3` FOREIGN KEY (`HL_NO`) REFERENCES `hospitallist` (`HL_NO`),
  ADD CONSTRAINT `diagnosis_ibfk_4` FOREIGN KEY (`DCT_NO`) REFERENCES `doctor` (`DCT_NO`),
  ADD CONSTRAINT `diagnosis_ibfk_5` FOREIGN KEY (`PTT_NO`) REFERENCES `patient` (`PTT_NO`);

--
-- 限制表 `doctor`
--
ALTER TABLE `doctor`
  ADD CONSTRAINT `doctor_ibfk_1` FOREIGN KEY (`DEPT_NAME`) REFERENCES `dept` (`DEPT_NAME`);

--
-- 限制表 `druglist`
--
ALTER TABLE `druglist`
  ADD CONSTRAINT `druglist_ibfk_2` FOREIGN KEY (`STF_NO`) REFERENCES `staff` (`STF_NO`);

--
-- 限制表 `drugmanage`
--
ALTER TABLE `drugmanage`
  ADD CONSTRAINT `drugmanage_ibfk_1` FOREIGN KEY (`STF_NO`) REFERENCES `staff` (`STF_NO`),
  ADD CONSTRAINT `drugmanage_ibfk_2` FOREIGN KEY (`DRUG_NO`) REFERENCES `drug` (`DRUG_NO`);

--
-- 限制表 `hospitallist`
--
ALTER TABLE `hospitallist`
  ADD CONSTRAINT `hospitallist_ibfk_1` FOREIGN KEY (`WD_NO`) REFERENCES `ward` (`WD_NO`),
  ADD CONSTRAINT `hospitallist_ibfk_2` FOREIGN KEY (`DCT_NO`) REFERENCES `doctor` (`DCT_NO`);

--
-- 限制表 `listdrug`
--
ALTER TABLE `listdrug`
  ADD CONSTRAINT `listdrug_ibfk_1` FOREIGN KEY (`DL_NO`) REFERENCES `druglist` (`DL_NO`),
  ADD CONSTRAINT `listdrug_ibfk_2` FOREIGN KEY (`DRUG_NO`) REFERENCES `drug` (`DRUG_NO`);

--
-- 限制表 `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`PTT_NO`) REFERENCES `patient` (`PTT_NO`),
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`STF_NO`) REFERENCES `staff` (`STF_NO`);

--
-- 限制表 `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`DEPT_NAME`) REFERENCES `dept` (`DEPT_NAME`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
