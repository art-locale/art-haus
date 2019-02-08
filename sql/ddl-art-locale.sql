-- The statement below sets the collation of the database to utf8
-- bhuffman1 MIGHT BE the username assigned DEPENDING ON THE configuration of the mysql database
ALTER DATABASE bhuffman1 CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- this creates the profile entity
CREATE TABLE profile (
	-- table's attributes list:
	profileId BINARY(16) NOT NULL,
	profileActivationToken CHAR(32),
	profileDate DATETIME(6) NOT NULL,
	profileEmail VARCHAR(128) NOT NULL,
	profileLocation VARCHAR(128),-- FIXME ask George latidute/long => Habersign, they will input address we change to Habersign.
	profileName VARCHAR(32) NOT NULL,
	profilePassword VARCHAR(97) NOT NULL, -- FIXME will need specifications
	profileWebsite VARCHAR(128) NULL,
	-- this marks the following attributes unique
	UNIQUE(profileEmail),
	UNIQUE(profileName),
	-- this creates an index
	INDEX(profileEmail),
	INDEX(profileName),
	-- index a searchable attribute
	INDEX(profileWebsite),
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
	-- index a searchable attribute
	INDEX(galleryName),
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
	imgageUrl VARCHAR(128) NULL,
--	imageTotalApplauds SMALLINT(2) NULL, -- FIXME count the applauds from all profileId's where the imageId - that particular image. Connection between applauds and total. Case for having: If not would have a query that calculates this total number from the database. Would we index?
	-- index the foreign keys
INDEX(imageGalleryId),
INDEX(imageProfileId),
-- index a searchable attribute
INDEX(imageTitle),
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
	applaudCount TINYINT(1) NULL, -- FIXME verify what would be optimal here.
	-- create the foreign key relations
	FOREIGN KEY(applaudProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(applaudImageId) REFERENCES image(imageId)-- ,
	-- this officiates the primary key for the entity
--	PRIMARY KEY(applaudProfileId,applaudImageId) -- FIXME verify Probably get rid of completely
);
