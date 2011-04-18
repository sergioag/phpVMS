<h3>Activity Feed</h3>
<?php

foreach($allactivities as $activity) {
    
    /*  Use the activity->type to determine the type of activity (duh?)
        Constants are in app.config.php 
        
        Like here, I put a specific link to the PIREP at the end of the message
        You can use the if/else's to add specific images?
        
        $activity->refid is the ID of the thing it's referring to, so if it's a
        new PIREP, the refid will be the ID of the PIREP
        
        $activity-> also contains all the fields about the pilot who this notice
        is about        
     */
        
    $pilotCode = PilotData::getPilotCode($activity->code, $activity->pilotid);
    
    $link_title = '';
    $link_href = '';
    if($activity->type == ACTIVITY_NEW_PIREP) {
        
        $link_href = url('/pireps/view/'.$activity->refid);
        $link_title = 'View Flight Report';
        
    } elseif($activity->type == ACTIVITY_NEW_PILOT) {
        /* Something special for a new pilot? */
    }
?>
    <p><a href="<?php echo url('/profile/view/'.$activity->pilotid);?>">
        <?php echo $pilotCode.' '.$activity->firstname.' '.$activity->lastname?>
        </a> 
    
        <?php echo $activity->message ?>
        
        <?php
        if($link_href != '') {
            echo ' <a href="'.$link_href.'">'.$link_title.'</a>';
        }
        ?>
    </p>
<?php
}
?>