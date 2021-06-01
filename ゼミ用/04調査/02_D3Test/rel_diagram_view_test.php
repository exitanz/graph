<?php
    $actor_name = "Mme.Thenardier";
    $actor_group = "グループ1";
    $actor_img = "image/Mme.Thenardier.jpg";
    $actor_memo = "テナルディエの妻（ファーストネームは不明）。宿屋のおかみ。ブロンドの髪（第1部での初登場時では赤毛となっていた）を持ち、赤あざでデコボコした顔に女性でありながら口ひげをはやした、口八丁手八丁の恰幅の良い大女。夫よりは12～15歳ほど年下である。窓ガラスや家具すら震え上がるほど響く声と、くるみを一打で叩き割るほどの怪力の持ち主。夫に負けず劣らずの悪党だが、息子ふたりを売るときに一抹の寂しさを覚えたこともあり、若干の良心は持っている模様。\n自分の娘は可愛がるが、自分の息子や他人の子供には愛情を持てず、夫しか怖がらない偏った心の持ち主。それゆえに、里子のコゼットに無茶な肉体労働をさせたり、顔面を殴ったりするなど肉体的な虐待を加えた。ゆえにコゼットは彼女を極端なまでに恐れた。\n1800年代初頭に有名だった作家ピゴー・ルブラン (Pigault-Lebrun) やデュクレー・デュミニル (Francois Guillaume Ducray-Duminil) の書いた、淫猥でくだらない小説をよく読み、娘たちに読んでいた小説の登場人物の名をつけ、おめかしさせて、荷馬車にぶらさがった大きい鎖でできたブランコで遊ばせていた。しかし、息子のガヴローシュが泣き続けても、彼女は「くさくさしちまう」と言って放置し続けた。\n実はガヴローシュの弟をふたり産んでいるが、手持ち無沙汰であったため、1823年、パリ在住の悪女マニョンに月10フラン[11]の貸賃で息子たちを売った。\nその後、夫や子供たちとともにパリに移住。娘たちには愛情を注いでいたが、夫への愛情は冷めていった。ゴルボー屋敷での一件で夫や娘たちとともにジャヴェールに逮捕され、みじめな最期を迎えることとなる。\nゴルボー屋敷待ち伏せ事件では、男たちが次々と降参する中、最後までジャヴェールに抵抗した。しかし、結局、先に逮捕されたふたりの娘の身の上を嘆きながら、夫と一緒に逮捕される。サディズムの語源となったサド侯爵も収監されたサン・ラザール監獄 (Prison Saint-Lazare) にて、予審中に獄死した。";
    $actor_time = "時系列1";
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8" />
  <title>相関図</title>

  <meta charset="utf-8" />
  <link rel="stylesheet" href="./lib/FontAwesome/css/all.css" />
  <link rel="stylesheet" href="./lib/Bootstrap4/bootstrap.min.css" />
  <link rel="stylesheet" href="./lib/css/styles.css" />
</head>

