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
          <b-button variant="success" @click="isLinkCreateModal = true"
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
            <b-dropdown-item @click="isTimeEditModal = true"
              >時系列名を編集</b-dropdown-item
            >
            <b-dropdown-item @click="isGroupEditModal = true"
              >グループ名を編集</b-dropdown-item
            >
          </b-dropdown>
          <b-dropdown right toggle-class="text-decoration-none" no-caret>
            <template #button-content>
              <font-awesome-icon icon="cog" />
            </template>
            <b-dropdown-item @click="isSubmitCheckModal = true"
              >投稿する</b-dropdown-item
            >
            <b-dropdown-item>
              <router-link v-bind:to="{ name: graphSubmit }"
                >相関図投稿画面へ
              </router-link></b-dropdown-item
            >
            <b-dropdown-item variant="danger" @click="isGraphDeleteModal = true"
              >相関図を削除</b-dropdown-item
            >
            <b-dropdown-item variant="danger" @click="isLogoutCheckModal = true"
              >ログアウト</b-dropdown-item
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

        <div class="content" @click="clickCell($event)" v-show="!loading">
          <d3-network
            :net-nodes="nodes"
            :net-links="links"
            :options="options"
            :node-cb="formatNode"
          >
          </d3-network>
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
                    <input id="acter_id" type="hidden" />
                    <aside class="col">
                      <h3>
                        <!-----------名前表示欄-------------->
                        <input id="acter_name" type="text" disabled />
                      </h3>
                    </aside>
                    <aside class="col text-right">
                      <!-----------人物情報編集ボタン-------------->
                      <b-button
                        variant="success"
                        @click="isActorEditModal = true"
                      >
                        編集
                      </b-button>
                      <!-----------削除ボタン-------------->
                      <b-button
                        variant="danger"
                        @click="isActorDeleteModal = true"
                      >
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
    <!-----------Actorボタン モーダル-------------->
    <b-modal v-model="isActorCreateModal" title="入力画面">
      <b-container fluid>
        <b-row class="mb-1">
          <b-col cols="3">名前</b-col>
          <b-col>
            <div class="input-group">
              <input
                class="form-control"
                placeholder="名前を入力してください。"
                type="text"
                name="create_actor_name"
                v-model="actorName"
                v-bind:class="[acterCreate.valid]"
              />
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">時系列</b-col>
          <b-col>
            <div class="input-group">
              <b-form-select v-model="selected" :options="options">
                <b-form-select-option>時系列１</b-form-select-option>
                <b-form-select-option>時系列２</b-form-select-option>
                <b-form-select-option>時系列３</b-form-select-option>
              </b-form-select>
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">グループ</b-col>
          <b-col>
            <div class="input-group">
              <select
                class="form-control"
                v-model="form.groupId"
                v-bind:class="[valid.groupIdValid]"
              >
                <option
                  v-for="(row, key) in items"
                  :key="key"
                  v-bind:value="row.groupId"
                >
                  {{ row.groupName }}
                </option>
              </select>
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">アイコン</b-col>
          <b-col>
            <div class="input-group">
              <b-form-file
                v-model="file1"
                placeholder="ファイルを選択"
              ></b-form-file>
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">詳細情報</b-col>
          <b-col>
            <div class="input-group">
              <b-form-textarea
                id="actor_info"
                v-model="text"
                rows="3"
                max-rows="10"
              ></b-form-textarea>
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
          登録
        </b-button>
      </template>
    </b-modal>
    <!-----------Linkボタン モーダル-------------->
    <b-modal v-model="isLinkCreateModal" title="入力画面">
      <b-container fluid>
        <b-row class="mb-1">
          <b-col cols="3">関係性名</b-col>
          <b-col>
            <div class="input-group">
              <input
                class="form-control"
                placeholder="関係を入力してください。"
                type="text"
                name="create_link_name"
                v-model="linkName"
                v-bind:class="[linkCreate.valid]"
              />
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">From</b-col>
          <b-col>
            <div class="input-group">
              <b-form-select v-model="selected" :options="options">
                <b-form-select-option>A</b-form-select-option>
                <b-form-select-option>B</b-form-select-option>
                <b-form-select-option>C</b-form-select-option>
              </b-form-select>
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">to</b-col>
          <b-col>
            <div class="input-group">
              <b-form-select v-model="selected" :options="options">
                <b-form-select-option>A</b-form-select-option>
                <b-form-select-option>B</b-form-select-option>
                <b-form-select-option>C</b-form-select-option>
              </b-form-select>
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">時系列</b-col>
          <b-col>
            <div class="input-group">
              <b-form-select v-model="selected" :options="options">
                <b-form-select-option>時系列１</b-form-select-option>
                <b-form-select-option>時系列２</b-form-select-option>
                <b-form-select-option>時系列３</b-form-select-option>
              </b-form-select>
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">詳細情報</b-col>
          <b-col>
            <div class="input-group">
              <b-form-textarea
                id="link_info"
                v-model="text"
                rows="3"
                max-rows="10"
              ></b-form-textarea>
            </div>
          </b-col>
        </b-row>
      </b-container>

      <template #modal-footer>
        <b-button
          variant="secondary"
          size="sm"
          class="float-right"
          @click="isLinkCreateModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="primary"
          size="sm"
          class="float-right"
          @click="linkCreate()"
        >
          登録
        </b-button>
      </template>
    </b-modal>

    <!-----------時系列名を編集 モーダル-------------->
    <b-modal v-model="isTimeEditModal" title="編集画面">
      <b-container fluid>
        <b-row class="mb-1">
          <input type="hidden" v-model="timeEdit.TimeId" />
          <input type="hidden" v-model="timeEdit.version" />
          <b-col cols="3">時系列名</b-col>
          <b-col>
            <div class="input-group">
              <input
                class="form-control"
                placeholder="時系列名を入力してください。"
                type="text"
                name="edit_time_name"
                v-model="timeEdit.timeName"
                v-bind:class="[timeEdit.valid]"
              />
              <b-button variant="info" @click="timeCreate()"> 追加 </b-button>
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <table class="table">
            <thead class="thead-light">
              <tr>
                <th>時系列名</th>
                <th>編集</th>
                <th>削除</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(row, key) in timeList" :key="key">
                <td>{{ row.timeName }}</td>
                <td>
                  <button
                    type="button"
                    class="btn btn-success"
                    @click="isTimeNameEditModal = true"
                  >
                    <font-awesome-icon icon="pencil-alt" />
                  </button>
                </td>
                <td>
                  <button
                    type="button"
                    class="btn btn-danger"
                    @click="isTimeDeleteModal = true"
                  >
                    <font-awesome-icon icon="times" />
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </b-row>
      </b-container>

      <template #modal-footer>
        <b-button
          variant="secondary"
          size="sm"
          class="float-right"
          @click="isTimeEditModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="primary"
          size="sm"
          class="float-right"
          @click="timeEdit()"
        >
          登録
        </b-button>
      </template>
    </b-modal>
    <!-----------編集 モーダル-------------->
    <b-modal v-model="isTimeNameEditModal" title="編集画面">
      <b-container fluid>
        <b-row class="mb-1">
          <input type="hidden" v-model="timeEdit.TimeId" />
          <input type="hidden" v-model="timeEdit.version" />
          <b-col cols="3">時系列名</b-col>
          <b-col>
            <div class="input-group">
              <input
                class="form-control"
                placeholder="時系列名を入力してください。"
                type="text"
                name="edit_time_name"
                v-model="timeEdit.timeName"
                v-bind:class="[timeEdit.valid]"
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
          @click="isTimeNameEditModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="primary"
          size="sm"
          class="float-right"
          @click="timeNameEdit()"
        >
          登録
        </b-button>
      </template>
    </b-modal>
    <!-----------削除 モーダル-------------->
    <b-modal v-model="isTimeDeleteModal" title="確認画面">
      <b-container fluid>
        <p class="my-4">時系列を削除しますか？</p>
      </b-container>

      <template #modal-footer>
        <b-button
          variant="secondary"
          size="sm"
          class="float-right"
          @click="isTimeDeleteModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="danger"
          size="sm"
          class="float-right"
          @click="timeDelete()"
        >
          削除
        </b-button>
      </template>
    </b-modal>

    <!-----------グループ名を編集 モーダル-------------->
    <b-modal v-model="isGroupEditModal" title="編集画面">
      <b-container fluid>
        <b-row class="mb-1">
          <input type="hidden" v-model="groupEdit.GroupId" />
          <input type="hidden" v-model="groupEdit.version" />
          <b-col cols="3">グループ名</b-col>
          <b-col>
            <div class="input-group">
              <input
                class="form-control"
                placeholder="グループ名を入力してください。"
                type="text"
                name="edit_group_name"
                v-model="groupEdit.groupName"
                v-bind:class="[groupEdit.valid]"
              />
              <b-button variant="info" @click="groupCreate()"> 追加 </b-button>
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <table class="table">
            <thead class="thead-light">
              <tr>
                <th>グループ名</th>
                <th>編集</th>
                <th>削除</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(row, key) in groupList" :key="key">
                <td>{{ row.groupName }}</td>
                <td>
                  <button
                    type="button"
                    class="btn btn-success"
                    @click="isGroupNameEditModal = true"
                  >
                    <font-awesome-icon icon="pencil-alt" />
                  </button>
                </td>
                <td>
                  <button
                    type="button"
                    class="btn btn-danger"
                    @click="isGroupDeleteModal = true"
                  >
                    <font-awesome-icon icon="times" />
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </b-row>
      </b-container>

      <template #modal-footer>
        <b-button
          variant="secondary"
          size="sm"
          class="float-right"
          @click="isGroupEditModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="primary"
          size="sm"
          class="float-right"
          @click="groupEdit()"
        >
          登録
        </b-button>
        <!-----------編集 モーダル-------------->
        <b-modal v-model="isGroupNameEditModal" title="編集画面">
          <b-container fluid>
            <b-row class="mb-1">
              <input type="hidden" v-model="groupEdit.GroupId" />
              <input type="hidden" v-model="groupEdit.version" />
              <b-col cols="3">グループ名</b-col>
              <b-col>
                <div class="input-group">
                  <input
                    class="form-control"
                    placeholder="グループ名を入力してください。"
                    type="text"
                    name="edit_group_name"
                    v-model="groupEdit.groupName"
                    v-bind:class="[groupEdit.valid]"
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
              @click="isGroupNameEditModal = false"
            >
              閉じる
            </b-button>
            <b-button
              variant="primary"
              size="sm"
              class="float-right"
              @click="groupNameEdit()"
            >
              登録
            </b-button>
          </template>
        </b-modal>
        <!-----------削除 モーダル-------------->
        <b-modal v-model="isGroupDeleteModal" title="確認画面">
          <b-container fluid>
            <p class="my-4">グループを削除しますか？</p>
          </b-container>

          <template #modal-footer>
            <b-button
              variant="secondary"
              size="sm"
              class="float-right"
              @click="isGroupDeleteModal = false"
            >
              閉じる
            </b-button>
            <b-button
              variant="danger"
              size="sm"
              class="float-right"
              @click="groupDelete()"
            >
              削除
            </b-button>
          </template>
        </b-modal>
      </template>
    </b-modal>
    <!-----------投稿するボタン モーダル-------------->
    <b-modal v-model="isSubmitCheckModal" title="確認画面">
      <b-container fluid>
        <p class="my-4">相関図が投稿されました。</p>
      </b-container>

      <template #modal-footer>
        <b-button
          variant="secondary"
          size="sm"
          class="float-right"
          @click="isSubmitCheckModal = false"
        >
          閉じる
        </b-button>
      </template>
    </b-modal>
    <!-----------相関図を削除 モーダル-------------->
    <b-modal v-model="isGraphDeleteModal" title="確認画面">
      <b-container fluid>
        <p class="my-4">相関図を削除しますか？</p>
      </b-container>

      <template #modal-footer>
        <b-button
          variant="secondary"
          size="sm"
          class="float-right"
          @click="isGraphDeleteModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="danger"
          size="sm"
          class="float-right"
          @click="graphDelete()"
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
    <!-----------Actor編集 モーダル-------------->
    <b-modal v-model="isActorEditModal" title="編集画面">
      <b-container fluid>
        <b-row class="mb-1">
          <input type="hidden" v-model="acterEdit.acterId" />
          <input type="hidden" v-model="acterEdit.version" />
          <b-col cols="3">名前</b-col>
          <b-col>
            <div class="input-group">
              <input
                class="form-control"
                placeholder="名前を入力してください。"
                type="text"
                name="edit_actor_name"
                v-model="acterEdit.actorName"
                v-bind:class="[acterEdit.valid]"
              />
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">時系列</b-col>
          <b-col>
            <div class="input-group">
              <b-form-select v-model="selected" :options="options">
                <b-form-select-option>時系列１</b-form-select-option>
                <b-form-select-option>時系列２</b-form-select-option>
                <b-form-select-option>時系列３</b-form-select-option>
              </b-form-select>
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">グループ</b-col>
          <b-col>
            <div class="input-group">
              <select
                class="form-control"
                v-model="form.groupId"
                v-bind:class="[valid.groupIdValid]"
              >
                <option
                  v-for="(row, key) in items"
                  :key="key"
                  v-bind:value="row.groupId"
                >
                  {{ row.groupName }}
                </option>
              </select>
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">アイコン</b-col>
          <b-col>
            <div class="input-group">
              <b-form-file
                v-model="file1"
                placeholder="ファイルを選択"
              ></b-form-file>
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">詳細情報</b-col>
          <b-col>
            <div class="input-group">
              <b-form-textarea
                id="actor_info"
                v-model="text"
                rows="3"
                max-rows="10"
              ></b-form-textarea>
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
          登録
        </b-button>
      </template>
    </b-modal>
    <!-----------Actor削除ボタン モーダル-------------->
    <b-modal v-model="isActorDeleteModal" title="確認画面">
      <b-container fluid>
        <p class="my-4">データを削除しますか？</p>
      </b-container>

      <template #modal-footer>
        <b-button
          variant="secondary"
          size="sm"
          class="float-right"
          @click="isActorDeleteModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="danger"
          size="sm"
          class="float-right"
          @click="actorDelete()"
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
import { VueFileName } from "../../constants/VueFileName.js";
import { VueLoading } from "vue-loading-template";
import { D3Service } from "../../scripts/D3Service.js";

