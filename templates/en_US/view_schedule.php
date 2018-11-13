<?php echo $data; ?>
<form class="form-horizontal" action="index.php?request=update_schedule&link=leave&link2=sc_f>" method="post" role="form">
 <legend><i class="fa fa-calendar"></i> <?php  echo "My Leave Schedule";   ?></legend> 
  <?php if($status==2) {  ?>
  <span>The leave schedule was reviewed and <span class="label label-danger">denied</span> on <?php echo $sup_update_date;  ?> the by supervisor</span><br />
 <br />
 <div class="form-group">
     <div class="col-sm-6 col-sm-offset-1">
       
    <textarea type='text' class="form-control" name="days" id="altField3" size="30" required="required"></textarea>
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
    </div><button type="submit" class="btn btn-primary" name="status" value="3">Update</button>
    </div>
     <?php  }else { if($status==3){ $ms = 'The leave schedule was reviewed and <span class="label label-success">approved</span> on '.$sup_update_date.' by supervisor'; }else { $ms = '<span class="label label-warning">pending !</span>'; }
			  echo 'The leave schedule is still '.$ms.'<br />'; 
			} ?>
            <br />
  <div class="col-sm-8">
  <div id="schedule3" style="width:100px;"> </div>
  </div>

 </form>