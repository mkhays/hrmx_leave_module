<?php
require($_SERVER['DOCUMENT_ROOT'].'/scripts/logout.php');
require('./logic/logic_processor.php');
require('scripts/send_email.php');
//require('/scripts/send-email.php');
class leave_controller{
	private $processor;
	public $g_var;
	public $num;
	private $send_email;
	private $send_email2;
	public function __construct(){
		$this->processor = new logic_processor();
        $this->send_email = new send_email();
		$this->send_email2 = new send_email();
	  $this->g_var = $this->get_leave_super();
	  	$this->num = $this->get_leave_requests_num();
		define('USER_NAMES', $_SESSION['firstname'].' '.$_SESSION['lastname']);
		}
	public function main_function(){
		$request = isset($_GET['request'])?$_GET['request']:NULL;
		if(!$request=='leave'){
			
			$sup_name = $this->processor->get_supervisor($_SESSION['user_id']);
		
				$data = "";
			$user_id = $_SESSION['user_id'];
			// $role = $_SESSION['role'];
			
			if($role=='HR office'){
				
			//$id = $this->processor->get_request_id2();
			//$leave_req_det = $id[0];
			//$name = $id[1];
			//$num = $id[2];
			
			$d = $this->processor->out_of_office_requests($user_id);;
			$num2 = $d[2];
			
			 $records = $this->processor->get_resump_requests($user_id, 2015);
		    $num3 = $records[14];
		    $staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
			
			if(!$leave_req_det){
				$display = 'blank.php';
				}
				else //$display = 'leave_approval.php';
			
	        $records = $this->processor->get_resump_requests($user_id, 2015);
		    $num3 = $records[14];
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];	
		    $display = 'hr_approval.php';
			$main_title="Leave Management";
			define('MAIN_CONTENT','templates/en_US/'.$display);
			define('SIDE_MENU','templates/en_US/hr_leave_menu.php');
			include('templates/en_US/main.php');
			}
			else{
				//$id = $this->processor->get_request_id($user_id);
			//$num = $id[2];
			
			$d = $this->processor->out_of_office_requests($user_id);
			$num2 = $d[2];
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
			// $pub_days = $this->pub_hol();
				$out2 = $this->processor->get_days($user_id);
			
			// foreach($out2 as $out_in):    
            // $ot = $out_in->in_out;
            // endforeach; 
            // if($ot==2){
			// 	$display = "lv_out_btn.php";
	       //  }else {
				$display = "leave_form.php";
				// }
				$staff = $this->processor->get_users();
				
			$records = $this->processor->get_resump_requests($user_id, 2015);
		    $num3 = $records[14];
			$main_title="Leave Management";
			$form_title = "Leave Form";
			define('MAIN_CONTENT','templates/en_US/'.$display);
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			include('templates/en_US/main.php');
				}
			}
		if($request=='leave'){
			
			$sup_name = $this->processor->get_supervisor($_SESSION['user_id']);
			$data = "";
			$user_id = $_SESSION['user_id'];
			//$role = $_SESSION['role'];
			
		/*	if($role=='HR office'){
			$id = $this->processor->get_request_id2();
			$leave_req_det = $id[0];
			$name = $id[1];
			$num = $id[2];
			
			$d = $this->processor->out_of_office_requests($user_id);
			$num2 = $d[2];
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
			
			if(!$leave_req_det){
				$display = 'blank.php';
				}
				else //$display = 'leave_approval.php';
				
		        $display = 'hr_approval.php';
			 $records = $this->processor->get_resump_requests($user_id, 2015);
		    $num3 = $records[14];
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
			$main_title="Leave Management";
			define('MAIN_CONTENT','templates/en_US/'.$display);
			define('SIDE_MENU','templates/en_US/hr_leave_menu.php');
			include('templates/en_US/main.php');
			}
			else { */
				//$id = $this->processor->get_request_id($user_id);
		//	$num = $id[2];
			
			$d = $this->processor->out_of_office_requests($user_id);
			$num2 = $d[2];
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
				$pub_days = $this->processor->pub_hol();
					$out2 = $this->processor->get_days($user_id);
			
			 // foreach($out2 as $out_in):    
            // $ot = $out_in->in_out;
            // endforeach; 
            // if($ot==2){
			// 	$display = "lv_out_btn.php";
	         // }else {
				$display = "leave_form.php";
			// 	}
				$staff = $this->processor->get_users();
				
			 $records = $this->processor->get_resump_requests($user_id, 2015);
		    $num3 = $records[14];
			$main_title="Leave Management";
			$form_title="Leave Form";
			define('MAIN_CONTENT','templates/en_US/'.$display);
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			include('templates/en_US/main.php');
				//}
			}
		if($request=='leave_form'){
				
				$sup_name = $this->processor->get_supervisor($_SESSION['user_id']);
				$data ="";
				$user_id = $_SESSION['user_id'];
				//$id = $this->processor->get_request_id($user_id);
			  //  $num = $id[2];
				
				$pub_days = $this->processor->pub_hol();
				
				$d = $this->processor->out_of_office_requests($user_id);
			$num2 = $d[2];
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
			$staff = $this->processor->get_users();
			$user_id = $_SESSION['user_id'];
			$leave_data = $this->processor->get_leave_responses($user_id);
			$out2 = $this->processor->get_days($user_id);
			
			/* foreach($out2 as $out_in):    
            $ot = $out_in->in_out;
            endforeach; 
            if($ot==2){
				$display = "lv_out_btn.php";
	        }else {  */
				$display = "leave_form.php";
				// }
				$staff = $this->processor->get_users();
				
				 $records = $this->processor->get_resump_requests($user_id, 2015);
				 $num3 = $records[14];
			$main_title="Leave Management";
			$form_title="Leave Form";
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			define('MAIN_CONTENT','templates/en_US/'.$display);
			include('templates/en_US/main.php');
			}
		if($request=='leave_request'){
			$data="";
			$leave_type = "";
			$start_date = "";
			$end_date = "";
			$leave_days = "";
			$comment = "";
				
			$sup_name = $this->processor->get_supervisor($_SESSION['user_id']);
			$sup_email = $this->processor->get_supervisor_email($_SESSION['user_id']);
			$user_id = $_SESSION['user_id'];
			
			$d = $this->processor->out_of_office_requests($user_id);
			$num2 = $d[2];
			// $records = $this->processor->duty_resumption_requests($user_id);
			 //$d_num = $records[9];
			
			//$records = $this->processor->get_resump_requests($user_id, 2015);
			$num3 = "";
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
		     if($_SERVER['REQUEST_METHOD']=='POST'){
			$leave_type = $_POST['leave_type'];
			if($_POST['leave_type']=="annual leave loan"){
			$leave_type = "loan";	
			}else{
			$leave_type = $_POST['leave_type'];	
			}
			$start_date = $_POST['leave_date1'];
			$end_date = $_POST['leave_date2'];
			$incharge = $_POST['in_charge'];
			$date1 = date_format(date_create($start_date), 'm/d/Y');
			$date2 = date_format(date_create($end_date), 'm/d/Y');
			$request_date = date("m/d/Y");
			//$leave_days = $_POST['days'];
			$comment = $_POST['comment'];
			$user_id = $_SESSION['user_id'];
			$status = 1;
			$approve_one =1;
			$approve_two =1;
			$startdate2 = strtotime($start_date);
			$isweekend1 = $this->processor->isWeekend($date1);
			$isweekend2 = $this->processor->isWeekend($date2);
			$enddate2 = strtotime($end_date);
			$pub_day1 = $this->processor->is_pub($date1);
			$pub_day2 = $this->processor->is_pub($date2);
			
		 if(($startdate2 > $enddate2)||(empty($startdate2)||empty($enddate2))){
			$data = '<div class="alert alert-warning"><a class="close" data-dismiss="alert">×</a>'.'Please correct your start and end dates. Note: Your end date should be greater than the start date and they should not be empty'.'</div>';
				}elseif(($isweekend1==1)||($isweekend2==1)){
				$data = '<div class="alert alert-warning"><a class="close" data-dismiss="alert">×</a>'.'Please correct your start and end dates. Note: Weekends should not be filled in'.'</div>';	
					}
				 elseif($pub_day1==1||$pub_day2==1){
					$data = '<div class="alert alert-warning"><a class="close" data-dismiss="alert">×</a>'.'Please correct your start and end dates. Note: Public holidays should not be filled in'.'</div>'; 
					 }
				 else{
			try{
		
				
				
				
			/* $supervisor_id = $this->processor->get_id($user_id);
			$names = $this->processor->get_email($supervisor_id);
			foreach($names as $names):
			$email = $names->user_email;
			endforeach;  */
			
            $staff = $this->processor->get_users();
			$pending = $this->processor->get_pending($user_id, $leave_type);
			$get_probation = $this->processor->get_probation($user_id);
			if($get_probation!=0 && $leave_type=='annual'){
				$data = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>'.'Sorry. You are Still on probation'.'</div>';
				}else{
			if($pending==0){
			$data = $this->processor->leave_request($user_id, $leave_type, $request_date, $start_date, $end_date, $status, $approve_one, $approve_two, $comment, $incharge, $leave_sup_id);
			if($data=="0"){
				$data = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>'.'Sorry. You are applying for more than the leave balance days available '.'</div>';
				}else{
			//$data = '<div class="alert alert-success">'.$data2.'</div>';
			$subject = "LEAVE REQUEST";
			$body = 'Hello, <br />'. $_SESSION['firstname'].' '.$_SESSION['lastname'].' has requested<b> '. $leave_type .' leave </b>from<b> '. $start_date .' </b>ending<b> '. $end_date.' </b><br /><br /> Please login to Baylor HR System to review the request.<br />
			<br />Baylor Intergrated Human Resource Information System <br />
			<br />
			<a href="https://hris.baylor-uganda.org"><strong>External Link</strong></a>
			<br /><br />
			 Thank you <br /><br /> BCM - Human Resource Information System';
			 $this->send_email->send_email($sup_email, $subject, $body);
			//$this->send_email->send_mail($email,$comment);
			//mail("kakandem45@gmail.com","testing","we are just testing this","From");
			
			}
			} else{
				
			$data = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>'.'Sorry. You have pending leave requests '.'</div>';	
				}
				}
			}
			catch(Exception $e){
				$data = $e->getMessage();
				}
			
				}
			}
			
			$pub_days = $this->processor->pub_hol();
				$out2 = $this->processor->get_days($user_id);
			
			/* foreach($out2 as $out_in):    
            $ot = $out_in->in_out;
            endforeach; 
            if($ot==2){
				$display = "lv_out_btn.php";
	        }else { */
				$display = "leave_form.php";
				// }
				
				$staff = $this->processor->get_users();
				$records = $this->processor->get_resump_requests($user_id, 2015);
				$num3 = $records[14];
				 
			$main_title="Leave Management";
			$form_title="Leave Form";
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			define('MAIN_CONTENT','templates/en_US/'.$display);
			include('templates/en_US/main.php');
				
			}
		if($request=='logout'){
				$this->logout = new logout();
				$this->logout->logout_user();	
							}
			if($request=='feed_back'){
			
			$form_title = "Leave feedback and History";
			$sup_name = $this->processor->get_supervisor($_SESSION['user_id']);
			$user_id = $_SESSION['user_id'];
			//$id = $this->processor->get_request_id($user_id);
		//	$num = $id[2];
			
			$d = $this->processor->out_of_office_requests($user_id);
			$num2 = $d[2];
			
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
			
			$leave_data = $this->processor->get_leave_responses($user_id);
			if(!$leave_data){
				$display='blank.php';
				}
				else $display='feed_back.php';
				
				$records = $this->processor->get_resump_requests($user_id, 2015);
				 $num3 = $records[14];
			$main_title="Feed Back and History";
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			define('MAIN_CONTENT','templates/en_US/'.$display);
			include('templates/en_US/main.php');		
				}
				
				
				if($request=='out_office_feedback'){
			
			$form_title = "Out of office feedback and History"; 
			$sup_name = $this->processor->get_supervisor($_SESSION['user_id']);
			$user_id = $_SESSION['user_id'];
			//$id = $this->processor->get_request_id($user_id);
		//	$num = $id[2];
			
			$d = $this->processor->out_of_office_requests($user_id);
			$num2 = $d[2];
			
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
			
			$out_data = $this->processor->out_of_office_responses($user_id);
			if(!$out_data){
				$display='blank.php';
				}
			else $display='out_of_office_feedback.php';
			
			$records = $this->processor->get_resump_requests($user_id, 2015);
			$num3 = $records[14];
			$main_title="Out of office feedback";
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			define('MAIN_CONTENT','templates/en_US/'.$display);
			include('templates/en_US/main.php');		
				}
				
