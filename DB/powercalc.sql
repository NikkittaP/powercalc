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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.AircraftParts: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `AircraftParts` DISABLE KEYS */;
/*!40000 ALTER TABLE `AircraftParts` ENABLE KEYS */;

-- Дамп структуры для таблица PowerDistributionData.ArchitecturesNames
DROP TABLE IF EXISTS `ArchitecturesNames`;
CREATE TABLE IF NOT EXISTS `ArchitecturesNames` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vehicleLayoutName_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL COMMENT 'Название архитектуры для модели (компоновки) ["База", "БЭС1"]',
  `isBasic` tinyint(4) DEFAULT NULL COMMENT 'Является ли базовой архитектурой',
  `chartColor` varchar(7) DEFAULT NULL COMMENT 'Цвет графика для архитектуры',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `FK_ArchitecturesNames_VehiclesLayoutsNames` (`vehicleLayoutName_id`),
  CONSTRAINT `FK_ArchitecturesNames_VehiclesLayoutsNames` FOREIGN KEY (`vehicleLayoutName_id`) REFERENCES `VehiclesLayoutsNames` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.ArchitecturesNames: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `ArchitecturesNames` DISABLE KEYS */;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.Architecture_to_VehicleLayout: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `Architecture_to_VehicleLayout` DISABLE KEYS */;
/*!40000 ALTER TABLE `Architecture_to_VehicleLayout` ENABLE KEYS */;

-- Дамп структуры для таблица PowerDistributionData.Constants
DROP TABLE IF EXISTS `Constants`;
CREATE TABLE IF NOT EXISTS `Constants` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `value` varchar(255) NOT NULL DEFAULT '0',
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `Индекс 2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.Constants: ~4 rows (приблизительно)
/*!40000 ALTER TABLE `Constants` DISABLE KEYS */;
INSERT INTO `Constants` (`id`, `name`, `value`, `description`) VALUES
	(1, 'isEfficiencyFixed', '1', 'КПД fix?'),
	(2, 'chartWidth', '1450', 'Ширина графика'),
	(3, 'chartHeight', '850', 'Высота графика'),
	(4, 'defaultChartColors', '#2f7ed8,#0d233a,#8bbc21,#910000,#1aadce,#492970,#f28f43,#77a1e5,#c42525,#a6c96a', 'Список стандартных цветов для графиков архитектур');
/*!40000 ALTER TABLE `Constants` ENABLE KEYS */;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.Consumers: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `Consumers` DISABLE KEYS */;
/*!40000 ALTER TABLE `Consumers` ENABLE KEYS */;

-- Дамп структуры для таблица PowerDistributionData.EnergySources
DROP TABLE IF EXISTS `EnergySources`;
CREATE TABLE IF NOT EXISTS `EnergySources` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'Название источника энергии ["ГС1", "ЛГС3", "ЭС1"]',
  `energySourceType_id` int(10) unsigned NOT NULL COMMENT 'Является ли электросистемой',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `FK_EnergySources_EnergySourceTypes` (`energySourceType_id`),
  CONSTRAINT `FK_EnergySources_EnergySourceTypes` FOREIGN KEY (`energySourceType_id`) REFERENCES `energysourcetypes` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.EnergySources: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `EnergySources` DISABLE KEYS */;
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

-- Дамп структуры для таблица PowerDistributionData.EnergySource_to_Architecture
DROP TABLE IF EXISTS `EnergySource_to_Architecture`;
CREATE TABLE IF NOT EXISTS `EnergySource_to_Architecture` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `energySource_id` int(10) unsigned NOT NULL,
  `architectureName_id` int(10) unsigned NOT NULL,
  `energySourceLinked_id` int(10) unsigned DEFAULT NULL COMMENT 'Электросистема от которой берет энергию',
  `qMax` float unsigned DEFAULT NULL COMMENT 'Qmax для расчёта Q располагаемого',
  `pumpPressureNominal` float unsigned DEFAULT NULL COMMENT 'Pнас ном',
  `pumpPressureWorkQmax` float unsigned DEFAULT NULL COMMENT 'Pнас раб при Qmax',
  `NMax` float unsigned DEFAULT NULL COMMENT 'Nmax для электросистем',
  PRIMARY KEY (`id`),
  UNIQUE KEY `Индекс 5` (`id`),
  KEY `FK_EnergySource_to_Architecture_EnergySources` (`energySource_id`),
  KEY `FK_EnergySource_to_Architecture_EnergySources_2` (`energySourceLinked_id`),
  KEY `FK_EnergySource_to_Architecture_ArchitecturesNames` (`architectureName_id`),
  CONSTRAINT `FK_EnergySource_to_Architecture_ArchitecturesNames` FOREIGN KEY (`architectureName_id`) REFERENCES `ArchitecturesNames` (`id`),
  CONSTRAINT `FK_EnergySource_to_Architecture_EnergySources` FOREIGN KEY (`energySource_id`) REFERENCES `EnergySources` (`id`),
  CONSTRAINT `FK_EnergySource_to_Architecture_EnergySources_2` FOREIGN KEY (`energySourceLinked_id`) REFERENCES `EnergySources` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.EnergySource_to_Architecture: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `EnergySource_to_Architecture` DISABLE KEYS */;
/*!40000 ALTER TABLE `EnergySource_to_Architecture` ENABLE KEYS */;

-- Дамп структуры для таблица PowerDistributionData.FlightModes
DROP TABLE IF EXISTS `FlightModes`;
CREATE TABLE IF NOT EXISTS `FlightModes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT 'Название режима полета ["Руление", "Взлёт"]',
  `reductionFactor` float unsigned DEFAULT NULL COMMENT 'Коэффициент понижения оборотов',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.FlightModes: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `FlightModes` DISABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.PumpEfficiency: ~9 rows (приблизительно)
