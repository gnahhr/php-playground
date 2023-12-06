<?php

namespace Router;
use Controllers\UserController;

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
  }

  private function createRoute($url, $method, $action, $model) {
    self::$routes[$method][$url] = [
      'action' => $action,
      'model' => self::$controllerWrapper[$model],
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
    ['action' => $action, 'model' => $model] = self::$routes[$reqMethod][$url];
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($model->{$action}());
  }
}