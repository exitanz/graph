<template>
  <div class="row">
    <!--------------------------相関図一覧画面-------------------------------->
    <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
    <aside class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
      <div class="card">
        <article class="card-body">
          <h4 class="card-title text-center mb-4 mt-1">相関図一覧</h4>
          <hr />
          <br />
          <b-alert show variant="success">相関図が作成されました。</b-alert>
          <b-alert show variant="danger"
            >作品名は〇文字以内で入力してください。</b-alert
          >
          <br />
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
        <!-----------編集モーダルウィンドウ-------------->
        <b-modal id="edit_modal" title="編集画面">
          <div class="mt-3">作品名</div>
          <b-form-input id="work_name-input"></b-form-input>
          <template #modal-footer="{ cancel, ok }">
            <b-button @click="cancel()"> Cancel </b-button>
            <b-button variant="primary" @click="ok()"> OK </b-button>
          </template>
        </b-modal>
        <!-----------削除モーダルウィンドウ-------------->
        <b-modal id="delete_modal" title="削除確認画面">
          <p class="my-4">データを削除しますか？</p>
          <template #modal-footer="{ cancel, ok }">
            <b-button @click="cancel()"> Cancel </b-button>
            <b-button variant="primary" @click="ok()"> OK </b-button>
          </template>
        </b-modal>
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
          <template #modal-footer="{ ok }">
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
      works: [],
      graphCreate: VueFaileName.graphCreate,
      login: VueFaileName.login,
    };
  },
};
</script>

<style>
</style>
