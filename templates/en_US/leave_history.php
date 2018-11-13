<div class="panel panel-info">
  <!-- Default panel contents -->
  <div class="panel-heading"><h4>History and Balance days</h4>&nbsp;<?php  echo $name1;  ?></div>
  <div class="panel-body">

 
<?php if(!$leave_data){echo "There is no leave activity yet !";}else { foreach ($leave_data as $leave_data):?>
<ul class="list-group">
  <li class="list-group-item success"><?php echo 'You requested '.$leave_data->leave_type.' leave on <b><i>'.$leave_data->request_date.'</i></b>         feedback: ';  ?><?php switch($leave_data->status){case 1: echo 'request <b><i>Pending</i></b>';break; case 2: echo 'request <b><i>denied</i></b>';break;default: echo 'request <b><i>accepted</i></b>';}  ?></li>
  </ul>
  <?php  endforeach;  } ?>

  </div>
  <!-- Table -->
  <?php     foreach($days as $day):               ?>
  <table class="table">
			<!--we create here table heading-->
				<thead>
					<tr>
                    <tr><h5><b>&nbsp;&nbsp;Balance Leave Days</b></h5></tr>
						<th><h6 align="center"><b>Annual</b></h6></th>  
						<th><h6 align="center"><b>Sick</b></h6></th>
						<th><h6 align="center"><b>Paternity</b></h6></th>
                        <th><h6 align="center"><b>maternity</b></h6></th>
						<th><h6 align="center"><b>Compassionate</b></h6></th>
                        <th><h6 align="center"><b>Compensatory</b></h6></th>
						 <th><h6 align="center"><b>Carry over</b></h6></th>
						  <th><h6 align="center"><b>Leave Loan</b></h6></th>
					</tr>
				</thead>
                <tbody>
				
				 <tr align="center" bgcolor="#CCFF99">
			     <td><?php  echo round($day->annual_leave.' '.'days',4);   ?></td>
                 <td><?php  echo round($day->sick_leave.' '.'days',4);   ?></td>
                 <td><?php  echo round($day->paternity_leave.' '.'days',4);   ?></td>
                 <td><?php  echo round($day->maternity_leave.' '.'days',4);   ?></td>
                 <td><?php  echo round($day->compassionate_leave.' '.'days',4);   ?></td>
				<td><?php  echo round($day->compensatory_leave.' '.'days',4);   ?></td>	
                <td><?php  echo round($day->carryover_leave.' '.'days',4);   ?></td>	
                <td><?php  echo round($day->loan_leave.' '.'days',4);   ?></td>				
 
					</tr>
					</tbody>

			</table> 
              <!-- <table class="table"> -->
			<!--we create here table heading-->
				<!--<thead>
					<tr>
                    <tr><h6><b>&nbsp;&nbsp;Leave days taken</b><p class="help-block">NOTE: Annual leave days taken are computed basing on standard 21 days a year in relation to the days achieved in each month</p>
</h6></tr>
						<th><h6 align="center"><b>Annual</b></h6></th>  
						<th><h6 align="center"><b>Sick</b></h6></th>
						<th><h6 align="center"><b>Paternity</b></h6></th>
                        <th><h6 align="center"><b>maternity</b></h6></th>
						<th><h6 align="center"><b>Compassionate</b></h6></th>
                        <th><h6 align="center"><b>Compensatory</b></h6></th>
						 <th><h6 align="center"><b>Carry over</b></h6></th>
					</tr>
				</thead>
                <tbody>
				
				 <tr align="center" style="background-color:#CFC">
			     <td><?php // echo $days_taken_annual; ?></td>
                 <td><?php // echo round(44-$day->sick_leave.' '.'days',4);   ?></td>
                 <td><?php // echo round(4-$day->paternity_leave.' '.'days',4);   ?></td>
                 <td><?php // echo round(60-$day->maternity_leave.' '.'days',4);   ?></td>
                 <td><?php // echo round(6-$day->compassionate_leave.' '.'days',4);   ?></td>
				 <td><?php // echo round($sum.' '.'days',4);   ?></td>	
                 <td><?php  //echo round($carry-$day->carryover_leave.' '.'days',4);   ?></td>
					</tr>
					</tbody>

			</table> -->
          <?php  endforeach;   ?>
</div>