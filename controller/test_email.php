<?php
require($_SERVER['DOCUMENT_ROOT'].'/hrm/modules/leave-management/scripts/send_email.php');
//require_once('/logic/logic_processor.php');

class test_email{
private $send_email;

public function __construct(){
$this->send_email = new send_mail();
		}
public function testmail(){
$this->send_email = new send_mail();
$email = 'mkakande@baylor-uganda.org';
$subject = 'test';
$body = 'testing ema';
$kaka = $this->send_email->send_email($email, $subject, $body);
return $kaka;
}
 
}
$t = new test_email();
echo $t->testmail();
