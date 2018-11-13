<?php
require('/logic/data_client.php');
require('/scripts/date_manager.php');
class logic_processor{
	private $data_client;
	private $date_manager;
	public function __construct(){
		$this->data_client = new data_client();
		$this->date_manager = new date_manager();
		}
	public function open_db(){
		$host = 'localhost';
        $user = 'root';
        $password = 'spider';
		$db = 'baylor_hrm';
        $mysql = mysql_connect($host, $user, $password);
		$connect = mysql_select_db($db);
      if(!$connect){
	throw new Exception("Connection to the database server failed!");
	} 
	else {
		$data = "success";
	}
	return $data;
		}
	public function close_db(){
           mysql_close();
		}
	public function leave_request($user_ids, $leave_type, $request_date, $leave_start_date1, $leave_end_date1, $status, $approve_one, $approve_two, $staff_comment, $incharge){
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
		    $days_num = ($hrs/3600)/24;		
				}else{
		$date1 = new DateTime(date_format($date_one, 'Y-m-d'));
	    $date2 = new DateTime(date_format($date_two, 'Y-m-d'));
		$hrs = strtotime($t2)-strtotime($t1);
		$hr_days = ($hrs/3600)/24;
		//$day = 	$date2->diff($date1)->format("%a");
		
		//$days_num = $hr_days + $day;
		$no_days = $this->get_dates($leave_start_date1,$leave_end_date1);
		$pub_hols = $this->pub_hol();
		$real_days = array_diff($no_days, $pub_hols);
		$days_num = count($real_days)+$hr_days;
			}
		$user_id = ($user_ids != NULL)?"'".mysql_real_escape_string($user_ids)."'":'NULL';
		$leave_days = ($days_num != NULL)?"'".mysql_real_escape_string($days_num)."'":'NULL';
		$leave_type = ($leave_type != NULL)?"'".mysql_real_escape_string($leave_type)."'":'NULL';
		$request_date = ($request_date != NULL)?"'".mysql_real_escape_string($request_date)."'":'NULL';
		$leave_start_date = ($leave_start_date1 != NULL)?"'".mysql_real_escape_string($leave_start_date1)."'":'NULL';
		$leave_end_date = ($leave_end_date1 != NULL)?"'".mysql_real_escape_string($leave_end_date1)."'":'NULL';
		$status = ($status != NULL)?"'".mysql_real_escape_string($status)."'":'NULL';
		$approve_on = ($approve_one != NULL)?"'".mysql_real_escape_string($approve_one)."'":'NULL';
		$approve_tw = ($approve_two != NULL)?"'".mysql_real_escape_string($approve_two)."'":'NULL';
		$comment = ($staff_comment != NULL)?"'".mysql_real_escape_string($staff_comment)."'":'NULL';
		$in_charge = ($incharge != NULL)?"'".mysql_real_escape_string($incharge)."'":'NULL';
		$this->open_db();
		$supervisor_id = $this->get_id($user_ids);
		$supervisor_id = ($supervisor_id != NULL)?"'".mysql_real_escape_string($supervisor_id)."'":'NULL';
		$copy = $this->should_copy($user_ids);
		$copy_sup = $copy[0];
		$copy_sup_id = $copy[1];
		
