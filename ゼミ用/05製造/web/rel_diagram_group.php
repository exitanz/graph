<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>相関図メニュー</title>
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
                        <h4 class="card-title text-center mb-4 mt-1">グループ1</h4>
                        <hr>
                        <div class="form-group row">
                            <div class="col">
                                <a href="./rel_diagram_acter.php"><button type="submit" class="btn btn-primary btn-block"> 登場人物 </button></a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <a href="./rel_diagram_time.php"><button type="submit" class="btn btn-warning btn-block"> 時系列 </button></a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <a href="./rel_diagram_rel.php"><button type="submit" class="btn btn-success btn-block"> 関係性 </button></a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col">
                                <a href="./rel_diagram_view.php"><button type="submit" class="btn btn-secondary btn-block"> 相関図 </button></a>
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