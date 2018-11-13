<?php
require_once('./includes/config.php');
require('./logic/data_client.php');
require('./logic/db.php');
require('./scripts/date_manager.php');
require('./includes/constants.php');

class logic_processor{
	private $data_client;
	private $date_manager;
	private $hrm_mysql_connect;
	public function __construct(){
		$this->data_client = new data_client();
		$this->date_manager = new date_manager();
		$this->db = new db();
		$this->hrm_mysql_connect = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
		}

	public function leave_request($user_ids, $leave_type, $request_date, $leave_start_date1, $leave_end_date1, $status, $approve_one, $approve_two, $staff_comment, $incharge, $sup_id){
		$leave_type1 = $leave_type."_leave";
		$date_one = new DateTime($leave_start_date1);
		$date_two = new DateTime($leave_end_date1);
		$date_1 = $date_one->format('m/d/Y');
		$date_2 = $date_two->format('m/d/Y');
		
		$t1 = $date_one->format('H:i');
		$t2 = $date_two->format('H:i');
		if($leave_start_date1==$leave_end_date1){
		$no_days = $this->get_dates($leave_start_date1,$leave_end_date1);
		$pub_hols = $this->pub_hol();
		$real_days = array_diff($no_days, $pub_hols);
		$days_num = count($real_days);
		
			}elseif(($date_1==$date_2)&&($t1!=$t2)){
			$hrs = strtotime($t2)-strtotime($t1);
		    $days_num = ($hrs/3600)/8;		
				}else{
		$date1 = new DateTime(date_format($date_one, 'Y-m-d'));
	    $date2 = new DateTime(date_format($date_two, 'Y-m-d'));
		$hrs = strtotime($t2)-strtotime($t1);
		$hr_days = ($hrs/3600)/8;
		//$day = 	$date2->diff($date1)->format("%a");
		
		//$days_num = $hr_days + $day;
		$no_days = $this->get_dates($leave_start_date1,$leave_end_date1);
		$pub_hols = $this->pub_hol();
		$real_days = array_diff($no_days, $pub_hols);
		$days_num = count($real_days)+$hr_days;
			}
		$user_id = ($user_ids != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($user_ids)."'":'NULL';
		$leave_days = ($days_num != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($days_num)."'":'NULL';
		$leave_type = ($leave_type != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($leave_type)."'":'NULL';
		$request_date = ($request_date != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($request_date)."'":'NULL';
		$leave_start_date = ($leave_start_date1 != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($leave_start_date1)."'":'NULL';
		$leave_end_date = ($leave_end_date1 != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($leave_end_date1)."'":'NULL';
		$status = ($status != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($status)."'":'NULL';
		$approve_on = ($approve_one != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($approve_one)."'":'NULL';
		$approve_tw = ($approve_two != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($approve_two)."'":'NULL';
		$comment = ($staff_comment != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($staff_comment)."'":'NULL';
		$in_charge = ($incharge != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($incharge)."'":'NULL';
		$supervisor_id = ($sup_id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($sup_id)."'":'NULL';
		
		$leave_balances = $this->get_days($user_ids); 
	   $annual_leave_no = $leave_balances[0]->$leave_type1;
		//$append = '';
		/*foreach($leave_balances as $leave_balances1){
		$annual_leave_no = $leave_balances1->$leave_type1;
		}*/
		if($annual_leave_no<$days_num){
			
			//$data = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>'.'Sorry. You are applying for more than the leave balance days available '.'</div>';
			$data = "0";
			}
			else {	
		
		$sql = $this->hrm_mysql_connect->query("INSERT INTO leave_request_2018 (user_id, supervisor_id, leave_days, leave_type, request_date, leave_start_date, leave_end_date, status, approval_one, approval_two, staff_comment, incharge_id) VALUES ($user_id, $supervisor_id, $leave_days, $leave_type, $request_date, $leave_start_date, $leave_end_date, $status, $approve_on, $approve_tw, $comment, $in_charge)");
			
		if(!$sql){
			$error = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>'.'Please check your fields, request not processed!'.'</div>';
			throw new Exception($error);
			}else{
				$data = '<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a>'.'Leave request sucessfully submited'.'</div>';
				 
				}
			}
		return $data;
		}
	//get no of days in range
   public function get_dates($start_date,$end_date){
	    $date1 = date_format(date_create($start_date), 'Y-m-d');
	    $date2 = date_format(date_create($end_date), 'Y-m-d');
		$dates = $this->date_manager->getAllDatesBetweenTwoDates($date1,$date2);
		$dates2 = $this->date_manager->exclude_weekends($dates);
		foreach($dates2 as $dat){
			$dates3[] = date_format(date_create($dat), 'm/d/Y');
			}
	   return $dates3;
	   }
//check if is weekend
public function isWeekend($date) {
    $weekDay = date('w', strtotime($date));
    return ($weekDay == 0 || $weekDay == 6);
}
		public function get_id($user_id){
		
		$in_out = "";
		$sql = $this->hrm_mysql_connect->query("SELECT supervisor_id FROM hrm_reg WHERE (user_id = '" . $this->hrm_mysql_connect->real_escape_string($user_id) . "')");
		    while ($row= $sql->fetch_array() ) {
            $id = $row['supervisor_id'];
			}
	     $sql2 = $this->hrm_mysql_connect->query("SELECT in_out, in_charge FROM leave_instance_2014 WHERE (user_id = '" . $this->hrm_mysql_connect->real_escape_string($id) . "')");
		// $sql = $this->hrm_mysql_connect->query("");
	        while($row2=$sql2->fetch_array()) {
			$in_out = $row2['in_out'];
			$incharge = $row2['in_charge'];
				}
			if(($in_out=='2')&&($incharge!='1')&&($incharge!=$user_id)){
			return $incharge;
			}else return $id;
		}
//update the supervisor copy column
	public function should_copy($user_id){
		
		$in_out = "";
		$sql = $this->hrm_mysql_connect->query("SELECT * FROM hrm_reg WHERE (user_id = '" . $this->hrm_mysql_connect->real_escape_string($user_id) . "')");
		    while ($row= $sql->fetch_array() ) {
            $id = $row['supervisor_id'];
			}
	$sql2 = $this->hrm_mysql_connect->query("SELECT * FROM leave_instance_2017 WHERE (user_id = '" . $this->hrm_mysql_connect->real_escape_string($id) . "')");
	        while($row2=$sql2->fetch_array()) {
			$in_out = $row2['in_out'];
			$incharge = $row2['in_charge'];
				}
			if(($in_out=='2')&&($incharge!='1')){
			return array(2,$id);
			}else return array(1,1);
		}
	/*
	public function get_staff_id($user_id){
		
		$sql = $this->hrm_mysql_connect->query("SELECT * FROM hrm_reg WHERE (supervisor_id = '" . $this->hrm_mysql_connect->real_escape_string($user_id) . "')");
		while ($row = $sql->fetch_array()){
			$id = $row['user_id'];
			}
			return $id;
		}
		*/
    public function get_email($user_id2){
		
		$sql = $this->hrm_mysql_connect->query("SELECT * FROM hrm_users WHERE (user_id = '" . $this->hrm_mysql_connect->real_escape_string($user_id2) . "')");
		    while ($row= $sql->fetch_object() ) {
            $names[] = $row;
			}
			return $names;
		}
		//get subordnate email
	public function get_sub_email($lv_id, $yr){
	
	$table = 'leave_request_'.$yr;
	$sql = $this->hrm_mysql_connect->query("SELECT * FROM $table WHERE (id = '" . $this->hrm_mysql_connect->real_escape_string($lv_id) . "')");
		while($row = $sql->fetch_array()){
			$id = $row['user_id'];
			}
			return $id;
		}
		
	public function get_incharge($out_id){
		
		$sql = $this->hrm_mysql_connect->query("SELECT * FROM hrm_out_of_office WHERE (id = '" . $this->hrm_mysql_connect->real_escape_string($out_id) . "')");
		while($row = $sql->fetch_array()){	
		$incharge = $row['incharge_id'];
			}
			return $incharge;
		}
		
	public function get_out_user_id($out_id){
		
		$sql = $this->hrm_mysql_connect->query("SELECT * FROM hrm_out_of_office WHERE (id = '" . $this->hrm_mysql_connect->real_escape_string($out_id) . "')");
		while($row = $sql->fetch_array()){	
		$out_user_id = $row['user_id'];
			}
			return $out_user_id;
		}
		
		
	public function get_leave_responses($user_id){
		
		$sql = $this->hrm_mysql_connect->query("SELECT * FROM leave_request_2018 WHERE (user_id = '" . $this->hrm_mysql_connect->real_escape_string($user_id) ."') ORDER BY id DESC");
		if($sql->num_rows=='0'){
			$leave_data="";
			}
			else{
		while(($data1 = $sql->fetch_object())!= NULL){
			$leave_data[] = $data1;
		   }
			}
		   return $leave_data;
		}
		
		public function out_of_office_responses($user_id){
		
		$sql = $this->hrm_mysql_connect->query("SELECT * FROM hrm_out_of_office WHERE (user_id = '" . $this->hrm_mysql_connect->real_escape_string($user_id) ."') ORDER BY id DESC");
		if($sql->num_rows=='0'){
			$out_data="";
			}
			else{
		while(($data1 = $sql->fetch_object())!= NULL){
			$out_data[] = $data1;
		   }
			}
		   return $out_data;
		}
		
	/*public function get_leave_requests($user_id){
		
		$sql = $this->hrm_mysql_connect->query("SELECT * FROM leave_request_2016 WHERE (supervisor_id = '" . $this->hrm_mysql_connect->real_escape_string($user_id)         ."') ORDER BY id DESC");
		if($sql->num_rows=='0'){
			$leave_data="";
			}
			else{
		while(($data1 = mysql_fetch_object($sql))!= NULL){
			$leave_data[] = $data1;
		   }
		  
			}
		   return $leave_data;
		}*/
		
		//function to get leave requests for only HR
	/*public function get_hr_leave_request(){
		
		$approv_o = 3;
		$approv_t = 2;
		$sql = $this->hrm_mysql_connect->query("SELECT * FROM leave_request_2016 WHERE (approval_one = '" . $this->hrm_mysql_connect->real_escape_string($approv_t) ."') ORDER BY id DESC");
		
		//if there is no request it will display none
		if($sql->num_rows=='0'){
			$leave_data="";
			}
			else{
		while(($data1 = mysql_fetch_object($sql))!= NULL){
			$leave_data[] = $data1;
		   }
		  
			}
		   return $leave_data;
		}*/
		
		public function out_of_office_requests($user_id){
			
			$na = "";
			$nam2 = "";
			$sql = $this->hrm_mysql_connect->query("SELECT * FROM hrm_out_of_office WHERE (supervisor_id = '" . $this->hrm_mysql_connect->real_escape_string($user_id)."')&&(status = '" . $this->hrm_mysql_connect->real_escape_string(1)."') ORDER BY id DESC");
			$nu = $sql->num_rows;
				if($nu==0){
			$number="";
			}else $number=$nu;
		
			
		$sql3 = $this->hrm_mysql_connect->query("SELECT * FROM hrm_out_of_office WHERE (supervisor_id = '" . $this->hrm_mysql_connect->real_escape_string($user_id)."') ORDER BY id DESC");
		while(($row2 = $sql3->fetch_object())!= NULL){
			$na[] = $row2;
			
		}
		if(!$na){
			
		}else{
			foreach($na as $nam):
			$sql2 = $this->hrm_mysql_connect->query("SELECT * FROM hrm_users WHERE (user_id = '" . $this->hrm_mysql_connect->real_escape_string($nam->user_id)."')");
			while ($row3 = $sql2->fetch_object()){
				$nam2[] = $row3;
				}
			endforeach;
				}
				return array($na,$nam2,$number);
			}
		
		//this function is used to get number of request for a supervisor and the person requesting
	public function get_request_id($user_id){
		
		$na="";
		$nam2="";
			$sql3 = $this->hrm_mysql_connect->query("SELECT * FROM leave_request_2018 WHERE (supervisor_id = '" . $this->hrm_mysql_connect->real_escape_string($user_id)."')&&(approval_one = '" . $this->hrm_mysql_connect->real_escape_string(1)."') ORDER BY id DESC");
			$num = $sql3->num_rows;
			if(!$num){
				$number = "";
				}else $number = $num;
			
		$sql = $this->hrm_mysql_connect->query("SELECT * FROM leave_request_2018 WHERE (supervisor_id = '" . $this->hrm_mysql_connect->real_escape_string($user_id)."') ORDER BY id DESC");
		while(($row2 = mysql_fetch_object($sql))!= NULL){
			$na[] = $row2;
			
		}
		if(!$na){
			
		}else{
			foreach($na as $nam):
			$sql2 = $this->hrm_mysql_connect->query("SELECT * FROM hrm_users WHERE (user_id = '" . $this->hrm_mysql_connect->real_escape_string($nam->user_id)."')");
			while ($row3 = $sql2->fetch_object()){
				$nam2[] = $row3;
				}
			endforeach;
		}
			return array($na,$nam2,$number);
		}
	//this function is used to get number of request for a supervisor and the person requesting
	public function get_all_leave_requests($user_id,$yr=2017){
		
		$user_ids = ($user_id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($user_id)."'":'NULL';
		$one = 1;
		$table1 = 'leave_request_'.$yr;
		$ones = ($one != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($one)."'":'NULL';
		$sql1 = $this->hrm_mysql_connect->query("SELECT a.user_id, b.supervisor_id FROM leave_reg a JOIN leave_groups b ON a.leave_group=b.group_id WHERE b.supervisor_id=$user_ids || b.delegate=$user_ids");
		if($sql1->num_rows!=0){
		while($data = $sql1->fetch_assoc()){
		$staff[] = $data['user_id'];
		}
		$filterExisting = "'" . implode("', '", $staff ) . "'";
		
	$sql2 = $this->hrm_mysql_connect->query("SELECT a.*, b.user_firstname, b.user_lastname FROM $table1 a LEFT JOIN hrm_users b ON a.user_id=b.user_id LEFT JOIN hrm_reg c ON a.user_id = c.user_id WHERE c.supervisor_id=$user_ids ORDER BY a.id DESC");
	$sql3 = $this->hrm_mysql_connect->query("SELECT a.*, b.user_firstname, b.user_lastname FROM $table1 a LEFT JOIN hrm_users b ON a.user_id=b.user_id LEFT JOIN hrm_reg c ON a.user_id = c.user_id WHERE c.supervisor_id=$user_ids && a.approval_one = $ones");
	    $num = $sql3->num_rows;
			 if($sql2->num_rows==0){
			$na = ""; 
		 }else{
		  while(($row2 = $sql2->fetch_object())){
			$na[] = $row2;
		}
		 }
		return array($na, $num);
		}else {
			$sql2 = $this->hrm_mysql_connect->query("SELECT a.*, b.user_firstname, b.user_lastname FROM $table1 a LEFT JOIN hrm_users b ON a.user_id=b.user_id LEFT JOIN hrm_reg c ON a.user_id = c.user_id WHERE c.supervisor_id=$user_ids ORDER BY a.id DESC");
	$sql3 = $this->hrm_mysql_connect->query("SELECT a.*, b.user_firstname, b.user_lastname FROM $table1 a LEFT JOIN hrm_users b ON a.user_id=b.user_id LEFT JOIN hrm_reg c ON a.user_id = c.user_id WHERE c.supervisor_id=$user_ids && a.approval_one = $ones");
	    $num = $sql3->num_rows;
		 if($sql2->num_rows==0){
			$na = ""; 
		 }else{
		  while(($row2 = $sql2->fetch_object())){
			$na[] = $row2;
		}
		return array($na, $num);
		}
		}
		}
		//for role of HR office
	public function get_request_id2(){
		
		$na="";
		$nam2="";
			$sql3 = $this->hrm_mysql_connect->query("SELECT * FROM leave_request_2018 WHERE (approval_one != '" . $this->hrm_mysql_connect->real_escape_string(1)."') && (approval_one != '" . $this->hrm_mysql_connect->real_escape_string(2)."') ORDER BY id DESC");
			$sql4 = $this->hrm_mysql_connect->query("SELECT * FROM leave_request_2018 WHERE (approval_one = '" . $this->hrm_mysql_connect->real_escape_string(3)."') && (approval_two = '" . $this->hrm_mysql_connect->real_escape_string(1)."') ORDER BY id DESC");
	    $nu = $sql4->num_rows;
		if($nu==0){
			$number="";
			}else $number=$nu;
		
			
	//	$sql = $this->hrm_mysql_connect->query("SELECT * FROM leave_request_2016 WHERE (supervisor_id = '" . $this->hrm_mysql_connect->real_escape_string($user_id)."')");
		while(($row2 = $sql3->fetch_object())!= NULL){
			$na[] = $row2;
			
		}
		if(!$na){
			
		}else{
			foreach($na as $nam):
			$sql2 = $this->hrm_mysql_connect->query("SELECT * FROM hrm_users WHERE (user_id = '" . $this->hrm_mysql_connect->real_escape_string($nam->user_id)."')");
			while ($row3 = $sql2->fetch_object()){
				$nam2[] = $row3;
				}
			endforeach;
		}
			return array($na,$nam2,$number);
		}
		
		//To update the final status of the leave request as replied by HR
		public function update_status($id, $comment, $status, $leave_id){
			$leave_id1 = ($leave_id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($leave_id)."'":'NULL';
			$sup_comment = ($comment != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($comment)."'":'NULL';
			$status2 = ($status != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($status)."'":'NULL';
			$id2 = ($id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($id)."'":'NULL';
			$in_out = $this->hrm_mysql_connect->real_escape_string('2');
			$date1 = date("m/d/y");
			$date = ($date1 != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($date1)."'":'NULL';
			$sql1 = $this->hrm_mysql_connect->query("UPDATE leave_request_2018 SET hr_comment=$sup_comment, status=$status2, approval_two=$status2,approval_one=$status2, hr_revdate=$date WHERE id=$leave_id1");
			$sql3 = $this->hrm_mysql_connect->query("SELECT * FROM leave_request_2018 WHERE (id = '" . $this->hrm_mysql_connect->real_escape_string($leave_id)."')");
			while($row = $sql3->fetch_array()){
				 $leave = $row['leave_type'];
				$incharge = $row['incharge_id'];
				$staff_id = $row['user_id'];
			$staff_id2 = $row['user_id'];
				if($status==2){
					$days3=0;
				$staff_id = ($staff_id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($staff_id)."'":'NULL';
					$days = $this->hrm_mysql_connect->real_escape_string($days3);
					}else{
				$days4 = $row['leave_days']; 
				$days = $this->hrm_mysql_connect->real_escape_string($days4); 
				}
				}
			$staff_id = ($staff_id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($staff_id)."'":'NULL';
			$three = $this->hrm_mysql_connect->real_escape_string(3); 
			$leav = $leave.'_leave';
			if($leav=='annual_leave'){
				//check balance of 2016 and 2017 and deduct from either accordingly
			//$get_2016_days = $this->select_by_where('leave_instance_2016','user_id',$staff_id2);
			$get_2018_days = $this->select_by_where('leave_instance_2018','user_id',$staff_id2);
			     //$annual_2016 = $get_2016_days[0]->annual_leave;
			      $annual_2018 = $get_2018_days[0]->annual_leave;
				 //$diff_2016 = $annual_2016-$days;
		  /* if(isset($annual_2016)){
			if($diff_2016==0||$diff_2016>0){
				$sql4 = $this->hrm_mysql_connect->query("UPDATE leave_instance_2016 SET days_taken = days_taken+$days, modif_date=$date, in_charge=$incharge, annual_leave=annual_leave-$days WHERE user_id=$staff_id");
			}else if($diff_2016<0){
			$positive_day = abs($diff_2016);
			$sql4 = $this->hrm_mysql_connect->query("UPDATE leave_instance_2016 SET days_taken = days_taken+$positive_day, modif_date=$date, in_charge=$incharge, annual_leave=annual_leave-annual_leave WHERE user_id=$staff_id");
            $this->hrm_mysql_connect->query("UPDATE leave_instance_2017 SET days_taken = days_taken+$positive_day, modif_date=$date, in_charge=$incharge, annual_leave=annual_leave-$positive_day WHERE user_id=$staff_id");			
			}
		   }else{*/
			   $this->hrm_mysql_connect->query("UPDATE leave_instance_2018 SET modif_date=$date, in_charge=$incharge, annual_leave=annual_leave-$days WHERE user_id=$staff_id");
			   
		   //}
			//$sql4 = $this->hrm_mysql_connect->query("UPDATE leave_instance_2017 SET days_taken = days_taken+$days, modif_date=$date, in_charge=$incharge, in_out=$in_out, annual_leave=annual_leave-$days WHERE user_id=$staff_id");
			//$sql5 = $this->hrm_mysql_connect->query("UPDATE leave_groups SET delegate=$incharge, status=$three WHERE supervisor_id=$staff_id");
			//$this->update_annual($staff_id);
				}else {
			$sql4 = $this->hrm_mysql_connect->query("UPDATE leave_instance_2018 SET $leav =$leav-$days, modif_date=$date, in_charge=$incharge, in_out=$in_out WHERE user_id=$staff_id");
				}
			if($sql1){
				$data =  '<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a>'.'Thank you. You have replied to the leave request'.'</div>';
				}
				else{
					$error = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>'.'Sorry, Your Out of office has not been forwarded. Contact I.T department'.'</div>';
				Throw new Exception($error);
				}
				return $data;
			//$sql = $this->hrm_mysql_connect->query("UPDATE leave_request_2016 SET status=" ");
			}
			
			
		public function approval_one($id, $comment, $status, $leave_id, $yr){
			
			$table1 = 'leave_request_'.$yr;
			$leave_id1 = ($leave_id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($leave_id)."'":'NULL';
			$sup_comment = ($comment != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($comment)."'":'NULL';
			$status2 = ($status != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($status)."'":'NULL';
			$id2 = ($id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($id)."'":'NULL';
			$t_date = date('m/d/y');
			$t_date2 = ($t_date != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($t_date)."'":'NULL';
			if($status==2){
$sql = $this->hrm_mysql_connect->query("UPDATE $table1 SET status=$status2, supervisor_comment=$sup_comment, approval_one=$status2, sup_revdate=$t_date2 WHERE    id=$leave_id1");
			if($sql){
				$data =  '<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a>'.'Thank you. You have replied to the leave request'.'</div>';
				}
				else{
					$error = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>'.'Sorry, Your Out of office has not been forwarded. Contact I.T department'.'</div>';
				Throw new Exception($error);
				}
				}
				else {
			$sql1 = $this->hrm_mysql_connect->query("UPDATE $table1 SET supervisor_comment=$sup_comment, approval_one=$status2, sup_revdate=$t_date2 WHERE    id=$leave_id1");
			if($sql1){
				$data =  '<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a>'.'Thank you. You have replied to the leave request'.'</div>';
				
				}
				else{
					$error = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>'.'Sorry, Your Out of office has not been forwarded. Contact I.T department'.'</div>';
				Throw new Exception($error);
				}
				return $data;
				}
			}
			
	public function approve_resup($comment, $status, $record_id, $days, $user_id, $lv_type){
	
	       $leave = $lv_type.'_leave';
			$record_id1 = ($record_id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($record_id)."'":'NULL';
			$sup_comment = ($comment != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($comment)."'":'NULL';
			$status2 = ($status != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($status)."'":'NULL';
		    $id2 = ($user_id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($user_id)."'":'NULL';
			$days1 = ($days != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($days)."'":'NULL';
			$leave_type = ($leave != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($leave)."'":'NULL';
			$t_date = date('Y/m/d');
			$t_date2 = ($t_date != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($t_date)."'":'NULL';
			if($status==2){
           $sql = $this->hrm_mysql_connect->query("UPDATE leave_resumption SET status=$status2, supervisor_comment=$sup_comment, status=$status2, update_date=$t_date2 WHERE id=$record_id1");
			if($sql){
				$data =  '<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a>'.'Thank you. You have denied the leave resumption request'.'</div>';
				}
				else{
					$error = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>'.'Sorry, request has not been procesed contact I.T department'.'</div>';
				Throw new Exception($error);
				}
				}
				else {
			$sql1 = $this->hrm_mysql_connect->query("UPDATE leave_resumption SET status=$status2, supervisor_comment=$sup_comment, status=$status2, update_date=$t_date2 WHERE id=$record_id1");
			//$sql2 = $this->hrm_mysql_connect->query("UPDATE leave_instance_2017 SET $leave=$leave+$days1 WHERE $user_id=$id2");
			if($sql2&&$sql1){
				$data =  '<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a>'.'Thank you. You have approved leave resumption request'.'</div>';
				
				}
				else{
					$error =  mysql_error().'<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>'.'Sorry, request has not been procesed contact I.T department'.'</div>';
				Throw new Exception($error);
				}
				return $data;
				}
		}	
	   public function out_approval($id, $comment, $status, $out_id){
			
			$out_id1 = ($out_id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($out_id)."'":'NULL';
			$sup_comment = ($comment != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($comment)."'":'NULL';
			$status2 = ($status != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($status)."'":'NULL';
			$id2 = ($id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($id)."'":'NULL';
			$date5 = date("m/d/y");
			$date = ($date5 != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($date5)."'":'NULL';
			if($status==2){
				$sql1 = $this->hrm_mysql_connect->query("UPDATE hrm_out_of_office SET status=$status2, supervisor_comment=$sup_comment, sup_revdate=$date WHERE    id=$out_id1");
			if($sql1){
				$data =  '<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a>'.'Thank you. You have replied to the leave request'.'</div>';
				}
				else{
					$error = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>'.'Sorry, response is not forwaded check your fields'.'</div>';
				Throw new Exception($error);
				}
				}
				else {
			$staff_id = $this->get_out_user_id($out_id);
			$incharge = $this->get_incharge($out_id);
			
	    if($incharge!=1){
			$incharge_email = $this->get_email($incharge);
		
		foreach ($incharge_email as $s_email):
		$incharge_email2 = $s_email->user_email;
		endforeach;
			}else{$incharge_email2="";}
			$in_out = $this->hrm_mysql_connect->real_escape_string('2');
			$sql2 = $this->hrm_mysql_connect->query("UPDATE hrm_out_of_office SET status=$status2, supervisor_comment=$sup_comment, sup_revdate=$date WHERE    id=$out_id1");
			$this->hrm_mysql_connect->query("UPDATE leave_instance_2018 SET in_out=$in_out, in_charge=$incharge WHERE user_id=$staff_id");
			//$sql3 = $this->hrm_mysql_connect->query("UPDATE leave_instance_2017 SET in_out=$in_out, supervisor_comment=$sup_comment WHERE    id=$out_id1");
			if($sql2){
				$data =  '<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a>'.'Thank you. You have replied to the leave request'.'</div>';
				
				}
				else{
					$error = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>'.'Sorry, response is not forwaded check your fields'.'</div>';
				Throw new Exception($error);
				}
				return array($data, $incharge_email2);
				}
			}
			
		public function get_days($user_id){
			
			$sql = $this->hrm_mysql_connect->query("SELECT * FROM leave_instance_2018 WHERE (user_id = '" . $this->hrm_mysql_connect->real_escape_string($user_id)."')");
			while($row = $sql->fetch_object()){
				$days[] = $row;
				}
				return $days;
			}
		public function get_users(){
			
			$sql = $this->hrm_mysql_connect->query("SELECT * FROM hrm_users");
			while($users = $sql->fetch_object()){
				$staff[] =  $users;
				}
			return $staff;
			}
		public function back_in_office($id){
			
			$in_out = $this->hrm_mysql_connect->real_escape_string(1);
			$id2 = $this->hrm_mysql_connect->real_escape_string($id);
			$sql = $this->hrm_mysql_connect->query("UPDATE leave_instance_2018 SET in_out=$in_out, in_charge='' WHERE user_id=$id2");
			
			
			}
	/*	public function get_sup_id($name){
			
			$sql = $this->hrm_mysql_connect->query("SELECT * FROM hrm_users WHERE user_firstname");
			
			}*/
		public function out_of_office_request($user_id, $date_one, $date_two, $in_charge, $comment){
			
			
		$date_start = new DateTime($date_one);
		$date_end = new DateTime($date_two);
		$date_1 = $date_start->format('m/d/Y');
		$date_2 = $date_end->format('m/d/Y');
		
		$t1 = $date_start->format('H:i');
		$t2 = $date_end->format('H:i');
		if($date_one==$date_two){
		$no_days = $this->get_dates($date_one,$date_two);
		$pub_hols = $this->pub_hol();
		$real_days = array_diff($no_days, $pub_hols);
		$days_num = count($real_days);
			}elseif(($date_1==$date_2)&&($t1!=$t2)){
			$hrs = strtotime($t2)-strtotime($t1);
		    $days_num = ($hrs/3600)/24;		
				}else{
		$date1 = new DateTime(date_format($date_start, 'Y-m-d'));
	    $date2 = new DateTime(date_format($date_end, 'Y-m-d'));
		$hrs = strtotime($t2)-strtotime($t1);
		$hr_days = ($hrs/3600)/24;
		//$day = 	$date2->diff($date1)->format("%a");
		
		//$days_num = $hr_days + $day;
		$no_days = $this->get_dates($date_one,$date_two);
		$pub_hols = $this->pub_hol();
		$real_days = array_diff($no_days, $pub_hols);
		$days_num = count($real_days)+$hr_days;
			}
			
			
			
			$id = ($user_id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($user_id)."'":'NULL';
			$date1 = ($date_one != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($date_one)."'":'NULL';
			$date2 = ($date_two != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($date_two)."'":'NULL';
			//$no_days = $this->get_dates($date_one,$date_two);
		    //$pub_hols = $this->pub_hol();
		    //$real_days = array_diff($no_days, $pub_hols);
		    //$days_num = count($real_days);
			$days = ($days_num != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($days_num)."'":'NULL';
			$incharge = ($in_charge != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($in_charge)."'":'NULL';
			$comment = ($comment != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($comment)."'":'NULL';
			$in_out = $this->hrm_mysql_connect->real_escape_string('2');
			$date5 = date("m/d/y");
			$date = ($date5 != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($date5)."'":'NULL';
			$status = $this->hrm_mysql_connect->real_escape_string('1');
		 $supervisor_id1 = $this->get_id($user_id);
		$supervisor_id = ($supervisor_id1 != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($supervisor_id1)."'":'NULL';
		$copy = $this->should_copy($user_id);
		$sup_copy = $copy[0];
		$sup_copy_id = $copy[1];
			
			$sql = $this->hrm_mysql_connect->query("INSERT INTO hrm_out_of_office (user_id, supervisor_id, incharge_id, start_date, end_date, days, request_date, status, comment, copied_sup_id, copy) VALUES ($id, $supervisor_id, $incharge, $date1, $date2, $days, $date, $status, $comment, $sup_copy_id, $sup_copy)");
			//$sql2 = $this->hrm_mysql_connect->query("UPDATE leave_instance_2017 SET in_out=$in_out, in_charge=$incharge WHERE user_id=$id");
			
			if($sql){
				$data = '<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a>'.'Out of office succesfully submited'.'</div>';
				} else{
					$error = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>'.'Sorry, Your Out of office has not been forwarded check your fields'.'</div>';
					throw new Exception($error);
					}
			return $data;
			}
//getting public holidays
  public function pub_hol(){
	  
	  $pub_hol = $this->data_client->get_pub_hol();
	  return $pub_hol;
	  }	
//is public holiday
  public function is_pub($date){
	  $pub = $this->pub_hol();
	  foreach($pub as $pub2){
		  if($date==$pub2){
			  return 1;
			  }
		  }
	  }
//get leave days for specific leave id
  public function get_lv_days($id){
	  
	  $lv_days = $this->data_client->get_lv_days($id);
	  return $lv_days;
	  }	
//update annual leave
 /* public function update_annual($user_id){
	  
	  $month = date('m');
	  $sql1 = $this->hrm_mysql_connect->query("SELECT * FROM leave_instance_2017 WHERE user_id=$user_id");
	  while($row = mysql_fetch_array($sql1)){
		  $days = $row[12];
		  }
	 $month_days = $month*1.75;
	 $lv_bal2 = $month_days-$days;
	 $lv_bal = $this->hrm_mysql_connect->real_escape_string($lv_bal2);
	 $sql2 = $this->hrm_mysql_connect->query("UPDATE leave_instance_2017 SET annual_leave=$lv_bal WHERE user_id=$user_id");
	  }*/
//update leave days per month ------function executed as a cron job-----------------
    public function update_annual_lv(){
		
		$sql = $this->hrm_mysql_connect->query("SELECT * FROM leave_instance_2018");
		while($row = mysql_fetch_object($sql)){
			$user_id[] = $row;
			}
		foreach($user_id as $users):
		echo $users->user_id;
		echo '<br />';
		endforeach;
		}
//get details of a supervisor to copy
   public function get_sup_copy_det($out_id){
	  
	  $id = $this->hrm_mysql_connect->real_escape_string($out_id);
	  $sql = $this->hrm_mysql_connect->query("SELECT * FROM hrm_out_of_office WHERE id=$id"); 
	  while($row = $sql->fetch_array()){
		  $copy = $row['copy'];
		  $copy_id = $row['copied_sup_id'];
		  $acting_sup = $row['supervisor_id'];
		  }
	   return array($copy, $copy_id, $acting_sup);
	   }
//get details of a supervisor to copy
   public function get_sup_lvcopy_det($lv_id){
	  
	  $id = $this->hrm_mysql_connect->real_escape_string($lv_id);
	  $sql = $this->hrm_mysql_connect->query("SELECT * FROM leave_request_2018 WHERE id=$id"); 
	  while($row = $sql->fetch_array()){
		  $copy = $row['copy'];
		  $copy_id = $row['copied_sup_id'];
		  $acting_sup = $row['supervisor_id'];
		  }
	   return array($copy, $copy_id, $acting_sup);
	   }
	   
//get supervisor details
  public function get_sup_det($supsor_det){
	
	$sup_date = $this->data_client->get_sup_data($supsor_det);
	return $sup_date;
	}
//get supervisor
  public function get_supervisor($user_id){
	  
	  $sup_name = $this->data_client->get_supervisor($user_id);
	  return $sup_name;
	  }
	//get supervisor
  public function get_supervisor_email($user_id){
	  
	  $sup_name = $this->data_client->get_supervisor_email($user_id);
	  return $sup_name;
	  }
//get staff for supervisor
  public function get_sup_staff($id){
	
	$users = $this->data_client->get_sup_staff($id);
	return $users;
	  }
//leave records
   public function get_leave_record($id){
	   
	   $records = $this->data_client->get_leave_record($id);
	   return $records;
	   }
// submit records
    public function resuption_submit($user_id, $leave_id, $newDate1, $newDate2, $pub_hol, $days, $comment, $type){
		
		$thisyear = date('Y');
		$date = date('Y/m/d');
		$stat = 1;
		$id = ($user_id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($user_id)."'":'NULL';
		$leave_rec = ($leave_id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($leave_id)."'":'NULL';
		$date_1 = ($newDate1!= NULL)?"'".$this->hrm_mysql_connect->real_escape_string($newDate1)."'":'NULL';
		$date_2 = ($newDate2 != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($newDate2)."'":'NULL';
		$pub_hol1 = ($pub_hol != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($pub_hol)."'":'NULL';
		$days_no = ($days != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($days)."'":'NULL';
		$comment_1 = ($comment != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($comment)."'":'NULL';
		$year = ($thisyear != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($thisyear)."'":'NULL';
		$date_today = ($date != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($date)."'":'NULL';
		$status = ($stat != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($stat)."'":'NULL';
		$type1 = ($type != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($type)."'":'NULL';
		$sql = $this->hrm_mysql_connect->query("INSERT INTO leave_resumption (leave_id, user_id, from_date, to_date, public_holiday, days, comment, status, date_posted, year, type) VALUES ($leave_rec, $id, $date_1, $date_2, $pub_hol1, $days_no, $comment_1, $status, $date_today, $thisyear, $type1)");
			if($sql){
				$data = '<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a>'.'Request succesfully submited'.'</div>';
				} else{
					$data = mysql_error().'<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>'.'Request not processed, contact I.T for support'.'</div>';
					}
			return $data;
		}
//resumption feedback
public function get_resump_feedback($id, $yr){
	
	$data = $this->data_client->get_resump_request($id, $yr);
	return $data;
	}
//view yeasr
public function view_years(){
	
	$yrs = $this->data_client->view_years();
	return $yrs;
	}
//supervisor , leave resumption
public function get_resump_requests($id, $year){
	
	$data = $this->data_client->get_resump_requests($id, $year);
	return $data;
	}
//leave resumption user id
public function leave_resump_userid($id){
	
	$user_id = $this->data_client->leave_resump_userid($id);
	return $user_id;
	}
//get staff by supervisor
public function get_sup_staff2($user){
	
	$staff = $this->data_client->get_sup_staff2($user);
	return $staff;
	}
//insert into day request
public function request_extra_day($user_id, $days, $reason){
	
	$date = date('Y/m/d');
		$stat = 1;
		$zero = 0;
		$id = ($user_id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($user_id)."'":'NULL';
		$day = ($days != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($days)."'":'NULL';
		$reasons = ($reason != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($reason)."'":'NULL';
		$dates = ($date != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($date)."'":'NULL';
		$status = ($stat != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($stat)."'":'NULL';
		$zer = ($zero != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($zero)."'":'NULL';
	$d = explode(",",$day);
		$days_num = count($d);
			
	$sql = $this->hrm_mysql_connect->query("INSERT INTO xtra_days_requests (user_id, days, dates, reason, status, taken, date_posted) VALUES ($id, $days_num, $day, $reasons, $status, $zer, $dates)");
	if($sql){
			return 1;
	}else {
		return mysql_error();
		}
	}
//view extra work day requests
public function get_sup_requests($user_id){
	
	$req = $this->data_client->get_sup_requests($user_id);
	return $req;
	}
//approve working extra day
public function approve_xtra_req($comment, $status, $days, $req_id, $user_id1){
	
	$date = date('Y/m/d');
	$usr_id = ($user_id1 != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($user_id1)."'":'NULL';
	$comm = ($comment != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($comment)."'":'NULL';
	$stat = ($status != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($status)."'":'NULL';
	$days_num = ($days != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($days)."'":'NULL';
	$id = ($req_id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($req_id)."'":'NULL';
	$dates = ($date != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($date)."'":'NULL';
	if($status==3){
	$sql = $this->hrm_mysql_connect->query("UPDATE xtra_days_requests SET comment=$comm, status=$stat, date_reviewed=$dates WHERE id=$id");
	$sql2 = $this->hrm_mysql_connect->query("UPDATE leave_instance_2018 SET compensatory_leave=compensatory_leave+$days_num WHERE user_id=$usr_id");
	}else{
		$sql = $this->hrm_mysql_connect->query("UPDATE xtra_days_requests SET comment=$comm, status=$stat, date_reviewed=$dates WHERE id=$id");
		}
	if($sql){
				$data = '<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a>'.'Request succesfully Accepted'.'</div>';
				} else{
					$data = mysql_error().'<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>'.'Request not processed, contact I.T for support'.'</div>';
					}
			return $data;
	}
// compesatory days taken 
public function get_compesatory_tacken($user_id){
	
	$sum = $this->data_client->get_compesatory_tacken($user_id);
	return $sum;
	}
/*add leave schedule*/
public function add_schedule($user_id1, $dates){
	
	$date = date('Y/m/d');
	$status = "1";
	$usr_id = ($user_id1 != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($user_id1)."'":'NULL';
	$dates1 = ($dates != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($dates)."'":'NULL';
	$stat = ($status != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($status)."'":'NULL';
	$date1 = ($date != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($date)."'":'NULL';
	$sql = $this->hrm_mysql_connect->query("INSERT INTO leave_schedule (user_id, leave_date, update_date, status) VALUES ($usr_id, $dates1, $date1, $stat)");
	if(!$sql){
		return 2;
		}else {
			return 1;
			}
	}
//update leave schedule
public function update_schedule($sc_id, $sta, $days1, $comm){
	
	$dates = date('Y/m/d');
	$id = ($sc_id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($sc_id)."'":'NULL';
	$dates1 = ($dates != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($dates)."'":'NULL';
	$stat = ($sta != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($sta)."'":'NULL';
	$days = ($days1 != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($days1)."'":'NULL';
	$commt = ($comm != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($comm)."'":'NULL';
	$sql = $this->hrm_mysql_connect->query("UPDATE leave_schedule SET leave_date=$days, status=$stat, super_comment=$commt WHERE sched_id=$id");
		if(!$sql){
		return mysql_error();
		}else {
			return 1;
			}
	}
//view schedule
public function  view_schedule($id, $user_id){
	
	$data = $this->data_client->view_schedule($id, $user_id);
	return $data;
	}
//get carry over 
public function get_carryover($id){
	
	$carr = $this->data_client->get_carryover($id);
	return $carr;
	}
/*
*
*
*LEAVE REQUEST GROUPS
*
*
*/
public function get_group($user_id){
	
	$user_id1 = ($user_id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($user_id)."'":'NULL';
	$sql = $this->hrm_mysql_connect->query("SELECT a.leave_group, b.name, b.supervisor_id, b.delegate, b.status, c.user_firstname, c.user_lastname, c.user_email FROM leave_reg a JOIN leave_groups b ON a.leave_group = b.group_id JOIN hrm_users c ON b.supervisor_id = c.user_id WHERE a.user_id=$user_id1");
	if($sql){
	$sup = $sql->fetch_assoc();
	$g_name = $sup['name'];
	$g_deleg = $sup['delegate'];
	$g_status = $sup['status'];
	if($g_status==3 && $g_deleg!=0){
		$user_id2 = ($g_deleg != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($g_deleg)."'":'NULL';
		$sql2 = $this->hrm_mysql_connect->query("SELECT user_firstname, user_lastname, user_email FROM hrm_users WHERE user_id=$user_id2");
		$sup_deleg = $sql2->fetch_assoc();
		$delegate = 1;
		$sup_id = $g_deleg;
		$sup_name = $sup_deleg['user_firstname'].' '.$sup_deleg['user_lastname'];
		$sup_email = $sup_deleg['user_email'];
		}else {
	$delegate = 0;
	$sup_id = $sup['supervisor_id'];
	$sup_name = $sup['user_firstname'].' '.$sup['user_lastname'];
	$sup_email = $sup['user_email'];
			}
			return array($g_name, $sup_id, $sup_name, $sup_email, $delegate);
	}else{
		return 0;
		}
}
//get all supervisor staff
public function sup_leave_staff($id){
	
	$id1 = ($id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($id)."'":'NULL';
	$sql = $this->hrm_mysql_connect->query("SELECT a.supervisor_id, b.user_firstname, b.user_lastname, c.annual_leave, c.sick_leave, c.compassionate_leave, c.compensatory_leave, c.carryover_leave FROM hrm_reg a LEFT JOIN hrm_users b ON a.user_id=b.user_id LEFT JOIN leave_instance_2018 c ON a.user_id = c.user_id WHERE a.supervisor_id=$id1 AND b.active=0");
		if($sql){
	while($staff = $sql->fetch_array()){
	$name[] = $staff[1].' '.$staff[2];
	$annual[] = $staff[3];
	$sick[] = $staff[4];
	$compasionate[] = $staff[5];
	$compes[] = $staff[6];
	$carry[] = $staff[7];

	}
		return array($name, $annual, $sick, $compasionate, $compes, $carry);
		}else {
		$empty = array("");
		return array($empty, $empty, $empty, $empty, $empty, $empty, $empty);
	}
	}
//get all pending leaves
public function get_pending($id, $leave_type){
	
		$id1 = ($id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($id)."'":'NULL';
			$leav_type = ($leave_type != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($leave_type)."'":'NULL';
		$one = 1;
	$stat = ($one != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($one)."'":'NULL';
	$sql = $this->hrm_mysql_connect->query("SELECT status FROM leave_request_2018 WHERE user_id=$id1 AND status=$stat AND leave_type=$leav_type");
	if($sql->num_rows==0){
		return 0;
		}else {
			return 1;
			}
	
	}
	//get probation of staff
 public function get_probation($user_id){
	 
	 $id1 = ($user_id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($user_id)."'":'NULL';
	 $sql = $this->hrm_mysql_connect->query("SELECT active FROM hrm_users WHERE user_id=$id1");
	 $row = $sql->fetch_assoc();
	 $stat = $row['active'];
	 return $stat;
	 }
	 /*
*
*
*PDO FUNCTIONS
*
*
*/	 
//function to insert data into a tabe and a column
	public function insert($tabl, $colm){
		 $this->resutl = $this->db->insert($tabl, $colm);
		return ($this->resutl);
		}

//function to select all data from a table
	 public function select_all($tbl){
		 $this->db->query('select * from '.$tbl);
		 return $this->db->result();
		 }	
// select all where
  public function select_by_where($tbl, $col, $pk){
	  $this->db->query('select * from '.$tbl.' WHERE '.$col.'='.$pk);
	  return $this->db->result();
	  }
//function to check if user has submited code of good conduct form
    public function select_by_id($tbl, $col, $pk){
		$this->db->query('select * from '.$tbl.' WHERE '.$col.' = '.$pk);
		 return $this->db->result();
		}
//function to get staff and their leave schedules
 public function select_staf_schd($user_id){
	 $this->db->query('SELECT a.leave_group, b.user_id, b.user_firstname, b.user_lastname, c.* FROM leave_reg a JOIN leave_groups d ON a.leave_group=d.group_id JOIN hrm_users b ON a.user_id=b.user_id LEFT JOIN leave_schedule c ON a.user_id = c.user_id WHERE d.supervisor_id='.$user_id);
	  return $this->db->result();
	 }
//function to review schedule
 public function  review_schedule($sch_id, $status, $comm){
	 $dates = date('Y-m-d');

$res = $this->db->query('UPDATE leave_schedule SET status='.$status.', sup_update_date="'.$dates.'", super_comment="'.$comm.'" WHERE sched_id='.$sch_id);
	 return $res;
	 }
//select requests of leave 
public function get_requests($id){
	$approv = 3;
	$leave_type = 'annual';
	$res = $this->db->query('SELECT leave_days FROM leave_request_2018 WHERE approval_two="'.$approv.'" AND leave_type="'.$leave_type.'" AND user_id='.$id);
	return $this->db->result();
	}
	
}
?>