		$leave_balances = $this->get_days($user_ids); 
		//$append = '';
		foreach($leave_balances as $leave_balances1){
		$annual_leave_no = $leave_balances1->$leave_type1;
		}
		if($annual_leave_no<$days_num){
			
			//$data = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>'.'Sorry. You are applying for more than the leave balance days available '.'</div>';
			$data = "0";
			}
			else {	
		
		$sql = mysql_query("INSERT INTO leave_request_2015 (user_id, supervisor_id, leave_days, leave_type, request_date, leave_start_date, leave_end_date, status, approval_one, approval_two, staff_comment, incharge_id, copied_sup_id, copy) VALUES ($user_id, $supervisor_id, $leave_days, $leave_type, $request_date, $leave_start_date, $leave_end_date, $status, $approve_on, $approve_tw, $comment, $in_charge, $copy_sup_id, $copy_sup)");
			$this->close_db();
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
	   $this->open_db();
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
		$this->open_db();
		$in_out = "";
		$sql = mysql_query("SELECT supervisor_id FROM hrm_reg WHERE (user_id = '" . mysql_real_escape_string($user_id) . "')");
		    while ($row= mysql_fetch_array($sql) ) {
            $id = $row['supervisor_id'];
			}
	     $sql2 = mysql_query("SELECT in_out, in_charge FROM leave_instance_2014 WHERE (user_id = '" . mysql_real_escape_string($id) . "')");
		// $sql = mysql_query("");
	        while($row2=mysql_fetch_array($sql2)) {
			$in_out = $row2['in_out'];
			$incharge = $row2['in_charge'];
				}
			if(($in_out=='2')&&($incharge!='1')&&($incharge!=$user_id)){
			return $incharge;
			}else return $id;
		}
//update the supervisor copy column
	public function should_copy($user_id){
		$this->open_db();
		$in_out = "";
		$sql = mysql_query("SELECT * FROM hrm_reg WHERE (user_id = '" . mysql_real_escape_string($user_id) . "')");
		    while ($row= mysql_fetch_array($sql) ) {
            $id = $row['supervisor_id'];
			}
	$sql2 = mysql_query("SELECT * FROM leave_instance_2015 WHERE (user_id = '" . mysql_real_escape_string($id) . "')");
	        while($row2=mysql_fetch_array($sql2)) {
			$in_out = $row2['in_out'];
			$incharge = $row2['in_charge'];
				}
			if(($in_out=='2')&&($incharge!='1')){
			return array(2,$id);
			}else return array(1,1);
		}
	/*
	public function get_staff_id($user_id){
		$this->open_db();
		$sql = mysql_query("SELECT * FROM hrm_reg WHERE (supervisor_id = '" . mysql_real_escape_string($user_id) . "')");
		while ($row = mysql_fetch_array($sql)){
			$id = $row['user_id'];
			}
			return $id;
		}
		*/
    public function get_email($user_id2){
		$this->open_db();
		$sql = mysql_query("SELECT * FROM hrm_users WHERE (user_id = '" . mysql_real_escape_string($user_id2) . "')");
		    while ($row= mysql_fetch_object($sql) ) {
            $names[] = $row;
			}
			return $names;
		}
		//get subordnate email
	public function get_sub_email($lv_id){
	$this->open_db();
	$sql = mysql_query("SELECT * FROM leave_request_2015 WHERE (id = '" . mysql_real_escape_string($lv_id) . "')");
		while($row = mysql_fetch_array($sql)){
			$id = $row['user_id'];
			}
			return $id;
		}
		
	public function get_incharge($out_id){
		$this->open_db();
		$sql = mysql_query("SELECT * FROM hrm_out_of_office WHERE (id = '" . mysql_real_escape_string($out_id) . "')");
		while($row = mysql_fetch_array($sql)){	
		$incharge = $row['incharge_id'];
			}
			return $incharge;
		}
		
	public function get_out_user_id($out_id){
		$this->open_db();
		$sql = mysql_query("SELECT * FROM hrm_out_of_office WHERE (id = '" . mysql_real_escape_string($out_id) . "')");
		while($row = mysql_fetch_array($sql)){	
		$out_user_id = $row['user_id'];
			}
			return $out_user_id;
		}
		
		
	public function get_leave_responses($user_id){
		$this->open_db();
		$sql = mysql_query("SELECT * FROM leave_request_2015 WHERE (user_id = '" . mysql_real_escape_string($user_id) ."') ORDER BY id DESC");
		if(mysql_num_rows($sql)=='0'){
			$leave_data="";
			}
			else{
		while(($data1 = mysql_fetch_object($sql))!= NULL){
			$leave_data[] = $data1;
		   }
			}
		   return $leave_data;
		}
		
