-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.7.20 - MySQL Community Server (GPL)
-- Операционная система:         Win64
-- HeidiSQL Версия:              9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Дамп структуры базы данных PowerDistributionData
DROP DATABASE IF EXISTS `PowerDistributionData`;
CREATE DATABASE IF NOT EXISTS `PowerDistributionData` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `PowerDistributionData`;

-- Дамп структуры для таблица PowerDistributionData.AircraftParts
DROP TABLE IF EXISTS `AircraftParts`;
CREATE TABLE IF NOT EXISTS `AircraftParts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Название группы ["Крыло", "Нос"]',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.AircraftParts: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `AircraftParts` DISABLE KEYS */;
INSERT INTO `AircraftParts` (`id`, `name`) VALUES
	(1, 'Крыло'),
	(2, 'Хвост'),
	(3, 'Нос');
/*!40000 ALTER TABLE `AircraftParts` ENABLE KEYS */;

-- Дамп структуры для таблица PowerDistributionData.ArchitecturesNames
DROP TABLE IF EXISTS `ArchitecturesNames`;
CREATE TABLE IF NOT EXISTS `ArchitecturesNames` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vehicleLayoutName_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Название архитектуры для модели (компоновки) ["База", "БЭС1"]',
  `isBasic` tinyint(4) DEFAULT NULL COMMENT 'Является ли базовой архитектурой',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `FK_ArchitecturesNames_VehiclesLayoutsNames` (`vehicleLayoutName_id`),
  CONSTRAINT `FK_ArchitecturesNames_VehiclesLayoutsNames` FOREIGN KEY (`vehicleLayoutName_id`) REFERENCES `VehiclesLayoutsNames` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.ArchitecturesNames: ~8 rows (приблизительно)
/*!40000 ALTER TABLE `ArchitecturesNames` DISABLE KEYS */;
INSERT INTO `ArchitecturesNames` (`id`, `vehicleLayoutName_id`, `name`, `isBasic`) VALUES
	(1, 1, 'База', 0),
	(2, 1, 'БЭС1', 0),
	(3, 3, 'Архит. 7 ЭлКрЛГС', 0),
	(4, 1, 'Архит. 6 2H2E', 0),
	(5, 1, 'Базовое распред. к расчету', 1),
	(6, 1, 'Архит. 5 ЭДСУ', 0),
	(7, 1, 'Архит. 8 ПЭС', 0);
/*!40000 ALTER TABLE `ArchitecturesNames` ENABLE KEYS */;

-- Дамп структуры для таблица PowerDistributionData.Architecture_to_VehicleLayout
DROP TABLE IF EXISTS `Architecture_to_VehicleLayout`;
CREATE TABLE IF NOT EXISTS `Architecture_to_VehicleLayout` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vehicleLayout_id` int(10) unsigned NOT NULL,
  `architectureName_id` int(10) unsigned NOT NULL,
  `energySource_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `FK_Architecture_to_VehicleLayout_VehicleLayout` (`vehicleLayout_id`),
  KEY `FK_Architecture_to_VehicleLayout_ArchitecturesNames` (`architectureName_id`),
  KEY `FK_Architecture_to_VehicleLayout_EnergySources` (`energySource_id`),
  CONSTRAINT `FK_Architecture_to_VehicleLayout_ArchitecturesNames` FOREIGN KEY (`architectureName_id`) REFERENCES `ArchitecturesNames` (`id`),
  CONSTRAINT `FK_Architecture_to_VehicleLayout_EnergySources` FOREIGN KEY (`energySource_id`) REFERENCES `EnergySources` (`id`),
  CONSTRAINT `FK_Architecture_to_VehicleLayout_VehicleLayout` FOREIGN KEY (`vehicleLayout_id`) REFERENCES `VehicleLayout` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.Architecture_to_VehicleLayout: ~280 rows (приблизительно)
/*!40000 ALTER TABLE `Architecture_to_VehicleLayout` DISABLE KEYS */;
INSERT INTO `Architecture_to_VehicleLayout` (`id`, `vehicleLayout_id`, `architectureName_id`, `energySource_id`) VALUES
	(1, 1, 5, 3),
	(2, 1, 6, 3),
	(3, 1, 4, 1),
	(4, 1, 3, 6),
	(5, 1, 7, 6),
	(6, 2, 5, 2),
	(7, 2, 6, 2),
	(8, 2, 4, 2),
	(9, 2, 3, 6),
	(10, 2, 7, 6),
	(11, 3, 5, 1),
	(12, 3, 6, 3),
	(13, 3, 4, 1),
	(14, 3, 3, 6),
	(15, 3, 7, 6),
	(16, 4, 5, 2),
	(17, 4, 6, 2),
	(18, 4, 4, 1),
	(19, 4, 3, 6),
	(20, 4, 7, 6),
	(21, 5, 5, 7),
	(22, 5, 6, 7),
	(23, 5, 4, 2),
	(24, 5, 3, 6),
	(25, 5, 7, 6),
	(26, 6, 5, 2),
	(27, 6, 6, 2),
	(28, 6, 4, 1),
	(29, 6, 3, 6),
	(30, 6, 7, 6),
	(31, 7, 5, 3),
	(32, 7, 6, 3),
	(33, 7, 4, 2),
	(34, 7, 3, 6),
	(35, 7, 7, 6),
	(36, 8, 5, 1),
	(37, 8, 6, 1),
	(38, 8, 4, 1),
	(39, 8, 3, 6),
	(40, 8, 7, 6),
	(41, 9, 5, 3),
	(42, 9, 6, 3),
	(43, 9, 4, 2),
	(44, 9, 3, 6),
	(45, 9, 7, 6),
	(46, 10, 5, 7),
	(47, 10, 6, 7),
	(48, 10, 4, 2),
	(49, 10, 3, 6),
	(50, 10, 7, 6),
	(51, 11, 5, 1),
	(52, 11, 6, 1),
	(53, 11, 4, 1),
	(54, 11, 3, 6),
	(55, 11, 7, 6),
	(56, 12, 5, 2),
	(57, 12, 6, 2),
	(58, 12, 4, 2),
	(59, 12, 3, 6),
	(60, 12, 7, 6),
	(61, 13, 5, 3),
	(62, 13, 6, 3),
	(63, 13, 4, 2),
	(64, 13, 3, 6),
	(65, 13, 7, 6),
	(66, 14, 5, 3),
	(67, 14, 6, 3),
	(68, 14, 4, 1),
	(69, 14, 3, 6),
	(70, 14, 7, 6),
	(71, 15, 5, 1),
	(72, 15, 6, 1),
	(73, 15, 4, 1),
	(74, 15, 3, 6),
	(75, 15, 7, 6),
	(76, 16, 5, 2),
	(77, 16, 6, 2),
	(78, 16, 4, 2),
	(79, 16, 3, 6),
	(80, 16, 7, 6),
	(81, 17, 5, 7),
	(82, 17, 6, 7),
	(83, 17, 4, 1),
	(84, 17, 3, 4),
	(85, 17, 7, 6),
	(86, 18, 5, 3),
	(87, 18, 6, 3),
	(88, 18, 4, 2),
	(89, 18, 3, 4),
	(90, 18, 7, 6),
	(91, 19, 5, 2),
	(92, 19, 6, 2),
	(93, 19, 4, 1),
	(94, 19, 3, 8),
	(95, 19, 7, 6),
	(96, 20, 5, 3),
	(97, 20, 6, 2),
	(98, 20, 4, 2),
	(99, 20, 3, 8),
	(100, 20, 7, 6),
	(101, 21, 5, 2),
	(102, 22, 5, 1),
	(103, 23, 5, 1),
	(104, 23, 6, 1),
	(105, 23, 4, 2),
	(106, 23, 3, 8),
	(107, 23, 7, 6),
	(108, 24, 5, 3),
	(109, 25, 5, 2),
	(110, 25, 6, 2),
	(111, 25, 4, 1),
	(112, 25, 3, 4),
	(113, 25, 7, 6),
	(114, 26, 5, 7),
	(115, 27, 5, 2),
	(116, 28, 5, 3),
	(117, 28, 6, 3),
	(118, 28, 4, 2),
	(119, 28, 3, 8),
	(120, 28, 7, 6),
	(121, 29, 5, 1),
	(122, 30, 5, 7),
	(123, 30, 6, 7),
	(124, 30, 4, 1),
	(125, 30, 3, 4),
	(126, 30, 7, 6),
	(127, 31, 5, 2),
	(128, 31, 6, 2),
	(129, 31, 4, 1),
	(130, 31, 3, 6),
	(131, 31, 7, 6),
	(132, 32, 5, 3),
	(133, 33, 5, 7),
	(134, 33, 6, 3),
	(135, 33, 4, 1),
	(136, 33, 3, 6),
	(137, 33, 7, 6),
	(138, 34, 5, 7),
	(139, 34, 6, 7),
	(140, 34, 4, 2),
	(141, 34, 3, 6),
	(142, 34, 7, 6),
	(143, 35, 5, 3),
	(144, 36, 5, 2),
	(145, 36, 6, 2),
	(146, 36, 4, 2),
	(147, 36, 3, 6),
	(148, 36, 7, 6),
	(149, 37, 5, 3),
	(150, 37, 6, 1),
	(151, 37, 4, 1),
	(152, 37, 3, 6),
	(153, 37, 7, 6),
	(154, 38, 5, 2),
	(155, 39, 5, 1),
	(156, 39, 6, 3),
	(157, 39, 4, 1),
	(158, 39, 3, 6),
	(159, 39, 7, 6),
	(160, 40, 5, 1),
	(161, 40, 6, 3),
	(162, 40, 4, 2),
	(163, 40, 3, 6),
	(164, 40, 7, 6),
	(165, 41, 5, 2),
	(166, 42, 5, 3),
	(167, 42, 6, 7),
	(168, 42, 4, 2),
	(169, 42, 3, 6),
	(170, 42, 7, 6),
	(171, 43, 5, 2),
	(172, 43, 6, 2),
	(173, 43, 4, 2),
	(174, 43, 3, 6),
	(175, 43, 7, 6),
	(176, 44, 5, 3),
	(177, 44, 6, 3),
	(178, 44, 4, 1),
	(179, 44, 3, 6),
	(180, 44, 7, 6),
	(181, 45, 5, 7),
	(182, 45, 6, 7),
	(183, 45, 4, 6),
	(184, 45, 3, 6),
	(185, 45, 7, 6),
	(186, 46, 5, 1),
	(187, 46, 6, 1),
	(188, 46, 4, 6),
	(189, 46, 3, 6),
	(190, 46, 7, 6),
	(191, 47, 5, 1),
	(192, 47, 6, 1),
	(193, 47, 4, 6),
	(194, 47, 3, 6),
	(195, 47, 7, 6),
	(196, 48, 5, 7),
	(197, 48, 6, 7),
	(198, 48, 4, 6),
	(199, 48, 3, 6),
	(200, 48, 7, 6),
	(201, 49, 5, 3),
	(202, 49, 6, 3),
	(203, 49, 4, 1),
	(204, 49, 3, 6),
	(205, 49, 7, 6),
	(206, 50, 5, 2),
	(207, 50, 6, 2),
	(208, 50, 4, 2),
	(209, 50, 3, 6),
	(210, 50, 7, 6),
	(211, 51, 5, 2),
	(212, 51, 6, 2),
	(213, 51, 4, 6),
	(214, 51, 3, 6),
	(215, 51, 7, 6),
	(216, 52, 5, 3),
	(217, 52, 6, 3),
	(218, 52, 4, 6),
	(219, 52, 3, 6),
	(220, 52, 7, 6),
	(221, 53, 5, 1),
	(222, 53, 6, 1),
	(223, 53, 4, 6),
	(224, 53, 3, 6),
	(225, 53, 7, 6),
	(226, 54, 5, 7),
	(227, 54, 6, 7),
	(228, 54, 4, 6),
	(229, 54, 3, 6),
	(230, 54, 7, 6),
	(231, 55, 5, 1),
	(232, 55, 6, 1),
	(233, 55, 4, 1),
	(234, 55, 3, 6),
	(235, 55, 7, 6),
	(236, 56, 5, 2),
	(237, 56, 6, 2),
	(238, 56, 4, 1),
	(239, 56, 3, 6),
	(240, 56, 7, 6);
/*!40000 ALTER TABLE `Architecture_to_VehicleLayout` ENABLE KEYS */;

-- Дамп структуры для таблица PowerDistributionData.Consumers
DROP TABLE IF EXISTS `Consumers`;
CREATE TABLE IF NOT EXISTS `Consumers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT 'Название потребителя ["Закрылки лев."]',
  `aircraftPart_id` int(10) unsigned DEFAULT NULL,
  `efficiencyHydro` float unsigned NOT NULL COMMENT 'КПД гидро',
  `efficiencyElectric` float unsigned NOT NULL COMMENT 'КПД электро',
  `q0` float unsigned NOT NULL COMMENT 'Q0',
  `qMax` float unsigned NOT NULL COMMENT 'Q потр',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `FK_Consumers_AircraftParts` (`aircraftPart_id`),
  CONSTRAINT `FK_Consumers_AircraftParts` FOREIGN KEY (`aircraftPart_id`) REFERENCES `AircraftParts` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.Consumers: ~56 rows (приблизительно)
