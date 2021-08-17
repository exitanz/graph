<template>
  <div class="row">
    <aside class="col-sm-3 col-md-3 col-lg-3 col-xl-2">
      <!-----------時系列タブ-------------->
      <div class="card">
        <div class="card-body row">
          <button
            type="button"
            class="btn btn-outline-primary col-12"
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
      <vue-loading
        v-show="loading"
        type="spin"
        color="#333"
        :size="{ width: '50px', height: '50px' }"
      ></vue-loading>
      <div class="card" id="view" v-show="!loading"></div>
      <br />
      <!-- カーソルを合わせたときに表示する情報領域-->
      <div id="datatip">
        <h2></h2>
        <p></p>
      </div>
    </aside>
    <b-modal v-model="isActorCreateModal">
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
              <!-- <input
                  class="form-control"
                  placeholder="口座名を入力してください。"
                  type="text"
                  name="_name"
                  v-model="editWallet.walletName"
                  v-bind:class="[editWalletValid.walletNameValid]"
                /> -->
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
  </div>
</template>

<script type="module">
//import { ApiURL } from "../../constants/ApiURL.js";
//import { CommonUtils } from "../../common/CommonUtils.js";
// import { VueFaileName } from "../../constants/VueFaileName.js";
import { VueLoading } from "vue-loading-template";
import { D3Service } from "../../scripts/D3Service.js";

export default {
  data() {
    return {
      times: [],
      loading: false,
      currentId: 0,
      /* モーダルウィンドウ変数 */
      isActorCreateModal: false,
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
    clearSvg() {
      // 相関図クリア
      D3Service.clear();
    },
    /* モーダルウィンドウ処理 */
    actorCreate() {
      this.isActorCreateModal = false;
    },
  },
  components: {
    VueLoading,
  },
  // computed: {
  // },
  // mounted() {
  // },
  // beforeUpdate(){
  // },
  // updated() {
  // },
  // beforeDestroy() {
  // },
  // destroyed(){
  // }
};
</script>

<style>
@import "../../style/d3.css";
</style>
