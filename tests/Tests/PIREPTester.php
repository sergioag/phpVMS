<?php
/*	Test registration functionality


class PIREPTester extends UnitTestCase  
{
	
	public $pirep_id;
	public $report_details;
	
	public function __construct() 
	{
		parent::__construct();
		$this->UnitTestCase('PIREP Testing');
	}
	
	public function testSubmitPIREP()
	{
		echo '<h3>PIREP Checks</h3>';
		
		Config::Set('PIREP_CHECK_DUPLICATE', false);

		$schedules = SchedulesData::findSchedules(array('s.flighttype'=>'P'));
		$idx = rand(0, count($schedules)-1);
		$sched = $schedules[$idx];
		unset($schedules);

		echo '<strong>Filing report...</strong><br />';
		$data = array(
			'pilotid'=>1,
			'code'=>$sched->code,
			'flightnum'=>$sched->flightnum,
			'route' => 'HYLND DCT PUT J42 RBV J230 BYRDD J48 MOL DCT FLCON',
			'depicao'=>$sched->depicao,
			'arricao'=>$sched->arricao,
			'aircraft'=>$sched->aircraft,
			'flighttime'=>$sched->flighttime,
			'submitdate'=>'NOW()',
			'fuelused'=>6000,
			'source'=>'unittest',
			'comment'=>'Test Flight',
		);
		
		$pirepid = PIREPData::fileReport($data);
		if($pirepid === false)
		{
			echo PIREPData::$lasterror;
		}

		$this->assertTrue(intval($pirepid), 'PIREP filed properly');
		$this->pirep_id = $pirepid;
	}
	
	public function testRetrieveReport()
	{
		$this->report_details = PIREPData::findPIREPS(array('p.pirepid'=>$this->pirep_id));
		$this->assertTrue($this->report_details);
	}
	
	public function testChangePIREPStatus()
	{
		# Reject it first
		$status = PIREPData::ChangePIREPStatus($this->pirep_id, PIREP_REJECTED);
		$this->assertTrue($status, DB::$error);
		
		# Verify status change
		$this->report_details = PIREPData::findPIREPS(array('p.pirepid'=>$this->pirep_id));
		$this->assertEqual($this->report_details[0]->accepted, PIREP_REJECTED);
		
		# Change to accepted
		$status = PIREPData::ChangePIREPStatus($this->pirep_id, PIREP_ACCEPTED);
		$this->assertTrue($status, DB::$error);
		
		# Verify status change
		$this->report_details = PIREPData::findPIREPS(array('p.pirepid'=>$this->pirep_id));
		$this->assertEqual($this->report_details[0]->accepted, PIREP_ACCEPTED);
	}
	
	public function testDeletePIREP()
	{
		# Delete it
		PIREPData::deletePIREP($this->pirep_id);
		
		# Verify delete
		$data = PIREPData::findPIREPS(array('p.pirepid'=>$this->pirep_id));
		$this->assertFalse($data);
		
		echo '<br />';
	}
}
*/
