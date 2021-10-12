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
  $result = $mc->exchange_all();

  $group_name = $result['users'][0]['id'].'&'.$result['users'][1]['id'];
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
<div class="exchange-list">
  <?php if (!empty($result['exchanges'])): ?>
    <?php foreach ($result['exchanges'] as $exchanges): ?>
      <?php if ($exchanges['body_host_id'] === $_SESSION['user_id']): ?>
        <div class="exchange-item">
          <div class="exchange-item-right">
            <div class="msg-time">
              <p><?=date('m/j', strtotime($exchanges['created_at'])); ?></p>
              <p><?=date('H:i', strtotime($exchanges['created_at'])); ?></p>
            </div>
            <div class="host-user-msg">
              <?=$exchanges['body']; ?>
              <div class="host-user-msg-fukidashi"></div>
            </div>
            <div>
              <img src="/img/profile.png" style="width:50px; height:50px;">
              <p style="font-size:10px; text-align:center;">自分</p>
            </div>
          </div>
        </div>
      <?php else: ?>
        <div class="exchange-item">
          <div class="exchange-item-left">
            <div>
              <img src="/img/profile.png" style="width:50px; height:50px;">
              <p style="font-size:10px; text-align:center;"><?=$result['user']['nickname']; ?><br />さん</p>
            </div>
            <div class="guest-user-msg">
              <?=$exchanges['body']; ?>
              <div class="guest-user-msg-fukidashi"></div>
            </div>
            <div class="msg-time">
              <p><?=date('m/j', strtotime($exchanges['created_at'])); ?></p>
              <p><?=date('H:i', strtotime($exchanges['created_at'])); ?></p>
            </div>
          </div>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  <?php else: ?>
    <p style="margin:100px; text-align:center;">まだメッセージはありません。</p>
  <?php endif; ?>
</div>

<form method="post" action="exchange_create.php" class="exchange-form">
  <input type="hidden" name="host_user_id" value="<?=$_GET['h_id']; ?>">
  <input type="hidden" name="guest_user_id" value="<?=$_GET['g_id']; ?>">
  <input type="hidden" name="body_host_id" value="<?=$_GET['h_id']; ?>">
  <input type="hidden" name="group_name" value="<?=$group_name; ?>">
  <textarea name="body" style="width:100%; height:70px;" placeholder="<?=$result['user']['nickname']; ?> さんへメッセージ"></textarea><br/>
  <input type="submit" value="メッセージを送信">
</form>

<?php include '../Views/footer.html'; ?>

<script>
  $(function() {
    setTimeout(function() {
      window.scroll(0,$(document).height());
    },0);
  });
</script>
</body>
</html>