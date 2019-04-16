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
        <input type="text" ref="inputSearch" name="search" placeholder="姓名、拼音、电话查询" value="">
        <i class="fas fa-search" @click="search"></i>
      </div>
    </div>
    {{chooseDay}}
  </div>
</template>

<script>
export default {
  name: "",
  props: ["chooseDay"],
  components: {},
  created() {
    // console.log(this.chooseDay);
  },
  data() {
    return {
      navBar: [
        { select: "天", active: true },
        { select: "周" },
        { select: "月" },
        { select: "列表" },
        { select: "排班" }
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
    search(){
     let  $search = this.$refs.inputSearch;
      console.log($search.value);
    }
  }
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
    // border: 1px solid black;
    display: flex;
    // justify-content:space-between;
    ul {
      display: flex;
      padding: 0;
      margin: 0;
      li {
        cursor: pointer;
        width: 50px;
        line-height: 35px;
        text-align: center;
        border: 1px solid green;
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
          background-color: green;
        }
        &:hover:not(.active-li) {
          background-color: #c7feb5;
        }
      }
    }
    .add-yuyue,.net-yuyue {
      line-height: 35px;
      border: 1px solid green;
      padding: 0 15px;
      border-radius: 8px;
      margin-left: 5%;
      &:hover {
        background-color: #c7feb5;
          color: green;
      }
    }
    .add-yuyue{
        background-color: green;
        color: #fff;
    }
    .net-yuyue{
      background-color: #fff;
        color: green;
    }
    .search{
      margin-left:auto;
      line-height: 35px;
      border: 1px solid green;
      border-radius: 8px;
      font-size: 18px;
      input{
        outline: none;
        border: none;
        padding:0 10px
      }
    }
  }
}
</style>
