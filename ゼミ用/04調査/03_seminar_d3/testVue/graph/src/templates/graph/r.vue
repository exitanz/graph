<template>
  <div class="row">
    <router-link v-bind:to="{ name: 'test3' }">
      <b-button variant="primary"> test3</b-button>
    </router-link>
    <router-link v-bind:to="{ name: 'test2' }">
      <b-button variant="primary"> test2</b-button>
    </router-link>
    <router-link v-bind:to="{ name: 'graphCreate' }">
      <b-button variant="primary"> graphCreate</b-button>
    </router-link>
    <router-link v-bind:to="{ name: 'graphSubmit' }">
      <b-button variant="primary"> graphSubmit</b-button>
    </router-link>
    <router-link v-bind:to="{ name: 'graphList' }">
      <b-button variant="primary"> graphList</b-button>
    </router-link>
  </div>
</template>

