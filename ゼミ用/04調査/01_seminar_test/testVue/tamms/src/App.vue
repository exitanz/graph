<template>
  <div id="app">
    <router-view name="menu" />
    <br />

    <!-- メイン画面 -->
    <div class="container-fluid">
      <router-view />
    </div>

    <!-- フッター -->
    <footer
      class="container py-5"
      id="footer"
    >
      <div class="row">
        <div class="col-12 col-md">
          <small class="d-block mb-3 text-muted">
            Copyright © 2021 ryome&K All Rights Reserved.
          </small>
        </div>
      </div>
    </footer>
  </div>
</template>

<script>
</script>

<style>
/* #app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
} */
</style>
