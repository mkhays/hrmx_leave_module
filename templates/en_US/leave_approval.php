<div class="panel-group" id="accordion">
<legend><?php  echo $form_title;   ?></legend> 
<?php
if($yr=='2016'){
	$activ1= "active";
	$activ2= "";
	$activ3= "";
	$activ4= "";
	$activ5= "";
	}else if($yr=='2015'){
		$activ1= "";
	$activ2= "active";
	$activ3= "";
	$activ4= "";
	$activ5= "";
		}else if($yr=='2014'){
			$activ1= "";
	$activ2= "";
	$activ3= "active";
	$activ4= "";
	$activ5= "";
			}else if($yr=='2017'){
			$activ1= "";
	$activ2= "";
	$activ3= "";
	$activ4= "active";
	$activ5= "";
			}
	else if($yr=='2018'){
	$activ1= "";
	$activ2= "";
	$activ3= "";
	$activ4= "";
	$activ5= "active";
			}

?>
<ul class="nav nav-pills">
<li role="presentation" class="<?php  echo $activ5; ?>"><a href="index.php?request=leave_requests&link=leave&link2=rev_lv&yr=2018">2018/2019</a></li>
<li role="presentation" class="<?php  echo $activ4; ?>"><a href="index.php?request=leave_requests&link=leave&link2=rev_lv&yr=2017">2017</a></li>
  <li role="presentation" class="<?php  echo $activ1; ?>"><a href="index.php?request=leave_requests&link=leave&link2=rev_lv&yr=2016">2016</a></li>
  <li role="presentation" class="<?php  echo $activ2; ?>"><a href="index.php?request=leave_requests&link=leave&link2=rev_lv&yr=2015">2015</a></li>
  <li role="presentation" class="<?php  echo $activ3; ?>"><a href="index.php?request=leave_requests&link=leave&link2=rev_lv&yr=2014">2014</a></li>
