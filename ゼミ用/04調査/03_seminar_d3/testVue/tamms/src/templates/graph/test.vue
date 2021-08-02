<template>
  <div class="row">
    <!--------------------------相関図制作画面-------------------------------->
    <!----------------------メニュー欄----------------------------->
    <!-----------Actorモーダルウィンドウ-------------->
    <b-modal
      id="actor_modal"
      ref="modal"
      title="入力画面"
      @show="resetModal"
      @hidden="resetModal"
      @ok="handleOk"
    >
      <form ref="form" @submit.stop.prevent="handleSubmit">
        <div class="mt-3">名前</div>
        <b-form-input id="actor_name-input"></b-form-input>
        <div class="mt-3">時系列</div>
        <b-form-select v-model="selected" :options="options">
          <b-form-select-option>時系列１</b-form-select-option>
          <b-form-select-option>時系列２</b-form-select-option>
          <b-form-select-option>時系列３</b-form-select-option>
        </b-form-select>
        <div class="mt-3">グループ</div>
        <b-form-select v-model="selected" :options="options">
          <b-form-select-option>グループA</b-form-select-option>
          <b-form-select-option>グループB</b-form-select-option>
          <b-form-select-option>グループC</b-form-select-option>
        </b-form-select>
        <div class="mt-3">アイコン</div>
        <b-form-file v-model="file1" placeholder="ファイルを選択"></b-form-file>
        <div class="mt-3">詳細情報</div>
        <b-form-textarea
          id="actor_info"
          v-model="text"
          rows="3"
          max-rows="10"
        ></b-form-textarea>
      </form>
      <template #modal-footer="{ cancel, ok }">
        <b-button @click="cancel()"> Cancel </b-button>
        <b-button variant="primary" @click="ok()"> OK </b-button>
      </template>
    </b-modal>
    <!-----------Linkモーダルウィンドウ-------------->
    <b-modal
      id="link_modal"
      ref="modal"
      title="入力画面"
      @show="resetModal"
      @hidden="resetModal"
      @ok="handleOk"
    >
      <form ref="form" @submit.stop.prevent="handleSubmit">
        <div class="mt-3">関係性名</div>
        <b-form-input id="link_name_input"></b-form-input>
        <div class="mt-3">From</div>
        <b-form-select v-model="selected" :options="options">
          <b-form-select-option>A</b-form-select-option>
          <b-form-select-option>B</b-form-select-option>
          <b-form-select-option>C</b-form-select-option>
        </b-form-select>
        <div class="mt-3">to</div>
        <b-form-select v-model="selected" :options="options">
          <b-form-select-option>A</b-form-select-option>
          <b-form-select-option>B</b-form-select-option>
          <b-form-select-option>C</b-form-select-option>
        </b-form-select>
        <div class="mt-3">時系列</div>
        <b-form-select v-model="selected" :options="options">
          <b-form-select-option>時系列１</b-form-select-option>
          <b-form-select-option>時系列２</b-form-select-option>
          <b-form-select-option>時系列３</b-form-select-option>
        </b-form-select>
        <div class="mt-3">詳細情報</div>
        <b-form-textarea
          id="link_info"
          v-model="text"
          rows="3"
          max-rows="10"
        ></b-form-textarea>
      </form>
      <template #modal-footer="{ cancel, ok }">
        <b-button @click="cancel()"> Cancel </b-button>
        <b-button variant="primary" @click="ok()"> OK </b-button>
      </template>
    </b-modal>
    <!-----------アップロードモーダルウィンドウ-------------->
    <b-modal id="upload_modal" title="確認画面">
      <p class="my-4">相関図を投稿しますか？</p>
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
    <!-----------時系列名編集モーダルウィンドウ-------------->
    <b-modal
      id="time_modal"
      ref="modal"
      title="編集画面"
      @show="resetModal"
      @hidden="resetModal"
      @ok="handleOk"
    >
      <b-form inline>
        <div class="mt-3">時系列名</div>
        <b-form-input class="mb-2 mr-sm-2 mb-sm-0"></b-form-input>
        <b-button variant="info"> 追加 </b-button>
      </b-form>
      <br />
      <br />
      <table class="table">
        <thead class="thead-light">
          <tr>
            <th>時系列名</th>
            <th>編集</th>
            <th>削除</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(row, key) in times" :key="key">
            <td>{{ row.timesName }}</td>
            <td>
              <button
                type="button"
                class="btn btn-success"
                v-b-modal.edit_modal
              >
                <font-awesome-icon icon="pencil-alt" />
              </button>
            </td>
            <td>
              <button
                type="button"
                class="btn btn-danger"
                v-b-modal.delete_modal
              >
                <font-awesome-icon icon="times" />
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <template #modal-footer="{ cancel, ok }">
        <b-button @click="cancel()"> Cancel </b-button>
        <b-button variant="primary" @click="ok()"> OK </b-button>
      </template>
    </b-modal>
    <!-----------グループ名編集モーダルウィンドウ-------------->
    <b-modal
      id="group_modal"
      ref="modal"
      title="編集画面"
      @show="resetModal"
      @hidden="resetModal"
      @ok="handleOk"
    >
      <b-form inline>
        <div class="mt-3">グループ名</div>
        <b-form-input class="mb-2 mr-sm-2 mb-sm-0"></b-form-input>
        <b-button variant="info"> 追加 </b-button>
      </b-form>
      <br />
      <br />
      <table class="table">
        <thead class="thead-light">
          <tr>
            <th>グループ名</th>
            <th>編集</th>
            <th>削除</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(row, key) in group" :key="key">
            <td>{{ row.groupName }}</td>
            <td>
              <button
                type="button"
                class="btn btn-success"
                v-b-modal.edit_modal
              >
                <font-awesome-icon icon="pencil-alt" />
              </button>
            </td>
            <td>
              <button
                type="button"
                class="btn btn-danger"
                v-b-modal.delete_modal
              >
                <font-awesome-icon icon="times" />
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <template #modal-footer="{ cancel, ok }">
        <b-button @click="cancel()"> Cancel </b-button>
        <b-button variant="primary" @click="ok()"> OK </b-button>
      </template>
    </b-modal>
    <!-----------時系列・グループ編集モーダルウィンドウ-------------->
    <b-modal
      id="edit_modal"
      ref="modal"
      title="編集画面"
      @show="resetModal"
      @hidden="resetModal"
      @ok="handleOk"
    >
      <form ref="form" @submit.stop.prevent="handleSubmit">
        <div class="mt-3">名前</div>
        <b-form-input id="edit_name-input"></b-form-input>
      </form>
      <template #modal-footer="{ cancel, ok }">
        <b-button @click="cancel()"> Cancel </b-button>
        <b-button variant="primary" @click="ok()"> OK </b-button>
      </template>
    </b-modal>
    <!-----------時系列タブ-------------->
    <div>
      <b-tabs pills vertical nav-wrapper-class="w-40">
        <b-tab title="時系列１" active></b-tab>
        <b-tab title="時系列２"></b-tab>
        <b-tab title="時系列３"></b-tab>
      </b-tabs>
    </div>

    <aside class="col-sm-10 col-md-10 col-lg-8 col-xl-8">
      <div id="view"></div>
      <!-- カーソルを合わせたときに表示する情報領域-->
      <div id="datatip">
        <h2></h2>
        <p></p>
      </div>
      <!-----------アンダーメニュー-------------->
      <div class="card-group row">
        <div class="card col-8">
          <!-----------人物情報-------------->
          <div class="card-body" id="side_data">
            <div class="row">
              <aside
                class="col-sm-4 col-md-4 col-lg-2 col-xl-2"
                id="side_data_img"
              ></aside>
              <aside class="col-sm-8 col-md-8 col-lg-10 col-xl-10">
                <div class="row">
                  <aside class="col">
                    <h3>
                      <!-----------名前表示欄-------------->
                      <b-form-input v-model="text" disabled></b-form-input>
                    </h3>
                  </aside>
                  <aside class="col text-right">
                    <!-----------人物情報編集ボタン-------------->
                    <b-button v-b-modal="'actor_edit_modal'" variant="success"
                      >編集</b-button
                    ><!-----------人物情報編集モーダルウィンドウ-------------->
                    <b-modal
                      id="actor_edit_modal"
                      ref="modal"
                      title="編集画面"
                      @show="resetModal"
                      @hidden="resetModal"
                      @ok="handleOk"
                    >
                      <form ref="form" @submit.stop.prevent="handleSubmit">
                        <div class="mt-3">名前</div>
                        <b-form-input id="edit_name-input"></b-form-input>
                        <div class="mt-3">時系列</div>
                        <b-form-select v-model="selected">
                          <b-form-select-option>時系列１</b-form-select-option>
                          <b-form-select-option>時系列２</b-form-select-option>
                          <b-form-select-option>時系列３</b-form-select-option>
                        </b-form-select>
                        <div class="mt-3">グループ</div>
                        <b-form-select v-model="selected">
                          <b-form-select-option>グループA</b-form-select-option>
                          <b-form-select-option>グループB</b-form-select-option>
                          <b-form-select-option>グループC</b-form-select-option>
                        </b-form-select>
                        <div class="mt-3">アイコン</div>
                        <b-form-file
                          v-model="file1"
                          placeholder="ファイルを選択"
                        ></b-form-file>
                        <div class="mt-3">詳細情報</div>
                        <b-form-textarea
                          id="edit_info"
                          v-model="text"
                          rows="3"
                          max-rows="10"
                        ></b-form-textarea>
                      </form>
                      <template #modal-footer="{ cancel, ok }">
                        <b-button @click="cancel()"> Cancel </b-button>
                        <b-button variant="primary" @click="ok()">
                          OK
                        </b-button>
                      </template>
                    </b-modal>
                    <!-----------削除ボタン-------------->
                    <b-button variant="danger" v-b-modal.delete_modal
                      >削除</b-button
                    ><!-----------削除モーダルウィンドウ-------------->
                    <b-modal id="delete_modal" title="削除確認画面">
                      <p class="my-4">データを削除しますか？</p>
                      <template #modal-footer="{ cancel, ok }">
                        <b-button @click="cancel()"> Cancel </b-button>
                        <b-button variant="primary" @click="ok()">
                          OK
                        </b-button>
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
                  </aside>
                </div>
                <div class="row">
                  <aside class="col">
                    <!-----------詳細情報表示欄-------------->
                    <b-form-textarea
                      id="textarea"
                      v-model="text"
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
          <div class="card-body" id="side_bar">
            <div class="row h-50 w-100">
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
    </aside>
  </div>
</template>

<script type="module">
//import { ApiURL } from "../../constants/ApiURL.js";
//import { CommonUtils } from "../../common/CommonUtils.js";
import { VueFaileName } from "../../constants/VueFaileName.js";
import * as d3 from "d3";
// import { D3ServiceTest } from "../../scripts/D3ServiceTest.js";

//Jsonfileのデータを保持
// let jsondata;

// let sidedata = this.$d3.select("#side_data");

//カーソルを合わせたときに表示する情報領域
// let datatip = this.$d3.select("#datatip");

// const this.$d3 = require("this.$d3");

export default {
  data() {
    return {
      times: [],
      group: [],
      login: VueFaileName.login,
    };
  },
  methods: {
    createSvg() {
      const svg = d3
        .select("#view")
        .append("svg")
        .attr("width", 500)
        .attr("height", 400);
      svg
        .append("rect")
        .attr("x", 0)
        .attr("y", 0)
        .attr("width", 500)
        .attr("height", 400)
        .style("fill", "red");
    },
  },
  mounted() {
    this.createSvg();
  },
};
</script>

<style>
</style>
