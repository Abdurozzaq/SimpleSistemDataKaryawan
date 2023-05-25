


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
SET NAMES utf8mb4;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table jabatan_pegawai
# ------------------------------------------------------------

DROP TABLE IF EXISTS `jabatan_pegawai`;

CREATE TABLE `jabatan_pegawai` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID Jabatan',
  `jabatan` varchar(250) NOT NULL COMMENT 'Nama Jabatan',
  `deskripsi` text DEFAULT NULL COMMENT 'Deskripsi Jabatan',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `jabatan_pegawai` WRITE;
/*!40000 ALTER TABLE `jabatan_pegawai` DISABLE KEYS */;

INSERT INTO `jabatan_pegawai` (`id`, `jabatan`, `deskripsi`) VALUES
	(1, 'Software Engineer', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus bibendum erat sed felis consectetur maximus. Fusce nec egestas mi.'),
	(2, 'Database Administrator', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus bibendum erat sed felis consectetur maximus. Fusce nec egestas mi.'),
	(3, 'Development Operations', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus bibendum erat sed felis consectetur maximus. Fusce nec egestas mi.');

/*!40000 ALTER TABLE `jabatan_pegawai` ENABLE KEYS */;
UNLOCK TABLES;



# Dump of table kontrak
# ------------------------------------------------------------

DROP TABLE IF EXISTS `kontrak`;

CREATE TABLE `kontrak` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID Kontrak',
  `nama_kontrak` varchar(250) NOT NULL COMMENT 'Nama Kontrak',
  `id_pegawai` int(11) NOT NULL COMMENT 'Id Pegawai',
  `id_jabatan` int(11) NOT NULL COMMENT 'ID Jabatan',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `kontrak` WRITE;
/*!40000 ALTER TABLE `kontrak` DISABLE KEYS */;

INSERT INTO `kontrak` (`id`, `nama_kontrak`, `id_pegawai`, `id_jabatan`) VALUES
	(1, 'Fulltime Software Engineer', 1, 1),
	(2, 'Intern Software Engineer', 2, 1),
	(3, 'Fulltime DBA', 3, 2),
	(4, 'Fulltime DevOps', 4, 3);

/*!40000 ALTER TABLE `kontrak` ENABLE KEYS */;
UNLOCK TABLES;



# Dump of table pegawai
# ------------------------------------------------------------

DROP TABLE IF EXISTS `pegawai`;

CREATE TABLE `pegawai` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id Pegawai',
  `nama` varchar(250) NOT NULL COMMENT 'Nama Pegawai',
  `email` varchar(250) NOT NULL COMMENT 'Email Pegawai',
  PRIMARY KEY (`id`,`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

LOCK TABLES `pegawai` WRITE;
/*!40000 ALTER TABLE `pegawai` DISABLE KEYS */;

INSERT INTO `pegawai` (`id`, `nama`, `email`) VALUES
	(1, 'Abdur', 'abdur@yopmail.com'),
	(2, 'Nurul', 'nurul@yopmail.com'),
	(3, 'Galih', 'galih@yopmail.com'),
	(4, 'Sari', 'sari@yopmail.com');

/*!40000 ALTER TABLE `pegawai` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


