CREATE TABLE profile
(
profileId INT UNSIGNED AUTO_INCREMENT NOT NULL,
profileName varchar(30) NOT NULL,
profilePermissions SET(ADMIN,AUTHOR,READER) NOT NULL,
profileAvatar INT NULL,
PRIMARY KEY (profileId)
);

CREATE TABLE article
(
articleId INT UNSIGNED AUTO_INCREMENT NOT NULL,
articleContents varchar(10000) NOT NULL,
articleTime DATETIME NOT NULL,
PRIMARY KEY (articleId),
INDEX(profileId),
FOREIGN KEY(profileId) REFERENCES profile(profileId)
);


CREATE TABLE articleLiked
(
articleLikedTime DATETIME NOT NULL,
INDEX(profileId),
INDEX(articleId),
FOREIGN KEY(articleId) REFERENCES article(articleId),
FOREIGN KEY(profileId) REFERENCES profile(profileId)
);


CREATE TABLE commentLiked
(
commentLikedTime DATETIME NOT NULL,
INDEX(profileId),
INDEX(articleId),
FOREIGN KEY(commentLiked) REFERENCES comment(commentId),
FOREIGN KEY(profileId) REFERENCES profile(profileId)
);

CREATE TABLE comment
(
commentId INT UNSIGNED AUTO_INCREMENT NOT NULL,
/*parentCommentId UNSIGNED AUTO_INCREMENT NULLABLE,*/
commentContents varchar(1000) NOT NULL,
PRIMARY KEY (commentId),
INDEX(profileId),
INDEX(articleId),
FOREIGN KEY(commentId) REFERENCES comment(commentId),
FOREIGN KEY(articleId) REFERENCES article(articleId),
FOREIGN KEY(profileId) REFERENCES profile(profileId)
);