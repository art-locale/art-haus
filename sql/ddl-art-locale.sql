-- The statement below sets the collation of the database to utf8
-- bhuffman1 is the username assigned in when you configure the mysql database to this file (i.e. the tab to the right in php storm)
ALTER DATABASE bhuffman1 CHARACTER SET utf8 COLLATE utf8_unicode_ci;

-- this creates the profile entity
CREATE TABLE profile (
	-- this creates the attribute for the primary key
	-- not null means the attribute is required!
	-- table's attributes list:
	workspaceId BINARY(16) NOT NULL,
	workspaceApps VARCHAR(32),
	workspaceThreads VARCHAR(128),
	-- this officiates the primary key for the entity
	PRIMARY KEY(workspaceId)
);
