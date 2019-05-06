<template>
  <div>
    <el-table
      border
      class="charge-top"
      :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
    >
      <div>
        <el-table-column
          prop="date"
          label="录音"
          width="180"
        >
        </el-table-column>
        <el-table-column
          prop="name"
          label="回访状态"
          width="180"
        >
        </el-table-column>
        <el-table-column
          prop="address"
          label="回访人"
        >
        </el-table-column>
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

      </div>
    </el-table>
    <div class="charge-bottom">
      <el-button
        class="button"
        type="primary"
      >收费</el-button>
      <el-button class="button">其他</el-button>
      <el-button class="button">预交款</el-button>
      <el-button class="button">流水单</el-button>
    </div>
    <!-- <div style="flex:">asd</div> -->
  </div>
</template>

<script>
export default {
  name: "ReturnVisitInfo",
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
        that.getChargeInfo();
      }
    }
  },
  computed: {},
  methods: {
    getChargeInfo() {},

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

.charge-top {
  width: 100%;
  height: 100%;
  margin: 0;
  padding: 0;
  position: relative;
}
.charge-bottom {
  height: 60px;
  position: absolute;
  left: 0;
  bottom: 0;
  background-color: #e3e3e3;
  width: 100%;
}

/deep/ .el-table__body-wrapper {
  height: 755px;
}

.button {
  width: 130px;
  margin-top: 10px;
  margin-left: 10px;
}
</style>