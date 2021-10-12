<?php 
session_start();
require_once(ROOT_PATH .'Views/common/head.php');
require_once(ROOT_PATH .'Controllers/MusicrossingController.php');
$mc = new MusicrossingController();
$result = $mc->index();





// print "<pre>";
// print_r($_POST);
// print "</pre>";

// print "<pre>";
// print_r($result);
// print "</pre>";

// print "<pre>";
// print_r($_SESSION);
// print "</pre>";

// $post = $_POST;
// $file_name = $post['file_name'];


// require_once(ROOT_PATH .'Controllers/testdate.php');
//   $allUsers = getAllUsers();
//   print "<pre>";
//   print_r($allUsers);
//   print "</pre>";



//   $count = 0;
//   foreach ($result['users'] as $user) {
//       $count++; 
//       print "●";print $count;print "●";print "<br />";
//       print $user['u1_email'];print "<br />";
//       print "<br />";
//   }

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
    
    <?php foreach ($result['users'] as $user): ?>
      <?php $work_count = 0; ?>
      <?php $part_count = 0; ?>
      <a href="userprofile.php?id=<?=$user['id']; ?>">
        <div class="users">
          <div class="photo">
            <img src="/img/profile.png">
          </div>

          <div class="list">
            <div class="name-box">
              <p style="font-size: 12px; font-weight: bold; padding-bottom: 5px;">ニックネーム：</p>
              <p class="name"><?=$user['nickname'] ;?></p>
            </div>

            <div class="detail">
              <div class="part-box">
                <p class="users-item-title">担当パート</p>
                <div class="part">
                  <?php foreach ($result['parts'] as $part): ?>
                    <?php if ($part['user_id'] === $user['id']): ?>
                      <p><?=$result['part_name'][$part['part_id']-1]['part']; ?></p>
                      <?php $part_count++; ?>
                    <?php else: ?>
                      <?php false; ?>
                    <?php endif; ?>
                  <?php endforeach; ?>
                  <?php if ($part_count === 0): ?>
                    <p>未選択</p>
                  <?php endif; ?>
                </div>
              </div>
              <div class="gender-box">
                <p class="users-item-title">性別</p>
                <div class="gender">
                  <?php if ($user['gender'] === 0): ?>
                    <p><?= '非公開'; ?></p>
                  <?php elseif ($user['gender'] === 1): ?>
                    <p><?= '男'; ?></p>
                  <?php elseif ($user['gender'] === 2): ?>
                    <p><?= '女'; ?></p>
                  <?php endif; ?>
                </div>
              </div>
              <div class="age-box">
                <p class="users-item-title">年代</p>
                <div class="age">
                  <?php if ($user['age'] === 0): ?>
                    <p><?='非公開'; ?></p>
                  <?php else: ?>
                    <p><?=$user['age'] ;?>代</p>
                  <?php endif; ?>
                </div>
              </div>
              <div class="state-box">
                <p class="users-item-title">現住地</p>
                <div class="state">
                  <p><?= $result['state_name'][$user['state_id']-1]['name']; ?></p>
                </div>
              </div>
              <div class="skill-box">
                <p class="users-item-title">スキル</p>
                <div class="skill">
                  <?php foreach ($result['works'] as $work): ?>
                    <?php if ($work['user_id'] === $user['id']): ?>
                      <p><?=$result['work_name'][$work['work_id']-1]['work']; ?></p>
                      <?php $work_count++; ?>
                    <?php else: ?>
                      <?php false; ?>
                    <?php endif; ?>
                  <?php endforeach; ?>
                  <?php if ($work_count === 0): ?>
                    <p>未選択</p>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>

          <div class="faborite-done">
            <img src="/img/favorite_done.png">
          </div>
        </div>
      </a>
    <?php endforeach; ?>

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