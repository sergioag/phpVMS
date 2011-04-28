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

class UserTest extends PHPUnit_Framework_TestCase   {
	
	public $pilotid;
	public $pilot_data;
    public $registrationData = array(
        'firstname' => 'Nabeel',
        'lastname' => 'Shahzad',
        'email' => 'unittest@email.com',
        'password' => 'TEST',
        'code' => 'VMS',
        'location' => 'US',
        'hub' => 'KJFK',
        'confirm' => false
        );
		
	/**
	 * UserTest::testRegisterUser()
	 * 
	 * @return void
	 */
	public function testRegisterUser() {
	   
		$data = RegistrationData::addUser($this->registrationData);
        $this->assertTrue($data, 'Reported error: '.RegistrationData::$error);
        
		$this->pilotid = RegistrationData::$pilotid;
        $this->assertGreaterThan(0, $this->pilotid, 'Valid pilot ID');
        
        $this->assertEquals(0, DB::errno(), 'User Registration');
        		
		# See if it was written
		$this->pilot_data = PilotData::getPilotData($this->pilotid);
		$this->assertObjectHasAttribute('pilotid', $this->pilot_data, 'Retrieve user data');
	}
	
    /**
     * UserTest::testUserDataIntegrity()
     * 
     * @return void
     */
    public function testUserDataIntegrity() {

        # See if basic data matched    
        $pilot = PilotData::getPilotByEmail('unittest@email.com');
        foreach($this->registrationData as $key => $value) {
         
            if($key == 'password') {
                continue;
            }
            
            $this->assertEquals($value, $pilot->{$key}, "Checking {$key}");
        }        
        
        # Did they get added to the default group?
        $defaultGroup = SettingsData::getSettingValue('DEFAULT_GROUP');
        $pilotGroups = PilotGroups::getUserGroups($pilot->pilotid);
        
        $this->assertNotEmpty($pilotGroups, 'PilotGroups::getUserGroups()');
        
        $found = false;
        foreach($pilotGroups as $group) {
            if(strtolower(trim($group->name)) == strtolower(trim($defaultGroup))) {
                $found = true;
                break;
            }
        }
        
        $this->assertTrue($found, 'User found in default group');    
    }
    
	/**
	 * UserTest::testEditUserData()
	 * 
	 * @return void
	 */
	public function testEditUserData()	{
	   
        $pilot = PilotData::getPilotByEmail('unittest@email.com');
        $this->assertObjectHasAttribute('pilotid', $pilot, 'PilotData::getPilotByEmail');
        
		# Check a save profile
        $save = PilotData::updateProfile($pilot->pilotid, array(
            'email' => 'unittest2@email.com',
            'location' => 'PK',
            )
        );
        
        $this->assertTrue($save, DB::error());
                
        # Verify if data was written, and if it differs
		$changeset1 = PilotData::getPilotData($pilot->pilotid);
        $this->assertEquals('PK', $changeset1->location);
		
		unset($data);
	}
    
    /**
     * UserTest::testUserStatusChanges()
     * 
     * @return void
     */
    public function testUserStatusChanges() {
        
        $pilot = PilotData::getPilotByEmail('unittest@email.com');
        
        # Go through all the statuses
        $status_type_list = Config::get('PILOT_STATUS_TYPES');
        
        foreach($status_type_list as $id => $status) {
            
            $save = PilotData::updateProfile($pilot->pilotid, array(
                'retired' => $id
            ));
            
            # Check if they are in the proper groups:
            foreach($status['group_add'] as $group) {
                $this->assertTrue(PilotGroups::CheckUserInGroup($pilot->pilotid, $group), "Error adding to \"$group\" for {$status['name']}");
            }
            
            foreach($status['group_remove'] as $group) {
                $this->assertNotTrue(PilotGroups::CheckUserInGroup($pilot->pilotid, $group));
            }
        }
        
        /* Set the user back to the default status */
        foreach($status_type_list as $id => $status) {
            
            if($status['default'] == false) {
                continue;
            }
            
            $save = PilotData::updateProfile($pilot->pilotid, array(
                'retired' => $id,
            ));
            
            # Check if they are in the proper groups:
            foreach($status['group_add'] as $group) {
                $this->assertTrue(PilotGroups::CheckUserInGroup($pilot->pilotid, $group), "Error adding to \"$group\" for {$status['name']}");
            }
            
            foreach($status['group_remove'] as $group) {
                $this->assertNotTrue(PilotGroups::CheckUserInGroup($pilot->pilotid, $group));
            }
        }
    }
    
    
    /**
     * UserTest::testPIREPFile()
     * 
     * @return void
     */
    public function testPIREPFile() {
        
        
    }
    
	
	/**
	 * UserTest::testDeleteUser()
	 * 
	 * @return void
	 */
	public function testDeleteUser() {
	   
        $pilot = PilotData::getPilotByEmail('unittest2@email.com');
        $this->assertObjectHasAttribute('pilotid', $pilot, 'PilotData::getPilotByEmail');
        
		$result = PilotData::deletePilot($pilot->pilotid);
        
		$data = PilotData::GetPilotData($pilot->pilotid);
		$this->assertFalse($data, "Pilot still exists");
	}
}
