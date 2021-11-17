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
          <b-dropdown-item variant="danger" @click="isLogoutCheckModal = true"
            >ログアウト</b-dropdown-item
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
      this.$http
        .get(ApiURL.SEARCH_OPUS, { params: params })
        .then((response) => {
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
          this.$http
            .get(ApiURL.SEARCH_TIME, { params: params })
            .then((response) => {
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
            })
            .catch(() => {
              // 失敗
              console.log("時系列取得に失敗しました。");
            });
        })
        .catch(() => {
          // 失敗
          console.log("作品取得に失敗しました。");
        });
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
      await this.$http
        .get(ApiURL.SEARCH_ACTOR, { params: params })
        .then((response) => {
          // 成功

          // 登場人物
          this.actorList = response.data.optional;
        })
        .catch(() => {
          // 失敗
          console.log("登場人物取得に失敗しました。");
        });
    },
    async createActorApi() {
      // 画像登録
      let params = {
        actor_name: this.createActor.actorName,
        actor_info: this.createActor.actorInfo,
        actor_img: !!this.createActor.imgFile
          ? this.createActor.imgFile
          : "data:image/png;base64,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",
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
      this.$http
        .post(ApiURL.CREATE_ACTOR, params)
        .then(() => {
          // 成功

          // 画面反映処理
          this.selectGraphApi(null, null, null);
          this.selectActorApi(null, null);

          // モーダルウィンドウを閉じる
          this.isCreateActorModal = false;
        })
        .catch(() => {
          // 失敗
          console.log("登場人物登録に失敗しました。");
        });
    },
    async editActorApi() {
      // 更新処理
      let params = {
        actor_id: this.editActor.actorId,
        actor_name: this.editActor.actorName,
        actor_info: this.editActor.actorInfo,
        actor_img: this.editActor.imgFile,
        opus_id: this.$route.params.id,
        time_id: this.currentId,
        group_id: this.editActor.groupId,
        version: this.editActor.version,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // 更新
      this.$http
        .put(ApiURL.EDIT_ACTOR, params)
        .then(() => {
          // 成功

          // 画面反映処理
          this.selectGraphApi(null, null, null);
          this.selectActorApi(null, null);

          // 表示変数初期化
          this.currentInfoFormat();

          // モーダルウィンドウ閉じる
          this.isEditActorModal = false;
        })
        .catch(() => {
          // 失敗
          console.log("登場人物更新に失敗しました。");
        });
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
      this.$http
        .post(ApiURL.DELETE_ACTOR, params)
        .then(() => {
          // 成功
          // 画面反映処理
          this.selectGraphApi(null, null, null);
          this.selectActorApi(null, null);

          // 表示変数初期化
          this.currentInfoFormat();

          // モーダルウィンドウ閉じる
          this.isDeleteActorModal = false;
        })
        .catch(() => {
          // 失敗
          console.log("登場人物削除に失敗しました。");
        });
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
      await this.$http
        .get(ApiURL.SEARCH_REL, { params: params })
        .then((response) => {
          // 成功

          // 関係
          this.relList = response.data.optional;
        })
        .catch(() => {
          // 失敗
          console.log("関係取得に失敗しました。");
        });
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
      this.$http
        .post(ApiURL.CREATE_REL, params)
        .then(() => {
          // 成功

          // 画面反映処理
          this.selectGraphApi(null, null, null);

          // モーダルウィンドウを閉じる
          this.isCreateRelModal = false;
        })
        .catch(() => {
          // 失敗
          console.log("関係登録に失敗しました。");
        });
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
      this.$http
        .put(ApiURL.EDIT_REL, params)
        .then(() => {
          // 成功

          // 画面反映処理
          this.selectGraphApi(null, null, null);
          this.selectRelApi(null, null);

          // 表示変数初期化
          this.currentInfoFormat();

          // モーダルウィンドウ閉じる
          this.isEditRelModal = false;
        })
        .catch(() => {
          // 失敗
          console.log("関係更新に失敗しました。");
        });
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
      this.$http
        .post(ApiURL.DELETE_REL, params)
        .then(() => {
          // 成功
          // 画面反映処理
          this.selectGraphApi(null, null, null);
          this.selectRelApi(null, null);

          // 表示変数初期化
          this.currentInfoFormat();

          // モーダルウィンドウ閉じる
          this.isDeleteRelModal = false;
        })
        .catch(() => {
          // 失敗
          console.log("関係削除に失敗しました。");
        });
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
      await this.$http
        .get(ApiURL.SEARCH_TIME, { params: params })
        .then((response) => {
          // 成功

          // 時系列
          this.timeList = response.data.optional;
        })
        .catch(() => {
          // 失敗
          console.log("時系列取得に失敗しました。");
        });
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
      this.$http
        .post(ApiURL.CREATE_TIME, params)
        .then(() => {
          // 成功

          // 画面反映処理
          this.selectTimeApi(null, null);
        })
        .catch(() => {
          // 失敗
          this.createTime.valid = "is-invalid";
          console.log("時系列登録に失敗しました。");
        });
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
      this.$http
        .put(ApiURL.EDIT_TIME, params)
        .then((response) => {
          // 成功

          // 画面反映処理
          this.selectTimeApi(null, null);

          // モーダルウィンドウ閉じる
          this.isEditTimeModal = false;
        })
        .catch((error) => {
          // 失敗
          this.editTime.valid = "is-invalid";
          console.log("時系列更新に失敗しました。");
        });
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
      this.$http
        .post(ApiURL.DELETE_TIME, params)
        .then((response) => {
          // 成功

          // 画面反映処理
          this.selectTimeApi(null, null);

          // モーダルウィンドウ閉じる
          this.isDeleteTimeModal = false;
        })
        .catch(() => {
          // 失敗
          console.log("時系列削除に失敗しました。");
        });
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
      await this.$http
        .get(ApiURL.SEARCH_GROUP, { params: params })
        .then((response) => {
          // 成功

          // グループ
          this.groupList = response.data.optional;
        })
        .catch(() => {
          // 失敗
          console.log("グループ取得に失敗しました。");
        });
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
      this.$http
        .post(ApiURL.CREATE_GROUP, params)
        .then(() => {
          // 成功

          // 画面反映処理
          this.selectGroupApi(null, null);
        })
        .catch(() => {
          // 失敗
          this.createGroup.groupNameValid = "is-invalid";
          this.createGroup.groupColorValid = "is-invalid";
          console.log("グループ登録に失敗しました。");
        });
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
      this.$http
        .put(ApiURL.EDIT_GROUP, params)
        .then((response) => {
          // 成功

          // 画面反映処理
          this.selectGroupApi(null, null);
          this.selectGraphApi(null, null, null);

          // モーダルウィンドウ閉じる
          this.isEditGroupModal = false;
        })
        .catch((error) => {
          // 失敗
          this.editGroup.groupNameValid = "is-invalid";
          this.editGroup.groupColorValid = "is-invalid";
          console.log("グループ更新に失敗しました。");
        });
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
      this.$http
        .post(ApiURL.DELETE_GROUP, params)
        .then(() => {
          // 成功

          // 画面反映処理
          this.selectGroupApi(null, null);
          this.selectGraphApi(null, null, null);

          // モーダルウィンドウ閉じる
          this.isDeleteGroupModal = false;
        })
        .catch(() => {
          // 失敗
          console.log("グループ削除に失敗しました。");
        });
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
      await this.$http
        .get(ApiURL.SEARCH_RELMST, { params: params })
        .then((response) => {
          // 成功

          // 関係性
          this.relMstList = response.data.optional;
        })
        .catch(() => {
          // 失敗
          console.log("関係性取得に失敗しました。");
        });
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
      this.$http
        .post(ApiURL.CREATE_RELMST, params)
        .then(() => {
          // 成功

          // 画面反映処理
          this.selectRelMstApi(null, null);
        })
        .catch(() => {
          // 失敗
          this.createRelMst.valid = "is-invalid";
          console.log("関係性登録に失敗しました。");
        });
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
      this.$http
        .put(ApiURL.EDIT_RELMST, params)
        .then((response) => {
          // 成功

          // 画面反映処理
          this.selectRelMstApi(null, null);

          // モーダルウィンドウ閉じる
          this.isEditRelMstModal = false;
        })
        .catch((error) => {
          // 失敗
          this.editRelMst.valid = "is-invalid";
          console.log("関係性更新に失敗しました。");
        });
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
      this.$http
        .post(ApiURL.DELETE_RELMST, params)
        .then((response) => {
          // 成功

          // 画面反映処理
          this.selectRelMstApi(null, null);

          // モーダルウィンドウ閉じる
          this.isDeleteRelMstModal = false;
        })
        .catch(() => {
          // 失敗
          console.log("関係性削除に失敗しました。");
        });
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
      await this.$http
        .get(ApiURL.SEARCH_GRAPH, { params: params })
        .then((response) => {
          this.nodes = response.data.optional.nodes;
          this.links = response.data.optional.links;
        })
        .catch(() => {
          console.log("グラフ取得に失敗しました。");
        });
    },
    async selectCommonMstApi(commonKey) {
      let params = {
        common_key: commonKey,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // 汎用マスタ画面反映処理
      // 汎用マスタ取得
      await this.$http
        .get(ApiURL.COMMON_MST, { params: params })
        .then((response) => {
          // 成功

          // 汎用マスタ
          this.commonMstColor = response.data.optional;
        })
        .catch(() => {
          // 失敗
          console.log("汎用マスタ取得に失敗しました。");
        });
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
      this.$http
        .get(ApiURL.SEARCH_OPUS, { params: params })
        .then((response) => {
          // パラメータ作成
          params = {
            opus_id: this.$route.params.id,
            opus_flg: 1,
            version: response.data.optional[0].version,
            user_id: this.$store.getters.getUserId,
            token: this.$store.getters.getToken,
          };

          // 作品更新
          this.$http
            .put(ApiURL.EDIT_OPUS, params)
            .then(() => {
              // 成功

              // モーダルウィンドウ閉じる
              this.isSubmitCheckModal = true;
            })
            .catch(() => {
              // 失敗
              console.log("投稿に失敗しました。");
            });
        })
        .catch(() => {
          console.log("作品取得に失敗しました。");
        });
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
      this.$http
        .post(ApiURL.DELETE_OPUS, params)
        .then((response) => {
          // 画面変更
          this.$router.push({
            name: VueFileName.graphList,
          });
        })
        .catch(() => {
          console.log("作品削除に失敗しました。");
        });
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
          this.$http
            .get(ApiURL.SEARCH_ACTOR, { params: params })
            .then((response) => {
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
        } else {
          // 関係編集
          // パラメータ生成
          let params = {
            rel_id: this.currentInfo.currentId,
            user_id: this.$store.getters.getUserId,
            token: this.$store.getters.getToken,
          };

          // 関係取得
          this.$http
            .get(ApiURL.SEARCH_REL, { params: params })
            .then((response) => {
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
            })
            .catch(() => {
              console.log("関係取得に失敗しました。");
            });
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
        this.$http
          .get(ApiURL.SEARCH_GRAPH, { params: params })
          .then((response) => {
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
          })
          .catch((error) => {
            console.log("グラフ取得に失敗しました。");
          });
      } catch (e) {
        console.log(e);
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
          this.currentInfo.currentImg = !!target.actor_img
            ? target.actor_img
            : "data:image/png;base64,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";
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
          this.currentInfo.currentImg = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAxAAAAMCCAYAAAD55yBtAAAABHNCSVQICAgIfAhkiAAAAF96VFh0UmF3IHByb2ZpbGUgdHlwZSBBUFAxAAAImeNKT81LLcpMVigoyk/LzEnlUgADYxMuE0sTS6NEAwMDCwMIMDQwMDYEkkZAtjlUKNEABZiYm6UBoblZspkpiM8FAE+6FWgbLdiMAAAgAElEQVR4nOzdeXhdR503+G9VnXPu1b7akrzJ8irJdrzL8hLb2QMJJM1LgCYv2A20HDuR14Stu0fwTDc0ZIWEJBPS8zTTM2/zMtPz0t1v0/S8zxBoSGInDWNICFkIJDaJE6+yLGu595yq+cO3jupeySEJto6W7+d59Ni62upI91adX9WvfgUQEREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREREU00XV1dMuk2EBEREU1mIukGEL0dnZ2dKaVUtTFmDQB4nvciAGQyGSilqgDgvvvuexwA9u3bt1kpJb761a8+lnt/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r/1Wa/0ggKsw+LeLYPC+dx2AJcZzv2gc8yml1Ffll2ut7wZwAwb/jofyD78C4L/nP/5R/r30QYq01mnXdZ/q6enBsWPHUFZWhlwu19Pf3w8AG7TWqWg0+mxPT8+en/3sZ9JnoFHEfePH0fe+972ZZWVlvV1dXcstyyrXWieuvfbag3/zN3/TlkqlFhcVFUEpVW/+jNa6CoMvQiGzBi/k30cBXJ3/+AAGLwYAUB54+r81Pm7GYCd6pHSmz2Po4pEE8O/SJq31/w5gaf5rRwA8o5TqeLdj1lqvAfAZACX5h/oxePFsR/5Cnr9oSjCbzL//cv79S0opuWnI7/Q690qpI1rrxRg83r/Kt8ucqjSP2/xaNQZvAvVKqWFpT/ngBxgcXSnLt1tyKE8qpV7Mf9/i/O/5Yr49d4zwuy7H4AX/gBls5X/WTCMcAGArpTry//fLMRRYdBrf52AwEEgrpbyZCjlX/uVf/gWvvPLKcQAoLi6usG37Msuyvg/gw1rrf3Zd9//duXMnp3OJaNzcdtttP9Bar8rlclBKvRiLxTLFxcWorq6ev2HDhrPr169/Kx73lmT9JQYHbsST73Cd/hqAeflPfy/fk7+2moqAwfvFCL+jCoODQ31Kqcb8Y3fnv/8O4/t+kP+wQyn108DvWI/Be0U1Bu8zMggHDHZ4r8fgfbwe/gE+KKV+EfhdswB8AkNBxwEAr+U/7jG+dXH+54OZAWabphsPTTM+7gLwtnn/Nu5l12PwnifP9/tAe0ccMDR+j9y7NuQfkv+b9GP+UynV9g4/KwOUFQDOYjBwO6uUet8pT9/+9rerlFJLAKCqqmrv5s2bWW6QCsudd9457rM/Wut4/n3Ze3zf9Her0JOfio6dx/OWyXOfx8+Uaq1L3/s7h7UrPsJjJSN97X3+zviF/NxEIYukuViaiML2jW98I3b77bcXv5/vlWvve11/tdZV+U7rhCb3obDb8V7y9//pF3vfmwzHSkRERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERERP9/e3BAAAAAACDk/+uGBAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAYCByKrkJ+Cr/YgAAAABJRU5ErkJggg==";
          this.currentInfo.isActor = false;
        }
      }
    },
    // 画像設定処理
    createActorFile(e) {
      const file = e.target.files[0];
      const reader = new FileReader();
      reader.addEventListener("load", (e) => {
        this.createActor.imgFile = reader.result;
      });

      if (file) {
        reader.readAsDataURL(file);
      }
    },
    editActorFile(e) {
      const file = e.target.files[0];
      const reader = new FileReader();
      reader.addEventListener("load", (e) => {
        this.editActor.imgFile = reader.result;
      });

      if (file) {
        reader.readAsDataURL(file);
      }
    },
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
