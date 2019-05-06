<template>
  <div class="yuyue-list">
    <el-table :data="listData" height="250" border style="width: 100%">
      <el-table-column prop="date" label="状态" width="120"></el-table-column>
      <el-table-column prop="name" label="预约日期" width="80"></el-table-column>
      <el-table-column prop="name" label="预约时间" width="80"></el-table-column>
      <el-table-column prop="name" label="结束时间" width="80"></el-table-column>
      <el-table-column prop="name" label="预约医生" width="80"></el-table-column>
      <el-table-column prop="name" label="就诊类型" width="80"></el-table-column>
      <el-table-column prop="name" label="患者姓名" width="80"></el-table-column>
      <el-table-column prop="name" label="病历号" width="80"></el-table-column>
      <el-table-column prop="name" label="事项" width="80"></el-table-column>
      <el-table-column prop="name" label="性别" width="80"></el-table-column>
      <el-table-column prop="name" label="患者来源" width="80"></el-table-column>
      <el-table-column prop="name" label="电话1" width="90"></el-table-column>
      <el-table-column prop="name" label="电话2" width="90"></el-table-column>
      <el-table-column prop="name" label="创建人" width="90"></el-table-column>
      <el-table-column prop="name" label="创建日期" width="90"></el-table-column>
      <el-table-column prop="address" label="地址"></el-table-column>
    </el-table>
  </div>
</template>

<script>
export default {
  name: "",

  data() {
    return {
      listData: [
        {
          date: "2016-05-03",
          name: "王小虎",
          address: "上海市普陀区金沙江路 1518 弄"
        },
        {
          date: "2016-05-02",
          name: "王小虎",
          address: "上海市普陀区金沙江路 1518 弄"
        },
        {
          date: "2016-05-04",
          name: "王小虎",
          address: "上海市普陀区金沙江路 1518 弄"
        },
        {
          date: "2016-05-01",
          name: "王小虎",
          address: "上海市普陀区金沙江路 1518 弄"
        },
        {
          date: "2016-05-08",
          name: "王小虎",
          address: "上海市普陀区金沙江路 1518 弄"
        },
        {
          date: "2016-05-06",
          name: "王小虎",
          address: "上海市普陀区金沙江路 1518 弄"
        },
        {
          date: "2016-05-07",
          name: "王小虎",
          address: "上海市普陀区金沙江路 1518 弄"
        }
      ]
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
}
</style>
