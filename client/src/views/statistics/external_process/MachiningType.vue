<template>
    <div
        class="charge-detail"
        ref="content"
    >
        <div
            class="action-bar"
            ref="search"
        >
            <div class="search-item">
                <span class="mr-10">送件日期</span>
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
                <span class="mr-10 ml-10">加工单位</span>
                <el-select
                    v-model="search.processingUnits"
                    placeholder=""
                    collapse-tags
                    class="processing-units"
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
                <el-button
                    type="primary"
                    @click="getData"
                >查询</el-button>
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
                    label="加工单位"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="加工内容"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="单价"
                    align="center"
                    show-overflow-tooltip
                >
                </el-table-column>
                <el-table-column
                    prop="address"
                    label="颗数"
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

            processingUnitsList: [
                { id: 0, label: "加工单位1" },
                { id: 1, label: "加工单位2" }
            ],

            search: {
                dateRange: [new Date(), new Date()],
                processingUnits: []
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
                    20;

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

    .processing-units {
        width: 160px;
    }
}
</style>