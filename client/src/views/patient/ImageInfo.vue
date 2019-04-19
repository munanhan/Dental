<template>
  <div class="image-content">
    <div class="image-top">
      asd
    </div>
    <div class="image-middle">
      asd
    </div>
    <div class="image-bottom">

      <el-button type="success" style="margin-left:10px;width: 90px;">自动导入</el-button>
      <el-button class="image-button">手动导入</el-button>
      <el-button class="image-button">其他</el-button>
      <el-button class="image-button">内窥镜</el-button>
      <el-button class="image-button">牙智宝</el-button>
      <el-button class="image-button">设备对接</el-button>
      <el-button class="image-button">影响分类</el-button>
      <el-button class="image-button">专业工具</el-button>

    </div>
  </div>
</template>

<script>
export default {
  name: "ImageInfo",
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
        that.getImageInfo();
      }
    }
  },
  computed: {},
  methods: {
    getImageInfo() {},

    getDataDone() {
      setTimeout(() => {
        that.$emit("update:refresh", false);
      }, 6e3);
    }
  }
};
</script>
<style lang="less" scoped>
.image-content {
    box-sizing: border-box;
  .image-top {
    border: 1px solid red;
    position: relative;
    height: 40px;
    background-color: #f3f1f1;
  }
  .image-middle {
    border: 1px solid red;
    height: 350px;
  }
  .image-bottom {
    background-color: #dedede;
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%;
    height: 59px;
    .image-button {
      border: 1px solid green;
      margin-left: 10px;
      margin-top: 10px;
      width: 90px;
    }
  }
}
</style>