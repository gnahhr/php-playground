<?php
  const BASE_PATH = __DIR__ . "\\";

  require('./inc/config.php');
  
  spl_autoload_register(function ($class) {
    require(BASE_PATH . $class . '.php');
  });

  $db = new Models\Database();
  $router = new Router\Router();
  
  $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
  $reqMethod = $_SERVER['REQUEST_METHOD'];
  
  $user = new Router\User(new Models\Users);

  $router->fetchAction($uri, $reqMethod);

  // echo(json_encode($db->create(["username", "password"], "users", ["user5", "password1"])));
  // echo $_SERVER['REQUEST_METHOD'];
?>