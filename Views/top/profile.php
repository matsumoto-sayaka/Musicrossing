<?php 
  require_once(ROOT_PATH .'Views/common/head.php');
  require_once(ROOT_PATH .'Controllers/MusicrossingController.php');
  $mc = new MusicrossingController();
  $params = $mc->signup();
  // print "<pre>";
  // print_r($result);
  // print "</pre>";

//   print "<pre>";
//   print_r($_SESSION);
//   print "</pre>";


    // ■■■■■■■■■■■■■  2021-10-01-Fri-add-start  ■■■■■■■■■■■■■■
    $disp_type = '';
    $login = '';
    $name = '';
    $user_id = '';
    $user = array();
    $part = array();
    $parts = array();
    $work = array();
    $works = array();
    $state = array();
    $part_and_work = array();
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $file_name = isset($_POST['file_name']) ? $_POST['file_name'] : '';
    }else{
        //$disp_type = isset($_GET['disp_type']) ? $_GET['disp_type'] : '';
    }
    $disp_type = isset($_GET['disp_type']) ? $_GET['disp_type'] : '';

    // print "■■■■■■■■■■■■■■■■<br />";
    // print $disp_type;print "<br />";
    // print "■■■■■■■■■■■■■■■■<br />";

    $userInfo = array();
    if(isset($_POST['update'])) {
        $updateResult = $mc->updateUser();
    }
    if($s->isExist('login')) {
        $login = $s->get('login');
        $user_id = $s->get('user_id');
        $userInfo = $mc->profile($user_id);
    }

    if(!isEmpty($userInfo)) {
        $user = $userInfo['user'] ? $userInfo['user'] : array();
        $s->set('name', $user['nickname']);
        $name = $s->get('name');
        $part = $userInfo['part'] ? $userInfo['part'] : array();
        $parts = $userInfo['parts'] ? $userInfo['parts'] : array();
        $work = $userInfo['work'] ? $userInfo['work'] : array();
        $works = $userInfo['works'] ? $userInfo['works'] : array();
        $state = $userInfo['state'] ? $userInfo['state'] : array();
        $part_and_work = getPartAndWorkNames($part, $parts, $work, $works);
    }
    $aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa = ""; //あとでこの行は消す　デバッグ実行でブレイク置きたいから書いただけ
    // ■■■■■■■■■■■■■■  2021-10-01-Fri-add-end  ■■■■■■■■■■■■■■

// print "<pre>";
// print_r($part_and_work);
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

<div class="myprofilebox">

