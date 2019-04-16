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
      <div class="add-yuyue">新增预约</div>
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
      <div :class="['today',$store.state.yuyue_date.chooseDate!= $store.state.yuyue_date.curDate? 'red':''] " @click="chooseToday">今</div>
      <div class="next-day" @click="handleNext">
        <div></div>
      </div>
      <div class="show-date">
        <span>
          {{this.yuyue_date.chooseDate}}
        </span> 
        <span>
          {{week[new Date(this.yuyue_date.chooseDate).getDay()]}}
        </span>
        <span>
          {{severalDays}}
        </span>
        </div>
    </div>
  </div>
</template>

<script>
import { formatDate } from '@/common/util.js';
export default {
  name: "",
  props: ["chooseDay"],
  components: {},
  created() {
    

  },
  data() {
    return {
      navBar: [
        { select: "天", active: true },
        { select: "周" },
        { select: "月" },
        { select: "列表" },
        { select: "排班" }
      ],
      week:{
        1:'周一',
        2:'周二',
        3:'周三',
        4:'周四',
        5:'周五',
        6:'周六',
        7:'周七',
      },
     
      yuyue_date : this.$store.state.yuyue_date,
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
      date.setDate(date.getDate() -1);
      let upDate =formatDate(date, 'yyyy-MM-dd');
      this.yuyue_date.myCalender.choosePrevNextDay(upDate);
      
    },
    handleNext() {
      let date = new Date(this.yuyue_date.chooseDate);
      date.setDate(date.getDate() +1);
      let upDate =formatDate(date, 'yyyy-MM-dd');
      this.yuyue_date.myCalender.choosePrevNextDay(upDate);
    },
    chooseToday() {
      this.yuyue_date.myCalender.chooseToday();
    },
   
  },
  computed:{
     severalDays(){
       return '今天';
     }
  },
};
</script>

<style lang="less">
.yuyue-right {
  background-color: #fff;
  width: 100%;
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
        border: 1px solid #7266ba;
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
          background-color: #7266ba;
        }
        &:hover:not(.active-li) {
          background-color: #a79de4;
        }
      }
    }
    .add-yuyue,
    .net-yuyue {
      line-height: 35px;
      border: 1px solid #7266ba;
      padding: 0 15px;
      border-radius: 8px;
      margin-left: 5%;
      &:hover {
        background-color: #a79de4;
        color: #7266ba;
      }
    }
    .add-yuyue {
      background-color: #7266ba;
      color: #fff;
    }
    .net-yuyue {
      background-color: #fff;
      color: #7266ba;
    }
    .search {
      margin-left: auto;
      line-height: 35px;
      border: 1px solid #7266ba;
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
    .show-date{
      font-size: 20px;
      font-weight: 800;
      margin-left:20px ;
    }
  }
}
</style>
