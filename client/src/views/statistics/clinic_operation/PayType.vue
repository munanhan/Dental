<template>
    <el-dialog
        title="收费方式"
        :visible.sync="show"
        :before-close="closeDialog"
        class="custom-dialog"
        :close-on-click-modal="false"
        v-dialog-drag
    >
        <div class="search">
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

            <span class="mr-10">收费时间</span>

            <span class="mr-10">
                <el-select
                    v-model="value"
                    placeholder="请选择支付方式"
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

            <span>
                <el-button type="primary" @click="getData">查询</el-button>
            </span>

        </div>
        <div>
            <table></table>
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
export default {
    name: "PayType",

    mixins: [ DialogForm ],

    components: {},
    props: {},
    data() {
        return {
            search: {
                dateRange: [new Date(), new Date()]
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
            }
        };
    },
    created() {},
    mounted() {
        let that = this;
        that.getDate();
    },
    watch: {},
    computed: {},
    methods: {
        getDate(){
            let that = this;


        }

    }
};
</script>
<style lang="less" scoped>
.pay-type {
    .search {
        padding: 10px;
        border-bottom: 1px solid #e3e3e3;
        height: 40px;
        width: 100%;
    }
}
</style>
