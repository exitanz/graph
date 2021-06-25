<template>
  <!--------------------------メニュー欄-------------------------->
  <b-navbar toggleable type="dark" variant="dark">
    <!--作品一覧のメニュー欄-->
    <b-button variant="secondary" @click="read_work">
      <font-awesome-icon icon="arrow-circle-left" />
    </b-button>
    <b-navbar-brand v-if="isActive"> 相関図制作システム </b-navbar-brand>

    <!--相関図制作画面のメニュー欄-->
    <b-navbar-brand div v-else> 作品名A</b-navbar-brand>
    <b-navbar-brand>
      <!-----------Actorボタン------------->
      <b-button v-b-modal="'actor_modal'" variant="info"
        >Actor<font-awesome-icon icon="user-plus" />
      </b-button>
      <!-----------Linkボタン-------------->
      <b-button v-b-modal="'link_modal'" variant="success"
        >Link
        <font-awesome-icon icon="arrows-alt-h" />
      </b-button>
      <!-----------UpLoadボタン------------->
      <b-button variant="secondary">
        <font-awesome-icon icon="download" />
      </b-button>
      <!-----------SetUpボタン------------->
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
