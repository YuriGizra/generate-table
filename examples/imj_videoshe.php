<?php
header('Content-Type: text/html; charset=utf-8');
require '../Database.php';
require '../GenerateTable.php';

// Todo: check what is wrong:
// Query works: SELECT '' as empty,if(`_titlee_he` = '', `_titlee`,`_titlee_he`), `_artiste_he`, IF(`_multimediae` = '', 0, 1), if(`_descriptione_he` = '', `_descriptione`, `_descriptione_he`),if(`_institution_he` = '', `_institution`,`_institution_he`),'' as empty FROM `_raw_videosen` LEFT JOIN `_raw_videoshe` ON _raw_videosen._itemnum = _raw_videoshe._itemnum_he WHERE `_raw_videoshe`.`__id` %3 = 0


$db_settings = array(
  'host'=>'localhost',
  'db_name' => 'IMJ',
  'user' => 'root',
  'pass' => 'root',
  'db_table' => '_raw_videoshe',
  'join_table' => array(
    'table' =>'_raw_videosen',
    'field1' => '_itemnum_he',
    'field2' => '_itemnum',
  ),
  'every_n_rows' => 3,
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
    'fields' => '_titlee_he,_titlee',
  ),

  'Description' => array(
    'operation' => 'or',
    'fields' => '_descriptione_he,_descriptione,',
  ),

  'Number of pics' => array(
    'field' => '_multimediae',
    'operation' => 'count_values',
    'separated_by' => ',',
  ),

  'Institution' => array(
    'operation' => 'or',
    'fields' => '_institution_he,_institution',
  ),

//  'Count of fields' => array(
//    'field' => '_multimediae',
//    'operation' => 'count_values',
//    'multifields' => '_pic1,_pic2,_pic3,_pic4,_pic5,_pic6'
//  )
);

$videos_table = new GenerateTable($db_settings, $fields, $prepare_fields);

