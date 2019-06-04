<template>
    <div class="diagnose">
        <div class="left-content">
            <div class="calendar-action">

                <span class="left-action">

                    <span class="ml-20 mr-10">处置日期</span>
                    <i
                        class="fa fa-arrow-circle-left mr-10 pre-mth"
                        @click.prevent.stop="switchDate('pre')"
                    ></i>

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
                <div class="date-range">
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
                </div>
                <div>
                    <div>
                        <label class="search-item">
                            <span class="label-text mr-10">患者分类</span>
                            <el-select
                                v-model="search.patient_type"
                                collapse-tags
                                class="search-input"
                            >
                                <el-option
                                    v-for="item in patientType"
                                    :key="item.id"
                                    :label="item.label"
                                    :value="item.id"
                                >
                                </el-option>
                            </el-select>
                        </label>
                    </div>
                    <div>
                        <label class="search-item">
                            <span class="label-text mr-10">就诊医生</span>
                            <el-select
                                v-model="search.doctor"
                                collapse-tags
                                class="search-input"
                            >
                                <el-option
                                    v-for="item in doctor"
                                    :key="item.id"
                                    :label="item.label"
                                    :value="item.id"
                                >
                                </el-option>
                            </el-select>
                        </label>
                    </div>
                    <div>
                        <label class="search-item">
                            <span class="label-text mr-10">患者查询</span>
                            <el-input
                                v-model="search.patient_info"
                                autocomplete="off"
                                class="input-text"
                                placeholder="患者、电话查询"
                            ></el-input>
                        </label>
                    </div>
                    <div>
                        <label class="search-item">
                            <span class="label-text mr-10">处置信息</span>
                            <el-input
                                v-model="search.disposal_info"
                                autocomplete="off"
                                class="input-text"
                                placeholder="名称、备注关键字查询"
                            ></el-input>
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
                    <el-radio-group
                        v-model="currentType"
                        @change="changeShow"
                    >
                        <el-radio-button label="diagnose">就诊</el-radio-button>
                        <el-radio-button label="returnVisit">回访</el-radio-button>
                        <el-radio-button label="monthlyCalendar">月历</el-radio-button>
                    </el-radio-group>
                </div>

                <div>
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
                </div>
            </div>

            <div class="diagnose-list">
                <div
                    class="diagnose-item is-current-day"
                    @dblclick.stop.prevent="addReturnDialog = true"
                >
                    <div class="diagnose-item-title">
                        <div>张飞</div>
                        <div>今天 &nbsp; 13:52</div>
                        <div>复诊</div>
                        <div>貂蝉</div>
                        <div>
                            <i
                                class="fa fa-comment-dots"
                                @click.stop.prevent=" addReturnDialog = true"
                            ></i>
                        </div>
                    </div>

                    <div class="diagnose-detail">
                        <div class="tooth">
                            <div class="tooth-row">
                                <div class="tooth-left">12345678</div>
                                <div class="tooth-right">12345678</div>
                            </div>
                            <div class="tooth-row">
                                <div class="tooth-left">123456789</div>
                                <div class="tooth-right">123456789</div>
                            </div>
                        </div>

                        <div class="detail">
                            <div class="detail-row">维生C片</div>
                            <div class="detail-row">口服一日三次</div>
                        </div>

                    </div>
                </div>

                <div
                    class="diagnose-item"
                    @dblclick.stop.prevent="addReturnDialog = true"
                >
                    <div class="diagnose-item-title">
                        <div>张飞</div>
                        <div>昨天 &nbsp; 13:52</div>
                        <div>复诊</div>
                        <div>貂蝉</div>
                        <div>
                            <i
                                class="fa fa-comment-dots"
                                @click.stop.prevent="addReturnDialog = true"
                            ></i>
                        </div>
                    </div>

                    <div class="diagnose-detail">
                        <div class="tooth">
                            <div class="tooth-row">
                                <div class="tooth-left">12345678</div>
                                <div class="tooth-right">12345678</div>
                            </div>
                            <div class="tooth-row">
                                <div class="tooth-left">123456789</div>
                                <div class="tooth-right">123456789</div>
                            </div>
                        </div>

                        <div class="detail">
                            <div class="detail-row">维生C片</div>
                            <div class="detail-row">口服一日三次</div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <add-return-visit
            :show.sync="addReturnDialog"
            @update="upateRetrunVisit"
        ></add-return-visit>
    </div>
