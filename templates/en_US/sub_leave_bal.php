
<div class="panel panel-info">
  <!-- Default panel contents -->
  <div class="panel-heading"><h4>History and Balance days</h4></div>
  <div class="panel-body">

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
					</tr>
				</thead>
                <tbody>
				
				 <tr align="center" bgcolor="#CCFF99">
			     <td><?php  echo round($day->annual_leave.' '.'days',4);   ?></td>
                 <td><?php  echo round($day->sick_leave.' '.'days',4);   ?></td>
                 <td><?php  echo round($day->paternity_leave.' '.'days',4);   ?></td>
                 <td><?php  echo round($day->maternity_leave.' '.'days',4);   ?></td>
                 <td><?php  echo round($day->compassionate_leave.' '.'days',4);   ?></td>
						
 
					</tr>
					</tbody>

			</table> 
              <table class="table">
			<!--we create here table heading-->
				<thead>
					<tr>
                    <tr><h6><b>&nbsp;&nbsp;Leave days taken</b></h6></tr>
						<th><h6 align="center"><b>Annual</b></h6></th>  
						<th><h6 align="center"><b>Sick</b></h6></th>
						<th><h6 align="center"><b>Paternity</b></h6></th>
                        <th><h6 align="center"><b>maternity</b></h6></th>
						<th><h6 align="center"><b>Compassionate</b></h6></th>
					</tr>
				</thead>
                <tbody>
				
				 <tr align="center" style="background-color:#CFC">
			     <td><?php   if($day->days_taken==null){ $days1 = '0'; 
				   echo  $days1.' days';
				  } else {
					echo $day->days_taken.' days';
					 }   ?></td>
                 <td><?php  echo round(60-$day->sick_leave.' '.'days',4);   ?></td>
                 <td><?php  echo round(4-$day->paternity_leave.' '.'days',4);   ?></td>
                 <td><?php  echo round(60-$day->maternity_leave.' '.'days',4);   ?></td>
                 <td><?php  echo round(15-$day->compassionate_leave.' '.'days',4);   ?></td>
						
 
					</tr>
					</tbody>

			</table>
          <?php  endforeach;   ?>
</div>