/*!40000 ALTER TABLE `Consumers` DISABLE KEYS */;
INSERT INTO `Consumers` (`id`, `name`, `aircraftPart_id`, `efficiencyHydro`, `efficiencyElectric`, `q0`, `qMax`) VALUES
	(1, 'ПОШ (уборка/выпуск)', 3, 0.55, 0.85, 0.5, 10),
	(2, 'ПОШ (руление) 1 кан.', 3, 0.5, 0.85, 0.5, 10),
	(3, 'ПОШ (руление) 2 кан.', 3, 0.5, 0.85, 0.5, 10),
	(4, 'Закрылки лев.', 1, 0.4, 0.85, 0.5, 40),
	(5, 'Закрылки пр.', 1, 0.4, 0.85, 0.5, 40),
	(6, 'Предкрылки лев.', 1, 0.4, 0.85, 0.5, 21),
	(7, 'Предкрылки пр.', 1, 0.4, 0.85, 0.5, 21),
	(8, 'ЛООШ (уборка/выпуск)', 1, 0.55, 0.85, 0.5, 25),
	(9, 'ЦООШ (уборка/выпуск)', 1, 0.55, 0.85, 0.5, 25),
	(10, 'ПООШ (уборка/выпуск)', 1, 0.55, 0.85, 0.5, 25),
	(11, 'ЛООШ (торможение, перед.)', 1, 0.5, 0.8, 0.5, 10),
	(12, 'ЛООШ (торможение, зад.)', 1, 0.5, 0.8, 0.5, 10),
	(13, 'ЦООШ (торможение, перед.)', 1, 0.5, 0.8, 0.5, 10),
	(14, 'ЦООШ (торможение, зад.)', 1, 0.5, 0.8, 0.5, 10),
	(15, 'ПООШ (торможение, перед.)', 1, 0.5, 0.8, 0.5, 10),
	(16, 'ПООШ (торможение, зад.)', 1, 0.5, 0.8, 0.5, 10),
	(17, 'РН верхний 1', 2, 0.5, 0.85, 0.665, 20),
	(18, 'РН верхний 2', 2, 0.5, 0.85, 0.665, 20),
	(19, 'РН верхний 3', 2, 0.5, 0.85, 0.665, 20),
	(20, 'РН нижний 1', 2, 0.5, 0.85, 0.665, 20),
	(21, 'РН нижний 2', 2, 0.5, 0.85, 0.665, 20),
	(22, 'РН нижний 3', 2, 0.5, 0.85, 0.665, 20),
	(23, 'РВ левый внеш. 1', 2, 0.5, 0.85, 0.55, 20),
	(24, 'РВ левый внеш. 2', 2, 0.5, 0.85, 0.55, 20),
	(25, 'РВ левый внутр. 1', 2, 0.5, 0.85, 0.55, 20),
	(26, 'РВ левый внутр. 2', 2, 0.5, 0.85, 0.55, 20),
	(27, 'РВ правый внутр. 2', 2, 0.5, 0.85, 0.55, 20),
	(28, 'РВ правый внутр. 1', 2, 0.5, 0.85, 0.55, 20),
	(29, 'РВ правый внеш. 2', 2, 0.5, 0.85, 0.55, 20),
	(30, 'РВ правый внеш. 1', 2, 0.5, 0.85, 0.55, 20),
	(31, 'Элерон внутр. лев. внеш.', 1, 0.5, 0.85, 0.62, 20),
	(32, 'Элерон внутр. лев. центр.', 1, 0.5, 0.85, 0.55, 20),
	(33, 'Элерон внутр. лев. внутр.', 1, 0.5, 0.85, 0.62, 20),
	(34, 'Элерон внутр. прав. внутр.', 1, 0.5, 0.85, 0.62, 20),
	(35, 'Элерон внутр. прав. центр.', 1, 0.5, 0.85, 0.55, 20),
	(36, 'Элерон внутр. прав. внеш.', 1, 0.5, 0.85, 0.62, 20),
	(37, 'Элерон внеш. лев. внеш.', 1, 0.5, 0.85, 0.62, 20),
	(38, 'Элерон внеш. лев. центр.', 1, 0.5, 0.85, 0.55, 20),
	(39, 'Элерон внеш. лев. внутр.', 1, 0.5, 0.85, 0.62, 20),
	(40, 'Элерон внеш. прав. внутр.', 1, 0.5, 0.85, 0.62, 20),
	(41, 'Элерон внеш. прав. центр.', 1, 0.5, 0.85, 0.55, 20),
	(42, 'Элерон внеш. прав. внеш.', 1, 0.5, 0.85, 0.62, 20),
	(43, 'Интерцептор 4 лев.', 1, 0.5, 0.85, 0.595, 25),
	(44, 'Интерцептор 3 лев.', 1, 0.5, 0.85, 0.595, 25),
	(45, 'Интерцептор 2 лев.', 1, 0.5, 0.85, 0.595, 25),
	(46, 'Интерцептор 1 лев.', 1, 0.5, 0.85, 0.595, 25),
	(47, 'Интерцептор 1 пр.', 1, 0.5, 0.85, 0.595, 25),
	(48, 'Интерцептор 2 пр.', 1, 0.5, 0.85, 0.595, 25),
	(49, 'Интерцептор 3 пр.', 1, 0.5, 0.85, 0.595, 25),
	(50, 'Интерцептор 4 пр.', 1, 0.5, 0.85, 0.595, 25),
	(51, 'Стабилизатор верхн. лев.', 2, 0.4, 0.85, 0.5, 21),
	(52, 'Стабилизатор верхн. прав.', 2, 0.4, 0.85, 0.5, 21),
	(53, 'Стабилизатор нижн. лев.', 2, 0.4, 0.85, 0.5, 21),
	(54, 'Стабилизатор нижн. прав.', 2, 0.4, 0.85, 0.5, 21),
	(55, 'Реверс тяги лев. 1', 1, 0.55, 0.85, 0.5, 36),
	(56, 'Реверс тяги лев. 2', 1, 0.55, 0.85, 0.5, 36);
