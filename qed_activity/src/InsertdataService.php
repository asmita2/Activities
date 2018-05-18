<?php
namespace Drupal\qed_activity;
use Drupal\Core\Database\Connection;

class InsertdataService {
  protected $connection;

  public function __construct(Connection $connection) {
    $this->connection = $connection;
  }

  public function insertData($userid, $first_name,$last_name){
    // $connection = \Drupal::database();
     $query = $this->connection->insert('d8_demo')->fields([
      'first_name' => $first_name,
      'last_name' => $last_name,
      'uid' => $userid,
     ])->execute();
  }
  public function getMsg(){
    // $connection = \Drupal::database();
    // $query = $this->connection->select( * FROM Table ORDER BY ID DESC LIMIT 1)
    $select = $this->connection->select('d8_demo','n')
    ->orderBy('id','DESC')
    ->range(0, 1);

    $result = $select->execute();
    dpm($result);
    return $result ;
   //  $uid = \Drupal::currentUser()->id();
   //  $query = $this->connection->select('todoinfo', 'n')
   //  ->fields('n',['textmessage'])
   //  ->condition('uid', $uid, '=');
   // $result = $query->execute();
   // return $result->fetchAllKeyed(0, 0);
  }
}
