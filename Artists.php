<?php

class Artists extends GenerateTable {
  private $db_settings = array(
    'host'=>'localhost',
    'db_name' => 'IMJ',
    'dbtable' => '_raw_exhen',
    'user' => 'root',
    'pass' => 'root',
  );

  protected $table = '_raw_artists';

  public $fields = array(
    'Title' => '_artistec',
    'Full name' => '_artiste_he',
    'Final editing' => '_finaleditinge_he'
  );

  public function __construct() {
    $this->db = Database::connect($this->db_settings);
//    $this->db = new PDO('mysql:host=localhost;dbname=IMJ','root', 'root');
  }


  public function getData(){

    $fields = $this->fieldsToString();
    $stmt = $this->db->query('SELECT ' . $fields . ' FROM ' . $this->table
      . ' LEFT JOIN `_raw_artists_he` ON  _raw_artists._artistcode = _raw_artists_he._artistcode_he WHERE _raw_artists.`__id` %3 = 0');
    $this->data = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
