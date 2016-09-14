# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.5.42)
# Database: geekpottest
# Generation Time: 2016-09-14 02:17:25 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table access_tokens
# ------------------------------------------------------------

DROP TABLE IF EXISTS `access_tokens`;

CREATE TABLE `access_tokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `access_tokens_user_id_foreign` (`user_id`),
  CONSTRAINT `access_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `access_tokens` WRITE;
/*!40000 ALTER TABLE `access_tokens` DISABLE KEYS */;

INSERT INTO `access_tokens` (`id`, `user_id`, `token`, `deleted_at`, `created_at`, `updated_at`)
VALUES
	(1,1,'$2y$10$SCN0isU.SrDfgExSx5ojbuHijQKJQ8TJmd7dyG5Cm2ZeQQKvgXjiy',NULL,'2016-09-13 23:16:10','2016-09-13 23:16:10'),
	(2,2,'$2y$10$Z/D9dV8vc/34pLnQH4nYVudes9zmTp3X.vTbaLrJyE0xXo73xEBCO',NULL,'2016-09-13 23:16:11','2016-09-13 23:16:11'),
	(3,6,'$2y$10$R.3FunvouJ1HYTiLtfxVnunB4/H9ZbtBkEYXL3Mg4xEU7rQE52qPW',NULL,'2016-09-13 23:16:14','2016-09-13 23:16:14'),
	(4,8,'$2y$10$0WBSGyxIlfWAQ/KVpBzXG.MavP38U1MRY0ZI7jCZHhCigk9UXCoUa',NULL,'2016-09-13 23:16:16','2016-09-13 23:16:16'),
	(5,10,'$2y$10$4om1waAYMr0HT9k6Je5bEeqqf/q4KlF.Lw1U7NFaeClUV1OVW8b/K','2016-09-13 23:16:17','2016-09-13 23:16:17','2016-09-13 23:16:17'),
	(6,12,'$2y$10$FjWgMJw4Y21wjMoTMZ30Iu0uJcbjbH2UaR7xzTFS35mFCurJUGVj.','2016-09-13 23:16:19','2016-09-13 23:16:19','2016-09-13 23:16:19'),
	(7,12,'$2y$10$yBgt.srVbrnOPKzYPTJBkufaGlYUUM0vgraFCnLUjKaYIRC0vAZ/q',NULL,'2016-09-13 23:16:19','2016-09-13 23:16:19'),
	(8,13,'$2y$10$f.szyE6ObSZUAzCjPAuEM.Np66svI9FvtBF/.cIq94FJVm3URfCGS',NULL,'2016-09-13 23:16:20','2016-09-13 23:16:20'),
	(9,14,'$2y$10$421wQxOBvYqi2FQkAmllJOaHdWGS7UIwmA1bY3OPvpc2/AKQeYMIa',NULL,'2016-09-13 23:16:21','2016-09-13 23:16:21'),
	(10,15,'$2y$10$3SELLhwzm4CwL1hrnhAFCeKCg53ZIgWU2sdlfh3ph1ovFWA6s02k2',NULL,'2016-09-13 23:16:22','2016-09-13 23:16:22'),
	(11,16,'$2y$10$wHmgMmnVhLXmh9v179hhP.4O2XQGESCwsxIPCKv1VVsnW0y1tMRim',NULL,'2016-09-13 23:16:23','2016-09-13 23:16:23'),
	(12,18,'$2y$10$LUBNvl7sd5F3L/Vcfj5zbunKSzEVgJE6zN3fL14WsURzgwXiFVuk2',NULL,'2016-09-13 23:16:25','2016-09-13 23:16:25'),
	(13,19,'$2y$10$72UkQt.J9S1b8aRJRMhaxe/qe2bZp4d8yOIjOjBlPpSJwRzpqzTVS',NULL,'2016-09-13 23:16:26','2016-09-13 23:16:26'),
	(14,21,'$2y$10$T4ACcg4kmdzXSUVjyI5YTOkTwj/g.vGJhReIiZ0vra.WnTrIPLQVG',NULL,'2016-09-13 23:16:27','2016-09-13 23:16:27'),
	(15,22,'$2y$10$XQabO3i9OAODDybx3sqXiu4bbnLMHJkg3MyljPIlbIjP5ov9L8FL2',NULL,'2016-09-13 23:16:28','2016-09-13 23:16:28'),
	(16,23,'$2y$10$PjeY/.BdyYWdP3wUvd8ewenK9gH379QkigCUcrTpO.yjr.p9PoTEm',NULL,'2016-09-13 23:16:29','2016-09-13 23:16:29'),
	(17,24,'$2y$10$j.FjLWPNEBQMt9qRfq8GjuToW0BbqUu2AksSJpks4ZSn2Mr0BHzZO',NULL,'2016-09-13 23:16:30','2016-09-13 23:16:30'),
	(18,26,'$2y$10$9WXlXQ6oWhkhQ2c4DfZ8PeNhXm9WpENFPD5o4./7SEdj0ulCii5iO',NULL,'2016-09-13 23:16:32','2016-09-13 23:16:32'),
	(19,27,'$2y$10$gV/9jQVWcVcn4y4tiDFg4uLuKGJJwoinYFSCGUn9gHbttOuqKtpNK',NULL,'2016-09-13 23:16:33','2016-09-13 23:16:33'),
	(20,29,'$2y$10$XYFSbhCFOFxqh1VcP4ATbu1ij9m1k/AuxEKMOtIBoNgtdNnw1vSea',NULL,'2016-09-13 23:16:35','2016-09-13 23:16:35'),
	(21,30,'$2y$10$kYOUrPOGl0XxIZViZen25uOUpTdV4fte5iCJicrZUVq7woCQJO81m',NULL,'2016-09-13 23:16:36','2016-09-13 23:16:36'),
	(22,32,'$2y$10$E17J9ECKG7WHn9MIv5TxQOBY4BYVQqKcLZCe01EC/MniVu/e571Em',NULL,'2016-09-13 23:16:37','2016-09-13 23:16:37'),
	(23,34,'$2y$10$nZou.LvYcpwkIV7LZ7zciex2nCIYz.3VscN8IHMygxx0091hF109y',NULL,'2016-09-13 23:16:39','2016-09-13 23:16:39'),
	(24,35,'$2y$10$95Y5E27/VwnUw1pBrZgxTeXjAB1pS755lHxygOxWzOO1o6SdseYLa','2016-09-13 23:16:42','2016-09-13 23:16:40','2016-09-13 23:16:40'),
	(25,35,'$2y$10$/leigxQ5pE.QvsVEaazXOu8JcPxdSFzNQZ.Vn8NAdDz4lPvEHBX/e','2016-09-13 23:16:42','2016-09-13 23:16:41','2016-09-13 23:16:41'),
	(26,35,'$2y$10$Y5ct5zOQWWRpUo7v.r6LK.37I.PocNffa7OIIXyR0S3o8Lt/trtrm','2016-09-13 23:16:42','2016-09-13 23:16:41','2016-09-13 23:16:41'),
	(27,35,'$2y$10$LyVKG/aLVjzC2WsKMEKXC.cdBpW45inGII6KdrSeZEbZ0E8fMW/JK','2016-09-13 23:16:42','2016-09-13 23:16:41','2016-09-13 23:16:41'),
	(28,36,'$2y$10$IaMMT5dsDCjLB2iqGN5xiePlAvK8WpbM7fdddpmZyZnMY5u0ZDvW2',NULL,'2016-09-13 23:16:42','2016-09-13 23:16:42'),
	(29,37,'$2y$10$KPcxwElnfYx8ojX1t2G9QeGfz65xBi5QSxJga7jZlpR/nADadvnmS',NULL,'2016-09-13 23:16:43','2016-09-13 23:16:43'),
	(30,38,'$2y$10$50SLqGlYcKiR7.KmRPV2Oex6hkNM/Y2GGHSfkzLa8V5B50C6opCBS',NULL,'2016-09-13 23:16:44','2016-09-13 23:16:44'),
	(31,39,'$2y$10$F078MKAeSAwOkE4.OdEiPe6RAkvLQNXcrkP5QP8D4rKdZvHyiGcvW',NULL,'2016-09-13 23:16:45','2016-09-13 23:16:45');

