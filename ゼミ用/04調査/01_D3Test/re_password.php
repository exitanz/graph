<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>パスワード変更</title>
    <link rel="stylesheet" href="./lib/Bootstrap4/bootstrap.min.css">
    <link rel="stylesheet" href="./lib/FontAwesome/css/all.min.css">
</head>

<body>
    <div class="container">
        <br />
        <div class="row">
            <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
            <aside class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
                <div class="card">
                    <article class="card-body">
                        <h4 class="card-title text-center mb-4 mt-1">パスワード変更</h4>
                        <hr>
                        <form action="../api/src/controller/LoginControler.php" method="POST">
                            <div class="form-group">
                                <br />
                                <div class="alert alert-success">パスワードを変更しました<br /></div>
                                <div class="alert alert-danger">パスワードが一致しません<br /></div>
                                <br />
                                <table class="table">
                                    <th></th>
                                </table>
                                <br />
                                <h3>現在のパスワード</h3>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i> </span>
                                    </div>
                                    <input class="form-control" placeholder="現在のパスワードを入力してください。" type="text" name="acter_name">
                                </div>
                                <br />
                                <br />
                                <h3>新しいパスワード</h3>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i> </span>
                                    </div>
                                    <input class="form-control" placeholder="新しいパスワードを入力してください。" type="text" name="acter_name">
                                </div>
                            </div>
                            <br />
                            <p class="text-center"><a href="./create.php" class="btn btn-secondary">送信</a></p>
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