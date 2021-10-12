<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Musicrossing</title>
    <link rel="stylesheet" type="text/css" href="/css/base.css">
</head>

<body>
    <header>
        <div class="header-contents">
            <div class="logo">
                <a href="index.php"><img src="/img/logo.png" alt="Musicrossing"></a>
            </div>

            <div class="menu">
                
                <div class="search">
                    <a href="search.php"><img src="/img/search.png" alt="検索"></a>
                </div>
                <div class="exchange">
                <a href="exchange.php?id=<?=$_SESSION['user_id']; ?>"><img src="/img/exchange.png" alt="やり取り"></a>
                </div>
                <div class="favorite">
                    <a href="favorite.php"><img src="/img/favorite.png" alt="お気に入り"></a>
                </div>
                <div class="profile">
                    <a href="profile.php?disp_type=view"><img src="/img/profile.png" alt="マイページ"></a>
                    <p><span style="color: magenta; font-size: 13px; font-weight: bold; "><?=$_SESSION['name']; ?></span>さん<br>ログイン中</p>
                </div>
            </div>

                <!-- <div class="login">
                <a href="../Users/login.php">ログイン</a>
                </div> -->

        </div>
    </header>
</body>

</html>