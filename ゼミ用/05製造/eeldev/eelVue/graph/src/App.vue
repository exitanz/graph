<template>
  <div id="app">
    <router-view name="menu" />

    <!-- メイン画面 -->
    <div>
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
            Copyright © 2021 exitanz All Rights Reserved.
          </small>
        </div>
      </div>
    </footer>
  </div>
</template>

<style>
</style>
