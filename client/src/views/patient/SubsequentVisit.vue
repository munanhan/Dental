<template>
  <el-dialog
    title="初诊"
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
          @tab-click="handleClick"
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
          <el-tab-pane
            label="患者信息"
            name="third"
          >角色管理</el-tab-pane>
          <el-tab-pane
            label="处置记录"
            name="fourth"
          >定时任务补偿</el-tab-pane>
          <el-tab-pane
            label="回访记录"
            name="5"
          >用户管理</el-tab-pane>
          <el-tab-pane
            label="收费信息"
            name="6"
          >用户管理</el-tab-pane>
          <el-tab-pane
            label="外加工记录"
            name="7"
          >用户管理</el-tab-pane>
          <el-tab-pane
            label="影像信息"
            name="8"
          >定时任务补偿</el-tab-pane>
          <el-tab-pane
            label="电网咨询"
            name="9"
          >用户管理</el-tab-pane>
          <el-tab-pane
            label="咨询沟通"
            name="0"
          >用户管理</el-tab-pane>
          <el-tab-pane
            label="病历信息"
            name="11"
          >用户管理</el-tab-pane>
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
        @click="changePassword"
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

      rules: {}
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