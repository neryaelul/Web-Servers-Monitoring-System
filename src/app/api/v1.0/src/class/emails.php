<?php

    class emails {

        function __construct($validation,$app_settings){
            $this->validation = $validation;
            $this->app_settings = $app_settings;
            $this->time = time();

        }
        
        public function add($details) {
            global $pdo;
            if($this->validation){
                if($this->validation['info']['permission'] >= $this->app_settings['endpoints']['emails']['operations']['add']['permission']){
                $data_check['name'][0] = $details['name'];
                $data_check['name'][1] = 'String';
                $data_check['address'][0] = $details['email'];
                $data_check['address'][1] = 'String';
                $checkDataValueRes = checkDataValue($data_check);
                if(!$checkDataValueRes['status']){            
                    $res['status'] = false;
                    $res['type'] = "error_parameters";
                    $res['info'] = $checkDataValueRes;
                    return $res;
                }elseif(!filter_var($details['email'], FILTER_VALIDATE_EMAIL)){
                    $res['status'] = false;
                    $res['type'] = "validate_email";
                    return $res;
                }else{
                    $select_q = $pdo->prepare("SELECT * FROM admin_emails WHERE email = :email");
                    $select_q->bindValue(':email', $details['email']);
                    $select_q->execute();
                    
                    if ($select_q->rowCount() == 0) {
                        $insert_q = $pdo->prepare("INSERT INTO admin_emails (name, time, email) VALUES (:name, :time, :email)");
                        $insert_q->bindValue(':name', $details['name']);
                        $insert_q->bindValue(':time', $this->time);
                        $insert_q->bindValue(':email', $details['email']);
                        $insert_q->execute();

                        $res['status'] = true;
                        $res['type'] = "added_success";
                        return $res;
                    }else{
                        $res['status'] = false;
                        $res['type'] = "existing_record";
                    return $res;
                    }
                }
            }else{
                $res['status'] = false;
                $res['type'] = "permission_error";
            return $res;
            }
        }
    }
    public function get($details) {
        if ($this->validation) {
            if ($this->validation['info']['permission'] >= $this->app_settings['endpoints']['tokens']['operations']['delete']['permission']) {
                global $pdo;
                    $select_q = $pdo->prepare("SELECT * FROM admin_emails");
                    $select_q->execute();
    
                    if ($select_q->rowCount() > 0) {
                        $row = $select_q->fetchAll(PDO::FETCH_ASSOC);
                        $res['status'] = true;
                        $res['results'] = $row;
                        return $res;
                    } else {
                        $res['status'] = false;
                        $res['type'] = "record_not_found";
                        return $res;
                    }
                }
            } else {
                $res['status'] = false;
                $res['type'] = "permission_error";
                return $res;
            }
        }
    public function delete($details) {
        global $pdo;
        if ($this->validation) {
            if ($this->validation['info']['permission'] >= $this->app_settings['endpoints']['emails']['operations']['delete']['permission']) {
                $data_check['email'][0] = $details['email'];
                $data_check['email'][1] = 'String';
                $checkDataValueRes = checkDataValue($data_check);
    
                if (!$checkDataValueRes['status']) {
                    $res['status'] = false;
                    $res['type'] = "error_parameters";
                    $res['info'] = $checkDataValueRes;
                    return $res;
                } else {
                    $select_q = $pdo->prepare("SELECT * FROM admin_emails WHERE email = :email");
                    $select_q->bindValue(':email', $details['email']);
                    $select_q->execute();
    
                    if ($select_q->rowCount() > 0) {
                        $delete_q = $pdo->prepare("DELETE FROM admin_emails WHERE email = :email");
                        $delete_q->bindValue(':email', $details['email']);
                        $delete_q->execute();
    
                        $res['status'] = true;
                        $res['type'] = "deleted_success";
                        return $res;
                    } else {
                        $res['status'] = false;
                        $res['type'] = "record_not_found";
                        return $res;
                    }
                }
                } else {
                    $res['status'] = false;
                    $res['type'] = "permission_error";
                    return $res;
                }
            }
        }
        
    }
?>