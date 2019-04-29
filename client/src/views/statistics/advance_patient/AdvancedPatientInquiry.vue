<template>
    <div
        class="advanced-patient"
        ref="content"
    >
        <div
            class="action-bar"
            ref="search"
        >
            <div>
                <div class="search-item">
                    <el-checkbox
                        v-model="search.furthers"
                        :true-label="1"
                        :false-label="0"
                    ></el-checkbox>
                    <span class="mr-10">复诊时间</span>
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
                </div>

                <div class="search-item">
                    <el-select
                        v-model="search.selectType"
                        placeholder=""
                        collapse-tags
                        class="select-type"
                        @change="changeType"
                    >
                        <el-option
                            v-for="item in selectTypeList"
                            :key="item.id"
                            :label="item.label"
                            :value="item.id"
                        >
                        </el-option>
                    </el-select>
                    <el-input
                        v-model.trim="search.tvalue"
                        :placeholder="selectInputText"
                        auto-complete="off"
                        class="select-input-value"
                    ></el-input>
                </div>

                <div class="search-item">
                    <span class="mr-10 ml-10">患者分类</span>
                    <el-select
                        v-model="search.patientType"
                        placeholder=""
                        collapse-tags
                        class="patient-type"
                    >
                        <el-option
                            v-for="item in patientTypeList"
                            :key="item.id"
                            :label="item.label"
                            :value="item.id"
                        >
                        </el-option>
                    </el-select>
                </div>
                <div class="search-item">
                    <el-checkbox
                        v-model="search.hasWebchat"
                        :true-label="1"
                        :false-label="0"
                    >有微信</el-checkbox>
                </div>
            </div>

            <div>
                <div class="search-item">
                    <span class="mr-10">联系地址</span>
                    <el-input
                        v-model.trim="search.contactAddress"
                        placeholder="联系地址"
                        auto-complete="off"
                        class="contact-address"
                    ></el-input>
                </div>
                <div class="search-item">
                    <span class="mr-10 patient-rank">患者会员等级</span>
                    <el-select
                        v-model="search.patientRank"
                        placeholder=""
                        collapse-tags
                        class="patient-rank-list"
                    >
                        <el-option
                            v-for="item in patientRankList"
                            :key="item.id"
                            :label="item.label"
                            :value="item.id"
                        >
                        </el-option>
                    </el-select>
                </div>

                <div class="search-item">
                    <span class="mr-10 ml-10">复诊医生</span>
                    <el-select
                        v-model="search.doctor"
                        placeholder=""
                        collapse-tags
                        class="patient-type"
                        clearable
                    >
                        <el-option
                            v-for="item in doctorList"
                            :key="item.id"
                            :label="item.label"
                            :value="item.id"
                        >
                        </el-option>
                    </el-select>
                </div>

                <div class="search-item">
                    <el-button
                        type="primary"
                        @click="getData"
                    >查询</el-button>
                </div>
            </div>

        </div>

        <el-row>
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
                    label="病历号"
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
                    label="年龄"
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
                    label="复诊医生"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="患者来源"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="就诊时间"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="消费总金额"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="当前欠费"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="微信"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="地址"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="会员等级"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="会员卡号"
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
                    prop="address"
                    label="介绍人"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
            </el-table>
            <span>总计： 欠款金额 0.00； 消费金额：0.00</span>
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

    </div>
</template>

<script>
import Base from "../Base";

export default {
    name: "AdvancedPatientInquiry",
    components: {},

    mixins: [Base],

    props: {
        refresh: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            tableHeight: 300,

            tableData: [],

            selectInputText: "患者姓名/电话号码",
            selectTypeList: [
                { id: 0, label: "患者信息" },
                { id: 1, label: "病历号" },
                { id: 2, label: "会员号" },
                { id: 3, label: "介绍人" }
            ],

            patientTypeList: [
                { id: 0, label: "全部" },
                { id: 1, label: "治疗" },
                { id: 2, label: "修复" },
                { id: 3, label: "种植" },
                { id: 4, label: "正畸" },
                { id: 5, label: "检查" },
                { id: 6, label: "洗牙" },
                { id: 7, label: "其他" }
            ],

            patientRankList: [
                { id: 0, label: "普通会员" },
                { id: 1, label: "黄金会员" },
                { id: 2, label: "铂金会员" }
            ],

            doctorList: [{ id: 0, label: "张三" }, { id: 1, label: "李四" }],

            search: {
                furthers: 0,
                dateRange: [new Date(), new Date()],
                selectType: 0,
                tvalue: "",
                patientType: 0,
                hasWebchat: 0,
                contactAddress: "",
                patientRank: 0,
                doctor: []
            },

            pager: {
                total: 0,
                current: 1,
                size: 50
            },

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
    watch: {
        refresh(newValue, oldValue) {
            let that = this;

            if (newValue) {
                that.resizeTable();
            }
        }
    },
    computed: {},
    methods: {
        changeType(value) {
            let that = this;

            switch (value) {
                case 0:
                    that.selectInputText = "患者姓名/电话号码";
                    break;
                case 1:
                    that.selectInputText = "病历号";
                    break;
                case 2:
                    that.selectInputText = "会员号";
                    break;
                case 3:
                    that.selectInputText = "介绍人";
                    break;
            }
        },

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

        resizeTable() {
            let that = this,
                tableHeight =
                    that.$refs.content.clientHeight -
                    that.$refs.search.clientHeight -
                    80;

            that.tableHeight = tableHeight;
        },

        afterGetData(res) {
            let that = this;

            that.tableData = res.data;
        }
    }
};
</script>
<style lang="less" scoped>
.advanced-patient {
    padding: 10px;
    height: 100%;
    box-sizing: border-box;

    .search-item {
        /deep/ .el-checkbox {
            margin-right: 10px;
        }
    }

    .select-type {
        width: 120px;
        margin-right: 10px;
    }

    .select-input-value {
        width: 160px;
    }

    .patient-type,
    .patient-level {
        width: 120px;
    }

    .patient-rank {
        display: inline-block;
        text-align: right;
        margin-left: 24px;
    }

    .patient-rank-list {
        width: 160px;
    }

    .contact-address {
        margin-left: 23px;
        width: 351px;
    }
}
</style>