/*!40000 ALTER TABLE `Consumers` ENABLE KEYS */;

-- Дамп структуры для таблица PowerDistributionData.EnergySources
DROP TABLE IF EXISTS `EnergySources`;
CREATE TABLE IF NOT EXISTS `EnergySources` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Название источника энергии ["ГС1", "ЛГС3", "ЭС1"]',
  `energySourceType_id` int(10) unsigned NOT NULL COMMENT 'Является ли электросистемой',
  `qMax` float unsigned DEFAULT NULL COMMENT 'Qmax для расчёта Q располагаемого',
  `pumpPressureNominal` float unsigned DEFAULT NULL COMMENT 'Pнас ном',
  `pumpPressureWorkQmax` float unsigned DEFAULT NULL COMMENT 'Pнас раб при Qmax',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `FK_EnergySources_EnergySourceTypes` (`energySourceType_id`),
  CONSTRAINT `FK_EnergySources_EnergySourceTypes` FOREIGN KEY (`energySourceType_id`) REFERENCES `energysourcetypes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.EnergySources: ~8 rows (приблизительно)
/*!40000 ALTER TABLE `EnergySources` DISABLE KEYS */;
INSERT INTO `EnergySources` (`id`, `name`, `energySourceType_id`, `qMax`, `pumpPressureNominal`, `pumpPressureWorkQmax`) VALUES
	(1, 'ГС1', 1, 180, 211, 195),
	(2, 'ГС2', 1, 180, 211, 195),
	(3, 'ГС3', 2, 180, 211, 195),
	(4, 'ЛГС1', 3, 50, 211, 195),
	(5, 'ЛГС3', 3, 10, 211, 195),
	(6, 'ЭС', 4, NULL, NULL, NULL),
	(7, 'ГС4', 1, 180, 211, 195),
	(8, 'ЛГС2', 3, 50, 211, 195);
/*!40000 ALTER TABLE `EnergySources` ENABLE KEYS */;

-- Дамп структуры для таблица PowerDistributionData.EnergySourceTypes
DROP TABLE IF EXISTS `EnergySourceTypes`;
CREATE TABLE IF NOT EXISTS `EnergySourceTypes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Название источника энергии ["Гидросистема", "Электросистема"]',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.EnergySourceTypes: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `EnergySourceTypes` DISABLE KEYS */;
INSERT INTO `EnergySourceTypes` (`id`, `name`) VALUES
	(1, 'Гидросистема'),
	(2, 'Гидроэлектросистема'),
	(3, 'Зональная гидроэлектросистема'),
	(4, 'Электросистема');
