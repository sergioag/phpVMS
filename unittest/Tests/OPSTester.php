<?php

class OPSTester extends UnitTestCase {
	
	public $pirep_id;
	public $report_details;
	
	public function __construct() 
	{
		parent::__construct();
		$this->UnitTestCase('PIREP Testing');
	}
	
	public function testRetrieveAirport()
	{
		echo '<h3>OperationsData Tests</h3>';
		echo "<strong>Checking geonames server</strong><br />";
		Config::Set('AIRPORT_LOOKUP_SERVER', 'geonames');
		
		OperationsData::RemoveAirport('PANC');
		$return = OperationsData::RetrieveAirportInfo('PANC');
		
		$this->assertNotEqual($return, false);
		
		echo "<strong>Checking phpVMS API server</strong><br />";
		Config::Set('AIRPORT_LOOKUP_SERVER', 'phpvms');
		Config::Set('PHPVMS_API_SERVER', 'http://apidev.phpvms.net');
		OperationsData::RemoveAirport('PANC');
		$return = OperationsData::RetrieveAirportInfo('PANC');
		
		$this->assertNotEqual($return, false);
		
	}
	
	public function testFindSchedules()
	{
		heading('findSchedules');
		$data = SchedulesData::findSchedules(array());
		$this->assertNotEqual($data, false);
	}

	public function testFindAircraft()
	{
		
	}
}