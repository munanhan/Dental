<template>
  <div class="outside-content">
    <el-table
      border
      class="outside-tab"
      :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
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
    <div class="outside-top" style="font-size:20px">

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
        :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
      >
        <el-table-column
          prop="date"
          label="牙位"
          align="center"
          width="300"
        >
        </el-table-column>
        <el-table-column
          prop="name"
          label="加工类型"
          align="center"
          width="600"
        >
        </el-table-column>
        <el-table-column
          prop="address"
          align="center"
          label="色号"
        >
        </el-table-column>
      </el-table>
    </div>
    <div class="outside-bottom">
      <el-button
        type="primary"
        style="margin-left:10px;width: 90px;"
        @click="Change_psw"
      >新增</el-button>
      <el-button class="outside-button">修改</el-button>
      <el-button type="danger">添加矫正</el-button>
      <el-button class="outside-button">删除</el-button>
    </div>
    <add-outside-processing :show.sync="changepw_show"></add-outside-processing>
  </div>
</template>

<script>
import AddOutsideProcessing from "./AddOutsideProcessing";
export default {
  name: "OutsideProcessing",
  components: {
    AddOutsideProcessing
  },
  props: {
    refresh: {
      type: Boolean,
      required: true,
    }
  },
  data() {
    return {
      changepw_show:false,
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
    },
    Change_psw() {
      this.changepw_show = true;
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
//   /deep/ .el-table th,
// .el-table tr {
//   background-color: #e5e5e5;
// }
}
/deep/ .el-alert__title{
  font-size: 15px
}
</style>