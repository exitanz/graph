<template>
  <div class="row">
    <aside class="col-sm-0 col-md-20 col-lg-2 col-xl-2"></aside>
    <aside class="col-sm-12 col-md-20 col-lg-8 col-xl-8">
      <div class="card">
        <article class="card-body">
          <h4 class="card-title text-center mb-4 mt-1">口座登録</h4>
          <hr>
          <div class="form-group">
            <br />
            <div
              v-if="complete"
              class="alert alert-success"
            >
              口座を登録しました。<br />
            </div>
            <div
              v-for="(error, key) in errors"
              :key="key"
            >
              <div class="alert alert-danger">{{error}}<br /></div>
            </div>
            <br />
            <h3>口座名</h3>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <font-awesome-icon icon="wallet" />
                </span>
              </div>
              <input
                class="form-control"
                placeholder="口座名を入力してください。"
                type="text"
                name="wallet_name"
                v-model="walletName"
                v-bind:class="[walletNameValid]"
              >
            </div>
          </div>
          <br />
          <br />
          <div class="form-group">
            <p class="text-center">
              <button
                type="submit"
                class="btn btn-primary btn-block"
                @click="createWallet"
              >
                登録
              </button>
            </p>
          </div>
          <div class="form-group row">
            <div class="col">
              <button
                type="submit"
                class="btn btn-danger btn-block"
                @click="returnWallet"
              >
                戻る
              </button>
            </div>
          </div>
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
      complete: false,
      walletName: "",
      walletNameValid: "",
    };
  },
  methods: {
    createWallet() {
      // パラメータ生成
      const params = {
        bankName: this.walletName,
      };

      // バリデーションチェック
      if (this.validation(params)) {
        throw "バリデーションエラー";
      }

      // const params = new URLSearchParams();
      // params.append("walletName", validParams.walletName);

      this.$http
        .post(ApiURL.WALLET, params)
        .then(() => {
          // 口座登録成功
          // 完了処理
          this.complete = true;
        })
        .catch((error) => {
          console.log(error);
          // 口座登録失敗
          this.errors.push("口座登録に失敗しました。");
        });
    },

    validation(params) {
      // 初期化
      let validationFlg = false;
      this.complete = false;
      this.errors = [];
      this.walletNameValid = "";

      if (CommonUtils.eq(params.bankName, "")) {
        this.errors.push("口座名は必須項目です。");
        this.walletNameValid = "is-invalid";
        validationFlg = true;
      }
      if (params.bankName.length < 1 || 20 < params.bankName.length) {
        this.errors.push("口座名は1から20文字以内で入力してください。");
        this.walletNameValid = "is-invalid";
        validationFlg = true;
      }
      return validationFlg;
    },
    returnWallet() {
      // 画面変更
      this.$router.push({
        name: VueFaileName.walletManage,
      });
    },
  },
};
</script>

<style>
</style>
