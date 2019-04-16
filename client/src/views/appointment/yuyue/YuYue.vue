<template>
    <div class="yuyue">
           
        <el-container>
            
                
                <yuyue-left ></yuyue-left>
                <yuyue-right ></yuyue-right>
              
              
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