/*!40000 ALTER TABLE `EnergySourceTypes` ENABLE KEYS */;

-- Дамп структуры для таблица PowerDistributionData.FlightModes
DROP TABLE IF EXISTS `FlightModes`;
CREATE TABLE IF NOT EXISTS `FlightModes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT 'Название режима полета ["Руление", "Взлёт"]',
  `reductionFactor` float unsigned DEFAULT NULL COMMENT 'Коэффициент понижения оборотов',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.FlightModes: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `FlightModes` DISABLE KEYS */;
INSERT INTO `FlightModes` (`id`, `name`, `reductionFactor`) VALUES
	(1, 'Взлёт', 1),
	(2, 'Крейсер', 0.85),
	(3, 'Посадка', 0.6),
	(4, 'Руление', 0.6);
/*!40000 ALTER TABLE `FlightModes` ENABLE KEYS */;

-- Дамп структуры для таблица PowerDistributionData.FlightModes_to_VehicleLayout
DROP TABLE IF EXISTS `FlightModes_to_VehicleLayout`;
CREATE TABLE IF NOT EXISTS `FlightModes_to_VehicleLayout` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vehicleLayout_id` int(10) unsigned NOT NULL,
  `flightMode_id` int(10) unsigned NOT NULL,
  `usageFactor` float unsigned DEFAULT NULL COMMENT 'На сколько задействован потребитель [0..1]',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `FK_FlightModes_to_VehicleLayout_VehicleLayout` (`vehicleLayout_id`),
  KEY `FK_FlightModes_to_VehicleLayout_FlightModes` (`flightMode_id`),
  CONSTRAINT `FK_FlightModes_to_VehicleLayout_FlightModes` FOREIGN KEY (`flightMode_id`) REFERENCES `FlightModes` (`id`),
  CONSTRAINT `FK_FlightModes_to_VehicleLayout_VehicleLayout` FOREIGN KEY (`vehicleLayout_id`) REFERENCES `VehicleLayout` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.FlightModes_to_VehicleLayout: ~56 rows (приблизительно)
