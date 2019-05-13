<template>
    <div class="recovery">
        <div class="left-content">
            <div class="calendar-action">

                <span class="left-action">

                    <span class="ml-20 mr-10">录入日期</span>
                    <i
                        class="fa fa-arrow-circle-left mr-10 pre-mth"
                        @click.prevent.stop="switchDate('pre')"
                    ></i>
                    <!-- <span
                    v-if="curYear != selectYear || curMonth != selectMonth"
                    class="current mr-10"
                    @click.stop="switchDate"
                >今</span> -->
                    <span
                        v-if="!isCurrentDate"
                        class="current mr-10"
                        @click.prevent.stop="switchDate('current')"
                    >今</span>

                    <span
                        v-if="isCurrentDate"
                        class="mr-10"
                    >
                        &nbsp;&nbsp;
                    </span>

                    <!-- <span v-else>&nbsp;&nbsp;&nbsp;</span> -->
                    <i
                        class="fa fa-arrow-circle-right mr-10 next-mth"
                        @click.prevent.stop="switchDate('next')"
                    ></i>

                </span>

                <span class="ml-10 date-type">
                    <el-radio-group
                        v-model="dateType"
                        size="medium"
                        @change="dateTypeChange"
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
                            @change="changeData('fm')"
                        >
                        </el-date-picker>
                    </label>
                </div>
                <div>
                    <label class="search-item">
                        <span class="label-text mr-10">到</span>
                        <el-date-picker
                            v-model="search.dtTo"
                            type="date"
                            format="yyyy-MM-dd"
                            value-format="yyyy-MM-dd"
                            :clearable="false"
                            class="search-input"
                            @change="changeData('to')"
                        >
                        </el-date-picker>
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
                    {{dateFmText}}
                </span>
                <span class="ml-10 mr-10">
                    -
                </span>
                <span class="mr-10">
                    {{dateToText}}
                </span>
                <span class="mr-10">
                    (共{{dateCount}}天)
                </span>

                <span class="ml-10">
                    <el-button
                        type="primary"
                        class="btns"
                        @click="addRecoveryDialog = true"
                    >新增回收</el-button>
                </span>
            </div>

            <div class="pay-table">
                <el-table
                    border
                    class="width100"
                    :data="tdata"
                    :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                    :height="tableHeight"
                >
                    <el-table-column
                        prop="address"
                        label="感染性体积/桶"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="感染性重量/kg"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="损伤性体积/桶"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="损伤性重量/kg"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="交接人"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="运送人"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="处置单位"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="address"
                        label="交接时间"
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

                    <el-table-column
                        label="操作"
                        align="center"
                        width="100"
                    >
                        <template slot-scope="scope">
                            <el-tooltip
                                effect="dark"
                                content="修改"
                                placement="top"
                            >
                                <el-button
                                    type="primary"
                                    size="mini"
                                    icon="el-icon-edit"
                                    circle
                                    @click.stop="showEditDialog(scope.row)"
                                ></el-button>
                            </el-tooltip>
                            <el-tooltip
                                effect="dark"
                                content="删除"
                                placement="bottom"
                            >
                                <el-button
                                    type="danger"
                                    size="mini"
                                    icon="el-icon-delete"
                                    circle
                                    @click.stop="del(scope.row, scope.$index)"
                                ></el-button>
                            </el-tooltip>
                        </template>
                    </el-table-column>

                </el-table>
            </div>
        </div>
		
        <add-recovery :show.sync="addDialog"></add-recovery>
        <edit-recovery :show.sync="editDialog"></edit-recovery>
    </div>
</template>

<script>
import { formatDate } from "@common/util";
import AddRecovery from "./AddRecovery";
import EditRecovery from "./EditRecovery";
import Base from "../base/TableBase";