				//This is to get the leave request of the supervisor 
			if($request=='leave_requests'){
			$form_title = "Review subordinates leave requests and History";
			$sup_name = $this->processor->get_supervisor($_SESSION['user_id']);
			$data="";
			$reply = "";
			$yr = $_GET['yr'];
			$role = $_SESSION['role'];
			$user_id = $_SESSION['user_id'];
			//$sub_id = $this->processor->get_sub_email($leave_id);
           // $days = $this->processor->get_days($sub_id); 
			if($role=='HR office'){
				//$leave_data = $this->processor->get_hr_leave_request();
				
					//This is to get the leave request numbers and name of supervisor
			$id = $this->processor->get_request_id2();
			$leave_req_det = $id[0];
			$name = $id[1];
			//$num = $id[2];
			
			$d = $this->processor->out_of_office_requests($user_id);
			$num2 = $d[2];
			// $records = $this->processor->duty_resumption_requests($user_id);
			// $d_num = $records[9];
			
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
			
			if(!$leave_req_det){
				$display = 'blank.php';
				}
				else //$display = 'leave_approval.php';
				
		        $display = 'hr_approval.php';
			
			//$records = $this->processor->get_resump_requests($user_id, 2015);
			$num3 = "";
			$main_title="Out of office";
			define('SIDE_MENU','templates/en_US/hr_leave_menu.php');
			define('MAIN_CONTENT','templates/en_US/'.$display);
			include('templates/en_US/main.php');
				}
				else{
			//$user_id = $_SESSION['user_id'];
			//$leave_dat = $this->processor->get_leave_requests($user_id);
			
			//This is to get the leave request numbers and name of person requesting
			//$id = $this->processor->get_request_id($user_id);
			//$leave_req_det = $id[0];
			//$name = $id[1];
			//$num = $id[2];
			
			$leave_req_dets = $this->processor->get_all_leave_requests($user_id, $yr);
			$leave_req_det = $leave_req_dets[0];
			// $num = $leave_req_dets[1];

			
			
			
			$d = $this->processor->out_of_office_requests($user_id);
			$num2 = $d[2];
			// $records = $this->processor->duty_resumption_requests($user_id);
			 //$d_num = $records[9];
			
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
			
			if(!$leave_req_det){
				$display = 'blank.php';
				}
				else {
				if(isset($_GET['usr_id'])){
					 $usr_id = isset($_GET['usr_id'])?$_GET['usr_id']:NULL;
					 $name12 = $this->processor->get_sup_det($usr_id);
					 $name4 = $name12[1];
					// $reply = $usr_id;
					 $days = $this->processor->get_days($usr_id);
					}
				$display = 'leave_approval.php';
				}
			//$records = $this->processor->get_resump_requests($user_id, 2015);
			$num3 = "";
			$main_title="Leave Requests and History";
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			define('MAIN_CONTENT','templates/en_US/'.$display);
			include('templates/en_US/main.php');
				}
				}
				
	if($request=='approv_two'){
				$comment="";
				$data="";
				$status="";
				$statu = "";
				$sup_name = $this->processor->get_supervisor($_SESSION['user_id']);
				$user_id = $_SESSION['user_id'];
				//$days = $this->processor->get_days($user_id);
				if($_SERVER['REQUEST_METHOD']=='POST'){
					if(isset($_POST['status'])){
					$comment = $_POST['comment'];
					$status = $_POST['status'];
					$leave_id = $_GET['lv_id'];
					$yr = $_GET['yr'];
						$data = $this->processor->update_status($user_id, $comment, $status, $leave_id);
						$name = $this->processor->get_sub_email($leave_id, $yr);
						$names = $this->processor->get_email($name);
		              	foreach($names as $names):
			            $email = $names->user_email;
			            endforeach;
						//$data = $email;
						$sup_copy_details = $this->processor->get_sup_lvcopy_det($leave_id);
						$copy = $sup_copy_details[0];
						$supsor_det = $sup_copy_details[1];
						$acting_sup = $sup_copy_details[2];
		
						if($status==2){
							$statu = "denied";
							$subject = "LEAVE REQUEST DENIED";
							} else $statu = "accepted";
							$subject = "LEAVE REQUEST APPROVED";
			            $body =  'Hello <br /> Your leave request has been <b> '.$statu.' </b> <br />Please log into the systen to view your request response details.<br /><a href="http://coegfsvtst-01/hrm">Baylor Intergrated Human Resource Information System</a><br /><br /> Thank you <br /><br /> BCM - Human Resource Information System';
			$email1="";
			$subject1 = "LEAVE REVIEW";
			      $body1 =  'Hello <br /> Please note, leave request has been<b> accepted by supervisor</b> <br />Please log into the system to view<br /><a href="https://hris.baylor-uganda.org">Baylor Intergrated Human Resource Information System</a><br /> Thank you <br /><br /> BCM - Human Resource Information System';
			  $this->send_email->send_email($email, $subject, $body);
			 // $this->send_email2->send_email($email1, $subject1, $body1);
					
				
					//$leave_data = $this->processor->get_leave_requests($user_id);
			$id = $this->processor->get_request_id2($user_id);
			$leave_req_det = $id[0];
			$name = $id[1];
			//$num = $id[2];
			
			$d = $this->processor->out_of_office_requests($user_id);
			$num2 = $d[2];
			// $records = $this->processor->duty_resumption_requests($user_id);
			// $d_num = $records[9];
			
           //  $records = $this->processor->get_resump_requests($user_id, 2015);
		   // $num3 = $records[14];
		   
		   	$leave_req_dets = $this->processor->get_all_leave_requests($user_id, $yr);
			$leave_req_det = $leave_req_dets[0];
			
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
			$form_title = 'Review subordinates leave requests and History';
			$main_title="Leave Requests and History";
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			define('MAIN_CONTENT','templates/en_US/leave_approval.php');
			include('templates/en_US/main.php');
					}
					}
				}
		
