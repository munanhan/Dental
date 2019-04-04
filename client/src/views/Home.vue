<template>
  <div class="home">
    
   <shouye></shouye>
  </div>
</template>

<script>
// @ is an alias to /src
// import HelloWorld from '@/components/HelloWorld.vue'
import shouye from '@/components/home/shouye.vue'

export default {
  name: 'home',
  components: {
    shouye
  }
}
</script>
<style lang="less">
@import "~@/assets/css/common.less";
</style>