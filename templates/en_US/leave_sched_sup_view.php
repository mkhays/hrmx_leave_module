<?php echo $data; ?>
<form class="form-horizontal" action="index.php?request=review_schedule&link=leave&link2=v_stf&id=<?php echo $staff_id;  ?>" method="post" role="form">
 <legend> <i class="fa fa-calendar"></i> leave Schedule  </legend> 
 

     <div class="form-group">
        <div class="col-sm-7 col-sm-offset-1">
          <?php echo $name. ' <span style="color:#09C">leave schedule</span>';  ?><br /><br />
          <?php if($status==1) {  ?>
        <label>Comment</label>
        <textarea name="comment" required></textarea>
        <input type="hidden" value="<?php echo $id; ?>" name="id"> 
        
    </div>
    </div>
    <div class="form-group">
    <div class="col-sm-offset-2 col-sm-7">
       <button type="submit" class="btn btn-success" name="status" value="3">Approve</button>
       <button type="submit" class="btn btn-danger" name="status" value="2">Deny</button>
       <?php  }else { if($status==3){ $ms = '<span class="label label-success">approved</span>'; }else { $ms = '<span class="label label-danger">denied</span>'; }
			echo 'The leave schedule was reviewed and '.$ms.' on '.$sup_update_date.' by supervisor'; 
			} ?>
    </div>
    
  </div>
   <div class="form-group">
  <div class="col-sm-8">
  <div id="schedule3" style="width:100px;"> </div>
  </div>

 </form>