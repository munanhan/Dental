<template>
    <el-dialog
        title="收费单流水"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog toll-sheet"
        :close-on-click-modal="false"
        v-dialog-drag
        width="1200px"
        top="2vh"
    >
        <div class="action-bar">
            <div class="search-item">
                <span class="mr-10">单据时间</span>
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

            <div class="action-bar-right">
                <div>
                    <el-button
                        type="primary"
                        @click="exportExcel"
                    >导出Excel</el-button>
                </div>

            </div>
        </div>
        <el-row>

            <el-table
                border
                class="width100 mb-10 pay-table"
                :data="tableData"
                :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                show-summary
            >
                <el-table-column
                    label="单据时间"
                    width="120"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="name"
                    label="病历号"
                    width="120"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="患者姓名"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="单据状态"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="单据编号"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="类型"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="应收"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="实收"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="收银员"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="医生"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
            </el-table>
        </el-row>

        <el-row
            class="pager"
            type="flex"
            justify="end"
        >
            <el-pagination
                @current-change="changePage"
                @size-change="pageSizeChange"
                background
                layout="total, sizes, prev, pager, next, jumper"
                :page-sizes="[10, 20, 50, 100, 200]"
                :page-size="pager.size"
                :total="pager.total"
                :current-page="pager.current"
            ></el-pagination>
        </el-row>
        <div
            slot="footer"
            class="dialog-footer"
        >
            <el-button @click="closeDialog">关闭</el-button>
        </div>
    </el-dialog>
</template>

<script>
import DialogForm from "../../base/DialogForm";
import { getYesterday, getCurWeek, getCurMonth } from "@common/util";
export default {
    name: "PayType",

    mixins: [DialogForm],

    data() {
        return {
            pager: {
                total: 0,
                current: 1,
                size: 200
            },

            search: {
                dateRange: [new Date(), new Date()],
                type: 0
            },

            payType: [
                { label: "现金", value: 0 },
                { label: "银行卡", value: 1 },
                { label: "社保卡", value: 2 },
                { label: "微信支付", value: 3 },
                { label: "支付宝支付", value: 4 }
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

            tableData: []
        };
    },
    mounted() {
        let that = this;
        that.getData();
    },
    methods: {
        changePage(index) {
            let that = this;

            if (that.pager) {
                that.pager.current = index;
                that.getData();
            }
        },

        pageSizeChange(val) {
            let that = this;

            if (that.pager) {
                that.pager.size = val;
                that.getData();
            }
        },

        getData() {
            let that = this;
        },

        exportExcel() {}
    }
};
</script>
<style lang="less" scoped>
.toll-sheet {
    .pay-table {
        min-height: 300px;
    }
}
</style>
