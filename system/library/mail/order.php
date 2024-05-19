<?php 
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


if (isset($_SESSION['account_email'])) {

    $email = $_SESSION['account_email'];
 
  $mail = new PHPMailer(true);
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'anhocdev02@gmail.com';
  $mail->Password = 'lxtsvnecemrveobs';
  $mail->Port = 465;
  $mail->SMTPSecure = 'ssl';
  $mail->isHTML(true);
  $mail->setFrom("anhocdev02@gmail.com", "DICO STORE");
  $mail->addAddress($email);
  $mail->Subject = ("[DICO STORE] CAM ON KHACH HANG");  
  $htmlCode = '<div style="border-style:solid;border-width:thin;border-color:#dadce0;border-radius:8px;padding: 20px" align="center" class="m_-8448117101150819138mdv2rw">
  <div style="font-family:\'Google Sans\',Roboto,RobotoDraft,Helvetica,Arial,sans-serif;border-bottom:thin solid #dadce0;color:rgba(0,0,0,0.87);background-color:#fff;font-weight:700;line-height:32px;padding-bottom:12px;text-align:center;word-break:break-word">
    <div style="font-size:24px">ĐẶT HÀNG THÀNH CÔNG TẠI DICO STORE</div>
  </div>
  <div style="font-family:Roboto-Regular,Helvetica,Arial,sans-serif;font-size:14px;color:rgba(0,0,0,0.87);line-height:20px;padding-top:20px;text-align:left">
    DICO STORE xin cảm ơn khách hàng đã mua sản phẩm tại website, đơn hàng sẽ sớm được giao đến quý khách!<br>
  </div>
</div>';
  $mail->Body = $htmlCode;
  $mail->send();

  header('Location:../../index.php?page=thankiu&order_type=1');
}
?>