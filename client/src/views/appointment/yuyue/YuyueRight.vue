<template>
  <div class="yuyue-right">
    <div class="navbar">
      <ul>
        <li
          v-for="(item,index) in navBar"
          :key="index"
          :class="{'active-li':item.active,'unactive':!item.active}"
          :id="'li'+index"
          @click="activeLi(item,index)"
        >{{item.select}}</li>
      </ul>
      <div class="add-yuyue" @click="addYuyue()">新增预约</div>
      <div class="net-yuyue">网上预约</div>
      <div class="search">
        <input
          type="text"
          ref="inputSearch"
          name="search"
          placeholder="姓名、电话查询"
          value
          @keyup.enter="search"
        >
        <i class="fas fa-search" @click="search"></i>
      </div>
    </div>
    <div class="date-header">
      <div v-show="navBar[0].active" class="header-day">
        <div class="prev-day" @click="handlePrevDay">
          <div></div>
        </div>
        <div
          :class="['today',$store.state.chooseDate!= $store.state.curDate? 'red':''] "
          @click="chooseToday"
        >今</div>
        <div class="next-day" @click="handleNextDay">
          <div></div>
        </div>
        <div class="show-date">
          <span>{{chooseDate}}</span>
          <span>{{week[new Date(this.chooseDate).getDay()]}}</span>
          <span>{{severalDays}}</span>
        </div>
      </div>
      <div v-show="navBar[1].active" class="header-week">
        <div class="prev-day" @click="handlePrevWeek">
          <div></div>
        </div>
        <div
          :class="['today',$store.state.chooseDate!= $store.state.curDate? 'red':''] "
          @click="chooseToday"
        >今</div>
        <div class="next-day" @click="handleNextWeek">
          <div></div>
        </div>
        <div class="show-date">
          <span>{{weekStart +'-'+ weekEnd}}</span>
        </div>
      </div>
      <div v-show="navBar[2].active" class="header-month" style="color:#fff;">2</div>
      <div v-show="navBar[3].active" class="header-list">
        <!-- ooooooooooooooooooooooooooooooooooooooooo -->
        <el-row class="right_top">{{showTime.dtfm}} - {{showTime.dtto}}(共{{showTime.total_day}}天)</el-row>
      </div>
    </div>
    <div class="date-body">
      <div v-show="navBar[0].active" class="day">
        <el-row class="day-header">
          <div>
            <span>24h</span>
          </div>
          <div class="doctor1">
            <el-select v-model="left_doctor" @change="changeYuyue('left')">
              <el-option
                v-for="(item,index) in doctor"
                :key="index"
                :label="item.name"
                :value="item.id"
              ></el-option>
            </el-select>
          </div>
          <div class="doctor2">
            <el-select v-model="right_doctor" @change="changeYuyue('right')">
              <el-option
                v-for="(item,index) in doctor"
                :key="index"
                :label="item.name"
                :value="item.id"
              ></el-option>
            </el-select>
          </div>
          <div>
            <span>24h</span>
          </div>
        </el-row>
        <el-row class="day-other">
          <div class="other-left">
            <template v-for="(item,index) in dayTime">
              <div :key="index">
                <span class="big-font">{{item}}</span>
                <span>00</span>
              </div>
              <div :key="index+ ' '">
                <span class="span-right">30</span>
              </div>
            </template>
          </div>
          <div class="other-center-left">
            <template v-for="(item,index) in dayTime">
              <div
                data-time="00"
                :data-h="item"
                :key="index +'3'"
                :class="[targetLeftArr[1].indexOf(`${item} : 00`) != -1 &&
                targetLeftArr[0][targetLeftArr[1].indexOf(`${item} : 00`)] == chooseDatesub5   
            ?'day-left-blue':'']"
                @click="addYuyue(item)"
              ></div>
              <div
                data-time="30"
                :data-h="item"
                :key="index+ '4'"
                :class="[targetLeftArr[1].indexOf(`${item} : 30`) != -1 &&
                targetLeftArr[0][targetLeftArr[1].indexOf(`${item} : 30`)] == chooseDatesub5   
            ?'day-left-blue':'']"
                @click="addYuyue(item)"
              ></div>
            </template>
          </div>
          <div class="other-center-right">
            <template v-for="(item,index) in dayTime">
              <div
                data-time="00"
                :data-h="item"
                :key="index +'1'"
                @click="addYuyue(item)"
                :class="[targetRightArr[1].indexOf(`${item} : 00`) != -1 &&
                targetRightArr[0][targetRightArr[1].indexOf(`${item} : 00`)] == chooseDatesub5   
            ?'day-right-blue':'']"
              ></div>
              <div
                data-time="30"
                :data-h="item"
                :key="index+ '2'"
                @click="addYuyue(item)"
                :class="[targetRightArr[1].indexOf(`${item} : 30`) != -1 &&
                targetRightArr[0][targetRightArr[1].indexOf(`${item} : 30`)] == chooseDatesub5   
            ?'day-right-blue':'']"
              ></div>
            </template>
          </div>
          <div class="other-left">
            <template v-for="(item,index) in dayTime">
              <div :key="index +'5'">
                <span>00</span>
                <span class="big-font">{{item}}</span>
              </div>
              <div :key="index +'6'">
                <span class="span-left">30</span>
              </div>
            </template>
          </div>
        </el-row>
      </div>
      <div v-show="navBar[1].active" class="week">
        <yuyue-week ref="week" :weekStart="weekStart" :weekEnd="weekEnd" :weekArr="weekArr"></yuyue-week>
      </div>
      <div v-show="navBar[2].active" class="month">
        <yuyue-month ref="month" :update.sync="navBar[2].active" @OnUpdateYuyueRes="updateYuyueRes"></yuyue-month>
      </div>
      <div v-show="navBar[3].active" class="list">
        <!-- <test></test>  -->
        <yuyue-list></yuyue-list>
      </div>
    </div>
    <!-- 错误提示 -->
    <el-dialog title="提示" :visible.sync="dialogVisible" width="30%">
      <span>预约日期不能小于今天</span>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogVisible = false">取 消</el-button>
        <el-button type="primary" @click="dialogVisible = false">确 定</el-button>
      </span>
    </el-dialog>
    <!-- 错误提示 -->
    <!-- 更换预约状态 -->
    <status-dialog :show.sync="statusDialog" :yuyue_id="yuyue_id"></status-dialog>
    <!-- 更换预约状态 -->
    <!-- 新增预约 start -->
    <add-yuyue
      :show.sync="addYuyueShow"
      :dayTime="dayTime"
      :yuyue_time.sync="yuyue_time"
      :yuyue_id="yuyue_id"
      :appointment_doctor="appointment_doctor"
    ></add-yuyue>
    <!-- 新增预约  end-->
  </div>
