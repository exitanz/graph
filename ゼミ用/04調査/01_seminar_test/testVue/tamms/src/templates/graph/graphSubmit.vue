<template>
  <div class="row">
    <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
    <aside class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
      <article class="card-body">
        <h4 class="card-title text-center mb-4 mt-1">相関図一覧</h4>
        <div>
          <b-card>
            <template #header>
              <b-tabs pills>
                <b-tab title="ユーザ名" active></b-tab>
                <b-tab title="作品名"></b-tab>
              </b-tabs>
            </template>

            <aside class="col-12" id="side_search">
              <b-form inline>
                <label class="mr-sm-2">検索</label>
                <b-form-input
                  class="mb-2 mr-sm-2 mb-sm-0"
                  placeholder="Search"
                ></b-form-input>
                <b-button variant="info">
                  <font-awesome-icon icon="search" />
                </b-button>
              </b-form>
            </aside>
          </b-card>
        </div>
        <hr />
        <br />
        <table class="table">
          <thead class="thead-light">
            <tr>
              <th>ユーザ名</th>
              <th>作品名</th>
              <th>閲覧</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(row, key) in times" :key="key">
              <td>{{ row.userName }}</td>
              <td>{{ row.workName }}</td>
              <td>
                <button type="button" class="btn btn-info">
                  <font-awesome-icon icon="eye" />
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <!-----------アップロードモーダルウィンドウ-------------->
        <b-modal id="upload_set_modal" title="確認画面">
          <p class="my-4">投稿する相関図を選択してください。</p>
          <table class="table">
            <thead class="thead-light">
              <tr>
                <th>選択</th>
                <th>作品名</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(row, key) in works" :key="key">
                <td>
                  <b-form-checkbox size="lg"></b-form-checkbox>
                </td>
                <td>{{ row.workName }}</td>
              </tr>
            </tbody>
          </table>
          <template #modal-footer="{ cancel, ok }">
            <b-button @click="cancel()"> Cancel </b-button>
            <b-button v-b-modal="'check_modal'" variant="primary" @click="ok()">
              OK
            </b-button>
          </template>
        </b-modal>
        <!-----------確認モーダルウィンドウ-------------->
        <b-modal id="check_modal" title="確認画面">
          <p class="my-4">相関図が投稿されました。</p>
          <template #modal-footer="{ cancel, ok }">
            <b-button @click="cancel()"> Cancel </b-button>
            <b-button variant="primary" @click="ok()"> OK </b-button>
          </template>
        </b-modal>
        <!-----------投稿管理モーダルウィンドウ-------------->
        <b-modal id="submit_set_modal" title="管理画面">
          <p class="my-4">投稿済み相関図</p>
          <table class="table">
            <thead class="thead-light">
              <tr>
                <th>作品名</th>
                <th>編集</th>
                <th>削除</th>
                <th>閲覧</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(row, key) in works" :key="key">
                <td>{{ row.workName }}</td>
                <td>
                  <button
                    type="button"
                    class="btn btn-success"
                    v-b-modal="'edit_modal'"
                  >
                    <font-awesome-icon icon="pencil-alt" />
                  </button>
                </td>
                <td>
                  <button
                    type="button"
                    class="btn btn-danger"
                    v-b-modal="'delete_modal'"
                  >
                    <font-awesome-icon icon="times" />
                  </button>
                </td>
                <td>
                  <router-link v-bind:to="{ name: graphCreate }">
                    <button
                      type="button"
                      class="btn btn-info"
                      @click="read_graph"
                    >
                      <font-awesome-icon icon="eye" />
                    </button>
                  </router-link>
                </td>
              </tr>
            </tbody>
          </table>
          <template #modal-footer="{ cancel, ok }">
            <b-button @click="cancel()"> Cancel </b-button>
            <b-button variant="primary" @click="ok()"> OK </b-button>
          </template>
        </b-modal>
        <!-----------ログアウトモーダルウィンドウ-------------->
        <b-modal id="logout_modal" title="確認画面">
          <p class="my-4">ログアウトしますか？</p>
          <template #modal-footer="{ cancel }">
            <b-button @click="cancel()"> Cancel </b-button>
            <router-link v-bind:to="{ name: login }">
              <b-button variant="primary"> OK </b-button>
            </router-link>
          </template>
        </b-modal>
      </article>
    </aside>
    <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
  </div>
</template>

<script>
//import { ApiURL } from "../../constants/ApiURL.js";
//import { CommonUtils } from "../../common/CommonUtils.js";
import { VueFaileName } from "../../constants/VueFaileName.js";

export default {
  data() {
    return {
      works: [],
      graphCreate: VueFaileName.graphCreate,
      login: VueFaileName.login,
    };
  },
};
</script>

<style>
</style>
