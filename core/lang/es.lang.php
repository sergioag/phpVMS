<?php
/**
 * Spanish Language Strings for phpVMS
 * 
 * @author Sergio Aguayo
 * 
 * You can use this file to create your own translations
 * Format is
 * 
 * key=>string
 * 
 * Key must be lower case, no underscores.  These are mainly for the
 * admin panel.
 */
 
$trans = array(
	
	/* Define some core language stuff */
	'invalid.php.version'				=> 'No este ejecutando PHP 5.0+',
	'database.connection.failed'		=> 'Falló la conexión a la base de datos',
	'error'								=> 'Ocurrió un error (%s)', /* %s is the error string */
	
	/*
	 * Module language replacements
	 */
	
	/* Email stuff */
	'email.inuse'						=> 'Esta dirección de email ya esta en uso',
	'email.register.accepted.subject'	=> '¡Su registro fue aceptado!',
	'email.register.rejected.subject'	=> '¡Su registro fue rechazado!',
	'email.pilot.retired.subject'		=> SITE_NAME.': Usted ha sido marcado como inactivo',
	
	/* Expenses */
	
	
	
	/* Registration Errors */
	'password.wrong.length'				=> 'La contraseña tiene menos de 5 caracteres',
	'password.no.match'					=> 'Las contraseñas no coinciden',
	'password.changed'					=> 'La contraseña ha sido cambiada satisfactoriamente',
	
	/* Pilots Info */
	'pilot.deleted'						=> 'El piloto ha sido eliminado',
	
	/* Awards */
	'award.exists'						=> '¡El piloto ya tiene este premio!',
	'award.deleted'						=> '¡Premio eliminado!',
	
	/* Groups */
	'group.added'						=> 'El grupo %s ha sido agregado', /* %s is group name */
	'group.saved'						=> 'El grupo %s ha sido guardado', /* %s is group name */
	'group.no.name'						=> 'Debe ingresar un nombre para el grupo',
	'group.pilot.already.in'			=> '¡El usuario ya estaba en este grupo!',
	'group.add.error'					=> 'Ocurrió un error agregando a este usuario al grupo',
	'group.user.added'					=> '¡El usuario ha sido agregado al grupo!',
	
	/* Pages */
	'page.add.title'					=> 'Agregar página',
	'page.edit.title'					=> 'Editar página', 
	'page.exists'						=> '¡Esta página ya existe!',
	'page.create.error'					=> 'Ocurrió un error creando el archivo',
	'page.edit.error'					=> 'Ocurrió un error guardando el contenido',
	'page.error.delete'					=> '¡Ocurrió un error borrando la página!',
	'page.deleted'						=> 'La página fue eliminada',
	
	/* News */
	'news.add.title'					=> 'Agregar Noticias',
	'news.edit.title'					=> 'Editar Noticias',
	'news.updated.success'				=> '¡Noticia editada correctamente!',
	'news.updated.error'				=> 'Ocurrió un error editando la noticia',
	'news.delete.error'					=> 'Ocurrió un error eliminando la noticia',
	'news.item.deleted'					=> 'Noticia eliminada',
	
	/* Settings */
	'settings.add.field'				=> 'Agregar Campo',
	'settings.edit.field'				=> 'Editar Campo',
	'pirep.field.add'					=> 'Agregar campo de PIREP',
	'pirep.field.edit'					=> 'Editar campo de PIREP',
	
	/* PIREPS */
	'pireps.view.recent'				=> 'Reportes Recientes',
	
	
	/*
	 * Template language replacements
	 */
	 
	
);