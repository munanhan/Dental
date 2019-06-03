<template>
  <div class="recon-calendar" ref="content">
    <div class="recon-head" ref="action">
      <div class="calendar-action">
        <i class="fa fa-arrow-circle-left mr-10 pre-mth" @click.stop="switchDate('pre')"></i>
        <span
          v-if="curYear != selectYear || curMonth != selectMonth"
          class="current mr-10"
          @click.stop="switchDate"
        >今</span>
        <span v-else>&nbsp;&nbsp;&nbsp;</span>
        <i class="fa fa-arrow-circle-right mr-10 next-mth" @click.stop="switchDate('next')"></i>
      </div>

      <span class="current-mth mr-20">{{selectYear}}年{{textMonth}}月</span>

      <!-- <span class="current-balance">
                <span class="mr-20">收：0.00</span>
                <span class="mr-20">支：0.00</span>
                <span class="mr-20">余：0.00</span>
      </span>-->
    </div>

    <!--
            <div class="calendar-head">

    </div>-->
    <div class="calendar">
      <table cellspacing="0">
        <thead>
          <tr>
            <td class="weekday">日</td>
            <td>一</td>
            <td>二</td>
            <td>三</td>
            <td>四</td>
            <td>五</td>
            <td class="weekday">六</td>
          </tr>
        </thead>

        <tbody>
          <tr
            class="calendar-item"
            v-for="(dateItem, dateIndex) in dateList"
            :key="dateIndex"
            :style="{
                            height: calendarCellHeight
                        }"
          >
            <td
              v-for="item in dateItem"
              :key="item.year + item.mth + item.date"
              :data="item.year+'-'+(item.mth<10?'0'+item.mth:item.mth)+'-'+(item.date<10?'0'+item.date:item.date)"
              class="calendar-day-cell"
              :class="{ 'not-current-mth': item.notCurr, 'active': item == selectItem, 
                                'current-day': item.year == curYear && item.mth - 1 == curMonth && item.date == curDate,
                                'weekday': item.red,
                                'month-blue':targetArr[0].indexOf(
                                  (item.mth.toString().length == 1 ? '0'+ item.mth:item.mth)+'.'+
            (item.date.toString().length == 1 ? '0'+ item.date:item.date)) != -1
                                }"
              @click="selectDate(item)"
            >{{item.date}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: "ReconCalendar",
  components: {},
  inject: ["navBar"],
  props: {
    update: {
      type: Boolean
    }
  },
  data() {
    return {
      dateList: [],
      calendarCellHeight: "70px",
      curYear: null,
      curMonth: null,
      curDate: null,
      selectItem: null,
      selectYear: null,
      selectMonth: null,
      textMonth: null,
      yuyue_month_res: [
        {
          age: "18",
          appointment_date: "2019-05-09",
          phone: "13538048392",
          appointment_doctor: "王医生",
          name: "韩楠",
          sex: "男",
          start_time: "10 : 30",
          type: "初诊",
          items: "拆线"
        },
        {
          age: "18",
          appointment_date: "2019-04-10",
          appointment_doctor: "王医生",
          phone: "13538048392",
          name: "韩楠",
          sex: "男",
          start_time: "14 : 00",
          type: "初诊",
          items: "拆线"
        }
      ]
    };
  },
  created() {
    let d = new Date();
    let year = d.getFullYear();
    let month = d.getMonth() + 1;
    let day = new Date(year, month, 0).getDate();
    this.getMonthData(year,month);
  },

  mounted() {
    let that = this;

    that.$nextTick(() => {
      that.resizeCalendar();
    });

    //监听事件,由layout那边的resize抛出的
    if (window.addEventListener) {
      window.addEventListener("bodyChange", that.resizeCalendar);
    } else {
      window.attachEvent("bodyChange", that.resizeCalendar);
    }
  },
  updated() {
    // let grays = document.getElementsByClassName("month-blue");
    // if (grays.length != 0) {
    //   this.yuyue_month_res.forEach((item, index) => {
    //     if (grays[index]) {
    //       grays[index].innerHTML = `<div class="add-month"><p><span>${
    //         item.name
    //       }</span> : <span>${item.items}</span></p></div>`;
    //     }
    //   });
    // }
    let grays = document.getElementsByClassName("month-blue");
    grays = Array.from(grays);

    grays.forEach((ele, key) => {
      let strhtml = ele.innerHTML + '<div class="add-month">';
      this.yuyue_month_res.forEach((item, index) => {
        if (ele.getAttribute("data") == item.appointment_date) {
          strhtml += `<div data-id="${item.appointment_date}" data-h="${
            item.start_time
          }"><p><span>${item.patient_name}</span> : <span>${item.items}</span>
                              </div>`;
        }
      });
      strhtml += "</div>";

      ele.innerHTML = strhtml;
    });
  },
  watch: {
    navBar: {
      handler: function(val, oldval) {
        val.forEach((ele, index) => {
          if (ele.select == "月" && ele.active == true) {
            if(this.selectMonth){
              this.getMonthData(this.selectYear,this.selectMonth);
            }
            // this.$api.appointment
            //   .getMonthAppointment({ start, end })
            //   .then(res => {
            //     this.yuyue_month_res = res.data;
            //   });
          }
        });
      },
      deep: true //对象内部的属性监听，也叫深度监听
    },
    update(newValue, oldValue) {
      let that = this;
      if (newValue) {
        that.resizeCalendar();

        let nowDate = new Date();

        that.curYear = nowDate.getFullYear();
        that.curMonth = nowDate.getMonth();
        that.curDate = nowDate.getDate();

        that.setDate(nowDate);

        // that.$emit("update:update", false);
      }
    }
  },
  computed: {
    targetArr() {
      let xArr = [],
        yArr = [];
      this.yuyue_month_res.forEach((item, index) => {
        let str = item.appointment_date.substr(5).replace("-", ".");
        xArr.push(str);
        yArr.push(item.start_time);
      });
      return [xArr, yArr];
    }
  },
  methods: {
    getMonthData(year,month) {
      let lastMonth = month -1;
      let nextMonth = month +1;
      lastMonth = lastMonth < 10 ? "0" + lastMonth : lastMonth;
      nextMonth = nextMonth < 10 ? "0" + nextMonth : nextMonth;
      let end = `${year}-${nextMonth}-31`;
      let start = `${year}-${lastMonth}-01`;
      this.$api.appointment.getMonthAppointment({ start, end }).then(res => {
        this.yuyue_month_res = res.data;
      });
    },
    setDate(selectDate) {
      let that = this,
        //总共42个日期
        count = 42,
        //当前日
        nowDate = selectDate,
        selectYear = nowDate.getFullYear(),
        selectMonth = nowDate.getMonth(),
        selDate = nowDate.getDate(),
        //当月的最后一天
        selectMonthLastDate = new Date(
          selectYear,
          selectMonth + 1,
          0
        ).getDate(),
        //上个月最后一天
        preMonthLast = new Date(selectYear, selectMonth, 0),
        preMonthYear = preMonthLast.getFullYear(),
        preMonth = preMonthLast.getMonth(),
        preMonthLastDate = preMonthLast.getDate(),
        preMonthLastDay = preMonthLast.getDay(), //星期几
        //下个月开始时间
        nextMonthStartDay = new Date(selectYear, selectMonth + 1, 1),
        nextMonthYear = nextMonthStartDay.getFullYear(),
        nextMonth = nextMonthStartDay.getMonth(),
        dateArray = [];

      that.selectYear = selectYear;
      that.selectMonth = selectMonth;
      //加1是为了用于显示
      that.textMonth = ("0" + (selectMonth + 1)).slice(-2);

      //计算上个月
      for (var i = 0; i <= preMonthLastDay; i++) {
        dateArray.push({
          year: preMonthYear,
          mth: preMonth + 1,
          date: preMonthLastDate - i,
          notCurr: true
        });
      }

      //计算当前月
      for (var i = 1; i <= selectMonthLastDate; i++) {
        var item = { year: selectYear, mth: selectMonth + 1, date: i };

        dateArray.push(item);

        //设置选中
        if (i == selDate) {
          that.selectItem = item;
        }
      }

      //计算下月
      let less = count - dateArray.length;
      for (var i = 1; i <= less; i++) {
        dateArray.push({
          year: nextMonthYear,
          mth: nextMonth + 1,
          date: i,
          notCurr: true
        });
      }

      let result = [];
      //切割6份方便遍历
      for (var i = 0; i < 6; i++) {
        //星期六，日显示红色
        dateArray[i * 7].red = true;
        dateArray[i * 7 + 6].red = true;

        result[i] = dateArray.slice(i * 7, (i + 1) * 7);
      }

      that.dateList = result;
    },

    switchDate(type) {
      let that = this,
        date = null;

      if (type == "pre") {
        date = new Date(that.selectYear, that.selectMonth - 1, 1);
      } else if (type == "next") {
        date = new Date(that.selectYear, that.selectMonth + 1, 1);
      } else {
        date = new Date();
      }

      //如果上下的一个是当前的年份和月份，则选中当前的日子
      if (
        date.getFullYear() == that.curYear &&
        date.getMonth() == that.curMonth
      ) {
        date = new Date();
      }

      that.setDate(date);
       this.getMonthData(this.selectYear,this.selectMonth);
    },

    //选中的日期
    selectDate(item) {
      let li0 = document.getElementById("li0");
      li0.click();
      let date =
        item.year +
        "-" +
        (item.mth < 10 ? "0" + item.mth : item.mth) +
        "-" +
        (item.date < 10 ? "0" + item.date : item.date);

      this.$store.commit("updateChooseDate", date);
      this.$api.appointment.getTodayAppointment({ date }).then(res => {
        if (res.code == 200) {
          this.$emit("OnUpdateYuyueRes", res.data);
        }
      });

      // console.log(item);
      //  this.$nextTick(function() {
      //   let self = this;
      //   this.navBar.forEach(function(item) {
      //     self.$set(item, "active", false);
      //   });
      //   this.$set({ select: "天", active: false }, "active", true);
      // });
      // let that = this;
      // if (that.selectYear == item.year && that.selectMonth == item.mth - 1) {
      //   that.selectItem = item;
      // } else {
      //   //如果选了上个月或下个月的话，就重新设置当前的日期
      //   that.setDate(new Date(item.year, item.mth - 1, item.date));
      // }
    },

    resizeCalendar() {
      let that = this,
        calendarHeight =
          that.$refs.content.clientHeight - that.$refs.action.clientHeight - 70,
        calendarCellHeight = parseInt(calendarHeight / 6, 10);

      calendarCellHeight = calendarCellHeight >= 70 ? calendarCellHeight : 70;

      that.calendarCellHeight = `${calendarCellHeight}px`;
    }
  }
};
</script>
<style lang="less">
//导入全局的颜色
@import "~@css/var";
.month {
  background-color: #ffffff;
}
.transition-2 {
  transition: all 0.2s;
}

