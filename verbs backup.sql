-- phpMyAdmin SQL Dump
-- version 3.4.10.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 04, 2012 at 01:15 AM
-- Server version: 5.1.62
-- PHP Version: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jtutorx1_japanese`
--

-- --------------------------------------------------------

--
-- Table structure for table `verbs`
--

CREATE TABLE IF NOT EXISTS `verbs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `english` varchar(40) NOT NULL,
  `dictionary` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `type` char(1) NOT NULL,
  `difficulty` char(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=130 ;

--
-- Dumping data for table `verbs`
--

INSERT INTO `verbs` (`id`, `english`, `dictionary`, `type`, `difficulty`) VALUES
(1, 'eat', '「食（た）べる', 'i', 'b'),
(2, 'run', '「走（はし）る', 'g', 'b'),
(3, 'drink', '「飲（の）む', 'g', 'b'),
(4, 'swim', '「泳（およ）ぐ', 'g', 'b'),
(5, 'read', '「読（よ）む', 'g', 'b'),
(6, 'meet', '「会（あ）う', 'g', 'b'),
(7, 'write', '「書（か）く', 'g', 'b'),
(8, 'believe', '「信（しん）じる', 'i', 'a'),
(20, 'walk', '「歩（ある）く', 'g', 'b'),
(10, 'see', '「見（み）る', 'i', 'b'),
(11, 'wait', '「待（ま）つ', 'g', 'b'),
(12, 'persevere', 'がんばる', 'g', 'b'),
(13, 'stand', '「立（た）つ', 'g', 'b'),
(14, 'search', '「探（さが）す', 'g', 'b'),
(15, 'borrow', '「借（か）りる', 'i', 'b'),
(16, 'forget', '「忘（わす）れる', 'i', 'i'),
(17, 'close', '「閉（と）じる', 'i', 'i'),
(18, 'hide', '「隠（かく）れる', 'i', 'i'),
(19, 'recover', '「取（と）り「戻（もど）す', 'g', 'i'),
(21, 'extend', '「伸（の）ばす', 'g', 'a'),
(22, 'gaze', '「眺（なが）める', 'i', 'a'),
(23, 'put', '「入（い）れる', 'i', 'b'),
(24, 'talk', '「話（はな）す', 'g', 'b'),
(25, 'help', '「手伝（てつだ）う', 'g', 'b'),
(34, 'know', '「知（し）る', 'g', 'b'),
(33, 'listen', '「聞（き）く', 'g', 'b'),
(35, 'marry', '「結婚（けっこん）する', 's', ''),
(36, 'study', '「勉強（べんきょう）する', 's', 'b'),
(38, 'turn on', 'つける', 'i', ''),
(64, 'hurry', '「急（いそ）ぐ', 'g', ''),
(40, 'play', '「遊（あそ）ぶ', 'g', ''),
(41, 'break (take a)', '「休（やす）む', 'g', 'b'),
(43, 'wake up', '「起（お）きる', 'i', ''),
(44, 'lend', '「借（か）りる', 'i', ''),
(45, 'send', '「送（おく）る', 'g', ''),
(47, 'have a meal', '「食事（しょくじ）する', 's', ''),
(59, 'show', '「見（み）せる', 'i', ''),
(50, 'catch', '「取（と）る', 'g', 'i'),
(58, 'get drunk', '「酔（よ）っぱらう', 'g', 'a'),
(63, 'show', '「見（み）せる', 'i', ''),
(65, 'call (shout)', '「呼（よ）ぶ', 'g', 'i'),
(66, 'turn', '「曲（ま）がる', 'g', ''),
(67, 'buy', '「買（か）う', 'g', 'b'),
(83, 'think', '「考（かんが）える', 'i', ''),
(69, 'have', '「持（も）つ', 'g', ''),
(72, 'say', '「言（い）う', 'g', ''),
(71, 'turn off', '「消（け）す', 'g', ''),
(73, 'remember', '「覚（おぼ）える', 'i', ''),
(74, 'stay', '「泊（と）まる', 'g', 'i'),
(75, 'recieve', '「貰う', 'g', ''),
(85, 'give', '「上（あ）げる', 'i', ''),
(77, 'sleep', '「寝（ね）る', 'i', ''),
(78, 'shut', '「閉（し）める', 'i', ''),
(79, 'open', '「開（あ）ける', 'i', ''),
(80, 'open (3rd p)', '「開（ひら）く', 'g', ''),
(81, 'close (3rd p)', '「閉（し）まる', 'g', 'i'),
(82, 'teach', '「教（おし）える', 'i', ''),
(84, 'think (opinion)', '「思（おも）う', 'g', 'i'),
(86, 'wear (head)', 'かぶる', 'g', ''),
(90, 'wear (body)', '「着（き）る', 'i', ''),
(91, 'wear (lower)', '「履（は）く', 'g', ''),
(92, 'get on', '「乗（の）る', 'g', ''),
(93, 'get off', '「降（お）りる', 'i', ''),
(94, 'bathe', '「浴（あ）びる', 'i', 'i'),
(95, 'go up', '「上（のぼ）る', 'g', ''),
(96, 'go down', '「下（くだ）る', 'g', ''),
(97, 'go', '「行（い）く', 'g', ''),
(98, 'enter', '「入（はい）る', 'g', 'b'),
(123, 'get out', '「出（で）る', 'i', ''),
(100, 'get out (money)', '「出（だ）す', 'g', ''),
(102, 'transfer (trains)', '「乗（の）り「換（か）える', 'i', ''),
(103, 'arrive', '「着（つ）く', 'g', 'b'),
(104, 'make', '「作（つく）る', 'g', ''),
(106, 'use', '「使（つか）える', 'i', ''),
(107, 'can', '「出（で）「来（き）る', 'i', 'b'),
(108, 'quit', '「止（や）める', 'i', ''),
(109, 'stop', '「止（と）まる', 'g', ''),
(112, 'give (3rd p)', '「呉（く）れる', 'g', ''),
(113, 'check', '「確（かく）「認（にん）する', 's', 'a'),
(114, 'taste', '「味（あじ）する', 's', ''),
(115, 'lick', '「舐（な）める', 'i', ''),
(116, 'worry', '「心（しん）「配（ぱい）する', 's', ''),
(117, 'take a walk', '「散（さん）「歩（ぽ）する', 's', ''),
(118, 'sell', '「売（う）る', 'g', ''),
(119, 'pay', '「払（はら）う', 'g', ''),
(120, 'wash', '「洗（あら）う', 'g', ''),
(121, 'start', '「始（はじ）まる', 'g', ''),
(122, 'need', '「要（い）る', 'g', ''),
(124, 'leave', '「発（た）つ', 'g', ''),
(125, 'accumulate', '「溜（た）める', 'i', 'a'),
(126, 'become', 'なる', 'g', 'i'),
(129, 'return', '「戻（もど）る', 'g', ''),
(128, 'return home', '「帰（かえ）ります', 'g', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
