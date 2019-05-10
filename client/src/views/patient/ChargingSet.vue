<template>
  <el-dialog
    title="收费设置"
    :visible.sync="show"
    width="550px"
    :before-close="handleClose"
    class="custom-dialog"
    center
    v-dialog-drag
  >
    <div class="chargeset-content">
      <div class="firstline">
        <div class="firstline-first">
          当前收费方式
        </div>
        <div class="firstline-first">
          分类收费 - 不启用划价
        </div>
        <el-button
          class="firstline-button"
          type="primary"
        >修改收费方式</el-button>
      </div>

      <!-- 第二行 -->
      <div class="secondline">
        <div class="secondline-first">
          其他设置
        </div>
        <el-checkbox
          class="secondline-checkbox"
          v-model="checked1"
        >打印时包含未收完明细</el-checkbox>
        <el-checkbox
          class="secondline-checkbox"
          v-model="checked2"
        >启用欠款模板</el-checkbox>
      </div>
      <div class="secondline">
        <!-- 第三行 -->
        <el-checkbox
          class="third-checkbox"
          v-model="checked1"
        >是否启用医保</el-checkbox>

      </div>
    </div>

    <span
      slot="footer"
      class="dialog-footer"
    >
      <el-button
        type="primary"
        @click="dialogClose"
      >确 定</el-button>
      <el-button @click="dialogClose">取 消</el-button>
    </span>
  </el-dialog>
</template>

<script>
export default {
  props: ["show"],
  created() {},
  data() {
    return {
      dialogVisible: false,
      checked1:"",
      checked2:"",
    };
  },
  methods: {
    dialogClose() {
      this.$emit("update:show", false);
    },
    handleClose(done) {
      this.$confirm("确认关闭？")
        .then(_ => {
          this.dialogClose();
          done();
        })
        .catch(_ => {});
    }
  }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";
.chargeset-content {
  font-size: 15px;
  .firstline {
    display: flex;
    .firstline-first {
      margin-right: 30px;
      margin-top: 10px;
    }
    .firstline-button {
      margin-left: 30px;
    }
  }
  .secondline {
    display: flex;
    margin-top: 50px;
    .secondline-first {
      margin-right: 30px;
    }
    .secondline-checkbox {
      margin-left: 20px;
    }
  }
  .third-checkbox {
  }
}
</style>