		if($request=='leave_history'){
		
		$hist_name = "";
		$sup_name = $this->processor->get_supervisor($_SESSION['user_id']);
			$user_id = $_SESSION['user_id'];
			$carry = $this->processor->get_carryover($user_id);
			$days_taken = $this->processor->get_requests($user_id);
			if(empty($days_taken)){
				$days_taken_annual = 0;
				}else{
			foreach($days_taken as $taken){
				$sum_days[] = $taken->leave_days;
				}
			$days_taken_annual	= array_sum($sum_days);
				}
			//$id = $this->processor->get_request_id($user_id);
			//$num = $id[2];
			$d = $this->processor->out_of_office_requests($user_id);
			$num2 = $d[2];
			$name1 = "";
			$aggr_leave = $this->processor->select_by_where('base_leave_balance','user_id', $user_id);
			$sum = $this->processor->get_compesatory_tacken($user_id);
			$days = $this->processor->get_days($user_id);
			$leave_data = $this->processor->get_leave_responses($user_id);
			if(!$leave_data){
				$display='leave_history.php';
				}
				else $display='leave_history.php';
				
			$records = $this->processor->get_resump_requests($user_id, 2015);
			 $num3 = $records[14];
			 
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
			 
			$main_title="Feed Back and History";
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			define('MAIN_CONTENT','templates/en_US/'.$display);
			include('templates/en_US/main.php');	
		}
		if($request=='approv_one'){
		        $comment="";
				$data="";
				$status="";
				$yr = $_GET['yr'];
				$form_title = 'Review subordinates leave requests and History';
				$sup_name = $this->processor->get_supervisor($_SESSION['user_id']);
				$user_id = $_SESSION['user_id'];
				if($_SERVER['REQUEST_METHOD']=='POST'){
					if(isset($_POST['status'])){
					$comment = $_POST['comment'];
					$status = $_POST['status'];
					$leave_id = $_GET['lv_id'];
					try{
						$data = $this->processor->approval_one($user_id, $comment, $status, $leave_id, $yr);
						if($status==3){
							$email="";
								$subject = "LEAVE REVIEW";
			            $body =  'Hello <br /> Please confirm the approval of leave request<b> accepted </b> <br />Please log into the system to Review<br /><a href="https://hris.baylor-uganda.org">Baylor Intergrated Human Resource Information System</a><br /> Thank you <br /><br /> BCM - Human Resource Information System';
			
			        $this->send_email->send_email($email, $subject, $body);
							}
							else if($status==2){
						$name = $this->processor->get_sub_email($leave_id, $yr);
						$names = $this->processor->get_email($name);
		              	foreach($names as $names):
			            $email = $names->user_email;
			            endforeach;
								$subject = "LEAVE REVIEW";
			            $body =  'Hello <br /> Your leave request has been <b>denied</b> <br />Please log into the systen to view your request response details<br /><a href="https://hris.baylor-uganda.org">Baylor Intergrated Human Resource Information System</a><br /> Thank you <br /><br /> Baylor College of Medicine Children\'s Foundation Uganda <br />Baylor Human Resource Information System';
			
			      $this->send_email->send_email($email, $subject, $body);
								
								
								}
						}catch (Exception $e){
							$data = $e->getmessage();
							}
					}
					//$leave_data = $this->processor->get_leave_requests($user_id);
			//$id = $this->processor->get_request_id($user_id);
			//$leave_req_det = $id[0];
			//$name = $id[1];
			//$num = $id[2];
			
				$leave_req_dets = $this->processor->get_all_leave_requests($user_id, $yr);
			$leave_req_det = $leave_req_dets[0];
			// $num = $leave_req_dets[1];
			
			$d = $this->processor->out_of_office_requests($user_id);
			$num2 = $d[2];
			// $records = $this->processor->duty_resumption_requests($user_id);
			// $d_num = $records[9];
			
			$sub_id = $this->processor->get_sub_email($leave_id, $yr);
           // $days = $this->processor->get_days($sub_id); 
			$name4="";
			$reply = "";
			
			//$records = $this->processor->get_resump_requests($user_id, 2015);
			//$num3 = $records[14];
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
			$main_title="Leave Requests and History";
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			define('MAIN_CONTENT','templates/en_US/leave_approval.php');
			include('templates/en_US/main.php');
				}
		}
		
	if($request=='out_reply'){
		        $comment="";
				$data="";
				$status="";
				
				$form_title = "Review subordinates out of office requests and History";
				$sup_name = $this->processor->get_supervisor($_SESSION['user_id']);
				$user_id = $_SESSION['user_id'];
				if($_SERVER['REQUEST_METHOD']=='POST'){
					if(isset($_POST['status'])){
					$comment = $_POST['comment'];
					$status = $_POST['status'];
					$out_id = $_GET['out_id'];
					try{
						$dat = $this->processor->out_approval($user_id, $comment, $status, $out_id);
						$data = $dat[0];
						$incharge_mail = $dat[1];
							$staff_id = $this->processor->get_out_user_id($out_id);
						$sub_email = $this->processor->get_email($staff_id);
						foreach($sub_email as $email1):
						$email3 = $email1->user_email;
						$name = '<b>'.$email1->user_firstname.' '.$email1->user_lastname.'</b>';
						endforeach;
						
						$sup_copy_details = $this->processor->get_sup_copy_det($out_id);
						$copy = $sup_copy_details[0];
						$supsor_det = $sup_copy_details[1];
						$acting_sup = $sup_copy_details[2];
					if($copy==2){
							$sup_data = $this->processor->get_sup_det($supsor_det);
							$sup_data_email = $sup_data[0];
							$sup_data_name = $sup_data[1];
							
							$act_sup_data = $this->processor->get_sup_det($acting_sup);
							$act_sup_data_email = $act_sup_data[0];
							$act_sup_data_name = $act_sup_data[1];
							
							$act_sup_data4 = $this->processor->get_sup_det($staff_id);
							$user_name12 = $act_sup_data4[1];
						if($status==3){
					$email1 = $sup_data_email;
					$subject1 = "OUT OF OFFICE APPROVAL";
			        $body1 =  'Hello, <br /> Out of office request for '.$user_name12.' was <b>accepted</b> by the acting supervisor '.$act_sup_data_name.'<br />Please log into the systen to view more details<br /><a href="https://hris.baylor-uganda.org">Baylor Intergrated Human Resource Information System</a><br /><br /> Thank you <br /><br /> BCM - Human Resource Information System';
					$this->send_email8 = new send_mail();
					  $this->send_email8->send_email($email1, $subject1, $body1);
						}else if($status==2){
					$email1 = $sup_data_email;
					
					//$records = $this->processor->get_resump_requests($user_id, 2015);
				   $num3 = '';
				   $staff48 = $this->processor->get_sup_requests($user_id);
	               $num4 = $staff48[8];
					$subject1 = "OUT OF OFFICE DENIAL";
			        $body1 =  'Hello <br /> Out of office request for '.$user_name12.' was <b>Denied</b> by the acting supervisor '.$act_sup_data_name.'<br />Please log into the systen to view more details<br /><a href="https://hris.baylor-uganda.org">Baylor Intergrated Human Resource Information System</a><br /><br /> Thank you <br /><br /> BCM - Human Resource Information System';
					$this->send_email8 = new send_mail();
					  $this->send_email8->send_email($email1, $subject1, $body1);
						}
					}
					
						if($status==3){
							$display = 'out_office_approval.php';
					$email1 = $email3;
					$subject1 = "OUT OF OFFICE APPROVAL";
			        $body1 =  'Hello, <br /> Out of office request has been <b>accepted</b> by the supervisor<br />Please log into the systen to view more details<br /><a href="https://hris.baylor-uganda.org">Baylor Intergrated Human Resource Information System</a><br /><br /> Thank you <br /><br /> BCM - Human Resource Information System';
					
					//$email2 = $incharge_mail;
					//$subject2= "OUT OF OFFICE APPROVAL";
				    //$body2 =  'Hello, <br /> Out of office request for '.$name.' has been <b>accepted by the supervisor <br />You are <b>delegated</b> to act on the officer\'s behalf<br /><br /> Thank you <br /><br /> BCM - Human Resource Information System';
			          $this->send_email->send_email($email1, $subject1, $body1);
					  //$this->send_email2 = new send_mail();
					  //$this->send_email2->send_email($email2, $subject2, $body2);
					  	$main_title="Out of office";
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			define('MAIN_CONTENT','templates/en_US/'.$display);
			include('templates/en_US/main.php');
							}
							else if($status==2){
								$display = 'out_office_approval.php';
						$staff_id = $this->processor->get_out_user_id($out_id);
						$sub_email = $this->processor->get_email($staff_id);
						foreach($sub_email as $email1):
						$email3 = $email1->user_email;
						endforeach;
								$subject = "OUT OF OFFICE DENIAL";
			            $body =  'Hello, <br /> Your Out of office request has been <b>denied</b> <br />Please log into the systen to view your request response details<br /><a href="https://hris.baylor-uganda.org">Baylor Intergrated Human Resource Information System</a><br /><br /> Thank you <br /><br />BCM - Human Resource Information System';
			     $this->send_email->send_email($email3, $subject, $body);
						$main_title="Out of office";
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			define('MAIN_CONTENT','templates/en_US/'.$display);
			include('templates/en_US/main.php');			
								
								}
						}catch (Exception $e){
							$data = $e->getmessage();
							}
					}
					//$leave_data = $this->processor->get_leave_requests($user_id);
			$id4 = $this->processor->get_request_id($user_id);
			$leave_req_det = $id4[0];
			$name = $id4[1];
			$num = $id4[2];
			
				
				$leave_req_dets = $this->processor->get_all_leave_requests($user_id);
		    	$leave_req_det = $leave_req_dets[0];
			
			$d = $this->processor->out_of_office_requests($user_id);
			$details = $d[0];
			$name = $d[1];
			$num2 = $d[2];
			if(!$details){
				$display = 'blank.php';
				}
				else 
				$display = 'out_office_approval.php';

             //$records = $this->processor->get_resump_requests($user_id, 2015);
			$num3 = '';
			
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
			
			$main_title="Out of office";
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			define('MAIN_CONTENT','templates/en_US/'.$display);
			include('templates/en_US/main.php');
				}
		}
		
	if($request=='out_office_requests'){
			
			$form_title = "Review subordinates out of office requests and History";
			$sup_name = $this->processor->get_supervisor($_SESSION['user_id']);
			$data="";
			$user_id = $_SESSION['user_id'];
			//$id = $this->processor->get_request_id($user_id);
		   // $num = $id[2];
			//$leave_dat = $this->processor->get_leave_requests($user_id);
			
			//This is to get the leave request numbers and name of person requesting
			$d = $this->processor->out_of_office_requests($user_id);
			$details = $d[0];
			$name = $d[1];
			$num2 = $d[2];
			if(!$details){
				$display = 'blank.php';
				}
				else $display = 'out_office_approval.php';
			
			$records = $this->processor->get_resump_requests($user_id, 2015);
			$num3 = $records[14];
			
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
			
			$main_title="Out of office";
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			define('MAIN_CONTENT','templates/en_US/'.$display);
			include('templates/en_US/main.php');
		}
	if($request=='out_of_office'){
			
			$sup_name = $this->processor->get_supervisor($_SESSION['user_id']);
		    $data ="";
			$ot="";
		    $user_id = $_SESSION['user_id'];
			$d = $this->processor->out_of_office_requests($user_id);
			$num2 = $d[2];
		   // $id = $this->processor->get_request_id($user_id);
		   // $num = $id[2];
		    //$user_id = $_SESSION['user_id'];
			//$leave_data = $this->processor->get_leave_responses($user_id);
			$staff = $this->processor->get_users();
			$out2 = $this->processor->get_days($user_id);
			
			foreach($out2 as $out_in):    
            $ot = $out_in->in_out;
            endforeach; 
            if($ot==2){
				 $pub_days = $this->processor->pub_hol();
				$display = "out_of_office.php";
	        }else {
				 $pub_days = $this->processor->pub_hol();
			   	$display = "out_of_office.php";
			}
			
			$records = $this->processor->get_resump_requests($user_id, 2015);
		    $num3 = $records[14];
			
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
			
			$main_title="Out of Office Form";
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			define('MAIN_CONTENT','templates/en_US/'.$display);
			include('templates/en_US/main.php');
		}
		