</template>

<script>
import AddReturnVisit from "../patient/ReturnVisitInfo/AddReturnVisit";
import { formatDate } from "@common/util";
export default {
    name: "Diagnose",
    components: { AddReturnVisit },
    props: {},
    data() {
        return {
            dateType: 0,
            search: {
                dtFm: new Date(),
                dtTo: new Date(),
                doctor: null,
                patient_type: null,
                patient_info: "",
                disposal_info: ""
            },

            pager: false,

            doctor: [
                { id: 0, label: "小李" },
                { id: 1, label: "张三" },
                { id: 2, label: "小刘" }
            ],

            patientType: [
                { id: 0, label: "治疗" },
                { id: 1, label: "修复" },
                { id: 2, label: "种植" }
            ],

            currentType: "diagnose",

            // tableData: [],
            // tableHeight: "300px",

            dateFmText: "",
            dateToText: "",
            dateCount: 0,

            //当前的日期
            currentDate: null,

            isCurrentDate: false,

            addReturnDialog: false
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

        // that.$nextTick(() => {
        //     that.resizeTable();
        // });

        // //监听事件,由layout那边的resize抛出的
        // if (window.addEventListener) {
        //     window.addEventListener("bodyChange", that.resizeTable);
        // } else {
        //     window.attachEvent("bodyChange", that.resizeTable);
        // }
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

        getData() {},
        exportExcel() {},

        upateRetrunVisit() {
            let that = this;
        },

        changeShow(value) {
            let that = this;
            that.$emit("update:type", value);

            //原来的值不更新，直接替换页面
            setTimeout(() => {
                that.currentType = "diagnose";
            }, 300);
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

.diagnose {
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

                .input-text {
                    max-width: 220px;
                    font-size: 16px;
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

            .date-range {
                border-bottom: 1px solid #e3e3e3;
                margin-bottom: 10px;
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

        .diagnose-list {
            padding: 10px;

            .diagnose-item {
                border: 2px solid #e3e3e3;
                border-left-width: 10px;
                cursor: pointer;
                padding: 10px;
                box-sizing: border-box;
                color: #989797;
                margin-bottom: 10px;

                .transition-2;

                .diagnose-item-title {
                    > div {
                        display: inline-block;
                        width: 160px;
                        font-size: 18px;
                        font-weight: bolder;
                    }

                    i {
                        font-size: 22px;
                    }

                    i:hover {
                        color: @color;
                    }
                }

                .diagnose-detail {
                    display: flex;

                    .tooth {
                        width: 220px;

                        .tooth-row {
                            display: flex;
                            font-size: 16px;

                            &:not(:last-of-type) {
                                border-bottom: 2px solid #e3e3e3;
                                transition: border 0.2s;
                            }

                            &:last-of-type {
                                .tooth-left,
                                .tooth-right {
                                    padding-top: 6px;
                                }
                            }

                            > div {
                                flex: 1 auto;
                            }

                            .tooth-left {
                                border-right: 2px solid #e3e3e3;
                                text-align: right;
                                transition: border 0.2s;
                            }

                            .tooth-right {
                                padding: 0 0 6px 6px;
                            }

                            .tooth-left,
                            .tooth-right {
                                letter-spacing: 2px;
                            }
                        }
                    }
                }

                .detail,
                .tooth {
                    margin: 16px 20px 0 0;
                }

                //设置间隔
                .detail .detail-row:first-of-type,
                .tooth .tooth-row .tooth-left {
                    padding: 0 6px 6px 0;
                }

                //设置间隔
                .detail .detail-row:last-of-type,
                .tooth .tooth-row:last-of-type .tooth-left,
                .tooth .tooth-row:last-of-type .tooth-right {
                    padding-top: 6px;
                }

                //当天
                &.is-current-day {
                    border-color: #8c8c8c;
                    color: #777474;

                    .diagnose-detail {
                        .tooth {
                            .tooth-row {
                                &:not(:last-of-type) {
                                    border-color: #989797;
                                }

                                .tooth-left {
                                    border-color: #989797;
                                }
                            }
                        }
                    }
                }

                &:hover {
                    border-color: @color;
                    color: #484848;

                    .diagnose-detail {
                        .tooth {
                            .tooth-row {
                                &:not(:last-of-type) {
                                    border-color: #989797;
                                }

                                .tooth-left {
                                    border-color: #989797;
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
</style>