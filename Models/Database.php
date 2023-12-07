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

  public function create($fields = [], $table, $uniqueValue, $values = []) {
    
    $fieldsJoin = join(', ', $fields);
    $valuesJoin = str_repeat("?, ", count($fields));

    if ($this->fetch($table, $uniqueValue, [$values[0]])) {
      header("HTTP/1.1 404 Not Found");
      return "Data already exists"; 
    }

    $query = "INSERT INTO $table ($fieldsJoin) VALUES (". rtrim($valuesJoin,", ") . ")";
    
    $stmt = self::$db->prepare($query);
    $status = $stmt->execute($values);

    if ($status) {
      header("HTTP/1.1 201 Created");
      return "Data created successfully!";
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
      $updatedValues = $updatedValues . $fields[$x] . " = '" . $values[$x] . "', ";
    }

    $query = "UPDATE $table SET " . rtrim($updatedValues,", ") . " WHERE $targetCol = ?";
    
    $stmt = self::$db->prepare($query);
    $status = $stmt->execute([$targetData]);

    if ($status) {
      return "Data updated successfully!";
    } else {
      return "Something went wrong!";
    }
  }

  public function delete($table, $targetCol, $targetData) {
    $query = "DELETE FROM $table WHERE $targetCol = \"$targetData\"";
    
    if (!$this->fetch($table, $targetCol, [$targetData])) {
      header("HTTP/1.1 404 Not Found");
      return ['message' => "Data doesn't exist!"];
    }

    $stmt = self::$db->prepare($query);
    $status = $stmt->execute();

    if ($status) {
      header("HTTP/1.1 200 Success");
      return ['message' => "Data deleted successfully!"];
    } else {
      header("HTTP/1.1 200 Success");
      return ['message' => "Something went wrong!"];
    }
  }
}