/*!40000 ALTER TABLE `FlightModes_to_VehicleLayout` DISABLE KEYS */;
INSERT INTO `FlightModes_to_VehicleLayout` (`id`, `vehicleLayout_id`, `flightMode_id`, `usageFactor`) VALUES
	(1, 1, 4, 0),
	(2, 2, 4, 1),
	(3, 3, 4, 1),
	(4, 4, 4, 0),
	(5, 5, 4, 0),
	(6, 6, 4, 0),
	(7, 7, 4, 0),
	(8, 8, 4, 0),
	(9, 9, 4, 0),
	(10, 10, 4, 0),
	(11, 11, 4, 0.5),
	(12, 12, 4, 0.5),
	(13, 13, 4, 0.5),
	(14, 14, 4, 0.5),
	(15, 15, 4, 0.5),
	(16, 16, 4, 0.5),
	(17, 17, 4, 0.1),
	(18, 18, 4, 0.1),
	(19, 19, 4, 0.1),
	(20, 20, 4, 0.1),
	(21, 21, 4, 0.1),
	(22, 22, 4, 0.1),
	(23, 23, 4, 0),
	(24, 24, 4, 0),
	(25, 25, 4, 0),
	(26, 26, 4, 0),
	(27, 27, 4, 0),
	(28, 28, 4, 0),
	(29, 29, 4, 0),
	(30, 30, 4, 0),
	(31, 31, 4, 0),
	(32, 32, 4, 0),
	(33, 33, 4, 0),
	(34, 34, 4, 0),
	(35, 35, 4, 0),
	(36, 36, 4, 0),
	(37, 37, 4, 0),
	(38, 38, 4, 0),
	(39, 39, 4, 0),
	(40, 40, 4, 0),
	(41, 41, 4, 0),
	(42, 42, 4, 0),
	(43, 43, 4, 0),
	(44, 44, 4, 0),
	(45, 45, 4, 0),
	(46, 46, 4, 0),
	(47, 47, 4, 0),
	(48, 48, 4, 0),
	(49, 49, 4, 0),
	(50, 50, 4, 0),
	(51, 51, 4, 0),
	(52, 52, 4, 0),
	(53, 53, 4, 0),
	(54, 54, 4, 0),
	(55, 55, 4, 0),
	(56, 56, 4, 0);
/*!40000 ALTER TABLE `FlightModes_to_VehicleLayout` ENABLE KEYS */;

