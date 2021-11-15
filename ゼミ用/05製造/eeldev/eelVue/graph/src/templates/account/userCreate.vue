<template>
  <div class="row">
    <aside class="col-12">
      <!-----------------------------------メニューバー--------------------------------------->
      <b-navbar toggleable type="dark" variant="dark">
        <b-navbar-brand> 相関図制作システム </b-navbar-brand>
      </b-navbar>
    </aside>
    <!-----------------------------------新規登録画面--------------------------------------->
    <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
    <aside class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
      <div class="card">
        <article class="card-body">
          <h4 class="card-title text-center mb-4 mt-1">新規登録</h4>
          <hr />
          <div class="form-group">
            <br />
            <div v-for="(error, key) in errors" :key="key">
              <div class="alert alert-danger">{{ error }}<br /></div>
            </div>
            <div v-if="complete" class="alert alert-success">
              ユーザ登録が完了しました。<br />
              （ユーザID：<span class="bg-warning">{{ userId }}</span
              >）<br />
            </div>
            <br />
            <h3>ユーザ名</h3>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <font-awesome-icon icon="signature" />
                </span>
              </div>
              <input
                class="form-control"
                v-bind:class="[userNameValid]"
                placeholder="ユーザ名を入力してください。"
                type="text"
                name="user_name"
                v-model="userName"
              />
            </div>
          </div>
          <br />
          <div class="form-group">
            <h3>パスワード</h3>
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
          <div class="form-group row">
            <div class="col">
              <button
                @click="userCreate"
                type="submit"
                class="btn btn-primary btn-block"
                id="usercreatesend"
              >
                送信
              </button>
            </div>
          </div>
          <div class="form-group row">
            <div class="col">
              <button
                type="submit"
                class="btn btn-danger btn-block"
                @click="returnLogin"
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
// import { ApiURL } from "../../constants/ApiURL.js";
import { CommonUtils } from "../../common/CommonUtils.js";
import { VueFileName } from "../../constants/VueFileName.js";

export default {
  data() {
    return {
      userId: "",
      userName: "",
      password: "",
      userNameValid: "",
      passwordValid: "",
      secretQuestionIdValid: "",
      secretAnswerValid: "",
      items: [],
      errors: [],
      complete: false,
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
    },
    userCreate() {
      // パラメータ生成
      const params = {
        user_name: this.userName,
        password: this.password,
      };

      // バリデーションチェック
      if (this.validation(params)) {
        throw "バリデーションエラー";
      }

      let test = eel
        .CreateAccountController(params)((response) => {
          // ログイン成功
          // 完了処理
          this.complete = true;
          // this.userId = response.data.optional.user_id;
        });
        console.log(test);
        // .catch((error) => {
        //   // ユーザ登録失敗
        //   this.errors = error.response.data.optional.msg;
        // });
    },
    validation(params) {
      // 初期化
      let validationFlg = false;
      this.complete = false;
      this.errors = [];
      this.userNameValid = "";
      this.passwordValid = "";

      if (CommonUtils.eq(params.user_name, "")) {
        this.errors.push("ユーザ名は必須項目です。");
        this.userNameValid = "is-invalid";
        validationFlg = true;
      }
      if (params.user_name.length < 1 || 20 < params.user_name.length) {
        this.errors.push("ユーザ名は1から20文字以内で入力してください。");
        this.userNameValid = "is-invalid";
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
    returnLogin() {
      // 画面変更
      this.$router.push({
        name: VueFileName.login,
      });
    },
  },
};
</script>

<style>
</style>
