<?php echo $data; ?>
<form class="form-horizontal" action="index.php?request=leave_resumption2" method="post" role="form">
 <legend><?php  echo $form_title;   ?></legend> 
    <div class="form-group">
     <div class="form-group">
     
     <!--Leave type -->
  
     <div class="col-sm-7 col-sm-offset-2">
     <label>Choose leave record</label>
  <select class="form-control" name="leave_id" size="5" required="required">
  <?php foreach($leave_type as $record => $key):  
  if($resumed[$record]==1){
	  $color = "#F90";
	  $disabled = 'disabled="disabled"';
	  }else if($resumed[$record]==3){
		   $color = "#0C0"; 
		   $disabled = 'disabled="disabled"';
		  } else if($resumed[$record]==2){
			   $color = "#F00"; 
		   $disabled = "";
			  }else{
		   $color = "#666"; 
		   $disabled = "";
				  }
  
   ?>
  <?php if($leav_id[$record]!=""){$msg =$leave_type[$record]." leave requested, from <b>".$start[$record]."</b>, to ".$end[$record]." for ".$days[$record]." days"; }else{ $msg=""; }   ?>
  <option value="<?php echo $leav_id[$record];  ?>" style="color:<?php echo $color;  ?>" <?php echo $disabled;  ?>>
  
<?php echo $msg; ?></option>
<?php endforeach;  ?>
</select>
    </div>
  </div> 
  <div class="form-group">
  </div>
      <!--Leave type -->
    <div class="form-group">
    <div class="col-md-3 col-sm-offset-2">
      <!--Leave start date -->
           <label>Dates returned to work</label>
                <div class='input-group date' id='datetimepicker5'>
                    <input type='text' class="form-control" name="date1" required="required" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
        </div></div>  </div>

   <div class="form-group">
  <div class="col-sm-6 col-sm-offset-2">
        <label>Comment</label>
   <textarea class="form-control" rows="3" name="comment"></textarea>
    </div>
  </div>

  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">
      <button type="submit" class="btn btn-primary" id="btn3" >Submit</button>
    </div>
  </div>
</form>