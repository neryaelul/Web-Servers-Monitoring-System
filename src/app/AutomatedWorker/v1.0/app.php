<?php
    require __DIR__ . '/src/class/server_check.php';
    require __DIR__ . '/src/class/email_list_admins_send.php';
    require __DIR__. '/src/email_lib/mail_smtp/vendor/autoload.php'; 

    $server_status = new server_check();
    $select_q = $pdo->prepare("SELECT * FROM webservers WHERE disabled <> 1");
    $select_q->execute();

    $email_to_admins = new email_list_admins_send('bylith@nerya.services');
    $results = $select_q->fetchAll(PDO::FETCH_ASSOC);
        $time = time();
        if($results){
            foreach($results as $row){
                echo $row['id'];
                if($row['type'] == "HTTP" || $row['type'] == "HTTPS"){
                    $res = $server_status->checkWebserverHTTP($row['address']);
                    $http_code = $res['info']['http_code'];
                    $latency = $res['info']['latency'];
                    $insert = true;
                }elseif($row['type'] == "FTP"){
                    $res = $server_status->checkFTP($row['address']);
                    $http_code = 0;
                    $latency = 0;
                    $insert = true;
                    
                }elseif($row['type'] == "FTPS"){
                    $res = $server_status->checkFTPS($row['address']);
                    $http_code = 0;
                    $latency = 0;
                    $insert = true;
                    
                }elseif($row['type'] == "SSH"){
                    $res = $server_status->checkSSH($row['address']);
                    $http_code = 0;
                    $latency = 0;
                    $insert = true;
                }

                if($insert){

                    $insert_q = $pdo->prepare("INSERT INTO history (list_id, time, status, message,status_code_http,latency_http) VALUES (:list_id, :time, :status, :message,:status_code_http,:latency_http)");
                    $insert_q->bindValue(':list_id', $row['id']);
                    $insert_q->bindValue(':time', $time);
                    $insert_q->bindValue(':status', (int)$res['status']);
                    $insert_q->bindValue(':message', $res['message']);
                    $insert_q->bindValue(':status_code_http', $http_code);
                    $insert_q->bindValue(':latency_http', $latency);
                    $insert_q->execute();

                    $history_q = $pdo->prepare("SELECT * FROM history WHERE list_id = :id ORDER BY id DESC LIMIT 5");
                    
                    $history_q->bindValue(':id', $row['id']);
                    $history_q->execute();
                    $results_history_q = $history_q->fetchAll(PDO::FETCH_ASSOC);
                    if($results_history_q){
                        $count_false = 0;
                        foreach($results_history_q as $row_history){
                            if($row_history['status'] == 0){
                                $count_false++;
                            }
                        }
                        echo "count_false - " . $count_false;
                        if($count_false >= 3){
                            $update_q = $pdo->prepare("UPDATE webservers SET healthy_status = 'Unhealthy' WHERE id = :id");
                            $update_q->bindValue(':id', $row['id']);
                            $update_q->execute();
                            if($count_false == 3){
                                $subject = 'Your server is Unhealthy - ' .$row['name'];
                                $message = '<h1>Your server is Unhealthy - ' .$row['name']. '</h1>';
                                $message .= '<p>Address: ' .$row['address']. '</h1>';
                                // שולחים מייל פעם אחת בלבד כדי לא לשלוח כל דקה מיילים
                              $email_to_admins->send($subject,$message);
                            }
                        }
                        if($count_false == 0){
                            $update_q = $pdo->prepare("UPDATE webservers SET healthy_status = 'Healthy' WHERE id = :id");
                            $update_q->bindValue(':id', $row['id']);
                            $update_q->execute();

                        }
                            

                        }
                    }
                }
            }
        
?>






