<?php echo $data; ?>
<form class="form-horizontal" action="index.php?request=leave_request&link2=lv_f" method="post" role="form">
 <legend><?php  echo $form_title;   ?></legend> 
     <div class="form-group">
     
     <!--Leave type -->
  
     <div class="col-sm-6 col-sm-offset-2">
     <label>Leave Type</label>
  <select class="form-control" id="chosen-select1" name="leave_type"   required="required" >
  <option></option>
  <option>sick</option>
  <option>maternity</option>
   <option>paternity</option>
  <option>annual</option>
  <option>compassionate</option>
  <option>compensatory</option>
  <option>carryover</option>
    <option>annual leave loan</option>
</select>
    </div>
  </div> 
  <div class="form-group">
  </div>

    <div class="form-group">
    <div class="col-md-3 col-sm-offset-2">
      <!--Leave start date -->
           <label>Leave Start Date</label>
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' class="form-control" name="leave_date1" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
        </div></div>
        <div class="col-md-3">
          <!--Leave End date -->
           <label>Leave End Date</label>
                <div class='input-group date' id='datetimepicker2'>
                    <input type='text' class="form-control" name="leave_date2" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
    
        </div></div> </div>
        <div></div>
         <!--  <div class="form-group"> -->
  <!--number of leave dats -->
  <!--  <div class="col-sm-2 col-sm-offset-2">
        <label>Number of Leave days</label>
      <input type="text" class="form-control" name="days">
    </div>
  </div> -->
  <div class="form-group">
  <div class="col-sm-6 col-sm-offset-2">
  <label>Delegate</label>
  <select class="form-control" id="chosen-select" name="in_charge">
  <option value="1">Choose incharge staff....</option>
  <?php foreach($staff as $users):  ?> 
  <?php $sup_id = $users->user_id; ?>
  <option value="<?php echo $sup_id; ?>"><?php echo $users->user_firstname . ' ' .$users->user_lastname; ?></option>
  <?php   endforeach;   ?>
</select>

    </div>
  </div> 
  
   <div class="form-group">
  <div class="col-sm-6 col-sm-offset-2">
        <label>Comment</label>
   <textarea class="form-control" rows="3" name="comment"></textarea>
   <p class="help-block">Give reason for taking leave, Name of person responsible for your duties, any other Telephone contact in case of any emergency while you are away.</p>
    </div>
  </div>

  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
</form>