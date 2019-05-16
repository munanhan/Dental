<template>
    <div class="attendace">
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

            <div class="pull-right excel-btn">
                <el-button
                    class="btns"
                    @click="exportExcel"
                    type="primary"
                >导出Excel</el-button>
            </div>
        </div>

        <div
            class="right-content"
            ref="content"
        >
            <div
                class="right-header"
                ref="contentHead"
            >
                <el-button
                    class="btns"
                    @click="setAttendance(1, '全勤')"
                    type="primary"
                >全勤</el-button>
                <el-button
                    class="btns"
                    @click="setAttendance(2, '请假')"
                    type="primary"
                >请假</el-button>
                <el-button
                    class="btns"
                    @click="setAttendance(3, '早退')"
                    type="primary"
                >早退</el-button>
                <el-button
                    class="btns"
                    @click="setAttendance(4, '迟到')"
                    type="primary"
                >迟到</el-button>
                <el-button
                    class="btns"
                    @click="setAttendance(5, '缺勤')"
                    type="primary"
                >缺勤</el-button>
                <el-button
                    class="btns"
                    @click="setAttendance(0, '')"
                    type="primary"
                >撤销</el-button>
            </div>

            <div class="right-content">
                <div
                    class="right-title"
                    ref="attendHead"
                >{{attendTitle}} 考勤表</div>

                <div
                    class="right-table"
                    :style="{
                            height: contentHeight
                        }"
                >
                    <table
                        cellspacing="0"
                        class="attendance-table"
                    >
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
                                    :class="{'weekday': item.isWeekDay}"
                                >
                                    {{item.weekDay}}
                                </td>
                            </tr>

                        </thead>
                        <tbody class="attendance-table-tbody">
                            <tr
                                v-for="(item, key, rowIdx) in tdata"
                                :key="rowIdx"
                            >
                                <td>{{key}}</td>
                                <td
                                    v-for="(attend, colIdx) in item"
                                    :key="rowIdx + colIdx"
                                    @mousedown.prevent.stop="selectStart(attend.isTotal, attend, rowIdx, colIdx)"
                                    @mouseenter.prevent.stop="selectEnd(attend.isTotal, attend, rowIdx, colIdx)"
                                    :class="{ 'day-select': !attend.isTotal, 'current-select': attend.currentSelect, 'other-select': attend.otherSelect }"
                                    :style="{
                                        backgroundColor: attend.backgroundColor
                                    }"
                                >{{attend.text}}</td>
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

            attendTitle: "",
            selectText: "",

            thead: [],

            tdata: {},

            contentHeight: "300px",

            //考勤对应的颜色
            colorMapping: { 0: "white", 1: "red" },
            //通知外部不清除，用于处理拖选的时候拖出边界，然后放到放开鼠标的时候不要清除框
            clear: true,
            //是否开始拖动
            start: false,
            //当前选中的点
            curRow: 0,
            curCol: 0,
            //上边和下边的停留点
            topRow: 0,
            bottomRow: 0,

            //左边和下面的停留点
            leftCol: 0,
            rightCol: 0,

            //延迟执行的timer
            selectTimer: null,

            //快速定位数组的位置
            quickRow: [],

            //判断是否有选中，用于处理点击上面的按钮无法确定当前是否有选中
            hasSelect: false,

            //用户的考勤数组数据映射，用于设置后快速找到相应的人员考勤数据
            dataObjectMapping: {}
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
        that.buildHeader();
        that.getData();
        that.getColor();

        that.$nextTick(() => {
            that.resizeContent();

            //监听事件,由layout那边的resize抛出的
            window.addEventListener("bodyChange", that.resizeContent);

            //绑定全局的mouseup事件，取消移动
            document.addEventListener("click", that.documentCelearSelect);
        });
    },

    destroyed() {
        document.removeEventListener("click", this.documentCelearSelect);
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
        //重新计算高度
        resizeContent() {
            let that = this,
                contentHeight =
                    that.$refs.content.clientHeight -
                    that.$refs.contentHead.clientHeight -
                    that.$refs.attendHead.clientHeight;

            that.contentHeight = `${contentHeight}px`;
        },

        //获取状态对应的颜色
        getColor() {
            let that = this;
        },

        setSelectText() {
            let that = this,
                year = that.selectYear,
                mth = ("00" + that.selectMth).substr(-2),
                date = ("00" + that.selectDate).substr(-2);

            if (that.selectMth != that.currentMth) {
                date = "01";
            }

            that.attendTitle = `${year}年${mth}月`;
            that.selectText = `${year}年${mth}月${date}日`;
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
            }

            that.setSelectText();
            that.buildHeader();
            that.getData();
        },

        buildHeader() {
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
                },
                totalMapping = [
                    {
                        text: "全勤",
                        totalText: "合计"
                    },
                    {
                        text: "请假",
                        totalText: "合计"
                    },
                    {
                        text: "早退",
                        totalText: "合计"
                    },
                    {
                        text: "迟到",
                        totalText: "合计"
                    },
                    {
                        text: "缺勤",
                        totalText: "合计"
                    }
                ];

            //输入人名列
            dateArray.push({
                date: "",
                weekDay: "",
                isWeekDay: ""
            });

            for (var i = 0; i < lastDate; i++) {
                var weekNum = (i + firstDay) % 7,
                    weekDay = weekMapping[weekNum];

                dateArray.push({
                    date: i + 1,
                    weekDay: weekDay,
                    isWeekDay: weekNum == 0 || weekNum == 6
                });
            }

            for (var i = 0; i < totalMapping.length; i++) {
                var item = totalMapping[i];

                dateArray.push({
                    date: item.text,
                    weekDay: item.totalText,
                    isWeekDay: false
                });
            }

            that.thead = dateArray;
        },

        getData() {
            //测试数据
            let that = this,
                lastDateInstance = new Date(that.selectYear, that.selectMth, 0),
                lastDate = lastDateInstance.getDate(),
                totalMapping = [
                    {
                        type: 1,
                        text: "全勤"
                    },
                    {
                        type: 2,
                        text: "请假"
                    },
                    {
                        type: 3,
                        text: "早退"
                    },
                    {
                        type: 4,
                        text: "迟到"
                    },
                    {
                        type: 5,
                        text: "缺勤"
                    }
                ];

            let tdata = {
                aaa: [],
                bbb: [],
                ccc: []
            };

            for (var j = 0; j < 3; j++) {
                var item = [];

                for (var i = 0; i < lastDate; i++) {
                    item.push({
                        day: i + 1,
                        type: 0,
                        text: "",
                        isTotal: false,
                        backgroundColor: that.colorMapping[0],
                        currentSelect: false,
                        otherSelect: false
                    });
                }

                for (var i = 0; i < totalMapping.length; i++) {
                    var mappingItem = totalMapping[i];

                    item.push({
                        day: i + 1,
                        type: mappingItem.type,
                        text: "0",
                        isTotal: true,
                        backgroundColor: false,
                        currentSelect: false,
                        otherSelect: false
                    });
                }

                //用于遍历
                that.quickRow[j] = item;

                if (j == 0) {
                    tdata["aaa"] = item;

                    //设置快速映射
                    that.dataObjectMapping["aaa"] = 0;
                } else if (j == 1) {
                    tdata["bbb"] = item;

                    that.dataObjectMapping["bbb"] = 1;
                } else if (j == 2) {
                    tdata["ccc"] = item;

                    that.dataObjectMapping["ccc"] = 2;
                }
            }

            that.tdata = tdata;
        },

        selectStart(isTotal, attend, rowIdx, colIdx) {
            let that = this;

            //汇总就跳过
            if (isTotal) {
                return;
            }

            //这里清除选择的数量
            that.clearSelect();

            //设置开始的标志
            that.start = true;

            //设置外部不清除，用于处理拖出table的时候的问题
            that.clear = false;

            //判断是否有选中，用于处理点击上面的按钮无法确定当前是否有选中
            that.hasSelect = true;

            //记录开始的位置
            that.curRow = rowIdx;
            that.curCol = colIdx;

            //设置左右和上下区域，降低遍历的数量
            that.topRow = that.bottomRow = rowIdx;
            that.leftCol = that.rightCol = colIdx;

            //设置当前的选择颜色
            attend.currentSelect = true;

            //绑定全局的mouseup事件，取消移动
            document.addEventListener("mouseup", event => {
                that.start = false;

                setTimeout(() => {
                    //设置外部不清除，用于处理拖出table的时候的问题
                    that.clear = true;
                }, 300);
            });
        },

        //是否需要清除选中
        documentCelearSelect(event) {
            let that = this,
                target = event.target,
                targetClassName = target.className;

            //是否不是拖出外部table时候的点击事件，如果是，则忽略删除
            if (that.clear) {
                if (
                    targetClassName.indexOf("attendance-table-tbody") === -1 &&
                    targetClassName.indexOf("day-select") === -1
                ) {
                    that.clearSelect();
                }
            }
        },

        //清除选择
        clearSelect() {
            let that = this;

            //清除原来的选择
            for (var row = that.topRow; row <= that.bottomRow; row++) {
                for (var col = that.leftCol; col <= that.rightCol; col++) {
                    var item = that.quickRow[row][col];
                    item["otherSelect"] = false;
                    item["currentSelect"] = false;
                }
            }

            //判断是否有选中，用于处理点击上面的按钮无法确定当前是否有选中
            that.hasSelect = false;
        },

        //鼠标移动到停止的位置
        selectEnd(isTotal, attend, rowIdx, colIdx) {
            let that = this;

            //汇总就跳过
            if (isTotal) {
                return;
            }

            if (that.start) {
                //延迟计算
                clearTimeout(that.selectTimer);

                that.selectTimer = setTimeout(() => {
                    //找出左右，上下的有效区间，包含选中和需要取消选中的区间
                    that.topRow = Math.min(that.topRow, that.bottomRow, rowIdx);
                    that.leftCol = Math.min(
                        that.leftCol,
                        that.rightCol,
                        colIdx
                    );
                    that.bottomRow = Math.max(
                        that.topRow,
                        that.bottomRow,
                        rowIdx
                    );
                    that.rightCol = Math.max(
                        that.leftCol,
                        that.rightCol,
                        colIdx
                    );

                    let seedLeft = colIdx - that.curCol <= 0 ? "left" : "right",
                        seedTop = rowIdx - that.curRow <= 0 ? "top" : "bottom";

                    for (var row = that.topRow; row <= that.bottomRow; row++) {
                        for (
                            var col = that.leftCol;
                            col <= that.rightCol;
                            col++
                        ) {
                            var flag =
                                // 当 seedLeft 为left的时候，col 位于区间[ idx, curCol ]
                                // 当 seedLeft 为right的时候 col 位于区间[ curCol, idex  ]
                                (seedLeft == "left"
                                    ? col >= colIdx && col <= that.curCol
                                    : col <= colIdx && col >= that.curCol) &&
                                // 当 seedTop 为top的时候，row 位于区间[ idx, curRow ]
                                // 当 seedTop 为bottom的时候 row 位于区间[ curRow, idx ]
                                (seedTop == "bottom"
                                    ? row >= that.curRow && row <= rowIdx
                                    : row <= that.curRow && row >= rowIdx);

                            that.quickRow[row][col]["otherSelect"] = flag;
                        }
                    }

                    //调整left和bottom，降低遍历的元素数量，提高速度
                    // that.topRow = Math.min(
                    //     that.topRow,
                    //     that.curRow,
                    //     that.bottomRow
                    // );
                    // that.leftCol = Math.min(
                    //     that.leftCol,
                    //     that.curCol,
                    //     that.rightCol
                    // );
                    // that.bottomRow = Math.max(
                    //     that.topRow,
                    //     that.curRow,
                    //     that.bottomRow
                    // );
                    // that.rightCol = Math.max(
                    //     that.leftCol,
                    //     that.curCol,
                    //     that.rightCol
                    // );
                }, 80); //可以设置60,80，100
            }
        },

        //设置状态
        setAttendance(type, text) {
            let that = this,
                rowCalc = []; //需要计算row的数量

            //判断是否有选中，用于处理点击上面的按钮无法确定当前是否有选中
            if (that.hasSelect) {
                //这里设置后顺带清楚，提升效率，不调用clearSelect
                for (var row = that.topRow; row <= that.bottomRow; row++) {
                    rowCalc.push(row);

                    for (var col = that.leftCol; col <= that.rightCol; col++) {
                        var item = that.quickRow[row][col];

                        item["type"] = type;
                        item["text"] = text;
                        item["backgroundColor"] = that.colorMapping[type];
                        item["otherSelect"] = false;
                        item["currentSelect"] = false;
                    }
                }

                //计算合计
                that.calcTotal(rowCalc);
                //发送远程的数据
                that.updateRemote(data);

                //判断是否有选中，用于处理点击上面的按钮无法确定当前是否有选中
                that.hasSelect = false;
            }
        },

        //计算合计
        calcTotal(rows) {
            let that = this;

            for (var i = 0; i < rows.length; i++) {
                var rowIdx = rows[i],
                    curRow = that.quickRow[rowIdx],
                    count = {};

                for (var j = 0; j < curRow.length; j++) {
                    var item = curRow[j];

                    if (item.type) {
                        if (item.isTotal) {
                            item.text = count[item.type] || 0;
                        } else {
                            count[item.type] = (count[item.type] || 0) + 1;
                        }
                    }
                }
            }
        },

        //更新考勤数据
        updateRemote(data) {
            let that = this;

            // TODO
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
        width: 100%;
        overflow: hidden;
        box-sizing: border-box;

        .right-header {
            height: 60px;
            border-bottom: 1px solid #e3e3e3;
            line-height: 60px;
            padding-left: 16px;
            box-sizing: border-box;
        }

        .right-content {
            .right-title {
                font-size: 20px;
                text-align: center;
                padding: 10px 0;
                box-sizing: border-box;
            }

            .right-table {
                width: 100%;
                overflow: auto;
                box-sizing: border-box;

                .attendance-table {
                    border: 1px solid #b7b2b2;
                    margin: 0 10px;

                    .weekday {
                        color: red;
                    }

                    td {
                        border: 1px solid #e3e3e3;
                        border-top: none;
                        border-left: none;
                        padding: 10px 6px;
                        min-width: 40px;
                        height: 20px;
                        text-align: center;
                        vertical-align: middle;

                        &.day-select {
                            cursor: pointer;
                        }

                        &.current-select {
                            background-color: @color !important;
                            opacity: 0.6 !important;
                            box-shadow: 4px 2px 10px @color;
                        }

                        &.other-select {
                            background-color: @color !important;
                            opacity: 0.3;
                            box-shadow: 4px 2px 10px @color;
                        }
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
                    }
                }
            }
        }
    }
}
</style>