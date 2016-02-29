<?php

class GenerateTable {
  // Connection to database.
  protected $db;

  protected $table;

  // Data to build table.
  public $data = array();

  // Mapping titles to fields in table. Keys is title table, value is database field name, nothing for empty column.
  public $fields = array (
    'Title' => '_titlee',
    'Artist'=> '_artiste',
    'Number of pics' => '_multimediae',
    'Special' => '',
    'Curator' => '',
    'Institution' => '_institution',
//    'Solo' => ''
  );

  // Fields need process values.
  public $special_fields = array (
    '_multimediae' => 'count'
  );

  public function __construct() {
    $this->db = Database::connect();
//    $this->table = $db_settings['db_table'];
  }

  public function getData(){

    $fields = $this->fieldsToString();
    $stmt = $this->db->query('SELECT ' . $fields . ' from ' . $this->table . ' WHERE `__id` %500 = 0');
    $this->data = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function builtTable() {

    // Calculate length for cell table.
    $length = $this->getLength();
    echo '<pre>';

    // Titles.

    print ('| ');
    foreach($this->fields as $title => $field) {
      print(str_pad($title, $length[$title])) . " | ";
    }
    print( "\n");

    // Values.

    foreach($this->data as $row) {
      print ('| ');
      foreach ($this->fields as $title => $field) {

        if (array_key_exists($field, $this->special_fields)) {

          $value = count(explode(',', $row[$field]));
        }
        else {
          $value = empty($field) ? '' : $row[$field];
        }
        echo str_pad(($value), $length[$title]) . " | ";
      }

      echo "\n";
    }
    echo '</pre>';
  }


  /**
   * @return array
   */
  public function getLength()
  {
  // Set length of column by Title.
    $length = array();
    foreach (array_keys($this->fields) as $title) {
      $length[$title] = strlen($title);
    }

    // Increase length by values from table.
    foreach ($this->data as $row) {
      foreach ($row as $field => $value) {
        // skip for special fields.
        if (array_key_exists($field, $this->special_fields)) {
          continue;
        }

        $key = array_search($field, $this->fields);
        if (strlen(trim($value)) > $length[$key]) {
          $length[$key] = strlen(trim($value));
        }
      }
    }
    return $length;
  }

  /**
   * @return string
   */
  public function fieldsToString() {
    $fields = '';
    foreach ($this->fields as $field) {
      if (!empty($field)) {
        $fields .= "`" . $field . "`, ";
      }
    }

    $fields = rtrim($fields, ", ");
    return $fields;
  }
}