/*!40000 ALTER TABLE `PumpEfficiency` DISABLE KEYS */;
INSERT INTO `PumpEfficiency` (`id`, `QCurQmax`, `pumpEfficiency`, `pumpEfficiencyRK`) VALUES
	(1, 0, 0, 0),
	(2, 0.03, 0.2, 0.19),
	(3, 0.06, 0.32, 0.301),
	(4, 0.125, 0.46, 0.432),
	(5, 0.25, 0.63, 0.592),
	(6, 0.375, 0.725, 0.682),
	(7, 0.5, 0.79, 0.743),
	(8, 0.75, 0.855, 0.8037),
	(9, 1, 0.885, 0.8319);
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.VehicleLayout: ~0 rows (приблизительно)
/*!40000 ALTER TABLE `VehicleLayout` DISABLE KEYS */;
/*!40000 ALTER TABLE `VehicleLayout` ENABLE KEYS */;

-- Дамп структуры для таблица PowerDistributionData.Vehicles
DROP TABLE IF EXISTS `Vehicles`;
CREATE TABLE IF NOT EXISTS `Vehicles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT 'Название аппарата ["B737", "Дрон 1", "МС-21 Базовый"]',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `name_UNIQUE` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.Vehicles: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `Vehicles` DISABLE KEYS */;
INSERT INTO `Vehicles` (`id`, `name`) VALUES
	(1, 'Ил-96-300');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы PowerDistributionData.VehiclesLayoutsNames: ~1 rows (приблизительно)
/*!40000 ALTER TABLE `VehiclesLayoutsNames` DISABLE KEYS */;
INSERT INTO `VehiclesLayoutsNames` (`id`, `vehicle_id`, `name`, `usingArchitectures`, `usingFlightModes`) VALUES
	(1, 1, 'Базовая компоновка', NULL, NULL);
/*!40000 ALTER TABLE `VehiclesLayoutsNames` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
