<?php  echo $data;    ?>
<table class="table table-striped" >
    <thead>
        <tr>
            <th>Name</th>
            <th>leave type</th>
            <th>start date</th>
            <th>end date</th>
             <th>days</th>
             <th>action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($days as $d => $key):   ?>
        <tr>
            <td><?php echo  $f_name[$d].' '.$l_name[$d];  ?></td>
            <td><?php echo $leave_type[$d];  ?></td>
            <td><?php echo  $start[$d];  ?></td>
             <td><?php echo  $end[$d];  ?></td>
              <td><?php echo  $days[$d];  ?></td>
              <td>
              <?php if($res[$d]==1){ ?>
              <form method="post" action="index.php?request=duty_res_review&link=leave&link2=d_res">
              <textarea name="comment" placeholder="WRITE COMMENT" required></textarea><br />
              <input name="id" value="<?php echo $id[$d]; ?>" hidden="true">
              <button type="submit" name="approve" class="btn btn-success btn-sm" >approve</button>
              <button type="submit" name="deny" class="btn btn-danger btn-sm" >deny</button>
              </form>
              <?php  } else if($res[$d]==2) {
				  echo "denied";
				  } else if($res[$d]==3){
					  echo "approved";
					  }    ?>
              
              </td>
        </tr>
        <?php  endforeach;  ?>
    </tbody>
</table>