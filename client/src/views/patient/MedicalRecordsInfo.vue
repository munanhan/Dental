<template>
  <div>adasdasbbbbbbbbb</div>
</template>

<script>
export default {
  name: "MedicalRecordsInfo",
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
        that.getMedicalRecordsInfo();
      }
    }
  },
  computed: {},
  methods: {
    getMedicalRecordsInfo() {},

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