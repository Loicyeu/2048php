--script to create the tables to develop the 2048 game
-- author: Christine Jacquin

-- drop the two tables if they exist
DROP TABLE IF EXISTS JOUEURS;
DROP TABLE IF EXISTS PARTIES;

--
-- Table structure for table JOUEURS
--


CREATE TABLE JOUEURS
(
  pseudo TEXT NOT NULL PRIMARY KEY ,
  password TEXT  NOT NULL
);

--
-- inserting data in JOUEURS table
--

INSERT INTO JOUEURS (`pseudo`, `password`) VALUES ('titi', '$6$VsDCW/kqInRv$/bkDT4rmkNLGo704srZE1riI4u7IUUcSuuEqrdkeBJ.3RcsnEO.ihAnWvIWJ0fSoP3hVa/OpWTbhi50xQhzEk1'),('toto', '$6$RTRffX4m9FBU$GQPzOIuRByEJMeT8r9fydj8eKfi7yurb0SQiT./3pHnG5ni2f96gboxLE4LZgCgEVMWMP6z.AxaOM8KaWJCmn0');

  
  -- Table structure for table PARTIES


CREATE TABLE PARTIES (
  id INTEGER NOT NULL PRIMARY KEY,
  pseudo TEXT CONSTRAINT fk_data_joueurs REFERENCES joueurs(pseudo),
  gagne INTEGER NOT NULL,
  score INTEGER NOT NULL
);