</template>

<script>
import { formatDate, addClass, inArray } from "@/common/util.js";
import Bus from "@/assets/Bus.js";
import AddYuyue from "./AddYuyue.vue";
import StatusDialog from "./StatusDialog.vue";
import YuyueWeek from "./YuyueWeek.vue";
import YuyueMonth from "./YuyueMonth.vue";
import YuyueList from "./YuyueList.vue";
import test from "./test.vue";
import { mapState, mapGetters } from "vuex";
import { setTimeout } from "timers";
import { format } from "path";
export default {
  name: "",
  props: ["chooseDay"],
  components: {
    AddYuyue,
    YuyueWeek,
    YuyueMonth,
    YuyueList,
    StatusDialog
    // test,
  },
  provide: function() {
    return {
      navBar: this.navBar,
      week: this.week,
      dayTime: this.dayTime,
      getWeekStartEnd: this.getWeekStartEnd,
      getTodayAppointment: this.getTodayAppointment,
      statusIcon: this.statusIcon,
      getWeekData: this.getWeekData
    };
  },
  created() {
    this.$nextTick(function() {
      this.getWeekStartEnd(this.chooseDate);
      //获取预约医生数据、
      this.$api.appointment.attendDoctor().then(res => {
        if (res.code == 200 && res.data.length > 0) {
          this.doctor = res.data;
          this.left_doctor = this.doctor[0].name;
          this.right_doctor = this.doctor[1].name;
          this.left_doctor_id = this.doctor[0].id;
          this.right_doctor_id = this.doctor[1].id;
          this.getTodayAppointment();
        }
      });
    });
    let self = this;
    Bus.$on("showTime", function(val) {
      self.showTime = val;
    });
  },
  data() {
    return {
      doctor: [],
      left_doctor: null,
      right_doctor: null,
      appointment_doctor: null,
      left_doctor_id: null,
      right_doctor_id: null,
      statusDialog: false,
      dialogVisible: false,
      addYuyueShow: false,
      navBar: [
        { select: "天", active: true },
        { select: "周" },
        { select: "月" },
        { select: "列表" }
      ],
      week: {
        1: "周一",
        2: "周二",
        3: "周三",
        4: "周四",
        5: "周五",
        6: "周六",
        0: "周日"
      },
      dayTime: [
        "09",
        "10",
        "11",
        "12",
        "13",
        "14",
        "15",
        "16",
        "17",
        "18",
        "19",
        "20",
        "21",
        "22"
      ],
      weekStart: null,
      weekEnd: null,
      yuyue_time: null,
      yuyue_left_res: [],
      yuyue_right_res: [],
      yuyue_id: null,
      target: null,
      showTime: {
        //显示计算总共时间
        dtfm: "",
        dtto: "",
        total_day: 0
      }
    };
  },

  methods: {
    changeYuyue(direction) {
      if (direction == "left") {
        this.$api.appointment
          .getTodayAppointment({
            date: this.chooseDate,
            left_doctor: this.left_doctor
          })
          .then(res => {
            if (res.code == 200) {
              this.yuyue_left_res = res.data[0];
            }
          });
      } else {
        this.$api.appointment
          .getTodayAppointment({
            date: this.chooseDate,
            right_doctor: this.right_doctor
          })
          .then(res => {
            if (res.code == 200) {
              this.yuyue_right_res = res.data[1];
            }
          });
      }
    },
    updateYuyueRes(data) {
      this.yuyue_left_res = data;
    },
    activeLi(item, index) {
      this.$nextTick(function() {
        let self = this;
        this.navBar.forEach(function(item) {
          self.$set(item, "active", false);
        });
        this.$set(item, "active", true);
        Bus.$emit("send", this.navBar);
      });
    },
    search() {
      let $search = this.$refs.inputSearch;
    },
    handlePrevDay() {
      let date = new Date(this.chooseDate);
      date.setDate(date.getDate() - 1);
      let upDate = formatDate(date, "yyyy-MM-dd");

      this.$store.commit("updateChooseDate", upDate);
      let left = typeof this.left_doctor == "number" ? this.left_doctor : null;
      let right =
        typeof this.right_doctor == "number" ? this.right_doctor : null;
      this.getTodayAppointment(left, right);
      this.myCalender.choosePrevNextDay(upDate);
    },
    handleNextDay() {
      let date = new Date(this.chooseDate);
      date.setDate(date.getDate() + 1);
      let upDate = formatDate(date, "yyyy-MM-dd");

      this.$store.commit("updateChooseDate", upDate);
      let left = typeof this.left_doctor == "number" ? this.left_doctor : null;
      let right =
        typeof this.right_doctor == "number" ? this.right_doctor : null;
      this.getTodayAppointment(left, right);
      this.myCalender.choosePrevNextDay(upDate);
    },
    handlePrevWeek() {
      let startStr = this.weekStart.split(/[年月日]/, 3).join("-"),
        oneDayTime = 24 * 3600 * 1000,
        start = new Date(startStr),
        end = new Date(startStr);

      start.setTime(start.getTime() - 7 * oneDayTime);
      end.setTime(end.getTime() - 1 * oneDayTime);

      this.weekEnd = formatDate(end, "yyyy年MM月dd日");
      this.weekStart = formatDate(start, "yyyy年MM月dd日");
      //获取一个星期的数据
      this.getWeekData();
    },
    getWeekData() {
      this.$api.appointment
        .getWeekAppointment({
          weekStart: this.weekStart,
          weekEnd: this.weekEnd
        })
        .then(res => {
          if (res.code == 200) {
            this.$refs.week.yuyue_week_res = res.data;
          }
        });
    },
    handleNextWeek() {
      let endStr = this.weekEnd.split(/[年月日]/, 3).join("-"),
        oneDayTime = 24 * 3600 * 1000,
        end = new Date(endStr),
        start = new Date(endStr);
      end.setTime(end.getTime() + 7 * oneDayTime);
      start.setTime(start.getTime() + 1 * oneDayTime);
      this.weekStart = formatDate(start, "yyyy年MM月dd日");
      this.weekEnd = formatDate(end, "yyyy年MM月dd日");
      //获取一个星期的数据
      this.getWeekData();
    },
    chooseToday() {
      this.myCalender.chooseToday();
    },
    //获取一周的开始日期和结束日期
    getWeekStartEnd(date) {
      let start = new Date(date),
        end = new Date(date),
        now = new Date(date),
        dayOfWeek = start.getDay(),
        oneDayTime = 3600 * 24 * 1000;

      start.setTime(start.getTime() - oneDayTime * dayOfWeek);
      end.setTime(end.getTime() + oneDayTime * (6 - dayOfWeek));

      this.weekStart = formatDate(start, "yyyy年MM月dd日");
      this.weekEnd = formatDate(end, "yyyy年MM月dd日");

      return [
        formatDate(start, "yyyy年MM月dd日"),
        formatDate(end, "yyyy年MM月dd日")
      ];
    },
    //获取一天的预约数据
    getTodayAppointment(left, right) {
      this.$api.appointment
        .getTodayAppointment({
          date: this.chooseDate,
          left_doctor: left ? left : this.left_doctor_id,
          right_doctor: right ? right : this.right_doctor_id
        })
        .then(res => {
          if (res.code == 200) {
            this.yuyue_left_res = res.data[0];
            this.yuyue_right_res = res.data[1];
          }
        });
    },

    addYuyue(item) {
      //按钮新增预约
      if (!item) {
        this.yuyue_id = null;
        this.addYuyueShow = true;
        return;
      }

      let date = formatDate(new Date(), "yyyy-MM-dd");
      this.isAttrDataTime(event.target);
      //提示过期不准预约
      if (this.chooseDate < date && !this.target.hasAttribute("id")) {
        this.dialogVisible = true;
        return;
      }
      if (
        this.target.hasAttribute("class") &&
        this.target.getAttribute("class") == "left"
      ) {
        this.statusDialog = true;
        this.yuyue_id = this.target.getAttribute("id");
        return;
      }
      this.addYuyueShow = true;

      if (
        this.target.hasAttribute("id") &&
        this.target.getAttribute("class") == "right"
      ) {
        this.yuyue_id = this.target.getAttribute("id");
        this.yuyue_time = this.target.getAttribute("data-h");
      } else {
        this.yuyue_id = null;
        this.target.parentNode.getAttribute("class") == "other-center-left"
          ? (this.appointment_doctor = this.left_doctor)
          : (this.appointment_doctor = this.right_doctor);
        if (item) {
          let time = this.target.attributes["data-time"].value;
          let yuyueDate = `${item} : ${time}`;
          this.yuyue_time = yuyueDate;
        }
      }
    },
    inArray(arr, str) {
      return inArray(arr, str);
    },
    isAttrDataTime(dom) {
      if (dom.getAttribute("class") == "left") {
        this.target = dom;
        return;
      }
      if (dom.getAttribute("class") == "right") {
        this.target = dom;
        return;
      }
      if (dom.hasAttribute("data-time")) {
        this.target = dom;
        return;
      }

      dom = dom.parentNode;
      this.isAttrDataTime(dom);
    },
    //根据状态值，处理icon
    statusIcon(statusValue, id) {
      let strhtml;
      switch (statusValue) {
        case "0":
          strhtml = ` <div class="left" id="${id}"><i class="far fa-clock" style="color:#fff;"></i></div>`;
          break;
        case "1":
          strhtml = `<div class="left" style="background-color:rgb(160, 101, 238)" id="${id}"><i class="far fa-thumbs-up" style="color:#fff;"></i></div>`;
          break;
        case "2":
          strhtml = `<div class="left" style="background-color:rgb(50, 17, 233)" id="${id}"><i class="fas fa-warehouse" style="color:#fff;"></i></div>`;
          break;
        case "3":
          strhtml = `<div class="left" style="background-color:#f40;" id="${id}"><i class="fas fa-exclamation-triangle" style="color:#fff;"></i></div>`;
          break;
        case "4":
          strhtml = `<div class="left" id="${id}" style="background-color:#ff3646;"><i class="el-icon-delete" style="color:#fff;"></i></div>`;
          break;
        case "5":
          strhtml = `<div class="left" id="${id}" style="background-color:#ff4040;"><i class="fas fa-times-circle" style="color:#fff;"></i></div>`;
          break;
      }
      return strhtml;
    }
  },
  computed: {
    weekArr() {
      let startStr = this.weekStart
        ? this.weekStart.split(/[年月日]/, 3).join("-")
        : "";
      let Arr = [],
        oneDayTime = 24 * 3600 * 1000,
        start = new Date(startStr);
      ["周日", "周一", "周二", "周三", "周四", "周五", "周六"].forEach(
        (item, i) => {
          let now = new Date();
          now.setTime(start.getTime() + i * oneDayTime);
          let obj = new Object();
          obj[item] = formatDate(now, "MM.dd");
          Arr.push(obj);
        }
      );

      return Arr;
    },
    severalDays() {
      //  let nowDate =formatDate(new Date(), 'yyyy-MM-dd');
      let nowTime = new Date(formatDate(new Date(), "yyyy-MM-dd")).getTime();
      let chooseTime = new Date(this.chooseDate).getTime();
      let days = Math.ceil((chooseTime - nowTime) / 1000 / 60 / 60 / 24);
      let strDays = null;
      if (days > 0) {
        days == 1 && (strDays = "明天");
        days == 2 && (strDays = "后天");
        days > 2 && (strDays = `（${days}天后）`);
      } else if (days == 0) {
        strDays = "今天";
      } else {
        days = Math.abs(days);
        days == 1 && (strDays = "昨天");
        days == 2 && (strDays = "前天");
        days > 2 && (strDays = `（${days}天前）`);
      }
      return strDays;
    },
    time_begin() {
      let arr = [];
      this.yuyue_left_res.forEach((item, index) => {
        arr.push(item.start_time);
      });
      return arr;
    },
    targetLeftArr() {
      let xArr = [],
        yArr = [];
      this.yuyue_left_res.forEach((item, index) => {
        let str = item.appointment_date.substr(5).replace("-", ".");
        xArr.push(str);
        yArr.push(item.start_time);
      });
      return [xArr, yArr];
    },
    targetRightArr() {
      let xArr = [],
        yArr = [];
      this.yuyue_right_res.forEach((item, index) => {
        let str = item.appointment_date.substr(5).replace("-", ".");
        xArr.push(str);
        yArr.push(item.start_time);
      });
      return [xArr, yArr];
    },
    ...mapState({
      myCalender: state => state.myCalender,
      chooseDate: state => state.chooseDate,
      curDate: state => state.curDate
    }),
    ...mapGetters({
      chooseDatesub5: "chooseDatesub5"
    })
  },
  updated() {
    let left_grays = document.getElementsByClassName("day-left-blue");
    let right_grays = document.getElementsByClassName("day-right-blue");
    left_grays = Array.from(left_grays);
    right_grays = Array.from(right_grays);
    left_grays.forEach((ele, key) => {
      let strhtml = '<div class="add-day">';
      this.yuyue_left_res.forEach((item, index) => {
        if (
          `${ele.getAttribute("data-h")} : ${ele.getAttribute("data-time")}` ==
          item.start_time
        ) {
          strhtml += `<div  data-h="${item.start_time}"><div class="inner">    
                  `;
          //-------------------------------------------------------

          strhtml += this.statusIcon(item.status, item.id);

          strhtml += `
              <div class="right" id="${item.id}" data-h="${item.start_time}">
                <p><span>${item.patient_name}</span><span>${
            item.type == 1 ? "复" : "初"
          }</span><span>${item.patient_age}</span></p>
                                <p><span>${item.patient_phone}</span></p>
                                <p><span>${item.items}</span></p>
              </div>
                            </div>`;
        }
      });
      strhtml += "</div>";
      ele.innerHTML = strhtml;
    });
    right_grays.forEach((ele, key) => {
      let strhtml = '<div class="add-day">';
      this.yuyue_right_res.forEach((item, index) => {
        if (
          `${ele.getAttribute("data-h")} : ${ele.getAttribute("data-time")}` ==
          item.start_time
        ) {
          strhtml += `<div  data-h="${item.start_time}"><div class="inner">    
                  `;
          //-------------------------------------------------------

          strhtml += this.statusIcon(item.status, item.id);

          strhtml += `
              <div class="right" id="${item.id}" data-h="${item.start_time}">
                <p><span>${item.patient_name}</span><span>${
            item.type == 1 ? "复" : "初"
          }</span><span>${item.patient_age}</span></p>
                                <p><span>${item.patient_phone}</span></p>
                                <p><span>${item.items}</span></p>
              </div>
                            </div>`;
        }
      });
      strhtml += "</div>";
      ele.innerHTML = strhtml;
    });
  }
};
</script>

<style lang="less">
@import "~@/assets/css/var.less";
@import "~@views/appointment/css/YuyueRight.less";

.month {
  width: 100% !important;
}
</style>
