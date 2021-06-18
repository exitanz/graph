<template>
  <!-- メニュー画面 -->
  <b-navbar toggleable type="dark" variant="dark">
    <b-navbar-brand :to="{ name: login }">
      相関図制作管理システム</b-navbar-brand
    >

    <b-navbar-brand>
      <!-----------Actorボタン-------------->
      <b-button v-b-modal="'actor_modal'" variant="info"
        >Actor<font-awesome-icon icon="user-plus" />
      </b-button>
      <b-modal
        id="actor_modal"
        ref="modal"
        title="入力画面"
        @show="resetModal"
        @hidden="resetModal"
        @ok="handleOk"
      ><!-----------Actorモーダルウィンドウ-------------->
        <form ref="form" @submit.stop.prevent="handleSubmit">
          <div class="mt-3">名前</div>
          <b-form-input id="actor_name-input"></b-form-input>
          <div class="mt-3">時系列</div>
          <b-form-select v-model="selected" :options="options">
            <b-form-select-option>時系列１</b-form-select-option>
            <b-form-select-option>時系列２</b-form-select-option>
            <b-form-select-option>時系列３</b-form-select-option>
          </b-form-select>
          <div class="mt-3">グループ</div>
          <b-form-select v-model="selected" :options="options">
            <b-form-select-option>グループA</b-form-select-option>
            <b-form-select-option>グループB</b-form-select-option>
            <b-form-select-option>グループC</b-form-select-option>
          </b-form-select>
          <div class="mt-3">アイコン</div>
          <b-form-file
            v-model="file1"
            placeholder="ファイルを選択"
          ></b-form-file>
          <div class="mt-3">詳細情報</div>
          <b-form-textarea
            id="actor_info"
            v-model="text"
            rows="3"
            max-rows="10"
          ></b-form-textarea>
        </form>
      </b-modal>
      <!-----------Linkボタン-------------->
      <b-button v-b-modal="'link_modal'" variant="success"
        >Link
        <font-awesome-icon icon="arrows-alt-h" />
      </b-button>
      <b-modal
        id="link_modal"
        ref="modal"
        title="入力画面"
        @show="resetModal"
        @hidden="resetModal"
        @ok="handleOk"
        ><!-----------Linkモーダルウィンドウ-------------->
        <form ref="form" @submit.stop.prevent="handleSubmit">
          <div class="mt-3">関係性名</div>
          <b-form-input id="link_name_input"></b-form-input>
          <div class="mt-3">From</div>
          <b-form-select v-model="selected" :options="options">
            <b-form-select-option>A</b-form-select-option>
            <b-form-select-option>B</b-form-select-option>
            <b-form-select-option>C</b-form-select-option>
          </b-form-select>
          <div class="mt-3">to</div>
          <b-form-select v-model="selected" :options="options">
            <b-form-select-option>A</b-form-select-option>
            <b-form-select-option>B</b-form-select-option>
            <b-form-select-option>C</b-form-select-option>
          </b-form-select>
          <div class="mt-3">時系列</div>
          <b-form-select v-model="selected" :options="options">
            <b-form-select-option>時系列１</b-form-select-option>
            <b-form-select-option>時系列２</b-form-select-option>
            <b-form-select-option>時系列３</b-form-select-option>
          </b-form-select>
          <div class="mt-3">詳細情報</div>
          <b-form-textarea
            id="link_info"
            v-model="text"
            rows="3"
            max-rows="10"
          ></b-form-textarea>
        </form>
      </b-modal>
      <!-----------UpLoadボタン-------------->
      <b-button variant="secondary">
        <font-awesome-icon icon="download" />
      </b-button>
      <!-----------SetUpボタン-------------->
      <b-dropdown right toggle-class="text-decoration-none" no-caret>
        <template #button-content>
          <font-awesome-icon icon="cog" />
        </template>
        <b-dropdown-item>相関図一覧</b-dropdown-item>
        <b-dropdown-item>時系列名編集</b-dropdown-item>
        <b-dropdown-item>グループ名編集</b-dropdown-item>
        <b-dropdown-item variant="danger" v-b-modal.modal-4
          >図を削除する</b-dropdown-item
        >
      </b-dropdown>
    </b-navbar-brand>
  </b-navbar>
</template>

<script>
//import { CommonUtils } from "../common/CommonUtils.js";
//import { ApiURL } from "../constants/ApiURL.js";
//import { VueFaileName } from "../constants/VueFaileName.js";

/*export default {
  data() {
    return {
      login: VueFaileName.login,
      userCreate: VueFaileName.userCreate,
      calendar: VueFaileName.calendar,
      walletManage: VueFaileName.walletManage,
      incomeHistory: VueFaileName.incomeHistory,
      paymentHistory: VueFaileName.paymentHistory,
      transHistory: VueFaileName.transHistory,
      incCategoryMenu: VueFaileName.incCategoryMenu,
      payCategoryMenu: VueFaileName.payCategoryMenu,
      budget: VueFaileName.budget,
    };
  },
  computed: {
    loginStatus() {
      return this.$store.getters.getJsessionId !== null;
    },
  },
  methods: {
    logout() {
      this.$http
        .post(
          CommonUtils.createApiUrl(ApiURL.LOGOUT),
          CommonUtils.createApiHeader()
        )
        .then(() => {
          // ログアウト成功
          // CookieにJSESSIONIDを登録
          CommonUtils.delCookie("JSESSIONID");

          // Vuexのセッションを初期化
          this.$store.commit("setJsessionId", null);

          this.$router.push({
            name: VueFaileName.login,
          });
        })
        .catch((error) => {
          // ログアウト失敗
          console.log(error);
        });
    },
  },
};*/
</script>

<style>
</style>
