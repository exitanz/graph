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
            <tr
              v-for="(row, key) in opusList"
              :key="key"
              v-bind:style="
                row.opus_flg == 1 ? 'background-color: #ffa500;' : ''
              "
            >
              <td>{{ row.opus_name }}</td>
              <td>
                <button
                  type="button"
                  class="btn btn-success"
                  @click="
                    isEditOpusModalOpen(
                      row.opus_id,
                      row.opus_name,
                      row.opus_flg,
                      row.version
                    )
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
          <div class="btn-group" v-if="searchOpus.min != 0">
            <button
              type="button"
              class="btn btn-secondary"
              v-bind:class="[
                searchOpus.min === searchOpus.current
                  ? 'btn-secondary active'
                  : 'btn-secondary',
              ]"
              @click="searchOpusApi(searchOpus.min)"
            >
              {{ searchOpus.min }}
            </button>
            　...
          </div>
          <div
            class="btn-group"
            v-for="index in searchOpus.btnloop"
            :key="index"
          >
            <button
              type="button"
              class="btn btn-secondary"
              v-bind:class="[
                index + searchOpus.addpage === searchOpus.current
                  ? 'btn-secondary active'
                  : 'btn-secondary',
              ]"
              @click="searchOpusApi(index + searchOpus.addpage)"
            >
              {{ index + searchOpus.addpage }}
            </button>
          </div>
          <div class="btn-group" v-if="searchOpus.max != 0">
            ...　
            <button
              type="button"
              class="btn btn-secondary"
              v-bind:class="[
                searchOpus.max === searchOpus.current
                  ? 'btn-secondary active'
                  : 'btn-secondary',
              ]"
              @click="searchOpusApi(searchOpus.max)"
            >
              {{ searchOpus.max }}
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
                <input
                  type="checkbox"
                  size="lg"
                  :value="row"
                  v-model="uploadList"
                />
              </td>
              <td>{{ row.opus_name }}</td>
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
          @click="uploadListApi()"
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
        <input type="hidden" v-model="editOpus.opusId" />
        <input type="hidden" v-model="editOpus.version" />
        <b-row class="mb-1">
          <b-col cols="3">作品名</b-col>
          <b-col>
            <div class="input-group">
              <input
                class="form-control"
                placeholder="作品名を入力してください。"
                type="text"
                name="edit_list_name"
                v-model="editOpus.opusName"
                v-bind:class="[editOpus.opusNameValid]"
              />
            </div>
          </b-col>
        </b-row>

        <b-row class="mb-1">
          <input type="hidden" v-model="editOpus.opusId" />
          <input type="hidden" v-model="editOpus.version" />
          <b-col cols="3">投稿状態</b-col>
          <b-col>
            <div class="input-group">
              <select
                v-model="editOpus.opusFlg"
                v-bind:class="[editOpus.opusFlgValid]"
              >
                <option value="1">投稿中</option>
                <option value="0">編集中</option>
              </select>
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
      uploadList: [],
      searchOpus: {
        current: 1,
        offset: 0,
        limit: Constant.OPUS_LIST_MAX,
        btnloop: 0,
        min: 0,
        max: 0,
        addpage: 0,
      },
      createOpus: {
        opusName: "",
        opusNameValid: "",
      },
      editOpus: {
        opusId: "",
        opusName: "",
        opusFlg: "",
        version: 0,
        opusNameValid: "",
        opusFlgValid: "",
      },
      deleteOpus: {
        opusId: "",
        version: 0,
        opusIdValid: "",
      },
      graphSubmit: VueFileName.graphSubmit,
      graphCreate: VueFileName.graphCreate,
      /* モーダルウィンドウ変数 */
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

      // パラメータ作成
      let params = {
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
        offset: this.searchOpus.offset,
        limit: this.searchOpus.limit,
      };

      // 作品一覧取得
      try {
        eel.SearchOpusControler({ params: params })((response) => {
          // 成功
          this.opusList = response.data.optional;

          // 画面切り替えボタン表示数

          // パラメータ作成
          let initParams = {
            user_id: this.$store.getters.getUserId,
            token: this.$store.getters.getToken,
            offset: 0,
            limit: 9999,
          };

          // 作品数取得
          try {
            eel.SearchOpusControler({ params: initParams })((response) => {
              // 成功

              // 画面切り替えボタン表示数
              this.searchOpus.addpage = 0;
              this.searchOpus.btnloop =
                response.data.optional.length > Constant.OPUS_LIST_MAX
                  ? Math.floor(
                      (response.data.optional.length - 1) /
                        Constant.OPUS_LIST_MAX
                    ) + 1
                  : 1;

              // nページ以上表示しない
              if (this.searchOpus.btnloop > Constant.OPUS_LIST_PAGE) {
                // 初期化
                // ボタン最大値
                this.searchOpus.max = 0;
                // ボタン最小値
                this.searchOpus.min = 0;

                if (
                  this.searchOpus.btnloop <
                  this.searchOpus.current + Constant.OPUS_LIST_PAGE
                ) {
                  // ページ開始位置
                  this.searchOpus.addpage =
                    this.searchOpus.btnloop - Constant.OPUS_LIST_PAGE - 1;
                  // ループ回数
                  this.searchOpus.btnloop = Constant.OPUS_LIST_PAGE + 1;
                } else {
                  // ボタン最大値
                  this.searchOpus.max = this.searchOpus.btnloop;
                  // ページ開始位置
                  this.searchOpus.addpage = this.searchOpus.current - 1;
                  // ループ回数
                  this.searchOpus.btnloop = Constant.OPUS_LIST_PAGE;
                }

                if (this.searchOpus.current != 1) {
                  // ボタン最小値
                  this.searchOpus.min = 1;
                }
              }
            });
          } catch (error) {
            // 失敗
            this.dangerMsgList = error.response.data.msg;
          }
        });
      } catch (error) {
        // 失敗
        this.dangerMsgList = error.response.data.msg;
      }
    },

    async uploadListApi() {
      // 作品投稿処理

      for (let row of this.uploadList) {
        // パラメータ作成
        let params = {
          opus_id: row.opus_id,
          opus_flg: 1,
          version: row.version,
          user_id: this.$store.getters.getUserId,
          token: this.$store.getters.getToken,
        };

        // 作品更新
        try {
          await eel.EditOpusControler(params)((response) => {
            // 成功
          });
        } catch (error) {
          // 失敗
          this.dangerMsgList = error.response.data.msg;
        }
      }

      // メッセージ更新
      this.successMsgList = ["作品を投稿しました。"];

      // 作品画面反映処理
      this.initialize();

      // モーダルウィンドウ閉じる
      this.isListUploadModal = false;
    },
    searchOpusApi(current) {
      // 作品検索処理
      this.searchOpus.current = current;
      this.searchOpus.offset = (current - 1) * Constant.OPUS_LIST_MAX;

      // 作品画面反映処理
      this.initialize();
    },
    createOpusApi() {
      // 作品登録処理

      // パラメータ作成
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
      try {
        eel.CreateOpusControler(params)((response) => {
          // 成功

          // 作品画面反映処理
          this.initialize();

          // メッセージ更新
          this.successMsgList = ["作品を登録しました。"];
        });
      } catch (error) {
        // 失敗
        this.dangerMsgList = error.response.data.msg;
      }
    },

    editOpusApi() {
      // 作品更新処理

      // パラメータ作成
      let params = {
        opus_id: this.editOpus.opusId,
        opus_name: this.editOpus.opusName,
        opus_flg: this.editOpus.opusFlg,
        version: this.editOpus.version,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // バリデーションチェック
      if (this.editOpusValidation(params)) {
        throw "バリデーションエラー";
      }

      // 作品更新
      try {
        eel.EditOpusControler(params)((response) => {
          // 成功

          // 作品画面反映処理
          this.initialize();

          // モーダルウィンドウ閉じる
          this.isEditOpusModal = false;

          // メッセージ更新
          this.successMsgList = ["作品を更新しました。"];
        });
      } catch (error) {
        // 失敗
        this.dangerMsgList = error.response.data.msg;
      }
    },

    deleteOpusApi() {
      // 作品削除処理

      // パラメータ作成
      let params = {
        opus_id: this.deleteOpus.opusId,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // 作品削除
      try {
        eel.EditOpusControler(params)((response) => {
          // 成功

          // 作品画面反映処理
          this.initialize();

          // モーダルウィンドウ閉じる
          this.isDeleteOpusModal = false;

          // メッセージ更新
          this.successMsgList = ["作品を削除しました。"];
        });
      } catch (error) {
        // 失敗
        this.dangerMsgList = error.response.data.msg;
      }
    },

    /* モーダルウィンドウ処理 */
    isEditOpusModalOpen(opusId, opusName, opusFlg, version) {
      // 作品編集モーダルウィンドウ

      // 初期化
      this.editOpus.opusId = opusId;
      this.editOpus.opusName = opusName;
      this.editOpus.opusFlg = opusFlg;
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

      this.editOpus.opusNameValid = "";

      if (CommonUtils.eq(params.opus_name, "")) {
        this.dangerMsgList.push("作品名は必須項目です。");
        this.editOpus.opusNameValid = "is-invalid";
        validationFlg = true;
      }
      if (params.opus_name.length < 1 || 100 < params.opus_name.length) {
        this.dangerMsgList.push("作品名は1から100文字以内で入力してください。");
        this.editOpus.opusNameValid = "is-invalid";
        validationFlg = true;
      }
      return validationFlg;
    },
    /* ログアウト処理 */
    logout() {
      // ログアウト

      // パラメータ作成
      let params = {
        user_id: this.$store.getters.getUserId,
      };

      // ログアウト処理
      try {
        eel.LogoutControler({ params: params })((response) => {
          // 成功

          // 画面変更
          this.$router.push({
            name: VueFileName.login,
          });
        });
      } catch (error) {
        // 失敗
        this.dangerMsgList = error.response.data.msg;
      }
    },
  },
};
</script>

<style>
</style>