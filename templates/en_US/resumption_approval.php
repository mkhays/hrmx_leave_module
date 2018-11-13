<div class="panel-group" id="accordion">
<?php  echo $data;  ?>
  <?php foreach ($record_id as $leave_data => $key):?>
  <div class="panel panel-<?php switch($status[$leave_data]){case 1: echo 'warning';break; case 2: echo 'danger';break;default: echo 'success';}  ?>">
    <div class="panel-heading">
     
      <h4 class="panel-title" style="font-size:14px">
        <a data-toggle="collapse" data-parent="#accordion" href="<?php  echo '#'.$record_id[$leave_data]; ?>">
          <?php if($days[$leave_data]>1){$day_type= 'days';}else { $day_type='day';}  echo $firstname[$leave_data].' '.$lastname[$leave_data].' requested a total of '.$days[$leave_data].' '.$day_type.' as a claim for the days missed during '.$leave[$leave_data].' leave from '.date_format(date_create(date('Y-m-d', strtotime($leave_start_date[$leave_data]))), 'l jS F Y').' to '.date_format(date_create(date('Y-m-d', strtotime($leave_end_date[$leave_data]))), 'l jS F Y') ; 
			  
			   ?>
        </a>
      </h4>
    </div>
    
    <div id="<?php  echo $record_id[$leave_data]; ?>" class="panel-collapse collapse">
      <div class="panel-body" style="font-size:13px">
    <b>Total Days recalled</b><br />
   <blockquote><?php echo $days[$leave_data]; ?></blockquote><br />
     <b>Public holidays while on leave</b><br />
   <blockquote><?php echo $pub_hol[$leave_data]; ?></blockquote><br />
   <b><small>Staff Comment</small></b><br />
   <blockquote><?php echo $comment[$leave_data]; ?></blockquote><br />
   <b><small>Supervisor comment</small></b><br />
   <blockquote><?php echo $sup_comment[$leave_data]; ?></blockquote><br />
   <?php  if($status[$leave_data]==1){ echo '   <form class="form-horizontal" action="index.php?link=leave&link2=rev_res&request=review_resup&lv_id='; ?><?php  echo $record_id[$leave_data] ?> <?php echo '" method="post" role="form">
     <div class="form-group">
  <div class="col-sm-6 col-sm-offset-2">
        <label>Comment</label>
   <textarea class="form-control" rows="3" name="comment"></textarea>
    </div>
    </div>
	<input type="hidden" class="form-control" name="days" value=" '.$days[$leave_data].'" />
	<input type="hidden" class="form-control" name="leave_type" value=" '.$leave[$leave_data].'" />
   <div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">
      <button type="submit" class="btn btn-success" name="status" value="3">Accept</button>
       <button type="submit" class="btn btn-warning" name="status" value="2">Deny</button>
    </div>
  </div>
  
   </form>';} else echo '';?>

   <br /><b>Status</b><br />
   <?php switch($status[$leave_data]){case 1: echo 'Leave request final review is still Pending';break; case 2: echo 'Leave has been denied';break;default: echo 'Leave has been accepted';}  ?>
            <div id="<?php  echo $status[$leave_data].'123'; ?>" class="panel-collapse collapse in">
            <br />
    </div>
      </div>
	 
    </div>
     
  </div>
  <?php  endforeach; ?> 
</div>