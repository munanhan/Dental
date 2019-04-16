<template>
  <div>
      adasdasdadas
  </div>
</template>

<script>
export default {
  name: "ChargeInfo",
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
        that.getChargeInfo();
      }
    }
  },
  computed: {},
  methods: {
    getChargeInfo() {},

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