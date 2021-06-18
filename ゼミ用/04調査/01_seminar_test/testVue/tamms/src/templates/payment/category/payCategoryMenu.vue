<template>
  <div class="row">
    <aside class="col-sm-0 col-md-20 col-lg-2 col-xl-2"></aside>
    <aside class="col-sm-12 col-md-20 col-lg-8 col-xl-8">
      <div class="card">
        <article class="card-body">
          <h4 class="card-title text-center mb-4 mt-1">支出カテゴリ一覧</h4>
          <hr />
          <p class="text-center">
            <button
              type="button"
              class="btn btn-info"
              id="categorydelete"
            >
              支出カテゴリ登録
            </button>
          </p>
          <br />
          <table class="table">
            <th></th>
          </table>
          <br />
          <table class="table">
            <thead class="thead-light">
              <tr>
                <th>支出カテゴリ名</th>
                <th>編集</th>
                <th>削除</th>
              </tr>
            </thead>
            <tbody id="categorytable">
              <div class="alert alert-secondary">
                支出カテゴリが一件もありません。<br />
              </div>
              <br />
              <tr>
                <td>ああああああああああああああああああああ</td>
                <td>
                  <button
                    type="button"
                    class="btn btn-info"
                    id="categoryedit"
                  >
                    <i class="fas fa-pen"></i>
                  </button>
                </td>
                <td>
                  <button
                    type="button"
                    class="btn btn-danger"
                    id="categorydelete"
                  >
                    <i class="fas fa-times-circle"></i>
                  </button>
                </td>
              </tr>
              <tr>
                <td></td>
                <td>
                  <button
                    type="button"
                    class="btn btn-info"
                    id="categoryedit"
                  >
                    <i class="fas fa-pen"></i>
                  </button>
                </td>
                <td>
                  <button
                    type="button"
                    class="btn btn-danger"
                    id="categorydelete"
                  >
                    <i class="fas fa-times-circle"></i>
                  </button>
                </td>
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
