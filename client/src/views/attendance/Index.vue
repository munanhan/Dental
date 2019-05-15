<template>
    <div class="attendace">
        <div class="letf-content">
            <div class="left-header">
                <i
                    class="fa fa-arrow-circle-left mr-10 pre-mth"
                    @click.prevent.stop="switchDate('pre')"
                ></i>

                <span
                    v-if="!isCurrent"
                    class="current mr-10"
                    @click.prevent.stop="switchDate('current')"
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
                    @click.prevent.stop="switchDate('next')"
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
                            @click.prevent.stop="changMonth(4 * (item - 1) + mth)"
                        >
                            {{4 * (item - 1) + mth}}月
                        </div>

                    </div>
                </div>
            </div>

            <div class="pull-right excel-btn">
                <el-button
                    class="btns"
                    @click="exportExcel"
                    type="primary"
                >导出Excel</el-button>
            </div>
        </div>

        <div class="right-content">
            <div class="right-header">
                <el-button
                    class="btns"
                    @click="setAttendance('all')"
                    type="primary"
                >全勤</el-button>
                <el-button
                    class="btns"
                    @click="setAttendance('leave')"
                    type="primary"
                >请假</el-button>
                <el-button
                    class="btns"
                    @click="setAttendance('leave_earlier')"
                    type="primary"
                >早退</el-button>
                <el-button
                    class="btns"
                    @click="setAttendance('late')"
                    type="primary"
                >迟到</el-button>
                <el-button
                    class="btns"
                    @click="setAttendance('duty')"
                    type="primary"
                >缺勤</el-button>
                <el-button
                    class="btns"
                    @click="setAttendance('undo')"
                    type="primary"
                >撤销</el-button>
            </div>

            <div class="right-content">
                <div class="right-title">2019年5月 考勤表</div>

                <table>
                    <thead>
                        <tr>
                            <td
                                v-for="(item, index) in thead"
                                :key="index"
                            >
                                {{item.date}}
                            </td>
                        </tr>

                        <tr>
                            <td
                                v-for="(item, index) in thead"
                                :key="index"
                            >
                                {{item.weekDay}}
                            </td>
                        </tr>

                    </thead>
                    <tbody>
                        <tr>
                            <td>bbbbb</td>
                            <td>bbbbb</td>
                            <td>bbbbb</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Attendance",
    components: {},
    props: {},
    data() {
        return {
            selectYear: 0,
            selectMth: 0,
            selectDate: 0,

            currentYear: 0,
            currentMth: 0,
            currentDate: 0,

            selectText: "",

            thead: []
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
        that.buildDate();
    },
    watch: {},
    computed: {
        isCurrent() {
            return (
                this.currentYear == this.selectYear &&
                this.selectMth == this.currentMth
            );
        }
    },
    methods: {
        setSelectText() {
            let that = this,
                year = that.selectYear,
                mth = ("00" + that.selectMth).substr(-2),
                date = ("00" + that.selectDate).substr(-2);

            if (that.selectMth != that.currentMth) {
                date = "01";
            }

            that.selectText = `${year}年${mth}月${date}日`;
        },

        changMonth(value) {
            let that = this;
            that.selectMth = value;

            that.setSelectText();
            that.buildDate();
        },

        switchDate(type) {
            let that = this;

            switch (type) {
                case "current":
                    that.selectYear = that.currentYear;
                    that.selectMth = that.currentMth;
                    that.selectDate = that.currentDate;
                    break;
                case "pre":
                    that.selectYear = that.selectYear - 1;

                    if (that.selectYear == that.currentYear) {
                        that.selectMth = that.currentMth;
                        that.selectDate = that.currentDate;
                    } else {
                        that.selectMth = 1;
                        that.selectDate = 1;
                    }

                    break;
                case "next":
                    that.selectYear = that.selectYear + 1;

                    if (that.selectYear == that.currentYear) {
                        that.selectMth = that.currentMth;
                        that.selectDate = that.currentDate;
                    } else {
                        that.selectMth = 1;
                        that.selectDate = 1;
                    }

                    break;
            }

            that.setSelectText();
            that.buildDate();
        },

        buildDate() {
            let that = this,
                firstDateInstance = new Date(
                    that.selectYear,
                    that.selectMth - 1,
                    1
                ),
                firstDay = firstDateInstance.getDay(),
                lastDateInstance = new Date(that.selectYear, that.selectMth, 0),
                lastDate = lastDateInstance.getDate(),
                dateArray = [],
                weekMapping = {
                    0: "日",
                    1: "一",
                    2: "二",
                    3: "三",
                    4: "四",
                    5: "五",
                    6: "六"
                };

            for (var i = 0; i < lastDate; i++) {
                dateArray.push({
                    date: i + 1,
                    weekDay: weekMapping[(i + firstDay) % 7]
                });
            }

            that.thead = dateArray;
        },

        setAttendance(type) {
            let that = this;

            switch (type) {
                case "all":
                    break;
                case "leave":
                    break;
                case "leave_earlier":
                    break;
                case "late":
                    break;
                case "duty":
                    break;
                case "undo":
                    break;
            }
        },

        exportExcel() {}
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

.transition-2 {
    transition: all 0.2s;
}

.attendace {
    display: flex;
    height: 100%;

    .letf-content {
        width: 320px;
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

        .excel-btn {
            margin-right: 20px;
        }
    }

    .right-content {
        flex: 1;
        background-color: white;

        .right-header {
            height: 60px;
            border-bottom: 1px solid #e3e3e3;
            line-height: 60px;
            padding-left: 16px;
        }

        .right-content {
            .right-title {
                font-size: 20px;
                text-align: center;
                padding: 10px 0;
            }
        }
    }
}
</style>