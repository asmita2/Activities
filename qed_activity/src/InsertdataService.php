<?php
namespace Drupal\qed_activity;
use Drupal\Core\Database\Connection;

class InsertdataService {
  protected $connection;

  public function __construct(Connection $connection) {
    $this->connection = $connection;
  }

  public function insertData($userid, $first_name,$last_name,$qualification ,$country,$state){
     $query = $this->connection->insert('d8_demo_info')->fields([
      'first_name' => $first_name,
      'last_name' => $last_name,
      'uid' => $userid,
      'qualification' => $qualification,
      'country' => $country,
      'state' => $state,
     ])->execute();
  }
  public function get_User_Details(){
     $connection = \Drupal::database();

    $select = $this->connection->select('d8_demo_info','n')
    ->fields('n',['first_name'])
    ->fields('n',['last_name'])
    ->orderBy('id','DESC')
    ->range(0, 1);

    $result = $select->execute()->fetchAssoc();
    return $result ;

  }
}
