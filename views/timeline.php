<link rel="stylesheet" href='<?PHP echo url::site() ?>plugins/timeline/css/timeline.css' />
<div class="timelinescroll">
	<p><?php echo Kohana::lang('timeline.guide');?></p>
	<?php
	
	$scale = 250 / $max;
	
	$date = $date_start;
	$output = "";
	$width = 0;
	do
	{
		$parts = explode("-",$date_start);
		$time = date("F o", mktime(0,0,0,$parts[1],1,$parts[0]));
		if(isset($dates[$date_start])){
		
			$height = $dates[$date_start] * $scale;
			$top = 250 - $height;
		
			$output .= '<div class="timelineunit">';
			$output .= '<div class="timelinehigher"><a href="' . url::site() . '/reports/index?from=' . $date_start . '-01&to=' . $date_start . '-31"><div style="position:relative; top:' . $top . 'px; width:50px; height:' . $height . 'px; background:#000"></div></a></div>';
			$output .= '<div class="timelinelower">' . $time . '</div>';
			$output .= '</div>';
		}else{
			$output .= '<div class="timelineunit">';
			$output .= '<div class="timelinehigher"></div>';
			$output .= '<div class="timelinelower">' . $time . '</div>';
			$output .= '</div>';
		}
		$parts = explode("-", $date_start);
		if($parts[1]=="12"){
			$date_start = ($parts[0] + 1) . "-01";
		}else{
			if(substr($parts[1],0,1)==0){
				$new_date = str_replace("0","",$parts[1]) + 1;
			}else{
				$new_date = $parts[1] + 1;
			}
			if(strlen($new_date)!=2){
				$new_date = "0" . $new_date;
			}
			$date_start = $parts[0] . "-" . $new_date;
		}
		$width += 50;
	}while ($date_start != $current);
	
	?>
	<div class="timelineholder" style="width:<?PHP echo $width; ?>px; height:350px">
		<?PHP
			echo $output;
		?>
	</div>
</div>
