<?php
/**
 * General locale settings - French
 * @package Raxan
 */

// site & language info
$locale['php.locale']           = 'fr';  // see setlocale()
$locale['lang.dir']             = 'ltr';
$locale['site.title']           = 'Mon Site Web';

// date & time (strtime format)
$locale['date.short']           = 'd/m/Y';
$locale['date.long']            = 'l d F Y';
$locale['date.time']            = 'h:n AM';

// numbers & currency
$locale['decimal.separator']    = ',';
$locale['thousand.separator']   = ' ';
$locale['currency.symbol']      = '€';
$locale['currency.location']    = 'rt';     // lt - left, rt - right
$locale['money.format']         = '';       // overrides above currency settings. See money_format()

$locale['days.short']           = array('Dimanche','Lundi','Mardi','Mercredi','Jeu','Vendredi','Samedi');
$locale['days.full']            = array('Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi');
$locale['months.short']         = array('Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre');
$locale['months.full']          = array('Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre');

// error messages
$locale['unauth_access']        = 'Accès non autorisé';
$locale['file_notfound']        = 'Fichier non trouvé';

// client-side error message
$locale['pdi-ajax-err-msg']     = "Erreur lors de la connexion au serveur. S'il vous plaît essayer de nouveau ou le rapport de la question à l'administrateur. Voir la console d'erreur pour plus d'informations.";

// commonly used words
$locale['error']                = 'Erreur';
$locale['yes']                  = 'Oui';
$locale['no']                   = 'Non';
$locale['cancel']               = 'Annuler';
$locale['save']                 = 'Enregistrer';
$locale['send']                 = 'Envoyer';
$locale['submit']              = 'Envoyer';
$locale['delete']               = 'Supprimer';
$locale['close']                = 'Fermer';
$locale['next']                 = 'Suivant';
$locale['prev']                 = 'Précédent';
$locale['page']                 = 'Page';
$locale['click']                = 'Cliquez sur';
$locale['sort']                 = 'Trier';
$locale['drag']                 = 'Faites glisser';
$locale['help']                 = 'Aider';
$locale['first']                = 'Premier';
$locale['last']                 = 'Dernier';


?>