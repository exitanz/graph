<template>
  <div class="row">
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
                v-bind:class="[userIdValid]"
                placeholder="ユーザIDを入力してください。"
                type="text"
                name="userId"
                v-model="userId"
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
                v-bind:class="[passwordValid]"
                placeholder="パスワードを入力してください。"
                type="password"
                name="password"
                v-model="password"
              />
            </div>
          </div>
          <br />
          <div class="form-group">
            <router-link v-bind:to="{ name: graphList }">
              <button
                @click="accountLogin"
                type="submit"
                class="btn btn-primary btn-block"
                id="login"
              >
                ログイン
              </button>
            </router-link>
          </div>
          <div class="form-group">
            <p class="text-center">
              新規登録の方は
              <router-link
                class="text-primary"
                v-bind:to="{ name: userCreate }"
              >
                こちら
              </router-link>
            </p>
          </div>
          <div class="form-group">
            <p class="text-center">
              パスワードをお忘れの方は
              <router-link class="text-primary" v-bind:to="{ name: question }">
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
//import { ApiURL } from "../../constants/ApiURL.js";
//import { CommonUtils } from "../../common/CommonUtils.js";
import { VueFaileName } from "../../constants/VueFaileName.js";

export default {
  data() {
    return {
      loginStatus: false,
      errors: [],
      userId: "",
      password: "",
      userIdValid: "",
      passwordValid: "",
      // graphList: VueFaileName.graphList,
      graphList: 'r',
      userCreate: VueFaileName.userCreate,
      question: VueFaileName.question,
    };
  },
  /*methods: {
    accountLogin() {
      // パラメータ生成
      const params = {
        userId: this.userId,
        password: this.password,
      };

      // バリデーションチェック
      if (this.validation(params)) {
        throw "バリデーションエラー";
      }

      this.$http
        .post(ApiURL.LOGIN, params)
        .then((response) => {
          // ログイン成功

          // CookieにJSESSIONIDを登録
          CommonUtils.setCookie("JSESSIONID", response.data.optional.sessionId);

          // VuexにJSESSIONIDを補完
          this.$store.commit("setJsessionId", response.data.optional.sessionId);

          // 画面変更
          this.$router.push({
            name: VueFaileName.calendar,
          });
        })
        .catch((error) => {
          console.log(error);
          // ログイン失敗
          this.errors.push("ユーザIDまたはパスワードが違います。");
        });
    },

    validation(params) {
      // 初期化
      let validationFlg = false;
      this.errors = [];

      if (CommonUtils.eq(params.userId, "")) {
        this.errors.push("ユーザIDは必須項目です。");
        this.userIdValid = "is-invalid";
        validationFlg = true;
      }
      if (params.userId.length != 12) {
        this.errors.push("ユーザIDは12文字で入力してください。");
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
  },*/
};
</script>

<style>
</style>
