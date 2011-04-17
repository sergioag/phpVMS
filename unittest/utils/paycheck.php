<?php

include '../../core/codon.config.php';
echo '<pre>';

$sql = 'UPDATE `'.TABLE_PREFIX.'pireps` SET `accepted`='.PIREP_PENDING.' WHERE `pirepid`=2';
DB::query($sql);

PIREPData::changePIREPStatus(2, PIREP_ACCEPTED);

var_dump(PilotData::getPaymentByPIREP(2));
