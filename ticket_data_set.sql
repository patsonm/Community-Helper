-- DROP TABLE IF EXISTS `ticket`;
-- DROP TABLE IF EXISTS `ticket_status`;


CREATE TABLE `ticket`(
	`id` int NOT NULL AUTO_INCREMENT,
	`firstName` varchar(255) NOT NULL,
	`lastName` varchar(255) NOT NULL,
	`email` varchar(255) DEFAULT NULL,
	`description` varchar(255) NOT NULL,
	`needType` varchar(255) NOT NULL,
	`serviceRequired` varchar(255) NOT NULL,
	`willDonate` varchar(255) NOT NULL,
	`lattitude` float,
	`longitude` float,
	PRIMARY KEY (`id`)
)ENGINE=InnoDB;


CREATE TABLE `ticket_status`(
	`id` int NOT NULL AUTO_INCREMENT,
	`organizationID` int NOT NULL,
	`ticketID` int NOT NULL,
	`status` varchar(255) NOT NULL DEFAULT 'pending',
	`useDescription` varchar(255) NOT NULL DEFAULT 'pending';
	`emailSent` varchar(255) NOT NULL DEFAULT 'not sent',
	PRIMARY KEY (`id`),
	FOREIGN KEY (`organizationID`) REFERENCES `organizations` (`id`) ON DELETE CASCADE,
	FOREIGN KEY (`ticketID`) REFERENCES `ticket` (`id`) ON DELETE CASCADE
)ENGINE=InnoDB;