	//getting out of office requests
	
	if($request=='back_in_office'){
		
		$sup_name = $this->processor->get_supervisor($_SESSION['user_id']);
		    $data ="";
		    $user_id = $_SESSION['user_id'];
		  //  $id = $this->processor->get_request_id($user_id);
		   // $num = $id[2];
			
			$d = $this->processor->out_of_office_requests($user_id);
			$num2 = $d[2];
			
		    $user_id = $_SESSION['user_id'];
			$leave_data = $this->processor->back_in_office($user_id);
			$staff = $this->processor->get_users();
			$out = $this->processor->get_days($user_id);
		    $pub_days = $this->processor->pub_hol();
			
			$records = $this->processor->get_resump_requests($user_id, 2015);
		    $num3 = $records[14];
			
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
			
			$main_title="Out of Office Form";
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			define('MAIN_CONTENT','templates/en_US/out_of_office.php');
			include('templates/en_US/main.php');
		}
	//back in office for leave
		if($request=='back_in_office2'){
		
		    $data ="";
		    $user_id = $_SESSION['user_id'];
		 //   $id = $this->processor->get_request_id($user_id);
		  //  $num = $id[2];
			
			$d = $this->processor->out_of_office_requests($user_id);
			$num2 = $d[2];
			$main_title="Leave Management";
			$form_title = "Leave Form";
		    $user_id = $_SESSION['user_id'];
			$leave_data = $this->processor->back_in_office($user_id);
			$staff = $this->processor->get_users();
			$out = $this->processor->get_days($user_id);
		    $pub_days = $this->processor->pub_hol();
			
			$records = $this->processor->get_resump_requests($user_id, 2015);
		    $num3 = $records[14];
			
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
			
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			define('MAIN_CONTENT','templates/en_US/leave_form.php');
			include('templates/en_US/main.php');
		}
		
	if($request=='out_of_office_request'){
		$data = "";
			
			$sup_name = $this->processor->get_supervisor($_SESSION['user_id']);
				$user_id = $_SESSION['user_id'];
			//	$id = $this->processor->get_request_id($user_id);
		//    $num = $id[2];
			
			$d = $this->processor->out_of_office_requests($user_id);
			$num2 = $d[2];
			
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
			
				if($_SERVER['REQUEST_METHOD']=='POST'){
					$date_one = $_POST['date1'];
					$date_two = $_POST['date2'];
					//$days = $_POST['days'];
					$in_charge = $_POST['in_charge'];
					$comment = $_POST['comment'];
					$date1 = date_format(date_create($date_one), 'm/d/Y');
			        $date2 = date_format(date_create($date_two), 'm/d/Y');
					$isweekend2 = $this->processor->isWeekend($date1);
		         	$isweekend3 = $this->processor->isWeekend($date2);
		        	$pub_day4 = $this->processor->is_pub($date1);
		        	$pub_day5 = $this->processor->is_pub($date2);
					
					
				if(($date_one > $date_two)||(empty($date_one)||empty($date_two))){
			$data = '<div class="alert alert-warning"><a class="close" data-dismiss="alert">×</a>'.'Please correct your start and end dates. Note: Your end date should be greater than the start date and they should not be empty'.'</div>';
		    $staff = $this->processor->get_users();
		   // $id = $this->processor->get_request_id($user_id);
		    //$num = $id[2];
			$d = $this->processor->out_of_office_requests($user_id);
			$num2 = $d[2];
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
			$pub_days = $this->processor->pub_hol();
			$main_title="Out of Office Form";
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			define('MAIN_CONTENT','templates/en_US/out_of_office.php');
			include('templates/en_US/main.php');
			// elseif($pub_day1==1||$pub_day2==1){
		}elseif(($pub_day4==1)||($pub_day5==1)){
				$data = '<div class="alert alert-warning"><a class="close" data-dismiss="alert">×</a>'.'Please correct your start and end dates. Note: Public holidays should not be filled in'.'</div>';
				$staff = $this->processor->get_users();
		   // $id = $this->processor->get_request_id($user_id);
		   // $num = $id[2];
			$d = $this->processor->out_of_office_requests($user_id);
			$num2 = $d[2];
			$pub_days = $this->processor->pub_hol();
			
			$records = $this->processor->get_resump_requests($user_id, 2015);
			$num3 = $records[14];
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
			$main_title="Out of Office Form";
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			define('MAIN_CONTENT','templates/en_US/out_of_office.php');
			include('templates/en_US/main.php');	
					}
	              elseif (($isweekend2==1)||($isweekend3==1)){  
					  			$data = '<div class="alert alert-warning"><a class="close" data-dismiss="alert">×</a>'.'Please correct your start and end dates. Note: Weekends should not be filled in'.'</div>';
				$staff = $this->processor->get_users();
		  //  $id = $this->processor->get_request_id($user_id);
		   // $num = $id[2];
			$d = $this->processor->out_of_office_requests($user_id);
			$num2 = $d[2];
			$pub_days = $this->processor->pub_hol();
			$main_title="Out of Office Form";
			
			$records = $this->processor->get_resump_requests($user_id, 2015);
			 $num3 = $records[14];
			 $staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			define('MAIN_CONTENT','templates/en_US/out_of_office.php');
			include('templates/en_US/main.php');	
					  }
				  else  {
					try{
			//$data = $in_charge;
			$data = $this->processor->out_of_office_request($user_id, $date_one, $date_two, $in_charge, $comment);
		$supervisor_id1 = $this->processor->get_id($user_id);
		//$supervisor_id = ($supervisor_id1 != NULL)?"'".mysql_real_escape_string($supervisor_id1)."'":'NULL';
		$sup_email = $this->processor->get_email($supervisor_id1);
		foreach ($sup_email as $s_email):
		$su_email = $s_email->user_email;
		endforeach;
		                //$email =     $su_email;
						$subject = "OUT OF OFFICE REQUEST";
						$from_name = '<b>'.$_SESSION['firstname'].' '.$_SESSION['lastname'].'</b>';
			            $body =  'Hello, <br /> '.$from_name.' has submitted an out of office request. <br />Please log into the systen to Review<br /><a href="https://hris.baylor-uganda.org">Baylor Intergrated Human Resource Information System</a><br /><br /> Thank you <br /><br /><br />BCM - Human Resource Information System';
			
		$this->send_email->send_email($su_email, $subject, $body);
					
			$staff = $this->processor->get_users();
			$pub_days = $this->processor->pub_hol();
			unset($_SESSION['sup_id']);
			
			$records = $this->processor->get_resump_requests($user_id, 2015);
			$num3 = $records[14];
			
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
				 
			$main_title="Out of Office Form";
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			define('MAIN_CONTENT','templates/en_US/out_of_office.php');
			include('templates/en_US/main.php');
					}catch (Exception $e){
		    $data = $e->getmessage();
		    $staff = $this->processor->get_users();
		    //$id = $this->processor->get_request_id($user_id);
		   // $num = $id[2];
			$d = $this->processor->out_of_office_requests($user_id);
			$num2 = $d[2];
			$pub_days = $this->processor->pub_hol();
			
			$records = $this->processor->get_resump_requests($user_id, 2015);
			$num3 = $records[14];
			
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
			
			$main_title="Out of Office Form";
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			define('MAIN_CONTENT','templates/en_US/out_of_office.php');
			include('templates/en_US/main.php');
				 }
				}
		     }
		}
		
