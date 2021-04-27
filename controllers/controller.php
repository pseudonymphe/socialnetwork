<?php

$action = isset($_GET["action"]) ? $_GET["action"] : "display";

switch ($action) {

  case 'register':
    // code...
    break;

  case 'logout':
    if (isset($_SESSION['userId'])) {
      unset($_SESSION['userId']);
    }
    header('Location: ?action=display');
    break;

  case 'login':
    include "../models/UserManager.php";
    if (isset($_POST['username']) && isset($_POST['password'])) {
      $userId = GetUserIdFromUserAndPassword($_POST['username'], $_POST['password']);
      if ($userId > 0) {
        $_SESSION['userId'] = $userId;
        header('Location: ?action=display');
      } else {
        $errorMsg = "Wrong login and/or password.";
        include "../views/LoginForm.php";
      }
    } else {
      include "../views/LoginForm.php";
    }
    break;

  case 'newMsg':
    // code...
    break;

  case 'newComment':
    // code...
    break;

  case 'display':
  default:
    include "../models/PostManager.php";
    if (isset($_GET['search'])) {
      $posts = SearchInPosts($_GET['search']);
    } else {
      $posts = GetAllPosts();
    }
    
    include "../models/CommentManager.php";
    $comments = array();

    foreach ($posts as $onePost) {
      $postId = $onePost['id'];
      $comments[$onePost['id']] = GetAllCommentsFromPostId($onePost['id']);
    }

    // ===================HARDCODED PART===========================
    // format idPost => array of comments
    /*$comments[1] = array(
      array("nickname" => "FakeUser1", "created_at" => "1970-01-01 00:00:00", "content" => "Fake comment 01."),
      array("nickname" => "FakeUser2", "created_at" => "1970-01-02 00:00:00", "content" => "Fake comment 02."),
      array("nickname" => "FakeUser1", "created_at" => "1970-01-03 00:00:00", "content" => "Fake comment 03.")
    );
    $comments[3] = array(
      array("nickname" => "FakeUser1", "created_at" => "1970-01-01 00:00:00", "content" => "Fake comment 04."),
    );*/
    // =============================================================

    include "../views/DisplayPosts.php";
    break;
}