export default {
  data() {
    return {
      timeList: [],
      createTime: {
        timeName: "",
      },
      groupList: [],
      createGroup: {
        groupName: "",
      },
      acterCreate: {
        acterId: "1",
        actorName: "2",
        acterInfo: "3",
        acterImg: "",
        valid: "",
      },
      linkCreate: {
        linkId: "1",
        linkName: "2",
        linkInfo: "3",
        valid: "",
      },
      timeEdit: {
        timeId: "",
        timeName: "",
        version: 0,
        valid: "",
      },
      timeNameEdit: {
        timeId: "",
        timeName: "",
        version: 0,
        valid: "",
      },
      timeDelete: {
        version: 0,
        valid: "",
      },
      groupEdit: {
        groupId: "",
        groupName: "",
        version: 0,
        valid: "",
      },
      groupNameEdit: {
        groupId: "",
        groupName: "",
        version: 0,
        valid: "",
      },
      groupDelete: {
        groupId: "",
        groupName: "",
        version: 0,
        valid: "",
      },
      submitCheck: {
        version: 0,
        valid: "",
      },
      graphEdit: {
        version: 0,
        valid: "",
      },
      logoutCheck: {
        version: 0,
        valid: "",
      },
      acterEdit: {
        acterId: "",
        actorName: "",
        acterInfo: "",
        acterImg: "",
        version: 0,
        valid: "",
      },
      actorDelete: {
        version: 0,
        valid: "",
      },
      form: {
        groupId: "",
      },
      valid: {
        groupIdValid: "",
      },
      items: [
        {
          groupId: "group01",
          groupName: "グループA1",
        },
        {
          groupId: "group02",
          groupName: "グループB2",
        },
        {
          groupId: "group03",
          groupName: "グループC3",
        },
      ],
      loading: false,
      currentId: 0,
      timeName: "",
      groupName: "",
      graphList: VueFileName.graphList,
      graphSubmit: VueFileName.graphSubmit,
      /* グラフ変数 */
      nodes: [],
      links: [],
      nodeSize: 40,
      canvas: false,
      force: 4000,
      /* モーダルウィンドウ変数 */
      isActorCreateModal: false,
      isLinkCreateModal: false,
      isSubmitCheckModal: false,
      isTimeEditModal: false,
      isTimeNameEditModal: false,
      isTimeDeleteModal: false,
      isGroupEditModal: false,
      isGroupNameEditModal: false,
      isGroupDeleteModal: false,
      isGraphDeleteModal: false,
      isLogoutCheckModal: false,
      isActorEditModal: false,
      isActorDeleteModal: false,
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
      this.timeList = [
        {
          timeId: "time0001",
          timeName: "あああ",
        },
        {
          timeId: "time0002",
          timeName: "aaaa",
        },
        {
          timeId: "time0003",
          timeName: "123445",
        },
        {
          timeId: "time0004",
          timeName: "test",
        },
      ];
      this.groupList = [
        {
          groupId: "groups0001",
          groupName: "あああ",
        },
        {
          groupId: "groups0002",
          groupName: "aaaa",
        },
        {
          groupId: "groups0003",
          groupName: "123445",
        },
        {
          groupId: "groups0004",
          groupName: "test",
        },
      ];

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

    /* テーブル */
    timeCreate() {
      let params = {
        timeId: "time0004",
        timeName: this.createTime.timeName,
      };
      // 追加処理
      console.log(params);
      // 再読み込み
      this.$router.go({ name: "timeList" });
    },
    groupCreate() {
      let params = {
        groupId: "group0004",
        groupName: this.createGroup.groupName,
      };
      // 追加処理
      console.log(params);
      // 再読み込み
      this.$router.go({ name: "groupList" });
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
      this.createEdit.acterId = document
        .getElementById("acter_id")
        .getAttribute("value");
      // モーダルウィンドウを閉じる
      this.isActorEditModal = false;
    },
    formatNode(node) {
      let svgAttrs = node._svgAttrs || {};
      if (!svgAttrs.id) svgAttrs.id = "node-" + node.id;
      node._svgAttrs = svgAttrs;
      return node;
    },
    clickCell(event) {
      let cell = event.target;
      this.nodes.push({ id: 11, name: "my awesome node 1" });
      console.log(cell);
      console.log(event.target);
    },
    // スクロール時のズーム処理
    handleScroll() {
      this.scrollY = window.scrollY;
      this.force = window.scrollY * 20 + 500;
      console.log(this.force);
    },
  },
  components: {
    D3Network,
    VueLoading,
  },
  computed: {
    options() {
      return {
        force: this.force,
        // size:{ w:600, h:600},
        linkWidth: 5,
        nodeSize: this.nodeSize,
        nodeLabels: true,
        linkLabels: true,
        canvas: this.canvas,
      };
    },
  },
  mounted() {
    window.addEventListener("scroll", this.handleScroll);
  },
};
</script>

<style>
@import "../../style/d3.css";
</style>