		/*  ---------------  */
//view supervisor staff
  if($request == "view_staff"){
	 $form_title = "View Subordinates";
	$data = "";
    
	$main_title="Staff list";
	  $user_id = $_SESSION['user_id'];
	  $sup_name = $this->processor->get_supervisor($_SESSION['user_id']);
	 // $id = $this->processor->get_request_id($user_id);
	//  $num = $id[2];
	  $d = $this->processor->out_of_office_requests($user_id);
	  $num2 = $d[2];
	  // $records = $this->processor->duty_resumption_requests($user_id);
	   //$d_num = $records[9];
			
	/*  $users = $this->processor->get_sup_staff($user_id);
	  $name = $users[0];
	  $position = $users[1];
	  $staff_id = $users[2];
	  $lv_schd = $users[3];
	  $status = $users[4];
	  $sch_id = $users[5];
	  
	  */
	  $sup_leave_staff = $this->processor->sup_leave_staff($user_id);
	  $staff_name = $sup_leave_staff[0];
	  $staff_annual = $sup_leave_staff[1];
	  $staff_sick = $sup_leave_staff[2];
	  $compasionate = $sup_leave_staff[3];
	  $compes = $sup_leave_staff[4];
	  $carry = $sup_leave_staff[5];
	  
	  $staff_sched = $this->processor->select_staf_schd($user_id);
	  	  
	 $staff48 = $this->processor->get_sup_requests($user_id);
	 $num4 = $staff48[8];
			
	define('SIDE_MENU','templates/en_US/leave_menu.php');
	define('MAIN_CONTENT','templates/en_US/sup_leave_staff.php');
	include('templates/en_US/main.php');
	}
//view leave request history
if($request == "staff_details"){
	
	$user_id = $_SESSION['user_id'];
	// $id = $this->processor->get_request_id($user_id);
	 // $num = $id[2];
	  $d = $this->processor->out_of_office_requests($user_id);
	  $num2 = $d[2];
	$user_id2 = $_GET['id'];
	  $users = $this->processor->get_sup_det($user_id2);
	  $name1 = $users[1];
	
	$days = $this->processor->get_days($user_id2);
			$leave_data = $this->processor->get_leave_responses($user_id2);
			if(!$leave_data){
				$display='leave_history.php';
				}
				else $display='leave_history.php';
				
			$records = $this->processor->get_resump_requests($user_id, 2015);
		    $num3 = $records[14];
			
			$staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
			
			$main_title="Feed Back and History";
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			define('MAIN_CONTENT','templates/en_US/'.$display);
			include('templates/en_US/main.php');
	}
//duty resumption form: form used when called back from leave
if($request=='resumption_form'){
	
	$data = "";
	$sup_name = $this->processor->get_supervisor($_SESSION['user_id']);
	$pub_days = $this->processor->pub_hol();
/* start getting leave and out of office requests  */
	$user_id = $_SESSION['user_id'];
	//$id = $this->processor->get_request_id($user_id);
	//$num = $id[2];
    $d = $this->processor->out_of_office_requests($user_id);
	$num2 = $d[2];
/* end getting leave and out of office requests  */
    $records = $this->processor->get_leave_record($user_id);
	$leave_type = $records[0];
	$days = $records[1];
	$start = $records[2];
	$end = $records[3];
	$leav_id = $records[4];
	
	$records = $this->processor->get_resump_requests($user_id, 2015);
	$num3 = $records[14];
	
	$staff48 = $this->processor->get_sup_requests($user_id);
	 $num4 = $staff48[8];
			
	$main_title="Duty Resumption";
	$form_title="Duty Resumption Form";
	define('SIDE_MENU','templates/en_US/leave_menu.php');
	define('MAIN_CONTENT','templates/en_US/resumption_form.php');
	include('templates/en_US/main.php');
	}
if($request=='leave_resumption'){
	
	$sup_name = $this->processor->get_supervisor($_SESSION['user_id']);
	$pub_days = $this->processor->pub_hol();
/* start getting leave and out of office requests  */
	$user_id = $_SESSION['user_id'];
	//$id = $this->processor->get_request_id($user_id);
	//$num = $id[2];
    $d = $this->processor->out_of_office_requests($user_id);
	$num2 = $d[2];
	$staff48 = $this->processor->get_sup_requests($user_id);
	 $num4 = $staff48[8];
/* end getting leave and out of office requests  */
    $records = $this->processor->get_leave_record($user_id);
	$leave_type = $records[0];
	$days = $records[1];
	$start = $records[2];
	$end = $records[3];
	$leav_id = $records[4];
	
	
	//getting supervisor id and email
			$supervisor_id = $this->processor->get_id($user_id);
			$names = $this->processor->get_email($supervisor_id);
			foreach($names as $names):
			$email = $names->user_email;
			endforeach;
			
			
			
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$leave_id = $_POST['leave_id'];
			$date1 = $_POST['date1'];
			$date2 = $_POST['date2']; 
			if(($date1 > $date2)){
			$data = '<div class="alert alert-warning"><a class="close" data-dismiss="alert">×</a>'.'Please correct your From and To dates. Note: Your end date should be greater than the start date'.'</div>';
			}else {
		if(isset($_POST['leave_check'])&&isset($_POST['pub_check'])){
			/*calculations for number of days   */
			$newDate1 = date("Y-m-d H:i:s", strtotime($date1));
			$newDate2 = date("Y-m-d H:i:s", strtotime($date2));
			$date_start = new DateTime($newDate1);
	     	$date_end = new DateTime($newDate2);
	    	$date_1 = $date_start->format('m/d/Y');
		    $date_2 = $date_end->format('m/d/Y');
		
		    $t1 = $date_start->format('H:i');
		    $t2 = $date_end->format('H:i');
			
			if($date1==$date2){
		$no_days = count($this->processor->get_dates($date1,$date2));
			}else if(($date_1==$date_2)&&($t1!=$t2)){
			$hrs = strtotime($t2)-strtotime($t1);
		    $no_days = ($hrs/3600)/24;	
			}else {
		$hrs = strtotime($t2)-strtotime($t1);
		$hr_days = ($hrs/3600)/24;
		$no_days = $this->processor->get_dates($date1, $date2);
		$pub_hols = $this->processor->pub_hol();
		$real_days = array_diff($no_days, $pub_hols);
		$no_days = count($real_days)+$hr_days;
				}
			
			
			$pub_hol = $_POST['pub_hol'];
			$days2 = $_POST['days'];
			$days = $no_days+$days2;
			$comment = $_POST['comment'];
			$type = 3;
			$data = $this->processor->resuption_submit($user_id, $leave_id, $newDate1, $newDate2, $pub_hol, $days, $comment, $type);
			$subject = "LEAVE RESUMPTION REQUEST";
			if($days>1){$day_type= 'days';}else { $day_type='day';}
			$body = 'Hello, <br />'. $_SESSION['firstname'].' '.$_SESSION['lastname'].' has requested<b> leave resumption </b>for '.$days.' '.$day_type.'<br /><br /> Please login to Baylor HR System to review the request.<br />
			<a href="https://hris.baylor-uganda.org">Baylor Intergrated Human Resource Information System</a>
			<br /><br />
			 Thank you <br /><br /> BCM - Human Resource Information System';
			 $this->send_email->send_email($email, $subject, $body);
			}else if(isset($_POST['leave_check'])){
			$leave_id = $_POST['leave_id'];
			$date1 = $_POST['date1'];
			$date2 = $_POST['date2'];
			$pub_hol = '';
			/* calculations for the days   */
			$newDate1 = date("Y-m-d H:i:s", strtotime($date1));
			$newDate2 = date("Y-m-d H:i:s", strtotime($date2));
			$date_start = new DateTime($newDate1);
	     	$date_end = new DateTime($newDate2);
	    	$date_1 = $date_start->format('m/d/Y');
		    $date_2 = $date_end->format('m/d/Y');
		
		    $t1 = $date_start->format('H:i');
		    $t2 = $date_end->format('H:i');
			
			if($date1==$date2){
		$no_days = count($this->processor->get_dates($date1,$date2));
			}else if(($date_1==$date_2)&&($t1!=$t2)){
			$hrs = strtotime($t2)-strtotime($t1);
		    $no_days = ($hrs/3600)/24;	
			}else {
		$hrs = strtotime($t2)-strtotime($t1);
		$hr_days = ($hrs/3600)/24;
		$no_days = $this->processor->get_dates($date1, $date2);
		$pub_hols = $this->processor->pub_hol();
		$real_days = array_diff($no_days, $pub_hols);
		$no_days = count($real_days)+$hr_days;
				}
		/* end of calculations for the days   */
		
			$comment = $_POST['comment'];
			$type = 1;
			$data = $this->processor->resuption_submit($user_id, $leave_id, $newDate1, $newDate2, $pub_hol, $no_days, $comment, $type);
				$subject = "LEAVE RESUMPTION REQUEST";
			if($no_days>1){$day_type= 'days';}else { $day_type='day';}
				$body = 'Hello, <br />'. $_SESSION['firstname'].' '.$_SESSION['lastname'].' has requested<b> leave resumption </b>for '.$no_days.' '.$day_type.'<br /><br /> Please login to Baylor HR System to review the request.<br />
			<a href="https://hris.baylor-uganda.org">Baylor Intergrated Human Resource Information System</a>
			<br /><br />
			 Thank you <br /><br /> BCM - Human Resource Information System';
			 $this->send_email->send_email($email, $subject, $body);
			}
			else if(isset($_POST['pub_check'])){
			$leave_id = "";
			$pub_hol = $_POST['pub_hol'];
			$newDate1 = "";
			$newDate2 = "";
			$days = $_POST['days'];
			$comment = $_POST['comment'];
			$type  = 2;
			$data = $this->processor->resuption_submit($user_id, $leave_id, $newDate1, $newDate2, $pub_hol, $days, $comment, $type);
				
				$subject = "LEAVE RESUMPTION REQUEST";
			if($days>1){$day_type= 'days';}else { $day_type='day';}
				$body = 'Hello, <br />'. $_SESSION['firstname'].' '.$_SESSION['lastname'].' has requested<b> leave resumption </b>for '.$days.' '.$day_type.'<br /><br /> Please login to Baylor HR System to review the request.<br />
			<a href="https://hris.baylor-uganda.org">Baylor Intergrated Human Resource Information System</a>
			<br /><br />
			 Thank you <br /><br /> BCM - Human Resource Information System';
			 $this->send_email->send_email($email, $subject, $body);
			}
				}
		}
	$records = $this->processor->get_resump_requests($user_id, 2015);
    $num3 = $records[14];	
	$main_title="Duty Resumption";
	$form_title="Duty Resumption Form";
	define('SIDE_MENU','templates/en_US/leave_menu.php');
	define('MAIN_CONTENT','templates/en_US/resumption_form.php');
	include('templates/en_US/main.php');
	
	}
	
if($request=='resumption_feedback'){
	
	$form_title = "Leave resumption request feedback and History";
	$data = "";
		$year_id = $_GET['yr_id'];
	$sup_name = $this->processor->get_supervisor($_SESSION['user_id']);
	$pub_days = $this->processor->pub_hol();
/* start getting leave and out of office requests  */
	$user_id = $_SESSION['user_id'];
	//$id = $this->processor->get_request_id($user_id);
	//$num = $id[2];
    $d = $this->processor->out_of_office_requests($user_id);
	$num2 = $d[2];
	$staff48 = $this->processor->get_sup_requests($user_id);
	$num4 = $staff48[8];
/* end getting leave and out of office requests  */
    $records = $this->processor->get_resump_feedback($user_id, $year_id);
	$leave_type = $records[0];
	$start = $records[1];
	$end = $records[2];
	$public_holiday = $records[3];
	$days = $records[4];
	$comment = $records[5];
	$status = $records[6];
	$date1 = $records[7];
	$sup_comment = $records[8];
	$leav_types = $records[9];
	$leav_start = $records[10];
	$leav_end = $records[11];
	$id2 = $records[12];
	$type = $records[13];
	
	$records = $this->processor->get_resump_requests($user_id, 2015);
				 $num3 = $records[14];
	$display = 'resumption_feedback.php';
	$main_title="Duty Resumption";
	define('SIDE_MENU','templates/en_US/leave_menu.php');
	define('MAIN_CONTENT','templates/en_US/'.$display);
	include('templates/en_US/main.php');
	}
