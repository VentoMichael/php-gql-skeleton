-- -------------------------------------------------------------
-- TablePlus 5.6.2(516)
--
-- https://tableplus.com/
--
-- Database: vertuoza_dvp
-- Generation Time: 2024-02-14 12:19:25.3870
-- -------------------------------------------------------------


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

DROP TABLE IF EXISTS `tenants`;
CREATE TABLE `tenants` (
  `id` CHAR(36) NOT NULL DEFAULT (UUID()),
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `tenants` (`id`, `name`) VALUES 
('112c33ae-3dbe-431b-994d-fffffe6fd49b', 'Vertuoza');

DROP TABLE IF EXISTS `unit_types`;
CREATE TABLE `unit_types` (
  `id` CHAR(36) NOT NULL DEFAULT (UUID()),
  `tenant_id` CHAR(36) DEFAULT NULL,  -- Changed to CHAR(36) to match the data type of `tenant.id`
  `label` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_unit_types_tenant_idx` (`tenant_id`),
  CONSTRAINT `fk_unit_types_tenants` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `unit_types` (`id`, `tenant_id`, `label`) VALUES 
('4c2241c9-841f-44c9-9a51-18cfd8f37890', '112c33ae-3dbe-431b-994d-fffffe6fd49b', 'Meter');

DROP TABLE IF EXISTS `collaborators`;
CREATE TABLE `collaborators` (
  `id` CHAR(36) NOT NULL DEFAULT (UUID()),
  `tenant_id` CHAR(36) DEFAULT NULL,  -- Changed to CHAR(36) to match the data type of `tenant.id`
  `name` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_collaborators_tenant_idx` (`tenant_id`),
  CONSTRAINT `fk_collaborators_tenants` FOREIGN KEY (`tenant_id`) REFERENCES `tenants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `collaborators` (`id`, `tenant_id`, `name`, `first_name`) VALUES
('4146e6ea-2534-4708-b33d-93af6cab43b6', '112c33ae-3dbe-431b-994d-fffffe6fd49b', 'Smith', 'John'),
('3125c2bd-94c6-47cd-a7f8-7a60f2762662', '112c33ae-3dbe-431b-994d-fffffe6fd49b', 'Denuit', 'Michel'),
('08d97e48-c4a5-42c8-a166-b1159a40b42a', '112c33ae-3dbe-431b-994d-fffffe6fd49b', 'Mayer', 'Carl');