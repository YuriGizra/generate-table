<?php

class ClassTable extends GenerateTable {
  private $db_settings = array(
    'host'=>'localhost',
    'db_name' => 'IMJ',
    'db_table' => '_raw_chugim',
    'join_left' => ''
    'user' => 'root',
    'pass' => 'root',
  );

  protected $table = '_raw_artists';
  
  protected $join_left = array();

  public $fields = array(
    'Title' => '_chugnum',
    't2' => '_catnum',
    'Lecturer' => '_lecturer',
    'Cost' => '_cost',
    'Description' => '_description',
    'Number of pics' => ''
  );

  public $prepare_fields = array(
    'Description' => array(
      'operation' => 'cut',
      'length' => '70',
    ),

    'Number of pics' => array(
      'operation' => 'count_values',
      'multivalue' => ',',
      // 'multifields' => 'pic_1,pic_2,pic_3'
    ),
  );

  public function __construct() {
    $this->db = Database::connect($this->db_settings);
    $this->table = $this->db_settings['db_table'];
//    $this->db = new PDO('mysql:host=localhost;dbname=IMJ','root', 'root');
  }


  public function getData(){

    $fields = $this->fieldsToString();
    var_dump('SELECT ' . $fields . ' FROM ' . $this->table
      . ' `__id` %3 = 0');
    $stmt = $this->db->query('SELECT ' . $fields . ' FROM ' . $this->table);

    $this->data = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

//  public function builtTable() {
//
//    // Calculate length for cell table.
//    $length = $this->getLength();
//    echo '<pre>';
//
//    // Titles.
//
//    print ('| ');
//    foreach($this->fields as $title => $field) {
//      print(str_pad($title, $length[$title])) . " | ";
//    }
//    print( "\n");
//
//    // Values.
//
//    foreach($this->data as $row) {
//      print ('| ');
//      foreach ($this->fields as $title => $field) {
//
//        if (array_key_exists($field, $this->special_fields)) {
//
//          $value = count(explode(',', $row[$field]));
//        }
//        else {
//          $value = empty($field) ? '' : $row[$field];
//        }
//        echo str_pad(($value), $length[$title]) . " | ";
//      }
//
//      echo "\n";
//    }
//    echo '</pre>';
//  }

}
