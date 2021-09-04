<template>
<span></span>
  <!-----------------------------------メニューバー--------------------------------------->
  <!-- <b-navbar toggleable type="dark" variant="dark">
    <b-button variant="secondary" @click="returnBtn()">
      <font-awesome-icon icon="arrow-circle-left" />
    </b-button>
    <b-navbar-brand> 作品名A</b-navbar-brand>
    <b-navbar-brand>
      <b-button
        variant="info"
        @click="isActorCreateModal = true"
        >Actor<font-awesome-icon icon="user-plus" />
      </b-button>
      <b-button v-b-modal="'link_modal'" variant="success"
        >Link
        <font-awesome-icon icon="arrows-alt-h" />
      </b-button>
      <b-dropdown right toggle-class="text-decoration-none" variant="warning">
        <template #button-content>
          Edit
          <font-awesome-icon icon="edit" />
        </template>
        <b-dropdown-item v-b-modal="'time_modal'">時系列名編集</b-dropdown-item>
        <b-dropdown-item v-b-modal="'group_modal'"
          >グループ名編集</b-dropdown-item
        >
      </b-dropdown>
      <b-dropdown right toggle-class="text-decoration-none" no-caret>
        <template #button-content>
          <font-awesome-icon icon="cog" />
        </template>
        <b-dropdown-item v-b-modal="'upload_modal'"
          >相関図を投稿する</b-dropdown-item
        >
        <b-dropdown-item>
          <router-link v-bind:to="{ name: graphSubmit }"
            >投稿画面へ
          </router-link></b-dropdown-item
        >
        <b-dropdown-item variant="danger" v-b-modal="'delete_modal'"
          >図を削除する</b-dropdown-item
        >
        <b-dropdown-item variant="danger" v-b-modal="'logout_modal'"
          >ログアウトする</b-dropdown-item
        >
      </b-dropdown>
    </b-navbar-brand>
  </b-navbar> -->
</template>

<script>
//import { CommonUtils } from "../common/CommonUtils.js";
//import { ApiURL } from "../constants/ApiURL.js";
// import { VueFaileName } from "../constants/VueFaileName.js";

export default {
};
</script>

<style>
</style>
