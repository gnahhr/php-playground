<?php

namespace Controllers;

use Models\Users;

class UserController extends BaseController {
  private static $user;

  public function __construct()
  { 
    if (isset($user)) {
      return;
    }

    self::$user = new Users();
  }

  public function getUsers() {
    return self::$user->getUsers();
  }

  public function createUser() {
    ['username' => $username, 'password' => $password] = $_POST;

    return self::$user->createUser($username, password_hash($password, PASSWORD_BCRYPT));
  }

  public function updateUser() {
    // Change Password
    ['username' => $username, 'password' => $password] = $_POST;

    return self::$user->updateUser(['password'], [$password], $username);
  }

  public function deleteUser() {
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    return self::$user->deleteUser($_POST['username']);
  }
}