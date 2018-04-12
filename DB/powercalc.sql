-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.6.38 - MySQL Community Server (GPL)
-- Операционная система:         Win32
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `FK_ArchitecturesNames_VehiclesLayoutsNames` (`vehicleLayoutName_id`),
  CONSTRAINT `FK_ArchitecturesNames_VehiclesLayoutsNames` FOREIGN KEY (`vehicleLayoutName_id`) REFERENCES `VehiclesLayoutsNames` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.ArchitecturesNames: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `ArchitecturesNames` DISABLE KEYS */;
INSERT INTO `ArchitecturesNames` (`id`, `vehicleLayoutName_id`, `name`) VALUES
	(1, 1, 'База'),
	(2, 1, 'БЭС1'),
	(3, 3, 'Архит. 7 ЭлКрЛГС');
/*!40000 ALTER TABLE `ArchitecturesNames` ENABLE KEYS */;

-- Дамп структуры для таблица PowerDistributionData.Architecture_to_VehicleLayout
DROP TABLE IF EXISTS `Architecture_to_VehicleLayout`;
CREATE TABLE IF NOT EXISTS `Architecture_to_VehicleLayout` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vehicleLayout_id` int(10) unsigned NOT NULL,
  `architectureName_id` int(10) unsigned NOT NULL,
  `energySource_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `FK_Architecture_to_VehicleLayout_VehicleLayout` (`vehicleLayout_id`),
  KEY `FK_Architecture_to_VehicleLayout_ArchitecturesNames` (`architectureName_id`),
  KEY `FK_Architecture_to_VehicleLayout_EnergySources` (`energySource_id`),
  CONSTRAINT `FK_Architecture_to_VehicleLayout_ArchitecturesNames` FOREIGN KEY (`architectureName_id`) REFERENCES `ArchitecturesNames` (`id`),
  CONSTRAINT `FK_Architecture_to_VehicleLayout_EnergySources` FOREIGN KEY (`energySource_id`) REFERENCES `EnergySources` (`id`),
  CONSTRAINT `FK_Architecture_to_VehicleLayout_VehicleLayout` FOREIGN KEY (`vehicleLayout_id`) REFERENCES `VehicleLayout` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.Architecture_to_VehicleLayout: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `Architecture_to_VehicleLayout` DISABLE KEYS */;
INSERT INTO `Architecture_to_VehicleLayout` (`id`, `vehicleLayout_id`, `architectureName_id`, `energySource_id`) VALUES
	(1, 1, 2, 4);
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.Consumers: ~7 rows (приблизительно)
/*!40000 ALTER TABLE `Consumers` DISABLE KEYS */;
INSERT INTO `Consumers` (`id`, `name`, `aircraftPart_id`, `efficiencyHydro`, `efficiencyElectric`, `q0`, `qMax`) VALUES
	(1, 'ПОШ (уборка/выпуск)', 3, 0.55, 0.85, 0.5, 10),
	(2, 'ПОШ (руление) 1 кан.', 3, 0.5, 0.85, 0.5, 10),
	(3, 'ПОШ (руление) 2 кан.', 3, 0.5, 0.85, 0.5, 10),
	(4, 'Закрылки лев.', 1, 0.4, 0.85, 0.5, 40),
	(5, 'Закрылки пр.', 1, 0.4, 0.85, 0.5, 40),
	(6, 'Предкрылки лев.', 1, 0.4, 0.85, 0.5, 21),
	(7, 'Предкрылки пр.', 1, 0.4, 0.85, 0.5, 21);
/*!40000 ALTER TABLE `Consumers` ENABLE KEYS */;

-- Дамп структуры для таблица PowerDistributionData.EnergySources
DROP TABLE IF EXISTS `EnergySources`;
CREATE TABLE IF NOT EXISTS `EnergySources` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Название источника энергии ["ГС1", "ЛГС3", "ЭС1"]',
  `isElectric` tinyint(4) DEFAULT NULL COMMENT 'Является ли электросистемой',
  `qMax` float unsigned DEFAULT NULL COMMENT 'Qmax для расчёта Q располагаемого',
  `pumpPressureNominal` float unsigned DEFAULT NULL COMMENT 'Pнас ном',
  `pumpPressureWorkQmax` float unsigned DEFAULT NULL COMMENT 'Pнас раб при Qmax',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.EnergySources: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `EnergySources` DISABLE KEYS */;
INSERT INTO `EnergySources` (`id`, `name`, `isElectric`, `qMax`, `pumpPressureNominal`, `pumpPressureWorkQmax`) VALUES
	(1, 'ГС1', 0, 180, 211, 195),
	(2, 'ГС2', 0, 180, 211, 195),
	(3, 'ЭС', 1, NULL, NULL, NULL),
	(4, 'ЛГС1', 0, 50, 211, 195),
	(5, 'ЛГС3', 0, 10, 211, 195);
/*!40000 ALTER TABLE `EnergySources` ENABLE KEYS */;

-- Дамп структуры для таблица PowerDistributionData.FlightModes
DROP TABLE IF EXISTS `FlightModes`;
CREATE TABLE IF NOT EXISTS `FlightModes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT 'Название режима полета ["Руление", "Взлёт"]',
  `reductionFactor` float unsigned DEFAULT NULL COMMENT 'Коэффициент понижения оборотов',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.FlightModes: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `FlightModes` DISABLE KEYS */;
INSERT INTO `FlightModes` (`id`, `name`, `reductionFactor`) VALUES
	(1, 'Взлёт', 1),
	(2, 'Крейсер', 0.85),
	(3, 'Посадка', 0.6);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.FlightModes_to_VehicleLayout: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `FlightModes_to_VehicleLayout` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.VehicleLayout: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `VehicleLayout` DISABLE KEYS */;
INSERT INTO `VehicleLayout` (`id`, `vehicleLayoutName_id`, `consumer_id`) VALUES
	(1, 1, 3),
	(2, 2, 4);
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `FK_VehiclesLayoutsNames_Vehicles` (`vehicle_id`),
  CONSTRAINT `FK_VehiclesLayoutsNames_Vehicles` FOREIGN KEY (`vehicle_id`) REFERENCES `Vehicles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.VehiclesLayoutsNames: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `VehiclesLayoutsNames` DISABLE KEYS */;
INSERT INTO `VehiclesLayoutsNames` (`id`, `vehicle_id`, `name`) VALUES
	(1, 1, 'Простая компоновка'),
	(2, 1, 'Сложная компоновка'),
	(3, 2, 'Простая компоновка');
/*!40000 ALTER TABLE `VehiclesLayoutsNames` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
