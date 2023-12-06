<?php

namespace Router;

class User extends Router {
  public function __construct() {
    $this->get('/users', "getUsers", "User");
    $this->post('/users', "createUser", "User");
    $this->delete('/users', "deleteUser", "User");
  }
};