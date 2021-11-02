<template>
  <div class="row">
    <aside class="col-12">
      <!-----------------------------------メニューバー--------------------------------------->
      <b-navbar toggleable type="dark" variant="dark">
        <b-button variant="secondary" @click="returnBtn()">
          <font-awesome-icon icon="arrow-circle-left" />
        </b-button>
        <b-navbar-brand> {{ opusInfo.opusName }}</b-navbar-brand>
        <b-navbar-brand>
          <b-button variant="info" @click="isCreateActorModalOpen()"
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
            <b-dropdown-item @click="isTimeModal = true"
              >時系列管理</b-dropdown-item
            >
            <b-dropdown-item @click="isGroupModal = true"
              >グループ管理</b-dropdown-item
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
    </aside>
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
                <div class="btn-group">
                  <button
                    type="button"
                    class="btn btn-secondary"
                    v-bind:class="[
                      currentSearchBtn === 1
                        ? 'btn-secondary active'
                        : 'btn-secondary',
                    ]"
                    @click="searchOpusApi(1)"
                  >
                    人物名
                  </button>
                  <button
                    type="button"
                    class="btn btn-secondary"
                    v-bind:class="[
                      currentSearchBtn === 2
                        ? 'btn-secondary active'
                        : 'btn-secondary',
                    ]"
                    @click="searchOpusApi(2)"
                  >
                    関係名
                  </button>
                  <button
                    type="button"
                    class="btn btn-secondary"
                    v-bind:class="[
                      currentSearchBtn === 3
                        ? 'btn-secondary active'
                        : 'btn-secondary',
                    ]"
                    @click="searchOpusApi(3)"
                  >
                    グループ名
                  </button>
                </div>
              </aside>
              <!-----------ズームタブ-------------->
              <aside class="col-12 p-3">
                <input type="range" max="100000" min="4000" v-model="force" />
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
    <!-----------Linkボタン モーダル-------------->
    <b-modal v-model="isLinkCreateModal" title="入力画面">
      <b-container fluid>
        <b-row class="mb-1">
          <b-col cols="3">関係名</b-col>
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
          <b-col cols="3">関係性</b-col>
          <b-col>
            <div class="input-group">
              <b-form-select v-model="selected" :options="options">
                <b-form-select-option>友達</b-form-select-option>
                <b-form-select-option>恋人</b-form-select-option>
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
          @click="logout()"
        >
          ログアウト
        </b-button>
      </template>
    </b-modal>
    <!-----------Actor編集 モーダル-------------->
    <b-modal v-model="isActorEditModal" title="編集画面">
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
              <select
                class="form-control"
                v-model="editActor.timeId"
                v-bind:class="[editActor.timeIdValid]"
              >
                <option :value="null" disabled>
                  時系列を選択してください。
                </option>
                <option
                  v-for="(row, key) in timeList"
                  :key="key"
                  v-bind:value="row.time_id"
                >
                  {{ row.time_name }}
                </option>
              </select>
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
import { ApiURL } from "../../constants/ApiURL.js";
import { CommonUtils } from "../../common/CommonUtils.js";
import { VueFileName } from "../../constants/VueFileName.js";
import { VueLoading } from "vue-loading-template";
import D3Network from "vue-d3-network";

