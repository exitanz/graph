<template>
  <div class="row">
    <aside class="col-12">
      <!-----------------------------------メニューバー--------------------------------------->
      <b-navbar toggleable type="dark" variant="dark">
        <b-navbar-brand> 相関図制作システム </b-navbar-brand>
        <b-navbar-brand>
          <b-button variant="success" @click="isListUploadModal = true"
            >投稿する
            <font-awesome-icon icon="upload" />
          </b-button>
          <b-dropdown right toggle-class="text-decoration-none" no-caret>
            <template #button-content>
              <font-awesome-icon icon="cog" />
            </template>
            <b-dropdown-item>
              <router-link v-bind:to="{ name: graphSubmit }"
                >投稿画面へ
              </router-link></b-dropdown-item
            >
            <b-dropdown-item variant="danger" @click="isLogoutCheckModal = true"
              >ログアウト</b-dropdown-item
            >
          </b-dropdown>
        </b-navbar-brand>
      </b-navbar>
    </aside>
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
              <input
                class="form-control"
                placeholder="作品名を入力してください。"
                type="text"
                name="edit_actor_name"
                v-model="createOpus.opusName"
              />
            </b-col>
            <b-col sm="2">
              <b-button variant="info" @click="opusCreate()"> 追加 </b-button>
            </b-col>
          </b-row>
        </b-container>
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
            <tr v-for="(row, key) in opusList" :key="key">
              <td>{{ row.opusName }}</td>
              <td>
                <button
                  type="button"
                  class="btn btn-success"
                  @click="isListEditModal = true"
                >
                  <font-awesome-icon icon="pencil-alt" />
                </button>
              </td>
              <td>
                <button
                  type="button"
                  class="btn btn-danger"
                  @click="isListDeleteModal = true"
                >
                  <font-awesome-icon icon="times" />
                </button>
              </td>
              <td>
                <router-link v-bind:to="{ name: graphCreate }">
                  <button type="button" class="btn btn-info">
                    <font-awesome-icon icon="eye" />
                  </button>
                </router-link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </aside>
    <!-----------モーダルウィンドウ-------------->
    <!-----------投稿するボタン モーダルウィンドウ-------------->
    <b-modal v-model="isListUploadModal" title="確認画面">
      <b-container fluid>
        <p class="my-4">投稿する相関図を選択してください。</p>
        <table class="table">
          <thead class="thead-light">
            <tr>
              <th>選択</th>
              <th>作品名</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(row, key) in opusList" :key="key">
              <td>
                <b-form-checkbox size="lg"></b-form-checkbox>
              </td>
              <td>{{ row.opusName }}</td>
            </tr>
          </tbody>
        </table>
      </b-container>

      <template #modal-footer>
        <b-button
          variant="secondary"
          size="sm"
          class="float-right"
          @click="isListUploadModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="primary"
          size="sm"
          class="float-right"
          @click="listUpload()"
        >
          投稿する
        </b-button>
      </template>
    </b-modal>
    <!-----------ログアウト モーダル-------------->
    <b-modal v-model="isLogoutCheckModal" title="確認画面">
      <b-container fluid>
        <p class="my-4">ログアウトしますか？</p>
      </b-container>

      <template #modal-footer>
        <b-button
          variant="secondary"
          size="sm"
          class="float-right"
          @click="isLogoutCheckModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="danger"
          size="sm"
          class="float-right"
          @click="logoutCheck()"
        >
          ログアウト
        </b-button>
      </template>
    </b-modal>
    <!-----------編集 モーダル-------------->
    <b-modal v-model="isListEditModal" title="編集画面">
      <b-container fluid>
        <b-row class="mb-1">
          <input type="hidden" v-model="listEdit.listId" />
          <input type="hidden" v-model="listEdit.version" />
          <b-col cols="3">作品名</b-col>
          <b-col>
            <div class="input-group">
              <input
                class="form-control"
                placeholder="作品名を入力してください。"
                type="text"
                name="edit_list_name"
                v-model="listEdit.listName"
                v-bind:class="[listEdit.valid]"
              />
            </div>
          </b-col>
        </b-row>
      </b-container>

      <template #modal-footer>
        <b-button
          variant="secondary"
          size="sm"
          class="float-right"
          @click="isListEditModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="primary"
          size="sm"
          class="float-right"
          @click="listEdit()"
        >
          登録
        </b-button>
      </template>
    </b-modal>
    <!-----------削除ボタン モーダル-------------->
    <b-modal v-model="isListDeleteModal" title="確認画面">
      <b-container fluid>
        <p class="my-4">データを削除しますか？</p>
      </b-container>

      <template #modal-footer>
        <b-button
          variant="secondary"
          size="sm"
          class="float-right"
          @click="isListDeleteModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="danger"
          size="sm"
          class="float-right"
          @click="listDelete()"
        >
          削除
        </b-button>
      </template>
    </b-modal>
  </div>
</template>

<script type="module">
//import { ApiURL } from "../../constants/ApiURL.js";
//import { CommonUtils } from "../../common/CommonUtils.js";
import { VueFaileName } from "../../constants/VueFaileName.js";

export default {
  data() {
    return {
      opusList: [],
      createOpus: {
        opusName: "",
      },
      Upload: {
        version: 0,
        valid: "",
      },
      logoutCheck: {
        version: 0,
        valid: "",
      },
      listEdit: {
        listId: "",
        listName: "",
        version: 0,
        valid: "",
      },
      listDelete: {
        version: 0,
        valid: "",
      },
      opusName: "",
      graphSubmit: VueFaileName.graphSubmit,
      graphCreate: VueFaileName.graphCreate,
      login: VueFaileName.login,
      /* モーダルウィンドウ変数 */
      isUploadModal: false,
      isLogoutCheckModal: false,
      isListEditModal: false,
      isListDeleteModal: false,
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
      this.opusList = [
        {
          opusId: "opus0001",
          opusName: "あああ",
        },
        {
          opusId: "opus0002",
          opusName: "aaaa",
        },
        {
          opusId: "opus0003",
          opusName: "123445",
        },
        {
          opusId: "opus0004",
          opusName: "test",
        },
      ];

      // 作品一覧取得
      this.opusList = [
        {
          opusId: "opus0001",
          opusName: "あああ",
        },
        {
          opusId: "opus0002",
          opusName: "aaaa",
        },
        {
          opusId: "opus0003",
          opusName: "123445",
        },
        {
          opusId: "opus0004",
          opusName: "test",
        },
      ];
    },
    opusCreate() {
      let params = {
        opusId: "opus0004",
        opusName: this.createOpus.opusName,
      };
      // 作品追加処理
      console.log(params);

      // 再読み込み
      this.$router.go({ name: "graphList" });
    },
    /* モーダルウィンドウ処理 */
    
  },
};
</script>

<style>
</style>