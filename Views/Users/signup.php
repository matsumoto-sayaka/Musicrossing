<?php
  require_once(ROOT_PATH .'Controllers/MusicrossingController.php');

  $mc = new MusicrossingController();
  $params = $mc->signup();

  // print_r($params);

  
//   $errors = [];
//   if(isset($_POST)) {

//     // メールアドレスのチェック
//     if(isset($_POST['email'])) {
//       if(empty($_POST['email'])) {
//         $errors['email'] = "メールアドレスは必須入力です。正しくご入力ください。";
//       } elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
//         $errors['email'] = "メールアドレスは正しくご入力ください。";
//       } 
//       foreach($all_params['users'] as $user) {
//         if($_POST['email'] == $user['email']) {
//           $errors['email'] = "既に登録されてるメールアドレスです。";
//         }
//       }
//     }
//     // パスワードのチェック
//     if(empty($_POST['password'])) {
//       $errors['password'] = "パスワードは必須入力です。正しくご入力ください。";
//     } elseif(!preg_match("/^[a-zA-Z0-9]+$/", $_POST['password'])) {
//       $errors['password'] = "パスワードは半角英数字のみでご入力ください。";
//     } 
//     // エラーが無ければ登録データでそのままログインし、一覧ページに遷移
//     if(count($errors) == 0) {
//       $user = new UserController();
//       $user->register();
//       $params = $user->login();
//       if(!empty($params['user'])) {
//         session_start();
//         $_SESSION['user'] = $params['user'];
//         header('Location: /top/index.php');
//         exit();
//       }
//     }
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

<div class="signupbox">
  <div class="searchtitle">
    <p>新規登録</p>
  </div>

  <div class="signup-box">
    <form method="post" action="complete.php">



        <input type="hidden" name="file_name" value="<?php print basename(__FILE__); ?>">
        <input type="hidden" name="thumbnail_path" value="fakepath">



  <div class="searchmain">
  <p><span style="color: red;" class="required">*</span>は必須項目</p>
  <br>
    <p class="fieldtitle">▼ニックネーム<span style="color: red;">*</span></p>
    <input type="text" name="nickname" id="nickname" class="textfield" placeholder="山田太郎"><br/>

    <!-- メールアドレス・入力フォーム -->
    <p class="fieldtitle">▼メールアドレス<span style="color: red;">*</span></p>
    <input type="text" placeholder="メールアドレス" name="email" value="<?php if(isset($_POST['email'])) {echo $_POST['email'];} ?>"></input>
    <!-- メールアドレス・バリデーション -->
    <?php if(isset($_POST['email'])): ?>
          <?php if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)): ?>
            <div class="user-error-msgs"><?= $errors['email']; ?></div>
            <?php endif; ?>
            <?php foreach($all_params['users'] as $user): ?>
              <?php if($_POST['email'] == $user['email']): ?>
                <div class="user-error-msgs"><?= $errors['email']; ?></div>
                <?php endif; ?>
                <?php endforeach; ?>
                <?php endif; ?>

    <!-- パスワード・入力フォーム -->
    <p class="fieldtitle">▼パスワード<span style="color: red;">*</span></p>
    <input type="password" placeholder="パスワード" name="password" value="<?php if(isset($_POST['password'])) {echo $_POST['password'];} ?>"></input>
    <!-- パスワード・バリデーション -->
    <?php if(isset($_POST['password'])): ?>
          <?php if(empty($_POST['password']) || !preg_match("/^[a-zA-Z0-9]+$/", $_POST['password'])): ?>
            <div class="user-error-msgs"><?= $errors['password']; ?></div>
            <?php endif; ?>
            <?php endif; ?>
        
    
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

        
    <p class="fieldtitle">▼自己紹介</p>
          <textarea name="self_introduction" id="body" class="textareafield"></textarea><br/>
        </div>
        
        
        <div class="searchbotann-box">
          <input type="submit" value="登  録" class=sendbtn></input>
        </div>
        
      </form>
    </body>
    </html>


 