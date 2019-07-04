<template>
  <div class="yuyue-left">
    <el-row>
      <el-col :span="2">
        <div>
          <i :class="[isRight ? rightClass :leftClass]" @click="toggleClass()"></i>
        </div>
      </el-col>
      <el-col v-show="isRight">
        <div class="date">
          <MyCalender ref="myCalender" v-if="!isList"></MyCalender>

          <div v-if="isList">
            <el-aside class="left" style="width: 320px;" :style="{'height':menuHeight+'px'}">
              <el-row class="left_top" style="width: 95%;">
                <el-col :span="6" class="top_font">操作时间</el-col>
                <el-col :span="3">
                  <el-button
                    type="primary"
                    icon="el-icon-arrow-left"
                    size="mini"
                    circle
                    class="top_btn"
                    @click="prev"
                  ></el-button>
                </el-col>
                <el-col :span="2" class="top_font">
                  <span @click="selectThis" style="cursor: pointer;">今</span>
                </el-col>
                <el-col :span="3">
                  <el-button
                    type="primary"
                    icon="el-icon-arrow-right"
                    size="mini"
                    circle
                    class="top_btn"
                    @click="next"
                  ></el-button>
                </el-col>
                <el-col :span="10" class="top_font">
                  <el-radio-group v-model="radio_date">
                    <el-radio :label="1" @change="selectToday">天</el-radio>
                    <el-radio :label="2" @change="selectWeek">周</el-radio>
                    <el-radio :label="3" @change="selectMonth">月</el-radio>
                  </el-radio-group>
                </el-col>
              </el-row>

              <el-row class="search">
                <span class="search_font">从</span>
                <el-date-picker
                  v-model="search.dtfm"
                  type="date"
                  placeholder="选择日期"
                  class="search_input"
                  value-format="yyyy-MM-dd"
                  @change="resetDate"
                  :clearable="false"
                  :editable="false"
                ></el-date-picker>
              </el-row>
              <el-row
                class="search"
                style="border-bottom: 1px solid rgba(33, 37, 43, 0.26);padding-bottom: 30px;"
              >
                <span class="search_font">到</span>
                <el-date-picker
                  v-model="search.dtto"
                  type="date"
                  placeholder="选择日期"
                  class="search_input"
                  value-format="yyyy-MM-dd"
                  @change="resetDate"
                  :clearable="false"
                  :editable="false"
                ></el-date-picker>
              </el-row>
              <el-row class="search">
                <div>预约状态</div>
                <div class="status-radio">
                  <div>
                    <el-radio v-model="search.statusRadio" label="全部">全部</el-radio>
                  </div>
                  <div>
                    <el-radio v-model="search.statusRadio" label="0">预约</el-radio>
                  </div>
                  <div>
                    <el-radio v-model="search.statusRadio" label="1">确认</el-radio>
                  </div>
                  <div>
                    <el-radio v-model="search.statusRadio" label="2">到达</el-radio>
                  </div>
                  <div>
                    <el-radio v-model="search.statusRadio" label="3">过期</el-radio>
                  </div>
                  <div>
                    <el-radio v-model="search.statusRadio" label="4">流失</el-radio>
                  </div>
                </div>
              </el-row>
              <el-row class="search" style="margin-top: 20px;">
                <el-col :span="12">
                  <el-button type="primary" @click="searchData">查询</el-button>
                </el-col>
                <!-- <el-col :span="12">
                  <el-button type="primary" @click="clearSearch">清空</el-button>
                </el-col>-->
              </el-row>
            </el-aside>
          </div>
        </div>
      </el-col>
    </el-row>
  </div>
</template>

