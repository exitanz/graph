<template>
  <div class="row">
    <aside class="col-12">
      <!-----------------------------------メニューバー--------------------------------------->
      <b-navbar toggleable type="dark" variant="dark">
        <b-button variant="secondary" @click="returnBtn()">
          <font-awesome-icon icon="arrow-circle-left" />
        </b-button>
        <b-navbar-brand> 作品名A</b-navbar-brand>
        <b-navbar-brand>
          <b-button variant="info" @click="isActorCreateModal = true"
            >Actor<font-awesome-icon icon="user-plus" />
          </b-button>
          <b-button v-b-modal="'link_modal'" variant="success"
            >Link
            <font-awesome-icon icon="arrows-alt-h" />
          </b-button>
          <b-dropdown
            right
            toggle-class="text-decoration-none"
            variant="warning"
          >
            <template #button-content>
              Edit
              <font-awesome-icon icon="edit" />
            </template>
            <b-dropdown-item v-b-modal="'time_modal'"
              >時系列名編集</b-dropdown-item
            >
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
      </b-navbar>
    </aside>
    <aside class="col-sm-3 col-md-3 col-lg-3 col-xl-2">
      <!-----------時系列タブ-------------->
      <div class="card overflow-auto" id="timetab">
        <div class="row">
          <button
            type="button"
            class="btn btn-outline-primary col-12"
            style="height: 40px"
            v-for="(row, index) in times"
            :key="index"
            :disabled="loading"
            v-bind:class="{ active: currentId === index }"
            @click="isSelectSvg(row.json, index)"
          >
            {{ row.timeName }}
          </button>
        </div>
      </div>
    </aside>
    <aside class="col-sm-9 col-md-9 col-lg-9 col-xl-10">
      <div class="row">
        <!-----------ローディング画面-------------->
        <div class="card" id="view2" v-show="loading">
          <vue-loading
            v-show="loading"
            type="spin"
            color="#333"
            :size="{ width: '50px', height: '50px' }"
          ></vue-loading>
        </div>
        <!-----------相関図画面-------------->
        <div class="card" id="view" v-show="!loading">
          <!-- カーソルを合わせたときに表示する情報領域-->
          <div id="datatip">
            <h2></h2>
            <p></p>
          </div>
        </div>
        <br />

        <!-----------アンダーメニュー-------------->
        <div class="card-group row">
          <div class="card col-8">
            <!-----------人物情報-------------->
            <div class="card-body">
              <section id="side_data">
                <h2>Data</h2>
                <h3></h3>
                <iframe
                  id="data_memo"
                  seamless
                  height="300"
                  width="220"
                  sandbox="allow-same-origin"
                ></iframe>
                <iframe
                  id="data_relation"
                  seamless
                  height="140"
                  width="220"
                  sandbox="allow-same-origin"
                ></iframe>
              </section>
              <div class="row" id="side_data_form">
                <aside
                  class="col-sm-3 col-md-3 col-lg-3 col-xl-2"
                  id="side_img"
                ></aside>
                <aside class="col-sm-9 col-md-9 col-lg-9 col-xl-10">
                  <div class="row">
                    <input
                      id="acter_id"
                      type="hidden"
                    />
                    <aside class="col">
                      <h3>
                        <!-----------名前表示欄-------------->
                        <input
                          id="acter_name"
                          type="text"
                          disabled
                        />
                      </h3>
                    </aside>
                    <aside class="col text-right">
                      <!-----------人物情報編集ボタン-------------->
                      <b-button
                        v-b-modal="'actor_edit_modal'"
                        variant="success"
                        @click="isActorEditModal = true"
                      >
                        編集
                      </b-button>
                      <!-----------削除ボタン-------------->
                      <b-button variant="danger" v-b-modal.delete_modal>
                        削除
                      </b-button>
                    </aside>
                  </div>
                  <div class="row">
                    <aside class="col">
                      <!-----------詳細情報表示欄-------------->
                      <b-form-textarea
                        id="acter_info"
                        rows="3"
                        max-rows="6"
                        disabled
                      ></b-form-textarea>
                    </aside>
                  </div>
                </aside>
              </div>
            </div>
          </div>
          <!-----------検索-------------->
          <div class="card col-4">
            <div class="card-body">
              <div class="row h-50 w-100">
                <aside class="col-12">
                  <b-form inline>
                    <div class="input-group mb-2 mr-sm-2">
                      <b-form-input
                        placeholder="検索文字列を入力してください"
                      ></b-form-input>
                      <div class="input-group-prepend">
                        <button class="btn btn-outline-info">
                          <font-awesome-icon icon="search" />
                        </button>
                      </div>
                    </div>
                  </b-form>
                </aside>
                <!-----------検索タブ-------------->
                <aside class="col-12 p-3">
                  <b-tabs pills>
                    <b-tab title="人物名" active></b-tab>
                    <b-tab title="関係性名"></b-tab>
                    <b-tab title="グループ名"></b-tab>
                  </b-tabs>
                </aside>
              </div>
            </div>
          </div>
        </div>
      </div>
    </aside>

    <!-----------モーダルウィンドウ-------------->
    <b-modal v-model="isActorCreateModal">
      <!-----------アクター登録-------------->
      <b-container fluid>
        <b-row class="mb-1">
          <b-col cols="3">口座名</b-col>
          <b-col>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <font-awesome-icon icon="wallet" />
                </span>
              </div>
              <input
                class="form-control"
                placeholder="口座名を入力してください。"
                type="text"
                name="create_actor_name"
                v-model="actorName"
                v-bind:class="[createActer.valid]"
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
          @click="isActorCreateModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="primary"
          size="sm"
          class="float-right"
          @click="actorCreate()"
        >
          作成
        </b-button>
      </template>
    </b-modal>
    <b-modal v-model="isActorEditModal">
      <!-----------アクター編集-------------->
      <b-container fluid>
        <b-row class="mb-1">
          <input type="hidden" v-model="editActer.acterId" />
          <input type="hidden" v-model="editActer.version" />
          <b-col cols="3">アクター名</b-col>
          <b-col>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">
                  <font-awesome-icon icon="wallet" />
                </span>
              </div>
              <input
                class="form-control"
                placeholder="アクター名を入力してください。"
                type="text"
                name="edit_actor_name"
                v-model="editActer.actorName"
                v-bind:class="[editActer.valid]"
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
          @click="isActorEditModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="primary"
          size="sm"
          class="float-right"
          @click="actorEdit()"
        >
          作成
        </b-button>
      </template>
    </b-modal>
  </div>
