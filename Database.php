<?php

class Database {

  protected static $db;

  private function __construct($settings) {

    try {
      self::$db = new PDO(
        'mysql:host=' . $settings['host'] . ';dbname='. $settings['db_name'],
        $settings['user'],
        $settings['pass']
      );
      self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
      echo "Connection Error: " . $e->getMessage();
    }
  }

  // Singleton connection.
  public static function connect($settings) {
    if (!self::$db) {
      new Database($settings);
    }

    return self::$db;
  }
}
