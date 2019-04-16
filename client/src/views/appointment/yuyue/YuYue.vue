<template>
    <div class="yuyue">
           
        <el-container>
            
                
                <yuyue-left :chooseDay.sync="chooseDay"></yuyue-left>
                <yuyue-right :chooseDay.sync="chooseDay"></yuyue-right>
              
              
        </el-container>


    </div>
</template>

<script>
    import { formatDate } from '@/common/util.js';
    import YuyueLeft from './YuyueLeft.vue';
    import YuyueRight from './YuyueRight.vue';
 
    export default {
        name: '',
        components: {
            YuyueLeft,
            YuyueRight,
     
        },
        data() {
            return {
                chooseDay: formatDate(new Date(), 'yyyy-MM-dd'),
            }
        },

        

        methods: {
           
        }
    }
</script>

<style lang="less">
    .dashboard {
        height: 100%;
    }

    .main-body {
        padding: 0 !important;
  
    }

    .yuyue {
        height: 100%;

        .el-container {
            height: 100%;

           
        }
    }
</style>