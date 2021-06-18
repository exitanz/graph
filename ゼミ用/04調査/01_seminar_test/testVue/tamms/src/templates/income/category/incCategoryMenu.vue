<template>
  <div class="row">
    <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
    <aside class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
      <div class="card">
        <article class="card-body">
          <h4 class="card-title text-center mb-4 mt-1">収入カテゴリ一覧</h4>
          <hr />
          <p class="text-center">
            <button
              type="button"
              class="btn btn-info"
              id="categorydelete"
            >
              収入カテゴリ登録
            </button>
          </p>
          <br />
          <div id="error">
            <div class="alert alert-secondary">
              収入カテゴリが1件もありません。<br />
            </div>
          </div>
          <table class="table">
            <thead class="thead-light">
              <tr>
                <th>収入カテゴリ名</th>
                <th>編集</th>
                <th>削除</th>
              </tr>
            </thead>
            <br />
            <tbody id="categorytable">
              <tr
                v-for="(row, key) in items"
                :key="key"
              >
                <td>
                  {{ row.incCategoryName }}
                </td>
                <td>
                  <button
                    type="button"
                    class="btn btn-info"
                    id="categoryedit"
                  >
                    <font-awesome-icon icon="pen" />
                  </button>
                </td>
                <td>
                  <button
                    type="button"
                    class="btn btn-danger"
                    id="categorydelete"
                  >
                    <font-awesome-icon icon="times-circle" />
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
import { ApiURL } from "../../../constants/ApiURL.js";
import { CommonUtils } from "../../../common/CommonUtils.js";
import { VueFaileName } from "../../../constants/VueFaileName.js";

export default {
  data() {
    return {
      errors: [],
      login: VueFaileName.login,
      incCategoryMenu: VueFaileName.incCategoryMenu,
      items: [],
    };
  },
  beforeRouteEnter(to, from, next) {
    next((vm) => {
      vm.initialize(); // 初期化処理
      next();
    });
  },
  methods: {
    initialize() {
      // 初期化処理
      // パラメータ生成
      this.$http
        .get(
          CommonUtils.createApiUrl(ApiURL.INCOME_CATEGORY),
          CommonUtils.createApiHeader()
        )
        .then((response) => {
          // 収入カテゴリ取得
          this.items = response.data.optional.incCategoryList;
        })
        .catch((error) => {
          console.log(error);
          // ログイン失敗
          // this.errors.push("ユーザIDまたはパスワードが違います。");
        });
    },
  },
};
</script>

<style>
</style>
