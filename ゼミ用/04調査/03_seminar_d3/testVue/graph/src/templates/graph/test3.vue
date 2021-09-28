<template>
  <div class="content" @click="clickCell($event)">
    <d3-network
      :net-nodes="nodes"
      :net-links="links"
      :options="options"
      :node-cb="formatNode"
    >
    </d3-network>
  </div>
</template>

<script type="module">
//import { ApiURL } from "../../constants/ApiURL.js";
//import { CommonUtils } from "../../common/CommonUtils.js";
// import { VueFaileName } from "../../constants/VueFaileName.js";
// import { VueLoading } from "vue-loading-template";
// import { D3Service } from "../../scripts/D3Service.js";
import D3Network from "vue-d3-network";

export default {
  data() {
    return {
      // nodes: [
      //   { id: 1, name: "my node 1" },
      //   { id: 2, name: "my node 2" },
      //   { id: 3, _color: "orange", _size: "50" },
      //   { id: 4 },
      //   { id: 5 },
      //   { id: 6 },
      //   { id: 7 },
      //   { id: 8 },
      //   { id: 9 },
      // ],
      // links: [
      //   { sid: 1, tid: 2, _color: "#1aad8d" },
      //   { sid: 2, tid: 3, _color: "#1aad8d" },
      //   { sid: 5, tid: 6, _color: "#1aad8d" },
      //   { sid: 6, tid: 5, _color: "#1aad8d" },
      //   { sid: 7, tid: 9, _color: "#1aad8d" },
      // ],
      nodes: [
        { id: 1, name: "my awesome node 1", ttt: "my awesome node 1" },
        { id: 2, name: "my node 2" },
        { id: 3, name: "orange node", _color: "orange" },
        { id: 4, _color: "#4466ff" },
        { id: 5 },
        { id: 6 },
        { id: 7 },
        { id: 8 },
        { id: 9 },
      ],
      links: [
        { sid: 1, tid: 2 },
        { sid: 2, tid: 8 },
        {
          sid: 3,
          tid: 4,
          _svgAttrs: { "stroke-width": 8, opacity: 1 },
          name: "custom link",
        },
        { sid: 4, tid: 5 },
        { sid: 5, tid: 6 },
        { sid: 7, tid: 8 },
        { sid: 5, tid: 8 },
        { sid: 3, tid: 8 },
        { sid: 7, tid: 9 },
      ],
      nodeSize: 40,
      canvas: false,
      force: 4000,
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
      this.force = (window.scrollY * 20) + 500
      console.log(this.force);
    },
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
  components: {
    D3Network,
  },
  mounted() {
    window.addEventListener("scroll", this.handleScroll);
  },
};
</script>

<style>
@import "../../style/d3-network.css";
</style>

