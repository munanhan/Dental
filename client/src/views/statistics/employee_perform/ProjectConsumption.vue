<template>
    <div
        class="project-consumption"
        ref="content"
    >
        <div
            class="action-bar"
            ref="search"
        >
            <div class="search-item">
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
                <el-checkbox
                    v-model="search.totalDoctor"
                    :true-label="1"
                    :false-label="0"
                    @change="changTable"
                >按医生统计</el-checkbox>
                <el-select
                    v-model="search.doctor"
                    placeholder="人员名称"
                    multiple
                    clearable
                    collapse-tags
                    class="doctor-list"
                >
                    <el-option
                        v-for="item in doctor"
                        :key="item.id"
                        :label="item.label"
                        :value="item.id"
                    >
                    </el-option>
                </el-select>
            </div>

            <div class="search-item">
                <el-input
                    v-model.trim="search.dim"
                    placeholder="处置名称/处置编号"
                    auto-complete="off"
                ></el-input>
            </div>

            <div class="search-item">
                <el-button
                    type="primary"
                    @click="getData"
                >查询</el-button>
            </div>

            <div class="action-bar-right">
                <el-button
                    type="primary"
                    @click="exportExcel"
                >导出Excel</el-button>
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
                    v-for="(item, index) in tableColumns"
                    :key="index"
                    :label="item.label"
                    :width="item.width"
                    :align="item.align"
                    :prop="item.prop"
                    :formatter="item.formatter"
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

    </div>
</template>

<script>
export default {
    name: "ProjectConsumption",
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

            doctor: [{ id: 0, label: "张三" }, { id: 1, label: "小李" }],

            chargeColumn: [
                {
                    label: "发生日期",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "经手人",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "负责人",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "支出类别",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "支出明细",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "支出金额",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "付款方式",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "备注",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                }
            ],

            doctorColumn: [
                {
                    label: "医生",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "发生日期",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "经手人",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "负责人",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "支出类别",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "支出明细",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "支出金额",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "付款方式",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "备注",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                }
            ],

            tableColumns: [],

            search: {
                dateRange: [new Date(), new Date()],
                totalDoctor: 0,
                doctor: [],
                dim: ""
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
        that.tableColumns = that.chargeColumn;
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
        },

    },
    computed: {},
    methods: {
        changTable(value) {
            let that = this;
            if (value == 0) {
                that.tableColumns = that.chargeColumn;
            } else {
                that.tableColumns = that.doctorColumn;
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
                    70;

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
.project-consumption {
    padding: 10px;
    height: 100%;
    box-sizing: border-box;

    .doctor-list {
        width: 160px;
    }
}
</style>