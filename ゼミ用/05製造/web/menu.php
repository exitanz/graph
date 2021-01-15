<?php
require_once  dirname(__FILE__) . '/../api/src/controller/CommonLoginControler.php';
// セッション開始
if (!isset($_SESSION)) {
    session_start();
}

// セッション値確認
if (!isset($_SESSION['user_id']) && empty($_SESSION['user_id']) || !isset($_SESSION['password']) && empty($_SESSION['password'])) {
    // リダイレクトを実行
    header("Location: ./login.php");
}
// ログイン確認
if (CommonLoginControler::commonLogin($_SESSION['user_id'], $_SESSION['password'])) {
    // リダイレクトを実行
    header("Location: ./login.php");
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>メニュー</title>
    <link rel="stylesheet" href="./lib/Bootstrap4/bootstrap.min.css">
    <link rel="stylesheet" href="./lib/FontAwesome/css/all.min.css">
</head>

<body>
    <div class="container">
        <br />
        <!-- メニュー画面 -->
        <div class="row">
            <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
            <aside class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
                <div class="card">
                    <article class="card-body">
                        <h4 class="card-title text-center mb-4 mt-1">メニュー</h4>
                        <hr>
                        <div class="form-group row">
                            <div class="col">
                                <a href="./rel_diagram_list.php"><button type="submit" class="btn btn-secondary btn-block"> 関係図一覧 </button></a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <a href="./create_group.php"><button type="submit" class="btn btn-secondary btn-block"> グループ作成 </button></a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <a href="./password_change.php"><button type="submit" class="btn btn-primary btn-block"> パスワード変更 </button></a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <a href="./logout.php"><button type="submit" class="btn btn-danger btn-block"> ログアウト </button></a>
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