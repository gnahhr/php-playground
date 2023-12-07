<?php

namespace Router;

class Auth extends Router
{
  public function __construct() {
    $this->post('/login', "loginUser", "Auth");
  }
}