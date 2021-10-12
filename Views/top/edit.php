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
  <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
</head>

<body>
<?php include '../Views/header.php'; ?>

<div class="myprofilebox">
  <div class="myprof-details1">
    <div class="myprof-contents">
      <div class="myprof-photo">
        <p>プロフィール画像</p>
      </div>
      <div class="myprof-nickname">
        <p>ニックネーム</p>
      </div>
      <div class="myprof-gender">
        <p>性別</p>
      </div>
      <div class="myprof-age">
        <p>年代</p>
      </div>
      <div class="myprof-part">
        <p>担当パート</p>
      </div>
      <div class="myprof-skill">
        <p>業務領域</p>
      </div>
      <div class="mystate">
        <p>都道府県</p>
      </div>
    </div>

    <div class="myprof-answer">
      <div class="myprof-photo-answer">
        <img src="/img/profile.png">
      </div>
      <div class="myprof-nickname-answer">
        <p>：　ハナコ</p>
      </div>
      <div class="myprof-gender-answer">
        <p>：　女</p>
      </div>
      <div class="myprof-age-answer">
        <p>：　20代</p>
      </div>
      <div class="myprof-part-answer">
        <p>：　ギター</p>
      </div>
      <div class="myprof-skill-answer">
        <p>：　作曲、演奏</p>
      </div>
      <div class="myprof-state-answer">
        <p>：　東京都</p>
      </div>
    </div>
  </div>
  <div class="myprof-details2">
    <div class="self-pr">
      <p>活動の拠点は下北沢です。活動の幅を広げたくて登録しました。お気軽にご連絡ください(^ ^)/</p>
    </div>
  </div>
  <div class="update">
        <a href="update.php">プロフィール更新</a>
    </div>
</div>


<?php include '../Views/footer.html'; ?>
</body>
</html>