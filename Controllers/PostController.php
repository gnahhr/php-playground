<?php

namespace Controllers;

use Models\Posts;

class PostController extends BaseController {
  private static $post;

  public function __construct()
  {
    if (isset(self::$post)){
      return;
    }

    self::$post = new Posts();
  }

  public function getPost()
  {
    $id = $_SERVER['QUERY_STRING'];
    return self::$post->getPost($id);
  }

  public function getPosts()
  {
    return self::$post->getPosts();
  }

  public function createPost() {
    ['title' => $title, 'body' => $body, 'username' => $username] = $_POST;

    return self::$post->createPost($title, $body, $username);
  }

  public function updatePost() {
    ['title' => $title, 'body' => $body] = $_POST;
    $id = $_SERVER['QUERY_STRING'];
    return self::$post->updatePost(['title', 'body'], [$title, $body], $id);
  }

  public function deletePost(){
    $id = $_SERVER['QUERY_STRING'];

    return self::$post->deletePost($id);
  }
}