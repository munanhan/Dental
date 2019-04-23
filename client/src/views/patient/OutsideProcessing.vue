<template>
  <div class="outside-content">
    <el-table
      border
      class="outside-tab"
    >
      <el-table-column
        prop="date"
        label="操作"
        width="100"
        align="center"
      >
      </el-table-column>
      <el-table-column
        prop="name"
        label="状态"
        width="90"
        align="center"
      >
      </el-table-column>
      <el-table-column
        prop="address"
        label="加工单位"
        align="center"
        width="180"
      >
      </el-table-column>
      <el-table-column
        prop="date"
        label="取件人"
        width="120"
        align="center"
      >
      </el-table-column>
      <el-table-column
        prop="name"
        label="送件日期"
        width="140"
        align="center"
      >
      </el-table-column>
      <el-table-column
        prop="address"
        label="回件日期"
        width="140"
        align="center"
      >
      </el-table-column>
      <el-table-column
        prop="date"
        label="加工颗数"
        width="110"
        align="center"
      >
      </el-table-column>
      <el-table-column
        prop="name"
        label="医生"
        width="90"
        align="center"
      >
      </el-table-column>
      <el-table-column
        prop="address"
        label="对患者价"
        width="120"
        align="center"
      >
      </el-table-column>
      <el-table-column
        prop="date"
        label="加工单位"
        width="110"
        align="center"
      >
      </el-table-column>
      <el-table-column
        prop="name"
        label="加工工厂"
        width="110"
        align="center"
      >
      </el-table-column>
      <el-table-column
        prop="address"
        label="备注"
        align="center"
        width="200"
      >
      </el-table-column>
    </el-table>
    <div class="outside-top">

      <el-alert
        title="外加工明细"
        :closable="false"
      >
      </el-alert>
    </div>
    <div class="outside-middle">
      <el-table
        border
        style="width: 100%"
      >
        <el-table-column
          prop="date"
          label="日期"
          width="180"
        >
        </el-table-column>
        <el-table-column
          prop="name"
          label="姓名"
          width="180"
        >
        </el-table-column>
        <el-table-column
          prop="address"
          label="地址"
        >
        </el-table-column>
      </el-table>
    </div>
    <div class="outside-bottom">
      <el-button
        type="primary"
        style="margin-left:10px;width: 90px;"
      >新增</el-button>
      <el-button class="outside-button">修改</el-button>
      <el-button type="danger">添加矫正</el-button>
      <el-button class="outside-button">删除</el-button>
    </div>
  </div>
</template>

<script>
export default {
  name: "OutsideProcessing",
  components: {},
  props: {
    refresh: {
      type: Boolean,
      required: true
    }
  },
  data() {
    return {
      //   tableData: [
      //     {
      //       date: "2016-05-02",
      //       name: "王小虎",
      //       address: "上海市普陀区金沙江路 1518 弄"
      //     },
      //     {
      //       date: "2016-05-04",
      //       name: "王小虎",
      //       address: "上海市普陀区金沙江路 1517 弄"
      //     },
      //     {
      //       date: "2016-05-01",
      //       name: "王小虎",
      //       address: "上海市普陀区金沙江路 1519 弄"
      //     },
      //     {
      //       date: "2016-05-03",
      //       name: "王小虎",
      //       address: "上海市普陀区金沙江路 1516 弄"
      //     }
      //   ]
    };
  },
  created() {},
  mounted() {},
  watch: {
    refresh(newValue, oldValue) {
      let that = this;

      if (newValue) {
        that.getOutsideProcessing();
      }
    }
  },
  computed: {},
  methods: {
    getOutsideProcessing() {},

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

/deep/ .el-table__body-wrapper {
  height: 550px;
}

.outside-content {
//   border: 1px solid red;
  box-sizing: border-box;
  .outside-tab {
    width: 100%;
  }
//   .outside-top {
//   }
//   .outside-middle {
//   }
  .outside-bottom {
    position: absolute;
    left: 0;
    bottom: 0;
    height: 61px;
    width: 100%;
    background-color: #e3e3e3;
    .outside-button {
      margin-left: 10px;
      margin-top: 10px;
      width: 90px;
    }
  }
}
</style>