<div class="panel-group" id="accordion">
<legend><?php  echo $form_title;   ?></legend> 
  <?php foreach ($leave_type as $leave_resup => $key):?>
  <div class="panel panel-<?php switch($status[$leave_resup]){case 1: echo 'warning';break; case 2: echo 'danger';break;default: echo 'success';}  ?>">
    <div class="panel-heading">
      <h4 class="panel-title" style="font-size:14px">
        <a data-toggle="collapse" data-parent="#accordion" href="<?php echo '#'.$id2[$leave_resup];   ?>">
        
  <?php if($days[$leave_resup]>1){$day_type= 'days';}else { $day_type='day';}  
  echo 'You requested for a total of '. $days[$leave_resup].' '.$day_type.' on 
  '.date_format(date_create(date('Y-m-d', strtotime($date1[$leave_resup]))), 'l jS F Y').' as a claim for the days missed during '.$leav_types[$leave_resup].' leave you started from '.date_format(date_create(date('Y-m-d', strtotime($leav_start[$leave_resup]))), 'l jS F Y').' to '.date_format(date_create(date('Y-m-d', strtotime($leav_end[$leave_resup]))), 'l jS F Y') ;
		  ?>
        </a>
      </h4>
    </div>
    
    <div id="<?php echo $id2[$leave_resup];   ?>" class="panel-collapse collapse">
      <div class="panel-body" style="font-size:13px">
        <b>Total Days recalled</b><br />
   <blockquote><?php echo $days[$leave_resup]; ?></blockquote><br />
     <b>Public holidays while on leave</b><br />
   <blockquote><?php echo $public_holiday[$leave_resup]; ?></blockquote><br />
   <b>Your Comment</b><br />
   <blockquote><?php echo $comment[$leave_resup]; ?></blockquote><br />
    <b>Supervisor Comment</b><br />
   <blockquote><?php echo $sup_comment[$leave_resup]; ?></blockquote><br />
   <br /><b>Status</b><br />
   <?php switch($status[$leave_resup]){case 1: echo 'Pending';break; case 2: echo 'Denied';break;default: echo 'Accepted';}  ?>
      </div>
	 
    </div>
     
  </div>
  <?php  endforeach; ?> 
</div>