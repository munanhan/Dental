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
            v-for="(i,n) in ['日','一','二','三','四','五','六']"
            :key="n"
            :data-y="item +' : 00'"
            :data-x="weekStart.match(/\d+/g)[1]+'.'+(+weekStart.match(/\d+/g)[2]+n)"
          ></div>
          <div
            v-for="(i,n) in ['日','一','二','三','四','五','六']"
            :key="n+' '"
            :data-y="item +' : 30'"
            :data-x="weekStart.match(/\d+/g)[1]+'.'+(+weekStart.match(/\d+/g)[2]+n)"
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
export default {
  name: "",
  inject: ["week", "navBar", "dayTime", "getWeekStartEnd"],
  props: ["weekStart","weekEnd","weekArr"],
  created() {

  },
  data() {
    return {
      yuyue_week_res: [
        {
          age: "18",
          apt_data: "2019-4-23",
          tel_one: "13538048392",
          doctor_id: "王医生",
          name: "韩楠",
          sex: "男",
          time_frame_begin: "11 : 30",
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
          time_frame_begin: "14 : 30",
          type_id: "初诊",
          items: ""
        }
      ]
    };
  },
  computed: {
    ...mapState({
      myCalender: state => state.myCalender,
      chooseDate: state => state.chooseDate,
      curDate: state => state.curDate
    })
  },
  methods: {
  
  },
  mounted() {
 
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
      }
    }
  }
}
</style>
