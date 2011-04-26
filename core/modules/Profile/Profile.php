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
 
class Profile extends CodonModule
{
	
	/**
	 * Profile::index()
	 * 
	 * @return
	 */
	public function index()
	{
		if(!Auth::LoggedIn()) {
			$this->set('message', 'You must be logged in to access this feature!');
			$this->render('core_error.tpl');
			return;
		}

		/*
		 * This is from /profile/editprofile
		 */
		 if(isset($this->post->action)) {
			if($this->post->action == 'saveprofile') {
				$this->save_profile_post();
			}
			
			/* this comes from /profile/changepassword
			*/
			if($this->post->action == 'changepassword') {
				$this->change_password_post();
			}
		}
        
        $pilotInfo = PilotData::getPilotData(Auth::$userinfo->pilotid);
		
		if(Config::Get('TRANSFER_HOURS_IN_RANKS') == true) {
			$totalhours = $pilotInfo->totalhours + $pilotInfo->transferhours;
		} else {
			$totalhours = $pilotInfo->totalhours;
		}
		
		$this->set('pilotcode', PilotData::getPilotCode($pilotInfo->code, $pilotInfo->pilotid));
		$this->set('report', PIREPData::getLastReports($pilotInfo->pilotid));
		$this->set('nextrank', RanksData::getNextRank($totalhours));
		$this->set('allawards', AwardsData::getPilotAwards($pilotInfo->pilotid));
		$this->set('userinfo', $pilotInfo);
        $this->set('pilot', $pilotInfo);
		$this->set('pilot_hours', $totalhours);

		$this->render('profile_main.tpl');
		
		CodonEvent::Dispatch('profile_viewed', 'Profile');
	}
	
	/**
	 * This is the public profile for the pilot
	 */
	/**
	 * Profile::view()
	 * 
	 * @param string $pilotid
	 * @return
	 */
	public function view($pilotid='')
	{
        
        $pilotid = PilotData::parsePilotID($pilotid);
		$userinfo = PilotData::getPilotData($pilotid);
		
		$this->title = 'Profile of '.$userinfo->firstname.' '.$userinfo->lastname;
		
		$this->set('userinfo', $userinfo);
		$this->set('allfields', PilotData::getFieldData($pilotid, false));
		$this->set('pireps', PIREPData::getAllReportsForPilot($pilotid));
		$this->set('pilotcode', PilotData::getPilotCode($userinfo->code, $userinfo->pilotid));
		$this->set('allawards', AwardsData::getPilotAwards($userinfo->pilotid));
		
		$this->render('pilot_public_profile.tpl');
		$this->render('pireps_viewall.tpl');
	}
	
	/**
	 * Profile::stats()
	 * 
	 * @return
	 */
	public function stats()
	{
		if(!Auth::LoggedIn()) {
			$this->set('message', 'You must be logged in to access this feature!');
			$this->render('core_error.tpl');
			return;
		}
		
		$this->render('profile_stats.tpl');
	}

	/**
	 * Profile::badge()
	 * 
	 * @return
	 */
	public function badge()
	{
		$this->set('badge_url', fileurl(SIGNATURE_PATH.'/'.PilotData::GetPilotCode(Auth::$userinfo->code, Auth::$userinfo->pilotid).'.png'));
		$this->set('pilotcode', PilotData::GetPilotCode(Auth::$userinfo->code, Auth::$userinfo->pilotid));
		$this->render('profile_badge.tpl');
	}
		
	/**
	 * Profile::editprofile()
	 * 
	 * @return
	 */
	public function editprofile()
	{
		if(!Auth::LoggedIn()) {
			$this->set('message', 'You must be logged in to access this feature!');
			$this->render('core_error.tpl');
			return;
		}

		$this->set('userinfo', Auth::$userinfo);
		$this->set('customfields', PilotData::getFieldData(Auth::$pilotid, true));
		$this->set('bgimages', PilotData::getBackgroundImages());
		$this->set('countries', Countries::getAllCountries());
		$this->set('pilotcode', PilotData::getPilotCode(Auth::$userinfo->code, Auth::$userinfo->pilotid));

		$this->render('profile_edit.tpl');
	}
	
	/**
	 * Profile::changepassword()
	 * 
	 * @return
	 */
	public function changepassword()
	{
		if(!Auth::LoggedIn()) {
			$this->set('message', 'You must be logged in to access this feature!');
			$this->render('core_error.tpl');
			return;
		}

		$this->render('profile_changepassword.tpl');
	}
	
	/**
	 * Profile::save_profile_post()
	 * 
	 * @return
	 */
	protected function save_profile_post()
	{
		if(!Auth::LoggedIn()) {
			$this->set('message', 'You must be logged in to access this feature!');
			$this->render('core_error.tpl');
			return;
		}
		
		$userinfo = Auth::$userinfo;
		
		//TODO: check email validity
		if($this->post->email == '') {
			return;
		}
				
		$params = array(
			'code' => Auth::$userinfo->code,
			'email' => $this->post->email,
			'location' => $this->post->location,
			'hub' => Auth::$userinfo->hub,
			'bgimage' => $this->post->bgimage,
			'retired' => false
		);
			
		PilotData::updateProfile($userinfo->pilotid, $params);
		PilotData::SaveFields($userinfo->pilotid, $_POST);
		
		# Generate a fresh signature
		PilotData::GenerateSignature($userinfo->pilotid);
		
		PilotData::SaveAvatar($userinfo->code, $userinfo->pilotid, $_FILES);
		
		$this->set('message', 'Profile saved!');
		$this->render('core_success.tpl');
	}

	/**
	 * Profile::change_password_post()
	 * 
	 * @return
	 */
	protected function change_password_post()
	{
		if(!Auth::LoggedIn()) {
			$this->set('message', 'You must be logged in to access this feature!');
			$this->render('core_error.tpl');
			return;
		}
		
		// Verify
		if($this->post->oldpassword == '') {
			$this->set('message', 'You must enter your current password');
			$this->render('core_error.tpl');
			return;
		}

		if($this->post->password1 != $this->post->password2) {
			$this->set('message', 'Your passwords do not match');
			$this->render('core_error.tpl');
			return;
		}

		// Change
		$hash = md5($this->post->oldpassword . Auth::$userinfo->salt);

		if($hash == Auth::$userinfo->password) {
			RegistrationData::ChangePassword(Auth::$pilotid, $_POST['password1']);
			$this->set('message', 'Your password has been reset');
		} else {
			$this->set('message', 'You entered an invalid password');
		}

		$this->render('core_success.tpl');
	}
}