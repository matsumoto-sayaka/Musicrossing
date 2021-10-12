<?php
  session_start();

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Musicrossing</title>
  <link rel="stylesheet" type="text/css" href="/css/base.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script>
  </script>
</head>
<body>
  
  <div class="loginbox">
  <p class="failed-msg"><?php if(isset($message)) {echo $message;} ?></p>
  <div id="login-box">
    <form method="post" action="../Users/login_confirm.php">

    
     <input type="hidden" name="file_name" value="<?php print basename(__FILE__); ?>">

<input type="email" name="email" placeholder="aaa@aaa.com">
<input type="password" name="password">
<input type="submit" value="login" id="login_submit-button" name="login">
</form>
</div>

<div class="password_reset">
<a href="passwordreset.php">パスワードを忘れた方はこちら</a>
</div>

<div class="move_to_signup">
<a href="signup.php">新規登録</a>

</div>
</body>
</html>