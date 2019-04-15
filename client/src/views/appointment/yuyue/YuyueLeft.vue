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
     
                  <MyCalender :chooseDay.sync="chooseDay"></MyCalender>
                   

                 
                </div>
            </el-col>

        </el-row>
    </div>
</template>

<script>
    import MyCalender from './Calender.vue';
    export default {
        name: '',
        props:{
            chooseDayleft:String,
        },
        components:{
            MyCalender,
        },
        data() {
            return {
                isRight: true,
                rightClass: 'fas fa-align-right',
                leftClass: 'fas fa-align-left',
                chooseDay:this.chooseDayleft,
    
                
            }
        },
        watch: {
            chooseDay(newChooseDay,oldChooseDay){
                this.$emit('update:chooseDay',newChooseDay);
            }
        },
        methods: {
            toggleClass() {
                this.isRight = !this.isRight;

            },
       
        }
    }
</script>

<style lang="less">
  
    .yuyue-left {
    height: 100%;
    background-color: #f3f3f3;

    .date {
        width: 400px;
        
    }
}

</style>