<template>
  <div class="image-content">
    <div class="image-top">
      <div
        class="block"
        style="float:right;margin-right:10px"
      >
        <div  class="mr-10">
          <span style="margin-top:10px;color:#acacac;margin-right:5px">日期</span>
            <el-date-picker
            style="margin-right:40px"
              v-model="search.dateRange"
              type="daterange"
              unlink-panels
              range-separator="至"
              start-placeholder="开始日期"
              end-placeholder="结束日期"
              :picker-options="pickerOptions"
              format="yyyy-MM-dd"
              value-format="yyyy-MM-dd"
              :clearable="false"
            >
            </el-date-picker>
          <el-slider
            v-model="value3"
            :show-tooltip="false"
            style="width:100px;margin-right:20px"
          ></el-slider>
          <el-button>刷新</el-button>
        </div>
      </div>
    </div>
    <div class="image-middle">
      asd
    </div>
    <div class="image-bottom">

      <el-button
        type="primary"
        style="margin-left:10px;width:90px"
        @click="autom_import"
      >自动导入</el-button>
      <el-button class="image-button">手动导入</el-button>
      <el-select
        v-model="other"
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
        v-model="image_class"
        placeholder="影像分类"
        class="image-button"
        style="width:110px"
      >
        <el-option
          v-for="item in image"
          :key="item.value"
          :label="item.label"
          :value="item.value"
        >
        </el-option>
      </el-select>
      <el-select
        v-model="profess_tools"
        placeholder="专业工具"
        class="image-button"
        style="width:110px"
      >
        <el-option
          v-for="item in professional"
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
       value3: '',
      search: {
        dateRange: [new Date(), new Date()]
      },
      image: [
        {
          value: "选项1",
          label: "正畸分类"
        },
        {
          value: "选项2",
          label: "美学分类"
        }
      ],
      image_class: "",
      professional: [
        {
          value: "选项1",
          label: "微笑设计"
        },
        {
          value: "选项2",
          label: "美牙秀"
        },
        {
          value: "选项3",
          label: "投影测量"
        }
      ],
      profess_tools: "",
      other: "",
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
      value: "",
      value1: [new Date(), new Date()]
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
    position: relative;
    height: 42px;
    background-color: #f3f1f1;
  }
  .image-middle {
    border: 1px solid rgb(185, 182, 182);
    height: 761px;
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
.mr-10 {
  display: flex;
}
</style>