<div id="mainbox">
<?php

	// Show the News module, call the function ShowNewsFront
	//	This is in the modules/Frontpage folder
	
	MainController::Run('News', 'ShowNewsFront', 5);
?>
</div>
<div id="sidebar">
	<h3>Reportes Recientes</h3>
	
	<?php MainController::Run('PIREPS', 'RecentFrontPage', 5); ?>

	<h3>Pilotos mas nuevos</h3>
	
	<?php MainController::Run('Pilots', 'RecentFrontPage', 5); ?>
	
	<h3>Usuarios Conectados</h3>
	<p><i>Han habido <?php echo count($usersonline)?> usuario(s) y <?php echo count($guestsonline);?> invitado(s) conectados en los últimos <?php echo Config::Get('USERS_ONLINE_TIME')?> minutos.</i></p>
	
	<?php
	/* $usersonline also has the list of users -
		really simple example
		
		Or if you're not on the frontpage:
		$usersonline = StatsData::UsersOnline();
		
	
	foreach($usersonline as $pilot)	
	{
		echo "{$pilot->firstname} {$pilot->lastname}<br />";
	}
	*/
	?>
	
</div>