		public function out_of_office_responses($user_id){
		$this->open_db();
		$sql = mysql_query("SELECT * FROM hrm_out_of_office WHERE (user_id = '" . mysql_real_escape_string($user_id) ."') ORDER BY id DESC");
		if(mysql_num_rows($sql)=='0'){
			$out_data="";
			}
			else{
		while(($data1 = mysql_fetch_object($sql))!= NULL){
			$out_data[] = $data1;
		   }
			}
		   return $out_data;
		}
		
	/*public function get_leave_requests($user_id){
		$this->open_db();
		$sql = mysql_query("SELECT * FROM leave_request_2015 WHERE (supervisor_id = '" . mysql_real_escape_string($user_id)         ."') ORDER BY id DESC");
		if(mysql_num_rows($sql)=='0'){
			$leave_data="";
			}
			else{
		while(($data1 = mysql_fetch_object($sql))!= NULL){
			$leave_data[] = $data1;
		   }
		  $this->close_db();
			}
		   return $leave_data;
		}*/
		
		//function to get leave requests for only HR
	/*public function get_hr_leave_request(){
		$this->open_db();
		$approv_o = 3;
		$approv_t = 2;
		$sql = mysql_query("SELECT * FROM leave_request_2015 WHERE (approval_one = '" . mysql_real_escape_string($approv_t) ."') ORDER BY id DESC");
		
		//if there is no request it will display none
		if(mysql_num_rows($sql)=='0'){
			$leave_data="";
			}
			else{
		while(($data1 = mysql_fetch_object($sql))!= NULL){
			$leave_data[] = $data1;
		   }
		  $this->close_db();
			}
		   return $leave_data;
		}*/
		
		public function out_of_office_requests($user_id){
			$this->open_db();
			$na = "";
			$nam2 = "";
			$sql = mysql_query("SELECT * FROM hrm_out_of_office WHERE (supervisor_id = '" . mysql_real_escape_string($user_id)."')&&(status = '" . mysql_real_escape_string(1)."') ORDER BY id DESC");
			$nu = mysql_num_rows($sql);
				if($nu==0){
			$number="";
			}else $number=$nu;
		
			
		$sql3 = mysql_query("SELECT * FROM hrm_out_of_office WHERE (supervisor_id = '" . mysql_real_escape_string($user_id)."') ORDER BY id DESC");
		while(($row2 = mysql_fetch_object($sql3))!= NULL){
			$na[] = $row2;
			
		}
		if(!$na){
			
		}else{
			foreach($na as $nam):
			$sql2 = mysql_query("SELECT * FROM hrm_users WHERE (user_id = '" . mysql_real_escape_string($nam->user_id)."')");
			while ($row3 = mysql_fetch_object($sql2)){
				$nam2[] = $row3;
				}
			endforeach;
				}
				return array($na,$nam2,$number);
			}
		
		//this function is used to get number of request for a supervisor and the person requesting
	public function get_request_id($user_id){
		$this->open_db();
		$na="";
		$nam2="";
			$sql3 = mysql_query("SELECT * FROM leave_request_2015 WHERE (supervisor_id = '" . mysql_real_escape_string($user_id)."')&&(approval_one = '" . mysql_real_escape_string(1)."') ORDER BY id DESC");
			$num = mysql_num_rows($sql3);
			if(!$num){
				$number = "";
				}else $number = $num;
			
		$sql = mysql_query("SELECT * FROM leave_request_2015 WHERE (supervisor_id = '" . mysql_real_escape_string($user_id)."') ORDER BY id DESC");
		while(($row2 = mysql_fetch_object($sql))!= NULL){
			$na[] = $row2;
			
		}
		if(!$na){
			
		}else{
			foreach($na as $nam):
			$sql2 = mysql_query("SELECT * FROM hrm_users WHERE (user_id = '" . mysql_real_escape_string($nam->user_id)."')");
			while ($row3 = mysql_fetch_object($sql2)){
				$nam2[] = $row3;
				}
			endforeach;
		}
			return array($na,$nam2,$number);
		}
		
