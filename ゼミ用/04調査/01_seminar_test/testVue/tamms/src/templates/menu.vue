<template>
  <!-----------------------作品一覧画面----------------------->
  <b-navbar toggleable type="dark" variant="dark">
    <b-navbar-brand> 相関図制作管理システム </b-navbar-brand>
  </b-navbar>

  <!-----------------------相関図制作画面----------------------->
  <!--メニュー欄 
  <b-navbar toggleable type="dark" variant="dark">
    <b-button variant="secondary">
      <font-awesome-icon icon="arrow-circle-left" />
    </b-button>
    <b-navbar-brand> 作品名A</b-navbar-brand>

    <b-navbar-brand>
      <-----------Actorボタン-------------
      <b-button v-b-modal="'actor_modal'" variant="info"
        >Actor<font-awesome-icon icon="user-plus" />
      </b-button>
      <-----------Linkボタン-------------
      <b-button v-b-modal="'link_modal'" variant="success"
        >Link
        <font-awesome-icon icon="arrows-alt-h" />
      </b-button>
      <-----------UpLoadボタン-------------
      <b-button variant="secondary">
        <font-awesome-icon icon="download" />
      </b-button>
      <-----------SetUpボタン-------------
      <b-dropdown right toggle-class="text-decoration-none" no-caret>
        <template #button-content>
          <font-awesome-icon icon="cog" />
        </template>
        <b-dropdown-item v-b-modal.time_modal>時系列名編集</b-dropdown-item>
        <b-dropdown-item v-b-modal.group_modal>グループ名編集</b-dropdown-item>
        <b-dropdown-item variant="danger" v-b-modal.delete_modal
          >図を削除する</b-dropdown-item
        >
      </b-dropdown>
    </b-navbar-brand>
  </b-navbar>
  -->
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
