<template>
  <div class="row">
    <router-link v-bind:to="{ name: 'graphCreate' }">
      <b-button variant="primary"> graphCreate</b-button>
    </router-link>
    <router-link v-bind:to="{ name: 'test2' }">
      <b-button variant="primary"> test2</b-button>
    </router-link>
    <router-link v-bind:to="{ name: 'test2' }">
      <b-button variant="primary"> test2</b-button>
    </router-link>
  </div>
</template>

