<template>
    <div>患者回收站</div>
</template>

<script>
export default {
    name: 'PatientRecyclingBin',
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
            that.getPatientInfo();
          }
        }
      },
      computed: {},
      methods: {
        getPatientInfo() {
          let that = this;

          that.$api.aaaa.aaaa
            .then(res => {
              that.getDataDone();
            })
            .catch(res => {
              that.getDataDone();
            });
        },

        getDataDone() {
          setTimeout(() => {
            that.$emit("update:refresh", false);
          }, 6e3);
        }
      }
}
</script>
<style lang="less" scoped>

</style>