<body>
  <!-- メニュー -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">
      <i class="fas fa-arrow-left"></i>
    </a>

    <div class="collapse navbar-collapse">
      <p class="h2 text-light mr-auto">レミゼラブル</p>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="#">
            <button type="button" class="btn btn-primary mb-12" data-toggle="modal" data-target="#testModal_Actor">
              Actor
              <i class="fas fa-user-plus fa-2x"></i>
            </button>
            <button type="button" class="btn btn-success mb-12" data-toggle="modal" data-target="#testModal_Link">
              Link
              <i class="fas fa-arrows-alt-h fa-2x"></i>
            </button>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="fas fa-download fa-2x"></i>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-cog fa-2x"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown">
            <a class="dropdown-item" href="#">読み込み</a>
            <a class="dropdown-item" href="#">リンク2</a>
            <a class="dropdown-item" href="#">リンク3</a>
            <a class="dropdown-item" href="#">
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#testModal_diagram_Del">
                図を削除
              </button>
            </a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <br />
  <div class="container-fluid">
    <div class="row">
      <aside class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
        <div class="btn-group-vertical nav nav-tabs nav-item nav-pills">
          <a class="nav-link btn btn-white active" data-toggle="tab">
            時系列１
          </a>
          <a class="nav-link btn btn-white" data-toggle="tab">
            時系列２
          </a>
          <a class="nav-link btn btn-white" data-toggle="tab">
            時系列３
          </a>
        </div>
      </aside>
      <aside class="col-sm-10 col-md-10 col-lg-8 col-xl-8">
        <div class="tab-content">
          <div class="tab-pane fade show active" id="item1">
            <svg width="980" height="600" style="background-color: #ddd"></svg>
            <div class="card-group row">
              <div class="card col-8">
                <div class="card-body" id="side_data">
                  <div class="row">
                    <aside class="col-sm-4 col-md-4 col-lg-2 col-xl-2" id="side_data_img"></aside>
                    <aside class="col-sm-8 col-md-8 col-lg-10 col-xl-10">
                      <div class="row">
                        <aside class="col">
                          <h3><textarea id="data_name" class="form-control" rows="1" disabled></textarea></h3>
                        </aside>
                        <aside class="col text-right">
                          <button type="submit" class="btn btn-success" data-toggle="modal" data-target="#testModal_Edit">
                            編集
                          </button>
                          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#testModal_Del">
                            削除
                          </button>
                        </aside>
                      </div>
                      <div class="row">
                        <aside class="col">
                          <textarea id="data_memo" class="form-control" rows="5" disabled></textarea>
                        </aside>
                      </div>
                    </aside>
                  </div>
                </div>
              </div>
              <div class="card col-4">
                <div class="card-body" id="sidebar">
                  <div class="row h-50 w-100">
                    <aside class="col-12" id="side_search">
                      <h2>検索</h2>
                      <div class="input-group">
                        <input type="text" class="form-control is-invalid" name="group_id" id="txt_search" />
                        <span class="input-group-btn">
                          <button type="submit" class="btn btn-primary" id="btn_search">
                            <i class="fas fa-search"></i>
                          </button>
                        </span>
                        <div class="invalid-feedback">
                          検索文字列を入力して下さい
                        </div>
                      </div>
                      <br />
                    </aside>
                    <aside class="col-12 p-3">
                      <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-outline-primary active">
                          <input type="radio" name="searchOptions" id="searc1" autocomplete="off" checked />人物
                        </label>
                        <label class="btn btn-outline-primary">
                          <input type="radio" name="searchOptions" id="searc2" autocomplete="off" />関係
                        </label>
                        <label class="btn btn-outline-primary">
                          <input type="radio" name="searchOptions" id="searc3" autocomplete="off" />グループ
                        </label>
                      </div>
                    </aside>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab-pane fade" id="item2">
            This is a text of item#2.
          </div>
          <div class="tab-pane fade" id="item3">
            This is a text of item#3.
          </div>
        </div>
      </aside>
      <aside class="col-sm-0 col-md-0 col-lg-2 col-xl-2"></aside>
    </div>
  </div>

<!-- Actorボタンクリック後に表示される画面の内容 -->
  <div class="modal fade" id="testModal_Actor" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4>
            <class="modal-title" id="myModalLabel">入力画面
          </h4>
          </h4>
        </div>
        <div class="modal-body">
          <div class="col-md">
            <form>
              <div class="form-group col-10">
                <label class="mt-4">名前</label>
                <input type="text" class="form-control mb-4">
                <label class="mt-4">グループ</label>
                <select class="form-control mb-4">
                  <option>グループ1</option>
                  <option>グループ2</option>
                  <option>グループ3</option>
                  <option>グループ4</option>
                </select>
                <label class="mt-4">時系列</label>
                <select class="form-control mb-4">
                  <option>時系列1</option>
                  <option>時系列2</option>
                  <option>時系列3</option>
                </select>
                <div class="form-group">
                  <h3>アイコン</h3>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"> <i class="fas fa-image"></i> </span>
                    </div>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input">
                      <label class="custom-file-label" for="inputFile" data-browse="参照">ファイルを選択</label>
                    </div>
                  </div>
                </div>
                <div class="form-group mb-4">
                  <label class="mt-4">備考</label>
                  <textarea class="form-control" rows="3"></textarea>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
          <button type="button" class="btn btn-primary">登録</button>
        </div>
      </div>
    </div>
  </div>

