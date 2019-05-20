<template>
    <div class="monthly-calendar">
        <div class="letf-content">
            <div class="left-header">
                <i
                    class="fa fa-arrow-circle-left mr-10 pre-mth"
                    @click.prevent.stop="switchDate('pre', selectYear - 1)"
                ></i>

                <span
                    v-if="!isCurrent"
                    class="current mr-10"
                    @click.prevent.stop="switchDate('current', currentYear)"
                >今</span>

                <span
                    v-if="isCurrent"
                    class="mr-10"
                >
                    &nbsp;&nbsp;
                </span>

                <!-- <span v-else>&nbsp;&nbsp;&nbsp;</span> -->
                <i
                    class="fa fa-arrow-circle-right mr-10 next-mth"
                    @click.prevent.stop="switchDate('next', selectYear + 1)"
                ></i>

                <span class="ml-10">{{selectText}}</span>
            </div>
            <div class="calendar">
                <div
                    class="cal-row"
                    v-for="(item, index) in 3"
                    :key="index"
                >
                    <div
                        class="cal-mth"
                        v-for="(mth, index) in 4"
                        :key="mth + index"
                    >
                        <div
                            class="mth-cell"
                            :class="{ 'active': selectMth == 4 * (item - 1) + mth }"
                            @click.prevent.stop="switchDate('changeMth', 4 * (item - 1) + mth)"
                        >
                            {{4 * (item - 1) + mth}}月
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div
            class="right-content"
            ref="content"
        >
            <div
                class="right-head"
                ref="head"
            >
                <div class="mb-10">

                    <span class="mr-10">

                        <el-radio-group
                            v-model="currentType"
                            @change="changeShow"
                        >
                            <el-radio-button label="diagnose">就诊</el-radio-button>
                            <el-radio-button label="returnVisit">回访</el-radio-button>
                            <el-radio-button label="monthlyCalendar">月历</el-radio-button>
                        </el-radio-group>
                    </span>

                    <span class="mr-10 retrun-type">

                        <el-radio-group
                            v-model="return_type"
                            @change="getData"
                        >
                            <el-radio :label="0">全部</el-radio>
                            <el-radio :label="1">未访</el-radio>
                            <el-radio :label="2">已回访</el-radio>
                            <el-radio :label="3">待跟进</el-radio>
                        </el-radio-group>
                    </span>

                </div>

                <div>
                    <span class="mth-calendar">
                        <i
                            class="fa fa-arrow-circle-left mr-10 pre-mth"
                            @click.stop="switchDate('pre-mth')"
                        ></i>
                        <span
                            v-if="currentYear != selectYear || currentMth != selectMth"
                            class="current mr-10"
                            @click.stop="switchDate('current', currentYear)"
                        >今</span>
                        <span v-else>&nbsp;&nbsp;&nbsp;</span>
                        <i
                            class="fa fa-arrow-circle-right mr-10 next-mth"
                            @click.stop="switchDate('next-mth')"
                        ></i>
                    </span>

                    <span>
                        <span class="mr-10">
                            {{selectText}}
                        </span>

                        <span class="mr-10">
                            {{weekDayText}}
                        </span>
                        <span>
                            ({{interText}})
                        </span>
                    </span>
                </div>
            </div>

            <div class="right-content">

                <div class="calendar">

                    <table cellspacing="0">
                        <thead>
                            <tr>
                                <td class="weekday">日</td>
                                <td>一</td>
                                <td>二</td>
                                <td>三</td>
                                <td>四</td>
                                <td>五</td>
                                <td class="weekday">六</td>
                            </tr>
                        </thead>

                        <tbody>
                            <tr
                                class="calendar-item"
                                v-for="(dateItem, dateIndex) in dateList"
                                :key="dateIndex"
                                :style="{
									height: calendarCellHeight
								}"
                            >
                                <td
                                    v-for="item in dateItem"
                                    :key="item.year + item.mth + item.date"
                                    :class="{ 'not-current-mth': item.notCurr, 'active': item == selectItem, 
											'current-day': item.year == currentYear && item.mth == currentMth && item.date == currentDate,
											'weekday': item.red }"
                                    @click="switchDate('select-date', item)"
                                    @dblclick="changeShow('returnVisit', item)"
                                >
                                    <span class="ml-10">{{item.date}}</span>

                                    <div
                                        class="return-list"
                                        :style="{
											height: `${returnItemHeight}px`
										}"
                                    >
                                        <div
                                            v-for="(item, index) in returnData[item.fullDate]"
                                            :key="index"
                                            class="return-item"
                                            :class="{'face-green': item.type == 1, 'face-orange': item.type == 2, 'face-plum': item.type == 3}"
                                        >
                                            {{item.name}}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "MonthlyCalendar",
    components: {},
    props: {
        type: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            selectYear: 0,
            selectMth: 0,
            selectDate: 0,

            currentYear: 0,
            currentMth: 0,
            currentDate: 0,

            selectText: "",
            weekDayText: "",
            interText: "",

            currentType: "monthlyCalendar",
            contentHeight: "300px",

            dateList: [],
            calendarCellHeight: "70px",
            returnItemHeight: "40px",

            return_type: 0,

            returnData: {
                "2019510": [
                    { type: 1, name: "6666" },
                    { type: 2, name: "77777" },
                    { type: 3, name: "88888" },
                    { type: 1, name: "11111" },
                    { type: 2, name: "22222" }
                ]
            }
        };
    },
    created() {},
    mounted() {
        let that = this,
            date = new Date();

        that.selectYear = that.currentYear = date.getFullYear();
        that.selectMth = that.currentMth = date.getMonth() + 1;
        that.selectDate = that.currentDate = date.getDate();

        that.setSelectText();
        that.setDate();

        that.$nextTick(() => {
            //监听事件,由layout那边的resize抛出的
            window.addEventListener("bodyChange", that.resizeContent);
        });
    },
    watch: {
        type(newValue, oldValue) {
            let that = this;

            if (newValue == "monthlyCalendar") {
                that.resizeContent();
            }
        }
    },

    computed: {
        isCurrent() {
            return (
                this.currentYear == this.selectYear &&
                this.selectMth == this.currentMth
            );
        }
    },
    methods: {
        //重新计算高度
        resizeContent() {
            let that = this,
                contentHeight =
                    that.$refs.content.clientHeight -
                    that.$refs.head.clientHeight,
                calendarCellHeight = parseInt((contentHeight - 54) / 6, 10);

            that.contentHeight = `${contentHeight}px`;

            calendarCellHeight =
                calendarCellHeight >= 70 ? calendarCellHeight : 70;

            that.calendarCellHeight = `${calendarCellHeight}px`;

            that.returnItemHeight = calendarCellHeight - 30;
        },

        setSelectText() {
            let that = this,
                year = that.selectYear,
                mth = ("00" + that.selectMth).substr(-2),
                date = ("00" + that.selectDate).substr(-2),
                selectDate = new Date(
                    that.selectYear,
                    that.selectMth - 1,
                    that.selectDate,
                    "00",
                    "00",
                    "00"
                ),
                weekday = selectDate.getDay(),
                mapping = {
                    0: "周日",
                    1: "周一",
                    2: "周二",
                    3: "周三",
                    4: "周四",
                    5: "周五",
                    6: "周六"
                },
                dayText = mapping[weekday],
                inter = parseInt(
                    (selectDate.getTime() -
                        new Date(
                            that.currentYear,
                            that.currentMth - 1,
                            that.currentDate,
                            "00",
                            "00",
                            "00"
                        ).getTime()) /
                        86400000
                ),
                dayMapping = {
                    "-2": "前天",
                    "-1": "昨天",
                    "0": "今天",
                    "1": "明天",
                    "2": "后天"
                },
                dayCurrent = dayMapping[inter];

            if (that.selectMth != that.currentMth) {
                date = "01";
            }

            if (!dayMapping[inter]) {
                var count = Math.abs(inter);

                if (inter < 0) {
                    dayCurrent = `前${count}天`;
                } else {
                    dayCurrent = `后${count}天`;
                }
            }

            that.selectText = `${year}年${mth}月${date}日`;
            that.weekDayText = `${dayText}`;
            that.interText = dayCurrent;
        },

        //转换时间，根据不同的类型处理value
        switchDate(type, value) {
            let that = this;

            switch (type) {
                case "changeMth":
                    that.selectMth = value;
                    break;
                case "current":
                    that.selectYear = value;
                    that.selectMth = that.currentMth;
                    that.selectDate = that.currentDate;
                    break;
                case "pre":
                    that.selectYear = value;

                    if (that.selectYear == that.currentYear) {
                        that.selectMth = that.currentMth;
                        that.selectDate = that.currentDate;
                    } else {
                        that.selectMth = 1;
                        that.selectDate = 1;
                    }

                    break;

                case "pre-mth":
                    that.selectMth = that.selectMth - 1;

                    var newDate = new Date(
                            that.selectYear,
                            that.selectMth - 1,
                            that.selectDate
                        ),
                        year = newDate.getFullYear(),
                        month = newDate.getMonth() + 1;

                    if (year == that.currentYear && month == that.currentMth) {
                        that.selectDate = that.currentDate;
                    } else {
                        that.selectDate = 1;
                    }

                    break;

                case "next-mth":
                    that.selectMth = that.selectMth + 1;

                    var newDate = new Date(
                            that.selectYear,
                            that.selectMth - 1,
                            that.selectDate
                        ),
                        year = newDate.getFullYear(),
                        month = newDate.getMonth() + 1;

                    if (year == that.currentYear && month == that.currentMth) {
                        that.selectDate = that.currentDate;
                    } else {
                        that.selectDate = 1;
                    }
                    break;

                case "next":
                    that.selectYear = value;

                    if (that.selectYear == that.currentYear) {
                        that.selectMth = that.currentMth;
                        that.selectDate = that.currentDate;
                    } else {
                        that.selectMth = 1;
                        that.selectDate = 1;
                    }

                    break;

                case "select-date":
                    that.selectYear = value.year;
                    that.selectMth = value.mth;
                    that.selectDate = value.date;
                    break;
            }

            that.setSelectText();
            that.getData();
            that.setDate();
        },

        getData() {},

        changeShow(value, item) {
            let that = this;
            that.$emit("update:type", value);

            if (item) {
                that.$emit(
                    "change-visit-date",
                    new Date(item.year, item.mth, item.date)
                );
            }

            //原来的值不更新，直接替换页面
            setTimeout(() => {
                that.currentType = "monthlyCalendar";
            }, 300);
        },

        setDate() {
            let that = this,
                //总共42个日期
                count = 42,
                //当前日
                selectYear = that.selectYear,
                selectMonth = that.selectMth - 1,
                selDate = that.selectDate,
                //当月的最后一天
                selectMonthLastDate = new Date(
                    selectYear,
                    selectMonth + 1,
                    0
                ).getDate(),
                //上个月最后一天
                preMonthLast = new Date(selectYear, selectMonth, 0),
                preMonthYear = preMonthLast.getFullYear(),
                preMonth = preMonthLast.getMonth(),
                preMonthLastDate = preMonthLast.getDate(),
                preMonthLastDay = preMonthLast.getDay(), //星期几
                //下个月开始时间
                nextMonthStartDay = new Date(selectYear, selectMonth + 1, 1),
                nextMonthYear = nextMonthStartDay.getFullYear(),
                nextMonth = nextMonthStartDay.getMonth(),
                dateArray = [];

            that.selectYear = selectYear;
            that.selectMonth = selectMonth;
            //加1是为了用于显示
            that.textMonth = ("0" + (selectMonth + 1)).slice(-2);

            //计算上个月
            for (var i = 0; i <= preMonthLastDay; i++) {
                dateArray.push({
                    year: preMonthYear,
                    mth: preMonth + 1,
                    date: preMonthLastDate - i,
                    notCurr: true,
                    fullDate: preMonthYear + "" + (preMonth + 1) + "" + i
                });
            }

            //计算当前月
            for (var i = 1; i <= selectMonthLastDate; i++) {
                var item = {
                    year: selectYear,
                    mth: selectMonth + 1,
                    date: i,
                    fullDate: selectYear + "" + (selectMonth + 1) + "" + i
                };

                dateArray.push(item);

                //设置选中
                if (i == selDate) {
                    that.selectItem = item;
                }
            }

            //计算下月
            let less = count - dateArray.length;
            for (var i = 1; i <= less; i++) {
                dateArray.push({
                    year: nextMonthYear,
                    mth: nextMonth + 1,
                    date: i,
                    notCurr: true,
                    fullDate: nextMonthYear + "" + (nextMonth + 1) + "" + i
                });
            }

            let result = [];
            //切割6份方便遍历
            for (var i = 0; i < 6; i++) {
                //星期六，日显示红色
                dateArray[i * 7].red = true;
                dateArray[i * 7 + 6].red = true;

                result[i] = dateArray.slice(i * 7, (i + 1) * 7);
            }

            that.dateList = result;
        }
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

.transition-2 {
    transition: all 0.2s;
}

.monthly-calendar {
    display: flex;
    height: 100%;

    .letf-content {
        width: 340px;
        min-width: 320px;
        border-right: 1px solid #e3e3e3;
        font-size: 18px;

        .left-header {
            border-bottom: 1px solid #cccaca;
            height: 60px;
            line-height: 60px;
            padding-left: 16px;
            box-sizing: border-box;

            i {
                color: @color;
                .transition-2;

                &:hover {
                    color: @hover-color;
                }
            }

            .current {
                .transition-2;

                &:hover {
                    color: @color;
                }
            }

            .current,
            .pre-mth,
            .next-mth {
                cursor: pointer;
            }
        }

        .calendar {
            padding: 10px;

            .cal-row {
                display: flex;

                .cal-mth {
                    flex: 1 auto;
                    text-align: center;

                    .mth-cell {
                        height: 60px;
                        width: 60px;
                        line-height: 60px;
                        border-radius: 50%;
                        box-sizing: border-box;
                        cursor: pointer;
                        .transition-2;

                        &.active {
                            border: 1px solid @color;
                            color: white;
                            background-color: @color;
                        }
                    }
                }
            }
        }
    }

    .right-content {
        flex: 1;
        background-color: white;

        .right-head {
            padding: 16px 0 10px 16px;
            font-size: 18px;
            border-bottom: 1px solid #e3e3e3;

            .retrun-type {
                border: 1px solid #e3e3e3;
                padding: 6px 10px;
                border-radius: 4px;
            }

            .mth-calendar {
                .current,
                .pre-mth,
                .next-mth {
                    cursor: pointer;
                }

                .current {
                    color: #6b6b6b;
                    .transition-2;

                    &:hover {
                        color: black;
                    }
                }

                > i {
                    color: @color;
                    .transition-2;

                    &:hover {
                        color: @hover-color;
                    }
                }
            }
        }

        .right-content {
            .calendar {
                padding: 10px;
                box-sizing: border-box;
                width: 100%;

                .return-list {
                    overflow: auto;

                    .return-item {
                        white-space: nowrap; /*不换行 */
                        overflow: hidden; /*内容超出宽度时隐藏超出部分的内容 */
                        text-overflow: ellipsis; /* 当对象内文本溢出时显示省略标记(...) ；需与overflow:hidden;一起使用。*/
                        border-top: 1px solid #e3e3e3;
                        border-left: 8px solid;
                        border-bottom: 0;

                        &:last-of-type {
                            border-bottom: 1px solid #e3e3e3;
                        }

                        &.face-green {
                            border-left-color: greenyellow;
                        }

                        &.face-orange {
                            border-left-color: orange;
                        }

                        &.face-plum {
                            border-left-color: plum;
                        }
                    }
                }

                table {
                    width: 100%;
                    border-color: #ffffff;
                    border: 1px solid #e3e3e3;
                    table-layout: fixed;
                    word-wrap: break-word;
                    overflow: auto;

                    .weekday {
                        color: red;
                    }

                    tr {
                        border: 0;
                    }

                    td {
                        border: 1px solid #e3e3e3;
                        border-top: none;
                        border-left: none;
                        padding-top: 10px;
                    }

                    tr {
                        td:last-of-type {
                            border-right: none;
                        }
                    }

                    tbody {
                        tr:last-of-type {
                            td {
                                border-bottom: none;
                            }
                        }

                        td {
                            vertical-align: top;
                            cursor: pointer;
                            .transition-2;

                            &:hover {
                                background-color: @linght-background-color;
                            }
                        }

                        .not-current-mth {
                            color: #9c9b9b;
                        }

                        .current-day {
                            background-color: @linght-background-color;
                            color: red;
                        }

                        .active {
                            background-color: @backgroud-color !important;
                        }
                    }

                    thead {
                        text-align: center;
                    }
                }
            }
        }
    }
}
</style>