<?php 
require_once('./includes/config.php');
   class data_client {
	 public function __construct(){
		$this->hrm_mysql_connect = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
		}
	public function supervisor_mail($user_id){
		$user = ($user_id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($user_id)."'":'NULL';
		$sql = $this->hrm_mysql_connect->query("SELECT * FROM hrm_reg WHERE (user_id = $user)");
		    while ( ($obj = $sql->fetch_object()) != NULL ) {
            $sup_email[] = $obj;
			}
			return $sup_email;
		}
//get public holidays
   public function get_pub_hol(){
	   $year = date('Y');
	   $yr = $this->hrm_mysql_connect->real_escape_string($year);
	   $sql = $this->hrm_mysql_connect->query("SELECT p_date FROM sys_public_holidays WHERE year=$yr");
	   while($row = $sql->fetch_array()){
		   $dates[] = $row['p_date'];
		   }
		   return $dates;
	   }
//get leave days
  public function get_lv_days($id){
	  $id2 = $this->hrm_mysql_connect->real_escape_string($id);
	  $sql = $this->hrm_mysql_connect->query("SELECT * FROM leave_request_2018 WHERE id=$id2");
	  while($row = $sql->fetch_array()){
		  $days = $row[3];
		  }
		  return $days;
	  }
//get supervisor data
    public function get_sup_data($supsor_det){
		$id = $this->hrm_mysql_connect->real_escape_string($supsor_det);
		$sql = $this->hrm_mysql_connect->query("SELECT * FROM hrm_users WHERE user_id=$id");
		while($row = $sql->fetch_array()){
			$email = $row['user_email'];
			$f_name = $row['user_firstname'];
			$l_name = $row['user_lastname'];
			$name = $f_name.' '.$l_name;
			$position = $row['user_position'];
			$user_no = $row['user_id_number'];
			$staff_id = $row['user_id'];
			}
			return array($email, $name, $position, $user_no, $staff_id);
		}
//get supervisor
//get supervisor
 public function get_supervisor($user_id){
		$user_id1 = $this->hrm_mysql_connect->real_escape_string($user_id);
		$sql = $this->hrm_mysql_connect->query("SELECT * FROM hrm_reg WHERE user_id=$user_id1");
		if($sql->num_rows!=0){
		while($row = $sql->fetch_array()){
			$sup_id = $row[3];
			}
		$sql2 = $this->hrm_mysql_connect->query("SELECT * FROM hrm_users WHERE user_id=$sup_id");
		while($row1 = $sql2->fetch_array()){
			$sup_name = $row1[2].' '.$row1[3];
			return $sup_name;
			}
		}else {return "supervisor not allocate";}
		}
	 public function get_supervisor_email($user_id){
		$user_id1 = $this->hrm_mysql_connect->real_escape_string($user_id);
		$sql = $this->hrm_mysql_connect->query("SELECT * FROM hrm_reg WHERE user_id=$user_id1");
		if($sql->num_rows!=0){
		while($row = $sql->fetch_array()){
			$sup_id = $row[3];
			}
		$sql2 = $this->hrm_mysql_connect->query("SELECT * FROM hrm_users WHERE user_id=$sup_id");
		while($row1 = $sql2->fetch_array()){
			$sup_email = $row1[6];
			return $sup_email;
			}
		}else {return "supervisor not allocate";}
		}
		
//get staff for supervisor
public function get_sup_staff($id){
	$user_id = $this->hrm_mysql_connect->real_escape_string($id);
	$sql = $this->hrm_mysql_connect->query("SELECT a.user_id, b.user_id, b.user_firstname, b.user_lastname, b.user_position FROM hrm_reg a JOIN hrm_users b on a.user_id=b.user_id WHERE supervisor_id=$user_id");
	if($sql->num_rows !=0){
		while($row = $sql->fetch_array()){
			$name[] = $row[2].' '.$row[3];
			$position[] = $row[4];
			$staff_id[] = $row[0];
			$shc = $this->has_leave_sched($row[0]);
			if($shc==2){
			$lv_sch[] = "no schedule";
			$status[] = "";
			$sch_id[] = "";
				}else {
			$lv_sch[] = "view leave shedule";
			$status[] = $shc[1];
			$sch_id[] = $shc[0];
					}
		}
			return array($name, $position, $staff_id, $lv_sch, $status, $sch_id);
		}else {
			$arr = array('no staff');
			$empty_arr = array('');
			return array($empty_arr, $arr, $arr, $arr, $arr, );
			}
	
	}
/*check if user has submited leave schedule*/
public function has_leave_sched($id){
		$user_id = ($id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($id)."'":'NULL';
		$sql = $this->hrm_mysql_connect->query("SELECT sched_id, status FROM leave_schedule WHERE user_id=$user_id");
		if($sql->num_rows==0){
			return 2;
			}else {
			while($row = $sql->fetch_array()){
				$sch_id = $row[0];
				$stat = $row[1];
				}
				return array($sch_id, $stat);
				}
	}
//get schedule
public function view_schedule($id, $user_id){
$sch_id = ($id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($id)."'":'NULL';
$user_id2 = ($user_id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($user_id)."'":'NULL';
		$sql = $this->hrm_mysql_connect->query("SELECT a.sched_id, a.leave_date, a.status, b.user_firstname, b.user_lastname FROM leave_schedule a JOIN hrm_users b on a.user_id=b.user_id WHERE a.user_id=$user_id2 AND a.sched_id=$sch_id");
			while($row = $sql->fetch_array()){
				$sch_id = $row[0];
				$dates = $row[1];
				$stat = $row[2];
				$f_name = $row[3];
				$l_name = $row[4];
				}
				return array($sch_id, $dates, $stat, $f_name, $l_name, $user_id);
	}
//get user details on leave records
public function get_leave_record($id){
	$user_id = $this->hrm_mysql_connect->real_escape_string($id);
	$approved = $this->hrm_mysql_connect->real_escape_string(3);
	$leave = 'annual';
	$leave1 = ($leave != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($leave)."'":'NULL';
	$leave2 = 'compensatory';
	$leave2 = ($leave2 != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($leave2)."'":'NULL';
	$sql = $this->hrm_mysql_connect->query("SELECT id, leave_days, leave_type, leave_start_date, leave_end_date FROM leave_request_2018 WHERE user_id=$user_id AND status=$approved AND (leave_type=$leave1||leave_type=$leave2)");
	if($sql->num_rows !=0){
		while($row = $sql->fetch_array()){
			$leave_id[] = $row['id'];
			$leave_type[] = $row['leave_type'];
			$leave_days[] = $row['leave_days'];
			$start[] = $row['leave_start_date'];
			$end[] = $row['leave_end_date'];
			}
			return array($leave_type, $leave_days, $start, $end, $leave_id);
		} else {
			$empty = array('');
			return array($empty, $empty, $empty, $empty, $empty);
			}
	}
//get resumption requests
  public function get_resump_request($id, $yr){
	 $one = "1";
	 $user_id = ($id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($id)."'":'NULL';
	 $approved = ($one != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($one)."'":'NULL';
	$sql = $this->hrm_mysql_connect->query("SELECT leave_id, from_date, to_date, public_holiday, days, comment, status, date_posted, supervisor_comment, id, type FROM leave_resumption WHERE user_id=$user_id AND date_posted LIKE '%$yr%'");
		if($sql->num_rows !=0){
		while($row = $sql->fetch_array()){;
			$leave_id[] = $row['leave_id'];
			$leave = $this->leave_details2($row['leave_id'], $yr);
			$leave_type[] = $leave[0];
			$leav_start_date[] = $leave[1];
			$leav_end_date[] = $leave[2];
			$from_date[] = $row['from_date'];
			$to_date[] = $row['to_date'];
			$public_holiday[] = $row['public_holiday'];
			$days[] = $row['days'];
			$comment[] = $row['comment'];
			$status[] = $row['status'];
			$date1[] = $row['date_posted'];
			$sup_comment[] = $row['supervisor_comment'];
			$id_row[] = $row['id'];
			$type[] = $row['type'];
			}
			return array($leave_id, $from_date, $to_date, $public_holiday, $days, $comment, $status, $date1, $sup_comment, $leave_type, $leav_start_date, $leav_end_date, $id_row, $type);
		} else {
			$empty = array();
			return array($empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty);
			}
	 }
//get leave request details
  public function leave_details($id){
	    $leave_id = ($id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($id)."'":'NULL';
	   $sql = $this->hrm_mysql_connect->query("SELECT leave_type, leave_start_date, leave_end_date FROM leave_request_2018 WHERE id=$leave_id");
	  if($sql->num_rows!=0){
	   while($row = $sql->fetch_array()){
		   $leave_type = $row['leave_type'];
		   $start_date = $row['leave_start_date'];
		   $end_date  = $row['leave_end_date'];
		   }
		   return array($leave_type, $start_date, $end_date);
	  }else {
		  $empty = array("");
		  return array($empty, $empty, $empty);
		  }
	  }
//get leave request details
  public function leave_details2($id, $year){
	    $leave_id = ($id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($id)."'":'NULL';
	   $sql = $this->hrm_mysql_connect->query("SELECT leave_type, leave_start_date, leave_end_date FROM leave_request_2018 WHERE id=$leave_id");
	  if($sql->num_rows!=0){
	   while($row = $sql->fetch_array()){
		   $leave_type = $row['leave_type'];
		   $start_date = $row['leave_start_date'];
		   $end_date  = $row['leave_end_date'];
		   }
		   return array($leave_type, $start_date, $end_date);
	  }else {
		  $empty = array("");
		  return array($empty, $empty, $empty);
		  }
	  }
//rensumption supervisor 
 public function get_resump_requests($id, $year){
	$one = '1';
	$approved = ($one != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($one)."'":'NULL';
	$user_id = ($id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($id)."'":'NULL';
	$sql = $this->hrm_mysql_connect->query("SELECT a.id, a.from_date, a.to_date, a.public_holiday, a.days, a.comment, a.supervisor_comment, a.status, a.leave_id, c.user_firstname, c.user_lastname, c.user_email FROM leave_resumption a JOIN hrm_reg b on a.user_id=b.user_id JOIN hrm_users c on a.user_id=c.user_id WHERE b.supervisor_id=$user_id AND a.date_posted LIKE '%$year%'");
	$sql2 = $this->hrm_mysql_connect->query("SELECT a.id FROM leave_resumption a JOIN hrm_reg b on a.user_id=b.user_id JOIN hrm_users c on a.user_id=c.user_id WHERE b.supervisor_id=$user_id AND a.status=$approved");	
		$num = $sql2->num_rows;
		if($sql->num_rows !=0){
		while($row = $sql->fetch_array()){;
			$record_id[] = $row[0];
			$from_date[] = $row[1];
			$to_date[] = $row[2];
			$public_hol[] = $row[3];
			$days[] = $row[4];
			$comment[] = $row[5];
			$sup_comment[] = $row[6];
			$status[] = $row[7];
			$leave_id[] = $row[8];
			$leave = $this->leave_details2($row[8], $year);
			$leave_type[] = $leave[0];
			$leav_start_date[] = $leave[1];
			$leav_end_date[] = $leave[2];
			$leave_start_date[] = $leave[1];
			$firstname[] = $row[9];
			$lastname[] = $row[10];
			$email[] = $row[11];
			}
			return array($record_id, $from_date, $to_date, $public_hol, $days, $comment, $sup_comment, $status, $firstname, $lastname, $email, $leave_type, $leav_end_date, $leav_end_date, $num);
		} else {
			$empty = array();
			$num = "";
			return array($empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty,$empty, $empty, $empty, $empty, $num);
			}
	 }
//get leave resumption details
   public function leave_resump_userid($id){
	   $userid = ($id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($id)."'":'NULL';
	   $sql = $this->hrm_mysql_connect->query("SELECT user_id FROM leave_resumption WHERE id=$userid");
	   while($row = $sql->fetch_array()){
		 $user = $row['user_id'];
	   }
	   return $user;
	   }
//get carry overs //get staff by supervisor
  public function get_sup_staff2($user){
	   $userid = ($user != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($user)."'":'NULL';
	  $sql = $this->hrm_mysql_connect->query("SELECT a.user_id, a.user_firstname, a.user_lastname FROM hrm_reg b LEFT JOIN hrm_users a ON b.user_id=a.user_id WHERE b.supervisor_id=$userid");
	 if($sql->num_rows!=0){
	 while($row = $sql->fetch_array()){
		 $user_id[] = $row[0];
		 $fname[] = $row[1];
		 $lname[] = $row[2];
		 }
		 return array($user_id, $fname, $lname);
	  } else{
	  $empty = array("");
	   return array($empty, $empty, $empty);
  }
  }
//view exrtra day request
public function get_sup_requests($user_id){
	$one = 1;
	$ones = ($one != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($one)."'":'NULL';
	$userid = ($user_id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($user_id)."'":'NULL';
	$sql = $this->hrm_mysql_connect->query("SELECT id, days, dates, reason, status, taken, date_posted, date_reviewed FROM xtra_days_requests WHERE user_id=$user_id");
	$sql2 = $this->hrm_mysql_connect->query("SELECT id FROM xtra_days_requests WHERE user_id=$user_id AND status=$ones");
	$num4 = $sql2->num_rows;
	if($sql->num_rows!=0){
		while($row = $sql->fetch_array()){
			$id[] = $row[0];
			$days[] = $row[1];
			$dates[] = $row[2];
			$reason[] = $row[3];
			$status[] = $row[4];
			$taken[] = $row[5];
			$posted[] = $row[6];
			$reviewed[] = $row[7];
			}
			return array($id, $days, $dates, $reason, $status, $taken, $posted, $reviewed, $num4);
		}else {
		$empty = array("");
		$empty2 = "";
		return array($empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty, $empty2);
		}
     }
//get total compesatory days
public function get_compesatory_tacken($user_id){
	$one = 1;
	$ones = ($one != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($one)."'":'NULL';
	$userid = ($user_id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($user_id)."'":'NULL';
   $sql = $this->hrm_mysql_connect->query("SELECT days FROM xtra_days_requests WHERE user_id=$user_id AND taken=$ones");
   if($sql->num_rows!=0){
   while($row = $sql->fetch_array()){
         $days[] = $row[0]; 
	   }
	   $sum = array_sum($days);
	   return $sum;
   }else {
	   $empty = "";
	   return $empty;
	   }
	}
//get carry overs 
public function get_carryover($id){
	$year = date('Y');
	$year1 = ($year != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($year)."'":'NULL';
	$user_id = ($id != NULL)?"'".$this->hrm_mysql_connect->real_escape_string($id)."'":'NULL';
	$sql = $this->hrm_mysql_connect->query("SELECT days FROM carry_over WHERE user_id = $user_id");
	if($sql->num_rows!=0){
		$row = $sql->fetch_assoc;
		$days = $row['days'];
		return $days.' days';
		}
		else {
			$none = "none";
			return $none;
			}
	}
//view years
 public function view_years(){
		 $sql = $this->hrm_mysql_connect->query("SELECT year FROM sys_years");
		 while($row = $sql->fetch_array()){
			 $years[] = $row[0];
			 }
			 return $years;
		 }

	}
?>