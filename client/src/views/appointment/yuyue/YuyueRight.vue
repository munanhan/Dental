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
          placeholder="姓名、拼音、电话查询"
          value
          @keyup.enter="search"
        >
        <i class="fas fa-search" @click="search"></i>
      </div>
    </div>
    <div class="date-header">
      <div class="prev-day" @click="handlePrev">
        <div></div>
      </div>
      <div
        :class="['today',$store.state.yuyue_date.chooseDate!= $store.state.yuyue_date.curDate? 'red':''] "
        @click="chooseToday"
      >今</div>
      <div class="next-day" @click="handleNext">
        <div></div>
      </div>
      <div class="show-date">
        <span>{{this.yuyue_date.chooseDate}}</span>
        <span>{{week[new Date(this.yuyue_date.chooseDate).getDay()]}}</span>
        <span>{{severalDays}}</span>
      </div>
    </div>
    <div class="date-body">
      <div v-show="navBar[0].active" class="day">
        <el-row class="day-header">
          <div>
            <span>24h</span>
          </div>
          <div class="doctor1">
            王医生
          </div>
          <div class="doctor2">
            未指定医生
          </div>
          <div>
            <span>24h</span>
          </div>
        </el-row>
        <el-row class="day-other" v-for="(item,index) in dayTime" :key="index">
          <div class="other-left">
              <div><span class="big-font">{{item}}</span><span>00</span></div>
              <div><span>30</span></div>
          </div>
           <div class="other-center" @click="addYuyue(item)">
              <div data-time="00"></div>
              <div data-time="00"></div>
              <div data-time="30"></div>
              <div data-time="30"></div>
           </div>
          <div class="other-left">
              <div><span>00</span><span class="big-font">{{item}}</span></div>
              <div><span class="span-left">30</span></div>
          </div>
         
          
        </el-row>
      </div>
      <div v-show="navBar[1].active" class="week">1</div>
      <div v-show="navBar[2].active" class="month">2</div>
      <div v-show="navBar[3].active" class="list">3</div>
      <div v-show="navBar[4].active" class="paiban">4</div>
    </div>
       
    <!-- 新增预约 start -->
      <add-yuyue :show.sync="addYuyueShow" :dayTime="dayTime" :yuyue_time="yuyue_time"></add-yuyue>
    <!-- 新增预约  end-->

  </div>
</template>

