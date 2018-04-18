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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.ArchitecturesNames: ~3 rows (приблизительно)
/*!40000 ALTER TABLE `ArchitecturesNames` DISABLE KEYS */;
INSERT INTO `ArchitecturesNames` (`id`, `vehicleLayoutName_id`, `name`, `isBasic`) VALUES
	(1, 1, 'База', 1),
	(2, 1, 'БЭС1', 0),
	(3, 3, 'Архит. 7 ЭлКрЛГС', 0);
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.Architecture_to_VehicleLayout: ~6 rows (приблизительно)
/*!40000 ALTER TABLE `Architecture_to_VehicleLayout` DISABLE KEYS */;
INSERT INTO `Architecture_to_VehicleLayout` (`id`, `vehicleLayout_id`, `architectureName_id`, `energySource_id`) VALUES
	(1, 1, 2, 4),
	(2, 1, 1, 2),
	(3, 3, 1, 1),
	(4, 3, 2, 2),
	(5, 4, 2, 6),
	(6, 4, 1, 4);
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
  `energySourceType_id` int(10) unsigned NOT NULL COMMENT 'Является ли электросистемой',
  `qMax` float unsigned DEFAULT NULL COMMENT 'Qmax для расчёта Q располагаемого',
  `pumpPressureNominal` float unsigned DEFAULT NULL COMMENT 'Pнас ном',
  `pumpPressureWorkQmax` float unsigned DEFAULT NULL COMMENT 'Pнас раб при Qmax',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `FK_EnergySources_EnergySourceTypes` (`energySourceType_id`),
  CONSTRAINT `FK_EnergySources_EnergySourceTypes` FOREIGN KEY (`energySourceType_id`) REFERENCES `energysourcetypes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.EnergySources: ~6 rows (приблизительно)
/*!40000 ALTER TABLE `EnergySources` DISABLE KEYS */;
INSERT INTO `EnergySources` (`id`, `name`, `energySourceType_id`, `qMax`, `pumpPressureNominal`, `pumpPressureWorkQmax`) VALUES
	(1, 'ГС1', 1, 180, 211, 195),
	(2, 'ГС2', 1, 180, 211, 195),
	(3, 'ГС3', 2, 180, 211, 195),
	(4, 'ЛГС1', 3, 50, 211, 195),
	(5, 'ЛГС3', 3, 10, 211, 195),
	(6, 'ЭС', 4, NULL, NULL, NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.FlightModes_to_VehicleLayout: ~2 rows (приблизительно)
/*!40000 ALTER TABLE `FlightModes_to_VehicleLayout` DISABLE KEYS */;
INSERT INTO `FlightModes_to_VehicleLayout` (`id`, `vehicleLayout_id`, `flightMode_id`, `usageFactor`) VALUES
	(1, 1, 1, 0.4),
	(2, 1, 2, 1),
	(3, 1, 3, 0.1);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.ResultsConsumers: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `ResultsConsumers` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.ResultsEnergySources: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `ResultsEnergySources` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.VehicleLayout: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `VehicleLayout` DISABLE KEYS */;
INSERT INTO `VehicleLayout` (`id`, `vehicleLayoutName_id`, `consumer_id`) VALUES
	(1, 1, 3),
	(2, 2, 4),
	(3, 1, 6),
	(4, 1, 5);
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
