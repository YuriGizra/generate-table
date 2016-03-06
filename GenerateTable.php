<?php

class GenerateTable {
  // Connection to database.
  protected $dbConnction;

  // database settings.
  protected $dbSettings;

  // Data to build table.
  public $data;

  // Mapping titles to fields in table. Keys is title table, value is database field name, nothing for empty column.
  public $fields;

  // Fields need process values.
  public $prepare_fields = array();

  public function __construct($db_settings, $fields, $prepare_fields) {
    $this->dbSettings = $db_settings;
    $this->fields = $fields;
    $this->prepare_fields = $prepare_fields;
    $this->dbConnction = Database::connect($db_settings);

    $this->getData();

    $table_data = $this->prepareValues();

    $this->builtTable($table_data);
  }

  /**
   *
   */
  public function getData() {

    // todo: join multitable - 'join_table' = array( 'table_name' => 'field1=field2', ..., ).
    $join = !empty($this->dbSettings['join_table']) ?
      ' LEFT JOIN ' . $this->dbSettings['join_table']['table'] . ' ON '
      . $this->dbSettings['db_table'] . '.' . $this->dbSettings['join_table']['field1']
      . '=' . $this->dbSettings['join_table']['table'] . '.' . $this->dbSettings['join_table']['field2'] . ' ' :
      '';
    $stmt = $this->dbConnction->query('SELECT * FROM ' . $this->dbSettings['db_table']
      . $join . ' WHERE ' . $this->dbSettings['db_table'] . '.`__id` %' . $this->dbSettings['every_n_rows'] . ' = 0');
    $this->data = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function prepareValues() {
    $table_data = array();
    $n=0;
    foreach ($this->data as $row) {

      foreach ($this->fields as $title => $field) {

        // Simple mapping.
        if (!array_key_exists($title, $this->prepare_fields)){
          $table_data[$n][$title] = empty($row[$field]) ? '' : trim($row[$field]);
        }
        else {
          $table_data[$n][$title] = $this->handleValue($this->prepare_fields[$title], $row);
        }
      }
      $n++;
    }
    return $table_data;
  }

  public function builtTable($table_data) {

    // Calculate length for cell table.
    $length = $this->getLength($table_data);
    echo '<pre>';

    // Titles.

    print ('| ');
    foreach($this->fields as $title => $field) {
      print(str_pad($title, $length[$title])) . " | ";
    }
    print( "\n");

    // Values.

    foreach($table_data as $row) {
      print ('| ');
      foreach ($row as $title => $value) {
        echo str_pad(($value), $length[$title]) . " | ";
      }

      echo "\n";
    }
    echo '</pre>';
  }


  /**
   * @return array
   */
  public function getLength($table_data)
  {

    // Set length of column by Title.
    $length = array();
    foreach (reset($table_data) as $title => $value) {
      $length[$title] = strlen($title);
    }

    // Increase length by longest value by col.
    foreach ($table_data as $row) {
      foreach ($row as $key => $value) {
        if (strlen($value) > $length[$key]) {
          $length[$key] = strlen($value);
        }
      }
    }

    return $length;
  }

  /**
   * Return handled value by settings operation.
   *
   * @param $settings
   * field -
   *
   * Operations:
   *   text_limit - Cut string until $settings['length'] char.
   *   concat - concatenate fields and separate with $settings['separate'].
   *   count_values -
   *   count_fields -
   *   or -
   *
   *   Todo: fill Operations.
   * @param $row
   *   Array. The row from sql table.
   *
   * @return int|string|void.
   *
   */

  public function handleValue($settings, $row) {

    $value='';

    switch ($settings['operation']) {

      case 'text_limit':

        // Todo: for hebrew : mb_substr ("String", 0, $len, 'utf-8') or mb_strcut();
        $value = substr(strip_tags($row[$settings['field']]), 0, $settings['length']);
        return  $value;

      case 'concat':
        $fields = explode(',', $settings['fields']);
        foreach ($fields as $field) {
          $value .= $row[$field] . $settings['separate'];
        }
        return rtrim($value, $settings['separate']);

      case 'count_values':
        $values = explode(',', $row[$settings['field']]);
        return count(array_filter($values));


      case 'count_fields':

        if (!empty($settings['multifields'])){
          $value=0;
          $fields = explode(',', $settings['multifields']);

          foreach($fields as $field ) {
            if(!empty($row[$field])) $value++;
          }
          return $value;
        }
        return;

      case 'or':
        $fields = explode(',', $settings['fields']);
        foreach($fields as $field) {
          if (empty($row[$field])){
            continue;
          }
          $value = trim($row[$field]);
        }

      return $value;


      default:
        return;
    }


    return;
  }

}
