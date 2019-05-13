<template>
  <el-dialog
    title="复诊"
    :visible.sync="show"
    :before-close="closeDialog"
    class="custom-dialog"
    v-dialog-drag
    width="1000px"
  >
    <div class="initDiag-content">
      <div class="left">
        <el-tabs
          v-model="activeName"
        >
          <el-tab-pane
            label="病历模板"
            name="medicalTemplates"
          >
            <medical-templates></medical-templates>
          </el-tab-pane>
          <el-tab-pane
            label="病历词条"
            name="second"
          >配置管理</el-tab-pane>
          
        </el-tabs>
      </div>
      <div class="right">
          
      </div>
    </div>

    <div
      slot="footer"
      class="dialog-footer"
    >
      <el-button @click="closeDialog">取 消</el-button>
      <el-button
        :loading="commitLoading"
        type="primary"
      >确 定</el-button>
    </div>
  </el-dialog>
</template>

<script>
import DialogForm from "../base/DialogForm";
export default {
  name: "InitialDiagnosis",

  mixins: [DialogForm],

  data() {
    return {
      activeName: "SubsequentVisit",
      medicalTemplates:"",

      rules: {

      }
    };
  },

  methods: {
   
  }
};
</script>
<style lang="less" scoped>
.initDiag-content {
  display: flex;
  .left {
    border: 1px solid rgb(224, 224, 224);
    position: relative;
    width: 425px;
    height: 500px;
  }
  .right {
    border: 1px solid rgb(224, 224, 224);
    position: absolute;
    right: 0;
    width: 540px;
    margin-right: 10px;
    height: 500px;
  }
}
</style>