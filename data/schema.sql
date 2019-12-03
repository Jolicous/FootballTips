USE footballtips;

DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS league;
DROP TABLE IF EXISTS team;
DROP TABLE IF EXISTS league_team;
DROP TABLE IF EXISTS encounter;
DROP TABLE IF EXISTS mytips;


CREATE TABLE  user (
  id        INT UNSIGNED NOT NULL AUTO_INCREMENT,
  firstName VARCHAR(64)  NOT NULL,
  lastName  VARCHAR(64)  NOT NULL,
  email     VARCHAR(128) NOT NULL,
  password  VARCHAR(255)  NOT NULL,
  punkte    INT NOT NULL,
  PRIMARY KEY  (id)
);

CREATE TABLE league (
  id      INT UNSIGNED  NOT NULL AUTO_INCREMENT,
  name    VARCHAR(64)   NOT NULL,
  kürzel  VARCHAR(5)    NOT NULL,
  img_src VARCHAR(64)   NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE team (
  id int UNSIGNED NOT NULL AUTO_INCREMENT,
  liga_id int NOT NULL,
  name varchar(64) not null,
  PRIMARY KEY (id),
  CONSTRAINT FK_league_team FOREIGN KEY (liga_id)
  REFERENCES league (id)
);

CREATE TABLE league_team (
  id  int UNSIGNED not null AUTO_INCREMENT,
  liga_id int not null,
  mannschaft_id int not null,
  tore int not null,
  gegentore int not null,
  punkte int not null,
  PRIMARY KEY (id),
  CONSTRAINT FK_league_team FOREIGN KEY (mannschaft_id)
  REFERENCES team (id),  
  CONSTRAINT FK_team_league FOREIGN KEY (liga_id)
  REFERENCES league (id)
);

CREATE TABLE encounter(
  id int UNSIGNED not null AUTO_INCREMENT,
  
);

INSERT INTO user (firstName, lastName, email, password) VALUES ('Ramon',  'Binz',  'ramon.binz@bbcag.ch',   sha2('ramon', 256));
INSERT INTO user (firstName, lastName, email, password) VALUES ('Samuel', 'Wicky', 'samuel.wicky@bbcag.ch', sha2('samuel', 256));

INSERT INTO league (name, kürzel, img_src) VALUES ('Premier League', 'ENG', '/images/pl_logo.png');