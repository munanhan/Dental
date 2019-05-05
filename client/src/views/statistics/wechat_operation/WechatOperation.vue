<template>
    <div class="wechat-operation">
        <el-row class="head">
            <el-col class="head-detail">
                <div class="head-item">
                    <div class="top theme-font-color">0</div>
                    <div class="head-button">昨日新增关注</div>
                </div>
            </el-col>
            <el-col class="head-detail">
                <div class="head-item">
                    <div class="top theme-font-color">0/0</div>
                    <div class="head-button">昨日取消关注</div>
                </div>
            </el-col>
            <el-col class="head-detail">
                <div class="head-item">
                    <div class="top theme-font-color">0</div>
                    <div class="head-button">总关注人数</div>
                </div>
            </el-col>
            <el-col class="head-detail">
                <div class="head-item">
                    <div class="top theme-font-color">0</div>
                    <div class="head-button">新增微信预约</div>
                </div>
            </el-col>
            <el-col class="head-detail">
                <div class="head-item">
                    <div class="top theme-font-color">0</div>
                    <div class="head-button">新增微信咨询</div>
                </div>
            </el-col>
        </el-row>

        <el-row class="trend">
            <div class="trend-title">
                <span class="chart-tip">&nbsp;</span>
                趋势图
            </div>
            <div class="tend-content">
                <div class="mb-10">
                    <span class="mr-20">
                        <el-date-picker
                            v-model="trendSearch.dateRange"
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
                        <el-radio-group
                            v-model="trendSearch.type"
                            @change="trendChange"
                        >
                            <el-radio-button :label="0">新增关注</el-radio-button>
                            <el-radio-button :label="1">取消关注</el-radio-button>
                            <el-radio-button :label="2">新增预约</el-radio-button>
                            <el-radio-button :label="3">新增咨询</el-radio-button>
                        </el-radio-group>
                    </span>
                </div>

                <div v-if="showChart">
                    <ve-line
                        :data="lineDate"
                        :settings="lineSettings"
                    ></ve-line>
                </div>
            </div>

        </el-row>

        <el-row class="detail">
            <div class="action-bar">
                <div class="search-item">
                    <el-date-picker
                        v-model="detailSearch.dateRange"
                        type="daterange"
                        align="right"
                        unlink-panels
                        range-separator="至"
                        start-placeholder="开始日期"
                        end-placeholder="结束日期"
                        format="yyyy-MM-dd"
                        value-format="yyyy-MM-dd"
                        :clearable="false"
                    >
                    </el-date-picker>
                </div>
                <div class="action-bar-right">
                    <el-button
                        type="primary"
                        @click="exportExcel"
                    >导出Excel</el-button>
                </div>
            </div>
            <div>
                <el-table
                    border
                    class="width100 mb-10"
                    :data="tableData"
                    :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                    :height="320"
                >
                    <el-table-column
                        label="时间"
                        width="120"
                        align="center"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="name"
                        label="新增关注"
                        align="center"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="取消关注"
                        align="center"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="新增微信预约"
                        align="center"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="新增咨询"
                        align="center"
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="总关注人数"
                        align="center"
                    >
                    </el-table-column>
                </el-table>
            </div>
        </el-row>
    </div>
</template>

<script>
export default {
    name: "WechatOperation",
    components: {},

    props: {
        refresh: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            trendSearch: {
                dateRange: [new Date(), new Date()],
                type: 0
            },

            detailSearch: {
                dateRange: [new Date(), new Date()]
            },

            tableData: [],            

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

            lineDate: {
                columns: ["date", "value"],
                rows: [
                    {
                        date: "2019-01-10",
                        value: 1393
                    },
                    {
                        date: "2019-01-11",
                        value: 3530
                    },
                    {
                        date: "2019-01-12",
                        value: 2923
                    },
                    {
                        date: "2019-01-13",
                        value: 1723
                    },
                    {
                        date: "2019-01-14",
                        value: 3792
                    },
                    {
                        date: "2019-01-15",
                        value: 4593
                    }
                ]
            },

            lineSettings: {
                labelMap: {
                    value: "数量"
                }
            },

            //因为首次加载时候图表没有显示， 所以要另外处理
            showChart: false
        };
    },
    created() {},
    mounted() {},
    watch: {
        refresh(newValue, oldValue) {
            let that = this;

            //因为首次加载时候图表没有显示， 所以要另外处理
            that.showChart = true;

            that.getTrendData();

            //更新原来的refresh, 防止下次点击时不通知更新
            that.$emit("update:refresh", false);
        }
    },
    computed: {},
    methods: {
        trendChange(value) {
            let that = this;

            that.getTrendData();
        },

        getTrendData() {
            let that = this;
        },

        getDetailData() {
            let that = this;
        },

        exportExcel() {
            let that = this;
        }
    }
};
</script>
<style lang="less" scoped>
//导入全局的颜色
@import "~@css/var";

.wechat-operation {
    position: relative;
    height: 100%;
    box-sizing: border-box;
    background-color: #efefef;
    padding: 10px;
    overflow: auto;

    .gray-border {
        border: 1px solid #e3e3e3;
    }

    .bg-white {
        background-color: white;
        box-shadow: 2px 2px 10px #888888;
        .gray-border;
    }

    .head {
        padding: 10px;
        height: 80px;
        line-height: 30px;
        display: flex;
        margin-bottom: 10px;

        .bg-white;

        .head-detail {
            font-size: 18px;
            border-right: 1px solid #e3e3e3;
            cursor: pointer;

            &:last-of-type {
                border-right: 0;
            }

            &:hover {
                .head-item {
                    .top,
                    .head-button {
                        color: @hover-color;
                    }
                }
            }

            .head-item {
                .top {
                    text-align: center;
                    font-size: 30px;
                }

                .head-button {
                    text-align: center;
                    transition: 0.2s all;
                }
            }
        }
    }

    .trend {
        margin-bottom: 10px;

        .bg-white;

        .trend-title {
            color: @color;
            padding: 10px;
            .gray-border;

            .chart-tip {
                background-color: @color;
                margin-right: 5px;
            }
        }

        .tend-content {
            padding: 10px;
        }
    }

    .detail {
        padding: 10px 10px 0 10px;
        .bg-white;
    }
}
</style>