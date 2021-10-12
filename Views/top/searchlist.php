<?php 
session_start();

require_once(ROOT_PATH .'Views/common/head.php');
require_once(ROOT_PATH . '/Controllers/DynamicProperty.php');
require_once(ROOT_PATH .'Views/common/function.php');
require_once(ROOT_PATH .'Controllers/MusicrossingController.php');

$mc = new MusicrossingController();
$results = new DynamicProperty();
$results = $mc->getUsersInfo();

$users = isset($results) ? $results->users : array();
$part = isset($results) ? $results->part_convenience : array();
$work = isset($results) ? $results->work_convenience : array();

// print "<pre>";
// print "■■■■■■■■■■■■■■■■■■■■■　ユーザ　■■■■■■■■■■■■■■■■■■■■■<br />";
// print_r($users);
// print "■■■■■■■■■■■■■■■■■■■■■　パート　■■■■■■■■■■■■■■■■■■■■■<br />";
// print_r($part);
// print "■■■■■■■■■■■■■■■■■■■■■　ワーク　■■■■■■■■■■■■■■■■■■■■■<br />";
// print_r($work);
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


<section>
<div class="background">
  <div class="listbox">
    
  <!--↓↓↓↓↓↓↓ ■■■■■■■　ユーザ情報の数だけループ　■■■■■■■ ここから ↓↓↓↓↓↓↓-->
    <?php foreach ($users as $user): ?>

      <?php $user_id = h('u1_id', $user); ?>
      <a href="userprofile.php?id=<?=$user_id; ?>">
      <?php $partInfo = getPartOrWorkRow_from_array($user_id, $part); ?>
      <?php $workInfo = getPartOrWorkRow_from_array($user_id, $work); ?>
      <div class="users">
        <div class="photo">
          <img src="/img/profile.png">
        </div>

        <div class="list">
          <div class="name">
            <p><?=h('u1_nickname', $user); ?></p>
          </div>

          <div class="detail">
            <div class="part">
                  <p><?=$partInfo['all_name']; ?></p>
            </div>
            <div class="gender">
              <?php if ($user['u1_gender'] == 0): ?>
                <p><?= '未選択'; ?></p>
              <?php elseif ($user['u1_gender'] == 1): ?>
                <p><?= '男'; ?></p>
                <?php elseif ($user['u1_gender'] == 2): ?>
                <p><?= '女'; ?></p>
              <?php endif; ?>
            </div>
            <div class="age">
              <p>
                <?php
                if ($user['u1_age'] == 0) {
                    print "未登録";
                }else{
                    print h('u1_age', $user)."代";
                }
                ?>
              </p>
            </div>
            <div class="state">
              <p><?=h('ms1_name', $user) ; ?></p>
            </div>
            <div class="skill">
                <p><?=$workInfo['all_name']; ?></p>
            </div>
          </div>
        </div>

        <div class="faborite-done">
          <img src="/img/favorite_done.png">
        </div>
      </div>
      </a>
    <?php endforeach; ?>
    <!--↑↑↑↑↑↑↑ ■■■■■■■　ユーザ情報の数だけループ　■■■■■■■ ここから ↑↑↑↑↑↑↑-->

      <div class="nextbotann"></div>
        <ul class="result">
          <li class="next">
            <a href="#">次ページ</a>
          </li>
        </ul>
      </div>
      </div>
    </div>
  </div>
</section>

<?php include '../Views/footer.html'; ?>
</body>
</html>