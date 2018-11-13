<div class="panel-group" id="accordion">
<legend><?php  echo $form_title;   ?></legend> 
  <?php foreach ($out_data as $out_data):?>

  <div class="panel panel-<?php switch($out_data->status){case 1: echo 'warning';break; case 2: echo 'danger';break;default: echo 'success';}  ?>">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="<?php  echo '#'.$out_data->id; ?>">
          <?php  echo 'Out of office requested on '.' <b>'.date_format(date_create(date('Y-m-d', strtotime($out_data->request_date))), 'l jS F Y').'</b>'; if($out_data->status==1){echo "<br />Waiting for Supervisor's approval";} else if($out_data->status==2){echo "<br />Supervisor <b style='color:#F00'>denied</b> the request on <b>".date_format(date_create(date('Y-m-d', strtotime($out_data->sup_revdate))), 'l jS F Y')."</b>";} else if($out_data->status==3){echo "<br />Supervisor <b style='color:#090'>Accepted</b> the out of office request on <b>".date_format(date_create(date('Y-m-d', strtotime($out_data->sup_revdate))), 'l jS F Y')."</b>";} ?>
        </a>
      </h4>
    </div>
    
    <div id="<?php  echo $out_data->id; ?>" class="panel-collapse collapse">
      <div class="panel-body">
  
   <?php  echo 'You Requested out of office on '.'<b>'.$out_data->request_date.'</b>'.' starting on <b>'.$out_data->start_date.'</b> and ending on <b>'.$out_data->end_date.'</b>'; ?>
  <br />
   <b>Your Comment</b><br />
   <blockquote><?php echo $out_data->comment; ?></blockquote><br />
    <b>Supervisor Comment</b><br />
   <blockquote><?php echo $out_data->supervisor_comment; ?></blockquote><br />
   <br /><b>Status</b><br />
   <?php switch($out_data->status){case 1: echo 'Pending';break; case 2: echo 'Denied';break;default: echo 'Accepted';}  ?>
      </div>
	 
    </div>
     
  </div>
  <?php  endforeach; ?> 
</div>