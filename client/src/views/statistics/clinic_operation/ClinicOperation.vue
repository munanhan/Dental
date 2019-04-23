<template>
    <div class="clinic">
        <div class="search">
            <span class="mr-10">统计日期</span>
            <span class="mr-10">
                <el-radio-group v-model="search.dateTypes">
                    <el-radio-button label="天"></el-radio-button>
                    <el-radio-button label="月"></el-radio-button>
                </el-radio-group>
            </span>

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
                <el-button type="primary" @click="getData">查询</el-button>

                <el-button type="primary" @click="test">测试</el-button>
            </span>

        </div>

        <div
            class="clinic-content"
            ref="content"
            @scroll="notifyScroll"
        >

            <div class="clinic-left">
                <!-- <div class="clinic-item">

            </div> -->

                <div
                    class="clinic-item clearfix"
                    ref="_1"
                >
                    <div class="pull-right">期初欠数： <span class="tip">20.10</span></div>
                    <el-table
                        :data="tableData"
                        border
                        class="width100"
                        :header-cell-style="{backgroundColor:'#f1f1f1',color:'#3a3a3a'}"
                        show-summary
                    >
                        <el-table-column
                            prop="date"
                            label="日期"
                            align="center"
                        >
                        </el-table-column>

                        <el-table-column
                            prop="date"
                            label="应收款项"
                            align="center"
                        >
                        </el-table-column>

                        <el-table-column
                            prop="date"
                            label="实际收款"
                            align="center"
                        >
                        </el-table-column>

                        <el-table-column
                            prop="date"
                            label="新增次数"
                            align="center"
                        >
                        </el-table-column>

                        <el-table-column
                            prop="date"
                            label="补收欠款"
                            align="center"
                        >
                        </el-table-column>

                        <el-table-column
                            prop="date"
                            label="预交数充值"
                            align="center"
                        >
                        </el-table-column>

                    </el-table>

                    <div class="pull-right">期末欠数： <span class="tip">20.10</span></div>
                </div>

                <div
                    class="clinic-item"
                    ref="_2"
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
                            label="主治医生"
                            align="center"
                        >
                        </el-table-column>

                        <el-table-column
                            prop="date"
                            label="总诊人数"
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
                            label="合计实收"
                            align="center"
                        >
                        </el-table-column>
                    </el-table>
                </div>

                <div
                    class="clinic-item"
                    ref="_3"
                >
                    <div><span class="chart-tip">&nbsp;</span>就诊人数</div>
                    <ve-line
                        :data="visitData"
                        :settings="visitSettings"
                    ></ve-line>
                </div>

                <div
                    class="clinic-item"
                    ref="_4"
                >
                    <div><span class="chart-tip">&nbsp;</span>营业收入</div>
                    <ve-line
                        :data="businessData"
                        :settings="businessSettings"
                    ></ve-line>
                </div>

                <div
                    class="clinic-item"
                    ref="_5"
                >
                    <div><span class="chart-tip">&nbsp;</span>患者来源收费统计</div>
                    <ve-pie :data="patientCost"></ve-pie>
                </div>

                <div
                    class="clinic-item"
                    ref="_6"
                >
                    <div><span class="chart-tip">&nbsp;</span>患者来源人数统计</div>
                    <ve-pie :data="patientNum"></ve-pie>
                </div>

                <div
                    class="clinic-item"
                    ref="_7"
                >
                    <div><span class="chart-tip">&nbsp;</span>收费分类统计</div>
                    <ve-pie :data="classificationOfCharges"></ve-pie>
                </div>

                <div
                    class="clinic-item"
                    ref="_8"
                >
                    <div><span class="chart-tip">&nbsp;</span>预约统计</div>
                    <ve-line
                        :data="bookData"
                        :settings="bookSettings"
                    ></ve-line>
                </div>

                <div
                    class="clinic-item"
                    ref="_9"
                >
                    <div><span class="chart-tip">&nbsp;</span>预约项目一览</div>
                    <ve-histogram
                        :data="bookProjectData"
                        :settings="bookProjectSettings"
                    ></ve-histogram>
                </div>

                <div
                    class="clinic-item"
                    ref="_10"
                >
                    <div><span class="chart-tip">&nbsp;</span>预约状态分析</div>
                    <ve-pie :data="reservation_status"></ve-pie>
                </div>

            </div>

            <div class="clinic-right" @wheel.stop.prevent="cateScroll">
                <el-timeline >
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

        <!-- 收费方式         -->
        <pay-type :show.sync='payTypeDialog'></pay-type>

        <!-- 初复诊记录明细 -->
        <first-visit :show.sync='firstVisitDialog'></first-visit>

        <!-- 复诊记录明细 -->
        <further-vist :show.sync='furtherVistDialog'></further-vist>

        <!-- 收费单流水 -->
        <toll-sheet :show.sync='tollSheetDialog'></toll-sheet>

        <!-- 患者费用明细 -->
        <patient-costs :show.sync='patientCostsDialog'></patient-costs>
    </div>
