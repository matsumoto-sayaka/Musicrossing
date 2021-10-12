<?php
require_once(ROOT_PATH .'Views/common/head.php');
require_once(ROOT_PATH .'Controllers/MusicrossingController.php');
$mc = new MusicrossingController();
$result = $mc->login_confirm();

if ($result['user'] == true) {
    session_start();
    $_SESSION['login'] = 1;
    $_SESSION['user_id'] = $result['user']['id'];
    $_SESSION['name'] = $result['user']['nickname'];
    header('Location: ../top/index.php');
} else {
    header('Location: login.php');
    exit();
}