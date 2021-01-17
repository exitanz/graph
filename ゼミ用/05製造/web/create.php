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
    <title>新規登録</title>
    <link rel="stylesheet" href="./lib/Bootstrap4/bootstrap.min.css">
    <link rel="stylesheet" href="./lib/FontAwesome/css/all.min.css">
</head>

<body>
    <div class="container">
        <br />
        <!-- 新規登録画面 -->
        <div class="row">
            <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
            <aside class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
                <div class="card">
                    <article class="card-body">
                        <h4 class="card-title text-center mb-4 mt-1">新規登録</h4>
                        <?php
                        if (isset($_SESSION['create_account_msg']) && !empty($_SESSION['create_account_msg'])) {
                            echo ($_SESSION['create_account_msg']);
                        }
                        ?>
                        <hr>
                        <form action="../api/src/controller/CreateAccountControl.php" method="POST">
                            <div class="form-group">
                                <h3>ユーザ名<span class="badge badge-danger">必須</span>：</h3>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fas fa-signature"></i> </span>
                                    </div>
                                    <input class="form-control is-invalid" placeholder="ユーザ名を入力してください。" type="text" name="user_name">
                                </div>
                            </div>
                            <br />
                            <div class="form-group">
                                <h3>パスワード<span class="badge badge-danger">必須</span>：</h3>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                    </div>
                                    <input class="form-control is-invalid" placeholder="パスワードを入力してください。" type="password" name="password">
                                </div>
                            </div>
                            <br />
                            <div class="form-group row">
                                <div class="col">
                                    <button type="submit" class="btn btn-primary btn-block"> 送信 </button>
                                </div>
                            </div>
                        </form>
                        <div class="form-group row">
                            <div class="col">
                                <a href="./login.php"><button type="submit" class="btn btn-danger btn-block"> 戻る </button></a>
                            </div>
                        </div>
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