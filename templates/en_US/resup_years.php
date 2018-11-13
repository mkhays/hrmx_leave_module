<div class="col-md-10 pull-right" role="main">
<div class="row">
  <label class="control-label"> &nbsp; &nbsp; Select year. All leave resumption requests</label><br /><br />
<div class="form-group">   
<div class="col-md-2">
<ul class="list-group">
    <?php  foreach($years as $year):  ?>
  <li class="list-group-item"><a href="index.php?request=resumption_requests&link=leave&link2=rev_res&yr_id=<?php echo $year; ?>"><?php echo $year; ?></a></li>
   <?php endforeach; ?>
</ul>
</div>
</div>
</div>
</div>

