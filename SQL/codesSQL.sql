CREATE TABLE employe (
	num_employe CHAR(8),
	nom_employe CHARACTER VARYING (25),
	prenom_employe CHARACTER VARYING (30),
	mail_employe CHARACTER VARYING (50),
    tel_employe CHAR(10),
	type_contrat CHARACTER VARYING (25),
	salaire FLOAT CHECK (salaire > 1539.42),
	poste CHARACTER VARYING (50),
    CONSTRAINT check_tel_employe CHECK (LENGTH(tel_employe) = 10),
    CONSTRAINT employe_UQ UNIQUE(tel_employe),
	CONSTRAINT employe_PK PRIMARY KEY (num_employe)
);

CREATE TABLE badge (
	num_badge CHAR(5),
	droitAccess BOOLEAN,
	tentative_access INT,
	CONSTRAINT badge_PK PRIMARY KEY (num_badge)
);

CREATE TABLE chambre (
	num_chambre CHAR(5),
	capacite INT CHECK (capacite > 0),
	type_chambre CHARACTER VARYING (50),
	occupation BOOLEAN,
	tel_chambre CHAR(10),
	num_etage INT CHECK (num_etage >= -2 AND num_etage <= 15),
	prix FLOAT CHECK (prix >= 0),
	description TEXT,
    CONSTRAINT check_tel_chambre CHECK (LENGTH(tel_chambre) = 10),
    CONSTRAINT chambre_UQ UNIQUE(tel_chambre),
	CONSTRAINT chambre_PK PRIMARY KEY (num_chambre)
);

CREATE TABLE reservation (
	num_reservation CHAR(10),
	date_reservation DATE,
	prixPaiement FLOAT CHECK (prixPaiement >= 0),
	date_debut DATE,
	date_fin DATE,
	CONSTRAINT reservation_PK PRIMARY KEY (num_reservation)
);

CREATE TABLE client (
	num_client CHAR(10),
	nom_client CHARACTER VARYING (25),
	prenom_client CHARACTER VARYING (25),
	mail_client CHARACTER VARYING (50),
	tel_client CHAR(10),
	addr_client CHARACTER VARYING (100),
	num_chambre CHAR(5),
    CONSTRAINT check_tel_client CHECK (LENGTH(tel_client) = 10),
	CONSTRAINT client_PK PRIMARY KEY (num_client),
	CONSTRAINT client_FK FOREIGN KEY (num_chambre) REFERENCES chambre (num_chambre)
);

CREATE TABLE effectuer (
	num_client CHAR(10),
	num_reservation CHAR(10),
	CONSTRAINT effectuer_PK PRIMARY KEY (num_client, num_reservation),
	CONSTRAINT effectuer_FK1 FOREIGN KEY (num_client) REFERENCES client (num_client),
	CONSTRAINT effectuer_FK2 FOREIGN KEY (num_reservation) REFERENCES reservation (num_reservation)
);

CREATE TABLE accede (
	num_badge CHAR(5),
	num_chambre CHAR(5),
	CONSTRAINT possede_PK PRIMARY KEY (num_badge, num_chambre),
	CONSTRAINT possede_FK1 FOREIGN KEY (num_badge) REFERENCES badge (num_badge),
	CONSTRAINT possede_FK2 FOREIGN KEY (num_chambre) REFERENCES chambre (num_chambre)
);

CREATE TABLE possede_client (
	num_badge CHAR(5),
	num_client CHAR(10),
	CONSTRAINT possede_client_PK PRIMARY KEY (num_badge, num_client),
	CONSTRAINT possede_FK1 FOREIGN KEY (num_badge) REFERENCES badge (num_badge),
	CONSTRAINT possede_FK2 FOREIGN KEY (num_client) REFERENCES client (num_client)
);

CREATE TABLE possede_employe (
	num_badge CHAR(5),
	num_employe CHAR(8),
	CONSTRAINT possede_employe_PK PRIMARY KEY (num_badge, num_employe),
	CONSTRAINT possede_FK1 FOREIGN KEY (num_badge) REFERENCES badge (num_badge),
	CONSTRAINT possede_FK2 FOREIGN KEY (num_employe) REFERENCES employe (num_employe)
);

CREATE TABLE departments (
	num_departement CHAR(2),
	nom_department CHARACTER VARYING (50),
	responsable_departement CHARACTER VARYING (24),
	nbre_personnels INT CHECK (nbre_personnels >= 0),
	type_departement CHARACTER VARYING (25),
	description TEXT,
	num_employe CHAR(8),
    CONSTRAINT departement_UQ UNIQUE(nom_department),
	CONSTRAINT departments_PK PRIMARY KEY (num_departement),
	CONSTRAINT departments_FK FOREIGN KEY (num_employe) REFERENCES employe (num_employe)
);

