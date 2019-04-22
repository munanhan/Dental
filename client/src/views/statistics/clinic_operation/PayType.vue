<template>
    <el-dialog
        title="收费方式"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog pay-type"
        :close-on-click-modal="false"
        v-dialog-drag
        width="1200px"
        top="2vh"
    >

        <div class="action-bar">
            <div class="search-item">
                <span class="mr-10">收费时间</span>
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
            </div>

            <div class="search-item">
                <span class="mr-10">收费时间</span>

                <span class="mr-10">
                    <el-select
                        v-model="search.type"
                        placeholder="请选择支付方式"
                        class="pay-select"
                    >
                        <el-option
                            v-for="item in payType"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                        >
                        </el-option>
                    </el-select>
                </span>
            </div>

            <el-button
                type="primary"
                @click="getData"
            >查询</el-button>

        </div>
        <div>
            <el-table
                border
                class="width100 mb-10 pay-table"
                :data="tableData"
                :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                show-summary
            >
                <el-table-column
                    label="收费时间"
                    width="120"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="name"
                    label="单据号"
                    width="120"
                    align="center"
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="病历号"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="性别"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="电话1"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="电话2"
                    align="center"
                    show-overflow-tooltip
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
                    label="收费金额"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="收费方式"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="收款员"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
            </el-table>
        </div>
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
        getData() {
            let that = this;
        }
    }
};
</script>
<style lang="less" scoped>
.pay-type {
    .pay-select {
        width: 130px;
    }

    .pay-table {
        min-height: 300px;
    }
}
</style>