<script>
import MyCalender from "./Calender.vue";
import Bus from "@/assets/Bus.js";
export default {
  name: "",
  created() {
    let self = this;
    this.searchData()
    Bus.$on("send", function(val) {
      self.navBarChange = val;
    });
    Bus.$on("pager_current", function(val) {
      self.search.current = val;
      self.searchData()
    });
    Bus.$on("pager_size", function(val) {
      self.search.size = val; 
     
       self.searchData()
    });
  },
  components: {
    MyCalender
  },
  computed: {
    isList() {
      var res;
      this.navBarChange.forEach((ele, key) => {
        if (key == 3) {
          res = ele.active;
        }
      });
      return res;
    }
  },
  data() {
    return {
      d: new Date(),
      isRight: true,
      rightClass: "fas fa-align-right",
      leftClass: "fas fa-align-left",
      chooseDay: this.chooseDayleft,
      navBarChange: [],
      tableData: [],
      search: {
        //搜索参数
        dtfm: new Date().toLocaleDateString(),
        dtto: new Date().toLocaleDateString(),
        statusRadio: "全部",
        current: 1,
        size: 10
        // ct_user: "",
        // patient: "",
        // module: ""
      },
      menuHeight: 667,
      radio_date: 1,
      show_time: {
        //显示计算总共时间
        dtfm: "",
        dtto: "",
        total_day: 0
      }
    };
  },
  watch: {
    show_time: {
      handler: function(val, oldval) {
        Bus.$emit("showTime", val);
        //   console.log(val)
        //   console.log(oldval)
      },
      deep: true //对象内部的属性监听，也叫深度监听
    }
  },
  methods: {
    toggleClass() {
      this.isRight = !this.isRight;
    },
    resetDate() {
      //重置时间
      this.calculation();
    },
    formatDate(date, option = "") {
      //时间转化
      var myyear = date.getFullYear();
      var mymonth = date.getMonth() + 1;
      var myweekday = date.getDate();

      var year = "-"; //年/月/日
      var month = "-";
      var day = "";

      if (option != "") {
        year = "年";
        month = "月";
        day = "日";
      }

      if (mymonth < 10) {
        mymonth = "0" + mymonth;
      }
      if (myweekday < 10) {
        myweekday = "0" + myweekday;
      }
      return myyear + year + mymonth + month + myweekday + day; //拼接,年月日
    },
    getMonthDays(myMonth, date = "") {
      //获得某月的天数
      var now = date == "" ? new Date() : new Date(date); //当前日期
      var nowYear = now.getYear(); //当前年
      nowYear += nowYear < 2000 ? 1900 : 0; //
      var monthStartDate = new Date(nowYear, myMonth, 1);
      var monthEndDate = new Date(nowYear, myMonth + 1, 1);
      var days = (monthEndDate - monthStartDate) / (1000 * 60 * 60 * 24);
      return days;
    },
    calculation() {
      //计算总共时间
      var dtfm = new Date(this.search.dtfm);
      var dtto = new Date(this.search.dtto);
      this.show_time.total_day =
        (dtto - dtfm + 60 * 60 * 24 * 1000) / (60 * 60 * 24 * 1000); //计算天数
      this.show_time.dtfm = this.formatDate(new Date(dtfm), 1);
      this.show_time.dtto = this.formatDate(new Date(dtto), 1);
    },
    prev() {
      //往上
      var option = this.radio_date;
      var date = this.search.dtfm;
      if (date != "") {
        date = new Date(Date.parse(date.replace(/-/g, "/")));
        //转化成时间戳
        date = date.getTime();
      }
      var yesterday =
        this.search.dtfm == ""
          ? new Date(new Date() - 1000 * 60 * 60 * 24)
          : new Date(date - 1000 * 60 * 60 * 24);
      switch (option) {
        case 1:
          //获取上一天
          this.selectToday(yesterday);
          this.calculation();
          break;
        case 2:
          //上周
          this.selectWeek(yesterday);
          this.calculation();
          break;
        case 3:
          //上月
          this.selectMonth(yesterday);
          this.calculation();
      }
    },
    next() {
      //往下
      var option = this.radio_date;
      var date = this.search.dtto;
      if (date != "") {
        date = new Date(Date.parse(date.replace(/-/g, "/")));
        //转化成时间戳
        date = date.getTime();
      }
      var tomorrow =
        this.search.dtto == ""
          ? new Date(new Date() + 1000 * 60 * 60 * 24)
          : new Date(date + 1000 * 60 * 60 * 24);
      switch (option) {
        case 1:
          //获取下一天
          this.selectToday(tomorrow);
          this.calculation();
          break;
        case 2:
          //下周
          this.selectWeek(tomorrow);
          this.calculation();
          break;
        case 3:
          //下月
          this.selectMonth(tomorrow);
          this.calculation();
      }
    },
    selectThis() {
      //选择今天/本周/本月
      var option = this.radio_date;
      switch (option) {
        case 1:
          this.selectToday(1);
          this.calculation();
          break;
        case 2:
          this.selectWeek(2);
          this.calculation();
          break;
        case 3:
          this.selectMonth(3);
          this.calculation();
      }
    },
    selectToday(date = "") {
      //选择今天
      var now = date == 1 ? new Date() : new Date(date); //当前日期 (1代表是取今天,值来源于单选radio的label)
      this.search.dtfm = now.toLocaleDateString();
      this.search.dtto = now.toLocaleDateString();
      this.calculation();
      this.getData();
    },
    selectWeek(date = "") {
      //选择这周
      var now = date == 2 ? new Date() : new Date(date); //当前日期 (2代表是取本周,值来源于单选radio的label)
      var nowDayOfWeek = now.getDay(); //今天本周的第几天
      var nowDay = now.getDate(); //当前日
      var nowMonth = now.getMonth(); //当前月
      var nowYear = now.getYear(); //当前年
      nowYear += nowYear < 2000 ? 1900 : 0; //

      var weekStartDate = new Date(nowYear, nowMonth, nowDay - nowDayOfWeek);
      this.search.dtfm = this.formatDate(weekStartDate); //本周第一天

      var weekEndDate = new Date(
        nowYear,
        nowMonth,
        nowDay + (6 - nowDayOfWeek)
      );
      this.search.dtto = this.formatDate(weekEndDate); //本周最后一天
      this.calculation();
      this.getData();
    },
    selectMonth(date = "") {
      //选择本月
      var now = date == 3 ? new Date() : new Date(date); //当前日期 (3代表是取本月,值来源于单选radio的label)
      var nowDayOfWeek = now.getDay(); //今天本周的第几天
      var nowDay = now.getDate(); //当前日
      var nowMonth = now.getMonth(); //当前月
      var nowYear = now.getYear(); //当前年
      nowYear += nowYear < 2000 ? 1900 : 0; //

      var monthStartDate = new Date(nowYear, nowMonth, 1);
      this.search.dtfm = this.formatDate(monthStartDate); //本月第一天

      var monthEndDate = new Date(
        nowYear,
        nowMonth,
        this.getMonthDays(nowMonth)
      );
      this.search.dtto = this.formatDate(monthEndDate); //本月最后一天
      this.calculation();
      this.getData();
    },
    searchData() {
      //查数据
      // console.log(this.search);
      this.getData();
    },
    getData() {
      let that = this;
      //表单数据
      that.$api.appointment
        .getListAppointment(that.search)
        .then(res => {
        if(res.code == 200){
       
          that.tableData = res[0].data;
          that.total = res[1].data[0].total;
          Bus.$emit("tableData", that.tableData);
          Bus.$emit("total", that.total);
        }
          //   console.log(that.tableData);
        })
        .catch(res => {});
    }
  },
  mounted() {
    this.$store.commit("updateMyCalender", this.$refs.myCalender);
    //  console.log(this.$refs.myCalender.chooseToday);
  }
};
</script>

