<template>
  <div class="row">
    <!--------------------------作品一覧画面-------------------------------->
    <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
    <aside class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
      <div class="card">
        <article class="card-body">
          <h4 class="card-title text-center mb-4 mt-1">相関図一覧</h4>
          <hr />
          <br />
          <b-alert show variant="success">作品名が作成されました。</b-alert>
          <b-alert show variant="danger"
            >〇〇文字以内で入力してください。</b-alert
          >
          <hr />
        </article>
        <b-container fluid>
          <b-row class="my-1">
            <b-col sm="2">
              <label class="mb-4 mt-1">作品名：</label>
            </b-col>
            <b-col sm="8">
              <b-form-input id="work-input"></b-form-input>
            </b-col>
            <b-col sm="2">
              <b-button variant="info"> 追加 </b-button>
            </b-col>
          </b-row>
        </b-container>
        <br />
        <br />
        <b-table :items="time" :fields="time_fields" striped responsive="sm">
          <template #cell(作品名)>
            <b-form-input class="mb-2 mr-sm-2 mb-sm-0" disabled></b-form-input>
          </template>
          <template #cell(編集)>
            <b-button size="sm" class="mr-2" variant="success">
              <font-awesome-icon icon="pencil-alt" />
            </b-button>
          </template>
          <template #cell(削除)>
            <b-button
              size="sm"
              class="mr-2"
              variant="danger"
              v-b-modal.delete_modal
            >
              <font-awesome-icon icon="times" />
            </b-button>
          </template>
          <template #cell(閲覧)>
            <b-button size="sm" class="mr-2" variant="info" @click="read_graph">
              <font-awesome-icon icon="eye" />
            </b-button>
          </template>
        </b-table>
        <!-----------削除モーダルウィンドウ-------------->
        <b-modal id="delete_modal" title="削除確認画面">
          <p class="my-4">データを削除しますか？</p>
        </b-modal>
      </div>
    </aside>
  </div>
</template>

<script>
//import { ApiURL } from "../../constants/ApiURL.js";
//import { CommonUtils } from "../../common/CommonUtils.js";
import { VueFaileName } from "../../constants/VueFaileName.js";

export default {
  data() {
    return {
      time_fields: ["作品名", "編集", "削除", "閲覧"],
      time: [
        {
          作品名: "作品名A",
        },
        {
          作品名: "作品名B",
        },
        {
          作品名: "作品名C",
        },
      ],
    };
  },
  datas: {
    isActive: true
  },
  methods: {
    read_graph() {
      this.$router.push({
        name: VueFaileName.question,
        function() {
          this.isActive = !this.isActive;
        },
      });
    },
  },
};
/*export default {
  data() {
    return {
      loginStatus: false,
      errors: [],
      userId: "",
      password: "",
      userIdValid: "",
      passwordValid: "",
      userCreate: VueFaileName.userCreate,
      question: VueFaileName.question,
    };
  },
  methods: {
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
  },
};*/
</script>

<style>
</style>
