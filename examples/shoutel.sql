-- --------------------------------------------------------
-- 호스트:                          localhost
-- 서버 버전:                        5.7.11 - MySQL Community Server (GPL)
-- 서버 OS:                        Win32
-- HeidiSQL 버전:                  11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 테이블 bb.st_board 구조 내보내기
DROP TABLE IF EXISTS `st_board`;
CREATE TABLE IF NOT EXISTS `st_board` (
  `no` bigint(20) NOT NULL AUTO_INCREMENT,
  `key` varchar(64) NOT NULL,
  `board_id` varchar(64) NOT NULL,
  `title` varchar(300) NOT NULL,
  `content` longtext NOT NULL,
  `register_date` datetime NOT NULL,
  `edit_date` datetime NOT NULL,
  `member_no` bigint(20) DEFAULT NULL,
  `nickname` varchar(64) NOT NULL,
  `hit` bigint(20) DEFAULT '0',
  `comment_count` bigint(20) DEFAULT '0',
  `vote_up` bigint(20) DEFAULT '0',
  `vote_down` bigint(20) DEFAULT '0',
  PRIMARY KEY (`no`),
  KEY `idx_key` (`key`) USING BTREE,
  KEY `idx_member_no` (`member_no`) USING BTREE,
  KEY `idx_hit` (`hit`),
  KEY `idx_comment_count` (`comment_count`),
  KEY `idx_vote_up` (`vote_up`),
  KEY `idx_vote_down` (`vote_down`),
  KEY `idx_board_id` (`board_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- 테이블 데이터 bb.st_board:~2 rows (대략적) 내보내기
DELETE FROM `st_board`;
/*!40000 ALTER TABLE `st_board` DISABLE KEYS */;
INSERT INTO `st_board` (`no`, `key`, `board_id`, `title`, `content`, `register_date`, `edit_date`, `member_no`, `nickname`, `hit`, `comment_count`, `vote_up`, `vote_down`) VALUES
	(1, '3', 'gg', 'aaa', 'aaa', '2020-06-17 01:11:18', '0000-00-00 00:00:00', 3, '', 13, NULL, 0, 0),
	(2, '3', 'notice', 'asdasasdㅁㄴ""\'\'ㅇㅁㄴ<>?<>ㅇ', '테스트', '2020-08-19 20:28:19', '2020-08-19 20:28:21', 3, '', 0, NULL, 0, 0);
/*!40000 ALTER TABLE `st_board` ENABLE KEYS */;

-- 테이블 bb.st_board_list 구조 내보내기
DROP TABLE IF EXISTS `st_board_list`;
CREATE TABLE IF NOT EXISTS `st_board_list` (
  `no` bigint(20) NOT NULL AUTO_INCREMENT,
  `board_id` varchar(64) NOT NULL,
  `board_name` varchar(300) NOT NULL,
  `board_admin` bigint(20) DEFAULT NULL,
  `board_managers` mediumtext,
  `description` varchar(10000) DEFAULT NULL,
  `category` bigint(20) NOT NULL,
  `board_cover` varchar(1000) DEFAULT NULL,
  `board_settings` mediumtext,
  `register_date` datetime NOT NULL,
  PRIMARY KEY (`no`),
  KEY `idx_board_id` (`board_id`) USING BTREE,
  KEY `idx_category` (`category`),
  KEY `idx_board_admin` (`board_admin`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- 테이블 데이터 bb.st_board_list:~1 rows (대략적) 내보내기
DELETE FROM `st_board_list`;
/*!40000 ALTER TABLE `st_board_list` DISABLE KEYS */;
INSERT INTO `st_board_list` (`no`, `board_id`, `board_name`, `board_admin`, `board_managers`, `description`, `category`, `board_cover`, `board_settings`, `register_date`) VALUES
	(1, 'notice', '공지', 2, NULL, '공지사항 게시판입니다.', 234, 'https://i.imgur.com/oVXV61i.jpg', '{"permission":{"list":2,"view":2,"writePost":99,"writeComment":2,"vote":2}}', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `st_board_list` ENABLE KEYS */;

-- 테이블 bb.st_board_trash 구조 내보내기
DROP TABLE IF EXISTS `st_board_trash`;
CREATE TABLE IF NOT EXISTS `st_board_trash` (
  `no` bigint(20) NOT NULL DEFAULT '0',
  `key` varchar(64) NOT NULL,
  `board_id` varchar(64) NOT NULL,
  `title` varchar(300) NOT NULL,
  `content` longtext NOT NULL,
  `register_date` datetime NOT NULL,
  `edit_date` datetime NOT NULL,
  `member_no` bigint(20) DEFAULT NULL,
  `hit` bigint(20) DEFAULT '0',
  `vote_up` bigint(20) DEFAULT '0',
  `vote_down` bigint(20) DEFAULT '0',
  PRIMARY KEY (`no`),
  KEY `idx_key` (`key`) USING BTREE,
  KEY `idx_board_key` (`board_id`) USING BTREE,
  KEY `member_no` (`member_no`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 테이블 데이터 bb.st_board_trash:~0 rows (대략적) 내보내기
DELETE FROM `st_board_trash`;
/*!40000 ALTER TABLE `st_board_trash` DISABLE KEYS */;
/*!40000 ALTER TABLE `st_board_trash` ENABLE KEYS */;

-- 테이블 bb.st_member 구조 내보내기
DROP TABLE IF EXISTS `st_member`;
CREATE TABLE IF NOT EXISTS `st_member` (
  `member_no` bigint(20) NOT NULL AUTO_INCREMENT,
  `member_id` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nick_name` varchar(64) NOT NULL,
  `admin` tinyint(4) NOT NULL,
  PRIMARY KEY (`member_no`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- 테이블 데이터 bb.st_member:~4 rows (대략적) 내보내기
DELETE FROM `st_member`;
/*!40000 ALTER TABLE `st_member` DISABLE KEYS */;
INSERT INTO `st_member` (`member_no`, `member_id`, `password`, `nick_name`, `admin`) VALUES
	(1, 'abcd', '$2y$12$nwt3/ABNVbSGyCoxYapm6uaWylV7X6X10ikImYUiVMlvd/PtDQciG', 'aaa', 0),
	(2, 'admin', '$2y$12$tNNYOu0K7ROGxdCXhj4AP.bXZXkoAdsb3RO42eI66y7WFSyxJ1yyi', '관리자', 1),
	(3, 'asdasdasd', '$2y$12$OqEOQ.C/.LeNhCh/qevOeuX1TcTIQk0YxhDhPh9LDoJNeuEy52e2.', 'Shoutel', 0),
	(4, 'member', '$2y$12$P8lU1SILCv5FrzLCIvmah.Lmz48UR/vCaYoVU3r0xbpfbAH7.WOSC', '아이디', 0);
/*!40000 ALTER TABLE `st_member` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
