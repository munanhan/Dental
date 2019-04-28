<template>
    <div
        class="charge-detail"
        ref="content"
    >
        <div
            class="action-bar"
            ref="search"
        >
            <div>
                <div class="search-item">
                    <el-checkbox
                        v-model="search.returnPiece"
                        :true-label="1"
                        :false-label="0"
                    >回件时间</el-checkbox>
                    <el-date-picker
                        v-model="search.dateRangeReturn"
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
                    <span class="mr-10 ml-10 label-text">加工单位</span>
                    <el-select
                        v-model="search.processingUnits"
                        placeholder=""
                        collapse-tags
                        class="search-second"
                        @change="changeType"
                    >
                        <el-option
                            v-for="item in processingUnitsList"
                            :key="item.id"
                            :label="item.label"
                            :value="item.id"
                        >
                        </el-option>
                    </el-select>
                </div>

                <div class="search-item">
                    <span class="mr-10 ml-10 label-text">医生</span>
                    <el-select
                        v-model="search.doctor"
                        placeholder=""
                        collapse-tags
                        class="search-thirds"
                        @change="changeType"
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
                        class="search-btn"
                    >查询</el-button>
                </div>
            </div>

            <div>
                <div class="search-item">
                    <el-checkbox
                        v-model="search.deliveryTime"
                        :true-label="1"
                        :false-label="0"
                    >送件时间</el-checkbox>
                    <el-date-picker
                        v-model="search.dateRangeDelive"
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
                    <span class="mr-10 ml-10 label-text">患者信息</span>
                    <el-input
                        v-model="search.patientInfo"
                        autocomplete="off"
                        placeholder="患者信息"
                        class="search-second"
                    ></el-input>
                </div>

                <div class="search-item">
                    <span class="mr-10 ml-10 label-text">加工状态</span>
                    <el-select
                        v-model="search.processingState"
                        placeholder=""
                        collapse-tags
                        class="search-thirds"
                    >
                        <el-option
                            v-for="item in processingStateList"
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
                        @click="exportExcel"
                        class="search-btn"
                    >导出Excel</el-button>
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
                    label="状态"
                    align="center"
                    show-overflow-tooltip
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
                    label="患者姓名"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="电话"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="加工单位"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="加工单号"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="取件人"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="送件时间"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="回件时间"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>

                <el-table-column
                    prop="address"
                    label="加工颗数"
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
                <el-table-column
                    prop="address"
                    label="加工厂价"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="加工金额"
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
        </el-row>

        <el-row>
            <div>加工明细</div>

            <el-table
                border
                class="width100 mb-10 details-table"
                :data="tableDetailData"
                :header-cell-style="{backgroundColor:'#e3e3e3',color:'#3a3a3a'}"
                :height="200"
            >
                <el-table-column
                    prop="address"
                    label="牙位"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="加工类型"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="色号"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
            </el-table>
        </el-row>

    </div>
</template>

<script>
export default {
    name: "ChargeDetail",
    components: {},
    props: {
        update: {
            type: Boolean,
            required: true
        }
    },
    data() {
        return {
            tableHeight: 300,

            tableData: [],
            tableDetailData: [],

            doctorList: [
                { id: 0, label: "张三" },
                { id: 1, label: "李四" },
                { id: 2, label: "王三" }
            ],

            processingUnitsList: [
                { id: 0, label: "加工单位1" },
                { id: 1, label: "加工单位2" }
            ],

            processingStateList: [
                { id: 0, label: "加工状态1" },
                { id: 1, label: "加工状态2" }
            ],

            search: {
                dateRangeReturn: [new Date(), new Date()],
                dateRangeDelive: [new Date(), new Date()],
                returnPiece: 1,
                processingUnits: [],
                doctor: [],
                deliveryTime: 0,
                patientInfo: "",
                processingState: []
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
    created() {
        let that = this;
        that.tableColumns = that.doctorColumn;
    },
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
        update(newValue, oldValue) {
            let that = this;
            if (newValue) {
                that.resizeTable();

                that.$emit("update:update", false);
            }
        }
    },
    computed: {},
    methods: {

        resizeTable() {
            let that = this,
                tableHeight =
                    that.$refs.content.clientHeight -
                    that.$refs.search.clientHeight -
                    250;

            that.tableHeight = tableHeight;
        },

        getData() {
            let that = this;
        },

        exportExcel() {}
    }
};
</script>
<style lang="less" scoped>
.charge-detail {
    padding: 10px;
    height: 100%;
    box-sizing: border-box;

    .search-second {
        width: 150px;
    }

    .search-thirds {
        width: 120px;
    }

    .label-text {
        width: 70px;
        display: inline-block;
        text-align: right;
    }

    .search-btn {
        width: 100px;
    }
}
</style>