-- The statement below sets the collation of the database to utf8
-- bhuffman1 MIGHT BE the username assigned DEPENDING ON THE configuration of the mysql database
ALTER DATABASE arthaus CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- Code for dropping tables (was used to change spelling of image attribute "imgage" to "image".


-- To drop the whole database
# DROP TABLE applaud;
# DROP TABLE image;
# DROP TABLE gallery;
# DROP TABLE profile;

-- To delete a specific image
DELETE FROM image WHERE imageId = UNHEX("0963B439A26F464B908611952B047FC3");

-- this creates the profile entity
CREATE TABLE profile (
	-- table's attributes list:
	profileId BINARY(16) NOT NULL,
	profileActivationToken CHAR(32),
	profileDate DATETIME(6) NOT NULL,
	profileEmail VARCHAR(128) NOT NULL,
	profileLatitude DECIMAL(9, 6) NOT NULL,
	profileLongitude DECIMAL(9, 6) NOT NULL,
	profileName VARCHAR(32) NOT NULL,
	profilePassword VARCHAR(97) NOT NULL,-- FIXME will need specifications
	profileWebsite VARCHAR(128) NULL,
	-- this marks the following attributes unique
	UNIQUE(profileEmail),
	UNIQUE(profileName),
	-- this creates an index
	INDEX(profileEmail),
	-- this officiates the primary key for the entity
	PRIMARY KEY(profileId)
);


-- this creates the gallery entity
CREATE TABLE gallery (
	-- table's attributes list:
	galleryId BINARY(16) NOT NULL,
	galleryProfileId BINARY(16) NOT NULL,
	galleryDate DATETIME(6) NOT NULL,
	galleryName VARCHAR(32) NOT NULL,
	-- index the foreign keys
	INDEX(galleryProfileId),
	-- create the foreign key relations
	FOREIGN KEY(galleryProfileId) REFERENCES profile(profileId),
	-- this officiates the primary key for the entity
	PRIMARY KEY(galleryId)
);


-- this creates the image entity
CREATE TABLE image (
	-- table's attributes list:
	imageId BINARY(16) NOT NULL,
	imageGalleryId BINARY(16) NOT NULL,
	imageProfileId BINARY(16) NOT NULL,
	imageDate DATETIME(6) NOT NULL,
	imageTitle VARCHAR(32) NOT NULL,
	imageUrl VARCHAR(255) NOT NULL,
--	imageTotalApplauds SMALLINT(2) NULL, -- FIXME count the applauds from all profileId's where the imageId - that particular image. Connection between applauds and total. Case for having: If not would have a query that calculates this total number from the database. Would we index?
	-- index the foreign keys
INDEX(imageGalleryId),
INDEX(imageProfileId),
	-- create the foreign key relations
FOREIGN KEY(imageGalleryId) REFERENCES gallery(galleryId),
FOREIGN KEY(imageProfileId) REFERENCES profile(profileId),
	-- this officiates the primary key for the entity
	PRIMARY KEY(imageId)
	);

-- this creates the applaud entity
CREATE TABLE applaud (
	-- table's attributes list:
	applaudProfileId BINARY(16) NOT NULL,
	applaudImageId BINARY(16) NOT NULL,
	applaudCount TINYINT(1) NOT NULL,
	-- index the foreign keys
	INDEX(applaudProfileId),
	INDEX(applaudImageId),
	-- create the foreign key relations
	FOREIGN KEY(applaudProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(applaudImageId) REFERENCES image(imageId),
	-- this officiates the primary key for the entity
	PRIMARY KEY(applaudProfileId,applaudImageId)
);
