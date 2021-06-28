<template>
  <!--------------------------メニューバー-------------------------->
  <b-navbar toggleable type="dark" variant="dark">
    <!--ログイン、ログアウト、新規登録、パスワード変更画面のメニューバー-->
    <b-navbar-brand> 相関図制作システム </b-navbar-brand>

    <!--相関図一覧画面のメニューバー--
    <b-navbar-brand> 相関図制作システム </b-navbar-brand>
    <b-navbar-brand>
      <b-dropdown right toggle-class="text-decoration-none" no-caret>
        <template #button-content>
          <font-awesome-icon icon="upload" />
        </template>
        <b-dropdown-item v-b-modal="'upload_set_modal'"
          >相関図を投稿する</b-dropdown-item
        >
        <b-dropdown-item>投稿画面へ</b-dropdown-item>
      </b-dropdown>
      <b-dropdown right toggle-class="text-decoration-none" no-caret>
        <template #button-content>
          <font-awesome-icon icon="cog" />
        </template>
        <b-dropdown-item variant="danger" v-b-modal="'logout_modal'"
          >ログアウトする</b-dropdown-item
        >
      </b-dropdown>
    </b-navbar-brand>-->

    <!--相関図制作画面のメニューバー--
    <b-button variant="secondary">
      <font-awesome-icon icon="arrow-circle-left" />
    </b-button>
    <b-navbar-brand> 作品名A</b-navbar-brand>
    <b-navbar-brand>
      <-----------Actorボタン-------------
      <b-button v-b-modal="'actor_modal'" variant="info"
        >Actor<font-awesome-icon icon="user-plus" />
      </b-button>
      <-----------Linkボタン--------------
      <b-button v-b-modal="'link_modal'" variant="success"
        >Link
        <font-awesome-icon icon="arrows-alt-h" />
      </b-button>
      <-----------UpLoadボタン-------------
      <b-dropdown right toggle-class="text-decoration-none" no-caret>
        <template #button-content>
          <font-awesome-icon icon="upload" />
        </template>
        <b-dropdown-item v-b-modal="'upload_modal'"
          >相関図を投稿する</b-dropdown-item
        >
        <b-dropdown-item>投稿画面へ</b-dropdown-item>
      </b-dropdown>
      <-----------SetUpボタン-------------
      <b-dropdown right toggle-class="text-decoration-none" no-caret>
        <template #button-content>
          <font-awesome-icon icon="cog" />
        </template>
        <b-dropdown-item v-b-modal="'time_modal'">時系列名編集</b-dropdown-item>
        <b-dropdown-item v-b-modal="'group_modal'">グループ名編集</b-dropdown-item>
        <b-dropdown-item variant="danger" v-b-modal="'delete_modal'"
          >図を削除する</b-dropdown-item
        >
        <b-dropdown-item variant="danger" v-b-modal="'logout_modal'"
          >ログアウトする</b-dropdown-item
        >
      </b-dropdown>
    </b-navbar-brand>-->
    <!--相関図投稿画面のメニューバー--
    <b-navbar-brand> 相関図投稿画面 </b-navbar-brand>
    <b-navbar-brand>
      <b-button v-b-modal="'upload_set_modal'" variant="success"
        >投稿する
        <font-awesome-icon icon="upload" />
      </b-button>
      <b-dropdown right toggle-class="text-decoration-none" no-caret>
        <template #button-content>
          <font-awesome-icon icon="user" />
        </template>
        <b-dropdown-item v-b-modal="'mypage_modal'"
          >マイページ</b-dropdown-item
        >
        <b-dropdown-item
          >相関図一覧画面へ</b-dropdown-item
        >
        <b-dropdown-item variant="danger" v-b-modal="'logout_modal'"
          >ログアウトする</b-dropdown-item
        >
      </b-dropdown>
    </b-navbar-brand>-->
  </b-navbar>
</template>

<script>
//import { CommonUtils } from "../common/CommonUtils.js";
//import { ApiURL } from "../constants/ApiURL.js";
//import { VueFaileName } from "../constants/VueFaileName.js";

/*export default {
  methods: {
    read_work() {
      this.$router.push({
        name: VueFaileName.login,
      });
    },
  },
};*/
</script>

<style>
</style>
