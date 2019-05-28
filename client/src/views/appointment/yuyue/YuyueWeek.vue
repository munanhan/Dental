<template>
  <div class="yuyue-week">
    <el-row class="week-header">
      <div>
        <span>24h</span>
      </div>
      <div class="week-day" v-for="(i,n) in weekArr" :key="n">
        <el-badge :value="0" class="item" :hidden="true">
          <template v-if="weekStart">
            <span
              :class="[curDate.substr(5).replace('-','.') ==
               +i[Object.keys(i)[0]].split('.')[0]+'.'+i[Object.keys(i)[0]].split('.')[1] ? 'red':'']"
            >{{`${Object.keys(i)[0]}${i[Object.keys(i)[0]]}`}}</span>
          </template>
        </el-badge>
      </div>
      <div>
        <span>24h</span>
      </div>
    </el-row>
    <el-row class="week-other" v-for="(item,index) in dayTime" :key="index">
      <div class="other-left">
        <div>
          <span class="big-font">{{item}}</span>
          <span>00</span>
        </div>
        <div>
          <span>30</span>
        </div>
      </div>
      <div class="other-center">
        <template v-if="weekStart">
          <div
            v-for="(i,n) in weekArr"
            :key="n"
            :data-y="item +' : 00'"
            :data-x="i[Object.keys(i)[0]]"
            :class="[targetArr[1].indexOf(`${item} : 00`) != -1 && 
            targetArr[0][targetArr[1].indexOf(`${item} : 00`)] == i[Object.keys(i)[0]]
            ?'week-blue':'']"
            @click="addYuyue"
          ></div>
          <div
            v-for="(i,n) in weekArr"
            :key="n+' '"
            :data-y="item +' : 30'"
            :data-x="i[Object.keys(i)[0]]"
            :class="[targetArr[1].indexOf(`${item} : 30`) != -1 && 
            targetArr[0][targetArr[1].indexOf(`${item} : 30`)] == i[Object.keys(i)[0]]
            ?'week-blue':'']"
            @click="addYuyue"
          ></div>
        </template>
      </div>
      <div class="other-left">
        <div>
          <span>00</span>
          <span class="big-font">{{item}}</span>
        </div>
        <div>
          <span class="span-left">30</span>
        </div>
      </div>
    </el-row>
    <!-- 错误提示 -->
    <el-dialog title="提示" :visible.sync="dialogVisible" width="30%">
      <span>预约日期不能小于今天</span>
      <span slot="footer" class="dialog-footer">
        <el-button @click="dialogVisible = false">取 消</el-button>
        <el-button type="primary" @click="dialogVisible = false">确 定</el-button>
      </span>
    </el-dialog>
    <!-- 错误提示 -->
    <status-dialog :show.sync="statusDialog" :yuyue_id="data_id"></status-dialog>`
    <!-- 新增预约 start -->
    <add-yuyue
      :show.sync="addYuyueShow"
      :dayTime="dayTime"
      :weekStart="weekStart"
      :weekEnd="weekEnd"
      :yuyue_time.sync="data_y"
      :yuyue_date.sync="data_x"
      :yuyue_id="data_id"
    ></add-yuyue>
    <!-- 新增预约  end-->
  </div>
</template>

<script>
import { mapState } from "vuex";
import StatusDialog from "./StatusDialog.vue";
import AddYuyue from "./AddYuyue.vue";
import { formatDate, addClass, inArray } from "@/common/util.js";
export default {
  name: "",
  inject: ["week", "navBar", "dayTime", "getWeekStartEnd", "statusIcon"],
  props: ["weekStart", "weekEnd", "weekArr"],
  created() {
    this.$nextTick(function() {
      setTimeout(() => {
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
      }, 1000);
    });
  },
  components: {
    StatusDialog,
    AddYuyue
  },
  data() {
    return {
      yuyue_week_res: [
        {
          id: 21,
          patient_id: 75,
          type: "0",
          status: null,
          appointment_doctor: "d",
          appointment_comment: "hdf",
          appointment_date: "2019-05-14",
          start_time: "10 : 00",
          over_time: "11 : 00",
          items: "牙周上药",
          created_at: "2019-05-14 09:25:46",
          created_by: null,
          updated_at: "2019-05-14 09:25:46",
          updated_by: null,
          age: 18,
          source: "朋友介绍",
          name: "h10",
          case_id: "20190514167",
          sex: "男",
          phone: "13538048392",
          content: "gh"
        },
        {
          id: 23,
          patient_id: 75,
          type: "0",
          status: null,
          appointment_doctor: "d",
          appointment_comment: "hdf",
          appointment_date: "2019-05-14",
          start_time: "10 : 00",
          over_time: "11 : 00",
          items: "牙周上药",
          created_at: "2019-05-14 09:25:46",
          created_by: null,
          updated_at: "2019-05-14 09:25:46",
          updated_by: null,
          age: 18,
          source: "朋友介绍",
          name: "h10",
          case_id: "20190514167",
          sex: "男",
          phone: "13538048392",
          content: "gh"
        },
        {
          id: 22,
          patient_id: 75,
          type: "0",
          status: null,
          appointment_doctor: "d",
          appointment_comment: "hdf",
          appointment_date: "2019-05-15",
          start_time: "11 : 00",
          over_time: "12 : 00",
          items: "牙周上药",
          created_at: "2019-05-14 09:25:46",
          created_by: null,
          updated_at: "2019-05-14 09:25:46",
          updated_by: null,
          age: 18,
          source: "朋友介绍",
          name: "h10",
          case_id: "20190514167",
          sex: "男",
          phone: "13538048392",
          content: "gh"
        }
      ],
      target: null,
      status: null,
      data_id: null,
      data_x: null,
      data_y: null,
      statusDialog: false,
      dialogVisible: false,
      addYuyueShow: false
    };
  },
  computed: {
    targetArr() {
      let xArr = [],
        yArr = [];
      this.yuyue_week_res.forEach((item, index) => {
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
    })
  },
  methods: {
    inArray(arr, str) {
      return inArray(arr, str);
    },
    addYuyue() {
      this.isAttrDataTime(event.target);
      if (this.data_x) {
        let date = formatDate(new Date(), "MM.dd");
        if (this.data_x < date) {
          this.dialogVisible = true;
        } else {
           this.addYuyueShow = true;
        }
      }
      //修改状态
      if (this.status && this.data_id) {
        this.statusDialog = true;
      }
      //修改预约数据
      if (!this.status && this.data_id) {
        this.addYuyueShow = true;
      }
    },
    isAttrDataTime(dom) {
      if (dom.hasAttribute("class") && dom.getAttribute("class") == "left") {
        this.target = dom;
        this.status = true;
        this.data_x = null;
        this.data_y = null;
        this.data_id = dom.getAttribute("id");
        return;
      }
      if (dom.hasAttribute("data-id")) {
        this.data_x = null;
        this.data_y = null;
        this.status = false;
        this.data_id = dom.getAttribute("data-id");
        this.data_y = dom.getAttribute("data-h");
        this.target = dom;
        return;
      }
      if (dom.hasAttribute("data-y")) {
        this.data_id = null;
        this.status = false;
        this.target = dom;
        let year = new Date().getFullYear() + "-";
        this.data_x =year + dom.getAttribute("data-x").replace('.','-');
        this.data_y = dom.getAttribute("data-y");
        return;
      }

      dom = dom.parentNode;
      this.isAttrDataTime(dom);
    }
  },
  mounted() {},
  updated() {
    let grays = document.getElementsByClassName("week-blue");
    grays = Array.from(grays);
    grays.forEach((ele, key) => {
      let strhtml = '<div class="add-week">';
      this.yuyue_week_res.forEach((item, index) => {
        if (
          `${ele.getAttribute("data-y")}` == item.start_time &&
          ele.getAttribute("data-x") ==
            item.appointment_date.substr(5).replace("-", ".")
        ) {
          strhtml += `<div data-id="${item.id}" data-h="${item.start_time}">
            <div class="inner">`;
          strhtml += this.statusIcon(item.status, item.id);
          strhtml += `<div class="right"><p><span>${item.patient_name}</span><span>${
            item.type == 1 ? "复" : "初"
          }
          </span><span>${item.patient_age}</span></p>
                                <p><span>${item.patient_phone}</span></p>
                                <p><span>${item.items}</span></p>
                              </div></div>`;
        }
      });
      strhtml += "</div>";
      ele.innerHTML = strhtml;
    });
  }
};
</script>

<style lang="less">
.week {
  width: 100%;
  position: relative;
}
.bg0#6bb15e {
  background-color: #6bb15e;
}
.yuyue-week {
  position: absolute;
  left: 0;
  top: 0;
  bottom: 0;
  right: 0;
  display: flex;
  flex-direction: column;
  width: 100%;
  .week-header {
    flex: auto;
    display: flex;
    > div {
      box-sizing: border-box;
      text-align: center;
      display: flex;
      > span,
      div {
        margin: auto;
      }
      &:first-of-type,
      &:last-of-type {
        flex-basis: 80px;
      }
    }
    .week-day {
      background-color: #fff;
      border: 1px solid #ccc;
      border-left: none;
      flex: auto;
    }
  }
  .week-other {
    flex: auto;
    display: flex;
    .other-left {
      flex-basis: 80px;
      display: flex;
      flex-direction: column;
      div {
        flex: auto;
        &:first-of-type {
          display: flex;
          padding: 0 10px;
          span {
            flex: auto;
            border-top: 1px solid #e6e6e6;
            &.big-font {
              font-size: 20px;
            }
          }
        }
        &:last-of-type {
          display: flex;
          padding: 0 10px;
          span {
            margin-left: auto;
            border-top: 1px solid #e6e6e6;
          }
          .span-left {
            margin: 0;
          }
        }
      }
    }
    .other-center {
      flex: auto;
      display: flex;
      flex-wrap: wrap;
      > div {
        flex: auto;
        width: 14.28%;
        box-sizing: border-box;
        background-color: #fff;
        border: 1px solid #ccc;
        &:not(.week-blue) {
          .add-week {
            display: none;
          }
        }

        &.week-blue {
          font-size: 12px;
          position: relative;

          > div.add-week {
            position: absolute;
            left: 0;
            right: 0;
            z-index: 1000;
            top: 0;
            bottom: -28px;
            overflow: hidden;
            display: flex;
            > div {
              flex: auto;
              display: flex;
              margin-right: 2px;
              background-color: rgba(151, 189, 214, 1);
              .inner {
                display: flex;
                margin-right: 10px;
                .left {
                  width: 18px;
                  height: 52px;
                  .bg0#6bb15e;
                  text-align: center;
                  // background-color: #f40;
                }
              }
            }
            p {
              margin: 0;
              color: #000 !important;
            }
            p:first-of-type {
              span {
                margin-right: 10px;
              }
              span:nth-of-type(1) {
                color: red;
                font-size: 14px;
              }
              span:nth-of-type(2) {
                display: inline-block;
                width: 12px;
                height: 12px;
                overflow: hidden;
                background-color: aqua;
              }
            }
          }
        }
      }
    }
  }
}
</style>
