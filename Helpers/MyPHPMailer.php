<?php
    namespace Helpers;

    require_once("C:\wamp64\www\UTN\Moviepass\Mailer\src\PHPMailer.php");
    require_once("C:\wamp64\www\UTN\Moviepass\Mailer\src\SMTP.php");
    require_once("C:\wamp64\www\UTN\Moviepass\Mailer\src\Exception.php");
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    class MyPHPMailer {

        public static function SendMail($clientEmail, $room, $movie, $showDate, $showStartTime, $showEndTime, $cinema, $purchase, $showID){
            $mail = new PHPMailer(true);

            $mailBody = "<b>¡Gracias por elegirnos!</b>
                        <br>
                        <p>Se registró correctamente su compra de ticket válida para:</p>
                        <ul>
                            <li>Cine: ".$cinema->getName()." - ".$cinema->getAddress()."</li>
                            <li>Sala: ".$room->getName()."</li>
                            <li>Película: ".$movie->getTitle()."</li>
                            <li>Reseña: ".$movie->getOverview()."</li>
                            <li>Fecha: ".date("d M Y", strtotime($showDate))."</li>
                            <li>Empieza: ".$showStartTime." - Termina: ".$showEndTime."</li>
                        </ul>
                        <br>
                        <p><b>Total abonado: $".$purchase->getPurchaseTotal()."</b></p>";

            $mailBodyAlter = '¡Gracias por elegirnos! Se registró correctamente su compra de ticket.';

            try {
                //Server settings
                $mail->isSMTP();                                          
                $mail->SMTPAuth   = true;                                  
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = 587;
                $mail->Username   = MAILER_EMAIL;     
                $mail->Password   = MAILER_PASSWORD;                          
        
            
                //Address
                $mail->setFrom(MAILER_EMAIL, MAILER_NAME);
                $mail->addAddress($clientEmail);     
            
                // Attachments --> attach here the qr code
                $mail->addAttachment(FRONT_ROOT.VIEWS_PATH."qrcodes/".$clientEmail."-show".$showID.".png");         
            
                // Content
                $mail->isHTML(true);                                 
                $mail->Subject = 'Compra de Ticket';
                $mail->Body    = $mailBody;
                $mail->AltBody = $mailBodyAlter;
            
                $mail->send();
                // echo 'Message has been sent';
                echo '<script>alert("Compra realizada: ¡Le hemos enviado un mail con la información de su compra!")</script>';
            } catch (Exception $e) {
                // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                echo '<script>alert("No pudimos enviarle un mail, pero su compra fue realizada.")</script>';
            }
        }

    }

?>