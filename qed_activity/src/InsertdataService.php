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
      'uid' => $userid,
      'first_name' => $first_name,
      'last_name' => $last_name,
     ])->execute();
  }

}
