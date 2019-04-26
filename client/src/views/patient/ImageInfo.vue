<template>
  <div class="image-content">
    <div class="image-top">
      asd
    </div>
    <div class="image-middle">
      asd
    </div>
    <div class="image-bottom">

      <el-button
        type="primary"
        style="margin-left:10px;width: 90px;"
        @click="autom_import"
      >自动导入</el-button>
      <el-button class="image-button">手动导入</el-button>
      <el-select
        v-model="value"
        placeholder="其他"
        class="image-button"
      >
        <el-option
          v-for="item in options"
          :key="item.value"
          :label="item.label"
          :value="item.value"
        >
        </el-option>
      </el-select>
      <el-button class="image-button">内窥镜</el-button>
      <el-button class="image-button">牙智宝</el-button>
      <el-button class="image-button">设备对接</el-button>
      <el-select
        v-model="value"
        placeholder="影像分类"
        class="image-button"
        style="width:110px"
      >
        <el-option
          v-for="item in options"
          :key="item.value"
          :label="item.label"
          :value="item.value"
        >
        </el-option>
      </el-select>
      <el-select
        v-model="value"
        placeholder="专业工具"
        class="image-button"
        style="width:110px"
      >
        <el-option
          v-for="item in options"
          :key="item.value"
          :label="item.label"
          :value="item.value"
        >
        </el-option>
      </el-select>

    </div>
    <automatic-import :show.sync="autoimp_show"></automatic-import>
  </div>
</template>

<script>
import AutomaticImport from "./AutomaticImport";
export default {
  name: "ImageInfo",
  components: {
    AutomaticImport
  },
  props: {
    refresh: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {
      autoimp_show: false,
      options: [
        {
          value: "选项1",
          label: "导出"
        },
        {
          value: "选项2",
          label: "删除"
        },
        {
          value: "选项3",
          label: "打印"
        }
      ],
      value: ""
    };
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
    },
    autom_import() {
      this.autoimp_show = true;
    }
  }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

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
    height: 759px;
  }
  .image-bottom {
    background-color: #dedede;
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%;
    height: 59px;
    .image-button {
      margin-left: 10px;
      margin-top: 10px;
      width: 100px;
    }
  }
}
</style>