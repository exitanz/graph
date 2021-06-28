<template>
  <div class="row">
    <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
    <aside class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
      <div class="card">
        <article class="card-body">
          <h4 class="card-title text-center mb-4 mt-1">パスワード変更</h4>
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
              パスワード変更が完了しました。<br />
            </div>
            <br />
            <h3>ユーザID</h3>
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
            <h3>新しいパスワード</h3>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <font-awesome-icon icon="lock" />
                </span>
              </div>
              <input
                class="form-control"
                v-bind:class="[newPasswordValid]"
                placeholder="新しいパスワードを入力してください。"
                type="password"
                name="newPassword"
                v-model="newPassword"
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
                @click="changePassword"
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
      complete: false,
      userId: "",
      newPassword: "",
      secretQuestionId: "",
      secretAnswer: "",
      userIdValid: "",
      newPasswordValid: "",
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
          console.log(response.data.optional.secretQuestionList);
          this.items = response.data.optional.secretQuestionList;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    changePassword() {
      // パラメータ生成
      const params = {
        userId: this.userId,
        newPassword: this.newPassword,
        secretQuestionId: this.secretQuestionId,
        secretAnswer: this.secretAnswer,
      };

      // バリデーションチェック
      if (this.validation(params)) {
        throw "バリデーションエラー";
      }

      this.$http
        .post(ApiURL.QUESTION, params)
        .then((response) => {
          // ログイン成功
          console.log(response);
          // 画面変更
          this.complete = true;
        })
        .catch((error) => {
          console.log(error);
          // ユーザ登録失敗
          this.errors.push(
            "ユーザIDまたは秘密の質問と質問の答えが一致しません。"
          );
        });
    },

    validation(params) {
      // 初期化
      let validationFlg = false;
      this.complete = false;
      this.errors = [];
      this.userIdValid = "";
      this.newPasswordValid = "";
      this.secretQuestionIdValid = "";
      this.secretAnswerValid = "";

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
      if (CommonUtils.eq(params.newPassword, "")) {
        this.errors.push("新しいパスワードは必須項目です。");
        this.newPasswordValid = "is-invalid";
        validationFlg = true;
      }
      if (params.newPassword.length < 1 || 20 < params.newPassword.length) {
        this.errors.push(
          "新しいパスワードは1から20文字以内で入力してください。"
        );
        this.newPasswordValid = "is-invalid";
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
