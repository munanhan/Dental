<template>
    <div class="expenditure">
        <div class="left-content">
            <div class="calendar-action">

                <span class="left-action">

                    <span class="ml-20 mr-10">发生日期</span>
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
                            v-model="search.dtfm"
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
                            v-model="search.dtto"
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
                <div>
                    <label class="search-item">
                        <span class="label-text mr-10">支出类型</span>
                        <el-select
                            v-model="search.expenditure_type"
                            collapse-tags
                            class="search-input"
                        >
                            <el-option
                                v-for="item in payType"
                                :key="item.id"
                                :label="item.expenditure_type"
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
                        @click="addDialog = true"
                    >新增支出</el-button>
                </span>
            </div>

            <div class="pay-table">
                <el-table
                    border
                    class="width100"
                    :data="tableData"
                    :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                    :height="tableHeight"
                    show-summary
                >
                    <!-- <el-table-column
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
                    </el-table-column> -->
                    <el-table-column
                        prop="date"
                        label="发生日期"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="handler"
                        label="经手人"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="charge_person"
                        label="负责人"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="expenditure_type"
                        label="支出类别"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="expenditure_content"
                        label="支出明细"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="expenditure_money"
                        label="支出金额"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="expenditure_method"
                        label="付款方式"
                        align="center"
                        show-overflow-tooltip
                    >
                    </el-table-column>
                    <el-table-column
                        prop="remark"
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
                                    @click.stop="showEdit(scope.row,scope.$index)"
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
                                    @click.stop="showDel(scope.row, scope.$index)"
                                ></el-button>
                            </el-tooltip>
                        </template>
                    </el-table-column>
                </el-table>
            </div>
        </div>

        <add-expenditure :show.sync="addDialog" @add-item="addItem"></add-expenditure>
        <edit-expenditure :show.sync="editDialog" :editItem="editData" @edit-item="updateItem"></edit-expenditure>
    </div>
</template>

<script>
import { formatDate } from "@common/util";
import AddExpenditure from './AddExpenditure';
import EditExpenditure from './EditExpenditure';
import Base from "../base/TableBase";
import { setCookie,getCookie,downloadFile } from "../../common/util";

