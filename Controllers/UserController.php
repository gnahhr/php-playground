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

    return self::$user->createUser($username, $password);
  }

  public function deleteUser() {
    // var_dump(file_get_contents("php://input"));
    $params = "";
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    parse_str(file_get_contents('php://input'), $result);

    echo $result['username'];
    // var_dump($_DELETE['username']);
    // return self::$user->deleteUser();
  }
}