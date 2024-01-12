<?php
    class access {
      public $time;
    
      function __construct() {
        $this->name = $name;
        $this->token = $token;
        $this->time = time();
      }
      function mk_hash_hmac($code) {
        $secret_key = 'xZ3i7zdrDkZzgpc3wV8VNfuXOL0iSaEwKEpoOi8VoJIayj1Wjsm8i76HIJyK';
        return hash_hmac('sha256', $code, $secret_key);
      }
      
      public function validation($name, $token) {
          global $pdo;
          $select_q = $pdo->prepare("SELECT * FROM api_access_tokens WHERE token_hash = :token_hash AND name = :name");
          $select_q->bindValue(':name', $name);
          $select_q->bindValue(':token_hash', $this->mk_hash_hmac($token));
          $select_q->execute();
          if($select_q->rowCount() > 0){
              $row = $select_q->fetch(PDO::FETCH_ASSOC);
              $res['status'] = true;
              $res['info'] = $row;
              return $res;
          } else {
              return array("status"=>false);
          }
      }
    }

    

?>