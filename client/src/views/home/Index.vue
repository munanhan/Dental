<template>
  <div class="home">
    <el-row class="head">
      <el-col class="num">
        <div class="head-item ">
          <div class="top">0</div>
          <div class="botton">今日总诊人数</div>
        </div>
      </el-col>
      <el-col class="num">
        <div class="head-item">
          <div class="top">0/0</div>
          <div class="botton">今日初/复诊人数</div>
        </div>
      </el-col>
      <el-col class="num">
        <div class="head-item">
          <div class="top">0</div>
          <div class="botton">今日回访</div>
        </div>
      </el-col>
      <el-col class="num">
        <div class="head-item">
          <div class="top">0</div>
          <div class="botton">今日预约</div>
        </div>
      </el-col>
      <el-col class="num">
        <div class="head-item">
          <div class="top">0</div>
          <div class="botton">今日新增关注</div>
        </div>
      </el-col>
      <el-col class="num">
        <div class="head-item">
          <div class="top">0</div>
          <div class="botton">今日应收金额</div>
        </div>
      </el-col>
      <el-col class="num">
        <div class="head-item">
          <div class="top">0</div>
          <div class="botton">今日实收金额</div>
        </div>
      </el-col>
    </el-row>
    <div>
      <el-row
        :gutter="24"
        style="padding:20px"
      >
        <div  style="border:1px solid #949090;padding:15px">
          <div>
            <el-col
              :span="5"
              style="padding-left:0px "
            >
              <div
                class="bl"
                @click="aaaa('today_work')"
                :class="{ today_work: state.today_work }"
              >
                <i class="fa fa-user-astronaut"></i> 今日工作
              </div>
            </el-col>

            <el-col
              :span="5"
              style="padding-right:20px "
            >
              <div
                class="bl"
                @click="aaaa('today_waiting_visit')"
                :class="{ today_work: state.today_waiting_visit }"
              >
                <i class="fa fa-phone-volume"></i> 今日待回访
              </div>
            </el-col>

            <el-col
              :span="4"
              style="padding-right:0px;padding-left:0px"
            >
              <div
                class="bl"
                @click="aaaa('ccc')"
                :class="{ today_work: state.ccc }"
              ><i class="fa fa-check-square"></i> 今日到件</div>
            </el-col>

            <el-col
              :span="5"
              style="padding-right:0px;padding-left:20px"
            >
              <div
                class="bl"
                @click="aaaa('ddd')"
                :class="{ today_work: state.ddd }"
              ><i class="fa fa-calendar-check"></i> 今日结算</div>
            </el-col>

            <el-col
              :span="5"
              style="padding-right:0px;padding-left:20px"
            >
              <div
                class="bl"
                @click="aaaa('eee')"
                :class="{ today_work: state.eee }"
              ><i class="fa fa-birthday-cake"></i> 今日生日</div>
            </el-col>
          </div>
          <!-- <div>
        <div class="aaaa">
          <div aaa></div>
          <div aaa></div>
          <div aaa></div>
          <div aaa></div>
          
          .aaa{
            padding: 0 10px;

            &:first-of-type{
              padding-left: 0;
            }

            &:last-of-type{
              padding-right: 0;
            }
          }
        </div>
        <div class="bbbb"></div>
      </div> -->

          <div v-if="state.today_work">
            <template>
              <el-table
                :data="tableData"
                border
                style="width: 100%"
                :header-cell-style="{background:'#D3CFCF',color:'#000000'}"
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

          <div v-if="state.today_waiting_visit">

            <template>
              <el-table
                :data="tableData"
                border
                style="width: 100%"
                :header-cell-style="{background:'#D3CFCF',color:'#000000'}"
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
                :header-cell-style="{background:'#D3CFCF',color:'#000000'}"
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
                :header-cell-style="{background:'#D3CFCF',color:'#000000'}"
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
              style="float:right;margin-bottom:10px"
            >群发消息</el-button>

            <div class="table">
              <el-table
                border
                ref="multipleTable"
                :data="tableData1"
                tooltip-effect="dark"
                style="width: 100%"
                @selection-change="handleSelectionChange"
                :header-cell-style="{background:'#D3CFCF',color:'#000000'}"
              >
                <el-table-column
                  type="selection"
                  width="80"
                  align="center"
                >
                </el-table-column>
                <el-table-column
                  label="操作"
                  width="120"
                  align="center"
                >
                  <template slot-scope="scope">{{ scope.row.date }}</template>
                </el-table-column>
                <el-table-column
                  prop="name"
                  label="患者姓名"
                  width="120"
                  align="center"
                >
                </el-table-column>
                <el-table-column
                  prop="address"
                  label="电话"
                  align="center"
                  show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                  prop="address"
                  label="病历号"
                  align="center"
                  show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                  prop="address"
                  label="出生年月"
                  align="center"
                  show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                  prop="address"
                  label="年龄"
                  align="center"
                  show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                  prop="address"
                  label="医生"
                  align="center"
                  show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                  prop="address"
                  label="最后发送时间"
                  align="center"
                  show-overflow-tooltip
                >
                </el-table-column>
              </el-table>
            </div>
          </div>
        </div>
      </el-row>
    </div>
  </div>
</template>

<script>
export default {
  name: "Home",

  data() {
    return {
      state: {
        today_work: true,
        today_waiting_visit: false,
        ccc: false,
        ddd: false,
        eee: false
      }
    };
  },

  created() {},

  methods: {
    resize() {
      let that = this;

      clearTimeout(that.chartTimer);

      // that.chartTimer = setTimeout(() => {
      //     that.chartHeight = that.$refs.blockContent.offsetHeight + "px";
      // }, 100);
    },

    aaaa(eeee) {
      let that = this;

      that.state["today_work"] = "today_work" == eeee;
      that.state["today_waiting_visit"] = "today_waiting_visit" == eeee;
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
// .home {
// }

.head {
  border: 1px solid #949090;
  padding: 10px;
  margin: 10px;
  height: 80px;
  line-height: 30px;
  display: flex;
  .num {
    font-size: 18px;
    color: #000000;
    border-right: 1px solid #949090;
    .head-item {
      border-right: 1xp solid #949090;
      cursor: pointer;

      .top {
        color: green;
        text-align: center;
        font-size: 30px;
      }

      .botton {
        text-align: center;
        &:hover {
          color: green;
          text-decoration: underline;
        }
      }

      //   .item {
      //     text-align: center;
      //   }
      //   .item:last-of-type {
      //     border: none;
      //   }
    }
  }
  .num:last-of-type {
    border: none;
  }
}

.today_work {
  color: #949090;

  // &:hover{
  //   color: red;
  // }
}

.bl {
  cursor: pointer;
  border: 1px solid;
  padding: 10px;
  height: 30px;
  line-height: 30px;
  margin-bottom: 10px;
  text-align: center;
  background-color: #fff;
  transition: 0.5s;

  &:hover {
    background-color: rgb(145, 255, 111);
  }
}
</style>