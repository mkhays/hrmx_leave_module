<div class="panel-group" id="accordion">
<legend><?php  echo $form_title;   ?></legend> 
<?php  echo $data;   ?>
  <?php foreach ($details as $leave_data => $key):?>
  <div class="panel panel-<?php switch($details[$leave_data]->status){case 1: echo 'warning';break; case 2: echo 'danger';break;default: echo 'success';}  ?>">
    <div class="panel-heading">
     
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="<?php  echo '#'.$details[$leave_data]->id; ?>">
          <?php  echo ' Out of office '.' Requested on '.' <b>'.date_format(date_create(date('Y-m-d', strtotime($details[$leave_data]->request_date))), 'l jS F Y').'</b> by <b>'.$name[$leave_data]->user_firstname.' '.$name[$leave_data]->user_lastname.'</b>' ; if($details[$leave_data]->status==2){echo "  <br />Request <b style='color:#F00'>denied</b> by Supervisor on <b>".date_format(date_create(date('Y-m-d', strtotime($details[$leave_data]->sup_revdate))), 'l jS F Y')."</b>";} 
		  else if($details[$leave_data]->status==3){echo "<br />Supervisor <b style='color:#090'>accepted</b> the out of office request on <b>".date_format(date_create(date('Y-m-d', strtotime($details[$leave_data]->sup_revdate))), 'l jS F Y')."</b>";}
		    ?>
        </a>
      </h4>
    </div>
    
    <div id="<?php  echo $details[$leave_data]->id; ?>" class="panel-collapse collapse">
      <div class="panel-body">
  
   <?php  echo $name[$leave_data]->user_firstname.' '.$name[$leave_data]->user_lastname.' requested out of office on  '.'<b>'.$details[$leave_data]->request_date.'</b>'.' starting on <b>'.$details[$leave_data]->start_date.'</b> and ending on <b>'.$details[$leave_data]->end_date.'</b>'; ?>
  <br />
   <b><small>Staff Comment</small></b><br />
   <blockquote><?php echo $details[$leave_data]->comment; ?></blockquote><br />
      <b><small>Supervisor Comment</small></b><br />
   <blockquote><?php echo $details[$leave_data]->supervisor_comment; ?></blockquote><br />
   <?php  if($details[$leave_data]->status==1){ echo '   <form class="form-horizontal" action="index.php?link=leave&link2=rev_out&request=out_reply&out_id='; ?><?php  echo $details[$leave_data]->id ?> <?php echo '" method="post" role="form">
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
   <?php switch($details[$leave_data]->status){case 1: echo 'Pending';break; case 2: echo 'Has been denied';break;default: echo 'Has been accepted';}  ?>
      </div>
	 
    </div>
     
  </div>
  <?php  endforeach; ?> 
</div>