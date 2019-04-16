<template>
  <div>
      啊大苏打撒旦
  </div>
</template>

<script>
export default {
  name: "ImageInfo",
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
        that.getImageInfo();
      }
    }
  },
  computed: {},
  methods: {
    getImageInfo() {},

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