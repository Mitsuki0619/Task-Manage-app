<?php
session_start();
require_once '../classes/UserLogic.php';
require_once '../classes/TaskLogic.php';

//ログインチェック
$result = UserLogic::checkLogin();
if(!$result) {
    header('Location: login.php');
}
$userdata = $_SESSION['login_user'];

$search_task = TaskLogic::searchTitle($userdata);
var_dump($search_task);

var_dump($_POST);