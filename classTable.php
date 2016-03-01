<?php
require 'Database.php';
require 'GenerateTable.php';

$db_settings = array(
  'host'=>'localhost',
  'db_name' => 'IMJ',
  'dbtable' => '_raw_chugim',
  'user' => 'root',
  'pass' => 'root',
);

// join left
$add_table = array(
  'name' => '',
  'field' => '',
);

$fields = array(
  'Title' => '',
  'Lecturer' => '',
  'Cost' => '',
  'Description' => '',
  'Number of pics' => ''
);

$prepare_fields = array(
  'Description' => array(
    'operation' => 'cut',
    'length' => '70',
  ),

  'Number of pics' => array(
    'operation' => 'count_values',
    // 'multivalue' => ',',
    // 'multifields' => 'pic_1,pic_2,pic_3'
  ),
);

new GenerateTable($db_settings, $fields);

