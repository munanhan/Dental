<template>
  <div class="yuyue-right">
       <div class="navbar">
         <ul>
           <li v-for="item in navBar" :key="item">{{item}}</li>
         </ul>
       </div>
        {{chooseDay}}
  </div>
</template>

<script>
export default {
  name: '',
  props:['chooseDay'],
  created() {
    // console.log(this.chooseDay);
  },
  data () {
    return {
      navBar:['天','周','月','列表','排班']
    }
  },

  methods: {}
}
</script>

<style lang="less">
.yuyue-right{
  background-color: #fff;
  ul>li{
    list-style: none;
  }
  .navbar{
    ul{
      display: flex;
       padding: 0;
      li{
        width: 50px;
        line-height: 40px;
        text-align: center;
        border:1px solid green;
        margin-right:2px; 
        &:first-of-type{
          border-top-left-radius:5px; 
        }
      }
    }
  }
}
</style>
