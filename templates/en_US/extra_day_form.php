<?php echo $data; ?>
<form class="form-horizontal" action="index.php?request=xtra_day_request&link2=req_day" method="post" role="form">
 <legend><?php  echo $form_title;   ?></legend> 
     <div class="form-group">
     
     <!--Leave type -->
  
     <div class="col-sm-6 col-sm-offset-2">
     <label>Days</label>
  <input type='text' class="form-control" name="days" id="from-input" required="required"/>
    </div>
  </div> 
  <div class="form-group">
  <div class="col-sm-6 col-sm-offset-2">
  <label>choose staff to call</label>
  <select class="form-control" id="chosen-select" multiple="multiple" name="usrid[]" required="required">
    <option></option>
  <?php foreach($usr_id as $users => $key):  ?> 
  <?php $sup_id = $usr_id[$users]; ?>
  <option value="<?php echo $sup_id; ?>"><?php echo $f_name[$users]. ' ' .$l_name[$users]; ?></option>
  <?php   endforeach;   ?>
</select>

    </div>
  </div> 
  
   <div class="form-group">
  <div class="col-sm-6 col-sm-offset-2">
        <label>Reason</label>
   <textarea class="form-control" rows="3" name="reason" required="required"></textarea>
   <p class="help-block">Give reason for requesting staff to an extra day.</p>
    </div>
  </div>

  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">
      <button type="submit" class="btn btn-primary">Request</button>
    </div>
  </div>
</form>