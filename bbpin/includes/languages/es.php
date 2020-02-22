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
$locale['hello'] 			= '¡Hola';
$locale['change.password'] 	= 'Cambiar contraseña';
$locale['logout'] 			= 'Cerrar sesión';
$locale['login'] 			= 'Login';
$locale['goto.home']		= 'Ir a la página principal '.SITE_NAME;
$locale['btn.find.user'] 	= 'Encuentra usuarios';
$locale['btn.find.groups'] 	= 'Encontrar grupos';
$locale['btn.save'] 		= 'guardar';
$locale['btn.del.group'] 	= 'Eliminar grupo';
$locale['warn.mes']			= 'Advertencia!';
$locale['signin']			= 'Regístrate en';

$locale['any']				= 'Any';
$locale['my.pin.requ']  	= 'My BBM-Pins Request..';
$locale['pin.requ.sent']  	= 'Pin request sent to user, user will be notified of your request.';
$locale['pin.requ.resent']  = 'Pin request already sent to this user.';
$locale['pin.requ.error']  	= 'Error in sending request, please try again later';
$locale['find.pins'] 		= 'Encontrar BBM-Pins';
$locale['find.group'] 		= 'Encontrar Grupos de BBM chat';
$locale['newest.groups']	= 'Nuevos <acronym title="blackberry messenger">BBM</acronym> Chat Grupos';
$locale['pro.incomplete'] 	= 'La información de su perfil está incompleto.<br>
							   Usted no será capaz de buscar otro miembro hasta que haya actualizado su perfil.<br>
							   Haga <a href="edit-profile.html">clic aquí para completar</a> su perfil.';
$locale['pro.missing.photo']= '<b>Falta foto del perfil</b> Para ver los miembros con fotos primero debe subir una foto de su auto. haga clic <a href="edit-my-gallery.html">aquí</a> para añadir una imagen.';

$locale['pin.verified']		= "Pin verificado";
$locale['pin.not.verified'] = "Pin no verificado";
$locale['male.gender'] 		= 'masculino';
$locale['female.gender'] 	= 'femenino';
$locale['male.gender.edit']	= 'masculino';
$locale['female.gender.edit']= 'femenino';
$locale['status.single'] 	= 'solo';
$locale['status.in a relationship'] = 'En una relación';
$locale['status.separated'] = 'apartado';
$locale['status.married'] 	= 'casado';
$locale['status.divorce'] 	= 'divorcio';
$locale['status.'."&nbsp;"] = '';
$locale['latest.members']   = 'Últimos Miembros';

//PROFILE
$locale['gender'] 			= 'género';
$locale['fname'] 			= 'Nombre';
$locale['lname'] 			= 'apellido';
$locale['age'] 				= 'edad';
$locale['edit.profile'] 	= 'Editar su perfil';
$locale['edit.gallery'] 	= 'Editar Galería de fotos';
$locale['gallery'] 			= 'Photo Gallery';
$locale['add.bbm.group'] 	= 'Agregue su Grupo BBM';
$locale['send.message'] 	= 'Enviar mensaje';
$locale['request.bbm.pin'] 	= 'Solicitud BBM Pin';
$locale['pro.update'] 		= 'Actualizar perfil';
$locale['pro.status'] 		= 'Estado civil';
$locale['pro.gender.pre'] 	= 'Preferencia de género';
$locale['pro.looking'] 		= 'Buscando a';
$locale['pro.country'] 		= 'País';
$locale['pro.education'] 	= 'Nivel de Educación';
$locale['pro.employment'] 	= 'Trabajo de campo';
$locale['pro.about'] 		= 'Acerca de mí';
$locale['pro.interest'] 	= 'Mon intérêt';
$locale['pro.dob'] 			= 'Date de naissance';
$locale['leave.comment']	= 'Deja un comentario';
$locale['leave.img.comment']= 'Leave a photo comment';
$locale['btn.add.comment'] 	= 'Añadir comentario';
$locale['btn.add.group'] 	= 'Agregue su Grupo BBM';
$locale['gallery.notice'] 	= 'Please upload at least one image for the other members viewing pleasure.';
$locale['hidden.by.user'] 	= 'Oculto por el usuario';
//GROUP
$locale['group.photo'] 			= 'Foto del grupo';
$locale['group.add.new'] 		= 'Crear Nuevo Grupo BBM';
$locale['group.name'] 			= 'Nombre del grupo';
$locale['group.country'] 		= 'País de Origen';
$locale['group.about'] 			= 'Descripción del Grupo';
$locale['group.edit'] 			= 'Edite su Grupo';
$locale['group.edit.gallery'] 	= 'Editar grupo Galería de Fotos';
$locale['group.request'] 		= 'Enviar Petición de grupo';
$locale['group.notice'] 		= 'Según algunos Grupos BBM no puede obtener acceso instantáneo debido a la cantidad de la solicitud de miembro y el importe límite de personas que pueden estar en cualquier grupo de blackberry.';
$locale['group.category'] 		= 'Grupo de Categorías';
$locale['edit.group.photo']		= "Foto del grupo";
//FOOTER
$locale['about']	= 'sobre';
$locale['faqs'] 	= 'Preguntas frecuentes';
$locale['privacy']	= 'Política de privacidad';
$locale['terms']	= 'Términos y condiciones';
$locale['feedback']	= 'Comentarios / Sugerencias';
$locale['contact']	= 'contáctenos';
$locale['fb.follow']= 'Al igual que nuestra página de Facebook';
$locale['tw.follow']= 'Follow @ jusbbmpins';
function profileLinkTitle($str){ echo 'ver perfil de '. strtolower($str) .' y obtener pin blackberry messenger';}
function requestPinTitle($str ){ return 'solicitud blackberry pin formulario '.strtolower($str);}
function myPinRequest($userId,$email,$fullname){ return 'haga clic <a href="'.DOMAIN.'index.php?action=request-pin&id='.$userId.'&ed='.base64_encode(base64_encode($email)).'" title="'.requestPinTitle($fullname).'" >aquí para solicitar</a> bbm pin-';}
?>