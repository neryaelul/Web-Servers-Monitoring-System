<?php
    class email_list_admins_send{
        function __construct($from){
            $this->from = $from;
        }
        function send($subject,$message){
            global $pdo;
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
                
                
            try {
                $mail->SMTPDebug = 2;                                      
                $mail->isSMTP();                                            
                $mail->Host       = 'smtp.elasticemail.com';                    
                $mail->SMTPAuth   = true;                                  
                $mail->Username   = 'bylith@nerya.services';              
                $mail->Password   = '614A63A865D7E46E5B3670BC73BD016D7C92';                        
                $mail->SMTPSecure = 'tls';                                 
                $mail->Port       = 2525;                                  
            
                $mail->setFrom($this->from, 'bylith');
                $select_q = $pdo->prepare("SELECT email,name FROM admin_emails");
                $select_q->execute();
                $emails = $select_q->fetchAll(PDO::FETCH_ASSOC);
                if($emails){
                    foreach ($emails as $email_row) {
                        $mail->addAddress($email_row['email'], $email_row['name']);            
                    }
                }
                    
                
                $mail->isHTML(true);                                        
                $mail->Subject = $subject;
                $mail->Body    = $message;

                $mail->send();
                echo 'Message has been sent';
            } catch (PHPMailer\PHPMailer\Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }
    
?>