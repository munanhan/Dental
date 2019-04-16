<template>
    <div class="appoinment">
       <YuYue></YuYue> 
    </div>
</template>

<script>
import YuYue from './yuyue/YuYue.vue'
export default {
    name: 'Appointment',
    components:{
      YuYue
    },
    props:{},
    data(){
      return {
      }
    },
    created(){},
    mounted(){},
    watch:{},
    computed:{},
    methods:{},
}
</script>
<style lang="less" scoped>
  .appoinment{
    height: 100%;
  }
</style>