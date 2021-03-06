DROP DATABASE IF EXISTS myDrive;
--
-- Database: `myDrive`
--
DROP DATABASE IF EXISTS myDrive;

CREATE DATABASE IF NOT EXISTS `myDrive` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `myDrive`;

-- Table structure for table `Files`

CREATE TABLE `Files` (
  `FileName` varchar(30) NOT NULL,
  `FileType` varchar(50) DEFAULT 'text/plain',
  `FileSize` bigint(20) UNSIGNED DEFAULT '0',
  `FileData` mediumblob,
  `FileDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ParentFolder` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- Table structure for table `Folder`
CREATE TABLE `Folder` (
  `FolderName` varchar(32) NOT NULL,
  `ParentFolder` varchar(32) DEFAULT NULL,
  `UserName` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table `Folder`
INSERT INTO `Folder` (`FolderName`, `ParentFolder`, `UserName`) VALUES
('folder1', NULL, 'User'),
('folder2', NULL, 'User'),
('folder3', 'folder1', 'User');

-- Dumping data for table `Files`
INSERT INTO `Files` (`FileName`, `FileType`, `FileSize`, `FileData`, `FileDate`, `ParentFolder`) VALUES
('file3', NULL, 0, NULL, '2016-05-17 10:07:44', 'folder1'),
('file1', '', 0, '', '2016-08-10 18:20:54', NULL),
('file2', '', 0, '', '2016-08-10 18:21:05', NULL),
('file4', '', 0, '', '2016-08-10 18:21:05', 'folder3');
-- --------------------------------------------------------

-- Table structure for table `Users`
CREATE TABLE `Users` (
  `UserName` varchar(32) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `Name` varchar(64) NOT NULL,
  `Admin` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table `Users`
INSERT INTO `Users` (`UserName`, `Password`, `Name`, `Admin`) VALUES
('User', '123', 'Jared Gailey', 1);

-- Indexes for table `Files`
ALTER TABLE `Files`
  ADD UNIQUE KEY `FileName` (`FileName`,`ParentFolder`),
  ADD KEY `Files` (`ParentFolder`);

-- Indexes for table `Folder`
ALTER TABLE `Folder`
  ADD PRIMARY KEY (`FolderName`),
  ADD KEY `UserName` (`UserName`),
  ADD KEY `ParentFolder` (`ParentFolder`);

-- Indexes for table `Users`
ALTER TABLE `Users`
  ADD PRIMARY KEY (`UserName`);

-- Constraints for table `Files`
ALTER TABLE `Files`
  ADD CONSTRAINT `Files` FOREIGN KEY (`ParentFolder`) REFERENCES `Folder` (`FolderName`);

-- Constraints for table `Folder`
ALTER TABLE `Folder`
  ADD CONSTRAINT `Folder_ibfk_1` FOREIGN KEY (`UserName`) REFERENCES `Users` (`UserName`),
  ADD CONSTRAINT `Folder_ibfk_2` FOREIGN KEY (`ParentFolder`) REFERENCES `Folder` (`FolderName`);

DELIMITER //

# Procedure returns path of a folder
-- traverses folder path and stores path in temporary table
-- 		can i do this one sql query? or without creating a temporary table?
--      fix: identify folder using username,parentFolder to correctly
#			 reference folders with same name
#			add arguments for username,foldername and handle NULL correctly
CREATE PROCEDURE `getPath` (IN `selectedFolder` CHAR(32))  BEGIN
  DECLARE nextDir CHAR(32);
CREATE TEMPORARY TABLE OUT_TEMP( folder varchar(32));
  while selectedFolder is not null do
    insert into OUT_TEMP(folder) values (selectedFolder);
	set nextDir = (select ParentFolder from Folder where FolderName=selectedFolder);
	set selectedFolder = nextDir;
  END WHILE;
  select * from OUT_TEMP;
DROP TEMPORARY TABLE OUT_TEMP;
END//

DELIMITER ;
