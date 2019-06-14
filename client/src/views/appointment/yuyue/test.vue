<template>
  <div>
    <ul>
      <li
        v-for="(item,$index) in items"
        :key="$index"
        @click="selectStyle (item, $index) "
        :class="{'active':item.active,'unactive':!item.active}"
      >
        {{item.select}}
        <span class="icon" v-show="item.active">当我是图标</span>
      </li>
    </ul>
    用户名：<input type="text" @keyup.13="but()">
    <!-- <div v-on:scroll.passive="onScroll" id="second"><div id="first"></div></div> -->
  </div>
</template>

<script>
import Vue from "vue";

export default {
  data() {
    return {
      active: false,
      items: [
        { select: "第一行" },
        { select: "第二行" },
        { select: "第三行" },
        { select: "第四行" }
      ]
    };
  },

  methods: {
      but(){
          console.log(event);
      },
      first(){
          alert('first');
      },
      second(){
          alert('second');
      },
      third(){
          alert('third');
      },
      onScroll(){
          console.log(event.target.scrollTop=350);
      },
    selectStyle(item, index) {
      console.log(item, index);
      this.$nextTick(function() {
        this.items.forEach(function(item) {
          Vue.set(item, "active", false);
        });
        Vue.set(item, "active", true);
      });
    }
  }
};
</script>

<!-- 样式 -->
<style lang="less" scoped>
.active {
  color: red;
}
.unactive {
  color: #000;
}
.icon {
  float: right;
  font-size: 12px;
}
    button {
        background: red;
        color: white;
    }

    #third {
        width: 50px;
        height: 50px;
        border: thin solid red;
    }

    #second {
        width: 100px;
        height: 100px;
        border: thin solid red;
        overflow-y:auto;
        overflow-x: hidden;
    }

    #first {
        width: 500px;
        height: 500px;
        border: thin solid red;
    }
</style>