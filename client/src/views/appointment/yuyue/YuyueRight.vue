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
                :key="index +'3'"
                :class="[targetArr[1].indexOf(`${item} : 00`) != -1 &&
                targetArr[0][targetArr[1].indexOf(`${item} : 00`)] == chooseDatesub5   
            ?'day-blue':'']"
                @click="addYuyue(item)"
              ></div>
              <div
                data-time="30"
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
    <add-yuyue :show.sync="addYuyueShow" :dayTime="dayTime" :yuyue_time="yuyue_time"></add-yuyue>
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
      getWeekStartEnd: this.getWeekStartEnd
    };
  },
  created() {
    this.$nextTick(function() {
      this.getWeekStartEnd(this.chooseDate);
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
      yuyue_res: [
        {
          age: "18",
          apt_data: "2019-04-23",
          tel_one: "13538048392",
          doctor_id: "王医生",
          name: "韩楠",
          sex: "男",
          time_frame_begin: "11 : 00",
          type_id: "初诊",
          items: "拆线"
        },
        {
          age: "18",
          apt_data: "2019-04-28",
          doctor_id: "王医生",
          tel_one: "13538048392",
          name: "韩楠",
          sex: "男",
          time_frame_begin: "14 : 30",
          type_id: "初诊",
          items: ""
        }
      ]
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
      this.myCalender.choosePrevNextDay(upDate);
    },
    handleNextDay() {
      let date = new Date(this.chooseDate);
      date.setDate(date.getDate() + 1);
      let upDate = formatDate(date, "yyyy-MM-dd");
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
    addYuyue(item) {
      this.addYuyueShow = true;

      if (item) {
        let time = event.target.attributes["data-time"].value;
        let yuyueDate = `${item} : ${time}`;
        this.yuyue_time = yuyueDate;
      }
    },
    inArray(arr, str) {
      return inArray(arr, str);
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
        arr.push(item.time_frame_begin);
      });
      return arr;
    },
    targetArr() {
      let xArr = [],
        yArr = [];
      this.yuyue_res.forEach((item, index) => {
        let str = item.apt_data.substr(5).replace("-", ".");
        xArr.push(str);
        yArr.push(item.time_frame_begin);
        // arr.push([{ x: str, y: item.time_frame_begin }, item]);
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

    if (grays.length != 0) {
      this.yuyue_res.forEach((item, index) => {
        if (grays[index]) {
          grays[index].innerHTML = `<div class="add-day"><p><span>${
            item.name
          }</span><span>${item.type_id}</span><span>${item.age}</span></p>
                            <p><span>${item.tel_one}</span></p>
                            <p><span>${item.items}</span></p>
                            <p><span>${
                              item.time_frame_begin
                            } - ${+item.time_frame_begin.substr(0, 2) +
            1} : ${item.time_frame_begin.substr(-2)} (60m)</span></p></div>`;
        }
      });
    }
  }
};
</script>

<style lang="less">
@import "~@/assets/css/var.less";
@import "~@views/appointment/css/YuyueRight.less";
.month{
    
    width: 100% !important;
}
</style>
