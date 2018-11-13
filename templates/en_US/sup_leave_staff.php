<div class="col-md-10 " role="main">

<div class="table-responsive">
<legend style="font-size:14px"><b>Registered staff</b> <p class="help-block">Note: Registered staff are staff who have been assigned thier correponding supervisors.</p></legend>
<table cellpadding="0" cellspacing="0" border="0" class="display table table-stripped" id="example">
<thead>
       <th colspan="6"><span style="text-align:center">Staff leave balances</span></th>
</thead>
	<thead>

		<tr style="font-size:13px">
			<th>Name</th>
			<th>Annual leave</th>
			<th>Sick leave</th>
			<th>Compasionate</th>
            	<th>Compensatory</th>
                	<th>Carry over</th>
                    <th>Leave schedule</th>
		</tr>
	</thead>
	<tbody>
<?php  foreach ($staff_name as $nams => $key):  ?>
		<tr style="font-size:12px">
			<td><?php  echo  $staff_name[$nams];  ?></td>
			<td><?php  echo  $staff_annual[$nams];  ?></td>
			<td><?php  echo  $staff_sick[$nams];    ?></td>
			<td><?php  echo  $compasionate[$nams];   ?></td>
            <td><?php  echo  $compes[$nams];   ?></td>
            <td><?php  echo  $carry[$nams];   ?></td>
              <td><?php  echo  $carry[$nams];   ?></td>
		</tr>
		<?php endforeach; ?>

	</tbody>
</table>
<legend style="font-size:14px"><p class="help-block">LEAVE SCHEDULE</p></legend>
<table cellpadding="0" cellspacing="0" border="0" class="display table table-stripped" id="example">
<thead>
       <th colspan="6"><span style="text-align:center">Staff leave schedules</span></th>
</thead>
	<thead>

		<tr style="font-size:13px">
			<th>Name</th>
            <th>Status</th>
            <th>Action</th>
		</tr>
	</thead>
	<tbody>
<?php  foreach ($staff_sched as $s_sch):  ?>
		<tr style="font-size:12px">
			<td><?php  echo  $s_sch->user_firstname.' '.$s_sch->user_lastname;  ?></td>
			<td><?php  if(empty($s_sch->sched_id)){ echo '<span class="label label-warning">not submited</span>'; }else{ echo '<span class="label label-success">submited</span>'; }  ?></td>
              <td><?php  if(empty($s_sch->sched_id)){ echo '<span class="label label-warning">not submited</span>'; }else{ echo '<a type="button" class="btn btn-primary btn-xs" href="index.php?request=staff_leave_schedule&link=leave&link2=v_stf&id='.$s_sch->user_id.'">View Schedule</a>';  }  ?></td>
		</tr>
		<?php endforeach; ?>

	</tbody>
</table>
</div></div></div>		
