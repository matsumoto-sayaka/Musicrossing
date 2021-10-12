<?php
require_once(ROOT_PATH .'Views/common/head.php');
require_once(ROOT_PATH .'Controllers/MusicrossingController.php');
$mc = new MusicrossingController();
$result = $mc->exchange_create();

header('Location: exchange_all.php?h_id='.$_POST['host_user_id'].'&g_id='.$_POST['guest_user_id']);
exit();