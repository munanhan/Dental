<template>
    <div class="yuyue-left">

        <el-row>
            <el-col :span="2">
                <div>
                    <i :class="[isRight ? rightClass :leftClass]" @click=toggleClass()></i>
                </div>
            </el-col>
            <el-col>
                <div class="date" v-show="isRight">
                      
                </div>
            </el-col>

        </el-row>
    </div>
</template>

<script>
    
    export default {
        name: '',
        components:{
            calendar,
        },
        data() {
            return {
                isRight: true,
                rightClass: 'fas fa-align-right',
                leftClass: 'fas fa-align-left',



                
            }
        },

        methods: {
            toggleClass() {
                this.isRight = !this.isRight;

            }
        }
    }
</script>

<style lang="less">
    @import '~@/assets/css/yuyue/yuyueLeft.less';
</style>