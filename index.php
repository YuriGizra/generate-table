<?php
//header('Content-type: text/plain; charset=utf-8');
require 'Database.php';
require 'GenerateTable.php';
//include 'view/header.html';
ini_set('display_errors', 1);
//require 'Jump.php';


$db_settings = array(
  'host'=>'localhost',
  'db_name' => 'IMJ',
  'db_table' => '_raw_exhen',
  'user' => 'root',
  'pass' => 'root',
);

$jump = new GenerateTable($db_settings);

$jump->getData();
$jump->builtTable();


//$db = Database::connect($db_settings);
//var_dump($db);
//$db->select_db( 'IMJ' );
//$stmt = $db->query('SELECT * from _raw_exhen LIMIT 10');
//var_dump($stmt->fetchAll());

//foreach($db->query('SELECT * from "_raw_exhen" LIMIT 10') as $row) {
//  print_r($row);
//}


