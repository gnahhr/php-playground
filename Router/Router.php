<?php

namespace Router;
use Controllers\UserController;
use Controllers\AuthController;
use Controllers\PostController;

class Router
{
  protected static $routes = [
    'GET' => [],
    'POST' => [],
    'PUT' => [],
    'DELETE' => [],
  ];

  protected static $controllerWrapper = [];

  public function __construct()
  {
    self::$controllerWrapper['User'] = new UserController();
    self::$controllerWrapper['Auth'] = new AuthController();
    self::$controllerWrapper['Post'] = new PostController();
  }

  private function createRoute($url, $method, $action, $model) {
    self::$routes[$method][$url] = [
      'action' => $action,
      'model' => $model,
    ];
  }

  public function get($url, $action, $model)
  {
    $this->createRoute($url, 'GET', $action, $model);
  }
  
  public function put($url, $action, $model)
  {
    $this->createRoute($url, 'PUT', $action, $model);
  }

  public function post($url, $action, $model)
  {
    $this->createRoute($url, 'POST', $action, $model);
  }

  public function delete($url, $action, $model)
  {
    $this->createRoute($url, 'DELETE', $action, $model);
  }

  public function fetchAction($url, $reqMethod) {
    $reqType = $reqMethod;

    if (isset($_POST['reqType']) && $reqMethod === 'POST') {
      $reqType = $_POST['reqType'];
    }
    
    if (!isset(self::$routes[$reqType][$url])) {
      header('HTTP/1.1 404 Not Found');
      echo "Not found!";
      return;
    }

    ['action' => $action, 'model' => $model] = self::$routes[$reqType][$url];

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(self::$controllerWrapper[$model]->{$action}());
  }
}