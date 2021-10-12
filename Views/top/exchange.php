<?php 
  session_start();
  session_regenerate_id(true);
  if (isset($_SESSION['login']) == false) {
    echo 'このページをご覧になるにはログインしてください。<br />';
    echo '<a href="/Users/login.php">ログイン画面へ</a>';
    exit();
  }

  require_once(ROOT_PATH .'Views/common/head.php');
  require_once(ROOT_PATH .'Controllers/MusicrossingController.php');
  $mc = new MusicrossingController();
  $result = $mc->exchange();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Musicrossing</title>
  <link rel="stylesheet" type="text/css" href="/css/base.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
</head>

<body>
<?php include '../Views/header.php'; ?>

<section>
  <div class="listbox">
    <p style="text-align: center; font-size: 30px; font-weight: bold;">Exchange List</p>

    <?php foreach ($result['exchange_users'] as $exchange_user): ?>
      <a href="exchange_all.php?h_id=<?=$_SESSION['user_id']; ?>&g_id=<?php if ($exchange_user['host_user_id'] === $_SESSION['user_id']) { echo $exchange_user['guest_user_id']; } elseif ($exchange_user['guest_user_id'] === $_SESSION['user_id']) { echo $exchange_user['host_user_id']; }?>">
        <div class="users">
          <div class="photo">
            <img src="/img/profile.png">
          </div>

          <div class="list">
            <div class="name">
              <?php if ($exchange_user['host_user_id'] === $_SESSION['user_id']): ?>
                <?php foreach ($result['users'] as $user): ?>
                  <?php if ($exchange_user['guest_user_id'] === $user['id']): ?>
                    <p><?=$user['nickname']; ?><span style="font-size: 13px;"> さんとの exchange room</span></p>
                  <?php else: ?>
                    <?php false; ?>
                  <?php endif; ?>
                <?php endforeach; ?>
              <?php elseif ($exchange_user['guest_user_id'] === $_SESSION['user_id']): ?>
                <?php foreach ($result['users'] as $user): ?>
                  <?php if ($exchange_user['host_user_id'] === $user['id']): ?>
                    <p><?=$user['nickname']; ?><span style="font-size: 13px;"> さんとの exchange room</span></p>
                  <?php else: ?>
                    <?php false; ?>
                  <?php endif; ?>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
            <div class="exchange-body">
              <p class="exchange-body-mark">最新</p>
              <p style="color: grey;"><?=$exchange_user['body']; ?></P>
            </div>
          </div>
        </div>
      </a>
    <?php endforeach; ?>

    <div class="nextbotann"></div>
    <ul class="result">
      <li class="page">
        <ul>
          <li class="next">
            <a href="#">次ページ</a>
          </li>
        </ul>
      </li>
    </ul>
    </div>
  </div>
</section>

<?php include '../Views/footer.html'; ?>
</body>
</html>