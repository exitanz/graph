<template>
  <div class="row">
    <aside class="col-12">
      <!-----------------------------------メニューバー--------------------------------------->
      <b-navbar toggleable type="dark" variant="dark">
        <b-navbar-brand> 相関図投稿画面 </b-navbar-brand>
        <b-navbar-brand>
          <b-button variant="success" @click="isSubmitUploadModal = true"
            >投稿する
            <font-awesome-icon icon="upload" />
          </b-button>
          <b-dropdown right toggle-class="text-decoration-none" no-caret>
            <template #button-content>
              <font-awesome-icon icon="cog" />
            </template>
            <b-dropdown-item @click="isSubmitManageModal = true"
              >相関図管理</b-dropdown-item
            >
            <b-dropdown-item>
              <router-link v-bind:to="{ name: graphList }"
                >相関図一覧画面へ
              </router-link></b-dropdown-item
            >
            <b-dropdown-item variant="danger" @click="isLogoutCheckModal = true"
              >ログアウト</b-dropdown-item
            >
          </b-dropdown>
        </b-navbar-brand>
      </b-navbar>
    </aside>
    <!--------------------------相関図投稿画面-------------------------------->
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
            <tr v-for="(row, key) in submitList" :key="key">
              <td>{{ row.userName }}</td>
              <td>{{ row.workName }}</td>
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
      </article>
    </aside>
    <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
    <!-----------モーダルウィンドウ-------------->
    <!-----------投稿するボタン モーダルウィンドウ-------------->
    <b-modal v-model="isSubmitUploadModal" title="確認画面">
      <b-container fluid>
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
          @click="isSubmitUploadModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="primary"
          size="sm"
          class="float-right"
          @click="submitUpload()"
        >
          投稿する
        </b-button>
      </template>
    </b-modal>
    <!-----------投稿管理 モーダルウィンドウ-------------->
    <b-modal v-model="isSubmitManageModal" title="管理画面">
      <b-container fluid>
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
                  @click="isSubmitManageEditModal = true"
                >
                  <font-awesome-icon icon="pencil-alt" />
                </button>
              </td>
              <td>
                <button
                  type="button"
                  class="btn btn-danger"
                  @click="isSubmitManageDeleteModal = true"
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
      </b-container>

      <template #modal-footer>
        <b-button
          variant="secondary"
          size="sm"
          class="float-right"
          @click="isSubmitManageModal = false"
        >
          閉じる
        </b-button>
      </template>
    </b-modal>
    <!-----------編集 モーダル-------------->
    <b-modal v-model="isSubmitManageEditModal" title="編集画面">
      <b-container fluid>
        <b-row class="mb-1">
          <input type="hidden" v-model="submitManageEdit.opusId" />
          <input type="hidden" v-model="submitManageEdit.version" />
          <b-col cols="3">作品名</b-col>
          <b-col>
            <div class="input-group">
              <input
                class="form-control"
                placeholder="作品名を入力してください。"
                type="text"
                name="edit_submitManage_name"
                v-model="submitManageEdit.opusName"
                v-bind:class="[submitManageEdit.valid]"
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
          @click="isSubmitManageEditModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="primary"
          size="sm"
          class="float-right"
          @click="submitManageEdit()"
        >
          登録
        </b-button>
      </template>
    </b-modal>
    <!-----------削除 モーダル-------------->
    <b-modal v-model="isSubmitManageDeleteModal" title="確認画面">
      <b-container fluid>
        <p class="my-4">データを削除しますか？</p>
      </b-container>

      <template #modal-footer>
        <b-button
          variant="secondary"
          size="sm"
          class="float-right"
          @click="isSubmitManageDeleteModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="danger"
          size="sm"
          class="float-right"
          @click="submitManageDelete()"
        >
          削除
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
  </div>
</template>

<script>
//import { ApiURL } from "../../constants/ApiURL.js";
//import { CommonUtils } from "../../common/CommonUtils.js";
import { VueFaileName } from "../../constants/VueFaileName.js";

export default {
  data() {
    return {
      submitList: [],
      works: [],
      submitUpload: {
        version: 0,
        valid: "",
      },
      submitManage: {
        version: 0,
        valid: "",
      },
      submitManageEdit: {
        submitManageId: "",
        submitManageName: "",
        version: 0,
        valid: "",
      },
      logoutCheck: {
        version: 0,
        valid: "",
      },
      graphList: VueFaileName.graphList,
      graphCreate: VueFaileName.graphCreate,
      login: VueFaileName.login,
      /* モーダルウィンドウ変数 */
      isSubmitUploadModal: false,
      isSubmitManageModal: false,
      isSubmitManageEditModal: false,
      isSubmitManageDeleteModal: false,
      isLogoutCheckModal: false,
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
      this.submitList = [
        {
          userName: "user0001",
          workName: "あいうえお",
        },
        {
          userName: "user0002",
          workName: "abcdefg",
        },
        {
          userName: "user0003",
          workName: "123123123",
        },
        {
          userName: "user0004",
          workName: "testtest",
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
      this.submitList = [
        {
          userName: "user0001",
          workName: "あいうえお",
        },
        {
          userName: "user0002",
          workName: "abcdefg",
        },
        {
          userName: "user0003",
          workName: "123123123",
        },
        {
          userName: "user0004",
          workName: "testtest",
        },
      ];
    },
    userCreate() {
      let params = {
        userName: "user0004",
      };
      // 作品追加処理
      console.log(params);

      // 再読み込み
      this.$router.go({ name: "graphSubmit" });
    },
    /* モーダルウィンドウ処理 */
  },
};
</script>

<style>
</style>
