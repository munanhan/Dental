<template>
  <div class="yuyue-right">
        yuyue-right
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
    }
  },

  methods: {}
}
</script>

<style lang="less">
.yuyue-right{
  background-color: #fff;
}
</style>
