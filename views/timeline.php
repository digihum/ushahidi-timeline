<link rel="stylesheet" href='<?PHP echo url::site() ?>plugins/timeline/css/timeline.css' />
<div class="timelinescroll">
	<p><?php echo Kohana::lang('timeline.guide');?></p>
	<?php

	$scale = 50 / $max;
	
	$date = $date_start;
	$output = "";
	$width = 0;

	if($interval!=6){

		foreach($dates as $date => $total)
		{
			$parts = explode("-",$date);
			$time = mktime(0,0,0,$parts[1],1,$parts[0]);
			$time_text = date("F o", $time);
			if($interval!=0){
				$time_text = Kohana::lang('timeline.from') . " " . $time_text;
				if($interval==1){
					if(substr($parts[1],0,1)==0){
						$parts[1] = str_replace("0","",$parts[1]);
					}
					$parts[1]+=1;
					if($parts[1]>12){
						$parts[1] = 12;
					}
					$end_date = mktime(0,0,0,$parts[1],1,$parts[0]);
				}
				if($interval==2){
					if(substr($parts[1],0,1)==0){
						$parts[1] = str_replace("0","",$parts[1]);
					}
					$parts[1]+=2;
					if($parts[1]>12){
						$parts[1] = 12;
					}
					$end_date = mktime(0,0,0,$parts[1],1,$parts[0]);
				}
				if($interval==3){
					if(substr($parts[1],0,1)==0){
						$parts[1] = str_replace("0","",$parts[1]);
					}
					$parts[1]+=3;
					if($parts[1]>12){
						$parts[1] = 12;
					}
					$end_date = mktime(0,0,0,$parts[1],1,$parts[0]);
				}
				if($interval==4){
					if(substr($parts[1],0,1)==0){
						$parts[1] = str_replace("0","",$parts[1]);
					}
					$parts[1]+=6;
					if($parts[1]>12){
						$parts[1] = 12;
					}
					$end_date = mktime(0,0,0,$parts[1],1,$parts[0]);
				}
				if($interval==5){
					if(substr($parts[1],0,1)==0){
						$parts[1] = str_replace("0","",$parts[1]);
					}
					$parts[1]+=12;
					if($parts[1]>12){
						$parts[1] = 12;
					}
					$end_date = mktime(0,0,0,$parts[1],1,$parts[0]);
				}
			}else{
				$end_date = $date;
			}
			
			if(isset($dates[$date_start])){
				$height = $total * $scale;
				$top = (50 - $height) + 200;
			
				$output .= '<div class="timelineunit">';
				$output .= '<div class="timelinehigher"><a href="' . url::site() . 'reports/index?s=' . $time . '&e=' . $end_date . '"><div style="position:relative; top:' . $top . 'px; width:50px; height:' . $height . 'px; background:#000"></div></a></div>';
				$output .= '<div class="timelinelower">' . $time_text . '</div>';
				$output .= '</div>';
			}else{
				$output .= '<div class="timelineunit">';
				$output .= '<div class="timelinehigher"></div>';
				$output .= '<div class="timelinelower">' . $time_text . '</div>';
				$output .= '</div>';
			}
			$width += 50;
			
		}
	}else{
		foreach($dates as $date => $total)
		{
		
			$seasons = array("spring","summer","autumn","winter");
		
			foreach($seasons as $season){
		
				if(isset($total[$season])){
					$height = $total[$season] * $scale;
					$top = (50 - $height) + 200;
					
					if($season=="spring"){
						$time = mktime(0,0,0,3,21,$date);
						$end_date = mktime(0,0,0,6,21,$date);
					}
					
					if($season=="summer"){
						$time = mktime(0,0,0,6,21,$date);
						$end_date = mktime(0,0,0,9,21,$date);
					}
					
					if($season=="autumn"){
						$time = mktime(0,0,0,9,21,$date);
						$end_date = mktime(0,0,0,12,21,$date);
					}
					
					if($season=="winter"){
						$time = mktime(0,0,0,12,21,$date);
						$end_date = mktime(0,0,0,3,21,$date+1);
					}
				
					$output .= '<div class="timelineunit">';
					$output .= '<div class="timelinehigher"><a href="' . url::site() . 'reports/index?s=' . $time . '&e=' . $end_date . '"><div style="position:relative; top:' . $top . 'px; width:50px; height:' . $height . 'px; background:#000"></div></a></div>';
					$output .= '<div class="timelinelower">' . Kohana::lang('timeline.' . $season) . " " . $date . '</div>';
					$output .= '</div>';
				}else{
					$output .= '<div class="timelineunit">';
					$output .= '<div class="timelinehigher"></div>';
					$output .= '<div class="timelinelower">' . Kohana::lang('timeline.' . $season) . " " . $date . '</div>';
					$output .= '</div>';
				}
				$width += 50;
				
			}
		}
	}
	
	?>
	<div class="timelineholder" style="width:<?PHP echo $width; ?>px; height:350px">
		<?PHP
			echo $output;
		?>
	</div>
</div>
