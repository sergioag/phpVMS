<?php
/**
 * phpVMS - Virtual Airline Administration Software
 * Copyright (c) 2008 Nabeel Shahzad
 * For more information, visit www.phpvms.net
 *	Forums: http://www.phpvms.net/forum
 *	Documentation: http://www.phpvms.net/docs
 *
 * phpVMS is licenced under the following license:
 *   Creative Commons Attribution Non-commercial Share Alike (by-nc-sa)
 *   View license.txt in the root, or visit http://creativecommons.org/licenses/by-nc-sa/3.0/
 *
 * @author Nabeel Shahzad
 * @copyright Copyright (c) 2008, Nabeel Shahzad
 * @link http://www.phpvms.net
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

class TimesTest extends PHPUnit_Framework_TestCase  {
    
	public $added_time = '';
	
	public function __construct() {
		parent::__construct();
	}
	
	public function testTimesAdded() {
	   
		$sql='SELECT `flighttime`
			  FROM '.TABLE_PREFIX.'pireps 
			  WHERE `accepted`='.PIREP_ACCEPTED;
			  
		$results = DB::get_results($sql);
		$this->added_time = 0;
        
		foreach($results as $row) {
			$this->added_time = Util::AddTime($this->added_time, $row->flighttime);
		}
		
        $this->assertNotEqual(0, $this->added_time);
		
		// Now calculate by PIREP
		$allpilots = PilotData::GetAllPilots();
		
		$total = 0;
		foreach($allpilots as $pilot) {
			$p_hours = PilotData::getPilotHours($pilot->pilotid);
			$total = Util::AddTime($total, $p_hours);
		}
		
		$this->assertNotEqual(0, $total);
		$this->assertEqual($total, $this->added_time);
		
		StatsData::UpdateTotalHours();
		$this->assertEqual($total, StatsData::TotalHours());
	}
}