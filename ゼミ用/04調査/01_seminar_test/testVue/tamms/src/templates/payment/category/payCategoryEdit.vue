<template>
  <div class="row">
    <aside class="col-sm-0 col-md-20 col-lg-2 col-xl-2"></aside>
    <aside class="col-sm-12 col-md-20 col-lg-8 col-xl-8">
      <div class="card">
        <article class="card-body">
          <h4 class="card-title text-center mb-4 mt-1">支出カテゴリ編集</h4>
          <hr />
          <div class="form-group">
            <br />
            <div class="alert alert-success">
              支出カテゴリを編集しました。<br />
            </div>
            <div class="alert alert-danger">
              支出カテゴリ名は20文字以内で入力してください<br />
            </div>
            <br />
            <table class="table">
              <th></th>
            </table>
            <br />
            <h3>支出カテゴリ名</h3>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-wallet"></i>
                </span>
              </div>
              <input
                class="form-control"
                placeholder="支出カテゴリ名を入力してください。"
                type="text"
                name="catagory_name"
              />
            </div>
          </div>
          <br />
          <br />
          <br />
          <p class="text-center"><a class="btn btn-secondary">編集</a></p>
          <br />
          <br />
          <table class="table">
            <th></th>
          </table>
          <br />
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
