CREATE TABLE `organizations`(
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	    `street_name` varchar(255) NOT NULL,
	    `suite` int DEFAULT NULL,
	    `city` varchar(100) NOT NULL,
	    `state` varchar(2) NOT NULL,
	    `zip` int(5) NOT NULL,
	`website` varchar(255) NOT NULL,
	`contact_name` varchar(255) NOT NULL,
	`email` varchar(255) DEFAULT NULL,
	`phone` int(10) NOT NULL,
	`description` varchar(255) NOT NULL,
	`lattitude` float (10,6),
	`longitude` float(10,6),
	UNIQUE KEY (`name`),
	PRIMARY KEY (`id`)
)
ENGINE=INNODB;

CREATE TABLE `categories`(
	`id` int NOT NULL AUTO_INCREMENT,
	`name` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
)
ENGINE=INNODB;

CREATE TABLE `organizations_categories`(
	`organizationID` int NOT NULL,
	`categoryID` int NOT NULL,
	FOREIGN KEY (`organizationID`) REFERENCES `organizations`(`id`) ON DELETE CASCADE,
	FOREIGN KEY (`categoryID`) REFERENCES `categories`(`id`) ON DELETE CASCADE
)
ENGINE=INNODB;



INSERT INTO `organizations` (`name`, `street_name`, `city`, `state`,`zip`,`lattitude`, `longitude`,`website`,`contact_name`,`phone`,`description`) VALUES ('North Helpline','12736 33rd Ave NE', 'Seattle', 'WA', 98125,47.7223197,-122.291804,'http://www.northhelpline.org/','Kelly Brown',2063673477,'Making sure our neighbors have food on the table and a roof over their heads');
INSERT INTO `organizations` (`name`, `street_name`, `city`, `state`,`zip`,`lattitude`, `longitude`,`website`,`contact_name`,`phone`,`description`) VALUES ('The Seattle Public Library Foundation','1000 4th Ave', 'Seattle', 'WA', 98104,47.606810,-122.332952,'https://supportspl.org/','Grace Nordhoff',2063864130, 'Supporting the Seattle Public Library');
INSERT INTO `organizations` (`name`, `street_name`, `city`, `state`,`zip`,`lattitude`, `longitude`,`website`,`contact_name`,`phone`,`description`) VALUES ('VillageReach','2900 Eastlake Avenue East', 'Seattle', 'WA', 98102, 47.647707, -122.324100,'http://www.villagereach.org/','Emily Bancroft',8662033175, 'Starting at the Last Mile');
INSERT INTO `organizations` (`name`, `street_name`, `city`, `state`,`zip`,`lattitude`, `longitude`,`website`,`contact_name`,`phone`,`description`) VALUES ('Pride Foundation','2014 E. Madison St', 'Seattle', 'WA', 98122, 47.617709, -122.305587,'https://pridefoundation.org/','Kris Hermanns', 8007357287, 'Building a Foundation for All');
INSERT INTO `organizations` (`name`, `street_name`, `city`, `state`,`zip`,`lattitude`, `longitude`,`website`,`contact_name`,`phone`,`description`) VALUES ('Boys & Girls Clubs of King County','Seattle','603 Stewart Street', 'WA', 98101, 47.613985, -122.336538,'https://positiveplace.org/','Lisa Chin',2064361800, 'The positive place for kids');
INSERT INTO `organizations` (`name`, `street_name`, `city`, `state`,`zip`,`lattitude`, `longitude`,`website`,`contact_name`,`phone`,`description`) VALUES ('Vision House' , '2951 Renton','Seattle', 'WA', 98056, 47.505375, -122.177225,'https://www.imaginecm.org/','Nancy Johnson',4252581006, 'Making childrens lives better by creating a place where they can playfully learn');

INSERT INTO `organizations` (`name`,`street_name`,`city`,`state`,`zip`,`website`,`contact_name`,`phone`,`description`)
VALUES( "Goodwill","1943 SE Sixth Avenue", "Portland", "OR", 97214, "https://meetgoodwill.org/who-we-are/donations/","Dale Emanuel",5032386165,"Our mission is to provide vocational opportunities to people with barriers to employment." );

INSERT INTO `categories` (`name`)
VALUES("food");

INSERT INTO `categories` (`name`)
VALUES("clothing");

INSERT INTO `categories` (`name`)
VALUES("employment services");

INSERT INTO `organizations_categories`(`organizationID`, `categoryID`) VALUES (1 , 2);
INSERT INTO `organizations_categories`(`organizationID`, `categoryID`) VALUES (1 , 3);
