<template>
  <div class="row">
    <!-----------------------------------メニューバー--------------------------------------->
    <b-navbar class="col-12" toggleable type="dark" variant="dark">
      <b-button variant="secondary" @click="returnBtn()">
        <font-awesome-icon icon="arrow-circle-left" />
      </b-button>
      <b-navbar-brand> {{ opusInfo.opusName }}</b-navbar-brand>
      <b-navbar-brand>
        <b-button variant="info" @click="isCreateActorModalOpen()"
          >Actor<font-awesome-icon icon="user-plus" />
        </b-button>
        <b-button variant="success" @click="isCreateRelModalOpen()"
          >Link
          <font-awesome-icon icon="arrows-alt-h" />
        </b-button>
        <b-dropdown right toggle-class="text-decoration-none" variant="warning">
          <template #button-content>
            others
            <font-awesome-icon icon="edit" />
          </template>
          <b-dropdown-item @click="isTimeModal = true"
            >時系列管理</b-dropdown-item
          >
          <b-dropdown-item @click="isGroupModal = true"
            >グループ管理</b-dropdown-item
          >
          <b-dropdown-item @click="isRelMstModal = true">
            関係性管理
          </b-dropdown-item>
        </b-dropdown>
        <b-dropdown right toggle-class="text-decoration-none" no-caret>
          <template #button-content>
            <font-awesome-icon icon="cog" />
          </template>
          <b-dropdown-item @click="editOpusApi()">投稿する</b-dropdown-item>
          <b-dropdown-item>
            <router-link v-bind:to="{ name: graphSubmit }"
              >相関図投稿画面へ
            </router-link>
          </b-dropdown-item>
          <b-dropdown-item variant="danger" @click="isGraphDeleteModal = true"
            >相関図を削除</b-dropdown-item
          >
        </b-dropdown>
      </b-navbar-brand>
    </b-navbar>
    <aside class="col-12">
      <div class="row">
        <!-----------時系列タブ-------------->
        <div class="card overflow-auto col-2" id="timetab">
          <div class="row">
            <button
              type="button"
              class="btn btn-outline-primary col-12"
              style="height: 40px"
              v-for="(row, key) in timeList"
              :key="key"
              :disabled="loading"
              v-bind:class="{ active: currentId === row.time_id }"
              @click="isSelectSvg(row.time_id)"
            >
              {{ row.time_name }}
            </button>
          </div>
        </div>

        <!-----------ローディング画面-------------->
        <div class="card col-10" v-show="loading">
          <vue-loading
            v-show="loading"
            type="spin"
            color="#333"
            :size="{ width: '50px', height: '50px' }"
          ></vue-loading>
        </div>
        <!-----------相関図画面-------------->
        <div class="card col-10" @click="clickCell($event)">
          <d3-network
            :net-nodes="nodes"
            :net-links="links"
            :options="options"
            :node-cb="formatNode"
          >
          </d3-network>
        </div>
      </div>
    </aside>
    <aside class="col-12">
      <!-----------アンダーメニュー-------------->
      <div class="card-group row">
        <div class="card col-6">
          <!-----------人物情報-------------->
          <div class="card-body">
            <div class="row">
              <aside
                class="col-sm-3 col-md-3 col-lg-3 col-xl-2"
                v-bind:style="{
                  backgroundImage: 'url(' + currentInfo.currentImg + ')',
                  backgroundSize: '100% auto',
                  backgroundRepeat: 'no-repeat',
                }"
              ></aside>
              <aside class="col-sm-9 col-md-9 col-lg-9 col-xl-10">
                <div class="row">
                  <input type="hidden" />
                  <aside class="col-8">
                    <!-----------名前表示欄-------------->
                    <input
                      type="text"
                      class="form-control"
                      v-model="currentInfo.currentName"
                      disabled
                    />
                  </aside>
                  <aside class="col-4 text-right">
                    <!-----------人物情報編集ボタン-------------->
                    <b-button
                      variant="success"
                      @click="isEditActorOrLinkModalOpen()"
                    >
                      編集
                    </b-button>
                    <!-----------削除ボタン-------------->
                    <b-button
                      variant="danger"
                      @click="isDeleteActorOrLinkModalOpen()"
                    >
                      削除
                    </b-button>
                  </aside>
                </div>
                <div class="row">
                  <aside class="col">
                    <!-----------詳細情報表示欄-------------->
                    <b-form-textarea
                      rows="3"
                      max-rows="6"
                      v-model="currentInfo.currentInfo"
                      disabled
                    ></b-form-textarea>
                  </aside>
                </div>
              </aside>
            </div>
          </div>
        </div>
        <!-----------検索-------------->
        <div class="card col-6">
          <div class="card-body">
            <div class="row">
              <aside class="col-12">
                <div class="input-group mb-2 mr-sm-2" inline>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="検索文字列を入力してください"
                    v-model="currentSearchText"
                  />
                  <div class="input-group-prepend">
                    <button class="btn btn-outline-info" @click="searchGraph()">
                      <font-awesome-icon icon="search" />
                    </button>
                  </div>
                </div>
              </aside>
              <!-----------検索タブ-------------->
              <aside class="col-12 p-3">
                <div class="btn-group">
                  <button
                    type="button"
                    class="btn btn-secondary"
                    v-bind:class="[
                      currentSearchBtn === 1
                        ? 'btn-secondary active'
                        : 'btn-secondary',
                    ]"
                    @click="currentSearchBtn = 1"
                  >
                    人物名
                  </button>
                  <button
                    type="button"
                    class="btn btn-secondary"
                    v-bind:class="[
                      currentSearchBtn === 3
                        ? 'btn-secondary active'
                        : 'btn-secondary',
                    ]"
                    @click="currentSearchBtn = 3"
                  >
                    関係名
                  </button>
                  <button
                    type="button"
                    class="btn btn-secondary"
                    v-bind:class="[
                      currentSearchBtn === 2
                        ? 'btn-secondary active'
                        : 'btn-secondary',
                    ]"
                    @click="currentSearchBtn = 2"
                  >
                    グループ名
                  </button>
                </div>
              </aside>
              <!-----------ズームタブ-------------->
              <aside class="col-12 p-3">
                <input type="range" max="50000" min="2000" v-model="force" />
              </aside>
            </div>
          </div>
        </div>
      </div>
    </aside>
    <!-----------モーダルウィンドウ-------------->
    <!-----------Actorボタン モーダル-------------->
    <b-modal v-model="isCreateActorModal" title="入力画面">
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
                v-model="createActor.actorName"
                v-bind:class="[createActor.actorNameValid]"
              />
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">時系列</b-col>
          <b-col>
            <div class="input-group">
              {{ currentName }}
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">グループ</b-col>
          <b-col>
            <div class="input-group">
              <select
                class="form-control"
                v-model="createActor.groupId"
                v-bind:class="[createActor.groupIdValid]"
              >
                <option :value="null" disabled>
                  グループを選択してください。
                </option>
                <option
                  v-for="(row, key) in groupList"
                  :key="key"
                  v-bind:value="row.group_id"
                >
                  {{ row.group_name }}
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
                v-on:change="createActorFile"
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
                v-model="createActor.actorInfo"
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
          @click="isCreateActorModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="primary"
          size="sm"
          class="float-right"
          @click="createActorApi()"
        >
          登録
        </b-button>
      </template>
    </b-modal>
    <!-----------Actor編集 モーダル-------------->
    <b-modal v-model="isEditActorModal" title="編集画面">
      <b-container fluid>
        <b-row class="mb-1">
          <input type="hidden" v-model="editActor.actorId" />
          <input type="hidden" v-model="editActor.version" />
          <b-col cols="3">名前</b-col>
          <b-col>
            <div class="input-group">
              <input
                class="form-control"
                placeholder="名前を入力してください。"
                type="text"
                name="edit_actor_name"
                v-model="editActor.actorName"
                v-bind:class="[editActor.valid]"
              />
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">時系列</b-col>
          <b-col>
            <div class="input-group">
              {{ currentName }}
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">グループ</b-col>
          <b-col>
            <div class="input-group">
              <select
                class="form-control"
                v-model="editActor.groupId"
                v-bind:class="[editActor.valid]"
              >
                <option :value="null" disabled>
                  グループを選択してください。
                </option>
                <option
                  v-for="(row, key) in groupList"
                  :key="key"
                  v-bind:value="row.group_id"
                >
                  {{ row.group_name }}
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
                v-model="editActor.actorImg"
                v-on:change="editActorFile"
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
                v-model="editActor.actorInfo"
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
          @click="isEditActorModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="success"
          size="sm"
          class="float-right"
          @click="editActorApi()"
        >
          更新
        </b-button>
      </template>
    </b-modal>
    <!-----------Actor削除ボタン モーダル-------------->
    <b-modal v-model="isDeleteActorModal" title="確認画面">
      <b-container fluid>
        <p class="my-4">データを削除しますか？</p>
      </b-container>

      <template #modal-footer>
        <b-button
          variant="secondary"
          size="sm"
          class="float-right"
          @click="isDeleteActorModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="danger"
          size="sm"
          class="float-right"
          @click="deleteActorApi()"
        >
          削除
        </b-button>
      </template>
    </b-modal>

    <!-----------Linkボタン モーダル-------------->
    <b-modal v-model="isCreateRelModal" title="入力画面">
      <b-container fluid>
        <b-row class="mb-1">
          <b-col cols="3">関係性</b-col>
          <b-col>
            <div class="input-group">
              <select
                class="form-control"
                v-model="createRel.relMstId"
                v-bind:class="[createRel.relMstIdValid]"
              >
                <option :value="null" disabled>
                  関係性を選択してください。
                </option>
                <option
                  v-for="(row, key) in relMstList"
                  :key="key"
                  v-bind:value="row.rel_mst_id"
                >
                  {{ row.rel_mst_name }}
                </option>
              </select>
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">From</b-col>
          <b-col>
            <div class="input-group">
              <select
                class="form-control"
                v-model="createRel.actorId"
                v-bind:class="[createRel.actorIdValid]"
              >
                <option :value="null" disabled>
                  登場人物を選択してください。
                </option>
                <option
                  v-for="(row, key) in actorList"
                  :key="key"
                  v-bind:value="row.actor_id"
                >
                  {{ row.actor_name }}
                </option>
              </select>
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">to</b-col>
          <b-col>
            <div class="input-group">
              <select
                class="form-control"
                v-model="createRel.targetId"
                v-bind:class="[createRel.targetIdvalid]"
              >
                <option :value="null" disabled>
                  登場人物を選択してください。
                </option>
                <option
                  v-for="(row, key) in actorList"
                  :key="key"
                  v-bind:value="row.actor_id"
                >
                  {{ row.actor_name }}
                </option>
              </select>
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">時系列</b-col>
          <b-col>
            <div class="input-group">
              {{ currentName }}
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">詳細情報</b-col>
          <b-col>
            <div class="input-group">
              <b-form-textarea
                id="link_info"
                v-model="createRel.relInfo"
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
          @click="isCreateRelModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="primary"
          size="sm"
          class="float-right"
          @click="createRelApi()"
        >
          登録
        </b-button>
      </template>
    </b-modal>
    <!-----------Link編集 モーダル-------------->
    <b-modal v-model="isEditRelModal" title="編集画面">
      <b-container fluid>
        <b-row class="mb-1">
          <b-col cols="3">関係性</b-col>
          <b-col>
            <div class="input-group">
              <select
                class="form-control"
                v-model="editRel.relMstId"
                v-bind:class="[editRel.relMstIdValid]"
              >
                <option :value="null" disabled>
                  関係性を選択してください。
                </option>
                <option
                  v-for="(row, key) in relMstList"
                  :key="key"
                  v-bind:value="row.rel_mst_id"
                >
                  {{ row.rel_mst_name }}
                </option>
              </select>
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">From</b-col>
          <b-col>
            <div class="input-group">
              <select
                class="form-control"
                v-model="editRel.actorId"
                v-bind:class="[editRel.actorIdValid]"
              >
                <option :value="null" disabled>
                  登場人物を選択してください。
                </option>
                <option
                  v-for="(row, key) in actorList"
                  :key="key"
                  v-bind:value="row.actor_id"
                >
                  {{ row.actor_name }}
                </option>
              </select>
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">to</b-col>
          <b-col>
            <div class="input-group">
              <select
                class="form-control"
                v-model="editRel.targetId"
                v-bind:class="[editRel.targetIdvalid]"
              >
                <option :value="null" disabled>
                  登場人物を選択してください。
                </option>
                <option
                  v-for="(row, key) in actorList"
                  :key="key"
                  v-bind:value="row.actor_id"
                >
                  {{ row.actor_name }}
                </option>
              </select>
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">時系列</b-col>
          <b-col>
            <div class="input-group">
              {{ currentName }}
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">詳細情報</b-col>
          <b-col>
            <div class="input-group">
              <b-form-textarea
                id="link_info"
                v-model="editRel.relInfo"
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
          @click="isEditRelModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="success"
          size="sm"
          class="float-right"
          @click="editRelApi()"
        >
          更新
        </b-button>
      </template>
    </b-modal>
    <!-----------Link削除ボタン モーダル-------------->
    <b-modal v-model="isDeleteRelModal" title="確認画面">
      <b-container fluid>
        <p class="my-4">データを削除しますか？</p>
      </b-container>

      <template #modal-footer>
        <b-button
          variant="secondary"
          size="sm"
          class="float-right"
          @click="isDeleteRelModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="danger"
          size="sm"
          class="float-right"
          @click="deleteRelApi()"
        >
          削除
        </b-button>
      </template>
    </b-modal>

    <!-----------関係性編集 モーダル-------------->
    <b-modal v-model="isRelMstModal" title="編集画面">
      <b-container fluid>
        <b-row class="mb-1">
          <input type="hidden" v-model="editRelMst.relMstId" />
          <input type="hidden" v-model="editRelMst.version" />
          <b-col cols="3">関係性名</b-col>
          <b-col>
            <div class="input-group">
              <input
                class="form-control"
                placeholder="関係性名を入力してください。"
                type="text"
                name="edit_rel_mst_name"
                v-model="createRelMst.relMstName"
                v-bind:class="[createRelMst.valid]"
              />
              <b-button variant="info" @click="createRelMstApi()">
                追加
              </b-button>
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <table class="table">
            <thead class="thead-light">
              <tr>
                <th>関係性名</th>
                <th>編集</th>
                <th>削除</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(row, key) in relMstList" :key="key">
                <td>{{ row.rel_mst_name }}</td>
                <td>
                  <button
                    type="button"
                    class="btn btn-success"
                    @click="
                      isEditRelMstModalOpen(
                        row.rel_mst_id,
                        row.rel_mst_name,
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
                    @click="isDeleteRelMstModalOpen(row.rel_mst_id)"
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
          @click="isRelMstModal = false"
        >
          閉じる
        </b-button>
      </template>
    </b-modal>
    <!-----------編集 モーダル-------------->
    <b-modal v-model="isEditRelMstModal" title="編集画面">
      <b-container fluid>
        <b-row class="mb-1">
          <input type="hidden" v-model="editRelMst.relMstId" />
          <input type="hidden" v-model="editRelMst.version" />
          <b-col cols="3">関係性名</b-col>
          <b-col>
            <div class="input-group">
              <input
                class="form-control"
                placeholder="関係性名を入力してください。"
                type="text"
                name="edit_rel_mst_name"
                v-model="editRelMst.relMstName"
                v-bind:class="[editRelMst.valid]"
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
          @click="isEditRelMstModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="success"
          size="sm"
          class="float-right"
          @click="editRelMstApi()"
        >
          更新
        </b-button>
      </template>
    </b-modal>
    <!-----------削除 モーダル-------------->
    <b-modal v-model="isDeleteRelMstModal" title="確認画面">
      <b-container fluid>
        <p class="my-4">関係性を削除しますか？</p>
      </b-container>

      <template #modal-footer>
        <b-button
          variant="secondary"
          size="sm"
          class="float-right"
          @click="isDeleteRelMstModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="danger"
          size="sm"
          class="float-right"
          @click="deleteRelMstApi()"
        >
          削除
        </b-button>
      </template>
    </b-modal>

    <!-----------時系列編集 モーダル-------------->
    <b-modal v-model="isTimeModal" title="編集画面">
      <b-container fluid>
        <b-row class="mb-1">
          <input type="hidden" v-model="editTime.timeId" />
          <input type="hidden" v-model="editTime.version" />
          <b-col cols="3">時系列名</b-col>
          <b-col>
            <div class="input-group">
              <input
                class="form-control"
                placeholder="時系列名を入力してください。"
                type="text"
                name="edit_time_name"
                v-model="createTime.timeName"
                v-bind:class="[createTime.valid]"
              />
              <b-button variant="info" @click="createTimeApi()">
                追加
              </b-button>
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
                <td>{{ row.time_name }}</td>
                <td>
                  <button
                    type="button"
                    class="btn btn-success"
                    @click="
                      isEditTimeModalOpen(
                        row.time_id,
                        row.time_name,
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
                    @click="isDeleteTimeModalOpen(row.time_id)"
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
          @click="isTimeModal = false"
        >
          閉じる
        </b-button>
      </template>
    </b-modal>
    <!-----------編集 モーダル-------------->
    <b-modal v-model="isEditTimeModal" title="編集画面">
      <b-container fluid>
        <b-row class="mb-1">
          <input type="hidden" v-model="editTime.timeId" />
          <input type="hidden" v-model="editTime.version" />
          <b-col cols="3">時系列名</b-col>
          <b-col>
            <div class="input-group">
              <input
                class="form-control"
                placeholder="時系列名を入力してください。"
                type="text"
                name="edit_time_name"
                v-model="editTime.timeName"
                v-bind:class="[editTime.valid]"
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
          @click="isEditTimeModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="success"
          size="sm"
          class="float-right"
          @click="editTimeApi()"
        >
          更新
        </b-button>
      </template>
    </b-modal>
    <!-----------削除 モーダル-------------->
    <b-modal v-model="isDeleteTimeModal" title="確認画面">
      <b-container fluid>
        <p class="my-4">時系列を削除しますか？</p>
      </b-container>

      <template #modal-footer>
        <b-button
          variant="secondary"
          size="sm"
          class="float-right"
          @click="isDeleteTimeModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="danger"
          size="sm"
          class="float-right"
          @click="deleteTimeApi()"
        >
          削除
        </b-button>
      </template>
    </b-modal>

    <!-----------グループ編集 モーダル-------------->
    <b-modal v-model="isGroupModal" title="編集画面">
      <b-container fluid>
        <b-row class="mb-1">
          <b-col cols="3">グループ名</b-col>
          <b-col>
            <div class="input-group">
              <input
                class="form-control"
                placeholder="グループ名を入力してください。"
                type="text"
                name="create_group_name"
                v-model="createGroup.groupName"
                v-bind:class="[createGroup.groupNameValid]"
              />
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">グループ色</b-col>
          <b-col>
            <div class="input-group">
              <select
                class="form-control"
                v-model="createGroup.groupColor"
                v-bind:class="[createGroup.groupColorValid]"
              >
                <option :value="null" disabled>
                  グループ色を選択してください。
                </option>
                <option
                  v-for="(val, key) in commonMstColor"
                  :key="key"
                  v-bind:value="val.common_value"
                >
                  {{ val.common_info }}
                </option>
              </select>
              <b-button variant="info" @click="createGroupApi()">
                追加
              </b-button>
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
              <tr
                v-for="(row, key) in groupList"
                :key="key"
                v-bind:style="{
                  backgroundColor: row.group_color,
                }"
              >
                <td>{{ row.group_name }}</td>
                <td>
                  <button
                    type="button"
                    class="btn btn-success"
                    @click="
                      isEditGroupModalOpen(
                        row.group_id,
                        row.group_name,
                        row.group_color,
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
                    @click="isDeleteGroupModalOpen(row.group_id)"
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
          @click="isGroupModal = false"
        >
          閉じる
        </b-button>
      </template>
    </b-modal>
    <!-----------編集 モーダル-------------->
    <b-modal v-model="isEditGroupModal" title="編集画面">
      <b-container fluid>
        <input type="hidden" v-model="editGroup.group_id" />
        <input type="hidden" v-model="editGroup.version" />
        <b-row class="mb-1">
          <b-col cols="3">グループ名</b-col>
          <b-col>
            <div class="input-group">
              <input
                class="form-control"
                placeholder="グループ名を入力してください。"
                type="text"
                name="edit_group_name"
                v-model="editGroup.groupName"
                v-bind:class="[editGroup.groupNameValid]"
              />
            </div>
          </b-col>
        </b-row>
        <b-row class="mb-1">
          <b-col cols="3">グループ色</b-col>
          <b-col>
            <div class="input-group">
              <select
                class="form-control"
                v-model="editGroup.groupColor"
                v-bind:class="[editGroup.groupColorValid]"
              >
                <option
                  v-for="(val, key) in commonMstColor"
                  :key="key"
                  v-bind:value="val.common_value"
                >
                  {{ val.common_info }}
                </option>
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
          @click="isEditGroupModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="success"
          size="sm"
          class="float-right"
          @click="editGroupApi()"
        >
          更新
        </b-button>
      </template>
    </b-modal>
    <!-----------削除 モーダル-------------->
    <b-modal v-model="isDeleteGroupModal" title="確認画面">
      <b-container fluid>
        <p class="my-4">グループを削除しますか？</p>
      </b-container>

      <template #modal-footer>
        <b-button
          variant="secondary"
          size="sm"
          class="float-right"
          @click="isDeleteGroupModal = false"
        >
          閉じる
        </b-button>
        <b-button
          variant="danger"
          size="sm"
          class="float-right"
          @click="deleteGroupApi()"
        >
          削除
        </b-button>
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
    <!-----------相関図削除 モーダル-------------->
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
import { VueLoading } from "vue-loading-template";
import D3Network from "vue-d3-network";

export default {
  data() {
    return {
      loading: false,
      actorList: [],
      timeList: [],
      relMstList: [],
      groupList: [],
      commonMstColor: [],
      currentInfo: {
        currentId: "",
        currentName: "",
        currentInfo: "",
        currentImg: "",
        opusId: "",
        timeId: "",
        groupId: "",
        isActor: true,
        valid: "",
      },
      opusInfo: {
        opusId: "",
        opusName: "",
        opusFlg: false,
        version: 0,
      },
      createActor: {
        actorName: "",
        actorInfo: "",
        actorImg: "",
        opusId: "",
        timeId: null,
        timeName: "",
        groupId: null,
        imgFile: null,
        actorNameValid: "",
        timeIdValid: "",
        groupIdValid: "",
      },
      editActor: {
        actorId: "",
        actorName: "",
        actorInfo: "",
        actorImg: "",
        opusId: "",
        timeId: null,
        groupId: null,
        imgFile: null,
        version: 0,
        actorNameValid: "",
        timeIdValid: "",
        groupIdValid: "",
      },
      createTime: {
        timeName: "",
        opusId: "",
        valid: "",
      },
      editTime: {
        timeId: "",
        timeName: "",
        version: 0,
        valid: "",
      },
      deleteTime: {
        timeId: "",
      },
      createGroup: {
        groupName: "",
        groupInfo: "",
        groupColor: null,
        opusId: "",
        timeId: "",
        groupNameValid: "",
        groupColorValid: "",
      },
      editGroup: {
        groupId: "",
        groupName: "",
        groupColor: null,
        version: 0,
        groupNameValid: "",
        groupColorValid: "",
      },
      deleteGroup: {
        groupId: "",
      },
      createRelMst: {
        relMstName: "",
        valid: "",
      },
      editRelMst: {
        relMstId: "",
        relMstName: "",
        version: 0,
        valid: "",
      },
      deleteRelMst: {
        relMstId: "",
      },
      createRel: {
        relMstId: null,
        relInfo: "",
        actorId: null,
        targetId: null,
        actorIdValid: "",
        targetIdvalid: "",
        relMstIdValid: "",
      },
      editRel: {
        relId: "",
        relMstId: null,
        relInfo: "",
        actorId: null,
        targetId: null,
        version: 0,
        actorIdValid: "",
        targetIdvalid: "",
        relMstIdValid: "",
      },
      currentId: "time0000",
      currentName: "",
      currentSearchText: "",
      currentSearchBtn: 1,
      graphList: VueFileName.graphList,
      graphSubmit: VueFileName.graphSubmit,
      /* グラフ変数 */
      nodes: [],
      links: [],
      nodeSize: 40,
      canvas: false,
      force: 2000,
      /* モーダルウィンドウ変数 */
      isCreateActorModal: false,
      isEditActorModal: false,
      isDeleteActorModal: false,
      isTimeModal: false,
      isEditTimeModal: false,
      isDeleteTimeModal: false,
      isGroupModal: false,
      isEditGroupModal: false,
      isDeleteGroupModal: false,
      isRelMstModal: false,
      isEditRelMstModal: false,
      isDeleteRelMstModal: false,
      isGraphDeleteModal: false,
      isCreateRelModal: false,
      isEditRelModal: false,
      isDeleteRelModal: false,
      isSubmitCheckModal: false,
    };
  },
  beforeRouteEnter(to, from, next) {
    next((vm) => {
      vm.initialize(); // 初期化処理
      next();
    });
  },
  methods: {
    /* 初期処理 */
    initialize() {
      // 初期化処理

      // パラメータ生成
      let params = {
        opus_id: this.$route.params.id,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // 作品取得

      try {
        eel.SearchOpusControler(params)((response) => {
          // 作品情報格納
          this.opusInfo.opusId = response.data.optional[0].opus_id;
          this.opusInfo.opusName = response.data.optional[0].opus_name;
          this.opusInfo.opusFlg = response.data.optional[0].opus_flg;
          this.opusInfo.version = response.data.optional[0].version;

          // 汎用マスタ（グループ色）取得
          this.selectCommonMstApi("_color");

          // 関係性取得
          this.selectRelMstApi(null, null);

          // 時系列取得
          params = {
            opus_id: this.$route.params.id,
            user_id: this.$store.getters.getUserId,
            token: this.$store.getters.getToken,
          };

          // 時系列画面反映処理
          // 時系列取得

          try {
            eel.SearchTimeControler(params)((response) => {
              // 成功

              // 時系列
              this.timeList = response.data.optional;

              // 時系列が存在するかチェック
              if (!!this.timeList[0] && !!this.timeList[0].time_id) {
                // 存在した時系列を格納
                this.currentId = this.timeList[0].time_id;
                this.currentName = this.timeList[0].time_name;
              }

              // グループ取得
              this.selectGroupApi(null, null);
              // グラフ取得
              this.selectGraphApi(null, null, null);
              // 登場人物取得
              this.selectActorApi(null, null);
            });
          } catch (error) {
            // 失敗
            console.log("時系列取得に失敗しました。");
          }
        });
      } catch (error) {
        // 失敗
        console.log("作品取得に失敗しました。");
      }
    },
    /* API */
    async selectActorApi(actorId, actorName) {
      let params = {
        actor_id: actorId,
        actor_name: actorName,
        opus_id: this.$route.params.id,
        time_id: this.currentId,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // 登場人物画面反映処理
      // 登場人物取得
      try {
        await eel.SearchActorControler(params)((response) => {
          // 成功

          // 登場人物
          this.actorList = response.data.optional;
        });
      } catch (error) {
        // 失敗
        console.log("登場人物取得に失敗しました。");
      }
    },
    async createActorApi() {
      // 画像登録
      let params = {
        actor_img: this.createActor.imgFile,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      if (!!this.createActor.imgFile) {
        // 画像登録
        try {
          await eel.CreateActorImgControler(params)((response) => {
            // 成功
            // 画像取得
            this.createActor.actorImg = response.data.optional[0].actor_img;
          });
        } catch (error) {
          // 失敗
          console.log("画像登録に失敗しました。");
        }
      }

      params = {
        actor_name: this.createActor.actorName,
        actor_info: this.createActor.actorInfo,
        actor_img: !!this.createActor.actorImg
          ? this.createActor.actorImg
          : "/user/unknown.png",
        opus_id: this.$route.params.id,
        time_id: this.currentId,
        group_id: this.createActor.groupId,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // バリデーションチェック
      if (this.createActorValidation(params)) {
        throw "バリデーションエラー";
      }

      // 登録

      try {
        eel.CreateActorControler(params)(() => {
          // 成功

          // 画面反映処理
          this.selectGraphApi(null, null, null);
          this.selectActorApi(null, null);

          // モーダルウィンドウを閉じる
          this.isCreateActorModal = false;
        });
      } catch (error) {
        // 失敗
        console.log("登場人物登録に失敗しました。");
      }
    },
    async editActorApi() {
      // 更新処理
      let params = {
        actor_img: this.editActor.imgFile,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      if (!!this.editActor.imgFile) {
        // 画像登録

        try {
          await eel.CreateActorImgControler(params)((response) => {
            // 成功
            // 画像取得
            this.editActor.actorImg = response.data.optional[0].actor_img;
          });
        } catch (error) {
          // 失敗
          console.log("画像登録に失敗しました。");
        }
      }

      // パラメータ作成
      params = {
        actor_id: this.editActor.actorId,
        actor_name: this.editActor.actorName,
        actor_info: this.editActor.actorInfo,
        actor_img: this.editActor.actorImg,
        opus_id: this.$route.params.id,
        time_id: this.currentId,
        group_id: this.editActor.groupId,
        version: this.editActor.version,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // 更新

      try {
        eel.EditActorControler(params)(() => {
          // 成功

          // 画面反映処理
          this.selectGraphApi(null, null, null);
          this.selectActorApi(null, null);

          // 表示変数初期化
          this.currentInfoFormat();

          // モーダルウィンドウ閉じる
          this.isEditActorModal = false;
        });
      } catch (error) {
        // 失敗
        console.log("登場人物更新に失敗しました。");
      }
    },
    deleteActorApi() {
      // 削除処理

      // パラメータ作成
      let params = {
        actor_id: this.currentInfo.currentId,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // 削除
      try {
        eel.DeleteActorControler(params)(() => {
          // 成功
          // 画面反映処理
          this.selectGraphApi(null, null, null);
          this.selectActorApi(null, null);

          // 表示変数初期化
          this.currentInfoFormat();

          // モーダルウィンドウ閉じる
          this.isDeleteActorModal = false;
        });
      } catch (error) {
        // 失敗
        console.log("登場人物削除に失敗しました。");
      }
    },
    async selectRelApi(relId, relMstId) {
      let params = {
        rel_id: relId,
        rel_mst_id: relMstId,
        opus_id: this.$route.params.id,
        time_id: this.currentId,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // 関係画面反映処理
      // 関係取得
      try {
        await eel.SearchRelControler(params)((response) => {
          // 成功

          // 関係
          this.relList = response.data.optional;
        });
      } catch (error) {
        // 失敗
        console.log("関係取得に失敗しました。");
      }
    },
    createRelApi() {
      let params = {
        rel_mst_id: this.createRel.relMstId,
        rel_mst_info: this.createRel.relInfo,
        actor_id: this.createRel.actorId,
        target_id: this.createRel.targetId,
        opus_id: this.$route.params.id,
        time_id: this.currentId,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // バリデーションチェック
      if (this.createRelValidation(params)) {
        throw "バリデーションエラー";
      }

      // 登録
      try {
        eel.CreateRelControler(params)(() => {
          // 成功

          // 画面反映処理
          this.selectGraphApi(null, null, null);

          // モーダルウィンドウを閉じる
          this.isCreateRelModal = false;
        });
      } catch (error) {
        // 失敗
        console.log("関係登録に失敗しました。");
      }
    },
    async editRelApi() {
      // 更新処理

      // パラメータ作成
      let params = {
        rel_id: this.editRel.relId,
        rel_mst_id: this.editRel.relMstId,
        rel_mst_info: this.editRel.relInfo,
        actor_id: this.editRel.actorId,
        target_id: this.editRel.targetId,
        opus_id: this.$route.params.id,
        time_id: this.currentId,
        version: this.editRel.version,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // 更新
      try {
        eel.EditRelControler(params)(() => {
          // 成功

          // 画面反映処理
          this.selectGraphApi(null, null, null);
          this.selectRelApi(null, null);

          // 表示変数初期化
          this.currentInfoFormat();

          // モーダルウィンドウ閉じる
          this.isEditRelModal = false;
        });
      } catch (error) {
        // 失敗
        console.log("関係更新に失敗しました。");
      }
    },

    deleteRelApi() {
      // 削除処理

      // パラメータ作成
      let params = {
        rel_id: this.currentInfo.currentId,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // 削除
      try {
        eel.DeleteRelControler(params)(() => {
          // 成功
          // 画面反映処理
          this.selectGraphApi(null, null, null);
          this.selectRelApi(null, null);

          // 表示変数初期化
          this.currentInfoFormat();

          // モーダルウィンドウ閉じる
          this.isDeleteRelModal = false;
        });
      } catch (error) {
        // 失敗
        console.log("関係削除に失敗しました。");
      }
    },

    async selectTimeApi(timeId, timeName) {
      let params = {
        time_id: timeId,
        time_name: timeName,
        opus_id: this.$route.params.id,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // 時系列画面反映処理
      // 時系列取得
      try {
        await eel.SearchTimeControler({ params: params })((response) => {
          // 成功

          // 時系列
          this.timeList = response.data.optional;
        });
      } catch (error) {
        // 失敗
        console.log("時系列取得に失敗しました。");
      }
    },

    createTimeApi() {
      let params = {
        time_name: this.createTime.timeName,
        opus_id: this.$route.params.id,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // バリデーションチェック
      if (this.createTimeValidation(params)) {
        throw "バリデーションエラー";
      }

      // 時系列登録
      try {
        eel.CreateTimeControler(params)(() => {
          // 成功

          // 画面反映処理
          this.selectTimeApi(null, null);
        });
      } catch (error) {
        // 失敗
        console.log("時系列登録に失敗しました。");
      }
    },

    editTimeApi() {
      // 更新処理

      // パラメータ作成
      let params = {
        time_id: this.editTime.timeId,
        time_name: this.editTime.timeName,
        version: this.editTime.version,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // バリデーションチェック
      if (this.editTimeValidation(params)) {
        throw "バリデーションエラー";
      }

      // 更新
      try {
        eel.EditTimeControler(params)((response) => {
          // 成功

          // 画面反映処理
          this.selectTimeApi(null, null);

          // モーダルウィンドウ閉じる
          this.isEditTimeModal = false;
        });
      } catch (error) {
        // 失敗
        console.log("時系列更新に失敗しました。");
      }
    },

    deleteTimeApi() {
      // 削除処理

      // パラメータ作成
      let params = {
        time_id: this.deleteTime.timeId,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // 削除
      try {
        eel.DeleteTimeControler(params)((response) => {
          // 成功

          // 画面反映処理
          this.selectTimeApi(null, null);

          // モーダルウィンドウ閉じる
          this.isDeleteTimeModal = false;
        });
      } catch (error) {
        // 失敗
        console.log("時系列削除に失敗しました。");
      }
    },

    async selectGroupApi(groupId, groupName) {
      let params = {
        group_id: groupId,
        group_name: groupName,
        opus_id: this.$route.params.id,
        time_id: this.currentId,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // グループ画面反映処理
      // グループ取得
      try {
        await eel.SearchGroupControler({ params: params })((response) => {
          // 成功

          // グループ
          this.groupList = response.data.optional;
        });
      } catch (error) {
        // 失敗
        console.log("グループ取得に失敗しました。");
      }
    },

    createGroupApi() {
      let params = {
        group_name: this.createGroup.groupName,
        group_color: this.createGroup.groupColor,
        opus_id: this.$route.params.id,
        time_id: this.currentId,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // バリデーションチェック
      if (this.createGroupValidation(params)) {
        throw "バリデーションエラー";
      }

      // 登録
      try {
        eel.CreateGroupControler(params)(() => {
          // 成功

          // 画面反映処理
          this.selectGroupApi(null, null);
        });
      } catch (error) {
        // 失敗
        console.log("グループ登録に失敗しました。");
      }
    },

    editGroupApi() {
      // 更新処理

      // パラメータ作成
      let params = {
        group_id: this.editGroup.groupId,
        group_name: this.editGroup.groupName,
        group_color: this.editGroup.groupColor,
        version: this.editGroup.version,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // バリデーションチェック
      if (this.editGroupValidation(params)) {
        throw "バリデーションエラー";
      }

      // 更新
      try {
        eel.EditGroupControler(params)((response) => {
          // 成功

          // 画面反映処理
          this.selectGroupApi(null, null);
          this.selectGraphApi(null, null, null);

          // モーダルウィンドウ閉じる
          this.isEditGroupModal = false;
        });
      } catch (error) {
        // 失敗
        console.log("グループ更新に失敗しました。");
      }
    },

    deleteGroupApi() {
      // 削除処理

      // パラメータ作成
      let params = {
        group_id: this.deleteGroup.groupId,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // 削除
      try {
        eel.DeleteGroupControler(params)(() => {
          // 成功

          // 画面反映処理
          this.selectGroupApi(null, null);
          this.selectGraphApi(null, null, null);

          // モーダルウィンドウ閉じる
          this.isDeleteGroupModal = false;
        });
      } catch (error) {
        // 失敗
        console.log("グループ削除に失敗しました。");
      }
    },

    async selectRelMstApi(relMstId, relMstName) {
      let params = {
        rel_mst_id: relMstId,
        rel_mst_name: relMstName,
        opus_id: this.$route.params.id,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // 関係性画面反映処理
      // 関係性取得
      try {
        await eel.SearchRelMstControler({ params: params })((response) => {
          // 成功

          // 関係性
          this.relMstList = response.data.optional;
        });
      } catch (error) {
        // 失敗
        console.log("関係性取得に失敗しました。");
      }
    },

    createRelMstApi() {
      let params = {
        rel_mst_name: this.createRelMst.relMstName,
        opus_id: this.$route.params.id,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // バリデーションチェック
      if (this.createRelMstValidation(params)) {
        throw "バリデーションエラー";
      }

      // 関係性登録
      try {
        eel;
        CreateRelMstControler(params)(() => {
          // 成功

          // 画面反映処理
          this.selectRelMstApi(null, null);
        });
      } catch (error) {
        // 失敗
        console.log("関係性登録に失敗しました。");
      }
    },

    editRelMstApi() {
      // 更新処理

      // パラメータ作成
      let params = {
        rel_mst_id: this.editRelMst.relMstId,
        rel_mst_name: this.editRelMst.relMstName,
        version: this.editRelMst.version,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // バリデーションチェック
      if (this.editRelMstValidation(params)) {
        throw "バリデーションエラー";
      }

      // 更新
      try {
        eel.EditRelMstControler(params)((response) => {
          // 成功

          // 画面反映処理
          this.selectRelMstApi(null, null);

          // モーダルウィンドウ閉じる
          this.isEditRelMstModal = false;
        });
      } catch (error) {
        // 失敗
        console.log("関係性更新に失敗しました。");
      }
    },

    deleteRelMstApi() {
      // 削除処理

      // パラメータ作成
      let params = {
        rel_mst_id: this.deleteRelMst.relMstId,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // 削除
      try {
        eel.DeleteRelMstControler(params)((response) => {
          // 成功

          // 画面反映処理
          this.selectRelMstApi(null, null);

          // モーダルウィンドウ閉じる
          this.isDeleteRelMstModal = false;
        });
      } catch (error) {
        // 失敗
        console.log("関係性削除に失敗しました。");
      }
    },

    async selectGraphApi(actorName, groupName, relMstName) {
      // パラメータ生成
      let params = {
        actor_name: actorName,
        group_name: groupName,
        rel_mst_name: relMstName,
        opus_id: this.$route.params.id,
        time_id: this.currentId,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // グラフ取得
      try {
        await eel.SearchGroupControler({ params: params }).then((response) => {
          this.nodes = response.data.optional.nodes;
          this.links = response.data.optional.links;
        });
      } catch (error) {
        // 失敗
        console.log("グラフ取得に失敗しました。");
      }
    },

    async selectCommonMstApi(commonKey) {
      let params = {
        common_key: commonKey,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // 汎用マスタ画面反映処理
      // 汎用マスタ取得
      try {
        await eel.SearchCommonControler({ params: params })((response) => {
          // 成功

          // 汎用マスタ
          this.commonMstColor = response.data.optional;
        });
      } catch (error) {
        // 失敗
        console.log("汎用マスタ取得に失敗しました。");
      }
    },

    editOpusApi() {
      // 作品更新処理
      // パラメータ生成
      let params = {
        opus_id: this.$route.params.id,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // 作品取得
      try {
        eel.SearchOpusControler({ params: params })((response) => {
          // パラメータ作成
          params = {
            opus_id: this.$route.params.id,
            opus_flg: 1,
            version: response.data.optional[0].version,
            user_id: this.$store.getters.getUserId,
            token: this.$store.getters.getToken,
          };
        });

        // 作品更新
        try {
          eel.EditOpusControler(params)(() => {
            // 成功

            // モーダルウィンドウ閉じる
            this.isSubmitCheckModal = true;
          });
        } catch (error) {
          // 失敗
          console.log("投稿に失敗しました。");
        }
      } catch (error) {
        // 失敗
        console.log("作品取得に失敗しました。");
      }
    },
    deleteOpusApi() {
      // 作品削除処理
      // パラメータ生成
      let params = {
        opus_id: this.$route.params.id,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // 作品削除
      try {
        eel.DeleteOpusControler(params)((response) => {
          // 画面変更
          this.$router.push({
            name: VueFileName.graphList,
          });
        });
      } catch (error) {
        // 失敗
        console.log("作品削除に失敗しました。");
      }
    },

    /* バリデーション */
    createActorValidation(params) {
      // 初期化
      let validationFlg = false;

      this.createActor.actorNameValid = "";
      this.createActor.timeIdValid = "";
      this.createActor.groupIdValid = "";

      if (CommonUtils.eq(params.actor_name, "")) {
        this.createActor.actorNameValid = "is-invalid";
        validationFlg = true;
      }

      if (CommonUtils.eq(params.time_id, "")) {
        this.createActor.timeIdValid = "is-invalid";
        validationFlg = true;
      }

      if (CommonUtils.eq(params.group_id, "")) {
        this.createActor.groupIdValid = "is-invalid";
        validationFlg = true;
      }
      return validationFlg;
    },
    createRelValidation(params) {
      // 初期化
      let validationFlg = false;

      this.createRel.relMstIdValid = "";
      this.createRel.actorIdValid = "";
      this.createRel.targetIdvalid = "";

      if (CommonUtils.eq(params.rel_mst_id, "")) {
        this.createRel.relMstIdValid = "is-invalid";
        validationFlg = true;
      }

      if (CommonUtils.eq(params.actor_id, "")) {
        this.createRel.actorIdValid = "is-invalid";
        validationFlg = true;
      }

      if (CommonUtils.eq(params.target_id, "")) {
        this.createRel.targetIdvalid = "is-invalid";
        validationFlg = true;
      }
      return validationFlg;
    },
    createTimeValidation(params) {
      // 初期化
      let validationFlg = false;

      this.createTime.timeName = "";

      if (CommonUtils.eq(params.time_name, "")) {
        this.createTime.valid = "is-invalid";
        validationFlg = true;
      }
      return validationFlg;
    },
    editTimeValidation(params) {
      // 初期化
      let validationFlg = false;

      this.editTime.valid = "";

      if (CommonUtils.eq(params.time_name, "")) {
        this.editTime.valid = "is-invalid";
        validationFlg = true;
      }
      return validationFlg;
    },
    createGroupValidation(params) {
      // 初期化
      let validationFlg = false;

      this.createGroup.groupNameValid = "";
      this.createGroup.groupColorValid = "";

      if (CommonUtils.eq(params.group_name, "")) {
        this.createGroup.groupNameValid = "is-invalid";
        validationFlg = true;
      }

      if (CommonUtils.eq(params.group_color, "")) {
        this.createGroup.groupColorValid = "is-invalid";
        validationFlg = true;
      }
      return validationFlg;
    },
    editGroupValidation(params) {
      // 初期化
      let validationFlg = false;

      this.editGroup.groupNameValid = "";
      this.editGroup.groupColorValid = "";

      if (CommonUtils.eq(params.group_name, "")) {
        this.editTime.groupNameValid = "is-invalid";
        validationFlg = true;
      }

      if (CommonUtils.eq(params.group_color, "")) {
        this.editTime.groupColorValid = "is-invalid";
        validationFlg = true;
      }
      return validationFlg;
    },
    createRelMstValidation(params) {
      // 初期化
      let validationFlg = false;

      this.createRelMst.relMstName = "";

      if (CommonUtils.eq(params.rel_mst_name, "")) {
        this.createRelMst.valid = "is-invalid";
        validationFlg = true;
      }
      return validationFlg;
    },
    editRelMstValidation(params) {
      // 初期化
      let validationFlg = false;

      this.editRelMst.valid = "";

      if (CommonUtils.eq(params.rel_mst_name, "")) {
        this.editRelMst.valid = "is-invalid";
        validationFlg = true;
      }
      return validationFlg;
    },
    /* モーダルウィンドウ処理 */
    isEditTimeModalOpen(timeId, timeName, version) {
      // 編集モーダルウィンドウ

      // 初期化
      this.editTime.timeId = timeId;
      this.editTime.timeName = timeName;
      this.editTime.version = version;

      // モーダルウィンドウ開く
      this.isEditTimeModal = true;
    },
    isDeleteTimeModalOpen(timeId) {
      // 削除モーダルウィンドウ

      // 初期化
      this.deleteTime.timeId = timeId;

      // モーダルウィンドウ開く
      this.isDeleteTimeModal = true;
    },
    isEditGroupModalOpen(groupId, groupName, groupColor, version) {
      // 編集モーダルウィンドウ

      // 初期化
      this.editGroup.groupId = groupId;
      this.editGroup.groupName = groupName;
      this.editGroup.groupColor = groupColor;
      this.editGroup.version = version;

      console.log(this.editGroup.groupId);
      console.log(this.editGroup.groupName);
      console.log(this.editGroup.groupColor);
      console.log(this.editGroup.version);

      // モーダルウィンドウ開く
      this.isEditGroupModal = true;
    },
    isDeleteGroupModalOpen(groupId) {
      // 削除モーダルウィンドウ

      // 初期化
      this.deleteGroup.groupId = groupId;

      // モーダルウィンドウ開く
      this.isDeleteGroupModal = true;
    },
    isCreateActorModalOpen() {
      // 登録モーダルウィンドウ

      // 初期化
      this.createActor.actorName = "";
      this.createActor.actorInfo = "";
      this.createActor.actorImg = "";
      this.createActor.opusId = null;
      this.createActor.timeId = null;
      this.createActor.groupId = null;
      this.createActor.imgFile = null;

      // モーダルウィンドウ開く
      this.isCreateActorModal = true;
    },
    isEditActorOrLinkModalOpen() {
      // 編集モーダルウィンドウ

      if (!!this.currentInfo.currentId) {
        if (this.currentInfo.isActor) {
          // 登場人物編集
          // パラメータ生成
          let params = {
            actor_id: this.currentInfo.currentId,
            user_id: this.$store.getters.getUserId,
            token: this.$store.getters.getToken,
          };

          // 登場人物取得
          eel
            .SearchActorControler({ params: params })((response) => {
              // モーダルウィンドウ開く
              this.editActor.actorId = response.data.optional[0].actor_id;
              this.editActor.actorName = response.data.optional[0].actor_name;
              this.editActor.actorInfo = response.data.optional[0].actor_info;
              this.editActor.actorImg = response.data.optional[0].actor_img;
              this.editActor.opusId = response.data.optional[0].opus_id;
              this.editActor.timeId = response.data.optional[0].time_id;
              this.editActor.groupId = response.data.optional[0].group_id;
              this.editActor.version = response.data.optional[0].version;

              // モーダルウィンドウ開く
              this.isEditActorModal = true;
            })
            .catch(() => {
              console.log("登場人物取得に失敗しました。");
            });

          try {
            eel.SearchActorControler({ params: params })((response) => {
              // モーダルウィンドウ開く
              this.editActor.actorId = response.data.optional[0].actor_id;
              this.editActor.actorName = response.data.optional[0].actor_name;
              this.editActor.actorInfo = response.data.optional[0].actor_info;
              this.editActor.actorImg = response.data.optional[0].actor_img;
              this.editActor.opusId = response.data.optional[0].opus_id;
              this.editActor.timeId = response.data.optional[0].time_id;
              this.editActor.groupId = response.data.optional[0].group_id;
              this.editActor.version = response.data.optional[0].version;

              // モーダルウィンドウ開く
              this.isEditActorModal = true;
            });
          } catch (error) {
            // 失敗
            console.log("登場人物取得に失敗しました。");
          }
        } else {
          // 関係編集
          // パラメータ生成
          let params = {
            rel_id: this.currentInfo.currentId,
            user_id: this.$store.getters.getUserId,
            token: this.$store.getters.getToken,
          };

          // 関係取得
          try {
            eel.SearchRelControler({ params: params })((response) => {
              // モーダルウィンドウ開く
              this.editRel.relId = response.data.optional[0].rel_id;
              this.editRel.relMstId = response.data.optional[0].rel_mst_id;
              this.editRel.relInfo = response.data.optional[0].rel_mst_info;
              this.editRel.actorId = response.data.optional[0].actor_id;
              this.editRel.targetId = response.data.optional[0].target_id;
              this.editRel.opusId = response.data.optional[0].opus_id;
              this.editRel.version = response.data.optional[0].version;

              // モーダルウィンドウ開く
              this.isEditRelModal = true;
            });
          } catch (error) {
            // 失敗
            console.log("関係取得に失敗しました。");
          }
        }
      }
    },

    isDeleteActorOrLinkModalOpen() {
      // 編集モーダルウィンドウ

      if (!!this.currentInfo.currentId) {
        if (this.currentInfo.isActor) {
          // モーダルウィンドウ開く
          this.isDeleteActorModal = true;
        } else {
          // モーダルウィンドウ開く
          this.isDeleteRelModal = true;
        }
      }
    },
    isCreateRelModalOpen() {
      // 登録モーダルウィンドウ

      // 初期化
      this.createRel.relMstId = null;
      this.createRel.relInfo = "";
      this.createRel.actorId = null;
      this.createRel.targetId = null;

      // モーダルウィンドウ開く
      this.isCreateRelModal = true;
    },
    isEditRelMstModalOpen(relMstId, relMstName, version) {
      // 編集モーダルウィンドウ

      // 初期化
      this.editRelMst.relMstId = relMstId;
      this.editRelMst.relMstName = relMstName;
      this.editRelMst.version = version;

      // モーダルウィンドウ開く
      this.isEditRelMstModal = true;
    },
    isDeleteRelMstModalOpen(relMstId) {
      // 削除モーダルウィンドウ

      // 初期化
      this.deleteRelMst.relMstId = relMstId;

      // モーダルウィンドウ開く
      this.isDeleteRelMstModal = true;
    },
    searchGraph() {
      // 検索処理

      // 初期化
      switch (this.currentSearchBtn) {
        case 1:
          // 検索処理
          this.selectGraphApi(this.currentSearchText, null, null);
          break;
        case 2:
          // 検索処理
          this.selectGraphApi(null, this.currentSearchText, null);
          break;
        case 3:
          // 検索処理
          this.selectGraphApi(null, null, this.currentSearchText);
          break;
      }
    },
    /* 相関図表示処理 */
    isSelectSvg(currentId) {
      // 画面変更
      try {
        // 選択中時系列を保持
        this.currentId = currentId;

        // パラメータ生成
        let params = {
          opus_id: this.$route.params.id,
          time_id: currentId,
          user_id: this.$store.getters.getUserId,
          token: this.$store.getters.getToken,
        };

        // グラフ取得
        try {
          eel.SearchGraphControler({ params: params })((response) => {
            this.nodes = response.data.optional.nodes;
            this.links = response.data.optional.links;
            // 表示変数初期化
            this.currentInfo.currentId = "";
            this.currentInfo.currentName = "";
            this.currentInfo.currentInfo = "";
            this.currentInfo.currentImg = "";
            this.currentInfo.opusId = "";
            this.currentInfo.timeId = "";
            this.currentInfo.groupId = "";
            this.currentInfo.isActor = true;

            for (let time of this.timeList) {
              if (this.currentId == time.time_id) {
                this.currentName = time.time_name;
              }
            }
            this.selectGroupApi();
          });
        } catch (e) {
          console.log(e);
        }
      } catch (error) {
        // 失敗
        console.log("グラフ取得に失敗しました。");
      }
    },

    /* 前ページ遷移処理 */
    returnBtn() {
      this.$router.go(-1);
    },
    /* 相関図ノード処理 */
    formatNode(node) {
      let svgAttrs = node._svgAttrs || {};
      if (!svgAttrs.id) svgAttrs.id = "node-" + node.id;
      node._svgAttrs = svgAttrs;
      return node;
    },
    /* 表示変数初期化処理 */
    currentInfoFormat() {
      // 表示変数初期化
      this.currentInfo.currentId = "";
      this.currentInfo.currentName = "";
      this.currentInfo.currentInfo = "";
      this.currentInfo.currentImg = "";
      this.currentInfo.opusId = "";
      this.currentInfo.timeId = "";
      this.currentInfo.groupId = "";
      this.currentInfo.isActor = true;
    },
    /* 相関図クリック時処理 */
    clickCell(event) {
      // 表示変数初期化
      this.currentInfoFormat();

      let id = 0;
      if (!!event.target.id) {
        // 登場人物か関係か確認
        if (event.target.id.match(/node/)) {
          // 登場人物の場合
          let target = {};
          id = Number(event.target.id.substr(5));
          for (let node of this.nodes) {
            if (id == node.id) {
              target = node;
            }
          }

          // 表示変数に代入
          this.currentInfo.currentId = target.actor_id;
          this.currentInfo.currentName = target.name;
          this.currentInfo.currentInfo = target.actor_info;
          this.currentInfo.currentImg = this.imagecheck(target.actor_img)
            ? target.actor_img
            : "/user/unknown.png";
          this.currentInfo.opusId = target.opus_id;
          this.currentInfo.timeId = target.time_id;
          this.currentInfo.groupId = target.group_id;
        } else {
          // 関係の場合
          let sname = "";
          let tname = "";
          id = Number(event.target.id.substr(5));

          for (let node of this.nodes) {
            if (this.links[id].sid == node.id) {
              sname = node.name;
            }
            if (this.links[id].tid == node.id) {
              tname = node.name;
            }
          }
          // 表示変数に代入
          this.currentInfo.currentId = this.links[id].rel_id;
          this.currentInfo.currentName = this.links[id].rel_mst_name;
          this.currentInfo.currentInfo =
            "【" +
            sname +
            "と" +
            tname +
            "の関係】" +
            "\n" +
            !!this.links[id].rel_mst_info
              ? this.links[id].rel_mst_info
              : "";
          this.currentInfo.currentImg = "/user/line.png";
          this.currentInfo.isActor = false;
        }
      }
    },
    // 画像設定処理
    createActorFile(e) {
      const file = e.target.files[0];
      const reader = new FileReader();
      reader.addEventListener("load", (e) => {
        this.createActor.imgFile = reader.result.replace(
          /data:.*\/.*;base64,/,
          ""
        );
      });

      if (file) {
        reader.readAsDataURL(file);
      }
    },
    editActorFile(e) {
      const file = e.target.files[0];
      const reader = new FileReader();
      reader.addEventListener("load", (e) => {
        this.editActor.imgFile = reader.result.replace(
          /data:.*\/.*;base64,/,
          ""
        );
      });

      if (file) {
        reader.readAsDataURL(file);
      }
    },
    // 画像確認処理
    imagecheck(url) {
      // 画像取得フラグ
      let imgFlg = true;
      if (url == null) {
        imgFlg = false;
      }

      let img = new Image();
      img.src = url;
      img.onerror = function () {
        // 画像が存在しない
        imgFlg = false;
      };

      return imgFlg;
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
        linkWidth: 5,
        nodeSize: this.nodeSize,
        nodeLabels: true,
        linkLabels: true,
        canvas: this.canvas,
      };
    },
  },
};
</script>

<style>
@import "../../style/d3-network.css";
</style>