</template>

<script type="module">
//import { ApiURL } from "../../constants/ApiURL.js";
//import { CommonUtils } from "../../common/CommonUtils.js";
import { VueFaileName } from "../../constants/VueFaileName.js";
import { VueLoading } from "vue-loading-template";
import { D3Service } from "../../scripts/D3Service.js";

export default {
  data() {
    return {
      createActer: {
        acterId: "1",
        actorName: "2",
        acterInfo: "3",
        acterImg: "",
        valid: "",
      },
      editActer: {
        acterId: "",
        actorName: "",
        acterInfo: "",
        acterImg: "",
        version: 0,
        valid: "",
      },
      times: [],
      loading: false,
      currentId: 0,
      graphList: VueFaileName.graphList,
      graphSubmit: VueFaileName.graphSubmit,
      /* モーダルウィンドウ変数 */
      isActorCreateModal: false,
      isActorEditModal: false,
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

      // 時系列順相関図json取得
      this.$http
        .get("/response/jsontmp.php")
        // .get("/project/test/d3/test01.php")
        .then((res) => {
          this.times = res.data;
          // 相関図作成
          this.createSvg(this.times[0].json);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    /* 相関図表示処理 */
    isSelectSvg(json, currentId) {
      // 画面変更
      try {
        if (this.loading) {
          throw "ローディング中に時系列の変更を検知した";
        }
        this.currentId = currentId;
        this.clearSvg();
        this.createSvg(json);
      } catch (e) {
        console.log(e);
        alert("ローディング中は時系列が変更できません");
      }
    },
    createSvg(json) {
      // 相関図作成
      this.loading = true; // ローディング表示
      D3Service.init(json); // 相関図作成処理

      // ローディング表示時間
      let stopTime = 4000;
      if (!!json && !!json.nodes && json.nodes.length > 0) {
        stopTime = json.nodes.length * 100;
      }

      setTimeout(() => {
        // ローディング非表示
        this.loading = false;
      }, stopTime);
    },
    loadSvg() {
      // 相関図更新

      // 相関図クリア
      this.clearSvg();

      // 時系列順相関図json取得
      this.$http
        .get("/response/jsontmp.php")
        // .get("/project/test/d3/test01.php")
        .then((res) => {
          this.times = res.data;
          // 相関図作成
          this.createSvg(this.times[this.currentId].json);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    clearSvg() {
      // 相関図クリア
      D3Service.clear();
    },
    returnBtn() {
      this.$router.go(-1);
    },
    /* モーダルウィンドウ処理 */
    actorCreate() {
      // アクター登録処理

      // 相関図再読み込み
      this.loadSvg();
      // モーダルウィンドウを閉じる
      this.isActorCreateModal = false;
    },
    actorEdit() {
      // アクター更新処理

      // 選択中のアクターID取得
      this.createEdit.acterId = document.getElementById('acter_id').getAttribute('value');
      // モーダルウィンドウを閉じる
      this.isActorEditModal = false;
    },
  },
  components: {
    VueLoading,
  },
};
</script>

<style>
@import "../../style/d3.css";
</style>
