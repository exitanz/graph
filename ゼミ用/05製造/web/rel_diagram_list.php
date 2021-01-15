<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>相関図一覧</title>
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
                        <h4 class="card-title text-center mb-4 mt-1">相関図一覧</h4>
                        <hr>
                            <div class="alert alert-danger"><strong>エラー ：</strong> グループが1件もありません<br /></div>
                        <div class="form-group row">
                            <div class="col">
                                <a href="./rel_diagram_group.php"><button type="submit" class="btn btn-secondary btn-block"> グループ１ </button></a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <a href="./rel_diagram_group.php"><button type="submit" class="btn btn-secondary btn-block"> グループ２ </button></a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <a href="./rel_diagram_group.php"><button type="submit" class="btn btn-secondary btn-block"> グループ３ </button></a>
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