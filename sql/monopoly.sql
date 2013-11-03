-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mar 08 Octobre 2013 à 13:30
-- Version du serveur: 5.1.44
-- Version de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `monopoly`
--

-- --------------------------------------------------------

--
-- Structure de la table `Action`
--

CREATE TABLE IF NOT EXISTS `Action` (
  `Id` int(10) NOT NULL,
  `Reference` int(10) NOT NULL,
  `Description` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `Action`
--

INSERT INTO `Action` (`Id`, `Reference`, `Description`) VALUES
(1, 1, 'avancer à go'),
(2, 2, 'erreur de la banque, +$200'),
(3, 3, 'frais du docteur, -$50'),
(4, 4, 'vente actions, +$45'),
(5, 5, 'sortie de prison'),
(6, 6, 'allez en prison'),
(7, 7, 'soirée d opera, +$50 par joueur'),
(8, 8, 'cadeau, +$100'),
(9, 9, 'retour impot, +20'),
(11, 11, 'ass vie, +100'),
(12, 12, 'frais du médecin, -100'),
(13, 13, 'frais étude, -100'),
(14, 14, 'services, +25'),
(15, 15, 'réno: -40 par maison, -115 par hotel'),
(16, 16, 'concours beauté, +10'),
(17, 17, 'héritage, +100'),
(18, 18, 'inutilisé'),
(19, 19, 'illinois'),
(20, 20, 'st-charles'),
(21, 21, 'service public'),
(22, 22, 'chemin de fer'),
(23, 23, 'dividende, +50'),
(24, 24, 'reculez 3 cases'),
(25, 25, 'réparation: -25 par maison, -100 par hotel'),
(26, 26, 'taxe pauvres, -15'),
(27, 27, 'Reading'),
(28, 28, 'promenade'),
(29, 29, 'élu président, -50 par joueur'),
(30, 30, 'prêts, +150'),
(31, 31, 'mot croisés, +100'),
(41, 41, 'case go'),
(42, 42, 'case CC'),
(43, 43, 'case chance'),
(44, 44, 'stationnement gratuit'),
(45, 45, 'inutilisé'),
(46, 46, 'taxe de luxe'),
(47, 47, 'impot sur revenu'),
(48, 48, 'visitez prison');

-- --------------------------------------------------------

--
-- Structure de la table `Argent`
--

CREATE TABLE IF NOT EXISTS `Argent` (
  `Montant` int(10) NOT NULL,
  `ImageBillet` varchar(40) NOT NULL,
  PRIMARY KEY (`Montant`),
  UNIQUE KEY `ImageBillet` (`ImageBillet`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `Argent`
--

INSERT INTO `Argent` (`Montant`, `ImageBillet`) VALUES
(1, 'Argent1.png'),
(10, 'Argent10.png'),
(100, 'Argent100.png'),
(20, 'Argent20.png'),
(5, 'Argent5.png'),
(50, 'Argent50.png'),
(500, 'Argent500.png');

-- --------------------------------------------------------

--
-- Structure de la table `Carte`
--

CREATE TABLE IF NOT EXISTS `Carte` (
  `Id` int(10) NOT NULL,
  `ActionId` int(10) NOT NULL,
  `TypeCarte` varchar(20) COLLATE utf8_bin NOT NULL,
  `Description` varchar(255) COLLATE utf8_bin NOT NULL,
  `Image` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `ActionId` (`ActionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `Carte`
--

INSERT INTO `Carte` (`Id`, `ActionId`, `TypeCarte`, `Description`, `Image`) VALUES
(1, 1, 'CC', 'PASSEZ GO/nRÉCLAMEZ $200)', 'imgCCAlleraGO.png'),
(2, 2, 'CC', 'ERREUR DE LA /nBANQUE EN/nVOTRE FAVEUR/nRÉCLAMEZ $200', 'imgErreurBanque.png'),
(3, 3, 'CC', 'FRAIS DU/nMÉDECIN/nPAYEZ $50', 'imgFraisDoc.png'),
(4, 4, 'CC', 'VOUS OBTENEZ/n$45/nPOUR LA VENTE/nD''ACTIONS', 'imgVenteActions.png'),
(5, 5, 'CCg', 'SORTEZ DE LA PRISON/nSANS FRAIS/nCette carte peut être/ngardée en/ncas de besoin/nou peut être vendue', 'imgSortiePrison.png'),
(6, 6, 'CC', 'ALLEZ EN PRISON/ndirectement/nNE PASSEZ PAS GO/nNERÉCLAMEZ PAS $200', 'imgAllezEnPrison.png'),
(7, 7, 'CC', 'Ouverture de l''opéra/nRÉCLAMEZ $50/NDE CHAQUE JOUEUR/nPour places du soir/nde première', 'imgOpera.png'),
(8, 8, 'CC', 'LE FONDS/nDE NOËL/nS''ACCUMULE/nRÉCLAMEZ $100', 'imgCadeauNoel.png'),
(9, 9, 'CC', 'REMBOURSEMENT/nDE L''IMPÔT SUR/nLE REVENU/nRÉCLAMEZ $20', 'imgRetourImpot.png'),
(11, 11, 'CC', 'L''ASSURANCE-VIE/nS''ACCUMULE/nRÉCLAMEZ $100', 'imgAssVie.png'),
(12, 12, 'CC', 'PAYEZ/n100$ À/nL''HÔPITAL', 'imgFraisHopital.png'),
(13, 13, 'CC', 'PAYEZ LA/nTAXE SCOLAIRE/nDE $150', 'imgFraisEtude.png'),
(14, 14, 'CC', 'RECEVEZ/n$25/nPOUR VOS/nSERVICES', 'imgService.png'),
(15, 15, 'CC', 'IMPÔT POUR/nRÉPARATIONS/nDE LA RUE/n$40 PAR MAISON/n$115 PAR HÔTEL', 'imgReno.png'),
(16, 16, 'CC', 'VOUS AVEZ GAGNEZ LE/nSECOND PRIX À UN/nCONCOURS DE/nBEAUTÉ/nRÉCLAMEZ $10', 'imgBeaute.png'),
(17, 17, 'CC', 'VOUS HÉRITEZ/nDE $100', 'imgHeritage.png'),
(18, 1, 'Chance', 'AVANCEZ/nÀ GO/n(RÉCLAMEZ $200)', 'imgCCAlleraGO.png'),
(19, 19, 'Chance', 'AVANCEZ À/nL''AVE. ILLINOIS.', 'imgCIllinois.png'),
(20, 20, 'Chance', 'AVANCEZ À LA/nPLACE ST-CHARLES/nSI VOUS PASSEZ GO RÉCLAMEZ $200', 'imgCStCharles.png'),
(21, 21, 'Chance', 'AVANCEZ VOTRE JETON/nAU "SERVICE PUBLIC"/nLE PLUS PRÈS. S''il n''est pas VENDU,/n vous pouvez l''acheter de/nla banque. S''il est VENDU,/nlancez les dès et payez/nau propriétaire dix fois le montant indiqué par les dés.', 'imgCServPublic.png'),
(22, 22, 'Chance', 'Avancez votre jeton au/nchemin de fer le plus/nproche et payez le/n double de la location au/npropriétaire, à laquelle il/na droit./nSi le chemin de fer n''est pas vendu,/nvous pouvez l''acheter de la banque', 'imgCChDeFer.png'),
(23, 23, 'Chance', 'LA BANQUE VOUS PAIE UN/n DIVIDENDE DE $50', 'imgCBanqueDividende.png'),
(24, 5, 'Chanceg', 'SORTEZ DE/nPRISON/nSANS FRAIS/nGardez cette carte jusqu''à/nce que vous en ayez besoin,/nou pour la vendre', 'imgSortiePrison.png'),
(25, 24, 'Chance', 'RECULEZ DE/n3 ESPACES', 'imgCReculer3.png'),
(26, 6, 'Chance', 'ALLEZ DIRECTEMENT/nEN PRISON/nNE PASSEZ PAS GO,NE RÉCLAMEZ PAS $200', 'imgAllezEnPrison.png'),
(27, 25, 'Chance', 'Faites des réparations géné/nrales à votre propriété./nPOUR CHAQUE MAISON/nPAYEZ $25/nPOUR CHAQUE HÔTEL, $100', 'imgReno.png'),
(28, 26, 'Chance', 'PAYEZ LA/nTAXE DES/nPAUVRES/nDE $15', 'imgTaxePauvres.png'),
(29, 27, 'Chance', 'VOYAGEZ/nPAR LE CHEMIN/nDE FER READING/nSI VOUS PASSEZ GO/nRÉCLAMEZ $200', 'imgCChReading.png'),
(30, 28, 'Chance', 'ALLEZ MARCHER SUR/nLA PROMENADE/nAVANCEZ VOTRE JETON/nSUR LA PROMENADE', 'imgCPromenade.png'),
(31, 29, 'Chance', 'Vous êtes élu/nPRÉSIDENT/nDU COMITÉ/nPAYEZ/n$50/nÀ CHAQUE JOUEUR', 'imgCPresident.png'),
(32, 30, 'Chance', 'VOTRE ÉDIFICE ET/nVOTRE PRÊT/nPRENNENT/nDE LA VALEUR/nRÉCLAMEZ $150', 'imgCPret.png');

-- --------------------------------------------------------

--
-- Structure de la table `CaseAchetable`
--

CREATE TABLE IF NOT EXISTS `CaseAchetable` (
  `Id` int(10) NOT NULL,
  `Titre` varchar(40) COLLATE utf8_bin NOT NULL,
  `GroupeDeCaseId` int(10) NOT NULL,
  `Prix` int(10) NOT NULL,
  `Location` int(10) NOT NULL,
  `Location1Maison` int(10) NOT NULL,
  `Location2Maison` int(10) NOT NULL,
  `Location3Maison` int(10) NOT NULL,
  `Location4Maison` int(10) NOT NULL,
  `LocationHotel` int(10) NOT NULL,
  `CoutMaison` int(10) NOT NULL,
  `CoutHotel` int(10) NOT NULL,
  `Hypotheque` int(10) NOT NULL,
  `URLlogo` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `GroupeDeCaseId` (`GroupeDeCaseId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `CaseAchetable`
--

INSERT INTO `CaseAchetable` (`Id`, `Titre`, `GroupeDeCaseId`, `Prix`, `Location`, `Location1Maison`, `Location2Maison`, `Location3Maison`, `Location4Maison`, `LocationHotel`, `CoutMaison`, `CoutHotel`, `Hypotheque`, `URLlogo`) VALUES
(1, 'Avenue de la Méditérranée', 1, 60, 2, 10, 30, 90, 160, 250, 30, 50, 50, 'propriete1.png'),
(3, 'Avenue de la Baltique', 1, 60, 4, 20, 60, 180, 320, 450, 30, 50, 50, 'propriete1.png'),
(5, 'Chemin de fer Reading', 8, 200, 25, 50, 100, 200, 0, 0, 100, 0, 0, 'propriete2.png'),
(6, 'Avenue de l''Orient', 2, 100, 6, 30, 90, 270, 400, 550, 50, 50, 50, 'propriete1.png'),
(8, 'Avenue Vermont', 2, 100, 6, 30, 90, 270, 400, 550, 50, 50, 50, 'propriete1.png'),
(9, 'Avenue Connecticut', 2, 120, 8, 40, 100, 300, 450, 600, 60, 50, 50, 'propriete1.png'),
(11, 'Place St-Charles', 3, 140, 10, 50, 150, 450, 625, 750, 70, 100, 100, 'propriete1.png'),
(12, 'Compagnie d''électricité', 10, 150, 0, 4, 10, 0, 0, 0, 75, 0, 0, 'propriete3.png'),
(13, 'Ave. Des Etats-Unis', 3, 140, 10, 50, 150, 450, 625, 750, 70, 100, 100, 'propriete1.png'),
(14, 'Avenue Virginie', 3, 160, 12, 60, 180, 500, 700, 900, 80, 100, 100, 'propriete1.png'),
(15, 'Chemin de fer Pennsylvanie', 8, 200, 25, 50, 100, 200, 0, 0, 100, 0, 0, 'propriete2.png'),
(16, 'Place St-Jacques', 4, 180, 14, 70, 200, 550, 750, 950, 90, 100, 100, 'propriete1.png'),
(18, 'Avenue Tennessee', 4, 180, 14, 70, 200, 550, 750, 950, 90, 100, 100, 'propriete1.png'),
(19, 'Avenue New York', 4, 200, 16, 80, 220, 600, 800, 1000, 100, 100, 100, 'propriete1.png'),
(21, 'Avenue Kentucky', 5, 220, 18, 90, 250, 700, 875, 1050, 110, 150, 150, 'propriete1.png'),
(23, 'Avenue Indiana ', 5, 220, 18, 90, 250, 700, 875, 1050, 110, 150, 150, 'propriete1.png'),
(24, 'Avenue Illinois', 5, 240, 20, 100, 300, 750, 925, 1100, 120, 150, 150, 'propriete1.png'),
(25, 'Chemin de fer B. & O.', 8, 200, 25, 50, 100, 200, 0, 0, 100, 0, 0, 'propriete2.png'),
(26, 'Avenue Atlantique', 6, 260, 22, 110, 330, 800, 975, 1150, 130, 150, 150, 'propriete1.png'),
(27, 'Avenue Ventnor', 6, 260, 22, 110, 330, 800, 975, 1150, 130, 150, 150, 'propriete1.png'),
(28, 'Aqueduc', 10, 150, 0, 4, 10, 0, 0, 0, 75, 0, 0, 'propriete3.png'),
(29, 'Jardins Marvin', 6, 280, 24, 120, 360, 850, 1025, 1200, 140, 150, 150, 'propriete1.png'),
(31, 'Ave du Pacifique', 9, 300, 26, 130, 390, 900, 1100, 1275, 150, 200, 200, 'propriete1.png'),
(32, 'Avenue Caroline du nord', 9, 300, 26, 130, 390, 900, 1100, 1275, 150, 200, 200, 'propriete1.png'),
(34, 'Avenue Pennsylvanie', 9, 320, 28, 150, 450, 1000, 1200, 1400, 160, 200, 200, 'propriete1.png'),
(35, 'Chemin de fer Petit Réseau', 8, 200, 25, 50, 100, 200, 0, 0, 100, 0, 0, 'propriete2.png'),
(37, 'Promenade', 7, 400, 50, 200, 600, 1400, 1700, 2000, 200, 200, 200, 'propriete1.png'),
(39, 'Place du parc', 7, 350, 35, 175, 500, 1100, 1300, 1500, 175, 200, 200, 'propriete1.png');

-- --------------------------------------------------------

--
-- Structure de la table `CaseAction`
--

CREATE TABLE IF NOT EXISTS `CaseAction` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `ActionID` int(11) NOT NULL,
  `Nom` varchar(45) COLLATE utf8_bin NOT NULL,
  `Image` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_CaseAction_Action1_Idx` (`ActionID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=9 ;

--
-- Contenu de la table `CaseAction`
--

INSERT INTO `CaseAction` (`ID`, `ActionID`, `Nom`, `Image`) VALUES
(1, 41, 'Go', 'imgCaseGo.png'),
(2, 42, 'Caisse Commune', 'imgCaseCaisse.png'),
(3, 43, 'Chance', 'imgCaseChance.png'),
(4, 44, 'Stationnement gratuit', 'imgCaseStationnement.png'),
(5, 6, 'Allez en prison', 'imgCasePolice.png'),
(6, 46, 'Taxe de luxe', 'imgCaseTaxe.png'),
(7, 47, 'Impot sur le revenu', 'imgCaseImpot.png'),
(8, 48, 'Visitez la prison', 'imgCasePrison.png');

-- --------------------------------------------------------

--
-- Structure de la table `DefinitionPartie`
--

CREATE TABLE IF NOT EXISTS `DefinitionPartie` (
  `Id` int(10) NOT NULL,
  `Nom` varchar(10) COLLATE utf8_bin NOT NULL,
  `Description` text COLLATE utf8_bin NOT NULL,
  `MaxNbJoueur` int(10) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `DefinitionPartie`
--

INSERT INTO `DefinitionPartie` (`Id`, `Nom`, `Description`, `MaxNbJoueur`) VALUES
(1, 'Courte', 0x556e652070617274696520636f75727465, 4),
(2, 'longue', 0x556e652070617274696520646520313420686575726573, 8);

-- --------------------------------------------------------

--
-- Structure de la table `DefinitionPartie_Argent`
--

CREATE TABLE IF NOT EXISTS `DefinitionPartie_Argent` (
  `DefinitionPartieId` int(10) NOT NULL,
  `ArgentMontant` int(10) NOT NULL,
  `Quantite` int(10) NOT NULL,
  PRIMARY KEY (`DefinitionPartieId`,`ArgentMontant`),
  KEY `ArgentMontant` (`ArgentMontant`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `DefinitionPartie_Argent`
--

INSERT INTO `DefinitionPartie_Argent` (`DefinitionPartieId`, `ArgentMontant`, `Quantite`) VALUES
(1, 1, 5),
(1, 5, 5),
(1, 10, 7),
(1, 20, 5),
(1, 50, 2),
(1, 100, 7),
(1, 500, 1),
(2, 5, 1),
(2, 10, 50),
(2, 20, 50),
(2, 50, 50),
(2, 100, 50);

-- --------------------------------------------------------

--
-- Structure de la table `DefinitionPartie_Carte`
--

CREATE TABLE IF NOT EXISTS `DefinitionPartie_Carte` (
  `DefinitionPartieId` int(10) NOT NULL,
  `CarteId` int(10) NOT NULL,
  PRIMARY KEY (`DefinitionPartieId`,`CarteId`),
  KEY `CarteId` (`CarteId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `DefinitionPartie_Carte`
--

INSERT INTO `DefinitionPartie_Carte` (`DefinitionPartieId`, `CarteId`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 11),
(1, 12),
(1, 13),
(1, 14),
(1, 15),
(1, 16),
(1, 17),
(1, 18),
(1, 19),
(1, 20),
(1, 21),
(1, 22),
(1, 23),
(1, 24),
(1, 25),
(1, 26),
(1, 27),
(1, 28),
(1, 29),
(1, 30),
(1, 31),
(1, 32);

-- --------------------------------------------------------

--
-- Structure de la table `DefinitionPartie_CaseAchetable`
--

CREATE TABLE IF NOT EXISTS `DefinitionPartie_CaseAchetable` (
  `DefinitionPartieId` int(10) NOT NULL,
  `CaseAchetableId` int(10) NOT NULL,
  `Position` int(10) NOT NULL,
  KEY `DefinitionPartieId` (`DefinitionPartieId`,`CaseAchetableId`),
  KEY `CaseAchetableId` (`CaseAchetableId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `DefinitionPartie_CaseAchetable`
--

INSERT INTO `DefinitionPartie_CaseAchetable` (`DefinitionPartieId`, `CaseAchetableId`, `Position`) VALUES
(1, 1, 1),
(1, 3, 3),
(1, 5, 5),
(1, 6, 6),
(1, 8, 8),
(1, 9, 9),
(1, 11, 11),
(1, 12, 12),
(1, 13, 13),
(1, 14, 14),
(1, 15, 15),
(1, 16, 16),
(1, 18, 18),
(1, 19, 19),
(1, 21, 21),
(1, 23, 23),
(1, 24, 24),
(1, 25, 25),
(1, 26, 26),
(1, 27, 27),
(1, 28, 28),
(1, 29, 29),
(1, 31, 31),
(1, 32, 32),
(1, 34, 34),
(1, 35, 35),
(1, 37, 37),
(1, 39, 39);

-- --------------------------------------------------------

--
-- Structure de la table `DefinitionPartie_CaseAction`
--

CREATE TABLE IF NOT EXISTS `DefinitionPartie_CaseAction` (
  `DefinitionPartieId` int(10) NOT NULL,
  `CaseActionId` int(10) NOT NULL,
  `Position` int(10) NOT NULL,
  PRIMARY KEY (`DefinitionPartieId`,`CaseActionId`,`Position`),
  KEY `DefinitionPartie_CaseAction_ibfk_2` (`CaseActionId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `DefinitionPartie_CaseAction`
--

INSERT INTO `DefinitionPartie_CaseAction` (`DefinitionPartieId`, `CaseActionId`, `Position`) VALUES
(1, 1, 0),
(1, 2, 2),
(1, 2, 17),
(1, 2, 33),
(1, 3, 7),
(1, 3, 22),
(1, 3, 36),
(1, 4, 20),
(1, 5, 30),
(1, 6, 38),
(1, 7, 4),
(1, 8, 10);

-- --------------------------------------------------------

--
-- Structure de la table `DefinitionPartie_Pion`
--

CREATE TABLE IF NOT EXISTS `DefinitionPartie_Pion` (
  `DefinitionPartieId` int(10) NOT NULL,
  `PionId` int(10) NOT NULL,
  PRIMARY KEY (`DefinitionPartieId`,`PionId`),
  KEY `PionId` (`PionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `DefinitionPartie_Pion`
--

INSERT INTO `DefinitionPartie_Pion` (`DefinitionPartieId`, `PionId`) VALUES
(1, 1),
(2, 1),
(1, 2),
(2, 2),
(1, 3),
(2, 3),
(1, 4),
(2, 4),
(2, 5),
(2, 6),
(2, 7),
(2, 8);

-- --------------------------------------------------------

--
-- Structure de la table `GroupeDeCase`
--

CREATE TABLE IF NOT EXISTS `GroupeDeCase` (
  `Id` int(10) NOT NULL,
  `IsCheminDeFer` tinyint(1) NOT NULL,
  `IsServicePublique` tinyint(1) NOT NULL,
  `Couleur` varchar(10) COLLATE utf8_bin NOT NULL,
  `CouleurHTML` varchar(7) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `GroupeDeCase`
--

INSERT INTO `GroupeDeCase` (`Id`, `IsCheminDeFer`, `IsServicePublique`, `Couleur`, `CouleurHTML`) VALUES
(1, 0, 0, 'Mauve', '#86066E'),
(2, 0, 0, 'BleuPoudre', '#57D3F2'),
(3, 0, 0, 'Rose', '#ECA0F2'),
(4, 0, 0, 'Orange', '#DD6938'),
(5, 0, 0, 'Rouge', '#FF0000'),
(6, 0, 0, 'Jaune', '#FFFF00'),
(7, 0, 0, 'Bleu', '#0000FF'),
(8, 1, 0, 'train', '#000000'),
(9, 0, 0, 'Vert', '#00FF00'),
(10, 0, 1, 'service', '#000000');

-- --------------------------------------------------------

--
-- Structure de la table `JoueurPartie`
--

CREATE TABLE IF NOT EXISTS `JoueurPartie` (
  `UsagerCompte` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `PartieEnCoursId` int(10) NOT NULL,
  `PionId` int(10) NOT NULL,
  `Position` int(10) NOT NULL,
  `OrdreDeJeu` int(10) NOT NULL,
  `EnPrison` tinyint(1) NOT NULL,
  `ToursRestants_Prison` int(10) NOT NULL,
  PRIMARY KEY (`UsagerCompte`,`PartieEnCoursId`),
  KEY `JoueurPartie_fk2` (`PartieEnCoursId`),
  KEY `JoueurPartie_fk3` (`PionId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `JoueurPartie`
--

INSERT INTO `JoueurPartie` (`UsagerCompte`, `PartieEnCoursId`, `PionId`, `Position`, `OrdreDeJeu`, `EnPrison`, `ToursRestants_Prison`) VALUES
('benoit', 1, 1, 0, 1, 0, 0),
('marc', 1, 3, 0, 3, 0, 0),
('tom', 1, 2, 0, 2, 0, 0),
('vero', 1, 4, 0, 4, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `JoueurPartie_Argent`
--

CREATE TABLE IF NOT EXISTS `JoueurPartie_Argent` (
  `ArgentMontant` int(10) NOT NULL,
  `JoueurPartieUsagerCompte` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `JoueurPartiePartieEnCoursId` int(10) NOT NULL,
  `Quantite` int(11) NOT NULL,
  PRIMARY KEY (`ArgentMontant`,`JoueurPartieUsagerCompte`,`JoueurPartiePartieEnCoursId`),
  KEY `fk2_JoueurPartieargent` (`JoueurPartieUsagerCompte`),
  KEY `fk3_JoueurPartieargent` (`JoueurPartiePartieEnCoursId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `JoueurPartie_Argent`
--

INSERT INTO `JoueurPartie_Argent` (`ArgentMontant`, `JoueurPartieUsagerCompte`, `JoueurPartiePartieEnCoursId`, `Quantite`) VALUES
(1, 'benoit', 1, 10),
(1, 'marc', 1, 0),
(1, 'tom', 1, 0),
(1, 'vero', 1, 0),
(5, 'benoit', 1, 3),
(5, 'marc', 1, 2),
(5, 'tom', 1, 2),
(5, 'vero', 1, 2),
(10, 'benoit', 1, 3),
(10, 'marc', 1, 3),
(10, 'tom', 1, 3),
(10, 'vero', 1, 5),
(50, 'benoit', 1, 2),
(50, 'marc', 1, 2),
(50, 'tom', 1, 4),
(50, 'vero', 1, 2),
(100, 'benoit', 1, 1),
(100, 'marc', 1, 4),
(100, 'tom', 1, 7),
(100, 'vero', 1, 4),
(500, 'benoit', 1, 0),
(500, 'marc', 1, 0),
(500, 'tom', 1, 0),
(500, 'vero', 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `JoueurPartie_Carte`
--

CREATE TABLE IF NOT EXISTS `JoueurPartie_Carte` (
  `JoueurPartieUsagerCompte` varchar(40) COLLATE utf8_bin NOT NULL,
  `JoueurPartiePartieEnCoursId` int(10) NOT NULL,
  `CarteId` int(10) NOT NULL,
  KEY `JoueurPartieUsagerCompte` (`JoueurPartieUsagerCompte`,`JoueurPartiePartieEnCoursId`,`CarteId`),
  KEY `JoueurPartieUsagerCompte_2` (`JoueurPartieUsagerCompte`),
  KEY `JoueurPartiePartieEnCoursId` (`JoueurPartiePartieEnCoursId`),
  KEY `CarteId` (`CarteId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `JoueurPartie_Carte`
--

INSERT INTO `JoueurPartie_Carte` (`JoueurPartieUsagerCompte`, `JoueurPartiePartieEnCoursId`, `CarteId`) VALUES
('marc', 1, 24);

-- --------------------------------------------------------

--
-- Structure de la table `JoueurPartie_CaseAchetable`
--

CREATE TABLE IF NOT EXISTS `JoueurPartie_CaseAchetable` (
  `JoueurPartieUsagerCompte` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `JoueurPartiePartieEnCoursId` int(10) NOT NULL,
  `CaseAchetableId` int(10) NOT NULL,
  `OrdreAffichage` int(10) NOT NULL,
  `Hypotheque` tinyint(1) NOT NULL,
  `NombreMaisons` int(10) NOT NULL,
  `NombreHotels` int(11) NOT NULL,
  PRIMARY KEY (`JoueurPartieUsagerCompte`,`JoueurPartiePartieEnCoursId`,`CaseAchetableId`),
  KEY `JoueurPartie_CaseAchetable_ibfk_1` (`CaseAchetableId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `JoueurPartie_CaseAchetable`
--

INSERT INTO `JoueurPartie_CaseAchetable` (`JoueurPartieUsagerCompte`, `JoueurPartiePartieEnCoursId`, `CaseAchetableId`, `OrdreAffichage`, `Hypotheque`, `NombreMaisons`, `NombreHotels`) VALUES
('benoit', 1, 1, 1, 0, 2, 0),
('benoit', 1, 3, 2, 0, 0, 1),
('benoit', 1, 6, 3, 0, 0, 1),
('marc', 1, 5, 1, 0, 0, 0),
('marc', 1, 15, 2, 0, 0, 0),
('marc', 1, 25, 3, 0, 0, 0),
('marc', 1, 35, 4, 0, 0, 0),
('tom', 1, 18, 2, 1, 0, 0),
('tom', 1, 21, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `PartieEnCours`
--

CREATE TABLE IF NOT EXISTS `PartieEnCours` (
  `Id` int(10) NOT NULL AUTO_INCREMENT,
  `Coordonnateur` varchar(40) COLLATE utf8_bin NOT NULL,
  `DefinitionPartieId` int(10) NOT NULL,
  `Nom` varchar(40) COLLATE utf8_bin NOT NULL,
  `JoueurTour` int(10) NOT NULL,
  `DebutPartie` datetime NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `Coordonnateur` (`Coordonnateur`),
  KEY `DefinitionPartieId` (`DefinitionPartieId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `PartieEnCours`
--

INSERT INTO `PartieEnCours` (`Id`, `Coordonnateur`, `DefinitionPartieId`, `Nom`, `JoueurTour`, `DebutPartie`) VALUES
(1, 'benoit', 1, 'Partie1', 1, '0000-00-00 00:00:00'),
(2, 'benoit', 2, 'Partie2', 2, '0000-00-00 00:00:00'),
(3, 'benoit', 1, 'Partie3', 1, '0000-00-00 00:00:00'),
(4, 'benoit', 1, 'Partie4', 1, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `PartieEnCours_CarteCC`
--

CREATE TABLE IF NOT EXISTS `PartieEnCours_CarteCC` (
  `PartieEnCoursId` int(10) NOT NULL,
  `CarteId` int(10) NOT NULL,
  `Position` int(10) NOT NULL,
  PRIMARY KEY (`PartieEnCoursId`,`CarteId`),
  KEY `PartieEnCours_CarteCC_ibfk_2` (`CarteId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `PartieEnCours_CarteCC`
--

INSERT INTO `PartieEnCours_CarteCC` (`PartieEnCoursId`, `CarteId`, `Position`) VALUES
(1, 1, 1),
(1, 2, 2),
(1, 3, 3),
(1, 4, 4),
(1, 5, 5),
(1, 6, 6),
(1, 7, 7),
(1, 8, 8),
(1, 9, 9),
(1, 11, 10),
(1, 12, 11),
(1, 13, 12),
(1, 14, 13),
(1, 15, 14),
(1, 16, 15),
(1, 17, 16);

-- --------------------------------------------------------

--
-- Structure de la table `PartieEnCours_CarteChance`
--

CREATE TABLE IF NOT EXISTS `PartieEnCours_CarteChance` (
  `PartieEnCoursId` int(10) NOT NULL,
  `CarteId` int(10) NOT NULL,
  `Position` int(10) NOT NULL,
  PRIMARY KEY (`PartieEnCoursId`,`CarteId`),
  KEY `PartieEnCours_CarteChance_ibfk_2` (`CarteId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `PartieEnCours_CarteChance`
--

INSERT INTO `PartieEnCours_CarteChance` (`PartieEnCoursId`, `CarteId`, `Position`) VALUES
(1, 18, 1),
(1, 19, 2),
(1, 20, 3),
(1, 21, 4),
(1, 22, 5),
(1, 23, 6),
(1, 24, 7),
(1, 25, 8),
(1, 26, 9),
(1, 27, 10),
(1, 28, 11),
(1, 29, 12),
(1, 30, 13),
(1, 31, 14),
(1, 32, 15);

-- --------------------------------------------------------

--
-- Structure de la table `Pion`
--

CREATE TABLE IF NOT EXISTS `Pion` (
  `Id` int(10) NOT NULL,
  `Nom` varchar(50) COLLATE utf8_bin NOT NULL,
  `ImageUrl` varchar(255) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `Pion`
--

INSERT INTO `Pion` (`Id`, `Nom`, `ImageUrl`) VALUES
(0, 'dummy', 'imgDummy'),
(1, 'voiture de course', 'ImgPionVoiture.png'),
(2, 'brouette', 'ImgPionBrouette.png'),
(3, 'fer à repasser', 'ImgPionFer.png'),
(4, 'cheval', 'ImgPionCheval.png'),
(5, 'bateau', 'ImgPionBateau.png'),
(6, 'train', 'ImgPionTrain.png'),
(7, 'canon', 'ImgPionCanon.png'),
(8, 'dé', 'ImgPionDe.png'),
(9, 'chapeau', 'ImgPionChapeau.png'),
(10, 'bottine', 'ImgPionBottine.png'),
(11, 'chien', 'ImgPionChien.png'),
(12, 'lampe', 'ImgPionLampe.png');

-- --------------------------------------------------------

--
-- Structure de la table `Usager`
--

CREATE TABLE IF NOT EXISTS `Usager` (
  `Compte` varchar(40) COLLATE utf8_bin NOT NULL,
  `Nom` varchar(40) COLLATE utf8_bin NOT NULL,
  `MotDePasse` varchar(40) COLLATE utf8_bin NOT NULL,
  `Role` enum('joueur','coordonnateur') COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`Compte`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `Usager`
--

INSERT INTO `Usager` (`Compte`, `Nom`, `MotDePasse`, `Role`) VALUES
('benoit', 'Benoit Desrosiers', '1a91d62f7ca67399625a4368a6ab5d4a3baa6073', 'coordonnateur'),
('marc', 'Marc-André', '1a91d62f7ca67399625a4368a6ab5d4a3baa6073', 'joueur'),
('tom', 'Tommy', '1a91d62f7ca67399625a4368a6ab5d4a3baa6073', 'joueur'),
('vero', 'Veronique', '1a91d62f7ca67399625a4368a6ab5d4a3baa6073', 'coordonnateur');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `Carte`
--
ALTER TABLE `Carte`
  ADD CONSTRAINT `Carte_ibfk_1` FOREIGN KEY (`ActionId`) REFERENCES `action` (`Id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `CaseAchetable`
--
ALTER TABLE `CaseAchetable`
  ADD CONSTRAINT `CaseAchetable_ibfk_1` FOREIGN KEY (`GroupeDeCaseId`) REFERENCES `groupedecase` (`Id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `CaseAction`
--
ALTER TABLE `CaseAction`
  ADD CONSTRAINT `fk_CaseAction_Action1` FOREIGN KEY (`ActionID`) REFERENCES `action` (`Id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `DefinitionPartie_Argent`
--
ALTER TABLE `DefinitionPartie_Argent`
  ADD CONSTRAINT `DefinitionPartie_Argent_ibfk_1` FOREIGN KEY (`DefinitionPartieId`) REFERENCES `definitionpartie` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `DefinitionPartie_Argent_ibfk_2` FOREIGN KEY (`ArgentMontant`) REFERENCES `argent` (`Montant`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `DefinitionPartie_Carte`
--
ALTER TABLE `DefinitionPartie_Carte`
  ADD CONSTRAINT `DefinitionPartie_Carte_ibfk_1` FOREIGN KEY (`DefinitionPartieId`) REFERENCES `definitionpartie` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `DefinitionPartie_Carte_ibfk_2` FOREIGN KEY (`CarteId`) REFERENCES `carte` (`Id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `DefinitionPartie_CaseAchetable`
--
ALTER TABLE `DefinitionPartie_CaseAchetable`
  ADD CONSTRAINT `DefinitionPartie_CaseAchetable_ibfk_1` FOREIGN KEY (`CaseAchetableId`) REFERENCES `caseachetable` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `DefinitionPartie_CaseAchetable_ibfk_2` FOREIGN KEY (`DefinitionPartieId`) REFERENCES `definitionpartie` (`Id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `DefinitionPartie_CaseAction`
--
ALTER TABLE `DefinitionPartie_CaseAction`
  ADD CONSTRAINT `DefinitionPartie_CaseAction_ibfk_1` FOREIGN KEY (`DefinitionPartieId`) REFERENCES `definitionpartie` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `DefinitionPartie_CaseAction_ibfk_2` FOREIGN KEY (`CaseActionId`) REFERENCES `caseaction` (`ID`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `DefinitionPartie_Pion`
--
ALTER TABLE `DefinitionPartie_Pion`
  ADD CONSTRAINT `DefinitionPartie_Pion_ibfk_1` FOREIGN KEY (`DefinitionPartieId`) REFERENCES `definitionpartie` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `DefinitionPartie_Pion_ibfk_2` FOREIGN KEY (`PionId`) REFERENCES `pion` (`Id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `JoueurPartie`
--
ALTER TABLE `JoueurPartie`
  ADD CONSTRAINT `JoueurPartie_fk` FOREIGN KEY (`UsagerCompte`) REFERENCES `usager` (`Compte`) ON UPDATE CASCADE,
  ADD CONSTRAINT `JoueurPartie_fk2` FOREIGN KEY (`PartieEnCoursId`) REFERENCES `partieencours` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `JoueurPartie_fk3` FOREIGN KEY (`PionId`) REFERENCES `pion` (`Id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `JoueurPartie_Argent`
--
ALTER TABLE `JoueurPartie_Argent`
  ADD CONSTRAINT `fk4_JoueurPartieargent` FOREIGN KEY (`JoueurPartieUsagerCompte`,`JoueurPartiePartieEnCoursId`) REFERENCES `joueurpartie` (`UsagerCompte`,`PartieEnCoursId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_JoueurPartieargent` FOREIGN KEY (`ArgentMontant`) REFERENCES `argent` (`Montant`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `JoueurPartie_Carte`
--
ALTER TABLE `JoueurPartie_Carte`
  ADD CONSTRAINT `JoueurPartie_Carte_ibfk_1` FOREIGN KEY (`CarteId`) REFERENCES `carte` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `JoueurPartie_Carte_ibfk_2` FOREIGN KEY (`JoueurPartiePartieEnCoursId`) REFERENCES `joueurpartie` (`PartieEnCoursId`) ON UPDATE CASCADE,
  ADD CONSTRAINT `JoueurPartie_Carte_ibfk_3` FOREIGN KEY (`JoueurPartieUsagerCompte`) REFERENCES `joueurpartie` (`UsagerCompte`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `JoueurPartie_CaseAchetable`
--
ALTER TABLE `JoueurPartie_CaseAchetable`
  ADD CONSTRAINT `JoueurPartie_CaseAchetable_ibfk_1` FOREIGN KEY (`CaseAchetableId`) REFERENCES `caseachetable` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `JoueurPartie_CaseAchetable_ibfk_2` FOREIGN KEY (`JoueurPartieUsagerCompte`) REFERENCES `joueurpartie` (`UsagerCompte`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `PartieEnCours`
--
ALTER TABLE `PartieEnCours`
  ADD CONSTRAINT `PartieEnCours_ibfk_1` FOREIGN KEY (`Coordonnateur`) REFERENCES `usager` (`Compte`) ON UPDATE CASCADE,
  ADD CONSTRAINT `PartieEnCours_ibfk_2` FOREIGN KEY (`DefinitionPartieId`) REFERENCES `definitionpartie` (`Id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `PartieEnCours_CarteCC`
--
ALTER TABLE `PartieEnCours_CarteCC`
  ADD CONSTRAINT `PartieEnCours_CarteCC_ibfk_1` FOREIGN KEY (`PartieEnCoursId`) REFERENCES `partieencours` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `PartieEnCours_CarteCC_ibfk_2` FOREIGN KEY (`CarteId`) REFERENCES `carte` (`Id`) ON UPDATE CASCADE;

--
-- Contraintes pour la table `PartieEnCours_CarteChance`
--
ALTER TABLE `PartieEnCours_CarteChance`
  ADD CONSTRAINT `PartieEnCours_CarteChance_ibfk_1` FOREIGN KEY (`PartieEnCoursId`) REFERENCES `partieencours` (`Id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `PartieEnCours_CarteChance_ibfk_2` FOREIGN KEY (`CarteId`) REFERENCES `carte` (`Id`) ON UPDATE CASCADE;
