-- database sphinx_search
DROP DATABASE IF EXISTS `sphinx_search` ;
CREATE DATABASE `sphinx_search` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

DROP TABLE IF EXISTS documents;
CREATE TABLE documents
(
	id			INTEGER PRIMARY KEY NOT NULL AUTO_INCREMENT,
	group_id	INTEGER NOT NULL,
	group_id2	INTEGER NOT NULL,
	date_added	DATETIME NOT NULL,
	title		VARCHAR(255) NOT NULL,
	content		TEXT NOT NULL
);

INSERT INTO documents ( id, group_id, group_id2, date_added, title, content ) VALUES
	( 1, 1, 5, NOW(), 'test one', 'this is my test document number one. also checking search within phrases.' ),
	( 2, 1, 6, NOW(), 'test two', 'this is my test document number two' ),
	( 3, 2, 7, NOW(), 'another doc', 'this is another group' ),
	( 4, 2, 8, NOW(), 'doc number four', 'this is to test groups' );

DROP TABLE IF EXISTS tags;
CREATE TABLE tags
(
	docid INTEGER NOT NULL,
	tagid INTEGER NOT NULL,
	UNIQUE(docid,tagid)
);

INSERT INTO tags VALUES
	(1,1), (1,3), (1,5), (1,7),
	(2,6), (2,4), (2,2),
	(3,15),
	(4,7), (4,40);



