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

<section>
  <div class="listbox">
    <div class="users">
      <div class="photo">
        <img src="/img/profile.png">
      </div>

      <div class="list">
        <div class="name">
          <p>ハナコ</p>
        </div>

        <div class="detail">
          <div class="part">
            <p>ギター</p>
          </div>
          <div class="gender">
            <p>女</p>
          </div>
          <div class="age">
            <p>20代</p>
          </div>
          <div class="state">
            <p>東京都</p>
          </div>
          <div class="skill">
            <p>作曲、演奏</p>
          </div>
        </div>
      </div>
    </div>

    <div class="users">
      <div class="photo">
        <img src="/img/profile.png">
      </div>

      <div class="list">
        <div class="name">
          <p>タロウ</p>
        </div>

        <div class="detail">
          <div class="part">
            <p>ギター</p>
          </div>
          <div class="gender">
            <p>男</p>
          </div>
          <div class="age">
            <p>20代</p>
          </div>
          <div class="state">
            <p>東京都</p>
          </div>
          <div class="skill">
            <p>作曲、演奏</p>
          </div>
        </div>
      </div>
    </div>
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