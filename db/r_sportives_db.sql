-- create database
CREATE DATABASE IF NOT EXISTS `r_sportives_db`;

USE `r_sportives_db`;

-- create tables
CREATE TABLE IF NOT EXISTS `personne` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `depart` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `sport` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `designation` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `pratique` (
  `personne_id` bigint NOT NULL,
  `sport_id` bigint NOT NULL,
  `niveau` varchar(255) NOT NULL,
  PRIMARY KEY (`personne_id`,`sport_id`),
  CONSTRAINT `pratique_ibfk_1` FOREIGN KEY (`personne_id`) REFERENCES `personne` (`id`),
  CONSTRAINT `pratique_ibfk_2` FOREIGN KEY (`sport_id`) REFERENCES `sport` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- Testing Requete
INSERT INTO `personne` (`nom`, `prenom`, `depart`, `email`)
VALUES  ('Martin', 'Jean', 'Paris', 'martin@martin'),
        ('Dupont', 'Jean', 'Paris', 'jean@jean.com'),
        ('Durand', 'Paul', 'Lyon', 'paul@paul.dr');

INSERT INTO `sport` (`designation`)
VALUES  ('Football'),
        ('Basket'),
        ('Tennis');

-- some queries
SELECT * FROM `personne`;
SELECT * FROM `sport`;
SELECT * FROM `pratique`;
SELECT *
FROM `personne`
WHERE id IN (SELECT personne_id
              FROM `pratique`
              WHERE sport_id IN (SELECT id FROM sport WHERE designation = 'Football' ) AND niveau = 'Intermediare'
) AND depart = 'Lyon';