<!-- Linkボタンクリック後に表示される画面の内容 -->
  <div class="modal fade" id="testModal_Link" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4>
            <class="modal-title" id="myModalLabel">入力画面
          </h4>
          </h4>
        </div>
        <div class="modal-body">
          <div class="col-md">
            <form>
              <div class="form-group col-10">
                <label class="mt-4">関係性</label>
                <input type="text" class="form-control mb-4">
                <div class="form-row">
                  <div class="form-group col-sm-6">
                    <label for="text4a">From</label>
                    <input type="text" class="form-control" id="text4a">
                  </div>
                  <div class="form-group col-sm-6">
                    <label for="text4b">to</label>
                    <input type="text" class="form-control" id="text4b">
                  </div>
                </div>
                <label class="mt-4">時系列</label>
                <select class="form-control mb-4">
                  <option>時系列1</option>
                  <option>時系列2</option>
                  <option>時系列3</option>
                </select>
                <div class="form-group mb-4">
                  <label class="mt-4">備考</label>
                  <textarea class="form-control" rows="3"></textarea>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
          <button type="button" class="btn btn-primary">登録</button>
        </div>
      </div>
    </div>
  </div>

<!-- 編集ボタンクリック後に表示される画面の内容 -->
  <div class="modal fade" id="testModal_Edit" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4>
            <class="modal-title" id="myModalLabel">編集画面
          </h4>
          </h4>
        </div>
        <div class="modal-body">
          <div class="col-md">
            <form>
              <div class="form-group col-10">
                <label class="mt-4">名前</label>
                <input type="text" class="form-control mb-4" value=<?= $actor_name ?>>
                <label class="mt-4">グループ</label>
                <select class="form-control mb-4">
                  <option value="グループ1">グループ1</option>
                  <option value="グループ2">グループ2</option>
                  <option value="グループ3">グループ3</option>
                  <option value="グループ4">グループ4</option>
                </select>
                <label class="mt-4">時系列</label>
                <select class="form-control mb-4">
                  <option value="時系列1">時系列1</option>
                  <option value="時系列2">時系列2</option>
                  <option value="時系列3">時系列3</option>
                </select>
                <div class="form-group">
                  <h3>アイコン</h3>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text"> <i class="fas fa-image"></i> </span>
                    </div>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input">
                      <label class="custom-file-label" for="inputFile" data-browse="参照">ファイルを選択</label>
                    </div>
                  </div>
                </div>
                <div class="form-group mb-4">
                  <label class="mt-4">備考</label>
                  <textarea class="form-control" rows="3" ><?= $actor_memo ?></textarea>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
          <button type="button" class="btn btn-primary">保存</button>
        </div>
      </div>
    </div>
  </div>

<!-- 削除ボタンクリック後に表示される画面の内容 -->
  <div class="modal fade" id="testModal_Del" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4>
            <div class="modal-title" id="myModalLabel">削除確認画面</div>
          </h4>
        </div>
        <div class="modal-body">
          <label>データを削除しますか？</label>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
          <button type="button" class="btn btn-danger">削除</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="testModal_diagram_Del" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4>
            <div class="modal-title" id="myModalLabel">削除確認画面</div>
          </h4>
        </div>
        <div class="modal-body">
          <label>データを削除しますか？</label>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">閉じる</button>
          <button type="button" class="btn btn-danger">削除</button>
        </div>
      </div>
    </div>
  </div>

  <!-- カーソルを合わせたときに表示する情報領域-->
  <div id="datatip">
    <h2></h2>
    <p></p>
  </div>
  <script src="./lib/jQuery/jquery-3.5.1.slim.min.js"></script>
  <script src="./lib/Bootstrap4/bootstrap.bundle.min.js"></script>
  <script src="./lib/FontAwesome/js/all.js"></script>
  <script src="./lib/js/d3/d3.min.js"></script>
  <script src="./lib/js/relationship_test.js"></script>
  <script src="./lib/js/script_test.js"></script>
</body>

</html>