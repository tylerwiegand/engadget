DROP TABLE IF EXISTS commentLiked;
DROP TABLE IF EXISTS comment;
DROP TABLE IF EXISTS articleLiked;
DROP TABLE IF EXISTS article;
DROP TABLE IF EXISTS profile;

CREATE TABLE profile (
	profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileName varchar(30) NOT NULL,
	profilePermissions char(1) NOT NULL,
	profileAvatar INT NULL,
	PRIMARY KEY (profileId)
	);

CREATE TABLE article (
	profileId INT UNSIGNED NOT NULL,
	articleId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	articleContents varchar(10000) NOT NULL,
	articleTime DATETIME NOT NULL,
	INDEX(profileId),
	PRIMARY KEY (articleId),
	FOREIGN KEY(profileId) REFERENCES profile(profileId)
);


CREATE TABLE articleLiked (
	articleId INT UNSIGNED NOT NULL,
	profileId INT UNSIGNED NOT NULL,
	articleLikedTime DATETIME NOT NULL,
	INDEX(profileId),
	INDEX(articleId),
	FOREIGN KEY(articleId) REFERENCES article(articleId),
	FOREIGN KEY(profileId) REFERENCES profile(profileId)
);

CREATE TABLE comment (
	commentId INT UNSIGNED AUTO_INCREMENT NOT NULL,
	profileId INT UNSIGNED NOT NULL,
	articleId INT UNSIGNED NOT NULL,
	parentCommentId INT UNSIGNED,
	commentContents varchar(1000) NOT NULL,
	PRIMARY KEY (commentId),
	INDEX(profileId),
	INDEX(articleId),
	INDEX(parentCommentId),
	FOREIGN KEY(articleId) REFERENCES article(articleId),
	FOREIGN KEY(profileId) REFERENCES profile(profileId)
);

CREATE TABLE commentLiked (
	commentId INT UNSIGNED NOT NULL,
	commentLiked INT UNSIGNED NOT NULL,
	profileId INT UNSIGNED NOT NULL,
	articleId INT UNSIGNED NOT NULL,
	commentLikedTime DATETIME NOT NULL,
	FOREIGN KEY(commentId) REFERENCES comment(commentId),
	FOREIGN KEY(profileId) REFERENCES profile(profileId)
);