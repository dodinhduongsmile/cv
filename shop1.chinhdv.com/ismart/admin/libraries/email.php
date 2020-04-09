<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
function send_mail($send_to_email,$send_to_fullname,$subject,$content, $option=array()){
    global $config;
    $config_email = $config['email'];
// Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
    //Server settings
    $mail->SMTPDebug = 0;                                       // Enable verbose debug output - thông báo lỗi
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = $config_email["smtp_host"];  // Specify main and backup SMTP servers - server google
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = $config_email["smtp_user"];                     // SMTP username - email gửi thư
    $mail->Password   = $config_email["smtp_pass"];                               // SMTP password - mật khẩu
    $mail->SMTPSecure = $config_email["smtp_secure"];                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = $config_email["smtp_port"];                                    // TCP port to connect to
    $mail->CharSet = 'UTF-8';//tiếng việt
    //Recipients
    $mail->setFrom($config_email["smtp_user"], $config_email["smtp_fullname"]); //người gửi thư
    $mail->addAddress($send_to_email, $send_to_fullname);     // Add a recipient - người nhận
    // $mail->addAddress('ellen@example.com');               // Name is optional - thêm người nhận
    $mail->addReplyTo($config_email["smtp_user"], $config_email["smtp_fullname"]); //thư trả lời sẽ gửi về đâu
     //$mail->addCC($option["add_cc"]); //gửi thêm người theo phương thức CC
    // $mail->addBCC('bcc@example.com');// gửi thêm người theo phương thức BCC

    // Attachments đính kèm
     //$mail->addAttachment($option["attachment"]);         // Add attachments - TỆP đính kèm
     // $mail->addAttachment('doduong.jpg', 'duong.png');    // Optional name - đổi tên tệp mới

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject; // tiêu đề thư
    $mail->Body    = $content; //nội dung thư
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    //echo 'vui lòng check email để kích hoạt tài khoản';
} catch (Exception $e) {
    echo "email không được gửi. chi tiết lỗi: {$mail->ErrorInfo}";
}
}