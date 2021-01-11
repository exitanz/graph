<?php
// セッション開始
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ログイン</title>
    <link rel="stylesheet" href="./lib/Bootstrap4/bootstrap.min.css">
    <link rel="stylesheet" href="./lib/FontAwesome/css/all.min.css">
</head>

<body>
    <div class="container">
        <br />
        <!-- ログイン画面 -->
        <div class="row">
            <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
            <aside class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
                <div class="card">
                    <article class="card-body">
                        <h4 class="card-title text-center mb-4 mt-1">ログイン</h4>
                        <?php
                        if (isset($_SESSION['login_msg']) && !empty($_SESSION['login_msg'])) {
                            echo ($_SESSION['login_msg']);
                        }
                        ?>
                        <hr>
                        <form action="../api/src/controller/LoginControler.php" method="POST">
                            <div class="form-group">
                                <h3>ユーザID：</h3>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                    </div>
                                    <input class="form-control" placeholder="ユーザIDを入力してください。" type="text" name="user_id">
                                </div>
                            </div>
                            <br />
                            <div class="form-group">
                                <h3>パスワード：</h3>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                    </div>
                                    <input class="form-control" placeholder="パスワードを入力してください。" type="password" name="password">
                                </div>
                            </div>
                            <br />
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block"> ログイン </button>
                            </div>
                            <p class="text-center"><a href="./create.php" class="btn btn-danger">新規登録</a></p>
                        </form>
                    </article>
                </div>
            </aside>
            <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
        </div>
    </div>

    <script src="./lib/jQuery/jquery-3.5.1.slim.min.js"></script>
    <script src="./lib/Bootstrap4/bootstrap.bundle.min.js"></script>
</body>

</html>