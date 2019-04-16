<template>
  <div>adasd3146814/</div>
</template>

<script>
export default {
  name: "ReturnVisitInfo",
  components: {},
  props: {
    refresh: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {};
  },
  created() {},
  mounted() {},
  watch: {
    refresh(newValue, oldValue) {
      let that = this;

      if (newValue) {
        that.getReturnVisitInfo();
      }
    }
  },
  computed: {},
  methods: {
    getReturnVisitInfo() {},

    getDataDone() {
      setTimeout(() => {
        that.$emit("update:refresh", false);
      }, 6e3);
    }
  }
};
</script>
<style lang="less" scoped>
</style>