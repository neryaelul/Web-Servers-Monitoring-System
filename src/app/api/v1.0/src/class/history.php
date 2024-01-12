<?php
        class history {
            function __construct($validation,$app_settings){
              $this->validation = $validation;
              $this->app_settings = $app_settings;
            }
            public function get($qSearch) {
              if($this->validation){
                if($this->validation['info']['permission'] >= $this->app_settings['endpoints']['history']['operations']['get']['permission']){
                    global $pdo;
                    $select_q = $pdo->prepare("SELECT * FROM history INNER JOIN webservers ON history.list_id = webservers.id WHERE webservers.name = :qSearch ORDER BY history.id");
                    $select_q->bindValue(":qSearch", $qSearch);
                    $select_q->execute();
                    if($select_q->rowCount() > 0){
                        $row = $select_q->fetchAll(PDO::FETCH_ASSOC);
                        $res['status'] = true;
                        $res['info'] = $row;
                        return $res;
                    } else {
                        return array("status"=>false);
                    }
                }else{
                    $res['status'] = false;
                    $res['type'] = "permission_error";
                    return $res;
                }
                
              }
            }
          }
?>