CREATE TABLE facture (
	num_facture CHAR(8),
	somme_totale FLOAT CHECK (somme_totale >= 0),
	date_facture DATE,
	num_reservation CHAR(10),
	num_client CHAR(10),
	CONSTRAINT facture_PK PRIMARY KEY (num_facture),
	CONSTRAINT facture_FK1 FOREIGN KEY (num_reservation) REFERENCES reservation (num_reservation),
	CONSTRAINT facture_FK2 FOREIGN KEY (num_client) REFERENCES client (num_client)
);

CREATE TABLE est_compter_dans (
	num_departement CHAR(2),
	num_facture CHAR(8),
	CONSTRAINT est_compter_dans_PK PRIMARY KEY (num_departement, num_facture),
	CONSTRAINT est_compter_dans_FK1 FOREIGN KEY (num_departement) REFERENCES departments (num_departement),
	CONSTRAINT est_compter_dans_FK2 FOREIGN KEY (num_facture) REFERENCES facture (num_facture)
);

--jeu de données

INSERT INTO employe(num_employe, nom_employe, prenom_employe, mail_employe, tel_employe, type_contrat, salaire, poste) VALUES
('ht701294', 'Gilbert', 'Levasseur', 'GilbertLevasseur@armyspy.com', '0696067386', 'CDD', 2536.26, 'Surveiller'),
('ht193121', 'Zdenek', 'Mercure', 'ZdenekMercure@teleworm.us', '0715502305', 'CDD', 5246.35, 'Manager'),
('ht183091', 'Ferragus', 'Caya', 'FerragusCaya@armyspy.com', '0605618427', 'CDI', 3684.01, 'Responsable restauration'),
('ht182033', 'Sébastien', 'Courcelle', 'SebastienCourcelle@dayrep.com', '0752164436', 'CDI', 1956.66, 'Receptionniste'),
('ht150128', 'Varden', 'Chalut', 'VardenChalut@rhyta.com', '0798762840', 'CDD', 1754.84, 'Serveur'),
('ht150127', 'Lavigne', 'Anna', 'anna@rhyta.com', '0798762841', 'CDD', 2200, 'Manager service ménager');

INSERT INTO badge(num_badge, droitAccess, tentative_access) VALUES
('b1102', TRUE, 0),
('b1149', TRUE, 0),
('b2185', TRUE, 0),
('b2653', TRUE, 0),
('b2811', TRUE, 0);

INSERT INTO chambre (num_chambre, capacite, type_chambre, occupation, tel_chambre, num_etage, prix, description) VALUES
('10001', 2, 'double deluxe', FALSE, '0952525252', 1, 200, 'chambre avec une balcon et possiblité de voir la plage de lexterieur'),
('20001', 1, 'simple', TRUE, '0962626262', 2, 50, 'chambre simple avec une lit'),
('50001', 40, 'Spéciale pour party', FALSE, '0972727272', 5, 10000, 'piscine, terrace avec une petite jardin, cuisine extérieur, des tables et bancs etc...'),
('10002', NULL, 'Chambre Surveillance camera', TRUE, '0982828282', 12, NULL, 'chambre de surveillance'),
('30005', 1, 'chambre luxe', TRUE, '0963636363', 13, 150, 'permet de avoir une vue globale de la cité et nottament accées à une télescope pour visualiser la ciel pendant la nuit'),
('10003', NULL, 'Sérveur des données', TRUE, '0992929292', 12, NULL, 'Les serveur de données'),
('10004', 2, 'double deluxe', FALSE, '0952525251', 1, 200, 'chambre avec une balcon et possiblité de voir la plage de lexterieur'),
('10005', 2, 'double deluxe', FALSE, '0952525253', 1, 200, 'chambre avec une balcon et possiblité de voir la plage de lexterieur'),
('20002', 1, 'simple', FALSE, '0962626261', 2, 50, 'chambre simple avec une lit'),
('20003', 1, 'simple', FALSE, '0962626263', 2, 50, 'chambre simple avec une lit'),
('20004', 1, 'simple', FALSE, '0962626264', 2, 50, 'chambre simple avec une lit'),
('20005', 1, 'simple', FALSE, '0962626265', 2, 50, 'chambre simple avec une lit'),
('30002', 1, 'chambre luxe', FALSE, '0963636366', 3, 150, 'permet de avoir une vue globale de la cité et nottament accées à une télescope pour visualiser la ciel pendant la nuit'),
('30003', 1, 'chambre luxe', FALSE, '0963636367', 3, 150, 'permet de avoir une vue globale de la cité et nottament accées à une télescope pour visualiser la ciel pendant la nuit'),
('30004', 1, 'chambre luxe', FALSE, '0963636368', 3, 150, 'permet de avoir une vue globale de la cité et nottament accées à une télescope pour visualiser la ciel pendant la nuit'),
('30001', 1, 'chambre luxe', FALSE, '0963636369', 3, 150, 'permet de avoir une vue globale de la cité et nottament accées à une télescope pour visualiser la ciel pendant la nuit'),
('40001', 2, 'double deluxe', FALSE, '0952525254', 4, 200, 'chambre avec une balcon et possiblité de voir la plage de lexterieur'),
('40002', 2, 'double deluxe', FALSE, '0952525255', 4, 200, 'chambre avec une balcon et possiblité de voir la plage de lexterieur'),
('40003', 2, 'double deluxe', FALSE, '0952525256', 4, 200, 'chambre avec une balcon et possiblité de voir la plage de lexterieur'),
('40004', 2, 'double deluxe', FALSE, '0952525257', 4, 200, 'chambre avec une balcon et possiblité de voir la plage de lexterieur'),
('40005', 2, 'double deluxe', FALSE, '0952525258', 4, 200, 'chambre avec une balcon et possiblité de voir la plage de lexterieur');