		//for role of HR office
	public function get_request_id2(){
		$this->open_db();
		$na="";
		$nam2="";
			$sql3 = mysql_query("SELECT * FROM leave_request_2015 WHERE (approval_one != '" . mysql_real_escape_string(1)."') && (approval_one != '" . mysql_real_escape_string(2)."') ORDER BY id DESC");
			$sql4 = mysql_query("SELECT * FROM leave_request_2015 WHERE (approval_one = '" . mysql_real_escape_string(3)."') && (approval_two = '" . mysql_real_escape_string(1)."') ORDER BY id DESC");
	    $nu = mysql_num_rows($sql4);
		if($nu==0){
			$number="";
			}else $number=$nu;
		
			
	//	$sql = mysql_query("SELECT * FROM leave_request_2015 WHERE (supervisor_id = '" . mysql_real_escape_string($user_id)."')");
		while(($row2 = mysql_fetch_object($sql3))!= NULL){
			$na[] = $row2;
			
		}
		if(!$na){
			
		}else{
			foreach($na as $nam):
			$sql2 = mysql_query("SELECT * FROM hrm_users WHERE (user_id = '" . mysql_real_escape_string($nam->user_id)."')");
			while ($row3 = mysql_fetch_object($sql2)){
				$nam2[] = $row3;
				}
			endforeach;
		}
			return array($na,$nam2,$number);
		}
		
		//To update the final status of the leave request as replied by HR
		public function update_status($id, $comment, $status, $leave_id){
			$this->open_db();
			$leave_id1 = ($leave_id != NULL)?"'".mysql_real_escape_string($leave_id)."'":'NULL';
			$sup_comment = ($comment != NULL)?"'".mysql_real_escape_string($comment)."'":'NULL';
			$status2 = ($status != NULL)?"'".mysql_real_escape_string($status)."'":'NULL';
			$id2 = ($id != NULL)?"'".mysql_real_escape_string($id)."'":'NULL';
			$in_out = mysql_real_escape_string('2');
			$date1 = date("m/d/y");
			$date = ($date1 != NULL)?"'".mysql_real_escape_string($date1)."'":'NULL';
			$sql1 = mysql_query("UPDATE leave_request_2015 SET hr_comment=$sup_comment, status=$status2, approval_two=$status2, hr_revdate=$date WHERE id=$leave_id1");
			$sql3 = mysql_query("SELECT * FROM leave_request_2015 WHERE (id = '" . mysql_real_escape_string($leave_id)."')");
			while($row = mysql_fetch_array($sql3)){
				$leave = $row['leave_type'];
				$incharge = $row['incharge_id'];
				$staff_id = $row['user_id'];
				if($status==2){
					$days3=0;
					$days = mysql_real_escape_string($days3);
					}else{
				$days4 = $row['leave_days']; 
				$days = mysql_real_escape_string($days4); 
				}
				}
			$staff_id = ($staff_id != NULL)?"'".mysql_real_escape_string($staff_id)."'":'NULL';
			$leav = $leave.'_leave';
			if($leav=='annual_leave'){
			$sql4 = mysql_query("UPDATE leave_instance_2015 SET days_taken = days_taken+$days, modif_date=$date, in_charge=$incharge, in_out=$in_out, annual_leave=annual_leave-$days WHERE user_id=$staff_id");
			//$this->update_annual($staff_id);
				}else {
			$sql4 = mysql_query("UPDATE leave_instance_2015 SET $leav =$leav-$days, modif_date=$date, in_charge=$incharge, in_out=$in_out WHERE user_id=$staff_id");
				}
			if($sql1){
				$data =  '<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a>'.'Thank you. You have replied to the leave request'.'</div>';
				}
				else{
					$error = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>'.'Sorry, Your Out of office has not been forwarded. Contact I.T department'.'</div>';
				Throw new Exception($error);
				}
				return $data;
			//$sql = mysql_query("UPDATE leave_request_2015 SET status=" ");
			}
			
