<legend><?php  echo $form_title;   ?></legend>
<table class="table table-condensed table-bordered">
    <thead>
        <tr>
            <th>Staff Id Number</th>
            <th>Name</th>
            <th>Position</th>
        </tr>
    </thead>
    <tbody>
    <?php  foreach($name as $nam => $key):  ?>
        <tr>
            <td><?php  echo $user_no[$nam]; ?></td>
            <td><a href="index.php?link2=v_stf&request=staff_details&id=<?php echo $staff_id[$nam];  ?>&link=leave"><?php   echo $name[$nam];   ?></a></td>
            <td><?php  echo $position[$nam];  ?></td>
        </tr>
<?php  endforeach;  ?>
    </tbody>
</table>