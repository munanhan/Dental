<template>
  <div class="yuyue-list">
    <el-table
      :data="listData"
      border
      class="width100 mb-10 sheet-table"
      :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
    >
      <el-table-column prop="status" label="状态" align="center" show-overflow-tooltip>
        <template slot-scope="scope">
          <span v-if="scope.row.status == '4'">
            <i class="fas fa-times-circle" style="color:#ff3646;background-color:#fff;"></i>流失
          </span>
          <span v-if="scope.row.status == '3'">
            <i class="fas fa-exclamation-triangle" style="color:#f17e1a;background-color:#fff;"></i>过期
          </span>
          <span v-if="scope.row.status == '2'">
            <i class="fas fa-warehouse" style="color:rgb(50, 17, 233);background-color:#fff;"></i>到达
          </span>
          <span v-if="scope.row.status == '1'">
            <i class="far fa-thumbs-up" style="color:rgb(160, 101, 238);background-color:#fff;"></i>确认
          </span>
          <span v-if="scope.row.status == '0'">
            <i class="far fa-clock" style="color:#6bb15e;background-color:#fff;"></i>预约
          </span>
        </template>
      </el-table-column>
      <el-table-column prop="appointment_date" label="预约日期" align="center" show-overflow-tooltip></el-table-column>
      <el-table-column prop="start_time" label="预约时间" align="center" show-overflow-tooltip></el-table-column>
      <el-table-column prop="over_time" label="结束时间" align="center" show-overflow-tooltip></el-table-column>
      <el-table-column prop="appointment_doctor" label="预约医生" align="center" show-overflow-tooltip></el-table-column>
      <el-table-column prop="type" label="就诊类型" align="center" show-overflow-tooltip>
        <template slot-scope="scope">{{scope.row.type == "1"?"复诊":"初诊"}}</template>
      </el-table-column>
      <el-table-column prop="patient_name" label="患者姓名" align="center" show-overflow-tooltip></el-table-column>
      <el-table-column prop="case_id" label="病历号" align="center" show-overflow-tooltip></el-table-column>
      <el-table-column prop="items" label="事项" align="center" show-overflow-tooltip></el-table-column>
      <el-table-column prop="patient_sex" label="性别" align="center" show-overflow-tooltip></el-table-column>
      <el-table-column prop="patient_source" label="患者来源" align="center" show-overflow-tooltip></el-table-column>
      <el-table-column prop="patient_phone" label="电话" align="center" show-overflow-tooltip></el-table-column>
      <el-table-column prop="created_by" label="创建人" align="center" show-overflow-tooltip></el-table-column>
      <el-table-column prop="created_at" label="创建日期" align="center" show-overflow-tooltip></el-table-column>
    </el-table>
    <el-row class="pager" type="flex" justify="end">
      <el-pagination
        @current-change="changePage"
        @size-change="pageSizeChange"
        background
        layout="total, sizes, prev, pager, next, jumper"
        :page-sizes="[10, 20, 50, 100, 200]"
        :page-size="pager.size"
        :total="pager.total"
        :current-page="pager.current"
      ></el-pagination>
    </el-row>
  </div>
</template>

<script>
import Bus from "@/assets/Bus.js";
export default {
  name: "",
  created() {
    let self = this;
    Bus.$on("tableData", function(val) {
      self.listData = val;
    });
    Bus.$on("total", function(val) {
      self.pager.total = val;
      console.log(val)
    });
  },
  data() {
    return {
      listData: [],
      pager: {
        total: 0,
        current: 1,
        size: 50
      }
    };
  },
  watch: {
    // pager:{
    //   handler:function(val,oldVal){
    //     console.log(val);
    //   },
    //   deep:true
    // }
  },
  methods: {
    changePage(index) {
      let that = this;

      if (that.pager) {
        that.pager.current = index;
        Bus.$emit("pager_current", index);
        // that.getData();
      }
    },

    pageSizeChange(val) {
      let that = this;

      if (that.pager) {
        that.pager.size = val;
        Bus.$emit("pager_size", val);
        // that.getData();
      }
    }
    // getData() {
    //   let that = this;
    //   let parms = {};

    //   parms.dtfm =
    //     typeof that.search.dateRange[0] == "object"
    //       ? that.search.dateRange[0].toLocaleDateString()
    //       : that.search.dateRange[0];
    //   parms.dtto =
    //     typeof that.search.dateRange[1] == "object"
    //       ? that.search.dateRange[1].toLocaleDateString()
    //       : that.search.dateRange[1];
    //   parms.doctor_id = that.search.doctor;

    //   parms.current_page = that.pager.current;

    //   parms.page_size = that.pager.size;

    //   that.$api.flow_sheet
    //     .get(parms)
    //     .then(res => {
    //       if (res.code == 200) {
    //         that.tableData = res.data.row;
    //         that.pager.total = res.data.total;
    //       } else {
    //         that.$message.error(res.msg || "get error.");
    //       }
    //     })
    //     .catch(res => {
    //       // console.log(res);
    //     });
    // }
  }
};
</script>

<style lang="less">
.yuyue-list {
  width: 100%;
  height: 100%;
}
</style>
