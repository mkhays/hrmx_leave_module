<?php  
class date_manager{
	public function __contruct(){
		
		}
# Get all dates between two dates using php code:
public function getAllDatesBetweenTwoDates($strDateFrom,$strDateTo)
{
    $aryRange=array();

    $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),     substr($strDateFrom,8,2),substr($strDateFrom,0,4));
    $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),     substr($strDateTo,8,2),substr($strDateTo,0,4));

    if ($iDateTo>=$iDateFrom)
    {
        array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry
        while ($iDateFrom<$iDateTo)
        {
            $iDateFrom+=86400; // add 24 hours
            array_push($aryRange,date('Y-m-d',$iDateFrom));
        }
    }
    return $aryRange;
}	

//exclude weekends
public function exclude_weekends($dateArray){
	foreach($dateArray as $dates):
//echo $dates.'-';
 $weekday = date("w", strtotime($dates)).'<br />';
if($weekday!=0&&$weekday!=6){
	$week_day[] =$dates;
	}
endforeach;
return $week_day;
	}
	
}



?>