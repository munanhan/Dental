<template>
    <div class="calendar">
        <div class="date-header">
            <div class="prev-month" @click="handlePrev">
                <div></div>
            </div>
            <div :class="['today',chooseDate!=curDate? 'red':''] " @click="chooseToday">今</div>
            <div class="next-month" @click="handleNext">
                <div></div>
            </div>
          
            <div class="show-date">{{$store.state.chooseDate}}</div>
        </div>
        <div class="date-content">
                <div class="week-header">
                  <div>日</div>
                  <div>一</div>
                  <div>二</div>
                  <div>三</div>
                  <div>四</div>
                  <div>五</div>
                  <div>六</div>
                </div>
                <div class="week-day">
                   
                  <div class="every-day" v-for="item in 42" :key="item">
                    <div v-if="item - beginDay > 0 && item - beginDay <= curDays"
                         :class="{
                           'now-day': `${year}-${month}-${item - beginDay}` === curDate,
                           'active-day': `${year}-${month}-${item - beginDay}` === $store.state.chooseDate
                         }"
                         :data-day="item - beginDay"
                         @click="handlechooseDate"
                    >
                      {{  `${year}-${month}-${item - beginDay}` === curDate ? '今':item - beginDay }}
                    </div>
                    <div v-else-if="item - beginDay <= 0" class="other-day">{{ prevDays - beginDay + item}}</div>
                    <div v-else class="other-day">{{ item - beginDay - curDays }}</div>
                  </div>
                  
                </div>
              </div>
    </div>
</template>

<script>
    export default {
        name: 'Calender',
        // props:{
        //     chooseDay: String;
        // },
        props:['chooseDay'],
        data() {
            return {
                forNum:42,
                year: null,
                month: null,
                day: null,
                curDate: null,
                activeDay: null
            }
        },
        created() {
            this.getInitTime();
        },
        methods: {
            getInitTime() {
                const date = new Date();
                this.year = date.getFullYear();
                this.month = date.getMonth() + 1;
                this.month.toString().length == 1 ? this.month = '0'+this.month: '';
               
                this.day = date.getDate();
                this.curDate = `${this.year}-${this.month}-${this.day}`;
                this.$store.commit('updateCurDate',this.curDate);
            },
            handlePrev() {
                if (this.month === 1) {
                    this.month = 12;
                    this.year--;
                } else {
                    this.month--;
                }
            },
            handleNext() {
                if (this.month === 12) {
                    this.month = 1;
                    this.year++;
                } else {
                    this.month++;
                }
            },
            handlechooseDate(e) {
                this.day = e.target.dataset.day;
               
            },
            chooseToday(){
               let [year,month,day] = this.curDate.split('-');
               this.year = year;
               this.month = month;
               this.day = day;
            },
            choosePrevNextDay(date){
                let [year,month,day] = date.split('-');
               this.year = year;
               this.month = month;
               this.day = day;
            }
        },
        watch: {
            chooseDate(newDate,oldDate){
                let arr = newDate.split('-');
                arr.splice(1,1,arr[1].length == 1? '0'+arr[1]:arr[1]); 
                this.$store.commit('updateChooseDate',arr.join('-'));
                
            },
        },
        computed: {
            chooseDate(){
                return `${this.year}-${this.month}-${this.day}`;
            },
            beginDay() {
                return new Date(this.year, this.month - 1, 1).getDay();
            },
            curDays() {
                return new Date(this.year, this.month, 0).getDate();
            },
            prevDays() {
                return new Date(this.year, this.month - 1, 0).getDate();
            }
        }
    }
</script>

<style lang="less">
    .calendar {
        
        .date-header {
            width: 100%;
            display: flex;
            line-height: 30px;

            .prev-month,
            .next-month {
                /* margin-left:30px; */
                &:hover{
                    border: 1px solid #ccc;
                    border-radius: 50%; 
                }
                width: 30px;
                height: 30px;
                cursor: pointer;
            }

            .prev-month div {
                position: relative;
                left: 15px;
                top:8px;
                width: 15px;
                height: 15px;
                border-left: 1px solid #000;
                border-bottom: 1px solid #000;
                transform: rotateZ(45deg)
            }
            .next-month div{
                position: relative;
                /* left: -15px; */
                top:8px;
                width: 15px;
                height: 15px;
                border-right: 1px solid #000;
                border-top: 1px solid #000;
                transform: rotateZ(45deg)
            }

           .today{
               font-size: 16px;
               color: transparent;
               padding: 0 10px;
               cursor: pointer;
               &.red{
                    color: red;
               }
           }

        }


        .show-date {
            flex: 1;
            text-align: center;
            /* color: #007fff; */
        }

        .week-header {
            display: flex;
        }

        .week-header>div {
            flex: 1;
            text-align: center;
            line-height: 30px;
            /* background-color: #007fff; */
            color: #ccc;
            font-weight: 600;
        }
        .week-header>div:nth-of-type(1),.week-header>div:last-of-type{
            color: red;
        }

        .week-day {
            width: 100%;
        }

        .every-day {

            display: inline-block;
            width: 14.28%;
            line-height: 50px;
            text-align: center;
            cursor: pointer;
        }
        .every-day:nth-of-type(7n){
            color: red;
        }
        .every-day:nth-of-type(7n+1){
            color: red;
        }
        .other-day {
            color: #ccc;
        }

        .now-day {
            border-radius:50px;
            background-color: #fff0D2; 
            font-weight: 600;
        }

        /* .active-day:not(.now-day) {
            border-radius:50px;
            border:2px solid red; 
            line-height: 46px;
        } */
        .active-day{
            border-radius:50px;
            border:2px solid red; 
            line-height: 46px;
        }
    }
</style>