<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>登場人物登録</title>
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
                        <h4 class="card-title text-center mb-4 mt-1">登場人物登録</h4>
                        <hr>
                        <form action="../api/src/controller/LoginControler.php" method="POST">
                            <div class="form-group">
                                <br />
                                <div class="alert alert-danger">登場人物名は100文字以内で入力してください<br /></div>
                                <br />
                                <table class="table">
                                    <th></th>
                                </table>
                                <br />
                                <h3>登場人物名</h3>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fas fa-smile"></i> </span>
                                    </div>
                                    <input class="form-control" placeholder="登場人物名を入力してください。" type="text" name="acter_name">
                                </div>
                            </div>
                            <br />
                            <div class="form-group">
                                <h3>説明</h3>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fas fa-pencil-alt"></i> </span>
                                    </div>
                                    <textarea row="3" class="form-control" placeholder="説明を入力してください。" name="acter_conf"></textarea>
                                </div>
                            </div>
                            <br />
                            <div class="form-group">
                                <h3>時系列</h3>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fas fa-clock"></i> </span>
                                    </div>
                                    <select class="form-control">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                    </select>
                                </div>
                            </div>
                            <br />
                            <div class="form-group">
                                <h3>アイコン</h3>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fas fa-image"></i> </span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputFile">
                                        <label class="custom-file-label" for="inputFile" data-browse="参照">ファイルを選択</label>
                                    </div>
                                </div>
                            </div>
                            <br />
                            <p class="text-center"><a href="./create.php" class="btn btn-secondary">送信</a></p>
                            <br />
                            <br />
                            <table class="table">
                                <th></th>
                            </table>
                            <br />
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>登場人物名</th>
                                        <th>説明</th>
                                        <th>時系列</th>
                                        <th>削除</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th>1</th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><button type="button" class="btn btn-danger">×</button></td>
                                    </tr>
                                    <tr>
                                        <th>2</th>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td><button type="button" class="btn btn-danger">×</button></td>
                                    </tr>
                                </tbody>
                            </table>
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