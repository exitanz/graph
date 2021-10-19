<template>
  <div class="row">
    <aside class="col-12">
      <!-----------------------------------メニューバー--------------------------------------->
      <b-navbar toggleable type="dark" variant="dark">
        <b-navbar-brand> 相関図制作システム </b-navbar-brand>
      </b-navbar>
    </aside>
    <!-----------------------------------ログイン画面--------------------------------------->
    <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
    <aside class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
      <div class="card">
        <article class="card-body">
          <h4 class="card-title text-center mb-4 mt-1">ログイン</h4>
          <hr />
          <div class="form-group">
            <br />
            <div v-for="(error, key) in errors" :key="key">
              <div class="alert alert-danger">{{ error }}<br /></div>
            </div>
            <br />
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <font-awesome-icon icon="user" />
                </span>
              </div>
              <input
                class="form-control"
                v-bind:class="[loginRequest.userIdValid]"
                placeholder="ユーザIDを入力してください。"
                type="text"
                name="userId"
                v-model="loginRequest.userId"
              />
            </div>
          </div>
          <br />
          <div class="form-group">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <font-awesome-icon icon="lock" />
                </span>
              </div>
              <input
                class="form-control"
                v-bind:class="[loginRequest.passwordValid]"
                placeholder="パスワードを入力してください。"
                type="password"
                name="password"
                v-model="loginRequest.password"
              />
            </div>
          </div>
          <br />
          <div class="form-group">
            <button
              @click="accountLogin"
              type="submit"
              class="btn btn-primary btn-block"
              id="login"
            >
              ログイン
            </button>
          </div>
          <div class="form-group">
            <p class="text-center">
              新規登録の方は
              <router-link
                class="text-primary"
                v-bind:to="{ name: vueLinks.userCreate }"
              >
                こちら
              </router-link>
            </p>
          </div>
        </article>
      </div>
    </aside>
    <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
  </div>
</template>

<script>
import { ApiURL } from "../../constants/ApiURL.js";
import { Constant } from "../../constants/Constant.js";
import { CommonUtils } from "../../common/CommonUtils.js";
import { VueFileName } from "../../constants/VueFileName.js";

export default {
  data() {
    return {
      loginStatus: false,
      errors: [],
      // ログインリクエストパラメータ
      loginRequest: {
        userId: "",
        userIdValid: "",
        password: "",
        passwordValid: "",
      },
      vueLinks: {
        userCreate: VueFileName.userCreate,
        question: VueFileName.question,
      },
    };
  },
  methods: {
    accountLogin() {
      // パラメータ生成
      let params = {
        user_id: this.loginRequest.userId,
        password: this.loginRequest.password,
      };

      // バリデーションチェック
      if (this.validation(params)) {
        throw "バリデーションエラー";
      }

      this.$http
        .post(ApiURL.LOGIN, params)
        .then((response) => {
          // ログイン成功

          // VuexにUserIdを補完
          this.$store.commit("setUserId", response.data.optional.user_id);

          // Vuexにtokenを補完
          this.$store.commit("setToken", response.data.optional.token);

          // 画面変更
          this.$router.push({
            name: VueFileName.graphList,
          });
        })
        .catch((error) => {
          // ログイン失敗
          this.errors = error.response.data.optional.msg;
        });
    },

    validation(params) {
      // 初期化
      let validationFlg = false;
      this.errors = [];

      if (CommonUtils.eq(params.user_id, "")) {
        this.errors.push("ユーザIDは必須項目です。");
        this.userIdValid = "is-invalid";
        validationFlg = true;
      }
      if (
        params.user_id.length !=
        Constant.USER_ID_STR.length + Constant.USER_ID_DIGIT
      ) {
        this.errors.push(
          "ユーザIDは" +
            (Constant.USER_ID_STR.length + Constant.USER_ID_DIGIT) +
            "文字で入力してください。"
        );
        this.userIdValid = "is-invalid";
        validationFlg = true;
      }
      if (CommonUtils.eq(params.password, "")) {
        this.errors.push("パスワードは必須項目です。");
        this.passwordValid = "is-invalid";
        validationFlg = true;
      }
      if (params.password.length < 1 || 20 < params.password.length) {
        this.errors.push("パスワードは1から20文字以内で入力してください。");
        this.passwordValid = "is-invalid";
        validationFlg = true;
      }
      return validationFlg;
    },
  },
};
</script>

<style>
</style>
