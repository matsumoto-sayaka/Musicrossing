<?php 
  require_once(ROOT_PATH .'Views/common/head.php');
  require_once(ROOT_PATH .'Controllers/MusicrossingController.php');
  $mc = new MusicrossingController();
  $result = $mc->userprofile();

  // print "<pre>";
  // print_r($result);
  // print "</pre>";
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

<div class="user-profilebox">
  <div class="user-prof-details1">
    <div class="photo-and-dm">
      <div class="user-prof-photo">
        <img src="/img/profile.png">
      </div>
      <div class="dm">
      <a href="exchange_all.php?h_id=<?=$_SESSION['user_id']; ?>&g_id=<?=$result['user']['id']; ?>">メッセージを送る</a>
      </div>
    </div>

    <div class="user-prof-details">
      <div class="user-nickname">
        <p><?=$result['user']['nickname']; ?></p>
      </div>
      <div class="user-gender">
        <?php if ($result['user']['gender'] === 0): ?>
          <p><?= '非公開'; ?></p>
        <?php elseif ($result['user']['gender'] === 1): ?>
          <p><?= '男'; ?></p>
          <?php elseif ($result['user']['gender'] === 2): ?>
          <p><?= '女'; ?></p>
        <?php endif; ?>
      </div>
      <div class="user-age">
        <?php if ($result['user']['age'] === 0): ?>
          <p><?='非公開'; ?></p>
        <?php else: ?>
          <p><?=$result['user']['age'] ;?>代</p>
        <?php endif; ?>
      </div>
      <div class="user-part">
        <?php foreach ($result['part'] as $part): ?>
          <p><?= $result['parts'][$part['part_id']-1]['part']; ?></p>
        <?php endforeach; ?>
      </div>
      <div class="user-skill">
        <?php foreach ($result['work'] as $work): ?>
          <p><?= $result['works'][$work['work_id']-1]['work']; ?></p>
        <?php endforeach; ?>
      </div>
      <div class="user-state">
        <p><?= $result['state'][$result['user']['state_id']-1]['name']; ?></p>
      </div>
    </div>
  </div>

  <div class="user-prof-details2">
    <div class="self-pr">
      <p><?=$result['user']['self_introduction']; ?></p>
    </div>
  </div>
</div>


<?php include '../Views/footer.html'; ?>
</body>
</html>