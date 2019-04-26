<template>
  <div class="medical-content">
    <div class="medical-top">
      adasd
    </div>
    <div class="medical-bottom">
      <div class="image-bottom">

        <el-button
          type="primary"
          style="margin-left:10px;width: 90px;"
          @click="int_diagn"
        >初诊</el-button>
        <el-button class="medical-button" @click="sub_visit">复诊</el-button>

        <el-select
          v-model="value"
          class="medical-button"
          style="width:150px"
          placeholder="口腔检查"
        >
          <el-option
            v-for="item in options"
            :key="item.value"
            :label="item.label"
            :value="item.value"
          >
          </el-option>
        </el-select>

        <el-button class="medical-button">风险评估</el-button>
        <el-button class="medical-button">其它</el-button>
        <el-button class="medical-button">知情同意书</el-button>
        <el-button class="medical-button">正畸病历</el-button>
      </div>
    </div>
    <initial-diagnosis :show.sync="intdiag_show"></initial-diagnosis>
    <subsequent-visit :show.sync="subvisit_show"></subsequent-visit>
  </div>
</template>

<script>
import InitialDiagnosis from "./InitialDiagnosis";
import SubsequentVisit from "./SubsequentVisit";
export default {
  name: "MedicalRecordsInfo",
  components: {
    InitialDiagnosis,
    SubsequentVisit
  },
  props: {
    refresh: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {
      options: [{
          value: '选项1',
          label: '口腔检查'
        }, {
          value: '选项2',
          label: '治疗计划'
        }, {
          value: '选项3',
          label: '牙周检查'
        }],
        value: '',
        intdiag_show:false,
        subvisit_show:false
    };
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
    },
    //初诊
     int_diagn(){
      this.intdiag_show = true;
    },
    //复诊
    sub_visit(){
      this.subvisit_show = true;
    }
  }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

.medical-content {
  .medical-top {
    border: 1px solid red;
    position: relative;
    height: 799px;
    background-color: #ebe6e6;
  }

  .medical-bottom {
    background-color: #dedede;
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%;
    height: 61px;
    .medical-button {
      margin-left: 10px;
      margin-top: 10px;
      width: 100px;
    }
  }
}
</style>