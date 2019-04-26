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
            :data-x="+i[Object.keys(i)[0]]"
            :class="[targetArr[1].indexOf(`${item} : 00`) != -1 && 
            targetArr[0][targetArr[1].indexOf(`${item} : 00`)] == +i[Object.keys(i)[0]]
            ?'week-blue':'']"
          ></div>
          <div
            v-for="(i,n) in weekArr"
            :key="n+' '"
            :data-y="item +' : 30'"
            :data-x="+i[Object.keys(i)[0]]"
            :class="[targetArr[1].indexOf(`${item} : 30`) != -1 && 
            targetArr[0][targetArr[1].indexOf(`${item} : 30`)] == +i[Object.keys(i)[0]]
            ?'week-blue':'']"
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
  </div>
</template>

<script>
import { mapState } from "vuex";
import { formatDate, addClass, inArray } from "@/common/util.js";
export default {
  name: "",
  inject: ["week", "navBar", "dayTime", "getWeekStartEnd"],
  props: ["weekStart", "weekEnd", "weekArr"],
  created() {},
  data() {
    return {
      yuyue_week_res: [
        {
          age: "18",
          apt_data: "2019-4-24",
          tel_one: "13538048392",
          doctor_id: "王医生",
          name: "韩楠",
          sex: "男",
          time_frame_begin: "10 : 30",
          type_id: "初诊",
          items: "拆线"
        },
        {
          age: "18",
          apt_data: "2019-4-23",
          doctor_id: "王医生",
          tel_one: "13538048392",
          name: "韩楠",
          sex: "男",
          time_frame_begin: "14 : 00",
          type_id: "初诊",
          items: ""
        }
      ]
    };
  },
  computed: {
    targetArr() {
      let xArr = [],
        yArr = [];
      this.yuyue_week_res.forEach((item, index) => {
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
    })
  },
  methods: {
    inArray(arr, str) {
      return inArray(arr, str);
    }
  },
  mounted() {
    let grays;
   

       grays = document.getElementsByClassName("week-blue");
      console.log(grays);
   
      // console.log(grays);
      // this.yuyue_week_res.forEach((item, index) => {
      // grays[index] &&  (grays[index].innerHTML = `<div><p><span>${item.name}</span><span>${
      //     item.type_id
      //   }</span><span>${item.age}</span></p>
      //                       <p><span>${item.tel_one}</span></p>
      //                       <p><span>${item.items}</span></p>
      //                       <p><span>${
      //                         item.time_frame_begin
      //                       } - ${+item.time_frame_begin.substr(0, 2) +
      //     1} : ${item.time_frame_begin.substr(-2)} (60m)</span></p></div>`)
      // });
    
  }
};
</script>

<style lang="less">
.week {
  width: 100%;
  position: relative;
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
      // border: 1px solid black;
      > div {
        flex: auto;
        width: 14.28%;
        box-sizing: border-box;
        background-color: #fff;
        border: 1px solid #ccc;
        &.week-blue {
          font-size: 12px;
          position: relative;
            background-color: rgba(151, 189, 214, 1);
          > div {
            position: absolute;
            left: 0;
            right: 0;
            height: 52px;
            overflow: hidden;
            p {
              margin: 0;
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
