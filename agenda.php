<?php
date_default_timezone_set('America/Sao_Paulo');
//date_default_timezone_set('Asia/Tokyo');

//$start_time = array("06:00","10:00","11:00","14:00","15:00","16:00","18:00","20:00","23:00");
//$end_time =   array("07:00","11:00","12:00","15:00","16:00","17:00","19:00","21:00","00:00");

//$start_time1 = array("06:00","10:00","11:00","14:00","15:00","16:00","18:00","20:00","23:00");
//$end_time1 =   array("07:00","11:00","12:00","15:00","16:00","17:00","19:00","21:00","00:00");

//$start_time2 = array("05:00","06:00","07:00");
//$end_time2 =   array("06:00","07:00","08:00");
$start_time2 = array("04:00","05:00","06:00","07:00","14:00","15:00","16:00","18:00","20:00","23:00");
$end_time2 =   array("05:00","06:00","07:00","08:00","15:00","16:00","17:00","19:00","21:00","00:00");
echo "array start_time2 ";print_r($start_time2);echo '</br>';
echo "array end_time2 ";print_r($end_time2);echo '</br></br>';
//$start_time2 = array("06:00","07:00","08:00","09:00","14:00","15:00","16:00","18:00","20:00","23:00");
//$end_time2 =   array("07:00","08:00","09:00","10:00","15:00","16:00","17:00","19:00","21:00","00:00");
//$start_time2 = array("06:00","07:00");
//$end_time2 =   array("07:00","08:00");

//$end_time_button = array("07:00","11:00","12:00","15:00","16:00","17:00","19:00","21:00","00:00");

//$diff = array_diff($end_time1,$start_time1);  // compare entry array $end_time1 are not presente in entry array $start_time1

// makes a variable called $diff_slice_index to slice array $end_time1 in array for the scheduled sequence and other array for EditUserProfileAgenda $schedule_num_rows > 1
foreach($end_time2 as $key=>$value){	
	if( array_diff(array($value),$start_time2) ){	
	$diff_slice_index = $key;	
	break;
	}
}
echo $diff_slice_index;echo '</br>';

echo "array slice 2nd part: [start] ";print_r( array_slice($start_time2,$diff_slice_index) );echo '</br>';
echo "array slice 2nd part: [end] ";print_r( array_slice($end_time2,$diff_slice_index) );echo '</br>';
$start_time = array_slice($start_time2,$diff_slice_index);
$end_time = array_slice($end_time2,$diff_slice_index);
$start_time1 = array_slice($start_time2,$diff_slice_index);
$end_time1 = array_slice($end_time2,$diff_slice_index);
$end_time_button = array_slice($end_time2,$diff_slice_index);