INSERT INTO reservation (num_reservation, date_reservation, prixPaiement, date_debut, date_fin) VALUES
('0123456789', '2022-11-19', 30000, '2022-12-02', '2022-12-26'),
('1123456789', '2022-11-19', 120, '2022-12-02', '2022-12-26'),
('2123456789', '2022-11-19', 120, '2022-12-02', '2022-12-26'),
('3123456789', '2022-11-19', 2800, '2022-12-02', '2022-12-26'),
('4123456789', '2022-11-19', 20000, '2022-12-02', '2022-12-26');

INSERT INTO client (num_client, nom_client, prenom_client, mail_client, tel_client, addr_client, num_chambre) VALUES
('cl12345678', 'Bernard', 'Legrand', 'bernard@gmail.com', '0676543212', '5 Rue de Papa, 93000', '10001'),
('cl87654321', 'Chrisopher', 'Milton', 'milton@gmail.com', '0676233212', '5 Rue du Général, 93000', '20001' ),
('cl11223344', 'Lemoulin', 'Lerat', 'lerat@gmail.com', '0676932212', '5 Rue de Maitre, 93000', '30005');

INSERT INTO effectuer (num_client, num_reservation) VALUES
('cl12345678', '0123456789'),
('cl87654321', '3123456789'),
('cl11223344', '4123456789');

INSERT INTO accede (num_badge, num_chambre) VALUES
('b2185', '10001'),
('b2653', '20001'),
('b2811', '30005'),
('b1102', '10001'),
('b1102', '20001'),
('b1102', '30005'),
('b1149', '10002'),
('b1102', '10002'),
('b1102', '10003'),
('b1102', '10004'),
('b1102', '10005'),
('b1102', '20002'),
('b1102', '20003'),
('b1102', '20004'),
('b1102', '20005'),
('b1102', '30001'),
('b1102', '30002'),
('b1102', '30003'),
('b1102', '30004'),
('b1102', '40001'),
('b1102', '40002'),
('b1102', '40003'),
('b1102', '40004'),
('b1102', '40005'),
('b1102', '50001');

INSERT INTO possede_client (num_badge, num_client) VALUES
('b2185', 'cl12345678'),
('b2653', 'cl87654321'),
('b2811', 'cl11223344');

INSERT INTO possede_employe (num_badge, num_employe) VALUES
('b1102', 'ht193121'),
('b1149', 'ht701294');

INSERT INTO departments (num_departement, nom_department, responsable_departement, nbre_personnels, type_departement, description, num_employe)VALUES
('01', 'Service restauration', 'Caya Ferragus', 40, 'service restauration', 'en charge de restuaration', 'ht183091'),
('02', 'Service de gestion hotel', 'Mercure Zednek', 15, 'service gestion', 'en charge de gestion de hotel', 'ht193121' ),
('03', 'Securite et surveillance', 'Levasseur Gilbert', 8, 'service securite', 'en charge de la securite', 'ht701294');

INSERT INTO facture (num_facture, somme_totale, date_facture, num_reservation, num_client) VALUES
('F1234567', '35000', '2022-12-30', '0123456789', 'cl12345678'),
('F0123456', '2800', '2022-12-20', '3123456789', 'cl87654321'),
('F1012345', '21500', '2022-12-23', '4123456789', 'cl11223344');

INSERT INTO est_compter_dans (num_departement, num_facture) VALUES
('01', 'F1234567'),
('02', 'F1234567'),
('01', 'F1012345'),
('02', 'F1012345'),
('01', 'F0123456');

--DML

--afficher les différentes type des chambres et leur prix
SELECT type_chambre,prix FROM chambre;

--afficher les différentes disponiblité de chambre lorsque le client il veut réserver
SELECT * FROM chambre WHERE occupation == FALSE;

--afficher un récapulatif de la réservation (détail des clients qui ont reserver)
SELECT nom_client,prenom_client,mail_client,tel_client,addr_client,num_chambre,num_reservation FROM client,effectuer WHERE client.num_client = effectuer.num_client;

--afficher un récapulatif de la facture aprés la période de réservation
SELECT * FROM facture;

--requete avec les données nécessaire pour ouvrir la porte
SELECT * FROM badge;

--requete des données pour vérifier la periode de validités
SELECT num_badge FROM reservation,badge WHERE reservation.date_reservation <= badge.periode_de_validite;

--afficher le nombre de jours restants au client résidant dans l'hotel
SELECT AGE(periode_de_validite, date_reservation) AS nbr_jour FROM reservation;
