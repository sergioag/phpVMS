<h3><?php echo $title?></h3>

<?php
	if(!$allpilots)
	{
		echo '¡No hay pilotos!';
		return;
	}
?>
<table id="tabledlist" class="tablesorter">
<thead>
<tr>
	<th>ID de Piloto</th>
	<th>Nombre</th>
	<th>Rango</th>
	<th>Vuelos</th>
	<th>Horas</th>
	<th>VATSIM PID</th>
</tr>
</thead>
<tbody>
<?php
foreach($allpilots as $pilot)
{
	/* 
		To include a custom field, use the following example:

		<td>
			<?php echo PilotData::GetFieldValue($pilot->pilotid, 'VATSIM ID'); ?>
		</td>

		For instance, if you added a field called "IVAO Callsign":

			echo PilotData::GetFieldValue($pilot->pilotid, 'IVAO Callsign');		
	 */
	 
	 // To skip a retired pilot, uncomment the next line:
	 //if($pilot->retired == 1) { continue; }
?>
<tr>
	<td width="1%" nowrap><a href="<?php echo url('/profile/view/'.$pilot->pilotid);?>">
			<?php echo PilotData::GetPilotCode($pilot->code, $pilot->pilotid)?></a>
	</td>
	<td>
		<img src="<?php echo Countries::getCountryImage($pilot->location);?>" 
			alt="<?php echo Countries::getCountryName($pilot->location);?>" />
			
		<?php echo $pilot->firstname.' '.$pilot->lastname?>
	</td>
	<td><img src="<?php echo $pilot->rankimage?>" alt="<?php echo $pilot->rank;?>" /></td>
	<td><?php echo $pilot->totalflights?></td>
	<td><?php echo Util::AddTime($pilot->totalhours, $pilot->transferhours); ?></td>
	<td><?php echo PilotData::GetFieldValue($pilot->pilotid, 'VATSIM PID'); ?></td>
<?php
}
?>
</tbody>
</table>