$diff = array_diff($end_time1,$start_time1);  // compare entry array $end_time1 are not presente in entry array $start_time1
/*
echo "diff : ";print_r($diff);echo '</br>';

while (list(, $val) = each($end_time2)) {	
	$i++;
    if ($val == '15:00') {
        break;   
    }
    echo "$val<br />\n";
}
*/
//print_r(array_keys($end_time1,"17:00"));echo '</br>';
//print_r( array_combine(array_keys($end_time1),$diff) ) ;echo '</br>';
	/*  20-03-2016 new code for field1 when for example 10:00-11:00 and 11:00-12:00 are scheduled  $start_time1 = array("10:00","11:00","17:00");$end_time1 = array("11:00","12:00","18:00");
	foreach($end_time1 as $key=>$value){	
		if( !array_diff(array($value),$start_time1 ) ){
			$field1[$key][0] = 1;
		}else{
			$subtract_end_start = (strtotime($start_time1[$key+1]) - strtotime($end_time1[$key])) / 3600;
			for ($i=0; $i < $subtract_end_start ; $i++){								
				$field1[$key][$i] = $i+1;									
			}
			for ($i=1; $i < $subtract_end_start +1 ; $i++){									
				$field2[$key][$i] = $i;
			}
		}
	}
	*/
	
	//echo " $ end time 1 : ";print_r($end_time_button);echo '</br>';echo '</br>';
	$array_test = array_keys($diff);
	
	echo '</br>';echo "[part 1] \$diff : ";print_r($diff);echo '</br>';
	
	foreach($diff as $key=>$value){
		if($value == end($diff))break;
		if($value != end($diff)){
			$subtract_end_start = (strtotime($start_time1[$key+1]) - strtotime($end_time1[$key])) / 3600;
			echo "\$subtract_end_start = ".$subtract_end_start."&nbsp &nbsp";
		}
		//isset($parts[1]) ? $parts[1] : null;
		/*
		0	06:00 - 07:00 $diff[0] 11:00
		1	1
		2	2
		3	3
		4	10:00 - 11:00
		5	11:00 - 12:00 $diff[2]
		6	1
		7	2
		8	14:00 - 15:00
		9	15:00 - 16:00
		10	16:00 - 17:00 $diff[5]
		11	1
		12	18:00 - 19:00 $diff[6]
		13	1
		14	20:00 - 21:00 $diff[7]
		15	1
		16	2
		17	23:00 - 24:00 $diff[8]
		array([0]=>0;[1]=>2;[2]=>5;[3]=>6;[4]=>7;[5]=>8);
		*/
		if($subtract_end_start == 0){ $field1[$key] = 0;$field2[$key] = 0; }
			else {				
				for ($i=0; $i < $subtract_end_start ; $i++){
					$field1[$key][$i] = $i+1;					
				}
				for ($i=1; $i < $subtract_end_start +1 ; $i++){
					$field2[$key][$i] = $i;
					echo 'foreach $diff ['.$key.']['.$i.'] = '.$i.'</br>';
				}	
			}	
	}
	echo '</br>[part 2] $field1 : ';print_r($field1);echo '</br>';
	//echo '</br>';
	//foreach($diff as $key=>$value){
	foreach($diff as $key=>$value){
		if($value == end($diff))break;		
		//if(!end($diff)) $subtract_end_start = (strtotime($start_time1[$key+1]) - strtotime($end_time1[$key])) / 3600;
		//if(!end($diff)) 
		$subtract_end_start = (strtotime($start_time1[$key+1]) / 3600) - (strtotime($end_time1[$key])/3600);
		
		//echo "Subtract \$start_time1[ ] - \$end_time1[ ] = ";echo (strtotime($start_time1[$key+1]) / 3600) - (strtotime($end_time1[$key])/3600);echo ";";
		
		echo "&nbsp &nbsp".$start_time1[$key+1].' - '.$end_time1[$key].' = '.$subtract_end_start.'; ';
		// $subtract_end_start = (strtotime($start_time1[$key+1]) - strtotime($end_time1[$key])) / 3600;
		if($subtract_end_start != 0){			
			if ( $key == 0 ) {
				continue;
			}			
			//echo "</br>field1[";echo $key;echo "] ";print_r($field1[$key -1]);echo " ; key : ";echo key($field1);echo "; subtract_end_start = ".$subtract_end_start;
			//for ($i=1; $i < $subtract_end_start+1; $i++){			
				for ($i=1; $i < $subtract_end_start+1; $i++){
					if( ! isset($field1[ $key - 1]) ){
						while(key( $field1 ) !== $key) next($field1) ;
						$prev_val = prev($field1);
						$prev_key = key($field1);
						$end_value = end( $field1[$prev_key] )+($key - $prev_key -1);
					} else { $end_value = end( $field1[$key- 1] ); }
					//echo '$field1['.$key.']['.$i.'] = $field2['.$key.']['.$i.'] = '.$field2[$key][$i].' + 1 + '.$end_value.' = '.$field2[$key][$i]+1+$end_value.'. </br>';
					echo '$field1['.$key.']['.$i.'] = '.$field2[$key][$i].' + 1 + '.$end_value.'; </br>';
					array_splice( $field1[$key],$i-1,1, $field2[$key][$i]+1+$end_value  );				
				}			
		}
	}
	echo '</br>[part 3] $field1 : ';print_r($field1);echo '</br>';
	foreach($field1 as $key=>$data){
		if(is_array($data))
		{
			foreach($data as $other_data)
			{
				$ar[] = $other_data;
			}
			
		}
		else
		{
			//echo $data, ', ';
			$ar[] = $data ;
		}
	}
	echo '[part 4] $ar : ';print_r($ar);
	for ($i=0; $i < count($ar) ; $i++){						
		array_splice( $start_time,$ar[$i],0,date('H:i',strtotime($end_time[  $ar[$i] - 1  ])) );
		array_splice($end_time,$ar[$i],0,date('H:i',strtotime($end_time[  $ar[$i] - 1  ])+60*60));
	}
	$start_array_size = sizeof($start_time);
	foreach($start_time as $key1=>$value1){
		$start_{$key1} = $value1;							
	}
	foreach($end_time as $key2=>$value2){		
		$end_{$key2} = $value2;
		$schedule_time = date('H:i', strtotime($start_{$key2})).' - '.date('H:i', strtotime($end_{$key2}));
	}
	
	if($diff_slice_index != 0){	
	$start_time_first_slice_part = array_slice($start_time2,0,$diff_slice_index);
	$end_time_first_slice_part = array_slice($end_time2,0,$diff_slice_index);
		//if(date('02:00') > $start_time_first_slice_part[0]){echo date('H:00', time())." > ".$start_time_first_slice_part[0];
		if(date('H:i', time()) > $start_time_first_slice_part[0]){
		echo '</br>'.date('H:00', time())." > ".$start_time_first_slice_part[0];		
		} else {
			echo '</br>'.date('H:00', time())." < ".$start_time_first_slice_part[0];
			$time_agenda_empty1 = date('00:00');
			$time_agenda_empty2 = date('01:00');

			$datetime_agenda_empty2 = $time_agenda_empty2;
			$datetime_agenda_empty1 = $time_agenda_empty1;
			$subtract_end_start = ( strtotime( '04:00:00' )   - strtotime($datetime_agenda_empty1) ) / 3600;
			for ($i=0; $i < $subtract_end_start; $i++){		
				//$timestamp_agenda_empty_start{$i} = time() + ($i*60*60);
				//$timestamp_agenda_empty_end{$i} = time() + (($i+1)*60*60);
				
				//$time_agenda_empty_start{$i} = date('H:00', $timestamp_agenda_empty_start{$i});
				//$time_agenda_empty_end{$i} = date('H:00', $timestamp_agenda_empty_end{$i});
				// http: //stackoverflow.com/questions/660501/simplest-way-to-increment-a-date-in-php
				$index1 = $i;
				$index2 = $i;
				$datetime1 = strtotime("+$index1 hour", strtotime("00:00"));
				$datetime2 = strtotime("+$index2 hour", strtotime("01:00"));
				//echo date("H:i", $date);
				$time_agenda_empty_start{$i} = date('H:00', $datetime1);
				$time_agenda_empty_end{$i} = date('H:00', $datetime2);
				if( !in_array(date('Y-m-d H:i:s', strtotime($time_agenda_empty_start{$i})), $start_time1) ){
				echo '
				<div id="agenda_'.$i.'" style="text-align:center;background-color:#FFFFFF;border-bottom:1px solid rgba(144,144,144,0.25);">
					'.$time_agenda_empty_start{$i}.' - '.$time_agenda_empty_end{$i}.'
					<button id="agendar'.$i.'" class="button_schedule"><a style=";" class="agendar">agendar</a></button>  id='.$i.'
				</div>';
				$ar[] = $i;
				} else {
				echo '
				<div id="agenda_'.$i.'" style="text-align:center;background-color:#FFFFFF;border-bottom:1px solid rgba(144,144,144,0.25);">
					'.$time_agenda_empty_start{$i}.' - '.$time_agenda_empty_end{$i}.' ocupada id='.$i.'
				</div>';
				}
			}	
		}
	}
	
	$time_agenda_empty1 = date('00:00');
	$time_agenda_empty2 = date('01:00');

	$datetime_agenda_empty2 = $time_agenda_empty2;
	$datetime_agenda_empty1 = $time_agenda_empty1;
	$subtract_end_start = ( strtotime( '04:00:00' )   - strtotime($datetime_agenda_empty1) ) / 3600;
	for ($i=0; $i < $subtract_end_start; $i++){		
		//$timestamp_agenda_empty_start{$i} = time() + ($i*60*60);
		//$timestamp_agenda_empty_end{$i} = time() + (($i+1)*60*60);
		
		//$time_agenda_empty_start{$i} = date('H:00', $timestamp_agenda_empty_start{$i});
		//$time_agenda_empty_end{$i} = date('H:00', $timestamp_agenda_empty_end{$i});
		// http: //stackoverflow.com/questions/660501/simplest-way-to-increment-a-date-in-php
		$index1 = $i;
		$index2 = $i;
		$datetime1 = strtotime("+$index1 hour", strtotime("00:00"));
		$datetime2 = strtotime("+$index2 hour", strtotime("01:00"));
		//echo date("H:i", $date);
		$time_agenda_empty_start{$i} = date('H:00', $datetime1);
		$time_agenda_empty_end{$i} = date('H:00', $datetime2);
		if( !in_array(date('Y-m-d H:i:s', strtotime($time_agenda_empty_start{$i})), $start_time1) ){
		echo '
		<div id="agenda_'.$i.'" style="text-align:center;background-color:#FFFFFF;border-bottom:1px solid rgba(144,144,144,0.25);">
			'.$time_agenda_empty_start{$i}.' - '.$time_agenda_empty_end{$i}.'
			<button id="agendar'.$i.'" class="button_schedule"><a style=";" class="agendar">agendar</a></button>  id='.$i.'
		</div>';
		$ar[] = $i;
		} else {
		echo '
		<div id="agenda_'.$i.'" style="text-align:center;background-color:#FFFFFF;border-bottom:1px solid rgba(144,144,144,0.25);">
			'.$time_agenda_empty_start{$i}.' - '.$time_agenda_empty_end{$i}.' ocupada id='.$i.'
		</div>';
		}
	}
	if($diff_slice_index != 0){
	//echo "array slice 1st part: [start] ";print_r( array_slice($start_time2,0,$diff_slice_index) );echo '</br>';
	//echo "array slice 1st part: [end] ";print_r( array_slice($end_time2,0,$diff_slice_index) );echo '</br>';
	$start_time_first_slice_part = array_slice($start_time2,0,$diff_slice_index);
	$end_time_first_slice_part = array_slice($end_time2,0,$diff_slice_index);
	$end_time_button = array_slice($end_time2,$diff_slice_index);		
		foreach($start_time_first_slice_part as $key=>$value ){
			if( in_array(date($value), $end_time_button) ){																							
				$button_time_schedule{$key} = ' <button id="agendar'.$key.'" class="button_schedule"><a style=";" class="agendar">agendar</a></button>';
			} else {									
				$button_time_schedule{$key} = '<a style=";" class="agendar">ocupada</a>';
			}
			echo'<div id="agenda_'.$key.'" style="text-align:center;background-color:#FFFFFF;border-bottom:1px solid rgba(144,144,144,0.25);">													
					'.date('H:i', strtotime($value)).' - '.date('H:i', strtotime($end_time_first_slice_part[$key])).$button_time_schedule{$key}.' id='.$key.'
				</div>';
		}		
	}
	
	foreach($end_time as $key3=>$value ){						
		if(! in_array(date($value), $end_time_button) ){																								
			$button_time_schedule{$key3} = ' <button id="agendar'.$key3.'" class="button_schedule"><a style=";" class="agendar">agendar</a></button>';
		} else {									
				$button_time_schedule{$key3} = '<a style=";" class="agendar">ocupada</a>';
		}						
		echo'<div id="agenda_'.$key3.'" style="text-align:center;background-color:#FFFFFF;border-bottom:1px solid rgba(144,144,144,0.25);">													
				'.date('H:i', strtotime($start_{$key3})).' - '.date('H:i', strtotime($value)).$button_time_schedule{$key3}.' id='.$key3.'
			</div>';		
	}
?>