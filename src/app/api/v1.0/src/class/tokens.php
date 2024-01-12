<?php
        class tokens extends access {
            function __construct($validation,$app_settings){
              $this->validation = $validation;
              $this->app_settings = $app_settings;
            }
            public function add($details) {
              if($this->validation){
                global $pdo;
                if($this->validation['info']['permission'] >= $this->app_settings['endpoints']['tokens']['operations']['add']['permission']){
                  $app_settings['endpoints']['tokens']['operations']['add']['permission'];
                  $data_check['name'][0] = $details['name'];
                  $data_check['name'][1] = 'String';
                  $data_check['permission'][0] = $details['permission'];
                  $data_check['permission'][1] = 'Integer';
                  
                  if(!checkDataValue($data_check)['status']){
                      $res['status'] = false;
                      $res['type'] = "error_parmetrs";
                      $res['info'] = checkDataValue($data_check);
                      return $res;
                  }else{
                    $select_q = $pdo->prepare("SELECT * FROM api_access_tokens WHERE name = :name");
                    $select_q->bindValue(':name', $details['name']);
                    $select_q->execute();
                    if($select_q->rowCount() == 0){
                        global $pdo;
                        $new_token = generateRandomString(40);
                        $insert_q = $pdo->prepare("INSERT INTO api_access_tokens (name, token_hash, added_by, permission) VALUES (:name, :token_hash, :added_by, :permission)");
                        $insert_q->bindValue(':name', $details['name']);
                        $insert_q->bindValue(':token_hash', $this->mk_hash_hmac($new_token));
                        $insert_q->bindValue(':permission', $details['permission']);
                        $insert_q->bindValue(':added_by',  $this->validation['info']['id']);
                        $insert_q->execute();
                        
                        $res['status'] = true;
                        $res['type'] = "added_success";
                        $res['token'] = $new_token;
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
                        $select_q = $pdo->prepare("SELECT * FROM api_access_tokens");
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
              if ($this->validation) {
                  if ($this->validation['info']['permission'] >= $this->app_settings['endpoints']['tokens']['operations']['delete']['permission']) {
                      global $pdo;
                      $data_check['name'][0] = $details['name'];
                      $data_check['name'][1] = 'String';
                      if (!checkDataValue($data_check)['status']) {
                          $res['status'] = false;
                          $res['type'] = "error_parameters";
                          $res['info'] = checkDataValue($data_check);
                          return $res;
                      } else {
                          $select_q = $pdo->prepare("SELECT * FROM api_access_tokens WHERE name = :name");
                          $select_q->bindValue(':name', $details['name']);
                          $select_q->execute();
          
                          if ($select_q->rowCount() > 0) {
                              
                              $delete_q = $pdo->prepare("DELETE FROM api_access_tokens WHERE name = :name");
                              $delete_q->bindValue(':name', $details['name']);
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