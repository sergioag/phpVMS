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

class SchedulePIREPTest extends PHPUnit_Framework_TestCase {
    
    protected $CODE = 'VMS';
    protected $FLIGHTNUM = '9998';
    
    protected $samplePilotID = 1;
    
    protected $sample_schedule = array(
        'code' => '', 
        'flightnum' => '',
        'depicao' => 'KJFK', 
        'arricao' => 'KBOS', 
        'route' => 'BDR V229 HFD V3 WOONS', 
        'aircraft' => '1', 
        'flightlevel' => '300',
        'distance' => '', 
        'deptime' => '1PM EST',
        'arrtime' => '3PM EST', 
        'flighttime' => '2',
        'daysofweek' => '1234567', 
        'week1' => '1234567', 'week2' => '01234', 'week3' => '1234567', 'week4' => '1234567', 
        'price' => '300', 
        'payforflight' => '3000',
        'flighttype' => 'P', 
        'notes' => 'This is a test flight',
        'enabled' => true,
    );
    
    /**
     * ScheduleTest::testAddSchedule()
     * 
     * @return void
     */
    public function testAddSchedule() {
        
        $this->sample_schedule['code'] = $this->CODE;
        $this->sample_schedule['flightnum'] = $this->FLIGHTNUM;        
        
        $ret = SchedulesData::addSchedule($this->sample_schedule);
        $this->assertTrue($ret, DB::error());
    }
    
    
    /**
     * Always find and return the test schedule, run the asserts
     * on what's found/returned too
     * 
     * @return void
     */
    protected function findSchedule() {

        $sched = SchedulesData::findSchedules(array(
            's.code' => $this->CODE, 's.flightnum' => $this->FLIGHTNUM,
            )
        );
        
        $this->assertGreaterThan(0, count($sched));
        
        # Make sure this schedule has an ID param?
        $sched = $sched [0];
        $this->assertObjectHasAttribute('id', $sched, 'Has ID');
        
        return $sched;
        
    }
    /**
     * ScheduleTest::testScheduleIntegrity()
     * 
     * @return void
     */
    public function testScheduleIntegrity() {
        
        $sched = $this->findSchedule();
        
        $this->assertEquals($this->CODE, $sched->code);
        $this->assertEquals($this->FLIGHTNUM, $sched->flightnum);
    }
    
    
    /**
     * ScheduleTest::testEditSchedule()
     * 
     * @return void
     */
    public function testEditSchedule() {
        
        $sched = $this->findSchedule();
        
        # Make sure days of week all inserted properly
        $this->assertEquals('1234560', $sched->daysofweek);
        $this->assertEquals('1234560', $sched->week1, 'Week 1, full week');
        $this->assertEquals('01234', $sched->week2, 'Week 2, partial week');        
    }
    
    /**
     * ScheduleTest::testNavData()
     * 
     * @return void
     */
    public function testNavData() {
        $sched = $this->findSchedule();
        $routeDetails = SchedulesData::getRouteDetails($sched->id);
        $this->assertGreaterThan(0, count($routeDetails));
    }
    
    /**
     * ScheduleTest::testPIREPFile()
     * 
     * @return void
     */
    public function testPIREPFile() {
        
        $sched = $this->findSchedule();
        
        
        Config::Set('PIREP_CHECK_DUPLICATE', false);
        Config::Set('EMAIL_SEND_PIREP', false);
        
        $pirep_test = array(
        	'pilotid' => $this->samplePilotID,
        	'code' => $sched->code,
        	'flightnum' => $sched->flightnum,
        	'route' => $sched->route,
        	'depicao' => $sched->depicao,
        	'arricao' => $sched->arricao,
        	'aircraft' => $sched->aircraft,
        	'flighttime' => $sched->flighttime,
        	'submitdate' => 'NOW()',
        	'fuelused' => 6000,
        	'source' => 'unittest',
        	'comment' => 'Test Flight',
        );
        
        # Update Pilot Pay to be set to zero
        PilotData::updateProfile($this->samplePilotID, array('totalpay' => 0));
        $pilot_data = PilotData::getPilotData($this->samplePilotID);
        $this->assertEquals($pilot_data->totalpay, 0, 'Reset Pilot Pay to 0');
        
        # File the flight report
        $pirepid = PIREPData::fileReport($pirep_test);
		$this->assertGreaterThan(0, $pirepid, PIREPData::$lasterror);
        
        $pirepdata = PIREPData::findPIREPS(array('p.pirepid' => $pirepid));     
        $this->assertGreaterThan(0, count($pirepdata), 'No PIREPs returned');   
        
        # Work on one...
        $pirepdata = $pirepdata[0];
        
        # Verify the little bits of this PIREP....
        $this->assertEquals(PILOT_PAY_SCHEDULE, $pirepdata->paytype , 'PIREP Pay Type');
        $this->assertEquals($this->sample_schedule['payforflight'], $pirepdata->pilotpay, 'PIREP Pay Amount');
        
        # Check the pilot pay        
        $pilot_data = PilotData::getPilotData($this->samplePilotID);
        $this->assertEquals($pilot_data->totalpay, 0, 'Check pilot pay after PIREP FILE');
        
        # Change PIREP Status
        $status = PIREPData::changePIREPStatus($pirepdata->pirepid, PIREP_ACCEPTED);
        
        $pilot_data = PilotData::getPilotData($this->samplePilotID);
        $this->assertEquals($pilot_data->totalpay, $this->sample_schedule['payforflight'], 
                'Check pilot pay after PIREP ACCEPT');
        
        # Was this PIREP found...
        $lastPIREPS = PIREPData::getLastReports($this->samplePilotID);
        
        # Delete the PIREP
        PIREPData::deletePIREP($pirepid);
		
		# Verify delete
		$data = PIREPData::findPIREPS(array('p.pirepid' => $pirepid));
		$this->assertEmpty($data, 'PIREPDdata::deletePIREP()');
    }
    
    /**
     * ScheduleTest::deleteTestSchedule()
     * 
     * @return void
     */
    public function deleteTestSchedule() {
        $sched = $this->findSchedule();
        
        $ret = SchedulesData::deleteSchedule($sched->id);
        
    }
}









