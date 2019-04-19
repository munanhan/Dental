<template>
  <div class="medical-content">
    <div class="medical-top">
      adasd
    </div>
    <div class="medical-bottom">
      <div class="image-bottom">

        <el-button
          type="success"
          style="margin-left:10px;width: 90px;"
        >初诊</el-button>
        <el-button class="medical-button">复诊</el-button>
        <el-button class="medical-button">空腔检查</el-button>
        <el-button class="medical-button">风险评估</el-button>
        <el-button class="medical-button">其它</el-button>
        <el-button class="medical-button">知情同意书</el-button>
        <el-button class="medical-button">正畸病历</el-button>
      </div>
    </div>
  </div>
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
.medical-content {
  .medical-top {
    border: 1px solid red;
    position: relative;
    height: 40px;
    background-color: #f3f1f1;
  }

  .medical-bottom {
    background-color: #dedede;
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%;
    height: 61px;
    .medical-button {
      border: 1px solid green;
      margin-left: 10px;
      margin-top: 10px;
      width: 100px;
    }
  }
}
</style>