<template>
  <div class="row">
    <aside class="col-12">
      <!-----------------------------------メニューバー--------------------------------------->
      <b-navbar toggleable type="dark" variant="dark">
        <b-navbar-brand> 相関図投稿画面 </b-navbar-brand>
        <b-navbar-brand>
          <b-dropdown right toggle-class="text-decoration-none" no-caret>
            <template #button-content>
              <font-awesome-icon icon="cog" />
            </template>
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
        <h4 class="card-title text-center mb-4 mt-1">投稿一覧</h4>
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
        <div>
          <b-card>
            <template #header>
              <div class="btn-group btn-group-lg">
                <button
                  class="btn btn-secondary"
                  @click="btnval = 1"
                  v-bind:class="{ active: btnval === 1 }"
                >
                  ユーザ名
                </button>
                <button
                  class="btn btn-secondary"
                  @click="btnval = 2"
                  v-bind:class="{ active: btnval === 2 }"
                >
                  作品名
                </button>
              </div>
            </template>

            <aside class="col-12" id="side_search">
              <b-form inline>
                <label class="mr-sm-2">検索</label>
                <b-form-input
                  class="mb-2 mr-sm-2 mb-sm-0"
                  placeholder="Search"
                  v-model="xname"
                ></b-form-input>
                <b-button variant="info" @click="initialize()">
                  <font-awesome-icon icon="search" />
                </b-button>
              </b-form>
            </aside>
          </b-card>
        </div>
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
            <tr
              v-for="(row, key) in opusSubmitList"
              :key="key"
              style="background-color: #ffa500"
            >
              <td>{{ row.user_name }}</td>
              <td>{{ row.opus_name }}</td>
              <td>
                <button
                  class="btn btn-info"
                  @click="createGraphApi(row.opus_id)"
                >
                  <font-awesome-icon icon="eye" />
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </article>
      <!-----------ページ切り替え-------------->

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
        <div class="btn-group" v-for="index in searchOpus.btnloop" :key="index">
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
    </aside>
    <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
    <!-----------モーダルウィンドウ-------------->
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
  </div>
</template>

<script>
import { ApiURL } from "../../constants/ApiURL.js";
//import { CommonUtils } from "../../common/CommonUtils.js";
import { VueFileName } from "../../constants/VueFileName.js";
import { Constant } from "../../constants/Constant.js";

export default {
  data() {
    return {
      opusSubmitList: [],
      works: [],
      successMsgList: [],
      dangerMsgList: [],
      searchOpus: {
        current: 1,
        offset: 0,
        limit: Constant.OPUS_LIST_MAX,
        btnloop: 0,
        min: 0,
        max: 0,
        addpage: 0,
      },
      btnval: 1,
      xname: "",
      graphList: VueFileName.graphList,
      graphCreate: VueFileName.graphCreate,
      login: VueFileName.login,
      /* モーダルウィンドウ変数 */
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

      // パラメータ作成
      let params = {
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
        offset: this.searchOpus.offset,
        limit: this.searchOpus.limit,
      };

      if (this.xname) {
        if (this.btnval == 1) {
          params.user_name = this.xname;
        } else {
          params.opus_name = this.xname;
        }
      }

      // 作品一覧取得
      this.$http
        .get(ApiURL.SEARCH_ALL_OPUS, { params: params })
        .then((response) => {
          // 成功
          this.opusSubmitList = response.data.optional;

          // 画面切り替えボタン表示数

          // パラメータ作成
          let initParams = {
            user_id: this.$store.getters.getUserId,
            token: this.$store.getters.getToken,
            offset: 0,
            limit: 9999,
          };

          if (this.xname) {
            if (this.btnval == 1) {
              initParams.user_name = this.xname;
            } else {
              initParams.opus_name = this.xname;
            }
          }

          // 作品数取得
          this.$http
            .get(ApiURL.SEARCH_ALL_OPUS, { params: initParams })
            .then((response) => {
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
      this.searchOpus.offset = (current - 1) * Constant.OPUS_LIST_MAX;

      // 作品画面反映処理
      this.initialize();
    },
    createGraphApi(opusId) {
      // 作品検索処理

      // パラメータ生成
      let params = {
        opus_id: opusId,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // 作品取得
      this.$http
        .get(ApiURL.SEARCH_OPUS, { params: params })
        .then((response) => {
          // 成功
          if (!response.data.optional.length) {
            this.$http
              .post(ApiURL.CREATE_GRAPH, params)
              .then((response) => {
                // 成功
                console.log(response);
                console.log(response.data.optional);
                // 画面変更
                this.$router.push({
                  path: this.graphCreate + "/" + response.data.optional.opus_id,
                });
              })
              .catch(() => {
                console.log("グラフ登録に失敗しました。");
              });
          } else {
            // 画面変更
            this.$router.push({
              path: this.graphCreate + "/" + opusId,
            });
          }
        })
        .catch(() => {
          console.log("作品取得に失敗しました。");
        });
    },
    /* モーダルウィンドウ処理 */
    /* ログアウト処理 */
    logout() {
      // ログアウト

      // パラメータ作成
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
        });
    },
  },
};
</script>

<style>
</style>