		public function approval_one($id, $comment, $status, $leave_id){
			$this->open_db();
			$leave_id1 = ($leave_id != NULL)?"'".mysql_real_escape_string($leave_id)."'":'NULL';
			$sup_comment = ($comment != NULL)?"'".mysql_real_escape_string($comment)."'":'NULL';
			$status2 = ($status != NULL)?"'".mysql_real_escape_string($status)."'":'NULL';
			$id2 = ($id != NULL)?"'".mysql_real_escape_string($id)."'":'NULL';
			$t_date = date('m/d/y');
			$t_date2 = ($t_date != NULL)?"'".mysql_real_escape_string($t_date)."'":'NULL';
			if($status==2){
$sql = mysql_query("UPDATE leave_request_2015 SET status=$status2, supervisor_comment=$sup_comment, approval_one=$status2, sup_revdate=$t_date2 WHERE    id=$leave_id1");
			if($sql){
				$data =  '<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a>'.'Thank you. You have replied to the leave request'.'</div>';
				}
				else{
					$error = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>'.'Sorry, Your Out of office has not been forwarded. Contact I.T department'.'</div>';
				Throw new Exception($error);
				}
				}
				else {
			$sql1 = mysql_query("UPDATE leave_request_2015 SET supervisor_comment=$sup_comment, approval_one=$status2, sup_revdate=$t_date2 WHERE    id=$leave_id1");
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
	$this->open_db();
	       $leave = $lv_type.'_leave';
			$record_id1 = ($record_id != NULL)?"'".mysql_real_escape_string($record_id)."'":'NULL';
			$sup_comment = ($comment != NULL)?"'".mysql_real_escape_string($comment)."'":'NULL';
			$status2 = ($status != NULL)?"'".mysql_real_escape_string($status)."'":'NULL';
		    $id2 = ($user_id != NULL)?"'".mysql_real_escape_string($user_id)."'":'NULL';
			$days1 = ($days != NULL)?"'".mysql_real_escape_string($days)."'":'NULL';
			$leave_type = ($leave != NULL)?"'".mysql_real_escape_string($leave)."'":'NULL';
			$t_date = date('Y/m/d');
			$t_date2 = ($t_date != NULL)?"'".mysql_real_escape_string($t_date)."'":'NULL';
			if($status==2){
           $sql = mysql_query("UPDATE leave_resumption SET status=$status2, supervisor_comment=$sup_comment, status=$status2, update_date=$t_date2 WHERE id=$record_id1");
			if($sql){
				$data =  '<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a>'.'Thank you. You have denied the leave resumption request'.'</div>';
				}
				else{
					$error = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>'.'Sorry, request has not been procesed contact I.T department'.'</div>';
				Throw new Exception($error);
				}
				}
				else {
			$sql1 = mysql_query("UPDATE leave_resumption SET status=$status2, supervisor_comment=$sup_comment, status=$status2, update_date=$t_date2 WHERE id=$record_id1");
			$sql2 = mysql_query("UPDATE leave_instance_2015 SET $leave=$leave+$days1 WHERE $user_id=$id2");
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
			$this->open_db();
			$out_id1 = ($out_id != NULL)?"'".mysql_real_escape_string($out_id)."'":'NULL';
			$sup_comment = ($comment != NULL)?"'".mysql_real_escape_string($comment)."'":'NULL';
			$status2 = ($status != NULL)?"'".mysql_real_escape_string($status)."'":'NULL';
			$id2 = ($id != NULL)?"'".mysql_real_escape_string($id)."'":'NULL';
			$date5 = date("m/d/y");
			$date = ($date5 != NULL)?"'".mysql_real_escape_string($date5)."'":'NULL';
			if($status==2){
				$sql1 = mysql_query("UPDATE hrm_out_of_office SET status=$status2, supervisor_comment=$sup_comment, sup_revdate=$date WHERE    id=$out_id1");
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
			$in_out = mysql_real_escape_string('2');
			$sql2 = mysql_query("UPDATE hrm_out_of_office SET status=$status2, supervisor_comment=$sup_comment, sup_revdate=$date WHERE    id=$out_id1");
			mysql_query("UPDATE leave_instance_2015 SET in_out=$in_out, in_charge=$incharge WHERE user_id=$staff_id");
			//$sql3 = mysql_query("UPDATE leave_instance_2015 SET in_out=$in_out, supervisor_comment=$sup_comment WHERE    id=$out_id1");
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
			$this->open_db();
			$sql = mysql_query("SELECT * FROM leave_instance_2015 WHERE (user_id = '" . mysql_real_escape_string($user_id)."')");
			while($row = mysql_fetch_object($sql)){
				$days[] = $row;
				}
				return $days;
			}
		public function get_users(){
			$this->open_db();
			$sql = mysql_query("SELECT * FROM hrm_users");
			while($users = mysql_fetch_object($sql)){
				$staff[] =  $users;
				}
			return $staff;
			}
		public function back_in_office($id){
			$this->open_db();
			$in_out = mysql_real_escape_string(1);
			$id2 = mysql_real_escape_string($id);
			$sql = mysql_query("UPDATE leave_instance_2015 SET in_out=$in_out, in_charge='' WHERE user_id=$id2");
			
			
			}
	/*	public function get_sup_id($name){
			$this->open_db();
			$sql = mysql_query("SELECT * FROM hrm_users WHERE user_firstname");
			
			}*/
		public function out_of_office_request($user_id, $date_one, $date_two, $in_charge, $comment){
			$this->open_db();
			
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
			
			
			
			$id = ($user_id != NULL)?"'".mysql_real_escape_string($user_id)."'":'NULL';
			$date1 = ($date_one != NULL)?"'".mysql_real_escape_string($date_one)."'":'NULL';
			$date2 = ($date_two != NULL)?"'".mysql_real_escape_string($date_two)."'":'NULL';
			//$no_days = $this->get_dates($date_one,$date_two);
		    //$pub_hols = $this->pub_hol();
		    //$real_days = array_diff($no_days, $pub_hols);
		    //$days_num = count($real_days);
			$days = ($days_num != NULL)?"'".mysql_real_escape_string($days_num)."'":'NULL';
			$incharge = ($in_charge != NULL)?"'".mysql_real_escape_string($in_charge)."'":'NULL';
			$comment = ($comment != NULL)?"'".mysql_real_escape_string($comment)."'":'NULL';
			$in_out = mysql_real_escape_string('2');
			$date5 = date("m/d/y");
			$date = ($date5 != NULL)?"'".mysql_real_escape_string($date5)."'":'NULL';
			$status = mysql_real_escape_string('1');
		 $supervisor_id1 = $this->get_id($user_id);
		$supervisor_id = ($supervisor_id1 != NULL)?"'".mysql_real_escape_string($supervisor_id1)."'":'NULL';
		$copy = $this->should_copy($user_id);
		$sup_copy = $copy[0];
		$sup_copy_id = $copy[1];
			
			$sql = mysql_query("INSERT INTO hrm_out_of_office (user_id, supervisor_id, incharge_id, start_date, end_date, days, request_date, status, comment, copied_sup_id, copy) VALUES ($id, $supervisor_id, $incharge, $date1, $date2, $days, $date, $status, $comment, $sup_copy_id, $sup_copy)");
			//$sql2 = mysql_query("UPDATE leave_instance_2015 SET in_out=$in_out, in_charge=$incharge WHERE user_id=$id");
			$this->close_db();
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
	  $this->open_db();
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
	  $this->open_db();
	  $lv_days = $this->data_client->get_lv_days($id);
	  return $lv_days;
	  }	
//update annual leave
 /* public function update_annual($user_id){
	  $this->open_db();
	  $month = date('m');
	  $sql1 = mysql_query("SELECT * FROM leave_instance_2015 WHERE user_id=$user_id");
	  while($row = mysql_fetch_array($sql1)){
		  $days = $row[12];
		  }
	 $month_days = $month*1.75;
	 $lv_bal2 = $month_days-$days;
	 $lv_bal = mysql_real_escape_string($lv_bal2);
	 $sql2 = mysql_query("UPDATE leave_instance_2015 SET annual_leave=$lv_bal WHERE user_id=$user_id");
	  }*/
//update leave days per month ------function executed as a cron job-----------------
    public function update_annual_lv(){
		$this->open_db();
		$sql = mysql_query("SELECT * FROM leave_instance_2015");
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
	  $this->open_db();
	  $id = mysql_real_escape_string($out_id);
	  $sql = mysql_query("SELECT * FROM hrm_out_of_office WHERE id=$id"); 
	  while($row = mysql_fetch_array($sql)){
		  $copy = $row['copy'];
		  $copy_id = $row['copied_sup_id'];
		  $acting_sup = $row['supervisor_id'];
		  }
	   return array($copy, $copy_id, $acting_sup);
	   }
//get details of a supervisor to copy
   public function get_sup_lvcopy_det($lv_id){
	  $this->open_db();
	  $id = mysql_real_escape_string($lv_id);
	  $sql = mysql_query("SELECT * FROM leave_request_2015 WHERE id=$id"); 
	  while($row = mysql_fetch_array($sql)){
		  $copy = $row['copy'];
		  $copy_id = $row['copied_sup_id'];
		  $acting_sup = $row['supervisor_id'];
		  }
	   return array($copy, $copy_id, $acting_sup);
	   }
	   
//get supervisor details
  public function get_sup_det($supsor_det){
	$this->open_db();
	$sup_date = $this->data_client->get_sup_data($supsor_det);
	return $sup_date;
	}
//get supervisor
  public function get_supervisor($user_id){
	  $this->open_db();
	  $sup_name = $this->data_client->get_supervisor($user_id);
	  return $sup_name;
	  }
//get staff for supervisor
  public function get_sup_staff($id){
	$this->open_db();
	$users = $this->data_client->get_sup_staff($id);
	return $users;
	  }
//leave records
   public function get_leave_record($id){
	   $this->open_db();
	   $records = $this->data_client->get_leave_record($id);
	   return $records;
	   }
// submit records
    public function resuption_submit($user_id, $leave_id, $newDate1, $newDate2, $pub_hol, $days, $comment, $type){
		$this->open_db();
		$thisyear = date('Y');
		$date = date('Y/m/d');
		$stat = 1;
		$id = ($user_id != NULL)?"'".mysql_real_escape_string($user_id)."'":'NULL';
		$leave_rec = ($leave_id != NULL)?"'".mysql_real_escape_string($leave_id)."'":'NULL';
		$date_1 = ($newDate1!= NULL)?"'".mysql_real_escape_string($newDate1)."'":'NULL';
		$date_2 = ($newDate2 != NULL)?"'".mysql_real_escape_string($newDate2)."'":'NULL';
		$pub_hol1 = ($pub_hol != NULL)?"'".mysql_real_escape_string($pub_hol)."'":'NULL';
		$days_no = ($days != NULL)?"'".mysql_real_escape_string($days)."'":'NULL';
		$comment_1 = ($comment != NULL)?"'".mysql_real_escape_string($comment)."'":'NULL';
		$year = ($thisyear != NULL)?"'".mysql_real_escape_string($thisyear)."'":'NULL';
		$date_today = ($date != NULL)?"'".mysql_real_escape_string($date)."'":'NULL';
		$status = ($stat != NULL)?"'".mysql_real_escape_string($stat)."'":'NULL';
		$type1 = ($type != NULL)?"'".mysql_real_escape_string($type)."'":'NULL';
		$sql = mysql_query("INSERT INTO leave_resumption (leave_id, user_id, from_date, to_date, public_holiday, days, comment, status, date_posted, year, type) VALUES ($leave_rec, $id, $date_1, $date_2, $pub_hol1, $days_no, $comment_1, $status, $date_today, $thisyear, $type1)");
			if($sql){
				$data = '<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a>'.'Request succesfully submited'.'</div>';
				} else{
					$data = mysql_error().'<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>'.'Request not processed, contact I.T for support'.'</div>';
					}
			return $data;
		}
//resumption feedback
public function get_resump_feedback($id, $yr){
	$this->open_db();
	$data = $this->data_client->get_resump_request($id, $yr);
	return $data;
	}
//view yeasr
public function view_years(){
	$this->open_db();
	$yrs = $this->data_client->view_years();
	return $yrs;
	}
//supervisor , leave resumption
public function get_resump_requests($id, $year){
	$this->open_db();
	$data = $this->data_client->get_resump_requests($id, $year);
	return $data;
	}
//leave resumption user id
public function leave_resump_userid($id){
	$this->open_db();
	$user_id = $this->data_client->leave_resump_userid($id);
	return $user_id;
	}
//get staff by supervisor
public function get_sup_staff2($user){
	$this->open_db();
	$staff = $this->data_client->get_sup_staff2($user);
	return $staff;
	}
//insert into day request
public function request_extra_day($user_id, $days, $reason){
	$this->open_db();
	$date = date('Y/m/d');
		$stat = 1;
		$zero = 0;
		$id = ($user_id != NULL)?"'".mysql_real_escape_string($user_id)."'":'NULL';
		$day = ($days != NULL)?"'".mysql_real_escape_string($days)."'":'NULL';
		$reasons = ($reason != NULL)?"'".mysql_real_escape_string($reason)."'":'NULL';
		$dates = ($date != NULL)?"'".mysql_real_escape_string($date)."'":'NULL';
		$status = ($stat != NULL)?"'".mysql_real_escape_string($stat)."'":'NULL';
		$zer = ($zero != NULL)?"'".mysql_real_escape_string($zero)."'":'NULL';
	$d = explode(",",$day);
		$days_num = count($d);
			
	$sql = mysql_query("INSERT INTO xtra_days_requests (user_id, days, dates, reason, status, taken, date_posted) VALUES ($id, $days_num, $day, $reasons, $status, $zer, $dates)");
	if($sql){
				$data = '<div class="alert alert-success"><a class="close" data-dismiss="alert">×</a>'.'Request succesfully submited'.'</div>';
				
				} else{
					$data = mysql_error().'<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>'.'Request not processed, contact I.T for support'.'</div>';
					}
			return array($data, 1);
	}
//view extra work day requests
public function get_sup_requests($user_id){
	$this->open_db();
	$req = $this->data_client->get_sup_requests($user_id);
	return $req;
	}
//approve working extra day
public function approve_xtra_req($comment, $status, $days, $req_id, $user_id){
	$this->open_db();
	$date = date('Y/m/d');
	$usr_id = ($user_id != NULL)?"'".mysql_real_escape_string($user_id)."'":'NULL';
	$comm = ($comment != NULL)?"'".mysql_real_escape_string($comment)."'":'NULL';
	$stat = ($status != NULL)?"'".mysql_real_escape_string($status)."'":'NULL';
	$days_num = ($days != NULL)?"'".mysql_real_escape_string($days)."'":'NULL';
	$id = ($req_id != NULL)?"'".mysql_real_escape_string($req_id)."'":'NULL';
	$dates = ($date != NULL)?"'".mysql_real_escape_string($date)."'":'NULL';
	if($status==3){
	$sql = mysql_query("UPDATE xtra_days_requests SET comment=$comm, status=$stat, date_reviewed=$dates WHERE id=$id");
	$sql2 = mysql_query("UPDATE leave_instance_2015 SET compensatory_leave=$days_num WHERE user_id=$usr_id");
	}else{
		$sql = mysql_query("UPDATE xtra_days_requests SET comment=$comm, status=$stat, date_reviewed=$dates WHERE id=$id");
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
	$this->open_db();
	$sum = $this->data_client->get_compesatory_tacken($user_id);
	return $sum;
	}
//get carry over 
public function get_carryover($id){
	$this->open_db();
	$carr = $this->data_client->get_carryover($id);
	return $carr;
	}
}
?>