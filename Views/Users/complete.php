<?php
  require_once(ROOT_PATH .'Controllers/MusicrossingController.php');
  $user = new MusicrossingController();
  $params = $user->complete();
  

if(isset($_POST['file_name'])) {
  if($_POST['file_name'] == "signup.php") {
      $result = $user->registUser();
  }
}


        // print_r($_POST);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Musicrossing</title>
  <link rel="stylesheet" type="text/css" href="/css/base.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>

  <div class="formarea">
    <div class="form">
      <div class="form-title">
        <p class="form-title-text">登録できました!!</p>
      </div>
      <div class="move_to_login">
        <a href="../Users/login.php">ログイン</a>
      </div>

    </div>
  </div>

</body>
</html>