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
              <b-tabs pills>
                <button
                  type="button"
                  class="col-12 p-3"
                  @click="btnval = 1"
                  v-bind:class="{ active: btnval === 1 }"
                >
                  ユーザ名
                </button>
                <button
                  type="button"
                  class="col-12 p-3"
                  @click="btnval = 2"
                  v-bind:class="{ active: btnval === 2 }"
                >
                  作品名
                </button>
              </b-tabs>
            </template>

            <aside class="col-12" id="side_search">
              <b-form inline>
                <label class="mr-sm-2">検索</label>
                <b-form-input
                  class="mb-2 mr-sm-2 mb-sm-0"
                  placeholder="Search"
                  v-model="xname"
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
            <tr v-for="(row, key) in opusSubmitList" :key="key">
              <td class="col-sm-2">{{ row.user_name }}</td>
              <td class="col-sm-2">{{ row.opus_name }}</td>
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
        <!-----------ページ切り替え-------------->
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
            <li class="page-item">
              <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
              <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav>
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
      opusList: [],
      opusSubmitList: [],
      works: [],
      successMsgList: [],
      dangerMsgList: [],
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
        offset: 0,
        limit: Constant.OPUS_LIST_MAX,
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
        })
        .catch((error) => {
          // 失敗
          this.dangerMsgList = error.response.data.msg;
        });
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
          this.dangerMsgList = error.response.data.msg;
        });
    },
  },
};
</script>

<style>
</style>