.recon-calendar {
  position: absolute;
  top: -36px;
  right: 0;
  left: 0;
  // bottom: 0;
  // padding-bottom:36px;

  background-color: #ffffff;

  height: 100%;
  box-sizing: border-box;

  .recon-head {
    padding: 10px;
    border-bottom: 1px solid #e3e3e3;

    .current,
    .pre-mth,
    .next-mth {
      cursor: pointer;
    }

    .current {
      color: #6b6b6b;
      .transition-2;

      &:hover {
        color: black;
      }
    }

    > div {
      display: inline-block;
      font-size: 22px;

      > i {
        color: @color;
        .transition-2;

        &:hover {
          color: @hover-color;
        }
      }
    }

    .current-mth {
      font-size: 24px;
    }
  }

  .calendar {
    padding: 10px;

    box-sizing: border-box;
    width: 100%;

    table {
      width: 100%;
      border-color: #ffffff;
      border: 1px solid #e3e3e3;

      .weekday {
        color: red;
      }

      tr {
        border: 0;
      }

      td {
        border: 1px solid #e3e3e3;
        border-top: none;
        border-left: none;
        padding: 10px;
      }

      tr {
        td:last-of-type {
          border-right: none;
        }
      }

      tbody {
        tr:last-of-type {
          td {
            border-bottom: none;
          }
        }

        td {
          vertical-align: top;
          cursor: pointer;
          .transition-2;

          &:hover {
            background-color: @linght-background-color;
          }
          &:not(.month-blue) {
            .add-month {
              display: none;
            }
          }
          &.month-blue {
            font-size: 12px;
            position: relative;
            padding-top: 0px;
            > div.add-month {
              position: absolute;
              left: 0;
              right: 0;
              z-index: 1000;
              // height: 2px;
              overflow: hidden;
              background-color: #fff0e6;
              div {
                border: 1px solid #000;
                margin-bottom: 1px;
              }
              p {
                padding: 0;
                margin: 0;
              }
            }
          }
        }

        .not-current-mth {
          color: #9c9b9b;
        }

        .current-day {
          background-color: @linght-background-color;
          color: red;
        }

        .active {
          background-color: @backgroud-color !important;
        }
      }

      thead {
        text-align: center;
      }
    }
  }
}
</style>