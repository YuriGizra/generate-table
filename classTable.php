<?php
header('Content-Type: text/html; charset=utf-8');
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
  'every_n_rows' => 4,
);

$fields = array(
  'Title' => '',
  'Lecturer' => '',
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

  'Lecturer' => array(
    'operation' => 'concat',
    'fields' => '_firstname,_lastname',
    'separate' => ' '
  ),
  'Description' => array(
    'field' => '_description',
    'operation' => 'cut',
    'length' => '70',
  ),

  'Number of pics' => array(
    'operation' => 'count_values',
    // 'multivalue' => ',',
     'multifields' => '_pic1,_pic2,_pic3,_pic4,_pic5,_pic6'
  ),
);

new GenerateTable($db_settings, $fields, $prepare_fields);

