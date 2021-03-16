-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le :  mar. 16 mars 2021 à 00:42
-- Version du serveur :  5.7.28
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `api_products_managing`
--

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(44, '2014_10_12_000000_create_users_table', 1),
(45, '2014_10_12_100000_create_password_resets_table', 1),
(46, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(47, '2019_08_19_000000_create_failed_jobs_table', 1),
(48, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(49, '2021_01_27_133157_create_product_states_table', 1),
(50, '2021_01_27_133204_create_sell_states_table', 1),
(51, '2021_01_28_171204_create_websites_table', 1),
(52, '2021_01_29_162038_create_products_table', 1),
(53, '2021_01_30_133117_create_purchases_table', 1),
(54, '2021_01_30_133142_create_sellings_table', 1),
(55, '2021_01_30_140624_create_product_photos_table', 1),
(56, '2021_02_17_120228_create_product_website_table', 1),
(57, '2021_02_19_135025_create_sessions_table', 1),
(58, '2021_03_05_103756_create_product_users_table', 1),
(63, '2021_03_05_103756_create_notifications_table', 2),
(64, '2021_03_15_125202_add_user_id_to_purchases', 2),
(65, '2021_03_15_125440_add_user_id_to_sellings', 2),
(74, '2021_03_15_131442_create_product_users_table', 3),
(75, '2021_03_16_001624_add_created_by_to_products', 4);

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `product_website_id` int(10) UNSIGNED NOT NULL,
  `available` tinyint(4) NOT NULL,
  `expired` tinyint(4) NOT NULL,
  `on` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  KEY `notifications_user_id_foreign` (`user_id`),
  KEY `notifications_product_id_foreign` (`product_id`),
  KEY `notifications_product_website_id_foreign` (`product_website_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `limited_edition` int(11) DEFAULT NULL,
  `real_cost` decimal(10,2) NOT NULL,
  `created_by` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `products_created_by_foreign` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `label`, `description`, `limited_edition`, `real_cost`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'BUMBER Panier de Basket pour Enfant - Hauteur réglable jusqu\'à 1m35', 'Le Panier de Basket Atlanta est un produit ludique, pratique et amusant. Il est conçu pour les plus petits , des premiers pas de l\'enfant juqu\'à ses 5 ans en moyenne.\r\n\r\nCe Panier de Basket est un Panier sur pied à roulettes, les paniers mobiles offrent de nombreux avantages dont la mobilité et la simplicité d’usage.\r\n\r\nÉquipez donc votre jardin, entrée de garage, cour, etc...d’un panier de basket!\r\n\r\nFaites-vous plaisir à vos enfants avec ce panier de qualité qui vous apportera de bons moments.', NULL, '49.00', 1, '2021-03-05 10:47:32', '2021-03-05 10:47:32'),
(2, 'Conan le cimmérien - la citadelle écarlate', 'La déchéance d\'un roi. La chute d\'un royaume.\r\n\r\nTout commence sur un champ de bataille. Conan, alors roi d\'Aquilonie, affronte une coalition de traîtres menée par le sorcier Tsotha-Lanthi qui, pour venir à bout de la rage du cimmérien, use de ses sortilèges avant de le neutraliser de la plus lâche des façons. Capturé vivant, Conan est emmené dans les terribles geôles de la citadelle écarlate pour y subir un sort pire que la mort et obtenir son abdication, pendant que les armées du sorcier marchent vers sa capitale. L\'horreur de la prison et la redoutable magie du sorcier auront-elles raison de la résolution inflexible de Conan ? Celui-ci parviendra-t-il à s\'échapper pour rejoindre son peuple à temps ?', NULL, '14.95', 1, '2021-03-05 10:49:04', '2021-03-05 10:49:04'),
(3, 'iPad Air 10,9\'\' 64 Go Gris Sidéral Wi-Fi 4ème génération 2020', 'Contenu du coffret: Câble de charge USB‑C (1 m), Adaptateur secteur USB‑C 20 W; Écran Liquid Retina; Écran Multi‑Touch rétroéclairé par LED avec technologie IPS; 264 pixels par pouce (ppp); Large gamme de couleurs (P3); Affichage True Tone; Revêtement oléophobe résistant aux traces de doigts; Écran laminé; Revêtement antireflet; Réflectance de 1,8 %; Luminance de 500 nits; Compatible avec l’Apple Pencil (2ᵉ génération); Prise en charge du ralenti en 1080p à 120 ou 240 i/s; Accéléré avec stabilisation; Stabilisation vidéo de qualité cinéma (1080p et 720p); Mise au point automatique continue; Réduction du bruit; Prise de photos 8 Mpx pendant l’enregistrement vidéo 4K; Zoom lecture;', NULL, '669.99', 1, '2021-03-05 10:52:07', '2021-03-05 10:52:07'),
(4, 'Aznavour & Friends', 'L\'enregistrement intégral de la soirée anniversaire (80 ans) de Charles Aznavour', NULL, '9.99', 1, '2021-03-05 10:54:09', '2021-03-05 10:54:09'),
(5, 'Topi Games- Bonsoir-Le Jeu de McFly et Carlito société, MAC-CAR-949001, Multicouleur', 'Bonsoir ! Comment vont-je? Êtes-vous prêts? On a adapté et combiné toutes vos vidéos préférées en un seul et unique jeu de société qui, on va pas s’mentir, défonce.\r\nChaque Case du plateau vous invite à relever un défi: on appelle des gens au hasard, concours d’anecdotes, mix’n’twist, blind test des synonymes, le double bac, surcoté/sous-côté et autres encore.\r\nRelève avec tes amis les défis de mcfly et carlito, et revis les différents jeux qui ont fait le succès de leur chaîne.', NULL, '24.99', 1, '2021-03-05 11:00:33', '2021-03-05 11:00:33'),
(6, 'Merchandise Boutique Officielle Game Of Thrones Coussin 38x38 cm Coussinet Inclus Motif Imprimé', 'Assure votre position au sein des sept Royaumes avec ce coussin sous licence officielle Game of Thrones avec la carte de Westeros. Fabriqué en toile tissée. Environ Dimensions : 40 x 40 cm. 100 % polyester. Nettoyage des taches uniquement.', NULL, '9.09', 1, '2021-03-05 11:03:23', '2021-03-05 11:03:23'),
(7, 'Créative Résine Kiki Chat Animal Night Light, Ornements Décoration Cadeau Petite Chat', '1.Vie Funny: la résine Chat animal avec veilleuse décorer votre table et votre bureau, apportant un sourire au cours d\'une vie bien remplie.\r\n2.Decoration maison et jardin: Drôle mini queue de chat de carton avec la lumière de nuit décorer pour miniature micro paysage mini maison de jardin.\r\n3.Pefect Cadeau : la collection de chiffre de poupée de résine de chat est populaire pour des enfants, des enfants, des amants, ils l\'aimeront beaucoup, c\'est le cadeau de geat Sur l\'anniversaire, Noël, Saint-Valentin et ainsi de suite', NULL, '10.00', 1, '2021-03-05 11:04:43', '2021-03-05 11:04:43'),
(8, 'Mon Voisin Totoro Lampe LED Night Light Table De Lecture Lampes de Bureau pour Enfants', 'FUNNY LIFE - Action en résine mignonne Miyazaki Animation Une figurine Totoro avec veilleuse pour décorer votre table et votre bureau, apportant un sourire pendant une vie trépidante, mini lumière blanche et chaleureuse Décorez votre chambre à coucher.', NULL, '15.00', 1, '2021-03-05 11:07:07', '2021-03-05 11:07:07'),
(9, 'WOWOW Gilet jaune Roadie jaune XL', 'La garantie de ce produit est de 2 ans.', NULL, '11.95', 1, '2021-03-05 11:11:04', '2021-03-05 11:11:04'),
(10, 'Casque gaming sans fil Astro A50 Noir + Station d\'accueil pour Xbox', 'Bénéficiez des performances et de la qualité sonore d\'ASTRO Audio V2 avec le confort et la liberté de la technologie sans fil. Le casque sans fil A50 + station d\'accueil pour Xbox offre l\'acoustique, l\'ergonomie, le confort et la résistance dont les joueurs et les streamers ont besoin. Profitez d\'une immersion absolue avec le casque sans fil A50 + station d\'accueil.', NULL, '319.99', 1, '2021-03-05 11:11:56', '2021-03-05 11:11:56'),
(11, 'Daft Punk - Random access memories', 'Plus de deux ans après avoir signé la BO de Tron Legacy, Daft Punk revient enfin avec un véritable album le 20 mai : Random Access Memories. Fidèle à eux-mêmes, les Parisiens livrent l\'information au compte-gouttes, notamment en diffusant lors du fameux Saturday Night Live deux extraits de leur nouvelle production. A l\'écoute des quelques secondes autorisées par le groupe, on a tout de suite pu identifié la marque de fabrique d\'un des collaborateurs annoncés de ce quatrième album, Nile Rodgers de Chic.', NULL, '10.00', 1, '2021-03-05 11:13:23', '2021-03-05 11:13:23'),
(12, 'Vélo assistance électrique Ion Fat 26\' 250 W Noir', 'Moteur : Brushless 24V - 250 Watts ; Batterie : Lithium-ion 24v-7.8aH ; Roues : 26\'; Afficheur : LED - Assistance 3 modes + Aide au démarrage -> 6km/h ; Freins : DISQUE AVANT/ARRIERE - DISC FRONT/REAR ; DERAILLEUR : SHIMANO 6S ; Temps de charge : 5 heures ; Vitesse : 25 km/h ; Autonomie maximale : 35 km', NULL, '899.00', 1, '2021-03-05 11:15:48', '2021-03-05 11:15:48'),
(13, 'HOMY CASA Bureau d\'angle contemporain Arlette Black - PVC - Noir', 'La table vous fournit une grande surface de travail à un prix abordable, tout en économisant l’espace qu’il occupe.\r\n\r\nBureau multifonctionnel, Idéal pour se servir comme un bureau d’ordinateur, d’étude ou de travail.\r\n\r\nOn peut poser ses livres, ustensiles, documents et d’autres choses sur le bureau et c’est possible d’y mettre au moins deux écrans d’affichage pour votre ordi.\r\n\r\nDesign sobre alliant modernité, il ajoutera une touche contemporaine dans votre pièce.', NULL, '185.00', 1, '2021-03-05 11:17:13', '2021-03-05 11:17:13'),
(14, 'MOOVWAY Trottinette électrique Easy-Trott - Noir', '- La trottinette électrique Easy Trott de Moovway -\r\n\r\nCraquez pour la trottinette Easy trott de Moovway.\r\nUne trottinette à petit prix qui simplifiera votre vie.Un moteur 300W qui vous permettra d\'aller jusqu\'à 25 km /h.', NULL, '199.00', 1, '2021-03-05 15:56:31', '2021-03-05 15:56:31');

-- --------------------------------------------------------

--
-- Structure de la table `product_photos`
--

DROP TABLE IF EXISTS `product_photos`;
CREATE TABLE IF NOT EXISTS `product_photos` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int(10) UNSIGNED NOT NULL,
  `label` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `ordered` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_photos_product_id_foreign` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product_photos`
--

INSERT INTO `product_photos` (`id`, `product_id`, `label`, `ordered`, `created_at`, `updated_at`) VALUES
(1, 1, '1.jpg', 1, '2021-03-05 10:47:32', '2021-03-05 10:47:32'),
(2, 1, '2.jpg', 2, '2021-03-05 10:47:44', '2021-03-05 10:47:44'),
(3, 1, '3.jpg', 3, '2021-03-05 10:47:44', '2021-03-05 10:47:44'),
(4, 1, '4.jpg', 4, '2021-03-05 10:47:44', '2021-03-05 10:47:44'),
(5, 2, '1.jpg', 1, '2021-03-05 10:49:04', '2021-03-05 10:49:04'),
(6, 3, '1.jpg', 1, '2021-03-05 10:52:08', '2021-03-05 10:52:08'),
(7, 4, '1.jpg', 1, '2021-03-05 10:54:09', '2021-03-05 10:54:09'),
(8, 5, '1.jpg', 1, '2021-03-05 11:00:33', '2021-03-05 11:00:33'),
(9, 3, '2.jpg', 2, '2021-03-05 11:01:14', '2021-03-05 11:01:14'),
(10, 3, '3.jpg', 3, '2021-03-05 11:01:15', '2021-03-05 11:01:15'),
(11, 3, '4.jpg', 4, '2021-03-05 11:01:15', '2021-03-05 11:01:15'),
(12, 3, '5.jpg', 5, '2021-03-05 11:01:15', '2021-03-05 11:01:15'),
(13, 3, '6.jpg', 6, '2021-03-05 11:01:15', '2021-03-05 11:01:15'),
(14, 6, '1.jpg', 1, '2021-03-05 11:03:23', '2021-03-05 11:03:23'),
(15, 6, '2.jpg', 2, '2021-03-05 11:03:35', '2021-03-05 11:03:35'),
(16, 6, '3.jpg', 3, '2021-03-05 11:03:35', '2021-03-05 11:03:35'),
(17, 6, '4.jpg', 4, '2021-03-05 11:03:35', '2021-03-05 11:03:35'),
(18, 7, '1.jpg', 1, '2021-03-05 11:04:44', '2021-03-05 11:04:44'),
(19, 7, '2.jpg', 2, '2021-03-05 11:05:48', '2021-03-05 11:05:48'),
(20, 7, '3.jpg', 3, '2021-03-05 11:05:48', '2021-03-05 11:05:48'),
(21, 7, '4.jpg', 4, '2021-03-05 11:05:48', '2021-03-05 11:05:48'),
(22, 7, '5.jpg', 5, '2021-03-05 11:05:48', '2021-03-05 11:05:48'),
(23, 7, '6.jpg', 6, '2021-03-05 11:05:48', '2021-03-05 11:05:48'),
(24, 7, '7.jpg', 7, '2021-03-05 11:05:48', '2021-03-05 11:05:48'),
(25, 8, '1.jpg', 1, '2021-03-05 11:07:07', '2021-03-05 11:07:07'),
(26, 9, '1.jpg', 1, '2021-03-05 11:11:05', '2021-03-05 11:11:05'),
(27, 9, '2.jpg', 2, '2021-03-05 11:11:10', '2021-03-05 11:11:10'),
(28, 10, '1.jpg', 1, '2021-03-05 11:11:56', '2021-03-05 11:11:56'),
(29, 10, '2.jpg', 2, '2021-03-05 11:12:26', '2021-03-05 11:12:26'),
(30, 10, '3.jpg', 3, '2021-03-05 11:12:26', '2021-03-05 11:12:26'),
(31, 10, '4.jpg', 4, '2021-03-05 11:12:26', '2021-03-05 11:12:26'),
(32, 10, '5.jpg', 5, '2021-03-05 11:12:26', '2021-03-05 11:12:26'),
(33, 10, '6.jpg', 6, '2021-03-05 11:12:26', '2021-03-05 11:12:26'),
(34, 11, '1.jpg', 1, '2021-03-05 11:13:23', '2021-03-05 11:13:23'),
(35, 12, '1.jpg', 1, '2021-03-05 11:15:48', '2021-03-05 11:15:48'),
(36, 12, '2.jpg', 2, '2021-03-05 11:16:16', '2021-03-05 11:16:16'),
(37, 12, '3.jpg', 3, '2021-03-05 11:16:16', '2021-03-05 11:16:16'),
(38, 12, '4.jpg', 4, '2021-03-05 11:16:16', '2021-03-05 11:16:16'),
(39, 12, '5.jpg', 5, '2021-03-05 11:16:16', '2021-03-05 11:16:16'),
(40, 12, '6.jpg', 6, '2021-03-05 11:16:16', '2021-03-05 11:16:16'),
(41, 12, '7.jpg', 7, '2021-03-05 11:16:16', '2021-03-05 11:16:16'),
(42, 13, '1.jpg', 1, '2021-03-05 11:17:13', '2021-03-05 11:17:13'),
(43, 13, '2.jpg', 2, '2021-03-05 11:19:01', '2021-03-05 11:19:01'),
(44, 13, '3.jpg', 3, '2021-03-05 11:19:01', '2021-03-05 11:19:01'),
(45, 13, '4.jpg', 4, '2021-03-05 11:19:01', '2021-03-05 11:19:01'),
(46, 14, '1.jpg', 1, '2021-03-05 15:56:31', '2021-03-05 15:56:31');

-- --------------------------------------------------------

--
-- Structure de la table `product_states`
--

DROP TABLE IF EXISTS `product_states`;
CREATE TABLE IF NOT EXISTS `product_states` (
  `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_states_label_unique` (`label`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product_states`
--

INSERT INTO `product_states` (`id`, `label`, `created_at`, `updated_at`) VALUES
(1, 'Neuf', '2021-03-05 10:46:26', '2021-03-05 10:46:26'),
(2, 'Occasion', '2021-03-05 10:46:26', '2021-03-05 10:46:26'),
(3, 'Correct', '2021-03-05 10:46:26', '2021-03-05 10:46:26'),
(4, 'Comme neuf', '2021-03-05 10:46:26', '2021-03-05 10:46:26');

-- --------------------------------------------------------

--
-- Structure de la table `product_users`
--

DROP TABLE IF EXISTS `product_users`;
CREATE TABLE IF NOT EXISTS `product_users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED NOT NULL,
  `archive` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_users_user_id_foreign` (`user_id`),
  KEY `product_users_product_id_foreign` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product_users`
--

INSERT INTO `product_users` (`id`, `user_id`, `product_id`, `archive`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, '2021-03-05 10:47:32', '2021-03-05 10:47:32'),
(2, 1, 2, 0, '2021-03-05 10:49:04', '2021-03-05 10:49:04'),
(3, 1, 3, 0, '2021-03-05 10:52:07', '2021-03-05 10:52:07'),
(4, 1, 4, 0, '2021-03-05 10:54:09', '2021-03-05 10:54:09'),
(5, 1, 5, 0, '2021-03-05 11:00:33', '2021-03-05 11:00:33'),
(6, 1, 6, 0, '2021-03-05 11:03:23', '2021-03-05 11:03:23'),
(7, 1, 7, 0, '2021-03-05 11:04:43', '2021-03-05 11:04:43'),
(8, 1, 8, 0, '2021-03-05 11:07:07', '2021-03-05 11:07:07'),
(9, 1, 9, 0, '2021-03-05 11:11:04', '2021-03-05 11:11:04'),
(10, 1, 10, 0, '2021-03-05 11:11:56', '2021-03-05 11:11:56'),
(11, 1, 11, 0, '2021-03-05 11:13:23', '2021-03-05 11:13:23'),
(12, 1, 12, 0, '2021-03-05 11:15:48', '2021-03-05 11:15:48'),
(13, 1, 13, 0, '2021-03-05 11:17:13', '2021-03-05 11:17:13'),
(14, 1, 14, 0, '2021-03-05 15:56:31', '2021-03-05 15:56:31'),
(15, 2, 7, 0, '2021-03-15 21:08:23', '2021-03-15 21:08:23'),
(16, 2, 14, 0, '2021-03-15 23:42:30', '2021-03-15 23:42:30');

-- --------------------------------------------------------

--
-- Structure de la table `product_websites`
--

DROP TABLE IF EXISTS `product_websites`;
CREATE TABLE IF NOT EXISTS `product_websites` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int(10) UNSIGNED NOT NULL,
  `website_id` int(10) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `url` longtext COLLATE utf8mb4_unicode_ci,
  `available_date` datetime DEFAULT NULL,
  `expiration_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_websites_product_id_foreign` (`product_id`),
  KEY `product_websites_website_id_foreign` (`website_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `product_websites`
--

INSERT INTO `product_websites` (`id`, `product_id`, `website_id`, `price`, `url`, `available_date`, `expiration_date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '49.00', 'https://www.amazon.fr/BUMBER-Atlanta-Panier-Basket-Enfant/dp/B0751GTDGK', NULL, NULL, '2021-03-05 10:47:32', '2021-03-05 10:47:32'),
(2, 2, 7, '14.95', 'https://www.cultura.com/conan-le-cimmerien-la-citadelle-ecarlate-9782344022535.html', '2023-02-03 12:49:00', NULL, '2021-03-05 10:49:32', '2021-03-05 10:49:32'),
(3, 4, 5, '9.99', 'https://www.fnac.com/a12993560/Charles-Aznavour-Aznavour-et-Friends-CD-album#omnsearchpos=1', NULL, '2019-12-27 00:00:00', '2021-03-05 10:54:09', '2021-03-05 10:54:09'),
(4, 4, 5, '9.99', 'https://www.fnac.com/a12993560/Charles-Aznavour-Aznavour-et-Friends-CD-album#omnsearchpos=1', '2023-03-01 12:54:00', NULL, '2021-03-05 10:54:37', '2021-03-05 10:54:37'),
(5, 5, 1, '19.84', 'https://www.amazon.fr/Topi-Carlito-soci%C3%A9t%C3%A9-MAC-CAR-949001-Multicouleur/dp/B07QS4QLF1/ref=sr_1_1?dchild=1&keywords=topi+games+bonsoir+mcfly+et+carlito&qid=1614945567&sr=8-1', NULL, NULL, '2021-03-05 11:00:33', '2021-03-05 11:00:33'),
(6, 6, 1, '9.09', 'https://www.amazon.fr/Game-Thrones-Merchandise-Officielle-Coussinet/dp/B07PMQ1SN5/?_encoding=UTF8&pd_rd_w=U1tEO&pf_rd_p=41ac001d-cb4a-4d05-8787-3c4f138c5ff9&pf_rd_r=20V5T8KZ29PNM0E8QEF9&pd_rd_r=bd5a9607-9ad6-4b24-b7f2-bae40d15d66a&pd_rd_wg=LIlJB&ref_=pd_gw_bmx&th=1', NULL, NULL, '2021-03-05 11:03:23', '2021-03-05 11:03:23'),
(7, 7, 1, '8.88', 'https://www.amazon.fr/Cr%C3%A9ative-Ornements-D%C3%A9coration-P%C3%A9pini%C3%A8re-Respiration/dp/B07FQHDGZW/?_encoding=UTF8&pd_rd_w=U1tEO&pf_rd_p=41ac001d-cb4a-4d05-8787-3c4f138c5ff9&pf_rd_r=20V5T8KZ29PNM0E8QEF9&pd_rd_r=bd5a9607-9ad6-4b24-b7f2-bae40d15d66a&pd_rd_wg=LIlJB&ref_=pd_gw_bmx', NULL, '2020-12-25 13:04:00', '2021-03-05 11:05:13', '2021-03-05 11:05:13'),
(8, 8, 1, '14.30', 'https://www.amazon.fr/Lecture-Enfants-Accessoires-Miniature-Artisanat/dp/B07WRRKM4M/ref=psdc_214938031_t5_B07FQHDGZW', '2024-06-21 13:07:00', NULL, '2021-03-05 11:07:28', '2021-03-05 11:07:28'),
(9, 9, 1, '11.95', 'https://www.auchan.fr/wowow-gilet-jaune-roadie-jaune-xl/p-m2946593', NULL, NULL, '2021-03-05 11:11:05', '2021-03-05 11:11:05'),
(10, 10, 5, '319.99', 'https://www.fnac.com/Casque-gaming-sans-fil-Astro-A50-Noir-Station-d-accueil-pour-Xbox/a15697926/w-4', NULL, NULL, '2021-03-05 11:12:10', '2021-03-05 11:12:10'),
(11, 11, 5, '10.00', 'https://www.fnac.com/a5806285/Daft-Punk-Random-access-memories-CD-album#int=:NonApplicable|NonApplicable|NonApplicable|5806285|NonApplicable|NonApplicable', NULL, '2019-11-14 13:13:00', '2021-03-05 11:13:59', '2021-03-05 11:13:59'),
(12, 12, 5, '899.00', 'https://www.fnac.com/Velo-assistance-electrique-Ion-Fat-26-250-W-Noir/a14790478/w-4#int=S:Tous%20les%20bons%20plans%20sports|Sport%20loisirs%20sant%C3%A9|447397|14790478|BL2|L1', NULL, NULL, '2021-03-05 11:15:48', '2021-03-05 11:15:48'),
(13, 13, 3, '89.00', 'https://www.cdiscount.com/maison/meubles-mobilier/homy-casa-bureau-d-angle-contemporain-arlette-blac/f-1176006-hom0745560590751.html#mpos=0|mp', NULL, '2020-07-17 13:17:00', '2021-03-05 11:17:50', '2021-03-05 11:17:50');

-- --------------------------------------------------------

--
-- Structure de la table `purchases`
--

DROP TABLE IF EXISTS `purchases`;
CREATE TABLE IF NOT EXISTS `purchases` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `product_id` int(10) UNSIGNED NOT NULL,
  `product_state_id` tinyint(3) UNSIGNED NOT NULL,
  `website_id` int(10) UNSIGNED NOT NULL,
  `cost` decimal(10,2) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchases_product_id_foreign` (`product_id`),
  KEY `purchases_product_state_id_foreign` (`product_state_id`),
  KEY `purchases_website_id_foreign` (`website_id`),
  KEY `purchases_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `purchases`
--

INSERT INTO `purchases` (`id`, `user_id`, `product_id`, `product_state_id`, `website_id`, `cost`, `date`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 1, '49.00', '2017-05-19', '2021-03-05 10:47:32', '2021-03-05 10:47:32'),
(2, 1, 4, 1, 5, '9.99', '2018-01-03', '2021-03-05 10:54:09', '2021-03-05 10:54:09'),
(3, 1, 5, 1, 1, '19.84', '2018-06-18', '2021-03-05 11:00:33', '2021-03-05 11:00:33'),
(4, 1, 6, 1, 1, '7.00', '2019-01-05', '2021-03-05 11:03:23', '2021-03-05 11:03:23'),
(5, 1, 9, 1, 1, '11.95', '2017-01-01', '2021-03-05 11:11:05', '2021-03-05 11:11:05'),
(6, 1, 12, 1, 5, '899.00', '2020-12-03', '2021-03-05 11:15:48', '2021-03-05 11:15:48'),
(7, 1, 13, 1, 3, '89.00', '2019-06-10', '2021-03-05 11:18:13', '2021-03-05 11:18:13'),
(8, 1, 9, 1, 8, '11.95', '2017-01-01', '2021-03-05 16:43:32', '2021-03-05 16:43:32');

-- --------------------------------------------------------

--
-- Structure de la table `sellings`
--

DROP TABLE IF EXISTS `sellings`;
CREATE TABLE IF NOT EXISTS `sellings` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `product_id` int(10) UNSIGNED NOT NULL,
  `product_state_id` tinyint(3) UNSIGNED NOT NULL,
  `purchase_id` int(10) UNSIGNED NOT NULL,
  `website_id` int(10) UNSIGNED NOT NULL,
  `sell_state_id` tinyint(3) UNSIGNED NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `confirmed_price` decimal(10,2) DEFAULT NULL,
  `shipping_fees` decimal(10,2) DEFAULT NULL,
  `shipping_fees_payed` decimal(10,2) DEFAULT NULL,
  `nb_views` int(11) DEFAULT NULL,
  `date_begin` date DEFAULT NULL,
  `date_sold` date DEFAULT NULL,
  `date_send` date DEFAULT NULL,
  `box` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sellings_product_id_foreign` (`product_id`),
  KEY `sellings_product_state_id_foreign` (`product_state_id`),
  KEY `sellings_purchase_id_foreign` (`purchase_id`),
  KEY `sellings_website_id_foreign` (`website_id`),
  KEY `sellings_sell_state_id_foreign` (`sell_state_id`),
  KEY `sellings_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sellings`
--

INSERT INTO `sellings` (`id`, `user_id`, `product_id`, `product_state_id`, `purchase_id`, `website_id`, `sell_state_id`, `price`, `confirmed_price`, `shipping_fees`, `shipping_fees_payed`, `nb_views`, `date_begin`, `date_sold`, `date_send`, `box`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 1, 2, 2, 5, '8.00', '8.00', '7.95', '7.95', 18, '2018-08-06', '2018-08-14', '2018-08-15', 1, '2021-03-05 14:06:28', '2021-03-05 14:06:28'),
(2, 1, 9, 1, 5, 2, 2, '10.00', NULL, '8.00', NULL, 155, '2020-03-20', NULL, NULL, 0, '2021-03-05 16:44:18', '2021-03-05 16:44:18');

-- --------------------------------------------------------

--
-- Structure de la table `sell_states`
--

DROP TABLE IF EXISTS `sell_states`;
CREATE TABLE IF NOT EXISTS `sell_states` (
  `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sell_states_label_unique` (`label`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sell_states`
--

INSERT INTO `sell_states` (`id`, `label`, `created_at`, `updated_at`) VALUES
(1, 'A mettre en vente', '2021-03-05 10:46:26', '2021-03-05 10:46:26'),
(2, 'En vente', '2021-03-05 10:46:26', '2021-03-05 10:46:26'),
(3, 'Vendu', '2021-03-05 10:46:26', '2021-03-05 10:46:26'),
(4, 'Envoyé', '2021-03-05 10:46:26', '2021-03-05 10:46:26'),
(5, 'Terminée', '2021-03-05 10:46:26', '2021-03-05 10:46:26');

-- --------------------------------------------------------

--
-- Structure de la table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('gnQt0tldpBez5lvvvq9gaEdAxtKbmx4rSfpdFxyL', 2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.82 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiQWpKM0V4d3EzQmwxMUZrbXQwMk9DT3lOMFE4ZGFTN2RpUW1GcXZ3TSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NzI6Imh0dHA6Ly9sb2NhbGhvc3QvMDAlMjAtJTIwQVBJL3Byb2R1Y3RzLW1hbmFnaW5nL2xhcmF2ZWw4L3B1YmxpYy9wcm9kdWN0cyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMCRpUWd1MGVZQWhlQmluUkNaMFNRSjZ1SHB2VTdHajUyVWw5UHptSEJGQnJzSDRNNWZHcUhIaSI7czozOiJ1cmwiO2E6MDp7fX0=', 1615848646),
('tyktEpWQQEd6yeWX4fQGKqUYBlxHeXn1Ku4TfY7S', 2, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.82 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiTEg3WktnaXlETHRSUFoyVHBNRWhzeElmQkZXd281QTRqUllCYTVzUiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NzI6Imh0dHA6Ly9sb2NhbGhvc3QvMDAlMjAtJTIwQVBJL3Byb2R1Y3RzLW1hbmFnaW5nL2xhcmF2ZWw4L3B1YmxpYy9wcm9kdWN0cyI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMCRpUWd1MGVZQWhlQmluUkNaMFNRSjZ1SHB2VTdHajUyVWw5UHptSEJGQnJzSDRNNWZHcUhIaSI7fQ==', 1615855353);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@admin.fr', '2021-03-05 10:38:02', '$2y$10$AGB01hDZNr7VNiy6jKaCn.jcCLCvXvFBgyCHghQ41X6wjAF/CzV0.', NULL, NULL, 'aClPC0rZY3VmtZ4QQ06yzRkvyIukb3yVWxEKwzIFXdIdKZPCGPcG674iIeYt', NULL, NULL, '2021-03-05 10:37:47', '2021-03-05 10:38:02'),
(2, 'Testeur', 'test@test.fr', '2021-03-15 19:59:58', '$2y$10$iQgu0eYAheBinRCZ0SQJ6uHpvU7Gj52Ul9PzmHBFBrsH4M5fGqHHi', NULL, NULL, '8fONTIHAwp4udIJ8FeRMw40pllA76KLD4PhyJ1qXBuTBQKBcPIlZuKOdov4v', NULL, NULL, '2021-03-15 19:59:45', '2021-03-15 19:59:58');

-- --------------------------------------------------------

--
-- Structure de la table `websites`
--

DROP TABLE IF EXISTS `websites`;
CREATE TABLE IF NOT EXISTS `websites` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `websites_label_unique` (`label`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `websites`
--

INSERT INTO `websites` (`id`, `label`, `url`, `created_at`, `updated_at`) VALUES
(1, 'Amazon', 'https://www.amazon.fr/', '2021-03-05 10:46:26', '2021-03-05 10:46:26'),
(2, 'eBay', 'https://www.ebay.fr/', '2021-03-05 10:46:26', '2021-03-05 10:46:26'),
(3, 'Cdiscount', 'https://www.cdiscount.com/', '2021-03-05 10:46:26', '2021-03-05 10:46:26'),
(4, 'Rakuten', 'https://fr.shopping.rakuten.com/', '2021-03-05 10:46:26', '2021-03-05 10:46:26'),
(5, 'Fnac', 'https://www.fnac.com/', '2021-03-05 10:46:26', '2021-03-05 10:46:26'),
(6, 'Groupon', 'https://www.groupon.fr/', '2021-03-05 10:46:26', '2021-03-05 10:46:26'),
(7, 'Cultura', 'https://www.cultura.com/', '2021-03-05 10:46:26', '2021-03-05 10:46:26'),
(8, 'Auchan', 'https://www.auchan.fr/', '2021-03-05 10:46:26', '2021-03-05 10:46:26');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_product_website_id_foreign` FOREIGN KEY (`product_website_id`) REFERENCES `product_websites` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `product_photos`
--
ALTER TABLE `product_photos`
  ADD CONSTRAINT `product_photos_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `product_users`
--
ALTER TABLE `product_users`
  ADD CONSTRAINT `product_users_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `product_websites`
--
ALTER TABLE `product_websites`
  ADD CONSTRAINT `product_websites_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_websites_website_id_foreign` FOREIGN KEY (`website_id`) REFERENCES `websites` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `purchases`
--
ALTER TABLE `purchases`
  ADD CONSTRAINT `purchases_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchases_product_state_id_foreign` FOREIGN KEY (`product_state_id`) REFERENCES `product_states` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchases_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `purchases_website_id_foreign` FOREIGN KEY (`website_id`) REFERENCES `websites` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `sellings`
--
ALTER TABLE `sellings`
  ADD CONSTRAINT `sellings_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sellings_product_state_id_foreign` FOREIGN KEY (`product_state_id`) REFERENCES `product_states` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sellings_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `purchases` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sellings_sell_state_id_foreign` FOREIGN KEY (`sell_state_id`) REFERENCES `sell_states` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sellings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sellings_website_id_foreign` FOREIGN KEY (`website_id`) REFERENCES `websites` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
