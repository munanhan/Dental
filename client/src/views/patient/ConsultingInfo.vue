<template>
  <div>
    aasdasda
  </div>
</template>

<script>
export default {
  name: "ConsultingInfo",
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
        that.getConsultingInfo();
      }
    }
  },
  computed: {},
  methods: {
    getConsultingInfo() {},

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