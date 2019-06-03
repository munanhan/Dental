<template>
  <div class="yuyue-list" >
    <el-table :data="listData" height="100%" border style="width: 100%">
      <el-table-column prop="status" label="状态" width="80">
        <template slot-scope="scope" >
          <span v-if="scope.row.status == '3'"><i class="fas fa-exclamation-triangle" style="color:red;background-color:#fff;"></i>过期</span>
          <span v-if="scope.row.status == '2'"><i class="fas fa-warehouse" style="color:red;background-color:#fff;"></i>到达</span>
          <span v-if="scope.row.status == '1'"><i class="far fa-thumbs-up" style="color:red;background-color:#fff;"></i>确认</span>
          <span v-if="scope.row.status == '0'"><i class="far fa-clock" style="color:red;background-color:#fff;"></i>预约</span>
        </template>
        
      </el-table-column>
      <el-table-column prop="appointment_date" label="预约日期" width="120"></el-table-column>
      <el-table-column prop="start_time" label="预约时间" width="80"></el-table-column>
      <el-table-column prop="over_time" label="结束时间" width="80"></el-table-column>
      <el-table-column prop="appointment_doctor" label="预约医生" width="80"></el-table-column>
      <el-table-column prop="type" label="就诊类型" width="80">
        <template slot-scope="scope">{{scope.row.type == "1"?"复诊":"初诊"}}</template>
      </el-table-column>
      <el-table-column prop="patient_name" label="患者姓名" width="100"></el-table-column>
      <el-table-column prop="case_id" label="病历号" width="120"></el-table-column>
      <el-table-column prop="items" label="事项" width="120"></el-table-column>
      <el-table-column prop="patient_sex" label="性别" width="80"></el-table-column>
      <el-table-column prop="patient_source" label="患者来源" width="80"></el-table-column>
      <el-table-column prop="patient_phone" label="电话" width="120"></el-table-column>
      <el-table-column prop="created_by" label="创建人" width="90"></el-table-column>
      <el-table-column prop="created_at" label="创建日期" ></el-table-column>
    </el-table>
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
  },
  data() {
    return {
      listData: []
    };
  },

  methods: {}
};
</script>

<style lang="less">
.list {
  width: 100%;
  background-color: #fff;
}
.yuyue-list {
  width: 100%;
  height: 100%;
}
</style>