/*!40000 ALTER TABLE `access_tokens` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`migration`, `batch`)
VALUES
	('2016_09_13_184426_create_users_table',1),
	('2016_09_13_210727_create_access_tokens_table',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `api_key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `perm` int(11) NOT NULL DEFAULT '0',
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `email`, `password`, `api_key`, `perm`, `deleted_at`, `created_at`, `updated_at`)
VALUES
	(1,'57d8b2e958998@test.com','$2y$10$ipLxWEvWAFXQmxrEzMhYWevaf3EOpyxuciQiORoCs5zEvoaAtSYsG','$2y$10$kOcTYNEF0ETAMNIyGS6OmOD/H4/1DtBwcUtJVYgQz8BoqE.GAqnH2',0,NULL,'2016-09-13 23:16:10','2016-09-13 23:16:10'),
	(2,'57d8b2ea702d2@test.com','$2y$10$pJQAvh26Qnc/hsUpx299vO3XqUkkIk553zG8s0VxiJHQlSjddYOuO','$2y$10$S8IxE4OZ7GhnChucqpnNZeL7Hepn4i6.lZhjaxAGCP2wR.CCkIV8C',0,NULL,'2016-09-13 23:16:11','2016-09-13 23:16:11'),
	(3,'57d8b2eb6add3@test.com','$2y$10$JGvPOftj5Igj3ziyWMFOCeBM6fo8tn0GS379O2wDNUWtvds/ozZou','$2y$10$kHPUAGhKhZESFZPsg55GSOCfMANPtkoSzMJs0.cTPIotkfflCef3e',0,NULL,'2016-09-13 23:16:12','2016-09-13 23:16:12'),
	(4,'test_store_json@user.com','$2y$10$gjpsWmS6y.ZVcev5smcfCO24kUIzb7eSYgm.pSyU50R9pX8zQd.RS','$2y$10$qIWyif3pja6kXEz0N8z3NuKiba/i8k48gw/qamZguT5fZmGjxkK52',0,NULL,'2016-09-13 23:16:12','2016-09-13 23:16:12'),
	(5,'test_status@user.com','$2y$10$LD6UoaEDDnMuUQFK76hO6eaUZYEfValGSMuinEH9yFCEQHvGAy7kG','$2y$10$kMTxRFYB/TX3.JlEAC0zNeCiN9r4O8qRz9Uc.OcQqAoyAan9xp2f2',0,NULL,'2016-09-13 23:16:13','2016-09-13 23:16:13'),
	(6,'57d8b2ed79997@test.com','$2y$10$C2o0a8ifVTkIcQUVAdYP.OCRXhtCOIoK6saZcXUv.LPps.lnR5eFC','$2y$10$BH4lU7zkXuyhd4KnUd/INOGuXIzXBz9eJkAGq7wE3BQF0whG1r99G',0,NULL,'2016-09-13 23:16:14','2016-09-13 23:16:14'),
	(7,'57d8b2ee7eddc@test.com','$2y$10$wKgcwrxCedLkHjZaxSWhF.bPnAo9JKqxYA5SUHflSIIfkO0tEJt2a','$2y$10$1lc4ma60NMk4nwXVSbsYyunmhERvtWjCJQDf08m6NVFiPR1BN5Dxu',0,NULL,'2016-09-13 23:16:15','2016-09-13 23:16:15'),
	(8,'57d8b2ef27a81@test.com','$2y$10$dgf3zIYmf..KnKgDfCY1IOSi5/8j7GelM5O.gbUZyoXJXnySt1w2a','$2y$10$Z2cic9Xa4..BBX2wujYqYuOhsAP9Lu2ESaGRW096jtz7y2Ksq6WqS',0,NULL,'2016-09-13 23:16:15','2016-09-13 23:16:15'),
	(9,'57d8b2f024631@test.com','$2y$10$iKZ70ijc9Yb/Eyb7wCX92elwRiJPy6lfML/Hu51Vs9sAF6nABOCVS','$2y$10$YwREw.NAGqEDCY17YLWKY.jYAEkIbUG72g61ikLiA31dqALMFfAE2',0,NULL,'2016-09-13 23:16:16','2016-09-13 23:16:16'),
	(10,'57d8b2f0c3400@test.com','$2y$10$aX8PGexQRD2rJ8pF2ARfZ.0bYqS4Ox3zW9vN3vG4y3uhRdns6wLxS','$2y$10$beDWc/HcP26VRYB.Iy8C3.VeyOFYe7G8BaAFhStEwb3pjfu6FkcWS',0,NULL,'2016-09-13 23:16:17','2016-09-13 23:16:17'),
	(11,'57d8b2f1b4b9e@test.com','$2y$10$HaOkIgFueAAFcmXS7OyLE.ZFE7aycHb1g5fFZfuHyyWDS4tkVDwDC','$2y$10$H6Q.pG8cDvdilEshjXZvDe6TNm9QQDweNQ/oEM3z5aWVyVX.T6oym',0,NULL,'2016-09-13 23:16:18','2016-09-13 23:16:18'),
	(12,'57d8b2f25f941@test.com','$2y$10$8IHTW5mZ2jNkDoFOpLqaCu5qaPhjdMZKgTaacxBtXpuT722uSIsAu','$2y$10$qdX9bwwBsQFWTre5aQSDpemKHxPDfzOgmX9JQEXYxMq5VEuPMyE0.',0,NULL,'2016-09-13 23:16:19','2016-09-13 23:16:19'),
	(13,'57d8b2f3a3ff3@test.com','$2y$10$BEIDm.JCFuFRjWyOiFdAsOIEidUX1qkxSIObCX8DImKJDH/mv.Sji','$2y$10$2K99ji4VKJwoK/9qK8wSduleTu5owKmYVMEXmD7hZUPnCN5pcxmV6',1,NULL,'2016-09-13 23:16:20','2016-09-13 23:16:20'),
	(14,'57d8b2f49a4e9@test.com','$2y$10$ihnPVumr0cZ6HZayVRnLBOfN.4KeAMpjD8fOSAxrAA/LqEfqrqBJm','$2y$10$lbl47AgO5W2p65MKShYjqO1f87/HD7OyAryDiJwdoQYic6gbfx.6G',1,NULL,'2016-09-13 23:16:21','2016-09-13 23:16:21'),
	(15,'57d8b2f595fac@test.com','$2y$10$bzdpqW0tOI33n87oL2NSXOJ2R/2E.L9mhu.P/zyfPon/.Tay1Jnny','$2y$10$gMa7dzN4hKw/mvwWWFhQYOBxq3zjGpgis76VO0eATNCQczCV2CU8G',1,NULL,'2016-09-13 23:16:22','2016-09-13 23:16:22'),
	(16,'57d8b2f68caba@test.com','$2y$10$d5Guy4dOWITaPEKWTs9t/ugt1TvsWktHTV9V8vKHzsVGTzJ3DP.6W','$2y$10$ePDKgbO6Nl.HnyncAO7uLOs1ihY/pynCh/oBLmTUP6MSKfvC/Q7N2',1,NULL,'2016-09-13 23:16:23','2016-09-13 23:16:23'),
	(17,'57d8b2f77f742@test.com','$2y$10$TnaZ2nbeGDpofa5i/J4Q4.K72hS5t.rbLDZYNq/LCZfaKCrQG8RMu','$2y$10$LO9rbs257ZJj74Q0fh2zjOxgvx00DmeWxxZUtd7iQuur4juadPIPi',0,'2016-09-13 23:16:24','2016-09-13 23:16:24','2016-09-13 23:16:24'),
	(18,'57d8b2f821e91@test.com','$2y$10$Hqy.EQfXkExomY6aEZhHlOTLZAww1.dX62lnwYh8ro6VRkk/uphkG','$2y$10$s5Cstyy27.uKqLpblvxR8OFkKRMZgwvpW/191zhYPb2oB8RrKRSsm',1,NULL,'2016-09-13 23:16:24','2016-09-13 23:16:24'),
	(19,'57d8b2f91c052@test.com','$2y$10$1tDUFgqORfi1DgmknVbKA.mWNgeq5OOxd1.0n8b9Zx9q3a0LY/Po.','$2y$10$PhubLaw7CqPVXSL4uZUHZOfzUlf6epmX9cdQy9M4laaTsQeLhv2GC',0,NULL,'2016-09-13 23:16:25','2016-09-13 23:16:25'),
	(20,'57d8b2fa14bc0@test.com','$2y$10$WhEPS6m4DPruMZyLmjnvheLiZueS3JzXTiBGK4I4oAQUsXovcHsxy','$2y$10$LHdHVs6GhCOUt9zAFT8jWOauCkB2xtPv6bsZB1hQlkAWUFVkKbBD6',0,'2016-09-13 23:16:27','2016-09-13 23:16:26','2016-09-13 23:16:27'),
	(21,'57d8b2faaed58@test.com','$2y$10$LhUgeC4zBmLNjs5vlW4QReLNOi6QMW1Ooa6lWmizXHmQ1tgFr.I6y','$2y$10$Ixtezbd09UUUbtKW5iXKROp72mTVTI/wltm.NqV./EMbyeBv.KFU2',1,NULL,'2016-09-13 23:16:27','2016-09-13 23:16:27'),
	(22,'57d8b2fbacb05@test.com','$2y$10$xiKGR25CzEXAXaH1FCgcneCikigtoZJeXBfLnqAYqoX0ar2hQr3yy','$2y$10$ibN3.lq1rwVaG8kFGgkT1uu.hsHW.ddreVUXtUIy.0GgKe3ZXUBRq',1,NULL,'2016-09-13 23:16:28','2016-09-13 23:16:28'),
	(23,'57d8b2fcac1b0@test.com','$2y$10$Ag.jFgBSoSYLRgjDpBDIHeUGxnm39..QVfIyGWIeOwhGUph.KP1dC','$2y$10$3m1NXvgOtfoxVa8EYTruXeptw6VQADkoEuEOMo7aHdTA4qWJz5J8S',0,NULL,'2016-09-13 23:16:29','2016-09-13 23:16:29'),
	(24,'57d8b2fdadec1@test.com','$2y$10$rNqlhwjMdKKZHD4BFbaCNO2ot4a4AsjPaHSxKuVuF09kcHfV1JiGu','$2y$10$b0LDJDLJs.X/PdldptcWou6lD2ThIBI6fd97m0iL6LYqKOvG8goRS',1,NULL,'2016-09-13 23:16:30','2016-09-13 23:16:30'),
	(25,'new@example.com','$2y$10$gofL5MjizVgYASoqgYrMY.IIuW2gINjFI0Z/BjGupO9s4YSqFUEAO','$2y$10$NMdOCmJXKhFJoLDwXC9hhua2uFu2.bWV/JX6qyn.l1EWyNiHznZb.',0,NULL,'2016-09-13 23:16:31','2016-09-13 23:16:32'),
	(26,'57d8b2ff5881b@test.com','$2y$10$gvNiA53s7MP4HUFu64YC7OypxA4SghF5qgw.9Hvbtblbm0FaC3hLe','$2y$10$cP3N4LrJOnW3WdoUYRThPuPEqoNROr61Klc1igN7hNysTpqkiHZw.',1,NULL,'2016-09-13 23:16:31','2016-09-13 23:16:32'),
	(27,'new_normal@example.com','$2y$10$jhYDLG9CYL/iE9qRvtyiAe8hNn0wZbg4dnAd6SFHwgUVPeoNg5Gju','$2y$10$LnYEGi0DYzvfl7Y11cgH1O9kxeCTTZXGSq5htIXUVDTAuH890wSM2',0,NULL,'2016-09-13 23:16:33','2016-09-13 23:16:33'),
	(28,'57d8b301e1f7e@test.com','$2y$10$s68XyAPA6EIxMyqBKRSGbOFXGyrDvSsZW29D6havc0n2NNpfPQxly','$2y$10$M0MxrIns4B06JA/R5.PcO.fPX5LeaeG/qoSAlxD59LTHRJKG7.2c.',0,NULL,'2016-09-13 23:16:34','2016-09-13 23:16:34'),
	(29,'57d8b302857bc@test.com','$2y$10$yubXxU56pvi2K5FvgQDm4.IZsC4JH.M8VuLvkNruykGPUkSAafYCi','$2y$10$Hg1FwVLsz9Xc82FPudriIOmLT3BEAhrSJk5WwzEdRkdDw90HRaSp.',0,NULL,'2016-09-13 23:16:35','2016-09-13 23:16:35'),
	(30,'57d8b303816da@test.com','$2y$10$A5/G/bIiz69lQzr6mno7feoOz9VcRskc8hYeMSC3OieFvdq/Hd0Fy','$2y$10$xZqO.ftSkcnWxr7pb4NxaOK1uKSB6Ab5qJtCChM/4aQ9ztdczrATS',1,NULL,'2016-09-13 23:16:36','2016-09-13 23:16:36'),
	(31,'57d8b30474d05@test.com','$2y$10$cK.jhs9y.nPnwRGo2G/rnut17qdc7we7y7pR/l6GS0q7LNfQb7qzm','$2y$10$dsk6RY7TiHHW7paVaKghquPAE7bmFRtk7p.yIoKKvlXgdCmzNQUEy',0,NULL,'2016-09-13 23:16:37','2016-09-13 23:16:37'),
	(32,'unique@example.com','$2y$10$hS4dhIsyOWyqnjcofFdb6.H4Fsz7YbnF/8m32LiDZnBDgYEpHGNMC','$2y$10$qXGO3oGl56zHoyJa0wOiauWfpfrR7tTGI28ompX..E4eRLmwhHYCi',1,NULL,'2016-09-13 23:16:37','2016-09-13 23:16:37'),
	(33,'57d8b305ef58d@test.com','$2y$10$J55GuhrDI6dE6VqMx1/FnupV31syF655HF.UNE4/84UwwPbeTM7/C','$2y$10$2TlWrRgRh1VwBNYosHCoJePsGL0pFt.o/4VcuRmjtKErn16goNpZq',0,NULL,'2016-09-13 23:16:38','2016-09-13 23:16:39'),
	(34,'57d8b3069480a@test.com','$2y$10$AwLtG5O093l09yA0c3dpL.g7th9P0/G33G.aJx8gxdb.JXbN2gCPm','$2y$10$0VSmUgKlimi9hidZJ8SU4uiXP91eieXfWXtIbrp8mDsGk3JpsXEuW',1,NULL,'2016-09-13 23:16:39','2016-09-13 23:16:39'),
	(35,'57d8b307db6b4@test.com','$2y$10$8mTHEuggYkbzxpKzfwy7Te1PqENufdUZI3pCiOVz9vWAaoWA0x2s2','$2y$10$u.8UwvxaMQgOGFfGaww1PON96fq8cFnLnJqlDiHolpQjtlsbfKtsC',0,NULL,'2016-09-13 23:16:40','2016-09-13 23:16:40'),
	(36,'57d8b309c8cc3@test.com','$2y$10$osqrsb4Kycomb2ILwgEfyeG2RqDJca7hHwtp72iJiUdUOVy/OxaT6','$2y$10$3sBTavEETOJxe8w0JRg7jezZR.l3Lmu.kwn9f.iBvV17tyWeDHafO',1,NULL,'2016-09-13 23:16:42','2016-09-13 23:16:42'),
	(37,'57d8b30acc828@test.com','$2y$10$8VSQkq5me0kM5Xten7s51.3h9ws1awxiQojmBpxVDbm.b01UHR1y6','$2y$10$ddBOctiFadYzNCH5whJNkeqsmGgJ2cXOfkmHFAQ5iqWURREltBoZS',1,NULL,'2016-09-13 23:16:43','2016-09-13 23:16:43'),
	(38,'57d8b30bceb23@test.com','$2y$10$4WsJ9AdVCp7DjvA8CjbOsOAU5zdc6DrydmbZDANe7PWXuCHnBU/xq','$2y$10$MAA/BzKgNqhfvqYKVI7Ra.wA1QMTfkCNnX7HUuMErCG1IWUcW4mGW',0,NULL,'2016-09-13 23:16:44','2016-09-13 23:16:44'),
	(39,'57d8b30cc9b77@test.com','$2y$10$MJ4VnfJ.5bVwGGzL9HfyIu3ABL8ZsCfgQ7.D/5ivqVruzVHZ/qE/i','$2y$10$Z/AqQDHoPBgOnpv8i7CNLOPR/lDIil2GMOqJ9JWGP64HcibLxP.Ye',1,NULL,'2016-09-13 23:16:45','2016-09-13 23:16:45');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
