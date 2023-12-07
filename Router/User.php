<?php

namespace Router;

class User extends Router {
  public function __construct()
  {
    $this->get('/users', "getUsers", "User");
    $this->post('/user', "createUser", "User");
    $this->put('/user', "updateUser", "User");
    $this->delete('/user', "deleteUser", "User");
  }
};