<?php  
class auto_backto_office{
	public function __construct(){
		}
	public function open_db(){
		$host = 'localhost';
        $user = 'root';
        $password = 'Cypher1234';
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
		//check if in or out
public function check_inout(){
	$this->open_db();
	$two = "2";
	$n_two = ($two != NULL)?"'".mysql_real_escape_string($two)."'":'NULL';
	$sql = mysql_query("SELECT * FROM leave_instance_2015 WHERE in_out=$n_two");
	if(mysql_num_rows($sql)!=0){
    while($row = mysql_fetch_array($sql)){
		$users[] = $row['user_id'];
		}
		return $users;
	}else return "false";
	}
// get the latest leave request
public function latest_leave_request($user){
	$this->open_db();
	$user_id = ($user != NULL)?"'".mysql_real_escape_string($user)."'":'NULL';
	$sql = mysql_query("SELECT * FROM leave_request_2015 WHERE user_id=$user_id ORDER BY id DESC LIMIT 1");
	while($row = mysql_fetch_array($sql)){
		//$leave_ids = $row['id'];
		//$user_id2 = $row['user_id'];
		$leave_end = $row['leave_end_date'];
		}
		return $leave_end;
	}
}
$back_on_office = new auto_backto_office();
$users = $back_on_office->check_inout();
if($users=="false"){

}else {
foreach($users as $user_id){
	$one = "1";
	$one_l = ($one != NULL)?"'".mysql_real_escape_string($one)."'":'NULL';
	$user = ($user_id != NULL)?"'".mysql_real_escape_string($user_id)."'":'NULL';
	//echo 'users'.$user_id.'<br />';
      $end = $back_on_office->latest_leave_request($user_id);
	  //echo 'leaveid'.$one.'userid'.$two.'leaveend'.$end.'<br />';
	  $time = strtotime($end);
	   date_default_timezone_set("Africa/Kampala");
       $today = strtotime(date("Y/m/d H:i"));
	  if($time<$today){
		 // echo "change";
		 $sql = mysql_query("UPDATE leave_instance_2015	SET in_out=$one_l WHERE user_id=$user");
		  }
		  else{
		  }
			  }
	}
?>