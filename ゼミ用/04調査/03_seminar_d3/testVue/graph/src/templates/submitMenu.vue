<template>
  <!-----------------------------------メニューバー--------------------------------------->
  <b-navbar toggleable type="dark" variant="dark">
    <b-navbar-brand> 相関図投稿画面 </b-navbar-brand>
    <b-navbar-brand>
      <b-button v-b-modal="'upload_set_modal'" variant="success"
        >投稿する
        <font-awesome-icon icon="upload" />
      </b-button>
      <b-dropdown right toggle-class="text-decoration-none" no-caret>
        <template #button-content>
          <font-awesome-icon icon="cog" />
        </template>
        <b-dropdown-item v-b-modal="'submit_set_modal'"
          >投稿管理</b-dropdown-item
        >
        <b-dropdown-item>
          <router-link v-bind:to="{ name: graphList }"
            >相関図一覧画面へ
          </router-link></b-dropdown-item
        >
        <b-dropdown-item variant="danger" v-b-modal="'logout_modal'"
          >ログアウトする</b-dropdown-item
        >
      </b-dropdown>
    </b-navbar-brand>
  </b-navbar>
</template>

<script>
//import { CommonUtils } from "../common/CommonUtils.js";
//import { ApiURL } from "../constants/ApiURL.js";
import { VueFileName } from "../constants/VueFileName.js";

export default {
  data() {
    return {
      graphList: VueFileName.graphList,
    };
  },
};
</script>

<style>
</style>
