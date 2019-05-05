<template>
  <el-dialog
    title="提示"
    :visible.sync="tuifeishow"
    width="30%"
    :before-close="handleClose"
  >
    <span>这是一段信息{{show}}</span>
    <span
      slot="footer"
      class="dialog-footer"
    >
      <el-button @click="tuifeishow = false">取 消</el-button>
      <el-button
        type="primary"
        @click="tuifeishow = false"
      >确 定</el-button>
    </span>
  </el-dialog>
</template>

<script>
export default {
//   prop: ["tuifeishow"],
  created() {
    //   console.log('-------'+ this.tuifeishow)
  },
  data() {
    return {
      dialogVisible: false
    };
  },
  methods: {
    handleClose(done) {
      this.$confirm("确认关闭？")
        .then(_ => {
          done();
        })
        .catch(_ => {});
    }
  }
};
</script>
