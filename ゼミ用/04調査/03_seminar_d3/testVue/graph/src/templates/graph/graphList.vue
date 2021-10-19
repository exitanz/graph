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
          <div v-for="(val, key) in successMsgList" :key="key">
            <b-alert show variant="success">
              {{ val }}
            </b-alert>
          </div>
          <div v-for="(val, key) in dangerMsgList" :key="key">
            <b-alert show variant="danger">
              {{ val }}
            </b-alert>
          </div>
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
                v-bind:class="[createOpus.opusNameValid]"
                placeholder="作品名を入力してください。"
                type="text"
                name="edit_actor_name"
                v-model="createOpus.opusName"
              />
            </b-col>
            <b-col sm="2">
              <b-button variant="info" @click="createOpusApi()">
                追加
              </b-button>
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
              <td class="col-sm-1">{{ row.opus_name }}</td>
              <td>
                <button
                  type="button"
                  class="btn btn-success"
                  @click="
                    isEditOpusModalOpen(row.opus_id, row.opus_name, row.version)
                  "
                >
                  <font-awesome-icon icon="pencil-alt" />
                </button>
              </td>
              <td>
                <button
                  type="button"
                  class="btn btn-danger"
                  @click="isDeleteOpusModalOpen(row.opus_id, row.version)"
                >
                  <font-awesome-icon icon="times" />
                </button>
              </td>
              <td>
                <router-link
                  v-bind:to="{ path: graphCreate + '/' + row.opus_id }"
                >
                  <button type="button" class="btn btn-info">
                    <font-awesome-icon icon="eye" />
                  </button>
                </router-link>
              </td>
            </tr>
          </tbody>
        </table>
        <br />
        <article class="card-body">
          <div class="btn-group" v-for="index in searchOpus.max" :key="index">
            <button
              type="button"
              class="btn btn-secondary"
              v-bind:class="[
                index === searchOpus.current
                  ? 'btn-secondary active'
                  : 'btn-secondary',
              ]"
              @click="searchOpusApi(index)"
            >
              {{ index }}
            </button>
          </div>
        </article>
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
                <b-col sm="2">
                  <b-form-checkbox size="lg"></b-form-checkbox>
                </b-col>
              </td>
              <td class="col-sm-1">{{ row.opusName }}</td>
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
          @click="logout()"
        >
          ログアウト
        </b-button>
      </template>
    </b-modal>
    <!-----------編集 モーダル-------------->
    <b-modal v-model="isEditOpusModal" title="編集画面">
      <b-container fluid>
        <b-row class="mb-1">
          <input type="hidden" v-model="editOpus.opusId" />
          <input type="hidden" v-model="editOpus.version" />
          <b-col cols="3">作品名</b-col>
          <b-col>
            <div class="input-group">
              <input
                class="form-control"
                placeholder="作品名を入力してください。"
                type="text"
                name="edit_list_name"
                v-model="editOpus.opusName"
                v-bind:class="[editOpus.valid]"
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
          @click="isEditOpusModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="success"
          size="sm"
          class="float-right"
          @click="editOpusApi()"
        >
          更新
        </b-button>
      </template>
    </b-modal>
    <!-----------削除ボタン モーダル-------------->
    <b-modal v-model="isDeleteOpusModal" title="確認画面">
      <b-container fluid>
        <p class="my-4">データを削除しますか？</p>
      </b-container>

      <template #modal-footer>
        <b-button
          variant="secondary"
          size="sm"
          class="float-right"
          @click="isDeleteOpusModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="danger"
          size="sm"
          class="float-right"
          @click="deleteOpusApi()"
        >
          削除
        </b-button>
      </template>
    </b-modal>
  </div>
</template>

<script type="module">
import { ApiURL } from "../../constants/ApiURL.js";
import { CommonUtils } from "../../common/CommonUtils.js";
import { VueFileName } from "../../constants/VueFileName.js";
import { Constant } from "../../constants/Constant.js";

