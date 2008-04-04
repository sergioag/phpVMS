<h3>PIREPs List</h3>
<p><?=$descrip;?></p>
<?php
if(!$pireps)
{
	echo '<p>No reports have been found</p>';
	return;
}	
?>
<table id="tabledlist" class="tablesorter">
<thead>
<tr>
	<th>Pilot</th>
	<th>Flight Number</th>
	<th>Departure</th>	
	<th>Arrival</th>
	<th>Flight Time</th>
	<th>Submitted</th>
	<th>Options (* for double click)</th>
</tr>
</thead>
<tbody>
<?php
foreach($pireps as $report)
{
?>
<tr>
	<td align="center"><a id="dialog" class="jqModal" href="action.php?admin=viewpilots&action=viewoptions&pilotid=<?=$report->pilotid;?>"><?=$report->firstname .' ' . $report->lastname?></a></td>
	<td align="center"><?=$report->code . $report->flightnum; ?></td>
	<td align="center"><?=$report->depicao; ?></td>
	<td align="center"><?=$report->arricao; ?></td>
	<td align="center"><?=$report->flighttime; ?></td>
	<td align="center"><?=date(DATE_FORMAT, $report->submitdate); ?>
		<?php
		
		if($report->accepted == PIREP_ACCEPTED)
			echo '<div id="success">Accepted</div>';
		elseif($report->accepted == PIREP_REJECTED)
			echo '<div id="error">Rejected</div>';
		elseif($report->accepted == PIREP_PENDING)
			echo '<div id="error">Approval Pending</div>';
		elseif($report->accepted == PIREP_INPROGRESS)
			echo '<div id="error">Flight in Progress</div>';
		
		?>
	</td>
	<td align="center">
		<a href="action.php?admin=viewpireps" action="approvepirep" 
			id="<?=$report->pirepid;?>" class="ajaxcall">Accept * </a>
		<br />
		<a id="dialog" class="jqModal" 
			href="action.php?admin=rejectpirep&pirepid=<?=$report->pirepid;?>">Reject</a>
		<br />
		<a id="dialog" class="jqModal" 
			href="action.php?admin=addcomment&pirepid=<?=$report->pirepid;?>">Add Comment</a>
	</td>
</tr>
<?php
}
?>
</tbody>
</table>