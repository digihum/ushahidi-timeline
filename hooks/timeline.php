<?php defined('SYSPATH') or die('No direct script access.');
// Start wildlife category block
class timeline { // CHANGE THIS FOR OTHER BLOCKS
	public function __construct()
	{
		// Array of block params
		$block = array(
			"classname" => "timeline", // Must match class name aboce
			"name" => "Timeline",
			"description" => "Show Time line"
		);
		// register block with core, this makes it available to users 
		blocks::register($block);
	}
	public function block()
	{
		// Load the reports block view
		$content = new View('timeline'); // CHANGE THIS IF YOU WANT A DIFFERENT VIEW
		
		// Get Reports
		$content->incidents = ORM::factory('incident')
 			->where('incident_active', '1')
 			->orderby('incident_date', 'desc')
 			->find_all();
			
		$dates = array();	
			
		foreach($content->incidents as $incident){
			$date = explode("-", $incident->incident_date);
			if(!isset($dates[$date[0] . "-" . $date[1]])){
				$dates[$date[0] . "-" . $date[1]] = 0;
			}
			$dates[$date[0] . "-" . $date[1]]++;
		}	
		
		$max = 0;
		$min = 1000000;
		
		foreach($dates as $date => $value){
			if($value>$min){
				$max = $value;
			}
			if($value>$max){
				$min = $value;
			}
		}
		
		ksort($dates);
		$date_keys = array_keys($dates);
		
		$content->max = $max; 
		$content->min = $min; 
		$content->dates = $dates;
		$content->date_start = $date_keys[0]; 
		$content->current = date("Y-m", time()); 
			
		echo $content;
	}
}
new thumbmaps;