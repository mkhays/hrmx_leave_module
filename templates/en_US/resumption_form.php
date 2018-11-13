<?php echo $data; ?>
<form class="form-horizontal" action="index.php?request=leave_resumption" method="post" role="form">
 <legend><?php  echo $form_title;   ?></legend> 
    <div class="form-group">
    <div class="col-md-1 col-sm-offset-2">
<input type="checkbox" class="form-control" name="leave_check" id="checkboxOne" />
</div> <div class="col-md-4">
  <label>check for leave record resumption request</label>
  </div></div>
     <div class="form-group">
     
     <!--Leave type -->
  
     <div class="col-sm-7 col-sm-offset-2">
     <label>Choose leave record</label>
  <select class="form-control" name="leave_id" multiple="multiple" required="required" id="leave_id2" disabled="disabled">
  <?php foreach($leave_type as $record => $key):   ?>
  <?php if($leav_id[$record]!=""){$msg ='<blockquote>'.$leave_type[$record].' leave requested, from <b>'.$start[$record].'</b>, to '.$end[$record].' for '.$days[$record].' days</blockquote>'; }else{ $msg=""; }   ?>
  <option value="<?php echo $leav_id[$record];  ?>"><?php echo $msg; ?></option>
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
           <label>Dates recalled from leave <br />From</label>
                <div class='input-group date' id='datetimepicker1'>
                    <input type='text' class="form-control" name="date1" id="from" disabled="disabled" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
        </div></div> 
        <div class="col-md-3">
          <!--Leave End date -->
           <label><br />To</label>
                <div class='input-group date' id='datetimepicker2'>
                    <input type='text' class="form-control" id="to" name="date2" disabled="disabled" />
                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                    </span>
    
        </div></div> </div>
         <!--  <div class="form-group"> -->
  <!--number of leave dats -->
  <!--  <div class="col-sm-2 col-sm-offset-2">
        <label>Number of Leave days</label>
      <input type="text" class="form-control" name="days">
    </div>
  </div> -->
    <div class="form-group">
    <div class="col-md-6 col-sm-offset-2">----------------------------------------------------------------------------</div></div>
    <div class="form-group">
    <div class="col-md-1 col-sm-offset-2">
<input type="checkbox" class="form-control" name="pub_check"  id="checkboxTwo"/>
</div> <div class="col-md-5">
  <label>check for unschedules public holidays while on leave resumption request</label>
  </div></div>
  <div class="form-group">
  <div class="col-sm-6 col-sm-offset-2">
  <label>Unscheduled Public Holiday(s) while on leave </label>
  <textarea class="form-control" rows="2" name="pub_hol" id="pub_hol3" disabled="disabled" required="required"></textarea>

    </div>
  </div> 
   <div class="form-group">
  <div class="col-sm-3 col-sm-offset-2">
      <!--Leave start date -->
           <label>Number of public holidays</label>
                    <select class="form-control" name="days" id="day" required="required" disabled="disabled" >
                    <option></option>
                    <?php for($a = 1; $a<3; $a++){   ?>
                    <option><?php echo $a; ?></option>
                    <?php  } ?>
                    </select>
        </div></div>
   <div class="form-group">
  <div class="col-sm-6 col-sm-offset-2">
        <label>Comment / Reason for being recalled</label>
   <textarea class="form-control" rows="3" name="comment" id="comt" required="required" disabled="disabled"></textarea>
    </div>
  </div>

  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">
      <button type="submit" class="btn btn-primary" id="btn3" disabled="disabled">Submit</button>
    </div>
  </div>
</form>