if($request=='resumption_yrs'){
	
	$user_id = $_SESSION['user_id'];
		$sup_name = $this->processor->get_supervisor($user_id);
	  //  $id = $this->processor->get_request_id($user_id);
	   // $num = $id[2];
	    $d = $this->processor->out_of_office_requests($user_id);
	    $num2 = $d[2];
	    $staff48 = $this->processor->get_sup_requests($user_id);
	    $num4 = $staff48[8];
		$records = $this->processor->get_resump_requests($user_id, 2015);
				 $num3 = $records[14];
	$years = $this->processor->view_years();
	$main_title="Choose year";
	define('SIDE_MENU','templates/en_US/leave_menu.php');
	define('MAIN_CONTENT','templates/en_US/resup_years.php');
	include('templates/en_US/main.php');
	}
if($request=='resumption_feedback_yrs'){
	
	$user_id = $_SESSION['user_id'];
		$sup_name = $this->processor->get_supervisor($user_id);
	    //$id = $this->processor->get_request_id($user_id);
	   // $num = $id[2];
	    $d = $this->processor->out_of_office_requests($user_id);
	    $num2 = $d[2];

	    $staff48 = $this->processor->get_sup_requests($user_id);
	    $num4 = $staff48[8];
		$records = $this->processor->get_resump_requests($user_id, 2015);
				 $num3 = $records[14];
	$years = $this->processor->view_years();
	$main_title="Choose year";
	define('SIDE_MENU','templates/en_US/leave_menu.php');
	define('MAIN_CONTENT','templates/en_US/resup_fb_yrs.php');
	include('templates/en_US/main.php');
	}
if($request=='resumption_requests'){
			
			$reply = "";
			$year_id = $_GET['yr_id'];
			$sup_name = $this->processor->get_supervisor($_SESSION['user_id']);
			$data="";
			$user_id = $_SESSION['user_id'];
			// $id = $this->processor->get_request_id($user_id);
		  //  $num = $id[2];
			  $d = $this->processor->out_of_office_requests($user_id);
	          $num2 = $d[2];
			  $staff48 = $this->processor->get_sup_requests($user_id);
	        $num4 = $staff48[8];
			$years = $this->processor->view_years();
			//$leave_dat = $this->processor->get_leave_requests($user_id);
			
		/* end getting leave and out of office requests  */
    $records = $this->processor->get_resump_requests($user_id, $year_id);
	$record_id = $records[0];
	$start = $records[1];
	$end = $records[2];
	$pub_hol = $records[3];
	$days = $records[4];
	$comment = $records[5];
	$sup_comment = $records[6];
	$status = $records[7];
	$firstname = $records[8];
	$lastname = $records[9];
	$email = $records[10];
	$leave = $records[11];
	$leave_start_date = $records[12];
	$leave_end_date = $records[13];
	$num3 = $records[14];
			if(!$record_id){
				$display = 'blank.php';
				}
				else $display = 'resumption_approval.php';
			
			$main_title="Leave Resumption requests and History";
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			define('MAIN_CONTENT','templates/en_US/'.$display);
			include('templates/en_US/main.php');
		}
		
		
		
		if($request=='review_resup'){
			
			$data = "LEAVE RESUMPTION HAS BEEN CLOSED OFF UNTIL FURTHER NOTICE";
			/*$user_id = $_SESSION['user_id'];
				$sup_name = $this->processor->get_supervisor($user_id);
				if($_SERVER['REQUEST_METHOD']=='POST'){
					if(isset($_POST['status'])){
					$comment = $_POST['comment'];
					$status = $_POST['status'];
					$days = $_POST['days'];
					$record_id = $_GET['lv_id'];
					$lv_type = $_POST['leave_type'];
					$sub_user_id = $this->processor->leave_resump_userid($record_id);
					$sub_email1 = $this->processor->get_sup_det($sub_user_id);
			          $sub_email = $sub_email1[0];
					try{
						//$data = $this->processor->approve_resup($comment, $status, $record_id, $days, $sub_user_id, $lv_type);
						if($status==3){
						$sub_name = $this->processor->get_sup_det($sub_user_id);
						$sub_names = $sub_name[1];
						if($days>1){
							$day_type = 'days';
							}else { 
							$day_type='day';
							}
						$email="";
						$subject = "LEAVE RESUMPTION APPROVED";
			            $body =  'Hello <br />Leave resumption requested by '.$sub_names.' for '.$days.' '.$day_type.' has been <b>approved </b> <br />Please log into the system to Review<br /><a href="https://hris.baylor-uganda.org">Baylor Intergrated Human Resource Information System</a><br /> Thank you <br /><br /> BCM - Human Resource Information System';
			            $body2 =  'Hello <br /> Your leave resumption request has been <b>Accepted</b> <br />Please log into the systen to view your request response details<br /><a href="https://hris.baylor-uganda.org">Baylor Intergrated Human Resource Information System</a><br /> Thank you <br /><br /> Baylor College of Medicine Children\'s Foundation Uganda <br />Baylor Human Resource Information System';
			        $this->send_email->send_email($email, $subject, $body);
					$this->send_email->send_email($sub_email, $subject, $body2);
							}
							else if($status==2){
						//$name = $this->processor->get_sub_email($leave_id);
						
						$subject = "LEAVE RESUMPTION DENIED";
			            $body =  'Hello <br /> Your leave resumption request has been <b>denied</b> <br />Please log into the systen to view your request response details<br /><a href="https://hris.baylor-uganda.org">Baylor Intergrated Human Resource Information System</a><br /> Thank you <br /><br /> Baylor College of Medicine Children\'s Foundation Uganda <br />Baylor Human Resource Information System';
			
			      $this->send_email->send_email($sub_email, $subject, $body, $days);
								
								
								}
						}catch (Exception $e){
							$data = $e->getmessage();
							}
					}
					//$leave_data = $this->processor->get_leave_requests($user_id);
		//	$id = $this->processor->get_request_id($user_id);
			//$leave_req_det = $id[0];
			//$name = $id[1];
			//$num = $id[2];
			
			$d = $this->processor->out_of_office_requests($user_id);
			$num2 = $d[2];
		//	$sub_id = $this->processor->get_sub_email($leave_id);
           // $days = $this->processor->get_days($sub_id); 
			$name4="";
			$reply = "";
	
	$staff48 = $this->processor->get_sup_requests($user_id);
	$num4 = $staff48[8];
			
	$records = $this->processor->get_resump_requests($user_id, 2015);
	$record_id = $records[0];
	$start = $records[1];
	$end = $records[2];
	$pub_hol = $records[3];
	$days = $records[4];
	$comment = $records[5];
	$sup_comment = $records[6];
	$status = $records[7];
	$firstname = $records[8];
	$lastname = $records[9];
	$email = $records[10];
	$leave = $records[11];
	$leave_start_date = $records[12];
	$leave_end_date = $records[13];
	$num3 = $records[14];
			if(!$record_id){
				$display = 'blank.php';
				}
				else $display = 'resumption_approval.php';
			*/
			$main_title="Leave resumption";
			define('SIDE_MENU','templates/en_US/leave_menu.php');
			define('MAIN_CONTENT','templates/en_US/resumption_approval.php');
			include('templates/en_US/main.php');
			}
//request form
//request form
if($request=='xtra_day_form'){
	$data = "";
	$form_title = "Request staff to work extra day";
	$user_id = $_SESSION['user_id'];
	$sup_name = $this->processor->get_supervisor($user_id);
  //  $id = $this->processor->get_request_id($user_id);
   // $num = $id[2];
    $d = $this->processor->out_of_office_requests($user_id);
	$num2 = $d[2];
	$staff48 = $this->processor->get_sup_requests($user_id);
	$num4 = $staff48[8];		
	$staff = $this->processor->get_sup_staff2($user_id);
	$usr_id = $staff[0];
	$f_name = $staff[1];
	$l_name = $staff[2];
	$main_title="Leave Resumption requests and History";
	define('SIDE_MENU','templates/en_US/leave_menu.php');
	define('MAIN_CONTENT','templates/en_US/extra_day_form.php');
	include('templates/en_US/main.php');
      }
//make request to staff
if($request=='xtra_day_request'){
		
			$user_id = $_SESSION['user_id'];
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$user_id1 = $_POST['usrid'];
		$days = $_POST['days'];
		$reason = $_POST['reason'];
	   foreach($user_id1 as $uid){
		    $dat = $this->processor->request_extra_day($uid, $days, $reason);
		   $email = $this->processor->get_sup_det($uid);
		   $emails[] = $email[0];
		   }
		$d = explode(",",$days);
		$days_num = count($d);
	$subject = "EXTRA WORK DAY REQUEST";
			if($days_num>1){$day_type= 'days';}else { $day_type='day';}
			$body = 'Hello, <br /> Your supervisor has requested you to work extra </b>for <b>'.$days_num.' '.$day_type.' on '. $days.'<br /><br /> Please login to Baylor HR System to review the request.<br />
			<a href="https://hris.baylor-uganda.org">Baylor Intergrated Human Resource Information System (INTERNAL LINK)</a>
			<br />	<a href="https://hris.baylor-uganda.org/hrm">Baylor Intergrated Human Resource Information System (EXTERNAL LINK)</a>
			<br /><br />
			 Thank you <br /><br /> BCM - Human Resource Information System';
				 foreach($emails as $em){
		$this->send_email3 = new send_mail();
		$this->send_email3->send_email($em, $subject, $body);	 
	}

	if($dat==1){
		$data = $this->success(" Request successfully processed");
		}else {
			$data = $this->error(" Request not processed");
			}
	$form_title = "Request staff to work extra day";
	$sup_name = $this->processor->get_supervisor($user_id);
   // $id = $this->processor->get_request_id($user_id);
   // $num = $id[2];
    $d = $this->processor->out_of_office_requests($user_id);
	$num2 = $d[2];
			
	$records = $this->processor->get_resump_requests($user_id, 2015);
	$num3 = $records[14];
	$staff48 = $this->processor->get_sup_requests($user_id);
	$num4 = $staff48[8];
	$staff = $this->processor->get_sup_staff2($user_id);
	$usr_id = $staff[0];
	$f_name = $staff[1];
	$l_name = $staff[2];
	$main_title="Leave Resumption requests and History";
	define('SIDE_MENU','templates/en_US/leave_menu.php');
	define('MAIN_CONTENT','templates/en_US/extra_day_form.php');
	include('templates/en_US/main.php');
	}
	}
	
