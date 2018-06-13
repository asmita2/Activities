<?php
namespace Drupal\qed_activity;
use Drupal\Core\Database\Connection;

class GetdataService {
  protected $connection;

  public function __construct(Connection $connection) {
    $this->connection = $connection;
  }
  public function get_appid(){

    $data =  $this->connection->select('weather_table','n')
    ->fields('n',['app_id'])
    ->execute()
    ->fetchAssoc('app_id');
   return $data;

  }
}

