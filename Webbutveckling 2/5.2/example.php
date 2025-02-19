<?php
require 'PHPMailerAutoload.php';
$mail = new PHPMailer;

// Skickar mailet om det inte fungerar blir det ett error
try {
    $mail->IsSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->SMTPAuth = true;
    $mail->Username = 'samuel.jahangiri1@gmail.com';
    $mail->Password = 'yxoyiosgvzwicruu';
    $mail->SMTPSecure = 'ssl';
    $mail->setFrom('samuel.jahangiri1@gmail.com', 'Samuel ');           
    $mail->addAddress('tynningolandet@gmail.com');
    $mail->addAttachment($_FILES['file1']['tmp_name'],$_FILES['file1']['name']);
    $mail->addAttachment($_FILES['file2']['tmp_name'],$_FILES['file2']['name']);
    $mail->addCC($_POST['cc']);  
    $mail->addBCC($_POST['bcc']);  
    $mail->isHTML(true); 
    $mail->Subject = $_POST['subject'];
    $mail->Body= $_POST['message']."<br>"."Observera! Detta meddelande är sänt från ett formulär på Internet och avsändaren kan vara felaktig!";
    $mail->send();
    echo "Mailet har skickats!";
} catch (Exception $e) {
    echo "Mailet kunde inte skickas {$mail->ErrorInfo}";
}

?>