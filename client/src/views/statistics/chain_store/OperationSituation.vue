<template>
    <div class="operation">
        <div class="search">
            <span class="mr-10">
                <el-date-picker
                    v-model="search.dateRange"
                    type="daterange"
                    align="right"
                    unlink-panels
                    range-separator="至"
                    start-placeholder="开始日期"
                    end-placeholder="结束日期"
                    :picker-options="pickerOptions"
                    format="yyyy-MM-dd"
                    value-format="yyyy-MM-dd"
                    :clearable="false"
                >
                </el-date-picker>
            </span>

            <span>
                <el-button
                    type="primary"
                    @click="getData"
                >查询</el-button>
            </span>

        </div>

        <div
            class="operation-content"
            ref="content"
            @scroll="notifyScroll"
        >

            <div class="operation-left">

                <div
                    class="operation-item clearfix"
                    ref="_1"
                >
                    <el-table
                        :data="tableData"
                        border
                        class="width100"
                        :header-cell-style="{backgroundColor:'#f1f1f1',color:'#3a3a3a'}"
                        show-summary
                    >
                        <el-table-column
                            prop="date"
                            label="序号"
                            align="center"
                        >
                        </el-table-column>

                        <el-table-column
                            prop="date"
                            label="诊所名称"
                            align="center"
                        >
                        </el-table-column>

                        <el-table-column
                            prop="date"
                            label="管家号"
                            align="center"
                        >
                        </el-table-column>

                        <el-table-column
                            prop="date"
                            label="初诊人数"
                            align="center"
                        >
                        </el-table-column>

                        <el-table-column
                            prop="date"
                            label="复诊人数"
                            align="center"
                        >
                        </el-table-column>

                        <el-table-column
                            prop="date"
                            label="初复诊比"
                            align="center"
                        >
                        </el-table-column>

                        <el-table-column
                            prop="date"
                            label="总收入"
                            align="center"
                        >
                        </el-table-column>

                    </el-table>

                </div>

                <div
                    class="operation-item"
                    ref="_2"
                >
                    <div><span class="chart-tip">&nbsp;</span>各诊所收入占比</div>
                    <ve-pie :data="clinicRatio"></ve-pie>
                </div>
                <div
                    class="operation-item"
                    ref="_3"
                >
                    <div><span class="chart-tip">&nbsp;</span>初诊人次</div>
                    <ve-pie :data="firstVisit"></ve-pie>
                </div>
                <div
                    class="operation-item"
                    ref="_4"
                >
                    <div><span class="chart-tip">&nbsp;</span>复诊人次</div>
                    <ve-pie :data="returnVisit"></ve-pie>
                </div>
            </div>

            <div
                class="operation-right"
                @wheel.stop.prevent="cateScroll"
            >
                <el-timeline>
                    <el-timeline-item
                        v-for="(activity, index) in activities"
                        :key="index"
                        color="#0bbd87"
                    >
                        <div
                            @click="pointSelect(activity)"
                            class="select-target"
                            :class="{ 'active': activity.select}"
                        >{{activity.content}}</div>
                    </el-timeline-item>
                </el-timeline>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    name: "OperationSituation",

    props: {
        update: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            search: {
                dateRange: [new Date(), new Date()]
            },

            activities: [
                {
                    target: "_1",
                    select: true,
                    content: "诊所业绩"
                },
                {
                    target: "_2",
                    select: false,
                    content: "收入占比"
                },
                {
                    target: "_3",
                    select: false,
                    content: "初诊人数"
                },
                {
                    target: "_4",
                    select: false,
                    content: "复诊人数"
                }
            ],

            pickerOptions: {
                shortcuts: [
                    {
                        text: "今天",
                        onClick(picker) {
                            picker.$emit("pick", [new Date(), new Date()]);
                        }
                    },
                    {
                        text: "昨天",
                        onClick(picker) {
                            let yesterday = getYesterday();

                            picker.$emit("pick", [yesterday, yesterday]);
                        }
                    },
                    {
                        text: "本周",
                        onClick(picker) {
                            let curWeek = getCurWeek();

                            picker.$emit("pick", [curWeek.start, curWeek.end]);
                        }
                    },
                    {
                        text: "本月",
                        onClick(picker) {
                            let curMonth = getCurMonth();

                            picker.$emit("pick", [
                                curMonth.start,
                                curMonth.end
                            ]);
                        }
                    }
                ]
            },

            tableData: [],

            //各诊所收入占比
            clinicRatio: {
                columns: ["type", "num"],
                rows: [
                    { type: "诊所1", num: 1393 },
                    { type: "诊所2", num: 3530 }
                ]
            },

            // 初诊人次
            firstVisit: {
                columns: ["type", "num"],
                rows: [
                    { type: "诊所1", num: 1393 },
                    { type: "诊所2", num: 3530 }
                ]
            },

            // 复诊人次
            returnVisit: {
                columns: ["type", "num"],
                rows: [
                    { type: "诊所1", num: 1393 },
                    { type: "诊所2", num: 3530 }
                ]
            },

            //记录元素的偏移高度
            contentHeight: 0,
            eleHeight: {},
            //记录当前活动的
            activeIndex: 0
        };
    },
    created() {},
    mounted() {
        let that = this;

        that.$nextTick(() => {
            that.resizeContent();
        });

        //监听事件,由layout那边的resize抛出的
        if (window.addEventListener) {
            window.addEventListener("bodyChange", that.resizeContent);
        } else {
            window.attachEvent("bodyChange", that.resizeContent);
        }
    },

    watch: {
        update(newValue, oldValue) {
            let that = this;

            if (newValue) {
                that.getData();
                that.$emit("update:update", false);
            }
        }
    },

    computed: {},
    methods: {
        resizeContent() {
            let that = this,
                contentEle = that.$refs.content,
                contentHeight = contentEle.clientHeight,
                scrollHeight = contentEle.scrollHeight;

            that.contentHeight = contentHeight + scrollHeight;

            for (var i = 1; i <= 4; i++) {
                //因为１０是外边距
                that.eleHeight["_" + i] = that.$refs["_" + i].offsetTop - 10;
            }
        },

        //右边的目录点击后，左边要滚动到相应的位置
        pointSelect(item) {
            let that = this,
                contentEle = that.$refs.content;

            for (var i = 0; i < that.activities.length; i++) {
                var actItem = that.activities[i];

                if (actItem == item) {
                    actItem.select = true;
                    //记录当前活动的
                    that.activeIndex = i;
                } else {
                    actItem.select = false;
                }
            }

            that.scrollAmin(contentEle, that.eleHeight[item.target], 300);

            //　苹果电脑浏览器兼容性不好，无法兼容
            // contentEle.scrollTo({
            //     top: that.eleHeight[item.target],
            //     behavior: "smooth"
            // })
        },

        //滚动动画
        //参考：　https://www.jianshu.com/p/b11b058ff5d8，注：这个页面的案例是有错误的
        scrollAmin(ele, top, duration) {
            let that = this,
                curTop = ele.scrollTop,
                durTop = top - curTop,
                startTime = +new Date(),
                scroll = function() {
                    const time = +new Date() - startTime;

                    //如果设置间隔的５００毫秒，则当前的高度加上要变动的高度乘以下次时间变动占间隔的的占比
                    ele.scrollTo(0, curTop + durTop * (time / duration));

                    //如果超过了间隔，就取消动画效果
                    if (time >= duration) {
                        ele.scrollTo(0, top);
                        cancelAnimationFrame(scroll);
                    } else {
                        //设置左边滚动的时候不要监听状态，防止死循环
                        that.notifyScrollStop = false;
                        requestAnimationFrame(scroll);
                    }
                };

            //设置左边滚动的时候不要监听状态，防止死循环
            that.notifyScrollStop = true;

            requestAnimationFrame(scroll);
        },

        //监听左边变动的高度，然后设置颜色
        notifyScroll(event) {
            let that = this;

            //如果停止监听的时候，则开始检测
            if (!that.notifyScrollStop) {
                clearTimeout(that.scrollTimer);

                that.scrollTimer = setTimeout(() => {
                    let contentEle = that.$refs.content,
                        curTop = contentEle.scrollTop,
                        hasSet = false;

                    for (var key in that.eleHeight) {
                        var item = that.eleHeight[key],
                            idx = +key.replace("_", "") - 1;

                        if (item >= curTop && !hasSet) {
                            that.activities[idx].select = true;
                            hasSet = true;

                            //记录当前活动的
                            that.activeIndex = idx;
                        } else {
                            that.activities[idx].select = false && !hasSet;
                        }
                    }
                }, 200);
            }
        },

        //右边滚动
        cateScroll(event) {
            let that = this;

            clearTimeout(that.rightWheelTimer);

            that.rightWheelTimer = setTimeout(() => {
                let count = 0,
                    rsIdx = that.activeIndex;

                if (event.wheelDelta) {
                    count = Math.floor(event.wheelDelta / 120);
                } else if (event.detail != null) {
                    count = -Math.floor(event.deltaY / 3);
                }

                //单次滚动，只滚动一条，不滚动多条，降低触发频率
                rsIdx += count > 0 ? -1 : 1;

                if (rsIdx < 0) {
                    rsIdx = 0;
                } else if (rsIdx >= that.activities.length) {
                    rsIdx = that.activities.length - 1;
                }

                that.pointSelect(that.activities[rsIdx]);
            }, 300);
        },

        getData() {
            let that = this;

            // 暂时关闭
            //     that.$api[that.api]
            //         [that.apiMethods](params)
            //         .then(res => {
            //             if (res.code == 0) {
            //                 that.afterGetData(res);
            //             } else {
            //                 that.$message.error(
            //                     res.msg || "获取数据失败，请重试."
            //                 );
            //             }

            //             //更新原来的refresh, 防止下次点击时不获取新数据
            //             that.$emit("update:refresh", false);
            //             //获取
            //             that.resizeContent();
            //         })
            //         .catch(e => {
            //             that.$message.error("获取数据失败，请重试.");

            //             //更新原来的refresh, 防止下次点击时不获取新数据
            //             that.$emit("update:refresh", false);
            //             that.resizeContent();
            //         });
        }
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";
.operation {
    position: relative;
    height: 100%;
    box-sizing: border-box;

    .search {
        padding: 10px;
        border-bottom: 1px solid #e3e3e3;
        height: 40px;
    }

    .operation-content {
        position: absolute;
        overflow: auto;
        top: 60px;
        bottom: 0;
        left: 0;
        right: 0;

        .operation-left {
            position: absolute;
            left: 10px;
            right: 200px;

            .operation-item {
                margin-bottom: 15px;

                &:first-of-type {
                    margin-top: 15px;
                }
            }

            .date-type {
                width: 100px;
            }

            .tip {
                color: red;
            }

            .chart-tip {
                background-color: @color;
                margin-right: 5px;
            }
        }

        .operation-right {
            width: 150px;
            position: fixed;
            right: 40px;
            margin-top: 30px;

            .select-target {
                cursor: pointer;
                &:hover {
                    color: #0bbd87;
                }
            }

            .active {
                color: #0bbd87;
            }
        }
    }
}
</style>