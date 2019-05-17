<template>
  <div class="yuyue-right">
    <div class="navbar">
      <ul>
        <li
          v-for="(item,index) in navBar"
          :key="index"
          :class="{'active-li':item.active,'unactive':!item.active}"
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
      <div v-show="navBar[3].active" class="header-list">3</div>
    </div>
    <div class="date-body">
      <div v-show="navBar[0].active" class="day">
        <el-row class="day-header">
          <div>
            <span>24h</span>
          </div>
          <div class="doctor1">王医生</div>
          <div class="doctor2">未指定医生</div>
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
                :class="[targetArr[1].indexOf(`${item} : 00`) != -1 &&
                targetArr[0][targetArr[1].indexOf(`${item} : 00`)] == chooseDatesub5   
            ?'day-blue':'']"
                @click="addYuyue(item)"
              ></div>
              <div
                data-time="30"
                :data-h="item"
                :key="index+ '4'"
                :class="[targetArr[1].indexOf(`${item} : 30`) != -1 &&
                targetArr[0][targetArr[1].indexOf(`${item} : 30`)] == chooseDatesub5   
            ?'day-blue':'']"
                @click="addYuyue(item)"
              ></div>
            </template>
          </div>
          <div class="other-center-right">
            <template v-for="(item,index) in dayTime">
              <div data-time="00" :key="index +'1'" @click="addYuyue(item)"></div>
              <div data-time="30" :key="index+ '2'" @click="addYuyue(item)"></div>
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
        <yuyue-week :weekStart="weekStart" :weekEnd="weekEnd" :weekArr="weekArr"></yuyue-week>
      </div>
      <div v-show="navBar[2].active" class="month">
        <yuyue-month :update.sync="navBar[2].active"></yuyue-month>
      </div>
      <div v-show="navBar[3].active" class="list">
        <yuyue-list></yuyue-list>
      </div>
    </div>

    <!-- 新增预约 start -->
    <add-yuyue
      :show.sync="addYuyueShow"
      :dayTime="dayTime"
      :yuyue_time.sync="yuyue_time"
      :yuyue_id="yuyue_id"
    ></add-yuyue>
    <!-- 新增预约  end-->
  </div>
</template>

<script>
import { formatDate, addClass, inArray } from "@/common/util.js";
import AddYuyue from "./AddYuyue.vue";
import YuyueWeek from "./YuyueWeek.vue";
import YuyueMonth from "./YuyueMonth.vue";
import YuyueList from "./YuyueList.vue";
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
    YuyueList
  },
  provide: function() {
    return {
      navBar: this.navBar,
      week: this.week,
      dayTime: this.dayTime,
      getWeekStartEnd: this.getWeekStartEnd,
      getTodayAppointment: this.getTodayAppointment
    };
  },
  created() {
    this.$nextTick(function() {
      this.getWeekStartEnd(this.chooseDate);
      this.getTodayAppointment();
    });
  },
  data() {
    return {
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
      yuyue_res: [],
      yuyue_id: null,
      target: null
    };
  },

  methods: {
    activeLi(item, index) {
      this.$nextTick(function() {
        let self = this;
        this.navBar.forEach(function(item) {
          self.$set(item, "active", false);
        });
        this.$set(item, "active", true);
      });
    },
    search() {
      let $search = this.$refs.inputSearch;
      console.log($search.value);
    },
    handlePrevDay() {
      let date = new Date(this.chooseDate);
      date.setDate(date.getDate() - 1);
      let upDate = formatDate(date, "yyyy-MM-dd");

      this.$store.commit("updateChooseDate", upDate);
      this.getTodayAppointment();
      this.myCalender.choosePrevNextDay(upDate);
    },
    handleNextDay() {
      let date = new Date(this.chooseDate);
      date.setDate(date.getDate() + 1);
      let upDate = formatDate(date, "yyyy-MM-dd");

      this.$store.commit("updateChooseDate", upDate);
      this.getTodayAppointment();
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
      this.$api.appointment
        .getWeekAppointment({
          weekStart: this.weekStart,
          weekEnd: this.weekEnd
        })
        .then(res => {
          if (res.code == 200) {
            this.yuyue_week_res = res.data;
          }
        });
      //  console.log(111);
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
      this.$api.appointment
        .getWeekAppointment({
          weekStart: this.weekStart,
          weekEnd: this.weekEnd
        })
        .then(res => {
          if (res.code == 200) {
            this.yuyue_week_res = res.data;
          }
        });
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
    getTodayAppointment() {
      this.$api.appointment
        .getTodayAppointment({ date: this.chooseDate })
        .then(res => {
          if (res.code == 200) {
            this.yuyue_res = res.data;
          }
        });
    },

    addYuyue(item) {
      this.addYuyueShow = true;
      this.isAttrDataTime(event.target);
      if (this.target.hasAttribute("data-id")) {
        this.yuyue_id = this.target.getAttribute("data-id");
        this.yuyue_time = this.target.getAttribute("data-h");
      } else {
        this.yuyue_id = null;
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
      if (dom.hasAttribute("data-id")) {
        this.target = dom;
        return;
      }
      if (dom.hasAttribute("data-time")) {
        this.target = dom;
        return;
      }

      dom = dom.parentNode;
      this.isAttrDataTime(dom);
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
      this.yuyue_res.forEach((item, index) => {
        arr.push(item.start_time);
      });
      return arr;
    },
    targetArr() {
      let xArr = [],
        yArr = [];
      this.yuyue_res.forEach((item, index) => {
        let str = item.appointment_date.substr(5).replace("-", ".");
        xArr.push(str);
        yArr.push(item.start_time);
        // arr.push([{ x: str, y: item.start_time }, item]);
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
    let grays = document.getElementsByClassName("day-blue");
    grays = Array.from(grays);
    grays.forEach((ele, key) => {
      let strhtml = '<div class="add-day">';
      this.yuyue_res.forEach((item, index) => {
        if (
          `${ele.getAttribute("data-h")} : ${ele.getAttribute("data-time")}` ==
          item.start_time
        ) {
          strhtml += `<div data-id="${item.id}" data-h="${
            item.start_time
          }"><p><span>${item.name}</span><span>${
            item.type == 1 ? "复" : "初"
          }</span><span>${item.age}</span></p>
                                <p><span>${item.phone}</span></p>
                                <p><span>${item.items}</span></p>
                              </div>`;
        }
      });
      strhtml += "</div>";
      ele.innerHTML = strhtml;
    });
    // if (grays.length != 0) {
    //   let strhtml = "";
    //   this.yuyue_res.forEach((item, index) => {
    //     strhtml += `<div class="add-item"><p><span>${item.name}</span><span>${
    //       item.type == 1 ? "复" : "初"
    //     }</span><span>${item.age}</span></p>
    //                         <p><span>${item.phone}</span></p>
    //                         <p><span>${item.items}</span></p>
    //                        </div>`;
    //   });
    // }
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
