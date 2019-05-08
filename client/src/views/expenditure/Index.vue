<template>
    <div class="expenditure">
        <div class="left-content">
            <div class="calendar-action">

                <span class="left-action">

                    <span class="ml-20 mr-10">发生日期</span>
                    <i
                        class="fa fa-arrow-circle-left mr-10 pre-mth"
                        @click.stop="switchDate('pre')"
                    ></i>
                    <!-- <span
                    v-if="curYear != selectYear || curMonth != selectMonth"
                    class="current mr-10"
                    @click.stop="switchDate"
                >今</span> -->
                    <span class="current mr-10">今</span>

                    <!-- <span v-else>&nbsp;&nbsp;&nbsp;</span> -->
                    <i
                        class="fa fa-arrow-circle-right mr-10 next-mth"
                        @click.stop="switchDate('next')"
                    ></i>

                </span>

                <span class="ml-10 date-type">
                    <el-radio-group
                        v-model="dateType"
                        size="medium"
                    >
                        <el-radio :label="0">天</el-radio>
                        <el-radio :label="1">周</el-radio>
                        <el-radio :label="2">月</el-radio>
                    </el-radio-group>
                </span>

            </div>

            <div class="search">
                <div>
                    <label class="search-item">
                        <span class="label-text mr-10">从</span>
                        <el-date-picker
                            v-model="search.dtFm"
                            type="date"
                            format="yyyy-MM-dd"
                            value-format="yyyy-MM-dd"
                            :clearable="false"
                            class="search-input"
                        >
                        </el-date-picker>
                    </label>
                </div>
                <div>
                    <label class="search-item">
                        <span class="label-text mr-10">到</span>
                        <el-date-picker
                            v-model="search.dtFm"
                            type="date"
                            format="yyyy-MM-dd"
                            value-format="yyyy-MM-dd"
                            :clearable="false"
                            class="search-input"
                        >
                        </el-date-picker>
                    </label>
                </div>
                <div>
                    <label class="search-item">
                        <span class="label-text mr-10">支出类型</span>
                        <el-select
                            v-model="search.payType"
                            collapse-tags
                            class="search-input"
                        >
                            <el-option
                                v-for="item in payType"
                                :key="item.id"
                                :label="item.label"
                                :value="item.id"
                            >
                            </el-option>
                        </el-select>
                    </label>
                </div>
                <div class="btn-container">
                    <div class="btn-item mr-10">
                        <el-button
                            type="primary"
                            class="btns"
                            @click="getData"
                        >查询</el-button>
                    </div>
                    <div class="btn-item ml-10">
                        <el-button
                            class="btns"
                            @click="exportExcel"
                        >导出Excel</el-button>
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
                <span>
                    2019年05年05日
                </span>
                <span class="ml-10 mr-10">
                    -
                </span>
                <span class="mr-10">
                    2019年05月11日
                </span>
                <span class="mr-10">
                    (共7天)
                </span>

                <span class="ml-10">
                    <el-button
                        type="primary"
                        class="btns"
                        @click="addPay"
                    >新增支出</el-button>
                </span>
            </div>

            <div class="pay-table">
                <el-table
                    border
                    class="width100 mb-10 details-table"
                    :data="tableData"
                    :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                    :height="tableHeight"
                    show-summary
                >
                    <el-table-column
                        prop="address"
                        label="删除"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="编辑"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="发生日期"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="经手人"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="负责人"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="支出类别"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="支出明细"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="支出金额"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="付款方式"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="备注"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                </el-table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Expenditure",
    components: {},
    props: {},
    data() {
        return {
            dateType: 0,
            search: {
                dtFm: new Date(),
                dtTo: new Date(),
                payType: 0
            },

            payType: [
                { id: 0, label: "全部" },
                { id: 1, label: "现金" },
                { id: 2, label: "转账" }
            ],

            tableData: [],
            tableHeight: "300px"
        };
    },
    created() {},
    mounted() {
        let that = this;

        that.$nextTick(() => {
            that.resizeTable();
        });

        //监听事件,由layout那边的resize抛出的
        if (window.addEventListener) {
            window.addEventListener("bodyChange", that.resizeTable);
        } else {
            window.attachEvent("bodyChange", that.resizeTable);
        }
    },
    watch: {},
    computed: {},
    methods: {
        switchDate() {},

        addPay() {},

        getData() {},

        exportExcel() {},

        resizeTable() {
            let that = this,
                tableHeight =
                    that.$refs.content.clientHeight -
                    that.$refs.head.clientHeight -
                    34;

            that.tableHeight = tableHeight;
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

.expenditure {
    display: flex;
    height: 100%;

    .left-content {
        width: 320px;
        border-right: 1px solid #e3e3e3;
        padding: 10px;
        font-size: 18px;

        .calendar-action {
            padding-bottom: 10px;
            border-bottom: 1px solid #a9a4a4;
            vertical-align: sub;
            margin-top: 6px;
            position: relative;

            .left-action {
                i {
                    color: @color;
                    .transition-2;

                    &:hover {
                        color: @hover-color;
                    }
                }
            }

            /deep/ .el-radio-group {
                position: absolute;
                top: 10px;

                .el-radio__label {
                    font-size: 18px;
                    padding-left: 5px;
                }

                .el-radio {
                    margin-right: 12px;
                    margin-top: -10px;

                    &:last-of-type {
                        margin-right: 0;
                    }
                }
            }

            .current,
            .pre-mth,
            .next-mth {
                cursor: pointer;
            }

            .date-type {
                // vertical-align: middle;
            }
        }

        .search {
            margin-top: 10px;

            .search-item {
                margin-bottom: 10px;
                display: inline-block;

                .label-text {
                    font-size: 16px;
                    display: inline-block;
                    width: 80px;
                    text-align: right;
                }

                .search-input {
                    max-width: 220px;
                }
            }

            .btn-container {
                display: flex;

                .btn-item {
                    flex: 1 auto;

                    &:first-of-type {
                        text-align: right;
                    }

                    .btns {
                        width: 100px;
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
        }

        .pay-table {
            padding: 10px;
        }
    }
}
</style>