-- Дамп структуры для таблица PowerDistributionData.PumpEfficiency
DROP TABLE IF EXISTS `PumpEfficiency`;
CREATE TABLE IF NOT EXISTS `PumpEfficiency` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `QCurQmax` float unsigned DEFAULT NULL COMMENT 'Qтек/Qmax',
  `pumpEfficiency` float unsigned DEFAULT NULL COMMENT 'КПД насоса',
  `pumpEfficiencyRK` float unsigned DEFAULT NULL COMMENT 'КПД насоса + РК',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `QCurQmax_UNIQUE` (`QCurQmax`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.PumpEfficiency: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `PumpEfficiency` DISABLE KEYS */;
/*!40000 ALTER TABLE `PumpEfficiency` ENABLE KEYS */;

-- Дамп структуры для таблица PowerDistributionData.ResultsConsumers
DROP TABLE IF EXISTS `ResultsConsumers`;
CREATE TABLE IF NOT EXISTS `ResultsConsumers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vehicleLayoutName_id` int(10) unsigned NOT NULL,
  `architectureName_id` int(10) unsigned NOT NULL,
  `flightMode_id` int(10) unsigned NOT NULL,
  `consumer_id` int(10) unsigned NOT NULL,
  `consumption` double DEFAULT NULL COMMENT 'Расход',
  `P_in` double DEFAULT NULL COMMENT 'Pin',
  `N_in_hydro` double DEFAULT NULL COMMENT 'Nin_гс',
  `N_out` double DEFAULT NULL COMMENT 'Nвых',
  `N_in_electric` double DEFAULT NULL COMMENT 'Nin_эс',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `FK_ResultsConsumers_VehiclesLayoutsNames` (`vehicleLayoutName_id`),
  KEY `FK_ResultsConsumers_ArchitecturesNames` (`architectureName_id`),
  KEY `FK_ResultsConsumers_FlightModes` (`flightMode_id`),
  KEY `FK_ResultsConsumers_Consumers` (`consumer_id`),
  CONSTRAINT `FK_ResultsConsumers_ArchitecturesNames` FOREIGN KEY (`architectureName_id`) REFERENCES `ArchitecturesNames` (`id`),
  CONSTRAINT `FK_ResultsConsumers_Consumers` FOREIGN KEY (`consumer_id`) REFERENCES `Consumers` (`id`),
  CONSTRAINT `FK_ResultsConsumers_FlightModes` FOREIGN KEY (`flightMode_id`) REFERENCES `FlightModes` (`id`),
  CONSTRAINT `FK_ResultsConsumers_VehiclesLayoutsNames` FOREIGN KEY (`vehicleLayoutName_id`) REFERENCES `VehiclesLayoutsNames` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=450 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.ResultsConsumers: ~65 rows (приблизительно)
/*!40000 ALTER TABLE `ResultsConsumers` DISABLE KEYS */;
INSERT INTO `ResultsConsumers` (`id`, `vehicleLayoutName_id`, `architectureName_id`, `flightMode_id`, `consumer_id`, `consumption`, `P_in`, `N_in_hydro`, `N_out`, `N_in_electric`) VALUES
	(386, 1, 5, 4, 1, 0.5, 195.46708148148, 0.15973977121753, 0, NULL),
	(387, 1, 5, 4, 2, 10, 194.07448888889, 3.1720343107704, 1.5860171553852, NULL),
	(388, 1, 5, 4, 3, 10, 194.57582222222, 3.1802283116593, 1.5901141558296, NULL),
	(389, 1, 5, 4, 4, 0.5, 194.07448888889, 0.15860171553852, 0, NULL),
	(390, 1, 5, 4, 5, 0.5, 197.36100740741, 0.16128752694099, 0, NULL),
	(391, 1, 5, 4, 6, 0.5, 194.07448888889, 0.15860171553852, 0, NULL),
	(392, 1, 5, 4, 7, 0.5, 195.46708148148, 0.15973977121753, 0, NULL),
	(393, 1, 5, 4, 8, 0.5, 194.57582222222, 0.15901141558296, 0, NULL),
	(394, 1, 5, 4, 9, 0.5, 195.46708148148, 0.15973977121753, 0, NULL),
	(395, 1, 5, 4, 10, 0.5, 197.36100740741, 0.16128752694099, 0, NULL),
	(396, 1, 5, 4, 11, 5, 194.57582222222, 1.5901141558296, 0.79505707791481, NULL),
	(397, 1, 5, 4, 12, 5, 194.07448888889, 1.5860171553852, 0.79300857769259, NULL),
	(398, 1, 5, 4, 13, 5, 195.46708148148, 1.5973977121753, 0.79869885608765, NULL),
	(399, 1, 5, 4, 14, 5, 195.46708148148, 1.5973977121753, 0.79869885608765, NULL),
	(400, 1, 5, 4, 15, 5, 194.57582222222, 1.5901141558296, 0.79505707791481, NULL),
	(401, 1, 5, 4, 16, 5, 194.07448888889, 1.5860171553852, 0.79300857769259, NULL),
	(402, 1, 5, 4, 17, 2, 197.36100740741, 0.64515010776395, 0.32257505388198, NULL),
	(403, 1, 5, 4, 18, 2, 195.46708148148, 0.63895908487012, 0.31947954243506, NULL),
	(404, 1, 5, 4, 19, 2, 194.07448888889, 0.63440686215407, 0.31720343107704, NULL),
	(405, 1, 5, 4, 20, 2, 195.46708148148, 0.63895908487012, 0.31947954243506, NULL),
	(406, 1, 5, 4, 21, 2, 194.07448888889, 0.63440686215407, 0.31720343107704, NULL),
	(407, 1, 5, 4, 22, 2, 194.57582222222, 0.63604566233185, 0.31802283116593, NULL),
	(408, 1, 5, 4, 23, 0.55, 194.57582222222, 0.17491255714126, 0, NULL),
	(409, 1, 5, 4, 24, 0.55, 195.46708148148, 0.17571374833928, 0, NULL),
	(410, 1, 5, 4, 25, 0.55, 194.07448888889, 0.17446188709237, 0, NULL),
	(411, 1, 5, 4, 26, 0.55, 197.36100740741, 0.17741627963509, 0, NULL),
	(412, 1, 5, 4, 27, 0.55, 194.07448888889, 0.17446188709237, 0, NULL),
	(413, 1, 5, 4, 28, 0.55, 195.46708148148, 0.17571374833928, 0, NULL),
	(414, 1, 5, 4, 29, 0.55, 194.57582222222, 0.17491255714126, 0, NULL),
	(415, 1, 5, 4, 30, 0.55, 197.36100740741, 0.17741627963509, 0, NULL),
	(416, 1, 5, 4, 31, 0.62, 194.07448888889, 0.19666612726776, 0, NULL),
	(417, 1, 5, 4, 32, 0.55, 195.46708148148, 0.17571374833928, 0, NULL),
	(418, 1, 5, 4, 33, 0.62, 197.36100740741, 0.19999653340682, 0, NULL),
	(419, 1, 5, 4, 34, 0.62, 197.36100740741, 0.19999653340682, 0, NULL),
	(420, 1, 5, 4, 35, 0.55, 195.46708148148, 0.17571374833928, 0, NULL),
	(421, 1, 5, 4, 36, 0.62, 194.07448888889, 0.19666612726776, 0, NULL),
	(422, 1, 5, 4, 37, 0.62, 195.46708148148, 0.19807731630974, 0, NULL),
	(423, 1, 5, 4, 38, 0.55, 194.07448888889, 0.17446188709237, 0, NULL),
	(424, 1, 5, 4, 39, 0.62, 194.57582222222, 0.19717415532287, 0, NULL),
	(425, 1, 5, 4, 40, 0.62, 194.57582222222, 0.19717415532287, 0, NULL),
	(426, 1, 5, 4, 41, 0.55, 194.07448888889, 0.17446188709237, 0, NULL),
	(427, 1, 5, 4, 42, 0.62, 195.46708148148, 0.19807731630974, 0, NULL),
	(428, 1, 5, 4, 43, 0.595, 194.07448888889, 0.18873604149084, 0, NULL),
	(429, 1, 5, 4, 44, 0.595, 195.46708148148, 0.19009032774886, 0, NULL),
	(430, 1, 5, 4, 45, 0.595, 197.36100740741, 0.19193215705978, 0, NULL),
	(431, 1, 4, 4, 45, NULL, NULL, NULL, NULL, 0),
	(432, 1, 5, 4, 46, 0.595, 194.57582222222, 0.18922358454373, 0, NULL),
	(433, 1, 4, 4, 46, NULL, NULL, NULL, NULL, 0),
	(434, 1, 5, 4, 47, 0.595, 194.57582222222, 0.18922358454373, 0, NULL),
	(435, 1, 4, 4, 47, NULL, NULL, NULL, NULL, 0),
	(436, 1, 5, 4, 48, 0.595, 197.36100740741, 0.19193215705978, 0, NULL),
	(437, 1, 4, 4, 48, NULL, NULL, NULL, NULL, 0),
	(438, 1, 5, 4, 49, 0.595, 195.46708148148, 0.19009032774886, 0, NULL),
	(439, 1, 5, 4, 50, 0.595, 194.07448888889, 0.18873604149084, 0, NULL),
	(440, 1, 5, 4, 51, 0.5, 194.07448888889, 0.15860171553852, 0, NULL),
	(441, 1, 4, 4, 51, NULL, NULL, NULL, NULL, 0),
	(442, 1, 5, 4, 52, 0.5, 195.46708148148, 0.15973977121753, 0, NULL),
	(443, 1, 4, 4, 52, NULL, NULL, NULL, NULL, 0),
	(444, 1, 5, 4, 53, 0.5, 194.57582222222, 0.15901141558296, 0, NULL),
	(445, 1, 4, 4, 53, NULL, NULL, NULL, NULL, 0),
	(446, 1, 5, 4, 54, 0.5, 197.36100740741, 0.16128752694099, 0, NULL),
	(447, 1, 4, 4, 54, NULL, NULL, NULL, NULL, 0),
	(448, 1, 5, 4, 55, 0.5, 194.57582222222, 0.15901141558296, 0, NULL),
	(449, 1, 5, 4, 56, 0.5, 194.07448888889, 0.15860171553852, 0, NULL);
/*!40000 ALTER TABLE `ResultsConsumers` ENABLE KEYS */;

-- Дамп структуры для таблица PowerDistributionData.ResultsEnergySources
DROP TABLE IF EXISTS `ResultsEnergySources`;
CREATE TABLE IF NOT EXISTS `ResultsEnergySources` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vehicleLayoutName_id` int(10) unsigned NOT NULL,
  `architectureName_id` int(10) unsigned NOT NULL,
  `flightMode_id` int(10) unsigned NOT NULL,
  `energySource_id` int(10) unsigned NOT NULL,
  `Qpump` double DEFAULT NULL COMMENT 'Q нас',
  `Qdisposable` double DEFAULT NULL COMMENT 'Q распол',
  `P_pump_out` double DEFAULT NULL COMMENT 'P нас вых',
  `Q_curr_to_Q_max` double DEFAULT NULL COMMENT 'Qтек/Qmax',
  `N_pump_out` double DEFAULT NULL COMMENT 'N нас вых',
  `N_pump_in` double DEFAULT NULL COMMENT 'N нас вх',
  `N_consumers_in_hydro` double DEFAULT NULL COMMENT 'Nпотр_вх_гс',
  `N_consumers_out` double DEFAULT NULL COMMENT 'Nпотр_вых',
  `N_electric_total` double DEFAULT NULL COMMENT 'Nэс_всего',
  `N_takeoff` double DEFAULT NULL COMMENT 'Nотбора',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `FK_ResultsEnergySources_VehiclesLayoutsNames` (`vehicleLayoutName_id`),
  KEY `FK_ResultsEnergySources_ArchitecturesNames` (`architectureName_id`),
  KEY `FK_ResultsEnergySources_FlightModes` (`flightMode_id`),
  KEY `FK_ResultsEnergySources_EnergySources` (`energySource_id`),
  CONSTRAINT `FK_ResultsEnergySources_ArchitecturesNames` FOREIGN KEY (`architectureName_id`) REFERENCES `ArchitecturesNames` (`id`),
  CONSTRAINT `FK_ResultsEnergySources_EnergySources` FOREIGN KEY (`energySource_id`) REFERENCES `EnergySources` (`id`),
  CONSTRAINT `FK_ResultsEnergySources_FlightModes` FOREIGN KEY (`flightMode_id`) REFERENCES `FlightModes` (`id`),
  CONSTRAINT `FK_ResultsEnergySources_VehiclesLayoutsNames` FOREIGN KEY (`vehicleLayoutName_id`) REFERENCES `VehiclesLayoutsNames` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.ResultsEnergySources: ~9 rows (приблизительно)
/*!40000 ALTER TABLE `ResultsEnergySources` DISABLE KEYS */;
INSERT INTO `ResultsEnergySources` (`id`, `vehicleLayoutName_id`, `architectureName_id`, `flightMode_id`, `energySource_id`, `Qpump`, `Qdisposable`, `P_pump_out`, `Q_curr_to_Q_max`, `N_pump_out`, `N_pump_in`, `N_consumers_in_hydro`, `N_consumers_out`, `N_electric_total`, `N_takeoff`) VALUES
	(51, 1, 5, 4, 1, 27.03, 108, 206.99555555556, 0.25027777777778, 9.1448480068244, 10.333161589632, 8.596157126415, 3.4982511428252, 0, 10.992725095353),
	(52, 1, 4, 4, 1, 36.77, 108, 205.55259259259, 0.34046296296296, 12.353386058848, 13.958628315082, 11.714952008943, 4.6187056527059, 0, 14.849604590513),
	(53, 1, 5, 4, 2, 30.63, 108, 206.46222222222, 0.28361111111111, 10.336107546691, 11.679217566883, 9.7159410938896, 3.8064411729244, 0, 12.424699539237),
	(54, 1, 4, 4, 2, 35.77, 108, 205.70074074074, 0.3312037037037, 12.026083666959, 13.588795103908, 11.381451620543, 4.6096922517281, 0, 14.456165004158),
	(55, 1, 5, 4, 3, 20.63, 108, 207.9437037037, 0.19101851851852, 7.0115563408886, 7.9226625320776, 6.5908629604353, 2.2363567970454, 0, 10.058914423949),
	(56, 1, 5, 4, 7, 7.03, 108, 209.95851851852, 0.065092592592593, 2.412449605096, 2.7259317571707, 2.2677026287903, 0.32257505388198, 0, 2.8999274012454),
	(57, 1, 4, 4, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0);
/*!40000 ALTER TABLE `ResultsEnergySources` ENABLE KEYS */;

-- Дамп структуры для таблица PowerDistributionData.VehicleLayout
DROP TABLE IF EXISTS `VehicleLayout`;
CREATE TABLE IF NOT EXISTS `VehicleLayout` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vehicleLayoutName_id` int(10) unsigned NOT NULL,
  `consumer_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `FK_VehicleLayout_VehiclesLayoutsNames` (`vehicleLayoutName_id`),
  KEY `FK_VehicleLayout_Consumers` (`consumer_id`),
  CONSTRAINT `FK_VehicleLayout_Consumers` FOREIGN KEY (`consumer_id`) REFERENCES `Consumers` (`id`),
  CONSTRAINT `FK_VehicleLayout_VehiclesLayoutsNames` FOREIGN KEY (`vehicleLayoutName_id`) REFERENCES `VehiclesLayoutsNames` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.VehicleLayout: ~56 rows (приблизительно)
/*!40000 ALTER TABLE `VehicleLayout` DISABLE KEYS */;
INSERT INTO `VehicleLayout` (`id`, `vehicleLayoutName_id`, `consumer_id`) VALUES
	(1, 1, 1),
	(2, 1, 2),
	(3, 1, 3),
	(4, 1, 4),
	(5, 1, 5),
	(6, 1, 6),
	(7, 1, 7),
	(8, 1, 8),
	(9, 1, 9),
	(10, 1, 10),
	(11, 1, 11),
	(12, 1, 12),
	(13, 1, 13),
	(14, 1, 14),
	(15, 1, 15),
	(16, 1, 16),
	(17, 1, 17),
	(18, 1, 18),
	(19, 1, 19),
	(20, 1, 20),
	(21, 1, 21),
	(22, 1, 22),
	(23, 1, 23),
	(24, 1, 24),
	(25, 1, 25),
	(26, 1, 26),
	(27, 1, 27),
	(28, 1, 28),
	(29, 1, 29),
	(30, 1, 30),
	(31, 1, 31),
	(32, 1, 32),
	(33, 1, 33),
	(34, 1, 34),
	(35, 1, 35),
	(36, 1, 36),
	(37, 1, 37),
	(38, 1, 38),
	(39, 1, 39),
	(40, 1, 40),
	(41, 1, 41),
	(42, 1, 42),
	(43, 1, 43),
	(44, 1, 44),
	(45, 1, 45),
	(46, 1, 46),
	(47, 1, 47),
	(48, 1, 48),
	(49, 1, 49),
	(50, 1, 50),
	(51, 1, 51),
	(52, 1, 52),
	(53, 1, 53),
	(54, 1, 54),
	(55, 1, 55),
	(56, 1, 56);
/*!40000 ALTER TABLE `VehicleLayout` ENABLE KEYS */;

-- Дамп структуры для таблица PowerDistributionData.Vehicles
DROP TABLE IF EXISTS `Vehicles`;
CREATE TABLE IF NOT EXISTS `Vehicles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT 'Название аппарата ["B737", "Дрон 1", "МС-21 Базовый"]',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.Vehicles: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `Vehicles` DISABLE KEYS */;
INSERT INTO `Vehicles` (`id`, `name`) VALUES
	(2, 'Sukhoi Superjet 100'),
	(1, 'МС-21');
/*!40000 ALTER TABLE `Vehicles` ENABLE KEYS */;

-- Дамп структуры для таблица PowerDistributionData.VehiclesLayoutsNames
DROP TABLE IF EXISTS `VehiclesLayoutsNames`;
CREATE TABLE IF NOT EXISTS `VehiclesLayoutsNames` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vehicle_id` int(10) unsigned NOT NULL,
  `name` varchar(255) DEFAULT NULL COMMENT 'Название модели (компоновки) ["Базовая модель", "Детальная модель"]',
  `usingArchitectures` varchar(255) DEFAULT NULL COMMENT 'id используемых архитектур через пробел',
  `usingFlightModes` varchar(255) DEFAULT NULL COMMENT 'id используемых режимов полета через пробел',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `FK_VehiclesLayoutsNames_Vehicles` (`vehicle_id`),
  CONSTRAINT `FK_VehiclesLayoutsNames_Vehicles` FOREIGN KEY (`vehicle_id`) REFERENCES `Vehicles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.VehiclesLayoutsNames: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `VehiclesLayoutsNames` DISABLE KEYS */;
INSERT INTO `VehiclesLayoutsNames` (`id`, `vehicle_id`, `name`, `usingArchitectures`, `usingFlightModes`) VALUES
	(1, 1, 'Простая компоновка', '4 5', '4'),
	(2, 1, 'Сложная компоновка', NULL, NULL),
	(3, 2, 'Простая компоновка', NULL, NULL);
/*!40000 ALTER TABLE `VehiclesLayoutsNames` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
