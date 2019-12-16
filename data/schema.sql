USE footballtips;

CREATE TABLE  user (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  firstName VARCHAR(64) NOT NULL,
  lastName VARCHAR(64) NOT NULL,
  email VARCHAR(128) NOT NULL,
  password VARCHAR(255) NOT NULL,
  punkte INT NOT NULL,
  PRIMARY KEY (id)
);

CREATE unique index user_email_uk ON user(email);

CREATE TABLE league (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(64) NOT NULL,
  kürzel VARCHAR(5) NOT NULL,
  img_src VARCHAR(64) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE team (
  id int UNSIGNED NOT NULL AUTO_INCREMENT,
  liga_id int UNSIGNED NOT NULL,
  name varchar(64) not null,
  PRIMARY KEY (id),
  CONSTRAINT FOREIGN KEY (liga_id) REFERENCES league(id)
);

CREATE TABLE league_team (
  liga_id int UNSIGNED not null,
  mannschaft_id int UNSIGNED not null,
  tore int UNSIGNED not null,
  gegentore int UNSIGNED not null,
  punkte int UNSIGNED not null,
  PRIMARY KEY (liga_id, mannschaft_id),
  CONSTRAINT FK_league_team FOREIGN KEY (mannschaft_id)
  REFERENCES team (id),  
  CONSTRAINT FK_team_league FOREIGN KEY (liga_id)
  REFERENCES league (id)
);

CREATE TABLE encounter(
  id int UNSIGNED not null AUTO_INCREMENT,
  hometeam_id int UNSIGNED not null,
  awayteam_id int UNSIGNED not null,
  homegoals int UNSIGNED,
  awaygoals int UNSIGNED,
  datum date not null,
  primary key (id),
  CONSTRAINT FK_encounter_hometeam FOREIGN KEY (hometeam_id)
  REFERENCES team (id),  
  CONSTRAINT FK_encounter_awayteam FOREIGN KEY (awayteam_id)
  REFERENCES team (id)
);

CREATE TABLE tips(
  id int UNSIGNED not null AUTO_INCREMENT,
  benutzer_id int UNSIGNED not null,
  begegnung_id int UNSIGNED not null,
  homegoals int UNSIGNED,
  awaygoals int UNSIGNED,
  PRIMARY KEY (id),
  CONSTRAINT FK_tips_encounter FOREIGN KEY (begegnung_id)
  REFERENCES encounter (id),  
  CONSTRAINT FK_tips_user FOREIGN KEY (benutzer_id)
  REFERENCES user (id)
);

INSERT INTO user (firstName, lastName, email, password, punkte) VALUES ('Ramon',  'Binz',  'ramon.binz@bbcag.ch',   sha2('ramon', 256), 25);
INSERT INTO user (firstName, lastName, email, password, punkte) VALUES ('Samuel', 'Wicky', 'samuel.wicky@bbcag.ch', sha2('samuel', 256), 30);

INSERT INTO league (name, kürzel, img_src) VALUES ('Premier League', 'ENG', '/images/pl_logo.png');
INSERT INTO league (name, kürzel, img_src) VALUES ('La Liga', 'ESP', '/images/laliga_logo.png');

INSERT INTO team (liga_id, name) VALUES ((select id from league where name = "Premier League"), "Manchester United");
INSERT INTO team (liga_id, name) VALUES ((select id from league where name = "Premier League"), "Manchester City");
INSERT INTO team (liga_id, name) VALUES ((select id from league where name = "La Liga"), "Real Madrid");
INSERT INTO team (liga_id, name) VALUES ((select id from league where name = "La Liga"), "FC Barcelona");

INSERT INTO league_team (liga_id, mannschaft_id, tore, gegentore, punkte) VALUES ((select id from league where name = "Premier League"), (select id from team where name = "Manchester United"), 30, 15, 31);
INSERT INTO league_team (liga_id, mannschaft_id, tore, gegentore, punkte) VALUES ((select id from league where name = "Premier League"), (select id from team where name = "Manchester City"), 50, 10, 45);
INSERT INTO league_team (liga_id, mannschaft_id, tore, gegentore, punkte) VALUES ((select id from league where name = "La Liga"), (select id from team where name = "Real Madrid"), 50, 10, 45);
INSERT INTO league_team (liga_id, mannschaft_id, tore, gegentore, punkte) VALUES ((select id from league where name = "La Liga"), (select id from team where name = "FC Barcelona"), 50, 10, 45);

INSERT INTO encounter (hometeam_id, awayteam_id, datum) VALUES ((select id from team where name = "Manchester United"), (select id from team where name = "Manchester City"), '2019-12-17');
INSERT INTO encounter (hometeam_id, awayteam_id, datum, homegoals, awaygoals) VALUES ((select id from team where name = "FC Barcelona"), (select id from team where name = "Real Madrid"), '2019-12-11', 2, 1);

INSERT INTO tips (benutzer_id, begegnung_id, homegoals, awaygoals) VALUES (1, 1, 3, 4);
INSERT INTO tips (benutzer_id, begegnung_id, homegoals, awaygoals) VALUES (1, 2, 2, 1);