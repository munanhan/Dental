<template>
    <div class="trend-analy">
        <div class="action-bar">
            <div class="search-item">
                <el-radio-group v-model="search.dateTypes">
                    <el-radio-button :label="0">天</el-radio-button>
                    <el-radio-button :label="1">周</el-radio-button>
                    <el-radio-button :label="2">月</el-radio-button>
                </el-radio-group>
            </div>

            <div class="search-item">
                <span class="mr-10 ml-10">时间</span>

                <el-date-picker
                    v-model="search.dateRange"
                    type="daterange"
                    align="right"
                    unlink-panels
                    range-separator="至"
                    start-placeholder="开始日期"
                    end-placeholder="结束日期"
                    format="yyyy-MM-dd"
                    value-format="yyyy-MM-dd"
                    :clearable="false"
                    v-show="search.dateTypes == 0"
                >
                </el-date-picker>

                <span
                    class="week-range"
                    v-show="search.dateTypes == 1"
                >
                    <el-date-picker
                        v-model="search.dateRange[0]"
                        type="week"
                        align="right"
                        unlink-panels
                        format="yyyy 第 WW 周"
                        :clearable="false"
                    >
                    </el-date-picker>
                    <span class="ml-10 mr-10 range-text">至</span>
                    <el-date-picker
                        v-model="search.dateRange[1]"
                        type="week"
                        align="right"
                        unlink-panels
                        format="yyyy 第 WW 周"
                        :clearable="false"
                    >
                    </el-date-picker>
                </span>

                <el-date-picker
                    v-model="search.dateRange"
                    type="monthrange"
                    align="right"
                    unlink-panels
                    range-separator="至"
                    start-placeholder="开始日期"
                    end-placeholder="结束日期"
                    :clearable="false"
                    v-show="search.dateTypes == 2"
                >
                </el-date-picker>
            </div>

            <div class="search-item">
                <span class="mr-10 ml-10">分析类型</span>
                <el-select
                    v-model="search.analy"
                    placeholder="类型选择"
                    class="analy-type"
                >
                    <el-option
                        v-for="item in analyType"
                        :key="item.id"
                        :label="item.label"
                        :value="item.id"
                    >
                    </el-option>
                </el-select>
            </div>

            <span>
                <el-button
                    type="primary"
                    @click="getData"
                >查询</el-button>
            </span>

        </div>

        <div class="trend-content">
            <div class="line-title">{{lineTitle}}</div>

            <ve-line
                :data="lineDate"
                :settings="lineSettings"
            ></ve-line>
        </div>

    </div>
</template>

<script>
export default {
    name: "TrendAnalysis",
    components: {},
    props: {
        update: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            search: {
                dateRange: [new Date(), new Date()],
                dateTypes: 0,
                analy: 0
            },

            analyType: [
                { id: 0, label: "总收入" },
                { id: 1, label: "初诊人次" },
                { id: 2, label: "复诊人次" }
            ],

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

            profitSetting: {
                labelMap: {
                    value: "收入"
                }
            },

            visitSetting: {
                labelMap: {
                    value: "初诊人次"
                }
            },

            returnSetting: {
                labelMap: {
                    value: "复诊人次"
                }
            },

            lineSettings: {},

            lineTitle: ""
        };
    },
    created() {},
    mounted() {},
    watch: {
        update(newValue, oldValue) {
            let that = this;
            if (newValue) {
                that.getData();
                that.$emit("update:update", false);
            }
        },

        "search.analy": {
            handler(newValue, oldValue) {
                let that = this;

                switch (newValue) {
                    case 0:
                        that.lineTitle = "诊所总收入";
                        that.lineSettings = that.profitSetting;
                        break;
                    case 1:
                        that.lineTitle = "诊所初诊人次分析";
                        that.lineSettings = that.visitSetting;
                        break;
                    case 2:
                        that.lineTitle = "诊所复诊人次分析";
                        that.lineSettings = that.returnSetting;
                        break;
                }
            },

            immediate: true
        }
    },
    computed: {},
    methods: {
        getData() {
            let that = this;

            // 暂时关闭
            //     that.$api[that.api]
            //         [that.apiMethods](params)
            //         .then(res => {
            //             if (res.code == 200) {
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
.trend-analy {
    padding: 10px;

    .search-item {
        margin-bottom: 10px;

        .analy-type {
            width: 140px;
        }

        .week-range {
            .range-text {
                font-size: 14px;
            }

            /deep/ .el-date-editor.el-input,
            .el-date-editor.el-input__inner {
                width: 150px;
            }
        }
    }

    .trend-content {
        .line-title {
            margin: 10px 0;
            text-align: center;
            font-size: 22px;
            font-weight: bold;
        }
    }
}
</style>