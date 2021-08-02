<template>
  <div class="row">
    <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
    <aside class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
      <div class="card">
        <article class="card-body">
          <h4 class="card-title text-center mb-4 mt-1">新規登録</h4>
          <hr>
          <div class="form-group">
            <br />
            <div
              v-for="(error, key) in errors"
              :key="key"
            >
              <div class="alert alert-danger">{{error}}<br /></div>
            </div>
            <div
              v-if="complete"
              class="alert alert-success"
            >
              ユーザ登録が完了しました。<br />
              （ユーザID：<span class="bg-warning">{{userId}}</span>）<br />
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
              >
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
              >
            </div>
          </div>
          <br />
          <div class="form-group">
            <h3>秘密の質問</h3>
            <div class="row">
              <div class="col-md">
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text">
                        <font-awesome-icon icon="question-circle" />
                      </span>
                    </div>
                    <select
                      class="form-control"
                      v-model="secretQuestionId"
                      v-bind:class="[secretQuestionIdValid]"
                    >
                      <option
                        v-for="(row, key) in items"
                        :key="key"
                        v-bind:value="row.secretQuestionId"
                      >
                        {{ row.secretName }}
                      </option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group">
            <h3>質問の答え</h3>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <font-awesome-icon icon="comment-dots" />
                </span>
              </div>
              <input
                class="form-control"
                placeholder="質問の答えを入力してください。"
                type="text"
                name="secretAnswer"
                v-model="secretAnswer"
                v-bind:class="[secretAnswerValid]"
              >
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
import { ApiURL } from "../../constants/ApiURL.js";
import { CommonUtils } from "../../common/CommonUtils.js";
import { VueFaileName } from "../../constants/VueFaileName.js";

export default {
  data() {
    return {
      errors: [],
      userId: "",
      complete: false,
      userName: "",
      password: "",
      secretQuestionId: "",
      secretAnswer: "",
      userNameValid: "",
      passwordValid: "",
      secretQuestionIdValid: "",
      secretAnswerValid: "",
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
        .get(ApiURL.QUESTION)
        .then((response) => {
          // 秘密の質問取得
          this.items = response.data.optional.secretQuestionList;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    userCreate() {
      // パラメータ生成
      const params = {
        userName: this.userName,
        password: this.password,
        secretQuestionId: this.secretQuestionId,
        secretAnswer: this.secretAnswer,
      };

      // バリデーションチェック
      if (this.validation(params)) {
        throw "バリデーションエラー";
      }

      this.$http
        .post(ApiURL.SIGNUP, params)
        .then((response) => {
          // ログイン成功
          // 完了処理
          this.complete = true;
          this.userId = response.data.optional.userId;
        })
        .catch((error) => {
          console.log(error);
          // ユーザ登録失敗
          this.errors.push("ユーザ登録に失敗しました。");
        });
    },
    validation(params) {
      // 初期化
      let validationFlg = false;
      this.complete = false;
      this.errors = [];
      this.userNameValid = "";
      this.passwordValid = "";
      this.secretQuestionIdValid = "";
      this.secretAnswerValid = "";

      if (CommonUtils.eq(params.userName, "")) {
        this.errors.push("ユーザ名は必須項目です。");
        this.userNameValid = "is-invalid";
        validationFlg = true;
      }
      if (params.userName.length < 1 || 20 < params.userName.length) {
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
      if (CommonUtils.eq(params.secretQuestionId, "")) {
        this.errors.push("秘密の質問は必須項目です。");
        this.secretQuestionIdValid = "is-invalid";
        validationFlg = true;
      }
      if (params.secretQuestionId.length != 7) {
        this.errors.push("秘密の質問IDは7文字で入力してください。");
        this.secretQuestionIdValid = "is-invalid";
        validationFlg = true;
      }
      if (CommonUtils.eq(params.secretAnswer, "")) {
        this.errors.push("秘密の質問は必須項目です。");
        this.secretAnswerValid = "is-invalid";
        validationFlg = true;
      }
      if (params.secretAnswer.length < 1 || 20 < params.secretAnswer.length) {
        this.errors.push("秘密の答えは1から20文字以内で入力してください。");
        this.secretAnswerValid = "is-invalid";
        validationFlg = true;
      }
      return validationFlg;
    },
    returnLogin() {
      // 画面変更
      this.$router.push({
        name: VueFaileName.login,
      });
    },
  },
};
</script>

<style>
</style>