</ul>
<br  />
<?php  echo $data;   ?>
<?php if(!isset($days)){ echo "";}else {
 foreach($days as $day):
$reply = "  
   <div id='collapseOne' class='panel-collapse collapse in'>
      <div class='panel-body'>        
  <table class='table'>
				<thead bgcolor='#CCFF99'>
					<tr>
                    <tr  ><h5>$name4<b>&nbsp;&nbsp;Balance Leave Days</b></h5></tr>
						<th><h6 align='center'><b>Annual</b></h6></th>  
						<th><h6 align='center'><b>Sick</b></h6></th>
						<th><h6 align='center'><b>Paternity</b></h6></th>
                        <th><h6 align='center'><b>maternity</b></h6></th>
						<th><h6 align='center'><b>Compassionate</b></h6></th>
					</tr>
				</thead>
                <tbody>
				
				 <tr align='center' bgcolor='#CCFF99'>
			     <td>". round($day->annual_leave.' '.'days',4)  ."</td>
                 <td>". round($day->sick_leave.' '.'days',4)  ."</td>
                 <td>". round($day->paternity_leave.' '.'days',4)   ."</td>
                 <td>". round($day->maternity_leave.' '.'days',4)  ."</td>
                 <td>". round($day->compassionate_leave.' '.'days',4)   ."</td>
						
 
					</tr>
					</tbody>

			</table> 
              <table class='table'>
				<thead style='background-color:#CFC'>
					<tr>
                    <tr><h6><b>&nbsp;&nbsp;Leave days taken</b></h6></tr>
						<th><h6 align='center'><b>Annual</b></h6></th>  
						<th><h6 align='center'><b>Sick</b></h6></th>
						<th><h6 align='center'><b>Paternity</b></h6></th>
                        <th><h6 align='center'><b>maternity</b></h6></th>
						<th><h6 align='center'><b>Compassionate</b></h6></th>
					</tr>
				</thead>
                <tbody>
				
				 <tr align='center' style='background-color:#CFC'>
			     <td>".round(((date('m')-1)*1.75)-$day->annual_leave,4)."</td>
                 <td>". round(60-$day->sick_leave.' '.'days',4) ."</td>
                 <td>". round(4-$day->paternity_leave.' '.'days',4) ."</td>
                 <td>". round(60-$day->maternity_leave.' '.'days',4) ."</td>
                 <td>". round(15-$day->compassionate_leave.' '.'days',4) ."</td>
						
 
					</tr>
					</tbody>

			</table></div></div>";
           endforeach;

}  ?>
<?php  echo $reply;  ?>
  <?php foreach ($leave_req_det as $leave_data):?>
  <div class="panel panel-<?php switch($leave_data->status){case 1: echo 'warning';break; case 2: echo 'danger';break;default: echo 'success';}  ?>">
    <div class="panel-heading">
     
      <h4 class="panel-title" style="font-size:14px">
        <a data-toggle="collapse" data-parent="#accordion" href="<?php  echo '#'.$leave_data->id; ?>">
          <?php  echo $leave_data->leave_type .' '.'leave was requested on '.' <b>'.date_format(date_create(date('Y-m-d', strtotime($leave_data->request_date))), 'l jS F Y').'</b> by <b>'.$leave_data->user_firstname.' '.$leave_data->user_lastname.'</b>' ; if($leave_data->approval_one==2){echo "<br />Supervisor <b style='color:#F00'>denied</b> on ".date_format(date_create(date('Y-m-d', strtotime($leave_data->request_date))), 'l jS F Y')."";}else if($leave_data->approval_one==3&&$leave_data->approval_two==1){
			  echo "<br />Supervisor <b style='color:#090'>approved</b> the leave on <b>".date_format(date_create(date('Y-m-d', strtotime($leave_data->sup_revdate))), 'l jS F Y')."</b>,<br />waiting for HR final <b style='color:#090'>approval</b>";}else if($leave_data->approval_one==3&&$leave_data->approval_two==2){	  echo "<br />Supervisor <b style='color:#090'>approved</b> the leave on <b>".date_format(date_create(date('Y-m-d', strtotime($leave_data->sup_revdate))), 'l jS F Y')."</b>,<br />HR Office <b style='color:#F00'>denied</b> the leave request on ".date_format(date_create(date('Y-m-d', strtotime($leave_data->hr_revdate))), 'l jS F Y').""; } 
			  else if($leave_data->approval_one==3&&$leave_data->approval_two==3){
				  echo "<br />Supervisor <b style='color:#090'>approved</b> the leave on <b>".date_format(date_create(date('Y-m-d', strtotime($leave_data->hr_revdate))), 'l jS F Y')."</b>,<br />";
				  }
			  
			   ?>
        </a>
      </h4>
    </div>
    
    <div id="<?php  echo $leave_data->id; ?>" class="panel-collapse collapse">
      <div class="panel-body" style="font-size:13px">
  
   <?php  echo '<b>'.$leave_data->user_firstname.' '.$leave_data->user_lastname.'</b> Requested '. $type = $leave_data->leave_type.' Leave on '.'<b>'.date_format(date_create(date('Y-m-d', strtotime($leave_data->request_date))), 'l jS F Y').'</b>'.' starting on <b>'.date_format(date_create(date('Y-m-d H:i', strtotime($leave_data->leave_start_date))), 'l jS F Y H:i').'</b> and ending on <b>'.date_format(date_create(date('Y-m-d H:i', strtotime($leave_data->leave_end_date))), 'l jS F Y H:i').'</b>'; ?>
  <br />
   <b><small>Staff Comment</small></b><br />
   <blockquote><?php echo $leave_data->staff_comment; ?></blockquote><br />
   <b><small>Supervisor comment</small></b><br />
   <blockquote><?php echo $leave_data->supervisor_comment; ?></blockquote><br />
      <b><small>HR Office comment</small></b><br />
   <blockquote><?php echo $leave_data->hr_comment; ?></blockquote><br />
   <?php  if($leave_data->approval_one==1){ echo '   <form class="form-horizontal" action="index.php?link=leave&link2=rev_lv&request=approv_two&lv_id=' ?><?php  echo $leave_data->id; ?><?php echo '&yr='.$yr.'" method="post" role="form">
     <div class="form-group">
  <div class="col-sm-6 col-sm-offset-2">
        <label>Comment</label>
   <textarea class="form-control" rows="3" name="comment"></textarea>
    </div>
    </div>
   <div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">
      <button type="submit" class="btn btn-success" name="status" value="3">Accept</button>
       <button type="submit" class="btn btn-warning" name="status" value="2">Deny</button>
    </div>
  </div>
  
   </form>';} else echo '';?>

   <br /><b>Status</b><br />
   <?php switch($leave_data->status){case 1: echo 'Leave request final review is still Pending';break; case 2: echo 'Leave has been denied';break;default: echo 'Leave has been accepted';}  ?>
            <div id="<?php  echo $leave_data->id.'123'; ?>" class="panel-collapse collapse in">
            <br />
            <a href="index.php?request=leave_requests&usr_id=<?php echo $leave_data->user_id;  ?>&link=leave"><strong><em style="color:#F0F">View Staff leave balances</em></strong></a>
    </div>
      </div>
	 
    </div>
     
  </div>
  <?php  endforeach; ?> 
</div>