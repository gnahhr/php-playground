<?php

namespace Controllers;

use Models\Auth;

class AuthController extends BaseController {
  private static $auth;

  public function __construct()
  {
    if (isset(self::$auth)){
      return;
    }

    self::$auth = new Auth();
  }

  public function loginUser()
  {
    ['username' => $username, 'password' => $password] = $_POST;

    return self::$auth->loginUser($username, $password);
  }
}