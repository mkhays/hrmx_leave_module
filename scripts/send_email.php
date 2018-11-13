<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'hrm/modules/leave-management/lib/PHPMailer/src/PHPMailer.php';
require 'hrm/modules/leave-management/lib/PHPMailer/src/SMTP.php';
require 'hrm/modules/leave-management/lib/PHPMailer/src/Exception.php';
class send_email{
	public $mail;
	public function __construct(){
		$this->mail = new PHPMailer(true);	
		}
	
	public function send_email($email, $subject, $body){
	$this->mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $this->mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $this->mail->isSMTP();                                      // Set mailer to use SMTP
    $this->mail->Host = '10.1.0.97';  // Specify main and backup SMTP servers
    $this->mail->SMTPAuth = true;                               // Enable SMTP authentication
    $this->mail->Username = 'baylor\hris';                 // SMTP username
    $this->mail->Password = '123Bcm123';                           // SMTP password
    $this->mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    //$mail->SMTPAutoTLS = false;
	$this->mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
	$this->mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $this->mail->setFrom('hris@baylor-uganda.org', 'Baylor HRIS');
    $this->mail->addAddress($email);     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    $this->mail->addReplyTo('epmsupport@baylor-uganda.org', 'HRIS support');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
   // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $this->mail->isHTML(true);                                  // Set email format to HTML
    $this->mail->Subject = $subject;
    $this->mail->Body    = $body;
    //$this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $this->mail->send();
    //echo 'Message has been sent';
} catch (Exception $e) {
   // echo 'Message could not be sent. Mailer Error: ', $this->mail->ErrorInfo;
}	
	}	
}
?>