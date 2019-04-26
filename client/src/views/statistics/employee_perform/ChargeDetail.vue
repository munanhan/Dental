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
                <span class="mr-10 ml-10">人员类型</span>
                <el-select
                    v-model="search.personType"
                    placeholder=""
                    collapse-tags
                    class="person-type-select"
                    @change="changeType"
                >
                    <el-option
                        v-for="item in personType"
                        :key="item.id"
                        :label="item.label"
                        :value="item.id"
                    >
                    </el-option>
                </el-select>
            </div>

            <div class="search-item">
                <el-select
                    v-model="search.personSelect"
                    placeholder="人员名称"
                    multiple
                    collapse-tags
                    clearable
                >
                    <el-option
                        v-for="item in personList"
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

            personType: [
                { id: 0, label: "医生" },
                { id: 1, label: "护士" },
                { id: 2, label: "咨询师" }
            ],

            personList: [
                { id: 0, label: "张三" },
                { id: 1, label: "李四" },
                { id: 2, label: "王三" }
            ],

            doctorColumn: [
                {
                    label: "日期",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "医生",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "总收入",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "西药费",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "放射费",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "检查费",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "诊疗费",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "补牙费",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "手术费",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "正畸费",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "修复费",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "其他",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                }
            ],

            nurseColumn: [
                {
                    label: "日期",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "护士",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "总收入",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "西药费",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "放射费",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "检查费",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "诊疗费",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "补牙费",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "手术费",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "正畸费",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "修复费",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "其他",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                }
            ],

            counselorColumn: [
                {
                    label: "日期",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "咨询师",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "总收入",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "西药费",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "放射费",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "检查费",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "诊疗费",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "补牙费",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "手术费",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "正畸费",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "修复费",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                },
                {
                    label: "其他",
                    field: "dd",
                    align: "center",
                    width: null,
                    formatter: null
                }
            ],

            tableColumns: [],

            search: {
                dateRange: [new Date(), new Date()],
                personType: 0,
                personSelect: []
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
        changeType(value) {
            let that = this;

            switch (value) {
                case 0:
                    that.tableColumns = that.doctorColumn;
                    break;
                case 1:
                    that.tableColumns = that.nurseColumn;
                    break;
                case 2:
                    that.tableColumns = that.counselorColumn;
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
.charge-detail {
    padding: 10px;
    height: 100%;
    box-sizing: border-box;

    .person-type-select {
        width: 100px;
    }
}
</style>