//get supervisor requests
if($request=='supervis_req'){
	
	$data = "";
	$form_title = "Requests to work extra days";
	$user_id = $_SESSION['user_id'];
	$sup_name = $this->processor->get_supervisor($user_id);
  //  $id = $this->processor->get_request_id($user_id);
  //  $num = $id[2];
    $d = $this->processor->out_of_office_requests($user_id);
	$num2 = $d[2];
	$staff = $this->processor->get_sup_requests($user_id);
	$usr_id = $staff[0];
	$days = $staff[1];
	$dates = $staff[2];
	$reason = $staff[3];
	$status = $staff[4];
	$num4 = $staff[8];
	$main_title="Requests to work extra days";
	define('SIDE_MENU','templates/en_US/leave_menu.php');
	define('MAIN_CONTENT','templates/en_US/extra_day_requests.php');
	include('templates/en_US/main.php');
	}
//work day request feedback
if($request=='xtra_reply'){
	
			$data = "";
			$form_title = "Requests to work extra days";
			$user_id = $_SESSION['user_id'];
				$sup_name = $this->processor->get_supervisor($user_id);
					//getting supervisor id and email
			$email1 = $this->g_var[3];

				if($_SERVER['REQUEST_METHOD']=='POST'){
					if(isset($_POST['status'])){
					$comment = $_POST['comment'];
					$status = $_POST['status'];
					$days = $_POST['days'];
					$req_id = $_GET['req_id'];
					
					try{
						$data = $this->processor->approve_xtra_req($comment, $status, $days, $req_id, $user_id);
						if($status==3){
						if($days>1){
							$day_type = 'days';
							}else { 
							$day_type='day';
							}
						$user_firstname = $_SESSION['firstname'];
						$user_lastname = $_SESSION['lastname'];
						$email="";
						$subject = "ACCEPTED EXTRA WORK DAYS";
			            $body =  'Hello <br /> '.$user_firstname.' '.$user_lastname.' has <b>Accepted to work extra'.$days.' '.$day_type.' as requested by the supervisor</b> <br />Please log into the system for more details<br /><a href="https://hris.baylor-uganda.org">Baylor Intergrated Human Resource Information System</a><br /> Thank you <br /><br /> BCM - Human Resource Information System';
			           $body2 =  'Hello <br /> '.$user_firstname.' '.$user_lastname.' has <b>Accepted to work extra'.$days.' '.$day_type.' </b> <br />Please log into the system for more details<br /><a href="https://hris.baylor-uganda.org">Baylor Intergrated Human Resource Information System (INTERNAL LINK)</a><br /> Thank you <br /><a href="https://hris.baylor-uganda.org/hrm">Baylor Intergrated Human Resource Information System (EXTERNAL LINK)</a><br /> Thank you <br /><br /> BCM - Human Resource Information System';
			        $this->send_email->send_email($email, $subject, $body);
					$this->send_email->send_email($email1, $subject, $body2);
							}
							else if($status==2){
						//$name = $this->processor->get_sub_email($leave_id);
						
						$subject = "EXTRA WORK DAYS DENIED";
			            $body =  'Hello <br /> '.$user_firstname.' '.$user_lastname.' <b> has denied request to work on extra </b> <br />Please log into the systen to view your request response details<br /><a href="https://hris.baylor-uganda.org">Baylor Intergrated Human Resource Information System</a><br /> Thank you <br /><br /> Baylor College of Medicine Children\'s Foundation Uganda <br />Baylor Human Resource Information System';
			
			      $this->send_email->send_email($sub_email, $subject, $body, $days);
								
								
								}
						}catch (Exception $e){
							$data = $e->getmessage();
							}
					}
					//$leave_data = $this->processor->get_leave_requests($user_id);
			$id = $this->processor->get_request_id($user_id);
			$leave_req_det = $id[0];
			$name = $id[1];
		//	$num = $id[2];
				$records = $this->processor->get_resump_requests($user_id, 2015);
	$num3 = $records[14];
			$d = $this->processor->out_of_office_requests($user_id);
			$num2 = $d[2];
			
		//	$sub_id = $this->processor->get_sub_email($leave_id);
           // $days = $this->processor->get_days($sub_id); 
			$name4="";
			$reply = "";
		
		$staff = $this->processor->get_sup_requests($user_id);
	$usr_id = $staff[0];
	$days = $staff[1];
	$dates = $staff[2];
	$reason = $staff[3];
	$status = $staff[4];
	$num4 = $staff[8];
	$main_title="Requests to work extra days";
	define('SIDE_MENU','templates/en_US/leave_menu.php');
	define('MAIN_CONTENT','templates/en_US/extra_day_requests.php');
	include('templates/en_US/main.php');
				}
     }
	 
/*form to add leave schedule*/
if($request=='schedule_form'){
$this->schedule_form();
	}
/*add leave schedule*/	


 if($request=='add_schedule'){
	 
	 $user_id = $_SESSION['user_id'];
	$data = "";
	
	//$id = $this->processor->get_request_id($user_id);
	//$num = $id[2];
	$d = $this->processor->out_of_office_requests($user_id);
	$num2 = $d[2];
	// $records = $this->processor->duty_resumption_requests($user_id);
	// $d_num = $records[9];
			
	// $records = $this->processor->get_resump_requests($user_id, 2015);
	// $num3 = $records[14];
	$staff48 = $this->processor->get_sup_requests($user_id);
	$num4 = $staff48[8];
		$leave_supervisor = $this->processor->get_group($user_id);
		  $leave_sup_name = $leave_supervisor[2];
			$leave_sup_email = $leave_supervisor[3];
			
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$dates = $_POST['days'];
		$elements = explode(',',$dates);
		if(count($elements)<14){
			$data = $this->error(" Please select a maximum of 14 annual leave days");
			$msg = 3;
			}else{
		$msg = $this->processor->add_schedule($user_id, $dates);
		if($msg==1){
			$subject = USER_NAMES." LEAVE SCHEDULE";
			$body = 'Hello, <br />'. $leave_sup_name. ' <br />'.USER_NAMES.' has submited the leave schedule<br/ >
			Please login the system and review.
			<br /> BCM - Human Resource Information System <br />
			<a href="http://baylorhris/hrm"><strong>Internal Link</strong></a>
			<br />
			<a href="https://hris.baylor-uganda.org/hrm"><strong>External Link</strong></a>
			<br /><br />
			 Thank you <br />';
			 $this->send_email->send_email($leave_sup_email, $subject, $body);
			}else{
				}
			}
		}
	$pub_days = $this->processor->pub_hol();
   // $this->schedule_form();
	header('Location: index.php?request=schedule_form&link=leave&link2=sc_f&msg='.$msg);
	 }
//get schedule by id
if($request=='sched_byid'){
	
		 $user_id = $_SESSION['user_id'];
	$data = "";
	
	$sup_name = $this->processor->get_supervisor($_SESSION['user_id']);
	//$id = $this->processor->get_request_id($user_id);
	//$num = $id[2];
	$d = $this->processor->out_of_office_requests($user_id);
	$num2 = $d[2];
  // $records = $this->processor->duty_resumption_requests($user_id);
	//		 $d_num = $records[9];
			
	// $records = $this->processor->get_resump_requests($user_id, 2015);
	// $num3 = $records[14];
	$staff48 = $this->processor->get_sup_requests($user_id);
	$num4 = $staff48[8];
	
	$usr_id = $_GET['id2'];
	$schd_id = $_GET['id'];
	
	$sch = $this->processor->view_schedule($schd_id, $usr_id);
	$s_id = $sch[0];
	$status = $sch[2];
	$fname = $sch[3];
	$lname = $sch[4];
	$us_id = $sch[5];
	
	$s_dates2 = explode(',',$sch[1]);
	foreach($s_dates2 as $dat){
		$dat2[] = $dat;
		}
	 $kaka2 ="";   
	 foreach($dat2 as $d): 
     $kaka = trim($d);
	 $kaka2 .=  "'".$kaka."',"; 
	endforeach;
	$str3 =  rtrim($kaka2,','); 
	$str = "[".$str3."]";
	
	$pub_days = $this->processor->pub_hol();
	$form_title = "leave schedule";
	define('SIDE_MENU','templates/en_US/leave_menu.php');
	define('MAIN_CONTENT','templates/en_US/view_schedule.php');
	include('templates/en_US/main.php');
	}
if($request=='staff_leave_schedule'){
	$this->staff_leave_schedule();
	}
if($request=='review_schedule'){
	$this->review_schedule();
	}
