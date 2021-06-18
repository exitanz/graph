<template>
  <div class="row">
    <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
    <aside class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
      <div class="card">
        <article class="card-body">
          <h4 class="card-title text-center mb-4 mt-1">ユーザ情報編集</h4>
          <hr>
          <div class="form-group">
            <br />
            <div class="alert alert-success">ユーザ編集が完了しました。<br /></div>
            <div class="alert alert-danger">必須項目を入力してください。<br /></div>
            <br />
            <h3>ユーザ名</h3>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fas fa-signature"></i> </span>
              </div>
              <input
                class="form-control is-invalid"
                placeholder="ユーザ名を入力してください。"
                type="text"
                name="user_name"
              >
            </div>
          </div>
          <br />
          <div class="form-group">
            <h3>現在のパスワード</h3>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
              </div>
              <input
                class="form-control is-invalid"
                placeholder="現在のパスワードを入力してください。"
                type="password"
                name="password"
              >
            </div>
          </div>
          <br />
          <div class="form-group">
            <h3>新しいパスワード</h3>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
              </div>
              <input
                class="form-control is-invalid"
                placeholder="新しいパスワードを入力してください。"
                type="password"
                name="password"
              >
            </div>
          </div>
          <br />
          <div class="form-group">
            <h3>秘密の質問</h3>
            <div class="row">
              <div class="col-md">
                <form>
                  <div class="form-group">
                    <select class="form-control">
                      <option>飼っているペットの名前は？</option>
                      <option>好きな食べものは？</option>
                      <option>学生時代やっていた部活動は？</option>
                    </select>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="form-group">
            <h3>質問の答え</h3>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"> <i class="fas fa-exclamation"></i> </span>
              </div>
              <input
                class="form-control is-invalid"
                placeholder="質問の答えを入力してください。"
                type="text"
                name="answer"
              >
            </div>
          </div>
          <br />
          <div class="form-group row">
            <div class="col">
              <button
                type="submit"
                class="btn btn-primary btn-block"
                id="usereditsend"
              > 送信 </button>
            </div>
          </div>
          <div class="form-group row">
            <div class="col">
              <button
                type="submit"
                class="btn btn-danger btn-block"
                id="usereditback"
              > 戻る </button>
            </div>
          </div>
        </article>
      </div>
    </aside>
    <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
  </div>
</template>

<script>
</script>

<style>
</style>
