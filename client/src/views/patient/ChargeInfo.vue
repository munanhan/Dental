<template>
  <div>
    <el-table
      border
      class="charge-top"
    >
      <div>
        <el-table-column
          prop="date"
          label="状态"
          width="55"
          align="center"
        >
        </el-table-column>
        <el-table-column
          prop="name"
          label="单据号"
          width="80"
          align="center"
        >
        </el-table-column>
        <el-table-column
          prop="address"
          label="收费时间"
          align="center"
          width="160"
        >
        </el-table-column>
        <el-table-column
          prop="date"
          label="医生"
          width="60"
          align="center"
        >
        </el-table-column>
        <el-table-column
          prop="name"
          label="收款员"
          width="70"
          align="center"
        >
        </el-table-column>
        <el-table-column
          prop="address"
          label="本次费用"
          width="90"
          align="center"
        >
        </el-table-column>
        <el-table-column
          prop="date"
          label="实收金额"
          width="90"
          align="center"
        >
        </el-table-column>
        <el-table-column
          prop="name"
          label="折扣金额"
          width="90"
          align="center"
        >
        </el-table-column>
        <el-table-column
          prop="address"
          label="欠费"
          width="120"
          align="center"
        >
        </el-table-column>
        <el-table-column
          prop="date"
          label="账单时间"
          width="160"
          align="center"
        >
        </el-table-column>
        <el-table-column
          prop="name"
          label="护士"
          width="120"
          align="center"
        >
        </el-table-column>
        <el-table-column
          prop="address"
          label="备注"
          width="150"
          align="center"
        >
        </el-table-column>
      </div>
    </el-table>
    <div class="charge-bottom">
      <el-button
        class="button"
        type="success"
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
  name: "ChargeInfo",
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
  border: 1px solid green;
  margin-top: 10px;
  margin-left: 10px;
}
</style>