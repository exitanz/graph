<template>
  <div class="row">
    <aside class="col-sm-0 col-md-20 col-lg-2 col-xl-2"></aside>
    <aside class="col-sm-12 col-md-20 col-lg-8 col-xl-8">
      <div class="card">
        <article class="card-body">
          <h4 class="card-title text-center mb-4 mt-1">収入履歴</h4>
          <hr>
          <div class="form-group">
            <p class="text-center"><a class="btn btn-info">収入登録</a></p>
            <hr>
            <p class="text-center"><a class="btn btn-secondary btn-block">カレンダー表示</a>
            </p>
            <hr>
          </div>
          <table class="table">
            <thead class="thead-light">
              <tr>
                <th>日付</th>
                <th>値段</th>
                <th>編集</th>
                <th>削除</th>
              </tr>
            </thead>
            <tbody>
              <div class="alert alert-danger">収入登録が一件もありません。<br /></div>
              <br />
              <tr>
                <td></td>
                <td></td>
                <td><button
                    type="button"
                    class="btn btn-info"
                    id="incomeedit"
                  ><i class="fas fa-pen"></i></button></td>
                <td><button
                    type="button"
                    class="btn btn-danger"
                    id="incomedelete"
                  ><i class="fas fa-times-circle"></i></button></td>
              </tr>
              <tr>
                <td></td>
                <td></td>
                <td><button
                    type="button"
                    class="btn btn-info"
                    id="incomeedit"
                  ><i class="fas fa-pen"></i></button></td>
                <td><button
                    type="button"
                    class="btn btn-danger"
                    id="incomedelete"
                  ><i class="fas fa-times-circle"></i></button></td>
              </tr>
            </tbody>
          </table>
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