export default {
    name: "Recovery",
    components: { AddRecovery, EditRecovery },
    mixins: [Base],

    props: {},
    data() {
        return {
            dateType: 0,
            search: {
                dtFm: new Date(),
                dtTo: new Date()
            },

            pager: false,

            dateFmText: "",
            dateToText: "",
            dateCount: 0,

            //当前的日期
            currentDate: null,

            isCurrentDate: false,

        };
    },
    created() {},
    mounted() {
        let that = this;

        //设置当前的日期
        that.currentDate = formatDate(new Date(), "yyyy-MM-dd");
        that.dateFmText = formatDate(that.search.dtFm, "yyyy年MM月dd日");
        that.dateToText = formatDate(that.search.dtTo, "yyyy年MM月dd日");

        that.checkCurrentData();
        that.calcDateCount();
    },
    watch: {
        "search.dtFm": {
            handler(newValue, oldValue) {
                let that = this;
                that.dateFmText = formatDate(newValue, "yyyy年MM月dd日");

                that.calcDateCount();
                that.checkCurrentData();
            }
        },

        "search.dtTo": {
            handler(newValue, oldValue) {
                let that = this;
                that.dateToText = formatDate(newValue, "yyyy年MM月dd日");

                that.calcDateCount();
                that.checkCurrentData();
            }
        }
    },
    computed: {},

    methods: {
        dateTypeChange(value) {
            let that = this,
                type = value == 0 ? "day" : value == 1 ? "week" : "month";
            that.switchDate(type);
        },

        checkCurrentData() {
            let that = this;

            that.isCurrentDate =
                formatDate(that.search.dtFm, "yyyy-MM-dd") ==
                    that.currentDate &&
                formatDate(that.search.dtTo, "yyyy-MM-dd") == that.currentDate;
        },

        calcDateCount() {
            let that = this,
                startTime = new Date(that.search.dtFm).getTime(),
                endTime = new Date(that.search.dtTo).getTime(),
                count = Math.round((endTime - startTime) / 86400000) + 1;

            that.dateCount = count;
        },

        //如果开始和结束的时间相减是负责则同步两边的值
        changeData(type) {
            let that = this,
                startTime = new Date(that.search.dtFm).getTime(),
                endTime = new Date(that.search.dtTo).getTime(),
                minus = endTime - startTime;

            if (minus < 0) {
                if (type == "fm") {
                    that.search.dtTo = that.search.dtFm;
                } else if (type == "to") {
                    that.search.dtFm = that.search.dtTo;
                }
            }
        },

        switchDate(type) {
            let that = this;

            that.search.dtFm = new Date(that.search.dtFm);

            let year = that.search.dtFm.getFullYear(),
                mth = that.search.dtFm.getMonth(),
                weekday = that.search.dtFm.getDay(),
                day = that.search.dtFm.getDate();

            switch (type) {
                case "current":
                    that.search.dtFm = that.search.dtTo = new Date();
                case "day":
                    that.search.dtTo = that.search.dtFm;
                    break;
                case "week":
                    that.search.dtFm = new Date(year, mth, day - weekday);
                    that.search.dtTo = new Date(year, mth, day + (6 - weekday));
                    break;
                case "month":
                    that.search.dtFm = new Date(year, mth, 1);
                    that.search.dtTo = new Date(year, mth + 1, 0);
                    break;
                case "pre":
                    if (that.dateType == 0) {
                        that.search.dtFm = that.search.dtTo = new Date(
                            year,
                            mth,
                            day - 1
                        );
                    } else if (that.dateType == 1) {
                        that.search.dtFm = new Date(
                            year,
                            mth,
                            day - weekday - 7
                        );
                        that.search.dtTo = new Date(
                            year,
                            mth,
                            day + (6 - weekday) - 7
                        );
                    } else {
                        that.search.dtFm = new Date(year, mth - 1, 1);
                        that.search.dtTo = new Date(year, mth - 2, 0);
                    }

                    break;
                case "next":
                    if (that.dateType == 0) {
                        that.search.dtFm = that.search.dtTo = new Date(
                            year,
                            mth,
                            day + 1
                        );
                    } else if (that.dateType == 1) {
                        that.search.dtFm = new Date(
                            year,
                            mth,
                            day - weekday + 7
                        );
                        that.search.dtTo = new Date(
                            year,
                            mth,
                            day + (6 - weekday) + 7
                        );
                    } else {
                        that.search.dtFm = new Date(year, mth + 1, 1);
                        that.search.dtTo = new Date(year, mth + 2, 0);
                    }
                    break;
            }
        },

        exportExcel() {},

        resizeTable() {
            let that = this,
                tableHeight =
                    that.$refs.content.clientHeight -
                    that.$refs.head.clientHeight -
                    24;

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

.recovery {
    display: flex;
    height: 100%;

    .left-content {
        width: 320px;
        min-width: 320px;
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

            // .date-type {
            //     // vertical-align: middle;
            // }
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