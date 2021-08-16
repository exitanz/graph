<template>
  <div class="row">
    <aside class="col-sm-2 col-md-2 col-lg-2 col-xl-2">
      <!-----------時系列タブ-------------->
      <b-card no-body>
        <b-tabs pills card vertical>
          <!-- v-bind:class="{ active: currentId === index }" -->
          <b-tab
            v-for="(row, index) in times"
            :key="index"
            v-bind:title="row.timeName"
            @click="isSelectSvg(row.json)"
          >
          </b-tab>
        </b-tabs>
        <!-- <b-button @click="createSvg()"> test </b-button> -->
        {{ currentId }}
      </b-card>
    </aside>
    <aside class="col-sm-10 col-md-10 col-lg-10 col-xl-10">
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
      let json = {};

      // 相関図json取得
      this.$http
        .get("/response/jsontmp.php")
        // .get("/project/test/d3/test01.php")
        .then((res) => {
          json = res.data;

          this.times = [
            {
              timeId: "1",
              timeName: "時系列A",
              version: 0,
              json: json,
            },
            {
              timeId: "2",
              timeName: "時系列2",
              version: 0,
              json: json,
            },
            {
              timeId: "3",
              timeName: "時系列B",
              version: 0,
              json: json,
            },
          ];

          this.createSvg(this.times[0].json);
        })
        .catch((error) => {
          console.log(error);
        });
      // this.times = ["時系列1", "時系列2", "時系列3"];
    },
    /* 相関図表示処理 */
    isSelectSvg(json) {
      // 画面変更
      this.clearSvg();
      this.createSvg(json);
    },
    createSvg(json) {
      // 相関図作成
      this.loading = true;
      D3Service.init(json);
      this.loading = false;
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
