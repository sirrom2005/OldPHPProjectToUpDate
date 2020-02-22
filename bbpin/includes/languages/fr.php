<?php
/*
* French File
*/
// Top Menu
$locale['php.locale']       = 'fr';
$locale['lang.dir']         = 'ltr';
$locale['lang']         	= 'french';
$locale['content.type']    	= 'ISO-8859-1';
$locale['date.long'] 		= 'l d F Y h:i A';
$locale['menu.home'] 		= 'maison';
$locale['menu.find.people'] = 'Trouver des gens';
$locale['menu.find.groups'] = 'Trouvez Groupes';
$locale['menu.messages'] 	= 'Messages';
$locale['menu.pin.request'] = 'Demande Pin';
$locale['menu.my.profile'] 	= 'Mon profil';
$locale['hello'] 			= 'Bonjour';
$locale['change.password'] 	= 'Changer mot de passe';
$locale['logout'] 			= 'Déconnexion';
$locale['login'] 			= 'Login';
$locale['goto.home']		= 'Aller à la page '.SITE_NAME;
$locale['btn.find.user'] 	= 'Trouvez utilisateurs';
$locale['btn.find.groups'] 	= 'trouver des groupes';
$locale['btn.save'] 		= 'Sauvegarder';
$locale['btn.del.group'] 	= 'supprimer le groupe';
$locale['warn.mes']			= 'Attention!';
$locale['signin']			= 'Connectez-vous';

$locale['any']				= 'Any';
$locale['my.pin.requ']  	= 'My BBM-Pins Request...';
$locale['pin.requ.sent']  	= 'Pin request sent to user, user will be notified of your request.';
$locale['pin.requ.resent']  = 'Pin request already sent to this user.';
$locale['pin.requ.error']  	= 'Error in sending request, please try again later';
$locale['find.pins'] 		= 'Trouvez BBM-Pins';
$locale['find.group'] 		= 'Trouvez Chat Groupes BBM';
$locale['newest.groups']	= 'Nouveaux groupes de discussion <acronym title="blackberry messenger">BBM</acronym>';
$locale['pro.incomplete'] 	= 'Informations de profil vous est incomplète.<br>
							   Vous ne serez pas en mesure de rechercher un autre membre jusqu\'à ce que vous avez mis à jour votre profil.<br>
							   <a href="edit-profile.html">Cliquez ici pour compléter votre profil</a>.';
$locale['pro.missing.photo']= '<b>Manquant photo de profil</b> pour afficher les membres avec photo vous devez d\'abord télécharger une photo de votre auto. cliquer <a href="edit-my-gallery.html">ici</a> A ajouter une photo.';

$locale['pin.verified']		= 'Pin vérifié';
$locale['pin.not.verified'] = 'Broche non vérifiés';
$locale['male.gender'] 		= 'masculin';
$locale['female.gender'] 	= 'féminin';
$locale['male.gender.edit']	= 'masculin';
$locale['female.gender.edit']= 'féminin';
$locale['status.single'] 	= 'unique';
$locale['status.in a relationship'] = 'Dans une relation';
$locale['status.separated'] = 'séparé';
$locale['status.married'] 	= 'marié';
$locale['status.divorce'] 	= 'divorce';
$locale['status.'."&nbsp;"] 	= '';
$locale['latest.members']   = 'Derniers membres';

//PROFILE
$locale['gender'] 			= 'sexe';
$locale['fname'] 			= 'Prénom';
$locale['lname'] 			= 'Nom de famille';
$locale['age'] 				= 'âge';
$locale['edit.profile'] 	= 'Modifier votre profil';
$locale['edit.gallery'] 	= 'Modifier la galerie de photos';
$locale['gallery'] 			= 'Photo Gallery';
$locale['add.bbm.group'] 	= 'Ajouter votre groupe BBM';
$locale['send.message'] 	= 'Envoyer un message';
$locale['request.bbm.pin'] 	= 'Demande BBM-Pin';
$locale['pro.update'] 		= 'Mettre à jour le profil';
$locale['pro.status'] 		= 'État civil';
$locale['pro.gender.pre'] 	= 'Préférence de genre';
$locale['pro.looking'] 		= 'Looking For';
$locale['pro.country'] 		= 'pays';
$locale['pro.education'] 	= 'Niveau d\'instruction';
$locale['pro.employment'] 	= 'domaine de l\'emploi';
$locale['pro.about'] 		= 'À propos de moi';
$locale['pro.interest'] 	= 'Mon intérêt';
$locale['pro.dob'] 			= 'Date de naissance';
$locale['leave.comment']	= 'Laisser un commentaire';
$locale['leave.img.comment']= 'Leave a photo comment';
$locale['btn.add.comment'] 	= 'Ajouter un commentaire';
$locale['btn.add.group'] 	= 'Ajouter votre groupe BBM';
$locale['gallery.notice'] 	= 'S\'il vous plaît télécharger au moins une image pour les autres membres visualisation plaisir.';
$locale['hidden.by.user'] 	= 'Caché par l\'utilisateur';
//GROUP
$locale['group.photo'] 			= 'photo de groupe';
$locale['group.add.new'] 		= 'Ajouter un nouveau groupe de BBM';
$locale['group.name'] 			= 'Nom du groupe';
$locale['group.country'] 		= 'Pays d\'origine';
$locale['group.about'] 			= 'description du groupe';
$locale['group.edit'] 			= 'Modifier votre groupe';
$locale['group.edit.gallery'] 	= 'Modifier le groupe de la galerie de photos';
$locale['group.request'] 		= 'Envoyer la demande du Groupe';
$locale['group.notice'] 		= 'DSelon certains groupes BBM vous ne pouvez pas obtenir un accès instantané à cause de la quantité de la demande des membres et le montant du plafond de personnes qui peuvent être dans n\'importe quel groupe de mûre.';
$locale['group.category'] 		= 'Catégorie Groupe';
$locale['edit.group.photo']		= "photo de groupe";
//FOOTER
$locale['about']	= 'sur';
$locale['faqs'] 	= 'FAQ';
$locale['privacy']	= 'Politique de confidentialité';
$locale['terms']	= 'Conditions générales de vente';
$locale['feedback']	= 'Commentaires / Suggestions';
$locale['contact']	= 'Contactez-nous';
$locale['fb.follow']= 'Comme notre page Facebook';
$locale['tw.follow']= 'Suivez @ jusbbmpins';
function profileLinkTitle($str){ echo 'Voir le profil '.strtolower($str).' et obtenir votre blackberry messenger broches';}
function requestPinTitle($str ){ return 'demande mûre formulaire broches '.strtolower($str);}
function myPinRequest($userId,$email,$fullname){ return 'cliquez <a href="'.DOMAIN.'index.php?action=request-pin&id='.$userId.'&ed='.base64_encode(base64_encode($email)).'" title="'.requestPinTitle($fullname).'" >ici pour demander</a> bbm broches';}
?>