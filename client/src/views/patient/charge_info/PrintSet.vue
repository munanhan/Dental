<template>
  <el-dialog
    title="票据打印格式设置"
    :visible.sync="show"
    width="30%"
    :close-on-click-modal="false"
    class="custom-dialog"
    center
    v-dialog-drag
  >
    <span>这是一段信息</span>
    <span
      slot="footer"
      class="dialog-footer"
    >
      <el-button @click="dialogClose">取 消</el-button>
      <el-button
        type="primary"
      >确 定</el-button>
    </span>
  </el-dialog>
</template>

<script>
export default {
  props: ["show"],
  created() {},
  data() {
    return {
      dialogVisible: false
    };
  },
  methods: {
    dialogClose() {
      this.$emit("update:show", false);
    },
    // handleClose(done) {
    //   this.$confirm("确认关闭？")
    //     .then(_ => {
    //       this.dialogClose();
    //       done();
    //     })
    //     .catch(_ => {});
    // }
  }
};
</script>
