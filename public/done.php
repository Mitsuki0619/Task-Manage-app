<?php 
session_start();
require_once '../classes/UserLogic.php';
require_once '../classes/TaskLogic.php';

  //ログインチェック
  $result = UserLogic::checkLogin();
  if(!$result) {
      header('Location: login.php');
  }

  $id = $_GET['id'];
  TaskLogic::doneTask($id);

  $uri = $_SERVER['HTTP_REFERER'];
  header("Location: ".$uri);