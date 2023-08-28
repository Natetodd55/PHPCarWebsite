<?php
require_once 'model.php';
session_start();



$action = isset($_GET['action']) ? $_GET['action'] : '';


switch ($action) {
    case 'createuser':
      include 'views/createuser.php';
      if ($_SERVER['REQUEST_METHOD'] == "POST"){
        if (!isset($_POST['username']) || !isset($_POST['password'])){
          header('Location: createuser.php');
        }else{
          $uname = $_POST['username'];
          $pword = password_hash($_POST['password'], PASSWORD_DEFAULT);
          if (checkUnique($uname) == true){
            createNewUser($uname, $pword);
            $_SESSION['loggedIn'] = true;
            $_SESSION['username'] = $uname;
            $currname = $uname;
            $_SESSION['id'] = getID($currname);
          }
          header('Location: controller.php');
        }
      }
      break;

    case 'login':
      include 'views/login.php';
      if ($_SERVER['REQUEST_METHOD'] == "POST"){
        if (!isset($_POST['username']) || !isset($_POST['password'])){
          header('Location: login.php');
        }else{
          $uname = $_POST['username'];
          $unhashed = $_POST['password'];
          if(loginUser($uname, $unhashed) == true){
            $_SESSION['loggedIn'] = true;
            $_SESSION['username'] = $uname;
            $currname = $uname;
            $_SESSION['id'] = getID($currname);
            header('Location: controller.php');
          }else{
            header('Location: controller.php?action=login');
          }
        }
      }
      break;

    case 'logout':
        $_SESSION['loggedIn'] = false;
        $_SESSION['username'] = "";
        $_SESSION['id'] = 0;
        header('Location: controller.php');
        break;

    case 'secret':
        include 'views/currentPosts.php';
        break;

    case 'createpost':
      include 'views/createpost.php';
      if ($_SERVER['REQUEST_METHOD'] == "POST"){
        if (!isset($_POST['make']) || !isset($_POST['model']) || !isset($_POST['year']) || !isset($_POST['price']) || !isset($_POST['desc'])){
          header('Location: createpost.php');
        }else{
          $make = $_POST['make'];
          $model = $_POST['model'];
          $year = $_POST['year'];
          $price = $_POST['price'];
          $desc = $_POST['desc'];
          $currUserId = getID($_SESSION['username']);
          createNewPost($make, $model, $year, $price, $desc, $currUserId);
          header('Location: controller.php');
        }
      }
      break;

    case 'updatepost':
      include 'views/updatePost.php';
      if ($_SERVER['REQUEST_METHOD'] == "POST"){
        if (!isset($_POST['make']) || !isset($_POST['model']) || !isset($_POST['year']) || !isset($_POST['price']) || !isset($_POST['desc'])){
          header('Location: createpost.php');
        }else{
          $make = $_POST['make'];
          $model = $_POST['model'];
          $year = $_POST['year'];
          $price = $_POST['price'];
          $desc = $_POST['desc'];
          $id = $_POST['updateid'];
          $carid = $id;
          $ownerofpost = getUserID($carid);
          if ($_SESSION['id'] != 0){
            if ($ownerofpost == $_SESSION['id']){
              updatePost($make, $model, $year, $price, $desc, $id);
            }
          }
          header('Location: controller.php');
        }
      }
      break;

    case 'deletepost':
      include 'views/deletepost.php';
      if ($_SERVER['REQUEST_METHOD'] == "POST"){
        $carid = $_POST['deleteid'];
        $ownerofpost = getUserID($carid);
        if ($_SESSION['id'] != 0){
          if ($ownerofpost == $_SESSION['id']){
            deletePost($carid); 
          }
        }
        header('Location: controller.php');
      }
      break;

    case '':
      include 'view.php';
      echo "<h1> Current Posts: </h1>";
      getData();
      break;
}
