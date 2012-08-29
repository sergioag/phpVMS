<?php
class Vatsim extends CodonModule
{
	public $section=null;
	public $count = 0;
	
	public function get_vatsim_data()
	{
		//get new file from Vatsim if it is more than 5 minutes old
		if(!file_exists('vatsimdata.txt') || time()-filemtime('vatsimdata.txt') > 300)
		{
			//choose a random download location per VATSIM policy
			$random = (rand(1, 4));
			if ($random == 1)
				{$url = 'http://www.net-flyer.net/DataFeed/vatsim-data.txt';}
			if ($random == 2)
				{$url = 'http://www.klain.net/sidata/vatsim-data.txt';}
			if ($random == 3)
				{$url = 'http://fsproshop.com/servinfo/vatsim-data.txt';}
			if ($random == 4)
				{$url = 'http://info.vroute.net/vatsim-data.txt';}
			//get the file
			$file = new CodonWebService();
			$contents = @$file->get($url);
			//save new file to server
			$newfile="vatsimdata.txt"; 
			$file = fopen ($newfile, "w"); 
			fwrite($file, $contents); 
			fclose ($file);  
		}
		
		$contents = file('vatsimdata.txt');
		$this->section = array();
		$readsection = false;
		foreach($contents as $line)
		{
			if(preg_match("/.*{$find}.*/i", $line, $matches))
			{
				$readsection = true;
				continue;
			}
			if($readsection)
			{
				if(trim($line) == ';')
				{
					break;
				}
				
				$this->section[] = $line;
				$this->count++;
			}
		}
	}
	
	public function create_vatsim_data($find, $type, $callsign)
	{
		if($this->section == null)
			$this->get_vatsim_data();
		
		foreach ($this->section as $row)
		{
			$row_info = explode(":", $row);
			if (ereg("^$type", $row_info[3]))
			{
				if (ereg("^$callsign", $row_info[0]))
				{
					Template::Set('row_info', $row_info);
					Template::Show('vatsim.tpl');
				}
			}
		}
	}
	
	public function count_vatsim_data($find, $type, $callsign)
	{
		return $this->count;
	}
}