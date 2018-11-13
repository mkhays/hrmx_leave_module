<?php echo $data; ?>
<form class="form-horizontal" action="index.php?request=out_of_office_request&link2=out_f" method="post" role="form">
      <legend><?php  echo $main_title;   ?></legend> 
     <!--Leave type -->
    <div class="form-group">
    <div class="col-md-3 col-sm-offset-2">
      <!--Leave start date -->
           <label>From</label>
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' class="form-control" name="date1" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
        </div></div> 
        <div class="col-md-3">
          <!--Leave End date -->
           <label>To</label>
                <div class='input-group date' id='datetimepicker2'>
                    <input type='text' class="form-control" name="date2" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
    
        </div></div> </div>
         
  <!--number of leave dats
    <div class="form-group">
    <div class="col-sm-2 col-sm-offset-2">
        <label>Number of days</label>
      <input type="text" class="form-control" name="days">
    </div>
  </div>  -->
  
       <div class="form-group">
     
     <!--Leave type -->
  
     <div class="col-sm-6 col-sm-offset-2">
     <label>Person in charge</label>
      
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
    <p class="help-block">Give Purpose of the trip whether work related or not, Name of person responsible for subordinate's duties, Telphone contact or email contact in case of any emergency while you are away.</p> 
    </div>
  </div>

     
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">
      <button type="submit" name="out" class="btn btn-primary">Submit</button>
    </div>
  </div>
</form>