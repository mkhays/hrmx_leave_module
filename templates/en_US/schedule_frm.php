<?php echo $data; ?>
<form class="form-horizontal" action="index.php?request=add_schedule&link=leave&link2=sc_f" method="post" role="form">
 <legend><i class="fa fa-calendar"></i> <?php  echo $form_title;   ?></legend> 
 <span id="helpBlock" class="help-block">Please select your planned leave days for year <?php  echo date('Y'); ?>.</span>
   <div class="form-group">
       <div class="col-sm-6 col-sm-offset-1">
    <textarea type='text' class="form-control" name="days" id="altField" size="30" rows="5" required="required" ></textarea>
    </div><button type="submit" class="btn btn-primary" >Submit</button>
    </div>
  <div class="col-sm-8">
  <div id="schedule"> </div>
  </div>
  </div>
 </form>