<script>
import { formatDate,addClass} from "@/common/util.js";
import AddYuyue from "./AddYuyue.vue";
export default {
  name: "",
  props: ["chooseDay"],
  components: {
    AddYuyue,
  },
  created() {},
  data() {
    return {
      addYuyueShow:false,
      navBar: [
        { select: "天", active: true },
        { select: "周" },
        { select: "月" },
        { select: "列表" },
        { select: "排班" }
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
      dayTime:['09','10','11','12','13','14','15','16','17','18','19','20','21','22'],

      yuyue_date: this.$store.state.yuyue_date,
      yuyue_time:null,
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
    handlePrev() {
      let date = new Date(this.yuyue_date.chooseDate);
      date.setDate(date.getDate() - 1);
      let upDate = formatDate(date, "yyyy-MM-dd");
      this.yuyue_date.myCalender.choosePrevNextDay(upDate);
    },
    handleNext() {
      let date = new Date(this.yuyue_date.chooseDate);
      date.setDate(date.getDate() + 1);
      let upDate = formatDate(date, "yyyy-MM-dd");
      this.yuyue_date.myCalender.choosePrevNextDay(upDate);
    },
    chooseToday() {
      this.yuyue_date.myCalender.chooseToday();
    },
    addYuyue(item){
     

        this.addYuyueShow = true;
      
      if(item){
          let time =event.target.attributes['data-time'].value;
          let yuyueDate = `${item} : ${time}`;
          this.yuyue_time = yuyueDate;
            
      }
   
    }
  },
  computed: {
    severalDays() {
      //  let nowDate =formatDate(new Date(), 'yyyy-MM-dd');
      let nowTime = new Date(formatDate(new Date(), "yyyy-MM-dd")).getTime();
      let chooseTime = new Date(this.yuyue_date.chooseDate).getTime();
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
    }
  }
};
</script>

<style lang="less">
@import '~@/assets/css/var.less';
.yuyue-right {
  background-color: #fff;
  width: 100%;
  display: flex;
  flex-direction: column;
  ul > li {
    list-style: none;
  }
  .navbar {
    width: 100%;
    display: flex;
    ul {
      display: flex;
      padding: 0;
      margin: 0;
      li {
        cursor: pointer;
        width: 50px;
        line-height: 35px;
        text-align: center;
        border: 1px solid @color;
        margin-right: 2px;
        &:first-of-type {
          border-top-left-radius: 7px;
          border-bottom-left-radius: 7px;
        }
        &:last-of-type {
          border-top-right-radius: 7px;
          border-bottom-right-radius: 7px;
        }
        &.active-li {
          background-color: @color;
        }
        &:hover:not(.active-li) {
          background-color: @hover-color;
        }
      }
    }
    .add-yuyue,
    .net-yuyue {
      line-height: 35px;
      border: 1px solid @color;
      padding: 0 15px;
      border-radius: 8px;
      margin-left: 5%;
      &:hover {
        background-color: @hover-color;
        color: @color;
      }
    }
    .add-yuyue {
      background-color: @color;
      color: #fff;
    }
    .net-yuyue {
      background-color: #fff;
      color: @color;
    }
    .search {
      margin-left: auto;
      line-height: 35px;
      border: 1px solid @color;
      border-radius: 8px;
      font-size: 18px;
      input {
        outline: none;
        border: none;
        height: 25px;
        padding: 0 10px;
      }
    }
  }
  .date-header {
    margin-top: 5px;
    width: 100%;
    display: flex;
    line-height: 30px;

    .prev-day,
    .next-day {
      border: 1px solid #ccc;
      border-radius: 50%;

      width: 30px;
      height: 30px;
      cursor: pointer;
    }

    .prev-day div {
      position: relative;
      left: 15px;
      top: 8px;
      width: 15px;
      height: 15px;
      border-left: 1px solid #000;
      border-bottom: 1px solid #000;
      transform: rotateZ(45deg);
    }
    .next-day div {
      position: relative;
      /* left: -15px; */
      top: 8px;
      width: 15px;
      height: 15px;
      border-right: 1px solid #000;
      border-top: 1px solid #000;
      transform: rotateZ(45deg);
    }

    .today {
      font-size: 16px;
      color: transparent;
      padding: 0 10px;
      cursor: pointer;
      &.red {
        color: red;
      }
    }
    .show-date {
      font-size: 20px;
      font-weight: 800;
      margin-left: 20px;
    }
  }
  .date-body {
    flex: auto;
    background-color: @backgroud-color;
    display: flex;
    .day {
      display: flex;
      width: 100%;
      flex-direction: column;
      .day-header {
        display: flex;
        flex-basis: 50px;
        line-height: 50px;
        padding-bottom:10px; 
        text-align: center;
        .doctor1{
          flex:1;
          border: 1px solid rgb(173, 171, 171);
          background-color: #fff;
        }
         .doctor2{
           flex:1;
          border: 1px solid rgb(173, 171, 171);
          border-left: none;
          background-color: #fff;
        }
        div:first-of-type,div:last-of-type{
           flex-basis: 80px;
        }
      }
       .day-other {
          flex: auto;
         
          display: flex;
          .other-left{
            flex-basis: 80px;
            display: flex;
            flex-direction: column;
            div{
              flex: auto;
              &:first-of-type{
                display: flex;
                padding: 0 10px;
                span{
                  flex: auto;
                  border-top: 1px solid #e6e6e6;
                  &.big-font{
                    font-size:20px; 
                  }
                }
              }
              &:last-of-type{
                 display: flex;
                  padding: 0 10px;
                span{
                  margin-left: auto;
                  border-top: 1px solid #e6e6e6;
                }
                .span-left{
                  margin:0;
                }
              }
            }
          }
          .other-center{
            flex: auto;
            display: flex;
            flex-wrap: wrap;
            border: 1px solid #d2d2d2;
            div{
              width: 50%;
              box-sizing: border-box;
              background-color: #fff;
              text-align: center;
              &:hover{
                cursor: pointer;
                background-color: @hover-color;
              }
              &:nth-of-type(1){
                border-bottom: 1px solid #e6e6e6;
                border-right: 1px solid #e6e6e6;
              }
               &:nth-of-type(2){
                border-bottom: 1px solid #e6e6e6;
              }
               &:nth-of-type(3){
                border-right: 1px solid #e6e6e6;
              }
            }
          }
       
      }
    }
  }
}
</style>
