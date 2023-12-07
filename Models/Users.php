<?php

namespace Models;

class Users extends Database {
  protected $fields = ["username", "password"];
  protected $tableName = "users";

  public function getUsers() {
    return $this->fetchAll($this->tableName);
  }

  public function createUser($username, $password) {
    return $this->create($this->fields, $this->tableName, "username", [$username, $password]);
  }

  public function updateUser($fields, $values, $target) {
    return $this->update($fields, $values, $this->tableName, 'username', $target);
  }

  public function deleteUser($username){
    return $this->delete($this->tableName, 'username', $username);
  }
}