<?php

namespace Models;

class Users extends Database {
  protected $fields = ["username", "password"];
  protected $tableName = "users";

  public function getUsers() {
    return $this->fetchAll($this->tableName);
  }

  public function createUser($username, $password) {
    return $this->create($this->fields, $this->tableName, [$username, $password]);
  }

  public function updateUser($fields, $values) {
    $this->update($fields, $values, $this->tableName, 'username', 'username');
  }

  public function deleteUser($username){
    $this->delete($this->tableName, 'username', $username);
  }
}