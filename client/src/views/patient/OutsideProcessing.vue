<template>
  <div>dasd2301.0</div>
</template>

<script>
export default {
  name: "OutsideProcessing",
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
        that.getOutsideProcessing();
      }
    }
  },
  computed: {},
  methods: {
    getOutsideProcessing() {},

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