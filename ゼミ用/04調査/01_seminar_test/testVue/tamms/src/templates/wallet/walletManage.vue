<template>
  <div class="row">
    <aside class="col-sm-0 col-md-20 col-lg-2 col-xl-2"></aside>
    <aside class="col-sm-12 col-md-20 col-lg-8 col-xl-8">
      <div class="card">
        <article class="card-body">
          <h4 class="card-title text-center mb-4 mt-1">口座一覧</h4>
          <hr>
          <p class="text-center">
            <button
              type="submit"
              class="btn btn-success"
              @click="changeCreate"
            >
              口座登録
            </button>
          </p>
          <hr>
          <br />
          <div
            v-for="(error, key) in errors"
            :key="key"
          >
            <div class="alert alert-danger">{{error}}<br /></div>
          </div>
          <table class="table">
            <thead class="thead-light">
              <tr>
                <th>口座名</th>
                <th>残高</th>
                <th>編集</th>
                <th>削除</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(row, key) in items"
                :key="key"
              >
                <td>{{row.bankName}}</td>
                <td>{{row.incMoney - row.payMoney}}</td>
                <td>
                  <button
                    type="button"
                    class="btn btn-info"
                    @click="changeEdit(row.bankId)"
                  >
                    <font-awesome-icon icon="pen" />
                  </button>
                </td>
                <td>
                  <button
                    type="button"
                    class="btn btn-danger"
                    @click="walletDelete(row.bankId)"
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
import { ApiURL } from "../../constants/ApiURL.js";
import { CommonUtils } from "../../common/CommonUtils.js";
import { VueFaileName } from "../../constants/VueFaileName.js";

export default {
  data() {
    return {
      errors: [],
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
      this.loadWallet();
    },
    loadWallet(params = {}) {
      this.errors = [];
      // パラメータ生成
      this.$http
        .get(ApiURL.WALLET, params)
        .then((response) => {
          // 収入カテゴリ取得
          this.items = response.data.optional.bankList;
          if (response.data.optional.total == 0) {
            this.errors.push("口座が一件もありません。");
          }
        })
        .catch((error) => {
          console.log(error);
          // ログイン失敗
        });
    },
    changeCreate() {
      // 画面変更
      this.$router.push({
        name: VueFaileName.walletCreate,
      });
    },
    changeEdit(paramId) {
      // 画面変更
      this.$router.push({
        name: VueFaileName.walletEdit,
        params: { bankId: paramId },
      });
    },
    walletDelete(paramId) {
      this.errors = [];
      // 口座削除
      // パラメータ生成
      this.$http
        .delete(
          CommonUtils.createApiUrlPathParam(
            ApiURL.BANK_ID,
            ApiURL.BANK_ID_NAME,
            paramId
          ),
          CommonUtils.createApiHeader()
        )
        .then(() => {
          // 口座削除
          // 初期化処理
          this.loadWallet();
        })
        .catch((error) => {
          console.log(error);
          // 口座削除失敗
          this.errors.push("口座削除に失敗しました。");
        });
    },
  },
};
</script>

<style>
</style>
