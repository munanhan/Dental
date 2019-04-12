<template>
  <div class="home">

    <el-row class="head">
      <el-col>
        <div
          class="head-item"
          @click="aaa"
        >
          <div>0</div>
          <div>日期</div>
        </div>
      </el-col>
      <el-col>
        <div
          class="head-item"
          @click="aaa"
        >
          <div>0</div>
          <div>日期</div>
        </div>
      </el-col>
      <el-col>
        <div
          class="head-item"
          @click="aaa"
        >
          <div>0</div>
          <div>日期</div>
        </div>
      </el-col>

    </el-row>

    

    <!-- <el-row style="cursor: pointer">
      <el-col :span="24">
        <div class="head">
          <el-col :span="5">
            <div class="item">今日总诊人数</div>
          </el-col>
          <el-col :span="5">
            <div class="item">今日初/复诊人数</div>
          </el-col>
          <el-col :span="4">
            <div class="item">今日回访</div>
          </el-col>
          <el-col :span="4">
            <div class="item">今日预约</div>
          </el-col>
          <el-col :span="4">
            <div class="item">今日新增关注</div>
          </el-col>
          <el-col :span="4">
            <div class="item">今日应收金额</div>
          </el-col>
          <el-col :span="4">
            <div class="item">今日实收金额</div>
          </el-col>
        </div>
      </el-col>
    </el-row> -->

    <div>
      <el-row
        :gutter="24"
        style="cursor: pointer"
      >
        <el-col :span="5">
          <div
            class="bl"
            @click="aaaa('TodayWork')"
            :class="{ TodayWork: state.TodayWork }"
          >今日工作</div>
        </el-col>
        <el-col :span="5">
          <div
            class="bl"
            @click="aaaa('TodayWaitingReturnVisit')"
            :class="{ TodayWork: state.TodayWaitingReturnVisit }"
          >今日待回访</div>
        </el-col>
        <el-col :span="4">
          <div
            class="bl"
            @click="aaaa('ccc')"
            :class="{ TodayWork: state.ccc }"
          >今日到件</div>
        </el-col>
        <el-col :span="4">
          <div
            class="bl"
            @click="aaaa('ddd')"
            :class="{ TodayWork: state.ddd }"
          >今日结算</div>
        </el-col>
        <el-col :span="4">
          <div
            class="bl"
            @click="aaaa('eee')"
            :class="{ TodayWork: state.eee }"
          >今日生日</div>
        </el-col>
      </el-row>

      <div>
        <div v-if="state.TodayWork">
          <template>
            <el-table
              :data="tableData"
              border
              style="width: 100%"
              :header-cell-style="{background:'#DDDDDD',color:'#000000'}"
            >
              <el-table-column
                prop="date"
                label="操作"
                width="80"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="患者姓名"
                width="150"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="状态"
                width="80"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="病历情况"
                width="150"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="病历号"
                width="90"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="address"
                label="就诊时间"
                width="150"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="预约时间"
                width="150"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="address"
                label="预约事项"
                width="150"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="医生"
                width="80"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="address"
                label="电话"
                width="80"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="address"
                label="就诊状态"
                width="150"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="应收"
                width="120"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="address"
                label="实收"
                align="center"
              >
              </el-table-column>
            </el-table>
          </template>
        </div>

        <div v-if="state.TodayWaitingReturnVisit">

          <template>
            <el-table
              :data="tableData"
              border
              style="width: 100%"
              :header-cell-style="{background:'#DDDDDD',color:'#000000'}"
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
                label="患者姓名"
                width="200"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="电话"
                width="100"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="回访日期"
                width="220"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="回访人"
                width="90"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="address"
                label="主治医生"
                width="200"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="回访内容"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="address"
                label="回访结果"
                width="200"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="回访状态"
                width="200"
                align="center"
              >
              </el-table-column>
            </el-table>
          </template>

        </div>

        <div v-if="state.ccc">
          <template>
            <el-table
              :data="tableData"
              border
              style="width: 100%"
              :header-cell-style="{background:'#DDDDDD',color:'#000000'}"
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
                width="100"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="患者姓名"
                width="130"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="电话"
                width="130"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="病历号"
                width="130"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="address"
                label="加工单位"
                width="150"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="加工单号"
                width="150"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="address"
                label="取件人"
                width="130"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="送件日期"
                width="150"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="回件日期"
                width="150"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="加工颗数"
                width="150"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="医生"
                align="center"
              >
              </el-table-column>
            </el-table>
          </template>
        </div>
        <div v-if="state.ddd">

          <template>
            <el-table
              :data="tableData"
              border
              style="width: 100%"
              :header-cell-style="{background:'#DDDDDD',color:'#000000'}"
            >
              <el-table-column
                prop="date"
                label="收费时间"
                width="240"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="患者姓名"
                width="240"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="病历号"
                width="210"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="医生"
                width="210"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="收银员"
                width="210"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="address"
                label="本次实收"
                width="200"
                align="center"
              >
              </el-table-column>
              <el-table-column
                prop="name"
                label="社保卡"
                align="center"
              >
              </el-table-column>
            </el-table>
          </template>
        </div>

        <div v-if="state.eee">

          <el-button
            type="success"
            style="float:right"
          >群发消息</el-button>

          <div class="table">
            <el-table
              border
              ref="multipleTable"
              :data="tableData1"
              tooltip-effect="dark"
              style="width: 100%"
              @selection-change="handleSelectionChange"
              :header-cell-style="{background:'#DDDDDD',color:'#000000'}"
            >
              <el-table-column
                type="selection"
                width="55"
              >
              </el-table-column>
              <el-table-column
                label="日期"
                width="120"
              >
                <template slot-scope="scope">{{ scope.row.date }}</template>
              </el-table-column>
              <el-table-column
                prop="name"
                label="姓名"
                width="120"
              >
              </el-table-column>
              <el-table-column
                prop="address"
                label="地址"
                show-overflow-tooltip
              >
              </el-table-column>
            </el-table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    name: 'Home',

  data() {
    return {
      state: {
        TodayWork: true,
        TodayWaitingReturnVisit: false,
        ccc: false,
        ddd: false,
        eee: false
      }
    };
  },

  created() {},

  methods: {
    // toggleSelection(rows) {
    //   if (rows) {
    //     rows.forEach(row => {
    //       this.$refs.multipleTable.toggleRowSelection(row);
    //     });
    //   } else {
    //     this.$refs.multipleTable.clearSelection();
    //   }
    // },
    // handleSelectionChange(val) {
    //   this.multipleSelection = val;
    // },
    resize() {
      let that = this;

      clearTimeout(that.chartTimer);

      // that.chartTimer = setTimeout(() => {
      //     that.chartHeight = that.$refs.blockContent.offsetHeight + "px";
      // }, 100);
    },

    aaaa(eeee) {
      let that = this;

      that.state["TodayWork"] = "TodayWork" == eeee;
      that.state["TodayWaitingReturnVisit"] = "TodayWaitingReturnVisit" == eeee;
      that.state["ccc"] = "ccc" == eeee;
      that.state["ddd"] = "ddd" == eeee;
      that.state["eee"] = "eee" == eeee;

      // for(var key in that.state){
      //     // that.$set()

      //     that.state[eeee] = (key == eeee);
      //     // console.log(key);
      //     // console.log((key == eeee))

      //     console.log(key);
      //     console.log(key == eeee)

      //     // that.$set(that.state, eeee, (key == eeee))

      //     console.log(that.state)
      // }

      // that.$forceUpdate();
    },

    getData() {
      let that = this;
    }
  }
};
</script>
<style lang="less" scoped>
.home {
}

.head {
  border: 1px solid #e3e3e3;
  padding: 10px;
  margin: 10px;
  height: 80px;
  line-height: 80px;
  display: flex;

//   .item {
//     text-align: center;
//   }
//   .item:last-of-type {
//     border: none;
//   }
}



.TodayWork {
  color: red;
}

.bl {
  border: 1px solid #e3e3e3;
  padding: 10px;
  height: 30px;
  line-height: 30px;
  margin: 10px;
}
</style>