export default {
  data() {
    return {
      loading: false,
      timeList: [],
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
      linkCreate: {
        linkId: "1",
        linkName: "2",
        linkInfo: "3",
        valid: "",
      },
      currentId: "time0000",
      currentName: "",
      currentSearchBtn: 1,
      graphList: VueFileName.graphList,
      graphSubmit: VueFileName.graphSubmit,
      /* グラフ変数 */
      nodes: [],
      links: [],
      nodeSize: 40,
      canvas: false,
      force: 4000,
      /* モーダルウィンドウ変数 */
      isCreateActorModal: false,
      isLinkCreateModal: false,
      isSubmitCheckModal: false,
      isTimeModal: false,
      isEditTimeModal: false,
      isDeleteTimeModal: false,
      isGroupModal: false,
      isEditGroupModal: false,
      isDeleteGroupModal: false,
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
    /* 初期処理 */
    initialize() {
      // 初期化処理

      // パラメータ生成
      let params = {
        opus_id: this.$route.params.id,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // パラメータ作成
      params = {
        opus_id: this.$route.params.id,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // 作品取得
      this.$http
        .get(ApiURL.SEARCH_OPUS, { params: params })
        .then((response) => {
          // 汎用マスタ取得
          this.opusInfo.opusId = response.data.optional[0].opus_id;
          this.opusInfo.opusName = response.data.optional[0].opus_name;
          this.opusInfo.opusFlg = response.data.optional[0].opus_flg;
          this.opusInfo.version = response.data.optional[0].version;
          this.selectCommonMstApi("_color");

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

              // パラメータ生成
              params = {
                time_id: this.currentId,
                user_id: this.$store.getters.getUserId,
                token: this.$store.getters.getToken,
              };

              // グループ取得
              this.$http
                .get(ApiURL.SEARCH_GROUP, { params: params })
                .then((response) => {
                  // 成功

                  // グループ
                  this.groupList = response.data.optional;

                  // パラメータ生成
                  params = {
                    opus_id: this.$route.params.id,
                    time_id: this.currentId,
                    user_id: this.$store.getters.getUserId,
                    token: this.$store.getters.getToken,
                  };

                  // グラフ取得
                  this.$http
                    .get(ApiURL.SEARCH_GRAPH, { params: params })
                    .then((response) => {
                      this.nodes = response.data.optional.nodes;
                      this.links = response.data.optional.links;
                    })
                    .catch(() => {
                      console.log("グラフ取得に失敗しました。");
                    });
                })
                .catch(() => {
                  // 失敗
                  console.log("グループ取得に失敗しました。");
                });
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
    createActorApi() {
      // 画像取得
      let params = {
        actor_img: this.createActor.imgFile,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      if (!!this.createActor.imgFile) {
        // 画像登録
        this.$http
          .post(ApiURL.CREATE_IMG_ACTOR, params)
          .then((response) => {
            // 成功
            // 画像取得
            this.createActor.actorImg = response.data.optional[0].actor_img;
          })
          .catch(() => {
            // 失敗
            console.log("画像登録に失敗しました。");
          });
      }

      params = {
        actor_name: this.createActor.actorName,
        actor_info: this.createActor.actorInfo,
        actor_img: !!this.createActor.actorImg ? this.createActor.actorImg: '/user/unknown.png',
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
          this.selectGraphApi(null, null);

          // モーダルウィンドウを閉じる
          this.isCreateActorModal = false;
        })
        .catch(() => {
          // 失敗
          console.log("登場人物登録に失敗しました。");
        });
    },
    selectTimeApi(timeId, timeName) {
      let params = {
        time_id: timeId,
        time_name: timeName,
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
    selectGroupApi(groupId, groupName) {
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
      this.$http
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
          this.selectGraphApi();

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
        .then((response) => {
          // 成功

          // 画面反映処理
          this.selectGroupApi(null, null);
          this.selectGraphApi();

          // モーダルウィンドウ閉じる
          this.isDeleteGroupModal = false;
        })
        .catch(() => {
          // 失敗
          console.log("時系列削除に失敗しました。");
        });
    },
    selectGraphApi() {
      // パラメータ生成
      let params = {
        opus_id: this.$route.params.id,
        time_id: this.currentId,
        user_id: this.$store.getters.getUserId,
        token: this.$store.getters.getToken,
      };

      // グラフ取得
      this.$http
        .get(ApiURL.SEARCH_GRAPH, { params: params })
        .then((response) => {
          this.nodes = response.data.optional.nodes;
          this.links = response.data.optional.links;
        })
        .catch((error) => {
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
    /* バリデーション */
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

      this.createGroup.group_name = "";
      this.createGroup.group_color = "";

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
      this.editGroup.groupId = groupId;

      // モーダルウィンドウ開く
      this.isDeleteGroupModal = true;
    },
    isCreateActorModalOpen(groupId) {
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
    returnBtn() {
      this.$router.go(-1);
    },
    /* モーダルウィンドウ処理 */
    actorEdit() {
      // アクター更新処理

      // 選択中のアクターID取得
      this.createEdit.actorId = document
        .getElementById("actor_id")
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
      // 表示変数初期化
      this.currentInfo.currentId = "";
      this.currentInfo.currentName = "";
      this.currentInfo.currentInfo = "";
      this.currentInfo.currentImg = "";
      this.currentInfo.opusId = "";
      this.currentInfo.timeId = "";
      this.currentInfo.groupId = "";
      this.currentInfo.isActor = true;

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
            sname +
            "と" +
            tname +
            "の関係" +
            "\n\n" +
            "【詳細情報】" +
            "\n" +
            this.links[id].rel_mst_info;
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
        // size:{ w:600, h:600},
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
@import "../../style/d3.css";
@import "../../style/d3-network.css";
</style>
