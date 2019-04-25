<template>
  <div>
      <div style="width:1000px;margin-left:10px;margin-bottom:10px;" >
      </div>
      <div dis-bottom>
        <div style="border:1px solid #e4e4e4;background-color:#e3e3e3;position:absolute;left;0;bottom:0;width:100%;height:59px">

      <el-button style="width:130px;margin-left:10px" type="primary">增加处置</el-button>
      <el-button class="dis-button">打印设置</el-button>
    </div>
      </div>
  </div>
  
</template>

<script>
export default {
  name: "DisposalRecords",
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
        that.getDisposalRecords();
      }
    }
  },
  computed: {},
  methods: {
    getDisposalRecords() {},

    getDataDone() {
      setTimeout(() => {
        that.$emit("update:refresh", false);
      }, 6e3);
    }
  }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

.dis-button{
   width: 130px;
  margin-left: 10px;
  margin-top: 10px;
}
</style>