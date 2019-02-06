-- The statement below sets the collation of the database to utf8
-- bhuffman1 MIGHT BE the username assigned DEPENDING ON THE configuration of the mysql database
ALTER DATABASE bhuffman1 CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- this creates the profile entity
CREATE TABLE profile (
	-- table's attributes list:
	profileId BINARY(16) NOT NULL, -- FIXME any consideration here for Auto incrementing?
	profileActivationToken CHAR(32),
	profileDate DATETIME(6) NOT NULL, -- FIXME look into other options
	profileEmail VARCHAR(128) NOT NULL,
	profileLocation, -- FIXME ask George latidute/long or city. as
	profileName VARCHAR(32) NOT NULL,
	profilePassword VARCHAR(140) NOT NULL,
	profileWebsite VARCHAR(128) NULL,
	-- this marks the following attributes unique
	UNIQUE(profileEmail),-- FIXME do we want these? pros and cons?
	UNIQUE(profileName),
	-- this creates an index
	INDEX(profileEmail), -- FIXME do we want these? pros and cons?
	-- this officiates the primary key for the entity
	PRIMARY KEY(profileId)
);


-- this creates the gallery entity
CREATE TABLE gallery (
	-- table's attributes list:
	galleryId BINARY(16) NOT NULL, -- FIXME any consideration here for Auto incrementing?
	galleryProfileId BINARY(16) NOT NULL,
	galleryDate DATETIME(6) NOT NULL, -- FIXME look into other options
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
	imageId BINARY(16) NOT NULL, -- FIXME any consideration here for Auto incrementing?
	imageGalleryId BINARY(16) NOT NULL,
	imageProfileId BINARY(16) NOT NULL,
	imageDate DATETIME(6) NOT NULL, -- FIXME look into other options
	imageTitle VARCHAR(32) NOT NULL,
	imgageUrl VARCHAR(128) NULL,
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
	applaudCount VARCHAR(50) NULL, -- FIXME verify what would be optimal here.
# 	-- index the foreign keys --FIXME verify, indexing unnecessary since they are used as primary keys.
# 	INDEX(applaudProfileId),
# 	INDEX(applaudImageId),
	-- create the foreign key relations
	FOREIGN KEY(applaudProfileId) REFERENCES profile(profileId),
	FOREIGN KEY(applaudImageId) REFERENCES image(imageId),
	-- this officiates the primary key for the entity
	PRIMARY KEY(applaudProfileId,applaudImageId) -- FIXME verify
);
