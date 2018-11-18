-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2018 at 02:19 PM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `doctor_ci`
--

-- --------------------------------------------------------

--
-- Table structure for table `dd_advertisements`
--

CREATE TABLE `dd_advertisements` (
  `ad_id` int(11) NOT NULL,
  `ad_type` varchar(10) NOT NULL,
  `ad_code` text NOT NULL,
  `ad_image` varchar(200) NOT NULL,
  `ad_link` varchar(250) NOT NULL,
  `ad_page` int(11) NOT NULL DEFAULT '1',
  `ad_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='1 home 2 single 3 both';

--
-- Dumping data for table `dd_advertisements`
--

INSERT INTO `dd_advertisements` (`ad_id`, `ad_type`, `ad_code`, `ad_image`, `ad_link`, `ad_page`, `ad_status`) VALUES
(1, 'script', '<iframe style=\"width:120px;height:240px;\" marginwidth=\"0\" marginheight=\"0\" scrolling=\"no\" frameborder=\"0\" src=\"//ws-na.amazon-adsystem.com/widgets/q?ServiceVersion=20070822&OneJS=1&Operation=GetAdHtml&MarketPlace=US&source=ss&ref=as_ss_li_til&ad_type=product_link&tracking_id=adsadsfs-20&marketplace=amazon&region=US&placement=B0793JSJRD&asins=B0793JSJRD&linkId=04e95cc3ba6892af784aa39e347dcd14&show_border=true&link_opens_in_new_window=true\"></iframe>', '', '', 3, 1),
(5, 'custom', '', 'upload/ad_image/3697eaf9e8.jpg', 'https://codecanyon.net/item/event-management-system-perfect-day/9241502', 3, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dd_appointment`
--

CREATE TABLE `dd_appointment` (
  `apo_id` int(11) NOT NULL,
  `apo_user_id` int(11) NOT NULL,
  `apo_clinic_id` int(11) NOT NULL,
  `apo_doctor_id` int(11) NOT NULL,
  `apo_timing` varchar(10) NOT NULL,
  `apo_date` date NOT NULL,
  `apo_status` tinyint(4) NOT NULL DEFAULT '1',
  `apo_note` varchar(50) NOT NULL DEFAULT '',
  `apo_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dd_categories`
--

CREATE TABLE `dd_categories` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(500) NOT NULL,
  `cat_image` varchar(500) NOT NULL,
  `cat_status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dd_categories`
--

INSERT INTO `dd_categories` (`cat_id`, `cat_name`, `cat_image`, `cat_status`) VALUES
(1, 'Doctor', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `dd_clinics`
--

CREATE TABLE `dd_clinics` (
  `cl_id` int(11) NOT NULL,
  `cl_name` varchar(250) NOT NULL,
  `cl_uid` int(11) NOT NULL,
  `cl_open_days` varchar(200) NOT NULL,
  `cl_time_interval` int(11) NOT NULL,
  `cl_motime` varchar(50) NOT NULL,
  `cl_mctime` varchar(50) NOT NULL,
  `cl_eotime` varchar(50) NOT NULL,
  `cl_ectime` varchar(50) NOT NULL,
  `cl_address` text NOT NULL,
  `cl_contact` varchar(50) NOT NULL,
  `cl_coordinates` varchar(100) NOT NULL,
  `cl_status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dd_favourite`
--

CREATE TABLE `dd_favourite` (
  `fav_id` int(11) NOT NULL,
  `fav_user_id` int(11) NOT NULL,
  `fav_doctor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dd_fields`
--

CREATE TABLE `dd_fields` (
  `field_id` int(11) NOT NULL,
  `label` varchar(250) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(10) NOT NULL,
  `options` varchar(500) NOT NULL,
  `doctor` tinyint(4) NOT NULL,
  `patients` tinyint(4) NOT NULL,
  `datetime` datetime NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dd_language`
--

CREATE TABLE `dd_language` (
  `language_id` int(11) NOT NULL,
  `language_key` text COLLATE utf8_unicode_ci NOT NULL,
  `language_type` text COLLATE utf8_unicode_ci NOT NULL,
  `language_english` text COLLATE utf8_unicode_ci NOT NULL,
  `language_french` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dd_language`
--

INSERT INTO `dd_language` (`language_id`, `language_key`, `language_type`, `language_english`, `language_french`) VALUES
(6, 'language_success', 'api', 'Language setting change successful.', ''),
(7, 'language_failure', 'api', 'Labguage doesn\'t change please try again', ''),
(8, 'category_success', 'api', 'Category is getting successfully', ''),
(9, 'category_failure', 'api', 'No category found', ''),
(10, 'subcategory_success', 'api', 'Subcategory is getting successfuly', ''),
(11, 'subcategory_failure', 'api', 'Subcategory not found', ''),
(13, 'header', 'api', 'Doctor Listing', 'Liste des médecins'),
(16, 'doctor_profile', 'api', 'Doctor Profile', 'doc_profile'),
(17, 'doctors_cat_success', 'api', 'here is doctor list.', 'aucun médecin trouvé'),
(18, 'doctors_cat_failure', 'api', 'No doctor in subcategory list.', 'Aucun médecin dans la liste de sous-catégorie.'),
(19, 'footerheading', 'footer', 'Get in touch with us !', 'Prenez contact avec nous!'),
(20, 'footersubheading', 'footer', 'Below are several ways for you to reach us. Pick Whichever is easiest for you.', 'Voici plusieurs façons de vous joindre à nous. Choisissez celui qui vous convient le mieux.'),
(21, 'footerbottom', 'footer', 'Copyright © 2018 Doctor Directory. All rights reserved', '\r\nCopyright © 2018 Annuaire des médecins. Tous les droits sont réservés'),
(22, 'doctor_profile_success', 'api', 'Successfully.', 'Avec succès.'),
(23, 'doctor_profile_failure', 'api', 'Doctor not found.', 'aucun médecin trouvé'),
(24, 'clinic_success', 'api', 'here is clinic list.', 'clinique trouvée'),
(25, 'clinic_failure', 'api', 'no clinic found', 'aucune clinique trouvée'),
(26, 'find_doctor', 'homepage', 'Find Your Doctors', 'Trouvez vos médecins'),
(27, 'search_doctor_placeholder', 'homepage', 'Search Doctor by Name, City, Specialties', 'Recherche médecin par nom, ville, spécialités'),
(28, 'find_category', 'homepage', 'Find from category', 'Trouver de la catégorie'),
(29, 'filter_by', 'homepage', 'Filter By', 'Filtrer par'),
(30, 'ascendatnt_by', 'homepage', 'Ascending (a-z)', 'Ascendant (a-z)'),
(31, 'descendatnt_by', 'homepage', 'Descendant (z-a)', 'Descendant (z-a)'),
(32, 'minprice_by', 'homepage', 'Min Price', '\r\nPrix ​​min'),
(33, 'maxprice_by', 'homepage', 'Max Price', 'Max Price'),
(35, 'doc_basic_info', 'doctordetail', 'Basic Information', 'Informations de base'),
(34, 'nodata_category', 'homepage', 'No data in this category', 'Pas de données dans cette catégorie'),
(36, 'fees', 'doctordetail', 'Fees', 'Honoraires'),
(37, 'special_in', 'doctordetail', 'Special In', 'Spécial en'),
(38, 'exp', 'doctordetail', 'Experience', 'Expérience'),
(39, 'years', 'doctordetail', 'Experience', 'Années'),
(40, 'qualification', 'doctordetail', 'Qualification', 'Qualification'),
(41, 'contact_number', 'doctordetail', 'Contact Number', 'Numéro de contact'),
(42, 'email_address', 'doctordetail', 'Email Address', 'Adresse e-mail'),
(43, 'doc_description', 'doctordetail', 'Description', 'La description'),
(44, 'reviews', 'doctordetail', 'Reviews', 'Avis'),
(45, 'write_review', 'doctordetail', 'Write Review', 'Ecrire une critique'),
(46, 'select_date', 'doctordetail', 'Select Date', 'Sélectionner une date'),
(47, 'select_clinic', 'doctordetail', 'Select Clinic', 'Sélectionner une clinique'),
(48, 'select_review_start', 'doctordetail', 'Select Review Start', 'Sélectionnez Revoir Démarrer'),
(49, 'book_appointment', 'doctordetail', 'Book Appointment', 'Rendez-vous au livre'),
(50, 'select_slot', 'doctordetail', 'Select a timing slot for your booking.', 'Sélectionnez un créneau de synchronisation pour votre réservation.'),
(51, 'morning', 'doctordetail', 'Morning', 'Matin'),
(52, 'afternoon', 'doctordetail', 'Afternoon', 'Après midi'),
(53, 'evening', 'doctordetail', 'Evening', 'Soir'),
(54, 'night', 'doctordetail', 'Night', 'Nuit'),
(55, 'book', 'doctordetail', 'Book', 'Livre'),
(56, 'doctors', 'menus', 'Doctors', 'Médecins'),
(57, 'appointments', 'menus', 'Appointments', 'Rendez-vous'),
(58, 'favourite', 'menus', 'Favourite', 'Préféré'),
(59, 'plan', 'menus', 'Pricing', 'Tarification'),
(60, 'hi', 'menus', 'Hi', 'salut'),
(61, 'profile_setting', 'menus', 'Profile Setting', 'Réglage du profil'),
(62, 'logout', 'menus', 'Logout', 'Connectez - Out'),
(63, 'login', 'menus', 'Login/Signup', 'S\'identifier/S\'inscrire'),
(64, 'login', 'authentication', 'Login', 'S\'identifier'),
(65, 'signup', 'authentication', 'Signup', 'S\'inscrire'),
(66, 'logusernametext', 'authentication', 'Full Name', 'Nom complet'),
(67, 'logpwdtext', 'authentication', 'Password', 'Mot de passe'),
(68, 'logforgotpwdtext', 'authentication', 'Forgot password ?', 'Mot de passe oublié ?'),
(69, 'submittext', 'authentication', 'Submit', 'Soumettre'),
(70, 'logconfirmpwdtext', 'authentication', 'Confirm Password', 'Confirmez le mot de passe'),
(71, 'googletext', 'authentication', 'Login with Google+', 'Se connecter avec Google+'),
(72, 'resetpassword', 'authentication', 'Reset Password', 'réinitialiser le mot de passe'),
(73, 'or', 'authentication', 'or', 'or'),
(74, 'logemailtext', 'authentication', 'Email', 'Email'),
(75, 'fgpwdinputtext', 'authentication', 'Recover Through Email.', 'Récupérer par courriel.'),
(76, 'account_information', 'profile', 'Account Information', 'Information sur le compte'),
(77, 'age', 'profile', 'Age', 'Âge'),
(78, 'years', 'profile', 'Years', 'Années'),
(79, 'become_doctor', 'profile', 'Create Doctor Profile', 'Créer un profil de médecin'),
(80, 'account_info', 'profile', 'Account Information', 'Information sur le compte'),
(81, 'change_pass', 'profile', 'Change Password', 'Changer le mot de passe'),
(82, 'bills_plans', 'profile', 'Bills and Plans', 'Factures et Plans'),
(83, 'setting', 'profile', 'Setting', 'Réglage'),
(84, 'full_name', 'profile', 'Full Name', 'Nom complet'),
(85, 'email', 'profile', 'Email', 'Email'),
(86, 'phone', 'profile', 'Phone', 'Téléphone'),
(87, 'gender', 'profile', 'Gender', 'Le genre'),
(88, 'male', 'profile', 'Male', 'Mâle'),
(89, 'female', 'profile', 'FeMale', 'Femelle'),
(90, 'address', 'profile', 'Address', 'Adresse'),
(91, 'select_category', 'profile', 'Select Category', 'Choisir une catégorie'),
(92, 'choose_one', 'profile', 'Choose One', 'Choisissez-en un'),
(93, 'select_subcategory', 'profile', 'Select Sub-Category', 'Sélectionnez une sous-catégorie'),
(94, 'exp', 'profile', 'Experience', 'Expérience'),
(95, 'qualification', 'profile', 'Qualification', 'Qualification'),
(96, 'fee', 'profile', 'Fee', 'Frais'),
(97, 'spec', 'profile', 'Specialization', 'Specializatio'),
(98, 'short_info', 'profile', 'Short Description', 'Short Description'),
(99, 'save_changes', 'profile', 'Save Changes', 'Sauvegarder les modifications'),
(100, 'select_location', 'profile', 'Select location (Move pointer)', 'Sélectionner l\'emplacement (déplacer le pointeu'),
(101, 'current_plan', 'profile', 'Current Plan', 'Plan actuel'),
(102, 'plan_name', 'profile', 'Plan Name', 'Nom du plan'),
(103, 'plan_duration', 'profile', 'Plan Duration', 'Durée du plan'),
(104, 'active_date', 'profile', 'Active Date', 'Date active'),
(105, 'my_payment', 'profile', 'My Payment', 'Mon paiement'),
(106, 'amount', 'profile', 'Amount', 'Montant'),
(107, 'payment_mode', 'profile', 'Payment Mode', 'Mode de paiement'),
(108, 'payment_date', 'profile', 'Payment Date', 'Date de paiement'),
(109, 'deactive_book', 'profile', 'Deactive Booking System for Patients', 'Système de réservation désactive pour les patients'),
(110, 'acceptt_terms', 'profile', 'I accept terms and coditions', 'J\'accepte les termes et les coditions'),
(111, 'continue', 'profile', 'Continue', 'Continuer'),
(112, 'empty_appointments', 'profile', 'You don\'t have an appointment', 'Vous n\'avez pas de rendez-vous'),
(113, 'clinic', 'profile', 'Clinic', 'Clinique'),
(114, 'patients', 'profile', 'Patients', 'Les patients'),
(115, 'booking_date', 'profile', 'Booking date', 'Date de réservation'),
(116, 'appointment_time', 'profile', 'Appointment time', 'Temps de rendez-vous'),
(117, 'action', 'profile', 'Action', 'action'),
(118, 'note', 'profile', 'Note', 'Remarque'),
(119, 'cancelebyuser', 'profile', 'Canceled by user', 'Annulé par l\'utilisateur'),
(120, 'cancelebydoctor', 'profile', 'Canceled by doctor', 'Annulé par le médecin'),
(121, 'rebookebydoctor', 'profile', 'Rebooked by doctor', 'Rebooked par le docteur'),
(122, 'rebookebyuser', 'profile', 'Rebooked by user', 'Rebooked par l\'utilisateur'),
(123, 'deleted', 'profile', 'Not Available', 'Indisponible'),
(124, 'upcoming_apo', 'profile', 'Upcoming appointments', 'Prochains rendez-vous'),
(125, 'past_apo', 'profile', 'Complete appointments', 'Rendez-vous complets'),
(126, 'name', 'profile', 'Name', 'prénom'),
(127, 'status', 'profile', 'Status', 'Statut'),
(128, 'addnewclinic', 'profile', 'Add New Clinic', 'Ajouter une nouvelle clinique'),
(129, 'empty_favroite', 'profile', 'No doctor found in your favourite list...', 'Aucun médecin trouvé dans votre liste de favoris ...'),
(130, 'tnctext', 'profile', 'After becoming a doctor.\r\nPlease logout from all other devices and login again.\r\nYour user profile will replace with doctor profile. your previous appointment as a user will not show. ', 'Après être devenu un médecin.\r\nVeuillez vous déconnecter de tous les autres appareils et reconnectez-vous.\r\nVotre profil d\'utilisateur remplacera avec le profil de docteur. votre rendez-vous précédent en tant qu\'utilisateur ne s\'affichera pas.'),
(131, 'accept_termsmsg', 'profile', 'Accept Terms', 'Accepter les termes'),
(132, 'reserved', '', '', ''),
(133, 'my_clinics', 'menus', 'My Clinics', 'Mes cliniques'),
(134, 'chats', 'menus', 'Chats', 'Bavarder'),
(135, 'chats', 'commontext', 'Chats', 'Bavarder'),
(136, 'book', 'commontext', 'Book', 'Livre'),
(137, 'views', 'commontext', 'Views', 'Vues'),
(138, 'addtofav', 'commontext', 'Add to favourite', 'Ajouter aux favoris'),
(139, 'removefav', 'commontext', 'Remove from favourite', 'Supprimer du favori'),
(140, 'bynow', 'commontext', 'Buy Now', 'Acheter maintenant'),
(141, 'uncategorized', 'commontext', 'Uncategorized', 'Non classé'),
(142, 'book_appo', 'commontext', 'Book Appointment', 'Rendez-vous au livre'),
(143, 'nothing_found', 'commontext', 'Nothing Found', 'rien n\'a été trouvé'),
(144, 'choose_one', 'commontext', 'Choose one', 'Choisissez-en un'),
(145, 'edit', 'commontext', 'Edit', 'modifier'),
(146, 'delete', 'commontext', 'Delete', 'modifier'),
(147, 'somethingwentwrong', 'commontext', 'Something went wrong, please try again', 'Une erreur s\'est produite. Veuillez réessayer'),
(148, 'paySuccessHeading', 'commontext', 'Success', 'Succès'),
(149, 'paySuccessh3', 'commontext', 'Your payment is successful.', 'Votre paiement est réussi.'),
(150, 'paySuccesstext', 'commontext', 'Your payment is successfully done.\r\nPlease check your email for further detail. ', 'Votre paiement a été effectué avec succès.\r\nS\'il vous plaît vérifier votre email pour plus de détails.'),
(151, 'payCanceledHeading', 'commontext', 'Transaction Cancelled', 'Transaction annulée'),
(152, 'payCancelh3', 'commontext', 'Oops , you canceled payment.', 'Oups, vous avez annulé le paiement.'),
(153, 'payCanceltext', 'commontext', 'You have canceled the payment, but don\'\'t worry the products are still in your cart. You can purchase them any time you want.', 'Vous avez annulé le paiement, mais ne vous inquiétez pas les produits sont toujours dans votre panier. Vous pouvez les acheter à tout moment.'),
(154, 'reserverd', 'commontext', '', ''),
(155, 'reserverd', 'commontext', '', ''),
(156, 'reserverd', 'commontext', '', ''),
(157, 'reserverd', 'commontext', '', ''),
(158, 'reserverd', 'commontext', '', ''),
(159, 'email', 'message', 'Email should be correct.', 'Le courrier électronique doit être correct.'),
(160, 'empty', 'message', 'All fields are Required', 'Tous les champs sont requis'),
(161, 'password', 'message', 'Password should contain minimum 8 characters.', 'Mot de passe doit contenir un minimum de 8 caractÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¨res.'),
(162, 'repassword', 'message', 'Both passwords should be same.', 'Les deux mots de passe doivent être identiques.'),
(163, 'loginsuc', 'message', 'Successfully logged in.', 'Connexion réussie.'),
(164, 'forgotpassword', 'message', 'Please, check your email for the forgot password link.', 'S\'il vous plaît, vérifiez votre email pour le lien mot de passe oublié.'),
(165, 'activateerror', 'message', 'Please, activate your account.', 'Veuillez activer votre compte.'),
(166, 'blockederror', 'message', 'Contact support, your account is blocked.', 'Contactez le support, votre compte est bloqué.'),
(167, 'loginerror', 'message', 'Login details are incorrect.', 'Les informations de connexion sont incorrectes .'),
(168, 'forgotpwderror', 'message', 'This detail is not with us.', 'Ce détail n\'est pas avec nous.'),
(169, 'resetpwdsuc', 'message', 'Password changed successfully.', 'Le mot de passe a été changé avec succès.'),
(170, 'registersuc', 'message', 'Please, check your email for activation link.', 'S\'il vous plaît, vérifiez votre e-mail pour le lien d\'activation.'),
(171, 'username', 'message', 'Username should not contain any special characters and should be not more that 10 characters.', 'Le nom d\'utilisateur ne doit pas contenir de caractères spéciaux et ne doit pas dépasser 10 caractères.'),
(172, 'newslettererr', 'message', 'Oops : Something went wrong. Please, try again.', 'Oups: Quelque chose s\'est mal passé. Veuillez réessayer.'),
(173, 'emailexists', 'message', 'Email is already taken. Please, try again.', 'Cet email est déjà pris. Veuillez réessayer.'),
(174, 'closed_clinic', 'message', 'Clinic is closed on your selected date', 'La clinique est fermée à la date sélectionnée'),
(175, 'add_fav', 'message', 'Successfully added to your favroite list', 'Ajouté avec succès à votre liste de favoris'),
(176, 'remove_fav', 'message', 'Succesfully remove from favroite', 'Retirer avec succès de favroite'),
(177, 'rat_add', 'message', 'Rating  add succesfully', 'Note ajouter avec succès\r\n'),
(178, 'rat_update', 'message', 'Rating  update succesfully', 'Mise à jour de la note avec succès'),
(179, 'add_success', 'message', 'Add successfully', 'Ajouter avec succès'),
(180, 'update_success', 'message', 'Update successfully', 'Mettre à jour'),
(181, 'delete_success', 'message', 'Delete Successfully', 'Supprimer avec succès'),
(182, 'emptysubcategory_doc', 'message', 'emptysubcategory_msg', 'Sous-catégorie vide s\'il vous plaît après un certain temps'),
(183, 'becomedoct_success', 'message', 'You are successfully become our doctor now update you profile', 'Vous êtes devenu avec succès notre médecin maintenant mettre à jour votre profil'),
(184, 'remove_img', 'message', 'Do you want to remove your profile pic', 'Voulez-vous supprimer votre photo de profil'),
(185, 'cancel_appointment', 'message', 'Do you want to cancel this appointment', 'Voulez-vous annuler ce rendez-vous'),
(186, 'rebook_appointment', 'message', 'Do you want to rebook this appointment', 'Voulez-vous modifier ce rendez-vous?'),
(187, 'not_docor', 'message', 'You are not a doctor', 'Tu n\'es pas un docteur'),
(188, 'notonchat', 'message', 'Currently this doctor is not registered with chat application,Please try after sometime', 'Actuellement ce docteur n\'est pas enregistré avec l\'application de causerie, essaye svp après quelque temps'),
(189, 'selectclinic', 'message', 'Please, select a clinic', 'S\'il vous plaît, sélectionnez une clinique'),
(190, 'clinic_name', 'clinic', 'Clinic Name', 'Nom de la clinique'),
(191, 'contact_number', 'clinic', 'Contact Number', 'Numéro de contact'),
(192, 'clinic_interval', 'clinic', 'Appointment Time Interval(Minutes)', 'Intervalle de temps de rendez-vous (minutes)'),
(193, 'mo_time', 'clinic', 'Morning time (Open)', 'Heure du matin (Ouvert)'),
(194, 'clinic_address', 'clinic', 'Clinic Address', 'Adresse de la clinique'),
(195, 'mc_time', 'clinic', 'Morning time (Close)', 'Heure du matin (Fermer)'),
(196, 'eo_time', 'clinic', 'Evening time (Open)', 'Heure du soir (Ouvert)'),
(197, 'ec_time', 'clinic', 'Evening time (Close)', 'Heure du soir (Fermer)'),
(198, 'open_days', 'clinic', 'Open Days', 'Jours ouverts'),
(199, 'select_location', 'clinic', 'Select location (Move pointer)', 'Sélectionner l\'emplacement (déplacer le pointeur)'),
(200, 'add_clinic_btn', 'clinic', 'Add', 'ajouter'),
(201, 'update_clinic_btn', 'clinic', 'Update', 'Mettre à jour'),
(202, 'add_new_clinic_heading', 'clinic', 'Add New Clinic', 'Ajouter une nouvelle clinique'),
(203, 'update_clinic_heading', 'clinic', 'Update Clinic', 'Mise à jour de la clinique'),
(204, 'map_search', 'clinic', 'Search', 'chercher'),
(205, 'review_comment', 'doctordetail', 'Enter Your Message here', '\r\nEntrez votre message ici'),
(206, 'appointment_list', 'api', 'Here appointment list', 'Ici liste de rendez-vous'),
(207, 'bookedbyuser', 'profile', 'Booked by user', 'Réservé par l\'utilisateur'),
(208, 'appointment_sucess', 'api', 'Appointment book successfully', 'Livre de rendez-vous avec succès'),
(209, 'appointment_fail', 'api', 'Please try other time slot', 'S\'il vous plaît essayez autre tranche de temps'),
(210, 'sidebar_home', 'api', 'Home', 'Accueil'),
(211, 'sidebar_find_doctors', 'api', 'Find Doctors', 'Trouver des médecins\r\n'),
(212, 'sidebar_my_fav_list', 'api', 'My Favourite List', 'Ma liste préférée\r\n'),
(213, 'sidebar_my_appointments', 'api', 'My Appointments', 'Mes rendez-vous\r\n'),
(214, 'sidebar_settings', 'api', 'Settings', 'Paramètres'),
(215, 'new_password', 'api', 'New Password', 'nouveau mot de passe\r\n'),
(216, 'ok', 'api', 'OK', 'D\'accord'),
(217, 'info_msg', 'api', 'Information Message', 'Message d\'information'),
(218, 'doctor_directory', 'api', 'Doctor Directory', 'Annuaire des médecins\r\n'),
(219, 'logout_warn', 'api', 'Do you want to log out ?', 'Voulez-vous vous déconnecter?'),
(220, 'cancel', 'api', 'Cancel', 'Annuler'),
(221, 'upcomming', 'api', 'Upcomming', 'en hausse'),
(222, 'completed', 'api', 'Completed', 'terminé'),
(223, 'call_now', 'api', 'Call Now', 'Appelle maintenant'),
(224, 'cancel_apo_text', 'api', 'Cancel Appointment', 'Annuler rendez-vous'),
(225, 'view_clinic', 'api', 'View Clinic', 'Voir la clinique'),
(226, 'doc_personal_info', 'api', 'Personal Information', 'Informations personnelles'),
(227, 'call_now', 'api', 'Call Now', 'Appelle maintenant'),
(228, 'delet_dialog', 'api', 'If you delete your clinic, all the appointments will also get deleted.', 'Si vous supprimez votre clinique, tous les rendez-vous seront également supprimés.'),
(229, 'edit_clinic', 'api', 'Edit Clinic', 'Modifier la clinique'),
(230, 'add_clinic', 'api', 'Add Clinic', 'Ajouter une clinique'),
(231, 'payment_date', 'api', 'Payment Date', 'Date de paiement'),
(232, 'payment_mode', 'api', 'Payment Mode', 'Mode de paiement'),
(233, '', '', '', ''),
(234, 'booking_status', 'api', 'Booking Status', 'Statut de réservation'),
(235, 'city', 'api', 'City', 'Ville'),
(236, 'noclinicforbook', 'doctordetail', 'Currently there is no clinic for this doctor', 'Actuellement il n\'y a pas de clinique pour ce docteur'),
(237, 'bookingclosedbydoctor', 'message', 'Currently booking is closed by doctor', 'Actuellement, la réservation est fermée par un médecin'),
(238, 'accountverifysuccess', 'authentication', 'Your account is activated', 'Votre compte est activé'),
(239, 'pwdchngsuc_text', 'message', 'Password changes successfully', 'Mot de passe modifié avec succès'),
(240, 'validmobile', 'message', 'Please enter valid mobile', 'Veuillez entrer un portable valide'),
(241, 'validnumber', 'message', 'Please enter valid number', 'Veuillez entrer un nombre valide'),
(242, 'min_rating', 'api', 'Please give minimum rating', 'S\'il vous plaît donner une note minimale'),
(243, 'add_comment', 'api', 'Please add a comment', 'S\'il vous plaît ajouter un commentaire'),
(244, 'add_fav_doc', 'api', 'Do you want to add doctor to favourite?', 'Voulez-vous ajouter un médecin à vos favoris?'),
(245, 'rem_fav_doc', 'api', 'Do you want to remove doctor from favourite?', 'Voulez-vous supprimer le docteur du favori?'),
(246, 'no_chat', 'api', 'Doctor is unavailable for chat', 'Le docteur n\'est pas disponible pour le chat'),
(247, 'conf_book', 'api', 'Do you want to book appointment for this time?', 'Voulez-vous réserver un rendez-vous pour cette fois?'),
(248, 'no_doc_found', 'api', 'No Doctors Found', 'Aucun médecin trouvé'),
(249, 'fill_data', 'api', 'Please fill in data, some fields are empty', 'S\'il vous plaît remplir les données, certains champs sont vides'),
(250, 'login_warn', 'api', 'Please login to use all the features of the app', 'Veuillez vous connecter pour utiliser toutes les fonctionnalités de l\'application'),
(251, 'no_name', 'api', 'Please Enter Name', 'Veuillez entrer le nom'),
(252, 'no_gender', 'api', 'Please Select Gender', 'Veuillez sélectionner le sexe'),
(253, 'no_mobile', 'api', 'Please Enter Contact Number', 'Veuillez entrer le numéro de contact'),
(254, 'no_city', 'api', 'Please Enter City', 'S\'il vous plaît entrer la ville'),
(255, 'no_clinic', 'api', 'Please Enter Clinic Name', 'Veuillez entrer le nom de la clinique'),
(256, 'no_clinic_address', 'api', 'Please Enter Clinic Address', 'Veuillez entrer l\'adresse de la clinique'),
(257, 'no_interval', 'api', 'Please Select Time Interval', 'Veuillez sélectionner un intervalle de temps'),
(258, 'no_mo', 'api', 'Please Enter Morning Opening Time', 'Veuillez entrer l\'heure d\'ouverture du matin'),
(259, 'no_mc', 'api', 'Please Enter Morning Closing Time', 'Veuillez entrer l\'heure de fermeture du matin'),
(260, 'no_mc', 'api', 'Please Enter Evening Opening Time', 'Veuillez entrer la date d\'ouverture du soir'),
(261, 'no_mc', 'api', 'Please Enter Morning Closing Time', 'Veuillez entrer l\'heure de fermeture du matin'),
(262, 'no_eo', 'api', 'Please Enter Evening Opening Time', 'Veuillez entrer la date d\'ouverture du soir'),
(263, 'no_ec', 'api', 'Please Enter Evening Closing Time', 'Veuillez entrer le moment de la fermeture du soir'),
(264, 'no_open', 'api', 'Please Select Open Days', 'S\'il vous plaît sélectionner Open Days'),
(265, 'actvtacnt_text', 'message', 'Please active your account', 'Veuillez activer votre compte'),
(266, 'noclinic', 'profile', 'You don\'t have any clinic', 'Vous n\'avez pas de clinique'),
(267, 'invalidresetkey', 'message', 'Key expired,Please check email again.', 'La clé a expiré. Veuillez vérifier à nouveau le courrier électronique.');

-- --------------------------------------------------------

--
-- Table structure for table `dd_paymentdetails`
--

CREATE TABLE `dd_paymentdetails` (
  `payment_id` int(11) NOT NULL,
  `payment_uid` int(11) NOT NULL,
  `payment_pid` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `payment_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `payment_mode` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `payment_amount` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dd_plans`
--

CREATE TABLE `dd_plans` (
  `plan_id` int(11) NOT NULL,
  `plan_name` varchar(250) NOT NULL,
  `plan_amount` varchar(100) NOT NULL,
  `plan_description` text NOT NULL,
  `plan_status` int(11) NOT NULL DEFAULT '1',
  `plan_duration` varchar(50) NOT NULL,
  `plan_duration_txt` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dd_plans`
--

INSERT INTO `dd_plans` (`plan_id`, `plan_name`, `plan_amount`, `plan_description`, `plan_status`, `plan_duration`, `plan_duration_txt`) VALUES
(1, 'Basic', '19', 'Unlimited Clinics\r\nUnlimited booking\r\nAppointment   ', 1, '7', '1 Weeks'),
(2, 'Popular', '49', 'Unlimited Clinics\r\nUnlimited booking \r\nAppointment   ', 1, '30', '1 Months'),
(3, 'Premium', '99', 'Unlimited Clinics\r\nUnlimited booking \r\nAppointment   ', 1, '365', '1 Years');

-- --------------------------------------------------------

--
-- Table structure for table `dd_rating`
--

CREATE TABLE `dd_rating` (
  `rat_id` int(11) NOT NULL,
  `rat_user_id` int(11) NOT NULL,
  `rat_doctor_id` int(11) NOT NULL,
  `rat_rating` varchar(20) NOT NULL,
  `rat_comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dd_record`
--

CREATE TABLE `dd_record` (
  `id` int(11) NOT NULL,
  `data` text NOT NULL,
  `type` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dd_settings`
--

CREATE TABLE `dd_settings` (
  `uniq_id` int(11) NOT NULL,
  `key_text` varchar(250) NOT NULL,
  `value_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dd_settings`
--

INSERT INTO `dd_settings` (`uniq_id`, `key_text`, `value_text`) VALUES
(1, 'logo_img', 'upload/webimages/logo.svg'),
(2, 'favicon_img', 'upload/webimages/favicon.png'),
(3, 'login_img', 'upload/webimages/login.jpg'),
(4, 'portal_curreny', 'USD'),
(5, 'portalcurreny_symbol', '$'),
(6, 'portal_revenuemodel', 'free'),
(7, 'languageoption_text', 'english,french'),
(8, 'weblanguage_text', 'english'),
(9, 'languagesection_text', 'api,homepage,doctordetail,commontext,menus,authentication,profile,footer,clinic'),
(10, 'languageswitch_checkbox', '1'),
(11, 'sitetitle_text', 'Doctor Listings with mobile app'),
(12, 'sitename_text', 'Doctor Directory - Kamleshyadav\'s Product'),
(13, 'seodescr_text', 'Doctor Listing is a  listing portal with mobile app'),
(14, 'siteauthor_text', 'Kamleshyadav'),
(15, 'googlelink_url', 'https://google.com'),
(16, 'twitterlink_url ', 'https://twitter.com'),
(17, 'fblink_url', 'https://facebook.com'),
(18, 'paypal_status', '1'),
(19, 'paypal_email', 'syinfotech333-facilitator1@gmail.com'),
(20, 'msg91_status', '0'),
(21, 'msg91_key', ''),
(22, 'copyright_text', 'Copyright © 2018 Doctor Listing. All rights reserved'),
(23, 'facebook_status', '0'),
(24, 'facebook_appid', '615526785293430'),
(25, 'facebook_appsecret', '0b055fc8c39fa30ca3aa37fc87bc6a42'),
(26, 'google_status', '1'),
(27, 'google_clientid', '730910893416-5ouj4fpne5al0o8po49oo9rrf8gsa0g4.apps.googleusercontent.com'),
(28, 'google_clientsecret', 'KyLFXrt07EF2P_1YbLUQ5Sw-'),
(29, 'map_api', ''),
(30, 'doctor_tnctext', 'Terms and Conditions to be a Doctor\r\n\r\n1. You will become the doctor of our Doctor Directory.\r\n2. You should be a legal doctor.\r\n3. Your user profile will replace with doctor profile. your previous appointment will not show .\r\n4. You have to be on time that you enter on you clinic'),
(31, 'metatags_text', 'Doctor Listing with mobile app'),
(32, 'registrationemail_text', 'Hi [username],\nPlease, click on the link below to activate your account. [break]\n[linktext] [break]\nThanks,[break]\nTeam Doctor Listing.'),
(33, 'forgotpwdemail_text', 'Hi [username],[break]\nPlease, click on the link below to reset your password. [break]\n[linktext] [break]\nThanks,[break]\nTeam Doctor Listing.'),
(34, 'registrationemail_linktext', 'Click here'),
(35, 'forgotpwdemail_linktext', 'Reset Password'),
(36, 'addnewuseremail_text', 'Hi [username],[break][break]\nCongratulation. We have your account. [break]\nHere are your login details [break]\nUsername : [username] [break]\nPassword : [password] [break]\nWebsite link : [website_link] [break]\nThanks,[break][break]\nTeam Doctor Listing.'),
(37, 'email_fromname', 'help'),
(38, 'email_fromemail', 'admin@doctorlisting.com'),
(39, 'bookappointment_text', 'Hi [username],[break]\nYour appointment  guaranteed by Doctor Directory. [break]\nIf in case you are unable to meet your doctor. Please cancel your appointment before 3 hours [break]\nDate : [apo_date] [break]\nTiming : [apo_timing] [break]\nWebsite link : [website_link] [break]\nThanks,[break][break]\nTeam Doctor Listing'),
(40, 'admob_appid', 'ca-app-pub-8209024401568123/1586854899'),
(41, 'email_contactemail', 'admin@doctor.com'),
(42, 'cancelbyuser_text', 'Hi [doctorname],[break]\n[username] has  canceled a appointment.[break]\nDate : [apo_date] [break]\nTiming : [apo_timing] [break]\nWebsite link : [website_link] [break]\nThanks,[break][break]\nTeam Doctor Listing'),
(43, 'cancelbydoctor_text', 'Hi [username],[break]\nDr [doctorname] has  canceled your appointment.[break]\nDate : [apo_date] [break]\nTiming : [apo_timing] [break]\nWebsite link : [website_link] [break]\nThanks,[break][break]\nTeam Doctor Listing'),
(44, '', ''),
(45, 'msg91_sender', 'DOCDIR'),
(46, 'chat_status', '0'),
(47, 'chat_appid', ''),
(48, 'chat_authkey', ''),
(49, 'chat_authsecret', ''),
(50, 'registrationemail_subject', 'Registaration Email'),
(51, 'forgotpwdemail_subject', 'Forget Password'),
(52, 'addnewuseremail_subject', 'Account Detail'),
(53, 'bookingemail_subject', 'Booking Detail'),
(54, 'transactionemail_subject', 'Details of purchase on Doctor Directory'),
(55, 'chat_accountkey', ''),
(56, 'firebase_status', '0'),
(57, 'firebase_key', ''),
(58, 'site_timezone', 'Asia/Kolkata'),
(59, 'google_anaylitics', '<script></script>'),
(60, 'bookappointmentdoc_text', 'Hi [doctorname],[break]\r\n[username] has  booked a appointment.[break]\r\nDate : [apo_date] [break]\r\nTiming : [apo_timing] [break]\r\nWebsite link : [website_link] [break]\r\nThanks,[break][break]\r\nTeam Doctor Listing');

-- --------------------------------------------------------

--
-- Table structure for table `dd_speciality`
--

CREATE TABLE `dd_speciality` (
  `spe_id` int(11) NOT NULL,
  `spe_name` varchar(250) NOT NULL,
  `spe_status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dd_speciality`
--

INSERT INTO `dd_speciality` (`spe_id`, `spe_name`, `spe_status`) VALUES
(1, 'Allergist or Immunologist', 1),
(2, 'Anesthesiologist', 1),
(3, 'Cardiologist', 1),
(4, 'Dermatologist', 1),
(5, 'Gastroenterologist', 1),
(6, 'Hematologist/Oncologist', 1),
(7, 'Internal Medicine Physician', 1),
(8, 'Nephrologist', 1),
(9, 'Neurologist', 1),
(10, 'Neurosurgeon', 1),
(11, 'Obstetrician', 1),
(12, 'Gynecologist', 1),
(13, 'Nurse-Midwifery', 1),
(14, 'Occupational Medicine Physician', 1),
(15, 'Ophthalmologist', 1),
(16, 'Oral and Maxillofacial Surgeon', 1),
(17, 'Orthopaedic Surgeon', 1),
(18, 'Otolaryngologist', 1),
(19, 'Pathologist', 1),
(20, 'Pediatrician', 1),
(21, 'Plastic Surgeon', 1),
(22, 'Podiatrist', 1),
(23, 'Psychiatrist', 1),
(24, 'Pulmonary Medicine Physician', 1),
(25, 'Radiation Onconlogist', 1),
(26, 'Diagnostic Radiologist', 1),
(27, 'Rheumatologist', 1),
(28, 'Urologist', 1),
(29, 'Lung', 1);

-- --------------------------------------------------------

--
-- Table structure for table `dd_subcategories`
--

CREATE TABLE `dd_subcategories` (
  `sub_id` int(11) NOT NULL,
  `sub_name` varchar(250) NOT NULL,
  `sub_urlname` varchar(250) NOT NULL,
  `sub_parent` int(11) NOT NULL,
  `sub_image` varchar(250) NOT NULL,
  `sub_status` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dd_subcategories`
--

INSERT INTO `dd_subcategories` (`sub_id`, `sub_name`, `sub_urlname`, `sub_parent`, `sub_image`, `sub_status`) VALUES
(1, 'Surgeon', '', 1, 'upload/sub_category/39d4449357.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `dd_users`
--

CREATE TABLE `dd_users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(200) NOT NULL,
  `user_pass` varchar(500) NOT NULL,
  `user_level` tinyint(4) NOT NULL COMMENT '1-admin, 2-patients, 3-doctor',
  `user_status` tinyint(4) NOT NULL,
  `user_key` varchar(255) NOT NULL,
  `user_mobile` varchar(255) NOT NULL,
  `user_pic` varchar(100) NOT NULL,
  `user_device_token` text NOT NULL,
  `user_device_type` varchar(15) NOT NULL,
  `user_device_id` varchar(255) NOT NULL,
  `user_gender` varchar(20) NOT NULL DEFAULT 'male',
  `user_city` varchar(50) NOT NULL,
  `user_dob` date NOT NULL,
  `user_registerdate` varchar(20) NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_plans` int(11) NOT NULL,
  `user_plansdate` datetime NOT NULL,
  `user_fees` bigint(20) NOT NULL,
  `user_offset` varchar(10) NOT NULL,
  `user_deleted` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dd_users`
--

INSERT INTO `dd_users` (`user_id`, `user_name`, `user_email`, `user_pass`, `user_level`, `user_status`, `user_key`, `user_mobile`, `user_pic`, `user_device_token`, `user_device_type`, `user_device_id`, `user_gender`, `user_city`, `user_dob`, `user_registerdate`, `user_plans`, `user_plansdate`, `user_fees`, `user_offset`, `user_deleted`) VALUES
(1, 'Admin', 'admin@doctorlistings.com', 'e6e061838856bf47e1de730719fb2609', 1, 1, '', '', '', '', '', '', '', '', '0000-00-00', '2018-02-01 11:42:52', 0, '0000-00-00 00:00:00', 0, '-330', 0);

-- --------------------------------------------------------

--
-- Table structure for table `dd_user_meta`
--

CREATE TABLE `dd_user_meta` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `key` varchar(50) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dd_advertisements`
--
ALTER TABLE `dd_advertisements`
  ADD PRIMARY KEY (`ad_id`);

--
-- Indexes for table `dd_appointment`
--
ALTER TABLE `dd_appointment`
  ADD PRIMARY KEY (`apo_id`);

--
-- Indexes for table `dd_categories`
--
ALTER TABLE `dd_categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `dd_clinics`
--
ALTER TABLE `dd_clinics`
  ADD PRIMARY KEY (`cl_id`);

--
-- Indexes for table `dd_favourite`
--
ALTER TABLE `dd_favourite`
  ADD PRIMARY KEY (`fav_id`);

--
-- Indexes for table `dd_fields`
--
ALTER TABLE `dd_fields`
  ADD PRIMARY KEY (`field_id`);

--
-- Indexes for table `dd_language`
--
ALTER TABLE `dd_language`
  ADD PRIMARY KEY (`language_id`);

--
-- Indexes for table `dd_paymentdetails`
--
ALTER TABLE `dd_paymentdetails`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `dd_plans`
--
ALTER TABLE `dd_plans`
  ADD PRIMARY KEY (`plan_id`);

--
-- Indexes for table `dd_rating`
--
ALTER TABLE `dd_rating`
  ADD PRIMARY KEY (`rat_id`),
  ADD KEY `user_id_constraint` (`rat_user_id`),
  ADD KEY `doctor_id_constraint` (`rat_doctor_id`);

--
-- Indexes for table `dd_record`
--
ALTER TABLE `dd_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dd_settings`
--
ALTER TABLE `dd_settings`
  ADD PRIMARY KEY (`uniq_id`);

--
-- Indexes for table `dd_speciality`
--
ALTER TABLE `dd_speciality`
  ADD PRIMARY KEY (`spe_id`);

--
-- Indexes for table `dd_subcategories`
--
ALTER TABLE `dd_subcategories`
  ADD PRIMARY KEY (`sub_id`);

--
-- Indexes for table `dd_users`
--
ALTER TABLE `dd_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `dd_user_meta`
--
ALTER TABLE `dd_user_meta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dd_advertisements`
--
ALTER TABLE `dd_advertisements`
  MODIFY `ad_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `dd_appointment`
--
ALTER TABLE `dd_appointment`
  MODIFY `apo_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dd_categories`
--
ALTER TABLE `dd_categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dd_clinics`
--
ALTER TABLE `dd_clinics`
  MODIFY `cl_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dd_favourite`
--
ALTER TABLE `dd_favourite`
  MODIFY `fav_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dd_fields`
--
ALTER TABLE `dd_fields`
  MODIFY `field_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dd_language`
--
ALTER TABLE `dd_language`
  MODIFY `language_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=268;

--
-- AUTO_INCREMENT for table `dd_paymentdetails`
--
ALTER TABLE `dd_paymentdetails`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dd_plans`
--
ALTER TABLE `dd_plans`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `dd_rating`
--
ALTER TABLE `dd_rating`
  MODIFY `rat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dd_record`
--
ALTER TABLE `dd_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dd_settings`
--
ALTER TABLE `dd_settings`
  MODIFY `uniq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `dd_speciality`
--
ALTER TABLE `dd_speciality`
  MODIFY `spe_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `dd_subcategories`
--
ALTER TABLE `dd_subcategories`
  MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dd_users`
--
ALTER TABLE `dd_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dd_user_meta`
--
ALTER TABLE `dd_user_meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
