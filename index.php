<?php
header('Content-Type: text/html; charset=utf-8');
require 'Database.php';
require 'GenerateTable.php';
require 'Artists.php';
require 'ClassTable.php';
ini_set('display_errors', 1);


$db_settings = array(
  'host'=>'localhost',
  'db_name' => 'IMJ',
  'db_table' => '_raw_exhen',
  'user' => 'root',
  'pass' => 'root',
);


//$jump = new GenerateTable($db_settings);
//
//$jump->getData();
//$jump->builtTable();

//$artistTable = new Artists();
//$artistTable->getData();
//$artistTable->builtTable();

$classTable = new ClassTable();
$classTable->getData();
$classTable->builtTable();

