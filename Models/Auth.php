<?php

namespace Models;

class Auth extends Database {

  public function loginUser($username, $password) {
    $user = $this->fetch('users', 'username', [$username]);

    if (!isset($user) || !password_verify($password, $user['password'])) {
      header("HTTP/1.1 200 OK");
      return ['message' => "Invalid username/password"];
    }

    return ['username' => $username];
  }
}