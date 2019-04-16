<template>
　　<div>
　　　　<ul>
　　　　　　<li v-for="(item,$index) in items" :key="$index" @click="selectStyle (item, $index) " :class="{'active':item.active,'unactive':!item.active}" >
　　　　　　{{item.select}} 
　　　　　　<span class="icon" v-show="item.active">当我是图标</span>
　　　　　　</li>
　　　　</ul>
　　</div>
</template>

<script>

　　import Vue from 'vue'

　　export default{
　　　　data(){
　　　　　　return {
　　　　　　　　active: false,
　　　　　　　　items: [
　　　　　　　　　　{select:'第一行'},
　　　　　　　　　　{select:'第二行'},
　　　　　　　　　　{select:'第三行'},
　　　　　　　　　　{select:'第四行'}
　　　　　　　　]
　　　　　　}
　　　　},


　　methods: {
　　　　selectStyle (item, index) {
            console.log(item,index);
　　　　　　this.$nextTick(function () {
　　　　　　　　this.items.forEach(function (item) {
　　　　　　　　　　Vue.set(item,'active',false);
　　　　　　　　});
　　　　　　　　Vue.set(item,'active',true);
　　　　　　});
　　　　}
　　}
}
</script>

<!-- 样式 -->
<style lang="less">
.active{
    color:red;
}
.unactive{
    color:#000;
}
.icon{
    float: right;
    font-size: 12px;
}

</style>