<style lang="less" scoped>
@import "~@/assets/css/var.less";
.yuyue-left {
  // width: 400px;
  height: 100%;
  background-color: #f3f3f3;

  .date {
    width: 400px;
    .left {
      height: 100%;
      /*border:1px solid black;*/
      .left_top {
        border-bottom: 1px solid rgba(33, 37, 43, 0.26);
        height: 40px;
        /*padding: 10px;*/
        /deep/ .el-radio {
          margin-right: 5px;
        }
        /deep/ .el-radio__input.is-checked .el-radio__inner {
          border-color: rgba(33, 37, 43, 0.26);
          background: rgba(33, 37, 43, 0.26);
        }
        /deep/ .el-radio__input.is-checked + .el-radio__label {
          color: black;
        }
        /deep/ .el-radio__label {
          padding-left: 5px;
        }
      }
      .top_font {
        padding-left: 7px;
        padding-top: 10px;
      }
      .top_btn {
        margin-top: 5px;
        margin-left: 5px;
        background-color: #efefef;
        border: 1px solid rgba(33, 37, 43, 0.26);
        color: #909399;
      }
      .search {
        padding: 10px;
        width: 95%;
        .status-radio {
          text-align: center;
          div {
            padding: 10px;
          }
        }
        .search_font {
          margin-right: 10px;
          float: left;
          margin-top: 10px;
          margin-left: 10px;
        }
        .search_input {
          width: 200px;
          float: right;
          margin-right: 5px;
        }
      }
    }
    .clear {
      border: 1px solid #ccc;
      border-left: none;
      border-right: none;
      line-height: 40px;
      display: flex;
      font-size: 18px;
      span {
        padding-left: 20px;
      }
      div {
        margin-left: 55%;
        border: 1px solid @color;
        width: 60px;
        text-align: center;
        border-radius: 12px;
        color: @color;
        background-color: #fff;
      }
    }
  }
}
</style>