export default {
  data() {
    return {
      opusList: [],
      successMsgList: [],
      dangerMsgList: [],
      searchOpus: {
        current: 1,
        offset: 0,
        limit: Constant.OPUS_LIST_MAX,
        max: 0,
      },
      createOpus: {
        opusName: "",
        opusNameValid: "",
      },
      editOpus: {
        opusId: "",
        opusName: "",
        version: 0,
        valid: "",
      },
      deleteOpus: {
        opusId: "",
        version: 0,
        valid: "",
      },
      graphSubmit: VueFileName.graphSubmit,
      graphCreate: VueFileName.graphCreate,
      /* モーダルウィンドウ変数 */
      isUploadModal: false,
      isLogoutCheckModal: false,
      isListUploadModal: false,
      isEditOpusModal: false,
      isDeleteOpusModal: false,
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

      let params = {
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
        offset: this.searchOpus.offset,
        limit: this.searchOpus.limit,
      };

      // 作品一覧取得
      this.$http
        .get(ApiURL.SEARCH_OPUS, { params: params })
        .then((response) => {
          // 成功
          this.opusList = response.data.optional;

          // 画面切り替えボタン表示数
          let initParams = {
            user_id: this.$store.getters.getUserId,
            token: this.$store.getters.getToken,
          };

          // 作品数取得
          this.$http
            .get(ApiURL.SEARCH_OPUS, { params: initParams })
            .then((response) => {
              // 成功

              // 画面切り替えボタン表示数
              this.searchOpus.max =
                response.data.optional.length > Constant.OPUS_LIST_MAX
                  ? Math.floor(
                      (response.data.optional.length - 1) /
                        Constant.OPUS_LIST_MAX
                    )
                  : 1;
            })
            .catch((error) => {
              // 失敗
              this.dangerMsgList = error.response.data.msg;
            });
        })
        .catch((error) => {
          // 失敗
          this.dangerMsgList = error.response.data.msg;
        });
    },
    searchOpusApi(current) {
      // 作品検索処理
      this.searchOpus.current = current;
      this.searchOpus.offset = current * Constant.OPUS_LIST_MAX;
      this.searchOpus.limit = current + 1 * Constant.OPUS_LIST_MAX;

      // 作品画面反映処理
      this.initialize();
    },
    createOpusApi() {
      // 作品登録処理

      let params = {
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
        opus_name: this.createOpus.opusName,
      };

      // バリデーションチェック
      if (this.createOpusValidation(params)) {
        throw "バリデーションエラー";
      }

      // 作品登録
      this.$http
        .post(ApiURL.CREATE_OPUS, params)
        .then((response) => {
          // 成功

          // 作品画面反映処理
          this.initialize();

          // メッセージ更新
          this.successMsgList = ["作品登録しました。"];
        })
        .catch((error) => {
          // 失敗
          this.dangerMsgList = error.response.data.msg;
        });
    },
    editOpusApi() {
      // 作品更新処理

      let params = {
        opus_id: this.editOpus.opusId,
        opus_name: this.editOpus.opusName,
        version: this.editOpus.version,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // バリデーションチェック
      if (this.editOpusValidation(params)) {
        throw "バリデーションエラー";
      }

      // 作品更新
      this.$http
        .put(ApiURL.EDIT_OPUS, params)
        .then((response) => {
          // 成功

          // 作品画面反映処理
          this.initialize();

          // モーダルウィンドウ閉じる
          this.isEditOpusModal = false;

          // メッセージ更新
          this.successMsgList = ["作品更新しました。"];
        })
        .catch((error) => {
          // 失敗
          this.dangerMsgList = error.response.data.msg;
        });
    },
    deleteOpusApi() {
      // 作品削除処理

      let params = {
        opus_id: this.deleteOpus.opusId,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // バリデーションチェック
      if (this.deleteOpusValidation(params)) {
        throw "バリデーションエラー";
      }

      // 作品削除
      this.$http
        .post(ApiURL.DELETE_OPUS, params)
        .then((response) => {
          // 成功

          // 作品画面反映処理
          this.initialize();

          // モーダルウィンドウ閉じる
          this.isDeleteOpusModal = false;

          // メッセージ更新
          this.successMsgList = ["作品削除しました。"];
        })
        .catch((error) => {
          // 失敗
          this.dangerMsgList = error.response.data.msg;
        });
    },
    /* モーダルウィンドウ処理 */
    isEditOpusModalOpen(opusId, opusName, version) {
      // 作品編集モーダルウィンドウ

      // 初期化
      this.editOpus.opusId = opusId;
      this.editOpus.opusName = opusName;
      this.editOpus.version = version;

      // モーダルウィンドウ開く
      this.isEditOpusModal = true;
    },
    isDeleteOpusModalOpen(opusId, version) {
      // 作品削除モーダルウィンドウ

      // 初期化
      this.deleteOpus.opusId = opusId;
      this.deleteOpus.version = version;

      // モーダルウィンドウ開く
      this.isDeleteOpusModal = true;
    },
    /* バリデーション */
    createOpusValidation(params) {
      // 初期化
      let validationFlg = false;

      this.successMsgList = [];
      this.dangerMsgList = [];

      this.createOpus.opusNameValid = "";

      if (CommonUtils.eq(params.opus_name, "")) {
        this.dangerMsgList.push("作品名は必須項目です。");
        this.createOpus.opusNameValid = "is-invalid";
        validationFlg = true;
      }
      if (params.opus_name.length < 1 || 100 < params.opus_name.length) {
        this.dangerMsgList.push("作品名は1から100文字以内で入力してください。");
        this.createOpus.opusNameValid = "is-invalid";
        validationFlg = true;
      }
      return validationFlg;
    },
    editOpusValidation(params) {
      // 初期化
      let validationFlg = false;

      this.successMsgList = [];
      this.dangerMsgList = [];

      this.createOpus.opusNameValid = "";

      if (CommonUtils.eq(params.opus_id, "")) {
        this.dangerMsgList.push("作品IDは必須項目です。");
        this.userNameValid = "is-invalid";
        validationFlg = true;
      }
      if (params.opus_id.length != Constant.OPUS_ID_LENGTH) {
        this.dangerMsgList.push(
          "作品IDは" + Constant.OPUS_ID_LENGTH + "文字で入力してください。"
        );
        this.userNameValid = "is-invalid";
        validationFlg = true;
      }
      if (CommonUtils.eq(params.opus_name, "")) {
        this.dangerMsgList.push("作品名は必須項目です。");
        this.createOpus.opusNameValid = "is-invalid";
        validationFlg = true;
      }
      if (params.opus_name.length < 1 || 100 < params.opus_name.length) {
        this.dangerMsgList.push("作品名は1から100文字以内で入力してください。");
        this.createOpus.opusNameValid = "is-invalid";
        validationFlg = true;
      }
      return validationFlg;
    },
    deleteOpusValidation(params) {
      // 初期化
      let validationFlg = false;

      this.successMsgList = [];
      this.dangerMsgList = [];

      this.createOpus.opusNameValid = "";

      if (CommonUtils.eq(params.opus_id, "")) {
        this.dangerMsgList.push("作品IDは必須項目です。");
        this.userNameValid = "is-invalid";
        validationFlg = true;
      }
      if (params.opus_id.length != Constant.OPUS_ID_LENGTH) {
        this.dangerMsgList.push(
          "作品IDは" + Constant.OPUS_ID_LENGTH + "文字で入力してください。"
        );
        this.userNameValid = "is-invalid";
        validationFlg = true;
      }
      return validationFlg;
    },
    // ログアウト処理
    logout() {
      // ログアウト
      let params = {
        user_id: this.$store.getters.getUserId,
      };

      // ログアウト処理
      this.$http
        .get(ApiURL.LOGOUT, { params: params })
        .then((response) => {
          // 成功

          // 画面変更
          this.$router.push({
            name: VueFileName.login,
          });
        })
        .catch((error) => {
          // 失敗
          this.dangerMsgList = error.response.data.msg;
        });
    },
  },
};
</script>

<style>
</style>