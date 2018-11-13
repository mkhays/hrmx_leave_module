<div class="panel-group" id="accordion">
<legend><?php  echo $form_title;   ?></legend> 
<?php  echo $data;   ?>
  <?php foreach ($usr_id as $leave_data => $key):?>
  <div class="panel panel-<?php switch($status[$leave_data]){case 1: echo 'warning';break; case 2: echo 'danger';break;default: echo 'success';}  ?>">
    <div class="panel-heading">
     
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="<?php  echo '#'.$usr_id[$leave_data]; ?>">
        <?php if($days[$leave_data]>1){$day_type='days';}else {$day_type='day';}   ?>
          <?php  if($usr_id[$leave_data]){echo ' You have been requested by your supervisor to work on  <b>'.$dates[$leave_data].'</b> for a total of <b>'.$days[$leave_data].' </b> '.$day_type;}else{echo "No request";}
		    ?>
        </a>
      </h4>
    </div>
    
    <div id="<?php  echo $usr_id[$leave_data]; ?>" class="panel-collapse collapse">
      <div class="panel-body">
   <b><small>reason for request</small></b><br />
   <blockquote><?php echo $reason[$leave_data]; ?></blockquote><br />
      <b><small>your Comment</small></b><br />
   <blockquote><?php //echo $details[$leave_data]; ?></blockquote><br />
   <?php  if($status[$leave_data]==1){ echo '   <form class="form-horizontal" action="index.php?link=leave&link2=sup_req&request=xtra_reply&req_id='; ?><?php  echo $usr_id[$leave_data] ?> <?php echo '" method="post" role="form">
     <div class="form-group">
  <div class="col-sm-6 col-sm-offset-2">
        <label>Comment</label>
   <textarea class="form-control" rows="3" name="comment"></textarea>
    </div>
    </div>
	<input type="hidden" class="form-control" name="days" value=" '.$days[$leave_data].'" />
   <div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">
      <button type="submit" class="btn btn-success" name="status" value="3">Accept</button>
       <button type="submit" class="btn btn-warning" name="status" value="2">Deny</button>
    </div>
  </div>
  
   </form>';} else echo '';?>

   <br /><b>Status</b><br />
   <?php switch($status[$leave_data]){case 1: echo 'Pending';break; case 2: echo 'Has been denied';break;default: echo 'Has been accepted';}  ?>
      </div>
	 
    </div>
     
  </div>
  <?php  endforeach; ?> 
</div>