export default {
    name: "Expenditure",
    mixins: [Base],

    components: {AddExpenditure, EditExpenditure},
    props: {},
    data() {
        return {
            dateType: 'expenditure',
            search: {
                dtfm: new Date(),
                dtto: new Date(),
                expenditure_type: undefined
            },

            pager: false,

            payType: [

            ],
            tableData:[],
            editData:{},
            // tableData: [],
            // tableHeight: "300px",

            dateFmText: "",
            dateToText: "",
            dateCount: 0,

            //当前的日期
            currentDate: null,

            isCurrentDate: false,

            //当前页面索引
            index: undefined,
            //当前行
            selectRow: {},

            // addPayDialog: false
        };
    },
    created() {},
    mounted() {
        let that = this;

        //设置当前的日期
        that.currentDate = formatDate(new Date(), "yyyy-MM-dd");
        that.dateFmText = formatDate(that.search.dtfm, "yyyy年MM月dd日");
        that.dateToText = formatDate(that.search.dtto, "yyyy年MM月dd日");

        that.checkCurrentData();
        that.calcDateCount();
        that.expenditureType();

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
        "search.dtfm": {
            handler(newValue, oldValue) {
                let that = this;
                that.dateFmText = formatDate(newValue, "yyyy年MM月dd日");

                that.calcDateCount();
                that.checkCurrentData();
            }
        },

        "search.dtto": {
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
                formatDate(that.search.dtfm, "yyyy-MM-dd") ==
                    that.currentDate &&
                formatDate(that.search.dtto, "yyyy-MM-dd") == that.currentDate;
        },

        calcDateCount() {
            let that = this,
                startTime = new Date(that.search.dtfm).getTime(),
                endTime = new Date(that.search.dtto).getTime(),
                count = Math.round((endTime - startTime) / 86400000) + 1;

            that.dateCount = count;
        },

        //如果开始和结束的时间相减是负责则同步两边的值
        changeData(type) {
            let that = this,
                startTime = new Date(that.search.dtfm).getTime(),
                endTime = new Date(that.search.dtto).getTime(),
                minus = endTime - startTime;

            if (minus < 0) {
                if (type == "fm") {
                    that.search.dtto = that.search.dtfm;
                } else if (type == "to") {
                    that.search.dtfm = that.search.dtto;
                }
            }
        },

        switchDate(type) {
            let that = this;

            that.search.dtfm = new Date(that.search.dtfm);

            let year = that.search.dtfm.getFullYear(),
                mth = that.search.dtfm.getMonth(),
                weekday = that.search.dtfm.getDay(),
                day = that.search.dtfm.getDate();

            switch (type) {
                case "current":
                    that.search.dtfm = that.search.dtto = new Date();
                case "day":
                    that.search.dtto = that.search.dtfm;
                    break;
                case "week":
                    that.search.dtfm = new Date(year, mth, day - weekday);
                    that.search.dtto = new Date(year, mth, day + (6 - weekday));
                    break;
                case "month":
                    that.search.dtfm = new Date(year, mth, 1);
                    that.search.dtto = new Date(year, mth + 1, 0);
                    break;
                case "pre":
                    if (that.dateType == 0) {
                        that.search.dtfm = that.search.dtto = new Date(
                            year,
                            mth,
                            day - 1
                        );
                    } else if (that.dateType == 1) {
                        that.search.dtfm = new Date(
                            year,
                            mth,
                            day - weekday - 7
                        );
                        that.search.dtto = new Date(
                            year,
                            mth,
                            day + (6 - weekday) - 7
                        );
                    } else {
                        that.search.dtfm = new Date(year, mth - 1, 1);
                        that.search.dtto = new Date(year, mth - 2, 0);
                    }

                    break;
                case "next":
                    if (that.dateType == 0) {
                        that.search.dtfm = that.search.dtto = new Date(
                            year,
                            mth,
                            day + 1
                        );
                    } else if (that.dateType == 1) {
                        that.search.dtfm = new Date(
                            year,
                            mth,
                            day - weekday + 7
                        );
                        that.search.dtto = new Date(
                            year,
                            mth,
                            day + (6 - weekday) + 7
                        );
                    } else {
                        that.search.dtfm = new Date(year, mth + 1, 1);
                        that.search.dtto = new Date(year, mth + 2, 0);
                    }
                    break;
            }
        },

        exportExcel() {
            let that = this;
            let dtfm = typeof that.search.dtfm == 'object'?
                                that.search.dtfm.toLocaleDateString():
                                that.search.dtfm;

            let dtto = typeof that.search.dtto == 'object'?
                                that.search.dtto.toLocaleDateString():
                                that.search.dtto;

            let expenditure_type = that.search.expenditure_type == undefined?'':
                                   that.search.expenditure_type;

            let url = (window.HOSTNAME || '')+'/api/expenditure/export?dtfm='+dtfm+'&dtto='+dtto+'&expenditure_type='+expenditure_type;
            let token = getCookie("token");
            console.log(url);
            downloadFile(url,{'Authorization':token},'支出清单');
        },

        expenditureType(){
            //支出类型
            let that = this;
            that.$api.expenditure_type.get()
                .then(res => {
                  if(res.code == 200){
                        that.payType = res.data;

                   }
                   else{
                       that.$message.error(
                            res.msg || "edit error."
                        );
                   }
                })
                .catch(res => {
                   // console.log(res);
                });
        },
        getData(){
            //获取数据
            let that = this;
            that.search.dtfm = typeof that.search.dtfm == 'object'?
                                that.search.dtfm.toLocaleDateString():
                                that.search.dtfm;

            that.search.dtto = typeof that.search.dtto == 'object'?
                                that.search.dtto.toLocaleDateString():
                                that.search.dtto;

            that.$api.expenditure.get(that.search)
                .then(res => {
                  if(res.code == 200){
                        that.tableData = res.data;

                   }
                   else{
                       that.$message.error(
                            res.msg || "edit error."
                        );
                   }
                })
                .catch(res => {
                   // console.log(res);
                });

        },
        addItem(data){
            let that = this;
            let date = new Date(data.date.replace("-","/")).toLocaleDateString();
            let dtfm = typeof that.search.dtfm == 'object'?
                                that.search.dtfm.toLocaleDateString():
                                that.search.dtfm;

            let dtto = typeof that.search.dtto == 'object'?
                                that.search.dtto.toLocaleDateString():
                                that.search.dtto;
            if (date >= dtfm && date <= dtto) {
                that.tableData.push(data);
            }

        },
        showDel(row,idx){
            let that = this;
              that.$confirm('删除不可恢复，是否确定删除？', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
              }).then(() => {
                that.del(row.id,idx);
              }).catch(() => {
                that.$message({
                  type: 'info',
                  message: '已取消删除'
                });          
              });
        },
        del(id,index){
            let that = this;
            that.$api.expenditure.del({id})
                .then(res => {
                    if (res.code == 200) {
                        that.$message({
                            message: res.msg,
                            type: "success",
                            duration: 800
                        });
                        //删除
                        that.tableData.splice(index, 1);
                    } else {
                        that.$message.error(res.msg || "删除失败.");
                    }
                })
                .catch(res => {
                    that.$message.error("删除失败.");
                });
        },
        showEdit(row,index){
            let that = this;
            let parms = {};
            parms.id = row.id;
            that.index = index;
            that.selectRow = row;
            that.$api.expenditure.getById(parms)
                .then(res => {
                    if (res.code == 200) {
                        // that.$message({
                        //     message: res.msg,
                        //     type: "success",
                        //     duration: 800
                        // });
                        that.editData = res.data;
                        that.editDialog = true;
                        
                    } else {
                        that.$message.error(res.msg || "获取失败.");
                    }
                })
                .catch(res => {
                    that.$message.error("获取失败.");
                });

        },
        updateItem(data){
            let that = this;
            that.$set(that.tableData,that.index,data);
        },

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

.expenditure {
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