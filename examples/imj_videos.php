<?php
header('Content-Type: text/html; charset=utf-8');
require '../Database.php';
require '../GenerateTable.php';

$db_settings = array(
  'host'=>'localhost',
  'db_name' => 'IMJ',
  'user' => 'root',
  'pass' => 'root',
  'db_table' => '_raw_videosen',
  'join_table' => array(
    'table' =>'_raw_videoshe',
    'field1' => '_itemnum',
    'field2' => '_itemnum_he',
  ),
  'every_n_rows' => 4,
);

$fields = array(
  'Title' => '',
  'Artist' => '_artiste',
  'Number of pics' => '',
  'Description' => '',
  'Institution' => ''
);


// 'or' get not empty from fields.
$prepare_fields = array(
  'Title' => array(
    'operation' => 'or',
    'fields' => '_titlee,_titlee_he',
  ),

  'Description' => array(
    'operation' => 'or',
    'fields' => '_descriptione,_descriptione_he',
  ),

  'Number of pics' => array(
    'field' => '_multimediae',
    'operation' => 'count_values',
    'separated_by' => ',',
  ),

  'Institution' => array(
    'operation' => 'or',
    'fields' => '_institution,_institution_he',
  ),

//  'Count of fields' => array(
//    'field' => '_multimediae',
//    'operation' => 'count_values',
//    'multifields' => '_pic1,_pic2,_pic3,_pic4,_pic5,_pic6'
//  )
);

$videos_table = new GenerateTable($db_settings, $fields, $prepare_fields);

