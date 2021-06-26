<template>
  <div class="row">
    <!--------------------------作品一覧画面-------------------------------->
    <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
    <aside class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
      <div class="card">
        <article class="card-body">
          <h4 class="card-title text-center mb-4 mt-1">相関図一覧</h4>
          <hr />
          <br />
          <b-alert show variant="success">作品名が作成されました。</b-alert>
          <b-alert show variant="danger"
            >〇〇文字以内で入力してください。</b-alert
          >
          <hr />
        </article>
        <b-container fluid>
          <b-row class="my-1">
            <b-col sm="2">
              <label class="mb-4 mt-1">作品名：</label>
            </b-col>
            <b-col sm="8">
              <b-form-input id="work-input"></b-form-input>
            </b-col>
            <b-col sm="2">
              <b-button variant="info"> 追加 </b-button>
            </b-col>
          </b-row>
        </b-container>
        <br />
        <br />
        <table class="table">
          <thead class="thead-light">
            <tr>
              <th>作品名</th>
              <th>編集</th>
              <th>削除</th>
              <th>閲覧</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(row, key) in works" :key="key">
              <td>{{ row.workName }}</td>
              <td>
                <button
                  type="button"
                  class="btn btn-success"
                  v-b-modal.work_edit_modal
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
              <td>
                <button type="button" class="btn btn-info" @click="read_graph">
                  <font-awesome-icon icon="eye" />
                </button>
              </td>
            </tr>
          </tbody>
        </table>
        <!-----------編集モーダルウィンドウ-------------->
        <b-modal id="work_edit_modal" title="編集画面">
          <div class="mt-3">作品名</div>
          <b-form-input id="work_name-input"></b-form-input>
        </b-modal>
        <!-----------削除モーダルウィンドウ-------------->
        <b-modal id="delete_modal" title="削除確認画面">
          <p class="my-4">データを削除しますか？</p>
        </b-modal>
      </div>
    </aside>
  </div>
</template>

<script>
//import { ApiURL } from "../../constants/ApiURL.js";
//import { CommonUtils } from "../../common/CommonUtils.js";
import { VueFaileName } from "../../constants/VueFaileName.js";

export default {
  data() {
    return {
      works: [],
    };
  },
  methods: {
    read_graph() {
      this.$router.push({
        name: VueFaileName.question,
        function() {
          this.isActive = !this.isActive;
        },
      });
    },
  },
};
</script>

<style>
</style>
