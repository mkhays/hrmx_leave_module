<div class="panel-group" id="accordion">
<legend><?php  echo $form_title;   ?></legend> 
  <?php foreach ($leave_data as $leave_data):?>
  <div class="panel panel-<?php switch($leave_data->status){case 1: echo 'warning';break; case 2: echo 'danger';break;default: echo 'success';}  ?>">
    <div class="panel-heading">
      <h4 class="panel-title" style="font-size:14px">
        <a data-toggle="collapse" data-parent="#accordion" href="<?php  echo '#'.$leave_data->id; ?>">
          <?php  echo $leave_data->leave_type .' '.'Leave Requested on '.' <b>'.date_format(date_create(date('Y-m-d', strtotime($leave_data->request_date))), 'l jS F Y').'</b>'; if($leave_data->approval_one==1){echo "<br />Waiting for Supervisor's review";}else if($leave_data->approval_two==1&&$leave_data->approval_one==3){ echo ' <br />Supervisor <b style="color:#090">Accepted</b> the leave request on '.date_format(date_create(date('Y-m-d', strtotime($leave_data->sup_revdate))), 'l jS F Y').',<br />Waiting for HR office review';}else if($leave_data->approval_one==2){echo '  <br />Supervisor <b style="color:#F00">denied</b> the request on '.date_format(date_create(date('Y-m-d', strtotime($leave_data->sup_revdate))), 'l jS F Y').'';}else if($leave_data->approval_one==3&&$leave_data->approval_two==2){ echo ' <br />Supervisor <b style="color:#090">Accepted</b> the leave request on '.date_format(date_create(date('Y-m-d', strtotime($leave_data->sup_revdate))), 'l jS F Y').',<br />HR Office <b style="color:#F00">denied</b> the leave request on '.date_format(date_create(date('Y-m-d', strtotime($leave_data->hr_revdate))), 'l jS F Y').'';} 
	else if($leave_data->approval_one==3&&$leave_data->approval_two==3){ echo ' <br />Supervisor <b style="color:#090">Accepted</b> the leave request on '.$leave_data->sup_revdate.',<br />HR Office finally <b style="color:#090">accepted</b> the leave request on '.date_format(date_create(date('Y-m-d', strtotime($leave_data->hr_revdate))), 'l jS F Y').'';} 	  
		  ?>
        </a>
      </h4>
    </div>
    
    <div id="<?php  echo $leave_data->id; ?>" class="panel-collapse collapse">
      <div class="panel-body" style="font-size:13px">
  
   <?php  echo 'You Requested '. $leave_data->leave_type.' Leave on '.'<b>'.date_format(date_create(date('Y-m-d', strtotime($leave_data->request_date))), 'l jS F Y').'</b>'.' starting on <b>'.date_format(date_create(date('Y-m-d H:i', strtotime($leave_data->leave_start_date))), 'l jS F Y H:i').'</b> and ending on <b>'.date_format(date_create(date('Y-m-d H:i', strtotime($leave_data->leave_end_date))), 'l jS F Y H:i').'</b>'; ?>
  <br />
   <b>Your Comment</b><br />
   <blockquote><?php echo $leave_data->staff_comment; ?></blockquote><br />
    <b>Supervisor Comment</b><br />
   <blockquote><?php echo $leave_data->supervisor_comment; ?></blockquote><br />
   <b>HR Office Comment</b><br />
   <blockquote><?php echo $leave_data->hr_comment; ?></blockquote><br />
   <br /><b>Status</b><br />
   <?php switch($leave_data->status){case 1: echo 'Pending';break; case 2: echo 'Denied';break;default: echo 'Accepted';}  ?>
      </div>
	 
    </div>
     
  </div>
  <?php  endforeach; ?> 
</div>