<?php

namespace Models;

class Posts extends Database {
  protected $fields = ["title", "body", "username"];
  protected $tableName = "posts";

  public function getPosts() {
    return $this->fetchAll($this->tableName);
  }

  public function getPost($id) {
    return $this->fetch($this->tableName, 'id', $id);
  }

  public function createPost($title, $body, $username) {
    return $this->create($this->fields, $this->tableName, "id", [$title, $body, $username]);
  }

  public function updatePost($fields, $values, $target) {
    return $this->update($fields, $values, $this->tableName, 'id', $target);
  }

  public function deletePost($id){
    return $this->delete($this->tableName, 'id', $id);
  }
}