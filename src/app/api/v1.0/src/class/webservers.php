<?php
    class webservers {
      public $time;
    
      
      function __construct($validation,$app_settings){
        $this->validation = $validation;
        $this->app_settings = $app_settings;
        $this->time = time();

      }
      
      public function add($details) {
            global $pdo;
            if($this->validation){
              // print_r($details);                
              if($this->validation['info']['permission'] >= $this->app_settings['endpoints']['webservers']['operations']['add']['permission']){
                $data_check['name'][0] = $details['name'];
                $data_check['name'][1] = 'String';
                $data_check['address'][0] = $details['address'];
                $data_check['address'][1] = 'String';
                $data_check['type'][0] = $details['type'];
                $data_check['type'][1] = 'String';
                $data_check['disabled'][0] = $details['disabled'];
                $data_check['disabled'][1] = 'Boolean';
                $checkDataValueRes = checkDataValue($data_check);

                if(!$checkDataValueRes['status']){            
                    $res['status'] = false;
                    $res['type'] = "error_parameters";
                    $res['info'] = $checkDataValueRes;
                    return $res;
                }else{
                  $typeCAP = strtoupper($details['type']);
                  if($typeCAP != "FTP" && $typeCAP != "FTPS" && $typeCAP != "SSH" && $typeCAP != "HTTPS" && $typeCAP != "HTTP") {
                      $res['status'] = false;
                      $res['type'] = "error_parameter_protocol_type";
                      return $res;
                  }else{
                    $select_q = $pdo->prepare("SELECT * FROM webservers WHERE name = :name");
                    $select_q->bindValue(':name', $details['name']);
                    $select_q->execute();

                    if ($select_q->rowCount() == 0) {
                          $insert_q = $pdo->prepare("INSERT INTO webservers (name, time, address, disabled, type, healthy_status) VALUES (:name, :time, :address, :disabled, :type, :healthy_status)");
                          $insert_q->bindValue(':name', $details['name']);
                          $insert_q->bindValue(':time', $this->time);
                          $insert_q->bindValue(':address', $details['address']);
                          $insert_q->bindValue(':disabled', (int)$details['disabled']);
                          $insert_q->bindValue(':type', $typeCAP);
                          $insert_q->bindValue(':healthy_status', "checking...");
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
                }
              }else{
                $res['status'] = false;
                $res['type'] = "permission_error";
                return $res;
              }
          }
      }
      public function update($details) {
        global $pdo;
        if($this->validation){
            if($this->validation['info']['permission'] >= $this->app_settings['endpoints']['webservers']['operations']['update']['permission']){

              $data_check['name'][0] = $details['name'];
              $data_check['name'][1] = 'String';
              $data_check['address'][0] = $details['address'];
              $data_check['address'][1] = 'String';
              $data_check['type'][0] = $details['type'];
              $data_check['type'][1] = 'String';
              $data_check['disabled'][0] = $details['disabled'];
              $data_check['disabled'][1] = 'Boolean';
              $checkDataValueRes = checkDataValue($data_check);

              if(!$checkDataValueRes['status']){            
                  $res['status'] = false;
                  $res['type'] = "error_parameters";
                  $res['info'] = $checkDataValueRes;
                  return $res;
              }elseif($details['type'] != "FTP" && $details['type'] != "FTPS" && $details['type'] != "SSH" && $details['type'] != "HTTPS" && $details['type'] != "HTTP") {
                  $res['status'] = false;
                  $res['type'] = "error_parameter_protocol_type";
                  return $res;
              }else{
                $select_q = $pdo->prepare("SELECT * FROM webservers WHERE name = :name");
                $select_q->bindValue(':name', $details['name']);
                $select_q->execute();

                if ($select_q->rowCount() > 0) {
                  $update_q = $pdo->prepare("UPDATE webservers SET address = :address,type = :type, disabled = :disabled WHERE name = :name");
                  

                  $update_q->bindValue(':name', $details['name']);
                  $update_q->bindValue(':address', $details['address']);
                  $update_q->bindValue(':disabled', (int)$details['disabled']);
                  $update_q->bindValue(':type', $details['type']);
                  
                  $update_q->execute();
                  $res['type'] = "updated_success";
                  $res['status'] = true;
                  return $res;
                }else{
                  $res['type'] = "record_not_found";
                  $res['status'] = false;
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
    
      public function get($qSearch) {
        global $pdo;
        if($this->validation){
          
          if($this->validation['info']['permission'] >= $this->app_settings['endpoints']['history']['operations']['get']['permission']){
              global $pdo;
              if(!isset($qSearch)){
                $select_q = $pdo->prepare("SELECT * FROM webservers");
                $with_history = false;
              }else{
                    $select_q = $pdo->prepare("SELECT * FROM webservers WHERE webservers.name = :qSearch");
                    $select_q->bindValue(":qSearch", $qSearch);
                    $with_history = true;
              }
              $select_q->execute();



              if($select_q->rowCount() > 0){
                $rows = $select_q->fetchAll(PDO::FETCH_ASSOC);
                
                  if($with_history){
                    
                    $qHistory = "SELECT *
                    FROM history 
                    WHERE list_id = :id";
                    
                    $select_q_history = $pdo->prepare($qHistory);
                    $select_q_history->bindValue(":id", $rows[0]['id']);
                    $select_q_history->execute();
                    $row_history = $select_q_history->fetchAll(PDO::FETCH_ASSOC);

                    $arr_res_rows['webservers'] = $rows[0];
                    $arr_res_rows['history'] = $row_history;
                  }else{
                    $arr_res_rows = $rows;
                  }
                  $res['status'] = true;
                  $res['results'] = $arr_res_rows;
                  return $res;
              } else {
                   $res['type'] = "record_not_found";
                   return $res;
              }
            }else{
                $res['status'] = false;
                $res['type'] = "permission_error";
                return $res;
            }
            
        }
      }
        public function delete($details) {
          global $pdo;
          if ($this->validation) {
              if ($this->validation['info']['permission'] >= $this->app_settings['endpoints']['webservers']['operations']['delete']['permission']) {
      
                  $data_check['name'][0] = $details['name'];
                  $data_check['name'][1] = 'String';
                  $checkDataValueRes = checkDataValue($data_check);
      
                  if (!$checkDataValueRes['status']) {
                      $res['status'] = false;
                      $res['type'] = "error_parameters";
                      $res['info'] = $checkDataValueRes;
                      return $res;
                  } else {
                      $select_q = $pdo->prepare("SELECT * FROM webservers WHERE name = :name");
                      $select_q->bindValue(':name', $details['name']);
                      $select_q->execute();
      
                      if ($select_q->rowCount() > 0) {
                          $delete_q = $pdo->prepare("DELETE FROM webservers WHERE name = :name");
                          $delete_q->bindValue(':name', $details['name']);
                          $delete_q->execute();
      
                          $res['type'] = "deleted_success";
                          $res['status'] = true;
                          return $res;
                      } else {
                          $res['type'] = "record_not_found";
                          $res['status'] = false;
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