//update schedule
if($request=='update_schedule'){	
	$user_id = $_SESSION['user_id'];
		if(isset($_GET['msg'])){
		if($_GET['msg']==1){
			$data = $this->success(" Request has been  processed. ");
			}else {
				$data = $this->error(" For some reasons the request was not  processed. ");
				}
		}else {
	$data = "";
		}
	$sup_name = $this->processor->get_supervisor($_SESSION['user_id']);
	//$id = $this->processor->get_request_id($user_id);
//	$num = $id[2];
	$d = $this->processor->out_of_office_requests($user_id);
	$num2 = $d[2];    

	$staff48 = $this->processor->get_sup_requests($user_id);
	$num4 = $staff48[8];
	
		$leave_supervisor = $this->processor->get_group($user_id);
		  $leave_sup_name = $leave_supervisor[2];
			$leave_sup_email = $leave_supervisor[3];
	
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$days1 = $_POST['days'];
		$sc_id =$_POST['id'];
		
		$dat = $this->processor->update_schedule($sc_id, $days1);
		if($dat==1){
			$subject = USER_NAMES." LEAVE SCHEDULE";
			$body = 'Hello, <br />'. $leave_sup_name. ' <br />'.USER_NAMES.' has re-submitted  the leave schedule<br/ >
			Please login the system and review.
			<br /> BCM - Human Resource Information System <br />
			<a href="http://baylorhris/hrm"><strong>Internal Link</strong></a>
			<br />
			<a href="https://hris.baylor-uganda.org/hrm"><strong>External Link</strong></a>
			<br /><br />
			 Thank you <br />';
			 $this->send_email->send_email($leave_sup_email, $subject, $body);
			}else{
				}
		}
	header('Location: index.php?request=schedule_form&link=leave&link2=sc_f&msg='.$dat);

	}	
	
}
	/*
*
*
* Group 
*
*
*
*/

public function get_leave_super(){
						//getting supervisor id and email
			session_start();
			$leave_supervisor = $this->processor->get_group($_SESSION['user_id']);
			$g_name = $leave_supervisor[0];
			$leave_sup_id = $leave_supervisor[1];
			$leave_sup_name = $leave_supervisor[2];
			$leave_sup_email = $leave_supervisor[3];
			$leave_delegation = $leave_supervisor[4];
			return $leave_supervisor;
	}
//get number of leave requests
public function get_leave_requests_num(){
			$leave_req_dets = $this->processor->get_all_leave_requests($_SESSION['user_id'],2017);
			 $num = $leave_req_dets[1];
			 return $num;
	}
/*
*
*
*LEAVE SCHEDULE
*
*
*
*/
public function schedule_form(){
	$user_id = $_SESSION['user_id'];
		if(isset($_GET['msg'])){
		if($_GET['msg']==1){
			$data = $this->success(" Request has been processed. ");
			}else if($_GET['msg']==3){
				$data = $this->error(" Request was not processed please select a MAXIMUM of 14 days. ");
				}else {
					$data = $this->error(" For some reasons the request was not  processed. ");
					}
		}else {
			$data = "";
			}
	$sup_name = $this->processor->get_supervisor($_SESSION['user_id']);
	//$id = $this->processor->get_request_id($user_id);
	//$num = $id[2];
	$d = $this->processor->out_of_office_requests($user_id);
	$num2 = $d[2];

	$staff48 = $this->processor->get_sup_requests($user_id);
	$num4 = $staff48[8];
	
	$pub_days = $this->processor->pub_hol();
	
	//check if leave schedule was submited and is in which state
	$get_leave_sch = $this->processor->select_by_id('leave_schedule','user_id',$user_id);
     if(count($get_leave_sch)==0){
	 $view =  'schedule_frm.php';
		 }else {
	 foreach($get_leave_sch as $sch){
		 $id = $sch->sched_id;
		 $dates = $sch->leave_date;
		 $update_date  = $sch->update_date;
		 $super_comment = $sch->super_comment;
		 $status = $sch->status;
		 $year = $sch->year;
		$sup_update_date = $sch->sup_update_date;
		 }
		$pre_dates = explode(',',$dates);
		foreach($pre_dates as $dat){
			$pre_date2[] = "'".trim($dat)."',";
			}
	$pre_date3 = implode('',$pre_date2);
	// $pre_date = "'".(substr($pre_date3,-1) == ',')?substr($pre_date3,0,-1) : $pre_date3."'";
	$pre_date = (substr($pre_date3,-1) == ',')?substr($pre_date3,0,-1) : $pre_date3;

	 $view =  'view_schedule.php';	 
			 }
	$form_title = "Set your leave schedule here";
	$main_title = "Leave Schedule";
	define('SIDE_MENU','templates/en_US/leave_menu.php');
	define('MAIN_CONTENT','templates/en_US/'.$view);
	include('templates/en_US/main.php');
	
	}
//supervisor leave schedule view
public function staff_leave_schedule(){
	$data = "";
	$user_id = $_SESSION['user_id'];
    $staff_id = $_GET['id'];
	if(isset($_GET['msg'])){
		if($_GET['msg']==1){
			$data = $this->success(" Request has been  processed. ");
			}else {
				$data = $this->error(" For some reasons the request was not  processed. ");
				}
		}
	$sup_name = $this->processor->get_supervisor($_SESSION['user_id']);
	//$id = $this->processor->get_request_id($user_id);
	//$num = $id[2];
	$d = $this->processor->out_of_office_requests($user_id);
	$num2 = $d[2];
	
	$staff48 = $this->processor->get_sup_requests($user_id);
	$num4 = $staff48[8];
	
	$pub_days = $this->processor->pub_hol();
	
	$staff_det = $this->processor->select_by_id('hrm_users','user_id',$staff_id);
	foreach($staff_det as $staf){
		$name = $staf->user_firstname.' '.$staf->user_lastname;
		}
	
	//check if leave schedule was submited and is in which state
	$get_leave_sch = $this->processor->select_by_id('leave_schedule','user_id',$staff_id);
	 foreach($get_leave_sch as $sch){
		 $id = $sch->sched_id;
		 $dates = $sch->leave_date;
		 $update_date  = $sch->update_date;
		 $super_comment = $sch->super_comment;
		 $status = $sch->status;
		 $year = $sch->year;
		 $sup_update_date = $sch->sup_update_date;
		 }
		$pre_dates = explode(',',$dates);
		foreach($pre_dates as $dat){
			$pre_date2[] = "'".trim($dat)."',";
			}
	$pre_date3 = implode('',$pre_date2);
	// $pre_date = "'".(substr($pre_date3,-1) == ',')?substr($pre_date3,0,-1) : $pre_date3."'";
	$pre_date = (substr($pre_date3,-1) == ',')?substr($pre_date3,0,-1) : $pre_date3;

	 $view =  'leave_sched_sup_view.php';	 
	$form_title = "Set your leave schedule here";
	$main_title = "Leave Schedule";
	define('SIDE_MENU','templates/en_US/leave_menu.php');
	define('MAIN_CONTENT','templates/en_US/'.$view);
	include('templates/en_US/main.php');
	}
//function to review leave schedule
public function review_schedule(){
	$data = "";
	$user_id = $_SESSION['user_id'];
	//$id = $this->processor->get_request_id($user_id);
//	$num = $id[2];
	$d = $this->processor->out_of_office_requests($user_id);
	$num2 = $d[2];    

	$staff48 = $this->processor->get_sup_requests($user_id);
	$num4 = $staff48[8];
	$staff_id = $_GET['id'];
  $staff_det = $this->processor->select_by_id('hrm_users','user_id',$staff_id);
	foreach($staff_det as $staf){
		$name = $staf->user_firstname.' '.$staf->user_lastname;
		$staff_email = $staf->user_email;
		$hr_email = '';
		}
	
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$sch_id = $_POST['id'];
		$status =$_POST['status'];
		$comm = $_POST['comment'];
		
		$dat = $this->processor->review_schedule($sch_id, $status, $comm);

		if($dat==1){
			$data = $this->success(" Request has been  processed. ");
			if($status==3){
			$subject = $name." LEAVE SCHEDULE APPROVED";
			$body = 'Hello, <br />'. $name.' <br />Your leave schedule has been reviewed and approved by your supervisor<br/ >
			Please login the system and review.
			<br /> BCM - Human Resource Information System <br />
			<a href="http://baylorhris/hrm"><strong>Internal Link</strong></a>
			<br />
			<a href="https://hris.baylor-uganda.org/hrm"><strong>External Link</strong></a>
			<br /><br />
			 Thank you <br />';
			 $this->send_email->send_email($staff_email, $subject, $body);
			 
			 $subject2 = $name." LEAVE SCHEDULE APPROVED";
			$body2 = 'Hello HR staff, <br /> <br />'.$name.' Leave schedule has been approved by the supervisor<br/ >
			Please login the system and view.
			<br /> BCM - Human Resource Information System <br />
			<a href="http://baylorhris/hrm/administrator"><strong>Internal Link</strong></a>
			<br />
			<a href="https://hris.baylor-uganda.org/hrm/administrator"><strong>External Link</strong></a>
			<br /><br />
			 Thank you <br />';
			 $this->send_email2->send_email($hr_email, $subject2, $body2);
			}else {
					$subject = $name." LEAVE SCHEDULE DENIED";
			$body = 'Hello, <br />'. $name.' <br />Your leave schedule has been reviewed and denied by your supervisor<br/ >
			Please login the system and review.
			<br /> BCM - Human Resource Information System <br />
			<a href="http://baylorhris/hrm"><strong>Internal Link</strong></a>
			<br />
			<a href="https://hris.baylor-uganda.org/hrm"><strong>External Link</strong></a>
			<br /><br />
			 Thank you <br />';
			 $this->send_email->send_email($staff_email, $subject, $body);
				}
			}else{
			$data = $this->error(" For some reasons the request was not  processed. ");
				}
		}
	header('Location: index.php?request=staff_leave_schedule&link=leave&link2=v_stf&id='.$staff_id.'&msg='.$dat);
	}



//succesful message
public function success($msg2){
	$msg = "<div class='alert alert-success alert-dismissible' role='alert'><b>Congratulations,</b>$msg2</div>";
	return $msg;
	}
//error message
public function error($msg2){
	$msg = "<div class='alert alert-danger alert-dismissible' role='alert'><b>Sorry</b> $msg2 <b>Contact systems administrator</b> for help! </div>";
	return $msg;
	}
}
?>