<!-- ■■■■■■■■■■■■■■■■■■■■■　ログイン中ならログインユーザの情報を表示する　■■■■■■■■■■■■■■■■■■■■■-->
<?php if($login == 1): ?>

    <!-- ■■■■■■■■■■■■■■■■■■■■■　閲覧モード　■■■■■■■■■■■■■■■■■■■■■-->
    <?php if($disp_type == 'view'): ?>
                <div class="edit">
                    <a href="profile.php?disp_type=edit">プロフィール編集</a>
                </div>
                <!-- ■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■ -->
                <!-- ■■■■■■■　重要！！！！！！！　ブラウザへのユーザ情報の表示が見づらかったので、一旦下記のclass名を変更しております。　　　　　 　■■■■■■■ -->
                <!-- ■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■ -->
                <div class="myprof-details1"><!-- ←　■■■■■■■■■■■■■■■■■■■■■　このクラス名を　myprof-details1　から　myprof-details10（これは存在しないクラス名）　へ　一旦変更しました。変更することでcssが効かなくなり、一応見やすくなりました。■■■■■■■■■■■■■■■■■■■■■　-->
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
                    <?php $key = 'nickname' ?>
                        <p>：　<?=h($key, $user) ?? ''; ?></p>
                    </div>
                    <div class="myprof-gender-answer">
                    <?php $key = 'gender';
                        $genderType = '未選択';
                        if($user[$key] == 1) $genderType = '男';
                        elseif($user[$key] == 2) $genderType = '女';
                    ?>
                        <p>：　<?=$genderType; ?></p>
                    </div>
                    <div class="myprof-age-answer">
                    <?php $key = 'age' ?>
                    <?php $ageText = (h($key, $user) == 0) ? "未選択" : h($key, $user)."代" ; ?>
                        <p>：　<?=$ageText; ?></p>
                    </div>
                    <div class="myprof-part-answer">
                        <p>：　<?=$part_and_work['part']; ?></p>
                    </div>
                    <div class="myprof-skill-answer">
                        <p>：　<?=$part_and_work['work']; ?></p>
                    </div>
                    <div class="myprof-state-answer">
                        <p>：　<?=getStateName($user['state_id'], $state); ?></p>
                    </div>
                    </div>
                </div>
                <div class="myprof-details2">
                    <div class="selfpr">
                    <?php $key = 'self_introduction' ?>
                    <p><?=h($key, $user) ?? ''; ?></p>
                    </div>
                </div>
                <div class="logout">
                    <a href="../Users/logout.php" class="btn btn--yellow">ログアウト</a>
                </div>
                </div>
    <!-- ■■■■■■■■■■■■■■■■■■■■■　編集モード　■■■■■■■■■■■■■■■■■■■■■-->
    <?php elseif($disp_type == 'edit'): ?>
        <div class="signup-box">
    <form method="post" action="profile.php?disp_type=view">


        <input type="hidden" name="file_name" value="<?php print basename(__FILE__); ?>">
        <input type="hidden" name="thumbnail_path" value="fakepath">
        <input type="hidden" name="user_id" value="<?=$user_id; ?>">


  <div class="searchmain">
  <p><span style="color: red;" class="required">*</span>は必須項目</p>
  <br>
    <p class="fieldtitle">▼ニックネーム<span style="color: red;">*</span></p>
    <input type="text" name="nickname" id="nickname" class="textfield" placeholder="山田太郎" value="<?=h('nickname', $user) ?? ''; ?>"><br/>

    <!-- メールアドレス・入力フォーム -->
    <p class="fieldtitle">▼メールアドレス<span style="color: red;">*</span></p>
    <input type="text" placeholder="メールアドレス" name="email" value="<?=h('email', $user) ?? ''; ?>" readonly disabled></input>
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
    <input type="text" placeholder="パスワード" name="password" value="" readonly disabled></input>
    <!-- パスワード・バリデーション -->
    <?php if(isset($_POST['password'])): ?>
          <?php if(empty($_POST['password']) || !preg_match("/^[a-zA-Z0-9]+$/", $_POST['password'])): ?>
            <div class="user-error-msgs"><?= $errors['password']; ?></div>
            <?php endif; ?>
            <?php endif; ?>
        
    
    <p class="fieldtitle">▼性別</p>


    <?php if($user['gender'] == 1): ?>
        <label>
          <input type="radio" name="gender" value="0">未選択　
        </label>
        <label>
          <input type="radio" name="gender" value="1" checked>男　　
        </label>
        <label>
          <input type="radio" name="gender" value="2">女
        </label>
    <?php elseif($user['gender'] == 2): ?>
        <label>
          <input type="radio" name="gender" value="0">未選択　
        </label>
        <label>
          <input type="radio" name="gender" value="1">男　　
        </label>
        <label>
          <input type="radio" name="gender" value="2" checked>女
        </label>
    <?php else: ?>
        <label>
          <input type="radio" name="gender" value="0" checked>未選択　
        </label>
        <label>
          <input type="radio" name="gender" value="1">男　　
        </label>
        <label>
          <input type="radio" name="gender" value="2">女
        </label>
    <?php endif; ?>

    <p class="fieldtitle">▼年代</p>
    <?php
        $age = 0;
        print "<select name='age'>";
        while($age <= 90) {
            if($age == 0) {
                print "<option value=".$age.">選択してください</option>";
            }else{
                if($age == $user['age']) {
                    print "<option value=".$age." selected>".$age."代</option>";
                }else{
                    print "<option value=".$age.">".$age."代</option>";
                }
            }
            $age = $age + 10;
        }
        print "</select>";
    ?>


    <p class="fieldtitle">▼担当パート</p>
      <?php foreach($params['part'] as $key=>$p): ?>
            <?php if(in_array($p['id'], $part_and_work['part_id'])): ?>
                <input type="checkbox" name="part[<?=$key ?>]" checked="checked" value="<?=$p['id'] ?>"><?=$p['part'] ?>
            <?php else: ?>
                <input type="checkbox" name="part[<?=$key ?>]" value="<?=$p['id'] ?>"><?=$p['part'] ?>
            <?php endif; ?>
      <?php endforeach ?>

    <p class="fieldtitle">▼業務領域</p>
      <?php foreach($params['work'] as $key=>$w): ?>
            <?php if(in_array($w['id'], $part_and_work['work_id'])): ?>
                <input type="checkbox" name="work[<?=$key ?>]" checked="checked" value="<?=$w['id'] ?>"><?=$w['work'] ?>
            <?php else: ?>
                <input type="checkbox" name="work[<?=$key ?>]" value="<?=$w['id'] ?>"><?=$w['work'] ?>
            <?php endif; ?>
      <?php endforeach ?>


    <p class="fieldtitle">▼都道府県</p>
      <select name="state_id">
        <option value="0">選択してください</option>
        <?php foreach($params['state'] as $states): ?>
            <?php if($user['state_id'] == $states['id']): ?>
                <option selected value="<?=$states['id'] ?>"><?=$states['name'] ?></option>
            <?php else: ?>
                <option value="<?=$states['id'] ?>"><?=$states['name'] ?></option>
            <?php endif; ?>
        <?php endforeach ?>
        </select>

        
    <p class="fieldtitle">▼自己紹介</p>
          <textarea name="self_introduction" id="body" class="textareafield"><?=h('self_introduction', $user) ?? ''; ?></textarea><br/>
        </div>
        
        
        <div class="searchbotann-box">
          <input type="submit" name="update" value="更  新" class=sendbtn></input>
        </div>
        
      </form>

    <?php endif; ?>







<!-- ■■■■■■■■■■■■■■■■■■■■■　ログアウト中ならログイン画面へのリンクを表示する　■■■■■■■■■■■■■■■■■■■■■-->
<?php 
// else: ?>
    <!-- <div class="login">
    <p>ログインしてください。</p>
    <a href="../Users/login.php">ログイン</a>
</div> -->
<?php endif; ?>

</div>
</div>

<?php include '../Views/footer.html'; ?>
</body>
</html>