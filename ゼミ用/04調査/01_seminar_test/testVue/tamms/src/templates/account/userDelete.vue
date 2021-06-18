<template>
  <div class="row">
    <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
    <aside class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
      <div class="card">
        <article class="card-body">
          <h4 class="card-title text-center mb-4 mt-1">ユーザ削除</h4>
          <hr>
          <div class="form-group">
            <br />
            <div class="alert alert-danger">必須項目を入力してください。<br /></div>
            <div class="alert alert-danger">ユーザを削除しました。<br /></div>
            <br />
            <div class="form-group">
              <h3>パスワード</h3>
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
            <div class="form-group row">
              <div class="col">
                <button
                  type="button"
                  class="btn btn-primary btn-block mb-8"
                  data-toggle="modal"
                  data-target="#testModal"
                  id="userdeletesend"
                > 送信 </button>
              </div>
            </div>
            <div class="form-group row">
              <div class="col">
                <button
                  type="submit"
                  class="btn btn-danger btn-block"
                  id="userdeleteback"
                > 戻る </button>
              </div>
            </div>
            <div
              class="modal fade"
              id="testModal"
              tabindex="-1"
              role="dialog"
              aria-labelledby="basicModal"
              aria-hidden="true"
            >
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4>
                      <div
                        class="modal-title"
                        id="myModalLabel"
                      >削除確認画面</div>
                    </h4>
                  </div>
                  <div class="modal-body">
                    <label>本当に削除しますか？</label>
                  </div>
                  <div class="modal-footer">
                    <button
                      type="button"
                      class="btn btn-primary"
                      data-dismiss="modal"
                      id="useryes"
                    >はい</button>
                    <button
                      type="button"
                      class="btn btn-danger"
                      id="userno"
                    >いいえ</button>
                  </div>
                </div>
              </div>
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
