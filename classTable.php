<?php
require 'Database.php';
require 'GenerateTable.php';

$db_settings = array(
  'host'=>'localhost',
  'db_name' => 'IMJ',
  'user' => 'root',
  'pass' => 'root',
  'db_table' => '_raw_chugim',
  'join_table' => array(
    'table' =>'_raw_lecturer',
    'field1' => '_lecturer',
    'field2' => '_idnum',
  ),
  'every_n_rows' => 2,
);

$fields = array(
  'Title' => '',
  'Lecturer' => '_firstname',
  'Cost' => '_cost',
  'Description' => '',
  'Number of pics' => ''
);

$prepare_fields = array(
  'Title' => array(
    'operation' => 'concat',
    'fields' => '_chugnum,_catnum',
    'separate' => '-'
  ),

//  'Lecturer' => array(
//    'operation' => 'concat',
//    'fields' => '_firstname,_lastname',
//    'separate' => ' '
//  ),
  'Description' => array(
    'field' => '_description',
    'operation' => 'cut',
    'length' => '70',
  ),

  'Number of pics' => array(
    'operation' => 'count_values',
    // 'multivalue' => ',',
     'multifields' => '_pic_1,_pic_2,_pic_3,_pic_4,_pic_5,_pic_6'
  ),
);

new GenerateTable($db_settings, $fields, $prepare_fields);

