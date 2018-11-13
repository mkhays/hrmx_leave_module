<div class="panel-group" id="accordion">
<?php  echo $data;   ?>
  <?php foreach ($leave_req_det as $leave_data => $key):?>
  <div class="panel panel-<?php switch($leave_req_det[$leave_data]->status){case 1: echo 'warning';break; case 2: echo 'danger';break;default: echo 'success';}  ?>">
  <?php  switch($leave_req_det[$leave_data]->status){case 1: $hr_state = 'has not yet reviewed the leave request';break; case 2: $hr_state = '<b style="color:#F00">denied</b> the request on '.date_format(date_create(date('Y-m-d', strtotime($leave_req_det[$leave_data]->hr_revdate))), 'l jS F Y').'';break;default: $hr_state= '<b style="color:#090">accepted</b> the leave request on '.date_format(date_create(date('Y-m-d', strtotime($leave_req_det[$leave_data]->hr_revdate))), 'l jS F Y').'';}  ?>
    <div class="panel-heading">
     
      <h4 class="panel-title" style="font-size:13px">
        <a data-toggle="collapse" data-parent="#accordion" href="<?php  echo '#'.$leave_req_det[$leave_data]->id; ?>">
          <?php  echo $leave_req_det[$leave_data]->leave_type .' '.'Leave Requested on '.' <b>'.date_format(date_create(date('Y-m-d', strtotime($leave_req_det[$leave_data]->request_date))), 'l jS F Y').'</b> by <b>'.$name[$leave_data]->user_firstname.' '.$name[$leave_data]->user_lastname.'.<br /></b> Supervisor <b style="color:#090">accepted</b> on <b>'.date_format(date_create(date('Y-m-d', strtotime($leave_req_det[$leave_data]->sup_revdate))), 'l jS F Y').'</b><br /> HR Office '. $hr_state.''; ?>
        </a>
      </h4>
    </div>
    
    <div id="<?php  echo $leave_req_det[$leave_data]->id; ?>" class="panel-collapse collapse">
      <div class="panel-body" style="font-size:13px">
  
   <?php  echo 'You Requested '. $type = $leave_req_det[$leave_data]->leave_type.' Leave on '.'<b>'.$leave_req_det[$leave_data]->request_date.'</b>'.' starting on <b>'.date_format(date_create(date('Y-m-d H:i', strtotime($leave_req_det[$leave_data]->leave_start_date))), 'l jS F Y H:i').'</b> and ending on <b>'.date_format(date_create(date('Y-m-d H:i', strtotime($leave_req_det[$leave_data]->leave_end_date))), 'l jS F Y H:i').'</b>'; ?>
  <br />
   <b><small>Staff Comment</small></b><br />
   <blockquote><?php echo $leave_req_det[$leave_data]->staff_comment; ?></blockquote><br />
     <b><small>Supervisor Comment</small></b><br />
   <blockquote><?php echo $leave_req_det[$leave_data]->supervisor_comment; ?></blockquote><br />
        <b><small>HR Office comment</small></b><br />
   <blockquote><?php echo $leave_req_det[$leave_data]->hr_comment; ?></blockquote><br />
   <?php  if($leave_req_det[$leave_data]->status==1){ echo '   <form class="form-horizontal" action="index.php?request=approv_two&lv_id='; ?><?php  echo $leave_req_det[$leave_data]->id ?> <?php echo '" method="post" role="form">
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
   <?php switch($leave_req_det[$leave_data]->status){case 1: echo 'Pending';break; case 2: echo 'Has been denied';break;default: echo 'Has been accepted';}  ?>
      </div>
	 
    </div>
     
  </div>
  <?php  endforeach; ?> 
</div>