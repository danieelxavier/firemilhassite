<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';


    // validation expected data exists
    if(!isset($_POST['origin']) ||
        !isset($_POST['destiny']) ||
        !isset($_POST['date1']) ||
        !isset($_POST['date2']) ||
        !isset($_POST['payment']) ||
        !isset($_POST['phone']) ||
        !isset($_POST['email'])) {
        // died(json_encode(array('status'=>"error", 'message'=>"We are sorry, but there appears to be a problem with the form you submitted.")));      
        echo json_encode(array('status'=>"error", 'message'=>"We are sorry, but there appears to be a problem with the form you submitted."));
        exit(0);

    }
    else{
        $origin = $_POST['origin']; // required
        $destiny = $_POST['destiny']; // required
        $date1 = $_POST['date1']; // required
        $date2 = $_POST['date2']; // required
        $payment = $_POST['payment']; // required
        $phone = $_POST['phone']; // required
        $email = $_POST['email']; // required


        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->CharSet = 'UTF-8';
            $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'makersitesdcx@gmail.com';                 // SMTP username
            $mail->Password = 'makersites@2019';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('makersitesdcx@gmail.com', 'SITE FIRE MILHAS');
            $mail->addAddress('danieelxavier@gmail.com', 'Fire Milhas');     // Add a recipient
            // $mail->addAddress('ellen@example.com');               // Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            $email_title = "SITE FIRE MILHAS - Nova solicitação de atendimento [".$email."]";

            $email_message = "<b>NOVA SOLICITAÇÃO DE ATENDIMENTO</b><br><br>";
            $email_message .= "<b>Dados do cliente:</b><br>";
            $email_message .= "<b>Telefone: </b>".$phone."<br>";
            $email_message .= "<b>Email: </b>".$email."<br><br>";
            $email_message .= "<b>Dados da viagem:</b><br>";
            $email_message .= "<b>Origem: </b>".$origin."<br>";
            $email_message .= "<b>Destino: </b>".$destiny."<br>";
            $email_message .= "<b>Data prevista da viagem: </b> entre ".$date1." e ".$date2."<br>";
            $email_message .= "<b>Forma de pagamento preferível: </b>".$payment."<br>";

            $origin = ""; // required
            $destiny = ""; // required
            $date1 = ""; // required
            $date2 = ""; // required
            $payment = ""; // required
            $phone = ""; // required
            $email = ""; // required

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $email_title;
            $mail->Body    = $email_message;
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


            //send the message, check for errors
            if (!$mail->send()) { 
                $result = array('status'=>"error", 'message'=>"Mailer Error: ".$mail->ErrorInfo);//
                echo json_encode($result);
            } else {
                $result = array('status'=>"success", 'message'=>"Message sent jotinha.");
                echo json_encode($result);
            }

        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }

    }

?>