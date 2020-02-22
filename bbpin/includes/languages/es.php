<?php
/*
* Spanish File
*/
// Top Menu
$locale['php.locale']       = 'es_ES';
$locale['lang.dir']         = 'ltr';
$locale['lang']         	= 'spanish';
$locale['content.type']    	= 'ISO-8859-1';
$locale['date.long'] 		= 'l, d \d\e F \d\e Y h:i A';
$locale['menu.home'] 		= 'casa';
$locale['menu.find.people'] = 'Buscar personas';
$locale['menu.find.groups'] = 'Encontrar Grupos';
$locale['menu.messages'] 	= 'Mensajes';
$locale['menu.pin.request'] = 'Pin Solicitud';
$locale['menu.my.profile'] 	= 'Mi Perfil';
$locale['hello'] 			= '�Hola';
$locale['change.password'] 	= 'Cambiar contrase�a';
$locale['logout'] 			= 'Cerrar sesi�n';
$locale['login'] 			= 'Login';
$locale['goto.home']		= 'Ir a la p�gina principal '.SITE_NAME;
$locale['btn.find.user'] 	= 'Encuentra usuarios';
$locale['btn.find.groups'] 	= 'Encontrar grupos';
$locale['btn.save'] 		= 'guardar';
$locale['btn.del.group'] 	= 'Eliminar grupo';
$locale['warn.mes']			= 'Advertencia!';
$locale['signin']			= 'Reg�strate en';

$locale['any']				= 'Any';
$locale['my.pin.requ']  	= 'My BBM-Pins Request..';
$locale['pin.requ.sent']  	= 'Pin request sent to user, user will be notified of your request.';
$locale['pin.requ.resent']  = 'Pin request already sent to this user.';
$locale['pin.requ.error']  	= 'Error in sending request, please try again later';
$locale['find.pins'] 		= 'Encontrar BBM-Pins';
$locale['find.group'] 		= 'Encontrar Grupos de BBM chat';
$locale['newest.groups']	= 'Nuevos <acronym title="blackberry messenger">BBM</acronym> Chat Grupos';
$locale['pro.incomplete'] 	= 'La informaci�n de su perfil est� incompleto.<br>
							   Usted no ser� capaz de buscar otro miembro hasta que haya actualizado su perfil.<br>
							   Haga <a href="edit-profile.html">clic aqu� para completar</a> su perfil.';
$locale['pro.missing.photo']= '<b>Falta foto del perfil</b> Para ver los miembros con fotos primero debe subir una foto de su auto. haga clic <a href="edit-my-gallery.html">aqu�</a> para a�adir una imagen.';

$locale['pin.verified']		= "Pin verificado";
$locale['pin.not.verified'] = "Pin no verificado";
$locale['male.gender'] 		= 'masculino';
$locale['female.gender'] 	= 'femenino';
$locale['male.gender.edit']	= 'masculino';
$locale['female.gender.edit']= 'femenino';
$locale['status.single'] 	= 'solo';
$locale['status.in a relationship'] = 'En una relaci�n';
$locale['status.separated'] = 'apartado';
$locale['status.married'] 	= 'casado';
$locale['status.divorce'] 	= 'divorcio';
$locale['status.'."&nbsp;"] = '';
$locale['latest.members']   = '�ltimos Miembros';

//PROFILE
$locale['gender'] 			= 'g�nero';
$locale['fname'] 			= 'Nombre';
$locale['lname'] 			= 'apellido';
$locale['age'] 				= 'edad';
$locale['edit.profile'] 	= 'Editar su perfil';
$locale['edit.gallery'] 	= 'Editar Galer�a de fotos';
$locale['gallery'] 			= 'Photo Gallery';
$locale['add.bbm.group'] 	= 'Agregue su Grupo BBM';
$locale['send.message'] 	= 'Enviar mensaje';
$locale['request.bbm.pin'] 	= 'Solicitud BBM Pin';
$locale['pro.update'] 		= 'Actualizar perfil';
$locale['pro.status'] 		= 'Estado civil';
$locale['pro.gender.pre'] 	= 'Preferencia de g�nero';
$locale['pro.looking'] 		= 'Buscando a';
$locale['pro.country'] 		= 'Pa�s';
$locale['pro.education'] 	= 'Nivel de Educaci�n';
$locale['pro.employment'] 	= 'Trabajo de campo';
$locale['pro.about'] 		= 'Acerca de m�';
$locale['pro.interest'] 	= 'Mon int�r�t';
$locale['pro.dob'] 			= 'Date de naissance';
$locale['leave.comment']	= 'Deja un comentario';
$locale['leave.img.comment']= 'Leave a photo comment';
$locale['btn.add.comment'] 	= 'A�adir comentario';
$locale['btn.add.group'] 	= 'Agregue su Grupo BBM';
$locale['gallery.notice'] 	= 'Please upload at least one image for the other members viewing pleasure.';
$locale['hidden.by.user'] 	= 'Oculto por el usuario';
//GROUP
$locale['group.photo'] 			= 'Foto del grupo';
$locale['group.add.new'] 		= 'Crear Nuevo Grupo BBM';
$locale['group.name'] 			= 'Nombre del grupo';
$locale['group.country'] 		= 'Pa�s de Origen';
$locale['group.about'] 			= 'Descripci�n del Grupo';
$locale['group.edit'] 			= 'Edite su Grupo';
$locale['group.edit.gallery'] 	= 'Editar grupo Galer�a de Fotos';
$locale['group.request'] 		= 'Enviar Petici�n de grupo';
$locale['group.notice'] 		= 'Seg�n algunos Grupos BBM no puede obtener acceso instant�neo debido a la cantidad de la solicitud de miembro y el importe l�mite de personas que pueden estar en cualquier grupo de blackberry.';
$locale['group.category'] 		= 'Grupo de Categor�as';
$locale['edit.group.photo']		= "Foto del grupo";
//FOOTER
$locale['about']	= 'sobre';
$locale['faqs'] 	= 'Preguntas frecuentes';
$locale['privacy']	= 'Pol�tica de privacidad';
$locale['terms']	= 'T�rminos y condiciones';
$locale['feedback']	= 'Comentarios / Sugerencias';
$locale['contact']	= 'cont�ctenos';
$locale['fb.follow']= 'Al igual que nuestra p�gina de Facebook';
$locale['tw.follow']= 'Follow @ jusbbmpins';
function profileLinkTitle($str){ echo 'ver perfil de '. strtolower($str) .' y obtener pin blackberry messenger';}
function requestPinTitle($str ){ return 'solicitud blackberry pin formulario '.strtolower($str);}
function myPinRequest($userId,$email,$fullname){ return 'haga clic <a href="'.DOMAIN.'index.php?action=request-pin&id='.$userId.'&ed='.base64_encode(base64_encode($email)).'" title="'.requestPinTitle($fullname).'" >aqu� para solicitar</a> bbm pin-';}
?>