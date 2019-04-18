<template>
    <div class="clinic">
        <div class="search">
            <span class="mr10">统计日期</span>
            <span class="mr10">
                <el-radio-group v-model="search.dateTypes">
                    <el-radio-button label="天"></el-radio-button>
                    <el-radio-button label="月"></el-radio-button>
                </el-radio-group>
            </span>

            <span class="mr10">
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
                <el-button type="primary">查询</el-button>
            </span>

        </div>

        <div class="clinic-content">

            <div class="clinic-left">
                <!-- <div class="clinic-item">

            </div> -->

                <div class="clinic-item clearfix">
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

                <div class="clinic-item">
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

                <div class="clinic-item">
                    <div><span class="chart-tip">&nbsp;</span>就诊人数</div>
                    <ve-line
                        :data="visitData"
                        :settings="visitSettings"
                    ></ve-line>
                </div>

                <div class="clinic-item">
                    <div><span class="chart-tip">&nbsp;</span>营业收入</div>
                    <ve-line
                        :data="businessData"
                        :settings="businessSettings"
                    ></ve-line>
                </div>

                <div class="clinic-item">
                    <div><span class="chart-tip">&nbsp;</span>患者来源收费统计</div>
                    <ve-pie :data="patientCost"></ve-pie>
                </div>

                <div class="clinic-item">
                    <div><span class="chart-tip">&nbsp;</span>患者来源人数统计</div>
                    <ve-pie :data="patientNum"></ve-pie>
                </div>

                <div class="clinic-item">
                    <div><span class="chart-tip">&nbsp;</span>收费分类统计</div>
                    <ve-pie :data="classificationOfCharges"></ve-pie>
                </div>

                <div class="clinic-item">
                    <div><span class="chart-tip">&nbsp;</span>预约统计</div>
                    <ve-line
                        :data="bookData"
                        :settings="bookSettings"
                    ></ve-line>
                </div>

                <div class="clinic-item">
                    <div><span class="chart-tip">&nbsp;</span>预约项目一览</div>
                    <ve-histogram
                        :data="bookProjectData"
                        :settings="bookProjectSettings"
                    ></ve-histogram>
                </div>

                <div class="clinic-item">
                    <div><span class="chart-tip">&nbsp;</span>预约状态分析</div>
                    <ve-pie :data="reservation_status"></ve-pie>
                </div>

            </div>

            <div class="clinic-right">
                <el-timeline>
                    <el-timeline-item
                        v-for="(activity, index) in activities"
                        :key="index"
                    >
                        {{activity.content}}
                    </el-timeline-item>
                </el-timeline>
            </div>

        </div>

    </div>
</template>

<script>
import Base from "../Base";
import { getYesterday, getCurWeek, getCurMonth } from "@common/util";
export default {
    name: "ClinicOperation",
    components: {},

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
                    content: "收入分类"
                },
                {
                    content: "就诊人次"
                },
                {
                    content: "就诊人数"
                },
                {
                    content: "营业收入"
                },
                {
                    content: "患者来源"
                },
                {
                    content: "来源人数"
                },
                {
                    content: "收费分类"
                },
                {
                    content: "预约人数"
                },
                {
                    content: "预约项目"
                },
                {
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

            contentHeight: 0
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
            window.addEventListener("bodyChange", that.resizeSubMenu);
        } else {
            window.attachEvent("bodyChange", that.resizeSubMenu);
        }
    },
    watch: {},
    computed: {},
    methods: {

        resizeContent(){
            let that = this;

            
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

.mr10 {
    margin-right: 10px;
}

.clinic {
    // padding: 0 10px;

    // position: absolute;
    // top: 10px;
    // bottom: 0;
    // left: 10px;
    // right: 10px;
    position: relative;
    height: 100%;
    box-sizing: border-box;
    // display: flex;
    // flex-direction: row;

    .search {
        padding: 0 10px 10px;
        border-bottom: 1px solid #e3e3e3;
        height: 40px;
        width: 100%;
    }

    .clinic-content {
        display: flex;
        height: 100%;
        top: 15px;
        // flex: 1 auto;
        position: absolute;
        overflow: auto;
        top: 70px;
        bottom: 0;
        left: 0;
        right: 0;

        .clinic-left {
            flex: 1 auto;
            position: absolute;
            left: 10px;
            right: 200px;

            .clinic-item {
                margin-bottom: 15px;
            }

            .date-type {
                width: 100px;
            }

            .tip {
                color: red;
            }

            .chart-tip {
                background-color: @color;
            }
        }

        .clinic-right {
            width: 200px;
            position: fixed;
            right: 0;
        }
    }
}
</style>