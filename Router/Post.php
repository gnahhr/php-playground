<?php

namespace Router;

class Post extends Router
{
  public function __construct() {
    $this->get('/post', "getPost", "Post");
    $this->get('/posts', "getPosts", "Post");
    $this->post('/post', "createPost", "Post");
    $this->put('/post', "updatePost", "Post");
    $this->delete('/post', "deletePost", "Post");
  }
}