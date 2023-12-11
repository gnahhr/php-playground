<?php
  const BASE_PATH = __DIR__ . "\\";
  header('Access-Control-Allow-Origin: *');
  header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
  header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
  require('./inc/config.php');
  
  spl_autoload_register(function ($class) {
    require(BASE_PATH . $class . '.php');
  });

  $db = new Models\Database();
  $router = new Router\Router();
  
  $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
  $reqMethod = $_SERVER['REQUEST_METHOD'];
  
  new Router\User(new Models\Users);
  new Router\Post(new Models\Posts);
  new Router\Auth(new Models\Auth);

  $router->fetchAction($uri, $reqMethod);

  // echo(json_encode($db->create(["username", "password"], "users", ["user5", "password1"])));
  // echo $_SERVER['REQUEST_METHOD'];
?>