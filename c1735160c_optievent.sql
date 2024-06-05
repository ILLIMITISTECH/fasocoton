-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 04 juin 2024 à 12:16
-- Version du serveur : 10.6.17-MariaDB-cll-lve
-- Version de PHP : 8.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `c1735160c_optievent`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`c1735160c`@`localhost` PROCEDURE `plannings` ()   BEGIN   
        
        DECLARE nb_auto,nb_perso INT DEFAULT 0;

        DECLARE v_nb INT DEFAULT 0; 
        DECLARE v_priorite, v_user_id INT DEFAULT 0 ; 
        DECLARE done BOOLEAN DEFAULT FALSE;

        DECLARE v_nom_ent_1, v_nom_part_1, v_nom_ent_2, v_nom_part_2 VARCHAR(255);

        DECLARE v_ent_id, v_ent_rv_id INT DEFAULT 0;  
        DECLARE v_ent_lang_1, v_ent_lang_2 VARCHAR(255);

        DECLARE v_cre_id, v_cre_duration INT DEFAULT 0 ;
        DECLARE v_cre_sale_id, v_cre_event_id INT DEFAULT 0 ;
        DECLARE v_cre_libelle_t, v_cre_heure_deb, v_cre_heure_fin, v_cre_lien, v_cre_join_url, v_cre_password VARCHAR(255);
        DECLARE v_cre_start_url text ;
        DECLARE v_cre_date_c DATE ;
        DECLARE v_cre_ordre, v_cre_status INT DEFAULT 0;
        
        DECLARE total_souhait, total_nb_souhait INT DEFAULT 0;
        DECLARE total_creneau, total_creneau_1 INT DEFAULT 0;
        DECLARE total_1, total_2, v_boucle INT DEFAULT 0;
       
        DECLARE end_1, end_2, v_ok_10 INT DEFAULT 1;                      
      
        DECLARE curs_souhait CURSOR
            FOR SELECT DISTINCT entreprise_id, entreprise_rv_id, langue_ent_1, langue_ent_2, priorite, user_id
            FROM planning_fs;
            

        DECLARE curs_creneau CURSOR
            FOR SELECT DISTINCT id, libelle_t, date_c, heure_deb, heure_fin, lien, ordre, sale_id, start_url, join_url, password, duration, event_id, status
            FROM creneaus;

       DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE; 
       
       DELETE FROM souhait_fs;
                INSERT INTO souhait_fs(entreprise_id,entreprise_rv_id,priorite, status, langue_ent_1, langue_ent_2,user_id) 
                        SELECT DISTINCT entreprise_id,entreprise_rv_id,priorite, status, langue_ent_1, langue_ent_2,user_id FROM souhaits where (status = 1 AND etats = 1);
                INSERT INTO souhait_fs(entreprise_id,entreprise_rv_id,priorite, status, langue_ent_1, langue_ent_2,user_id) 
                        SELECT DISTINCT entreprise_id,entreprise_rv_id,priorite, status, langue_ent_1, langue_ent_2,user_id FROM souhaites where (status = 1 AND etats = 1);
        DELETE FROM planning_fs;
                INSERT INTO planning_fs(entreprise_id, entreprise_rv_id, langue_ent_1, langue_ent_2, priorite,user_id,status)
                        SELECT DISTINCT entreprise_id, entreprise_rv_id, langue_ent_1, langue_ent_2, priorite, user_id, status FROM souhait_fs;


       DELETE FROM plannings;

        SELECT DISTINCT count(*) INTO total_nb_souhait 
        FROM planning_fs;

        SELECT DISTINCT count(*) INTO total_creneau 
        FROM creneaus;


        -- Les traitements
        OPEN curs_creneau;
           
                boucle_1: LOOP
                    FETCH curs_creneau INTO v_cre_id, v_cre_libelle_t, v_cre_date_c, v_cre_heure_deb, v_cre_heure_fin, v_cre_lien, v_cre_ordre, v_cre_sale_id, v_cre_start_url, v_cre_join_url, v_cre_password, v_cre_duration, v_cre_event_id, v_cre_status;
                    -- Structure IF pour quitter la boucle à la fin des résultats
                        
                        IF done THEN     -- Plus besoin de "= 1"
                            LEAVE boucle_1;
                        END IF;
                        
                        IF end_1 > total_creneau THEN
                            LEAVE boucle_1;
                        END IF;
                    OPEN curs_souhait;            
                        boucle_2: LOOP
                            FETCH curs_souhait INTO v_ent_id, v_ent_rv_id, v_ent_lang_1, v_ent_lang_2, v_priorite, v_user_id ;
                                
                                IF done THEN     -- Plus besoin de "= 1"
                                LEAVE boucle_2;
                                END IF;

                                IF end_2 > total_creneau THEN
                                    LEAVE boucle_2;
                                END IF; 

                                FETCH curs_creneau INTO v_cre_id, v_cre_libelle_t, v_cre_date_c, v_cre_heure_deb, v_cre_heure_fin, v_cre_lien, v_cre_ordre, v_cre_sale_id, v_cre_start_url, v_cre_join_url, v_cre_password, v_cre_duration, v_cre_event_id, v_cre_status;
                                    
                                    IF end_1 > total_creneau THEN
                                        LEAVE boucle_1;
                                        LEAVE boucle_2;
                                    END IF;

                                INSERT INTO plannings(entreprise_id, entreprise_rv_id, lang_1, lang_2, priorite, libelle_t, date_rv, heure_deb, heure_fin,lien, status_rv, ok_10, sale_id, start_url,join_url, password, duration, event_id, user_id)
                                VALUES(v_ent_id, v_ent_rv_id, v_ent_lang_1, v_ent_lang_2, v_priorite, v_cre_libelle_t, v_cre_date_c, v_cre_heure_deb, v_cre_heure_fin,v_cre_lien, v_cre_status, v_ok_10, v_cre_sale_id, v_cre_start_url, v_cre_join_url, v_cre_password, v_cre_duration, v_cre_event_id, v_user_id);                                         
                                    
                                INSERT INTO plannings(entreprise_id, entreprise_rv_id, lang_1, lang_2, priorite, libelle_t, date_rv, heure_deb, heure_fin,lien, status_rv, ok_10, sale_id, start_url,join_url, password, duration, event_id, user_id)
                                VALUES(v_ent_rv_id, v_ent_id, v_ent_lang_1, v_ent_lang_2, v_priorite, v_cre_libelle_t, v_cre_date_c, v_cre_heure_deb, v_cre_heure_fin,v_cre_lien, v_cre_status, v_ok_10, v_cre_sale_id, v_cre_start_url, v_cre_join_url, v_cre_password,v_cre_duration, v_cre_event_id, v_user_id); 
                                
                                SET end_1 = end_1 + 1;
                        END LOOP boucle_2;
                    CLOSE curs_souhait;   
                END LOOP boucle_1;
        CLOSE  curs_creneau;   
        -- End traitements
          
    END$$

$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `achat_tickets`
--

CREATE TABLE `achat_tickets` (
  `id` int(11) NOT NULL,
  `type_ticket` varchar(50) DEFAULT NULL,
  `status_paiement` tinyint(1) DEFAULT NULL,
  `mode_paiement` varchar(50) DEFAULT NULL,
  `date_paiement` date DEFAULT NULL,
  `participant_id` int(11) DEFAULT NULL,
  `pass_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `activites`
--

CREATE TABLE `activites` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `heure_debut` varchar(255) DEFAULT NULL,
  `heure_fin` varchar(255) DEFAULT NULL,
  `gratuit` tinyint(1) DEFAULT NULL,
  `state` tinyint(1) DEFAULT NULL,
  `nombre_participants_online` int(11) DEFAULT NULL,
  `nombre_participants_offline` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `start_url` text DEFAULT NULL,
  `join_url` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `activites`
--

INSERT INTO `activites` (`id`, `libelle`, `date`, `heure_debut`, `heure_fin`, `gratuit`, `state`, `nombre_participants_online`, `nombre_participants_offline`, `created_at`, `updated_at`, `sale_id`, `event_id`, `start_url`, `join_url`, `password`, `duration`) VALUES
(64, 'Ceremonie d\'ouverture', '2022-01-26', '09:00', '12:00', NULL, NULL, NULL, NULL, '2021-10-14 20:21:34', '2021-10-14 13:21:34', NULL, 12, 'https://us05web.zoom.us/s/83907435820?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MzkwNzQzNTgyMCIsInN0ayI6IlVreDlFUWpMSlVLV3k5QkxUdW4ySHE2ZXBRLVliUkxGdzlhclBXT2xUWk0uQUcuYmdlR29jTEFjN1duTEl5UFZ1aGQ2OUlYZGpkQWQxX0NpMFQ3eUNJaWRMUFpmamhMX0RqYnFNdUl6Zi1ucERtSVRPbEZNOUQwNFBSOHNDcHUuMnE2R0g4WFdxV0hFbzBJbkZhNUN3QS5Rb3IzWHdzaXVaOWlIT3I3IiwiZXhwIjoxNjM0MjI0ODk0LCJpYXQiOjE2MzQyMTc2OTQsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.MxqjIxOy1uDeDXyWDmnrj4zda99gSflasuVUSXaGkFg', 'https://us05web.zoom.us/j/83907435820?pwd=Z0Z3dXRiclpvSzkyMkhXQUpPUGorZz09', '32dESJ', 4),
(65, 'Conférence inaugurale', '2022-01-26', '11:00', '13:00', NULL, NULL, NULL, NULL, '2021-10-14 20:22:32', '2021-10-14 13:22:32', NULL, 12, 'https://us05web.zoom.us/s/87593061636?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NzU5MzA2MTYzNiIsInN0ayI6Ijd6dGswOUI0TWxTeHEtWHBFVTNIVUNNbWhkQWNOc2xENE55MzRZN0drMkEuQUcuUTZWOTlnTnpmTl84TWMwQWNsX2ppaU4tSGE4M0psZFZpR0o1Vm91QUI4WEttaTZOTlBiNkFaQWJXM01PdlRuSzBxYmpoTjFfYXVyNlU0ajMuUllUcVQ1UDVBNGJXM1pHXzBuNENFZy5GTkpxWjlsNEw4c0x0cnItIiwiZXhwIjoxNjM0MjI0OTUyLCJpYXQiOjE2MzQyMTc3NTIsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.TBu9bxx51Q4j7flVFv4ghVi01PnVEXXOpjw0mjqbHuo', 'https://us05web.zoom.us/j/87593061636?pwd=bzAybVdteTZ4WWwvaU1aeCtoZjRrZz09', '0fbsWF', 3),
(66, 'Rôle et contribution des PME/PMI dans l’essor de l’industrie textile africaine', '2022-01-26', '14:30', '13:30', NULL, NULL, NULL, NULL, '2021-10-14 20:23:37', '2021-10-14 13:23:37', NULL, 12, 'https://us05web.zoom.us/s/82745362491?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4Mjc0NTM2MjQ5MSIsInN0ayI6InBrY0Fqc2VyOTc5SkR4OFRuSWNqelFyMGh4MEJRdHRYNXFob0ZUWnhXZDguQUcuZThSSmk1N0VMbTExUHZSVUhwelVRS0IzS1BZdkxZelpEUmlGLTU4UTNBU2lSNEJIdWNxTG16UFZyRjlNOUxZTHFVM0dSY2loWkJnbzhEUnkuYzUxQ3BUaFduMzczVXFLeTNORzFhdy5OM01UYXZPNFF6M2NUZEZOIiwiZXhwIjoxNjM0MjI1MDE3LCJpYXQiOjE2MzQyMTc4MTcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.Vvl1myP08Qf2w0KK4F1Ci7TNV7Uzw3KEaaEnStfGyeg', 'https://us05web.zoom.us/j/82745362491?pwd=YWNxZ28yRGd2K0ZNZythVHBQK1dmQT09', '14a8z0', 2),
(67, 'Bourse de projets textiles : état des lieux de la phase I et perspectives', '2022-01-26', '14:30', '13:00', NULL, NULL, NULL, NULL, '2021-10-14 20:24:42', '2021-10-14 13:24:42', NULL, 12, 'https://us05web.zoom.us/s/89866718918?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTg2NjcxODkxOCIsInN0ayI6Ik5xSWhjeEdzRTVzZ1VQNHFhRlM5MjQ3VThfeWhwSkplRmJhRTBGdUNvTEEuQUcucXhEcWNjamE1OFVOWThvTFFxR3U1dHktQkxUbnI0OTc1ZlZiUDRad2kxRklMOHFacDU1RHZ6alEtd1BsTV9CbFdXR3RLNEZLZ19EUGUwdG8uZWpSRUNZcEFNSklkNFhUTDVIRGw2Zy5ncEdGbFhJVjBkblM5M0FxIiwiZXhwIjoxNjM0MjI1MDgyLCJpYXQiOjE2MzQyMTc4ODIsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.jSheR0xGdoWqhzrz2o8h0wPmqEkym_6ApInniGw5sXw', 'https://us05web.zoom.us/j/89866718918?pwd=NmlIeTBPU0ZKSU92c1hSR0s3R20xZz09', 'Wnp6f0', 2),
(68, 'Nuits du SICOT à la place de la Nation', '2022-01-26', '19:30', '23:30', NULL, NULL, NULL, NULL, '2021-10-14 20:25:44', '2021-10-14 13:25:44', NULL, 12, 'https://us05web.zoom.us/s/86750207444?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4Njc1MDIwNzQ0NCIsInN0ayI6InBiWmlaMnBoR3JfWXpVLXZoOEk0SzM4aHNibVlZT1dtZ2VhbVhsTmJkRTAuQUcuY0xDV214R3QtbjFUOVRwTjNPc3ZKbzQwOGFVM1Q2NDdUVk83cmI4d00zd3ZCWEZCcmd5SXRqaVNoa2lpMEFzY0M3T3JXYjRKaFdJRzNZWW0uZmE1UGtwZzFwNHlmOE9kUEwzT3p6Zy43RWFUb3NOd0xrLXJvQkFDIiwiZXhwIjoxNjM0MjI1MTQ0LCJpYXQiOjE2MzQyMTc5NDQsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.q6c8KqNLOzutNBYBEYqqN8NdbMuN2QNqgggwsAlbAUA', 'https://us05web.zoom.us/j/86750207444?pwd=cnNPTUtFUHlHTXhmZitjZVZNUmEwUT09', 'ed1tBn', 5),
(69, 'Compétitivité des produits textiles africains dans un contexte de libéralisation des économies et d’intégration africaine', '2022-01-28', '09:00', '11:00', NULL, NULL, NULL, NULL, '2021-10-14 20:26:37', '2021-10-14 13:26:37', NULL, 12, 'https://us05web.zoom.us/s/87330680288?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NzMzMDY4MDI4OCIsInN0ayI6IjFPLVR3OG42MjdTdzRMcWlQV054YjhGQkpOQXk1NThBUTM0X2gxbWpJZlUuQUcuYnItbzRPTzFVdkxnSlJLcU5sb0JzMHZjTnZaZFpjVXdaR1kyc1JHeDhSRHcwcFlST1pnWmh5d043QnNsN2RRR2pwR3gyV0hkWWVoZ1VPR0YuNFR5VlBYZ09CbUF4dU5Zemt2UXZzQS50cFlGNzRmQjJ2ZlFMM1FTIiwiZXhwIjoxNjM0MjI1MTk2LCJpYXQiOjE2MzQyMTc5OTYsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.Hl4aMZbP0OBzofr5Zms3Il3FAApc_F8y4QU6orx5cLU', 'https://us05web.zoom.us/j/87330680288?pwd=enNtbU5rWUVoNy9WRnZqcXI3dEdNQT09', '4FMfLb', 3),
(70, 'Coton biologique : défis de la production et de la transformation', '2022-01-28', '09:00', '11:00', NULL, NULL, NULL, NULL, '2021-10-18 15:21:42', '2021-10-18 15:21:42', NULL, 12, 'https://us05web.zoom.us/s/86510631360?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NjUxMDYzMTM2MCIsInN0ayI6IjFtX2hPWTE5TFdYOTJUdWoyUzV6MlFXNm03T2hxM3RXcFdQYlRYaEtNaU0uQUcuTU40bUt3di1UemxjZlQtdnJ0bWNBNGJxdHpNZU5YRVRlZVFUUFNsNEx3eHN6M04tYWtvUzlxOEFnNkdMTUZOQW0wc01EMDdibHo4dFhUOWcuVDhRSl8tZ3A1Tnc2c3FDS2xucGR3Zy5yU0RSa0h3RHVySTRKYm1EIiwiZXhwIjoxNjM0MjI1MjM1LCJpYXQiOjE2MzQyMTgwMzUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.6-4WB2TRjYPtIYX70M6j5XmolyxEDf0JLKkfizsxvZI', 'https://us05web.zoom.us/j/86510631360?pwd=WXA3Q1VlN2lDUHpVbEc1WUpkd3c3QT09', 'nEg6t3', 3),
(71, 'Echanges entre Investisseurs modèles dans le secteur textile et Etudiants à l’Université Norbert ZONGO de Koudougou', '2022-01-28', '10:00', '12:00', NULL, NULL, NULL, NULL, '2021-10-14 20:28:01', '2021-10-14 13:28:01', NULL, 12, 'https://us05web.zoom.us/s/82719493234?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjcxOTQ5MzIzNCIsInN0ayI6InhrMWJzMVZxOXJZRWQyTXByTlFUVno5NXBfeDl6WTdZdmp4TnVMOVRzaFkuQUcuemVpMjdVXzZqQVVlSEJOaEs0b09XVzNVZ3U1U25jSzF4TGVNaUxCOGtkNFlHRjcteHFPVWo5QXptS2VfUHNBZFRLemQ4UUJzaTd2eXRWb3MuSWFfZnVDcW9yR3BKbjNNOXVCNndKUS42b2Rmd0V4d2FqSkkxcm5yIiwiZXhwIjoxNjM0MjI1MjgxLCJpYXQiOjE2MzQyMTgwODEsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.POwT9rrG6xBXcYXn8OY4_WqENTdyrWtZpXRYg7F5zuQ', 'https://us05web.zoom.us/j/82719493234?pwd=ZXR1d0hlemUwNUpPTGhEV1MrcE9Qdz09', 'n5bs8E', 2),
(72, 'Rôle et place de la mode vestimentaire dans l’essor de l’industrie textile africaine', '2022-01-28', '11:30', '13:30', NULL, NULL, NULL, NULL, '2021-10-14 20:28:58', '2021-10-14 13:28:58', NULL, 12, 'https://us05web.zoom.us/s/89419990705?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTQxOTk5MDcwNSIsInN0ayI6InAwUE15WUE4bDNyQ1h2VS1FM1Q2ZnUwTlRkUUdiSjdXdEphUXFBdW5WdGMuQUcuRlZhQXlwN01FbEJuXzZ6OEwxQWM3dXQzTWk1dmRTaU53cWR5RVBQLVlqdGFtbTZHbHlNLVF6WkQ5dDlWYXpwT0RLUkExV3NfYTBpTU9BeUIuanl1cmhYLVE0X04xTDdpZkFGUTRhUS5HbGZkMTFYdjMzM082SmR0IiwiZXhwIjoxNjM0MjI1MzM4LCJpYXQiOjE2MzQyMTgxMzgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.NKWaAfKhQbLjJgJ-2ZKYDi1EwAhbpRgP7Y0sBDdyEE4', 'https://us05web.zoom.us/j/89419990705?pwd=Mmt2QmpnNGNDei9oNHNNMUtiaDEvUT09', '7VMS75', 2),
(73, 'Cérémonie de clôture :', '2022-01-28', '15:30', '17:30', NULL, NULL, NULL, NULL, '2021-10-14 20:30:00', '2021-10-14 13:30:00', NULL, 12, 'https://us05web.zoom.us/s/82192836690?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjE5MjgzNjY5MCIsInN0ayI6IkFaS2M2ZURfS1NtTk9iLTJERFhLNlBoQUt3Z2djeFJIMDBYNFdRd3FBSDAuQUcuaTc3OWZ2el8zT2VmeUFEazJsSElDX1Q2STZ3cVgzNUxXZHNmQUE2a3ZoVHFQenZpRTdZdmtPd2FaYi0zOGV4SXoyakdjcldHcmFzU3Z1RmkucG9Gc0xrcWhLYjgtSWpmbFVSQVViQS52M05JQl92bkxwUTczNEdTIiwiZXhwIjoxNjM0MjI1Mzk5LCJpYXQiOjE2MzQyMTgxOTksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.8iDfyEh5AWFhRIyqpT4CxjuX9btFBo5UuOUjqsssgh0', 'https://us05web.zoom.us/j/82192836690?pwd=OHRWdDE4eU8weFRaU0oxd3BVNTZRUT09', 'w8FgTH', 2),
(74, 'Défilé de mode international à Splendid hôtel', '2022-01-28', '19:30', '23:30', NULL, NULL, NULL, NULL, '2021-10-14 20:31:06', '2021-10-14 13:31:06', NULL, 12, 'https://us05web.zoom.us/s/85435263040?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTQzNTI2MzA0MCIsInN0ayI6ImR6dmZHUEtMeERKUndDTVdtME1TRXlqSXBOejYwa3RGRkxJdEVOTHBoNGMuQUcudzV5ZWViSDlIWkpHZ3ZqN2ZPYUdOMWU4WmFqQUZCMmtTd1lISXZJQUtNN04teTdzWEo0YTJGcHhZV2IzNDFwTy1wc0NpMWYtVUotRElvTzkueGdKX1otTVMtQklaQ0VISnU4RjdiZy5ROExOUjd3dUxxTnJ0blBhIiwiZXhwIjoxNjM0MjI1NDY2LCJpYXQiOjE2MzQyMTgyNjYsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.jszz-MOnNmx_TXXVLrIS5w5q3XUbJ_4r0ho_ishSdFY', 'https://us05web.zoom.us/j/85435263040?pwd=ZTlLbVIxcWRIV1pKSld6T2hmdHJMUT09', '84nsYr', 4),
(75, 'Nuits du SICOT à la place de la Nation', '2021-01-28', '21:00', '00:00', NULL, NULL, NULL, NULL, '2021-10-18 15:19:11', '2021-10-14 13:32:08', NULL, 12, 'https://us05web.zoom.us/s/82258759901?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjI1ODc1OTkwMSIsInN0ayI6IlFZdHphZ2QtTVBpTlVxbTEyNHJRM0Y0cENjRDlVMnVhM3NCQXNPZVlVUHcuQUcuV19WYjUwNHZ3Y3JSb3YzRU9wS21qVkhzMXJqblNaS0U2MVhSX3FhWVlEU2pUMnNtekVqSlowOVZXaTJaTDV4TlYwcG9QZy1zZVhOaFI2MmkuT2trVmNwVW03TmpYbXRXdThEWndxUS5oOVVqa2R0M1JWTGIxR2VEIiwiZXhwIjoxNjM0MjI1NTI4LCJpYXQiOjE2MzQyMTgzMjgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.iM9TsSYstA3Z0DXhVx0aowqs2OliOg_V5A7AKcSRC-k', 'https://us05web.zoom.us/j/82258759901?pwd=ZDFmc1p2MFhxUXg1OXlrNmtyblpndz09', 'CC8RnJ', 4),
(76, 'Diner', '2021-01-28', NULL, NULL, NULL, NULL, NULL, NULL, '2021-10-18 15:19:20', '2021-10-18 15:12:47', NULL, 12, 'https://us05web.zoom.us/s/83453337540?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MzQ1MzMzNzU0MCIsInN0ayI6ImFIdy1SZUU4YWs5dE5JMHBxaHJXZHh2ZGEyZDhQUkQwMDgyTjV1ZzRwSzguQUcuZkRTTnNFQy1rQVBHM3hNQmdmYkhwQjFBMFBRV09nUUptYmg3TE03UXdXZWFiZjcyajNTQjA0cEphRXhhZkpfX2VnOVFmbElUbm9DN2xwcHguZlViQm1SaG12Q1lQenc2SC13QXhfUS5hQzhhck5iU3RQNFIzdTAzIiwiZXhwIjoxNjM0MzE1NDE1LCJpYXQiOjE2MzQzMDgyMTUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.Hrtf6V7vBe2IgRFHzmYISB3jmv72JQOVQvI1rBUjBh4', 'https://us05web.zoom.us/j/83453337540?pwd=dDZEM1IwTTdVRlQrQlBBb3RGbG5xdz09', 'uu5Gn0', 1),
(77, 'Cérémonie', '2021-12-10', '12:00', '14:00', NULL, NULL, NULL, NULL, '2021-10-18 15:22:23', '2021-10-15 15:08:42', NULL, 12, 'https://us05web.zoom.us/s/88688157782?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODY4ODE1Nzc4MiIsInN0ayI6IllmVFQ3N1UyMWNabGVIemNPUU5HR0Z2RmppOUtscU9ZUFFfY05qTEJLWDguQUcuTHI5MHhra0dVOE5mTEVtS2hhQkMwRENWRjFKeFExdlJ5dlFaZEZtWDMtVjFUcEdDSE9VR0d2MHhoNU05dy11bllTcnZ4N3kxVWFYdkE1ZXIuVDdpRXRYM3VIc0NaQzd1ajBWeEZ5QS5fakJ2dUhmUkNYTGI5eDRUIiwiZXhwIjoxNjM0MzE3NzIyLCJpYXQiOjE2MzQzMTA1MjIsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.l6g6vSXKwZkrGvlpvWxr9v8qY2-N2fQfsG76IeAGUEE', 'https://us05web.zoom.us/j/88688157782?pwd=eElZdWRBTnZyR3NIMGJnUGxVOTJGdz09', '2wQq9B', 2);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `chambres`
--

CREATE TABLE `chambres` (
  `id` int(11) NOT NULL,
  `nom_chambre` varchar(255) DEFAULT NULL,
  `prix` varchar(255) DEFAULT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `chef_delegations`
--

CREATE TABLE `chef_delegations` (
  `id` int(11) NOT NULL,
  `id_participant` int(11) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nom_delegation` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT 'placeholder.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `creneaus`
--

CREATE TABLE `creneaus` (
  `id` int(11) NOT NULL,
  `libelle_t` varchar(255) DEFAULT NULL,
  `table_id` int(11) DEFAULT 0,
  `sale_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `heure_deb` varchar(255) DEFAULT NULL,
  `heure_fin` varchar(255) DEFAULT NULL,
  `date_c` date DEFAULT NULL,
  `libre` tinyint(4) DEFAULT 0,
  `ordre` int(11) DEFAULT 0,
  `lien` tinyint(4) DEFAULT 0,
  `status` tinyint(4) DEFAULT 0,
  `start_url` text DEFAULT NULL,
  `join_url` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `creneaus`
--

INSERT INTO `creneaus` (`id`, `libelle_t`, `table_id`, `sale_id`, `event_id`, `date`, `heure_deb`, `heure_fin`, `date_c`, `libre`, `ordre`, `lien`, `status`, `start_url`, `join_url`, `password`, `duration`, `created_at`, `updated_at`) VALUES
(1, 'Table 1', 0, 1, 7, NULL, '09:00', '09:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89401549080?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTQwMTU0OTA4MCIsInN0ayI6InM5TGh0dURTVW4zWm8tQUthZVFKODU3YU1JV0Y0M28zNTQzLTNObnREZ1EuQUcuTFhVNURVQkp0enF5M1EwSzBCbkRndXNVejYyMVBmWGZvbGZMOGJPRXA2cXY2bXVYVzhzUm1adzZyZXdRMXZEVlJqdU1xR05nZWpNVWhMcFouVTlUTTZEbjExdDNneWdLV3Z2SEVmdy5vLTItRFFzS0I1Uk55djZvIiwiZXhwIjoxNjMyNDA1NzA3LCJpYXQiOjE2MzIzOTg1MDcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.GyH0SNr5cHx9w8kvYZvX-XzcnSDmZuwdaVWX34z6wL4', 'https://us05web.zoom.us/j/89401549080?pwd=SHZHR1MxcTc3MnFCdk9FaGh1WWZGdz09', 'Rz6R77', 30, '2021-10-08 11:05:52', NULL),
(2, 'Table 1', 0, 1, 7, NULL, '09:30', '10:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82756452797?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4Mjc1NjQ1Mjc5NyIsInN0ayI6IkUxUjcwRkJZUmV6UFQ5UFhrdHhUdElSb2JNWVJuSDlPbENvTVBRMnhqS1UuQUcuc3RGMUFrS0Q0U3Q1ZVJ4WXZEZDVDYWZqN0pCeEY3US0zNGlYQlhKT2NMN2VQM0VTNVdJWnlYTmxSSlNxbDkwbDJuSTcxVlluMDd2SF9NdjAuRk5WMlpYSVJQUzZLRHNpdWo0NUtfQS4zT1dpSGR3NTQ1YjVpOEtvIiwiZXhwIjoxNjMyNDA1NzA4LCJpYXQiOjE2MzIzOTg1MDgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.aBcJj0dtk8r_mj-CkpUoTQZ3KauKVLlbqh9iljgBxp0', 'https://us05web.zoom.us/j/82756452797?pwd=N3M4d0sxZ1hTVmNqQWVVWkMxdzlMdz09', 'H5YsFG', 30, '2021-10-08 11:05:52', NULL),
(3, 'Table 1', 0, 1, 7, NULL, '10:00', '10:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88624710109?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODYyNDcxMDEwOSIsInN0ayI6IkJiOVBqMkdGQi1EOG80eC05NHdJbHFiR0F0TjYzT1hhVUpheFBBZ2stNFkuQUcuOFQ3RGxMWTdFMkM4SmdsRkgya1ZNRHpkZWRJbnlhRWJyS052Y2xqbWZ6ODZxTmdQSnFwc05NUjVWYVNJVEN2eUdpSmFYb0h4amxUaEJ4WHMuTG9JRmhTSFV3MFdGdnY4V013V2NTQS5RUXpHdzMxQkxyVHNEaE9WIiwiZXhwIjoxNjMyNDA1NzA5LCJpYXQiOjE2MzIzOTg1MDksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.lM96eWTvSf05UpyuZSPg78YrmahlqfrX4Br9-c9_GBk', 'https://us05web.zoom.us/j/88624710109?pwd=Q3hjRnNKZ2l3SXNqeWc2OE1YWk1rdz09', 'b42Ukh', 30, '2021-10-08 11:05:52', NULL),
(4, 'Table 1', 0, 1, 7, NULL, '10:30', '11:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88442439932?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODQ0MjQzOTkzMiIsInN0ayI6IndLY1dRY0VRcFQ1VnV4SF9oei1NdS1IQ2s5SEhCZ3N5M3ZVLWRWY3AzNnMuQUcuOFJzZ0ZvdWc3b2dQTmhHa1Aza2FDZXRuaU9McmlBdWRocDdzS0QzNEpoQm5XYXRKRmtuY29WU3lwN0NWZGtsUmJvemZBWnBuSGtRVUZyT1kuSDgtcFRSVHZ2VWxCbzlLN2NmUW9wdy5LdFhwalR4YVBVQm9rS1dkIiwiZXhwIjoxNjMyNDA1NzExLCJpYXQiOjE2MzIzOTg1MTEsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.CYU8UshLEgNLv38VxpAvmI9XEvmADR_12v7wq0M4x1Y', 'https://us05web.zoom.us/j/88442439932?pwd=QzlSU1RMdlo2ZlFqckFWOGV5b0Nkdz09', '1i0B4N', 30, '2021-10-08 11:05:52', NULL),
(5, 'Table 1', 0, 1, 7, NULL, '11:00', '11:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/85118491104?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTExODQ5MTEwNCIsInN0ayI6Ik52bFBKM05fUVJybkhUU2t3OWJRSE9EVmtTYWpHeFdwTHFGX2cxOVRNU0EuQUcuMlZTQjNwdzhHLXVSVjd5WmxFY2I0eThid1ZSY3piOEd1Y2dQSDVfWkU5cExfdWtGNk1XclduRU55MjlxZE15U2VWeXdSNTFEemV1bndSUG8uQ0FaMVluWVo5alg3TFJrVmlVSzM2Zy5lTE9KTG1MZlRNbW9VOV94IiwiZXhwIjoxNjMyNDA1NzEyLCJpYXQiOjE2MzIzOTg1MTIsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.ZxHG2CfQb3A4PYz0KWuoLKNYn_cTIno-7Cqsi4q2yPM', 'https://us05web.zoom.us/j/85118491104?pwd=QmtadDdxVVZieU5YVEpNQU9LWWFodz09', 'm08edz', 30, '2021-10-08 11:05:52', NULL),
(6, 'Table 1', 0, 1, 7, NULL, '11:30', '12:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88619864694?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODYxOTg2NDY5NCIsInN0ayI6IkU1ZWpyWUFOWm4waC15ZnNtQUlmU21xc0NIN0dOYkRqMlQ3TGVCd2Y3eVUuQUcuTUlCSlRjZkYxVXB4c2xJZVp2NWJJdFYtTkRKREJ6emdHYlc5Q19hYjQ2X1pWSlBDSnBidzdmbEFfdnpteUpQQXVxSDBFQV9rNG5vT3RCVTYuQ3QyY0I3SzVrWllDbUVKTnowTlNhQS5wQVNBQ084RkhZY1BIYzJFIiwiZXhwIjoxNjMyNDA1NzEzLCJpYXQiOjE2MzIzOTg1MTMsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.6F7hsZbwXBe24kRGFUZKvnfkNSH3rpyilRP2uqw4k3s', 'https://us05web.zoom.us/j/88619864694?pwd=NzBZa3JPc0srTkxhZG9SRFk5WHFvdz09', '7VesWA', 30, '2021-10-08 11:05:52', NULL),
(7, 'Table 1', 0, 1, 7, NULL, '12:00', '12:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89508048324?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTUwODA0ODMyNCIsInN0ayI6ImlvWDdOLTRHR2FDcnFiR3dkQnZPSVZtclFfRGd3UjY3ckZyeEJfTGIwRmMuQUcuTjk2dHA0UGtWdi01ZE9zcXJKcTFkaDFmS0syeEFtMEtVYjNGejJZV0RYc3Q1UGUwSW1VZ1RodEozQ0tMQVF5czk3b1paMFEzZEh1LW1yMnYucURDWUZ1d0dFS2FhdzNpTXRCOHJGdy5pcUxLWEpXT2lXZFJoUi1KIiwiZXhwIjoxNjMyNDA1NzE0LCJpYXQiOjE2MzIzOTg1MTQsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.n51yRdrcEcI1dpRT29F9yZBL7WWTQFjJW_Ntxv90SMM', 'https://us05web.zoom.us/j/89508048324?pwd=NHR3cm51U0laRGpQbEJHL3VXVEwxQT09', 'w0Cd0m', 30, '2021-10-08 11:05:52', NULL),
(8, 'Table 1', 0, 1, 7, NULL, '12:30', '13:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/84246027666?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NDI0NjAyNzY2NiIsInN0ayI6IlUzZnc4X0ktYXphVTk2aUUyWHZuUnh1OEpNY2dDSmktSHNqZkwxV3NpbFUuQUcuLTVrc3ZRYVNfaHp5OWZxdlBjYTRLcEdmWmpBTW5XQ3BsdmJTV2U3cGY3VkQwSktNUmNBdk5fNzhCbTdheGdEc2psYkJkTDhqMmpmd19KWUsuTFdYZzE5azFsSXJRd19kM2dwZVFMUS5WLVVsQl81WWliUjhDOXgyIiwiZXhwIjoxNjMyNDA1NzE1LCJpYXQiOjE2MzIzOTg1MTUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.FU3rhPIzleWrAO9ak-enHg8Yr85Nnv1imO9umQNDI6U', 'https://us05web.zoom.us/j/84246027666?pwd=YTE2RnJQaEJGTm9CbXlwaGpuY01LZz09', '5CUGNG', 30, '2021-10-08 11:05:52', NULL),
(9, 'Table 1', 0, 1, 7, NULL, '13:00', '13:30', '2021-10-08', 0, 0, 0, 0, NULL, NULL, NULL, 30, '2021-10-08 11:05:52', NULL),
(10, 'Table 1', 0, 1, 7, NULL, '14:30', '15:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81766513534?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTc2NjUxMzUzNCIsInN0ayI6IlR4RkRiVUkyakFzR1ltdDYyeGYyUkJnU2RFbWlMUVZYR1F0NEp2eHh0bHcuQUcuQ2lueXFRX3BKX0V1RXBYUEEzOUFFaXRpOFhRVDN5eWVucTkzcDctTDRCQUtnT1hUakxRSWpqbTR3d2c1ODlkVjItQVZBbGxoeVZWRFRVU2guUjJ5aXRXSmUzTUxaYU5fUGtzUHZsUS53OFFiWGNIR01YV3hpTnBhIiwiZXhwIjoxNjMyNDA1NzE3LCJpYXQiOjE2MzIzOTg1MTcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.K0Sx30JeZhSb4GfnQh6RQQbHvAyoQJBOji9i32Ejzi4', 'https://us05web.zoom.us/j/81766513534?pwd=U2VrT1VHcWFoY1I0NDRhVGtycDd4Zz09', '6SW90B', 30, '2021-10-08 11:05:52', NULL),
(11, 'Table 1', 0, 1, 7, NULL, '15:00', '15:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/86109812517?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NjEwOTgxMjUxNyIsInN0ayI6IlpBM1hMZDJkOUJaMzhBZG1PUkdWYlJ2TmI0aFJ4OUtiZnI1WksxTXJPejAuQUcuekxaOUtlUnBrYW9vV0poMGlxQ21BZHphRGJYcVY3WTJPZFZEUS1UT0dWdWVIakhucTRwLUpZci1pVzZkVVB6VGhySlNfNTRsQThBMlpmTjQuUF9IZ01MMmZjTC1BMXAwSXhEMms2QS5fUmROSWlpQkh0UDA4UVFnIiwiZXhwIjoxNjMyNDA1NzE4LCJpYXQiOjE2MzIzOTg1MTgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.aoKK2UhF4YQjJIfuHJefdkGffBc2g4ocKiIWgJkm30k', 'https://us05web.zoom.us/j/86109812517?pwd=dExqa2tTV2VzQm1mQUJabjdEL294dz09', '2btX6Z', 30, '2021-10-08 11:05:52', NULL),
(12, 'Table 1', 0, 1, 7, NULL, '15:30', '16:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/85263485871?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTI2MzQ4NTg3MSIsInN0ayI6InZhSmRKQ3dsd1c5UnV2TnNOYTZVU095RHQ5R0ZpWmNNQW1tanJaWXlRSm8uQUcuUVFaVEdLUmYwZ182RE51alBiUURxWDZ6YUhKcHJuU3RjUEEzS3NRZEMzejNmYXFtZE5vR3hRN1FFRkRZRUVZVDBhdGNPa19vblJ3NzZMencuay03VEdfYmRUV19NUlp3ODY5YkROUS5MV2F2a0tnQm1Va2ZkSGszIiwiZXhwIjoxNjMyNDA1NzE5LCJpYXQiOjE2MzIzOTg1MTksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.gN6qeU4QocrO9NmMs9aVtWIISdBktB0ScmCraR_GKYw', 'https://us05web.zoom.us/j/85263485871?pwd=VjRQZlZ5cDRRQVdzc1Btei9peGpzQT09', 'P10j7N', 30, '2021-10-08 11:05:52', NULL),
(13, 'Table 1', 0, 1, 7, NULL, '16:00', '16:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/85154993738?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTE1NDk5MzczOCIsInN0ayI6IlFWSlc5OU9kWFZ1SjYxYWktcURXbTN5ZVcwei1ZUUpENUdoWGI4a1Eyd2MuQUcuY2ZVbW9JOE9oQm5ZQU1XNGRPZVVfbFZVa29BWmRFbDZUcE5UWTNuUGxpMktVeXNPaWtxVV9Ob1ZrVDRwaWtLdFR6LWhEVktJRTRDVlhoVzIuenAzZk4yMUdSdU1fQkdTTVRiUmNUUS4xS2xJWnY3b1BwN1ktTmJYIiwiZXhwIjoxNjMyNDA1NzIwLCJpYXQiOjE2MzIzOTg1MjAsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.mu-NetO0iJGKyF0pM0jVhZkLIxAlHgqanlHeRGgKXwI', 'https://us05web.zoom.us/j/85154993738?pwd=NjFieldKaENMYm1FM1lMaUtjbjZ6Zz09', 'bX6eYQ', 30, '2021-10-08 11:05:52', NULL),
(14, 'Table 1', 0, 1, 7, NULL, '16:30', '17:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87271589401?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NzI3MTU4OTQwMSIsInN0ayI6Ijd6eklLcVo2LXRjeFFYZW5JTXg4YmZzeXJ1bGdEYWd3eUUxWVNDVFpBa0kuQUcuOExjUVpOcWFNZm96c0VsbUsydm11NnZDSl9hMlVpT0h5dFlKTkVUZ2dLV3RwSWFLaGUyNEdvTkU3eC1mNnA3enhPNWFleDdCOXZOLU1TX0kudUxrc0R4R3dpbTNkVXVib3R4dzBOZy5RUWlrTWJFRmlFU2Q5NnVsIiwiZXhwIjoxNjMyNDA1NzIxLCJpYXQiOjE2MzIzOTg1MjEsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.fjoWX30Oc28xEKOXs7FVrvL222ao41pWVd3rRZh5ge4', 'https://us05web.zoom.us/j/87271589401?pwd=dVE0YnRvZTVkOUhQUVRJdmNJNGRXdz09', '9Z8xhf', 30, '2021-10-08 11:05:52', NULL),
(15, 'Table 1', 0, 1, 7, NULL, '17:00', '17:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81208273554?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTIwODI3MzU1NCIsInN0ayI6IlVjOUQ3bUlubGRTM2VtcHkwUDZYYmtuSW1KZDNDUjRYdlNnWnpGbkJkRkUuQUcubHc2ZWZRMmZHZmoxX0R4OGtqTlRrVXZTS3VxWWh1dk8zU2dfNzZUSWhxcm9PRjNDcTFOdzE5aC1OaElzWkQybVlhdjc0bHZ3YUlDV29QQnYuMWoxcGJlNFB0Z2l6RjlscjlmTm5Rdy5SdGtjVzUwVzc2dGM1SVUxIiwiZXhwIjoxNjMyNDA1NzIzLCJpYXQiOjE2MzIzOTg1MjMsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.5YiVASsvtWxtS_YYMMgNaPBRUc-OThCoSRpSpdPaN5w', 'https://us05web.zoom.us/j/81208273554?pwd=eUpndDAwdGM1amdnZW9Fang4eDZnQT09', 'EbUL50', 30, '2021-10-08 11:05:52', NULL),
(16, 'Table 1', 0, 1, 7, NULL, '17:30', '18:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/86145417851?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NjE0NTQxNzg1MSIsInN0ayI6IndGeWdFajZudm1jRzg5R2FCQkx1N0N6Z1FlVFh2dDMyMDUzdlE2MVFPZXcuQUcuMFJ3ejE1YTVZWHRKcTN3MmFHUU01ank1SWptdVdxVXRLR0U2M1lCTW5PeERTMDBKNTVOYnEzaGpKVUlRazFicU9oemxmQmdOS3JTS0NDVjkuQXVVSjhWNm9qblctVXFvc1R1ODhLQS5PeURTTEFTamY0d0V1OTNFIiwiZXhwIjoxNjMyNDA1NzI0LCJpYXQiOjE2MzIzOTg1MjQsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.g_fWJ9gv-mTf6m7SopWcdEvZA0ggUND89KxPokPXxhA', 'https://us05web.zoom.us/j/86145417851?pwd=dlZCTi9scG1nckEwS2lRaEVJUWlCQT09', 'N0Y2BH', 30, '2021-10-08 11:05:52', NULL),
(17, 'Table 2', 0, 1, 7, NULL, '09:00', '09:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88410550585?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODQxMDU1MDU4NSIsInN0ayI6InVpWlhoOGFZekVtb0R2akJ5TW5DR3BGY1lZUHZsakhqSllJZFdmY1VnUjguQUcuT3pxWFhWc0o0eUx2aWNPYmtuNzc3akhhLUw4Rk9XWThJa0FHYzI3UTJNT1BSc1hCQVVKS3FJYkVpeS13WTkxX1RHQjhwZlpCaGNoRE41ekQua2lKOWNObFBJeVdIUDdXN1lQRjlzQS5MTzdNdVBnMzVfWGJYYk12IiwiZXhwIjoxNjMyNDA1NzI1LCJpYXQiOjE2MzIzOTg1MjUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.DQOzVz3x_Dv2bNNN17CDEW9_EU04jW7X5KgO5uBGqT8', 'https://us05web.zoom.us/j/88410550585?pwd=Um5oZEpiaEIxZ1hUSTViZ0k5UHUydz09', '3Ezzk7', 30, '2021-10-08 11:05:52', NULL),
(18, 'Table 2', 0, 1, 7, NULL, '09:30', '10:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/84268507665?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NDI2ODUwNzY2NSIsInN0ayI6IlpNbDVjWnF2eVVrR3V0UHc2QU9UZWhpNGloZkJRRUlOTU45RGJQRmNOaHMuQUcubnhLOXZ1eF81cVNoT2Z2Q2U2ckIwQVdobUdaS3UzeFg4X0h0OXpyUXRUeW96alp2cWVidmpoYVoyTDhyQndJY2RVbTFoVXNtYjBSZWc3RVguN2ZGMTBPSlJZNjRrdUEyVGNjbHM4US5Bc21WQ1lUb2FFUGJJZFdQIiwiZXhwIjoxNjMyNDA1NzI2LCJpYXQiOjE2MzIzOTg1MjYsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.dDiqvbbUuDPxxP1yFyuzdB--Yi8RnkOpqoKIcFr88_U', 'https://us05web.zoom.us/j/84268507665?pwd=S2pIck1HMi9oTUM4b25kM1lLK1dudz09', '5Fr6E6', 30, '2021-10-08 11:05:52', NULL),
(19, 'Table 2', 0, 1, 7, NULL, '10:00', '10:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/84034100501?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NDAzNDEwMDUwMSIsInN0ayI6IjRaRW1zTFA3aWxIUVBQbHhQbC1kMHZ1QncxLWt2aWdmZ2JRcENKVkxEeGsuQUcucWZ1TVl6XzViNjhBdUtYUHZoZzJlcWdmX3ZTRmlRdXo1YTBCb1U4eXRLVlE0ZjMybWduYk5DNU05UXBUVHBtQUZyemdLbzdMeXE5eTEycmsudzREdzNuZTQzVi1YRGp5bndtVW03US5CQzBTT2xOTEJveFpOU1FNIiwiZXhwIjoxNjMyNDA1NzI3LCJpYXQiOjE2MzIzOTg1MjcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.6S2SY2rHsgkC-Li4X3NhxHlZFIICFJhZ-ci3evlbk9M', 'https://us05web.zoom.us/j/84034100501?pwd=dkI2b0VFNHNwaWUwN2xXZSthOG5MZz09', 'wBST3v', 30, '2021-10-08 11:05:52', NULL),
(20, 'Table 2', 0, 1, 7, NULL, '10:30', '11:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89980378238?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTk4MDM3ODIzOCIsInN0ayI6Ink2a1J0eWpDRHpKSE1xOEltYjhObDJfbl9sRlRuUHRjYW0xUUJjVVU3dTguQUcuSDR5SWVUaGltajRCVWFod0tqdEJtcGlfV0QzYzBLQ3lRQ2lPQnI3c1NUWmV4enF0Tl9Ra0hzTU9BWm1ZTWFOMmc5dzZMaTgyUGM4bjI2cEkudUpiM0RBUVQ4ZFMwOC1lM3Q4R3dSdy5id3BmTzFDT2U4NnkyVzNDIiwiZXhwIjoxNjMyNDA1NzI5LCJpYXQiOjE2MzIzOTg1MjksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.7qa9SA0bKEskeVfIToDm_oqXbOeTXdr0pwgqZG1AvoA', 'https://us05web.zoom.us/j/89980378238?pwd=a3NUMHJpaFdqaEIrNklVRk1QM0h1QT09', 'zvz3Ya', 30, '2021-10-08 11:05:52', NULL),
(21, 'Table 2', 0, 1, 7, NULL, '11:00', '11:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82306596579?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjMwNjU5NjU3OSIsInN0ayI6Ikh5MDNJbVBfM2M2b1dhVWtUeS01a2ZSVWRDbHFSa3RHYUpHaEM5cHl6N1kuQUcuZTVRc3pOdUNFNklEZks3RC01eTJkam1MRHk2MHFNTnY2S1VnaXVXWWZIMVhPRjZwbENZa0s3TzdmXzRZOVRBVUdtRFhxUFJlci13UzFEdk8uNTlZdExjcXJDMmFtWXNUTVliMWNTUS5mYWFnRWY5OUdwdUN0NTMtIiwiZXhwIjoxNjMyNDA1NzMwLCJpYXQiOjE2MzIzOTg1MzAsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ._MEwdF4YqTIRzenfc84rIGrXbzwrBtZg_YBlEebsXJ8', 'https://us05web.zoom.us/j/82306596579?pwd=YXF1MlE3dzFUY0JUeHFtR05UaTlXUT09', 'hNMj9s', 30, '2021-10-08 11:05:52', NULL),
(22, 'Table 2', 0, 1, 7, NULL, '11:30', '12:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87895705094?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4Nzg5NTcwNTA5NCIsInN0ayI6IjM1QmZJTXRORk85V2dQS1FVRkJidUQtLXlTMzhpTzhhb2ZtbmtHRzhIZnMuQUcuQWkwV3psVHRja0ZMRHpacEF0SkFpRnl4MmRnVHdDQXV6cjdyLTlRYm5sTHBpSV9kYVI2aXFhU3ZJckZUdlRYZ1lIbE9fcElSZC1oV0xjN0suNGNvRWZXQmdQcDctc3hHUEpwSVlBQS4zWUhGcW1LTU1JZWVYQjZXIiwiZXhwIjoxNjMyNDA1NzMxLCJpYXQiOjE2MzIzOTg1MzEsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.fDUs--cDQCwInj4JNHBR2D87Hkx78XajsJjjocJ7u_Y', 'https://us05web.zoom.us/j/87895705094?pwd=cmZNSXZYb1pROGd5bW43anJacTVHZz09', 'Z4jTr5', 30, '2021-10-08 11:05:52', NULL),
(23, 'Table 2', 0, 1, 7, NULL, '12:00', '12:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87457702575?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NzQ1NzcwMjU3NSIsInN0ayI6IkFpdlJqVUFHaEpYN3RLNnJIbDhnbjk3UkNWTVBDUEFQc3FQTWFMX3lQYkkuQUcuUVVCYmpoR01kUWs1eDgyS082azVWby02QkNtMVhvbTFVX0FYbG9FOHVKWFpFZGhYYWQ4ejVEelJ6R2h1MzQyNHZ5Z2xhdHlPanJ2SHQ2bjguUDNqTV92aUNvYzFFYzMzZ1ZiY1Jkdy5XWmI4bGZkSTBJelVBUEdBIiwiZXhwIjoxNjMyNDA1NzMyLCJpYXQiOjE2MzIzOTg1MzIsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.vP_NBWeuPxbR1MuLqkz55OW7UTDcxdQs2DWZa4ZsAOg', 'https://us05web.zoom.us/j/87457702575?pwd=UldJRG92djJaOTd1L1BJY0dCVnNQZz09', 'ez8vcW', 30, '2021-10-08 11:05:52', NULL),
(24, 'Table 2', 0, 1, 7, NULL, '12:30', '13:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/86443008625?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NjQ0MzAwODYyNSIsInN0ayI6Ikw1akxsa2ZiYmZiVFZQUEgyc2J3a3V4d0RSbDB5LUg1aXZud3BPOElzZjAuQUcuZ3JjNEVDc09Tem1kWXFZZ0FRcTNlSVZoTzlCTlN4TnFCNnNVcXVtc1puSFZ5WmVkcWxvTWdGWTI0c2tKQjcwM0o2S1RYLWl0QktDSE5vT0YuaGdjWXhEcVY1LW5EQ3FOcVBqZV8tQS53UnJIVFBpUjVJT0FoLW5oIiwiZXhwIjoxNjMyNDA1NzMzLCJpYXQiOjE2MzIzOTg1MzMsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.2wFQjLp4lys8TUDA2aulLyuxRoWZge8ws5V5NCV9B9w', 'https://us05web.zoom.us/j/86443008625?pwd=U0FSa0VOVnVUU0lwQVFTVEgxbllvQT09', 'u9PKK1', 30, '2021-10-08 11:05:52', NULL),
(25, 'Table 2', 0, 1, 7, NULL, '13:00', '13:30', '2021-10-08', 0, 0, 0, 0, NULL, NULL, NULL, 30, '2021-10-08 11:05:52', NULL),
(26, 'Table 2', 0, 1, 7, NULL, '14:30', '15:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/85808721837?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTgwODcyMTgzNyIsInN0ayI6ImFIanBicjlWVjA2RHBVeC1kUnJJdzMzRXNhVDB0R183V2l4cFYyNlRoN1kuQUcuY3VBWDdueFZ3ZTFFM25IQzBYVU9YN2hmbzR4eGtNaUVQZFF2cll6aW1IMU1tZG5sOGVFSDVEc1dxQnhOWFVZb09WaDBDZ1F0UlZ2TVdoYkUuWWxNSktkZ1dzaFZ2dE4tU1B2NEQ5US50WW1RaE5tU0JaNG9UbnZMIiwiZXhwIjoxNjMyNDA1NzM1LCJpYXQiOjE2MzIzOTg1MzUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.aChdMK07tCSIt7dU3lrOEQLumUb2gRiGNiZK9BWTj7c', 'https://us05web.zoom.us/j/85808721837?pwd=S2o2amV3elJTNUNVczNwTVpjTmNRUT09', 'V73tF3', 30, '2021-10-08 11:05:52', NULL),
(27, 'Table 2', 0, 1, 7, NULL, '15:00', '15:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89701209382?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTcwMTIwOTM4MiIsInN0ayI6Ijh5dzR1QldBYnh4R2pjME11blR4ZXZGS1AzZ0JVWU5sSWZUaDNha1dFZWcuQUcuQUY5elN4NFZZeEZDdmtfbERrSG5ibjJQczMwLUhDazdidlBvYmRrd0FSYWloU244Q2pfMnI2ZHBvb1Nqd1NQc2xyN3BZTGIxSXRWT2k5TXoublNjM2Q2a2I1SlBTZVdmdjgxUXcwQS5yRjR4Y25JaExzV1FOTnlpIiwiZXhwIjoxNjMyNDA1NzM2LCJpYXQiOjE2MzIzOTg1MzYsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.BzbBIvcNJECVqxjFwUVvVd02ldJAWfyTywTzi7DRHK4', 'https://us05web.zoom.us/j/89701209382?pwd=SUI3WFpQUXJpbU8rRVJEdWYxay9iUT09', 'z6q0Fh', 30, '2021-10-08 11:05:52', NULL),
(28, 'Table 2', 0, 1, 7, NULL, '15:30', '16:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81015640564?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTAxNTY0MDU2NCIsInN0ayI6InpGMXFVZURFWk5DbV95ZzNfMVh5VlRXTlFGeTZlZ2RWZXBRNWxaZno1eE0uQUcuMlVBeExuU0h3Qkl5N1ZlQ1cyb0FZWU8xMUFYZTlEMlc0S0RIREsxYmRLV1FRNVpydzNSSXFrUjRVS0pJallCcUhVS2x2RE5RMThvZEp1YnIuTUxKWHl0VUhJbE9zNEJMZVJnazhUdy5Pd29xcTBwNVNfeGdKVzd2IiwiZXhwIjoxNjMyNDA1NzM3LCJpYXQiOjE2MzIzOTg1MzcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.7fMaMZsTYiP_1BfhBBRyEGJ8EHM8eiESGamYpuWponM', 'https://us05web.zoom.us/j/81015640564?pwd=UnpBZ20xR1JDc0VGYnNxOEJMYVpxdz09', 'EqD2VW', 30, '2021-10-08 11:05:52', NULL),
(29, 'Table 2', 0, 1, 7, NULL, '16:00', '16:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82691848364?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjY5MTg0ODM2NCIsInN0ayI6Im5yV3NDekFHSEgxaXZFTEcyTGlYUTl6WDZuWktURmR2WHMyY29BeERwX00uQUcuRDBJWnV0dW1GeldoWVppRGpBbVF6VXJMODdiQko5aXhDcTZaQ2RRWE15X1p1ZGNXbGR3Qzl4amVHYXRUV2N5R2dBazhrRklaeWJTQTZKa0EuUHR6RzRGaUJyMmN2bEpSSHpQdURSQS5HeHZBalo1c1h5bFdpV0t3IiwiZXhwIjoxNjMyNDA1NzM4LCJpYXQiOjE2MzIzOTg1MzgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HzEO6vFS-lvak87mrccANoREv1zMlFr55BlqWSLTrFE', 'https://us05web.zoom.us/j/82691848364?pwd=T1lvOC9MR2VGZnFESGpwWmZ2NGVhQT09', 'fB8KkU', 30, '2021-10-08 11:05:52', NULL),
(30, 'Table 2', 0, 1, 7, NULL, '16:30', '17:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82435808992?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjQzNTgwODk5MiIsInN0ayI6IjJTeFlWcXNDYWIxY3pQT0F3NEVvdXBJb2VhX1BZNE9vRDQ0b2wwMkVEZzAuQUcuNkJGOFhIbzJLYmgtLWFaTTdad2JLTDJRNUtwTjlXdXVZVmVyalkxdTEzblY0OXN6Zzl1aVF0b1V5emtnVTBZVlNrdXJ0NHczWXkySE5POVQuU0xGMjZFaURWQ0J6MWRCYlNDcGpBdy5rVFpKdXBPalYwaDhpZkpHIiwiZXhwIjoxNjMyNDA1NzM5LCJpYXQiOjE2MzIzOTg1MzksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.nrkxaKLYqjwjQRK518mUTk1OtnBKaJk5QKx5dfdhN0g', 'https://us05web.zoom.us/j/82435808992?pwd=UlVJV2JkWEJLYnRKQnp2d1p0UFdLZz09', 'M7ArD9', 30, '2021-10-08 11:05:52', NULL),
(31, 'Table 2', 0, 1, 7, NULL, '17:00', '17:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/85168845300?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTE2ODg0NTMwMCIsInN0ayI6IjllVFpMbUNuOVFMWTRaaHdnOWFrdUZxUnU0MlpBUEIxVUVFVVN5Zi0yQTguQUcuakJIYndsb3ZFNTlaV3g2WDNRSms5MkFlZ0NEWXVDdzFZSl84SWxyQ1ZUa2gzQjVxT2JVZDVjMy1oQjU2UURJQTRsMjFDeWF3X2xlbDJFWDQubkNTOE5rWkVwQkRCcThKNnROZGNqZy5IQ1c5WVFQR240YWlNRmxlIiwiZXhwIjoxNjMyNDA1NzQxLCJpYXQiOjE2MzIzOTg1NDEsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HW5MyYu28KYFWTuf59PLnYvj-MuV8YvyVN8V2CDIdUs', 'https://us05web.zoom.us/j/85168845300?pwd=L2xPU2Y4TTNOQUNnQlBGWlM3VGhTUT09', 'hGC5ZM', 30, '2021-10-08 11:05:52', NULL),
(32, 'Table 2', 0, 1, 7, NULL, '17:30', '18:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88233883889?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODIzMzg4Mzg4OSIsInN0ayI6InJnRERaYVctVTk1b2p0OVd6QUlzdFRlU3Z1QmUyRkMyQ1FsRzZLRzlRSEkuQUcucm9hOGZBMFQyWXRjcVZHRWl4U3RsTnJkbGZKMWNPSVJCMU42Wnl4aFNlYnBjaEpybElYUEt4QWk1LV9YUkV0T1RUSGV6MUZhdEtoNjhxUm8uSVE4R0dSSTg1cS1YNFVoc3FFWmltZy50Y3VJYWJRalp0M2JzZVU5IiwiZXhwIjoxNjMyNDA1NzQyLCJpYXQiOjE2MzIzOTg1NDIsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.1QYLJTWPzO3cwIx_bVyqt__lSfkYTDmHa9FY4_J68vc', 'https://us05web.zoom.us/j/88233883889?pwd=OVNlSUFqSzFwVW0rSkVyRGlPMjJQdz09', 'NgT8nw', 30, '2021-10-08 11:05:52', NULL),
(33, 'Table 3', 0, 1, 7, NULL, '09:00', '09:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89138597724?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTEzODU5NzcyNCIsInN0ayI6Imp2dFNHcDJUb0NGMzhyVFNmNTdNczJHU0FoM214TDVRUnExTlowYWV5OUUuQUcuaGZWMkQyeVktbldyYTB3MnQ3UHlOdFBBa3Rld2tGRmlfTHNPT0NDMFpLUm14eXV5MUZhMDB5OUVlbTdFMHBVclhnaFA1dDQ2Mm9ZR25FalEucTI5UmxRLUU2bExaeTVNT0NJTEgtZy41aDJmWXpZeFI3cndDQzV0IiwiZXhwIjoxNjMyNDA1NzQzLCJpYXQiOjE2MzIzOTg1NDMsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.63NOnRnTJVzwql5ZBVMi58nYWhaPwkoqD1XOzaMR9CY', 'https://us05web.zoom.us/j/89138597724?pwd=TXZJeUFxWEJuZGJQY2FpQzNmbjMvQT09', 'd6G57z', 30, '2021-10-08 11:05:52', NULL),
(34, 'Table 3', 0, 1, 7, NULL, '09:30', '10:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/83288431712?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MzI4ODQzMTcxMiIsInN0ayI6Im9jRVlhYzdEVUh6RFBPU3ZNcXctcUUtTlR1Ti12RXA4N0NyQ3NDUkpZb1UuQUcucWh6RW1HZXJqT3dfRjNMSHEtRUJKSHN5a2hSblk3eFNTZjNWVm5PZlNNeGhBY292NUF0aWo4cU84RWlQbWZ5dVhRWXlIazZqRkwteTZiZWQuT2VyczZUb0p5cU4zQlVKMVNTRUc3QS5PcmVMbExnd08xbjlKMExuIiwiZXhwIjoxNjMyNDA1NzQ0LCJpYXQiOjE2MzIzOTg1NDQsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.QdqggsBmqpC9n5VgMssN5ddtchAXLBjL4e3DBf1-HIY', 'https://us05web.zoom.us/j/83288431712?pwd=emdrOFFDZTNndUcwQjdBeVgwUWYrdz09', 'eJXBc6', 30, '2021-10-08 11:05:52', NULL),
(35, 'Table 3', 0, 1, 7, NULL, '10:00', '10:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81476239948?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTQ3NjIzOTk0OCIsInN0ayI6IlBULXFYdlMzWVgyQmNJczB0ZUsxTmM4cTdaMHVlR0lKOXZycGZReUJqS3MuQUcuLWVnczdTOUJObXJIenBZcG9yZVU1SmRHbGxaeFlqaWFieV8zelJiWjJQRHI5cjA2N0JPQzBiYXMxQ1RWUjhfSDBRTDBNb3dJNDBPbVV0ejkuYllYQmJmQW1lT29lWklMOXZqdUs5dy5aakxnWlluLVBKLWVtSXVDIiwiZXhwIjoxNjMyNDA1NzQ1LCJpYXQiOjE2MzIzOTg1NDUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.9pA_EkqbIjVjwpUH62COR7Z4ZpgTg5kFDeeMK1ee3rw', 'https://us05web.zoom.us/j/81476239948?pwd=dldNcDlQQXhHRGJlNGhOdy9uY1RSdz09', 'nm8Pyb', 30, '2021-10-08 11:05:52', NULL),
(36, 'Table 3', 0, 1, 7, NULL, '10:30', '11:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/84704264647?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NDcwNDI2NDY0NyIsInN0ayI6IlRmb2U4NklDbUdnQUt2NmpDQVBBY2piZVFZcWlCTDlwc1NlVldlS2ExMWsuQUcubnJMSkt3c2RpaDVHV3Q5SExfSWo3YWVRVnFDTnpNZGJWVDNiMy1fTHpXV2RTVTRrc2drVHZ4cXRTUVpJUzI1U09aZExBd2ZnVWdtcUYyX2guLWcxeTdodVlFLV9FV0MzdVVZMkwwZy53dXo4ckN1S3RnNEMzcGFRIiwiZXhwIjoxNjMyNDA1NzQ3LCJpYXQiOjE2MzIzOTg1NDcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.8Z6bOQbmLQTkwf6UOhQUnCDxdDWHUN_bo8dYga8Ynuo', 'https://us05web.zoom.us/j/84704264647?pwd=SVB4ZzFTUlRjRlNiM3haK09KbEpzdz09', 'qv9H3y', 30, '2021-10-08 11:05:52', NULL),
(37, 'Table 3', 0, 1, 7, NULL, '11:00', '11:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88943551740?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODk0MzU1MTc0MCIsInN0ayI6IjZFUHdXM1ZRd3ZmQmFkNEhWbEs5MmkwSEF6NENmUUxINFBnbWQxZkxCMjQuQUcubHJuVmtYNkhpRE9IS0hKVVJ6anVKbHU1VWxudGZLMU40UzgxMjdVVzJXeUlqVW42ZzRuY1Q0ajZTOUV0WmZUbXRLQjY1aFRFVGdkQ3RUN3YuOEtSaXpSOVMxRW1EN0NBNHhMVTFMQS5scGJGWm44QnhmZjUxd01SIiwiZXhwIjoxNjMyNDA1NzQ4LCJpYXQiOjE2MzIzOTg1NDgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HJqt73DLJwOu5_M9BcWqsAk2qZ6uqDrUoCzHIDv7KgQ', 'https://us05web.zoom.us/j/88943551740?pwd=TGs4TzR1MldGZlhwVEc0QUlBdGgwZz09', 'Pu8v4N', 30, '2021-10-08 11:05:52', NULL),
(38, 'Table 3', 0, 1, 7, NULL, '11:30', '12:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89664512901?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTY2NDUxMjkwMSIsInN0ayI6InVwcFN0eXdWXzJ4SlIydXhaQnNPUEVxLXA4SUE3cmd1bkU4dHR0TUFiNkUuQUcuYlBEYjVVV1RnS29jMkZWRFRZT01VMFRXZkl0b2dRTU8wS0U5UFFJaVBLNlRBZXcwY00yVzB3TTRlV0JyZjhOUlNGcnpRLVZDTnlDSVY5OXQuQnJjTEllOHJnWGdILVhmR2tkNEliUS5YLWJFNkE0M1FldWFmUC0xIiwiZXhwIjoxNjMyNDA1NzQ5LCJpYXQiOjE2MzIzOTg1NDksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.hPGhRanbyw-cUsllN_gM52T2q88A7Mx-o3VLBCFD8yw', 'https://us05web.zoom.us/j/89664512901?pwd=NEc4UklqczNENDl1T0QvVlM4WDJBdz09', 'SmHF6H', 30, '2021-10-08 11:05:52', NULL),
(39, 'Table 3', 0, 1, 7, NULL, '12:00', '12:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82115165250?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjExNTE2NTI1MCIsInN0ayI6Ik5XNlVhLWJ2cE8zRDRNckJJLVVaWlRZRXBuYXBWS3F0OVd4azhHUHJyZm8uQUcuRXIzaDFEZERxbmxSYVI2N19ROG9kX3VGVHJyRXNrR3JreXM1aDV6QTdoRmxBVUo1UzlsdXZCemc4SnNCM1ByREFCMVVQX0tMTWlwVy1USHIuQVRCc291SWtrQl90N3dPV2dSTkprQS4taVItZ1NLN2VZME9OSWRxIiwiZXhwIjoxNjMyNDA1NzUwLCJpYXQiOjE2MzIzOTg1NTAsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.UDrfK4H8o7MCp19Ui9MXR-FBxR1fHU-KvQbmuh0HgIQ', 'https://us05web.zoom.us/j/82115165250?pwd=bnZJR01mSGd0b0l4bC9Cai9zNEh4UT09', 'u2AMCe', 30, '2021-10-08 11:05:52', NULL),
(40, 'Table 3', 0, 1, 7, NULL, '12:30', '13:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/86708009235?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NjcwODAwOTIzNSIsInN0ayI6InpvbHZ0ekFuV1RoWmpoV3czNmZKM1lKMHd0ODRCUzVGX2taTzFFajBHa2cuQUcuMmcwVUZqRjRfX3d4am50WHpzU001NEdVS2g4VDBMSkM5eHVjNlF1Qm85ZXFOd1doR3dfR1FaMFdLWm40UGZSczh6LTh3ZHZUR2E0c2VYY2MuX0szcFBHS2x3R2xnUXNsMU5TQ3pLQS5zcEt5aElzVEVoQlN6M3M1IiwiZXhwIjoxNjMyNDA1NzUxLCJpYXQiOjE2MzIzOTg1NTEsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.RfN9XwkIui-6-JhZ_4T5Dl7Vyv78ElMWIpZZSIYK8to', 'https://us05web.zoom.us/j/86708009235?pwd=NXZ5YlJWYVFZa0p3VUpZWHNwa0QyUT09', 'ft4uDL', 30, '2021-10-08 11:05:52', NULL),
(41, 'Table 3', 0, 1, 7, NULL, '13:00', '13:30', '2021-10-08', 0, 0, 0, 0, NULL, NULL, NULL, 30, '2021-10-08 11:05:52', NULL),
(42, 'Table 3', 0, 1, 7, NULL, '14:30', '15:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81019445003?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTAxOTQ0NTAwMyIsInN0ayI6ImM5b0Y1dncwakRpckRIbzFvNXZ6WlVZc090ckdURzlfVzlSM2stZ09JVkEuQUcuTmtQQ21TTkgyYTV2am9UNmoxblJZaGpCbVZ4dTNJMkVsRUo4VDFoTktyUnFOTlA5a2ZlS1dmQTV3SmVGbklRN2Y1bGhuZlF0dzhTemZfYTAuYXlGaHR0Nm56dFB4eE5abjcya2ZmQS5JanpLckFMNU9SM3BwWXExIiwiZXhwIjoxNjMyNDA1NzUzLCJpYXQiOjE2MzIzOTg1NTMsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.uWtcRGZz802gKX2UhqCUwBA47Ld2GoCaxUY8RMN0zjs', 'https://us05web.zoom.us/j/81019445003?pwd=ZFZnOFFuM1l6RHpLNVVySWZGaVRSQT09', 'PFgL41', 30, '2021-10-08 11:05:52', NULL),
(43, 'Table 3', 0, 1, 7, NULL, '15:00', '15:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87357165002?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NzM1NzE2NTAwMiIsInN0ayI6InpmeTNPMHJTc3dyMnBiT1BjelZGcGt0Wnl0cXVfZlFVOW9tdDN4NU10bmsuQUcubE0tblhIWHNLYnRHYnd4aFJLa1FDQzVXYk1LX2NqVV91cDc4TDZKS1RsdzdxeWFpeWFocF9pRktiUjhUb1hzZGNXNlphX01XZmRud1p6Q1EuM3BZZHdOcWVyU1B0emRrbEJCaTRhZy5RQTdVMEtCcG1OTUt5dk1kIiwiZXhwIjoxNjMyNDA1NzU0LCJpYXQiOjE2MzIzOTg1NTQsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.764HliB2R4ScoMeYPt7EJ3wOzhLSz1UkhCgCvWzWRbo', 'https://us05web.zoom.us/j/87357165002?pwd=L25qbm8zeElUOTlkZWkxM1crRlVCUT09', '6e5rgE', 30, '2021-10-08 11:05:52', NULL),
(44, 'Table 3', 0, 1, 7, NULL, '15:30', '16:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87598588621?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NzU5ODU4ODYyMSIsInN0ayI6IjlUemVvWm9KbTZoM0gyaVoxYjU5dUoxaElRdU16MHBvYjJvcFZYVVZ5c1UuQUcuUHpiWEhxaFBraHphSHpxNlg5YkdBckl6MVlncHQ0VXVDUkZvWlJwQ0V0c3JReGs5ejl6RmFVbGRLd1BFOTF6M09NWUdGSEFtTG5NbFJFSWEudWZQMjJGM21LREpfc0JPNlNzVXVyUS5lRWtvLUZ5WDU1OEZYWHRfIiwiZXhwIjoxNjMyNDA1NzU1LCJpYXQiOjE2MzIzOTg1NTUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.rGp6TVY9n5E21ZOaXMwr0DmuKZuCQE_UGXQyYdd_c88', 'https://us05web.zoom.us/j/87598588621?pwd=MTJDTUc4b3lIbjVSbEkycXN0NURFdz09', 'xpXsp4', 30, '2021-10-08 11:05:52', NULL),
(45, 'Table 3', 0, 1, 7, NULL, '16:00', '16:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/85191541338?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTE5MTU0MTMzOCIsInN0ayI6InZZdjlKcGVBYmJsRlE5RDZ6dHdkZ25nOWhqMV9fUW9PTW5TWUhLUGRQdmsuQUcudV9VLWJqSV96bUU4NEk4NUlkT2N2M1d0a2hSR0lSbDFxbG1NamhmVDZFaFpDYVlNcXJOVTl4SjFqYmFxNGhldXJwcTRiaXVvVUkyRlMzbDgueGQxT0F3eHhaNm9TNHltZkxfOEk3Zy5nbFBqMFBaem9CLVJWdXVJIiwiZXhwIjoxNjMyNDA1NzU2LCJpYXQiOjE2MzIzOTg1NTYsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.uhjoygM-b-E21lj6kAisg5OU-sAnkF7TUSwx7yktE8o', 'https://us05web.zoom.us/j/85191541338?pwd=SEF6dVROVkZOOUM0UEJxc1BHcmFJdz09', 'b9Ffvd', 30, '2021-10-08 11:05:52', NULL),
(46, 'Table 3', 0, 1, 7, NULL, '16:30', '17:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89404585520?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTQwNDU4NTUyMCIsInN0ayI6InFmdXB0TUZWLWxZM2d6amZ5U2VJQTlyUW1rOTZXc2NCcUNJaldoeDJUUE0uQUcuV3d6eDJNdWg2Vk9ENWg3Mk5WdDUzdnFNTnlha3l6bHMyRzg5dVJtNndFS1AyMGNPbENPTmJoeWRYbGc2WVJBSXVXZE9OdWdra0dCRkNZeGYuWnNyMkNwN1V5ZlJGekczZWlxSlEtZy5Qem5mQ1B4MmZvM3FrOVl2IiwiZXhwIjoxNjMyNDA1NzU3LCJpYXQiOjE2MzIzOTg1NTcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HcTQ5gPBlbiocjKavQtDXP2_lzoF7I5bTk7uuaPStXs', 'https://us05web.zoom.us/j/89404585520?pwd=Q3RzeG1rc0VhT21lMnp6YWthWG5zUT09', '8Hc3eU', 30, '2021-10-08 11:05:52', NULL),
(47, 'Table 3', 0, 1, 7, NULL, '17:00', '17:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82161080679?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjE2MTA4MDY3OSIsInN0ayI6IlM4N2FjUW43MnZWQ256c0gzWWowSkJDOEstS2pwTW9acnB0TXFkdVlDNlUuQUcuMlA4TkdSY2NqeUFLVGsxTGhhOU1kMk51eC1aUlh0eWo4OW0wXzJLVWwyWGxZUnF0bllSeVJrY3FpVm1RRlo4Y29KdzJVVDU2U3dFem4zbXYuOWNiUEp5cW1VZXkzMGc3bGJCU1JKQS5qVGotM3VSTVpnYlZmOTlSIiwiZXhwIjoxNjMyNDA1NzU4LCJpYXQiOjE2MzIzOTg1NTgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.UHMVv9UFxEJmDYc5JnK7yW7c8-DBhYg7L_7OPYZxiHI', 'https://us05web.zoom.us/j/82161080679?pwd=SERZSnFiSHgrRXpJWi90Z1NXc2tpZz09', 'fi8SAi', 30, '2021-10-08 11:05:52', NULL),
(48, 'Table 3', 0, 1, 7, NULL, '17:30', '18:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81617523944?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTYxNzUyMzk0NCIsInN0ayI6Ink3Z1NnUGwzbnI3bXZCWGRaLVRINGRTYVFKOUl2VEI2MnMydVBiYm8yM0EuQUcuY3pzODN6UlRiVGFlVDJjcjQzSEFELUkzVzBQUG9ldVEtVnhra2tocGtjMVVNQURtNEdyU1JQc0t0ZXEzTWpITVJzVFNXeG1nTkZ1MzdJMmEuVHRjNDhxUjRkTGhuYUZUQ252SEVtdy5XOGhCb0xWZDNoSU1NODNfIiwiZXhwIjoxNjMyNDA1NzYwLCJpYXQiOjE2MzIzOTg1NjAsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ._f2gtj-dQc88Hlnxs1xG3Ezc_uRrBmVZ7iCWtFtMRXM', 'https://us05web.zoom.us/j/81617523944?pwd=VXlsRVB1WkQ0WU12WWxYSFB5NGxGZz09', 'r11yBt', 30, '2021-10-08 11:05:52', NULL),
(49, 'Table 1', 0, 1, 7, NULL, '09:00', '09:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/84084710118?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NDA4NDcxMDExOCIsInN0ayI6ImtIdlI1RVA2dXZpaDNBRkRRV3VGSHIzcHRNaUdNMFZ0Z0ZuR192MmhuTjQuQUcuZ3ZuZ1ZXMTYtV0tnR0M3eTM2SEsya0tjMnBGLVFUN2ZJOFBEeFJzNW1ZQWFvb3NsZGNBRGFZZ2NsbDlpR0pWc1E2LWNOWFh6VTY3aXhRNF8uWlFhSDJRYTk1UTN2OGFfbkNSamh3Zy5scFFjVkVYLW1CNk5WSFRpIiwiZXhwIjoxNjMyNDA3MzE5LCJpYXQiOjE2MzI0MDAxMTksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.Fui0mDb2E8oq7gABO-Fy7fdGgVC41CWCZn1KqOiTAYI', 'https://us05web.zoom.us/j/84084710118?pwd=TytNZTdWTTB4Y1pRaTRMcFlFYnoxUT09', 'Az44xY', 30, '2021-10-08 11:05:52', NULL),
(50, 'Table 1', 0, 1, 7, NULL, '09:30', '10:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82638411731?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjYzODQxMTczMSIsInN0ayI6ImVUZzlscjJ6N0t0RmlMZHVIdm1jRUJNREROQkVydnZ5XzZ0Mms2OTZ5MTQuQUcucFA2UW5paHdQbXN1NWVwMHZzNGZBVmUweThmVmk1WnRkRGpkVmRNa0VwYV9pcnR2cEJ3YnFZd3NnQzFjbmcwcFBEUXV4MHpBZmJjS0FwelkuckFacTVGR2JZUHlkMGhBYUZyVmhRUS5OZ1JtUy03WDl5aEpXaUZtIiwiZXhwIjoxNjMyNDA3MzIwLCJpYXQiOjE2MzI0MDAxMjAsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.jsXnunHaaf2bs3vcDibEmahmPmh8YkcAMgwwFORqYJY', 'https://us05web.zoom.us/j/82638411731?pwd=TEVBQ25wajEvN043UHZNbTJNNG8yZz09', '7s0ru6', 30, '2021-10-08 11:05:52', NULL),
(51, 'Table 1', 0, 1, 7, NULL, '10:00', '10:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/83368834339?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MzM2ODgzNDMzOSIsInN0ayI6Ikljd2VrVGFJVmdIaTlYWGFpV3lfMkQ2ZjRHWFdEeVJrbEwyZF9uVml4VXMuQUcuU0Y1RE5jWExqbXZ1bG9EclQ2OVEtRUo2ci1IcXJWeVhOTXBuOUtNNWVXZHB6Q01GZjkzNVRmZVdyZnRfYWpqV01BRjdBUTBJeDdRdHNIb1QuamZuNDZENGR1VU5oZTBHd1hsU0NYQS4zNGJDRmxaUUFQLVJhRlRwIiwiZXhwIjoxNjMyNDA3MzIyLCJpYXQiOjE2MzI0MDAxMjIsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.kQ9KU3q5JSZFUHmM0JErCJO8qnteRZQNg0X5btIFMdo', 'https://us05web.zoom.us/j/83368834339?pwd=NlpTOSt3UmVmSVdwdncwWFZDU0tpUT09', 'dip8pi', 30, '2021-10-08 11:05:52', NULL),
(52, 'Table 1', 0, 1, 7, NULL, '10:30', '11:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/84712779506?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NDcxMjc3OTUwNiIsInN0ayI6IkZ1Nk56UWhSRHQ0OG1wSUxMVmwwV3lYX1ZiZmpfalhXaktVRjAwNHYxU3cuQUcuUVB4clN6czFDRVM4TVBPeUxWVFU2SUR1N1prVWVDb3ByLWtURmRQaWk5dDlSQ085NmpMNnZfS2NORXlYMFR3Ul9rNWFhT0d4NlFhYVVfQkkuLXBUejFsRDBobUhSVlBIUVozd1ppZy5xVVlsZmxtaXVqQjFwUE9nIiwiZXhwIjoxNjMyNDA3MzIzLCJpYXQiOjE2MzI0MDAxMjMsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.3ntfsmDcxYPgHQnJO87SSwDEdxfzjtvdFHtaytATJIM', 'https://us05web.zoom.us/j/84712779506?pwd=N281c0t0UFBWUDVTU2EyRlViTEVFZz09', 'rnsd7h', 30, '2021-10-08 11:05:52', NULL),
(53, 'Table 1', 0, 1, 7, NULL, '11:00', '11:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88983776397?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODk4Mzc3NjM5NyIsInN0ayI6IkpwQ2h6V2VKbmVfSzdPNUVYMVpOb2pMS09VTWNfeGFDcmtsemYwN0pKaW8uQUcuaWZJbTJwRnFBWGw0VC03c3RkbV9ra3NkUDR0ajRuZmhfTjZvT3I5cWJOT0NLSDRkMml1M0lOaVphYV9GMWJiQmRWRkhBSFlGVHB5UWtWSnouY1U1MkpvLXBwUVQ3UmpZZkJqNWphUS5TbGZQMkVPbVRXSmJVa01pIiwiZXhwIjoxNjMyNDA3MzI0LCJpYXQiOjE2MzI0MDAxMjQsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.dkuAwFEjbItcS-ilUIly55ZYMW7zhpC1EaY40sqnS7g', 'https://us05web.zoom.us/j/88983776397?pwd=Mi9TUnprNllWdEt0VW9YTExhOXAxUT09', 'Rbiv3u', 30, '2021-10-08 11:05:52', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `creneaus_rvs`
--

CREATE TABLE `creneaus_rvs` (
  `id` int(11) NOT NULL,
  `libelle_t` varchar(255) DEFAULT NULL,
  `table_id` int(11) DEFAULT 0,
  `sale_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `heure_deb` varchar(255) DEFAULT NULL,
  `heure_fin` varchar(255) DEFAULT NULL,
  `date_c` date DEFAULT NULL,
  `libre` tinyint(4) DEFAULT 0,
  `ordre` int(11) DEFAULT 0,
  `lien` tinyint(4) DEFAULT 0,
  `status` tinyint(4) DEFAULT 0,
  `start_url` text DEFAULT NULL,
  `join_url` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `creneaus_rvs`
--

INSERT INTO `creneaus_rvs` (`id`, `libelle_t`, `table_id`, `sale_id`, `event_id`, `date`, `heure_deb`, `heure_fin`, `date_c`, `libre`, `ordre`, `lien`, `status`, `start_url`, `join_url`, `password`, `duration`, `created_at`, `updated_at`) VALUES
(1134, 'Table 2', 0, 1, 7, NULL, '09:00', '09:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88410550585?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODQxMDU1MDU4NSIsInN0ayI6InVpWlhoOGFZekVtb0R2akJ5TW5DR3BGY1lZUHZsakhqSllJZFdmY1VnUjguQUcuT3pxWFhWc0o0eUx2aWNPYmtuNzc3akhhLUw4Rk9XWThJa0FHYzI3UTJNT1BSc1hCQVVKS3FJYkVpeS13WTkxX1RHQjhwZlpCaGNoRE41ekQua2lKOWNObFBJeVdIUDdXN1lQRjlzQS5MTzdNdVBnMzVfWGJYYk12IiwiZXhwIjoxNjMyNDA1NzI1LCJpYXQiOjE2MzIzOTg1MjUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.DQOzVz3x_Dv2bNNN17CDEW9_EU04jW7X5KgO5uBGqT8', 'https://us05web.zoom.us/j/88410550585?pwd=Um5oZEpiaEIxZ1hUSTViZ0k5UHUydz09', '3Ezzk7', 30, '2021-10-08 11:05:52', NULL),
(1135, 'Table 2', 0, 1, 7, NULL, '10:00', '10:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/84034100501?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NDAzNDEwMDUwMSIsInN0ayI6IjRaRW1zTFA3aWxIUVBQbHhQbC1kMHZ1QncxLWt2aWdmZ2JRcENKVkxEeGsuQUcucWZ1TVl6XzViNjhBdUtYUHZoZzJlcWdmX3ZTRmlRdXo1YTBCb1U4eXRLVlE0ZjMybWduYk5DNU05UXBUVHBtQUZyemdLbzdMeXE5eTEycmsudzREdzNuZTQzVi1YRGp5bndtVW03US5CQzBTT2xOTEJveFpOU1FNIiwiZXhwIjoxNjMyNDA1NzI3LCJpYXQiOjE2MzIzOTg1MjcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.6S2SY2rHsgkC-Li4X3NhxHlZFIICFJhZ-ci3evlbk9M', 'https://us05web.zoom.us/j/84034100501?pwd=dkI2b0VFNHNwaWUwN2xXZSthOG5MZz09', 'wBST3v', 30, '2021-10-08 11:05:52', NULL),
(1136, 'Table 2', 0, 1, 7, NULL, '10:30', '10:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89980378238?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTk4MDM3ODIzOCIsInN0ayI6Ink2a1J0eWpDRHpKSE1xOEltYjhObDJfbl9sRlRuUHRjYW0xUUJjVVU3dTguQUcuSDR5SWVUaGltajRCVWFod0tqdEJtcGlfV0QzYzBLQ3lRQ2lPQnI3c1NUWmV4enF0Tl9Ra0hzTU9BWm1ZTWFOMmc5dzZMaTgyUGM4bjI2cEkudUpiM0RBUVQ4ZFMwOC1lM3Q4R3dSdy5id3BmTzFDT2U4NnkyVzNDIiwiZXhwIjoxNjMyNDA1NzI5LCJpYXQiOjE2MzIzOTg1MjksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.7qa9SA0bKEskeVfIToDm_oqXbOeTXdr0pwgqZG1AvoA', 'https://us05web.zoom.us/j/89980378238?pwd=a3NUMHJpaFdqaEIrNklVRk1QM0h1QT09', 'zvz3Ya', 30, '2021-10-08 11:05:52', NULL),
(1137, 'Table 2', 0, 1, 7, NULL, '11:00', '11:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82306596579?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjMwNjU5NjU3OSIsInN0ayI6Ikh5MDNJbVBfM2M2b1dhVWtUeS01a2ZSVWRDbHFSa3RHYUpHaEM5cHl6N1kuQUcuZTVRc3pOdUNFNklEZks3RC01eTJkam1MRHk2MHFNTnY2S1VnaXVXWWZIMVhPRjZwbENZa0s3TzdmXzRZOVRBVUdtRFhxUFJlci13UzFEdk8uNTlZdExjcXJDMmFtWXNUTVliMWNTUS5mYWFnRWY5OUdwdUN0NTMtIiwiZXhwIjoxNjMyNDA1NzMwLCJpYXQiOjE2MzIzOTg1MzAsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ._MEwdF4YqTIRzenfc84rIGrXbzwrBtZg_YBlEebsXJ8', 'https://us05web.zoom.us/j/82306596579?pwd=YXF1MlE3dzFUY0JUeHFtR05UaTlXUT09', 'hNMj9s', 30, '2021-10-08 11:05:52', NULL),
(1138, 'Table 2', 0, 1, 7, NULL, '11:30', '11:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87895705094?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4Nzg5NTcwNTA5NCIsInN0ayI6IjM1QmZJTXRORk85V2dQS1FVRkJidUQtLXlTMzhpTzhhb2ZtbmtHRzhIZnMuQUcuQWkwV3psVHRja0ZMRHpacEF0SkFpRnl4MmRnVHdDQXV6cjdyLTlRYm5sTHBpSV9kYVI2aXFhU3ZJckZUdlRYZ1lIbE9fcElSZC1oV0xjN0suNGNvRWZXQmdQcDctc3hHUEpwSVlBQS4zWUhGcW1LTU1JZWVYQjZXIiwiZXhwIjoxNjMyNDA1NzMxLCJpYXQiOjE2MzIzOTg1MzEsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.fDUs--cDQCwInj4JNHBR2D87Hkx78XajsJjjocJ7u_Y', 'https://us05web.zoom.us/j/87895705094?pwd=cmZNSXZYb1pROGd5bW43anJacTVHZz09', 'Z4jTr5', 30, '2021-10-08 11:05:52', NULL),
(1139, 'Table 2', 0, 1, 7, NULL, '12:00', '12:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87457702575?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NzQ1NzcwMjU3NSIsInN0ayI6IkFpdlJqVUFHaEpYN3RLNnJIbDhnbjk3UkNWTVBDUEFQc3FQTWFMX3lQYkkuQUcuUVVCYmpoR01kUWs1eDgyS082azVWby02QkNtMVhvbTFVX0FYbG9FOHVKWFpFZGhYYWQ4ejVEelJ6R2h1MzQyNHZ5Z2xhdHlPanJ2SHQ2bjguUDNqTV92aUNvYzFFYzMzZ1ZiY1Jkdy5XWmI4bGZkSTBJelVBUEdBIiwiZXhwIjoxNjMyNDA1NzMyLCJpYXQiOjE2MzIzOTg1MzIsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.vP_NBWeuPxbR1MuLqkz55OW7UTDcxdQs2DWZa4ZsAOg', 'https://us05web.zoom.us/j/87457702575?pwd=UldJRG92djJaOTd1L1BJY0dCVnNQZz09', 'ez8vcW', 30, '2021-10-08 11:05:52', NULL),
(1140, 'Table 2', 0, 1, 7, NULL, '12:30', '12:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/86443008625?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NjQ0MzAwODYyNSIsInN0ayI6Ikw1akxsa2ZiYmZiVFZQUEgyc2J3a3V4d0RSbDB5LUg1aXZud3BPOElzZjAuQUcuZ3JjNEVDc09Tem1kWXFZZ0FRcTNlSVZoTzlCTlN4TnFCNnNVcXVtc1puSFZ5WmVkcWxvTWdGWTI0c2tKQjcwM0o2S1RYLWl0QktDSE5vT0YuaGdjWXhEcVY1LW5EQ3FOcVBqZV8tQS53UnJIVFBpUjVJT0FoLW5oIiwiZXhwIjoxNjMyNDA1NzMzLCJpYXQiOjE2MzIzOTg1MzMsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.2wFQjLp4lys8TUDA2aulLyuxRoWZge8ws5V5NCV9B9w', 'https://us05web.zoom.us/j/86443008625?pwd=U0FSa0VOVnVUU0lwQVFTVEgxbllvQT09', 'u9PKK1', 30, '2021-10-08 11:05:52', NULL),
(1141, 'Table 2', 0, 1, 7, NULL, '13:00', '13:00', '2021-10-08', 0, 0, 0, 0, NULL, NULL, NULL, 30, '2021-10-08 11:05:52', NULL),
(1142, 'Table 2', 0, 1, 7, NULL, '14:30', '14:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/85808721837?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTgwODcyMTgzNyIsInN0ayI6ImFIanBicjlWVjA2RHBVeC1kUnJJdzMzRXNhVDB0R183V2l4cFYyNlRoN1kuQUcuY3VBWDdueFZ3ZTFFM25IQzBYVU9YN2hmbzR4eGtNaUVQZFF2cll6aW1IMU1tZG5sOGVFSDVEc1dxQnhOWFVZb09WaDBDZ1F0UlZ2TVdoYkUuWWxNSktkZ1dzaFZ2dE4tU1B2NEQ5US50WW1RaE5tU0JaNG9UbnZMIiwiZXhwIjoxNjMyNDA1NzM1LCJpYXQiOjE2MzIzOTg1MzUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.aChdMK07tCSIt7dU3lrOEQLumUb2gRiGNiZK9BWTj7c', 'https://us05web.zoom.us/j/85808721837?pwd=S2o2amV3elJTNUNVczNwTVpjTmNRUT09', 'V73tF3', 30, '2021-10-08 11:05:52', NULL),
(1143, 'Table 2', 0, 1, 7, NULL, '15:00', '15:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89701209382?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTcwMTIwOTM4MiIsInN0ayI6Ijh5dzR1QldBYnh4R2pjME11blR4ZXZGS1AzZ0JVWU5sSWZUaDNha1dFZWcuQUcuQUY5elN4NFZZeEZDdmtfbERrSG5ibjJQczMwLUhDazdidlBvYmRrd0FSYWloU244Q2pfMnI2ZHBvb1Nqd1NQc2xyN3BZTGIxSXRWT2k5TXoublNjM2Q2a2I1SlBTZVdmdjgxUXcwQS5yRjR4Y25JaExzV1FOTnlpIiwiZXhwIjoxNjMyNDA1NzM2LCJpYXQiOjE2MzIzOTg1MzYsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.BzbBIvcNJECVqxjFwUVvVd02ldJAWfyTywTzi7DRHK4', 'https://us05web.zoom.us/j/89701209382?pwd=SUI3WFpQUXJpbU8rRVJEdWYxay9iUT09', 'z6q0Fh', 30, '2021-10-08 11:05:52', NULL),
(1144, 'Table 2', 0, 1, 7, NULL, '15:30', '15:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81015640564?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTAxNTY0MDU2NCIsInN0ayI6InpGMXFVZURFWk5DbV95ZzNfMVh5VlRXTlFGeTZlZ2RWZXBRNWxaZno1eE0uQUcuMlVBeExuU0h3Qkl5N1ZlQ1cyb0FZWU8xMUFYZTlEMlc0S0RIREsxYmRLV1FRNVpydzNSSXFrUjRVS0pJallCcUhVS2x2RE5RMThvZEp1YnIuTUxKWHl0VUhJbE9zNEJMZVJnazhUdy5Pd29xcTBwNVNfeGdKVzd2IiwiZXhwIjoxNjMyNDA1NzM3LCJpYXQiOjE2MzIzOTg1MzcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.7fMaMZsTYiP_1BfhBBRyEGJ8EHM8eiESGamYpuWponM', 'https://us05web.zoom.us/j/81015640564?pwd=UnpBZ20xR1JDc0VGYnNxOEJMYVpxdz09', 'EqD2VW', 30, '2021-10-08 11:05:52', NULL),
(1145, 'Table 2', 0, 1, 7, NULL, '16:00', '16:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82691848364?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjY5MTg0ODM2NCIsInN0ayI6Im5yV3NDekFHSEgxaXZFTEcyTGlYUTl6WDZuWktURmR2WHMyY29BeERwX00uQUcuRDBJWnV0dW1GeldoWVppRGpBbVF6VXJMODdiQko5aXhDcTZaQ2RRWE15X1p1ZGNXbGR3Qzl4amVHYXRUV2N5R2dBazhrRklaeWJTQTZKa0EuUHR6RzRGaUJyMmN2bEpSSHpQdURSQS5HeHZBalo1c1h5bFdpV0t3IiwiZXhwIjoxNjMyNDA1NzM4LCJpYXQiOjE2MzIzOTg1MzgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HzEO6vFS-lvak87mrccANoREv1zMlFr55BlqWSLTrFE', 'https://us05web.zoom.us/j/82691848364?pwd=T1lvOC9MR2VGZnFESGpwWmZ2NGVhQT09', 'fB8KkU', 30, '2021-10-08 11:05:52', NULL),
(1146, 'Table 2', 0, 1, 7, NULL, '16:30', '16:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82435808992?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjQzNTgwODk5MiIsInN0ayI6IjJTeFlWcXNDYWIxY3pQT0F3NEVvdXBJb2VhX1BZNE9vRDQ0b2wwMkVEZzAuQUcuNkJGOFhIbzJLYmgtLWFaTTdad2JLTDJRNUtwTjlXdXVZVmVyalkxdTEzblY0OXN6Zzl1aVF0b1V5emtnVTBZVlNrdXJ0NHczWXkySE5POVQuU0xGMjZFaURWQ0J6MWRCYlNDcGpBdy5rVFpKdXBPalYwaDhpZkpHIiwiZXhwIjoxNjMyNDA1NzM5LCJpYXQiOjE2MzIzOTg1MzksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.nrkxaKLYqjwjQRK518mUTk1OtnBKaJk5QKx5dfdhN0g', 'https://us05web.zoom.us/j/82435808992?pwd=UlVJV2JkWEJLYnRKQnp2d1p0UFdLZz09', 'M7ArD9', 30, '2021-10-08 11:05:52', NULL),
(1147, 'Table 2', 0, 1, 7, NULL, '17:00', '17:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/85168845300?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTE2ODg0NTMwMCIsInN0ayI6IjllVFpMbUNuOVFMWTRaaHdnOWFrdUZxUnU0MlpBUEIxVUVFVVN5Zi0yQTguQUcuakJIYndsb3ZFNTlaV3g2WDNRSms5MkFlZ0NEWXVDdzFZSl84SWxyQ1ZUa2gzQjVxT2JVZDVjMy1oQjU2UURJQTRsMjFDeWF3X2xlbDJFWDQubkNTOE5rWkVwQkRCcThKNnROZGNqZy5IQ1c5WVFQR240YWlNRmxlIiwiZXhwIjoxNjMyNDA1NzQxLCJpYXQiOjE2MzIzOTg1NDEsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HW5MyYu28KYFWTuf59PLnYvj-MuV8YvyVN8V2CDIdUs', 'https://us05web.zoom.us/j/85168845300?pwd=L2xPU2Y4TTNOQUNnQlBGWlM3VGhTUT09', 'hGC5ZM', 30, '2021-10-08 11:05:52', NULL),
(1148, 'Table 2', 0, 1, 7, NULL, '17:30', '17:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88233883889?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODIzMzg4Mzg4OSIsInN0ayI6InJnRERaYVctVTk1b2p0OVd6QUlzdFRlU3Z1QmUyRkMyQ1FsRzZLRzlRSEkuQUcucm9hOGZBMFQyWXRjcVZHRWl4U3RsTnJkbGZKMWNPSVJCMU42Wnl4aFNlYnBjaEpybElYUEt4QWk1LV9YUkV0T1RUSGV6MUZhdEtoNjhxUm8uSVE4R0dSSTg1cS1YNFVoc3FFWmltZy50Y3VJYWJRalp0M2JzZVU5IiwiZXhwIjoxNjMyNDA1NzQyLCJpYXQiOjE2MzIzOTg1NDIsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.1QYLJTWPzO3cwIx_bVyqt__lSfkYTDmHa9FY4_J68vc', 'https://us05web.zoom.us/j/88233883889?pwd=OVNlSUFqSzFwVW0rSkVyRGlPMjJQdz09', 'NgT8nw', 30, '2021-10-08 11:05:52', NULL),
(1149, 'Table 3', 0, 1, 7, NULL, '09:00', '09:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89138597724?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTEzODU5NzcyNCIsInN0ayI6Imp2dFNHcDJUb0NGMzhyVFNmNTdNczJHU0FoM214TDVRUnExTlowYWV5OUUuQUcuaGZWMkQyeVktbldyYTB3MnQ3UHlOdFBBa3Rld2tGRmlfTHNPT0NDMFpLUm14eXV5MUZhMDB5OUVlbTdFMHBVclhnaFA1dDQ2Mm9ZR25FalEucTI5UmxRLUU2bExaeTVNT0NJTEgtZy41aDJmWXpZeFI3cndDQzV0IiwiZXhwIjoxNjMyNDA1NzQzLCJpYXQiOjE2MzIzOTg1NDMsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.63NOnRnTJVzwql5ZBVMi58nYWhaPwkoqD1XOzaMR9CY', 'https://us05web.zoom.us/j/89138597724?pwd=TXZJeUFxWEJuZGJQY2FpQzNmbjMvQT09', 'd6G57z', 30, '2021-10-08 11:05:52', NULL),
(1150, 'Table 3', 0, 1, 7, NULL, '10:00', '10:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81476239948?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTQ3NjIzOTk0OCIsInN0ayI6IlBULXFYdlMzWVgyQmNJczB0ZUsxTmM4cTdaMHVlR0lKOXZycGZReUJqS3MuQUcuLWVnczdTOUJObXJIenBZcG9yZVU1SmRHbGxaeFlqaWFieV8zelJiWjJQRHI5cjA2N0JPQzBiYXMxQ1RWUjhfSDBRTDBNb3dJNDBPbVV0ejkuYllYQmJmQW1lT29lWklMOXZqdUs5dy5aakxnWlluLVBKLWVtSXVDIiwiZXhwIjoxNjMyNDA1NzQ1LCJpYXQiOjE2MzIzOTg1NDUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.9pA_EkqbIjVjwpUH62COR7Z4ZpgTg5kFDeeMK1ee3rw', 'https://us05web.zoom.us/j/81476239948?pwd=dldNcDlQQXhHRGJlNGhOdy9uY1RSdz09', 'nm8Pyb', 30, '2021-10-08 11:05:52', NULL),
(1151, 'Table 3', 0, 1, 7, NULL, '10:30', '10:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/84704264647?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NDcwNDI2NDY0NyIsInN0ayI6IlRmb2U4NklDbUdnQUt2NmpDQVBBY2piZVFZcWlCTDlwc1NlVldlS2ExMWsuQUcubnJMSkt3c2RpaDVHV3Q5SExfSWo3YWVRVnFDTnpNZGJWVDNiMy1fTHpXV2RTVTRrc2drVHZ4cXRTUVpJUzI1U09aZExBd2ZnVWdtcUYyX2guLWcxeTdodVlFLV9FV0MzdVVZMkwwZy53dXo4ckN1S3RnNEMzcGFRIiwiZXhwIjoxNjMyNDA1NzQ3LCJpYXQiOjE2MzIzOTg1NDcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.8Z6bOQbmLQTkwf6UOhQUnCDxdDWHUN_bo8dYga8Ynuo', 'https://us05web.zoom.us/j/84704264647?pwd=SVB4ZzFTUlRjRlNiM3haK09KbEpzdz09', 'qv9H3y', 30, '2021-10-08 11:05:52', NULL),
(1152, 'Table 3', 0, 1, 7, NULL, '11:00', '11:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88943551740?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODk0MzU1MTc0MCIsInN0ayI6IjZFUHdXM1ZRd3ZmQmFkNEhWbEs5MmkwSEF6NENmUUxINFBnbWQxZkxCMjQuQUcubHJuVmtYNkhpRE9IS0hKVVJ6anVKbHU1VWxudGZLMU40UzgxMjdVVzJXeUlqVW42ZzRuY1Q0ajZTOUV0WmZUbXRLQjY1aFRFVGdkQ3RUN3YuOEtSaXpSOVMxRW1EN0NBNHhMVTFMQS5scGJGWm44QnhmZjUxd01SIiwiZXhwIjoxNjMyNDA1NzQ4LCJpYXQiOjE2MzIzOTg1NDgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HJqt73DLJwOu5_M9BcWqsAk2qZ6uqDrUoCzHIDv7KgQ', 'https://us05web.zoom.us/j/88943551740?pwd=TGs4TzR1MldGZlhwVEc0QUlBdGgwZz09', 'Pu8v4N', 30, '2021-10-08 11:05:52', NULL),
(1153, 'Table 3', 0, 1, 7, NULL, '11:30', '11:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89664512901?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTY2NDUxMjkwMSIsInN0ayI6InVwcFN0eXdWXzJ4SlIydXhaQnNPUEVxLXA4SUE3cmd1bkU4dHR0TUFiNkUuQUcuYlBEYjVVV1RnS29jMkZWRFRZT01VMFRXZkl0b2dRTU8wS0U5UFFJaVBLNlRBZXcwY00yVzB3TTRlV0JyZjhOUlNGcnpRLVZDTnlDSVY5OXQuQnJjTEllOHJnWGdILVhmR2tkNEliUS5YLWJFNkE0M1FldWFmUC0xIiwiZXhwIjoxNjMyNDA1NzQ5LCJpYXQiOjE2MzIzOTg1NDksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.hPGhRanbyw-cUsllN_gM52T2q88A7Mx-o3VLBCFD8yw', 'https://us05web.zoom.us/j/89664512901?pwd=NEc4UklqczNENDl1T0QvVlM4WDJBdz09', 'SmHF6H', 30, '2021-10-08 11:05:52', NULL),
(1154, 'Table 3', 0, 1, 7, NULL, '12:00', '12:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82115165250?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjExNTE2NTI1MCIsInN0ayI6Ik5XNlVhLWJ2cE8zRDRNckJJLVVaWlRZRXBuYXBWS3F0OVd4azhHUHJyZm8uQUcuRXIzaDFEZERxbmxSYVI2N19ROG9kX3VGVHJyRXNrR3JreXM1aDV6QTdoRmxBVUo1UzlsdXZCemc4SnNCM1ByREFCMVVQX0tMTWlwVy1USHIuQVRCc291SWtrQl90N3dPV2dSTkprQS4taVItZ1NLN2VZME9OSWRxIiwiZXhwIjoxNjMyNDA1NzUwLCJpYXQiOjE2MzIzOTg1NTAsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.UDrfK4H8o7MCp19Ui9MXR-FBxR1fHU-KvQbmuh0HgIQ', 'https://us05web.zoom.us/j/82115165250?pwd=bnZJR01mSGd0b0l4bC9Cai9zNEh4UT09', 'u2AMCe', 30, '2021-10-08 11:05:52', NULL),
(1155, 'Table 3', 0, 1, 7, NULL, '12:30', '12:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/86708009235?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NjcwODAwOTIzNSIsInN0ayI6InpvbHZ0ekFuV1RoWmpoV3czNmZKM1lKMHd0ODRCUzVGX2taTzFFajBHa2cuQUcuMmcwVUZqRjRfX3d4am50WHpzU001NEdVS2g4VDBMSkM5eHVjNlF1Qm85ZXFOd1doR3dfR1FaMFdLWm40UGZSczh6LTh3ZHZUR2E0c2VYY2MuX0szcFBHS2x3R2xnUXNsMU5TQ3pLQS5zcEt5aElzVEVoQlN6M3M1IiwiZXhwIjoxNjMyNDA1NzUxLCJpYXQiOjE2MzIzOTg1NTEsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.RfN9XwkIui-6-JhZ_4T5Dl7Vyv78ElMWIpZZSIYK8to', 'https://us05web.zoom.us/j/86708009235?pwd=NXZ5YlJWYVFZa0p3VUpZWHNwa0QyUT09', 'ft4uDL', 30, '2021-10-08 11:05:52', NULL),
(1156, 'Table 3', 0, 1, 7, NULL, '13:00', '13:00', '2021-10-08', 0, 0, 0, 0, NULL, NULL, NULL, 30, '2021-10-08 11:05:52', NULL),
(1157, 'Table 3', 0, 1, 7, NULL, '14:30', '14:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81019445003?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTAxOTQ0NTAwMyIsInN0ayI6ImM5b0Y1dncwakRpckRIbzFvNXZ6WlVZc090ckdURzlfVzlSM2stZ09JVkEuQUcuTmtQQ21TTkgyYTV2am9UNmoxblJZaGpCbVZ4dTNJMkVsRUo4VDFoTktyUnFOTlA5a2ZlS1dmQTV3SmVGbklRN2Y1bGhuZlF0dzhTemZfYTAuYXlGaHR0Nm56dFB4eE5abjcya2ZmQS5JanpLckFMNU9SM3BwWXExIiwiZXhwIjoxNjMyNDA1NzUzLCJpYXQiOjE2MzIzOTg1NTMsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.uWtcRGZz802gKX2UhqCUwBA47Ld2GoCaxUY8RMN0zjs', 'https://us05web.zoom.us/j/81019445003?pwd=ZFZnOFFuM1l6RHpLNVVySWZGaVRSQT09', 'PFgL41', 30, '2021-10-08 11:05:52', NULL),
(1158, 'Table 3', 0, 1, 7, NULL, '15:00', '15:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87357165002?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NzM1NzE2NTAwMiIsInN0ayI6InpmeTNPMHJTc3dyMnBiT1BjelZGcGt0Wnl0cXVfZlFVOW9tdDN4NU10bmsuQUcubE0tblhIWHNLYnRHYnd4aFJLa1FDQzVXYk1LX2NqVV91cDc4TDZKS1RsdzdxeWFpeWFocF9pRktiUjhUb1hzZGNXNlphX01XZmRud1p6Q1EuM3BZZHdOcWVyU1B0emRrbEJCaTRhZy5RQTdVMEtCcG1OTUt5dk1kIiwiZXhwIjoxNjMyNDA1NzU0LCJpYXQiOjE2MzIzOTg1NTQsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.764HliB2R4ScoMeYPt7EJ3wOzhLSz1UkhCgCvWzWRbo', 'https://us05web.zoom.us/j/87357165002?pwd=L25qbm8zeElUOTlkZWkxM1crRlVCUT09', '6e5rgE', 30, '2021-10-08 11:05:52', NULL),
(1159, 'Table 3', 0, 1, 7, NULL, '15:30', '15:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87598588621?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NzU5ODU4ODYyMSIsInN0ayI6IjlUemVvWm9KbTZoM0gyaVoxYjU5dUoxaElRdU16MHBvYjJvcFZYVVZ5c1UuQUcuUHpiWEhxaFBraHphSHpxNlg5YkdBckl6MVlncHQ0VXVDUkZvWlJwQ0V0c3JReGs5ejl6RmFVbGRLd1BFOTF6M09NWUdGSEFtTG5NbFJFSWEudWZQMjJGM21LREpfc0JPNlNzVXVyUS5lRWtvLUZ5WDU1OEZYWHRfIiwiZXhwIjoxNjMyNDA1NzU1LCJpYXQiOjE2MzIzOTg1NTUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.rGp6TVY9n5E21ZOaXMwr0DmuKZuCQE_UGXQyYdd_c88', 'https://us05web.zoom.us/j/87598588621?pwd=MTJDTUc4b3lIbjVSbEkycXN0NURFdz09', 'xpXsp4', 30, '2021-10-08 11:05:52', NULL),
(1160, 'Table 3', 0, 1, 7, NULL, '16:00', '16:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/85191541338?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTE5MTU0MTMzOCIsInN0ayI6InZZdjlKcGVBYmJsRlE5RDZ6dHdkZ25nOWhqMV9fUW9PTW5TWUhLUGRQdmsuQUcudV9VLWJqSV96bUU4NEk4NUlkT2N2M1d0a2hSR0lSbDFxbG1NamhmVDZFaFpDYVlNcXJOVTl4SjFqYmFxNGhldXJwcTRiaXVvVUkyRlMzbDgueGQxT0F3eHhaNm9TNHltZkxfOEk3Zy5nbFBqMFBaem9CLVJWdXVJIiwiZXhwIjoxNjMyNDA1NzU2LCJpYXQiOjE2MzIzOTg1NTYsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.uhjoygM-b-E21lj6kAisg5OU-sAnkF7TUSwx7yktE8o', 'https://us05web.zoom.us/j/85191541338?pwd=SEF6dVROVkZOOUM0UEJxc1BHcmFJdz09', 'b9Ffvd', 30, '2021-10-08 11:05:52', NULL),
(1161, 'Table 3', 0, 1, 7, NULL, '16:30', '16:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89404585520?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTQwNDU4NTUyMCIsInN0ayI6InFmdXB0TUZWLWxZM2d6amZ5U2VJQTlyUW1rOTZXc2NCcUNJaldoeDJUUE0uQUcuV3d6eDJNdWg2Vk9ENWg3Mk5WdDUzdnFNTnlha3l6bHMyRzg5dVJtNndFS1AyMGNPbENPTmJoeWRYbGc2WVJBSXVXZE9OdWdra0dCRkNZeGYuWnNyMkNwN1V5ZlJGekczZWlxSlEtZy5Qem5mQ1B4MmZvM3FrOVl2IiwiZXhwIjoxNjMyNDA1NzU3LCJpYXQiOjE2MzIzOTg1NTcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HcTQ5gPBlbiocjKavQtDXP2_lzoF7I5bTk7uuaPStXs', 'https://us05web.zoom.us/j/89404585520?pwd=Q3RzeG1rc0VhT21lMnp6YWthWG5zUT09', '8Hc3eU', 30, '2021-10-08 11:05:52', NULL),
(1162, 'Table 3', 0, 1, 7, NULL, '17:00', '17:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82161080679?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjE2MTA4MDY3OSIsInN0ayI6IlM4N2FjUW43MnZWQ256c0gzWWowSkJDOEstS2pwTW9acnB0TXFkdVlDNlUuQUcuMlA4TkdSY2NqeUFLVGsxTGhhOU1kMk51eC1aUlh0eWo4OW0wXzJLVWwyWGxZUnF0bllSeVJrY3FpVm1RRlo4Y29KdzJVVDU2U3dFem4zbXYuOWNiUEp5cW1VZXkzMGc3bGJCU1JKQS5qVGotM3VSTVpnYlZmOTlSIiwiZXhwIjoxNjMyNDA1NzU4LCJpYXQiOjE2MzIzOTg1NTgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.UHMVv9UFxEJmDYc5JnK7yW7c8-DBhYg7L_7OPYZxiHI', 'https://us05web.zoom.us/j/82161080679?pwd=SERZSnFiSHgrRXpJWi90Z1NXc2tpZz09', 'fi8SAi', 30, '2021-10-08 11:05:52', NULL),
(1163, 'Table 3', 0, 1, 7, NULL, '17:30', '17:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81617523944?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTYxNzUyMzk0NCIsInN0ayI6Ink3Z1NnUGwzbnI3bXZCWGRaLVRINGRTYVFKOUl2VEI2MnMydVBiYm8yM0EuQUcuY3pzODN6UlRiVGFlVDJjcjQzSEFELUkzVzBQUG9ldVEtVnhra2tocGtjMVVNQURtNEdyU1JQc0t0ZXEzTWpITVJzVFNXeG1nTkZ1MzdJMmEuVHRjNDhxUjRkTGhuYUZUQ252SEVtdy5XOGhCb0xWZDNoSU1NODNfIiwiZXhwIjoxNjMyNDA1NzYwLCJpYXQiOjE2MzIzOTg1NjAsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ._f2gtj-dQc88Hlnxs1xG3Ezc_uRrBmVZ7iCWtFtMRXM', 'https://us05web.zoom.us/j/81617523944?pwd=VXlsRVB1WkQ0WU12WWxYSFB5NGxGZz09', 'r11yBt', 30, '2021-10-08 11:05:52', NULL),
(1164, 'Table 2', 0, 1, 7, NULL, '09:00', '09:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88410550585?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODQxMDU1MDU4NSIsInN0ayI6InVpWlhoOGFZekVtb0R2akJ5TW5DR3BGY1lZUHZsakhqSllJZFdmY1VnUjguQUcuT3pxWFhWc0o0eUx2aWNPYmtuNzc3akhhLUw4Rk9XWThJa0FHYzI3UTJNT1BSc1hCQVVKS3FJYkVpeS13WTkxX1RHQjhwZlpCaGNoRE41ekQua2lKOWNObFBJeVdIUDdXN1lQRjlzQS5MTzdNdVBnMzVfWGJYYk12IiwiZXhwIjoxNjMyNDA1NzI1LCJpYXQiOjE2MzIzOTg1MjUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.DQOzVz3x_Dv2bNNN17CDEW9_EU04jW7X5KgO5uBGqT8', 'https://us05web.zoom.us/j/88410550585?pwd=Um5oZEpiaEIxZ1hUSTViZ0k5UHUydz09', '3Ezzk7', 30, '2021-10-08 11:05:52', NULL),
(1165, 'Table 2', 0, 1, 7, NULL, '10:00', '10:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/84034100501?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NDAzNDEwMDUwMSIsInN0ayI6IjRaRW1zTFA3aWxIUVBQbHhQbC1kMHZ1QncxLWt2aWdmZ2JRcENKVkxEeGsuQUcucWZ1TVl6XzViNjhBdUtYUHZoZzJlcWdmX3ZTRmlRdXo1YTBCb1U4eXRLVlE0ZjMybWduYk5DNU05UXBUVHBtQUZyemdLbzdMeXE5eTEycmsudzREdzNuZTQzVi1YRGp5bndtVW03US5CQzBTT2xOTEJveFpOU1FNIiwiZXhwIjoxNjMyNDA1NzI3LCJpYXQiOjE2MzIzOTg1MjcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.6S2SY2rHsgkC-Li4X3NhxHlZFIICFJhZ-ci3evlbk9M', 'https://us05web.zoom.us/j/84034100501?pwd=dkI2b0VFNHNwaWUwN2xXZSthOG5MZz09', 'wBST3v', 30, '2021-10-08 11:05:52', NULL),
(1166, 'Table 2', 0, 1, 7, NULL, '10:30', '10:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89980378238?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTk4MDM3ODIzOCIsInN0ayI6Ink2a1J0eWpDRHpKSE1xOEltYjhObDJfbl9sRlRuUHRjYW0xUUJjVVU3dTguQUcuSDR5SWVUaGltajRCVWFod0tqdEJtcGlfV0QzYzBLQ3lRQ2lPQnI3c1NUWmV4enF0Tl9Ra0hzTU9BWm1ZTWFOMmc5dzZMaTgyUGM4bjI2cEkudUpiM0RBUVQ4ZFMwOC1lM3Q4R3dSdy5id3BmTzFDT2U4NnkyVzNDIiwiZXhwIjoxNjMyNDA1NzI5LCJpYXQiOjE2MzIzOTg1MjksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.7qa9SA0bKEskeVfIToDm_oqXbOeTXdr0pwgqZG1AvoA', 'https://us05web.zoom.us/j/89980378238?pwd=a3NUMHJpaFdqaEIrNklVRk1QM0h1QT09', 'zvz3Ya', 30, '2021-10-08 11:05:52', NULL),
(1167, 'Table 2', 0, 1, 7, NULL, '11:00', '11:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82306596579?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjMwNjU5NjU3OSIsInN0ayI6Ikh5MDNJbVBfM2M2b1dhVWtUeS01a2ZSVWRDbHFSa3RHYUpHaEM5cHl6N1kuQUcuZTVRc3pOdUNFNklEZks3RC01eTJkam1MRHk2MHFNTnY2S1VnaXVXWWZIMVhPRjZwbENZa0s3TzdmXzRZOVRBVUdtRFhxUFJlci13UzFEdk8uNTlZdExjcXJDMmFtWXNUTVliMWNTUS5mYWFnRWY5OUdwdUN0NTMtIiwiZXhwIjoxNjMyNDA1NzMwLCJpYXQiOjE2MzIzOTg1MzAsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ._MEwdF4YqTIRzenfc84rIGrXbzwrBtZg_YBlEebsXJ8', 'https://us05web.zoom.us/j/82306596579?pwd=YXF1MlE3dzFUY0JUeHFtR05UaTlXUT09', 'hNMj9s', 30, '2021-10-08 11:05:52', NULL),
(1168, 'Table 2', 0, 1, 7, NULL, '11:30', '11:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87895705094?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4Nzg5NTcwNTA5NCIsInN0ayI6IjM1QmZJTXRORk85V2dQS1FVRkJidUQtLXlTMzhpTzhhb2ZtbmtHRzhIZnMuQUcuQWkwV3psVHRja0ZMRHpacEF0SkFpRnl4MmRnVHdDQXV6cjdyLTlRYm5sTHBpSV9kYVI2aXFhU3ZJckZUdlRYZ1lIbE9fcElSZC1oV0xjN0suNGNvRWZXQmdQcDctc3hHUEpwSVlBQS4zWUhGcW1LTU1JZWVYQjZXIiwiZXhwIjoxNjMyNDA1NzMxLCJpYXQiOjE2MzIzOTg1MzEsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.fDUs--cDQCwInj4JNHBR2D87Hkx78XajsJjjocJ7u_Y', 'https://us05web.zoom.us/j/87895705094?pwd=cmZNSXZYb1pROGd5bW43anJacTVHZz09', 'Z4jTr5', 30, '2021-10-08 11:05:52', NULL),
(1169, 'Table 2', 0, 1, 7, NULL, '12:00', '12:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87457702575?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NzQ1NzcwMjU3NSIsInN0ayI6IkFpdlJqVUFHaEpYN3RLNnJIbDhnbjk3UkNWTVBDUEFQc3FQTWFMX3lQYkkuQUcuUVVCYmpoR01kUWs1eDgyS082azVWby02QkNtMVhvbTFVX0FYbG9FOHVKWFpFZGhYYWQ4ejVEelJ6R2h1MzQyNHZ5Z2xhdHlPanJ2SHQ2bjguUDNqTV92aUNvYzFFYzMzZ1ZiY1Jkdy5XWmI4bGZkSTBJelVBUEdBIiwiZXhwIjoxNjMyNDA1NzMyLCJpYXQiOjE2MzIzOTg1MzIsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.vP_NBWeuPxbR1MuLqkz55OW7UTDcxdQs2DWZa4ZsAOg', 'https://us05web.zoom.us/j/87457702575?pwd=UldJRG92djJaOTd1L1BJY0dCVnNQZz09', 'ez8vcW', 30, '2021-10-08 11:05:52', NULL),
(1170, 'Table 2', 0, 1, 7, NULL, '12:30', '12:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/86443008625?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NjQ0MzAwODYyNSIsInN0ayI6Ikw1akxsa2ZiYmZiVFZQUEgyc2J3a3V4d0RSbDB5LUg1aXZud3BPOElzZjAuQUcuZ3JjNEVDc09Tem1kWXFZZ0FRcTNlSVZoTzlCTlN4TnFCNnNVcXVtc1puSFZ5WmVkcWxvTWdGWTI0c2tKQjcwM0o2S1RYLWl0QktDSE5vT0YuaGdjWXhEcVY1LW5EQ3FOcVBqZV8tQS53UnJIVFBpUjVJT0FoLW5oIiwiZXhwIjoxNjMyNDA1NzMzLCJpYXQiOjE2MzIzOTg1MzMsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.2wFQjLp4lys8TUDA2aulLyuxRoWZge8ws5V5NCV9B9w', 'https://us05web.zoom.us/j/86443008625?pwd=U0FSa0VOVnVUU0lwQVFTVEgxbllvQT09', 'u9PKK1', 30, '2021-10-08 11:05:52', NULL),
(1171, 'Table 2', 0, 1, 7, NULL, '13:00', '13:00', '2021-10-08', 0, 0, 0, 0, NULL, NULL, NULL, 30, '2021-10-08 11:05:52', NULL),
(1172, 'Table 2', 0, 1, 7, NULL, '14:30', '14:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/85808721837?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTgwODcyMTgzNyIsInN0ayI6ImFIanBicjlWVjA2RHBVeC1kUnJJdzMzRXNhVDB0R183V2l4cFYyNlRoN1kuQUcuY3VBWDdueFZ3ZTFFM25IQzBYVU9YN2hmbzR4eGtNaUVQZFF2cll6aW1IMU1tZG5sOGVFSDVEc1dxQnhOWFVZb09WaDBDZ1F0UlZ2TVdoYkUuWWxNSktkZ1dzaFZ2dE4tU1B2NEQ5US50WW1RaE5tU0JaNG9UbnZMIiwiZXhwIjoxNjMyNDA1NzM1LCJpYXQiOjE2MzIzOTg1MzUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.aChdMK07tCSIt7dU3lrOEQLumUb2gRiGNiZK9BWTj7c', 'https://us05web.zoom.us/j/85808721837?pwd=S2o2amV3elJTNUNVczNwTVpjTmNRUT09', 'V73tF3', 30, '2021-10-08 11:05:52', NULL),
(1173, 'Table 2', 0, 1, 7, NULL, '15:00', '15:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89701209382?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTcwMTIwOTM4MiIsInN0ayI6Ijh5dzR1QldBYnh4R2pjME11blR4ZXZGS1AzZ0JVWU5sSWZUaDNha1dFZWcuQUcuQUY5elN4NFZZeEZDdmtfbERrSG5ibjJQczMwLUhDazdidlBvYmRrd0FSYWloU244Q2pfMnI2ZHBvb1Nqd1NQc2xyN3BZTGIxSXRWT2k5TXoublNjM2Q2a2I1SlBTZVdmdjgxUXcwQS5yRjR4Y25JaExzV1FOTnlpIiwiZXhwIjoxNjMyNDA1NzM2LCJpYXQiOjE2MzIzOTg1MzYsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.BzbBIvcNJECVqxjFwUVvVd02ldJAWfyTywTzi7DRHK4', 'https://us05web.zoom.us/j/89701209382?pwd=SUI3WFpQUXJpbU8rRVJEdWYxay9iUT09', 'z6q0Fh', 30, '2021-10-08 11:05:52', NULL),
(1174, 'Table 2', 0, 1, 7, NULL, '15:30', '15:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81015640564?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTAxNTY0MDU2NCIsInN0ayI6InpGMXFVZURFWk5DbV95ZzNfMVh5VlRXTlFGeTZlZ2RWZXBRNWxaZno1eE0uQUcuMlVBeExuU0h3Qkl5N1ZlQ1cyb0FZWU8xMUFYZTlEMlc0S0RIREsxYmRLV1FRNVpydzNSSXFrUjRVS0pJallCcUhVS2x2RE5RMThvZEp1YnIuTUxKWHl0VUhJbE9zNEJMZVJnazhUdy5Pd29xcTBwNVNfeGdKVzd2IiwiZXhwIjoxNjMyNDA1NzM3LCJpYXQiOjE2MzIzOTg1MzcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.7fMaMZsTYiP_1BfhBBRyEGJ8EHM8eiESGamYpuWponM', 'https://us05web.zoom.us/j/81015640564?pwd=UnpBZ20xR1JDc0VGYnNxOEJMYVpxdz09', 'EqD2VW', 30, '2021-10-08 11:05:52', NULL),
(1175, 'Table 2', 0, 1, 7, NULL, '16:00', '16:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82691848364?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjY5MTg0ODM2NCIsInN0ayI6Im5yV3NDekFHSEgxaXZFTEcyTGlYUTl6WDZuWktURmR2WHMyY29BeERwX00uQUcuRDBJWnV0dW1GeldoWVppRGpBbVF6VXJMODdiQko5aXhDcTZaQ2RRWE15X1p1ZGNXbGR3Qzl4amVHYXRUV2N5R2dBazhrRklaeWJTQTZKa0EuUHR6RzRGaUJyMmN2bEpSSHpQdURSQS5HeHZBalo1c1h5bFdpV0t3IiwiZXhwIjoxNjMyNDA1NzM4LCJpYXQiOjE2MzIzOTg1MzgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HzEO6vFS-lvak87mrccANoREv1zMlFr55BlqWSLTrFE', 'https://us05web.zoom.us/j/82691848364?pwd=T1lvOC9MR2VGZnFESGpwWmZ2NGVhQT09', 'fB8KkU', 30, '2021-10-08 11:05:52', NULL),
(1176, 'Table 2', 0, 1, 7, NULL, '16:30', '16:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82435808992?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjQzNTgwODk5MiIsInN0ayI6IjJTeFlWcXNDYWIxY3pQT0F3NEVvdXBJb2VhX1BZNE9vRDQ0b2wwMkVEZzAuQUcuNkJGOFhIbzJLYmgtLWFaTTdad2JLTDJRNUtwTjlXdXVZVmVyalkxdTEzblY0OXN6Zzl1aVF0b1V5emtnVTBZVlNrdXJ0NHczWXkySE5POVQuU0xGMjZFaURWQ0J6MWRCYlNDcGpBdy5rVFpKdXBPalYwaDhpZkpHIiwiZXhwIjoxNjMyNDA1NzM5LCJpYXQiOjE2MzIzOTg1MzksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.nrkxaKLYqjwjQRK518mUTk1OtnBKaJk5QKx5dfdhN0g', 'https://us05web.zoom.us/j/82435808992?pwd=UlVJV2JkWEJLYnRKQnp2d1p0UFdLZz09', 'M7ArD9', 30, '2021-10-08 11:05:52', NULL),
(1177, 'Table 2', 0, 1, 7, NULL, '17:00', '17:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/85168845300?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTE2ODg0NTMwMCIsInN0ayI6IjllVFpMbUNuOVFMWTRaaHdnOWFrdUZxUnU0MlpBUEIxVUVFVVN5Zi0yQTguQUcuakJIYndsb3ZFNTlaV3g2WDNRSms5MkFlZ0NEWXVDdzFZSl84SWxyQ1ZUa2gzQjVxT2JVZDVjMy1oQjU2UURJQTRsMjFDeWF3X2xlbDJFWDQubkNTOE5rWkVwQkRCcThKNnROZGNqZy5IQ1c5WVFQR240YWlNRmxlIiwiZXhwIjoxNjMyNDA1NzQxLCJpYXQiOjE2MzIzOTg1NDEsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HW5MyYu28KYFWTuf59PLnYvj-MuV8YvyVN8V2CDIdUs', 'https://us05web.zoom.us/j/85168845300?pwd=L2xPU2Y4TTNOQUNnQlBGWlM3VGhTUT09', 'hGC5ZM', 30, '2021-10-08 11:05:52', NULL),
(1178, 'Table 2', 0, 1, 7, NULL, '17:30', '17:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88233883889?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODIzMzg4Mzg4OSIsInN0ayI6InJnRERaYVctVTk1b2p0OVd6QUlzdFRlU3Z1QmUyRkMyQ1FsRzZLRzlRSEkuQUcucm9hOGZBMFQyWXRjcVZHRWl4U3RsTnJkbGZKMWNPSVJCMU42Wnl4aFNlYnBjaEpybElYUEt4QWk1LV9YUkV0T1RUSGV6MUZhdEtoNjhxUm8uSVE4R0dSSTg1cS1YNFVoc3FFWmltZy50Y3VJYWJRalp0M2JzZVU5IiwiZXhwIjoxNjMyNDA1NzQyLCJpYXQiOjE2MzIzOTg1NDIsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.1QYLJTWPzO3cwIx_bVyqt__lSfkYTDmHa9FY4_J68vc', 'https://us05web.zoom.us/j/88233883889?pwd=OVNlSUFqSzFwVW0rSkVyRGlPMjJQdz09', 'NgT8nw', 30, '2021-10-08 11:05:52', NULL),
(1179, 'Table 3', 0, 1, 7, NULL, '09:00', '09:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89138597724?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTEzODU5NzcyNCIsInN0ayI6Imp2dFNHcDJUb0NGMzhyVFNmNTdNczJHU0FoM214TDVRUnExTlowYWV5OUUuQUcuaGZWMkQyeVktbldyYTB3MnQ3UHlOdFBBa3Rld2tGRmlfTHNPT0NDMFpLUm14eXV5MUZhMDB5OUVlbTdFMHBVclhnaFA1dDQ2Mm9ZR25FalEucTI5UmxRLUU2bExaeTVNT0NJTEgtZy41aDJmWXpZeFI3cndDQzV0IiwiZXhwIjoxNjMyNDA1NzQzLCJpYXQiOjE2MzIzOTg1NDMsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.63NOnRnTJVzwql5ZBVMi58nYWhaPwkoqD1XOzaMR9CY', 'https://us05web.zoom.us/j/89138597724?pwd=TXZJeUFxWEJuZGJQY2FpQzNmbjMvQT09', 'd6G57z', 30, '2021-10-08 11:05:52', NULL),
(1180, 'Table 3', 0, 1, 7, NULL, '10:00', '10:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81476239948?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTQ3NjIzOTk0OCIsInN0ayI6IlBULXFYdlMzWVgyQmNJczB0ZUsxTmM4cTdaMHVlR0lKOXZycGZReUJqS3MuQUcuLWVnczdTOUJObXJIenBZcG9yZVU1SmRHbGxaeFlqaWFieV8zelJiWjJQRHI5cjA2N0JPQzBiYXMxQ1RWUjhfSDBRTDBNb3dJNDBPbVV0ejkuYllYQmJmQW1lT29lWklMOXZqdUs5dy5aakxnWlluLVBKLWVtSXVDIiwiZXhwIjoxNjMyNDA1NzQ1LCJpYXQiOjE2MzIzOTg1NDUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.9pA_EkqbIjVjwpUH62COR7Z4ZpgTg5kFDeeMK1ee3rw', 'https://us05web.zoom.us/j/81476239948?pwd=dldNcDlQQXhHRGJlNGhOdy9uY1RSdz09', 'nm8Pyb', 30, '2021-10-08 11:05:52', NULL),
(1181, 'Table 3', 0, 1, 7, NULL, '10:30', '10:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/84704264647?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NDcwNDI2NDY0NyIsInN0ayI6IlRmb2U4NklDbUdnQUt2NmpDQVBBY2piZVFZcWlCTDlwc1NlVldlS2ExMWsuQUcubnJMSkt3c2RpaDVHV3Q5SExfSWo3YWVRVnFDTnpNZGJWVDNiMy1fTHpXV2RTVTRrc2drVHZ4cXRTUVpJUzI1U09aZExBd2ZnVWdtcUYyX2guLWcxeTdodVlFLV9FV0MzdVVZMkwwZy53dXo4ckN1S3RnNEMzcGFRIiwiZXhwIjoxNjMyNDA1NzQ3LCJpYXQiOjE2MzIzOTg1NDcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.8Z6bOQbmLQTkwf6UOhQUnCDxdDWHUN_bo8dYga8Ynuo', 'https://us05web.zoom.us/j/84704264647?pwd=SVB4ZzFTUlRjRlNiM3haK09KbEpzdz09', 'qv9H3y', 30, '2021-10-08 11:05:52', NULL),
(1182, 'Table 3', 0, 1, 7, NULL, '11:00', '11:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88943551740?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODk0MzU1MTc0MCIsInN0ayI6IjZFUHdXM1ZRd3ZmQmFkNEhWbEs5MmkwSEF6NENmUUxINFBnbWQxZkxCMjQuQUcubHJuVmtYNkhpRE9IS0hKVVJ6anVKbHU1VWxudGZLMU40UzgxMjdVVzJXeUlqVW42ZzRuY1Q0ajZTOUV0WmZUbXRLQjY1aFRFVGdkQ3RUN3YuOEtSaXpSOVMxRW1EN0NBNHhMVTFMQS5scGJGWm44QnhmZjUxd01SIiwiZXhwIjoxNjMyNDA1NzQ4LCJpYXQiOjE2MzIzOTg1NDgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HJqt73DLJwOu5_M9BcWqsAk2qZ6uqDrUoCzHIDv7KgQ', 'https://us05web.zoom.us/j/88943551740?pwd=TGs4TzR1MldGZlhwVEc0QUlBdGgwZz09', 'Pu8v4N', 30, '2021-10-08 11:05:52', NULL),
(1183, 'Table 3', 0, 1, 7, NULL, '11:30', '11:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89664512901?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTY2NDUxMjkwMSIsInN0ayI6InVwcFN0eXdWXzJ4SlIydXhaQnNPUEVxLXA4SUE3cmd1bkU4dHR0TUFiNkUuQUcuYlBEYjVVV1RnS29jMkZWRFRZT01VMFRXZkl0b2dRTU8wS0U5UFFJaVBLNlRBZXcwY00yVzB3TTRlV0JyZjhOUlNGcnpRLVZDTnlDSVY5OXQuQnJjTEllOHJnWGdILVhmR2tkNEliUS5YLWJFNkE0M1FldWFmUC0xIiwiZXhwIjoxNjMyNDA1NzQ5LCJpYXQiOjE2MzIzOTg1NDksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.hPGhRanbyw-cUsllN_gM52T2q88A7Mx-o3VLBCFD8yw', 'https://us05web.zoom.us/j/89664512901?pwd=NEc4UklqczNENDl1T0QvVlM4WDJBdz09', 'SmHF6H', 30, '2021-10-08 11:05:52', NULL),
(1184, 'Table 3', 0, 1, 7, NULL, '12:00', '12:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82115165250?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjExNTE2NTI1MCIsInN0ayI6Ik5XNlVhLWJ2cE8zRDRNckJJLVVaWlRZRXBuYXBWS3F0OVd4azhHUHJyZm8uQUcuRXIzaDFEZERxbmxSYVI2N19ROG9kX3VGVHJyRXNrR3JreXM1aDV6QTdoRmxBVUo1UzlsdXZCemc4SnNCM1ByREFCMVVQX0tMTWlwVy1USHIuQVRCc291SWtrQl90N3dPV2dSTkprQS4taVItZ1NLN2VZME9OSWRxIiwiZXhwIjoxNjMyNDA1NzUwLCJpYXQiOjE2MzIzOTg1NTAsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.UDrfK4H8o7MCp19Ui9MXR-FBxR1fHU-KvQbmuh0HgIQ', 'https://us05web.zoom.us/j/82115165250?pwd=bnZJR01mSGd0b0l4bC9Cai9zNEh4UT09', 'u2AMCe', 30, '2021-10-08 11:05:52', NULL),
(1185, 'Table 3', 0, 1, 7, NULL, '12:30', '12:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/86708009235?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NjcwODAwOTIzNSIsInN0ayI6InpvbHZ0ekFuV1RoWmpoV3czNmZKM1lKMHd0ODRCUzVGX2taTzFFajBHa2cuQUcuMmcwVUZqRjRfX3d4am50WHpzU001NEdVS2g4VDBMSkM5eHVjNlF1Qm85ZXFOd1doR3dfR1FaMFdLWm40UGZSczh6LTh3ZHZUR2E0c2VYY2MuX0szcFBHS2x3R2xnUXNsMU5TQ3pLQS5zcEt5aElzVEVoQlN6M3M1IiwiZXhwIjoxNjMyNDA1NzUxLCJpYXQiOjE2MzIzOTg1NTEsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.RfN9XwkIui-6-JhZ_4T5Dl7Vyv78ElMWIpZZSIYK8to', 'https://us05web.zoom.us/j/86708009235?pwd=NXZ5YlJWYVFZa0p3VUpZWHNwa0QyUT09', 'ft4uDL', 30, '2021-10-08 11:05:52', NULL),
(1186, 'Table 3', 0, 1, 7, NULL, '13:00', '13:00', '2021-10-08', 0, 0, 0, 0, NULL, NULL, NULL, 30, '2021-10-08 11:05:52', NULL),
(1187, 'Table 3', 0, 1, 7, NULL, '14:30', '14:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81019445003?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTAxOTQ0NTAwMyIsInN0ayI6ImM5b0Y1dncwakRpckRIbzFvNXZ6WlVZc090ckdURzlfVzlSM2stZ09JVkEuQUcuTmtQQ21TTkgyYTV2am9UNmoxblJZaGpCbVZ4dTNJMkVsRUo4VDFoTktyUnFOTlA5a2ZlS1dmQTV3SmVGbklRN2Y1bGhuZlF0dzhTemZfYTAuYXlGaHR0Nm56dFB4eE5abjcya2ZmQS5JanpLckFMNU9SM3BwWXExIiwiZXhwIjoxNjMyNDA1NzUzLCJpYXQiOjE2MzIzOTg1NTMsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.uWtcRGZz802gKX2UhqCUwBA47Ld2GoCaxUY8RMN0zjs', 'https://us05web.zoom.us/j/81019445003?pwd=ZFZnOFFuM1l6RHpLNVVySWZGaVRSQT09', 'PFgL41', 30, '2021-10-08 11:05:52', NULL),
(1188, 'Table 3', 0, 1, 7, NULL, '15:00', '15:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87357165002?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NzM1NzE2NTAwMiIsInN0ayI6InpmeTNPMHJTc3dyMnBiT1BjelZGcGt0Wnl0cXVfZlFVOW9tdDN4NU10bmsuQUcubE0tblhIWHNLYnRHYnd4aFJLa1FDQzVXYk1LX2NqVV91cDc4TDZKS1RsdzdxeWFpeWFocF9pRktiUjhUb1hzZGNXNlphX01XZmRud1p6Q1EuM3BZZHdOcWVyU1B0emRrbEJCaTRhZy5RQTdVMEtCcG1OTUt5dk1kIiwiZXhwIjoxNjMyNDA1NzU0LCJpYXQiOjE2MzIzOTg1NTQsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.764HliB2R4ScoMeYPt7EJ3wOzhLSz1UkhCgCvWzWRbo', 'https://us05web.zoom.us/j/87357165002?pwd=L25qbm8zeElUOTlkZWkxM1crRlVCUT09', '6e5rgE', 30, '2021-10-08 11:05:52', NULL),
(1189, 'Table 3', 0, 1, 7, NULL, '15:30', '15:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87598588621?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NzU5ODU4ODYyMSIsInN0ayI6IjlUemVvWm9KbTZoM0gyaVoxYjU5dUoxaElRdU16MHBvYjJvcFZYVVZ5c1UuQUcuUHpiWEhxaFBraHphSHpxNlg5YkdBckl6MVlncHQ0VXVDUkZvWlJwQ0V0c3JReGs5ejl6RmFVbGRLd1BFOTF6M09NWUdGSEFtTG5NbFJFSWEudWZQMjJGM21LREpfc0JPNlNzVXVyUS5lRWtvLUZ5WDU1OEZYWHRfIiwiZXhwIjoxNjMyNDA1NzU1LCJpYXQiOjE2MzIzOTg1NTUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.rGp6TVY9n5E21ZOaXMwr0DmuKZuCQE_UGXQyYdd_c88', 'https://us05web.zoom.us/j/87598588621?pwd=MTJDTUc4b3lIbjVSbEkycXN0NURFdz09', 'xpXsp4', 30, '2021-10-08 11:05:52', NULL),
(1190, 'Table 3', 0, 1, 7, NULL, '16:00', '16:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/85191541338?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTE5MTU0MTMzOCIsInN0ayI6InZZdjlKcGVBYmJsRlE5RDZ6dHdkZ25nOWhqMV9fUW9PTW5TWUhLUGRQdmsuQUcudV9VLWJqSV96bUU4NEk4NUlkT2N2M1d0a2hSR0lSbDFxbG1NamhmVDZFaFpDYVlNcXJOVTl4SjFqYmFxNGhldXJwcTRiaXVvVUkyRlMzbDgueGQxT0F3eHhaNm9TNHltZkxfOEk3Zy5nbFBqMFBaem9CLVJWdXVJIiwiZXhwIjoxNjMyNDA1NzU2LCJpYXQiOjE2MzIzOTg1NTYsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.uhjoygM-b-E21lj6kAisg5OU-sAnkF7TUSwx7yktE8o', 'https://us05web.zoom.us/j/85191541338?pwd=SEF6dVROVkZOOUM0UEJxc1BHcmFJdz09', 'b9Ffvd', 30, '2021-10-08 11:05:52', NULL),
(1191, 'Table 3', 0, 1, 7, NULL, '16:30', '16:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89404585520?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTQwNDU4NTUyMCIsInN0ayI6InFmdXB0TUZWLWxZM2d6amZ5U2VJQTlyUW1rOTZXc2NCcUNJaldoeDJUUE0uQUcuV3d6eDJNdWg2Vk9ENWg3Mk5WdDUzdnFNTnlha3l6bHMyRzg5dVJtNndFS1AyMGNPbENPTmJoeWRYbGc2WVJBSXVXZE9OdWdra0dCRkNZeGYuWnNyMkNwN1V5ZlJGekczZWlxSlEtZy5Qem5mQ1B4MmZvM3FrOVl2IiwiZXhwIjoxNjMyNDA1NzU3LCJpYXQiOjE2MzIzOTg1NTcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HcTQ5gPBlbiocjKavQtDXP2_lzoF7I5bTk7uuaPStXs', 'https://us05web.zoom.us/j/89404585520?pwd=Q3RzeG1rc0VhT21lMnp6YWthWG5zUT09', '8Hc3eU', 30, '2021-10-08 11:05:52', NULL),
(1192, 'Table 3', 0, 1, 7, NULL, '17:00', '17:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82161080679?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjE2MTA4MDY3OSIsInN0ayI6IlM4N2FjUW43MnZWQ256c0gzWWowSkJDOEstS2pwTW9acnB0TXFkdVlDNlUuQUcuMlA4TkdSY2NqeUFLVGsxTGhhOU1kMk51eC1aUlh0eWo4OW0wXzJLVWwyWGxZUnF0bllSeVJrY3FpVm1RRlo4Y29KdzJVVDU2U3dFem4zbXYuOWNiUEp5cW1VZXkzMGc3bGJCU1JKQS5qVGotM3VSTVpnYlZmOTlSIiwiZXhwIjoxNjMyNDA1NzU4LCJpYXQiOjE2MzIzOTg1NTgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.UHMVv9UFxEJmDYc5JnK7yW7c8-DBhYg7L_7OPYZxiHI', 'https://us05web.zoom.us/j/82161080679?pwd=SERZSnFiSHgrRXpJWi90Z1NXc2tpZz09', 'fi8SAi', 30, '2021-10-08 11:05:52', NULL),
(1193, 'Table 3', 0, 1, 7, NULL, '17:30', '17:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81617523944?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTYxNzUyMzk0NCIsInN0ayI6Ink3Z1NnUGwzbnI3bXZCWGRaLVRINGRTYVFKOUl2VEI2MnMydVBiYm8yM0EuQUcuY3pzODN6UlRiVGFlVDJjcjQzSEFELUkzVzBQUG9ldVEtVnhra2tocGtjMVVNQURtNEdyU1JQc0t0ZXEzTWpITVJzVFNXeG1nTkZ1MzdJMmEuVHRjNDhxUjRkTGhuYUZUQ252SEVtdy5XOGhCb0xWZDNoSU1NODNfIiwiZXhwIjoxNjMyNDA1NzYwLCJpYXQiOjE2MzIzOTg1NjAsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ._f2gtj-dQc88Hlnxs1xG3Ezc_uRrBmVZ7iCWtFtMRXM', 'https://us05web.zoom.us/j/81617523944?pwd=VXlsRVB1WkQ0WU12WWxYSFB5NGxGZz09', 'r11yBt', 30, '2021-10-08 11:05:52', NULL),
(1194, 'Table 2', 0, 1, 7, NULL, '09:00', '09:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88410550585?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODQxMDU1MDU4NSIsInN0ayI6InVpWlhoOGFZekVtb0R2akJ5TW5DR3BGY1lZUHZsakhqSllJZFdmY1VnUjguQUcuT3pxWFhWc0o0eUx2aWNPYmtuNzc3akhhLUw4Rk9XWThJa0FHYzI3UTJNT1BSc1hCQVVKS3FJYkVpeS13WTkxX1RHQjhwZlpCaGNoRE41ekQua2lKOWNObFBJeVdIUDdXN1lQRjlzQS5MTzdNdVBnMzVfWGJYYk12IiwiZXhwIjoxNjMyNDA1NzI1LCJpYXQiOjE2MzIzOTg1MjUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.DQOzVz3x_Dv2bNNN17CDEW9_EU04jW7X5KgO5uBGqT8', 'https://us05web.zoom.us/j/88410550585?pwd=Um5oZEpiaEIxZ1hUSTViZ0k5UHUydz09', '3Ezzk7', 30, '2021-10-08 11:05:52', NULL),
(1195, 'Table 2', 0, 1, 7, NULL, '10:00', '10:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/84034100501?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NDAzNDEwMDUwMSIsInN0ayI6IjRaRW1zTFA3aWxIUVBQbHhQbC1kMHZ1QncxLWt2aWdmZ2JRcENKVkxEeGsuQUcucWZ1TVl6XzViNjhBdUtYUHZoZzJlcWdmX3ZTRmlRdXo1YTBCb1U4eXRLVlE0ZjMybWduYk5DNU05UXBUVHBtQUZyemdLbzdMeXE5eTEycmsudzREdzNuZTQzVi1YRGp5bndtVW03US5CQzBTT2xOTEJveFpOU1FNIiwiZXhwIjoxNjMyNDA1NzI3LCJpYXQiOjE2MzIzOTg1MjcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.6S2SY2rHsgkC-Li4X3NhxHlZFIICFJhZ-ci3evlbk9M', 'https://us05web.zoom.us/j/84034100501?pwd=dkI2b0VFNHNwaWUwN2xXZSthOG5MZz09', 'wBST3v', 30, '2021-10-08 11:05:52', NULL);
INSERT INTO `creneaus_rvs` (`id`, `libelle_t`, `table_id`, `sale_id`, `event_id`, `date`, `heure_deb`, `heure_fin`, `date_c`, `libre`, `ordre`, `lien`, `status`, `start_url`, `join_url`, `password`, `duration`, `created_at`, `updated_at`) VALUES
(1196, 'Table 2', 0, 1, 7, NULL, '10:30', '10:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89980378238?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTk4MDM3ODIzOCIsInN0ayI6Ink2a1J0eWpDRHpKSE1xOEltYjhObDJfbl9sRlRuUHRjYW0xUUJjVVU3dTguQUcuSDR5SWVUaGltajRCVWFod0tqdEJtcGlfV0QzYzBLQ3lRQ2lPQnI3c1NUWmV4enF0Tl9Ra0hzTU9BWm1ZTWFOMmc5dzZMaTgyUGM4bjI2cEkudUpiM0RBUVQ4ZFMwOC1lM3Q4R3dSdy5id3BmTzFDT2U4NnkyVzNDIiwiZXhwIjoxNjMyNDA1NzI5LCJpYXQiOjE2MzIzOTg1MjksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.7qa9SA0bKEskeVfIToDm_oqXbOeTXdr0pwgqZG1AvoA', 'https://us05web.zoom.us/j/89980378238?pwd=a3NUMHJpaFdqaEIrNklVRk1QM0h1QT09', 'zvz3Ya', 30, '2021-10-08 11:05:52', NULL),
(1197, 'Table 2', 0, 1, 7, NULL, '11:00', '11:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82306596579?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjMwNjU5NjU3OSIsInN0ayI6Ikh5MDNJbVBfM2M2b1dhVWtUeS01a2ZSVWRDbHFSa3RHYUpHaEM5cHl6N1kuQUcuZTVRc3pOdUNFNklEZks3RC01eTJkam1MRHk2MHFNTnY2S1VnaXVXWWZIMVhPRjZwbENZa0s3TzdmXzRZOVRBVUdtRFhxUFJlci13UzFEdk8uNTlZdExjcXJDMmFtWXNUTVliMWNTUS5mYWFnRWY5OUdwdUN0NTMtIiwiZXhwIjoxNjMyNDA1NzMwLCJpYXQiOjE2MzIzOTg1MzAsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ._MEwdF4YqTIRzenfc84rIGrXbzwrBtZg_YBlEebsXJ8', 'https://us05web.zoom.us/j/82306596579?pwd=YXF1MlE3dzFUY0JUeHFtR05UaTlXUT09', 'hNMj9s', 30, '2021-10-08 11:05:52', NULL),
(1198, 'Table 2', 0, 1, 7, NULL, '11:30', '11:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87895705094?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4Nzg5NTcwNTA5NCIsInN0ayI6IjM1QmZJTXRORk85V2dQS1FVRkJidUQtLXlTMzhpTzhhb2ZtbmtHRzhIZnMuQUcuQWkwV3psVHRja0ZMRHpacEF0SkFpRnl4MmRnVHdDQXV6cjdyLTlRYm5sTHBpSV9kYVI2aXFhU3ZJckZUdlRYZ1lIbE9fcElSZC1oV0xjN0suNGNvRWZXQmdQcDctc3hHUEpwSVlBQS4zWUhGcW1LTU1JZWVYQjZXIiwiZXhwIjoxNjMyNDA1NzMxLCJpYXQiOjE2MzIzOTg1MzEsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.fDUs--cDQCwInj4JNHBR2D87Hkx78XajsJjjocJ7u_Y', 'https://us05web.zoom.us/j/87895705094?pwd=cmZNSXZYb1pROGd5bW43anJacTVHZz09', 'Z4jTr5', 30, '2021-10-08 11:05:52', NULL),
(1199, 'Table 2', 0, 1, 7, NULL, '12:00', '12:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87457702575?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NzQ1NzcwMjU3NSIsInN0ayI6IkFpdlJqVUFHaEpYN3RLNnJIbDhnbjk3UkNWTVBDUEFQc3FQTWFMX3lQYkkuQUcuUVVCYmpoR01kUWs1eDgyS082azVWby02QkNtMVhvbTFVX0FYbG9FOHVKWFpFZGhYYWQ4ejVEelJ6R2h1MzQyNHZ5Z2xhdHlPanJ2SHQ2bjguUDNqTV92aUNvYzFFYzMzZ1ZiY1Jkdy5XWmI4bGZkSTBJelVBUEdBIiwiZXhwIjoxNjMyNDA1NzMyLCJpYXQiOjE2MzIzOTg1MzIsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.vP_NBWeuPxbR1MuLqkz55OW7UTDcxdQs2DWZa4ZsAOg', 'https://us05web.zoom.us/j/87457702575?pwd=UldJRG92djJaOTd1L1BJY0dCVnNQZz09', 'ez8vcW', 30, '2021-10-08 11:05:52', NULL),
(1200, 'Table 2', 0, 1, 7, NULL, '12:30', '12:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/86443008625?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NjQ0MzAwODYyNSIsInN0ayI6Ikw1akxsa2ZiYmZiVFZQUEgyc2J3a3V4d0RSbDB5LUg1aXZud3BPOElzZjAuQUcuZ3JjNEVDc09Tem1kWXFZZ0FRcTNlSVZoTzlCTlN4TnFCNnNVcXVtc1puSFZ5WmVkcWxvTWdGWTI0c2tKQjcwM0o2S1RYLWl0QktDSE5vT0YuaGdjWXhEcVY1LW5EQ3FOcVBqZV8tQS53UnJIVFBpUjVJT0FoLW5oIiwiZXhwIjoxNjMyNDA1NzMzLCJpYXQiOjE2MzIzOTg1MzMsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.2wFQjLp4lys8TUDA2aulLyuxRoWZge8ws5V5NCV9B9w', 'https://us05web.zoom.us/j/86443008625?pwd=U0FSa0VOVnVUU0lwQVFTVEgxbllvQT09', 'u9PKK1', 30, '2021-10-08 11:05:52', NULL),
(1201, 'Table 2', 0, 1, 7, NULL, '13:00', '13:00', '2021-10-08', 0, 0, 0, 0, NULL, NULL, NULL, 30, '2021-10-08 11:05:52', NULL),
(1202, 'Table 2', 0, 1, 7, NULL, '14:30', '14:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/85808721837?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTgwODcyMTgzNyIsInN0ayI6ImFIanBicjlWVjA2RHBVeC1kUnJJdzMzRXNhVDB0R183V2l4cFYyNlRoN1kuQUcuY3VBWDdueFZ3ZTFFM25IQzBYVU9YN2hmbzR4eGtNaUVQZFF2cll6aW1IMU1tZG5sOGVFSDVEc1dxQnhOWFVZb09WaDBDZ1F0UlZ2TVdoYkUuWWxNSktkZ1dzaFZ2dE4tU1B2NEQ5US50WW1RaE5tU0JaNG9UbnZMIiwiZXhwIjoxNjMyNDA1NzM1LCJpYXQiOjE2MzIzOTg1MzUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.aChdMK07tCSIt7dU3lrOEQLumUb2gRiGNiZK9BWTj7c', 'https://us05web.zoom.us/j/85808721837?pwd=S2o2amV3elJTNUNVczNwTVpjTmNRUT09', 'V73tF3', 30, '2021-10-08 11:05:52', NULL),
(1203, 'Table 2', 0, 1, 7, NULL, '15:00', '15:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89701209382?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTcwMTIwOTM4MiIsInN0ayI6Ijh5dzR1QldBYnh4R2pjME11blR4ZXZGS1AzZ0JVWU5sSWZUaDNha1dFZWcuQUcuQUY5elN4NFZZeEZDdmtfbERrSG5ibjJQczMwLUhDazdidlBvYmRrd0FSYWloU244Q2pfMnI2ZHBvb1Nqd1NQc2xyN3BZTGIxSXRWT2k5TXoublNjM2Q2a2I1SlBTZVdmdjgxUXcwQS5yRjR4Y25JaExzV1FOTnlpIiwiZXhwIjoxNjMyNDA1NzM2LCJpYXQiOjE2MzIzOTg1MzYsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.BzbBIvcNJECVqxjFwUVvVd02ldJAWfyTywTzi7DRHK4', 'https://us05web.zoom.us/j/89701209382?pwd=SUI3WFpQUXJpbU8rRVJEdWYxay9iUT09', 'z6q0Fh', 30, '2021-10-08 11:05:52', NULL),
(1204, 'Table 2', 0, 1, 7, NULL, '15:30', '15:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81015640564?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTAxNTY0MDU2NCIsInN0ayI6InpGMXFVZURFWk5DbV95ZzNfMVh5VlRXTlFGeTZlZ2RWZXBRNWxaZno1eE0uQUcuMlVBeExuU0h3Qkl5N1ZlQ1cyb0FZWU8xMUFYZTlEMlc0S0RIREsxYmRLV1FRNVpydzNSSXFrUjRVS0pJallCcUhVS2x2RE5RMThvZEp1YnIuTUxKWHl0VUhJbE9zNEJMZVJnazhUdy5Pd29xcTBwNVNfeGdKVzd2IiwiZXhwIjoxNjMyNDA1NzM3LCJpYXQiOjE2MzIzOTg1MzcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.7fMaMZsTYiP_1BfhBBRyEGJ8EHM8eiESGamYpuWponM', 'https://us05web.zoom.us/j/81015640564?pwd=UnpBZ20xR1JDc0VGYnNxOEJMYVpxdz09', 'EqD2VW', 30, '2021-10-08 11:05:52', NULL),
(1205, 'Table 2', 0, 1, 7, NULL, '16:00', '16:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82691848364?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjY5MTg0ODM2NCIsInN0ayI6Im5yV3NDekFHSEgxaXZFTEcyTGlYUTl6WDZuWktURmR2WHMyY29BeERwX00uQUcuRDBJWnV0dW1GeldoWVppRGpBbVF6VXJMODdiQko5aXhDcTZaQ2RRWE15X1p1ZGNXbGR3Qzl4amVHYXRUV2N5R2dBazhrRklaeWJTQTZKa0EuUHR6RzRGaUJyMmN2bEpSSHpQdURSQS5HeHZBalo1c1h5bFdpV0t3IiwiZXhwIjoxNjMyNDA1NzM4LCJpYXQiOjE2MzIzOTg1MzgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HzEO6vFS-lvak87mrccANoREv1zMlFr55BlqWSLTrFE', 'https://us05web.zoom.us/j/82691848364?pwd=T1lvOC9MR2VGZnFESGpwWmZ2NGVhQT09', 'fB8KkU', 30, '2021-10-08 11:05:52', NULL),
(1206, 'Table 2', 0, 1, 7, NULL, '16:30', '16:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82435808992?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjQzNTgwODk5MiIsInN0ayI6IjJTeFlWcXNDYWIxY3pQT0F3NEVvdXBJb2VhX1BZNE9vRDQ0b2wwMkVEZzAuQUcuNkJGOFhIbzJLYmgtLWFaTTdad2JLTDJRNUtwTjlXdXVZVmVyalkxdTEzblY0OXN6Zzl1aVF0b1V5emtnVTBZVlNrdXJ0NHczWXkySE5POVQuU0xGMjZFaURWQ0J6MWRCYlNDcGpBdy5rVFpKdXBPalYwaDhpZkpHIiwiZXhwIjoxNjMyNDA1NzM5LCJpYXQiOjE2MzIzOTg1MzksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.nrkxaKLYqjwjQRK518mUTk1OtnBKaJk5QKx5dfdhN0g', 'https://us05web.zoom.us/j/82435808992?pwd=UlVJV2JkWEJLYnRKQnp2d1p0UFdLZz09', 'M7ArD9', 30, '2021-10-08 11:05:52', NULL),
(1207, 'Table 2', 0, 1, 7, NULL, '17:00', '17:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/85168845300?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTE2ODg0NTMwMCIsInN0ayI6IjllVFpMbUNuOVFMWTRaaHdnOWFrdUZxUnU0MlpBUEIxVUVFVVN5Zi0yQTguQUcuakJIYndsb3ZFNTlaV3g2WDNRSms5MkFlZ0NEWXVDdzFZSl84SWxyQ1ZUa2gzQjVxT2JVZDVjMy1oQjU2UURJQTRsMjFDeWF3X2xlbDJFWDQubkNTOE5rWkVwQkRCcThKNnROZGNqZy5IQ1c5WVFQR240YWlNRmxlIiwiZXhwIjoxNjMyNDA1NzQxLCJpYXQiOjE2MzIzOTg1NDEsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HW5MyYu28KYFWTuf59PLnYvj-MuV8YvyVN8V2CDIdUs', 'https://us05web.zoom.us/j/85168845300?pwd=L2xPU2Y4TTNOQUNnQlBGWlM3VGhTUT09', 'hGC5ZM', 30, '2021-10-08 11:05:52', NULL),
(1208, 'Table 2', 0, 1, 7, NULL, '17:30', '17:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88233883889?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODIzMzg4Mzg4OSIsInN0ayI6InJnRERaYVctVTk1b2p0OVd6QUlzdFRlU3Z1QmUyRkMyQ1FsRzZLRzlRSEkuQUcucm9hOGZBMFQyWXRjcVZHRWl4U3RsTnJkbGZKMWNPSVJCMU42Wnl4aFNlYnBjaEpybElYUEt4QWk1LV9YUkV0T1RUSGV6MUZhdEtoNjhxUm8uSVE4R0dSSTg1cS1YNFVoc3FFWmltZy50Y3VJYWJRalp0M2JzZVU5IiwiZXhwIjoxNjMyNDA1NzQyLCJpYXQiOjE2MzIzOTg1NDIsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.1QYLJTWPzO3cwIx_bVyqt__lSfkYTDmHa9FY4_J68vc', 'https://us05web.zoom.us/j/88233883889?pwd=OVNlSUFqSzFwVW0rSkVyRGlPMjJQdz09', 'NgT8nw', 30, '2021-10-08 11:05:52', NULL),
(1209, 'Table 3', 0, 1, 7, NULL, '09:00', '09:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89138597724?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTEzODU5NzcyNCIsInN0ayI6Imp2dFNHcDJUb0NGMzhyVFNmNTdNczJHU0FoM214TDVRUnExTlowYWV5OUUuQUcuaGZWMkQyeVktbldyYTB3MnQ3UHlOdFBBa3Rld2tGRmlfTHNPT0NDMFpLUm14eXV5MUZhMDB5OUVlbTdFMHBVclhnaFA1dDQ2Mm9ZR25FalEucTI5UmxRLUU2bExaeTVNT0NJTEgtZy41aDJmWXpZeFI3cndDQzV0IiwiZXhwIjoxNjMyNDA1NzQzLCJpYXQiOjE2MzIzOTg1NDMsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.63NOnRnTJVzwql5ZBVMi58nYWhaPwkoqD1XOzaMR9CY', 'https://us05web.zoom.us/j/89138597724?pwd=TXZJeUFxWEJuZGJQY2FpQzNmbjMvQT09', 'd6G57z', 30, '2021-10-08 11:05:52', NULL),
(1210, 'Table 3', 0, 1, 7, NULL, '10:00', '10:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81476239948?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTQ3NjIzOTk0OCIsInN0ayI6IlBULXFYdlMzWVgyQmNJczB0ZUsxTmM4cTdaMHVlR0lKOXZycGZReUJqS3MuQUcuLWVnczdTOUJObXJIenBZcG9yZVU1SmRHbGxaeFlqaWFieV8zelJiWjJQRHI5cjA2N0JPQzBiYXMxQ1RWUjhfSDBRTDBNb3dJNDBPbVV0ejkuYllYQmJmQW1lT29lWklMOXZqdUs5dy5aakxnWlluLVBKLWVtSXVDIiwiZXhwIjoxNjMyNDA1NzQ1LCJpYXQiOjE2MzIzOTg1NDUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.9pA_EkqbIjVjwpUH62COR7Z4ZpgTg5kFDeeMK1ee3rw', 'https://us05web.zoom.us/j/81476239948?pwd=dldNcDlQQXhHRGJlNGhOdy9uY1RSdz09', 'nm8Pyb', 30, '2021-10-08 11:05:52', NULL),
(1211, 'Table 3', 0, 1, 7, NULL, '10:30', '10:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/84704264647?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NDcwNDI2NDY0NyIsInN0ayI6IlRmb2U4NklDbUdnQUt2NmpDQVBBY2piZVFZcWlCTDlwc1NlVldlS2ExMWsuQUcubnJMSkt3c2RpaDVHV3Q5SExfSWo3YWVRVnFDTnpNZGJWVDNiMy1fTHpXV2RTVTRrc2drVHZ4cXRTUVpJUzI1U09aZExBd2ZnVWdtcUYyX2guLWcxeTdodVlFLV9FV0MzdVVZMkwwZy53dXo4ckN1S3RnNEMzcGFRIiwiZXhwIjoxNjMyNDA1NzQ3LCJpYXQiOjE2MzIzOTg1NDcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.8Z6bOQbmLQTkwf6UOhQUnCDxdDWHUN_bo8dYga8Ynuo', 'https://us05web.zoom.us/j/84704264647?pwd=SVB4ZzFTUlRjRlNiM3haK09KbEpzdz09', 'qv9H3y', 30, '2021-10-08 11:05:52', NULL),
(1212, 'Table 3', 0, 1, 7, NULL, '11:00', '11:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88943551740?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODk0MzU1MTc0MCIsInN0ayI6IjZFUHdXM1ZRd3ZmQmFkNEhWbEs5MmkwSEF6NENmUUxINFBnbWQxZkxCMjQuQUcubHJuVmtYNkhpRE9IS0hKVVJ6anVKbHU1VWxudGZLMU40UzgxMjdVVzJXeUlqVW42ZzRuY1Q0ajZTOUV0WmZUbXRLQjY1aFRFVGdkQ3RUN3YuOEtSaXpSOVMxRW1EN0NBNHhMVTFMQS5scGJGWm44QnhmZjUxd01SIiwiZXhwIjoxNjMyNDA1NzQ4LCJpYXQiOjE2MzIzOTg1NDgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HJqt73DLJwOu5_M9BcWqsAk2qZ6uqDrUoCzHIDv7KgQ', 'https://us05web.zoom.us/j/88943551740?pwd=TGs4TzR1MldGZlhwVEc0QUlBdGgwZz09', 'Pu8v4N', 30, '2021-10-08 11:05:52', NULL),
(1213, 'Table 3', 0, 1, 7, NULL, '11:30', '11:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89664512901?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTY2NDUxMjkwMSIsInN0ayI6InVwcFN0eXdWXzJ4SlIydXhaQnNPUEVxLXA4SUE3cmd1bkU4dHR0TUFiNkUuQUcuYlBEYjVVV1RnS29jMkZWRFRZT01VMFRXZkl0b2dRTU8wS0U5UFFJaVBLNlRBZXcwY00yVzB3TTRlV0JyZjhOUlNGcnpRLVZDTnlDSVY5OXQuQnJjTEllOHJnWGdILVhmR2tkNEliUS5YLWJFNkE0M1FldWFmUC0xIiwiZXhwIjoxNjMyNDA1NzQ5LCJpYXQiOjE2MzIzOTg1NDksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.hPGhRanbyw-cUsllN_gM52T2q88A7Mx-o3VLBCFD8yw', 'https://us05web.zoom.us/j/89664512901?pwd=NEc4UklqczNENDl1T0QvVlM4WDJBdz09', 'SmHF6H', 30, '2021-10-08 11:05:52', NULL),
(1214, 'Table 3', 0, 1, 7, NULL, '12:00', '12:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82115165250?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjExNTE2NTI1MCIsInN0ayI6Ik5XNlVhLWJ2cE8zRDRNckJJLVVaWlRZRXBuYXBWS3F0OVd4azhHUHJyZm8uQUcuRXIzaDFEZERxbmxSYVI2N19ROG9kX3VGVHJyRXNrR3JreXM1aDV6QTdoRmxBVUo1UzlsdXZCemc4SnNCM1ByREFCMVVQX0tMTWlwVy1USHIuQVRCc291SWtrQl90N3dPV2dSTkprQS4taVItZ1NLN2VZME9OSWRxIiwiZXhwIjoxNjMyNDA1NzUwLCJpYXQiOjE2MzIzOTg1NTAsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.UDrfK4H8o7MCp19Ui9MXR-FBxR1fHU-KvQbmuh0HgIQ', 'https://us05web.zoom.us/j/82115165250?pwd=bnZJR01mSGd0b0l4bC9Cai9zNEh4UT09', 'u2AMCe', 30, '2021-10-08 11:05:52', NULL),
(1215, 'Table 3', 0, 1, 7, NULL, '12:30', '12:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/86708009235?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NjcwODAwOTIzNSIsInN0ayI6InpvbHZ0ekFuV1RoWmpoV3czNmZKM1lKMHd0ODRCUzVGX2taTzFFajBHa2cuQUcuMmcwVUZqRjRfX3d4am50WHpzU001NEdVS2g4VDBMSkM5eHVjNlF1Qm85ZXFOd1doR3dfR1FaMFdLWm40UGZSczh6LTh3ZHZUR2E0c2VYY2MuX0szcFBHS2x3R2xnUXNsMU5TQ3pLQS5zcEt5aElzVEVoQlN6M3M1IiwiZXhwIjoxNjMyNDA1NzUxLCJpYXQiOjE2MzIzOTg1NTEsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.RfN9XwkIui-6-JhZ_4T5Dl7Vyv78ElMWIpZZSIYK8to', 'https://us05web.zoom.us/j/86708009235?pwd=NXZ5YlJWYVFZa0p3VUpZWHNwa0QyUT09', 'ft4uDL', 30, '2021-10-08 11:05:52', NULL),
(1216, 'Table 3', 0, 1, 7, NULL, '13:00', '13:00', '2021-10-08', 0, 0, 0, 0, NULL, NULL, NULL, 30, '2021-10-08 11:05:52', NULL),
(1217, 'Table 3', 0, 1, 7, NULL, '14:30', '14:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81019445003?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTAxOTQ0NTAwMyIsInN0ayI6ImM5b0Y1dncwakRpckRIbzFvNXZ6WlVZc090ckdURzlfVzlSM2stZ09JVkEuQUcuTmtQQ21TTkgyYTV2am9UNmoxblJZaGpCbVZ4dTNJMkVsRUo4VDFoTktyUnFOTlA5a2ZlS1dmQTV3SmVGbklRN2Y1bGhuZlF0dzhTemZfYTAuYXlGaHR0Nm56dFB4eE5abjcya2ZmQS5JanpLckFMNU9SM3BwWXExIiwiZXhwIjoxNjMyNDA1NzUzLCJpYXQiOjE2MzIzOTg1NTMsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.uWtcRGZz802gKX2UhqCUwBA47Ld2GoCaxUY8RMN0zjs', 'https://us05web.zoom.us/j/81019445003?pwd=ZFZnOFFuM1l6RHpLNVVySWZGaVRSQT09', 'PFgL41', 30, '2021-10-08 11:05:52', NULL),
(1218, 'Table 3', 0, 1, 7, NULL, '15:00', '15:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87357165002?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NzM1NzE2NTAwMiIsInN0ayI6InpmeTNPMHJTc3dyMnBiT1BjelZGcGt0Wnl0cXVfZlFVOW9tdDN4NU10bmsuQUcubE0tblhIWHNLYnRHYnd4aFJLa1FDQzVXYk1LX2NqVV91cDc4TDZKS1RsdzdxeWFpeWFocF9pRktiUjhUb1hzZGNXNlphX01XZmRud1p6Q1EuM3BZZHdOcWVyU1B0emRrbEJCaTRhZy5RQTdVMEtCcG1OTUt5dk1kIiwiZXhwIjoxNjMyNDA1NzU0LCJpYXQiOjE2MzIzOTg1NTQsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.764HliB2R4ScoMeYPt7EJ3wOzhLSz1UkhCgCvWzWRbo', 'https://us05web.zoom.us/j/87357165002?pwd=L25qbm8zeElUOTlkZWkxM1crRlVCUT09', '6e5rgE', 30, '2021-10-08 11:05:52', NULL),
(1219, 'Table 3', 0, 1, 7, NULL, '15:30', '15:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87598588621?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NzU5ODU4ODYyMSIsInN0ayI6IjlUemVvWm9KbTZoM0gyaVoxYjU5dUoxaElRdU16MHBvYjJvcFZYVVZ5c1UuQUcuUHpiWEhxaFBraHphSHpxNlg5YkdBckl6MVlncHQ0VXVDUkZvWlJwQ0V0c3JReGs5ejl6RmFVbGRLd1BFOTF6M09NWUdGSEFtTG5NbFJFSWEudWZQMjJGM21LREpfc0JPNlNzVXVyUS5lRWtvLUZ5WDU1OEZYWHRfIiwiZXhwIjoxNjMyNDA1NzU1LCJpYXQiOjE2MzIzOTg1NTUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.rGp6TVY9n5E21ZOaXMwr0DmuKZuCQE_UGXQyYdd_c88', 'https://us05web.zoom.us/j/87598588621?pwd=MTJDTUc4b3lIbjVSbEkycXN0NURFdz09', 'xpXsp4', 30, '2021-10-08 11:05:52', NULL),
(1220, 'Table 3', 0, 1, 7, NULL, '16:00', '16:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/85191541338?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTE5MTU0MTMzOCIsInN0ayI6InZZdjlKcGVBYmJsRlE5RDZ6dHdkZ25nOWhqMV9fUW9PTW5TWUhLUGRQdmsuQUcudV9VLWJqSV96bUU4NEk4NUlkT2N2M1d0a2hSR0lSbDFxbG1NamhmVDZFaFpDYVlNcXJOVTl4SjFqYmFxNGhldXJwcTRiaXVvVUkyRlMzbDgueGQxT0F3eHhaNm9TNHltZkxfOEk3Zy5nbFBqMFBaem9CLVJWdXVJIiwiZXhwIjoxNjMyNDA1NzU2LCJpYXQiOjE2MzIzOTg1NTYsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.uhjoygM-b-E21lj6kAisg5OU-sAnkF7TUSwx7yktE8o', 'https://us05web.zoom.us/j/85191541338?pwd=SEF6dVROVkZOOUM0UEJxc1BHcmFJdz09', 'b9Ffvd', 30, '2021-10-08 11:05:52', NULL),
(1221, 'Table 3', 0, 1, 7, NULL, '16:30', '16:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89404585520?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTQwNDU4NTUyMCIsInN0ayI6InFmdXB0TUZWLWxZM2d6amZ5U2VJQTlyUW1rOTZXc2NCcUNJaldoeDJUUE0uQUcuV3d6eDJNdWg2Vk9ENWg3Mk5WdDUzdnFNTnlha3l6bHMyRzg5dVJtNndFS1AyMGNPbENPTmJoeWRYbGc2WVJBSXVXZE9OdWdra0dCRkNZeGYuWnNyMkNwN1V5ZlJGekczZWlxSlEtZy5Qem5mQ1B4MmZvM3FrOVl2IiwiZXhwIjoxNjMyNDA1NzU3LCJpYXQiOjE2MzIzOTg1NTcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HcTQ5gPBlbiocjKavQtDXP2_lzoF7I5bTk7uuaPStXs', 'https://us05web.zoom.us/j/89404585520?pwd=Q3RzeG1rc0VhT21lMnp6YWthWG5zUT09', '8Hc3eU', 30, '2021-10-08 11:05:52', NULL),
(1222, 'Table 3', 0, 1, 7, NULL, '17:00', '17:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82161080679?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjE2MTA4MDY3OSIsInN0ayI6IlM4N2FjUW43MnZWQ256c0gzWWowSkJDOEstS2pwTW9acnB0TXFkdVlDNlUuQUcuMlA4TkdSY2NqeUFLVGsxTGhhOU1kMk51eC1aUlh0eWo4OW0wXzJLVWwyWGxZUnF0bllSeVJrY3FpVm1RRlo4Y29KdzJVVDU2U3dFem4zbXYuOWNiUEp5cW1VZXkzMGc3bGJCU1JKQS5qVGotM3VSTVpnYlZmOTlSIiwiZXhwIjoxNjMyNDA1NzU4LCJpYXQiOjE2MzIzOTg1NTgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.UHMVv9UFxEJmDYc5JnK7yW7c8-DBhYg7L_7OPYZxiHI', 'https://us05web.zoom.us/j/82161080679?pwd=SERZSnFiSHgrRXpJWi90Z1NXc2tpZz09', 'fi8SAi', 30, '2021-10-08 11:05:52', NULL),
(1223, 'Table 3', 0, 1, 7, NULL, '17:30', '17:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81617523944?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTYxNzUyMzk0NCIsInN0ayI6Ink3Z1NnUGwzbnI3bXZCWGRaLVRINGRTYVFKOUl2VEI2MnMydVBiYm8yM0EuQUcuY3pzODN6UlRiVGFlVDJjcjQzSEFELUkzVzBQUG9ldVEtVnhra2tocGtjMVVNQURtNEdyU1JQc0t0ZXEzTWpITVJzVFNXeG1nTkZ1MzdJMmEuVHRjNDhxUjRkTGhuYUZUQ252SEVtdy5XOGhCb0xWZDNoSU1NODNfIiwiZXhwIjoxNjMyNDA1NzYwLCJpYXQiOjE2MzIzOTg1NjAsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ._f2gtj-dQc88Hlnxs1xG3Ezc_uRrBmVZ7iCWtFtMRXM', 'https://us05web.zoom.us/j/81617523944?pwd=VXlsRVB1WkQ0WU12WWxYSFB5NGxGZz09', 'r11yBt', 30, '2021-10-08 11:05:52', NULL),
(1224, 'Table 2', 0, 1, 7, NULL, '09:00', '09:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88410550585?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODQxMDU1MDU4NSIsInN0ayI6InVpWlhoOGFZekVtb0R2akJ5TW5DR3BGY1lZUHZsakhqSllJZFdmY1VnUjguQUcuT3pxWFhWc0o0eUx2aWNPYmtuNzc3akhhLUw4Rk9XWThJa0FHYzI3UTJNT1BSc1hCQVVKS3FJYkVpeS13WTkxX1RHQjhwZlpCaGNoRE41ekQua2lKOWNObFBJeVdIUDdXN1lQRjlzQS5MTzdNdVBnMzVfWGJYYk12IiwiZXhwIjoxNjMyNDA1NzI1LCJpYXQiOjE2MzIzOTg1MjUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.DQOzVz3x_Dv2bNNN17CDEW9_EU04jW7X5KgO5uBGqT8', 'https://us05web.zoom.us/j/88410550585?pwd=Um5oZEpiaEIxZ1hUSTViZ0k5UHUydz09', '3Ezzk7', 30, '2021-10-08 11:05:52', NULL),
(1225, 'Table 2', 0, 1, 7, NULL, '10:00', '10:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/84034100501?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NDAzNDEwMDUwMSIsInN0ayI6IjRaRW1zTFA3aWxIUVBQbHhQbC1kMHZ1QncxLWt2aWdmZ2JRcENKVkxEeGsuQUcucWZ1TVl6XzViNjhBdUtYUHZoZzJlcWdmX3ZTRmlRdXo1YTBCb1U4eXRLVlE0ZjMybWduYk5DNU05UXBUVHBtQUZyemdLbzdMeXE5eTEycmsudzREdzNuZTQzVi1YRGp5bndtVW03US5CQzBTT2xOTEJveFpOU1FNIiwiZXhwIjoxNjMyNDA1NzI3LCJpYXQiOjE2MzIzOTg1MjcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.6S2SY2rHsgkC-Li4X3NhxHlZFIICFJhZ-ci3evlbk9M', 'https://us05web.zoom.us/j/84034100501?pwd=dkI2b0VFNHNwaWUwN2xXZSthOG5MZz09', 'wBST3v', 30, '2021-10-08 11:05:52', NULL),
(1226, 'Table 2', 0, 1, 7, NULL, '10:30', '10:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89980378238?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTk4MDM3ODIzOCIsInN0ayI6Ink2a1J0eWpDRHpKSE1xOEltYjhObDJfbl9sRlRuUHRjYW0xUUJjVVU3dTguQUcuSDR5SWVUaGltajRCVWFod0tqdEJtcGlfV0QzYzBLQ3lRQ2lPQnI3c1NUWmV4enF0Tl9Ra0hzTU9BWm1ZTWFOMmc5dzZMaTgyUGM4bjI2cEkudUpiM0RBUVQ4ZFMwOC1lM3Q4R3dSdy5id3BmTzFDT2U4NnkyVzNDIiwiZXhwIjoxNjMyNDA1NzI5LCJpYXQiOjE2MzIzOTg1MjksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.7qa9SA0bKEskeVfIToDm_oqXbOeTXdr0pwgqZG1AvoA', 'https://us05web.zoom.us/j/89980378238?pwd=a3NUMHJpaFdqaEIrNklVRk1QM0h1QT09', 'zvz3Ya', 30, '2021-10-08 11:05:52', NULL),
(1227, 'Table 2', 0, 1, 7, NULL, '11:00', '11:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82306596579?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjMwNjU5NjU3OSIsInN0ayI6Ikh5MDNJbVBfM2M2b1dhVWtUeS01a2ZSVWRDbHFSa3RHYUpHaEM5cHl6N1kuQUcuZTVRc3pOdUNFNklEZks3RC01eTJkam1MRHk2MHFNTnY2S1VnaXVXWWZIMVhPRjZwbENZa0s3TzdmXzRZOVRBVUdtRFhxUFJlci13UzFEdk8uNTlZdExjcXJDMmFtWXNUTVliMWNTUS5mYWFnRWY5OUdwdUN0NTMtIiwiZXhwIjoxNjMyNDA1NzMwLCJpYXQiOjE2MzIzOTg1MzAsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ._MEwdF4YqTIRzenfc84rIGrXbzwrBtZg_YBlEebsXJ8', 'https://us05web.zoom.us/j/82306596579?pwd=YXF1MlE3dzFUY0JUeHFtR05UaTlXUT09', 'hNMj9s', 30, '2021-10-08 11:05:52', NULL),
(1228, 'Table 2', 0, 1, 7, NULL, '11:30', '11:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87895705094?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4Nzg5NTcwNTA5NCIsInN0ayI6IjM1QmZJTXRORk85V2dQS1FVRkJidUQtLXlTMzhpTzhhb2ZtbmtHRzhIZnMuQUcuQWkwV3psVHRja0ZMRHpacEF0SkFpRnl4MmRnVHdDQXV6cjdyLTlRYm5sTHBpSV9kYVI2aXFhU3ZJckZUdlRYZ1lIbE9fcElSZC1oV0xjN0suNGNvRWZXQmdQcDctc3hHUEpwSVlBQS4zWUhGcW1LTU1JZWVYQjZXIiwiZXhwIjoxNjMyNDA1NzMxLCJpYXQiOjE2MzIzOTg1MzEsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.fDUs--cDQCwInj4JNHBR2D87Hkx78XajsJjjocJ7u_Y', 'https://us05web.zoom.us/j/87895705094?pwd=cmZNSXZYb1pROGd5bW43anJacTVHZz09', 'Z4jTr5', 30, '2021-10-08 11:05:52', NULL),
(1229, 'Table 2', 0, 1, 7, NULL, '12:00', '12:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87457702575?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NzQ1NzcwMjU3NSIsInN0ayI6IkFpdlJqVUFHaEpYN3RLNnJIbDhnbjk3UkNWTVBDUEFQc3FQTWFMX3lQYkkuQUcuUVVCYmpoR01kUWs1eDgyS082azVWby02QkNtMVhvbTFVX0FYbG9FOHVKWFpFZGhYYWQ4ejVEelJ6R2h1MzQyNHZ5Z2xhdHlPanJ2SHQ2bjguUDNqTV92aUNvYzFFYzMzZ1ZiY1Jkdy5XWmI4bGZkSTBJelVBUEdBIiwiZXhwIjoxNjMyNDA1NzMyLCJpYXQiOjE2MzIzOTg1MzIsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.vP_NBWeuPxbR1MuLqkz55OW7UTDcxdQs2DWZa4ZsAOg', 'https://us05web.zoom.us/j/87457702575?pwd=UldJRG92djJaOTd1L1BJY0dCVnNQZz09', 'ez8vcW', 30, '2021-10-08 11:05:52', NULL),
(1230, 'Table 2', 0, 1, 7, NULL, '12:30', '12:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/86443008625?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NjQ0MzAwODYyNSIsInN0ayI6Ikw1akxsa2ZiYmZiVFZQUEgyc2J3a3V4d0RSbDB5LUg1aXZud3BPOElzZjAuQUcuZ3JjNEVDc09Tem1kWXFZZ0FRcTNlSVZoTzlCTlN4TnFCNnNVcXVtc1puSFZ5WmVkcWxvTWdGWTI0c2tKQjcwM0o2S1RYLWl0QktDSE5vT0YuaGdjWXhEcVY1LW5EQ3FOcVBqZV8tQS53UnJIVFBpUjVJT0FoLW5oIiwiZXhwIjoxNjMyNDA1NzMzLCJpYXQiOjE2MzIzOTg1MzMsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.2wFQjLp4lys8TUDA2aulLyuxRoWZge8ws5V5NCV9B9w', 'https://us05web.zoom.us/j/86443008625?pwd=U0FSa0VOVnVUU0lwQVFTVEgxbllvQT09', 'u9PKK1', 30, '2021-10-08 11:05:52', NULL),
(1231, 'Table 2', 0, 1, 7, NULL, '13:00', '13:00', '2021-10-08', 0, 0, 0, 0, NULL, NULL, NULL, 30, '2021-10-08 11:05:52', NULL),
(1232, 'Table 2', 0, 1, 7, NULL, '14:30', '14:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/85808721837?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTgwODcyMTgzNyIsInN0ayI6ImFIanBicjlWVjA2RHBVeC1kUnJJdzMzRXNhVDB0R183V2l4cFYyNlRoN1kuQUcuY3VBWDdueFZ3ZTFFM25IQzBYVU9YN2hmbzR4eGtNaUVQZFF2cll6aW1IMU1tZG5sOGVFSDVEc1dxQnhOWFVZb09WaDBDZ1F0UlZ2TVdoYkUuWWxNSktkZ1dzaFZ2dE4tU1B2NEQ5US50WW1RaE5tU0JaNG9UbnZMIiwiZXhwIjoxNjMyNDA1NzM1LCJpYXQiOjE2MzIzOTg1MzUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.aChdMK07tCSIt7dU3lrOEQLumUb2gRiGNiZK9BWTj7c', 'https://us05web.zoom.us/j/85808721837?pwd=S2o2amV3elJTNUNVczNwTVpjTmNRUT09', 'V73tF3', 30, '2021-10-08 11:05:52', NULL),
(1233, 'Table 2', 0, 1, 7, NULL, '15:00', '15:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89701209382?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTcwMTIwOTM4MiIsInN0ayI6Ijh5dzR1QldBYnh4R2pjME11blR4ZXZGS1AzZ0JVWU5sSWZUaDNha1dFZWcuQUcuQUY5elN4NFZZeEZDdmtfbERrSG5ibjJQczMwLUhDazdidlBvYmRrd0FSYWloU244Q2pfMnI2ZHBvb1Nqd1NQc2xyN3BZTGIxSXRWT2k5TXoublNjM2Q2a2I1SlBTZVdmdjgxUXcwQS5yRjR4Y25JaExzV1FOTnlpIiwiZXhwIjoxNjMyNDA1NzM2LCJpYXQiOjE2MzIzOTg1MzYsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.BzbBIvcNJECVqxjFwUVvVd02ldJAWfyTywTzi7DRHK4', 'https://us05web.zoom.us/j/89701209382?pwd=SUI3WFpQUXJpbU8rRVJEdWYxay9iUT09', 'z6q0Fh', 30, '2021-10-08 11:05:52', NULL),
(1234, 'Table 2', 0, 1, 7, NULL, '15:30', '15:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81015640564?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTAxNTY0MDU2NCIsInN0ayI6InpGMXFVZURFWk5DbV95ZzNfMVh5VlRXTlFGeTZlZ2RWZXBRNWxaZno1eE0uQUcuMlVBeExuU0h3Qkl5N1ZlQ1cyb0FZWU8xMUFYZTlEMlc0S0RIREsxYmRLV1FRNVpydzNSSXFrUjRVS0pJallCcUhVS2x2RE5RMThvZEp1YnIuTUxKWHl0VUhJbE9zNEJMZVJnazhUdy5Pd29xcTBwNVNfeGdKVzd2IiwiZXhwIjoxNjMyNDA1NzM3LCJpYXQiOjE2MzIzOTg1MzcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.7fMaMZsTYiP_1BfhBBRyEGJ8EHM8eiESGamYpuWponM', 'https://us05web.zoom.us/j/81015640564?pwd=UnpBZ20xR1JDc0VGYnNxOEJMYVpxdz09', 'EqD2VW', 30, '2021-10-08 11:05:52', NULL),
(1235, 'Table 2', 0, 1, 7, NULL, '16:00', '16:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82691848364?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjY5MTg0ODM2NCIsInN0ayI6Im5yV3NDekFHSEgxaXZFTEcyTGlYUTl6WDZuWktURmR2WHMyY29BeERwX00uQUcuRDBJWnV0dW1GeldoWVppRGpBbVF6VXJMODdiQko5aXhDcTZaQ2RRWE15X1p1ZGNXbGR3Qzl4amVHYXRUV2N5R2dBazhrRklaeWJTQTZKa0EuUHR6RzRGaUJyMmN2bEpSSHpQdURSQS5HeHZBalo1c1h5bFdpV0t3IiwiZXhwIjoxNjMyNDA1NzM4LCJpYXQiOjE2MzIzOTg1MzgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HzEO6vFS-lvak87mrccANoREv1zMlFr55BlqWSLTrFE', 'https://us05web.zoom.us/j/82691848364?pwd=T1lvOC9MR2VGZnFESGpwWmZ2NGVhQT09', 'fB8KkU', 30, '2021-10-08 11:05:52', NULL),
(1236, 'Table 2', 0, 1, 7, NULL, '16:30', '16:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82435808992?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjQzNTgwODk5MiIsInN0ayI6IjJTeFlWcXNDYWIxY3pQT0F3NEVvdXBJb2VhX1BZNE9vRDQ0b2wwMkVEZzAuQUcuNkJGOFhIbzJLYmgtLWFaTTdad2JLTDJRNUtwTjlXdXVZVmVyalkxdTEzblY0OXN6Zzl1aVF0b1V5emtnVTBZVlNrdXJ0NHczWXkySE5POVQuU0xGMjZFaURWQ0J6MWRCYlNDcGpBdy5rVFpKdXBPalYwaDhpZkpHIiwiZXhwIjoxNjMyNDA1NzM5LCJpYXQiOjE2MzIzOTg1MzksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.nrkxaKLYqjwjQRK518mUTk1OtnBKaJk5QKx5dfdhN0g', 'https://us05web.zoom.us/j/82435808992?pwd=UlVJV2JkWEJLYnRKQnp2d1p0UFdLZz09', 'M7ArD9', 30, '2021-10-08 11:05:52', NULL),
(1237, 'Table 2', 0, 1, 7, NULL, '17:00', '17:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/85168845300?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTE2ODg0NTMwMCIsInN0ayI6IjllVFpMbUNuOVFMWTRaaHdnOWFrdUZxUnU0MlpBUEIxVUVFVVN5Zi0yQTguQUcuakJIYndsb3ZFNTlaV3g2WDNRSms5MkFlZ0NEWXVDdzFZSl84SWxyQ1ZUa2gzQjVxT2JVZDVjMy1oQjU2UURJQTRsMjFDeWF3X2xlbDJFWDQubkNTOE5rWkVwQkRCcThKNnROZGNqZy5IQ1c5WVFQR240YWlNRmxlIiwiZXhwIjoxNjMyNDA1NzQxLCJpYXQiOjE2MzIzOTg1NDEsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HW5MyYu28KYFWTuf59PLnYvj-MuV8YvyVN8V2CDIdUs', 'https://us05web.zoom.us/j/85168845300?pwd=L2xPU2Y4TTNOQUNnQlBGWlM3VGhTUT09', 'hGC5ZM', 30, '2021-10-08 11:05:52', NULL),
(1238, 'Table 2', 0, 1, 7, NULL, '17:30', '17:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88233883889?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODIzMzg4Mzg4OSIsInN0ayI6InJnRERaYVctVTk1b2p0OVd6QUlzdFRlU3Z1QmUyRkMyQ1FsRzZLRzlRSEkuQUcucm9hOGZBMFQyWXRjcVZHRWl4U3RsTnJkbGZKMWNPSVJCMU42Wnl4aFNlYnBjaEpybElYUEt4QWk1LV9YUkV0T1RUSGV6MUZhdEtoNjhxUm8uSVE4R0dSSTg1cS1YNFVoc3FFWmltZy50Y3VJYWJRalp0M2JzZVU5IiwiZXhwIjoxNjMyNDA1NzQyLCJpYXQiOjE2MzIzOTg1NDIsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.1QYLJTWPzO3cwIx_bVyqt__lSfkYTDmHa9FY4_J68vc', 'https://us05web.zoom.us/j/88233883889?pwd=OVNlSUFqSzFwVW0rSkVyRGlPMjJQdz09', 'NgT8nw', 30, '2021-10-08 11:05:52', NULL),
(1239, 'Table 3', 0, 1, 7, NULL, '09:00', '09:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89138597724?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTEzODU5NzcyNCIsInN0ayI6Imp2dFNHcDJUb0NGMzhyVFNmNTdNczJHU0FoM214TDVRUnExTlowYWV5OUUuQUcuaGZWMkQyeVktbldyYTB3MnQ3UHlOdFBBa3Rld2tGRmlfTHNPT0NDMFpLUm14eXV5MUZhMDB5OUVlbTdFMHBVclhnaFA1dDQ2Mm9ZR25FalEucTI5UmxRLUU2bExaeTVNT0NJTEgtZy41aDJmWXpZeFI3cndDQzV0IiwiZXhwIjoxNjMyNDA1NzQzLCJpYXQiOjE2MzIzOTg1NDMsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.63NOnRnTJVzwql5ZBVMi58nYWhaPwkoqD1XOzaMR9CY', 'https://us05web.zoom.us/j/89138597724?pwd=TXZJeUFxWEJuZGJQY2FpQzNmbjMvQT09', 'd6G57z', 30, '2021-10-08 11:05:52', NULL),
(1240, 'Table 3', 0, 1, 7, NULL, '10:00', '10:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81476239948?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTQ3NjIzOTk0OCIsInN0ayI6IlBULXFYdlMzWVgyQmNJczB0ZUsxTmM4cTdaMHVlR0lKOXZycGZReUJqS3MuQUcuLWVnczdTOUJObXJIenBZcG9yZVU1SmRHbGxaeFlqaWFieV8zelJiWjJQRHI5cjA2N0JPQzBiYXMxQ1RWUjhfSDBRTDBNb3dJNDBPbVV0ejkuYllYQmJmQW1lT29lWklMOXZqdUs5dy5aakxnWlluLVBKLWVtSXVDIiwiZXhwIjoxNjMyNDA1NzQ1LCJpYXQiOjE2MzIzOTg1NDUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.9pA_EkqbIjVjwpUH62COR7Z4ZpgTg5kFDeeMK1ee3rw', 'https://us05web.zoom.us/j/81476239948?pwd=dldNcDlQQXhHRGJlNGhOdy9uY1RSdz09', 'nm8Pyb', 30, '2021-10-08 11:05:52', NULL),
(1241, 'Table 3', 0, 1, 7, NULL, '10:30', '10:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/84704264647?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NDcwNDI2NDY0NyIsInN0ayI6IlRmb2U4NklDbUdnQUt2NmpDQVBBY2piZVFZcWlCTDlwc1NlVldlS2ExMWsuQUcubnJMSkt3c2RpaDVHV3Q5SExfSWo3YWVRVnFDTnpNZGJWVDNiMy1fTHpXV2RTVTRrc2drVHZ4cXRTUVpJUzI1U09aZExBd2ZnVWdtcUYyX2guLWcxeTdodVlFLV9FV0MzdVVZMkwwZy53dXo4ckN1S3RnNEMzcGFRIiwiZXhwIjoxNjMyNDA1NzQ3LCJpYXQiOjE2MzIzOTg1NDcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.8Z6bOQbmLQTkwf6UOhQUnCDxdDWHUN_bo8dYga8Ynuo', 'https://us05web.zoom.us/j/84704264647?pwd=SVB4ZzFTUlRjRlNiM3haK09KbEpzdz09', 'qv9H3y', 30, '2021-10-08 11:05:52', NULL),
(1242, 'Table 3', 0, 1, 7, NULL, '11:00', '11:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88943551740?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODk0MzU1MTc0MCIsInN0ayI6IjZFUHdXM1ZRd3ZmQmFkNEhWbEs5MmkwSEF6NENmUUxINFBnbWQxZkxCMjQuQUcubHJuVmtYNkhpRE9IS0hKVVJ6anVKbHU1VWxudGZLMU40UzgxMjdVVzJXeUlqVW42ZzRuY1Q0ajZTOUV0WmZUbXRLQjY1aFRFVGdkQ3RUN3YuOEtSaXpSOVMxRW1EN0NBNHhMVTFMQS5scGJGWm44QnhmZjUxd01SIiwiZXhwIjoxNjMyNDA1NzQ4LCJpYXQiOjE2MzIzOTg1NDgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HJqt73DLJwOu5_M9BcWqsAk2qZ6uqDrUoCzHIDv7KgQ', 'https://us05web.zoom.us/j/88943551740?pwd=TGs4TzR1MldGZlhwVEc0QUlBdGgwZz09', 'Pu8v4N', 30, '2021-10-08 11:05:52', NULL),
(1243, 'Table 3', 0, 1, 7, NULL, '11:30', '11:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89664512901?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTY2NDUxMjkwMSIsInN0ayI6InVwcFN0eXdWXzJ4SlIydXhaQnNPUEVxLXA4SUE3cmd1bkU4dHR0TUFiNkUuQUcuYlBEYjVVV1RnS29jMkZWRFRZT01VMFRXZkl0b2dRTU8wS0U5UFFJaVBLNlRBZXcwY00yVzB3TTRlV0JyZjhOUlNGcnpRLVZDTnlDSVY5OXQuQnJjTEllOHJnWGdILVhmR2tkNEliUS5YLWJFNkE0M1FldWFmUC0xIiwiZXhwIjoxNjMyNDA1NzQ5LCJpYXQiOjE2MzIzOTg1NDksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.hPGhRanbyw-cUsllN_gM52T2q88A7Mx-o3VLBCFD8yw', 'https://us05web.zoom.us/j/89664512901?pwd=NEc4UklqczNENDl1T0QvVlM4WDJBdz09', 'SmHF6H', 30, '2021-10-08 11:05:52', NULL),
(1244, 'Table 3', 0, 1, 7, NULL, '12:00', '12:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82115165250?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjExNTE2NTI1MCIsInN0ayI6Ik5XNlVhLWJ2cE8zRDRNckJJLVVaWlRZRXBuYXBWS3F0OVd4azhHUHJyZm8uQUcuRXIzaDFEZERxbmxSYVI2N19ROG9kX3VGVHJyRXNrR3JreXM1aDV6QTdoRmxBVUo1UzlsdXZCemc4SnNCM1ByREFCMVVQX0tMTWlwVy1USHIuQVRCc291SWtrQl90N3dPV2dSTkprQS4taVItZ1NLN2VZME9OSWRxIiwiZXhwIjoxNjMyNDA1NzUwLCJpYXQiOjE2MzIzOTg1NTAsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.UDrfK4H8o7MCp19Ui9MXR-FBxR1fHU-KvQbmuh0HgIQ', 'https://us05web.zoom.us/j/82115165250?pwd=bnZJR01mSGd0b0l4bC9Cai9zNEh4UT09', 'u2AMCe', 30, '2021-10-08 11:05:52', NULL),
(1245, 'Table 3', 0, 1, 7, NULL, '12:30', '12:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/86708009235?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NjcwODAwOTIzNSIsInN0ayI6InpvbHZ0ekFuV1RoWmpoV3czNmZKM1lKMHd0ODRCUzVGX2taTzFFajBHa2cuQUcuMmcwVUZqRjRfX3d4am50WHpzU001NEdVS2g4VDBMSkM5eHVjNlF1Qm85ZXFOd1doR3dfR1FaMFdLWm40UGZSczh6LTh3ZHZUR2E0c2VYY2MuX0szcFBHS2x3R2xnUXNsMU5TQ3pLQS5zcEt5aElzVEVoQlN6M3M1IiwiZXhwIjoxNjMyNDA1NzUxLCJpYXQiOjE2MzIzOTg1NTEsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.RfN9XwkIui-6-JhZ_4T5Dl7Vyv78ElMWIpZZSIYK8to', 'https://us05web.zoom.us/j/86708009235?pwd=NXZ5YlJWYVFZa0p3VUpZWHNwa0QyUT09', 'ft4uDL', 30, '2021-10-08 11:05:52', NULL),
(1246, 'Table 3', 0, 1, 7, NULL, '13:00', '13:00', '2021-10-08', 0, 0, 0, 0, NULL, NULL, NULL, 30, '2021-10-08 11:05:52', NULL),
(1247, 'Table 3', 0, 1, 7, NULL, '14:30', '14:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81019445003?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTAxOTQ0NTAwMyIsInN0ayI6ImM5b0Y1dncwakRpckRIbzFvNXZ6WlVZc090ckdURzlfVzlSM2stZ09JVkEuQUcuTmtQQ21TTkgyYTV2am9UNmoxblJZaGpCbVZ4dTNJMkVsRUo4VDFoTktyUnFOTlA5a2ZlS1dmQTV3SmVGbklRN2Y1bGhuZlF0dzhTemZfYTAuYXlGaHR0Nm56dFB4eE5abjcya2ZmQS5JanpLckFMNU9SM3BwWXExIiwiZXhwIjoxNjMyNDA1NzUzLCJpYXQiOjE2MzIzOTg1NTMsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.uWtcRGZz802gKX2UhqCUwBA47Ld2GoCaxUY8RMN0zjs', 'https://us05web.zoom.us/j/81019445003?pwd=ZFZnOFFuM1l6RHpLNVVySWZGaVRSQT09', 'PFgL41', 30, '2021-10-08 11:05:52', NULL),
(1248, 'Table 3', 0, 1, 7, NULL, '15:00', '15:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87357165002?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NzM1NzE2NTAwMiIsInN0ayI6InpmeTNPMHJTc3dyMnBiT1BjelZGcGt0Wnl0cXVfZlFVOW9tdDN4NU10bmsuQUcubE0tblhIWHNLYnRHYnd4aFJLa1FDQzVXYk1LX2NqVV91cDc4TDZKS1RsdzdxeWFpeWFocF9pRktiUjhUb1hzZGNXNlphX01XZmRud1p6Q1EuM3BZZHdOcWVyU1B0emRrbEJCaTRhZy5RQTdVMEtCcG1OTUt5dk1kIiwiZXhwIjoxNjMyNDA1NzU0LCJpYXQiOjE2MzIzOTg1NTQsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.764HliB2R4ScoMeYPt7EJ3wOzhLSz1UkhCgCvWzWRbo', 'https://us05web.zoom.us/j/87357165002?pwd=L25qbm8zeElUOTlkZWkxM1crRlVCUT09', '6e5rgE', 30, '2021-10-08 11:05:52', NULL),
(1249, 'Table 3', 0, 1, 7, NULL, '15:30', '15:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87598588621?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NzU5ODU4ODYyMSIsInN0ayI6IjlUemVvWm9KbTZoM0gyaVoxYjU5dUoxaElRdU16MHBvYjJvcFZYVVZ5c1UuQUcuUHpiWEhxaFBraHphSHpxNlg5YkdBckl6MVlncHQ0VXVDUkZvWlJwQ0V0c3JReGs5ejl6RmFVbGRLd1BFOTF6M09NWUdGSEFtTG5NbFJFSWEudWZQMjJGM21LREpfc0JPNlNzVXVyUS5lRWtvLUZ5WDU1OEZYWHRfIiwiZXhwIjoxNjMyNDA1NzU1LCJpYXQiOjE2MzIzOTg1NTUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.rGp6TVY9n5E21ZOaXMwr0DmuKZuCQE_UGXQyYdd_c88', 'https://us05web.zoom.us/j/87598588621?pwd=MTJDTUc4b3lIbjVSbEkycXN0NURFdz09', 'xpXsp4', 30, '2021-10-08 11:05:52', NULL),
(1250, 'Table 3', 0, 1, 7, NULL, '16:00', '16:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/85191541338?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTE5MTU0MTMzOCIsInN0ayI6InZZdjlKcGVBYmJsRlE5RDZ6dHdkZ25nOWhqMV9fUW9PTW5TWUhLUGRQdmsuQUcudV9VLWJqSV96bUU4NEk4NUlkT2N2M1d0a2hSR0lSbDFxbG1NamhmVDZFaFpDYVlNcXJOVTl4SjFqYmFxNGhldXJwcTRiaXVvVUkyRlMzbDgueGQxT0F3eHhaNm9TNHltZkxfOEk3Zy5nbFBqMFBaem9CLVJWdXVJIiwiZXhwIjoxNjMyNDA1NzU2LCJpYXQiOjE2MzIzOTg1NTYsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.uhjoygM-b-E21lj6kAisg5OU-sAnkF7TUSwx7yktE8o', 'https://us05web.zoom.us/j/85191541338?pwd=SEF6dVROVkZOOUM0UEJxc1BHcmFJdz09', 'b9Ffvd', 30, '2021-10-08 11:05:52', NULL),
(1251, 'Table 3', 0, 1, 7, NULL, '16:30', '16:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89404585520?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTQwNDU4NTUyMCIsInN0ayI6InFmdXB0TUZWLWxZM2d6amZ5U2VJQTlyUW1rOTZXc2NCcUNJaldoeDJUUE0uQUcuV3d6eDJNdWg2Vk9ENWg3Mk5WdDUzdnFNTnlha3l6bHMyRzg5dVJtNndFS1AyMGNPbENPTmJoeWRYbGc2WVJBSXVXZE9OdWdra0dCRkNZeGYuWnNyMkNwN1V5ZlJGekczZWlxSlEtZy5Qem5mQ1B4MmZvM3FrOVl2IiwiZXhwIjoxNjMyNDA1NzU3LCJpYXQiOjE2MzIzOTg1NTcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HcTQ5gPBlbiocjKavQtDXP2_lzoF7I5bTk7uuaPStXs', 'https://us05web.zoom.us/j/89404585520?pwd=Q3RzeG1rc0VhT21lMnp6YWthWG5zUT09', '8Hc3eU', 30, '2021-10-08 11:05:52', NULL),
(1252, 'Table 3', 0, 1, 7, NULL, '17:00', '17:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82161080679?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjE2MTA4MDY3OSIsInN0ayI6IlM4N2FjUW43MnZWQ256c0gzWWowSkJDOEstS2pwTW9acnB0TXFkdVlDNlUuQUcuMlA4TkdSY2NqeUFLVGsxTGhhOU1kMk51eC1aUlh0eWo4OW0wXzJLVWwyWGxZUnF0bllSeVJrY3FpVm1RRlo4Y29KdzJVVDU2U3dFem4zbXYuOWNiUEp5cW1VZXkzMGc3bGJCU1JKQS5qVGotM3VSTVpnYlZmOTlSIiwiZXhwIjoxNjMyNDA1NzU4LCJpYXQiOjE2MzIzOTg1NTgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.UHMVv9UFxEJmDYc5JnK7yW7c8-DBhYg7L_7OPYZxiHI', 'https://us05web.zoom.us/j/82161080679?pwd=SERZSnFiSHgrRXpJWi90Z1NXc2tpZz09', 'fi8SAi', 30, '2021-10-08 11:05:52', NULL),
(1253, 'Table 3', 0, 1, 7, NULL, '17:30', '17:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81617523944?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTYxNzUyMzk0NCIsInN0ayI6Ink3Z1NnUGwzbnI3bXZCWGRaLVRINGRTYVFKOUl2VEI2MnMydVBiYm8yM0EuQUcuY3pzODN6UlRiVGFlVDJjcjQzSEFELUkzVzBQUG9ldVEtVnhra2tocGtjMVVNQURtNEdyU1JQc0t0ZXEzTWpITVJzVFNXeG1nTkZ1MzdJMmEuVHRjNDhxUjRkTGhuYUZUQ252SEVtdy5XOGhCb0xWZDNoSU1NODNfIiwiZXhwIjoxNjMyNDA1NzYwLCJpYXQiOjE2MzIzOTg1NjAsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ._f2gtj-dQc88Hlnxs1xG3Ezc_uRrBmVZ7iCWtFtMRXM', 'https://us05web.zoom.us/j/81617523944?pwd=VXlsRVB1WkQ0WU12WWxYSFB5NGxGZz09', 'r11yBt', 30, '2021-10-08 11:05:52', NULL),
(1254, 'Table 2', 0, 1, 7, NULL, '09:00', '09:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88410550585?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODQxMDU1MDU4NSIsInN0ayI6InVpWlhoOGFZekVtb0R2akJ5TW5DR3BGY1lZUHZsakhqSllJZFdmY1VnUjguQUcuT3pxWFhWc0o0eUx2aWNPYmtuNzc3akhhLUw4Rk9XWThJa0FHYzI3UTJNT1BSc1hCQVVKS3FJYkVpeS13WTkxX1RHQjhwZlpCaGNoRE41ekQua2lKOWNObFBJeVdIUDdXN1lQRjlzQS5MTzdNdVBnMzVfWGJYYk12IiwiZXhwIjoxNjMyNDA1NzI1LCJpYXQiOjE2MzIzOTg1MjUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.DQOzVz3x_Dv2bNNN17CDEW9_EU04jW7X5KgO5uBGqT8', 'https://us05web.zoom.us/j/88410550585?pwd=Um5oZEpiaEIxZ1hUSTViZ0k5UHUydz09', '3Ezzk7', 30, '2021-10-08 11:05:52', NULL),
(1255, 'Table 2', 0, 1, 7, NULL, '10:00', '10:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/84034100501?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NDAzNDEwMDUwMSIsInN0ayI6IjRaRW1zTFA3aWxIUVBQbHhQbC1kMHZ1QncxLWt2aWdmZ2JRcENKVkxEeGsuQUcucWZ1TVl6XzViNjhBdUtYUHZoZzJlcWdmX3ZTRmlRdXo1YTBCb1U4eXRLVlE0ZjMybWduYk5DNU05UXBUVHBtQUZyemdLbzdMeXE5eTEycmsudzREdzNuZTQzVi1YRGp5bndtVW03US5CQzBTT2xOTEJveFpOU1FNIiwiZXhwIjoxNjMyNDA1NzI3LCJpYXQiOjE2MzIzOTg1MjcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.6S2SY2rHsgkC-Li4X3NhxHlZFIICFJhZ-ci3evlbk9M', 'https://us05web.zoom.us/j/84034100501?pwd=dkI2b0VFNHNwaWUwN2xXZSthOG5MZz09', 'wBST3v', 30, '2021-10-08 11:05:52', NULL),
(1256, 'Table 2', 0, 1, 7, NULL, '10:30', '10:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89980378238?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTk4MDM3ODIzOCIsInN0ayI6Ink2a1J0eWpDRHpKSE1xOEltYjhObDJfbl9sRlRuUHRjYW0xUUJjVVU3dTguQUcuSDR5SWVUaGltajRCVWFod0tqdEJtcGlfV0QzYzBLQ3lRQ2lPQnI3c1NUWmV4enF0Tl9Ra0hzTU9BWm1ZTWFOMmc5dzZMaTgyUGM4bjI2cEkudUpiM0RBUVQ4ZFMwOC1lM3Q4R3dSdy5id3BmTzFDT2U4NnkyVzNDIiwiZXhwIjoxNjMyNDA1NzI5LCJpYXQiOjE2MzIzOTg1MjksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.7qa9SA0bKEskeVfIToDm_oqXbOeTXdr0pwgqZG1AvoA', 'https://us05web.zoom.us/j/89980378238?pwd=a3NUMHJpaFdqaEIrNklVRk1QM0h1QT09', 'zvz3Ya', 30, '2021-10-08 11:05:52', NULL),
(1257, 'Table 2', 0, 1, 7, NULL, '11:00', '11:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82306596579?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjMwNjU5NjU3OSIsInN0ayI6Ikh5MDNJbVBfM2M2b1dhVWtUeS01a2ZSVWRDbHFSa3RHYUpHaEM5cHl6N1kuQUcuZTVRc3pOdUNFNklEZks3RC01eTJkam1MRHk2MHFNTnY2S1VnaXVXWWZIMVhPRjZwbENZa0s3TzdmXzRZOVRBVUdtRFhxUFJlci13UzFEdk8uNTlZdExjcXJDMmFtWXNUTVliMWNTUS5mYWFnRWY5OUdwdUN0NTMtIiwiZXhwIjoxNjMyNDA1NzMwLCJpYXQiOjE2MzIzOTg1MzAsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ._MEwdF4YqTIRzenfc84rIGrXbzwrBtZg_YBlEebsXJ8', 'https://us05web.zoom.us/j/82306596579?pwd=YXF1MlE3dzFUY0JUeHFtR05UaTlXUT09', 'hNMj9s', 30, '2021-10-08 11:05:52', NULL);
INSERT INTO `creneaus_rvs` (`id`, `libelle_t`, `table_id`, `sale_id`, `event_id`, `date`, `heure_deb`, `heure_fin`, `date_c`, `libre`, `ordre`, `lien`, `status`, `start_url`, `join_url`, `password`, `duration`, `created_at`, `updated_at`) VALUES
(1258, 'Table 2', 0, 1, 7, NULL, '11:30', '11:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87895705094?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4Nzg5NTcwNTA5NCIsInN0ayI6IjM1QmZJTXRORk85V2dQS1FVRkJidUQtLXlTMzhpTzhhb2ZtbmtHRzhIZnMuQUcuQWkwV3psVHRja0ZMRHpacEF0SkFpRnl4MmRnVHdDQXV6cjdyLTlRYm5sTHBpSV9kYVI2aXFhU3ZJckZUdlRYZ1lIbE9fcElSZC1oV0xjN0suNGNvRWZXQmdQcDctc3hHUEpwSVlBQS4zWUhGcW1LTU1JZWVYQjZXIiwiZXhwIjoxNjMyNDA1NzMxLCJpYXQiOjE2MzIzOTg1MzEsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.fDUs--cDQCwInj4JNHBR2D87Hkx78XajsJjjocJ7u_Y', 'https://us05web.zoom.us/j/87895705094?pwd=cmZNSXZYb1pROGd5bW43anJacTVHZz09', 'Z4jTr5', 30, '2021-10-08 11:05:52', NULL),
(1259, 'Table 2', 0, 1, 7, NULL, '12:00', '12:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87457702575?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NzQ1NzcwMjU3NSIsInN0ayI6IkFpdlJqVUFHaEpYN3RLNnJIbDhnbjk3UkNWTVBDUEFQc3FQTWFMX3lQYkkuQUcuUVVCYmpoR01kUWs1eDgyS082azVWby02QkNtMVhvbTFVX0FYbG9FOHVKWFpFZGhYYWQ4ejVEelJ6R2h1MzQyNHZ5Z2xhdHlPanJ2SHQ2bjguUDNqTV92aUNvYzFFYzMzZ1ZiY1Jkdy5XWmI4bGZkSTBJelVBUEdBIiwiZXhwIjoxNjMyNDA1NzMyLCJpYXQiOjE2MzIzOTg1MzIsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.vP_NBWeuPxbR1MuLqkz55OW7UTDcxdQs2DWZa4ZsAOg', 'https://us05web.zoom.us/j/87457702575?pwd=UldJRG92djJaOTd1L1BJY0dCVnNQZz09', 'ez8vcW', 30, '2021-10-08 11:05:52', NULL),
(1260, 'Table 2', 0, 1, 7, NULL, '12:30', '12:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/86443008625?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NjQ0MzAwODYyNSIsInN0ayI6Ikw1akxsa2ZiYmZiVFZQUEgyc2J3a3V4d0RSbDB5LUg1aXZud3BPOElzZjAuQUcuZ3JjNEVDc09Tem1kWXFZZ0FRcTNlSVZoTzlCTlN4TnFCNnNVcXVtc1puSFZ5WmVkcWxvTWdGWTI0c2tKQjcwM0o2S1RYLWl0QktDSE5vT0YuaGdjWXhEcVY1LW5EQ3FOcVBqZV8tQS53UnJIVFBpUjVJT0FoLW5oIiwiZXhwIjoxNjMyNDA1NzMzLCJpYXQiOjE2MzIzOTg1MzMsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.2wFQjLp4lys8TUDA2aulLyuxRoWZge8ws5V5NCV9B9w', 'https://us05web.zoom.us/j/86443008625?pwd=U0FSa0VOVnVUU0lwQVFTVEgxbllvQT09', 'u9PKK1', 30, '2021-10-08 11:05:52', NULL),
(1261, 'Table 2', 0, 1, 7, NULL, '13:00', '13:00', '2021-10-08', 0, 0, 0, 0, NULL, NULL, NULL, 30, '2021-10-08 11:05:52', NULL),
(1262, 'Table 2', 0, 1, 7, NULL, '14:30', '14:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/85808721837?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTgwODcyMTgzNyIsInN0ayI6ImFIanBicjlWVjA2RHBVeC1kUnJJdzMzRXNhVDB0R183V2l4cFYyNlRoN1kuQUcuY3VBWDdueFZ3ZTFFM25IQzBYVU9YN2hmbzR4eGtNaUVQZFF2cll6aW1IMU1tZG5sOGVFSDVEc1dxQnhOWFVZb09WaDBDZ1F0UlZ2TVdoYkUuWWxNSktkZ1dzaFZ2dE4tU1B2NEQ5US50WW1RaE5tU0JaNG9UbnZMIiwiZXhwIjoxNjMyNDA1NzM1LCJpYXQiOjE2MzIzOTg1MzUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.aChdMK07tCSIt7dU3lrOEQLumUb2gRiGNiZK9BWTj7c', 'https://us05web.zoom.us/j/85808721837?pwd=S2o2amV3elJTNUNVczNwTVpjTmNRUT09', 'V73tF3', 30, '2021-10-08 11:05:52', NULL),
(1263, 'Table 2', 0, 1, 7, NULL, '15:00', '15:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89701209382?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTcwMTIwOTM4MiIsInN0ayI6Ijh5dzR1QldBYnh4R2pjME11blR4ZXZGS1AzZ0JVWU5sSWZUaDNha1dFZWcuQUcuQUY5elN4NFZZeEZDdmtfbERrSG5ibjJQczMwLUhDazdidlBvYmRrd0FSYWloU244Q2pfMnI2ZHBvb1Nqd1NQc2xyN3BZTGIxSXRWT2k5TXoublNjM2Q2a2I1SlBTZVdmdjgxUXcwQS5yRjR4Y25JaExzV1FOTnlpIiwiZXhwIjoxNjMyNDA1NzM2LCJpYXQiOjE2MzIzOTg1MzYsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.BzbBIvcNJECVqxjFwUVvVd02ldJAWfyTywTzi7DRHK4', 'https://us05web.zoom.us/j/89701209382?pwd=SUI3WFpQUXJpbU8rRVJEdWYxay9iUT09', 'z6q0Fh', 30, '2021-10-08 11:05:52', NULL),
(1264, 'Table 2', 0, 1, 7, NULL, '15:30', '15:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81015640564?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTAxNTY0MDU2NCIsInN0ayI6InpGMXFVZURFWk5DbV95ZzNfMVh5VlRXTlFGeTZlZ2RWZXBRNWxaZno1eE0uQUcuMlVBeExuU0h3Qkl5N1ZlQ1cyb0FZWU8xMUFYZTlEMlc0S0RIREsxYmRLV1FRNVpydzNSSXFrUjRVS0pJallCcUhVS2x2RE5RMThvZEp1YnIuTUxKWHl0VUhJbE9zNEJMZVJnazhUdy5Pd29xcTBwNVNfeGdKVzd2IiwiZXhwIjoxNjMyNDA1NzM3LCJpYXQiOjE2MzIzOTg1MzcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.7fMaMZsTYiP_1BfhBBRyEGJ8EHM8eiESGamYpuWponM', 'https://us05web.zoom.us/j/81015640564?pwd=UnpBZ20xR1JDc0VGYnNxOEJMYVpxdz09', 'EqD2VW', 30, '2021-10-08 11:05:52', NULL),
(1265, 'Table 2', 0, 1, 7, NULL, '16:00', '16:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82691848364?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjY5MTg0ODM2NCIsInN0ayI6Im5yV3NDekFHSEgxaXZFTEcyTGlYUTl6WDZuWktURmR2WHMyY29BeERwX00uQUcuRDBJWnV0dW1GeldoWVppRGpBbVF6VXJMODdiQko5aXhDcTZaQ2RRWE15X1p1ZGNXbGR3Qzl4amVHYXRUV2N5R2dBazhrRklaeWJTQTZKa0EuUHR6RzRGaUJyMmN2bEpSSHpQdURSQS5HeHZBalo1c1h5bFdpV0t3IiwiZXhwIjoxNjMyNDA1NzM4LCJpYXQiOjE2MzIzOTg1MzgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HzEO6vFS-lvak87mrccANoREv1zMlFr55BlqWSLTrFE', 'https://us05web.zoom.us/j/82691848364?pwd=T1lvOC9MR2VGZnFESGpwWmZ2NGVhQT09', 'fB8KkU', 30, '2021-10-08 11:05:52', NULL),
(1266, 'Table 2', 0, 1, 7, NULL, '16:30', '16:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82435808992?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjQzNTgwODk5MiIsInN0ayI6IjJTeFlWcXNDYWIxY3pQT0F3NEVvdXBJb2VhX1BZNE9vRDQ0b2wwMkVEZzAuQUcuNkJGOFhIbzJLYmgtLWFaTTdad2JLTDJRNUtwTjlXdXVZVmVyalkxdTEzblY0OXN6Zzl1aVF0b1V5emtnVTBZVlNrdXJ0NHczWXkySE5POVQuU0xGMjZFaURWQ0J6MWRCYlNDcGpBdy5rVFpKdXBPalYwaDhpZkpHIiwiZXhwIjoxNjMyNDA1NzM5LCJpYXQiOjE2MzIzOTg1MzksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.nrkxaKLYqjwjQRK518mUTk1OtnBKaJk5QKx5dfdhN0g', 'https://us05web.zoom.us/j/82435808992?pwd=UlVJV2JkWEJLYnRKQnp2d1p0UFdLZz09', 'M7ArD9', 30, '2021-10-08 11:05:52', NULL),
(1267, 'Table 2', 0, 1, 7, NULL, '17:00', '17:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/85168845300?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTE2ODg0NTMwMCIsInN0ayI6IjllVFpMbUNuOVFMWTRaaHdnOWFrdUZxUnU0MlpBUEIxVUVFVVN5Zi0yQTguQUcuakJIYndsb3ZFNTlaV3g2WDNRSms5MkFlZ0NEWXVDdzFZSl84SWxyQ1ZUa2gzQjVxT2JVZDVjMy1oQjU2UURJQTRsMjFDeWF3X2xlbDJFWDQubkNTOE5rWkVwQkRCcThKNnROZGNqZy5IQ1c5WVFQR240YWlNRmxlIiwiZXhwIjoxNjMyNDA1NzQxLCJpYXQiOjE2MzIzOTg1NDEsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HW5MyYu28KYFWTuf59PLnYvj-MuV8YvyVN8V2CDIdUs', 'https://us05web.zoom.us/j/85168845300?pwd=L2xPU2Y4TTNOQUNnQlBGWlM3VGhTUT09', 'hGC5ZM', 30, '2021-10-08 11:05:52', NULL),
(1268, 'Table 2', 0, 1, 7, NULL, '17:30', '17:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88233883889?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODIzMzg4Mzg4OSIsInN0ayI6InJnRERaYVctVTk1b2p0OVd6QUlzdFRlU3Z1QmUyRkMyQ1FsRzZLRzlRSEkuQUcucm9hOGZBMFQyWXRjcVZHRWl4U3RsTnJkbGZKMWNPSVJCMU42Wnl4aFNlYnBjaEpybElYUEt4QWk1LV9YUkV0T1RUSGV6MUZhdEtoNjhxUm8uSVE4R0dSSTg1cS1YNFVoc3FFWmltZy50Y3VJYWJRalp0M2JzZVU5IiwiZXhwIjoxNjMyNDA1NzQyLCJpYXQiOjE2MzIzOTg1NDIsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.1QYLJTWPzO3cwIx_bVyqt__lSfkYTDmHa9FY4_J68vc', 'https://us05web.zoom.us/j/88233883889?pwd=OVNlSUFqSzFwVW0rSkVyRGlPMjJQdz09', 'NgT8nw', 30, '2021-10-08 11:05:52', NULL),
(1269, 'Table 3', 0, 1, 7, NULL, '09:00', '09:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89138597724?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTEzODU5NzcyNCIsInN0ayI6Imp2dFNHcDJUb0NGMzhyVFNmNTdNczJHU0FoM214TDVRUnExTlowYWV5OUUuQUcuaGZWMkQyeVktbldyYTB3MnQ3UHlOdFBBa3Rld2tGRmlfTHNPT0NDMFpLUm14eXV5MUZhMDB5OUVlbTdFMHBVclhnaFA1dDQ2Mm9ZR25FalEucTI5UmxRLUU2bExaeTVNT0NJTEgtZy41aDJmWXpZeFI3cndDQzV0IiwiZXhwIjoxNjMyNDA1NzQzLCJpYXQiOjE2MzIzOTg1NDMsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.63NOnRnTJVzwql5ZBVMi58nYWhaPwkoqD1XOzaMR9CY', 'https://us05web.zoom.us/j/89138597724?pwd=TXZJeUFxWEJuZGJQY2FpQzNmbjMvQT09', 'd6G57z', 30, '2021-10-08 11:05:52', NULL),
(1270, 'Table 3', 0, 1, 7, NULL, '10:00', '10:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81476239948?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTQ3NjIzOTk0OCIsInN0ayI6IlBULXFYdlMzWVgyQmNJczB0ZUsxTmM4cTdaMHVlR0lKOXZycGZReUJqS3MuQUcuLWVnczdTOUJObXJIenBZcG9yZVU1SmRHbGxaeFlqaWFieV8zelJiWjJQRHI5cjA2N0JPQzBiYXMxQ1RWUjhfSDBRTDBNb3dJNDBPbVV0ejkuYllYQmJmQW1lT29lWklMOXZqdUs5dy5aakxnWlluLVBKLWVtSXVDIiwiZXhwIjoxNjMyNDA1NzQ1LCJpYXQiOjE2MzIzOTg1NDUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.9pA_EkqbIjVjwpUH62COR7Z4ZpgTg5kFDeeMK1ee3rw', 'https://us05web.zoom.us/j/81476239948?pwd=dldNcDlQQXhHRGJlNGhOdy9uY1RSdz09', 'nm8Pyb', 30, '2021-10-08 11:05:52', NULL),
(1271, 'Table 3', 0, 1, 7, NULL, '10:30', '10:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/84704264647?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NDcwNDI2NDY0NyIsInN0ayI6IlRmb2U4NklDbUdnQUt2NmpDQVBBY2piZVFZcWlCTDlwc1NlVldlS2ExMWsuQUcubnJMSkt3c2RpaDVHV3Q5SExfSWo3YWVRVnFDTnpNZGJWVDNiMy1fTHpXV2RTVTRrc2drVHZ4cXRTUVpJUzI1U09aZExBd2ZnVWdtcUYyX2guLWcxeTdodVlFLV9FV0MzdVVZMkwwZy53dXo4ckN1S3RnNEMzcGFRIiwiZXhwIjoxNjMyNDA1NzQ3LCJpYXQiOjE2MzIzOTg1NDcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.8Z6bOQbmLQTkwf6UOhQUnCDxdDWHUN_bo8dYga8Ynuo', 'https://us05web.zoom.us/j/84704264647?pwd=SVB4ZzFTUlRjRlNiM3haK09KbEpzdz09', 'qv9H3y', 30, '2021-10-08 11:05:52', NULL),
(1272, 'Table 3', 0, 1, 7, NULL, '11:00', '11:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88943551740?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODk0MzU1MTc0MCIsInN0ayI6IjZFUHdXM1ZRd3ZmQmFkNEhWbEs5MmkwSEF6NENmUUxINFBnbWQxZkxCMjQuQUcubHJuVmtYNkhpRE9IS0hKVVJ6anVKbHU1VWxudGZLMU40UzgxMjdVVzJXeUlqVW42ZzRuY1Q0ajZTOUV0WmZUbXRLQjY1aFRFVGdkQ3RUN3YuOEtSaXpSOVMxRW1EN0NBNHhMVTFMQS5scGJGWm44QnhmZjUxd01SIiwiZXhwIjoxNjMyNDA1NzQ4LCJpYXQiOjE2MzIzOTg1NDgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HJqt73DLJwOu5_M9BcWqsAk2qZ6uqDrUoCzHIDv7KgQ', 'https://us05web.zoom.us/j/88943551740?pwd=TGs4TzR1MldGZlhwVEc0QUlBdGgwZz09', 'Pu8v4N', 30, '2021-10-08 11:05:52', NULL),
(1273, 'Table 3', 0, 1, 7, NULL, '11:30', '11:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89664512901?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTY2NDUxMjkwMSIsInN0ayI6InVwcFN0eXdWXzJ4SlIydXhaQnNPUEVxLXA4SUE3cmd1bkU4dHR0TUFiNkUuQUcuYlBEYjVVV1RnS29jMkZWRFRZT01VMFRXZkl0b2dRTU8wS0U5UFFJaVBLNlRBZXcwY00yVzB3TTRlV0JyZjhOUlNGcnpRLVZDTnlDSVY5OXQuQnJjTEllOHJnWGdILVhmR2tkNEliUS5YLWJFNkE0M1FldWFmUC0xIiwiZXhwIjoxNjMyNDA1NzQ5LCJpYXQiOjE2MzIzOTg1NDksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.hPGhRanbyw-cUsllN_gM52T2q88A7Mx-o3VLBCFD8yw', 'https://us05web.zoom.us/j/89664512901?pwd=NEc4UklqczNENDl1T0QvVlM4WDJBdz09', 'SmHF6H', 30, '2021-10-08 11:05:52', NULL),
(1274, 'Table 3', 0, 1, 7, NULL, '12:00', '12:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82115165250?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjExNTE2NTI1MCIsInN0ayI6Ik5XNlVhLWJ2cE8zRDRNckJJLVVaWlRZRXBuYXBWS3F0OVd4azhHUHJyZm8uQUcuRXIzaDFEZERxbmxSYVI2N19ROG9kX3VGVHJyRXNrR3JreXM1aDV6QTdoRmxBVUo1UzlsdXZCemc4SnNCM1ByREFCMVVQX0tMTWlwVy1USHIuQVRCc291SWtrQl90N3dPV2dSTkprQS4taVItZ1NLN2VZME9OSWRxIiwiZXhwIjoxNjMyNDA1NzUwLCJpYXQiOjE2MzIzOTg1NTAsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.UDrfK4H8o7MCp19Ui9MXR-FBxR1fHU-KvQbmuh0HgIQ', 'https://us05web.zoom.us/j/82115165250?pwd=bnZJR01mSGd0b0l4bC9Cai9zNEh4UT09', 'u2AMCe', 30, '2021-10-08 11:05:52', NULL),
(1275, 'Table 3', 0, 1, 7, NULL, '12:30', '12:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/86708009235?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NjcwODAwOTIzNSIsInN0ayI6InpvbHZ0ekFuV1RoWmpoV3czNmZKM1lKMHd0ODRCUzVGX2taTzFFajBHa2cuQUcuMmcwVUZqRjRfX3d4am50WHpzU001NEdVS2g4VDBMSkM5eHVjNlF1Qm85ZXFOd1doR3dfR1FaMFdLWm40UGZSczh6LTh3ZHZUR2E0c2VYY2MuX0szcFBHS2x3R2xnUXNsMU5TQ3pLQS5zcEt5aElzVEVoQlN6M3M1IiwiZXhwIjoxNjMyNDA1NzUxLCJpYXQiOjE2MzIzOTg1NTEsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.RfN9XwkIui-6-JhZ_4T5Dl7Vyv78ElMWIpZZSIYK8to', 'https://us05web.zoom.us/j/86708009235?pwd=NXZ5YlJWYVFZa0p3VUpZWHNwa0QyUT09', 'ft4uDL', 30, '2021-10-08 11:05:52', NULL),
(1276, 'Table 3', 0, 1, 7, NULL, '13:00', '13:00', '2021-10-08', 0, 0, 0, 0, NULL, NULL, NULL, 30, '2021-10-08 11:05:52', NULL),
(1277, 'Table 3', 0, 1, 7, NULL, '14:30', '14:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81019445003?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTAxOTQ0NTAwMyIsInN0ayI6ImM5b0Y1dncwakRpckRIbzFvNXZ6WlVZc090ckdURzlfVzlSM2stZ09JVkEuQUcuTmtQQ21TTkgyYTV2am9UNmoxblJZaGpCbVZ4dTNJMkVsRUo4VDFoTktyUnFOTlA5a2ZlS1dmQTV3SmVGbklRN2Y1bGhuZlF0dzhTemZfYTAuYXlGaHR0Nm56dFB4eE5abjcya2ZmQS5JanpLckFMNU9SM3BwWXExIiwiZXhwIjoxNjMyNDA1NzUzLCJpYXQiOjE2MzIzOTg1NTMsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.uWtcRGZz802gKX2UhqCUwBA47Ld2GoCaxUY8RMN0zjs', 'https://us05web.zoom.us/j/81019445003?pwd=ZFZnOFFuM1l6RHpLNVVySWZGaVRSQT09', 'PFgL41', 30, '2021-10-08 11:05:52', NULL),
(1278, 'Table 3', 0, 1, 7, NULL, '15:00', '15:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87357165002?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NzM1NzE2NTAwMiIsInN0ayI6InpmeTNPMHJTc3dyMnBiT1BjelZGcGt0Wnl0cXVfZlFVOW9tdDN4NU10bmsuQUcubE0tblhIWHNLYnRHYnd4aFJLa1FDQzVXYk1LX2NqVV91cDc4TDZKS1RsdzdxeWFpeWFocF9pRktiUjhUb1hzZGNXNlphX01XZmRud1p6Q1EuM3BZZHdOcWVyU1B0emRrbEJCaTRhZy5RQTdVMEtCcG1OTUt5dk1kIiwiZXhwIjoxNjMyNDA1NzU0LCJpYXQiOjE2MzIzOTg1NTQsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.764HliB2R4ScoMeYPt7EJ3wOzhLSz1UkhCgCvWzWRbo', 'https://us05web.zoom.us/j/87357165002?pwd=L25qbm8zeElUOTlkZWkxM1crRlVCUT09', '6e5rgE', 30, '2021-10-08 11:05:52', NULL),
(1279, 'Table 3', 0, 1, 7, NULL, '15:30', '15:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87598588621?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NzU5ODU4ODYyMSIsInN0ayI6IjlUemVvWm9KbTZoM0gyaVoxYjU5dUoxaElRdU16MHBvYjJvcFZYVVZ5c1UuQUcuUHpiWEhxaFBraHphSHpxNlg5YkdBckl6MVlncHQ0VXVDUkZvWlJwQ0V0c3JReGs5ejl6RmFVbGRLd1BFOTF6M09NWUdGSEFtTG5NbFJFSWEudWZQMjJGM21LREpfc0JPNlNzVXVyUS5lRWtvLUZ5WDU1OEZYWHRfIiwiZXhwIjoxNjMyNDA1NzU1LCJpYXQiOjE2MzIzOTg1NTUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.rGp6TVY9n5E21ZOaXMwr0DmuKZuCQE_UGXQyYdd_c88', 'https://us05web.zoom.us/j/87598588621?pwd=MTJDTUc4b3lIbjVSbEkycXN0NURFdz09', 'xpXsp4', 30, '2021-10-08 11:05:52', NULL),
(1280, 'Table 3', 0, 1, 7, NULL, '16:00', '16:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/85191541338?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTE5MTU0MTMzOCIsInN0ayI6InZZdjlKcGVBYmJsRlE5RDZ6dHdkZ25nOWhqMV9fUW9PTW5TWUhLUGRQdmsuQUcudV9VLWJqSV96bUU4NEk4NUlkT2N2M1d0a2hSR0lSbDFxbG1NamhmVDZFaFpDYVlNcXJOVTl4SjFqYmFxNGhldXJwcTRiaXVvVUkyRlMzbDgueGQxT0F3eHhaNm9TNHltZkxfOEk3Zy5nbFBqMFBaem9CLVJWdXVJIiwiZXhwIjoxNjMyNDA1NzU2LCJpYXQiOjE2MzIzOTg1NTYsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.uhjoygM-b-E21lj6kAisg5OU-sAnkF7TUSwx7yktE8o', 'https://us05web.zoom.us/j/85191541338?pwd=SEF6dVROVkZOOUM0UEJxc1BHcmFJdz09', 'b9Ffvd', 30, '2021-10-08 11:05:52', NULL),
(1281, 'Table 3', 0, 1, 7, NULL, '16:30', '16:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89404585520?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTQwNDU4NTUyMCIsInN0ayI6InFmdXB0TUZWLWxZM2d6amZ5U2VJQTlyUW1rOTZXc2NCcUNJaldoeDJUUE0uQUcuV3d6eDJNdWg2Vk9ENWg3Mk5WdDUzdnFNTnlha3l6bHMyRzg5dVJtNndFS1AyMGNPbENPTmJoeWRYbGc2WVJBSXVXZE9OdWdra0dCRkNZeGYuWnNyMkNwN1V5ZlJGekczZWlxSlEtZy5Qem5mQ1B4MmZvM3FrOVl2IiwiZXhwIjoxNjMyNDA1NzU3LCJpYXQiOjE2MzIzOTg1NTcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HcTQ5gPBlbiocjKavQtDXP2_lzoF7I5bTk7uuaPStXs', 'https://us05web.zoom.us/j/89404585520?pwd=Q3RzeG1rc0VhT21lMnp6YWthWG5zUT09', '8Hc3eU', 30, '2021-10-08 11:05:52', NULL),
(1282, 'Table 3', 0, 1, 7, NULL, '17:00', '17:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82161080679?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjE2MTA4MDY3OSIsInN0ayI6IlM4N2FjUW43MnZWQ256c0gzWWowSkJDOEstS2pwTW9acnB0TXFkdVlDNlUuQUcuMlA4TkdSY2NqeUFLVGsxTGhhOU1kMk51eC1aUlh0eWo4OW0wXzJLVWwyWGxZUnF0bllSeVJrY3FpVm1RRlo4Y29KdzJVVDU2U3dFem4zbXYuOWNiUEp5cW1VZXkzMGc3bGJCU1JKQS5qVGotM3VSTVpnYlZmOTlSIiwiZXhwIjoxNjMyNDA1NzU4LCJpYXQiOjE2MzIzOTg1NTgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.UHMVv9UFxEJmDYc5JnK7yW7c8-DBhYg7L_7OPYZxiHI', 'https://us05web.zoom.us/j/82161080679?pwd=SERZSnFiSHgrRXpJWi90Z1NXc2tpZz09', 'fi8SAi', 30, '2021-10-08 11:05:52', NULL),
(1283, 'Table 3', 0, 1, 7, NULL, '17:30', '17:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81617523944?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTYxNzUyMzk0NCIsInN0ayI6Ink3Z1NnUGwzbnI3bXZCWGRaLVRINGRTYVFKOUl2VEI2MnMydVBiYm8yM0EuQUcuY3pzODN6UlRiVGFlVDJjcjQzSEFELUkzVzBQUG9ldVEtVnhra2tocGtjMVVNQURtNEdyU1JQc0t0ZXEzTWpITVJzVFNXeG1nTkZ1MzdJMmEuVHRjNDhxUjRkTGhuYUZUQ252SEVtdy5XOGhCb0xWZDNoSU1NODNfIiwiZXhwIjoxNjMyNDA1NzYwLCJpYXQiOjE2MzIzOTg1NjAsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ._f2gtj-dQc88Hlnxs1xG3Ezc_uRrBmVZ7iCWtFtMRXM', 'https://us05web.zoom.us/j/81617523944?pwd=VXlsRVB1WkQ0WU12WWxYSFB5NGxGZz09', 'r11yBt', 30, '2021-10-08 11:05:52', NULL),
(1284, 'Table 2', 0, 1, 7, NULL, '09:00', '09:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88410550585?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODQxMDU1MDU4NSIsInN0ayI6InVpWlhoOGFZekVtb0R2akJ5TW5DR3BGY1lZUHZsakhqSllJZFdmY1VnUjguQUcuT3pxWFhWc0o0eUx2aWNPYmtuNzc3akhhLUw4Rk9XWThJa0FHYzI3UTJNT1BSc1hCQVVKS3FJYkVpeS13WTkxX1RHQjhwZlpCaGNoRE41ekQua2lKOWNObFBJeVdIUDdXN1lQRjlzQS5MTzdNdVBnMzVfWGJYYk12IiwiZXhwIjoxNjMyNDA1NzI1LCJpYXQiOjE2MzIzOTg1MjUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.DQOzVz3x_Dv2bNNN17CDEW9_EU04jW7X5KgO5uBGqT8', 'https://us05web.zoom.us/j/88410550585?pwd=Um5oZEpiaEIxZ1hUSTViZ0k5UHUydz09', '3Ezzk7', 30, '2021-10-08 11:05:52', NULL),
(1285, 'Table 2', 0, 1, 7, NULL, '10:00', '10:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/84034100501?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NDAzNDEwMDUwMSIsInN0ayI6IjRaRW1zTFA3aWxIUVBQbHhQbC1kMHZ1QncxLWt2aWdmZ2JRcENKVkxEeGsuQUcucWZ1TVl6XzViNjhBdUtYUHZoZzJlcWdmX3ZTRmlRdXo1YTBCb1U4eXRLVlE0ZjMybWduYk5DNU05UXBUVHBtQUZyemdLbzdMeXE5eTEycmsudzREdzNuZTQzVi1YRGp5bndtVW03US5CQzBTT2xOTEJveFpOU1FNIiwiZXhwIjoxNjMyNDA1NzI3LCJpYXQiOjE2MzIzOTg1MjcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.6S2SY2rHsgkC-Li4X3NhxHlZFIICFJhZ-ci3evlbk9M', 'https://us05web.zoom.us/j/84034100501?pwd=dkI2b0VFNHNwaWUwN2xXZSthOG5MZz09', 'wBST3v', 30, '2021-10-08 11:05:52', NULL),
(1286, 'Table 2', 0, 1, 7, NULL, '10:30', '10:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89980378238?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTk4MDM3ODIzOCIsInN0ayI6Ink2a1J0eWpDRHpKSE1xOEltYjhObDJfbl9sRlRuUHRjYW0xUUJjVVU3dTguQUcuSDR5SWVUaGltajRCVWFod0tqdEJtcGlfV0QzYzBLQ3lRQ2lPQnI3c1NUWmV4enF0Tl9Ra0hzTU9BWm1ZTWFOMmc5dzZMaTgyUGM4bjI2cEkudUpiM0RBUVQ4ZFMwOC1lM3Q4R3dSdy5id3BmTzFDT2U4NnkyVzNDIiwiZXhwIjoxNjMyNDA1NzI5LCJpYXQiOjE2MzIzOTg1MjksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.7qa9SA0bKEskeVfIToDm_oqXbOeTXdr0pwgqZG1AvoA', 'https://us05web.zoom.us/j/89980378238?pwd=a3NUMHJpaFdqaEIrNklVRk1QM0h1QT09', 'zvz3Ya', 30, '2021-10-08 11:05:52', NULL),
(1287, 'Table 2', 0, 1, 7, NULL, '11:00', '11:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82306596579?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjMwNjU5NjU3OSIsInN0ayI6Ikh5MDNJbVBfM2M2b1dhVWtUeS01a2ZSVWRDbHFSa3RHYUpHaEM5cHl6N1kuQUcuZTVRc3pOdUNFNklEZks3RC01eTJkam1MRHk2MHFNTnY2S1VnaXVXWWZIMVhPRjZwbENZa0s3TzdmXzRZOVRBVUdtRFhxUFJlci13UzFEdk8uNTlZdExjcXJDMmFtWXNUTVliMWNTUS5mYWFnRWY5OUdwdUN0NTMtIiwiZXhwIjoxNjMyNDA1NzMwLCJpYXQiOjE2MzIzOTg1MzAsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ._MEwdF4YqTIRzenfc84rIGrXbzwrBtZg_YBlEebsXJ8', 'https://us05web.zoom.us/j/82306596579?pwd=YXF1MlE3dzFUY0JUeHFtR05UaTlXUT09', 'hNMj9s', 30, '2021-10-08 11:05:52', NULL),
(1288, 'Table 2', 0, 1, 7, NULL, '11:30', '11:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87895705094?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4Nzg5NTcwNTA5NCIsInN0ayI6IjM1QmZJTXRORk85V2dQS1FVRkJidUQtLXlTMzhpTzhhb2ZtbmtHRzhIZnMuQUcuQWkwV3psVHRja0ZMRHpacEF0SkFpRnl4MmRnVHdDQXV6cjdyLTlRYm5sTHBpSV9kYVI2aXFhU3ZJckZUdlRYZ1lIbE9fcElSZC1oV0xjN0suNGNvRWZXQmdQcDctc3hHUEpwSVlBQS4zWUhGcW1LTU1JZWVYQjZXIiwiZXhwIjoxNjMyNDA1NzMxLCJpYXQiOjE2MzIzOTg1MzEsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.fDUs--cDQCwInj4JNHBR2D87Hkx78XajsJjjocJ7u_Y', 'https://us05web.zoom.us/j/87895705094?pwd=cmZNSXZYb1pROGd5bW43anJacTVHZz09', 'Z4jTr5', 30, '2021-10-08 11:05:52', NULL),
(1289, 'Table 2', 0, 1, 7, NULL, '12:00', '12:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87457702575?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NzQ1NzcwMjU3NSIsInN0ayI6IkFpdlJqVUFHaEpYN3RLNnJIbDhnbjk3UkNWTVBDUEFQc3FQTWFMX3lQYkkuQUcuUVVCYmpoR01kUWs1eDgyS082azVWby02QkNtMVhvbTFVX0FYbG9FOHVKWFpFZGhYYWQ4ejVEelJ6R2h1MzQyNHZ5Z2xhdHlPanJ2SHQ2bjguUDNqTV92aUNvYzFFYzMzZ1ZiY1Jkdy5XWmI4bGZkSTBJelVBUEdBIiwiZXhwIjoxNjMyNDA1NzMyLCJpYXQiOjE2MzIzOTg1MzIsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.vP_NBWeuPxbR1MuLqkz55OW7UTDcxdQs2DWZa4ZsAOg', 'https://us05web.zoom.us/j/87457702575?pwd=UldJRG92djJaOTd1L1BJY0dCVnNQZz09', 'ez8vcW', 30, '2021-10-08 11:05:52', NULL),
(1290, 'Table 2', 0, 1, 7, NULL, '12:30', '12:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/86443008625?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NjQ0MzAwODYyNSIsInN0ayI6Ikw1akxsa2ZiYmZiVFZQUEgyc2J3a3V4d0RSbDB5LUg1aXZud3BPOElzZjAuQUcuZ3JjNEVDc09Tem1kWXFZZ0FRcTNlSVZoTzlCTlN4TnFCNnNVcXVtc1puSFZ5WmVkcWxvTWdGWTI0c2tKQjcwM0o2S1RYLWl0QktDSE5vT0YuaGdjWXhEcVY1LW5EQ3FOcVBqZV8tQS53UnJIVFBpUjVJT0FoLW5oIiwiZXhwIjoxNjMyNDA1NzMzLCJpYXQiOjE2MzIzOTg1MzMsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.2wFQjLp4lys8TUDA2aulLyuxRoWZge8ws5V5NCV9B9w', 'https://us05web.zoom.us/j/86443008625?pwd=U0FSa0VOVnVUU0lwQVFTVEgxbllvQT09', 'u9PKK1', 30, '2021-10-08 11:05:52', NULL),
(1291, 'Table 2', 0, 1, 7, NULL, '13:00', '13:00', '2021-10-08', 0, 0, 0, 0, NULL, NULL, NULL, 30, '2021-10-08 11:05:52', NULL),
(1292, 'Table 2', 0, 1, 7, NULL, '14:30', '14:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/85808721837?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTgwODcyMTgzNyIsInN0ayI6ImFIanBicjlWVjA2RHBVeC1kUnJJdzMzRXNhVDB0R183V2l4cFYyNlRoN1kuQUcuY3VBWDdueFZ3ZTFFM25IQzBYVU9YN2hmbzR4eGtNaUVQZFF2cll6aW1IMU1tZG5sOGVFSDVEc1dxQnhOWFVZb09WaDBDZ1F0UlZ2TVdoYkUuWWxNSktkZ1dzaFZ2dE4tU1B2NEQ5US50WW1RaE5tU0JaNG9UbnZMIiwiZXhwIjoxNjMyNDA1NzM1LCJpYXQiOjE2MzIzOTg1MzUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.aChdMK07tCSIt7dU3lrOEQLumUb2gRiGNiZK9BWTj7c', 'https://us05web.zoom.us/j/85808721837?pwd=S2o2amV3elJTNUNVczNwTVpjTmNRUT09', 'V73tF3', 30, '2021-10-08 11:05:52', NULL),
(1293, 'Table 2', 0, 1, 7, NULL, '15:00', '15:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89701209382?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTcwMTIwOTM4MiIsInN0ayI6Ijh5dzR1QldBYnh4R2pjME11blR4ZXZGS1AzZ0JVWU5sSWZUaDNha1dFZWcuQUcuQUY5elN4NFZZeEZDdmtfbERrSG5ibjJQczMwLUhDazdidlBvYmRrd0FSYWloU244Q2pfMnI2ZHBvb1Nqd1NQc2xyN3BZTGIxSXRWT2k5TXoublNjM2Q2a2I1SlBTZVdmdjgxUXcwQS5yRjR4Y25JaExzV1FOTnlpIiwiZXhwIjoxNjMyNDA1NzM2LCJpYXQiOjE2MzIzOTg1MzYsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.BzbBIvcNJECVqxjFwUVvVd02ldJAWfyTywTzi7DRHK4', 'https://us05web.zoom.us/j/89701209382?pwd=SUI3WFpQUXJpbU8rRVJEdWYxay9iUT09', 'z6q0Fh', 30, '2021-10-08 11:05:52', NULL),
(1294, 'Table 2', 0, 1, 7, NULL, '15:30', '15:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81015640564?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTAxNTY0MDU2NCIsInN0ayI6InpGMXFVZURFWk5DbV95ZzNfMVh5VlRXTlFGeTZlZ2RWZXBRNWxaZno1eE0uQUcuMlVBeExuU0h3Qkl5N1ZlQ1cyb0FZWU8xMUFYZTlEMlc0S0RIREsxYmRLV1FRNVpydzNSSXFrUjRVS0pJallCcUhVS2x2RE5RMThvZEp1YnIuTUxKWHl0VUhJbE9zNEJMZVJnazhUdy5Pd29xcTBwNVNfeGdKVzd2IiwiZXhwIjoxNjMyNDA1NzM3LCJpYXQiOjE2MzIzOTg1MzcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.7fMaMZsTYiP_1BfhBBRyEGJ8EHM8eiESGamYpuWponM', 'https://us05web.zoom.us/j/81015640564?pwd=UnpBZ20xR1JDc0VGYnNxOEJMYVpxdz09', 'EqD2VW', 30, '2021-10-08 11:05:52', NULL),
(1295, 'Table 2', 0, 1, 7, NULL, '16:00', '16:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82691848364?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjY5MTg0ODM2NCIsInN0ayI6Im5yV3NDekFHSEgxaXZFTEcyTGlYUTl6WDZuWktURmR2WHMyY29BeERwX00uQUcuRDBJWnV0dW1GeldoWVppRGpBbVF6VXJMODdiQko5aXhDcTZaQ2RRWE15X1p1ZGNXbGR3Qzl4amVHYXRUV2N5R2dBazhrRklaeWJTQTZKa0EuUHR6RzRGaUJyMmN2bEpSSHpQdURSQS5HeHZBalo1c1h5bFdpV0t3IiwiZXhwIjoxNjMyNDA1NzM4LCJpYXQiOjE2MzIzOTg1MzgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HzEO6vFS-lvak87mrccANoREv1zMlFr55BlqWSLTrFE', 'https://us05web.zoom.us/j/82691848364?pwd=T1lvOC9MR2VGZnFESGpwWmZ2NGVhQT09', 'fB8KkU', 30, '2021-10-08 11:05:52', NULL),
(1296, 'Table 2', 0, 1, 7, NULL, '16:30', '16:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82435808992?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjQzNTgwODk5MiIsInN0ayI6IjJTeFlWcXNDYWIxY3pQT0F3NEVvdXBJb2VhX1BZNE9vRDQ0b2wwMkVEZzAuQUcuNkJGOFhIbzJLYmgtLWFaTTdad2JLTDJRNUtwTjlXdXVZVmVyalkxdTEzblY0OXN6Zzl1aVF0b1V5emtnVTBZVlNrdXJ0NHczWXkySE5POVQuU0xGMjZFaURWQ0J6MWRCYlNDcGpBdy5rVFpKdXBPalYwaDhpZkpHIiwiZXhwIjoxNjMyNDA1NzM5LCJpYXQiOjE2MzIzOTg1MzksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.nrkxaKLYqjwjQRK518mUTk1OtnBKaJk5QKx5dfdhN0g', 'https://us05web.zoom.us/j/82435808992?pwd=UlVJV2JkWEJLYnRKQnp2d1p0UFdLZz09', 'M7ArD9', 30, '2021-10-08 11:05:52', NULL),
(1297, 'Table 2', 0, 1, 7, NULL, '17:00', '17:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/85168845300?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTE2ODg0NTMwMCIsInN0ayI6IjllVFpMbUNuOVFMWTRaaHdnOWFrdUZxUnU0MlpBUEIxVUVFVVN5Zi0yQTguQUcuakJIYndsb3ZFNTlaV3g2WDNRSms5MkFlZ0NEWXVDdzFZSl84SWxyQ1ZUa2gzQjVxT2JVZDVjMy1oQjU2UURJQTRsMjFDeWF3X2xlbDJFWDQubkNTOE5rWkVwQkRCcThKNnROZGNqZy5IQ1c5WVFQR240YWlNRmxlIiwiZXhwIjoxNjMyNDA1NzQxLCJpYXQiOjE2MzIzOTg1NDEsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HW5MyYu28KYFWTuf59PLnYvj-MuV8YvyVN8V2CDIdUs', 'https://us05web.zoom.us/j/85168845300?pwd=L2xPU2Y4TTNOQUNnQlBGWlM3VGhTUT09', 'hGC5ZM', 30, '2021-10-08 11:05:52', NULL),
(1298, 'Table 2', 0, 1, 7, NULL, '17:30', '17:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88233883889?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODIzMzg4Mzg4OSIsInN0ayI6InJnRERaYVctVTk1b2p0OVd6QUlzdFRlU3Z1QmUyRkMyQ1FsRzZLRzlRSEkuQUcucm9hOGZBMFQyWXRjcVZHRWl4U3RsTnJkbGZKMWNPSVJCMU42Wnl4aFNlYnBjaEpybElYUEt4QWk1LV9YUkV0T1RUSGV6MUZhdEtoNjhxUm8uSVE4R0dSSTg1cS1YNFVoc3FFWmltZy50Y3VJYWJRalp0M2JzZVU5IiwiZXhwIjoxNjMyNDA1NzQyLCJpYXQiOjE2MzIzOTg1NDIsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.1QYLJTWPzO3cwIx_bVyqt__lSfkYTDmHa9FY4_J68vc', 'https://us05web.zoom.us/j/88233883889?pwd=OVNlSUFqSzFwVW0rSkVyRGlPMjJQdz09', 'NgT8nw', 30, '2021-10-08 11:05:52', NULL),
(1299, 'Table 3', 0, 1, 7, NULL, '09:00', '09:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89138597724?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTEzODU5NzcyNCIsInN0ayI6Imp2dFNHcDJUb0NGMzhyVFNmNTdNczJHU0FoM214TDVRUnExTlowYWV5OUUuQUcuaGZWMkQyeVktbldyYTB3MnQ3UHlOdFBBa3Rld2tGRmlfTHNPT0NDMFpLUm14eXV5MUZhMDB5OUVlbTdFMHBVclhnaFA1dDQ2Mm9ZR25FalEucTI5UmxRLUU2bExaeTVNT0NJTEgtZy41aDJmWXpZeFI3cndDQzV0IiwiZXhwIjoxNjMyNDA1NzQzLCJpYXQiOjE2MzIzOTg1NDMsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.63NOnRnTJVzwql5ZBVMi58nYWhaPwkoqD1XOzaMR9CY', 'https://us05web.zoom.us/j/89138597724?pwd=TXZJeUFxWEJuZGJQY2FpQzNmbjMvQT09', 'd6G57z', 30, '2021-10-08 11:05:52', NULL),
(1300, 'Table 3', 0, 1, 7, NULL, '10:00', '10:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81476239948?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTQ3NjIzOTk0OCIsInN0ayI6IlBULXFYdlMzWVgyQmNJczB0ZUsxTmM4cTdaMHVlR0lKOXZycGZReUJqS3MuQUcuLWVnczdTOUJObXJIenBZcG9yZVU1SmRHbGxaeFlqaWFieV8zelJiWjJQRHI5cjA2N0JPQzBiYXMxQ1RWUjhfSDBRTDBNb3dJNDBPbVV0ejkuYllYQmJmQW1lT29lWklMOXZqdUs5dy5aakxnWlluLVBKLWVtSXVDIiwiZXhwIjoxNjMyNDA1NzQ1LCJpYXQiOjE2MzIzOTg1NDUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.9pA_EkqbIjVjwpUH62COR7Z4ZpgTg5kFDeeMK1ee3rw', 'https://us05web.zoom.us/j/81476239948?pwd=dldNcDlQQXhHRGJlNGhOdy9uY1RSdz09', 'nm8Pyb', 30, '2021-10-08 11:05:52', NULL),
(1301, 'Table 3', 0, 1, 7, NULL, '10:30', '10:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/84704264647?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NDcwNDI2NDY0NyIsInN0ayI6IlRmb2U4NklDbUdnQUt2NmpDQVBBY2piZVFZcWlCTDlwc1NlVldlS2ExMWsuQUcubnJMSkt3c2RpaDVHV3Q5SExfSWo3YWVRVnFDTnpNZGJWVDNiMy1fTHpXV2RTVTRrc2drVHZ4cXRTUVpJUzI1U09aZExBd2ZnVWdtcUYyX2guLWcxeTdodVlFLV9FV0MzdVVZMkwwZy53dXo4ckN1S3RnNEMzcGFRIiwiZXhwIjoxNjMyNDA1NzQ3LCJpYXQiOjE2MzIzOTg1NDcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.8Z6bOQbmLQTkwf6UOhQUnCDxdDWHUN_bo8dYga8Ynuo', 'https://us05web.zoom.us/j/84704264647?pwd=SVB4ZzFTUlRjRlNiM3haK09KbEpzdz09', 'qv9H3y', 30, '2021-10-08 11:05:52', NULL),
(1302, 'Table 3', 0, 1, 7, NULL, '11:00', '11:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/88943551740?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4ODk0MzU1MTc0MCIsInN0ayI6IjZFUHdXM1ZRd3ZmQmFkNEhWbEs5MmkwSEF6NENmUUxINFBnbWQxZkxCMjQuQUcubHJuVmtYNkhpRE9IS0hKVVJ6anVKbHU1VWxudGZLMU40UzgxMjdVVzJXeUlqVW42ZzRuY1Q0ajZTOUV0WmZUbXRLQjY1aFRFVGdkQ3RUN3YuOEtSaXpSOVMxRW1EN0NBNHhMVTFMQS5scGJGWm44QnhmZjUxd01SIiwiZXhwIjoxNjMyNDA1NzQ4LCJpYXQiOjE2MzIzOTg1NDgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HJqt73DLJwOu5_M9BcWqsAk2qZ6uqDrUoCzHIDv7KgQ', 'https://us05web.zoom.us/j/88943551740?pwd=TGs4TzR1MldGZlhwVEc0QUlBdGgwZz09', 'Pu8v4N', 30, '2021-10-08 11:05:52', NULL),
(1303, 'Table 3', 0, 1, 7, NULL, '11:30', '11:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89664512901?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTY2NDUxMjkwMSIsInN0ayI6InVwcFN0eXdWXzJ4SlIydXhaQnNPUEVxLXA4SUE3cmd1bkU4dHR0TUFiNkUuQUcuYlBEYjVVV1RnS29jMkZWRFRZT01VMFRXZkl0b2dRTU8wS0U5UFFJaVBLNlRBZXcwY00yVzB3TTRlV0JyZjhOUlNGcnpRLVZDTnlDSVY5OXQuQnJjTEllOHJnWGdILVhmR2tkNEliUS5YLWJFNkE0M1FldWFmUC0xIiwiZXhwIjoxNjMyNDA1NzQ5LCJpYXQiOjE2MzIzOTg1NDksImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.hPGhRanbyw-cUsllN_gM52T2q88A7Mx-o3VLBCFD8yw', 'https://us05web.zoom.us/j/89664512901?pwd=NEc4UklqczNENDl1T0QvVlM4WDJBdz09', 'SmHF6H', 30, '2021-10-08 11:05:52', NULL),
(1304, 'Table 3', 0, 1, 7, NULL, '12:00', '12:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82115165250?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjExNTE2NTI1MCIsInN0ayI6Ik5XNlVhLWJ2cE8zRDRNckJJLVVaWlRZRXBuYXBWS3F0OVd4azhHUHJyZm8uQUcuRXIzaDFEZERxbmxSYVI2N19ROG9kX3VGVHJyRXNrR3JreXM1aDV6QTdoRmxBVUo1UzlsdXZCemc4SnNCM1ByREFCMVVQX0tMTWlwVy1USHIuQVRCc291SWtrQl90N3dPV2dSTkprQS4taVItZ1NLN2VZME9OSWRxIiwiZXhwIjoxNjMyNDA1NzUwLCJpYXQiOjE2MzIzOTg1NTAsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.UDrfK4H8o7MCp19Ui9MXR-FBxR1fHU-KvQbmuh0HgIQ', 'https://us05web.zoom.us/j/82115165250?pwd=bnZJR01mSGd0b0l4bC9Cai9zNEh4UT09', 'u2AMCe', 30, '2021-10-08 11:05:52', NULL),
(1305, 'Table 3', 0, 1, 7, NULL, '12:30', '12:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/86708009235?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NjcwODAwOTIzNSIsInN0ayI6InpvbHZ0ekFuV1RoWmpoV3czNmZKM1lKMHd0ODRCUzVGX2taTzFFajBHa2cuQUcuMmcwVUZqRjRfX3d4am50WHpzU001NEdVS2g4VDBMSkM5eHVjNlF1Qm85ZXFOd1doR3dfR1FaMFdLWm40UGZSczh6LTh3ZHZUR2E0c2VYY2MuX0szcFBHS2x3R2xnUXNsMU5TQ3pLQS5zcEt5aElzVEVoQlN6M3M1IiwiZXhwIjoxNjMyNDA1NzUxLCJpYXQiOjE2MzIzOTg1NTEsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.RfN9XwkIui-6-JhZ_4T5Dl7Vyv78ElMWIpZZSIYK8to', 'https://us05web.zoom.us/j/86708009235?pwd=NXZ5YlJWYVFZa0p3VUpZWHNwa0QyUT09', 'ft4uDL', 30, '2021-10-08 11:05:52', NULL),
(1306, 'Table 3', 0, 1, 7, NULL, '13:00', '13:00', '2021-10-08', 0, 0, 0, 0, NULL, NULL, NULL, 30, '2021-10-08 11:05:52', NULL),
(1307, 'Table 3', 0, 1, 7, NULL, '14:30', '14:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81019445003?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTAxOTQ0NTAwMyIsInN0ayI6ImM5b0Y1dncwakRpckRIbzFvNXZ6WlVZc090ckdURzlfVzlSM2stZ09JVkEuQUcuTmtQQ21TTkgyYTV2am9UNmoxblJZaGpCbVZ4dTNJMkVsRUo4VDFoTktyUnFOTlA5a2ZlS1dmQTV3SmVGbklRN2Y1bGhuZlF0dzhTemZfYTAuYXlGaHR0Nm56dFB4eE5abjcya2ZmQS5JanpLckFMNU9SM3BwWXExIiwiZXhwIjoxNjMyNDA1NzUzLCJpYXQiOjE2MzIzOTg1NTMsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.uWtcRGZz802gKX2UhqCUwBA47Ld2GoCaxUY8RMN0zjs', 'https://us05web.zoom.us/j/81019445003?pwd=ZFZnOFFuM1l6RHpLNVVySWZGaVRSQT09', 'PFgL41', 30, '2021-10-08 11:05:52', NULL),
(1308, 'Table 3', 0, 1, 7, NULL, '15:00', '15:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87357165002?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NzM1NzE2NTAwMiIsInN0ayI6InpmeTNPMHJTc3dyMnBiT1BjelZGcGt0Wnl0cXVfZlFVOW9tdDN4NU10bmsuQUcubE0tblhIWHNLYnRHYnd4aFJLa1FDQzVXYk1LX2NqVV91cDc4TDZKS1RsdzdxeWFpeWFocF9pRktiUjhUb1hzZGNXNlphX01XZmRud1p6Q1EuM3BZZHdOcWVyU1B0emRrbEJCaTRhZy5RQTdVMEtCcG1OTUt5dk1kIiwiZXhwIjoxNjMyNDA1NzU0LCJpYXQiOjE2MzIzOTg1NTQsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.764HliB2R4ScoMeYPt7EJ3wOzhLSz1UkhCgCvWzWRbo', 'https://us05web.zoom.us/j/87357165002?pwd=L25qbm8zeElUOTlkZWkxM1crRlVCUT09', '6e5rgE', 30, '2021-10-08 11:05:52', NULL),
(1309, 'Table 3', 0, 1, 7, NULL, '15:30', '15:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/87598588621?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NzU5ODU4ODYyMSIsInN0ayI6IjlUemVvWm9KbTZoM0gyaVoxYjU5dUoxaElRdU16MHBvYjJvcFZYVVZ5c1UuQUcuUHpiWEhxaFBraHphSHpxNlg5YkdBckl6MVlncHQ0VXVDUkZvWlJwQ0V0c3JReGs5ejl6RmFVbGRLd1BFOTF6M09NWUdGSEFtTG5NbFJFSWEudWZQMjJGM21LREpfc0JPNlNzVXVyUS5lRWtvLUZ5WDU1OEZYWHRfIiwiZXhwIjoxNjMyNDA1NzU1LCJpYXQiOjE2MzIzOTg1NTUsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.rGp6TVY9n5E21ZOaXMwr0DmuKZuCQE_UGXQyYdd_c88', 'https://us05web.zoom.us/j/87598588621?pwd=MTJDTUc4b3lIbjVSbEkycXN0NURFdz09', 'xpXsp4', 30, '2021-10-08 11:05:52', NULL),
(1310, 'Table 3', 0, 1, 7, NULL, '16:00', '16:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/85191541338?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4NTE5MTU0MTMzOCIsInN0ayI6InZZdjlKcGVBYmJsRlE5RDZ6dHdkZ25nOWhqMV9fUW9PTW5TWUhLUGRQdmsuQUcudV9VLWJqSV96bUU4NEk4NUlkT2N2M1d0a2hSR0lSbDFxbG1NamhmVDZFaFpDYVlNcXJOVTl4SjFqYmFxNGhldXJwcTRiaXVvVUkyRlMzbDgueGQxT0F3eHhaNm9TNHltZkxfOEk3Zy5nbFBqMFBaem9CLVJWdXVJIiwiZXhwIjoxNjMyNDA1NzU2LCJpYXQiOjE2MzIzOTg1NTYsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.uhjoygM-b-E21lj6kAisg5OU-sAnkF7TUSwx7yktE8o', 'https://us05web.zoom.us/j/85191541338?pwd=SEF6dVROVkZOOUM0UEJxc1BHcmFJdz09', 'b9Ffvd', 30, '2021-10-08 11:05:52', NULL),
(1311, 'Table 3', 0, 1, 7, NULL, '16:30', '16:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/89404585520?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4OTQwNDU4NTUyMCIsInN0ayI6InFmdXB0TUZWLWxZM2d6amZ5U2VJQTlyUW1rOTZXc2NCcUNJaldoeDJUUE0uQUcuV3d6eDJNdWg2Vk9ENWg3Mk5WdDUzdnFNTnlha3l6bHMyRzg5dVJtNndFS1AyMGNPbENPTmJoeWRYbGc2WVJBSXVXZE9OdWdra0dCRkNZeGYuWnNyMkNwN1V5ZlJGekczZWlxSlEtZy5Qem5mQ1B4MmZvM3FrOVl2IiwiZXhwIjoxNjMyNDA1NzU3LCJpYXQiOjE2MzIzOTg1NTcsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.HcTQ5gPBlbiocjKavQtDXP2_lzoF7I5bTk7uuaPStXs', 'https://us05web.zoom.us/j/89404585520?pwd=Q3RzeG1rc0VhT21lMnp6YWthWG5zUT09', '8Hc3eU', 30, '2021-10-08 11:05:52', NULL),
(1312, 'Table 3', 0, 1, 7, NULL, '17:00', '17:00', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/82161080679?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MjE2MTA4MDY3OSIsInN0ayI6IlM4N2FjUW43MnZWQ256c0gzWWowSkJDOEstS2pwTW9acnB0TXFkdVlDNlUuQUcuMlA4TkdSY2NqeUFLVGsxTGhhOU1kMk51eC1aUlh0eWo4OW0wXzJLVWwyWGxZUnF0bllSeVJrY3FpVm1RRlo4Y29KdzJVVDU2U3dFem4zbXYuOWNiUEp5cW1VZXkzMGc3bGJCU1JKQS5qVGotM3VSTVpnYlZmOTlSIiwiZXhwIjoxNjMyNDA1NzU4LCJpYXQiOjE2MzIzOTg1NTgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.UHMVv9UFxEJmDYc5JnK7yW7c8-DBhYg7L_7OPYZxiHI', 'https://us05web.zoom.us/j/82161080679?pwd=SERZSnFiSHgrRXpJWi90Z1NXc2tpZz09', 'fi8SAi', 30, '2021-10-08 11:05:52', NULL),
(1313, 'Table 3', 0, 1, 7, NULL, '17:30', '17:30', '2021-10-08', 0, 0, 0, 0, 'https://us05web.zoom.us/s/81617523944?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4MTYxNzUyMzk0NCIsInN0ayI6Ink3Z1NnUGwzbnI3bXZCWGRaLVRINGRTYVFKOUl2VEI2MnMydVBiYm8yM0EuQUcuY3pzODN6UlRiVGFlVDJjcjQzSEFELUkzVzBQUG9ldVEtVnhra2tocGtjMVVNQURtNEdyU1JQc0t0ZXEzTWpITVJzVFNXeG1nTkZ1MzdJMmEuVHRjNDhxUjRkTGhuYUZUQ252SEVtdy5XOGhCb0xWZDNoSU1NODNfIiwiZXhwIjoxNjMyNDA1NzYwLCJpYXQiOjE2MzIzOTg1NjAsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ._f2gtj-dQc88Hlnxs1xG3Ezc_uRrBmVZ7iCWtFtMRXM', 'https://us05web.zoom.us/j/81617523944?pwd=VXlsRVB1WkQ0WU12WWxYSFB5NGxGZz09', 'r11yBt', 30, '2021-10-08 11:05:52', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `creneaux`
--

CREATE TABLE `creneaux` (
  `id` int(11) NOT NULL DEFAULT 0,
  `libelle_t` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_c` date NOT NULL,
  `heure_deb` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `heure_fin` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordre` int(11) DEFAULT NULL,
  `libre` tinyint(4) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `creneaux`
--

INSERT INTO `creneaux` (`id`, `libelle_t`, `date_c`, `heure_deb`, `heure_fin`, `ordre`, `libre`, `event_id`, `created_at`, `updated_at`, `status`) VALUES
(0, 'Table 1', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 1', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 1', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 1', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 1', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 1', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 1', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 2', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 2', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 2', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 2', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 2', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 2', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 2', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 3', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 3', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 3', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 3', '2020-01-30', '10.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 3', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 3', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 3', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 4', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 4', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 4', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 4', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 4', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 4', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 4', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 5', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 5', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 5', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 5', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 5', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 5', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 5', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 6', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 6', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 6', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 6', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 6', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 6', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 6', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 7', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 7', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 7', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 7', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 7', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 7', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 7', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 8', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 8', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 8', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 8', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 8', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 8', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 8', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 9', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 9', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 9', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 9', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 9', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 9', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 9', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 10', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 10', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 10', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 10', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 10', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 10', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 10', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 11', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 11', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 11', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 11', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 11', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 11', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 11', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 12', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 12', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 12', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 12', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 12', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 12', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 12', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 13', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 13', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 13', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 13', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 13', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 13', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 13', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 14', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 14', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 14', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 14', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 14', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 14', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 14', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 15', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 15', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 15', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 15', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 15', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 15', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 15', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 16', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 16', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 16', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 16', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 16', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 16', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 16', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 17', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 17', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 17', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 17', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 17', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 17', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 17', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 18', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 18', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 18', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 18', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 18', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 18', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 18', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 19', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 19', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 19', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 19', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 19', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 19', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 19', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 20', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 20', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 20', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 20', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 20', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 20', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 20', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 21', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 21', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 21', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 21', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 21', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 21', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 21', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 22', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 22', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 22', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 22', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 22', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 22', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 22', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 23', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 23', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 23', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 23', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 23', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 23', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 23', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 24', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 24', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 24', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 24', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 24', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 24', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 24', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 25', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 25', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 25', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 25', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 25', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 25', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 25', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 26', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 26', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 26', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 26', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 26', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 26', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 26', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 27', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 27', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 27', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 27', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 27', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 27', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 27', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 28', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 28', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 28', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 28', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 28', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 28', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 28', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 29', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 29', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 29', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 29', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 29', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 29', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 29', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 30', '2020-01-30', '14.30', '15.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 30', '2020-01-30', '15.00', '15.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 30', '2020-01-30', '15.30', '16.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 30', '2020-01-30', '16.00', '16.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 30', '2020-01-30', '16.30', '17.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 30', '2020-01-30', '17.00', '17.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 30', '2020-01-30', '17.30', '18.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 1', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 1', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 1', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 1', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 1', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 1', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 1', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 1', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 1', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 2', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 2', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 2', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 2', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 2', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 2', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 2', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 2', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 2', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 3', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 3', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 3', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 3', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 3', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 3', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 3', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 3', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 3', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 4', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 4', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 4', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 4', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 4', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 4', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 4', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 4', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 4', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 5', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 5', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 5', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 5', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 1', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 5', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 5', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 5', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 5', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 6', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 6', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 6', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 6', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 6', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 6', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 6', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 6', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 6', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 7', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 7', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 7', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 7', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 7', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 7', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 7', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 7', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 7', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 8', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 8', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 8', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 8', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 8', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 8', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 8', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 8', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 8', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 9', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 9', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 9', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 9', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 9', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 9', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 9', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 9', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 9', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 10', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 10', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 10', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 10', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 10', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 10', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 10', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 10', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 10', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 11', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 11', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 11', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 11', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 11', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 11', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 11', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 11', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 11', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 12', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 12', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 12', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 12', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 12', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 12', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 12', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 12', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 12', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 13', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 13', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 13', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 13', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 13', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 13', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 13', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 13', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 13', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 14', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 14', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 14', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 14', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 14', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 14', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 14', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 14', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 14', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 15', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 15', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 15', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 15', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 15', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 15', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 15', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 15', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 15', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 16', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 16', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 16', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 16', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 16', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 16', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 16', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 16', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 16', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 17', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 17', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 17', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 17', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 17', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 17', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 17', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 17', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 17', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 18', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 18', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 18', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 18', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 18', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 18', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 18', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 18', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 18', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 19', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 19', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 19', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 19', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 19', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 19', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 19', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 19', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 19', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 20', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 20', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 20', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 20', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 20', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 20', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 20', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 20', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 20', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 21', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 21', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 21', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 21', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 21', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 21', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 21', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 21', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 21', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 22', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 22', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 22', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 22', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 22', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 22', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 22', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 22', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 22', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 23', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 23', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 23', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 23', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 23', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 23', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 23', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 23', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 23', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 24', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 24', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 24', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 24', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 24', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 24', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 24', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 24', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 24', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 25', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 25', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 25', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 25', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 25', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 25', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 25', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 25', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 25', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 26', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 26', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 26', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 26', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 26', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 26', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 26', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 26', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 26', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 27', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 27', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 27', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 27', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 27', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 27', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 27', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 27', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 27', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 28', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 28', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 28', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 28', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 28', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 28', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 28', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 28', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 28', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0);
INSERT INTO `creneaux` (`id`, `libelle_t`, `date_c`, `heure_deb`, `heure_fin`, `ordre`, `libre`, `event_id`, `created_at`, `updated_at`, `status`) VALUES
(0, 'Table 29', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 29', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 29', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 29', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 29', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 29', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 29', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 29', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 29', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 30', '2020-01-31', '09.00', '09.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 30', '2020-01-31', '09.30', '10.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 30', '2020-01-31', '10.00', '10.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 30', '2020-01-31', '10.30', '11.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 30', '2020-01-31', '11.00', '11.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 30', '2020-01-31', '11.30', '12.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 30', '2020-01-31', '12.00', '12.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 30', '2020-01-31', '12.30', '13.00', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0),
(0, 'Table 30', '2020-01-31', '13.00', '13.30', 1, 0, NULL, '2020-02-02 14:33:45', '2020-02-02 14:33:45', 0);

-- --------------------------------------------------------

--
-- Structure de la table `demande_b2gs`
--

CREATE TABLE `demande_b2gs` (
  `id` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `dificulte1` varchar(255) DEFAULT NULL,
  `dificulte2` varchar(255) DEFAULT NULL,
  `dificulte3` varchar(255) DEFAULT NULL,
  `aide` text DEFAULT NULL,
  `details` text DEFAULT NULL,
  `date` date DEFAULT NULL,
  `heure_deb` varchar(255) DEFAULT NULL,
  `heure_fin` varchar(255) DEFAULT NULL,
  `statut` tinyint(4) DEFAULT 0,
  `participant_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `demande_b2gs`
--

INSERT INTO `demande_b2gs` (`id`, `updated_at`, `dificulte1`, `dificulte2`, `dificulte3`, `aide`, `details`, `date`, `heure_deb`, `heure_fin`, `statut`, `participant_id`, `created_at`) VALUES
(1, '2022-08-30 13:22:54', 'Besoin d\'investissement', NULL, NULL, 'Avec de l\'investissement', 'Ministère de l\'éducation', NULL, NULL, NULL, 1, 351, '2022-08-30 11:21:43'),
(2, '2022-09-02 09:30:56', 'Besoin d\'investissement', NULL, NULL, 'Offre d\'emploi', 'Ministère de l\'éducation', NULL, NULL, NULL, 1, 355, '2022-09-02 07:26:37');

-- --------------------------------------------------------

--
-- Structure de la table `entreprises`
--

CREATE TABLE `entreprises` (
  `id` int(11) NOT NULL,
  `nom_entreprise` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `tel_entreprise` varchar(255) DEFAULT NULL,
  `email_entreprise` varchar(255) DEFAULT NULL,
  `site` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `produit_id` varchar(255) DEFAULT NULL,
  `autre_secteur` varchar(255) DEFAULT NULL,
  `participant_id` int(11) DEFAULT NULL,
  `secteur_a` varchar(255) DEFAULT NULL,
  `secteur_b` varchar(255) DEFAULT NULL,
  `secteur_c` varchar(255) DEFAULT NULL,
  `secteur_activite_rechercher` varchar(250) DEFAULT NULL,
  `profile_entreprise_rechercher` varchar(250) DEFAULT NULL,
  `profile_entreprise_a` varchar(255) DEFAULT NULL,
  `profile_entreprise_b` varchar(255) DEFAULT NULL,
  `profile_entreprise_c` varchar(255) DEFAULT NULL,
  `partenaire_rechercher` varchar(255) DEFAULT NULL,
  `partenaire_rencontrer_a` varchar(255) DEFAULT NULL,
  `partenaire_rencontrer_b` varchar(255) DEFAULT NULL,
  `partenaire_rencontrer_c` varchar(255) DEFAULT NULL,
  `profile_partenaire_rechercher_a` varchar(255) DEFAULT NULL,
  `profile_partenaire_rechercher_b` varchar(255) DEFAULT NULL,
  `profile_partenaire_rechercher_c` varchar(255) DEFAULT NULL,
  `rendez_vous` varchar(255) DEFAULT NULL,
  `b2g` tinyint(4) DEFAULT 0,
  `secteur_activite_id` int(11) DEFAULT NULL,
  `pay_id` int(11) DEFAULT NULL,
  `pays` varchar(255) DEFAULT NULL,
  `activite_id` int(11) DEFAULT NULL,
  `profil_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `delege` int(11) DEFAULT NULL,
  `autre_participant` tinyint(1) DEFAULT 0,
  `event_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL,
  `alliance_rechercher` varchar(255) DEFAULT NULL,
  `zone_geographie` varchar(255) DEFAULT NULL,
  `langue` varchar(255) DEFAULT NULL,
  `slogan` varchar(255) DEFAULT NULL,
  `photos` varchar(255) DEFAULT 'placeholder.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `entreprises`
--

INSERT INTO `entreprises` (`id`, `nom_entreprise`, `adresse`, `tel_entreprise`, `email_entreprise`, `site`, `description`, `produit_id`, `autre_secteur`, `participant_id`, `secteur_a`, `secteur_b`, `secteur_c`, `secteur_activite_rechercher`, `profile_entreprise_rechercher`, `profile_entreprise_a`, `profile_entreprise_b`, `profile_entreprise_c`, `partenaire_rechercher`, `partenaire_rencontrer_a`, `partenaire_rencontrer_b`, `partenaire_rencontrer_c`, `profile_partenaire_rechercher_a`, `profile_partenaire_rechercher_b`, `profile_partenaire_rechercher_c`, `rendez_vous`, `b2g`, `secteur_activite_id`, `pay_id`, `pays`, `activite_id`, `profil_id`, `user_id`, `delege`, `autre_participant`, `event_id`, `created_at`, `updated_at`, `alliance_rechercher`, `zone_geographie`, `langue`, `slogan`, `photos`) VALUES
(1, 'Cabinet TTC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'TIC et innovation / ICT and innovation', NULL, NULL, NULL, NULL, 'Prestataire de services', NULL, NULL, 'je suis a la recherche de PTF', 'TIC et innovation / ICT and innovation', 'Industrie textile / Textile Industry', 'Services aux entreprises / Business services', 'Technologie / Technology', NULL, NULL, 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 724, NULL, 1, 12, '2021-10-21 09:20:50', '2021-10-21 09:20:50', NULL, NULL, NULL, NULL, 'placeholder.png'),
(2, 'YOSR SERVICE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'TIC et innovation / ICT and innovation', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Services aux entreprises / Business services', NULL, NULL, 'Technologie / Technology', NULL, NULL, 'ras', 'Services aux entreprises / Business services', 'TIC et innovation / ICT and innovation', NULL, 'Technologie / Technology', 'Importateur / Importer', NULL, 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 732, NULL, 0, 12, '2021-10-21 19:15:25', '2021-10-21 19:15:25', NULL, NULL, NULL, NULL, 'placeholder.png'),
(3, 'ABS International SARL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Services aux entreprises / Business services', 'BTP / Construction and public works', NULL, NULL, 'Consultant / Consultant', 'Distributeur / Distributor', 'Fabricant / Manufacturer', 'Je suis à la recherche de partenaires techniques et financiers', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Services aux entreprises / Business services', 'Industrie textile / Textile Industry', 'Investisseur / Investor', 'Partenaire Technique / Technical Partner', 'Partenaire Institutionnel / Institutionnal Partner', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 733, NULL, 0, 12, '2021-10-21 20:15:02', '2021-10-21 20:15:02', NULL, NULL, NULL, NULL, 'placeholder.png'),
(4, 'Unité de Tissage du Gulmu', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'TIC et innovation / ICT and innovation', NULL, NULL, 'Importateur / Importer', 'Distributeur / Distributor', 'Investisseur / Investor', NULL, 'Industrie textile / Textile Industry', 'Services aux entreprises / Business services', 'Distribution / Distribution', 'Distributeur / Distributor', 'Importateur / Importer', 'Partenaire Technique / Technical Partner', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 734, NULL, 0, 12, '2021-10-21 20:26:01', '2021-10-21 20:26:01', NULL, NULL, NULL, NULL, 'placeholder.png'),
(5, 'Burkina Build Center', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'BTP / Construction and public works', 'Energie / Energy', 'Industrie manufacturière / Manufacturing industry', NULL, NULL, 'Investisseur / Investor', 'Partenaire Institutionnel / Institutionnal Partner', 'Distributeur / Distributor', 'Institutions d\'accompagnement financier', 'BTP / Construction and public works', 'Industrie manufacturière / Manufacturing industry', 'Energie / Energy', 'Investisseur / Investor', 'Distributeur / Distributor', 'Partenaire Institutionnel / Institutionnal Partner', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 736, NULL, 0, 12, '2021-10-21 21:38:04', '2021-10-21 21:38:04', NULL, NULL, NULL, NULL, 'placeholder.png'),
(7, 'GOUBA AVOCATS- LAW FIRM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Autres / Others', NULL, NULL, NULL, NULL, 'Consultant / Consultant', NULL, NULL, 'Les entreprises étrangères qui veulent investir au Burkina et les entreprises installées au Burkina et qui ont besoin d\'un accompagnement juridique et fiscal d\'un cabinet d\'avocats.', 'Industrie textile / Textile Industry', 'Energie / Energy', 'TIC et innovation / ICT and innovation', 'Investisseur / Investor', 'Investisseur / Investor', 'Investisseur / Investor', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 740, NULL, 0, 12, '2021-10-22 08:05:09', '2021-10-22 08:05:09', NULL, NULL, NULL, NULL, 'placeholder.png'),
(8, 'EAI SARL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Energie / Energy', 'BTP / Construction and public works', NULL, NULL, NULL, 'Prestataire de services', NULL, NULL, 'Nous recherchons des investisseurs , partenaires techniques ou fabricant dans le domaine de l\'industrie textile', 'Industrie textile / Textile Industry', 'BTP / Construction and public works', NULL, 'Investisseur / Investor', 'Partenaire Technique / Technical Partner', 'Fabricant / Manufacturer', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 743, NULL, 0, 12, '2021-10-22 12:32:49', '2021-10-22 12:32:49', NULL, NULL, NULL, NULL, 'placeholder.png'),
(9, 'Cabinet Ammani Consulting Group SARL', NULL, '00226 58 77 77 53 (Watsapp)', NULL, NULL, NULL, NULL, NULL, NULL, 'Services aux entreprises / Business services', 'Services aux entreprises / Business services', 'Services aux entreprises / Business services', NULL, NULL, 'Consultant / Consultant', 'Consultant / Consultant', 'Consultant / Consultant', 'Nous voulons des partenariats avec des entreprises qui veulent un accompagnement en matière d\'assistance comptable et fiscale, de formation , d’études de marchés , de montage de projets , de suivi-évaluation et de création et développement d\'entreprise', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'BTP / Construction and public works', 'Transport & Logistique / Transportation and Logistics', 'Investisseur / Investor', 'Importateur / Importer', 'Sous-traitant / Subcontractor', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 745, NULL, 0, 12, '2021-10-22 13:11:54', '2021-10-22 13:11:54', NULL, NULL, NULL, 'La compétence au service du developpement de votre entreprise', 'logo[1].jpg'),
(10, 'SOCIETE KOYAMGA DISTRIBUTION', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Distribution / Distribution', 'Distribution / Distribution', 'Distribution / Distribution', NULL, NULL, 'Distributeur / Distributor', 'Distributeur / Distributor', 'Distributeur / Distributor', 'Besoin de fabricant souhaitant faire représenter sa marque au Burkina par un distributeur exclusif.', 'Biens de consommation / Consumption Goods', 'Biens de consommation / Consumption Goods', 'Biens de consommation / Consumption Goods', 'Fabricant / Manufacturer', 'Fabricant / Manufacturer', 'Fabricant / Manufacturer', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 747, NULL, 0, 12, '2021-10-22 16:28:30', '2021-10-22 16:28:30', NULL, NULL, NULL, NULL, 'placeholder.png'),
(11, 'INERA Programme Coton', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Environnement / Environment', 'Industrie textile / Textile Industry', NULL, NULL, 'Partenaire Technique / Technical Partner', 'Partenaire Technique / Technical Partner', 'Partenaire Technique / Technical Partner', 'Activités de recherche sur le coton biologique', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Partenaire Technique / Technical Partner', 'Partenaire Technique / Technical Partner', 'Partenaire Technique / Technical Partner', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 750, NULL, 0, 12, '2021-10-22 21:59:02', '2021-10-22 21:59:02', NULL, NULL, NULL, NULL, 'placeholder.png'),
(12, 'Pro-etole trading', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Distribution / Distribution', 'Services aux entreprises / Business services', 'Autres / Others', NULL, NULL, 'Distributeur / Distributor', 'Importateur / Importer', 'Importateur / Importer', 'Partenariat', 'Distribution / Distribution', 'Distribution / Distribution', 'Distribution / Distribution', 'Distributeur / Distributor', 'Importateur / Importer', 'Importateur / Importer', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 753, NULL, 0, 12, '2021-10-23 07:08:39', '2021-10-23 07:08:39', NULL, NULL, NULL, NULL, 'placeholder.png'),
(13, 'Zam Zam production', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Services aux entreprises / Business services', 'Services aux entreprises / Business services', 'Services aux entreprises / Business services', NULL, NULL, 'Prestataire de services', 'Prestataire de services', 'Prestataire de services', 'Accompagnement technique et financière pour mon entreprise culturel', 'Services aux entreprises / Business services', 'Services aux entreprises / Business services', 'Services aux entreprises / Business services', 'Partenaire Institutionnel / Institutionnal Partner', 'Partenaire Institutionnel / Institutionnal Partner', 'Consultant / Consultant', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 754, NULL, 0, 12, '2021-10-23 07:43:30', '2021-10-23 07:43:30', NULL, NULL, NULL, NULL, 'placeholder.png'),
(14, 'Ouaga Flash Média', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Services aux entreprises / Business services', 'TIC et innovation / ICT and innovation', 'TIC et innovation / ICT and innovation', NULL, NULL, 'Technologie / Technology', 'Consultant / Consultant', 'Autres / Others', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 757, NULL, 0, 12, '2021-10-23 09:57:44', '2021-10-23 11:57:44', NULL, NULL, NULL, NULL, 'placeholder.png'),
(15, 'MUSIK UNIVERS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Tourisme / Tourism', 'Distribution / Distribution', NULL, NULL, 'Fabricant / Manufacturer', 'Distributeur / Distributor', NULL, 'Le coton médical', 'Activités médicales et pharmaceutiques / Medical and pharmaceutical activities', 'Industrie textile / Textile Industry', NULL, 'Fabricant / Manufacturer', 'Partenaire Institutionnel / Institutionnal Partner', NULL, 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 760, NULL, 1, 12, '2021-10-23 23:52:38', '2021-10-23 23:52:38', NULL, NULL, NULL, NULL, 'placeholder.png'),
(16, 'Université Joseph KI-ZERBO/IGEDD', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Environnement / Environment', 'Energie / Energy', 'Agriculture et agro-alimentaire / Agriculture and food processing', NULL, NULL, 'Consultant / Consultant', 'Partenaire Technique / Technical Partner', 'Prestataire de services', 'Des partenaires qui peuvent nous accompagner dans la technologie, l\'investissement ou dans le renforcement institutionnel.', 'Environnement / Environment', 'Industrie textile / Textile Industry', 'Energie / Energy', 'Investisseur / Investor', 'Technologie / Technology', 'Partenaire Technique / Technical Partner', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 761, NULL, 1, 12, '2021-10-25 09:00:04', '2021-10-25 09:00:04', NULL, NULL, NULL, NULL, 'placeholder.png'),
(17, 'OTHENTIC DESIGN', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Distribution / Distribution', NULL, NULL, NULL, 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Importateur / Importer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 765, NULL, 1, 12, '2021-10-25 13:04:42', '2021-10-25 15:04:42', NULL, NULL, NULL, NULL, 'placeholder.png'),
(18, 'Clo Design', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', NULL, NULL, NULL, 'Fabricant / Manufacturer', 'Distributeur / Distributor', NULL, 'Nous recherchons des investisseurs pour nos permettre d\'aborder toutes les activités prevues de l\'entreprise', 'Tourisme / Tourism', 'Distribution / Distribution', 'Transport & Logistique / Transportation and Logistics', 'Investisseur / Investor', 'Distributeur / Distributor', 'Partenaire Technique / Technical Partner', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 776, NULL, 1, 12, '2021-10-30 12:14:24', '2021-10-30 12:14:24', NULL, NULL, NULL, NULL, 'placeholder.png'),
(19, 'Entrprise  FASO/NAFA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Artisanat / Arts and crafts', 'Services aux entreprises / Business services', NULL, NULL, 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Prestataire de services', '- partenariat en export/import\r\n- écoulement de nos produits a l’intérieur et a l extérieure\r\n- financement pour la matière première\r\n-  technologie', NULL, NULL, NULL, 'Importateur / Importer', 'Technologie / Technology', 'Prestataire de services', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 777, NULL, 1, 12, '2021-11-02 13:22:31', '2021-11-02 13:22:31', NULL, NULL, NULL, NULL, 'placeholder.png'),
(20, 'UbiLearning', NULL, '0022676234666', NULL, 'www.ubilearning.org', NULL, NULL, NULL, NULL, 'TIC et innovation / ICT and innovation', 'Services aux entreprises / Business services', 'TIC et innovation / ICT and innovation', NULL, NULL, 'Consultant / Consultant', 'Prestataire de services', 'Consultant / Consultant', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SANS un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 793, NULL, 1, 12, '2021-11-05 20:08:01', '2021-11-05 20:08:01', NULL, NULL, NULL, 'Learn and Teach a Language anywhere anytime', 'logo Ubilearning.jpg'),
(21, 'Soie&coton', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Distribution / Distribution', NULL, NULL, NULL, 'Fabricant / Manufacturer', 'Distributeur / Distributor', NULL, NULL, 'Industrie textile / Textile Industry', 'Industrie manufacturière / Manufacturing industry', NULL, 'Investisseur / Investor', 'Distributeur / Distributor', NULL, 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 820, NULL, 0, 12, '2021-11-06 19:31:45', '2021-11-06 19:31:45', NULL, NULL, NULL, NULL, 'placeholder.png'),
(22, 'Aktan Misr Textile & Dyeing S.A.E', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', NULL, NULL, NULL, NULL, 'Fabricant / Manufacturer', NULL, NULL, 'I need a cotton and yarn suppliers.', 'Industrie textile / Textile Industry', 'Industrie manufacturière / Manufacturing industry', 'Transport & Logistique / Transportation and Logistics', 'Fabricant / Manufacturer', NULL, NULL, 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Egypte', NULL, NULL, 821, NULL, 0, 12, '2021-11-07 11:46:01', '2021-11-07 11:46:01', NULL, NULL, NULL, NULL, 'placeholder.png'),
(23, 'Secrétariat Permanent de la Filière Coton Libéralisée', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Autres / Others', 'Industrie textile / Textile Industry', NULL, NULL, NULL, 'Partenaire Institutionnel / Institutionnal Partner', NULL, NULL, 'Investisseurs et porteurs de projets textiles', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Investisseur / Investor', 'Consultant / Consultant', 'Partenaire Technique / Technical Partner', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 822, NULL, 0, 12, '2021-11-07 16:33:10', '2021-11-07 16:33:10', NULL, NULL, NULL, NULL, 'placeholder.png'),
(24, 'TIERIS FASHION / NAKONI CRÉATION', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', NULL, NULL, NULL, 'Fabricant / Manufacturer', 'Distributeur / Distributor', NULL, 'Nous recherchons des partenaires évoluant dans le domaine du textile / tissage ou ayant un besoin des produits issus de ce domaine d\'activité.', 'Industrie textile / Textile Industry', 'Tourisme / Tourism', 'Artisanat / Arts and crafts', 'Distributeur / Distributor', 'Partenaire Technique / Technical Partner', 'Partenaire Institutionnel / Institutionnal Partner', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 809, NULL, 1, 12, '2021-11-07 20:46:32', '2021-11-07 20:46:32', NULL, NULL, NULL, NULL, 'placeholder.png'),
(25, 'O\'shine', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Distribution / Distribution', NULL, NULL, 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Prestataire de services', 'Structure d\'accompagnement, structure de financement, des investisseurs, des distributeurs internationaux', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Services aux entreprises / Business services', 'Investisseur / Investor', 'Partenaire Technique / Technical Partner', 'Importateur / Importer', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 824, NULL, 0, 12, '2021-11-08 21:40:46', '2021-11-08 21:40:46', NULL, NULL, NULL, NULL, 'placeholder.png'),
(26, 'Compagnie Malienne pour le Développement des Textiles (CMDT)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', NULL, NULL, 'Autres / Others', 'Partenaire Technique / Technical Partner', 'Autres / Others', 'Clients fibre de coton', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Environnement / Environment', 'Services aux entreprises / Business services', 'Investisseur / Investor', 'Partenaire Technique / Technical Partner', 'Autres / Others', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Mali', NULL, NULL, 828, NULL, 0, 12, '2021-11-13 18:45:39', '2021-11-13 18:45:39', NULL, NULL, NULL, NULL, 'placeholder.png'),
(27, 'Assemblée Permanente des chambres de métiers du Mali', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Autres / Others', 'Autres / Others', 'Artisanat / Arts and crafts', NULL, NULL, 'Partenaire Institutionnel / Institutionnal Partner', 'Partenaire Institutionnel / Institutionnal Partner', 'Partenaire Institutionnel / Institutionnal Partner', 'Les investisseurs et les organisateurs pour un partage d\'expérience', 'Artisanat / Arts and crafts', 'Industrie textile / Textile Industry', 'Distribution / Distribution', 'Investisseur / Investor', 'Fabricant / Manufacturer', 'Partenaire Institutionnel / Institutionnal Partner', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Mali', NULL, NULL, 832, NULL, 1, 12, '2021-11-15 09:02:45', '2021-11-15 09:02:45', NULL, NULL, NULL, NULL, 'placeholder.png'),
(28, 'Saint-joe création', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Distribution / Distribution', 'Artisanat / Arts and crafts', NULL, NULL, 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Autres / Others', 'Des investisseurs et distributeurs de vêtements', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Distribution / Distribution', 'Partenaire Technique / Technical Partner', 'Distributeur / Distributor', 'Investisseur / Investor', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Côte d\'Ivoire', NULL, NULL, 837, NULL, 0, 12, '2021-11-15 14:33:23', '2021-11-15 14:33:23', NULL, NULL, NULL, NULL, 'placeholder.png'),
(29, 'Patheo couture', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Distribution / Distribution', NULL, NULL, 'Investisseur / Investor', 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Créateur, modéliste et distributeurs', 'Distribution / Distribution', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Investisseur / Investor', 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Côte d\'Ivoire', NULL, NULL, 838, NULL, 0, 12, '2021-11-15 15:34:23', '2021-11-15 15:34:23', NULL, NULL, NULL, NULL, 'placeholder.png'),
(30, 'Flori-Art', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Artisanat / Arts and crafts', NULL, NULL, 'Fabricant / Manufacturer', 'Innovation, R&D / Innovation, R&D', 'Fabricant / Manufacturer', NULL, 'Distribution / Distribution', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Distributeur / Distributor', 'Importateur / Importer', 'Partenaire Institutionnel / Institutionnal Partner', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 784, NULL, 0, 12, '2021-11-16 11:55:22', '2021-11-16 11:55:22', NULL, NULL, NULL, NULL, 'placeholder.png'),
(31, 'Sanga D', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Autres / Others', 'Autres / Others', 'Autres / Others', NULL, NULL, 'Fabricant / Manufacturer', 'Fabricant / Manufacturer', 'Fabricant / Manufacturer', 'Distribution de prêt à porté', 'Industrie textile / Textile Industry', 'Distribution / Distribution', 'Autres / Others', 'Investisseur / Investor', 'Partenaire Technique / Technical Partner', NULL, 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 839, NULL, 1, 12, '2021-11-16 12:51:08', '2021-11-16 12:51:08', NULL, NULL, NULL, NULL, 'placeholder.png'),
(32, 'Ambassade', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Autres / Others', 'Autres / Others', 'Autres / Others', NULL, NULL, 'Partenaire Institutionnel / Institutionnal Partner', 'Partenaire Institutionnel / Institutionnal Partner', 'Partenaire Institutionnel / Institutionnal Partner', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SANS un planning B 2 B', NULL, NULL, NULL, 'Côte d\'Ivoire', NULL, NULL, 842, NULL, 0, 12, '2021-11-16 19:06:42', '2021-11-16 20:06:42', NULL, NULL, NULL, NULL, 'placeholder.png'),
(33, 'Ambassade du Burkina Faso en côte d\'ivoire', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Autres / Others', 'Autres / Others', 'Autres / Others', NULL, NULL, 'Partenaire Institutionnel / Institutionnal Partner', 'Autres / Others', 'Partenaire Institutionnel / Institutionnal Partner', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SANS un planning B 2 B', NULL, NULL, NULL, 'Côte d\'Ivoire', NULL, NULL, 843, NULL, 0, 12, '2021-11-16 19:14:18', '2021-11-16 20:14:18', NULL, NULL, NULL, NULL, 'placeholder.png'),
(34, 'Ajc.bf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Autres / Others', 'Autres / Others', 'Autres / Others', NULL, NULL, 'Autres / Others', 'Autres / Others', 'Autres / Others', 'Appuie financière pour obtention des matériaux de couture et formation en perfection pour notre association', 'Industrie textile / Textile Industry', 'Industrie textile / Textile Industry', 'Industrie textile / Textile Industry', 'Investisseur / Investor', 'Partenaire Technique / Technical Partner', 'Fabricant / Manufacturer', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 844, NULL, 0, 12, '2021-11-17 13:21:50', '2021-11-17 13:21:50', NULL, NULL, NULL, NULL, 'placeholder.png'),
(35, 'Association des Jeunes pour la Valorisation de la Cotonnade', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Autres / Others', 'Autres / Others', 'Autres / Others', NULL, NULL, 'Partenaire Technique / Technical Partner', 'Autres / Others', 'Autres / Others', 'des investisseurs et des donneurs d\'ordre', 'Distribution / Distribution', 'Artisanat / Arts and crafts', 'Industrie textile / Textile Industry', 'Partenaire Institutionnel / Institutionnal Partner', 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Mali', NULL, NULL, 845, NULL, 0, 12, '2021-11-18 15:33:28', '2021-11-18 15:33:28', NULL, NULL, NULL, NULL, 'placeholder.png'),
(36, 'INTERCOTON', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Distribution / Distribution', 'Autres / Others', NULL, NULL, 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Autres / Others', 'Égrenage de coton et commercialisation', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Distribution / Distribution', 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Autres / Others', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Côte d\'Ivoire', NULL, NULL, 846, NULL, 0, 12, '2021-11-18 16:04:05', '2021-11-18 16:04:05', NULL, NULL, NULL, NULL, 'placeholder.png'),
(37, 'Conseil coton anacarde', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Distribution / Distribution', NULL, NULL, 'Fabricant / Manufacturer', 'Partenaire Institutionnel / Institutionnal Partner', 'Autres / Others', 'Investisseurs dans le domaine du coton, du textile et de l\'anacarde', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Industrie textile / Textile Industry', 'Industrie manufacturière / Manufacturing industry', 'Investisseur / Investor', 'Partenaire Institutionnel / Institutionnal Partner', 'Fabricant / Manufacturer', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Côte d\'Ivoire', NULL, NULL, 847, NULL, 0, 12, '2021-11-19 11:55:32', '2021-11-19 11:55:32', NULL, NULL, NULL, NULL, 'placeholder.png'),
(38, 'Association des Stilystes modélistes de Côte d\'Ivoire', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Autres / Others', NULL, NULL, 'Fabricant / Manufacturer', 'Prestataire de services', 'Autres / Others', 'Partenaire financier et investisseur', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Distribution / Distribution', 'Fabricant / Manufacturer', 'Partenaire Technique / Technical Partner', 'Fabricant / Manufacturer', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Côte d\'Ivoire', NULL, NULL, 848, NULL, 0, 12, '2021-11-19 12:12:29', '2021-11-19 12:12:29', NULL, NULL, NULL, NULL, 'placeholder.png'),
(39, 'AGROPROCESS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Industrie textile / Textile Industry', 'Distribution / Distribution', NULL, NULL, 'Fabricant / Manufacturer', 'Investisseur / Investor', 'Partenaire Technique / Technical Partner', 'PARTENAIRE INSTITUTIONNEL POUR INVESTIR DANS LE COTON', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Industrie textile / Textile Industry', 'Autres / Others', 'Partenaire Institutionnel / Institutionnal Partner', 'Fabricant / Manufacturer', 'Autres / Others', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Côte d\'Ivoire', NULL, NULL, 849, NULL, 0, 12, '2021-11-19 12:24:20', '2021-11-19 12:24:20', NULL, NULL, NULL, NULL, 'placeholder.png'),
(40, 'FAUSTO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Distribution / Distribution', 'Autres / Others', 'Autres / Others', NULL, NULL, 'Distributeur / Distributor', 'Sous-traitant / Subcontractor', 'Autres / Others', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SANS un planning B 2 B', NULL, NULL, NULL, 'Mali', NULL, NULL, 850, NULL, 0, 12, '2021-11-19 11:30:54', '2021-11-19 12:30:54', NULL, NULL, NULL, NULL, 'placeholder.png'),
(41, 'Marubeni Corporation', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Industrie manufacturière / Manufacturing industry', 'Energie / Energy', NULL, NULL, 'Investisseur / Investor', 'Fabricant / Manufacturer', 'Prestataire de services', 'je souhaite des échanges avec les partenaires institutionnels pour investir dans l’énergie ou le coton', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Industrie textile / Textile Industry', 'Energie / Energy', 'Partenaire Institutionnel / Institutionnal Partner', 'Fabricant / Manufacturer', 'Autres / Others', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Afrique du Sud', NULL, NULL, 851, NULL, 0, 12, '2021-11-19 12:59:00', '2021-11-19 12:59:00', NULL, NULL, NULL, NULL, 'placeholder.png'),
(42, 'ALIAKBAR GROUP', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Distribution / Distribution', 'Autres / Others', NULL, NULL, 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Prestataire de services', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SANS un planning B 2 B', NULL, NULL, NULL, 'Pakistan', NULL, NULL, 852, NULL, 0, 12, '2021-11-19 12:18:27', '2021-11-19 13:18:27', NULL, NULL, NULL, NULL, 'placeholder.png'),
(43, 'Ftusa', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Autres / Others', NULL, NULL, 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Autres / Others', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SANS un planning B 2 B', NULL, NULL, NULL, 'Tunisie', NULL, NULL, 853, NULL, 0, 12, '2021-11-19 13:42:05', '2021-11-19 14:42:05', NULL, NULL, NULL, NULL, 'placeholder.png'),
(44, 'Centre de Devéloppement de l\'Artisanat Textile', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Artisanat / Arts and crafts', 'Artisanat / Arts and crafts', 'Artisanat / Arts and crafts', NULL, NULL, 'Partenaire Institutionnel / Institutionnal Partner', 'Partenaire Institutionnel / Institutionnal Partner', 'Partenaire Institutionnel / Institutionnal Partner', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SANS un planning B 2 B', NULL, NULL, NULL, 'Mali', NULL, NULL, 854, NULL, 0, 12, '2021-11-19 13:48:53', '2021-11-19 14:48:53', NULL, NULL, NULL, NULL, 'placeholder.png'),
(45, 'Sft', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Distribution / Distribution', 'Industrie manufacturière / Manufacturing industry', NULL, NULL, 'Fabricant / Manufacturer', 'Investisseur / Investor', 'Importateur / Importer', '1.specialiste dans la production d accessoire médicaux à base de coton\r\n2.fabricant d unité de production  de coton medical', 'Industrie textile / Textile Industry', 'Industrie manufacturière / Manufacturing industry', 'Services aux entreprises / Business services', 'Consultant / Consultant', 'Fabricant / Manufacturer', 'Partenaire Technique / Technical Partner', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Côte d\'Ivoire', NULL, NULL, 855, NULL, 0, 12, '2021-11-21 14:14:56', '2021-11-21 14:14:56', NULL, NULL, NULL, NULL, 'placeholder.png'),
(46, 'Textile Engineer Expert-Consultant', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Services aux entreprises / Business services', 'Autres / Others', 'Autres / Others', NULL, NULL, 'Consultant / Consultant', 'Prestataire de services', 'Autres / Others', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SANS un planning B 2 B', NULL, NULL, NULL, 'Maroc', NULL, NULL, 858, NULL, 0, 12, '2021-11-23 15:53:40', '2021-11-23 16:53:40', NULL, NULL, NULL, NULL, 'placeholder.png'),
(47, 'LUMIERE COUTURE', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Distribution / Distribution', 'Autres / Others', NULL, NULL, 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Autres / Others', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SANS un planning B 2 B', NULL, NULL, NULL, 'Mali', NULL, NULL, 859, NULL, 1, 12, '2021-11-24 10:45:55', '2021-11-24 11:45:55', NULL, NULL, NULL, NULL, 'placeholder.png'),
(48, 'Couture Mixte', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Autres / Others', 'Autres / Others', 'Distribution / Distribution', NULL, NULL, 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Autres / Others', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SANS un planning B 2 B', NULL, NULL, NULL, 'Mali', NULL, NULL, 860, NULL, 0, 12, '2021-11-24 10:50:50', '2021-11-24 11:50:50', NULL, NULL, NULL, NULL, 'placeholder.png'),
(49, 'APCMM', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Autres / Others', NULL, NULL, NULL, NULL, 'Partenaire Institutionnel / Institutionnal Partner', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SANS un planning B 2 B', NULL, NULL, NULL, 'Mali', NULL, NULL, 861, NULL, 0, 12, '2021-11-24 14:06:30', '2021-11-24 15:06:30', NULL, NULL, NULL, NULL, 'placeholder.png'),
(50, 'Gherzi Textil Organisation AG', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', NULL, NULL, NULL, NULL, 'Consultant / Consultant', NULL, NULL, NULL, 'Industrie textile / Textile Industry', NULL, NULL, 'Partenaire Institutionnel / Institutionnal Partner', 'Partenaire Technique / Technical Partner', 'Investisseur / Investor', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Suisse', NULL, NULL, 867, NULL, 0, 12, '2021-11-26 13:38:04', '2021-11-26 13:38:04', NULL, NULL, NULL, NULL, 'placeholder.png'),
(51, 'Université Joseph Ki-Zerbo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Autres / Others', NULL, NULL, NULL, NULL, 'Innovation, R&D / Innovation, R&D', 'Consultant / Consultant', 'Partenaire Institutionnel / Institutionnal Partner', 'Recherche scientifique', 'Autres / Others', NULL, NULL, 'Consultant / Consultant', 'Innovation, R&D / Innovation, R&D', 'Partenaire Institutionnel / Institutionnal Partner', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 870, NULL, 1, 12, '2021-11-26 14:55:11', '2021-11-26 14:55:11', NULL, NULL, NULL, NULL, 'placeholder.png'),
(52, 'SAHA ART', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Artisanat / Arts and crafts', 'Industrie textile / Textile Industry', 'Distribution / Distribution', NULL, NULL, 'Fabricant / Manufacturer', 'Prestataire de services', 'Partenaire Technique / Technical Partner', 'Nous souhaitons partager les experiences en matiere de vente internationale en ligne avec des partenaires .', 'Artisanat / Arts and crafts', 'Industrie textile / Textile Industry', 'Distribution / Distribution', 'Consultant / Consultant', 'Partenaire Technique / Technical Partner', 'Investisseur / Investor', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 874, NULL, 0, 12, '2021-11-26 19:47:45', '2021-11-26 19:47:45', NULL, NULL, NULL, NULL, 'placeholder.png'),
(53, 'MADIRO INTER', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie manufacturière / Manufacturing industry', 'TIC et innovation / ICT and innovation', 'Industrie textile / Textile Industry', NULL, NULL, 'Investisseur / Investor', 'Distributeur / Distributor', 'Investisseur / Investor', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 875, NULL, 1, 12, '2021-11-26 22:12:04', '2021-11-26 23:12:04', NULL, NULL, NULL, NULL, 'placeholder.png'),
(54, 'Take iT with Zama', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Biens de consommation / Consumption Goods', NULL, NULL, 'Fabricant / Manufacturer', 'Prestataire de services', 'Innovation, R&D / Innovation, R&D', 'Nous souhaitons avoir des partenaires qui entrent dans le capital de l\'entreprise.', 'Artisanat / Arts and crafts', 'Distribution / Distribution', 'Services aux entreprises / Business services', 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Partenaire Technique / Technical Partner', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 878, NULL, 0, 12, '2021-11-27 09:55:27', '2021-11-27 09:55:27', NULL, NULL, NULL, NULL, 'placeholder.png'),
(55, 'COEFFICIENT SARL', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Services aux entreprises / Business services', 'Energie / Energy', 'Industrie textile / Textile Industry', NULL, NULL, 'Consultant / Consultant', 'Innovation, R&D / Innovation, R&D', 'Technologie / Technology', NULL, 'Energie / Energy', 'Industrie textile / Textile Industry', 'TIC et innovation / ICT and innovation', 'Investisseur / Investor', 'Fabricant / Manufacturer', 'Partenaire Technique / Technical Partner', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 879, NULL, 1, 12, '2021-11-27 10:34:02', '2021-11-27 10:34:02', NULL, NULL, NULL, NULL, 'placeholder.png'),
(56, 'IPROBUSINESS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Tourisme / Tourism', 'Industrie textile / Textile Industry', NULL, NULL, 'Consultant / Consultant', 'Importateur / Importer', 'Investisseur / Investor', NULL, 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Tourisme / Tourism', 'BTP / Construction and public works', 'Distributeur / Distributor', 'Fabricant / Manufacturer', 'Importateur / Importer', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Turquie', NULL, NULL, 880, NULL, 1, 12, '2021-11-27 13:59:23', '2021-11-27 13:59:23', NULL, NULL, NULL, NULL, 'placeholder.png'),
(57, 'Better Cotton Initiative', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Environnement / Environment', 'Industrie textile / Textile Industry', NULL, NULL, 'Partenaire Technique / Technical Partner', 'Consultant / Consultant', 'Prestataire de services', NULL, 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Environnement / Environment', NULL, 'Partenaire Technique / Technical Partner', 'Partenaire Institutionnel / Institutionnal Partner', 'Innovation, R&D / Innovation, R&D', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 891, NULL, 0, 12, '2021-11-29 13:13:46', '2021-11-29 13:13:46', NULL, NULL, NULL, NULL, 'placeholder.png'),
(58, 'UNPCB', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Agriculture et agro-alimentaire / Agriculture and food processing', NULL, NULL, NULL, NULL, 'Partenaire Technique / Technical Partner', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 894, NULL, 0, 12, '2021-11-29 14:24:49', '2021-11-29 15:24:49', NULL, NULL, NULL, NULL, 'placeholder.png'),
(59, 'Hunan Going Global Investment&Economic Service Platform', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Agriculture et agro-alimentaire / Agriculture and food processing', 'TIC et innovation / ICT and innovation', 'Biens de consommation / Consumption Goods', NULL, NULL, 'Investisseur / Investor', 'Importateur / Importer', 'Prestataire de services', 'On a aussi besoin de Prestataire de services', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'TIC et innovation / ICT and innovation', 'Biens de consommation / Consumption Goods', 'Distributeur / Distributor', 'Fabricant / Manufacturer', 'Importateur / Importer', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Chine', NULL, NULL, 898, NULL, 0, 12, '2021-11-30 08:59:12', '2021-11-30 08:59:12', NULL, NULL, NULL, NULL, 'placeholder.png'),
(60, 'Taiba world business', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Environnement / Environment', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Industrie textile / Textile Industry', NULL, NULL, 'Prestataire de services', 'Sous-traitant / Subcontractor', 'Prestataire de services', 'Pour le moment je pas de partenaire', 'Industrie textile / Textile Industry', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Artisanat / Arts and crafts', 'Investisseur / Investor', 'Prestataire de services', 'Distributeur / Distributor', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Tchad', NULL, NULL, 907, NULL, 1, 12, '2021-11-30 21:32:51', '2021-11-30 21:32:51', NULL, NULL, NULL, NULL, 'placeholder.png'),
(61, 'TTC BURKINA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Services aux entreprises / Business services', 'Transport & Logistique / Transportation and Logistics', 'Autres / Others', NULL, NULL, 'Prestataire de services', 'Importateur / Importer', 'Sous-traitant / Subcontractor', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 910, NULL, 1, 12, '2021-12-01 05:29:22', '2021-12-01 06:29:22', NULL, NULL, NULL, NULL, 'placeholder.png'),
(62, 'Farahat grob', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Industrie textile / Textile Industry', 'Industrie textile / Textile Industry', NULL, NULL, 'Fabricant / Manufacturer', 'Investisseur / Investor', 'Investisseur / Investor', NULL, 'Industrie textile / Textile Industry', 'Industrie textile / Textile Industry', 'Industrie textile / Textile Industry', 'Fabricant / Manufacturer', 'Investisseur / Investor', 'Investisseur / Investor', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Egypte', NULL, NULL, 914, NULL, 0, 12, '2021-12-02 01:04:05', '2021-12-02 01:04:05', NULL, NULL, NULL, NULL, 'placeholder.png'),
(63, 'Edouabé Sika', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Artisanat / Arts and crafts', 'Distribution / Distribution', 'Industrie textile / Textile Industry', NULL, NULL, 'Fabricant / Manufacturer', 'Prestataire de services', 'Distributeur / Distributor', NULL, 'Industrie textile / Textile Industry', 'Services aux entreprises / Business services', 'Artisanat / Arts and crafts', 'Prestataire de services', 'Fabricant / Manufacturer', 'Consultant / Consultant', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Togo', NULL, NULL, 921, NULL, 0, 12, '2021-12-02 22:52:18', '2021-12-02 22:52:18', NULL, NULL, NULL, NULL, 'placeholder.png'),
(64, 'MEDITERRANEAN TEXTILE AND RAW MATERIALS EXPORTERS\' ASSOCIATION', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Autres / Others', NULL, NULL, NULL, 'Autres / Others', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SANS un planning B 2 B', NULL, NULL, NULL, 'Turquie', NULL, NULL, 915, NULL, 0, 12, '2021-12-03 12:53:22', '2021-12-03 13:53:22', NULL, NULL, NULL, NULL, 'placeholder.png'),
(65, 'Union Départementale des coopératives villageoise des producteurs de coton du Zou UD-CVPC/Zou', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Biens de consommation / Consumption Goods', 'Environnement / Environment', NULL, NULL, 'Partenaire Institutionnel / Institutionnal Partner', 'Consultant / Consultant', 'Autres / Others', 'Des partenaires pour le financement des producteurs de ma coopérative', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Environnement / Environment', 'Autres / Others', 'Partenaire Institutionnel / Institutionnal Partner', 'Investisseur / Investor', 'Technologie / Technology', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Bénin', NULL, NULL, 929, NULL, 1, 12, '2021-12-03 16:54:16', '2021-12-03 16:54:16', NULL, NULL, NULL, NULL, 'placeholder.png'),
(66, 'Jupiter consultant Afrique', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Services aux entreprises / Business services', 'Autres / Others', 'Autres / Others', NULL, NULL, 'Consultant / Consultant', 'Prestataire de services', 'Partenaire Technique / Technical Partner', NULL, 'Industrie textile / Textile Industry', 'TIC et innovation / ICT and innovation', 'Energie / Energy', 'Importateur / Importer', 'Investisseur / Investor', 'Innovation, R&D / Innovation, R&D', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Bénin', NULL, NULL, 933, NULL, 0, 12, '2021-12-03 23:55:23', '2021-12-03 23:55:23', NULL, NULL, NULL, NULL, 'placeholder.png'),
(67, 'RELOUKING SERVICE', NULL, '00226 72366451', NULL, NULL, NULL, NULL, NULL, NULL, 'Services aux entreprises / Business services', 'Distribution / Distribution', 'Industrie textile / Textile Industry', NULL, NULL, 'Prestataire de services', 'Distributeur / Distributor', 'Autres / Others', 'Je vends des des filatures de coton je cherche des investisseurs pour agrandir mon entreprise nommé RELOUKING SERVICE car c’est un domaine que j’ai appris à apprécier grâce à ma mère qui est tisserande j’y connais bien dans le domaine', 'Artisanat / Arts and crafts', 'Distribution / Distribution', 'Distribution / Distribution', 'Partenaire Technique / Technical Partner', 'Investisseur / Investor', 'Importateur / Importer', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 934, NULL, 1, 12, '2021-12-04 12:43:01', '2021-12-04 12:43:01', NULL, NULL, NULL, NULL, '5BF1EE6B-6E2C-4466-81D1-1F1D99E6E5C5.png'),
(68, 'Atisport', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', NULL, NULL, NULL, NULL, 'Importateur / Importer', 'Distributeur / Distributor', 'Distributeur / Distributor', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Tchad', NULL, NULL, 935, NULL, 1, 12, '2021-12-04 12:11:55', '2021-12-04 13:11:55', NULL, NULL, NULL, NULL, 'placeholder.png'),
(69, 'Prestations Express Leader / EVENTS ARTS ET DECORS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Autres / Others', NULL, NULL, 'Fabricant / Manufacturer', 'Prestataire de services', 'Innovation, R&D / Innovation, R&D', 'Entreprise événementielle', 'Biens de consommation / Consumption Goods', 'Distribution / Distribution', 'Services aux entreprises / Business services', 'Distributeur / Distributor', 'Investisseur / Investor', 'Technologie / Technology', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 943, NULL, 1, 12, '2021-12-06 18:52:13', '2021-12-06 18:52:13', NULL, NULL, NULL, NULL, 'placeholder.png'),
(70, 'Magnificat Group', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Services aux entreprises / Business services', 'Services aux entreprises / Business services', 'Services aux entreprises / Business services', NULL, NULL, 'Fabricant / Manufacturer', 'Investisseur / Investor', 'Partenaire Technique / Technical Partner', 'RAS', 'BTP / Construction and public works', 'Industrie textile / Textile Industry', 'Activités médicales et pharmaceutiques / Medical and pharmaceutical activities', 'Fabricant / Manufacturer', 'Partenaire Technique / Technical Partner', 'Investisseur / Investor', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 949, NULL, 1, 12, '2021-12-07 09:15:09', '2021-12-07 09:15:09', NULL, NULL, NULL, NULL, 'placeholder.png'),
(71, 'SODEFITEX', NULL, '+221 338897950', NULL, 'www.sodefitex.sn', NULL, NULL, NULL, NULL, 'Agriculture et agro-alimentaire / Agriculture and food processing', NULL, NULL, NULL, NULL, 'Fabricant / Manufacturer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Senegal', NULL, NULL, 950, NULL, 1, 12, '2021-12-07 09:45:20', '2021-12-07 09:45:20', NULL, NULL, NULL, 'Dynamisme Innovateur', 'LOGO SODEFITEX.png'),
(72, 'SODEFITEX', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Agriculture et agro-alimentaire / Agriculture and food processing', NULL, NULL, NULL, NULL, 'Fabricant / Manufacturer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Senegal', NULL, NULL, 950, NULL, 1, 12, '2021-12-07 08:16:44', '2021-12-07 09:16:44', NULL, NULL, NULL, NULL, 'placeholder.png'),
(73, 'Quotidien Numérique d\'Afrique', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Autres / Others', NULL, NULL, NULL, NULL, 'Autres / Others', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SANS un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 959, NULL, 1, 12, '2021-12-08 10:14:02', '2021-12-08 11:14:02', NULL, NULL, NULL, NULL, 'placeholder.png'),
(74, 'Djeneba forte international', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Distribution / Distribution', 'Autres / Others', NULL, NULL, 'Prestataire de services', 'Innovation, R&D / Innovation, R&D', 'Fabricant / Manufacturer', 'AFP/PME', 'Industrie textile / Textile Industry', 'Autres / Others', 'Industrie textile / Textile Industry', 'Partenaire Institutionnel / Institutionnal Partner', 'Innovation, R&D / Innovation, R&D', 'Importateur / Importer', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 961, NULL, 0, 12, '2021-12-08 14:30:49', '2021-12-08 14:30:49', NULL, NULL, NULL, NULL, 'placeholder.png'),
(75, 'Cabinet d\'étude Adam EXPER Textile et Habillement', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Industrie textile / Textile Industry', 'Industrie textile / Textile Industry', NULL, NULL, 'Consultant / Consultant', 'Consultant / Consultant', 'Consultant / Consultant', 'Partenariat de consultation pour :\r\n- Matériels textiles\r\n- Tissage artisanal\r\n- Autres', 'Industrie textile / Textile Industry', 'Environnement / Environment', 'Services aux entreprises / Business services', NULL, NULL, NULL, 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 963, NULL, 0, 12, '2021-12-08 19:21:15', '2021-12-08 19:21:15', NULL, NULL, NULL, NULL, 'placeholder.png');
INSERT INTO `entreprises` (`id`, `nom_entreprise`, `adresse`, `tel_entreprise`, `email_entreprise`, `site`, `description`, `produit_id`, `autre_secteur`, `participant_id`, `secteur_a`, `secteur_b`, `secteur_c`, `secteur_activite_rechercher`, `profile_entreprise_rechercher`, `profile_entreprise_a`, `profile_entreprise_b`, `profile_entreprise_c`, `partenaire_rechercher`, `partenaire_rencontrer_a`, `partenaire_rencontrer_b`, `partenaire_rencontrer_c`, `profile_partenaire_rechercher_a`, `profile_partenaire_rechercher_b`, `profile_partenaire_rechercher_c`, `rendez_vous`, `b2g`, `secteur_activite_id`, `pay_id`, `pays`, `activite_id`, `profil_id`, `user_id`, `delege`, `autre_participant`, `event_id`, `created_at`, `updated_at`, `alliance_rechercher`, `zone_geographie`, `langue`, `slogan`, `photos`) VALUES
(76, 'Sinergi Burkina', NULL, '+22625375766', NULL, 'www.sinergiburkina.com', NULL, NULL, NULL, NULL, 'Autres / Others', 'Services aux entreprises / Business services', NULL, NULL, NULL, 'Investisseur / Investor', NULL, NULL, 'Sinergi Burkina recherche des entreprises portants des projets de développement dans divers secteurs d\'activités( Textile, Energie, agro-alimentaire, santé, cosmétique, Digital etc.)', 'Industrie textile / Textile Industry', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Industrie manufacturière / Manufacturing industry', 'Fabricant / Manufacturer', 'Innovation, R&D / Innovation, R&D', NULL, 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 964, NULL, 1, 12, '2021-12-13 10:41:55', '2021-12-13 10:41:55', NULL, NULL, NULL, NULL, 'Sinergi-Burkina.png'),
(77, 'Investisseurs et Partenaires', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Autres / Others', NULL, NULL, NULL, NULL, 'Investisseur / Investor', 'Investisseur / Investor', NULL, 'Entreprises de tout secteur d\'activité à la recherde partenaires financiers.', 'Industrie textile / Textile Industry', 'Energie / Energy', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Fabricant / Manufacturer', 'Partenaire Institutionnel / Institutionnal Partner', 'Innovation, R&D / Innovation, R&D', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 966, NULL, 1, 12, '2021-12-12 15:54:31', '2021-12-12 15:54:31', NULL, NULL, NULL, NULL, 'placeholder.png'),
(78, 'Hosnia Confection', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Industrie textile / Textile Industry', NULL, NULL, NULL, 'Fabricant / Manufacturer', NULL, NULL, NULL, 'Industrie textile / Textile Industry', NULL, NULL, 'Fabricant / Manufacturer', NULL, NULL, 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 971, NULL, 0, 12, '2021-12-13 15:08:35', '2021-12-13 15:08:35', NULL, NULL, NULL, NULL, 'placeholder.png'),
(79, 'NFAFA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Agriculture et agro-alimentaire / Agriculture and food processing', NULL, NULL, NULL, 'Distributeur / Distributor', 'Fabricant / Manufacturer', NULL, 'Nous recherchons des partenaires qui nous aideront à développer davantage notre entreprise.', 'Industrie textile / Textile Industry', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Activités médicales et pharmaceutiques / Medical and pharmaceutical activities', 'Investisseur / Investor', 'Investisseur / Investor', 'Partenaire Institutionnel / Institutionnal Partner', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 973, NULL, 1, 12, '2021-12-14 13:54:41', '2021-12-14 13:54:41', NULL, NULL, NULL, NULL, 'placeholder.png'),
(80, 'Seed2Shirt', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Agriculture et agro-alimentaire / Agriculture and food processing', NULL, NULL, 'Autres / Others', 'Autres / Others', 'Autres / Others', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SANS un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 974, NULL, 0, 12, '2021-12-14 14:00:43', '2021-12-14 15:00:43', NULL, NULL, NULL, NULL, 'placeholder.png'),
(81, 'BOLLORE TRANSPORT & LOGISTICS BURKINA FASO', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Transport & Logistique / Transportation and Logistics', 'Autres / Others', 'Autres / Others', NULL, NULL, 'Autres / Others', 'Autres / Others', 'Autres / Others', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SANS un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 975, NULL, 0, 12, '2021-12-15 07:28:45', '2021-12-15 08:28:45', NULL, NULL, NULL, NULL, 'placeholder.png'),
(82, 'WORLD BANK GROUP', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Services aux entreprises / Business services', 'Autres / Others', 'Autres / Others', NULL, NULL, 'Investisseur / Investor', 'Autres / Others', 'Autres / Others', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SANS un planning B 2 B', NULL, NULL, NULL, 'États-Unis', NULL, NULL, 979, NULL, 0, 12, '2021-12-16 13:34:13', '2021-12-16 14:34:13', NULL, NULL, NULL, NULL, 'placeholder.png'),
(83, 'Union Nationale des Producteurs de Coton du Burkina', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Agriculture et agro-alimentaire / Agriculture and food processing', NULL, NULL, NULL, NULL, 'Autres / Others', NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Agriculture et agro-alimentaire / Agriculture and food processing', NULL, 'Fabricant / Manufacturer', 'Investisseur / Investor', NULL, 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 980, NULL, 1, 12, '2021-12-17 08:28:38', '2021-12-17 08:28:38', NULL, NULL, NULL, NULL, 'placeholder.png'),
(84, 'ZROS Vêtement', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Autres / Others', 'Industrie manufacturière / Manufacturing industry', NULL, NULL, 'Fabricant / Manufacturer', 'Autres / Others', 'Fabricant / Manufacturer', NULL, 'Industrie textile / Textile Industry', 'Industrie manufacturière / Manufacturing industry', 'Autres / Others', 'Fabricant / Manufacturer', 'Partenaire Institutionnel / Institutionnal Partner', 'Autres / Others', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Algérie', NULL, NULL, 990, NULL, 1, 12, '2021-12-19 23:55:44', '2021-12-19 23:55:44', NULL, NULL, NULL, NULL, 'placeholder.png'),
(85, 'Sogepra sarl', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Distribution / Distribution', 'Environnement / Environment', NULL, NULL, 'Distributeur / Distributor', 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Nous cherchons des partenaires pour investir dans la transfortion du coton, \r\nEt des fabriquant de produits intrants agricole', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Industrie textile / Textile Industry', 'Distribution / Distribution', 'Fabricant / Manufacturer', 'Importateur / Importer', 'Autres / Others', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 991, NULL, 1, 12, '2021-12-20 13:22:56', '2021-12-20 13:22:56', NULL, NULL, NULL, NULL, 'placeholder.png'),
(87, 'Conseil Burkinabè des Chargeurs', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Transport & Logistique / Transportation and Logistics', 'Services aux entreprises / Business services', 'Autres / Others', NULL, NULL, 'Partenaire Institutionnel / Institutionnal Partner', 'Consultant / Consultant', 'Autres / Others', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SANS un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 995, NULL, 0, 12, '2021-12-21 09:25:03', '2021-12-21 10:25:03', NULL, NULL, NULL, NULL, 'placeholder.png'),
(88, 'Seed2Shirt', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Industrie manufacturière / Manufacturing industry', 'Distribution / Distribution', NULL, NULL, 'Partenaire Institutionnel / Institutionnal Partner', 'Importateur / Importer', 'Distributeur / Distributor', NULL, 'Industrie textile / Textile Industry', 'Industrie manufacturière / Manufacturing industry', 'Distribution / Distribution', 'Partenaire Institutionnel / Institutionnal Partner', 'Innovation, R&D / Innovation, R&D', 'Autres / Others', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'États-Unis', NULL, NULL, 996, NULL, 0, 12, '2021-12-21 11:29:18', '2021-12-21 11:29:18', NULL, NULL, NULL, NULL, 'placeholder.png'),
(89, 'ILLIMITIS', NULL, NULL, NULL, 'www.illimitis.com', NULL, NULL, NULL, NULL, 'TIC et innovation / ICT and innovation', 'Services aux entreprises / Business services', NULL, NULL, NULL, 'Prestataire de services', 'Sous-traitant / Subcontractor', 'Consultant / Consultant', 'Partenaire dans la technologie (intégration de solutions, internet des objets, drones, représentation) et dans la formation (consultance, représentation, joint-ventures)', 'TIC et innovation / ICT and innovation', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Services aux entreprises / Business services', 'Investisseur / Investor', 'Prestataire de services', 'Distributeur / Distributor', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 997, NULL, 1, 12, '2021-12-21 13:38:43', '2021-12-21 13:38:43', NULL, NULL, NULL, 'Notre imagination est notre seule limite !', 'placeholder.png'),
(90, 'SINMATEX TEXCOM s.a', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Industrie manufacturière / Manufacturing industry', 'Industrie textile / Textile Industry', 'Autres / Others', NULL, NULL, 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Autres / Others', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SANS un planning B 2 B', NULL, NULL, NULL, 'Maroc', NULL, NULL, 998, NULL, 0, 12, '2021-12-21 12:59:20', '2021-12-21 13:59:20', NULL, NULL, NULL, NULL, 'placeholder.png'),
(91, 'Savonnerie Parfumerie du Houet', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Biens de consommation / Consumption Goods', 'Autres / Others', NULL, NULL, 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Autres / Others', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'SANS un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 1000, NULL, 0, 12, '2021-12-21 13:38:21', '2021-12-21 14:38:21', NULL, NULL, NULL, NULL, 'placeholder.png'),
(92, 'BOBOCREA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Artisanat / Arts and crafts', 'Industrie textile / Textile Industry', 'Autres / Others', NULL, NULL, 'Fabricant / Manufacturer', 'Autres / Others', 'Autres / Others', 'Étant dans une dynamique de reconnaissance sur le plan mondial , nous sommes à la recherche des partenaires sous traitant , de financement, de formation', 'Industrie textile / Textile Industry', 'Tourisme / Tourism', 'Distribution / Distribution', 'Distributeur / Distributor', 'Sous-traitant / Subcontractor', 'Importateur / Importer', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 1003, NULL, 0, 12, '2021-12-21 19:04:50', '2021-12-21 19:04:50', NULL, NULL, NULL, NULL, 'placeholder.png'),
(93, 'ASSOS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Services aux entreprises / Business services', 'TIC et innovation / ICT and innovation', NULL, NULL, NULL, 'Consultant / Consultant', 'Investisseur / Investor', NULL, 'Hello', 'Tourisme / Tourism', 'Environnement / Environment', 'TIC et innovation / ICT and innovation', 'Distributeur / Distributor', 'Investisseur / Investor', 'Consultant / Consultant', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Senegal', NULL, NULL, 1008, NULL, 0, 12, '2022-08-30 13:05:31', '2022-08-30 13:05:31', NULL, NULL, NULL, NULL, 'col10.png'),
(96, 'WANDA', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Artisanat / Arts and crafts', 'TIC et innovation / ICT and innovation', 'Energie / Energy', NULL, NULL, 'Consultant / Consultant', 'Investisseur / Investor', 'Importateur / Importer', 'Say something', 'Artisanat / Arts and crafts', 'TIC et innovation / ICT and innovation', NULL, 'Distributeur / Distributor', 'Investisseur / Investor', 'Consultant / Consultant', 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Bangladesh', NULL, NULL, 1011, NULL, 0, 12, '2022-08-30 13:32:30', '2022-08-30 13:32:30', NULL, NULL, NULL, NULL, 'placeholder.png'),
(97, 'TolgoAsi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'TIC et innovation / ICT and innovation', 'Distribution / Distribution', NULL, NULL, NULL, 'Prestataire de services', 'Consultant / Consultant', NULL, 'Hello je voudrais rencontrer une entreprise dans le développement de solution', 'TIC et innovation / ICT and innovation', 'Environnement / Environment', 'Services aux entreprises / Business services', 'Prestataire de services', 'Investisseur / Investor', NULL, 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Senegal', NULL, NULL, 1012, NULL, 0, 12, '2022-09-02 09:22:57', '2022-09-02 09:22:57', NULL, NULL, NULL, NULL, 'placeholder.png'),
(98, 'Illimitis', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Transport & Logistique / Transportation and Logistics', 'BTP / Construction and public works', 'Industrie manufacturière / Manufacturing industry', NULL, NULL, 'Partenaire Institutionnel / Institutionnal Partner', 'Technologie / Technology', NULL, NULL, 'Environnement / Environment', 'Energie / Energy', NULL, 'Technologie / Technology', 'Technologie / Technology', NULL, 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 1013, NULL, 0, 12, '2023-11-09 13:09:25', '2023-11-09 13:09:25', NULL, NULL, NULL, NULL, 'placeholder.png'),
(99, 'Illimitis', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Transport & Logistique / Transportation and Logistics', 'BTP / Construction and public works', 'Industrie manufacturière / Manufacturing industry', NULL, NULL, 'Partenaire Institutionnel / Institutionnal Partner', 'Technologie / Technology', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'AVEC un planning B 2 B', NULL, NULL, NULL, 'Burkina Faso', NULL, NULL, 1013, NULL, 0, 12, '2023-11-09 12:09:13', '2023-11-09 13:09:13', NULL, NULL, NULL, NULL, 'placeholder.png');

-- --------------------------------------------------------

--
-- Structure de la table `entreprise_rvs`
--

CREATE TABLE `entreprise_rvs` (
  `id` int(11) NOT NULL DEFAULT 0,
  `nom_entreprise` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `description` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `pays` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `secteur_a` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `secteur_b` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `secteur_c` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `partenaire_rechercher` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `partenaire_rencontrer_a` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `partenaire_rencontrer_b` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `partenaire_rencontrer_c` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `profile_entreprise_a` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `profile_entreprise_b` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `profile_entreprise_c` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `profile_partenaire_rechercher_a` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `profile_partenaire_rechercher_b` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `profile_partenaire_rechercher_c` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `rendez_vous` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `langue` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `entreprise_rvs`
--

INSERT INTO `entreprise_rvs` (`id`, `nom_entreprise`, `description`, `pays`, `secteur_a`, `secteur_b`, `secteur_c`, `partenaire_rechercher`, `partenaire_rencontrer_a`, `partenaire_rencontrer_b`, `partenaire_rencontrer_c`, `profile_entreprise_a`, `profile_entreprise_b`, `profile_entreprise_c`, `profile_partenaire_rechercher_a`, `profile_partenaire_rechercher_b`, `profile_partenaire_rechercher_c`, `rendez_vous`, `langue`, `user_id`, `event_id`, `created_at`, `updated_at`) VALUES
(1, 'Cabinet TTC', NULL, 'Burkina Faso', 'TIC et innovation / ICT and innovation', NULL, NULL, 'je suis a la recherche de PTF', 'TIC et innovation / ICT and innovation', 'Industrie textile / Textile Industry', 'Services aux entreprises / Business services', 'Prestataire de services', NULL, NULL, 'Technologie / Technology', NULL, NULL, 'AVEC un planning B 2 B', NULL, 724, 12, '2021-10-21 09:20:50', '2021-10-21 09:20:50'),
(2, 'YOSR SERVICE', NULL, 'Burkina Faso', 'TIC et innovation / ICT and innovation', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Services aux entreprises / Business services', 'ras', 'Services aux entreprises / Business services', 'TIC et innovation / ICT and innovation', NULL, 'Technologie / Technology', NULL, NULL, 'Technologie / Technology', 'Importateur / Importer', NULL, 'AVEC un planning B 2 B', NULL, 732, 12, '2021-10-21 19:15:25', '2021-10-21 19:15:25'),
(3, 'ABS International SARL', NULL, 'Burkina Faso', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Services aux entreprises / Business services', 'BTP / Construction and public works', 'Je suis à la recherche de partenaires techniques et financiers', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Services aux entreprises / Business services', 'Industrie textile / Textile Industry', 'Consultant / Consultant', 'Distributeur / Distributor', 'Fabricant / Manufacturer', 'Investisseur / Investor', 'Partenaire Technique / Technical Partner', 'Partenaire Institutionnel / Institutionnal Partner', 'AVEC un planning B 2 B', NULL, 733, 12, '2021-10-21 20:15:02', '2021-10-21 20:15:02'),
(4, 'Unité de Tissage du Gulmu', NULL, 'Burkina Faso', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'TIC et innovation / ICT and innovation', NULL, 'Industrie textile / Textile Industry', 'Services aux entreprises / Business services', 'Distribution / Distribution', 'Importateur / Importer', 'Distributeur / Distributor', 'Investisseur / Investor', 'Distributeur / Distributor', 'Importateur / Importer', 'Partenaire Technique / Technical Partner', 'AVEC un planning B 2 B', NULL, 734, 12, '2021-10-21 20:26:01', '2021-10-21 20:26:01'),
(5, 'Burkina Build Center', NULL, 'Burkina Faso', 'BTP / Construction and public works', 'Energie / Energy', 'Industrie manufacturière / Manufacturing industry', 'Institutions d\'accompagnement financier', 'BTP / Construction and public works', 'Industrie manufacturière / Manufacturing industry', 'Energie / Energy', 'Investisseur / Investor', 'Partenaire Institutionnel / Institutionnal Partner', 'Distributeur / Distributor', 'Investisseur / Investor', 'Distributeur / Distributor', 'Partenaire Institutionnel / Institutionnal Partner', 'AVEC un planning B 2 B', NULL, 736, 12, '2021-10-21 21:38:04', '2021-10-21 21:38:04'),
(7, 'GOUBA AVOCATS- LAW FIRM', NULL, 'Burkina Faso', 'Autres / Others', NULL, NULL, 'Les entreprises étrangères qui veulent investir au Burkina et les entreprises installées au Burkina et qui ont besoin d\'un accompagnement juridique et fiscal d\'un cabinet d\'avocats.', 'Industrie textile / Textile Industry', 'Energie / Energy', 'TIC et innovation / ICT and innovation', 'Consultant / Consultant', NULL, NULL, 'Investisseur / Investor', 'Investisseur / Investor', 'Investisseur / Investor', 'AVEC un planning B 2 B', NULL, 740, 12, '2021-10-22 08:05:09', '2021-10-22 08:05:09'),
(8, 'EAI SARL', NULL, 'Burkina Faso', 'Energie / Energy', 'BTP / Construction and public works', NULL, 'Nous recherchons des investisseurs , partenaires techniques ou fabricant dans le domaine de l\'industrie textile', 'Industrie textile / Textile Industry', 'BTP / Construction and public works', NULL, 'Prestataire de services', NULL, NULL, 'Investisseur / Investor', 'Partenaire Technique / Technical Partner', 'Fabricant / Manufacturer', 'AVEC un planning B 2 B', NULL, 743, 12, '2021-10-22 12:32:49', '2021-10-22 12:32:49'),
(9, 'Cabinet Ammani Consulting Group SARL', NULL, 'Burkina Faso', 'Services aux entreprises / Business services', 'Services aux entreprises / Business services', 'Services aux entreprises / Business services', 'Nous voulons des partenariats avec des entreprises qui veulent un accompagnement en matière d\'assistance comptable et fiscale, de formation , d’études de marchés , de montage de projets , de suivi-évaluation et de création et développement d\'entreprise', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'BTP / Construction and public works', 'Transport & Logistique / Transportation and Logistics', 'Consultant / Consultant', 'Consultant / Consultant', 'Consultant / Consultant', 'Investisseur / Investor', 'Importateur / Importer', 'Sous-traitant / Subcontractor', 'AVEC un planning B 2 B', NULL, 745, 12, '2021-10-22 13:11:54', '2021-10-22 13:11:54'),
(10, 'SOCIETE KOYAMGA DISTRIBUTION', NULL, 'Burkina Faso', 'Distribution / Distribution', 'Distribution / Distribution', 'Distribution / Distribution', 'Besoin de fabricant souhaitant faire représenter sa marque au Burkina par un distributeur exclusif.', 'Biens de consommation / Consumption Goods', 'Biens de consommation / Consumption Goods', 'Biens de consommation / Consumption Goods', 'Distributeur / Distributor', 'Distributeur / Distributor', 'Distributeur / Distributor', 'Fabricant / Manufacturer', 'Fabricant / Manufacturer', 'Fabricant / Manufacturer', 'AVEC un planning B 2 B', NULL, 747, 12, '2021-10-22 16:28:30', '2021-10-22 16:28:30'),
(11, 'INERA Programme Coton', NULL, 'Burkina Faso', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Environnement / Environment', 'Industrie textile / Textile Industry', 'Activités de recherche sur le coton biologique', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Partenaire Technique / Technical Partner', 'Partenaire Technique / Technical Partner', 'Partenaire Technique / Technical Partner', 'Partenaire Technique / Technical Partner', 'Partenaire Technique / Technical Partner', 'Partenaire Technique / Technical Partner', 'AVEC un planning B 2 B', NULL, 750, 12, '2021-10-22 21:59:02', '2021-10-22 21:59:02'),
(12, 'Pro-etole trading', NULL, 'Burkina Faso', 'Distribution / Distribution', 'Services aux entreprises / Business services', 'Autres / Others', 'Partenariat', 'Distribution / Distribution', 'Distribution / Distribution', 'Distribution / Distribution', 'Distributeur / Distributor', 'Importateur / Importer', 'Importateur / Importer', 'Distributeur / Distributor', 'Importateur / Importer', 'Importateur / Importer', 'AVEC un planning B 2 B', NULL, 753, 12, '2021-10-23 07:08:39', '2021-10-23 07:08:39'),
(13, 'Zam Zam production', NULL, 'Burkina Faso', 'Services aux entreprises / Business services', 'Services aux entreprises / Business services', 'Services aux entreprises / Business services', 'Accompagnement technique et financière pour mon entreprise culturel', 'Services aux entreprises / Business services', 'Services aux entreprises / Business services', 'Services aux entreprises / Business services', 'Prestataire de services', 'Prestataire de services', 'Prestataire de services', 'Partenaire Institutionnel / Institutionnal Partner', 'Partenaire Institutionnel / Institutionnal Partner', 'Consultant / Consultant', 'AVEC un planning B 2 B', NULL, 754, 12, '2021-10-23 07:43:30', '2021-10-23 07:43:30'),
(14, 'Ouaga Flash Média', NULL, 'Burkina Faso', 'Services aux entreprises / Business services', 'TIC et innovation / ICT and innovation', 'TIC et innovation / ICT and innovation', NULL, NULL, NULL, NULL, 'Technologie / Technology', 'Consultant / Consultant', 'Autres / Others', NULL, NULL, NULL, 'AVEC un planning B 2 B', NULL, 757, 12, '2021-10-23 09:57:44', '2021-10-23 11:57:44'),
(15, 'MUSIK UNIVERS', NULL, 'Burkina Faso', 'Industrie textile / Textile Industry', 'Tourisme / Tourism', 'Distribution / Distribution', 'Le coton médical', 'Activités médicales et pharmaceutiques / Medical and pharmaceutical activities', 'Industrie textile / Textile Industry', NULL, 'Fabricant / Manufacturer', 'Distributeur / Distributor', NULL, 'Fabricant / Manufacturer', 'Partenaire Institutionnel / Institutionnal Partner', NULL, 'AVEC un planning B 2 B', NULL, 760, 12, '2021-10-23 23:52:38', '2021-10-23 23:52:38'),
(16, 'Université Joseph KI-ZERBO/IGEDD', NULL, 'Burkina Faso', 'Environnement / Environment', 'Energie / Energy', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Des partenaires qui peuvent nous accompagner dans la technologie, l\'investissement ou dans le renforcement institutionnel.', 'Environnement / Environment', 'Industrie textile / Textile Industry', 'Energie / Energy', 'Consultant / Consultant', 'Partenaire Technique / Technical Partner', 'Prestataire de services', 'Investisseur / Investor', 'Technologie / Technology', 'Partenaire Technique / Technical Partner', 'AVEC un planning B 2 B', NULL, 761, 12, '2021-10-25 09:00:04', '2021-10-25 09:00:04'),
(17, 'OTHENTIC DESIGN', NULL, 'Burkina Faso', 'Industrie textile / Textile Industry', 'Distribution / Distribution', NULL, NULL, NULL, NULL, NULL, 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Importateur / Importer', NULL, NULL, NULL, 'AVEC un planning B 2 B', NULL, 765, 12, '2021-10-25 13:04:42', '2021-10-25 15:04:42'),
(18, 'Clo Design', NULL, 'Burkina Faso', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', NULL, 'Nous recherchons des investisseurs pour nos permettre d\'aborder toutes les activités prevues de l\'entreprise', 'Tourisme / Tourism', 'Distribution / Distribution', 'Transport & Logistique / Transportation and Logistics', 'Fabricant / Manufacturer', 'Distributeur / Distributor', NULL, 'Investisseur / Investor', 'Distributeur / Distributor', 'Partenaire Technique / Technical Partner', 'AVEC un planning B 2 B', NULL, 776, 12, '2021-10-30 12:14:24', '2021-10-30 12:14:24'),
(19, 'Entrprise  FASO/NAFA', NULL, 'Burkina Faso', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Artisanat / Arts and crafts', 'Services aux entreprises / Business services', '- partenariat en export/import\r\n- écoulement de nos produits a l’intérieur et a l extérieure\r\n- financement pour la matière première\r\n-  technologie', NULL, NULL, NULL, 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Prestataire de services', 'Importateur / Importer', 'Technologie / Technology', 'Prestataire de services', 'AVEC un planning B 2 B', NULL, 777, 12, '2021-11-02 13:22:31', '2021-11-02 13:22:31'),
(21, 'Soie&coton', NULL, 'Burkina Faso', 'Industrie textile / Textile Industry', 'Distribution / Distribution', NULL, NULL, 'Industrie textile / Textile Industry', 'Industrie manufacturière / Manufacturing industry', NULL, 'Fabricant / Manufacturer', 'Distributeur / Distributor', NULL, 'Investisseur / Investor', 'Distributeur / Distributor', NULL, 'AVEC un planning B 2 B', NULL, 820, 12, '2021-11-06 19:31:45', '2021-11-06 19:31:45'),
(22, 'Aktan Misr Textile & Dyeing S.A.E', NULL, 'Egypte', 'Industrie textile / Textile Industry', NULL, NULL, 'I need a cotton and yarn suppliers.', 'Industrie textile / Textile Industry', 'Industrie manufacturière / Manufacturing industry', 'Transport & Logistique / Transportation and Logistics', 'Fabricant / Manufacturer', NULL, NULL, 'Fabricant / Manufacturer', NULL, NULL, 'AVEC un planning B 2 B', NULL, 821, 12, '2021-11-07 11:46:01', '2021-11-07 11:46:01'),
(23, 'Secrétariat Permanent de la Filière Coton Libéralisée', NULL, 'Burkina Faso', 'Autres / Others', 'Industrie textile / Textile Industry', NULL, 'Investisseurs et porteurs de projets textiles', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Partenaire Institutionnel / Institutionnal Partner', NULL, NULL, 'Investisseur / Investor', 'Consultant / Consultant', 'Partenaire Technique / Technical Partner', 'AVEC un planning B 2 B', NULL, 822, 12, '2021-11-07 16:33:10', '2021-11-07 16:33:10'),
(24, 'TIERIS FASHION / NAKONI CRÉATION', NULL, 'Burkina Faso', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', NULL, 'Nous recherchons des partenaires évoluant dans le domaine du textile / tissage ou ayant un besoin des produits issus de ce domaine d\'activité.', 'Industrie textile / Textile Industry', 'Tourisme / Tourism', 'Artisanat / Arts and crafts', 'Fabricant / Manufacturer', 'Distributeur / Distributor', NULL, 'Distributeur / Distributor', 'Partenaire Technique / Technical Partner', 'Partenaire Institutionnel / Institutionnal Partner', 'AVEC un planning B 2 B', NULL, 809, 12, '2021-11-07 20:46:32', '2021-11-07 20:46:32'),
(25, 'O\'shine', NULL, 'Burkina Faso', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Distribution / Distribution', 'Structure d\'accompagnement, structure de financement, des investisseurs, des distributeurs internationaux', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Services aux entreprises / Business services', 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Prestataire de services', 'Investisseur / Investor', 'Partenaire Technique / Technical Partner', 'Importateur / Importer', 'AVEC un planning B 2 B', NULL, 824, 12, '2021-11-08 21:40:46', '2021-11-08 21:40:46'),
(26, 'Compagnie Malienne pour le Développement des Textiles (CMDT)', NULL, 'Mali', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Clients fibre de coton', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Environnement / Environment', 'Services aux entreprises / Business services', 'Autres / Others', 'Partenaire Technique / Technical Partner', 'Autres / Others', 'Investisseur / Investor', 'Partenaire Technique / Technical Partner', 'Autres / Others', 'AVEC un planning B 2 B', NULL, 828, 12, '2021-11-13 18:45:39', '2021-11-13 18:45:39'),
(27, 'Assemblée Permanente des chambres de métiers du Mali', NULL, 'Mali', 'Autres / Others', 'Autres / Others', 'Artisanat / Arts and crafts', 'Les investisseurs et les organisateurs pour un partage d\'expérience', 'Artisanat / Arts and crafts', 'Industrie textile / Textile Industry', 'Distribution / Distribution', 'Partenaire Institutionnel / Institutionnal Partner', 'Partenaire Institutionnel / Institutionnal Partner', 'Partenaire Institutionnel / Institutionnal Partner', 'Investisseur / Investor', 'Fabricant / Manufacturer', 'Partenaire Institutionnel / Institutionnal Partner', 'AVEC un planning B 2 B', NULL, 832, 12, '2021-11-15 09:02:45', '2021-11-15 09:02:45'),
(28, 'Saint-joe création', NULL, 'Côte d\'Ivoire', 'Industrie textile / Textile Industry', 'Distribution / Distribution', 'Artisanat / Arts and crafts', 'Des investisseurs et distributeurs de vêtements', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Distribution / Distribution', 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Autres / Others', 'Partenaire Technique / Technical Partner', 'Distributeur / Distributor', 'Investisseur / Investor', 'AVEC un planning B 2 B', NULL, 837, 12, '2021-11-15 14:33:23', '2021-11-15 14:33:23'),
(29, 'Patheo couture', NULL, 'Côte d\'Ivoire', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Distribution / Distribution', 'Créateur, modéliste et distributeurs', 'Distribution / Distribution', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Investisseur / Investor', 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Investisseur / Investor', 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'AVEC un planning B 2 B', NULL, 838, 12, '2021-11-15 15:34:23', '2021-11-15 15:34:23'),
(30, 'Flori-Art', NULL, 'Burkina Faso', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Artisanat / Arts and crafts', NULL, 'Distribution / Distribution', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Fabricant / Manufacturer', 'Innovation, R&D / Innovation, R&D', 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Importateur / Importer', 'Partenaire Institutionnel / Institutionnal Partner', 'AVEC un planning B 2 B', NULL, 784, 12, '2021-11-16 11:55:22', '2021-11-16 11:55:22'),
(31, 'Sanga D', NULL, 'Burkina Faso', 'Autres / Others', 'Autres / Others', 'Autres / Others', 'Distribution de prêt à porté', 'Industrie textile / Textile Industry', 'Distribution / Distribution', 'Autres / Others', 'Fabricant / Manufacturer', 'Fabricant / Manufacturer', 'Fabricant / Manufacturer', 'Investisseur / Investor', 'Partenaire Technique / Technical Partner', NULL, 'AVEC un planning B 2 B', NULL, 839, 12, '2021-11-16 12:51:08', '2021-11-16 12:51:08'),
(34, 'Ajc.bf', NULL, 'Burkina Faso', 'Autres / Others', 'Autres / Others', 'Autres / Others', 'Appuie financière pour obtention des matériaux de couture et formation en perfection pour notre association', 'Industrie textile / Textile Industry', 'Industrie textile / Textile Industry', 'Industrie textile / Textile Industry', 'Autres / Others', 'Autres / Others', 'Autres / Others', 'Investisseur / Investor', 'Partenaire Technique / Technical Partner', 'Fabricant / Manufacturer', 'AVEC un planning B 2 B', NULL, 844, 12, '2021-11-17 13:21:50', '2021-11-17 13:21:50'),
(35, 'Association des Jeunes pour la Valorisation de la Cotonnade', NULL, 'Mali', 'Autres / Others', 'Autres / Others', 'Autres / Others', 'des investisseurs et des donneurs d\'ordre', 'Distribution / Distribution', 'Artisanat / Arts and crafts', 'Industrie textile / Textile Industry', 'Partenaire Technique / Technical Partner', 'Autres / Others', 'Autres / Others', 'Partenaire Institutionnel / Institutionnal Partner', 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'AVEC un planning B 2 B', NULL, 845, 12, '2021-11-18 15:33:28', '2021-11-18 15:33:28'),
(36, 'INTERCOTON', NULL, 'Côte d\'Ivoire', 'Industrie textile / Textile Industry', 'Distribution / Distribution', 'Autres / Others', 'Égrenage de coton et commercialisation', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Distribution / Distribution', 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Autres / Others', 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Autres / Others', 'AVEC un planning B 2 B', NULL, 846, 12, '2021-11-18 16:04:05', '2021-11-18 16:04:05'),
(37, 'Conseil coton anacarde', NULL, 'Côte d\'Ivoire', 'Industrie textile / Textile Industry', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Distribution / Distribution', 'Investisseurs dans le domaine du coton, du textile et de l\'anacarde', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Industrie textile / Textile Industry', 'Industrie manufacturière / Manufacturing industry', 'Fabricant / Manufacturer', 'Partenaire Institutionnel / Institutionnal Partner', 'Autres / Others', 'Investisseur / Investor', 'Partenaire Institutionnel / Institutionnal Partner', 'Fabricant / Manufacturer', 'AVEC un planning B 2 B', NULL, 847, 12, '2021-11-19 11:55:32', '2021-11-19 11:55:32'),
(38, 'Association des Stilystes modélistes de Côte d\'Ivoire', NULL, 'Côte d\'Ivoire', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Autres / Others', 'Partenaire financier et investisseur', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Distribution / Distribution', 'Fabricant / Manufacturer', 'Prestataire de services', 'Autres / Others', 'Fabricant / Manufacturer', 'Partenaire Technique / Technical Partner', 'Fabricant / Manufacturer', 'AVEC un planning B 2 B', NULL, 848, 12, '2021-11-19 12:12:29', '2021-11-19 12:12:29'),
(39, 'AGROPROCESS', NULL, 'Côte d\'Ivoire', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Industrie textile / Textile Industry', 'Distribution / Distribution', 'PARTENAIRE INSTITUTIONNEL POUR INVESTIR DANS LE COTON', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Industrie textile / Textile Industry', 'Autres / Others', 'Fabricant / Manufacturer', 'Investisseur / Investor', 'Partenaire Technique / Technical Partner', 'Partenaire Institutionnel / Institutionnal Partner', 'Fabricant / Manufacturer', 'Autres / Others', 'AVEC un planning B 2 B', NULL, 849, 12, '2021-11-19 12:24:20', '2021-11-19 12:24:20'),
(41, 'Marubeni Corporation', NULL, 'Afrique du Sud', 'Industrie textile / Textile Industry', 'Industrie manufacturière / Manufacturing industry', 'Energie / Energy', 'je souhaite des échanges avec les partenaires institutionnels pour investir dans l’énergie ou le coton', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Industrie textile / Textile Industry', 'Energie / Energy', 'Investisseur / Investor', 'Fabricant / Manufacturer', 'Prestataire de services', 'Partenaire Institutionnel / Institutionnal Partner', 'Fabricant / Manufacturer', 'Autres / Others', 'AVEC un planning B 2 B', NULL, 851, 12, '2021-11-19 12:59:00', '2021-11-19 12:59:00'),
(45, 'Sft', NULL, 'Côte d\'Ivoire', 'Industrie textile / Textile Industry', 'Distribution / Distribution', 'Industrie manufacturière / Manufacturing industry', '1.specialiste dans la production d accessoire médicaux à base de coton\r\n2.fabricant d unité de production  de coton medical', 'Industrie textile / Textile Industry', 'Industrie manufacturière / Manufacturing industry', 'Services aux entreprises / Business services', 'Fabricant / Manufacturer', 'Investisseur / Investor', 'Importateur / Importer', 'Consultant / Consultant', 'Fabricant / Manufacturer', 'Partenaire Technique / Technical Partner', 'AVEC un planning B 2 B', NULL, 855, 12, '2021-11-21 14:14:56', '2021-11-21 14:14:56'),
(50, 'Gherzi Textil Organisation AG', NULL, 'Suisse', 'Industrie textile / Textile Industry', NULL, NULL, NULL, 'Industrie textile / Textile Industry', NULL, NULL, 'Consultant / Consultant', NULL, NULL, 'Partenaire Institutionnel / Institutionnal Partner', 'Partenaire Technique / Technical Partner', 'Investisseur / Investor', 'AVEC un planning B 2 B', NULL, 867, 12, '2021-11-26 13:38:04', '2021-11-26 13:38:04'),
(51, 'Université Joseph Ki-Zerbo', NULL, 'Burkina Faso', 'Autres / Others', NULL, NULL, 'Recherche scientifique', 'Autres / Others', NULL, NULL, 'Innovation, R&D / Innovation, R&D', 'Consultant / Consultant', 'Partenaire Institutionnel / Institutionnal Partner', 'Consultant / Consultant', 'Innovation, R&D / Innovation, R&D', 'Partenaire Institutionnel / Institutionnal Partner', 'AVEC un planning B 2 B', NULL, 870, 12, '2021-11-26 14:55:11', '2021-11-26 14:55:11'),
(52, 'SAHA ART', NULL, 'Burkina Faso', 'Artisanat / Arts and crafts', 'Industrie textile / Textile Industry', 'Distribution / Distribution', 'Nous souhaitons partager les experiences en matiere de vente internationale en ligne avec des partenaires .', 'Artisanat / Arts and crafts', 'Industrie textile / Textile Industry', 'Distribution / Distribution', 'Fabricant / Manufacturer', 'Prestataire de services', 'Partenaire Technique / Technical Partner', 'Consultant / Consultant', 'Partenaire Technique / Technical Partner', 'Investisseur / Investor', 'AVEC un planning B 2 B', NULL, 874, 12, '2021-11-26 19:47:45', '2021-11-26 19:47:45'),
(53, 'MADIRO INTER', NULL, 'Burkina Faso', 'Industrie manufacturière / Manufacturing industry', 'TIC et innovation / ICT and innovation', 'Industrie textile / Textile Industry', NULL, NULL, NULL, NULL, 'Investisseur / Investor', 'Distributeur / Distributor', 'Investisseur / Investor', NULL, NULL, NULL, 'AVEC un planning B 2 B', NULL, 875, 12, '2021-11-26 22:12:04', '2021-11-26 23:12:04'),
(54, 'Take iT with Zama', NULL, 'Burkina Faso', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Biens de consommation / Consumption Goods', 'Nous souhaitons avoir des partenaires qui entrent dans le capital de l\'entreprise.', 'Artisanat / Arts and crafts', 'Distribution / Distribution', 'Services aux entreprises / Business services', 'Fabricant / Manufacturer', 'Prestataire de services', 'Innovation, R&D / Innovation, R&D', 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Partenaire Technique / Technical Partner', 'AVEC un planning B 2 B', NULL, 878, 12, '2021-11-27 09:55:27', '2021-11-27 09:55:27'),
(55, 'COEFFICIENT SARL', NULL, 'Burkina Faso', 'Services aux entreprises / Business services', 'Energie / Energy', 'Industrie textile / Textile Industry', NULL, 'Energie / Energy', 'Industrie textile / Textile Industry', 'TIC et innovation / ICT and innovation', 'Consultant / Consultant', 'Innovation, R&D / Innovation, R&D', 'Technologie / Technology', 'Investisseur / Investor', 'Fabricant / Manufacturer', 'Partenaire Technique / Technical Partner', 'AVEC un planning B 2 B', NULL, 879, 12, '2021-11-27 10:34:02', '2021-11-27 10:34:02'),
(56, 'IPROBUSINESS', NULL, 'Turquie', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Tourisme / Tourism', 'Industrie textile / Textile Industry', NULL, 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Tourisme / Tourism', 'BTP / Construction and public works', 'Consultant / Consultant', 'Importateur / Importer', 'Investisseur / Investor', 'Distributeur / Distributor', 'Fabricant / Manufacturer', 'Importateur / Importer', 'AVEC un planning B 2 B', NULL, 880, 12, '2021-11-27 13:59:23', '2021-11-27 13:59:23'),
(57, 'Better Cotton Initiative', NULL, 'Burkina Faso', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Environnement / Environment', 'Industrie textile / Textile Industry', NULL, 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Environnement / Environment', NULL, 'Partenaire Technique / Technical Partner', 'Consultant / Consultant', 'Prestataire de services', 'Partenaire Technique / Technical Partner', 'Partenaire Institutionnel / Institutionnal Partner', 'Innovation, R&D / Innovation, R&D', 'AVEC un planning B 2 B', NULL, 891, 12, '2021-11-29 13:13:46', '2021-11-29 13:13:46'),
(58, 'UNPCB', NULL, 'Burkina Faso', 'Agriculture et agro-alimentaire / Agriculture and food processing', NULL, NULL, NULL, NULL, NULL, NULL, 'Partenaire Technique / Technical Partner', NULL, NULL, NULL, NULL, NULL, 'AVEC un planning B 2 B', NULL, 894, 12, '2021-11-29 14:24:49', '2021-11-29 15:24:49'),
(59, 'Hunan Going Global Investment&Economic Service Platform', NULL, 'Chine', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'TIC et innovation / ICT and innovation', 'Biens de consommation / Consumption Goods', 'On a aussi besoin de Prestataire de services', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'TIC et innovation / ICT and innovation', 'Biens de consommation / Consumption Goods', 'Investisseur / Investor', 'Importateur / Importer', 'Prestataire de services', 'Distributeur / Distributor', 'Fabricant / Manufacturer', 'Importateur / Importer', 'AVEC un planning B 2 B', NULL, 898, 12, '2021-11-30 08:59:12', '2021-11-30 08:59:12'),
(60, 'Taiba world business', NULL, 'Tchad', 'Environnement / Environment', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Industrie textile / Textile Industry', 'Pour le moment je pas de partenaire', 'Industrie textile / Textile Industry', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Artisanat / Arts and crafts', 'Prestataire de services', 'Sous-traitant / Subcontractor', 'Prestataire de services', 'Investisseur / Investor', 'Prestataire de services', 'Distributeur / Distributor', 'AVEC un planning B 2 B', NULL, 907, 12, '2021-11-30 21:32:51', '2021-11-30 21:32:51'),
(61, 'TTC BURKINA', NULL, 'Burkina Faso', 'Services aux entreprises / Business services', 'Transport & Logistique / Transportation and Logistics', 'Autres / Others', NULL, NULL, NULL, NULL, 'Prestataire de services', 'Importateur / Importer', 'Sous-traitant / Subcontractor', NULL, NULL, NULL, 'AVEC un planning B 2 B', NULL, 910, 12, '2021-12-01 05:29:22', '2021-12-01 06:29:22'),
(62, 'Farahat grob', NULL, 'Egypte', 'Industrie textile / Textile Industry', 'Industrie textile / Textile Industry', 'Industrie textile / Textile Industry', NULL, 'Industrie textile / Textile Industry', 'Industrie textile / Textile Industry', 'Industrie textile / Textile Industry', 'Fabricant / Manufacturer', 'Investisseur / Investor', 'Investisseur / Investor', 'Fabricant / Manufacturer', 'Investisseur / Investor', 'Investisseur / Investor', 'AVEC un planning B 2 B', NULL, 914, 12, '2021-12-02 01:04:05', '2021-12-02 01:04:05'),
(63, 'Edouabé Sika', NULL, 'Togo', 'Artisanat / Arts and crafts', 'Distribution / Distribution', 'Industrie textile / Textile Industry', NULL, 'Industrie textile / Textile Industry', 'Services aux entreprises / Business services', 'Artisanat / Arts and crafts', 'Fabricant / Manufacturer', 'Prestataire de services', 'Distributeur / Distributor', 'Prestataire de services', 'Fabricant / Manufacturer', 'Consultant / Consultant', 'AVEC un planning B 2 B', NULL, 921, 12, '2021-12-02 22:52:18', '2021-12-02 22:52:18'),
(65, 'Union Départementale des coopératives villageoise des producteurs de coton du Zou UD-CVPC/Zou', NULL, 'Bénin', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Biens de consommation / Consumption Goods', 'Environnement / Environment', 'Des partenaires pour le financement des producteurs de ma coopérative', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Environnement / Environment', 'Autres / Others', 'Partenaire Institutionnel / Institutionnal Partner', 'Consultant / Consultant', 'Autres / Others', 'Partenaire Institutionnel / Institutionnal Partner', 'Investisseur / Investor', 'Technologie / Technology', 'AVEC un planning B 2 B', NULL, 929, 12, '2021-12-03 16:54:16', '2021-12-03 16:54:16'),
(66, 'Jupiter consultant Afrique', NULL, 'Bénin', 'Services aux entreprises / Business services', 'Autres / Others', 'Autres / Others', NULL, 'Industrie textile / Textile Industry', 'TIC et innovation / ICT and innovation', 'Energie / Energy', 'Consultant / Consultant', 'Prestataire de services', 'Partenaire Technique / Technical Partner', 'Importateur / Importer', 'Investisseur / Investor', 'Innovation, R&D / Innovation, R&D', 'AVEC un planning B 2 B', NULL, 933, 12, '2021-12-03 23:55:23', '2021-12-03 23:55:23'),
(67, 'RELOUKING SERVICE', NULL, 'Burkina Faso', 'Services aux entreprises / Business services', 'Distribution / Distribution', 'Industrie textile / Textile Industry', 'Je vends des des filatures de coton je cherche des investisseurs pour agrandir mon entreprise nommé RELOUKING SERVICE car c’est un domaine que j’ai appris à apprécier grâce à ma mère qui est tisserande j’y connais bien dans le domaine', 'Artisanat / Arts and crafts', 'Distribution / Distribution', 'Distribution / Distribution', 'Prestataire de services', 'Distributeur / Distributor', 'Autres / Others', 'Partenaire Technique / Technical Partner', 'Investisseur / Investor', 'Importateur / Importer', 'AVEC un planning B 2 B', NULL, 934, 12, '2021-12-04 12:43:01', '2021-12-04 12:43:01'),
(68, 'Atisport', NULL, 'Tchad', 'Industrie textile / Textile Industry', NULL, NULL, NULL, NULL, NULL, NULL, 'Importateur / Importer', 'Distributeur / Distributor', 'Distributeur / Distributor', NULL, NULL, NULL, 'AVEC un planning B 2 B', NULL, 935, 12, '2021-12-04 12:11:55', '2021-12-04 13:11:55'),
(69, 'Prestations Express Leader / EVENTS ARTS ET DECORS', NULL, 'Burkina Faso', 'Industrie textile / Textile Industry', 'Artisanat / Arts and crafts', 'Autres / Others', 'Entreprise événementielle', 'Biens de consommation / Consumption Goods', 'Distribution / Distribution', 'Services aux entreprises / Business services', 'Fabricant / Manufacturer', 'Prestataire de services', 'Innovation, R&D / Innovation, R&D', 'Distributeur / Distributor', 'Investisseur / Investor', 'Technologie / Technology', 'AVEC un planning B 2 B', NULL, 943, 12, '2021-12-06 18:52:13', '2021-12-06 18:52:13'),
(70, 'Magnificat Group', NULL, 'Burkina Faso', 'Services aux entreprises / Business services', 'Services aux entreprises / Business services', 'Services aux entreprises / Business services', 'RAS', 'BTP / Construction and public works', 'Industrie textile / Textile Industry', 'Activités médicales et pharmaceutiques / Medical and pharmaceutical activities', 'Fabricant / Manufacturer', 'Investisseur / Investor', 'Partenaire Technique / Technical Partner', 'Fabricant / Manufacturer', 'Partenaire Technique / Technical Partner', 'Investisseur / Investor', 'AVEC un planning B 2 B', NULL, 949, 12, '2021-12-07 09:15:09', '2021-12-07 09:15:09'),
(71, 'SODEFITEX', NULL, 'Senegal', 'Agriculture et agro-alimentaire / Agriculture and food processing', NULL, NULL, NULL, NULL, NULL, NULL, 'Fabricant / Manufacturer', NULL, NULL, NULL, NULL, NULL, 'AVEC un planning B 2 B', NULL, 950, 12, '2021-12-07 09:45:20', '2021-12-07 09:45:20'),
(72, 'SODEFITEX', NULL, 'Senegal', 'Agriculture et agro-alimentaire / Agriculture and food processing', NULL, NULL, NULL, NULL, NULL, NULL, 'Fabricant / Manufacturer', NULL, NULL, NULL, NULL, NULL, 'AVEC un planning B 2 B', NULL, 950, 12, '2021-12-07 08:16:44', '2021-12-07 09:16:44'),
(74, 'Djeneba forte international', NULL, 'Burkina Faso', 'Industrie textile / Textile Industry', 'Distribution / Distribution', 'Autres / Others', 'AFP/PME', 'Industrie textile / Textile Industry', 'Autres / Others', 'Industrie textile / Textile Industry', 'Prestataire de services', 'Innovation, R&D / Innovation, R&D', 'Fabricant / Manufacturer', 'Partenaire Institutionnel / Institutionnal Partner', 'Innovation, R&D / Innovation, R&D', 'Importateur / Importer', 'AVEC un planning B 2 B', NULL, 961, 12, '2021-12-08 14:30:49', '2021-12-08 14:30:49'),
(75, 'Cabinet d\'étude Adam EXPER Textile et Habillement', NULL, 'Burkina Faso', 'Industrie textile / Textile Industry', 'Industrie textile / Textile Industry', 'Industrie textile / Textile Industry', 'Partenariat de consultation pour :\r\n- Matériels textiles\r\n- Tissage artisanal\r\n- Autres', 'Industrie textile / Textile Industry', 'Environnement / Environment', 'Services aux entreprises / Business services', 'Consultant / Consultant', 'Consultant / Consultant', 'Consultant / Consultant', NULL, NULL, NULL, 'AVEC un planning B 2 B', NULL, 963, 12, '2021-12-08 19:21:15', '2021-12-08 19:21:15'),
(76, 'Sinergi Burkina', NULL, 'Burkina Faso', 'Autres / Others', 'Services aux entreprises / Business services', NULL, 'Sinergi Burkina recherche des entreprises portants des projets de développement dans divers secteurs d\'activités( Textile, Energie, agro-alimentaire, santé, cosmétique, Digital etc.)', 'Industrie textile / Textile Industry', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Industrie manufacturière / Manufacturing industry', 'Investisseur / Investor', NULL, NULL, 'Fabricant / Manufacturer', 'Innovation, R&D / Innovation, R&D', NULL, 'AVEC un planning B 2 B', NULL, 964, 12, '2021-12-13 10:41:55', '2021-12-13 10:41:55'),
(77, 'Investisseurs et Partenaires', NULL, 'Burkina Faso', 'Autres / Others', NULL, NULL, 'Entreprises de tout secteur d\'activité à la recherde partenaires financiers.', 'Industrie textile / Textile Industry', 'Energie / Energy', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Investisseur / Investor', 'Investisseur / Investor', NULL, 'Fabricant / Manufacturer', 'Partenaire Institutionnel / Institutionnal Partner', 'Innovation, R&D / Innovation, R&D', 'AVEC un planning B 2 B', NULL, 966, 12, '2021-12-12 15:54:31', '2021-12-12 15:54:31'),
(78, 'Hosnia Confection', NULL, 'Burkina Faso', 'Industrie textile / Textile Industry', 'Industrie textile / Textile Industry', NULL, NULL, 'Industrie textile / Textile Industry', NULL, NULL, 'Fabricant / Manufacturer', NULL, NULL, 'Fabricant / Manufacturer', NULL, NULL, 'AVEC un planning B 2 B', NULL, 971, 12, '2021-12-13 15:08:35', '2021-12-13 15:08:35'),
(79, 'NFAFA', NULL, 'Burkina Faso', 'Industrie textile / Textile Industry', 'Agriculture et agro-alimentaire / Agriculture and food processing', NULL, 'Nous recherchons des partenaires qui nous aideront à développer davantage notre entreprise.', 'Industrie textile / Textile Industry', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Activités médicales et pharmaceutiques / Medical and pharmaceutical activities', 'Distributeur / Distributor', 'Fabricant / Manufacturer', NULL, 'Investisseur / Investor', 'Investisseur / Investor', 'Partenaire Institutionnel / Institutionnal Partner', 'AVEC un planning B 2 B', NULL, 973, 12, '2021-12-14 13:54:41', '2021-12-14 13:54:41'),
(83, 'Union Nationale des Producteurs de Coton du Burkina', NULL, 'Burkina Faso', 'Agriculture et agro-alimentaire / Agriculture and food processing', NULL, NULL, NULL, 'Industrie textile / Textile Industry', 'Agriculture et agro-alimentaire / Agriculture and food processing', NULL, 'Autres / Others', NULL, NULL, 'Fabricant / Manufacturer', 'Investisseur / Investor', NULL, 'AVEC un planning B 2 B', NULL, 980, 12, '2021-12-17 08:28:38', '2021-12-17 08:28:38'),
(84, 'ZROS Vêtement', NULL, 'Algérie', 'Industrie textile / Textile Industry', 'Autres / Others', 'Industrie manufacturière / Manufacturing industry', NULL, 'Industrie textile / Textile Industry', 'Industrie manufacturière / Manufacturing industry', 'Autres / Others', 'Fabricant / Manufacturer', 'Autres / Others', 'Fabricant / Manufacturer', 'Fabricant / Manufacturer', 'Partenaire Institutionnel / Institutionnal Partner', 'Autres / Others', 'AVEC un planning B 2 B', NULL, 990, 12, '2021-12-19 23:55:44', '2021-12-19 23:55:44'),
(85, 'Sogepra sarl', NULL, 'Burkina Faso', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Distribution / Distribution', 'Environnement / Environment', 'Nous cherchons des partenaires pour investir dans la transfortion du coton, \r\nEt des fabriquant de produits intrants agricole', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Industrie textile / Textile Industry', 'Distribution / Distribution', 'Distributeur / Distributor', 'Fabricant / Manufacturer', 'Distributeur / Distributor', 'Fabricant / Manufacturer', 'Importateur / Importer', 'Autres / Others', 'AVEC un planning B 2 B', NULL, 991, 12, '2021-12-20 13:22:56', '2021-12-20 13:22:56'),
(88, 'Seed2Shirt', NULL, 'États-Unis', 'Industrie textile / Textile Industry', 'Industrie manufacturière / Manufacturing industry', 'Distribution / Distribution', NULL, 'Industrie textile / Textile Industry', 'Industrie manufacturière / Manufacturing industry', 'Distribution / Distribution', 'Partenaire Institutionnel / Institutionnal Partner', 'Importateur / Importer', 'Distributeur / Distributor', 'Partenaire Institutionnel / Institutionnal Partner', 'Innovation, R&D / Innovation, R&D', 'Autres / Others', 'AVEC un planning B 2 B', NULL, 996, 12, '2021-12-21 11:29:18', '2021-12-21 11:29:18'),
(89, 'ILLIMITIS', NULL, 'Burkina Faso', 'TIC et innovation / ICT and innovation', 'Services aux entreprises / Business services', NULL, 'Partenaire dans la technologie (intégration de solutions, internet des objets, drones, représentation) et dans la formation (consultance, représentation, joint-ventures)', 'TIC et innovation / ICT and innovation', 'Agriculture et agro-alimentaire / Agriculture and food processing', 'Services aux entreprises / Business services', 'Prestataire de services', 'Sous-traitant / Subcontractor', 'Consultant / Consultant', 'Investisseur / Investor', 'Prestataire de services', 'Distributeur / Distributor', 'AVEC un planning B 2 B', NULL, 997, 12, '2021-12-21 13:38:43', '2021-12-21 13:38:43'),
(92, 'BOBOCREA', NULL, 'Burkina Faso', 'Artisanat / Arts and crafts', 'Industrie textile / Textile Industry', 'Autres / Others', 'Étant dans une dynamique de reconnaissance sur le plan mondial , nous sommes à la recherche des partenaires sous traitant , de financement, de formation', 'Industrie textile / Textile Industry', 'Tourisme / Tourism', 'Distribution / Distribution', 'Fabricant / Manufacturer', 'Autres / Others', 'Autres / Others', 'Distributeur / Distributor', 'Sous-traitant / Subcontractor', 'Importateur / Importer', 'AVEC un planning B 2 B', NULL, 1003, 12, '2021-12-21 19:04:50', '2021-12-21 19:04:50'),
(93, 'ASSOS', NULL, 'Senegal', 'Services aux entreprises / Business services', 'TIC et innovation / ICT and innovation', NULL, 'Hello', 'Tourisme / Tourism', 'Environnement / Environment', 'TIC et innovation / ICT and innovation', 'Consultant / Consultant', 'Investisseur / Investor', NULL, 'Distributeur / Distributor', 'Investisseur / Investor', 'Consultant / Consultant', 'AVEC un planning B 2 B', NULL, 1008, 12, '2022-08-30 13:05:31', '2022-08-30 13:05:31'),
(96, 'WANDA', NULL, 'Bangladesh', 'Artisanat / Arts and crafts', 'TIC et innovation / ICT and innovation', 'Energie / Energy', 'Say something', 'Artisanat / Arts and crafts', 'TIC et innovation / ICT and innovation', NULL, 'Consultant / Consultant', 'Investisseur / Investor', 'Importateur / Importer', 'Distributeur / Distributor', 'Investisseur / Investor', 'Consultant / Consultant', 'AVEC un planning B 2 B', NULL, 1011, 12, '2022-08-30 13:32:30', '2022-08-30 13:32:30'),
(97, 'TolgoAsi', NULL, 'Senegal', 'TIC et innovation / ICT and innovation', 'Distribution / Distribution', NULL, 'Hello je voudrais rencontrer une entreprise dans le développement de solution', 'TIC et innovation / ICT and innovation', 'Environnement / Environment', 'Services aux entreprises / Business services', 'Prestataire de services', 'Consultant / Consultant', NULL, 'Prestataire de services', 'Investisseur / Investor', NULL, 'AVEC un planning B 2 B', NULL, 1012, 12, '2022-09-02 09:22:57', '2022-09-02 09:22:57');

-- --------------------------------------------------------

--
-- Structure de la table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `nom_event_fr` varchar(255) DEFAULT NULL,
  `nom_event_en` varchar(255) DEFAULT NULL,
  `site` varchar(255) DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `phase` tinyint(1) DEFAULT 0,
  `max` int(11) DEFAULT NULL,
  `organisateur_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `events`
--

INSERT INTO `events` (`id`, `nom_event_fr`, `nom_event_en`, `site`, `date_debut`, `date_fin`, `status`, `phase`, `max`, `organisateur_id`, `created_at`, `updated_at`) VALUES
(7, 'Test de la Tech', 'Test de la Tech', NULL, '2021-09-10', '2021-09-10', 0, 2, NULL, NULL, '2021-10-07 19:37:37', '2021-10-07 14:07:09'),
(12, 'SICOT 2022', 'SICOT 2022', 'sicot.com', '2022-01-29', '2022-01-29', 1, 4, 10, 1, '2022-09-02 09:32:47', '2022-09-02 09:32:47'),
(13, 'Tester', 'Test', 'test.com', '2021-10-21', '2021-10-21', 0, 0, NULL, 1, '2021-10-12 21:03:37', '2021-10-12 21:03:37');

-- --------------------------------------------------------

--
-- Structure de la table `facilitateurs`
--

CREATE TABLE `facilitateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `langue_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `hotels`
--

CREATE TABLE `hotels` (
  `id` int(11) NOT NULL,
  `nom_hotel` varchar(255) DEFAULT NULL,
  `details_hotel` text DEFAULT NULL,
  `email_hotel` varchar(255) DEFAULT NULL,
  `tel_hotel` varchar(255) DEFAULT NULL,
  `site_hotel` varchar(255) DEFAULT NULL,
  `type_hotel` varchar(50) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `hotels`
--

INSERT INTO `hotels` (`id`, `nom_hotel`, `details_hotel`, `email_hotel`, `tel_hotel`, `site_hotel`, `type_hotel`, `event_id`, `created_at`, `updated_at`) VALUES
(4, 'AUBERGE BALZAC', '20', NULL, '70 28 08 95 /  78 02 61 76', '10', 'Auberge', NULL, '2022-01-14 12:45:10', '2022-01-14 13:45:10'),
(5, 'AUBERGE BELLE VUE', '20', NULL, NULL, '10', 'Auberge', NULL, '2022-01-14 12:45:28', '2022-01-14 13:45:28'),
(6, 'AUBERGE BENEWENDE', '44', NULL, '71871938', '22', 'Auberge', NULL, '2022-01-14 12:44:59', '2022-01-14 13:44:59'),
(7, 'AUBERGE BIENVENU', '26', NULL, '71 64 49 54 / 66225468', '13', 'Auberge', NULL, '2022-01-14 12:45:45', '2022-01-14 13:45:45'),
(8, 'AUBERGE EUREKA', '12', NULL, '71 74 95 66', '6', 'Auberge', NULL, '2022-01-14 12:46:07', '2022-01-14 13:46:07'),
(9, 'AUBERGE EUREKA ANNEXE', '20', NULL, '71 74 95 66', '10', 'Auberge', NULL, '2022-01-14 12:46:27', '2022-01-14 13:46:27'),
(10, 'AUBERGE FASO', '18', NULL, '52 53 51 07 /  69 77 33 07', '9', 'Auberge', NULL, '2022-01-14 12:46:46', '2022-01-14 13:46:46'),
(11, 'AUBERGE FRANCK', '22', NULL, '70 23 26 77', '11', 'Auberge', NULL, '2022-01-14 12:47:01', '2022-01-14 13:47:01'),
(12, 'AUBERGE GALYAM', '24', NULL, '70 32 10 00', '12', 'Auberge', NULL, '2022-01-14 12:47:30', '2022-01-14 13:47:30'),
(13, 'AUBERGE GRACIAS', '34', NULL, '63 99 99 17 /  58 93 22 93', '17', 'Auberge', NULL, '2022-01-14 12:47:49', '2022-01-14 13:47:49'),
(14, 'RESIDENCE LA COLOMBE', '40', NULL, '72168959', '20', 'Résidence', NULL, '2022-01-14 13:08:07', '2022-01-14 14:08:07'),
(15, 'RESIDENCE LA COMLOBE II', '56', NULL, '73 48 59 74', '28', 'Résidence', NULL, '2022-01-14 20:08:48', '2022-01-14 14:08:48'),
(16, 'AUBERGE LA PERLE', '20', NULL, '70 26 42 88 /  71 75 97 31', '10', 'Auberge', NULL, '2022-01-14 20:09:24', '2022-01-14 14:09:24'),
(17, 'AUBERGE LA SOURCE', '20', NULL, '78 66 08 63', '10', 'Auberge', NULL, '2022-01-14 20:10:08', '2022-01-14 14:10:08'),
(18, 'AUBERGE LE CALCIO', '30', NULL, '70 48 41 95', '15', 'Auberge', NULL, '2022-01-14 20:10:51', '2022-01-14 14:10:51'),
(19, 'AUBERGE LE PRINCE', '20', NULL, '70 37 60 01 / 79279429', '10', 'Auberge', NULL, '2022-01-14 20:11:20', '2022-01-14 14:11:20'),
(20, 'AUBERGE MODESTE', '54', NULL, '70 24 79 21', '27', 'Auberge', NULL, '2022-01-14 20:11:55', '2022-01-14 14:11:55'),
(21, 'AUBERGE MODESTE 2', '11', NULL, '70 24 79 21', '11', 'Auberge', NULL, '2022-01-14 20:12:34', '2022-01-14 14:12:34'),
(22, 'AUBERGE NEBNOOMA', '28', NULL, '79208454 /  54580583', '14', 'Auberge', NULL, '2022-01-14 20:13:06', '2022-01-14 14:13:06'),
(23, 'AUBERGE NERWAYA DE KOKOLOGHO II', '30', NULL, '79 46 58 92', '15', 'Auberge', NULL, '2022-01-14 20:13:38', '2022-01-14 14:13:38'),
(24, 'AUBERGE NOUVELLE ALLIANCES', '18', NULL, '68 19 85 48', '9', 'Auberge', NULL, '2022-01-14 20:14:12', '2022-01-14 14:14:12'),
(25, 'AUBERGE SONGUI', '24', NULL, '72 41 38 50 /  25 44 10 43', '12', 'Auberge', NULL, '2022-01-14 20:14:41', '2022-01-14 14:14:41'),
(26, 'AUBERGE SYLVANA ANNEXE', '20', NULL, '70476105 / 70480712', '10', 'Auberge', NULL, '2022-01-14 20:15:10', '2022-01-14 14:15:10'),
(27, 'AUBERGE TEEGA WENDE', '14', NULL, '78 69 61 56', '7', 'Auberge', NULL, '2022-01-14 20:15:37', '2022-01-14 14:15:37'),
(28, 'AUBERGE TOP CLASS', '23', NULL, '78 92 29 11', '15', 'Auberge', NULL, '2022-01-14 20:16:09', '2022-01-14 14:16:09'),
(29, 'AUBERGE TOULIST ROYAL', '24', NULL, '73 85 86 86 /  78 19 38 90', '12', 'Auberge', NULL, '2022-01-14 20:16:37', '2022-01-14 14:16:37'),
(30, 'HOTEL TOULOUROU', '46', NULL, '25440170', '23', 'Hôtel', NULL, '2022-01-14 20:17:17', '2022-01-14 14:17:17'),
(31, 'AUBERGE WEND-M\'MI', '22', NULL, '63604499', '11', 'Auberge', NULL, '2022-01-14 20:18:04', '2022-01-14 14:18:04'),
(32, 'MAISON D’HOTE   WEND-YAM GUEST HOUSE', '10', NULL, NULL, '5', 'Maison d\'hôte', NULL, '2022-01-14 20:18:48', '2022-01-14 14:18:48'),
(33, 'AUBERGE YEELBA', '38', NULL, '60 01 70 27', '19', 'Auberge', NULL, '2022-01-14 20:19:38', '2022-01-14 14:19:38'),
(34, 'AUBERGE YILYMDE', '36', NULL, '78716420', '18', 'Auberge', NULL, '2022-01-14 20:20:11', '2022-01-14 14:20:11'),
(35, 'CENTRE D’ACCUEIL H. B', '18', NULL, '78 97 72 33', '9', 'Auberge', NULL, '2022-01-14 20:20:47', '2022-01-14 14:20:47'),
(36, 'HOTEL BON SEJOUR', '40', NULL, '78 54 30 01 / 78073989', '20', 'Auberge', NULL, '2022-01-14 20:23:01', '2022-01-14 14:23:01'),
(37, 'HOTEL SOMKIETA ZAMA I', '30', NULL, '70 25 78 55', '15', 'Auberge', NULL, '2022-01-14 20:29:52', '2022-01-14 14:29:52'),
(38, 'HOTEL SOMKIETA ZAMA II', '42', NULL, '70 25 78 55 / 25440770', '21', 'Auberge', NULL, '2022-01-14 20:30:44', '2022-01-14 14:30:44'),
(39, 'HOTEL SOMKIETA ZAMA III', '22', NULL, '25 44 90 49', '11', 'Auberge', NULL, '2022-01-14 20:31:12', '2022-01-14 14:31:12'),
(40, 'LOUNAT HEBERGEMENT', '16', NULL, '56922205', '8', 'Auberge', NULL, '2022-01-14 13:32:42', '2022-01-14 14:32:42'),
(41, 'MAISON D’HOTE NERWAYA', '14', NULL, '71 31 04 05', '7', 'Auberge', NULL, '2022-01-14 20:34:33', '2022-01-14 14:34:33'),
(42, 'MAISON D\'HOTE DAFRA', '10', NULL, '78847764 /  65218773', '5', 'Maison d\'hôte', NULL, '2022-01-14 20:35:09', '2022-01-14 14:35:09'),
(43, 'MOTEL WENDWAOGA', '14', NULL, '73 32 59 20', '7', 'Auberge', NULL, '2022-01-14 20:35:41', '2022-01-14 14:35:41'),
(44, 'ORNELA HEBERGEMENT', '20', NULL, '70487444', '10', 'Auberge', NULL, '2022-01-14 20:36:11', '2022-01-14 14:36:11'),
(45, 'PENSION LAZARE', '34', NULL, '78 29 10 10', '17', 'Auberge', NULL, '2022-01-14 20:36:41', '2022-01-14 14:36:41'),
(46, 'RESIDENCE G.D', '20', NULL, '67 35 21 04', '10', 'Auberge', NULL, '2022-01-14 20:37:07', '2022-01-14 14:37:07'),
(47, 'RESIDENCE LE BAOBAB', '22', NULL, '70 26 78 89', '11', 'Auberge', NULL, '2022-01-14 20:37:36', '2022-01-14 14:37:36'),
(48, 'BON SEJOUR ANNEXE I', '40', NULL, '77483077', '20', 'Auberge', NULL, '2022-01-14 20:38:04', '2022-01-14 14:38:04'),
(49, 'BON SEJOUR ANNEXE II', '20', NULL, '77483077', '10', 'Auberge', NULL, '2022-01-14 20:38:37', '2022-01-14 14:38:37'),
(50, 'AUBERGE VILLETTE', '20', NULL, NULL, '10', 'Résidence', NULL, '2022-01-14 20:39:03', '2022-01-14 14:39:03'),
(51, 'CENTRE ABBE PIERRE', '100', NULL, '71 31 04 05', '33', 'Autres', NULL, '2022-01-14 20:39:41', '2022-01-14 14:39:41'),
(52, 'CENTRE D’ACCUEIL ENVIRONNEMENT', '32', NULL, '76 40 73 24', '16', 'Autres', NULL, '2022-01-14 20:40:24', '2022-01-14 14:40:24'),
(53, 'CENTRE D’ACCUEIL PETIT SEMINAIRE', '52', NULL, '61 67 71 10', '26', 'Autres', NULL, '2022-01-14 20:41:08', '2022-01-14 14:41:08'),
(54, 'CENTRE OCADES', '43', NULL, '61 67 71 10', '24', 'Autres', NULL, '2022-01-14 20:41:42', '2022-01-14 14:41:42'),
(55, 'CHIC HOTEL', '108', NULL, '25 44 18 56 /  78 86 41 60', '54', 'Hôtel', NULL, '2022-01-14 20:43:02', '2022-01-14 14:43:02'),
(56, 'EXCELLENCE HOTEL', '154', NULL, '25 44 02 59 /  7073 62 62', '76', 'Hôtel', NULL, '2022-01-14 20:44:05', '2022-01-14 14:44:05'),
(57, 'HOTEL BENEBSOUKA', '96', NULL, '25 44 00 42 /  70 20 61 41', '48', 'Hôtel', NULL, '2022-01-14 20:44:46', '2022-01-14 14:44:46'),
(58, 'HOTEL LA CONSOLATRICE', '34', NULL, '70 25 58 79', '17', 'Hôtel', NULL, '2022-01-14 20:45:24', '2022-01-14 14:45:24'),
(59, 'HOTEL DE L’AMITIE', '82', NULL, '70 23 26 78', '29', 'Hôtel', NULL, '2022-01-14 20:46:12', '2022-01-14 14:46:12'),
(60, 'HOTEL DENVER', '40', NULL, '25 44 18 83', '20', 'Hôtel', NULL, '2022-01-14 20:46:45', '2022-01-14 14:46:45'),
(61, 'HOTEL DIMA', '197', NULL, '25 44 19 96', '78', 'Hôtel', NULL, '2022-01-14 20:47:44', '2022-01-14 14:47:44'),
(62, 'HOTEL JACKSON', '54', NULL, '69 13 19 85', '27', 'Hôtel', NULL, '2022-01-14 20:48:19', '2022-01-14 14:48:19'),
(63, 'HOTEL KOUDOUGOU', '32', NULL, '73 01 44 44', '16', 'Hôtel', NULL, '2022-01-14 20:48:58', '2022-01-14 14:48:58'),
(64, 'HOTEL LA PAIX', '48', NULL, NULL, '24', 'Hôtel', NULL, '2022-01-14 20:49:18', '2022-01-14 14:49:18'),
(65, 'HOTEL OGAZA', '63', NULL, '70 11 74 75 /  69 13 19 85', '27', 'Hôtel', NULL, '2022-01-14 20:49:52', '2022-01-14 14:49:52'),
(66, 'HOTEL PHOTO LUXE', '63', NULL, '25 44 00 87 /  70 65 42 87', '35', 'Hôtel', NULL, '2022-01-14 20:50:26', '2022-01-14 14:50:26'),
(67, 'HOTEL POUSGA', '70', NULL, '25 44 03 30', '28', 'Hôtel', NULL, '2022-01-14 20:50:53', '2022-01-14 14:50:53'),
(68, 'HOTEL POUSGA ANNEXE', '16', NULL, '25 44 03 30', '12', 'Hôtel', NULL, '2022-01-14 20:53:09', '2022-01-14 14:53:09'),
(69, 'RAMON WENDE HOTEL', '96', NULL, '25 44 00 85 /  71 40 76 60', '50', 'Hôtel', NULL, '2022-01-14 20:53:57', '2022-01-14 14:53:57'),
(70, 'HOTEL SPLENDIDE', '234', NULL, '70 20 44 19', '117', 'Hôtel', NULL, '2022-01-14 20:54:32', '2022-01-14 14:54:32'),
(71, 'RESIDENCE YIDJENDJA', '20', NULL, '76 75 94 71 /  58 89 21 63', '10', 'Résidence', NULL, '2022-01-14 20:55:00', '2022-01-14 14:55:00'),
(72, 'LA CASA', '10', NULL, '61 67 71 10 / 51010909', '5', 'Autres', NULL, '2022-01-14 20:55:27', '2022-01-14 14:55:27'),
(73, 'RESIDENCE ALICE', '54', NULL, '75 13 53 54', '27', 'Résidence', NULL, '2022-01-14 20:55:57', '2022-01-14 14:55:57'),
(74, 'RESIDENCE BURKINDI', '13', NULL, '69 13 19 85', '10', 'Résidence', NULL, '2022-01-14 20:56:31', '2022-01-14 14:56:31'),
(75, 'RESIDENCE CENDRION', '34', NULL, '70 67 82 00', '19', 'Résidence', NULL, '2022-01-14 20:57:00', '2022-01-14 14:57:00'),
(76, 'RESIDENCE EDIDIA', '28', NULL, '78 14 55 70', '14', 'Résidence', NULL, '2022-01-14 20:57:29', '2022-01-14 14:57:29'),
(77, 'RESIDENCE EVERGREEN', '26', NULL, '72460885', '13', 'Résidence', NULL, '2022-01-14 20:57:57', '2022-01-14 14:57:57'),
(78, 'RESIDENCE FADILAH', '32', NULL, '64202525', '16', 'Résidence', NULL, '2022-01-14 20:58:25', '2022-01-14 14:58:25'),
(79, 'RESIDENCE IPALA', '32', NULL, NULL, '16', 'Résidence', NULL, '2022-01-14 20:59:33', '2022-01-14 14:59:33'),
(80, 'RESIDENCE NAZEMSE', '22', NULL, '70 48 43 19', '11', 'Résidence', NULL, '2022-01-14 21:00:01', '2022-01-14 15:00:01'),
(81, 'RESIDENCE PHILIP\'S', '20', NULL, '66 21 94 14', '10', 'Résidence', NULL, '2022-01-14 21:01:55', '2022-01-14 15:01:55'),
(82, 'RESIDENCE POKO', '20', NULL, '7026 58 57', '10', 'Résidence', NULL, '2022-01-14 21:02:21', '2022-01-14 15:02:21'),
(83, 'RESIDENCE POKO ANNEXE', '30', NULL, '70 26 58 57', '15', 'Résidence', NULL, '2022-01-14 21:02:51', '2022-01-14 15:02:51'),
(84, 'RESIDENCE REANE', '30', NULL, '61 66 76 36', '15', 'Résidence', NULL, '2022-01-14 21:03:19', '2022-01-14 15:03:19'),
(85, 'RESIDENCE REEL', '29', NULL, '78 14 05 15 / 64 81 81 50', '15', 'Résidence', NULL, '2022-01-14 21:04:35', '2022-01-14 15:04:35'),
(86, 'RESIDENCE SHALOM', '42', NULL, '25 44 11 41', '21', 'Résidence', NULL, '2022-01-14 21:05:02', '2022-01-14 15:05:02'),
(87, 'RESIDENCE SONDON NINGBE', '20', NULL, '70 32 10 10 /  55 55 33 00', '10', 'Résidence', NULL, '2022-01-14 21:05:28', '2022-01-14 15:05:28'),
(88, 'RESIDENCE SYLVANA', '14', NULL, '70 47 61 05', '7', 'Résidence', NULL, '2022-01-14 21:05:56', '2022-01-14 15:05:56'),
(89, 'RESIDENCE TARBALA', '52', NULL, '70 28 07 46', '26', 'Résidence', NULL, '2022-01-14 21:06:32', '2022-01-14 15:06:32'),
(90, 'RESIDENCE TEEGA WENDE', '14', NULL, '78 69 61 56', '7', 'Résidence', NULL, '2022-01-14 21:06:54', '2022-01-14 15:06:54'),
(91, 'RESIDENCE TIGBO', '40', NULL, '70 26 66 96', '20', 'Résidence', NULL, '2022-01-14 21:07:18', '2022-01-14 15:07:18'),
(92, 'RESIDENCE VIP', '16', NULL, NULL, '8', 'Résidence', NULL, '2022-01-14 21:07:37', '2022-01-14 15:07:37'),
(93, 'RESIDENCE WENDMI', '12', NULL, '75 13 53 54', '6', 'Résidence', NULL, '2022-01-14 21:08:04', '2022-01-14 15:08:04'),
(94, 'RESIDENCE YAM', '14', NULL, '78 16 99 90', '7', 'Résidence', NULL, '2022-01-14 21:08:28', '2022-01-14 15:08:28'),
(95, 'RESIDENCE YIDJEDJA', '20', NULL, '70 77 30 05', '10', 'Résidence', NULL, '2022-01-14 21:08:56', '2022-01-14 15:08:56');

-- --------------------------------------------------------

--
-- Structure de la table `indisponibilite_participants`
--

CREATE TABLE `indisponibilite_participants` (
  `id` int(11) NOT NULL,
  `participant_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `creneau_id` int(11) DEFAULT NULL,
  `dispo` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `intervenants`
--

CREATE TABLE `intervenants` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `langue_id` int(11) DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `interventions`
--

CREATE TABLE `interventions` (
  `activite_id` int(11) NOT NULL,
  `intervenant_id` int(11) DEFAULT NULL,
  `traducteur_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `langues`
--

CREATE TABLE `langues` (
  `id` int(11) NOT NULL,
  `libelle_eng` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `langues`
--

INSERT INTO `langues` (`id`, `libelle_eng`, `created_at`, `updated_at`) VALUES
(4, 'Anglais', '2021-09-09 13:13:54', '2021-09-09 06:13:54'),
(5, 'Espagnol', '2021-09-09 13:13:54', '2021-09-09 06:13:54'),
(7, 'Francais', '2021-09-09 13:13:54', '2021-09-09 06:13:54');

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

CREATE TABLE `membres` (
  `id` int(11) NOT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `tel_part` varchar(255) DEFAULT NULL,
  `entreprise_id` int(11) DEFAULT NULL,
  `delegation_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `pays_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `type_id` int(11) DEFAULT NULL,
  `contenu` varchar(255) DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `date_envoi` date DEFAULT NULL,
  `nbr_pax` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `officiels`
--

CREATE TABLE `officiels` (
  `id` int(11) NOT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `fonction` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `officiel_participants`
--

CREATE TABLE `officiel_participants` (
  `id` int(11) NOT NULL,
  `participant_id` int(11) DEFAULT NULL,
  `officiel_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `heure_debut` varchar(255) DEFAULT NULL,
  `heure_fin` varchar(255) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `status` tinyint(4) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `organisateurs`
--

CREATE TABLE `organisateurs` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `pays_id` int(11) DEFAULT NULL,
  `portable` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `langue_id` int(11) DEFAULT NULL,
  `email_org` varchar(255) DEFAULT NULL,
  `logo1` varchar(255) DEFAULT NULL,
  `color1` varchar(255) DEFAULT NULL,
  `color2` varchar(255) DEFAULT NULL,
  `souscription_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `participants`
--

CREATE TABLE `participants` (
  `id` int(11) NOT NULL,
  `genre` varchar(255) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `fonction` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `tel_part` varchar(255) DEFAULT NULL,
  `langue_id` int(11) DEFAULT NULL,
  `entreprise_id` int(11) DEFAULT NULL,
  `delegation_id` int(11) DEFAULT NULL,
  `admin` int(11) DEFAULT NULL,
  `demande_officiel` varchar(255) DEFAULT NULL,
  `presence` tinyint(4) DEFAULT NULL,
  `kit` tinyint(4) DEFAULT 0,
  `stand` tinyint(4) DEFAULT 0,
  `event_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `voyage_id` int(11) DEFAULT NULL,
  `profil` tinyint(4) DEFAULT 0,
  `pays_id` int(11) DEFAULT NULL,
  `hebergement` tinyint(1) DEFAULT 0,
  `visa` tinyint(1) DEFAULT 0,
  `b2g` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `participants`
--

INSERT INTO `participants` (`id`, `genre`, `nom`, `prenom`, `fonction`, `email`, `password`, `tel_part`, `langue_id`, `entreprise_id`, `delegation_id`, `admin`, `demande_officiel`, `presence`, `kit`, `stand`, `event_id`, `user_id`, `voyage_id`, `profil`, `pays_id`, `hebergement`, `visa`, `b2g`, `created_at`, `updated_at`) VALUES
(351, NULL, 'Buya', 'Jonathan', 'DG', 'christiannamaisha@gmail.com', NULL, '777772038', 7, 94, NULL, NULL, NULL, 1, 0, 0, 12, 1008, NULL, 1, 1, 0, 0, NULL, '2022-08-30 12:59:53', '2022-08-30 12:59:53'),
(352, NULL, 'Ndiaye', 'Gnagna', 'DIRECTEUR GENERAL ADJOINT', 'gnagna@gmail.com', NULL, NULL, NULL, 93, NULL, NULL, NULL, NULL, 0, 0, 12, 1009, NULL, 0, NULL, 0, 0, 0, '2022-08-30 11:06:02', '2022-08-30 13:06:02'),
(354, NULL, 'Fall', 'Hassan', 'CEO', 'hassan@gmail.com', NULL, '34567222', 4, 96, NULL, NULL, NULL, 1, 0, 0, 12, 1011, NULL, 1, 142, 0, 0, NULL, '2022-08-30 13:32:04', '2022-08-30 13:32:04'),
(355, NULL, 'Ndiaye', 'Aziz', 'CEO', 'aziz@gmail.com', NULL, '7745362037', 7, 97, NULL, NULL, NULL, 1, 0, 0, 12, 1012, NULL, 1, 1, 0, 0, NULL, '2022-09-02 09:21:39', '2022-09-02 09:21:39'),
(356, NULL, 'jjj', 'jjjj', 'Project assistant', 'josue.t@illimitis.com', NULL, '65923587', 4, 99, NULL, NULL, NULL, 1, 1, 1, 12, 1013, NULL, 1, 5, NULL, 1, NULL, '2023-11-09 13:09:13', '2023-11-09 13:09:13'),
(357, NULL, 'dvx', 'cxc', NULL, 'gnagna.n@illimitis.com', NULL, '456789', 7, NULL, NULL, NULL, NULL, 1, 0, 0, 12, 1014, NULL, 1, 142, 0, 0, 0, '2023-11-09 13:23:58', '2023-11-09 13:23:58');

-- --------------------------------------------------------

--
-- Structure de la table `pass`
--

CREATE TABLE `pass` (
  `id` int(11) NOT NULL,
  `activite_id` int(11) DEFAULT NULL,
  `prix` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

CREATE TABLE `pays` (
  `id` int(11) NOT NULL,
  `libelle_fr` varchar(255) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `pays`
--

INSERT INTO `pays` (`id`, `libelle_fr`, `event_id`, `created_at`, `updated_at`) VALUES
(1, 'Senegal', 1, '2020-12-03 23:02:41', '2019-12-06 13:28:35'),
(2, 'Mali', 1, '2020-12-03 23:02:41', '2019-11-26 23:17:57'),
(3, 'Ghana', 1, '2020-12-03 23:02:41', '2019-11-26 23:18:08'),
(4, 'Cap-vert', 1, '2020-12-03 23:02:41', '2019-11-26 23:18:19'),
(5, 'Burkina Faso', 1, '2020-12-03 23:02:41', '2019-12-06 13:28:26'),
(6, 'Sudan', 1, '2020-12-03 23:02:41', '2019-11-26 23:18:34'),
(7, 'Nigeria', 1, '2020-12-03 23:02:41', '2019-11-26 23:18:44'),
(8, 'Togo', 1, '2020-12-03 23:02:41', '2019-11-26 23:18:51'),
(9, 'RD Congo', 1, '2020-12-03 23:02:41', '2019-11-26 23:19:10'),
(10, 'Afrique du Sud', 1, '2020-12-29 08:38:04', '2020-12-29 01:38:04'),
(11, 'Namibie', 1, '2020-12-03 23:02:41', '2019-11-26 23:19:38'),
(12, 'Zambie', 1, '2020-12-03 23:02:41', '2019-11-26 23:19:46'),
(13, 'Côte d\'Ivoire', 1, '2020-12-03 23:02:41', '2019-11-26 23:23:14'),
(14, 'Algérie', 1, '2020-12-03 23:02:41', '2019-11-26 23:23:24'),
(16, 'Egypte', 1, '2020-12-03 23:02:41', '2019-11-26 23:23:36'),
(17, 'Somalie', 1, '2020-12-03 23:02:41', '2019-11-26 23:23:43'),
(18, 'Angola', 1, '2020-12-03 23:02:41', '2019-11-26 23:25:23'),
(19, 'Bénin', 1, '2020-12-03 23:02:41', '2019-11-26 23:25:33'),
(20, 'Botswana', 1, '2020-12-03 23:02:41', '2019-11-26 23:25:54'),
(21, 'Burundi', 1, '2020-12-03 23:02:41', '2019-11-26 23:26:10'),
(22, 'Cameroun', 1, '2020-12-03 23:02:41', '2019-11-26 23:26:18'),
(23, 'République centrafricaine', 1, '2020-12-03 23:02:41', '2019-11-26 23:26:49'),
(24, 'Comores', 1, '2020-12-03 23:02:41', '2019-11-26 23:26:59'),
(25, 'Congo', 1, '2020-12-03 23:02:41', '2019-11-26 23:27:13'),
(26, 'Djibouti', 1, '2020-12-03 23:02:41', '2019-11-26 23:27:33'),
(27, 'Érythrée', 1, '2020-12-03 23:02:41', '2019-11-26 23:27:55'),
(28, 'Éthiopie', 1, '2020-12-03 23:02:41', '2019-11-26 23:28:06'),
(29, 'Gabon', 1, '2020-12-03 23:02:41', '2019-11-26 23:28:14'),
(30, 'Gambie', 1, '2020-12-03 23:02:41', '2019-11-26 23:28:22'),
(31, 'Guiné-Bissau', 1, '2020-12-03 23:02:41', '2019-11-26 23:28:39'),
(32, 'Guiné-équatoriale', 1, '2020-12-03 23:02:41', '2019-11-26 23:28:59'),
(33, 'Kenya', 1, '2020-12-03 23:02:41', '2019-11-26 23:29:09'),
(34, 'Lesotho', 1, '2020-12-03 23:02:41', '2019-11-26 23:29:28'),
(35, 'Libéria', 1, '2020-12-03 23:02:41', '2019-11-26 23:29:47'),
(36, 'Libye', 1, '2020-12-03 23:02:41', '2019-11-26 23:29:59'),
(37, 'Madagascar', 1, '2020-12-03 23:02:41', '2019-11-26 23:30:48'),
(38, 'Malawi', 1, '2020-12-03 23:02:41', '2019-11-26 23:31:08'),
(39, 'Maroc', 1, '2020-12-03 23:02:41', '2019-11-26 23:31:22'),
(40, 'Maurice', 1, '2020-12-03 23:02:41', '2019-11-26 23:31:44'),
(41, 'Mauritanie', 1, '2020-12-03 23:02:41', '2019-11-26 23:32:05'),
(42, 'Mozambique', 1, '2020-12-03 23:02:41', '2019-11-26 23:32:21'),
(43, 'Niger', 1, '2020-12-03 23:02:41', '2019-11-26 23:32:28'),
(44, 'Ouganda', 1, '2020-12-03 23:02:41', '2019-11-26 23:32:45'),
(45, 'Rwanda', 1, '2020-12-03 23:02:41', '2019-11-26 23:33:02'),
(46, 'Sao Tomé-et-Principe', 1, '2020-12-03 23:02:41', '2019-11-26 23:33:27'),
(47, 'Seychelles', 1, '2020-12-03 23:02:41', '2019-11-26 23:33:46'),
(48, 'Sierra Leone', 1, '2020-12-03 23:02:41', '2019-11-26 23:33:59'),
(49, 'Sud-Soudan', 1, '2020-12-03 23:02:41', '2019-11-26 23:34:15'),
(50, 'Swaziland', 1, '2020-12-03 23:02:41', '2019-11-26 23:34:31'),
(51, 'Tanzanie', 1, '2020-12-03 23:02:41', '2019-11-26 23:34:50'),
(52, 'Tchad', 1, '2020-12-03 23:02:41', '2019-11-26 23:35:04'),
(53, 'Tunisie', 1, '2020-12-03 23:02:41', '2019-11-26 23:35:13'),
(54, 'Zimbabwe', 1, '2020-12-03 23:02:41', '2019-11-26 23:35:37'),
(55, 'Allemagne', 1, '2020-12-03 23:02:41', '2019-11-26 23:36:15'),
(56, 'Albanie', 1, '2020-12-03 23:02:41', '2019-11-26 23:36:22'),
(57, 'France', 1, '2020-12-03 23:02:41', '2019-11-26 23:36:30'),
(58, 'Italie', 1, '2020-12-03 23:02:41', '2019-11-26 23:36:38'),
(59, 'Portugal', 1, '2020-12-03 23:02:41', '2019-11-26 23:36:45'),
(60, 'Espagne', 1, '2020-12-03 23:02:41', '2019-11-26 23:36:53'),
(61, 'Grèce', 1, '2020-12-03 23:02:41', '2019-11-26 23:37:39'),
(62, 'Belgique', 1, '2020-12-03 23:02:41', '2019-11-26 23:37:50'),
(63, 'Andorre', 1, '2020-12-03 23:02:41', '2019-11-26 23:38:07'),
(64, 'Arménie', 1, '2020-12-03 23:02:41', '2019-11-26 23:38:25'),
(65, 'Autriche', 1, '2020-12-03 23:02:41', '2019-11-26 23:38:34'),
(66, 'Azerbaïdjan', 1, '2020-12-03 23:02:41', '2019-11-26 23:39:24'),
(67, 'Biélorussie', 1, '2020-12-03 23:02:41', '2019-11-26 23:39:53'),
(68, 'Bosnie-Herzégovnie', 1, '2020-12-03 23:02:41', '2019-11-26 23:40:17'),
(69, 'Bulgarie', 1, '2020-12-03 23:02:41', '2019-11-26 23:40:28'),
(70, 'Chypre', 1, '2020-12-03 23:02:41', '2019-11-26 23:40:38'),
(71, 'Croatie', 1, '2020-12-03 23:02:41', '2019-11-26 23:40:47'),
(72, 'Danemark', 1, '2020-12-03 23:02:41', '2019-11-26 23:40:59'),
(73, 'Estonie', 1, '2020-12-03 23:02:41', '2019-11-26 23:41:11'),
(74, 'Finlande', 1, '2020-12-03 23:02:41', '2019-11-26 23:41:32'),
(75, 'Géorgie', 1, '2020-12-03 23:02:41', '2019-11-26 23:41:46'),
(76, 'Hongrie', 1, '2020-12-03 23:02:41', '2019-11-26 23:41:56'),
(77, 'Irlande', 1, '2020-12-03 23:02:41', '2019-11-26 23:42:04'),
(78, 'Islande', 1, '2020-12-03 23:02:41', '2019-11-26 23:42:12'),
(79, 'Lettonie', 1, '2020-12-03 23:02:41', '2019-11-26 23:42:25'),
(80, 'Liechtenstein', 1, '2020-12-03 23:02:41', '2019-11-26 23:42:50'),
(81, 'Lituanie', 1, '2020-12-03 23:02:41', '2019-11-26 23:43:17'),
(82, 'Luxembourg', 1, '2020-12-03 23:02:41', '2019-11-26 23:43:33'),
(83, 'République deMacédoine', 1, '2020-12-03 23:02:41', '2019-11-26 23:44:10'),
(84, 'Malte', 1, '2020-12-03 23:02:41', '2019-11-26 23:44:20'),
(85, 'Moldavie', 1, '2020-12-03 23:02:41', '2019-11-26 23:44:31'),
(86, 'Monaco', 1, '2020-12-03 23:02:41', '2019-11-26 23:44:40'),
(87, 'Monténégro', 1, '2020-12-03 23:02:41', '2019-11-26 23:45:02'),
(88, 'Norvège', 1, '2020-12-03 23:02:41', '2019-11-26 23:45:20'),
(89, 'Pays-Bas', 1, '2020-12-03 23:02:41', '2019-11-26 23:45:34'),
(90, 'Pologne', 1, '2020-12-03 23:02:41', '2019-11-26 23:45:40'),
(91, 'République tchèque', 1, '2020-12-03 23:02:41', '2019-11-26 23:46:06'),
(92, 'Roumanie', 1, '2020-12-03 23:02:41', '2019-11-26 23:46:15'),
(93, 'Royaume-Uni', 1, '2020-12-03 23:02:41', '2019-11-26 23:46:31'),
(94, 'Russie', 1, '2020-12-03 23:02:41', '2019-11-26 23:46:41'),
(95, 'Saint-Marin', 1, '2020-12-03 23:02:41', '2019-11-26 23:47:02'),
(96, 'Serbie', 1, '2020-12-03 23:02:41', '2019-11-26 23:47:13'),
(97, 'Slovaquie', 1, '2020-12-03 23:02:41', '2019-11-26 23:47:26'),
(98, 'Slovénie', 1, '2020-12-03 23:02:41', '2019-11-26 23:47:38'),
(99, 'Suède', 1, '2020-12-03 23:02:41', '2019-11-26 23:47:50'),
(100, 'Suisse', 1, '2020-12-03 23:02:41', '2019-11-26 23:47:59'),
(101, 'Ukraine', 1, '2020-12-03 23:02:41', '2019-11-26 23:48:18'),
(102, 'Vatican', 1, '2020-12-03 23:02:41', '2019-11-26 23:48:30'),
(103, 'Antigua-Barbuda', 1, '2020-12-03 23:02:41', '2019-11-27 10:11:11'),
(104, 'Argentine', 1, '2020-12-03 23:02:41', '2019-11-27 10:11:19'),
(105, 'Bahamas', 1, '2020-12-03 23:02:41', '2019-11-27 10:11:30'),
(106, 'Barbade', 1, '2020-12-03 23:02:41', '2019-11-27 10:11:43'),
(107, 'Belize', 1, '2020-12-03 23:02:41', '2019-11-27 10:11:54'),
(108, 'Bolivie', 1, '2020-12-03 23:02:41', '2019-11-27 10:12:02'),
(109, 'Brésil', 1, '2020-12-03 23:02:41', '2019-11-27 10:12:14'),
(110, 'Canada', 1, '2020-12-03 23:02:41', '2019-11-27 10:12:20'),
(111, 'Chili', 1, '2020-12-03 23:02:41', '2019-11-27 10:12:31'),
(112, 'Colombie', 1, '2020-12-03 23:02:41', '2019-11-27 10:12:37'),
(113, 'Costa Rica', 1, '2020-12-03 23:02:41', '2019-11-27 10:12:47'),
(114, 'Cuba', 1, '2020-12-03 23:02:41', '2019-11-27 10:12:53'),
(115, 'République dominicaine', 1, '2020-12-03 23:02:41', '2019-11-27 10:13:22'),
(116, 'Dominique', 1, '2020-12-03 23:02:41', '2019-11-27 10:13:31'),
(117, 'Équateur', 1, '2020-12-03 23:02:41', '2019-11-27 10:13:51'),
(118, 'États-Unis', 1, '2020-12-03 23:02:41', '2020-01-08 13:41:35'),
(119, 'Grenade', 1, '2020-12-03 23:02:41', '2019-11-27 10:14:25'),
(120, 'Guatemala', 1, '2020-12-03 23:02:41', '2019-11-27 10:14:41'),
(121, 'Guyana', 1, '2020-12-03 23:02:41', '2019-11-27 10:14:48'),
(122, 'Haïti', 1, '2020-12-03 23:02:41', '2019-11-27 10:15:02'),
(123, 'Honduras', 1, '2020-12-03 23:02:41', '2019-11-27 10:15:12'),
(124, 'Jamaïque', 1, '2020-12-03 23:02:41', '2019-11-27 10:15:33'),
(125, 'Mexique', 1, '2020-12-03 23:02:41', '2019-11-27 10:15:42'),
(126, 'Nicaragua', 1, '2020-12-03 23:02:41', '2019-11-27 10:15:55'),
(127, 'Panama', 1, '2020-12-03 23:02:41', '2019-11-27 10:16:04'),
(128, 'Paraguay', 1, '2020-12-03 23:02:41', '2019-11-27 10:16:30'),
(129, 'Pérou', 1, '2020-12-03 23:02:41', '2019-11-27 10:16:38'),
(130, 'Porto Rico', 1, '2020-12-03 23:02:41', '2019-11-27 10:16:50'),
(131, 'Saint-Christophe-et-Niévès', 1, '2020-12-03 23:02:41', '2019-11-27 10:17:25'),
(132, 'Sainte-Lucie', 1, '2020-12-03 23:02:41', '2019-11-27 10:17:40'),
(133, 'Saint-vincenr-et-les-Grenadines', 1, '2020-12-03 23:02:41', '2019-11-27 10:18:17'),
(134, 'Salvador', 1, '2020-12-03 23:02:41', '2019-11-27 10:18:26'),
(135, 'Suriname', 1, '2020-12-03 23:02:41', '2019-11-27 10:18:35'),
(136, 'Trinité-et-Tobago', 1, '2020-12-03 23:02:41', '2019-11-27 10:19:00'),
(137, 'Uruguay', 1, '2020-12-03 23:02:41', '2019-11-27 10:19:15'),
(138, 'Venzuela', 1, '2020-12-03 23:02:41', '2019-11-27 10:19:27'),
(139, 'Afghanistan', 1, '2020-12-03 23:02:41', '2019-11-27 10:20:16'),
(140, 'Arabie Saoudite', 1, '2020-12-03 23:02:41', '2019-11-27 10:20:34'),
(141, 'Bahreïn', 1, '2020-12-03 23:02:41', '2019-11-27 10:20:58'),
(142, 'Bangladesh', 1, '2020-12-03 23:02:41', '2019-11-27 10:21:10'),
(143, 'Bhoutan', 1, '2020-12-03 23:02:41', '2019-11-27 10:21:18'),
(144, 'Birmanie', 1, '2020-12-03 23:02:41', '2019-11-27 10:21:31'),
(145, 'Brunei', 1, '2020-12-03 23:02:41', '2019-11-27 10:21:41'),
(146, 'Cambodge', 1, '2020-12-03 23:02:41', '2019-11-27 10:22:00'),
(147, 'Chine', 1, '2020-12-03 23:02:41', '2019-11-27 10:22:06'),
(148, 'Corée du Nord', 1, '2020-12-03 23:02:41', '2019-11-27 10:22:19'),
(149, 'Corée du Sud', 1, '2020-12-03 23:02:41', '2019-11-27 10:22:29'),
(150, 'Émirats Arabies Unis', 1, '2020-12-03 23:02:41', '2019-11-27 10:22:52'),
(151, 'Inde', 1, '2020-12-03 23:02:41', '2019-11-27 10:22:57'),
(152, 'Indonésie', 1, '2020-12-03 23:02:41', '2019-11-27 10:23:11'),
(153, 'Irak', 1, '2020-12-03 23:02:41', '2019-11-27 10:23:20'),
(154, 'Iran', 1, '2020-12-03 23:02:41', '2019-11-27 10:23:27'),
(155, 'Israël', 1, '2020-12-03 23:02:41', '2019-11-27 10:23:40'),
(156, 'Japon', 1, '2020-12-03 23:02:41', '2019-11-27 10:23:46'),
(157, 'Jordanie', 1, '2020-12-03 23:02:41', '2019-11-27 10:23:59'),
(158, 'Kazakhstan', 1, '2020-12-03 23:02:41', '2019-11-27 10:24:25'),
(159, 'Kazakhizistan', 1, '2020-12-03 23:02:41', '2019-11-27 10:24:53'),
(160, 'Koweït', 1, '2020-12-03 23:02:41', '2019-11-27 10:25:22'),
(161, 'Laos', 1, '2020-12-03 23:02:41', '2019-11-27 10:25:27'),
(162, 'Liban', 1, '2020-12-03 23:02:41', '2019-11-27 10:25:32'),
(163, 'Malaisie', 1, '2020-12-03 23:02:41', '2019-11-27 10:25:45'),
(164, 'Maldives', 1, '2020-12-03 23:02:41', '2019-11-27 10:25:54'),
(165, 'Mongolie', 1, '2020-12-03 23:02:41', '2019-11-27 10:26:24'),
(166, 'Népal', 1, '2020-12-03 23:02:41', '2019-11-27 10:26:32'),
(167, 'Oman', 1, '2020-12-03 23:02:41', '2019-11-27 10:26:37'),
(168, 'Ouzbékistan', 1, '2020-12-03 23:02:41', '2019-11-27 10:26:54'),
(169, 'Palestine', 1, '2020-12-03 23:02:41', '2019-11-27 10:27:08'),
(170, 'Pakistan', 1, '2020-12-03 23:02:41', '2019-11-27 10:27:19'),
(171, 'Philippines', 1, '2020-12-03 23:02:41', '2019-11-27 10:27:43'),
(172, 'Qatar', 1, '2020-12-03 23:02:41', '2019-11-27 10:27:53'),
(173, 'Singapour', 1, '2020-12-03 23:02:41', '2019-11-27 10:28:08'),
(174, 'Sri Lanka', 1, '2020-12-03 23:02:41', '2019-11-27 10:28:18'),
(175, 'Syrie', 1, '2020-12-03 23:02:41', '2019-11-27 10:28:29'),
(176, 'Tadjikistan', 1, '2020-12-03 23:02:41', '2019-11-27 10:28:51'),
(177, 'Taïwan', 1, '2020-12-03 23:02:41', '2019-11-27 10:29:04'),
(178, 'Thaïlande', 1, '2020-12-03 23:02:41', '2019-11-27 10:29:14'),
(179, 'Timor Oriental', 1, '2020-12-03 23:02:41', '2019-11-27 10:29:30'),
(180, 'Turkménistan', 1, '2020-12-03 23:02:41', '2019-11-27 10:30:03'),
(181, 'Turquie', 1, '2020-12-03 23:02:41', '2019-11-27 10:30:13'),
(182, 'Viêt Nam', 1, '2020-12-03 23:02:41', '2019-11-27 10:30:27'),
(183, 'Yémen', 1, '2020-12-03 23:02:41', '2019-11-27 10:30:41'),
(184, 'Australie', 1, '2020-12-03 23:02:41', '2019-11-27 10:31:06'),
(185, 'Fidji', 1, '2020-12-03 23:02:41', '2019-11-27 10:31:15'),
(186, 'Kiribati', 1, '2020-12-03 23:02:41', '2019-11-27 10:31:23'),
(187, 'Marshall', 1, '2020-12-03 23:02:41', '2019-11-27 10:31:36'),
(188, 'Micronésie', 1, '2020-12-03 23:02:41', '2019-11-27 10:31:53'),
(189, 'Nauru', 1, '2020-12-03 23:02:41', '2019-11-27 10:32:04'),
(190, 'Nouvelle-Zélande', 1, '2020-12-03 23:02:41', '2019-11-27 10:32:29'),
(191, 'Palaos', 1, '2020-12-03 23:02:41', '2019-11-27 10:32:38'),
(192, 'Papouasie-Nouvelle-Guinée', 1, '2020-12-03 23:02:41', '2019-11-27 10:33:53'),
(193, 'Salomon', 1, '2020-12-03 23:02:41', '2019-11-27 10:34:11'),
(194, 'Samoa', 1, '2020-12-03 23:02:41', '2019-11-27 10:34:32'),
(195, 'Tonga', 1, '2020-12-03 23:02:41', '2019-11-27 10:34:58'),
(196, 'Tuvalu', 1, '2020-12-03 23:02:41', '2019-11-27 10:35:20'),
(197, 'Vanuatu', 1, '2020-12-03 23:02:41', '2019-11-27 10:35:39');

-- --------------------------------------------------------

--
-- Structure de la table `plannings`
--

CREATE TABLE `plannings` (
  `id` int(11) NOT NULL,
  `entreprise_id` int(11) DEFAULT NULL,
  `entreprise_rv_id` int(11) DEFAULT NULL,
  `lang_1` varchar(255) DEFAULT NULL,
  `lang_2` varchar(255) DEFAULT NULL,
  `priorite` int(11) NOT NULL,
  `libelle_t` varchar(20) NOT NULL,
  `date_rv` date NOT NULL,
  `heure_deb` varchar(10) NOT NULL,
  `heure_fin` varchar(10) NOT NULL,
  `lien` varchar(255) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `start_url` text DEFAULT NULL,
  `join_url` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `status_rv` tinyint(4) DEFAULT NULL,
  `ok_10` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `facilitateur_id` int(11) DEFAULT NULL,
  `traducteur_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `etats` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `plannings`
--

INSERT INTO `plannings` (`id`, `entreprise_id`, `entreprise_rv_id`, `lang_1`, `lang_2`, `priorite`, `libelle_t`, `date_rv`, `heure_deb`, `heure_fin`, `lien`, `sale_id`, `start_url`, `join_url`, `password`, `duration`, `status_rv`, `ok_10`, `user_id`, `event_id`, `facilitateur_id`, `traducteur_id`, `created_at`, `updated_at`, `etats`) VALUES
(7, 97, 93, NULL, NULL, 1, 'Table 1', '2021-10-08', '09:30', '10:00', '0', 1, 'https://us05web.zoom.us/s/82756452797?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4Mjc1NjQ1Mjc5NyIsInN0ayI6IkUxUjcwRkJZUmV6UFQ5UFhrdHhUdElSb2JNWVJuSDlPbENvTVBRMnhqS1UuQUcuc3RGMUFrS0Q0U3Q1ZVJ4WXZEZDVDYWZqN0pCeEY3US0zNGlYQlhKT2NMN2VQM0VTNVdJWnlYTmxSSlNxbDkwbDJuSTcxVlluMDd2SF9NdjAuRk5WMlpYSVJQUzZLRHNpdWo0NUtfQS4zT1dpSGR3NTQ1YjVpOEtvIiwiZXhwIjoxNjMyNDA1NzA4LCJpYXQiOjE2MzIzOTg1MDgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.aBcJj0dtk8r_mj-CkpUoTQZ3KauKVLlbqh9iljgBxp0', 'https://us05web.zoom.us/j/82756452797?pwd=N3M4d0sxZ1hTVmNqQWVVWkMxdzlMdz09', 'H5YsFG', 30, 0, 1, 1012, 7, NULL, NULL, '2022-09-02 09:32:47', '0000-00-00 00:00:00', 0),
(8, 93, 97, NULL, NULL, 1, 'Table 1', '2021-10-08', '09:30', '10:00', '0', 1, 'https://us05web.zoom.us/s/82756452797?zak=eyJ0eXAiOiJKV1QiLCJzdiI6IjAwMDAwMSIsInptX3NrbSI6InptX28ybSIsImFsZyI6IkhTMjU2In0.eyJhdWQiOiJjbGllbnRzbSIsInVpZCI6IlNrazFIQVJKUWxxNXV0QU5tUzZ3UWciLCJpc3MiOiJ3ZWIiLCJzdHkiOjEsIndjZCI6InVzMDUiLCJjbHQiOjAsIm1udW0iOiI4Mjc1NjQ1Mjc5NyIsInN0ayI6IkUxUjcwRkJZUmV6UFQ5UFhrdHhUdElSb2JNWVJuSDlPbENvTVBRMnhqS1UuQUcuc3RGMUFrS0Q0U3Q1ZVJ4WXZEZDVDYWZqN0pCeEY3US0zNGlYQlhKT2NMN2VQM0VTNVdJWnlYTmxSSlNxbDkwbDJuSTcxVlluMDd2SF9NdjAuRk5WMlpYSVJQUzZLRHNpdWo0NUtfQS4zT1dpSGR3NTQ1YjVpOEtvIiwiZXhwIjoxNjMyNDA1NzA4LCJpYXQiOjE2MzIzOTg1MDgsImFpZCI6IkJYTDJSM0lFUUFxSmVickFyMmN3ZmciLCJjaWQiOiIifQ.aBcJj0dtk8r_mj-CkpUoTQZ3KauKVLlbqh9iljgBxp0', 'https://us05web.zoom.us/j/82756452797?pwd=N3M4d0sxZ1hTVmNqQWVVWkMxdzlMdz09', 'H5YsFG', 30, 0, 1, 1012, 7, NULL, NULL, '2022-09-02 09:32:47', '0000-00-00 00:00:00', 0);

-- --------------------------------------------------------

--
-- Structure de la table `plannings_rvs`
--

CREATE TABLE `plannings_rvs` (
  `id` int(11) NOT NULL,
  `entreprise_id` int(11) DEFAULT NULL,
  `entreprise_rv_id` int(11) DEFAULT NULL,
  `lang_1` varchar(255) DEFAULT NULL,
  `lang_2` varchar(255) DEFAULT NULL,
  `priorite` int(11) NOT NULL,
  `libelle_t` varchar(20) NOT NULL,
  `date_rv` date NOT NULL,
  `heure_deb` varchar(10) NOT NULL,
  `heure_fin` varchar(10) NOT NULL,
  `lien` varchar(255) DEFAULT NULL,
  `sale_id` int(11) DEFAULT NULL,
  `start_url` text DEFAULT NULL,
  `join_url` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `duration` int(11) DEFAULT NULL,
  `status_rv` tinyint(4) DEFAULT NULL,
  `ok_10` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `facilitateur_id` int(11) DEFAULT NULL,
  `traducteur_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `etats` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Structure de la table `planning_fs`
--

CREATE TABLE `planning_fs` (
  `id` int(11) NOT NULL,
  `entreprise_id` int(11) DEFAULT NULL,
  `entreprise_rv_id` int(11) DEFAULT NULL,
  `langue_ent_1` varchar(255) DEFAULT NULL,
  `langue_ent_2` varchar(255) DEFAULT NULL,
  `priorite` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` tinyint(1) DEFAULT 0,
  `etats` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `planning_fs`
--

INSERT INTO `planning_fs` (`id`, `entreprise_id`, `entreprise_rv_id`, `langue_ent_1`, `langue_ent_2`, `priorite`, `user_id`, `event_id`, `created_at`, `updated_at`, `status`, `etats`) VALUES
(164, 97, 93, NULL, NULL, 1, 1012, 1, '2022-09-02 09:32:47', '0000-00-00 00:00:00', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `produit_services`
--

CREATE TABLE `produit_services` (
  `id` int(11) NOT NULL,
  `entreprise_id` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `profils`
--

CREATE TABLE `profils` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `profil_rechercher_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `profils`
--

INSERT INTO `profils` (`id`, `libelle`, `profil_rechercher_id`, `event_id`, `created_at`, `updated_at`) VALUES
(1, 'Consultant / Consultant', 21, 1, '2020-12-14 20:09:58', '2020-12-14 13:09:58'),
(2, 'Distributeur / Distributor', 8, 1, '2020-12-03 23:03:18', '2019-12-06 11:12:02'),
(3, 'Fabricant / Manufacturer', 9, 1, '2020-12-03 23:03:18', '2019-12-06 11:12:24'),
(4, 'Investisseur / Investor', 10, 1, '2020-12-03 23:03:18', '2019-12-06 11:12:33'),
(5, 'Importateur / Importer', 11, 1, '2020-12-03 23:03:18', '2019-12-06 11:12:41'),
(6, 'Prestataire de services', NULL, 1, '2020-12-03 23:03:18', '2019-11-27 09:30:24'),
(7, 'Sous-traitant / Subcontractor', 12, 1, '2020-12-03 23:03:18', '2019-12-06 11:12:59'),
(8, 'Innovation, R&D / Innovation, R&D', 13, 1, '2020-12-03 23:03:18', '2019-12-06 11:13:09'),
(9, 'Technologie / Technology', 14, 1, '2020-12-03 23:03:18', '2019-12-06 11:13:19'),
(10, 'Partenaire Technique / Technical Partner', 24, 1, '2020-12-29 08:39:32', '2020-12-29 01:39:32'),
(11, 'Autres / Others', 17, 1, '2020-12-03 23:03:18', '2019-12-06 11:14:07'),
(12, 'Partenaire Institutionnel / Institutionnal Partner', 16, 1, '2020-12-03 23:03:18', '2019-12-06 11:14:00');

-- --------------------------------------------------------

--
-- Structure de la table `publicites`
--

CREATE TABLE `publicites` (
  `id` int(11) NOT NULL,
  `sponsor_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `salles`
--

CREATE TABLE `salles` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `salles`
--

INSERT INTO `salles` (`id`, `libelle`, `created_at`, `updated_at`) VALUES
(1, 'Nelson Mandela', '2021-09-09 10:57:27', NULL),
(2, 'Cheikh Anta Diop', '2021-09-09 10:57:27', NULL),
(3, 'Obama', '2021-09-09 10:57:27', NULL),
(4, 'Abdoulaye Wade', '2021-09-09 10:57:27', NULL),
(5, 'Toma Sankara', '2021-09-09 10:57:27', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `secteur_activites`
--

CREATE TABLE `secteur_activites` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `secteur_activite_rechercher_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `secteur_activites`
--

INSERT INTO `secteur_activites` (`id`, `libelle`, `secteur_activite_rechercher_id`, `event_id`, `created_at`, `updated_at`) VALUES
(1, 'Agriculture et agro-alimentaire / Agriculture and food processing', 0, 1, '2021-10-07 14:07:39', '2021-10-07 14:07:39'),
(2, 'Biens de consommation / Consumption Goods', 0, 1, '2020-12-03 23:06:37', '2019-12-02 16:56:33'),
(3, 'Environnement / Environment', 8, 1, '2020-12-03 23:06:37', '2019-12-06 11:07:20'),
(4, 'Industrie textile / Textile Industry', 0, 1, '2020-12-03 23:06:37', '2019-12-02 16:55:40'),
(5, 'Energie / Energy', 0, 1, '2020-12-03 23:06:37', '2019-12-02 16:57:07'),
(6, 'Tourisme / Tourism', 9, 1, '2020-12-03 23:06:37', '2019-12-06 11:07:36'),
(7, 'TIC et innovation / ICT and innovation', 11, 1, '2020-12-03 23:06:37', '2019-12-06 11:08:01'),
(9, 'Artisanat / Arts and crafts', 12, 1, '2020-12-03 23:06:37', '2019-12-06 11:08:37'),
(10, 'Distribution / Distribution', 13, 1, '2020-12-03 23:06:37', '2019-12-06 11:08:48'),
(11, 'Industrie manufacturière / Manufacturing industry', 14, 1, '2020-12-03 23:06:37', '2019-12-06 11:09:07'),
(12, 'Services aux entreprises / Business services', 15, 1, '2020-12-03 23:06:37', '2019-12-06 11:09:20'),
(13, 'BTP / Construction and public works', 16, 1, '2020-12-03 23:06:37', '2019-12-06 11:09:50'),
(14, 'Activités médicales et pharmaceutiques / Medical and pharmaceutical activities', 17, 1, '2020-12-03 23:06:37', '2019-12-06 11:10:13'),
(15, 'Transport & Logistique / Transportation and Logistics', 18, 1, '2020-12-03 23:06:37', '2019-12-06 11:10:43'),
(16, 'Autres / Others', 22, 1, '2020-12-19 19:29:56', '2020-12-15 07:02:25');

-- --------------------------------------------------------

--
-- Structure de la table `sejour_participants`
--

CREATE TABLE `sejour_participants` (
  `id` int(11) NOT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `statut` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `heure_debut` varchar(255) DEFAULT NULL,
  `heure_fin` varchar(255) DEFAULT NULL,
  `participant_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `souhaites`
--

CREATE TABLE `souhaites` (
  `id` int(11) NOT NULL,
  `entreprise_id` int(11) DEFAULT NULL,
  `entreprise_rv_id` int(11) DEFAULT NULL,
  `priorite` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `etats` tinyint(4) DEFAULT 0,
  `langue_ent_1` varchar(255) DEFAULT NULL,
  `langue_ent_2` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `souhaites`
--

INSERT INTO `souhaites` (`id`, `entreprise_id`, `entreprise_rv_id`, `priorite`, `status`, `etats`, `langue_ent_1`, `langue_ent_2`, `user_id`, `event_id`, `created_at`, `updated_at`) VALUES
(39, 97, 93, 1, 1, 1, NULL, NULL, 1012, 12, '2022-09-02 07:28:57', '2022-09-02 07:31:31');

-- --------------------------------------------------------

--
-- Structure de la table `souhaits`
--

CREATE TABLE `souhaits` (
  `id` int(11) NOT NULL,
  `entreprise_id` int(11) DEFAULT NULL,
  `entreprise_rv_id` int(11) DEFAULT NULL,
  `priorite` int(11) DEFAULT NULL,
  `priorite_a` tinyint(4) DEFAULT 0,
  `status` tinyint(4) DEFAULT NULL,
  `etats` tinyint(4) DEFAULT 0,
  `langue_ent_1` varchar(255) DEFAULT NULL,
  `langue_ent_2` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `souhaits`
--

INSERT INTO `souhaits` (`id`, `entreprise_id`, `entreprise_rv_id`, `priorite`, `priorite_a`, `status`, `etats`, `langue_ent_1`, `langue_ent_2`, `user_id`, `event_id`, `created_at`, `updated_at`) VALUES
(1205, 1, 2, 0, 0, 0, 0, NULL, NULL, 724, 1, NULL, NULL),
(1206, 1, 3, 0, 0, 0, 0, NULL, NULL, 724, 1, NULL, NULL),
(1207, 1, 4, 0, 0, 0, 0, NULL, NULL, 724, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `souhaits_rvs`
--

CREATE TABLE `souhaits_rvs` (
  `id` int(11) NOT NULL,
  `entreprise_id` int(11) DEFAULT NULL,
  `entreprise_rv_id` int(11) DEFAULT NULL,
  `priorite` int(11) DEFAULT NULL,
  `priorite_a` tinyint(4) DEFAULT 0,
  `status` tinyint(4) DEFAULT NULL,
  `etats` tinyint(4) DEFAULT 0,
  `langue_ent_1` varchar(255) DEFAULT NULL,
  `langue_ent_2` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `souhaits_rvs`
--

INSERT INTO `souhaits_rvs` (`id`, `entreprise_id`, `entreprise_rv_id`, `priorite`, `priorite_a`, `status`, `etats`, `langue_ent_1`, `langue_ent_2`, `user_id`, `event_id`, `created_at`, `updated_at`) VALUES
(18479, 1, 2, 0, 0, 0, 0, NULL, NULL, 724, 1, NULL, NULL),
(18480, 1, 3, 0, 0, 0, 0, NULL, NULL, 724, 1, NULL, NULL),
(18481, 1, 4, 0, 0, 0, 0, NULL, NULL, 724, 1, NULL, NULL),
(18482, 1, 2, 0, 0, 0, 0, NULL, NULL, 724, 1, NULL, NULL),
(18483, 1, 3, 0, 0, 0, 0, NULL, NULL, 724, 1, NULL, NULL),
(18484, 1, 4, 0, 0, 0, 0, NULL, NULL, 724, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `souhait_fs`
--

CREATE TABLE `souhait_fs` (
  `id` int(11) NOT NULL DEFAULT 0,
  `entreprise_id` int(11) DEFAULT NULL,
  `entreprise_rv_id` int(11) DEFAULT NULL,
  `priorite` int(11) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `langue_ent_1` varchar(255) DEFAULT NULL,
  `langue_ent_2` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Déchargement des données de la table `souhait_fs`
--

INSERT INTO `souhait_fs` (`id`, `entreprise_id`, `entreprise_rv_id`, `priorite`, `status`, `langue_ent_1`, `langue_ent_2`, `user_id`, `event_id`, `created_at`, `updated_at`) VALUES
(0, 97, 93, 1, 1, NULL, NULL, 1012, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `souscriptions`
--

CREATE TABLE `souscriptions` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated-at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sponsors`
--

CREATE TABLE `sponsors` (
  `id` int(11) NOT NULL,
  `nom_sponsor` varchar(255) DEFAULT NULL,
  `ordre` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `categorie_id` int(11) DEFAULT NULL,
  `logo1` varchar(255) DEFAULT NULL,
  `logo2` varchar(255) DEFAULT NULL,
  `logo3` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `sponsors`
--

INSERT INTO `sponsors` (`id`, `nom_sponsor`, `ordre`, `event_id`, `categorie_id`, `logo1`, `logo2`, `logo3`, `created_at`, `updated_at`) VALUES
(2, 'APEX', 2, NULL, NULL, 'apex.png', NULL, NULL, '2021-10-14 19:00:21', '2021-10-14 12:00:21'),
(3, 'ABI', 3, NULL, NULL, 'Abi.png', NULL, NULL, '2021-10-14 19:00:35', '2021-10-14 12:00:35'),
(4, 'Chambre de Commerce', 4, NULL, NULL, 'chammbre de commerce.png', NULL, NULL, '2021-10-14 19:00:58', '2021-10-14 12:00:58'),
(5, 'FILSAH', 5, NULL, NULL, 'filsah.png', NULL, NULL, '2021-10-14 19:02:10', '2021-10-14 12:02:10'),
(6, 'AFP', 6, NULL, NULL, 'afp.png', NULL, NULL, '2021-10-14 19:02:31', '2021-10-14 12:02:31'),
(7, 'SOFITEX', 7, NULL, NULL, 'sofitex.png', NULL, NULL, '2021-10-14 19:03:02', '2021-10-14 12:03:02');

-- --------------------------------------------------------

--
-- Structure de la table `tables`
--

CREATE TABLE `tables` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `tables`
--

INSERT INTO `tables` (`id`, `libelle`, `created_at`, `updated_at`) VALUES
(1, 'table 1', '2021-09-09 10:54:34', NULL),
(2, 'table 1', '2021-09-09 10:54:34', NULL),
(3, 'table 2', '2021-09-09 10:54:34', NULL),
(4, 'table 3', '2021-09-09 10:54:34', NULL),
(5, 'table 4', '2021-09-09 10:54:34', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `traducteurs`
--

CREATE TABLE `traducteurs` (
  `id` int(11) NOT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `tel` varchar(255) DEFAULT NULL,
  `langue_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `types`
--

CREATE TABLE `types` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `types`
--

INSERT INTO `types` (`id`, `libelle`, `created_at`, `updated_at`) VALUES
(2, 'Hotesse', '2021-10-13 22:27:40', '2021-10-13 15:27:40'),
(3, 'Journaliste', '2021-10-13 22:28:25', '2021-10-13 15:28:25'),
(4, 'Membre comité', '2021-10-13 22:31:06', '2021-10-13 15:31:06'),
(5, 'Gestionnaire SICOT ROOM', '2021-10-13 22:31:06', '2021-10-13 15:31:06'),
(6, 'Panneliste', '2021-10-20 16:32:34', '2021-10-20 18:32:34'),
(7, 'Gestionnaire SICOT', '2021-10-20 16:32:56', '2021-10-20 18:32:56'),
(8, 'Maître de cérémonie', '2021-10-20 16:33:58', '2021-10-20 18:33:58');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `identite` varchar(255) DEFAULT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `portable` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `pays_id` int(11) DEFAULT NULL,
  `langue_id` int(11) DEFAULT NULL,
  `admin` varchar(255) DEFAULT NULL,
  `kit` tinyint(4) DEFAULT NULL,
  `stand` int(11) DEFAULT NULL,
  `code_event` varchar(50) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `delegation_id` int(11) DEFAULT NULL,
  `photo` varchar(255) DEFAULT 'placeholder.png',
  `presence` tinyint(1) DEFAULT NULL,
  `entreprise_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `profil` tinyint(4) DEFAULT 0,
  `need` int(11) DEFAULT 1,
  `b2g` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `identite`, `nom`, `prenom`, `email`, `portable`, `password`, `pays_id`, `langue_id`, `admin`, `kit`, `stand`, `code_event`, `event_id`, `delegation_id`, `photo`, `presence`, `entreprise_id`, `user_id`, `profil`, `need`, `b2g`, `created_at`, `updated_at`) VALUES
(5, NULL, 'Admin', 'Mister', 'admin@optievent.com', '3377749926', '$2y$10$isx5gd9Ey8AADoK9M1agfOSuXfylUP8Dhwo/GaYCjfhMzhxZ0Qlty', 1, 1, '1', 0, 0, 'RAF 2022', NULL, NULL, 'placeholder.png', NULL, NULL, NULL, 0, 0, 0, '2022-08-30 12:39:16', '2021-10-16 14:19:27'),
(1008, NULL, 'Buya', 'Jonathan', 'christiannamaisha@gmail.com', '777772038', '$2y$10$isx5gd9Ey8AADoK9M1agfOSuXfylUP8Dhwo/GaYCjfhMzhxZ0Qlty', 1, 7, NULL, NULL, NULL, NULL, 12, NULL, 'col10.png', NULL, NULL, NULL, 1, 1, 0, '2022-08-30 13:40:52', '2022-08-30 13:05:09'),
(1009, NULL, 'Ndiaye', 'Gnagna', 'gnagna@gmail.com', '779890665', '$2y$10$isx5gd9Ey8AADoK9M1agfOSuXfylUP8Dhwo/GaYCjfhMzhxZ0Qlty', NULL, NULL, NULL, NULL, NULL, NULL, 12, NULL, 'placeholder.png', NULL, NULL, NULL, 0, 1, 0, '2022-08-30 13:41:01', '2022-08-30 13:06:02'),
(1011, NULL, 'Fall', 'Hassan', 'hassan@gmail.com', '34567222', '$2y$10$isx5gd9Ey8AADoK9M1agfOSuXfylUP8Dhwo/GaYCjfhMzhxZ0Qlty', 142, 4, NULL, NULL, NULL, NULL, 12, NULL, 'placeholder.png', NULL, NULL, NULL, 1, 1, 0, '2022-08-30 13:41:12', '2022-08-30 13:30:41'),
(1012, NULL, 'Ndiaye', 'Aziz', 'aziz@gmail.com', '7745362037', '$2y$10$1ijwUPSbblsT68.5B71jNuToBhUuFXfao5RNCXYxWx6pzxRH6V39u', 1, 7, NULL, NULL, NULL, NULL, 12, NULL, 'email_signature collaboratis (2).png', NULL, NULL, NULL, 1, 1, 0, '2022-09-02 09:25:05', '2022-09-02 09:25:05'),
(1013, NULL, 'jjj', 'jjjj', 'josue.t@illimitis.com', '65923587', '$2y$10$.UmXI4r1.clhuUzZuSUuv.nbVxL2Pj8dXqznVUEJXvfoeZafO4lD6', 5, 4, NULL, NULL, NULL, NULL, 12, NULL, 'placeholder.png', NULL, NULL, NULL, 1, 1, 0, '2023-11-09 12:06:00', '2023-11-09 13:06:00'),
(1014, NULL, 'dvx', 'cxc', 'gnagna.n@illimitis.com', '456789', '$2y$10$y1R3177iqlF2zEZJmhMVtuOh6VQUyQgKgon9uNsa3mro95m7ndaAO', 142, 7, NULL, NULL, NULL, NULL, 12, NULL, 'placeholder.png', NULL, NULL, NULL, 1, 1, 0, '2023-11-09 12:23:11', '2023-11-09 13:23:11');

-- --------------------------------------------------------

--
-- Structure de la table `voyages`
--

CREATE TABLE `voyages` (
  `id` int(11) NOT NULL,
  `obtention_visa` varchar(255) DEFAULT NULL,
  `date_passeport` date DEFAULT NULL,
  `date_arriver` date DEFAULT NULL,
  `heure_depart` varchar(255) DEFAULT NULL,
  `date_depart` varchar(255) DEFAULT NULL,
  `heure_arrive` varchar(255) DEFAULT NULL,
  `echeance_passeport` date DEFAULT NULL,
  `nationalite` varchar(255) DEFAULT NULL,
  `numero_vol_depart` varchar(255) DEFAULT NULL,
  `numero_vol_arrivee` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `achat_tickets`
--
ALTER TABLE `achat_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `activites`
--
ALTER TABLE `activites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `chambres`
--
ALTER TABLE `chambres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `chef_delegations`
--
ALTER TABLE `chef_delegations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `creneaus`
--
ALTER TABLE `creneaus`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `creneaus_rvs`
--
ALTER TABLE `creneaus_rvs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `demande_b2gs`
--
ALTER TABLE `demande_b2gs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `entreprises`
--
ALTER TABLE `entreprises`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `facilitateurs`
--
ALTER TABLE `facilitateurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `indisponibilite_participants`
--
ALTER TABLE `indisponibilite_participants`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `intervenants`
--
ALTER TABLE `intervenants`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `langues`
--
ALTER TABLE `langues`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `membres`
--
ALTER TABLE `membres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `officiels`
--
ALTER TABLE `officiels`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `officiel_participants`
--
ALTER TABLE `officiel_participants`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `organisateurs`
--
ALTER TABLE `organisateurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pass`
--
ALTER TABLE `pass`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `pays`
--
ALTER TABLE `pays`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `plannings`
--
ALTER TABLE `plannings`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `plannings_rvs`
--
ALTER TABLE `plannings_rvs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `planning_fs`
--
ALTER TABLE `planning_fs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `produit_services`
--
ALTER TABLE `produit_services`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `profils`
--
ALTER TABLE `profils`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `publicites`
--
ALTER TABLE `publicites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `salles`
--
ALTER TABLE `salles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `secteur_activites`
--
ALTER TABLE `secteur_activites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sejour_participants`
--
ALTER TABLE `sejour_participants`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `souhaites`
--
ALTER TABLE `souhaites`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `souhaits`
--
ALTER TABLE `souhaits`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `souhaits_rvs`
--
ALTER TABLE `souhaits_rvs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `souscriptions`
--
ALTER TABLE `souscriptions`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sponsors`
--
ALTER TABLE `sponsors`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `traducteurs`
--
ALTER TABLE `traducteurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `voyages`
--
ALTER TABLE `voyages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `achat_tickets`
--
ALTER TABLE `achat_tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `activites`
--
ALTER TABLE `activites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `chambres`
--
ALTER TABLE `chambres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `chef_delegations`
--
ALTER TABLE `chef_delegations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `creneaus`
--
ALTER TABLE `creneaus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT pour la table `creneaus_rvs`
--
ALTER TABLE `creneaus_rvs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1314;

--
-- AUTO_INCREMENT pour la table `demande_b2gs`
--
ALTER TABLE `demande_b2gs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `entreprises`
--
ALTER TABLE `entreprises`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT pour la table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `facilitateurs`
--
ALTER TABLE `facilitateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `hotels`
--
ALTER TABLE `hotels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT pour la table `indisponibilite_participants`
--
ALTER TABLE `indisponibilite_participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `intervenants`
--
ALTER TABLE `intervenants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `langues`
--
ALTER TABLE `langues`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT pour la table `membres`
--
ALTER TABLE `membres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `officiels`
--
ALTER TABLE `officiels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `officiel_participants`
--
ALTER TABLE `officiel_participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `organisateurs`
--
ALTER TABLE `organisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=358;

--
-- AUTO_INCREMENT pour la table `pass`
--
ALTER TABLE `pass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `pays`
--
ALTER TABLE `pays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;

--
-- AUTO_INCREMENT pour la table `plannings`
--
ALTER TABLE `plannings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `plannings_rvs`
--
ALTER TABLE `plannings_rvs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT pour la table `planning_fs`
--
ALTER TABLE `planning_fs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `produit_services`
--
ALTER TABLE `produit_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `profils`
--
ALTER TABLE `profils`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `publicites`
--
ALTER TABLE `publicites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `salles`
--
ALTER TABLE `salles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `secteur_activites`
--
ALTER TABLE `secteur_activites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `sejour_participants`
--
ALTER TABLE `sejour_participants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `souhaites`
--
ALTER TABLE `souhaites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT pour la table `souhaits`
--
ALTER TABLE `souhaits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1208;

--
-- AUTO_INCREMENT pour la table `souhaits_rvs`
--
ALTER TABLE `souhaits_rvs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18485;

--
-- AUTO_INCREMENT pour la table `souscriptions`
--
ALTER TABLE `souscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `sponsors`
--
ALTER TABLE `sponsors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `traducteurs`
--
ALTER TABLE `traducteurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1015;

--
-- AUTO_INCREMENT pour la table `voyages`
--
ALTER TABLE `voyages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
