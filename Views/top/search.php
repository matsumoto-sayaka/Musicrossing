<?php
session_start();

  require_once(ROOT_PATH .'Controllers/MusicrossingController.php');

  $mc = new MusicrossingController();
  $params = $mc->signup();

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

<div class="searchbox">
  <div class="searchtitle">
    <p>会員検索</p>
  </div>


  <div class="searchmain">
    <!-- <form method="post" action="index.php"> -->
    <form method="post" action="searchlist.php">

    <input type="hidden" name="file_name" value="<?php print basename(__FILE__); ?>">
      
    <p class="fieldtitle">▼性別</p>



            <label>
          <input type="radio" name="gender" value="0" checked>未選択　
        </label>




        
        <label>
          <input type="radio" name="gender" value="1">男　　
        </label>
        <label>
          <input type="radio" name="gender" value="2">女
        </label>

    <p class="fieldtitle">▼年代</p>
        <select name="age">



        <option value="0">選択してください</option>

      

          <option value="10">10代</option>
          <option value="20">20代</option>
          <option value="30">30代</option>
          <option value="40">40代</option>
          <option value="50">50代</option>
          <option value="60">60代</option>
          <option value="70">70代</option>
          <option value="80">80代</option>
          <option value="90">90代</option>
        </select>

    <p class="fieldtitle">▼担当パート</p>
      <?php foreach($params['part'] as $key=>$parts): ?>
        <input type="checkbox" name="part[<?=$key ?>]" value="<?=$parts['id'] ?>"><?=$parts['part'] ?>
      <?php endforeach ?>

    <p class="fieldtitle">▼業務領域</p>
      <?php foreach($params['work'] as $key=>$works): ?>
        <input type="checkbox" name="work[<?=$key ?>]" value="<?=$works['id'] ?>"><?=$works['work'] ?>
      <?php endforeach ?>

    <p class="fieldtitle">▼都道府県</p>
      <select name="state_id">

    
        <option value="0">選択してください</option>


        <?php foreach($params['state'] as $states): ?>
          <option value="<?=$states['id'] ?>"><?=$states['name'] ?></option>
        <?php endforeach ?>
        </select>
        </div>

        <div class="searchbotann-box">
          <input type="submit" value="検  索" class=sendbtn></input>
        </div>
      </form>
  </div>
</div>


      <?php include '../Views/footer.html'; ?>

</body>
</html>