</template>

<script>
import Base from "../Base";
import { getYesterday, getCurWeek, getCurMonth } from "@common/util";
import PayType from './PayType';
import FirstVisit from './FirstVisit';
import FurtherVist from './FurtherVist';
import TollSheet from './TollSheet';
import PatientCosts from './PatientCosts';

export default {
    name: "ClinicOperation",
    components: { PayType, FirstVisit, FurtherVist, TollSheet, PatientCosts },

    mixins: [Base],

    props: {},
    data() {
        return {
            search: {
                dateRange: [new Date(), new Date()],
                dateTypes: "天"
            },

            activities: [
                {
                    target: "_1",
                    select: true,
                    content: "收入分类"
                },
                {
                    target: "_2",
                    select: false,
                    content: "就诊人次"
                },
                {
                    target: "_3",
                    select: false,
                    content: "就诊人数"
                },
                {
                    target: "_4",
                    select: false,
                    content: "营业收入"
                },
                {
                    target: "_5",
                    select: false,
                    content: "患者来源"
                },
                {
                    target: "_6",
                    select: false,
                    content: "来源人数"
                },
                {
                    target: "_7",
                    select: false,
                    content: "收费分类"
                },
                {
                    target: "_8",
                    select: false,
                    content: "预约统计"
                },
                {
                    target: "_9",
                    select: false,
                    content: "预约项目"
                },
                {
                    target: "_10",
                    select: false,
                    content: "预约状态"
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

            //就诊人数折线图
            visitData: {
                columns: ["date", "first_visit", "next_visit", "total_visit"],
                rows: [
                    {
                        date: "1/1",
                        first_visit: 1393,
                        next_visit: 1093,
                        total_visit: 0.32
                    },
                    {
                        date: "1/2",
                        first_visit: 3530,
                        next_visit: 3230,
                        total_visit: 0.26
                    },
                    {
                        date: "1/3",
                        first_visit: 2923,
                        next_visit: 2623,
                        total_visit: 0.76
                    },
                    {
                        date: "1/4",
                        first_visit: 1723,
                        next_visit: 1423,
                        total_visit: 0.49
                    },
                    {
                        date: "1/5",
                        first_visit: 3792,
                        next_visit: 3492,
                        total_visit: 0.323
                    },
                    {
                        date: "1/6",
                        first_visit: 4593,
                        next_visit: 4293,
                        total_visit: 0.78
                    }
                ]
            },

            visitSettings: {
                stack: { visit: ["first_visit", "next_visit", "total_visit"] },
                area: true,
                labelMap: {
                    first_visit: "初诊",
                    next_visit: "复诊",
                    total_visit: "总诊"
                }
            },

            //----------------------------------------

            //营业收入
            businessData: {
                columns: ["date", "cash", "op_income", "ac_receivable"],
                rows: [
                    {
                        date: "1/1",
                        cash: 1393,
                        op_income: 1093,
                        ac_receivable: 0.32
                    },
                    {
                        date: "1/2",
                        cash: 3530,
                        op_income: 3230,
                        ac_receivable: 0.26
                    },
                    {
                        date: "1/3",
                        cash: 2923,
                        op_income: 2623,
                        ac_receivable: 0.76
                    },
                    {
                        date: "1/4",
                        cash: 1723,
                        op_income: 1423,
                        ac_receivable: 0.49
                    },
                    {
                        date: "1/5",
                        cash: 3792,
                        op_income: 3492,
                        ac_receivable: 0.323
                    },
                    {
                        date: "1/6",
                        cash: 4593,
                        op_income: 4293,
                        ac_receivable: 0.78
                    }
                ]
            },

            businessSettings: {
                stack: { business: ["cash", "op_income", "ac_receivable"] },
                area: true,
                labelMap: {
                    cash: "现金收入",
                    op_income: "营业收入",
                    ac_receivable: "应收费用"
                }
            },

            //----------------------------------------

            //患者来源收费统计-----------------
            patientCost: {
                columns: ["type", "cost"],
                rows: [{ type: "1/1", cost: 1393 }, { type: "1/2", cost: 3530 }]
            },
            //--------------------------

            //患者来源人数统计--------------------
            patientNum: {
                columns: ["type", "num"],
                rows: [{ type: "1/1", num: 1393 }, { type: "1/2", num: 3530 }]
            },
            //---------------------------------

            //收费分类统计--------------------------
            classificationOfCharges: {
                columns: ["type", "num"],
                rows: [{ type: "1/1", num: 1393 }, { type: "1/2", num: 3530 }]
            },
            //-----------------------------------

            //预约统计--------------------
            bookData: {
                columns: ["date", "first_book", "next_book", "total_book"],
                rows: [
                    {
                        date: "1/1",
                        first_book: 1393,
                        next_book: 1093,
                        total_book: 0.32
                    },
                    {
                        date: "1/2",
                        first_book: 3530,
                        next_book: 3230,
                        total_book: 0.26
                    },
                    {
                        date: "1/3",
                        first_book: 2923,
                        next_book: 2623,
                        total_book: 0.76
                    },
                    {
                        date: "1/4",
                        first_book: 1723,
                        next_book: 1423,
                        total_book: 0.49
                    },
                    {
                        date: "1/5",
                        first_book: 3792,
                        next_book: 3492,
                        total_book: 0.323
                    },
                    {
                        date: "1/6",
                        first_book: 4593,
                        next_book: 4293,
                        total_book: 0.78
                    }
                ]
            },

            bookSettings: {
                stack: { business: ["first_book", "next_book", "total_book"] },
                labelMap: {
                    first_book: "初诊预约",
                    next_book: "复诊预约",
                    total_book: "总预约"
                }
            },
            //----------------------------

            //预约项目一览-----------------
            bookProjectData: {
                columns: [
                    "tooth_extraction",
                    "denture",
                    "dressing_change",
                    "tooth_filling",
                    "wearing_teeth",
                    "surgery",
                    "remove_stitches",
                    "root_canal_equipment",
                    "trial_crown",
                    "root_canal_therapy"
                ],
                rows: [
                    {
                        tooth_extraction: 1393,
                        denture: 1393,
                        dressing_change: 1093,
                        tooth_filling: 131321,
                        wearing_teeth: 131,
                        surgery: 13122,
                        remove_stitches: 133,
                        root_canal_equipment: 13257,
                        trial_crown: 12154,
                        root_canal_therapy: 2344
                    }
                ]
            },

            bookProjectSettings: {
                labelMap: {
                    tooth_extraction: "拔牙",
                    denture: "试戴义齿",
                    dressing_change: "换药",
                    tooth_filling: "补牙",
                    wearing_teeth: "戴牙",
                    surgery: "手术",
                    remove_stitches: "拆线",
                    root_canal_equipment: "根管预备",
                    trial_crown: "试内冠",
                    root_canal_therapy: "根管治疗"
                }
            },
            //-----------------------------

            //预约状态分析-------------------------
            reservation_status: {
                columns: ["type", "status"],
                rows: [
                    { type: "1/1", status: 1393 },
                    { type: "1/2", status: 3530 }
                ]
            },
            //--------------------------------

            //记录元素的偏移高度
            contentHeight: 0,
            eleHeight: {},
            //记录当前活动的
            activeIndex: 0,

            //停止监听滚动，用于右边点击和右边鼠标滚动的时候使用
            notifyScrollStop: false,
            scrollTimer: null,
            rightWheelTimer: null,

            //收费方式
            payTypeDialog: false,

            //初诊记录明细
            firstVisitDialog: false,

            //复诊记录明细
            furtherVistDialog: false,

            //收费单流水
            tollSheetDialog: false,

            //患者费用
            patientCostsDialog: false
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

    watch: {},
    computed: {},
    methods: {

        // test(){
        //     let that = this;
            // that.payTypeDialog = true;

            // that.firstVisitDialog = true;

            // that.furtherVistDialog = true;

            // that.tollSheetDialog = true;

            // that.patientCostsDialog = true;
        // },

        resizeContent() {
            let that = this,
                contentEle = that.$refs.content,
                contentHeight = contentEle.clientHeight,
                scrollHeight = contentEle.scrollHeight;

            that.contentHeight = contentHeight + scrollHeight;

            for (var i = 1; i <= 10; i++) {
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

                if(actItem == item){
                    actItem.select = true;
                    //记录当前活动的
                    that.activeIndex = i;
                }else{
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
                rsIdx += (count > 0? -1: 1);

                if (rsIdx < 0) {
                    rsIdx = 0;
                } else if (rsIdx >= that.activities.length) {
                    rsIdx = that.activities.length - 1;
                }

                that.pointSelect(that.activities[rsIdx]);
            }, 300);
        },

        afterGetData(res) {
            let that = this;
        }
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

.clinic {
    position: relative;
    height: 100%;
    box-sizing: border-box;

    .search {
        padding: 10px;
        border-bottom: 1px solid #e3e3e3;
        height: 40px;
        width: 100%;
    }

    .clinic-content {
        position: absolute;
        overflow: auto;
        top: 60px;
        bottom: 0;
        left: 0;
        right: 0;

        .clinic-left {
            position: absolute;
            left: 10px;
            right: 200px;

            .clinic-item {
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

        .clinic-right {
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