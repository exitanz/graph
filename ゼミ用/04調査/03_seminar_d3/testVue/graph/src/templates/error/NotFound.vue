<template>
  <div class="row">
    <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
    <aside class="col-sm-12 col-md-8 col-lg-8 col-xl-8">
      <div class="card">
        <article class="card-body">
          <h4 class="card-title text-center mb-4 mt-1">404 - Not Found</h4>
          <hr />
          <br />
          <div id="error">
            <div class="alert alert-secondary">
              ページが存在しません<br />
            </div>
          </div>
          <div class="form-group row">
            <div class="col">
              <button
                type="submit"
                class="btn btn-danger btn-block"
                @click="returnLogin"
              >
                トップページ
              </button>
            </div>
          </div>
        </article>
      </div>
    </aside>
    <aside class="col-sm-0 col-md-2 col-lg-2 col-xl-2"></aside>
  </div>
</template>

<script>
import { VueFileName } from "../../constants/VueFileName.js";

export default {
  methods: {
    returnLogin() {
      // 画面変更
      this.$router.push({
        name: VueFileName.login,
      });
    },
  },
};
</script>

<style>
</style>
