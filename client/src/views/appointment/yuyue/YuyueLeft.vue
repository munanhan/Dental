<template>
    <div class="yuyue-left">

        <el-row>
            <el-col :span="2">
                <div>
                    <i :class="[isRight ? rightClass :leftClass]" @click=toggleClass()></i>
                </div>
            </el-col>
            <el-col v-show="isRight">
                <div class="date" >
     
                  <MyCalender ref="myCalender" ></MyCalender>
                   
                    <div class="clear">
                        <span>预约回收站</span>
                        <div>清空</div>
                    </div>
                 
                </div>
            </el-col>

        </el-row>
    </div>
</template>

<script>
    import MyCalender from './Calender.vue';
    export default {
        name: '',
        created(){
           
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
          
        },
        methods: {
            toggleClass() {
                this.isRight = !this.isRight;

            },
        },
        mounted(){
             this.$store.commit('updateYuyueDate',{
                             name:'myCalender',
                             value:this.$refs.myCalender,
                        });
            //  console.log(this.$refs.myCalender.chooseToday);
        }
    }
</script>

<style lang="less">
@import '~@/assets/css/var.less';
.yuyue-left {
    // width: 400px;
    height: 100%;
    background-color: #f3f3f3;

    .date {
        width: 400px;
        .clear{
            border: 1px solid #ccc;
            border-left:none; 
            border-right:none; 
            line-height: 40px;
            display: flex;
            font-size: 18px;
            span{
                padding-left:20px; 
            }
            div{
              margin-left:55%;
              border:1px solid @color;
              width: 60px;
              text-align: center;
              border-radius: 12px;
              color: @color;
              background-color: #fff;
            }
          
            
        }
    }
}

</style>