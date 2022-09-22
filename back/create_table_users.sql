CREATE TABLE IF NOT EXISTS `Users` (`username` VARCHAR(50) NOT NULL, `hash` VARCHAR(100) NOT NULL, `role` VARCHAR(7) NOT NULL, PRIMARY KEY (`username`), UNIQUE (`username`))
