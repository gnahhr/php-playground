<?php
namespace Models;
use PDO;
use PDOException;

class Database
{
  protected static $db;

  public function __construct() {
    if (isset(self::$db)) {
      return;
    }

    try { 
      $dsn = "mysql:host=" . DB_HOST . ":" . DB_PORT . ";dbname=" . DB_NAME;
      self::$db = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
      self::$db ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }

  public function fetchAll($table) {
    $query = "SELECT * FROM " . $table;
    $stmt = self::$db->prepare($query);
    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($data) > 0) {
      header("HTTP/1.1 200 OK");
    } else {
      header("HTTP/1.1 204 No Content");
    }
    return $data;
  }

  public function fetch($table, $condition, $params = []) {
    $query = "SELECT * FROM " . $table . " WHERE " . $condition . " = ?";
    $stmt = self::$db->prepare($query);
    $stmt->execute($params);

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function create($fields = [], $table, $values = []) {
    
    $fieldsJoin = join(', ', $fields);
    $valuesJoin = str_repeat("?, ", count($fields));

    if ($this->fetch($table, "username", [$values[0]])) {
      header("HTTP/1.1 404 Not Found");
      return "Username already exists"; 
    }

    $query = "INSERT INTO $table ($fieldsJoin) VALUES (". rtrim($valuesJoin,", ") . ")";
    
    $stmt = self::$db->prepare($query);
    $status = $stmt->execute($values);

    if ($status) {
      header("HTTP/1.1 201 Created");
      return "User created successfully!";
    } else {
      header("HTTP/1.1 409 Created");
      return "Something went wrong!";
    }
  }

  public function update($fields = [], $values = [], $table, $targetCol, $targetData) {
    $updatedValues = "";

    if (!$this->fetch($table, $targetCol, [$targetData])) {
      return "Data doesn't exist!";
    }

    for ($x = 0; $x < count($fields); $x++) {
      $updatedValues = $updatedValues . $fields[$x] . "=" . $values[$x] . ", ";
    }

    $query = "UPDATE $table SET VALUES $updatedValues WHERE $targetCol = $targetData";

    $stmt = self::$db->prepare($query);
    $status = $stmt->execute($values);

    if ($status) {
      return "User updated successfully!";
    } else {
      return "Something went wrong!";
    }
  }

  public function delete($table, $targetCol, $targetData) {
    $query = "DELETE FROM $table WHERE $targetCol = $targetData";

    if (!$this->fetch($table, $targetCol, [$targetData])) {
      return "Data doesn't exist!";
    }

    $stmt = self::$db->prepare($query);
    $status = $stmt->execute();

    if ($status) {
      return "User deleted successfully!";
    } else {
      return "Something went wrong!";
    }
  }
}