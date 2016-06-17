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

		Requirements::css('plugins/timeline/css/timeline.css');
	
		// Load the reports block view
		$content = new View('timeline'); // CHANGE THIS IF YOU WANT A DIFFERENT VIEW
		
		// Get Reports
		$content->incidents = ORM::factory('incident')
 			->where('incident_active', '1')
 			->orderby('incident_date', 'desc')
 			->find_all();
			
		$dates = array();	
		
		$settings = ORM::factory('timeline_settings')
 			->find_all();
			
		foreach ($settings as $setting){
			$interval = $setting->timeline_interval;
		}
		
		if($interval != 6){
		
			foreach($content->incidents as $incident){
				$date = explode("-", $incident->incident_date);
				if(!isset($dates[$date[0] . "-" . $date[1]])){
					$dates[$date[0] . "-" . $date[1]] = 0;
				}
				$dates[$date[0] . "-" . $date[1]]++;
			}	
			
			$max = 0;
			$min = 1000000;
			
			ksort($dates);
			
			$date_keys = array_keys($dates);
			$date = $date_keys[0];
			$end_date = $date_keys[count($date_keys)-1];
			$new_dates = array();
			$total = 0;
			
			if($interval!=0){
				while($date != $end_date){
					
					$parts = explode("-", $date);
					if(isset($dates[$date])){
						$total += $dates[$date];
					}
					
					if($interval==1){
						if($parts[1]=="02"){
							$new_dates[$parts[0] . "-01"] = $total;
							$total = 0;
						}
						if($parts[1]=="04"){
							$new_dates[$parts[0] . "-03"] = $total;
							$total = 0;
						}
						if($parts[1]=="06"){
							$new_dates[$parts[0] . "-05"] = $total;
							$total = 0;
						}
						if($parts[1]=="08"){
							$new_dates[$parts[0] . "-07"] = $total;
							$total = 0;
						}
						if($parts[1]=="10"){
							$new_dates[$parts[0] . "-09"] = $total;
							$total = 0;
						}
						if($parts[1]=="12"){
							$new_dates[$parts[0] . "-11"] = $total;
							$total = 0;
						}
					}
					
					if($interval==2){
						if($parts[1]=="03"){
							$new_dates[$parts[0] . "-01"] = $total;
							$total = 0;
						}
						if($parts[1]=="06"){
							$new_dates[$parts[0] . "-04"] = $total;
							$total = 0;
						}
						if($parts[1]=="09"){
							$new_dates[$parts[0] . "-07"] = $total;
							$total = 0;
						}
						if($parts[1]=="12"){
							$new_dates[$parts[0] . "-10"] = $total;
							$total = 0;
						}
					}
					
					if($interval==3){
						if($parts[1]=="04"){
							$new_dates[$parts[0] . "-01"] = $total;
							$total = 0;
						}
						if($parts[1]=="08"){
							$new_dates[$parts[0] . "-05"] = $total;
							$total = 0;
						}
						if($parts[1]=="12"){
							$new_dates[$parts[0] . "-09"] = $total;
							$total = 0;
						}
					}
					
					if($interval==4){
						if($parts[1]=="06"){
							$new_dates[$parts[0] . "-01"] = $total;
							$total = 0;
						}
						if($parts[1]=="12"){
							$new_dates[$parts[0] . "-07"] = $total;
							$total = 0;
						}
					}
					
					if($interval==5){
						if($parts[1]=="12"){
							$new_dates[$parts[0] . "-01"] = $total;
							$total = 0;
						}
					}

					if($interval==6){
						if($parts[1]=="12"){
							$new_dates[$parts[0] . "-01"] = $total;
							$total = 0;
						}
					}
					
					if(substr($parts[1],0,1)==0){
						$next_month = substr($parts[1],1,1) + 1; 
					}else{
						$next_month = $parts[1] + 1; 
					}
					if($next_month==13){
						$next_month ="01";
						$next_year = $parts[0] + 1;
					}else{
						if(strlen($next_month)!=2){
							$next_month = "0" . $next_month;
						}
						$next_year = $parts[0];
					}
					$date = $next_year . "-" . $next_month;
				}
				
				if($total!=0){
					
					if($interval==1){
					
						if(substr($parts[1],0,1)=="0"){
							$month = str_replace("0","",$parts[1]);
						}else{
							$month = $parts[1];
						}	
					
						if($month<="02"){
							$new_dates[$parts[0] . "-01"] = $total;
						}
						if($month<="04"){
							$new_dates[$parts[0] . "-03"] = $total;
						}
						if($month<="06"){
							$new_dates[$parts[0] . "-05"] = $total;
						}
						if($month<="08"){
							$new_dates[$parts[0] . "-07"] = $total;
						}
						if($month<="10"){
							$new_dates[$parts[0] . "-09"] = $total;
						}
						if($month<="12"){
							$new_dates[$parts[0] . "-11"] = $total;
						}
					}
					
					if($interval==2){
					
						if(substr($parts[1],0,1)=="0"){
							$month = str_replace("0","",$parts[1]);
						}else{
							$month = $parts[1];
						}	
						
						if($month<="03"){
							$new_dates[$parts[0] . "-01"] = $total;
						}else if($month<="06"){
							$new_dates[$parts[0] . "-04"] = $total;
						}else if($month<="09"){
							$new_dates[$parts[0] . "-07"] = $total;
						}else if($month<="12"){
							$new_dates[$parts[0] . "-10"] = $total;
						}
					}
					
					if($interval==3){
					
						if(substr($parts[1],0,1)=="0"){
							$month = str_replace("0","",$parts[1]);
						}else{
							$month = $parts[1];
						}	
						
						if($month <= "4"){
							$new_dates[$parts[0] . "-01"] = $total;
						}else if($month <="8"){
							$new_dates[$parts[0] . "-05"] = $total;
							$total = 0;
						}else if($month <="12"){
							$new_dates[$parts[0] . "-09"] = $total;
						}
					}
					
					if($interval==4){
					
						if(substr($parts[1],0,1)=="0"){
							$month = str_replace("0","",$parts[1]);
						}else{
							$month = $parts[1];
						}	
						
						if($month <= "6"){
							$new_dates[$parts[0] . "-01"] = $total;
						}else if($month <= "12"){
							$new_dates[$parts[0] . "-06"] = $total;
						}
					}
					
					if($interval==5){
						$new_dates[$next_year . "-01"] = $total;
					}

					if($total>$min){
						$min = $total;
					}
					if($total>$max){
						$max = $total;
					}
					
				}
			}
		}else{
		
			foreach($content->incidents as $incident){
				
				$date = explode("-", $incident->incident_date);
	
				if($date[1]==1||$date[1]==2){
					$season = "winter";
				}
				if($date[1]==3){
					if($date[2]<21){
						$season = "winter";
					}else{
						$season = "spring";
					}
				}
				if($date[1]==4||$date[1]==5){
					$season = "spring";
				}
				if($date[1]==6){
					if($date[2]<21){
						$season = "spring";
					}else{
						$season = "summer";
					}
				}
				if($date[1]==7||$date[1]==8){
					$season = "summer";
				}
				if($date[1]==9){
					if($date[2]<21){
						$season = "summer";
					}else{
						$season = "autumn";
					}
				}
				if($date[1]==10||$date[1]==11){
					$season = "autumn";
				}
				if($date[1]==12){
					if($date[2]<21){
						$season = "autumn";
					}else{
						$season = "winter";
					}
				}
				if(!isset($dates[$date[0]])){
					if(isset($dates[$date[0]][$season])){
						$dates[$date[0]][$season] = array(0);
					}
				}
				
				$dates[$date[0]][$season]++;
				
				if($dates[$date[0]][$season]>$min){
					$min = $dates[$date[0]][$season];
				}
				if($dates[$date[0]][$season]>$max){
					$max = $dates[$date[0]][$season];
				}
				
			}
			
		}
		
		if($interval != 6){
			$date_keys = array_keys($new_dates);
		}
		
		$content->interval = $interval; 
		$content->max = $max; 
		$content->min = $min; 
		
		if($interval != 6){
			$content->dates = $new_dates;
			$content->date_start = $date_keys[0]; 
			$content->current = date("Y-m", time()); 
		}else{
			ksort($dates);
			$date_keys = array_keys($dates);
			$content->dates = $dates;
			$content->date_start = $date_keys[0]; 
			
			$current_year = date("Y", time());
			$current_month = date("m", time());
			$current_day = date("j", time());
			
			if($current_month==1||$current_month==2){
				$season = "winter";
			}
			if($current_month==3){
				if($current_day<21){
					$season = "winter";
				}else{
					$season = "spring";
				}
			}
			if($current_month==4||$current_month==5){
				$season = "spring";
			}
			if($current_month==6){
				if($current_day<21){
					$season = "spring";
				}else{
					$season = "summer";
				}
			}
			if($current_month==7||$current_month==8){
				$season = "summer";
			}
			if($current_month==9){
				if($current_day<21){
					$season = "summer";
				}else{
					$season = "autumn";
				}
			}
			if($current_month==10||$current_month==11){
				$season = "autumn";
			}
			if($current_month==12){
				if($current_day<21){
					$season = "autumn";
				}else{
					$season = "winter";
				}
			}
			if(!isset($dates[$date[0]])){
				if(isset($dates[$date[0]][$season])){
					$dates[$date[0]][$season] = array(0);
				}
			}
			
			$content->current = $current_year . "-" . $season;
			
		}
			
		echo $content;
	}
}
new timeline;